<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: header_php.php 744 2004-12-09 05:47:31Z ajeh $
//


// check to see if we're upgrading
$is_upgrade = $_GET['is_upgrade'];

  $zc_install->error = false;
  $zc_install->fatal_error = false;
  $zc_install->error_list = array();

  if (isset($_POST['submit'])) {
    if ($_POST['db_type'] != 'mysql') $_POST['db_prefix'] = '';  // if not using mysql, don't support prefixes
    if ($_POST['db_sess'] != 'true' || $_POST['cache_type'] == 'file') {  //if not storing sessions in database, or if caching to file, check folder
      $zc_install->isEmpty($_POST['sql_cache_dir'],  ERROR_TEXT_CACHE_DIR_ISEMPTY, ERROR_CODE_CACHE_DIR_ISEMPTY);
      $zc_install->isDir($_POST['sql_cache_dir'],  ERROR_TEXT_CACHE_DIR_ISDIR, ERROR_CODE_CACHE_DIR_ISDIR);
      $zc_install->isWriteable($_POST['sql_cache_dir'],  ERROR_TEXT_CACHE_DIR_ISWRITEABLE, ERROR_CODE_CACHE_DIR_ISWRITEABLE);
    }
    $zc_install->isEmpty($_POST['db_host'], ERROR_TEXT_DB_HOST_ISEMPTY, ERROR_CODE_DB_HOST_ISEMPTY);
    $zc_install->isEmpty($_POST['db_username'], ERROR_TEXT_DB_USERNAME_ISEMPTY, ERROR_CODE_DB_USERNAME_ISEMPTY);
    $zc_install->isEmpty($_POST['db_name'], ERROR_TEXT_DB_NAME_ISEMPTY, ERROR_CODE_DB_NAME_ISEMPTY);
    $zc_install->fileExists($_POST['db_type'] . '_zencart.sql', ERROR_TEXT_DB_SQL_NOTEXIST, ERROR_CODE_DB_SQL_NOTEXIST);
    $zc_install->functionExists($_POST['db_type'], ERROR_TEXT_DB_NOTSUPPORTED, ERROR_CODE_DB_NOTSUPPORTED);
    $zc_install->dbConnect($_POST['db_type'], $_POST['db_host'], $_POST['db_name'], $_POST['db_username'], $_POST['db_pass'], ERROR_TEXT_DB_CONNECTION_FAILED, ERROR_CODE_DB_CONNECTION_FAILED,ERROR_TEXT_DB_NOTEXIST, ERROR_CODE_DB_NOTEXIST);
    $zc_install->dbExists(false, $_POST['db_type'], $_POST['db_host'], $_POST['db_username'], $_POST['db_pass'], $_POST['db_name'], ERROR_TEXT_DB_NOTEXIST, ERROR_CODE_DB_NOTEXIST);

    if (!$zc_install->fatal_error) {
      require('../includes/classes/db/' . $_POST['db_type'] . '/query_factory.php');
//      require('lib/db.func.php');
      if ($_POST['db_sess'] == 'true') {
        $_POST['db_sess'] = 'db';
      } else {
        $_POST['db_sess'] = '';
      }
      $virtual_http_path = parse_url($_GET['virtual_http_path']);
      $http_server = $virtual_http_path['scheme'] . '://' . $virtual_http_path['host'];
      $http_catalog = $virtual_http_path['path'];
      if (isset($virtual_http_path['port']) && !empty($virtual_http_path['port'])) {
        $http_server .= ':' . $virtual_http_path['port'];
      }
      if (substr($http_catalog, -1) != '/') {
        $http_catalog .= '/';
      }
      $sql_cache_dir = $_GET['sql_cache_dir'];
      $cache_type = $_GET['cache_type'];
      $https_server = $_GET['virtual_https_server'];
      $https_catalog = $_GET['virtual_https_path'];
      $https_catalog_path = ereg_replace($https_server,'',$https_catalog) . '/';
      $https_catalog = $https_catalog_path;

      //now let's write the files
      // Catalog version first:
      require('includes/store_configure.php');
      $fp = fopen($_GET['physical_path'] . '/includes/configure.php', 'w');
      fputs($fp, $file_contents);
      fclose($fp);
      @chmod($_GET['physical_path'] . '/includes/configure.php', 0644);
      // now Admin version:
      require('includes/admin_configure.php');
      $fp = fopen($_GET['physical_path'] . '/admin/includes/configure.php', 'w');
      fputs($fp, $file_contents);
      fclose($fp);
      @chmod($_GET['physical_path'] . '/admin/includes/configure.php', 0644);

      if ($is_upgrade) { //if upgrading, move onto the upgrade page
         //update the cache folder setting:
         $db = new queryFactory;
         $db->Connect($_POST['db_host'], $_POST['db_username'], $_POST['db_pass'], $_POST['db_name'], true);
         $sql = "update ".$_POST['db_prefix']."configuration set configuration_value='".$_POST['sql_cache_dir']."' where configuration_key='SESSION_WRITE_DIRECTORY'";
         $db->Execute($sql);
         //update the phpbb setting:
         $sql = "update ".$_POST['db_prefix']."configuration set configuration_value='".$_GET['use_phpbb']."' where configuration_key='PHPBB_LINKS_ENABLED'";
         $db->Execute($sql);

         header('location: index.php?main_page=database_upgrade&language=' . $language);
         exit;
      } else { // not upgrading - load the fresh database
         //OK, files written -- now let's connect to the database and load the tables:
         $db = new queryFactory;
         $db->Connect($_POST['db_host'], $_POST['db_username'], $_POST['db_pass'], $_POST['db_name'], true);
         executeSql($_POST['db_type'] . '_zencart.sql', $_POST['db_name'], $_POST['db_prefix']);

         //update the cache folder setting:
         $sql = "update ".$_POST['db_prefix']."configuration set configuration_value='".$_POST['sql_cache_dir']."' where configuration_key='SESSION_WRITE_DIRECTORY'";
         $db->Execute($sql);
         //update the phpbb setting:
         $sql = "update ".$_POST['db_prefix']."configuration set configuration_value='".$_GET['use_phpbb']."' where configuration_key='PHPBB_LINKS_ENABLED'";
         $db->Execute($sql);

         $db->Close();
         // done - now onto next page for Store Setup (entries into database)
         header('location: index.php?main_page=store_setup&language=' . $language);
         exit;
      } //endif $is_upgrade
    }
  }

if ($is_upgrade) { // read previous settings from configure.php
   $zdb_type       = zen_read_config_value('DB_TYPE');
   $zdb_prefix     = zen_read_config_value('DB_PREFIX');
   $zdb_server     = zen_read_config_value('DB_SERVER');
   $zdb_user       = zen_read_config_value('DB_SERVER_USERNAME');
   $zdb_pwd        = zen_read_config_value('DB_SERVER_PASSWORD');
   $zdb_name       = zen_read_config_value('DB_DATABASE');
   $zdb_sql_cache  = ($_GET['sql_cache']=='') ? zen_read_config_value('DIR_FS_SQL_CACHE') : $_GET['sql_cache'];
   $zdb_cache_type = zen_read_config_value('SQL_CACHE_METHOD');
   $zdb_persistent = zen_read_config_value('USE_PCONNECT');
   $zdb_sessions   = (zen_read_config_value('STORE_SESSIONS')) ? 'true' : 'false';

  } else { // set defaults:
   $zdb_type       = 'MySQL';
   $zdb_prefix     = '';
   $zdb_server     = 'localhost';
   $zdb_user       = 'root';
   $zdb_name       = 'zencart';
   $zdb_sql_cache  = $_GET['sql_cache'];
   $zdb_cache_type = 'None';
   $zdb_persistent = 'false';
   $zdb_sessions   = 'true';
 } //endif $is_upgrade

  if (!isset($_POST['db_host']))     $_POST['db_host']    = $zdb_server;
  if (!isset($_POST['db_username'])) $_POST['db_username']= $zdb_user;
  if (!isset($_POST['db_name']))     $_POST['db_name']    = $zdb_name;
  if (!isset($_POST['sql_cache']))   $_POST['sql_cache']  = $zdb_sql_cache;
  if (!isset($_POST['db_conn']))     $_POST['db_conn']    = $zdb_persistent;
  if (!isset($_POST['db_sess']))     $_POST['db_sess']    = $zdb_sessions;
  if (!isset($_POST['db_prefix']))   $_POST['db_prefix']  = $zdb_prefix;
  if (!isset($_POST['db_type']))     $_POST['db_type']    = $zdb_type;
  if (!isset($_POST['cache_type']))  $_POST['cache_type'] = $zdb_cache_type;

  setInputValue($_POST['db_host'],    'DATABASE_HOST_VALUE', $zdb_server);
  setInputValue($_POST['db_username'],'DATABASE_USERNAME_VALUE', $zdb_user);
  setInputValue($_POST['db_name'],    'DATABASE_NAME_VALUE', $zdb_name);
  setInputValue($_POST['sql_cache'],  'SQL_CACHE_VALUE', $zdb_sql_cache);
  setInputValue($_POST['db_prefix'],  'DATABASE_NAME_PREFIX', $zdb_prefix );
  setRadioChecked($_POST['db_conn'],  'DB_CONN', $zdb_persistent);
  setRadioChecked($_POST['db_sess'],  'DB_SESS', $zdb_sessions);
?>
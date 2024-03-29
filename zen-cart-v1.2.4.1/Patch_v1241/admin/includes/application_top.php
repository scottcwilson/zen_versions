<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: application_top.php 597 2004-11-18 19:42:11Z wilt $
//

// Start the clock for the page parse time log
  define('PAGE_PARSE_START_TIME', microtime());

// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);


// Set the local configuration parameters - mainly for developers
  if (file_exists('includes/local/configure.php')) include('includes/local/configure.php');

// Include application configuration parameters
  require('includes/configure.php');

// include the list of extra configure files
  if ($za_dir = @dir(DIR_WS_INCLUDES . 'extra_configures')) {
    while ($zv_file = $za_dir->read()) {
      if (strstr($zv_file, '.php')) {
        require(DIR_WS_INCLUDES . 'extra_configures/' . $zv_file);
      }
    }
  }

// set the type of request (secure or not)
  $request_type = ($_SERVER['HTTPS'] == 'on') ? 'SSL' : 'NONSSL';

// set php_self in the local scope
  if (!isset($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];

// Used in the "Backup Manager" to compress backups
  define('LOCAL_EXE_GZIP', '/usr/bin/gzip');
  define('LOCAL_EXE_GUNZIP', '/usr/bin/gunzip');
  define('LOCAL_EXE_ZIP', '/usr/local/bin/zip');
  define('LOCAL_EXE_UNZIP', '/usr/local/bin/unzip');

// include the list of project filenames
  require(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'filenames.php');

// include the list of project database tables
  require(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'database_tables.php');

// include the list of compatibility issues
  require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'compatibility.php');

// customization for the design layout
  define('BOX_WIDTH', 125); // how wide the boxes should be in pixels (default: 125)

// Define how do we update currency exchange rates
// Possible values are 'oanda' 'xe' or ''
  define('CURRENCY_SERVER_PRIMARY', 'oanda');
  define('CURRENCY_SERVER_BACKUP', 'xe');

// include the database functions
  require(DIR_WS_FUNCTIONS . 'database.php');

// include the list of extra database tables and filenames
//  include(DIR_WS_MODULES . 'extra_datafiles.php');
  if ($za_dir = @dir(DIR_WS_INCLUDES . 'extra_datafiles')) {
    while ($zv_file = $za_dir->read()) {
      if (strstr($zv_file, '.php')) {
        require(DIR_WS_INCLUDES . 'extra_datafiles/' . $zv_file);
      }
    }
  }

// include the cache class
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'cache.php');
  $zc_cache = new cache;
// Load db classes

// Load queryFactory db classes
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'db/' .DB_TYPE . '/query_factory.php');
  $db = new queryFactory();
  $db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

  $zc_cache->sql_cache_flush_cache();

// Define the project version  (must come after db class is loaded)
  require(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'version.php');

// Determine the DATABASE patch level
  $project_db_info= $db->Execute('select * from ' . TABLE_PROJECT_VERSION . ' WHERE project_version_key = "Zen-Cart Database" ');
  define('PROJECT_DB_VERSION_MAJOR',$project_db_info->fields['project_version_major']);
  define('PROJECT_DB_VERSION_MINOR',$project_db_info->fields['project_version_minor']);
  define('PROJECT_DB_VERSION_PATCH1',$project_db_info->fields['project_version_patch1']);
  define('PROJECT_DB_VERSION_PATCH2',$project_db_info->fields['project_version_patch2']);
  define('PROJECT_DB_VERSION_PATCH1_SOURCE',$project_db_info->fields['project_version_patch1_source']);
  define('PROJECT_DB_VERSION_PATCH2_SOURCE',$project_db_info->fields['project_version_patch2_source']);

// set application wide parameters
  $configuration = $db->Execute('select configuration_key as cfgKey, configuration_value as cfgValue
                                 from ' . TABLE_CONFIGURATION);
  while (!$configuration->EOF) {
    define($configuration->fields['cfgKey'], $configuration->fields['cfgValue']);
    $configuration->MoveNext();
  }

// set product type layout paramaters
  $configuration = $db->Execute('select configuration_key as cfgKey, configuration_value as cfgValue
                          from ' . TABLE_PRODUCT_TYPE_LAYOUT);

  while (!$configuration->EOF) {
    define($configuration->fields['cfgKey'], $configuration->fields['cfgValue']);
    $configuration->movenext();
  }

// GZIP for Admin
// if gzip_compression is enabled, start to buffer the output
  if ( (GZIP_LEVEL == '1') && ($ext_zlib_loaded = extension_loaded('zlib')) && (PHP_VERSION >= '4') ) {
    if (($ini_zlib_output_compression = (int)ini_get('zlib.output_compression')) < 1) {
      if (PHP_VERSION >= '4.0.4') {
        ob_start('ob_gzhandler');
      } else {
        include(DIR_WS_FUNCTIONS . 'gzip_compression.php');
        ob_start();
        ob_implicit_flush();
      }
    } else {
      ini_set('zlib.output_compression_level', GZIP_LEVEL);
    }
  }

// define our general functions used application-wide
  require(DIR_WS_FUNCTIONS . 'general.php');
  require(DIR_WS_FUNCTIONS . 'functions_prices.php');
  require(DIR_WS_FUNCTIONS . 'html_output.php');
  require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'functions_email.php');

// include the list of extra functions
  if ($za_dir = @dir(DIR_WS_FUNCTIONS . 'extra_functions')) {
    while ($zv_file = $za_dir->read()) {
      if (strstr($zv_file, '.php')) {
        require(DIR_WS_FUNCTIONS . 'extra_functions/' . $zv_file);
      }
    }
  }

// initialize the logger class
  require(DIR_WS_CLASSES . 'logger.php');

// include shopping cart class
  require(DIR_WS_CLASSES . 'shopping_cart.php');


// define how the session functions will be used
  require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'sessions.php');

// set the session name and save path
  $http_domain = zen_get_top_level_domain(HTTP_SERVER);
  $https_domain = zen_get_top_level_domain(HTTPS_SERVER);
  $current_domain = (($request_type == 'NONSSL') ? $http_domain : $https_domain);
  if (SESSION_USE_FQDN == 'False') $current_domain = '.' . $current_domain;
  zen_session_name('zenAdminID');
  zen_session_save_path(SESSION_WRITE_DIRECTORY);

// set the session cookie parameters
//   if (function_exists('session_set_cookie_params')) {
    session_set_cookie_params(0, '/', (zen_not_null($current_domain) ? $current_domain : ''));
//  } elseif (function_exists('ini_set')) {
//    ini_set('session.cookie_lifetime', '0');
//    ini_set('session.cookie_path', DIR_WS_ADMIN);
//  }

// lets start our session
  zen_session_start();
  $session_started = true;

// set the language
  if (!$_SESSION['language'] || isset($_GET['language'])) {

    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language();

    if (isset($_GET['language']) && zen_not_null($_GET['language'])) {
      $lng->set_language($_GET['language']);
    } else {
      $lng->get_browser_language();
      $lng->set_language(DEFAULT_LANGUAGE);
    }

    $_SESSION['language'] = $lng->language['directory'];
    $_SESSION['languages_id'] = $lng->language['id'];
  }

// Set theme related directories
  $template_query = $db->Execute("select template_dir
                                  from " . TABLE_TEMPLATE_SELECT .
                                  " where template_language = '0'");

  $template_dir = $template_query->fields['template_dir'];
  $template_query = $db->Execute("select template_dir
                                  from " . TABLE_TEMPLATE_SELECT .
                                  " where template_language = '" . $_SESSION['languages_id'] . "'");

  if ($template_query->RecordCount() > 0) {
    $template_dir = $template_query->fields['template_dir'];
  }

  define('DIR_WS_TEMPLATE_IMAGES', DIR_WS_CATALOG_TEMPLATE . $template_dir . '/images/');
  define('DIR_WS_TEMPLATE_ICONS', DIR_WS_TEMPLATE_IMAGES . 'icons/');

  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'template_func.php');
  $template = new template_func(DIR_WS_TEMPLATE);


// include the language translations
  require(DIR_WS_LANGUAGES . $_SESSION['language'] . '.php');
  $current_page = basename($PHP_SELF);
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $current_page)) {
    include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $current_page);
  }

  if ($za_dir = @dir(DIR_WS_LANGUAGES . $_SESSION['language'] . '/extra_definitions')) {
    while ($zv_file = $za_dir->read()) {
      if (strstr($zv_file, '.php')) {
        require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/extra_definitions/' . $zv_file);
      }
    }
  }
// load the product class
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'products.php');
  $zc_products = new products;

// define our localization functions
  require(DIR_WS_FUNCTIONS . 'localization.php');

// Include validation functions (right now only email address)
  require(DIR_WS_FUNCTIONS . 'validations.php');

// setup our boxes
  require(DIR_WS_CLASSES . 'table_block.php');
  require(DIR_WS_CLASSES . 'box.php');

// initialize the message stack for output messages
  require(DIR_WS_CLASSES . 'message_stack.php');
  $messageStack = new messageStack;

//  split-page-results
//  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'split_page_results.php');

  require(DIR_WS_CLASSES . 'split_page_results.php');

// entry/item info classes
  require(DIR_WS_CLASSES . 'object_info.php');

// email classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'email.php');

// file uploading class
  require(DIR_WS_CLASSES . 'upload.php');

// set a default time limit
  zen_set_time_limit(GLOBAL_SET_TIME_LIMIT);

// auto activate and expire banners
  require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'banner.php');
  zen_activate_banners();
  zen_expire_banners();

// auto expire special products
  require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'specials.php');
  zen_start_specials();
  zen_expire_specials();

// auto expire featured products
  require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'featured.php');
  zen_start_featured();
  zen_expire_featured();

// auto expire salemaker sales
  require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'salemaker.php');
  zen_start_salemaker();
  zen_expire_salemaker();

// calculate category path
  if (isset($_GET['cPath'])) {
    $cPath = $_GET['cPath'];
  } else {
    $cPath = '';
  }

  if (zen_not_null($cPath)) {
    $cPath_array = zen_parse_category_path($cPath);
    $cPath = implode('_', $cPath_array);
    $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  } else {
    $current_category_id = 0;
  }

// default open navigation box
  if (!$_SESSION['selected_box']) {
    $_SESSION['selected_box'] = 'configuration';
  }

  if (isset($_GET['selected_box'])) {
    $_SESSION['selected_box'] = $_GET['selected_box'];
  }


// check if a default currency is set
  if (!defined('DEFAULT_CURRENCY')) {
    $messageStack->add(ERROR_NO_DEFAULT_CURRENCY_DEFINED, 'error');
  }

// check if a default language is set
  if (!defined('DEFAULT_LANGUAGE')) {
    $messageStack->add(ERROR_NO_DEFAULT_LANGUAGE_DEFINED, 'error');
  }

  if (function_exists('ini_get') && ((bool)ini_get('file_uploads') == false) ) {
    $messageStack->add(WARNING_FILE_UPLOADS_DISABLED, 'warning');
  }

// set demo message
  if (zen_get_configuration_key_value('ADMIN_DEMO')=='1') {
    if (zen_admin_demo()) {
      $messageStack->add(ADMIN_DEMO_ACTIVE, 'warning');
    } else {
      $messageStack->add(ADMIN_DEMO_ACTIVE_EXCLUSION, 'warning');
    }
  }

// include the password crypto functions
  require(DIR_WS_FUNCTIONS . 'password_funcs.php');

  if (!(basename($PHP_SELF) == FILENAME_LOGIN . '.php')) {
    if (!isset($_SESSION['admin_id'])) {
      if (!(basename($PHP_SELF) == FILENAME_PASSWORD_FORGOTTEN . '.php')) {
        zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
      }
    }
  }

  if ((basename($PHP_SELF) == FILENAME_LOGIN . '.php') and (substr_count(dirname($PHP_SELF),'//') > 0 or substr_count(dirname($PHP_SELF),'.php') > 0)) {
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  // audience functions are for newsletter and mass-email audience-selection queries
  require(DIR_WS_FUNCTIONS.'audience.php');

?>
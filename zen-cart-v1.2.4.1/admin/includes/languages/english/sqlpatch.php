<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
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
//  $Id: sqlpatch.php 277 2004-09-10 23:03:52Z wilt $
//
  define('HEADING_TITLE','SQL Query Executor');
  define('HEADING_WARNING','BE SURE TO DO A FULL DATABASE BACKUP BEFORE RUNNING SCRIPTS HERE');
  define('HEADING_WARNING2','If you are installing 3rd-party contributions, note that you do so at your own risk.<br />Zen Cart&trade; makes no warranty as to the safety of scripts supplied by 3rd-party contributors. Test before using on your live database!');
  define('TEXT_QUERY_RESULTS','Query Results:');
  define('TEXT_ENTER_QUERY_STRING','Enter the query <br />to be executed:&nbsp;&nbsp;<br /><br />Be sure to<br />end with ;');
  define('TEXT_QUERY_FILENAME','Upload file:');
  define('ERROR_NOTHING_TO_DO','Error: Nothing to do - no query or query-file specified.');
  define('TEXT_CLOSE_WINDOW', '[ close window ]');
  define('SQLPATCH_HELP_TEXT','The SQLPATCH tool lets you install system patches by pasting SQL code directly into the textarea '.
                              'field here, or by uploading a supplied script (.SQL) file.  ' . "\n\n" . 'The commands entered or ' .
                              'uploaded may only begin with the following statements, and MUST be in UPPERCASE: ' . "\n" .
                              '<ul><li>DROP TABLE IF EXISTS</li><li>CREATE TABLE</li><li>INSERT INTO</li><li>ALTER TABLE</li>' .
                              '<li>UPDATE</li><li>DELETE FROM</li></ul>' . "\n\n" .
                              'When preparing scripts to be used by this tool, DO NOT include a table prefix, as this tool will ' .
                              'automatically insert the required prefix for the active database, based on settings in the store\'s ' .
                              'admin/includes/configure.php file (DB_PREFIX definition).' . "\n");

?>
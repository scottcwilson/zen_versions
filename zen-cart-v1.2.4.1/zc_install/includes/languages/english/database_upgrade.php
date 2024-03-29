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
// $Id: database_upgrade.php 277 2004-09-10 23:03:52Z wilt $
//

  define('PAGE_HEADING', 'Zen Cart&trade; Setup - Database Upgrade');
  define('UPDATE_DATABASE_NOW','Update Database Now');//this comes before TEXT_MAIN
  define('TEXT_MAIN', '<em>Warning: </em> This script should ONLY be used to upgrade your Zen Cart database schema through the versions listed below.  ' .
                      '<span class="emphasis"><strong>We HIGHLY RECOMMEND doing a full backup of your database prior to performing any upgrades on it!</strong></span>');
  define('TEXT_MAIN_2','<span class="emphasis">Please check the details below very carefully</span>. This information is taken from your configure.php settings.<br />' .
                      'Do not proceed unless you\'re sure they\'re correct, or else you risk corruption to your database.');

  define('DATABASE_INFORMATION', 'Database Information');
  define('DATABASE_TYPE', 'Database Type');
  define('DATABASE_HOST', 'Database Host');
  define('DATABASE_USERNAME', 'Database Username');
  define('DATABASE_PASSWORD', 'Database Password');
  define('DATABASE_NAME', 'Database Name');
  define('DATABASE_PREFIX', 'Database Table-Prefix');

  define('SNIFFER_PREDICTS','<em>Upgrade Sniffer</em> predicts: ');
  define('CHOOSE_UPGRADES','Please confirm your desired upgrade steps');
  define('TITLE_DATABASE_PREFIX_CHANGE','Change Database Table-Prefix');
  define('ERROR_PREFIX_CHANGE_NEEDED','<span class="errors">We were unable to locate the Zen Cart tables in your database.<br />Perhaps your database table-prefix has been specified incorrectly?</span><br />If modifying table prefixes doesn\'t solve your problem, you will need to manually compare your configure.php settings with your actual database, perhaps through phpMyAdmin or your webserver control panel.');
  define('TEXT_DATABASE_PREFIX_CHANGE','If you wish to change the database table prefixes, enter the new prefix below. <span class="emphasis">NOTE: please verify that the prefix name is not already used in your database</span>, as we do not check for such duplication. Using an already-existing table prefix will corrupt your database.');
  define('TEXT_DATABASE_PREFIX_CHANGE_WARNING','<span class="errors"><strong>WARNING: DO NOT ATTEMPT TO CHANGE TABLE PREFIXES IF YOU DO NOT HAVE A FULL AND DEPENDABLE RECENT BACKUP OF YOUR DATABASE CONTENTS. If something goes wrong in the process, you will need to recover from your backup. If this is cause for concern or uncertainty for you, then DO NOT attempt to rename your tables.</strong></span>');
  define('DATABASE_OLD_PREFIX','Old Table-Prefix');
  define('DATABASE_OLD_PREFIX_INSTRUCTION','Enter the OLD Table-Prefix');
  define('ENTRY_NEW_PREFIX','New Table-Prefix ');
  define('DATABASE_NEW_PREFIX_INSTRUCTION','Enter the NEW Table-Prefix');

  define('UPDATE_DATABASE_WARNING_DO_NOT_INTERRUPT','<span class="emphasis">After clicking below, DO NOT INTERRUPT. Please be patient during upgrade.</span>');
  define('SKIP_UPDATES','Skip Updates');
?>
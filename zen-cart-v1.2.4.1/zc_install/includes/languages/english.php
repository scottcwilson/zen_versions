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
// $Id: english.php 358 2004-09-28 23:30:32Z drbyte $
//

  define('YES', 'YES');
  define('NO', 'NO');

  // Global entries for the <html> tag
  define('HTML_PARAMS','dir="ltr" lang="en"');

  // charset for web pages and emails
  define('CHARSET', 'iso-8859-1');

  // META TAG TITLE
  define('META_TAG_TITLE', 'Zen Cart&trade; Installer');

  if (isset($_GET['main_page']) && ($_GET['main_page']== 'index' || $_GET['main_page']== 'license')) {
    define('TEXT_ERROR_WARNING', 'Hi: Just a few issues that need addressing before we continue.');
  } else {
    define('TEXT_ERROR_WARNING', '<span class="errors"><strong>Warning: Problems Found</strong></span>');
  }

  define('DB_ERROR_NOT_CONNECTED', 'Install Error: Could not connect to the Database');

  define('UPLOAD_SETTINGS','The Maximum upload size supported will be whichever the LOWER of these values:.<br />
<em>upload_max_filesize</em> in php.ini %s <br />
<em>post_max_size</em> in php.ini: %s <br />' . 
//'<em>Zen Cart</em> Upload Setting: %s <br />' .
'You may find some Apache settings that prevent you from uploading files or limit your maximum file size.  
See the Apache documentation for more information.');

  define('TEXT_HELP_LINK', ' more info...');
  define('TEXT_CLOSE_WINDOW', 'Close Window');
  define('STORE_ADDRESS_DEFAULT_VALUE', 'Store Name
  Address
  Country
  Phone');

  define('ERROR_TEXT_4_1_2', 'PHP Version is 4.1.2');
  define('ERROR_CODE_4_1_2', '1');

  define('ERROR_TEXT_ADMIN_CONFIGURE', '/admin/includes/configure.php does not exist');
  define('ERROR_CODE_ADMIN_CONFIGURE', '2');

  define('ERROR_TEXT_STORE_CONFIGURE', '/includes/configure.php file does not exist');
  define('ERROR_CODE_STORE_CONFIGURE', '3');

  define('ERROR_TEXT_PHYSICAL_PATH_ISEMPTY', 'Physical path is empty');
  define('ERROR_CODE_PHYSICAL_PATH_ISEMPTY', '9');

  define('ERROR_TEXT_PHYSICAL_PATH_INCORRECT', 'Physical path is incorrect');
  define('ERROR_CODE_PHYSICAL_PATH_INCORRECT', '10');

  define('ERROR_TEXT_VIRTUAL_HTTP_ISEMPTY', 'Virtual HTTP is empty');
  define('ERROR_CODE_VIRTUAL_HTTP_ISEMPTY', '11');

  define('ERROR_TEXT_VIRTUAL_HTTPS_ISEMPTY', 'Virtual HTTPS is empty');
  define('ERROR_CODE_VIRTUAL_HTTPS_ISEMPTY', '12');

  define('ERROR_TEXT_VIRTUAL_HTTPS_SERVER_ISEMPTY', 'Virtual HTTPS server is empty');
  define('ERROR_CODE_VIRTUAL_HTTPS_SERVER_ISEMPTY', '13');

  define('ERROR_TEXT_DB_USERNAME_ISEMPTY', 'DB UserName is empty');
  define('ERROR_CODE_DB_USERNAME_ISEMPTY', '16'); // re-using another one, since message is essentially the same.

  define('ERROR_TEXT_DB_HOST_ISEMPTY', 'DB Host is empty');
  define('ERROR_CODE_DB_HOST_ISEMPTY', '24');

  define('ERROR_TEXT_DB_NAME_ISEMPTY', 'DB name is empty'); 
  define('ERROR_CODE_DB_NAME_ISEMPTY', '25');

  define('ERROR_TEXT_DB_SQL_NOTEXIST', 'SQL Install file does not exist');
  define('ERROR_CODE_DB_SQL_NOTEXIST', '26');

  define('ERROR_TEXT_DB_NOTSUPPORTED', 'Database not supported');
  define('ERROR_CODE_DB_NOTSUPPORTED', '27');

  define('ERROR_TEXT_DB_CONNECTION_FAILED', 'Connection to Database failed');
  define('ERROR_CODE_DB_CONNECTION_FAILED', '28');

  define('ERROR_TEXT_DB_CREATE_FAILED', 'Could not create database');
  define('ERROR_CODE_DB_CREATE_FAILED', '29');

  define('ERROR_TEXT_DB_NOTEXIST', 'Database does not exist');
  define('ERROR_CODE_DB_NOTEXIST', '30');

  define('ERROR_TEXT_STORE_NAME_ISEMPTY', 'Store name is empty');
  define('ERROR_CODE_STORE_NAME_ISEMPTY', '31');

  define('ERROR_TEXT_STORE_OWNER_ISEMPTY', 'Store owner is empty');
  define('ERROR_CODE_STORE_OWNER_ISEMPTY', '32');

  define('ERROR_TEXT_STORE_OWNER_EMAIL_ISEMPTY', 'Store email address is empty');
  define('ERROR_CODE_STORE_OWNER_EMAIL_ISEMPTY', '33');

  define('ERROR_TEXT_STORE_OWNER_EMAIL_NOTEMAIL', 'Store email address is not valid');
  define('ERROR_CODE_STORE_OWNER_EMAIL_NOTEMAIL', '34');

define('ERROR_TEXT_STORE_ADDRESS_ISEMPTY', 'Store address is empty');
define('ERROR_CODE_STORE_ADDRESS_ISEMPTY', '35');

define('ERROR_TEXT_DEMO_SQL_NOTEXIST', 'Demo product SQL file does not exist');
define('ERROR_CODE_DEMO_SQL_NOTEXIST', '36');

define('ERROR_TEXT_ADMIN_USERNAME_ISEMPTY', 'Admin user name is empty');
define('ERROR_CODE_ADMIN_USERNAME_ISEMPTY', '46');

define('ERROR_TEXT_ADMIN_EMAIL_ISEMPTY', 'Admin email empty');
define('ERROR_CODE_ADMIN_EMAIL_ISEMPTY', '47');

define('ERROR_TEXT_ADMIN_EMAIL_NOTEMAIL', 'Admin email is not valid');
define('ERROR_CODE_ADMIN_EMAIL_NOTEMAIL', '48');

define('ERROR_TEXT_ADMIN_PASS_ISEMPTY', 'Admin password is empty');
define('ERROR_CODE_ADMIN_PASS_ISEMPTY', '49');

define('ERROR_TEXT_ADMIN_PASS_NOTEQUAL', 'Passwords do not match');
define('ERROR_CODE_ADMIN_PASS_NOTEQUAL', '50');

define('ERROR_TEXT_PHP_VERSION', 'PHP Version not supported');
define('ERROR_CODE_PHP_VERSION', '55');

define('ERROR_TEXT_ADMIN_CONFIGURE_WRITE', 'admin configure.php is not writeable');
define('ERROR_CODE_ADMIN_CONFIGURE_WRITE', '56');

define('ERROR_TEXT_STORE_CONFIGURE_WRITE', 'store configure.php is not writeable');
define('ERROR_CODE_STORE_CONFIGURE_WRITE', '57');

define('ERROR_TEXT_CACHE_DIR_ISEMPTY', 'The Session/SQL Cache Directory entry is empty');
define('ERROR_CODE_CACHE_DIR_ISEMPTY', '61');

define('ERROR_TEXT_CACHE_DIR_ISDIR', 'The Session/SQL Cache Directory entry does not exist');
define('ERROR_CODE_CACHE_DIR_ISDIR', '62');

define('ERROR_TEXT_CACHE_DIR_ISWRITEABLE', 'The Session/SQL Cache Directory entry is not writeable');
define('ERROR_CODE_CACHE_DIR_ISWRITEABLE', '63');

define('ERROR_TEXT_PHPBB_CONFIG_NOTEXIST', 'phpBB config files do not exist');
define('ERROR_CODE_PHPBB_CONFIG_NOTEXIST', '68');

define('ERROR_TEXT_REGISTER_GLOBALS_ON', 'Register Globals is ON');
define('ERROR_CODE_REGISTER_GLOBALS_ON', '69');

define('ERROR_TEXT_SAFE_MODE_ON', 'Safe Mode is ON');
define('ERROR_CODE_SAFE_MODE_ON', '70');

define('ERROR_TEXT_CACHE_CUSTOM_NEEDED','Cache folder required to use file caching support');
define('ERROR_CODE_CACHE_CUSTOM_NEEDED', '71');

define('ERROR_TEXT_TABLE_RENAME_CONFIGUREPHP_FAILED','Could not update all your configure.php files with new prefix');
define('ERROR_CODE_TABLE_RENAME_CONFIGUREPHP_FAILED', '72');

define('ERROR_TEXT_TABLE_RENAME_INCOMPLETE','Could not rename all tables');
define('ERROR_CODE_TABLE_RENAME_INCOMPLETE', '73');

define('ERROR_TEXT_SESSION_SAVE_PATH','PHP "session.save_path" is not writable');
define('ERROR_CODE_SESSION_SAVE_PATH','74');

define('ERROR_TEXT_MAGIC_QUOTES_RUNTIME','PHP "magic_quotes_runtime" is active');
define('ERROR_CODE_MAGIC_QUOTES_RUNTIME','75');

define('ERROR_TEXT_DB_VER_UNKNOWN','Database Engine version information unknown');
define('ERROR_CODE_DB_VER_UNKNOWN','76');

define('ERROR_TEXT_UPLOADS_DISABLED','File Uploads are disabled');
define('ERROR_CODE_UPLOADS_DISABLED','77');

  $error_code ='';
if (isset($_GET['error_code'])) {
  $error_code = $_GET['error_code'];
  }

switch ($error_code) {
  case ('1'):
    define('POPUP_ERROR_HEADING', 'PHP Version 4.1.2 Detected');
    define('POPUP_ERROR_TEXT', 'Some releases of PHP Version 4.1.2 have a bug which affects super global arrays. This may result in the admin section of Zen Cart not being accessible. You are advised to upgrade your PHP version if possible.');
    
  break;
  case ('2'):
    define('POPUP_ERROR_HEADING', '/admin/includes/configure.php does not exist');
    define('POPUP_ERROR_TEXT', 'The file /admin/includes/configure.php does not exist. You can create this either as a blank file or by renaming /admin/includes/dist-configure.php to configure.php.  After creating it, you need to mark it read-write or CHMOD 666 or CHMOD 777.');
    
  break;
  case ('3'):
    define('POPUP_ERROR_HEADING', '/includes/configure.php does not exist');
    define('POPUP_ERROR_TEXT', 'The file /includes/configure.php does not exist. You can create this either as a blank file or by renaming /includes/dist-configure.php to configure.php.  After creating it, you need to mark it read-write or CHMOD 666 or CHMOD 777.');
    
  break;
  case ('4'):
    define('POPUP_ERROR_HEADING', 'Physical Path');
    define('POPUP_ERROR_TEXT', 'The physiscal path is the path to the directory where your Zen Cart files are installed. For example on some linux systems the html files are stored in /var/www/html. If you then put your Zen Cart files in a directory called \'store\', the physical path would be /var/www/html/store. The installer usually can be trusted to guess this directory correctly.');
    
  break;
  case ('5'):
    define('POPUP_ERROR_HEADING', 'Virtual HTTP Path');
    define('POPUP_ERROR_TEXT', 'This is the address you would need to put into a web browser to view your Zen Cart website. If the site is in the \'root\' of your domain, this would be \'http://www.yourdomain.com\'. If you had put the files under a directory called \'store\' then the path would be \'http://www.yourdomain.com/store\'.');
    
  break;
  case ('6'):
    define('POPUP_ERROR_HEADING', 'Virtual HTTPS Server');
    define('POPUP_ERROR_TEXT', 'This is the web server address for your secure/SSL server. This address varies depending on how SSL/Secure mode is implemented on your server. You are advised to read the <a href="http://www.zen-cart.com/modules/xoopsfaq/index.php?cat_id=2#46" target="_blank">FAQ Entry</a> on SSL to ensure this is set correctly.');
    
  break;
  case ('7'):
    define('POPUP_ERROR_HEADING', 'Virtual HTTPS Path');
    define('POPUP_ERROR_TEXT', 'This is the address you would need to put into a web browser to view your Zen Cart website in secure/SSL mode. You are advised to read the <a href="http://www.zen-cart.com/modules/xoopsfaq/index.php?cat_id=2#46" target="_blank">FAQ Entry</a> on SSL to ensure this is set correctly.');
    
  break;
  case ('8'):
    define('POPUP_ERROR_HEADING', 'Enable SSL');
    define('POPUP_ERROR_TEXT', 'This setting determines whether SSL/Secure (HTTPS:) mode is used on security-vulnerable pages of your Zen Cart website.<br /><br />Any page where personal information is entered e.g. login, checkout, account details can be protected by SSL/Secure mode.  It can also be actived for the Administration area.<br /><br />You must have access to an SSL server (denoted by using HTTPS instead of HTTP). <br /><br />If you are not sure if you have an SSL server then please leave this setting set to false for now, and check with your hosting provider. Note: As with all settings, this can be changed later by editing the appropriate configure.php file.');
    
  break;
  case ('9'):
    define('POPUP_ERROR_HEADING', 'Physical Path is empty');
    define('POPUP_ERROR_TEXT', 'You have left the entry for the Physical path empty. You must make a valid entry here.');
    
  break;
  case ('10'):
    define('POPUP_ERROR_HEADING', 'Physical Path is incorrect');
    define('POPUP_ERROR_TEXT', 'The entry you have made for the Physical Path does not appear to be valid. Please correct and try again.');
    
  break;
  case ('11'):
    define('POPUP_ERROR_HEADING', 'Virtual HTTP is empty');
    define('POPUP_ERROR_TEXT', 'You have left the entry for the Virtual HTTP path empty. You must make a valid entry here.');
    
  break;
  case ('12'):
    define('POPUP_ERROR_HEADING', 'Virtual HTTPS is empty');
    define('POPUP_ERROR_TEXT', 'You have left the entry for the Virtual HTTPS path empty as well as enabling SSL mode. You must make a valid entry here or disable SSL mode.');
    
  break;
  case ('13'):
    define('POPUP_ERROR_HEADING', 'Virtual HTTPS server is empty');
    define('POPUP_ERROR_TEXT', 'You have left the entry for the Virtual HTTPS server empty as well as enabling SSL mode. You must make a valid entry here or disable SSL mode');
    
  break;
  case ('14'):
    define('POPUP_ERROR_HEADING', 'Database Type');
    define('POPUP_ERROR_TEXT', 'Zen Cart is designed to support multiple database types. Unfortunately at the moment that support is not complete. For now you should always leave this set to MySQL.');
    
  break;
  case ('15'):
    define('POPUP_ERROR_HEADING', 'Database Host');
    define('POPUP_ERROR_TEXT', 'This is the name of the webserver on which your host runs their database program. In most cases this can always be left set to \'localhost\'. In some exceptional cases you will need to ask your hosting provider for the server name of their database server.');
    
  break;
  case ('16'):
    define('POPUP_ERROR_HEADING', 'Database User Name');
    define('POPUP_ERROR_TEXT', 'All databases require a username and password to access them. The username for your database may well have been assigned by your hosting provider and you should contact them for details.');
    
  break;
  case ('17'):
    define('POPUP_ERROR_HEADING', 'Database Password');
    define('POPUP_ERROR_TEXT', 'All databases require a username and password to access them. The password for your database may well have been assigned by your hosting provider and you should contact them for details.');
    
  break;
  case ('18'):
    define('POPUP_ERROR_HEADING', 'Database Name');
    define('POPUP_ERROR_TEXT', 'This is the name of the database that will be used for Zen Cart. If you are unsure as to what this should be, then you should contact your hosting provider for more information.');
    
  break;
  case ('19'):
    define('POPUP_ERROR_HEADING', 'Database Table-Prefix');
    define('POPUP_ERROR_TEXT', 'Zen Cart allows you to add a prefix to the table names it uses to store its information. This is especially useful if your host only allows you one database, and you want to install other scripts on your system that use that database. Normally you should just leave the default setting as it is.');
    
  break;
  case ('20'):
    define('POPUP_ERROR_HEADING', 'Database Create');
    define('POPUP_ERROR_TEXT', 'This setting determines whether the installer should attempt to create the main database for Zen Cart. Note \'create\' in this context has nothing to do with adding the tables that Zen Cart needs, which will be done automatically anyway. Many hosts will not give their users \'create\' permissions, but provide another method for creating blank databases, e.g. cPanel or phpMyAdmin.');
    
  break;
  case ('21'):
    define('POPUP_ERROR_HEADING', 'Database Connection');
    define('POPUP_ERROR_TEXT', 'Persistent connections are a method of reducing the load on the database. You should consult your server host before setting this option.  Enabling "persistent connections" could cause your host to experience database problems if they haven\'t configured to handle it.<br /><br />Again, be sure to talk to your host before considering use of this option.');
    
  break;
  case ('22'):
    define('POPUP_ERROR_HEADING', 'Database Sessions');
    define('POPUP_ERROR_TEXT', 'This detemines whether session information is stored in a file or in the database. While file-based sessions are faster, database sessions are recommended for all online stores using SSL connections, for the sake of security.');
    
  break;
  case ('23'):
    define('POPUP_ERROR_HEADING', 'Enable SSL');
    define('POPUP_ERROR_TEXT', '');
    
  break;
  case ('24'):
    define('POPUP_ERROR_HEADING', 'DB Host is empty');
    define('POPUP_ERROR_TEXT', 'The entry for DB Host is empty. Please enter a valid Database Server Hostname. <br />This is the name of the webserver on which your host runs their database program. In most cases this can always be left set to \'localhost\'. In some exceptional cases you will need to ask your hosting provider for the server name of their database server.');
  break;
  
  case ('25'):
    define('POPUP_ERROR_HEADING', 'DB name is empty');
    define('POPUP_ERROR_TEXT', 'The entry for DB name is empty. Please enter the name of the database you wish to use for Zen Cart.<br />This is the name of the database that will be used for Zen Cart. If you are unsure as to what this should be, then you should contact your hosting provider for more information.');
    
  break;
  case ('26'):
    define('POPUP_ERROR_HEADING', 'SQL Install file does not exist');
    define('POPUP_ERROR_TEXT', 'The installer could not find the sql install file. This should exist within the \'zc_install\' directory and be called something like \'mysql_zencart.sql\'.');
    
  break;
  case ('27'):
    define('POPUP_ERROR_HEADING', 'Database not supported');
    define('POPUP_ERROR_TEXT', 'The database type you have selected does not appear to be supported by the PHP version you have installed. You may need to check with your hosting provider to check that the database type you have selected is supported. If this is your own server, then please ensure that support for the database type has been compiled into PHP, and that the necessary extensions/modules/dll files are being loaded (esp check php.ini for extension=mysql.so, etc).');
    
  break;
  case ('28'):
    define('POPUP_ERROR_HEADING', 'Connection to Database failed');
    define('POPUP_ERROR_TEXT', 'A connection to the database could not be made. This can happen for a number of reasons. <br /><br />
You may have given the wrong DB host name, or the user name or <em>password </em>may be incorrect. <br /><br />
You may also have given the wrong database name (<strong>Does it exist?</strong> <strong>Did you create it?</strong> -- NOTE: Zen Cart&trade; does not create a database for you.).<br /><br />
Please review all of the entries and ensure that they are correct.');
    
  break;
  case ('29'):
    define('POPUP_ERROR_HEADING', 'Could not create database');
    define('POPUP_ERROR_TEXT', 'You do not appear to have permission to create a blank database. You may need to contact your host to do this for you. Alternatavely you may need to use cpanel or phpMyAdmin to create a blank database. Once you create the database manually, DESELECT the \'Create Database\' option in the Zen Cart Installer in order to proceed.');
    
  break;
  case ('30'):
    define('POPUP_ERROR_HEADING', 'Database does not exist');
    define('POPUP_ERROR_TEXT', 'The database name you have specified does not appear to exist.<br />(<strong>Did you create it?</strong> -- NOTE: Zen Cart&trade; does not create a database for you.).<br /><br />Please check your database details, then verify this entry and make corrections where necessary.');
    
  break;
  case ('31'):
    define('POPUP_ERROR_HEADING', 'Store name is empty');
    define('POPUP_ERROR_TEXT', 'Please specify the name by which you will refer to your store.');
    
  break;
  case ('32'):
    define('POPUP_ERROR_HEADING', 'Store owner is empty');
    define('POPUP_ERROR_TEXT', 'Please supply the name of the store owner.  This information will appear in the \'Contact Us\' page, the \'Welcome\' email messages, and other places throughout the store.');
    
  break;
  case ('33'):
    define('POPUP_ERROR_HEADING', 'Store email address is empty');
    define('POPUP_ERROR_TEXT', 'Please supply the store\'s primary email address. This is the address which will be supplied for contact information in emails that are sent out from the store. It will not be displayed on any pages in the store unless you manually do such configuration.');
    
  break;
  case ('34'):
    define('POPUP_ERROR_HEADING', 'Store email address is not valid');
    define('POPUP_ERROR_TEXT', 'You must supply a valid email address.');
    
  break;
  case ('35'):
    define('POPUP_ERROR_HEADING', 'Store address is empty');
    define('POPUP_ERROR_TEXT', 'Please supply the street address of your store.  This will be displayed on the Contact-Us page (this can be disabled if required), and on invoice/packing-slip materials. It will also be displayed if a customer elects to purchase by check/money-order, upon checkout.');
    
  break;
  case ('36'):
    define('POPUP_ERROR_HEADING', 'Demo product SQL file does not exist');
    define('POPUP_ERROR_TEXT', 'We were unable to locate the SQL file containing the Zen Cart demo products to load them into your store.  Please check that the /zc_install/demo/xxxxxxx_demo.sql file exists. (xxxxxxx = your database-type).');
    
  break;
  case ('37'):
    define('POPUP_ERROR_HEADING', 'Store Name');
    define('POPUP_ERROR_TEXT', 'The name of your store. This will be used in emails sent by the system and in some cases, the browser title.');
    
  break;
  case ('38'):
    define('POPUP_ERROR_HEADING', 'Store Owner');
    define('POPUP_ERROR_TEXT', 'The Store Owner details may be used in emails sent by the system.');
    
  break;
  case ('39'):
    define('POPUP_ERROR_HEADING', 'Store Owner Email');
    define('POPUP_ERROR_TEXT', 'The main email address by which your store can be contacted. Most emails sent by the system will use this, as well as contact us pages.');
    
  break;
  case ('40'):
    define('POPUP_ERROR_HEADING', 'Store Country');
    define('POPUP_ERROR_TEXT', 'The country your store is based in. It is important that you set this correctly to ensure that Tax and shipping options work correctly.  It also determines the address-label layout on invoicing, etc.');
    
  break;
  case ('41'):
    define('POPUP_ERROR_HEADING', 'Store Zone');
    define('POPUP_ERROR_TEXT', 'This represents a geographical sub-division of the country your store is based in. eg. A state in the U.S.A.');
    
  break;
  case ('42'):
    define('POPUP_ERROR_HEADING', 'Store Address');
    define('POPUP_ERROR_TEXT', 'Your Store Address, used on invoices and order confirmations');
    
  break;
  case ('43'):
    define('POPUP_ERROR_HEADING', 'Store Default Language');
    define('POPUP_ERROR_TEXT', 'The default language your store will use. Zen_Cart is inherently multi-language, provided the correct language pack is loaded. Unfortunately at the moment Zen Cart only comes with an English Language Pack as default.');
    
  break;
  case ('44'):
    define('POPUP_ERROR_HEADING', 'Store Default Currency');
    define('POPUP_ERROR_TEXT', 'Select a default currency which your store will operate on.  If your desired currency is not listed here, it can be changed easily in the Admin area after installation is complete.');
    
  break;
  case ('45'):
    define('POPUP_ERROR_HEADING', 'Install Demo Products');
    define('POPUP_ERROR_TEXT', 'Please select whether you wish to install the demo products into the database in order to preview the methods by which various features of Zen Cart operate.');
    
  break;
  case ('46'):
    define('POPUP_ERROR_HEADING', 'Admin user name is empty');
    define('POPUP_ERROR_TEXT', 'To log into the Admin area after install is complete, you need to supply an Admin username here.');
    
  break;
  case ('47'):
    define('POPUP_ERROR_HEADING', 'Admin email empty');
    define('POPUP_ERROR_TEXT', 'The Admin email address is required in order to send password-resets in case you forget the password.');
    
  break;
  case ('48'):
    define('POPUP_ERROR_HEADING', 'Admin email is not valid');
    define('POPUP_ERROR_TEXT', 'Please supply a valid email address.');
    
  break;
  case ('49'):
    define('POPUP_ERROR_HEADING', 'Admin password is empty');
    define('POPUP_ERROR_TEXT', 'For security, the Administrator\'s password cannot be blank.');
    
  break;
  case ('50'):
    define('POPUP_ERROR_HEADING', 'Passwords do not match');
    define('POPUP_ERROR_TEXT', 'Please re-enter the administrator password and confirmation password.');
    
  break;
  case ('51'):
    define('POPUP_ERROR_HEADING', 'Admin User Name');
    define('POPUP_ERROR_TEXT', 'To log into the Admin area after install is complete, you need to supply an Admin username here.');
    
  break;
  case ('52'):
    define('POPUP_ERROR_HEADING', 'Admin Email Address');
    define('POPUP_ERROR_TEXT', 'The Admin email address is required in order to send password-resets in case you forget the password.');
    
  break;
  case ('53'):
    define('POPUP_ERROR_HEADING', 'Admin Password');
    define('POPUP_ERROR_TEXT', 'The administrator password is your secure password to allow you access to the administration area.');
    
  break;
  case ('54'):
    define('POPUP_ERROR_HEADING', 'Admin Password Confirmation');
    define('POPUP_ERROR_TEXT', 'Naturally, you need to supply matching passwords before the password can be saved for future use.');
    
  break;
  case ('55'):
    define('POPUP_ERROR_HEADING', 'PHP Version not supported');
    define('POPUP_ERROR_TEXT', 'The PHP Version running on your webserver is not supported by Zen Cart.  Additionally, some releases of PHP Version 4.1.2 have a bug which affects super global arrays. This may result in the admin section of Zen Cart not being accessible. You are advised to upgrade your PHP version if possible.');
    
  break;
  case ('56'):
    define('POPUP_ERROR_HEADING', 'admin configure.php is not writeable');
    define('POPUP_ERROR_TEXT', 'The file admin/includes/configure.php is not writeable. If you are using a Unix or Linux system then please CHMOD the file to 777 or 666 until the Zen Cart install is completed. On a Windows system it is simply enough that the file is set to read/write.');
    
  break;
  case ('57'):
    define('POPUP_ERROR_HEADING', 'store configure.php is not writeable');
    define('POPUP_ERROR_TEXT', 'The file includes/configure.php is not writeable. If you are using a Unix or Linux system then please CHMOD the file to 777 or 666 until the Zen Cart install is completed. On a Windows system it is simply enough that the file is set to read/write.');
    
  break;
  case ('58'):
    define('POPUP_ERROR_HEADING', 'DB Table Prefix');
    define('POPUP_ERROR_TEXT', 'Zen Cart allows you to add a prefix to the table names it uses to store its information. This is especially useful if your host only allows you one database, and you want to install other scripts on your system that use that database. Normally you should just leave the default setting as it is.');
    
  break;
  case ('59'):
    define('POPUP_ERROR_HEADING', 'SQL Cache Directory');
    define('POPUP_ERROR_TEXT', 'SQL queries can be cached either in the database, in a file on your server\'s hard disk, or not at all. If you choose to cache SQL queries to a file on your server\'s hard disk, then you must provide the directory where this information can be saved. <br /><br />The standard Zen Cart installation includes a \'cache\' folder.  You need to mark this folder read-write for your webserver (ie: apache) to access it.<br /><br />Please ensure that the directory you select exists and is writeable by the web server (CHMOD 777 or at least 666 recommended).');
    
  break;
  case ('60'):
    define('POPUP_ERROR_HEADING', 'SQL Cache Method');
    define('POPUP_ERROR_TEXT', 'Some SQL queries are marked as being cacheable. This means that if they are cached they will run much more quickly. You can decide which method is used to cache the SQL Query.<br /><br /><strong>None</strong>. SQL queries are not cached at all. If you have very few products/categories you might actually find this gives the best speed for your site.<br /><br /><strong>Database</strong>. SQL queries are cached to a database table. Sounds strange but this might provide a speed increase for sites with medium numbers of products/categories.<br /><br /><strong>File</strong>. SQL Queries are cached to your server\'s hard disk. For this to work you must ensure that the directory where queries are cached to is writeable by the web server. This method is probably most suitable for sites with a large number of products/categories.');
    
  break;

  case ('61'):
    define('POPUP_ERROR_HEADING', 'The Session/SQL Cache Directory entry is empty');
    define('POPUP_ERROR_TEXT', 'If you wish to use file caching for Session/SQL queries, you must supply a valid directory on your webserver, and ensure that the webserver has rights to write into that folder/directory.');
    
  break;
  case ('62'):
    define('POPUP_ERROR_HEADING', 'The Session/SQL Cache Directory entry does not exist');
    define('POPUP_ERROR_TEXT', 'If you wish to use file caching for Session/SQL queries, you must supply a valid directory on your webserver, and ensure that the webserver has rights to write into that folder/directory.');
    
  break;
  case ('63'):
    define('POPUP_ERROR_HEADING', 'The Session/SQL Cache Directory entry is not writeable');
    define('POPUP_ERROR_TEXT', 'If you wish to use file caching for Session/SQL queries, you must supply a valid directory on your webserver, and ensure that the webserver has rights to write into that folder/directory.  CHMOD 666 or 777 is advisable under Linux/Unix.  Read/Write is suitable under Windows servers.');
    
  break;
  case ('64'):
    define('POPUP_ERROR_HEADING', 'Do you want to link to a phpBB forum on your site?');
    define('POPUP_ERROR_TEXT', 'If you wish to connect your Zen Cart store to an existing phpBB forum, select Yes here.');
    
  break;
  case ('65'):
    define('POPUP_ERROR_HEADING', 'phpBB Database Table-Prefix');
    define('POPUP_ERROR_TEXT', 'Please supply the table-prefix for your phpBB tables in the database where they are located. This is usually \'phpBB_\'');
    
  break;
  case ('66'):
    define('POPUP_ERROR_HEADING', 'phpBB Database Name');
    define('POPUP_ERROR_TEXT', 'Please supply the database name where your phpBB tables are located.');
  break;
  case ('67'):
    define('POPUP_ERROR_HEADING', 'phpBB Directory');
    define('POPUP_ERROR_TEXT', 'Please supply the full/complete path to where your phpBB script files are stored. This will allow Zen Cart to know what path to direct users to when they click on the phpBB link in your store.<br /><br />The path entered here is relative to the "root" of your server. So, if your phpBB installation is in <strong>/home/users/username/public_html/phpbb </strong>, then you need to enter <strong>/home/users/username/public_html/phpbb/ </strong>here. If it is under another set of subfolders, you need to list those folders in the path.<br /><br />We will look to find your "<em>config.php</em>" file in that folder.');
  break;
  case ('68'):
    define('POPUP_ERROR_HEADING', 'phpBB Directory');
    define('POPUP_ERROR_TEXT', 'No phpBB configure file could be found in the directory you specified. You must already have installed phpBB if you wish to use this automatic configuration. Otherwise you will have to skip automatic phpBB configuration and set it up manually later.<br /><br />The path entered here is relative to the "root" of your server. So, if your phpBB installation is in <strong>/home/users/username/public_html/phpbb </strong>, then you need to enter <strong>/home/users/username/public_html/phpbb/ </strong>here. If it is under another set of subfolders, you need to list those folders in the path.<br /><br />We will look to find your "<em>config.php</em>" file in that folder.');
  break;
  case ('69'):
    define('POPUP_ERROR_HEADING', 'Register Globals');
    define('POPUP_ERROR_TEXT', 'Zen Cart can work with the "Register Globals" setting on or off.  However, having it "off" leaves your system somewhat more secure.');
  break;
  case ('70'):
    define('POPUP_ERROR_HEADING', 'Safe Mode is On');
    define('POPUP_ERROR_TEXT', 'Zen Cart, being a full-service e-Commerce application, does not work well on servers running in Safe Mode.<br /><br />To run an e-Commerce system requires many advanced services often restricted on lower-cost "shared" hosting services. To run your online store in optimum fashion will require setting up a webhosting service that does not place you or your webspace in "Safe Mode".  You need your hosting company to set "SAFE_MODE=OFF" in your php.ini file.');
  break;
  case ('71'):
    define('POPUP_ERROR_HEADING', 'Cache folder required to use file-based caching support');
    define('POPUP_ERROR_TEXT', 'If you wish to use the "file-based SQL cache support" in Zen Cart, you\'ll need to set the proper permissions on the cache folder in your webspace.<br /><br />Optionally, you can choose "Database Caching" or "No Caching" if you prefer not to use the cache folder. In this case, you MAY need to disable "store sessions" as well, as the session tracker uses the file cache as well.<br /><br />To set up the cache folder properly, use your FTP program or shell access to your server to CHMOD the folder to 666 or 777 read-write permissions level.<br /><br />Most specifically, the userID of your webserver (ie: \'apache\' or \'www-user\' or maybe \'IUSR_something\' under Windows) must have all \'read-write-delete\' etc privileges to the cache folder.');
  break;
  case ('72'):
    define('POPUP_ERROR_HEADING', 'ERROR: Could not update all your configure.php files with new prefix');
    define('POPUP_ERROR_TEXT', 'While attempting to update your configure.php files after renaming tables, we encountered an error.  You will need to manually edit your /includes/configure.php and /admin/includes/configure.php files and ensure that the "define" for "DB_PREFIX" is set properly for your Zen Cart tables in your database.');
  break;
  case ('73'):
    define('POPUP_ERROR_HEADING', 'ERROR: Could not apply new table-prefix to all tables');
    define('POPUP_ERROR_TEXT', 'While attempting to rename your database tables with the new table prefix, we encountered an error.  You will need to manually review your database tablenames for accuracy. Worst-case, you may need to recover from your backup.');
  break;
  case ('74'):
    define('POPUP_ERROR_HEADING', 'NOTE: PHP "session.save_path" is not writable');
    define('POPUP_ERROR_TEXT', '<strong>This is JUST a note </strong>to inform you that you do not have permission to write to the path specified in the PHP session.save_path setting.<br /><br />This simply means that you cannot use this path setting for temporary file storage.  Instead, use the "suggested cache path" shown below it.');
  break;
  case ('75'):
    define('POPUP_ERROR_HEADING', 'NOTE: PHP "magic_quotes_runtime" is active');
    define('POPUP_ERROR_TEXT', 'It is best to have "magic_quotes_runtime" disabled. When enabled, it can cause unexpected 1064 SQL errors, and other code-execution problems.<br /><br />If you cannot disable it for the whole server, it may be possible to disable via .htaccess or your own php.ini file in your private webspace.  Talk to your hosting company for assistance.');
  break;
  case ('76'):
    define('POPUP_ERROR_HEADING', 'Database Engine version information unknown');
    define('POPUP_ERROR_TEXT', 'The version number of your database engine could not be obtained.<br /><br />This is NOT NECESSARILY a serious issue. In fact, it can be quite common on a production server, as at the stage of this inspection, we may not yet know the required security credentials in order to log in to your server, since those are obtained later in the installation process.<br /><br />It is generally safe to proceed even if this information is listed as Unknown.');
  break;
  case ('77'):
    define('POPUP_ERROR_HEADING', 'File Uploads are DISABLED');
    define('POPUP_ERROR_TEXT', 'File uploads are DISABLED. To enable them, make sure <em><strong>file_uploads = on</strong></em> is in your server\'s php.ini file.');
  break;



}

?>
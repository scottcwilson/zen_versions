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
// $Id: application_top.php 742 2004-12-08 15:42:13Z ajeh $
//

// start the timer for the page parse time log
  define('PAGE_PARSE_START_TIME', microtime());
//  define('DISPLAY_PAGE_PARSE_TIME', 'true');
// set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);

  ini_set("arg_separator.output","&");

// Set the local configuration parameters - mainly for developers
  if (file_exists('includes/local/configure.php')) {
    include('includes/local/configure.php');
  }
// include server parameters
  if (file_exists('includes/configure.php')) {
    include('includes/configure.php');
  }

// include the list of extra configure files
  if ($za_dir = @dir(DIR_WS_INCLUDES . 'extra_configures')) {
    while ($zv_file = $za_dir->read()) {
      if (strstr($zv_file, '.php')) {
        require(DIR_WS_INCLUDES . 'extra_configures/' . $zv_file);
      }
    }
  }


// determine install status
  if (( (!file_exists('includes/configure.php') && !file_exists('includes/local/configure.php')) ) || (DB_TYPE == '') || (!file_exists('includes/classes/db/' .DB_TYPE . '/query_factory.php'))) {
    header('location: zc_install/index.php');
    exit;
  }

  require('includes/classes/db/' .DB_TYPE . '/query_factory.php');
  $db = new queryFactory();
  if ( (!$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, USE_PCONNECT, false)) && (file_exists('zc_install/index.php')) ) {
    header('location: zc_install/index.php');
    exit;
  };

// Define the project version  (must come after DB class is loaded)
  require(DIR_WS_INCLUDES . 'version.php');

// set the type of request (secure or not)
  $request_type = ($_SERVER['HTTPS'] == 'on') ? 'SSL' : 'NONSSL';

// set php_self in the local scope
  if (!isset($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];

// include the list of project filenames
  require(DIR_WS_INCLUDES . 'filenames.php');

// include the list of project database tables
  require(DIR_WS_INCLUDES . 'database_tables.php');

// include the list of compatibility issues
  require(DIR_WS_FUNCTIONS . 'compatibility.php');

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
  require(DIR_WS_CLASSES . 'cache.php');
  $zc_cache = new cache;

  $configuration = $db->Execute('select configuration_key as cfgkey, configuration_value as cfgvalue
                                 from ' . TABLE_CONFIGURATION, '', true, 150);

  while (!$configuration->EOF) {
//    define($configuration->fields['cfgkey'], $configuration->fields['cfgvalue']);
    define($configuration->fields['cfgkey'], $configuration->fields['cfgvalue']);
//    echo $configuration->fields['cfgkey'] . '#';
    $configuration->MoveNext();
  }
  $configuration = $db->Execute('select configuration_key as cfgkey, configuration_value as cfgvalue
                          from ' . TABLE_PRODUCT_TYPE_LAYOUT);

  while (!$configuration->EOF) {
    define($configuration->fields['cfgkey'], $configuration->fields['cfgvalue']);
    $configuration->movenext();
  }

// Load the database dependant query defines
  if (file_exists(DIR_WS_CLASSES . 'db/' . DB_TYPE . '/define_queries.php')) {
    include(DIR_WS_CLASSES . 'db/' . DB_TYPE . '/define_queries.php');
  }

// sniffer class
  require(DIR_WS_CLASSES . 'sniffer.php');
  $sniffer = new sniffer;

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

// set the HTTP GET parameters manually if search_engine_friendly_urls is enabled
  if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
    if (strlen($_SERVER['REQUEST_URI']) > 1) {
      $GET_array = array();
      $PHP_SELF = $_SERVER['SCRIPT_NAME'];
      $vars = explode('/', substr($_SERVER['REQUEST_URI'], 1));
      for ($i=0, $n=sizeof($vars); $i<$n; $i++) {
        if (strpos($vars[$i], '[]')) {
          $GET_array[substr($vars[$i], 0, -2)][] = $vars[$i+1];
        } else {
          $_GET[$vars[$i]] = $vars[$i+1];
        }
        $i++;
      }

      if (sizeof($GET_array) > 0) {
        while (list($key, $value) = each($GET_array)) {
          $_GET[$key] = $value;
        }
      }
    }
  }

// define general functions used application-wide
//  require(DIR_WS_FUNCTIONS . 'general.php');
  require(DIR_WS_FUNCTIONS . 'functions_general.php');
  require(DIR_WS_FUNCTIONS . 'html_output.php');
  require(DIR_WS_FUNCTIONS . 'functions_email.php');

// load extra functions
  include(DIR_WS_MODULES . 'extra_functions.php');

// set the top level domains
  $http_domain = zen_get_top_level_domain(HTTP_SERVER);
  $https_domain = zen_get_top_level_domain(HTTPS_SERVER);
  $current_domain = (($request_type == 'NONSSL') ? $http_domain : $https_domain);
  if (SESSION_USE_FQDN == 'False') $current_domain = '.' . $current_domain;

// include cache functions if enabled
  if (USE_CACHE == 'true') include(DIR_WS_FUNCTIONS . 'cache.php');


// include shopping cart class
  require(DIR_WS_CLASSES . 'shopping_cart.php');


// include navigation history class
  require(DIR_WS_CLASSES . 'navigation_history.php');

// define how the session functions will be used
  require(DIR_WS_FUNCTIONS . 'sessions.php');

// set the session name and save path
  zen_session_name('zenid');
  zen_session_save_path(SESSION_WRITE_DIRECTORY);

// set the session cookie parameters
    session_set_cookie_params(0, '/', (zen_not_null($current_domain) ? $current_domain : ''));

// set the session ID if it exists
   if (isset($_POST[zen_session_name()])) {
     zen_session_id($_POST[zen_session_name()]);
   } elseif ( ($request_type == 'SSL') && isset($_GET[zen_session_name()]) ) {
     zen_session_id($_GET[zen_session_name()]);
   }

// start the session
  $session_started = false;
  if (SESSION_FORCE_COOKIE_USE == 'True') {
    zen_setcookie('cookie_test', 'please_accept_for_session', time()+60*60*24*30, '/', (zen_not_null($current_domain) ? $current_domain : ''));

    if (isset($_COOKIE['cookie_test'])) {
      zen_session_start();
      $session_started = true;
    }
  } elseif (SESSION_BLOCK_SPIDERS == 'True') {
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $spider_flag = false;

    if (zen_not_null($user_agent)) {
      $spiders = file(DIR_WS_INCLUDES . 'spiders.txt');

      for ($i=0, $n=sizeof($spiders); $i<$n; $i++) {
        if (zen_not_null($spiders[$i])) {
          if (is_integer(strpos($user_agent, trim($spiders[$i])))) {
            $spider_flag = true;
            break;
          }
        }
      }
    }

    if ($spider_flag == false) {
      zen_session_start();
      $session_started = true;
    }
  } else {
    zen_session_start();
    $session_started = true;
  }

// set host_address once per session to reduce load on server
  if (!$_SESSION['customers_host_address']) {
    $_SESSION['customers_host_address']= gethostbyaddr($_SERVER['REMOTE_ADDR']);
  }

// verify the ssl_session_id if the feature is enabled
  if ( ($request_type == 'SSL') && (SESSION_CHECK_SSL_SESSION_ID == 'True') && (ENABLE_SSL == 'true') && ($session_started == true) ) {
    $ssl_session_id = $_SERVER['SSL_SESSION_ID'];
    if (!$_SESSION['SSL_SESSION_ID']) {
      $_SESSION['SESSION_SSL_ID'] = $ssl_session_id;
    }

    if ($_SESSION['SESSION_SSL_ID'] != $ssl_session_id) {
      zen_session_destroy();
      zen_redirect(zen_href_link(FILENAME_SSL_CHECK));
    }
  }

// verify the browser user agent if the feature is enabled
  if (SESSION_CHECK_USER_AGENT == 'True') {
    $http_user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (!$_SESSION['SESSION_USER_AGENT']) {
      $_SESSION['SESSION_USER_AGENT'] = $http_user_agent;
    }

    if ($_SESSION['SESSION_USER_AGENT'] != $http_user_agent) {
      zen_session_destroy();
      zen_redirect(zen_href_link(FILENAME_LOGIN));
    }
  }

// verify the IP address if the feature is enabled
  if (SESSION_CHECK_IP_ADDRESS == 'True') {
    $ip_address = zen_get_ip_address();
    if (!$_SESSION['SESSION_IP_ADDRESS']) {
      $_SESSION['SESSION_IP_ADDRESS'] = $ip_address;
    }

    if ($_SESSION['SESSION_IP_ADDRESS'] != $ip_address) {
      zen_session_destroy();
      zen_redirect(zen_href_link(FILENAME_LOGIN));
    }
  }

// create the shopping cart & fix the cart if necesary
  if (!$_SESSION['cart']) {
    $_SESSION['cart'] = new shoppingCart;
  }


// include currencies class and create an instance
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

// include the mail classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');

// set the language
  if (!$_SESSION['language'] || isset($_GET['language'])) {

    require(DIR_WS_CLASSES . 'language.php');

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
  $sql = "select template_dir
          from " . TABLE_TEMPLATE_SELECT .
         " where template_language = '0'";

  $template_query = $db->Execute($sql);

  $template_dir = $template_query->fields['template_dir'];

  $sql = "select template_dir
          from " . TABLE_TEMPLATE_SELECT .
         " where template_language = '" . $_SESSION['languages_id'] . "'";

  $template_query = $db->Execute($sql);

  if ($template_query->RecordCount() > 0) {
      $template_dir = $template_query->fields['template_dir'];
  }
//if (template_switcher_available=="YES") $template_dir = templateswitch_custom($current_domain);
  define('DIR_WS_TEMPLATE', DIR_WS_TEMPLATES . $template_dir . '/');

  define('DIR_WS_TEMPLATE_IMAGES', DIR_WS_TEMPLATE . 'images/');
  define('DIR_WS_TEMPLATE_ICONS', DIR_WS_TEMPLATE_IMAGES . 'icons/');

  require(DIR_WS_CLASSES . 'template_func.php');
  $template = new template_func(DIR_WS_TEMPLATE);

// include the language translations
// include template specific language files
  if (file_exists(DIR_WS_LANGUAGES . $template_dir . '/' . $_SESSION['language'] . '.php')) {
    $template_dir_select = $template_dir . '/';
//die('Yes ' . DIR_WS_LANGUAGES . $template_dir . '/' . $_SESSION['language'] . '.php');
  } else {
//die('NO ' . DIR_WS_LANGUAGES . $template_dir . '/' . $_SESSION['language'] . '.php');
    $template_dir_select = '';
  }


  require(DIR_WS_LANGUAGES . $template_dir_select . $_SESSION['language'] . '.php');

// include the extra language translations
  include(DIR_WS_MODULES . 'extra_definitions.php');

// currency
  if (!$_SESSION['currency'] || isset($_GET['currency']) || ( (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') && (LANGUAGE_CURRENCY != $_SESSION['currency']) ) ) {
    if (isset($_GET['currency'])) {
      if (!$_SESSION['currency'] = zen_currency_exists($_GET['currency'])) $_SESSION['currency'] = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
    } else {
      $_SESSION['currency'] = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
    }
  }

// Sanitize get parameters in the url
  if (isset($_GET['products_id'])) $_GET['products_id'] = ereg_replace('[^0-9a-f:]', '', $_GET['products_id']);
  if (isset($_GET['manufacturers_id'])) $_GET['manufacturers_id'] = ereg_replace('[^0-9]', '', $_GET['manufacturers_id']);
  if (isset($_GET['cPath'])) $_GET['cPath'] = ereg_replace('[^0-9_]', '', $_GET['cPath']);
  if (isset($_GET['main_page'])) $_GET['main_page'] = ereg_replace('[^0-9a-zA-Z_]', '', $_GET['main_page']);
  while (list($key, $value) = each($_GET)) {
    $_GET[$key] = ereg_replace('[<>]', '', $value);
  }

// validate products_id for search engines and bookmarks, etc.
  if (isset($_GET['products_id']) and $_SESSION['check_valid'] != 'false') {
    $check_valid = zen_products_id_valid($_GET['products_id']);
    if (!$check_valid) {
      $_GET['main_page'] = zen_get_info_page($_GET['products_id']);
      // do not recheck redirect
      $_SESSION['check_valid'] = 'false';
      zen_redirect(zen_href_link($_GET['main_page'], 'products_id=' . $_GET['products_id']));
    }
  } else {
    $_SESSION['check_valid'] = 'true';
  }

// navigation history
  if (!isset($_SESSION['navigation'])) {
    $_SESSION['navigation'] = new navigationHistory;
  }
  $_SESSION['navigation']->add_current_page();
// Down for maintenance module
  if (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])){
//  if (EXCLUDE_ADMIN_IP_FOR_MAINTENANCE != $_SERVER['REMOTE_ADDR']){
    if (DOWN_FOR_MAINTENANCE=='true' and $_GET['main_page'] != DOWN_FOR_MAINTENANCE_FILENAME) zen_redirect(zen_href_link(DOWN_FOR_MAINTENANCE_FILENAME));
  }

// do not let people get to down for maintenance page if not turned on
  if (DOWN_FOR_MAINTENANCE=='false' and $_GET['main_page'] == DOWN_FOR_MAINTENANCE_FILENAME) {
    zen_redirect(zen_href_link(FILENAME_DEFAULT));
  }

// customer login status
// 0 = normal shopping
// 1 = Login to shop
// 2 = Can browse but no prices
// verify display of prices
  switch (true) {
    case (DOWN_FOR_MAINTENANCE == 'true'):
// if not down for maintenance check login status
      break;
    case ($_GET['main_page'] == FILENAME_LOGOFF):
      break;
    case (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == ''):
    // customer must be logged in to browse
//die('I see ' . $_GET['main_page'] . ' vs ' . FILENAME_LOGIN);
      if ($_GET['main_page'] != FILENAME_LOGIN and $_GET['main_page'] != FILENAME_CREATE_ACCOUNT ) {
        if (!isset($_GET['set_session_login'])) {
          $_GET['set_session_login'] = 'true';
          $_SESSION['navigation']->set_snapshot();
        }
        zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
      }
      break;
    case (CUSTOMERS_APPROVAL == '2' and $_SESSION['customer_id'] == ''):
    // customer may browse but no prices
      break;
    default:
    // proceed normally
      break;
    }


// customer authorization status
// 0 = normal shopping
// 1 = customer authorization to shop
// 2 = customer authorization pending can browse but no prices
// verify display of prices
  switch (true) {
    case (DOWN_FOR_MAINTENANCE == 'true'):
// if not down for maintenance check login status
      break;
    case ($_GET['main_page'] == FILENAME_LOGOFF or $_GET['main_page'] == FILENAME_PRIVACY or $_GET['main_page'] == FILENAME_PASSWORD_FORGOTTEN or $_GET['main_page'] == FILENAME_CONTACT_US or $_GET['main_page'] == FILENAME_CONDITIONS or $_GET['main_page'] == FILENAME_SHIPPING or $_GET['main_page'] == FILENAME_UNSUBSCRIBE):
      break;
    case (CUSTOMERS_APPROVAL_AUTHORIZATION == '1' and $_SESSION['customer_id'] == ''):
    // customer must be logged in to browse
      if ($_GET['main_page'] != FILENAME_LOGIN and $_GET['main_page'] != FILENAME_CREATE_ACCOUNT ) {
        if (!isset($_GET['set_session_login'])) {
          $_GET['set_session_login'] = 'true';
          $_SESSION['navigation']->set_snapshot();
        }
        zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
      }
      break;
    case (CUSTOMERS_APPROVAL_AUTHORIZATION == '2' and $_SESSION['customer_id'] == ''):
    // customer must be logged in to browse
/*
      if ($_GET['main_page'] != FILENAME_LOGIN and $_GET['main_page'] != FILENAME_CREATE_ACCOUNT ) {
        if (!isset($_GET['set_session_login'])) {
          $_GET['set_session_login'] = 'true';
          $_SESSION['navigation']->set_snapshot();
        }
        zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
      }
*/
      break;
    case (CUSTOMERS_APPROVAL_AUTHORIZATION == '1' and $_SESSION['customers_authorization'] != '0'):
    // customer is pending approval
    // customer must be logged in to browse
      if ($_GET['main_page'] != CUSTOMERS_AUTHORIZATION_FILENAME) {
        zen_redirect(zen_href_link(CUSTOMERS_AUTHORIZATION_FILENAME));
      }
      break;
    case (CUSTOMERS_APPROVAL_AUTHORIZATION == '2' and $_SESSION['customers_authorization'] != '0'):
    // customer may browse but no prices
      break;
    default:
    // proceed normally
      break;
    }

// infobox
  require(DIR_WS_CLASSES . 'boxes.php');

// initialize the message stack for output messages
  require(DIR_WS_CLASSES . 'message_stack.php');
  $messageStack = new messageStack;

// Shopping cart actions
  if (isset($_GET['action'])) {
// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
    if ($session_started == false) {
      zen_redirect(zen_href_link(FILENAME_COOKIE_USAGE));
    }

    if (DISPLAY_CART == 'true') {
      $goto =  FILENAME_SHOPPING_CART;
      $parameters = array('action', 'cPath', 'products_id', 'pid', 'main_page');
    } else {
      $goto = $_GET['main_page'];
      if ($_GET['action'] == 'buy_now') {
        $parameters = array('action');
      } else {
        $parameters = array('action', 'pid', 'main_page');
      }
    }
    switch ($_GET['action']) {
      // customer wants to update the product quantity in their shopping cart
      // delete checkbox or 0 quantity removes from cart
      case 'update_product' : for ($i=0, $n=sizeof($_POST['products_id']); $i<$n; $i++) {
                                $adjust_max= 'false';

//                                if ( in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array())) or $_POST['cart_quantity'][$i]==0) {
                                if ( in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array())) or $_POST['cart_quantity'][$i]==0) {
                                  $_SESSION['cart']->remove($_POST['products_id'][$i]);
                                } else {
                                  $add_max = zen_get_products_quantity_order_max($_POST['products_id'][$i]);
                                  $cart_qty = $_SESSION['cart']->in_cart_mixed($_POST['products_id']);
                                  $new_qty = $_POST['cart_quantity'][$i];
                                  if (($add_max == 1 and $cart_qty == 1)) {
                                    // do not add
                                    $adjust_max= 'true';
                                  } else {
                                    // adjust quantity if needed
                                    if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                                      $adjust_max= 'true';
                                      $new_qty = $add_max - $cart_qty;
                                    }
                                    $attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';
                                    $_SESSION['cart']->add_cart($_POST['products_id'][$i], $new_qty, $attributes, false);
                                  }
                                    if ($adjust_max == 'true') {
                                      $messageStack->add_session('header', ERROR_MAXIMUM_QTY . ' - ' . zen_get_products_name($_POST['products_id'][$i]), 'caution');
                                    }
                                }
                              }


                              zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
                              break;

// remove individual products from cart
      case 'remove_product': if (isset($_GET['product_id']) && zen_not_null($_GET['product_id'])) $_SESSION['cart']->remove($_GET['product_id']);
                             zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
                             break;
      // customer adds a product from the products page
      case 'add_product' :
                              if (isset($_POST['products_id']) && is_numeric($_POST['products_id'])) {
// verify attributes and quantity first
      $the_list = '';
      $adjust_max= 'false';
    if (isset($_POST['id'])) {
      while(list($key,$value) = each($_POST['id'])) {
        $check = zen_get_attributes_valid($_POST['products_id'], $key, $value);
        if ($check == false) {
          // zen_get_products_name($_POST['products_id']) .
          $the_list .= TEXT_ERROR_OPTION_FOR . '<span class="alertBlack">' . zen_options_name($key) . '</span>' . TEXT_INVALID_SELECTION_LABELED . '<span class="alertBlack">' . (zen_values_name($value) == 'TEXT' ? TEXT_INVALID_USER_INPUT : zen_values_name($value)) . '</span>' . '<br />';
        }
      }
    }

// verify qty to add
    $add_max = zen_get_products_quantity_order_max($_POST['products_id']);
    $cart_qty = $_SESSION['cart']->in_cart_mixed($_POST['products_id']);
    $new_qty = $_POST['cart_quantity'];
    if (($add_max == 1 and $cart_qty == 1)) {
      // do not add
      $new_qty = 0;
      $adjust_max= 'true';
    } else {
      // adjust quantity if needed
      if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
        $adjust_max= 'true';
        $new_qty = $add_max - $cart_qty;
      }
    }

  if ((zen_get_products_quantity_order_max($_POST['products_id']) == 1 and $_SESSION['cart']->in_cart_mixed($_POST['products_id']) == 1)) {
    // do not add
  } else {
    // process normally
// bof: set error message
      if ($the_list != '') {
        $messageStack->add('header', ERROR_CORRECTIONS_HEADING . $the_list, 'error');
      } else {
      // process normally

// iii 030813 added: File uploading: save uploaded files with unique file names
          $real_ids = $_POST['id'];
          if ($_GET['number_of_uploads'] > 0) {
            require(DIR_WS_CLASSES . 'upload.php');
            for ($i = 1, $n = $_GET['number_of_uploads']; $i <= $n; $i++) {
              if (zen_not_null($_FILES['id']['tmp_name'][TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]]) and ($_FILES['id']['tmp_name'][TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] != 'none')) {
                $products_options_file = new upload('id');
                $products_options_file->set_destination(DIR_FS_UPLOADS);
                if ($products_options_file->parse(TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i])) {
                  $products_image_extention = substr($products_options_file->filename, strrpos($products_options_file->filename, '.'));
                  if ($_SESSION['customer_id']) {
                    $db->Execute("insert into " . TABLE_FILES_UPLOADED . " (sesskey, customers_id, files_uploaded_name) values('" . zen_session_id() . "', '" . $_SESSION['customer_id'] . "', '" . zen_db_input($products_options_file->filename) . "')");
                  } else {
                    $db->Execute("insert into " . TABLE_FILES_UPLOADED . " (sesskey, files_uploaded_name) values('" . zen_session_id() . "', '" . zen_db_input($products_options_file->filename) . "')");
                  }
                  $insert_id = $db->Insert_ID();
                  $real_ids[TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] = $insert_id . ". " . $products_options_file->filename;
                  $products_options_file->set_filename("$insert_id" . $products_image_extention);
                  if (!($products_options_file->save())) {
                    break 2;
                  }
                } else {
                  break 2;
                }
              } else { // No file uploaded -- use previous value
                $real_ids[TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] = $_POST[TEXT_PREFIX . UPLOAD_PREFIX . $i];
              }
            }
          }

                                $_SESSION['cart']->add_cart($_POST['products_id'], $_SESSION['cart']->get_quantity(zen_get_uprid($_POST['products_id'], $real_ids))+($new_qty), $real_ids);
// iii 030813 end of changes.
        } // eof: set error message
      } // eof: quantity maximum = 1

      if ($adjust_max == 'true') {
        $messageStack->add_session('header', ERROR_MAXIMUM_QTY . ' - ' . zen_get_products_name($_POST['products_id']), 'caution');
      }
                            }
      if ($the_list == '') {
        // no errors
                              zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
      } else {
        // errors - display popup message
      }
                              break;
      // performed by the 'buy now' button in product listings and review page
      case 'buy_now' :        if (isset($_GET['products_id'])) {
                                if (zen_has_product_attributes($_GET['products_id'])) {
                                  zen_redirect(zen_href_link(zen_get_info_page($_GET['products_id']), 'products_id=' . $_GET['products_id']));
                                } else {

                                  $add_max = zen_get_products_quantity_order_max($_GET['products_id']);
                                  $cart_qty = $_SESSION['cart']->in_cart_mixed($_GET['products_id']);
                                  $new_qty = zen_get_buy_now_qty($_GET['products_id']);
                                  if (($add_max == 1 and $cart_qty == 1)) {
                                    // do not add
                                    $new_qty = 0;
                                  } else {
                                    // adjust quantity if needed
                                    if (($new_qty + $cart_qty > $add_max) and $add_max != 0) {
                                      $new_qty = $add_max - $cart_qty;
                                    }
                                  }

                                  if ((zen_get_products_quantity_order_max($_GET['products_id']) == 1 and $_SESSION['cart']->in_cart_mixed($_GET['products_id']) == 1)) {
                                    // do not add
                                  } else {
                                    // check for min/max and add that value or 1
                                    // $add_qty = zen_get_buy_now_qty($_GET['products_id']);
//                                    $_SESSION['cart']->add_cart($_GET['products_id'], $_SESSION['cart']->get_quantity($_GET['products_id'])+$add_qty);
                                    $_SESSION['cart']->add_cart($_GET['products_id'], $_SESSION['cart']->get_quantity($_GET['products_id'])+$new_qty);
                                  }
                                }
                              }
                              zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
                              break;
      case 'notify' :         if ($_SESSION['customer_id']) {
                                if (isset($_GET['products_id'])) {
                                  $notify = $_GET['products_id'];
                                } elseif (isset($_GET['notify'])) {
                                  $notify = $_GET['notify'];
                                } elseif (isset($_POST['notify'])) {
                                  $notify = $_POST['notify'];
                                } else {
                                  zen_redirect(zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action', 'notify', 'main_page'))));
                                }
                                if (!is_array($notify)) $notify = array($notify);
                                for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
                                  $check_query = "select count(*) as count
                                                  from " . TABLE_PRODUCTS_NOTIFICATIONS . "
                                                  where products_id = '" . $notify[$i] . "'
                                                  and customers_id = '" . $_SESSION['customer_id'] . "'";
                                  $check = $db->Execute($check_query);
                                  if ($check->fields['count'] < 1) {
                                    $sql = "insert into " . TABLE_PRODUCTS_NOTIFICATIONS . "
                                                            (products_id, customers_id, date_added)
                                            values ('" . $notify[$i] . "', '" . $_SESSION['customer_id'] . "', now())";
                                    $db->Execute($sql);
                                  }
                                }
                                zen_redirect(zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action', 'notify', 'main_page'))));
                              } else {
                                $_SESSION['navigation']->set_snapshot();
                                zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
                              }
                              break;
      case 'notify_remove' :  if ($_SESSION['customer_id'] && isset($_GET['products_id'])) {
                                $check_query = "select count(*) as count
                                                from " . TABLE_PRODUCTS_NOTIFICATIONS . "
                                                where products_id = '" . $_GET['products_id'] . "'
                                                and customers_id = '" . $_SESSION['customer_id'] . "'";

                                $check = $db->Execute($check_query);
                                if ($check->fields['count'] > 0) {
                                  $sql = "delete from " . TABLE_PRODUCTS_NOTIFICATIONS . "
                                          where products_id = '" . $_GET['products_id'] . "'
                                          and customers_id = '" . $_SESSION['customer_id'] . "'";
                                  $db->Execute($sql);
                                }
                                zen_redirect(zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action', 'main_page'))));
                              } else {
                                $_SESSION['navigation']->set_snapshot();
                                zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
                              }
                              break;
      case 'cust_order' :     if ($_SESSION['customer_id'] && isset($_GET['pid'])) {
                                if (zen_has_product_attributes($_GET['pid'])) {
                                  zen_redirect(zen_href_link(zen_get_info_page($_GET['pid']), 'products_id=' . $_GET['pid']));
                                } else {
                                  $db->Execute("delete from " . TABLE_WISHLIST . " where products_id = '" . $_GET['pid'] . "' and customers_id = '" . $_SESSION['customer_id'] . "'");
                                  $_SESSION['cart']->add_cart($_GET['pid'], $_SESSION['cart']->get_quantity($_GET['pid'])+1);
                                }
                              }
                              zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
                              break;
 // Add product to the wishlist

      case 'add_wishlist' :  if (ereg('^[0-9]+$', $_POST['products_id'])) {
                               if  ($_POST['products_id']) {
                                 $db->Execute("delete from " . TABLE_WISHLIST . " where products_id = '" . $_GET['products_id'] . "' and customers_id = '" . $_SESSION['customer_id'] . "'");
                                 $db->Execute("insert into " . TABLE_WISHLIST . " (customers_id, products_id, products_model, products_name, products_price) values ('" . $_SESSION['customer_id'] . "', '" . $_POST['products_id'] . "', '" . $products_model . "', '" . $products_name . "', '" . $products_price . "' )");
                               }
                             }

                             zen_redirect(zen_href_link(FILENAME_WISHLIST));
        break;
     // Add wishlist item to the cart

case 'wishlist_add_cart': reset ($lvnr);
                           reset ($lvanz);
                                 while (list($key,$elem) =each ($lvnr))
                                       {
                                        (list($key1,$elem1) =each ($lvanz));
                                        $db->Execute("update " . TABLE_WISHLIST . " SET products_quantity=$elem1 WHERE customers_id= '" . $_SESSION['customer_id'] . "' AND products_id=$elem");
                                        $db->Execute("delete from " . TABLE_WISHLIST . " WHERE customers_id= '" . $_SESSION['customer_id'] . "' AND products_quantity='999'");
                                        $products_in_wishlist = $db->Execute("select * from " . TABLE_WISHLIST . " WHERE customers_id= '" . $_SESSION['customer_id'] . "' AND products_id = $elem AND products_quantity <> '0'");

                                        while (!$products_in_wishlist->EOF)
                                              {
                                               $cart->add_cart($products_in_wishlist->fields['products_id'], $products_in_wishlist->fields['products_quantity']);
                                               }
                                        }
                                  reset ($lvanz);
                              zen_redirect(zen_href_link(FILENAME_WISHLIST));
                              break;


// remove item from the wishlist
///// CHANGES TO case 'remove_wishlist' BY DREAMSCAPE /////
      case 'remove_wishlist' :
                             $db->Execute("delete from " . TABLE_WISHLIST . " where products_id = '" . $HTTP_GET_VARS['pid'] . "' and customers_id = '" . $_SESSION['customer_id'] . "'");
                            zen_redirect(zen_href_link(FILENAME_WISHLIST));
                             break;
    }
  }

// include the who's online functions
  require(DIR_WS_FUNCTIONS . 'whos_online.php');
  zen_update_whos_online();

// include the password crypto functions
  require(DIR_WS_FUNCTIONS . 'password_funcs.php');

// include validation functions (right now only email address)
  require(DIR_WS_FUNCTIONS . 'validations.php');

// split-page-results
  require(DIR_WS_CLASSES . 'split_page_results.php');

// auto activate and expire banners
  require(DIR_WS_FUNCTIONS . 'banner.php');
  zen_activate_banners();
  zen_expire_banners();

// auto expire special products
  require(DIR_WS_FUNCTIONS . 'specials.php');
  zen_start_specials();
  zen_expire_specials();

// auto expire featured products
  require(DIR_WS_FUNCTIONS . 'featured.php');
  zen_start_featured();
  zen_expire_featured();

// auto expire salemaker sales
  require(DIR_WS_FUNCTIONS . 'salemaker.php');
  zen_start_salemaker();
  zen_expire_salemaker();

// calculate category path
  if (isset($_GET['cPath'])) {
    $cPath = $_GET['cPath'];
  } elseif (isset($_GET['products_id']) && !zen_check_url_get_terms()) {
//  } elseif (isset($_GET['products_id']) && !isset($_GET['manufacturers_id']) && !isset($_GET['music_genres_id'])) {
    $cPath = zen_get_product_path($_GET['products_id']);
  } else {
    if (SHOW_CATEGORIES_ALWAYS == '1' && !zen_check_url_get_terms()) {
      $show_welcome = 'true';
      $cPath = (defined('CATEGORIES_START_MAIN') ? CATEGORIES_START_MAIN : '');
    } else {
      $show_welcome = 'false';
      $cPath = '';
    }
  }

  if (zen_not_null($cPath)) {
    $cPath_array = zen_parse_category_path($cPath);
    $cPath = implode('_', $cPath_array);
    $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  } else {
    $current_category_id = 0;
    $cPath_array = array();
  }

// include the breadcrumb class and start the breadcrumb trail
  require(DIR_WS_CLASSES . 'breadcrumb.php');
  $breadcrumb = new breadcrumb;

  $breadcrumb->add(HEADER_TITLE_CATALOG, zen_href_link(FILENAME_DEFAULT));

// add category names or the manufacturer name to the breadcrumb trail
  if (isset($cPath_array)) {
    for ($i=0, $n=sizeof($cPath_array); $i<$n; $i++) {
      $categories_query = "select categories_name
                           from " . TABLE_CATEGORIES_DESCRIPTION . "
                           where categories_id = '" . (int)$cPath_array[$i] . "'
                           and language_id = '" . (int)$_SESSION['languages_id'] . "'";

      $categories = $db->Execute($categories_query);

      if ($categories->RecordCount() > 0) {
        $breadcrumb->add($categories->fields['categories_name'], zen_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
      } else {
        break;
      }
    }
  }

// split to add manufacturers_name to the display
  if (isset($_GET['manufacturers_id'])) {
    $manufacturers_query = "select manufacturers_name
                            from " . TABLE_MANUFACTURERS . "
                            where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";

    $manufacturers = $db->Execute($manufacturers_query);

    if ($manufacturers->RecordCount() > 0) {
      $breadcrumb->add($manufacturers->fields['manufacturers_name'], zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $_GET['manufacturers_id']));
    }
  }

// add the products model to the breadcrumb trail
  if (isset($_GET['products_id'])) {
    $productname_query = "select products_name
                   from " . TABLE_PRODUCTS_DESCRIPTION . "
                   where products_id = '" . (int)$_GET['products_id'] . "'
             and language_id = '" . $_SESSION['languages_id'] . "'";

    $productname = $db->Execute($productname_query);

    if ($productname->RecordCount() > 0) {
      $breadcrumb->add($productname->fields['products_name'], zen_href_link(zen_get_info_page($_GET['products_id']), 'cPath=' . $cPath . '&products_id=' . $_GET['products_id']));
    }
  }

  require(DIR_WS_CLASSES . 'category_tree.php');

// set which precautions should be checked
  define('WARN_INSTALL_EXISTENCE', 'true');
  define('WARN_CONFIG_WRITEABLE', 'true');
  define('WARN_SESSION_DIRECTORY_NOT_WRITEABLE', 'true');
  define('WARN_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'true');
  define('WARN_SESSION_AUTO_START', 'true');
  define('WARN_DOWNLOAD_DIRECTORY_NOT_READABLE', 'true');
?>
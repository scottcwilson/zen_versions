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
// $Id: header_php.php 408 2004-10-09 22:08:18Z wilt $
//
// if the customer is not logged on, redirect them to the shopping cart page
  if (!$_SESSION['customer_id']) {
    zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
  }

/*
// ORIGINAL CODE
  if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
    $notify_string = 'action=notify&';
    $notify = $_POST['notify'];
    if (!is_array($notify)) $notify = array($notify);
    for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
      $notify_string .= 'notify[]=' . $notify[$i] . '&';
    }
    if (strlen($notify_string) > 0) $notify_string = substr($notify_string, 0, -1);

    zen_redirect(zen_href_link(FILENAME_DEFAULT, $notify_string));
  }

*/

// MODIFIED TO WORK UNLESS NOTIFY IS CHECKED ... SEE RESULTS OF DIE()
  $notify_string='';
  if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
    $notify_string = 'action=notify&';
    $notify = $_POST['notify'];
//    if (!is_array($notify)) $notify = array($notify);

    if (is_array($notify)) {
      for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
        $notify_string .= 'notify[]=' . $notify[$i] . '&';
      }
      if (strlen($notify_string) > 0) $notify_string = substr($notify_string, 0, -1);
    }
    if ($notify_string == 'action=notify&') {
      zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'SSL'));
    } else {
      zen_redirect(zen_href_link(FILENAME_DEFAULT, $notify_string));
    }
  }


  require(DIR_WS_MODULES . 'require_languages.php');
  $breadcrumb->add(NAVBAR_TITLE_1);
  $breadcrumb->add(NAVBAR_TITLE_2);

  $global_query = "select global_product_notifications from " . TABLE_CUSTOMERS_INFO . "
                   where customers_info_id = '" . (int)$_SESSION['customer_id'] . "'";

  $global = $db->Execute($global_query);

  if ($global->fields['global_product_notifications'] != '1') {
    $orders_query = "select orders_id from " . TABLE_ORDERS . "
                     where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                     order by date_purchased desc limit 1";

    $orders = $db->Execute($orders_query);

    $products_array = array();

    $products_query = "select products_id, products_name from " . TABLE_ORDERS_PRODUCTS . "
                       where orders_id = '" . (int)$orders->fields['orders_id'] . "'
                       order by products_name";

    $products = $db->Execute($products_query);

    while (!$products->EOF) {
      $products_array[] = array('id' => $products->fields['products_id'],
                                'text' => $products->fields['products_name']);
      $products->MoveNext();
    }
  } else {
    $orders_query = "select orders_id from " . TABLE_ORDERS . "
                     where customers_id = '" . (int)$_SESSION['customer_id'] . "'
                     order by date_purchased desc limit 1";

    $orders = $db->Execute($orders_query);
  }

// include template specific file name defines
  $define_checkout_success = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CHECKOUT_SUCCESS, 'false');
?>

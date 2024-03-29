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
// $Id: order_history.php 290 2004-09-15 19:48:26Z wilt $
//

  if ($_SESSION['customer_id']) {
// retreive the last x products purchased
  $orders_query = "select distinct op.products_id
                   from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p
                   where o.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                   and o.orders_id = op.orders_id
                   and op.products_id = p.products_id
                   and p.products_status = '1'
                   group by products_id
                   order by o.date_purchased desc
                   limit " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX;

    $orders = $db->Execute($orders_query);

    if ($orders->RecordCount() > 0) {
      $product_ids = '';
      while (!$orders->EOF) {
        $product_ids .= (int)$orders->fields['products_id'] . ',';
        $orders->MoveNext();
      }
      $product_ids = substr($product_ids, 0, -1);
      $rows=0;
      $customer_orders_string = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
      $products_query = "select products_id, products_name
                         from " . TABLE_PRODUCTS_DESCRIPTION . "
                         where products_id in (" . $product_ids . ")
                         and language_id = '" . (int)$_SESSION['languages_id'] . "'
                         order by products_name";

      $products = $db->Execute($products_query);

      while (!$products->EOF) {
        $rows++;
        $customer_orders[$rows]['id'] = $products->fields['products_id'];
        $customer_orders[$rows]['name'] = $products->fields['products_name'];
        $products->MoveNext();
      }
      $customer_orders_string .= '</table>';

      require($template->get_template_dir('tpl_order_history.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_order_history.php');
      $title =  BOX_HEADING_CUSTOMER_ORDERS;
      $left_corner = false;
      $right_corner = false;
      $right_arrow = false;
      $title_link = false;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
    }
  }
?>
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
// $Id: blk_previous_orders.php 530 2004-11-10 19:35:44Z wilt $
//
  $orders_query = "select o.orders_id, o.date_purchased, o.delivery_name,
                          o.delivery_country, o.billing_name, o.billing_country,
                          ot.text as order_total, s.orders_status_name
                   from   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " .
                              TABLE_ORDERS_STATUS . " s
                   where  o.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                   and    o.orders_id = ot.orders_id
                   and    ot.class = 'ot_total'
                   and    o.orders_status = s.orders_status_id
                   and    s.language_id = '" . (int)$_SESSION['languages_id'] . "'
                   order by orders_id desc limit 3";

  $orders = $db->Execute($orders_query);

  while (!$orders->EOF) {
    if (zen_not_null($orders->fields['delivery_name'])) {
      $order_name = $orders->fields['delivery_name'];
      $order_country = $orders->fields['delivery_country'];
    } else {
      $order_name = $orders->fields['billing_name'];
      $order_country = $orders->fields['billing_country'];
    }
    require($template->get_template_dir('tpl_block_previous_orders.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_block_previous_orders.php');
    $orders->MoveNext();
  }
?>
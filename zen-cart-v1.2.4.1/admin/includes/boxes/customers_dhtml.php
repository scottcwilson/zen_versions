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
//  $Id: customers_dhtml.php 754 2004-12-10 01:55:11Z wilt $
//
  $za_contents = array();
  $za_heading = array();
  $za_heading = array('text' => BOX_HEADING_CUSTOMERS, 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CUSTOMERS_CUSTOMERS, 'link' => zen_href_link(FILENAME_CUSTOMERS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CUSTOMERS_ORDERS, 'link' => zen_href_link(FILENAME_ORDERS, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CUSTOMERS_GROUP_PRICING, 'link' => zen_href_link(FILENAME_GROUP_PRICING, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_CUSTOMERS_PAYPAL, 'link' => zen_href_link(FILENAME_PAYPAL, '', 'NONSSL'));
if ($za_dir = @dir(DIR_WS_BOXES . 'extra_boxes')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/customers_dhtml.php$/', $zv_file)) {
      require(DIR_WS_BOXES . 'extra_boxes/' . $zv_file);
    }
  }
}
?>
<!-- customers //-->
<?php
echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- customers_eof //-->

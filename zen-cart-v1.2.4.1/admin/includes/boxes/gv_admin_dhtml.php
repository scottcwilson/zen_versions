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
//  $Id: gv_admin_dhtml.php 290 2004-09-15 19:48:26Z wilt $
//
  $za_contents = array();
  $za_heading = array();
  $za_heading = array('text' => BOX_HEADING_GV_ADMIN, 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));

// don't Coupons unless installed
if (MODULE_ORDER_TOTAL_COUPON_STATUS=='true') {
  $za_contents[] = array('text' => BOX_COUPON_ADMIN, 'link' => zen_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL'));
 } // coupons installed

// don't Gift Vouchers unless installed
if (MODULE_ORDER_TOTAL_GV_STATUS=='true') {
  $za_contents[] = array('text' => BOX_GV_ADMIN_QUEUE, 'link' => zen_href_link(FILENAME_GV_QUEUE, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_GV_ADMIN_MAIL, 'link' => zen_href_link(FILENAME_GV_MAIL, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_GV_ADMIN_SENT, 'link' => zen_href_link(FILENAME_GV_SENT, '', 'NONSSL'));
} // gift vouchers installed

// if both are off display msg
if (!defined('MODULE_ORDER_TOTAL_COUPON_STATUS') and !defined('MODULE_ORDER_TOTAL_GV_STATUS')) {
  $za_contents[] = array('text' => NOT_INSTALLED_TEXT, 'link' => '');
} // coupons and gift vouchers not installed
if ($za_dir = @dir(DIR_WS_BOXES . 'gv_admin_boxes')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/gv_admin_dhtml.php$/', $zv_file)) {
      require(DIR_WS_BOXES . 'extra_boxes/' . $zv_file);
    }
  }
}
?>
<!-- gv_admin //-->
<?php
echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- gv_admin_eof //-->

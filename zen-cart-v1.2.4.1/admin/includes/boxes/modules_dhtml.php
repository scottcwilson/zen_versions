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
//  $Id: modules_dhtml.php 290 2004-09-15 19:48:26Z wilt $
//
  $za_contents = array();
  $za_heading = array();
  $za_heading = array('text' => BOX_HEADING_MODULES, 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));
  $za_contents[] = array('text' => BOX_MODULES_PAYMENT, 'link' => zen_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL'));
  $za_contents[] = array('text' => BOX_MODULES_SHIPPING, 'link' => zen_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL'));
  $za_contents[] = array('text' => BOX_MODULES_ORDER_TOTAL, 'link' => zen_href_link(FILENAME_MODULES, 'set=ordertotal',  'NONSSL'));
if ($za_dir = @dir(DIR_WS_BOXES . 'extra_boxes')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/modules_dhtml.php$/', $zv_file)) {
      require(DIR_WS_BOXES . 'extra_boxes/' . $zv_file);
    }
  }
}
?>
<!-- modules //-->
<?php
echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- modules_eof //-->

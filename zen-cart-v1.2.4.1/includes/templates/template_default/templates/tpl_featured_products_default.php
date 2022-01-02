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
// $Id: tpl_featured_products_default.php 290 2004-09-15 19:48:26Z wilt $
//
?>

<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="breadCrumb" colspan="2"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></td>
  </tr>
  <tr>
    <td class="pageHeading" colspan="2"><h1><?php echo HEADING_TITLE; ?></h1></td>
  </tr>
<?php
// display order dropdown
  $disp_order_default = PRODUCT_FEATURED_LIST_SORT_DEFAULT;
  include(DIR_WS_MODULES . 'listing_display_order.php');
?>
<?php

  $featured_products_array = array();

  $featured_products_query_raw = "select p.products_id, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id, p.products_date_added, m.manufacturers_name, p.products_model, p.products_quantity, p.products_weight from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd
                                  left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                                  where p.products_status = '1' and p.products_id = f.products_id and f.status = '1'
                                  and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'" . $order_by;

  $featured_products_split = new splitPageResults($featured_products_query_raw, MAX_DISPLAY_PRODUCTS_FEATURED_PRODUCTS);

  if (($featured_products_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
  <tr>
    <td class="pageresults"><?php echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS); ?></td>
    <td align="right" class="pageresults"><?php echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></td>
  </tr>
<?php
  }
?>
  <tr>
    <td class="main" colspan="2"><?php include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_FEATURED_PRODUCTS_LISTING)); ?></td>
  </tr>
<?php
  if (($featured_products_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
  <tr>
    <td class="pageresults"><?php echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS); ?></td>
    <td align="right" class="pageresults"><?php echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></td>
  </tr>
<?php
  }
?>
</table>
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
// $Id: product_listing.php 290 2004-09-15 19:48:26Z wilt $
//
  $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right' . (PRODUCTS_LIST_PRICE_WIDTH > 0 ? '" width="' . PRODUCTS_LIST_PRICE_WIDTH : '');
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        break;
/*
      case 'PRODUCT_LIST_BUY_NOW':
        $lc_text = TABLE_HEADING_BUY_NOW;
        $lc_align = 'center';
        break;
*/
    }

//    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
    if ( ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = zen_create_sort_heading($_GET['sort'], $col+1, $lc_text);
    }

    $list_box_contents[0][$col] = array('align' => $lc_align,
                                    'params' => 'class="productListing-heading" nowrap="nowrap"',
                                    'text' => '&nbsp;' . $lc_text . '&nbsp;');
  }

  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing = $db->Execute($listing_split->sql_query);
    while (!$listing->EOF) {
      $rows++;

      if (($rows/2) == floor($rows/2)) {
        $list_box_contents[$rows] = array('params' => 'class="productListing-even"');
      } else {
        $list_box_contents[$rows] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($list_box_contents) - 1;

      for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
        $lc_align = '';

        switch ($column_list[$col]) {
          case 'PRODUCT_LIST_MODEL':
            $lc_align = '';
            $lc_text = '&nbsp;' . $listing->fields['products_model'] . '&nbsp;';
            break;
          case 'PRODUCT_LIST_NAME':
            $lc_align = '';
            if (isset($_GET['manufacturers_id'])) {
              $lc_text = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'manufacturers_id=' . $_GET['manufacturers_id'] . '&products_id=' . $listing->fields['products_id']) . '">' . $listing->fields['products_name'] . '</a>';
            } else {
              $lc_text = '&nbsp;<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . $listing->fields['products_name'] . '</a>&nbsp;';
            }
            break;
          case 'PRODUCT_LIST_MANUFACTURER':
            $lc_align = '';
            $lc_text = '&nbsp;<a href="' . zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing->fields['manufacturers_id']) . '">' . $listing->fields['manufacturers_name'] . '</a>&nbsp;';
            break;
          case 'PRODUCT_LIST_PRICE':
            $lc_price = zen_get_products_display_price($listing->fields['products_id']);
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $lc_price . '&nbsp;';

// more info in place of buy now
            $lc_button = '';
            if (zen_has_product_attributes($listing->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {
              $lc_button = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
            } else {
              $lc_button = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT) . '</a>&nbsp;';
            }
            $the_button = $lc_button;
            $products_link = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
            $lc_text .= '<br />' . zen_get_buy_now_button($listing->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($listing->fields['products_id']);

            break;
          case 'PRODUCT_LIST_QUANTITY':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $listing->fields['products_quantity'] . '&nbsp;';
            break;
          case 'PRODUCT_LIST_WEIGHT':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $listing->fields['products_weight'] . '&nbsp;';
            break;
          case 'PRODUCT_LIST_IMAGE':
            $lc_align = 'center';
            if (isset($_GET['manufacturers_id'])) {
              $lc_text = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'manufacturers_id=' . $_GET['manufacturers_id'] . '&products_id=' . $listing->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $listing->fields['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT) . '</a>';
            } else {
              $lc_text = '&nbsp;<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $listing->fields['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT) . '</a>&nbsp;';
            }
            break;
/*
          case 'PRODUCT_LIST_BUY_NOW':
            $lc_align = 'center';
// more info in place of buy now
            if (zen_has_product_attributes($listing->fields['products_id'])) {
              $lc_text = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
            } else {
              $lc_text = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT) . '</a>&nbsp;';
            }
            $the_button = $lc_text;
            $products_link = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
            $lc_text = zen_get_buy_now_button($listing->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($listing->fields['products_id']);
            break;
*/
        }

        $list_box_contents[$rows][$col] = array('align' => $lc_align,
                                               'params' => 'class="productListing-data"',
                                               'text'  => $lc_text);
      }
      $listing->MoveNext();
    }
    $error_categories==false;
  } else {
    $list_box_contents = array();

    $list_box_contents[0] = array('params' => 'class="productListing-odd"');
    $list_box_contents[0][] = array('params' => 'class="productListing-data"',
                                   'text' => TEXT_NO_PRODUCTS);

    $error_categories = true;
  }

  require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
?>
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
// $Id: tpl_document_general_info_display.php 290 2004-09-15 19:48:26Z wilt $
//
// Variables available on this page
//
// $products_name
// $products_model
// $products_price
// $specials_price
// $products_image @@TODO Consider using a array generated by a class for multiple images
// $products_url
// $products_date_available
// $products_date_added
// $products_description
// $products_manufacturer
// $products_weight
// $products_quantity
// $options_name - Array
// $options_menu - Array
//   $module_show_categories
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2" class="breadCrumb"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></td>
  </tr>

<?php
if ($debug_on == '1') {
  echo '<tr>';
  echo '  <td colspan="2" class="smallText">';
  echo 'Looking at ' . (int)$_GET['products_id'] . '<br />';
  echo 'Base Price ' . zen_get_products_base_price((int)$_GET['products_id']) . '<br />';
  echo 'Actual Price ' . zen_get_products_actual_price((int)$_GET['products_id']) . '<br />';
  echo 'Special Price ' . zen_get_products_special_price((int)$_GET['products_id'], true) . '<br />';
  echo 'Sale Maker Discount Type ' . zen_get_products_sale_discount_type((int)$_GET['products_id']) . '<br />';
  echo 'Discount Calc ' . zen_get_discount_calc((int)$_GET['products_id']) . '<br />';
  echo 'Discount Calc Attr $100 $75 $50 $25 ' . zen_get_discount_calc((int)$_GET['products_id'], true, 100) . ' | ' . zen_get_discount_calc((int)$_GET['products_id'], true, 75) . ' | ' . zen_get_discount_calc((int)$_GET['products_id'], true, 50) . ' | ' . zen_get_discount_calc((int)$_GET['products_id'], true, 25) . '<br />';

  echo '<br> Start of page - document general<br>' .
  zen_get_show_product_switch($products_id_current, 'weight') . '<br>' .
  zen_get_show_product_switch($products_id_current, 'weight_attributes') . '<br>' .
  zen_get_show_product_switch($products_id_current, 'date_added') . '<br>' .
  zen_get_show_product_switch($products_id_current, 'quantity') . '<br>' .
  zen_get_show_product_switch($products_id_current, 'model') . '<br>' .
  SHOW_DOCUMENT_GENERAL_INFO_WEIGHT_ATTRIBUTES . '<br>' .
  SHOW_DOCUMENT_GENERAL_INFO_WEIGHT . '<br>' .
  SHOW_DOCUMENT_GENERAL_INFO_MANUFACTURER . '<br>' .
  SHOW_DOCUMENT_GENERAL_INFO_QUANTITY . '<br>' .
  '<br>';
  echo '  </td>';
  echo '</tr>';
}
?>
<?php if (PRODUCT_INFO_PREVIOUS_NEXT == '1' or PRODUCT_INFO_PREVIOUS_NEXT == '3') { ?>
  <tr>
    <td colspan="2" align="center">
      <?php require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
    </td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="2" class="pageHeading" valign="top"><h1><?php echo $products_name; ?></h1></td>
  </tr>
  <tr>
    <td align="center" valign="top" class="smallText" rowspan="3" width="<?php echo SMALL_IMAGE_WIDTH; ?>">
<?php
  if (zen_not_null($products_image)) {
    require(DIR_WS_MODULES . 'pages/' . $current_page_base . '/main_template_vars_images.php');
  } else {
    echo '&nbsp;';
  }
?>
    </td>
  </tr>

  <tr>
    <td colspan="2" class="main" align="center">
<?php
  if ($pr_attr->fields['total'] > 0) {
?>
      <table border="0" width="90%" cellspacing="0" cellpadding="2">
<?php if ($zv_display_select_option > 0) { ?>
        <tr>
          <td colspan="2" class="main" align="left"><?php echo TEXT_PRODUCT_OPTIONS; ?></td>
        </tr>
<?php } // show please select unless all are readonly ?>
<?php
    for($i=0;$i<sizeof($options_name);$i++) {
?>
<?php
  if ($options_comment[$i] != '' and $options_comment_position[$i] == '0') {
?>

        <tr>
          <td><?php echo zen_draw_separator(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_TRANPARENT, '1', '5'); ?></td>
        </tr>
        <tr>
          <td colspan="2" class="ProductInfoComments" align="left" valign="bottom"><?php echo $options_comment[$i]; ?></td>
        </tr>
<?php
  }
?>
        <tr>
          <td class="main" align="left" valign="top"><?php echo $options_name[$i] . ':'; ?></td>
          <td class="main" align="left" valign="top" width="75%"><?php echo $options_menu[$i]; ?></td>
        </tr>
<?php if ($options_comment[$i] != '' and $options_comment_position[$i] == '1') { ?>
        <tr>
          <td colspan="2" class="ProductInfoComments" align="left" valign="top"><?php echo $options_comment[$i]; ?></td>
        </tr>
<?php } ?>

<?php
if ($options_attributes_image[$i] != '') {
?>
        <tr><td colspan="2"><table class="products-attributes-images"><tr>
          <?php echo $options_attributes_image[$i]; ?>
        </tr></table></td></tr>
<?php
}
?>
<?php
    }
?>
<?php
  if ($show_onetime_charges_description == 'true') {
?>
        <tr>
          <td colspan="2" class="main" align="left"><?php echo TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION; ?></td>
        </tr>
<?php } ?>

<?php
  if ($show_attributes_qty_prices_description == 'true') {
?>
        <tr>
          <td colspan="2" class="main" align="left"><?php echo zen_image(DIR_WS_TEMPLATE_ICONS . 'icon_status_green.gif', TEXT_ATTRIBUTES_QTY_PRICE_HELP_LINK, 10, 10) . '&nbsp;' . '<a href="javascript:popupWindowPrice(\'' . zen_href_link(FILENAME_POPUP_ATTRIBUTES_QTY_PRICES, 'products_id=' . $_GET['products_id'] . '&products_tax_class_id=' . $products_tax_class_id) . '\')">' . TEXT_ATTRIBUTES_QTY_PRICE_HELP_LINK . '</a>'; ?></td>
        </tr>
<?php } ?>

      </table>
<?php
  }
?>
    </td>
  </tr>

<?php if ($products_description != '') { ?>
  <tr>
    <td colspan="2" class="plainbox-description" valign="top"><?php echo stripslashes($products_description); ?></td>
  </tr>
<?php } ?>

<?php require(DIR_WS_MODULES . 'pages/' . $current_page_base . '/main_template_vars_images_additional.php'); ?>
<?php if (PRODUCT_INFO_PREVIOUS_NEXT == '2' or PRODUCT_INFO_PREVIOUS_NEXT == '3') { ?>
  <tr>
    <td colspan="2" align="center">
      <?php require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
    </td>
  </tr>
<?php } ?>
  <tr>
    <td align="center" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="main" align="left" valign="bottom">
<?php
  if ($reviews->fields['count'] > 0 or SHOW_DOCUMENT_GENERAL_INFO_REVIEWS == '1') {
    echo '<table align="left">';
    echo '  <tr>';
    echo '    <td class="main" align="center" valign="bottom">';
    echo (SHOW_DOCUMENT_GENERAL_INFO_REVIEWS_COUNT == '1' ? TEXT_CURRENT_REVIEWS . ' ' . $reviews->fields['count'] : '&nbsp;') . '<br />';
    echo (SHOW_DOCUMENT_GENERAL_INFO_REVIEWS == '1' ? '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params()) . '">' . zen_image_button(BUTTON_IMAGE_REVIEWS, BUTTON_REVIEWS_ALT) . '</a>' : '&nbsp;');
    echo '    </td>';
    echo '  </tr>';
    echo '</table>';
  }
?>
    </td>
    <td class="main" align="right" valign="bottom">
<?php
  if (SHOW_DOCUMENT_GENERAL_INFO_TELL_A_FRIEND == '1') {
    echo '<table align="right">';
    echo '  <tr>';
    echo '    <td class="main" align="center" valign="bottom">';
    echo (SHOW_DOCUMENT_GENERAL_INFO_TELL_A_FRIEND == '1' ? '<a href="' . zen_href_link(FILENAME_TELL_A_FRIEND, 'products_id=' . $_GET['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_TELLAFRIEND, BUTTON_TELLAFRIEND_ALT) . '</a>' : '');
    echo '    </td>';
    echo '  </tr>';
    echo '</table>';
  }
?>
    </td>
  </tr>
<?php
  if ($products_date_available > date('Y-m-d H:i:s')) {
    if (SHOW_DOCUMENT_GENERAL_INFO_DATE_AVAILABLE == '1') {
?>
  <tr>
    <td colspan="2" align="center" class="smallText"><?php echo sprintf(TEXT_DATE_AVAILABLE, zen_date_long($products_date_available)); ?></td>
  </tr>
<?php
    }
  } else {
    if (SHOW_DOCUMENT_GENERAL_INFO_DATE_ADDED == '1') {
?>
  <tr>
    <td colspan="2" align="center" class="smallText"><?php echo sprintf(TEXT_DATE_ADDED, zen_date_long($products_date_added)); ?></td>
  </tr>
<?php
    } // SHOW_DOCUMENT_GENERAL_INFO_DATE_ADDED
  }
?>
<?php
  if (zen_not_null($products_url)) {
    if (SHOW_DOCUMENT_GENERAL_INFO_URL == '1') {
?>
  <tr>
    <td class="main" align="center" colspan="2">
      <?php echo sprintf(TEXT_MORE_INFORMATION, zen_href_link(FILENAME_REDIRECT, 'action=url&goto=' . urlencode($products_url), 'NONSSL', true, false)); ?>
    </td>
  </tr>
 <?php
    } // SHOW_DOCUMENT_GENERAL_INFO_URL
  }
?>
<tr>
  <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
</tr>
</table>
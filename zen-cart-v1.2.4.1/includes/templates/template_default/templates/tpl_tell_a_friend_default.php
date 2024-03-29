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
// $Id: tpl_tell_a_friend_default.php 290 2004-09-15 19:48:26Z wilt $
//
?>
<?php echo zen_draw_form('email_friend', zen_href_link(FILENAME_TELL_A_FRIEND, 'action=process&products_id=' . $_GET['products_id'])); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="breadCrumb" colspan="2"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></td>
  </tr>
  <tr>
    <td class="pageHeading" colspan="2"><h1><?php echo sprintf(HEADING_TITLE, $product_info->fields['products_name']); ?></h1></td>
  </tr>
<?php
  if ($messageStack->size('friend') > 0) {
?>
  <tr>
    <td class="main" colspan="2"><?php echo $messageStack->output('friend'); ?></td>
  </tr>
<?php
  }
?>
  <tr>
    <td class="main" colspan="2" ><?php echo zen_draw_separator(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_SILVER_SEPARATOR, '100%', '1'); ?></td>
  </tr>
  <tr>
    <td class="plainBoxHeading" width="40%"><?php echo FORM_TITLE_CUSTOMER_DETAILS; ?></td>
    <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo FORM_FIELD_CUSTOMER_NAME; ?></td>
    <td class="main"><?php echo zen_draw_input_field('from_name') . '&nbsp;<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>'; ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo FORM_FIELD_CUSTOMER_EMAIL; ?></td>
    <td class="main"><?php echo zen_draw_input_field('from_email_address') . '&nbsp;<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>'; ?></td>
  </tr>
  <tr>
    <td class="plainBoxHeading" colspan="2"><?php echo FORM_TITLE_FRIEND_DETAILS; ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo FORM_FIELD_FRIEND_NAME; ?></td>
    <td class="main"><?php echo zen_draw_input_field('to_name') . '&nbsp;<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>'; ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo FORM_FIELD_FRIEND_EMAIL; ?></td>
    <td class="main"><?php echo zen_draw_input_field('to_email_address', $_GET['to_email_address']) . '&nbsp;<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>'; ?></td>
  </tr>
  <tr>
    <td class="plainBoxHeading" colspan="2"><?php echo FORM_TITLE_FRIEND_MESSAGE; ?></td>
  </tr>
  <tr>
    <td class="main" colspan="2"><?php echo zen_draw_textarea_field('message', 'soft', 40, 8); ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo '<a href="' . zen_href_link(zen_get_info_page($_GET['products_id']), 'products_id=' . $_GET['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_ADD_ADDRESS_ALT) . '</a>'; ?></td>
    <td align="right"><?php echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_SEND_ALT); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="main" height="10px"></td>
  </tr>
  <tr>
    <td colspan="2" class="main"><?php echo EMAIL_ADVISORY_INCLUDED_WARNING . str_replace('-----', '', EMAIL_ADVISORY); ?></td>
  </tr>
</table></form>
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
// $Id: tpl_address_book_process_default.php 290 2004-09-15 19:48:26Z wilt $
//
?>
<?php if (!isset($_GET['delete'])) echo zen_draw_form('addressbook', zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, (isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : ''), 'SSL'), 'post', 'onsubmit="return check_form(addressbook);"'); ?>
  <table border="0" width="100%" cellspacing="2" cellpadding="2">
    <tr>
      <td class="breadCrumb" colspan="3"><?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?></td>
    </tr>
    <tr>
      <td class="pageHeading" colspan="3"><?php if (isset($_GET['edit'])) { echo HEADING_TITLE_MODIFY_ENTRY; } elseif (isset($_GET['delete'])) { echo HEADING_TITLE_DELETE_ENTRY; } else { echo HEADING_TITLE_ADD_ENTRY; } ?></td>
    </tr>
<?php
  if ($messageStack->size('addressbook') > 0) {
?>
    <tr>
      <td class="main" colspan="3"><?php echo $messageStack->output('addressbook'); ?></td>
    </tr>
<?php
  }

  if (isset($_GET['delete'])) {
?>
    <tr>
      <td class="main" colspan="3" ><?php echo zen_draw_separator(OTHER_IMAGE_SILVER_SEPARATOR, '100%', '1'); ?></td>
    </tr>
    <tr>
      <td class="main" width="50%" valign="top"><?php echo DELETE_ADDRESS_DESCRIPTION; ?></td>
      <td class="main" align="left" valign="top"><?php echo SELECTED_ADDRESS; ?><br /><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_ARROW_SOUTH_EAST); ?></td>
      <td class="main" width="30%"valign="top"><?php echo zen_address_label($_SESSION['customer_id'], $_GET['delete'], true, ' ', '<br />'); ?></td>
    </tr>
    <tr>
      <td class="main" colspan="3" ><?php echo zen_draw_separator(OTHER_IMAGE_SILVER_SEPARATOR, '100%', '1'); ?></td>
    </tr>
    <tr>
      <td class="main"><?php echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></td>
      <td align="right" colspan="2"><?php echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $_GET['delete'] . '&action=deleteconfirm', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_DELETE, BUTTON_DELETE_ALT) . '</a>'; ?></td>
    </tr>
<?php
  } else {
?>
    <tr>
      <td class="plainBox" colspan="2"><?php require(DIR_WS_MODULES . 'address_book_details.php'); ?></td>
    </tr>
<?php
    if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
?>
    <tr>
      <td class="main"><?php echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></td>
      <td align="right"><?php echo zen_draw_hidden_field('action', 'update') . zen_draw_hidden_field('edit', $_GET['edit']) . zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?></td>
    </tr>
<?php
    } else {
?>
    <tr>
      <td class="main"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></td>
      <td align="right"><?php echo zen_draw_hidden_field('action', 'process') . zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); ?></td>
    </tr>
<?php
    }
  }
?>
</table><?php if (!isset($_GET['delete'])) echo '</form>'; ?>
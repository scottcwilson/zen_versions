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
// $Id: tpl_box_default_right.php 290 2004-09-15 19:48:26Z wilt $
//

// choose box images based on box position
  $img_right = $template->get_template_dir('block_left_03.gif',DIR_WS_TEMPLATE, $current_page_base,'images'). '/block_left_03.gif';
  $img_left = $template->get_template_dir('block_left_01.gif',DIR_WS_TEMPLATE, $current_page_base,'images'). '/block_left_01.gif';
  $img_center = $template->get_template_dir('block_left_02.gif',DIR_WS_TEMPLATE, $current_page_base,'images'). '/block_left_02.gif';
  $img_right_b = $template->get_template_dir('block_left_07.gif',DIR_WS_TEMPLATE, $current_page_base,'images'). '/block_left_07.gif';
  $img_left_b = $template->get_template_dir('block_left_05.gif',DIR_WS_TEMPLATE, $current_page_base,'images'). '/block_left_05.gif';
  $img_center_b = $template->get_template_dir('block_left_06.gif',DIR_WS_TEMPLATE, $current_page_base,'images'). '/block_left_06.gif';
  $img_center_bb = $template->get_template_dir('block_left_06.gif',DIR_WS_TEMPLATE, $current_page_base,'images'). '/block_left_06.gif';
  if ($title_link) {
    $title = '<a href="' . zen_href_link($title_link) . '">' . $title . BOX_HEADING_LINKS . '</a>';
  }
//
?>
<!--// bof: <?php echo $box_id; ?> //-->

<table border="0" cellpadding="0" cellspacing="0" width="<?php echo $column_width; ?>" class="bluestripsideBox">
  <tr>
    <td><?php echo zen_image($img_left, '', 11, 32); ?></td>
    <td width="100%" height="32" background="<?php echo $img_center; ?>"><div class="sideBoxHeading"><?php echo $title; ?></div></td>
    <td><?php echo zen_image($img_right, '', 11, 32); ?></td>
  </tr>
  <tr>
    <td colspan="3" width="100%" height="100%" class="sideBoxContent"><div class="boxText"><?php echo $content; ?></div></td>
  </tr>
  <tr>
    <td><?php echo zen_image($img_left_b, '', 11, 7); ?></td>
    <td width="100%"><?php echo zen_image($img_center_bb); ?></td>
    <td><?php echo zen_image($img_right_b, '', 11, 7); ?></td>
  </tr>
</table>

<!--// eof: <?php echo $box_id; ?> //-->
<table width="<?php echo $column_width; ?>" border="0" cellspacing="0" cellpadding="0" class="<?php echo $column_box_spacer; ?>">
  <tr class="<?php echo $column_box_spacer; ?>">
    <td class="<?php echo $column_box_spacer; ?>"></td>
  </tr>
</table>

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
// $Id: tpl_main_page.php 290 2004-09-15 19:48:26Z wilt $
//
?>
<body>
<table width="95%" align="center" class="popupinfoshoppingcart">
<tr><td>
<p class="main"><strong><?php echo HEADING_TITLE; ?></strong><br /><?php echo zen_draw_separator(); ?></p>
<p class="main"><strong><i><?php echo SUB_HEADING_TITLE_1; ?></i></strong><br /><?php echo SUB_HEADING_TEXT_1; ?></p>
<p class="main"><strong><i><?php echo SUB_HEADING_TITLE_2; ?></i></strong><br /><?php echo SUB_HEADING_TEXT_2; ?></p>
<p class="main"><strong><i><?php echo SUB_HEADING_TITLE_3; ?></i></strong><br /><?php echo SUB_HEADING_TEXT_3; ?></p>
<p align="right" class="main"><a href="javascript:window.close();"><?php echo TEXT_CURRENT_CLOSE_WINDOW; ?></a></p>
</td></tr>
</table>
</body>
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
// $Id: languages.php 290 2004-09-15 19:48:26Z wilt $
//

// test if box should display
  $show_languages= false;

  if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {
    $show_languages= true;
  }

  if ($show_languages == true) {
    if (!isset($lng) || (isset($lng) && !is_object($lng))) {
      include(DIR_WS_CLASSES . 'language.php');
      $lng = new language;
    }

    reset($lng->catalog_languages);
    require($template->get_template_dir('tpl_languages.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_languages.php');
    $title =  BOX_HEADING_LANGUAGES;
    $left_corner = false;
    $right_corner = false;
    $right_arrow = false;
    $title_link = false;
    require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
  }
?>
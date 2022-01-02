<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
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
// $Id: manufacturers.php 926 2005-01-10 21:15:23Z ajeh $
//

// test if manufacturers sidebox should show
  $show_manufacturers= true;

// for large lists of manufacturers uncomment this section
/*
  if (($_GET['main_page']==FILENAME_DEFAULT and ($_GET['cPath'] == '' or $_GET['cPath'] == 0)) or  ($_SERVER['HTTPS'] == 'on')) {
    $show_manufacturers= false;
  } else {
    $show_manufacturers= true;
  }
*/

if ($show_manufacturers) {

// only check products if requested - this may slow down the processing of the manufacturers sidebox
  if (PRODUCTS_MANUFACTURERS_STATUS == '1') {
    $manufacturers_query = "select distinct m.manufacturers_id, m.manufacturers_name
                            from " . TABLE_MANUFACTURERS . " m
                            left join " . TABLE_PRODUCTS . " p on m.manufacturers_id = p.manufacturers_id
                            where m.manufacturers_id = p.manufacturers_id and p.products_status= '1'
                            order by manufacturers_name";
  } else {
    $manufacturers_query = "select m.manufacturers_id, m.manufacturers_name
                            from " . TABLE_MANUFACTURERS . " m
                            order by manufacturers_name";
  }

  $manufacturers = $db->Execute($manufacturers_query);

  if ($manufacturers->RecordCount()>0) {
    $number_of_rows = $manufacturers->RecordCount()+1;

// Display a list
    $manufacturers_array = array();
    if ($_GET['manufacturers_id'] == '' ) {
      $manufacturers_array[] = array('id' => '', 'text' => PULL_DOWN_ALL);
    } else {
      $manufacturers_array[] = array('id' => '', 'text' => PULL_DOWN_MANUFACTURERS);
    }

    while (!$manufacturers->EOF) {
      $manufacturers_name = ((strlen($manufacturers->fields['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers->fields['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers->fields['manufacturers_name']);
      $manufacturers_array[] = array('id' => $manufacturers->fields['manufacturers_id'],
                                       'text' => $manufacturers_name);

      $manufacturers->MoveNext();
    }
      require($template->get_template_dir('tpl_manufacturers_select.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_manufacturers_select.php');

    $title =  BOX_HEADING_MANUFACTURERS;
    $left_corner = false;
    $right_corner = false;
    $right_arrow = false;
    $title_link = false;
    require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
  }
} // $show_manufacturers
?>
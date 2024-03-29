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
// $Id: main_template_vars.php 290 2004-09-15 19:48:26Z wilt $
//
//die($category_depth);
//die($_GET['music_genre_id']);

// release manufactures_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
  if ($_GET['manufacturers_id'] <= 0) {
    unset($_GET['manufacturers_id']);
    unset($manufacturers_id);
  }

// release music_genre_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
  if ($_GET['music_genre_id'] <= 0) {
    unset($_GET['music_genre_id']);
    unset($music_genre_id);
  }

// release record_company_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
  if ($_GET['record_company_id'] <= 0) {
    unset($_GET['record_company_id']);
    unset($record_company_id);
  }

// only elease typefilter if both record_company_id and music_genre_id are blank
// this will result in the home page, if used
  if ($_GET['record_company_id'] <= 0 and $_GET['music_genre_id'] <= 0) {
    unset($_GET['typefilter']);
    unset($typefilter);
  }

  if ($category_depth == 'nested')
    {
    $sql = "select cd.categories_name, c.categories_image
            from   " . TABLE_CATEGORIES . " c, " .
                       TABLE_CATEGORIES_DESCRIPTION . " cd
            where      c.categories_id = '" . (int)$current_category_id . "'
            and        cd.categories_id = '" . (int)$current_category_id . "'
            and        cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
            and        c.categories_status= '1'";

    $category = $db->Execute($sql);

    if (isset($cPath) && strpos($cPath, '_'))
    {
// check to see if there are deeper categories within the current category
      $category_links = array_reverse($cPath_array);
      for($i=0, $n=sizeof($category_links); $i<$n; $i++)
      {
        $sql = "select count(*) as total
                from   " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                where      c.parent_id = '" . (int)$category_links[$i] . "'
                and        c.categories_id = cd.categories_id
                and        cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                and        c.categories_status= '1'";

        $categories = $db->Execute($sql);

        if ($categories->fields['total'] < 1)
        {
        // do nothing, go through the loop
        } else {
          $categories_query = "select c.categories_id, cd.categories_name, c.categories_image, c.parent_id
                  from   " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                  where      c.parent_id = '" . (int)$category_links[$i] . "'
                  and        c.categories_id = cd.categories_id
                  and        cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                  and        c.categories_status= '1'
                  order by   sort_order, cd.categories_name";

          break; // we've found the deepest category the customer is in
        }
      }
    } else {
      $categories_query = "select c.categories_id, cd.categories_name, c.categories_image, c.parent_id
                           from   " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                           where      c.parent_id = '" . (int)$current_category_id . "'
                           and        c.categories_id = cd.categories_id
                           and        cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and        c.categories_status= '1'
                           order by   sort_order, cd.categories_name";
    }
    $categories = $db->Execute($categories_query);
    $number_of_categories = $categories->RecordCount();
    $new_products_category_id = $current_category_id;

/////////////////////////////////////////////////////////////////////////////////////////////////////
    $tpl_page_body = 'tpl_index_categories.php';
/////////////////////////////////////////////////////////////////////////////////////////////////////

//  } elseif ($category_depth == 'products' || isset($_GET['manufacturers_id']) || isset($_GET['music_genre_id'])) {
  } elseif ($category_depth == 'products' || zen_check_url_get_terms()) {
    if (SHOW_PRODUCT_INFO_ALL_PRODUCTS == '1') {
      // set a category filter
      $new_products_category_id = $cPath;
    } else {
      // do not set the category
    }
// create column list
    $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                         'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                         'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                         'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                         'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                         'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                         'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE);

/*                         ,
                         'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);
*/
    asort($define_list);
    $column_list = array();
    reset($define_list);
    while (list($key, $value) = each($define_list))
    {
      if ($value > 0) $column_list[] = $key;
    }

    $select_column_list = '';

    for ($i=0, $n=sizeof($column_list); $i<$n; $i++)
    {
      switch ($column_list[$i])
      {
        case 'PRODUCT_LIST_MODEL':
          $select_column_list .= 'p.products_model, ';
          break;
        case 'PRODUCT_LIST_NAME':
          $select_column_list .= 'pd.products_name, ';
          break;
        case 'PRODUCT_LIST_MANUFACTURER':
          $select_column_list .= 'm.manufacturers_name, ';
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $select_column_list .= 'p.products_quantity, ';
          break;
        case 'PRODUCT_LIST_IMAGE':
          $select_column_list .= 'p.products_image, ';
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $select_column_list .= 'p.products_weight, ';
          break;
      }
    }
// add the product filters for other product types here
//
if (isset($_GET['typefilter'])) {
//die('here1');
  require(DIR_WS_INCLUDES . 'index_filters/' . $_GET['typefilter'] . '_filter.php');
} else {
  require(DIR_WS_INCLUDES . 'index_filters/default_filter.php');
}
//die('here2');


////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $tpl_page_body = 'tpl_index_product_list.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////
  } else {
////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $tpl_page_body = 'tpl_index_default.php';
////////////////////////////////////////////////////////////////////////////////////////////////////////////
  }

// categories_description
    $sql = "select categories_description from " . TABLE_CATEGORIES_DESCRIPTION . "
            where categories_id= '" . $current_category_id . "'
            and language_id = '" . (int)$_SESSION['languages_id'] . "'";

    $categories_description_lookup= $db->Execute($sql);

    $current_categories_description = $categories_description_lookup->fields['categories_description'];

  require($template->get_template_dir($tpl_page_body, DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . $tpl_page_body);
?>
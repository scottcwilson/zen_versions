<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: meta_tags.php 960 2005-01-28 03:46:53Z ajeh $
//

// Define Primary Section Output
  define('PRIMARY_SECTION', ' : ');

// Define Secondary Section Output
  define('SECONDARY_SECTION', ' - ');

// Define Tertiary Section Output
  define('TERTIARY_SECTION', ', ');

// Add tertiary section to site tagline
  if (strlen(SITE_TAGLINE) > 1) {
    define('TAGLINE', TERTIARY_SECTION . SITE_TAGLINE);
  } else {
    define('TAGLINE', '');
  }


// Get all top category names for use with web site keywords
  $sql = "select cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$_SESSION['languages_id'] . "'";
  $keywords_metatags = $db->Execute($sql);
  while (!$keywords_metatags->EOF) {
    $keywords_string_metatags .= $keywords_metatags->fields['categories_name'] . ' ';
    $keywords_metatags->MoveNext();
  }
  define('KEYWORDS', $keywords_string_metatags . CUSTOM_KEYWORDS);

// Get different meta tag values depending on main_page values
  switch ($_GET['main_page']) {
  case 'advanced_search':
  case 'account_edit':
  case 'account_history':
  case 'account_history_info':
  case 'account_newsletters':
  case 'account_notifications':
  case 'account_password':
  case 'address_book':
    define('META_TAG_TITLE', HEADING_TITLE . PRIMARY_SECTION . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . NAVBAR_TITLE_1 . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . NAVBAR_TITLE_1);
    break;

  case 'address_book_process':
    define('META_TAG_TITLE', NAVBAR_TITLE_ADD_ENTRY . PRIMARY_SECTION . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . NAVBAR_TITLE_ADD_ENTRY . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . NAVBAR_TITLE_ADD_ENTRY);
	break;

  case 'advanced_search_result':
  case 'password_forgotten':
    define('META_TAG_TITLE', NAVBAR_TITLE_2 . PRIMARY_SECTION . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . NAVBAR_TITLE_2 . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . NAVBAR_TITLE_2);
	break;

  case 'checkout_confirmation':
  case 'checkout_payment':
  case 'checkout_payment_address':
  case 'checkout_shipping':
  case 'checkout_success':
  case 'create_account_success':
    define('META_TAG_TITLE', HEADING_TITLE . PRIMARY_SECTION . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . HEADING_TITLE . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . HEADING_TITLE);
    break;

  case 'index':
    if ($category_depth == 'nested') {
      $sql = "select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$current_category_id . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'";
      $category_metatags = $db->Execute($sql);
      if ($category_metatags->EOF) {
        $meta_tags_over_ride = true;
      } else {
        define('META_TAG_TITLE', $category_metatags->fields['categories_name'] . PRIMARY_SECTION . TITLE . TAGLINE);
        define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . $category_metatags->fields['categories_name'] . SECONDARY_SECTION . KEYWORDS);
        define('META_TAG_KEYWORDS', KEYWORDS . ' ' . $category_metatags->fields['categories_name']);
      } // EOF
    } elseif ($category_depth == 'products') {
	    if (isset($_GET['manufacturers_id'])) {
        $sql = "select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";
        $manufacturer_metatags = $db->Execute($sql);
        if ($manufacturer_metatags->EOF) {
          $meta_tags_over_ride = true;
        } else {
          define('META_TAG_TITLE', $manufacturer_metatags->fields['manufacturers_name'] . PRIMARY_SECTION . TITLE . TAGLINE);
          define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . $manufacturer_metatags->fields['manufacturers_name'] . SECONDARY_SECTION . KEYWORDS);
          define('META_TAG_KEYWORDS', KEYWORDS . ' ' . $manufacturer_metatags->fields['manufacturers_name']);
        } // EOF
   	  } else {
        $sql = "select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$current_category_id . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'";
        $category_metatags = $db->Execute($sql);
        if ($category_metatags->EOF) {
          $meta_tags_over_ride = true;
        } else {
          define('META_TAG_TITLE', $category_metatags->fields['categories_name'] . PRIMARY_SECTION . TITLE . TAGLINE);
          define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . $category_metatags->fields['categories_name'] . SECONDARY_SECTION . KEYWORDS);
          define('META_TAG_KEYWORDS', KEYWORDS . ' ' . $category_metatags->fields['categories_name']);
        } // EOF
      }
    } else {
      define('META_TAG_TITLE', TITLE . TAGLINE);
      define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . str_replace(array("'",'"'),'',strip_tags(HEADING_TITLE)) . SECONDARY_SECTION . KEYWORDS);
      define('META_TAG_KEYWORDS', KEYWORDS . ' ' . str_replace(array("'",'"'),'',strip_tags(HEADING_TITLE)));
    }
    break;

  case 'popup_image':
    $meta_products_name = zen_clean_html($products_values->fields['products_name']);
    define('META_TAG_TITLE', $meta_products_name . PRIMARY_SECTION . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . $meta_products_name . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . $meta_products_name);
    break;

  case 'popup_image_additional':
    $meta_products_name = zen_clean_html($products_values->fields['products_name']);
    define('META_TAG_TITLE', $meta_products_name . PRIMARY_SECTION . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . $meta_products_name . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . $meta_products_name);
    break;

  case 'popup_search_help':
    define('META_TAG_TITLE', HEADING_SEARCH_HELP . PRIMARY_SECTION . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . HEADING_SEARCH_HELP . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . HEADING_SEARCH_HELP);
    break;

//  case 'product_info':
  case (strstr($_GET['main_page'], 'product_') or strstr($_GET['main_page'], 'document_')):
    $sql = "select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_price, p.products_tax_class_id, p.product_is_free from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
    $product_info_metatags = $db->Execute($sql);
    if ($product_info_metatags->EOF) {
      $meta_tags_over_ride = true;
    } else {
      if (META_TAG_INCLUDE_PRICE == '1' and !strstr($_GET['main_page'], 'document_general')) {
        if ($product_info_metatags->fields['product_is_free'] != '1') {
          $meta_products_price = zen_get_products_actual_price($product_info_metatags->fields['products_id']);
          $meta_products_price = SECONDARY_SECTION . $currencies->display_price($meta_products_price, zen_get_tax_rate($product_info_metatags->fields['products_tax_class_id']));
        } else {
          $meta_products_price = SECONDARY_SECTION . META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT;
        }
      } else {
        $meta_products_price = '';
      }

      if (zen_not_null($product_info_metatags->fields['products_model'])) {
        $meta_products_name = $product_info_metatags->fields['products_name'] . ' [' . $product_info_metatags->fields['products_model'] . ']';
      } else {
        $meta_products_name = $product_info_metatags->fields['products_name'];
      }
      $meta_products_name = zen_clean_html($meta_products_name);

      $products_description = substr(strip_tags(stripslashes($product_info_metatags->fields['products_description'])), 0, 100);
      $products_description = zen_clean_html($products_description);

      define('META_TAG_TITLE', $meta_products_name . $meta_products_price . PRIMARY_SECTION . TITLE . TAGLINE);
      define('META_TAG_DESCRIPTION', TITLE . ' ' . $meta_products_name . SECONDARY_SECTION . $products_description . ' ...');
      define('META_TAG_KEYWORDS', KEYWORDS . ' ' . $meta_products_name);
    } // EOF
    break;

  case 'product_reviews':
    $sql = "select p.products_id, pd.products_name, p.products_model, p.products_price, p.products_tax_class_id, p.product_is_free from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
    $review_metatags = $db->Execute($sql);
    if ($review_metatags->EOF) {
      $meta_tags_over_ride = true;
    } else {
      if (META_TAG_INCLUDE_PRICE == '1') {
        if ($review_metatags->fields['product_is_free'] != '1') {
          $meta_products_price = zen_get_products_actual_price($review_metatags->fields['products_id']);
          $meta_products_price = SECONDARY_SECTION . $currencies->display_price($meta_products_price, zen_get_tax_rate($review_metatags->fields['products_tax_class_id']));
        } else {
          $meta_products_price = SECONDARY_SECTION . META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT;
        }
      } else {
        $meta_products_price = '';
      }

      if (zen_not_null($review_metatags->fields['products_model'])) {
        $meta_products_name = $review_metatags->fields['products_name'] . ' [' . $review_metatags->fields['products_model'] . ']';
      } else {
        $meta_products_name = $review_metatags->fields['products_name'];
      }

      $meta_products_name = zen_clean_html($meta_products_name);

      define('META_TAG_TITLE', $meta_products_name . $meta_products_price . PRIMARY_SECTION . TITLE . TERTIARY_SECTION . NAVBAR_TITLE);
      define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . NAVBAR_TITLE . SECONDARY_SECTION . $meta_products_name . SECONDARY_SECTION . $meta_products_price);
      define('META_TAG_KEYWORDS', KEYWORDS . ' ' . $meta_products_name);
    } // EOF
    break;

  case 'product_reviews_info':
    $sql = "select rd.reviews_text, r.reviews_rating, r.reviews_id, r.customers_name, p.products_id, p.products_price, p.products_tax_class_id, p.products_model, pd.products_name, p.product_is_free from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where r.reviews_id = '" . (int)$_GET['reviews_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "' and r.products_id = p.products_id and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '". (int)$_SESSION['languages_id'] . "'";
    $review_metatags = $db->Execute($sql);
    if ($review_metatags->EOF) {
      $meta_tags_over_ride = true;
    } else {
      if (META_TAG_INCLUDE_PRICE == '1') {
        if ($review_metatags->fields['product_is_free'] != '1') {
          $meta_products_price = zen_get_products_actual_price($review_metatags->fields['products_id']);
          $meta_products_price = SECONDARY_SECTION . $currencies->display_price($meta_products_price, zen_get_tax_rate($review_metatags->fields['products_tax_class_id']));
        } else {
          $meta_products_price = SECONDARY_SECTION . META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT;
        }
      } else {
        $meta_products_price = '';
      }

      if (zen_not_null($review_metatags->fields['products_model'])) {
        $meta_products_name = $review_metatags->fields['products_name'] . ' [' . $review_metatags->fields['products_model'] . ']';
      } else {
        $meta_products_name = $review_metatags->fields['products_name'];
      }

      $meta_products_name = zen_clean_html($meta_products_name);

      $review_text_metatags = substr(strip_tags(stripslashes($review_metatags->fields['reviews_text'])), 0, 60);
      $reviews_rating_metatags = SUB_TITLE_RATING . ' ' . sprintf(TEXT_OF_5_STARS, $review_metatags->fields['reviews_rating']);
      define('META_TAG_TITLE', $meta_products_name . $meta_products_price . PRIMARY_SECTION . TITLE . TERTIARY_SECTION . NAVBAR_TITLE);
      define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . NAVBAR_TITLE . SECONDARY_SECTION . $meta_products_name . SECONDARY_SECTION . $review_metatags->fields['customers_name'] . SECONDARY_SECTION . $review_text_metatags . ' ...' . SECONDARY_SECTION . $reviews_rating_metatags);
      define('META_TAG_KEYWORDS', KEYWORDS . ' ' . $meta_products_name . ' ' . $review_metatags->fields['customers_name'] . ' ' . $reviews_rating_metatags);
    } // EOF
    break;

  default:
    define('META_TAG_TITLE', (defined('NAVBAR_TITLE') ? NAVBAR_TITLE . PRIMARY_SECTION : '') . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . PRIMARY_SECTION . NAVBAR_TITLE . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . NAVBAR_TITLE);
  }

  // meta tags override due to 404, missing products_id, cPath or other EOF issues
  if ($meta_tags_over_ride == true) {
    define('META_TAG_TITLE', (defined('NAVBAR_TITLE') ? NAVBAR_TITLE . PRIMARY_SECTION : '') . TITLE . TAGLINE);
    define('META_TAG_DESCRIPTION', TITLE . (defined('NAVBAR_TITLE') ? PRIMARY_SECTION . NAVBAR_TITLE : '') . SECONDARY_SECTION . KEYWORDS);
    define('META_TAG_KEYWORDS', KEYWORDS . ' ' . (defined('NAVBAR_TITLE') ? NAVBAR_TITLE : ''));
  }
?>
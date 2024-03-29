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
// $Id: order.php 954 2005-01-22 17:47:38Z ajeh $
//

  class order {
    var $info, $totals, $products, $customer, $delivery, $content_type, $email_low_stock, $products_ordered_attributes,
        $products_ordered, $products_ordered_email;

    function order($order_id = '') {
      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();

      if (zen_not_null($order_id)) {
        $this->query($order_id);
      } else {
        $this->cart();
      }
    }

    function query($order_id) {
      global $db;

      $order_id = zen_db_prepare_input($order_id);

      $order_query = "select customers_id, customers_name, customers_company,
                             customers_street_address, customers_suburb, customers_city,
                             customers_postcode, customers_state, customers_country,
                             customers_telephone, customers_email_address, customers_address_format_id,
                             delivery_name, delivery_company, delivery_street_address, delivery_suburb,
                             delivery_city, delivery_postcode, delivery_state, delivery_country,
                             delivery_address_format_id, billing_name, billing_company,
                             billing_street_address, billing_suburb, billing_city, billing_postcode,
                             billing_state, billing_country, billing_address_format_id,
                             payment_method, payment_module_code, shipping_method, shipping_module_code,
                             coupon_code, cc_type, cc_owner, cc_number, cc_expires, currency, currency_value,
                             date_purchased, orders_status, last_modified, order_total, order_tax
                      from " . TABLE_ORDERS . "
                      where orders_id = '" . (int)$order_id . "'";

      $order = $db->Execute($order_query);

      $totals_query = "select title, text, class
                       from " . TABLE_ORDERS_TOTAL . "
                       where orders_id = '" . (int)$order_id . "'
                       order by sort_order";

      $totals = $db->Execute($totals_query);

      while (!$totals->EOF) {
        $this->totals[] = array('title' => $totals->fields['title'],
                                'text' => $totals->fields['text'],
                                'class' => $totals->fields['class']);
        $totals->MoveNext();
      }

      $order_total_query = "select text, value
         from " . TABLE_ORDERS_TOTAL . "
         where orders_id = '" . (int)$order_id . "'
         and class = 'ot_total'";


      $order_total = $db->Execute($order_total_query);


      $shipping_method_query = "select title, value
          from " . TABLE_ORDERS_TOTAL . "
          where orders_id = '" . (int)$order_id . "'
          and class = 'ot_shipping'";


      $shipping_method = $db->Execute($shipping_method_query);

      $order_status_query = "select orders_status_name
                             from " . TABLE_ORDERS_STATUS . "
                             where orders_status_id = '" . $order->fields['orders_status'] . "'
                             and language_id = '" . (int)$_SESSION['languages_id'] . "'";

      $order_status = $db->Execute($order_status_query);

      $this->info = array('currency' => $order->fields['currency'],
                          'currency_value' => $order->fields['currency_value'],
                          'payment_method' => $order->fields['payment_method'],
                          'payment_module_code' => $order->fields['payment_module_code'],
                          'shipping_method' => $order->fields['shipping_method'],
                          'shipping_module_code' => $order->fields['shipping_module_code'],
                          'coupon_code' => $order->fields['coupon_code'],
                          'cc_type' => $order->fields['cc_type'],
                          'cc_owner' => $order->fields['cc_owner'],
                          'cc_number' => $order->fields['cc_number'],
                          'cc_expires' => $order->fields['cc_expires'],
                          'date_purchased' => $order->fields['date_purchased'],
                          'orders_status' => $order_status->fields['orders_status_name'],
                          'last_modified' => $order->fields['last_modified'],
                          'total' => $order->fields['order_total'],
                          'tax' => $order->fields['order_tax'],
                          'shipping_method' => ((substr($shipping_method->fields['title'], -1) == ':') ? substr(strip_tags($shipping_method->fields['title']), 0, -1) : strip_tags($shipping_method->fields['title'])));

      $this->customer = array('id' => $order->fields['customers_id'],
                              'name' => $order->fields['customers_name'],
                              'company' => $order->fields['customers_company'],
                              'street_address' => $order->fields['customers_street_address'],
                              'suburb' => $order->fields['customers_suburb'],
                              'city' => $order->fields['customers_city'],
                              'postcode' => $order->fields['customers_postcode'],
                              'state' => $order->fields['customers_state'],
                              'country' => $order->fields['customers_country'],
                              'format_id' => $order->fields['customers_address_format_id'],
                              'telephone' => $order->fields['customers_telephone'],
                              'email_address' => $order->fields['customers_email_address']);

      $this->delivery = array('name' => $order->fields['delivery_name'],
                              'company' => $order->fields['delivery_company'],
                              'street_address' => $order->fields['delivery_street_address'],
                              'suburb' => $order->fields['delivery_suburb'],
                              'city' => $order->fields['delivery_city'],
                              'postcode' => $order->fields['delivery_postcode'],
                              'state' => $order->fields['delivery_state'],
                              'country' => $order->fields['delivery_country'],
                              'format_id' => $order->fields['delivery_address_format_id']);

      if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {
        $this->delivery = false;
      }

      $this->billing = array('name' => $order->fields['billing_name'],
                             'company' => $order->fields['billing_company'],
                             'street_address' => $order->fields['billing_street_address'],
                             'suburb' => $order->fields['billing_suburb'],
                             'city' => $order->fields['billing_city'],
                             'postcode' => $order->fields['billing_postcode'],
                             'state' => $order->fields['billing_state'],
                             'country' => $order->fields['billing_country'],
                             'format_id' => $order->fields['billing_address_format_id']);

      $index = 0;
      $orders_products_query = "select orders_products_id, products_id, products_name,
                                       products_model, products_price, products_tax,
                                       products_quantity, final_price,
                                       onetime_charges,
                                       products_priced_by_attribute, product_is_free, products_discount_type, products_discount_type_from
                                from " . TABLE_ORDERS_PRODUCTS . "
                                where orders_id = '" . (int)$order_id . "'";

      $orders_products = $db->Execute($orders_products_query);

      while (!$orders_products->EOF) {
// convert quantity to proper decimals - account history
          if (QUANTITY_DECIMALS != 0) {
            $fix_qty = $orders_products->fields['products_quantity'];
            switch (true) {
            case (!strstr($fix_qty, '.')):
              $new_qty = $fix_qty;
              break;
            default:
              $new_qty = preg_replace('/[0]+$/', '', $orders_products->fields['products_quantity']);
              break;
            }
          } else {
            $new_qty = $orders_products->fields['products_quantity'];
          }

          $new_qty = round($new_qty, QUANTITY_DECIMALS);

          if ($new_qty == (int)$new_qty) {
            $new_qty = (int)$new_qty;
          }

        $this->products[$index] = array('qty' => $new_qty,
	                                'id' => $orders_products->fields['products_id'],
                                        'name' => $orders_products->fields['products_name'],
                                        'model' => $orders_products->fields['products_model'],
                                        'tax' => $orders_products->fields['products_tax'],
                                        'price' => $orders_products->fields['products_price'],
                                        'final_price' => $orders_products->fields['final_price'],
                                        'onetime_charges' => $orders_products->fields['onetime_charges'],
                                        'products_priced_by_attribute' => $orders_products->fields['products_priced_by_attribute'],
                                        'product_is_free' => $orders_products->fields['product_is_free'],
                                        'products_discount_type' => $orders_products->fields['products_discount_type'],
                                        'products_discount_type_from' => $orders_products->fields['products_discount_type_from']);

        $subindex = 0;
        $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values, options_values_price,
                                    price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
                             where orders_id = '" . (int)$order_id . "'
                             and orders_products_id = '" . (int)$orders_products->fields['orders_products_id'] . "'";

        $attributes = $db->Execute($attributes_query);
        if ($attributes->RecordCount()) {
          while (!$attributes->EOF) {
            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes->fields['products_options'],
                                                                     'value' => $attributes->fields['products_options_values'],
                                                                     'prefix' => $attributes->fields['price_prefix'],
                                                                     'price' => $attributes->fields['options_values_price']);

            $subindex++;
            $attributes->MoveNext();
          }
        }

        $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

        $index++;
        $orders_products->MoveNext();
      }
    }

    function cart() {
      global $db, $currencies;

      $this->content_type = $_SESSION['cart']->get_content_type();

      $customer_address_query = "select c.customers_firstname, c.customers_lastname, c.customers_telephone,
                                        c.customers_email_address, ab.entry_company, ab.entry_street_address,
                                        ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id,
                                        z.zone_name, co.countries_id, co.countries_name,
                                        co.countries_iso_code_2, co.countries_iso_code_3,
                                        co.address_format_id, ab.entry_state
                                 from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab
                                 left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                 left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id)
                                 where c.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                 and ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                 and c.customers_default_address_id = ab.address_book_id";

      $customer_address = $db->Execute($customer_address_query);

      $shipping_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,
                                        ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,
                                        ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id,
                                        c.countries_id, c.countries_name, c.countries_iso_code_2,
                                        c.countries_iso_code_3, c.address_format_id, ab.entry_state
                                 from " . TABLE_ADDRESS_BOOK . " ab
                                 left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                 left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id)
                                 where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                 and ab.address_book_id = '" . (int)$_SESSION['sendto'] . "'";

      $shipping_address = $db->Execute($shipping_address_query);

      $billing_address_query = "select ab.entry_firstname, ab.entry_lastname, ab.entry_company,
                                       ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,
                                       ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id,
                                       c.countries_id, c.countries_name, c.countries_iso_code_2,
                                       c.countries_iso_code_3, c.address_format_id, ab.entry_state
                                from " . TABLE_ADDRESS_BOOK . " ab
                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id)
                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";

      $billing_address = $db->Execute($billing_address_query);
//STORE_PRODUCT_TAX_BASIS

      switch (STORE_PRODUCT_TAX_BASIS) {
        case 'Shipping':

          $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                from " . TABLE_ADDRESS_BOOK . " ab
                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                and ab.address_book_id = '" . (int)($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'";
          $tax_address = $db->Execute($tax_address_query);
        break;
        case 'Billing':

          $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                from " . TABLE_ADDRESS_BOOK . " ab
                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";
          $tax_address = $db->Execute($tax_address_query);
        break;
        case 'Store':
          if ($billing_address->fields['entry_zone_id'] == STORE_ZONE) {

            $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                  from " . TABLE_ADDRESS_BOOK . " ab
                                  left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                  where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                  and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";
          } else {
            $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                  from " . TABLE_ADDRESS_BOOK . " ab
                                  left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                  where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                  and ab.address_book_id = '" . (int)($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'";
          }
          $tax_address = $db->Execute($tax_address_query);
     }


      $class =& $_SESSION['payment'];

      if (isset($_SESSION['cc_id'])) {
        $coupon_code_query = "select coupon_code
                              from " . TABLE_COUPONS . "
                              where coupon_id = '" . (int)$_SESSION['cc_id'] . "'";

        $coupon_code = $db->Execute($coupon_code_query);


      }

      $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
                          'currency' => $_SESSION['currency'],
                          'currency_value' => $currencies->currencies[$_SESSION['currency']]['value'],
                          'payment_method' => $GLOBALS[$class]->title,
                          'payment_module_code' => $GLOBALS[$class]->code,
                          'coupon_code' => $coupon_code->fields['coupon_code'],
//                          'cc_type' => (isset($GLOBALS['cc_type']) ? $GLOBALS['cc_type'] : ''),
//                          'cc_owner' => (isset($GLOBALS['cc_owner']) ? $GLOBALS['cc_owner'] : ''),
//                          'cc_number' => (isset($GLOBALS['cc_number']) ? $GLOBALS['cc_number'] : ''),
//                          'cc_expires' => (isset($GLOBALS['cc_expires']) ? $GLOBALS['cc_expires'] : ''),
//                          'cc_cvv' => (isset($GLOBALS['cc_cvv']) ? $GLOBALS['cc_cvv'] : ''),
                          'shipping_method' => $_SESSION['shipping']['title'],
                          'shipping_cost' => $_SESSION['shipping']['cost'],
                          'subtotal' => 0,
                          'tax' => 0,
                          'total' => 0,
                          'tax_groups' => array(),
                          'comments' => (isset($_SESSION['comments']) ? $_SESSION['comments'] : ''));

//print_r($GLOBALS[$class]);
//echo $class;
//print_r($GLOBALS);
//echo $_SESSION['payment'];
/*
// this is set above to the module filename it should be set to the module title like Checks/Money Order rather than moneyorder
      if (isset($$_SESSION['payment']) && is_object($$_SESSION['payment'])) {
        $this->info['payment_method'] = $$_SESSION['payment']->title;
      }
*/
      if ($this->info['total'] == 0) {
        if (DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID == 0) {
          $this->info['order_status'] = DEFAULT_ORDERS_STATUS_ID;
        } else {
          $this->info['order_status'] = DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID;
        }
      }
      if (isset($GLOBALS[$class]) && is_object($GLOBALS[$class])) {
        if ( isset($GLOBALS[$class]->order_status) && is_numeric($GLOBALS[$class]->order_status) && ($GLOBALS[$class]->order_status > 0) ) {
          $this->info['order_status'] = $GLOBALS[$class]->order_status;
        }
      }

      $this->customer = array('firstname' => $customer_address->fields['customers_firstname'],
                              'lastname' => $customer_address->fields['customers_lastname'],
                              'company' => $customer_address->fields['entry_company'],
                              'street_address' => $customer_address->fields['entry_street_address'],
                              'suburb' => $customer_address->fields['entry_suburb'],
                              'city' => $customer_address->fields['entry_city'],
                              'postcode' => $customer_address->fields['entry_postcode'],
                              'state' => ((zen_not_null($customer_address->fields['entry_state'])) ? $customer_address->fields['entry_state'] : $customer_address->fields['zone_name']),
                              'zone_id' => $customer_address->fields['entry_zone_id'],
                              'country' => array('id' => $customer_address->fields['countries_id'], 'title' => $customer_address->fields['countries_name'], 'iso_code_2' => $customer_address->fields['countries_iso_code_2'], 'iso_code_3' => $customer_address->fields['countries_iso_code_3']),
                              'format_id' => $customer_address->fields['address_format_id'],
                              'telephone' => $customer_address->fields['customers_telephone'],
                              'email_address' => $customer_address->fields['customers_email_address']);

      $this->delivery = array('firstname' => $shipping_address->fields['entry_firstname'],
                              'lastname' => $shipping_address->fields['entry_lastname'],
                              'company' => $shipping_address->fields['entry_company'],
                              'street_address' => $shipping_address->fields['entry_street_address'],
                              'suburb' => $shipping_address->fields['entry_suburb'],
                              'city' => $shipping_address->fields['entry_city'],
                              'postcode' => $shipping_address->fields['entry_postcode'],
                              'state' => ((zen_not_null($shipping_address->fields['entry_state'])) ? $shipping_address->fields['entry_state'] : $shipping_address->fields['zone_name']),
                              'zone_id' => $shipping_address->fields['entry_zone_id'],
                              'country' => array('id' => $shipping_address->fields['countries_id'], 'title' => $shipping_address->fields['countries_name'], 'iso_code_2' => $shipping_address->fields['countries_iso_code_2'], 'iso_code_3' => $shipping_address->fields['countries_iso_code_3']),
                              'country_id' => $shipping_address->fields['entry_country_id'],
                              'format_id' => $shipping_address->fields['address_format_id']);

      $this->billing = array('firstname' => $billing_address->fields['entry_firstname'],
                             'lastname' => $billing_address->fields['entry_lastname'],
                             'company' => $billing_address->fields['entry_company'],
                             'street_address' => $billing_address->fields['entry_street_address'],
                             'suburb' => $billing_address->fields['entry_suburb'],
                             'city' => $billing_address->fields['entry_city'],
                             'postcode' => $billing_address->fields['entry_postcode'],
                             'state' => ((zen_not_null($billing_address->fields['entry_state'])) ? $billing_address->fields['entry_state'] : $billing_address->fields['zone_name']),
                             'zone_id' => $billing_address->fields['entry_zone_id'],
                             'country' => array('id' => $billing_address->fields['countries_id'], 'title' => $billing_address->fields['countries_name'], 'iso_code_2' => $billing_address->fields['countries_iso_code_2'], 'iso_code_3' => $billing_address->fields['countries_iso_code_3']),
                             'country_id' => $billing_address->fields['entry_country_id'],
                             'format_id' => $billing_address->fields['address_format_id']);

      $index = 0;
      $products = $_SESSION['cart']->get_products();
      for ($i=0, $n=sizeof($products); $i<$n; $i++) {
        $this->products[$index] = array('qty' => $products[$i]['quantity'],
                                        'name' => $products[$i]['name'],
                                        'model' => $products[$i]['model'],
                                        'tax' => zen_get_tax_rate($products[$i]['tax_class_id'], $tax_address->fields['entry_country_id'], $tax_address->fields['entry_zone_id']),
                                        'tax_description' => zen_get_tax_description($products[$i]['tax_class_id'], $tax_address->fields['entry_country_id'], $tax_address->fields['entry_zone_id']),
                                        'price' => $products[$i]['price'],
                                        'final_price' => $products[$i]['price'] + $_SESSION['cart']->attributes_price($products[$i]['id']),
                                        'onetime_charges' => $_SESSION['cart']->attributes_price_onetime_charges($products[$i]['id'], $products[$i]['quantity']),
                                        'weight' => $products[$i]['weight'],
                                        'products_priced_by_attribute' => $products[$i]['products_priced_by_attribute'],
                                        'product_is_free' => $products[$i]['product_is_free'],
                                        'products_discount_type' => $products[$i]['products_discount_type'],
                                        'products_discount_type_from' => $products[$i]['products_discount_type_from'],
                                        'id' => $products[$i]['id']);

        if ($products[$i]['attributes']) {
          $subindex = 0;
          reset($products[$i]['attributes']);
          while (list($option, $value) = each($products[$i]['attributes'])) {
/*
	//clr 030714 Determine if attribute is a text attribute and change products array if it is.
            if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID){
              $attr_value = $products[$i]['attributes_values'][$option];
            } else {
              $attr_value = $attributes->fields['products_options_values_name'];
            }
*/

            $attributes_query = "select popt.products_options_name, poval.products_options_values_name,
                                        pa.options_values_price, pa.price_prefix
                                 from " . TABLE_PRODUCTS_OPTIONS . " popt,
                                      " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval,
                                      " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                 where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                 and pa.options_id = '" . (int)$option . "'
                                 and pa.options_id = popt.products_options_id
                                 and pa.options_values_id = '" . (int)$value . "'
                                 and pa.options_values_id = poval.products_options_values_id
                                 and popt.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                 and poval.language_id = '" . (int)$_SESSION['languages_id'] . "'";

            $attributes = $db->Execute($attributes_query);

	//clr 030714 Determine if attribute is a text attribute and change products array if it is.
            if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID){
              $attr_value = $products[$i]['attributes_values'][$option];
            } else {
              $attr_value = $attributes->fields['products_options_values_name'];
            }

            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes->fields['products_options_name'],
                                                                     'value' => $attr_value,
                                                                     'option_id' => $option,
                                                                     'value_id' => $value,
                                                                     'prefix' => $attributes->fields['price_prefix'],
                                                                     'price' => $attributes->fields['options_values_price']);

            $subindex++;
          }
        }

// add onetime charges here
//$_SESSION['cart']->attributes_price_onetime_charges($products[$i]['id'], $products[$i]['quantity'])

        $shown_price = (zen_add_tax($this->products[$index]['final_price'], $this->products[$index]['tax']) * $this->products[$index]['qty'])
                      + zen_add_tax($this->products[$index]['onetime_charges'], $this->products[$index]['tax']);
        $this->info['subtotal'] += $shown_price;

        $products_tax = $this->products[$index]['tax'];
        $products_tax_description = $this->products[$index]['tax_description'];
        if (DISPLAY_PRICE_WITH_TAX == 'true') {
          $this->info['tax'] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          if (isset($this->info['tax_groups']["$products_tax_description"])) {
            $this->info['tax_groups']["$products_tax_description"] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          } else {
            $this->info['tax_groups']["$products_tax_description"] = $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          }
        } else {
          $this->info['tax'] += ($products_tax / 100) * $shown_price;
          if (isset($this->info['tax_groups']["$products_tax_description"])) {
            $this->info['tax_groups']["$products_tax_description"] += ($products_tax / 100) * $shown_price;
          } else {
            $this->info['tax_groups']["$products_tax_description"] = ($products_tax / 100) * $shown_price;
          }
        }
        $this->info['tax'] = zen_round($this->info['tax'],2);
        $index++;
      }

      if (DISPLAY_PRICE_WITH_TAX == 'true') {
        $this->info['total'] = $this->info['subtotal'] + $this->info['shipping_cost'];
      } else {
        $this->info['total'] = $this->info['subtotal'] + $this->info['tax'] + $this->info['shipping_cost'];
      }
    }

    function create($zf_ot_modules, $zf_mode = 2) {
      global $db;

      $sql_data_array = array('customers_id' => $_SESSION['customer_id'],
                          'customers_name' => $this->customer['firstname'] . ' ' . $this->customer['lastname'],
                          'customers_company' => $this->customer['company'],
                          'customers_street_address' => $this->customer['street_address'],
                          'customers_suburb' => $this->customer['suburb'],
                          'customers_city' => $this->customer['city'],
                          'customers_postcode' => $this->customer['postcode'],
                          'customers_state' => $this->customer['state'],
                          'customers_country' => $this->customer['country']['title'],
                          'customers_telephone' => $this->customer['telephone'],
                          'customers_email_address' => $this->customer['email_address'],
                          'customers_address_format_id' => $this->customer['format_id'],
                          'delivery_name' => $this->delivery['firstname'] . ' ' . $this->delivery['lastname'],
                          'delivery_company' => $this->delivery['company'],
                          'delivery_street_address' => $this->delivery['street_address'],
                          'delivery_suburb' => $this->delivery['suburb'],
                          'delivery_city' => $this->delivery['city'],
                          'delivery_postcode' => $this->delivery['postcode'],
                          'delivery_state' => $this->delivery['state'],
                          'delivery_country' => $this->delivery['country']['title'],
                          'delivery_address_format_id' => $this->delivery['format_id'],
                          'billing_name' => $this->billing['firstname'] . ' ' . $this->billing['lastname'],
                          'billing_company' => $this->billing['company'],
                          'billing_street_address' => $this->billing['street_address'],
                          'billing_suburb' => $this->billing['suburb'],
                          'billing_city' => $this->billing['city'],
                          'billing_postcode' => $this->billing['postcode'],
                          'billing_state' => $this->billing['state'],
                          'billing_country' => $this->billing['country']['title'],
                          'billing_address_format_id' => $this->billing['format_id'],
                          'payment_method' => $this->info['payment_method'],
                          'payment_module_code' => $this->info['payment_module_code'],
                          'coupon_code' => $this->info['coupon_code'],
                          'cc_type' => $this->info['cc_type'],
                          'cc_owner' => $this->info['cc_owner'],
                          'cc_number' => $this->info['cc_number'],
                          'cc_expires' => $this->info['cc_expires'],
                          'date_purchased' => 'now()',
                          'orders_status' => $this->info['order_status'],
                          'order_total' => $this->info['total'],
                          'order_tax' => $this->info['tax'],
                          'currency' => $this->info['currency'],
                          'currency_value' => $this->info['currency_value']);


      zen_db_perform(TABLE_ORDERS, $sql_data_array);

      $insert_id = $db->Insert_ID();

      for ($i=0, $n=sizeof($zf_ot_modules); $i<$n; $i++) {
        $sql_data_array = array('orders_id' => $insert_id,
                                'title' => $zf_ot_modules[$i]['title'],
                                'text' => $zf_ot_modules[$i]['text'],
                                'value' => $zf_ot_modules[$i]['value'],
                                'class' => $zf_ot_modules[$i]['code'],
                                'sort_order' => $zf_ot_modules[$i]['sort_order']);

        zen_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
      }

      $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
      $sql_data_array = array('orders_id' => $insert_id,
                          'orders_status_id' => $this->info['order_status'],
                          'date_added' => 'now()',
                          'customer_notified' => $customer_notification,
                          'comments' => $this->info['comments']);

      zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

      return($insert_id);

    }


    function  create_add_products($zf_insert_id, $zf_mode = false) {
      global $db, $currencies, $order_total_modules, $order_totals;

// initialized for the email confirmation

      $this->products_ordered = '';
      $this->products_ordered_html = '';
      $this->subtotal = 0;
      $this->total_tax = 0;

// lowstock email report
      $this->email_low_stock='';

  for ($i=0, $n=sizeof($this->products); $i<$n; $i++) {
// Stock Update - Joao Correia
        if (STOCK_LIMITED == 'true') {
          if (DOWNLOAD_ENABLED == 'true') {
            $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename
                            FROM " . TABLE_PRODUCTS . " p
                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                             ON p.products_id=pa.products_id
                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                             ON pa.products_attributes_id=pad.products_attributes_id
                            WHERE p.products_id = '" . zen_get_prid($this->products[$i]['id']) . "'";

// Will work with only one option for downloadable products
// otherwise, we have to build the query dynamically with a loop
            $products_attributes = $this->products[$i]['attributes'];
            if (is_array($products_attributes)) {
              $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
            }
            $stock_values = $db->Execute($stock_query_raw);
          } else {
            $stock_values = $db->Execute("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . zen_get_prid($this->products[$i]['id']) . "'");
          }


          if ($stock_values->RecordCount() > 0) {
// do not decrement quantities if products_attributes_filename exists
            if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values->fields['products_attributes_filename'])) {
              $stock_left = $stock_values->fields['products_quantity'] - $this->products[$i]['qty'];
              $this->products[$i]['stock_reduce'] = $this->products[$i]['qty'];
            } else {
              $stock_left = $stock_values->fields['products_quantity'];
            }

//            $this->products[$i]['stock_value'] = $stock_values->fields['products_quantity'];

             $db->Execute("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . zen_get_prid($this->products[$i]['id']) . "'");
//        if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {
            if ($stock_left < 1) {
// only set status to off when not displaying sold out
              if (SHOW_PRODUCTS_SOLD_OUT == '0') {
                 $db->Execute("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . zen_get_prid($this->products[$i]['id']) . "'");
              }
            }

// for low stock email
            if ( $stock_left <= STOCK_REORDER_LEVEL ) {
          // WebMakers.com Added: add to low stock email
              $this->email_low_stock .=  'ID# ' . zen_get_prid($this->products[$i]['id']) . "\t\t" . $this->products[$i]['model'] . "\t\t" . $this->products[$i]['name'] . "\t\t" . ' Qty Left: ' . $stock_left . "\n";
            }
          }
        }

// Update products_ordered (for bestsellers list)
//    $db->Execute("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . zen_get_prid($order->products[$i]['id']) . "'");
         $db->Execute("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%f', $this->products[$i]['qty']) . " where products_id = '" . zen_get_prid($this->products[$i]['id']) . "'");

        $sql_data_array = array('orders_id' => $zf_insert_id,
                            'products_id' => zen_get_prid($this->products[$i]['id']),
                            'products_model' => $this->products[$i]['model'],
                            'products_name' => $this->products[$i]['name'],
                            'products_price' => $this->products[$i]['price'],
                            'final_price' => $this->products[$i]['final_price'],
                            'onetime_charges' => $this->products[$i]['onetime_charges'],
                            'products_tax' => $this->products[$i]['tax'],
                            'products_quantity' => $this->products[$i]['qty'],
                            'products_priced_by_attribute' => $this->products[$i]['products_priced_by_attribute'],
                            'product_is_free' => $this->products[$i]['product_is_free'],
                            'products_discount_type' => $this->products[$i]['products_discount_type'],
                            'products_discount_type_from' => $this->products[$i]['products_discount_type_from']);
        zen_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

        $order_products_id = $db->Insert_ID();

        $order_total_modules->update_credit_account($i);//ICW ADDED FOR CREDIT CLASS SYSTEM

//------insert customer choosen option to order--------
        $attributes_exist = '0';
        $this->products_ordered_attributes = '';
        if (isset($this->products[$i]['attributes'])) {
           $attributes_exist = '1';
           for ($j=0, $n2=sizeof($this->products[$i]['attributes']); $j<$n2; $j++) {
           if (DOWNLOAD_ENABLED == 'true') {
             $attributes_query = "select popt.products_options_name, poval.products_options_values_name,
                               pa.options_values_price, pa.price_prefix,
                               pa.product_attribute_is_free, pa.products_attributes_weight, pa.products_attributes_weight_prefix,
                               pa.attributes_discounted, pa.attributes_price_base_included, pa.attributes_price_onetime,
                               pa.attributes_price_factor, pa.attributes_price_factor_offset,
                               pa.attributes_price_factor_onetime, pa.attributes_price_factor_onetime_offset,
                               pa.attributes_qty_prices, pa.attributes_qty_prices_onetime,
                               pa.attributes_price_words, pa.attributes_price_words_free,
                               pa.attributes_price_letters, pa.attributes_price_letters_free,
                               pad.products_attributes_maxdays, pad.products_attributes_maxcount, pad.products_attributes_filename,
                               pa.product_attribute_is_free, pa.attributes_discounted
                               from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                               left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                on pa.products_attributes_id=pad.products_attributes_id
                               where pa.products_id = '" . zen_db_input($this->products[$i]['id']) . "'
                                and pa.options_id = '" . $this->products[$i]['attributes'][$j]['option_id'] . "'
                                and pa.options_id = popt.products_options_id
                                and pa.options_values_id = '" . $this->products[$i]['attributes'][$j]['value_id'] . "'
                                and pa.options_values_id = poval.products_options_values_id
                                and popt.language_id = '" . $_SESSION['languages_id'] . "'
                                and poval.language_id = '" . $_SESSION['languages_id'] . "'";

             $attributes_values = $db->Execute($attributes_query);
           } else {
             $attributes_values = $db->Execute("select popt.products_options_name, poval.products_options_values_name,
                               pa.options_values_price, pa.price_prefix,
                               pa.product_attribute_is_free, pa.products_attributes_weight, pa.products_attributes_weight_prefix,
                               pa.attributes_discounted, pa.attributes_price_base_included, pa.attributes_price_onetime,
                               pa.attributes_price_factor, pa.attributes_price_factor_offset,
                               pa.attributes_price_factor_onetime, pa.attributes_price_factor_onetime_offset,
                               pa.attributes_qty_prices, pa.attributes_qty_prices_onetime,
                               pa.attributes_price_words, pa.attributes_price_words_free,
                               pa.attributes_price_letters, pa.attributes_price_letters_free
                               from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                               where pa.products_id = '" . $this->products[$i]['id'] . "' and pa.options_id = '" . $this->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $this->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $_SESSION['languages_id'] . "' and poval.language_id = '" . $_SESSION['languages_id'] . "'");
           }

//clr 030714 update insert query.  changing to use values form $order->products for products_options_values.
           $sql_data_array = array('orders_id' => $zf_insert_id,
                                   'orders_products_id' => $order_products_id,
                                   'products_options' => $attributes_values->fields['products_options_name'],

//                                 'products_options_values' => $attributes_values->fields['products_options_values_name'],
                                   'products_options_values' => $this->products[$i]['attributes'][$j]['value'],
                                   'options_values_price' => $attributes_values->fields['options_values_price'],
                                   'price_prefix' => $attributes_values->fields['price_prefix'],
                                   'product_attribute_is_free' => $attributes_values->fields['product_attribute_is_free'],
                                   'products_attributes_weight' => $attributes_values->fields['products_attributes_weight'],
                                   'products_attributes_weight_prefix' => $attributes_values->fields['products_attributes_weight_prefix'],
                                   'attributes_discounted' => $attributes_values->fields['attributes_discounted'],
                                   'attributes_price_base_included' => $attributes_values->fields['attributes_price_base_included'],
                                   'attributes_price_onetime' => $attributes_values->fields['attributes_price_onetime'],
                                   'attributes_price_factor' => $attributes_values->fields['attributes_price_factor'],
                                   'attributes_price_factor_offset' => $attributes_values->fields['attributes_price_factor_offset'],
                                   'attributes_price_factor_onetime' => $attributes_values->fields['attributes_price_factor_onetime'],
                                   'attributes_price_factor_onetime_offset' => $attributes_values->fields['attributes_price_factor_onetime_offset'],
                                   'attributes_qty_prices' => $attributes_values->fields['attributes_qty_prices'],
                                   'attributes_qty_prices_onetime' => $attributes_values->fields['attributes_qty_prices_onetime'],
                                   'attributes_price_words' => $attributes_values->fields['attributes_price_words'],
                                   'attributes_price_words_free' => $attributes_values->fields['attributes_price_words_free'],
                                   'attributes_price_letters' => $attributes_values->fields['attributes_price_letters'],
                                   'attributes_price_letters_free' => $attributes_values->fields['attributes_price_letters_free']
                                   );


           zen_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

           if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values->fields['products_attributes_filename']) && zen_not_null($attributes_values->fields['products_attributes_filename'])) {
             $sql_data_array = array('orders_id' => $zf_insert_id,
                                     'orders_products_id' => $order_products_id,
                                     'orders_products_filename' => $attributes_values->fields['products_attributes_filename'],
                                     'download_maxdays' => $attributes_values->fields['products_attributes_maxdays'],
                                     'download_count' => $attributes_values->fields['products_attributes_maxcount']);

             zen_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
           }
//clr 030714 changing to use values from $orders->products and adding call to zen_decode_specialchars()
//        $this->products_ordered_attributes .= "\n\t" . $attributes_values->fields['products_options_name'] . ' ' . $attributes_values->fields['products_options_values_name'];
           $this->products_ordered_attributes .= "\n\t" . $attributes_values->fields['products_options_name'] . ' ' . zen_decode_specialchars($this->products[$i]['attributes'][$j]['value']);
        }
      }
//------insert customer choosen option eof ----
      $this->total_weight += ($this->products[$i]['qty'] * $this->products[$i]['weight']);
      $this->total_tax += zen_calculate_tax($total_products_price, $products_tax) * $this->products[$i]['qty'];
      $this->total_cost += $total_products_price;

// include onetime charges
      $this->products_ordered .=  $this->products[$i]['qty'] . ' x ' . $this->products[$i]['name'] . ' (' . $this->products[$i]['model'] . ') = ' .
                            $currencies->display_price($this->products[$i]['final_price'], $this->products[$i]['tax'], $this->products[$i]['qty']) .
                            ($this->products[$i]['onetime_charges'] !=0 ? "\n" . TEXT_ONETIME_CHARGES_EMAIL . $currencies->display_price($this->products[$i]['onetime_charges'], $this->products[$i]['tax'], 1) : '') .
                            $this->products_ordered_attributes . "\n";
      $this->products_ordered_html .=
	'<tr>' .
	'<td class="product-details" align="right" valign="top" width="30">' . $this->products[$i]['qty'] . '&nbsp;x</td>' .
	'<td class="product-details" valign="top">' . $this->products[$i]['name'] . ' (' . $this->products[$i]['model'] . ')' .
	'<nobr><small><em> '. $this->products_ordered_attributes .'</em></small></nobr></td>' .
	'<td class="product-details-num" valign="top" align="right">' .
	    $currencies->display_price($this->products[$i]['final_price'], $this->products[$i]['tax'], $this->products[$i]['qty']) .
	    ($this->products[$i]['onetime_charges'] !=0 ?
                 '</td></tr><tr><td class="product-details">' . TEXT_ONETIME_CHARGES_EMAIL . '</td>' .
                 '<td>' . $currencies->display_price($this->products[$i]['onetime_charges'], $this->products[$i]['tax'], 1) : '') .
	'</td></tr>';
    }

     $order_total_modules->apply_credit();//ICW ADDED FOR CREDIT CLASS SYSTEM
    }


    function send_order_email($zf_insert_id, $zf_mode) {
      global $currencies, $order_totals;

//      print_r($this);
//      die();
      if ($this->email_low_stock != '' and SEND_LOWSTOCK_EMAIL=='1') {
  // send an email
          $email_low_stock = SEND_EXTRA_LOW_STOCK_EMAIL_TITLE . "\n\n" . $this->email_low_stock;
          zen_mail('', SEND_EXTRA_LOW_STOCK_EMAILS_TO, EMAIL_TEXT_SUBJECT_LOWSTOCK, $email_low_stock, STORE_OWNER, EMAIL_FROM, array('EMAIL_MESSAGE_HTML' => nl2br($email_low_stock)),'low_stock');
      }

// lets start with the email confirmation
// make an array to store the html version
        $html_msg=array();

//intro area
        $email_order = EMAIL_TEXT_HEADER . EMAIL_TEXT_FROM . STORE_NAME . "\n\n" .
                       $this->customer['firstname'] . ' ' . $this->customer['lastname'] . "\n\n" .
                       EMAIL_THANKS_FOR_SHOPPING . "\n" . EMAIL_DETAILS_FOLLOW . "\n" .
                       EMAIL_SEPARATOR . "\n" .
                       EMAIL_TEXT_ORDER_NUMBER . ' ' . $zf_insert_id . "\n" .
                       EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n" .
                       EMAIL_TEXT_INVOICE_URL . ' ' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false) . "\n\n";
        $html_msg['EMAIL_TEXT_HEADER']     = EMAIL_TEXT_HEADER;
        $html_msg['EMAIL_TEXT_FROM']       = EMAIL_TEXT_FROM;
        $html_msg['INTRO_STORE_NAME']      = STORE_NAME;
        $html_msg['EMAIL_THANKS_FOR_SHOPPING'] = EMAIL_THANKS_FOR_SHOPPING;
        $html_msg['EMAIL_DETAILS_FOLLOW']  = EMAIL_DETAILS_FOLLOW;
        $html_msg['INTRO_ORDER_NUM_TITLE'] = EMAIL_TEXT_ORDER_NUMBER;
        $html_msg['INTRO_ORDER_NUMBER']    = $zf_insert_id;
        $html_msg['INTRO_DATE_TITLE']      = EMAIL_TEXT_DATE_ORDERED;
        $html_msg['INTRO_DATE_ORDERED']    = strftime(DATE_FORMAT_LONG);
        $html_msg['INTRO_URL_TEXT']        = EMAIL_TEXT_INVOICE_URL_CLICK;
        $html_msg['INTRO_URL_VALUE']       = zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false);

//comments area
        if ($this->info['comments']) {
          $email_order .= zen_db_output($this->info['comments']) . "\n\n";
          $html_msg['ORDER_COMMENTS'] = zen_db_output($this->info['comments']);
        } else {
          $html_msg['ORDER_COMMENTS'] = '';
        }

//products area
        $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .
                        EMAIL_SEPARATOR . "\n" .
                        $this->products_ordered .
                        EMAIL_SEPARATOR . "\n";
        $html_msg['PRODUCTS_TITLE'] = EMAIL_TEXT_PRODUCTS;
        $html_msg['PRODUCTS_DETAIL']='<table class="product-details" border="0" width="100%" cellspacing="0" cellpadding="2">' . $this->products_ordered_html . '</table>';

//order totals area
        $html_ot .= '<td class="order-totals-text" align="right" width="100%">' . '&nbsp;' . '</td><td class="order-totals-num" align="right" nowrap="nowrap">' . '---------' .'</td></tr><tr>';
        for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
          $email_order .= strip_tags($order_totals[$i]['title']) . ' ' . strip_tags($order_totals[$i]['text']) . "\n";
      	$html_ot .= '<td class="order-totals-text" align="right" width="100%">' . $order_totals[$i]['title'] . '</td><td class="order-totals-num" align="right" nowrap="nowrap">' .($order_totals[$i]['text']) .'</td></tr><tr>';
        }
        $html_msg['ORDER_TOTALS'] = '<table border="0" width="100%" cellspacing="0" cellpadding="2">' . $html_ot . '</table>';

//addresses area: Delivery
        $html_msg['HEADING_ADDRESS_INFORMATION']= HEADING_ADDRESS_INFORMATION;
	  $html_msg['ADDRESS_DELIVERY_TITLE']     = EMAIL_TEXT_DELIVERY_ADDRESS;
	  $html_msg['ADDRESS_DELIVERY_DETAIL']    = ($this->content_type != 'virtual') ? zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, '', "<br />") : 'n/a';
	  $html_msg['SHIPPING_METHOD_TITLE']      = HEADING_SHIPPING_METHOD;
	  $html_msg['SHIPPING_METHOD_DETAIL']     = (zen_not_null($this->info['shipping_method'])) ? $this->info['shipping_method'] : 'n/a';

        if ($this->content_type != 'virtual') {
          $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" .
                          EMAIL_SEPARATOR . "\n" .
         zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], 0, '', "\n") . "\n";
        }

//addresses area: Billing
        $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                        EMAIL_SEPARATOR . "\n" .
                       zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], 0, '', "\n") . "\n\n";
	  $html_msg['ADDRESS_BILLING_TITLE']   = EMAIL_TEXT_BILLING_ADDRESS;
	  $html_msg['ADDRESS_BILLING_DETAIL']  = zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, '', "<br />");

    if (is_object($GLOBALS[$_SESSION['payment']])) {
          $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .
                          EMAIL_SEPARATOR . "\n";
          $payment_class = $_SESSION['payment'];
          $email_order .= $GLOBALS[$payment_class]->title . "\n\n";
          if ($GLOBALS[$payment_class]->email_footer) {
            $email_order .= $GLOBALS[$payment_class]->email_footer . "\n\n";
          }
        }
	  $html_msg['PAYMENT_METHOD_TITLE']  = (is_object($GLOBALS[$_SESSION['payment']]) ? EMAIL_TEXT_PAYMENT_METHOD : '') ;
	  $html_msg['PAYMENT_METHOD_DETAIL'] = (is_object($GLOBALS[$_SESSION['payment']]) ? $GLOBALS[$payment_class]->title : '' );
	  $html_msg['PAYMENT_METHOD_FOOTER'] = (is_object($GLOBALS[$_SESSION['payment']]) ? $GLOBALS[$payment_class]->email_footer : '');

// include disclaimer
        $email_order .= "\n-----\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS) . "\n\n";
// include copyright
        $email_order .= "\n-----\n" . EMAIL_FOOTER_COPYRIGHT . "\n\n";

        while (strstr($email_order, '&nbsp;')) $email_order = str_replace('&nbsp;', ' ', $email_order);

        $html_msg['EMAIL_FIRST_NAME'] = $this->customer['firstname'];
        $html_msg['EMAIL_LAST_NAME'] = $this->customer['lastname'];
//  $html_msg['EMAIL_TEXT_HEADER'] = EMAIL_TEXT_HEADER;
        $html_msg['EXTRA_INFO'] = '';
        zen_mail($this->customer['firstname'] . ' ' . $this->customer['lastname'], $this->customer['email_address'], EMAIL_TEXT_SUBJECT . EMAIL_ORDER_NUMBER_SUBJECT . $zf_insert_id, $email_order, STORE_NAME, EMAIL_FROM, $html_msg, 'checkout');

// send additional emails
       if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
	   $extra_info=email_collect_extra_info('','', $this->customer['firstname'] . ' ' . $this->customer['lastname'], $this->customer['email_address'], $this->customer['telephone']);
         $html_msg['EXTRA_INFO'] = $extra_info['HTML'];
         zen_mail('', SEND_EXTRA_ORDER_EMAILS_TO, SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT . ' ' . EMAIL_TEXT_SUBJECT . EMAIL_ORDER_NUMBER_SUBJECT . $zf_insert_id,
         $email_order . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'checkout_extra');
      }
    }

  }
?>
<?php
/**
 * Login Page
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6528 2007-06-25 23:25:27Z drbyte $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_LOGIN');

// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
if ($session_started == false) {
  zen_redirect(zen_href_link(FILENAME_COOKIE_USAGE));
}

// if the customer is logged in already, redirect them to the My account page
  if (isset($_SESSION['customer_id']) and $_SESSION['customer_id'] != '') {
    zen_redirect(zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  }

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_CREATE_ACCOUNT));

$error = false;
if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
  $email_address = zen_db_prepare_input($_POST['email_address']);
  $password = zen_db_prepare_input($_POST['password']);

  /* Privacy-policy-read does not need to be checked during "login"
  if (DISPLAY_PRIVACY_CONDITIONS == 'true') {
  if (!isset($_POST['privacy_conditions']) || ($_POST['privacy_conditions'] != '1')) {
  $error = true;
  $messageStack->add('create_account', ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED, 'error');
  }
  }
  */


  // Check if email exists
  $check_customer_query = "SELECT customers_id, customers_firstname, customers_password,
                                    customers_email_address, customers_default_address_id,
                                    customers_authorization, customers_referral
                           FROM " . TABLE_CUSTOMERS . "
                           WHERE customers_email_address = :email";

  $check_customer_query  =$db->bindVars($check_customer_query, ':email', $email_address, 'string');
  $check_customer = $db->Execute($check_customer_query);

  if (!$check_customer->RecordCount()) {
    $error = true;
  } else {
    // Check that password is good
    if (!zen_validate_password($password, $check_customer->fields['customers_password'])) {
      $error = true;
    } else {
      if (SESSION_RECREATE == 'True') {
        zen_session_recreate();
      }

      $check_country_query = "SELECT entry_country_id, entry_zone_id
                              FROM " . TABLE_ADDRESS_BOOK . "
                              WHERE customers_id = :customersID
                              AND address_book_id = :adressBookID";

      $check_country_query = $db->bindVars($check_country_query, ':customersID', $check_customer->fields['customers_id'], 'integer');
      $check_country_query = $db->bindVars($check_country_query, ':adressBookID', $check_customer->fields['customers_default_address_id'], 'integer');
      $check_country = $db->Execute($check_country_query);

      $_SESSION['customer_id'] = $check_customer->fields['customers_id'];
      $_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
      $_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
      $_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
      $_SESSION['customer_country_id'] = $check_country->fields['entry_country_id'];
      $_SESSION['customer_zone_id'] = $check_country->fields['entry_zone_id'];

      $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
              SET customers_info_date_of_last_logon = now(),
                  customers_info_number_of_logons = customers_info_number_of_logons+1
              WHERE customers_info_id = :customersID";

      $sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
      $db->Execute($sql);
      $zco_notifier->notify('NOTIFY_LOGIN_SUCCESS');

      // restore cart contents
      $_SESSION['cart']->restore_contents();
      /*
      if ($_SESSION['cart']->count_contents() > 0) {
      zen_redirect(zen_href_link(FILENAME_CHECKOUT_SHIPPING));
      }
      */
      if (sizeof($_SESSION['navigation']->snapshot) > 0) {
        //    $back = sizeof($_SESSION['navigation']->path)-2;
        //if (isset($_SESSION['navigation']->path[$back]['page'])) {
        //    if (sizeof($_SESSION['navigation']->path)-2 > 0) {
        $origin_href = zen_href_link($_SESSION['navigation']->snapshot['page'], zen_array_to_string($_SESSION['navigation']->snapshot['get'], array(zen_session_name())), $_SESSION['navigation']->snapshot['mode']);
        //            $origin_href = zen_back_link_only(true);
        $_SESSION['navigation']->clear_snapshot();
        zen_redirect($origin_href);
      } else {
        zen_redirect(zen_href_link(FILENAME_DEFAULT));
      }
    }
  }
}

if ($error == true) {
  $messageStack->add('login', TEXT_LOGIN_ERROR);
  $zco_notifier->notify('NOTIFY_LOGIN_FAILURE');
}

$breadcrumb->add(NAVBAR_TITLE);

// Check for PayPal express checkout button suitability:
$paypalec_enabled = (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True');
// Check for express checkout button suitability:
$ec_button_enabled = ($paypalec_enabled && ($_SESSION['cart']->count_contents() > 0 && $_SESSION['cart']->total > 0));


// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_LOGIN');
?>
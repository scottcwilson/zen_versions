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
//  $Id: orders.php 528 2004-11-10 15:56:02Z wilt $
//

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status = $db->Execute("select orders_status_id, orders_status_name
                                 from " . TABLE_ORDERS_STATUS . "
                                 where language_id = '" . (int)$_SESSION['languages_id'] . "'");


  while (!$orders_status->EOF) {
    $orders_statuses[] = array('id' => $orders_status->fields['orders_status_id'],
                               'text' => $orders_status->fields['orders_status_name'] . ' [' . $orders_status->fields['orders_status_id'] . ']');
    $orders_status_array[$orders_status->fields['orders_status_id']] = $orders_status->fields['orders_status_name'];
    $orders_status->MoveNext();
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (zen_not_null($action)) {
    switch ($action) {
      case 'update_order':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        }
        $oID = zen_db_prepare_input($_GET['oID']);
        $status = zen_db_prepare_input($_POST['status']);
        $comments = zen_db_prepare_input($_POST['comments']);

        $order_updated = false;
        $check_status = $db->Execute("select customers_name, customers_email_address, orders_status,
                                      date_purchased from " . TABLE_ORDERS . "
                                      where orders_id = '" . (int)$oID . "'");

        if ( ($check_status->fields['orders_status'] != $status) || zen_not_null($comments)) {
          $db->Execute("update " . TABLE_ORDERS . "
                        set orders_status = '" . zen_db_input($status) . "', last_modified = now()
                        where orders_id = '" . (int)$oID . "'");

          $customer_notified = '0';
          if (isset($_POST['notify']) && ($_POST['notify'] == 'on')) {
            $notify_comments = '';
            if (isset($_POST['notify_comments']) && ($_POST['notify_comments'] == 'on') && zen_not_null($comments)) {
              $notify_comments = EMAIL_TEXT_COMMENTS_UPDATE . $comments . "\n\n";
            }


//send emails
      $message = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" .
      EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n\n" .
      EMAIL_TEXT_INVOICE_URL . ' ' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n\n" .
      EMAIL_TEXT_DATE_ORDERED . ' ' . zen_date_long($check_status->fields['date_purchased']) . "\n\n" .
      strip_tags($notify_comments) .
      EMAIL_TEXT_STATUS_UPDATED . sprintf(EMAIL_TEXT_STATUS_LABEL, $orders_status_array[$status] ) . 
      EMAIL_TEXT_STATUS_PLEASE_REPLY;

      $html_msg['EMAIL_CUSTOMERS_NAME']    = $check_status->fields['customers_name'];
      $html_msg['EMAIL_TEXT_ORDER_NUMBER'] = EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID;
      $html_msg['EMAIL_TEXT_INVOICE_URL']  = '<a href="' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') .'">'.str_replace(':','',EMAIL_TEXT_INVOICE_URL).'</a>';
      $html_msg['EMAIL_TEXT_DATE_ORDERED'] = EMAIL_TEXT_DATE_ORDERED . ' ' . zen_date_long($check_status->fields['date_purchased']);
      $html_msg['EMAIL_TEXT_STATUS_COMMENTS'] = $notify_comments;
      $html_msg['EMAIL_TEXT_STATUS_UPDATED'] = str_replace('\n','', EMAIL_TEXT_STATUS_UPDATED);
      $html_msg['EMAIL_TEXT_STATUS_LABEL'] = str_replace('\n','', sprintf(EMAIL_TEXT_STATUS_LABEL, $orders_status_array[$status] ));
      $html_msg['EMAIL_TEXT_NEW_STATUS'] = $orders_status_array[$status];
      $html_msg['EMAIL_TEXT_STATUS_PLEASE_REPLY'] = str_replace('\n','', EMAIL_TEXT_STATUS_PLEASE_REPLY);

            zen_mail($check_status->fields['customers_name'], $check_status->fields['customers_email_address'], EMAIL_TEXT_SUBJECT . ' #' . $oID, $message, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status');

            $customer_notified = '1';
//send extra emails
            if (SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_STATUS == '1' and SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO != '') {
              zen_mail('', SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO, SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_SUBJECT . ' ' . EMAIL_TEXT_SUBJECT . ' #' . $oID, $message, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status_extra');
            }
          }

          $db->Execute("insert into " . TABLE_ORDERS_STATUS_HISTORY . "
                      (orders_id, orders_status_id, date_added, customer_notified, comments)
                      values ('" . (int)$oID . "',
                      '" . zen_db_input($status) . "',
                      now(),
                      '" . zen_db_input($customer_notified) . "',
                      '" . zen_db_input($comments)  . "')");

          $order_updated = true;
        }

        if ($order_updated == true) {
         if ($status == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE) {
            // adjust download_maxdays based on current date
            $zc_max_days = date_diff($check_status->fields['date_purchased'], date('Y-m-d H:i:s', time())) + DOWNLOAD_MAX_DAYS;

            $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays='" . $zc_max_days . "', download_count='" . DOWNLOAD_MAX_COUNT . "' where orders_id='" . (int)$oID . "'";
            $db->Execute($update_downloads_query);
          }
          $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        } else {
          $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
        }

        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'deleteconfirm':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')), 'NONSSL'));
        }
        $oID = zen_db_prepare_input($_GET['oID']);

        zen_remove_order($oID, $_POST['restock']);

        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')), 'NONSSL'));
        break;
    }
  }

  if (($action == 'edit') && isset($_GET['oID'])) {
    $oID = zen_db_prepare_input($_GET['oID']);

    $orders = $db->Execute("select orders_id from " . TABLE_ORDERS . "
                            where orders_id = '" . (int)$oID . "'");

    $order_exists = true;
    if ($orders->RecordCount() <= 0) {
      $order_exists = false;
      $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
  }

  include(DIR_WS_CLASSES . 'order.php');
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
</head>
<body onload="init()">
<!-- header //-->
<?php
  require(DIR_WS_INCLUDES . 'header.php');
?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->

<?php if (empty($action)) { ?>
<!-- search -->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
         <tr><?php echo zen_draw_form('search', FILENAME_ORDERS, '', 'get', '', true); ?>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td colspan="2" class="smallText" align="right">
<?php
// show reset search
  if ((isset($_GET['search']) && zen_not_null($_GET['search'])) or $_GET['cID'] !='') {
    echo '<a href="' . zen_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a><br />';
  }
?>
<?php
  echo HEADING_TITLE_SEARCH_DETAIL . ' ' . zen_draw_input_field('search');
  if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
    $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
    echo '<br/ >' . TEXT_INFO_SEARCH_DETAIL_FILTER . $keywords;
  }
?>
            </td>
          </form></tr>
        </table></td>
      </tr>
<!-- search -->
<?php } ?>


<?php
  if (($action == 'edit') && ($order_exists == true)) {
    $order = new order($oID);
    if ($order->info['payment_module_code']) {
      if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
        require(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
        require(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
        $module = new $order->info['payment_module_code'];
//        echo $module->admin_notification($oID);
      }
    }
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right"><?php echo '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action','referer'))) . '">' . zen_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="3"><?php echo zen_draw_separator(); ?></td>
          </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_CUSTOMER; ?></b></td>
                <td class="main"><?php echo zen_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b></td>
                <td class="main"><?php echo $order->customer['telephone']; ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
                <td class="main"><?php echo '<a href="mailto:' . $order->customer['email_address'] . '">' . $order->customer['email_address'] . '</a>'; ?></td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>
                <td class="main"><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'); ?></td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
                <td class="main"><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ENTRY_ORDER_ID . $oID; ?></b></td>
      </tr>
      <tr>
     <td><table border="0" cellspacing="0" cellpadding="2">
        <tr>
           <td class="main"><strong><?php echo ENTRY_DATE_PURCHASED; ?></strong></td>
           <td class="main"><?php echo zen_date_long($order->info['date_purchased']); ?></td>
        </tr>
        <tr>
           <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>
           <td class="main"><?php echo $order->info['payment_method']; ?></td>
        </tr>
<?php
    if (zen_not_null($order->info['cc_type']) || zen_not_null($order->info['cc_owner']) || zen_not_null($order->info['cc_number'])) {
?>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
            <td class="main"><?php echo $order->info['cc_type']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
            <td class="main"><?php echo $order->info['cc_owner']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
            <td class="main"><?php echo $order->info['cc_number']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_CVV; ?></td>
            <td class="main"><?php echo $order->info['cc_cvv']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
            <td class="main"><?php echo $order->info['cc_expires']; ?></td>
          </tr>
<?php
    }
?>
        </table></td>
      </tr>
<?php
      if (method_exists($module, 'admin_notification')) {
?>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <?php echo $module->admin_notification($oID); ?>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
}
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
          </tr>
<?php
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      echo '          <tr class="dataTableRow">' . "\n" .
           '            <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['name'];

      if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {
        for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
          echo '<br /><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
          if ($order->products[$i]['attributes'][$j]['product_attribute_is_free'] == '1' and $order->products[$i]['product_is_free'] == '1') echo TEXT_INFO_ATTRIBUTE_FREE;
          echo '</i></small></nobr>';
        }
      }

      echo '            </td>' . "\n" .
           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top">' . zen_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' .
                          $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format($order->products[$i]['onetime_charges'], true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' .
                          $currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' .
                          $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format($order->products[$i]['onetime_charges'], true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' .
                          $currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</b></td>' . "\n";
      echo '          </tr>' . "\n";
    }
?>
          <tr>
            <td align="right" colspan="8"><table border="0" cellspacing="0" cellpadding="2">
<?php
    for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
      echo '              <tr>' . "\n" .
           '                <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title'] . '</td>' . "\n" .
           '                <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '</td>' . "\n" .
           '              </tr>' . "\n";
    }
?>
            </table></td>
          </tr>
        </table></td>
      </tr>

<?php
  // show downloads
  require(DIR_WS_MODULES . 'orders_download.php');
?>

      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
          </tr>
<?php
    $orders_history = $db->Execute("select orders_status_id, date_added, customer_notified, comments
                                    from " . TABLE_ORDERS_STATUS_HISTORY . "
                                    where orders_id = '" . zen_db_input($oID) . "'
                                    order by date_added");

    if ($orders_history->RecordCount() > 0) {
      while (!$orders_history->EOF) {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" align="center">' . zen_datetime_short($orders_history->fields['date_added']) . '</td>' . "\n" .
             '            <td class="smallText" align="center">';
        if ($orders_history->fields['customer_notified'] == '1') {
          echo zen_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
        } else {
          echo zen_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
        }
        echo '            <td class="smallText">' . $orders_status_array[$orders_history->fields['orders_status_id']] . '</td>' . "\n";
        echo '            <td class="smallText">' . nl2br(zen_db_output($orders_history->fields['comments'])) . '&nbsp;</td>' . "\n" .
             '          </tr>' . "\n";
        $orders_history->MoveNext();
      }
    } else {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
?>
        </table></td>
      </tr>
      <tr>
        <td class="main"><br /><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
      <tr><?php echo zen_draw_form('status', FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=update_order', 'post', '', true); ?>
        <td class="main"><?php echo zen_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><b><?php echo ENTRY_STATUS; ?></b> <?php echo zen_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo zen_draw_checkbox_field('notify', '', true); ?></td>
                <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> <?php echo zen_draw_checkbox_field('notify_comments', '', true); ?></td>
              </tr>
            </table></td>
            <td valign="top"><?php echo zen_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
          </tr>
        </table></td>
      </form></tr>
      <tr>
        <td colspan="2" align="right"><?php echo '<a href="' . zen_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . zen_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . zen_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action'))) . '">' . zen_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
// check if order has open gv
        $gv_check = $db->Execute("select order_id, unique_id
                                  from " . TABLE_COUPON_GV_QUEUE ."
                                  where order_id = '" . $_GET['oID'] . "' and release_flag='N' limit 1");
        if ($gv_check->RecordCount() > 0) {
          $goto_gv = '<a href="' . zen_href_link(FILENAME_GV_QUEUE, 'order=' . $_GET['oID']) . '">' . zen_image_button('button_gift_queue.gif',IMAGE_GIFT_QUEUE) . '</a>';
          echo '      <tr><td align="right"><table width="225"><tr>';
          echo '        <td align="center">';
          echo $goto_gv . '&nbsp;&nbsp;';
          echo '        </td>';
          echo '      </tr></table></td></tr>';
        }
?>
<?php
  } else {
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr><?php echo zen_draw_form('orders', FILENAME_ORDERS, '', 'get', '', true); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . zen_draw_input_field('oID', '', 'size="12"') . zen_draw_hidden_field('action', 'edit'); ?></td>
              </form></tr>
              <tr><?php echo zen_draw_form('status', FILENAME_ORDERS, '', 'get', '', true); ?>
                <td class="smallText" align="right">
                  <?php
                    echo HEADING_TITLE_STATUS . ' ' . zen_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), $_GET['status'], 'onChange="this.form.submit();"');
                  ?>
                </td>
              </form></tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="smallText"><?php echo zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10) . ' ' . TEXT_BILLING_SHIPPING_MISMATCH; ?>
          </td>
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
<?php
// Sort Listing
          switch ($_GET['list_order']) {
              case "id-asc":
              $disp_order = "c.customers_id";
              break;
              case "firstname":
              $disp_order = "c.customers_firstname";
              break;
              case "firstname-desc":
              $disp_order = "c.customers_firstname DESC";
              break;
              case "lastname":
              $disp_order = "c.customers_lastname, c.customers_firstname";
              break;
              case "lastname-desc":
              $disp_order = "c.customers_lastname DESC, c.customers_firstname";
              break;
              case "company":
              $disp_order = "a.entry_company";
              break;
              case "company-desc":
              $disp_order = "a.entry_company DESC";
              break;
              default:
              $disp_order = "c.customers_id DESC";
          }
?>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ORDERS_ID; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>

<?php
// create search filter
  $search = '';
  if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
    $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
    $search = " and (o.customers_city like '%" . $keywords . "%' or o.customers_postcode like '%" . $keywords . "%' or o.date_purchased like '%" . $keywords . "%' or o.billing_name like '%" . $keywords . "%' or o.billing_company like '%" . $keywords . "%' or o.billing_street_address like '%" . $keywords . "%' or o.delivery_city like '%" . $keywords . "%' or o.delivery_postcode like '%" . $keywords . "%' or o.delivery_name like '%" . $keywords . "%' or o.delivery_company like '%" . $keywords . "%' or o.delivery_street_address like '%" . $keywords . "%' or o.billing_city like '%" . $keywords . "%' or o.billing_postcode like '%" . $keywords . "%' or o.customers_email_address like '%" . $keywords . "%' or o.customers_name like '%" . $keywords . "%' or o.customers_company like '%" . $keywords . "%' or o.customers_street_address  like '%" . $keywords . "%' or o.customers_telephone like '%" . $keywords . "%')";
  }
?>
<?php
    $new_fields = ", o.customers_street_address, o.delivery_name, o.delivery_street_address, o.billing_name, o.billing_street_address ";
    if (isset($_GET['cID'])) {
      $cID = zen_db_prepare_input($_GET['cID']);
      $orders_query_raw = "select o.orders_id, o.customers_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total" . $new_fields . " from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$cID . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$_SESSION['languages_id'] . "' and ot.class = 'ot_total' order by orders_id DESC";
    } elseif ($_GET['status'] != '') {
      $status = zen_db_prepare_input($_GET['status']);
      $orders_query_raw = "select o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total" . $new_fields . " from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$_SESSION['languages_id'] . "' and s.orders_status_id = '" . (int)$status . "' and ot.class = 'ot_total'  " . $search . " order by o.orders_id DESC";
    } else {
      $orders_query_raw = "select o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total" . $new_fields . " from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$_SESSION['languages_id'] . "' and ot.class = 'ot_total'  " . $search . " order by o.orders_id DESC";
    }
    $orders_query_numrows = '';
    $orders_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $orders_query_raw, $orders_query_numrows);
    $orders = $db->Execute($orders_query_raw);
    while (!$orders->EOF) {
    if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ($_GET['oID'] == $orders->fields['orders_id']))) && !isset($oInfo)) {
        $oInfo = new objectInfo($orders->fields);
      }

      if (isset($oInfo) && is_object($oInfo) && ($orders->fields['orders_id'] == $oInfo->orders_id)) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit', 'NONSSL') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID')) . 'oID=' . $orders->fields['orders_id'], 'NONSSL') . '\'">' . "\n";
      }

      $show_difference = '';
      if (($orders->fields['delivery_name'] != $orders->fields['billing_name'] and $orders->fields['delivery_name'] != '')) {
        $show_difference = ' ' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
      if (($orders->fields['delivery_street_address'] != $orders->fields['billing_street_address'] and $orders->fields['delivery_street_address'] != '')) {
        $show_difference = ' ' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
      if ($show_difference == '') {
        $show_difference = ' ' . zen_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', 10, 10);
      }
?>
                <td class="dataTableContent" align="right"><?php echo $orders->fields['orders_id'] . $show_difference; ?></td>
                <td class="dataTableContent"><?php echo '<a href="' . zen_href_link(FILENAME_CUSTOMERS, 'cID=' . $orders->fields['customers_id'], 'NONSSL') . '">' . zen_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW . ' ' . TABLE_HEADING_CUSTOMERS) . '</a>&nbsp;' . $orders->fields['customers_name']; ?></td>
                <td class="dataTableContent" align="right"><?php echo strip_tags($orders->fields['order_total']); ?></td>
                <td class="dataTableContent" align="center"><?php echo zen_datetime_short($orders->fields['date_purchased']); ?></td>
                <td class="dataTableContent" align="right"><?php echo $orders->fields['orders_status_name']; ?></td>

                <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($orders->fields['orders_id'] == $oInfo->orders_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID')) . 'oID=' . $orders->fields['orders_id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
      $orders->MoveNext();
    }
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
                    <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
                  </tr>
<?php
  if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
?>
                  <tr>
                    <td class="smallText" align="right" colspan="2">
                      <?php
                        echo '<a href="' . zen_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>';
                        if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
                          $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
                          echo '<br/ >' . TEXT_INFO_SEARCH_DETAIL_FILTER . $keywords;
                        }
                      ?>
                    </td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ORDER . '</b>');

      $contents = array('form' => zen_draw_form('orders', FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=deleteconfirm', 'post', '', true));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br /><br /><b>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>');
      $contents[] = array('text' => '<br />' . zen_draw_checkbox_field('restock') . ' ' . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id, 'NONSSL') . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($oInfo) && is_object($oInfo)) {
        $heading[] = array('text' => '<b>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' . zen_datetime_short($oInfo->date_purchased) . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit', 'NONSSL') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete', 'NONSSL') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . zen_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . zen_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_DATE_ORDER_CREATED . ' ' . zen_date_short($oInfo->date_purchased));
        if (zen_not_null($oInfo->last_modified)) $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED . ' ' . zen_date_short($oInfo->last_modified));
        $contents[] = array('text' => '<br />' . TEXT_INFO_PAYMENT_METHOD . ' '  . $oInfo->payment_method);

// check if order has open gv
        $gv_check = $db->Execute("select order_id, unique_id
                                  from " . TABLE_COUPON_GV_QUEUE ."
                                  where order_id = '" . $oInfo->orders_id . "' and release_flag='N' limit 1");
        if ($gv_check->RecordCount() > 0) {
          $goto_gv = '<a href="' . zen_href_link(FILENAME_GV_QUEUE, 'order=' . $oInfo->orders_id) . '">' . zen_image_button('button_gift_queue.gif',IMAGE_GIFT_QUEUE) . '</a>';
          $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
          $contents[] = array('align' => 'center', 'text' => $goto_gv);
        }
      }
      break;
  }

  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
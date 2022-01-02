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
// $Id: header_php.php 979 2005-02-09 02:05:15Z drbyte $
//
if (!isset($_GET['debug'])) define('ZC_UPG_DEBUG',false);
if (!isset($_GET['debug2'])) define('ZC_UPG_DEBUG2',false);
if (!isset($_GET['debug3'])) define('ZC_UPG_DEBUG3',false);

$is_upgrade = true; //that's what this page is all about!

//this is the latest database-version-level that this script knows how to inspect and upgrade to.
//it is used to determine whether to stay on the upgrade page when done, or continue to the finished page
$latest_version = '1.2.3'; 
$configure_files_array = array('../includes/configure.php','../admin/includes/configure.php');
$database_tablenames_array=array('../includes/database_tables.php', '../includes/extra_datafiles/music_type_database_names.php');

define('DIR_WS_INCLUDES', '../includes/');
$zc_install->test_store_configure(ERROR_TEXT_STORE_CONFIGURE,ERROR_CODE_STORE_CONFIGURE);
if (ZC_UPG_DEBUG==true && $zc_install->fatal_error) echo 'FATAL ERROR-CONFIGURE FILE';

if (!$zc_install->fatal_error) {
  if (ZC_UPG_DEBUG==true) echo 'configure.php file appears OK<br>';
  require(DIR_WS_INCLUDES . 'configure.php');
  require(DIR_WS_INCLUDES . 'classes/db/' . DB_TYPE . '/query_factory.php');
//open database connection to run queries against it
  $db_test = new queryFactory;
  $db_test->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");

//check to see if a database_table_prefix has been defined.  If not, set it to blank.
  if (!defined(DB_PREFIX) || DB_PREFIX == 'DB_PREFIX' || "'".DB_PREFIX."'" == 'DB_PREFIX') {
    define('DB_PREFIX','');
  }

// Check to see if any Zen Cart tables exist
    $tables = $db_test->Execute("SHOW TABLES like '".DB_PREFIX."configuration'");
     if (ZC_UPG_DEBUG==true) echo 'ZEN-Configuration = '. $tables->RecordCount() .'<br>';
     if ($tables->RecordCount() > 0) {
        $zdb_configuration_table_found = true;
       }

if ($zdb_configuration_table_found) {
// first test to see if they have run the 1.1 upgrade script   (v1.0.4 to v.1.1.1)
    $tables = $db_test->Execute("SHOW TABLES like '".DB_PREFIX."files_uploaded'");
     if (ZC_UPG_DEBUG==true) echo '104-Table = '. $tables->RecordCount() .'<br>';
     if ($tables->RecordCount() > 0) {
        $got_v1_1_0 = true;
        $zdb_ver = '1.1.0';
    }

// now test to see if they have run the 1.1 -> 1.1.1 bugfix update
    $sql = "select * from " . DB_PREFIX . "admin where admin_name = 'demo'";
    $result = $db_test->Execute($sql);
    if (ZC_UPG_DEBUG==true) echo 'v111-recordcount= '.$result->RecordCount().'<br>';
    if ($result->RecordCount() > 0) {
      $got_v1_1_1 = true;
    }
  //2nd check:
    $sql = "SELECT count(*) as count FROM " . DB_PREFIX . "configuration WHERE configuration_key = 'CATEGORIES_COUNT_ZERO'";
    $result = $db_test->Execute($sql);
    if (ZC_UPG_DEBUG==true) echo 'v111-count=' . $result->fields['count'] .'<br>';
  if ($result->fields['count'] > '0') {
      $got_v1_1_1 = true;
    }

// now test to see if they have run the 1.1.1 -> 1.1.2 update
    $sql = "SELECT count(*) as count FROM " . DB_PREFIX . "configuration WHERE configuration_key = 'MODULE_PAYMENT_CC_STORE_NUMBER'";
    $result = $db_test->Execute($sql);
    if (ZC_UPG_DEBUG==true) echo 'v112-count=' . $result->fields['count'] .'<br>';
//    if ($result->RecordCount > 0) {
  if ($result->fields['count'] > '0') {
      $got_v1_1_2 = true;
    }

// there were no critical SQL changes from v1.1.2 to v1.1.3 -- just to change a default, but such change shouldn't
// be necessary if the installed shop/store is already functional, unless can't get free-shipping for 0-weight to work

// now test to see if they have run the 1.1.2 -> 1.1.4 update
    $sql = "show fields from " . DB_PREFIX . "customers_basket_attributes";   // could we use "describe" as well ?
    $result = $db_test->Execute($sql);
      while (!$result->EOF) {
      if (ZC_UPG_DEBUG==true) echo "114-fields=" . $result->fields['Field'] . '<br>';
       if  ($result->fields['Field'] == 'products_options_sort_order') {
         if ($result->fields['Type'] == 'text')  {
           $got_v1_1_4 = true;
         }
       }
        $result->MoveNext();
      }

// now test to see if they have run the 1.1.4 -> PATCH1 update
    $sql = "select configuration_title from " . DB_PREFIX . "configuration where configuration_key='SHIPPING_BOX_WEIGHT'";   // could use "describe" as well ?
    $result = $db_test->Execute($sql);
       while (!$result->EOF) {
       if (ZC_UPG_DEBUG==true) echo "114patch-fields=" . $result->fields['configuration_title'] . '<br>';
         if  ($result->fields['configuration_title'] == 'Package Tare Small to Medium - added percentage:weight') {
            $got_v1_1_4_patch1 = true;
         }
         $result->MoveNext();
       }


// now test to see if the v1.1.4->v1.2.0 upgrade has been completed
  //1st check for v1.20
    $sql = "select configuration_title from " . DB_PREFIX . "configuration where configuration_key='TUTORIAL_STATUS'";
    $result = $db_test->Execute($sql);
  $got_v1_2_0a = true;  // set true -- if value found (but should be deleted), then set to false.
      while (!$result->EOF) {
       if (ZC_UPG_DEBUG==true) echo "120a-configtitle=" . $result->fields['configuration_title'] . '<br>';
       if  ($result->fields['configuration_title'] != '') {
          $got_v1_2_0a = false;
       }
       $result->MoveNext();
     }
  //2nd check for v1.20
    $tables = $db_test->Execute("SHOW TABLES like '" . DB_PREFIX . "product_type_layout'");
     if (ZC_UPG_DEBUG==true) echo '120b-Table= '. $tables->RecordCount() .'<br>';
     if ($tables->RecordCount() > 0) {
       $got_v1_2_0b = true;
      }
  //3rd check for v1.20
    $sql = "select configuration_group_title, configuration_group_description from " . DB_PREFIX . "configuration_group WHERE configuration_group_id = '13'";
    $result = $db_test->Execute($sql);
     while (!$result->EOF) {
       if (ZC_UPG_DEBUG==true) echo "120c-cfggroup13=attrb ==" . $result->fields['configuration_group_title'] . '<br>';
       if  ($result->fields['configuration_group_title'] == 'Attribute Settings') {
           $got_v1_2_0c = true;
       }
       $result->MoveNext();
     }
  //4th check for v1.20
    $sql = "show fields from " . DB_PREFIX . "categories";
    $result = $db_test->Execute($sql);
    while (!$result->EOF) {
      if (ZC_UPG_DEBUG==true) echo "120d-fields=" . $result->fields['Field'] . '<br>';
      if  ($result->fields['Field'] == 'categories_status') {
        if ($result->fields['Type'] == 'tinyint(1)')  {
             $got_v1_2_0d = true;
        }
      }
      $result->MoveNext();
    }
  //5th check for v1.20
    $sql = "show fields from " . DB_PREFIX . "customers";
    $result = $db_test->Execute($sql);
    while (!$result->EOF) {
      if (ZC_UPG_DEBUG==true) echo "120e-fields=" . $result->fields['Field'] . '<br>';
      if  ($result->fields['Field'] == 'customers_nick' || $result->fields['Field'] == 'customers_group_pricing' || $result->fields['Field'] == 'customers_email_format') {
          $got_v1_2_0e = true;
      }
      $result->MoveNext();
    }
  //6th check for v1.20
    $sql = "show fields from " . DB_PREFIX . "products";
    $result = $db_test->Execute($sql);
    while (!$result->EOF) {
    if (ZC_UPG_DEBUG==true) echo "120f-fields=" . $result->fields['Field'] . '<br>';
       if  ($result->fields['Field'] == 'master_categories_id') {
          $got_v1_2_0f = true;
       }
      $result->MoveNext();
    }

  //7th check for v1.2.0
    $tables = $db_test->Execute("SHOW TABLES like '" . DB_PREFIX . "project_version'");
     if ($tables->RecordCount() > 0) {
    $sql = "SELECT project_version_major, project_version_minor from " . DB_PREFIX . "project_version WHERE project_version_key = 'Zen-Cart Main'";
    $result = $db_test->Execute($sql);
    if (ZC_UPG_DEBUG==true) echo "120g-project_version=" . $result->fields['project_version_major'] . '.' . $result->fields['project_version_minor'] . '<br>';
    if ($result->fields['project_version_major']=='1' && $result->fields['project_version_minor']=='2') $got_v1_2_0g = true;
    }

  // evaluate all 6 checks
   if ($got_v1_2_0a && $got_v1_2_0b && $got_v1_2_0c && $got_v1_2_0d && $got_v1_2_0e && $got_v1_2_0f) {
     $got_v1_2_0 = true;
   }


// now test to see if the v1.2.0->v1.2.1 upgrade has been completed
  $tables = $db_test->Execute("SHOW TABLES like '" . DB_PREFIX . "project_version'");
  if ($tables->RecordCount() > 0) {
  //1st check for v1.2.1
  $sql = "select configuration_title from " . DB_PREFIX . "configuration where configuration_key='DISPLAY_PRICE_WITH_TAX_ADMIN'";
  $result = $db_test->Execute($sql);
  if (ZC_UPG_DEBUG==true) echo "121a-configkey_check=" . $result->fields['configuration_title'] . '<br>';
  if  ($result->RecordCount()>0) $got_v1_2_1a = true;

  //2nd check for v1.2.1
  $tables = $db_test->Execute("SHOW TABLES like '" . DB_PREFIX . "orders_session_info'");
  if (ZC_UPG_DEBUG==true) echo '121b-Table= '. $tables->fields['Tables_in_' . DB_DATABASE . ' (' . DB_PREFIX . 'orders_session_info)'] . ' ' . $tables->RecordCount() . '<br>';
  if ($tables->RecordCount() > 0) {
    $got_v1_2_1b = true;
  }
  //3rd check for v1.2.1
  $sql = "show fields from " . DB_PREFIX . "products_discount_quantity";
  $result = $db_test->Execute($sql);
  while (!$result->EOF) {
    if (ZC_UPG_DEBUG==true) echo "121c-fields-'discount_qty'->FLOAT=" . $result->fields['Field'] . '->' . $result->fields['Type'] . '<br>';
    if  ($result->fields['Field'] == 'discount_qty') {
      if (strtoupper($result->fields['Type']) == 'FLOAT')  {
        $got_v1_2_1c = true;
      }
    }
  $result->MoveNext();
  }
  //4th check for v1.2.1 - part a
  $sql = "SELECT project_version_major, project_version_minor from " . DB_PREFIX . "project_version WHERE project_version_key = 'Zen-Cart Main'";
  $result = $db_test->Execute($sql);
  if (ZC_UPG_DEBUG==true) echo "121d-project_versionZC=" . $result->fields['project_version_major'] . '.' . $result->fields['project_version_minor'] . '<br>';
  if  ($result->fields['project_version_major']=='1' && $result->fields['project_version_minor']=='2.1') $got_v1_2_1d = true;

  //4th check for v1.2.1 -- part b
  $sql = "SELECT project_version_major, project_version_minor from " . DB_PREFIX . "project_version WHERE project_version_key = 'Zen-Cart Database'";
  $result = $db_test->Execute($sql);
  if (ZC_UPG_DEBUG==true) echo "121e-project_versionDB=" . $result->fields['project_version_major'] . '.' . $result->fields['project_version_minor'] . '<br>';
  if  ($result->fields['project_version_major']=='1' && $result->fields['project_version_minor']=='2.1') $got_v1_2_1e = true;
  //check alternate setting for erroneous code in initial 1.2.0 release (it was left at 1+1.2):
  if  ($result->fields['project_version_major']=='1' && $result->fields['project_version_minor']=='1.2') $got_v1_2_1e = true;
  } //version number

  if (ZC_UPG_DEBUG==true) {
    echo '1.2.1a='.$got_v1_2_1a.'<br>';
    echo '1.2.1b='.$got_v1_2_1b.'<br>';
    echo '1.2.1c='.$got_v1_2_1c.'<br>';
    echo '1.2.1d='.$got_v1_2_1d.'<br>';
    echo '1.2.1e='.$got_v1_2_1e.'<br><br>';
  }

  // evaluate all 5 checks
  if ($got_v1_2_1a) {
    $got_v1_2_1 = true;
    $zdb_ver = '1.2.1';
    if (ZC_UPG_DEBUG==true) echo 'Got 1.2.1<br>';
  }

// 1.2.2 checks
  //1st check for v1.2.2
  $sql = "select configuration_title from " . DB_PREFIX . "configuration where configuration_key='SEND_EXTRA_ORDER_EMAILS_TO'";
  $result = $db_test->Execute($sql);
  if (ZC_UPG_DEBUG==true) echo "122a-configkey_check=" . $result->fields['configuration_title'] . '<br>';
  if  ($result->fields['configuration_title'] == 'Send Copy of Order Confirmation Emails To') {
    $got_v1_2_2 = true;
    $zdb_ver = '1.2.2';
    if (ZC_UPG_DEBUG==true) echo '<br>Got 1.2.2<br>';
  }

// 1.2.3 checks
  //1st check for v1.2.3
  $sql = "select configuration_title from " . DB_PREFIX . "configuration where configuration_key='DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID'";
  $result = $db_test->Execute($sql);
  if (ZC_UPG_DEBUG==true) echo "123a-configkey_check=" . $result->fields['configuration_title'] . '<br>';
  if  ($result->fields['configuration_title'] == 'Default Order Status For Zero Balance Orders') {
    $got_v1_2_3 = true;
    $zdb_ver = '1.2.3';
    if (ZC_UPG_DEBUG==true) echo '<br>Got 1.2.3<br>';
  }

// 1.2.4 checks
  //1st check for v1.2.4
  $sql = "select configuration_title from " . DB_PREFIX . "configuration where configuration_key='PRODUCTS_MANUFACTURERS_STATUS'";
  $result = $db_test->Execute($sql);
  if (ZC_UPG_DEBUG==true) echo "124a-configkey_check=" . $result->fields['configuration_title'] . '<br>';
  if  ($result->fields['configuration_title'] == 'Manufacturers List - Verify Product Exist') {
    $got_v1_2_4 = true;
    $zdb_ver = '1.2.4';
    if (ZC_UPG_DEBUG==true) echo '<br>Got 1.2.4<br>';
  }
// THE FOLLOWING SIMPLY CHECKS FOR THE EXTRA INDEX AND REMOVES IT:
    $tables = $db_test->Execute("SHOW TABLES like '".DB_PREFIX."project_version_history'");
     if ($tables->RecordCount() > 0) {
       $sql = "show index from " . DB_PREFIX . "project_version_history";
       $result = $db_test->Execute($sql);
       while (!$result->EOF) {
         if (ZC_UPG_DEBUG==true) echo "INDEX TEST-'project_version_history'=" . $result->fields['Field'] . '->' . $result->fields['Type'] . '<br>';
         if  ($result->fields['Key_name'] == 'project_version_key') {
             if (ZC_UPG_DEBUG==true) echo 'Index on project_version_key found. Deleting.<br>';
             $db_test->Execute("drop index project_version_key on " . DB_PREFIX . "project_version_history");
         }
       $result->MoveNext();
       }
     }
/////////////////////////////


//*** FUTURE CHECKS GO ABOVE THIS LINE ****

//******************************

 } //endif $zdb_configuration_table_found

// Finished querying database for configuration info
   $db_test->Close();


// *** NOW DETERMINE REQUIRED UPDATES BASED ON TEST RESULTS

//display options based on what was found -- THESE SHOULD BE PROCESSED IN REVERSE ORDER, NEWEST VERSION FIRST... !
//that way only the "earliest-required" upgrade is suggested first.
    if (!$got_v1_2_4) {
      $sniffer =  ' upgrade v1.2.3 to v1.2.4';
      $needs_v1_2_4=true;
    }
    if (!$got_v1_2_3) {
      $sniffer =  ' upgrade v1.2.2 to v1.2.3';
      $needs_v1_2_3=true;
    }
    if (!$got_v1_2_2) {
      $sniffer =  ' upgrade v1.2.1 to v1.2.2';
      $needs_v1_2_2=true;
    }
    if (!$got_v1_2_1) {
      $sniffer =  ' upgrade v1.2.0 to v1.2.1';
      $needs_v1_2_1=true;
    }
    if (!$got_v1_2_0) {
      $sniffer =  ' upgrade v1.1.4 to v1.2.0';
      $needs_v1_2_0=true;
    }
    if (!$got_v1_1_4_patch1) {
      $sniffer =  ' upgrade v1.1.4 to v1.1.4_patch1';
      $needs_v1_1_4_patch1=true;
    }
    if (!$got_v1_1_4) {
      $sniffer =  ' upgrade v1.1.2 or v1.1.3 to v1.1.4';
      $needs_v1_1_4=true;
    }
    if (!$got_v1_1_2) {
      $sniffer =  ' upgrade v1.1.1 to v1.1.2';
      $needs_v1_1_2=true;
    }
    if (!$got_v1_1_1) {
      $sniffer =  ' upgrade v1.1.0 to v1.1.1';
      $needs_v1_1_1=true;
    }
    if (!$got_v1_1_0) {
      $sniffer =  ' upgrade v1.04 to v.1.1.1';
      $needs_v1_1_0=true;
//    $needs_v1_1_1=false; // exclude the 1.1.0-to-1.1.1 update since it's included in this step if selected
    }


 if (!$sniffer) {
   $sniffer = ' No upgrade required';
   $sniffer_version = "";
   }

} // end if zc_install_error == false ....... and database schema checks

if (ZC_UPG_DEBUG3==true) {
  echo '<br>110='.$got_v1_1_0;
  echo '<br>111='.$got_v1_1_1;
  echo '<br>112='.$got_v1_1_2;
  echo '<br>114='.$got_v1_1_4;
  echo '<br>1_1_4_patch1='.$got_v1_1_4_patch1;
  echo '<br>120='.$got_v1_2_0;
  echo '<br>121='.$got_v1_2_1;
  echo '<br>122='.$got_v1_2_2;
  echo '<br>123='.$got_v1_2_3;
  echo '<br>124='.$got_v1_2_4;
  echo '<br>';
  }

// IF FORM WAS SUBMITTED, CHECK SELECTIONS AND PERFORM THEM
  if (isset($_POST['submit'])) {
   $sniffer =  '';
   $sniffer_version = '';

   if (is_array($_POST['version'])) {
   if (ZC_UPG_DEBUG2==true) foreach($_POST['version'] as $value) { echo 'Selected: ' . $value.'<br />';}
     reset($_POST['version']);
     while (list(, $value) = each($_POST['version'])) {
     $sniffer_file = '';
      switch ($value) {
       case '1.0.4':  // upgrading from v1.0.4 to 1.1.1
          if ($got_v1_1_1) continue;  // if prerequisite not completed, or already done, skip
          $sniffer_file = '_upgrade_zencart_104_to_111.sql';
          if (ZC_UPG_DEBUG2==true) echo '<br>'.$sniffer_file.'<br>';
          $got_v1_1_1 = true;
          $db_upgraded_to_version='1.1.1';
          break;
       case '1.1.0':  // upgrading from v1.1.0 to 1.1.1
          if (!$got_v1_1_0 || $got_v1_1_1) continue; // if don't have prerequisite, or if already done this step
        $sniffer_file = '_upgrade_zencart_110_to_111.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_1_1 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.1.1';
          break;
       case '1.1.1':  // upgrading from v1.1.1 to 1.1.2
          if (!$got_v1_1_1 || $got_v1_1_2) continue;
        $sniffer_file = '_upgrade_zencart_110_to_112.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_1_2 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.1.2';
          break;
       case '1.1.2-or-1.1.3':  // upgrading from v1.1.2 or v.1.13  TO   1.1.4
          if (!$got_v1_1_2 || $got_v1_1_4) continue;
        $sniffer_file = '_upgrade_zencart_112_to_114.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_1_4 = true;
          $got_v1_1_4_patch1 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.1.4-1';
          break;
       case '1.1.4':  // upgrading from v1.1.4 to 1.1.4 patch1
          if (!$got_v1_1_4 || $got_v1_1_4_patch1) continue;
        $sniffer_file = '_upgrade_zencart_114_patch1.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_1_4_patch1 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.1.4-1';
          break;
       case '1.1.4u':  // upgrading from v1.1.4 TO v1.2.0  ('u' implies "upgrade", rather than just the patch1)
          if (!$got_v1_1_4 || $got_v1_2_0) continue;
          $sniffer_file = '_upgrade_zencart_114_to_120.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_2_0 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.2.0';
          break;
       case '1.2.0':  // upgrading from v1.2.0 TO v1.2.1
          if (!$got_v1_2_0 || $got_v1_2_1) continue;  // if prerequisite not completed, or already done, skip
          $sniffer_file = '_upgrade_zencart_120_to_121.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_2_1 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.2.1';
          break;
       case '1.2.1':  // upgrading from v1.2.1 TO v1.2.2
          if (!$got_v1_2_1 || $got_v1_2_2) continue;  // if prerequisite not completed, or already done, skip
          $sniffer_file = '_upgrade_zencart_121_to_122.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_2_2 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.2.2';
          break;
       case '1.2.2':  // upgrading from v1.2.2 TO v1.2.3
          if (!$got_v1_2_2 || $got_v1_2_3) continue;  // if prerequisite not completed, or already done, skip
          $sniffer_file = '_upgrade_zencart_122_to_123.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_2_3 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.2.3';
          break;
       case '1.2.3':  // upgrading from v1.2.3 TO v1.2.4
          if (!$got_v1_2_3 || $got_v1_2_4) continue;  // if prerequisite not completed, or already done, skip
          $sniffer_file = '_upgrade_zencart_123_to_124.sql';
          if (ZC_UPG_DEBUG2==true) echo $sniffer_file.'<br>';
          $got_v1_2_4 = true; //after processing this step, this will be the new version-level
          $db_upgraded_to_version='1.2.4';
          break;
       default:
       $nothing_to_process=true;
       } // end while

       //check for errors
     $zc_install->test_store_configure(ERROR_TEXT_STORE_CONFIGURE,ERROR_CODE_STORE_CONFIGURE);
     if (!$zc_install->fatal_error) {
        require(DIR_WS_INCLUDES . 'configure.php');
//        require(DIR_WS_INCLUDES . 'classes/db/' . DB_TYPE . '/query_factory.php');
        $zc_install->fileExists(DB_TYPE . $sniffer_file, DB_TYPE . $sniffer_file . ' ' . ERROR_TEXT_DB_SQL_NOTEXIST, ERROR_CODE_DB_SQL_NOTEXIST);
        $zc_install->functionExists(DB_TYPE, ERROR_TEXT_DB_NOTSUPPORTED, ERROR_CODE_DB_NOTSUPPORTED);
        $zc_install->dbConnect(DB_TYPE, DB_SERVER, DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, ERROR_TEXT_DB_CONNECTION_FAILED, ERROR_CODE_DB_CONNECTION_FAILED,ERROR_TEXT_DB_NOTEXIST, ERROR_CODE_DB_NOTEXIST);
        }

       if (ZC_UPG_DEBUG2==true) echo 'Processing ['.$sniffer_file.']...<br />';
       if ($zc_install->error == false && $nothing_to_process==false) {
          $db = new queryFactory;
          $db->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");
          if (!ini_get('safe_mode')) set_time_limit(300);
          executeSql(DB_TYPE . $sniffer_file, DB_DATABASE, DB_PREFIX);
          $db->Close();
          } // end if
     } // end while
  } // end if-is-array-POST['version']

  // if database table-prefix 'change' has been requested, process it here:
  if (isset($_POST['newprefix'])) {
    $newprefix = $_POST['newprefix'];
    if (isset($_POST['db_prefix'])) { //use specified "old" prefix if entered
       $db_prefix_rename_from = $_POST['db_prefix'];
       } else {
       $db_prefix_rename_from = DB_PREFIX;
       }
    if ($newprefix != $db_prefix_rename_from) { // don't process prefix changes if same prefix selected
     $zc_install->test_admin_configure(ERROR_TEXT_ADMIN_CONFIGURE,ERROR_CODE_ADMIN_CONFIGURE);
     $zc_install->test_store_configure(ERROR_TEXT_STORE_CONFIGURE,ERROR_CODE_STORE_CONFIGURE);
     $zc_install->test_admin_configure_write(ERROR_TEXT_ADMIN_CONFIGURE_WRITE,ERROR_CODE_ADMIN_CONFIGURE_WRITE);
     $zc_install->test_store_configure_write(ERROR_TEXT_STORE_CONFIGURE_WRITE,ERROR_CODE_STORE_CONFIGURE_WRITE);
     $zc_install->functionExists(DB_TYPE, ERROR_TEXT_DB_NOTSUPPORTED, ERROR_CODE_DB_NOTSUPPORTED);
     $zc_install->dbConnect(DB_TYPE, DB_SERVER, DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, ERROR_TEXT_DB_CONNECTION_FAILED, ERROR_CODE_DB_CONNECTION_FAILED,ERROR_TEXT_DB_NOTEXIST, ERROR_CODE_DB_NOTEXIST);

     if (ZC_UPG_DEBUG2==true) echo 'Processing prefix updates...<br />';
     if ($zc_install->error == false && $nothing_to_process==false) {
       $db = new queryFactory;
       $db->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE) or die("Unable to connect to database");

       $tables = $db->Execute("SHOW TABLES"); // get a list of tables to compare against
       $tables_list = array();
       while (!$tables->EOF) {
	  $tables_list[] = $tables->fields['Tables_in_' . DB_DATABASE];
       $tables->MoveNext();
       } //end while


      //read the "database_tables.php" files, and loop through the table names
      foreach($database_tablenames_array as $filename) {
       if (!file_exists($filename)) continue;
       $lines = file($filename);
       foreach ($lines as $line) {
         $line = trim($line);
         if (substr($line,0,1) != '<' && substr($line,0,2) != '?'.'>' && substr($line,0,2) != '//' && $line != '') {
//           echo 'line='.$line.'<br>';
             $def_string=array();
             $def_string=explode("'",$line);
             //define('TABLE_CONSTANT',DB_PREFIX.'tablename');
             //[1]=TABLE_CONSTANT
             //[2]=,DB_PREFIX.
             //[3]=tablename
             //[4]=);
             //[5]=
             //echo '[1]->'.$def_string[1].'<br>';
             //echo '[2]->'.$def_string[2].'<br>';
             //echo '[3]->'.$def_string[3].'<br>';
             //echo '[4]->'.$def_string[4].'<br>';
             //echo '[5]->'.$def_string[5].'<br>';
           if (strtoupper($def_string[1]) != 'DB_PREFIX' // the define of DB_PREFIX is not a tablename
               && str_replace('PHPBB','',strtoupper($def_string[1]) ) == strtoupper($def_string[1])  // this is not a phpbb table
               && str_replace(' ','',$def_string[2]) == ',DB_PREFIX.') { // this is a Zen Cart-related table (vs phpbb)
               $tablename_read = $def_string[3];
               foreach($tables_list as $existing_table) {
                 if ($tablename_read == str_replace($db_prefix_rename_from,'',$existing_table)) {
                  //echo $tablename_read.'<br>';
                  $sql_command = 'alter table '. $db_prefix_rename_from . $tablename_read . ' rename ' . $newprefix.$tablename_read;
                  //echo $sql_command .'<br>';
                  $db->Execute($sql_command);
                  $tables_updated++;
                  $tablename_read = '';
                  $sql_command = '';
                }//endif $tablename_read == existing
               }//end foreach $tables_list
              } //endif is "DEFINE"?
            } // endif substring not < or ? or // etc
          } //end foreach $lines
         }//end foreach $database_tablenames array

         $db->Close();
         } // end if zc_install-error

         //echo $tables_updated;
         if ($tables_updated <50) $zc_install->setError(ERROR_TEXT_TABLE_RENAME_INCOMPLETE, ERROR_CODE_TABLE_RENAME_INCOMPLETE, false);

         if ($tables_updated >50) {
           //update the configure.php files with the new prefix.
           $configure_files_updated = 0;
           foreach($configure_files_array as $filename) {
            $lines = file($filename);
            $full_file = '';
            foreach ($lines as $line) {
               $def_string=explode("'",$line);
               if (strtoupper($def_string[1]) == 'DB_PREFIX') {
                  // check to see if prefix found matches what we've been processing... for safety to be sure we have the right line
                  $old_prefix_from_file = $def_string[3];
                  if ($old_prefix_from_file == DB_PREFIX || $old_prefix_from_file == $db_prefix_rename_from) {
                       $line = '  define(\'DB_PREFIX\', \'' . $newprefix. '\');' . "\n";
                       $configure_files_updated++;
                  }
              } // endif DEFINE DB_PREFIX found;
              $full_file .= $line;
            } //end foreach $lines
            $fp = fopen($filename, 'w');
            fputs($fp, $full_file);
            fclose($fp);
            @chmod($filename, 0644);
           } //end foreach array to update configure.php files
         if ($configure_files_updated <2) $zc_install->setError(ERROR_TEXT_TABLE_RENAME_CONFIGUREPHP_FAILED, ERROR_CODE_TABLE_RENAME_CONFIGUREPHP_FAILED, false);
        } //endif $tables_updated count sufficient
      } //endif newprefix != DB_PREFIX
  } //endif prefix POST'd


 if ($db_upgraded_to_version==$latest_version && $zc_install->error == false) { // if all db upgrades have been applied, go to the 'finished' page.
  header('location: index.php?main_page=finished&language=' . $language);
  exit;
  } else { //return for more upgrades
  header('location: index.php?main_page=database_upgrade&language=' . $language);
  exit;
  }//endif
 } // end if POST==submit

 if (isset($_POST['skip'])) {
  header('location: index.php?main_page=finished&language=' . $language);
  exit;
 }
?>
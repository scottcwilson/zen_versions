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
// $Id: header_php.php 290 2004-09-15 19:48:26Z wilt $
//
  $zc_install->error = false;
  $zc_install->fatal_error = false;
  $zc_install->error_list = array();
  
//  $zc_install->test_php_version('=','4.1.2',ERROR_TEXT_4_1_2, ERROR_CODE_4_1_2, false);
//  $zc_install->test_php_version('<','4.0.6',ERROR_TEXT_PHP_VERSION, ERROR_CODE_PHP_VERSION, true);
//  $zc_install->test_admin_configure(ERROR_TEXT_ADMIN_CONFIGURE,ERROR_CODE_ADMIN_CONFIGURE);
//  $zc_install->test_store_configure(ERROR_TEXT_STORE_CONFIGURE,ERROR_CODE_STORE_CONFIGURE);
//  $zc_install->test_admin_configure_write(ERROR_TEXT_ADMIN_CONFIGURE_WRITE,ERROR_CODE_ADMIN_CONFIGURE_WRITE);
//  $zc_install->test_store_configure_write(ERROR_TEXT_STORE_CONFIGURE_WRITE,ERROR_CODE_STORE_CONFIGURE_WRITE);
  
  if (isset($_POST['submit'])) {
    if ($_POST['lisence'] == 'agree' && !$zc_install->fatal_error) {
      header('location: index.php?main_page=system_setup&language=' . $language);
      exit;
    }
  }
?>
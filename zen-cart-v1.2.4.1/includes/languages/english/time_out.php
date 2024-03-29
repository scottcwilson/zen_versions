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
// $Id: time_out.php 290 2004-09-15 19:48:26Z wilt $
//

define('NAVBAR_TITLE', 'Login Time Out');
define('HEADING_TITLE', 'Login Time Out');

define('TEXT_INFORMATION', 'We\'re sorry but for your protection,
  due to the long delay while either checking out,
  or on a secure page, the session has timed out.<br /><br />
  If you were placing an order, please
  <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Login</a>
  and your Shopping Cart will be restored. You may then go back to the Checkout and complete your final purchases.<br /><br />
  If you had completed an order and wish to review it' .
  (DOWNLOAD_ENABLED == 'true' ? ', or had a download and wish to retrieve it' : '') . ',
  please go to your <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">My Account</a> page to view your order.
  ');
?>
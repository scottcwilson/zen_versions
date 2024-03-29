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
//  $Id: header_navigation.php 290 2004-09-15 19:48:26Z wilt $
//
?>
<!-- Menu bar #2. -->
<div id="navbar">
<ul class="nde-menu-system">
<?php

  require(DIR_WS_BOXES . 'configuration_dhtml.php');
  require(DIR_WS_BOXES . 'catalog_dhtml.php');
  require(DIR_WS_BOXES . 'modules_dhtml.php');
  require(DIR_WS_BOXES . 'customers_dhtml.php');
  require(DIR_WS_BOXES . 'taxes_dhtml.php');
  require(DIR_WS_BOXES . 'localization_dhtml.php');
  require(DIR_WS_BOXES . 'reports_dhtml.php');
  require(DIR_WS_BOXES . 'tools_dhtml.php');
  require(DIR_WS_BOXES . 'gv_admin_dhtml.php');
  require(DIR_WS_BOXES . 'extras_dhtml.php');

?>
</ul>
</div>

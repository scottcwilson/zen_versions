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
// $Id: tpl_main_page.php 277 2004-09-10 23:03:52Z wilt $
//

  $header_template = 'tpl_header.php';
  $footer_template = 'tpl_footer.php';
  $left_column_file = 'column_left.php';
  $body_id = str_replace('_', '', $_GET['main_page']);

?>
<body id="<?php echo $body_id; ?>" <?php echo $zc_first_field;?>>
<div id="wrap">
  <div id="header">
  <img src="<?php echo DIR_WS_INSTALL_TEMPLATE; ?>images/zen_header_bg.jpg">
  </div>
  <div id="content">
  <?php
  require($body_code);
  ?>
  </div>
  <div id="navigation">
  <?php
  require(DIR_WS_INSTALL_TEMPLATE . "sideboxes/navigation.php");
  ?>
  </div>
  <div id="footer">
    <p>Copyright &copy; 2003 <a href="http://www.zen-cart.com" target="_blank">Zen Cart</a></p>
  </div>
</div>
</body>
</html>
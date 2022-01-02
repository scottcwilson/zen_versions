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
// $Id: admin_setup_default.php 290 2004-09-15 19:48:26Z wilt $
//
?>
<h1>:: <?php echo TEXT_PAGE_HEADING; ?></h1>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) require(DIR_WS_INSTALL_TEMPLATE . 'templates/display_errors.php');
?>

    <form method="post" action="index.php?main_page=admin_setup&language=<?php  echo $language; ?>">
	  <fieldset>
	  <legend><?php echo ADMIN_INFORMATION; ?></legend>
		<div class="section">
		  <input type="text" id="admin_username" name="admin_username" tabindex="1" value="<?php echo ADMIN_USERNAME_VALUE; ?>" />
		  <label for="admin_username"><?php echo ADMIN_USERNAME; ?></label>
		  <p><?php echo ADMIN_USERNAME_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=51\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="password" id="admin_pass" name="admin_pass" tabindex="1" />
		  <label for="admin_pass"><?php echo ADMIN_PASS; ?></label>
		  <p><?php echo ADMIN_PASS_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=53\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="password" id="admin_pass_confirm" name="admin_pass_confirm" tabindex="1"/>
		  <label for="admin_pass_confirm"><?php echo ADMIN_PASS_CONFIRM; ?></label>
		  <p><?php echo ADMIN_PASS_CONFIRM_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=54\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="admin_email" name="admin_email" tabindex="1" value="<?php echo ADMIN_EMAIL_VALUE; ?>" />
		  <label for="admin_email"><?php echo ADMIN_EMAIL; ?></label>
		  <p><?php echo ADMIN_EMAIL_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=52\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
	  </fieldset>
	  <input type="submit" name="submit" class="button" tabindex="1" value="<?php echo SAVE_ADMIN_SETTINGS; ?>" />
    </form>
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
// $Id: database_setup_default.php 920 2005-01-09 19:04:03Z ajeh $
//
?>
<h1>:: <?php echo TEXT_PAGE_HEADING; ?></h1>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) require(DIR_WS_INSTALL_TEMPLATE . 'templates/display_errors.php');
?>

    <form method="post" action="index.php?main_page=database_setup&physical_path=<?php echo $_GET['physical_path']; ?>&virtual_http_path=<?php echo $_GET['virtual_http_path']; ?>&virtual_https_path=<?php echo $_GET['virtual_https_path']; ?>&virtual_https_server=<?php echo $_GET['virtual_https_server']; ?>&enable_ssl=<?php echo $_GET['enable_ssl']; ?>&enable_ssl_admin=<?php echo $_GET['enable_ssl_admin']; ?>&sql_cache_dir=<?php echo $_GET['sql_cache_dir']; ?>&cache_type=<?php echo $_GET['cache_type']; ?>&phpbb_dir=<?php echo $_GET['phpbb_dir']; ?>&sql_cache=<?php echo $_GET['sql_cache']; ?>&is_upgrade=<?php echo $_GET['is_upgrade']; ?>&use_phpbb=<?php echo $_GET['use_phpbb']; ?>">
	  <fieldset>
	  <legend><?php echo DATABASE_INFORMATION; ?></legend>
	    <div class="section">
		  <select id="db_type" name="db_type" tabindex="1">
		    <option value="mysql"<?php echo setSelected('mysql', $_POST['db_type']); ?>>MySQL</option>
			<option value="postgres"<?php echo setSelected('postgres', $_POST['db_type']); ?>>PostgreSQL</option>
		  </select>
	      <label for="db_type"><?php echo DATABASE_TYPE; ?></label>
		  <p><?php echo DATABASE_TYPE_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=14\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
<?php if (!$is_upgrade || $zc_install->fatal_error) { //do not display prefix field if upgrading ... prefix can be edited on the database-upgrade page, next. ?>
		<div class="section">
		  <input type="text" id="db_prefix" name="db_prefix" tabindex="2" value="<?php echo DATABASE_NAME_PREFIX; ?>" size="18" />
		  <label for="db_prefix"><?php echo DATABASE_PREFIX; ?></label>
		  <p><?php echo DATABASE_PREFIX_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=19\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
<?php } else { ?>
		  <input type="hidden" id="db_prefix" name="db_prefix" value="<?php echo DATABASE_NAME_PREFIX; ?>" />
<?php } ?>

                <div class="section">
		  <input type="text" id="db_host" name="db_host" tabindex="3" value="<?php echo DATABASE_HOST_VALUE; ?>" size="18" />
		  <label for="db_host"><?php echo DATABASE_HOST; ?></label>
		  <p><?php echo DATABASE_HOST_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=15\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="db_username" name="db_username" tabindex="4" value="<?php echo DATABASE_USERNAME_VALUE; ?>" size="18" />
		  <label for="db_username"><?php echo DATABASE_USERNAME; ?></label>
		  <p><?php echo DATABASE_USERNAME_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=16\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="password" id="db_pass" name="db_pass" tabindex="5" />
		  <label for="db_pass"><?php echo DATABASE_PASSWORD; ?></label>
		  <p><?php echo DATABASE_PASSWORD_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=17\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
		<div class="section">
		  <input type="text" id="db_name" name="db_name" tabindex="6" value="<?php echo DATABASE_NAME_VALUE; ?>" size="18" />
		  <label for="db_name"><?php echo DATABASE_NAME; ?></label>
		  <p><?php echo DATABASE_NAME_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=18\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>

<!--
		<div class="section">
		  <div class="input">
		    <input type="radio" name="db_conn" id="db_conn_yes" tabindex="7" value="true" <?php echo DB_CONN_TRUE; ?>/>
		    <label for="db_conn_yes"><?php echo YES; ?></label>
		    <input type="radio" name="db_conn" id="db_conn_no" tabindex="7" value="false" <?php echo DB_CONN_FALSE; ?>/>
		    <label for="db_conn_no"><?php echo NO; ?></label>
		  </div>
		  <span class="label"><?php echo DATABASE_CONNECTION; ?></span>
		  <p><?php echo DATABASE_CONNECTION_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=21\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
-->

		<div class="section">
		  <div class="input">
		    <input type="radio" name="db_sess" id="db_sess_yes" tabindex="8" value="true" <?php echo DB_SESS_TRUE; ?>/>
		    <label for="db_sess_yes"><?php echo YES; ?></label>
		    <input type="radio" name="db_sess" id="db_sess_no" tabindex="8" value="false" <?php echo DB_SESS_FALSE; ?>/>
		    <label for="db_sess_no"><?php echo NO; ?></label>
		  </div>
		  <span class="label"><?php echo DATABASE_SESSION; ?></span>
		  <p><?php echo DATABASE_SESSION_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=22\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
	    <div class="section">
		  <select id="cache_type" name="cache_type" tabindex="9">
		    <option value="none"<?php echo setSelected('none', $_POST['cache_type']); ?>>None</option>
		    <option value="file"<?php echo setSelected('file', $_POST['cache_type']); ?>>File</option>
		    <option value="database"<?php echo setSelected('database', $_POST['cache_type']); ?>>Database</option>
		  </select>
	      <label for="cache_type"><?php echo CACHE_TYPE; ?></label>
		  <p><?php echo CACHE_TYPE_INSTRUCTION . '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=60\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
                <div class="section">
		  <input type="text" id="sql_cache_dir" name="sql_cache_dir" tabindex="10" size="55" value="<?php echo SQL_CACHE_VALUE; ?>" />
		  <label for="sql_cache_dir"><?php echo SQL_CACHE; ?></label>
		  <p><?php echo SQL_CACHE_INSTRUCTION. '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=59\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
		</div>
          </fieldset>
	  <input type="submit" name="submit" class="button" tabindex="15" value="<?php echo SAVE_DATABASE_SETTINGS; ?>" />
    </form>
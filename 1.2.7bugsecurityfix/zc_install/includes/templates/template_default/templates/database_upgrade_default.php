<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2006 The zen-cart developers                           |
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
// $Id: database_upgrade_default.php 2902 2006-01-27 06:47:23Z drbyte $
//
?>
<h1>:: <?php echo PAGE_HEADING; ?></h1>
<p><?php echo TEXT_MAIN; ?></p>
<?php
  if ($zc_install->error) require(DIR_WS_INSTALL_TEMPLATE . 'templates/display_errors.php');
?>
    <form method="post" action="index.php?main_page=database_upgrade"<?php if (isset($_GET['language'])) { echo '&language=' . $_GET['language']; } ?>">
<?php if ($zdb_configuration_table_found) { ?>
<p><?php echo TEXT_MAIN_2; ?></p>
    <fieldset>
    <legend><?php echo DATABASE_INFORMATION . ' -- &nbsp;<strong>' . SNIFFER_PREDICTS . $sniffer . '</strong>'; ?></legend>
      <div class="section">
        <label for="db_type"><?php echo '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=14\')"> ' . DATABASE_TYPE. '</a>'; ?></label>
      <?php echo '&nbsp;=&nbsp;' . DB_TYPE; ?>
    </div>
    <div class="section">
      <label for="db_host"><?php echo '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=15\')"> ' . DATABASE_HOST . '</a>'; ?></label>
      <?php echo '&nbsp;=&nbsp;' . DB_SERVER; ?>
    </div>
    <div class="section">
      <label for="db_name"><?php echo '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=18\')"> ' . DATABASE_NAME . '</a>'; ?></label>
      <?php echo '&nbsp;=&nbsp;' . DB_DATABASE; ?>
    </div>
    <div class="section">
      <label for="db_username"><?php echo '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=16\')"> ' . DATABASE_USERNAME . '</a>'; ?></label>
      <?php echo '&nbsp;=&nbsp;' . DB_SERVER_USERNAME; ?>
    </div>
    <div class="section">
      <label for="db_prefix"><?php echo '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=19\')"> ' . DATABASE_PREFIX . '</a>'; ?></label>
      <?php echo '&nbsp;=&nbsp;' . DB_PREFIX; ?>
    </div>
    <div class="section">
      <label for="db_prefix"><?php echo '<a href="javascript:popupWindow(\'popup_help_screen.php?error_code=87\')"> ' . DATABASE_PRIVILEGES . '</a>'; ?></label>
      <?php echo '&nbsp;=&nbsp;' . $zdb_privs; ?>
    </div>
    </fieldset>
    <br />

    <fieldset>
    <legend><strong><?php echo CHOOSE_UPGRADES; ?></strong></legend>
      <div class="input">
      <input <?php if ($needs_v1_1_0) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox1" value="1.0.4"  tabindex="1" >
      <label for="checkbox1">Upgrade DB from 1.0.4 to 1.1.1</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_1_1) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox2" value="1.1.0" tabindex="2" >
      <label for="checkbox2">Upgrade DB from 1.1.0 to 1.1.1</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_1_2) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox3" value="1.1.1" tabindex="3" >
      <label for="checkbox3">Upgrade DB from 1.1.1 to 1.1.2</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_1_4) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox4" value="1.1.2-or-1.1.3" tabindex="4" >
      <label for="checkbox4">Upgrade DB from 1.1.2 or 1.1.3 to 1.1.4</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_1_4_patch1) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox5" value="1.1.4" tabindex="5" >
      <label for="checkbox5">Upgrade DB from 1.1.4 to 1.1.4-patch1</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_2_0) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox6" value="1.1.4u" tabindex="6" >
      <label for="checkbox6">Upgrade DB from 1.1.4-x to 1.2.0</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_2_1) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox7" value="1.2.0" tabindex="7" >
      <label for="checkbox7">Upgrade DB from 1.2.0 to 1.2.1</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_2_2) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox8" value="1.2.1" tabindex="8" >
      <label for="checkbox8">Upgrade DB from 1.2.1 to 1.2.2</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_2_3) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox9" value="1.2.2" tabindex="9" >
      <label for="checkbox9">Upgrade DB from 1.2.2 to 1.2.3</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_2_4) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox10" value="1.2.3" tabindex="10" >
      <label for="checkbox10">Upgrade DB from 1.2.3 to 1.2.4</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_2_5) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox11" value="1.2.4" tabindex="11" >
      <label for="checkbox11">Upgrade DB from 1.2.4 to 1.2.5</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_2_6) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox11" value="1.2.5" tabindex="12" >
      <label for="checkbox12">Upgrade DB from 1.2.5 to 1.2.6</label>
    </div>
      <div class="input">
      <input <?php if ($needs_v1_2_7) {echo "checked";} ?> name="version[]" type="checkbox" id="checkbox11" value="1.2.6" tabindex="13" >
      <label for="checkbox12">Upgrade DB from 1.2.6 to 1.2.7</label>
    </div>
    </fieldset>
    <br />
<?php } //endif $zdb_configuration_table_found ?>


    <fieldset>
    <legend><strong><?php echo TITLE_DATABASE_PREFIX_CHANGE; ?></strong></legend>
<?php if (!$zdb_configuration_table_found) { ?>
      <?php echo ERROR_PREFIX_CHANGE_NEEDED; ?><br /><br />
      <div class="section">
        <input type="text" id="db_prefix" name="db_prefix" tabindex="14" value="<?php echo DB_PREFIX; ?>" />
        <label for="db_prefix"><?php echo DATABASE_OLD_PREFIX; ?></label>
        <p><?php echo DATABASE_OLD_PREFIX_INSTRUCTION; ?></p>
      </div>
<?php } else { // end of display field to enter "old" prefix if couldn't connect to database before ?>
      <?php echo TEXT_DATABASE_PREFIX_CHANGE; ?><br /><br />
<?php } // display normal heading ?>
      <div class="section">
      <input type="text" id="newprefix" name="newprefix" tabindex="15" value="<?php echo DB_PREFIX; ?>" />
      <label for="newprefix"><?php echo ENTRY_NEW_PREFIX; ?></label>
        <p><?php echo DATABASE_NEW_PREFIX_INSTRUCTION .'&nbsp; <a href="javascript:popupWindow(\'popup_help_screen.php?error_code=19\')"> ' . TEXT_HELP_LINK . '</a>'; ?></p>
      <?php echo TEXT_DATABASE_PREFIX_CHANGE_WARNING; ?><br /><br />
    </div>
    </fieldset>
<br />

    <fieldset>
    <legend><strong><?php echo TITLE_SECURITY; ?></strong></legend>
      <?php echo ADMIN_PASSSWORD_INSTRUCTION .'&nbsp; <a href="javascript:popupWindow(\'popup_help_screen.php?error_code=78\')"> ' . TEXT_HELP_LINK . '</a>'; ?> <br /><br />
     <div class="section">
      <input type="text" id="adminid" name="adminid" tabindex="18" size="18" value="<?php echo $_POST['adminid']; ?>" />
      <label for="adminid"><?php echo ENTRY_ADMIN_ID; ?></label>
     <div class="section">
    </div>
      <input type="password" id="adminpwd" name="adminpwd" tabindex="19" />
      <label for="adminpwd"><?php echo ENTRY_ADMIN_PASSWORD; ?></label>
    <br />
    </div>

    </fieldset>

    <br />&nbsp;&nbsp;<?php echo UPDATE_DATABASE_WARNING_DO_NOT_INTERRUPT; ?>&nbsp;
<?php if (isset($_GET['debug'])) echo '<input type="hidden" id="debug" name="debug" value="'.$_GET['debug'].'" />'; ?>
<?php if (isset($_GET['debug2'])) echo '<input type="hidden" id="debug2" name="debug2" value="'.$_GET['debug2'].'" />'; ?>
<?php if (isset($_GET['debug3'])) echo '<input type="hidden" id="debug3" name="debug3" value="'.$_GET['debug3'].'" />'; ?>
<?php if (isset($_GET['nogrants'])) echo '<input type="hidden" id="nogrants" name="nogrants" value="'.$_GET['nogrants'].'" />'; ?>
<?php if (isset($_POST['nogrants'])) echo '<input type="hidden" id="nogrants" name="nogrants" value="'.$_POST['nogrants'].'" />'; ?>
    <input type="submit" name="submit" class="button"  tabindex="20" value="<?php echo UPDATE_DATABASE_NOW; ?>" />
<?php if ($zdb_configuration_table_found) { ?>
    <input type="submit" name="skip" class="button"  tabindex="21" value="<?php echo SKIP_UPDATES; ?>" />
<?php } //endif ?>
    </form>
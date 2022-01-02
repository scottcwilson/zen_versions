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
//  $Id: sqlpatch.php 277 2004-09-10 23:03:52Z wilt $
//
  require('includes/application_top.php');

  define('HEADING_TITLE','SQL Query Executor');
  define('HEADING_WARNING','BE SURE TO DO A FULL DATABASE BACKUP BEFORE RUNNING SCRIPTS HERE');
  define('HEADING_WARNING2','If you are installing 3rd-party contributions, note that you do so at your own risk.<br />Zen Cart&trade; makes no warranty as to the safety of scripts supplied by 3rd-party contributors. Test before using on your live database!');
  define('TEXT_QUERY_RESULTS','Query Results:');
  define('TEXT_ENTER_QUERY_STRING','Enter the query <br />to be executed:&nbsp;&nbsp;<br /><br />Be sure to<br />end with ;');
  define('TEXT_QUERY_FILENAME','Upload file:');
  define('ERROR_NOTHING_TO_DO','Error: Nothing to do - no query or query-file specified.');
  define('TEXT_CLOSE_WINDOW', '[ close window ]');
  define('SQLPATCH_HELP_TEXT','The SQLPATCH tool lets you install system patches by pasting SQL code directly into the textarea '.
                              'field here, or by uploading a supplied script (.SQL) file.  ' . "\n\n" . 'The commands entered or ' .
                              'uploaded may only begin with the following statements, and MUST be in UPPERCASE: ' . "\n" .
                              '<ul><li>DROP TABLE IF EXISTS</li><li>CREATE TABLE</li><li>INSERT INTO</li><li>ALTER TABLE</li>' .
                              '<li>UPDATE</li><li>DELETE FROM</li></ul>' . "\n\n" .
                              'When preparing scripts to be used by this tool, DO NOT include a table prefix, as this tool will ' .
                              'automatically insert the required prefix for the active database, based on settings in the store\'s ' .
                              'admin/includes/configure.php file (DB_PREFIX definition).' . "\n");

//NOTE: THIS IS INTENTIONAL:
$linebreak = '
';
// NOTE: this line break is intentional!!!!

  function executeSql($lines, $database, $table_prefix = -1) {
    if (!get_cfg_var('safe_mode')) {
      set_time_limit(1200);
    }
    global $db, $debug;
    $newline = '';
    $saveline = '';
    foreach ($lines as $line) {
      $line = trim($line);
      $line = $saveline . $line;
      $keep_together = 1;

      // The following command checks to see if we're asking for a block of commands to be run at once.
      // Syntax: #NEXT_X_ROWS_AS_ONE_COMMAND:6     for running the next 6 commands together (commands denoted by a ;)
      if (substr($line,0,28) == '#NEXT_X_ROWS_AS_ONE_COMMAND:') $keep_together = substr($line,28);
      if (substr($line,0,1) != '#' && substr($line,0,1) != '-' && $line != '') {
        if ($table_prefix != -1) {
//echo '*}'.$line.'<br>';
          if (strtoupper(substr($line, 0, 21)) == 'DROP TABLE IF EXISTS ') {
            $line = 'DROP TABLE IF EXISTS ' . $table_prefix . substr($line, 21);
          } elseif (strtoupper(substr($line, 0, 13)) == 'CREATE TABLE ') {
            $line = 'CREATE TABLE ' . $table_prefix . substr($line, 13);
          } elseif (strtoupper(substr($line, 0, 12)) == 'INSERT INTO ') {
            $line = 'INSERT INTO ' . $table_prefix . substr($line, 12);
          } elseif (strtoupper(substr($line, 0, 12)) == 'ALTER TABLE ') {
            $line = 'ALTER TABLE ' . $table_prefix . substr($line, 12);
          } elseif (strtoupper(substr($line, 0, 7)) == 'UPDATE ') {
            $line = 'UPDATE ' . $table_prefix . substr($line, 7);
          } elseif (strtoupper(substr($line, 0, 12)) == 'DELETE FROM ') {
            $line = 'DELETE FROM ' . $table_prefix . substr($line, 12);
          } elseif (strtoupper(substr($line, 0, 7)) == 'UPDATE ') {
            $line = 'UPDATE ' . $table_prefix . substr($line, 7);
          } elseif (strtoupper(substr($line, 0, 8)) == 'SELECT (' && substr_count($line,'FROM ')>0) {
            $line = str_replace('FROM ','FROM '. $table_prefix, $line);
          } elseif (strtoupper(substr($line, 0, 10)) == 'LEFT JOIN ') {
            $line = 'LEFT JOIN ' . $table_prefix . substr($line, 10);
          } elseif (strtoupper(substr($line, 0, 5)) == 'FROM ') {
            if (substr_count($line,',')>0) { // contains FROM and a comma, thus must parse for multiple tablenames
              $tbl_list = explode(',',substr($line,5));
              $line = 'FROM ';
              foreach($tbl_list as $val) {
                $line .= $table_prefix . trim($val) . ','; // add prefix and comma
              } //end foreach
              if (substr($line,-1)==',') $line = substr($line,0,(strlen($line)-1)); // remove trailing ','
            } else { //didn't have a comma, but starts with "FROM ", so insert table prefix
              $line = str_replace('FROM ', 'FROM '.$table_prefix, $line); 
            }//endif substr_count(,)
          } //end if/elseif series
        } // endif $table_prefix
        $newline .= $line . ' ';

        if ( substr($line,-1) ==  ';') {
          //found a semicolon, so treat it as a full command, incrementing counter of rows to process at once
          if (substr($newline,-1)==' ') $newline = substr($newline,0,(strlen($newline)-1)); 
          $lines_to_keep_together_counter++; 
          if ($lines_to_keep_together_counter == $keep_together) { // if all grouped rows have been loaded, go to execute.
            $complete_line = true;
            $lines_to_keep_together_counter=0;
          } else {
            $complete_line = false;
          }
        } //endif found ';'

        if ($complete_line) {
          if ($debug==true) echo 'About to execute.  Debug info:<br>$ line='.$line.'<br>$ complete_line='.$complete_line.'<br>$ keep_together='.$keep_together.'<br>SQL='.$newline.'<br><br>';
          if (get_magic_quotes_runtime() > 0) $newline=stripslashes($newline);
          $output=$db->Execute($newline);
          $results++;
          $string .= $newline.'<br />';
          $return_output[]=$output;
          // reset var's
          $newline = '';
          $keep_together=1;
          $complete_line = false;
        } //endif $complete_line
      } //endif ! # or -
    } // end foreach $lines
  return array('queries'=> $results, 'string'=>$string, 'output'=>$return_output);
  } //end function

  if (isset($_GET['debug']) && $_GET['debug']=='ON') $debug=true;
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (zen_not_null($action)) {
    switch ($action) {
      case 'execute':
       if (isset($_POST['query_string']) && $_POST['query_string'] !='' ) {
         $query_string = $_POST['query_string'];
         if (@get_magic_quotes_gpc() > 0) $query_string = stripslashes($query_string);
         if ($debug==true) echo $query_string . '<br />';
         $query_string = explode($linebreak, ($query_string));
         $query_results = executeSql($query_string, DB_DATABASE, DB_PREFIX);
           if ($query_results['queries'] > 0) {
             $messageStack->add('Success: '.$query_results['queries'], 'success');
           } else {
             $messageStack->add('Failed: '.$query_results['queries'], 'error');
           }
       } else {
         $messageStack->add(ERROR_NOTHING_TO_DO, 'error');
       }
       break;
      case 'uploadquery':
            $upload_query = file($_FILES['sql_file']['tmp_name']);
            $query_string  = zen_db_prepare_input($upload_query);
            if ($query_string !='') {
//              if (@get_magic_quotes_runtime() > 0) $query_string = stripslashes($query_string); //may be redundant since using zen_db_prepare_input()
              $query_results = executeSql($query_string, DB_DATABASE, DB_PREFIX);
              if ($query_results['queries'] > 0) {
                $messageStack->add('Success: '.$query_results['queries'], 'success');
              } else {
                $messageStack->add('Failed: '.$query_results['queries'], 'error');
              }
            } else {
              $messageStack->add(ERROR_NOTHING_TO_DO, 'error');
            }
       break;
      case 'help':
       break;
      default:
       break;
    }
  }
?>
<? if ($action != 'help') { ?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script type="text/javascript">
  <!--
  function popupHelpWindow(url) {
    window.open(url,'popupImageWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
  }
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
<body onload="init()" >
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->


<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
        <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
      </tr>
      <tr><td class="alert"><?php echo HEADING_WARNING; ?></td></tr>
       <tr>
          <td class="alert"><b><?php echo HEADING_WARNING2; ?></td>
       </tr>
    </table></td>
  </tr>
<?php
  if ( $action == 'execute'  && $_POST['query_string'] !='' ) {
?>
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
          <td class="smallText"><b><?php echo TEXT_QUERY_RESULTS; ?></td>
       </tr>
       <tr>
         <td class="smallText"><?php echo $query_results['string']; ?></td>
       </tr>
     </table></td>
   </tr>
<?php
  }
?>
    <tr><?php echo zen_draw_form('getquery', FILENAME_SQLPATCH, 'action=execute' . (($debug==true)?'&debug=ON':''),'post', ''); ?>
      <td><table border="0" cellpadding="0" cellspacing="2">
        <tr>
          <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
        </tr>
        <tr>
          <td valign="top" class="main" width="110px"><?php echo TEXT_ENTER_QUERY_STRING; ?></td>
          <td><?php echo zen_draw_textarea_field('query_string', 'soft', '80%', '10', '','',false); ?></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><?php echo zen_image_submit('button_send.gif', IMAGE_SEND); ?></td>
        </tr>
      </table></td>
    </form></tr>


    <tr><?php echo zen_draw_form('getqueryfile', FILENAME_SQLPATCH, 'action=uploadquery' . (($debug==true)?'&debug=ON':''),'post', 'enctype="multipart/form-data"'); ?>
      <td><table border="0" cellpadding="0" cellspacing="2">
        <tr>
          <td valign="top" class="main" width="110px">&nbsp;<?php echo TEXT_QUERY_FILENAME; ?> </td>
          <td><?php echo zen_draw_file_field('sql_file'); ?>&nbsp;&nbsp;&nbsp;<?php echo zen_image_submit('button_upload.gif', IMAGE_UPLOAD); ?></td>
        </tr>
      </table></td>
    </form></tr>
        <tr>
          <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
        </tr>
    <tr>
      <td width="300" align="right">
        <a href="<?php echo zen_href_link(FILENAME_SQLPATCH, 'action=help'); ?>" target='_blank'><?php echo zen_image_button('button_details.gif', IMAGE_DETAILS); ?></a></td>
    </tr>
<!-- body_text_eof //-->
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

<?php } elseif ($action == 'help') { // endif $action != 'help' ?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html  <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title>HELP - <?php echo HEADING_TITLE; ?> - Zen Cart&trade;</title>
</head>
<body id="popup"></body>
<div id="popup_header">
<h1>
<?php
  echo 'Zen Cart&trade; ' . HEADING_TITLE;
  echo '<br /><br />';
?>
</h1>
</div>
<div id="popup_content">
<span style="  color: #FF0000;  font-weight: bold;"><?php echo HEADING_WARNING; ?></span><br />
<?php
  echo SQLPATCH_HELP_TEXT;
  echo '<br /><br />';
?>
<span style="  color: #FF0000;  font-weight: bold;"><?php echo HEADING_WARNING; ?></span><br />
<span style="  color: #FF0000;  font-weight: bold;"><?php echo HEADING_WARNING2; ?></span><br />
</div>
<?php
  echo '<center>' . '<a href="javascript:window.close()">' . TEXT_CLOSE_WINDOW . '</a></center>';
?>
</body>
</html>
<?php } //endif $action = help ?>
<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
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
// $Id: general.php 277 2004-09-10 23:03:52Z wilt $
//


  function zen_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }

function setInputValue($input, $constant, $default) {
  if (isset($input)) {
    define($constant, $input);
  } else {
    define($constant, $default);
  }
}

function setRadioChecked($input, $constant, $default) {
  if ($input == '') {
	$input = $default;
  }
  if ($input == 'true') {
	define($constant . '_FALSE', '');
	define($constant . '_TRUE', 'checked="checked" ');
  } else {
	define($constant . '_FALSE', 'checked="checked" ');
	define($constant . '_TRUE', '');
  }
}

function setSelected($input, $selected) {
  if ($input == $selected) {
    return ' selected="selected"';
  }
}
function executeSql($sql_file, $database, $table_prefix = -1) {
//	  echo 'start SQL execute';
	    global $db;

    if (!get_cfg_var('safe_mode')) {
      set_time_limit(1200);
    }

    $lines = file($sql_file);
    $newline = '';
//    $saveline = '';
    foreach ($lines as $line) {
      $line = trim($line);
//      $line = $saveline . $line;
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
          if ($debug=='ON') echo 'About to execute.  Debug info:<br>$ line='.$line.'<br>$ complete_line='.$complete_line.'<br>$ keep_together='.$keep_together.'<br>SQL='.$newline.'<br><br>';
          if (get_magic_quotes_runtime() > 0) $newline=stripslashes($newline);
          $db->Execute($newline);
          // reset var's
          $newline = '';
          $keep_together=1;
          $complete_line = false;
        } //endif $complete_line

      } //endif ! # or -
    } // end foreach $lines
  } //end function

  function zen_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(zen_sanitize_string(stripslashes($string)));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = zen_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }

  function zen_sanitize_string($string) {
    $string = ereg_replace(' +', ' ', $string);
    return preg_replace("/[<>]/", '_', $string);
  }

  function zen_validate_email($email = "root@localhost.localdomain") {
    $valid_address = true;
    $user ="";
    $domain="";
// split the e-mail address into user and domain parts
// need to update to trap for addresses in the format of "first@last"@someplace.com
// this method will most likely break in that case
	list( $user, $domain ) = explode( "@", $email );
	$valid_ip_form = '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}';
	$valid_email_pattern = '^[a-z0-9]+[a-z0-9_\.\'\-]*@[a-z0-9]+[a-z0-9\.\-]*\.(([a-z]{2,6})|([0-9]{1,3}))$';
	$space_check = '[ ]';

// strip beginning and ending quotes, if and only if both present
	if( (ereg('^["]', $user) && ereg('["]$', $user)) ){
		$user = ereg_replace ( '^["]', '', $user );
		$user = ereg_replace ( '["]$', '', $user );
		$user = ereg_replace ( $space_check, '', $user ); //spaces in quoted addresses OK per RFC (?)
		$email = $user."@".$domain; // contine with stripped quotes for remainder
	}

// if e-mail domain part is an IP address, check each part for a value under 256
	if (ereg($valid_ip_form, $domain)) {
	  $digit = explode( ".", $domain );
	  for($i=0; $i<4; $i++) {
		if ($digit[$i] > 255) {
		  $valid_address = false;
		  return $valid_address;
		  exit;
		}
// stop crafty people from using internal IP addresses
		if (($digit[0] == 192) || ($digit[0] == 10)) {
		  $valid_address = false;
		  return $valid_address;
		  exit;
		}
	  }
	}

	if (!ereg($space_check, $email)) { // trap for spaces in
	  if ( eregi($valid_email_pattern, $email)) { // validate against valid e-mail patterns
		$valid_address = true;
	  } else {
		$valid_address = false;
		return $valid_address;
		exit;
	  	}
	  }

// Verify e-mail has an associated MX and/or A record.
// Need alternate method to deal with Verisign shenanigans and with Windows Servers
//		if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
//		  $valid_address = false;
//		}

    return $valid_address;
  }

  function zen_encrypt_password($plain) {
    $password = '';

    for ($i=0; $i<10; $i++) {
      $password .= zen_rand();
    }

    $salt = substr(md5($password), 0, 2);

    $password = md5($salt . $plain) . ':' . $salt;

    return $password;
  }

  function zen_rand($min = null, $max = null) {
    static $seeded;

    if (!isset($seeded)) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }

  function zen_read_config_value($value) {
    $files_array = array();
    $files_array[] = '../includes/configure.php';

    if ($za_dir = @dir('../includes/' . 'extra_configures')) {
      while ($zv_file = $za_dir->read()) {
        if (strstr($zv_file, '.php')) {
          //echo $zv_file.'<br>';
          $files_array[] = $zv_file;
        }
      }
    }
    foreach ($files_array as $filename) {
     if (!file_exists($filename)) continue;
     //echo $filename . '!<br>';
     $lines = file($filename);
     foreach($lines as $line) { // read the configure.php file for specific variables
       $def_string=array();
       $def_string=explode("'",$line);
       //define('CONSTANT','value');
       //[1]=TABLE_CONSTANT
       //[2]=,
       //[3]=value
       //[4]=);
       //[5]=
       if (strtoupper($def_string[1]) == $value ) $string .= $def_string[3];
     }//end foreach $line
   }//end foreach $filename
  return $string;
  }

?>
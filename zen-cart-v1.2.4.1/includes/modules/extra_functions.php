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
// $Id: extra_functions.php 290 2004-09-15 19:48:26Z wilt $
//

// set directories to check for function files
  $extra_functions_directory = DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'extra_functions/';
  $ws_extra_functions_directory = DIR_WS_FUNCTIONS . 'extra_functions/';

// Check for new functions in extra_functions directory
  $dir_check= $directory_array;
  $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));

  if ($dir = @dir($extra_functions_directory)) {
    while ($file = $dir->read()) {
      if (!is_dir($extra_functions_directory . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
            $directory_array[] = $file;
        }
      }
    }
    if (sizeof($directory_array)) {
      sort($directory_array);
    }
    $dir->close();
  }

  $file_cnt=0;
  for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++) {
    $file_cnt++;
    $file = $directory_array[$i];

    if (file_exists($ws_extra_functions_directory . $file)) {
//      echo 'LOADING: ' . $ws_extra_functions_directory . $file . ' ' . $file_cnt . '<br />';
      include($ws_extra_functions_directory . $file);
    }
  }
?>
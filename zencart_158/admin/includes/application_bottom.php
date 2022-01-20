<?php
/**
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2019 Sep 15 Modified in v1.5.7 $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
//  @todo icwtodo Development debug code
// do not remove for now
if (defined('DEV_SHOW_APPLICATION_BOTTOM_DEBUG') && DEV_SHOW_APPLICATION_BOTTOM_DEBUG == true) {
    $langLoaded = $languageLoader->getLanguageFilesLoaded();
    dump($langLoaded);
    $files = get_included_files();
    $langFiles = [];
    $pattern = '~^' . DIR_FS_CATALOG . DIR_WS_LANGUAGES . '~';
    foreach ($files as $file) {
        $shortFile = str_replace(DIR_FS_CATALOG, '', $file);
        if (in_array($shortFile, $langLoaded['legacy']) || in_array($file, $langLoaded['legacy'])) {
            continue;
        }
        if (in_array($shortFile, $langLoaded['arrays']) || in_array($file, $langLoaded['arrays'])) {
            continue;
        }
        if (preg_match($pattern, $file)) {
            $langFiles[] = $file;
        }
    }
    dump($langFiles);
//dump($_SESSION);
}
// close session (store variables)
  session_write_close();

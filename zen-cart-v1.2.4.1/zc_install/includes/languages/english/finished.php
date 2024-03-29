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
// $Id: finished.php 277 2004-09-10 23:03:52Z wilt $
//

  define('TEXT_MAIN',"<h2>Congratulations!</h2><h3>You have successfully installed Zen Cart&trade; on your system!</h3><p>
<h2>NEXT STEPS</h2>For security, you will need to reset your <strong>configure.php</strong> files located in the <strong>/admin/includes/</strong> and <strong>/includes/</strong> folders back to read-only mode before allowing people to access your store.<br /><br />
Additionally, you'll want to remove or rename the <strong>/zc_install</strong> folder so that someone can't re-install your shop again and wipe out your database!  Warnings will appear until the folder has been removed or renamed.
<h2>CONFIGURATION</h2>We encourage you to begin by <a href=\"http://www.zen-cart.com\"><strong>reading the FAQ's</strong> in our online support forums</a> for useful information to assist with configuring and customizing your online shop the way you wish it to look and operate. 
If you have questions, this is the first place to look! If you're stumped, feel free to post a question! We have a helpful, friendly, knowledgeable community who welcomes you.
<h2>IMPORTANT READING</h2>The most important thing you'll want to become familiar with in order to customize your site is our <em><strong>template system</strong></em>.  There are some very good articles on the template system in our <a href=\"http://www.zen-cart.com\">online FAQ section</a>.
<h2>ADDITIONAL READING</h2>In our <a href=\"http://www.zen-cart.com\">online forums</a>, there is a section called '<strong>Downloads</strong>'.  Inside, there is a category called '<strong>Documentation</strong>', which contains the latest versions of manuals which cover the various aspects of managing your site.<br /><br />
We're glad you chose Zen Cart&trade; to be your e-Commerce solution!<br /><br />" . 
'<a href="http://www.zen-cart.com">Visit us online at www.zen-cart.com</a>' . '</p>' .
'<p>Press the <em>Store</em> button below to test out your store or press the <em>Admin</em> button to begin customizing your store.</p>');

  define('TEXT_PAGE_HEADING', 'Zen Cart&trade; Setup - Finished');
  define('STORE', 'Click here to go to the Store');
  define('ADMIN', 'Click here to open the Admin area');
?>
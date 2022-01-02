
*****************************************************************
Installing the Zen Cart v1.2.4 Shipping Module and Security Patch
*****************************************************************

This patch prevents a possible URL spoof in the Admin that would 
allow a hacker to view a page. This patch also fixes the 
textarea bug in the table and zones shipping rate modules 
and fixes the miscalculation of the number of boxes when the 
maximum weight was reached in the UPS and USPS shipping modules.

*****************************************************************

After unzipping the package you should have:

docs/README.txt (this file)

admin/includes/application_top.php
admin/includes/functions/general.php
includes/modules/shipping/table.php
includes/modules/shipping/ups.php
includes/modules/shipping/usps.php
includes/modules/shipping/zones.php

****************************************************************
Before making any changes, make sure to have a current backup of 
your files and your database.
****************************************************************

To install: 

Upload the the 3 directories (/docs/, /includes/, /admin/) to 
the root of your Zen Cart installation. The files need to overwrite 
the stock files of Zen Cart. 

If you have made custom changes to any of the files in the package 
you need to add your code changes to the patch files before uploading.

****************************************************************
****************************************************************
After uploading the patch files, it is recommended for additional 
security that you rename your admin directory.
****************************************************************
****************************************************************

****************************************************************
How to Rename the Admin Directory

Before making any changes, make sure to have a current backup of your files and your database.


1- Open your admin/includes/configure.php.
   Change all instances of /admin/ to your chosen name.

Change this section:

// NOTE: be sure to leave the trailing '/' at the end of these lines if you make changes!
// * DIR_WS_* = Webserver directories (virtual/URL)
  // these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)
  define('DIR_WS_ADMIN', '/admin/');
  define('DIR_WS_CATALOG', '/');
  define('DIR_WS_HTTPS_ADMIN', '/admin/');
  define('DIR_WS_HTTPS_CATALOG', '/');

Change this section:

// * DIR_FS_* = Filesystem directories (local/physical)
  //the following path is a COMPLETE path to your Zen Cart files. eg: /var/www/vhost/accountname/public_html/store/
  define('DIR_FS_ADMIN', '/home/mystore.com/www/public/admin/');
  define('DIR_FS_CATALOG', '/home/mystore.com/www/public/');


2- Find your Zen Cart /admin/ directory. Rename the directory to match your admin/includes/configure.php.
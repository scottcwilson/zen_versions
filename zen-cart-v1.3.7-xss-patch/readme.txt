Zen Cart v1.3.7  XSS PATCH   Released April 21, 2007
====================================================

There exist some XSS-related issues for which you will want to patch your site.

The vulnerability only affects those people using the special TEXT input attribute on their products.
The problem arises due to insufficient cleansing of outputs.

NOTE: we have fixed the vulnerability by specifically targeting output functions where the TEXT attribute data is displayed, in both catalog and admin. This is how we have addressed possible and actual XSS vulnerabilities in the past.
We have not used global cleansing of all $_POST variables, as this may limit the functionality of various intrinsic Zen Cart operations.

The files in this zip are:
/readme.txt (this file should not be uploaded to your site. All the rest should)
/admin/orders.php
/admin/packingslip.php
/admin/invoice.php
/includes/modules/pages/shopping_cart/header_php.php
/includes/templates/template_default/templates/tpl_account_history_info_default.php
/includes/templates/template_default/templates/tpl_checkout_confirmation_default.php


DETAILS
=======

To combat a possible XSS exploit vulnerability in Zen Cart, simply copy the 
enclosed files to your v1.3.7 website.

Remember, if you have renamed your admin folder, you will have to use *that* 
folder name when copying/uploading the /admin/ folder files.

Further, if you have customized copies of the enclosed template files, you 
should manually apply the changes from these files into your customized files.
Using WinMerge as a file-comparison tool will help you quickly identify your
customizations and help you merge the changes easily.




APPLYING TO OLDER VERSIONS
==========================
If you need to apply these fixes to an older version of Zen Cart, this can be accomplished by replacing this:

$order->products[$i]['attributes'][$j]['value']

with this:

zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])

... in the affected files.

In the modules/pages/shopping_cart/header_php.php file, the change is a little different, like this:
$attr_value
becomes:
zen_output_string_protected($attr_value)


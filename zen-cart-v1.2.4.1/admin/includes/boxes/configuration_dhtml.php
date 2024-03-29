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
//  $Id: configuration_dhtml.php 290 2004-09-15 19:48:26Z wilt $
//

?>
<!-- configuration //-->
<li class="submenu"> 
<a target="_top" href="<?php echo  zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL') ?>"><?php echo BOX_HEADING_CONFIGURATION; ?></a><ul>
<?php
  $heading = array();
  $contents = array();
  $heading[] = array('text'  => BOX_HEADING_CONFIGURATION,

                     'link'  => zen_href_link(basename($PHP_SELF), zen_get_all_get_params(array('selected_box')) . 'selected_box=configuration'));
  if (1 == 1) {
    $cfg_groups = '';
    $configuration_groups = $db->Execute("select configuration_group_id as cgID, 
                                                       configuration_group_title as cgTitle 
                                                from " . TABLE_CONFIGURATION_GROUP . " 
                                                where visible = '1' order by sort_order");

    while (!$configuration_groups->EOF) {
      $cfg_groups .= '<li><a href="' . zen_href_link(FILENAME_CONFIGURATION, 'gID=' . $configuration_groups->fields['cgID'], 'NONSSL') . '">' . $configuration_groups->fields['cgTitle'] . '</a></li>';
      $configuration_groups->MoveNext();
    }
  }
echo $cfg_groups;
?>
</ul>
</li>
<!-- configuration_eof //-->
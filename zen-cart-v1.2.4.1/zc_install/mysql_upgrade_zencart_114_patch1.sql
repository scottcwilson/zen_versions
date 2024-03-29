# The following commands are used to upgrade the Zen Cart v1.1.4 database structure to v1.1.4-PATCH1 format.
#
# $Id: mysql_upgrade_zencart_114_patch1.sql 277 2004-09-10 23:03:52Z wilt $
#

Update configuration set configuration_title = 'Package Tare Small to Medium - added percentage:weight' where configuration_key= 'SHIPPING_BOX_WEIGHT';
Update configuration set configuration_description= 'What is the weight of typical packaging of small to medium packages?<br />Example: 10% + 1lb 10:1<br />10% + 0lbs 10:0<br />0% + 5lbs 0:5<br />0% + 0lbs 0:0' where configuration_key= 'SHIPPING_BOX_WEIGHT';
Update configuration set configuration_title = 'Larger packages - added packaging percentage:weight' where configuration_key= 'SHIPPING_BOX_PADDING';
Update configuration set configuration_description= 'What is the weight of typical packaging for Large packages?<br />Example: 10% + 1lb 10:1<br />10% + 0lbs 10:0<br />0% + 5lbs 0:5<br />0% + 0lbs 0:0' where configuration_key= 'SHIPPING_BOX_PADDING';

## END OF UPDATE
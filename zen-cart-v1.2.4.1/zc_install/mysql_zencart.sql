# Main Zen Cart SQL Load for MySQL databases
#
# $Id: mysql_zencart.sql 981 2005-02-09 06:56:47Z drbyte $
#
#
# Table structure for table address_book
#

DROP TABLE IF EXISTS address_book;
CREATE TABLE address_book (
  address_book_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  entry_gender char(1) NOT NULL default '',
  entry_company varchar(32) default NULL,
  entry_firstname varchar(32) NOT NULL default '',
  entry_lastname varchar(32) NOT NULL default '',
  entry_street_address varchar(64) NOT NULL default '',
  entry_suburb varchar(32) default NULL,
  entry_postcode varchar(10) NOT NULL default '',
  entry_city varchar(32) NOT NULL default '',
  entry_state varchar(32) default NULL,
  entry_country_id int(11) NOT NULL default '0',
  entry_zone_id int(11) NOT NULL default '0',
  PRIMARY KEY  (address_book_id),
  KEY idx_address_book_customers_id (customers_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table address_format
#

DROP TABLE IF EXISTS address_format;
CREATE TABLE address_format (
  address_format_id int(11) NOT NULL auto_increment,
  address_format varchar(128) NOT NULL default '',
  address_summary varchar(48) NOT NULL default '',
  PRIMARY KEY  (address_format_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table admin
#

DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
  admin_id int(11) NOT NULL auto_increment,
  admin_name varchar(32) NOT NULL default '',
  admin_email varchar(96) NOT NULL default '',
  admin_pass varchar(40) NOT NULL default '',
  admin_level tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (admin_id)
) TYPE=MyISAM;

# --------------------------------------------------------

DROP TABLE IF EXISTS authorizenet;
CREATE TABLE authorizenet (
  id int(11) unsigned NOT NULL auto_increment,
  customer_id int(11) NOT NULL default '0',
  order_id int(11) NOT NULL default '0',
  response_code int(1) NOT NULL default '0',
  response_text varchar(255) NOT NULL default '',
  authorization_type text NOT NULL,
  transaction_id int(15) NOT NULL default '0',
  sent longtext NOT NULL,
  received longtext NOT NULL,
  time varchar(50) NOT NULL default '',
  session_id varchar(255) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM;

#
# Table structure for table banners
#

DROP TABLE IF EXISTS banners;
CREATE TABLE banners (
  banners_id int(11) NOT NULL auto_increment,
  banners_title varchar(64) NOT NULL default '',
  banners_url varchar(255) NOT NULL default '',
  banners_image varchar(64) NOT NULL default '',
  banners_group varchar(15) NOT NULL default '',
  banners_html_text text,
  expires_impressions int(7) default '0',
  expires_date datetime default NULL,
  date_scheduled datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  date_status_change datetime default NULL,
  status int(1) NOT NULL default '1',
  banners_open_new_windows int(1) NOT NULL default '1',
  banners_on_ssl int(1) NOT NULL default '1',
  PRIMARY KEY  (banners_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table banners_history
#

DROP TABLE IF EXISTS banners_history;
CREATE TABLE banners_history (
  banners_history_id int(11) NOT NULL auto_increment,
  banners_id int(11) NOT NULL default '0',
  banners_shown int(5) NOT NULL default '0',
  banners_clicked int(5) NOT NULL default '0',
  banners_history_date datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (banners_history_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table categories
#

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  categories_id int(11) NOT NULL auto_increment,
  categories_image varchar(64) default NULL,
  parent_id int(11) NOT NULL default '0',
  sort_order int(3) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  categories_status tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (categories_id),
  KEY idx_categories_parent_id (parent_id),
  KEY idx_sort_order (sort_order)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table categories_description
#

DROP TABLE IF EXISTS categories_description;
CREATE TABLE categories_description (
  categories_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  categories_name varchar(32) NOT NULL default '',
  categories_description text NOT NULL,
  PRIMARY KEY  (categories_id,language_id),
  KEY idx_categories_name (categories_name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table configuration
#

DROP TABLE IF EXISTS configuration;
CREATE TABLE configuration (
  configuration_id int(11) NOT NULL auto_increment,
  configuration_title text NOT NULL,
  configuration_key varchar(255) NOT NULL default '',
  configuration_value text NOT NULL,
  configuration_description text NOT NULL,
  configuration_group_id int(11) NOT NULL default '0',
  sort_order int(5) default NULL,
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  use_function text default NULL,
  set_function text default NULL,
  PRIMARY KEY  (configuration_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table configuration_group
#

DROP TABLE IF EXISTS configuration_group;
CREATE TABLE configuration_group (
  configuration_group_id int(11) NOT NULL auto_increment,
  configuration_group_title varchar(64) NOT NULL default '',
  configuration_group_description varchar(255) NOT NULL default '',
  sort_order int(5) default NULL,
  visible int(1) default '1',
  PRIMARY KEY  (configuration_group_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table counter
#

DROP TABLE IF EXISTS counter;
CREATE TABLE counter (
  startdate char(8) default NULL,
  counter int(12) default NULL
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table counter_history
#

DROP TABLE IF EXISTS counter_history;
CREATE TABLE counter_history (
  month char(8) default NULL,
  counter int(12) default NULL
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table countries
#

DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
  countries_id int(11) NOT NULL auto_increment,
  countries_name varchar(64) NOT NULL default '',
  countries_iso_code_2 char(2) NOT NULL default '',
  countries_iso_code_3 char(3) NOT NULL default '',
  address_format_id int(11) NOT NULL default '0',
  PRIMARY KEY  (countries_id),
  KEY IDX_COUNTRIES_NAME (countries_name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table coupon_email_track
#

DROP TABLE IF EXISTS coupon_email_track;
CREATE TABLE coupon_email_track (
  unique_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  customer_id_sent int(11) NOT NULL default '0',
  sent_firstname varchar(32) default NULL,
  sent_lastname varchar(32) default NULL,
  emailed_to varchar(32) default NULL,
  date_sent datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (unique_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table coupon_gv_customer
#

DROP TABLE IF EXISTS coupon_gv_customer;
CREATE TABLE coupon_gv_customer (
  customer_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  PRIMARY KEY  (customer_id),
  KEY customer_id (customer_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table coupon_gv_queue
#

DROP TABLE IF EXISTS coupon_gv_queue;
CREATE TABLE coupon_gv_queue (
  unique_id int(5) NOT NULL auto_increment,
  customer_id int(5) NOT NULL default '0',
  order_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  date_created datetime NOT NULL default '0001-01-01 00:00:00',
  ipaddr varchar(32) NOT NULL default '',
  release_flag char(1) NOT NULL default 'N',
  PRIMARY KEY  (unique_id),
  KEY uid (unique_id,customer_id,order_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table coupon_redeem_track
#

DROP TABLE IF EXISTS coupon_redeem_track;
CREATE TABLE coupon_redeem_track (
  unique_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  customer_id int(11) NOT NULL default '0',
  redeem_date datetime NOT NULL default '0001-01-01 00:00:00',
  redeem_ip varchar(32) NOT NULL default '',
  order_id int(11) NOT NULL default '0',
  PRIMARY KEY  (unique_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table coupon_restrict
#

DROP TABLE IF EXISTS coupon_restrict;
CREATE TABLE coupon_restrict (
  restrict_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  product_id int(11) NOT NULL default '0',
  category_id int(11) NOT NULL default '0',
  coupon_restrict char(1) NOT NULL default 'N',
  PRIMARY KEY  (restrict_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table coupons
#

DROP TABLE IF EXISTS coupons;
CREATE TABLE coupons (
  coupon_id int(11) NOT NULL auto_increment,
  coupon_type char(1) NOT NULL default 'F',
  coupon_code varchar(32) NOT NULL default '',
  coupon_amount decimal(8,4) NOT NULL default '0.0000',
  coupon_minimum_order decimal(8,4) NOT NULL default '0.0000',
  coupon_start_date datetime NOT NULL default '0001-01-01 00:00:00',
  coupon_expire_date datetime NOT NULL default '0001-01-01 00:00:00',
  uses_per_coupon int(5) NOT NULL default '1',
  uses_per_user int(5) NOT NULL default '0',
  restrict_to_products varchar(255) default NULL,
  restrict_to_categories varchar(255) default NULL,
  restrict_to_customers text,
  coupon_active char(1) NOT NULL default 'Y',
  date_created datetime NOT NULL default '0001-01-01 00:00:00',
  date_modified datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (coupon_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table coupons_description
#

DROP TABLE IF EXISTS coupons_description;
CREATE TABLE coupons_description (
  coupon_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '0',
  coupon_name varchar(32) NOT NULL default '',
  coupon_description text,
  KEY coupon_id (coupon_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table currencies
#

DROP TABLE IF EXISTS currencies;
CREATE TABLE currencies (
  currencies_id int(11) NOT NULL auto_increment,
  title varchar(32) NOT NULL default '',
  code char(3) NOT NULL default '',
  symbol_left varchar(24) default NULL,
  symbol_right varchar(24) default NULL,
  decimal_point char(1) default NULL,
  thousands_point char(1) default NULL,
  decimal_places char(1) default NULL,
  value float(13,8) default NULL,
  last_updated datetime default NULL,
  PRIMARY KEY  (currencies_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table customers
#

DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
  customers_id int(11) NOT NULL auto_increment,
  customers_gender char(1) NOT NULL default '',
  customers_firstname varchar(32) NOT NULL default '',
  customers_lastname varchar(32) NOT NULL default '',
  customers_dob datetime NOT NULL default '0001-01-01 00:00:00',
  customers_email_address varchar(96) NOT NULL default '',
  customers_nick varchar(96) NOT NULL default '',
  customers_default_address_id int(11) NOT NULL default '0',
  customers_telephone varchar(32) NOT NULL default '',
  customers_fax varchar(32) default NULL,
  customers_password varchar(40) NOT NULL default '',
  customers_newsletter char(1) default NULL,
  customers_group_pricing int(11) NOT NULL default '0',
  customers_email_format VARCHAR( 4 ) DEFAULT 'TEXT' NOT NULL,
  customers_authorization int(1) NOT NULL default '0',
  customers_referral VARCHAR(32) NOT NULL default '',
  PRIMARY KEY  (customers_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table customers_basket
#

DROP TABLE IF EXISTS customers_basket;
CREATE TABLE customers_basket (
  customers_basket_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  products_id tinytext NOT NULL,
  customers_basket_quantity FLOAT DEFAULT '0' NOT NULL,
  final_price decimal(15,4) NOT NULL default '0.0000',
  customers_basket_date_added varchar(8) default NULL,
  PRIMARY KEY  (customers_basket_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table customers_basket_attributes
#

DROP TABLE IF EXISTS customers_basket_attributes;
CREATE TABLE customers_basket_attributes (
  customers_basket_attributes_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  products_id tinytext NOT NULL,
  products_options_id varchar(64) NOT NULL default '0',
  products_options_value_id int(11) NOT NULL default '0',
  products_options_value_text varchar(64) default NULL,
  products_options_sort_order text NOT NULL,
  PRIMARY KEY  (customers_basket_attributes_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table customers_info
#

DROP TABLE IF EXISTS customers_info;
CREATE TABLE customers_info (
  customers_info_id int(11) NOT NULL default '0',
  customers_info_date_of_last_logon datetime default NULL,
  customers_info_number_of_logons int(5) default NULL,
  customers_info_date_account_created datetime default NULL,
  customers_info_date_account_last_modified datetime default NULL,
  global_product_notifications int(1) default '0',
  PRIMARY KEY  (customers_info_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table db_cache
#
DROP TABLE IF EXISTS db_cache;
CREATE TABLE db_cache (
  cache_entry_name varchar(64) NOT NULL,
  cache_data blob,
  cache_entry_created int(15),
  PRIMARY KEY  (cache_entry_name)
) TYPE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table featured
#

DROP TABLE IF EXISTS featured;
CREATE TABLE featured (
  featured_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  featured_date_added datetime default NULL,
  featured_last_modified datetime default NULL,
  expires_date date NOT NULL default '0001-01-01',
  date_status_change datetime default NULL,
  status int(1) NOT NULL default '1',
  featured_date_available date NOT NULL default '0001-01-01',
  PRIMARY KEY  (featured_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table files_uploaded
#

DROP TABLE IF EXISTS files_uploaded;
CREATE TABLE files_uploaded (
  files_uploaded_id int(11) NOT NULL auto_increment,
  sesskey varchar(32) default NULL,
  customers_id int(11) default NULL,
  files_uploaded_name varchar(64) NOT NULL default '',
  PRIMARY KEY  (files_uploaded_id)
) TYPE=MyISAM COMMENT='Must always have either a sesskey or customers_id';

# --------------------------------------------------------

#
# Table structure for table geo_zones
#

DROP TABLE IF EXISTS geo_zones;
CREATE TABLE geo_zones (
  geo_zone_id int(11) NOT NULL auto_increment,
  geo_zone_name varchar(32) NOT NULL default '',
  geo_zone_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (geo_zone_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `get_terms_to_filter`
#
DROP TABLE IF EXISTS get_terms_to_filter;
CREATE TABLE get_terms_to_filter (
  get_term_name varchar(255) NOT NULL default '',
  PRIMARY KEY  (get_term_name)
) TYPE=MyISAM;

#
# Table structure for table geo_zones
#

DROP TABLE IF EXISTS group_pricing;
CREATE TABLE group_pricing (
  group_id int(11) NOT NULL auto_increment,
  group_name varchar(32) NOT NULL default '',
  group_percentage decimal(5,2) NOT NULL default '0',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (group_id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table languages
#

DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
  languages_id int(11) NOT NULL auto_increment,
  name varchar(32) NOT NULL default '',
  code char(2) NOT NULL default '',
  image varchar(64) default NULL,
  directory varchar(32) default NULL,
  sort_order int(3) default NULL,
  PRIMARY KEY  (languages_id),
  KEY IDX_LANGUAGES_NAME (name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table layout_boxes
#

DROP TABLE IF EXISTS layout_boxes;
CREATE TABLE layout_boxes (
  layout_id int(11) NOT NULL auto_increment,
  layout_template varchar(64) NOT NULL default '',
  layout_box_name varchar(64) NOT NULL default '',
  layout_box_status tinyint(1) NOT NULL default '0',
  layout_box_location tinyint(1) NOT NULL default '0',
  layout_box_sort_order int(11) NOT NULL default '0',
  layout_box_sort_order_single int(11) NOT NULL default '0',
  layout_box_status_single tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (layout_id),
  KEY layout_box_status (layout_box_status)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table manufacturers
#

DROP TABLE IF EXISTS manufacturers;
CREATE TABLE manufacturers (
  manufacturers_id int(11) NOT NULL auto_increment,
  manufacturers_name varchar(32) NOT NULL default '',
  manufacturers_image varchar(64) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (manufacturers_id),
  KEY IDX_MANUFACTURERS_NAME (manufacturers_name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table music_genre
#

DROP TABLE IF EXISTS music_genre;
CREATE TABLE music_genre (
  music_genre_id int(11) NOT NULL auto_increment,
  music_genre_name varchar(32) NOT NULL default '',
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (music_genre_id),
  KEY IDX_MUSIC_GENRE_NAME (music_genre_name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table manufacturers_info
#

DROP TABLE IF EXISTS manufacturers_info;
CREATE TABLE manufacturers_info (
  manufacturers_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  manufacturers_url varchar(255) NOT NULL default '',
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime default NULL,
  PRIMARY KEY  (manufacturers_id,languages_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table media_clips
#

DROP TABLE IF EXISTS media_clips;
CREATE TABLE media_clips (
  clip_id int(11) NOT NULL auto_increment,
  media_id int(11) NOT NULL default '0',
  clip_type smallint(6) NOT NULL default '0',
  clip_filename text NOT NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (clip_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table media_manager
#

DROP TABLE IF EXISTS media_manager;
CREATE TABLE media_manager (
  media_id int(11) NOT NULL auto_increment,
  media_name varchar(255) NOT NULL default '',
  last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (media_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table media_to_products
#

DROP TABLE IF EXISTS media_to_products;
CREATE TABLE media_to_products (
  media_id int(11) NOT NULL default '0',
  product_id int(11) NOT NULL default '0'
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table media_types
#

DROP TABLE IF EXISTS media_types;
CREATE TABLE media_types (
  type_id int(11) NOT NULL auto_increment,
  type_name varchar(64) NOT NULL default '',
  type_ext varchar(8) NOT NULL default '',
  PRIMARY KEY  (type_id)
) TYPE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table newsletters
#

DROP TABLE IF EXISTS newsletters;
CREATE TABLE newsletters (
  newsletters_id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  content text NOT NULL,
  content_html TEXT NOT NULL,
  module varchar(255) NOT NULL default '',
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  date_sent datetime default NULL,
  status int(1) default NULL,
  locked int(1) default '0',
  PRIMARY KEY  (newsletters_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table orders
#

DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  orders_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  customers_name varchar(64) NOT NULL default '',
  customers_company varchar(32) default NULL,
  customers_street_address varchar(64) NOT NULL default '',
  customers_suburb varchar(32) default NULL,
  customers_city varchar(32) NOT NULL default '',
  customers_postcode varchar(10) NOT NULL default '',
  customers_state varchar(32) default NULL,
  customers_country varchar(32) NOT NULL default '',
  customers_telephone varchar(32) NOT NULL default '',
  customers_email_address varchar(96) NOT NULL default '',
  customers_address_format_id int(5) NOT NULL default '0',
  delivery_name varchar(64) NOT NULL default '',
  delivery_company varchar(32) default NULL,
  delivery_street_address varchar(64) NOT NULL default '',
  delivery_suburb varchar(32) default NULL,
  delivery_city varchar(32) NOT NULL default '',
  delivery_postcode varchar(10) NOT NULL default '',
  delivery_state varchar(32) default NULL,
  delivery_country varchar(32) NOT NULL default '',
  delivery_address_format_id int(5) NOT NULL default '0',
  billing_name varchar(64) NOT NULL default '',
  billing_company varchar(32) default NULL,
  billing_street_address varchar(64) NOT NULL default '',
  billing_suburb varchar(32) default NULL,
  billing_city varchar(32) NOT NULL default '',
  billing_postcode varchar(10) NOT NULL default '',
  billing_state varchar(32) default NULL,
  billing_country varchar(32) NOT NULL default '',
  billing_address_format_id int(5) NOT NULL default '0',
  payment_method varchar(32) NOT NULL default '',
  payment_module_code varchar(32) NOT NULL default '',
  shipping_method varchar(32) NOT NULL default '',
  shipping_module_code varchar(32) NOT NULL default '',
  coupon_code varchar(32) NOT NULL default '',
  cc_type varchar(20) default NULL,
  cc_owner varchar(64) default NULL,
  cc_number varchar(32) default NULL,
  cc_expires varchar(4) default NULL,
  cc_cvv blob,
  last_modified datetime default NULL,
  date_purchased datetime default NULL,
  orders_status int(5) NOT NULL default '0',
  orders_date_finished datetime default NULL,
  currency char(3) default NULL,
  currency_value decimal(14,6) default NULL,
  order_total decimal(14,2) default NULL,
  order_tax decimal(14,2) default NULL,
  paypal_ipn_id INT( 11 ) DEFAULT '0' NOT NULL,
  PRIMARY KEY  (orders_id)
) TYPE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table orders_products
#

DROP TABLE IF EXISTS orders_products;
CREATE TABLE orders_products (
  orders_products_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  products_id int(11) NOT NULL default '0',
  products_model varchar(32) default NULL,
  products_name varchar(64) NOT NULL default '',
  products_price decimal(15,4) NOT NULL default '0.0000',
  final_price decimal(15,4) NOT NULL default '0.0000',
  products_tax decimal(7,4) NOT NULL default '0.0000',
  products_quantity FLOAT DEFAULT '0' NOT NULL,
  onetime_charges decimal(15,4) NOT NULL default '0.0000',
  products_priced_by_attribute tinyint(1) NOT NULL default '0',
  product_is_free tinyint(1) NOT NULL default '0',
  products_discount_type tinyint(1) NOT NULL default '0',
  products_discount_type_from tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (orders_products_id)
) TYPE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table orders_products_attributes
#

DROP TABLE IF EXISTS orders_products_attributes;
CREATE TABLE orders_products_attributes (
  orders_products_attributes_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_products_id int(11) NOT NULL default '0',
  products_options varchar(32) NOT NULL default '',
  products_options_values varchar(32) NOT NULL default '',
  options_values_price decimal(15,4) NOT NULL default '0.0000',
  price_prefix char(1) NOT NULL default '',
  product_attribute_is_free tinyint(1) NOT NULL default '0',
  products_attributes_weight decimal(8,4) NOT NULL default '0.0000',
  products_attributes_weight_prefix char(1) NOT NULL default '',
  attributes_discounted tinyint(1) NOT NULL default '1',
  attributes_price_base_included tinyint(1) NOT NULL default '1',
  attributes_price_onetime decimal(15,4) NOT NULL default '0.0000',
  attributes_price_factor decimal(15,4) NOT NULL default '0.0000',
  attributes_price_factor_offset decimal(15,4) NOT NULL default '0.0000',
  attributes_price_factor_onetime decimal(15,4) NOT NULL default '0.0000',
  attributes_price_factor_onetime_offset decimal(15,4) NOT NULL default '0.0000',
  attributes_qty_prices text,
  attributes_qty_prices_onetime text,
  attributes_price_words decimal(15,4) NOT NULL default '0.0000',
  attributes_price_words_free int(4) NOT NULL default '0',
  attributes_price_letters decimal(15,4) NOT NULL default '0.0000',
  attributes_price_letters_free int(4) NOT NULL default '0',
  products_options_id INT( 11 ) DEFAULT '0' NOT NULL,
  products_options_values_id INT( 11 ) DEFAULT '0' NOT NULL,
  PRIMARY KEY  (orders_products_attributes_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table orders_products_download
#

DROP TABLE IF EXISTS orders_products_download;
CREATE TABLE orders_products_download (
  orders_products_download_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_products_id int(11) NOT NULL default '0',
  orders_products_filename varchar(255) NOT NULL default '',
  download_maxdays int(2) NOT NULL default '0',
  download_count int(2) NOT NULL default '0',
  PRIMARY KEY  (orders_products_download_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table orders_status
#

DROP TABLE IF EXISTS orders_status;
CREATE TABLE orders_status (
  orders_status_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  orders_status_name varchar(32) NOT NULL default '',
  PRIMARY KEY  (orders_status_id,language_id),
  KEY idx_orders_status_name (orders_status_name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table orders_status_history
#

DROP TABLE IF EXISTS orders_status_history;
CREATE TABLE orders_status_history (
  orders_status_history_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_status_id int(5) NOT NULL default '0',
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  customer_notified int(1) default '0',
  comments text,
  PRIMARY KEY  (orders_status_history_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table orders_total
#

DROP TABLE IF EXISTS orders_total;
CREATE TABLE orders_total (
  orders_total_id int(10) unsigned NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  text varchar(255) NOT NULL default '',
  value decimal(15,4) NOT NULL default '0.0000',
  class varchar(32) NOT NULL default '',
  sort_order int(11) NOT NULL default '0',
  PRIMARY KEY  (orders_total_id),
  KEY idx_orders_total_orders_id (orders_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table product_types
#

DROP TABLE IF EXISTS product_types;
CREATE TABLE product_types (
  type_id int(11) NOT NULL auto_increment,
  type_name varchar(255) NOT NULL default '',
  type_handler varchar(255) NOT NULL default '',
  type_master_type int(11) NOT NULL default '1',
  allow_add_to_cart char(1) NOT NULL default 'Y',
  default_image varchar(255) NOT NULL default '',
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  last_modified datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (type_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table product_types_to_category
#

DROP TABLE IF EXISTS product_types_to_category;
CREATE TABLE product_types_to_category (
  product_type_id int(11) NOT NULL default '0',
  category_id int(11) NOT NULL default '0'
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products
#

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  products_id int(11) NOT NULL auto_increment,
  products_type int(11) NOT NULL default '1',
  products_quantity FLOAT DEFAULT '0' NOT NULL,
  products_model varchar(32) default NULL,
  products_image varchar(64) default NULL,
  products_price decimal(15,4) NOT NULL default '0.0000',
  products_virtual tinyint(1) NOT NULL default '0',
  products_date_added datetime NOT NULL default '0001-01-01 00:00:00',
  products_last_modified datetime default NULL,
  products_date_available datetime default NULL,
  products_weight decimal(5,2) NOT NULL default '0.00',
  products_status tinyint(1) NOT NULL default '0',
  products_tax_class_id int(11) NOT NULL default '0',
  manufacturers_id int(11) default NULL,
  products_ordered FLOAT DEFAULT '0' NOT NULL,
  products_quantity_order_min FLOAT DEFAULT '1' NOT NULL,
  products_quantity_order_units FLOAT DEFAULT '1' NOT NULL,
  products_priced_by_attribute tinyint(1) NOT NULL default '0',
  product_is_free tinyint(1) NOT NULL default '0',
  product_is_call tinyint(1) NOT NULL default '0',
  products_quantity_mixed tinyint(1) NOT NULL default '0',
  product_is_always_free_shipping tinyint(1) NOT NULL default '0',
  products_qty_box_status tinyint(1) NOT NULL default '1',
  products_quantity_order_max FLOAT DEFAULT '0' NOT NULL,
  products_sort_order int(11) NOT NULL default '0',
  products_discount_type tinyint(1) NOT NULL default '0',
  products_discount_type_from tinyint(1) NOT NULL default '0',
  products_price_sorter decimal(15,4) NOT NULL default '0.0000',
  master_categories_id int(11) NOT NULL default '0',
  products_mixed_discount_quantity tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (products_id),
  KEY idx_products_date_added (products_date_added)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_attributes
#

DROP TABLE IF EXISTS products_attributes;
CREATE TABLE products_attributes (
  products_attributes_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  options_id int(11) NOT NULL default '0',
  options_values_id int(11) NOT NULL default '0',
  options_values_price decimal(15,4) NOT NULL default '0.0000',
  price_prefix char(1) NOT NULL default '',
  products_options_sort_order int(11) NOT NULL default '0',
  product_attribute_is_free tinyint(1) NOT NULL default '0',
  products_attributes_weight decimal(8,4) NOT NULL default '0.0000',
  products_attributes_weight_prefix char(1) NOT NULL default '',
  attributes_display_only tinyint(1) NOT NULL default '0',
  attributes_default tinyint(1) NOT NULL default '0',
  attributes_discounted tinyint(1) NOT NULL default '1',
  attributes_image varchar(64) default NULL,
  attributes_price_base_included tinyint(1) NOT NULL default '1',
  attributes_price_onetime decimal(15,4) NOT NULL default '0.0000',
  attributes_price_factor decimal(15,4) NOT NULL default '0.0000',
  attributes_price_factor_offset decimal(15,4) NOT NULL default '0.0000',
  attributes_price_factor_onetime decimal(15,4) NOT NULL default '0.0000',
  attributes_price_factor_onetime_offset decimal(15,4) NOT NULL default '0.0000',
  attributes_qty_prices text,
  attributes_qty_prices_onetime text,
  attributes_price_words decimal(15,4) NOT NULL default '0.0000',
  attributes_price_words_free int(4) NOT NULL default '0',
  attributes_price_letters decimal(15,4) NOT NULL default '0.0000',
  attributes_price_letters_free int(4) NOT NULL default '0',
  attributes_required tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (products_attributes_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_attributes_download
#

DROP TABLE IF EXISTS products_attributes_download;
CREATE TABLE products_attributes_download (
  products_attributes_id int(11) NOT NULL default '0',
  products_attributes_filename varchar(255) NOT NULL default '',
  products_attributes_maxdays int(2) default '0',
  products_attributes_maxcount int(2) default '0',
  PRIMARY KEY  (products_attributes_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_description
#

DROP TABLE IF EXISTS products_description;
CREATE TABLE products_description (
  products_id int(11) NOT NULL auto_increment,
  language_id int(11) NOT NULL default '1',
  products_name varchar(64) NOT NULL default '',
  products_description text,
  products_url varchar(255) default NULL,
  products_viewed int(5) default '0',
  PRIMARY KEY  (products_id,language_id),
  KEY products_name (products_name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_discount_quantity
#
DROP TABLE IF EXISTS products_discount_quantity;
CREATE TABLE products_discount_quantity (
  discount_id int(4) NOT NULL default '0',
  products_id int(11) NOT NULL default '0',
  discount_qty FLOAT DEFAULT '0' NOT NULL,
  discount_price decimal(15,4) NOT NULL default '0.0000'
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table product_music_extra
#

DROP TABLE IF EXISTS product_music_extra;
CREATE TABLE product_music_extra (
  products_id int(11) NOT NULL default '0',
  artists_id int(11) NOT NULL default '0',
  record_company_id int(11) NOT NULL default '0',
  music_genre_id int(11) NOT NULL default '0',
  PRIMARY KEY  (products_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_notifications
#

DROP TABLE IF EXISTS products_notifications;
CREATE TABLE products_notifications (
  products_id int(11) NOT NULL default '0',
  customers_id int(11) NOT NULL default '0',
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (products_id,customers_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_options
#

DROP TABLE IF EXISTS products_options;
CREATE TABLE products_options (
  products_options_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  products_options_name varchar(32) NOT NULL default '',
  products_options_sort_order int(11) NOT NULL default '0',
  products_options_type int(5) NOT NULL default '0',
  products_options_length smallint(2) NOT NULL default '32',
  products_options_comment varchar(64) default NULL,
  products_options_size smallint(2) NOT NULL default '32',
  products_options_images_per_row int(2) default '5',
  products_options_images_style int(1) default '0',
  PRIMARY KEY  (products_options_id,language_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_options_types
#

DROP TABLE IF EXISTS products_options_types;
CREATE TABLE products_options_types (
  products_options_types_id int(11) NOT NULL default '0',
  products_options_types_name varchar(32) default NULL,
  PRIMARY KEY  (products_options_types_id)
) TYPE=MyISAM COMMENT='Track products_options_types';

# --------------------------------------------------------

#
# Table structure for table products_options_values
#

DROP TABLE IF EXISTS products_options_values;
CREATE TABLE products_options_values (
  products_options_values_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  products_options_values_name varchar(64) NOT NULL default '',
  products_options_values_sort_order int(11) NOT NULL default '0',
  PRIMARY KEY  (products_options_values_id,language_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_options_values_to_products_options
#

DROP TABLE IF EXISTS products_options_values_to_products_options;
CREATE TABLE products_options_values_to_products_options (
  products_options_values_to_products_options_id int(11) NOT NULL auto_increment,
  products_options_id int(11) NOT NULL default '0',
  products_options_values_id int(11) NOT NULL default '0',
  PRIMARY KEY  (products_options_values_to_products_options_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table products_to_categories
#

DROP TABLE IF EXISTS products_to_categories;
CREATE TABLE products_to_categories (
  products_id int(11) NOT NULL default '0',
  categories_id int(11) NOT NULL default '0',
  PRIMARY KEY  (products_id,categories_id)
) TYPE=MyISAM;

# --------------------------------------------------------


#
# Table structure for table record_artists
#

DROP TABLE IF EXISTS record_artists;
CREATE TABLE record_artists (
  artists_id int(11) NOT NULL auto_increment,
  artists_name varchar(32) NOT NULL default '',
  artists_image varchar(64) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (artists_id),
  KEY IDX_ARTISTS_NAME (artists_name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table record_artists_info
#

DROP TABLE IF EXISTS record_artists_info;
CREATE TABLE record_artists_info (
  artists_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  artists_url varchar(255) NOT NULL default '',
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime default NULL,
  PRIMARY KEY  (artists_id,languages_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table record_company
#

DROP TABLE IF EXISTS record_company;
CREATE TABLE record_company (
  record_company_id int(11) NOT NULL auto_increment,
  record_company_name varchar(32) NOT NULL default '',
  record_company_image varchar(64) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (record_company_id),
  KEY IDX_RECORD_COMPANY_NAME (record_company_name)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table record_company_info
#

DROP TABLE IF EXISTS record_company_info;
CREATE TABLE record_company_info (
  record_company_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  record_company_url varchar(255) NOT NULL default '',
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime default NULL,
  PRIMARY KEY  (record_company_id,languages_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table reviews
#

DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
  reviews_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  customers_id int(11) default NULL,
  customers_name varchar(64) NOT NULL default '',
  reviews_rating int(1) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  reviews_read int(5) NOT NULL default '0',
  status int(1) NOT NULL default '1',
  PRIMARY KEY  (reviews_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table reviews_description
#

DROP TABLE IF EXISTS reviews_description;
CREATE TABLE reviews_description (
  reviews_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  reviews_text text NOT NULL,
  PRIMARY KEY  (reviews_id,languages_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table salemaker_sales
#

DROP TABLE IF EXISTS salemaker_sales;
CREATE TABLE salemaker_sales (
  sale_id int(11) NOT NULL auto_increment,
  sale_status tinyint(4) NOT NULL default '0',
  sale_name varchar(30) NOT NULL default '',
  sale_deduction_value decimal(15,4) NOT NULL default '0.0000',
  sale_deduction_type tinyint(4) NOT NULL default '0',
  sale_pricerange_from decimal(15,4) NOT NULL default '0.0000',
  sale_pricerange_to decimal(15,4) NOT NULL default '0.0000',
  sale_specials_condition tinyint(4) NOT NULL default '0',
  sale_categories_selected text,
  sale_categories_all text,
  sale_date_start date NOT NULL default '0001-01-01',
  sale_date_end date NOT NULL default '0001-01-01',
  sale_date_added date NOT NULL default '0001-01-01',
  sale_date_last_modified date NOT NULL default '0001-01-01',
  sale_date_status_change date NOT NULL default '0001-01-01',
  PRIMARY KEY  (sale_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table sessions
#

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
  sesskey varchar(32) NOT NULL default '',
  expiry int(11) unsigned NOT NULL default '0',
  value text NOT NULL,
  PRIMARY KEY  (sesskey)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table specials
#

DROP TABLE IF EXISTS specials;
CREATE TABLE specials (
  specials_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  specials_new_products_price decimal(15,4) NOT NULL default '0.0000',
  specials_date_added datetime default NULL,
  specials_last_modified datetime default NULL,
  expires_date date NOT NULL default '0001-01-01',
  date_status_change datetime default NULL,
  status int(1) NOT NULL default '1',
  specials_date_available date NOT NULL default '0001-01-01',
  PRIMARY KEY  (specials_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table tax_class
#

DROP TABLE IF EXISTS tax_class;
CREATE TABLE tax_class (
  tax_class_id int(11) NOT NULL auto_increment,
  tax_class_title varchar(32) NOT NULL default '',
  tax_class_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (tax_class_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table tax_rates
#

DROP TABLE IF EXISTS tax_rates;
CREATE TABLE tax_rates (
  tax_rates_id int(11) NOT NULL auto_increment,
  tax_zone_id int(11) NOT NULL default '0',
  tax_class_id int(11) NOT NULL default '0',
  tax_priority int(5) default '1',
  tax_rate decimal(7,4) NOT NULL default '0.0000',
  tax_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (tax_rates_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table template_select
#

DROP TABLE IF EXISTS template_select;
CREATE TABLE template_select (
  template_id int(11) NOT NULL auto_increment,
  template_dir varchar(64) NOT NULL default '',
  template_language varchar(64) NOT NULL default '0',
  PRIMARY KEY  (template_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table whos_online
#

DROP TABLE IF EXISTS whos_online;
CREATE TABLE whos_online (
  customer_id int(11) default NULL,
  full_name varchar(64) NOT NULL default '',
  session_id varchar(128) NOT NULL default '',
  ip_address varchar(15) NOT NULL default '',
  time_entry varchar(14) NOT NULL default '',
  time_last_click varchar(14) NOT NULL default '',
  last_page_url varchar(255) NOT NULL default '',
  host_address text NOT NULL,
  KEY ip_address (ip_address),
  KEY session_id (session_id),
  KEY customer_id (customer_id),
  KEY time_entry (time_entry),
  KEY time_last_click (time_last_click),
  KEY last_page_url (last_page_url)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table zones
#

DROP TABLE IF EXISTS zones;
CREATE TABLE zones (
  zone_id int(11) NOT NULL auto_increment,
  zone_country_id int(11) NOT NULL default '0',
  zone_code varchar(32) NOT NULL default '',
  zone_name varchar(32) NOT NULL default '',
  PRIMARY KEY  (zone_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table zones_to_geo_zones
#

DROP TABLE IF EXISTS zones_to_geo_zones;
CREATE TABLE zones_to_geo_zones (
  association_id int(11) NOT NULL auto_increment,
  zone_country_id int(11) NOT NULL default '0',
  zone_id int(11) default NULL,
  geo_zone_id int(11) default NULL,
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY  (association_id)
) TYPE=MyISAM;


#
# Database table for customers_wishlist
#

DROP TABLE IF EXISTS customers_wishlist;
CREATE TABLE customers_wishlist (
  products_id int(13) NOT NULL default '0',
  customers_id int(13) NOT NULL default '0',
  products_model varchar(13) default NULL,
  products_name varchar(64) NOT NULL default '',
  products_price decimal(8,2) NOT NULL default '0.00',
  final_price decimal(8,2) NOT NULL default '0.00',
  products_quantity int(2) NOT NULL default '0',
  wishlist_name varchar(64) default NULL
) TYPE=MyISAM;


# data
INSERT INTO template_select VALUES (1, 'classic', '0');

# 1 - Default, 2 - USA, 3 - Spain, 4 - Singapore, 5 - Germany
INSERT INTO address_format VALUES (1, '$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country','$city / $country');
INSERT INTO address_format VALUES (2, '$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country','$city, $state / $country');
INSERT INTO address_format VALUES (3, '$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country','$state / $country');
INSERT INTO address_format VALUES (4, '$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country');
INSERT INTO address_format VALUES (5, '$firstname $lastname$cr$streets$cr$postcode $city$cr$country','$city / $country');

INSERT INTO admin VALUES (1, 'Admin', 'admin@localhost', '351683ea4e19efe34874b501fdbf9792:9b', 1);
INSERT INTO admin VALUES (2, 'demo', 'demo@localhost', '23ce1aad0e04a3d2334c7aef2f8ade83:58', 2);

INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status) VALUES (1, 'Zen Cart', 'http://www.zen-cart.com', 'banners/zencart_468_60_02.gif', 'Wide-Banners', '', 0, NULL, NULL, '2004-01-11 20:59:12', NULL, 1);
INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status) VALUES (2, 'Zen Cart the art of e-commerce', 'http://www.zen-cart.com', 'banners/125zen_logo.gif', 'SideBox-Banners', '', 0, NULL, NULL, '2004-01-11 20:59:12', NULL, 1);
INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status) VALUES (3, 'Zen Cart the art of e-commerce', 'http://www.zen-cart.com', 'banners/125x125_zen_logo.gif', 'SideBox-Banners', '', 0, NULL, NULL, '2004-01-11 20:59:12', NULL, 1);
INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status) VALUES (4, 'if you have to think ... you haven\'t been Zenned!', 'http://www.zen-cart.com', 'banners/think_anim.gif', 'Wide-Banners', '', 0, NULL, NULL, '2004-01-12 20:53:18', NULL, 1);
INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status) VALUES (5, 'Chain Reaction Web', 'http://www.chainreactionweb.com', 'banners/crw-zen-banner.gif', 'Wide-Banners', '', 0, NULL, NULL, '2004-01-12 20:56:01', NULL, 1);

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Store Name', 'STORE_NAME', 'Zen Cart', 'The name of my store', '1', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Store Owner', 'STORE_OWNER', 'Team Zen Cart', 'The name of my store owner', '1', '2', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Country', 'STORE_COUNTRY', '223', 'The country my store is located in <br /><br /><strong>Note: Please remember to update the store zone.</strong>', '1', '6', 'zen_get_country_name', 'zen_cfg_pull_down_country_list(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Zone', 'STORE_ZONE', '18', 'The zone my store is located in', '1', '7', 'zen_cfg_get_zone_name', 'zen_cfg_pull_down_zone_list(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Expected Sort Order', 'EXPECTED_PRODUCTS_SORT', 'desc', 'This is the sort order used in the expected products box.', '1', '8', 'zen_cfg_select_option(array(\'asc\', \'desc\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Expected Sort Field', 'EXPECTED_PRODUCTS_FIELD', 'date_expected', 'The column to sort by in the expected products box.', '1', '9', 'zen_cfg_select_option(array(\'products_name\', \'date_expected\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Switch To Default Language Currency', 'USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 'Automatically switch to the language\'s currency when it is changed', '1', '10', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Use Search-Engine Safe URLs (still in development)', 'SEARCH_ENGINE_FRIENDLY_URLS', 'false', 'Use search-engine safe urls for all site links', '6', '12', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Cart After Adding Product', 'DISPLAY_CART', 'true', 'Display the shopping cart after adding a product (or return back to their origin)', '1', '14', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Default Search Operator', 'ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 'Default search operators', '1', '17', 'zen_cfg_select_option(array(\'and\', \'or\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Store Address and Phone', 'STORE_NAME_ADDRESS', 'Store Name\nAddress\nCountry\nPhone', 'This is the Store Name, Address and Phone used on printable documents and displayed online', '1', '18', 'zen_cfg_textarea(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Category Counts', 'SHOW_COUNTS', 'true', 'Count recursively how many products are in each category', '1', '19', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Tax Decimal Places', 'TAX_DECIMAL_PLACES', '0', 'Pad the tax value this amount of decimal places', '1', '20', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Prices with Tax', 'DISPLAY_PRICE_WITH_TAX', 'false', 'Display prices with tax included (true) or add the tax at the end (false)', '1', '21', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Prices with Tax in Admin', 'DISPLAY_PRICE_WITH_TAX_ADMIN', 'false', 'Display prices with tax included (true) or add the tax at the end (false) in Admin(Invoices)', '1', '21', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Basis of Product Tax', 'STORE_PRODUCT_TAX_BASIS', 'Shipping', 'On what basis is Product Tax calculated. Options are<br />Shipping - Based on customers Shipping Address<br />Billing Based on customers Billing address<br />Store - Based on Store address if Billing/Shipping Zone equals Store zone', '1', '21', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Basis of Shipping Tax', 'STORE_SHIPPING_TAX_BASIS', 'Shipping', 'On what basis is Shipping Tax calculated. Options are<br />Shipping - Based on customers Shipping Address<br />Billing Based on customers Billing address<br />Store - Based on Store address if Billing/Shipping Zone equals Store zone - Can be overriden by correctly written Shipping Module', '1', '21', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Admin Session Time Out in Seconds', 'SESSION_TIMEOUT_ADMIN', '3600', 'Enter the time in seconds. Default=3600<br />Example: 3600= 1 hour<br /><br />Note: Too few seconds can result in timeout issues when adding/editing products', 1, 40, NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Admin Set max_execution_time for processes', 'GLOBAL_SET_TIME_LIMIT', '60', 'Enter the time in seconds for how long the max_execution_time of processes should be. Default=60<br />Example: 60= 1 minute<br /><br />Note: Changing the time limit is only needed if you are having problems with the execution time of a process', 1, 42, NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show if version update available', 'SHOW_VERSION_UPDATE_IN_HEADER', 'true', 'Automatically check to see if a new version of Zen-Cart is available. Enabling this can sometimes slow down the loading of Admin pages. (Displayed on main Index page after login, and Server Info page.)', 1, 44, 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Store Status', 'STORE_STATUS', '0', 'What is your Store Status<br />0= Normal Store<br />1= Showcase no prices<br />2= Showcase with prices', '1', '25', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Server Uptime', 'DISPLAY_SERVER_UPTIME', 'true', 'Displaying Server uptime can cause entries in error logs on some servers. (true = Display, false = don\'t display)', 1, 46, '2003-11-08 20:24:47', '0001-01-01 00:00:00', '', 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Missing Page Check', 'MISSING_PAGE_CHECK', 'true', 'Zen-Cart can check for missing pages in the URL and redirect to Index page. For debugging you may want to turn this off. (true = Check for missing pages, false = Don\'t check for missing pages)', 1, 48, '2003-11-08 20:24:47', '0001-01-01 00:00:00', '', 'zen_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('HTML Editor', 'HTML_EDITOR_PREFERENCE', 'NONE', 'Please select the HTML/Rich-Text editor you wish to use for composing Admin-related emails, newsletters, and product descriptions', '1', '110', 'zen_cfg_select_option(array(\'HTMLAREA\', \'NONE\'),', now());
#phpbb
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable phpBB linkage?', 'PHPBB_LINKS_ENABLED', 'false', 'Should Zen Cart synchronize new account information to your (already-installed) phpBB forum?', '1', '120', 'zen_cfg_select_option(array(\'true\', \'false\'),', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Category Counts - Admin', 'SHOW_COUNTS_ADMIN', 'true', 'Show Category Counts in Admin?', '1', '130', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('First Name', 'ENTRY_FIRST_NAME_MIN_LENGTH', '2', 'Minimum length of first name', '2', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Last Name', 'ENTRY_LAST_NAME_MIN_LENGTH', '2', 'Minimum length of last name', '2', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Date of Birth', 'ENTRY_DOB_MIN_LENGTH', '10', 'Minimum length of date of birth', '2', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('E-Mail Address', 'ENTRY_EMAIL_ADDRESS_MIN_LENGTH', '6', 'Minimum length of e-mail address', '2', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Street Address', 'ENTRY_STREET_ADDRESS_MIN_LENGTH', '5', 'Minimum length of street address', '2', '5', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Company', 'ENTRY_COMPANY_MIN_LENGTH', '2', 'Minimum length of company name', '2', '6', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Post Code', 'ENTRY_POSTCODE_MIN_LENGTH', '4', 'Minimum length of post code', '2', '7', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('City', 'ENTRY_CITY_MIN_LENGTH', '3', 'Minimum length of city', '2', '8', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('State', 'ENTRY_STATE_MIN_LENGTH', '2', 'Minimum length of state', '2', '9', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Telephone Number', 'ENTRY_TELEPHONE_MIN_LENGTH', '3', 'Minimum length of telephone number', '2', '10', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Password', 'ENTRY_PASSWORD_MIN_LENGTH', '5', 'Minimum length of password', '2', '11', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Credit Card Owner Name', 'CC_OWNER_MIN_LENGTH', '3', 'Minimum length of credit card owner name', '2', '12', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Credit Card Number', 'CC_NUMBER_MIN_LENGTH', '10', 'Minimum length of credit card number', '2', '13', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Credit Card CVV Number', 'CC_CVV_MIN_LENGTH', '3', 'Minimum length of credit card CVV number', '2', '13', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Product Review Text', 'REVIEW_TEXT_MIN_LENGTH', '50', 'Minimum length of product review text', '2', '14', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Best Sellers', 'MIN_DISPLAY_BESTSELLERS', '1', 'Minimum number of best sellers to display', '2', '15', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Also Purchased Products', 'MIN_DISPLAY_ALSO_PURCHASED', '1', 'Minimum number of products to display in the \'This Customer Also Purchased\' box', '2', '16', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Nick Name', 'ENTRY_NICK_MIN_LENGTH', '3', 'Minimum length of Nick Name', '2', '1', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Address Book Entries', 'MAX_ADDRESS_BOOK_ENTRIES', '5', 'Maximum address book entries a customer is allowed to have', '3', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Search Results Per Page', 'MAX_DISPLAY_SEARCH_RESULTS', '20', 'Number of products to list on a search result page', '3', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Prev/Next Navigation Page Links', 'MAX_DISPLAY_PAGE_LINKS', '5', 'Number of \'number\' links use for page-sets', '3', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Products on Special ', 'MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 'Number of products on special to display', '3', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('New Products Module', 'MAX_DISPLAY_NEW_PRODUCTS', '9', 'Number of new products to display in a category', '3', '5', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Upcoming Products ', 'MAX_DISPLAY_UPCOMING_PRODUCTS', '10', 'Number of \'upcoming\' products to display', '3', '6', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Manufacturers List - Scroll Box Size/Style', 'MAX_MANUFACTURERS_LIST', '3', 'Number of manufacturers names to be displayed in the scroll box window. Setting this to 1 or 0 will display a dropdown list.', '3', '7', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Manufacturers List - Verify Product Exist', 'PRODUCTS_MANUFACTURERS_STATUS', '1', 'Verify that at least 1 product exists and is active for the manufacturer name to show<br /><br />Note: When this feature is ON it can produce slower results on sites with a large number of products and/or manufacturers<br />0= off 1= on', 3, 7, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Music Genre List - Scroll Box Size/Style', 'MAX_MUSIC_GENRES_LIST', '3', 'Number of music genre names to be displayed in the scroll box window. Setting this to 1 or 0 will display a dropdown list.', '3', '7', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Record Company List - Scroll Box Size/Style', 'MAX_RECORD_COMPANY_LIST', '3', 'Number of record company names to be displayed in the scroll box window. Setting this to 1 or 0 will display a dropdown list.', '3', '7', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Length of Record Company Name', 'MAX_DISPLAY_RECORD_COMPANY_NAME_LEN', '15', 'Used in record companies box; maximum length of record company name to display. Longer names will be truncated.', '3', '8', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Length of Music Genre Name', 'MAX_DISPLAY_MUSIC_GENRES_NAME_LEN', '15', 'Used in music genres box; maximum length of music genre name to display. Longer names will be truncated.', '3', '8', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Length of Manufacturers Name', 'MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15', 'Used in manufacturers box; maximum length of manufacturers name to display. Longer names will be truncated.', '3', '8', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('New Product Reviews Per Page', 'MAX_DISPLAY_NEW_REVIEWS', '6', 'Number of new reviews to display on each page', '3', '9', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Random Product Reviews For Box', 'MAX_RANDOM_SELECT_REVIEWS', '10', 'Number of random product reviews to rotate in the box', '3', '10', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Random New Products For Box', 'MAX_RANDOM_SELECT_NEW', '10', 'Number of random new product to display in box', '3', '11', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Random Products On Special For Box', 'MAX_RANDOM_SELECT_SPECIALS', '10', 'Number of random products on special to display in box', '3', '12', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Categories To List Per Row', 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3', 'How many categories to list per row', '3', '13', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('New Products Listing- Number Per Page', 'MAX_DISPLAY_PRODUCTS_NEW', '10', 'Number of new products\' listings per page', '3', '14', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Best Sellers For Box', 'MAX_DISPLAY_BESTSELLERS', '10', 'Number of best sellers to display in box', '3', '15', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Also Purchased Products', 'MAX_DISPLAY_ALSO_PURCHASED', '6', 'Number of products to display in the \'This Customer Also Purchased\' box', '3', '16', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Recent Purchases Box- NOTE: box is disabled ', 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6', 'Number of products to display in the recent purchases box', '3', '17', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Customer Order History List Per Page', 'MAX_DISPLAY_ORDER_HISTORY', '10', 'Number of orders to display in the order history list in \'My Account\'', '3', '18', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Display of Customers on Customers Page', 'MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER', '20', '', 3, 19, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Display of Orders on Orders Page', 'MAX_DISPLAY_SEARCH_RESULTS_ORDERS', '20', '', 3, 20, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Display of Products on Reports', 'MAX_DISPLAY_SEARCH_RESULTS_REPORTS', '20', '', 3, 21, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Categories Products Display List', 'MAX_DISPLAY_RESULTS_CATEGORIES', '10', 'Number of products to list per screen', 3, 22, now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Products Listing- Number Per Page', 'MAX_DISPLAY_PRODUCTS_LISTING', '10', 'Maximum Number of Products to list per page on main page', '3', '30', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Products Attributes - Option Names and Values Display', 'MAX_ROW_LISTS_OPTIONS', '10', 'Maximum number of option names and values to display in the products attributes page', '3', '24', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Products Attributes - Attributes Controller Display', 'MAX_ROW_LISTS_ATTRIBUTES_CONTROLLER', '30', 'Maximum number of attributes to display in the Attributes Controller page', '3', '25', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Products Attributes - Downloads Manager Display', 'MAX_DISPLAY_SEARCH_RESULTS_DOWNLOADS_MANAGER', '30', 'Maximum number of attributes downloads to display in the Downloads Manager page', '3', '26', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Featured Products - Number to Display Admin', 'MAX_DISPLAY_SEARCH_RESULTS_FEATURED_ADMIN', '10', 'Number of featured products to list per screen - Admin', 3, 27, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Display of Featured Products - Main Page', 'MAX_DISPLAY_SEARCH_RESULTS_FEATURED', '9', 'Number of featured products to list on main page', 3, 28, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Display of Featured Products Page', 'MAX_DISPLAY_PRODUCTS_FEATURED_PRODUCTS', '10', 'Number of featured products to list per screen', 3, 29, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Random Featured Products For Box', 'MAX_RANDOM_SELECT_FEATURED_PRODUCTS', '10', 'Number of random featured products to display in box', '3', '30', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Display of Specials Products - Main Page', 'MAX_DISPLAY_SPECIAL_PRODUCTS_INDEX', '9', 'Number of special products to list on main page', 3, 31, now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('New Product Listing - Limited to ...', 'SHOW_NEW_PRODUCTS_LIMIT', '0', 'Limit the New Product Listing to<br />0= All desc<br />1= Current Month<br />30= 30 Days<br />60= 60 Days<br />90= 90 Days<br />120= 120 Days', '3', '40', 'zen_cfg_select_option(array(\'0\', \'1\', \'30\', \'60\', \'90\', \'120\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Display of Products All Page', 'MAX_DISPLAY_PRODUCTS_ALL', '10', 'Number of products to list per screen', 3, 45, now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum Display of Language Flags in Language Side Box', 'MAX_LANGUAGE_FLAGS_COLUMNS', '3', 'Number of Language Flags per Row', 3, 50, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Maximum File Upload Size', 'MAX_FILE_UPLOAD_SIZE', '2048000', 'What is the Maximum file size for uploads?<br />Default= 2048000', 3, 60, now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Small Image Width', 'SMALL_IMAGE_WIDTH', '100', 'The pixel width of small images', '4', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Small Image Height', 'SMALL_IMAGE_HEIGHT', '80', 'The pixel height of small images', '4', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Heading Image Width', 'HEADING_IMAGE_WIDTH', '57', 'The pixel width of heading images', '4', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Heading Image Height', 'HEADING_IMAGE_HEIGHT', '40', 'The pixel height of heading images', '4', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Subcategory Image Width', 'SUBCATEGORY_IMAGE_WIDTH', '100', 'The pixel width of subcategory images', '4', '5', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Subcategory Image Height', 'SUBCATEGORY_IMAGE_HEIGHT', '57', 'The pixel height of subcategory images', '4', '6', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Calculate Image Size', 'CONFIG_CALCULATE_IMAGE_SIZE', 'true', 'Calculate the size of images?', '4', '7', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Image Required', 'IMAGE_REQUIRED', 'true', 'Enable to display broken images. Good for development.', '4', '8', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Image - Shopping Cart Status', 'IMAGE_SHOPPING_CART_STATUS', '1', 'Show product image in the shopping cart?<br />0= off 1= on', 4, 9, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Shopping Cart Width', 'IMAGE_SHOPPING_CART_WIDTH', '50', 'Default = 50', 4, 10, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Shopping Cart Height', 'IMAGE_SHOPPING_CART_HEIGHT', '40', 'Default = 40', 4, 11, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Product Info - Image Width', 'MEDIUM_IMAGE_WIDTH', '150', 'The pixel width of Product Info images', '4', '20', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Product Info - Image Height', 'MEDIUM_IMAGE_HEIGHT', '120', 'The pixel height of Product Info images', '4', '21', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Product Info - Image Medium Suffix', 'IMAGE_SUFFIX_MEDIUM', '_MED', 'Product Info Medium Image Suffix<br />Default = _MED', '4', '22', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Product Info - Image Large Suffix', 'IMAGE_SUFFIX_LARGE', '_LRG', 'Product Info Large Image Suffix<br />Default = _LRG', '4', '23', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Product Info - Number of Additional Images per Row', 'IMAGES_AUTO_ADDED', '3', 'Product Info - Enter the number of additional images to display per row<br />Default = 3', '4', '30', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Product Listing Width', 'IMAGE_PRODUCT_LISTING_WIDTH', '100', 'Default = 100', 4, 40, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Product Listing Height', 'IMAGE_PRODUCT_LISTING_HEIGHT', '80', 'Default = 80', 4, 41, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Product New Listing Width', 'IMAGE_PRODUCT_NEW_LISTING_WIDTH', '100', 'Default = 100', 4, 42, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Product New Listing Height', 'IMAGE_PRODUCT_NEW_LISTING_HEIGHT', '80', 'Default = 80', 4, 43, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - New Products Width', 'IMAGE_PRODUCT_NEW_WIDTH', '100', 'Default = 100', 4, 44, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - New Products Height', 'IMAGE_PRODUCT_NEW_HEIGHT', '80', 'Default = 80', 4, 45, now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Featured Products Width', 'IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH', '100', 'Default = 100', 4, 46, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Featured Products Height', 'IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT', '80', 'Default = 80', 4, 47, now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Product All Listing Width', 'IMAGE_PRODUCT_ALL_LISTING_WIDTH', '100', 'Default = 100', 4, 48, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Image - Product All Listing Height', 'IMAGE_PRODUCT_ALL_LISTING_HEIGHT', '80', 'Default = 80', 4, 49, now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Image - No Image Status', 'PRODUCTS_IMAGE_NO_IMAGE_STATUS', '1', 'Use automatic No Image when none is added to product<br />0= off<br />1= On', '4', '60', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Product Image - No Image picture', 'PRODUCTS_IMAGE_NO_IMAGE', 'no_picture.gif', 'Use automatic No Image when none is added to product<br />Default = no_picture.gif', '4', '61', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Image - Use Proportional Images on Products and Categories', 'PROPORTIONAL_IMAGES_STATUS', '1', 'Use Proportional Images on Products and Categories?<br /><br />NOTE: Do not use 0 height or width settings for Proportion Images<br />0= off 1= on', 4, 75, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Email Salutation', 'ACCOUNT_GENDER', 'true', 'Display salutation choice during account creation and with account information', '5', '1', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Date of Birth', 'ACCOUNT_DOB', 'true', 'Display date of birth field during account creation and with account information', '5', '2', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Company', 'ACCOUNT_COMPANY', 'true', 'Display company field during account creation and with account information', '5', '3', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Address Line 2', 'ACCOUNT_SUBURB', 'true', 'Display address line 2 field during account creation and with account information', '5', '4', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('State', 'ACCOUNT_STATE', 'true', 'Display state field during account creation and with account information', '5', '5', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Create Account Default Country ID', 'SHOW_CREATE_ACCOUNT_DEFAULT_COUNTRY', '223', 'Set Create Account Default Country ID to:<br />Default is 223', '5', '6', 'zen_get_country_name', 'zen_cfg_pull_down_country_list_none(', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Newsletter Checkbox', 'ACCOUNT_NEWSLETTER_STATUS', '1', 'Show Newsletter Checkbox<br />0= off<br />1= Display Unchecked<br />2= Display Checked<br /><strong>Note: Defaulting this to accepted may be in violation of certain regulations for your state or country</strong>', 5, 45, 'zen_cfg_select_option(array(\'0\', \'1\', \'2\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Customer Default Email Preference', 'ACCOUNT_EMAIL_PREFERENCE', '0', 'Set the Default Customer Default Email Preference<br />0= Text<br />1= HTML<br /><strong>Note: Defaulting this to accepted may be in violation of certain regulations for your state or country</strong>', 5, 46, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Customer Product Notification Status', 'CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS', '1', 'Customer should be asked about product notifications after checkout success<br />0= Never ask<br />1= Ask, unless already set to global<br /><br />Note: Sidebox must be turned off separately', '5', '50', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Customer Shop Status - View Shop and Prices', 'CUSTOMERS_APPROVAL', '0', 'Customer must be approved to shop<br />0= Not required<br />1= Must login to browse<br />2= May browse but no prices unless logged in<br />3= Showroom Only<br /><br />It is recommended that Option 2 be used for the purposes of Spiders if you wish customers to login to see prices.', '5', '55', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\'), ', now());

#customer approval to shop
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Customer Approval Status - Authorization Pending', 'CUSTOMERS_APPROVAL_AUTHORIZATION', '0', 'Customer must be Authorized to shop<br />0= Not required<br />1= Must be Authorized to Browse<br />2= May browse but no prices unless Authorized<br /><br />It is recommended that Option 2 be used for the purposes of Spiders', '5', '65', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Customer Authorization: filename', 'CUSTOMERS_AUTHORIZATION_FILENAME', 'customers_authorization', 'Customer Authorization filename<br />Note: Do not include the extention<br />Default=customers_authorization', '5', '66', '', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Customer Authorization: Hide Header', 'CUSTOMERS_AUTHORIZATION_HEADER_OFF', 'false', 'Customer Authorization: Hide Header <br />(true=hide false=show)', '5', '67', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Customer Authorization: Hide Column Left', 'CUSTOMERS_AUTHORIZATION_COLUMN_LEFT_OFF', 'false', 'Customer Authorization: Hide Column Left <br />(true=hide false=show)', '5', '68', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Customer Authorization: Hide Column Right', 'CUSTOMERS_AUTHORIZATION_COLUMN_RIGHT_OFF', 'false', 'Customer Authorization: Hide Column Right <br />(true=hide false=show)', '5', '69', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Customer Authorization: Hide Footer', 'CUSTOMERS_AUTHORIZATION_FOOTER_OFF', 'false', 'Customer Authorization: Hide Footer <br />(true=hide false=show)', '5', '70', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Customer Authorization: Hide Prices', 'CUSTOMERS_AUTHORIZATION_PRICES_OFF', 'false', 'Customer Authorization: Hide Prices <br />(true=hide false=show)', '5', '71', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Customers Referral Status', 'CUSTOMERS_REFERRAL_STATUS', '0', 'Customers Referral Code is created from<br />0= Off<br />1= 1st Discount Coupon Code used<br />2= Customer can add during create account or edit if blank<br /><br />NOTE: Once the Customers Referral Code has been set it can only be changed in the Admin Customer', '5', '80', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Installed Modules', 'MODULE_PAYMENT_INSTALLED', 'cc.php;cod.php', 'List of payment module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: cc.php;cod.php;paypal.php)', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Installed Modules', 'MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_gv.php;ot_coupon.php;ot_total.php', 'List of order_total module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Installed Modules', 'MODULE_SHIPPING_INSTALLED', 'flat.php', 'List of shipping module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ups.php;flat.php;item.php)', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Cash On Delivery Module', 'MODULE_PAYMENT_COD_STATUS', 'True', 'Do you want to accept Cash On Delevery payments?', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Payment Zone', 'MODULE_PAYMENT_COD_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Sort order of display.', 'MODULE_PAYMENT_COD_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('Set Order Status', 'MODULE_PAYMENT_COD_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Credit Card Module', 'MODULE_PAYMENT_CC_STATUS', 'True', 'Do you want to accept credit card payments?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Split Credit Card E-Mail Address', 'MODULE_PAYMENT_CC_EMAIL', '', 'If an e-mail address is entered, the middle digits of the credit card number will be sent to the e-mail address (the outside digits are stored in the database with the middle digits censored)', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Collect & store the CVV number', 'MODULE_PAYMENT_CC_COLLECT_CVV', 'True', 'Do you want to collect the CVV number. Note: If you do the CVV number will be stored in the database in an encoded format.', 6, 0, NULL, '2004-01-11 22:55:51', NULL, 'zen_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Store the Credit Card Number', 'MODULE_PAYMENT_CC_STORE_NUMBER', 'False', 'Do you want to store the Credit Card Number. Note: The Credit Card Number will be stored unenecrypted, and as such may represent a security problem', 6, 0, NULL, now(), NULL, 'zen_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Sort order of display.', 'MODULE_PAYMENT_CC_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0' , now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Payment Zone', 'MODULE_PAYMENT_CC_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('Set Order Status', 'MODULE_PAYMENT_CC_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Flat Shipping', 'MODULE_SHIPPING_FLAT_STATUS', 'True', 'Do you want to offer flat rate shipping?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Shipping Cost', 'MODULE_SHIPPING_FLAT_COST', '5.00', 'The shipping cost for all orders using this shipping method.', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Tax Class', 'MODULE_SHIPPING_FLAT_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Tax Basis', 'MODULE_SHIPPING_FLAT_TAX_BASIS', 'Shipping', 'On what basis is Shipping Tax calculated. Options are<br />Shipping - Based on customers Shipping Address<br />Billing Based on customers Billing address<br />Store - Based on Store address if Billing/Shipping Zone equals Store zone', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Shipping Zone', 'MODULE_SHIPPING_FLAT_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Sort Order', 'MODULE_SHIPPING_FLAT_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Currency', 'DEFAULT_CURRENCY', 'USD', 'Default Currency', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Language', 'DEFAULT_LANGUAGE', 'en', 'Default Language', '6', '0', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Order Status For New Orders', 'DEFAULT_ORDERS_STATUS_ID', '1', 'When a new order is created, this order status will be assigned to it.', '6', '0', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Admin configuration_key shows', 'ADMIN_CONFIGURATION_KEY_ON', '0', 'Manually switch to value of 1 to see the configuration_key name in configuration displays', '6', '0', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Country of Origin', 'SHIPPING_ORIGIN_COUNTRY', '223', 'Select the country of origin to be used in shipping quotes.', '7', '1', 'zen_get_country_name', 'zen_cfg_pull_down_country_list(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Postal Code', 'SHIPPING_ORIGIN_ZIP', 'NONE', 'Enter the Postal Code (ZIP) of the Store to be used in shipping quotes.', '7', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Enter the Maximum Package Weight you will ship', 'SHIPPING_MAX_WEIGHT', '50', 'Carriers have a max weight limit for a single package. This is a common one for all.', '7', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Package Tare Small to Medium - added percentage:weight', 'SHIPPING_BOX_WEIGHT', '0:3', 'What is the weight of typical packaging of small to medium packages?<br />Example: 10% + 1lb 10:1<br />10% + 0lbs 10:0<br />0% + 5lbs 0:5<br />0% + 0lbs 0:0', '7', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Larger packages - added packaging percentage:weight', 'SHIPPING_BOX_PADDING', '10:0', 'What is the weight of typical packaging for Large packages?<br />Example: 10% + 1lb 10:1<br />10% + 0lbs 10:0<br />0% + 5lbs 0:5<br />0% + 0lbs 0:0', '7', '5', now());

# moved to product_types
#INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Virtual Default Status - Skip Shipping Address', 'PRODUCTS_VIRTUAL_DEFAULT', '0', 'What should the Default Virtual Product status be when adding new products?<br /><br />0= Virtual Product Defaults to OFF<br />1= Virtual Product Defaults to ON<br />NOTE: Virtual Products do not require a Shipping Address', '7', '10', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
#INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Default Status - Normal Shipping Rules', 'PRODUCTS_IS_ALWAYS_FREE_SHIPPING_DEFAULT', '0', 'What should the Default Free Shipping status be when adding new products?<br /><br />0= Free Shipping Defaults to OFF<br />1= Free Shipping Defaults to ON<br />NOTE: Free Shipping Products require a Shipping Address', '7', '11', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Number of Boxes and Weight Status', 'SHIPPING_BOX_WEIGHT_DISPLAY', '3', 'Display Shipping Weight and Number of Boxes?<br /><br />0= off<br />1= Boxes Only<br />2= Weight Only<br />3= Both Boxes and Weight', '7', '15', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Shipping Estimator Display Settings for Shopping Cart', 'SHOW_SHIPPING_ESTIMATOR_BUTTON', '1', '<br />0= Off<br />1= Display as Button on Shopping Cart', '7', '20', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Order Free Shipping 0 Weight Status', 'ORDER_WEIGHT_ZERO_STATUS', '0', 'If there is no weight to the order, does the order have Free Shipping?<br />0= no<br />1= yes<br /><br />Note: When using Free Shipping, Enable the Free Shipping Module this will only show when shipping is free.', '7', '15', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Image', 'PRODUCT_LIST_IMAGE', '1', 'Do you want to display the Product Image?', '8', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Manufacturer Name','PRODUCT_LIST_MANUFACTURER', '0', 'Do you want to display the Product Manufacturer Name?', '8', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Model', 'PRODUCT_LIST_MODEL', '0', 'Do you want to display the Product Model?', '8', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Name', 'PRODUCT_LIST_NAME', '2', 'Do you want to display the Product Name?', '8', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Price/Add to Cart', 'PRODUCT_LIST_PRICE', '3', 'Do you want to display the Product Price/Add to Cart', '8', '5', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Quantity', 'PRODUCT_LIST_QUANTITY', '0', 'Do you want to display the Product Quantity?', '8', '6', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Weight', 'PRODUCT_LIST_WEIGHT', '0', 'Do you want to display the Product Weight?', '8', '7', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Price/Add to Cart Column Width', 'PRODUCTS_LIST_PRICE_WIDTH', '125', 'Define the width of the Price/Add to Cart column<br />Default= 125', '8', '8', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Category/Manufacturer Filter (0=off; 1=on)', 'PRODUCT_LIST_FILTER', '1', 'Do you want to display the Category/Manufacturer Filter?', '8', '9', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Prev/Next Split Page Navigation (1-top, 2-bottom, 3-both)', 'PREV_NEXT_BAR_LOCATION', '3', 'Sets the location of the Prev/Next Split Page Navigation', '8', '10', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Listing Default Sort Order', 'PRODUCT_LISTING_DEFAULT_SORT_ORDER', '', 'Product Listing Default sort order?<br />NOTE: Leave Blank for Product Sort Order. Sort the Product Listing in the order you wish for the default display to start in to get the sort order setting. Example: 2a', '8', '15', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Product Add to Cart Button (0=off; 1=on)', 'PRODUCT_LIST_PRICE_BUY_NOW', '1', 'Do you want to display the Add to Cart Button?', '8', '20', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());


INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Check stock level', 'STOCK_CHECK', 'true', 'Check to see if sufficent stock is available', '9', '1', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Subtract stock', 'STOCK_LIMITED', 'true', 'Subtract product in stock by product orders', '9', '2', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Allow Checkout', 'STOCK_ALLOW_CHECKOUT', 'true', 'Allow customer to checkout even if there is insufficient stock', '9', '3', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Mark product out of stock', 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***', 'Display something on screen so customer can see which product has insufficient stock', '9', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Stock Re-order level', 'STOCK_REORDER_LEVEL', '5', 'Define when stock needs to be re-ordered', '9', '5', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Products status in Catalog when out of stock should be set to', 'SHOW_PRODUCTS_SOLD_OUT', '0', 'Show Products when out of stock<br /><br />0= set product status to OFF<br />1= leave product status ON', '9', '10', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Sold Out Image in place of Add to Cart', 'SHOW_PRODUCTS_SOLD_OUT_IMAGE', '1', 'Show Sold Out Image instead of Add to Cart Button<br /><br />0= off<br />1= on', '9', '11', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Quantity Decimals', 'QUANTITY_DECIMALS', '0', 'Allow how many decimals on Quantity<br /><br />0= off', '9', '15', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Shopping Cart - Delete Checkboxes or Delete Button', 'SHOW_SHOPPING_CART_DELETE', '3', 'Show on Shopping Cart Delete Button and/or Checkboxes<br /><br />1= Delete Button Only<br />2= Checkbox Only<br />3= Delete Button and Checkbox Only', '9', '20', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Shopping Cart - Update Cart Button Location', 'SHOW_SHOPPING_CART_UPDATE', '3', 'Show on Shopping Cart Update Cart Button Location as:<br /><br />1= Next to each Qty Box<br />2= Below all Products<br />3= Both Next to each Qty Box and Below all Products<br /><br />Note: this setting controls which of 3 tpl_shopping_cart_default files are called', '9', '22', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Store Page Parse Time', 'STORE_PAGE_PARSE_TIME', 'false', 'Store the time it takes to parse a page', '10', '1', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Log Destination', 'STORE_PAGE_PARSE_TIME_LOG', '/var/log/www/zen/page_parse_time.log', 'Directory and filename of the page parse time log', '10', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Log Date Format', 'STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S', 'The date format', '10', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display The Page Parse Time', 'DISPLAY_PAGE_PARSE_TIME', 'true', 'Display the page parse time on the bottom of each page<br />You do not need to store the times to display them in the Catalog', '10', '4', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Store Database Queries', 'STORE_DB_TRANSACTIONS', 'false', 'Store the database queries in the page parse time log (PHP4 only)', '10', '5', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('E-Mail Transport Method', 'EMAIL_TRANSPORT', 'sendmail', 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.<br /><br />SMTPAUTH should only be used if your server requires SMTP authorization to send messages. You must also configure your SMTPAUTH settings in the appropriate fields in this admin section.<br /><br />"Sendmail -f" is only for servers which require the use of the -f parameter to send mail. This is a security setting often used to prevent spoofing. Will cause errors if your host mailserver is not configured to use it.', '12', '1', 'zen_cfg_select_option(array(\'sendmail\', \'sendmail-f\', \'smtp\', \'smtpauth\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('SMTP Email Sending Domain', 'EMAIL_SMTPAUTH_SEND_DOMAIN', 'YourDomain.com', 'Enter the domain name of your shop. In most cases this is the same as your store URL without the HTTP://<br />Only required if using SMTP Authentication for email.', '12', '101', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('SMTP Email Account Mailbox', 'EMAIL_SMTPAUTH_MAILBOX', 'YourDomain.com', 'Enter the mailbox account name (me@mydomain.com) supplied by your host. This is the account name that your host requires for SMTP authentication.<br />Only required if using SMTP Authentication for email.', '12', '101', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('SMTP Email Account Password', 'EMAIL_SMTPAUTH_PASSWORD', 'YourDomain.com', 'Enter the password for your SMTP mailbox. <br />Only required if using SMTP Authentication for email.', '12', '101', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('SMTP Email Mail Host', 'EMAIL_SMTPAUTH_MAIL_SERVER', 'YourDomain.com', 'Enter the DNS name of your SMTP mail server.<br />ie: mail.mydomain.com<br />or 55.66.77.88<br />Only required if using SMTP Authentication for email.', '12', '101', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('E-Mail Linefeeds', 'EMAIL_LINEFEED', 'LF', 'Defines the character sequence used to separate mail headers.', '12', '2', 'zen_cfg_select_option(array(\'LF\', \'CRLF\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Use MIME HTML When Sending Emails', 'EMAIL_USE_HTML', 'false', 'Send e-mails in HTML format', '12', '3', 'zen_cfg_select_option(array(\'true\', \'false\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Verify E-Mail Addresses Through DNS', 'ENTRY_EMAIL_ADDRESS_CHECK', 'false', 'Verify e-mail address through a DNS server', '12', '4', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Send E-Mails', 'SEND_EMAILS', 'true', 'Send out e-mails', '12', '5', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Email Archiving Active?', 'EMAIL_ARCHIVE', 'false', 'If you wish to have email messages archived/stored when sent, set this to "true".', '12', '6', 'zen_cfg_select_option(array(\'true\', \'false\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('E-Mail Friendly-Errors', 'EMAIL_FRIENDLY_ERRORS', 'true', 'Do you want to display friendly errors if emails fail?  Setting this to false will display PHP errors and likely cause the script to fail. Only set to false while troubleshooting.', '12', '7', 'zen_cfg_select_option(array(\'true\', \'false\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Email Address (Displayed to Contact you)', 'STORE_OWNER_EMAIL_ADDRESS', 'root@localhost', 'Email address of Store Owner.  Used as "display only" when informing customers of how to contact you.', '12', '10', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Email Address (sent FROM)', 'EMAIL_FROM', 'Zen Cart <root@localhost>', 'Address from which email messages will be "sent" by default. Can be over-ridden at compose-time in admin modules.', '12', '11', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function) VALUES ('Email Admin Format?', 'ADMIN_EXTRA_EMAIL_FORMAT', 'TEXT', 'Please select the Admin extra email format', 12, 12, NULL, 'zen_cfg_select_option(array(\'TEXT\', \'HTML\'), ');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Copy of Order Confirmation Emails To', 'SEND_EXTRA_ORDER_EMAILS_TO', '', 'Send COPIES of order confirmation emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '12', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Send Copy of Create Account Emails To - Status', 'SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_STATUS', '0', 'Send copy of Create Account Status<br />0= off 1= on', '12', '13', 'zen_cfg_select_option(array(\'0\', \'1\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Copy of Create Account Emails To', 'SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO', '', 'Send copy of Create Account emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '14', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Send Copy of Tell a Friend Emails To - Status', 'SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_STATUS', '0', 'Send copy of Tell a Friend Status<br />0= off 1= on', '12', '15', 'zen_cfg_select_option(array(\'0\', \'1\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Copy of Tell a Friend Emails To', 'SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO', '', 'Send copy of Tell a Friend emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '16', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Send Copy of Customer GV Send Emails To - Status', 'SEND_EXTRA_GV_CUSTOMER_EMAILS_TO_STATUS', '0', 'Send copy of Customer GV Send Status<br />0= off 1= on', '12', '17', 'zen_cfg_select_option(array(\'0\', \'1\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Copy of Customer GV Send Emails To', 'SEND_EXTRA_GV_CUSTOMER_EMAILS_TO', '', 'Send copy of Customer GV Send emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '18', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Send Copy of Admin GV Mail Emails To - Status', 'SEND_EXTRA_GV_ADMIN_EMAILS_TO_STATUS', '0', 'Send copy of Admin GV Mail Status<br />0= off 1= on', '12', '19', 'zen_cfg_select_option(array(\'0\', \'1\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Copy of Customer Admin GV Mail Emails To', 'SEND_EXTRA_GV_ADMIN_EMAILS_TO', '', 'Send copy of Admin GV Mail emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '20', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Send Copy of Admin Discount Coupon Mail Emails To - Status', 'SEND_EXTRA_DISCOUNT_COUPON_ADMIN_EMAILS_TO_STATUS', '0', 'Send copy of Admin Discount Coupon Mail Status<br />0= off 1= on', '12', '21', 'zen_cfg_select_option(array(\'0\', \'1\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Copy of Customer Admin Discount Coupon Mail Emails To', 'SEND_EXTRA_DISCOUNT_COUPON_ADMIN_EMAILS_TO', '', 'Send copy of Admin Discount Coupon Mail emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '22', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Send Copy of Admin Orders Status Emails To - Status', 'SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_STATUS', '0', 'Send copy of Admin Orders Status Status<br />0= off 1= on', '12', '23', 'zen_cfg_select_option(array(\'0\', \'1\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Copy of Admin Orders Status Emails To', 'SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO', '', 'Send copy of Admin Orders Status emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '24', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Set "Contact Us" Email Dropdown List', 'CONTACT_US_LIST', '', 'On the "Contact Us" Page, set the list of email addresses , in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '40', 'zen_cfg_textarea(', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Allow Guest To Tell A Friend', 'ALLOW_GUEST_TO_TELL_A_FRIEND', 'true', 'Allow guests to tell a friend about a product', '12', '50', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Contact Us - Show Store Name and Address', 'CONTACT_US_STORE_NAME_ADDRESS', '1', 'Include Store Name and Address<br />0= off 1= on', '12', '50', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Send Extra Low Stock Emails', 'SEND_LOWSTOCK_EMAIL', '0', 'When stock level is at or below low stock level send an email<br />0= off<br />1= on', '12', '60', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Send Extra Low Stock Emails To', 'SEND_EXTRA_LOW_STOCK_EMAILS_TO', '', 'When stock level is at or below low stock level send an email to this address, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '12', '61', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display "Newsletter Unsubscribe" Link?', 'SHOW_NEWSLETTER_UNSUBSCRIBE_LINK', 'true', 'Show "Newsletter Unsubscribe" link in the "Information" side-box?', '12', '70', 'zen_cfg_select_option(array(\'true\', \'false\'),', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Audience-Select Count Display', 'AUDIENCE_SELECT_DISPLAY_COUNTS', 'true', 'When displaying lists of available audiences/recipients, should the recipients-count be included? <br /><em>(This may make things slower if you have a lot of customers or complex audience queries)</em>', '12', '90', 'zen_cfg_select_option(array(\'true\', \'false\'),', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('New Signup Discount Coupon ID#', 'NEW_SIGNUP_DISCOUNT_COUPON', '', 'Select the coupon<br />', 16, 75, NULL, now(), NULL, 'zen_cfg_select_coupon_id(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('New Signup Gift Voucher Amount', 'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '', 'Leave blank for none<br />Or enter an amount ie. 10 for $10.00', 16, 76, NULL, now(), NULL, NULL);


INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Downloads', 'DOWNLOAD_ENABLED', 'false', 'Enable the products download functions.', '13', '1', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Download by Redirect', 'DOWNLOAD_BY_REDIRECT', 'true', 'Use browser redirection for download. Disable on non-Unix systems.<br /><br />Note: Set /pub to 777 when redirect is true', '13', '2', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Download Expiration- Number of Days)' ,'DOWNLOAD_MAX_DAYS', '7', 'Set number of days before the download link expires. 0 means no limit.', '13', '3', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Number of Downloads Allowed - Per Product' ,'DOWNLOAD_MAX_COUNT', '5', 'Set the maximum number of downloads. 0 means no download authorized.', '13', '4', '', now());

INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Downloads Controller Update Status Value', 'DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE', '4', 'What orders_status resets the Download days and Max Downloads - Default is 4', '13', '10', now(), '', NULL , NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Downloads Controller Order Status Value >= lower value', 'DOWNLOADS_CONTROLLER_ORDERS_STATUS', '2', 'Downloads Controller Order Status Value - Default >= 2<br /><br />Downloads are available for checkout based on the orders status. Orders with orders status greater than this value will be available for download. The orders status is set for an order by the Payment Modules. Set the lower range for this range.', '13', '12', now(), '', NULL , NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Downloads Controller Order Status Value <= upper value', 'DOWNLOADS_CONTROLLER_ORDERS_STATUS_END', '4', 'Downloads Controller Order Status Value - Default <= 4<br /><br />Downloads are available for checkout based on the orders status. Orders with orders status less than this value will be available for download. The orders status is set for an order by the Payment Modules.  Set the upper range for this range.', '13', '13', now(), '', NULL , NULL);

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Price Factor', 'ATTRIBUTES_ENABLED_PRICE_FACTOR', 'true', 'Enable the Attributes Price Factor.', '13', '25', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Qty Price Discount', 'ATTRIBUTES_ENABLED_QTY_PRICES', 'true', 'Enable the Attributes Quantity Price Discounts.', '13', '26', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Attribute Images', 'ATTRIBUTES_ENABLED_IMAGES', 'true', 'Enable the Attributes Images.', '13', '28', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Text Pricing by word or letter', 'ATTRIBUTES_ENABLED_TEXT_PRICES', 'true', 'Enable the Attributes Text Pricing by word or letter.', '13', '35', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Text Pricing - Spaces are Free', 'TEXT_SPACES_FREE', '1', 'On Text pricing Spaces are Free<br /><br />0= off 1= on', '13', '36', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Read Only option type - Ignore for Add to Cart', 'PRODUCTS_OPTIONS_TYPE_READONLY_IGNORED', '1', 'When a Product only uses READONLY attributes, should the Add to Cart button be On or Off?<br />0= OFF<br />1= ON', '13', '37', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());



INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable GZip Compression', 'GZIP_LEVEL', '0', '0= off 1= on', '14', '1', 'zen_cfg_select_option(array(\'0\', \'1\'),', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Session Directory', 'SESSION_WRITE_DIRECTORY', '/tmp', 'If sessions are file based, store them in this directory.', '15', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Cookie Domain', 'SESSION_USE_FQDN', 'True', 'If True the full domain name will be used to store the cookie, e.g. www.mydomain.com. If False only a partial domain name will be used, e.g. mydomain.com. If you are unsure about this, always leave set to true.', '15', '2', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Force Cookie Use', 'SESSION_FORCE_COOKIE_USE', 'False', 'Force the use of sessions when cookies are only enabled.', '15', '2', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Check SSL Session ID', 'SESSION_CHECK_SSL_SESSION_ID', 'False', 'Validate the SSL_SESSION_ID on every secure HTTPS page request.', '15', '3', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Check User Agent', 'SESSION_CHECK_USER_AGENT', 'False', 'Validate the clients browser user agent on every page request.', '15', '4', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Check IP Address', 'SESSION_CHECK_IP_ADDRESS', 'False', 'Validate the clients IP address on every page request.', '15', '5', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Prevent Spider Sessions', 'SESSION_BLOCK_SPIDERS', 'True', 'Prevent known spiders from starting a session.', '15', '6', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Recreate Session', 'SESSION_RECREATE', 'False', 'Recreate the session to generate a new session ID when the customer logs on or creates an account (PHP >=4.1 needed).', '15', '7', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Length of the redeem code', 'SECURITY_CODE_LENGTH', '10', 'Enter the length of the redeem code<br />The longer the more secure', 16, 1, NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('Default Order Status For Zero Balance Orders', 'DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID', '2', 'When an order\'s balance is zero, this order status will be assigned to it.', '16', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Credit Card Enable Status - VISA', 'CC_ENABLED_VISA', '1', 'Accept VISA 0= off 1= on', '17', '1', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Credit Card Enable Status - MasterCard', 'CC_ENABLED_MC', '1', 'Accept MasterCard 0= off 1= on', '17', '2', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Credit Card Enable Status - AmericanExpress', 'CC_ENABLED_AMEX', '0', 'Accept AmericanExpress 0= off 1= on', '17', '3', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Credit Card Enable Status - Diners Club', 'CC_ENABLED_DINERS_CLUB', '0', 'Accept Diners Club 0= off 1= on', '17', '4', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Credit Card Enable Status - Discover Card', 'CC_ENABLED_DISCOVER', '0', 'Accept Discover Card 0= off 1= on', '17', '5', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Credit Card Enable Status - JCB', 'CC_ENABLED_JCB', '0', 'Accept JCB 0= off 1= on', '17', '6', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Credit Card Enable Status - AUSTRALIAN BANKCARD', 'CC_ENABLED_AUSTRALIAN_BANKCARD', '0', 'Accept AUSTRALIAN BANKCARD 0= off 1= on', '17', '7', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Credit Card Enabled - Show on Payment', 'SHOW_ACCEPTED_CREDIT_CARDS', '0', 'Show accepted credit cards on Payment page?<br />0= off<br />1= As Text<br />2= As Images<br /><br />Note: images and text must be defined in both the database and language file for specific credit card types.', '17', '50', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('This module is installed', 'MODULE_ORDER_TOTAL_GV_STATUS', 'true', '', 6, 1, NULL, '2003-10-30 22:16:40', NULL, 'zen_cfg_select_option(array(\'true\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Sort Order', 'MODULE_ORDER_TOTAL_GV_SORT_ORDER', '840', 'Sort order of display.', 6, 2, NULL, '2003-10-30 22:16:40', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Queue Purchases', 'MODULE_ORDER_TOTAL_GV_QUEUE', 'true', 'Do you want to queue purchases of the Gift Voucher?', 6, 3, NULL, '2003-10-30 22:16:40', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Include Shipping', 'MODULE_ORDER_TOTAL_GV_INC_SHIPPING', 'true', 'Include Shipping in calculation', 6, 5, NULL, '2003-10-30 22:16:40', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Include Tax', 'MODULE_ORDER_TOTAL_GV_INC_TAX', 'true', 'Include Tax in calculation.', 6, 6, NULL, '2003-10-30 22:16:40', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Re-calculate Tax', 'MODULE_ORDER_TOTAL_GV_CALC_TAX', 'None', 'Re-Calculate Tax', 6, 7, NULL, '2003-10-30 22:16:40', NULL, 'zen_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Tax Class', 'MODULE_ORDER_TOTAL_GV_TAX_CLASS', '0', 'Use the following tax class when treating Gift Voucher as Credit Note.', 6, 0, NULL, '2003-10-30 22:16:40', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Credit including Tax', 'MODULE_ORDER_TOTAL_GV_CREDIT_TAX', 'false', 'Add tax to purchased Gift Voucher when crediting to Account', 6, 8, NULL, '2003-10-30 22:16:40', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('This module is installed', 'MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS', 'true', '', 6, 1, NULL, '2003-10-30 22:16:43', NULL, 'zen_cfg_select_option(array(\'true\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Sort Order', 'MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER', '400', 'Sort order of display.', 6, 2, NULL, '2003-10-30 22:16:43', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Allow Low Order Fee', 'MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE', 'false', 'Do you want to allow low order fees?', 6, 3, NULL, '2003-10-30 22:16:43', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Order Fee For Orders Under', 'MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER', '50', 'Add the low order fee to orders under this amount.', 6, 4, NULL, '2003-10-30 22:16:43', 'currencies->format', NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Order Fee', 'MODULE_ORDER_TOTAL_LOWORDERFEE_FEE', '5', 'For Percentage Calculation - include a % Example: 10%<br />For a flat amount just enter the amount - Example: 5 for $5.00', 6, 5, NULL, '2003-10-30 22:16:43', '', NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Attach Low Order Fee On Orders Made', 'MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION', 'both', 'Attach low order fee for orders sent to the set destination.', 6, 6, NULL, '2003-10-30 22:16:43', NULL, 'zen_cfg_select_option(array(\'national\', \'international\', \'both\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Tax Class', 'MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS', '0', 'Use the following tax class on the low order fee.', 6, 7, NULL, '2003-10-30 22:16:43', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(');

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('No Low Order Fee on Virtual Products', 'MODULE_ORDER_TOTAL_LOWORDERFEE_VIRTUAL', 'false', 'Do not charge Low Order Fee when cart is Virtual Products Only', 6, 8, NULL, '2004-04-20 22:16:43', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('No Low Order Fee on Gift Vouchers', 'MODULE_ORDER_TOTAL_LOWORDERFEE_GV', 'false', 'Do not charge Low Order Fee when cart is Gift Vouchers Only', 6, 9, NULL, '2004-04-20 22:16:43', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('This module is installed', 'MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true', '', 6, 1, NULL, '2003-10-30 22:16:46', NULL, 'zen_cfg_select_option(array(\'true\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Sort Order', 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '200', 'Sort order of display.', 6, 2, NULL, '2003-10-30 22:16:46', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Allow Free Shipping', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false', 'Do you want to allow free shipping?', 6, 3, NULL, '2003-10-30 22:16:46', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Free Shipping For Orders Over', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50', 'Provide free shipping for orders over the set amount.', 6, 4, NULL, '2003-10-30 22:16:46', 'currencies->format', NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Provide Free Shipping For Orders Made', 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national', 'Provide free shipping for orders sent to the set destination.', 6, 5, NULL, '2003-10-30 22:16:46', NULL, 'zen_cfg_select_option(array(\'national\', \'international\', \'both\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('This module is installed', 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', '', 6, 1, NULL, '2003-10-30 22:16:49', NULL, 'zen_cfg_select_option(array(\'true\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Sort Order', 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '100', 'Sort order of display.', 6, 2, NULL, '2003-10-30 22:16:49', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('This module is installed', 'MODULE_ORDER_TOTAL_TAX_STATUS', 'true', '', 6, 1, NULL, '2003-10-30 22:16:52', NULL, 'zen_cfg_select_option(array(\'true\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Sort Order', 'MODULE_ORDER_TOTAL_TAX_SORT_ORDER', '300', 'Sort order of display.', 6, 2, NULL, '2003-10-30 22:16:52', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('This module is installed', 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true', '', 6, 1, NULL, '2003-10-30 22:16:55', NULL, 'zen_cfg_select_option(array(\'true\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Sort Order', 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '999', 'Sort order of display.', 6, 2, NULL, '2003-10-30 22:16:55', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Tax Class', 'MODULE_ORDER_TOTAL_COUPON_TAX_CLASS', '0', 'Use the following tax class when treating Discount Coupon as Credit Note.', 6, 0, NULL, '2003-10-30 22:16:36', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Include Tax', 'MODULE_ORDER_TOTAL_COUPON_INC_TAX', 'true', 'Include Tax in calculation.', 6, 6, NULL, '2003-10-30 22:16:36', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Sort Order', 'MODULE_ORDER_TOTAL_COUPON_SORT_ORDER', '280', 'Sort order of display.', 6, 2, NULL, '2003-10-30 22:16:36', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Include Shipping', 'MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING', 'false', 'Include Shipping in calculation', 6, 5, NULL, '2003-10-30 22:16:36', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('This module is installed', 'MODULE_ORDER_TOTAL_COUPON_STATUS', 'true', '', 6, 1, NULL, '2003-10-30 22:16:36', NULL, 'zen_cfg_select_option(array(\'true\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Re-calculate Tax', 'MODULE_ORDER_TOTAL_COUPON_CALC_TAX', 'Standard', 'Re-Calculate Tax', 6, 7, NULL, '2003-10-30 22:16:36', NULL, 'zen_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Admin Demo Status', 'ADMIN_DEMO', '0', 'Admin Demo should be on?<br />0= off 1= on', 6, '', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Product option type Select', 'PRODUCTS_OPTIONS_TYPE_SELECT', '0', 'The number representing the Select type of product option.', 0, NULL, now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Text product option type', 'PRODUCTS_OPTIONS_TYPE_TEXT', '1', 'Numeric value of the text product option type', 6, NULL, now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Radio button product option type', 'PRODUCTS_OPTIONS_TYPE_RADIO', '2', 'Numeric value of the radio button product option type', 6, NULL, now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Check box product option type', 'PRODUCTS_OPTIONS_TYPE_CHECKBOX', '3', 'Numeric value of the check box product option type', 6, NULL, now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'File product option type', 'PRODUCTS_OPTIONS_TYPE_FILE', '4', 'Numeric value of the file product option type', 6, NULL, now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'ID for text and file products options values', 'PRODUCTS_OPTIONS_VALUES_TEXT_ID', '0', 'Numeric value of the products_options_values_id used by the text and file attributes.', 6, NULL, now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Upload prefix', 'UPLOAD_PREFIX', 'upload_', 'Prefix used to differentiate between upload options and other options', 0, NULL, now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Text prefix', 'TEXT_PREFIX', 'txt_', 'Prefix used to differentiate between text option values and other option values', 0, NULL, now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'Read Only option type', 'PRODUCTS_OPTIONS_TYPE_READONLY', '5', 'Numeric value of the file product option type', 6, NULL, now(), now(), NULL, NULL);






INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Products Info - Products Option Name Sort Order', 'PRODUCTS_OPTIONS_SORT_ORDER', '0', 'Sort order of Option Names for Products Info<br />0= Sort Order, Option Name<br />1= Option Name', 18, 35, now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Products Info - Product Option Value of Attributes Sort Order', 'PRODUCTS_OPTIONS_SORT_BY_PRICE', '1', 'Sort order of Product Option Values of Attributes for Products Info<br />0= Sort Order, Price<br />1= Sort Order, Option Value Name', 18, 36, now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');

# test remove and only use products_options_images_per_row
#INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Product Info - Number of Attribute Images per Row', 'PRODUCTS_IMAGES_ATTRIBUTES_PER_ROW', '5', 'Product Info - Enter the number of attribute images to display per row<br />Default = 5', '18', '40', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Info - Show Option Values Name Below Attributes Image', 'PRODUCT_IMAGES_ATTRIBUTES_NAMES', '1', 'Product Info - Show the name of the Option Value beneath the Attribute Image?<br />0= off 1= on', 18, 41, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

# test remove and only use products_options_images_style
#INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Info - Show Option Values and Attributes Images for Radio Buttons and Checkboxes', 'PRODUCT_IMAGES_ATTRIBUTES_NAMES_COLUMN', '0', '0= Images Below Option Names<br />1= Element, Image and Option Value<br />2= Element, Image and Option Name Below<br />3= Option Name Below Element and Image<br />4= Element Below Image and Option Name<br />5= Element Above Image and Option Name', 18, 42, 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\', \'5\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Info - Show Sales Discount Savings Status', 'SHOW_SALE_DISCOUNT_STATUS', '1', 'Product Info - Show the amount of discount savings?<br />0= off 1= on', 18, 45, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Info - Show Sales Discount Savings Dollars or Percentage', 'SHOW_SALE_DISCOUNT', '1', 'Product Info - Show the amount of discount savings display as:<br />1= % off 2= $amount off', 18, 46, 'zen_cfg_select_option(array(\'1\', \'2\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Info - Show Sales Discount Savings Percentage Decimals', 'SHOW_SALE_DISCOUNT_DECIMALS', '0', 'Product Info - Show discount savings display as a Percentage with how many decimals?:<br />Default= 0', 18, 47, NULL, now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Info - Price is Free Image or Text Status', 'OTHER_IMAGE_PRICE_IS_FREE_ON', '1', 'Product Info - Show the Price is Free Image or Text on Displayed Price<br />0= Text<br />1= Image', 18, 50, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Info - Price is Call for Price Image or Text Status', 'PRODUCTS_PRICE_IS_CALL_IMAGE_ON', '1', 'Product Info - Show the Price is Call for Price Image or Text on Displayed Price<br />0= Text<br />1= Image', 18, 51, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Quantity Box Status - Adding New Products', 'PRODUCTS_QTY_BOX_STATUS', '1', 'What should the Default Quantity Box Status be set to when adding New Products?<br /><br />0= off<br />1= on<br />NOTE: This will show a Qty Box when ON and default the Add to Cart to 1', '18', '55', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Product Reviews Require Approval', 'REVIEWS_APPROVAL', '1', 'Do product reviews require approval?<br /><br />Note: When Review Status is off, it will also not show<br /><br />0= off 1= on', '18', '62', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Meta Tags - Include Product Price in Title', 'META_TAG_INCLUDE_PRICE', '1', 'Do you want to include the Product Price in the Meta Tag Title?<br /><br />0= off 1= on', '18', '70', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Also Purchased Products Columns per Row', 'SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS', '3', 'Also Purchased Products Columns per Row<br />0= off or set the sort order', '18', '72', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Previous Next - Navigation Bar Position', 'PRODUCT_INFO_PREVIOUS_NEXT', '1', 'Location of Previous/Next Navigation Bar<br />0= off<br />1= Top of Page<br />2= Bottom of Page<br />3= Both Top and Bottom of Page', 18, 21, now(), now(), NULL, 'zen_cfg_select_drop_down(array(array(\'id\'=>\'0\', \'text\'=>\'Off\'), array(\'id\'=>\'1\', \'text\'=>\'Top of Page\'), array(\'id\'=>\'2\', \'text\'=>\'Bottom of Page\'), array(\'id\'=>\'3\', \'text\'=>\'Both Top & Bottom of Page\')),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Previous Next - Sort Order', 'PRODUCT_INFO_PREVIOUS_NEXT_SORT', '1', 'Products Display Order by<br />0= Product ID<br />1= Product Name<br />2= Model<br />3= Price, Product Name<br />4= Price, Model<br />5= Product Name, Model<br />6= Product Sort Order', 18, 22, now(), now(), NULL, 'zen_cfg_select_drop_down(array(array(\'id\'=>\'0\', \'text\'=>\'Product ID\'), array(\'id\'=>\'1\', \'text\'=>\'Name\'), array(\'id\'=>\'2\', \'text\'=>\'Product Model\'), array(\'id\'=>\'3\', \'text\'=>\'Product Price - Name\'), array(\'id\'=>\'4\', \'text\'=>\'Product Price - Model\'), array(\'id\'=>\'5\', \'text\'=>\'Product Name - Model\'), array(\'id\'=>\'6\', \'text\'=>\'Product Sort Order\')),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Previous Next - Button and Image Status', 'SHOW_PREVIOUS_NEXT_STATUS', '0', 'Button and Product Image status settings are:<br />0= Off<br />1= On', 18, 20, now(), now(), NULL, 'zen_cfg_select_drop_down(array(array(\'id\'=>\'0\', \'text\'=>\'Off\'), array(\'id\'=>\'1\', \'text\'=>\'On\')),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Previous Next - Button and Image Settings', 'SHOW_PREVIOUS_NEXT_IMAGES', '0', 'Show Previous/Next Button and Product Image Settings<br />0= Button Only<br />1= Button and Product Image<br />2= Product Image Only', 18, 21, now(), now(), NULL, 'zen_cfg_select_drop_down(array(array(\'id\'=>\'0\', \'text\'=>\'Button Only\'), array(\'id\'=>\'1\', \'text\'=>\'Button and Product Image\'), array(\'id\'=>\'2\', \'text\'=>\'Product Image Only\')),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Previous Next - Image Width?', 'PREVIOUS_NEXT_IMAGE_WIDTH', '50', 'Previous/Next Image Width?', '18', '22', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Previous Next - Image Height?', 'PREVIOUS_NEXT_IMAGE_HEIGHT', '40', 'Previous/Next Image Height?', '18', '23', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Previous Next - Navigation Includes Category', 'PRODUCT_INFO_CATEGORIES', '1', 'Product\'s Category Image and Name Alignment Above Previous/Next Navigation Bar<br />0= off<br />1= Align Left<br />2= Align Center<br />3= Align Right', 18, 20, now(), now(), NULL, 'zen_cfg_select_drop_down(array(array(\'id\'=>\'0\', \'text\'=>\'Off\'), array(\'id\'=>\'1\', \'text\'=>\'Align Left\'), array(\'id\'=>\'2\', \'text\'=>\'Align Center\'), array(\'id\'=>\'3\', \'text\'=>\'Align Right\')),');



INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Column Width - Left Boxes', 'BOX_WIDTH_LEFT', '150px', 'Width of the Left Column Boxes<br />px may be included<br />Default = 150px', 19, 1, NULL, '2003-11-21 22:16:36', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Column Width - Right Boxes', 'BOX_WIDTH_RIGHT', '150px', 'Width of the Right Column Boxes<br />px may be included<br />Default = 150px', 19, 2, NULL, '2003-11-21 22:16:36', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Bread Crumbs Navigation Separator', 'BREAD_CRUMBS_SEPARATOR', '&nbsp;::&nbsp;', 'Enter the separator symbol to appear between the Navigation Bread Crumb trail<br />Note: Include spaces with the &amp;nbsp; symbol if you want them part of the separator.<br />Default = &amp;nbsp;::&amp;nbsp;', 19, 3, NULL, '2003-11-21 22:16:36', NULL, 'zen_cfg_textarea_small(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Bestsellers - Number Padding', 'BEST_SELLERS_FILLER', '&nbsp;', 'What do you want to Pad the numbers with?<br />Default = &amp;nbsp;', 19, 5, NULL, '2003-11-21 22:16:36', NULL, 'zen_cfg_textarea_small(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Bestsellers - Truncate Product Names', 'BEST_SELLERS_TRUNCATE', '35', 'What size do you want to truncate the Product Names?<br />Default = 35', 19, 6, NULL, '2003-11-21 22:16:36', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Bestsellers - Truncate Product Names followed by ...', 'BEST_SELLERS_TRUNCATE_MORE', 'true', 'When truncated Product Names follow with ...<br />Default = true', 19, 7, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories Box - Show Specials Link', 'SHOW_CATEGORIES_BOX_SPECIALS', 'true', 'Show Specials Link in the Categories Box', 19, 8, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories Box - Show Products New Link', 'SHOW_CATEGORIES_BOX_PRODUCTS_NEW', 'true', 'Show Products New Link in the Categories Box', 19, 9, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Shopping Cart Box Status', 'SHOW_SHOPPING_CART_BOX_STATUS', '1', 'Shopping Cart Shows<br />0= Always<br />1= Only when full<br />2= Only when full but when viewing the Shopping Cart', 19, 10, 'zen_cfg_select_option(array(\'0\', \'1\', \'2\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories Box - Show Featured Products Link', 'SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS', 'true', 'Show Featured Products Link in the Categories Box', 19, 11, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories Box - Show Products All Link', 'SHOW_CATEGORIES_BOX_PRODUCTS_ALL', 'true', 'Show Products All Link in the Categories Box', 19, 12, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Column Left Status - Global', 'COLUMN_LEFT_STATUS', '1', 'Show Column Left, unless page override exists?<br />0= Column Left is always off<br />1= Column Left is on, unless page override', 19, 15, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Column Right Status - Global', 'COLUMN_RIGHT_STATUS', '1', 'Show Column Right, unless page override exists?<br />0= Column Right is always off<br />1= Column Right is on, unless page override', 19, 16, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Column Width - Left', 'COLUMN_WIDTH_LEFT', '150px', 'Width of the Left Column<br />px may be included<br />Default = 150px', 19, 20, NULL, '2003-11-21 22:16:36', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Column Width - Right', 'COLUMN_WIDTH_RIGHT', '150px', 'Width of the Right Column<br />px may be included<br />Default = 150px', 19, 21, NULL, '2003-11-21 22:16:36', NULL, NULL);

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Categories Separator between links Status', 'SHOW_CATEGORIES_SEPARATOR_LINK', '1', 'Show Category Separator between Category Names and Links?<br />0= off<br />1= on', 19, 24, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories Separator between the Category Name and Count', 'CATEGORIES_SEPARATOR', '-&gt;', 'What separator do you want between the Category name and the count?<br />Default = -&amp;gt;', 19, 25, NULL, '2003-11-21 22:16:36', NULL, 'zen_cfg_textarea_small(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories Separator between the Category Name and Sub Categories', 'CATEGORIES_SEPARATOR_SUBS', '|_&nbsp;', 'What separator do you want between the Category name and Sub Category Name?<br />Default = |_&amp;nbsp;', 19, 26, NULL, '2004-03-25 22:16:36', NULL, 'zen_cfg_textarea_small(');

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories Count Prefix', 'CATEGORIES_COUNT_PREFIX', '&nbsp;(', 'What do you want to Prefix the count with?<br />Default= (', 19, 27, NULL, '2003-01-21 22:16:36', NULL, 'zen_cfg_textarea_small(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories Count Suffix', 'CATEGORIES_COUNT_SUFFIX', ')', 'What do you want as a Suffix to the count?<br />Default= )', 19, 28, NULL, '2003-01-21 22:16:36', NULL, 'zen_cfg_textarea_small(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Categories SubCategories Indent', 'CATEGORIES_SUBCATEGORIES_INDENT', '&nbsp;&nbsp;', 'What do you want to use as the subcategories indent?<br />Default= &nbsp;&nbsp;', 19, 29, NULL, '2004-06-24 22:16:36', NULL, 'zen_cfg_textarea_small(');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Categories with 0 Products Status', 'CATEGORIES_COUNT_ZERO', '0', 'Show Category Count for 0 Products?<br />0= off<br />1= on', 19, 30, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Split Categories Box', 'CATEGORIES_SPLIT_DISPLAY', 'True', 'Split the categories box display by product type', 19, 31, 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Shopping Cart - Show Totals', 'SHOW_TOTALS_IN_CART', '1', 'Show Totals Above Shopping Cart?<br />0= off<br />1= on<br />2= on, no weight when 0', 19, 31, 'zen_cfg_select_option(array(\'0\', \'1\', \'2\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Categories - Always Show on Main Page', 'SHOW_CATEGORIES_ALWAYS', '0', 'Always Show Categories on Main Page<br />0= off<br />1= on<br />Default category can be set to Top Level or a Specific Top Level', 19, 45, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Main Page - Opens with Category', 'CATEGORIES_START_MAIN', '0', '0= Top Level Categories<br />Or enter the Category ID#<br />Note: Sub Categories can also be used Example: 3_10', '19', '46', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Categories - Always Open to Show SubCategories', 'SHOW_CATEGORIES_SUBCATEGORIES_ALWAYS', '1', 'Always Show Categories and SubCategories<br />0= off, just show Top Categories<br />1= on, Always show Categories and SubCategories when selected', 19, 47, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Banner Display Groups - Header Position 1', 'SHOW_BANNERS_GROUP_SET1', '', 'The Banner Display Groups can be from 1 Banner Group or Multiple Banner Groups<br /><br />For Multiple Banner Groups enter the Banner Group Name separated by a colon <strong>:</strong><br /><br />Example: Wide-Banners:SideBox-Banners<br /><br />What Banner Group(s) do you want to use in the Header Position 1?<br />Leave blank for none', '19', '55', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Banner Display Groups - Header Position 2', 'SHOW_BANNERS_GROUP_SET2', '', 'The Banner Display Groups can be from 1 Banner Group or Multiple Banner Groups<br /><br />For Multiple Banner Groups enter the Banner Group Name separated by a colon <strong>:</strong><br /><br />Example: Wide-Banners:SideBox-Banners<br /><br />What Banner Group(s) do you want to use in the Header Position 2?<br />Leave blank for none', '19', '56', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Banner Display Groups - Header Position 3', 'SHOW_BANNERS_GROUP_SET3', '', 'The Banner Display Groups can be from 1 Banner Group or Multiple Banner Groups<br /><br />For Multiple Banner Groups enter the Banner Group Name separated by a colon <strong>:</strong><br /><br />Example: Wide-Banners:SideBox-Banners<br /><br />What Banner Group(s) do you want to use in the Header Position 3?<br />Leave blank for none', '19', '57', '', '', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Banner Display Groups - Footer Position 1', 'SHOW_BANNERS_GROUP_SET4', '', 'The Banner Display Groups can be from 1 Banner Group or Multiple Banner Groups<br /><br />For Multiple Banner Groups enter the Banner Group Name separated by a colon <strong>:</strong><br /><br />Example: Wide-Banners:SideBox-Banners<br /><br />What Banner Group(s) do you want to use in the Footer Position 1?<br />Leave blank for none', '19', '65', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Banner Display Groups - Footer Position 2', 'SHOW_BANNERS_GROUP_SET5', '', 'The Banner Display Groups can be from 1 Banner Group or Multiple Banner Groups<br /><br />For Multiple Banner Groups enter the Banner Group Name separated by a colon <strong>:</strong><br /><br />Example: Wide-Banners:SideBox-Banners<br /><br />What Banner Group(s) do you want to use in the Footer Position 2?<br />Leave blank for none', '19', '66', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Banner Display Groups - Footer Position 3', 'SHOW_BANNERS_GROUP_SET6', 'Wide-Banners', 'The Banner Display Groups can be from 1 Banner Group or Multiple Banner Groups<br /><br />For Multiple Banner Groups enter the Banner Group Name separated by a colon <strong>:</strong><br /><br />Example: Wide-Banners:SideBox-Banners<br /><br />Default Group is Wide-Banners<br /><br />What Banner Group(s) do you want to use in the Footer Position 3?<br />Leave blank for none', '19', '67', '', '', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Banner Display Groups - Side Box banner_box', 'SHOW_BANNERS_GROUP_SET7', 'SideBox-Banners', 'The Banner Display Groups can be from 1 Banner Group or Multiple Banner Groups<br /><br />For Multiple Banner Groups enter the Banner Group Name separated by a colon <strong>:</strong><br /><br />Example: Wide-Banners:SideBox-Banners<br />Default Group is SideBox-Banners<br /><br />What Banner Group(s) do you want to use in the Side Box - banner_box?<br />Leave blank for none', '19', '70', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Banner Display Groups - Side Box banner_box2', 'SHOW_BANNERS_GROUP_SET8', 'SideBox-Banners', 'The Banner Display Groups can be from 1 Banner Group or Multiple Banner Groups<br /><br />For Multiple Banner Groups enter the Banner Group Name separated by a colon <strong>:</strong><br /><br />Example: Wide-Banners:SideBox-Banners<br />Default Group is SideBox-Banners<br /><br />What Banner Group(s) do you want to use in the Side Box - banner_box2?<br />Leave blank for none', '19', '71', '', '', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Footer - Show IP Address status', 'SHOW_FOOTER_IP', '1', 'Show Customer IP Address in the Footer<br />0= off<br />1= on<br />Should the Customer IP Address show in the footer?', 19, 80, 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Product Discount Quantities - Add how many blank discounts?', 'DISCOUNT_QTY_ADD', '5', 'How many blank discount quantities should be added for Product Pricing?', '19', '90', '', '', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('Product Discount Quantities - Display how many per row?', 'DISCOUNT_QUANTITY_PRICES_COLUMN', '5', 'How many discount quantities should show per row on Product Info Pages?', '19', '95', '', '', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('<strong>Down for Maintenance: ON/OFF</strong>', 'DOWN_FOR_MAINTENANCE', 'false', 'Down for Maintenance <br />(true=on false=off)', '20', '1', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Down for Maintenance: filename', 'DOWN_FOR_MAINTENANCE_FILENAME', 'down_for_maintenance', 'Down for Maintenance filename<br />Note: Do not include the extention<br />Default=down_for_maintenance', '20', '2', '', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Down for Maintenance: Hide Header', 'DOWN_FOR_MAINTENANCE_HEADER_OFF', 'false', 'Down for Maintenance: Hide Header <br />(true=hide false=show)', '20', '3', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Down for Maintenance: Hide Column Left', 'DOWN_FOR_MAINTENANCE_COLUMN_LEFT_OFF', 'false', 'Down for Maintenance: Hide Column Left <br />(true=hide false=show)', '20', '4', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Down for Maintenance: Hide Column Right', 'DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF', 'false', 'Down for Maintenance: Hide Column Right <br />(true=hide false=show)', '20', '5', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Down for Maintenance: Hide Footer', 'DOWN_FOR_MAINTENANCE_FOOTER_OFF', 'false', 'Down for Maintenance: Hide Footer <br />(true=hide false=show)', '20', '6', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('Down for Maintenance: Hide Prices', 'DOWN_FOR_MAINTENANCE_PRICES_OFF', 'false', 'Down for Maintenance: Hide Prices <br />(true=hide false=show)', '20', '7', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Down For Maintenance (exclude this IP-Address)', 'EXCLUDE_ADMIN_IP_FOR_MAINTENANCE', 'your IP (ADMIN)', 'This IP Address is able to access the website while it is Down For Maintenance (like webmaster)<br />To enter multiple IP Addresses, separate with a comma. If you do not know your IP Address, check in the Footer of your Shop.', 20, 8, '2003-03-21 13:43:22', '2003-03-21 21:20:07', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('NOTICE PUBLIC Before going Down for Maintenance: ON/OFF', 'WARN_BEFORE_DOWN_FOR_MAINTENANCE', 'false', 'Give a WARNING some time before you put your website Down for Maintenance<br />(true=on false=off)<br />If you set the \'Down For Maintenance: ON/OFF\' to true this will automaticly be updated to false', 20, 9, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Date and hours for notice before maintenance', 'PERIOD_BEFORE_DOWN_FOR_MAINTENANCE', '15/05/2003  2-3 PM', 'Date and hours for notice before maintenance website, enter date and hours for maintenance website', 20, 10, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, NULL);
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display when webmaster has enabled maintenance', 'DISPLAY_MAINTENANCE_TIME', 'false', 'Display when Webmaster has enabled maintenance <br />(true=on false=off)<br />', 20, 11, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display website maintenance period', 'DISPLAY_MAINTENANCE_PERIOD', 'false', 'Display Website maintenance period <br />(true=on false=off)<br />', 20, 12, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Website maintenance period', 'TEXT_MAINTENANCE_PERIOD_TIME', '2h00', 'Enter Website Maintenance period (hh:mm)', 20, 13, '2003-03-21 13:08:25', '2003-03-21 11:42:47', NULL, NULL);

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Confirm Terms and Conditions During Checkout Procedure', 'DISPLAY_CONDITIONS_ON_CHECKOUT', 'false', 'Show the Terms and Conditions during the checkout procedure which the customer must agree to.', '11', '1', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Confirm Privacy Notice During Account Creation Procedure', 'DISPLAY_PRIVACY_CONDITIONS', 'false', 'Show the Privacy Notice during the account creation procedure which the customer must agree to.', '11', '2', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Image', 'PRODUCT_NEW_LIST_IMAGE', '1102', 'Do you want to display the Product Image?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Quantity', 'PRODUCT_NEW_LIST_QUANTITY', '1202', 'Do you want to display the Product Quantity?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Buy Now Button', 'PRODUCT_NEW_BUY_NOW', '1300', 'Do you want to display the Product Buy Now Button<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Name', 'PRODUCT_NEW_LIST_NAME', '2101', 'Do you want to display the Product Name?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Model', 'PRODUCT_NEW_LIST_MODEL', '2201', 'Do you want to display the Product Model?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '5', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Manufacturer Name','PRODUCT_NEW_LIST_MANUFACTURER', '2302', 'Do you want to display the Product Manufacturer Name?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '6', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Price', 'PRODUCT_NEW_LIST_PRICE', '2402', 'Do you want to display the Product Price<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '7', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Weight', 'PRODUCT_NEW_LIST_WEIGHT', '2502', 'Do you want to display the Product Weight?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '8', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Date Added', 'PRODUCT_NEW_LIST_DATE_ADDED', '2601', 'Do you want to display the Product Date Added?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '21', '9', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Product Description', 'PRODUCT_NEW_LIST_DESCRIPTION', '1', 'Do you want to display the Product Description - First 150 characters?<br />0= off<br />1= on', '21', '10', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Product Display - Default Sort Order', 'PRODUCT_NEW_LIST_SORT_DEFAULT', '6', 'What Sort Order Default should be used for New Products Display?<br />Default= 6 for Date New to Old<br /><br />1= Products Name<br />2= Products Name Desc<br />3= Price low to high, Products Name<br />4= Price high to low, Products Name<br />5= Model<br />6= Date Added desc<br />7= Date Added<br />8= Product Sort Order', '21', '11', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Products New Group ID', 'PRODUCT_NEW_LIST_GROUP_ID', '21', 'Warning: Only change this if your Products New Group ID has changed from the default of 21<br />What is the configuration_group_id for New Products Listings?', '21', '12', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Image', 'PRODUCT_FEATURED_LIST_IMAGE', '1102', 'Do you want to display the Product Image?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Quantity', 'PRODUCT_FEATURED_LIST_QUANTITY', '1202', 'Do you want to display the Product Quantity?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Buy Now Button', 'PRODUCT_FEATURED_BUY_NOW', '1300', 'Do you want to display the Product Buy Now Button<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Name', 'PRODUCT_FEATURED_LIST_NAME', '2101', 'Do you want to display the Product Name?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Model', 'PRODUCT_FEATURED_LIST_MODEL', '2201', 'Do you want to display the Product Model?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '5', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Manufacturer Name','PRODUCT_FEATURED_LIST_MANUFACTURER', '2302', 'Do you want to display the Product Manufacturer Name?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '6', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Price', 'PRODUCT_FEATURED_LIST_PRICE', '2402', 'Do you want to display the Product Price<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '7', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Weight', 'PRODUCT_FEATURED_LIST_WEIGHT', '2502', 'Do you want to display the Product Weight?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '8', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Date Added', 'PRODUCT_FEATURED_LIST_DATE_ADDED', '2601', 'Do you want to display the Product Date Added?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '22', '9', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Product Description', 'PRODUCT_FEATURED_LIST_DESCRIPTION', '1', 'Do you want to display the Product Description - First 150 characters?', '22', '10', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Product Display - Default Sort Order', 'PRODUCT_FEATURED_LIST_SORT_DEFAULT', '1', 'What Sort Order Default should be used for Featured Product Display?<br />Default= 1 for Product Name<br /><br />1= Products Name<br />2= Products Name Desc<br />3= Price low to high, Products Name<br />4= Price high to low, Products Name<br />5= Model<br />6= Date Added desc<br />7= Date Added<br />8= Product Sort Order', '22', '11', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Featured Products Group ID', 'PRODUCT_FEATURED_LIST_GROUP_ID', '22', 'Warning: Only change this if your Featured Products Group ID has changed from the default of 22<br />What is the configuration_group_id for Featured Products Listings?', '22', '12', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Image', 'PRODUCT_ALL_LIST_IMAGE', '1102', 'Do you want to display the Product Image?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '1', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Quantity', 'PRODUCT_ALL_LIST_QUANTITY', '1202', 'Do you want to display the Product Quantity?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '2', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Buy Now Button', 'PRODUCT_ALL_BUY_NOW', '1300', 'Do you want to display the Product Buy Now Button<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '3', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Name', 'PRODUCT_ALL_LIST_NAME', '2101', 'Do you want to display the Product Name?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '4', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Model', 'PRODUCT_ALL_LIST_MODEL', '2201', 'Do you want to display the Product Model?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '5', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Manufacturer Name','PRODUCT_ALL_LIST_MANUFACTURER', '2302', 'Do you want to display the Product Manufacturer Name?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '6', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Price', 'PRODUCT_ALL_LIST_PRICE', '2402', 'Do you want to display the Product Price<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '7', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Weight', 'PRODUCT_ALL_LIST_WEIGHT', '2502', 'Do you want to display the Product Weight?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '8', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Display Product Date Added', 'PRODUCT_ALL_LIST_DATE_ADDED', '2601', 'Do you want to display the Product Date Added?<br /><br />0= off<br />1st digit Left or Right<br />2nd and 3rd digit Sort Order<br />4th digit number of breaks after<br />', '23', '9', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Product Description', 'PRODUCT_ALL_LIST_DESCRIPTION', '1', 'Do you want to display the Product Description - First 150 characters?', '23', '10', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display Product Display - Default Sort Order', 'PRODUCT_ALL_LIST_SORT_DEFAULT', '1', 'What Sort Order Default should be used for All Products Display?<br />Default= 1 for Product Name<br /><br />1= Products Name<br />2= Products Name Desc<br />3= Price low to high, Products Name<br />4= Price high to low, Products Name<br />5= Model<br />6= Date Added desc<br />7= Date Added<br />8= Product Sort Order', '23', '11', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Default Products All Group ID', 'PRODUCT_ALL_LIST_GROUP_ID', '23', 'Warning: Only change this if your Products All Group ID has changed from the default of 23<br />What is the configuration_group_id for Products All Listings?', '23', '12', now());


INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show New Products on Main Page', 'SHOW_PRODUCT_INFO_MAIN_NEW_PRODUCTS', '1', 'Show New Products on Main Page<br />0= off or set the sort order', '24', '65', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Featured Products on Main Page', 'SHOW_PRODUCT_INFO_MAIN_FEATURED_PRODUCTS', '2', 'Show Featured Products on Main Page<br />0= off or set the sort order', '24', '66', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Special Products on Main Page', 'SHOW_PRODUCT_INFO_MAIN_SPECIALS_PRODUCTS', '3', 'Show Special Products on Main Page<br />0= off or set the sort order', '24', '67', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Upcoming Products on Main Page', 'SHOW_PRODUCT_INFO_MAIN_UPCOMING', '4', 'Show Upcoming Products on Main Page<br />0= off or set the sort order', '24', '68', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show New Products on Main Page - Category with SubCategories', 'SHOW_PRODUCT_INFO_CATEGORY_NEW_PRODUCTS', '1', 'Show New Products on Main Page - Category with SubCategories<br />0= off or set the sort order', '24', '70', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Featured Products on Main Page - Category with SubCategories', 'SHOW_PRODUCT_INFO_CATEGORY_FEATURED_PRODUCTS', '2', 'Show Featured Products on Main Page - Category with SubCategories<br />0= off or set the sort order', '24', '71', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Special Products on Main Page - Category with SubCategories', 'SHOW_PRODUCT_INFO_CATEGORY_SPECIALS_PRODUCTS', '3', 'Show Special Products on Main Page - Category with SubCategories<br />0= off or set the sort order', '24', '72', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Upcoming Products on Main Page - Category with SubCategories', 'SHOW_PRODUCT_INFO_CATEGORY_UPCOMING', '4', 'Show Upcoming Products on Main Page - Category with SubCategories<br />0= off or set the sort order', '24', '73', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show New Products on Main Page - Errors and Missing Products Page', 'SHOW_PRODUCT_INFO_MISSING_NEW_PRODUCTS', '1', 'Show New Products on Main Page - Errors and Missing Product<br />0= off or set the sort order', '24', '75', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Featured Products on Main Page - Errors and Missing Products Page', 'SHOW_PRODUCT_INFO_MISSING_FEATURED_PRODUCTS', '2', 'Show Featured Products on Main Page - Errors and Missing Product<br />0= off or set the sort order', '24', '76', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Special Products on Main Page - Errors and Missing Products Page', 'SHOW_PRODUCT_INFO_MISSING_SPECIALS_PRODUCTS', '3', 'Show Special Products on Main Page - Errors and Missing Product<br />0= off or set the sort order', '24', '77', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Upcoming Products on Main Page - Errors and Missing Products Page', 'SHOW_PRODUCT_INFO_MISSING_UPCOMING', '4', 'Show Upcoming Products on Main Page - Errors and Missing Product<br />0= off or set the sort order', '24', '78', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show New Products - below Product Listing', 'SHOW_PRODUCT_INFO_LISTING_BELOW_NEW_PRODUCTS', '1', 'Show New Products below Product Listing<br />0= off or set the sort order', '24', '85', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Featured Products - below Product Listing', 'SHOW_PRODUCT_INFO_LISTING_BELOW_FEATURED_PRODUCTS', '2', 'Show Featured Products below Product Listing<br />0= off or set the sort order', '24', '86', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Special Products - below Product Listing', 'SHOW_PRODUCT_INFO_LISTING_BELOW_SPECIALS_PRODUCTS', '3', 'Show Special Products below Product Listing<br />0= off or set the sort order', '24', '87', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Show Upcoming Products - below Product Listing', 'SHOW_PRODUCT_INFO_LISTING_BELOW_UPCOMING', '4', 'Show Upcoming Products below Product Listing<br />0= off or set the sort order', '24', '88', 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('New Products Columns per Row', 'SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS', '3', 'New Products Columns per Row', '24', '95', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Featured Products Columns per Row', 'SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS', '3', 'Featured Products Columns per Row', '24', '96', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\', \'4\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Special Products Columns per Row', 'SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS', '3', 'Special Products Columns per Row', '24', '97', 'zen_cfg_select_option(array(\'1\', \'2\', \'3\', \'4\'), ', now());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Filter Product Listing for Current Top Level Category When Enabled', 'SHOW_PRODUCT_INFO_ALL_PRODUCTS', '1', 'Filter the products when Product Listing is enabled for current Main Category or show products from all categories?<br />0= Filter Off 1=Filter On ', '24', '100', 'zen_cfg_select_option(array(\'0\', \'1\'), ', now());

insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Main Page Status', 'DEFINE_MAIN_PAGE_STATUS', '1', 'Enable the Defined Main Page text?<br />0= OFF<br />1= ON', '25', '60', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Contact Us Status', 'DEFINE_CONTACT_US_STATUS', '1', 'Enable the Defined Contact Us text?<br />0= OFF<br />1= ON', '25', '61', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Privacy Status', 'DEFINE_PRIVACY_STATUS', '1', 'Enable the Defined Privacy text?<br />0= OFF<br />1= ON', '25', '62', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Shipping & Returns', 'DEFINE_SHIPPINGINFO_STATUS', '1', 'Enable the Defined Shipping & Returns text?<br />0= OFF<br />1= ON', '25', '63', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Conditions of Use', 'DEFINE_CONDITIONS_STATUS', '1', 'Enable the Defined Conditions of Use text?<br />0= OFF<br />1= ON', '25', '64', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Checkout Success', 'DEFINE_CHECKOUT_SUCCESS_STATUS', '1', 'Enable the Defined Checkout Success text?<br />0= OFF<br />1= ON', '25', '65', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');

insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Page 2', 'DEFINE_PAGE_2_STATUS', '1', 'Enable the Defined Page 2 text?<br />0= OFF<br />1= ON', '25', '82', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Page 3', 'DEFINE_PAGE_3_STATUS', '1', 'Enable the Defined Page 3 text?<br />0= OFF<br />1= ON', '25', '83', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');
insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('Define Page 4', 'DEFINE_PAGE_4_STATUS', '1', 'Enable the Defined Page 4 text?<br />0= OFF<br />1= ON', '25', '84', now(), now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\'),');













INSERT INTO configuration_group VALUES ('1', 'My Store', 'General information about my store', '1', '1');
INSERT INTO configuration_group VALUES ('2', 'Minimum Values', 'The minimum values for functions / data', '2', '1');
INSERT INTO configuration_group VALUES ('3', 'Maximum Values', 'The maximum values for functions / data', '3', '1');
INSERT INTO configuration_group VALUES ('4', 'Images', 'Image parameters', '4', '1');
INSERT INTO configuration_group VALUES ('5', 'Customer Details', 'Customer account configuration', '5', '1');
INSERT INTO configuration_group VALUES ('6', 'Module Options', 'Hidden from configuration', '6', '0');
INSERT INTO configuration_group VALUES ('7', 'Shipping/Packaging', 'Shipping options available at my store', '7', '1');
INSERT INTO configuration_group VALUES ('8', 'Product Listing', 'Product Listing configuration options', '8', '1');
INSERT INTO configuration_group VALUES ('9', 'Stock', 'Stock configuration options', '9', '1');
INSERT INTO configuration_group VALUES ('10', 'Logging', 'Logging configuration options', '10', '1');
INSERT INTO configuration_group VALUES ('11', 'Regulations', 'Regulation options', '16', '1');
INSERT INTO configuration_group VALUES ('12', 'E-Mail Options', 'General setting for E-Mail transport and HTML E-Mails', '12', '1');
INSERT INTO configuration_group VALUES ('13', 'Attribute Settings', 'Configure products attributes settings', '13', '1');
INSERT INTO configuration_group VALUES ('14', 'GZip Compression', 'GZip compression options', '14', '1');
INSERT INTO configuration_group VALUES ('15', 'Sessions', 'Session options', '15', '1');
INSERT INTO configuration_group VALUES ('16', 'GV Coupons', 'Gift Vouchers and Coupons', '16', '1');
INSERT INTO configuration_group VALUES ('17', 'Credit Cards', 'Credit Cards Accepted', '17', '1');
INSERT INTO configuration_group VALUES ('18', 'Product Info', 'Product Info Display Options', '18', '1');
INSERT INTO configuration_group VALUES ('19', 'Layout Settings', 'Layout Options', '19', '1');
INSERT INTO configuration_group VALUES ('20', 'Website Maintenance', 'Website Maintenance Options', '20', '1');
INSERT INTO configuration_group VALUES ('21', 'New Listing', 'New Products Listing', '21', '1');
INSERT INTO configuration_group VALUES ('22', 'Featured Listing', 'Featured Products Listing', '22', '1');
INSERT INTO configuration_group VALUES ('23', 'All Listing', 'All Products Listing', '23', '1');
INSERT INTO configuration_group VALUES ('24', 'Index Listing', 'Index Products Listing', '24', '1');
insert into configuration_group VALUES ('25', 'Define Page Status', 'Define Main Pages and HTMLArea Options', '25', '1');

INSERT INTO countries VALUES (1,'Afghanistan','AF','AFG','1');
INSERT INTO countries VALUES (2,'Albania','AL','ALB','1');
INSERT INTO countries VALUES (3,'Algeria','DZ','DZA','1');
INSERT INTO countries VALUES (4,'American Samoa','AS','ASM','1');
INSERT INTO countries VALUES (5,'Andorra','AD','AND','1');
INSERT INTO countries VALUES (6,'Angola','AO','AGO','1');
INSERT INTO countries VALUES (7,'Anguilla','AI','AIA','1');
INSERT INTO countries VALUES (8,'Antarctica','AQ','ATA','1');
INSERT INTO countries VALUES (9,'Antigua and Barbuda','AG','ATG','1');
INSERT INTO countries VALUES (10,'Argentina','AR','ARG','1');
INSERT INTO countries VALUES (11,'Armenia','AM','ARM','1');
INSERT INTO countries VALUES (12,'Aruba','AW','ABW','1');
INSERT INTO countries VALUES (13,'Australia','AU','AUS','1');
INSERT INTO countries VALUES (14,'Austria','AT','AUT','5');
INSERT INTO countries VALUES (15,'Azerbaijan','AZ','AZE','1');
INSERT INTO countries VALUES (16,'Bahamas','BS','BHS','1');
INSERT INTO countries VALUES (17,'Bahrain','BH','BHR','1');
INSERT INTO countries VALUES (18,'Bangladesh','BD','BGD','1');
INSERT INTO countries VALUES (19,'Barbados','BB','BRB','1');
INSERT INTO countries VALUES (20,'Belarus','BY','BLR','1');
INSERT INTO countries VALUES (21,'Belgium','BE','BEL','1');
INSERT INTO countries VALUES (22,'Belize','BZ','BLZ','1');
INSERT INTO countries VALUES (23,'Benin','BJ','BEN','1');
INSERT INTO countries VALUES (24,'Bermuda','BM','BMU','1');
INSERT INTO countries VALUES (25,'Bhutan','BT','BTN','1');
INSERT INTO countries VALUES (26,'Bolivia','BO','BOL','1');
INSERT INTO countries VALUES (27,'Bosnia and Herzegowina','BA','BIH','1');
INSERT INTO countries VALUES (28,'Botswana','BW','BWA','1');
INSERT INTO countries VALUES (29,'Bouvet Island','BV','BVT','1');
INSERT INTO countries VALUES (30,'Brazil','BR','BRA','1');
INSERT INTO countries VALUES (31,'British Indian Ocean Territory','IO','IOT','1');
INSERT INTO countries VALUES (32,'Brunei Darussalam','BN','BRN','1');
INSERT INTO countries VALUES (33,'Bulgaria','BG','BGR','1');
INSERT INTO countries VALUES (34,'Burkina Faso','BF','BFA','1');
INSERT INTO countries VALUES (35,'Burundi','BI','BDI','1');
INSERT INTO countries VALUES (36,'Cambodia','KH','KHM','1');
INSERT INTO countries VALUES (37,'Cameroon','CM','CMR','1');
INSERT INTO countries VALUES (38,'Canada','CA','CAN','1');
INSERT INTO countries VALUES (39,'Cape Verde','CV','CPV','1');
INSERT INTO countries VALUES (40,'Cayman Islands','KY','CYM','1');
INSERT INTO countries VALUES (41,'Central African Republic','CF','CAF','1');
INSERT INTO countries VALUES (42,'Chad','TD','TCD','1');
INSERT INTO countries VALUES (43,'Chile','CL','CHL','1');
INSERT INTO countries VALUES (44,'China','CN','CHN','1');
INSERT INTO countries VALUES (45,'Christmas Island','CX','CXR','1');
INSERT INTO countries VALUES (46,'Cocos (Keeling) Islands','CC','CCK','1');
INSERT INTO countries VALUES (47,'Colombia','CO','COL','1');
INSERT INTO countries VALUES (48,'Comoros','KM','COM','1');
INSERT INTO countries VALUES (49,'Congo','CG','COG','1');
INSERT INTO countries VALUES (50,'Cook Islands','CK','COK','1');
INSERT INTO countries VALUES (51,'Costa Rica','CR','CRI','1');
INSERT INTO countries VALUES (52,'Cote D\'Ivoire','CI','CIV','1');
INSERT INTO countries VALUES (53,'Croatia','HR','HRV','1');
INSERT INTO countries VALUES (54,'Cuba','CU','CUB','1');
INSERT INTO countries VALUES (55,'Cyprus','CY','CYP','1');
INSERT INTO countries VALUES (56,'Czech Republic','CZ','CZE','1');
INSERT INTO countries VALUES (57,'Denmark','DK','DNK','1');
INSERT INTO countries VALUES (58,'Djibouti','DJ','DJI','1');
INSERT INTO countries VALUES (59,'Dominica','DM','DMA','1');
INSERT INTO countries VALUES (60,'Dominican Republic','DO','DOM','1');
INSERT INTO countries VALUES (61,'East Timor','TP','TMP','1');
INSERT INTO countries VALUES (62,'Ecuador','EC','ECU','1');
INSERT INTO countries VALUES (63,'Egypt','EG','EGY','1');
INSERT INTO countries VALUES (64,'El Salvador','SV','SLV','1');
INSERT INTO countries VALUES (65,'Equatorial Guinea','GQ','GNQ','1');
INSERT INTO countries VALUES (66,'Eritrea','ER','ERI','1');
INSERT INTO countries VALUES (67,'Estonia','EE','EST','1');
INSERT INTO countries VALUES (68,'Ethiopia','ET','ETH','1');
INSERT INTO countries VALUES (69,'Falkland Islands (Malvinas)','FK','FLK','1');
INSERT INTO countries VALUES (70,'Faroe Islands','FO','FRO','1');
INSERT INTO countries VALUES (71,'Fiji','FJ','FJI','1');
INSERT INTO countries VALUES (72,'Finland','FI','FIN','1');
INSERT INTO countries VALUES (73,'France','FR','FRA','1');
INSERT INTO countries VALUES (74,'France, Metropolitan','FX','FXX','1');
INSERT INTO countries VALUES (75,'French Guiana','GF','GUF','1');
INSERT INTO countries VALUES (76,'French Polynesia','PF','PYF','1');
INSERT INTO countries VALUES (77,'French Southern Territories','TF','ATF','1');
INSERT INTO countries VALUES (78,'Gabon','GA','GAB','1');
INSERT INTO countries VALUES (79,'Gambia','GM','GMB','1');
INSERT INTO countries VALUES (80,'Georgia','GE','GEO','1');
INSERT INTO countries VALUES (81,'Germany','DE','DEU','5');
INSERT INTO countries VALUES (82,'Ghana','GH','GHA','1');
INSERT INTO countries VALUES (83,'Gibraltar','GI','GIB','1');
INSERT INTO countries VALUES (84,'Greece','GR','GRC','1');
INSERT INTO countries VALUES (85,'Greenland','GL','GRL','1');
INSERT INTO countries VALUES (86,'Grenada','GD','GRD','1');
INSERT INTO countries VALUES (87,'Guadeloupe','GP','GLP','1');
INSERT INTO countries VALUES (88,'Guam','GU','GUM','1');
INSERT INTO countries VALUES (89,'Guatemala','GT','GTM','1');
INSERT INTO countries VALUES (90,'Guinea','GN','GIN','1');
INSERT INTO countries VALUES (91,'Guinea-bissau','GW','GNB','1');
INSERT INTO countries VALUES (92,'Guyana','GY','GUY','1');
INSERT INTO countries VALUES (93,'Haiti','HT','HTI','1');
INSERT INTO countries VALUES (94,'Heard and Mc Donald Islands','HM','HMD','1');
INSERT INTO countries VALUES (95,'Honduras','HN','HND','1');
INSERT INTO countries VALUES (96,'Hong Kong','HK','HKG','1');
INSERT INTO countries VALUES (97,'Hungary','HU','HUN','1');
INSERT INTO countries VALUES (98,'Iceland','IS','ISL','1');
INSERT INTO countries VALUES (99,'India','IN','IND','1');
INSERT INTO countries VALUES (100,'Indonesia','ID','IDN','1');
INSERT INTO countries VALUES (101,'Iran (Islamic Republic of)','IR','IRN','1');
INSERT INTO countries VALUES (102,'Iraq','IQ','IRQ','1');
INSERT INTO countries VALUES (103,'Ireland','IE','IRL','1');
INSERT INTO countries VALUES (104,'Israel','IL','ISR','1');
INSERT INTO countries VALUES (105,'Italy','IT','ITA','1');
INSERT INTO countries VALUES (106,'Jamaica','JM','JAM','1');
INSERT INTO countries VALUES (107,'Japan','JP','JPN','1');
INSERT INTO countries VALUES (108,'Jordan','JO','JOR','1');
INSERT INTO countries VALUES (109,'Kazakhstan','KZ','KAZ','1');
INSERT INTO countries VALUES (110,'Kenya','KE','KEN','1');
INSERT INTO countries VALUES (111,'Kiribati','KI','KIR','1');
INSERT INTO countries VALUES (112,'Korea, Democratic People\'s Republic of','KP','PRK','1');
INSERT INTO countries VALUES (113,'Korea, Republic of','KR','KOR','1');
INSERT INTO countries VALUES (114,'Kuwait','KW','KWT','1');
INSERT INTO countries VALUES (115,'Kyrgyzstan','KG','KGZ','1');
INSERT INTO countries VALUES (116,'Lao People\'s Democratic Republic','LA','LAO','1');
INSERT INTO countries VALUES (117,'Latvia','LV','LVA','1');
INSERT INTO countries VALUES (118,'Lebanon','LB','LBN','1');
INSERT INTO countries VALUES (119,'Lesotho','LS','LSO','1');
INSERT INTO countries VALUES (120,'Liberia','LR','LBR','1');
INSERT INTO countries VALUES (121,'Libyan Arab Jamahiriya','LY','LBY','1');
INSERT INTO countries VALUES (122,'Liechtenstein','LI','LIE','1');
INSERT INTO countries VALUES (123,'Lithuania','LT','LTU','1');
INSERT INTO countries VALUES (124,'Luxembourg','LU','LUX','1');
INSERT INTO countries VALUES (125,'Macau','MO','MAC','1');
INSERT INTO countries VALUES (126,'Macedonia, The Former Yugoslav Republic of','MK','MKD','1');
INSERT INTO countries VALUES (127,'Madagascar','MG','MDG','1');
INSERT INTO countries VALUES (128,'Malawi','MW','MWI','1');
INSERT INTO countries VALUES (129,'Malaysia','MY','MYS','1');
INSERT INTO countries VALUES (130,'Maldives','MV','MDV','1');
INSERT INTO countries VALUES (131,'Mali','ML','MLI','1');
INSERT INTO countries VALUES (132,'Malta','MT','MLT','1');
INSERT INTO countries VALUES (133,'Marshall Islands','MH','MHL','1');
INSERT INTO countries VALUES (134,'Martinique','MQ','MTQ','1');
INSERT INTO countries VALUES (135,'Mauritania','MR','MRT','1');
INSERT INTO countries VALUES (136,'Mauritius','MU','MUS','1');
INSERT INTO countries VALUES (137,'Mayotte','YT','MYT','1');
INSERT INTO countries VALUES (138,'Mexico','MX','MEX','1');
INSERT INTO countries VALUES (139,'Micronesia, Federated States of','FM','FSM','1');
INSERT INTO countries VALUES (140,'Moldova, Republic of','MD','MDA','1');
INSERT INTO countries VALUES (141,'Monaco','MC','MCO','1');
INSERT INTO countries VALUES (142,'Mongolia','MN','MNG','1');
INSERT INTO countries VALUES (143,'Montserrat','MS','MSR','1');
INSERT INTO countries VALUES (144,'Morocco','MA','MAR','1');
INSERT INTO countries VALUES (145,'Mozambique','MZ','MOZ','1');
INSERT INTO countries VALUES (146,'Myanmar','MM','MMR','1');
INSERT INTO countries VALUES (147,'Namibia','NA','NAM','1');
INSERT INTO countries VALUES (148,'Nauru','NR','NRU','1');
INSERT INTO countries VALUES (149,'Nepal','NP','NPL','1');
INSERT INTO countries VALUES (150,'Netherlands','NL','NLD','1');
INSERT INTO countries VALUES (151,'Netherlands Antilles','AN','ANT','1');
INSERT INTO countries VALUES (152,'New Caledonia','NC','NCL','1');
INSERT INTO countries VALUES (153,'New Zealand','NZ','NZL','1');
INSERT INTO countries VALUES (154,'Nicaragua','NI','NIC','1');
INSERT INTO countries VALUES (155,'Niger','NE','NER','1');
INSERT INTO countries VALUES (156,'Nigeria','NG','NGA','1');
INSERT INTO countries VALUES (157,'Niue','NU','NIU','1');
INSERT INTO countries VALUES (158,'Norfolk Island','NF','NFK','1');
INSERT INTO countries VALUES (159,'Northern Mariana Islands','MP','MNP','1');
INSERT INTO countries VALUES (160,'Norway','NO','NOR','1');
INSERT INTO countries VALUES (161,'Oman','OM','OMN','1');
INSERT INTO countries VALUES (162,'Pakistan','PK','PAK','1');
INSERT INTO countries VALUES (163,'Palau','PW','PLW','1');
INSERT INTO countries VALUES (164,'Panama','PA','PAN','1');
INSERT INTO countries VALUES (165,'Papua New Guinea','PG','PNG','1');
INSERT INTO countries VALUES (166,'Paraguay','PY','PRY','1');
INSERT INTO countries VALUES (167,'Peru','PE','PER','1');
INSERT INTO countries VALUES (168,'Philippines','PH','PHL','1');
INSERT INTO countries VALUES (169,'Pitcairn','PN','PCN','1');
INSERT INTO countries VALUES (170,'Poland','PL','POL','1');
INSERT INTO countries VALUES (171,'Portugal','PT','PRT','1');
INSERT INTO countries VALUES (172,'Puerto Rico','PR','PRI','1');
INSERT INTO countries VALUES (173,'Qatar','QA','QAT','1');
INSERT INTO countries VALUES (174,'Reunion','RE','REU','1');
INSERT INTO countries VALUES (175,'Romania','RO','ROM','1');
INSERT INTO countries VALUES (176,'Russian Federation','RU','RUS','1');
INSERT INTO countries VALUES (177,'Rwanda','RW','RWA','1');
INSERT INTO countries VALUES (178,'Saint Kitts and Nevis','KN','KNA','1');
INSERT INTO countries VALUES (179,'Saint Lucia','LC','LCA','1');
INSERT INTO countries VALUES (180,'Saint Vincent and the Grenadines','VC','VCT','1');
INSERT INTO countries VALUES (181,'Samoa','WS','WSM','1');
INSERT INTO countries VALUES (182,'San Marino','SM','SMR','1');
INSERT INTO countries VALUES (183,'Sao Tome and Principe','ST','STP','1');
INSERT INTO countries VALUES (184,'Saudi Arabia','SA','SAU','1');
INSERT INTO countries VALUES (185,'Senegal','SN','SEN','1');
INSERT INTO countries VALUES (186,'Seychelles','SC','SYC','1');
INSERT INTO countries VALUES (187,'Sierra Leone','SL','SLE','1');
INSERT INTO countries VALUES (188,'Singapore','SG','SGP', '4');
INSERT INTO countries VALUES (189,'Slovakia (Slovak Republic)','SK','SVK','1');
INSERT INTO countries VALUES (190,'Slovenia','SI','SVN','1');
INSERT INTO countries VALUES (191,'Solomon Islands','SB','SLB','1');
INSERT INTO countries VALUES (192,'Somalia','SO','SOM','1');
INSERT INTO countries VALUES (193,'South Africa','ZA','ZAF','1');
INSERT INTO countries VALUES (194,'South Georgia and the South Sandwich Islands','GS','SGS','1');
INSERT INTO countries VALUES (195,'Spain','ES','ESP','3');
INSERT INTO countries VALUES (196,'Sri Lanka','LK','LKA','1');
INSERT INTO countries VALUES (197,'St. Helena','SH','SHN','1');
INSERT INTO countries VALUES (198,'St. Pierre and Miquelon','PM','SPM','1');
INSERT INTO countries VALUES (199,'Sudan','SD','SDN','1');
INSERT INTO countries VALUES (200,'Suriname','SR','SUR','1');
INSERT INTO countries VALUES (201,'Svalbard and Jan Mayen Islands','SJ','SJM','1');
INSERT INTO countries VALUES (202,'Swaziland','SZ','SWZ','1');
INSERT INTO countries VALUES (203,'Sweden','SE','SWE','1');
INSERT INTO countries VALUES (204,'Switzerland','CH','CHE','1');
INSERT INTO countries VALUES (205,'Syrian Arab Republic','SY','SYR','1');
INSERT INTO countries VALUES (206,'Taiwan','TW','TWN','1');
INSERT INTO countries VALUES (207,'Tajikistan','TJ','TJK','1');
INSERT INTO countries VALUES (208,'Tanzania, United Republic of','TZ','TZA','1');
INSERT INTO countries VALUES (209,'Thailand','TH','THA','1');
INSERT INTO countries VALUES (210,'Togo','TG','TGO','1');
INSERT INTO countries VALUES (211,'Tokelau','TK','TKL','1');
INSERT INTO countries VALUES (212,'Tonga','TO','TON','1');
INSERT INTO countries VALUES (213,'Trinidad and Tobago','TT','TTO','1');
INSERT INTO countries VALUES (214,'Tunisia','TN','TUN','1');
INSERT INTO countries VALUES (215,'Turkey','TR','TUR','1');
INSERT INTO countries VALUES (216,'Turkmenistan','TM','TKM','1');
INSERT INTO countries VALUES (217,'Turks and Caicos Islands','TC','TCA','1');
INSERT INTO countries VALUES (218,'Tuvalu','TV','TUV','1');
INSERT INTO countries VALUES (219,'Uganda','UG','UGA','1');
INSERT INTO countries VALUES (220,'Ukraine','UA','UKR','1');
INSERT INTO countries VALUES (221,'United Arab Emirates','AE','ARE','1');
INSERT INTO countries VALUES (222,'United Kingdom','GB','GBR','1');
INSERT INTO countries VALUES (223,'United States','US','USA', '2');
INSERT INTO countries VALUES (224,'United States Minor Outlying Islands','UM','UMI','1');
INSERT INTO countries VALUES (225,'Uruguay','UY','URY','1');
INSERT INTO countries VALUES (226,'Uzbekistan','UZ','UZB','1');
INSERT INTO countries VALUES (227,'Vanuatu','VU','VUT','1');
INSERT INTO countries VALUES (228,'Vatican City State (Holy See)','VA','VAT','1');
INSERT INTO countries VALUES (229,'Venezuela','VE','VEN','1');
INSERT INTO countries VALUES (230,'Viet Nam','VN','VNM','1');
INSERT INTO countries VALUES (231,'Virgin Islands (British)','VG','VGB','1');
INSERT INTO countries VALUES (232,'Virgin Islands (U.S.)','VI','VIR','1');
INSERT INTO countries VALUES (233,'Wallis and Futuna Islands','WF','WLF','1');
INSERT INTO countries VALUES (234,'Western Sahara','EH','ESH','1');
INSERT INTO countries VALUES (235,'Yemen','YE','YEM','1');
INSERT INTO countries VALUES (236,'Yugoslavia','YU','YUG','1');
INSERT INTO countries VALUES (237,'Zaire','ZR','ZAR','1');
INSERT INTO countries VALUES (238,'Zambia','ZM','ZMB','1');
INSERT INTO countries VALUES (239,'Zimbabwe','ZW','ZWE','1');

INSERT INTO currencies VALUES (1,'US Dollar','USD','$','','.',',','2','1.0000', now());
INSERT INTO currencies VALUES (2,'Euro','EUR','','EUR','.',',','2','1.1036', now());

INSERT INTO languages VALUES (1,'English','en','icon.gif','english',1);

INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'banner_box.php', 1, 0, 300, 1, 127);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'banner_box2.php', 1, 1, 15, 1, 15);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'best_sellers.php', 1, 1, 30, 70, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'categories.php', 1, 0, 10, 10, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'currencies.php', 1, 1, 80, 60, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'document_categories.php', 1, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'featured.php', 1, 0, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'information.php', 1, 0, 50, 40, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'languages.php', 1, 1, 70, 50, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'manufacturers.php', 1, 0, 30, 20, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'manufacturer_info.php', 1, 1, 35, 95, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'more_information.php', 1, 0, 200, 200, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'music_genres.php', 1, 1, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'order_history.php', 0, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'product_notifications.php', 1, 1, 55, 85, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'record_companies.php', 1, 1, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'reviews.php', 1, 0, 40, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'search.php', 1, 1, 10, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'search_header.php', 0, 0, 0, 0, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'shopping_cart.php', 1, 1, 20, 30, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'specials.php', 1, 1, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'tell_a_friend.php', 1, 1, 65, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'whats_new.php', 1, 0, 20, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('blue_strip', 'whos_online.php', 1, 1, 200, 200, 1);

INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'banner_box.php', 1, 0, 300, 1, 127);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'banner_box2.php', 1, 1, 15, 1, 15);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'best_sellers.php', 1, 1, 30, 70, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'categories.php', 1, 0, 10, 10, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'currencies.php', 1, 1, 80, 60, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'document_categories.php', 1, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'featured.php', 1, 0, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'information.php', 1, 0, 50, 40, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'languages.php', 1, 1, 70, 50, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'manufacturers.php', 1, 0, 30, 20, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'manufacturer_info.php', 1, 1, 35, 95, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'more_information.php', 1, 0, 200, 200, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'music_genres.php', 1, 1, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'order_history.php', 0, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'product_notifications.php', 1, 1, 55, 85, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'record_companies.php', 1, 1, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'reviews.php', 1, 0, 40, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'search.php', 1, 1, 10, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'search_header.php', 0, 0, 0, 0, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'shopping_cart.php', 1, 1, 20, 30, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'specials.php', 1, 1, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'tell_a_friend.php', 1, 1, 65, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'whats_new.php', 1, 0, 20, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('classic', 'whos_online.php', 1, 1, 200, 200, 1);

INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'banner_box.php', 1, 0, 300, 1, 127);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'banner_box2.php', 1, 1, 15, 1, 15);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'best_sellers.php', 1, 1, 30, 70, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'categories.php', 1, 0, 10, 10, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'currencies.php', 1, 1, 80, 60, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'document_categories.php', 1, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'featured.php', 1, 0, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'information.php', 1, 0, 50, 40, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'languages.php', 1, 1, 70, 50, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'manufacturers.php', 1, 0, 30, 20, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'manufacturer_info.php', 1, 1, 35, 95, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'more_information.php', 1, 0, 200, 200, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'music_genres.php', 1, 1, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'order_history.php', 0, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'product_notifications.php', 1, 1, 55, 85, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'record_companies.php', 1, 1, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'reviews.php', 1, 0, 40, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'search.php', 1, 1, 10, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'search_header.php', 0, 0, 0, 0, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'shopping_cart.php', 1, 1, 20, 30, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'specials.php', 1, 1, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'tell_a_friend.php', 1, 1, 65, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'whats_new.php', 1, 0, 20, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('default_template_settings', 'whos_online.php', 1, 1, 200, 200, 1);

INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'banner_box.php', 1, 0, 300, 1, 127);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'banner_box2.php', 1, 1, 15, 1, 15);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'best_sellers.php', 1, 1, 30, 70, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'categories.php', 1, 0, 10, 10, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'currencies.php', 1, 1, 80, 60, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'featured.php', 1, 0, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'information.php', 1, 0, 50, 40, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'languages.php', 1, 1, 70, 50, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'manufacturers.php', 1, 0, 30, 20, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'manufacturer_info.php', 1, 1, 35, 95, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'more_information.php', 1, 0, 200, 200, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'my_broken_box.php', 1, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'order_history.php', 0, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'product_notifications.php', 1, 1, 55, 85, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'reviews.php', 1, 0, 40, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'search.php', 1, 1, 10, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'search_header.php', 0, 0, 0, 0, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'shopping_cart.php', 1, 1, 20, 30, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'specials.php', 1, 1, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'tell_a_friend.php', 1, 1, 65, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'whats_new.php', 1, 0, 20, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('template_default', 'whos_online.php', 1, 1, 200, 200, 1);

INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'banner_box2.php', 1, 1, 15, 1, 15);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'best_sellers.php', 1, 1, 30, 70, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'categories.php', 1, 0, 10, 10, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'currencies.php', 1, 1, 80, 60, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'information.php', 1, 0, 50, 40, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'languages.php', 1, 1, 70, 50, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'manufacturers.php', 1, 0, 30, 20, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'manufacturer_info.php', 1, 1, 35, 95, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'more_information.php', 1, 0, 100, 200, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'my_broken_box.php', 1, 0, 0, 1, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'order_history.php', 0, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'product_notifications.php', 1, 1, 55, 85, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'reviews.php', 1, 0, 40, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'search.php', 1, 1, 10, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'search_header.php', 0, 0, 0, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'shopping_cart.php', 1, 1, 20, 30, 1);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'specials.php', 1, 1, 45, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'tell_a_friend.php', 1, 1, 65, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'whats_new.php', 1, 0, 20, 0, 0);
INSERT INTO layout_boxes (layout_template, layout_box_name, layout_box_status, layout_box_location, layout_box_sort_order, layout_box_sort_order_single, layout_box_status_single) VALUES ('zencss', 'whos_online.php', 1, 1, 200, 200, 1);

INSERT INTO orders_status VALUES ( '1', '1', 'Pending');
INSERT INTO orders_status VALUES ( '2', '1', 'Processing');
INSERT INTO orders_status VALUES ( '3', '1', 'Delivered');
INSERT INTO orders_status VALUES ( '4', '1', 'Update');

INSERT INTO product_types VALUES (1, 'Product - General', 'product', '1', 'Y', '', now(), now());
INSERT INTO product_types VALUES (2, 'Product - Music', 'product_music', '1', 'Y', '', now(), now());
INSERT INTO product_types VALUES (3, 'Document - General', 'document_general', '3', 'N', '', now(), now());
INSERT INTO product_types VALUES (4, 'Document - Product', 'document_product', '3', 'Y', '', now(), now());
INSERT INTO product_types VALUES (5, 'Product - Free Shipping', 'product_free_shipping', '1', 'Y', '', now(), now());

INSERT INTO products_options_types (products_options_types_id, products_options_types_name) VALUES (0, 'Dropdown');
INSERT INTO products_options_types (products_options_types_id, products_options_types_name) VALUES (1, 'Text');
INSERT INTO products_options_types (products_options_types_id, products_options_types_name) VALUES (2, 'Radio');
INSERT INTO products_options_types (products_options_types_id, products_options_types_name) VALUES (3, 'Checkbox');
INSERT INTO products_options_types (products_options_types_id, products_options_types_name) VALUES (4, 'File');
INSERT INTO products_options_types (products_options_types_id, products_options_types_name) VALUES (5, 'Read Only');

INSERT INTO products_options_values (products_options_values_id, language_id, products_options_values_name) VALUES (0, 1, 'TEXT');

# USA/Florida
INSERT INTO tax_rates VALUES (1, 1, 1, 1, 7.0, 'FL TAX 7.0%', now(), now());
INSERT INTO geo_zones (geo_zone_id,geo_zone_name,geo_zone_description,date_added) VALUES (1,"Florida","Florida local sales tax zone",now());
INSERT INTO zones_to_geo_zones (association_id,zone_country_id,zone_id,geo_zone_id,date_added) VALUES (1,223,18,1,now());
INSERT INTO tax_class (tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (1, 'Taxable Goods', 'The following types of products are included non-food, services, etc', '2004-01-21 01:35:29', '2004-01-21 01:35:29');

# USA
INSERT INTO zones VALUES (1,223,'AL','Alabama');
INSERT INTO zones VALUES (2,223,'AK','Alaska');
INSERT INTO zones VALUES (3,223,'AS','American Samoa');
INSERT INTO zones VALUES (4,223,'AZ','Arizona');
INSERT INTO zones VALUES (5,223,'AR','Arkansas');
INSERT INTO zones VALUES (6,223,'AF','Armed Forces Africa');
INSERT INTO zones VALUES (7,223,'AA','Armed Forces Americas');
INSERT INTO zones VALUES (8,223,'AC','Armed Forces Canada');
INSERT INTO zones VALUES (9,223,'AE','Armed Forces Europe');
INSERT INTO zones VALUES (10,223,'AM','Armed Forces Middle East');
INSERT INTO zones VALUES (11,223,'AP','Armed Forces Pacific');
INSERT INTO zones VALUES (12,223,'CA','California');
INSERT INTO zones VALUES (13,223,'CO','Colorado');
INSERT INTO zones VALUES (14,223,'CT','Connecticut');
INSERT INTO zones VALUES (15,223,'DE','Delaware');
INSERT INTO zones VALUES (16,223,'DC','District of Columbia');
INSERT INTO zones VALUES (17,223,'FM','Federated States Of Micronesia');
INSERT INTO zones VALUES (18,223,'FL','Florida');
INSERT INTO zones VALUES (19,223,'GA','Georgia');
INSERT INTO zones VALUES (20,223,'GU','Guam');
INSERT INTO zones VALUES (21,223,'HI','Hawaii');
INSERT INTO zones VALUES (22,223,'ID','Idaho');
INSERT INTO zones VALUES (23,223,'IL','Illinois');
INSERT INTO zones VALUES (24,223,'IN','Indiana');
INSERT INTO zones VALUES (25,223,'IA','Iowa');
INSERT INTO zones VALUES (26,223,'KS','Kansas');
INSERT INTO zones VALUES (27,223,'KY','Kentucky');
INSERT INTO zones VALUES (28,223,'LA','Louisiana');
INSERT INTO zones VALUES (29,223,'ME','Maine');
INSERT INTO zones VALUES (30,223,'MH','Marshall Islands');
INSERT INTO zones VALUES (31,223,'MD','Maryland');
INSERT INTO zones VALUES (32,223,'MA','Massachusetts');
INSERT INTO zones VALUES (33,223,'MI','Michigan');
INSERT INTO zones VALUES (34,223,'MN','Minnesota');
INSERT INTO zones VALUES (35,223,'MS','Mississippi');
INSERT INTO zones VALUES (36,223,'MO','Missouri');
INSERT INTO zones VALUES (37,223,'MT','Montana');
INSERT INTO zones VALUES (38,223,'NE','Nebraska');
INSERT INTO zones VALUES (39,223,'NV','Nevada');
INSERT INTO zones VALUES (40,223,'NH','New Hampshire');
INSERT INTO zones VALUES (41,223,'NJ','New Jersey');
INSERT INTO zones VALUES (42,223,'NM','New Mexico');
INSERT INTO zones VALUES (43,223,'NY','New York');
INSERT INTO zones VALUES (44,223,'NC','North Carolina');
INSERT INTO zones VALUES (45,223,'ND','North Dakota');
INSERT INTO zones VALUES (46,223,'MP','Northern Mariana Islands');
INSERT INTO zones VALUES (47,223,'OH','Ohio');
INSERT INTO zones VALUES (48,223,'OK','Oklahoma');
INSERT INTO zones VALUES (49,223,'OR','Oregon');
INSERT INTO zones VALUES (50,223,'PW','Palau');
INSERT INTO zones VALUES (51,223,'PA','Pennsylvania');
INSERT INTO zones VALUES (52,223,'PR','Puerto Rico');
INSERT INTO zones VALUES (53,223,'RI','Rhode Island');
INSERT INTO zones VALUES (54,223,'SC','South Carolina');
INSERT INTO zones VALUES (55,223,'SD','South Dakota');
INSERT INTO zones VALUES (56,223,'TN','Tennessee');
INSERT INTO zones VALUES (57,223,'TX','Texas');
INSERT INTO zones VALUES (58,223,'UT','Utah');
INSERT INTO zones VALUES (59,223,'VT','Vermont');
INSERT INTO zones VALUES (60,223,'VI','Virgin Islands');
INSERT INTO zones VALUES (61,223,'VA','Virginia');
INSERT INTO zones VALUES (62,223,'WA','Washington');
INSERT INTO zones VALUES (63,223,'WV','West Virginia');
INSERT INTO zones VALUES (64,223,'WI','Wisconsin');
INSERT INTO zones VALUES (65,223,'WY','Wyoming');

# Canada
INSERT INTO zones VALUES (66,38,'AB','Alberta');
INSERT INTO zones VALUES (67,38,'BC','British Columbia');
INSERT INTO zones VALUES (68,38,'MB','Manitoba');
INSERT INTO zones VALUES (69,38,'NF','Newfoundland');
INSERT INTO zones VALUES (70,38,'NB','New Brunswick');
INSERT INTO zones VALUES (71,38,'NS','Nova Scotia');
INSERT INTO zones VALUES (72,38,'NT','Northwest Territories');
INSERT INTO zones VALUES (73,38,'NU','Nunavut');
INSERT INTO zones VALUES (74,38,'ON','Ontario');
INSERT INTO zones VALUES (75,38,'PE','Prince Edward Island');
INSERT INTO zones VALUES (76,38,'QC','Quebec');
INSERT INTO zones VALUES (77,38,'SK','Saskatchewan');
INSERT INTO zones VALUES (78,38,'YT','Yukon Territory');

# Germany
INSERT INTO zones VALUES (79,81,'NDS','Niedersachsen');
INSERT INTO zones VALUES (80,81,'BAW','Baden-Wrttemberg');
INSERT INTO zones VALUES (81,81,'BAY','Bayern');
INSERT INTO zones VALUES (82,81,'BER','Berlin');
INSERT INTO zones VALUES (83,81,'BRG','Brandenburg');
INSERT INTO zones VALUES (84,81,'BRE','Bremen');
INSERT INTO zones VALUES (85,81,'HAM','Hamburg');
INSERT INTO zones VALUES (86,81,'HES','Hessen');
INSERT INTO zones VALUES (87,81,'MEC','Mecklenburg-Vorpommern');
INSERT INTO zones VALUES (88,81,'NRW','Nordrhein-Westfalen');
INSERT INTO zones VALUES (89,81,'RHE','Rheinland-Pfalz');
INSERT INTO zones VALUES (90,81,'SAR','Saarland');
INSERT INTO zones VALUES (91,81,'SAS','Sachsen');
INSERT INTO zones VALUES (92,81,'SAC','Sachsen-Anhalt');
INSERT INTO zones VALUES (93,81,'SCN','Schleswig-Holstein');
INSERT INTO zones VALUES (94,81,'THE','Thringen');

# Austria
INSERT INTO zones VALUES (95,14,'WI','Wien');
INSERT INTO zones VALUES (96,14,'NO','Niedersterreich');
INSERT INTO zones VALUES (97,14,'OO','Obersterreich');
INSERT INTO zones VALUES (98,14,'SB','Salzburg');
INSERT INTO zones VALUES (99,14,'KN','K???nten');
INSERT INTO zones VALUES (100,14,'ST','Steiermark');
INSERT INTO zones VALUES (101,14,'TI','Tirol');
INSERT INTO zones VALUES (102,14,'BL','Burgenland');
INSERT INTO zones VALUES (103,14,'VB','Voralberg');

# Swizterland
INSERT INTO zones VALUES (104,204,'AG','Aargau');
INSERT INTO zones VALUES (105,204,'AI','Appenzell Innerrhoden');
INSERT INTO zones VALUES (106,204,'AR','Appenzell Ausserrhoden');
INSERT INTO zones VALUES (107,204,'BE','Bern');
INSERT INTO zones VALUES (108,204,'BL','Basel-Landschaft');
INSERT INTO zones VALUES (109,204,'BS','Basel-Stadt');
INSERT INTO zones VALUES (110,204,'FR','Freiburg');
INSERT INTO zones VALUES (111,204,'GE','Genf');
INSERT INTO zones VALUES (112,204,'GL','Glarus');
INSERT INTO zones VALUES (113,204,'JU','Graubnden');
INSERT INTO zones VALUES (114,204,'JU','Jura');
INSERT INTO zones VALUES (115,204,'LU','Luzern');
INSERT INTO zones VALUES (116,204,'NE','Neuenburg');
INSERT INTO zones VALUES (117,204,'NW','Nidwalden');
INSERT INTO zones VALUES (118,204,'OW','Obwalden');
INSERT INTO zones VALUES (119,204,'SG','St. Gallen');
INSERT INTO zones VALUES (120,204,'SH','Schaffhausen');
INSERT INTO zones VALUES (121,204,'SO','Solothurn');
INSERT INTO zones VALUES (122,204,'SZ','Schwyz');
INSERT INTO zones VALUES (123,204,'TG','Thurgau');
INSERT INTO zones VALUES (124,204,'TI','Tessin');
INSERT INTO zones VALUES (125,204,'UR','Uri');
INSERT INTO zones VALUES (126,204,'VD','Waadt');
INSERT INTO zones VALUES (127,204,'VS','Wallis');
INSERT INTO zones VALUES (128,204,'ZG','Zug');
INSERT INTO zones VALUES (129,204,'ZH','Zrich');

# Spain
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'A Corua','A Corua');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Alava','Alava');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Albacete','Albacete');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Alicante','Alicante');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Almeria','Almeria');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Asturias','Asturias');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Avila','Avila');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Badajoz','Badajoz');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Baleares','Baleares');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Barcelona','Barcelona');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Burgos','Burgos');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Caceres','Caceres');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cadiz','Cadiz');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cantabria','Cantabria');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Castellon','Castellon');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ceuta','Ceuta');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ciudad Real','Ciudad Real');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cordoba','Cordoba');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cuenca','Cuenca');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Girona','Girona');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Granada','Granada');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Guadalajara','Guadalajara');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Guipuzcoa','Guipuzcoa');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Huelva','Huelva');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Huesca','Huesca');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Jaen','Jaen');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'La Rioja','La Rioja');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Las Palmas','Las Palmas');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Leon','Leon');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Lleida','Lleida');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Lugo','Lugo');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Madrid','Madrid');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Malaga','Malaga');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Melilla','Melilla');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Murcia','Murcia');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Navarra','Navarra');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ourense','Ourense');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Palencia','Palencia');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Pontevedra','Pontevedra');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Salamanca','Salamanca');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Santa Cruz de Tenerife','Santa Cruz de Tenerife');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Segovia','Segovia');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Sevilla','Sevilla');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Soria','Soria');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Tarragona','Tarragona');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Teruel','Teruel');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Toledo','Toledo');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Valencia','Valencia');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Valladolid','Valladolid');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Vizcaya','Vizcaya');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Zamora','Zamora');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Zaragoza','Zaragoza');

DROP TABLE IF EXISTS paypal_session;
CREATE TABLE paypal_session (
  unique_id int(11) NOT NULL auto_increment,
  session_id text NOT NULL,
  saved_session blob NOT NULL,
  expiry int(17) NOT NULL default '0',
  PRIMARY KEY  (unique_id)
) TYPE=MyISAM;

DROP TABLE IF EXISTS paypal;
CREATE TABLE paypal (
  paypal_ipn_id int(11) unsigned NOT NULL auto_increment,
  zen_order_id int(11) unsigned NOT NULL,
  txn_type varchar(10) NOT NULL default '',
  reason_code varchar(15) default NULL,
  payment_type varchar(7) NOT NULL default '',
  payment_status varchar(17) NOT NULL default '',
  pending_reason varchar(14) default NULL,
  invoice varchar(64) default NULL,
  mc_currency char(3) NOT NULL default '',
  first_name varchar(32) NOT NULL default '',
  last_name varchar(32) NOT NULL default '',
  payer_business_name varchar(64) default NULL,
  address_name varchar(32) default NULL,
  address_street varchar(64) default NULL,
  address_city varchar(32) default NULL,
  address_state varchar(32) default NULL,
  address_zip varchar(10) default NULL,
  address_country varchar(64) default NULL,
  address_status varchar(11) default NULL,
  payer_email varchar(96) NOT NULL default '',
  payer_id varchar(32) NOT NULL default '',
  payer_status varchar(10) NOT NULL default '',
  payment_date datetime NOT NULL default '0001-01-01 00:00:00',
  business varchar(96) NOT NULL default '',
  receiver_email varchar(96) NOT NULL default '',
  receiver_id varchar(32) NOT NULL default '',
  txn_id varchar(17) NOT NULL default '',
  parent_txn_id varchar(17) default NULL,
  num_cart_items tinyint(4) unsigned NOT NULL default '1',
  mc_gross decimal(7,2) NOT NULL default '0.00',
  mc_fee decimal(7,2) NOT NULL default '0.00',
  payment_gross decimal(7,2) default NULL,
  payment_fee decimal(7,2) default NULL,
  settle_amount decimal(7,2) default NULL,
  settle_currency char(3) default NULL,
  exchange_rate decimal(4,2) default NULL,
  notify_version decimal(2,1) NOT NULL default '0.0',
  verify_sign varchar(128) NOT NULL default '',
  last_modified datetime NOT NULL default '0001-01-01 00:00:00',
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  memo text,
  PRIMARY KEY (paypal_ipn_id,txn_id),
  KEY idx_paypal_paypal_ipn_id (paypal_ipn_id)
);


DROP TABLE IF EXISTS product_type_layout;
CREATE TABLE product_type_layout (
  configuration_id int(11) NOT NULL auto_increment,
  configuration_title text NOT NULL,
  configuration_key varchar(255) NOT NULL default '',
  configuration_value text NOT NULL,
  configuration_description text NOT NULL,
  product_type_id int(11) NOT NULL default '0',
  sort_order int(5) default NULL,
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  use_function text default NULL,
  set_function text default NULL,
  PRIMARY KEY  (configuration_id)
  )TYPE=MyISAM;

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Model Number', 'SHOW_PRODUCT_INFO_MODEL', '1', 'Display Model Number on Product Info 0= off 1= on', '1', '1', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Weight', 'SHOW_PRODUCT_INFO_WEIGHT', '1', 'Display Weight on Product Info 0= off 1= on', '1', '2', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Attribute Weight', 'SHOW_PRODUCT_INFO_WEIGHT_ATTRIBUTES', '1', 'Display Attribute Weight on Product Info 0= off 1= on', '1', '3', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Manufacturer', 'SHOW_PRODUCT_INFO_MANUFACTURER', '1', 'Display Manufacturer Name on Product Info 0= off 1= on', '1', '4', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Quantity in Shopping Cart', 'SHOW_PRODUCT_INFO_IN_CART_QTY', '1', 'Display Quantity in Current Shopping Cart on Product Info 0= off 1= on', '1', '5', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Quantity in Stock', 'SHOW_PRODUCT_INFO_QUANTITY', '1', 'Display Quantity in Stock on Product Info 0= off 1= on', '1', '6', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Count', 'SHOW_PRODUCT_INFO_REVIEWS_COUNT', '1', 'Display Product Reviews Count on Product Info 0= off 1= on', '1', '7', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Button', 'SHOW_PRODUCT_INFO_REVIEWS', '1', 'Display Product Reviews Button on Product Info 0= off 1= on', '1', '8', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Available', 'SHOW_PRODUCT_INFO_DATE_AVAILABLE', '1', 'Display Date Available on Product Info 0= off 1= on', '1', '9', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Added', 'SHOW_PRODUCT_INFO_DATE_ADDED', '1', 'Display Date Added on Product Info 0= off 1= on', '1', '10', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product URL', 'SHOW_PRODUCT_INFO_URL', '1', 'Display URL on Product Info 0= off 1= on', '1', '11', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Starting At text on Price', 'SHOW_PRODUCT_INFO_STARTING_AT', '1', 'Display Starting At text on products with attributes Product Info 0= off 1= on', '1', '12', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Tell a Friend button', 'SHOW_PRODUCT_INFO_TELL_A_FRIEND', '1', 'Display the Tell a Friend button on Product Info<br /><br />Note: Turning this setting off does not affect the Tell a Friend box in the columns and turning off the Tell a Friend box does not affect the button<br />0= off 1= on', '1', '15', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Image Status - Catalog', 'SHOW_PRODUCT_INFO_ALWAYS_FREE_SHIPPING_IMAGE_SWITCH', '0', 'Show the Free Shipping image/text in the catalog?', '1', '16', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'Yes\'), array(\'id\'=>\'0\', \'text\'=>\'No\')), ', now());
#admin defaults
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, use_function, set_function, date_added) VALUES ('Product Price Tax Class Default - When adding new products?', 'DEFAULT_PRODUCT_TAX_CLASS_ID', '0', 'What should the Product Price Tax Class Default ID be when adding new products?', '1', '100', '', '', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Virtual Default Status - Skip Shipping Address - When adding new products?', 'DEFAULT_PRODUCT_PRODUCTS_VIRTUAL', '0', 'Default Virtual Product status to be ON when adding new products?', '1', '101', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Default Status - Normal Shipping Rules - When adding new products?', 'DEFAULT_PRODUCT_PRODUCTS_IS_ALWAYS_FREE_SHIPPING', '0', 'What should the Default Free Shipping status be when adding new products?', '1', '102', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());


INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Model Number', 'SHOW_PRODUCT_MUSIC_INFO_MODEL', '1', 'Display Model Number on Product Info 0= off 1= on', '2', '1', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Weight', 'SHOW_PRODUCT_MUSIC_INFO_WEIGHT', '0', 'Display Weight on Product Info 0= off 1= on', '2', '2', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Attribute Weight', 'SHOW_PRODUCT_MUSIC_INFO_WEIGHT_ATTRIBUTES', '1', 'Display Attribute Weight on Product Info 0= off 1= on', '2', '3', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Artist', 'SHOW_PRODUCT_MUSIC_INFO_ARTIST', '1', 'Display Artists Name on Product Info 0= off 1= on', '2', '4', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Music Genre', 'SHOW_PRODUCT_MUSIC_INFO_GENRE', '1', 'Display Music Genre on Product Info 0= off 1= on', '2', '4', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Record Company', 'SHOW_PRODUCT_MUSIC_INFO_RECORD_COMPANY', '1', 'Display Recoprd Company on Product Info 0= off 1= on', '2', '4', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Artist', 'SHOW_PRODUCT_MUSIC_INFO_ARTIST', '1', 'Display Artists Name on Product Info 0= off 1= on', '2', '4', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Quantity in Shopping Cart', 'SHOW_PRODUCT_MUSIC_INFO_IN_CART_QTY', '1', 'Display Quantity in Current Shopping Cart on Product Info 0= off 1= on', '2', '5', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Quantity in Stock', 'SHOW_PRODUCT_MUSIC_INFO_QUANTITY', '0', 'Display Quantity in Stock on Product Info 0= off 1= on', '2', '6', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Count', 'SHOW_PRODUCT_MUSIC_INFO_REVIEWS_COUNT', '1', 'Display Product Reviews Count on Product Info 0= off 1= on', '2', '7', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Button', 'SHOW_PRODUCT_MUSIC_INFO_REVIEWS', '1', 'Display Product Reviews Button on Product Info 0= off 1= on', '2', '8', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Available', 'SHOW_PRODUCT_MUSIC_INFO_DATE_AVAILABLE', '1', 'Display Date Available on Product Info 0= off 1= on', '2', '9', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Added', 'SHOW_PRODUCT_MUSIC_INFO_DATE_ADDED', '1', 'Display Date Added on Product Info 0= off 1= on', '2', '10', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Starting At text on Price', 'SHOW_PRODUCT_MUSIC_INFO_STARTING_AT', '1', 'Display Starting At text on products with attributes Product Info 0= off 1= on', '2', '12', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Tell a Friend button', 'SHOW_PRODUCT_MUSIC_INFO_TELL_A_FRIEND', '1', 'Display the Tell a Friend button on Product Info<br /><br />Note: Turning this setting off does not affect the Tell a Friend box in the columns and turning off the Tell a Friend box does not affect the button<br />0= off 1= on', '2', '15', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Image Status - Catalog', 'SHOW_PRODUCT_MUSIC_INFO_ALWAYS_FREE_SHIPPING_IMAGE_SWITCH', '0', 'Show the Free Shipping image/text in the catalog?', '2', '16', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'Yes\'), array(\'id\'=>\'0\', \'text\'=>\'No\')), ', now());
#admin defaults
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, use_function, set_function, date_added) VALUES ('Product Price Tax Class Default - When adding new products?', 'DEFAULT_PRODUCT_MUSIC_TAX_CLASS_ID', '0', 'What should the Product Price Tax Class Default ID be when adding new products?', '2', '100', '', '', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Virtual Default Status - Skip Shipping Address - When adding new products?', 'DEFAULT_PRODUCT_MUSIC_PRODUCTS_VIRTUAL', '0', 'Default Virtual Product status to be ON when adding new products?', '2', '101', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Default Status - Normal Shipping Rules - When adding new products?', 'DEFAULT_PRODUCT_MUSIC_PRODUCTS_IS_ALWAYS_FREE_SHIPPING', '0', 'What should the Default Free Shipping status be when adding new products?', '2', '102', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());


INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Count', 'SHOW_DOCUMENT_GENERAL_INFO_REVIEWS_COUNT', '1', 'Display Product Reviews Count on Product Info 0= off 1= on', '3', '7', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Button', 'SHOW_DOCUMENT_GENERAL_INFO_REVIEWS', '1', 'Display Product Reviews Button on Product Info 0= off 1= on', '3', '8', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Available', 'SHOW_DOCUMENT_GENERAL_INFO_DATE_AVAILABLE', '1', 'Display Date Available on Product Info 0= off 1= on', '3', '9', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Added', 'SHOW_DOCUMENT_GENERAL_INFO_DATE_ADDED', '1', 'Display Date Added on Product Info 0= off 1= on', '3', '10', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Tell a Friend button', 'SHOW_DOCUMENT_GENERAL_INFO_TELL_A_FRIEND', '1', 'Display the Tell a Friend button on Product Info<br /><br />Note: Turning this setting off does not affect the Tell a Friend box in the columns and turning off the Tell a Friend box does not affect the button<br />0= off 1= on', '3', '15', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product URL', 'SHOW_DOCUMENT_GENERAL_INFO_URL', '1', 'Display URL on Product Info 0= off 1= on', '3', '11', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
#admin defaults


INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Model Number', 'SHOW_DOCUMENT_PRODUCT_INFO_MODEL', '1', 'Display Model Number on Product Info 0= off 1= on', '4', '1', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Weight', 'SHOW_DOCUMENT_PRODUCT_INFO_WEIGHT', '0', 'Display Weight on Product Info 0= off 1= on', '4', '2', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Attribute Weight', 'SHOW_DOCUMENT_PRODUCT_INFO_WEIGHT_ATTRIBUTES', '1', 'Display Attribute Weight on Product Info 0= off 1= on', '4', '3', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Manufacturer', 'SHOW_DOCUMENT_PRODUCT_INFO_MANUFACTURER', '1', 'Display Manufacturer Name on Product Info 0= off 1= on', '4', '4', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Quantity in Shopping Cart', 'SHOW_DOCUMENT_PRODUCT_INFO_IN_CART_QTY', '1', 'Display Quantity in Current Shopping Cart on Product Info 0= off 1= on', '4', '5', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Quantity in Stock', 'SHOW_DOCUMENT_PRODUCT_INFO_QUANTITY', '0', 'Display Quantity in Stock on Product Info 0= off 1= on', '4', '6', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Count', 'SHOW_DOCUMENT_PRODUCT_INFO_REVIEWS_COUNT', '1', 'Display Product Reviews Count on Product Info 0= off 1= on', '4', '7', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Button', 'SHOW_DOCUMENT_PRODUCT_INFO_REVIEWS', '1', 'Display Product Reviews Button on Product Info 0= off 1= on', '4', '8', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Available', 'SHOW_DOCUMENT_PRODUCT_INFO_DATE_AVAILABLE', '1', 'Display Date Available on Product Info 0= off 1= on', '4', '9', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Added', 'SHOW_DOCUMENT_PRODUCT_INFO_DATE_ADDED', '1', 'Display Date Added on Product Info 0= off 1= on', '4', '10', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product URL', 'SHOW_DOCUMENT_PRODUCT_INFO_URL', '1', 'Display URL on Product Info 0= off 1= on', '4', '11', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Starting At text on Price', 'SHOW_DOCUMENT_PRODUCT_INFO_STARTING_AT', '1', 'Display Starting At text on products with attributes Product Info 0= off 1= on', '4', '12', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Tell a Friend button', 'SHOW_DOCUMENT_PRODUCT_INFO_TELL_A_FRIEND', '1', 'Display the Tell a Friend button on Product Info<br /><br />Note: Turning this setting off does not affect the Tell a Friend box in the columns and turning off the Tell a Friend box does not affect the button<br />0= off 1= on', '4', '15', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Image Status - Catalog', 'SHOW_DOCUMENT_PRODUCT_INFO_ALWAYS_FREE_SHIPPING_IMAGE_SWITCH', '0', 'Show the Free Shipping image/text in the catalog?', '4', '16', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'Yes\'), array(\'id\'=>\'0\', \'text\'=>\'No\')), ', now());
#admin defaults
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, use_function, set_function, date_added) VALUES ('Product Price Tax Class Default - When adding new products?', 'DEFAULT_DOCUMENT_PRODUCT_TAX_CLASS_ID', '0', 'What should the Product Price Tax Class Default ID be when adding new products?', '4', '100', '', '', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Virtual Default Status - Skip Shipping Address - When adding new products?', 'DEFAULT_DOCUMENT_PRODUCT_PRODUCTS_VIRTUAL', '0', 'Default Virtual Product status to be ON when adding new products?', '4', '101', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Default Status - Normal Shipping Rules - When adding new products?', 'DEFAULT_DOCUMENT_PRODUCT_PRODUCTS_IS_ALWAYS_FREE_SHIPPING', '0', 'What should the Default Free Shipping status be when adding new products?', '4', '102', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());


INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Model Number', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_MODEL', '1', 'Display Model Number on Product Info 0= off 1= on', '5', '1', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Weight', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_WEIGHT', '0', 'Display Weight on Product Info 0= off 1= on', '5', '2', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Attribute Weight', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_WEIGHT_ATTRIBUTES', '1', 'Display Attribute Weight on Product Info 0= off 1= on', '5', '3', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Manufacturer', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_MANUFACTURER', '1', 'Display Manufacturer Name on Product Info 0= off 1= on', '5', '4', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Quantity in Shopping Cart', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_IN_CART_QTY', '1', 'Display Quantity in Current Shopping Cart on Product Info 0= off 1= on', '5', '5', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Quantity in Stock', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_QUANTITY', '1', 'Display Quantity in Stock on Product Info 0= off 1= on', '5', '6', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Count', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_REVIEWS_COUNT', '1', 'Display Product Reviews Count on Product Info 0= off 1= on', '5', '7', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Reviews Button', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_REVIEWS', '1', 'Display Product Reviews Button on Product Info 0= off 1= on', '5', '8', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Available', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_DATE_AVAILABLE', '0', 'Display Date Available on Product Info 0= off 1= on', '5', '9', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Date Added', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_DATE_ADDED', '1', 'Display Date Added on Product Info 0= off 1= on', '5', '10', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product URL', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_URL', '1', 'Display URL on Product Info 0= off 1= on', '5', '11', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Starting At text on Price', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_STARTING_AT', '1', 'Display Starting At text on products with attributes Product Info 0= off 1= on', '5', '12', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());

INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Show Product Tell a Friend button', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_TELL_A_FRIEND', '1', 'Display the Tell a Friend button on Product Info<br /><br />Note: Turning this setting off does not affect the Tell a Friend box in the columns and turning off the Tell a Friend box does not affect the button<br />0= off 1= on', '5', '15', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Image Status - Catalog', 'SHOW_PRODUCT_FREE_SHIPPING_INFO_ALWAYS_FREE_SHIPPING_IMAGE_SWITCH', '1', 'Show the Free Shipping image/text in the catalog?', '5', '16', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'Yes\'), array(\'id\'=>\'0\', \'text\'=>\'No\')), ', now());
#admin defaults
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, use_function, set_function, date_added) VALUES ('Product Price Tax Class Default - When adding new products?', 'DEFAULT_PRODUCT_FREE_SHIPPING_TAX_CLASS_ID', '0', 'What should the Product Price Tax Class Default ID be when adding new products?', '5', '100', '', '', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Virtual Default Status - Skip Shipping Address - When adding new products?', 'DEFAULT_PRODUCT_FREE_SHIPPING_PRODUCTS_VIRTUAL', '0', 'Default Virtual Product status to be ON when adding new products?', '5', '101', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());
INSERT INTO product_type_layout (configuration_title, configuration_key, configuration_value, configuration_description, product_type_id, sort_order, set_function, date_added) VALUES ('Product Free Shipping Default Status - Normal Shipping Rules - When adding new products?', 'DEFAULT_PRODUCT_FREE_SHIPPING_PRODUCTS_IS_ALWAYS_FREE_SHIPPING', '1', 'What should the Default Free Shipping status be when adding new products?', '5', '102', 'zen_cfg_select_drop_down(array(array(\'id\'=>\'1\', \'text\'=>\'True\'), array(\'id\'=>\'0\', \'text\'=>\'False\')), ', now());





# This creates the email archive table:
#
# Table structure for table `zen_email_archive`

DROP TABLE IF EXISTS email_archive;
CREATE TABLE email_archive (
  archive_id int(11) NOT NULL auto_increment,
  email_to_name varchar(96) NOT NULL default '',
  email_to_address varchar(96) NOT NULL default '',
  email_from_name varchar(96) NOT NULL default '',
  email_from_address varchar(96) NOT NULL default '',
  email_subject varchar(255) NOT NULL default '',
  email_html text NOT NULL,
  email_text text NOT NULL,
  date_sent datetime NOT NULL default '0001-01-01 00:00:00',
  module varchar(64) NOT NULL default '',
  PRIMARY KEY  (archive_id),
  KEY email_to (email_to_name),
  KEY module (email_subject)
);

#
# Create table for query_builder tool (audiences.php)
#
DROP TABLE IF EXISTS query_builder;
CREATE TABLE query_builder (
query_id INT( 11 ) NOT NULL AUTO_INCREMENT ,
query_category VARCHAR( 40 ) NOT NULL ,
query_name VARCHAR( 80 ) NOT NULL ,
query_description TEXT NOT NULL ,
query_string TEXT NOT NULL ,
query_keys_list TEXT NOT NULL ,
PRIMARY KEY ( query_id ) ,
UNIQUE ( query_name )
) COMMENT = 'Stores queries for re-use in Admin email and report modules';

## Insert the default queries for "all customers" and "all newsletter subscribers"
INSERT INTO query_builder ( query_id , query_category , query_name , query_description , query_string ) VALUES ( '1', 'email', 'All Customers', 'Returns all customers name and email address for sending mass emails (ie: for newsletters, coupons, GV\'s, messages, etc).', 'select customers_email_address, customers_firstname, customers_lastname from TABLE_CUSTOMERS order by customers_lastname, customers_firstname, customers_email_address');
INSERT INTO query_builder ( query_id , query_category , query_name , query_description , query_string ) VALUES ( '2', 'email,newsletters', 'All Newsletter Subscribers', 'Returns name and email address of newsletter subscribers', 'select customers_firstname, customers_lastname, customers_email_address from TABLE_CUSTOMERS where customers_newsletter = \'1\'');
INSERT INTO query_builder ( query_id , query_category , query_name , query_description , query_string ) VALUES ( '3', 'email,newsletters', 'Dormant Customers (>3months) (Subscribers)', 'Subscribers who HAVE purchased something, but have NOT purchased for at least three months.', 'select c.customers_email_address, c.customers_lastname, c.customers_firstname from TABLE_CUSTOMERS c, TABLE_ORDERS o where c.customers_newsletter = \'1\' AND c.customers_id = o.customers_id and o.date_purchased < subdate(now(),INTERVAL 3 MONTH) GROUP BY c.customers_email_address order by c.customers_lastname, c.customers_firstname ASC');
INSERT INTO query_builder ( query_id , query_category , query_name , query_description , query_string ) VALUES ( '4', 'email,newsletters', 'Active customers in past 3 months (Subscribers)', 'Newsletter subscribers who are also active customers (purchased something) in last 3 months.', 'select c.customers_email_address, c.customers_lastname, c.customers_firstname from TABLE_CUSTOMERS c, TABLE_ORDERS o where c.customers_newsletter = \'1\' AND c.customers_id = o.customers_id and o.date_purchased > subdate(now(),INTERVAL 3 MONTH) GROUP BY c.customers_email_address order by c.customers_lastname, c.customers_firstname ASC');
INSERT INTO query_builder ( query_id , query_category , query_name , query_description , query_string ) VALUES ( '5', 'email,newsletters', 'Active customers in past 3 months (Regardless of subscription status)', 'All active customers (purchased something) in last 3 months, ignoring newsletter-subscription status.', 'select c.customers_email_address, c.customers_lastname, c.customers_firstname from TABLE_CUSTOMERS c, TABLE_ORDERS o WHERE c.customers_id = o.customers_id and o.date_purchased > subdate(now(),INTERVAL 3 MONTH) GROUP BY c.customers_email_address order by c.customers_lastname, c.customers_firstname ASC');
#
# end of Query-Builder Setup
#
#
# Dumping data for table `zen_get_terms_to_filter`
#

INSERT INTO get_terms_to_filter VALUES ('manufacturers_id');
INSERT INTO get_terms_to_filter VALUES ('music_genre_id');
INSERT INTO get_terms_to_filter VALUES ('record_company_id');

#
# Table structure for table `project_version`
#

DROP TABLE IF EXISTS project_version;
CREATE TABLE project_version (
  project_version_id tinyint(3) NOT NULL auto_increment,
  project_version_key varchar(40) NOT NULL default '',
  project_version_major varchar(20) NOT NULL default '',
  project_version_minor varchar(20) NOT NULL default '',
  project_version_patch1 varchar(20) NOT NULL default '',
  project_version_patch2 varchar(20) NOT NULL default '',
  project_version_patch1_source varchar(20) NOT NULL default '',
  project_version_patch2_source varchar(20) NOT NULL default '',
  project_version_comment varchar(250) NOT NULL default '',
  project_version_date_applied datetime NOT NULL default '0001-01-01 01:01:01',
  PRIMARY KEY  (project_version_id),
  UNIQUE KEY project_version_key (project_version_key)
) TYPE=MyISAM COMMENT='Database Version Tracking';

#
# Dumping data for table `project_version`
#

INSERT INTO project_version (project_version_id, project_version_key, project_version_major, project_version_minor, project_version_patch1, project_version_patch1_source, project_version_patch2, project_version_patch2_source, project_version_comment, project_version_date_applied) VALUES (1, 'Zen-Cart Main', '1', '2.4', '', '', '', '', 'Fresh Installation', now());
INSERT INTO project_version (project_version_id, project_version_key, project_version_major, project_version_minor, project_version_patch1, project_version_patch1_source, project_version_patch2, project_version_patch2_source, project_version_comment, project_version_date_applied) VALUES (2, 'Zen-Cart Database', '1', '2.4', '', '', '', '', 'Fresh Installation', now());

DROP TABLE IF EXISTS project_version_history;
CREATE TABLE project_version_history (
  project_version_id tinyint(3) NOT NULL auto_increment,
  project_version_key varchar(40) NOT NULL default '',
  project_version_major varchar(20) NOT NULL default '',
  project_version_minor varchar(20) NOT NULL default '',
  project_version_patch varchar(20) NOT NULL default '',
  project_version_comment varchar(250) NOT NULL default '',
  project_version_date_applied datetime NOT NULL default '0001-01-01 01:01:01',
  PRIMARY KEY  (project_version_id)
) TYPE=MyISAM COMMENT='Database Version Tracking History';

INSERT INTO project_version_history (project_version_id, project_version_key, project_version_major, project_version_minor, project_version_patch, project_version_comment, project_version_date_applied) VALUES (1, 'Zen-Cart Main', '1', '2.4', '', 'Fresh Installation', now());
INSERT INTO project_version_history (project_version_id, project_version_key, project_version_major, project_version_minor, project_version_patch, project_version_comment, project_version_date_applied) VALUES (2, 'Zen-Cart Database', '1', '2.4', '', 'Fresh Installation', now());

DROP TABLE IF EXISTS paypal_payment_status;
CREATE TABLE paypal_payment_status (
  payment_status_id int(11) NOT NULL auto_increment,
  payment_status_name varchar(64) NOT NULL default '',
  PRIMARY KEY (payment_status_id)
);

INSERT INTO paypal_payment_status VALUES (1, 'Completed');
INSERT INTO paypal_payment_status VALUES (2, 'Pending');
INSERT INTO paypal_payment_status VALUES (3, 'Failed');
INSERT INTO paypal_payment_status VALUES (4, 'Denied');
INSERT INTO paypal_payment_status VALUES (5, 'Refunded');
INSERT INTO paypal_payment_status VALUES (6, 'Canceled_Reversal');
INSERT INTO paypal_payment_status VALUES (7, 'Reversed');


DROP TABLE IF EXISTS paypal_payment_status_history;
CREATE TABLE paypal_payment_status_history (
  payment_status_history_id int(11) NOT NULL auto_increment,
  paypal_ipn_id int(11) NOT NULL default '0',
  txn_id varchar(64) NOT NULL default '',
  parent_txn_id varchar(64) NOT NULL default '',
  payment_status varchar(17) NOT NULL default '',
  pending_reason varchar(14) default NULL,
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY (payment_status_history_id)
);

##### End of SQL setup for Zen Cart.

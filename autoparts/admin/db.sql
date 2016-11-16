/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50140
Source Host           : localhost:3306
Source Database       : tdmod

Target Server Type    : MYSQL
Target Server Version : 50140
File Encoding         : 65001

Date: 2015-01-23 15:07:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `TDM_CURS`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_CURS`;
CREATE TABLE `TDM_CURS` (
  `CODE` varchar(3) NOT NULL,
  `RATE` float(12,7) NOT NULL,
  `TEMPLATE` varchar(12) NOT NULL,
  `TRUNCATE` int(1) NOT NULL,
  PRIMARY KEY (`CODE`),
  KEY `CODE` (`CODE`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_CURS
-- ----------------------------
INSERT INTO `TDM_CURS` VALUES ('BYR', '230.7379913', '# p.', '4');
INSERT INTO `TDM_CURS` VALUES ('EUR', '0.0170500', '#€', '1');
INSERT INTO `TDM_CURS` VALUES ('RUB', '1.0000000', '# руб.', '2');
INSERT INTO `TDM_CURS` VALUES ('UAH', '0.3305500', '# грн.', '3');
INSERT INTO `TDM_CURS` VALUES ('USD', '0.0212900', '#$', '1');

-- ----------------------------
-- Table structure for `TDM_IM_COLUMNS`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_IM_COLUMNS`;
CREATE TABLE `TDM_IM_COLUMNS` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `SUPID` int(4) NOT NULL,
  `NUM` int(2) NOT NULL,
  `FIELD` varchar(16) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `SUPID` (`SUPID`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_IM_COLUMNS
-- ----------------------------

-- ----------------------------
-- Table structure for `TDM_IM_SUPPLIERS`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_IM_SUPPLIERS`;
CREATE TABLE `TDM_IM_SUPPLIERS` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(32) NOT NULL,
  `CODE` varchar(32) NOT NULL,
  `COLUMN_SEP` varchar(3) NOT NULL DEFAULT ';',
  `ARTBRA_SEP` varchar(3) NOT NULL,
  `ARTBRA_SIDE` int(1) NOT NULL DEFAULT '1',
  `ENCODE` varchar(9) NOT NULL DEFAULT 'CP1251',
  `FILE_PATH` varchar(256) NOT NULL,
  `FILE_NAME` varchar(32) NOT NULL,
  `FILE_PASSW` varchar(32) NOT NULL,
  `START_FROM` int(12) NOT NULL,
  `STOP_BEFORE` int(12) NOT NULL,
  `DELETE_ON_START` int(1) NOT NULL,
  `PRICE_EXTRA` int(4) NOT NULL,
  `CONSIDER_HOT` int(1) NOT NULL,
  `PRICE_ADD` float(12,2) NOT NULL,
  `PRICE_TYPE` int(3) NOT NULL,
  `MIN_AVAIL` int(4) NOT NULL,
  `MAX_DAY` int(4) NOT NULL,
  `DEF_BRAND` varchar(32) NOT NULL,
  `DEF_CURRENCY` varchar(3) NOT NULL,
  `DAY_ADD` int(4) NOT NULL,
  `DEF_AVAILABLE` int(4) NOT NULL,
  `DEF_STOCK` varchar(16) NOT NULL,
  PRIMARY KEY (`ID`,`CONSIDER_HOT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_IM_SUPPLIERS
-- ----------------------------

-- ----------------------------
-- Table structure for `TDM_LANGS`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_LANGS`;
CREATE TABLE `TDM_LANGS` (
  `LANG` char(2) NOT NULL,
  `CODE` char(32) NOT NULL,
  `VALUE` varchar(512) NOT NULL,
  `TYPE` tinyint(1) NOT NULL DEFAULT '0',
  `SYSTEM` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`LANG`,`CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_LANGS
-- ----------------------------
INSERT INTO `TDM_LANGS` VALUES ('en', 'About', 'About', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Active', 'Active', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add', 'Add', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Added_to_cart', 'Added to cart', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Additional_Information', 'Additional Information', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_days', 'Add days', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_days_webservices', 'Add to the delivery period specified number of days', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_fixed_amount', 'Add a fixed amount', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_new', 'Add new', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_new_supplier', 'Add new supplier', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_price', 'Add price', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_price_extra', 'Add price extra (discount)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_to_cart', 'Add to cart', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Add_to_price', 'Add to price', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Admin_panel_position', 'Admin panel position', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'All', 'All', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Allow_order_without_price', 'Allow order without price', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'All_fields_are_required', 'All fields are required', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'All_sections', 'All sections', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Analog', 'Analog', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Analogs_of_brand_number', 'Analog parts of manufacturer', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'and', 'and', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Any_name', 'Any name', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Applicability_to_model_cars', 'Applicability to model cars', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Apply', 'Apply', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Apply_discount_of_base_price', 'Apply a discount (margin) of the base price for the users of this group', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Apply_filter', 'Apply filter', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Archive_password', 'Archive password', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Article', 'Article', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Article_is_located', 'Article is located', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'As_default', 'As default', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Automatically_fillin_CODE_fields', 'Automatically fill in the empty [URL code] fields from original names (in the current language)', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Avail.', 'Avail.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Availability', 'Availability', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'A_required_field', 'A required field', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Back_brand_selection', 'Back to the brand selection', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Back_model_selection', 'Back to select a model', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Barcode', 'Barcode (EAN)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Basic_type_of_price', 'Basic type of price', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Before_import_start_delete', 'Before import start - delete the prices with this supplier <u>name</u>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Body', 'Body', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Bottom_SEO_text', 'Bottom SEO text', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Brand', 'Brand', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Cache_prices', 'Cache prices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Cancel', 'Cancel', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Capacity', 'Capacity', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Cars_only', 'Cars only', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Catalog', 'Catalog', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Characteristics', 'Characteristics', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Click_to_enlarge', 'Click to enlarge', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Clipping_cents', 'Clipping cents', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Close', 'Close', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Code', 'Code', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Columns_relations', 'Columns relations', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Column_separator', 'Column separator', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Commercial_vehicles', 'Commercial', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Component', 'Component', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Component_cache', 'Component cache', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'com_manufacturers_1', 'Manufacturer names separated by commas', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Contains', 'Contains', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Crosses', 'Crosses', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Crosses_direction', 'Crosses direction', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Cross_number', 'Cross number', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Currencies', 'Currencies', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Currency', 'Currency', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Current_CMS', 'Current CMS', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Cylinder', 'Cylinder', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Database_service', 'Module Database service', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Date', 'Date', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'DB_Editor', 'Module database editor ', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'DB_name', 'Data base name', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Dealer', 'Dealer', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Default_currency', 'Default currency', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Default_in_CSV', 'Default separator in CSV file is <b>;</b>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Default_lang', 'Default language', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Default_view', 'Default view', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Delete', 'Delete', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Delete_old_prices', 'Delete the old prices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Delete_this_Meta_record', 'Delete this SEO-Meta record', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Delete_this_records', 'Delete all this records', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Descriptions_&_tips', 'Descriptions and tips', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Descr_IMA_file_path', 'Specify the path (from site root) to the price list is downloaded to your server', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Descr_IM_file_path', 'Specify the path (from site root) to the price list is downloaded to your server, such as: <b>/myprices/prices.csv</b><br> \r\nEither the path to the file on the remote site:<br><b>http://some-site.com/import/prices.zip</b>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Discount', 'Discount', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'discount_margin_of_base_price', 'discount (margin) of the base price', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Downloading', 'Downloading', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Download_updates', 'Download updates', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Dtime', 'Term', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Dtime_delivery', 'Delivery period (days)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Edit', 'Edit', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Editor', 'Editor', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Enable_caching', 'Caching', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Encode', 'Encode', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Engine', 'Engine', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'English_phrase', 'English phrase', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Equally', 'Equally', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Error', 'Error', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Example', 'Example', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Exchange_rates', 'Exchange rates', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Files_prefix', 'Files prefix', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'File_name', 'File name', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'File_path', 'File path on server', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Filtered_by', 'Filtered by', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Filter_by_manufacturer', 'Filter by manufacturer', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'from', 'from', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Fuel', 'Fuel', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Full_path_to_images_folder', 'The full path to the folder of images and PDF files of TecDoc database. For example\r\n', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Full_sections_tree', 'Full sections tree', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Group', 'Group', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Grouped_by_letter', 'Grouped by letter if more', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Group_ID_of_CMS', 'Group <b>ID</b> of your CMS for binding', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Handler', 'Handler', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Help', 'Help', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Hide_items_without_prices', 'Hide items without prices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Hide_models', 'Hide models', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Hide_prices', 'Hide prices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Hide_prices_availability_0', 'Hide prices if the availability 0', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Hide_selected', 'Hide selected', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Hot_prices_without_discount', 'Hot prices without a discount', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Hp', 'Hp', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'If_brand_&_article_located', 'If brand & article located in same column', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'If_price_includes_headings', 'If the price-list includes column headings', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'If_price_includes_option_hot', 'If the price includes the option \"Hot\" - that extra (discount) does not apply', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'If_price_in_format_zip', 'If the price in a format zip, rar', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'if_seometa_not_set', 'if not set, then the default value is printed from the component settings', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Ignore_type_of_car', 'Ignore type of car', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Import', 'Import', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Import_analogs_records', 'Import records of analogs', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Import_master', 'Import master', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Info.', 'Info.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Information_about_brand', 'Information about this brand', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'is_already_exist', 'is already exist', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Items_on_page', 'Items on page', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Kg', 'Kg.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Kv', 'Kv', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'L.', 'l.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Language', 'Language', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Language_phrases_in_field', 'In this field you can specify <a href=\"langs.php\">language phrases</a> - which displays the text on the current site language', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Linguistic_phrases', 'Linguistic phrases', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'List_of_favourites', 'List of favourites', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Localization', 'Localization', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Login', 'Login', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Logout', 'Logout', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Lookup_analogues', 'Lookup analogues', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Main_sections', 'Main sections', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Main_settings', 'Main', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Manufacturer', 'Manufacturer', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Manufacturers', 'Manufacturers', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Max_days', 'Maximal days', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Max_days_limit', 'Do not take the prices if the delivery period specified above', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Min_avail', 'Minimal available', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Min_avail_limit', 'Do not take the prices if the available of less than the specified', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Model', 'Model', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Models_list', 'List of models', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Models_starting_with', 'Models starting with', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Model_selection', 'Model selection', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Module_settings', 'Module settings', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Name', 'Name', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'New_updates_available', 'New updates available', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'No', 'No', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Not_check_in_db_type_car', 'Do not check in the TecDoc DB there any parts for this car type in subsection - show all subsections', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'No_models', 'No models of this manufacturer', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'No_parts_for_model', 'Has no parts.., we will add them later', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'No_records', 'No records', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'No_updates_available', 'No new updates available...', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Number', 'Number', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Number_of_prices_requested', 'Number of prices requested from suppliers site - at one-time (when caching prices from web-service). If the whole selection quantity of items greater than this limit - you will be prompted for the price only for products on this page. Caching is not applied. ', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Number_type', 'Number type', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Number_visible_prices', 'Number of visible prices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Off_', 'Off', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'On_', 'On', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Options', 'Options', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Order', 'Order', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Original', 'Original', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'out_of', 'out of', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Page', 'Page', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Partner', 'Partner', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Parts_of_section', 'Parts of section', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Part_number', 'Part number', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Password', 'Password', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Pcs', 'Pcs.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Photo_count', 'Photo count', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Please_login', 'Please log in', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Power', 'Power', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Price', 'Price', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Prices', 'Prices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Price_code', 'Price code', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Price_date', 'Date', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Price_of_supplier', 'Price-list of supplier', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Price_options', 'Price options', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_COPY', 'Copy of the original', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_DAMAGED', 'Damaged', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_HOT', 'Hot sale', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_LITERS', 'Volume (liters)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_MINIMUM', 'Minimum number', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_NORETURN', 'No return', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_PERCENTGIVE', 'Deliverie percentage', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_PRICE_ID', 'Price ID', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_RESTORED', 'Restored', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_SET', 'Set (pcs.)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_USED', 'Used', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'PRICE_OPTION_WEIGHT', 'Weight', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Price_type', 'Price type', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Price_with_cents', 'Price with cents', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Public_view', 'Public view', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Query_limit', 'Query limit', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Rate', 'Rate', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Really_clear_all_DB_records', 'Really clear all DB records of this web-service', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Really_delete_record', 'Really delete record', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Record', 'Record', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Records_deleted', 'Records deleted', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Records_per_page', 'Records per page', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Record_added', 'Record added', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Record_deleted', 'Record deleted', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Record_updated', 'Record updated', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Refresh_component_cache', 'Refresh this component cache', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Related_numbers', 'Related numbers', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Rename_to', 'Rename to', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Required_three_columns', 'Required three columns: number, brand. price', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Retail', 'Retail', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Return_to_module_catalog', 'Return to module catalog', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Rounded_greater', 'Rounded to the greater whole', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Rounded_lower', 'Rounded to the lower whole', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Rounded_nearest', 'Rounded to the nearest whole', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Save', 'Save', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Search_button', 'Search', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Search_by_parts_number', 'Search by parts number', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Search_form_example', 'Example of <b>html</b> search form, for insert in the header of your CMS, see the file <b>../searchform.php</b>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Search_photo', 'Search photo', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Search_photo_in_google', 'Search photo in Google', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Section', 'Section', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sections_of_parts', 'Sections of parts', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Selected', 'Selected', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Select_manufacturer', 'Select manufacturer', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'select_model', 'select the model', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Separator_brand_article', 'Separator of brand & article', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Server', 'Server', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Settings', 'Settings', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Settings_default_seometa', 'Each module component generates metadata and page H1 automatically based on the following options below. Language phrases should be placed between the two characters # (pound). The right of each field - component generated derived phrases that can be used in templates.', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Settings_saved', 'The settings are saved', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Set_base_currency_rate', 'Rate of the <b>base currency</b> of your site should be equal to <b>1.00</b>. The rates ​​of other currencies specify as <b>reverse</b> (or forward) course from this base currency.', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_all', 'Show all', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_filter_by_brand', 'Show filter by brand', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_item_properties', 'Show item properties', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_more_prices', 'Show more prices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_more_properties', 'Show more properties', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_query_statistic', 'Show query statistic', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_search_form', 'Show search form', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_selected', 'Show selected', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_tabs', 'Show tabs', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Show_users_in_this_group', 'Show users in this group only the prices of this type <span class=\"tiptext\">(existing in the database)</span>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'SLeft', 'Left', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'sm', 'sm', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sort', 'Sort', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sort_brand_rating_price', 'Brand rating & price available', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sort_by', 'Sort by', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sort_by_default', 'Sort by default', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sort_description_price', 'Availability of description and prices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sort_lowest_delivery_time', 'Lowest delivery time', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sort_lowest_price', 'Lowest price', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Sort_photo_available', 'Photo available', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Spare_parts_catalog', 'Spare parts catalog', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'SRight', 'Right', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Start_from_line', 'Start from line', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Start_import', 'Start import', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Stock', 'Stock', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Subsections_of_parts', 'Subsections of parts', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Supplier', 'Supplier', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Suppliers', 'Suppliers', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Supplier_DB_records', 'Supplier DB records', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Symbolic_code', 'Symbolic code', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Table', 'Table', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Take_links', 'Take links (crosses)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'TecDoc_DB', 'TecDoc Data Base', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Tecdoc_module', 'TDM :: TecDoc module', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Template', 'Template', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Term_caching', 'Term caching', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'this', 'this', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Tips_available_for_administrator', 'Descriptions and tips are available in the module only for authorized administrator', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Title', 'Title', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Top_SEO_text', 'Top SEO text', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Total_items', 'Total items', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Total_records', 'Total records', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'to_pt', 'to p.t.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'to_the', 'to the', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Trade', 'Trade', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Type_of_engine', 'Type of engine', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Updates_installed', 'Updates installed', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Updates_installed_with_errors', 'Updates installed with errors', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Updates_period_expired_pay', 'Updates period expired: pay new', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Upload_new_file', 'Upload new file to the server', '1', '0');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Value', 'Value', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'View', 'View', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'visible_in_public_side', 'visible in the public side', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'visible_only_to_administrator', 'visible only to the administrator', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Warning', 'Warning', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Webservice', 'Webservice', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Webservices', 'Suppliers webservices', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Webservices_login', 'Taken from your web-service supplier', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Webservice_DB_records', 'Web-service DB records', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Weight_gr', 'Weight (gr.)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Wholesale', 'Wholesale', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Widgets_1', 'Widgets. The exchange rates for the current date', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Widgets_2', 'obtained online through web services banks', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'With_form_create_unique_SEO', 'With this form you can create a unique only for this page SEO-Meta data. To edit the template, automatically generated SEO-Meta data - go to the module settings section.', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'With_respect_to_base_currency', 'With respect to the base currency', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'WS_link_both', 'Both sides', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'WS_link_left', 'Left side', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'WS_link_right', 'Right side', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Year', 'Year', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Year_construction', 'Year of construction', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Your_prices_level', 'Your prices level', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'Your_server_uploads_limit', 'Limit of your server for file downloads', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_accessories', 'Accessories', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_air_conditioning', 'Air Conditioning', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_air_system', 'Compressed air system', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_auxiliary_drive', 'Power Take Off (PTO)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_axle_drive', 'Axle Drive', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_axle_mounting', 'Axle Mounting', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_belt_drive', 'Belt Drive', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_body', 'Body', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_brake_system', 'Brake System', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_carrier_equipment', 'Carrier equipment', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_clutch', 'Clutch', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_comfort', 'Comfort systems', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_cooling_system', 'Cooling System', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_electrics', 'Electrics', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_engine', 'Engine', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_exhaust_system', 'Exhaust System', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_filters', 'Filters', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_fuel_mixture', 'Fuel mixture formation', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_fuel_supply', 'Fuel supply system', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_glow_ignition', 'Glow ignition', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_headlight_washer', 'Headlight washer', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_heater', 'Heater', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_hybrid', 'Hybrid', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_information_system', 'Information system', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_interior', 'Interior equipment', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_lock', 'Locking system', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_maintenance_service', 'Maintenance Service parts', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_srs_system', 'Security Systems', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_steering', 'Steering', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_suspension', 'Suspension', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_towbar', 'Towbar', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_transmission', 'Transmission', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_wheels_tires', 'Wheels & tyres', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_wheel_drive', 'Wheel Drive', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('en', 'zS_windscreen_cleaning', 'Windscreen cleaning system', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'About', 'Описание', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Active', 'Активность', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add', 'Добавить', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Added_to_cart', 'Добавлен в корзину', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Additional_Information', 'Дополнительная информация', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_days', 'Добавить дней', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_days_webservices', 'Добавить к сроку доставки указанное количество дней', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_fixed_amount', 'Добавить фиксированную сумму', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_new', 'Добавить', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_new_supplier', 'Добавить нового поставщика', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_price', 'Добавить цену', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_price_extra', 'Добавить наценку (скидку)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_to_cart', 'Добавить в корзину', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Add_to_price', 'Добавить к цене', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Admin_panel_position', 'Расположение админ-панели', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'All', 'Все', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Allow_order_without_price', 'Разрешить заказ товара без цен', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'All_fields_are_required', 'Все поля обязательны для заполнения', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'All_sections', 'Все разделы', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Analog', 'Аналог', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Analogs_of_brand_number', 'Аналоги запчасти производителя', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'and', 'и', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Any_name', 'Любое название', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Applicability_to_model_cars', 'Применимость к моделям авто', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Apply', 'Применить', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Apply_discount_of_base_price', 'Применить скидку (наценку) от базовой цены для пользователей этой группы', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Apply_filter', 'Применить фильтр', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Archive_password', 'Пароль архива', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Article', 'Артикул', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Article_is_located', 'Артикул расположен', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'As_default', 'По умолчанию', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Automatically_fillin_CODE_fields', 'Заполнить автоматически пустые поля [URL code] из оригинальных названий (на текущем языке)', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Avail.', 'Нал.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Availability', 'Наличие', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'A_required_field', 'Не заполнено обязательное поле', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Back_brand_selection', 'Назад к выбору производителя авто', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Back_model_selection', 'Назад к выбору модели', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Barcode', 'Штрих код (EAN)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Basic_type_of_price', 'Базовый (основной) тип цены', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Before_import_start_delete', 'Перед началом импорта - удалить цены с <u>названием</u> этого поставщика', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Body', 'Кузов', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Bottom_SEO_text', 'Нижний SEO текст', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Brand', 'Бренд', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Cache_prices', 'Кэшировать цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Cancel', 'Отменить', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Capacity', 'Объём', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Cars_only', 'Легковые авто', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Catalog', 'Каталог', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Characteristics', 'Характеристики', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Click_to_enlarge', 'Увеличить', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Clipping_cents', 'Отсечение копеек', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Close', 'Закрыть', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Code', 'Код', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Columns_relations', 'Привязка колонок', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Column_separator', 'Разделитель колонок', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Commercial_vehicles', 'Коммерческий транспорт', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Component', 'Компонент', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Component_cache', 'Кэш компонента', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'com_manufacturers_1', 'Названия производителей через запятую', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Contains', 'Содержит', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Crosses', 'Кроссы', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Crosses_direction', 'Направление кроссировки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Cross_number', 'Кросс номер', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Currencies', 'Валюты', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Currency', 'Валюта', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Current_CMS', 'Текущая CMS', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Cylinder', 'Цил.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Database_service', 'Обслуживание базы данных модуля', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Date', 'Дата', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'DB_Editor', 'Редактор базы данных модуля', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'DB_name', 'Имя базы данных', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Dealer', 'Дилер', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Default_currency', 'Валюта по умолчанию', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Default_in_CSV', 'По умолчанию в CSV файле разделитель <b>;</b>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Default_lang', 'Язык по умолчанию', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Default_view', 'Вид по умолчанию', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Delete', 'Удалить', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Delete_old_prices', 'Удалять старые цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Delete_this_Meta_record', 'Удалить эту SEO-Meta запись', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Delete_this_records', 'Удалить все эти записи', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Descriptions_&_tips', 'Описания и подсказки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Descr_IMA_file_path', 'Укажите путь (от корня сайта) к файлу загруженному на ваш сервер', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Descr_IM_file_path', 'Укажите путь (от корня сайта) к прайсу загруженному на ваш сервер, например: <b>/myprices/prices.csv</b><br>  \r\nЛибо путь к файлу на удаленном сайте:<br><b>http://some-site.com/import/prices.zip</b>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Discount', 'Скидка', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'discount_margin_of_base_price', 'скидка (наценка) от базовой цены', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Downloading', 'Загрузка', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Download_updates', 'Установить обновления', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Dtime', 'Срок', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Dtime_delivery', 'Срок поставки (дней)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Edit', 'Редактировать', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Editor', 'Редактор', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Enable_caching', 'Кэширование', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Encode', 'Кодировка', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Engine', 'Двигатель', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'English_phrase', 'Фраза на английском', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Equally', 'Равно', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Error', 'Ошибка', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Example', 'Например', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Exchange_rates', 'Курсы валют', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Files_prefix', 'Префикс файлов', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'File_name', 'Имя файла', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'File_path', 'Путь к файлу на сервере', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Filtered_by', 'Отфильтровано по', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Filter_by_manufacturer', 'Фильтровать по производителю', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'from', 'от', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Fuel', 'Топливо', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Full_path_to_images_folder', 'Полный путь к папке картинок и PDF файлов базы TecDoc. Например', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Full_sections_tree', 'Полная ветка разделов', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Group', 'Группа', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Grouped_by_letter', 'Группировать по буквам если более', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Group_ID_of_CMS', '<b>ID</b> группы CMS для привязки', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Handler', 'Обработчик', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Help', 'Помощь', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Hide_items_without_prices', 'Скрыть товары без цен', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Hide_models', 'Скрыть модели', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Hide_prices', 'Скрыть цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Hide_prices_availability_0', 'Скрыть цены если наличие 0', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Hide_selected', 'Скрыть выбранные', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Hot_prices_without_discount', 'Распродажа без скидки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Hp', 'Лс', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'If_brand_&_article_located', 'Если бренд и артикул расположены в одной колонке', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'If_price_includes_headings', 'Если прайс содержит заголовки колонок', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'If_price_includes_option_hot', 'Если цена содержит опцию \"Распродажа\" - то наценку (скидку) не применять', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'If_price_in_format_zip', 'Если прайс в формате zip, rar', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'if_seometa_not_set', 'если не задано, то выведется значение по умолчанию - из настроек компонента', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Ignore_type_of_car', 'Не учитывать тип авто', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Import', 'Импорт', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Import_analogs_records', 'Импорт записей кроссов', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Import_master', 'Мастер импорта', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Info.', 'Инфо.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Information_about_brand', 'Информация об этом бредне', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'is_already_exist', 'уже существует', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Items_on_page', 'Товаров на странице', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Kg', 'Кг.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Kv', 'Кв', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'L.', 'л.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Language', 'Язык', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Language_phrases_in_field', 'В данном поле можно указывать <a href=\"langs.php\">языковые фразы</a> - которые отобразят текст на текущем языке сайта', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Linguistic_phrases', 'Языковые фразы', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'List_of_favourites', 'Список избранных', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Localization', 'Локализация', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Login', 'Логин', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Logout', 'Выход', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Lookup_analogues', 'Найти аналоги', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Main_sections', 'Основные разделы', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Main_settings', 'Основные', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Manufacturer', 'Производитель', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Manufacturers', 'Производители', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Max_days', 'Максимум дней доставки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Max_days_limit', 'Не принимать цены если срок доставки выше указанного', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Min_avail', 'Минимальное наличие', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Min_avail_limit', 'Не принимать цены если наличие ниже указанного', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Model', 'Модель', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Models_list', 'Список моделей', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Models_starting_with', 'Модели начиная с', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Model_selection', 'Выбор модели', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Module_settings', 'Настройки модуля', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Name', 'Название', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'New_updates_available', 'Доступны новые обновления', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'No', 'Нет', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Not_check_in_db_type_car', 'Не проверять в базе TecDoc есть ли запчасти на выбранный тип модели авто в подразделе - вывести все подразделы', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'No_models', 'Нет моделей этого производителя', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'No_parts_for_model', 'Пока что нет запчастей.., мы добавим их позже', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'No_records', 'Нет записей', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'No_updates_available', 'Пока что нет новых обновлений модуля для вас...', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Number', 'Номер', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Number_of_prices_requested', 'Количество запросов цен на сайт поставщика - за один раз (при включенном кэшировании цен веб-сервиса). Если во всей выборке количество товаров больше этого лимита - то будут запрошены цены только для товаров на текущей странице. Кэширование не будет применено.', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Number_type', 'Тип номера', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Number_visible_prices', 'Количество видимых цен', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Off_', 'Выкл.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'On_', 'Вкл.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Options', 'Опции', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Order', 'Заказать', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Original', 'Оригинальный', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'out_of', 'из', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Page', 'Страница', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Partner', 'Партнер', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Parts_of_section', 'Запчасти раздела', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Part_number', 'Номер запчасти', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Password', 'Пароль', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Pcs', 'Шт.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Photo_count', 'Количество фото', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Please_login', 'Пожалуйста, авторизуйтесь', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Power', 'Мощность', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Price', 'Цена', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Prices', 'Цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Price_code', 'Код прайса', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Price_date', 'Дата', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Price_of_supplier', 'Прайс-лист поставщика', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Price_options', 'Опции цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_COPY', 'Копия оригинала', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_DAMAGED', 'Есть повреждения', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_HOT', 'Распродажа', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_LITERS', 'Объём (литров)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_MINIMUM', 'Минимальное количество', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_NORETURN', 'Возврату не подлежит', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_PERCENTGIVE', 'Процент поставки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_PRICE_ID', 'ID цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_RESTORED', 'Восстановлен', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_SET', 'Комплектация (шт.)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_USED', 'Б/у', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'PRICE_OPTION_WEIGHT', 'Вес', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Price_type', 'Тип цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Price_with_cents', 'Цены с копейками', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Public_view', 'Публичная часть', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Query_limit', 'Лимит запроса', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Rate', 'Курс', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Really_clear_all_DB_records', 'Действительно удалить все DB записи веб-сервиса', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Really_delete_record', 'Действительно удалить запись', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Record', 'Запись', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Records_deleted', 'Записей удалено', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Records_per_page', 'Записей на странице', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Record_added', 'Запись добавлена', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Record_deleted', 'Запись удалена', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Record_updated', 'Запись обновлена', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Refresh_component_cache', 'Сбросить кэш этого компонента', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Related_numbers', 'Связанные номера', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Rename_to', 'Переименовать в', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Required_three_columns', 'Обязательны три колонки: артикул, бренд, цена', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Retail', 'Розница', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Return_to_module_catalog', 'Вернуться в каталог модуля', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Rounded_greater', 'Округлить к большему целому', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Rounded_lower', 'Округлить к меньшему целому', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Rounded_nearest', 'Округлить к ближайшему целому', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Save', 'Сохранить', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Search_button', 'Найти', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Search_by_parts_number', 'Поиск по номеру запчасти', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Search_form_example', 'Пример <b>html</b> формы поиска для для вставки в шапке вашей CMS смотрите в файле <b>../searchform.php</b>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Search_photo', 'Искать фото', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Search_photo_in_google', 'Искать фото в Google', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Section', 'Раздел', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sections_of_parts', 'Разделы запчастей', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Selected', 'Выбрано', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Select_manufacturer', 'Выбор производителя', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'select_model', 'выберите модель', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Separator_brand_article', 'Разделитель бренда и артикула', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Server', 'Сервер', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Settings', 'Настройки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Settings_default_seometa', 'Каждый компонент модуля генерирует метаданные и заголовок H1 страницы автоматически исходя из ниже следующих настроек. Языковые фразы следует помещать между двумя знаками # (решетка). Справа от каждого поля выведены генерируемые компонентом фразы которые можно использовать в шаблонах. Если для какой либо страницы заданы собственные метаданные то ниже следующие настройки шаблона метаданных не будут к ней применены.', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Settings_saved', 'Настройки сохранены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Set_base_currency_rate', 'Курс <b>основной валюты</b> вашего сайта должен быть равен <b>1.00</b>. Значения курса остальных валют укажите как <b>обратный</b> (или прямой) курс от этой основной валюты. ', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_all', 'Показать все', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_filter_by_brand', 'Показать фильтр по бренду', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_item_properties', 'Показывать характеристики товара', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_more_prices', 'Показать ещё цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_more_properties', 'Показать больше свойств', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_query_statistic', 'Показывать статистику', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_search_form', 'Показать строку поиска', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_selected', 'Показать выбранные', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_tabs', 'Показывать вкладки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Show_users_in_this_group', 'Показывать пользователям этой группы только цены этого типа <span class=\"tiptext\">(загруженные в базу цен модуля)</span>', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'SLeft', 'Слева', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'sm', 'см', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sort', 'Сорт.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sort_brand_rating_price', 'Рейтингу бренда и наличию цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sort_by', 'Сортировать по', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sort_by_default', 'Сортировка по умолчанию', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sort_description_price', 'Наличию описания и цены', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sort_lowest_delivery_time', 'Наименьшему сроку доставки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sort_lowest_price', 'Наименьшей цене', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Sort_photo_available', 'Наличию фото', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Spare_parts_catalog', 'Каталог авто запчастей', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'SRight', 'Справа', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Start_from_line', 'Начать со строки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Start_import', 'Импортировать', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Stock', 'Склад', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Subsections_of_parts', 'Подразделы запчастей', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Supplier', 'Поставщик', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Suppliers', 'Поставщики', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Supplier_DB_records', 'БД записи поставщика', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Symbolic_code', 'Символьный код', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Table', 'Таблица', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Take_links', 'Принимать кроссы', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'TecDoc_DB', 'База Данных TecDoc', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Tecdoc_module', 'TDM :: TecDoc модуль', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Template', 'Шаблон', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Term_caching', 'Срок кэширования', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'this', 'этот', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Tips_available_for_administrator', 'Описания и подсказки доступны в модуле только для авторизовавшегося администратора', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Title', 'Заголовок', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Top_SEO_text', 'Верхний SEO текст', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Total_items', 'Всего товаров', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Total_records', 'Всего записей', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'to_pt', 'до н.в.', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'to_the', 'по', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Trade', 'Торговый', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Type_of_engine', 'Тип двигателя', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Updates_installed', 'Обновления установлены', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Updates_installed_with_errors', 'Обновления установлены с ошибками', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Updates_period_expired_pay', 'Срок оплаты обновлений истек: оплатить', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Upload_new_file', 'Загрузить новый файл на сервер', '1', '0');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Value', 'Значение', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'View', 'Вид', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'visible_in_public_side', 'видимые в публичной части', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'visible_only_to_administrator', 'видно только администратору', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Warning', 'Внимание', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Webservice', 'Веб-сервис', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Webservices', 'Веб-сервисы поставщиков', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Webservices_login', 'Берется у поставщика вебсервиса', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Webservice_DB_records', 'БД записи веб-сервиса', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Weight_gr', 'Вес (гр.)', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Wholesale', 'Оптовый', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Widgets_1', 'Виджеты. Курсы валют на текущую дату', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Widgets_2', 'полученные онлайн через веб-сервисы банков', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'With_form_create_unique_SEO', 'С помощью данной формы можно создать уникальные только для этой страницы SEO-Meta данные. Что бы отредактировать шаблон автоматически генерируемых SEO-Meta данных всех страниц - перейдите в раздел настроек модуля.', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'With_respect_to_base_currency', 'По отношению к основной валюте', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'WS_link_both', 'Обе стороны', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'WS_link_left', 'Влево', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'WS_link_right', 'Вправо', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Year', 'Год', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Year_construction', 'Год выпуска', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Your_prices_level', 'Ваш уровень цен', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'Your_server_uploads_limit', 'Лимит вашего сервера на загрузку файлов', '1', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_accessories', 'Комплектующие', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_air_conditioning', 'Кондиционер', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_air_system', 'Пневматическая система', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_auxiliary_drive', 'Вспомогательная передача', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_axle_drive', 'Главная передача', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_axle_mounting', 'Подвеска оси', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_belt_drive', 'Ременный привод', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_body', 'Кузов', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_brake_system', 'Тормозная система', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_carrier_equipment', 'Оборудование для перевозки', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_clutch', 'Сцепление', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_comfort', 'Дополнительные удобства', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_cooling_system', 'Охлаждение', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_electrics', 'Электрика', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_engine', 'Двигатель', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_exhaust_system', 'Система выпуска', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_filters', 'Фильтр', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_fuel_mixture', 'Подготовка топливной смеси', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_fuel_supply', 'Система подачи топлива', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_glow_ignition', 'Зажигание', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_headlight_washer', 'Очистка фар', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_heater', 'Отопление и вентиляция', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_hybrid', 'Гибрид', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_information_system', 'Информационная система', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_interior', 'Интерьер', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_lock', 'Замок', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_maintenance_service', 'Детали для ТО', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_srs_system', 'Система безопасности SRS', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_steering', 'Рулевое управление', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_suspension', 'Амортизация', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_towbar', 'Прицепное оборудование', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_transmission', 'Коробка передач', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_wheels_tires', 'Колёса и шины', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_wheel_drive', 'Привод колеса', '0', '1');
INSERT INTO `TDM_LANGS` VALUES ('ru', 'zS_windscreen_cleaning', 'Очистка окон', '0', '1');

-- ----------------------------
-- Table structure for `TDM_LINKS`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_LINKS`;
CREATE TABLE `TDM_LINKS` (
  `PKEY1` varchar(64) NOT NULL,
  `BKEY1` varchar(32) NOT NULL,
  `AKEY1` varchar(32) NOT NULL,
  `PKEY2` varchar(64) NOT NULL,
  `BKEY2` varchar(32) NOT NULL,
  `AKEY2` varchar(32) NOT NULL,
  `SIDE` int(1) NOT NULL,
  `CODE` varchar(32) NOT NULL,
  PRIMARY KEY (`PKEY1`,`PKEY2`),
  KEY `PKEY1` (`PKEY1`,`SIDE`) USING HASH,
  KEY `PKEY2` (`PKEY2`,`SIDE`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_LINKS
-- ----------------------------

-- ----------------------------
-- Table structure for `TDM_PRICES`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_PRICES`;
CREATE TABLE `TDM_PRICES` (
  `BKEY` varchar(64) NOT NULL,
  `AKEY` varchar(64) NOT NULL,
  `ARTICLE` varchar(32) NOT NULL,
  `ALT_NAME` varchar(128) NOT NULL DEFAULT '',
  `BRAND` varchar(32) NOT NULL,
  `PRICE` float(12,2) NOT NULL,
  `TYPE` int(2) NOT NULL,
  `CURRENCY` varchar(3) NOT NULL,
  `DAY` int(4) NOT NULL,
  `AVAILABLE` int(4) NOT NULL,
  `SUPPLIER` varchar(32) NOT NULL,
  `STOCK` varchar(32) NOT NULL,
  `OPTIONS` varchar(64) NOT NULL,
  `CODE` varchar(32) NOT NULL,
  `DATE` varchar(10) NOT NULL,
  PRIMARY KEY (`BKEY`,`DAY`,`SUPPLIER`,`STOCK`,`TYPE`,`AKEY`,`OPTIONS`),
  KEY `AKEY` (`BKEY`,`AKEY`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_PRICES
-- ----------------------------

-- ----------------------------
-- Table structure for `TDM_SEOMETA`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_SEOMETA`;
CREATE TABLE `TDM_SEOMETA` (
  `LANG` int(2) NOT NULL,
  `URL` varchar(128) NOT NULL,
  `TITLE` varchar(128) DEFAULT NULL,
  `KEYWORDS` varchar(128) DEFAULT NULL,
  `DESCRIPTION` varchar(128) DEFAULT NULL,
  `H1` varchar(64) DEFAULT NULL,
  `TOPTEXT` text,
  `BOTTEXT` text,
  PRIMARY KEY (`URL`,`LANG`),
  KEY `URL` (`URL`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of TDM_SEOMETA
-- ----------------------------

-- ----------------------------
-- Table structure for `TDM_SETTINGS`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_SETTINGS`;
CREATE TABLE `TDM_SETTINGS` (
  `ITEM` varchar(32) NOT NULL DEFAULT '',
  `FIELD` varchar(32) NOT NULL DEFAULT '',
  `VALUE` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`ITEM`,`FIELD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_SETTINGS
-- ----------------------------
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'APANEL_POSITION', 'Top');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'CMS_INTEGRATION', 'NoCMS');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'CRON_KEY', '585980');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'DEFAULT_CURRENCY', 'RUB');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'DEFAULT_LANG', 'ru');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'MODELS_FROM', '1985');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_COPY', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_DAMAGED', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_HOT', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_LITERS', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_MINIMUM', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_NORETURN', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_PERCENTGIVE', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_RESTORED', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_SET', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_USED', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'OPTION_WEIGHT', '0');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'SHOW_SEARCHFORM', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'SHOW_STAT', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'TECDOC_DB_LOGIN', '');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'TECDOC_DB_NAME', 'tecdoc_2015_1q_noctm');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'TECDOC_DB_PASS', '');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'TECDOC_DB_SERVER', 'autodbase.ru:3306');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'TECDOC_FILES_PREFIX', '');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'USE_CACHE', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('module', 'VERSION', '3015');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_DISCOUNT_2', '-10');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_DISCOUNT_3', '-15');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_DISCOUNT_4', '0');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_DISCOUNT_5', '-5');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_GID_1', '1');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_GID_2', 'no');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_GID_3', 'no');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_GID_4', '-');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_GID_5', '-');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_TYPE_1', 'Retail');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_TYPE_2', 'Wholesale');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_TYPE_3', 'Partner');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_TYPE_4', 'Dealer');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_TYPE_5', 'Discount');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_VIEW_2', '2');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_VIEW_3', '2');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_VIEW_4', '2');
INSERT INTO `TDM_SETTINGS` VALUES ('pricetype', 'PRICE_VIEW_5', '2');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'ANALOGPARTS_DESCRIPTION', '#Analogs_of_brand_number#: SEARCH_BRAND - SEARCH_NUMBER: PARTS_LIST');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'ANALOGPARTS_H1', '#Analogs_of_brand_number#: SEARCH_BRAND - SEARCH_NUMBER');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'ANALOGPARTS_KEYWORDS', 'PARTS_LIST');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'ANALOGPARTS_TITLE', '#Analogs_of_brand_number#: SEARCH_BRAND - SEARCH_NUMBER');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'MANUFACTURERS_DESCRIPTION', '#Spare_parts_catalog#');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'MANUFACTURERS_H1', '#Select_manufacturer#');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'MANUFACTURERS_KEYWORDS', 'BRANDS_LIST');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'MANUFACTURERS_TITLE', '#Spare_parts_catalog# - #Select_manufacturer#');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'MODELS_DESCRIPTION', '#Model_selection#  #Manufacturer# BRAND');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'MODELS_H1', '#Model_selection# BRAND');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'MODELS_KEYWORDS', 'BRAND, MODELS_LIST');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'MODELS_TITLE', 'BRAND - MODELS_LIST');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SEARCHPARTS_DESCRIPTION', '#Search_by_parts_number#');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SEARCHPARTS_H1', '#Search_by_parts_number#:  SEARCH_NUMBER');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SEARCHPARTS_KEYWORDS', 'PARTS_LIST');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SEARCHPARTS_TITLE', '#Search_by_parts_number#:  SEARCH_NUMBER');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SECTIONPARTS_DESCRIPTION', 'SECTION - SUBSECTION: BRAND, MODEL, DATE, TYPE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SECTIONPARTS_H1', 'SUBSECTION: BRAND, MODEL');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SECTIONPARTS_KEYWORDS', 'BRAND,  MODEL, DATE, TYPE, SECTION, SUBSECTION,  PARTS_LIST');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SECTIONPARTS_TITLE', 'SECTION - SUBSECTION:  BRAND, MODEL');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SECTIONS_DESCRIPTION', '#Sections_of_parts#: BRAND - MODEL DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SECTIONS_H1', '#Sections_of_parts#: BRAND MODEL TYPE DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SECTIONS_KEYWORDS', 'BRAND, MODEL, TYPE, DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SECTIONS_TITLE', '#Sections_of_parts#: BRAND + MODEL TYPE DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SUBSECTIONS_DESCRIPTION', 'SECTION: BRAND - MODEL DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SUBSECTIONS_H1', 'SECTION: BRAND MODEL DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SUBSECTIONS_KEYWORDS', 'SECTION, BRAND, MODEL, TYPE, DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'SUBSECTIONS_TITLE', 'SECTION + BRAND + MODEL TYPE DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'TYPES_DESCRIPTION', 'BRAND MODEL DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'TYPES_H1', '#Type_of_engine#: BRAND MODEL DATE');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'TYPES_KEYWORDS', 'BRAND, MODEL');
INSERT INTO `TDM_SETTINGS` VALUES ('seometa', 'TYPES_TITLE', 'BRAND MODEL #Type_of_engine#');

-- ----------------------------
-- Table structure for `TDM_WS`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_WS`;
CREATE TABLE `TDM_WS` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(32) NOT NULL,
  `ACTIVE` int(1) NOT NULL,
  `SCRIPT` varchar(32) NOT NULL,
  `CACHE` int(1) NOT NULL,
  `CLIENT_ID` varchar(32) NOT NULL,
  `LOGIN` varchar(32) NOT NULL,
  `PASSW` varchar(32) NOT NULL,
  `QUERY_LIMIT` int(4) NOT NULL,
  `CURRENCY` varchar(3) NOT NULL,
  `TYPE` int(3) NOT NULL,
  `DAY_ADD` int(2) NOT NULL,
  `PRICE_ADD` float(12,2) NOT NULL,
  `PRICE_EXTRA` int(6) NOT NULL,
  `MIN_AVAIL` int(4) NOT NULL,
  `MAX_DAY` int(4) NOT NULL,
  `LINKS_TAKE` int(1) NOT NULL,
  `LINKS_SIDE` int(1) NOT NULL,
  `PRICE_CODE` varchar(32) NOT NULL,
  `REFRESH_TIME` int(12) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_WS
-- ----------------------------

-- ----------------------------
-- Table structure for `TDM_WS_TIME`
-- ----------------------------
DROP TABLE IF EXISTS `TDM_WS_TIME`;
CREATE TABLE `TDM_WS_TIME` (
  `SID` int(9) NOT NULL,
  `WSID` int(3) NOT NULL,
  `PKEY` varchar(64) NOT NULL,
  `TIME` int(10) NOT NULL,
  PRIMARY KEY (`SID`,`WSID`,`PKEY`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of TDM_WS_TIME
-- ----------------------------

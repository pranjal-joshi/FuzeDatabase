SELECT 'Starting Fuze-Database table maintainance engine.. ' as '';
SELECT 'Defragmenting all tables.. Please wait..' as '';
ALTER TABLE `after_pu` ENGINE = INNODB;
ALTER TABLE `calibration_table` ENGINE = INNODB;
ALTER TABLE `lot_table` ENGINE = INNODB;
ALTER TABLE `pcb_testing` ENGINE = INNODB;
ALTER TABLE `housing_table` ENGINE = INNODB;
ALTER TABLE `potting_table` ENGINE = INNODB;
ALTER TABLE `qa_table` ENGINE = INNODB;
ALTER TABLE `forum_table` ENGINE = INNODB;
ALTER TABLE `battery_table` ENGINE = INNODB;
ALTER TABLE `barcode_table` ENGINE = INNODB;
ALTER TABLE `vendor_pcb_series_table` ENGINE = INNODB;

SELECT 'Starting InnoDB table compression..' as '';
SET GLOBAL innodb_file_per_table=1;
SET GLOBAL innodb_file_format=Barracuda;
ALTER TABLE `after_pu` ROW_FORMAT=compressed;
ALTER TABLE `calibration_table` ROW_FORMAT=compressed;
ALTER TABLE `lot_table` ROW_FORMAT=compressed;
ALTER TABLE `pcb_testing` ROW_FORMAT=compressed;
ALTER TABLE `housing_table` ROW_FORMAT=compressed;
ALTER TABLE `qa_table` ROW_FORMAT=compressed;
ALTER TABLE `forum_table` ROW_FORMAT=compressed;
ALTER TABLE `battery_table` ROW_FORMAT=compressed;
ALTER TABLE `barcode_table` ROW_FORMAT=compressed;
ALTER TABLE `vendor_pcb_series_table` ROW_FORMAT=compressed;

SELECT 'Altering tables to normalize AUTO_INCREMENT..' as '';

SELECT 'Processing `after_pu` table..' as '';
ALTER TABLE `after_pu` DROP `_id`;
ALTER TABLE `after_pu` AUTO_INCREMENT = 1;
ALTER TABLE `after_pu` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `calibration_table` table..' as '';
ALTER TABLE `calibration_table` DROP `_id`;
ALTER TABLE `calibration_table` AUTO_INCREMENT = 1;
ALTER TABLE `calibration_table` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `lot_table` table..' as '';
ALTER TABLE `lot_table` DROP `_id`;
ALTER TABLE `lot_table` AUTO_INCREMENT = 1;
ALTER TABLE `lot_table` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `pcb_testing` table..' as '';
ALTER TABLE `pcb_testing` DROP `_id`;
ALTER TABLE `pcb_testing` AUTO_INCREMENT = 1;
ALTER TABLE `pcb_testing` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `housing_table` table..' as '';
ALTER TABLE `housing_table` DROP `_id`;
ALTER TABLE `housing_table` AUTO_INCREMENT = 1;
ALTER TABLE `housing_table` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `potting_table` table..' as '';
ALTER TABLE `potting_table` DROP `_id`;
ALTER TABLE `potting_table` AUTO_INCREMENT = 1;
ALTER TABLE `potting_table` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `qa_table` table..' as '';
ALTER TABLE `qa_table` DROP `_id`;
ALTER TABLE `qa_table` AUTO_INCREMENT = 1;
ALTER TABLE `qa_table` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `forum_table` table..' as '';
ALTER TABLE `forum_table` DROP `thread_id`;
ALTER TABLE `forum_table` AUTO_INCREMENT = 1;
ALTER TABLE `forum_table` ADD `thread_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `battery_table` table..' as '';
ALTER TABLE `battery_table` DROP `_id`;
ALTER TABLE `battery_table` AUTO_INCREMENT = 1;
ALTER TABLE `battery_table` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `barcode_table` table..' as '';
ALTER TABLE `barcode_table` DROP `_id`;
ALTER TABLE `barcode_table` AUTO_INCREMENT = 1;
ALTER TABLE `barcode_table` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Processing `vendor_pcb_series_table` table..' as '';
ALTER TABLE `vendor_pcb_series_table` DROP `_id`;
ALTER TABLE `vendor_pcb_series_table` AUTO_INCREMENT = 1;
ALTER TABLE `vendor_pcb_series_table` ADD `_id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

SELECT 'Done Processing all tables!' as '';
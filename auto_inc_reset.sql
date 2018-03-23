SELECT 'Starting Fuze-Database table maintainance engine.. Altering AUTO_INCREMENT..' as '';

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

SELECT 'Done Processing all tables!' as '';
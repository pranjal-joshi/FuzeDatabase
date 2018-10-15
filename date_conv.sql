SELECT 'Processing `pcb_testing` table..' as '';
ALTER TABLE `pcb_testing` ADD COLUMN `dcol` DATE;
UPDATE `pcb_testing` SET `dcol`=STR_TO_DATE(`record_date`, '%e %M, %Y');
ALTER TABLE `pcb_testing` DROP COLUMN `record_date`;
ALTER TABLE `pcb_testing` CHANGE COLUMN `dcol` `record_date` DATE;

SELECT 'Processing `housing_table` table..' as '';
ALTER TABLE `housing_table` ADD COLUMN `dcol` DATE;
UPDATE `housing_table` SET `dcol`=STR_TO_DATE(`record_date`, '%e %M, %Y');
ALTER TABLE `housing_table` DROP COLUMN `record_date`;
ALTER TABLE `housing_table` CHANGE COLUMN `dcol` `record_date` DATE;

SELECT 'Processing `potting_table` table..' as '';
ALTER TABLE `potting_table` ADD COLUMN `dcol` DATE;
UPDATE `potting_table` SET `dcol`=STR_TO_DATE(`record_date`, '%e %M, %Y');
ALTER TABLE `potting_table` DROP COLUMN `record_date`;
ALTER TABLE `potting_table` CHANGE COLUMN `dcol` `record_date` DATE;

SELECT 'Processing `after_pu` table..' as '';
ALTER TABLE `after_pu` ADD COLUMN `dcol` DATE;
UPDATE `after_pu` SET `dcol`=STR_TO_DATE(`record_date`, '%e %M, %Y');
ALTER TABLE `after_pu` DROP COLUMN `record_date`;
ALTER TABLE `after_pu` CHANGE COLUMN `dcol` `record_date` DATE;

SELECT 'Processing `calibration_table` table..' as '';
ALTER TABLE `calibration_table` ADD COLUMN `dcol` DATE;
UPDATE `calibration_table` SET `dcol`=STR_TO_DATE(`timestamp`, '%e %M, %Y');
ALTER TABLE `calibration_table` DROP COLUMN `timestamp`;
ALTER TABLE `calibration_table` CHANGE COLUMN `dcol` `timestamp` DATE;
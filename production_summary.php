<?php

	include('db_config.php');

	if(isset($_COOKIE['fuzeLogin'])) {

		if($_POST['task'] == 'check') {
			$sql = "SELECT * FROM `fuze_production_launch` WHERE `lot_no`='".$_POST['lot_no']."' AND `contract_no`='".$_POST['contract_no']."'";
			$res = mysqli_query($db, $sql);
			$cnt = mysqli_num_rows($res);
			if($cnt > 0) {
				echo "ok";
			}
			else {
				"invalid";
			}
		}
		elseif($_POST['task'] == 'save') {
			$tblSql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`fuze_production_record` ( `_id` INT NOT NULL AUTO_INCREMENT , `fuze_type` VARCHAR(4) NOT NULL , `fuze_diameter` VARCHAR(4) NOT NULL , `record_date` DATE NOT NULL , `stream` VARCHAR(4) NOT NULL , `operation` TEXT NOT NULL , `process_cnt` INT NOT NULL , `op_cnt` INT NOT NULL , `shift` VARCHAR(10) NOT NULL , `lot_no` SMALLINT NOT NULL , `remark` TEXT , PRIMARY KEY (`_id`)) ENGINE = InnoDB COMMENT = 'holds production & cumulative count info';";
			$tblRes = mysqli_query($db, $tblSql);

			$operationArray = array("VISUAL","HSG GND PIN","HSG UNMOULDED","HSG MOULDED","HEAD","BATTERY TINNING","HSG UNMOULDED","HSG MOULDED","FUZE BASE","FUZE ASSY","HEAD","VISUAL","FUZE FINAL");

			unset($_POST['summaryData']['0']);
			unset($_POST['summaryData']['1']);
			unset($_POST['summaryData']['2']);
			unset($_POST['summaryData']['3']);

			$fetchSql = "SELECT * FROM `fuze_production_launch` WHERE `lot_no`='".$_POST['lot_no']."'";
			$fetchRes = mysqli_query($db, $fetchSql);
			$fetchRow = mysqli_fetch_assoc($fetchRes);
			$fuze_type = $fetchRow['fuze_type'];
			$fuze_diameter = $fetchRow['fuze_diameter'];

			$delSql = "DELETE FROM `fuze_production_record` WHERE `record_date`=STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y') AND `shift`='".$_POST['shift']."'";
			$delRes = mysqli_query($db, $delSql);

			$sd = $_POST['summaryData'];

			print_r($sd);

			$addSql = "INSERT INTO `fuze_production_record` (`_id`,`fuze_type`,`fuze_diameter`,`record_date`,`stream`,`operation`,`process_cnt`,`op_cnt`,`shift`,`lot_no`,`remark`) VALUES 
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[0]."','".$sd['5']."','".$sd['6']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[1]."','".$sd['8']."','".$sd['9']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[2]."','".$sd['11']."','".$sd['12']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[3]."','".$sd['14']."','".$sd['15']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[4]."','".$sd['17']."','".$sd['18']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[5]."','".$sd['20']."','".$sd['21']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[6]."','".$sd['23']."','".$sd['24']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[7]."','".$sd['26']."','".$sd['27']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[8]."','".$sd['29']."','".$sd['30']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[9]."','".$sd['32']."','".$sd['33']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[10]."','".$sd['35']."','".$sd['36']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'S&A','".$operationArray[11]."','".$sd['38']."','".$sd['39']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', ''),
				(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'S&A','".$operationArray[12]."','".$sd['41']."','".$sd['42']."', 
				'".$_POST['shift']."', 
				'".$_POST['lot_no']."', '')
				";

				$addRes = mysqli_query($db, $addSql);

				if($addRes) {
					echo "ok";
				}
				else {
					echo "fail";
				}
		}
	}

?>
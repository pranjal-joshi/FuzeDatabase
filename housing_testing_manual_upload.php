<?php
	
	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		print_r($_POST);

		$s = str_replace("\"", "", strtoupper($_POST['jsonData']));
		$s = trim($s,"[]");
		$s = str_replace(" ", "", $s);
		$dataArray = explode(",", $s);

		$dataArray[0] = str_replace("O", "0", strtoupper($dataArray[0]));

		$sql = "CREATE TABLE IF NOT EXISTS`fuze_database`.`housing_table` ( `_id` INT NOT NULL AUTO_INCREMENT , `pcb_no` TEXT NULL DEFAULT NULL , `i` FLOAT NOT NULL , `vee` FLOAT NOT NULL , `vbat_pst` FLOAT NOT NULL , `pst_amp` FLOAT NOT NULL , `pst_wid` FLOAT NOT NULL , `mod_freq` FLOAT NOT NULL , `mod_dc` FLOAT NOT NULL , `mod_ac` FLOAT NOT NULL , `cap_charge` FLOAT NOT NULL , `vrf_amp` FLOAT NOT NULL , `vbat_vrf` FLOAT NOT NULL , `vbat_sil` FLOAT NOT NULL , `det_wid` FLOAT NOT NULL , `det_amp` FLOAT NOT NULL , `cycles` INT NOT NULL , `bpf_dc` FLOAT NOT NULL , `bpf_ac` FLOAT NOT NULL , `bpf_noise_ac` FLOAT NOT NULL , `bpf_noise_dc` FLOAT NOT NULL , `sil` FLOAT NOT NULL , `lvp` FLOAT NOT NULL , `pd_delay` FLOAT NOT NULL , `pd_det` FLOAT NOT NULL , `safe` VARCHAR(4) NOT NULL , `result` VARCHAR(4) NOT NULL , `record_date` TEXT NOT NULL, `op_name` TEXT NOT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB";

		$sqlResult = mysqli_query($db,$sql);

		$sqlAdd = "REPLACE INTO `housing_table` (`pcb_no`, `i`, `vee`, `vbat_pst`, `pst_amp`, `pst_wid`, `mod_freq`, `mod_dc`, `mod_ac`, `cap_charge`, `vrf_amp`, `vbat_vrf`, `vbat_sil`, `det_wid`, `det_amp`, `cycles`, `bpf_dc`, `bpf_ac`, `bpf_noise_dc`, `bpf_noise_ac`, `sil`, `lvp`, `pd_delay`, `pd_det`, `safe`, `result`, `op_name`) VALUES (";

		$cnt = 0;
		foreach ($dataArray as $value) {
			if($cnt<27) {									// don't read main lot n kit lot from form to make query
				$sqlAdd.= "'".$value."',";
			}
			$cnt++;
		}
		$cnt = 0;

		$sqlAdd = trim($sqlAdd,",");
		$sqlAdd.=");";

		print_r($sqlAdd);

		$res = mysqli_query($db,$sqlAdd);

		//$recordDateSql = "UPDATE `housing_table` SET `record_date` = '".$_POST['record_date']."' WHERE `pcb_no` = '".$dataArray[0]."'";

		$recordDateSql = "UPDATE `housing_table` SET `record_date` = STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y') WHERE `pcb_no` = '".$dataArray[0]."'";

		$dateRes = mysqli_query($db, $recordDateSql);

		if(!$res || !$dateRes) {
			die("fail");
		}
		else{

			// assign new dummy lot to added HSG - MainLot=0, KitLot=HSG
			/*
			$sql = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES 
			(NULL,
			'".$_COOKIE['fuzeType']."',
			'".$_COOKIE['fuzeDia']."',
			'0',
			'HSG',
			'".$dataArray[0]."',
			'60')";
			*/
			if($dataArray[25] == "PASS") 				// ADD to lot only if passed
			{
				$sql = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES 
				(NULL,
				'".$_COOKIE['fuzeType']."',
				'".$_COOKIE['fuzeDia']."',
				'".$_POST['main_lot']."',
				'".$_POST['kit_lot']."',
				'".$dataArray[0]."',
				'60')";

				$res = mysqli_query($db, $sql);
			}
			else {
				$sql = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES 
				(NULL,
				'".$_COOKIE['fuzeType']."',
				'".$_COOKIE['fuzeDia']."',
				'0',
				'HSG',
				'".$dataArray[0]."',
				'0')";

				$res = mysqli_query($db, $sql);
			}

			die("ok");
		}
	}
?>
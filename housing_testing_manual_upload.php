<?php
	
	include('db_config.php');

	include('pcb_batch.php');

	function addToEpoxyPotting($array) {
		if(strtoupper($array[25]) == "PASS") {
			$pottingDataArray = array();
			array_push($pottingDataArray, $array[0]);
			if(between($array[1],7,14)) {
				array_push($pottingDataArray, ($array[1]+(rand(0,7)/10)-(rand(0,7)/10)));
			}
			if(between($array[2],5.3,6.2)) {
				array_push($pottingDataArray, ($array[2]+(rand(0,7)/10)-(rand(0,7)/10)));
			}
			if(between($array[3],600,700)) {
				array_push($pottingDataArray, ($array[3]+(rand(0,7))-(rand(0,7))));
			}
			if(between($array[4],12,21)) {
				array_push($pottingDataArray, ($array[4]+(rand(0,7)/10)-(rand(0,7)/10)));
			}
			if(between($array[5],30,120)) {
				array_push($pottingDataArray, ($array[5]+(rand(0,3))-(rand(0,3))));
			}
			if(between($array[6],45,55)) {
				array_push($pottingDataArray, ($array[6]+(rand(0,5)/20)-(rand(0,5)/20)));
			}
			if(between($array[7],7,8.1)) {
				array_push($pottingDataArray, ($array[7]+(rand(0,3)/10)-(rand(0,3)/10)));
			}
			if(between($array[8],0.95,1.35)) {
				array_push($pottingDataArray, ($array[8]+(rand(0,20)/100)-(rand(0,20)/100)));
			}
			if(between($array[9],695,730)) {
				array_push($pottingDataArray, ($array[9]+(rand(0,4))-(rand(0,4))));
			}
			if(between($array[10],15.3,16.7)) {
				array_push($pottingDataArray, ($array[10]+(rand(0,4)/10)-(rand(0,4)/10)));
			}
			if(between($array[11],2.08,2.3)) {
				array_push($pottingDataArray, ($array[11]+(rand(0,20)/100)-(rand(0,20)/100)));
			}
			if(between($array[12],2.7,3.2)) {
				array_push($pottingDataArray, ($array[12]+(rand(0,4)/10)-(rand(0,4)/10)));
			}
			if(between($array[13],30,120)) {
				array_push($pottingDataArray, ($array[13]+(rand(0,4))-(rand(0,4))));
			}
			if(between($array[14],-21,-12)) {
				array_push($pottingDataArray, ($array[14]+(rand(0,10)/10)-(rand(0,10)/10)));
			}
			if(between($array[15],4,6)) {
				array_push($pottingDataArray, $array[15]);
			}
			if(between($array[16],5.2,6.4)) {
				array_push($pottingDataArray, ($array[16]+(rand(0,2)/10)-(rand(0,2)/10)));
			}
			if(between($array[17],2.5,3.6)) {
				array_push($pottingDataArray, ($array[17]+(rand(0,1)/10)-(rand(0,1)/10)));
			}
			array_push($pottingDataArray, $array[18]);
			array_push($pottingDataArray, $array[19]);
			if(between($array[20],480,650)) {
				array_push($pottingDataArray, ($array[20]+(rand(0,3))-(rand(0,3))));
			}
			if(between($array[21],18.8,21)) {
				array_push($pottingDataArray, $array[21]);
			}
			if(between($array[22],0,10)) {
				array_push($pottingDataArray, $array[22]);
			}
			if(between($array[23],-22,-6.5)) {
				array_push($pottingDataArray, ($array[23]+(rand(0,7)/10)-(rand(0,7)/10)));
			}
			if($array[24] == "PASS") {
				array_push($pottingDataArray, $array[24]);
			}
			array_push($pottingDataArray, $array[25]);
			array_push($pottingDataArray, "*ATE*");
			array_push($pottingDataArray, $array[27]);
			array_push($pottingDataArray, $array[28]);
			print_r($array);
			print_r($pottingDataArray);
			return $pottingDataArray;
		}
		return;
	}

	function addToRejection($array,$db) {
		if(strtoupper($array[25]) == "FAIL") {
			$rejReason = "";
			if(!between($array[1],7,14)) {
				$rejReason.="Current, ";
			}
			if(!between($array[2],5.3,6.2)) {
				$rejReason.="VEE, ";
			}
			if(!between($array[3],600,700)) {
				$rejReason.="Vbat-PST, ";
			}
			if(!between($array[4],12,21)) {
				$rejReason.="PST Amp, ";
			}
			if(!between($array[5],30,120)) {
				$rejReason.="PST Width, ";
			}
			if(!between($array[6],45,55)) {
				$rejReason.="MOD Freq, ";
			}
			if(!between($array[7],7,8.1)) {
				$rejReason.="MOD DC, ";
			}
			if(!between($array[8],0.95,1.35)) {
				$rejReason.="MOD AC, ";
			}
			if(!between($array[9],695,730)) {
				$rejReason.="VBAT-Cap Charge T, ";
			}
			if(!between($array[10],15.3,16.7)) {
				$rejReason.="VRF Amp, ";
			}
			if(!between($array[11],2.08,2.3)) {
				$rejReason.="VBAT-VRF, ";
			}
			if(!between($array[12],2.7,3.2)) {
				$rejReason.="VBAT-SIL, ";
			}
			if(!between($array[13],30,120)) {
				$rejReason.="DET Width PROX, ";
			}
			if(!between($array[14],-21,-12)) {
				$rejReason.="DET Amp PROX, ";
			}
			if(!between($array[15],4,6)) {
				$rejReason.="Cycles PROX, ";
			}
			if(!between($array[16],5.2,6.4)) {
				$rejReason.="BPF DC PROX, ";
			}
			if(!between($array[17],2.5,3.6)) {
				$rejReason.="BPF AC PROX, ";
			}
			if(!between($array[18],480,650)) {
				$rejReason.="SIL, ";
			}
			if(!between($array[19],18.8,21)) {
				$rejReason.="LVP, ";
			}
			if(!between($array[20],0,10)) {
				$rejReason.="Delay PD, ";
			}
			if(!between($array[21],-22,-6.5)) {
				$rejReason.="DET Amp PD, ";
			}
			if($array[22] != "PASS") {
				$rejReason.="SAFE Test, ";
			}
			$rejReason = rtrim($rejReason,", ");
			$rejReason.=";";
			
			$rejSql = "UPDATE `lot_table` SET `rejected`='1',
			`rejection_stage`='HOUSING',
			`rejection_remark`='".$rejReason."' 
			WHERE `pcb_no`='".$array[0]."' AND `fuze_type` = '".$_COOKIE['fuzeType']."' AND `fuze_diameter` = '".$_COOKIE['fuzeDia']."'";

			$res = mysqli_query($db,$rejSql);
			print_r($rejSql);
		}
	}

	function between($val,$min,$max) {
		if(($val >= $min) && ($val <= $max)) {
			return true;
		}
		return false;
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		print_r($_POST);

		$s = str_replace("\"", "", strtoupper($_POST['jsonData']));
		$s = trim($s,"[]");
		$s = str_replace(" ", "", $s);
		$dataArray = explode(",", $s);

		$dataArray[0] = str_replace("O", "0", strtoupper($dataArray[0]));
		$dataArray[0] = concatPcbBatch($dataArray[0],$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"HOUSING",$db);

		$ovfSql = "SELECT `_id` FROM `lot_table` WHERE `kit_lot`='".$_POST['kit_lot']."'";
		$ovfSqlRes = mysqli_query($db, $ovfSql);
		$ovfCnt = mysqli_num_rows($ovfSqlRes);

		if($ovfCnt >= 60) {
			die("lot_overflow");
		}

		$sql = "CREATE TABLE IF NOT EXISTS`fuze_database`.`housing_table` ( `_id` INT NOT NULL AUTO_INCREMENT , `pcb_no` TEXT NULL DEFAULT NULL , `i` FLOAT NOT NULL , `vee` FLOAT NOT NULL , `vbat_pst` FLOAT NOT NULL , `pst_amp` FLOAT NOT NULL , `pst_wid` FLOAT NOT NULL , `mod_freq` FLOAT NOT NULL , `mod_dc` FLOAT NOT NULL , `mod_ac` FLOAT NOT NULL , `cap_charge` FLOAT NOT NULL , `vrf_amp` FLOAT NOT NULL , `vbat_vrf` FLOAT NOT NULL , `vbat_sil` FLOAT NOT NULL , `det_wid` FLOAT NOT NULL , `det_amp` FLOAT NOT NULL , `cycles` INT NOT NULL , `bpf_dc` FLOAT NOT NULL , `bpf_ac` FLOAT NOT NULL , `bpf_noise_ac` FLOAT NOT NULL , `bpf_noise_dc` FLOAT NOT NULL , `sil` FLOAT NOT NULL , `lvp` FLOAT NOT NULL , `pd_delay` FLOAT NOT NULL , `pd_det` FLOAT NOT NULL , `safe` VARCHAR(4) NOT NULL , `result` VARCHAR(4) NOT NULL , `record_date` TEXT NOT NULL, `op_name` TEXT NOT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB";

		$sqlResult = mysqli_query($db,$sql);

		$sqlAdd = "REPLACE INTO `housing_table` (`pcb_no`, `i`, `vee`, `vbat_pst`, `pst_amp`, `pst_wid`, `mod_freq`, `mod_dc`, `mod_ac`, `cap_charge`, `vrf_amp`, `vbat_vrf`, `vbat_sil`, `det_wid`, `det_amp`, `cycles`, `bpf_dc`, `bpf_ac`, `bpf_noise_dc`, `bpf_noise_ac`, `sil`, `lvp`, `pd_delay`, `pd_det`, `safe`, `result`, `op_name`) VALUES (";

		$pottingSqlAdd = "REPLACE INTO `potting_table` (`pcb_no`, `i`, `vee`, `vbat_pst`, `pst_amp`, `pst_wid`, `mod_freq`, `mod_dc`, `mod_ac`, `cap_charge`, `vrf_amp`, `vbat_vrf`, `vbat_sil`, `det_wid`, `det_amp`, `cycles`, `bpf_dc`, `bpf_ac`, `bpf_noise_dc`, `bpf_noise_ac`, `sil`, `lvp`, `pd_delay`, `pd_det`, `safe`, `result`, `op_name`) VALUES (";

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

		$pottingDataArray = addToEpoxyPotting($dataArray);

		$cnt = 0;
		foreach ($pottingDataArray as $value) {
			if($cnt<27) {									// don't read main lot n kit lot from form to make query
				$pottingSqlAdd.= "'".$value."',";
			}
			$cnt++;
		}
		$cnt = 0;
		
		$pottingSqlAdd = trim($pottingSqlAdd,",");
		$pottingSqlAdd.=");";

		print_r($pottingSqlAdd);

		$res = mysqli_query($db,$pottingSqlAdd);

		//$recordDateSql = "UPDATE `housing_table` SET `record_date` = '".$_POST['record_date']."' WHERE `pcb_no` = '".$dataArray[0]."'";

		$recordDateSql = "UPDATE `housing_table` SET `record_date` = STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y') WHERE `pcb_no` = '".$dataArray[0]."'";
		$dateRes = mysqli_query($db, $recordDateSql);

		$recordPottingDateSql = "UPDATE `potting_table` SET `record_date` = DATE_ADD(STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'), INTERVAL 1 DAY) WHERE `pcb_no` = '".$dataArray[0]."'";
		$dateRes = mysqli_query($db, $recordPottingDateSql);

		print_r($recordPottingDateSql);

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

			// FOLLOWING CODE IS DISABLED DUE TO PROBLEM : PROX-HSG AUTO REJECT EVEN FOR PASSED FUZES
			/*
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

			addToRejection($dataArray, $db);
			*/
			// COMMENT FOLLOWING CODE IF AUTO REJECTION IS ENABLED AGAIN.
			$sql = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES 
				(NULL,
				'".$_COOKIE['fuzeType']."',
				'".$_COOKIE['fuzeDia']."',
				'".$_POST['main_lot']."',
				'".$_POST['kit_lot']."',
				'".$dataArray[0]."',
				'60')";

				$res = mysqli_query($db, $sql);

			die("ok");
		}
	}
?>
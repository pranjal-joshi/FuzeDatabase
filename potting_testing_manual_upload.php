<?php
	
	include('db_config.php');

	include('pcb_batch.php');

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
			`rejection_stage`='POTTING',
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

		$s = str_replace("\"", "", strtoupper($_POST['jsonData']));
		$s = trim($s,"[]");
		$s = str_replace(" ", "", $s);
		$dataArray = explode(",", $s);

		$dataArray[0] = str_replace("O", "0", strtoupper($dataArray[0]));
		$dataArray[0] = concatPcbBatch($dataArray[0],$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"POTTING",$db);

		print_r($dataArray);

		$sql = "CREATE TABLE IF NOT EXISTS`fuze_database`.`potting_table` ( `_id` INT NOT NULL AUTO_INCREMENT , `pcb_no` TEXT NULL DEFAULT NULL , `i` FLOAT NOT NULL , `vee` FLOAT NOT NULL , `vbat_pst` FLOAT NOT NULL , `pst_amp` FLOAT NOT NULL , `pst_wid` FLOAT NOT NULL , `mod_freq` FLOAT NOT NULL , `mod_dc` FLOAT NOT NULL , `mod_ac` FLOAT NOT NULL , `cap_charge` FLOAT NOT NULL , `vrf_amp` FLOAT NOT NULL , `vbat_vrf` FLOAT NOT NULL , `vbat_sil` FLOAT NOT NULL , `det_wid` FLOAT NOT NULL , `det_amp` FLOAT NOT NULL , `cycles` INT NOT NULL , `bpf_dc` FLOAT NOT NULL , `bpf_ac` FLOAT NOT NULL , `bpf_noise_ac` FLOAT NOT NULL , `bpf_noise_dc` FLOAT NOT NULL , `sil` FLOAT NOT NULL , `lvp` FLOAT NOT NULL , `pd_delay` FLOAT NOT NULL , `pd_det` FLOAT NOT NULL , `safe` VARCHAR(4) NOT NULL , `result` VARCHAR(4) NOT NULL , `record_date` TEXT NOT NULL, `op_name` TEXT NOT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB";

		$sqlResult = mysqli_query($db,$sql);

		$sqlAdd = "REPLACE INTO `potting_table` (`pcb_no`, `i`, `vee`, `vbat_pst`, `pst_amp`, `pst_wid`, `mod_freq`, `mod_dc`, `mod_ac`, `cap_charge`, `vrf_amp`, `vbat_vrf`, `vbat_sil`, `det_wid`, `det_amp`, `cycles`, `bpf_dc`, `bpf_ac`, `bpf_noise_dc`, `bpf_noise_ac`, `sil`, `lvp`, `pd_delay`, `pd_det`, `safe`, `result`, `op_name`) VALUES (";

		foreach ($dataArray as $value) {
			$sqlAdd.= "'".$value."',";
		}

		$sqlAdd = trim($sqlAdd,",");
		$sqlAdd.=");";

		$res = mysqli_query($db,$sqlAdd);

		//$recordDateSql = "UPDATE `potting_table` SET `record_date` = '".$_POST['record_date']."' WHERE `pcb_no` = '".$dataArray[0]."'";

		$recordDateSql = "UPDATE `potting_table` SET `record_date` = STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y') WHERE `pcb_no` = '".$dataArray[0]."'";

		$dateRes = mysqli_query($db, $recordDateSql);

		if(!$res || !$dateRes) {
			die("fail");
		}
		else{
			addToRejection($dataArray, $db);
			die("ok");
		}
	}
	else {
		die("
				<center>
					</br>
					<h3 style='color: red'>This is suspecious! Unauthorized access to this page.</h3>
					</br>
					<a href='index.php'>Go back</a> to Login Page
				</center>
			");
	}
?>
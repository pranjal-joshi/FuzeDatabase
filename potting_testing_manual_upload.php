<?php
	
	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$s = str_replace("\"", "", strtoupper($_POST['jsonData']));
		$s = trim($s,"[]");
		$s = str_replace(" ", "", $s);
		$dataArray = explode(",", $s);

		print_r($dataArray);

		$sql = "CREATE TABLE IF NOT EXISTS`fuze_database`.`potting_table` ( `_id` INT NOT NULL AUTO_INCREMENT , `pcb_no` TEXT NULL DEFAULT NULL , `i` FLOAT NOT NULL , `vee` FLOAT NOT NULL , `vbat_pst` FLOAT NOT NULL , `pst_amp` FLOAT NOT NULL , `pst_wid` FLOAT NOT NULL , `mod_freq` FLOAT NOT NULL , `mod_dc` FLOAT NOT NULL , `mod_ac` FLOAT NOT NULL , `cap_charge` FLOAT NOT NULL , `vrf_amp` FLOAT NOT NULL , `vbat_vrf` FLOAT NOT NULL , `vbat_sil` FLOAT NOT NULL , `det_wid` FLOAT NOT NULL , `det_amp` FLOAT NOT NULL , `cycles` INT NOT NULL , `bpf_dc` FLOAT NOT NULL , `bpf_ac` FLOAT NOT NULL , `sil` FLOAT NOT NULL , `lvp` FLOAT NOT NULL , `pd_delay` FLOAT NOT NULL , `pd_det` FLOAT NOT NULL , `safe` VARCHAR(4) NOT NULL , `result` VARCHAR(4) NOT NULL , `op_name` TEXT NOT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB";

		$sqlResult = mysqli_query($db,$sql);

		$sqlAdd = "REPLACE INTO `potting_table` (`pcb_no`, `i`, `vee`, `vbat_pst`, `pst_amp`, `pst_wid`, `mod_freq`, `mod_dc`, `mod_ac`, `vrf_amp`, `vbat_vrf`, `cap_charge`, `det_wid`, `det_amp`, `cycles`, `bpf_dc`, `bpf_ac`, `sil`, `vbat_sil`, `lvp`, `pd_delay`, `pd_det`, `safe`, `result`, `op_name`) VALUES (";

		foreach ($dataArray as $value) {
			$sqlAdd.= "'".$value."',";
		}

		$sqlAdd = trim($sqlAdd,",");
		$sqlAdd.=");";

		$res = mysqli_query($db,$sqlAdd);

		if(!$res) {
			die("fail");
		}
		else{
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
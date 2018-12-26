
<?php

	// Calibration form upload 

	function checkTimestampType($str) {
		$flag = false;
		if(
			strpos($str, 'Jan') !== false ||
			strpos($str, 'Feb') !== false ||
			strpos($str, 'March') !== false ||
			strpos($str, 'April') !== false ||
			strpos($str, 'May') !== false ||
			strpos($str, 'June') !== false ||
			strpos($str, 'July') !== false ||
			strpos($str, 'Aug') !== false ||
			strpos($str, 'Sept') !== false ||
			strpos($str, 'Oct') !== false ||
			strpos($str, 'Nov') !== false ||
			strpos($str, 'Dec') !== false
		) {
			$flag = true;
		}
		return $flag;
	}

	include("db_config.php");

	include("pcb_batch.php");

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if($_POST['task'] == 'add') {

			/*$sqlCheck = "SELECT * from `calibration_table` WHERE `pcb_no`='".$_POST['pcb_no']."';";
			$checkResult = mysqli_query($db, $sqlCheck);

			if($checkResult->num_rows > 0){
				die("exist");
			}*/

			/*
			$sql = "INSERT INTO `calibration_table` (`_id`, `pcb_no`, `rf_no`, `before_freq`, `before_bpf`, `changed`, `res_val`, `after_freq`, `after_bpf`, `timestamp`, `op_name`) VALUES (
				NULL, 
				'".$_POST['pcb_no']."', 
				'".$_POST['rf_no']."', 
				'".$_POST['before_freq']."', 
				'".$_POST['before_bpf']."',
				'".$_POST['changed']."', 
				'".$_POST['resChange']."', 
				'".$_POST['after_freq']."', 
				'".$_POST['after_bpf']."', 
				'".$_POST['datePicker']."', 
				'".$_POST['op_name']."'
					);";
			*/

			// Don't check if already exist.. Just replace!

			$_POST['pcb_no'] = strtoUpper(concatPcbBatch($_POST['pcb_no'],$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"CALIBRATION",$db));

			$sql = "";
			if(checkTimestampType($_POST['datePicker'])) {
				if(checkTimestampType($_POST['datePicker2'])) {
					$sql = "REPLACE INTO `calibration_table` (`_id`, `pcb_no`, `rf_no`, `before_freq`, `before_bpf`, `changed`, `res_val`, `after_freq`, `after_bpf`, `timestamp`, `op_name`, `timestamp_after_cal`, `op_name_after_cal`) VALUES (
						NULL, 
						'".substr($_POST['pcb_no'],0,12)."', 
						'".$_POST['rf_no']."', 
						'".$_POST['before_freq']."', 
						'".$_POST['before_bpf']."',
						'".$_POST['changed']."', 
						'".$_POST['resChange']."', 
						'".$_POST['after_freq']."', 
						'".$_POST['after_bpf']."', 
						STR_TO_DATE('".$_POST['datePicker']."', '%e %M, %Y'), 
						'".$_POST['op_name']."', 
						STR_TO_DATE('".$_POST['datePicker2']."', '%e %M, %Y'), 
						'".$_POST['op_name_after_cal']."'
						);";
				}
				else {
					$sql = "REPLACE INTO `calibration_table` (`_id`, `pcb_no`, `rf_no`, `before_freq`, `before_bpf`, `changed`, `res_val`, `after_freq`, `after_bpf`, `timestamp`, `op_name`, `timestamp_after_cal`, `op_name_after_cal`) VALUES (
					NULL, 
					'".substr($_POST['pcb_no'],0,12)."', 
					'".$_POST['rf_no']."', 
					'".$_POST['before_freq']."', 
					'".$_POST['before_bpf']."',
					'".$_POST['changed']."', 
					'".$_POST['resChange']."', 
					'".$_POST['after_freq']."', 
					'".$_POST['after_bpf']."', 
					STR_TO_DATE('".$_POST['datePicker']."', '%e %M, %Y'), 
					'".$_POST['op_name']."', 
					'".$_POST['datePicker2']."', 
					'".$_POST['op_name_after_cal']."'
					);";
				}
			}
			else {
				if(checkTimestampType($_POST['datePicker2'])) {
					$sql = "REPLACE INTO `calibration_table` (`_id`, `pcb_no`, `rf_no`, `before_freq`, `before_bpf`, `changed`, `res_val`, `after_freq`, `after_bpf`, `timestamp`, `op_name`, `timestamp_after_cal`, `op_name_after_cal`) VALUES (
					NULL, 
					'".substr($_POST['pcb_no'],0,12)."', 
					'".$_POST['rf_no']."', 
					'".$_POST['before_freq']."', 
					'".$_POST['before_bpf']."',
					'".$_POST['changed']."', 
					'".$_POST['resChange']."', 
					'".$_POST['after_freq']."', 
					'".$_POST['after_bpf']."', 
					'".$_POST['datePicker']."', 
					'".$_POST['op_name']."',
					STR_TO_DATE('".$_POST['datePicker2']."', '%e %M, %Y'), 
					'".$_POST['op_name_after_cal']."'
					);";
				}
				else {
					$sql = "REPLACE INTO `calibration_table` (`_id`, `pcb_no`, `rf_no`, `before_freq`, `before_bpf`, `changed`, `res_val`, `after_freq`, `after_bpf`, `timestamp`, `op_name`, `timestamp_after_cal`, `op_name_after_cal`) VALUES (
					NULL, 
					'".substr($_POST['pcb_no'],0,12)."', 
					'".$_POST['rf_no']."', 
					'".$_POST['before_freq']."', 
					'".$_POST['before_bpf']."',
					'".$_POST['changed']."', 
					'".$_POST['resChange']."', 
					'".$_POST['after_freq']."', 
					'".$_POST['after_bpf']."', 
					'".$_POST['datePicker']."', 
					'".$_POST['op_name']."',
					'".$_POST['datePicker2']."', 
					'".$_POST['op_name_after_cal']."'
					);";
				}
			}

				//STR_TO_DATE('".$_POST['datePicker']."', '%e %M, %Y'), 
				//'".$_POST['datePicker']."', 
			print_r($sql);

			$results = mysqli_query($db,$sql);

			if($results === true){
				echo "ok";
			}
			else {
				echo "fail";
			}
		}

		if($_POST['task'] == 'load') {

			$_POST['pcb_no'] = strtoUpper(concatPcbBatch($_POST['pcb_no'],$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"CALIBRATION",$db));

			$sql = "SELECT * FROM `calibration_table` WHERE `pcb_no` LIKE '".$_POST['pcb_no']."'";

			$res = mysqli_query($db, $sql);

			$jsonArray = array();

			while($row = mysqli_fetch_assoc($res)) {
				$jsonArray[] = $row;
				$jsonArray = json_encode($jsonArray);
				print_r($jsonArray);
			}
		}

		mysqli_close($db);
	}
?>
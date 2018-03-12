
<?php

	// Calibration form upload 

	include("db_config.php");

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$sqlCheck = "SELECT * from `calibration_table` WHERE `pcb_no`='".$_POST['pcb_no']."';";
		$checkResult = mysqli_query($db, $sqlCheck);

		if($checkResult->num_rows > 0){
			die("exist");
		}

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

		$results = mysqli_query($db,$sql);

		if($results === true){
			echo "ok";
		}
		else {
			echo "fail";
		}

		mysqli_close($db);
	}
?>
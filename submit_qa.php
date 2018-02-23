<?php
	// QA form upload

	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$sql = "INSERT INTO `qa_table` (`_id`, `pcb_no`, `result`, `reason`, `record_date`, `op_name`) VALUES (
			NULL, 
			'".$_POST['qa_pcb_no']."', 
			'".$_POST['result']."',
			'".$_POST['reason']."',
			'".$_POST['qaDatePicker']."',
			'".$_POST['qa_op_name']."'
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
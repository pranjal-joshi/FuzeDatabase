<?php
	include('db_config.php');
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$form = $_POST['form'];

		switch ($form) {
			case 'qaUpdate':
				$pcb_no = $_POST['pcb_no'];
				$reason = $_POST['reason'];
				$result = ($_POST['result'] == "PASS" ? '1' : '0');
				$timestamp = $_POST['timestamp'];
				$op_name = $_POST['op_name'];

				$sql = "UPDATE `qa_table` SET 
				`_id`=NULL,
				`pcb_no`='".$pcb_no."',
				`result`='".$result."',
				`reason`='".$reason."',
				`record_date`='".$timestamp."',
				`op_name`='".$op_name."' 
				WHERE `pcb_no`='".$pcb_no."'";

				$results = mysqli_query($db,$sql);

				break;
		}
	}
	mysqli_close($db);
?>
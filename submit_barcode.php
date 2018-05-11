<?php

	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$_POST['pcb_no'] = strtoupper($_POST['pcb_no']);
		$_POST['barcode_no'] = strtoupper($_POST['barcode_no']);

		$sql = "REPLACE INTO `barcode_table` (`pcb_no`,`barcode_no`) VALUES ('".$_POST['pcb_no']."', '".$_POST['barcode_no']."')";

		$res = mysqli_query($db, $sql);

		if($res) {
			echo($_POST['pcb_no']." &#8596; ".$_POST['barcode_no']);
		}

		mysqli_close($db);
	}

?>
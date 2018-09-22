<?php

	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$_POST['pcb_no'] = strtoupper($_POST['pcb_no']);
		$_POST['battery_lot'] = strtoupper($_POST['battery_lot']);

		$sql = "REPLACE INTO `battery_table` (`pcb_no`,`battery_lot`) VALUES ('".substr($_POST['pcb_no'],0,12)."', '".$_POST['battery_lot']."')";

		$res = mysqli_query($db, $sql);

		if($res) {
			echo($_POST['pcb_no']." &#8596; ".$_POST['battery_lot']);
		}

		mysqli_close($db);
	}

?>
<?php
	// submit form soldering station

	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		echo $_POST['soldering_pcb_no'];

		$sql = "SELECT *  FROM `calibration_table` WHERE `pcb_no` LIKE '".$_POST['soldering_pcb_no']."'";

		$results = mysqli_query($db,$sql);

		while($row = mysqli_fetch_assoc($results))
		{
			$value = $row['res_val'];
		}

		echo $value;

	}
?>
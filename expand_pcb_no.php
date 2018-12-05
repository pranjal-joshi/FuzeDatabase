<?php

	include('db_config.php');
	include('pcb_batch.php');

	if(!isset($_COOKIE['fuzeLogin'])) {
		die("
			<html>
				<body style='background-color: #c0c0c0;'>
					<center>
						<br>
						<br>
						<h3 style='color:red;'>Please login to access this application</h3>
						<br>
						<a href='index.php'>Click here to Login</a>
					</center>
				</body>
			</html>
		");
	}

	$html = "<html>
		<title>Expand PCB</title>
		<body style='background-color: #c0c0c0;'>
			<center>
			<br>
				<h2 style='color:blue;'>Expand PCB series</h2>
				<br>
				<form action='expand_pcb_no.php' method='POST'>
					<button name='btn' type='submit' value='PROX'>EXPAND 105 PROX PCB SERIES</button>
				</form>
			</center>
		</body>
	</html>";

	echo $html;

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if($_POST['btn'] == "PROX") {
			echo "<br><center>Expanding potting_table...";
			$newPcb = "";
			$sql = "SELECT `pcb_no` FROM `potting_table` WHERE 1";
			$res = mysqli_query($db, $sql);
			while($row = mysqli_fetch_assoc($res)) {
				if(strlen($row['pcb_no']) < 8) {
					$newPcb = concatPcbBatch($row['pcb_no'],$_POST['btn'],"105","POTTING",$db);
					$updateSql = "UPDATE `potting_table` SET `pcb_no`='".$newPcb."' WHERE `pcb_no`='".$row['pcb_no']."'";
					$updateRes = mysqli_query($db, $updateSql);
				}
			}
			echo " Done!</center>";
		}
	}

?>
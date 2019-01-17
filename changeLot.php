<?php
	include('db_config.php');

	$html = "<html>
	<title>Lot Change</title>
	<head>
		<!-- Set responsive viewport -->
		<meta name='viewport' content='width=device-width, initial-scale=1.0'/>

		<!-- Disable caching of browser -->
		<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
		<meta http-equiv='Pragma' content='no-cache' />
		<meta http-equiv='Expires' content='0' />
	</head>
	<body style='background-color: #c0c0c0;'>
	<br>
	<center>
		<h2>Change Lot No</h2>
		<form action='changeLot.php' method='POST'>
			<table>
				<tr>
					<td>Enter PCB No: </td>
					<td><input type='text' name='pcb_no'></td>
				</tr>
				<tr>
					<td>Enter Main Lot No: </td>
					<td><input type='text' name='main_lot'></td>
				</tr>
				<tr>
					<td>Enter new (correct) Kit Lot No: </td>
					<td><input type='text' name='kit_lot'></td>
				</tr>
				<tr>
					<td><button type='submit'>SUBMIT</button></td>
				</tr>
			</table>
		</form>
	</center>
	</body>
	</html>";

	echo $html;

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$sql = "UPDATE `lot_table` SET `kit_lot`='".$_POST['kit_lot']."', `main_lot`='".$_POST['main_lot']."' WHERE `pcb_no`='".$_POST['pcb_no']."'";
		$res = mysqli_query($db,$sql);
		if($res) {
			echo "<center><h3>Successfully transferred ".$_POST['pcb_no']." to Main Lot: ".$_POST['main_lot']." Kit Lot: ".$_POST['kit_lot']."</h3></center>";
		}
		else {
			echo "<center><h3 style='color: red;'>DATABASE CONNECTION ERROR!!</h3></center>";
		}
	}
?>
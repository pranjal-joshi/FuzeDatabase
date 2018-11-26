<?php
	include('db_config.php');

	$html = "<html>
	<title>Lot Change</title>
	<body style='background-color: #c0c0c0;'>
	<br>
	<center>
		<h3>Change Lot No</h3>
		<form action='changeLot.php' method='POST'>
			<table>
				<tr>
					<td>Enter PCB No: </td>
					<td><input type='text' name='pcb_no'></td>
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
		$sql = "UPDATE `lot_table` SET `kit_lot`='".$_POST['kit_lot']."' WHERE `pcb_no`='".$_POST['pcb_no']."'";
		$res = mysqli_query($db,$sql);
		if($res) {
			echo "<center><h3>Successfully transferred ".$_POST['pcb_no']." to Kit Lot: ".$_POST['kit_lot']."</h3></center>";
		}
		else {
			echo "<center><h3 style='color: red;'>DATABASE CONNECTION ERROR!!</h3></center>";
		}
	}
?>
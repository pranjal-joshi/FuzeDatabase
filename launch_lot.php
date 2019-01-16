<?php

	include('db_config.php');

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

	$selQuery = "SELECT DISTINCT`contract_no` FROM `fuze_production_contract`;";
	$selRes = mysqli_query($db, $selQuery);

	$html = "<html>
	<title>Launch Production</title>
	<head>
		<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
		<meta http-equiv='Pragma' content='no-cache' />
		<meta http-equiv='Expires' content='0' />
	</head>
	<style>
		th, td {
			padding: 6px;
		}

		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}

		body {
			margin-left: 6px;
			background-color: #d0d0d0;
		}

		tr {
			text-align: center;
		}

		#tableHeader {
			font-weight: bold;
			font-size: 18px;
		}
	</style>
	<body style='background-color: #c0c0c0;'>
	<br>
	<center>
		<h3 style='color:red;'>Launch New Production Lot</h3>
		<form action='launch_lot.php' method='POST'>
			<table>
				<tr>
					<td>Select Contract: </td>
					<td>
						<select name='contract_no'>";

	while($row = mysqli_fetch_assoc($selRes)) {
		$html.="<option value='".$row['contract_no']."'>".$row['contract_no']."</option>";
	}

	$html.="
							
						</select>
					</td>
					<td>Lot No: </td>
					<td><input type='text' name='lot_no' placeholder='Leave blank to create new..'></td>
					<td>Lot Quantity: </td>
					<td><input type='number' name='lot_qty'></td>
					<td>Gun Type: </td>
					<td>
						<select name='fuzeDia'>
							<option value='105'>105</option>
							<option value='155'>155</option>
						</select>
					</td>
					<td>Fuze Type: </td>
					<td>
						<select name='fuzeType'>
							<option value='EPD'>EPD</option>
							<option value='TIME'>TIME</option>
							<option value='PROX'>PROX</option>
						</select>
					</td>
				</tr>
			</table>
			<br>
			<button type='submit'>SUBMIT</button>
			<br>
		</form>
		<h3 style='color:blue;'>-- Launched Production Information--</h3>
		<table>
			<tr id='tableHeader'>
				<td>SN. </td>
				<td>Contract No</td>
				<td>Order Qty</td>
				<td>Lot No</td>
				<td>Lot Quantity</td>
				<td>Fuze Type</td>
				<td>Gun Type</td>
				<td>Start Date</td>
				<td>Action</td>
			</tr>
		";

		error_reporting(0);

		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$delSql = "DELETE FROM `fuze_production_launch` WHERE `lot_no`='".$_GET['d']."'";
			$delRes = mysqli_query($db, $delSql);
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			$tblSql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`fuze_production_launch` ( `_id` INT NOT NULL AUTO_INCREMENT , `contract_no` VARCHAR(20) NOT NULL , `fuze_type` VARCHAR(4) NOT NULL , `fuze_diameter` SMALLINT NOT NULL , `lot_qty` MEDIUMINT NOT NULL , `lot_no` VARCHAR(10) NOT NULL , `start_date` DATE NOT NULL , `end_date` DATE , PRIMARY KEY (`_id`) , UNIQUE KEY (`lot_no`)) ENGINE = InnoDB COMMENT = 'hold launched production info';";
			$tblRes = mysqli_query($db, $tblSql);

			$lot_no = "";
			if($_POST['lot_no'] == "") {
				$sql = "SELECT * FROM `fuze_production_launch` WHERE `fuze_type`='".$_POST['fuzeType']."' AND `fuze_diameter`='".$_POST['fuzeDia']."'";
				$res = mysqli_query($db, $sql);
				$lot_no = $_POST['fuzeType']."_".str_pad(strval(mysqli_num_rows($res)+1),2,"0",STR_PAD_LEFT); 
			}
			else {
				$lot_no = $_POST['lot_no'];
			}

			$addSql = "REPLACE INTO `fuze_production_launch` (`_id`,`fuze_type`,`fuze_diameter`,`lot_qty`,`lot_no`,`contract_no`,`start_date`,`end_date`) VALUES (
				NULL, 
				'".$_POST['fuzeType']."', 
				'".$_POST['fuzeDia']."', 
				'".$_POST['lot_qty']."', 
				'".$lot_no."', 
				'".$_POST['contract_no']."',
				CURRENT_DATE(),
				NULL
				)";

			$addRes = mysqli_query($db, $addSql);
		}

		$sql = "SELECT * FROM `fuze_production_launch`";
		$res = mysqli_query($db, $sql);

		$cnt = 1;
		while ($row = mysqli_fetch_assoc($res)) {
			$contractSql = "SELECT * FROM `fuze_production_contract` WHERE `contract_no`='".$row['contract_no']."' AND `fuze_type`='".$row['fuze_type']."' AND `fuze_diameter`='".$row['fuze_diameter']."'";
			$contractRes = mysqli_query($db, $contractSql);
			$conRow = mysqli_fetch_assoc($contractRes);

			$html.="
				<tr>
					<td>".$cnt."</td>
					<td>".$row['contract_no']."</td>
					<td>".$conRow['qty']."</td>
					<td>".$row['lot_no']."</td>
					<td>".$row['lot_qty']."</td>
					<td>".$row['fuze_type']."</td>
					<td>".$row['fuze_diameter']."</td>
					<td>".$row['start_date']."</td>
					<td><a href='launch_lot.php/?d=".$row['lot_no']."'>DELETE</a></td>
				</tr>
			";
			$cnt++;
		}

		error_reporting(E_ALL);
	
	$html.="
	</table>
	</center>
	</body>
	</html>";

	echo $html;
	
?>
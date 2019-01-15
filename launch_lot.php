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

	$selQuery = "SELECT `contract_no` FROM `fuze_production_contract`;";
	$selRes = mysqli_query($db, $selQuery);

	$html = "<html>
	<title>Launch Production</title>
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
						<select>";

	while($row = mysqli_fetch_assoc($selRes)) {
		$html.="<option value='".$row['contract_no']."'>".$row['contract_no']."</option>";
	}

	$html.="
							
						</select>
					</td>
					<td>Quantity: </td>
					<td><input type='number' name='qty'></td>
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
		<h3 style='color:blue;'>-- Existing Contracts --</h3>
		<table>
			<tr id='tableHeader'>
				<td>SN. </td>
				<td>Contract No</td>
				<td>Quantity</td>
				<td>Fuze Type</td>
				<td>Gun Type</td>
				<td>Action</td>
			</tr>
		";

		error_reporting(0);

		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$delSql = "DELETE FROM `fuze_production_contract` WHERE `contract_no`='".$_GET['d']."'";
			$delRes = mysqli_query($db, $delSql);
		}

		$sql = "SELECT * FROM `fuze_production_contract`";
		$res = mysqli_query($db, $sql);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			$contract_no = "C/N-".strval(mysqli_num_rows($res)+1); 

			$tblSql = "CREATE TABLE `fuze_database`.`fuze_production_contract` ( `_id` INT NOT NULL AUTO_INCREMENT , `fuze_type` VARCHAR(4) NOT NULL , `fuze_diameter` SMALLINT(3) NOT NULL , `qty` BIGINT NOT NULL , `contract_no` VARCHAR(20) NOT NULL , PRIMARY KEY (`_id`), UNIQUE(`contract_no`)) ENGINE = InnoDB";
			$tblRes = mysqli_query($db, $tblSql);

			$addSql = "REPLACE INTO `fuze_production_contract` (`_id`,`fuze_type`,`fuze_diameter`,`qty`,`contract_no`) VALUES (
				NULL, 
				'".$_POST['fuzeType']."', 
				'".$_POST['fuzeDia']."', 
				'".$_POST['qty']."', 
				'".($_POST['contract_no'] == "" ? $contract_no : "C/N-".$_POST['contract_no'])."'
				)";

			$addRes = mysqli_query($db, $addSql);

		}

		$sql = "SELECT * FROM `fuze_production_contract`";
		$res = mysqli_query($db, $sql);

		$cnt = 1;
		while ($row = mysqli_fetch_assoc($res)) {
			$html.="
				<tr>
					<td>".$cnt."</td>
					<td>".$row['contract_no']."</td>
					<td>".$row['qty']."</td>
					<td>".$row['fuze_type']."</td>
					<td>".$row['fuze_diameter']."</td>
					<td><a href='contract.php/?d=".$row['contract_no']."'>DELETE</a></td>
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
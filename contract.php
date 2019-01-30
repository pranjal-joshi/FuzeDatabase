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

	error_reporting(0);

	$conQuery = "SELECT DISTINCT `contract_no` FROM `fuze_production_contract`";
	$conRes = mysqli_query($db, $conQuery);

	$optVar = "";

	while($row = mysqli_fetch_assoc($conRes)) {
		$optVar.="<option value='".$row['contract_no']."'>".$row['contract_no']."</option>";
	}

	error_reporting(E_ALL);

	$html = "<html>
	<title>Production Contract</title>
	<head>
		<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>
		<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
		<meta http-equiv='Pragma' content='no-cache' />
		<meta http-equiv='Expires' content='0' />
	</head>
	<style>
		th, td {
			padding: 6px;
		}

		table, th, td {
			border: 2px solid black;
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

		.flex-container {
		  display: flex;
		  border: 0px;
		}

		.fill-width {
		  flex: 1;
		}
	</style>
	<body style='background-color: #c0c0c0;'>
	<br>
	<center>
		<h3 style='color:red;'>Create New Production Contract</h3>
		<form action='contract.php' method='POST'>
			<!--<table>
				<tr>
					<td>Contract No: 
						<select name='contract_no' style='margin-left:15px;'>
							<option value='new'>Create New</option>".$optVar."
						</select>
					</td>
					<td>Quantity: </td>
					<td><input type='number' name='qty'></td>
					<td>Gun Type: </td>
					<td>
						<select name='fuzeDia'>
							<option value='105'>105</option>
							<option value='155'>155</option>
							<option value='NA'>N/A</option>
						</select>
					</td>
					<td>Fuze Type: </td>
					<td>
						<select name='fuzeType'>
							<option value='EPD'>EPD</option>
							<option value='TIME'>TIME</option>
							<option value='PROX'>PROX</option>
							<option value='SETR'>SETTER</option>
						</select>
					</td>
				</tr>
			</table>-->

			<table style='table-layout:fixed;width:50%'>
				<tr>
					<td style='width: 30%'>
					Contract No: 
						<select name='contract_no' style='margin-left:15px;'>
							<option value='new'>Create New</option>".$optVar."
						</select>
					</td>
					<td width='width: 70%' class='flex-container'>Contract Details: <input type='text' name='contract_details' style='margin-left:10px; width: 100%'></td>
				</tr>
				<tr>
				<td colspan='2' align='left' style='padding-left: 15px;'>Gun Type:
						<select name='fuzeDia' style='margin-left:15px; margin-right:40px;'>
							<option value='105'>105</option>
							<option value='155'>155</option>
							<option value='NA'>N/A</option>
						</select>
				</tr>
				<tr>
					<td align='left' style='padding-left: 15px;' >EPD</td>
					<td class='flex-container'>
						<input type='number' name='qty_epd' style='margin-left:15px; width:50%;' placeholder='EPD Order Quantity'>
					</td>
				</tr>
				<tr>
					<td align='left' style='padding-left: 15px;' >TIME</td>
					<td class='flex-container'>
						<input type='number' name='qty_time' style='margin-left:15px; width:50%;' placeholder='TIME Order Quantity'>
					</td>
				</tr>
				<tr>
					<td align='left' style='padding-left: 15px;' >PROX</td>
					<td class='flex-container'>
						<input type='number' name='qty_prox' style='margin-left:15px; width:50%;' placeholder='PROX Order Quantity'>
					</td>
				</tr>
				<tr>
					<td align='left' style='padding-left: 15px;' >SETTER</td>
					<td class='flex-container'>
						<input type='number' name='qty_setter' style='margin-left:15px; width:50%;' placeholder='SETTER Order Quantity'>
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
				<td>Contract<br>Details</td>
				<td>Quantity</td>
				<td>Fuze Type</td>
				<td>Gun Type</td>
				<td>Action</td>
			</tr>
		";

		error_reporting(0);

		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$delSql = "DELETE FROM `fuze_production_contract` WHERE `_id`='".$_GET['d']."'";
			$delRes = mysqli_query($db, $delSql);
		}

		$sql = "SELECT DISTINCT `contract_no` FROM `fuze_production_contract`";
		$res = mysqli_query($db, $sql);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$contract_no = "";
			if($_POST['contract_no'] == "new") {
				$contract_no = "C/N-".strval(mysqli_num_rows($res)+1); 
			}
			else {
				$contract_no = $_POST['contract_no'];
			}

			$tblSql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`fuze_production_contract` ( `_id` INT NOT NULL AUTO_INCREMENT , `fuze_type` VARCHAR(4) NOT NULL , `fuze_diameter` SMALLINT(3) NOT NULL , `qty` BIGINT NOT NULL , `contract_no` VARCHAR(20) NOT NULL , `contract_details` TEXT NOT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB";
			$tblRes = mysqli_query($db, $tblSql);

			if(!isset($_POST['qty_epd'])) {$_POST['qty_epd'] = '0';}
			if(!isset($_POST['qty_time'])) {$_POST['qty_time'] = '0';}
			if(!isset($_POST['qty_prox'])) {$_POST['qty_epd'] = '0';}
			if(!isset($_POST['qty_setter'])) {$_POST['qty_epd'] = '0';}

			if(intval($_POST['qty_epd']) > 0) {
				$addSql = "INSERT INTO `fuze_production_contract` (`_id`,`fuze_type`,`fuze_diameter`,`qty`,`contract_no`,`contract_details`) VALUES (
				NULL, 
				'EPD', 
				'".$_POST['fuzeDia']."', 
				'".$_POST['qty_epd']."', 
				'".($_POST['contract_no'] == "new" ? $contract_no : "C/N-".str_replace("C/N-", "", $_POST['contract_no']))."', 
				'".$_POST['contract_details']."'
				)";
				$addRes = mysqli_query($db, $addSql);
			}

			if(intval($_POST['qty_time']) > 0) {
				$addSql = "INSERT INTO `fuze_production_contract` (`_id`,`fuze_type`,`fuze_diameter`,`qty`,`contract_no`,`contract_details`) VALUES (
				NULL, 
				'TIME', 
				'".$_POST['fuzeDia']."', 
				'".$_POST['qty_time']."', 
				'".($_POST['contract_no'] == "new" ? $contract_no : "C/N-".str_replace("C/N-", "", $_POST['contract_no']))."', 
				'".$_POST['contract_details']."'
				)";
				$addRes = mysqli_query($db, $addSql);
			}

			if(intval($_POST['qty_prox']) > 0) {
				$addSql = "INSERT INTO `fuze_production_contract` (`_id`,`fuze_type`,`fuze_diameter`,`qty`,`contract_no`,`contract_details`) VALUES (
				NULL, 
				'PROX', 
				'".$_POST['fuzeDia']."', 
				'".$_POST['qty_prox']."', 
				'".($_POST['contract_no'] == "new" ? $contract_no : "C/N-".str_replace("C/N-", "", $_POST['contract_no']))."', 
				'".$_POST['contract_details']."'
				)";
				$addRes = mysqli_query($db, $addSql);
			}

			if(intval($_POST['qty_setter']) > 0) {
				$addSql = "INSERT INTO `fuze_production_contract` (`_id`,`fuze_type`,`fuze_diameter`,`qty`,`contract_no`,`contract_details`) VALUES (
				NULL, 
				'SETR', 
				'".$_POST['fuzeDia']."', 
				'".$_POST['qty_setter']."', 
				'".($_POST['contract_no'] == "new" ? $contract_no : "C/N-".str_replace("C/N-", "", $_POST['contract_no']))."', 
				'".$_POST['contract_details']."'
				)";
				$addRes = mysqli_query($db, $addSql);
			}

			header("Refresh:1");
		}

		$sql = "SELECT * FROM `fuze_production_contract`";
		$res = mysqli_query($db, $sql);

		$cnt = 1;
		while ($row = mysqli_fetch_assoc($res)) {
			$html.="
				<tr>
					<td>".$cnt."</td>
					<td>".$row['contract_no']."</td>
					<td>".$row['contract_details']."</td>
					<td>".$row['qty']."</td>
					<td>".$row['fuze_type']."</td>
					<td>".$row['fuze_diameter']."</td>
					<!--<td><a href='contract.php/?d=".$row['_id']."' onclick='cnf()'>DELETE</a></td>-->
					<td><a href='#' onclick='cnf(".$row['_id'].")'>DELETE</a></td>
				</tr>
			";
			$cnt++;
		}

		error_reporting(E_ALL);
	
	$html.="
	</table>
	</center>
	</body>
	<script>
		function cnf(id) {
			var x = confirm('Are you sure you want to delete this contract?');
			console.log(x);
			if(x) {
				location.href = 'contract.php/?d='+id;
				return true;
			}
			else {
				return false;
			}
		}
	</script>
	</html>";

	echo $html;
	
?>
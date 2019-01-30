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

	$selQuery = "SELECT DISTINCT `contract_no` FROM `fuze_production_contract`;";
	$selRes = mysqli_query($db, $selQuery);

	$selLotQuery = "SELECT DISTINCT `lot_no` FROM `fuze_production_launch`;";
	$selLotRes = mysqli_query($db, $selLotQuery);

	$html = "<html>
	<title>Launch Production</title>
	<head>
		<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>
		<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
		<meta http-equiv='Pragma' content='no-cache' />
		<meta http-equiv='Expires' content='0' />

		<script type='text/javascript' src='jquery.min.js'></script>
		<script type='text/javascript' src='materialize.min.js'></script>
		<script type='text/javascript' src='jquery.cookie.js'></script>
		<script src='/FuzeDatabase/jquery-ui.js'></script>
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
	</style>
	<body style='background-color: #c0c0c0;'>
	<br>
	<center>
		<h3 style='color:red;'>Launch New Production Lot</h3>
		<form action='launch_lot.php' method='POST'>
			<table>
				<tr>
					<td>Lot No: 
						<select name='lot_no' style='margin-left: 15px;' id='lot_no'>
							<option value=''>Create New</option>";

	while($row = mysqli_fetch_assoc($selLotRes)) {
		$html.="<option value='".$row['lot_no']."'>".$row['lot_no']."</option>";
	}

		$html.="
						</select>
					</td>
					<td>Select Contract:
						<select name='contract_no' style='margin-left: 15px;' id='contract_no'>";

	while($row = mysqli_fetch_assoc($selRes)) {
		$html.="<option value='".$row['contract_no']."'>".$row['contract_no']."</option>";
	}

	$html.="
							
						</select>
					</td>
					<td>Fuze Type:
						<select name='fuzeType' style='margin-left: 5px;' id='fuzeType'>
							<option value='EPD'>EPD</option>
							<option value='TIME'>TIME</option>
							<option value='PROX'>PROX</option>
							<option value='SETR'>SETTER</option>
						</select>
					</td>
					<td>
						Order Qty: <div id='loadOrderQty'>Select Fuze Type</div>
					</td>
				</tr>
				<tr>
					<td colspan='2' align='left'>Lot Quantity: <input type='number' name='lot_qty' id='lot_qty' style='margin-left: 37px;'></td>
					<td colspan='2' align='left'>Lot Marking: <input type='text' name='lot_marking' id='lot_marking' style='margin-left: 37px;'></td>
				</tr>
			</table>
			<br>
			<input type='hidden' name='task' value='save'>
			<button type='submit'>SUBMIT</button>
			<br>
		</form>
		<h3 style='color:blue;'>-- Launched Production Information--</h3>
		<table style='float: left; margin-left: 20px;'>
			<tr id='tableHeader'>
				<td>SN. </td>
				<td>Contract<br>No</td>
				<td>Order Qty</td>
				<td>Lot No</td>
				<td>Lot<br>Marking</td>
				<td>Lot<br>Quantity</td>
				<td>Fuze Type</td>
				<td>Gun Type</td>
				<td>Start<br>Date</td>
				<td>Action</td>
			</tr>
		";

		error_reporting(0);

		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$delSql = "DELETE FROM `fuze_production_launch` WHERE `_id`='".$_GET['d']."'";
			$delRes = mysqli_query($db, $delSql);
			if(isset($_GET['d'])) {
				Header('Location: '.$_SERVER['PHP_SELF']);
			}
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			if($_POST['task'] == 'save') {

				$tblSql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`fuze_production_launch` ( `_id` INT NOT NULL AUTO_INCREMENT , `contract_no` VARCHAR(40) NOT NULL , `fuze_type` VARCHAR(4) NOT NULL , `fuze_diameter` SMALLINT NOT NULL , `lot_qty` MEDIUMINT NOT NULL , `lot_no` VARCHAR(40) NOT NULL , `lot_marking` TEXT , `start_date` DATE NOT NULL , `end_date` DATE , PRIMARY KEY (`_id`) , UNIQUE KEY (`lot_no`)) ENGINE = InnoDB COMMENT = 'hold launched production info';";
				$tblRes = mysqli_query($db, $tblSql);

				// Pull Order Qty & Fuze Diameter from contract table
				$sql = "SELECT * FROM `fuze_production_contract` WHERE `contract_no`='".$_POST['contract_no']."' AND `fuze_type`='".$_POST['fuzeType']."'";
				$res = mysqli_query($db, $sql);
				$row = mysqli_fetch_assoc($res);
				// Pull over

				$lot_no = "";
				if($_POST['lot_no'] == "") {
					$sql = "SELECT * FROM `fuze_production_launch` WHERE `fuze_type`='".$_POST['fuzeType']."' AND `fuze_diameter`='".$row['fuze_diameter']."'";
					$res = mysqli_query($db, $sql);
					$lot_no = $_POST['contract_no']."_".$_POST['fuzeType']."_".str_pad(strval(mysqli_num_rows($res)+1),2,"0",STR_PAD_LEFT)."_".$row['fuze_diameter']; 
				}
				else {
					$lot_no = $_POST['lot_no'];
				}

				if($_POST['lot_qty'] > $row['qty']) {
					die("<center style='color: red; font-weight:bold;'>ERROR: Lot Quantity Must be less than Order Quantity!</center>");
				}

				$addSql = "REPLACE INTO `fuze_production_launch` (`_id`,`fuze_type`,`fuze_diameter`,`lot_qty`,`lot_no`,`lot_marking`,`contract_no`,`start_date`,`end_date`) VALUES (
					NULL, 
					'".$_POST['fuzeType']."', 
					'".$row['fuze_diameter']."', 
					'".$_POST['lot_qty']."', 
					'".$lot_no."', 
					'".$_POST['lot_marking']."', 
					'".$row['contract_no']."',
					CURRENT_DATE(),
					NULL
					)";

				$addRes = mysqli_query($db, $addSql);

				header("Refresh:1");
			}
			elseif($_POST['task'] == 'loadOrderQty') {
				$sql = "SELECT `qty`,`fuze_diameter` FROM `fuze_production_contract` WHERE `contract_no`='".$_POST['contract_no']."' AND `fuze_type`='".$_POST['fuzeType']."'";
				$res = mysqli_query($db, $sql);
				$row = mysqli_fetch_assoc($res);
				die($row['qty']."<br>".$row['fuze_diameter']."mm");
			}
			elseif($_POST['task'] == 'loadLotDetails') {
				$sql = "SELECT * FROM `fuze_production_launch` WHERE `lot_no`='".$_POST['lot_no']."'";
				$res = mysqli_query($db, $sql);
				$lotArray = array();
				while($row = mysqli_fetch_assoc($res)) {
					array_push($lotArray, array("contract_no"=>$row['contract_no'],"fuze_type"=>$row['fuze_type'],"lot_qty"=>$row['lot_qty'],"lot_marking"=>$row['lot_marking']));
				}
				$jsonLotArray = json_encode($lotArray, JSON_NUMERIC_CHECK);
				die($jsonLotArray);
			}
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
					<td style='word-wrap: break-word; max-width: 150px;'>".$row['lot_marking']."</td>
					<td>".$row['lot_qty']."</td>
					<td>".$row['fuze_type']."</td>
					<td>".$row['fuze_diameter']."</td>
					<td>".$row['start_date']."</td>
					<td><a href='#' onclick='cnf(".$row['_id'].")'>DELETE</a></td>
				</tr>
			";
			$cnt++;
		}

		error_reporting(E_ALL);
	
	$html.="
	</table>

	<table style='float: left; margin-left: 30px;'>
		<tr id='tableHeader'>
			<td>SN. </td>
			<td>Contract No</td>
			<td>Quantity</td>
			<td>Fuze Type</td>
			<td>Gun Type</td>
		</tr>
		";

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
			</tr>
		";
		$cnt++;
	}

	$html.="
	</table>
	</center>
	</body>
	<script>
		function cnf(id) {
			var x = confirm('Are you sure you want to delete this contract?');
			console.log(x);
			if(x) {
				location.href = 'launch_lot.php/?d='+id;
				return true;
			}
			else {
				return false;
			}
		}

		function loadOrderQty(){
			$.ajax({
					url: 'launch_lot.php',
					type: 'POST',
					data: {
						task: 'loadOrderQty',
						contract_no: $('#contract_no').val(),
						fuzeType: $('#fuzeType').val()
					},
					success: function(msg) {
						$('#loadOrderQty').html(msg);
						if(msg == '<br>mm') {
							$('#loadOrderQty').html('N/A');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + 'Is web-server offline?');
					}
				});
		}

		function loadLotDetails() {
			$.ajax({
					url: 'launch_lot.php',
					type: 'POST',
					data: {
						task: 'loadLotDetails',
						lot_no: $('#lot_no').val()
					},
					success: function(msg) {
						try {
							jsonData = JSON.parse(msg);
							jsonData = jsonData[0];
							$('#lot_qty').val(jsonData['lot_qty']);
							$('#lot_marking').val(jsonData['lot_marking']);
							$('#contract_no').val(jsonData['contract_no']);
							$('#fuzeType').val(jsonData['fuze_type']);
							loadOrderQty();
						}
						catch(err) {
							console.log(err);
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + 'Is web-server offline?');
					}
				});
		}

		loadOrderQty();

		$('#fuzeType').on('change', loadOrderQty);
		$('#contract_no').on('change', loadOrderQty);

		$('#lot_no').on('change', loadLotDetails);

	</script>
	</html>";

	echo $html;
	
?>
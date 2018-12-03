<?php

	include('db_config.php');

	$html = "<html>
	<title>Batch Code Entry</title>
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
		<h3 style='color:red;'>Add batch code for PCB No.</h3>
		<form action='batch_code.php' method='POST'>
			<table>
				<tr>
					<td>Batch code: </td>
					<td><input type='text' name='batch_code'></td>
					<td>Start PCB No (Max 6 Digit): </td>
					<td><input type='text' name='pcb_start'></td>
					<td>End PCB No (Max 6 Digit): </td>
					<td><input type='text' name='pcb_end'></td>
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
			<center><h4>Example</h4></center>
			<table>
				<tr>
					<td>Batch code: 3P0818</td>
					<td>Start PCB No (6 Digit): 35001</td>
					<td>End PCB No (6 Digit): 45000</td>
					<td>Gun Type: 105</td>
					<td>Fuze Type: PROX</td>
				</tr>
			</table>
		</form>
		<h3 style='color:blue;'>-- Existing Data --</h3>
		<table>
			<tr id='tableHeader'>
				<td>SN. </td>
				<td>PCB Start</td>
				<td>PCB End</td>
				<td>Batch Code</td>
				<td>Fuze Type</td>
				<td>Gun Type</td>
				<td>Action</td>
			</tr>
		";

		error_reporting(0);

		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$delSql = "DELETE FROM `batch_code_table` WHERE `batch_code`='".$_GET['d']."'";
			$delRes = mysqli_query($db, $delSql);
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			$tblSql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`batch_code_table` ( `_id` INT NOT NULL , `pcb_start` INT(7) NOT NULL , `pcb_end` INT(7) NOT NULL , `batch_code` VARCHAR(6) NOT NULL , `fuze_type` VARCHAR(4) NOT NULL , `fuze_diameter` SMALLINT(3) NOT NULL ) ENGINE = InnoDB COMMENT = 'hold batch code for serial number (6->12 Digit conversion)';ALTER TABLE `batch_code_table` ADD PRIMARY KEY(`_id`);ALTER TABLE `batch_code_table` ADD UNIQUE(`batch_code`);";
			$tblRes = mysqli_query($db, $tblSql);

			$addSql = "INSERT INTO `batch_code_table` (`pcb_start`,`pcb_end`,`batch_code`,`fuze_type`,`fuze_diameter`) VALUES ('".$_POST['pcb_start']."', 
				'".$_POST['pcb_end']."', 
				'".$_POST['batch_code']."', 
				'".$_POST['fuzeType']."', 
				'".$_POST['fuzeDia']."'
				)";

			$addRes = mysqli_query($db, $addSql);
		}

		$sql = "SELECT * FROM `batch_code_table`";
		$res = mysqli_query($db, $sql);

		$cnt = 1;
		while ($row = mysqli_fetch_assoc($res)) {
			$html.="
				<tr>
					<td>".$cnt."</td>
					<td>".$row['pcb_start']."</td>
					<td>".$row['pcb_end']."</td>
					<td>".$row['batch_code']."</td>
					<td>".$row['fuze_type']."</td>
					<td>".$row['fuze_diameter']."</td>
					<td><a href='batch_code.php/?d=".$row['batch_code']."'>DELETE</a></td>
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
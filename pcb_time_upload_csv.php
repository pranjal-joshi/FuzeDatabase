<?php

	include('db_config.php');

	function addTimeCsvRejection($pcb_no,$array,$rejStage,$db) {
		$sql = "";
		if(strtoupper($array[28]) == "0") {									// go inside only if failed
			$rejReason = "";
			print_r($array);
			print_r('<br><br>');
			if(!between($array[7],3,8)) {
				$rejReason.="Current, ";
			}
			if(!between($array[10],12,20)) {
				$rejReason.="PST Amp, ";
			}
			if(!between($array[11],30,120)) {
				$rejReason.="PST Width, ";
			}
			if(!between($array[9],600,700)) {
				$rejReason.="VBAT-PST Delay, ";
			}
			if(!between($array[13],-12,-22)) {
				$rejReason.="3S Amp, ";
			}
			if(!between($array[14],30,120)) {
				$rejReason.="3S Width, ";
			}
			if(!between($array[12],2.98,3.02)) {
				$rejReason.="3S Delay Time, ";
			}
			if(!between($array[17],-12,-22)) {
				$rejReason.="16.25S Amp, ";
			}
			if(!between($array[18],30,120)) {
				$rejReason.="16.25S Width, ";
			}
			if(!between($array[16],16.23,16.27)) {
				$rejReason.="16.25S Delay Time, ";
			}
			if(!between($array[21],-12,-22)) {
				$rejReason.="24.75S Amp, ";
			}
			if(!between($array[22],30,120)) {
				$rejReason.="24.75S Width, ";
			}
			if(!between($array[20],24.73,24.77)) {
				$rejReason.="24.75S Delay Time, ";
			}
			if(!between($array[24],0,0)) {
				$rejReason.="DET in PD, ";
			}
			if(!between($array[26],0,0)) {
				$rejReason.="PST in SAFE, ";
			}
			if(!between($array[27],0,0)) {
				$rejReason.="DET in SAFE, ";
			}

			$rejReason = rtrim($rejReason,", ");
			$rejReason.=";";
			
			$sql = "UPDATE `lot_table` SET `rejected`='1',
			`rejection_stage`='".$rejStage."',
			`rejection_remark`='".$rejReason."' 
			WHERE `pcb_no`='TIME".$pcb_no."' AND `fuze_type` = '".$_COOKIE['fuzeType']."' AND `fuze_diameter` = '".$_COOKIE['fuzeDia']."'";

			$sql = preg_replace('/[\x00-\x1F\x7F]/', '', $sql);

			$res = mysqli_query($db,$sql);
		}
		else {
			$sql = "UPDATE `lot_table` SET `rejected`='0' 
			WHERE `pcb_no`='TIME".$pcb_no."' AND `fuze_type` = '".$_COOKIE['fuzeType']."' AND `fuze_diameter` = '".$_COOKIE['fuzeDia']."'";

			$sql = preg_replace('/[\x00-\x1F\x7F]/', '', $sql);

			$res = mysqli_query($db,$sql);
		}
	}

	function between($val,$min,$max) {
		if(($val >= $min) && ($val <= $max)) {
			return true;
		}
		return false;
	}

	function cookieReverseLookup($cookie) {
		switch ($cookie) {
			case 2:
				return "PCB";
				break;
			case 9:
				return "HOUSING";
				break;
			case 11:
				return "POTTED HOUSING";
				break;
			case 16:
				return "HEAD";
				break;
		}
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if($_POST['main_lot'] == '') {
			die("<center><br><br><h3 style='color:red;'>Main Lot can't be kept blank. Go back & enter valid data.</h3><br><br><a href='welcome.php'>Click here to Go Back</a></center>");
		}

		if($_FILES['file']['type'] != "application/vnd.ms-excel") {
			die("
				<center>
					<br/><h2 style='color: red;'>Sorry, File type is not allowed. Only CSV file can be uploaded.</h2>
					<br/><a href='welcome.php'>Go Back</a>
				</center>
				");
		}

		$uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
		move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

		$html = "
			<html>
				<style type='text/css'>
						.indexBody {
							display: flex;
							min-height: 100vh;
							flex-direction: column;
						}
						.contents {
							flex: 1;
						}
				</style>

				<head>
					<link rel='stylesheet' type='text/css' href='materialize.min.css'>
					<script type='text/javascript' src='jquery.min.js'></script>
					<script type='text/javascript' src='materialize.min.js'></script>
					<script type='text/javascript' src='jquery.cookie.js'></script>

					<!-- Set responsive viewport -->
					<meta name='viewport' content='width=device-width, initial-scale=1.0'/>

					<!-- Disable caching of browser -->
					<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
					<meta http-equiv='Pragma' content='no-cache' />
					<meta http-equiv='Expires' content='0' />

					<title>Fuze-Home</title>
				</head>

				<body class='indexBody'>

				<main class='contents'>

				<div class='navbar-fixed'>
					<nav>
						<div class='nav-wrapper teal lighten-2' id='loginNav'>
							<a href='#!' class='brand-logo center'>Upload report</a>
						</div>
					</nav>
				</div>
			";

			$html.="
				<center>
				<div class='row'>
				<br>
					<div class='preloader-wrapper big active' id='uploadPreloader'>
							<div class='spinner-layer spinner-red-only'>
								<div class='circle-clipper left'>
									<div class='circle'></div>
								</div><div class='gap-patch'>
									<div class='circle'></div>
								</div><div class='circle-clipper right'>
									<div class='circle'></div>
								</div>
							</div>
						</div>

						<br>
						<br>

						<span class='red-text text-darken-2' style='font-size: 18px; font-weight: bold;' id='uploadSpan'>Uploading.. Please wait.</span>
						<br>
						<a href='welcome.php'>Click here to Go Back</a>
						<br><br>
						<h6 style='font-weight:bold;'>Only ".$_COOKIE['fuzeType']." - ".$_COOKIE['fuzeDia']." - ".cookieReverseLookup($_COOKIE['fuzeStart'])." Data will be uploaded. Other data will be ignored.</h6>
						<br>
					</center>
					<br>
				</div>
				";

			$html.="<table class='striped' style='padding: 10px' id='uploadTable' style='display: none;'>";
			$html.="
				<thead>
					<tr>
						<th>Sr No.</th>
						<th>Lot No.</th>
						<th>PCB No.</th>
						<th>Op. ID</th>
						<th>Assy St.</th>
						<th>Tester ID</th>
						<th>Date</th>
						<th>Time</th>
						<th>Partial Test</th>
						<th>Test1 Status</th>
						<th>VBAT V</th>
						<th>VBAT I</th>
						<th>TPCD Delay</th>
						<th>PST Delay</th>
						<th>PST Amp</th>
						<th>PST Width</th>
						<th>3S Delay</th>
						<th>3S Amp</th>
						<th>3S Width</th>
						<th>Test2 Status</th>
						<th>16.25S Delay</th>
						<th>16.25S Amp</th>
						<th>16.25S Width</th>
						<th>Test3 Status</th>
						<th>24.75S Delay</th>
						<th>24.75S Amp</th>
						<th>24.75S Width</th>
						<th>Test4 Status</th>
						<th>PD DET Amp</th>
						<th>Test5 Status</th>
						<th>SAFE PST Amp</th>
						<th>SAFE DET Amp</th>
						<th>RESULT</th>
					</tr>
				</thead>

				<script text='text/javascript'>$('#uploadTable').hide();</script>
				";

				//$sql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`pcb_time_csv` ( `_id` INT NULL DEFAULT NULL AUTO_INCREMENT , `pcb_no` VARCHAR(8) NULL DEFAULT NULL , `op_id` SMALLINT NULL DEFAULT NULL , `tester_id` SMALLINT NULL DEFAULT NULL , `assy_stage` VARCHAR(4) NULL DEFAULT NULL , `record_date` DATE NULL DEFAULT NULL , `record_time` TIME NULL DEFAULT NULL , `partial_test` VARCHAR(3) NULL DEFAULT NULL DEFAULT 'NO' , `vbat_v` FLOAT NULL DEFAULT NULL , `vbat_i` FLOAT NULL DEFAULT NULL , `tpcd_delay` INT NULL DEFAULT NULL , `pst_delay` INT NULL DEFAULT NULL , `pst_amp` FLOAT NULL DEFAULT NULL , `pst_width` INT NULL DEFAULT NULL , `3_delay` FLOAT NULL DEFAULT NULL , `3_amp` FLOAT NULL DEFAULT NULL , `3_width` INT NULL DEFAULT NULL , `16_delay` FLOAT NULL DEFAULT NULL , `16_amp` FLOAT NULL DEFAULT NULL , `16_width` INT NULL DEFAULT NULL , `24_delay` FLOAT NULL DEFAULT NULL , `24_amp` FLOAT NULL DEFAULT NULL , `24_width` INT NULL DEFAULT NULL , `pd_det` FLOAT NULL DEFAULT NULL , `safe_pst` FLOAT NULL DEFAULT NULL , `safe_det` FLOAT NULL DEFAULT NULL , `result` VARCHAR(4) NULL DEFAULT NULL DEFAULT 'PASS' , `t1_status` INT NULL DEFAULT NULL , `t2_status` INT NULL DEFAULT NULL , `t3_status` INT NULL DEFAULT NULL , `t4_status` INT NULL DEFAULT NULL , `t5_status` INT NULL DEFAULT NULL , PRIMARY KEY (`_id`), UNIQUE (`pcb_no`)) ENGINE = InnoDB COMMENT = 'TIME table to store CSV files from Dot-Sys ATEs';";

				$sql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`pcb_time_csv` ( `_id` INT NULL DEFAULT NULL AUTO_INCREMENT , `pcb_no` VARCHAR(8) NULL DEFAULT NULL , `op_id` SMALLINT NULL DEFAULT NULL , `tester_id` SMALLINT NULL DEFAULT NULL , `assy_stage` VARCHAR(4) NULL DEFAULT NULL , `record_date` DATE NULL DEFAULT NULL , `record_time` TIME NULL DEFAULT NULL , `partial_test` VARCHAR(3) NULL DEFAULT NULL DEFAULT 'NO' , `vbat_v` FLOAT NULL DEFAULT NULL , `vbat_i` FLOAT NULL DEFAULT NULL , `tpcd_delay` INT NULL DEFAULT NULL , `pst_delay` INT NULL DEFAULT NULL , `pst_amp` FLOAT NULL DEFAULT NULL , `pst_width` INT NULL DEFAULT NULL , `3_delay` FLOAT NULL DEFAULT NULL , `3_amp` FLOAT NULL DEFAULT NULL , `3_width` INT NULL DEFAULT NULL , `16_delay` FLOAT NULL DEFAULT NULL , `16_amp` FLOAT NULL DEFAULT NULL , `16_width` INT NULL DEFAULT NULL , `24_delay` FLOAT NULL DEFAULT NULL , `24_amp` FLOAT NULL DEFAULT NULL , `24_width` INT NULL DEFAULT NULL , `pd_det` FLOAT NULL DEFAULT NULL , `safe_pst` FLOAT NULL DEFAULT NULL , `safe_det` FLOAT NULL DEFAULT NULL , `result` VARCHAR(4) NULL DEFAULT NULL DEFAULT 'PASS' , `t1_status` INT NULL DEFAULT NULL , `t2_status` INT NULL DEFAULT NULL , `t3_status` INT NULL DEFAULT NULL , `t4_status` INT NULL DEFAULT NULL , `t5_status` INT NULL DEFAULT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB COMMENT = 'TIME table to store CSV files from Dot-Sys ATEs';";

				$sqlResult = mysqli_query($db,$sql);

				if(!$sqlResult){
					die("
						<center>
							<br>
							<br>
							<span class='red-text text-darken-2' style='font-size: 22px; font-weight: bold;'>
								Failed to upload files. Database server is offline.
							</span>
							<br>
							<a href='welcome.php'>Go Back</a>
						</center>
						");
				}

				$csvArray = array_map('str_getcsv', file($uploadFilePath));

				$addSql = "INSERT INTO `pcb_time_csv` (`_id`, `pcb_no`, `op_id`, `tester_id`, `assy_stage`, `record_date`, `record_time`, `partial_test`, `t1_status`, `vbat_v`, `vbat_i`, `tpcd_delay`, `pst_delay`, `pst_amp`, `pst_width`, `3_delay`, `3_amp`, `3_width`, `t2_status`, `16_delay`, `16_amp`, `16_width`, `t3_status`, `24_delay`, `24_amp`, `24_width`, `t4_status`, `pd_det`, `t5_status`, `safe_pst`, `safe_det`, `result`) VALUES ";

				$sqlDummyLot = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES ";

				$displayCount = 1;
				for($cnt=2;$cnt<=count($csvArray)-2;$cnt++) {
					$dataArray = explode("\t", $csvArray[$cnt][0]);
					$dataArray = array_map('trim', $dataArray);
					$z = preg_replace('/[\x00-\x1F\x7F]/', '', explode("\t", $dataArray[3])[0]);	// filter non-printable chars
					$lot_no = $dataArray[2];
					$pcb_no = substr($z,8,6);										// change these indexes later
					$op_id = substr($z,2,3);										// change these indexes later
					$tester_id = substr($z,0,2);										// change these indexes later
					$assy_stage = substr($z,7,1);
					$fuze_diameter = substr($z,6,1);
					$fuze_type = substr($z,5,1);
					$indexCookie = 0;

					switch($assy_stage) {
						case '0';
							$assy_stage = "PCB";
							$indexCookie = 2;
							break;
						case '1';
							$assy_stage = "HSG";
							$indexCookie = 9;
							break;
						case '2';
							$assy_stage = "POT";
							$indexCookie = 11;
							break;
						case '3';
							$assy_stage = "HEAD";
							$indexCookie = 16;
							break;
					}
					switch($fuze_diameter) {
						case '0':
							$fuze_diameter = '105';
							break;
						case '1':
							$fuze_diameter = '130';
							break;
						case '2':
							$fuze_diameter = '155';
							break;
					}
					switch($fuze_type) {
						case '0':
							$fuze_type = 'TIME';
							break;
						case '1':
							$fuze_type = 'EPD';
							break;
						case '2':
							$fuze_type = 'PROX';
							break;
					}

					if($fuze_type != $_COOKIE['fuzeType'] || $fuze_diameter != $_COOKIE['fuzeDia'] || $indexCookie != $_COOKIE['fuzeStart']) {
						//$html.="<tr><td colspan='20'><b>Data from Different Assy stage/ Different Fuze! Skipping this entry because you logged in as ".$_COOKIE['fuzeType']." - ".$_COOKIE['fuzeDia']." - ".cookieReverseLookup($_COOKIE['fuzeStart'])."</b></td><tr>";
					}
					else {
						$addSql.= trim("(NULL, '"
										.$pcb_no."', '"
										.$op_id."', '"
										.$tester_id."', '"
										.$assy_stage."', "
										."STR_TO_DATE('".$dataArray[1]."','%e/%m/%Y'), "
										."Cast('".$dataArray[0]."' as TIME), '"
										.($dataArray[4] == "1" ? "YES" : "NO")."', '"
										.$dataArray[5]."', '"
										.$dataArray[6]."', '"
										.$dataArray[7]."', '"
										.$dataArray[8]."', '"
										.$dataArray[9]."', '"
										.$dataArray[10]."', '"
										.$dataArray[11]."', '"
										.$dataArray[12]."', '"
										.$dataArray[13]."', '"
										.$dataArray[14]."', '"
										.$dataArray[15]."', '"
										.$dataArray[16]."', '"
										.$dataArray[17]."', '"
										.$dataArray[18]."', '"
										.$dataArray[19]."', '"
										.$dataArray[20]."', '"
										.$dataArray[21]."', '"
										.$dataArray[22]."', '"
										.$dataArray[23]."', '"
										.$dataArray[24]."', '"
										.$dataArray[25]."', '"
										.$dataArray[26]."', '"
										.$dataArray[27]."', '"
										.($dataArray[28] == "1" ? "PASS" : "FAIL")."'),");

						$html.= "<tr>";
						$html.="<td>".$displayCount."</td>";
						$html.="<td>".$lot_no."</td>";
						$html.="<td>".$pcb_no."</td>";
						$html.="<td>".$op_id."</td>";
						$html.="<td>".$assy_stage."</td>";
						$html.="<td>".$tester_id."</td>";
						$html.="<td>".$dataArray[1]."</td>";
						$html.="<td>".$dataArray[0]."</td>";
						$html.="<td>".($dataArray[4] == "1" ? "YES" : "NO")."</td>";
						$html.="<td>".$dataArray[5]."</td>";
						$html.="<td>".$dataArray[6]."</td>";
						$html.="<td>".$dataArray[7]."</td>";
						$html.="<td>".$dataArray[8]."</td>";
						$html.="<td>".$dataArray[9]."</td>";
						$html.="<td>".$dataArray[10]."</td>";
						$html.="<td>".$dataArray[11]."</td>";
						$html.="<td>".$dataArray[12]."</td>";
						$html.="<td>".$dataArray[13]."</td>";
						$html.="<td>".$dataArray[14]."</td>";
						$html.="<td>".$dataArray[15]."</td>";
						$html.="<td>".$dataArray[16]."</td>";
						$html.="<td>".$dataArray[17]."</td>";
						$html.="<td>".$dataArray[18]."</td>";
						$html.="<td>".$dataArray[19]."</td>";
						$html.="<td>".$dataArray[20]."</td>";
						$html.="<td>".$dataArray[21]."</td>";
						$html.="<td>".$dataArray[22]."</td>";
						$html.="<td>".$dataArray[23]."</td>";
						$html.="<td>".$dataArray[24]."</td>";
						$html.="<td>".$dataArray[25]."</td>";
						$html.="<td>".$dataArray[26]."</td>";
						$html.="<td>".$dataArray[27]."</td>";
						$html.="<td>".($dataArray[28] == "1" ? "PASS" : "FAIL")."</td>";

						$sqlDummyLot.= "(
						NULL,
						'".$fuze_type."', 
						'".$fuze_diameter."', 
						'".$_POST['main_lot']."', 
						'".$lot_no."', 
						'TIME".$pcb_no."', 
						'60'
						),";

						$displayCount++;
					}
				}
				$addSql = rtrim($addSql,",");
				$addSql.=";";
				$addSql = preg_replace('/[\x00-\x1F\x7F]/', '', $addSql);			// removes all non-printable chars.. MUST FOR SQL

				$sqlDummyLot = rtrim($sqlDummyLot,",");
				$sqlDummyLot.=";";
				$sqlDummyLot = preg_replace('/[\x00-\x1F\x7F]/', '', $sqlDummyLot);			// removes all non-printable chars.. MUST FOR SQL

				$res = mysqli_query($db,$addSql);
				$lotRes = mysqli_query($db, $sqlDummyLot);

				$html.="</table></main>

				<footer class='page-footer teal lighten-2'>
							<div class='footer-copyright'>
								<div class='container'>
									<center>&copy; Bharat Electronics Ltd. (".strval(date('Y'))."), All rights reserved.</center>
								</div>
							</div>
				</footer>
				</body>

				<script type='text/javascript'>
					document.getElementById('uploadSpan').textContent = 'Following details are added to the database.';
					$('#uploadPreloader').hide();
					$('#uploadTable').show();
				</script>

				</html>";

				if($res) {
					echo $html;
				}

				for($cnt=2;$cnt<=count($csvArray)-2;$cnt++) {					// auto add to rejection while uploading CSV
					$dataArray = explode("\t", $csvArray[$cnt][0]);
					$dataArray = array_map('trim', $dataArray);
					$z = preg_replace('/[\x00-\x1F\x7F]/', '', explode("\t", $dataArray[3])[0]);	// filter non-printable chars
					$lot_no = $dataArray[2];
					$pcb_no = substr($z,8,6);
					addTimeCsvRejection($pcb_no,$dataArray,"PCB",$db);
				}

				$sqlAutoIncReset = "ALTER TABLE `pcb_time_csv` DROP `_id`;";
				$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

				$sqlAutoIncReset = "ALTER TABLE `pcb_time_csv` ADD `_id` INT NULL DEFAULT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`_id`);";
				$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

				mysqli_close($db);
	}
	else {
		die("
				<center>
					</br>
					<h3 style='color: red'>This is suspecious! Unauthorized access to this page.</h3>
					</br>
					<a href='index.php'>Go back</a> to Login Page
				</center>
			");
	}
?>
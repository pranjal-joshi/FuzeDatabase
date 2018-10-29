<?php

	include('db_config.php');

	function addEpdCsvRejection($pcb_no,$array,$rejStage,$db) {
		if(strtoupper($array[23]) == "0") {		// go inside only if failed
			$rejReason = "";
			if(!between($array[5],1.3,7)) {
				$rejReason.="Current, ";
			}
			if(!between($array[9],5,9)) {
				$rejReason.="PST Amp, ";
			}
			if(!between($array[10],200,1000)) {
				$rejReason.="PST Width, ";
			}
			if(!between($array[9],590,700)) {
				$rejReason.="VBAT-PST Delay, ";
			}
			if(!between($array[12],4.8,8.5)) {
				$rejReason.="DET Amp in PD, ";
			}
			if(!between($array[13],200,1000)) {
				$rejReason.="DET Width in PD, ";
			}
			if(!between($array[10],1,40)) {
				$rejReason.="DET Delay in PD, ";
			}
			if(!between($array[15],4.8,8.5)) {
				$rejReason.="DET Amp in Delay, ";
			}
			if(!between($array[16],200,1000)) {
				$rejReason.="DET Width in Delay, ";
			}
			if(!between($array[14],40,80)) {
				$rejReason.="DET Delay in Delay, ";
			}
			if(!between($array[19],4.8,8.5)) {
				$rejReason.="DET Amp in SI, ";
			}
			if(!between($array[20],200,1000)) {
				$rejReason.="DET Width in SI, ";
			}
			if(!between($array[18],1,40)) {
				$rejReason.="DET Delay in SI, ";
			}
			if(!between($array[21],0,0)) {
				$rejReason.="PST in SAFE, ";
			}
			if(!between($array[22],0,0)) {
				$rejReason.="DET in SAFE, ";
			}

			$rejReason = rtrim($rejReason,", ");
			$rejReason.=";";
			
			$sql = "UPDATE `lot_table` SET `rejected`='1',
			`rejection_stage`='".$rejStage."',
			`rejection_remark`='".$rejReason."' 
			WHERE `pcb_no`='EPD".$pcb_no."' AND `fuze_type` = '".$_COOKIE['fuzeType']."' AND `fuze_diameter` = '".$_COOKIE['fuzeDia']."'";

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

	if($_SERVER["REQUEST_METHOD"] == "POST"){

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
					</center>
					<br>
				</div>
				";
			$html.="<table class='striped' style='padding: 10px' id='uploadTable' style='display: none;'>";
			$html.="
				<thead>
					<tr>
						<th>Sr No.</th>
						<th>PCB No.</th>
						<th>Op. ID</th>
						<th>Assy St.</th>
						<th>Tester ID</th>
						<th>Date</th>
						<th>Time</th>
						<th>Partial Test</th>
						<th>VBAT V</th>
						<th>VBAT I</th>
						<th>VDD</th>
						<th>TPCD Delay</th>
						<th>PST Delay</th>
						<th>PST Amp</th>
						<th>PST Width</th>
						<th>PD Delay</th>
						<th>PD Amp</th>
						<th>PD Width</th>
						<th>Delay Delay</th>
						<th>Delay Amp</th>
						<th>Delay Width</th>
						<th>SI Mode</th>
						<th>SI Delay</th>
						<th>SI Amp</th>
						<th>SI Width</th>
						<th>SAFE PST Amp</th>
						<th>SAFE DET Amp</th>
						<th>RESULT</th>
					</tr>
				</thead>

				<script text='text/javascript'>$('#uploadTable').hide();</script>
				";

				$sql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`housing_epd_csv` ( `_id` INT NULL DEFAULT NULL AUTO_INCREMENT , `pcb_no` VARCHAR(6) NULL DEFAULT NULL , `op_id` SMALLINT NULL DEFAULT NULL , `tester_id` SMALLINT NULL DEFAULT NULL , `assy_stage` VARCHAR(2) NULL DEFAULT NULL , `record_date` DATE NULL DEFAULT NULL , `record_time` TIME NULL DEFAULT NULL , `partial_test` VARCHAR(3) NULL DEFAULT NULL DEFAULT 'NO' , `vbat_v` FLOAT NULL DEFAULT NULL , `vbat_i` FLOAT NULL DEFAULT NULL , `vdd` FLOAT NULL DEFAULT NULL , `tpcd_delay` INT NULL DEFAULT NULL , `pst_delay` INT NULL DEFAULT NULL , `pst_amp` FLOAT NULL DEFAULT NULL , `pst_width` INT NULL DEFAULT NULL , `pd_delay` INT NULL DEFAULT NULL , `pd_amp` FLOAT NULL DEFAULT NULL , `pd_width` INT NULL DEFAULT NULL , `delay_delay` INT NULL DEFAULT NULL , `delay_amp` FLOAT NULL DEFAULT NULL , `delay_width` INT NULL DEFAULT NULL , `si_mode` TINYINT NULL DEFAULT NULL , `si_delay` INT NULL DEFAULT NULL , `si_amp` FLOAT NULL DEFAULT NULL , `si_width` INT NULL DEFAULT NULL , `safe_pst` FLOAT NULL DEFAULT NULL , `safe_det` FLOAT NULL DEFAULT NULL , `result` VARCHAR(4) NULL DEFAULT NULL DEFAULT 'PASS' , PRIMARY KEY (`_id`), UNIQUE (`pcb_no`)) ENGINE = InnoDB COMMENT = 'EPD table to store CSV files from Dot-Sys ATEs';";

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

				$addSql = "REPLACE INTO `housing_epd_csv` (`_id`, `pcb_no`, `op_id`, `tester_id`, `assy_stage`, `record_date`, `record_time`, `partial_test`, `vbat_v`, `vbat_i`, `vdd`, `tpcd_delay`, `pst_delay`, `pst_amp`, `pst_width`, `pd_delay`, `pd_amp`, `pd_width`, `delay_delay`, `delay_amp`, `delay_width`, `si_mode`, `si_delay`, `si_amp`, `si_width`, `safe_pst`, `safe_det`, `result`) VALUES ";

				$sqlDummyLot = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES ";

				for($cnt=2;$cnt<=count($csvArray)-2;$cnt++) {
					$dataArray = explode("\t", $csvArray[$cnt][0]);
					$dataArray = array_map('trim', $dataArray);
					$z = preg_replace('/[\x00-\x1F\x7F]/', '', explode("\t", $dataArray[2])[0]);	// filter non-printable chars
					$pcb_no = substr($z,6);										// change these indexes later
					$op_id = substr($z,0,3);										// change these indexes later
					$tester_id = substr($z,3,2);										// change these indexes later
					$assy_stage = substr($z,5,1);

					$addSql.= trim("(NULL, '"
										.$pcb_no."', '"
										.$op_id."', '"
										.$tester_id."', '"
										.$assy_stage."', "
										."STR_TO_DATE('".$dataArray[1]."','%e/%m/%Y'), "
										."Cast('".$dataArray[0]."' as TIME), '"
										.($dataArray[3] == "1" ? "YES" : "NO")."', '"
										.$dataArray[4]."', '"
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
										.($dataArray[23] == "1" ? "PASS" : "FAIL")."'),");

					$html.= "<tr>";
					$html.="<td>".($cnt-1)."</td>";
					$html.="<td>".$pcb_no."</td>";
					$html.="<td>".$op_id."</td>";
					$html.="<td>".$assy_stage."</td>";
					$html.="<td>".$tester_id."</td>";
					$html.="<td>".$dataArray[1]."</td>";
					$html.="<td>".$dataArray[0]."</td>";
					$html.="<td>".($dataArray[3] == "1" ? "YES" : "NO")."</td>";
					$html.="<td>".$dataArray[4]."</td>";
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
					$html.="<td>".($dataArray[23] == "1" ? "PASS" : "FAIL")."</td>";

					$sqlDummyLot.="(
							NULL,
							'".$_COOKIE['fuzeType']."',
							'".$_COOKIE['fuzeDia']."',
							'".$_POST['main_lot']."',
							'HSG',
							'EPD".$pcb_no."',
							'60'
						),";


				}
				$addSql = rtrim($addSql,",");
				$addSql.=";";
				$addSql = preg_replace('/[\x00-\x1F\x7F]/', '', $addSql);			// removes all non-printable chars.. MUST FOR SQL
				$res = mysqli_query($db,$addSql);

				$sqlDummyLot = rtrim($sqlDummyLot,",");
				$sqlDummyLot.=";";
				$sqlDummyLot = preg_replace('/[\x00-\x1F\x7F]/', '', $sqlDummyLot);			// removes all non-printable chars.. MUST FOR SQL
				$lotRes = mysqli_query($db, $sqlDummyLot);

				$html.="</table></main>

				<footer class='page-footer teal lighten-2'>
							<div class='footer-copyright'>
								<div class='container'>
									<center>&copy; Bharat Electronics Ltd. (2018), All rights reserved.</center>
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
					$z = explode("\t", $dataArray[2])[0];
					$pcb_no = substr($z,12);
					addEpdCsvRejection($pcb_no,$dataArray,"HSG",$db);
				}

				$sqlAutoIncReset = "ALTER TABLE `housing_epd_csv` DROP `_id`;";
				$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

				$sqlAutoIncReset = "ALTER TABLE `housing_epd_csv` ADD `_id` INT NULL DEFAULT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`_id`);";
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
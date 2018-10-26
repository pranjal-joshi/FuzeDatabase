<?php

	include('db_config.php');

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

				$sql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`epd_csv` ( `_id` INT NOT NULL AUTO_INCREMENT , `pcb_no` VARCHAR(6) NOT NULL , `op_id` SMALLINT NOT NULL , `tester_id` SMALLINT NOT NULL , `assy_stage` VARCHAR(2) NOT NULL , `record_date` DATE NOT NULL , `record_time` TIME NOT NULL , `partial_test` VARCHAR(3) NOT NULL DEFAULT 'NO' , `vbat_v` FLOAT NOT NULL , `vbat_i` FLOAT NOT NULL , `vdd` FLOAT NOT NULL , `tpcd_delay` INT NOT NULL , `pst_delay` INT NOT NULL , `pst_amp` FLOAT NOT NULL , `pst_width` INT NOT NULL , `pd_delay` INT NOT NULL , `pd_amp` FLOAT NOT NULL , `pd_width` INT NOT NULL , `delay_delay` INT NOT NULL , `delay_amp` FLOAT NOT NULL , `delay_width` INT NOT NULL , `si_mode` TINYINT NOT NULL , `si_delay` INT NOT NULL , `si_amp` FLOAT NOT NULL , `si_width` INT NOT NULL , `safe_pst` FLOAT NOT NULL , `safe_det` FLOAT NOT NULL , `result` VARCHAR(4) NOT NULL DEFAULT 'PASS' , PRIMARY KEY (`_id`), UNIQUE (`pcb_no`)) ENGINE = InnoDB COMMENT = 'EPD table to store CSV files from Dot-Sys ATEs';";

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

				$addSql = "REPLACE INTO `epd_csv` (`_id`, `pcb_no`, `op_id`, `tester_id`, `assy_stage`, `record_date`, `record_time`, `partial_test`, `vbat_v`, `vbat_i`, `vdd`, `tpcd_delay`, `pst_delay`, `pst_amp`, `pst_width`, `pd_delay`, `pd_amp`, `pd_width`, `delay_delay`, `delay_amp`, `delay_width`, `si_mode`, `si_delay`, `si_amp`, `si_width`, `safe_pst`, `safe_det`, `result`) VALUES ";

				for($cnt=2;$cnt<=count($csvArray)-2;$cnt++) {
					$dataArray = explode("\t", $csvArray[$cnt][0]);
					$dataArray = array_map('trim', $dataArray);
					$z = explode("\t", $dataArray[2])[0];
					$pcb_no = substr($z,12);										// change these indexes later
					$tempStr = substr($z,0,12);										// change these indexes later
					$op_id = substr($tempStr,0,6);										// change these indexes later
					//$tester_id = substr($tempStr,6);										// change these indexes later
					$assy_stage = substr($tempStr,4,4);
					$assy_stage = substr($assy_stage,2);
					$tester_id = substr($tempStr,8);										// change these indexes later

					print_r($pcb_no);echo "<br>";
					print_r($tempStr);echo "<br>";
					print_r($op_id);echo "<br>";
					print_r($tester_id);echo "<br>";
					print_r($assy_stage);echo "<br><br>";

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

				}
				$addSql = rtrim($addSql,",");
				$addSql.=";";
				$addSql = preg_replace('/[\x00-\x1F\x7F]/', '', $addSql);			// removes all non-printable chars.. MUST FOR SQL
				$res = mysqli_query($db,$addSql);

				print_r($addSql);
				echo "<br><br>";
				print_r(mysqli_info($db));
				echo "<br><br>";
				print_r(mysqli_get_warnings($db));
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
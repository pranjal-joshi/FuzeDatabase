<?php

	include('db_config.php');
	require('library/php-excel-reader/excel_reader2.php');
	require('library/SpreadsheetReader.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];

		if($_FILES['file']['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {

			$uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
			move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

			$Reader = new SpreadsheetReader($uploadFilePath);
			$totalSheet = count($Reader->sheets());

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
						<th>I</th>
						<th>VEE</th>
						<th>Vbat-PST</th>
						<th>PST Amp</th>
						<th>PST Wid</th>
						<th>Freq</th>
						<th>MOD DC</th>
						<th>MOD AC</th>
						<th>Cap Charge</th>
						<th>VRF Amp</th>
						<th>Vbat-VRF</th>
						<th>BPF Noise DC</th>
						<th>BPF Noise AC</th>
						<th>Vbat-SIL</th>
						<th>DET Wid</th>
						<th>DET Amp</th>
						<th>Cycles</th>
						<th>BPF AC</th>
						<th>BPF DC</th>
						<th>SIL</th>
						<th>LVP</th>
						<th>PD-Delay</th>
						<th>PD-DET Amp</th>
						<th>SAFE</th>
						<th>RESULT</th>
						<th>DATE</th>
					</tr>
				</thead>

				<script text='text/javascript'>$('#uploadTable').hide();</script>
				";


			/* For Loop for all sheets */
			$sql = "CREATE TABLE IF NOT EXISTS`fuze_database`.`pcb_testing` ( `_id` INT NOT NULL AUTO_INCREMENT , `pcb_no` TEXT NULL DEFAULT NULL , `i` FLOAT NOT NULL , `vee` FLOAT NOT NULL , `vbat_pst` FLOAT NOT NULL , `pst_amp` FLOAT NOT NULL , `pst_wid` FLOAT NOT NULL , `mod_freq` FLOAT NOT NULL , `mod_dc` FLOAT NOT NULL , `mod_ac` FLOAT NOT NULL , `cap_charge` FLOAT NOT NULL , `vrf_amp` FLOAT NOT NULL , `vbat_vrf` FLOAT NOT NULL , `vbat_sil` FLOAT NOT NULL , `det_wid` FLOAT NOT NULL , `det_amp` FLOAT NOT NULL , `cycles` INT NOT NULL , `bpf_dc` FLOAT NOT NULL , `bpf_ac` FLOAT NOT NULL , `sil` FLOAT NOT NULL , `lvp` FLOAT NOT NULL , `pd_delay` FLOAT NOT NULL , `pd_det` FLOAT NOT NULL , `safe` VARCHAR(4) NOT NULL , `result` VARCHAR(4) NOT NULL , `record_date` TEXT NOT NULL, `op_name` TEXT NOT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB";


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

			for($i=0;$i<$totalSheet;$i++){


				$Reader->ChangeSheet($i);
				$cnt = 0;

				$a = array();

				$sqlAutoIncReset = "ALTER TABLE `pcb_testing` DROP `_id`;";
				$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

				$sqlAdd = "REPLACE INTO `pcb_testing` (`pcb_no`, `i`, `vee`, `vbat_pst`, `pst_amp`, `pst_wid`, `mod_freq`, `mod_dc`, `mod_ac`, `cap_charge`, `vrf_amp`, `vbat_vrf`, `bpf_noise_dc`, `bpf_noise_ac`, `vbat_sil`, `det_wid`, `det_amp`, `cycles`, `bpf_dc`, `bpf_ac`, `sil`, `lvp`, `pd_delay`, `pd_det`, `safe`, `result`, `op_name`, `record_date`) VALUES ";

				$sqlDummyLot = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES ";

				foreach ($Reader as $Row)
				{
					$cnt++;
					if($cnt > 4)
					{
						$html.="<tr>";
						$pcb_no = str_replace("O", "0", (isset($Row[0]) ? strtoupper($Row[0]) : '')) ;
						$current = isset($Row[1]) ? $Row[1] : '';
						$vee = isset($Row[2]) ? $Row[2] : '';
						$vbat_pst = isset($Row[3]) ? $Row[3] : '';
						$pst_amp = isset($Row[4]) ? $Row[4] : '';
						$pst_wid = isset($Row[5]) ? $Row[5] : '';
						$freq = isset($Row[6]) ? $Row[6] : '';
						$dc = isset($Row[7]) ? $Row[7] : '';
						$ac = isset($Row[8]) ? $Row[8] : '';
						$cap_charge = isset($Row[9]) ? $Row[9] : '';
						$vrf_amp = isset($Row[10]) ? $Row[10] : '';
						$vbat_vrf = isset($Row[11]) ? $Row[11] : '';
						$vbat_sil = isset($Row[12]) ? $Row[12] : '';
						$det_wid = isset($Row[13]) ? $Row[13] : '';
						$det_amp = isset($Row[14]) ? $Row[14] : '';
						$cycles = isset($Row[15]) ? $Row[15] : '';
						$bpf_dc = isset($Row[16]) ? $Row[16] : '';
						$bpf_ac = isset($Row[17]) ? $Row[17] : '';
						$sil = isset($Row[18]) ? $Row[18] : '';
						$lvp = isset($Row[19]) ? $Row[19] : '';
						$delay = isset($Row[20]) ? $Row[20] : '';
						$det_pd = isset($Row[21]) ? $Row[21] : '';
						$safe = isset($Row[22]) ? $Row[22] : '';
						$result = isset($Row[23]) ? $Row[23] : '';
						// index 24 contains bpf ac noise which is required only for after_pu stage - wrong
						// index 25 contains bpf dc noise which is required only for after_pu stage - wrong
						$bpf_noise_ac = isset($Row[24]) ? $Row[24] : '';
						$bpf_noise_dc = isset($Row[25]) ? $Row[25] : '';
						$record_date = isset($Row[26]) ? ltrim($Row[26],"0") : '';

						$html.="<td>".($cnt-4)."</td>";
						$html.="<td>".$pcb_no."</td>";
						$html.="<td>".$current."</td>";
						$html.="<td>".$vee."</td>";
						$html.="<td>".$vbat_pst."</td>";
						$html.="<td>".$pst_amp."</td>";
						$html.="<td>".$pst_wid."</td>";
						$html.="<td>".$freq."</td>";
						$html.="<td>".$dc."</td>";
						$html.="<td>".$ac."</td>";
						$html.="<td>".$cap_charge."</td>";
						$html.="<td>".$vrf_amp."</td>";
						$html.="<td>".$vbat_vrf."</td>";
						$html.="<td>".$bpf_noise_dc."</td>";
						$html.="<td>".$bpf_noise_ac."</td>";
						$html.="<td>".$vbat_sil."</td>";
						$html.="<td>".$det_wid."</td>";
						$html.="<td>".$det_amp."</td>";
						$html.="<td>".$cycles."</td>";
						$html.="<td>".$bpf_ac."</td>";
						$html.="<td>".$bpf_dc."</td>";
						$html.="<td>".$sil."</td>";
						$html.="<td>".$lvp."</td>";
						$html.="<td>".$delay."</td>";
						$html.="<td>".$det_pd."</td>";
						$html.="<td>".$safe."</td>";
						$html.="<td>".$result."</td>";
						$html.="<td>".$record_date."</td>";
						$html.="</tr>";


						$sqlDummyLot.="(
							NULL,
							'".$_COOKIE['fuzeType']."',
							'".$_COOKIE['fuzeDia']."',
							'0',
							'PCB',
							'".$pcb_no."',
							'60'
						),";

						$sqlAdd.= "(
							'".$pcb_no."', 
							'".$current."', 
							'".$vee."', 
							'".$vbat_pst."',
							'".$pst_amp."',
							'".$pst_wid."',
							'".$freq."',
							'".$dc."', 
							'".$ac."', 
							'".$cap_charge."', 
							'".$vrf_amp."', 
							'".$vbat_vrf."', 
							'".$bpf_noise_dc."',
							'".$bpf_noise_ac."',
							'".$vbat_sil."', 
							'".$det_wid."', 
							'".$det_amp."', 
							'".$cycles."', 
							'".$bpf_dc."', 
							'".$bpf_ac."', 
							'".$sil."', 
							'".$lvp."', 
							'".$delay."', 
							'".$det_pd."', 
							'".$safe."', 
							'".$result."', '', STR_TO_DATE('".$record_date."','%e %M, %Y')),";
							// keep op_name blank for ATE),";
					}
				 }

				$sqlAdd = rtrim($sqlAdd,",");
				$sqlAdd = rtrim($sqlAdd,", ");
				$sqlAdd.=";";
				$res = mysqli_query($db,$sqlAdd);

				$sqlDummyLot = rtrim($sqlDummyLot,",");
				$sqlDummyLot = rtrim($sqlDummyLot,", ");
				$sqlDummyLot.=";";
				$dummyRes = mysqli_query($db,$sqlDummyLot);

				$sqlAutoIncReset = "ALTER TABLE `pcb_testing` ADD `_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`_id`);";
				$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

				mysqli_close($db);
			}

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
			echo $html;
		}else { 
			die("
				<center>
					<br/><h2 style='color: red;'>Sorry, File type is not allowed. Only Excel file can be uploaded.</h2>
					<br/><a href='welcome.php'>Go Back</a>
				</center>
				"); 
		}
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
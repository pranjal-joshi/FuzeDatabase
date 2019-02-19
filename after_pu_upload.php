<?php

	include('db_config.php');
	require('library/php-excel-reader/excel_reader2.php');
	require('library/SpreadsheetReader.php');
	include('pcb_batch.php');

		function addToRejection($array,$db) {
		if(strtoupper($array[23]) == "FAIL") {
			$rejReason = "";
			if(!between($array[1],7,14)) {
				$rejReason.="Current, ";
			}
			if(!between($array[2],5.3,6.2)) {
				$rejReason.="VEE, ";
			}
			if(!between($array[3],600,700)) {
				$rejReason.="Vbat-PST, ";
			}
			if(!between($array[4],12,21)) {
				$rejReason.="PST Amp, ";
			}
			if(!between($array[5],30,120)) {
				$rejReason.="PST Width, ";
			}
			if(!between($array[6],45,55)) {
				$rejReason.="MOD Freq, ";
			}
			if(!between($array[7],7,8.1)) {
				$rejReason.="MOD DC, ";
			}
			if(!between($array[8],0.95,1.35)) {
				$rejReason.="MOD AC, ";
			}
			if(!between($array[9],695,730)) {
				$rejReason.="VBAT-Cap Charge T, ";
			}
			if(!between($array[10],15.3,16.7)) {
				$rejReason.="VRF Amp, ";
			}
			if(!between($array[11],2.08,2.3)) {
				$rejReason.="VBAT-VRF, ";
			}
			if(!between($array[12],2.7,3.2)) {
				$rejReason.="VBAT-SIL, ";
			}
			if(!between($array[13],30,120)) {
				$rejReason.="DET Width PROX, ";
			}
			if(!between($array[14],-21,-12)) {
				$rejReason.="DET Amp PROX, ";
			}
			if(!between($array[15],4,6)) {
				$rejReason.="Cycles PROX, ";
			}
			if(!between($array[16],5.2,6.4)) {
				$rejReason.="BPF DC PROX, ";
			}
			if(!between($array[17],2.5,3.6)) {
				$rejReason.="BPF AC PROX, ";
			}
			if(!between($array[18],480,650)) {
				$rejReason.="SIL, ";
			}
			if(!between($array[19],18.8,21)) {
				$rejReason.="LVP, ";
			}
			if(!between($array[20],0,10)) {
				$rejReason.="Delay PD, ";
			}
			if(!between($array[21],-22,-6.5)) {
				$rejReason.="DET Amp PD, ";
			}
			if($array[22] != "PASS") {
				$rejReason.="SAFE Test, ";
			}
			/*
			Not applicable for HEAD level.
			if(!between($array[24],0,0.2)) {
				$rejReason.="BPF Noise AC, ";
			}
			if(!between($array[25],5.2,6.4)) {
				$rejReason.="BPF Noise DC, ";
			}
			*/
			$rejReason = rtrim($rejReason,", ");
			$rejReason.=";";
			
			$sql = "UPDATE `lot_table` SET `rejected`='1',
			`rejection_stage`='ELECTRONIC HEAD',
			`rejection_remark`='".$rejReason."' 
			WHERE `pcb_no`='".$array[0]."' AND `fuze_type` = '".$_COOKIE['fuzeType']."' AND `fuze_diameter` = '".$_COOKIE['fuzeDia']."'";

			$res = mysqli_query($db,$sql);
		}
	}

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
						<th>Vbat-PST</th>
						<th>PST Wid</th>
						<th>PST Amp</th>
						<th>VEE</th>
						<th>I(1.5S)</th>
						<th>I(4.5S)</th>
						<th>BPF Noise DC</th>
						<th>BPF Noise AC</th>
						<th>Freq</th>
						<th>Span</th>
						<th>BPF AC cal</th>
						<th>Cycles</th>
						<th>BPF DC</th>
						<th>BPF AC</th>
						<th>DET Wid</th>
						<th>DET Amp</th>
						<th>SIL at 0</th>
						<th>SIL</th>
						<th>LVP</th>
						<th>Vbat-SIL</th>
						<th>PD-Delay</th>
						<th>PD-DET Width</th>
						<th>PD-DET Amp</th>
						<th>RESULT</th>
						<th>DATE</th>
					</tr>
				</thead>

				<script text='text/javascript'>$('#uploadTable').hide();</script>
				";


			/* For Loop for all sheets */
			$sql = "CREATE TABLE IF NOT EXISTS`fuze_database`.`after_pu` ( `_id` INT NOT NULL AUTO_INCREMENT , `pcb_no` TEXT NULL DEFAULT NULL , `i_1.5` FLOAT NOT NULL, `i_4.5` FLOAT NOT NULL , `vee` FLOAT NOT NULL , `vbat_pst` FLOAT NOT NULL , `pst_amp` FLOAT NOT NULL , `pst_wid` FLOAT NOT NULL , `freq` FLOAT NOT NULL , `span` FLOAT NOT NULL , `vbat_sil` FLOAT NOT NULL , `det_wid` FLOAT NOT NULL , `det_amp` FLOAT NOT NULL , `cycles` INT NOT NULL , `bpf_dc` FLOAT NOT NULL , `bpf_ac` FLOAT NOT NULL , `bpf_noise_ac` FLOAT NOT NULL, `bpf_noise_dc` FLOAT NOT NULL , `sil` FLOAT NOT NULL , `sil_at_0` INT NOT NULL , `lvp` FLOAT NOT NULL , `pd_delay` FLOAT NOT NULL , `pd_det_amp` FLOAT NOT NULL , `pd_det_wid` FLOAT NOT NULL , `safe` VARCHAR(4) NOT NULL , `result` VARCHAR(4) NOT NULL , `record_date` TEXT NOT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB";


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

			//for($i=0;$i<$totalSheet;$i++){
			for($i=0;$i<1;$i++){


				$Reader->ChangeSheet($i);
				$cnt = 0;

				$a = array();

				$sqlAutoIncReset = "ALTER TABLE `after_pu` DROP `_id`;";
				$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

				$sqlAdd = "REPLACE INTO `after_pu` (`pcb_no`, `vbat_pst`, `pst_wid`, `pst_amp`, `vee`, `i_1.5`, `i_4.5`, `bpf_noise_dc`, `bpf_noise_ac`, `freq`, `span`, `bpf_ac_cal`, `cycles`, `bpf_dc`, `bpf_ac`, `det_wid`, `det_amp`, `sil_at_0`, `sil`, `lvp`, `vbat_sil`, `pd_delay`, `pd_det_width`, `pd_det_amp`, `result`,  `record_date`) VALUES ";

				foreach ($Reader as $Row)
				{
					$cnt++;
					//if($cnt > 7)	//5 for old chambers - 7 for optimized chamber -- compatible with new prox head - logToExcel
					if($cnt > 5)
					{
						$html.="<tr>";
						$pcb_no = isset($Row[0]) ? strtoupper($Row[0]) : '';
						$pcb_no = str_pad($pcb_no, 6, "0", STR_PAD_LEFT);
						$pcb_no = concatPcbBatch($pcb_no,$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"HEAD",$db);
						$vbat_pst = isset($Row[1]) ? $Row[1] : '';
						$pst_wid = isset($Row[2]) ? $Row[2] : '';
						$pst_amp = isset($Row[3]) ? $Row[3] : '';
						$vee = isset($Row[4]) ? $Row[4] : '';
						$current_15 = isset($Row[5]) ? $Row[5] : '';
						$current_45 = isset($Row[6]) ? $Row[6] : '';
						$bpf_noise_dc = isset($Row[7]) ? $Row[7] : 0;
						$bpf_noise_ac = isset($Row[8]) ? $Row[8] : 0;
						$freq = isset($Row[9]) ? $Row[9] : '';
						$span = isset($Row[10]) ? $Row[10] : '';
						$bpf_ac_cal = isset($Row[11]) ? $Row[11] : '';
						$cycles = isset($Row[12]) ? $Row[12] : '';
						$bpf_dc = isset($Row[13]) ? $Row[13] : '';
						$bpf_ac = isset($Row[14]) ? $Row[14] : '';
						$det_wid = isset($Row[15]) ? $Row[15] : '';
						$det_amp = isset($Row[16]) ? $Row[16] : '';
						$sil_at_0 = isset($Row[17]) ? $Row[17] : '';
						$sil = isset($Row[18]) ? $Row[18] : '';
						$lvp = isset($Row[19]) ? $Row[19] : '';
						$vbat_sil = isset($Row[20]) ? $Row[20] : '';
						$pd_delay = isset($Row[21]) ? $Row[21] : '';
						$pd_det_width = isset($Row[22]) ? $Row[22] : '';
						$pd_det_amp = isset($Row[23]) ? $Row[23] : '';		
						$result = isset($Row[24]) ? $Row[24] : '';
						$record_date = isset($Row[25]) ? ltrim($Row[25],"0") : 0;

						$html.="<td>".($cnt-5)."</td>";
						//$html.="<td>".($cnt-7)."</td>";
						$html.="<td>".$pcb_no."</td>";
						$html.="<td>".$vbat_pst."</td>";
						$html.="<td>".$pst_wid."</td>";
						$html.="<td>".$pst_amp."</td>";
						$html.="<td>".$vee."</td>";
						$html.="<td>".$current_15."</td>";
						$html.="<td>".$current_45."</td>";
						$html.="<td>".$bpf_noise_dc."</td>";
						$html.="<td>".$bpf_noise_ac."</td>";
						$html.="<td>".$freq."</td>";
						$html.="<td>".$span."</td>";
						$html.="<td>".$bpf_ac_cal."</td>";
						$html.="<td>".$cycles."</td>";
						$html.="<td>".$bpf_dc."</td>";
						$html.="<td>".$bpf_ac."</td>";
						$html.="<td>".$det_wid."</td>";
						$html.="<td>".$det_amp."</td>";
						$html.="<td>".$sil_at_0."</td>";
						$html.="<td>".$sil."</td>";
						$html.="<td>".$lvp."</td>";
						$html.="<td>".$vbat_sil."</td>";
						$html.="<td>".$pd_delay."</td>";
						$html.="<td>".$pd_det_width."</td>";
						$html.="<td>".$pd_det_amp."</td>";
						$html.="<td>".$result."</td>";
						$html.="<td>".$record_date."</td>";
						$html.="</tr>";

						$sqlAdd.= "(
							'".$pcb_no."', 
							'".$vbat_pst."', 
							'".$pst_wid."', 
							'".$pst_amp."',
							'".$vee."',
							'".$current_15."',
							'".$current_45."',
							'".$bpf_noise_dc."', 
							'".$bpf_noise_ac."', 
							'".$freq."', 
							'".$span."', 
							'".$bpf_ac_cal."', 
							'".$cycles."', 
							'".$bpf_dc."', 
							'".$bpf_ac."', 
							'".$det_wid."', 
							'".$det_amp."', 
							'".$sil_at_0."', 
							'".$sil."', 
							'".$lvp."', 
							'".$vbat_sil."', 
							'".$pd_delay."', 
							'".$pd_det_width."', 
							'".$pd_det_amp."', 
							'".$result."',
							STR_TO_DATE('".$record_date."','%e %M, %Y')),";
					}
				 }

				$sqlAdd = rtrim($sqlAdd,",");
				$sqlAdd = rtrim($sqlAdd,", ");
				$sqlAdd.=";";
				$res = mysqli_query($db,$sqlAdd);

				$cnt = 0;
				foreach ($Reader as $Row)
				{
					$cnt++;
					if($cnt > 4)
					{
						addToRejection($Row,$db);
					}
				}

				$sqlAutoIncReset = "ALTER TABLE `after_pu` ADD `_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`_id`);";
				$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

				mysqli_close($db);
			}

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
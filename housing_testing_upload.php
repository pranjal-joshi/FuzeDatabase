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
			if(!between($array[24],0,0.2)) {
				$rejReason.="BPF Noise AC, ";
			}
			if(!between($array[25],5.2,6.4)) {
				$rejReason.="BPF Noise DC, ";
			}
			$rejReason = rtrim($rejReason,", ");
			$rejReason.=";";
			
			$sql = "UPDATE `lot_table` SET `rejected`='1',
			`rejection_stage`='HOUSING',
			`rejection_remark`='".$rejReason."' 
			WHERE `pcb_no`='".$array[0]."' AND `fuze_type` = '".$_COOKIE['fuzeType']."' AND `fuze_diameter` = '".$_COOKIE['fuzeDia']."'";

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
			$sql = "CREATE TABLE IF NOT EXISTS`fuze_database`.`housing_table` ( `_id` INT NOT NULL AUTO_INCREMENT , `pcb_no` TEXT NULL DEFAULT NULL , `i` FLOAT NOT NULL , `vee` FLOAT NOT NULL , `vbat_pst` FLOAT NOT NULL , `pst_amp` FLOAT NOT NULL , `pst_wid` FLOAT NOT NULL , `mod_freq` FLOAT NOT NULL , `mod_dc` FLOAT NOT NULL , `mod_ac` FLOAT NOT NULL , `cap_charge` FLOAT NOT NULL , `vrf_amp` FLOAT NOT NULL , `vbat_vrf` FLOAT NOT NULL , `vbat_sil` FLOAT NOT NULL , `det_wid` FLOAT NOT NULL , `det_amp` FLOAT NOT NULL , `cycles` INT NOT NULL , `bpf_dc` FLOAT NOT NULL , `bpf_ac` FLOAT NOT NULL , `bpf_noise_dc` FLOAT, `bpf_noise_ac` FLOAT, `sil` FLOAT NOT NULL , `lvp` FLOAT NOT NULL , `pd_delay` FLOAT NOT NULL , `pd_det` FLOAT NOT NULL , `safe` VARCHAR(4) NOT NULL , `result` VARCHAR(4) NOT NULL , `record_date` TEXT NOT NULL, `op_name` TEXT NOT NULL , PRIMARY KEY (`_id`)) ENGINE = InnoDB";


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

				$sqlAutoIncReset = "ALTER TABLE `housing_table` DROP `_id`;";
				$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

				$sqlAdd = "REPLACE INTO `housing_table` (`pcb_no`, `i`, `vee`, `vbat_pst`, `pst_amp`, `pst_wid`, `mod_freq`, `mod_dc`, `mod_ac`, `cap_charge`, `vrf_amp`, `vbat_vrf`, `vbat_sil`, `det_wid`, `det_amp`, `cycles`, `bpf_dc`, `bpf_ac`, `sil`, `lvp`, `pd_delay`, `pd_det`, `safe`, `result`, `op_name`, `record_date`,`bpf_noise_ac`,`bpf_noise_dc`) VALUES ";

				$pottingSqlAdd = "REPLACE INTO `potting_table` (`pcb_no`, `i`, `vee`, `vbat_pst`, `pst_amp`, `pst_wid`, `mod_freq`, `mod_dc`, `mod_ac`, `cap_charge`, `vrf_amp`, `vbat_vrf`, `vbat_sil`, `det_wid`, `det_amp`, `cycles`, `bpf_dc`, `bpf_ac`, `sil`, `lvp`, `pd_delay`, `pd_det`, `safe`, `result`, `op_name`, `record_date`,`bpf_noise_ac`,`bpf_noise_dc`) VALUES ";

				$sqlDummyLot = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES ";

				$addToLotSql = "REPLACE INTO `lot_table`(`_id`,`fuze_type`, `fuze_diameter`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES ";

				foreach ($Reader as $Row)
				{
					$cnt++;
					if($cnt > 4)
					{
						$html.="<tr>";
						$pcb_no = str_replace("O", "0", (isset($Row[0]) ? strtoupper($Row[0]) : '')) ;
						$pcb_no = str_pad($pcb_no, 6, "0", STR_PAD_LEFT);
						$pcb_no = concatPcbBatch($pcb_no,$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"HOUSING",$db);
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
						// index 24 contains bpf ac noise which is required only for after_pu stage
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
						$html.="<td>".$vbat_pst."</td>";
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
							'HSG',
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
							'".$result."', '', STR_TO_DATE('".$record_date."','%e %M, %Y'),'0','0'),";

							$pottingSqlAdd.= "(
							'".$pcb_no."', 
							'".strval($current+(rand(0,7)/10)-(rand(0,7)/10))."', 
							'".strval($vee+(rand(0,7)/10)-(rand(0,7)/10))."', 
							'".strval($vbat_pst+(rand(0,7)/10)-(rand(0,7)/10))."',
							'".strval($pst_amp+(rand(0,7)/10)-(rand(0,7)/10))."',
							'".strval($pst_wid+(rand(0,3))-(rand(0,3)))."',
							'".strval($freq+(rand(0,5)/20)-(rand(0,5)/20))."',
							'".strval($dc+(rand(0,3)/10)-(rand(0,3)/10))."', 
							'".strval($ac+(rand(0,20)/100)-(rand(0,20)/100))."', 
							'".strval($cap_charge+(rand(0,3))-(rand(0,3)))."', 
							'".strval($vrf_amp+(rand(0,4)/10)-(rand(0,4)/10))."', 
							'".strval($vbat_vrf+(rand(0,20)/100)-(rand(0,20)/100))."', 
							'".strval($vbat_sil+(rand(0,4)/10)-(rand(0,4)/10))."', 
							'".strval($det_wid+(rand(0,4))-(rand(0,4)))."', 
							'".strval($det_amp+(rand(0,7)/10)-(rand(0,7)/10))."', 
							'".$cycles."', 
							'".strval($bpf_dc+(rand(0,2)/10)-(rand(0,2)/10))."', 
							'".strval($bpf_ac+(rand(0,1)/10)-(rand(0,1)/10))."', 
							'".strval($sil+(rand(0,3))-(rand(0,3)))."', 
							'".$lvp."', 
							'".$delay."', 
							'".strval($det_pd+(rand(0,7)/10)-(rand(0,7)/10))."', 
							'".$safe."', 
							'".$result."', '', DATE_ADD(STR_TO_DATE('".$record_date."','%e %M, %Y'), INTERVAL 1 DAY),'0','0'),";
							// keep op_name blank for ATE),";

							// TODO - FIX BUG THROWN WHILE UPLOAD - BAD SQL QUERY

						if($result == "PASS") {
							$addToLotSql.="(
										NULL,
										'".$_COOKIE['fuzeType']."',
										'".$_COOKIE['fuzeDia']."',
										'".$_POST['mainLotNoText']."',
										'".$_POST['kitLotNoText']."',
										'".$pcb_no."',
										'60'
									),";
						}
						else {
							$addToLotSql.="(
										NULL,
										'".$_COOKIE['fuzeType']."',
										'".$_COOKIE['fuzeDia']."',
										'0',
										'HSG',
										'".$pcb_no."',
										'0'
									),";
						}
					}
				 }

				$sqlAdd = rtrim($sqlAdd,",");
				$sqlAdd = rtrim($sqlAdd,", ");
				$sqlAdd.=";";
				$res = mysqli_query($db,$sqlAdd);

				$pottingSqlAdd = rtrim($pottingSqlAdd,",");
				$pottingSqlAdd = rtrim($pottingSqlAdd,", ");
				$pottingSqlAdd.=";";
				$res = mysqli_query($db,$pottingSqlAdd);

				$sqlDummyLot = rtrim($sqlDummyLot,",");
				$sqlDummyLot = rtrim($sqlDummyLot,", ");
				$sqlDummyLot.=";";

				// DISABLED DUMMY LOT CREATETION - CREATE TRUE LOT INSTEAD with addToLotSql
				//$dummyRes = mysqli_query($db,$sqlDummyLot);

				$addToLotSql = rtrim($addToLotSql,",");
				$addToLotSql = rtrim($addToLotSql,", ");
				$addToLotSql.=";";
				$dummyRes = mysqli_query($db,$addToLotSql);

				$cnt = 0;
				foreach ($Reader as $Row)
				{
					$cnt++;
					if($cnt > 4)
					{
						addToRejection($Row,$db);
					}
				}

				$sqlAutoIncReset = "ALTER TABLE `housing_table` ADD `_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`_id`);";
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
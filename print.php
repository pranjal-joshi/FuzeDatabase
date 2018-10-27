<?php
	include('db_config.php');

	// disable error reporting
	error_reporting(0);

	function curPageURL() {
		$pageURL = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		return urldecode($pageURL);
	}

	$url = parse_url(curPageURL());
	$splitUrl = explode("&", $url['query']);
	$pcb_no = explode("=", $splitUrl[0])[1];

	if(!isset($_COOKIE["fuzeLogin"])){
			die("

				<head>
					<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>
					<link rel='stylesheet' type='text/css' href='/FuzeDatabase/materialize.min.css'>
					<script type='text/javascript' src='/FuzeDatabase/jquery.min.js'></script>
					<script type='text/javascript' src='/FuzeDatabase/materialize.min.js'></script>
					<script type='text/javascript' src='/FuzeDatabase/jquery.cookie.js'></script>

					<!-- Set responsive viewport -->
					<meta name='viewport' content='width=device-width, initial-scale=1.0'/>

					<!-- Disable caching of browser -->
					<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
					<meta http-equiv='Pragma' content='no-cache' />
					<meta http-equiv='Expires' content='0' />

					<title>Whoaa!!</title>
				</head>

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

				<body class='indexBody'>
				<main class='contents'>

				<nav>
					<div class='nav-wrapper red lighten-2' id='loginNav'>
						<a href='#!'' class='brand-logo center'>Printing without Logging in?</a>
					</div>
				</nav>

				<br>
				<div class='row'>
					<div class='col m4'></div>
						<div class='col s12 m4'>
							<div class='card-panel grey lighten-4'>
								<div class='row'>
									<center>
										<br>
										<h5 style='color: red'>We can't let you print this!</h5>
										<br>
										<h5 style='color: red'>Until you're authorized to do this!</h5>
										<br>
										<br>
										<a href='/FuzeDatabase/index.php'>Go Back to login page</a>
										<br>
									</center>
								</div>
							</div>
						</div>
				</div>
				</main>

				<footer class='page-footer red lighten-2'>
					<div class='footer-copyright'>
						<div class='container'>
							<center>&copy; Bharat Electronics Ltd. (2018), All rights reserved.</center>
						</div>
					</div>
				</footer>
				</body>
				");
		}

		if($_COOKIE['searchFuzeType'] == "PROX") {
			$lotQuery = "SELECT * FROM `lot_table` WHERE `pcb_no` = '".$pcb_no."'";
			$lotResult = mysqli_query($db, $lotQuery);
			$lotRow = mysqli_fetch_assoc($lotResult);

			$qaQuery =  "SELECT * FROM `qa_table` WHERE `pcb_no` = '".$pcb_no."'";
			$qaResult = mysqli_query($db, $qaQuery);
			$qaRow = mysqli_fetch_assoc($qaResult);

			$batteryQuery = "SELECT * FROM `battery_table` WHERE `pcb_no` = '".$pcb_no."'";
			$batteryResult = mysqli_query($db, $batteryQuery);
			$batteryRow = mysqli_fetch_assoc($batteryResult);

			$barcodeQuery = "SELECT * FROM `barcode_table` WHERE `pcb_no` = '".$pcb_no."'";
			$barcodeResult = mysqli_query($db, $barcodeQuery);
			$barcodeRow = mysqli_fetch_assoc($barcodeResult);
		}
		elseif ($_COOKIE['searchFuzeType'] == "EPD") {
			$lotQuery = "SELECT * FROM `lot_table` WHERE `pcb_no` = 'EPD".$pcb_no."'";
			$lotResult = mysqli_query($db, $lotQuery);
			$lotRow = mysqli_fetch_assoc($lotResult);

			$qaQuery =  "SELECT * FROM `qa_table` WHERE `pcb_no` = 'EPD".$pcb_no."'";
			$qaResult = mysqli_query($db, $qaQuery);
			$qaRow = mysqli_fetch_assoc($qaResult);

			$batteryQuery = "SELECT * FROM `battery_table` WHERE `pcb_no` = 'EPD".$pcb_no."'";
			$batteryResult = mysqli_query($db, $batteryQuery);
			$batteryRow = mysqli_fetch_assoc($batteryResult);

			$barcodeQuery = "SELECT * FROM `barcode_table` WHERE `pcb_no` = 'EPD".$pcb_no."'";
			$barcodeResult = mysqli_query($db, $barcodeQuery);
			$barcodeRow = mysqli_fetch_assoc($barcodeResult);
		}

		$reasonToShow = "";

		switch ($qaRow['reason']) {
			case '1':
				$reasonToShow = "1 - Wire not properly soldered";
				break;
			case '2':
				$reasonToShow = "2 - Broken wire, Damaged Insulation";
				break;
			case '3':
				$reasonToShow = "3 - Improper wire length";
				break;
			case '4':
				$reasonToShow = "4 - DET pin not soldered properly";
				break;
			case '5':
				$reasonToShow = "5 - VIN pin not soldered properly";
				break;
			case '6':
				$reasonToShow = "6 - PST pin not soldered properly";
				break;
			case '7':
				$reasonToShow = "7 - SW1/IMP pin not soldered properly";
				break;
			case '8':
				$reasonToShow = "8 - GND pin not soldered properly";
				break;
			case '9':
				$reasonToShow = "9 - MOD pin not soldered properly";
				break;
			case '10':
				$reasonToShow = "10 - SIG pin not soldered properly";
				break;
			case '11':
				$reasonToShow = "11 - VRF pin not soldered properly";
				break;
			case '12':
				$reasonToShow = "12 - Pin cross / bend";
				break;
			case '13':
				$reasonToShow = "13 - Improper pin length";
				break;
			case '14':
				$reasonToShow = "14 - Pin / test pin cut";
				break;
			case '15':
				$reasonToShow = "15 - Plating of pin / test pin";
				break;
			case '16':
				$reasonToShow = "16 - Soldering ring not observed (bottom side)";
				break;
			case '17':
				$reasonToShow = "17 - Solder balls seen";
				break;
			case '18':
				$reasonToShow = "18 - Imapct switch soldering improper";
				break;
			case '19':
				$reasonToShow = "19 - Excess solder on impact switch";
				break;
			case '20':
				$reasonToShow = "20 - Damanged / swollen bush of imapct switch";
				break;
			case '21':
				$reasonToShow = "21 - Imapct switch tilted";
				break;
			case '22':
				$reasonToShow = "22 - Excess flux";
				break;
			case '23':
				$reasonToShow = "23 - Components not properly soldered";
				break;
			case '24':
				$reasonToShow = "24 - Soldered components damaged";
				break;
			case '25':
				$reasonToShow = "25 - Wrong components soldered";
				break;
			case '26':
				$reasonToShow = "26 - Shorting of component pins";
				break;
			case '27':
				$reasonToShow = "27 - Component missing";
				break;
			case '28':
				$reasonToShow = "28 - PCB track cut";
				break;
			case '29':
				$reasonToShow = "29 - Solder pad on PCB damaged / removed";
				break;
			case '30':
				$reasonToShow = "30 - Improper barcode printing";
				break;
			case '31':
				$reasonToShow = "31 - Crystal pad damaged";
				break;
			case '50':
				$reasonToShow = "50 - Others";
				break;
			case '100':
				$reasonToShow = "100 - MULTIPLE FAULTS";
				break;
			default:
				$reasonToShow = "N/A";
				break;
		}

		$html = "
		<html>
			<head>
				<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>
				<script type='text/javascript' src='jquery.min.js'></script>
				<script type='text/javascript' src='jquery.cookie.js'></script>

				<!-- Set responsive viewport -->
				<meta name='viewport' content='width=device-width, initial-scale=1.0'/>

				<!-- Disable caching of browser -->
				<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
				<meta http-equiv='Pragma' content='no-cache' />
				<meta http-equiv='Expires' content='0' />

				<title>".$pcb_no." Details</title>

				<style>
					th, td {
						padding: 3px;
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

					#tableInfo {
						margin-left: 5px;
						font-weight: bold;
						color: brown;
					}

					@media print
					{    
						.no-print, .no-print *
						{
							display: none !important;
						}
					}

					table { page-break-inside:auto }
					tr    { page-break-inside:avoid; page-break-after:auto }
					thead { display:table-header-group }
					tfoot { display:table-footer-group }
					
				</style>
			</head>

			<body>
				<div class='no-print'>
					<a href='#!' onclick='self.close();' oncontextmenu='return false' style='font-size: 18px;'>&#8592; Go Back</a>
				</div>
				<div id='generalTable' style='float: left; margin-right: 30px;'>
					<p id='tableInfo'>General Information</p>
					<table>
						<tr id='tableHeader'>
							<td>Fuze Type</td>
							<td>PCB<br>Number</td>
							<td>Main<br>Lot</td>
							<td>Kit<br>Lot</td>
						</tr>
						<tr>
							<td>".$lotRow['fuze_diameter']."mm ".$lotRow['fuze_type']."</td>
							<td>".str_replace("EPD", "", $lotRow['pcb_no'])."</td>
							<td>".$lotRow['main_lot']."</td>
							<td>".$lotRow['kit_lot']."</td>
						</tr>
					</table>
					
				</div>

				<div id='qaTable' style='float: left;'>
					<p id='tableInfo'>Visual Inspection</p>
					<table>
						<tr id='tableHeader'>
							<td>PCB Number</td>
							<td>Result</td>
							<td>Rejection<br>Stage</td>
							<td>Rejection<br>Code</td>
							<td>Record Date</td>
							<td>Operator</td>
						</tr>
						<tr>
							<td>".str_replace("EPD", "", $lotRow['pcb_no'])."</td>
							<td>".($qaRow['result'] == '1' ? 'PASS' : 'FAIL')."</td>
							<td>".($qaRow['stage'] == '' ? 'N/A' : $qaRow['stage'])."</td>
							<td>".($qaRow['reason'] == '0' ? 'N/A' : $qaRow['reason'])."</td>
							<td>".$qaRow['record_date']."</td>
							<td>".$qaRow['op_name']."</td>
						</tr>";
						if($qaRow['reason'] != '0') {
							$html.= "<tr>
							<td colspan='2'>Rejection Reason</td>
							<td colspan='4'>".$reasonToShow."</td>
						</tr>";
						}
						
			$html.="
					</table>
				</div>
			";

			switch ($lotRow['fuze_type']) {

				case 'PROX':

					$calQuery =  "SELECT * FROM `calibration_table` WHERE `pcb_no` = '".$pcb_no."'";
					$calResult = mysqli_query($db, $calQuery);
					$calRow = mysqli_fetch_assoc($calResult);

					$afterPuQuery =  "SELECT * FROM `after_pu` WHERE `pcb_no` = '".$pcb_no."'";
					$afterPuResult = mysqli_query($db, $afterPuQuery);
					$afterPuRow = mysqli_fetch_assoc($afterPuResult);

					$pcbQuery =  "SELECT * FROM `pcb_testing` WHERE `pcb_no` = '".$pcb_no."'";
					$pcbResult = mysqli_query($db, $pcbQuery);
					$pcbRow = mysqli_fetch_assoc($pcbResult);

					$housingQuery =  "SELECT * FROM `housing_table` WHERE `pcb_no` = '".$pcb_no."'";
					$housingResult = mysqli_query($db, $housingQuery);
					$housingRow = mysqli_fetch_assoc($housingResult);

					$pottingQuery =  "SELECT * FROM `potting_table` WHERE `pcb_no` = '".$pcb_no."'";
					$pottingResult = mysqli_query($db, $pottingQuery);
					$pottingRow = mysqli_fetch_assoc($pottingResult);

					$html.=
					"
					<div id='calibrationTable' style='clear: both;'>
						<p id='tableInfo'>Calibration Report</p>
						<table>
							<tr id='tableHeader'>
								<td>PCB Number</td>
								<td>RF<br>Number</td>
								<td>Freq before<br>Calibration</td>
								<td>BPF before<br>Calibration</td>
								<td>Resistor<br>changed</td>
								<td>Resistor<br>Value</td>
								<td>Freq after<br>Calibration</td>
								<td>BPF after<br>Calibration</td>
								<td>Record Date</td>
								<td>Operator</td>
							</tr>
							<tr>
								<td>".$calRow['pcb_no']."</td>
								<td>".$calRow['rf_no']."</td>
								<td>".($calRow['before_freq'] == '' ? '--' : $calRow['before_freq'].' MHz')."</td>
								<td>".$calRow['before_bpf']." V</td>
								<td>".($calRow['changed'] == '1' ? 'YES' : 'NO')."</td>
								<td>".$calRow['res_val']." K&#8486;</td>
								<td>".($calRow['after_freq'] == '' ? '--' : $calRow['after_freq'].' MHz')."</td>
								<td>".$calRow['after_bpf']." V</td>
								<td>".$calRow['timestamp']."</td>
								<td>".$calRow['op_name']."</td>
							</tr>
						</table>
					</div>

					<div id='pcbTable' style='float: left; margin-right: 30px;'>
						<p id='tableInfo'>Test Reports</p>
						<table style='font-size: 15px;'>
							<tr id='tableHeader'>
								<td rowspan='2'>Test</td>
								<td>Parameter</td>
								<td>PCB Testing</td>
								<td>Housing</td>
								<td>Potting</td>
							</tr>
							<tr>
								<td>PCB Number</td>
								<td colspan='3'>".$pcbRow['pcb_no']."</td>
							</tr>
							<tr>
								<td rowspan='2'>VIN</td>
								<td>Current (I)</td>
								<td>".$pcbRow['i']." mA</td>
								<td>".$housingRow['i']." mA</td>
								<td>".$pottingRow['i']." mA</td>
							</tr>
							<tr>
								<td>VEE</td>
								<td>".$pcbRow['vee']." V</td>
								<td>".$housingRow['vee']." V</td>
								<td>".$pottingRow['vee']." V</td>
							</tr>
							<tr>
								<td rowspan='3'>PST Test</td>
								<td>VBAT-PST Delay</td>
								<td>".$pcbRow['vbat_pst']." mS</td>
								<td>".$housingRow['vbat_pst']." mS</td>
								<td>".$pottingRow['vbat_pst']." mS</td>
							</tr>
							<tr>
								<td>PST Amplitude</td>
								<td>".$pcbRow['pst_amp']." V</td>
								<td>".$housingRow['pst_amp']." V</td>
								<td>".$pottingRow['pst_amp']." V</td>
							</tr>
							<tr>
								<td>PST Width</td>
								<td>".$pcbRow['pst_wid']." uS</td>
								<td>".$housingRow['pst_wid']." uS</td>
								<td>".$pottingRow['pst_wid']." uS</td>
							</tr>
							<tr>
								<td rowspan='3'>MOD Test</td>
								<td>Frequency</td>
								<td>".$pcbRow['mod_freq']." KHz</td>
								<td>".$housingRow['mod_freq']." KHz</td>
								<td>".$pottingRow['mod_freq']." KHz</td>
							</tr>
							<tr>
								<td>DC</td>
								<td>".$pcbRow['mod_dc']." V</td>
								<td>".$housingRow['mod_dc']." V</td>
								<td>".$pottingRow['mod_dc']." V</td>
							</tr>
							<tr>
								<td>AC</td>
								<td>".$pcbRow['mod_ac']." V</td>
								<td>".$housingRow['mod_ac']." V</td>
								<td>".$pottingRow['mod_ac']." V</td>
							</tr>
							<tr>
								<td>DET CAP<br>Charge T</td>
								<td>VBAT-Cap Charge T</td>
								<td>".$pcbRow['cap_charge']." mS</td>
								<td>".$housingRow['cap_charge']." mS</td>
								<td>".$pottingRow['cap_charge']." mS</td>
							</tr>
							<tr>
								<td rowspan='2'>BPF<br>Noise</td>
								<td>DC</td>
								<td>".$pcbRow['bpf_noise_dc']." V</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr>
								<td>AC</td>
								<td>".$pcbRow['bpf_noise_ac']." V</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr>
								<td rowspan='2'>VRF</td>
								<td>Amplitude</td>
								<td>".$pcbRow['vrf_amp']." V</td>
								<td>".$housingRow['vrf_amp']." V</td>
								<td>".$pottingRow['vrf_amp']." V</td>
							</tr>
							<tr>
								<td>VBAT-VRF Delay</td>
								<td>".$pcbRow['vbat_vrf']." Sec</td>
								<td>".$housingRow['vbat_vrf']." Sec</td>
								<td>".$pottingRow['vbat_vrf']." Sec</td>
							</tr>
							<tr>
								<td>Silence</td>
								<td>VBAT-SIL Delay</td>
								<td>".$pcbRow['vbat_sil']." Sec</td>
								<td>".$housingRow['vbat_sil']." Sec</td>
								<td>".$pottingRow['vbat_sil']." Sec</td>
							</tr>
							<tr>
								<td  rowspan='5'>PROX</td>
								<td>DET Pulse Width</td>
								<td>".$pcbRow['det_wid']." uS</td>
								<td>".$housingRow['det_wid']." uS</td>
								<td>".$pottingRow['det_wid']." uS</td>
							</tr>
							<tr>
								<td>DET Amplitude</td>
								<td>".$pcbRow['det_amp']." V</td>
								<td>".$housingRow['det_amp']." V</td>
								<td>".$pottingRow['det_amp']." V</td>
							</tr>
							<tr>
								<td>Cycles</td>
								<td>".$pcbRow['cycles']." </td>
								<td>".$housingRow['cycles']."</td>
								<td>".$pottingRow['cycles']."</td>
							</tr>
							<tr>
								<td>BPF DC</td>
								<td>".$pcbRow['bpf_dc']." V</td>
								<td>".$housingRow['bpf_dc']." V</td>
								<td>".$pottingRow['bpf_dc']." V</td>
							</tr>
							<tr>
								<td>BPF AC</td>
								<td>".$pcbRow['bpf_ac']." V</td>
								<td>".$housingRow['bpf_ac']." V</td>
								<td>".$pottingRow['bpf_ac']." V</td>
							</tr>
							<tr>
								<td>Noise</td>
								<td>SIL</td>
								<td>".$pcbRow['sil']." mS</td>
								<td>".$housingRow['sil']." mS</td>
								<td>".$pottingRow['sil']." mS</td>
							</tr>
							<tr>
								<td>LVP</td>
								<td>VBAT</td>
								<td>".$pcbRow['lvp']." V</td>
								<td>".$housingRow['lvp']." V</td>
								<td>".$pottingRow['lvp']." V</td>
							</tr>
							<tr>
								<td rowspan='2'>PD</td>
								<td>Delay</td>
								<td>".$pcbRow['pd_delay']." uS</td>
								<td>".$housingRow['pd_delay']." uS</td>
								<td>".$pottingRow['pd_delay']." uS</td>
							</tr>
							<tr>
								<td>DET Amplitude</td>
								<td>".$pcbRow['pd_det']." V</td>
								<td>".$housingRow['pd_det']." V</td>
								<td>".$pottingRow['pd_det']." V</td>
							</tr>
							<tr>
								<td>SAFE</td>
								<td>No PST/No DET</td>
								<td>".$pcbRow['safe']." </td>
								<td>".$housingRow['safe']." </td>
								<td>".$pottingRow['safe']." </td>
							</tr>
							<tr>
								<td>RESULT</td>
								<td>PASS/FAIL</td>
								<td>".$pcbRow['result']." </td>
								<td>".$housingRow['result']." </td>
								<td>".$pottingRow['result']." </td>
							</tr>
							<tr>
								<td colspan='2'>Operator Name</td>
								<td>".($pcbRow['op_name'] == "" ? "*ATE*" : explode("&", $pcbRow['op_name'])[0]."<br>".explode("&", $pcbRow['op_name'])[1])."</td>
								<td>".($housingRow['op_name'] == "" ? "*ATE*" : explode("&", $housingRow['op_name'])[0]."<br>".explode("&", $housingRow['op_name'])[1])."</td>
								<td>".($pottingRow['op_name'] == "" ? "*ATE*" : explode("&", $pottingRow['op_name'])[0]."<br>".explode("&", $pottingRow['op_name'])[1])."</td>
							</tr>
						</table>
						<br>
					</div>

					<div id='afterPuTable' style='float: left; margin-right: 30px;'>
					<p id='tableInfo'>Final Report</p>
						<table style='font-size: 15px;'>
							<tr id='tableHeader'>
								<td rowspan='2'>Test</td>
								<td>Parameter</td>
								<td>After PU</td>
							</tr>
							<tr>
								<td>PCB Number</td>
								<td>".$afterPuRow['pcb_no']."</td>
							</tr>
							<tr>
								<td rowspan='10'>Mode<br>TIMER_5<br>Sec</td>
								<td>VBAT-PST</td>
								<td>".$afterPuRow['vbat_pst']." mS</td>
							</tr>
							<tr>
								<td>PST Width</td>
								<td>".$afterPuRow['pst_wid']." uS</td>
							</tr>
							<tr>
								<td>PST Amp</td>
								<td>".$afterPuRow['pst_amp']." V</td>
							</tr>
							<tr>
								<td>VEE</td>
								<td>".$afterPuRow['vee']." V</td>
							</tr>
							<tr>
								<td>I @<br>1.5 Sec</td>
								<td>".$afterPuRow['i_1.5']." mA</td>
							</tr>
							<tr>
								<td>I @<br>4.5 Sec</td>
								<td>".$afterPuRow['i_4.5']." mA</td>
							</tr>
							<tr>
								<td>BPF DC<br>Noise</td>
								<td>".$afterPuRow['bpf_noise_dc']." V</td>
							</tr>
							<tr>
								<td>BPF AC<br>Noise</td>
								<td>".$afterPuRow['bpf_noise_ac']." V</td>
							</tr>
							<tr>
								<td>Frequency</td>
								<td>".$afterPuRow['freq']." MHz</td>
							</tr>
							<tr>
								<td>Span</td>
								<td>".$afterPuRow['span']." MHz</td>
							</tr>
							<tr>
								<td rowspan='6'>Calibration<br>Pulse<br>DET</td>
								<td>BPF Cal<br>After PU</td>
								<td>".$afterPuRow['bpf_ac_cal']." V</td>
							</tr>
							<tr>
								<td>Cycles</td>
								<td>".$afterPuRow['cycles']."</td>
							</tr>
							<tr>
								<td>BPF DC</td>
								<td>".$afterPuRow['bpf_dc']." V</td>
							</tr>
							<tr>
								<td>BPF AC</td>
								<td>".$afterPuRow['bpf_ac']." V</td>
							</tr>
							<tr>
								<td>DET Width</td>
								<td>".$afterPuRow['det_wid']." uS</td>
							</tr>
							<tr>
								<td>DET Amp</td>
								<td>".$afterPuRow['det_amp']." V</td>
							</tr>
							<tr>
								<td rowspan='2'>Silence</td>
								<td>SIL at 0</td>
								<td>".$afterPuRow['sil_at_0']."</td>
							</tr>
							<tr>
								<td>SIL</td>
								<td>".$afterPuRow['sil']." mS</td>
							</tr>
							<tr>
								<td rowspan='2'>LVP</td>
								<td>VBAT</td>
								<td>".$afterPuRow['lvp']." V</td>
							</tr>
							<tr>
								<td>VBAT-SIL</td>
								<td>".$afterPuRow['vbat_sil']." S</td>
							</tr>
							<tr>
								<td rowspan='3'>Mode<br>PD</td>
								<td>DET Delay</td>
								<td>".$afterPuRow['pd_delay']." uS</td>
							</tr>
							<tr>
								<td>DET width</td>
								<td>".$afterPuRow['pd_det_width']." uS</td>
							</tr>
							<tr>
								<td>DET Amp</td>
								<td>".$afterPuRow['pd_det_amp']." V</td>
							</tr>
							<tr>
								<td>RESULT</td>
								<td>PASS/FAIL</td>
								<td>".$afterPuRow['result']."</td>
							</tr>
						</table>
						<br>
					</div>

					";
					
					break;

				case "EPD":

					$pcbQuery =  "SELECT * FROM `pcb_epd_csv` WHERE `pcb_no` = '".$pcb_no."'";
					$pcbResult = mysqli_query($db, $pcbQuery);
					$pcbRow = mysqli_fetch_assoc($pcbResult);

					$html.= "
						<div id='epdPcbTable' style='clear: both;'>
						<p id='tableInfo'>Test Reports</p>
						<table style='font-size: 15px;'>
							<tr id='tableHeader'>
								<td rowspan='2'>Test</td>
								<td>Parameter</td>
								<td>PCB Testing</td>
								<td>Housing</td>
								<td>Potting</td>
								<td>Electronic<br>Head</td>
							</tr>
							<tr>
								<td>PCB Number</td>
								<td colspan='4'>".str_replace("EPD", "", $pcbRow['pcb_no'])."</td>
							</tr>
							<tr>
								<td rowspan='2'>VIN</td>
								<td>Current (I)</td>
								<td>".$pcbRow['vbat_i']." mA</td>
							</tr>
							<tr>
								<td>VDD</td>
								<td>".$pcbRow['vdd']." V</td>
							</tr>
							<tr>
								<td rowspan='3'>PST<br>Test</td>
								<td>PST Amplitude</td>
								<td>".$pcbRow['pst_amp']." V</td>
							</tr>
							<tr>
								<td>PST Width</td>
								<td>".$pcbRow['pst_width']." uS</td>
							<tr>
								<td>VBAT-PST Delay</td>
								<td>".$pcbRow['pst_delay']." mS</td>
							</tr>
							<tr>
								<td rowspan='3'>PD<br>Test</td>
								<td>DET Amplitude</td>
								<td>".$pcbRow['pd_amp']." V</td>
							</tr>
							<tr>
								<td>DET Width</td>
								<td>".$pcbRow['pd_width']." uS</td>
							<tr>
								<td>DET Delay</td>
								<td>".$pcbRow['pd_delay']." uS</td>
							</tr>
							<tr>
								<td rowspan='3'>Delay<br>Test</td>
								<td>DET Amplitude</td>
								<td>".$pcbRow['delay_amp']." V</td>
							</tr>
							<tr>
								<td>DET Width</td>
								<td>".$pcbRow['delay_width']." uS</td>
							<tr>
								<td>DET Delay</td>
								<td>".$pcbRow['delay_delay']." mS</td>
							</tr>
							<tr>
								<td rowspan='3'>Switch<br>Integrity<br>Test</td>
								<td>DET Amplitude</td>
								<td>".$pcbRow['si_amp']." V</td>
							</tr>
							<tr>
								<td>DET Width</td>
								<td>".$pcbRow['si_width']." uS</td>
							<tr>
								<td>DET Delay</td>
								<td>".$pcbRow['si_delay']." mS</td>
							</tr>
							<tr>
								<td>SAFE</td>
								<td>No PST/No DET</td>
								<td>PST Amp = ".$pcbRow['safe_pst']."V<br>DET Amp = ".$pcbRow['safe_det']."V</td>
							</tr>
							<tr>
								<td>RESULT</td>
								<td>PASS/FAIL</td>
								<td>".$pcbRow['result']." </td>
							</tr>
							<!--<tr>		//disabled
								<td colspan='2'>Operator Name</td>
								<td>".($pcbRow['op_name'] == "" ? "*ATE*" : explode("&", $pcbRow['op_name'])[0]."<br>".explode("&", $pcbRow['op_name'])[1])."</td>
								<td>".($housingRow['op_name'] == "" ? "*ATE*" : explode("&", $housingRow['op_name'])[0]."<br>".explode("&", $housingRow['op_name'])[1])."</td>
								<td>".($pottingRow['op_name'] == "" ? "*ATE*" : explode("&", $pottingRow['op_name'])[0]."<br>".explode("&", $pottingRow['op_name'])[1])."</td>
							</tr>-->
						</table>
						<br>
					</div>
					";
			}

			$html.=	"
								<div id='rejectionTable' style='float: bottom; margin-left: 15px;'>
									<p id='tableInfo'>Rejection Report</p>
									<table style='width: 170px;'>
										<tr id='tableHeader'>
											<td>Parameters</td>
											<td>Information<br></td>
										</tr>
										<tr>
											<td>Status</td>
											<td>".($lotRow['rejected'] == '0' ? 'ACCEPTED' : 'REJECTED')."</td>
										</tr>
										<tr>
											<td>Rejection<br>stage</td>
											<td>".($lotRow['rejected'] == '0' ? '--' : $lotRow['rejection_stage'])."</td>
										</tr>
										<tr>
											<td>Remark</td>
											<td>".($lotRow['rejected'] == '0' ? '--' : $lotRow['rejection_remark'])."</td>
										</tr>
									</table>
									<br>
								</div>

								</body>
							</html>
							";

			$html.= "
							<div id='batteryTable' style='float: bottom; margin-left: 15px;'>
								<p id='tableInfo'>Battery Information</p>
								<table style='width: 210px;'>
									<tr id='tableHeader'>
										<td colspan='2'>Details</td>
									</tr>
									<tr>
										<td>Battery Lot</td>
										<td>".($batteryRow['battery_lot'] == '' ? 'Unavailable' : $batteryRow['battery_lot'])."</td>
									</tr>
								</table>
							</div>
							";

			$html.= "
							<div id='barcodeTable' style='float: bottom; margin-left: 15px;'>
								<p id='tableInfo'>Barcode Information</p>
								<table style='width: 210px;'>
									<tr id='tableHeader'>
										<td colspan='2'>Details</td>
									</tr>
									<tr>
										<td>Barcode Number</td>
										<td>".($barcodeRow['barcode_no'] == '' ? 'Unavailable' : $barcodeRow['barcode_no'])."</td>
									</tr>
								</table>
							</div>
							";

			echo $html;
?>
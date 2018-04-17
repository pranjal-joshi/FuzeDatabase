<?php
	include('db_config.php');

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
										<h5 style='color: red'>We can't let you search!</h5>
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

		$lotQuery = "SELECT * FROM `lot_table` WHERE `pcb_no` = '".$pcb_no."'";
		$lotResult = mysqli_query($db, $lotQuery);
		$lotRow = mysqli_fetch_assoc($lotResult);

		$qaQuery =  "SELECT * FROM `qa_table` WHERE `pcb_no` = '".$pcb_no."'";
		$qaResult = mysqli_query($db, $qaQuery);
		$qaRow = mysqli_fetch_assoc($qaResult);

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
						padding: 6px;
					}

					table, th, td {
						border: 1px solid black;
						border-collapse: collapse;
					}

					body {
						margin-left: 12px;
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
				</style>
			</head>

			<body>
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
							<td>".$lotRow['pcb_no']."</td>
							<td>".$lotRow['main_lot']."</td>
							<td>".$lotRow['kit_lot']."</td>
						</tr>
					</table>
					<br>
				</div>

				<div id='qaTable' style='float: left;'>
					<p id='tableInfo'>Q/A Information</p>
					<table>
						<tr id='tableHeader'>
							<td>PCB Number</td>
							<td>Result</td>
							<td>Rejection<br>Code</td>
							<td>Record Date</td>
							<td>Operator</td>
						</tr>
						<tr>
							<td>".$qaRow['pcb_no']."</td>
							<td>".($qaRow['result'] == '1' ? 'PASS' : 'FAIL')."</td>
							<td>".$qaRow['reason']."</td>
							<td>".$qaRow['record_date']."</td>
							<td>".$qaRow['op_name']."</td>
						</tr>
					</table>
					<br>
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
					<br>
						<p id='tableInfo'>Calibration Record</p>
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
						<br>
					</div>

					<div id='pcbTable' style='float: left; margin-right: 15px;'>
						<p id='tableInfo'>Test Records</p>
						<table style='font-size: 15px;'>
							<tr id='tableHeader'>
								<td rowspan='2'>Test</td>
								<td>Parameter</td>
								<td>PCB Testing</td>
								<td>Housing</td>
								<td>Potting</td>
								<td>After PU</td>
							</tr>
							<tr>
								<td>PCB Number</td>
								<td colspan='4'>".$pcbRow['pcb_no']."</td>
								<!--<td>".$housingRow['pcb_no']."</td>
								<td>".$pottingRow['pcb_no']."</td>
								<td>".$afterPuRow['pcb_no']."</td>-->
							</tr>
							<tr>
								<td rowspan='2'>VIN</td>
								<td>Current (I)</td>
								<td>".$pcbRow['i']." mA</td>
								<td>".$housingRow['i']." mA</td>
								<td>".$pottingRow['i']." mA</td>
								<td>".$afterPuRow['i']." mA</td>
							</tr>
							<tr>
								<td>VEE</td>
								<td>".$pcbRow['vee']." V</td>
								<td>".$housingRow['vee']." V</td>
								<td>".$pottingRow['vee']." V</td>
								<td>".$afterPuRow['vee']." V</td>
							</tr>
							<tr>
								<td rowspan='3'>PST Test</td>
								<td>VBAT-PST Delay</td>
								<td>".$pcbRow['vbat_pst']." mS</td>
								<td>".$housingRow['vbat_pst']." mS</td>
								<td>".$pottingRow['vbat_pst']." mS</td>
								<td>".$afterPuRow['vbat_pst']." mS</td>
							</tr>
							<tr>
								<td>PST Amplitude</td>
								<td>".$pcbRow['pst_amp']." V</td>
								<td>".$housingRow['pst_amp']." V</td>
								<td>".$pottingRow['pst_amp']." V</td>
								<td>".$afterPuRow['pst_amp']." V</td>
							</tr>
							<tr>
								<td>PST Width</td>
								<td>".$pcbRow['pst_wid']." uS</td>
								<td>".$housingRow['pst_wid']." uS</td>
								<td>".$pottingRow['pst_wid']." uS</td>
								<td>".$afterPuRow['pst_wid']." uS</td>
							</tr>
							<tr>
								<td rowspan='3'>MOD Test</td>
								<td>Frequency</td>
								<td>".$pcbRow['mod_freq']." KHz</td>
								<td>".$housingRow['mod_freq']." KHz</td>
								<td>".$pottingRow['mod_freq']." KHz</td>
								<td>".$afterPuRow['mod_freq']." KHz</td>
							</tr>
							<tr>
								<td>DC</td>
								<td>".$pcbRow['mod_dc']." V</td>
								<td>".$housingRow['mod_dc']." V</td>
								<td>".$pottingRow['mod_dc']." V</td>
								<td>".$afterPuRow['mod_dc']." V</td>
							</tr>
							<tr>
								<td>AC</td>
								<td>".$pcbRow['mod_ac']." V</td>
								<td>".$housingRow['mod_ac']." V</td>
								<td>".$pottingRow['mod_ac']." V</td>
								<td>".$afterPuRow['mod_ac']." V</td>
							</tr>
							<tr>
								<td>DET CAP<br>Charge T</td>
								<td>VBAT-Cap Charge T</td>
								<td>".$pcbRow['cap_charge']." mS</td>
								<td>".$housingRow['cap_charge']." mS</td>
								<td>".$pottingRow['cap_charge']." mS</td>
								<td>".$afterPuRow['cap_charge']." mS</td>
							</tr>
							<tr>
								<td rowspan='2'>VRF</td>
								<td>Amplitude</td>
								<td>".$pcbRow['vrf_amp']." V</td>
								<td>".$housingRow['vrf_amp']." V</td>
								<td>".$pottingRow['vrf_amp']." V</td>
								<td>".$afterPuRow['vrf_amp']." V</td>
							</tr>
							<tr>
								<td>VBAT-VRF Delay</td>
								<td>".$pcbRow['vbat_vrf']." Sec</td>
								<td>".$housingRow['vbat_vrf']." Sec</td>
								<td>".$pottingRow['vbat_vrf']." Sec</td>
								<td>".$afterPuRow['vbat_vrf']." Sec</td>
							</tr>
							<tr>
								<td>Silence</td>
								<td>VBAT-SIL Delay</td>
								<td>".$pcbRow['vbat_sil']." Sec</td>
								<td>".$housingRow['vbat_sil']." Sec</td>
								<td>".$pottingRow['vbat_sil']." Sec</td>
								<td>".$afterPuRow['vbat_sil']." Sec</td>
							</tr>
							<tr>
								<td  rowspan='5'>PROX</td>
								<td>DET Pulse Width</td>
								<td>".$pcbRow['det_wid']." uS</td>
								<td>".$housingRow['det_wid']." uS</td>
								<td>".$pottingRow['det_wid']." uS</td>
								<td>".$afterPuRow['det_wid']." uS</td>
							</tr>
							<tr>
								<td>DET Amplitude</td>
								<td>".$pcbRow['det_amp']." V</td>
								<td>".$housingRow['det_amp']." V</td>
								<td>".$pottingRow['det_amp']." V</td>
								<td>".$afterPuRow['det_amp']." V</td>
							</tr>
							<tr>
								<td>Cycles</td>
								<td>".$pcbRow['cycles']." </td>
								<td>".$housingRow['cycles']."</td>
								<td>".$pottingRow['cycles']."</td>
								<td>".$afterPuRow['cycles']." </td>
							</tr>
							<tr>
								<td>BPF DC</td>
								<td>".$pcbRow['bpf_dc']." V</td>
								<td>".$housingRow['bpf_dc']." V</td>
								<td>".$pottingRow['bpf_dc']." V</td>
								<td>".$afterPuRow['bpf_dc']." V</td>
							</tr>
							<tr>
								<td>BPF AC</td>
								<td>".$pcbRow['bpf_ac']." V</td>
								<td>".$housingRow['bpf_ac']." V</td>
								<td>".$pottingRow['bpf_ac']." V</td>
								<td>".$afterPuRow['bpf_ac']." V</td>
							</tr>
							<tr>
								<td>Noise</td>
								<td>SIL</td>
								<td>".$pcbRow['sil']." mS</td>
								<td>".$housingRow['sil']." mS</td>
								<td>".$pottingRow['sil']." mS</td>
								<td>".$afterPuRow['sil']." mS</td>
							</tr>
							<tr>
								<td>LVP</td>
								<td>VBAT</td>
								<td>".$pcbRow['lvp']." V</td>
								<td>".$housingRow['lvp']." V</td>
								<td>".$pottingRow['lvp']." V</td>
								<td>".$afterPuRow['lvp']." V</td>
							</tr>
							<tr>
								<td rowspan='2'>PD</td>
								<td>Delay</td>
								<td>".$pcbRow['pd_delay']." uS</td>
								<td>".$housingRow['pd_delay']." uS</td>
								<td>".$pottingRow['pd_delay']." uS</td>
								<td>".$afterPuRow['pd_delay']." uS</td>
							</tr>
							<tr>
								<td>DET Amplitude</td>
								<td>".$pcbRow['pd_det']." V</td>
								<td>".$housingRow['pd_det']." V</td>
								<td>".$pottingRow['pd_det']." V</td>
								<td>".$afterPuRow['pd_det']." V</td>
							</tr>
							<tr>
								<td>SAFE</td>
								<td>No PST/No DET</td>
								<td>".$pcbRow['safe']." </td>
								<td>".$housingRow['safe']." </td>
								<td>".$pottingRow['safe']." </td>
								<td>".$afterPuRow['safe']." </td>
							</tr>
							<tr>
								<td>RESULT</td>
								<td>PASS/FAIL</td>
								<td>".$pcbRow['result']." </td>
								<td>".$housingRow['result']." </td>
								<td>".$pottingRow['result']." </td>
								<td>".$afterPuRow['result']." </td>
							</tr>
							<tr>
								<td colspan='2'>Operator Name</td>
								<td>".($pcbRow['op_name'] == "" ? "*ATE*" : $pcbRow['op_name'])."</td>
								<td>".($housingRow['op_name'] == "" ? "*ATE*" : $housingRow['op_name'])."</td>
								<td>".($pottingRow['op_name'] == "" ? "*ATE*" : $pottingRow['op_name'])."</td>
								<td>".($afterPuRow['op_name'] == "" ? "*ATE*" : $afterPuRow['op_name'])."</td>
							</tr>
						</table>
						<br>
					</div>";
					
					break;
			}

			$html.=	"
								<div id='rejectionTable' style='float: left; margin-left: 15px;'>
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

			echo $html;
?>
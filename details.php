<?php
	include('db_config.php');

	set_error_handler('exceptions_error_handler');

	function exceptions_error_handler($severity, $message, $filename, $lineno) {
		if (error_reporting() == 0) {
			return;
		}
		if (error_reporting() & $severity) {
			throw new ErrorException($message, 0, $severity, $filename, $lineno);
		}
	}

	function curPageURL() {
		$pageURL = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		return $pageURL;
	}

	$url = parse_url(curPageURL());

	$splitUrl = explode("&", $url['query']);

	$toSearch = explode("=", $splitUrl[0])[1];
	$searchIn = explode("=", $splitUrl[1])[1];
	$searchTable = explode("=", $splitUrl[2])[1];

	if(!isset($_COOKIE["fuzeLogin"])){
			die("

				<head>
					<link rel='stylesheet' type='text/css' href='/fuze/materialize.min.css'>
					<script type='text/javascript' src='/fuze/jquery.min.js'></script>
					<script type='text/javascript' src='/fuze/materialize.min.js'></script>
					<script type='text/javascript' src='/fuze/jquery.cookie.js'></script>

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
						<a href='#!'' class='brand-logo center'>Searching without Logging in?</a>
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
										<a href='/fuze/index.php'>Go Back to login page</a>
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
				<link rel='stylesheet' type='text/css' href='/fuze/materialize.min.css'>
				<script type='text/javascript' src='/fuze/jquery.min.js'></script>
				<script type='text/javascript' src='/fuze/materialize.min.js'></script>
				<script type='text/javascript' src='/fuze/jquery.cookie.js'></script>

				<!-- Set responsive viewport -->
				<meta name='viewport' content='width=device-width, initial-scale=1.0'/>

				<!-- Disable caching of browser -->
				<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
				<meta http-equiv='Pragma' content='no-cache' />
				<meta http-equiv='Expires' content='0' />

				<title>Fuze-Details</title>
			</head>

			<body class='indexBody'>
				<main class='contents'>

				<nav>
					<div class='nav-wrapper teal lighten-2' id='detailsNav'>
						<a href='#!'' class='brand-logo center'>Fuze Details</a>

						<a><span class='white-text text-darken-5 right' style='font-size: 18px; padding-right: 20px; font-weight: bold' onclick='logout()'>Logout</span></a>

						<a><span class='white-text text-darken-5 left' style='font-size: 18px; padding-left: 20px; font-weight: bold' onclick='self.close();'>Back</span></a>
					</div>
				</nav>

				<div class='row'>
					<div class='col m2'></div>
					<div class='col m8 s12'>

					<br>
		";

		$sql = "";

		switch ($searchTable) {

			case 'qa_table':
				$sql = $sql = "SELECT * FROM `".$searchTable."` WHERE `".$searchIn."` = '".$toSearch."'";
				$results = mysqli_query($db,$sql);

				if(!$results){
					die("
							<center>
								<span style='font-weight: bold; font-size: 22px' class='red-text text-darken-2'>Search Failure!</span>
							</center>
						");
				}
				else {
					$row = mysqli_fetch_row($results);
					$html.="
					<div class='card-panel grey lighten-4' id='qaDetailsCard'>
						<div class='row'>
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='qaDetailsTitle'>QA Report</span>
							</center>

							<form id='qaDetailsForm'>
							<br>
								<table id='qaDetailsTable'>
									<tbody>

									<tr>
										<td class='center'><span class='center'>PCB Number <span></td>
										<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
										<td class='center'>
											<div class='input-field col s12 center'>
												<input type='text' id='qaDetailsPcbNo'>
											</div>
										</td>
									</tr>

									<tr>
										<td class='center'><span class='center'>Result <span></td>
										<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
										<td class='center'>
											<div class='input-field col s12 center'>
												<input type='text' id='qaDetailsResult'>
											</div>
										</td>
									</tr>

									<tr>
										<td class='center'><span class='center'>Rejection reason <span></td>
										<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
										<td class='center'>
											<div class='input-field col s12 center'>
												<input type='text' id='qaDetailsReason'>
											</div>
										</td>
									</tr>

									<tr>
										<td class='center'><span class='center'>Date <span></td>
										<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
										<td class='center'>
											<div class='input-field col s12 center'>
												<input type='text' id='qaDetailsTimestamp'>
											</div>
										</td>
									</tr>

									<tr>
										<td class='center'><span class='center'>Operator <span></td>
										<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
										<td class='center'>
											<div class='input-field col s12 center'>
												<input type='text' id='qaDetailsOperator'>
											</div>
										</td>
									</tr>

									</tbody>
								</table>
							</form>

						</div>
					</div>
									";
				}
				$html.= "<script type='text/javascript'>";
					try {
					// SCRIPT FOR AFTER_PU CARD
						switch ($row[3]) {
							case '1':
								$row[3] = "1 - Wire not properly soldered";
								break;
							case '2':
								$row[3] = "2 - Broken wire, Damaged Insulation";
								break;
							case '3':
								$row[3] = "3 - Improper wire length";
								break;
							case '4':
								$row[3] = "4 - DET pin not soldered properly";
								break;
							case '5':
								$row[3] = "5 - VIN pin not soldered properly";
								break;
							case '6':
								$row[3] = "6 - PST pin not soldered properly";
								break;
							case '7':
								$row[3] = "7 - SW1/IMP pin not soldered properly";
								break;
							case '8':
								$row[3] = "8 - GND pin not soldered properly";
								break;
							case '9':
								$row[3] = "9 - MOD pin not soldered properly";
								break;
							case '10':
								$row[3] = "10 - SIG pin not soldered properly";
								break;
							case '11':
								$row[3] = "11 - VRF pin not soldered properly";
								break;
							case '12':
								$row[3] = "12 - Pin cross / bend";
								break;
							case '13':
								$row[3] = "13 - Improper pin length";
								break;
							case '14':
								$row[3] = "14 - Pin / test pin cut";
								break;
							case '15':
								$row[3] = "15 - Plating of pin / test pin";
								break;
							case '16':
								$row[3] = "16 - Soldering ring not observed (bottom side)";
								break;
							case '17':
								$row[3] = "17 - Solder balls seen";
								break;
							case '18':
								$row[3] = "18 - Imapct switch soldering improper";
								break;
							case '19':
								$row[3] = "19 - Excess solder on impact switch";
								break;
							case '20':
								$row[3] = "20 - Damanged / swollen bush of imapct switch";
								break;
							case '21':
								$row[3] = "21 - Imapct switch tilted";
								break;
							case '22':
								$row[3] = "22 - Excess flux";
								break;
							case '23':
								$row[3] = "23 - Components not properly soldered";
								break;
							case '24':
								$row[3] = "24 - Soldered components damaged";
								break;
							case '25':
								$row[3] = "25 - Wrong components soldered";
								break;
							case '26':
								$row[3] = "26 - Shorting of component pins";
								break;
							case '27':
								$row[3] = "27 - Component missing";
								break;
							case '28':
								$row[3] = "28 - PCB track cut";
								break;
							case '29':
								$row[3] = "29 - Solder pan on PCB damaged / removed";
								break;
							case '30':
								$row[3] = "30 - Improper barcode printing";
								break;
							case '31':
								$row[3] = "31 - Crystal pad damaged";
								break;
							case '100':
								$row[3] = "100 - MULTIPLE FAULTS";
								break;
							default:
								$row[3] = "Not Applicable";
								break;
						}

						$html.= "	$('#qaDetailsPcbNo').val('".$row[1]."');
											$('#qaDetailsResult').val('".($row[2] == '1' ? 'PASS' : 'FAIL')."');
											$('#qaDetailsReason').val('".$row[3]."');
											$('#qaDetailsTimestamp').val('".$row[4]."');
											$('#qaDetailsOperator').val('".$row[5]."');
											";

						// ### Control record modification based on login access
						if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
							$html.= "$('input[type=text]').prop('readonly','true');";
						}
					}
					catch(Exception $e){
							$html.="
								$('#qaDetailsForm').hide();
								document.getElementById('qaDetailsTitle').innerHTML = 'Failed to search the given parameter!';
							";
					}
					$html.= "</script>";
				break;

			case 'after_pu':
				$sql = $sql = "SELECT * FROM `".$searchTable."` WHERE `".$searchIn."` = '".$toSearch."'";
				$results = mysqli_query($db,$sql);

				if(!$results){
					die("
							<center>
								<span style='font-weight: bold; font-size: 22px' class='red-text text-darken-2'>Search Failure!</span>
							</center>
						");
				}
				else {
					$row = mysqli_fetch_row($results);
					$html.="
					<div class='card-panel grey lighten-4' id='afterPuDetailsCard'>
						<div class='row'>
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='afterPuDetailsTitle'>After PU Report</span>
							</center>

							<form id='afterPuDetailsForm'>
							<br>
								<table id='afterPuDetailsTable'>
									<tbody>

										<tr>
										<td class='center'><span class='center'>PCB Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Current (I) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsCurrent' data-position='bottom' data-delay='500' data-tooltip='7 to 14 mA' class='tooltipped'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Voltage (VEE) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsVee' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.30 to 6.20 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PST Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>VBAT-PST Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsVbatPst' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='600 to 700 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsPstAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='12 to 21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Width <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsPstWid' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>MOD Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>Frequency <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsFreq' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='46 to 55 KHz'>
												</div>
											</td>
											<td class='center'><span class='center'>DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsModDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='7 to 8.1 V'>
												</div>
											</td>
											<td class='center'><span class='center'>AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsModAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0.95 to 1.35 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>VRF Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>VRF Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsVrfAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='15.3 to 16.7 V'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-VRF Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsVbatVrf' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.08 to 2.30 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-Cap Charge T <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsCapCharge' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='695 to 730 mS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PROX Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>DET Width <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>Cycles <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsCycles' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4 to 6'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsBpfDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.2 to 6.4 V'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsBpfAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.5 to 3.6 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Noise Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>SIL <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='480 to 650 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-SIL Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsVbatSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.7 to 3.2 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>LVP <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsLvp' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='18.8 to 21 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PD Test</span></center>

								<table>
									<tbody>

											<td class='center'><span class='center'>Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsPDDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0 to 10 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsPDDet' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -22 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Results</span></center>

								<table>
									<tbody>

											<td class='center'><span class='center'>SAFE Test <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsSafe'>
												</div>
											</td>
											<td class='center'><span class='center'>Result <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='AfterPuDetailsResult'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

							</form>

						</div>
					</div>

					";
					$html.= "<script type='text/javascript'>";
					try {
					// SCRIPT FOR AFTER_PU CARD
						$html.= "	$('#AfterPuDetailsPcbNo').val('".$row[1]."');
											$('#AfterPuDetailsCurrent').val('".$row[2]." mA');
											$('#AfterPuDetailsVee').val('".$row[3]." V');
											$('#AfterPuDetailsVbatPst').val('".$row[4]." mS');
											$('#AfterPuDetailsPstAmpl').val('".$row[5]." V');
											$('#AfterPuDetailsPstWid').val('".$row[6]." uS');
											$('#AfterPuDetailsFreq').val('".$row[7]." KHz');
											$('#AfterPuDetailsModDC').val('".$row[8]." V');
											$('#AfterPuDetailsModAC').val('".$row[9]." V');
											$('#AfterPuDetailsCapCharge').val('".$row[10]." mS');
											$('#AfterPuDetailsVrfAmpl').val('".$row[11]." V');
											$('#AfterPuDetailsVbatVrf').val('".$row[12]." Sec');
											$('#AfterPuDetailsVbatSil').val('".$row[13]." Sec');
											$('#AfterPuDetailsDetWidth').val('".$row[14]." uS');
											$('#AfterPuDetailsDetAmpl').val('".$row[15]." V');
											$('#AfterPuDetailsCycles').val('".$row[16]."');
											$('#AfterPuDetailsBpfAC').val('".$row[17]." V');
											$('#AfterPuDetailsBpfDC').val('".$row[18]." V');
											$('#AfterPuDetailsSil').val('".$row[19]." mS');
											$('#AfterPuDetailsLvp').val('".$row[20]." V');
											$('#AfterPuDetailsPDDelay').val('".$row[21]." uS');
											$('#AfterPuDetailsPDDet').val('".$row[22]." V');
											$('#AfterPuDetailsSafe').val('".$row[23]."');
											$('#AfterPuDetailsResult').val('".$row[24]."');


											";

						// ### Control record modification based on login access
						if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
							$html.= "$('input[type=text]').prop('readonly','true');";
						}
					}
					catch(Exception $e){
							$html.="
								$('#afterPuDetailsForm').hide();
								document.getElementById('calibrationDetailsTitle').innerHTML = 'Failed to search the given parameter!';
							";
					}
					$html.= "</script>";
				}
				break;

			case 'pcb_testing':
				$sql = $sql = "SELECT * FROM `".$searchTable."` WHERE `".$searchIn."` = '".$toSearch."'";
				$results = mysqli_query($db,$sql);

				if(!$results){
					die("
							<center>
								<span style='font-weight: bold; font-size: 22px' class='red-text text-darken-2'>Search Failure!</span>
							</center>
						");
				}
				else {
					$row = mysqli_fetch_row($results);
					$html.="
					<div class='card-panel grey lighten-4' id='pcbTestingDetailsCard'>
						<div class='row'>
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='pcbTestingDetailsTitle'>PCB Test Report</span>
							</center>

							<form id='pcbTestingDetailsForm'>
							<br>
								<table id='pcbTestingDetailsTable'>
									<tbody>

										<tr>
										<td class='center'><span class='center'>PCB Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Current (I) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsCurrent' data-position='bottom' data-delay='500' data-tooltip='7 to 14 mA' class='tooltipped'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Voltage (VEE) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsVee' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.30 to 6.20 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PST Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>VBAT-PST Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsVbatPst' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='600 to 700 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsPstAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='12 to 21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Width <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsPstWid' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>MOD Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>Frequency <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsFreq' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='46 to 55 KHz'>
												</div>
											</td>
											<td class='center'><span class='center'>DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsModDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='7 to 8.1 V'>
												</div>
											</td>
											<td class='center'><span class='center'>AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsModAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0.95 to 1.35 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>VRF Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>VRF Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsVrfAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='15.3 to 16.7 V'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-VRF Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsVbatVrf' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.08 to 2.30 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-Cap Charge T <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsCapCharge' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='695 to 730 mS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PROX Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>DET Width <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>Cycles <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsCycles' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4 to 6'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsBpfDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.2 to 6.4 V'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsBpfAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.5 to 3.6 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Noise Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>SIL <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='480 to 650 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-SIL Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsVbatSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.7 to 3.2 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>LVP <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsLvp' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='18.8 to 21 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PD Test</span></center>

								<table>
									<tbody>

											<td class='center'><span class='center'>Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsPDDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0 to 10 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsPDDet' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -22 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Results</span></center>

								<table>
									<tbody>

											<td class='center'><span class='center'>SAFE Test <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsSafe'>
												</div>
											</td>
											<td class='center'><span class='center'>Result <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsResult'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

							</form>

						</div>
					</div>

					";
					$html.= "<script type='text/javascript'>";
					try {
					// SCRIPT FOR PCB_TESTING CARD
						$html.= "	$('#PcbTestingDetailsPcbNo').val('".$row[1]."');
											$('#PcbTestingDetailsCurrent').val('".$row[2]." mA');
											$('#PcbTestingDetailsVee').val('".$row[3]." V');
											$('#PcbTestingDetailsVbatPst').val('".$row[4]." mS');
											$('#PcbTestingDetailsPstAmpl').val('".$row[5]." V');
											$('#PcbTestingDetailsPstWid').val('".$row[6]." uS');
											$('#PcbTestingDetailsFreq').val('".$row[7]." KHz');
											$('#PcbTestingDetailsModDC').val('".$row[8]." V');
											$('#PcbTestingDetailsModAC').val('".$row[9]." V');
											$('#PcbTestingDetailsCapCharge').val('".$row[10]." mS');
											$('#PcbTestingDetailsVrfAmpl').val('".$row[11]." V');
											$('#PcbTestingDetailsVbatVrf').val('".$row[12]." Sec');
											$('#PcbTestingDetailsVbatSil').val('".$row[13]." Sec');
											$('#PcbTestingDetailsDetWidth').val('".$row[14]." uS');
											$('#PcbTestingDetailsDetAmpl').val('".$row[15]." V');
											$('#PcbTestingDetailsCycles').val('".$row[16]."');
											$('#PcbTestingDetailsBpfAC').val('".$row[17]." V');
											$('#PcbTestingDetailsBpfDC').val('".$row[18]." V');
											$('#PcbTestingDetailsSil').val('".$row[19]." mS');
											$('#PcbTestingDetailsLvp').val('".$row[20]." V');
											$('#PcbTestingDetailsPDDelay').val('".$row[21]." uS');
											$('#PcbTestingDetailsPDDet').val('".$row[22]." V');
											$('#PcbTestingDetailsSafe').val('".$row[23]."');
											$('#PcbTestingDetailsResult').val('".$row[24]."');


											";

						// ### Control record modification based on login access
						if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
							$html.= "$('input[type=text]').prop('readonly','true');";
						}
					}
					catch(Exception $e){
							$html.="
								$('#pcbTestingDetailsForm').hide();
								document.getElementById('pcbTestingDetailsTitle').innerHTML = 'Failed to search the given parameter!';
							";
					}
					$html.= "</script>";
				}
				break;

			case 'calibration_table':
				$sql = $sql = "SELECT * FROM `".$searchTable."` WHERE `".$searchIn."` = '".$toSearch."'";
				$results = mysqli_query($db,$sql);

				if(!$results){
					die("
							<center>
								<span style='font-weight: bold; font-size: 22px' class='red-text text-darken-2'>Search Failure!</span>
							</center>
						");
				}
				else {
					$row = mysqli_fetch_row($results);
					switch ($row[5])
					{
						case '1':
							$row[5] = "Yes";
							break;
						
						default:
							$row[5] = "No";
							break;
					}
					$html.="
					<div class='card-panel grey lighten-4' id='calibrationDetailsCard'>
						<div class='row'>
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='calibrationDetailsTitle'>Calibration Report</span>
							</center>

							<form id='calibrationDetailsForm'>
							<br>
								<table id='calibrationDetailsTable'>
									<thead>
										<th class='center'>Parameters</th>
										<th class='center'></th>
										<th class='center'>Values</th>
										<th class='center'>Parameters</th>
										<th class='center'></th>
										<th class='center'>Values</th>
									</thead>
									<tbody>

										<tr>
											<td class='center'><span class='center'>PCB Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>RF Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsRfNo'>
												</div>
											</td>
										</tr>

										<tr>
											<td class='center'><span class='center'>BPF AC (Before)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsBpfbefore'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF AC (After)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsBpfAfter'>
												</div>
											</td>
										</tr>

										<tr>
											<td class='center'><span class='center'>Frequency (Before)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsFreqBefore'>
												</div>
											</td>
											<td class='center'><span class='center'>Frequency (After)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsFreqAfter'>
												</div>
											</td>
										</tr>

										<tr>
											<td class='center'><span class='center'>Resistor Changed?<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsResChange'>
												</div>
											</td>
											<td class='center'><span class='center'>Resistor Value<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsResValue'>
												</div>
											</td>
										</tr>

										<tr>
											<td class='center'><span class='center'>Date<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsDate'>
												</div>
											</td>
											<td class='center'><span class='center'>Operator<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsOperator'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>
							</form>
						</div>
					</div>
				";
				}

				$html.= "<script type='text/javascript'>";
				try {
				// SCRIPT FOR CALIBRATION CARD
					$html.= "	$('#calibrationDetailsPcbNo').val('".$row[1]."');
										$('#calibrationDetailsRfNo').val('".$row[2]."');
										$('#calibrationDetailsFreqBefore').val('".$row[3]." MHz');
										$('#calibrationDetailsBpfbefore').val('".$row[4]." V');
										$('#calibrationDetailsResChange').val('".$row[5]."');
										$('#calibrationDetailsResValue').val('".$row[6]."K\u2126');
										$('#calibrationDetailsFreqAfter').val('".$row[7]." MHz');
										$('#calibrationDetailsBpfAfter').val('".$row[8]." V');
										$('#calibrationDetailsDate').val('".$row[9]."');
										$('#calibrationDetailsOperator').val('".$row[10 ]."');
										";

					// ### Control record modification based on login access
					if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
						$html.= "$('input[type=text]').prop('readonly','true');";
					}
				}
				catch(Exception $e){
						$html.="
							$('#calibrationDetailsForm').hide();
							document.getElementById('calibrationDetailsTitle').innerHTML = 'Failed to search the given parameter!';
						";
				}
				$html.= "</script>";

				break;
		}

		$html.="
						</div>
					</div>
					</main>

					<footer class='page-footer teal lighten-2'>
						<div class='footer-copyright'>
							<div class='container'>
								<center>&copy; Bharat Electronics Ltd. (2018), All rights reserved.</center>
							</div>
						</div>
					</footer>

				</body>

				<script type='text/javascript'>
					function logout(){
						document.cookie = 'fuzeLogin=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
						location.href = '/fuze/index.php';
					}
					";
				$html.= "</script>
								</html>";

		echo $html;

		mysqli_close($db);
?>
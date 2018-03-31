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
		return urldecode($pageURL);
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$form = $_POST['form'];
		switch ($form) {
			case 'qaUpdate':
				$pcb_no = $_POST['pcb_no'];
				$reason = $_POST['reason'];
				$result = (strtoupper($_POST['result']) == "PASS" ? '1' : '0');
				$timestamp = $_POST['timestamp'];
				$op_name = strtoupper($_POST['op_name']);

				$reasonToSave = "";
				switch ($reason) {
							case '1':
								$reasonToSave = "1 - Wire not properly soldered";
								break;
							case '2':
								$reasonToSave = "2 - Broken wire, Damaged Insulation";
								break;
							case '3':
								$reasonToSave = "3 - Improper wire length";
								break;
							case '4':
								$reasonToSave = "4 - DET pin not soldered properly";
								break;
							case '5':
								$reasonToSave = "5 - VIN pin not soldered properly";
								break;
							case '6':
								$reasonToSave = "6 - PST pin not soldered properly";
								break;
							case '7':
								$reasonToSave = "7 - SW1/IMP pin not soldered properly";
								break;
							case '8':
								$reasonToSave = "8 - GND pin not soldered properly";
								break;
							case '9':
								$reasonToSave = "9 - MOD pin not soldered properly";
								break;
							case '10':
								$reasonToSave = "10 - SIG pin not soldered properly";
								break;
							case '11':
								$reasonToSave = "11 - VRF pin not soldered properly";
								break;
							case '12':
								$reasonToSave = "12 - Pin cross / bend";
								break;
							case '13':
								$reasonToSave = "13 - Improper pin length";
								break;
							case '14':
								$reasonToSave = "14 - Pin / test pin cut";
								break;
							case '15':
								$reasonToSave = "15 - Plating of pin / test pin";
								break;
							case '16':
								$reasonToSave = "16 - Soldering ring not observed (bottom side)";
								break;
							case '17':
								$reasonToSave = "17 - Solder balls seen";
								break;
							case '18':
								$reasonToSave = "18 - Imapct switch soldering improper";
								break;
							case '19':
								$reasonToSave = "19 - Excess solder on impact switch";
								break;
							case '20':
								$reasonToSave = "20 - Damanged / swollen bush of imapct switch";
								break;
							case '21':
								$reasonToSave = "21 - Imapct switch tilted";
								break;
							case '22':
								$reasonToSave = "22 - Excess flux";
								break;
							case '23':
								$reasonToSave = "23 - Components not properly soldered";
								break;
							case '24':
								$reasonToSave = "24 - Soldered components damaged";
								break;
							case '25':
								$reasonToSave = "25 - Wrong components soldered";
								break;
							case '26':
								$reasonToSave = "26 - Shorting of component pins";
								break;
							case '27':
								$reasonToSave = "27 - Component missing";
								break;
							case '28':
								$reasonToSave = "28 - PCB track cut";
								break;
							case '29':
								$reasonToSave = "29 - Solder pad on PCB damaged / removed";
								break;
							case '30':
								$reasonToSave = "30 - Improper barcode printing";
								break;
							case '31':
								$reasonToSave = "31 - Crystal pad damaged";
								break;
							case '100':
								$reasonToSave = "100 - MULTIPLE FAULTS";
								break;
							default:
								$reasonToSave = "Not Applicable";
								break;
						}

				$sql = "UPDATE `qa_table` SET 
				`pcb_no`='".$pcb_no."',
				`result`='".$result."',
				`reason`='".$reason."',
				`record_date`='".$timestamp."',
				`op_name`='".$op_name."' 
				WHERE `pcb_no`='".$pcb_no."'";

				$sqlLotUpdate = "UPDATE `lot_table` SET
				`rejected` = '".(strtoupper($_POST['result']) == "PASS" ? '0' : '1')."',
				`rejection_remark`='".$reasonToSave."' 
				WHERE `pcb_no`='".$pcb_no."'";

				$results = mysqli_query($db,$sql);
				$lotResults = mysqli_query($db,$sqlLotUpdate);
				break;

			case 'afterPuUpdate':
				$sql = "UPDATE `after_pu` SET 
				`pcb_no`='".$_POST['pcb_no']."',
				`i`='".$_POST['current']."',
				`vee`='".$_POST['vee']."',
				`vbat_pst`='".$_POST['vbat_pst']."',
				`pst_amp`='".$_POST['pst_ampl']."',
				`pst_wid`='".$_POST['pst_wid']."',
				`mod_freq`='".$_POST['mod_freq']."',
				`mod_dc`='".$_POST['mod_dc']."',
				`mod_ac`='".$_POST['mod_ac']."',
				`cap_charge`='".$_POST['cap_charge']."',
				`vrf_amp`='".$_POST['vrf_ampl']."',
				`vbat_vrf`='".$_POST['vbat_vrf']."',
				`vbat_sil`='".$_POST['vbat_sil']."',
				`det_wid`='".$_POST['det_wid']."',
				`det_amp`='".$_POST['det_ampl']."',
				`cycles`='".$_POST['cycles']."',
				`bpf_dc`='".$_POST['bpf_dc']."',
				`bpf_ac`='".$_POST['bpf_ac']."',
				`sil`='".$_POST['sil']."',
				`lvp`='".$_POST['lvp']."',
				`pd_delay`='".$_POST['pd_delay']."',
				`pd_det`='".$_POST['pd_det']."',
				`safe`='".$_POST['safe']."',
				`result`='".$_POST['result']."' WHERE `pcb_no`='".$_POST['pcb_no']."'";

				$results = mysqli_query($db,$sql);

				$sqlLotUpdate = "";
				if(strtoupper($_POST['result']) == "PASS") {
					$sqlLotUpdate = "UPDATE `lot_table` SET
					`rejected` = '0' 
					WHERE `pcb_no`='".$_POST['pcb_no']."'";
				}
				else {
					$sqlLotUpdate = "UPDATE `lot_table` SET
					`rejected` = '1' 
					WHERE `pcb_no`='".$_POST['pcb_no']."'";
				}

				$lotResults = mysqli_query($db,$sqlLotUpdate);
				break;

			case 'housingTableUpdate':
				$sql = "UPDATE `housing_table` SET 
				`pcb_no`='".$_POST['pcb_no']."',
				`i`='".$_POST['current']."',
				`vee`='".$_POST['vee']."',
				`vbat_pst`='".$_POST['vbat_pst']."',
				`pst_amp`='".$_POST['pst_ampl']."',
				`pst_wid`='".$_POST['pst_wid']."',
				`mod_freq`='".$_POST['mod_freq']."',
				`mod_dc`='".$_POST['mod_dc']."',
				`mod_ac`='".$_POST['mod_ac']."',
				`cap_charge`='".$_POST['cap_charge']."',
				`vrf_amp`='".$_POST['vrf_ampl']."',
				`vbat_vrf`='".$_POST['vbat_vrf']."',
				`vbat_sil`='".$_POST['vbat_sil']."',
				`det_wid`='".$_POST['det_wid']."',
				`det_amp`='".$_POST['det_ampl']."',
				`cycles`='".$_POST['cycles']."',
				`bpf_dc`='".$_POST['bpf_dc']."',
				`bpf_ac`='".$_POST['bpf_ac']."',
				`sil`='".$_POST['sil']."',
				`lvp`='".$_POST['lvp']."',
				`pd_delay`='".$_POST['pd_delay']."',
				`pd_det`='".$_POST['pd_det']."',
				`safe`='".$_POST['safe']."',
				`result`='".$_POST['result']."' WHERE `pcb_no`='".$_POST['pcb_no']."'";

				$results = mysqli_query($db,$sql);

				$sqlLotUpdate = "";
				if(strtoupper($_POST['result']) == "PASS") {
					$sqlLotUpdate = "UPDATE `lot_table` SET
					`rejected` = '0' 
					WHERE `pcb_no`='".$_POST['pcb_no']."'";
				}
				else {
					$sqlLotUpdate = "UPDATE `lot_table` SET
					`rejected` = '1' 
					WHERE `pcb_no`='".$_POST['pcb_no']."'";
				}

				$lotResults = mysqli_query($db,$sqlLotUpdate);

				break;

			case 'pottingTableUpdate':
				$sql = "UPDATE `potting_table` SET 
				`pcb_no`='".$_POST['pcb_no']."',
				`i`='".$_POST['current']."',
				`vee`='".$_POST['vee']."',
				`vbat_pst`='".$_POST['vbat_pst']."',
				`pst_amp`='".$_POST['pst_ampl']."',
				`pst_wid`='".$_POST['pst_wid']."',
				`mod_freq`='".$_POST['mod_freq']."',
				`mod_dc`='".$_POST['mod_dc']."',
				`mod_ac`='".$_POST['mod_ac']."',
				`cap_charge`='".$_POST['cap_charge']."',
				`vrf_amp`='".$_POST['vrf_ampl']."',
				`vbat_vrf`='".$_POST['vbat_vrf']."',
				`vbat_sil`='".$_POST['vbat_sil']."',
				`det_wid`='".$_POST['det_wid']."',
				`det_amp`='".$_POST['det_ampl']."',
				`cycles`='".$_POST['cycles']."',
				`bpf_dc`='".$_POST['bpf_dc']."',
				`bpf_ac`='".$_POST['bpf_ac']."',
				`sil`='".$_POST['sil']."',
				`lvp`='".$_POST['lvp']."',
				`pd_delay`='".$_POST['pd_delay']."',
				`pd_det`='".$_POST['pd_det']."',
				`safe`='".$_POST['safe']."',
				`result`='".$_POST['result']."' WHERE `pcb_no`='".$_POST['pcb_no']."'";

				$results = mysqli_query($db,$sql);

				$sqlLotUpdate = "";
				if(strtoupper($_POST['result']) == "PASS") {
					$sqlLotUpdate = "UPDATE `lot_table` SET
					`rejected` = '0' 
					WHERE `pcb_no`='".$_POST['pcb_no']."'";
				}
				else {
					$sqlLotUpdate = "UPDATE `lot_table` SET
					`rejected` = '1' 
					WHERE `pcb_no`='".$_POST['pcb_no']."'";
				}

				$lotResults = mysqli_query($db,$sqlLotUpdate);

				break;

			case 'pcbTestingUpdate':
				$sql = "UPDATE `pcb_testing` SET 
				`pcb_no`='".$_POST['pcb_no']."',
				`i`='".$_POST['current']."',
				`vee`='".$_POST['vee']."',
				`vbat_pst`='".$_POST['vbat_pst']."',
				`pst_amp`='".$_POST['pst_ampl']."',
				`pst_wid`='".$_POST['pst_wid']."',
				`mod_freq`='".$_POST['mod_freq']."',
				`mod_dc`='".$_POST['mod_dc']."',
				`mod_ac`='".$_POST['mod_ac']."',
				`cap_charge`='".$_POST['cap_charge']."',
				`vrf_amp`='".$_POST['vrf_ampl']."',
				`vbat_vrf`='".$_POST['vbat_vrf']."',
				`vbat_sil`='".$_POST['vbat_sil']."',
				`det_wid`='".$_POST['det_wid']."',
				`det_amp`='".$_POST['det_ampl']."',
				`cycles`='".$_POST['cycles']."',
				`bpf_dc`='".$_POST['bpf_dc']."',
				`bpf_ac`='".$_POST['bpf_ac']."',
				`sil`='".$_POST['sil']."',
				`lvp`='".$_POST['lvp']."',
				`pd_delay`='".$_POST['pd_delay']."',
				`pd_det`='".$_POST['pd_det']."',
				`safe`='".$_POST['safe']."',
				`result`='".$_POST['result']."' WHERE `pcb_no`='".$_POST['pcb_no']."'";

				$results = mysqli_query($db,$sql);

				$sqlLotUpdate = "";
				if(strtoupper($_POST['result']) == "PASS") {
					$sqlLotUpdate = "UPDATE `lot_table` SET
					`rejected` = '0' 
					WHERE `pcb_no`='".$_POST['pcb_no']."'";
				}
				else {
					$sqlLotUpdate = "UPDATE `lot_table` SET
					`rejected` = '1' 
					WHERE `pcb_no`='".$_POST['pcb_no']."'";
				}

				$lotResults = mysqli_query($db,$sqlLotUpdate);

				break;

			case 'calibrationUpdate':
				$sql = "UPDATE `calibration_table` SET 
				`pcb_no`='".$_POST['pcb_no']."',
				`rf_no`='".$_POST['rf_no']."',
				`before_freq`='".$_POST['before_freq']."',
				`before_bpf`='".$_POST['before_bpf']."',
				`changed`='".$_POST['res_change']."',
				`res_val`='".$_POST['res_val']."',
				`after_freq`='".$_POST['after_freq']."',
				`after_bpf`='".$_POST['after_bpf']."',
				`timestamp`='".$_POST['timestamp']."',
				`op_name`='".$_POST['op_name']."' WHERE `pcb_no`='".$_POST['pcb_no']."'";

				$results = mysqli_query($db,$sql);
				break;
		}
		$toSearch = $_COOKIE['toSearch'];
		$searchIn = $_COOKIE['searchIn'];
		$searchTable = $_COOKIE['searchTable'];
	}
	else {
		$url = parse_url(curPageURL());
		try {
			$splitUrl = explode("&", $url['query']);

			$toSearch = explode("=", $splitUrl[0])[1];
			$searchIn = explode("=", $splitUrl[1])[1];
			$searchTable = explode("=", $splitUrl[2])[1];

			setcookie('toSearch',$toSearch,0,"/");
			setcookie('searchIn',$searchIn,0,"/");
			setcookie('searchTable',$searchTable,0,"/");
		}
		catch(Exception $e)
		{
			$toSearch = $_COOKIE['toSearch'];
			$searchIn = $_COOKIE['searchIn'];
			$searchTable = $_COOKIE['searchTable'];
		}
	}
		
	if(!isset($_COOKIE["fuzeLogin"])){
			die("

				<head>
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

				<title>Fuze-Details</title>
			</head>

			<body class='indexBody'>
				<main class='contents'>

				<div class='navbar-fixed'>
				<nav>
					<div class='nav-wrapper teal lighten-2' id='detailsNav'>
						<a href='#!'' class='brand-logo center'>Fuze Details</a>

						<a><span class='white-text text-darken-5 right' style='font-size: 18px; padding-right: 20px; font-weight: bold' onclick='logout()'>Logout</span></a>

						<a><span class='white-text text-darken-5 left' style='font-size: 18px; padding-left: 20px; font-weight: bold' onclick='self.close();'>Back</span></a>
					</div>
				</nav>
				</div>

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
					<script src='/FuzeDatabase/jquery-ui.js'></script>
					<link rel='stylesheet' href='/FuzeDatabase/jquery-ui.css'>

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
											<div class='input-field col s9 center tooltipped' data-position='bottom' data-delay='250' data-tooltip='Enter rejection code only. No need to type description.'>
												<input type='text' id='qaDetailsReason'>
											</div>
											<div class='col s3'>
											<br>
											<br>
												<!--<a href='/FuzeDatabase/rejection_reasons.txt' target='_blank'>View Rejection codes</a>-->
												<a onclick='modalFunction()'>View Rejection codes</a>
												<div id='dialog'></div>
												<script>
													function modalFunction() {
														$.ajax({
															url: '/FuzeDatabase/rejection_reasons.txt',
															success: function(data) {
																//alert(data);
																$('#dialog').dialog({autoOpen : false, modal : true, show : 'blind', hide : 'blind'});
																$('#dialog').css('white-space','pre-wrap');
																$('#dialog').html(data);
																$('#dialog').dialog('open');
															}
														});
													}
												</script>
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

								<center>
									<a class='btn waves-effect waves-light' id='qaUpdateButton'>UPDATE</a>
								</center>

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
								$row[3] = "29 - Solder pad on PCB damaged / removed";
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

						$html.= "
											$('#qaDetailsPcbNo').val('".$row[1]."');
											$('#qaDetailsResult').val('".($row[2] == '1' ? 'PASS' : 'FAIL')."');
											$('#qaDetailsReason').val('".$row[3]."');
											$('#qaDetailsTimestamp').val('".$row[4]."');
											$('#qaDetailsOperator').val('".$row[5]."');
											$('#qaDetailsPcbNo').prop('readonly','true');
											$('#qaDetailsPcbNo').click(function(){
												alert('PCB number is primary record. You can\'t change it!')
											});
											";

						// ### Control record modification based on login access
						if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
							$html.= "
												$('input[type=text]').prop('readonly','true');
												$('#qaUpdateButton').hide();
												$('#qaDetailsPcbNo').unbind('click');
											";
						}
						else {
							$html.="
										$('#qaUpdateButton').click(function(){
											$.ajax({
												type: 'POST',
												data: {
													form: 'qaUpdate',
													pcb_no: $('#qaDetailsPcbNo').val(),
													result: $('#qaDetailsResult').val(),
													reason: $('#qaDetailsReason').val(),
													timestamp: $('#qaDetailsTimestamp').val(),
													op_name: $('#qaDetailsOperator').val()
												},
												success: function(msg) {
													if(msg.includes('ok')){
														Materialize.toast('Record Updated',1500,'rounded');
													}
													else{
														Materialize.toast('Failed to save record!',3000,'rounded');
														Materialize.toast('Database server is offline!',3000,'rounded');
													}
												},
												error: function(XMLHttpRequest, textStatus, errorThrown) {
													 alert(errorThrown + 'Database server offline?');
												}
											});
										});
							";
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

								<center>
									<a class='btn waves-light waves-effect' id='afterPuUpdateButton'>UPDATE</a>
								</center>

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
											$('#AfterPuDetailsBpfDC').val('".$row[19]." V');
											$('#AfterPuDetailsSil').val('".$row[20]." mS');
											$('#AfterPuDetailsLvp').val('".$row[21]." V');
											$('#AfterPuDetailsPDDelay').val('".$row[22]." uS');
											$('#AfterPuDetailsPDDet').val('".$row[23]." V');
											$('#AfterPuDetailsSafe').val('".$row[24]."');
											$('#AfterPuDetailsResult').val('".$row[25]."');

											$('#AfterPuDetailsPcbNo').prop('readonly','true');
											$('#AfterPuDetailsPcbNo').click(function(){
												alert('PCB number is primary record. You can\'t change it!')
											});
											";

						// ### Control record modification based on login access
						if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
							$html.= "
											$('input[type=text]').prop('readonly','true');
											$('#afterPuUpdateButton').hide();
											$('#AfterPuDetailsPcbNo').unbind('click');
											";
						}
						else {
							$html.="
										$('#afterPuUpdateButton').click(function(){
											$.ajax({
												type: 'POST',
												data: {
													form: 'afterPuUpdate',
													pcb_no: $('#AfterPuDetailsPcbNo').val(),
													current: $('#AfterPuDetailsCurrent').val().replace(/[^\d.-]/g, ''),
													vee: $('#AfterPuDetailsVee').val().replace(/[^\d.-]/g, ''),
													vbat_pst: $('#AfterPuDetailsVbatPst').val().replace(/[^\d.-]/g, ''),
													pst_ampl: $('#AfterPuDetailsPstAmpl').val().replace(/[^\d.-]/g, ''),
													pst_wid: $('#AfterPuDetailsPstWid').val().replace(/[^\d.-]/g, ''),
													mod_freq: $('#AfterPuDetailsFreq').val().replace(/[^\d.-]/g, ''),
													mod_dc: $('#AfterPuDetailsModDC').val().replace(/[^\d.-]/g, ''),
													mod_ac: $('#AfterPuDetailsModAC').val().replace(/[^\d.-]/g, ''),
													vrf_ampl: $('#AfterPuDetailsVrfAmpl').val().replace(/[^\d.-]/g, ''),
													vbat_vrf: $('#AfterPuDetailsVbatVrf').val().replace(/[^\d.-]/g, ''),
													cap_charge: $('#AfterPuDetailsCapCharge').val().replace(/[^\d.-]/g, ''),
													det_wid: $('#AfterPuDetailsDetWidth').val().replace(/[^\d.-]/g, ''),
													det_ampl: $('#AfterPuDetailsDetAmpl').val().replace(/[^\d.-]/g, ''),
													cycles: $('#AfterPuDetailsCycles').val().replace(/[^\d.-]/g, ''),
													bpf_dc: $('#AfterPuDetailsBpfDC').val().replace(/[^\d.-]/g, ''),
													bpf_ac: $('#AfterPuDetailsBpfAC').val().replace(/[^\d.-]/g, ''),
													sil: $('#AfterPuDetailsSil').val().replace(/[^\d.-]/g, ''),
													vbat_sil: $('#AfterPuDetailsVbatSil').val().replace(/[^\d.-]/g, ''),
													lvp: $('#AfterPuDetailsLvp').val().replace(/[^\d.-]/g, ''),
													pd_delay: $('#AfterPuDetailsPDDelay').val().replace(/[^\d.-]/g, ''),
													pd_det: $('#AfterPuDetailsPDDet').val().replace(/[^\d.-]/g, ''),
													safe: $('#AfterPuDetailsSafe').val().toUpperCase(),
													result: $('#AfterPuDetailsResult').val().toUpperCase()
												},
												success: function(msg) {
													console.log(msg);
													if(msg.includes('ok')){
														Materialize.toast('Record Updated',1500,'rounded');
													}
													else{
														Materialize.toast('Failed to save record!',3000,'rounded');
														Materialize.toast('Database server is offline!',3000,'rounded');
													}
												},
												error: function(XMLHttpRequest, textStatus, errorThrown) {
													 alert(errorThrown + 'Database server offline?');
												}
											});
										});
							";
						}
					}
					catch(Exception $e){
							$html.="
								$('#afterPuDetailsForm').hide();
								document.getElementById('afterPuDetailsTitle').innerHTML = 'Failed to search the given parameter!';
							";
							print_r($e);
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

								<center>
									<a class='btn waves-light waves-effect' id='pcbTestingUpdateButton'>UPDATE</a>
								</center>

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

											$('#PcbTestingDetailsPcbNo').prop('readonly','true');
											$('#PcbTestingDetailsPcbNo').click(function(){
												alert('PCB number is primary record. You can\'t change it!')
											});
											";

						// ### Control record modification based on login access
						if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
							$html.= "
											$('input[type=text]').prop('readonly','true');
											$('#pcbTestingUpdateButton').hide();
											$('#PcbTestingDetailsPcbNo').unbind('click');
											";
						}
						else {
							$html.="
										$('#pcbTestingUpdateButton').click(function(){
											$.ajax({
												type: 'POST',
												data: {
													form: 'pcbTestingUpdate',
													pcb_no: $('#PcbTestingDetailsPcbNo').val(),
													current: $('#PcbTestingDetailsCurrent').val().replace(/[^\d.-]/g, ''),
													vee: $('#PcbTestingDetailsVee').val().replace(/[^\d.-]/g, ''),
													vbat_pst: $('#PcbTestingDetailsVbatPst').val().replace(/[^\d.-]/g, ''),
													pst_ampl: $('#PcbTestingDetailsPstAmpl').val().replace(/[^\d.-]/g, ''),
													pst_wid: $('#PcbTestingDetailsPstWid').val().replace(/[^\d.-]/g, ''),
													mod_freq: $('#PcbTestingDetailsFreq').val().replace(/[^\d.-]/g, ''),
													mod_dc: $('#PcbTestingDetailsModDC').val().replace(/[^\d.-]/g, ''),
													mod_ac: $('#PcbTestingDetailsModAC').val().replace(/[^\d.-]/g, ''),
													vrf_ampl: $('#PcbTestingDetailsVrfAmpl').val().replace(/[^\d.-]/g, ''),
													vbat_vrf: $('#PcbTestingDetailsVbatVrf').val().replace(/[^\d.-]/g, ''),
													cap_charge: $('#PcbTestingDetailsCapCharge').val().replace(/[^\d.-]/g, ''),
													det_wid: $('#PcbTestingDetailsDetWidth').val().replace(/[^\d.-]/g, ''),
													det_ampl: $('#PcbTestingDetailsDetAmpl').val().replace(/[^\d.-]/g, ''),
													cycles: $('#PcbTestingDetailsCycles').val().replace(/[^\d.-]/g, ''),
													bpf_dc: $('#PcbTestingDetailsBpfDC').val().replace(/[^\d.-]/g, ''),
													bpf_ac: $('#PcbTestingDetailsBpfAC').val().replace(/[^\d.-]/g, ''),
													sil: $('#PcbTestingDetailsSil').val().replace(/[^\d.-]/g, ''),
													vbat_sil: $('#PcbTestingDetailsVbatSil').val().replace(/[^\d.-]/g, ''),
													lvp: $('#PcbTestingDetailsLvp').val().replace(/[^\d.-]/g, ''),
													pd_delay: $('#PcbTestingDetailsPDDelay').val().replace(/[^\d.-]/g, ''),
													pd_det: $('#PcbTestingDetailsPDDet').val().replace(/[^\d.-]/g, ''),
													safe: $('#PcbTestingDetailsSafe').val().toUpperCase(),
													result: $('#PcbTestingDetailsResult').val().toUpperCase()
												},
												success: function(msg) {
													console.log(msg);
													if(msg.includes('ok')){
														Materialize.toast('Record Updated',1500,'rounded');
													}
													else{
														Materialize.toast('Failed to save record!',3000,'rounded');
														Materialize.toast('Database server is offline!',3000,'rounded');
													}
												},
												error: function(XMLHttpRequest, textStatus, errorThrown) {
													 alert(errorThrown + 'Database server offline?');
												}
											});
										});
							";
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

		case 'housing_table':
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
					<div class='card-panel grey lighten-4' id='housingTableDetailsCard'>
						<div class='row'>
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='housingTableDetailsTitle'>Housing Test Report</span>
							</center>

							<form id='housingTableDetailsForm'>
							<br>
								<table id='housingTableDetailsTable'>
									<tbody>

										<tr>
										<td class='center'><span class='center'>PCB Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Current (I) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsCurrent' data-position='bottom' data-delay='500' data-tooltip='7 to 14 mA' class='tooltipped'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Voltage (VEE) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsVee' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.30 to 6.20 V'>
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
													<input type='text' id='HousingTableDetailsVbatPst' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='600 to 700 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsPstAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='12 to 21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Width <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsPstWid' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
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
													<input type='text' id='HousingTableDetailsFreq' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='46 to 55 KHz'>
												</div>
											</td>
											<td class='center'><span class='center'>DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsModDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='7 to 8.1 V'>
												</div>
											</td>
											<td class='center'><span class='center'>AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsModAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0.95 to 1.35 V'>
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
													<input type='text' id='HousingTableDetailsVrfAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='15.3 to 16.7 V'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-VRF Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsVbatVrf' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.08 to 2.30 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-Cap Charge T <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsCapCharge' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='695 to 730 mS'>
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
													<input type='text' id='HousingTableDetailsDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>Cycles <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsCycles' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4 to 6'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsBpfDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.2 to 6.4 V'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsBpfAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.5 to 3.6 V'>
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
													<input type='text' id='HousingTableDetailsSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='480 to 650 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-SIL Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsVbatSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.7 to 3.2 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>LVP <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsLvp' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='18.8 to 21 V'>
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
													<input type='text' id='HousingTableDetailsPDDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0 to 10 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsPDDet' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -22 V'>
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
													<input type='text' id='HousingTableDetailsSafe'>
												</div>
											</td>
											<td class='center'><span class='center'>Result <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='HousingTableDetailsResult'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center>
									<a class='btn waves-light waves-effect' id='housingTableUpdateButton'>UPDATE</a>
								</center>

							</form>

						</div>
					</div>

					";
					$html.= "<script type='text/javascript'>";
					try {
						$html.= "	$('#HousingTableDetailsPcbNo').val('".$row[1]."');
											$('#HousingTableDetailsCurrent').val('".$row[2]." mA');
											$('#HousingTableDetailsVee').val('".$row[3]." V');
											$('#HousingTableDetailsVbatPst').val('".$row[4]." mS');
											$('#HousingTableDetailsPstAmpl').val('".$row[5]." V');
											$('#HousingTableDetailsPstWid').val('".$row[6]." uS');
											$('#HousingTableDetailsFreq').val('".$row[7]." KHz');
											$('#HousingTableDetailsModDC').val('".$row[8]." V');
											$('#HousingTableDetailsModAC').val('".$row[9]." V');
											$('#HousingTableDetailsCapCharge').val('".$row[10]." mS');
											$('#HousingTableDetailsVrfAmpl').val('".$row[11]." V');
											$('#HousingTableDetailsVbatVrf').val('".$row[12]." Sec');
											$('#HousingTableDetailsVbatSil').val('".$row[13]." Sec');
											$('#HousingTableDetailsDetWidth').val('".$row[14]." uS');
											$('#HousingTableDetailsDetAmpl').val('".$row[15]." V');
											$('#HousingTableDetailsCycles').val('".$row[16]."');
											$('#HousingTableDetailsBpfAC').val('".$row[17]." V');
											$('#HousingTableDetailsBpfDC').val('".$row[18]." V');
											$('#HousingTableDetailsSil').val('".$row[19]." mS');
											$('#HousingTableDetailsLvp').val('".$row[20]." V');
											$('#HousingTableDetailsPDDelay').val('".$row[21]." uS');
											$('#HousingTableDetailsPDDet').val('".$row[22]." V');
											$('#HousingTableDetailsSafe').val('".$row[23]."');
											$('#HousingTableDetailsResult').val('".$row[24]."');

											$('#HousingTableDetailsPcbNo').prop('readonly','true');
											$('#HousingTableDetailsPcbNo').click(function(){
												alert('PCB number is primary record. You can\'t change it!')
											});
											";

						// ### Control record modification based on login access
						if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
							$html.= "
											$('input[type=text]').prop('readonly','true');
											$('#housingTableUpdateButton').hide();
											$('#HousingTableDetailsPcbNo').unbind('click');
											";
						}
						else {
							$html.="
										$('#housingTableUpdateButton').click(function(){
											$.ajax({
												type: 'POST',
												data: {
													form: 'housingTableUpdate',
													pcb_no: $('#HousingTableDetailsPcbNo').val(),
													current: $('#HousingTableDetailsCurrent').val().replace(/[^\d.-]/g, ''),
													vee: $('#HousingTableDetailsVee').val().replace(/[^\d.-]/g, ''),
													vbat_pst: $('#HousingTableDetailsVbatPst').val().replace(/[^\d.-]/g, ''),
													pst_ampl: $('#HousingTableDetailsPstAmpl').val().replace(/[^\d.-]/g, ''),
													pst_wid: $('#HousingTableDetailsPstWid').val().replace(/[^\d.-]/g, ''),
													mod_freq: $('#HousingTableDetailsFreq').val().replace(/[^\d.-]/g, ''),
													mod_dc: $('#HousingTableDetailsModDC').val().replace(/[^\d.-]/g, ''),
													mod_ac: $('#HousingTableDetailsModAC').val().replace(/[^\d.-]/g, ''),
													vrf_ampl: $('#HousingTableDetailsVrfAmpl').val().replace(/[^\d.-]/g, ''),
													vbat_vrf: $('#HousingTableDetailsVbatVrf').val().replace(/[^\d.-]/g, ''),
													cap_charge: $('#HousingTableDetailsCapCharge').val().replace(/[^\d.-]/g, ''),
													det_wid: $('#HousingTableDetailsDetWidth').val().replace(/[^\d.-]/g, ''),
													det_ampl: $('#HousingTableDetailsDetAmpl').val().replace(/[^\d.-]/g, ''),
													cycles: $('#HousingTableDetailsCycles').val().replace(/[^\d.-]/g, ''),
													bpf_dc: $('#HousingTableDetailsBpfDC').val().replace(/[^\d.-]/g, ''),
													bpf_ac: $('#HousingTableDetailsBpfAC').val().replace(/[^\d.-]/g, ''),
													sil: $('#HousingTableDetailsSil').val().replace(/[^\d.-]/g, ''),
													vbat_sil: $('#HousingTableDetailsVbatSil').val().replace(/[^\d.-]/g, ''),
													lvp: $('#HousingTableDetailsLvp').val().replace(/[^\d.-]/g, ''),
													pd_delay: $('#HousingTableDetailsPDDelay').val().replace(/[^\d.-]/g, ''),
													pd_det: $('#HousingTableDetailsPDDet').val().replace(/[^\d.-]/g, ''),
													safe: $('#HousingTableDetailsSafe').val().toUpperCase(),
													result: $('#HousingTableDetailsResult').val().toUpperCase()
												},
												success: function(msg) {
													console.log(msg);
													if(msg.includes('ok')){
														Materialize.toast('Record Updated',1500,'rounded');
													}
													else{
														Materialize.toast('Failed to save record!',3000,'rounded');
														Materialize.toast('Database server is offline!',3000,'rounded');
													}
												},
												error: function(XMLHttpRequest, textStatus, errorThrown) {
													 alert(errorThrown + 'Database server offline?');
												}
											});
										});
							";
						}
					}
					catch(Exception $e){
							$html.="
								$('#housingTableDetailsForm').hide();
								document.getElementById('housingTableDetailsTitle').innerHTML = 'Failed to search the given parameter!';
							";
							print_r($e);
					}
					$html.= "</script>";
				}
				break;

			case 'potting_table':
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
					<div class='card-panel grey lighten-4' id='pottingTableDetailsCard'>
						<div class='row'>
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='pottingTableDetailsTitle'>Potting Test Report</span>
							</center>

							<form id='pottingTableDetailsForm'>
							<br>
								<table id='pottingTableDetailsTable'>
									<tbody>

										<tr>
										<td class='center'><span class='center'>PCB Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Current (I) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsCurrent' data-position='bottom' data-delay='500' data-tooltip='7 to 14 mA' class='tooltipped'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Voltage (VEE) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsVee' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.30 to 6.20 V'>
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
													<input type='text' id='PottingTableDetailsVbatPst' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='600 to 700 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsPstAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='12 to 21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Width <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsPstWid' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
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
													<input type='text' id='PottingTableDetailsFreq' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='46 to 55 KHz'>
												</div>
											</td>
											<td class='center'><span class='center'>DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsModDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='7 to 8.1 V'>
												</div>
											</td>
											<td class='center'><span class='center'>AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsModAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0.95 to 1.35 V'>
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
													<input type='text' id='PottingTableDetailsVrfAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='15.3 to 16.7 V'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-VRF Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsVbatVrf' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.08 to 2.30 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-Cap Charge T <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsCapCharge' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='695 to 730 mS'>
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
													<input type='text' id='PottingTableDetailsDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>Cycles <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsCycles' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4 to 6'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsBpfDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.2 to 6.4 V'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsBpfAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.5 to 3.6 V'>
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
													<input type='text' id='PottingTableDetailsSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='480 to 650 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-SIL Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsVbatSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.7 to 3.2 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>LVP <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsLvp' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='18.8 to 21 V'>
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
													<input type='text' id='PottingTableDetailsPDDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0 to 10 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsPDDet' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -22 V'>
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
													<input type='text' id='PottingTableDetailsSafe'>
												</div>
											</td>
											<td class='center'><span class='center'>Result <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PottingTableDetailsResult'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center>
									<a class='btn waves-light waves-effect' id='pottingTableUpdateButton'>UPDATE</a>
								</center>

							</form>

						</div>
					</div>

					";
					$html.= "<script type='text/javascript'>";
					try {
						$html.= "	$('#PottingTableDetailsPcbNo').val('".$row[1]."');
											$('#PottingTableDetailsCurrent').val('".$row[2]." mA');
											$('#PottingTableDetailsVee').val('".$row[3]." V');
											$('#PottingTableDetailsVbatPst').val('".$row[4]." mS');
											$('#PottingTableDetailsPstAmpl').val('".$row[5]." V');
											$('#PottingTableDetailsPstWid').val('".$row[6]." uS');
											$('#PottingTableDetailsFreq').val('".$row[7]." KHz');
											$('#PottingTableDetailsModDC').val('".$row[8]." V');
											$('#PottingTableDetailsModAC').val('".$row[9]." V');
											$('#PottingTableDetailsCapCharge').val('".$row[10]." mS');
											$('#PottingTableDetailsVrfAmpl').val('".$row[11]." V');
											$('#PottingTableDetailsVbatVrf').val('".$row[12]." Sec');
											$('#PottingTableDetailsVbatSil').val('".$row[13]." Sec');
											$('#PottingTableDetailsDetWidth').val('".$row[14]." uS');
											$('#PottingTableDetailsDetAmpl').val('".$row[15]." V');
											$('#PottingTableDetailsCycles').val('".$row[16]."');
											$('#PottingTableDetailsBpfAC').val('".$row[17]." V');
											$('#PottingTableDetailsBpfDC').val('".$row[18]." V');
											$('#PottingTableDetailsSil').val('".$row[19]." mS');
											$('#PottingTableDetailsLvp').val('".$row[20]." V');
											$('#PottingTableDetailsPDDelay').val('".$row[21]." uS');
											$('#PottingTableDetailsPDDet').val('".$row[22]." V');
											$('#PottingTableDetailsSafe').val('".$row[23]."');
											$('#PottingTableDetailsResult').val('".$row[24]."');

											$('#PottingTableDetailsPcbNo').prop('readonly','true');
											$('#PottingTableDetailsPcbNo').click(function(){
												alert('PCB number is primary record. You can\'t change it!')
											});
											";

						// ### Control record modification based on login access
						if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
							$html.= "
											$('input[type=text]').prop('readonly','true');
											$('#pottingTableUpdateButton').hide();
											$('#PottingTableDetailsPcbNo').unbind('click');
											";
						}
						else {
							$html.="
										$('#pottingTableUpdateButton').click(function(){
											$.ajax({
												type: 'POST',
												data: {
													form: 'pottingTableUpdate',
													pcb_no: $('#PottingTableDetailsPcbNo').val(),
													current: $('#PottingTableDetailsCurrent').val().replace(/[^\d.-]/g, ''),
													vee: $('#PottingTableDetailsVee').val().replace(/[^\d.-]/g, ''),
													vbat_pst: $('#PottingTableDetailsVbatPst').val().replace(/[^\d.-]/g, ''),
													pst_ampl: $('#PottingTableDetailsPstAmpl').val().replace(/[^\d.-]/g, ''),
													pst_wid: $('#PottingTableDetailsPstWid').val().replace(/[^\d.-]/g, ''),
													mod_freq: $('#PottingTableDetailsFreq').val().replace(/[^\d.-]/g, ''),
													mod_dc: $('#PottingTableDetailsModDC').val().replace(/[^\d.-]/g, ''),
													mod_ac: $('#PottingTableDetailsModAC').val().replace(/[^\d.-]/g, ''),
													vrf_ampl: $('#PottingTableDetailsVrfAmpl').val().replace(/[^\d.-]/g, ''),
													vbat_vrf: $('#PottingTableDetailsVbatVrf').val().replace(/[^\d.-]/g, ''),
													cap_charge: $('#PottingTableDetailsCapCharge').val().replace(/[^\d.-]/g, ''),
													det_wid: $('#PottingTableDetailsDetWidth').val().replace(/[^\d.-]/g, ''),
													det_ampl: $('#PottingTableDetailsDetAmpl').val().replace(/[^\d.-]/g, ''),
													cycles: $('#PottingTableDetailsCycles').val().replace(/[^\d.-]/g, ''),
													bpf_dc: $('#PottingTableDetailsBpfDC').val().replace(/[^\d.-]/g, ''),
													bpf_ac: $('#PottingTableDetailsBpfAC').val().replace(/[^\d.-]/g, ''),
													sil: $('#PottingTableDetailsSil').val().replace(/[^\d.-]/g, ''),
													vbat_sil: $('#PottingTableDetailsVbatSil').val().replace(/[^\d.-]/g, ''),
													lvp: $('#PottingTableDetailsLvp').val().replace(/[^\d.-]/g, ''),
													pd_delay: $('#PottingTableDetailsPDDelay').val().replace(/[^\d.-]/g, ''),
													pd_det: $('#PottingTableDetailsPDDet').val().replace(/[^\d.-]/g, ''),
													safe: $('#PottingTableDetailsSafe').val().toUpperCase(),
													result: $('#PottingTableDetailsResult').val().toUpperCase()
												},
												success: function(msg) {
													console.log(msg);
													if(msg.includes('ok')){
														Materialize.toast('Record Updated',1500,'rounded');
													}
													else{
														Materialize.toast('Failed to save record!',3000,'rounded');
														Materialize.toast('Database server is offline!',3000,'rounded');
													}
												},
												error: function(XMLHttpRequest, textStatus, errorThrown) {
													 alert(errorThrown + 'Database server offline?');
												}
											});
										});
							";
						}
					}
					catch(Exception $e){
							$html.="
								$('#pottingTableDetailsForm').hide();
								document.getElementById('pottingTableDetailsTitle').innerHTML = 'Failed to search the given parameter!';
							";
							print_r($e);
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
							$row[5] = "YES";
							break;
						
						default:
							$row[5] = "NO";
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

								<center>
									<a class='btn waves-light waves-effect' id='calibrationUpdateButton'>UPDATE</a>
								</center>

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

										$('#calibrationDetailsPcbNo').prop('readonly','true');
										$('#calibrationDetailsPcbNo').click(function(){
											alert('PCB number is primary record. You can\'t change it!')
										});
										";

					// ### Control record modification based on login access
					if(isset($_COOKIE["fuzeAccess"]) && (strcmp($_COOKIE["fuzeAccess"], "write") == 0)){
						$html.= "
										$('input[type=text]').prop('readonly','true');
										$('#calibrationUpdateButton').hide();
										$('#calibrationDetailsPcbNo').unbind('click');
										";
					}
					else {
							$html.="
										$('#calibrationUpdateButton').click(function(){
											$.ajax({
												type: 'POST',
												data: {
													form: 'calibrationUpdate',
													pcb_no: $('#calibrationDetailsPcbNo').val(),
													rf_no: $('#calibrationDetailsRfNo').val(),
													before_bpf: $('#calibrationDetailsBpfbefore').val().replace(/[^\d.-]/g, ''),
													after_bpf: $('#calibrationDetailsBpfAfter').val().replace(/[^\d.-]/g, ''),
													before_freq: $('#calibrationDetailsFreqBefore').val().replace(/[^\d.-]/g, ''),
													after_freq: $('#calibrationDetailsFreqAfter').val().replace(/[^\d.-]/g, ''),
													res_change: ($('#calibrationDetailsResChange').val().toUpperCase() == 'YES' ? '1' : '0'),
													res_val: $('#calibrationDetailsResValue').val().replace(/[^\d.-]/g, ''),
													timestamp: $('#calibrationDetailsDate').val(),
													op_name: $('#calibrationDetailsOperator').val().toUpperCase()
												},
												success: function(msg) {
													console.log(msg);
													if(msg.includes('ok')){
														Materialize.toast('Record Updated',1500,'rounded');
													}
													else{
														Materialize.toast('Failed to save record!',3000,'rounded');
														Materialize.toast('Database server is offline!',3000,'rounded');
													}
												},
												error: function(XMLHttpRequest, textStatus, errorThrown) {
													 alert(errorThrown + 'Database server offline?');
												}
											});
										});
							";
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
						location.href = '/FuzeDatabase/index.php';
					}
					";
				$html.= "</script>
								</html>";

		echo $html;

		mysqli_close($db);
?>
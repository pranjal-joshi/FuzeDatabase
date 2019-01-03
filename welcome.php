<!DOCTYPE html>

<html>

	<style type="text/css">
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
		<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>
		<link rel="stylesheet" type="text/css" href="materialize.min.css">
		<link rel='stylesheet' href='/FuzeDatabase/jquery-ui.css'>

		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="materialize.min.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>
		<script src='/FuzeDatabase/jquery-ui.js'></script>

		<!-- Set responsive viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- Disable caching of browser -->
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />

		<title>Fuze-Home</title>
	</head>

	<?php
		if(!isset($_COOKIE["fuzeLogin"])){
			die("

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
						<a href='#!'' class='brand-logo center'>What are you doing? (-_-)</a>
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
										<h5 style='color: red'>Unauthorized access detected!!</h5>
										<br>
										<h5 style='color: red'>This incident will be reported.</h5>
										<br>
										<br>
										<a href='index.php'>Go Back to login page</a>
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
							<center>&copy; Bharat Electronics Ltd. (".strval(date('Y'))."), All rights reserved.</center>
						</div>
					</div>
				</footer>
				</body>
				");
		}
		else {
			include('db_config.php');
			$dateSql = "SELECT CURRENT_DATE";
			$dateRes = mysqli_query($db, $dateSql);
			$date = mysqli_fetch_assoc($dateRes);
			setcookie("currentDate",$date['CURRENT_DATE'],0,"/");
		}
	?>

	<body class="indexBody">

		<main class="contents">
			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper teal lighten-2" id="loginNav">
						<a href="#!" class="brand-logo center" id="loginNavTitle">Fuze Database</a>

						<a class='dropdown-button' href='#' data-activates='dropdownMenu' data-constrainWidth="false" id="menuDropdown">
							<span class='white-text text-darken-5' style="font-size: 20px; padding-left: 20px; font-weight: bold">&#9776; Menu</span>
						</a>

						<a class='dropdown-button right' href='#' data-activates='dropdownMenu' onclick="logout();">
							<span class='white-text text-darken-5' style="font-size: 16px; padding-right: 20px; font-weight: bold">Logout &#128711;</span>
						</a>

						<ul id='dropdownMenu' class='dropdown-content' data-constrainWidth="false">
							<li><a class="waves-effect waves-light modal-trigger" href="#searchModal"><img src="search.svg" width="20px" height="20px" style="margin-right: 3px; padding-top: 4px;"></img>Search</a></li>
							<li class="divider"></li>
							<li><a href="rejection.php" target="_blank"><img src="error.svg" width="20px" height="20px" style="margin-right: 3px; padding-top: 4px;"></img>Rejection</a></li>
							<li class="divider"></li>
							<?php
								//if($_COOKIE["fuzeAccess"] == "edit"){
								if($_COOKIE["fuzeAccess"] == "DE95B43BCEEB4B998AED4AED5CEF1AE7"){
									echo "<li><a href='solution.php' target='_blank'><img src='check.svg' width='20px' height='20px' style='margin-right: 3px; padding-top: 4px;''></img>Solutions</a></li>";
								}
								else {
									echo "<li><a class='grey-text' id='solutionLink'><img src='check.svg' width='20px' height='20px' style='margin-right: 3px; padding-top: 4px;''></img>Solutions</a></li>";
									echo "<script>
													$('#solutionLink').click(function(){
														alert('Sorry! You dont have access to this feature.');
													});
												</script>";
								}
							?>
							<li class="divider"></li>
							<?php
								//if($_COOKIE["fuzeAccess"] == "edit"){
								if($_COOKIE["fuzeAccess"] == "DE95B43BCEEB4B998AED4AED5CEF1AE7"){
									echo "<li><a href='analytics.php' target='_blank'><img src='chart.svg' width='20px' height='20px' style='margin-right: 3px; padding-top: 4px;''></img>Analytics</a></li>";
								}
								else {
									echo "<li><a class='grey-text' id='analyticsLink'><img src='chart.svg' width='20px' height='20px' style='margin-right: 3px; padding-top: 4px;''></img>Analytics</a></li>";
									echo "<script>
													$('#analyticsLink').click(function(){
														alert('Sorry! You dont have access to this feature.');
													});
												</script>";
								}
							?>
							<li class="divider"></li>
							<li><a href="forum.php" target="_blank"><img src="forum.svg" width="20px" height="20px" style="margin-right: 3px; padding-top: 4px;"></img>Forum</a></li>
						</ul>
	
					</div>

				</nav>
			</div>

			<!-- search modal -->
			<div id="searchModal" class="modal">
				<div class="modal-content">
					<center>
						<span class="teal-text text-darken-2" style="font-weight: bold; font-size: 24px;">Search the record</span>
						<div class="row">

							<div class="row">
								<br>
								<div class="col s12">
									<input type="radio" name="searchGroup" class="with-gap" id="radioEPD" name="radioEPD" value="1" onchange="onSearchRadioChange()">
									<label for="radioEPD">EPD</label>
									<input type="radio" name="searchGroup" class="with-gap" id="radioTIME" name="radioTIME" value="2" onchange="onSearchRadioChange()">
									<label for="radioTIME">TIME</label>
									<input type="radio" name="searchGroup" class="with-gap" id="radioPROX" name="radioPROX" value="3" onchange="onSearchRadioChange()" checked>
									<label for="radioPROX">PROX</label>
								</div>
							</div>
							
							<div class="row" id="searchSelect" style="min-height: 300px;">
								<div class="input-field col s3">
									<select name="searchSelect" id="searchSelect">
										<option value="1" selected>PCB Number</option>
										<option value="11">Lot Number</option>
										<option value="2">RF Number</option>
										<option value="3">Resistor Value</option>
										<option value="4">Before Freq</option>
										<option value="5">Before BPF AC</option>
										<option value="6">After Freq</option>
										<option value="7">After BPF AC</option>
										<option value="8">Date</option>
										<option value="9">Operator Name</option>
										<option value="10">Result(Pass/Fail)</option>
									</select>
									<label>Search by</label>
								</div>

								<div class="row" id="searchTableSelect">
									<div class="input-field col s2">
										<select name="searchTableSelect" id="searchTableSelect">
											<option value="1">After PU</option>
											<option value="2">Calibration</option>
											<option value="3">Visual</option>
											<option value="4" selected>PCB Testing</option>
											<option value="5">Housing Testing</option>
											<option value="6">Potted Housing</option>
											<option value="7">Electronic Head</option>
										</select>
										<label>Search In</label>
									</div>

								<div class="input-field col s4" id="search_box_div">
									<input type="text" name="search_box" id="search_box" autofocus class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='For partial search, use wildcard (%__%) like %234%'>
									<label for="search_box">What to search?</label>
								</div>

								<div id="quickSearchDiv">
							  	<input type="checkbox" class="filled-in" id="QuickSearchSwitch" checked="checked">
							  	<label for="QuickSearchSwitch">Quick Search</label>
							  </div>

								<br>
								<a class="btn col s2" href="#" id="searchButton" name="searchButton">SEARCH</a>

								<div class="row" id="searchModalDatePickerRow" style="display: none;">
									<div class='input-field col s6' id="searchModalDatePicker1">
										<input type='text' id='searchModalRecordDate1' class="datepicker">
										<label for="searchModalRecordDate1">* From</label>
									</div>

									<div class='input-field col s6' id="searchModalDatePicker2">
										<input type='text' id='searchModalRecordDate2' class="datepicker">
										<label for="searchModalRecordDate2">To</label>
									</div>
								</div>

							</div>

							<div id="searchPreloader" style="display: none;">
								<div class="col s4"></div>
								<div class="progress col s4">
										<div class="indeterminate"></div>
								</div>
							</div>

							<div class="row" id="searchDynamicTable">
							</div>

							<script type="text/javascript">$('select').material_select();</script>

						</div>
					</center>
				</div>
				<div class="modal-footer">
					<center>
						<a href="#" class="btn-flat waves-light waves-red waves-effect" onclick="$('#searchModal').closeModal();">Cancel</a>
					</center>
				</div>
			</div>

			<!-- report modal -->
			<div id="reportModal" class="modal">
				<div class="modal-content" style="min-height: 350px;">
					<center>
						<span class="teal-text text-darken-2" style="font-weight: bold; font-size: 24px;">Generate Report</span>
						<br><br>
						<div class="row">

							<div class="input-field col s4">
								<select name="searchSelect" id="reportSelect">
									<optgroup label="Testing">
										<option value="testing_record">Testing Record</option>
										<option value="testing_daily_count" selected>Testing Daily Count</option>
									</optgroup>
									<optgroup label="Assembly">
										<option value="barcode_record">Barcode Record</option>
										<option value="battery_record">Battery Record</option>
									</optgroup>
								</select>
								<label>Report type</label>
							</div>

							<div class="input-field col s3">
								<select name="searchSelect" id="reportFuzeSelect">
									<option value="" selected disabled>-- Select --</option>
									<option value="EPD">EPD</option>
									<option value="TIME">TIME</option>
									<option value="PROX">PROX</option>
								</select>
								<label>Fuze type</label>
							</div>

							<div class="input-field col s3">
								<select name="searchSelect" id="reportDiaSelect">
									<option value="" selected disabled>-- Select --</option>
									<option value="105">105</option>
									<option value="155">155</option>
								</select>
								<label>Fuze type</label>
							</div>

							<div class="input-field col s2">
								<input type="text" id="reportLotNo">
								<label for="reportLotNo">Lot No.</label>
							</div>
						</div>
						<br>
						<a class="btn col s2" href="#" id="reportButton" name="reportButton">Get report</a>
						<script type="text/javascript">$('select').material_select();</script>
					</center>
				</div>
							
				<div class="modal-footer">
					<center>
						<a href="#" class="btn-flat waves-light waves-red waves-effect" onclick="$('#reportModal').closeModal();">Cancel</a>
					</center>
				</div>
			</div>

			<div class="row">
				<div class="col m1"></div>
				<div class="col m10 s12">

					<br>
					<div class="card-panel grey lighten-4" id="calibrationCard" style="display: none;">
						<div class="row">

							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Enter Calibration Details</span>
							</center>

							<form class="col s12" method="post" id="calibrationForm">
								<div class="row">
									<div class="input-field col s6">
										<input id="pcb_no" name="pcb_no" type="text" required autofocus>
										<label for="pcb_no"><center>PCB Number</center></label>
									</div>
									<div class="input-field col s6">
										<input id="rf_no" name="rf_no" type="text" required>
										<label for="rf_no"><center>RF Number</center></label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s6">
										<input id="before_freq" name="before_freq" type="text" disabled>
										<label for="before_freq"><center>Before Calibration - Freq (MHz)</center></label>
									</div>
									<div class="input-field col s6">
										<input id="before_bpf" name="before_bpf" type="text">
										<label for="before_bpf"><center>Before Calibration - BPF AC (V)</center></label>
									</div>
								</div>

								<div class="row">
									<center>
									<div id="dialog"></div>
									<div class="col s3">
										<span class="black-text">Calibration resistor changed?</span>
									</div>
									<div class="col s3">
										<a onclick="showCalibrationTable()">Resistor value guide</a>
										<script type="text/javascript">
											function showCalibrationTable() {
												$.ajax({
															url: '/FuzeDatabase/calibration_res.txt',
															success: function(data) {
																$('#dialog').dialog({
																	autoOpen : false,
																	modal : true,
																	show : 'blind',
																	hide : 'blind',
																	width: '40%',
																	title: 'Resistor Value Guide'
																});
																$('#dialog').css('white-space','pre-wrap');
																$('#dialog').html(data);
																$('#dialog').dialog('open');
																$('.ui-widget-overlay').bind('click', function(){
																	$('#dialog').unbind();
																	$('#dialog').dialog('close');
																});
															}
														});
											}
										</script>
									</div>
									<div class="col s6">
										<input type="radio" name="group1" class="with-gap" id="radioYes" name="radioYes" value="1" onchange="onRadioChange()">
										<label for="radioYes">Yes</label>
										<input type="radio" name="group1" class="with-gap" id="radioNo" name="radioNo" value="0" onchange="onRadioChange()" checked>
										<label for="radioNo">No</label>
									</div>
									</center>
								</div>

								<div class="row">
									<div class="input-field col s2">
										<input type="text" name="resChange" id="resChange" disabled>
										<label for="resChange"><center>Resistor (K&#8486;)</center></label>
									</div>
									<div class="input-field col s5">
										<input type="text" name="after_freq" id="after_freq">
										<label for="after_freq"><center>After Calibration - Freq (MHz)</center></label>
									</div>
									<div class="input-field col s5">
										<input type="text" name="after_bpf" id="after_bpf">
										<label for="after_bpf"><center>After Calibration - BPF AC (V)</center></label>
									</div>
								</div>

								<div class="row">
									<center>
										<span style="font-weight: bold; font-size: 16px" class="teal-text text-darken-2">Additional Information - Before Calibration</span>
									</center>
								</div>

								<div class="row">
									<div class="input-field col s6">
										<input type="text" name="datePicker" id="datePicker" class="datepicker" required>
										<label for="datePicker"><center>Record date</center></label>
									</div>
									<div class="input-field col s6">
										<input type="text" name="op_name" id="op_name" required>
										<label for="op_name"><center>Operator's Name</center></label>
									</div>
								</div>

								<div class="row">
									<center>
										<span style="font-weight: bold; font-size: 16px" class="teal-text text-darken-2">Additional Information - After Calibration</span>
									</center>
								</div>

								<div class="row">
									<div class="input-field col s6">
										<input type="text" name="datePickerAfterCal" id="datePickerAfterCal" class="datepicker" required>
										<label for="datePickerAfterCal"><center>Record date</center></label>
									</div>
									<div class="input-field col s6">
										<input type="text" name="op_name_after_cal" id="op_name_after_cal" required>
										<label for="op_name_after_cal"><center>Operator's Name</center></label>
									</div>
								</div>

								<center>
									<a class="waves-effect waves-light btn" id="submitButton">SUBMIT</a>
									<a class="btn waves-effect waves-red red lighten-2" id="clearButton">CLEAR</a>
								</center>

							</form>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="qaCard" style="display: none;">
						<div class="row">
							
							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Visual Inspection Details</span>
							</center>

							<form class="col s12" method="post" id="qaForm">
								<div class="row">

									<div class="row">
										<div class="input-field col s6">
											<input id="qa_pcb_no" name="qa_pcb_no" type="text" required autofocus>
											<label for="wa_pcb_no"><center>PCB Number</center></label>
										</div>
										<div class="input-field col s6">
											<select name="qa_stage" id="qa_stage">
												<option value="" disabled selected>-- Select --</option>
												<option value="PCB">PCB</option>
												<option value="HSG">Housing</option>
											</select>
										</div>
									</div>

									<div class="row">
										<center>
										<div class="col s6">
											<span class="black-text">Visual inspection results :</span>
										</div>
										<div class="col s6">
											<input type="radio" name="qaGroup" class="with-gap" id="radioPass" name="radioPass" value="1" onchange="onQaRadioChange()" checked>
											<label for="radioPass">PASS</label>
											<input type="radio" name="qaGroup" class="with-gap" id="radioRework" name="radioRework" value="0" onchange="onQaRadioChange()">
											<label for="radioRework">REWORK</label>
											<input type="radio" name="qaGroup" class="with-gap" id="radioReject" name="radioReject" value="-1" onchange="onQaRadioChange()">
											<label for="radioReject">REJECT</label>
										</div>
										</center>
									</div>

									<div class="row" style="display: none;" id="qaFailRow">
										<div class="input-field col s12">
											<select name="qaFailReason" id="qaFailReason">
												<option value="" disabled selected>Select reason of Rejection/Rework</option>
												<option value="1">1 - Wire not properly soldered</option>
												<option value="2">2 - Broken wire, Damaged Insulation</option>
												<option value="3">3 - Improper wire length</option>
												<option value="4">4 - DET pin not soldered properly</option>
												<option value="5">5 - VIN pin not soldered properly</option>
												<option value="6">6 - PST pin not soldered properly</option>
												<option value="7">7 - SW1/IMP pin not soldered properly</option>
												<option value="8">8 - GND pin not soldered properly</option>
												<option value="9">9 - MOD pin not soldered properly</option>
												<option value="10">10 - SIG pin not soldered properly</option>
												<option value="11">11 - VRF pin not soldered properly</option>
												<option value="12">12 - Pin cross / bend</option>
												<option value="13">13 - Improper pin length</option>
												<option value="14">14 - Pin / test pin cut</option>
												<option value="15">15 - Plating of pin / test pin</option>
												<option value="16">16 - Soldering ring not observed (bottom side)</option>
												<option value="17">17 - Solder balls seen</option>
												<option value="18">18 - Imapct switch soldering improper</option>
												<option value="19">19 - Excess solder on impact switch</option>
												<option value="20">20 - Damanged / swollen bush of imapct switch</option>
												<option value="21">21 - Imapct switch tilted</option>
												<option value="22">22 - Excess flux</option>
												<option value="23">23 - Components not properly soldered</option>
												<option value="24">24 - Soldered components damaged</option>
												<option value="25">25 - Wrong components soldered</option>
												<option value="26">26 - Shorting of component pins</option>
												<option value="27">27 - Component missing</option>
												<option value="28">28 - PCB track cut</option>
												<option value="29">29 - Solder pad on PCB damaged / removed</option>
												<option value="30">30 - Improper barcode printing</option>
												<option value="31">31 - Crystal pad damaged</option>
												<option value="50">50 - Others</option>
												<option value="100">100 - MULTIPLE FAULTS</option>
											</select>
										</div>
									</div>

									<div class="row" style="display: none;" id="qaFailCommentRow">
										<div class="input-field col s12">
											<input id="qaFailComment" type="text">
											<label for="qaFailComment">Enter Description</label>
										</div>
									</div>

									<div class="row">
										<center>
											<span style="font-weight: bold; font-size: 16px" class="teal-text text-darken-2">Additional Information</span>
										</center>
									</div>

									<div class="row">
										<div class="input-field col s6">
											<input type="text" name="qaDatePicker" id="qaDatePicker" class="datepicker" required>
											<label for="qaDatePicker"><center>Record date</center></label>
										</div>
										<div class="input-field col s6">
											<input type="text" name="qa_op_name" id="qa_op_name" required>
											<label for="qa_op_name"><center>Operator's Name</center></label>
										</div>
									</div>

								</div>

								<center>
									<a class="waves-effect waves-light btn" id="qaSubmitButton">SUBMIT</a>
									<a class="btn waves-effect waves-red red lighten-2" id="qaClearButton">CLEAR</a>
								</center>

							</form>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="modulesCard" style="display: none;">
						<div class="row">
							
							<center>
								<span style="font-weight: bold; font-size: 24px" class="teal-text text-darken-2">Modules</span>
							</center>
							<br>
							<br>

							<div class="row">
								<div class="col s3" id="qa_module">
									<center>
										<img class="responsive-img" src="qa_logo.svg">
										<br>
										<span style="font-size: 22px">Q/A</span>
									</center>
								</div>
								<div class="col s3" id="ppc_module">
									<center>
										<img class="responsive-img" src="ppc.svg">
										<br>
										<span style="font-size: 22px">PPC</span>
									</center>
								</div>
								<div class="col s3" id="production_module">
									<center>
										<img class="responsive-img" src="production.svg">
										<br>
										<span style="font-size: 22px">Production</span>
									</center>
								</div>
								<div class="col s3" id="testing_module">
									<center>
										<img class="responsive-img" src="testing.svg">
										<br>
										<span style="font-size: 22px">Testing</span>
									</center>
								</div>
							</div>

							<script type="text/javascript">
								$('#production_module').click(function() {
									$("#productionDialog" ).dialog({
										autoOpen: false,
										modal : true,
										show : 'blind',
										hide : 'blind',
										width: '30%',
										title: "Production Module"
									});
									$('#productionDialog').dialog('open');
									$('.ui-widget-overlay').bind('click', function(){
										$('#productionDialog').unbind();
										$('#productionDialog').dialog('close');
									});
								});
								$('#qa_module').click(function() {
									$("#qaDialog" ).dialog({
               			autoOpen: false,
               			modal : true,
										show : 'blind',
										hide : 'blind',
										width: '30%',
										title: "Q/A Module"
       						});
       						$('#qaDialog').dialog('open');
									$('.ui-widget-overlay').bind('click', function(){
										$('#qaDialog').unbind();
										$('#qaDialog').dialog('close');
									});
								});
								$('#testing_module').click(function() {
									$("#testingDialog" ).dialog({
               			autoOpen: false,
               			modal : true,
										show : 'blind',
										hide : 'blind',
										width: '30%',
										title: "Testing Module"
       						});
       						$('#testingDialog').dialog('open');
									$('.ui-widget-overlay').bind('click', function(){
										$('#testtingDialog').unbind();
										$('#testtingDialog').dialog('close');
									});
								});
								$('#ppc_module').click(function() {
									$("#ppcDialog" ).dialog({
               			autoOpen: false,
               			modal : true,
										show : 'blind',
										hide : 'blind',
										width: '30%',
										title: "PPC Module"
       						});
       						$('#ppcDialog').dialog('open');
									$('.ui-widget-overlay').bind('click', function(){
										$('#ppcDialog').unbind();
										$('#ppcDialog').dialog('close');
									});
								});
							</script>

						</div>

						<div id='productionDialog' style="display: none;">
							<ul>
								<li><a href="vendor.php" target="_blank" style="color: blue;">&#9672; Vendor wise PCB Series Entry</a></li>
								<li><a id="barcodeRecordLink" href="#" style="color: blue;">&#9672; Lotwise Report : Barcode linking</a></li>
								<li><a id="batteryRecordLink" href="#" style="color: blue;">&#9672; Lotwise Report: Battery linking</a></li>
							</ul>
						</div>

						<div id='qaDialog' style="display: none;">
							<ul>
								<li><a href="analytics.php" target="_blank" style="color: blue;">&#9672; Vendor wise Rejection</a></li>
							</ul>
						</div>

						<div id='ppcDialog' style="display: none;">
							<ul>
								<li><a href="batch_code.php" target="_blank" style="color: blue;">&#9672; PCB Batch Code Entry</a></li>
							</ul>
						</div>

						<div id='testingDialog' style="display: none;">
							<ul>
								<li><a href="analytics.php" target="_blank" style="color: blue;">&#9672; Analytics: Testing Count</a></li>
								<li><a id="dailyCountLink" href="#" style="color: blue;">&#9672; Lotwise Report : Daily Count + Cumulative</a></li>
								<li><a id="testingRecordLink" href="#" style="color: blue;">&#9672; Lotwise Report: Electrical Parameters (All stages)</a></li>
							</ul>
						</div>

					</div>

					<div class="card-panel grey lighten-4" id="mgrsCard" style="display: none;">
						<div class="row">
							
							<center>
								<span style="font-weight: bold; font-size: 24px" class="teal-text text-darken-2">Tools</span>
							</center>
							<br>
							<br>

							<div class="row">
								<div class="col s4 modal-trigger" href="#searchModal">
									<center>
										<img class="responsive-img" src="search.svg">
										<br>
										<span style="font-size: 22px">Search</span>
									</center>
								</div>
								<div class="col s4" onclick="window.open('rejection.php','_blank');">
									<center>
										<img class="responsive-img" src="error.svg">
										<br>
										<span style="font-size: 22px">Rejections</span>
									</center>
								</div>
								<div class="col s4" onclick="window.open('mtrlmgmt.php','_blank');">
									<center>
										<img class="responsive-img" src="cart.svg">
										<br>
										<span style="font-size: 22px">Shopfloor Material Management</span>
									</center>
								</div>
								<div class="col s4" onclick="window.open('analytics.php','_blank');" style="margin-top: 45px;">
									<center>
										<img class="responsive-img" src="chart.svg">
										<br>
										<span style="font-size: 22px">Analytics</span>
									</center>
								</div>
								<div class="col s4" onclick="window.open('solution.php','_blank');" style="margin-top: 45px;">
									<center>
										<img class="responsive-img" src="check.svg">
										<br>
										<span style="font-size: 22px">Problems & Solutions</span>
									</center>
								</div>
								<div class="col s4" onclick="$('#reportModal').openModal();" style="margin-top: 45px;">
									<center>
										<img class="responsive-img" src="report.svg">
										<br>
										<span style="font-size: 22px">Lotwise Reports</span>
									</center>
								</div>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="batteryCard" style="display: none;">
						<div class="row">
							
							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Link with Battery Record</span>
							</center>

							<br><br><br>
							
							<div class="row">
								<div class="col s3"></div>
								<div class="input-field col s6">
									<input id="battery_pcb_no" name="battery_pcb_no" type="text" autofocus>
									<label for="battery_pcb_no"><center>Scan PCB Number</center></label>
								</div>
								<div class="col s3"></div>
							</div>
							<div class="row">
								<div class="col s3"></div>
								<div class="input-field col s6">
									<input id="battery_lot_no" name="battery_lot_no" type="text">
									<label for="battery_lot_no"><center>Enter Battery Lot Number</center></label>
								</div>
								<div class="col s3"></div>
							</div>
							<br>
							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2" id="batterySpan"></span>
							</center>
							<br>

							<center>
								<a class='btn waves-light waves-effect' id='batterySubmitButton'>SUBMIT</a>
								<a class='btn red waves-effect' id='batteryClearButton' >CLEAR</a>
							</center>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="barcodeCard" style="display: none;">
						<div class="row">
							
							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Link PCB Number with BEL Barcode</span>
							</center>

							<br><br><br>
							
							<div class="row">
								<div class="col s3"></div>
								<div class="input-field col s3">
									<input id="barcode_pcb_no" name="barcode_pcb_no" type="text" autofocus>
									<label for="barcode_pcb_no"><center>Scan PCB Number</center></label>
								</div>
								<div class="input-field col s3">
									<input id="barcode_pcb_no_manual" name="barcode_pcb_no_manual" type="text">
									<label for="barcode_pcb_no_manual"><center>Or Enter Manually</center></label>
								</div>
								<div class="col s3"></div>
							</div>
							<div class="row">
								<div class="col s3"></div>
								<div class="input-field col s6">
									<input id="barcode_sticker_no" name="barcode_sticker_no" type="text">
									<label for="barcode_sticker_no"><center>Scan Barcode Sticker</center></label>
								</div>
								<div class="col s3"></div>
							</div>
							<br>
							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2" id="barcodeSpan"></span>
							</center>
							<br>

							<center>
								<a class='btn waves-light waves-effect' id='barcodeSubmitButton'>SUBMIT</a>
								<a class='btn red waves-effect' id='barcodeClearButton' >CLEAR</a>
							</center>

							<div class="row">
								<br><br>
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Or Upload Excel file</span>
								</center>
								<br>
								<form action="submit_barcode.php" method="POST" enctype="multipart/form-data">
								
									<center>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn">Upload</button>
									</center>

								</form>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="solderingCard" style="display: none;">
						<div class="row">
							
							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Scan PCB number for resistor value</span>
							</center>

							<br>
							<br>
							
								<div class="row">

									<div class="row">
										<div class="input-field col s6">
											<input id="soldering_pcb_no" name="soldering_pcb_no" type="text" autofocus>
											<label for="soldering_pcb_no"><center>Scan PCB Number</center></label>
										</div>

										<div class="input-field col s6">
											<input id="soldering_pcb_no_manual" name="soldering_pcb_no_manual" type="text">
											<label for="soldering_pcb_no"><center>Or Enter Manually</center></label>
										</div>
									</div>

									<center>
										<br>
										<div class="row">
											<span class="teal-text text-darken-2" id="solderingNo" style="font-weight: bold; font-size: 18px; display: none">
												PCB Number
											</span>
											<br><br>
											<span class="teal-text text-darken-2" id="solderingRes" style="font-weight: bold; font-size: 24px; display: none">
											100 K&#8486;
											</span>
										</div>

										<br>
										<br>
										<a class="waves-effect waves-light btn" id="solderingSubmitButton">SUBMIT</a>
										<a class="btn waves-effect waves-red red lighten-2" id="solderingClearButton">CLEAR</a>
									</center>

								</div>
							

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="lotCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Lot-wise Entry</span>
								</center>
								<br>
								<br>

								<div class="row">
									<div class="input-field col s4">
										<input id="mainLotNoText" name="mainLotNoText" type="text" autofocus>
										<label for="mainLotNoText"><center>Enter Main Lot Number</center></label>
									</div>
									<div class="input-field col s4">
										<input id="kitLotNoText" name="kitLotNoText" type="text">
										<label for="kitLotNoText"><center>Enter Kit Lot Number</center></label>
									</div>
									<br>
									<a class="btn waves-effect waves-light col s4 center" id='lotViewButton'>VIEW LOT</a>
								</div>

								<div class="row">
									<div class="input-field col s4">
										<input id="lotScanPcb" name="lotScanPcb" type="text">
										<label for="lotScanPcb"><center>Scan PCB Number</center></label>
									</div>
									<div class="input-field col s4">
										<input id="lotManualPcb" name="lotManualPcb" type="text">
										<label for="lotManualPcb"><center>Or Enter manually</center></label>
									</div>
									<br>
									<a class="btn waves-effect waves-light col s4 center" id='lotManualButton'>ADD MANUALLY</a>
								</div>

								<div class="row">
									<center>
										<span style="font-weight: bold; font-size: 18px" id='lotRecordCountTitle'class="teal-text text-darken-2"># Records found in this Kit Lot</span>
										<br>
										<span style="font-size: 12px" class="grey-text text-darken-2">Note: Entries with Red colour are rejected in testing.</span>
									</center>
								</div>

								<div class="row" id="lotEntryTable">
								</div>

							</div>
						</div>
					</div>

					<div class="card-panel grey lighten-4" id="afterPUCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Upload Excel file of results After PU Potting</span>
								</center>
							</div>

							<div class="row">
								<br>
								<form action="after_pu_upload.php" method="POST" enctype="multipart/form-data">
								
									<center>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn">Upload</button>
									</center>

								</form>
							</div>

							<div class="row">
								<br>
								<br>
								<center>
									<a href="PROX UNIT HEAD - LogToExcel.exe">Download PROX UNIT HEAD - Log to Excel converter application</a>
								</center>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="pcbTestingCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Upload Excel file of results After PCB testing</span>
								</center>
							</div>

							<div class="row">
								<br>
								<form action="pcb_testing_upload.php" method="POST" enctype="multipart/form-data">
								
									<center>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn">Upload</button>
									</center>

								</form>
							</div>

							<div class="row">
								<br>
								<br>
								<center>
									<a href="LogToExcel.exe">Download Log to Excel converter application</a>
								</center>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="HousingTestingCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Upload Excel file of results After HOUSING testing</span>
								</center>
							</div>

							<div class="row">
								<br>
								<form action="housing_testing_upload.php" method="POST" enctype="multipart/form-data">

									<div class="row" id="housingLotRow">
										<div class="col s4"></div>
										<div class="input-field col s2">
											<input id="mainLotNoText" name="mainLotNoText" type="text" autofocus>
											<label for="mainLotNoText"><center>Main Lot</center></label>
										</div>
										<div class="input-field col s2">
											<input id="kitLotNoText" name="kitLotNoText" type="text">
											<label for="kitLotNoText"><center>Kit Lot</center></label>
										</div>
									</div>
								
									<center>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn" id="housingAteUpload">Upload</button>
									</center>

								</form>
							</div>

							<div class="row">
								<br>
								<br>
								<center>
									<a href="LogToExcel.exe">Download Log to Excel converter application</a>
								</center>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="PottedHousingTestingCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Upload Excel file of results After testing POTTED HOUSING</span>
								</center>
							</div>

							<div class="row">
								<br>
								<form action="potting_testing_upload.php" method="POST" enctype="multipart/form-data">
								
									<center>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn">Upload</button>
									</center>

								</form>
							</div>

							<div class="row">
								<br>
								<br>
								<center>
									<a href="LogToExcel.exe">Download Log to Excel converter application</a>
								</center>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="reworkCard" style="display: none;">
						<div class="row">
							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Rework</span>
								<br>
								<br>
								<img class="responsive-img" src="under_con.jpg" width="258" height="196"></img>
							</center>
						</div>
					</div>

					<!-- EMPTY DIVS.. DEEP CLONING WITH JS, SAVES BANDWIDTH -->

					<div class='card-panel grey lighten-4' id='HousingTestingManualCard' style="display: none;"></div>

					<div class='card-panel grey lighten-4' id='PottingTestingManualCard' style="display: none;"></div>          

					<div class='card-panel grey lighten-4' id='pcbTestingManualCard' style="display: none;">
						<div class='row manual-testing-clone' id='manualTestingClone'>
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='pcbTestingManualTitle'>PCB Testing - Manual</span>
							</center>

							<form id='pcbTestingManualForm'>
							<br>
								<table id='pcbTestingManualTable'>
									<tbody>

										<tr>
										<td class='center'><span class='center'>PCB Number <br>(12 digits)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Current<br>(7-14 mA) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualCurrent' data-position='bottom' data-delay='500' data-tooltip='7 to 14 mA' class='tooltipped'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Voltage<br>(5.3-6.15 V) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVee' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.30 to 6.20 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PST Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>VBAT-PST Delay <br>(600-700 mS) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVbatPst' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='600 to 700 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Ampl <br>(12-21 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualPstAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='12 to 21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Width <br>(30-120 uS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualPstWid' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>MOD Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>Frequency <br>(46-55 KHz)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualFreq' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='46 to 55 KHz'>
												</div>
											</td>
											<td class='center'><span class='center'>DC <br>(7-8.1 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualModDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='7 to 8.1 V'>
												</div>
											</td>
											<td class='center'><span class='center'>AC <br>(0.95-1.35 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualModAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0.95 to 1.35 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>VRF Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>VBAT-Cap Charge T <br>(695-730 mS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualCapCharge' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='695 to 730 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>VRF Ampl <br>(15.3-16.7 V) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVrfAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='15.3 to 16.7 V'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-VRF Delay <br>(2.08-2.3 Sec)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVbatVrf' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.08 to 2.30 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-SIL Delay <br>(2.7-3.2 Sec)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVbatSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.7 to 3.2 Sec'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PROX Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>DET Width <br>(30-120 uS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <br>(-12 to -21 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>Cycles <br>(4-6)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualCycles' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4 to 6'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF DC <br>(5.2-6.4 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualBpfDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.2 to 6.4 V'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF AC <br>(2.5-3.6 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualBpfAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.5 to 3.6 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;' id="bgNoiseHeader">BPF (Background Noise)</span></center>

								<table id="bgNoiseTable">
									<tbody>										
										<tr>
											<td class='center'><span class='center'>BPF Noise DC <br>(5.2-6.4 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsBpfNoiseDc' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5 to 6.5 V'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF Noise AC <br>(0-0.2 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='PcbTestingDetailsBpfNoiseAc' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0 to 0.25 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Noise & LVP Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>SIL <br>(480-650 mS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='480 to 650 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>LVP <br>(18.8-21 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualLvp' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='18.8 to 21 V'>
												</div>
											</td>
										</tr>
									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PD Test</span></center>

								<table>
									<tbody>

											<td class='center'><span class='center'>Delay <br>(0-10 uS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualPDDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0 to 10 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <br>(-12 to -21 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualPDDet' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -22 V'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Results</span></center>

								<table>
									<tbody>
										<tr>
											<td class='center'><span class='center'>SAFE Test <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center' style="display: none;">
													<input type='text' id='pcbTestingManualSafe' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='PASS or FAIL' value="PASS">
												</div>
												<input class="with-gap" name="safeTestRadio" type="radio" id="safePass" value="PASS" checked />
  											<label for="safePass">Pass</label>
  											<input class="with-gap" name="safeTestRadio" type="radio" id="safeFail" value="FAIL"/>
  											<label for="safeFail">Fail</label>
											</td>
											<td class='center'><span class='center'>Result <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center' style="display: none;">
													<input type='text' id='pcbTestingManualResult' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='PASS or FAIL' value="PASS">
												</div>
												<input class="with-gap" name="resultRadio" type="radio" id="resultPass" value="PASS" checked />
  											<label for="resultPass">Pass</label>
  											<input class="with-gap" name="resultRadio" type="radio" id="resultFail" value="FAIL"/>
  											<label for="resultFail">Fail</label>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Additional Information</span></center>

								<table>
									<tbody>
										<tr>
											<td class='center'><span class='center'>Record Date <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center' id="manualTestingDataDatePicker">
													<input type='text' id='pcbTestingManualRecordDate' class="datepicker">
												</div>
											</td>
											<td class='center'><span class='center'>Operator Name <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualOperatorName'>
												</div>
											</td>
										</tr>
										<tr id="pcbTestingManualLotInfo">
											<td class='center'><span class='center'>Main Lot<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualMainLot'>
												</div>
											</td>
											<td class='center'><span class='center'>Kit Lot<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type="text" id='pcbTestingManualKitLot'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center>
									<a class='btn waves-light waves-effect' id='pcbTestingManualSubmitButton'>SUBMIT</a>
									<a class='btn red waves-effect' id='pcbTestingManualClearButton'>CLEAR</a>
								</center>

							</form>
						</div>
					</div>

					<div class="card-panel grey lighten-4" id="unavailableCard" style="display: none;">
						<div class="row">
							<center>
								<span style="font-weight: bold; font-size: 20px" class="red-text text-darken-1">Requested resource is currently unavailable.</span>
							</center>
						</div>
					</div>


					<div class="card-panel grey lighten-4" id="epdAtePcbCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">PCB - Upload CSV file from Dot-Sys EPD ATE</span>
								</center>
							</div>

							<div class="row">
								<br>
								<form action="pcb_epd_upload_csv.php" method="POST" enctype="multipart/form-data">
								
									<center>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn">Upload</button>
									</center>

								</form>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="epdAteHousingCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">HOUSING - Upload CSV file from Dot-Sys EPD ATE</span>
								</center>
							</div>

							<div class="row">
								<br>
								<form action="housing_epd_upload_csv.php" method="POST" enctype="multipart/form-data">
								
									<center>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn">Upload</button>
										<br><br>
										<div class="col s4"></div>
										<div class='input-field col s4 center'>
											<input type="number" name="main_lot">
											<label for="main_lot">*Enter Main Lot No</label>
										</div>
									</center>

								</form>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="epdAtePottingCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">POTTED HSG - Upload CSV file from Dot-Sys EPD ATE</span>
								</center>
							</div>

							<div class="row">
								<br>
								<form action="potted_epd_upload_csv.php" method="POST" enctype="multipart/form-data">
								
									<center>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn">Upload</button>
									</center>

								</form>
							</div>

						</div>
					</div>

					<div class="card-panel grey lighten-4" id="epdAteHeadCard" style="display: none;">
						<div class="row">
							
							<div class="row">
								<center>
									<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">ELECTRONIC HEAD - Upload CSV file from Dot-Sys EPD ATE</span>
								</center>
							</div>

							<div class="row">
								<br>
								<form action="head_epd_upload_csv.php" method="POST" enctype="multipart/form-data">
								
									<center>
										<div class="col s2"></div>
										<div class="input-field col s4">
											<input id="main_lot" name="main_lot" type="text" autofocus>
											<label for="main_lot"><center>Main Lot</center></label>
										</div>
										<br>
										<input type="file"  name="file" >
										<button type="submit" value="submit" class="btn">Upload</button>
									</center>

								</form>
							</div>

						</div>
					</div>

					<div class='card-panel grey lighten-4' id='epdHousingTestingDetailsCard' style="display: none;"></div>

					<div class='card-panel grey lighten-4' id='epdPottedTestingDetailsCard' style="display: none;"></div>

					<div class='card-panel grey lighten-4' id='epdHeadTestingDetailsCard' style="display: none;"></div>

					<div class='card-panel grey lighten-4' id='epdPcbTestingDetailsCard' style="display: none;">
						<div class='row' id="epdTestingClone">
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='epdPcbTestingDetailsTitle'>EPD - PCB Test Report</span>
							</center>

							<br>
								<table id='epdPcbTestingDetailsTable'>
									<tbody>

										<tr>
										<td class='center'><span class='center'>PCB Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Current (I)<br>(1.3 to 7 mA) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsCurrent' data-position='bottom' data-delay='500' data-tooltip='1.3 to 7 mA' class='tooltipped'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Voltage (VDD)<br>(4.4 to 5.8 V) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsVee' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4.4 to 5.5 V'>
												</div>
											</td>
											<td class='center'><span class='center'>TPCD Delay<br>(1 to 80 mS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsTpcd' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='1 to 80 mS' disabled>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PST Test</span></center>

								<table>
									<tbody>

										<tr>
											<td class='center'><span class='center'>PST Ampl<br>(5 to 9 V) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsPstAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5 to 9 V'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Width<br>(200 uS min) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsPstWid' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='200 uS (min)'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-PST Delay<br>(500 to 700 mS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsVbatPst' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='590 to 700 mS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>


								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>PD Test</span></center>

								<table>
									<tbody>

										<tr>
										<td class='center'><span class='center'>DET Ampl<br>(4.8 to 8.5 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsPDDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4.8 to 8.5 V'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Width<br>(250 uS min)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsPDDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='250 uS (min)'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Delay<br>(1 to 40 uS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsPDDetDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='1 to 40 uS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Delay Test</span></center>

								<table>
									<tbody>

										<tr>
										<td class='center'><span class='center'>DET Ampl<br>(4.8 to 8.5 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsDelayDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4.8 to 8.5 V'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Width<br>(250 uS min)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsDelayDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='250 uS (min)'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Delay<br>(40 to 80 mS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsDelayDetDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='40 to 80 mS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Switch Integrity Test</span></center>

								<table>
									<tbody>

										<tr>
										<td class='center'><span class='center'>DET Ampl<br>(4.8 to 8.5 V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsSIDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4.8 to 8.5 V'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Width<br>(250 uS min)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsSIDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='250 uS (min)'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Delay<br>(40 to 80 mS)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsSIDetDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='40 to 80 mS'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Results</span></center>

								<table>
									<tbody>

											<td class='center'><span class='center'>SAFE Test - PST Amp<br>(0V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsSafePst'>
												</div>
											</td>
											<td class='center'><span class='center'>SAFE Test - DET Amp<br>(0V)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsSafeDet'>
												</div>
											</td>
											<td class='center'><span class='center'>Result<br>(PASS/FAIL)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingDetailsResult'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>

								<center><span class='black-text' style='font-weight: bold; font-size:16px;'>Additional Information</span></center>

								<table>
									<tbody>
										<tr>
											<td class='center'><span class='center'>Record Date <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center' id="manualTestingDataDatePicker">
													<input type='text' id='epdPcbTestingManualRecordDate' class="datepicker">
												</div>
											</td>
											<td class='center'><span class='center'>Operator Name <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='epdPcbTestingManualOperatorName'>
												</div>
											</td>
										</tr>
									</tbody>
								</table>

								<center>
									<a class='btn waves-light waves-effect' id='epdPcbTestingManualSubmitButton'>SUBMIT</a>
									<a class='btn red waves-effect' id='epdPcbTestingManualClearButton'>CLEAR</a>
								</center>


						</div>
					</div>

					<div class="card-panel grey lighten-4" id="searchCard" style="display: none;">
						<div class="row">
							<center>
								<span style="font-weight: bold; font-size: 24px" class="teal-text text-darken-2">Search</span>
							</center>

							<div class="row" id="searchSelect">
								<div class="input-field col s2">
									<select name="searchSelect" id="searchSelect">
										<option value="1" selected>PCB Number</option>
										<option value="2">RF Number</option>
										<option value="3">Resistor Value</option>
										<option value="4">Before Freq</option>
										<option value="5">Before BPF AC</option>
										<option value="6">After Freq</option>
										<option value="7">After BPF AC</option>
										<option value="8">Date</option>
										<option value="9">Operator Name</option>
										<option value="10">Result(Pass/Fail)</option>
									</select>
									<label>Search by</label>
								</div>

								<div class="input-field col s8">
									<input type="text" name="search_box" id="search_box" autofocus>
									<label for="search_box">What to search?</label>
								</div>

								<br>
								<a class="btn col s2" href="#" id="searchButton">SEARCH</a>

							</div>

							<script type="text/javascript">$('select').material_select();</script>

						</div>
					</div>

				</div>
			</div>
	</main>

	<footer class="page-footer teal lighten-2">
		<div class="footer-copyright">
			<div class="container">
				<center>&copy; Bharat Electronics Ltd. (<?php echo(strval(date('Y'))); ?>), All rights reserved.</center>
			</div>
		</div>
	</footer>

	</body>

	<script type="text/javascript">

		$(document).ready(function(){
			$('input:radio[name=safeTestRadio]').change(function(){
			$('#pcbTestingManualSafe').val($('input:radio[name=safeTestRadio]:checked').val());
				console.log($('input:radio[name=safeTestRadio]:checked').val());
			});

			$('input:radio[name=resultRadio]').change(function(){
				$('#pcbTestingManualResult').val($('input:radio[name=resultRadio]:checked').val());
				console.log($('input:radio[name=resultRadio]:checked').val());
			});
			if($.cookie('fuzeStart') == "10" || $.cookie('fuzeStart') == "12") {
				$('#bgNoiseTable').fadeOut();
				$('#bgNoiseHeader').fadeOut();
			}
			if($.cookie('fuzeType') != 'PROX' && $.cookie('fuzeStart') == "9") {		// hide lot info for EPD & TIME Fuzes
				$('#housingLotRow').fadeOut();
			}
			if($.cookie('fuzeType') == "PROX" && ($.cookie('fuzeStart') == "8" || $.cookie('fuzeStart') == "12")) {
				$('#pcbTestingManualLotInfo').remove();
			}

			if($.cookie('searchFuzeType') == "EPD" || $.cookie('fuzeType') == "EPD") {
				$('#radioEPD').prop('checked',true);
			}
			else if($.cookie('searchFuzeType') == "TIME" || $.cookie('fuzeType') == "TIME") {
				$('#radioTIME').prop('checked',true);
			}
		});

		var isBound = false;
		$('.modal-trigger').leanModal({
					dismissible: true, // Modal can be dismissed by clicking outside of the modal
					opacity: .5, // Opacity of modal background
					inDuration: 300, // Transition in duration
					outDuration: 200, // Transition out duration
					startingTop: '4%', // Starting top style attribute
					endingTop: '10%', // Ending top style attribute
					ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.

						$('#searchSelect').on('change',function() { 				// show datepicker if date is selected
							if($('#searchSelect :selected').val() == '8') {
								$('#searchModalDatePickerRow').fadeIn();
								$('#quickSearchDiv').fadeOut();
								$('#search_box_div').animate({ opacity:0 });
							}
							else {
								$('#searchModalDatePickerRow').fadeOut();
								$('#quickSearchDiv').fadeIn();
								$('#search_box_div').animate({ opacity:1 });
							}
						});

						$('#search_box').focus();
						if(!isBound) {
							$('#search_box').keypress(function (e) {
							 var key = e.which;
							 console.log(key);
							 if(key == 13)  // the enter key code
								{
									$('#searchButton').trigger('click');
									return false;  
								}
							});

							$('#searchButton').click(function(){
								var quickSearch = 1;
								if($('#QuickSearchSwitch').prop('checked')) {
									quickSearch = 1;
								}
								else {
									quickSearch = 0;
								}
								document.getElementById('searchDynamicTable').innerHTML = "";
								$('#searchPreloader').fadeIn();
								var text = $('#search_box').val();
								var select = $('#searchSelect :selected').val();
								var tableSelect = $('#searchTableSelect :selected').val();
								if(text === "" && select != '8'){
									Materialize.toast("Search box can't be kept blank",2500,'rounded');
									$('#search_box').focus();
									$('#searchPreloader').fadeOut();
									return false;
								}
								else if(text === "%" || text.includes("%%") || text === "*" || text.includes("**") || text.includes("%*") || text.includes("*%")) {
									Materialize.toast("Wildcard search is not allowed here!",2500,'rounded');
									$('#search_box').focus();
									$('#searchPreloader').fadeOut();
									return false;
								}
								if(select != '8') {
									$.ajax({
										url : 'search.php',
										type: 'post',
										data: {
											query: text,
											select: select,
											tableSelect: tableSelect,
											quickSearch: quickSearch
										},
										success: function(msg) {
											$('#searchPreloader').fadeOut();
											document.getElementById('searchDynamicTable').innerHTML = msg;
										},
										error: function(XMLHttpRequest, textStatus, errorThrown) {
											 alert(errorThrown + "\n\nIs web-server offline?");
										}
									});
								}
								else {
									$.ajax({
										url : 'search.php',
										type: 'post',
										data: {
											query: text,
											select: select,
											tableSelect: tableSelect,
											datepicker1: $('#searchModalRecordDate1').val(),
											datepicker2: $('#searchModalRecordDate2').val(),
											quickSearch: 0
										},
										success: function(msg) {
											$('#searchPreloader').fadeOut();
											document.getElementById('searchDynamicTable').innerHTML = msg;
										},
										error: function(XMLHttpRequest, textStatus, errorThrown) {
											 alert(errorThrown + "\n\nIs web-server offline?");
										}
									});
								}
							});
							isBound = true;
						}
					},

					complete: function() { // Callback for Modal close
						$('#search_box').val('');
						document.getElementById('searchDynamicTable').innerHTML = '';
					} 
				}
			);

		$('#dailyCountLink').click(function () {
			$('#testingDialog').dialog('close');
			$('#reportModal').openModal();
			$('#reportSelect option[value=testing_daily_count]').prop('selected',true);
			$('select').material_select();
		});

		$('#testingRecordLink').click(function() {
			$('#testingDialog').dialog('close');
			$('#reportModal').openModal();
			$('#reportSelect option[value=testing_record]').prop('selected',true);
			$('select').material_select();
		});

		$('#barcodeRecordLink').click(function() {
			$('#productionDialog').dialog('close');
			$('#reportModal').openModal();
			$('#reportSelect option[value=barcode_record]').prop('selected',true);
			$('select').material_select();
		});

		$('#batteryRecordLink').click(function() {
			$('#productionDialog').dialog('close');
			$('#reportModal').openModal();
			$('#reportSelect option[value=battery_record]').prop('selected',true);
			$('select').material_select();
		});

		$('#reportButton').click(function() {
			if($('#reportSelect :selected').val() == "" || $('#reportFuzeSelect :selected').val() == "" || $('#reportDiaSelect :selected').val() == "" || $('#reportLotNo').val() == "") {
				Materialize.toast('Please select the required fields',2500,'rounded');
			}
			else {
				Materialize.toast('Generating Report. Please wait..',5000,'rounded');
				$.ajax({
					url : 'report.php',
					type: 'post',
					data: {
						report: $('#reportSelect :selected').val(),
						fuze_type: $('#reportFuzeSelect :selected').val(),
						fuze_diameter: $('#reportDiaSelect :selected').val(),
						lot_no: $('#reportLotNo').val()
					},
					success: function(msg) {
						//console.log(msg);
						if(msg.includes("invalid wildcard")) {
							Materialize.toast("FAILED: You can't use wildcard (*) here!",2500,'rounded');
						}
						else if(msg.includes("data not available")) {
							Materialize.toast("FAILED: Data not available!",2500,'rounded');
						}
						else {
							msg = msg.split("</Workbook>");
							msg[0] = msg[0]+"</Workbook>";
							var blob = new Blob([msg[0]], { type: 'data:application/vnd.ms-excel' }); 
							var downloadUrl = URL.createObjectURL(blob);
							var a = document.createElement("a");
							a.href = downloadUrl;
							a.download = msg[1]+".xls";
							document.body.appendChild(a);
							a.click();
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + "\n\nIs web-server offline?");
					}
				});
			}
		});

		switch($.cookie('fuzeDia')){
			case '105':
				document.getElementById('loginNavTitle').innerHTML = "105 mm " + $.cookie('fuzeType') + " Fuze Database";
				break;
			case '155':
				document.getElementById('loginNavTitle').innerHTML = "155 mm "+ $.cookie('fuzeType') +" Fuze Database";
				break;
		}

		var validationArray = new Array();

				if($.cookie('fuzeType') == "PROX" && $.cookie('fuzeAccess') != "37BD0D3935B47BE2AB57BCF91B57F499") {
			switch($.cookie('fuzeStart')){
			case '1':
				$('select').material_select();
				$('#qaCard').fadeIn();
				$('#qaCard').keypress(function (e) {
					var key = e.which || e.keyCode;
					if(key == 13)  // the enter key code
					{
						$('#qaSubmitButton').trigger('click');
						return false;  
					}
				});
				$('#qaCard').keydown(function (e) {
					var key = e.which || e.keyCode;
					if(key == 27)  // the esc key code
					{
						$('#qaClearButton').trigger('click');
						return false;  
					}
				});
				$('#qaDatePicker').val(getTodaysDate());
				break;
			case '2':
				$('#pcbTestingCard').fadeIn();
				break;
			case '3':
				$('#calibrationCard').fadeIn();
				$('#calibrationCard').keypress(function (e) {
					var key = e.which || e.keyCode;
					if(key == 13)  // the enter key code
					{
						$('#submitButton').trigger('click');
						return false;  
					}
				});
				$('#calibrationCard').keydown(function (e) {
					var key = e.which || e.keyCode;
					if(key == 27)  // the esc key code
					{
						$('#clearButton').trigger('click');
						return false;  
					}
				});
				$('#datePicker').val(getTodaysDate());
				$('#datePickerAfterCal').val(getTodaysDate());
				break;
			case '4':
				$('#afterPUCard').fadeIn();
				break;
			case '5':
				$('#reworkCard').fadeIn();
				break;
			case '6':
				$('#solderingCard').fadeIn();
				$('#solderingCard').keypress(function (e) {
					var key = e.which || e.keyCode;
					if(key == 13)  // the enter key code
					{
						$('#solderingSubmitButton').trigger('click');
						return false;  
					}
				});
				break;
			case '7':
				$('#lotCard').fadeIn();
				$('#lotManualPcb').keypress(function (e) {
					var key = e.which;
					if(key == 13)  // the enter key code
					{
						$('#lotManualButton').trigger('click');
						return false;  
					}
				});
				break;
			case '8':
				$('#pcbTestingManualRecordDate').val(getTodaysDate());
				$('#pcbTestingManualCard').fadeIn();
				$('#pcbTestingManualPcbNo').focus();
				$('input[type="text"]').each(function(){
					$(this).change(function(){
						switch($(this).attr('id')) {
							case 'pcbTestingManualCurrent':
								if(parseFloat($(this).val()) < 7 || parseFloat($(this).val()) > 14) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[0] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[0] = true;
								}
								break;
							case 'pcbTestingManualVee':
								if(parseFloat($(this).val()) < 5.30 || parseFloat($(this).val()) > 6.2) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[1] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[1] = true;
								}
								break;
							case 'pcbTestingManualVbatPst':
								if(parseFloat($(this).val()) < 600 || parseFloat($(this).val()) > 700) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[2] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[2] = true;
								}
								break;
							case 'pcbTestingManualPstAmpl':
								if(parseFloat($(this).val()) < 12 || parseFloat($(this).val()) > 21) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[3] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[3] = true;
								}
								break;
							case 'pcbTestingManualPstWid':
								if(parseFloat($(this).val()) < 30 || parseFloat($(this).val()) > 120) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[4] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[4] = true;
								}
								break;
							case 'pcbTestingManualFreq':
								if(parseFloat($(this).val()) < 46 || parseFloat($(this).val()) > 55) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[5] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[5] = true;
								}
								break;
							case 'pcbTestingManualModDC':
								if(parseFloat($(this).val()) < 7 || parseFloat($(this).val()) > 8.1) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[6] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[6] = true;
								}
								break;
							case 'pcbTestingManualModAC':
								if(parseFloat($(this).val()) < 0.95 || parseFloat($(this).val()) > 1.35) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[7] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[7] = true;
								}
								break;
							case 'pcbTestingManualVrfAmpl':
								if(parseFloat($(this).val()) < 15.3 || parseFloat($(this).val()) > 16.7) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[8] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[8] = true;
								}
								break;
							case 'pcbTestingManualVbatVrf':
								if(parseFloat($(this).val()) < 2.08 || parseFloat($(this).val()) > 2.30) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[9] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									$('#resultFail').click();
									validationArray[9] = true;
								}
								break;
							case 'pcbTestingManualCapCharge':
								if(parseFloat($(this).val()) < 695 || parseFloat($(this).val()) > 730) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[10] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[10] = true;
								}
								break;
							case 'pcbTestingManualDetWidth':
								if(parseFloat($(this).val()) < 30 || parseFloat($(this).val()) > 120) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[11] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[11] = true;
								}
								break;
							case 'pcbTestingManualDetAmpl':
								if(parseFloat($(this).val()) < -21 || parseFloat($(this).val()) > -12) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[12] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[12] = true;
								}
								break;
							case 'pcbTestingManualCycles':
								if(parseFloat($(this).val()) < 4 || parseFloat($(this).val()) > 6) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[13] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[13] = true;
								}
								break;
							case 'pcbTestingManualBpfDC':
								if(parseFloat($(this).val()) < 5.2 || parseFloat($(this).val()) > 6.4) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[14] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[14] = true;
								}
								break;
							case 'pcbTestingManualBpfAC':
								if(parseFloat($(this).val()) < 2.5 || parseFloat($(this).val()) > 3.6) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[15] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[15] = true;
								}
								break;
							case 'pcbTestingManualSil':
								if(parseFloat($(this).val()) < 480 || parseFloat($(this).val()) > 650) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[16] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[16] = true;
								}
								break;
							case 'pcbTestingManualVbatSil':
								if(parseFloat($(this).val()) < 2.7 || parseFloat($(this).val()) > 3.2) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[17] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[17] = true;
								}
								break;
							case 'pcbTestingManualLvp':
								if(parseFloat($(this).val()) < 18.8 || parseFloat($(this).val()) > 21) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[18] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[18] = true;
								}
								break;
							case 'pcbTestingManualPDDelay':
								if(parseFloat($(this).val()) < 0 || parseFloat($(this).val()) > 10) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[19] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[19] = true;
								}
								break;
							case 'pcbTestingManualPDDet':
								if(parseFloat($(this).val()) < -22 || parseFloat($(this).val()) > -12) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[20] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[20] = true;
								}
								break;
						}
					});
				});
				$('#pcbTestingManualCard').keypress(function (e) {
					var key = e.which || e.keyCode;
					if(key == 13)  // the enter key code
					{
						$('#pcbTestingManualSubmitButton').trigger('click');
						return false;  
					}
				});
				$('#pcbTestingManualCard').keydown(function (e) {
					var key = e.which || e.keyCode;
					if(key == 27)  // the esc key code
					{
						$('#pcbTestingManualClearButton').trigger('click');
						return false;  
					}
				});
				break;
			case '9':
				$('#HousingTestingCard').fadeIn();
				break;
			case '10':
				$('#manualTestingClone').clone().appendTo("#HousingTestingManualCard");
				$('#pcbTestingManualRecordDate').val(getTodaysDate());
				$('#HousingTestingManualCard').fadeIn();
				document.getElementById('pcbTestingManualTitle').innerHTML = "Housing Testing - Manual";
				$('#pcbTestingManualPcbNo').focus();
				$('input[type="text"]').each(function(){
					$(this).change(function(){
						switch($(this).attr('id')) {
							case 'pcbTestingManualCurrent':
								if(parseFloat($(this).val()) < 7 || parseFloat($(this).val()) > 14) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[0] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[0] = true;
								}
								break;
							case 'pcbTestingManualVee':
								if(parseFloat($(this).val()) < 5.30 || parseFloat($(this).val()) > 6.2) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[1] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[1] = true;
								}
								break;
							case 'pcbTestingManualVbatPst':
								if(parseFloat($(this).val()) < 600 || parseFloat($(this).val()) > 700) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[2] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[2] = true;
								}
								break;
							case 'pcbTestingManualPstAmpl':
								if(parseFloat($(this).val()) < 12 || parseFloat($(this).val()) > 21) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[3] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[3] = true;
								}
								break;
							case 'pcbTestingManualPstWid':
								if(parseFloat($(this).val()) < 30 || parseFloat($(this).val()) > 120) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[4] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[4] = true;
								}
								break;
							case 'pcbTestingManualFreq':
								if(parseFloat($(this).val()) < 46 || parseFloat($(this).val()) > 55) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[5] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[5] = true;
								}
								break;
							case 'pcbTestingManualModDC':
								if(parseFloat($(this).val()) < 7 || parseFloat($(this).val()) > 8.1) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[6] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[6] = true;
								}
								break;
							case 'pcbTestingManualModAC':
								if(parseFloat($(this).val()) < 0.95 || parseFloat($(this).val()) > 1.35) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[7] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[7] = true;
								}
								break;
							case 'pcbTestingManualVrfAmpl':
								if(parseFloat($(this).val()) < 15.3 || parseFloat($(this).val()) > 16.7) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[8] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[8] = true;
								}
								break;
							case 'pcbTestingManualVbatVrf':
								if(parseFloat($(this).val()) < 2.08 || parseFloat($(this).val()) > 2.30) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[9] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[9] = true;
								}
								break;
							case 'pcbTestingManualCapCharge':
								if(parseFloat($(this).val()) < 695 || parseFloat($(this).val()) > 730) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[10] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[10] = true;
								}
								break;
							case 'pcbTestingManualDetWidth':
								if(parseFloat($(this).val()) < 30 || parseFloat($(this).val()) > 120) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[11] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[11] = true;
								}
								break;
							case 'pcbTestingManualDetAmpl':
								if(parseFloat($(this).val()) < -21 || parseFloat($(this).val()) > -12) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[12] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[12] = true;
								}
								break;
							case 'pcbTestingManualCycles':
								if(parseFloat($(this).val()) < 4 || parseFloat($(this).val()) > 6) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[13] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[13] = true;
								}
								break;
							case 'pcbTestingManualBpfDC':
								if(parseFloat($(this).val()) < 5.2 || parseFloat($(this).val()) > 6.4) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[14] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[14] = true;
								}
								break;
							case 'pcbTestingManualBpfAC':
								if(parseFloat($(this).val()) < 2.5 || parseFloat($(this).val()) > 3.6) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[15] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[15] = true;
								}
								break;
							case 'pcbTestingManualSil':
								if(parseFloat($(this).val()) < 480 || parseFloat($(this).val()) > 650) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[16] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[16] = true;
								}
								break;
							case 'pcbTestingManualVbatSil':
								if(parseFloat($(this).val()) < 2.7 || parseFloat($(this).val()) > 3.2) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[17] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[17] = true;
								}
								break;
							case 'pcbTestingManualLvp':
								if(parseFloat($(this).val()) < 18.8 || parseFloat($(this).val()) > 21) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[18] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[18] = true;
								}
								break;
							case 'pcbTestingManualPDDelay':
								if(parseFloat($(this).val()) < 0 || parseFloat($(this).val()) > 10) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[19] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[19] = true;
								}
								break;
							case 'pcbTestingManualPDDet':
								if(parseFloat($(this).val()) < -22 || parseFloat($(this).val()) > -12) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[20] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[20] = true;
								}
								break;
						}
					});
				});
				$('#HousingTestingManualCard').keypress(function (e) {
					var key = e.which || e.keyCode;
					if(key == 13)  // the enter key code
					{
						$('#pcbTestingManualSubmitButton').trigger('click');
						return false;  
					}
				});
				$('#HousingTestingManualCard').keydown(function (e) {
					var key = e.which || e.keyCode;
					if(key == 27)  // the esc key code
					{
						$('#pcbTestingManualClearButton').trigger('click');
						return false;  
					}
				});
				break;
			case '11':
				$('#PottedHousingTestingCard').fadeIn();
				break;
			case '12':
				$('#manualTestingClone').clone().appendTo("#PottingTestingManualCard");
				$('#pcbTestingManualRecordDate').val(getTodaysDate());
				$('#PottingTestingManualCard').fadeIn();
				document.getElementById('pcbTestingManualTitle').innerHTML = "Potted Housing Testing - Manual";
				$('#pcbTestingManualPcbNo').focus();
				$('input[type="text"]').each(function(){
					$(this).change(function(){
						switch($(this).attr('id')) {
							case 'pcbTestingManualCurrent':
								if(parseFloat($(this).val()) < 7 || parseFloat($(this).val()) > 14) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[0] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[0] = true;
								}
								break;
							case 'pcbTestingManualVee':
								if(parseFloat($(this).val()) < 5.30 || parseFloat($(this).val()) > 6.2) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[1] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[1] = true;
								}
								break;
							case 'pcbTestingManualVbatPst':
								if(parseFloat($(this).val()) < 600 || parseFloat($(this).val()) > 700) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[2] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[2] = true;
								}
								break;
							case 'pcbTestingManualPstAmpl':
								if(parseFloat($(this).val()) < 12 || parseFloat($(this).val()) > 21) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[3] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[3] = true;
								}
								break;
							case 'pcbTestingManualPstWid':
								if(parseFloat($(this).val()) < 30 || parseFloat($(this).val()) > 120) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[4] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[4] = true;
								}
								break;
							case 'pcbTestingManualFreq':
								if(parseFloat($(this).val()) < 46 || parseFloat($(this).val()) > 55) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[5] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[5] = true;
								}
								break;
							case 'pcbTestingManualModDC':
								if(parseFloat($(this).val()) < 7 || parseFloat($(this).val()) > 8.1) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[6] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[6] = true;
								}
								break;
							case 'pcbTestingManualModAC':
								if(parseFloat($(this).val()) < 0.95 || parseFloat($(this).val()) > 1.35) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[7] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[7] = true;
								}
								break;
							case 'pcbTestingManualVrfAmpl':
								if(parseFloat($(this).val()) < 15.3 || parseFloat($(this).val()) > 16.7) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[8] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[8] = true;
								}
								break;
							case 'pcbTestingManualVbatVrf':
								if(parseFloat($(this).val()) < 2.08 || parseFloat($(this).val()) > 2.30) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[9] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[9] = true;
								}
								break;
							case 'pcbTestingManualCapCharge':
								if(parseFloat($(this).val()) < 695 || parseFloat($(this).val()) > 730) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[10] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[10] = true;
								}
								break;
							case 'pcbTestingManualDetWidth':
								if(parseFloat($(this).val()) < 30 || parseFloat($(this).val()) > 120) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[11] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[11] = true;
								}
								break;
							case 'pcbTestingManualDetAmpl':
								if(parseFloat($(this).val()) < -21 || parseFloat($(this).val()) > -12) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[12] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[12] = true;
								}
								break;
							case 'pcbTestingManualCycles':
								if(parseFloat($(this).val()) < 4 || parseFloat($(this).val()) > 6) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[13] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[13] = true;
								}
								break;
							case 'pcbTestingManualBpfDC':
								if(parseFloat($(this).val()) < 5.2 || parseFloat($(this).val()) > 6.4) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[14] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[14] = true;
								}
								break;
							case 'pcbTestingManualBpfAC':
								if(parseFloat($(this).val()) < 2.5 || parseFloat($(this).val()) > 3.6) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[15] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[15] = true;
								}
								break;
							case 'pcbTestingManualSil':
								if(parseFloat($(this).val()) < 480 || parseFloat($(this).val()) > 650) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[16] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[16] = true;
								}
								break;
							case 'pcbTestingManualVbatSil':
								if(parseFloat($(this).val()) < 2.7 || parseFloat($(this).val()) > 3.2) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[17] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[17] = true;
								}
								break;
							case 'pcbTestingManualLvp':
								if(parseFloat($(this).val()) < 18.8 || parseFloat($(this).val()) > 21) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[18] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[18] = true;
								}
								break;
							case 'pcbTestingManualPDDelay':
								if(parseFloat($(this).val()) < 0 || parseFloat($(this).val()) > 10) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[19] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[19] = true;
								}
								break;
							case 'pcbTestingManualPDDet':
								if(parseFloat($(this).val()) < -22 || parseFloat($(this).val()) > -12) {
									$(this).css({"border-bottom":"1px solid red", "box-shadow":"0 1px 0 0 red"});
									$('#resultFail').click();
									validationArray[20] = false;
								}
								else {
									$(this).css({"border-bottom":"1px solid #00c853", "box-shadow":"0 1px 0 0 #00c853"});
									validationArray[20] = true;
								}
								break;
						}
					});
				});
				$('#PottingTestingManualCard').keypress(function (e) {
					var key = e.which || e.keyCode;
					if(key == 13)  // the enter key code
					{
						$('#pcbTestingManualSubmitButton').trigger('click');
						return false;  
					}
				});
				$('#PottingTestingManualCard').keydown(function (e) {
					var key = e.which || e.keyCode;
					if(key == 27)  // the esc key code
					{
						$('#pcbTestingManualClearButton').trigger('click');
						return false;  
					}
				});
				break;

			case '13':
				$('#batteryCard').fadeIn();
				$('#batteryCard').keypress(function (e) {
					var key = e.which || e.keyCode;
					if(key == 13)  // the enter key code
					{
						$('#batterySubmitButton').trigger('click');
						return false;  
					}
				});
				$('#batteryCard').keydown(function (e) {
					var key = e.which || e.keyCode;
					if(key == 27)  // the esc key code
					{
						$('#batteryClearButton').trigger('click');
						return false;  
					}
				});
				break;

			case '14':
				$('#barcodeCard').fadeIn();
				/*$('#barcodeCard').keypress(function (e) {
					var key = e.which || e.keyCode;
					if(key == 13)  // the enter key code
					{
						$('#barcodeSubmitButton').trigger('click');
						return false;  
					}
				});*/
				$('#barcodeCard').keydown(function (e) {
					var key = e.which || e.keyCode;
					if(key == 27)  // the esc key code
					{
						$('#barcodeClearButton').trigger('click');
						return false;  
					}
				});
				$('#barcode_pcb_no').bind('keyup', function(e){
					if($(this).val().length > 4){
						setTimeout(function(){
							$('#barcode_sticker_no').focus();
						}, 500);
					}
				});
				var barcodeSubmitFunction = function(e){
					if($(this).val().length > 15){
						$('#barcode_sticker_no').unbind('keyup');
						setTimeout(function(){
							$('#barcodeSubmitButton').trigger('click');
							$('#barcode_sticker_no').bind('keyup', barcodeSubmitFunction);
						}, 600);
					}
				};
				$('#barcode_sticker_no').bind('keyup', function(e){
					if($(this).val().length > 15){
						$('#barcode_sticker_no').unbind('keyup');
						setTimeout(function(){
							$('#barcodeSubmitButton').trigger('click');
							$('#barcode_sticker_no').bind('keyup', barcodeSubmitFunction);
						}, 600);
					}
				});
				break;

			case '15':
				window.location = "mtrlmgmt.php";
				break;

			default:
				$('#unavailableCard').fadeIn();
			}
		}
		else if($.cookie('fuzeType') == "EPD" && $.cookie('fuzeAccess') != "37BD0D3935B47BE2AB57BCF91B57F499") {
			switch($.cookie('fuzeStart')){
				case '1':
					$('select').material_select();
					$('#qaCard').fadeIn();
					$('#qaCard').keypress(function (e) {
						var key = e.which || e.keyCode;
						if(key == 13)  // the enter key code
						{
							$('#qaSubmitButton').trigger('click');
							return false;  
						}
					});
					$('#qaCard').keydown(function (e) {
						var key = e.which || e.keyCode;
						if(key == 27)  // the esc key code
						{
							$('#qaClearButton').trigger('click');
							return false;  
						}
					});
					$('#qaDatePicker').val(getTodaysDate());
					break;
				case '2':
					$('#epdAtePcbCard').fadeIn();
					break;
				case '7':
					$('#lotCard').fadeIn();
					$('#lotManualPcb').keypress(function (e) {
						var key = e.which;
						if(key == 13)  // the enter key code
						{
							$('#lotManualButton').trigger('click');
							return false;  
						}
					});
					break;
				case '8':
					$('#epdPcbTestingDetailsCard').fadeIn();
					$('#epdPcbTestingDetailsPcbNo').focus();
					break;
				case '9':
					$('#epdAteHousingCard').fadeIn();
					break;
				case '10':
					$('#epdTestingClone').clone().appendTo("#epdHousingTestingDetailsCard");
					$('#epdPcbTestingDetailsTitle').html("EPD - HOUSING Test Report");
					$('#epdHousingTestingDetailsCard').fadeIn();
					$('#epdPcbTestingDetailsPcbNo').focus();
					break;
				case '11':
					$('#epdAtePottingCard').fadeIn();
					break;
				case '12':
					$('#epdTestingClone').clone().appendTo("#epdPottedTestingDetailsCard");
					$('#epdPcbTestingDetailsTitle').html("EPD - POTTED HOUSING Test Report");
					$('#epdPottedTestingDetailsCard').fadeIn();
					$('#epdPcbTestingDetailsPcbNo').focus();
					break;
				case '16':
					$('#epdAteHeadCard').fadeIn();
					break;
				case '17':
					$('#epdTestingClone').clone().appendTo("#epdHeadTestingDetailsCard");
					$('#epdPcbTestingDetailsTitle').html("EPD - ELECTRONIC HEAD Test Report");
					$('#epdHeadTestingDetailsCard').fadeIn();
					$('#epdPcbTestingDetailsPcbNo').focus();
					break;
				default:
					$('#unavailableCard').fadeIn();
			}
		}
		else if($.cookie('fuzeAccess') == "37BD0D3935B47BE2AB57BCF91B57F499") {
			$('#mgrsCard').fadeIn();
			$('#modulesCard').fadeIn();
			$('#menuDropdown').hide();
		}

		function validateTestEntries() {
			var finalValidation = true;
			$('#pcbTestingManualSafe').val($('#pcbTestingManualSafe').val().toUpperCase());
			if(validationArray.length < 21) {
				return false;
			}
			for(var i=0;i<validationArray.length;i++) {
				finalValidation &= validationArray[i];
			}
			return finalValidation;
		}

		function onRadioChange(){
			var formData = $('input[name=group1]:checked').attr('id');
			if(formData === "radioYes") {
				document.getElementById("resChange").disabled = false;
				//document.getElementById("after_freq").disabled = false;
				//document.getElementById("after_bpf").disabled = false;
			}
			else{
				document.getElementById("resChange").disabled = true;
				//document.getElementById("after_freq").disabled = true;
				//document.getElementById("after_bpf").disabled = true;
			}
		}

		var radioState = "radioPass";
		function onQaRadioChange() {
			radioState = $('input[name=qaGroup]:checked').attr('id');
			if(radioState === "radioPass"){
				$('#qaFailRow').fadeOut(function(onComplete){
					$('#qaFailRow').fadeOut();
					$('#qaFailComment').fadeOut();
				});
			}
			else if(radioState === "radioRework") {
				$('select').material_select();
				$('#qaFailRow').fadeIn();
				$('#qaFailComment').fadeIn();
			}
			else {
				$('#qaFailRow').fadeOut(function(onComplete){
					$('#qaFailRow').fadeIn();
				$('#qaFailComment').fadeIn();
				});
			}
		}

		function onSearchRadioChange() {
			radioState = $('input[name=searchGroup]:checked').attr('id');
			if(radioState == "radioEPD") {
				document.cookie = "searchFuzeType=EPD; expires=Mon, 31 Dec 2040 00:00:00 GMT; path=/";
			}
			else if(radioState == "radioTIME") {
				document.cookie = "searchFuzeType=TIME; expires=Mon, 31 Dec 2040 00:00:00 GMT; path=/";
			}
			else {
				document.cookie = "searchFuzeType=PROX; expires=Mon, 31 Dec 2040 00:00:00 GMT; path=/";
			}
		}

		function logout(){
			document.cookie = "fuzeLogin=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
			location.href = "index.php";
		}

		$('#clearButton').click(function(){
			$('#pcb_no').val('');
			$('#rf_no').val('');
			$('#before_bpf').val('');
			$('#before_freq').val('');
			$('#after_freq').val('');
			$('#after_bpf').val('');
			$('#resChange').val('');
			$('#radioNo').prop('checked',true);
			document.getElementById("resChange").disabled = true;
			//document.getElementById("after_freq").disabled = true;
			//document.getElementById("after_bpf").disabled = true;
			$('#pcb_no').focus();
		});

		$('#batterySubmitButton').click(function(){
			if($('#battery_lot_no').val() == "" || $('#battery_pcb_no').val() == "") {
				Materialize.toast("Please enter sufficient data.",3000,'rounded');
			}
			else {
				$('#battery_pcb_no').val($('#battery_pcb_no').val().toUpperCase());
				$('#battery_lot_no').val($('#battery_lot_no').val().toUpperCase());
				$.ajax({
					url: 'submit_battery.php',
					type: 'POST',
					data: {
						pcb_no: $('#battery_pcb_no').val(),
						battery_lot: $('#battery_lot_no').val()
					},
					success: function(msg) {
						Materialize.toast("Record Linked", 3000, 'rounded');
						$('#batterySpan').html(msg + "<br><br>");
						$('#battery_pcb_no').val('')
						$('#battery_pcb_no').focus();
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert(errorThrown + "\n\nIs web-server offline?");
					}
				});
			}
		});

		$('#barcodeSubmitButton').click(function() {
			if(($('#barcode_pcb_no').val() == "" && $('#barcode_pcb_no_manual').val() == "") || $('#barcode_sticker_no').val() == "") {
				Materialize.toast("Please enter sufficient data.",3000,'rounded');
			}
			else {
				$('#barcode_pcb_no').val($('#barcode_pcb_no').val().toUpperCase());
				$('#barcode_pcb_no_manual').val($('#barcode_pcb_no_manual').val().toUpperCase());
				$('#barcode_sticker_no').val($('#barcode_sticker_no').val().toUpperCase());
				$.ajax({
					url: 'submit_barcode.php',
					type: 'POST',
					data: {
						pcb_no: $('#barcode_pcb_no').val() == "" ? $('#barcode_pcb_no_manual').val() : $('#barcode_pcb_no').val(),
						barcode_no: $('#barcode_sticker_no').val()
					},
					success: function(msg) {
						Materialize.toast("Record Linked", 3000, 'rounded');
						$('#barcodeSpan').html(msg + "<br><br>");
						$('#barcodeClearButton').trigger('click');
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert(errorThrown + "\n\nIs web-server offline?");
					}
				});
			}
		});

		$('#barcodeClearButton').click(function() {
			$('#barcode_pcb_no').val('')
			$('#barcode_pcb_no_manual').val('')
			$('#barcode_sticker_no').val('')
			$('#barcode_pcb_no').focus();
		});

		$('#batteryClearButton').click(function() {
			$('#battery_lot_no').val('');
			$('#battery_pcb_no').val('');
			$('#battery_pcb_no').focus();
		});

		$('#submitButton').click(function(){
			if(($('#pcb_no').val().length == 0) || ($('#rf_no').val().length == 0) || ($('#before_bpf').val().length == 0) || ($('#datePicker').val().length == 0) || ($('#op_name').val().length == 0))
			{
				Materialize.toast("Can't save with blank fields.",4000,'rounded');
				Materialize.toast("Check what you have missed.",4000,'rounded');
			}
			else {
				$.ajax({
				url: 'submit_cal.php',
				type: 'POST',
				data:{
					pcb_no: $('#pcb_no').val(),
					rf_no: $('#rf_no').val(),
					before_freq: $('#before_freq').val(),
					after_freq: $('#after_freq').val(),
					before_bpf: $('#before_bpf').val(),
					after_bpf: $('#after_bpf').val(),
					resChange: $('#resChange').val(),
					changed: (($('#resChange').val().length > 0) ? '1' : '0'),
					datePicker: $('#datePicker').val(),
					op_name: $('#op_name').val().toUpperCase(),
					datePicker2: $('#datePickerAfterCal').val(),
					op_name_after_cal: $('#op_name_after_cal').val().toUpperCase(),
					task: 'add'
				},
				success: function(msg) {
					if(msg.includes("ok")){
						Materialize.toast("Record Saved",1000,'rounded');
						$('#pcb_no').val('');
						$('#rf_no').val('');
						$('#before_bpf').val('');
						$('#before_freq').val('');
						$('#after_freq').val('');
						$('#after_bpf').val('');
						$('#resChange').val('');
						$('#radioNo').prop('checked',true);
						document.getElementById("resChange").disabled = true;
						//document.getElementById("after_freq").disabled = true;
						//document.getElementById("after_bpf").disabled = true;
						$('#pcb_no').focus();
					}
					else if(msg.includes("exist")) {
							Materialize.toast("Record already exist!",3000,'rounded');
							Materialize.toast("Search this PCB number for details.",3000,'rounded');
						}
					else{
						Materialize.toast("Failed to save record!",3000,'rounded');
						Materialize.toast("Database server is offline!",3000,'rounded');
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					 alert(errorThrown + "\n\nIs web-server offline?");
				}
			});
			}
		});

		$('#pcb_no').bind('keyup', function(e){
				if($(this).val().length > 3){
					setTimeout(function(){
						$.ajax({
							url: 'submit_cal.php',
							type: 'POST',
							data: {
								task: 'load',
								pcb_no: $('#pcb_no').val()
							},
							success: function(msg) {
								try {
									msg = JSON.parse(msg);
									if(msg['0']['changed'] == "1") {
										$("#radioYes").prop("checked", true);
										$("#radioNo").prop("checked", false);
									}
									else {
										$("#radioNo").prop("checked", true);
										$("#radioYes").prop("checked", false);
									}
									onRadioChange();
									$('#rf_no').focus();
									$('#rf_no').val(msg['0']['rf_no']);
									$('#before_bpf').focus();
									$('#before_bpf').val(msg['0']['before_bpf']);
									$('#resChange').focus();
									$('#resChange').val(msg['0']['res_val'] == "0" ? "" : msg['0']['res_val']);
									$('#after_freq').focus();
									$('#after_freq').val(msg['0']['after_freq']);
									$('#after_bpf').focus();
									$('#after_bpf').val(msg['0']['after_bpf']);
									$('#op_name').focus();
									$('#op_name').val(msg['0']['op_name']);
									$('#datePicker').val(msg['0']['timestamp']);
									if(msg['0']['timestamp_after_cal'] != "0000-00-00") {
										$('#datePickerAfterCal').val(msg['0']['timestamp_after_cal']);
									}
									if(msg['0']['op_name_after_cal'] != "") {
										$('#op_name_after_cal').focus();
										$('#op_name_after_cal').val(msg['0']['op_name_after_cal']);
									}
									$('#pcb_no').focus();
								}
								catch(err) { // do nothing
									console.log(err);
								}
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								alert(errorThrown + ' Is web-server offline?');
							}
						});
					}, 300);
				}
			});

		$('#qaSubmitButton').click(function(){
			if (($('#qa_pcb_no').val().length == 0) || ($('#qa_op_name').val().length == 0) || ($('#qaDatePicker').val().length == 0) || $('#qa_stage :selected').val() == ""){
				Materialize.toast("Can't save with blank fields.",4000,'rounded');
				Materialize.toast("Check what you have missed.",4000,'rounded');
			}
			else {
				var radioValue;
				if(radioState == "radioPass") {
					radioValue = '1';
				}
				else if(radioState == "radioRework") {
					radioValue = '0';
				}
				else {
					radioValue = '-1';
				}
				$.ajax({
					url: 'submit_qa.php',
					type: 'POST',
					data: {
						qa_pcb_no: $('#qa_pcb_no').val(),
						result: radioValue,
						reason: (radioState == "radioRework" ? $('#qaFailReason').val() : ""),
						qaDatePicker: $('#qaDatePicker').val(),
						qa_op_name: $('#qa_op_name').val().toUpperCase(),
						qa_stage: $('#qa_stage').val(),
						qa_comment: $('#qaFailComment').val()
					},
					success: function(msg) {
						console.log(msg);
						if(msg.includes("ok")){
							Materialize.toast("Record Saved",1000,'rounded');
							$('#qa_pcb_no').val('');
							$('#radioPass').prop('checked',true);
							$('#qaFailReason').val('');
							$('#qaFailRow').fadeOut();
							$('#qa_pcb_no').focus();
							radioState = "radioPass";
							$('#qaFailComment').val('');
							$('#qaFailCommentRow').fadeOut();
						}
						else if(msg.includes("exist")) {
							Materialize.toast("Record already exist!",3000,'rounded');
							Materialize.toast("Search this PCB number in QA table for details.",3000,'rounded');
						}
						else{
							console.log(msg);
							Materialize.toast("Failed to save record!",3000,'rounded');
							Materialize.toast("Database server is offline!",3000,'rounded');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + "\n\nIs web-server offline?");
					}
				});
			}
		});

		$('#qaClearButton').click(function(){
			$('#qa_pcb_no').val('');
			$('#radioPass').prop('checked',true);
			$('#qaFailReason').val('');
			$('#qaFailRow').fadeOut();
			$('#qa_pcb_no').focus();
			radioState = "radioPass";
			$('#qaFailComment').val('');
			$('#qaFailCommentRow').fadeOut();
		});

		$('#qaFailReason').on('change', function() {
			if($('#qaFailReason').val() == 100 || $('#qaFailReason').val() == 50) {
				// show comment textbox
				$('#qaFailCommentRow').fadeIn();
			}
			else {
				$('#qaFailCommentRow').fadeOut();
			}
		});

		var timeOutLock = false;
		$('#soldering_pcb_no').bind('keyup',function(e){
			if(($(this).val().length > 4) && !timeOutLock){
				setTimeout(function(){
					$('#solderingSubmitButton').trigger("click");
				}, 500);
				timeOutLock = true;
			}
		});

		var lotTimeOutLock = false;
		$('#lotScanPcb').bind('keyup',function(e){
			if(($(this).val().length > 4) && !lotTimeOutLock){
				setTimeout(function(){
					$('#lotManualButton').trigger("click");
				}, 500);
				lotTimeOutLock = true;
			}
		});

		$('#solderingSubmitButton').click(function(){
			timeOutLock = false;
			if (($('#soldering_pcb_no').val().length == 0) && ($('#soldering_pcb_no_manual').val().length == 0)) {
				Materialize.toast("PCB number should not kept blank",3000,'rounded');
			}
			else {
				$.ajax({
					url: 'submit_soldering.php',
					type: 'POST',
					data: {
						soldering_pcb_no: ($('#soldering_pcb_no').val().length == 0) ? $('#soldering_pcb_no_manual').val() : $('#soldering_pcb_no').val()
					},
					success: function(msg) {
						document.getElementById('solderingNo').textContent = ($('#soldering_pcb_no').val().length == 0) ? $('#soldering_pcb_no_manual').val() : $('#soldering_pcb_no').val();
						console.log(msg);
						if(msg.toLowerCase().includes("undefined")){
							document.getElementById('solderingRes').textContent = "Failed to find resistor for scanned PCB No.";
							$('#soldering_pcb_no').focus();
						}
						else{
							msg = msg.replace(($('#soldering_pcb_no').val().length == 0) ? $('#soldering_pcb_no_manual').val() : $('#soldering_pcb_no').val(),"");
							if(msg == "0") {
								document.getElementById('solderingRes').textContent = "No need to change resistor."
							}
							else {
								document.getElementById('solderingRes').textContent = msg + " K\u2126";
							}
						}
						$('#solderingRes').fadeIn();
						$('#solderingNo').fadeIn()
						setTimeout(function(){ 
							$('#soldering_pcb_no').val('');
							$('#soldering_pcb_no_manual').val('');
							$('#soldering_pcb_no').focus();
						}, 2000
						);
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + "\n\nIs web-server offline?");
					}
				});
			}
		});

		$('#solderingClearButton').click(function(){
			$('#soldering_pcb_no').val('');
			$('#soldering_pcb_no_manual').val('');
			$('#soldering_pcb_no').focus();
			$('#solderingRes').fadeOut();
			$('#solderingNo').fadeOut()
		});

		$('#lotManualButton').click(function(){
			lotTimeOutLock = false;
			if (($('#mainLotNoText').val().length == 0) || ($('#kitLotNoText').val().length == 0) || ($('#lotFuzeType').val() == '') || ($('#lotSize').val() == '') || (($('#lotScanPcb').val().length == 0) && ($('#lotManualPcb').val().length == 0))){
				Materialize.toast("Can't save with blank fields.",4000,'rounded');
				Materialize.toast("Check what you have missed.",4000,'rounded');
				$('#lotScanPcb').val('');
			}
			else{
				$.ajax({
					url: 'lot.php',
					type: 'POST',
					data: {
						pcb_no: ($('#lotScanPcb').val().length == 0 ? $('#lotManualPcb').val() : $('#lotScanPcb').val()),
						fuze: $.cookie('fuzeType'),		//$('#lotFuzeType :selected').val(),	--- CHANGED ---
						size: "60",										//$('#lotSize :selected').val(),			--- CHANGED ---
						main_lot: $('#mainLotNoText').val(),
						kit_lot: $('#kitLotNoText').val(),
						fuze_diameter: $.cookie('fuzeDia'),
						task: 'add'
					},
					success: function(msg) {
						document.getElementById('lotEntryTable').innerHTML = msg;
						console.log(msg);
						if(msg.includes('</table>')){
							Materialize.toast('Record created',1500,'rounded');
							var cnt = occurrences(msg,"</tr>").toString();
							//document.getElementById('lotRecordCountTitle').innerHTML = cnt + "/" + $('#lotSize :selected').val() + " Records found in this Kit Lot";  --- CHANGED ---
							document.getElementById('lotRecordCountTitle').innerHTML = cnt + "/60 Records found in this Kit Lot";
							setTimeout(function(){
								$('#lotScanPcb').val('');
								$('#lotManualPcb').val('');
							},1000);
						}
						else if(msg.toLowerCase().includes('already')) {
							Materialize.toast('Record already exists!',3000,'rounded');
							$('#lotScanPcb').val('');
						}
						else if(msg.toLowerCase().includes('failed housing')) {
							Materialize.toast('Can not add!',3000,'rounded');
							$('#lotScanPcb').val('');
						}
						else{
							Materialize.toast('Failed to save record!',3000,'rounded');
							Materialize.toast('Database server is offline!',3000,'rounded');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + 'Is web-server offline?');
					}
				});
			}
		});

		$('#kitLotNoText').bind('keyup',function(e){
			viewLot();
		});

		$('#lotViewButton').click(function(){
			viewLot();
		});

		function viewLot(){
			if (($('#mainLotNoText').val().length == 0) || ($('#lotFuzeType').val() == '') || ($('#lotSize').val() == '')){
				Materialize.toast("Insufficient data to search.",4000,'rounded');
			}
			else{
				$.ajax({
					url: 'lot.php',
					type: 'POST',
					data: {
						pcb_no: ($('#lotScanPcb').val().length == 0 ? $('#lotManualPcb').val() : $('#lotScanPcb').val()),
						fuze: $.cookie('fuzeType'),		//$('#lotFuzeType :selected').val(),	--- CHANGED ---
						size: "60",										//$('#lotSize :selected').val(),			--- CHANGED ---
						main_lot: $('#mainLotNoText').val(),
						kit_lot: $('#kitLotNoText').val(),
						fuze_diameter: $.cookie('fuzeDia'),
						task: 'view'
					},
					success: function(msg) {
						document.getElementById('lotEntryTable').innerHTML = msg;
						if(msg.includes('</table>')){
							var cnt = occurrences(msg,"</tr>").toString();
							console.log(cnt);
							//document.getElementById('lotRecordCountTitle').innerHTML = cnt + "/" + $('#lotSize :selected').val() + " Records found in this Kit Lot"; --- CHANGED ---
							document.getElementById('lotRecordCountTitle').innerHTML = cnt + "/60 Records found in this Kit Lot";
						}
						else{
							Materialize.toast('Failed to save record!',3000,'rounded');
							Materialize.toast('Database server is offline!',3000,'rounded');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + 'Is web-server offline?');
					}
				});
			}
		}

		var manualTestingData = new Array();
		$('#pcbTestingManualSubmitButton').click(function(){
			manualTestingData = new Array();
			var isEmpty = false;
			var ajaxMainLotNo = 0;
			var ajaxKitLotNo = "HSG";
			if($.cookie('fuzeStart') == "8") {
				$('#pcbTestingManualCard input[type="text"]').each(function(){
					if($(this).val() == "") {
						isEmpty = true;
					}
					if($(this).attr('id') != "pcbTestingManualRecordDate") {	// field name remains same - DOM manipulted
						if($(this).attr('id') == "pcbTestingManualPcbNo") {
							manualTestingData.push($(this).val().substring(0,12));
						}
						else {
							manualTestingData.push($(this).val());
						}
					}
				});
				if($('#pcbTestingManualRecordDate').val() == "") {
					isEmpty = true;
				}
			}
			else if($.cookie('fuzeStart') == "10") {
				$('#HousingTestingManualCard input[type="text"]').each(function(){
					if($(this).val() == "" && $(this).attr('id') != "PcbTestingDetailsBpfNoiseAc" && $(this).attr('id') != "PcbTestingDetailsBpfNoiseDc") {
						isEmpty = true;
					}
					if($(this).attr('id') != "pcbTestingManualRecordDate") {		// field name remains same - DOM manipulted
						if($(this).attr('id') == "pcbTestingManualPcbNo") {
							manualTestingData.push($(this).val().substring(0,12));
						}
						else {
							manualTestingData.push($(this).val());
						}
					}
				});
				if($('#pcbTestingManualRecordDate').val() == "") {
					isEmpty = true;
				}
				ajaxMainLotNo = $('#pcbTestingManualMainLot').val();
				ajaxKitLotNo = $('#pcbTestingManualKitLot').val();
			}
			else if($.cookie('fuzeStart') == "12") {
				$('#PottingTestingManualCard input[type="text"]').each(function(){
					console.log(this);
					if($(this).val() == "" && $(this).attr('id') != "PcbTestingDetailsBpfNoiseAc" && $(this).attr('id') != "PcbTestingDetailsBpfNoiseDc") {
						isEmpty = true;
					}
					if($(this).attr('id') != "pcbTestingManualRecordDate") {		// field name remains same - DOM manipulted
						if($(this).attr('id') == "pcbTestingManualPcbNo") {
							manualTestingData.push($(this).val().substring(0,12));
						}
						else {
							manualTestingData.push($(this).val());
						}
					}
				});
				if($('#pcbTestingManualRecordDate').val() == "") {
					isEmpty = true;
				}
			}
			
			if(isEmpty) { /////////////////////////// CHANGE ! LATER - DONE ////////////////////////////////////////
				Materialize.toast("Please fill up all fields.",3000,'rounded');
			}
			else {
				// ajax stuff here
				var phpUrl = "";
				if($.cookie('fuzeStart') == "8") {
					phpUrl = 'pcb_testing_manual_upload.php';
				}
				else if($.cookie('fuzeStart') == "10") {
					phpUrl = 'housing_testing_manual_upload.php';
				}
				else if($.cookie('fuzeStart') == "12") {
					phpUrl = 'potting_testing_manual_upload.php';
				}

				$.ajax({
					url: phpUrl,
					type: 'POST',
					data: {
						jsonData: JSON.stringify(manualTestingData),
						record_date: $('#pcbTestingManualRecordDate').val(),
						main_lot: ajaxMainLotNo,
						kit_lot: ajaxKitLotNo
					},
					success: function(msg) {
						console.log(manualTestingData);
						console.log(msg);
						if(msg.includes("ok")) {
							Materialize.toast('Record saved',2000,'rounded');
							$('#pcbTestingManualClearButton').trigger('click');
						}
						else if(msg.includes("lot_overflow")) {
							Materialize.toast('Lot Overflow!',2000,'rounded');
							alert("*** Kit Lot already full! ***\n\nCan't enter more than 60 units in the same kit lot!\nPlease change the kit lot number!");
						}
						else {
							console.log(msg);
							Materialize.toast('Failed to save the record!',2000,'rounded');
							Materialize.toast('Server says - ' + msg,2000,'rounded');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + "\n\nIs web-server offline?");
					}
				});
			}
		});

		$('#pcbTestingManualClearButton').click(function(){
			$('input[type="text"]').each(function(){
				if($(this).attr('id') != "pcbTestingManualOperatorName" && $(this).attr('id') != "pcbTestingManualRecordDate" && $(this).attr('id') != "pcbTestingManualMainLot" && $(this).attr('id') != "pcbTestingManualKitLot") {
					$(this).val('');
				}
			});
			$('#pcbTestingManualSafe').val('PASS');
			$('#pcbTestingManualResult').val('PASS');
			$('#safePass').prop('checked',true);
			$('#resultPass').prop('checked',true);
			$('#pcbTestingManualPcbNo').focus();
		});

		function occurrences(string, subString, allowOverlapping) {
			string += "";
			subString += "";
			if (subString.length <= 0) return (string.length + 1);

			var n = 0,
					pos = 0,
					step = allowOverlapping ? 1 : subString.length;

			while (true) {
					pos = string.indexOf(subString, pos);
					if (pos >= 0) {
							++n;
							pos += step;
					} else break;
			}
			return n;
		}

		function getTodaysDate() {
			var date = new Date($.cookie("currentDate"));
			locale = "en-us";
			dateString = date.getDate().toString() + " " + date.toLocaleString(locale, { month: "long" }) + ", " + date.getFullYear();
			return dateString;
		}

		$('.datepicker').pickadate({
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15, // Creates a dropdown of 15 years to control year,
			today: 'Today',
			clear: 'Clear',
			close: 'Ok',
			closeOnSelect: false // Close upon selecting a date,
		});

	</script>

</html>

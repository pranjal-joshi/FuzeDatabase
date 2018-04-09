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
		<link rel="stylesheet" type="text/css" href="materialize.min.css">
		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="materialize.min.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>

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
							<center>&copy; Bharat Electronics Ltd. (2018), All rights reserved.</center>
						</div>
					</div>
				</footer>
				</body>
				");
		}
	?>

	<body class="indexBody">

		<main class="contents">
			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper teal lighten-2" id="loginNav">
						<a href="#!" class="brand-logo center" id="loginNavTitle">Fuze Database Home-page</a>

						<a class='dropdown-button' href='#' data-activates='dropdownMenu'>
							<span class='white-text text-darken-5' style="font-size: 20px; padding-left: 20px; font-weight: bold">Menu</span>
						</a>

						<a class='dropdown-button right' href='#' data-activates='dropdownMenu' onclick="logout();">
							<span class='white-text text-darken-5' style="font-size: 16px; padding-right: 20px; font-weight: bold">Logout</span>
						</a>

						<ul id='dropdownMenu' class='dropdown-content'>
							<li><a class="waves-effect waves-light modal-trigger" href="#searchModal">Search</a></li>
							<li class="divider"></li>
							<li><a href="rejection.php" target="_blank">Rejection</a></li>
							<li class="divider"></li>
							<?php
								//if($_COOKIE["fuzeAccess"] == "edit"){
								if($_COOKIE["fuzeAccess"] == "DE95B43BCEEB4B998AED4AED5CEF1AE7"){
									echo "<li><a href='solution.php' target='_blank'>Solutions</a></li>";
								}
								else {
									echo "<li><a class='grey-text' id='solutionLink'>Solutions</a></li>";
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
									echo "<li><a href='analytics.php' target='_blank'>Analytics</a></li>";
								}
								else {
									echo "<li><a class='grey-text' id='analyticsLink'>Analytics</a></li>";
									echo "<script>
													$('#analyticsLink').click(function(){
														alert('Sorry! You dont have access to this feature.');
													});
												</script>";
								}
							?>
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
							
							<div class="row" id="searchSelect" style="min-height: 300px;">
								<div class="input-field col s3">
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
									</select>
									<label>Search by</label>
								</div>

								<div class="row" id="searchTableSelect">
									<div class="input-field col s2">
										<select name="searchTableSelect" id="searchTableSelect">
											<option value="1" selected>After PU</option>
											<option value="2">Calibration</option>
											<option value="3">QA</option>
											<option value="4">PCB Testing</option>
											<option value="5">Housing Testing</option>
											<option value="6">Potted Housing</option>
											<option value="7">Electronic Head</option>
										</select>
										<label>Search In</label>
									</div>

								<div class="input-field col s5">
									<input type="text" name="search_box" id="search_box" autofocus class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='For partial search, use wildcard (%__%) like %234%'>
									<label for="search_box">What to search?</label>
								</div>

								<br>
								<a class="btn col s2" href="#" id="searchButton" name="searchButton">SEARCH</a>

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

			<div class="row">
				<div class="col m2"></div>
				<div class="col m8 s12">

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
										<input id="before_freq" name="before_freq" type="text">
										<label for="before_freq"><center>Before Calibration - Freq (MHz)</center></label>
									</div>
									<div class="input-field col s6">
										<input id="before_bpf" name="before_bpf" type="text">
										<label for="before_bpf"><center>Before Calibration - BPF AC (V)</center></label>
									</div>
								</div>

								<div class="row">
									<center>
									<div class="col s6">
										<span class="black-text">Calibration resistor changed?</span>
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
										<input type="text" name="after_freq" id="after_freq" disabled>
										<label for="after_freq"><center>After Calibration - Freq (MHz)</center></label>
									</div>
									<div class="input-field col s5">
										<input type="text" name="after_bpf" id="after_bpf" disabled>
										<label for="after_bpf"><center>After Calibration - BPF AC (V)</center></label>
									</div>
								</div>

								<div class="row">
									<center>
										<span style="font-weight: bold; font-size: 16px" class="teal-text text-darken-2">Additional Information</span>
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
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Enter QA Details</span>
							</center>

							<form class="col s12" method="post" id="qaForm">
								<div class="row">

									<div class="row">
										<div class="input-field col s12">
											<input id="qa_pcb_no" name="qa_pcb_no" type="text" required autofocus>
											<label for="wa_pcb_no"><center>PCB Number</center></label>
										</div>
									</div>

									<div class="row">
										<center>
										<div class="col s6">
											<span class="black-text">QA / Visual inspection results :</span>
										</div>
										<div class="col s6">
											<input type="radio" name="qaGroup" class="with-gap" id="radioPass" name="radioPass" value="1" onchange="onQaRadioChange()" checked>
											<label for="radioPass">PASS</label>
											<input type="radio" name="qaGroup" class="with-gap" id="radioFail" name="radioFail" value="0" onchange="onQaRadioChange()">
											<label for="radioFail">FAIL</label>
										</div>
										</center>
									</div>

									<div class="row" style="display: none;" id="qaFailRow">
										<div class="input-field col s12">
											<select name="qaFailReason" id="qaFailReason">
												<option value="" disabled selected>Select reason for rejection</option>
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
												<option value="100">100 - MULTIPLE FAULTS</option>
											</select>
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
									<div class="input-field col s2">
										<select name="lotFuzeType" id="lotFuzeType" required>
											<option value="" disabled selected>-- Please select --</option>
											<option value="EPD">EPD</option>
											<option value="TIME">TIME</option>
											<option value="PROX">PROX</option>
										</select>
										<label>Select Fuze Type</label>
									</div>
									<div class="input-field col s2">
										<select name="lotSize" id="lotSize" required>
											<option value="" disabled selected>-- Please select --</option>
											<option value="30">30</option>
											<option value="60">60</option>
										</select>
										<label>Select Kit-Lot size</label>
									</div>
									<div class="input-field col s3">
										<input id="mainLotNoText" name="mainLotNoText" type="text">
										<label for="mainLotNoText"><center>Enter Main Lot Number</center></label>
									</div>
									<div class="input-field col s3">
										<input id="kitLotNoText" name="kitLotNoText" type="text">
										<label for="kitLotNoText"><center>Enter Kit Lot Number</center></label>
									</div>
									<br>
									<a class="btn waves-effect waves-light col s2 center" id='lotViewButton'>VIEW LOT</a>
								</div>

								<div class="row">
									<div class="input-field col s4">
										<input id="lotScanPcb" name="lotScanPcb" type="text" autofocus>
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
									<a href="LogToExcel.exe">Download Log to Excel converter application</a>
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
										<td class='center'><span class='center'>PCB Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Current (I) <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualCurrent' data-position='bottom' data-delay='500' data-tooltip='7 to 14 mA' class='tooltipped'>
												</div>
											</td>
											<td class='center'><span class='center'>Supply Voltage (VEE) <span></td>
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
											<td class='center'><span class='center'>VBAT-PST Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVbatPst' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='600 to 700 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualPstAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='12 to 21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>PST Width <span></td>
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
											<td class='center'><span class='center'>Frequency <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualFreq' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='46 to 55 KHz'>
												</div>
											</td>
											<td class='center'><span class='center'>DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualModDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='7 to 8.1 V'>
												</div>
											</td>
											<td class='center'><span class='center'>AC <span></td>
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
											<td class='center'><span class='center'>VRF Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVrfAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='15.3 to 16.7 V'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-VRF Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVbatVrf' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.08 to 2.30 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-Cap Charge T <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualCapCharge' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='695 to 730 mS'>
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
													<input type='text' id='pcbTestingManualDetWidth' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='30 to 120 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualDetAmpl' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='-12 to -21 V'>
												</div>
											</td>
											<td class='center'><span class='center'>Cycles <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualCycles' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='4 to 6'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF DC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualBpfDC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='5.2 to 6.4 V'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF AC <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualBpfAC' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.5 to 3.6 V'>
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
													<input type='text' id='pcbTestingManualSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='480 to 650 mS'>
												</div>
											</td>
											<td class='center'><span class='center'>VBAT-SIL Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualVbatSil' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='2.7 to 3.2 Sec'>
												</div>
											</td>
											<td class='center'><span class='center'>LVP <span></td>
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

											<td class='center'><span class='center'>Delay <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualPDDelay' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='0 to 10 uS'>
												</div>
											</td>
											<td class='center'><span class='center'>DET Ampl <span></td>
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

											<td class='center'><span class='center'>SAFE Test <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualSafe' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='PASS or FAIL'>
												</div>
											</td>
											<td class='center'><span class='center'>Result <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='pcbTestingManualResult' class='tooltipped' data-position='bottom' data-delay='500' data-tooltip='PASS or FAIL'>
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

									</tbody>
								</table>

								<center>
									<a class='btn waves-light waves-effect' id='pcbTestingManualSubmitButton'>SUBMIT</a>
									<a class='btn red waves-effect' id='pcbTestingManualClearButton'>CLEAR</a>
								</center>

							</form>
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
				<center>&copy; Bharat Electronics Ltd. (2018), All rights reserved.</center>
			</div>
		</div>
	</footer>

	</body>

	<script type="text/javascript">

		var isBound = false;
		$('.modal-trigger').leanModal({
					dismissible: true, // Modal can be dismissed by clicking outside of the modal
					opacity: .5, // Opacity of modal background
					inDuration: 300, // Transition in duration
					outDuration: 200, // Transition out duration
					startingTop: '4%', // Starting top style attribute
					endingTop: '10%', // Ending top style attribute
					ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
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
								document.getElementById('searchDynamicTable').innerHTML = "";
								$('#searchPreloader').fadeIn();
								var text = $('#search_box').val();
								var select = $('#searchSelect :selected').val();
								var tableSelect = $('#searchTableSelect :selected').val();
								if(text === ""){
									Materialize.toast("Search box can't be kept blank",2500,'rounded');
									$('#search_box').focus();
									return false;
								}
								else if(text === "%" || text.includes("%%")) {
									Materialize.toast("Wildcard search is not allowed here!",2500,'rounded');
									$('#search_box').focus();
									$('#searchPreloader').fadeOut();
									return false;
								}
								$.ajax({
									url : 'search.php',
									type: 'post',
									data: {
										query: text,
										select: select,
										tableSelect: tableSelect
									},
									success: function(msg) {
										$('#searchPreloader').fadeOut();
										document.getElementById('searchDynamicTable').innerHTML = msg;
									},
									error: function(XMLHttpRequest, textStatus, errorThrown) {
										 alert(errorThrown + "\n\nDatabase server offline?");
									}
								});
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

		switch($.cookie('fuzeDia')){
			case '105':
				document.getElementById('loginNavTitle').innerHTML = "105 mm " + $.cookie('fuzeType') + " Fuze Database";
				break;
			case '155':
				document.getElementById('loginNavTitle').innerHTML = "155 mm "+ $.cookie('fuzeType') +" Fuze Database";
				break;
		}

		var validationArray = new Array();

		if($.cookie('fuzeType') == "PROX") {
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
					if(key == 27)  // the enter key code
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
					if(key == 27)  // the enter key code
					{
						$('#clearButton').trigger('click');
						return false;  
					}
				});
				$('#datePicker').val(getTodaysDate());
				break;
			case '4':
				$('#afterPUCard').fadeIn();
				break;
			case '5':
				$('#reworkCard').fadeIn();
				break;
			case '6':
				$('#solderingCard').fadeIn();
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
					if(key == 27)  // the enter key code
					{
						$('#pcbTestingManualClearButton').trigger('click');
						return false;  
					}
				});
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
					if(key == 27)  // the enter key code
					{
						$('#pcbTestingManualClearButton').trigger('click');
						return false;  
					}
				});
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
					if(key == 27)  // the enter key code
					{
						$('#pcbTestingManualClearButton').trigger('click');
						return false;  
					}
				});
				break;
			}
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
				document.getElementById("after_freq").disabled = false;
				document.getElementById("after_bpf").disabled = false;
			}
			else{
				document.getElementById("resChange").disabled = true;
				document.getElementById("after_freq").disabled = true;
				document.getElementById("after_bpf").disabled = true;
			}
		}

		var radioState = "radioPass";
		function onQaRadioChange() {
			radioState = $('input[name=qaGroup]:checked').attr('id');
			if(radioState === "radioPass"){
				$('#qaFailRow').fadeOut(function(onComplete){
					$('select').material_select('destroy');
				});
			}
			else {
				$('select').material_select();
				$('#qaFailRow').fadeIn();
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
			document.getElementById("after_freq").disabled = true;
			document.getElementById("after_bpf").disabled = true;
			$('#pcb_no').focus();
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
					op_name: $('#op_name').val().toUpperCase()
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
						document.getElementById("after_freq").disabled = true;
						document.getElementById("after_bpf").disabled = true;
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
					 alert(errorThrown + "\n\nDatabase server offline?");
				}
			});
			}
		});

		$('#qaSubmitButton').click(function(){
			if (($('#qa_pcb_no').val().length == 0) || ($('#qa_op_name').val().length == 0) || ($('#qaDatePicker').val().length == 0)){
				Materialize.toast("Can't save with blank fields.",4000,'rounded');
				Materialize.toast("Check what you have missed.",4000,'rounded');
			}
			else {
				$.ajax({
					url: 'submit_qa.php',
					type: 'POST',
					data: {
						qa_pcb_no: $('#qa_pcb_no').val(),
						result: ((radioState == "radioPass") ? '1' : '0'),
						reason: $('#qaFailReason').val(),
						qaDatePicker: $('#qaDatePicker').val(),
						qa_op_name: $('#qa_op_name').val().toUpperCase()
					},
					success: function(msg) {
						if(msg.includes("ok")){
							Materialize.toast("Record Saved",1000,'rounded');
							$('#qa_pcb_no').val('');
							$('#radioPass').prop('checked',true);
							$('#qaFailReason').val('');
							$('#qaFailRow').fadeOut();
							$('#qa_pcb_no').focus();
							radioState = "radioPass";
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
						 alert(errorThrown + "\n\nDatabase server offline?");
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
						 alert(errorThrown + "\n\nDatabase server offline?");
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
						fuze: $('#lotFuzeType :selected').val(),
						size: $('#lotSize :selected').val(),
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
							document.getElementById('lotRecordCountTitle').innerHTML = cnt + "/" + $('#lotSize :selected').val() + " Records found in this Kit Lot";
							setTimeout(function(){
								$('#lotScanPcb').val('');
								$('#lotManualPcb').val('');
							},1000);
						}
						else if(msg.toLowerCase().includes('already')) {
							Materialize.toast('Record already exists!',3000,'rounded');
							$('#lotScanPcb').val('');
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
						fuze: $('#lotFuzeType :selected').val(),
						size: $('#lotSize :selected').val(),
						main_lot: $('#mainLotNoText').val(),
						kit_lot: $('#kitLotNoText').val(),
						task: 'view'
					},
					success: function(msg) {
						document.getElementById('lotEntryTable').innerHTML = msg;
						if(msg.includes('</table>')){
							var cnt = occurrences(msg,"</tr>").toString();
							console.log(cnt);
							document.getElementById('lotRecordCountTitle').innerHTML = cnt + "/" + $('#lotSize :selected').val() + " Records found in this Kit Lot";
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
			}
		}

		var manualTestingData = new Array();
		$('#pcbTestingManualSubmitButton').click(function(){
			manualTestingData = new Array();
			var isEmpty = false;
			if($.cookie('fuzeStart') == "8") {
				$('#pcbTestingManualCard input[type="text"]').each(function(){
					if($(this).val() == "") {
						isEmpty = true;
					}
					if($(this).attr('id') != "pcbTestingManualRecordDate") {	// field name remains same - DOM manipulted
						manualTestingData.push($(this).val());
					}
				});
				if($('#pcbTestingManualRecordDate').val() == "") {
					isEmpty = true;
				}
			}
			else if($.cookie('fuzeStart') == "10") {
				$('#HousingTestingManualCard input[type="text"]').each(function(){
					if($(this).val() == "") {
						isEmpty = true;
					}
					if($(this).attr('id') != "pcbTestingManualRecordDate") {		// field name remains same - DOM manipulted
						manualTestingData.push($(this).val());
					}
				});
				if($('#pcbTestingManualRecordDate').val() == "") {
					isEmpty = true;
				}
			}
			else if($.cookie('fuzeStart') == "12") {
				$('#PottingTestingManualCard input[type="text"]').each(function(){
					if($(this).val() == "") {
						isEmpty = true;
					}
					if($(this).attr('id') != "pcbTestingManualRecordDate") {		// field name remains same - DOM manipulted
						manualTestingData.push($(this).val());
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
						record_date: $('#pcbTestingManualRecordDate').val()
					},
					success: function(msg) {
						console.log(manualTestingData);
						console.log(msg);
						if(msg.includes("ok")) {
							Materialize.toast('Record saved',2000,'rounded');
							$('#pcbTestingManualClearButton').trigger('click');
						}
						else {
							Materialize.toast('Failed to save the record!',2000,'rounded');
							Materialize.toast('Server says - ' + msg,2000,'rounded');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + "\n\nDatabase server offline?");
					}
				});
			}
		});

		$('#pcbTestingManualClearButton').click(function(){
			$('input[type="text"]').each(function(){
				if($(this).attr('id') != "pcbTestingManualOperatorName" || $(this).attr('id') != "pcbTestingManualRecordDate") {
					$(this).val('');
				}
			});
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
			var date = new Date();
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

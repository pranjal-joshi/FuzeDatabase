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
						<a href="#!" class="brand-logo center">Fuze Database Home-page</a>

						<a class='dropdown-button' href='#' data-activates='dropdownMenu'>
							<span class='white-text text-darken-5' style="font-size: 20px; padding-left: 20px; font-weight: bold">Menu</span>
						</a>

						<a class='dropdown-button right' href='#' data-activates='dropdownMenu' onclick="logout();">
							<span class='white-text text-darken-5' style="font-size: 16px; padding-right: 20px; font-weight: bold">Logout</span>
						</a>

						<ul id='dropdownMenu' class='dropdown-content'>
							<li><a class="waves-effect waves-light modal-trigger" href="#searchModal">Search</a></li>
							<li class="divider"></li>
							<li><a href="#!">Edit</a></li>
							<li class="divider"></li>
							<li><a href="#!">Modify</a></li>
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
										</select>
										<label>Search In</label>
									</div>

								<div class="input-field col s5">
									<input type="text" name="search_box" id="search_box" autofocus>
									<label for="search_box">What to search?</label>
								</div>

								<br>
								<a class="btn col s2" href="#" id="searchButton" name="searchButton">SEARCH</a>

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
												<option value="29">29 - Solder pan on PCB damaged / removed</option>
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
								var text = $('#search_box').val();
								var select = $('#searchSelect :selected').val();
								var tableSelect = $('#searchTableSelect :selected').val();
								if(text === ""){
									Materialize.toast("Search box can't be kept blank",2500,'rounded');
									$('#search_box').focus();
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

		$(".button-collapse").sideNav({
			menuWidth: 130,
			edge: 'left',
			closeOnClick: false,
			draggable: true
		});

		$('.datepicker').pickadate({
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15, // Creates a dropdown of 15 years to control year,
			today: 'Today',
			clear: 'Clear',
			close: 'Ok',
			closeOnSelect: false // Close upon selecting a date,
		});

		switch($.cookie('fuzeStart')){
			case '1':
				$('select').material_select();
				$('#qaCard').fadeIn();
				break;
			case '2':
				$('#pcbTestingCard').fadeIn();
				break;
			case '3':
				$('#calibrationCard').fadeIn();
				break;
			case '4':
				$('#afterPUCard').fadeIn();
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
						task: 'add'
					},
					success: function(msg) {
						document.getElementById('lotEntryTable').innerHTML = msg;
						console.log(msg);
						if(msg.includes('</table>')){
							Materialize.toast('Record created',1500,'rounded');
							var cnt = occurrences(msg,"</tr>").toString();
							document.getElementById('lotRecordCountTitle').innerHTML = cnt.concat(' Records found in this Kit Lot');
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
							document.getElementById('lotRecordCountTitle').innerHTML = cnt.concat(' Records found in this Kit Lot');
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
	</script>

</html>

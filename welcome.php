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
						<a href="#!" class="brand-logo center">Proxmity Fuze Database Home-page</a>

						<a class='dropdown-button' href='#' data-activates='dropdownMenu'>
							<span class='white-text text-darken-5' style="font-size: 20px; padding-left: 20px; font-weight: bold">Menu</span>
						</a>

						<a class='dropdown-button right' href='#' data-activates='dropdownMenu' onclick="logout();">
							<span class='white-text text-darken-5' style="font-size: 16px; padding-right: 20px; font-weight: bold">Logout</span>
						</a>

						<ul id='dropdownMenu' class='dropdown-content'>
							<li><a href="#!">Add</a></li>
							<li class="divider"></li>
							<li><a href="#!">Edit</a></li>
							<li class="divider"></li>
							<li><a href="#!">Modify</a></li>
						</ul>
	
					</div>

				</nav>
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
										<input id="before_bpf" name="before_bpf" type="text" required>
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
											<span class="black-text">QA/Visual inspection results :</span>
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
												<option value="0">0 - MULTIPLE FAULTS</option>
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
			case '3':
				$('#calibrationCard').fadeIn();
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
			if(($('#pcb_no').val().length == 0) || ($('#rf_no').val().length == 0) || ($('#before_freq').val().length == 0) || ($('#before_bpf').val().length == 0) || ($('#datePicker').val().length == 0) || ($('#op_name').val().length == 0))
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
							$('#qaFailRow').val('');
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
			$('#qaFailRow').val('');
			$('#qaFailRow').fadeOut();
			$('#qa_pcb_no').focus();
			radioState = "radioPass";
		});
	</script>

</html>

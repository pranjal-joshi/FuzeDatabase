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
					<div class="card-panel grey lighten-4" id="calibrationCard">
						<div class="row">

							<center>
								<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Enter Calibration Details</span>
							</center>

							<form class="col s12" method="post" id="calibrationForm">
								<div class="row">
									<div class="input-field col s6">
										<input id="pcb_no" name="pcb_no" type="text">
										<label for="pcb_no"><center>PCB Number</center></label>
									</div>
									<div class="input-field col s6">
										<input id="rf_no" name="rf_no" type="text">
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
										<input type="text" name="datePicker" id="datePicker" class="datepicker">
										<label for="datePicker"><center>Record date</center></label>
									</div>
									<div class="input-field col s6">
										<input type="text" name="op_name" id="op_name">
										<label for="op_name"><center>Operator's Name</center></label>
									</div>
								</div>

								<center>
									<!--<button class="waves-effect waves-light btn" type="submit" id="submitButton">SUBMIT</button>-->
									<a class="waves-effect waves-light btn" id="submitButton">SUBMIT</a>
									<a class="btn waves-effect waves-red red lighten-2" id="clearButton">CLEAR</a>
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
					op_name: $('#op_name').val()
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
	</script>

</html>

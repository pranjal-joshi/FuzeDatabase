<?php
	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$table_name = "pcb_testing";

		if($_POST['type'] == 'reject') {

			switch ($_POST['stage']) {
				case 'Q/A':
					$table_name = "qa_table";
					break;
				case 'PCB':
					$table_name = "pcb_testing";
					break;
				case 'HOUSING':
					$table_name = "housing_table";
					break;
				case 'POTTING':
					$table_name = "potting_table";
					break;
				case 'PU POTTING':
					$table_name = "calibration_table";
					break;
				case 'ELECTRONIC HEAD':
					$table_name = "after_pu";
					break;
			}

			$checkSql = "SELECT * FROM `lot_table` WHERE `pcb_no`='".$_POST['pcb_no']."' AND `fuze_type`='".$_POST['fuze']."' AND `fuze_diameter`='".$_POST['diameter']."'";
			$checkRes = mysqli_query($db, $checkSql);

			if($checkRes->num_rows < 1) {
				die("no record found!");
			}

			$sql = "UPDATE `lot_table` SET `rejected`='1',
			`rejection_stage`='".$_POST['stage']."',
			`rejection_remark`='".$_POST['remark']."' 
			WHERE `pcb_no`='".$_POST['pcb_no']."' AND `fuze_type` = '".$_POST['fuze']."' AND `fuze_diameter` = '".$_POST['diameter']."'";

			$result = mysqli_query($db, $sql);

			if($result){
				die("ok");
			}
		}
		elseif ($_POST['type'] == 'accept') {
			$sql = "UPDATE `lot_table` SET `rejected`='0', `acception_remark`='".$_POST['remark']."'
			WHERE `pcb_no`='".$_POST['pcb_no']."' AND `fuze_type` = '".$_POST['fuze']."' AND `fuze_diameter` = '".$_POST['diameter']."'";

			//print_r($sql);

			$result = mysqli_query($db, $sql);

			// remove qa fail data unconditionally
			$qaSql = "UPDATE `qa_table` SET `result`='1', `comment`='', reason='0' WHERE `pcb_no`='".$_POST['pcb_no']."'";
			$qaRes = mysqli_query($db, $qaSql);
			print_r($qaSql);

			if($result){
				die("ok");
			}
		}
	}
	else {
		if(!isset($_COOKIE["fuzeLogin"])) {
			die("
				<!DOCTYPE html>
			<html>

			<style type='text/css'>
					.analyticsBody {
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
				<link rel='stylesheet' type='text/css' href='materialize.min.css'>
				<script type='text/javascript' src='jquery.min.js'></script>
				<script type='text/javascript' src='materialize.min.js'></script>
				<script type='text/javascript' src='jquery.cookie.js'></script>
				<script src='canvasjs-2.0.1/canvasjs.min.js'></script>

				<!-- Set responsive viewport -->
				<meta name='viewport' content='width=device-width, initial-scale=1.0'/>

				<!-- Disable caching of browser -->
				<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
				<meta http-equiv='Pragma' content='no-cache' />
				<meta http-equiv='Expires' content='0' />

				<title>Fuze-Analytics</title>
			</head>

			<body class='analyticsBody'>
				<main class='contents'>

				<nav>
					<div class='nav-wrapper red lighten-2' id='analyticsNav'>
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
										<a href='index.php'>Go Back</a>
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
				</html>
			");
		}
	}
?>

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
		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="materialize.min.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>

		<!-- Set responsive viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- Disable caching of browser -->
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />

		<title>Fuze-Rejection</title>

	</head>

	<body class="indexBody">

		<main class="contents">

		<div class="navbar-fixed">
			<nav>
				<div class="nav-wrapper teal lighten-2">
					<a href="#!" class="brand-logo center" id="loginNavTitle">Fuze - Rejection Control</a>

					<a><span class='white-text text-darken-5 left' style='font-size: 18px; padding-left: 20px; font-weight: bold' onclick='self.close();'>Back</span></a>
				</div>
			</nav>
		</div>

		<!--<div class="row">
			<div class="col m2"></div>
				<div class="col s12 m8">
					<br>
					<br>
					<div class="card-panel grey lighten-4" id="rejectionCard">
						<br>

						<center>
							<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Add to Rejection / Edit Rejection</span>
							<p class="red-text text-lighten-1" style="font-size: 12px;">Fields indicated by (*) are mandatory.</p>
							<br>
						</center>

						<div class="row">
							<div class="input-field col s2">
								<select name="rejection_fuze_type" id="rejection_fuze_type" required>
									<option value="" disabled selected>--Select--</option>
									<option value="EPD">EPD</option>
									<option value="TIME">TIME</option>
									<option value="PROX">PROX</option>
								</select>
								<label>* Select Fuze Type</label>
							</div>

							<div class="input-field col s2">
								<select name="rejection_fuze_diameter" id="rejection_fuze_diameter" required>
									<option value="" selected disabled>--Select--</option>
									<option value="105">105 mm</option>
									<option value="155">155 mm</option>
								</select>
								<label>* Gun Type</label>
							</div>

							<div class="input-field col s8">
								<input id="rejection_scan_pcb" name="rejection_scan_pcb" type="text" autofocus>
								<label for="rejection_scan_pcb"><center>* Scan PCB Number</center></label>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s4">
								<select name="rejection_stage" id="rejection_stage" required>
									<option value="" disabled selected>-- Please select --</option>
									<option value="Q/A">Visual (Q/A)</option>
									<option value="PCB">PCB</option>
									<option value="HOUSING">HOUSING</option>
									<option value="POTTING">ASSEMBLY ELECTRONICS (POTTED)</option>
									<option value="PU POTTING">CALIBRATION (PROX ONLY)</option>
									<option value="ELECTRONIC HEAD">ELECTRONIC HEAD</option>
								</select>
								<label>* Rejection Stage</label>
							</div>
							<div class="input-field col s8" required>
								<input type="text" id="rejection_remark">
								<label for="rejection_remark">* Rejection Remark</label>
							</div>
						</div>
						<br>
						<center>
							<a class="waves-effect waves-light btn red" id="rejection_submit">ADD TO REJECTION</a>
							<a class="btn waves-effect teal lighten-1" id="rejection_clear">CLEAR</a>
						</center>

					</div>
				</div>
			</div>

			<div class="row">
			<div class="col m2"></div>
				<div class="col s12 m8">
					<div class="card-panel grey lighten-4" id="acceptionCard">
						<center>
							<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Re-accept Rejected Fuze</span>
							<br>
						</center>

						<div class="row">
							<div class="input-field col s2">
								<select name="acception_fuze_type" id="acception_fuze_type">
									<option value="" disabled selected>--Select--</option>
									<option value="EPD">EPD</option>
									<option value="TIME">TIME</option>
									<option value="PROX">PROX</option>
								</select>
								<label>* Select Fuze Type</label>
							</div>

							<div class="input-field col s2">
								<select name="acception_fuze_diameter" id="acception_fuze_diameter" required>
									<option value="" selected disabled>--Select--</option>
									<option value="105">105 mm</option>
									<option value="155">155 mm</option>
								</select>
								<label>* Gun Type</label>
							</div>

							<div class="input-field col s8">
								<input id="acception_scan_pcb" name="acception_scan_pcb" type="text">
								<label for="acception_scan_pcb"><center>* Scan PCB Number</center></label>
							</div>
						</div>

						<div class="input-field col s12">
							<input class="tooltipped" id="acception_remark" name="acception_remark" type="text" data-position="top" data-delay="50" data-tooltip="Help us knowing how you solved this problem">
							<label for="acception_remark"><center>Remark</center></label>
						</div>

						<br>
						<center>
							<a class="waves-effect waves-light btn green" id="acception_submit">ACCEPT FROM REJECTION</a>
							<a class="btn waves-effect teal lighten-1" id="acception_clear">CLEAR</a>
						</center>

					</div>
				</div>
			</div>
		-->

		<div class="row">
			<div class="col s1"></div>
				<div class="col s5">
					<br>
					<br>
					<div class="card-panel grey lighten-4" id="rejectionCard">
						<br>

						<center>
							<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Add to Rejection / Edit Rejection</span>
							<p class="red-text text-lighten-1" style="font-size: 12px;">Fields indicated by (*) are mandatory.</p>
							<br>
						</center>

						<div class="row">
							<div class="input-field col s2">
								<select name="rejection_fuze_type" id="rejection_fuze_type" required>
									<option value="" disabled selected>--Select--</option>
									<option value="EPD">EPD</option>
									<option value="TIME">TIME</option>
									<option value="PROX">PROX</option>
								</select>
								<label>* Fuze Type</label>
							</div>

							<div class="input-field col s2">
								<select name="rejection_fuze_diameter" id="rejection_fuze_diameter" required>
									<option value="" selected disabled>--Select--</option>
									<option value="105">105 mm</option>
									<option value="155">155 mm</option>
								</select>
								<label>* Gun Type</label>
							</div>

							<div class="input-field col s8">
								<input id="rejection_scan_pcb" name="rejection_scan_pcb" type="text" autofocus>
								<label for="rejection_scan_pcb"><center>* Scan PCB Number</center></label>
							</div>
						</div>

						<!-- Value and process name will be mismatch. Remember to use the values for further processing -->
						<div class="row">
							<div class="input-field col s4">
								<select name="rejection_stage" id="rejection_stage" required>
									<option value="" disabled selected>-- Please select --</option>
									<option value="Q/A">Visual (Q/A)</option>
									<option value="PCB">PCB</option>
									<option value="HOUSING">HOUSING</option>
									<option value="POTTING">ASSEMBLY ELECTRONICS (POTTED)</option>
									<option value="PU POTTING">CALIBRATION (PROX ONLY)</option>
									<option value="ELECTRONIC HEAD">ELECTRONIC HEAD</option>
								</select>
								<label>* Rejection Stage</label>
							</div>
							<div class="input-field col s8" required>
								<input type="text" id="rejection_remark">
								<label for="rejection_remark">* Rejection Remark</label>
							</div>
						</div>
						<center>
							<a class="waves-effect waves-light btn red" id="rejection_submit">ADD TO REJECTION</a>
							<a class="btn waves-effect teal lighten-1" id="rejection_clear">CLEAR</a>
						</center>

					</div>
				</div>

				<div class="col s5">
					<br><br>
					<div class="card-panel grey lighten-4" id="acceptionCard">
						<center>
							<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Re-accept Rejected Fuze</span>
							<p class="red-text text-lighten-1" style="font-size: 12px;">Fields indicated by (*) are mandatory.</p>
							<br>
							<br>
						</center>

						<div class="row">
							<div class="input-field col s2">
								<select name="acception_fuze_type" id="acception_fuze_type">
									<option value="" disabled selected>--Select--</option>
									<option value="EPD">EPD</option>
									<option value="TIME">TIME</option>
									<option value="PROX">PROX</option>
								</select>
								<label>* Fuze Type</label>
							</div>

							<div class="input-field col s2">
								<select name="acception_fuze_diameter" id="acception_fuze_diameter" required>
									<option value="" selected disabled>--Select--</option>
									<option value="105">105 mm</option>
									<option value="155">155 mm</option>
								</select>
								<label>* Gun Type</label>
							</div>

							<div class="input-field col s8">
								<input id="acception_scan_pcb" name="acception_scan_pcb" type="text">
								<label for="acception_scan_pcb"><center>* Scan PCB Number</center></label>
							</div>
						</div>

						<div class="input-field col s12">
							<input class="tooltipped" id="acception_remark" name="acception_remark" type="text" data-position="top" data-delay="50" data-tooltip="Help us knowing how you solved this problem">
							<label for="acception_remark"><center>Remark</center></label>
						</div>
						<center style="margin-top: 120px;">
							<a class="waves-effect waves-light btn green" id="acception_submit">ACCEPT FROM REJECTION</a>
							<a class="btn waves-effect teal lighten-1" id="acception_clear">CLEAR</a>
						</center>

					</div>
				</div>
				<div class="col s1"></div>
			</div>

		</main>
	</body>

	<footer class="page-footer teal lighten-2">
		<div class="footer-copyright">
			<div class="container">
				<center>&copy; Bharat Electronics Ltd. (".strval(date('Y'))."), All rights reserved.</center>
			</div>
		</div>
	</footer>

	<script type="text/javascript">

		switch($.cookie('fuzeDia')){
			case '105':
				document.getElementById('loginNavTitle').innerHTML = "105 mm Fuze Database";
				$('#rejection_fuze_diameter').val("105");
				$('#acception_fuze_diameter').val("105");
				break;
			case '155':
				document.getElementById('loginNavTitle').innerHTML = "155 mm Fuze Database";
				$('#rejection_fuze_diameter').val("155");
				$('#acception_fuze_diameter').val("155");
				break;
		}

		switch($.cookie('fuzeType')) {
			case 'EPD':
				$('#rejection_fuze_type').val("EPD");
				$('#acception_fuze_type').val("EPD");
				break;
			case 'TIME':
				$('#rejection_fuze_type').val("TIME");
				$('#acception_fuze_type').val("TIME");
				break;
			case 'PROX':
				$('#rejection_fuze_type').val("PROX");
				$('#acception_fuze_type').val("PROX");
				break;
		}

		$('select').material_select();

		$('#rejection_clear').click(function(){
			$('#rejection_scan_pcb').val('');
			$('#rejection_remark').val('');
			$('#rejection_scan_pcb').focus();
		});

		$('#acception_clear').click(function() {
			$('#acception_scan_pcb').val('');
			$('#acception_remark').val('');
			$('#acception_scan_pcb').focus();
		});

		var confirmStatus;
		$('#rejection_submit').click(function(){
				if (($('#rejection_fuze_type :selected').val() == '') || ($('#rejection_fuze_diameter :selected').val() == '') || ($('#rejection_stage :selected').val() == '') || ($('#rejection_remark').val() == '') || ($('#rejection_scan_pcb').val() == '')){
					Materialize.toast("Please fill-up the required fields!",4000,'rounded');
					}
				else {
					addToRejection();
				}
		});

		$('#acception_submit').click(function(){
			if ($('#acception_fuze_type :selected').val() == '' || $('#acception_scan_pcb').val() == '' || $('#acception_fuze_diameter :selected').val() == ''){
				Materialize.toast("Please fill-up the required fields!",4000,'rounded');
			}
			else {
				acceptFromRejection();
			}
		});

		function acceptFromRejection(){
			$.ajax({
					url: 'rejection.php',
					type: 'POST',
					data: {
						type: 'accept',
						pcb_no: $('#acception_scan_pcb').val(),
						fuze: $('#acception_fuze_type :selected').val(),
						remark: $('#acception_remark').val(),
						diameter: $('#acception_fuze_diameter :selected').val()
					},
					success: function(msg) {
						console.log(msg);
						if(msg.includes("ok")){
							Materialize.toast('Accepted back from rejection',3000,'rounded');
						}
						else{
							Materialize.toast('Failed to reject!',3000,'rounded');
							Materialize.toast('Server says: ' + msg.toString(),3000,'rounded');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + 'Is web-server offline?');
					}
				});
		}

		function addToRejection(){
			$.ajax({
					url: 'rejection.php',
					type: 'POST',
					data: {
						type: 'reject',
						pcb_no: $('#rejection_scan_pcb').val(),
						fuze: $('#rejection_fuze_type :selected').val(),
						stage: $('#rejection_stage :selected').val(),
						remark: $('#rejection_remark').val(),
						diameter: $('#rejection_fuze_diameter :selected').val()
					},
					success: function(msg) {
						console.log(msg);
						if(msg.includes("ok")){
							Materialize.toast('Added to rejection',3000,'rounded');
						}
						else if(msg.includes("no record found")) {
							alert("No record found for "+ $('#rejection_scan_pcb').val() +" at "+ $('#rejection_stage :selected').val() +" rejection stage!\n\nPlease enter data manually or Upload ATE result for "+ $('#rejection_scan_pcb').val() +" to continue..");
							Materialize.toast('Data Not Submitted!',3000,'rounded');
						}
						else{
							Materialize.toast('Failed to reject!',3000,'rounded');
							Materialize.toast('Server says: ' + msg.toString(),3000,'rounded');
						}
						$('#rejection_clear').trigger('click');
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + 'Is web-server offline?');
					}
				});
		}
	</script>
</html>
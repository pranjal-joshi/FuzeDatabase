
<?php

	//error_reporting(0);
	
	include("db_config.php");

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if($_POST['select'] == "rejection") {

			if($_POST['fuze_type'] == "PROX") {

				$qaRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='Q/A' AND 
					`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
					`fuze_type` = '".$_POST['fuze_type']."'";
				$qaRejectionGraphResult = mysqli_query($db, $qaRejectionGraphQuery);

				$pcbRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='PCB' AND 
					`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
					`fuze_type` = '".$_POST['fuze_type']."'";
				$pcbRejectionGraphResult = mysqli_query($db, $pcbRejectionGraphQuery);

				$housingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='HOUSING' AND 
					`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
					`fuze_type` = '".$_POST['fuze_type']."'";
				$housingRejectionGraphResult = mysqli_query($db, $housingRejectionGraphQuery);

				$pottingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='POTTING' AND 
					`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
					`fuze_type` = '".$_POST['fuze_type']."'";
				$pottingRejectionGraphResult = mysqli_query($db, $pottingRejectionGraphQuery);

				$puPottingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='PU POTTING' AND 
					`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
					`fuze_type` = '".$_POST['fuze_type']."'";
				$puPottingRejectionGraphResult = mysqli_query($db, $puPottingRejectionGraphQuery);

				$rejectionData = array(
					array("label"=>"QA/Visual","symbol"=>"Q/A","y"=>mysqli_num_rows($qaRejectionGraphResult)),
					array("label"=>"PCB","symbol"=>"PCB","y"=>mysqli_num_rows($pcbRejectionGraphResult)),
					array("label"=>"HOUSING","symbol"=>"HOUSING","y"=>mysqli_num_rows($housingRejectionGraphResult)),
					array("label"=>"POTTING","symbol"=>"POTTING","y"=>mysqli_num_rows($pottingRejectionGraphResult)),
					array("label"=>"PU POTTING","symbol"=>"PU POTTING","y"=>mysqli_num_rows($puPottingRejectionGraphResult))
				);

				die(json_encode($rejectionData, JSON_NUMERIC_CHECK));
		}

		}
		elseif($_POST['select'] == "production") {

			$table_name = "";
			$column_name = "";
			$sql = "";

			if($_POST['process'] == "calibration") {
				$table_name = "calibration_table";
				$column_name = "timestamp";
			}
			elseif ($_POST['process'] == "Q/A") {
				$table_name = "qa_table";
				$column_name = "record_date";
			}

			$productionData = array();

			for($i=1;$i<=$_POST['days_in_month'];$i++) {
				$productionSql = "SELECT `_id` FROM `".$table_name."` WHERE `".$column_name."` = '".strval($i)." ".$_POST['month']."'";
				$productionResult = mysqli_query($db, $productionSql);
				array_push($productionData, 
					array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
				);
			}
			die(json_encode($productionData, JSON_NUMERIC_CHECK));
		}
	}
	else {
		echo "
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
		";
	}

	if($_COOKIE["fuzeAccess"] != "edit"){
		die("
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
										<a onclick='self.close();'>Go Back</a>
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

	<body class="analyticsBody">

		<main class="contents">
			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper teal lighten-2" id="analyticsNav">
						<a href="#!" class="brand-logo center" id="analyticsNavTitle">Fuze Database Analytics</a>
						<a onclick="self.close();">
							<span class='white-text text-darken-5' style="font-size: 18px; padding-left: 20px; font-weight: bold">Back</span>
						</a>
					</div>
				</nav>
			</div>

			<div class="row">
				<div class="col m2"></div>
				<div class="col m8 s12">

					<br>
					<div class="card-panel grey lighten-4" id="analyticsCard">
						<div class="row">

							<div class="input-field col s4">
								<select name="analytics_select" id="analytics_select" onchange="whatToShow(this.value)">
									<option value="" selected disabled>-- Select --</option>
									<option value="rejection">Rejection</option>
									<option value="production">Prodution</option>
								</select>
								<label>Select criteria</label>
							</div>

							<div class="input-field col s4" style="display: none;" id="analytics_fuze_type_div">
							<select name="analytics_fuze_type" id="analytics_fuze_type">
								<option value="" disabled selected>-- select --</option>
								<option value="EPD">EPD</option>
								<option value="TIME">TIME</option>
								<option value="PROX">PROX</option>
							</select>
							<label>Select Fuze Type</label>
						</div>

						<div class="input-field col s4" style="display: none;" id="analytics_fuze_diameter_div">
							<select name="analytics_fuze_diameter" id="analytics_fuze_diameter" required>
								<option value="" selected disabled>--Select--</option>
								<option value="105">105 mm</option>
								<option value="155">155 mm</option>
							</select>
							<label>Fuze Diameter</label>
						</div>

					</div>

					<div class="row" id="production_select_row" style="display: none;">
						<div class="input-field col s4" id="analytics_process_div">
							<select name="analytics_proess" id="analytics_process" required>
								<option value="" selected disabled>--Select--</option>
								<option value="Q/A">Q/A</option>
								<option value="calibration">Calibration</option>
							</select>
							<label>Process</label>
						</div>

						<!--<div class="input-field col s4" id="analytics_month_div">
							<select name="analytics_month" id="analytics_month" required>
								<option value="" selected disabled>--Select--</option>
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
							<label>Month</label>
						</div>-->
						<label for="analytics_month" style="margin-left: 30px;">Select month</label>
						<br>
						<input type="month" name="analytics_month" id="analytics_month" style="margin-left: 30px;">
					</div>

					<div class="row">
						<center>
							<a class="btn waves-effect waves-light" id="analyticsShowButton">SHOW</a>
						</center>
					</div>

					</div>
					<br>
					<div id="chartContainer" style="width: 100%, height: 200px;"></div>

				</div>
			</div>

		</main>
	</body>

	<script type="text/javascript">

		$('select').material_select();

		$('#analyticsShowButton').click(function(){

			if($('#analytics_select :selected').val() == "rejection") {

				if($('#analytics_fuze_diameter :selected').val() == '' || $('#analytics_fuze_type :selected').val() == '') {
					Materialize.toast("Please select the required fields!",3000,'rounded');
				}
				else {
					$.ajax({
						type: 'POST',
						data: {
							select: $('#analytics_select :selected').val(),
							fuze_type: $('#analytics_fuze_type :selected').val(),
							fuze_diameter: $('#analytics_fuze_diameter :selected').val()
						},
						success: function(msg) {
							var chart = new CanvasJS.Chart("chartContainer",{
									theme: 'light2',
									exportEnabled: true,
									animationEnabled: 'true',
									title: {
										text: 'Rejection Analysis for ' + $('#analytics_fuze_diameter :selected').val() + ' mm ' + $('#analytics_fuze_type :selected').val() + ' Fuze'
									},
									data: [{
										type: 'doughnut',
										indexLabel: '{symbol} - #percent%',
										showInLegend: true,
										legendText: "{label} : {y} - #percent%",
										dataPoints: JSON.parse(msg)
									}]
							});
							chart.render();
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							 alert(errorThrown + 'Database server offline?');
						}
					});
				}
			}
			else if($('#analytics_select :selected').val() == "production") {
				if($('#analytics_fuze_diameter :selected').val() == '' || $('#analytics_fuze_type :selected').val() == '' || selectedMonth == "" || $('#analytics_process :selected').val() == '') {
					Materialize.toast("Please select the required fields!",3000,'rounded');
				}
				else {
					$.ajax({
						type: 'POST',
						data: {
							select: $('#analytics_select :selected').val(),
							fuze_type: $('#analytics_fuze_type :selected').val(),
							fuze_diameter: $('#analytics_fuze_diameter :selected').val(),
							process: $('#analytics_process :selected').val(),
							month: selectedMonth,
							days_in_month: daysInMonth
						},
						success: function(msg) {
							var chart = new CanvasJS.Chart("chartContainer", {
								animationEnabled: true,
								exportEnabled: true,
								theme: "light2",
								title: {
									text: $('#analytics_process :selected').val() + " of " + $('#analytics_fuze_diameter :selected').val() + " mm " + $('#analytics_fuze_type :selected').val() + " Fuze in " + selectedMonth
								},
								axisX: {
									title: "Days",
								},
								axisY: {
									title: "Prodution rate",
									includeZero: false
								},
								data: [{
									type: "line",
									dataPoints: JSON.parse(msg)
								}]
							});
							chart.render();
							$('#chartContainer').css({"margin-bottom":"100px"});
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							 alert(errorThrown + 'Database server offline?');
						}
					});
				}
			}
			else {
				Materialize.toast("Please select the required fields!",3000,'rounded');
			}
		});

		function whatToShow(mode) {
			$('#analytics_fuze_diameter_div').fadeIn();
			$('#analytics_fuze_type_div').fadeIn();
			if(mode == "production") {
				$('#production_select_row').fadeIn();
			}
			else {
				$('#production_select_row').fadeOut();
			}
		}

		var selectedMonth = "";
		var daysInMonth = 30;

		function getMonthYear(pickString) {
			var splitString = pickString.split("-");
			var year = splitString[0];
			var month;
			switch(splitString[1]) {
				case '01':
					month = "January, ";
					daysInMonth = 31;
					break;
				case '02':
					month = "February, ";
					if(parseInt(year)%4 == 0) {
						daysInMonth = 28;
					}
					else {
						daysInMonth = 27;
					}
					break;
				case '03':
					month = "March, ";
					daysInMonth = 31;
					break;
				case '04':
					month = "April, ";
					daysInMonth = 30;
					break;
				case '05':
					month = "May, ";
					daysInMonth = 31;
					break;
				case '06':
					month = "June, ";
					daysInMonth = 30;
					break;
				case '07':
					month = "July, ";
					daysInMonth = 31;
					break;
				case '08':
					month = "August, ";
					daysInMonth = 31;
					break;
				case '09':
					month = "September, ";
					daysInMonth = 30;
					break;
				case '10':
					month = "October, ";
					daysInMonth = 31;
					break;
				case '11':
					month = "November, ";
					daysInMonth = 30;
					break;
				case '12':
					month = "December, ";
					daysInMonth = 31;
					break;
			}
			//month = "%".concat(month);
			return (month.concat(year));
		}

		$('#analytics_month').change(function(){
			selectedMonth = getMonthYear($(this).val())
		});
	</script>

</html>
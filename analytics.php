
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

				$headRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='HEAD' AND 
					`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
					`fuze_type` = '".$_POST['fuze_type']."'";
				$headRejectionGraphResult = mysqli_query($db, $headRejectionGraphQuery);

				$rejectionData = array(
					array("label"=>"Q/A","symbol"=>"Q/A","y"=>mysqli_num_rows($qaRejectionGraphResult)),
					array("label"=>"PCB","symbol"=>"PCB","y"=>mysqli_num_rows($pcbRejectionGraphResult)),
					array("label"=>"HOUSING","symbol"=>"HOUSING","y"=>mysqli_num_rows($housingRejectionGraphResult)),
					array("label"=>"POTTING","symbol"=>"POTTING","y"=>mysqli_num_rows($pottingRejectionGraphResult)),
					array("label"=>"PU POTTING","symbol"=>"PU POTTING","y"=>mysqli_num_rows($puPottingRejectionGraphResult)),
					array("label"=>"ELECTRONIC HEAD","symbol"=>"ELECTRONIC HEAD","y"=>mysqli_num_rows($puPottingRejectionGraphResult))
				);

				die(json_encode($rejectionData, JSON_NUMERIC_CHECK));
		}

		}
		elseif($_POST['select'] == "production") {

			$table_name = "";
			$column_name = "";
			$sql = "";

			if($_POST['process'] == "calibration" && $_POST['fuze_type'] == "PROX") {
				$table_name = "calibration_table";
				$column_name = "timestamp";
			}
			elseif ($_POST['process'] == "Q/A") {
				$table_name = "qa_table";
				$column_name = "record_date";
			}

			$productionData = array();

			for($i=1;$i<=$_POST['days_in_month'];$i++) {

				$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `".$table_name."`.`pcb_no` = `lot_table`.`pcb_no` WHERE `".$column_name."` = '".strval($i)." ".$_POST['month']."' AND `fuze_diameter`='".$_POST['fuze_diameter']."'";

				$productionResult = mysqli_query($db, $productionSql);
				array_push($productionData, 
					array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
				);
			}
			die(json_encode($productionData, JSON_NUMERIC_CHECK));
		}
		elseif($_POST['select'] == "rejection_details") {
			
			$detailsSql = "SELECT `pcb_no`,`rejection_remark` FROM `lot_table` WHERE 
				`rejection_stage`='".$_POST['rejection_stage']."' AND 
				`fuze_type`='".$_POST['fuze_type']."' AND 
				`fuze_diameter` = '".$_POST['fuze_diameter']."';
			";

			$detailsRes = mysqli_query($db, $detailsSql);

			$htmlTable = "";
			while ($row = mysqli_fetch_assoc($detailsRes)) {
				$htmlTable.="<tr>";
				$htmlTable.="<td>".$row['pcb_no']."</td>";
				$htmlTable.="<td>".$row['rejection_remark']."</td>";
				$htmlTable.="</tr>";
			}
			die($htmlTable);
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

	if(!isset($_COOKIE['fuzeAccess']) || $_COOKIE["fuzeAccess"] != "edit"){
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

			<!-- search modal -->
			<div id="analyticsModal" class="modal">
				<div class="modal-content">
					<center>
						<span class="teal-text text-darken-2" id="analyticsModalHeader" style="font-weight: bold; font-size: 24px;">Rejection Details</span>
						<br>
						<br>
						<div class="row">
							<table class="striped" id="rejection_details_table">
								<thead>
									<tr>
										<th>PCB Number</th>
										<th>Remark</th>
									</tr>
								</thead>
								<tbody id="rejection_details_tbody">
									
								</tbody>
							</table>
						</div>
					</center>
				</div>
				<div class="modal-footer">
					<center>
						<a href="#" class="btn-flat waves-light waves-red waves-effect" onclick="$('#analyticsModal').closeModal();">BACK</a>
						<a href="rejection.php" target="_blank" class="btn-flat waves-light waves-red waves-effect">Go to rejection</a>
					</center>
				</div>
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
						<div class="input-field col s6" id="analytics_process_div">
							<select name="analytics_proess" id="analytics_process" required>
								<option value="" selected disabled>--Select--</option>
								<option value="Q/A">Q/A</option>
								<option value="calibration">Calibration</option>
							</select>
							<label>Process</label>
						</div>

						<label for="analytics_month" style="margin-left: 30px;">Select month</label>
						<br>
						<input type="month" name="analytics_month" id="analytics_month" style="margin-left: 30px;">
					</div>

					<div class="row">
						<center>
							<a class="btn waves-effect waves-light" id="analyticsShowButton">SHOW</a>
							<br>
							<br>
							<span class="grey-text text-darken-1" id="analytics_detail_span" style="display: none;">Click on the pie-chart for more details</span>
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

		var chart;
		$('#analyticsShowButton').click(function(){

			if($('#analytics_select :selected').val() == "rejection") {

				if($('#analytics_fuze_diameter :selected').val() == '' || $('#analytics_fuze_type :selected').val() == '') {
					Materialize.toast("Please select the required fields!",3000,'rounded');
				}
				else {
					$('#analytics_detail_span').fadeIn();
					$.ajax({
						type: 'POST',
						data: {
							select: $('#analytics_select :selected').val(),
							fuze_type: $('#analytics_fuze_type :selected').val(),
							fuze_diameter: $('#analytics_fuze_diameter :selected').val()
						},
						success: function(msg) {
							chart = new CanvasJS.Chart("chartContainer",{
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
										click: onChartClick,
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
									text: ($('#analytics_process :selected').val().charAt(0).toUpperCase() + $('#analytics_process :selected').val().slice(1)) + " of " + $('#analytics_fuze_diameter :selected').val() + " mm " + $('#analytics_fuze_type :selected').val() + " Fuze in " + selectedMonth
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
									lineColor: "#009688",
									color: "#00897b",
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
				$('#analytics_detail_span').fadeOut();
			}
			else {
				$('#production_select_row').fadeOut();
				$('#analytics_detail_span').fadeOut();
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

		function onChartClick(e) {
			$('#analyticsModalHeader').html("Rejection Details of " + e.dataPoint.label + " stage");
			$('#analyticsModal').openModal();
			$.ajax({
				type: 'POST',
				data: {
					select: 'rejection_details',
					fuze_type: $('#analytics_fuze_type :selected').val(),
					fuze_diameter: $('#analytics_fuze_diameter :selected').val(),
					rejection_stage: e.dataPoint.label
				},
				success: function(msg) {
					console.log(msg);
					$('#rejection_details_tbody').html(msg);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert(errorThrown + 'Database server offline?');
				}
			});
		}

	</script>

</html>
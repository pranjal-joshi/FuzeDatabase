<?php
	include('db_config.php');

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
						<a href='#!'' class='brand-logo center'>What are you doing?</a>
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
										<h5 style='color: red'>We can't show you anything</h5>
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

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$sql = "SELECT `rejection_remark`,`acception_remark` FROM `lot_table` WHERE `fuze_type`='".$_POST['fuze_type']."' AND`fuze_diameter`='".$_POST['fuze_diameter']."' AND`rejection_remark` != '' AND `acception_remark` != ''";

			$results = mysqli_query($db,$sql);

			$tableVar = "";

			if($results) {
				while ($row = mysqli_fetch_assoc($results)) {
					$tableVar.= "<tr>";
					$tableVar.= "<td>".$row['rejection_remark']."</td>";
					$tableVar.= "<td>".$row['acception_remark']."</td>";
					$tableVar.= "</tr>";
				}
				mysqli_close($db);
				die($tableVar);
			}
		}

?>

<!DOCTYPE html>
	<html>

	<style type='text/css'>
			.solutionBody {
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

		<title>Fuze-Solutions</title>
	</head>

	<body class="solutionBody">

		<main class="contents">
			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper teal lighten-2" id="solutionNav">
						<a href="#!" class="brand-logo center" id="solutionNavTitle">Fuze Database Problem-Solutions</a>
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
					<div class="card-panel grey lighten-4" id="solutionCard">
						<div class="row">
							<div class="input-field col s6" id="solution_fuze_type_div">
								<select name="solution_fuze_type" id="solution_fuze_type" onchange="onSelectChange()">
									<option value="" disabled selected>-- select --</option>
									<option value="EPD">EPD</option>
									<option value="TIME">TIME</option>
									<option value="PROX">PROX</option>
								</select>
								<label>Select Fuze Type</label>
							</div>

							<div class="input-field col s6" id="solution_fuze_diameter_div" onchange="onSelectChange()">
								<select name="solution_fuze_diameter" id="solution_fuze_diameter" required>
									<option value="" selected disabled>--Select--</option>
									<option value="105">105 mm</option>
									<option value="155">155 mm</option>
								</select>
								<label>Fuze Diameter</label>
							</div>
						</div>

						<div class="row">
							<table class="centered striped">
								<thead>
									<tr>
										<th class="center">Problem</th>
										<th class="center">Solution</th>
									</tr>
								</thead>
								<tbody id="solution_tbody"></tbody>
							</table>
						</div>
					</div>

				</div>
			</div>

		</main>
	</body>

	<script type="text/javascript">
		$(document).ready(function() {
			$('select').material_select();
		});

		function onSelectChange() {
			if($('#solution_fuze_type :selected').val() != "" && $('#solution_fuze_diameter :selected').val() != "") {
				$.ajax({
					type: 'POST',
					data: {
						fuze_type: $('#solution_fuze_type :selected').val(),
						fuze_diameter: $('#solution_fuze_diameter :selected').val()
					},
					success: function(msg) {
						$('#solution_tbody').html(msg);
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert(errorThrown + 'Database server offline?');
					}
				});
			}
		}
	</script>

</html>
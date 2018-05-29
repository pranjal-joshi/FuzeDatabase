<?php
	
	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$start_numeric = vendorToNumeric($_POST['series_start']);
		$stop_numeric = vendorToNumeric($_POST['series_stop']);

		$sql = "INSERT INTO `vendor_pcb_series_table` (`_id`, `vendor_name`, `series_start`, `series_stop`, `series_start_alphanumeric`, `series_stop_alphanumeric`, `fuze_type`) VALUES 
		(NULL, '".$_POST['vendor_name']."', '".$start_numeric."', '".$stop_numeric."', '".$_POST['series_start']."', '".$_POST['series_stop']."', '".$_POST['fuze_type']."')";

		$sqlResult = mysqli_query($db,$sql);

		if($sqlResult) {
			die("ok");
		}
		else {
			die("err");
		}
		mysqli_close($db);
	}

	function vendorToNumeric($alphanumeric) {
		preg_match_all('/([0-9]+|[a-zA-Z]+)/',$alphanumeric,$arr);
		$data = $arr[0];
		for($i=0;$i<sizeof($data);$i++) {
			if(!is_numeric($data[$i])) {
				$data[$i] = ord($data[$i]);
			}
		}
		$append = "";
		for($i=0;$i<sizeof($data);$i++) {
			$append.=strval($data[$i]);
		}
		return $append;
	}

	$html = "
		<!DOCTYPE html>

		<html>

			<style type='text/css'>
							.vendorBody {
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
				<link rel='stylesheet' href='/FuzeDatabase/jquery-ui.css'>
				<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>

				<script type='text/javascript' src='jquery.min.js'></script>
				<script type='text/javascript' src='materialize.min.js'></script>
				<script type='text/javascript' src='jquery.cookie.js'></script>
				<script type='text/javascript' src='jquery.vide.min.js'></script>
				<script src='/FuzeDatabase/jquery-ui.js'></script>

				<!-- Set responsive viewport -->
				<meta name='viewport' content='width=device-width, initial-scale=1.0'/>

				<!-- Disable caching of browser -->
				<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
				<meta http-equiv='Pragma' content='no-cache' />
				<meta http-equiv='Expires' content='0' />

				<title>Vendor</title>

			</head>

			<body class='vendorBody' id='vendorBody'>

				<main class='contents'>

				<div class='navbar-fixed'>
					<nav>
						<div class='nav-wrapper teal lighten-2' id='vendorNav'>
							<a href='#!' class='brand-logo center'>Vendor wise series entry</a>
						</div>
					</nav>
				</div>

				<br><br>
				<div class='row'>
					<div class='col m2'></div>
					<div class='col s12 m8'>
						<div class='card-panel grey lighten-4' id='vendorCard'>
							<div class='row'>
								<div class='input-field col s6'>
									<select name='fuze_type' id='fuze_type' required>
										<option value='' disabled selected>--Select--</option>
										<option value='EPD'>EPD</option>
										<option value='TIME'>TIME</option>
										<option value='PROX'>PROX</option>
									</select>
									<label>Fuze Type</label>
								</div>
								<div class='input-field col s6'>
									<select name='vendor_name' id='vendor_name' required>
										<option value='' disabled selected>--Select--</option>
										<option value='INTERFAB'>Interfab</option>
										<option value='FRONTLINE'>Frontline</option>
										<option value='SGS'>SGS</option>
									</select>
									<label>Vendor Name</label>
								</div>
							</div>
							<div class='row'>
								<div class='input-field col s6'>
									<input id='vendorSeriesStart' type='text'>
									<label for='vendorSeriesStart'><center>Enter first PCB number</center></label>
								</div>
								<div class='input-field col s6'>
									<input id='vendorSeriesStop' type='text'>
									<label for='vendorSeriesStop'><center>Enter last PCB number</center></label>
								</div>
							</div>
							<center>
								<a class='waves-effect waves-light btn' id='vendorSubmitButton'>SUBMIT</a>
							</center>
							<br>
							<table class='striped centered'>
								<thead>
									<tr>
										<th>Vendor</th>
										<th>Series Start</th>
										<th>Series End</th>
										<th>Type</th>
									</tr>
								</thead>
								<tbody>
							";

							$showSql = "SELECT `vendor_name`,`series_start_alphanumeric`,`series_stop_alphanumeric`,`fuze_type` FROM `vendor_pcb_series_table` ORDER BY `_id` DESC";

							$res = mysqli_query($db, $showSql);

							while ($row = mysqli_fetch_assoc($res)) {
								$html.= "
									<tr>
										<td>".$row['vendor_name']."</td>
										<td>".$row['series_start_alphanumeric']."</td>
										<td>".$row['series_stop_alphanumeric']."</td>
										<td>".$row['fuze_type']."</td>
									</tr>
								";
							}

						$html.="
						</tbody>
						</table>
						</div>
					</div>
				</div>

				</main>
			</body>

			<script type='text/javascript'>
					$('select').material_select();

					$('#vendorSubmitButton').click(function(){
						onSubmit();
					});

					function onSubmit() {
						if($('#fuze_type :selected').val() == '' || $('#vendor_name :selected').val() == '' || $('#vendorSeriesStart').val() == '' || $('#vendorSeriesStop').val() == '')
						{
							Materialize.toast('Please enter sufficient data',2000,'rounded');
						}
						else {
							$.ajax({
								type: 'POST',
								data: {
									fuze_type: $('#fuze_type :selected').val(),
									vendor_name: $('#vendor_name :selected').val(),
									series_start: $('#vendorSeriesStart').val().toUpperCase(),
									series_stop: $('#vendorSeriesStop').val().toUpperCase()
								},
								success: function(msg) {
									if(msg.includes('ok')) {
										Materialize.toast('Record created',2000,'rounded');
										setTimeout(function(){
											location.reload(true)
										},2000);
									}
									else {
										Materialize.toast('Error while creating record',3000,'rounded');
									}
								},
								error: function(XMLHttpRequest, textStatus, errorThrown) {
								 alert(errorThrown + ' Is web-server offline?');
								}
							});
						}
					}
			</script>

		</html>
	";

	if(isset($_COOKIE['fuzeLogin'])) {
		if($_COOKIE['fuzeAccess'] == "37BD0D3935B47BE2AB57BCF91B57F499") {
			echo $html;
		}
		else {
			echo "<center>
							<br><br>
								<h3 style='color: red'>You don't have enough permissions to access this page.</h3>
								<br>
								<a href='mgrlogin.php'>Click here to login</a>
						</center>";
		}
	}
	else {
			echo "<center>
							<br><br>
								<h3 style='color: red'>You don't have enough permissions to access this page.</h3>
								<br>
								<a href='mgrlogin.php'>Click here to login</a>
						</center>";
		}
	

?>


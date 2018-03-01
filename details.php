<?php
	include('db_config.php');

	set_error_handler('exceptions_error_handler');

	function exceptions_error_handler($severity, $message, $filename, $lineno) {
		if (error_reporting() == 0) {
			return;
		}
		if (error_reporting() & $severity) {
			throw new ErrorException($message, 0, $severity, $filename, $lineno);
		}
	}

	function curPageURL() {
		$pageURL = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		return $pageURL;
	}

	$url = parse_url(curPageURL());

	$splitUrl = explode("&", $url['query']);

	$toSearch = explode("=", $splitUrl[0])[1];
	$searchIn = explode("=", $splitUrl[1])[1];
	$searchTable = explode("=", $splitUrl[2])[1];

	if(!isset($_COOKIE["fuzeLogin"])){
			die("

				<head>
					<link rel='stylesheet' type='text/css' href='/fuze/materialize.min.css'>
					<script type='text/javascript' src='/fuze/jquery.min.js'></script>
					<script type='text/javascript' src='/fuze/materialize.min.js'></script>
					<script type='text/javascript' src='/fuze/jquery.cookie.js'></script>

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
						<a href='#!'' class='brand-logo center'>Searching without Logging in?</a>
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
										<h5 style='color: red'>We can't let you search!</h5>
										<br>
										<h5 style='color: red'>Until you're authorized to do this!</h5>
										<br>
										<br>
										<a href='/fuze/index.php'>Go Back to login page</a>
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

	$html = "
		<html>
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

			<head>
				<link rel='stylesheet' type='text/css' href='/fuze/materialize.min.css'>
				<script type='text/javascript' src='/fuze/jquery.min.js'></script>
				<script type='text/javascript' src='/fuze/materialize.min.js'></script>
				<script type='text/javascript' src='/fuze/jquery.cookie.js'></script>

				<!-- Set responsive viewport -->
				<meta name='viewport' content='width=device-width, initial-scale=1.0'/>

				<!-- Disable caching of browser -->
				<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
				<meta http-equiv='Pragma' content='no-cache' />
				<meta http-equiv='Expires' content='0' />

				<title>Fuze-Details</title>
			</head>

			<body class='indexBody'>
				<main class='contents'>

				<nav>
					<div class='nav-wrapper teal lighten-2' id='detailsNav'>
						<a href='#!'' class='brand-logo center'>Fuze Details</a>

						<a><span class='white-text text-darken-5 right' style='font-size: 18px; padding-right: 20px; font-weight: bold' onclick='logout()'>Logout</span></a>

						<a><span class='white-text text-darken-5 left' style='font-size: 18px; padding-left: 20px; font-weight: bold' onclick='window.history.go(-1); return false;'>Back</span></a>
					</div>
				</nav>

				<div class='row'>
					<div class='col m2'></div>
					<div class='col m8 s12'>

					<br>
		";

		$sql = "";

		switch ($searchTable) {
			//case 'calibration_table':
			default:
				$sql = $sql = "SELECT * FROM `".$searchTable."` WHERE `".$searchIn."` = '".$toSearch."'";
				$results = mysqli_query($db,$sql);

				if(!$results){
					die("
							<center>
								<span style='font-weight: bold; font-size: 22px' class='red-text text-darken-2'>Search Failure!</span>
							</center>
						");
				}
				else {
					$row = mysqli_fetch_row($results);
					switch ($row[5])
					{
						case '1':
							$row[5] = "Yes";
							break;
						
						default:
							$row[5] = "No";
							break;
					}
					$html.="
					<div class='card-panel grey lighten-4' id='calibrationDetailsCard'>
						<div class='row'>
							<center>
								<span style='font-weight: bold; font-size: 22px' class='teal-text text-darken-2' id='calibrationDetailsTitle'>Calibration Report</span>
							</center>

							<form id='calibrationDetailsForm'>
							<br>
								<table id='calibrationDetailsTable'>
									<thead>
										<th class='center'>Parameters</th>
										<th class='center'></th>
										<th class='center'>Values</th>
										<th class='center'>Parameters</th>
										<th class='center'></th>
										<th class='center'>Values</th>
									</thead>
									<tbody>

										<tr>
											<td class='center'><span class='center'>PCB Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsPcbNo'>
												</div>
											</td>
											<td class='center'><span class='center'>RF Number <span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsRfNo'>
												</div>
											</td>
										</tr>

										<tr>
											<td class='center'><span class='center'>BPF AC (Before)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsBpfbefore'>
												</div>
											</td>
											<td class='center'><span class='center'>BPF AC (After)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsBpfAfter'>
												</div>
											</td>
										</tr>

										<tr>
											<td class='center'><span class='center'>Frequency (Before)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsFreqBefore'>
												</div>
											</td>
											<td class='center'><span class='center'>Frequency (After)<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsFreqAfter'>
												</div>
											</td>
										</tr>

										<tr>
											<td class='center'><span class='center'>Resistor Changed?<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsResChange'>
												</div>
											</td>
											<td class='center'><span class='center'>Resistor Value<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsResValue'>
												</div>
											</td>
										</tr>

										<tr>
											<td class='center'><span class='center'>Date<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsDate'>
												</div>
											</td>
											<td class='center'><span class='center'>Operator<span></td>
											<td class='center'><span class='center' style='font-weight: bold;'>:<span></td>
											<td class='center'>
												<div class='input-field col s12 center'>
													<input type='text' id='calibrationDetailsOperator'>
												</div>
											</td>
										</tr>

									</tbody>
								</table>
							</form>
						</div>
					</div>
				";
				}
				break;
		}

		$html.="
						</div>
					</div>
					</main>

					<footer class='page-footer teal lighten-2'>
						<div class='footer-copyright'>
							<div class='container'>
								<center>&copy; Bharat Electronics Ltd. (2018), All rights reserved.</center>
							</div>
						</div>
					</footer>

				</body>

				<script type='text/javascript'>
					function logout(){
						document.cookie = 'fuzeLogin=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
						location.href = '/fuze/index.php';
					}
					";
					try {
						$html.= "	$('#calibrationDetailsPcbNo').val('".$row[1]."');
											$('#calibrationDetailsRfNo').val('".$row[2]."');
											$('#calibrationDetailsFreqBefore').val('".$row[3]." MHz');
											$('#calibrationDetailsBpfbefore').val('".$row[4]." V');
											$('#calibrationDetailsResChange').val('".$row[5]."');
											$('#calibrationDetailsResValue').val('".$row[6]."K\u2126');
											$('#calibrationDetailsFreqAfter').val('".$row[7]." MHz');
											$('#calibrationDetailsBpfAfter').val('".$row[8]." V');
											$('#calibrationDetailsDate').val('".$row[9]."');
											$('#calibrationDetailsOperator').val('".$row[10 ]."');";
					}
					catch(Exception $e){
						$html.="
							$('#calibrationDetailsForm').hide();
							document.getElementById('calibrationDetailsTitle').innerHTML = 'Failed to search the given parameter!';
						";
					}

				$html.= "</script>
								</html>";

		echo $html;

		mysqli_close($db);
?>
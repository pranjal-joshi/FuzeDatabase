
<!--
	PROX SERVER
	Author  : Pranjal Joshi
	Date  : 16/02/2018
-->

<?php

	include("db_config.php");

	$logged_in = false;

	session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$mypassword = mysqli_real_escape_string($db,$_POST['password']);
		$mypassword = md5($mypassword);

		$sql = "SELECT * FROM password WHERE passwd = '$mypassword'";

		$result = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$count = mysqli_num_rows($result);

		if($count == 1) {
			$_SESSION['login_user'] = $mypassword;
			$cookie_name = "fuzeLogin";
			$cookie_value = strtoupper(md5("ok"));
			//$cookie_value = "ok");
			setcookie($cookie_name, $cookie_value, 0,"/");

			$accessCookie = "fuzeAccess";
			$accessCookieValue = strtoupper(md5($row['access']));
			//$accessCookieValue = $row['access'];
			setcookie($accessCookie, $accessCookieValue, 0,"/");

			$fuzeDiaCookie = "fuzeDia";
			$fuzeDiaValue = $_POST['fuze_diameter'];
			setcookie($fuzeDiaCookie, $fuzeDiaValue, 0, "/");

			$fuzeTypeCookie = "fuzeType";
			$fuzeTypeValue = $_POST['fuze_type'];
			setcookie($fuzeTypeCookie, $fuzeTypeValue, 0, "/");

			$startPointCookie = "fuzeStart";
			$startPointValue = $_POST['startPoint'];
			setcookie($startPointCookie, $startPointValue, 0, "/");

			header("location: welcome.php");
		}
		else {
			 $error = "Your Login Name or Password is invalid";
			 die(
				 "
				 <html>
				 <head>
					<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>
					<link rel='stylesheet' type='text/css' href='materialize.min.css'>
				 </head>

				 <body>
				 <br>
				 <div class='row'>
					<div class='col m4'></div>
						<div class='card-panel col s12 m4 grey lighten-4'>
							<center>
							<br>
							<span class='red-text text-darken-3'>Wrong password! Please try again or contact site admin.</span>
							<br>
							<br>
							<a href='index.php'>Go Back</a>
							<br>
							<br>
							</center>
						</div>
					</div>
					</body>
					</html>"
			 );
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

		<link rel="stylesheet" type="text/css" href="materialize.min.css">
		<link rel='stylesheet' href='/FuzeDatabase/jquery-ui.css'>
		<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>

		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="materialize.min.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>
		<script type="text/javascript" src="jquery.vide.min.js"></script>
		<script src='/FuzeDatabase/jquery-ui.js'></script>

		<!-- Set responsive viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- Disable caching of browser -->
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />

		<title>Fuze-DB</title>

	</head>

	<body class="indexBody" id="indexBody">

		<main class="contents">

		<div class="navbar-fixed">
			<nav>
				<div class="nav-wrapper teal lighten-2" id="loginNav">
					<a href="#!" class="brand-logo center">Welcome to Fuze Database</a>
				</div>
			</nav>
		</div>

		<div class="row">
			<div class="col m3"></div>
				<div class="col s12 m6">
					<br>
					<div class="card-panel grey lighten-4" id="loginCard">
						<br>
						<center>
							<img id="page_logo" class="responsive-img" src="bel-logo-transparent.png" width="350" height="200"></img>
						</center>

							<form method="POST">
								<div class="row">
									<div class="col m4"></div>
									<div class="row">
										<div class="input-field col s12">
											<input type="password" name="password" id="password" class="validate" required autofocus>
											<label for="password">Password</label>
										</div>
									</div>

										<div class="row">

											<div class="input-field col s2">
												<select name="fuze_type" id="fuze_type" required>
													<option value="" disabled selected>--Select--</option>
													<option value="EPD">EPD</option>
													<option value="TIME">TIME</option>
													<option value="PROX">PROX</option>
												</select>
												<label>Fuze Type</label>
											</div>

											<div class="input-field col s2">
												<select name="fuze_diameter" id="fuze_diameter" required>
													<option value="" selected disabled>--Select--</option>
													<option value="105">105 mm</option>
													<option value="155">155 mm</option>
												</select>
												<label>Fuze Diameter</label>
											</div>

											<div class="input-field col s8" id="startPointDiv">
												<select name="startPoint" required>
													<option value="" disabled selected>Select your start point</option>
													<optgroup label="Common">
														<option value="1">QA/Visual</option>
														<option value="2">PCB Testing - ATE</option>
														<option value="8">PCB Testing - Manual</option>
														<option value="9">Housing Testing - ATE</option>
														<option value="10">Housing Testing - Manual</option>
														<option value="11">Potted Housing Testing - ATE</option>
														<option value="12">Potted Housing Testing - Manual</option>
													</optgroup>
													<optgroup label="For Proximity">
														<option value="3">Calibration</option>
														<option value="4">After PU - ATE</option>
														<option value="5">Rework</option>
														<option value="6">Soldering</option>
													</optgroup>
													<optgroup label="For supervisors">
														<option value="7">Lotwise Entry</option>
													</optgroup>
													<optgroup label="Mechanical">
														<option value="13">Battery linking</option>
													</optgroup>
												</select>
												<label>Select process</label>
											</div>
										</div>
								</div>

								<center>
									<button class="waves-effect waves-light btn" type="submit" name="action" id="loginButton">LOGIN</button>
								</center>
							</form>
							<br>
							<br>
							<center>
								<a href="mgrlogin.php" style="color: teal; font-size: 16px;">&#10596; Management login &#10594;</a>
								<br><br>
								<a href="#" style="color: #ef5350;" onclick="openModal()">Trouble logging in?</a>
							</center>

							<div id='troubleModal'></div>

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

		$(document).ready(function() {
			$('select').material_select();

			//$('body').vide('bgvideo_greyscale.mp4');

			$('#page_logo').on("contextmenu", function(e){
				return false;
			});

			$('#page_logo').on("dragstart", function(e){
				return false;
			});

			$('#page_logo').on("selectstart", function(e){
				return false;
			});

			Materialize.toast("Press F11 to go Fullscreen",2500,'rounded');

			var elem = document.body;
			if (elem.requestFullscreen) {
				elem.requestFullscreen();
			} else if (elem.msRequestFullscreen) {
				elem.msRequestFullscreen();
			} else if (elem.mozRequestFullScreen) {
				elem.mozRequestFullScreen();
			} else if (elem.webkitRequestFullscreen) {
				elem.webkitRequestFullscreen();
			}

		});

		function openModal() {
				$('#troubleModal').html('Please contact the system administrator.\n\nE-mail: pranjaljoshi@bel.co.in\nContact: 3919\n\nPranjal P. Joshi\nFuze department.');
				$('#troubleModal').dialog({
					autoOpen : false,
					modal : true,
					show : 'blind',
					hide : 'blind',
					width: '30%',
					title: 'Login help'
				});
				$('#troubleModal').css('white-space','pre-wrap');
				$('#troubleModal').dialog('open');
				$('.ui-widget-overlay').bind('click', function(){
					$('#troubleModal').unbind();
					$('#troubleModal').dialog('close');
				});
			}

	</script>
</html>

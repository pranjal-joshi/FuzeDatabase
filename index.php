
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

		$startPointCookie = "fuzeStart";
		$startPointValue = $_POST['startPoint'];
		setcookie($startPointCookie, $startPointValue, 0, "/");

		$sql = "SELECT * FROM password WHERE passwd = '$mypassword'";

		$result = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$count = mysqli_num_rows($result);

		if($count == 1) {
			$_SESSION['login_user'] = $mypassword;
			$cookie_name = "fuzeLogin";
			$cookie_value = "ok";
			setcookie($cookie_name, $cookie_value, 0,"/");
			header("location: welcome.php");
		}
		else {
			 $error = "Your Login Name or Password is invalid";
			 die(
				 "
				 <html>
				 <head>
					<link rel='stylesheet' type='text/css' href='materialize.min.css'>
				 </head>

				 <body>
				 <br>
				 <div class='row'>
					<div class='col m4'></div>
						<div class='card-panel col s12 m4 grey lighten-4'>
							<center>
							<br>
							<span class='red-text text-darken-3'>Wrong password! Please try again.</span>
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
		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="materialize.min.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>

		<!-- Set responsive viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- Disable caching of browser -->
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />

		<title>Fuze-DB</title>

	</head>

	<body class="indexBody">

		<main class="contents">

		<div class="navbar-fixed">
			<nav>
				<div class="nav-wrapper teal lighten-2" id="loginNav">
					<a href="#!" class="brand-logo center">Welcome to Proxmity Fuze Database</a>
				</div>
			</nav>
		</div>

		<div class="row">
			<div class="col m4"></div>
				<div class="col s12 m4">
					<br>
					<br>
					<div class="card-panel grey lighten-4" id="loginCard">
						<br>
						<center>
							<img class="responsive-img" src="fuze.svg" width="100" height="100"></img>
						</center>

							<form method="POST">
								<div class="row">
									<div class="col m4"></div>
									<div class="row">
										<div class="input-field col s12">
											<input type="password" name="password" id="password" class="validate" required>
											<label for="password">Password</label>
										</div>
									</div>

										<div class="row">
											<div class="input-field col s12">
												<select name="startPoint" required>
													<option value="" disabled selected>Select your start point</option>
													<option value="1">QA/Visual</option>
													<option value="2">PCB Testing</option>
													<option value="3">Calibration</option>
													<option value="4">After PU</option>
													<option value="5">Rework</option>
													<option value="6">Soldering</option>
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
								<a href="" onclick="alert('Please contact the system administrator.\n\nPranjal P. Joshi\nFuze department.\n\npranjaljoshi@bel.co.in')">Trouble logging in?</a>
							</center>

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
		});

	</script>
</html>

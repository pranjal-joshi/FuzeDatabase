
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

		$mypassword = strtolower(mysqli_real_escape_string($db,$_POST['password']));
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
			setcookie($accessCookie, $accessCookieValue, 0,"/");

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
		<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>
		<link rel="stylesheet" type="text/css" href="materialize.min.css">
		<link rel='stylesheet' href='/FuzeDatabase/jquery-ui.css'>

		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="materialize.min.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>
		<script src='/FuzeDatabase/jquery-ui.js'></script>

		<!-- Set responsive viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- Disable caching of browser -->
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />

		<title>Manager's Login</title>

	</head>

	<body class="indexBody">

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
								</div>

								<center>
									<button class="waves-effect waves-light btn" type="submit" name="action" id="loginButton">LOGIN</button>
								</center>
							</form>
							<br>
							<br>
							<center>
								<a href="index.php" style="color: teal; font-size: 16px;">&#10596; Production login &#10594;</a>
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
					<center>&copy; Bharat Electronics Ltd. (".strval(date('Y'))."), All rights reserved.</center>
				</div>
			</div>
		</footer>

		<script type="text/javascript">
			$('#page_logo').on("contextmenu", function(e){
				return false;
			});

			$('#page_logo').on("dragstart", function(e){
				return false;
			});

			$('#page_logo').on("selectstart", function(e){
				return false;
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

	</body>
</html>

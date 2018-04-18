<?php
	include('db_config.php');

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if($_POST['mode'] == 'new') {
			$sqlNew = "INSERT INTO `forum_table` (`message`) VALUE ('".$_POST['msg']."')";
			$newRes = mysqli_query($db, $sqlNew);
			if($newRes) {
				die("ok");
			}
			else {
				die("fail");
			}
		}
		elseif($_POST['mode'] == 'load_table') {
			$tableSql = "SELECT * FROM `forum_table` ORDER BY `thread_id` DESC";
			$tableRes = mysqli_query($db, $tableSql);

			$tbody = "";
			while ($row = mysqli_fetch_assoc($tableRes)) {
				$tbody.="<tr>";
				$tbody.="<td class='left'>".$row['thread_id']."</td>";
				$tbody.="<td class='center'>".$row['message']."</td>";
				$tbody.="</tr>";
			}
			die($tbody);
		}
	}
?>

<html>

	<style type="text/css">
			.forumBody {
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

		<title>Fuze-Forum</title>
	</head>

	<?php
		if(!isset($_COOKIE["fuzeLogin"])){
			die("

				<style type='text/css'>
						.forumBody {
							display: flex;
							min-height: 100vh;
							flex-direction: column;
						}
						.contents {
							flex: 1;
						}
				</style>

				<body class='forumBody'>
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

	<body class="forumBody">
		<main class="contents">

			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper teal lighten-2" id="loginNav">
						<a href="#!" class="brand-logo center">Fuze Database Forum</a>
					</div>
				</nav>
			</div>

			<div class="row">
			<div class="col m2"></div>
				<div class="col s12 m8">
					<br>
					<br>
					<div class="card-panel grey lighten-4" id="forumCard">
						<div class="row">
							<center>
								<span class="teal-text text-darken-2" style="font-size: 18px; font-weight: bold;">.: Create a new thread :.</span>
							</center>
							<div class="input-field col s12">
								<textarea id="new_msg" class="materialize-textarea"></textarea>
								<label for="new_msg">What's on your mind?</label>
							</div>
							<br>
							<center><a href="#!" class="btn waves-light" id="forumSubmit" onclick="submitForum()">SUBMIT</a></center>
						</div>
						<br>
						<div class="row">
							<center>
								<span class="teal-text text-darken-2" style="font-size: 18px; font-weight: bold;">.: Previous threads :.</span>
							</center>
							<table class="stripped">
								<thead>
									<tr>
										<th class="left" width="10px">Th. No.</th>
										<th class="center">Messages</th>
									</tr>
								</thead>
								<tbody id="forumTableBody">
								</tbody>
							</table>
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
		reloadTable();

		function submitForum() {
			if($('#new_msg').val() != "") {
				$.ajax({
					type: "POST",
					data: {
						msg: $('#new_msg').val(),
						mode: 'new'
					},
					success: function(msg) {
						if(msg == "ok") {
							Materialize.toast("New thread created",3000,'rounded');
							$('#new_msg').val('');
							reloadTable();
						}
						else if(msg == "fail") {
							Materialize.toast("Failed to create thread!",3000,'rounded');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert(errorThrown + 'Is web-server offline?');
					}
				});
			}
			else {
				Materialize.toast("Text can't be kept blank",3000,'rounded');
			}
		}

		function reloadTable() {
			$.ajax({
			type: "POST",
			data: {
				mode: 'load_table'
			},
			success: function(msg) {
				$('#forumTableBody').html(msg);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(errorThrown + 'Is web-server offline?');
			}
			});
		}

	</script>

</html>
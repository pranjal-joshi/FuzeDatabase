<?php

	include("db_config.php");

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if($_POST['task'] == 'add') {

			$sql = "INSERT INTO `mtrl_mgmt` (`_id`, `mtrl_name`, `mtrl_qty`, `fuze_type`, `fuze_diameter`) VALUES (NULL, '".$_POST['name']."', '".$_POST['qty']."', NULL, NULL)";
			print_r($sql);

			$sqlResult = mysqli_query($db,$sql);

			if($sqlResult) {
				die("ok");
			}
			else {
				die("err");
			}
			mysqli_close($db);
		}
		elseif($_POST['task'] == 'update') {
			$size = sizeof($_POST['array']['data']);
			for($i=0;$i<$size;$i++) {
				$name = $_POST['array']['data'][$i]['name'];
				$qty = $_POST['array']['data'][$i]['qty'];
				print_r($name);
				$sql = "UPDATE `mtrl_mgmt` SET `mtrl_qty`='".$qty."' WHERE `mtrl_name`='".$name."'";
				$dateRes = mysqli_query($db, $sql);
			}
			die("ok");
		}
	}
	else {

		echo "
		<!DOCTYPE html>
			<html>

			<style type='text/css'>
					.mtrlmgmtBody {
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

				<title>Fuze - Material Mgmt</title>
			</head>
		";

		if(!isset($_COOKIE['fuzeAccess'])) {		// TO DENY ACCESS WITH WRITE PERMSN, ADD --> || $_COOKIE["fuzeAccess"] == "EFB2A684E4AFB7D55E6147FBE5A332EE"
			die("
					<body class='mtrlmgmtBody'>
					<main class='contents'>

					<nav>
						<div class='nav-wrapper red lighten-2' id='mtrlmgmtNav'>
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
	}

$html = "

<body class='mtrlmgmtBody'>

	<main class='contents'>
		<div class='navbar-fixed'>
			<nav>
				<div class='nav-wrapper teal lighten-2' id='mtrlmgmtNav'>
					<a href='#!' class='brand-logo center' id='mtrlmgmtNavTitle'>Shopfloor Material Management</a>
					<a onclick='self.close();'>
						<span class='white-text text-darken-5' style='font-size: 18px; padding-left: 20px; font-weight: bold'>Back</span>
					</a>
					<a class='dropdown-button right' href='#' data-activates='dropdownMenu' onclick='logout();'>
						<span class='white-text text-darken-5' style='font-size: 16px; padding-right: 20px; font-weight: bold'>Logout &#128711;</span>
					</a>
				</div>
			</nav>
		</div>

		<br><br>
		<div class='row'>
			<div class='col m2'></div>
			<div class='col s12 m8'>
				<div class='card-panel grey lighten-4' id='mtrlmgmtCard'>
					<center>
						<span class='teal-text text-darken-2' style='font-weight: bold; font-size: 18px;'>Add Material</span>
					</center>
					<div class='row'>
						<div class='input-field col s8'>
							<input id='newMtrlName' type='text'>
							<label for='newMtrlName'>Name of Material</label>
						</div>
						<div class='input-field col s2'>
							<input id='newMtrlQty' type='number'>
							<label for='newMtrlQty'>Quantity</label>
						</div>
						<div class='input-field col s2'>
							<center>
								<a class='waves-effect waves-light btn' id='newMtrlAddBtn' style='margin-top: 10px;' onclick='onAdd()'>ADD</a>
							</center>
						</div>
					</div>
					<br>
					<center>
						<span class='teal-text text-darken-2' style='font-weight: bold; font-size: 18px;'>List of Material</span>
					</center>
					<div class='row'>
						<table class='striped' id='mtrlTable'>
							<thead>
								<tr>
									<th>Material</th>
									<th width='100'>Quantity</th>
								</tr>
							</thead>
							<tbody id='mtrlmgmtTbody'>";

			$showSql = "SELECT `mtrl_name`,`mtrl_qty` FROM `mtrl_mgmt`";

			$res = mysqli_query($db, $showSql);
			$qtyCol = 1;
			while ($row = mysqli_fetch_assoc($res)) {
				$html.= "
					<tr>
						<td>".$row['mtrl_name']."</td>
						<td>
							<div class='input-field'>
								<input id='qtyCol".$qtyCol."'type='number' value='".$row['mtrl_qty']."' style='all: unset; text-align:right;'
							</div>
						</td>
					</tr>
				";
				$qtyCol++;
			}
							
			$html.="</tbody>
						</table>
					</div>
					<center>
						<a class='waves-effect waves-light btn' id='mtrlUpdateBtn' style='margin-top: 10px;' onclick='onUpdateClick()'>UPDATE</a>
					</center>
				</div>
			</div>
		</div>

	</main>

</body>

<script type='text/javascript'>
	function logout(){
		document.cookie = 'fuzeLogin=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
		location.href = 'index.php';
	}

	function onUpdateClick() {
		var jsonMaterial = {data:[]};
		var rc = 0;
		var colName = '';
		$('#mtrlTable tr').each(function() {
			if(rc == 0) {
				// do nothing
			}
			else {
				mtrlName = $(this).html();
				mtrlName = mtrlName.split('</td>')[0];
				mtrlName = mtrlName.split('>')[1];

				colName = 'qtyCol' + rc.toString();
				mtrlQty = document.getElementById(colName).value;
				
				jsonMaterial.data.push({
					'name': mtrlName,
					'qty': mtrlQty
				});


			}
			rc += 1;
		});

		console.log(jsonMaterial);

		$.ajax({
				type: 'POST',
				data: {
					array: jsonMaterial,
					task: 'update'
				},
				success: function(msg) {
					if(msg.includes('ok')) {
						Materialize.toast('Record updated',2000,'rounded');
						setTimeout(function(){location.reload(true)},2000);
					}
					else {
						console.log(msg);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert(errorThrown + ' Is web-server offline?');
				}
			});
	}

	function onAdd() {
		if($('#newMtrlName').val() == '' || $('#newMtrlQty').val() == '') {
			Materialize.toast('Please enter name & quantity.',3000,'rounded');
		}
		else {
			$.ajax({
				type: 'POST',
				data: {
					name: $('#newMtrlName').val(),
					qty: $('#newMtrlQty').val(),
					task: 'add'
				},
				success: function(msg) {
					if(msg.includes('ok')) {
						Materialize.toast('Record created',2000,'rounded');
						setTimeout(function(){
							location.reload(true)
						},2000);
					}
					else {
						console.log(msg);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert(errorThrown + ' Is web-server offline?');
				}
			});
		}
	}
</script>

</html>";

echo $html;

?>
<?php
	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$sql = "UPDATE `lot_table` SET `rejected`='1',
		`rejection_stage`='".$_POST['stage']."',
		`rejection_remark`='".$_POST['remark']."' 
		WHERE `pcb_no`='".$_POST['pcb_no']."' AND `fuze_type` = '".$_POST['fuze']."'";

		$result = mysqli_query($db, $sql);

		echo $sql;

		if($result){
			echo "ok";
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
				<div class="nav-wrapper teal lighten-2">
					<a href="#!" class="brand-logo center">Fuze Database Home-Page</a>

					<a><span class='white-text text-darken-5 left' style='font-size: 18px; padding-left: 20px; font-weight: bold' onclick='self.close();'>Back</span></a>
				</div>
			</nav>
		</div>

		<div class="row">
			<div class="col m2"></div>
				<div class="col s12 m8">
					<br>
					<br>
					<div class="card-panel grey lighten-4" id="loginCard">
						<br>

						<center>
							<span style="font-weight: bold; font-size: 20px" class="teal-text text-darken-2">Add to Rejection</span>
							<p class="red-text text-lighten-1" style="font-size: 12px;">Fields indicated by (*) are mandatory.</p>
							<br>
						</center>

						<div class="row">
							<div class="input-field col s3">
								<select name="rejection_fuze_type" id="rejection_fuze_type" required>
									<option value="" disabled selected>-- Please select --</option>
									<option value="EPD">EPD</option>
									<option value="TIME">TIME</option>
									<option value="PROX">PROX</option>
								</select>
								<label>* Select Fuze Type</label>
							</div>
							<div class="input-field col s4">
								<input id="rejection_scan_pcb" name="rejection_scan_pcb" type="text" autofocus>
								<label for="rejection_scan_pcb"><center>* Scan PCB Number</center></label>
							</div>
							<div class="input-field col s5">
								<input id="rejection_manual_pcb" name="rejection_manual_pcb" type="text">
								<label for="rejection_manual_pcb"><center>Or Enter manually</center></label>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s4">
								<select name="rejection_stage" id="rejection_stage" required>
									<option value="" disabled selected>-- Please select --</option>
									<option value="Q/A">Q/A Visual</option>
									<option value="PCB">PCB</option>
									<option value="HOUSING">HOUSING</option>
									<option value="POTTING">POTTING</option>
									<option value="PU POTTING">PU POTTING</option>
								</select>
								<label>* Rejection Stage</label>
							</div>
							<div class="input-field col s8" required>
								<input type="text" id="rejection_remark">
								<label for="rejection_remark">* Rejection Remark</label>
							</div>
						</div>
						<br>
						<center>
							<a class="waves-effect waves-light btn red" id="rejection_submit">ADD TO REJECTION</a>
							<a class="btn waves-effect teal lighten-1" id="rejection_clear">CLEAR</a>
						</center>

					</div>
				</div>
			</div>

		</main>
	</body>

	<script type="text/javascript">
		$('select').material_select();

		$('#rejection_clear').click(function(){
			$('#rejection_scan_pcb').val('');
			$('#rejection_manual_pcb').val('');
			$('#rejection_remark').val('');
			$('#rejection_scan_pcb').focus();
		});

		var confirmStatus;
		$('#rejection_submit').click(function(){
				if (($('#rejection_fuze_type :selected').val() == '') || ($('#rejection_stage :selected').val() == '') || ($('#rejection_remark').val() == '') || (($('#rejection_scan_pcb').val() == '') && ($('#rejection_manual_pcb').val() == ''))){
					Materialize.toast("Please fill-up the required fields!",4000,'rounded');
					}
				else {
					confirmStatus = confirm("Are you sure about rejecting this fuze?");
					if(confirmStatus == true) {
						addToRejection();
						$('#rejection_clear').trigger('click');
					}
					else{
						// do nothing
					}
				}
		});

		function addToRejection(){
			$.ajax({
					url: 'rejection.php',
					type: 'POST',
					data: {
						pcb_no: ($('#rejection_scan_pcb').val() == '' ? $('#rejection_manual_pcb').val() : $('#rejection_scan_pcb').val()),
						fuze: $('#rejection_fuze_type :selected').val(),
						stage: $('#rejection_stage :selected').val(),
						remark: $('#rejection_remark').val()
					},
					success: function(msg) {
						console.log(msg);
						if(msg.includes("ok")){
							Materialize.toast('Added to rejection',3000,'rounded');
						}
						else{
							Materialize.toast('Failed to reject!',3000,'rounded');
							Materialize.toast('Server says: ' + msg.toString(),3000,'rounded');
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						 alert(errorThrown + 'Database server offline?');
					}
				});
		}
	</script>
</html>
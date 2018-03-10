<?php
	include("db_config.php");

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
		return urldecode($pageURL);
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		if($_POST['task'] == "add") {

			$sql = "INSERT INTO `lot_table`(`_id`,`fuze_type`, `main_lot`, `kit_lot`, `pcb_no`, `kit_lot_size`) VALUES 
			(NULL,
			'".$_POST['fuze']."',
			'".$_POST['main_lot']."',
			'".$_POST['kit_lot']."',
			'".$_POST['pcb_no']."',
			'".$_POST['size']."')";

			$sqlCheck = "SELECT * FROM `lot_table` WHERE `pcb_no`='".$_POST['pcb_no']."' AND `fuze_type` = '".$_POST['fuze']."'";

			$checkResult = mysqli_query($db,$sqlCheck);
			if($checkResult->num_rows)
			{
				die("<center><p style='color: red; font-weight: bold;'>Already entered in the lot. Search this PCB Number for more information. (Menu -> Search)</p><center>");
			}
			else{
				$result = mysqli_query($db,$sql);
				if($result){

					$tableQuery = "SELECT * FROM `lot_table` WHERE 
					`fuze_type` = '".$_POST['fuze']."' AND 
					`main_lot` = '".$_POST['main_lot']."' AND 
					`kit_lot` = '".$_POST['kit_lot']."' ORDER BY `_id` DESC";

					$tableResult = mysqli_query($db,$tableQuery);

					$html = "
										<center>
											<table class='striped' style='left: 0px; right: 0px; top: 0px; bottom: 0px;'>
												<thead>
													<th class='center'>Fuze Type</th>
													<th class='center'>Main Lot</th>
													<th class='center'>Kit Lot</th>
													<th class='center'>PCB Number</th>
													<th class='center'>Kit Lot size</th>
													<th class='center'>Action</th>
												</thead>
												<tbody>
									";
					
					while ($row = mysqli_fetch_assoc($tableResult)) {
						if($row['rejected'] == '1'){
							$html.= "<tr class='red-text text-darken-2' style='font-weight: bold;'>";
						}
						else {
							$html.= "<tr>";
						}
						$html.=	"
												<td class='center'>".$row['fuze_type']."</td>
												<td class='center'>".$row['main_lot']."</td>
												<td class='center'>".$row['kit_lot']."</td>
												<td class='center'>".$row['pcb_no']."</td>
												<td class='center'>".$row['kit_lot_size']."</td>
												<td class='center'><a href='lot.php/?pcb_no=".$row['pcb_no']."&fuze=".$row['fuze_type']."' class='btn waves-effect waves-light red' target='_blank'>DELETE</a></td>
											</tr>
										";
					}
					$html.= "</tbody></table></center>";
					echo $html;
				}
			}
		}
		elseif ($_POST['task'] == 'view') {
			$tableQuery = "SELECT * FROM `lot_table` WHERE 
					`fuze_type` = '".$_POST['fuze']."' AND 
					`main_lot` = '".$_POST['main_lot']."' AND 
					`kit_lot` = '".$_POST['kit_lot']."' ORDER BY `_id` DESC";

					$tableResult = mysqli_query($db,$tableQuery);

					$html = "
										<center>
											<table class='striped' style='left: 0px; right: 0px; top: 0px; bottom: 0px;'>
												<thead>
													<th class='center'>Fuze Type</th>
													<th class='center'>Main Lot</th>
													<th class='center'>Kit Lot</th>
													<th class='center'>PCB Number</th>
													<th class='center'>Kit Lot size</th>
													<th class='center'>Action</th>
												</thead>
												<tbody>
									";
					
					while ($row = mysqli_fetch_assoc($tableResult)) {
						if($row['rejected'] == '1'){
							$html.= "<tr class='red-text text-darken-2' style='font-weight: bold;'>";
						}
						else {
							$html.= "<tr>";
						}
						$html.= "	
												<td class='center'>".$row['fuze_type']."</td>
												<td class='center'>".$row['main_lot']."</td>
												<td class='center'>".$row['kit_lot']."</td>
												<td class='center'>".$row['pcb_no']."</td>
												<td class='center'>".$row['kit_lot_size']."</td>
												<td class='center'><a href='lot.php/?pcb_no=".$row['pcb_no']."&fuze=".$row['fuze_type']."' class='btn waves-effect waves-light red' target='_blank'>DELETE</a></td>
											</tr>
										";
					}
					$html.= "</tbody></table>";
					echo $html;
		}
	}

	else{
		$url = parse_url(curPageURL());
		
		try {
			$splitUrl = explode("&", $url['query']);
			$pcb_no = explode("=", $splitUrl[0])[1];
			$fuze_type = explode("=", $splitUrl[1])[1];

			$deleteQuery = "DELETE FROM `lot_table` WHERE `pcb_no`='".$pcb_no."' AND `fuze_type`='".$fuze_type."'";
			$deleteResult = mysqli_query($db, $deleteQuery);

			if(mysqli_affected_rows($db) > 0){
				echo"
							<center>
								<br>
								<br>
								<h3 style='color: red; font-weight: bold;'>Following entry has been deleted from Lot-wise records.</h3>
								<p>PCB Number: ".$pcb_no."</p>
								<p>Fuze Type : ".$fuze_type."</p>
								<br>
								<a href='#' onclick='self.close();'>Go Back</a> and press \"View Lot\" button to refresh.
							</center>
						";
			}
			else{
				echo"
							<center>
								<br>
								<br>
								<h3 style='color: red; font-weight: bold;'>No match found! Nothing to delete!</h3>
								<h3 style='color: red; font-weight: bold;'>Have you already deleted this?</h3>
								<br>
								<a href='#' onclick='self.close();'>Click here to Go Back</a>
							</center>
						";
			}
		}
		catch(Exception $e){
			print_r($e);
		}
	}

	mysqli_close($db);
?>
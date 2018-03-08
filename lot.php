<?php
	include("db_config.php");

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
						$html.= "
											<tr>
												<td class='center'>".$row['fuze_type']."</td>
												<td class='center'>".$row['main_lot']."</td>
												<td class='center'>".$row['kit_lot']."</td>
												<td class='center'>".$row['pcb_no']."</td>
												<td class='center'>".$row['kit_lot_size']."</td>
												<td class='center'><a class='btn waves-effect waves-light red'>DELETE</a></td>
											</tr>
										";
					}
					$html.= "</tbody></table>";
					echo $html;
				}
			}
		}
		elseif ($_POST['task'] == 'delete') {
			print_r($_POST);
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
						$html.= "	
											<tr>
												<td class='center'>".$row['fuze_type']."</td>
												<td class='center'>".$row['main_lot']."</td>
												<td class='center'>".$row['kit_lot']."</td>
												<td class='center'>".$row['pcb_no']."</td>
												<td class='center'>".$row['kit_lot_size']."</td>
												<td class='center'><a class='btn waves-effect waves-light red'>DELETE</a></td>
											</tr>
										";
					}
					$html.= "</tbody></table>";
					echo $html;
		}
	}

	mysqli_close($db);
?>
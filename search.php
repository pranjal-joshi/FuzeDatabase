<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$searchIn = "";
		$searchInTable = $_POST['tableSelect'];
		$query = $_POST['query'];
		$table_head = "";

		switch ($searchInTable) {
			case '1':
				$searchInTable = "after_pu";
				break;
			case '2':
				$searchInTable = "calibration_table";
				break;
			case '3':
				$searchInTable = "qa_table";
				break;
			case '4':
				$searchInTable = "pcb_testing";
				break;
			case '5':
				$searchInTable = "housing_table";
				break;
			case '6':
				$searchInTable = "potting_table";
				break;
		}

		switch ($_POST['select']) {
			case '1':
				$searchIn = "pcb_no";
				$table_head.= "
				<thead>
					<tr>
						<th class='center'>S.N.</th>
						<th class='center'>PCB NO.</th>
						<!--<th class='center'>TABLE</th>-->
						<th class='center'>TYPE</th>
						<th class='center'>MAIN LOT</th>
						<th class='center'>KIT LOT</th>
						<th class='center'>ACTION</th>
						<!--
						<center><th>Before BPF AC</th></center>
						<center><th>RES</th></center>
						<center><th>After Freq</th></center>
						<center><th>After BPF</th></center>
						<center><th>Time</th></center>
						<center><th>OP</th></center>
						-->
					</tr>
				</thead>";
				break;
			case '2':
				$searchIn = "rf_no";
				$searchInTable = "calibration_table";
				break;
			case '3':
				$searchIn = "res_val";
				$searchInTable = "calibration_table";
				break;
			case '4':
				$searchIn = "before_freq";
				$searchInTable = "calibration_table";
				break;
			case '5':
				$searchIn = "before_bpf";
				$searchInTable = "calibration_table";
				break;
			case '6':
				$searchIn = "after_freq";
				$searchInTable = "calibration_table";
				break;
			case '7':
				$searchIn = "after_bpf";
				$searchInTable = "calibration_table";
				break;
			case '8':
				if($searchInTable == "calibration_table") {
					$searchIn = "timestamp";
				}
				else {
					$searchIn = "record_date";
				}
				break;
			case '9':
				$searchIn = "op_name";
				$query = strtoupper($query);
				break;
		}

		//$sql = "SELECT * FROM `".$searchInTable."` WHERE `".$searchIn."` LIKE '".$query."%'";

		$sql = "SELECT * FROM `".$searchInTable."` WHERE `".$searchIn."` LIKE '".$query."%'";

		$results = mysqli_query($db,$sql);

		$value = "<center><table class='centered striped' style='left: 0px; right: 0px; top: 0px; bottom: 0px;'>".$table_head;

		$cnt = 0;
		if($results) {
			while ($row = mysqli_fetch_assoc($results)) {
				$sqlLot = "SELECT * FROM `lot_table` WHERE `pcb_no` = '".$row['pcb_no']."'";
				$lotResult = mysqli_query($db,$sqlLot);
				$lotRow = mysqli_fetch_assoc($lotResult);
				$value.="<tr>";
				$cnt++;
				$value.="<td class='center'>".$cnt."</td>";
				if($_POST['select'] == '3')	{
					$value.="<td class='center'>".$row[$searchIn]."K</td>";
				}
				elseif($_POST['select'] == '4' || $_POST['select'] == '6')	{
					$value.="<td class='center'>".$row[$searchIn]." MHz</td>";
				}
				elseif($_POST['select'] == '5' || $_POST['select'] == '7')	{
					$value.="<td class='center'>".$row[$searchIn]." V</td>";
				}
				else{
					$value.="<td class='center'>".$row[$searchIn]."</td>";
				}
				//$value.="<td class='center'>".strtoupper($searchInTable)."</td>";
				$value.="<td class='center'>".$lotRow['fuze_type']."</td>";
				$value.="<td class='center'>".$lotRow['main_lot']."</td>";
				$value.="<td class='center'>".$lotRow['kit_lot']."</td>";
				$value.="<td class='center'><a href='details.php/?q=".$row[$searchIn]."&s=".$searchIn."&t=".$searchInTable."' class='btn waves-effect waves-light' target='_blank'>VIEW details</a></td>";
				$value.="<td class='center'><a href='print.php/?q=".$row['pcb_no']."' class='btn waves-effect waves-light blue-grey' target='_blank'>PRINT</a></td>";
				$value.="</tr></center>";
			}
			echo $value."</table>";
		}
		else {
			//echo($sql);
			die("<br><p style='color: red; font-weight: bold;'>Failed to search!</p>");
		}
	}
?>
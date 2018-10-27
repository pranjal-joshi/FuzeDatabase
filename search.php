<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include('db_config.php');

	// This functions maps string input dates into a large query for search
	/*function dateRangeQuery($startDate, $endDate, $searchInTable, $searchIn) {
		$monthArray = array("January","February","March","April","May","June","July","August","September","October","November","December");
		if($endDate == "") {
			$endDate = $startDate;
		}
		$d1 = (int)explode(" ", $startDate)[0];
		$m1 = rtrim(explode(" ", $startDate)[1],",");
		$y1 = (int)explode(" ", $startDate)[2];
		$d2 = (int)explode(" ", $endDate)[0];
		$m2 = rtrim(explode(" ", $endDate)[1],",");
		$y2 = (int)explode(" ", $endDate)[2];
		$sameYear = 0;
		$sameMonth = 0;
		$tempYear = 0;
		$tempMonth = 0;
		$m1key = array_search($m1, $monthArray);
		$m2key = array_search($m2, $monthArray);

		//$sql = "SELECT * FROM `".$searchInTable."` WHERE `".$searchIn."` LIKE ";
		$sql = "SELECT * FROM `".$searchInTable."` WHERE ";

		if($y2 - $y1 < 0) {								// From > To
			die("<br><p style='color: red; font-weight: bold;'>'From' date should not be ahead of 'To' date!</p>");
		}
		else {
			for($i=$y1;$i<=$y2;$i++) {
				if($y2 - $y1 == 0) {					// same year
					$sameYear = 1;
					if($m2key - $m1key < 0) {		// From > To
						die("<br><p style='color: red; font-weight: bold;'>'From' date should not be ahead of 'To' date!</p>");
					}
				}
				if($sameYear) {
					for($k=$m1key;$k<=$m2key;$k++) {
						// code date looper here
						if($m2key - $m1key == 0) {
							$sameMonth = 1;
							if($d2 - $d1 < 0) {
								die("<br><p style='color: red; font-weight: bold;'>'From' date should not be ahead of 'To' date!</p>");
							}
						}
						if($sameMonth) {
							for($j=$d1;$j<=$d2;$j++) {
								$sql.="`".$searchIn."` LIKE '".strval($j)." ".strval($monthArray[$m1key]).", ".strval($y1)."' OR ";
							}
							$sql = rtrim($sql," OR ");
						}
						else {
							$tempMonth = $m1key;
							for($j=$d1;$j<=31;$j++) {
								$sql.="`".$searchIn."` LIKE '".strval($j)." ".strval($monthArray[$m1key]).", ".strval($y1)."' OR ";
							}
							$tempMonth++;
							for($h=$tempMonth;$h<$m2key;$h++) {
								for($j=1;$j<=31;$j++) {
									$sql.="`".$searchIn."` LIKE '".strval($j)." ".strval($monthArray[$h]).", ".strval($y1)."' OR ";
								}
							}
							for($j=1;$j<=$d2;$j++) {
								$sql.="`".$searchIn."` LIKE '".strval($j)." ".strval($monthArray[$m2key]).", ".strval($y1)."' OR ";
							}
							$sql = rtrim($sql," OR ");
							break;
						}
					}
				}
				else {
					die("<br><p style='color: red; font-weight: bold;'>Search is available only for duration of 1 year. Split the dates in multiple searches to obtain results for multiple years!<br><br>Example: 25 Dec - 5 Jan => 25 Dec - 31 Dec & 1 Jan - 5 Jan</p>");
				}
			}
		}
		unset($monthArray);
		return $sql;
	}*/

	// New - this function uses SQL date datatype with between query
	function dateRangeQuery($startDate, $endDate, $searchInTable, $searchIn) {
		if($endDate == "") {
			$endDate = $startDate;
		}
		$start = new DateTime($startDate);
		$end = new DateTime($endDate);
		if($start > $end) {
			die("<br><p style='color: red; font-weight: bold;'>'From' date should not be ahead of 'To' date!</p>");
		}
		$sql = "SELECT * FROM ".$searchInTable." WHERE ".$searchIn." BETWEEN STR_TO_DATE('".$startDate."','%e %M, %Y') AND STR_TO_DATE('".$endDate."','%e %M, %Y')";
		return $sql;
	}



	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$searchIn = "";
		$searchInTable = $_POST['tableSelect'];
		$query = str_replace("*", "%", $_POST['query']);
		$table_head = "";

		if($_COOKIE['searchFuzeType'] == "PROX") {
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
				case '7':
					$searchInTable = "after_pu";
					break;
			}
		}
		elseif($_COOKIE['searchFuzeType'] == "EPD") {
			switch ($searchInTable) {
				case '4':
					$searchInTable = "pcb_epd_csv";
					break;
			}
		}

		switch ($_POST['select']) {
			case '1':
				$searchIn = "pcb_no";
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
			case '10':
				$searchIn = "result";
				$query = strtoupper($query);
				break;
		}

		if($_POST['select'] == '1') {
			$table_head.= "
				<thead>
					<tr>
						<th class='center'>S.N.</th>
						<th class='center'>PCB NO.</th>
						<th class='center'>TYPE</th>
						<th class='center'>MAIN LOT</th>
						<th class='center'>KIT LOT</th>
						<th class='center'>ACTION</th>
					</tr>
				</thead>";
		}
		else {
			$table_head.= "
				<thead>
					<tr>
						<th class='center'>S.N.</th>
						<th class='center'>Value</th>
						<th class='center'>PCB NO.</th>
						<th class='center'>TYPE</th>
						<th class='center'>MAIN LOT</th>
						<th class='center'>KIT LOT</th>
						<th class='center'>ACTION</th>
					</tr>
				</thead>";
		}

		//$sql = "SELECT * FROM `".$searchInTable."` WHERE `".$searchIn."` LIKE '".$query."%'";

		// Switch between quick & deep search
		$sql = "";
		if($_POST['quickSearch'] == '0') {
			$sql = "SELECT * FROM `".$searchInTable."` WHERE `".$searchIn."` LIKE '".$query."%'";
		}
		else {
			$today = date("Y-m-d",strtotime("today"));
			$past = date("Y-m-d",strtotime("-3 Months"));
			if($searchInTable != 'calibration_table') {
				$sql = "SELECT * FROM `".$searchInTable."` WHERE `".$searchIn."` LIKE '".$query."%' AND `record_date` BETWEEN '".$past."' AND '".$today."'";
			}
			else {
				$sql = "SELECT * FROM `".$searchInTable."` WHERE `".$searchIn."` LIKE '".$query."%' AND `timestamp` BETWEEN '".$past."' AND '".$today."'";
			}
		}

		if($_POST['select'] == '8') {
			$sql = dateRangeQuery($_POST['datepicker1'],$_POST['datepicker2'],$searchInTable,$searchIn);
		}

		$results = mysqli_query($db,$sql);

		$value = "<center><table class='centered striped' style='left: 0px; right: 0px; top: 0px; bottom: 0px;'>".$table_head;

		$cnt = 0;
		if($results) {
			while ($row = mysqli_fetch_assoc($results)) {
				$sqlLot = "SELECT * FROM `lot_table` WHERE `pcb_no` LIKE '%".$row['pcb_no']."'";
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
				if($_POST['select'] != '1') {
					if($row['result'] == "FAIL") {
						$value.="<td class='center' style='color: red; font-weight: bold'>".$row['pcb_no']."</td>";
					}
					else {
						$value.="<td class='center'>".$row['pcb_no']."</td>";	
					}
				}
				if($row['result'] == "FAIL") {
					$value.="<td class='center' style='color: red;'>".$lotRow['fuze_type']."</td>";
					$value.="<td class='center' style='color: red;'>".$lotRow['main_lot']."</td>";
					$value.="<td class='center' style='color: red;'>".$lotRow['kit_lot']."</td>";
				}
				else {
					$value.="<td class='center'>".$lotRow['fuze_type']."</td>";
					$value.="<td class='center'>".$lotRow['main_lot']."</td>";
					$value.="<td class='center'>".$lotRow['kit_lot']."</td>";
				}
				//$value.="<td class='center'><a href='details.php/?q=".$row[$searchIn]."&s=".$searchIn."&t=".$searchInTable."' class='btn waves-effect waves-light' target='_blank'>VIEW details</a></td>";
				$value.="<td class='center'><a href='details.php/?q=".$row['pcb_no']."&t=".$searchInTable."' class='btn waves-effect waves-light' target='_blank'>VIEW details</a></td>";
				$value.="<td class='center'><a href='print.php/?q=".$row['pcb_no']."' class='btn waves-effect waves-light blue-grey' target='_blank'>PRINT</a></td>";
				$value.="</tr></center>";
			}
			echo $value."</table>";
		}
		else {
			echo($sql);		// UNCOMMENT THIS LATER
			die("<br><p style='color: red; font-weight: bold;'>Failed to search!</p>");
		}
	}
?>
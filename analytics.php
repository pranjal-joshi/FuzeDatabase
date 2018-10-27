
<?php

	//error_reporting(0);
	
	include("db_config.php");

	function vendorToNumeric($alphanumeric) {
		preg_match_all('/([0-9]+|[a-zA-Z]+)/',$alphanumeric,$arr);
		$data = $arr[0];
		for($i=0;$i<sizeof($data);$i++) {
			if(!is_numeric($data[$i])) {
				$data[$i] = ord($data[$i]);
			}
		}
		$append = "";
		for($i=0;$i<sizeof($data);$i++) {
			$append.=strval($data[$i]);
		}
		return $append;
	}

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if($_POST['select'] == "rejection") {

			if($_POST['fuze_type'] == "PROX" || $_POST['fuze_type'] == "EPD") {

				if($_POST['main_lot'] != "*") {

					$qaRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='Q/A' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."' AND `main_lot` = '".$_POST['main_lot']."'";
					$qaRejectionGraphResult = mysqli_query($db, $qaRejectionGraphQuery);

					$pcbRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='PCB' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."' AND `main_lot` = '".$_POST['main_lot']."'";
					$pcbRejectionGraphResult = mysqli_query($db, $pcbRejectionGraphQuery);

					$housingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='HOUSING' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."' AND `main_lot` = '".$_POST['main_lot']."'";
					$housingRejectionGraphResult = mysqli_query($db, $housingRejectionGraphQuery);

					$pottingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='POTTING' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."' AND `main_lot` = '".$_POST['main_lot']."'";
					$pottingRejectionGraphResult = mysqli_query($db, $pottingRejectionGraphQuery);

					$puPottingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='PU POTTING' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."' AND `main_lot` = '".$_POST['main_lot']."'";
					$puPottingRejectionGraphResult = mysqli_query($db, $puPottingRejectionGraphQuery);

					$headRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='ELECTRONIC HEAD' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."' AND `main_lot` = '".$_POST['main_lot']."'";
					$headRejectionGraphResult = mysqli_query($db, $headRejectionGraphQuery);

					try {
						$rejectionData = array(
						array("label"=>"VISUAL","symbol"=>"VISUAL","y"=>mysqli_num_rows($qaRejectionGraphResult)),
						array("label"=>"PCB","symbol"=>"PCB","y"=>mysqli_num_rows($pcbRejectionGraphResult)),
						array("label"=>"HOUSING","symbol"=>"HOUSING","y"=>mysqli_num_rows($housingRejectionGraphResult)),
						array("label"=>"POTTING","symbol"=>"POTTING","y"=>mysqli_num_rows($pottingRejectionGraphResult)),
						array("label"=>"PU POTTING","symbol"=>"PU POTTING","y"=>mysqli_num_rows($puPottingRejectionGraphResult)),
						array("label"=>"ELECTRONIC HEAD","symbol"=>"ELECTRONIC HEAD","y"=>mysqli_num_rows($headRejectionGraphResult))
						);
						die(json_encode($rejectionData, JSON_NUMERIC_CHECK));
					}
					catch(Exception $e){
						die($e);
					}
				}
				else {
					$qaRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='Q/A' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."'";
					$qaRejectionGraphResult = mysqli_query($db, $qaRejectionGraphQuery);

					$pcbRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='PCB' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."'";
					$pcbRejectionGraphResult = mysqli_query($db, $pcbRejectionGraphQuery);

					$housingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='HOUSING' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."'";
					$housingRejectionGraphResult = mysqli_query($db, $housingRejectionGraphQuery);

					$pottingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='POTTING' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."'";
					$pottingRejectionGraphResult = mysqli_query($db, $pottingRejectionGraphQuery);

					$puPottingRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='PU POTTING' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."'";
					$puPottingRejectionGraphResult = mysqli_query($db, $puPottingRejectionGraphQuery);

					$headRejectionGraphQuery = "SELECT `_id` from `lot_table` WHERE `rejected`='1' AND `rejection_stage`='ELECTRONIC HEAD' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`fuze_type` = '".$_POST['fuze_type']."'";
					$headRejectionGraphResult = mysqli_query($db, $headRejectionGraphQuery);

					try {
						$rejectionData = array(
						array("label"=>"VISUAL","symbol"=>"VISUAL","y"=>mysqli_num_rows($qaRejectionGraphResult)),
						array("label"=>"PCB","symbol"=>"PCB","y"=>mysqli_num_rows($pcbRejectionGraphResult)),
						array("label"=>"HOUSING","symbol"=>"HOUSING","y"=>mysqli_num_rows($housingRejectionGraphResult)),
						array("label"=>"POTTING","symbol"=>"POTTING","y"=>mysqli_num_rows($pottingRejectionGraphResult)),
						array("label"=>"PU POTTING","symbol"=>"PU POTTING","y"=>mysqli_num_rows($puPottingRejectionGraphResult)),
						array("label"=>"ELECTRONIC HEAD","symbol"=>"ELECTRONIC HEAD","y"=>mysqli_num_rows($headRejectionGraphResult))
						);
						die(json_encode($rejectionData, JSON_NUMERIC_CHECK));
					}
					catch(Exception $e){
						die($e);
					}
				}
			}
		}
		elseif($_POST['select'] == "vendor_rejection") {
			$nameArray = array();
			$startArray = array();
			$stopArray = array();
			$startAlphanumericArray = array();
			$stopAlphanumericArray = array();

			$vendorSeriesSql = "SELECT * FROM `vendor_pcb_series_table` WHERE `fuze_type` = '".$_POST['fuze_type']."'";
			$vendorResults = mysqli_query($db, $vendorSeriesSql);

			while ($row = mysqli_fetch_assoc($vendorResults)) {
				array_push($nameArray, $row['vendor_name']);
				array_push($startArray, $row['series_start']);
				array_push($stopArray, $row['series_stop']);
				array_push($startAlphanumericArray, $row['series_start_alphanumeric']);
				array_push($stopAlphanumericArray, $row['series_stop_alphanumeric']);
			}

			$counter = sizeof($startArray);

			if($_POST['main_lot'] == "*") {
				$rejectedSql = "SELECT `pcb_no` FROM `lot_table` WHERE `fuze_type`='".$_POST['fuze_type']."' AND `rejected`='1' AND `fuze_diameter`='".$_POST['fuze_diameter']."'";
			}
			else {
				$rejectedSql = "SELECT `pcb_no` FROM `lot_table` WHERE `fuze_type`='".$_POST['fuze_type']."' AND `rejected`='1' AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `main_lot`='".$_POST['main_lot']."'";	
			}
			$rejectedResult = mysqli_query($db, $rejectedSql);

			$pcbNos = array();
			$vendors = array();

			while ($row = mysqli_fetch_assoc($rejectedResult)) {
				$numeric = vendorToNumeric($row['pcb_no']);
				array_push($pcbNos, $row['pcb_no']);
				for($i=0;$i<$counter;$i++) {
					if(($numeric >= $startArray[$i]) && ($numeric <= $stopArray[$i])) {
						array_push($vendors, $nameArray[$i]);
						break;
					}
				}
			}

			$vendorWiseRejection = array_count_values($vendors);
			$uniqueVendorNames = array_unique($vendors);

			$keysForVendors = array();
			for($i=0;$i<sizeof(array_keys(array_unique($vendors)));$i++) {
				array_push($keysForVendors, array_keys(array_unique($vendors))[$i]);
			}


			$vendorNames = array();
			for($i=0;$i<sizeof($keysForVendors);$i++) {
				array_push($vendorNames, $uniqueVendorNames[$keysForVendors[$i]]);
			}

			try {
				$rejectionData = array();
				for ($i=0; $i<sizeof($vendorNames);$i++) { 
					array_push($rejectionData, array("label"=>$vendorNames[$i],"symbol"=>$vendorNames[$i],"y"=>$vendorWiseRejection[$vendorNames[$i]]));
				}
				die(json_encode($rejectionData, JSON_NUMERIC_CHECK));
			}
			catch(Exception $e){
				die($e);
			}
		}
		elseif($_POST['select'] == "production") {

			if($_POST['process'] != 'all') {

				$table_name = "";
				$column_name = "record_date";
				$sql = "";

				if($_POST['process'] == "calibration" && $_POST['fuze_type'] == "PROX") {
					$table_name = "calibration_table";
					$column_name = "timestamp";
				}
				elseif ($_POST['process'] == "Q/A") {
					$table_name = "qa_table";
				}
				elseif ($_POST['process'] == "pcb Testing") {		// edit like this for other tables-EPD
					if($_POST['fuze_type'] == "PROX") {
						$table_name = "pcb_testing";
					}
					elseif ($_POST['fuze_type'] == "EPD") {
						$table_name = "pcb_epd_csv";
					}
				}
				elseif ($_POST['process'] == "housing Testing") {
					$table_name = "housing_table";
				}
				elseif ($_POST['process'] == "potted Housing Testing") {
					$table_name = "potting_table";
				}
				elseif ($_POST['process'] == "electronic head") {
					$table_name = "after_pu";
				}

				$productionData = array();
				$productionSql = "";

				for($i=1;$i<=$_POST['days_in_month'];$i++) {

					if($_POST['fuze_type'] == "PROX") {
						$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `".$table_name."`.`pcb_no` = `lot_table`.`pcb_no` WHERE `".$column_name."` = STR_TO_DATE('".strval($i)." ".$_POST['month']."','%e %M, %Y') AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."'";
					}
					else if($_POST['fuze_type'] == "EPD") {	// modified query for EPD
						$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `lot_table`.`pcb_no` LIKE CONCAT('%',`".$table_name."`.`pcb_no`) WHERE `".$column_name."` = STR_TO_DATE('".strval($i)." ".$_POST['month']."','%e %M, %Y') AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."'";
					}

					//print_r($productionSql);

					$productionResult = mysqli_query($db, $productionSql);
					array_push($productionData, 
						array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
					);
				}
				die(json_encode($productionData, JSON_NUMERIC_CHECK));
			}
			else {
				$sql = "";
				$productionDataAll = array();
				$productionCalibrationData = array();
				$productionQaData = array();
				$productionPcbData = array();
				$productionHousingData = array();
				$productionPottingData = array();
				$productionAfterPuData = array();

				$table_name = "calibration_table";
				$column_name = "timestamp";

				for($i=1;$i<=$_POST['days_in_month'];$i++) {

					$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `".$table_name."`.`pcb_no` = `lot_table`.`pcb_no` WHERE `".$column_name."` = STR_TO_DATE('".strval($i)." ".$_POST['month']."','%e %M, %Y') AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."'";

					$productionResult = mysqli_query($db, $productionSql);
					array_push($productionCalibrationData, 
						array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
					);
				}

				$column_name = "record_date";

				$table_name = "qa_table";
				for($i=1;$i<=$_POST['days_in_month'];$i++) {

					$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `".$table_name."`.`pcb_no` = `lot_table`.`pcb_no` WHERE `".$column_name."` = STR_TO_DATE('".strval($i)." ".$_POST['month']."','%e %M, %Y') AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."'";

					$productionResult = mysqli_query($db, $productionSql);
					array_push($productionQaData, 
						array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
					);
				}

				$table_name = "pcb_testing";
				for($i=1;$i<=$_POST['days_in_month'];$i++) {

					$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `".$table_name."`.`pcb_no` = `lot_table`.`pcb_no` WHERE `".$column_name."` = STR_TO_DATE('".strval($i)." ".$_POST['month']."','%e %M, %Y') AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."'";

					$productionResult = mysqli_query($db, $productionSql);
					array_push($productionPcbData, 
						array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
					);
				}

				$table_name = "housing_table";
				for($i=1;$i<=$_POST['days_in_month'];$i++) {

					$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `".$table_name."`.`pcb_no` = `lot_table`.`pcb_no` WHERE `".$column_name."` = STR_TO_DATE('".strval($i)." ".$_POST['month']."','%e %M, %Y') AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."'";

					$productionResult = mysqli_query($db, $productionSql);
					array_push($productionHousingData, 
						array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
					);
				}

				$table_name = "potting_table";
				for($i=1;$i<=$_POST['days_in_month'];$i++) {

					$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `".$table_name."`.`pcb_no` = `lot_table`.`pcb_no` WHERE `".$column_name."` = STR_TO_DATE('".strval($i)." ".$_POST['month']."','%e %M, %Y') AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."'";

					$productionResult = mysqli_query($db, $productionSql);
					array_push($productionPottingData, 
						array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
					);
				}

				$table_name = "after_pu";
				for($i=1;$i<=$_POST['days_in_month'];$i++) {

					$productionSql = "SELECT `".$table_name."`.`_id` FROM `".$table_name."` JOIN `lot_table` ON `".$table_name."`.`pcb_no` = `lot_table`.`pcb_no` WHERE `".$column_name."` = STR_TO_DATE('".strval($i)." ".$_POST['month']."','%e %M, %Y') AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."'";

					$productionResult = mysqli_query($db, $productionSql);
					array_push($productionAfterPuData, 
						array("x"=>$i, "y"=>mysqli_num_rows($productionResult))
					);
				}

				$productionData = array();
				array_push($productionData, $productionQaData);
				array_push($productionData, $productionPcbData);
				array_push($productionData, $productionHousingData);
				array_push($productionData, $productionPottingData);
				array_push($productionData, $productionCalibrationData);
				array_push($productionData, $productionAfterPuData);
				die(json_encode($productionData, JSON_NUMERIC_CHECK));
			}
		}
		elseif($_POST['select'] == "total_rejection") {

			$totalRejectionData = array();
			$totalProductionData = array();
			$finalChartData = array();

			$uniqueLotsSql = "SELECT DISTINCT(`main_lot`) FROM `lot_table` WHERE `fuze_diameter`= '".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."' ORDER BY `main_lot` ASC";

			$uniqueLotsResult = mysqli_query($db, $uniqueLotsSql);

			while ($row = mysqli_fetch_assoc($uniqueLotsResult)) {
				$rejectionSql = "SELECT `_id` FROM `lot_table` WHERE `fuze_diameter`= '".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."' AND `rejected` = '1' AND `main_lot` = '".$row['main_lot']."'";

				$productionSql = "SELECT `_id` FROM `lot_table` WHERE `fuze_diameter`= '".$_POST['fuze_diameter']."' AND `fuze_type`='".$_POST['fuze_type']."' AND `rejected` = '0' AND `main_lot` = '".$row['main_lot']."'";

				$rejectionResult = mysqli_query($db, $rejectionSql);
				$productionResult = mysqli_query($db, $productionSql);

				array_push($totalRejectionData, array("label"=>"LOT ".$row['main_lot'],"y"=>mysqli_num_rows($rejectionResult)));
				array_push($totalProductionData, array("label"=>"LOT ".$row['main_lot'],"y"=>mysqli_num_rows($productionResult)));
			}

			array_push($finalChartData, $totalProductionData);
			array_push($finalChartData, $totalRejectionData);

			die(json_encode($finalChartData, JSON_NUMERIC_CHECK));
		}
		elseif($_POST['select'] == "vendor_rejection_details") {
			
			$nameArray = array();
			$startArray = array();
			$stopArray = array();
			$startAlphanumericArray = array();
			$stopAlphanumericArray = array();
			$pcbArray = array();

			$vendorSeriesSql = "SELECT * FROM `vendor_pcb_series_table` WHERE `fuze_type` = '".$_POST['fuze_type']."' AND `vendor_name`='".$_POST['vendor_name']."'";
			$vendorResults = mysqli_query($db, $vendorSeriesSql);

			while ($row = mysqli_fetch_assoc($vendorResults)) {
				//array_push($nameArray, $row['vendor_name']);
				array_push($startArray, $row['series_start']);
				array_push($stopArray, $row['series_stop']);
				array_push($startAlphanumericArray, $row['series_start_alphanumeric']);
				array_push($stopAlphanumericArray, $row['series_stop_alphanumeric']);
			}

			$counter = sizeof($startArray);

			if($_POST['main_lot'] == "*") {
				$rejectedSql = "SELECT `pcb_no`,`rejection_remark` FROM `lot_table` WHERE `fuze_type`='".$_POST['fuze_type']."' AND `rejected`='1' AND `fuze_diameter`='".$_POST['fuze_diameter']."'";
			}
			else {
				$rejectedSql = "SELECT `pcb_no`,`rejection_remark` FROM `lot_table` WHERE `fuze_type`='".$_POST['fuze_type']."' AND `rejected`='1' AND `fuze_diameter`='".$_POST['fuze_diameter']."' AND `main_lot`='".$_POST['main_lot']."'";	
			}
			$rejectedResult = mysqli_query($db, $rejectedSql);

			$pcbNos = array();
			$rejectionRemark = array();
			$vendors = array();

			while ($row = mysqli_fetch_assoc($rejectedResult)) {
				$numeric = vendorToNumeric($row['pcb_no']);
				for($i=0;$i<$counter;$i++) {
					if(($numeric >= $startArray[$i]) && ($numeric <= $stopArray[$i])) {
						array_push($pcbNos, $row['pcb_no']);
						array_push($rejectionRemark, $row['rejection_remark']);
						break;
					}
				}
			}

			$htmlTable = "";
			for ($i=0; $i<sizeof($pcbNos);$i++) { 
				$htmlTable.="<tr>";
				$htmlTable.="<td>".$pcbNos[$i]."</td>";
				$htmlTable.="<td>".$rejectionRemark[$i]."</td>";
				$htmlTable.="</tr>";
			}
			die($htmlTable);
		}

		elseif($_POST['select'] == "rejection_details") {

			if($_POST['main_lot'] != "*") {

				if($_POST['rejection_stage'] == "ELECTRONIC HEAD" && $_POST['fuze_type'] == "PROX")
				{
					$detailsSql = "SELECT `lot_table`.`rejection_remark`,`lot_table`.`pcb_no`,`after_pu`.`bpf_ac`,`after_pu`.`bpf_noise_ac` FROM `lot_table` JOIN `after_pu` ON `lot_table`.`pcb_no`=`after_pu`.`pcb_no` WHERE `lot_table`.`fuze_type` = 'PROX' AND `lot_table`.`rejection_stage` = 'ELECTRONIC HEAD' AND `lot_table`.`fuze_diameter` = '".$_POST['fuze_diameter']."' AND `main_lot` = '".$_POST['main_lot']."'";

					$detailsRes = mysqli_query($db, $detailsSql);

					$htmlTable = "";
					while ($row = mysqli_fetch_assoc($detailsRes)) {
						$htmlTable.="<tr>";
						$htmlTable.="<td>".$row['pcb_no']."</td>";
						$htmlTable.="<td>".$row['bpf_ac']."</td>";
						$htmlTable.="<td>".$row['bpf_noise_ac']."</td>";
						$htmlTable.="<td>".$row['rejection_remark']."</td>";
						$htmlTable.="</tr>";
					}
					die($htmlTable);
				}
				else 
				{
					$detailsSql = "SELECT `pcb_no`,`rejection_remark` FROM `lot_table` WHERE 
						`rejection_stage`='".$_POST['rejection_stage']."' AND 
						`fuze_type`='".$_POST['fuze_type']."' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."' AND
						`main_lot` = '".$_POST['main_lot']."'
					";

					$detailsRes = mysqli_query($db, $detailsSql);

					$htmlTable = "";
					while ($row = mysqli_fetch_assoc($detailsRes)) {
						$htmlTable.="<tr>";
						$htmlTable.="<td>".$row['pcb_no']."</td>";
						$htmlTable.="<td>".$row['rejection_remark']."</td>";
						$htmlTable.="</tr>";
					}
					die($htmlTable);
				}
			}
			else {
				if($_POST['rejection_stage'] == "ELECTRONIC HEAD" && $_POST['fuze_type'] == "PROX")
				{
					$detailsSql = "SELECT `lot_table`.`rejection_remark`,`lot_table`.`pcb_no`,`after_pu`.`bpf_ac`,`after_pu`.`bpf_noise_ac` FROM `lot_table` JOIN `after_pu` ON `lot_table`.`pcb_no`=`after_pu`.`pcb_no` WHERE `lot_table`.`fuze_type` = 'PROX' AND `lot_table`.`rejection_stage` = 'ELECTRONIC HEAD' AND `lot_table`.`fuze_diameter` = '".$_POST['fuze_diameter']."'";

					$detailsRes = mysqli_query($db, $detailsSql);

					$htmlTable = "";
					while ($row = mysqli_fetch_assoc($detailsRes)) {
						$htmlTable.="<tr>";
						$htmlTable.="<td>".$row['pcb_no']."</td>";
						$htmlTable.="<td>".$row['bpf_ac']."</td>";
						$htmlTable.="<td>".$row['bpf_noise_ac']."</td>";
						$htmlTable.="<td>".$row['rejection_remark']."</td>";
						$htmlTable.="</tr>";
					}
					die($htmlTable);
				}
				else 
				{
					$detailsSql = "SELECT `pcb_no`,`rejection_remark` FROM `lot_table` WHERE 
						`rejection_stage`='".$_POST['rejection_stage']."' AND 
						`fuze_type`='".$_POST['fuze_type']."' AND 
						`fuze_diameter` = '".$_POST['fuze_diameter']."';
					";

					$detailsRes = mysqli_query($db, $detailsSql);

					$htmlTable = "";
					while ($row = mysqli_fetch_assoc($detailsRes)) {
						$htmlTable.="<tr>";
						$htmlTable.="<td>".$row['pcb_no']."</td>";
						$htmlTable.="<td>".$row['rejection_remark']."</td>";
						$htmlTable.="</tr>";
					}
					die($htmlTable);
				}
			}
		}
	}
	else {
		echo "
		<!DOCTYPE html>
			<html>

			<style type='text/css'>
					.analyticsBody {
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

				<title>Fuze-Analytics</title>
			</head>
		";
	}

	if(!isset($_COOKIE['fuzeAccess']) || $_COOKIE["fuzeAccess"] == "EFB2A684E4AFB7D55E6147FBE5A332EE"){
		die("
				<body class='analyticsBody'>
				<main class='contents'>

				<nav>
					<div class='nav-wrapper red lighten-2' id='analyticsNav'>
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
?>

	<body class="analyticsBody">

		<main class="contents">
			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper teal lighten-2" id="analyticsNav">
						<a href="#!" class="brand-logo center" id="analyticsNavTitle">Fuze Database Analytics</a>
						<a onclick="self.close();">
							<span class='white-text text-darken-5' style="font-size: 18px; padding-left: 20px; font-weight: bold">Back</span>
						</a>
					</div>
				</nav>
			</div>

			<!-- Analytics modal -->
			<div id="analyticsModal" class="modal">
				<div class="modal-content">
					<center>
						<span class="teal-text text-darken-2" id="analyticsModalHeader" style="font-weight: bold; font-size: 24px;">Rejection Details</span>
						<br>
						<br>
						<div class="row">
							<table class="striped" id="rejection_details_table">
								<thead>
									<tr>
										<th>PCB Number</th>
										<th>Remark</th>
									</tr>
								</thead>
								<tbody id="rejection_details_tbody"></tbody>
							</table>
							<table class="striped" id="rejection_details_table_prox_head" style="display: none;">
								<thead>
									<tr>
										<th>PCB Number</th>
										<th>BPF AC<br>Volt</th>
										<th>BPF Noise AC<br>Volt</th>
										<th>Remark</th>
									</tr>
								</thead>
								<tbody id="rejection_details_tbody_prox_head"></tbody>
							</table>
						</div>
					</center>
				</div>
				<div class="modal-footer">
					<center>
						<a href="#" class="btn-flat waves-light waves-red waves-effect" onclick="$('#analyticsModal').closeModal();$('#rejection_details_table').show();$('#rejection_details_table_prox_head').hide();">BACK</a>
						<a href="rejection.php" target="_blank" class="btn-flat waves-light waves-red waves-effect">Go to rejection</a>
					</center>
				</div>
			</div>

			<!-- Vendor wise Rejection Modal -->
			<div id="vendorWiseRejectionModal" class="modal">
				<div class="modal-content">
					<center>
						<span class="teal-text text-darken-2" id="vendorWiseRejectionHeader" style="font-weight: bold; font-size: 24px;">Rejection Details</span>
						<br>
						<br>
						<div class="row">
							<table class="striped center" id="vendor_rejection_details_table">
								<thead>
									<tr>
										<th>PCB Number</th>
										<th>Rejection Remark</th>
									</tr>
								</thead>
								<tbody id="vendor_rejection_details_tbody"></tbody>
							</table>
						</div>
					</center>
				</div>
				<div class="modal-footer">
					<center>
						<a href="#" class="btn-flat waves-light waves-red waves-effect" onclick="$('#vendorWiseRejectionModal').closeModal();$('#vendor_rejection_details_table').show();">BACK</a>
						<a href="rejection.php" target="_blank" class="btn-flat waves-light waves-red waves-effect">Go to rejection</a>
					</center>
				</div>
			</div>

			<div class="row">
				<div class="col m2"></div>
				<div class="col m8 s12">

					<br>
					<div class="card-panel grey lighten-4" id="analyticsCard">
						<div class="row">

							<div class="input-field col s4">
								<select name="analytics_select" id="analytics_select" onchange="whatToShow(this.value)">
									<option value="" selected disabled>-- Select --</option>
									<option value="rejection">Rejection Details</option>
									<option value="production">Prodution Details</option>
									<option value="vendor_rejection">Vendor wise Rejection</option>
									<option value="total_rejection">Total Rejection</option>
								</select>
								<label>Select criteria</label>
							</div>

							<div class="input-field col s3" style="display: none;" id="analytics_fuze_type_div">
							<select name="analytics_fuze_type" id="analytics_fuze_type">
								<option value="" disabled selected>-- select --</option>
								<option value="EPD">EPD</option>
								<option value="TIME">TIME</option>
								<option value="PROX">PROX</option>
							</select>
							<label>Select Fuze Type</label>
						</div>

						<div class="input-field col s3" style="display: none;" id="analytics_fuze_diameter_div">
							<select name="analytics_fuze_diameter" id="analytics_fuze_diameter" required>
								<option value="" selected disabled>--Select--</option>
								<option value="105">105 mm</option>
								<option value="155">155 mm</option>
							</select>
							<label>Gun Type</label>
						</div>

						<div class='input-field col s2' style="display: none;" id='analytics_main_lot_div'>
							<input type='text' id='analytics_main_lot' class='tooltipped' data-position='bottom' data-delay='250' data-tooltip='Use * to select all lots'>
							<label for='analytics_main_lot'>Main Lot No.</label>
						</div>

					</div>

					<div class="row" id="production_select_row" style="display: none;">
						<div class="input-field col s6" id="analytics_process_div">
							<select name="analytics_proess" id="analytics_process" required>
								<option value="" selected disabled>--Select--</option>
								<option value="all">All</option>
								<option value="Q/A">Visual (Q/A)</option>
								<option value="calibration">Calibration</option>
								<option value="pcb Testing">PCB Testing</option>
								<option value="housing Testing">Housing Testing</option>
								<option value="potted Housing Testing">Potted Housing Testing</option>
								<option value="electronic head">Electronic Head</option>
							</select>
							<label>Process</label>
						</div>

						<label for="analytics_month" style="margin-left: 30px;">Select month</label>
						<br>
						<input type="month" name="analytics_month" id="analytics_month" style="margin-left: 30px;">
					</div>

					<div class="row">
						<center>
							<a class="btn waves-effect waves-light" id="analyticsShowButton">SHOW</a>
							<br>
							<br>
							<span class="red-text text-darken-3" id="analytics_detail_span" style="display: none;">Click on the pie-chart for more details</span>
						</center>
					</div>

					</div>
					<br>
					<div id="chartContainer" style="width: 100%, height: 200px;"></div>

				</div>
			</div>

		</main>
	</body>

	<script type="text/javascript">

		$('select').material_select();

		$('#analyticsCard').keypress(function (e) {
			var key = e.which || e.keyCode;
			if(key == 13)  // the enter key code
			{
				$('#analyticsShowButton').trigger('click');
				return false;  
			}
		});

		var monthlyCount;
		var finalMonthlyCount=0;
		var chart;
		$('#analyticsShowButton').click(function(){

			if($('#analytics_select :selected').val() == "rejection") {

				if($('#analytics_fuze_diameter :selected').val() == '' || $('#analytics_fuze_type :selected').val() == '' || $('#analytics_main_lot').val() == '') {
					Materialize.toast("Please select the required fields!",3000,'rounded');
					$('#analytics_main_lot').focus();
				}
				else {
					$('#analytics_detail_span').html('Click on the pie-chart for more details');
					$('#analytics_detail_span').fadeIn();
					$.ajax({
						type: 'POST',
						data: {
							select: $('#analytics_select :selected').val(),
							fuze_type: $('#analytics_fuze_type :selected').val(),
							fuze_diameter: $('#analytics_fuze_diameter :selected').val(),
							main_lot: $('#analytics_main_lot').val()
						},
						success: function(msg) {
							console.log(msg);
							chart = new CanvasJS.Chart("chartContainer",{
									theme: 'light2',
									exportEnabled: true,
									animationEnabled: 'true',
									title: {
										text: 'Rejection Analysis for ' + $('#analytics_fuze_diameter :selected').val() + ' mm ' + $('#analytics_fuze_type :selected').val() + ' Fuze - LOT ' + ($('#analytics_main_lot').val() == "*"? "ALL" : $('#analytics_main_lot').val())
									},
									data: [{
										type: 'doughnut',
										indexLabelFormatter: function(e) {
											console.log(e);
											if (e.percent == 0)
												return "";
											else
												return e.dataPoint.label + " - " + e.percent.toFixed(2) + "%";
										},
										showInLegend: true,
										legendText: "{label} : {y} - #percent%",
										click: onChartClick,
										dataPoints: JSON.parse(msg)
									}]
							});
							$('#chartContainer').fadeIn();
							renderChart(chart, "No Data Available");
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							 alert(errorThrown + 'Is web-server offline?');
						}
					});
				}
			}
			else if($('#analytics_select :selected').val() == "production") {
				if($('#analytics_fuze_diameter :selected').val() == '' || $('#analytics_fuze_type :selected').val() == '' || selectedMonth == "" || $('#analytics_process :selected').val() == '') {
					Materialize.toast("Please select the required fields!",3000,'rounded');
				}
				else {
					$.ajax({
						type: 'POST',
						data: {
							select: $('#analytics_select :selected').val(),
							fuze_type: $('#analytics_fuze_type :selected').val(),
							fuze_diameter: $('#analytics_fuze_diameter :selected').val(),
							process: $('#analytics_process :selected').val(),
							month: selectedMonth,
							days_in_month: daysInMonth
						},
						success: function(msg) {
							console.log(msg);
							if(JSON.parse(msg).length < 27) {			// only valid if 'all' selected from UI
								jsonMsg = JSON.stringify(JSON.parse(msg)[0]);
								var monthlyCount = JSON.parse(jsonMsg);
								for(var i=0;i<monthlyCount.length;i++) {
									finalMonthlyCount += monthlyCount[i]['y'];
								}
								finalMonthlyCount = 0;
								var chart = new CanvasJS.Chart("chartContainer", {
									animationEnabled: true,
									exportEnabled: true,
									theme: "light2",
									title: {
										text: ($('#analytics_process :selected').val().charAt(0).toUpperCase() + $('#analytics_process :selected').val().slice(1)) + " of " + $('#analytics_fuze_diameter :selected').val() + " mm " + $('#analytics_fuze_type :selected').val() + " Fuze in " + selectedMonth
									},
									toolTip:{   
										content: "{name} - Date {x} : Count {y}" 
									},
									axisX: {
										title: "Days",
									},
									axisY: {
										title: "Prodution rate",
										includeZero: false
									},
									data: [
									{
										type: "line",
										legendText: "Q/A",
										name: "Q/A",
										showInLegend: true,
										dataPoints: JSON.parse(msg)[0]
									},
									{
										type: "line",
										legendText: "PCB",
										name: "PCB",
										showInLegend: true,
										dataPoints: JSON.parse(msg)[1]
									},
									{
										type: "line",
										legendText: "Housing",
										name: "Housing",
										showInLegend: true,
										dataPoints: JSON.parse(msg)[2]
									},
									{
										type: "line",
										legendText: "Potting",
										name: "Potting",
										showInLegend: true,
										dataPoints: JSON.parse(msg)[3]
									},
									{
										type: "line",
										legendText: "Calibration",
										name: "Calibration",
										showInLegend: true,
										dataPoints: JSON.parse(msg)[4]
									},
									{
										type: "line",
										legendText: "Elec. Head",
										name: "Elec. Head",
										showInLegend: true,
										dataPoints: JSON.parse(msg)[5]
									}
									]
								});
								$('#chartContainer').fadeIn();
								chart.render();
								$('#chartContainer').css({"margin-bottom":"100px"});
							}
							else {
								var monthlyCount = JSON.parse(msg);
								for(var i=0;i<monthlyCount.length;i++) {
									finalMonthlyCount += monthlyCount[i]['y'];
								}
								$('#analytics_detail_span').html('Cumulative count for ' + selectedMonth + " is " + finalMonthlyCount.toString());
								$('#analytics_detail_span').fadeIn();
								finalMonthlyCount = 0;
								var chart = new CanvasJS.Chart("chartContainer", {
									animationEnabled: true,
									exportEnabled: true,
									theme: "light2",
									title: {
										text: ($('#analytics_process :selected').val().charAt(0).toUpperCase() + $('#analytics_process :selected').val().slice(1)) + " of " + $('#analytics_fuze_diameter :selected').val() + " mm " + $('#analytics_fuze_type :selected').val() + " Fuze in " + selectedMonth
									},
									axisX: {
										title: "Days",
									},
									axisY: {
										title: "Prodution rate",
										includeZero: false
									},
									data: [{
										type: "line",
										lineColor: "#009688",
										color: "#00897b",
										dataPoints: JSON.parse(msg)
									}]
								});
								$('#chartContainer').fadeIn();
								chart.render();
								$('#chartContainer').css({"margin-bottom":"100px"});
								}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							 alert(errorThrown + 'Is web-server offline?');
						}
					});
				}
			}
			else if($('#analytics_select :selected').val() == "total_rejection") {
				if($('#analytics_fuze_diameter :selected').val() == '' || $('#analytics_fuze_type :selected').val() == '') {
					Materialize.toast("Please select the required fields!",3000,'rounded');
				}
				else {
					$('#analytics_detail_span').html('Hover mouse on the graph for more details');
					$('#analytics_detail_span').fadeIn();
					$.ajax({
						type: 'POST',
						data: {
							select: $('#analytics_select :selected').val(),
							fuze_type: $('#analytics_fuze_type :selected').val(),
							fuze_diameter: $('#analytics_fuze_diameter :selected').val(),
						},
						success: function(msg) {
							var productionData = JSON.parse(msg)[0];
							var rejectionData = JSON.parse(msg)[1];
							var chart = new CanvasJS.Chart("chartContainer", {
								animationEnabled: true,
								exportEnabled: true,
								theme: "light2",
								title: {
									text: "Rejection against Prodution - " + $('#analytics_fuze_diameter :selected').val() + "mm " + $('#analytics_fuze_type :selected').val() + " Fuze"
								},
								axisX: {
									title: "Lots",
								},
								axisY: {
									title: "Count",
								},
								toolTip: {
									shared: true,
									content: function(e) {
										var str = "";
										str = "<span style='color: blue; font-weight: bold; font-size: 16px;'>" + e.entries[0].dataPoint.label + "</span>";
										str += "<br>";
										str += "<span style='color: #009688; font-weight: bold'>Passed - " + e.entries[0].dataPoint.y + "</span>";
										str += "<br>";
										str += "<span style='color: #ff5252; font-weight: bold'>Rejected - " + e.entries[1].dataPoint.y + "</span>";
										str += "<br>";
										str += "<span style='color: #ff5252; font-weight: bold'>Rejection - " + (e.entries[1].dataPoint.y/(e.entries[0].dataPoint.y+e.entries[1].dataPoint.y)).toFixed(4)*100 + "%</span>";
										str += "<br>";
										str += "<span style='color: black; font-weight: bold'>Manufactured - " + (e.entries[1].dataPoint.y + e.entries[0].dataPoint.y) + "</span>";

										return str;
									}
								},
								data: [
									{
										type: "stackedColumn",
										showInLegend: true,
										name: "Passed",
										color: "#009688",
										dataPoints: productionData
									},
									{
										type: "stackedColumn",
										showInLegend: true,
										name: "Rejected",
										color: "#ff5252",
										dataPoints: rejectionData
									}
								]
							});
							$('#chartContainer').fadeIn();
							renderChart(chart, "No Data Available");
							$('#chartContainer').css({"margin-bottom":"100px"});
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							 alert(errorThrown + 'Is web-server offline?');
						}
					});
				}
			}
			else if($('#analytics_select :selected').val() == "vendor_rejection") {

				if($('#analytics_fuze_diameter :selected').val() == '' || $('#analytics_fuze_type :selected').val() == '' || $('#analytics_main_lot').val() == '') {
					Materialize.toast("Please select the required fields!",3000,'rounded');
					$('#analytics_main_lot').focus();
				}
				else {
					$('#analytics_detail_span').html('Click on the pie-chart for more details');
					$('#analytics_detail_span').fadeIn();
					$.ajax({
						type: 'POST',
						data: {
							select: $('#analytics_select :selected').val(),
							fuze_type: $('#analytics_fuze_type :selected').val(),
							fuze_diameter: $('#analytics_fuze_diameter :selected').val(),
							main_lot: $('#analytics_main_lot').val()
						},
						success: function(msg) {
							console.log(msg);
							chart = new CanvasJS.Chart("chartContainer",{
									theme: 'light2',
									exportEnabled: true,
									animationEnabled: 'true',
									title: {
										text: 'Vendor Wise Rejection for ' + $('#analytics_fuze_diameter :selected').val() + ' mm ' + $('#analytics_fuze_type :selected').val() + ' Fuze - LOT ' + ($('#analytics_main_lot').val() == "*"? "ALL" : $('#analytics_main_lot').val())
									},
									data: [{
										type: 'doughnut',
										indexLabelFormatter: function(e) {
											console.log(e);
											if (e.percent == 0)
												return "";
											else
												return e.dataPoint.label + " - " + e.percent.toFixed(2) + "%";
										},
										showInLegend: true,
										legendText: "{label} : {y} - #percent%",
										click: onVendorChartClick,
										dataPoints: JSON.parse(msg)
									}]
							});
							$('#chartContainer').fadeIn();
							renderChart(chart, "No Data Available");
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							 alert(errorThrown + 'Is web-server offline?');
						}
					});
				}
			}
			else {
				Materialize.toast("Please select the required fields!",3000,'rounded');
			}
		});

		function whatToShow(mode) {
			$('#analytics_fuze_diameter_div').fadeIn();
			$('#analytics_fuze_type_div').fadeIn();
			try {
				$('#chartContainer').fadeOut();
			}
			catch(err) {
			}
			if(mode == "production") {
				$('#production_select_row').fadeIn();
				$('#analytics_detail_span').fadeOut();
				$('#analytics_main_lot_div').fadeOut();
			}
			else if(mode == "rejection" || mode == "vendor_rejection"){
				$('#analytics_main_lot_div').fadeIn();
				$('#production_select_row').fadeOut();
				$('#analytics_detail_span').fadeOut();
			}
			else if(mode == "total_rejection") {
				$('#analytics_main_lot_div').fadeOut();
				$('#production_select_row').fadeOut();
				$('#analytics_detail_span').fadeOut();
			}
		}

		var selectedMonth = "";
		var daysInMonth = 30;

		function getMonthYear(pickString) {
			var splitString = pickString.split("-");
			var year = splitString[0];
			var month;
			switch(splitString[1]) {
				case '01':
					month = "January, ";
					daysInMonth = 31;
					break;
				case '02':
					month = "February, ";
					if(parseInt(year)%4 == 0) {
						daysInMonth = 28;
					}
					else {
						daysInMonth = 27;
					}
					break;
				case '03':
					month = "March, ";
					daysInMonth = 31;
					break;
				case '04':
					month = "April, ";
					daysInMonth = 30;
					break;
				case '05':
					month = "May, ";
					daysInMonth = 31;
					break;
				case '06':
					month = "June, ";
					daysInMonth = 30;
					break;
				case '07':
					month = "July, ";
					daysInMonth = 31;
					break;
				case '08':
					month = "August, ";
					daysInMonth = 31;
					break;
				case '09':
					month = "September, ";
					daysInMonth = 30;
					break;
				case '10':
					month = "October, ";
					daysInMonth = 31;
					break;
				case '11':
					month = "November, ";
					daysInMonth = 30;
					break;
				case '12':
					month = "December, ";
					daysInMonth = 31;
					break;
			}
			//month = "%".concat(month);
			return (month.concat(year));
		}

		$('#analytics_month').change(function(){
			selectedMonth = getMonthYear($(this).val())
		});

		function onChartClick(e) {
			$('#analyticsModalHeader').html("Rejection Details of " + e.dataPoint.label + " stage");
			$('#analyticsModal').openModal({
				complete: function() {
					$('#rejection_details_table').show();
					$('#rejection_details_table_prox_head').hide();
				}
			});
			if(e.dataPoint.label == "ELECTRONIC HEAD" && $('#analytics_fuze_type').val() == "PROX") {
				$('#rejection_details_table').hide();
				$('#rejection_details_table_prox_head').show();
			}
			$.ajax({
				type: 'POST',
				data: {
					select: 'rejection_details',
					fuze_type: $('#analytics_fuze_type :selected').val(),
					fuze_diameter: $('#analytics_fuze_diameter :selected').val(),
					rejection_stage: e.dataPoint.label,
					main_lot: $('#analytics_main_lot').val()
				},
				success: function(msg) {
					console.log(msg);
					if(e.dataPoint.label == "ELECTRONIC HEAD" && $('#analytics_fuze_type').val() == "PROX") {
						$('#rejection_details_tbody_prox_head').html(msg);
					}
					else {
						$('#rejection_details_tbody').html(msg);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert(errorThrown + 'Is web-server offline?');
				}
			});
		}

		function onVendorChartClick(e) {
			$('#vendorWiseRejectionHeader').html("Rejection Details of " + e.dataPoint.label);
			$('#vendorWiseRejectionModal').openModal({
				complete: function() {
					$('#vendor_rejection_details_table').show();
				}
			});
			$.ajax({
				type: 'POST',
				data: {
					select: 'vendor_rejection_details',
					fuze_type: $('#analytics_fuze_type :selected').val(),
					fuze_diameter: $('#analytics_fuze_diameter :selected').val(),
					vendor_name: e.dataPoint.label,
					main_lot: $('#analytics_main_lot').val()
				},
				success: function(msg) {
					console.log(msg);
					$('#vendor_rejection_details_tbody').html(msg);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert(errorThrown + 'Is web-server offline?');
				}
			});
		}

		function renderChart(chart, errorText){
			var dataPoints = chart.options.data[0].dataPoints;
			var isEmpty = !(dataPoints && dataPoints.length > 0);
		 
			if(!isEmpty){
				for(var i = 0; i < dataPoints.length; i++){
					isEmpty = !dataPoints[i].y;
					if(!isEmpty)
						break;
				}
		 	}
		
			if(isEmpty) {
				document.getElementById('chartContainer').innerHTML = "<br><center><span class='red-text text-darken-1 center' style='font-weight: bold; font-size:18px;'>" + errorText + "</span><center>";
			}
		 	else {
				chart.render();
			}
	 	}

	</script>

</html>
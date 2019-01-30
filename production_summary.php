<?php

	include('db_config.php');

	$ovfMsg = "";

	function isOverflow($submittedCount, $cumulativeCount, $lotNumber, $operation, $db) {
		$qtyQuery = "SELECT `lot_qty` FROM `fuze_production_launch` WHERE `lot_no`='".$lotNumber."'";
		$qtyRes = mysqli_query($db, $qtyQuery);
		$qtyRow = mysqli_fetch_assoc($qtyRes);
		if(($cumulativeCount + $submittedCount) > $qtyRow['lot_qty']) {
			die("<div style='color:red'>Error: </div><br>Only ".strval($qtyRow['lot_qty']-$cumulativeCount)." Qty of ".$operation." can be added to this lot.<br><br>Remaining Qty of ".strval($submittedCount-$qtyRow['lot_qty'])." must be added to the next lot.");
		}
	}

	if(isset($_COOKIE['fuzeLogin'])) {

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			$operationArray = array("VISUAL","HSG GND PIN","HSG UNMOULDED","HSG MOULDED","HEAD","BATTERY TINNING","HSG UNMOULDED","HSG MOULDED","FUZE BASE","FUZE ASSY","HEAD","VISUAL","FUZE FINAL");

			$sql = "";
			if(isset($_POST['contract_no'])) {
				$sql = "SELECT * FROM `fuze_production_launch` WHERE `lot_no`='".$_POST['lot_no']."' AND `contract_no`='".$_POST['contract_no']."'";
			}
			else {
				$sql = "SELECT * FROM `fuze_production_launch` WHERE `lot_no`='".$_POST['lot_no']."'";
			}

			$res = mysqli_query($db, $sql);
			$cnt = mysqli_num_rows($res);

			$sql1 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='TEST' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[0]."'";
			$sql2 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='TEST' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[1]."'";
			$sql3 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='TEST' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[2]."'";
			$sql4 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='TEST' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[3]."'";
			$sql5 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='TEST' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[4]."'";

			$sql6 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='ASSY' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[5]."'";
			$sql7 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='ASSY' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[6]."'";
			$sql8 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='ASSY' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[7]."'";
			$sql9 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='ASSY' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[8]."'";
			$sql10 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='ASSY' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[9]."'";
			$sql11 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='ASSY' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[10]."'";

			$sql12 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='S&A' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[11]."'";
			$sql13 = "SELECT SUM(`process_cnt`) AS `process_cnt` FROM `fuze_production_record` WHERE `stream`='S&A' AND `lot_no`='".$_POST['lot_no']."'  AND `operation`='".$operationArray[12]."'";

			$lotSizeSql = "SELECT `lot_qty` FROM `fuze_production_launch` WHERE `lot_no`='".$_POST['lot_no']."'";
			$lotSizeRes = mysqli_query($db, $lotSizeSql);
			$lotSizeRow = mysqli_fetch_assoc($lotSizeRes);

			$sql1res = mysqli_query($db, $sql1);
			$sql2res = mysqli_query($db, $sql2);
			$sql3res = mysqli_query($db, $sql3);
			$sql4res = mysqli_query($db, $sql4);
			$sql5res = mysqli_query($db, $sql5);
			$sql6res = mysqli_query($db, $sql6);
			$sql7res = mysqli_query($db, $sql7);
			$sql8res = mysqli_query($db, $sql8);
			$sql9res = mysqli_query($db, $sql9);
			$sql10res = mysqli_query($db, $sql10);
			$sql11res = mysqli_query($db, $sql11);
			$sql12res = mysqli_query($db, $sql12);
			$sql13res = mysqli_query($db, $sql13);

			$sql1row = mysqli_fetch_assoc($sql1res);
			$sql2row = mysqli_fetch_assoc($sql2res);
			$sql3row = mysqli_fetch_assoc($sql3res);
			$sql4row = mysqli_fetch_assoc($sql4res);
			$sql5row = mysqli_fetch_assoc($sql5res);
			$sql6row = mysqli_fetch_assoc($sql6res);
			$sql7row = mysqli_fetch_assoc($sql7res);
			$sql8row = mysqli_fetch_assoc($sql8res);
			$sql9row = mysqli_fetch_assoc($sql9res);
			$sql10row = mysqli_fetch_assoc($sql10res);
			$sql11row = mysqli_fetch_assoc($sql11res);
			$sql12row = mysqli_fetch_assoc($sql12res);
			$sql13row = mysqli_fetch_assoc($sql13res);

			if($_POST['task'] == 'check') {

				$cumulativeArray = array();

				array_push($cumulativeArray, array("1"=>$sql1row['process_cnt']));
				array_push($cumulativeArray, array("2"=>$sql2row['process_cnt']));
				array_push($cumulativeArray, array("3"=>$sql3row['process_cnt']));
				array_push($cumulativeArray, array("4"=>$sql4row['process_cnt']));
				array_push($cumulativeArray, array("5"=>$sql5row['process_cnt']));
				array_push($cumulativeArray, array("6"=>$sql6row['process_cnt']));
				array_push($cumulativeArray, array("7"=>$sql7row['process_cnt']));
				array_push($cumulativeArray, array("8"=>$sql8row['process_cnt']));
				array_push($cumulativeArray, array("9"=>$sql9row['process_cnt']));
				array_push($cumulativeArray, array("10"=>$sql10row['process_cnt']));
				array_push($cumulativeArray, array("11"=>$sql11row['process_cnt']));
				array_push($cumulativeArray, array("12"=>$sql12row['process_cnt']));
				array_push($cumulativeArray, array("13"=>$sql13row['process_cnt']));
				array_push($cumulativeArray, array("lot_qty"=>$lotSizeRow['lot_qty']));

				if($cnt > 0) {
					array_push($cumulativeArray, array("cnt"=>"ok"));
				}
				else {
					array_push($cumulativeArray, array("cnt"=>"invalid"));
				}

				$cumulativeArrayJson = json_encode($cumulativeArray, JSON_NUMERIC_CHECK);

				echo($cumulativeArrayJson);
			}
			elseif($_POST['task'] == 'load') {			// load data on date change

				$loadSql = "SELECT * FROM `fuze_production_record` WHERE `record_date`=STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y') AND `shift`='".$_POST['shift']."' AND `lot_no`='".$_POST['lot_no']."'";
				$loadRes = mysqli_query($db, $loadSql);

				$loadCountArray = array();
				$c = 1;
				if(mysqli_num_rows($loadRes) == 0) {
					for($i=0;$i<13;$i++) {
						array_push($loadCountArray, array("cnt"=>"", "op"=>""));
					}
				}
				else {
					while ($row = mysqli_fetch_assoc($loadRes)) {
						array_push($loadCountArray, array("cnt"=>$row['process_cnt'], "op"=>$row['op_cnt']));
					}
				}

				$loadCountArrayJson = json_encode($loadCountArray, JSON_NUMERIC_CHECK);
				echo($loadCountArrayJson);

			}
			elseif($_POST['task'] == 'report') {
				$cumulativeArray = array();

				array_push($cumulativeArray, array("1"=>$sql1row['process_cnt']));
				array_push($cumulativeArray, array("2"=>$sql2row['process_cnt']));
				array_push($cumulativeArray, array("3"=>$sql3row['process_cnt']));
				array_push($cumulativeArray, array("4"=>$sql4row['process_cnt']));
				array_push($cumulativeArray, array("5"=>$sql5row['process_cnt']));
				array_push($cumulativeArray, array("6"=>$sql6row['process_cnt']));
				array_push($cumulativeArray, array("7"=>$sql7row['process_cnt']));
				array_push($cumulativeArray, array("8"=>$sql8row['process_cnt']));
				array_push($cumulativeArray, array("9"=>$sql9row['process_cnt']));
				array_push($cumulativeArray, array("10"=>$sql10row['process_cnt']));
				array_push($cumulativeArray, array("11"=>$sql11row['process_cnt']));
				array_push($cumulativeArray, array("12"=>$sql12row['process_cnt']));
				array_push($cumulativeArray, array("13"=>$sql13row['process_cnt']));
				array_push($cumulativeArray, array("lot_qty"=>$lotSizeRow['lot_qty']));

				if($cnt > 0) {
					array_push($cumulativeArray, array("cnt"=>"ok"));
				}
				else {
					array_push($cumulativeArray, array("cnt"=>"invalid"));
				}

				$reportArray = array();

				$datesSql = "SELECT DISTINCT `record_date` FROM `fuze_production_record` WHERE `lot_no`='".$_POST['lot_no']."' ORDER BY `record_date` ASC";
				$dateRes = mysqli_query($db, $datesSql);

				while($dateRow = mysqli_fetch_assoc($dateRes)){

					$testDataCatcher = array();

					for($i=0;$i<5;$i++){
						$testSql = "SELECT SUM(`process_cnt`) AS `process_cnt`, SUM(`op_cnt`) AS `op_cnt` FROM `fuze_production_record` WHERE `record_date`='".$dateRow['record_date']."' AND `stream`='TEST' AND `operation`='".$operationArray[$i]."'";
						$testRes = mysqli_query($db, $testSql);
						$testRow = mysqli_fetch_assoc($testRes);
						if($testRow['process_cnt'] > 0){
							array_push($testDataCatcher, array("operation"=>$operationArray[$i], "cnt"=>$testRow['process_cnt'], "op_cnt"=>$testRow['op_cnt'], "stream"=>"test"));
						}
						else {
							array_push($testDataCatcher, array("operation"=>$operationArray[$i], "cnt"=>"-", "op_cnt"=>"-", "stream"=>"test"));
						}
					}
					for($i=5;$i<11;$i++){
						$testSql = "SELECT SUM(`process_cnt`) AS `process_cnt`, SUM(`op_cnt`) AS `op_cnt` FROM `fuze_production_record` WHERE `record_date`='".$dateRow['record_date']."' AND `stream`='ASSY' AND `operation`='".$operationArray[$i]."'";
						$testRes = mysqli_query($db, $testSql);
						$testRow = mysqli_fetch_assoc($testRes);
						if($testRow['process_cnt'] > 0){
							array_push($testDataCatcher, array("operation"=>$operationArray[$i], "cnt"=>$testRow['process_cnt'], "op_cnt"=>$testRow['op_cnt'], "stream"=>"assy"));
						}
						else {
							array_push($testDataCatcher, array("operation"=>$operationArray[$i], "cnt"=>"-", "op_cnt"=>"-", "stream"=>"assy"));
						}
					}
					for($i=11;$i<13;$i++){
						$testSql = "SELECT SUM(`process_cnt`) AS `process_cnt`, SUM(`op_cnt`) AS `op_cnt` FROM `fuze_production_record` WHERE `record_date`='".$dateRow['record_date']."' AND `stream`='S&A' AND `operation`='".$operationArray[$i]."'";
						$testRes = mysqli_query($db, $testSql);
						$testRow = mysqli_fetch_assoc($testRes);
						if($testRow['process_cnt'] > 0){
							array_push($testDataCatcher, array("operation"=>$operationArray[$i], "cnt"=>$testRow['process_cnt'], "op_cnt"=>$testRow['op_cnt'], "stream"=>"S&A"));
						}
						else {
							array_push($testDataCatcher, array("operation"=>$operationArray[$i], "cnt"=>"-", "op_cnt"=>"-", "stream"=>"S&A"));
						}
					}
					array_push($reportArray, array('date'=>$dateRow['record_date'],"data"=>$testDataCatcher));
				}

				$reportArray = array("cumulativeArray"=>$cumulativeArray,"reportArray"=>$reportArray);

				$reportArrayJson = json_encode($reportArray, JSON_NUMERIC_CHECK);
				echo $reportArrayJson;
			}
			elseif($_POST['task'] == 'save') {
				$tblSql = "CREATE TABLE IF NOT EXISTS `fuze_database`.`fuze_production_record` ( `_id` INT NOT NULL AUTO_INCREMENT , `fuze_type` VARCHAR(4) NOT NULL , `fuze_diameter` VARCHAR(4) NOT NULL , `record_date` DATE NOT NULL , `stream` VARCHAR(4) NOT NULL , `operation` TEXT NOT NULL , `process_cnt` INT NOT NULL , `op_cnt` INT NOT NULL , `shift` VARCHAR(10) NOT NULL , `lot_no` VARCHAR(20) NOT NULL , `remark` TEXT , PRIMARY KEY (`_id`)) ENGINE = InnoDB COMMENT = 'holds production & cumulative count info';";
				$tblRes = mysqli_query($db, $tblSql);

				unset($_POST['summaryData']['0']);
				unset($_POST['summaryData']['1']);
				unset($_POST['summaryData']['2']);
				unset($_POST['summaryData']['3']);

				$fetchSql = "SELECT * FROM `fuze_production_launch` WHERE `lot_no`='".$_POST['lot_no']."'";
				$fetchRes = mysqli_query($db, $fetchSql);
				$fetchRow = mysqli_fetch_assoc($fetchRes);
				$fuze_type = $fetchRow['fuze_type'];
				$fuze_diameter = $fetchRow['fuze_diameter'];

				$delSql = "DELETE FROM `fuze_production_record` WHERE `record_date`=STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y') AND `shift`='".$_POST['shift']."' AND `lot_no`='".$_POST['lot_no']."'";
				$delRes = mysqli_query($db, $delSql);

				$sd = $_POST['summaryData'];

				$sdCnt = 5;
				for($opCnt=0;$opCnt<13;$opCnt++) {
					isOverflow($sd[strval($sdCnt)], $sql1row['process_cnt'], $_POST['lot_no'], $operationArray[$opCnt], $db);
					$sdCnt += 3;
				}

				$addSql = "INSERT INTO `fuze_production_record` (`_id`,`fuze_type`,`fuze_diameter`,`record_date`,`stream`,`operation`,`process_cnt`,`op_cnt`,`shift`,`lot_no`,`remark`) VALUES 
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[0]."','".$sd['5']."','".$sd['6']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[1]."','".$sd['8']."','".$sd['9']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[2]."','".$sd['11']."','".$sd['12']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[3]."','".$sd['14']."','".$sd['15']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'TEST','".$operationArray[4]."','".$sd['17']."','".$sd['18']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[5]."','".$sd['20']."','".$sd['21']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[6]."','".$sd['23']."','".$sd['24']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[7]."','".$sd['26']."','".$sd['27']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[8]."','".$sd['29']."','".$sd['30']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[9]."','".$sd['32']."','".$sd['33']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'ASSY','".$operationArray[10]."','".$sd['35']."','".$sd['36']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'S&A','".$operationArray[11]."','".$sd['38']."','".$sd['39']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', ''),
					(NULL, '".$fuze_type."','".$fuze_diameter."',STR_TO_DATE('".$_POST['record_date']."', '%e %M, %Y'),'S&A','".$operationArray[12]."','".$sd['41']."','".$sd['42']."', 
					'".$_POST['shift']."', 
					'".$_POST['lot_no']."', '')
					";

					$addRes = mysqli_query($db, $addSql);

					if($addRes) {
						echo "ok";
					}
					else {
						echo "fail";
					}
				}
			}
			elseif($_SERVER['REQUEST_METHOD'] == 'GET'){

				$selLotQuery = "SELECT DISTINCT `lot_no` FROM `fuze_production_launch` ORDER BY `lot_no`;";
				$selLotRes = mysqli_query($db, $selLotQuery);

				$html= "
					<html>
						<title>Production Summary</title>
						<head>
							<link rel='shortcut icon' type='image/x-icon' href='/FuzeDatabase/favicon.ico'/>
							<meta http-equiv='Cache-Control' content='no-cache, no-store, must-revalidate' />
							<meta http-equiv='Pragma' content='no-cache' />
							<meta http-equiv='Expires' content='0' />

							<script type='text/javascript' src='jquery.min.js'></script>
							<script type='text/javascript' src='materialize.min.js'></script>
							<script type='text/javascript' src='jquery.cookie.js'></script>
							<script src='/FuzeDatabase/jquery-ui.js'></script>
						</head>
						<style>
							th, td {
								padding: 6px;
							}

							table, th, td {
								border: 2px solid black;
								border-collapse: collapse;
							}

							body {
								margin-left: 6px;
								background-color: #d0d0d0;
							}

							tr {
								text-align: center;
							}

							#tableHeader {
								font-weight: bold;
								font-size: 18px;
							}
						</style>
						<body style='background-color: #c0c0c0;'>
							<br>
							<center>
								<h2 style='color:red;'>Production Summary</h2>
									<table>
										<td>Select Lot No: 
											<select name='lot_no' id='lot_no' style='margin-left: 15px;'>
												<option value='' disabled selected>Click Here</option>";

			while($row = mysqli_fetch_assoc($selLotRes)) {
				$html.="<option value='".$row['lot_no']."'>".$row['lot_no']."</option>";
			}
			$html.="
											</select>
										</td>
									</table>
									<br>
									<button type='submit' id='submitBtn'>DISPLAY</button>
								<br>
								<div id='summaryTable'></div>
								<div id='reportTable' style='margin-top: 150px;'></div>
						</body>

						<script type='text/javascript'>
							$('#submitBtn').on('click', function(){
								$.ajax({
									url: 'production_summary.php',
									type: 'POST',
									data: {
										task: 'report',
										lot_no: $('#lot_no').val()
									},
									success: function(msg) {
										console.log(msg);
										try {
											jsonData = JSON.parse(msg);
											console.log(jsonData);";

							$tableVar = addslashes("<br><h3 style='margin-left: 20px; text-align: left; color: blue;'>Lot Progress: Quantity [Operator Count]</h3><table style='float: left; margin-left: 10px;'><tr id='tableHeader'><td style='min-width: 95px;' rowspan='2'>Date</td><td colspan='5'>Testing</td><td colspan='6'>Assembly</td><td colspan='2'>S&A</td></tr><tr id='tableHeader'><td>Visual<br>Inspection</td><td>GND Pin<br>Soldering</td><td>Housing<br>Unmoulded</td><td>Housing<br>Moulded</td><td>Electronic<br>Head</td><td>Battery<br>Tinning</td><td>Elec Hsg<br>Assy</td><td>Elec Hsg<br>Moulded</td><td>Assy<br>Fuze Base</td><td>Assy<br>Fuze</td><td>Electronic<br>Head</td><td>Visual<br>Inspection</td><td>Electronic<br>Head Final</td></tr>");

							$summaryTableVar = addslashes("<br><h3 style='margin-left: 20px; text-align: left; color: blue;'>Lot Summary:</h3><table style='float: left; margin-left: 10px;'><tr id='tableHeader'><td style='min-width: 95px;' rowspan='2'>Lot<br>Details</td><td colspan='5'>Testing</td><td colspan='6'>Assembly</td><td colspan='2'>S&A</td></tr><tr id='tableHeader'><td>Visual<br>Inspection</td><td>GND Pin<br>Soldering</td><td>Housing<br>Unmoulded</td><td>Housing<br>Moulded</td><td>Electronic<br>Head</td><td>Battery<br>Tinning</td><td>Elec Hsg<br>Assy</td><td>Elec Hsg<br>Moulded</td><td>Assy<br>Fuze Base</td><td>Assy<br>Fuze</td><td>Electronic<br>Head</td><td>Visual<br>Inspection</td><td>Electronic<br>Head Final</td></tr>");

						$html.="var tblData = \"".$tableVar."\";

											for(var i=0;i<jsonData['reportArray'].length;i++) {

												tblData += '<tr><td>'+jsonData['reportArray'][i]['date']+'</td>';

												for(var j=0;j<13;j++) {
													if(jsonData['reportArray'][i]['data'][j]['cnt'] == '-') {
														tblData += '<td>-</td>';
													}
													else {
														tblData += '<td>'+jsonData['reportArray'][i]['data'][j]['cnt']+'<br>['+jsonData['reportArray'][i]['data'][j]['op_cnt']+']</td>';
													}
												}
												tblData += '</tr>';
											}

											tblData += '</table>';
											$('#reportTable').html(tblData);

											var summaryTableData = \"".$summaryTableVar."\";

											summaryTableData += '<td>'+$('#lot_no').val()+'</td>';

											for(var j=0;j<13;j++) {
												summaryTableData += '<td>'+jsonData['cumulativeArray'][j][j+1]+'</td>';
											}

											summaryTableData += '</tr></table>';
											$('#summaryTable').html(summaryTableData);
										}
										catch(err) {
											alert('ERROR FETCHING DATABASE! SHOW THIS ERROR TO ADMIN:\\n\\n'+err);
										}
								},
								error: function(XMLHttpRequest, textStatus, errorThrown) {
									 alert(errorThrown + '\\n\\nIs web-server offline?');
								}
								});
							});
						</script>

					</html>	
				";

				echo $html;
			}
	}
	else {
		die("
			<html>
				<body style='background-color: #c0c0c0;'>
					<center>
						<br>
						<br>
						<h3 style='color:red;'>Please login to access this application</h3>
						<br>
						<a href='index.php'>Click here to Login</a>
					</center>
				</body>
			</html>
		");
	}

?>
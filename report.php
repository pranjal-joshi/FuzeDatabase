<?php
	include('db_config.php');
	require('php-excel.class.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		switch ($_POST['report']) {
			case 'barcode_record':
				$sql = "";
				if($_POST['lot_no'] == "*") {
					$sql = "SELECT `lot_table`.`pcb_no`, `barcode_table`.`barcode_no`, `lot_table`.`main_lot`, `lot_table`.`kit_lot` FROM `barcode_table` JOIN `lot_table` ON `barcode_table`.`pcb_no` = `lot_table`.`pcb_no` WHERE `lot_table`.`fuze_type` = '".$_POST['fuze_type']."' AND `lot_table`.`fuze_diameter` = '".$_POST['fuze_diameter']."'";
				}
				else {
					$sql = "SELECT `lot_table`.`pcb_no`, `barcode_table`.`barcode_no`, `lot_table`.`main_lot`, `lot_table`.`kit_lot` FROM `barcode_table` JOIN `lot_table` ON `barcode_table`.`pcb_no` = `lot_table`.`pcb_no` WHERE `lot_table`.`main_lot` = '".$_POST['lot_no']."' AND `lot_table`.`fuze_type` = '".$_POST['fuze_type']."' AND `lot_table`.`fuze_diameter` = '".$_POST['fuze_diameter']."'";
				}
				$res = mysqli_query($db, $sql);
				$cnt = 1;
				$excelArray = array();
				array_push($excelArray, array("SN.","PCB Number","Barcode Number","Main lot","Kit lot"));
				while ($row = mysqli_fetch_assoc($res)) {
					array_push($excelArray, array(strval($cnt),$row['pcb_no'],$row['barcode_no'],$row['main_lot'],$row['kit_lot']));
					$cnt++;
				}
				if($_POST['lot_no'] == "*") {
					$filename = 'Barcode Record - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' ALL LOTS';
				}
				else {
					$filename = 'Barcode Record - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' LOT '.$_POST['lot_no'].'';
				}
				$xls = new Excel_XML;
				$xls->addWorksheet('Barcode Record',$excelArray);
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 				header('Content-Disposition: attachment; filename="Barcode Record - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls"');
				$xls->sendWorkbook('Barcode Record - '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls');
				echo $filename;
				
				break;

			case 'battery_record':
				$sql = "";
				if($_POST['lot_no'] == "*") {
					$sql = "SELECT `lot_table`.`pcb_no`, `battery_table`.`battery_lot`, `lot_table`.`main_lot`, `lot_table`.`kit_lot` FROM `battery_table` JOIN `lot_table` ON `battery_table`.`pcb_no` = `lot_table`.`pcb_no` WHERE `lot_table`.`fuze_type` = '".$_POST['fuze_type']."' AND `lot_table`.`fuze_diameter` = '".$_POST['fuze_diameter']."'";
				}
				else {
					$sql = "SELECT `lot_table`.`pcb_no`, `battery_table`.`battery_lot`, `lot_table`.`main_lot`, `lot_table`.`kit_lot` FROM `battery_table` JOIN `lot_table` ON `battery_table`.`pcb_no` = `lot_table`.`pcb_no` WHERE `lot_table`.`main_lot` = '".$_POST['lot_no']."' AND `lot_table`.`fuze_type` = '".$_POST['fuze_type']."' AND `lot_table`.`fuze_diameter` = '".$_POST['fuze_diameter']."'";
				}
				$res = mysqli_query($db, $sql);
				$cnt = 1;
				$excelArray = array();
				array_push($excelArray, array("SN.","PCB Number","Battery Lot","Main lot","Kit lot"));
				while ($row = mysqli_fetch_assoc($res)) {
					array_push($excelArray, array(strval($cnt),$row['pcb_no'],$row['battery_lot'],$row['main_lot'],$row['kit_lot']));
					$cnt++;
				}
				if($_POST['lot_no'] == "*") {
					$filename = 'Battery Record - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' ALL LOTS.xls';
				}
				else {
					$filename = 'Battery Record - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' LOT '.$_POST['lot_no'].'.xls';
				}
				$xls = new Excel_XML;
				$xls->addWorksheet('Battery Record',$excelArray);
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 				header('Content-Disposition: attachment; filename="Battery Record - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls"');
				$xls->sendWorkbook('Battery Record - '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls');
				echo $filename;
				
				break;

			case 'testing_daily_count':
				if($_POST['lot_no'] == "*") {
					die("invalid wildcard");
				}

				$cnt = 0;
				$excelDataArray = array();

				array_push($excelDataArray, array("Daily Record - ".$_POST['fuze_diameter']."mm ".$_POST['fuze_type']." - LOT ".$_POST['lot_no']));

				array_push($excelDataArray, array(""));

				array_push($excelDataArray, array("SN.","DATE\n(DD-MM-YY)","PCB Testing","HSG Testing","Potted\nHSG Testing","RF Calibration","Unit Head\nTesting"));

				$startDateSql = "SELECT `lot_table`.`pcb_no`, `lot_table`.`main_lot`, `lot_table`.`kit_lot`,  `pcb_testing`.`record_date` FROM `lot_table` JOIN `housing_table` ON `housing_table`.`pcb_no`=`lot_table`.`pcb_no` JOIN `pcb_testing` ON `pcb_testing`.`pcb_no`=`lot_table`.`pcb_no` WHERE `lot_table`.`main_lot`='".$_POST['lot_no']."' ORDER BY `pcb_testing`.`record_date` ASC";

				$stopDateSql = "SELECT `lot_table`.`pcb_no`, `lot_table`.`main_lot`, `lot_table`.`kit_lot`,  `after_pu`.`record_date` FROM `lot_table` JOIN `housing_table` ON `housing_table`.`pcb_no`=`lot_table`.`pcb_no` JOIN `after_pu` ON `after_pu`.`pcb_no`=`lot_table`.`pcb_no` WHERE `lot_table`.`main_lot`='".$_POST['lot_no']."' ORDER BY `after_pu`.`record_date` DESC";

				$startDateRes = mysqli_query($db,$startDateSql);
				$startDate = mysqli_fetch_assoc($startDateRes);

				$stopDateRes = mysqli_query($db,$stopDateSql);
				$stopDate = mysqli_fetch_assoc($stopDateRes);

				if(mysqli_num_rows($startDateRes)==0 && mysqli_num_rows($stopDateRes)==0) {
					die("data not available");
				}

				$startDateObj = new DateTime($startDate['record_date']);
				$startDateObj->modify("-1 day");

				$stopDayObj = new DateTime($stopDate['record_date']);
				$stopDayObj->modify("1 day");

				$period = new DatePeriod(
					$startDateObj,
					new DateInterval('P1D'),
					$stopDayObj
				);

				foreach ($period as $key => $value) {
					$pcbSql = "SELECT `_id` FROM `pcb_testing` WHERE `record_date` = '".$value->format('Y-m-d')."'";
					$hsgSql = "SELECT `_id` FROM `housing_table` WHERE `record_date` = '".$value->format('Y-m-d')."'";
					$pottingSql = "SELECT `_id` FROM `potting_table` WHERE `record_date` = '".$value->format('Y-m-d')."'";
					$calSql = "SELECT `_id` FROM `calibration_table` WHERE `timestamp` = '".$value->format('Y-m-d')."'";
					$headSql = "SELECT `_id` FROM `after_pu` WHERE `record_date` = '".$value->format('Y-m-d')."'";

					$pcbRes = mysqli_query($db, $pcbSql);
					$hsgRes = mysqli_query($db, $hsgSql);
					$pottingRes = mysqli_query($db, $pottingSql);
					$calRes = mysqli_query($db, $calSql);
					$headRes = mysqli_query($db, $headSql);
					$cnt++;

					array_push($excelDataArray, array(
						strval($cnt),
						$value->format('d-m-Y'),
						mysqli_num_rows($pcbRes),
						mysqli_num_rows($hsgRes),
						mysqli_num_rows($pottingRes),
						mysqli_num_rows($calRes),
						mysqli_num_rows($headRes),
					));

					//print_r($value->format('d-m-Y'));
				}

				$filename = 'Testing Daily Count - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' LOT '.$_POST['lot_no'].'.xls';
				$xls = new Excel_XML;

				$xls->addWorksheet('LOT '.$_POST['lot_no'],$excelDataArray);

				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment; filename="Testing Daily Count - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls"');
				$xls->sendWorkbook('Testing Daily Count - '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls');
				echo $filename;

				break;

			case 'testing_record':
				$pcbSql = "";
				$hsgSql = "";
				$pottingSql = "";
				$calSql = "";
				$headSql = "";

				$excelPcbArray = array();
				$excelHsgArray = array();
				$excelPottingArray = array();
				$excelCalArray = array();
				$excelHeadArray = array();

				if($_POST['fuze_type'] == 'PROX') {
					if($_POST['lot_no'] == "*") {
						die("invalid wildcard");
					}
					else {
						$pcbSql = "SELECT * FROM `pcb_testing` JOIN `lot_table` ON `lot_table`.`pcb_no`=`pcb_testing`.`pcb_no` WHERE `lot_table`.`fuze_type`='PROX' AND `lot_table`.`main_lot`='".$_POST['lot_no']."' AND `lot_table`.`fuze_diameter`='".$_POST['fuze_diameter']."'";

						$hsgSql = "SELECT * FROM `housing_table` JOIN `lot_table` ON `lot_table`.`pcb_no`=`housing_table`.`pcb_no` WHERE `lot_table`.`fuze_type`='PROX' AND `lot_table`.`main_lot`='".$_POST['lot_no']."' AND `lot_table`.`fuze_diameter`='".$_POST['fuze_diameter']."'";

						$pottingSql = "SELECT * FROM `potting_table` JOIN `lot_table` ON `lot_table`.`pcb_no`=`potting_table`.`pcb_no` WHERE `lot_table`.`fuze_type`='PROX' AND `lot_table`.`main_lot`='".$_POST['lot_no']."' AND `lot_table`.`fuze_diameter`='".$_POST['fuze_diameter']."'";

						$calSql = "SELECT * FROM `calibration_table` JOIN `lot_table` ON `lot_table`.`pcb_no`=`calibration_table`.`pcb_no` WHERE `lot_table`.`fuze_type`='PROX' AND `lot_table`.`main_lot`='".$_POST['lot_no']."' AND `lot_table`.`fuze_diameter`='".$_POST['fuze_diameter']."'";

						$headSql = "SELECT * FROM `after_pu` JOIN `lot_table` ON `lot_table`.`pcb_no`=`after_pu`.`pcb_no` WHERE `lot_table`.`fuze_type`='PROX' AND `lot_table`.`main_lot`='".$_POST['lot_no']."' AND `lot_table`.`fuze_diameter`='".$_POST['fuze_diameter']."'";
					}

					$pcbRes = mysqli_query($db, $pcbSql);
					array_push($excelPcbArray, array("PCB No", "KIT LOT", "Current", "VEE", "VBAT-PST", "PST-AMP", "PST-WID", "MOD FREQ", "MOD DC", "MOD AC", "CAP CHARGE", "VRF-AMP", "VBAT-VRF", "VBAT-SIL", "DET-WID", "DET-AMP", "CYCLES", "BPF DC", "BPF AC", "BPF NOISE DC", "BPF NOISE AC", "SIL", "LVP", "PD DELAY", "PD DET", "SAFE", "RESULT", "OPERATOR", "DATE"));
					while ($row = mysqli_fetch_assoc($pcbRes)) {
						array_push($excelPcbArray, array($row['pcb_no'],$row['kit_lot'],$row['i'],$row['vee'],$row['vbat_pst'],$row['pst_amp'],$row['pst_wid'],$row['mod_freq'],$row['mod_dc'],$row['mod_ac'],$row['cap_charge'],$row['vrf_amp'],$row['vbat_vrf'],$row['vbat_sil'],$row['det_wid'],$row['det_amp'],$row['cycles'],$row['bpf_dc'],$row['bpf_ac'],$row['bpf_noise_ac'],$row['bpf_noise_dc'],$row['sil'],$row['lvp'],$row['pd_delay'],$row['pd_det'],$row['safe'],$row['result'],$row['op_name'],$row['record_date']));
					}

					$hsgRes = mysqli_query($db, $hsgSql);
					array_push($excelHsgArray, array("PCB No", "KIT LOT", "Current", "VEE", "VBAT-PST", "PST-AMP", "PST-WID", "MOD FREQ", "MOD DC", "MOD AC", "CAP CHARGE", "VRF-AMP", "VBAT-VRF", "VBAT-SIL", "DET-WID", "DET-AMP", "CYCLES", "BPF DC", "BPF AC", "SIL", "LVP", "PD DELAY", "PD DET", "SAFE", "RESULT", "OPERATOR", "DATE"));
					while ($row = mysqli_fetch_assoc($hsgRes)) {
						array_push($excelHsgArray, array($row['pcb_no'],$row['kit_lot'],$row['i'],$row['vee'],$row['vbat_pst'],$row['pst_amp'],$row['pst_wid'],$row['mod_freq'],$row['mod_dc'],$row['mod_ac'],$row['cap_charge'],$row['vrf_amp'],$row['vbat_vrf'],$row['vbat_sil'],$row['det_wid'],$row['det_amp'],$row['cycles'],$row['bpf_dc'],$row['bpf_ac'],$row['sil'],$row['lvp'],$row['pd_delay'],$row['pd_det'],$row['safe'],$row['result'],$row['op_name'],$row['record_date']));
					}

					$pottingRes = mysqli_query($db, $pottingSql);
					array_push($excelPottingArray, array("PCB No", "KIT LOT", "Current", "VEE", "VBAT-PST", "PST-AMP", "PST-WID", "MOD FREQ", "MOD DC", "MOD AC", "CAP CHARGE", "VRF-AMP", "VBAT-VRF", "VBAT-SIL", "DET-WID", "DET-AMP", "CYCLES", "BPF DC", "BPF AC", "SIL", "LVP", "PD DELAY", "PD DET", "SAFE", "RESULT", "OPERATOR", "DATE"));
					while ($row = mysqli_fetch_assoc($pottingRes)) {
						array_push($excelPottingArray, array($row['pcb_no'],$row['kit_lot'],$row['i'],$row['vee'],$row['vbat_pst'],$row['pst_amp'],$row['pst_wid'],$row['mod_freq'],$row['mod_dc'],$row['mod_ac'],$row['cap_charge'],$row['vrf_amp'],$row['vbat_vrf'],$row['vbat_sil'],$row['det_wid'],$row['det_amp'],$row['cycles'],$row['bpf_dc'],$row['bpf_ac'],$row['sil'],$row['lvp'],$row['pd_delay'],$row['pd_det'],$row['safe'],$row['result'],$row['op_name'],$row['record_date']));
					}

					$calRes = mysqli_query($db, $calSql);
					array_push($excelCalArray, array("PCB No", "RF No", "F Before", "BPF Before", "Res changed", "Res Value", "F After", "BPF After", "OPERATOR", "DATE", "KIT LOT"));
					while ($row = mysqli_fetch_assoc($calRes)) {
						array_push($excelCalArray, array($row['pcb_no'],$row['rf_no'],$row['before_freq'],$row['before_bpf'],$row['changed'],$row['res_val'],$row['after_freq'],$row['after_bpf'],$row['op_name'],$row['timestamp'],$row['kit_lot']));
					}

					$headRes = mysqli_query($db, $headSql);
					array_push($excelHeadArray, array("PCB No", "KIT LOT", "CUrrent 1.5S", "Current 4.5S", "VEE", "VBAT-PST", "PST-AMP", "PST-WID", "FREQ", "SPAN", "BPF AC CAL", "VBAT-SIL", "DET-WID", "DET-AMP", "CYCLES", "BPF DC", "BPF AC", "BPF NOISE AC", "BPF NOISE DC", "SIL", "SIL AT 0", "LVP", "PD DELAY", "PD DET AMP", "PD DET WIDTH", "RESULT", "DATE"));
					while ($row = mysqli_fetch_assoc($pottingRes)) {
						array_push($excelheadArray, array($row['pcb_no'],$row['kit_lot'],$row['i_1.5'],$row['i_4.5'],$row['vee'],$row['vbat_pst'],$row['pst_amp'],$row['pst_wid'],$row['freq'],$row['span'],$row['bpf_ac_cal'],$row['vbat_sil'],$row['det_wid'],$row['det_amp'],$row['cycles'],$row['bpf_dc'],$row['bpf_ac'],$row['bpf_noise_ac'],$row['bpf_noise_dc'],$row['sil'],$row['sil_at_0'],$row['lvp'],$row['pd_delay'],$row['pd_det_amp'],$row['pd_det_width'],$row['result'],$row['record_date']));
					}
					
					$filename = 'Testing Record - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' LOT '.$_POST['lot_no'].'.xls';
					$xls = new Excel_XML;

					$xls->addWorksheet('PCB',$excelPcbArray);
					$xls->addWorksheet('Housing',$excelHsgArray);
					$xls->addWorksheet('Potted Hsg',$excelPottingArray);
					$xls->addWorksheet('Calibration',$excelCalArray);
					$xls->addWorksheet('Electronic Head',$excelHeadArray);

					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 					header('Content-Disposition: attachment; filename="Testing Record - '.$_POST['fuze_diameter'].' '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls"');
 					$xls->sendWorkbook('Testing Record - '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls');
					echo $filename;
				}
				// write code here for EPD/TIME fuzes
				break;
			
		}
	}

?>
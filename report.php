<?php
	include('db_config.php');
	require('php-excel.class.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		//print_r($_POST);

		switch ($_POST['report']) {
			case 'barcode_record':
				$sql = "SELECT `lot_table`.`pcb_no`, `barcode_table`.`barcode_no`, `lot_table`.`main_lot`, `lot_table`.`kit_lot` FROM `barcode_table` JOIN `lot_table` ON `barcode_table`.`pcb_no` = `lot_table`.`pcb_no` WHERE `lot_table`.`main_lot` = '".$_POST['lot_no']."' AND `lot_table`.`fuze_type` = '".$_POST['fuze_type']."' AND `lot_table`.`fuze_diameter` = '".$_POST['fuze_diameter']."'";
				$res = mysqli_query($db, $sql);
				$cnt = 1;
				$excelArray = array();
				array_push($excelArray, array("SN.","PCB Number","Barcode Number","Main lot","Kit lot"));
				while ($row = mysqli_fetch_assoc($res)) {
					array_push($excelArray, array(strval($cnt),$row['pcb_no'],$row['barcode_no'],$row['main_lot'],$row['kit_lot']));
					$cnt++;
				}
				$xls = new Excel_XML;
				$xls->addWorksheet('Barcode Record',$excelArray);
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 				//header('Content-Disposition: attachment; filename='.'Barcode Record - '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls');
				$xls->sendWorkbook('Barcode Record - '.$_POST['fuze_type'].' LOT '.$_POST['fuze_diameter'].'.xls');
				break;
			
		}
	}

?>
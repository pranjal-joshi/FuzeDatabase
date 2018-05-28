<?php
	// QA form upload

	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$sqlCheck = "SELECT * from `qa_table` WHERE `pcb_no`='".$_POST['qa_pcb_no']."';";
		$checkResult = mysqli_query($db, $sqlCheck);

		// Disabled record exist searc due to DB-REPLACE query
		/*
		if($checkResult->num_rows > 0){
			die("exist");
		}
		*/

		$sql = "REPLACE INTO `qa_table` (`_id`, `pcb_no`, `stage`, `result`, `reason`, `record_date`, `op_name`) VALUES (
			NULL, 
			'".$_POST['qa_pcb_no']."', 
			'".$_POST['qa_stage']."',
			'".$_POST['result']."',
			'".$_POST['reason']."',
			'".$_POST['qaDatePicker']."',
			'".$_POST['qa_op_name']."'
				);";

			$results = mysqli_query($db,$sql);

			print_r($_POST);

			if($results === true){
				echo "ok";
			}
			else {
				echo "fail";
			}

			$reasonToSave = strval($_POST['reason']);

			switch ($reasonToSave) {
				case '1':
					$reasonToSave = "1 - Wire not properly soldered";
					break;
				case '2':
					$reasonToSave = "2 - Broken wire, Damaged Insulation";
					break;
				case '3':
					$reasonToSave = "3 - Improper wire length";
					break;
				case '4':
					$reasonToSave = "4 - DET pin not soldered properly";
					break;
				case '5':
					$reasonToSave = "5 - VIN pin not soldered properly";
					break;
				case '6':
					$reasonToSave = "6 - PST pin not soldered properly";
					break;
				case '7':
					$reasonToSave = "7 - SW1/IMP pin not soldered properly";
					break;
				case '8':
					$reasonToSave = "8 - GND pin not soldered properly";
					break;
				case '9':
					$reasonToSave = "9 - MOD pin not soldered properly";
					break;
				case '10':
					$reasonToSave = "10 - SIG pin not soldered properly";
					break;
				case '11':
					$reasonToSave = "11 - VRF pin not soldered properly";
					break;
				case '12':
					$reasonToSave = "12 - Pin cross / bend";
					break;
				case '13':
					$reasonToSave = "13 - Improper pin length";
					break;
				case '14':
					$reasonToSave = "14 - Pin / test pin cut";
					break;
				case '15':
					$reasonToSave = "15 - Plating of pin / test pin";
					break;
				case '16':
					$reasonToSave = "16 - Soldering ring not observed (bottom side)";
					break;
				case '17':
					$reasonToSave = "17 - Solder balls seen";
					break;
				case '18':
					$reasonToSave = "18 - Imapct switch soldering improper";
					break;
				case '19':
					$reasonToSave = "19 - Excess solder on impact switch";
					break;
				case '20':
					$reasonToSave = "20 - Damanged / swollen bush of imapct switch";
					break;
				case '21':
					$reasonToSave = "21 - Imapct switch tilted";
					break;
				case '22':
					$reasonToSave = "22 - Excess flux";
					break;
				case '23':
					$reasonToSave = "23 - Components not properly soldered";
					break;
				case '24':
					$reasonToSave = "24 - Soldered components damaged";
					break;
				case '25':
					$reasonToSave = "25 - Wrong components soldered";
					break;
				case '26':
					$reasonToSave = "26 - Shorting of component pins";
					break;
				case '27':
					$reasonToSave = "27 - Component missing";
					break;
				case '28':
					$reasonToSave = "28 - PCB track cut";
					break;
				case '29':
					$reasonToSave = "29 - Solder pad on PCB damaged / removed";
					break;
				case '30':
					$reasonToSave = "30 - Improper barcode printing";
					break;
				case '31':
					$reasonToSave = "31 - Crystal pad damaged";
					break;
				case '50':
					$reasonToSave = "50 - Others";
					break;
				case '100':
					$reasonToSave = "100 - MULTIPLE FAULTS";
					break;
				default:
					$reasonToSave = "Not Applicable";
			}
			print_r($reasonToSave);
			if($reasonToSave != "Not Applicable") {
				$pcbRejection = "UPDATE `lot_table` SET `rejection_stage`='Q/A', `rejection_remark`='Rejection Code: ".$reasonToSave."', `rejected`='1' WHERE `pcb_no`='".$_POST['qa_pcb_no']."'";
				$rejectionResult = mysqli_query($db,$pcbRejection);
				print_r($pcbRejection);
			}
			mysqli_close($db);
	}
?>
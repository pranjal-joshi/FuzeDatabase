<?php

	include('db_config.php');
	include("pcb_batch.php");
	require('library/php-excel-reader/excel_reader2.php');
	require('library/SpreadsheetReader.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];

		error_reporting(0);

		if(is_uploaded_file($_FILES['file']['tmp_name'])) {

			error_reporting(E_ALL);

			if($_FILES['file']['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {

				$uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
				move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

				$html = "
					<style>
						th, td {
							padding: 2px;
						}

						table, th, td {
							border: 1px solid black;
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

						#tableInfo {
							margin-left: 5px;
							font-weight: bold;
							color: brown;
						}

						@media print
						{    
							.no-print, .no-print *
							{
								display: none !important;
							}
						}

						table { page-break-inside:auto }
						tr    { page-break-inside:avoid; page-break-after:auto }
						thead { display:table-header-group }
						tfoot { display:table-footer-group }
					</style>
					<body style='background-color: #d0d0d0;'>
						<center>
							<br><h3>Following Data has been uploaded</h3><br>
							<table>
								<tr id='tableHeader'>
									<td>Sr.No.</td>
									<td>PCB NUMBER</td>
									<td>BARCODE NUMBER</td>
								</tr>";


				$Reader = new SpreadsheetReader($uploadFilePath);
				$totalSheet = count($Reader->sheets());

				for($i=0;$i<$totalSheet;$i++){

					$Reader->ChangeSheet($i);
					$cnt = 0;
					$a = array();

					$sqlAutoIncReset = "ALTER TABLE `barcode_table` DROP `_id`;";
					$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

					$sqlAdd = "REPLACE INTO `barcode_table` (`pcb_no`,`barcode_no`) VALUES ";

					foreach ($Reader as $Row){
						$cnt++;
						if($cnt > 1) {
							$Row[2] = concatPcbBatch($Row[2],$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"HEAD",$db);
							$Row[7] = concatPcbBatch($Row[7],$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"HEAD",$db);
							if(($Row[2] != "" || $Row[7] != "") && $Row[2] != "PCB NO")
							{
								$sqlAdd.= "(
									'".$Row[2]."', 
									'".$Row[1]."'),
									(
									'".$Row[7]."', 
									'".$Row[6]."'),";
								$html.= "
									<tr>
										<td>".strval($cnt-1)."</td>
										<td>".$Row[2]."</td>
										<td>".$Row[1]."</td>
									</tr>
									<tr>
										<td>".strval($cnt)."</td>
										<td>".$Row[7]."</td>
										<td>".$Row[6]."</td>
									</tr>
								";
								$cnt++;
							}
						}
					}
					$sqlAdd = rtrim($sqlAdd,",");
					$sqlAdd = rtrim($sqlAdd,", ");
					$sqlAdd.=";";
					$res = mysqli_query($db,$sqlAdd);

					$sqlAutoIncReset = "ALTER TABLE `barcode_table` ADD `_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`_id`);";
					$autoIncResult = mysqli_query($db, $sqlAutoIncReset);

					$html.= "</table>
						</center>
					</body>";

					die($html);
				}
			}
			else {
				die("
				<center>
					<br/><h2 style='color: red;'>Sorry, File type is not allowed. Only Excel file can be uploaded.</h2>
					<br/><a href='welcome.php'>Go Back</a>
				</center>
				"); 
			}
		}
		else {
			$_POST['pcb_no'] = strtoupper($_POST['pcb_no']);
			$_POST['barcode_no'] = strtoupper($_POST['barcode_no']);

			$_POST['pcb_no'] = concatPcbBatch($_POST['pcb_no'],$_COOKIE['fuzeType'],$_COOKIE['fuzeDia'],"HEAD",$db);

			$sql = "REPLACE INTO `barcode_table` (`pcb_no`,`barcode_no`) VALUES ('".substr($_POST['pcb_no'],0,12)."', '".$_POST['barcode_no']."')";

			$res = mysqli_query($db, $sql);

			if($res) {
				echo($_POST['pcb_no']." &#8596; ".$_POST['barcode_no']);
			}
		}

		mysqli_close($db);
	}

?>
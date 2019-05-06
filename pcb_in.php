<?php

	include('db_config.php');

	include('pcb_batch.php');

	function loadInwardTable($db) {
		$loadSql = "SELECT * FROM `pcb_inout` ORDER BY `date` DESC LIMIT 200";
		$loadRes = mysqli_query($db, $loadSql);

		$timeSql = "SELECT SUM(`received`) AS `sum_received`, SUM(`accepted`) AS `sum_accepted`, SUM(`rejected`) AS `sum_rejected`, SUM(`received`)-SUM(`accepted`)-SUM(`rejected`) AS `stock` FROM `pcb_inout` WHERE `fuze_type`='TIME'";
		$proxSql = "SELECT SUM(`received`) AS `sum_received`, SUM(`accepted`) AS `sum_accepted`, SUM(`rejected`) AS `sum_rejected`, SUM(`received`)-SUM(`accepted`)-SUM(`rejected`) AS `stock` FROM `pcb_inout` WHERE `fuze_type`='PROX'";
		$epd105Sql = "SELECT SUM(`received`) AS `sum_received`, SUM(`accepted`) AS `sum_accepted`, SUM(`rejected`) AS `sum_rejected`, SUM(`received`)-SUM(`accepted`)-SUM(`rejected`) AS `stock` FROM `pcb_inout` WHERE `fuze_type`='EPD' AND `fuze_diameter`='105'";
		$epd155Sql = "SELECT SUM(`received`) AS `sum_received`, SUM(`accepted`) AS `sum_accepted`, SUM(`rejected`) AS `sum_rejected`, SUM(`received`)-SUM(`accepted`)-SUM(`rejected`) AS `stock` FROM `pcb_inout` WHERE `fuze_type`='EPD' AND `fuze_diameter`='155'";

		$timeRes = mysqli_query($db, $timeSql);
		$proxRes = mysqli_query($db, $proxSql);
		$epd105Res = mysqli_query($db, $epd105Sql);
		$epd155Res = mysqli_query($db, $epd155Sql);

		$timeRow = mysqli_fetch_assoc($timeRes);
		$proxRow = mysqli_fetch_assoc($proxRes);
		$epd105Row = mysqli_fetch_assoc($epd105Res);
		$epd155Row = mysqli_fetch_assoc($epd155Res);

		$html="<div class='row'>
						<table class='centered'>
								<thead>
									<tr>
										<th>PCB Type</th>
										<th>Received</th>
										<th>Accepted</th>
										<th>Rejected</th>
										<th>In Stock</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>EPD 105</td>
										<td>".$epd105Row['sum_received']."</td>
										<td>".$epd105Row['sum_accepted']."</td>
										<td>".$epd105Row['sum_rejected']."</td>
										<td>".$epd105Row['stock']."</td>
									</tr>
									<tr>
										<td>EPD 155</td>
										<td>".$epd155Row['sum_received']."</td>
										<td>".$epd155Row['sum_accepted']."</td>
										<td>".$epd155Row['sum_rejected']."</td>
										<td>".$epd155Row['stock']."</td>
									</tr>
									<tr>
										<td>TIME</td>
										<td>".$timeRow['sum_received']."</td>
										<td>".$timeRow['sum_accepted']."</td>
										<td>".$timeRow['sum_rejected']."</td>
										<td>".$timeRow['stock']."</td>
									</tr>
									<tr>
										<td>PROX</td>
										<td>".$proxRow['sum_received']."</td>
										<td>".$proxRow['sum_accepted']."</td>
										<td>".$proxRow['sum_rejected']."</td>
										<td>".$proxRow['stock']."</td>
									</tr>
								</tbody>
							</table><br><br>
							<table class='centered'>
								<thead>
									<tr>
										<th>Date</th>
										<th>Fuze<br>Type</th>
										<th>Gun<br>Type</th>
										<th>Vendor</th>
										<th>Received</th>
										<th>Accepted</th>
										<th>Rejected</th>
										<th>Operator</th>
									</tr>
								</thead>
								<tbody>";								
		while($row = mysqli_fetch_assoc($loadRes)) {
			$html.="<tr>
								<td>".$row['date']."</td>
								<td>".$row['fuze_type']."</td>
								<td>".$row['fuze_diameter']."</td>
								<td>".$row['vendor']."</td>
								<td>".$row['received']."</td>
								<td>".$row['accepted']."</td>
								<td>".$row['rejected']."</td>
								<td>".$row['op_name']."</td>
							</tr>";
		}
		$html.="		</tbody>
			</table>			
		</div>";
		die($html);
	}

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if($_POST['type'] == 'save') {
			$createSql = "CREATE TABLE `pcb_inout` (
							 `_id` int(11) NOT NULL AUTO_INCREMENT,
							 `date` date NOT NULL,
							 `vendor` varchar(20) NOT NULL,
							 `fuze_type` varchar(4) NOT NULL,
							 `fuze_diameter` int(11) NOT NULL,
							 `received` bigint(20) NOT NULL,
							 `accepted` bigint(20) NOT NULL,
							 `rejected` int(11) NOT NULL,
							 `op_name` text NOT NULL,
							 PRIMARY KEY (`_id`)
							) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Hold PCB IN-OUT Record for PPC & Visual'
							";
			$createRes = mysqli_query($db, $createSql);

			$sql = "INSERT INTO `pcb_inout` (`_id`, `date`, `vendor`, `fuze_type`, `fuze_diameter`, `received`, `accepted`, `rejected`, `op_name`) VALUES (NULL, STR_TO_DATE('".$_POST['date']."','%e %M, %Y'), '".$_POST['vendor']."', '".$_POST['fuze_type']."', '".$_POST['fuze_diameter']."', '".$_POST['received']."', '".$_POST['accepted']."', '".$_POST['rejected']."', '".$_POST['op_name']."')";
			$res = mysqli_query($db, $sql);
			loadInwardTable($db);
		}
		else if($_POST['type'] == 'load') {
			loadInwardTable($db);
		}

	}

?>
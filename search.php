<?php

	include('db_config.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$searchIn = "";
		$query = $_POST['query'];
		$table_head = "";

		switch ($_POST['select']) {
			case '1':
				$searchIn = "pcb_no";
				$table_head.= "
				<thead>
					<tr>
						<th>_id</th>
						<th>PCB No.</th>
						<th>RF No.</th>
						<th>Before Freq.</th>
						<th>Before BPF AC</th>
						<th></th>
						<th>RES</th>
						<th>After Freq</th>
						<th>After BPF</th>
						<th>Time</th>
						<th>OP</th>
					</tr>
				</thead>";
				break;
			case '2':
				$searchIn = "rf_no";
				break;
			case '3':
				$searchIn = "res_val";
				break;
			case '4':
				$searchIn = "before_freq";
				break;
			case '5':
				$searchIn = "before_bpf";
				break;
			case '6':
				$searchIn = "after_freq";
				break;
			case '7':
				$searchIn = "after_bpf";
				break;
			case '8':
				$searchIn = "timestamp";
				break;
			case '9':
				$searchIn = "op_name";
				$query = strtoupper($query);
				break;
		}

		$sql = "SELECT * FROM `calibration_table` WHERE `".$searchIn."` LIKE '".$query."%'";

		$results = mysqli_query($db,$sql);

		$value = "<table class='striped'>".$table_head;

		if($results) {
			while($row = mysqli_fetch_assoc($results))
			{
				$value.= "<tr>";
				foreach ($row as $item) {
					$value.= "<td>".$item."</td>";
				}
				$value.="<td><a href='#' class='btn waves-light waves-effect waves-green green'>EDIT</a></td>";
				$value.="<td><a href='#' class='btn waves-light waves-effect waves-red red'>DELETE</a></td>";
				$value.="</tr>";
			}
			echo $value;
			mysqli_close($db);
		}
		else {
			die("fail to search.");
		}
	}
?>
<?php

	function isBetween($val,$min,$max) {
		if(($val >= $min) && ($val <= $max)) {
			return true;
		}
		return false;
	}

	function concatPcbBatch($pcbNo,$fuzeType,$fuzeDia,$process,$db) {
		if(strlen($pcbNo) < 8) {
			$fetchSql = "SELECT * from `batch_code_table` WHERE 1";
			$fetchRes = mysqli_query($db, $fetchSql);
			while ($row = mysqli_fetch_assoc($fetchRes)) {
				if(isBetween(intval($pcbNo),intval($row['pcb_start']),intval($row['pcb_end'])) && $fuzeType == $row['fuze_type'] && $fuzeDia == $row['fuze_diameter']) {
					$pcbNo = $row['batch_code'].$pcbNo;
					return $pcbNo;
				}
			}
		}
		return $pcbNo;
	}
?>
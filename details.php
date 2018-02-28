<?php
	include('db_config.php');

	function curPageURL() {
		$pageURL = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		return $pageURL;
	}

	$url = parse_url(curPageURL());

	$splitUrl = explode("&", $url['query']);

	$toSearch = explode("=", $splitUrl[0])[1];
	$searchIn = explode("=", $splitUrl[1])[1];
	$searchTable = explode("=", $splitUrl[2])[1];

	print_r($splitUrl);
	echo "<br>";
	print_r($toSearch);
	echo "<br>";
	print_r($searchIn);
	echo "<br>";
	print_r($searchTable);

	mysqli_close($db);
?>
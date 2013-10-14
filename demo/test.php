<?php
	echo header("Access-Control-Allow-Origin:*");
	header('Content-type: text/json');

	$res = array (
		"data" => array("chenjiajie", "lindayi", "liudanyang")
	);
	echo $res;
?>

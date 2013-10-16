<?php
	echo header("Access-Control-Allow-Origin:*");
	header('Content-type: text/json');

	//数据库链接
	include_once "conn.php";

	//获得查询语句
	$query = $_GET['query'];

	$result = mysql_query("SELECT profilename FROM profile WHERE profilename LIKE \"%".$query."%\" LIMIT 0,10", $conn);

	//存入data数组
	$data = array();
	while(($row = mysql_fetch_row($result))) {
		array_push($data, $row[0]);
	}	
	//编码成json格式
	$res = array(
		"data" => $data,
	);

	echo json_encode($res);
?>

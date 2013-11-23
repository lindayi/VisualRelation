<?php

	function proctime($time, $t)
	{
		if (($t == 1)&&(strlen($time) > 15)) $time = substr($time, 15, 12);
		else $time = substr($time, 0, 12);
		
		return substr($time, 0, 4).",".substr($time, 4, 2).",".substr($time, 6, 2);
	}

	include_once "conn.php";
	$titleheadline = $_GET['keyword'];
	$id = $_GET['id'];
	$titleheadline = $titleheadline." 的时间轴";
	$count = 0;

	$sqlquery = "SELECT DISTINCT destid, ne, realtime, type FROM relation WHERE sourceid = '".$id. "' and type not in ( \"CeMODIFIERS\",\"CeXMODIFIER_OF\")";
	$result = mysql_query($sqlquery);
	$row = mysql_fetch_array($result);
	while($row = mysql_fetch_array($result))
	{
		$startDate[$count] = proctime($row["realtime"],0);
		$endDate[$count] = proctime($row["realtime"],1);
		$headline[$count] = $row["ne"];
		$text[$count] = "<p>来源：</p>";
		//$sqlquery = "SELECT DISTINCT destid, type, text FROM relation, doc WHERE destid = ".$row["destid"]." and sourceid = ".$id." and type = ".
		$count++;
	}
?>

	{
		"timeline":
		{
			"headline":"北京邮电大学互联网治理与法律研究中心 的时间轴",
			"type":"default",
			"text":"<p>点击右侧箭头，进入时间轴</p>",
			"asset": {},
			"date": [
			{
				"startDate":"2012,12,22",
				"endDate":"2012,12,22",
				"headline":"中国.北京",
				"text":"<p>类型：CeLOCATION</p><p>来源：</p>",
				"tag":"组织",
				"asset": {}
				}
			],
			"era": []
		}
	}
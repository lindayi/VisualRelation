<?php
	/*
	
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
	*/

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

	$sqlquery = "SELECT DISTINCT destid, ne, relation.realtime, type, profiletype FROM relation,profile WHERE relation.sourceid = '".$id. "' and type not in ( \"CeMODIFIERS\",\"CeXMODIFIER_OF\") and destid = profileid order by relation.realtime desc limit 0,300";
	$result = mysql_query($sqlquery);
	$row = mysql_fetch_array($result);

	$dates = array();
	while($row = mysql_fetch_array($result))
	{
		$startDate[$count] = proctime($row["realtime"],0);
		$endDate[$count] = proctime($row["realtime"],1);
		$headline[$count] = $row["ne"];
		$tag[$count] = $row["profiletype"];
		if ($tag[$count] == "1") $tag[$count] = "地点";
		if ($tag[$count] == "2") $tag[$count] = "机构";
		if ($tag[$count] == "3") $tag[$count] = "人物";
		
		$text[$count] = "<p>来源：</p>";
		$textquery = "SELECT doc.text FROM relation, doc WHERE destid = ".$row["destid"]." and sourceid = ".$id." and type = '".$row["type"]."' and relation.doc = doc.file and relation.sentenceid = doc.sentenceid";
		$textresult = mysql_query($textquery);
		$textrow = mysql_fetch_array($textresult);
		$text[$count] = $text[$count].$textrow["text"];
		
		$asset = array();
		$date = array(
			"startDate"=>$startDate[$count],
			"endDate"=>$endDate[$count],
			"headline"=>$headline[$count],
			"text"=>$text[$count],
			"tag"=>$tag[$count],
			"asset"=>$asset
			);
		array_push($dates, $date);
		$count++;
	}

	$asset = array();
	$era = array();
	$timeline = array(
		"headline"=>$titleheadline,
		"type"=>"default",
		"text"=>"<p>点击右侧箭头，进入时间轴</p>",
		"asset"=>$asset,
		"date"=>$dates,
		"era"=>$era
		);
	$res = array(
		"timeline"=>$timeline
		);

	echo json_encode($res);
?>

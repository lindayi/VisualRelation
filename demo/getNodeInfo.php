<?php
	include_once "conn.php";
	$id = $_GET['id'];
	$sqlquery = "SELECT * FROM profile WHERE profileid=".$id;
	$result = mysql_query($sqlquery, $conn);
	$row = mysql_fetch_array($result);
	if($row["profiletype"] == 1) {$key[0] = "类型"; $value[0] = "地点";}
	if($row["profiletype"] == 2) {$key[0] = "类型"; $value[0] = "组织";}
	if($row["profiletype"] == 3) {$key[0] = "类型"; $value[0] = "人物";}

	if($row["profilesubtype"] == "NeGov") {$value[0] = $value[0]." 政府";}
	if($row["profilesubtype"] == "NeMan") {$value[0] = $value[0]." 男性";}
	if($row["profilesubtype"] == "NeAss") {$value[0] = $value[0]." 协会";}
	if($row["profilesubtype"] == "NeCo") {$value[0] = $value[0]." 企业";}
	if($row["profilesubtype"] == "NeWom") {$value[0] = $value[0]." 女性";}
	if($row["profilesubtype"] == "NeCty") {$value[0] = $value[0]." 城市";}
	if($row["profilesubtype"] == "NeSch") {$value[0] = $value[0]." 大学";}
	if($row["profilesubtype"] == "NePrv") {$value[0] = $value[0]." 省份";}
	if($row["profilesubtype"] == "NeCtr") {$value[0] = $value[0]." 国家";}
	if($row["profilesubtype"] == "NeMed") {$value[0] = $value[0]." 媒体";}
	if($row["profilesubtype"] == "NeArm") {$value[0] = $value[0]." 军队";}

	$sqlsentence = mysql_query("SELECT text FROM doc WHERE file = \"".$row["sourcedoc"]."\" AND sentenceid = ".$row["sourceid"], $conn);
	$sentencerow = mysql_fetch_array($sqlsentence);
	$key[1] = "来源"; $value[1] = $sentencerow["text"];
	$key[2] = "VIP"; if($row["vip"]) $value[2] = "是"; else $value[2] = "否";

	$pkey = 3;

	$sqlquery = "SELECT DISTINCT type, ne FROM relation WHERE sourceid=".$id." AND destid=0 AND type not like 'CeMODIFIERS'";
	$result = mysql_query($sqlquery, $conn);
	while($row = mysql_fetch_array($result))
	{
		switch ($row["type"]) {
			case "CePerPOSITION":
				$key[$pkey] = "职位";
				break;
			case "CeALIASES":
				$key[$pkey] = "别名";
				break;
			case "CePerTITLE":
				$key[$pkey] = "头衔";
				break;
			case "CeAGE":
				$key[$pkey] = "年龄";
				break;
			case "CePerCOLLEAGUES_R":
				$key[$pkey] = "同事";
				break;
			case "CePerBIRTHTIME":
				$key[$pkey] = "出生时间";
				break;
			case "CeXWHERE_FROM_OF":
				$key[$pkey] = "其来自于";
				break;
			case "CeOrgSTAFF":
				$key[$pkey] = "职员";
				break;
			case "CePerAFFILIATION":
				$key[$pkey] = "工作单位";
				break;
			case "CePerDEGREES":
				$key[$pkey] = "学位";
				break;
			case "CePerPARENTS":
				$key[$pkey] = "父母";
				break;
			case "CePerCHILDREN":
				$key[$pkey] = "子女";
				break;
			case "CeXBIRTHPLACE_OF":
				$key[$pkey] = "其出生地";
				break;
			case "CePerSIBLINGS_R":
				$key[$pkey] = "兄弟姐妹";
				break;
			case "CeOrgSeniorExecutive":
				$key[$pkey] = "高管";
				break;
			case "CeOrgSeniorExecutive_R":
				$key[$pkey] = "高管";
				break;
			case "CeOrgShareholder":
				$key[$pkey] = "股东";
				break;
			case "CeOrgShareholder_R":
				$key[$pkey] = "股东";
				break;
			case "CeOrgEstablishmentTime":
				$key[$pkey] = "创建时间";
				break;
			case "CeOrgEstablishmentTime":
				$key[$pkey] = "创建时间";
				break;
			case "CeOrgSeniorExecutive":
				$key[$pkey] = "创建人";
				break;
			case "CeOrgSeniorExecutive_R":
				$key[$pkey] = "创建人";
				break;

			
			default:
				$key[$pkey] = $row["type"];
				break;
		}
		$value[$pkey] = $row["ne"];
		$pkey++;
	}

	$info = array();
	for ($i = 0; $i < $pkey ;$i++) {
		$item = array($key[$i]=>$value[$i]);
		array_push($info, $item);
	}
	echo json_encode($info);
?>

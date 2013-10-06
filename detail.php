<?php
	include_once "conn.php";
	$id = $_GET['id'];
	$name = $_GET['name'];
	
	$result = mysql_query("select type from profile where id=".$id);
	$row = mysql_fetch_array($result);
	$type = $row["type"];
	
	$sqlquery = "select distinct destid,name,relation.type,relation.content from relation,profile where relation.sourceid=\"".$id."\" ";
	$sqlquery = $sqlquery."and relation.type in ( \"CeAGE\" , \"CeALIASES\" , \"CeBIRTHPLACE\" , \"CeLOCATION\" , \"CeLOCATION_OF\" , \"CeOrgSTAFF\" , \"CePerAFFILIATION\" , \"CePerBIRTHTIME\" , \"CePerCHILDREN\" , \"CePerCOLLEAGUES\" , \"CePerCOLLEAGUES_R\" , \"CePerDEGREES\" , \"CePerEDUCATION\" , \"CePerFAMILY\" , \"CePerFAMILY_R\" , \"CePerPARENTS\" , \"CePerPOSITION\" , \"CePerRELATIVE\" , \"CePerRELATIVE_R\" , \"CePerSIBLINGS\" , \"CePerSIBLINGS_R\" , \"CePerSPOUSE\" , \"CePerSPOUSE_R\" , \"CePerTITLE\" , \"CePerWHERE_FROM\" , \"CeTRAINEE\" , \"CeXBIRTHPLACE_OF\" , \"CeXWHERE_FROM_OF\" ) ";
	$sqlquery = $sqlquery."and profile.id = destid ORDER BY relation.type ASC";
?>
<style>
	.relationtable {
		font: 10px;
	}
</style>

<h2><?php echo $name; ?></h2>
<p>
<button type="button" onclick="window.open('graph.php?id=<?php echo $id; ?>&depth=1&per=per&loc=loc&org=org&self=self&name=<?php echo $name; ?>&type=<?php echo $type; ?>')">快速检索实体</button>
<button type="button" onclick="window.open('index.php')">设置高级条件</button>
</p>
<div class="relationtable"><p>

<?php
	$result = mysql_query($sqlquery);
	
	while ($row = mysql_fetch_array($result))
	{
		if($row["type"] == "CeAGE") echo "年龄: ";
		if($row["type"] == "CeALIASES") echo "别名: ";
		if($row["type"] == "CeBIRTHPLACE") echo "出生地: ";
		if($row["type"] == "CeLOCATION") echo "位置: ";
		if($row["type"] == "CeLOCATION_OF") echo "其位置: ";
		if($row["type"] == "CeOrgSTAFF") echo "职员: ";
		if($row["type"] == "CePerAFFILIATION") echo "工作单位: ";
		if($row["type"] == "CePerBIRTHTIME") echo "出生时间: ";
		if($row["type"] == "CePerCHILDREN") echo "子女: ";
		if($row["type"] == "CePerCOLLEAGUES") echo "同事: ";
		if($row["type"] == "CePerCOLLEAGUES_R") echo "同事: ";
		if($row["type"] == "CePerDEGREES") echo "学位: ";
		if($row["type"] == "CePerEDUCATION") echo "教育: ";
		if($row["type"] == "CePerFAMILY") echo "家人: ";
		if($row["type"] == "CePerFAMILY_R") echo "家人: ";
		if($row["type"] == "CePerPARENTS") echo "父母: ";
		if($row["type"] == "CePerPOSITION") echo "职位: ";
		if($row["type"] == "CePerRELATIVE") echo "亲属: ";
		if($row["type"] == "CePerRELATIVE_R") echo "亲属: ";
		if($row["type"] == "CePerSIBLINGS") echo "兄弟姐妹: ";
		if($row["type"] == "CePerSIBLINGS_R") echo "兄弟姐妹: ";
		if($row["type"] == "CePerSPOUSE") echo "丈夫: ";
		if($row["type"] == "CePerSPOUSE_R") echo "妻子: ";
		if($row["type"] == "CePerTITLE") echo "头衔: ";
		if($row["type"] == "CePerWHERE_FROM") echo "来自: ";
		if($row["type"] == "CeTRAINEE") echo "受训者: ";
		if($row["type"] == "CeXBIRTHPLACE_OF") echo "其出生地: ";
		if($row["type"] == "CeTRAINEE") echo "受训者: ";
		if($row["type"] == "CeXWHERE_FROM_OF") echo "其来自于: ";
		
		if($row["destid"] != "0") echo $row["name"]." <br />\n";
		else echo $row["content"]." <br />\n";
	}
?>
</p>

</div>
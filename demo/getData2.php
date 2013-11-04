<?php
	include_once "conn.php";
	$id = $_GET['id'];
	$per = $_GET['per'];
	$loc = $_GET['loc'];
	$org = $_GET['org'];
	$num = $_GET['num'];
	$graph = $_GET['graph'];
	$coexist = $_GET['coexist'];
	$tstart = $_GET['tstart'];
	$tend = $_GET['tend'];

	$clockstart = microtime();

	$sqlquery = "SELECT DISTINCT relation.destid, relation.type rtype, profile.profilename, profile.profiletype ptype, profile.mentions FROM relation, profile WHERE relation.sourceid=".$id." AND relation.destid!=0 ";
	if(!$coexist) $sqlquery = $sqlquery."AND relation.type not like 'CeCoexist%' ";
	if($tstart != "") $sqlquery = $sqlquery."AND relation.realtime > ".$tstart."00 ";
	if($tend != "") $sqlquery = $sqlquery."AND relation.realtime < ".$tend."00 ";
	if(!$loc) $sqlquery = $sqlquery."AND profile.profiletype != 1 ";
	if(!$org) $sqlquery = $sqlquery."AND profile.profiletype != 2 ";
	if(!$per) $sqlquery = $sqlquery."AND profile.profiletype != 3 ";
	$sqlquery = $sqlquery."AND relation.destid=profile.profileid ORDER BY relation.destid ASC";
	$result = mysql_query($sqlquery, $conn);
	
	//echo $sqlquery;

	$pnode = 1;
	$plink = 0;
	$nodeid[0] = $id;
	$nodeinfo = mysql_query("SELECT * FROM profile WHERE profileid = ".$id, $conn);
	$row = mysql_fetch_array($nodeinfo);
	$nodename[0] = $row["profilename"];
	$nodetype[0] = $row["profiletype"];
	$nodemention[0] = $row["mentions"];

	while($row = mysql_fetch_array($result))
	{
		if($row["destid"] == $nodeid[$pnode - 1]) continue;
		$nodeid[$pnode] = $row["destid"];
		$nodename[$pnode] = $row["profilename"];
		$nodetype[$pnode] = $row["ptype"];
		$nodemention[$pnode] = $row["mentions"];
		$pnode++;

		$linksource[$plink] = $id;
		$linktarget[$plink] = $row["destid"];
		$linktype[$plink] = $row["rtype"];
		$linkinfo = mysql_query("SELECT COUNT(*) FROM relation WHERE sourceid = ".$id." AND destid = ".$row["destid"], $conn);
		$count = mysql_fetch_array($linkinfo);
		$linkweight[$plink] = $count["COUNT(*)"];
		$plink++;
		
		if($pnode > $num) break;
	}
	/*get nodes*/
	$nodes = array();	//store the node info
	for ($i = 0; $i < $pnode; $i++) {
		$node = array("id"=>$nodeid[$i], "name"=>$nodename[$i], "type"=>$nodetype[$i], "mention"=>$nodemention[$i]);
		//echo "<br />";
		//echo $nodeid[$i];
		array_push($nodes, $node);
	}

	if($graph && ($pnode > 1))
	{
		$sqlquery = "SELECT DISTINCT sourceid, destid, type FROM relation WHERE sourceid in (".$nodeid[1];
		for($i = 2; $i < $pnode; $i++)
			$sqlquery = $sqlquery.",".$nodeid[$i];
		$sqlquery = $sqlquery.") AND destid in (".$nodeid[1];
		for($i = 2; $i < $pnode; $i++)
			$sqlquery = $sqlquery.",".$nodeid[$i];
		$sqlquery = $sqlquery.") ";
		if(!$coexist) $sqlquery = $sqlquery."AND type not like 'CeCoexist%' ";
		if($tstart != "") $sqlquery = $sqlquery."AND realtime > ".$tstart."00 ";
		if($tend != "") $sqlquery = $sqlquery."AND realtime < ".$tend."00 ORDER BY sourceid ASC";


		$result = mysql_query($sqlquery, $conn);
		while($row = mysql_fetch_array($result))
		{
			$linksource[$plink] = $row["sourceid"];
			$linktarget[$plink] = $row["destid"];
			$linktype[$plink] = $row["type"];
			$linkinfo = mysql_query("SELECT COUNT(*) FROM relation WHERE sourceid = ".$row["sourceid"]." AND destid = ".$row["destid"], $conn);
			$count = mysql_fetch_array($linkinfo);
			$linkweight[$plink] = $count["COUNT(*)"];
			$plink++;
		}
	}

	for($i = 0; $i < $plink; $i++)
	{
		for($j = 0; $j < $pnode; $j++)
			if($linksource[$i] == $nodeid[$j])
			{
				$linksource[$i] = $j;
				break;
			}
		for($j = 0; $j < $pnode; $j++)
			if($linktarget[$i] == $nodeid[$j])
			{
				$linktarget[$i] = $j;
				break;
			}
	}

	/*get links*/
	$links = array();    //store the link
	for ($i = 0; $i < $plink; $i++) {
		$link = array("source"=>$linksource[$i], "target"=>$linktarget[$i], "type"=>$linktype[$i], "weight"=>$linkweight[$i]);
		array_push($links, $link);
	}

	$res = array("nodes"=>$nodes, "links"=>$links);

	echo json_encode($res);
?>
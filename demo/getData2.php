<?php
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

	$sqlquery = "SELECT DISTINCT relation.destid, relation.type rtype, profile.profiletype ptype, profile.mentions FROM relation, profile WHERE relation.sourceid=".$id." AND relation.destid!=0 ";
	if($coexist) $sqlquery = $sqlquery."AND relation.type not like 'CeCoexist%' ";
	if($tstart != "") $sqlquery = $sqlquery."AND relation.realtime > ".$tstart."00 ";
	if($tend != "") $sqlquery = $sqlquery."AND relation.realtime < ".$tend."00 ";
	if(!$loc) $sqlquery = $sqlquery."AND profile.profiletype != 1 ";
	if(!$org) $sqlquery = $sqlquery."AND profile.profiletype != 2 ";
	if(!$per) $sqlquery = $sqlquery."AND profile.profiletype != 3 ";
	$sqlquery = $sqlquery."AND relation.destid=profile.profileid LIMIT 0,".$num;
	$result = mysql_query($sqlquery);
?>
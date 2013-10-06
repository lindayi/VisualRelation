<?php
	include_once "conn.php";
	include_once "function.php";

	$id = $_GET['id'];
	$depth = $_GET['depth'];

	$per = $_GET['per'];
	$loc = $_GET['loc'];
	$org = $_GET['org'];
	$self = $_GET['self'];
	
	$max = $_GET['max'];
	
	if(!$max) $max=100;
	
	$tstart = microtime();
?>
<!DOCTYPE html>
<meta charset="utf-8">
<style>

.node {
/*  stroke: #fff;
  stroke-width: 1.5px;*/
}

.link {
/*  fill: none;
  stroke: #bbb;*/
  fill: none;
/*  stroke: #666;*/
  stroke-width: 0.5px;
}

text {
  pointer-events: none;
/*  font: 12px normal;*/
  font:  12px normal "宋体",Arial,Times;
  fill:  white;
}

.black_overlay{
    display: none;
    position: absolute;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: black;
    z-index:1001;
    -moz-opacity: 0.5;
    opacity:.5;
    filter: alpha(opacity=50);
}

.white_content_small {
    display: none;
    position: absolute;
    top: 40%;
    left: 70%;
    width: 20%;
    height: 40%;
    border: 10px solid lightblue;
    background-color: white;
    z-index:1002;
    overflow: auto;
}

</style>
<body>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script>

var width = 1024,
    height = 800;

var color = d3.scale.category20();

var force = d3.layout.force().linkDistance(30).linkStrength(2).charge(-30).size([width, height]);

var svg = d3.select("body").append("svg").attr("width", width).attr("height", height);

// 背景
d3.select("body").transition().style("background-color", "grey");
</script>
<?php
	
	echo "<script>\n";
	$anum = 1;
	$nodeid[0] = $id;
	$nodename[0] = $_GET['name'];
	$nodetype[0] = $_GET['type'];
	$sqlquery = "select distinct relation.sourceid,destid,name,profile.type from relation,profile where relation.sourceid=\"".$nodeid[0]."\" and destid not like '0' ";
	if($per != "per") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_ORG_PER\" , \"CeCoexist_LOC_PER\" , \"CeCoexist_PER_PER\" , \"CeCoexist_PER_PER_R\" ) ";
	if($loc != "loc") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_LOC_LOC\" , \"CeCoexist_LOC_LOC_R\" , \"CeCoexist_ORG_LOC\" , \"CeCoexist_PER_LOC\" ) ";
	if($org != "org") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_LOC_ORG\" , \"CeCoexist_ORG_ORG\" , \"CeCoexist_ORG_ORG_R\" , \"CeCoexist_PER_ORG\" ) ";
	if($self != "self") $sqlquery = $sqlquery."and relation.type not in ( \"CeAGE\" , \"CeALIASES\" , \"CeBIRTHPLACE\" , \"CeLOCATION\" , \"CeLOCATION_OF\" , \"CeMODIFIERS\" , \"CeOrgSTAFF\" , \"CePerAFFILIATION\" , \"CePerBIRTHTIME\" , \"CePerCHILDREN\" , \"CePerCOLLEAGUES\" , \"CePerCOLLEAGUES_R\" , \"CePerDEGREES\" , \"CePerEDUCATION\" , \"CePerFAMILY\" , \"CePerFAMILY_R\" , \"CePerPARENTS\" , \"CePerPOSITION\" , \"CePerRELATIVE\" , \"CePerRELATIVE_R\" , \"CePerSIBLINGS\" , \"CePerSIBLINGS_R\" , \"CePerSPOUSE\" , \"CePerSPOUSE_R\" , \"CePerTITLE\" , \"CePerWHERE_FROM\" , \"CeTRAINEE\" , \"CeXBIRTHPLACE_OF\" , \"CeXMODIFIER_OF\" , \"CeXWHERE_FROM_OF\" ) ";
	$sqlquery = $sqlquery."and profile.id = destid";
	$result = mysql_query($sqlquery);
	
	while ($row = mysql_fetch_array($result))
	{
		if (checkid($row["destid"], $nodeid, $anum)) continue;
		$nodeid[$anum] = $row["destid"];
		$nodename[$anum] = $row["name"];
		$nodetype[$anum] = $row["type"];
		$anum = $anum + 1;
		if($anum > $max) break;
	}
	$depth = $depth - 1;
	$dnow = 1;
	for(; $depth > 0; $depth = $depth - 1)
	{
		$sqlquery = "select distinct relation.sourceid,destid,name,profile.type from relation,profile where relation.sourceid in (\"".$nodeid[$dnow]."\"";
		for($i = $dnow+1; $i < $anum; $i++)
		{
			$sqlquery = $sqlquery." ,\"".$nodeid[$i]."\"";
		}
		$dnow = $anum;
		$sqlquery = $sqlquery.") and destid not like '0' ";
		if($per != "per") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_ORG_PER\" , \"CeCoexist_LOC_PER\" , \"CeCoexist_PER_PER\" , \"CeCoexist_PER_PER_R\" ) ";
		if($loc != "loc") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_LOC_LOC\" , \"CeCoexist_LOC_LOC_R\" , \"CeCoexist_ORG_LOC\" , \"CeCoexist_PER_LOC\" ) ";
		if($org != "org") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_LOC_ORG\" , \"CeCoexist_ORG_ORG\" , \"CeCoexist_ORG_ORG_R\" , \"CeCoexist_PER_ORG\" ) ";
		if($self != "self") $sqlquery = $sqlquery."and relation.type not in ( \"CeAGE\" , \"CeALIASES\" , \"CeBIRTHPLACE\" , \"CeLOCATION\" , \"CeLOCATION_OF\" , \"CeMODIFIERS\" , \"CeOrgSTAFF\" , \"CePerAFFILIATION\" , \"CePerBIRTHTIME\" , \"CePerCHILDREN\" , \"CePerCOLLEAGUES\" , \"CePerCOLLEAGUES_R\" , \"CePerDEGREES\" , \"CePerEDUCATION\" , \"CePerFAMILY\" , \"CePerFAMILY_R\" , \"CePerPARENTS\" , \"CePerPOSITION\" , \"CePerRELATIVE\" , \"CePerRELATIVE_R\" , \"CePerSIBLINGS\" , \"CePerSIBLINGS_R\" , \"CePerSPOUSE\" , \"CePerSPOUSE_R\" , \"CePerTITLE\" , \"CePerWHERE_FROM\" , \"CeTRAINEE\" , \"CeXBIRTHPLACE_OF\" , \"CeXMODIFIER_OF\" , \"CeXWHERE_FROM_OF\" ) ";
		$sqlquery = $sqlquery."and profile.id = destid";
		$result = mysql_query($sqlquery);
		while ($row = mysql_fetch_array($result))
		{
			if (checkid($row["destid"], $nodeid, $anum)) continue;
			$nodeid[$anum] = $row["destid"];
			$nodename[$anum] = $row["name"];
			$nodetype[$anum] = $row["type"];
			$anum = $anum + 1;
			if($anum > $max) break;
		}
	}

	$sqlquery = "select distinct sourceid,destid from relation where (sourceid in (\"".$nodeid[0]."\"";
	for($i = 1; $i < $anum; $i++)
		$sqlquery = $sqlquery." , \"".$nodeid[$i]."\"";
	$sqlquery = $sqlquery.")) and (destid in (\"".$nodeid[0]."\"";
	for($i = 1; $i < $anum; $i++)
		$sqlquery = $sqlquery." , \"".$nodeid[$i]."\"";
	$sqlquery = $sqlquery.")) ";
	if($per != "per") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_ORG_PER\" , \"CeCoexist_LOC_PER\" , \"CeCoexist_PER_PER\" , \"CeCoexist_PER_PER_R\" ) ";
	if($loc != "loc") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_LOC_LOC\" , \"CeCoexist_LOC_LOC_R\" , \"CeCoexist_ORG_LOC\" , \"CeCoexist_PER_LOC\" ) ";
	if($org != "org") $sqlquery = $sqlquery."and relation.type not in ( \"CeCoexist_LOC_ORG\" , \"CeCoexist_ORG_ORG\" , \"CeCoexist_ORG_ORG_R\" , \"CeCoexist_PER_ORG\" ) ";
	if($self != "self") $sqlquery = $sqlquery."and relation.type not in ( \"CeAGE\" , \"CeALIASES\" , \"CeBIRTHPLACE\" , \"CeLOCATION\" , \"CeLOCATION_OF\" , \"CeMODIFIERS\" , \"CeOrgSTAFF\" , \"CePerAFFILIATION\" , \"CePerBIRTHTIME\" , \"CePerCHILDREN\" , \"CePerCOLLEAGUES\" , \"CePerCOLLEAGUES_R\" , \"CePerDEGREES\" , \"CePerEDUCATION\" , \"CePerFAMILY\" , \"CePerFAMILY_R\" , \"CePerPARENTS\" , \"CePerPOSITION\" , \"CePerRELATIVE\" , \"CePerRELATIVE_R\" , \"CePerSIBLINGS\" , \"CePerSIBLINGS_R\" , \"CePerSPOUSE\" , \"CePerSPOUSE_R\" , \"CePerTITLE\" , \"CePerWHERE_FROM\" , \"CeTRAINEE\" , \"CeXBIRTHPLACE_OF\" , \"CeXMODIFIER_OF\" , \"CeXWHERE_FROM_OF\" ) ";

	$result = mysql_query($sqlquery, $conn);
	$row = mysql_fetch_array($result);
	echo "var graph = {\n";
	echo "\"links\": [{\n";
	echo "\"source\": \"".getnum($row["sourceid"], $nodeid, $anum)."\",\n";
	$tmpnum = getnum($row["destid"], $nodeid, $anum);
	echo "\"target\": \"".$tmpnum."\",\n";
	if ($nodetype[$tmpnum] == "LocationProfile") echo "\"value\": \"1\"\n}";
	else if ($nodetype[$tmpnum] == "OrgProfile") echo "\"value\": \"2\"\n}";
	else if ($nodetype[$tmpnum] == "PersonProfile") echo "\"value\": \"3\"\n}";

	while ($row = mysql_fetch_array($result))
	{
		if (getnum($row["sourceid"], $nodeid, $anum) == getnum($row["destid"], $nodeid, $anum)) continue;
		if ($judge[getnum($row["destid"], $nodeid, $anum)][getnum($row["sourceid"], $nodeid, $anum)] == 1) continue;
		echo ", {\n";
		echo "\"source\": \"".getnum($row["sourceid"], $nodeid, $anum)."\",\n";
		$tmpnum = getnum($row["destid"], $nodeid, $anum);
		echo "\"target\": \"".$tmpnum."\",\n";
		if ($nodetype[$tmpnum] == "LocationProfile") echo "\"value\": \"1\"\n}";
		else if ($nodetype[$tmpnum] == "OrgProfile") echo "\"value\": \"2\"\n}";
		else if ($nodetype[$tmpnum] == "PersonProfile") echo "\"value\": \"3\"\n}";
		$judge[getnum($row["sourceid"], $nodeid, $anum)][getnum($row["destid"], $nodeid, $anum)] = 1;
	}
	
	echo "],\n\"nodes\":[{\n";
	echo "\"count\": 10,\n";
	echo "\"id\": ".$nodeid[0].",\n";
	if ($nodetype[0] == "PersonProfile") echo "\"group\": \"1\",\n";
	if ($nodetype[0] == "OrgProfile") echo "\"group\": \"2\",\n";
	if ($nodetype[0] == "LocationProfile") echo "\"group\": \"3\",\n";
	echo "\"name\": \"".$nodename[0]."\"\n}";
	for($i = 1; $i < $anum; $i++)
	{
		echo ", {\n\"count\": 10,\n";
		echo "\"id\": ".$nodeid[$i].",\n";
		if ($nodetype[$i] == "PersonProfile") echo "\"group\": \"1\",\n";
		if ($nodetype[$i] == "OrgProfile") echo "\"group\": \"2\",\n";
		if ($nodetype[$i] == "LocationProfile") echo "\"group\": \"3\",\n";
		echo "\"name\": \"".$nodename[$i]."\"\n}";
	}
	echo "]\n};";
	$load = microtime();
	$StartMicro = substr($tstart,0,10);
	$StartSecond = substr($tstart,11,10);
	$StopMicro = substr($load,0,10);
	$StopSecond = substr($load,11,10);
	$start = floatval($StartMicro) + $StartSecond;
	$stop = floatval($StopMicro) + $StopSecond;
	echo "\nd3.select(\"body\").append(\"span\").text(\"检索：".round($stop-$start,3)."s\");"
?>
</script>
<script>
var nodes = graph.nodes.slice(),
	links = [],
	bilinks = [];

graph.links.forEach(function(link) {
	var s = nodes[link.source],
		t = nodes[link.target],
		i = {}; // intermediate node
    v = link.value;
	nodes.push(i);
	links.push({
		source: s,
		target: i
	}, {
		source: i,
		target: t
	});
	bilinks.push([s, i, t ,v ]);
});

force.nodes(nodes).links(links).start();

var link = svg.selectAll(".link").data(bilinks)
                  .enter().append("path")
                  .attr("class","link")
                  .style("stroke", function(d) { 
                    //console.log(d);
                    if(d[3] != null) { 
                      if(d[3] == "1"){
                      //  console.log(d[3]);
                        return color("1");
                      }else if(d[3] == "2"){
                        return color("2");
                      }else if(d[3] == "3"){
			return color("3");
		      }else return color("4");
                    }; 
                  })
		  .style("stroke-width",1.2);

var node = svg.selectAll(".node").data(graph.nodes)
                  .enter().append("g")
                  .attr("class", "node")
				  .attr("onclick", function(d){
					return "document.getElementById(\"detail\").src = 'detail.php?id="+d.id+"&name="+d.name+"'; ShowDiv('MyDiv','fade');";})
                  .call(force.drag);

              //小圆   2.5-7.5
              node.append("circle").attr("class", "node")
              .attr("r", function(d){
                console.log(d.count/2)
                if(d.count/2<2){
                  return 2.5;
                }else{
                  return d.count/2;
                }
              })              
              .style("fill", function(d) {
          //      console.log(d);
          //      return color(d.group);
                return color(d.group+"")
              });


node.append("text")
                .attr("dx", 12)
                .attr("dy",".35em")
                .attr("class","text")
                .text(function(d) {
                return d.name
              });

force.on("tick", function() {
                link.attr("d", function(d) {
                  return "M" + d[0].x + "," + d[0].y + "S"
                      + d[1].x + "," + d[1].y + " "
                      + d[2].x + "," + d[2].y;
                });
                node.attr("transform",function(d) {
                  return "translate(" + d.x + "," + d.y + ")";
                });
              });
</script>
    <div id="fade" class="black_overlay"></div>
    <div id="MyDiv" class="white_content_small">
        <div style="text-align: right; cursor: default; height: 20px;">
            <span style="font-size: 16px;" onclick="CloseDiv('MyDiv','fade')">×</span>
        </div>
		<iframe id="detail" frameborder=0 height="90%" width="100%" ></iframe>
    </div>
<?php
	$load2 = microtime();
	$StartMicro = substr($load,0,10);
	$StartSecond = substr($load,11,10);
	$StopMicro = substr($load2,0,10);
	$StopSecond = substr($load2,11,10);
	$start = floatval($StartMicro) + $StartSecond;
	$stop = floatval($StopMicro) + $StopSecond;
	echo "<script>d3.select(\"body\").append(\"span\").text(\"绘图：".round($stop-$start,6)."s\");</script>"
?>
</body>
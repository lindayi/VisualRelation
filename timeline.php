<?php
	include_once "conn.php";
	include_once "function.php";
	$name = $_GET['name'];
	$type = $_GET['type'];
	$id = $_GET['id'];
?>

<html>
<head>
    <!-- jQuery -->
    <script type="text/javascript" src="lib/jquery-min.js"></script>
    <!-- BEGIN TimelineJS -->
    <script type="text/javascript" src="js/storyjs-embed.js"></script>
    <script>
	var dataObject = {
		"timeline":
		{
			"headline":"<?php echo $name; ?> 的时间轴",
			"type":"default",
			"text":"<p>点击右侧箭头，进入时间轴</p>",
			"asset": {},
			"date": [
			<?php
				$sqlquery = "select distinct relation.destid, relation.realtime, profile.name, profile.type from relation,profile where relation.sourceid=".$id." and relation.destid=id and realtime not like \"\" and relation.type not in ( \"CeMODIFIERS\",\"CeXMODIFIER_OF\")";
				$result = mysql_query($sqlquery);
				$row = mysql_fetch_array($result);
				
				echo "{\n\"startDate\":\"".proctime($row["realtime"],0)."\",\n";
				echo "\"endDate\":\"".proctime($row["realtime"],1)."\",\n";
				if($row["name"]) {
					echo "\"headline\":\"".$row["name"]."\",\n";
					$result2 = mysql_query("select type,content from relation where sourceid=".$id." and destid=".$row["destid"]." and realtime not like \"\" and type not like \"CeMODIFIERS\"");
					$row2 = mysql_fetch_array($result2);
					echo "\"text\":\"<p>类型：".$row2["type"]."</p><p>来源：".$row2["content"]."</p>\",\n";
					echo "\"tag\":\""; if($row["type"]=="PersonProfile") echo "人物"; else if($type=="LocationProfile") echo "地点"; else echo "组织"; echo "\",\n";
				}
				else {
					$result2 = mysql_query("select type,content from relation where sourceid=".$id." and destid=".$row["destid"]." and realtime not like \"\" and type not like \"CeMODIFIERS\"");
					$row2 = mysql_fetch_array($result2);
					$content = replace_html_tag($row2["content"], 'title');
					if (substr($content,0,6) == "<body>") $content = substr($content,6,strlen($content)-6); 
					echo "\"headline\":\"".$row2["content"]."\",\n"; 
					echo "\"text\":\"<p>类型：".$row2["type"]."</p>\",\n";
					echo "\"tag\":\""; if($type=="PersonProfile") echo "人物"; else if($type=="LocationProfile") echo "地点"; else echo "组织"; echo "\",\n";
				}
				echo "\"asset\": {}\n}\n";
				
				while($row = mysql_fetch_array($result))
				{
					echo ",{\n\"startDate\":\"".proctime($row["realtime"],0)."\",\n";
					echo "\"endDate\":\"".proctime($row["realtime"],1)."\",\n";
					if($row["name"]) {
						echo "\"headline\":\"".$row["name"]."\",\n"; 
						$result2 = mysql_query("select type,content from relation where sourceid=".$id." and destid=".$row["destid"]." and realtime not like \"\" and type not like \"CeMODIFIERS\"");
						$row2 = mysql_fetch_array($result2);
						$content = replace_html_tag($row2["content"], 'title');
						if (substr($content,0,6) == "<body>") $content = substr($content,6,strlen($content)-6); 
						echo "\"text\":\"<p>类型：".$row2["type"]."</p><p>来源：".$content."</p>\",\n";
						echo "\"tag\":\""; if($row["type"]=="PersonProfile") echo "人物"; else if($type=="LocationProfile") echo "地点"; else echo "组织"; echo "\",\n";
					}
					else {
						$result2 = mysql_query("select type,content from relation where sourceid=".$id." and destid=".$row["destid"]." and realtime not like \"\" and type not like \"CeMODIFIERS\"");
						$row2 = mysql_fetch_array($result2);
						$content = replace_html_tag($row2["content"], 'title');
						if (substr($content,0,6) == "<body>") $content = substr($content,6,strlen($content)-6); 
						echo "\"headline\":\"".$row2["content"]."\",\n"; 
						echo "\"text\":\"<p>类型：".$row2["type"]."</p>\",\n";
						echo "\"tag\":\""; if($type=="PersonProfile") echo "人物"; else if($type=="LocationProfile") echo "地点"; else echo "组织"; echo "\",\n";
					}
					echo "\"asset\": {}\n}\n";
				}
			?>
			],
			"era": []
		}
	}
    $(document).ready(function() {
        createStoryJS({
            type:       'timeline',
            source:     dataObject,
            embed_id:   'my-timeline'
        });
    });
	</script>
    <!-- END TimelineJS -->
</head>
<body>  
    <div id="my-timeline"></div>
</body>
</html>
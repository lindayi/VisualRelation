<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关系可视化模型</title>
<link href="css/index.css" type=text/css rel=stylesheet>
</head>

<?php
	include_once "conn.php";
	include_once "function.php";
	
	$name = $_GET['name'];
	$result = mysql_query("SELECT id,type FROM profile where name like \"$name\"", $conn);
	
	if (!($row = mysql_fetch_array($result)))
	{
		echo "<script>alert(\"对不起，没有查找到 ".$name." 的数据。\"); history.back() </script>";
	}
	
	$id[0] = $row["id"];
	$type = $row["type"];
	if (!($row = mysql_fetch_array($result)))
	{
		$search = $_GET['search'];
		if ($search == "graph")
		{
			$depth = $_GET['depth'];
			$per = $_GET['per'];
			$loc = $_GET['loc'];
			$org = $_GET['org'];
			$self = $_GET['self'];
			echo "<script>window.location.href='graph.php?id=".$id[0]."&depth=".$depth."&per=".$per."&loc=".$loc."&org=".$org."&self=".$self."&name=".$name."&type=".$type."';</script>";
		}
		else
			echo "<script>window.location.href='timeline.php?id=".$id[0]."&name=".$name."&type=".$type."';</script>";
	}
	else $num = 1;
	do
	{
		$id[$num] = $row["id"];
		$num++;
	}while($row = mysql_fetch_array($result));
?>

<body>

<table width="100%" height="100%" align="center">
<tr height="90%"><td>
    <table align="center">
        <tr>
          <td height="89" colspan="2"><h1 align="center" class="text">检索到多个<?php echo $name;?>，请选择：</h1></td>
        </tr>
        <tr>
        <!--<td width="180" valign="top"><img src="image/xupt.png" height="150"></td>-->
        <td valign="top">
            <div class="nTab">
                <div class="TabTitle">
                    <ul id="myTab" style="font-size:9px">
                        <li class="active" onclick="nTabs(this,0);"><?php echo $id[0];?></li>
						<?php
							for($i = 1; $i < $num; $i++)
								echo "<li class=\"normal\" onclick=\"nTabs(this,".$i.");\">".$id[$i]."</li>\n";
						?>
                    </ul>
                </div>
                <div class="TabContent">
                    <div id="myTab_Content0">
						<?php
							$result = mysql_query("SELECT relation.type,relation.content,profile.name,profile.type ptype FROM relation,profile where relation.sourceid = ".$id[0]." and relation.destid = profile.id limit 0,10", $conn);
							echo "<div class=\"text\" align=\"center\"> <p> \n";
							$search = $_GET['search'];
							echo "<p>部分关联实体</p>";
							echo "<table width=\"400\" border=\"1px\" bordercolor=white class=\"text\"> \n";
							while ($row = mysql_fetch_array($result))
							{
								echo "<tr> \n";
								if($row["name"] != "") echo "<td width=\"40%\">".$row["type"]."</td>"."<td>".$row["name"]."</td> \n";
								else echo "<td width=\"40%\">".$row["type"]."</td>"."<td>".$row["content"]."</td> \n";
								echo "</tr> \n";
							}
							echo "</table>";
							echo "</p>\n";
							if ($search == "graph")
							{
								$depth = $_GET['depth'];
								$per = $_GET['per'];
								$loc = $_GET['loc'];
								$org = $_GET['org'];
								$self = $_GET['self'];
								echo "<input onclick=\"window.location.href='graph.php?id=".$id[0]."&depth=".$depth."&per=".$per."&loc=".$loc."&org=".$org."&self=".$self."&name=".$name."&type=".$type."'\" type=\"button\" value=\"检索此实体\">";
								
							}
							else
								echo "<input onclick=\"window.location.href='timeline.php?id=".$id[0]."&name=".$name."&type=".$type."'\" type=\"button\" value=\"检索此实体\">";

							echo "</div>\n";
						?>
                    </div>
					<?php
						for($i = 1; $i < $num; $i++)
						{
							$result = mysql_query("SELECT relation.type,profile.name,relation.content,profile.type ptype FROM relation,profile where relation.sourceid = ".$id[$i]." and relation.destid = profile.id limit 0,10", $conn);
							echo "<div id=\"myTab_Content".$i."\" class=\"none\">\n";
							echo "<div class=\"text\" align=\"center\"> <p> \n";
							echo "<p>部分关联实体</p>";
							echo "<table width=\"400\" border=\"1px\" bordercolor=white class=\"text\"> \n";
							while ($row = mysql_fetch_array($result))
							{
								echo "<tr> \n";
								if($row["name"] != "") echo "<td width=\"40%\">".$row["type"]."</td>"."<td>".$row["name"]."</td> \n";
								else echo "<td width=\"40%\">".$row["type"]."</td>"."<td>".$row["content"]."</td> \n";
								echo "</tr> \n";
							}
							echo "</table>";
							echo "</p>\n";
							if ($search == "graph")
							{
								$depth = $_GET['depth'];
								$per = $_GET['per'];
								$loc = $_GET['loc'];
								$org = $_GET['org'];
								$self = $_GET['self'];
								echo "<input onclick=\"window.location.href='graph.php?id=".$id[$i]."&depth=".$depth."&per=".$per."&loc=".$loc."&org=".$org."&self=".$self."&name=".$name."&type=".$type."'\" type=\"button\" value=\"检索此实体\">";
							}
							else
								echo "<input onclick=\"window.location.href='timeline.php?id=".$id[$i]."&name=".$name."&type=".$type."'\" type=\"button\" value=\"检索此实体\">";
							echo "</div>\n</div>\n";
						}
					?>
                </div>
            </div>
        </td>
        </tr>
    </table>
</td></tr>
<tr height="10%">
<td align="center" class="footer">
	Copyright © 2013<br />
    Visualization Powered by <a href="http://www.lindayi.tk"> Lin Dayi </a>
</td>
</tr>
</table>
</body>

</html>

<?php
	include_once "conn.php";
	$keyword = $_GET['keyword'];
	$result = mysql_query("SELECT profileid FROM profile where profilename like \"".$keyword."\"", $conn);
	
	if (!($row = mysql_fetch_array($result)))
	{
		$aliasresult = mysql_query("SELECT profileid, profilename FROM profile,relation WHERE profileid = relation.sourceid AND relation.type = 'CeALIASES' AND relation.ne = '".$keyword."'");
		if (!($aliasrow = mysql_fetch_array($aliasresult)))
			echo "<script>alert(\"对不起，没有查找到 ".$keyword." 的数据。\"); history.back() </script>";
		else
			echo "<script>window.location.href='graph.php?id=".$aliasrow["profileid"]."&keyword=".$aliasrow["profilename"]."';</script>";
		
	}
	
	$id[0] = $row["profileid"];
	if (!($row = mysql_fetch_array($result)))
		echo "<script>window.location.href='graph.php?id=".$id[0]."&keyword=".$keyword."';</script>";
	else $num = 1;
	do
	{
		$id[$num] = $row["profileid"];
		$num++;
	}while($row = mysql_fetch_array($result));
?> 
<!DOCTYPE html>
<html>
<head>
	<title>关系可视化 v3</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<style type="text/css">
	body {
		padding-top: 40px;
		padding-bottom: 40px;
		position: relative;
		font-family:"ff-tisa-web-pro-1","ff-tisa-web-pro-2","Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","Microsoft YaHei UI","Microsoft YaHei","WenQuanYi Micro Hei",sans-serif;
	}
	</style>
</head>

<body style="background-color:#000; background-image:url(img/bg.jpg); background-repeat:no-repeat; background-position:top; background-size:cover;">

<!-- 导航 -->
<div class="container">
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<a class="brand" href="#">关系可视化 v3</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="divider-vertical"></li>
						<li><a href="index.html">首　　页</a></li>
						<li><a href="index.html">上传数据</a></li>
						<li><a href="index.html">使用说明</a></li>
						<li><a href="index.html">管理登录</a></li>
					</ul>

					<ul class="nav pull-right">
						<li class="divider-vertical"></li>
						<li class="dropdown">
							<a href="#"  class="dropdown-toggle" data-toggle="dropdown">Language<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="active"><a href="#">简体中文</a></li>
								<li><a href="#">正體中文</a></li>
								<li><a href="#">English</a></li>
							</ul>
						</li>
					</ul>
					<form class="navbar-search pull-right" action="findid.php" method="get">
						<input type="text" name="keyword" class="search-query span2" placeholder="<?php echo $keyword;?>">
					</form>
				</div><!-- /.nav-collapse-->
			</div>
		</div><!-- /navbar-inner-->
    </div><!-- /navbar-->
</div>

<!-- 内容 -->
<div class="container">
	<div class="row" style="text-align:center;">
		<h1 style="padding-top:50px; color:#FFF">检索到多个同名<?php echo $keyword?>，请选择：</h1>
        <p>&nbsp;</p>
	</div>
	<div class="row span7 offset2">
		<div class="bs-docs-example">
			<ul id="myTab" class="nav nav-tabs">
				<li class="active"><a href="#pro1" data-toggle="tab"><?php echo $keyword."#1";?></a></li>
				<?php
				for($i = 2; $i <= $num; $i++)
					echo "				<li><a href=\"#pro".$i."\" data-toggle=\"tab\">".$keyword."#".$i."</a></li>\n";
				?>
			</ul>
			<div id="myTabContent" class="tab-content">
            <?php
				for($i = 1; $i <= $num; $i++)
				{
					echo "<div class=\"tab-pane fade";
					if($i == 1) echo " in active";
					echo "\" id=\"pro".$i."\" style=\"color:#FFF\">\n";
					$result = mysql_query("SELECT DISTINCT type,ne FROM relation where sourceid = ".$id[$i-1]." limit 0,10", $conn);
					echo "<h3>部分关联实体</h3>\n";
					echo "<table width=\"100%\" border=\"1px\" bordercolor=white class=\"text\"> \n";
					while ($row = mysql_fetch_array($result))
					{
						echo "	<tr> \n";
						echo "		<td width=\"40%\">".$row["type"]."</td>"."<td>".$row["ne"]."</td> \n";
						echo "	</tr> \n";
					}
					echo "</table>\n";
					echo "<div style=\"padding-top:10px\"><button class=\"btn btn-large btn-info btn-block\" onclick=\"jump(".$id[$i-1].");\">检索此实体</button></div>\n";
					echo "</div>\n";
				}
			?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.js"></script>
<script>
function jump(id)
{
	window.location="graph.php?id=" + id + "&keyword=<?php echo $keyword; ?>";
	//console.
}
</script>
</body>
</html>

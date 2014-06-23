<?php
	include_once "conn.php";
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
						<li class="active"><a href="update.php">上传数据</a></li>
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
		<h1 style="padding-top:50px; color:#FFF">数据更新完成！...[4 / 4]</h1>
		<h3 style="color:#FFF">&nbsp;</h3>
		<h4 style="color:#FFF">&nbsp;</h4>
		<p>&nbsp;</p>
	</div>

	<div class="row" style="text-align:center;">
		<div class="progress progress-striped active">
			<div class="bar" style="width: 100%;"></div>
		</div>
		<a class="btn btn-large btn-primary" href="index.html">返回首页</a>
	</div>

</div>

<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.js"></script>
<?php
	flush();
	mysql_query("truncate doc");
	mysql_query("truncate profile");
	mysql_query("truncate relation");
	$sql = file_get_contents("./upload/resort_doc.sql");
	$sql = rtrim($sql);
	$sql = rtrim($sql, ',');
	mysql_query($sql.";");
	$sql = file_get_contents("./upload/resort_profile.sql");
	$sql = rtrim($sql);
	$sql = rtrim($sql, ',');
	mysql_query($sql.";");
	$sql = file_get_contents("./upload/resort_relation.sql");
	$sql = rtrim($sql);
	$sql = rtrim($sql, ',');
	mysql_query($sql);
?>
</body>
</html>

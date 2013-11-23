<html>
<head>
	<title>关系可视化 v3</title>
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="./bootstrap/css/bootstrap-switch.css" rel="stylesheet">
	<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./bootstrap/js/storyjs-embed.js"></script>
	<style type="text/css">
	body {
		padding-top: 40px;
		padding-bottom: 40px;
		position: relative;
		font-family:"ff-tisa-web-pro-1","ff-tisa-web-pro-2","Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","Microsoft YaHei UI","Microsoft YaHei","WenQuanYi Micro Hei",sans-serif;
	}
	</style>

<script>
	function getid()
	{
	  var url = window.location.search;

	  var param = url.split('?')[1];
	  var param1= param.split('&')[0];
	  
	  return param1.split('=')[1];
	}
	//get keyword from search frame' placeholder
	function getkeyword()
	{
	  return $('#keyword').attr("placeholder");
	}
	$.ajax({
		url: "getTimeInfo.php",
		type: "GET",
		dataType:"JSON",
		async:false,
		data: {
			"id": getid(),
			"keyword": getkeyword()
		},
		success: function(data) {
			dataObject = data;
		}
	})

	$(document).ready(function() {
        createStoryJS({
            type:       'timeline',
            source:     dataObject,
            embed_id:   'my-timeline'
        });
    });
</script>
</head>

<body>

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
						<input id="keyword" type="text" name="keyword" class="search-query span2" placeholder="<?php echo $_GET['keyword']; ?>">
						<div id="typeSwitch" class="make-switch" data-on-label="图谱" data-off-label="时间轴" data-text-label="切换模式" data-on="info" data-off="success">
						  <input type="checkbox" unchecked />
						</div>
					</form>
				</div><!-- /.nav-collapse-->
			</div>
		</div><!-- /navbar-inner-->
  </div><!-- /navbar-->
</div>

<div id="my-timeline" style="padding-top:40px; "></div>

<script type="text/javascript" src="./bootstrap/js/bootstrap-switch.js"></script>
<script>
	$('#typeSwitch').on('switch-change', function () {
	    window.location = "graph.php?id=" + getid() + "&keyword=" + getkeyword();
	});
</script>

</body>
</html>
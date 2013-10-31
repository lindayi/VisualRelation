<!DOCTYPE html>
<html>
<head>
	<title>关系可视化 v3</title>
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="./bootstrap/css/bootstrap-switch.css" rel="stylesheet">
  <link href="./bootstrap/css/slider.css" rel="stylesheet">
  <link href="./bootstrap/css/datetimepicker.css" rel="stylesheet" media="screen">
    
	<style type="text/css">
	body {
		padding-top: 40px;
		padding-bottom: 40px;
		position: relative;
		font-family:"ff-tisa-web-pro-1","ff-tisa-web-pro-2","Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","Microsoft YaHei UI","Microsoft YaHei","WenQuanYi Micro Hei",sans-serif;
	}
	</style>
    <style>

.node {
  /*stroke: #000;
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
  fill:  #fff;
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
</head>

<body style="background-color:#fff;">

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
						<input type="text" name="keyword" class="search-query span2" placeholder="<?php echo $_GET['keyword']; ?>">
            <div id="mySwitch" class="make-switch" data-on-label="图谱" data-off-label="时间轴" data-text-label="切换模式" data-on="info" data-off="success">
						  <input type="checkbox" checked />
						</div>
					</form>
				</div><!-- /.nav-collapse-->
			</div>
		</div><!-- /navbar-inner-->
  </div><!-- /navbar-->
</div>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span9">
      <graph></graph>
      <script src="./bootstrap/js/d3.v3.min.js"></script>
      <script>

      var width = document.body.clientWidth - 400,
          height = document.documentElement.clientHeight - 90;

      var color = d3.scale.category20();

      var force = d3.layout.force().linkDistance(30).linkStrength(2).charge(-30).size([width, height]);

      var svg = d3.select("graph").append("svg").attr("width", width).attr("height", height).attr("padding-top","40px");

      // 背景
      //d3.select("body").transition().style("background-color", "grey");
      </script>
      <script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
      <script>

      function getdata() {
          var graph = {};
          $.ajax({
      	    url: "getData.php",
      	    type: "GET",
              dataType: "JSON",
      	    async: false,
      	    success: function(res) {
                  var svg = d3.select("graph").append("svg").attr("width", "100%").attr("height", "100%").attr("padding-top","40px");
                  graph = res;
                  draw(graph);
      	    }
          });
      }

      function draw(graph) {
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
          		              .style("stroke-width",1.5);
        


          var node = svg.selectAll(".node").data(graph.nodes)
                            .enter().append("g")
                            .attr("class", "node")
          				          .attr("onclick", function(d){})
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
                          .style("fill", "black")
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
      }
      getdata();
      function update() {
        d3.select("svg").remove();
        getdata();
      }
      </script>
    </div>
    <div class="span3">
      <div class="row" style="padding-top:40px">
      	<div class="span12">
      		<div class="modal" style="position: relative; top: auto; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 100%;">
            <div class="modal-header">
              <h3>筛选</h3>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="getData.php" method="get">
                <div class="control-group">
                  <div class="span4">
                    <div id="per_switch" class="make-switch switch-small" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>" data-text-label="人物">
                      <input type="checkbox" checked />
                    </div>
                  </div>
                  <div class="span4">
                    <div id="loc_switch" class="make-switch switch-small" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>" data-text-label="地点">
                      <input type="checkbox" checked />
                    </div>
                    <div class="modal-footer">
                      <button id="filter" class="btn btn-primary" onclick=update()>筛选</button>
                  </div>
                  <div class="span4">
                    <div id="org_switch" class="make-switch switch-small" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>" data-text-label="组织">
                      <input type="checkbox" checked />
                    </div>
                  </div>
                </div>
                <!--<div class="control-group">
                  <input type="text" class="span2" value="4" id="sl1">
                </div>-->
                <div class="control-group">
                  <div class="span6">
                  关系展示:
                  <div id="tree_graph" class="make-switch switch-small" data-on-label="图状" data-off-label="树状" data-on="primary" data-off="primary">
                    <input type="checkbox" checked />
                  </div>
                  </div>
                  <div class="span6">
                  共存关系:
                  <div id="tree_switch" class="make-switch switch-small" data-on-label="显示" data-off-label="过滤" data-on="primary" data-off="primary">
                    <input type="checkbox" checked />
                  </div>
                  </div>
                </div>
                <div class="control-group">
                  起始时间：
                  <div class="input-append date form_datetime" data-date="" data-date-format="dd MM yyyy - HH:ii p" data-link-field="Tstart" data-picker-position="bottom-left">
                      <input class="span10" size="16" type="text" value="" readonly>
                      <span class="add-on"><i class="icon-th"></i></span>
                  </div>
                  <input type="hidden" id="Tstart" value="" /><br/>
                </div>
                <div class="control-group">
                  终止时间：
                  <div class="input-append date form_datetime" data-date="" data-date-format="dd MM yyyy - HH:ii p" data-link-field="Tend" data-picker-position="bottom-left">
                      <input class="span10" size="16" type="text" value="" readonly>
                      <span class="add-on"><i class="icon-th"></i></span>
                  </div>
                  <input type="hidden" id="Tend" value="" /><br/>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button id="filter" class="btn btn-primary" onclick=getdata()>筛选</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="span12">
          <div class="modal" style="position: relative; top: auto; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 100%;">
            <div class="modal-header">
              <h3>属性</h3>
            </div>
            <div class="modal-body">
              <p>开发中…</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
        $('#sl1').slider({
          formater: function(value) {
            return 'Current value: '+value;
          }
        });
</script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap-switch.js"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap-slider.js"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script>
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
</script>
</body>
</html>

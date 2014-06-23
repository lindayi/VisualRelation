<!DOCTYPE html>
<html>
<head>
	<title>关系可视化 v3</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="./bootstrap/css/bootstrap-switch.css" rel="stylesheet">
  <link href="./bootstrap/css/datetimepicker.css" rel="stylesheet" media="screen">
  <script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
  <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
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
</head>

<body style="background-color:#000;">

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
      <graph id="vis"></graph>
    </div>
    <div class="span3">
      <div class="row" style="padding-top:40px">
      	<div class="span12">
      		<div class="modal" style="position: relative; top: auto; left: auto; right: auto; margin: 0 auto 20px; z-index: 1; max-width: 100%;">
            <div class="modal-header">
              <h3>筛选</h3>
            </div>
            <div class="modal-body">
              <form class="form-horizontal">
                <div class="control-group">
                  <div class="span4">
                    <div id="per_switch" class="make-switch switch-small" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>" data-text-label="人物">
                      <input id="per" type="checkbox" name="per" checked />
                    </div>
                  </div>
                  <div class="span4">
                    <div id="loc_switch" class="make-switch switch-small" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>" data-text-label="地点">
                      <input id="loc" type="checkbox" name="loc" checked />
                    </div>
                  </div>
                  <div class="span4">
                    <div id="org_switch" class="make-switch switch-small" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>" data-text-label="组织">
                      <input id="org" type="checkbox" name="org" checked />
                    </div>
                  </div>
                </div>
                <div class="control-group">
                  点数：
                  <input id="num" name="num" type="range" step="50" min="50" max="300" value="100" /><numtext>100</numtext>
                </div>
                <div class="control-group">
                  <div class="span6">
                  关系展示:
                  <div id="tree_graph" class="make-switch switch-small" data-on-label="图状" data-off-label="树状" data-on="primary" data-off="primary">
                    <input id="graph" type="checkbox" name="graph" checked />
                  </div>
                  </div>
                  <div class="span6">
                  共存关系:
                  <div id="tree_switch" class="make-switch switch-small" data-on-label="显示" data-off-label="过滤" data-on="primary" data-off="primary">
                    <input id="coexist" type="checkbox" name="coexist" checked />
                  </div>
                  </div>
                </div>
                <div class="control-group">
                  起始时间：
                  <div id="tstart" class="input-append date form_datetime" data-date="" data-date-format="yyyymmddhhii" data-picker-position="bottom-left">
                      <input name="tstart" class="span10" size="16" type="text" value="" readonly>
                      <span class="add-on"><i class="icon-th"></i></span>
                  </div>
                </div>
                <div class="control-group">
                  终止时间：
                  <div id="tend" class="input-append date form_datetime" data-date="" data-date-format="yyyymmddhhii" data-picker-position="bottom-left">
                      <input name="tend" class="span10" size="16" type="text" value="" readonly>
                      <span class="add-on"><i class="icon-th"></i></span>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button id="filter" class="btn btn-primary" onclick="filter()">筛选</button>
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
            <div class="modal-body" style="height:100px; overflow:auto">
              <p id="nodeinfo"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- tips when user wating for data-->
<div id="process-scroll" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="process-scrollLabel" aria-hidden="true">
  <div class="modal-header">
    正在渲染请稍等...
  </div>
  <div class="modal-body">
    <div class="progress progress-striped active">
      <div class="bar" style="width: 100%;"> </div>
    </div>
  </div>  
</div>
<!-- error tips when ajax error-->
<div id="error" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="errorLabel" arria-hidden="true">
  <div class="modal-header">
    错误：
  </div>
  <div class="modal-body">
    对不起，数据库暂无此数据 :(
  </div>
  <div class="modal-footer">
    <button id="ok" class="btn" style="margin:right">确定</button>
  </div>>
</div>

<script src="./bootstrap/js/d3.v3.min.js"></script>
<script>

var width = document.body.clientWidth - 400,
    height = document.documentElement.clientHeight - 90;

var color = d3.scale.category20();

// 背景
//d3.select("body").transition().style("background-color", "grey");

function judgeWidth(mentions) {
  if (mentions > 100) {
    return 2;
  } else if (mentions < 10) {
    return 1;
  } else {
    return 1.5;
  }
}
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
function getnodeinfo(id, name){
  $.ajax({
    url: "getNodeInfo.php",
    type: "GET",
    dataType: "JSON",
    data: {"id": id},
    success: function(data) {
      console.log(data.length);
      var msg = "";
      var line = "";

      msg = "<h4>" + name + "</h4>"; 
      for (var i = 0; i < data.length; i++) {                          
        for (var j in data[i]) {
          line = "<strong>" + j + "</strong>" + ":"+ data[i][j] + "<br />";
        } 
        msg += line;
      }
      console.log(msg);
      $('#nodeinfo').html(msg);
    }
  });
}
function getlinkinfo(source, target) {
  var coexist = $("#coexist").attr("checked") == "checked"? "1": "0";
  $.ajax({
    url: "getLinkInfo.php",
    type: "GET",
    dataType: "JSON",
    data: {
      "source": source.id,
      "target": target.id,
      "coexist": coexist
    },
    success: function (data) {
      var msg = "";
      var line = "";
      msg += "<h4>" + source.name + " → " + target.name + "</h4>";
      msg += "<strong>关系类型:</strong>" + data.type + "<br />";

      for (var i = 0; i < data.sources.length; i++) {
        line += "<strong>关系来源：(" + (i+1) +")</strong>" + data.sources[i].text + "<br />";
      }
      msg += line;
      $('#nodeinfo').html(msg);
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
        i = {}, 
        w = link.weight,
        tp = nodes[link.target].type;
      nodes.push(i);
      links.push({
        source: s,
        target: i
      }, {
        source: i,
        target: t
      });
      bilinks.push([s, i, t ,w ,tp]);
    });

   var force = d3.layout.force()
          //.linkDistance(70)
          .linkDistance(30)
          .linkStrength(2)
          //.charge(-30)
          .charge(-60)
          .nodes(nodes)
          .links(links)
          .size([width, height])
          .start();

    /*直线用line,曲线用path*/
    var link = svg.selectAll(".link")
              .data(bilinks)
              .enter().append("path")
              //.enter().append("line")
              .attr("class", "link")
              .style("stroke", function(d) { return color(d[4]);})
              .style("stroke-width", function (d) {
                        return judgeWidth(d[3]);
                      })
              .on("mouseover", function(d) {                        
                $(this).css("stroke-width", "5px");
              })
              .on("mouseout", function(d) {
                $(this).css("stroke-width", judgeWidth(d[3]));                    
              })
              .on("click", function(d) {
                console.log(d[0]);
                console.log(d[2]);
                //console.log
                getlinkinfo(d[0], d[2]);
              })
              .attr('id', function(d) { return d[2]['id'];})
              .attr("x1", function(d) { return d[0].x; })
              .attr("y1", function(d) { return d[0].y; })
              .attr("x2", function(d) { return d[2].x; })
              .attr("y2", function(d) { return d[2].y; });

    var node = svg.selectAll("circle.node")
            .data(graph.nodes)
            .enter().append("circle")
            .attr("class", "node")
            .attr("r", function(d){
              //console.log(d.mention/2)
              if (d.mention > 100) {
                return 10;
              } else if (d.mention < 5){
                return d.mention < 2.5 ? 2.5: d.mention;
              } else {
                return 5;
              }
            })
            .on("click", function(d){
                            getnodeinfo(d.id, d.name);
                          })              
            .style("fill", function(d) {
              return color(d.type);
            })
            .call(force.drag);

            node.append("title")
              .text(function(d) { return d.name; });
            node.append("text")
              .text(function(d) { return d.name; });

    var texts = svg.selectAll("text.label")
                    .data(graph.nodes)
                    .enter().append("text")
                    .attr("class", "label")
                    .attr("dx", 12)
                    .attr("dy", ".35em")
                    .text(function(d) { return d.name; });

    force.on("tick", function() {
      /*曲线时的坐标转换代码*/
      link.attr("d", function(d) {
                        return "M" + d[0].x + "," + d[0].y + "S"
                            + d[1].x + "," + d[1].y + " "
                            + d[2].x + "," + d[2].y;
                      });
      /*直线时的坐标转换代码*/
      // link.attr("x1", function(d) { return d[0].x; })
      //   .attr("y1", function(d) { return d[0].y; })
      //   .attr("x2", function(d) { return d[2].x; })
      //   .attr("y2", function(d) { return d[2].y; });

      node.attr("cx", function(d) { return d.x; })
          .attr("cy", function(d) { return d.y; });
      texts.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
    });
}

function redraw() {
  console.log("here", d3.event.translate, d3.event.scale);
  svg.attr("transform", "translate(" + d3.event.translate + ")"
    + " scale(" + d3.event.scale + ")");
}

function filter()
{
  var per     = $('#per').attr("checked") == "checked"? "1": "0";
  var loc     = $('#loc').attr("checked") == "checked"? "1": "0";
  var org     = $('#org').attr("checked") == "checked"? "1": "0";
  var num     = $('#num').attr("value");
  var graph   = $("#graph").attr("checked") == "checked"? "1": "0";
  var coexist = $("#coexist").attr("checked") == "checked"? "1": "0";
  var tstart  = $("#tstart").val();
  var tend    = $("#tend").val();
  var id      = getid();
  console.log(tstart);
  console.log(tend);


  //judege the parameter
  // if ((tstart >= tend) && (tstart != "") && (tend != "")) {
  //   alert("wrong");
  // }

  $('#process-scroll').modal('show');
  $.ajax({
    url: "getData2.php",
    type: "GET",
    dataType: "JSON",
    data: {
      "id": id,
      "per": per,
      "loc": loc,
      "org": org,
      "num": num,
      "graph": graph,
      "coexist": coexist,
      "tstart": tstart,
      "tend": tend,
    },
    //async: false,
    success: function(data) {
      console.log(data);
      $('#process-scroll').modal('hide');
      d3.select("svg").remove();
      svg = d3.select("graph")
        .append("svg:svg")
        .attr("width", width)
        .attr("height", height)
        .attr("padding-top","40px")
        .attr("pointer-events", "all")
        //.append('svg:g')    
        .append('svg:g')
        .call(d3.behavior.zoom().on("zoom", redraw));
      
      svg.append('svg:rect')
        .attr('width', width)
        .attr('height', height)
        .attr('fill', 'black');



      graph = data;
      console.log(data);
      draw(graph);
      data = "";
    },
    error: function(e){
      console.log(e);
      $('#process-scroll').modal('hide');
      $('#error').modal('show');
    }
  });

}
filter();
getnodeinfo(getid(), getkeyword());
</script>
<script type="text/javascript" src="./bootstrap/js/bootstrap-switch.js"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<!--<script type="text/javascript" src="./bootstrap/js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>-->
<script>
function trans_time(obj)
{
  var time = "";
  var year = obj.date.getUTCFullYear();
  var month = obj.date.getUTCMonth() + 1;    //because getUTCMonth start from 0
  var day = obj.date.getUTCDate();
  var hours = obj.date.getUTCHours();
  var minutes = obj.date.getUTCMinutes();

  time += year;
  if (month < 10) {
    time += "0" + month;
  } else {
    time += month;
  }
  if (day < 10) {
    time += "0" + day;
  } else {
    time += day;
  }
  if (hours < 10) {
    time += "0" + hours;
  } else {
    time += hours;
  }
  if (minutes < 10) {
    time += "0" + minutes;
  } else {
    time += minutes;
  }
  console.log(time);

  return time;
}

$('.form_datetime').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1,
});

$('#tstart')
.datetimepicker()
.on('changeDate', function(ev){
  console.log(trans_time(ev));
  $('#tstart').attr("value", trans_time(ev));
});

$('#tend')
.datetimepicker()
.on('changeDate', function(ev){
  console.log(trans_time(ev));
  $('#tend').attr("value", trans_time(ev));
});

$("#num").on("change",function(){
  var val = $("#num").val();
  $("numtext").html(val);
});

$('#ok').on("click", function() {
  $('#error').modal('hide');
});

$('#typeSwitch').on('switch-change', function () {
    window.location = "timeline.php?id=" + getid() + "&keyword=" + getkeyword();
});
</script>

</body>
</html>

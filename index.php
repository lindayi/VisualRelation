<?php
	include_once "conn.php";
	include_once "function.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关系可视化模型</title>
<link href="css/jquery.autocomplete.css" type=text/css rel=stylesheet>
<link href="css/index.css" type=text/css rel=stylesheet>
</head>

<body>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<script language="javascript">
        $(document).ready(function() {
        $("#name").autocomplete("getajaxtag.php",
        {
          delay:10,
          minChars:1,
          matchSubset:1,
          matchContains:1,
          cacheLength:10,
          onItemSelect:selectItem,
          onFindValue:findValue,
          formatItem:formatItem,
          autoFill:false
        }
        );
        $("#name2").autocomplete("getajaxtag.php",
        {
          delay:10,
          minChars:1,
          matchSubset:1,
          matchContains:1,
          cacheLength:10,
          onItemSelect:selectItem,
          onFindValue:findValue,
          formatItem:formatItem,
          autoFill:false
        }
        );
        });
</script>
<table width="100%" height="100%" align="center">
<tr height="90%"><td>
    <table align="center">
        <tr>
          <td height="89" colspan="2"><h1 align="center" class="text">关系可视化模型<span class="version"> Beta2</span></h1></td>
        </tr>
        <tr>
        <!--<td width="180" valign="top">
			<img src="image/xupt.png" height="150">
		</td>-->
        <td valign="top">
            <div class="nTab">
                <div class="TabTitle">
                    <ul id="myTab">
                        <li class="active" onclick="nTabs(this,0);">图谱检索</li>
                        <li class="normal" onclick="nTabs(this,1);">时间检索</li>
                    </ul>
                </div>
                <div class="TabContent">
                    <div id="myTab_Content0" align="center">
                        <form action="findid.php" method="get" class="text">
                            <p>
                                <span class="STYLE1">关键字：</span>
                                <input name="name" type="text" id="name"/>
                                <span class="STYLE1">展开层数：</span>
                                <input name="depth" type="text" value="1" size="5" />
                            </p>
                            <p>
                                <span class="STYLE1">关系筛选维度：</span>
                                <input type="checkbox" name="per" value="per" checked="Yes"> 人物 
                                <input type="checkbox" name="loc" value="loc" checked="Yes"> 地点 
                                <input type="checkbox" name="org" value="org" checked="Yes"> 组织
                                <input type="checkbox" name="self" value="self" checked="Yes"> 自身属性 
                            </p>
                            <p>
                                <input name="search" value="graph" type="hidden" />
                                <input value="检索" type="submit" />
                            </p>
                        </form> 
                    </div>
                    <div id="myTab_Content1" class="none" align="center">
                        <form action="findid.php" method="get" class="text">
                            <p>
                                <span class="STYLE1">关键字：</span>
                                <input name="name" type="text" id="name2" size="30" />

                                <input name="search" value="timeline" type="hidden" />
                                <input value="检索" type="submit" />
                            </p>
                        </form> 
                    </div>
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

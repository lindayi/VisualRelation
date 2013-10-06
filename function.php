<script type="text/javascript">
    function nTabs(thisObj, Num) {
        if (thisObj.className == "active") return;
        var tabList = document.getElementById("myTab").getElementsByTagName("li");
        for (i = 0; i < tabList.length; i++) {//点击之后，其他tab变成灰色，内容隐藏，只有点击的tab和内容有属性
            if (i == Num) {
                thisObj.className = "active";
                document.getElementById("myTab_Content" + i).style.display = "block";
            } else {
                tabList[i].className = "normal";
                document.getElementById("myTab_Content" + i).style.display = "none";
            }
        }
    }
	
    function findValue(li) {
        if( li == null ) return alert("No match!");
        if( !!li.extra ) var sValue = li.extra[0];
        else var sValue = li.selectValue;
    }
    function selectItem(li) { findValue(li);}
    function formatItem(row) { return row[0];//return row[0] + " (id: " + row[1] + ")"//如果有其他参数调用row[1]，对应输出格式Sparta|896
    }
    function lookupAjax(){
        var oSuggest = $("#name")[0].autocompleter;
        oSuggest.findValue();
        return false;
    }
	
		//弹出隐藏层
	function ShowDiv(show_div,bg_div){
	   document.getElementById(show_div).style.display='block';
	   document.getElementById(bg_div).style.display='block' ;
	   var bgdiv = document.getElementById(bg_div);
	   bgdiv.style.width = document.body.scrollWidth; 
	  // bgdiv.style.height = $(document).height();
	   $("#"+bg_div).height($(document).height());
	};
	//关闭弹出层
	function CloseDiv(show_div,bg_div)
	{
		document.getElementById(show_div).style.display='none';
		document.getElementById(bg_div).style.display='none';
	};
</script>

<?php
	function checkid($id, $nodeid, $anum)
	{
		for($k = 0; $k < $anum; $k++)
			if ($nodeid[$k] == $id) return 1;
		return 0;
	}

	function getnum($id, $nodeid, $anum)
	{
		for($k = 0; $k < $anum; $k++)
		{
			if($nodeid[$k] == $id) return $k;
		}
		return "-1";
	}
	
	function proctime($time, $t)
	{
		if (($t == 1)&&(strlen($time) > 15)) $time = substr($time, 15, 12);
		else $time = substr($time, 0, 12);
		
		return substr($time, 0, 4).",".substr($time, 4, 2).",".substr($time, 6, 2);
	}
	
	function replace_html_tag($string, $tagname, $clear = false){
		$re = $clear ? '' : '\1';
		$sc = '/<' . $tagname . '(?:\s[^>]*)?>([\s\S]*?)?<\/' . $tagname . '>/i';
		return preg_replace($sc, $re, $string);
	}

?>
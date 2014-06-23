<?php
	$conn = mysql_connect("localhost:3306","数据库用户名","数据库密码");
	mysql_select_db("库名", $conn);
	mysql_query("set names utf8");
?>

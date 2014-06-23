<?php
	include_once("conn.php");

	ob_implicit_flush(1);
	if ($_FILES["file"]["error"] > 0)
	{
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
		echo "<script>alert('文件过大！请上传小于10M的数据包。'); window.location.href=\"update.php\";</script>";
	}
	else
	{
/*	
		echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		echo "Type: " . $_FILES["file"]["type"] . "<br />";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
*/		
		echo exec("rm -rf *");
		if(!move_uploaded_file($_FILES["file"]["tmp_name"], "upload/data.tar.gz"))
		{	echo "<script>alert('文件上传失败！请联系管理员。'); window.location.href=\"update.php\";</script>"; exit(); }
/*		echo exec("tar -xvf ./upload/data.tar.gz -C ./upload");
		echo exec("cp ./script/* ./upload");
		echo exec("python ./upload/parsexml3.0.py");
		echo exec("sh ./upload/resort.sh");

		echo "Truncate DOC...<br />";
		mysql_query("truncate doc");
		echo "DONE!<br />";
		echo "Truncate PROFILE...<br />";
		mysql_query("truncate profile");
		echo "DONE!<br />";
		echo "Truncate RELATION...<br />";
		mysql_query("truncate relation");
		echo "DONE!<br />";
		flush();
		echo "Source DOC...<br />";
		flush();
		$sql = file_get_contents("./upload/resort_doc.sql");
		$sql = rtrim($sql);
		$sql = rtrim($sql, ',');
		mysql_query($sql.";");
		echo "DONE!<br />";
		flush();
		echo "Source PROFILE...<br />";
		$sql = file_get_contents("./upload/resort_profile.sql");
		$sql = rtrim($sql);
		$sql = rtrim($sql, ',');
		mysql_query($sql.";");
		echo "DONE!<br />";
		echo "Source RELATION...<br />";
		$sql = file_get_contents("./upload/resort_relation.sql");
		$sql = rtrim($sql);
		$sql = rtrim($sql, ',');
		mysql_query($sql);
		echo "DONE!<br />";*/
		echo "<script>window.location.href=\"update_1.php\";</script>";
	}
?>

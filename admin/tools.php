<?php
include_once("../include/config.php");
include("../include/functions.php");
error_reporting(1);
if (get('act')=='thu')
{
	$sql = "select * from products";
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		$prod_id = $row['prod_pic'];
		generate_image_thumbnail("../upload/prod_pic/large/".$prod_id,"../upload/prod_pic/small/".$prod_id);
	}
}

if (get('act')=='res')
{
	$sql = "select * from products WHERE prod_store =1";
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		$prod_id = $row['prod_code'];
		generate_image_thumbnail("../upload/prod_pic/ajay/".$prod_id.".jpg","../upload/prod_pic/thumb/".$prod_id.".jpg");
		echo "$prod_id  converted<br>";
	}
}

if (get('act')=='ren')
{
	$fileFolder = "/upload/prod_pic/large";
	$directory = $_SERVER['DOCUMENT_ROOT'].$fileFolder.'/';
	$i = 1; 
	$handler = opendir($directory);
	while ($file = readdir($handler)) {
	
		if ($file != "." && $file != "..") {
			
			$newName = str_replace(" - A"," - B",$file);
			
			rename($directory.$file, $directory.$newName); // here; prepended a $directory
		}
		echo "$directory$file > $newName<br>";
	}
	closedir($handler);
}

?>

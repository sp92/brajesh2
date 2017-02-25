<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");

$type = $_REQUEST['type'];
$title =  $_REQUEST['t'];

?>


<div class="my-account">
  <div class="dashboard">
    <div class="page-title">
      <h1>Manage <? echo $title?> </h1>
    </div>
    <?
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");
  	
if (get("Submit3")!= "")
{
	$type = get("type");
	$etitle = get("etitle");
	$seq = get("seq");
	if ($type=="V")
		$source = get("source");
	$active = get("active");
	
	if ($row_id==0)
	{			
		$sql = "insert into gallery Set type='$type',title='$etitle', seq='$seq',source='$source',active='$active',create_date=now()";	
	}
	else
	{
		$sql = "update gallery Set type='$type',title='$etitle', seq='$seq',active='$active'";
		if ($type=="V") 
			$sql = $sql. ", source='$source'";
		$sql = $sql. " where gid=$row_id ";
	}
	//echo $sql;
	mysql_query($sql);
	if ($row_id==0)
	{
		$result = mysql_query("select gid from gallery where type='$type' order by gid desc");
		$num_rows = mysql_num_rows($result);
		if ($num_rows>0)
		{	
			$row1=mysql_fetch_array($result);
			$newgid = $row1["gid"];
		}
	}
	else
		$newgid = $row_id;
		
	// Upload Images
	$image=$_FILES['file']['name'];
	if ($image != "")
	{		
		$path="../gallery/".$newgid.".jpg";
		move_uploaded_file($_FILES['file']['tmp_name'],$path);		
		generate_image_thumbnail("../gallery/".$newgid.".jpg","../gallery/small/".$newgid.".jpg","gallery");
		
		//$sql = "update writer_det Set writer_pic = '$writer_code' where writer_code=$writer_code ";
		//mysql_query($sql);
	}
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');parent.location.href='managegallery.php?type=$type&t=$title' </script>";
}

$sql = "select * from gallery where gid=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$type = $row["type"];	
	$etitle = $row["title"];			
	$seq = $row["seq"];
	$source = $row["source"];
	$active = $row["active"];
	if ($active == 1)
		$active = "checked";
	else
		$inactive = "checked";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/styles.css" rel="stylesheet" type="text/css" /> 


</head>
<body>
<style>
td
{
	padding:5px;
}
</style>
    <form action=""  method="post" enctype="multipart/form-data" name="form2" id="form2" onSubmit="return valid(this)">
      <script = javascript>
	function valid(a)
	{ 
		/*
			if (a.etitle.value=="")
			{
			alert ("Enter title ...")
			a.etitle.focus();
			return false;
			}
			
			*/
	
		return true;
		}
	</script>
      <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
        <tr>
          <td width="30%" ><div align="right" ><b>Title:</b></div></td>
          <td width="70%" ><input name="etitle" type="text" id="etitle" style="width:190px;" value="<? echo $etitle?>" size="30" maxlength="500" />
         </td>
        </tr>
        <tr>
          <td ><div align="right" ><b>Sequance:</b></div></td>
          <td ><input name="seq" type="text" id="seq" style="width:190px;" value="<? echo $seq?>" size="3" maxlength="2" /></td>
        </tr>
		<? if ($type=="P"){ ?>
        <tr>
          <td ><div align="right" ><b>Image File :</b></div></td>
          <td ><input type="file" name="file" />
		  <? if ($row_id>0) {?>
		  <img src="../gallery/small/<? echo $row_id?>.jpg" />
		  <? } ?>
		  </td>
        </tr>
		<? } else { ?>
        <tr>
          <td width="30%" valign="top" ><div align="right" ><b>Video File Link :</b></div></td>
          <td width="70%" ><textarea name="source" cols="70" rows="8" id="source" style="width:290px; height:100px"><? echo $source?></textarea></td>
        </tr>
		<? }?>
        <tr>
          <td width="30%" ><div align="right" ><b>Is Active:</b></div></td>
          <td width="70%" ><div>
		  <input name="active" type="radio" value="1" <? echo $active ?> />
            Active
              <input name="active" type="radio" value="0"  <? echo $inactive ?>  />
			Not Active
			</div>		</td>
        </tr>
       
        <tr >
          <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
              <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" value="Save" />
            </div></td>
        </tr>
      </table>
</form>
</body>
</html>

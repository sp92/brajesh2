<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");
?>


<div class="my-account">
  <div class="dashboard">
    <div class="page-title">
      <h1>Manage Writers </h1>
    </div>
    <?
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");

if (get("Submit3")!= "")
{
	$writer_name = get("writer_name");
	$writer_name_h = get("writer_name_h");
	$writer_det = get("writer_det");
	$view_home= get("view_home");
	$active = get("active");
	
	if ($row_id==0)
	{	
		$sql = "select max(writer_code) from writer_det";
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);			
		$writer_code = $row[0]+1;	
		$cols = " Set writer_code=$writer_code, writer_name='$writer_name',writer_name_h='$writer_name_h',writer_det='$writer_det',view_home='$view_home',
				active='$active'";	
		$sql = "insert into writer_det $cols";	
	}
	else
	{
		$cols = " Set writer_name='$writer_name',writer_name_h='$writer_name_h',writer_det='$writer_det',view_home='$view_home',
				active='$active'";	
		$sql = "update writer_det  $cols
				where wid=$row_id ";	
				$writer_code=$row_id;
	}
	
	//echo $sql;
	mysql_query($sql);
	// Upload Images
	$image=$_FILES['file']['name'];
	if ($image != "")
	{		
		$path="../authors/".$writer_code.".jpg";
		move_uploaded_file($_FILES['file']['tmp_name'],$path);		
		generate_image_thumbnail("../authors/".$writer_code.".jpg","../authors/small/".$writer_code.".jpg","writer");
		
		$sql = "update writer_det Set writer_pic = '$writer_code' where writer_code=$writer_code ";
		mysql_query($sql);
	}
	$msg = "Information updated.<br>";
	//echo "<script>alert('Information saved.');parent.location.href='managewriters.php' </script>";
}

$sql = "select * from writer_det where wid=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$writer_name = $row["writer_name"];	
	$writer_name_h = $row["writer_name_h"];			
	$writer_det = $row["writer_det"];
	$writer_pic = $row["writer_pic"];
	$active = $row["active"];
	$view_home = $row["view_home"];
	if ($view_home == 1)
		$view_home_yes = "checked";
	else
		$view_home_no = "checked";

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
<table width="100%%" height="144" border="0">
  <tr>
    <td width="71%">
	<style>
	td
	{
		padding:5px;
	}
    </style>
      <form action=""  method="post" enctype="multipart/form-data" id="form2" onSubmit="return valid(this)">
        <script = javascript>
	function valid(a)
	{ 
		if (a.writer_name.value=="")
			{
			alert ("Enter writer_det name...")
			a.writer_name.focus();
			return false;
			}
			
			
	
		return true;
		}
	  </script>
        <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
          <tr>
            <td width="30%" ><div align="right" ><b>Writer Name:</b></div></td>
            <td width="70%" ><input name="writer_name" type="text" id="writer_name" style="width:190px;" value="<? echo $writer_name?>" size="30" maxlength="500" />            </td>
          </tr>
          <tr>
            <td width="30%" valign="top" ><div align="right" ><b>Writer Name (Hindi):</b></div></td>
            <td width="70%" ><textarea name="writer_name_h" cols="20" id="writer_name_h" style="width:190px;"><? echo $writer_name_h?></textarea></td>
          </tr>
          <tr>
            <td width="30%" valign="top" ><div align="right" ><b>Description:</b></div></td>
            <td width="70%" ><textarea name="writer_det" cols="50" rows="5" id="description" style="width:190px;"><? echo $writer_det?></textarea></td>
          </tr>
          <tr>
            <td width="30%" ><div align="right" ><b>Picture:</b></div></td>
            <td width="70%" ><input type="file" name="file" /></td>
          </tr>
          <tr>
            <td ><div align="right" ><b>Show on Home Page :</b></div></td>
            <td ><div>
                <input name="view_home" type="radio" value="1" <? echo $view_home_yes ?> />
              Yes
              <input name="view_home" type="radio" value="0"  <? echo $view_home_no ?> />
              No
            </div></td>
          </tr>
          <tr>
            <td width="30%" ><div align="right" ><b>Is Active:</b></div></td>
            <td width="70%" ><div>
                <input name="active" type="radio" value="1" <? echo $active ?> />
              Active
              <input name="active" type="radio" value="0"  <? echo $inactive ?>>
              Not Active </div></td>
          </tr>
          <tr >
            <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
                    <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" value="Save" />
            </div></td>
          </tr>
        </table>
      </form>
    </div></td>
    <td width="29%"><img src="../authors/small/<? echo trim($writer_pic); ?>.jpg" title="<? echo trim($writer_pic)?>"/><br />
<img src="../authors/<? echo trim($writer_pic); ?>.jpg" title="<? echo trim($writer_pic)?>"/>
</td>
  </tr>
</table>
</body>
</html>

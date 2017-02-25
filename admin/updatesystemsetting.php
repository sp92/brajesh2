<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");
$StoreId =   $_SESSION["StoreId"];


//print_r($_POST); exit;
?>
<div class="my-account">
<div class="dashboard">
<div class="page-title">
  <h1>Manage System Setting</h1>
</div>
<?
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");
  	
if (get("Submit3")!= "")
{
	$code_fld = get("code_fld");
	$code_value = get("code_value");
	$code_desc = get("code_desc");
	$code_desc1 = get("code_desc1");
	$code_desc2 = get("code_desc2");
	$code_desc3 = get("code_desc3");
	$code_desc4 = get("code_desc4");
	$code_desc5 = $StoreId; //get("code_desc5");
	$active = get("active");
		
	if ($row_id==0)
	{	
					
		 $sql = "insert into code_mstr Set 
								code_fld='$code_fld',
								code_value='$code_value',
								code_desc='$code_desc', 
								code_desc1='$code_desc1',
								code_desc2='$code_desc2',
								code_desc3='$code_desc3',
								code_desc4='$code_desc4',
								code_desc5='$code_desc5',
								active='$active'";	
	}
	else
	{
		 $sql = "update code_mstr Set 
								code_fld='$code_fld',
								code_value='$code_value',
								code_desc='$code_desc', 
								code_desc1='$code_desc1',
								code_desc2='$code_desc2',
								code_desc3='$code_desc3',
								code_desc4='$code_desc4',
								code_desc5='$code_desc5',
								active='$active'
				where id=$row_id "; 
		$code_id =  $row_id ;
	}
	//echo $sql;
	mysql_query($sql);
	
	// Upload Images
	
	
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');parent.location.href='managesystemsetting.php?groupName=".get("groupName")."' </script>";
}
if (get("groupName") != "")
{
	
	$code_fld=get("groupName");
}
$sql = "select * from code_mstr where id=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$code_fld = $row["code_fld"];	
	$code_value = $row["code_value"];			
	$code_desc = $row["code_desc"];
	$code_desc1 = $row["code_desc1"];
	$code_desc2 = $row["code_desc2"];
	$code_desc3 = $row["code_desc3"];
	$code_desc4 = $row["code_desc4"];
	$code_desc5 = $row["code_desc5"];
	$active = $row["active"];
	if ($active == 1)
		$active = "checked";
	else
		$inactive = "checked";
		
	$english = $row["lang"];
	if ($english == 'E')
		$english = "checked";
	else
		$hindi = "checked";
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
</head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<body>
<style>
td
{
	padding:5px;
}
</style>
<form  method="post" name="form2" action="" id="form2" onSubmit="return valid(this)" enctype="multipart/form-data">
  <script = javascript>
	function valid(a)
	{ 
		if (a.code_fld.value=="")
			{
			alert ("Enter Group Name ...")
			a.code_fld.focus();
			return false;
			}
			
			
	
		return true;
		}
	</script>
  <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
      <td width="30%" ><div align="right" ><b>Group Name</b></div></td>
      <td width="70%" ><input name="code_fld" type="text" id="code_fld" style="width:190px;" value="<? echo $code_fld?>" size="70" /></td>
    </tr>
    <tr id='dis_item_name' >
      <td width="30%" ><div align="right" ><b>Value:</b></div></td>
      <td width="70%" ><input name="code_value" type="text" id="code_value" style="width:190px;" value="<? echo $code_value?>" size="70" /></td>
    </tr>
    <tr>
      <td ><div align="right" ><b>Description:</b></div></td>
      <td ><textarea name="code_desc" type="text" id="code_desc" style="width:190px;" size="30"  /><? echo $code_desc?></textarea></td>
    </tr>
    <tr>
      <td ><div align="right" ><b>Description1:</b></div></td>
      <td ><input name="code_desc1" type="text" id="code_desc1" style="width:190px;" value="<? echo $code_desc1?>" size="30" /></td>
    </tr>
    <tr>
      <td ><div align="right" ><b>Description2:</b></div></td>
      <td ><input name="code_desc2" type="text" id="code_desc2" style="width:190px;" value="<? echo $code_desc2?>" size="70" /></td>
    </tr>
    <!--<tr>
          <td ><div align="right" ><b>Description3:</b></div></td>
          <td ><input name="code_desc3" type="text" id="code_desc3" style="width:190px;" value="<? echo $code_desc3?>" size="70" /></td>
        </tr>
		<tr>
          <td ><div align="right" ><b>Description4:</b></div></td>
          <td ><input name="code_desc4" type="text" id="code_desc4" style="width:190px;" value="<? echo $code_desc4?>" size="70" /></td>
        </tr>
		<tr>
          <td ><div align="right" ><b>Description5:</b></div></td>
          <td ><input name="code_desc5" type="text" id="code_desc5" style="width:190px;" value="<? echo $code_desc5?>" size="70" /></td>
        </tr>-->
    <tr>
      <td width="30%" ><div align="right" ><b>Is Active:</b></div></td>
      <td width="70%" ><div>
          <input name="active" type="radio" value="1" <? echo $active ?> />
          Active
          <input name="active" type="radio" value="0"  <? echo $inactive ?>  />
          Not Active </div></td>
    </tr>
    <tr >
      <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
          <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" id="submitbutton" value="Save" />
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>

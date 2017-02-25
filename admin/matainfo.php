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
      <h1>&nbsp;Manage Meta Data Info </h1>
    </div>
    <?

$group = get("group");
$location = get("location");

if (get("delid")>0)
{
	$sql = "delete from metainfo where id= ".get("delid");
	mysql_query($sql);
	echo "<center>Information deleted.</center>";
}


if (get("Submit3")!= "")
{
	$title = get("title");
	$keyword = get("keyword");
	$description = get("description");
	
	if ($row_id==0)
	{	
		$sql = "insert into metainfo Set `group`='$group', `location`='$location', `title`='$title', `keyword`='$keyword', `description`='$description'";	
	}
	else
	{
		$sql = "update metainfo Set `group`='$group', `location`='$location', `title`='$title', `keyword`='$keyword', `description`='$description'
				where `group`='$group' and `location`='$location' ";
	}
	
	mysql_query($sql);
	
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');  </script>";
}

$cat_seq=0;
$sql = "select * from metainfo where `group`='$group' and `location`='$location'";
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$id = $row["id"];	
	$group = $row["group"];	
	$location = $row["location"];			
	$title = $row["title"];
	$keyword = $row["keyword"];
	$description = $row["description"];
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
    <form  method="post" name="form2" action="" id="form2" onSubmit="//return valid(this)">
      <script = javascript>
	function valid(a)
	{ 
		if (a.cat_name.value=="")
			{
			alert ("Enter category name...")
			a.cat_name.focus();
			return false;
			}
			
			
	
		return true;
		}
	</script>
      <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
        <tr>
          <td width="30%" ><div align="right" ><b>Title:</b></div></td>
          <td width="70%" >

		  <input required name="title" type="text" id="title" style="width:190px;" value="<? echo $title ?>" size="30" />
          <input type="hidden" name="group" value="<? echo $group?>" />
          <input type="hidden" name="location" value="<? echo $location?>" /></td>
        </tr>
       <!-- <tr>
          <td width="30%" valign="top" ><div align="right" ><b>Category Name (Hindi):</b></div></td>
          <td width="70%" ><textarea name="cat_name_h" cols="20" id="cat_name_h" style="width:190px;"><? echo $cat_name_h?></textarea></td>
        </tr>-->
        <tr>
          <td width="30%" valign="top" ><div align="right" ><b>Description:</b></div></td>
          <td width="70%" ><textarea name="description" cols="50" rows="5" id="description" style="width:190px;"><? echo $description ?></textarea></td>
        </tr>
		
		<tr>
          <td width="30%" ><div align="right" ><b>Keyword:</b></div></td>
          <td width="70%" ><input name="keyword" type="text" id="keyword" style="width:190px;" value="<? echo $keyword?>" size="30" /></td>
        </tr>
       
        <tr >
          <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
              <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" value="Save" />
            <? if ($id > 0) {?>
			<a href="matainfo.php?delid=<? echo $id?>"> Delete
			<? }?>
			
			</div></td>
        </tr>
      </table>
    </form>
  </div>
</body>
</html>

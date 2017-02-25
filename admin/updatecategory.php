<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");
$StoreId =   $_SESSION["StoreId"];
?>


<div class="my-account">
  <div class="dashboard">
    <div class="page-title">
      <h1>Manage Category </h1>
    </div>
    <?
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");

if (get("Submit3")!= "")
{
	$cat_name = get("cat_name");
	$cat_title_h = get("cat_title_h");
	$cat_desc = get("cat_desc");
	$cat_seq = get("cat_seq");
	$cat_lang = get("cat_lang");
	$cat_active = get("active");
	
	if ($row_id==0)
	{	
		$sql = "select max(cat_id)+1 from category";
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);	
		$cat_id = $row[0];	
		$sql = "insert into category Set cat_id=$cat_id, cat_title='$cat_name',cat_title_h='$cat_title_h',cat_desc='$cat_desc',
				cat_store = $StoreId, cat_lang='$cat_lang', cat_seq='$cat_seq',cat_active='$cat_active'";	
	}
	else
	{
		echo $sql = "update category Set cat_title='$cat_name',cat_title_h='$cat_title_h',cat_desc='$cat_desc',
				cat_store = $StoreId, cat_lang='$cat_lang', cat_seq='$cat_seq',cat_active='$cat_active'
				where cid=$row_id ";
	}
	$sql;
	mysql_query($sql);
	
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');parent.location.href='managecategory.php' </script>";
}

$cat_seq=0;
$sql = "select * from category where cid=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$cat_name = $row["cat_title"];	
	$cat_group_id = $row["cat_group_id"];			
	$cat_desc = $row["cat_desc"];
	$cat_seq = $row["cat_seq"];
	$cat_lang = $row["cat_lang"];
	$cat_active = $row["cat_active"];
	if ($cat_active == 1)
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
    <form  method="post" name="form2" action="" id="form2" onSubmit="return valid(this)">
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
          <td width="30%" ><div align="right" ><b>Category Name:</b></div></td>
          <td width="70%" ><input required name="cat_name" type="text" id="cat_name" style="width:190px;" value="<? echo $cat_name?>" size="30" maxlength="500" />          </td>
        </tr>
      
        <tr>
          <td width="30%" valign="top" ><div align="right" ><b>Description:</b></div></td>
          <td width="70%" ><textarea name="cat_desc" cols="50" rows="5" id="description" style="width:190px;"><? echo $cat_desc?></textarea></td>
        </tr>
        <tr>
          <td width="30%" ><div align="right" ><b>Language:</b></div></td>
          <td width="70%" >
		  <select name="cat_lang" id="cat_lang" required>
		  	<? echo fn_ddl("Language", $cat_lang); ?>
		  </select>
		  </td>
        </tr>
		
		<tr>
          <td width="30%" ><div align="right" ><b>Sequance:</b></div></td>
          <td width="70%" ><input type="text" style="width:190px;" name="cat_seq" maxlength="2" size="30" value="<? echo $cat_seq?>" /></td>
        </tr>
        <tr>
          <td width="30%" ><div align="right" ><b>Is Active:</b></div></td>
          <td width="70%" ><div>
		  <input name="active" type="radio" value="1" <? echo $active ?> />
            Active
              <input name="active" type="radio" value="0"  <? echo $inactive ?>  />
			Not Active
			</div>
		</td>
        </tr>
       
        <tr >
          <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
              <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" value="Save" />
            </div></td>
        </tr>
      </table>
    </form>
  </div>
</div>
</body>
</html>

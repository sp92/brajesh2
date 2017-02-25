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
      <h1>Manage Sub Category </h1>
    </div>
  </div>
</div>
    <?
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");

if (get("Submit3")!= "")
{
	$cat_id = get("cat_id");
	$cat_group_id = get("cat_group_id");
	$cat_name = get("cat_name");
	$cat_group_id = get("cat_group_id");
	$cat_desc = get("cat_desc");
	$cat_seq = get("cat_seq");
	$cat_active = get("active");
	
	if ($row_id==0)
	{	
		$sql = "select max(subcat_id) from subcategory where cat_id=$cat_id ";
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);	
		$scat_id = $row[0]+1;	
		$sql = "insert into subcategory Set cat_id=$cat_id, subcat_id=$scat_id, subcat_title='$cat_name',subcat_title_h='$cat_group_id',
				subcat_desc='$cat_desc', subcat_seq='$cat_seq', subcat_active='$cat_active'";	
	}
	else
	{
		$sql = "update subcategory Set cat_id=$cat_id, subcat_title='$cat_name',subcat_title_h='$cat_group_id',
				subcat_desc='$cat_desc', subcat_seq='$cat_seq', subcat_active='$cat_active'
		where sid=$row_id ";
	}
	
	mysql_query($sql);
	
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');parent.location.href='managesubcategory.php' </script>";
}
$cat_seq=0;
$sql = "select * from subcategory where sid=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$cat_id = $row["cat_id"];	
	$cat_name = $row["subcat_title"];	
	$cat_group_id = $row["cat_group_id"];			
	$cat_desc = $row["subcat_desc"];
	$cat_seq = $row["subcat_seq"];
	$cat_active = $row["subcat_active"];
	$cat_group_id = $row["cat_group_id"];
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
          <td ><div align="right" ><b> Category Name:</b></div></td>
          <td >
		  <select name="cat_id" id="cat_id">
          <?
		    $sql = "select * from category where cat_active=1 order by cat_title";
			$result = mysql_query($sql);
			echo "<option value=''>---Select---</option>";
			while($row=mysql_fetch_array($result))
			{
				
				echo "<option value='".$row["cat_id"]."' ". (($row["cat_id"]==$cat_id)?"selected":"") .">".$row["cat_title"]."</option>";
			}	
		  ?>
		  </select>
          </td>
        </tr>
        <tr>
          <td width="30%" ><div align="right" ><b>Sub Category Name:</b></div></td>
          <td width="70%" ><input required name="cat_name" type="text" id="cat_name" style="width:190px;" value="<? echo $cat_name?>" size="30" maxlength="500" />          </td>
        </tr>
       <!-- <tr>
          <td width="30%" valign="top" ><div align="right" ><b>Sub Category Name (Hindi):</b></div></td>
          <td width="70%" ><textarea name="cat_name_h" cols="20" id="cat_name_h" style="width:190px;"><? echo $cat_name_h?></textarea></td>
        </tr>-->
        <tr>
          <td width="30%" valign="top" ><div align="right" ><b>Description:</b></div></td>
          <td width="70%" ><textarea name="cat_desc" cols="50" rows="5" id="description" style="width:190px;"><? echo $cat_desc?></textarea></td>
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

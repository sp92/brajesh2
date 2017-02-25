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
      <h1>Manage Sub Sub Category </h1>
    </div>
  </div>
</div>
    <?
	 $cat_id=get('cat_id');
	 $subcat_id=get('subcat_id');
	
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");

if (get("Submit3")!= "")
{
	$cat_id = get("cat_id");
	$subcat_id = get("subcat_id");
	$sub_cat_name = get("subcat_name");
	$cat_group_id = get("cat_group_id");
	$cat_desc = get("cat_desc");
	$cat_seq = get("cat_seq");
	$cat_active = get("active");
	
	if ($row_id==0)
	{	
			
		$sql = "insert into sub_subcategory Set cat_id=$cat_id,subcat_id=$subcat_id,sub_subcat_title='$sub_cat_name',cat_group_id='$cat_group_id',
				sub_subcat_desc='$cat_desc', sub_subcat_seq='$cat_seq', sub_subcat_active='$cat_active'";	
	}
	else
	{
		$sql = "update sub_subcategory Set cat_id=$cat_id,subcat_id=$subcat_id,sub_subcat_title='$sub_cat_name',cat_group_id='$cat_group_id',
				sub_subcat_desc='$cat_desc', sub_subcat_seq='$cat_seq', sub_subcat_active='$cat_active'
		where sub_sid=$row_id ";
	}
	
	mysql_query($sql);
	
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');parent.location.href='managesubsubcategory.php' </script>";
}
$cat_seq=0;
$sql = "select * from sub_subcategory where sub_sid=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$cat_id = $row["cat_id"];	
	$subcat_id = $row["subcat_id"];	
	$cat_name = $row["sub_subcat_title"];	
	$cat_group_id = $row["cat_group_id"];			
	$cat_desc = $row["sub_subcat_desc"];
	$cat_seq = $row["sub_subcat_seq"];
	$cat_active = $row["sub_subcat_active"];
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
        <form action=""  method="post"  name="form2" id="form2">
        <tr>
          <td width="30%" valign="top" ><div align="right" ><b>Mapping Group Category:</b></div></td>
          
		  <td><select  required name="cat_group_id" id="catcat_group_id_name_h" >
          <option >Select Group Category</option>
		   <? $sql = "select * from categorygroup";
		  $gid=get('gid');
		  $qry=mysql_query($sql);
		  while($row1=mysql_fetch_array($qry)){?>
          <option value="<? echo $row1['cat_gID']; ?>" <? echo (($row1["cat_gID"]==$gid)?"selected":"")?>><? echo $row1['cat_gCode']; ?></option>
          <? } ?>
		  </select>
		  </td>
        </tr>
		<tr>
          <td ><div align="right" ><b> Category Name:</b></div></td>
          <td >
		  <select onchange='this.form.submit()' name="cat_id" id="cat_id">
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
		</form>
		    <tr>
          <td ><div align="right" ><b> Sub Category Name:</b></div></td>
          <td >
		  <select name="subcat_id" id="subcat_id">
          <?
		   
		    $sqls = "select * from subcategory where cat_id=".$cat_id." and subcat_active=1 order by subcat_title";
			$results = mysql_query($sqls);
			echo "<option value=''>---Select---</option>";
			while($rows=mysql_fetch_array($results))
			{
				
				echo "<option value='".$rows["subcat_id"]."' ". (($rows["subcat_id"]==$subcat_id)?"selected":"") .">".$rows["subcat_title"]."</option>";
			}	
		  ?>
		  </select>
          </td>
        </tr>
		
        <tr>
          <td width="30%" ><div align="right" ><b>Sub Sub Category Name:</b></div></td>
          <td width="70%" ><input required name="subcat_name" type="text" id="subcat_name" style="width:190px;" value="<? echo $cat_name?>" size="30" maxlength="500" />          </td>
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

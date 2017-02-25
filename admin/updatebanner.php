<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");

$type = $_REQUEST['type'];
$title =  $_REQUEST['t'];
//print_r($_POST); exit;
?>


<div class="my-account">
  <div class="dashboard">
    <div class="page-title">
      <h1>Manage <? echo $title?> </h1>
    </div>
    <?
	$stor_id=$_SESSION["StoreId"];
	$row_id = 0;
	if (get("id")!="")
		$row_id = get("id");
		
	if (get("Submit3")!= "")
	{
		$page = get("page");
		$banner_location = get("banner_location");
		$startdate = get("startdate");
		$enddate = get("enddate");
		$link = get("link");
		$sort = get("sort");
		$active = get("active");
		
		$image=$_FILES['file']['name'];
		
		if ($row_id==0)
		{	
			$sql = "select max(banner_id) from banner";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);			
			$banner_id = $row[0]+1;		
			$sql = "insert into banner Set 
										store_id='$stor_id',
										page='$page',
										banner_location='$banner_location',
										url='$link', 
										sort = '$sort',
										start_date='$startdate',
										end_date='$enddate',
										active='$active'
										";	 
		}
		else
		{
			 $sql = "update banner Set 
										store_id='$stor_id',
										page='$page',
										banner_location='$banner_location',
										url='$link', 
										sort = '$sort',
										start_date='$startdate',
										end_date='$enddate',
										active='$active'
					where banner_id=$row_id ";
			$banner_id =  $row_id ;
		}
		//echo $sql;
		mysql_query($sql);
		
		// Upload Images
		
		if ($image != "")
		{	
			$image_name=$banner_id.'_'.$image;
			$sql_qry = "update banner Set 
										image='$image_name'
										where banner_id=$banner_id ";
			mysql_query($sql_qry);
			$path="../upload/banners/".$image_name;
			move_uploaded_file($_FILES['file']['tmp_name'],$path);		
		}
		
		$msg = "Information updated.<br>";
		echo "<script>alert('Information saved.');parent.location.href='managebanner.php' </script>";
	}
	
	$sort=0;
	$sql = "select * from banner where banner_id=". $row_id;
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	if ($num_rows>0)
	{	
		$row=mysql_fetch_array($result);	
		$page = $row["page"];	
		$banner_location = $row["banner_location"];	
		$url = $row["url"];			
		$start_date = $row["start_date"];
		$sort = $row["sort"];
		$end_date = $row["end_date"];
		$image = $row["image"];
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
<link href="css/styles.css" rel="stylesheet" type="text/css" /> 
<script src="ckeditor/ckeditor.js"></script>


</head>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    $( "#datepicker1" ).datepicker({ dateFormat: "yy-mm-dd" });
  });
  </script>
  
<script>
$(document).delegate( "#submitbutton", "click", function() {

$('#ctl00_MainContent_ddlProduct1 option').attr('selected', true);
//alert("gfdg");
})
</script>
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
		if (a.banner_location.value=="")
			{
			alert ("Enter title ...")
			a.etitle.focus();
			return false;
			}
			
			
	
		return true;
		}
	</script>
	
      <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
        <tr>
          <td ><div align="right" ><b>Banner Page:</b></div></td>
          <td ><select name="page" id="page">
              <? echo fn_ddl("BannerPage", $page)?>
              </select>          </td>
        </tr>
        <tr>
          <td width="30%" ><div align="right" ><b>Banner Location:</b></div></td>
          <td width="70%" ><select name="banner_location" id="">
		   <? echo fn_ddl("BannerLocation", $banner_location, $stor_id)?>
		  </select>         </td>
        </tr>
        <tr>
          <td ><div align="right" ><b>Start Date:</b></div></td>
          <td ><input name="startdate" type="text" id="datepicker" style="width:190px;" value="<? echo $start_date?>" size="10" maxlength="10" /></td>
        </tr>
		
        <tr>
          <td ><div align="right" ><b>End Date:</b></div></td>
          <td ><input name="enddate" type="text" id="datepicker1" style="width:190px;" value="<? echo $end_date?>" size="10" maxlength="10" /></td>
        </tr>
		<tr>
          <td ><div align="right" ><b>Book Code/ Url:</b></div></td>
          <td ><input name="link" type="text" id="link" style="width:190px;" value="<? echo $url?>" size="70" /> 
          (Code like: 123,345,235) </td>
        </tr>
		<tr>
          <td ><div align="right" ><b>Sort:</b></div></td>
          <td ><input name="sort" type="text" id="sort" style="width:90px;" value="<? echo $sort?>" size="10" /></td>
        </tr>
		<tr>
            <td width="30%" ><div align="right" ><b>Banner Image:</b></div></td>
            <td width="70%" ><input type="file" name="file" /></td>
        </tr>
        <tr>
          <td width="30%" ><div align="right" ><b>Is Active:</b></div></td>
          <td width="70%" ><div>
		  <input name="active" type="radio" value="1" <? echo $active ?> />
            Active
              <input name="active" type="radio" value="0"  <? echo $inactive ?>  />
			Inactive
			</div>		</td>
        </tr>
       
		
	   
        <tr >
          <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
              <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" id="submitbutton" value="Save" />
            </div></td>
        </tr>
        <tr >
          <td colspan="2" align="center">
		  <? if ($image !="") 
		  	echo "<img style='width: 367px;' src='../upload/banners/$image'>" ?>
		  
		  </td>
        </tr>
      </table>
</form>






</body>


<script type="text/javascript">        



function AddSelectedProduct()
{
var strMainProduct = document.getElementById("ctl00_MainContent_ddlProduct");
var strSelectedProduct =  document.getElementById("ctl00_MainContent_ddlProduct1");
//             if(strMainProduct.selectedIndex == -1)
//             {
//                alert("Please select a book to add from list");               
//             }
//             else
{
	


var flag = 0;
var intlength = strSelectedProduct.length;                          
if(intlength == 0)
{
strSelectedProduct.options[intlength]= new Option(strMainProduct.options[strMainProduct.selectedIndex].text,strMainProduct.options[strMainProduct.selectedIndex].value);                
}
else
{ 
for(i=0;i<strSelectedProduct.length;i++)
{                        
if(strSelectedProduct.options[i].value == strMainProduct.options[strMainProduct.selectedIndex].value )
{	                    
flag = 1;
intlength = i+1;
break;
}
}

if(flag == 0)
{
strSelectedProduct.options[strSelectedProduct.length]= new Option(strMainProduct.options[strMainProduct.selectedIndex].text,strMainProduct.options[strMainProduct.selectedIndex].value);
flag = 0;
}
}
}
}

function DeleteSelectedProduct() {
var strSelectedProduct =  document.getElementById("ctl00_MainContent_ddlProduct1");
//alert(strSelectedProduct.selectedIndex);
if(strSelectedProduct.selectedIndex == -1)
{
alert("Please select a book to delete from list");               
}
else
{
for (i = 0; i < strSelectedProduct.length; i++) {
if (strSelectedProduct.selectedIndex >= 0) {                                       
if(strSelectedProduct.options[i].value == strSelectedProduct.options[strSelectedProduct.selectedIndex].value ) {
            
strSelectedProduct.remove(i);
break;
}
}
}
}            
}

</script>

</html>

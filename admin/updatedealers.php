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
      <h1>Manage Category </h1>
    </div>
    <?
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");

if (get("Submit3")!= "")
{
	$store_name = get("store_name");
	$contact_person = get("contact_person");
	$address = get("address");
	$city = get("city");
	$state = get("state");
	$phone = get("phone");
	$phone1 = get("phone1");	
	$active = get("active");
	
	$cols = " Set store_name='$store_name',contact_person='$contact_person',address='$address',
							city='$city',state='$state',phone='$phone',phone1='$phone1',active='$active'";
	if ($row_id==0)
	{	
		$sql = "insert into bookstores $cols";	
	}
	else
	{
		$sql = "update bookstores $cols
				where id=$row_id ";
	}
	
	mysql_query($sql);
	
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');parent.location.href='managedealers.php' </script>";
}

$sql = "select * from bookstores where id=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$store_name = $row["store_name"];
	$contact_person = $row["contact_person"];
	$address = $row["address"];
	$city = $row["city"];
	$state = $row["state"];
	$phone = $row["phone"];
	$phone1 = $row["phone1"];	
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
	font-size:11px;
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
          <td width="30%" align="right" ><b>Store Name:</b></td>
          <td width="70%" ><input name="store_name" type="text" id="store_name" style="width:190px;" value="<? echo $store_name?>" size="30" maxlength="255" />          </td>
        </tr>
        <tr>
          <td width="30%" align="right" valign="top" ><b>Contact Person </b></td>
          <td width="70%" ><input name="contact_person" type="text" id="contact_person" style="width:190px;" value="<? echo $contact_person?>" size="30" maxlength="500" /></td>
        </tr>
        <tr>
          <td width="30%" align="right" valign="top" ><b>Address:</b></td>
          <td width="70%" ><input name="address" type="text" id="address" style="width:190px;" value="<? echo $address?>" size="30" maxlength="255" /></td>
        </tr>
        <tr>
          <td width="30%" align="right" ><b>City:</b></td>
          <td width="70%" ><input name="city" type="text" id="city" style="width:190px;" value="<? echo $city?>" size="30" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" ><b>State:</b></td>
          <td ><input name="state" type="text" id="state" style="width:190px;" value="<? echo $state?>" size="30" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" ><b>Phone:</b></td>
          <td ><input name="phone" type="text" id="phone" style="width:190px;" value="<? echo $phone ?>" size="30" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" ><b>Phone 1:</b></td>
          <td ><input name="phone1" type="text" id="phone1" style="width:190px;" value="<? echo $phone1 ?>" size="30" maxlength="255" /></td>
        </tr>
        <tr>
          <td width="30%" align="right" ><b>Is Active:</b></td>
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
  </div>
</body>
</html>

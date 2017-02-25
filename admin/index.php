<?php
error_reporting(0);
session_start();

$_SESSION["admin"] = "";
$_SESSION['username']="";
$_SESSION['uid']="";
$_SESSION["StoreId"]='';

$msg = $_REQUEST["msg"];
if (isset($_POST['login']))
{
	$msg="Invalid Login Information!!";	
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	include("../include/config.php");
	$sql="select * from admin_users where email='$username' and password='$password'";
	$select_query=mysql_query($sql);
	while($row=mysql_fetch_array($select_query))
	{
		$msg="Login...";	
		$username=$row['email'];
		$_SESSION["admin"] = "yes";
		$_SESSION['username']=$username;
		$_SESSION['uid']=$row['id'];

		header("location:main.php");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>fashion Admin Area</title>
<link rel="stylesheet" href="admin.css" type="text/css" />
<style type="text/css">
<!--
.style5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12; }
.style6 {
	font-size: 10px;
	color: #000000;
}
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
body {
	background-color: #FFFFFF;
	margin-top: 140px;
}
.style9 {color: #FFFFFF}
.style12 {
	font-family: "Courier New", Courier, mono, "Earthquake MF", "Microsoft Sans Serif", "MS Sans Serif", Mangal, Shruti, Script;
	font-size: 24px;
	font-weight: bold;
	color: #FFFFFF;
}
.style15 {
	font-size: 10px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style18 {
	font-size: 36px;
	color: #000000;
}
.style23 {font-size: 36px; color: #000000; font-weight: bold; }
.style26 {font-size: 36px; color: #FF0000; font-weight: bold; }
.style28 {
	font-size: 14px;
	color: #666666;
}
-->
</style>
<meta name="google-site-verification" content="mCOTc5k6Pfq1ufJd4sh_TVDZGGUk32CIq-ksMwkrhMw" />
</head>

<body>
<form id="form1" name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
  <table width="100" style="border:#B51D68 10px " border="5px"  align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="21%"><img src="image/login.gif" width="204" height="300" /></td>
      <td width="79%" align="center" bgcolor="#EEF3F2"><span class="style12"><span class="style26">Fashion Admin Area</span></span>
        <br />
        <br />
        <table width="429" border="0">
          <tr>
            <td width="135" align="right">Username:</td>
            <td width="284" align="left"><input name="username" type="text" class="text" id="username" style="border:#6175C7 1px solid" size="16" default /></td>
          </tr>
          <tr>
            <td align="right">Password:</td>
            <td align="left"><input name="password" type="password" class="text" id="password" style="border:#6175C7 1px solid" size="16" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" class="style9">
              <input name="login" type="submit" class="style7" id="login5" style="background-color:#93D084;border:#6175C7 1px solid" value="Login&gt;&gt;" />
            </td>
          </tr>
        </table>
      <span class="style7">&nbsp;<?php echo $msg; ?> </span></td>
    </tr>
  </table></br></br></br></br>
  <div align="center"><span class="style15">All rights reserved. Design & Developed by Ramagya.</span></div>
</form>
<span class="style15">
<script>
</script>
</span>
<script>document.getElementById("username").focus();
</script>
</body>
</html>

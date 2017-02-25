<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/styles.css" rel="stylesheet" type="text/css" /> 
<link href="styles.css" rel="stylesheet" type="text/css" />


</head>
<body>

<div class="my-account">
  <div class="dashboard">
    <div class="page-title">
      <h1>Change Password </h1>
    </div>
	
	<?
		if (isset($_POST['Save']))
		{
			$old=$_POST['oldpassword'];
			$new=$_POST['newpassword'];
			$user=$_SESSION['username'];
			$str="update admin_users set password='$new' where email='$user' && password='$old'";
			
			$result=mysql_query($str);
			if(mysql_affected_rows())
			{
				$msg="Your Password is successfully Changed ";
				//header("location:index.php?msg=$msg");
				echo "<script>alert('$msg');parent.location.href='index.php' </script>";
			}
			else
			{
				echo $msg="Error: Old Password is not matching";
			}
		}
		?>
		<FORM action="" method="post">
		  <table width="379" border="0">
            <tr>
              <td width="21%" height="35">&nbsp;</td>
              <td width="30%"><span class="style5"><span class="style6"><span class="style7  style15">Old Password:</span></span></span></td>
              <td width="49%"><input name="oldpassword" type="password" class="text" id="oldpassword" style="border:#6175C7 1px solid" size="16" required /></td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td><span class="style7  style15"><span class="style5"><span class="style6">New Password:</span></span></span></td>
              <td><input name="newpassword" type="password" class="text" id="newpassword" style="border:#6175C7 1px solid" size="16" required /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><input name="Save" type="submit" id="login" value="Save" /></td>
            </tr>
          </table>
</FORM>
	


</body>
</html>

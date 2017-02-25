<?php
session_start();
if($_SESSION['username']=="")
	header("location:index.php");
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Main Screen</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #999999;
}
.style1 {
	font-size: 24px;
	font-style: italic;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
-->
</style><meta name="google-site-verification" content="mCOTc5k6Pfq1ufJd4sh_TVDZGGUk32CIq-ksMwkrhMw" />
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><? include("top.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#E4F0FC"><table width="100%"  border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="17%" bgcolor="#9999CC">&nbsp;</td>
        <td width="83%"><div align="center">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>Welcome</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
		  <? include_once("cron_orderstatus.php"); ?>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><? include("bottam.php"); ?></td>
  </tr>
</table>
</body>
</html>

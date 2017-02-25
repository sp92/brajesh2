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
.style2 {color: #FFFFFF}
.style3 {font-weight: bold}
.style4 {color: #FFFFFF; font-weight: bold; }
ul li {padding:0 0 0 0;position:relative}
ul li img {float:none !important}
ol {margin-left:1.5em}
ol li {list-style-type:decimal;list-style-position:inside}
.ul {list-style-type:decimal;list-style-position:inside}
.hn{font-family:surya;font-size:18px;}

-->
</style><meta name="google-site-verification" content="mCOTc5k6Pfq1ufJd4sh_TVDZGGUk32CIq-ksMwkrhMw" />
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><? include("top.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#E4F0FC">
	<table width="100%"  border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="17%" align="center" valign="top" bgcolor="#9999CC">&nbsp;
		</td>
        <td width="83%"><table width="100%" height="29"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="4%" bgcolor="#CCCCCC">&nbsp;</td>
            <td width="96%" bgcolor="#0066FF"><strong class="style2">Db Backup </strong></td>
          </tr>
        </table>
         
		 <form method="post" action="">
		   <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td height="36" align="center" bgcolor="#FFFFFF"><? include("dbbackup.php"); ?></td>
            </tr>
            <tr>
              <td bgcolor="#E5E5E5">&nbsp;
			  </td>
            </tr>
          </table>
          </form>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><? include("bottam.php"); ?></td>
  </tr>
</table>
<script>
function delconf()
{
	if (!confirm('Are you sure to delete'))
		return false;
	else
		return true;
}

function fn_edit(id,issue,desc,act)
{
	document.getElementById("id").value = id;
	document.getElementById("issue").value = issue;
	document.getElementById("desc").value = desc;
	document.getElementById("active").checked = (act==1)?true:false;
}
</script>
</body>
</html>

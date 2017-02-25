<?php
session_start();
if($_SESSION['username']=="")
	header("location:index.php");
include("config.php");	
?>
<?
  $code_id = $_REQUEST['id'];		  
  $code_fld = ($_REQUEST['code_fld']=='new')?$_REQUEST['code_fld1']:$_REQUEST['code_fld'];		  
  
  if (isset($_POST['Submit']))
  {
	$code_value = $_REQUEST['code_value']; 
	$code_desc = $_REQUEST['code_desc']; 
	$code_desc1 = $_REQUEST['code_desc1']; 
	$code_desc2 = $_REQUEST['code_desc2']; 
	$active = $_REQUEST['active']; 

	if ($active == "") $active = 0;
	if ($code_id == 0)
	{
		$insert_query=mysql_query("Insert into codemstr (code_id, code_fld, code_value, code_desc, code_desc1, code_desc2, active) VALUES (NUll, '$code_fld', '$code_value', '$code_desc', '$code_desc1', '$code_desc2', $active)") or die (mysql_error());
	}
	else
		$insert_query=mysql_query("UPDATE codemstr SET code_fld='$code_fld',`code_value`='$code_value',`code_desc`='$code_desc',`code_desc1`='$code_desc1', `code_desc2`='$code_desc2',active='$active' WHERE code_id=$code_id") or die (mysql_error());			

	if($insert_query)
	{
		$msg="$code_fld Sucessfully saved..!";
		header('location:codelist.php?ms='.$msg.'&code_fld='.$code_fld);
	}
	else
	{
		mysql_error();
	}
  } // Save 
	  

	if ($code_fld != "")
	{
		if ($code_id != "")
		{
			$sql = "Select * from codemstr where code_id = $code_id ";
			$det_arr = mysql_query($sql );
			while($row=mysql_fetch_array($det_arr))
			{
				$code_value = $row['code_value'];
				$code_desc = $row['code_desc'];
				$code_desc1 = $row['code_desc1'];
				$code_desc2 = $row['code_desc2'];
				$active = $row['active'];
				if ($active == 1)	$chk = "Checked";
				
			}
		}
	}
	//echo $type;   
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
    <td bgcolor="#E4F0FC">
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="17%" bgcolor="#9999CC">&nbsp;</td>
        <td width="83%">
		<table width="100%" height="29"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="4%" bgcolor="#CCCCCC">&nbsp;</td>
            <td width="96%" bgcolor="#0066FF"><strong class="style2"> >> Code Settings </strong></td>
          </tr>
        </table>
          
          
          <form action="codesettings.php" method="post"  name="form">
            <table width="521" height="20"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
              <tr>
                <td colspan="2" class="style2"> Add/Edit <? echo $code_fld;?> </td>
              </tr>
              <tr valign="top" bgcolor="#FFFFFF">
                <td width="173" align="right">Code Field </td>
                <td width="337">
               		<select name="code_fld" id="code_fld" style="font-size:10px" onchange="fn_checksel()">
					    <option value="">--- Select ---</option>
					    <?
							$special=mysql_query("select distinct(code_fld) from codemstr  order by code_fld");
							while($row=mysql_fetch_array($special))
							{
								if (trim($code_fld) == trim($row["code_fld"])) $sel = "selected";
								echo "<option value='". $row["code_fld"]."' ". $sel.">". strtoupper($row["code_fld"])."</option>";
								$sel = "";
							}
							echo "<option value='new' ". $sel.">Other/New</option>";
						  ?>
				       </select>
                    <input name="id" type="hidden" id="id" value="<? echo $code_id;?>">               		
                    <input name="code_fld1" type="text" id="code_fld1" value="" size="40" maxlength="200" style="display:none;">
				     <script>
					  function fn_checksel()
					  {
						if (document.getElementById("code_fld").value == "new")
						{
							document.getElementById("code_fld1").style.display = "inline";
						}
						else
						{
							document.getElementById("code_fld1").style.display = "none";
						}
					  }
					 </script>
                 </td>
              </tr>
			  <?
			  if ($type == "SubCategory") {?>
			  <? }?>
              <tr bgcolor="#FFFFFF">
                <td align="right">Value&nbsp;</td>
                <td><input name="code_value" type="text" id="code_value" value="<? echo $code_value;?>" size="40" maxlength="500"></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td align="right" valign="top">Description&nbsp;</td>
                <td><input name="code_desc" type="text" id="code_desc" value="<? echo $code_desc;?>" size="40"></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td align="right" valign="top">Description1&nbsp;</td>
                <td><input name="code_desc1" type="text" id="code_desc1" value="<? echo $code_desc1;?>" size="40" maxlength="500"></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td align="right" valign="top">Description2&nbsp;</td>
                <td><input name="code_desc2" type="text" id="code_desc2" value="<? echo $code_desc2;?>" size="40" maxlength="500"></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td align="right">Is Active&nbsp;</td>
                <td><input name="active" type="checkbox" id="active" value="1" <? echo $chk ?>></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td colspan="2" align="right"><div align="center">
                    <input type="submit" name="Submit" value="Save" onClick="return validate();">
                    <input type="reset" name="Submit2" value="Reset">
                </div></td>
              </tr>
            </table>
          </form>
      </table>         
    </td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td><? include("bottam.php"); ?></td>
  </tr>
</table>
<script>
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

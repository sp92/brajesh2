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
.style3 {font-weight: bold}
.style4 {color: #FFFFFF; font-weight: bold; }
ul li {padding:0 0 0 0;position:relative}
ul li img {float:none !important}
ol {margin-left:1.5em}
ol li {list-style-type:decimal;list-style-position:inside}
.ul {list-style-type:decimal;list-style-position:inside}
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
        <td width="83%">
		<?
			  $code_fld = $_REQUEST['code_fld'];
			  if ($code_fld == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {
			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="delete from codemstr where code_id= $id";
						$query1=mysql_query($sql);
						if ($query1) $msg =  "<br>Record Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update codemstr set active = ".get("active")." where code_id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Record Updated...";
					}
				}
			}
			  ?>
		
		<table width="100%" height="29"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="4%" bgcolor="#CCCCCC">&nbsp;</td>
            <td width="96%" bgcolor="#0066FF"><strong class="style2">Settings List</strong></td>
          </tr>
        </table>
         <center style="color:#FF0000"><? echo $_REQUEST["ms"]. $msg; ?></center>
          <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href="codesettings.php?code_fld=<? echo $code_fld;?>">Add <? echo $title;?>
			  </a>
			  
			  <table width="100%"  border="0">
                <tr bgcolor="#FFFFFF">
                  <td colspan="7"><div align="center"><span class="style3">
				  <form>
				    <div align="left">Code Field
				        <select name="code_fld" id="code_fld" onchange="form.submit()" style="font-size:10px">
					    <option value="">--- Select ---</option>
					    <?
							$special=mysql_query("select distinct(code_fld) from codemstr  order by code_fld");
							while($row=mysql_fetch_array($special))
							{
								$sel = "";
								if ($code_fld == $row["code_fld"]) $sel = "selected";
								echo "<option value='". $row["code_fld"]."' ". $sel.">". strtoupper($row["code_fld"])."</option>";
							}
						  ?>
				          </select>
				      </div>
				  </form>
				  <?php echo $print  ?></span></div></td>
                  </tr>
                <tr bgcolor="#A9A9A9">
                  <td width="2%" height="21"><div align="center"><strong><span class="style16 style2">#</span></strong></div></td>
                  <td width="10%"><div align="center"><strong><span class="style16 style2">Option</span></strong></div></td>
				  <td width="14%" ><div align="left"><strong><span class="style16 style2">Code Value</span></strong></div></td>                  
                  <td width="20%" ><span class="style4">Code Desc1</span></td>
                  <td width="23%"><span class="style4">Code Desc2</span></td>
                  <td width="24%"><span class="style4">Code Desc3</span></td>
                  <td width="7%"><div align="center"><strong><span class="style16 style2">Active</span></strong></div></td>                  
                </tr>
				<?php
				if ( $_REQUEST['code_fld']!="")
				{
					$sql="select * from codemstr where code_fld = '$code_fld'  order by code_fld, code_value";
					$query=mysql_query($sql);
				
				{
					while($row=mysql_fetch_array($query))
					{
					 $sn += 1;
					 $id=$row['code_id']; 
					 //$catid = $row['category_id'];
					 //$scatid = $row['subcategory_id'];
					 $code_fld=$row['code_fld'];	
					 $code_value=$row['code_value'];					 
					 $active=($row['active']==1)?'Yes':'No';
					 $status=($row['active']==1)?'0':'1';
					 $code_desc = $row['code_desc'];
					 $code_desc1 = $row['code_desc1'];
					 $code_desc2 = $row['code_desc2'];
					 echo "<tr valign='top' class=ol>
						<td class=ul><div align='center'> $sn </div></td>
						<td><a href='codesettings.php?code_fld=$code_fld&id=$id'><u>Edit</u></a></font> | <a href='codelist.php?code_fld=$code_fld&id=$id&del=y' onclick='return delconf();'><u>Delete</u></a></font></td>
						<td>$code_value</td>
						<td>$code_desc</td>
						<td>$code_desc1</td>
						<td>$code_desc2</td>
						<td> <a href='codelist.php?code_fld=$code_fld&id=$id&active=$status'> $active </a></td>
						</tr> 
						<tr><td colspan=5></td></tr>";
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=5 align=center bgcolor=yellow> No data found </td></tr>";
				
				}
				?>
              </table>
			  <? 
			  }
			   ?>			  </td>
            </tr>
            <tr>
              <td bgcolor="#E5E5E5">&nbsp;
			  </td>
            </tr>
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

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
</style>

<meta name="google-site-verification" content="mCOTc5k6Pfq1ufJd4sh_TVDZGGUk32CIq-ksMwkrhMw" />
</head>
<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><? include("top.php"); ?>
    </td>
  </tr>
  <tr>
    <td style="padding-left:10px" ><table width="99%"  border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td  align="center" valign="top"><? include("left.php"); ?>
          </td>
          <td ><?
			  
			  $type = "U"; //$_REQUEST['type'];
			  $title = "eMag SMS ";// $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {
			  	
			  }
			
			if ($_REQUEST["category"] != "") 
				$category = $_REQUEST["category"];
				
			if ($_REQUEST["lang"] != "") 
				$lang = $_REQUEST["lang"];
			else
				$lang = "E";
				
			$sql="select * from emag_sms";
			$query = mysql_query($sql);
			$totalusers= mysql_num_rows($query);
			
			$enddate=get("enddate");
			$fromdate =  get("fromdate");
			$fldName = get("fldName");
			$kw = get("kw");
			if ($fromdate == "") $fromdate = date('Y-m-d');
			if ($enddate=="") $enddate= date('Y-m-d');
			 $_SESSION["filter"] = "";
			  ?>
            <div class="my-account" >
              <div class="dashboard" >
                <div class="page-title" >
                  <h1><? echo $title ?> List</h1>
                </div>
              </div>
            </div>
            <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>
            <div class="filter"> <strong>Search By:</strong>
              <form action="" method="get" name="fm_user">
              <strong>From: </strong>
                <input name="fromdate" type="date" id="fromdate" value="<? echo $fromdate?>" size="10"  maxlength="10">
                <strong>to </strong>
                <input name="enddate" type="date" id="enddate"  value="<? echo $enddate?>">
                <input name="Search" type="submit" value="Search" onclick="//fn_get('users.php')">
                
				<input name="Export" type="button" id="Export" value="Export" onClick="window.open('export/?for=SMS-List','iFrame','')">
              </form>
            </div>
            <table width="100%"  border="0" bgcolor="#D3D3D3">
              <tr>
                <td bgcolor="#FFFFFF"><a href="managequestions.php?type=<? echo $type;?>&t=<? echo $title;?>"></a>
                  <?
			  if ($type != "")
 			  {	
			  	    $_SESSION["ExpSql"] ="";
				 	$sn =0;
					$_SESSION['type'] = $type;
					$_SESSION["lang"] = $lang;
					
					$qdt = " created_date between '$fromdate 00:00:01' and '$enddate 23:59:59'";				
					
					$sql="select * from emag_sms where  $qdt order by created_date desc";
					$query=mysql_query($sql);
					$_SESSION["filter"] = $qdt;
					//$_SESSION["ExpSql"] = $sql;
				}
			  ?>
                  <table width="100%"  border="0">
                    <tr class="table_header">
                      <td colspan="8"><div align="left"> Total Address Count: <? echo $totalusers ?>.   &nbsp;&nbsp;Current Listing: <? echo mysql_num_rows($query);?> </div></td>
                    </tr>
                    <tr bgcolor="#A9A9A9">
                      <td width="2%" height="21"><div align="center"><strong><span class="style16 style2">#</span></strong></div></td>
                      <td><strong><span class="style16 style2">Name</span></strong></td>
                      <td width="14%" ><div align="left"><span class="style4">City</span></div></td>
                      <td width="15%" ><span class="style4">Email</span></td>          
					   <td width="15%" ><span class="style4">Mobile</span></td>                     
                      <td width="11%" ><span class="style4">Created Date </span></td>                    
                    </tr>
                    <?php
				if ($type != "")
				{	
					while($row=mysql_fetch_array($query))
					{
					 $sn += 1;
					 //$id=$row['id']; 					
					 $col1=$row['FirstName'] .' '. $row['LastName'];	
					 $col2=$row['City'];						
					 $col3 = $row['Email'];
					 $col4 = $row['Mobile'];
					 $col5 = $row['created_date'];
					 $bgcolor=($sn % 2)?'row':'row1';
					 //if ((string)$col4 != (string)$col5) $bgcolor="<b>";
					 //$code_desc2 = $row['code_desc2'];
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=700&modal=false";
					 echo "<tr  class='$bgcolor'>
						<td>$sn</td>
						<td>$col1</td>
						<td>$col2</td>
						<td >$col3</td>
						<td >$col4</td>
						<td >$col5</td>
					
						</tr> 
						<tr><td colspan=6></td></tr>";
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=9 align=center bgcolor=yellow> No data found </td></tr>";
				
				
				?>
                  </table>
                  <? 
			  }
			   ?>
                </td>
              </tr>
              <tr>
                <td bgcolor="#E5E5E5">&nbsp;</td>
              </tr>
            </table>
            </form>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><br>
      <? include("bottam.php"); ?></td>
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

function fn_get(act)
{
	document.forms["fm_user"].target = (act=='users.php'?'':'new');
	document.forms["fm_user"].action = act;
	document.forms["fm_user"].action.submit();
}
</script>
</body>
</html>

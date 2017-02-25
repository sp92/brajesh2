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
	<script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="thickbox.js"></script>

	</td>
  </tr>
  <tr>
    <td bgcolor="#E4F0FC">
	<table width="100%"  border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="9%" align="center" valign="top" bgcolor="#9999CC">&nbsp;		</td>
        <td width="91%">
		<?
			  
			  $type = "U"; //$_REQUEST['type'];
			  $title = "Users";// $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {
			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="delete from users where UserId= $id";
						$query1=mysql_query($sql);
						if ($query1) $msg =  "<br>Record Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update users set active = ".get("active")." where userid= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Record Updated...";
					}
				}
			}
			if ($_REQUEST["category"] != "") 
				$category = $_REQUEST["category"];
				
			if ($_REQUEST["lang"] != "") 
				$lang = $_REQUEST["lang"];
			else
				$lang = "E";
				
			$sql="select UserId from users";
			$query = mysql_query($sql);
			$totalusers= mysql_num_rows($query);
			?>
		
		<table width="100%" height="29"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="4%" bgcolor="#CCCCCC">&nbsp;</td>
            <td width="96%" bgcolor="#0066FF"><strong class="style2"><? echo $title ?>  List</strong></td>
          </tr>
        </table>
         <center style="color:#FF0000"><? echo $_REQUEST["ms"]. $msg; ?></center>
		 <form method="get" action="">
		   <strong>From:		   </strong>
		   <input name="fromdate" type="text" id="fromdate" value="<?echo date('Y-m-d')?>" size="10" maxlength="10">(YYYY-mm-dd)  
		   <strong>to Last		   </strong>
		   <input name="days" type="text" id="days" size="2" maxlength="3" value="0"> 
		   <strong>Days</strong> 
		   <input name="Search" type="submit" value="Search">
          <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href="managequestions.php?type=<? echo $type;?>&t=<? echo $title;?>"></a>
			  <?
			  if ($type != "")
				{	$sign="";
				 	$sn =0;
					$_SESSION['type'] = $type;
					$_SESSION["lang"] = $lang;
					
					//if (get("fromdate") != "" && get("days") >= 0) 
					{
						$days=get("days");
						$todate =  get("fromdate");
						if ($todate == "") $todate = date('Y-m-d');
						if ($days=="") $days=0;
						$fromdate =  date('Y-m-d', strtotime($todate) - ($days * 60 * 60 * 24)); 
						$qdt = " where createddate >= '$fromdate 00:00:00' and createddate <= '$todate 23:59:59'";			
					}		
					
					$sql="select *, (select code_desc from codemstr where code_fld='Sign' AND code_value=Sign) As Sign ,
					(select MaillingDate from mailling_logs where UId=UserId order by MaillingDate desc limit 1) As MaillingDate 
					from users $qdt order by userid desc";
					//echo $sql;
					$query=mysql_query($sql);
				}
			  ?>
			  <table width="100%"  border="0">
                <tr bgcolor="#FFFFFF">
                  <td colspan="8"><div align="left">
				 Total User Count: <? echo $totalusers ?>.   &nbsp;&nbsp;Current Listing: <? echo mysql_num_rows($query);?>
				  <span class="style3"><?php echo $print  ?></span></div></td>
                  </tr>
                <tr bgcolor="#A9A9A9">
                  <td width="2%" height="21"><div align="center"><strong><span class="style16 style2">#</span></strong></div></td>
                  <td width="5%"><div align="center"><strong><span class="style16 style2">Option</span></strong></div></td>
				  <td width="5%" ><div align="left"><strong><span class="style16 style2">Sign</span></strong></div></td>                  
				  <td width="14%" ><div align="left"><strong><span class="style16 style2">Name</span></strong></div></td>                  
                  <td width="15%" ><span class="style4">City/State</span></td>
                  <td width="25%" ><span class="style4">Email</span></td>
                  <td width="11%" ><span class="style4">Created Date </span></td>
                  <td width="11%" ><span class="style4">Updated Date </span></td>
                  <td width="11%"><span class="style4">Mailing Date</span></td>
                </tr>
				<?php
				if ($type != "")
				{	
					while($row=mysql_fetch_array($query))
					{
					 $sn += 1;
					 $id=$row['UserId']; 
					 $col0= $row['Sign'];	
					 $col1=$row['Name'];	
					 $col2=$row['City'].' '.$row['State'];	
					 //$class = ($col2=="E")?"eng":"hn";				 
					 $colLast=($row['Active']==1)?'Yes':'No';
					 $status=($row['Active']==1)?'0':'1';
					 $col3 = $row['Email'];
					 $col4 = $row['CreatedDate'];
					 $col5 = $row['ModifiedDate'];
					 $col6 = $row['MaillingDate'];
					 $bgcolor="";
					 if ((string)$col4 != (string)$col5) $bgcolor="<b>";
					 //$code_desc2 = $row['code_desc2'];
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=550&width=750&modal=false";
					 echo "<tr valign='top' class=ol>
						<td class=ul><div align='center'> $sn </div></td>
						<td><a href='mailling_personal.php?type=$type&t=$title&uid=$id$aj' class='thickbox'><u>Send Mail</u></a></td>
						<td>$col0</td>
						<td>$col1</td>
						<td>$col2</td>
						<td class=$class>$col3</td>
						<td class=$class>$col4</td>
						<td class=$class>$bgcolor$col5</td>
						<td>$col6</td>
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
			   ?>			  </td>
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

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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#fromdate" ).datepicker({ dateFormat: "yy-mm-dd" });
    $( "#fromdate1" ).datepicker({ dateFormat: "yy-mm-dd" });
  });
  </script>
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><? include("top.php"); ?>

	</td>
  </tr>
  <tr>
   <td style="padding-left:10px" >
	<table width="99%"  border="0" cellspacing="0" cellpadding="3">
      <tr>
         <td  align="center" valign="top">
		<? include("left.php"); ?>
		</td>
        <td >
		<?
			  
			  
			  	
			  	if ($_REQUEST["del"] == "y")
				{
					if ($_REQUEST["id"] != "")
					{
						$id = $_REQUEST["id"];
						$sql="delete from feedback where id= $id";
						$query1=mysql_query($sql);
						if ($query1) $msg =  "<br>Record Deleted...";
					}
				}
				
				if ($_REQUEST["active"]!= "")
				{			
					if ($_REQUEST["id"] != "")
					{
						$id = $_REQUEST["id"];
						$sql="update feedback set active = ".$_REQUEST["active"]." where id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Record Updated...";
					}
				}
			
			
			$enddate=get("enddate");
			$fromdate =  get("fromdate");
			$fldName = get("fldName");
			$kw = get("kw");
			if ($fromdate == "") $fromdate = date('Y-m-d');
			if ($enddate=="") $enddate= date('Y-m-d');
			  ?>
		
		<div class="my-account" >
		  <div class="dashboard" >
			<div class="page-title" >
			  <h1>Feedback  List</h1>
			</div>
		  </div>
		</div>
        <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>	
		 <div class="filter">
		  <strong>Search By:</strong><br>
		 <form method="get" action="">
		   <strong>From:		   </strong>
		   <strong>From:		   </strong>
		   <input name="fromdate" type="date" id="fromdate" value="<? echo $fromdate?>" size="10"  maxlength="10">
		   <strong>to 		   </strong>
		   <input name="enddate" type="date" id="enddate"  value="<? echo $enddate?>">
		   
		   <input name="Search" type="submit" value="Search" onclick="//fn_get('managereview.php')">
		  <!-- <input name="Export" type="submit" id="Export" value="Export Users" onclick="fn_get('usersexport.php')">-->
		   </form>
		   </div>
		  
		   <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href="managequestions.php?type=<? echo $type;?>&t=<? echo $title;?>"></a>
			  <?
			 	
				 	$sn =0;						
					$sql="select count(*) from feedback ";
					$query = mysql_query($sql);
					$row=mysql_fetch_array($query);
					$totalusers = $row[0];
					
					$qdt = " where `date` between '$fromdate 00:00:01' and '$enddate 23:59:59'";	
					$sql="select * from feedback $qdt order by id desc";
					$query=mysql_query($sql);
				
			  ?>
			  <table width="100%"  border="0">
                <tr bgcolor="#FFFFFF">
                  <td colspan="11"><div align="left">
				 Total Reviews Count: <? echo $totalusers ?>.   &nbsp;&nbsp;Current Listing: <? echo mysql_num_rows($query);?>
				 </div></td>
                  </tr>
                <tr class="table_header">
                  <td width="2%" height="21"><div align="center"><strong><span>#</span></strong></div></td>
                  <td width="5%"><div align="center"><strong><span>Option</span></strong></div></td>
				  <td width="4%" ><div align="left"><strong><span >Type</span></strong></div></td>  
				  <td width="7%" ><div align="left"><strong><span >Related to</span></strong></div></td>
				  <td width="14%" ><div align="left"><strong><span >Inquiry for</span></strong></div></td>  
				  <td width="13%" ><div align="left"><strong><span >Name</span></strong></div></td>  
				  <td width="16%" ><div align="left"><strong><span >Email</span></strong></div></td>                  
				  <td width="8%" ><div align="left"><strong><span >Mobile</span></strong></div></td>                  
                  <td width="20%" ><span ><strong>Message</strong></span></td>                
                  <td width="11%" ><span ><strong>Date</strong></span></td>
                </tr>
				<?php
					
					while($row=mysql_fetch_array($query))
					{
					 $sn++;
					 
					 $id=$row['id']; 
					 $col= $row['inquiry_type'];	
					 $col0= $row['inquiry_related_to'];	
					 $col1=$row['inquiry_for'];	
					 $col2=$row['name'];	
					 $col3 = $row['company_name'];
					 $col4 = $row['address'].'</br>'.$row['city'].'- '.$row['pin'] .'</br>'.$row['state'].'</br>'.$row['country'];
					 $col5 = $row['email'];					
					 $col6 = $row['mobile'];				
					 $col7 = $row['inquiry_message'];					
					 $col8 = $row['date'];					
					 $bgcolor=($sn % 2)?'row':'row1';
					
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=700&modal=false";
					 echo "<tr  class='$bgcolor'>
						<td ><div align='center'> $sn </div></td>
						<td><a href='managefeedback.php?id=$id&del=y&fromdate=$todate&days=$days' onclick='return delconf();'><u>Delete</u></a></font></td>
						<td>$col</td>
						<td>$col0</td>
						<td>$col1</td>		
						<td>$col2</td>						
						<td >$col5</td>
						<td >$col6</td>
						<td >$col7</td>
						<td >$col8</td>
						</tr> 
						<tr><td colspan=6></td></tr>";
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=11 align=center bgcolor=yellow> No data found </td></tr>";
				
				
				?>
              </table>
  			    </td>
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
    <td>	<br><? include("bottam.php"); ?></td>
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
	document.forms[0].target = (act=='users.php'?'':'new');
	document.forms[0].action = act;
	document.forms[0].action.submit();
}
</script>
</body>
</html>

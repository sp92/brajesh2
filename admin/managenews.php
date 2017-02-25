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

</head>
<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<? include("top.php"); ?>

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
			  
			  $type = $_REQUEST['type'];
			  $title =  $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {
			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="delete from events where event_id= $id";
						$query1=mysql_query($sql);
						if ($query1) $msg =  "<br>Record Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update events set active = ".get("active")." where event_id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Record Updated...";
					}
				}
			}
			
			$enddate=get("enddate");
			$fromdate =  get("fromdate");
			$fldName = get("fldName");
			$kw = get("kw");
			if ($fromdate == "") $fromdate = date('Y-m-d');
			if ($enddate=="") $enddate= date('Y-m-d');

			
			 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=550&width=850&modal=false";
			  ?>
		
		<div class="my-account" >
		  <div class="dashboard" >
			<div class="page-title" >
			  <h1><? echo $title ?>  List</h1>
			</div>
		  </div>
		</div>
        <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>	
		 <div class="filter">
		  <strong>Search By:</strong><br>
		 <form method="get" action="">
		   <input type="hidden" name="t" value="<? echo $title?>">
		   <input type="hidden" name="type" value="<? echo $type?>">
		  
		     <? if ($type=='News') {?>
		   <select class="w30" name="enddate" id="enddate" >
                <? for ($i=date('m'); $i >= date('m')-11; $i--) { 
					$val = (($i>0)?date('Y'):date('Y')-1) .'-'.  ($i+(($i>0)?'':'12'));
				?>
                <option value="<? echo $val ?>" <?  if (get('enddate')==$val) echo "selected"; ?>><? echo date('F Y', strtotime($val.'-01')) ?></option>
                <? }?>
              </select>
		  <? } else { ?>	  
			  <? if (!($type=='Event' || $type=='EmpNews' || $type=='ForthExam')) {?>
			   <strong>From:		   </strong>
			   <input name="fromdate" type="date" id="fromdate" value="<? echo $fromdate?>" size="10"  maxlength="10">
			   <strong>to 		   </strong>
			  <? } else echo "Date: "?>
			   <input name="enddate" type="date" id="enddate"  value="<? echo $enddate?>">
		  <? }?>
		 
			  
		   <input name="Search" type="submit" value="Search" onclick="//fn_get('managereview.php')">
		  <!-- <input name="Export" type="submit" id="Export" value="Export Users" onclick="fn_get('usersexport.php')">-->
		   </form>
		   </div>
		  
		   <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			   <a href='updatenews.php?id=0&type=<? echo $type?>&t=<? echo $title?><? echo $aj; ?>' class='thickbox' ">Add <? echo $title ?></a>
			  <?
			  if ($type != "")
				{	
				 	$sn =0;
					if($type=='EmpNews' )
					{
						$qdt = " and '$enddate' between fromdate and enddate ";	
					}
					if($type=='ForthExam')
						$qdt = " and fromdate >= '$enddate'";	
					if($type=='Event')
						$qdt = " and year(enddate) = '". date('Y', strtotime($enddate)) ."'";	
					else
					{
						$enddate = date('Y', strtotime($enddate))*date('m', strtotime($enddate));
						$qdt = " and year(fromdate)*month(fromdate) = '$enddate' ";
						//$qdt = " and `fromdate` between '$fromdate' and '$enddate'";	
					}
					$sql="select count(*) from events where type='$type' $qdt";
					$query = mysql_query($sql);
					$row=mysql_fetch_array($query);
					$totalusers = $row[0];
					
					$sql="select * from events where type='$type' $qdt order by event_id desc";
					$query=mysql_query($sql);
				}
			  ?>
			  <table width="100%"  border="0">
                <tr bgcolor="#FFFFFF">
                  <td colspan="8"><div align="left">
				 Total <? echo $title ?> Count: <? echo $totalusers ?>.   &nbsp;&nbsp;Current Listing: <? echo mysql_num_rows($query);?>
				 </div></td>
                  </tr>
                <tr class="table_header">
                  <td width="2%" height="21"><div align="center"><strong><span>#</span></strong></div></td>
                  <td width="8%"><div align="center"><strong><span>Option</span></strong></div></td>
				  <td  ><div align="left"><strong><span >Title</span></strong></div></td>  
				  <td width="15%" ><div align="left"><strong><span >From Date</span></strong></div></td>                  
				  <td width="14%" ><div align="left"><strong><span >End Date</span></strong></div></td>                  
  				  <td width="11%" ><span ><strong>Created Date</strong> </span></td>
                  <td width="6%"><span ><strong>Active</strong></span></td>
                </tr>
				<?php
				if ($type != "")
				{	
					while($row=mysql_fetch_array($query))
					{
					 $sn++;
					 if ($sn > 50) break;
					 $id=$row['event_id']; 
					 $col0= $row['title'];	
					 $col1=$row['fromdate'];	
					 $col2=$row['enddate'];						 		 
					 $col3 = $row['create_date'];					
					 $colLast=($row['active']==1)?'Yes':'No';
					 $status=($row['active']==1)?'0':'1';
					 $bgcolor=($sn % 2)?'row':'row1';
					
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=950&modal=false";
					 echo "<tr  class='$bgcolor'>
						<td ><div align='center'> $sn </div></td>
						<td><a href='updatenews.php?type=$type&t=$title&id=$id$aj' class='thickbox' ><u>Edit</u></a> | <a href='managenews.php?t=$title&type=$type&id=$id&del=y&fromdate=$todate&days=$days' onclick='return delconf();'><u>Delete</u></a></font></td>
						<td>$col0</td>
						<td>$col1</td>
						<td>$col2</td>
						<td>$col3</td>
						<td> <a href='managenews.php?t=$title&type=$type&id=$id&active=$status&fromdate=$todate&days=$days'> $colLast </a></td>
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

</script>


<script>
  $(function() { 
	//$( "#fromdate" ).datepicker({ dateFormat: "yy-mm-dd" });
	//$( "#datepicker1" ).datepicker({ dateFormat: "yy-mm-dd" });
  });
  </script>

</body>
</html>

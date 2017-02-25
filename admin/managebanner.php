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
    <td><? include("top.php"); ?>
    </td>
  </tr>
  <tr>
    <td style="padding-left:10px" ><table width="99%"  border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td  align="center" valign="top"><? include("left.php"); ?>
          </td>
          <td ><?			  
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="delete from banner where banner_id= $id";
						$query1=mysql_query($sql);
						if ($query1) $msg =  "<br>Record Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update banner set active = ".get("active")." where banner_id= $id";
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
			
			 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=550&width=750&modal=false";
			  ?>
            <div class="my-account" >
              <div class="dashboard" >
                <div class="page-title" >
                  <h1>Banner  List</h1>
                </div>
              </div>
            </div>
            <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>
            <div class="filter" style="display:none"> <strong>Search By:</strong><br>
              <form method="get" action="" >
                <input type="hidden" name="t" value="<? echo $title?>">
                <input type="hidden" name="type" value="<? echo $type?>">
                <strong>From: </strong>
                <input name="fromdate" type="date" id="fromdate" value="<? echo $fromdate?>" size="10"  maxlength="10">
                <strong>to </strong>
                <input name="enddate" type="date" id="enddate"  value="<? echo $enddate?>">
                <input name="Search" type="submit" value="Search" onclick="//fn_get('managereview.php')">
                <!-- <input name="Export" type="submit" id="Export" value="Export Users" onclick="fn_get('usersexport.php')">-->
              </form>
            </div>
            <table width="100%"  border="0" bgcolor="#D3D3D3">
              <tr>
                <td bgcolor="#FFFFFF"><a href='updatebanner.php?id=0<? echo $aj; ?>' class='thickbox' >Add Banner</a>
                  <?
			  	
				 	$sn =0;
					//$qdt = " and `create_date` between '$fromdate 00:00:01' and '$enddate 23:59:59'";	
						
					$sql="select count(*) from banner $qdt";
					$query = mysql_query($sql);
					$row=mysql_fetch_array($query);
					$totalusers = $row[0];
					
					$sql="select * from banner where store_id=$StoreId $qdt order by banner_location desc";
					$query=mysql_query($sql);
				
			  ?>
                  <table width="100%"  border="0">
                    <tr bgcolor="#FFFFFF">
                      <td colspan="8"><div align="left"> Total Banner Count: <? echo $totalusers ?>.   &nbsp;&nbsp;Current Listing: <? echo mysql_num_rows($query);?> </div></td>
                    </tr>
                    <tr class="table_header">
                      <td width="2%" height="21"><div align="center"><strong><span>#</span></strong></div></td>
                      <td width="8%"><div align="center"><strong><span>Option</span></strong></div></td>
                      <td  ><div align="left"><strong><span >Page</span></strong></div></td>
                      <td  ><div align="left"><strong><span >Location</span></strong></div></td>
                      <td width="15%" ><div align="left"><strong><span >URL</span></strong></div></td>
                      <td width="15%" ><div align="left"><strong><span >Start Date</span></strong></div></td>
                      <td width="14%" ><div align="left"><strong><span >End Date</span></strong></div></td>
                      <td width="11%" ><span ><strong>Banner</strong> </span></td>
                      <td width="6%" ><span ><strong>Order</strong> </span></td>
					  <td width="6%" ><span ><strong>View</strong> </span></td>
                      <td width="6%" ><span ><strong>Hits</strong> </span></td>
                      <td width="6%"><span ><strong>Active</strong></span></td>
                    </tr>
                    <?php
					
					while($row=mysql_fetch_array($query))
					{
					 $sn++;
					 if ($sn > 50) break;
					 $id=$row['banner_id']; 
					 $col= $row['page'];	
					 $col0= $row['banner_location'];	
					 $col1=$row['url'];	
					 $col2=$row['start_date'];						 		 
					 $col3 = $row['end_date'];					
					 $col4 = "<a href='/upload/banners/".$row['image']."?$aj' class='thickbox'><img src='../upload/banners/".$row['image']."' width=50 height=25></a>";						
					 $col51 = $row['sort'];			
					 $col5 = $row['view'];					
					 $col6 = $row['hits'];				
					 $colLast=($row['active']==1)?'Yes':'No';
					 $status=($row['active']==1)?'0':'1';
					 $bgcolor=($sn % 2)?'row':'row1';
					
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=700&modal=false";
					 echo "<tr  class='$bgcolor'>
						<td ><div align='center'> $sn </div></td>
						<td><a href='updatebanner.php?id=$id$aj' class='thickbox' ><u>Edit</u></a> | <a href='managebanner.php?id=$id&del=y&fromdate=$todate&days=$days' onclick='return delconf();'><u>Delete</u></a></font></td>
						<td>$col</td>
						<td>$col0</td>
						<td>$col1</td>
						<td>$col2</td>
						<td>$col3</td>
						<td>$col4</td>
						<td>$col51</td>
						<td>$col5</td>
						<td>$col6</td>
						<td> <a href='managebanner.php?id=$id&active=$status&fromdate=$todate&days=$days'> $colLast </a></td>
						</tr> 
						<tr><td colspan=6></td></tr>";
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=11 align=center bgcolor=yellow> No data found </td></tr>";
				
				
				?>
                  </table></td>
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

</script>
<script>
  $(function() { 
	//$( "#fromdate" ).datepicker({ dateFormat: "yy-mm-dd" });
	//$( "#datepicker1" ).datepicker({ dateFormat: "yy-mm-dd" });
  });
  </script>
</body>
</html>

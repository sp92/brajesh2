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
			    $fgroupnameall='';
				$groupCode = get('groupName') ;
			    if ($groupCode  != "")
				{
					if ($groupCode=="StaticPages") $groupCode= $groupCode.$StoreId;
					$fgroupnameall=" and code_fld='".$groupCode ."'";
					$fgroupnameonly=$groupCode ;					
				}
			  
			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="delete from code_mstr where id= $id";
						$query1=mysql_query($sql);
						if ($query1) $msg =  "<br>Record Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update code_mstr set active = ".get("active")." where id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Record Updated...";
					}
				}
			
			
			$days=get("days");
			$todate =  get("fromdate");
			//if ($todate == "") $todate = date('Y-m-d');
			//if ($days=="") $days=0;
			
			 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=400&width=600&modal=false";
			  ?>
            <div class="my-account" >
              <div class="dashboard" >
                <div class="page-title" >
                  <div style="float: left;">
                    <h1>System Setting List</h1>
                  </div>
                  <div style="float: right;">
                    <form name="fgrpname" id="fgrpname" method="get"  action="">
                      <select name="groupName" onchange='fn_fgroup()' id="groupName" >
                        <option value="">--Select--</option>
                        <?php 
						$sql11="select DISTINCT code_fld from code_mstr  order by code_fld asc";
						$query11=mysql_query($sql11);
						while($grpName=mysql_fetch_array($query11))
						{
							if($grpName['code_fld']==$fgroupnameonly)
							$selecteda="selected";
							echo "<option value='".$grpName['code_fld']."' $selecteda>".$grpName['code_fld']."</option>";
							$selecteda='';
						}
					  ?>
                      </select>
                    </form>
                  </div>
                </div>
              </div>
              <div style="clear:both;"></div>
            </div>
            <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>	
            <table width="100%"  border="0" bgcolor="#D3D3D3">
              <tr>
                <td bgcolor="#FFFFFF"><a href='updatesystemsetting.php?id=0&groupName=<? echo $fgroupnameonly.$aj; ?>' class='thickbox' >Add New</a>
                  <?
			 	
				 	$sn =0;
						
					$sql="select count(*) from discountmaster";
					$query = mysql_query($sql);
					$row=mysql_fetch_array($query);
					$totalusers = $row[0];
					
					if ($StoreId != 0)
						$StoreSelect = " and code_desc5=$StoreId ";
					//echo $fgroupnameall;
					
					$sql="select * from code_mstr where 1=1 $fgroupnameall order by code_fld asc";
					$query=mysql_query($sql);
				
			  ?>
                  <table width="100%"  border="0">
                    <tr bgcolor="#FFFFFF">
                      <td colspan="8"><div align="left"> Total  Current Listing: <? echo mysql_num_rows($query);?> </div></td>
                    </tr>
                    <tr class="table_header">
                      <td width="2%" height="21"><div align="center"><strong><span>#</span></strong></div></td>
                      <td width="8%"><div align="center"><strong><span>Option</span></strong></div></td>
                      <td width="7%" ><div align="left"><strong><span >Group</span></strong></div></td>
                      <td width="11%" ><div align="left"><strong><span >Value</span></strong></div></td>
                      <td width="14%" ><div align="left"><strong><span >Description</span></strong></div></td>
                      <td width="11%" ><span ><strong>Description1</strong> </span></td>
                      <td width="11%" ><span ><strong>Description2</strong> </span></td>
                      <!-- <td width="11%" ><span ><strong>Description3</strong> </span></td>
  				  <td width="11%" ><span ><strong>Description4</strong> </span></td>
  				  <td width="11%" ><span ><strong>Description5</strong> </span></td>-->
                      <td width="6%"><span ><strong>Active</strong></span></td>
                    </tr>
                    <?php
					$nr = mysql_num_rows($query); // Get total of Num rows from the database query
					if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
						$pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
						//$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
					} else { // If the pn URL variable is not present force it to be value of page number 1
						$pn = 1;
					} 
					//This is where we set how many database items to show on each page 
					$itemsPerPage = 10; 
					// Get the value of the last page in the pagination result set
					$lastPage = ceil($nr / $itemsPerPage);
					// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
					if ($pn < 1) { // If it is less than 1
						$pn = 1; // force if to be 1
					} else if ($pn > $lastPage) { // if it is greater than $lastpage
						$pn = $lastPage; // force it to be $lastpage's value
					} 
					// This creates the numbers to click in between the next and back buttons
					// This section is explained well in the video that accompanies this script
					$centerPages = "";
					$sub1 = $pn - 1;
					$sub2 = $pn - 2;
					$add1 = $pn + 1;
					$add2 = $pn + 2;
					if ($pn == 1) {
						$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
						$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
					} else if ($pn == $lastPage) {
						$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
						$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
					} else if ($pn > 2 && $pn < ($lastPage - 1)) {
						$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
						$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
						$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
						$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
						$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
					} else if ($pn > 1 && $pn < $lastPage) {
						$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
						$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
						$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
					}
					// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
					$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage; 
					// Now we are going to run the same query as above but this time add $limit onto the end of the SQL syntax
					// $sql2 is what we will use to fuel our while loop statement below
					$sql2 = mysql_query("$sql $limit"); 
					//////////////////////////////// END Adam's Pagination Logic ////////////////////////////////////////////////////////////////////////////////
					///////////////////////////////////// Adam's Pagination Display Setup /////////////////////////////////////////////////////////////////////
					$paginationDisplay = ""; // Initialize the pagination output variable
					// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
					if ($lastPage != "1"){
						// This shows the user what page they are on, and the total number of pages
						$paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
						// If we are not on page 1 we can place the Back button
						if ($pn != 1) {
							$previous = $pn - 1;
							$paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $previous . '"> Back</a> ';
						} 
						// Lay in the clickable numbers display here between the Back and Next links
						$paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
						// If we are not on the very last page we can place the Next button
						if ($pn != $lastPage) {
							$nextPage = $pn + 1;
							$paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?groupName='.$fgroupnameonly.'&pn=' . $nextPage . '"> Next</a> ';
						} 
					}
					?>
                    <?php
					
					while($row=mysql_fetch_array($sql2))
					{
					 $sn++;
					 
					 $id=$row['id']; 
					 $col0= $row['code_fld'];	
					 $col1=$row['code_value'];
					 $col2=$row['code_desc'];
					 $col3=$row['code_desc1'];						 		 
					 $col4 = $row['code_desc2'];					
					 $col5 = $row['code_desc3'];					
					 $col6 = $row['code_desc4'];					
					 $col7 = $row['code_desc5'];					
					 $colLast=($row['active']==1)?'Yes':'No';
					 $status=($row['active']==1)?'0':'1';
					 $bgcolor=($sn % 2)?'row':'row1';
					
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=400&width=600&modal=false";
					 
					 if ($col0 == "StaticPages1" || $col0 == "StaticPages2" )
					 	$metaInfo = "| <a href='matainfo.php?group=$col0&location=$col1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=550&modal=false' class='thickbox' ><u>MetaInfo</u></a>";

					 
					 echo "<tr  class='$bgcolor'>
						<td ><div align='center'> $sn </div></td>
						<td><a href='updatesystemsetting.php?groupName=$col0&id=$id$aj' class='thickbox' ><u>Edit</u></a> $metaInfo
						| <a href='managesystemsetting.php?id=$id&del=y&fromdate=$todate&days=$days&groupName=$fgroupnameonly' onclick='return delconf();'><u>Delete</u></a></font></td>
						<td>$col0</td>
						<td>$col1</td>
						<td>$col2</td>
						<td>$col3</td>
						<td>$col4</td>
						<!--<td>$col5</td>
						<td>$col6</td>
						<td>$col7</td>-->
						<td> <a href='managesystemsetting.php?id=$id&active=$status&fromdate=$todate&days=$days&groupName=$fgroupnameonly'> $colLast </a></td>
						</tr> 
						<tr><td colspan=6></td></tr>";
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=9 align=center bgcolor=yellow> No data found </td></tr>";
				
				
				?>
                  </table></td>
              </tr >
              <tr>
                <td bgcolor="#E5E5E5">&nbsp;</td>
              </tr>
              <tr>
                <td><div style="margin-left:58px; margin-right:58px; padding:6px; background-color:#FFF; border:#999 1px solid;"><?php echo $paginationDisplay; ?></div></td>
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
	document.forms[0].target = (act=='users.php'?'':'new');
	document.forms[0].action = act;
	document.forms[0].action.submit();
}
function fn_fgroup()
	{		
		//alert("dfsdf");
		$("#fgrpname").submit();
		//location.href="exams.php?lang="+lang;
	}
</script>
</body>
</html>

<?php
session_start();
if($_SESSION['username']=="")
	header("location:index.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Main Screen</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><? include("top.php"); ?>
	
</td>
  </tr>
  <tr>
    <td style="padding-left:10px" >
	  <table width="99%"  border="0" cellspacing="0" cellpadding="3" >
      <tr>
        <td  align="center" valign="top">
		<? include("left.php"); ?>
		</td>
        <td >
		<?
			  $pagename =  basename($_SERVER['PHP_SELF']); 
			  $type = "O"; //$_REQUEST['type'];
			  $title = "Books";// $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="delete from products where prod_id= $id";
						$query1=mysql_query($sql);						
						$msg =  "<br>Book Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update products set prod_active = ".get("active")." where prod_id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Item Updated...";
					}
				}
			}
			 $cat_id =  get("cat_id");
			 $keyword =  get("keyword");
			 $fld =  get("area");
			 if ($fld=="") $fld="prod_code";
			 if ($cat_id =="") $cat_id ="";
			 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=600&width=950&modal=false";
			 
			 
			$filter = "cat_store=$StoreId ";		
			if ($cat_id > 0)
				$filter .= " and prod_cat = '$cat_id' "	;	
			if ($keyword != "" && $fld=="")
			{
				
				$filter = $filter ." and (prod_name_e like '%$keyword%' OR writer_e like '%$keyword%' OR prod_isbn like '%$keyword%' 
									OR prod_year like '%$keyword%' OR prod_code like '%$keyword%' )"	;					
			}
			if ($keyword != "" && $fld!="")
					$filter = $filter ." and $fld like '%$keyword%'";
					
			 $_SESSION["filter"] =	$filter;			
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
		 <form action="" method="get">
		   <strong>Category:</strong>
		    <select name="cat_id" id="cat_id" onChange="document.forms[1].submit()" class="select">
          <?
		    $sql = "select * from category where cat_store=$StoreId and cat_active=1 order by cat_title";
			$result = mysql_query($sql);
			echo "<option value=''>---Select---</option>";
			while($row=mysql_fetch_array($result))
			{
				echo "<option value='".$row["cat_id"]."' ". (($row["cat_id"]==$cat_id)?"selected":"") .">".$row["cat_title"]."</option>";
			}	
		  ?>
		  </select>
		    or/and Keyword:
		 
		    <input type="text" name="keyword" title="By: Title, ISBN, Writer, Book Code, Year" value="<? echo $keyword?>">
		    in
			<select name="area" id="area" class="select">
			 <?
		  	echo fn_ddl("ddlSearch", $fld);
		 	 ?>
			</select>
		    <input name="Search" type="submit" value="Search"> 
			<input name="button" type="button" value="Export Books" onClick="window.open('export/?for=Books-List','iFrame','')">
		  </form>
		  </div>
          <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href='updateproducts.php?id=0<? echo $aj; ?>' class='thickbox' ">Add New</a>
			 <?
				$sn =0;		
									
				$sql="select *, c.cat_title from products p left join category c on c.cat_id = p.prod_cat where  $filter order by prod_cat, prod_name_e, modify_date desc";
				$query=mysql_query($sql);					
				$num_rows = mysql_num_rows($query);				
			 ?>
			   | Total records <? echo $num_rows ?>.
			  <div class="scroll">
			  <table width="100%"  border="0" cellpadding="1" cellspacing="0" >
                <tr bgcolor="#FFFFFF">
                  <td colspan="7"><div align="left">
				  <span class="style3"><?php echo $print  ?></span></div></td>
                </tr>
                <tr class="table_header" >
                  <td width="2%" height="21"><div align="center"><strong><span >#</span></strong></div></td>
                  <td width="10%"><div align="center"><strong><span >Option</span></strong></div></td>
				  <td width="14%" ><div align="left"><strong><span >Category</span></strong></div></td>                  
                  <td width="25%"><span><strong>Book Code - Name </strong></span></td>
				  <td width="25%"><span><strong>Writer</strong></span></td>
                  <td  ><strong>Price</strong></td>                
                  <td width="5%"><span >Active</span></td>
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
					$itemsPerPage = 20; //$ItemPerPage=20;
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
				//if ($type != "")
				{						
					while($row=mysql_fetch_array($sql2))
					{
					 if ($sn == 50) break;
					 $sn += 1;
					 $id=$row['prod_id']; 
					 $cid=$row['prod_cat'];
					 $prod_group_id=$row['prod_group_id'];		
					 	
					 $col1= $row['cat_title'];	
					 $col2=  $row['prod_code'] . " - ". $row['prod_name_e'];						
					 $col3 = $row['writer_e'];
					 $col4 = $row['prod_rate'];
					 $colLast = ($row['prod_active']==1)?'Yes':'No';
					 $active = ($row['prod_active']==1)?'0':'1';
					 
					 $colLast = "<a href='$pagename?active=$active &id=$id'>$colLast</a>";
					 $bgcolor=($sn % 2)?'row':'row1'; 					 
					
					 echo "<tr class='$bgcolor' >
						<td class=ul><div align='center'> $sn </div></td>
						<td align=center>
						<a href='updateproducts.php?type=$type&t=$title&id=$id&gid=$prod_group_id$aj' class='thickbox' ><u>Edit</u></a>
						| <a href='matainfo.php?group=books&location=$id&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=550&modal=false' class='thickbox' ><u>MetaInfo</u></a>
						| <a href='manageproducts.php?t=$title&type=$type&id=$id&del=y' onclick='return delconf();'><u>Delete</u></a></font>
						
						</td>
						
						<td>$col1</td>
						<td>$col2</td>
						<td width=5%>$col3</td>
						<td width=5%>Rs.$col4/-</td>				
						<td> $colLast</td>
						</tr> 
						<tr bgcolor='white'><td colspan=8></td></tr>";
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=7 align=center bgcolor=yellow> No data found </td></tr>";
								
				?>
				
              </table>
			  </div>
			  <? 
			  }
			   ?>			  
			   </td>
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
    <td style="padding-top:5px">
	
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
function fm_submit()
{
	document.form.submit();
}
function fn_edit(id,issue,desc,act)
{
	document.getElementById("id").value = id;
	document.getElementById("issue").value = issue;
	document.getElementById("desc").value = desc;
	document.getElementById("active").checked = (act==1)?true:false;
}

function fn_statchat(id)
{
	var w= window.open('../chat/index.php?BookingId='+id,'Chat','width=700, height=500');
	w.focus();
}

</script>
</body>
</html>

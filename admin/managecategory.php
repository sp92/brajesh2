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
			  $title = "Category";// $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="select * from products where prod_cat in (select cat_id from category where cid= $id)";
						$result = mysql_query($sql);
						$num_rows = mysql_num_rows($result);
						if ($num_rows==0)
						{
							$sql="delete from category where cid= $id";
							$query1=mysql_query($sql);						
							$msg =  "<br>Category Deleted...";
						}
						else
							$msg =  "<br>Error: There are active items attached with this category. Hence category can't be deleted";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update category set cat_active = ".get("active")." where cid= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Category Updated...";
					}
				}
			}
		
				
			$days=get("days");
			$todate =  get("fromdate");
			if ($todate == "") $todate = date('Y-m-d');
			if ($days=="") $days=0;
			 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=400&width=600&modal=false";
			 $_SESSION["filter"] = "";
			?>
		
		
		<div class="my-account" >
		  <div class="dashboard" >
			<div class="page-title" >
			  <h1><? echo $title ?>  List</h1>
			</div>
		  </div>
		</div>
         <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>	
		 <input name="button" type="button" value="Export Category" onClick="window.open('export/?for=Category-List','iFrame','')">
		 <!-- <form action="" method="get">
		   <strong>From:		   </strong>
		   <input name="fromdate" type="text" id="fromdate" value="<? echo $todate?>" size="10" maxlength="10">(YYYY-mm-dd)  
		   <strong>to Last		   </strong>
		   <input name="days" type="text" id="days" size="2" maxlength="2"  value="<?echo $days ?>"> 
		   <strong>Days</strong> 
		   <input name="Search" type="submit" value="Search">-->
          <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href='updatecategory.php?id=0<? echo $aj; ?>' class='thickbox' ">Add New</a>
			  <?
			
				 	$sn =0;
					$_SESSION['type'] = $type;
					$_SESSION["lang"] = $lang;
					
					$fromdate =  date('Y-m-d', strtotime($todate) - ($days * 60 * 60 * 24)); 
					$qdt = " and O.order_date >= '$fromdate 00:00:00' and O.order_date <= '$todate 23:59:59'";						
										
					$sql="select * from category where cat_store = $StoreId order by cat_title ";
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
				  <td width="14%" ><div align="left"><strong><span >Group Category Id </span></strong></div></td>                  
                  <td width="25%"><span><strong>Category Name </strong></span></td>
                  <td  ><strong>Sort Order </strong></td>                
                  <td width="5%"><span >Active</span></td>
                </tr>
							
				<?php
				if ($type != "")
				{	
				
					while($row=mysql_fetch_array($query))
					{
					 $sn += 1;
					 $id=$row['cid']; 
					 $col1=$row['cat_group_id'];	
					 $col2=$row['cat_title'];						
					 $col3 = $row['cat_seq'];
					 //$col4 = $row['total_amount'];
					 $colLast = ($row['cat_active']==1)?'Yes':'No';
					 $active = ($row['cat_active']==1)?'0':'1';
					 $colLast = "<a href='$pagename?active=$active &id=$id'>$colLast</a>";
					 $bgcolor=($sn % 2)?'row':'row1'; 					 
					
					 echo "<tr class='$bgcolor' >
						<td class=ul><div align='center'> $sn </div></td>
						<td align=center><a href='updatecategory.php?type=$type&t=$title&id=$id&gid=$col1$aj' class='thickbox' ><u>Edit</u></a></font> 
						| <a href='matainfo.php?group=category&location=$col1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=550&modal=false' class='thickbox' ><u>MetaInfo</u></a>
						| <a href='$pagename?t=$title&type=$type&id=$id&del=y' onclick='return delconf();'><u>Remove</u></a></font></td>
						
						<td>$col1</td>
						<td>$col2</td>
						<td width=5%>$col3</td>
										
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

</body>
</html>

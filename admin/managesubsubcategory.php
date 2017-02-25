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
			  $title = "Sub Sub Category";// $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$cid = $_REQUEST["cid"];
						$sql="select * from products where cat_id=$cid  and prod_subcat in (select subcat_id from sub_subcategory where sub_sid= $id)";
						$result = mysql_query($sql);
						$num_rows = mysql_num_rows($result);
						if ($num_rows==0)
						{
							$sql="delete from sub_subcategory where sub_sid= $id";
							$query1=mysql_query($sql);						
							$msg =  "<br>Sub Sub Category Deleted...";
						}
						else
							$msg =  "<br>Error: There are active items attached with this sub sub category. Hence sub sub category can't be deleted";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update sub_subcategory set sub_subcat_active = ".get("active")." where sub_sid= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Sub Sub Category Updated...";
					}
				}
			}
		
				
			$days=get("days");
			$todate =  get("fromdate");
			if ($todate == "") $todate = date('Y-m-d');
			if ($days=="") $days=0;
			$aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=400&width=600&modal=false";
			?>
		
		
		<div class="my-account" >
		  <div class="dashboard" >
			<div class="page-title" >
			  <h1><? echo $title ?>  List</h1>
			</div>
		  </div>
		</div>
         <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>		
		 <input name="button" type="button" value="Export Sub Sub Category" onClick="window.open('export/?for=SubSubCategory-List','iFrame','')">
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
			  <a href='updatesubsubcategory.php?id=0<? echo $aj; ?>' class='thickbox' ">Add New</a>
			 <?
				$sn =0;
				$_SESSION['type'] = $type;
				$_SESSION["lang"] = $lang;
				
				$fromdate =  date('Y-m-d', strtotime($todate) - ($days * 60 * 60 * 24)); 
				$qdt = " and O.order_date >= '$fromdate 00:00:00' and O.order_date <= '$todate 23:59:59'";						
									
				//$sql="select *, c.cat_title from category c join sub_subcategory ss on c.cat_id = ss.cat_id order by ss.sub_sid DESC";
				$sql="select *, c.cat_title from category c join sub_subcategory ss on c.cat_id = ss.cat_id join subcategory s on  ss.cat_id = s.cat_id  and ss.subcat_id = s.subcat_id order by ss.sub_sid DESC";
				//$sql="select * from category c join subcategory s on c.cat_id = s.cat_id left join sub_subcategory ss 
				//on  ss.subcat_id= s.subcat_id order by sub_sid DESC";
			
			//$sql="select *, c.cat_title from news p join category c on c.cat_id = p.news_cat 
			//left join subcategory sc on  sc.subcat_id= c.cat_id and p.news_subcat = sc.subcat_id where  
			//news_id=$row_id";
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
				  <td width="14%" ><div align="left"><strong><span >Group Category Id</span></strong></div></td>                  
                  <td width="20%"><span><strong>Category Name </strong></span></td>
				  <td width="20%"><span><strong>Sub Category Name </strong></span></td>
				  <td width="20%"><span><strong>Sub Sub Category Name </strong></span></td>
                  <td  ><strong>Sort Order </strong></td>                
                  <td width="5%"><span >Active</span></td>
                </tr>
							
				<?php
				if ($type != "")
				{						
					while($row=mysql_fetch_array($query))
					{
					 $sn += 1;
					 $id=$row['sub_sid']; 
					 $cid=$row['cat_id'];		
					 $col1=$row['subcat_id'];	
					 $col2=$row['cat_title'];
					 $colg=$row['cat_group_id'];						
					 $col3 = $row['subcat_title'];
					 $col3s = $row['sub_subcat_title'];
					 $col4 = $row['sub_subcat_seq'];
					 $colLast = ($row['sub_subcat_active']==1)?'Yes':'No';
					 $active = ($row['sub_subcat_active']==1)?'0':'1';
					 
					 $colLast = "<a href='$pagename?active=$active &id=$id'>$colLast</a>";
					 $bgcolor=($sn % 2)?'row':'row1'; 					 
					
					 echo "<tr class='$bgcolor' >
						<td class=ul><div align='center'> $sn </div></td>
						<td align=center><a href='updatesubsubcategory.php?type=$type&t=$title&id=$id&gid=$colg$aj' class='thickbox' ><u>Edit</u></a>
						  | <a href='matainfo.php?group=subcategory&location=$col1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=550&modal=false' class='thickbox' ><u>MetaInfo</u></a>
						 | <a href='$pagename?t=$title&cid=$cid&id=$id&del=y' onclick='return delconf();'><u>Remove</u></a></font></td>
						
						<td>$colg</td>
						<td>$col2</td>
						<td width=5%>$col3</td>
						<td width=5%>$col3s</td>
						<td width=5%>$col4</td>				
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

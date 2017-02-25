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
			  $title = "Bookstores";// $_REQUEST['t'];

			  {			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");						
						$sql="delete from bookstores where id= $id";
						$query1=mysql_query($sql);						
						$msg =  "<br>Bookstore Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update bookstores set active = ".get("active")." where id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Book store updated...";
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
		 <!-- <form action="" method="get">
		   <strong>From:		   </strong>
		   <input name="fromdate" type="text" id="fromdate" value="<? echo $todate?>" size="10" maxlength="10">(YYYY-mm-dd)  
		   <strong>to Last		   </strong>
		   <input name="days" type="text" id="days" size="2" maxlength="2"  value="<?echo $days ?>"> 
		   <strong>Days</strong> 
		   <input name="Search" type="submit" value="Search">-->
          <input name="button" type="button" value="Export Dealers" onClick="window.open('export/?for=Dealers-List','iFrame','')">
          <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href='updatedealers.php?id=0<? echo $aj; ?>' class='thickbox' ">Add New</a>
			  <?
				 	$sn =0;
					$fromdate =  date('Y-m-d', strtotime($todate) - ($days * 60 * 60 * 24)); 
					$qdt = " and O.order_date >= '$fromdate 00:00:00' and O.order_date <= '$todate 23:59:59'";						
										
					$sql="select * from bookstores order by city, store_name ";
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
                  <td width="10%" align="left"><strong><span >Option</span></strong></td>
				  <td width="55%" align="left" ><span><strong>Bookstore Name</strong></span></td>                  
                  <td width="14%" align="left"><strong>City</strong></td>
                  <td width="14%"  ><strong>State</strong></td>                
                  <td width="5%"><strong>Active</strong></td>
                </tr>
							
				<?php
				if ($type != "")
				{	
				
					while($row=mysql_fetch_array($query))
					{
					 $sn += 1;
					 $id=$row['id']; 
					 $col1=$row['store_name'];	
					 $col2=$row['city'];						
					 $col3 = $row['state'];
					 //$col4 = $row['total_amount'];
					 $colLast = ($row['active']==1)?'Yes':'No';
					 $active = ($row['active']==1)?'0':'1';
					 $colLast = "<a href='$pagename?active=$active &id=$id'>$colLast</a>";
					 $bgcolor=($sn % 2)?'row':'row1'; 					 
					
					 echo "<tr class='$bgcolor' >
						<td class=ul><div align='center'> $sn </div></td>
						<td align=center><a href='updatedealers.php?type=$type&t=$title&id=$id$aj' class='thickbox' ><u>Edit</u></a></font> | <a href='$pagename?t=$title&type=$type&id=$id&del=y' onclick='return delconf();'><u>Remove</u></a></font></td>
						
						<td>$col1</td>
						<td>$col2</td>
						<td>$col3</td>
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

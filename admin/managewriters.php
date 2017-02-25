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
			  $title = "Writers";// $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="select * from products where writer in (select writer_code from writer_det where wid = $id)";
						$result = mysql_query($sql);
						$num_rows = mysql_num_rows($result);
						if ($num_rows==0)
						{
							$sql="delete from writer_det where wid= $id";
							$query1=mysql_query($sql);						
							$msg =  "<br>Writer Deleted...";
						}
						else
							$msg =  "<br>Error: There are active items attached with writer. Hence writer can't be deleted";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update writer_det set active = ".get("active")." where wid= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Writer Updated...";
					}
				}
			}
		
				
			$keyword =  get("keyword");
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
		<div class="filter">
		 <strong>Search By:</strong><br>
		 <form action="" method="get">
		   Writer Name:
		    <input type="text" name="keyword" title="Writer name" value="<? echo $keyword?>">
		    <input name="Search" type="submit" value="Search">
		  </form>
		  </div>
          <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href='updatewriter.php?id=0<? echo $aj; ?>' class='thickbox' ">Add New</a>
			  <?
			
				 	$sn =0;
				
					
				if ($keyword != "")
					$filter = $filter ." where (writer_name like '%$keyword%')"	;								
										
					$sql="select * from writer_det $filter order by writer_name ";
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
                  <td width="5%"><div align="center"><strong><span >Option</span></strong></div></td>
				  <td width="4%" ><div align="left"><strong><span >Writer Id </span></strong></div></td>                  
                  <td width="25%"><span><strong>Writer Name </strong></span></td>
                  <td width="25%" ><strong>Name (Hindi) </strong></td>                
                  <td width="5%"><span >Active</span></td>
                </tr>
							
				<?php
				if ($type != "")
				{	
				
					while($row=mysql_fetch_array($query))
					{
					 $sn += 1;
					 $id=$row['wid']; 
					 $col1=$row['writer_code'];	
					 $col2=$row['writer_name'];						
					 $col3 = $row['writer_name_h'];
					 //$col4 = $row['total_amount'];
					 $colLast = ($row['active']==1)?'Yes':'No';
					 $active = ($row['active']==1)?'0':'1';
					 $colLast = "<a href='$pagename?active=$active &id=$id'>$colLast</a>";
					 $bgcolor=($sn % 2)?'row':'row1'; 					 
					
					 echo "<tr class='$bgcolor' >
						<td class=ul><div align='center'> $sn </div></td>
						<td align=center><a href='updatewriter.php?type=$type&t=$title&id=$id$aj' class='thickbox' ><u>Edit</u></a></font> | <a href='$pagename?t=$title&type=$type&id=$id&del=y' onclick='return delconf();'><u>Remove</u></a></font></td>
						
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

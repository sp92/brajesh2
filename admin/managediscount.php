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
   <td style="padding-left:10px" >
	<table width="99%"  border="0" cellspacing="0" cellpadding="3">
      <tr>
         <td  align="center" valign="top">
		<? include("left.php"); ?>
		</td>
        <td >
		<?
			  
			
			  
			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="delete from discountmaster where d_id= $id";
						$query1=mysql_query($sql);
						if ($query1) $msg =  "<br>Record Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update discountmaster set active = ".get("active")." where d_id= $id";
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
			  <h1>Discount List</h1>
			</div>
		  </div>
		</div>
        <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>	
		 
		  
		   <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			   <a href='updatediscount.php?id=0&<? echo $aj; ?>' class='thickbox' ">Add Discount</a>
			  <?
			 	
				 	$sn =0;
					$sql="select count(*) from discountmaster where store_id=$StoreId";
					$query = mysql_query($sql);
					$row=mysql_fetch_array($query);
					$totalusers = $row[0];
					
					$sql="select * from discountmaster  where store_id=$StoreId order by discount_type, start_date desc, end_date ";
					$query=mysql_query($sql);
				
			  ?>
			  <table width="100%"  border="0">
                <tr bgcolor="#FFFFFF">
                  <td colspan="8"><div align="left">
				 Total Discount Current Listing: <? echo mysql_num_rows($query);?>
				 </div></td>
                  </tr>
                <tr class="table_header">
                  <td width="2%" height="21"><div align="center"><strong><span>#</span></strong></div></td>
                  <td width="8%"><div align="center"><strong><span>Option</span></strong></div></td>
				  <td width="7%" ><div align="left"><strong><span >Type</span></strong></div></td>  
				  <td width="45%" ><div align="left"><strong><span >Name</span></strong></div></td>                  
				  <td width="14%" ><div align="left"><strong><span >Between</span></strong></div></td>                  
  				  <td width="11%" ><span ><strong>Calculation</strong> </span></td>
  				  <td width="11%" ><span ><strong>Discount</strong> </span></td>
                  <td width="6%"><span ><strong>Active</strong></span></td>
                </tr>
				<?php
					
					while($row=mysql_fetch_array($query))
					{
					 $sn++;
					 
					 $id=$row['d_id']; 
					 $col0= $row['discount_type'];	
					 $col1=$row['discount_items'];
					 $tab='';
					 $id1='';
					 $name='';
					 $nameItem='';
					if($col0=='Category'){
					 $tab='category';
					 $id1='cat_id';
					 $name='cat_title';
					 }
					 else if($col0=='Sub Category'){
					 $tab='subcategory';
					 $id1='subcat_id';
					 $name='subcat_title';
					 }
					  else if($col0=='Publisher')
					  {
					 $tab='publisher';
					 $id1='publisher_code';
					 $name='publisher_name';
					 }
					  else if($col0=='Book')
					  {
						$tab='products';
						$id1='prod_code';
						$name='prod_name_e';
						}
					  else if($col0=='Traders')
					  {
					 $tab='subcategory';
					 $id1='subcat_id';
					 $name='subcat_title';
					 }

					if($col0!='Coupon')
					{
						$discountItems = explode(",", $row['discount_items']);					
						foreach ($discountItems as $value) {
							$sql_cat = mysql_query("select * from $tab where $id1='". trim($value) ."'");
							$data_cat=mysql_fetch_array($sql_cat);
							$nameItem .=$data_cat[$name].', ';
						 } 
					 }
					 else
					 	$nameItem = "<a href='orders.php?coup=". $row['discount_items'] . "' title='Click to check orders against this coupon'>". $row['discount_items']."</a> (Max. use: ". $row['discount_coup_max'] .")" ;
					
					 $nameItem = trim($nameItem,", ");	
					 $col2=$row['start_date'].' to '.$row['end_date'];						 		 
					 $col3 = $row['discount_calc'];					
					 $col4 = $row['discount_value'];					
					 $colLast=($row['active']==1)?'Yes':'No';
					 $status=($row['active']==1)?'0':'1';
					 $bgcolor=($sn % 2)?'row':'row1';
					
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=400&width=600&modal=false";
					 echo "<tr  class='$bgcolor'>
						<td ><div align='center'> $sn </div></td>
						<td><a href='managediscount.php?id=$id&del=y' onclick='return delconf();'><u>Delete</u></a></font></td>
						<td>$col0</td>
						<td><strong>$col0: </strong>$nameItem</td>
						<td>$col2</td>
						<td>$col3</td>
						<td>$col4</td>
						<td> <a href='managediscount.php?id=$id&active=$status&fromdate=$todate&days=$days'> $colLast </a></td>
						</tr> 
						<tr><td colspan=6></td></tr>";
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=9 align=center bgcolor=yellow> No data found </td></tr>";
				
				
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

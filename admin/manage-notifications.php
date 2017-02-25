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
			  
			  $type = "U"; //$_REQUEST['type'];
			  $title = "Notification ";// $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {
			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						$sql="delete from notification where id= $id";
						$query1=mysql_query($sql);
						if ($query1) $msg =  "<br>Record Deleted...";
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update notification set active = ".get("active")." where id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Record Updated...";
					}
				}
			}
			
			$enddate=get("enddate");
			$fromdate =  get("fromdate");
			$fldName = get("reg_type");
			$kw = get("kw");
			if ($fromdate == "") $fromdate = date('Y-m-d');
			if ($enddate=="") $enddate= date('Y-m-d');
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
		   <strong>Type:		   </strong>
		   <select id="reg_type" name="reg_type" >
		    <option value="">--All--</option>
		   	<option value="NL"  <? echo ($fldName=="NL")?"selected":"" ?> >Newsletter</option>
			<option value="Book"  <? echo ($fldName=="Book")?"selected":"" ?> >Books</option>
		   </select>
		    
		   <strong>From:		   </strong>
		   <input name="fromdate" type="date" id="fromdate" value="<? echo $fromdate?>" size="10"  maxlength="10">
		   <strong>to 		   </strong>
		   <input name="enddate" type="date" id="enddate"  value="<? echo $enddate?>">
		   
		   <input name="Search" type="submit" value="Search" onclick="//fn_get('managereview.php')">
		   <input name="button" type="button" value="Export Filtered Results" onClick="window.open('export/?for=Notification','iFrame','')">
		   </form>
		   </div>
		  
		   <table width="100%"  border="0" bgcolor="#D3D3D3">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href="managequestions.php?type=<? echo $type;?>&t=<? echo $title;?>"></a>
			  <?
			  if ($type != "")
				{	
				 	$sn =0;
					$qdt = " and `reg_type` like '%$fldName%'";	
					$qdt .= " and `created_date` between '$fromdate 00:00:01' and '$enddate 23:59:59'";		
					
					
					$sql="select count(*) from notification ";
					$query = mysql_query($sql);
					$row=mysql_fetch_array($query);
					$totalusers = $row[0];
					
					$sql="select 
						  case when reg_type='NL' then
						  		'Newsletter'
								else
								  (select concat(prod_code,'-',prod_name_e) from products where prod_id =  replace(reg_type,'Book|',''))
								end as 'reg_type',
						   name, email, created_date
						  from notification where 1=1 $qdt order by reg_type ";
					$query=mysql_query($sql);
					$_SESSION["filter"] = $qdt;
				}
			  ?>
			  <table width="100%"  border="0">
                <tr bgcolor="#FFFFFF">
                  <td colspan="7"><div align="left">
				 Total notification count: <? echo $totalusers ?>.   &nbsp;&nbsp;Current Listing: <? echo mysql_num_rows($query);?>
				 </div></td>
                  </tr>
                <tr class="table_header">
                  <td width="2%" height="21"><div align="center"><strong><span>#</span></strong></div></td>
				  <td ><div align="left"><strong><span >Type</span></strong></div></td>  
				  <td width="30%" ><div align="left"><strong>Name</strong></div></td>                  
                  <td width="30%" ><div align="left"><strong><span >Email</span></strong></div></td>                
				  <td width="10%"><span ><strong>Created Date</strong></span></td>
                  </tr>
				<?php
				if ($type != "")
				{	
					while($row=mysql_fetch_array($query))
					{
					 $sn++;
					 
					 $col0= $row['reg_type'];	
					 /*
					 if ($col0=="NL") 
					 	$col0="Newsletter";
					 else
					 {
					 	$prod_id = str_replace("Book|","",$col0); 
					 	$col0=getValue("select prod_name_e from products where prod_id = $prod_id ");
					 }
					 */
					 $col1=$row['name'];	
					 $col2=$row['email'];						 		 
					 $col3 = $row['created_date'];					
					 $bgcolor=($sn % 2)?'row':'row1';
					
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=700&modal=false";
					 echo "<tr  class='$bgcolor'>
						<td ><div align='center'> $sn </div></td>
						<td>$col0</td>
						<td>$col1</td>
						<td>$col2</td>
						<td>$col3</td>
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

function fn_get(act)
{
	document.forms[0].target = (act=='users.php'?'':'new');
	document.forms[0].action = act;
	document.forms[0].action.submit();
}
</script>
</body>
</html>

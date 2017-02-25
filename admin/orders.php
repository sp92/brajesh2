<?php
session_start();
if($_SESSION['username']=="")
	header("location:index.php");
?>
<!doctype html>
<html lang="us">

<head>
<title>Main Screen</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
		<? include("left.php"); ?>		</td>
        <td >
		<?
			  $type = "O"; //$_REQUEST['type'];
			  $title = "Orders";// $_REQUEST['t'];
			  if ($type == "") 
			  	 $msg ="Please select Code Field"; 
			  else
			  {			  	
			  	if (get("del") == "y")
				{
					if (get("id") != "")
					{
						$id = get("id");
						update_order($id, "", "", "Cancel");
					}
				}
				
				if (get("active")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update orders set order_can = now() where order_id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Record #$id Updated...";
					}
				}
				
				if (get("payment")!= "")
				{			
					if (get("id") != "")
					{
						$id = get("id");
						$sql="update orders set order_action = ".get("payment")." where order_id= $id";
						$query1=mysql_query($sql);
						if ($query1)  $msg = "<br>Record #$id Payment Status Updated...";
					}
				}
			}
			$order_status = get('order_status');
			$coup=get("coup");
			$enddate=get("enddate");
			$fromdate =  get("fromdate");
			$fldName = get("fldName");
			$kw = get("kw");
			if ($fromdate == "") $fromdate = date('Y-m-d');
			if ($enddate=="") $enddate= date('Y-m-d');
			
			if (get("del")=="y")
				$qdt=$_SESSION["filter"];
			else
			{	
				if ($coup!="")
				{
					$qdt = $qdt. " and discount_code = '$coup' ";
					$print = "- Coupon $coup : Orders List";
				}
				else
				{
								
					if ($kw!="")
					{
						$qdt = $qdt. " and $fldName like '%$kw%' ";
					}
					else
						$qdt = " and o_active=1 and o.order_date between '$fromdate 00:00:01' and '$enddate 23:59:59'";	
						
					if ($order_status == "CC")
						$qdt .= " and pay_mode = 'CC' and payment_date <> ''";
					else if ($order_status != "")
						$qdt .= " and order_action = $order_status ";
				}
				$_SESSION["filter"] =	$qdt;
			}
			
			
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
		   <strong> In:</strong>
		   <select name="fldName">
		  <!-- <option value="">--Select--</option>-->
		   <option value="o.order_id" <? echo ($fldName=="o.order_id")?"selected":"" ?> >Order Number</option>
		   <option value="o.order_status" <? echo ($fldName=="o.order_status")?"selected":"" ?>>Order Status</option>
		   <option value="a.name" <? echo ($fldName=="a.name")?"selected":"" ?>>Buyer Name</option>
		   <option value="a.email" <? echo ($fldName=="a.email")?"selected":"" ?>>Buyer Email</option>
		   </select>
		   <input name="kw" type="text" id="kw" value="<? echo $kw?>" size="30"  >
		   <strong> Order Status: </strong>
		   <select name="order_status">
              <? echo fn_ddl("OrderStatus", $order_status)?>
           </select>
		   <br>
		   <strong>From:		   </strong>
		   <input name="fromdate" type="date" id="fromdate" value="<? echo $fromdate?>" size="10"  maxlength="10">
		   <strong>to 		   </strong>
		   <input name="enddate" type="date" id="enddate"  value="<? echo $enddate?>">
		   <input name="Search" type="submit" value="Search">
		   <input name="button2" type="button" value="Export Orders for Staus Update" onClick="window.open('export/?for=Orders-Status-List','iFrame','')">
		   <input name="button" type="button" value="Export Filtered Results" onClick="window.open('export/?for=Orders-List','iFrame','')">
		  </form>
		  </div>
		  <br>
          <table width="100%"  border="0">
            <tr>
              <td bgcolor="#FFFFFF">
			  <a href="managequestions.php?type=<? echo $type;?>&t=<? echo $title;?>"></a>
			  
			  <table width="100%"  border="0" cellpadding="1" cellspacing="0" >
                <tr bgcolor="#FFFFFF">
                  <td colspan="7"><div align="left">
				 
				  <span class="style3"><?php echo $print  ?></span></div></td>
                  </tr>
                <tr bgcolor="#A9A9A9" >
                  <td width="2%" height="21"><div align="center"><strong><span class="style16 style2">#</span></strong></div></td>
                  <td width="10%"><div align="center"><strong><span class="style16 style2">Option</span></strong></div></td>
				  <td width="14%" ><div align="left"><strong><span class="style16 style2">Order Date</span></strong></div></td>                  
                  <td width="15%" ><span class="style4">Customer</span></td>
                  <td ><span class="style4">Email</span></td>
                  <td width="5%"><span class="style4">Payment Type</span></td>
				  <td width="5%"><span class="style4">Status</span></td>
				  <td width="10%"><span class="style4">Order Amount</span></td>
                  <td width="20%"><span class="style4">Status</span></td>
                </tr>
								
				<?php
				if ($type != "")
				{	
				 	$sn =0;					
					
					if ($StoreId > 0) 	$qdt .= " and label= '".(($StoreId==1)?'WFAS':'') ."'";
						
					$sql="select * from orders o, address a where a.aid =o.user_aid $qdt order by order_id desc";
					$query=mysql_query($sql);
				
					while($row=mysql_fetch_array($query))
					{
					 $sn += 1;
					 $id=$row['order_id']; 
					 $col1=$row['order_date'];	
					 $col2=$row['name'];
					 $label=$row['label'];	
					 //$class = ($col2=="E")?"eng":"hn";				 
					 $PayMode = $row['pay_mode'];	
					 
					 //$status=($row['OActive']==1)?'0':'1';
					 $payment=($row['order_action']==4)?'5':'4';
					 $col3 = $row['email'];
					 $col6 = "Rs. ".$row['total_amount'];
					 $col4 = $PayMode;
					 $col5 =  "<a href='orders.php?id=$id&payment=$payment&fromdate=$todate&days=$days' onclick='fm_submit()'>". (($row['order_action']==5 || $row['order_action']==6)?"<b>Revd.</b>":"Pending") ."</a>";
					 //$code_desc2 = $row['code_desc2'];
					 $bgcolor = ($row['pay_id']=="1")?"#FEF7ED":"#F5FCF5";
					 //$inactive=($row['OActive']==1)?'black':'lightgray';
					 $colLast= $row['order_status']; //($row['OActive']==1)?'Yes':'No';
					 
					 //$aj = "&height=420&width=700";
					 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=600&width=800&modal=false";
					 echo "<tr valign='top' height=20 class=ol bgcolor='$bgcolor' style='color:$inactive; vertical-align:center'>
						<td class=ul><div align='center'> $sn </div></td>
						<td><a href='manageorders.php?type=$type&t=$title&oid=$id$aj' class='thickbox' ><u>$label/$id</u></a>";
						//if (!($row['pay_id']==3 && $row['order_action']==5))						
							echo "| <a href='orders.php?t=$title&type=$type&id=$id&del=y' onclick='return delconf();'><u>Cancel</u></a>
								| <a href='manageorders.php?type=print&t=$title&oid=$id' target='_new'><u>Print</u></a>
								
								";
						
					echo "</td>
						
						<td>$col1</td>
						<td>$col2</td>
						<td class=$class>$col3</td>
						<td class=$class>$col4</td>
						<td class=$class>$col5</td>
						<td class=$class>$col6</td>
						<td> $colLast</td>
						</tr> 
						<tr bgcolor='white'><td colspan=8></td></tr>";
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=8 align=center bgcolor=yellow> No data found </td></tr>";
								
				?>
              </table>
			  <? 
			  }
			   ?>			  </td>
            </tr>
          </table>
          </form>        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<br>
	<? include("bottam.php"); ?></td>
  </tr>
</table>
<script>
function delconf()
{
	if (!confirm('Are you sure to Cancel !'))
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

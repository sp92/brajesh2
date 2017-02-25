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
		<? include("left.php"); ?>		</td>
        <td >
		<?
			$msg="";
			$type = "O"; //$_REQUEST['type'];
			$title = "Orders Staus";// $_REQUEST['t'];
			$order_status = get('order_status');
			if (get("Update") == "Update")
			{
				if ($order_status==4) $ostatus="PaymentPending";
				if ($order_status==5) $ostatus="PaymentReceived";
				if ($order_status==6) $ostatus="Complete";
				if ($order_status==7) $ostatus="Cancel";
				
				$msg = update_order(get("order_id"), get("shiped"), get("referance"), $ostatus);
				if ($order_status==6)
					sms_status(get("order_id"));
			}
			
			if (get("Bulk") == "Bulk Update")
			{
				$orders = get("orders_info");
				$orders  = str_replace("	",",",$orders );
				if ($orders!="")
				{
					$order_rows = explode("\r\n",$orders);
					foreach ($order_rows as $rows)
					{
						$cols = explode(",", $rows);
						$msg = update_order($cols[0], $cols[1], $cols[2], "Complete");
						sms_status($cols[0]);
					}					
				}
			}
			
			function sms_status($order_id)
			{
				$sql = "select * from orders o join address a on aid=user_aid where order_id='$order_id'";
				$prod_arr = mysql_query($sql);
				while($row1=mysql_fetch_array($prod_arr))
				{
					$amt = $row1["total_amount"];
					$name = $row1['name'];
					$mobile = trim($row1['mobile']);
					if ($row1['label']=='UP')
						$sms = "Order no. $order_id is dispatched. You may view status at www.upkar.in. We appreciate your business and look forward to serve again. Upkar Prakashan";
					else
						$sms = "Order no. $order_id is dispatched. You may view status at www.pdgroup.in. We appreciate your business and look forward to serve again.Pratiyogita darpan";

					echo SendSMS($mobile, $sms);
				}
			}
			
			?>
		
		<div class="my-account" >
		  <div class="dashboard" >
			<div class="page-title" >
			  <h1><? echo $title ?>  Update</h1>
			</div>
		  </div>
		</div>
        <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo  $msg; ?></div>	
		 <div class="filter"></div>
		  <br>
          <table width="100%"  border="0">
            <tr>
              <td bgcolor="#FFFFFF">
                <table width="100%%" height="87" border="0">
                  <tr>
                    <td width="37%" valign="top"><strong>Update Single Order 
                      </strong>
					  <form name="form1" method="post" action="">
                      <table width="100%%" border="0">
                        <tr>
                          <td>Order Status </td>
                          <td><select name="order_status" id="order_status" onChange="fn_show()" >
                            <? echo fn_ddl("OrderStatus", '$order_status')?>
                          </select></td>
                        </tr>
                        <tr>
                          <td width="27%">Order#</td>
                          <td width="73%"><input type="number" name="order_id" id="order_id" required onBlur="fn_getOrderTrail($('#order_id').val())"></td>
                        </tr>
						
                        <tr class="shipping"  >
                          <td>Shiped Via </td>
                          <td> <select name="shiped" id="shiped" >
								<? echo fn_ddl("ShippingOpt", ''); ?>
							  </select></td>
                        </tr>
                        <tr class="shipping" >
                          <td>Referance#</td>
                          <td><input type="text" name="referance" ></td>
                        </tr>
						
                        <tr>
                          <td>&nbsp;</td>
                          <td><input name="Update" type="submit" id="Update" value="Update"></td>
                        </tr>
                      </table>
					  </form>
					  <div id="orderStatus"></div>
					  </td>
                    <td width="63%" valign="top"><strong>Bulk Order Shipping Update</strong><br> 
						<form name="form1" method="post" action="">
                      <textarea name="orders_info" cols="100%" rows="15"></textarea>
                      <br>
                      Example: order#, shipped via, referance
                      <br>
                      <input name="Bulk" type="submit" id="Bulk" value="Bulk Update">
					   </form>
					  </td>
                  </tr>
                </table>
                           
             </td>
            </tr>
          </table>
                 </td>
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
$('.shipping').hide();
$('#order_status').val('6');
function fn_show()
{
	$('.shipping').hide();
	if ($('#order_status').val() == '6')
		$('.shipping').show();
}
fn_show();
</script>
</body>
</html>

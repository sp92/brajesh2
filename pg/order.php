<?
$userid=$_SESSION['mem_id'];
if ($userid=="")
{
	$_SESSION["url"] = 'order';
	echo "<script>location.href='onlinetest/member/registration.php?url=order'</script>";
}
//if ($content=="Order")
{
	if (isset($_REQUEST['osubmit']))
	{		
		$payamttype = $_REQUEST['PaymentType'];	
		if ($payamttype!="")
		{
			$payamt = $_REQUEST['payamt'];
			$delcharge = $_REQUEST['delcharge'];
			$comments = str_replace("'","`",$_REQUEST['comments']);
			
			if ($_SESSION['cart'] != null)
			{
				$sql = "INSERT INTO `orders` (`oid`, `mid`, `odate`, `oamount`) VALUES (NULL, '$userid', '$now', '$payamt');";
				$det_arr = mysql_query($sql);
				$oid = 0;
				$sql = "SELECT oid from orders order by oid desc limit 1";
				$det_arr = mysql_query($sql);
				while($row=mysql_fetch_array($det_arr))
				{
					$oid = $row[0];
					$_SESSION['oid'] = $oid;
					$sql = "Select * from paper_group where gid in (". rtrim($_SESSION['cart'],",") .")";
					$det_arr = mysql_query($sql);
					$sql="";
					$sn=0;		
					while($row=mysql_fetch_array($det_arr))
					{
						$sn++;
						$gtype = explode(",",$_SESSION['payopt']);
						if ($gtype[$sn-1]=="Yes")
						{
							$rate = $row['price_withans'];
							$ans=1;	
						}		
						else
						{
							$rate = $row['price'];
							$ans=0;	
						}			
						$insql="Insert Into  order_items values($oid, ". $row["gid"].", $ans, $rate,0);";
						mysql_query($insql);
					}
					$_SESSION['cart'] = null;	
					$_SESSION['payopt'] = null;	
					
					$fromemail="info@tajwhite.in"; 
					$toemail=$email;
					$bcc="info@tajwhite"; 
					$subject="Taj White-Your order# UP$oid"; 
					$message =
						"
						Dear $title $name, <p> 
						Thanks for ordering on tajwhite.in. <br />
						Your <strong>Order#EN$oid</strong> is processed.<br />	<br />
						
						For more details, please contact at info@tajwhite.in
						";
					echo send_mail($fromemail, $toemail,$bcc, $subject, $message);
					//header("location:forms.php?content=Order Recipt");	
				}
			} //if ($_SESSION['cart'] != null && $Cart==1)
			
			
			if ($payamttype=="D")
			{		
				require("libfuncs.php3");
			
				$Merchant_Id = "" ;//This id(also User Id)  available at "Generate Working Key" of "Settings & Options" 
				$Amount = $payamt ;//your script should substitute the amount in the quotes provided here
				$Order_Id = "EN$oid" ;//your script should substitute the order description in the quotes provided here
				$Redirect_Url = "http://tajwhite.in/payment.php" ;//your redirect URL where your customer will be redirected after authorisation from CCAvenue
			
				$WorkingKey = ""  ;//put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key ,login to your CCAvenue merchant account and visit the "Generate Working Key" section at the "Settings & Options" page. 
				$Checksum = getCheckSum($Merchant_Id,$Amount,$Order_Id ,$Redirect_Url,$WorkingKey);
		
				$sql = "Select * from  f_member where mem_id = $userid ";
				$det_arr = mysql_query($sql );
				while($row=mysql_fetch_array($det_arr))
				{
					$billing_cust_name=$row["fname"].' '. $row["lname"];
					$billing_cust_address=$row["address1"].' '. $row["address2"];
					$billing_cust_state= $row["state"];
					$billing_cust_country=$row["country"];
					$billing_cust_tel=$row["contactno"];
					$billing_cust_email=$row["email"];
					
					$delivery_cust_name=$billing_cust_name;
					$delivery_cust_address=$billing_cust_address;
					$delivery_cust_state = $billing_cust_state;
					$delivery_cust_country = $billing_cust_country;
					$delivery_cust_tel=$billing_cust_tel;
					//$delivery_cust_notes=$row[""];
					
					$Merchant_Param="" ;
					$billing_city = $row["city"];
					$billing_zip = $row["zip"];
					$delivery_city = $row["city"];
					$delivery_zip = $row["zip"];
				}		
				?>
				<form name="ccavanue" method="post" action="https://www.ccavenue.com/shopzone/cc_details.jsp">
				<input type=hidden name=Merchant_Id value="<?php echo $Merchant_Id; ?>">
				<input type=hidden name=Amount value="<?php echo $Amount; ?>">
				<input type=hidden name=Order_Id value="<?php echo $Order_Id; ?>">
				<input type=hidden name=Redirect_Url value="<?php echo $Redirect_Url; ?>">
				<input type=hidden name=Checksum value="<?php echo $Checksum; ?>">
				<input type="hidden" name="billing_cust_name" value="<?php echo $billing_cust_name; ?>"> 
				<input type="hidden" name="billing_cust_address" value="<?php echo $billing_cust_address; ?>"> 
				<input type="hidden" name="billing_cust_country" value="<?php echo $billing_cust_country; ?>"> 
				<input type="hidden" name="billing_cust_state" value="<?php echo $billing_cust_state; ?>"> 
				<input type="hidden" name="billing_zip" value="<?php echo $billing_zip; ?>"> 
				<input type="hidden" name="billing_cust_tel" value="<?php echo $billing_cust_tel; ?>"> 
				<input type="hidden" name="billing_cust_email" value="<?php echo $billing_cust_email; ?>"> 
				<input type="hidden" name="delivery_cust_name" value="<?php echo $delivery_cust_name; ?>"> 
				<input type="hidden" name="delivery_cust_address" value="<?php echo $delivery_cust_address; ?>"> 
				<input type="hidden" name="delivery_cust_country" value="<?php echo $delivery_cust_country; ?>"> 
				<input type="hidden" name="delivery_cust_state" value="<?php echo $delivery_cust_state; ?>"> 
				<input type="hidden" name="delivery_cust_tel" value="<?php echo $delivery_cust_tel; ?>"> 
				<input type="hidden" name="delivery_cust_notes" value="<?php echo $delivery_cust_notes; ?>"> 
				<input type="hidden" name="Merchant_Param" value="<?php echo $Merchant_Param; ?>"> 
				<input type="hidden" name="billing_cust_city" value="<?php echo $billing_city; ?>"> 
				<input type="hidden" name="billing_zip_code" value="<?php echo $billing_zip; ?>"> 
				<input type="hidden" name="delivery_cust_city" value="<?php echo $delivery_city; ?>"> 
				<input type="hidden" name="delivery_zip_code" value="<?php echo $delivery_zip; ?>"> 
				</form>
				<script>
					document.ccavanue.submit();
				</script>
				<?
				return;
			} //if ($payamttype=="D")
		}
		else 
		{
			$ErroMsg = "Please select your payment option.";
		}//if ($payamttype=="")
	}//if (isset($_REQUEST['osubmit']))
}  //if ($content=="Order Details")
?>
<form method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">	
		  <tr>
			<td colspan="2" align="left" bgcolor="#000000"><strong>Order Details </strong><br />
		    (Please fill all information correctly) </td>
		  </tr>
		  <tr>
		  <td colspan="2" height="2"></td>
		  </tr>
		 
		  <tr>
			<td align="right" bgcolor="#990000" class="style8">Payment Option  </td>
			<td align="left" valign="top" bgcolor="#990000" >			
			
				  <select name="PaymentType"  id="PaymentType">
				  <option value="D">Credit Card/Online Payment</option>				 
				  </select>
			
		    </td>
		  </tr>
		  
		  <tr>
			<td colspan="2" valign="top">
			<table width="100%" border="0" cellpadding="3" cellspacing="1">
			  <tr>
				<td width="6%" bgcolor="#000033"><strong># </strong></td>
				<td width="57%" bgcolor="#000033"><strong>Particulars </strong></td>
				<td width="11%" align="right" bgcolor="#000033"><strong>Qty</strong></td>
				<td width="13%" align="right" bgcolor="#000033"><strong>Price<span class="style8">(Rs)</span></strong></td>
				<td width="13%" align="right" bgcolor="#000033"><strong>Amount<span class="style8">(Rs)</span></strong></td>
			  </tr>
			   <?  
			   	if ($_SESSION['cart']!="")
				{			  
					$sql = "Select * from paper_group where gid in (". rtrim($_SESSION['cart'],",") .")";
					$det_arr = mysql_query($sql );
										  
					$sn=0;
					while($row=mysql_fetch_array($det_arr))
					{
						$sn++;
						$itemid = $row['gid'];
						$item = $row['gtitle'].'<br>'.$row['gdetails'];
						$qty = 1;
						$gtype = explode(",",$_SESSION['payopt']);
						if ($gtype[$sn-1]=="Yes")
							$rate1 = $row['price_withans'];			
						else
							$rate1 = $row['price'];			
						
						$iamt = $qty*$rate1;			
						?>
					  <tr>
						<td><? echo $sn; ?></td>
						<td><? echo $item; ?></td>
						<td align="right"><? echo $qty; ?></td>
						<td align="right"><? echo $rate; ?></td>
						<td align="right"><? echo $iamt; ?></td>
					  </tr>
					  <?
						$tamount += $iamt;
					}				
				}
				?>
					
			  <tr>
				<td colspan="4" align="right" bgcolor="#000033"><strong>Total Payble Amount</strong> </td>
				<td align="right" bgcolor="#000033"><span class="style8">Rs.</span><? echo $tamount; ?></td>
			  </tr>
			</table>			
			<input type="hidden" name="payamt" value="<? echo $tamount ?>" />
 			</td>
		  </tr>
		  
		  <tr>
			<td width="30%" align="right" valign="top">Total Pay Amout: </td>
			<td width="70%" align="left" valign="top" class="redlink"><strong><span class="style8">Rs.</span></strong><? echo $tamount; ?>/-</td>
		  </tr>
		 <tr>
			<td colspan=2><h3> Billing Information</h3>
			  <style type="text/css" media="screen">
			.lable
			{
					
				width:100px;
				font-weight:bold;
				color:#FFFFFF;
			}
			</style>

				<?
				$sql = "Select * from  f_member where mem_id = $userid ";
				$det_arr = mysql_query($sql );
				while($row=mysql_fetch_array($det_arr))
				{
					echo "<span class=lable><br>Name: </span>". $billing_cust_name= $row["fname"].' '. $row["lname"];
					echo "<span class=lable><br>Address: </span>".$billing_cust_address=$row["address1"].' '. $row["address2"];
					echo "<span class=lable><br>State: </span>".$billing_cust_state= $row["state"];
					echo "<span class=lable><br>Country: </span>".$billing_cust_country=$row["country"];
					echo "<span class=lable><br>Phone: </span>".$billing_cust_tel=$row["contactno"];
					echo "<span class=lable><br>Email: </span>".$billing_cust_email=$row["email"];
				}
				
				?>
			</td>
		  </tr>
		  
		  <tr>
			<td align="right"><table border="0" width="125" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="top" ><a href="javascript:openLogo('shopline2282')"><img src="http://www.ccavenue.com/images/100.gif" border="0" /></a> </td>
              </tr>
            </table></td>
			<td valign="top">
				<? if ($tamount >0) {?>
				<input type="submit" name="osubmit" id="osubmit" value="Process to Payment" onclick="return validatefm(this);" /> 
				<br />
				(Please do not click twice)
				<? }?>
			<script language='JavaScript'>
					function openLogo(ClientID)
					{
					var attributes = 'toolbar=0,location=0,directories=0,status=0, menubar=0,scrollbars=1,resizable=1,width=550,height=600,left=0,top=0';
					sealWin=window.open('http://www.ccavenue.com/verifySeal.jsp?ClientID='+ClientID ,'win',attributes); 
					self.name = 'mainWin'; 
					}
					</script></td>
		  </tr>
</table>
</form>
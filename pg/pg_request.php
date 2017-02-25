<?
	require("libfuncs.php3");

	$Merchant_Id = $Merchant_Id ;//This id(also User Id)  available at "Generate Working Key" of "Settings & Options" 
	$Amount = $payamt ;//your script should substitute the amount in the quotes provided here
	$Order_Id = "$OrderPrefix$order_id" ;//your script should substitute the order description in the quotes provided here
	$Redirect_Url = "$SiteUrl/orderstatus.php" ;//your redirect URL where your customer will be redirected after authorisation from CCAvenue

	$WorkingKey = $WorkingKey  ;//put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key ,login to your CCAvenue merchant account and visit the "Generate Working Key" section at the "Settings & Options" page. 
	$Checksum = getCheckSum($Merchant_Id,$Amount,$Order_Id ,$Redirect_Url,$WorkingKey);

	$sql = "select a.cname, a.name, a.address1, a.address2, a.city, a.state, a.country, a.pin, a.tel_res, a.tel_off, a.mobile, a.email
			from address a where aid = $bid";

	$det_arr = mysql_query($sql );
	while($row=mysql_fetch_array($det_arr))
	{
		$billing_cust_name=$row["name"];
		$billing_cust_address=$row["address1"].' '. $row["address2"] ;
		$billing_cust_state= $row["state"];
		$billing_cust_country=$row["country"];
		$billing_cust_tel=$row["tel_res"];
		$billing_cust_email=$row["email"];
		
		$delivery_cust_name=$billing_cust_name;
		$delivery_cust_address=$billing_cust_address;
		$delivery_cust_state = $billing_cust_state;
		$delivery_cust_country = $billing_cust_country;
		$delivery_cust_tel=$billing_cust_tel;
		//$delivery_cust_notes=$row[""];
		
		$Merchant_Param="" ;
		$billing_city = $row["city"];
		$billing_zip = $row["pin"];
		$delivery_city = $row["city"];
		$delivery_zip = $row["pin"];
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
?>
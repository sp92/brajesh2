<?
if ($_SESSION["pay_id"] == 3)
{
	require("libfuncs.php3");

	$WorkingKey = $WorkingKey ; //put in the 32 bit working key in the quotes provided here
	$Merchant_Id= $_REQUEST['Merchant_Id'];
	$Amount= $_REQUEST['Amount'];
	$Order_Id= $_REQUEST['Order_Id'];
	$Merchant_Param= $_REQUEST['Merchant_Param'];
	$Checksum= $_REQUEST['Checksum'];
	$AuthDesc=$_REQUEST['AuthDesc'];
		
    $Checksum = verifyChecksum($Merchant_Id, $Order_Id , $Amount,$AuthDesc,$Checksum,$WorkingKey);


	if($Checksum=="true" && $AuthDesc=="Y")
	{
		echo $msg="<br>Thank you for order with us. You has been charged and your transaction is successful. Please login and explore.";
		$status = 1;
		//Here you need to put in the routines for a successful 
		//transaction such as sending an email to customer,
		//setting database status, informing logistics etc etc
	}
	else if($Checksum=="true" && $AuthDesc=="B")
	{
		echo $msg="Thank you for order with us. We will keep you posted regarding the status of your order through e-mail";
		$status = 1;
		//Here you need to put in the routines/e-mail for a  "Batch Processing" order
		//This is only if payment for this transaction has been made by an American Express Card
		//since American Express authorisation status is available only after 5-6 hours by mail from ccavenue and at the "View Pending Orders"
	}
	else if($Checksum=="true" && $AuthDesc=="N")
	{
		echo $msg="Thank you for shopping with us. However,the transaction has been declined.";
		$status = 0;
		
		//Here you need to put in the routines for a failed
		//transaction such as sending an email to customer
		//setting database status etc etc
	}
	else
	{
		echo $msg="Security Error. Illegal access detected";
		$status = 0;
		//Here you need to simply ignore this and dont need
		//to perform any operation in this condition
	}
}	

if ($Order_Id == "")
	$Order_Id = $_SESSION["OrderNo"];

$Order_Id = str_replace($OrderPrefix,"",$Order_Id);
	
if ($status == 1)
{
	update_order($Order_Id,"","","PaymentReceived");
}
else
{
	update_order($Order_Id,"","","PaymentPending");
}

/*
$sql = "update orders set order_action='$order_action', order_status='$order_status', payment_date='$payment_date' where order_id = $oid";
mysql_query($sql);
*/

?>
<?
include_once("../include/config.php");
include("../include/functions.php");


$enddate = date('Y-m-d');
$fromdate = date('Y-m-d', strtotime("-2 day",strtotime($enddate)));
$qdt = " and pg_response='' and pay_mode='CC' and (payment_date is NULL OR payment_date='' ) and o.order_date between '$fromdate 00:00:01' and '$enddate 23:59:59'";		

$sql="select * from orders o, address a where a.aid =o.user_aid $qdt order by order_id desc";
$query=mysql_query($sql);

while($row=mysql_fetch_array($query))
{
	$orderIdPref = $row["label"]. $row["order_id"];
	$Order_Id = $row["order_id"];
	$pg_url = "http://www.ccavenue.com/servlet/new_txn.OrderStatusTracker?Merchant_Id=$Merchant_Id&Order_Id=";
	if ($row["label"]=="PD")
		$pg_url = "http://www.ccavenue.com/servlet/new_txn.OrderStatusTracker?Merchant_Id=M_pub33204_33204&Order_Id=";

	$url = "$pg_url$orderIdPref";
	$file = file_get_contents($url);
	if (strpos($file,"AuthDesc=Y")>0)
	{
		echo update_order($Order_Id,"","","PaymentReceived");
	}
	else
	{
		echo update_order($Order_Id,"","","PaymentPending");
	}
	$sql="update orders set pg_response='$file' where order_id=$Order_Id";
	mysql_query($sql);
	echo "<br>";
}
?>
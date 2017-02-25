<?
$sql = "select * from orders o join address a on aid=user_aid where order_id='$order_id'";
$prod_arr = mysql_query($sql);
while($row1=mysql_fetch_array($prod_arr))
{
	$amt = $row1["total_amount"];
	$name = $row1['name'];
	$mobile = trim($row1['mobile']);
	$sms = "Thank you for your order no. $order_id for Rs.$amt/- You may view and manage your order at www.manojpublications.com. We appreciate your business.Manoj Publication";
	SendSMS($mobile, $sms);
}
?>
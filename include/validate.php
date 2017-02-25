<?
include("config.php"); 
$today = date("Y-m-d");
$userid =0;

$Coupon = get("coupon");

if ($Coupon!="")
{
	$sql = "select * from discountmaster where store_id = $StoreId and discount_items='$Coupon' and discount_user = $userid and discount_type='Coupon' AND '$today' between start_date and end_date and active=1";	
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{				
		if ($row["discount_coup_max"] == 0)
			echo $Msg = "Sorry! all copuons has been used. Please use another.";
		else
			$Msg="Good";
	}
	if ($Msg == "")
		echo $Msg = "Invalid coupon used or copon validity has already expired.";
}
?>

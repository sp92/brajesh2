<?
session_start();
include_once("../include/config.php");
include_once("../include/functions.php");

$oid = get("oid");
if ($oid!="")
{
	$n=0;
	$sql="select * from order_tracking where order_id=$oid order by created_date desc";
	$query=mysql_query($sql);
	while($row=mysql_fetch_array($query))
	{	
		if ($n==0)
			echo "<strong>Date/ Time&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Order Status</strong><br>";
		echo $row["created_date"] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $row["status"] ."<br>";
		$n++;
		
	}
}
?>
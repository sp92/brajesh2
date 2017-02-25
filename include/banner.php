<?
include("config.php"); 
$bid = get("bid");
$sql = "select * from banner where banner_id='$bid'";	
$det_arr = mysql_query($sql);
while($row=mysql_fetch_array($det_arr))
{
	$sql = "update banner set hits = (hits+1) where banner_id = ".$row["banner_id"];	
	mysql_query($sql);
	$link = $row["url"];
	if (strpos($link,",")>0)
	{
		$link  = "../lpage.php?code=". trim(str_replace(" ","",$link),",");
	}
	header("location:$link");
}

?>

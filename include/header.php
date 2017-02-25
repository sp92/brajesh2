<? 
session_start();
include("config.php"); 

$page = basename($_SERVER['PHP_SELF']); // "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION["redirect"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($_SESSION["userid"]=="")
{
	if (
		strpos($page,'account.php') > 0 || 
		//strpos($page,'onepage') > 0 ||
		strpos($page,'order.php') > 0
		)
	{
		$_SESSION["redirect"] = $page;
		header("location:login.php");
	}
}
else
{
	if (strpos($page,'login.php') > 0)
	{
		 $_SESSION["username"] = "";
		 $_SESSION["userid"] = "";
		 $_SESSION["email"] = "";
	}
}

include("cartinc.php"); 


//------------ Geting the mata info -----
$hdtitle = "Welcome to My Fashion";
$hdkeword = "My Fashion.";

if (strpos($page,'lpage.php') == 0 && get("cat") > 0 )
{
	$group = "category";
	$location =  get("cat");
}
else if (strpos($page,'lpage.php') == 0 && get("scat") > 0 )
{
	$group = "subcategory";
	$location =  get("scat");
}
else if (strpos($page,'details.php') == 0 && get("prod_id") > 0 )
{
	$group = "books";
	$location =  get("prod_id");
}
else 
{
	$group = "StaticPages$StoreId";
	$location =  $page;
}
//echo $page;

$sql = "Select * from metainfo where `group`= '$group' and location='$location'";
$det_arr = mysql_query($sql);
while($row=mysql_fetch_array($det_arr))
{
	$hdtitle = $row['title'];
	$hddesc = $row['description'];
	$hdkeword = $row['keyword'];
}

?>
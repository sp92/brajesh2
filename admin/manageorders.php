<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../scripts/jquery.min.js"></script>
<script>
	function fn_getOrderTrail(oid)
	{
		$.post("order_status.php",
		{
			oid:oid
		},
		function(data,status){ 
		  $("#orderStatus").html(data);
		});
	}
	</script>
<?
if (!session_id()) 
    session_start(); 
	

if($_SESSION['username']=="")
	header("location:index.php");
	
include_once("../include/config.php");	
include_once("../include/functions.php");

include_once("../include/orderinfo_print.php");	

?>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/responsive.css" rel="stylesheet" type="text/css" />
<link href="../css/nav.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="screen">
<!--
@import url("../css/DGslider.css");
@import url("../css/themes/pascal/pascal.css");
-->

td
{
	font-size:11px
}
</style>

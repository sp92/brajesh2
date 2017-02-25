<?php
session_start();
include_once("../include/config.php");
include("../include/functions.php");
$tab=get('tab');
$id=get('id');
$name=get('name');
$store_id=$_SESSION["StoreId"];

if ($tab=='category')
	$add = " where cat_store=$store_id ";

$sql = "select * from $tab $add order by $name asc";
	//echo "<script>alert('$sql')</script>";
?>
<option value="">---Select----</option>
<?php
$sql_cat = mysql_query($sql);
while($data_cat=mysql_fetch_array($sql_cat))
{
?>
	<option value="<? echo $data_cat[$id];?>"><? echo $data_cat[$name];?></option>
<?php 
} ?>
				

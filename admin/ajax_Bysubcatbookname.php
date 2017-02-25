<?php
include_once("../include/config.php");
include("../include/functions.php");

?>

<option value="">---Select----</option>
<?php
$sql_cat = mysql_query("select * from products where  prod_subcat='".$_POST['id']."' and prod_cat='".$_POST['catid']."' order by prod_id asc");
while($data_cat=mysql_fetch_array($sql_cat))
{
?>
<option value="<? echo $data_cat['prod_id'];?>"><? echo $data_cat['prod_name_e'];?></option>
<?php } ?>

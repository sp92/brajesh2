<?php
include_once("../include/config.php");
include("../include/functions.php");
?>


<?php
$sql_cat = mysql_query("select * from products where prod_cat='".$_POST['id']."' order by prod_name_e asc");
while($data_cat=mysql_fetch_array($sql_cat))
{
?>
<option value="<? echo $data_cat['prod_id'];?>" select="selected"><? echo $data_cat['prod_name_e'];?></option>
<?php } ?>

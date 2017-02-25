<?php
include_once("../include/config.php");
include("../include/functions.php");
print_r($_POST);
?>
<option value="">---Select----</option>
<?php
 $sql_cat = mysql_query("select * from subcategory where subcat_active=1 and cat_id=".$_POST['id']." order by subcat_seq asc");
						 while($data_cat=mysql_fetch_array($sql_cat))
						 {
					?>
					<option value="<? echo $data_cat['subcat_id'];?>"><? echo $data_cat['subcat_title'];?></option>
					<?php } ?>
				

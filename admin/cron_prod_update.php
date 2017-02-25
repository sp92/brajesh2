<?php
include_once("../include/config.php");
include("../include/functions.php");

$tdate = date('Y-m-d');
$sql = "select * from products p
		join category c on prod_cat = cat_id
		where modify_date='$tdate' and prod_active=1";	
$det_arr = mysql_query($sql);
while($row=mysql_fetch_array($det_arr))
{
	$site= ($row['prod_store']==1)?'http://upkar.in':'http://pdgroup.upkar.in';
	$prod .= '<tr>';
	$prod .= '<td>'. $site.'</td>' ;			
	$prod .= "<td><img src='$site/upload/prod_pic/small/". $row['prod_pic']."'></td>" ;			
	$prod .= '<td>'. $row['cat_title'].'</td>' ;			
	$prod .= '<td>'. $row['prod_code'].'</td>' ;			
	$prod .= '<td>'. $row['prod_name_e'].'</td>' ;			
	$prod .= '<td>'. $row['writer_e'].'</td>' ;			
	$prod .= '<td>'. $row['prod_isbn'].'</td>' ;			
	$prod .= '<td>'. $row['prod_rate'].'</td>' ;			
	$prod .= '</tr>';
}

if ($prod !="")
{
	echo $email = str_replace('\r\n',',',getCodeValue('ProdEmailList','code_desc'));
	$header = "<table border=1 cellpadding=3 cellspacing=0><tr style='font-weight:bold'><td>Site</td><td>Cover</td><td>Category</td><td>Code</td><td>Name</td><td>Writer</td><td>ISBN</td><td>Price</td></tr>";
	$mMessage = "Dear Sir,<br><br>Following books are recently updated:<br>".$header.$prod ."</table>";
	$mSubject = "Books update notification on $tdate";

	$mFrom     = $FromMailId;
	$mTo       = $email;
	$mBCC	   = $FromMailId;

	echo send_mail($mFrom, $mTo, $mSubject, $mMessage, $mBCC);
}


?>
<script>
	alert("Complete");
</script>
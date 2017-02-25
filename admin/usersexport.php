<?
session_start();

include_once("../include/config.php");
if($_SESSION['username']=="admin")
{		
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	//header("Content-Length: " . strlen($out));
	// Output to browser with appropriate mime type, you choose ;)
	header("Content-type: text/x-csv");
	header("Content-Disposition: attachment; filename=Users.csv");
	
	

	$query=mysql_query($_SESSION["ExpSql"]);
	
	$sn=0;
	echo "User List\r\n";
	echo "#, Email,Name,Phone\r\n";
	while($row=mysql_fetch_array($query))
	{
		 $sn += 1;
		 $col0= $row['email'];	
		 $col1=$row['name'];	
		 $col2=$row['tel_res'].'/M:'.$row['mobile'];
		 echo "$sn, $col0,$col1,$col2\r\n";
	}
}
?>
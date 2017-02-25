<?php 
session_start();
include 'config.php';?>
<?
$em = get("email");
if ($em != "")
{
	 $sql = "select * from users where email = '$em' and active=1";
	 $prod_arr = mysql_query($sql);
	 $num_rows = mysql_num_rows($prod_arr);
	 while($row=mysql_fetch_array($prod_arr))
	 {
		$name = $row["name"];
		$un = $row["email"];
		$pw = $row["password"];
		$mfrom    = $FromMailId;
		$mto      =  $em;
		$msubject = "Password request on $SiteUrl";
		$mMessage ="Dear $name, <br>  <br>Following is your username and password registred with us:<br><br> username: $un <br> password: $pw <br><br> From <br> $FromSign";
		
		echo $status = send_mail($mfrom, $mto, $msubject, $mMessage);
		echo "Success";
	 }
	 if ($num_rows ==0)
	 {
		echo "<font color=red> Error: Provided email id is not registered with us. Please try with another email id <br> or send email at $CustomerCareEmail</font>";
	 }
}	
?>
<?
include("config.php"); 
if (get("reg_type")!="")
	$reg_type = get("reg_type");

if (get("email") != "")
{
  $email = get("email");
  $sql = "select * from notification where email = '$email'";
  $result = mysql_query($sql);
  $num_rows = mysql_num_rows($result);
  if ($num_rows > 0) 
  {
	$message = "Email id is already register for newsletter.";
	$msgclass = "error-msg";
   }
  else
  {
	$sql = "insert into notification (name, email, contact, reg_type, created_date) values('$name','$email','','$reg_type',now())";
	mysql_query($sql);
	$message = "Thanks for newsletter subscription.";
	$msgclass = "success-msg";
  } 
  echo $message;
}
?>
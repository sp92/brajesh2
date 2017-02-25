<?
include("config.php"); 
if (get("email") != "")
{
  $name = get("firstname") . " " . get("lastname");
  $email = get("email");
  $password = get("password");
  $newsletter = get("is_subscribed");
  $sql = "select * from users where email = '$email'";
  $result = mysql_query($sql);
  $num_rows = mysql_num_rows($result);
  if ($num_rows > 0) 
  {
	$message = "Email id is already in use. Please correct/change the email id.";
	$msgclass = "error-msg";
   }
  else
  {
	$sql = "insert into users (name, email, password, active, rights, newsletter) values('$name','$email','$password',1,1,'$newsletter')";
	mysql_query($sql);
	$message = "Congartulation!!!<br> Being a part of our family. Your account has been created. <br />
				  ";
	$disp = "none";
	$msgclass = "success-msg";
  } 
  echo $message;
}
?>
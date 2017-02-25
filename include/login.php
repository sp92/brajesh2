<?php 
session_start();
include 'config.php';?>
<?
 $_SESSION["username"] = "";
 $_SESSION["userid"] ="";
 $_SESSION["email"] ="";

/////////////////////////////////
 $email = get("email");
 $pass = get("password");
 
 $url = "account.php?page=dashboard";
 if ($_SESSION["redirect"] != "") $url = $_SESSION["redirect"];
 
 //$url = $_SESSION["redirect"];
 
 if ($email <> "")
 {
	$sql = "select * from users where email = '$email' and password='$pass'";
	$prod_arr = mysql_query($sql);	
	$mess= "";
	while($row=mysql_fetch_array($prod_arr))
	{	
		 $sid = session_id();
		 $_SESSION["username"] = $row["name"];
		 $_SESSION["userid"] = $row["id"];
		 $_SESSION["email"] = $row["email"];
		 $_SESSION["redirect"]="";		 
		 // attaching the cart items to logged in user
		  mysql_query("update cart set user_id=".$row["id"]." where sessionid = '$sid'");
		  mysql_query("update users set login=now() where id =".$row["id"]);	
		 
		  //echo $url;
		  echo "<script>parent.location.href='$url';</script>";
		 //header("location:$url");
	}

	if ($_SESSION["username"]=="")
	{
		 echo "Email id or passowrd is incorrect.";
	}
	else
		echo "Login Success.";
}

?>
<?php
/*
if (substr($_SERVER['HTTP_HOST'],0,3) != 'www' && substr($_SERVER['HTTP_HOST'],0,9) != 'localhost' && strpos('admin1',$_SERVER['HTTP_HOST']) == -1) 
{ 
	header('HTTP/1.1 301 Moved Permanently'); 
	header('Location: http://www.'.$_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI']); 
}
*/

error_reporting(0);

/****************************************
General Setting 
****************************************/
	$OrderPrefix = "WFAS";
	$SiteUrl = "http://localhost/attabaazar.com/";
	$FromSign = "My Fashion";
	$FreeShippingAmt = 500;
	$ShippingAmt = 50;
	$CustomerCarePhone = "+91-9868112194";
	$CustomerCareEmail = "care@womens_fashion.com";
	$OrderCCMailId = "my@womens_fashion.com";
	$FromMailId= "care@womens_fashion.com";
        //$mBCC = "ramagya@gmail.com";

	$GLOBALS['urlRewite'] = false; 
	$Lang='E';
	$StoreId=1;
	
// Google Analeytics code
	$gaTrackingNumber ="";
	
	
// reCAPTCHA Keys
	// Get a key from https://www.google.com/recaptcha/admin/create
	$publickey = "6Lcp6P4SAAAAAP2Euh2wjRVt-SdJZnLbkOsGMykQ";
	$privatekey = "6Lcp6P4SAAAAADpvQ9gWPeNSac6yo7ZAwt7QCPdf";
		
	
//-- Payment Gateway Active
	$Merchant_Id = "";
	$WorkingKey = "";

//-- Mail Setup
	global $SMTPFromMail;
	global $SMTPPassword;
	global $SMTPPort;
	global $SMTPServer;
	global $SMTPAuth;
	global $SendMail;
	global $SendSMS;
	$SMTPFromMail = "webmaster@womens_fashion.com";
	$SMTPPassword = "womens_fashion@13579!@#$";
	$SMTPPort 	 = "465";             		//If Gmail:465  Else= 25
	$SMTPServer   = "smtp.gmail.com";      //Default: localhost, Gmail: smtp.gmail.com	
	$SMTPAuth   = "ssl"; 
	$SendMail = 1;   						// 1 = Yes, 0=No
	$SendSMS = 1;   						// 1 = Yes, 0=No


// Default Settings
	$mailtemplate ="";	
	date_default_timezone_set('Asia/Calcutta'); 
	$now = date("Y-m-d H:i:s");
	$today = date("Y-m-d");
	$GLOBALS['today'] = $today;
	$GLOBALS['StoreId'] = $StoreId; 

/****************************************
Db Setting 
****************************************/

global $CONFIG_Server;
global $CONFIG_Database;
global $CONFIG_User;
global $CONFIG_Pass;
global $CONFIG_wbServer;

if ($_SERVER['HTTP_HOST'] == 'localhost')
{
	 $CONFIG_Server = "localhost"; 
	 $CONFIG_Database = "ramesh_db";
	 $CONFIG_User= "root";
	 $CONFIG_Pass="";
	 $CONFIG_Folder	= "";
   	 $GLOBALS['HomeDir'] = "//var//www//vhosts//test.com//womens_fashion.in//"; 

}
else
{
	 $CONFIG_Server = ""; 
	 $CONFIG_Database = "";
	 $CONFIG_User= "";
	 $CONFIG_Pass="";
	 $CONFIG_Folder	= "";
 	 $GLOBALS['HomeDir'] = "E:\\Divesh\\test\\wb\\php\\womens_fashion\\"; 
	
}

$error="";
$con=mysql_connect($CONFIG_Server,$CONFIG_User,$CONFIG_Pass) or $error = mysql_error();
$db=mysql_select_db($CONFIG_Database,$con) or $error = mysql_error();
mysql_query ("set character_set_results='utf8'"); 
mysql_query("SET NAMES utf8");
echo $error;
if ($error!="")
{
	die(mysql_error());
	//header("location:/Message.htm");
} 

include_once("my_sql_helper.php"); 
include_once("functions.php");
//header("Connection: Keep-alive");
?>
<?php
include_once("config.php");

$toemail = "disveshs@gmail.com"; //"vinaysheelsaxena@gmail.com";
$fromemail = "web@aapkikismat.com";
$bcc="diveshs@gmail.com";
$subject = "Appkikismat Mysql Db Backup";
$message = "Here is the Aapkikismat Db backup.";
// don't need to edit below this section

try 
{
	$backupfile = $CONFIG_Database .  date("Y-m-d-H-i-s") . '.sql';
	echo system("mysqldump --opt -h $CONFIG_Server -u $CONFIG_User -p $CONFIG_Pass $CONFIG_Database > $backupfile");
	//system("mysqldump -h $dbhost -u $dbuser -p$dbpass $dbname > $backupfile");
	//echo send_mail($fromemail, $toemail,$bcc, $subject, $message,$backupfile) ;
}
catch (Exception $e)
{
	echo 'Message: ' .$e->getMessage();
}
//unlink($backupfile);
echo "Db backup is complete ";
?>
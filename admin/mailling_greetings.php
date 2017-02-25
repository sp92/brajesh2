<?php
session_start();
if($_SESSION['username']=="")
	header("location:index.php");
	
if ($_REQUEST['t'] != "")
{
	$_SESSION['sectiondesc'] = $_REQUEST['t'];
	//echo $_SESSION['lang'] = $_REQUEST['lang'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Send Greetings Screen</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #999999;
}
.style1 {
	font-size: 24px;
	font-style: italic;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
.hn{font-family:surya;font-size:18px;}

-->
</style><meta name="google-site-verification" content="mCOTc5k6Pfq1ufJd4sh_TVDZGGUk32CIq-ksMwkrhMw" />
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><? include("top.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#E4F0FC">
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="17%" bgcolor="#9999CC">&nbsp;</td>
        <td width="83%" >
		<table width="100%" height="29"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="4%" bgcolor="#CCCCCC">&nbsp;</td>
            <td width="96%" bgcolor="#0066FF"><strong class="style2"> >> <? echo $_SESSION['sectiondesc'] ?></strong></td>
          </tr>
        </table>
          <?	
		  if (isset($_POST['Submit']))
		  {
			$fromemail = "web@aapkikismat.com";			
			$mailbody=$_REQUEST["description"];	
				
			$sql="select * from users ";
			$query=mysql_query($sql);			
			while($row1=mysql_fetch_array($query))
			{	
				$subject = "";		
				$body = "";	
				$DOB = explode(' ',$row1['DOB']);
				//echo $DOB[0].$DOB[1];
				$DOA = explode(' ',$row1['DOA']);
				$toemail = $row1['Email'];
				$name = $row1["Title"] . ' '.$row1["Name"];
				if ($_SESSION['sectiondesc'] == "Send Birth Day Mail" && $row1['DOB'] != "" && $DOB[0] == (int)date('d') &&  $DOB[1] == (int)date('m'))	
				{			
					$subject = "Appkikismat - Birth Day Greetings";
					$body = "<center><img src='http://aapkikismat.com/img/flowers.jpg'>
							<br>
							<h3>Happy Life</h3>				
							If you want to be happy for one day,<br>					
							go for dinner with someone.	<br>				
							Happy for a week,	<br>				
							spending holidays with lover.<br>					
							But		<br>			
							For a happy life,	<br>				
							keep me as a friend!<br>					
							<strong>Happy Birthday!</strong><br>
							</center><P>";
				}
				if ($_SESSION['sectiondesc'] == "Send Anniversary Mail" && $row1['DOA'] != "" && $DOA[0] == (int)date('d') &&  $DOA[1] == (int)date('m'))	
				{
					$subject = "Appkikismat - Anniversary Greetings";
					$body = "<center><img src='http://aapkikismat.com/img/flowers.jpg'><br><strong>Happy aniversary <br>May god bless you. <br> May This year bring many happiness in your life.</strong></center><P>";
				}

				$message = 
					"					
					Dear <strong>$name</strong>,<br><br>
					<font color=red size=4>$body</font>	<br>
					$mailbody 
					<br><br> Have a nice day!!!
					";
					
				if ($toemail !="" && strpos($toemail,'*') === false  && $subject!="")
				{
					$ii++;
				    $tid = $tid. $sign.'-'.$toemail."<br>"; 
					//echo $message;
					echo send_mail($fromemail, $toemail,$bcc="", $subject, $message,"") ;
				}									
			}
			echo "Sending mail is completed to $ii users.";
		  }
		?>
          
          <form action="" method="post" name="form1">
		  <input type="hidden" name="id" value="<?=$id ?>">
            <table width="98%" height="20"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
              <tr>
                <td colspan="2" class="style2"><? echo $_SESSION['sectiondesc'];?> </td>
              </tr>
			  <?if ($_SESSION['sectiondesc']!="Daily Forecast")
		  		{?>
              <tr bgcolor="#FFFFFF">
                <td align="right" valign="top">Message&nbsp;</td>
                <td><textarea name="description" cols="<? echo ($lang =="H")?500:50; ?>" rows="10" id="description" class="<? echo ($lang =="H")? "hn":""; ?>"><? echo $description;?></textarea></td>
              </tr>
			  <? }?>
              <tr bgcolor="#FFFFFF">
                <td colspan="2" align="right"><div align="center">
                    <input type="submit" name="Submit" value="Send" onClick="return validate();">
                    <input type="reset" name="Submit2" value="Reset">
                </div></td>
              </tr>
            </table>
          </form>
      </table>         
    </td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td><? include("bottam.php"); ?></td>
  </tr>
</table>

</body>
</html>

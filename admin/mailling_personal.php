<?php
session_start();
if($_SESSION['username']=="")
	header("location:index.php");
	
if ($_REQUEST['t'] != "")
{
	$_SESSION['sectiondesc'] = $_REQUEST['t'];
	//echo $_SESSION['lang'] = $_REQUEST['lang'];
}
include_once("config.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Send Greetings Screen</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="winxp.blue.css" rel="stylesheet" type="text/css" /> 

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

-->
</style>
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td bgcolor="#E4F0FC">
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="83%" >
		
		<table width="100%" height="29"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="4%" bgcolor="#CCCCCC">&nbsp;</td>
            <td width="96%" bgcolor="#0066FF"><strong class="style2"> Send Personal Mail</strong></td>
          </tr>
        </table>
          <?	
		  $userid  = $_REQUEST["uid"];
		  if (isset($_POST['Submit']))
		  {
			$fromemail = "web@aapkikismat.com";			
			$message=$_REQUEST["message"];	
			$message = str_replace(chr(10),'<br>',$message);
			$subject=$_REQUEST["subject"];	
				
			$sql="select * from users where UserId=$userid ";
			$query=mysql_query($sql);			
			while($row1=mysql_fetch_array($query))
			{				
				$toemail = $row1['Email'];
				$name = $row1["Title"] . ' '.$row1["Name"];
									
				if ($toemail !="" && strpos($toemail,'*') === false  && $subject!="")
				{
					$ii++;
				    $tid = $tid. $sign.'-'.$toemail."<br>"; 
					//echo $message;
					$status = send_mail($fromemail, $toemail,$bcc="", $subject, $message,"") ;
					if ($status=="")
					{
						echo "Sending mail is completed.";
						$sql = "insert into  mailling_logs values($userid,now()) ";
						mysql_query($sql );
					}
					else
						echo $status;
				}									
			}			
		}
		else
		{
		  
			if ($_SERVER['HTTP_HOST'] == 'localhost')
				$filters = "http://localhost:2923/horoscope.ak/getInfo.aspx?";
			else
				$filters = "http://horoscope.aapkikismat.com/getInfo.aspx?";
			
	
			if ($userid != "")
			{	
				$sql = "Select * from users where userId = $userid ";
				$det_arr = mysql_query($sql );
				while($row=mysql_fetch_array($det_arr))
				{
					$name = $row['Name'];
					$gender = $row['Gender'];
					$birthtime = $row['BirthTime'];
					$birthplace = $row['BirthPlace'];
					$birthcountry  = $row['BirthCountry'];
					$dob = explode(" ",$row['DOB']);
				}
			
				$time = explode(' ', $birthtime);	
				$filters  = $filters . "Name=".$name;
				$filters  = $filters . "&Gender=".$gender;
				$filters  = $filters . "&DOB=".$dob[0]."/".$dob[1]."/".$dob[2];
				$filters  = $filters . "&Time=".$time[0].":".$time[1].":00";
				$filters  = $filters . "&City=".$birthplace;
				$filters  = $filters . "&Country=".$birthcountry;
				$filters  = $filters . "&Opt=ALL";
			}	
		//echo $filters;			
		?>
		 <div align="center">
			<iframe src="<? echo $filters ?>" width="100%" height="300" frameborder="0" scrolling="auto"></iframe>
		 </div>
          <form action="" method="post" name="form1">
		  <input type="hidden" name="uid" value="<?=$userid ?>">
            <table width="100%" height="20"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
              <tr>
                <td colspan="2" class="style2">Compose Mail</td>
              </tr>
			  
			  <tr bgcolor="#FFFFFF">
                <td align="right" valign="top">Subject&nbsp;</td>
                <td><input name="subject" type="text" id="subject" value="" size="90" width="50" ></td>
              </tr>
			  
              <tr bgcolor="#FFFFFF">
                <td align="right" valign="top">Message&nbsp;</td>
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td valign="top"><textarea name="message" cols="65" rows="10" id="message" ></textarea></td>
					<td valign="top"><strong>Mailing History</strong><br>
					<?
					$sql = "Select * from mailling_logs where UId = $userid order by MaillingDate desc ";
					$det_arr = mysql_query($sql );
					while($row=mysql_fetch_array($det_arr))
					{
						echo "- ". $row['MaillingDate']."<br>";
					}
					
					?>
					
					</td>
				  </tr>
				</table>

				
				</td>
              </tr>
			
              <tr bgcolor="#FFFFFF">
                <td colspan="2" align="right"><div align="center">
                    <input type="submit" name="Submit" value="Send" onClick="//fn_send();">
                    <input type="reset" name="Submit2" value="Reset">
                    <!--<input name="preview" type="button" id="preview" onClick="fn_preview()" value="Mail Preview">-->
                </div></td>
              </tr>
            </table>
          </form>
		  <? }?>
      </table>         
    </td>
  </tr>
</table></td>
  </tr>
  
</table>
<script>
function fn_preview()
{
	window.open('','pre','width=700 height=500 scrollbars=1');
	document.form1.target = "pre";
	document.form1.action= "preview.php"
	document.form1.submit();
}
function fn_send()
{
	document.form1.target = "";
	document.form1.action= ""
	document.form1.submit();
}
</script>
</body>
</html>

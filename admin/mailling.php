<?php
session_start();
if($_SESSION['username']=="")
	header("location:index.php");
	
if ($_REQUEST['t'] != "")
{
	$_SESSION['sectiondesc'] = $_REQUEST['t'];
	//echo $_SESSION['lang'] = $_REQUEST['lang'];
}
set_time_limit(0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Main Screen</title>
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
 <script type="text/javascript"> 
			window.onload=function ()
			{
				new JsDatePick({
					useMode:2,
					target:"FromDate"
					//limitToToday:true <-- Add this should you want to limit the calendar until today.
					})
					
				new JsDatePick({
					useMode:2,
					target:"ToDate",
					//limitToToday:true 
					})	
		
			}
		</script>
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
		  $id = get("id");
		  $lang = "E"; //$_SESSION['lang']; 
		  $type = $_SESSION['type']; 	
		  if ($_SESSION['sectiondesc']=="Daily Forecast")
		  {
		  	$subject = "Your Today`s Forecast - ". date('d M Y');
			$que = " and Forecast = 1";			
		  }
		  if ($_SESSION['sectiondesc']=="Site Update/Newsletter")
		  {
		  	$subject = "Latest Update";
			$que = " and Newsletter = 1";	
		  }
		  
		  if ($_SESSION['sectiondesc']=="Mail to All Users")
		  {
		  	$subject = "Announcement";
			//$que = " and Newsletter = 1";	
		  }
		  if (isset($_POST['Submit']))
		  {
			$sign = $_REQUEST['sign']; 
			$mailbody=$_REQUEST["description"];		
			$msg=$_REQUEST["message"];
			$FromDate=get("fromdate");
			$ToDate=$_REQUEST["ToDate"];
			$TemplateId = $_REQUEST["TemplateId"];
			$subject = $_REQUEST["subject"];
						
			if ($sign != "All")
				$sendto = " and sign='$sign' ";
				
			if ($FromDate != "" && $ToDate != "")
			{
				$daterange = " and CreatedDate between '$FromDate 00:00:00' and '$ToDate 23:59:59' ";
			}
			$sql="select * from users where Active=1 $que $sendto $daterange order by sign";
			$query=mysql_query($sql);
			$ii=0;
			while($row=mysql_fetch_array($query))
			{
				$send = false;				
				$sign = $row["Sign"];
				if ($row["Forecast"]==1)
				{
					if ($sign != $psign)
					{ 
						$forecast ="";
						$sql1="select FcDescription from forecast where fctype='D' and fcsign='$sign' and Fcday=".date('z');
						$query1=mysql_query($sql1);			
						while($row1=mysql_fetch_array($query1))
						{
							$forecast = $row1['FcDescription'];
						}
						$sql1 = "Select * from codemstr where code_fld= 'DayColor' AND  code_value='".date('w')."' AND  code_desc='$sign' and active=1";
						$det_arr1 = mysql_query($sql1);
						while($row1=mysql_fetch_array($det_arr1))
						{
							$daycolor = $row1['code_desc1'];
							$extraval = "<p><table bgcolor=black cellspacing=1 cellpadding=5><tr>
										<td bgcolor=white><strong>Color of the day</strong></td><td bgcolor='$daycolor' width=20> $daycolor</td>
										</tr></table>";
						}
						$forecast .= $extraval;
					}
					$psign = $sign;
					if (trim($forecast) !="")	$send = true;
				}
				else
				{
					$send = true;
				}				

				$name = $row["Title"] . ' '.$row["Name"];
				$toemail = $row["Email"];
				$fromemail = "web@aapkikismat.com";
				
				$body = "<strong>Your today's forecast</strong><P>$forecast<br><br> Have a nice day!!!";
				if ($mailbody != "")
					$body = $mailbody;

				$message = 
					"					
					Dear <strong>$name</strong>,<p>
					$body	
					";
					//&& $toemail=="diveshs@gmail.com"
				if ($toemail !="" && $send == true)
				{
					$jj++;
					//echo $toemail."<br>";
					$tid = $tid. $sign.'-'.$toemail."<br>"; 
					//$toemail="diveshs@gmail.com";
					$status = send_mail($fromemail, $toemail,$bcc="", "Aapki Kismat-".$subject, $message,"") ;
					if ($status != "")
					{
						$errmail = $errmail.$toemail ." - ".$status. "<br>";
						$errcount++;
					}
					else
					{
						$ii++;
					}
				}
				
			}
			//echo "$tid <br>";
			echo "<div style='height:150px; width:500px; overflow:auto; border:solid 1px'>
				<strong>$sign Mail Sending Summary</strong> <br>
				 ----------------------------------------<br>
				  <strong>Total try:</strong> $jj<br> 
				  <strong>Success:</strong> $ii<br>
				  <strong>Failed: </strong>$errcount<br><br>
				  <strong>Failed Mail Ids:</strong> <br>
				  $errmail 
				  </div><br>
				  ";
		  }
		?>
          
          <form action="" method="post" name="form1">
		  <input type="hidden" name="id" value="<?=$id ?>">
            <table width="98%" height="20"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
              <tr>
                <td colspan="2" class="style2"> Send email for <? echo $_SESSION['sectiondesc'];?> </td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td width="20%" align="right">Sign </td>
                <td>
                  <select name="sign" id="sign" class="<? echo ($lang =="H")? "hn":""; ?>" >                    
					<option value="All">To All</option>
					<?
					$signr = mysql_query("Select * from codemstr where code_fld = 'Sign' order by code_value");		
					while($row=mysql_fetch_array($signr))
					{	$signdesc = ($lang =="E")? $row['code_desc']:$row['code_desc1'];
						if ($sign == $row['code_value']) $sel = "selected";
						echo "<option value='".$row['code_value']."' ".$sel.">". $signdesc ."</option>";
						$sel = "";
					}
					?>
                  </select>
                  &nbsp;  User Created Date: from
                  <input name="FromDate" type="text" id="FromDate" size="8" maxlength="10"> 
                  to                  
                  <input name="ToDate" type="text" id="ToDate" size="8" maxlength="10"></td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td align="right" valign="top">Subject&nbsp;</td>
                <td><input type=text name="subject"  id="subject" class="<? echo ($lang =="H")? "hn":""; ?>" value="<? echo $subject;?>" size=60></td>
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
<script>
function fn_edit(id,issue,desc,act)
{
	document.getElementById("id").value = id;
	document.getElementById("issue").value = issue;
	document.getElementById("desc").value = desc;
	document.getElementById("active").checked = (act==1)?true:false;
}
</script>
</body>
</html>

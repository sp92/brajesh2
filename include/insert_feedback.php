<?php include_once('config.php');?>
<?php

$disp ="inline";
if (get("typefor")!= "")
{
	$inquiry_type= get("typefor");
	$inquiry_related_to = get("inquiry_related_to");
	$inquiry_for = get("inquiry_for");
	$name = get("name");
	$company_name = get("company_name");
	$address = get("address");
	$state = get("state");
	$pin = get("pin");
	$country = get("country");
	$phone = get("phone");
	$mobile = get("mobile");
	$email = get("email");
	$inquiry_message = get("inquiry_message");
	$e_newsletters = get("newsletter");

		 $sql = "insert into feedback Set 
								inquiry_type='$inquiry_type',
								inquiry_related_to='$inquiry_related_to',
								inquiry_for='$inquiry_for',
								name='$name', 
								company_name='$company_name',
								address='$address',
								state	='$state',
								pin	='$pin',
								country='$country',
								phone='$phone',
								mobile='$mobile',
								email='$email',
								inquiry_message='$inquiry_message',
								`e-newsletters`='$e_newsletters',
								date=NOW()
								";	 
	mysql_query($sql);
	if ($e_newsletters=="1")
	{
		$reg_type = "NL";
		include("newsletter-register.php");
	}
	if ($inquiry_related_to!="")
	{
		$e_newsletters = ($e_newsletters=="1")?"Yes":"No";	
		$mMessage = "<em><b>Dear $name,</b></em><br><br>
					Following are $inquiry_type details posted by you for $FromSign <br>
					<b>$inquiry_type related to</b> $inquiry_related_to<br>
					<b>Inquiry for</b> $inquiry_for<br>
					<b>Name</b> $name <br>
					<b>Mobile</b> $mobile <br>
					<b>Email</b> $email <br>
					<b>$inquiry_type message</b> $inquiry_message<br>
					<b>Newletter</b> $e_newsletters
					";
	}
	else
	{
		$mMessage = "<em><b>Dear Sir,</b></em><br><br>
					Following are $inquiry_type details posted by you for $FromSign <br>
					<b>Email</b> $email <br>
					<b>Mobile</b> $mobile <br>					
					<b>$inquiry_type message</b> $inquiry_message<br>
					";
	}
	
	$disp ="none";
	$msg = "<br><br><strong> - Your $inquiry_type submitted successfully</strong>."; 
	
	$mFrom     = $FromMailId;
	$mTo       = $email;
	$mBCC	   = "";
	$data 	   = array();
	$mSubject  = "Thanks for your $inquiry_type submitted with ".$SiteUrl;
	//$mMessage  =  getMailBody("Feedback", $data);
	
	send_mail($mFrom, $mTo, $mSubject, $mMessage, $mBCC);
	send_mail($email, $CustomerCareEmail, "New Feedback/Enquiry submitted on $FromSign", $mMessage, $mBCC);
}
?>

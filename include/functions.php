<?
	
function getpic($pic)
{
	$pic = trim("upload/".$pic);
	if (strpos($pic,"&") <= 0 && strpos($pic,",") <= 0)
	{
		if (!file_exists($pic))
		{
			$pic = str_replace("upload","../upload",$pic);
			if (!file_exists($pic))
				$pic = "images/small_image.png"	;
		}
	}	 
	else
		$pic = "images/small_image.png";
	
	return $pic;
}


function getItemPic($pic, $align='')
{
	
	if ($align=="") $align="Left";
	$pic = trim($pic);
	if (strpos($pic,"&") <= 0 && strpos($pic,",") <= 0)
	{
		if (!file_exists("upload/".$pic))
			$pic = ""	;	
		else
			$pic = "<img src='upload/$pic' align='$align' style='padding:5px' > ";
	}	
	else
		$pic = "";
		
	return $pic;
}

function send_mail($from, $to, $subject, $message, $bcc='', $Template='') 
{	
	$data = array($message);
	if ($Template=='')	
		$message = getMailBody("MailTemplate".$GLOBALS['StoreId'], $data);
	else
		$message = $data[0];
	
	if ($GLOBALS['SendMail'] == 1)
	{
		//send_mail_php($from, $to, $subject, $message, $bcc) ;
		//send_mail_1($from, $to, $subject, $message, $bcc);
		send_mail_local($from, $to, $subject, $message, $bcc); 
	}
}


function send_mail_local($from, $to, $subject, $message, $bcc="") 
{	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= "From: $from";
	if ($cc!="") $headers .= "\r\nBcc: $cc\r\n\r\n";
	if ($bcc!="") $headers .= "\r\nBcc: $bcc\r\n\r\n";

	$status = mail($to,$subject,$message,$headers);
	/*
	if ($status==0) 
		return "Some Error";
	else
		return "success";
		*/
}


function send_mail_1($from, $to, $subject, $message, $bcc="") 
{		
	$data = array($message);
	$message = getMailBody("MailTemplate".$GLOBALS['StoreId'], $data);
	
	if ($GLOBALS['SendMail'] == 1)
	{
		$SmtpUser= $GLOBALS['SMTPFromMail'];// write webmail user ID
		$SmtpPass= $GLOBALS['SMTPPassword']; // write user password for webmail.
		$SmtpServer= $GLOBALS['SMTPServer']; //leave intact
		$SmtpPort=$GLOBALS['SMTPPort']; //default 25 considered. Do not change unless you what is other port you should be using.
		//$bcc = "diveshsingh@yahoo.com";	
		require_once("smtp.mail.php");
		
		$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $message, $bcc);
		$SMTPChat = $SMTPMail->SendMail();
		if(!$SMTPChat)
			return "Some Error<br>";
	}
}

function send_mail_php($fromemail, $toemail, $subject, $message, $bcc="") 
{

	$SmtpUser= $GLOBALS['SMTPFromMail'];// write webmail user ID
	$SmtpPass= $GLOBALS['SMTPPassword']; // write user password for webmail.
	$SmtpServer= $GLOBALS['SMTPServer']; //leave intact
	$SmtpPort=$GLOBALS['SMTPPort']; //default 25 considered. Do not change unless you what is other port you should be using.
	$SmtpAuth=$GLOBALS['SMTPAuth']; 

	require_once("PHPMailerAutoload.php");
	$mail = new PHPMailer();
	//$mail->SetLanguage( 'en', 'phpmailer/language/' );
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
    $mail->Username = $SmtpUser;
    $mail->Password = $SmtpPass;
    $mail->Host = $SmtpServer;
    $mail->Port = $SmtpPort;
	$mail->SMTPSecure = $SmtpAuth;
	$mail->setFrom($fromemail);  
	
	$mail->AddAddress($toemail);  
	if ($attachment!="")
		$mail->AddAttachment($attachment);  
	$mail->WordWrap = 50;
	$mail->IsHTML(true);      
	//$mail->SMTPDebug = true;               	
	$mail->From = $fromemail;
	if ($bcc!="")
		$mail->AddBcc($bcc);
	$mail->Subject  =  $subject;
	$mail->Body = $message;   
	
	//$mail->addAttachment('/usr/labnol/file.doc');         // Add attachments
	//$mail->addAttachment('/images/image.jpg', 'new.jpg'); // Optional name

	$msg="";
	if(!$mail->Send())
	{
		$msg="Message was not sent <p>";
		$msg .="Mailer Error: " . $mail->ErrorInfo;
	}	
	return $msg ;
}

function SendSMS($mobile, $message)
{
	$mobile = str_replace("+91","",$mobile);
	$mobile = str_replace(" ","",$mobile);

	if ($mobile!="" && $message!="" && $GLOBALS['SendSMS'] == 1)
	{
		$url = "http://www.twowaysms.co.in/api/MessageCompose?admin=info@dextrousinfo.com&user=Publisher@upkar.in:C98W4Q1&senderID=UPKARP&receipientno=$mobile&msgtxt=$message&state=4";
		$url = str_replace(" ","%20",$url);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_POST, 1);
		$curl_scraped_page = curl_exec($ch);
		curl_close($ch);
		//echo $curl_scraped_page;
	}
	return "";
}


function get($input)
{
	if (isset($_REQUEST[$input]))
	{	
		return  str_replace("'","''", $_REQUEST[$input]);
	}
}


function dropdowns($grp,$selectedValue)
{
	$sql = "select * from code_mstr where code_fld='$grp' order by code_desc1, code_desc";
	$prod_arr = mysql_query($sql);
	while($row1=mysql_fetch_array($prod_arr))
	{
		$desc = $row1["code_desc"];
		$sel = "";
		if ($selectedValue == $row1["code_value"] || $selectedValue == $desc) $sel = "selected";
		$dropdowns = $dropdowns . "<option value='". $row1["code_value"] ."' ".$sel.">". $desc ."</option>";
	}
	return  $dropdowns;
}

function ddlCat($for,$selectedValue,$cat=0, $StoreId=1)
{
	$dropdowns = "<option value=''>--Select--</option>";
	$sql = "select cat_id, cat_title from category where cat_active = 1 and cat_store=$StoreId order by cat_seq, cat_title";
	if ($for=="subcat")
		$sql = "select subcat_id, subcat_title from subcategory where subcat_active = 1 and cat_id=$cat order by subcat_seq, subcat_title";
	$prod_arr = mysql_query($sql);
	while($row1=mysql_fetch_array($prod_arr))
	{
		$desc = ($row1[1]);
		$sel = "";
		if ($selectedValue == $row1[0] || $selectedValue == $desc) $sel = "selected";
		$dropdowns .= "<option value='". $row1[0] ."' ".$sel.">". $desc ."</option>";
	}
	return  $dropdowns;
}


function generate_image_thumbnail($source_image_path, $thumbnail_image_path, $type="")
{
	if ($type=="writer")
	{
		$THUMBNAIL_IMAGE_MAX_WIDTH= 78;
		$THUMBNAIL_IMAGE_MAX_HEIGHT= 100;
	}
	elseif ($type=="large")
	{
		$THUMBNAIL_IMAGE_MAX_WIDTH= 330;
		$THUMBNAIL_IMAGE_MAX_HEIGHT= 439;
	}
	else
	{
		$THUMBNAIL_IMAGE_MAX_WIDTH= 144;
		$THUMBNAIL_IMAGE_MAX_HEIGHT= 191;
	}
	
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }
    
	$source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $THUMBNAIL_IMAGE_MAX_WIDTH / $THUMBNAIL_IMAGE_MAX_HEIGHT;
	
    if ($source_image_width <= $THUMBNAIL_IMAGE_MAX_WIDTH && $source_image_height <= $THUMBNAIL_IMAGE_MAX_HEIGHT) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) ($THUMBNAIL_IMAGE_MAX_HEIGHT * $source_aspect_ratio);
        $thumbnail_image_height = $THUMBNAIL_IMAGE_MAX_HEIGHT;
    } else {
        $thumbnail_image_width = $THUMBNAIL_IMAGE_MAX_WIDTH;
        $thumbnail_image_height = (int) ($THUMBNAIL_IMAGE_MAX_WIDTH / $source_aspect_ratio);
    }
	
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
    imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    return true;
}

function getTitle($text, $chracter=25)
{
	//echo strlen($text);
	if (strlen(trim($text)) > $chracter)
	{
		for ($i=$chracter; $i < 200; $i++)
		{
			if (substr($text,$i,1)==" ")
			{
				//echo $i;
				break;
			}
		}
		$chracter = $i;
		$text = substr($text, 0, $chracter)."...";
	}
	return $text;		
}

function fn_ddl($for, $sel="", $Store="")
{	
	if ($Store!="")	$extra = " and code_desc5 = '$Store'";
	$str = "<option value=''>---Select---</option>";
	$sql = "select * from code_mstr where code_fld = '$for' and active=1 $extra order by code_desc1, code_desc ";
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		if (strpos($sel,$row[2]) > -1) $sele = " selected ";
		$str = $str. "<option value='". $row[2] . "' ". $sele.">". $row[3]."</option>";
		$sele = "";
	}
	return $str;
}

function getProdRatings($pid)
{
	$nn=0;
	$sql = "select * from reviews where prod_id=$pid and active=1";
	$prod_arr1 = mysql_query($sql);
	while($rr=mysql_fetch_array($prod_arr1))
	{		
		$ratecnt = $ratecnt+$rr["ratings"];
		$nn++;
	}
	$rating = array("Average" => round(($ratecnt/$nn),0), "ReviewsCnt" => $nn );
	return $rating;
}

function getBanner($StoreId,$page, $loc)
{
	//echo "$StoreId,$page, $loc";
	 if ($page=="index.php" && $loc=="Main") 
	 {
		 $w100="w100";
	 	$div= '<div class="core-slider_item">';
		$divclose= "</div>";
	 }
	 $banner = "";
	 $sql = "select * from banner
			where active=1 
			and store_id = $StoreId 
			and '". date('Y-m-d') ."' between start_date and end_date 
			and page = '$page'
			and banner_location =  '$loc'
			order by sort";	
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{				
		if ($row["url"] != "")
		    $banner = $banner .  "$div <a href='include/banner.php?bid=". $row["banner_id"] ."' target=_new><img  src='upload/banners/".$row["image"]."' class='".$w100." img-responsive w100' alt=''></a> $divclose\n";
		else
		    $banner = $banner .  "$div <img src='upload/banners/".$row["image"]."' class='img-responsive ".$w100."' alt=''> $divclose\n";
		
		// Update status
		$sql = "update banner set view = (view+1) where banner_id = ".$row["banner_id"];	
		mysql_query($sql);
	}
	
	
	return $banner;	
}


function GetCurrencyRate($ProdId, $rateType)
{
    $sql = "select code_value from code_mstr, products where code_desc=prod_mrp_currency and code_fld = 'CurrencyConversion' and prod_id=$ProdId";
	if ($rateType == "M")
		$sql = "select code_value from code_mstr, products where code_desc=prod_currency and code_fld = 'CurrencyConversion' and prod_id=ProdId";
	
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		$GetCurrencyRate = $row["code_value"];
	}
	if ($GetCurrencyRate=="") $GetCurrencyRate=1;
	return $GetCurrencyRate;	
}

///---------- Related to discounts--------------
function GetFinalPrice($ProdId, $MRP)
{
	$today = date("Y-m-d");

	$GetFinalPrice1 = $MRP;
	if ($_SESSION["usertype"] == "trader")
	{
		$userid = $_SESSION["id"];		
		if ($userid=="") $userid = 0;
		$sql = "select count(*) from discountmaster where '$today' between start_date and end_date and active=1";	
		$det_arr = mysql_query($sql);
		$row = mysql_fetch_array($det_arr);
		if ($row[0] > 0)
			$GetFinalPrice1 = GetDiscountedPrice($userid, $ProdId, $MRP);
	}
	else
	{
		$sql = "select count(*) from discountmaster where discount_user = 0 AND '$today' between start_date and end_date and active=1";	
		$det_arr = mysql_query($sql);
		$row = mysql_fetch_array($det_arr);
		if ($row[0] > 0)
			$GetFinalPrice1 = GetDiscountedPrice(0, $ProdId, $MRP);
		else
			$GetFinalPrice1 = $MRP;	
	}
	return round($GetFinalPrice1,0);	
}

// Get Discount
function GetDiscountedPrice($userid, $ProdId, $MRP)
{
	$today = date("Y-m-d");
	// echo( "<p>" .$userid . " - ". $ProdId . " - ". $MRP . "<br>" );
	$showtype = 0; //Flag Trun off / on
	$DiscPrice = 0;
		
	/// Get discount based on Book
	if ($DiscPrice==0) 	
		$DiscPrice = GetDiscountsOnLevels($userid,$ProdId,$MRP,"Book","prod_code",$showtype);

	/// Get discount based on Publiser
	if ($DiscPrice==0) 	
		$DiscPrice = GetDiscountsOnLevels($userid,$ProdId,$MRP,"Publisher","prod_publisher",$showtype);

	/// Get discount based on Sub Category
	if ($DiscPrice==0) 	
		$DiscPrice = GetDiscountsOnLevels($userid,$ProdId,$MRP,"Sub Category","prod_subcat",$showtype);

	/// Get discount based on Category
	if ($DiscPrice==0) 	
		$DiscPrice = GetDiscountsOnLevels($userid,$ProdId,$MRP,"Category","prod_cat",$showtype);

	/// Get discount based on Traders	
	if ($_SESSION["usertype"] == "trader")
	{
		if ($userid > 0 && getValue("select count(*) from DiscountMaster where DiscountUser = $userid and active=1") == 0)
		{
			$sql = "select * from discountmaster where discount_user = $userid and discount_type='Traders' AND '$today' between start_date and end_date and active=1";	
			$det_arr = mysql_query($sql);
			while($row=mysql_fetch_array($det_arr))
			{
				if ($ShowType==1) echo ($Type);						
				$DiscPrice = DiscountedRate($MRP, $row["discount_calc"], $row["discount_value"]);
			}
		}
	}

	if ($DiscPrice==0) 
		return $MRP;
	else
		 return $DiscPrice;	
}	


function GetDiscountsOnLevels($userid,$ProdId,$MRP,$Type,$Col, $ShowType=0) 
{
	$StoreId =$GLOBALS['StoreId'];
	//echo "$userid,$ProdId,$MRP,$Type,$Col, $ShowType<br>";
	//echo "<br>";
	$today = date("Y-m-d");
	$sql = "select * from discountmaster where discount_user = $userid and discount_type='$Type' AND '$today' between start_date and end_date and store_id=$StoreId and active=1 order by end_date limit 0,1";	
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		$catids = $row["discount_items"];				
		if ($Type!="Coupon")
		{	
			//echo "Select count(*) from products where prod_id = $ProdId and $Col in ($catids)";	
			if (getValue("Select count(*) from products where prod_id = $ProdId and $Col in ($catids)") > 0)
			{
				if ($ShowType==1) echo ($Type);						
				$DiscPrice = DiscountedRate($MRP, $row["discount_calc"], $row["discount_value"]);
			}
		}
		else
		{
			if ($catids == $row["discount_items"])
			{
				if ($ShowType==1) echo ($Type);						
				$DiscPrice = DiscountedRate($MRP, $row["discount_calc"], $row["discount_value"]);
			}			
		}
	}
	return $DiscPrice;
}


// Calculate final Price
function DiscountedRate($MRP, $DiscType, $DiscVal)
{
	//echo "$MRP, $DiscType, $DiscVal ";
	if ($MRP > 0) 
	{
		if ($DiscType == "Percentage")		
			$DiscountedRate = round($MRP - ($MRP * $DiscVal/100),2);		
		else
			$DiscountedRate = $MRP - $DiscVal;		
	}
	return $DiscountedRate;
}

function GetCouponDiscounts($Amount, $Coupon, $userid=0) 
{
	$StoreId = $GLOBALS['StoreId'];
	$today = date("Y-m-d");
	$sql = "select * from discountmaster where store_id = $StoreId and discount_items='$Coupon' and discount_coup_max > 0 and discount_user = $userid and discount_type='Coupon' AND '$today' between start_date and end_date and active=1";	
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{				
		$DiscPrice = DiscountedRate($Amount, $row["discount_calc"], $row["discount_value"]);
		$DiscPrice = $Amount-$DiscPrice;
	}
	
	return $DiscPrice;
}



function fn_link($page)
{
	$link = "";
	if ($GLOBALS['urlRewite'] == true) 
	{
		$link = str_replace("&","-",str_replace("=","-",str_replace(".php?","-",$page))) ;
		$link = str_replace(".php","",$link);
		$link = str_replace("/",", ",$link);
		$link = str_replace("%2F",", ",$link);
		$link = str_replace(" ","-",$link);
	
	}
	else
		$link = $page;
	return $link;
}

/// Discount on Total Amount
function getDiscountOnTotal($TotalAmount)
{
	$DiscPrice = 0;
	$sql = "select * from code_mstr where code_fld = 'DiscountOnTotal' and active=1";	
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		if  ($TotalAmount >= (int)$row["code_desc"] && $TotalAmount <=  (int)$row["code_desc1"])
			$DiscPrice = round($TotalAmount *  $row["code_value"]/100);	
	}
	return $DiscPrice;
}

/// Shipping on Total Amount
function getShipping($TotalAmount)
{
	//echo $TotalAmount;
	$DiscPrice = 0;
	$sql = "select * from code_mstr where code_fld = 'ShippingChg' and active=1";	
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		if ($TotalAmount >= (int)$row["code_desc"] && $TotalAmount <=  (int)$row["code_desc1"])
			$DiscPrice = $row["code_value"];			
	}
	return $DiscPrice;
}


/// Get single Value from code master
function getCodeValue($CodeFld, $Field='')
{
	$Value = 0;
	if ($CodeFld=="ProdEmailList") $Value = "";
	if ($Field=="") $Field = " code_value";
	$sql = "select $Field from code_mstr where code_fld = '$CodeFld' and active=1";	
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		if ($CodeFld=="ProdEmailList") 
			$Value .= $row[0];	
		else
			$Value = $row[0];		
	}
	return $Value;
}

// Create Mail Body from templates
function getMailBody($mBody, $Data)
{
	$Body = getValue("Select code_desc from code_mstr where code_fld = 'MailTemplate' and code_value = '$mBody'");
	for ($i=0; $i< count($Data); $i++)
	{
		$Body = str_replace("[$i]", $Data[$i], $Body);
	}
	return  $Body;
}

function getCMValue($group, $value, $output="")
{
	$col = " code_desc ";
	if ($output!="")
		$col = $output;
	return getValue("Select $col from code_mstr where code_fld = '$group' and code_value = '$value'");
}

function insertAddess($input)
{
	 $sql = "INSERT INTO  address  Set 
			`uid` ='". $input[0] ."',
			`address_type` ='". $input[1] ."',
			`cname` ='". $input[2] ."',
			`name` ='". $input[3] ."',
			`address1` ='". $input[4] ."',
			`address2` ='". $input[5] ."',
			`city` ='". $input[6] ."',
			`state` ='". $input[7] ."',
			`country` ='". $input[8] ."',
			`pin` ='". $input[9] ."',
			`tel_res` ='". $input[10] ."',
			`mobile` ='". $input[11] ."',
			`email` ='". $input[12] ."',
			`active` = '1' ";
	
	$det_arr = mysql_query($sql);
	return getValue("select @@identity");
			
}

function getAddress($type, $aid)
{
	//if ($type!="") $extra = " and address_type='$type'";
	$sql = "select * from address a where aid = $aid $extra";
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	if ($num_rows>0)
	{
		$row=mysql_fetch_array($result);
		
		$ShippingAddress = $ShippingAddress . $row["name"]. "<br>";
		if ($row["cname"]!= "" ) $ShippingAddress = $ShippingAddress . $row["cname"]. "<br>";
		$ShippingAddress = $ShippingAddress . $row["address1"]. "<br>";
		$ShippingAddress = $ShippingAddress . $row["city"]. " ". $row["pin"]. "<br>";
		$ShippingAddress = $ShippingAddress . $row["state"]. "-". $row["country"]. "<br>";
		if ($row["tel_res"]!= "" ) $ShippingAddress = $ShippingAddress . "Phone: " . $row["tel_res"]. "<br>";
		$ShippingAddress = $ShippingAddress . "Mobile: " . $row["mobile"]. "<br>";
		if ($row["email"]!= "" && $type=="") 
		{
			$ShippingAddress = $ShippingAddress . "Email: " . $row["email"] ;
			//$_SESSION["BillingEmail"] =  $row["email"];
		}
		if ($type=="arr")
			$ShippingAddress = $row;
	}
	return $ShippingAddress;
}


function update_order($id, $via, $referance, $action="")
{
	if ($action=="PaymentPending")
	{
		$status = "Order Received - Payment Pending";
		$order_action = "4";
		//$extra = " , o_active = 0,  order_can = now() ";
	}
	if ($action=="PaymentReceived")
	{
		$status = "Payment Received - Despatch Pending";
		$order_action = "5";
		$extra = ", payment_date = now() ";
	}
	if ($action=="Complete" && $referance!="")
	{
		$via_desc = getCMValue("ShippingOpt",$via);
		$status = "Order shipped via $via_desc, shipping referance $referance";
		$order_action = "6";
		$extra = ", order_delivery = now()";
	}
	
	if ($action=="Cancel")
	{
		$status = "Order cancelled.";
		$order_action = "7";
		$extra = " , o_active = 1,  order_can = now() ";
	}

	
	$sql="insert into order_tracking set order_id=$id, action='$action', status='$status', referance='$referance', del_mode='$via', created_date=now()";
	mysql_query($sql);
	
	$sql="update orders set order_action = $order_action, order_status='$status' $extra where order_id= $id";
	$query1=mysql_query($sql);
	return "<br>Order #$id Status Updated...";
}

function save_profile($email,$name)
{
	$sql = "select * from users where email = '$email'";
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	if ($num_rows > 0) 
	{
		$url = "account.php?page=dashboard";
		if ($_SESSION["redirect"] != "") $url = $_SESSION["redirect"];
		$_SESSION["username"] = "";
		$_SESSION["userid"] ="";
		$_SESSION["email"] ="";
		$sql = "select * from users where email = '$email'";
		$prod_arr = mysql_query($sql);	
		while($row=mysql_fetch_array($prod_arr))
		{		     		
			 $sid = session_id();
			 $que = "update cart set user_id=".$row["id"]." where sessionid = '$sid'";
			 mysql_query("update users set login=now() where id =".$row["id"]);	
			 $_SESSION["username"] = $row["name"];
			 $_SESSION["userid"] = $row["id"];
			 $_SESSION["email"] = $row["email"];
			 $_SESSION["redirect"]="";		 
			 mysql_query($que);	
			 echo "<script>parent.location.href='$url';</script>";
		}
	}
	else
	{
		$StoreId =$GLOBALS['StoreId'];
		$sql = "insert into users (name, email, password, active, rights, newsletter, school) values('$name','$email','$password',1,1,'$newsletter','$StoreId,FB')";
		mysql_query($sql);
		mysql_query("update users set login=now() where email ='$email'");	
		echo "<script>parent.location.href='$url';</script>";
	} 
}

?>
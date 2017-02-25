<div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp aj animated animated" style="visibility: visible; -webkit-animation-name: fadeInUp; animation-name: fadeInUp;">
	<div class="more-info-tab clearfix ">
  		<h3 class="new-product-title pull-left"><b class="copN"> Personal </b> <b class="copR">Profile</b></h3>
	</div>
                <?
	//echo $_SESSION["username"];
	if ($_SESSION["admin"] == "")
		$uid = $_SESSION["userid"];
		
	if (get("Submit3")!= "")
	{
		$cname = get("cname");
		$name = get("name");
		$address1 = get("address1");
		$address2 = get("address2");
		$city = get("city");
		$state = get("state");
		$pin = get("pin");
		$country = get("country");
		$tel_res = get("tel_res");
		$tel_off = get("tel_off");
		$fax = get("fax");
		$mobile = get("mobile");
		
		$sql = "update users Set cname='$cname',name='$name',address1='$address1',
				address2='$address2',city='$city',state='$state',pin='$pin',country='$country',
				tel_res='$tel_res',tel_off='$tel_off',fax='$fax',mobile='$mobile'
				where id=$u_id ";
		mysql_query($sql);
		
		$msg = "Information updated.<br>";
	}
	$country = "India";
	$sql = "select * from users where id=". $uid;
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	if ($num_rows>0)
	{			
		$row=mysql_fetch_array($result);	
		$cname = $row["cname"];			
		$name = $row["name"];
		$address1 = $row["address1"];
		$address2 = $row["address2"];
		$city = $row["city"];
		$state = $row["state"];
		$pin = $row["pin"];
		$country = $row["country"];
		$tel_res = $row["tel_res"];
		$tel_off = $row["tel_off"];
		$fax = $row["fax"];								
		$mobile = $row["mobile"];
		$email = $row["email"]; //mysql_query("select email from users where id=". u_id)(0)	
	}
	$button = "Update";
?>
		<form  method="post" name="form2" action="<? echo  $action ?>" id="form2" onsubmit="return valid(this)">
        <script = javascript>
	function valid(a)
	{ 
		if (a.name.value=="")
			{
			alert ("Enter Your Name...")
			a.name.focus();
			return false;
			}
		if (a.address1.value=="")
			{
			alert ("Enter address...")
			a.address1.focus();
			return false;
			}
		if (a.city.value=="")
			{
			alert ("Enter city...")
			a.city.focus();
			return false;
			}
		if (a.state.value=="")
			{
			alert ("Enter state...")
			a.state.focus();
			return false;
			}			
		if (a.mobile.value=="")
			{
			alert ("Enter mobile...")
			a.mobile.focus();
			return false;
			}
		
			
	
		return true;
		}
	</script>  
 			<div class="col-md-6 ">
				<div class="form-group">
		    		<input type="text" name="cname" maxlength="100" value="<? echo $cname?>" size="30" class="form-control unicase-form-control text-input" placeholder="Company Name">
		  		</div>
	 		</div>
        	<div class="col-md-6 ">
				<div class="form-group">
		    		<input type="text" name="name" maxlength="50" value="<? echo $name?>" size="20" class="form-control unicase-form-control text-input" placeholder="Name">
                    <font color="#FF0000">
            <input type="hidden" name="id" id="id" value="<? echo $uid?>" />
            </font>
		  		</div>
	 		</div>
      		<div class="col-md-6 ">
				<div class="form-group">
		    		<input type="text" name="address1" maxlength="50" value="<? echo $address1?>" size="20" class="form-control unicase-form-control text-input" placeholder="Address">
		  		</div>
			</div>
      		<div class="col-md-6 ">
				<div class="form-group">
		    		<input type="text" name="city" maxlength="20" value="<? echo $city?>" size="20" class="form-control unicase-form-control text-input" placeholder="City">
		  		</div>
	   		</div>
      		<div class="col-md-6 ">
				<div class="form-group">
                <? 
						$vis ="inline";
						$vis1 ="inline" ;
						if ($country == "India") $vis ="none" ;
						if ($country != "India") $vis1 ="none" ;
						//response.write country&"fff"
						?>
                        <input type="text" name="state" id="state" maxlength="20" value="<? echo $state?>" size="12" style="display:<? echo $vis?>" class="form-control unicase-form-control text-input" placeholder="State">
		    <select name="stateid" id="stateid" onchange="fn_fillstate(this)" style=" display:<? echo $vis1?>; height:43px;" class="form-control unicase-form-control text-input">
                      <option>-- Select --</option>
              			<? echo dropdowns("State", $state) ?>                                      
						</select>
                        <script>
				function fn_fillstate(arg)
				{
					var x=document.getElementById("stateid").selectedIndex;
					var y=document.getElementById("stateid").options;
					document.form2.state.value = y[x].text;
				}
				</script>
		  		</div>
	  		</div>
            <div class="col-md-6 ">
				<div class="form-group">
		    		<input type="text" name="pin" size="8" maxlength="6" value="<? echo $pin?>" class="form-control unicase-form-control text-input" placeholder="Pincode">
		  		</div>
	  		</div>
         	<div class="col-md-6 ">
    			<div class="form-group">
		   			<select name="country" id="country" onchange="fn_reset_state()"  style="position:absolute; top:0px; width:91%;" class="form-control unicase-form-control text-input">
                    	<option>-- Select --</option>
              			<? echo dropdowns("country",$country) ?>                                        </select>
                        <script>
				function fn_reset_state()
				{
					document.form2.state.value =""
					document.form2.state.style.display = "inline"
					document.form2.stateid.style.display = "none"
					var x=document.getElementById("country").selectedIndex;
					var y=document.getElementById("country").options;																
					if (y[x].text=="India")
					{
						document.form2.state.style.display = "none";
						document.form2.stateid.style.display = "inline";
					}
				}								
			  </script>
		  		</div>
	  		</div>
       		<div class="col-md-6 ">
				<div class="form-group">
		    		<input type="text" name="tel_res" maxlength="20" value="<? echo $tel_res?>" size="20" class="form-control unicase-form-control text-input" placeholder="Telepho No.">
		  		</div>
	   		</div>
         	<div class="col-md-6 ">
				<div class="form-group">
		    		<input type="text" name="mobile" maxlength="20" value="<? echo $mobile?>" size="20" class="form-control unicase-form-control text-input" placeholder="Mobile">
		  		</div>
	 		</div>
            <? if($_SESSION['username']!="") {?>
            <div class="col-md-6 ">
				<div class="form-group">
		    		<input type="email" name="email" maxlength="20" value="<? echo $email?>" size="20" class="form-control unicase-form-control text-input" placeholder="Email">
		  		</div>
	 		</div>
            <? } ?>
            <div class="col-md-12">
				<div class="form-group">
		    		<div style="text-align:center;color:red"> <? echo $msg; ?>
		  		</div>
	  		</div>
       		<div class="col-md-12">
				<div class="form-group">
		    		<button name="Submit3" type="submit" value="<? echo $button ?>" class="btn-upper btn btn-primary checkout-page-button"><? echo $button ?></button>
		  		</div>
	  		</div>
    
 </form>   
                
     </div>
<?
	$page = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	$u_id = $_SESSION["userid"];
	$country="India";
	$aid = get("aid");
	
	if ($aid > 0 && get("del")=="yes")
	{
		$sql = "delete from address where aid=$aid and uid = ".$u_id;
		mysql_query($sql);
		$mess="Information deleted sucessfully";
	}
	
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
		$email = get("email1");
		$mobile = get("mobile");
		$defaultadd = 0	;
		if (get("defaultadd") == "1")
			$defaultadd=1;
		
		$sql = "select * from address where aid = $aid and uid = ".$u_id;
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		if ($num_rows==0)
		{
			$sql = "insert into address Set uid = '$u_id',cname='$cname',name='$name',address1='$address1',
					address2='$address2',city='$city',state='$state',pin='$pin',country='$country',  email='$email',
					tel_res='$tel_res',tel_off='$tel_off',fax='$fax',mobile='$mobile',defaultadd='$defaultadd'";
			
		}
		else
		{
			$sql = "update address Set uid = '$u_id',cname='$cname',name='$name',address1='$address1',
					address2='$address2',city='$city',state='$state',pin='$pin',country='$country', email='$email',
					tel_res='$tel_res',tel_off='$tel_off',fax='$fax',mobile='$mobile',defaultadd='$defaultadd' 
					where aid=$aid and uid = $u_id ";
		}
		//echo $sql;
		mysql_query($sql);
		if ($aid == 0)
		{
			$result = mysql_query("select @@identity");
			$row=mysql_fetch_array($result);
			$aid =$row[0];
		}
		if ($defaultadd==1)			
			mysql_query("update address Set defaultadd = 0 where uid = $u_id");

		$mess="Information updated sucessfully";
		if ($action == "shipping.php")
			echo  "<script>location.href='order.php?aid=$aid';</script>";
		$aid=0;
	}	
	
	if ($u_id != "")
	{
		$sql = "select * from address where uid=$u_id";
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);				
		if ($num_rows == 0)
		{
			$sql = "select * from users where id=$u_id ";
			$aid=0;	
			$defaultadd = "Checked"	;
		}
		else
		{			
			$sql = "select * from address where uid=$u_id and defaultadd=1";
			if ($aid != "") 
				$sql = "select * from address where uid=$u_id and aid =$aid";
		}	
		//echo  $sql;
		$country = "India";
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		while($row=mysql_fetch_array($result))
		{
			if ($aid == "") $aid = $row["aid"];
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
			$email = $row["email"];								
			$mobile = $row["mobile"];
			if ($aid > 0) 
			{
				if ($row["defaultadd"]==1) $defaultadd = "checked";
				if ($row["active"]==1) $active = "checked";
			}
		}		
	}
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
<div align="center" style="color:red"><? echo  $mess ?></div>
	<div class="col-md-6 border">
    	<div class="more-info-tab clearfix ">
    		<h4 class="new-product-title pull-left"><b class="copN"> Select from previous </b> <b class="copR">shipping addresses </b></h4>
        </div>
        <div style="overflow:auto; height:400px">
        <?
			$sql = "select * from address where uid=$u_id"; 
			$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);
			
			while($row1=mysql_fetch_array($result))
			{
				$selaid = $row1["aid"];
				//$AddressInfo = $AddressInfo . "<br>" . $row1["cname""];
				$AddressInfo = $AddressInfo .  $row1["name"];
				$AddressInfo = $AddressInfo . "<br>" . $row1["address1"];
				if ($row1["address2"]!="")		
					$AddressInfo = $AddressInfo . "<br> Landmark: " . $row1["address2"] ."<br>";							

				$AddressInfo = $AddressInfo . $row1["city"];							
				$AddressInfo = $AddressInfo . ", " . $row1["state"];
				
				$AddressInfo = $AddressInfo . "-" . $row1["pin"];
				$AddressInfo = $AddressInfo . " (" . $row1["country"] . ")";
				//$AddressInfo = $AddressInfo . "<br>" . $row1["tel_off"];
				//$AddressInfo = $AddressInfo . "<br>" . $row1["fax"];
				$AddressInfo = $AddressInfo . "<br>Phone: " . $row1["tel_res"];
				$AddressInfo = $AddressInfo . "<br>Mobile: " . $row1["mobile"];
				$AddressInfo = $AddressInfo . "<br>Email: " . $row1["email"];
				
				$star ="";
				$chk = "";
				if ($row1["defaultadd"]==1) $star ="#FFD9D9";
				if ($selaid == $aid) $chk = "checked";
			?>
		<div class="m5 p5 fs11" style="border:#000000 solid 1px; padding:10px; margin-bottom:10px; background-color:">
      		<? echo $AddressInfo ?><br />
            <? if ($Edit == "Edit"){ ?>
            <a href="<? echo $page ?>&aid=<? echo $selaid ?>&del=yes"><strong>Delete</strong></a>
            <? } ?>
        	<input type="button" value="Select" name="add"  onclick="document.getElementById('aid').value='<? echo  $selaid ?>'; document.form2.submit()" class="btn" style="margin-bottom:10px;">
    	</div>
        <?
				$AddressInfo = "";
			}
			
			?>
 	</div>
    <? if (strpos($page,"?") > 0 ) {?>
        	<a href="<? echo $page ?>&aid=0"><strong>Add New Address</strong></a><br />
        <? } else { ?>
        	<a href="<? echo $page ?>?aid=0"><strong>Add New Address</strong></a><br />
        <? }?>
        <em> Red = Default Address</em>
	</div>
    <div class="col-md-b border2">
    	<div class="more-info-tab clearfix ">
        	<h4 class="new-product-title pull-left">
            	<b class="copN"> OR Enter a new</b> <b class="copR">shipping addresses </b>
     		</h4>
       	</div>
        <div class="col-md-12 ">
			<div class="form-group">
		    	<input type="text" name="cname" maxlength="100" value="<? echo $cname?>" size="30" class="form-control unicase-form-control text-input" placeholder="Company Name">
		  	</div>
			</div>
		<div class="col-md-12 ">
			<div class="form-group">
		    	<input type="text" name="name" maxlength="50" value="<? echo $name?>" size="20" class="form-control unicase-form-control text-input" placeholder="Name">
                <font color="#FF0000">
              	<input type="hidden" name="aid" id="aid" value="<? echo $aid?>" />
              </font>
		  	</div>
	 	</div>
   		<div class="col-md-12 ">
			<div class="form-group">
		    	<input type="text" name="address1" maxlength="20" value="<? echo $address1?>" size="20" class="form-control unicase-form-control text-input" placeholder="Address">
		   	</div>
	  	</div>
        <div class="col-md-12 ">
			<div class="form-group">
		    	<input type="text" name="address2" maxlength="20" value="<? echo $address2?>" size="20" class="form-control unicase-form-control text-input" placeholder="Landmark">
		   	</div>
		</div>
   		<div class="col-md-12 ">
			<div class="form-group">
		    	<input type="text" name="city" maxlength="20" value="<? echo $city?>" size="20" class="form-control unicase-form-control text-input" placeholder="City">
		  	</div>
	 	</div>
  		<div class="col-md-12 ">
			<div class="form-group">
            	<input type="text" name="state" id="state" maxlength="20" value="<? echo $state?>" size="12" style="display:<? echo $vis?>" class="form-control unicase-form-control text-input" placeholder="State">
		    	<select name="stateid" style="position:absolute; top:0px; width:91%;" id="stateid" onchange="fn_fillstate(this)" style="display:<? echo $vis1?>" class="form-control unicase-form-control text-input">
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
        <div class="col-md-12 ">
			<div class="form-group">
		    	<input type="text" name="pin" size="8" maxlength="6" value="<? echo $pin?>" class="form-control unicase-form-control text-input" placeholder="Pincode">
		  	</div>
	 	</div>              
        <div class="col-md-12 ">
			<div class="form-group">
		   		<select name="country" id="country" onchange="fn_reset_state()" class="form-control unicase-form-control text-input">
      				<option>-- Select --</option>
                	<? echo dropdowns("country",$country) ?>                                       
   				</select>
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
      	<div class="col-md-12 ">
			<div class="form-group">
		    	<input type="text" name="tel_res" maxlength="20" value="<? echo $tel_res?>" size="20" class="form-control unicase-form-control text-input" placeholder="Telepho No.">
		  	</div>
		</div>
   		<div class="col-md-12 ">
			<div class="form-group">
		    	<input type="text" name="mobile" maxlength="20" value="<? echo $mobile?>" size="20" class="form-control unicase-form-control text-input" placeholder="Mobile">
		  	</div>
		</div>
        <div class="col-md-12">
			<div class="form-group">
		    	<input type="email" name="email1" value="<? echo $email?>" size="20" class="form-control unicase-form-control text-input" placeholder="Email">
		  	</div>
		</div>
       	<div class="col-md-12 ">
			<div class="form-group">
		     	<input type="checkbox" name="defaultadd" value="1"  <? echo $defaultadd?> placeholder="Password..." class="check mt2">
      			<dd class="btn-md style1 fl pl10">Default Address:</dd>
		  	</div>
		</div>
        <div class="col-md-12">
			<div class="form-group">
		    	<button name="Submit3" type="submit" class="btn-upper btn btn-primary checkout-page-button" value="<? echo $button ?>"><? echo $button ?></button>
		  	</div>
	 	</div>
     </div>
</form>
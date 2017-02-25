<?
if (get("Submit")!= "")
{
	$u_id = $_SESSION["userid"];
	$pwd = get("newpassword");
	mysql_query("update users set password='$pwd' where id = ".$u_id);
	$mess="Information updated sucessfully<br>";
}
?>
<script>
			function validate(obj)
			{
				if (obj.password.value =="")
				{
					alert("Enter old password");
					obj.password.focus();
					return false;
				}
				if (obj.newpassword.value.length <6)
				{
					alert("Please enter 6 or more characters in new password");
					obj.newpassword.focus();
					return false;
				}
				if (obj.newpassword.value =="")
				{
					alert("Enter new password");
					obj.newpassword.focus();
					return false;
				}
				if (obj.conpassword.value =="")
				{
					alert("Enter confirm password");
					obj.conpassword.focus();
					return false;
				}
				
				if (obj.conpassword.value != obj.newpassword.value)
				{
					alert("New password and confirm password must match");
					obj.conpassword.focus();
					return false;
				}
			}
			
			</script>
            <form name="form1" method="post" action="" onSubmit="return validate(this)">
<div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp aj animated animated" style="visibility: visible; -webkit-animation-name: fadeInUp; animation-name: fadeInUp;">
	<div class="more-info-tab clearfix ">
		<h3 class="new-product-title pull-left"><b class="copN"> Change </b> <b class="copR">Password</b></h3>
 	</div>
 	<div class="col-md-6 ">
		<div class="form-group">
			<input type="password" name="password" class="form-control unicase-form-control text-input" placeholder="Old Password">
    	</div>
 	</div>
  	<div class="col-md-6 ">
		<div class="form-group">
			<input type="password" name="newpassword" class="form-control unicase-form-control text-input" placeholder="New Password">
		</div>
 	</div>
  	<div class="col-md-6 ">
		<div class="form-group">
			<input type="password" name="conpassword" class="form-control unicase-form-control text-input" placeholder="Confirm Password">
		</div>
 	</div>
 	<div style="clear:both;"></div>
  	<div class="col-md-2">
		<div class="form-group">
			<button type="submit" name="Submit" value="Update" class="btn-upper btn btn-primary checkout-page-button">Update</button>
		</div>
 	</div>
   	<div class="col-md-2">
		<div class="form-group">
			<button type="reset" name="Submit2" value="Reset" class="btn-upper btn btn-primary checkout-page-button">Reset</button>
		</div>
   	</div>
</div>
</form>
// cart blinking

function fn_click_wish_blink(pid_wish,qty_wish)
	{ 
		//alert(pid_wish);
		$.post("include/cartinc.php",
		
		{
		  prod_idwish:pid_wish,
		  prod_qtywish:qty_wish,
		  add_wish:"wish_yes"
		},
		function(data,status){ 
		 if (data!="error")
		 {
			
			 $(".item_count_show12_wish").html(data);	
		 }
		});	

	}
	
	
	// wishlist blinking

function fn_crtclikk(pid2,qty2)
	{ 
		//alert(pid2);
		$.post("include/cartinc.php",
		
		{
		  prod_id12:pid2,
		  prod_qty1:qty2,
		  add2:"yes2"
		},
		function(data,status){ 
		 if (data!="error")
		 {
			
			 $(".item_count_show12").html(data);	
		 }
		});	

	}


//slide_show cart


		function fn_click()
		{
		$('#div12').load('slide_show.php');
		
		}  
//slide_show wishlist
function fn_click_wish()
		{
		$('#div_wishlist').load('slide_show_wishlist.php');
		
		}  

function fn_click_wish1()
		{
			//alert();
		$('#div_wishlistcount').load('slide_show_wishlist.php #wish_count');
		
		} 

function fn_s11lide_load(ses,qty4)
	{ alert();
		$.post("include/cartinc.php",
		
		{
		  sesid:ses,
		  prod_qty4:qty4,
		  ses:"ses"
		},
		function(data,status){ 
		 if (data!="error")
		 {
			
			 $(".slideshowdiv").html(data);	
		 }
		});	
	}	
	
// JavaScript Document

//Login
	function fn_login()
	{ 
		$("#lmsg").html("");
		$.post("include/login.php",
		{
		  email:$("#lemail").val(),
		  password:$("#lpassword").val(),
		  url:''
		},
		function(data,status){ 
		  if (data!="")
		  	 $("#lmsg").html(data);
		  else
		  {
			 //location.href="onepage.php";
		  }
		});	
	}

	function fn_resetpwd()
	{ 
		$("#msg").html("");
		$.post("include/forgot-password.php",
		{
		  email:$("#femail").val(),
		  password:$("#lpassword").val(),
		  url:''
		},
		function(data,status){ 
		  if (data=="Success")
		  {
		  	 $("#msg").html("We send your details at your email id. Please check your email for the details. Thank you...");
			 $("#fm-form").hide();
		  }
		  else
		  {
			 $("#msg").html(data);
		  }
		});	
	}
// Shopping Cart
	function fn_loadcart()
	{ 
		$.post("include/cart.php",
		{
		},
		function(data,status){ 
		  $("#cart_items").html(data);
		});	
	}
	
	function fn_getFunction(fn,inp,id)
	{ 
		alert(fn);
		alert(inp);
		alert(id);
		$.post("include/functions_result.php",
		{
			fn:fn,
			in:inp
		},
		function(data,status){ 
		  $("#"+id).html(data);
		});	
	}

	function fn_addcart(pid,qty)
	{ 
		$("#CartBox").hide();
		$("#WishBox").hide();
		$.post("include/cartinc.php",
		{
		  prod_id1:pid,
		  prod_qty1:qty,
		  add:"yes"
		},
		function(data,status){ 
		  //alert(data);
		  if (data=="OutOfStock")
		  	 alert('Sorry! This book is out of stock.');
		  else if (data=="MixedStock")
		  	 alert('Books can\'t be ordered with Pre order books. \nPlease make two seprate order for each.');
		  else if (data=="MixedPre")
		  	 alert('Pre order books can\'t be ordered with other books. \nPlease make two seprate order for each.');
		  else
		  {
			  //alert(data);
			  $(".cart-summ").html(data);
			
			  if (qty!=1111)
			  {
				 $("#pop-CartAmt").html($("#CartAmount").html()); 
			  	 $("#CartBox").show();
			  }
			  else
			  {
				 //$("#pop-CartAmt").html($("#CartAmount").html()); 
			  	 $("#WishBox").show();
			  }
			  /*
			  if (qty==1)
				//alert("1 item added into cart.");
			  else
				//alert("1 item added into wish list.");
				*/
		  }
		  if (data=="MixedStock" || data=="MixedPre")
		  {
			 document.getElementById("fancybox-overlay").style.display="none";
			 document.getElementById("fancybox-content").style.display="none";
			 $("#fancybox-close").hide();
		  }
		});	
		
	}
	
	function fn_orderNow(pid,qty)
	{ 
		$.post("include/cartinc.php",
		{
		  prod_id1:pid,
		  prod_qty1:qty,
		  add:"yes"
		},
		function(data,status){ 
		  if (data=="OutOfStock")
		  	 alert('Sorry! This book is out of stock.');
		  else if (data=="MixedStock")
		  	 alert('Books can\'t be ordered with Pre order books. \nPlease make two seprate order for each.');
		  else if (data=="MixedPre")
		  	 alert('Pre order books can\'t be ordered with other books. \nPlease make two seprate order for each.');
		  else
		  {
			  fn_loadcart();
			 location.href="checkout.php";
		  }
		});	
	}
	
	function fn_updatecart(pid,qty)
	{		
		//alert(qty);
		$.post("include/cart.php",
		{
		  cart_id1:pid,
		  prod_qty1:qty,
		  Submit:" Update"
		},
		function(data,status){		
		  $("#cart_items").html(data);		
		});	
	}
	
	function fn_delcart(pid)
	{
		$.post("include/cart.php",
		{
		  delid:pid	 
		},
		function(data,status){
		  $("#cart_items").html(data);		
		});	
	}		
	
	function fn_delwish(pid,qty)
	{
		$.post("include/cartinc.php",
		{
		  delid:pid,	
		  qty:"1111"	 
		},
		function(data,status){ 
		  location.href='account.php?page=wishlist';		
		});	
	}
	
	function fn_orderitems(checkout)
	{
		$.post("include/cartinc.php",
		{
		  checkout:checkout,
		  coupon: $("#coupon").val()
		},
		function(data,status){
		  $("#order_items").html(data);		
		});	
	}
	
	function fn_coupon()
	{
		$("#coup-msg").html('');
		if ($("#coupon").val() == "")
		{
			$("#coup-msg").html('- Please enter a valid coupon code.');
		}
		else
		{
			$.post("include/validate.php",
			{
			  coupon: $("#coupon").val()
			},
			function(data,status){
			  $("#coup-msg").html(data);		
			});	
			if ($("#coup-msg").html()=="")
				fn_orderitems(true);
		}
		

	}
	
	function fn_validateOrder(totAmt)
	{
		$("#check-out").html('');
		$.post("include/validate.php",
		{
		  totAmt:totAmt
		},
		function(data,status){
			if (data=="AllGood")
				return true;
			else
			{
				$("#check-out").html('- Please enter a valid coupon code.');
				return false;
			}
		});	
		
	}
	
	
	function fn_CreateNewUser()
	{
		msg="";
		$("#message").html("");
		email = $("#remail").val();
		pass = $("#rpassword").val();
		pass1 = $("#rpassword1").val();
		
		
		if (pass1!="" && pass != pass1)
			msg = "Confirm Password is not same.";
		
		if (msg!="")
		{
			$("#message").html(msg);
			//alert(email)
		}
		else
		{ 
			$.post("include/register.php",
			{
			  email:email,	
			  password:pass 
			},
			function(data,status){ 
			  $("#message").html(data);		
			});	
		}
	
	}

	function fn_Newsletter(email)
	{
		var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
		$("#nmsg").html('');
		if (email=="")
		{
			$("#nmsg").html('- Email is required');
			return;
		}
		if (email.match(pattern)==null)
		{
			$("#nmsg").html('- Invalid email');
			return;
		}
		$.post("include/newsletter-register.php",
		{
		  email:email,	
		  reg_type:'NL'
		},
		function(data,status){ 
		  $("#nmsg").html(data);		
		});	
	}
	function fn_LoadEmpNews(lang)
	{			
	}
	
	function fn_Event(eType, year, lang)
	{	
		$("#mainform").submit();
		//location.href="events.php?eType="+eType +"&Year="+ year +"&lang="+lang;
	}
	
	function fn_News(year, lang)
	{		
		$("#mainform").submit();
		//location.href="news.php?Year="+ year +"&lang="+lang;
	}
	
	function fn_Exams(lang)
	{		
		$("#mainform").submit();
		//location.href="exams.php?lang="+lang;
	}
	
	function fn_CheckShipping()
	{		
		
		if ($("#shipadd").is(":checked"))
		{
			fn_setAttrib(true,'#s');
			$("#shipping-address").show();
		}
		else
		{
			fn_setAttrib(false,'#s');
			$("#shipping-address").hide();
		}
		//if ($("#shipadd[checked]")
	}
	

	
	function fn_setAttrib(act,ctrl)
	{
		$(ctrl+"name").attr('required',act);
		$(ctrl+"address").attr('required',act);
		$(ctrl+"city").attr('required',act);
		$(ctrl+"state").attr('required',act);
		$(ctrl+"pin").attr('required',act);
		$(ctrl+"country").attr('required',act);
		$(ctrl+"mobile").attr('required',act);
		if (ctrl=="#")
			$(ctrl+"email").attr('required',act);
	}
	
	function fn_otherAdd()
	{
		$('#existing-add').hide(); 
		$('#add-form').show(); 
		$('#bid').val('');
		$('#sid').val('');
		$('.billing').prop('checked', false);
		$('.shipping').prop('checked', false);
		fn_setAttrib(true,'#')
		$('.billing').attr('required', false);
		$('.shipping').attr('required', false);
	}
	
	function fn_existingAdd()
	{
		$('#existing-add').show(); 
		$('#add-form').hide(); 
		$('.billing').attr('required', true);
		$('.shipping').attr('required', true);
	}
	
	
	function fn_getOrderTrail(oid)
	{
		$.post("ncba_admin/order_status.php",
		{
			oid:oid
		},
		function(data,status){ 
		  $("#orderStatus").html(data);
		});
	}
	
	
	
	//next label1
	
	function loginnext()
	{
		//alert();
	 $("#Emaill").removeClass("active");
	 $("#addresss").addClass("active");
	 
	   document.getElementById("addresss").innerHTML = "<a data-toggle='tab' role='tab'   aria-expanded='true'>Email Id </a>";	
	   document.getElementById("Review").innerHTML = "<a data-toggle='tab' role='tab'   aria-expanded='true'>Review order </a>";
	   document.getElementById("paymentt").innerHTML = "<a data-toggle='tab' role='tab'  aria-expanded='true'>Make  payment </a>";
	}
	//Address next
	function address_next()
	{ 
	
	$("#Emaill").removeClass("active");
	 $("#addresss").removeClass("active");
	 $("#Review").addClass("active");
	 
	   document.getElementById("addresss").innerHTML = "<a data-toggle='tab' role='tab'  href='#brand-info' aria-expanded='true'>Address </a>";	
	   document.getElementById("Review").innerHTML = "<a data-toggle='tab' role='tab'   aria-expanded='true'>Review order </a>";
	   document.getElementById("paymentt").innerHTML = "<a data-toggle='tab' role='tab'   aria-expanded='true'>Make  payment </a>";
		
	}
	//reviews_next
	function reviews_next()
	{ 
	  $("#Emaill").removeClass("active");
	  $("#addresss").removeClass("active");
	  $("#Review").removeClass("active");
	  $("#paymentt").addClass("active");
	   document.getElementById("Review").innerHTML = "<a data-toggle='tab' role='tab'  href='#faq' aria-expanded='true'>Review order </a>";
	   document.getElementById("paymentt").innerHTML = "<a data-toggle='tab' role='tab'   aria-expanded='true'>Make  payment </a>";
	}


	
	
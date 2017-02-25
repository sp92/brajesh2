<? include("top.php");?>
<body>
<!-- header -->
	<div class="agileits_header">
		<div class="w3l_offers">
			<a href="products.html">Today's special Offers !</a>
		</div>
		<div class="w3l_search">
			<form action="#" method="post">
				<input type="text" name="Product" value="Search a product..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search a product...';}" required="">
				<input type="submit" value=" ">
			</form>
		</div>
		<div class="product_list_header">  
			<form action="#" method="post" class="last">
                <fieldset>
                    <input type="hidden" name="cmd" value="_cart" />
                    <input type="hidden" name="display" value="1" />
                    <input type="submit" name="submit" value="View your cart" class="button" />
                </fieldset>
            </form>
		</div>
		<div class="w3l_header_right">
			<ul>
				<li class="dropdown profile_details_drop">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i><span class="caret"></span></a>
					<div class="mega-dropdown-menu">
						<div class="w3ls_vegetables">
							<ul class="dropdown-menu drp-mnu">
								<li><a href="login.html">Login</a></li> 
								<li><a href="login.html">Sign Up</a></li>
							</ul>
						</div>                  
					</div>	
				</li>
			</ul>
		</div>
		<div class="w3l_header_right1">
			<h2><a href="mail.html">Contact Us</a></h2>
		</div>
		<div class="clearfix"> </div>
	</div>
<!-- script-for sticky-nav -->
	<script>
	$(document).ready(function() {
		 var navoffeset=$(".agileits_header").offset().top;
		 $(window).scroll(function(){
			var scrollpos=$(window).scrollTop(); 
			if(scrollpos >=navoffeset){
				$(".agileits_header").addClass("fixed");
			}else{
				$(".agileits_header").removeClass("fixed");
			}
		 });
		 
	});
	</script>
<!-- //script-for sticky-nav -->
	<div class="logo_products">
		<div class="container">
			<div class="w3ls_logo_products_left">
				<h1><a href="index.html"><span>Atta</span> Bazaar</a></h1>
			</div>
			<div class="w3ls_logo_products_left1">
				<ul class="special_items">
					<li><a href="#">Events</a><i>/</i></li>
					<li><a href="#">About Us</a><i>/</i></li>
					<li><a href="#">Best Deals</a><i>/</i></li>
					<li><a href="#">Services</a></li>
				</ul>
			</div>
			<div class="w3ls_logo_products_left1">
				<ul class="phone_email">
					<li><i class="fa fa-phone" aria-hidden="true"></i>(+0123) 234 567</li>
					<li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:store@grocery.com">store@grocery.com</a></li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //header -->
<!-- products-breadcrumb -->
	<div class="products-breadcrumb">
		<div class="container">
			<ul>
				<li><i class="fa fa-home" aria-hidden="true"></i><a href="index.html">Home</a><span>|</span></li>
				<li>Bread & Bakery</li>
			</ul>
		</div>
	</div>
<!-- //products-breadcrumb -->
<!-- banner -->
	<div class="banner">
		
		<?  include("left.php");?>

		<div class="w3l_banner_nav_right">
			<div class="w3l_banner_nav_right_banner8">
				<h3>Best Deals For New Products<span class="blink_me"></span></h3>
			</div>
			<div class="w3ls_w3l_banner_nav_right_grid w3ls_w3l_banner_nav_right_grid_sub">
<? 
			if (get("View")!= "")
				$_SESSION["List"] = get("View") ;
				
			$View = $_SESSION["List"];
	
			$lang = get("lang");			
			$sword = get("word");
			$stype = get("type");
			$prod_cat =  get("cat");
			$prod_scat =  get("scat");
			$desc = get("desc");
			$desc = str_replace("-"," ", $desc);
			$desc = str_replace("lpage.php/","", $desc);
			$prod_code =  get("code");
			
			$lang = getValue("select cat_lang from category where cat_id=$prod_cat");
			if ($sword =="")
			{
				if (get("lang")!="" && $lang!=get("lang")) 
				{
					 $prod_cat = getValue("select cat_title_h from category where cat_id=$prod_cat");
					 $desc = getValue("select cat_title from category where cat_id=$prod_cat");	
					 $lang = getValue("select cat_lang from category where cat_id=$prod_cat");				
				}
			}

			$addque = " or extra IN ('". $prod_cat  ."') ";
			$que="select * from products prd where prd.prod_cat = '". $prod_cat ."' AND prod_subcat='". $prod_scat ."' and prod_active=1 order by prod_seq, prod_isbn, prod_name";
			if ($prod_scat == 0)  $que="select * from products prd where prd.prod_cat = '". $prod_cat ."' and prod_active=1 order by prod_seq, writer_e, prod_name";
			if (get("new") == 1) $que = "select * from products prd  where prd.prod_new = 1  and prod_active=1 order by prod_seq, writer_e, prod_name";
			if (get("hot") == 1)  $que = "select * from products prd  where  prd.prod_hot = 1  and prod_active=1 order by prod_seq,writer_e, prod_name";		
			if (get("spec") == 1)  $que = "select * from products prd  where  prd.prod_special = 1  and prod_active=1 order by prod_seq,writer_e, prod_name";	
			if (get("forthc") == 1)  $que = "select * from products prd  where  prd.prod_forthc = 1  and prod_active=1 order by prod_seq,writer_e, prod_name"	;
			if (get("best") == 1)  $que = "select top 20 * from products prd  order by  prod_rate-prod_sprate desc, prod_code,writer_e, prod_name";
			if (get("auth") <> "")  $que = "select * from products prd  where  writer_e = '". get("auth") ."'  and prod_active=1 order by prod_seq,writer_e, prod_name";
			if ($prod_code != "")  $que="select * from products prd where prd.prod_code in (". $prod_code .") and prod_active=1 order by prod_seq, prod_name";
			
			if ($sword <> "")
			{
				$addque = " where prod_store=$StoreId and (prod_code like '%" . $sword . "%'";
				$addque = $addque . " OR prod_name_e like '%" . $sword . "%'";
				$addque = $addque . " OR prod_name like '%" . $sword . "%'";
				if (strlen($sword)>10)
					$addque = $addque . " OR prod_ISBN like '%" . $sword . "%'";
				//$addque= $addque . " OR prod_publisher like '%" . $sword . "%'";
				$addque = $addque . " OR writer_e like '%" . $sword . "%')";
				if ($lang !="")
					$addque .= " and  prod_type='$lang'";
				//$addque = $addque . " OR prod_year like '%" . $sword . "%' or prod_publisher like '%" . $sword . "%' or prod_ISBN like '%" . $sword . "%' or prod_name_e like '%" . $sword . "%' or writer_e like '%" . $sword . "%'";
				if ($prod_cat <> "All")  $addque = $addque ;
				$que="select * from products prd join category c on prod_cat=cat_id and cat_active=1 " . $addque . " and prod_active=1 order by prod_seq, writer_e, prod_name limit 0, 300";
			}
			//echo $que;
			$disp = "none"; 
			$result = mysql_query($que);
			$total_books = mysql_num_rows($result);
			
		 	
		   ?>
<?
				if ($total_books > 0)
				{
					$disp = "block";
					$msg="";
				}
				else
				{
					$msg = "<br> <center><strong>No books found.</strong></center><br>";
				}
				?>
				<h3 class="w3l_fruit">Bread & Bakery</h3>
				<div class="w3ls_w3l_banner_nav_right_grid1 w3ls_w3l_banner_nav_right_grid1_veg">
				<?
								 
								 while($row=mysql_fetch_array($result))
								 {				
									 $pic = getpic("prod_pic/small/". trim($row["prod_pic"]));		
									 
									 $pid=$row["prod_id"];
												 
									 // Get product Rating
									 $rating =  getProdRatings($pid);
									 $avg = $rating["Average"];
									 $rCount = $rating["ReviewsCnt"];
									 // End Ratings

									$MRP = round(GetCurrencyRate($row["prod_id"],"M") * $row["prod_rate"],0);					
									$PrintMRP = round(GetCurrencyRate($row["prod_id"],"S") * $row["prod_sprate"],0);								
									$SalePrice = GetFinalPrice($row["prod_id"], $MRP);
									$Discount=0;
									if ($PrintMRP > 0) 
										$Discount = ceil((($PrintMRP - $SalePrice) * 100) / $PrintMRP);	
									
									include("include/prod_list_template.php");
										} 
									 echo $msg;
									 ?>	
				</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
<!-- //banner -->
<!-- newsletter -->
	<div class="newsletter">
		<div class="container">
			<div class="w3agile_newsletter_left">
				<h3>sign up for our newsletter</h3>
			</div>
			<div class="w3agile_newsletter_right">
				<form action="#" method="post">
					<input type="email" name="Email" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">
					<input type="submit" value="subscribe now">
				</form>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //newsletter -->
<!-- footer -->
	<? include("footer.php");?>
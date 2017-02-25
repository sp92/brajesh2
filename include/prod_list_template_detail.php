<?
 $BtnText = "Buy Now";
 if ($row["stock"] == "Pre-Order")
	$BtnText = "Pre Order Now";

 $disp = "inline";
 //if ($row["prod_store"] != $StoreId || $row["prod_cat"] == 133)
	 //$disp = "none";
	 
  $extra_link = fn_link("details.php?prod_id=".$row["prod_id"]."&title=");
  //if ($row["prod_cat"] == 133)
  	//$extra_link = "http://www.fashion.com' target='_new'";
 
  $title_chr = 100;
  $writer_chr = 50;
  if ($row["prod_type"]=="E")
  {
  	 $title_chr = 90;
	 $writer_chr = 50;
  }
?>
<li>
					<div class="w3l_related_products_grid">
						<div class="agile_ecommerce_tab_left dresses_grid">
							<div class="hs-wrapper hs-wrapper3">
						<img src="<? echo $pic?>" class="img-responsive height100"  alt="<? echo $row["prod_name_e"]?>" />		
								<div class="w3_hs_bottom">
									<div class="flex_ecommerce">
										<a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
									</div>
								</div>
							</div>
							<h5><a href="<? echo fn_link($extra_link) ?>"><? echo getTitle($row["prod_name_e"],30);?></a></h5>
							<div class="simpleCart_shelfItem">
							<? if ($Discount>0){ ?>	
								<p class="flexisel_ecommerce_cart"><span>Rs. <? echo ($PrintMRP) ?>/</span> <i class="item_price">Rs. <? echo($SalePrice) ?>/-</i></p>
								<? } else {?>							
									<p> <i class="flexisel_ecommerce_cart"><? echo($PrintMRP) ?>/-</i></p>
								<? }?>
								<? if (($SalePrice>0 && $PrintMRP > 0 && ($row["stock"] == 'In Stock' || $row["stock"] == 'Pre-Order' ))|| $Discount == 100) { ?>
							<p><a class="item_add" href="#." id=<? echo $row["prod_id"] ?> onclick="fn_addcart(<? echo $row["prod_id"] ?>,1);">Add to cart</a></p>
							<?}?>
							</div>
						</div>
					</div>
				</li>








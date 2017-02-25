<?
 $BtnText = "Buy Now";
 if ($row["stock"] == "Pre-Order")
	$BtnText = "Pre Order Now";

 $disp = "inline";
 if ($row["prod_store"] != $StoreId || $row["prod_cat"] == 133)
	 $disp = "none";
	 
  $extra_link = fn_link("details.php?prod_id=".$row["prod_id"]."&title=");
  //if ($row["prod_cat"] == 133)
  	//$extra_link = "http://www.fashion.com' target='_new'";
 
?>
	<div class="col-md-4 agile_ecommerce_tab_left">
	<div class="hs-wrapper">
		
		<img src="<? echo $pic?>" class="img-responsive height100"  alt="<? echo $row["prod_name_e"]?>" />
		<div class="w3_hs_bottom">
			<ul>
				<li>
					<a href="#" data-toggle="modal" data-url="#myModal" data-load-url="include/quick-view.php"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
				</li>
			</ul>
		</div>
	</div>
	<h5><a href="<? echo fn_link($extra_link) ?>"><? echo getTitle($row["prod_name_e"],30);?></a></h5>
	<div class="simpleCart_shelfItem">
		<? if ($Discount>0){ ?>							
		<p><span>Rs. <? echo ($PrintMRP) ?>/</span> <i class="item_price">Rs. <? echo($SalePrice) ?>/-</i></p>
		<? } else {?>							
			<p> <i class="item_price"><? echo($PrintMRP) ?>/-</i></p>
		<? }?>
						
			<? if (($SalePrice>0 && $PrintMRP > 0 && ($row["stock"] == 'In Stock' || $row["stock"] == 'Pre-Order' ))|| $Discount == 100) { ?>
			<p><a class="item_add" href="#." id=<? echo $row["prod_id"] ?> onclick="fn_addcart(<? echo $row["prod_id"] ?>,1);">Add to cart</a></p>
			<?}?>
	</div>
</div>
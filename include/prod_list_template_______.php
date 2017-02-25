<?
 $BtnText = "Buy Now";
 if ($row["stock"] == "Pre-Order")
	$BtnText = "Pre Order Now";

 $disp = "inline";
 if ($row["prod_store"] != $StoreId || $row["prod_cat"] == 133)
	 $disp = "none";
	 
  $extra_link = fn_link("details.php?prod_id=".$row["prod_id"]."&title=");
  //if ($row["prod_cat"] == 133)
  	//$extra_link = "http://www.manojpublications.com' target='_new'";
 
  $title_chr = 100;
  $writer_chr = 50;
  if ($row["prod_type"]=="E")
  {
  	 $title_chr = 90;
	 $writer_chr = 50;
  }
?>
<div class="col-sm-6 col-md-3 wow fadeInUp">
    <div class="products">			
        <div class="product">		
            <div class="product-image">
                <div class="image">
                    <a href="<? echo fn_link($extra_link) ?>">
                        <img src="<? echo $pic?>" alt="<? echo $row["prod_name_e"]?>" />
                    </a>
                </div>                        		   
            </div>
            <div class="product-info text-left">
                <h3 class="name"><a href="<? echo fn_link($extra_link) ?>" title="<? echo $row["prod_name"]?>"><? echo getTitle($row["prod_name_e"],$title_chr)?></a></h3>
                <div class="rating rateit-small"></div>
                <div class="description"></div>
                <div class="product-price">
                <? if ($Discount>0){ ?>	
                    <span class="price">Rs. <? echo($SalePrice) ?>/-</span>
                    <span class="price-before-discount">Rs. <? echo ($PrintMRP) ?>/</span>
                <? } else {?>
                    <span class="price">Rs. <? echo($PrintMRP) ?>/-</span>
                <? }?>
                </div>
            </div>
            <div class="cart clearfix animate-effect">
                     <div class="list-unstyled part_A w100">
                    <? if (($SalePrice>0 && $PrintMRP > 0 && ($row["stock"] == 'In Stock' || $row["stock"] == 'Pre-Order' ))
                    || $Discount == 100) { ?>
                             <a href="#" class="mb10 but" id=<? echo $row["prod_id"] ?>  onclick="fn_addcart(<? echo $row["prod_id"] ?>,1);">
                                     <i class="fa fa-shopping-cart" ></i>													
                             </a>	
                              <a class="mb10 but" href="javascript:fn_orderNow(<? echo $row["prod_id"] ?>,1)" title="<? echo $BtnText?>"> <? echo $BtnText?> 
                            </a>
                             <? } 
                            if ($row["prod_wish"]!= '1')
                            {
                            ?>
                             <a href="#" onclick="fn_addcart(<? echo $row["prod_id"] ?>,1111)" class="add-to-cart mb10 but">
                                <i class="icon fa fa-heart"></i>
                            </a>
                            <? 
                            }
                            else
                            {
                            ?>
 									<a href="<? echo $SiteUrl?>account.php?page=wishlist&delid=<? echo $row["cart_id"] ?>" class="add-to-cart mb10 but">
										<i class="fa fa-times"></i>
									</a>
                            <? }?>
                    </div>
             </div>
        </div>
    </div>
</div>
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

<div class="col-md-3 w3ls_w3l_banner_left" >
            <div class="hover14 column">
            <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
              <div class="agile_top_brand_left_grid_pos">
                <img src="<? echo $pic?>" alt="<? echo getTitle($row["prod_name_e"],20) ;?>" class="img-responsive" />
              </div>
              <div class="agile_top_brand_left_grid1">
                <figure>
                  <div class="snipcart-item block">
                    <div class="snipcart-thumb">
                      <a href="single.html"><img src="<? echo $pic?>" alt="<? echo getTitle($row["prod_name_e"],20) ;?> " class="img-responsive" /></a>
                      <p><? echo getTitle($row["prod_name_e"],15)?></p>
                      <h4>
                        <? if ($Discount>0){ ?> 
                        Rs.<? echo($SalePrice) ?>

                       <span>Rs. <? echo($PrintMRP) ?></span>
                       <? } else {?>
                       Rs. <? echo($PrintMRP) ?>/-
                       <? }?>

                       </h4>
                    </div>
                    <div class="snipcart-details">
                      <form action="#" method="post">
                        <fieldset>
                       <!--   <input type="hidden" name="cmd" value="_cart" />
                          <input type="hidden" name="add" value="1" />
                          <input type="hidden" name="business" value=" " />
                          <input type="hidden" name="item_name" value="butter croissants" />
                          <input type="hidden" name="amount" value="2.00" />
                          <input type="hidden" name="discount_amount" value="1.00" />
                          <input type="hidden" name="currency_code" value="USD" />
                          <input type="hidden" name="return" value=" " />
                          <input type="hidden" name="cancel_return" value=" " />-->
                          <? if (($SalePrice>0 && $PrintMRP > 0 && ($row["stock"] == 'In Stock' || $row["stock"] == 'Pre-Order' )) || $Discount == 100) { ?>
                          <input type="submit" name="submit" id=<? echo $row["prod_id"] ?> onclick="fn_addcart(<? echo $row["prod_id"] ?>,1) " class="button" />

                          <?  } ?>
                        </fieldset>
                      </form>
                    </div>
                  </div>
                </figure>
              </div>
            </div>
            </div>
          </div>

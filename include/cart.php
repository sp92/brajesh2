<? 
session_start();
$sid = session_id();

include ("cartinc.php") ;

$disp = "none"; 
$sql = "select subscription, c.prod_mrp, c.prod_rate, prod_pic, writer_e, c.cart_id, p.prod_id, prod_code, prod_name, prod_name_e, prod_qty from cart c, products p where c.prod_id = p.prod_id and sessionid = '$sid' and prod_wish=0";
$rsCart = mysql_query($sql);
$num_rows = mysql_num_rows(($rsCart));

if ($min_cart)
	$disp = "none"; 
else
{
	if ($num_rows > 0)
		$disp = "block";
	else 
		echo "<div style='width:100%; float:lef;border:1px solid #eee;padding:30px 0; text-align:center; color:#000; font-size:18px;'><strong>- Empty cart.</strong></div>";
}
?>
<form action="cart.php" method="post" style="display:<?echo $disp?>">



<div class="shopping-cart">
	<div class="col-md-12 col-sm-12 shopping-cart-table ">
		<div class="table-responsive wOA">
			<table class="table table-bordered" id="tital_item1">
                <thead>
                    <tr>
                        <th class="cart-description item">Item</th>
                        <th class="cart-product-name item">Item Description</th>
                        <th class="cart-qty item">Quantity</th>
                        <th class="cart-sub-total item">Price</th>
                        <th class="cart-total last-item">Subtotal</th>
                        <th class="cart-romove item">Remove</th>
                    </tr>
                </thead>
                <tbody class="t_body2">
                <?	
				while($row=mysql_fetch_array($rsCart))
				{
					$fc=0;
					$intQty = 0;
					$n++;
					//echo $row["prod_pic"];
					$pic = getpic("prod_pic/small/". trim($row["prod_pic"]));
				?>
           			<tr style="border: 1px solid #000;">
                 		<td class="cart-image br1">
							<a href="<? echo fn_link("details.php?prod_id=".$row["prod_id"]."&title=".$row["prod_name_e"]) ?>" class="entry-thumbnail">
                            <img src="<? echo $pic?>" alt="" width="75" height="100">
							</a>
						</td>
						<td class="cart-product-name-info br1">
							<h4 class="cart-product-description">
                            	<a href="<? echo fn_link("details.php?prod_id=".$row["prod_id"]."&title=".$row["prod_name_e"]) ?>"><? echo $row["prod_name_e"]?></a>
                      		</h4>
							<div class="cart-product-info">
								<span class="product-imel">Author:<span><? echo $row["writer_e"]?></span></span><br>
								<span class="product-color">Code:<span><? echo $row["prod_code"]?></span></span>
							</div>
						</td>
						<td class="cart-product-quantity br1">
							<div class="quant-input fl mr5">
				                <input style="width: 47px; height: 35px;" autocomplete="off" type="number" min="1" name="prod_qty<? echo $n?>" id="prod_qty<? echo $n?>" title="Quantity" required value="<? echo $row["prod_qty"]?>" maxlength="2" />
			              	</div>
                          	<div class="quant-input fl" onClick="fn_updatecart('<? echo $row["cart_id"] ?>',document.getElementById('prod_qty<? echo $n ?>').value)">
				          			<div class="arrow plus gradient btn btn-upper">
                                  		<span class="ir"><i class="icon fa fa-refresh"></i></span>
                             		</div>
                                <input type="hidden" name="cart_id<? echo $n?>" value="<? echo $row["cart_id"]?>" />
			              	</div>
		            	</td>
						<td class="cart-product-sub-total br1">
                        <span class="cart-sub-total-price"><? echo $row["prod_rate"]?>/-</span>
                        <? if ($row["prod_rate"]!= $row["prod_mrp"]) {?>
                        <span class="cart-sub-total-price" style="text-decoration:line-through"><? echo $row["prod_mrp"]?>/-</span>
                        <? } ?>
                        </td>
						<td class="cart-product-grand-total br1">
                        <span class="cart-grand-total-price"><? echo ($row["prod_qty"]*$row["prod_rate"])?>/-</span>
                        </td>
                        <td class="romove-item br1">
                        	<a href="javascript:fn_delcart('<? echo $row["cart_id"] ?>')" title="Remove" class="icon"><i class="fa fa-trash-o"></i></a>
                    	</td>
					</tr>
                    <? 
					$SubTotal = $SubTotal + ($row["prod_qty"] * $row["prod_rate"]);
					if ($row["subscription"]==false)
						$ShipTotAmount = $ShipTotAmount + $SubTotal;	
					
					$discount=  round((($row["prod_mrp"] - $row["prod_rate"]) * 100) / $row["prod_mrp"]);
					$mrpTotal =$mrpTotal +  ($row["prod_qty"] * $row["prod_mrp"]);
					$intQty = $intQty + $row["prod_qty"];
					$intMRPSaving = $mrpTotal - $tamount;	
				
					 $TotalDiscount =0;
					 $TotalDiscount = getDiscountOnTotal($SubTotal);
					 $_SESSION["TotalDiscount"] = $TotalDiscount;
					 
					 //$shipping = 0;
					 //$shipping = getShipping($ShipTotAmount);
					 //$_SESSION["freight"] = $shipping;
					 
					 $NetPaybal = $SubTotal - $TotalDiscount + $shipping;
					 $_SESSION["NetPaybal"] = $NetPaybal;
					}?>
                </tbody>
                <tfoot class="t_body2">
            		<tr>
                 		<td colspan="7">
                    		<div class="shopping-cart-btn">
                         		<span class="">
                          			<a href="#" onClick="window.location.href='index.php'" class="btn btn-upper btn-primary outer-left-xs">Continue Shopping</a>                       			
                                    <a href="#" onClick="window.location.href='checkout_process.php?checkoput=checkoput'" class="btn btn-upper btn-primary pull-right outer-right-xs">Proceed to checkout</a>
                                </span>
                            </div>
                        </td>
                    </tr>
                </tfoot>
			</table>
		</div>
	</div>				
	<div class="col-md-4 col-sm-12 cart-shopping-total fr">
		<table class="table table-bordered" >
			<thead>
				<tr>
					<th id="total1">
						<div class="cart-sub-total">
							Subtotal<span class="inner-left-md"><? echo $SubTotal?>/-</span>
						</div>
                        <div class="cart-sub-total">
						Shipping Charges:<span class="inner-left-md"><? echo $shipping?>/-</span>
						</div>
                        <? if ($TotalDiscount>0) {?>
                        <div class="cart-sub-total">
						 Discounts:<span class="inner-left-md"><? echo $TotalDiscount?>/-</span>
						</div>
                        <? } ?>
						<div class="cart-grand-total">
							Grand Total<span class="inner-left-md"><? echo $NetPaybal ?>/-</span>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="cart-checkout-btn pull-right">
							<button type="button" class="btn btn-primary" onClick="window.location.href='<? echo fn_link('checkout_process.php') ?>'">PROCCED TO CHEKOUT</button>
						</div>
					</td>
				</tr>
			</tbody> 
		</table> 
	</div> 
</div>
<script>
	value="<div class='items-cart-inner cart-summ'><div class='total-price-basket'> <span class='lbl'>cart -</span> <span class='total-price'>  <span class='sign'>Rs.</span>  <span class='value' id='CartAmount'><? echo $CartAmount ?></span> </span></div><div class='basket'> <i class='glyphicon glyphicon-shopping-cart'></i></div><div class='basket-item-count'><span class='count' id='CartCount'><? echo $CartItems ?></span></div>  </div>";	
	<? if ($CartItems == 0 && $min_cart=="") { ?>
		//value = "<div class=fl>Empty Cart</div>";
	<? }?>
	//$("#cart_items").html(value);
	$(".cart-summ").html(value);
</script>
</form>
<? 
if ($min_cart) {
	$sql = "select * from products where prod_id = ". get("pid");
	$rsCart = mysql_query($sql);
	while($row=mysql_fetch_array($rsCart))
	{
	?>
		<div style="font-size:14px; color:#000000; line-height:30px;">1 item (<strong><? echo $row["prod_name_e"]?></strong>) added in <? echo  get("type")?>.</div>
        <br />
	<? 
	}
} ?>
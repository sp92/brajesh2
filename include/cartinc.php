<?
	if (session_id()=="") 
		session_start();
	include("config.php");  
	$sid = session_id();
	$user_id=$_SESSION["userid"];
	
	//--------------------- product adding in cart ------------------
	if (get("add") == "yes")
	{			
		if ($count == 0)  $count=1;
		//echo $count ."dsa";
		for ($i=1; $i<=$count; $i++)
		{
			$prod_id = get("prod_id".$i);				
			$prod_qty = get("prod_qty".$i);
			
			if (getValue("select stock from products where prod_id = ".$prod_id) == 'Out of Stock')
			{
				echo "OutOfStock";
				return;
			}	
			
			if (getValue("select stock from products where prod_id = ".$prod_id) != 'Pre-Order')
			{
				if (getValue("select count(*) from products p, cart c where p.prod_id=c.prod_id and p.stock = 'Pre-Order' and sessionid = '$sid'") > 0 )
				{
					echo "MixedStock";
					return;
				}	
			}
			else
			{
				if (getValue("select count(*) from products p, cart c where p.prod_id=c.prod_id and p.stock != 'Pre-Order' and sessionid = '$sid'") > 0 )
				{
					echo "MixedPre";
					return;
				}
			}
				
			
			if ($prod_qty == 1111) $wish=1; 
			if ($prod_qty != "0" && $prod_qty != "" && $prod_id != "")
			{	
				if ($prod_qty == 1111) $prod_qty=0;
				$sql = "select * from products where prod_id = ".$prod_id;
				$rs = mysql_query($sql);
				$r=mysql_fetch_array($rs);
				$prod_rate = $r["prod_rate"];
				$prod_sprate = $r["prod_sprate"];
			
				$MRP = round(GetCurrencyRate($prod_id,"M") * $prod_rate,0);					
				$PrintMRP = round(GetCurrencyRate($prod_id,"S") * $prod_sprate,0);								
				$SalePrice = GetFinalPrice($prod_id, $MRP);
				$Discount=0;
				if ($PrintMRP > 0) 
					$Discount = round((($PrintMRP - $SalePrice) * 100) / $PrintMRP);
				
				$sql = "select sessionid, prod_id, prod_qty, user_id from cart where prod_id = ".$prod_id." and sessionid = '$sid'";
				$rsCart = mysql_query($sql);
				$n=0;
				while($row=mysql_fetch_array($rsCart))
				{
				   $n=1;
				   $updsql = "update cart set prod_id = '$prod_id', prod_qty=prod_qty+$prod_qty, sessionid='$sid', user_id='$user_id',prod_rate='$SalePrice', prod_mrp='$PrintMRP',prod_wish='$wish' where prod_id = $prod_id and sessionid = '$sid'";
				   mysql_query($updsql);					
				} 
				if ($n==0)
				{
				   mysql_query("insert into cart set prod_id = '$prod_id', prod_qty='$prod_qty', sessionid='$sid', user_id='$user_id', prod_rate='$SalePrice', prod_mrp='$PrintMRP',prod_wish='$wish', created_date=now()");
				}
			}
		}
	}
				
	//------------------------ end--------------------
	
	//-------------------- update cart ---------------------
	$cart_id = get("cart_id1");
	$prod_qty = get("prod_qty1");
	$prod_del = get("prod_del1");
	
	if ($cart_id > 0)
	{
		$sql = "update cart set prod_qty = ". $prod_qty ." where cart_id=". $cart_id ." and prod_wish = 0 and sessionid = '$sid'";
		mysql_query($sql);
		if ($prod_del != 0)  
			mysql_query("delete from cart where (cart_id=". $prod_del ." or prod_qty = 0) and prod_wish = 0 and sessionid = '$sid'");
		if ($prod_del == 0)
		   mysql_query("delete from cart where (prod_qty = 0) and prod_wish = 0 and sessionid = '$sid'");
	}
	
	//---------- end updation
	$prod_del = get("delid");
	if ($prod_del>0 && get("qty")=="1111") 
	{
		$sql = "delete from cart where (prod_id = ".$prod_del.") and prod_wish = 1 and user_id =$user_id";
		mysql_query($sql);
	}
	else
		mysql_query("delete from cart where (cart_id = ".$prod_del.") and prod_wish = 0 and sessionid = '$sid'");

	$CartItems=0;
	$CartAmount=0.00;
	$sql = "Select subscription, c.prod_qty, c.prod_rate from cart c join products p on p.prod_id=c.prod_id where sessionid = '$sid' and prod_wish=0";
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		$CartItems++;
		$CartAmount = $CartAmount+ ($row['prod_rate']*$row['prod_qty']);			
		if ($row["subscription"]==0)
			$ShipTotAmount = $ShipTotAmount + ($row['prod_rate']*$row['prod_qty']);	
	}
	 $shipping = 0;
	 if ($ShipTotAmount>0)
	 	$shipping = getShipping($ShipTotAmount);
	 $_SESSION["freight"] = $shipping;

	
	if (get("add") == "yes")
	{
		echo '<div class="items-cart-inner cart-summ">
                                    <div class="total-price-basket">
                                        <span class="lbl">cart -</span>
                                        <span class="total-price">
                                            <span class="sign">Rs.</span>
                                            <span class="value" id="CartAmount">'. $CartAmount. '</span>
                                        </span>
                                    </div>
                                    <div class="basket">
                                        <i class="glyphicon glyphicon-shopping-cart"></i>
                                    </div>
                                    <div class="basket-item-count"><span class="count" id="CartCount">'.$CartItems .'</span></div>
                                </div>';		
		return;
	}


	if (get("checkout")==true)
	{	
		?>
		<table border="01" class="fs12" style="width: 109%;border: 1px solid #dcad32; margin: -15px 0 0 -12px;">
		<tbody>
			<tr>
			  <td width="87%" class="p10"> <strong>Item</strong></td>
			  <td width="87%" class="p10"> <strong>Quantity</strong></td>
			  <td width="13%" class="ac p10"><strong>Total(Rs.)</strong> </td>
			</tr>
		<?
		$coupon_code =  trim(get("coupon"));
		$sql = "select subscription, c.prod_mrp, c.prod_rate, prod_pic, writer_e, c.cart_id, p.prod_id, prod_code, prod_name, prod_name_e, prod_qty from cart c, products p where c.prod_id = p.prod_id and sessionid = '$sid' and prod_wish=0";
		$rsCart = mysql_query($sql);
		$num_rows = mysql_num_rows(($rsCart));
		while($row=mysql_fetch_array($rsCart))
		{		
		    ?>
			<tr>
				<td width="87%" class="p10"><? echo $row["prod_name_e"]?> </td>
				<td width="87%" class="p10"><? echo $row["prod_qty"] ?> </td>
				<td width="13%" class="ar p10"><? echo ($row["prod_qty"] * $row["prod_rate"]);?></td>
			</tr>
		    <? 	
			$intQty = 0;
			//$pic = getpic("prod_pic/small/". trim($row["prod_pic"]).".jpg");
			$SubTotal = $SubTotal + ($row["prod_qty"] * $row["prod_rate"]);
			
			if ($row["subscription"]==false)
				$ShipTotAmount = $ShipTotAmount + ($row['prod_rate']*$row['prod_qty']);	
			
			$discount=  round((($row["prod_mrp"] - $row["prod_rate"]) * 100) / $row["prod_mrp"]);
			$mrpTotal =$mrpTotal +  ($row["prod_qty"] * $row["prod_mrp"]);
			$intQty = $intQty + $row["prod_qty"];		
		}
		////
		
		$intMRPSaving = $mrpTotal - $tamount;			
		
		$TotalDiscount =0;
		$DiscTypeText = "&nbsp;";
		if ($coupon_code !="")
		{
			$TotalDiscount = GetCouponDiscounts($SubTotal,$coupon_code, 0) ;
			if ($TotalDiscount>0)
				$DiscTypeText = "Coupon Discount: $coupon_code ";
		}
		else
		{
			$coupon_code = "";
		}	
		if ($TotalDiscount == 0)
		{
			$TotalDiscount1 = getDiscountOnTotal($SubTotal);
			if ($TotalDiscount1 > 0)
			{
				$DiscTypeText = "Discount on Total";
				$coupon_code = "DiscOnTot";
			}
			$TotalDiscount = $TotalDiscount1;
		}
		$_SESSION["TotalDiscount"] = $TotalDiscount;
		
		/*
		$shipping = 0;
		 if ($ShipTotAmount>0)
			$shipping = getShipping($ShipTotAmount);
		$_SESSION["freight"] = $shipping;
		*/
		$NetPaybal = $SubTotal - $TotalDiscount + $shipping;
		
		?>
		<tr>
			<td width="87%" class="p10 ar"> Subtotal </td>
			<td width="13%" colspan="2" class="ar p10"><? echo $SubTotal?></td>
		</tr>
		<tr>
			<td width="87%"  class="ar p10 "> Shipping </td>
			<td width="13%"colspan="2"  class="ar p10"><? echo  $shipping ?></td>
		</tr>
		<tr>
			<td width="87%"  class="ar p10"><? echo $DiscTypeText ?> Discount </td>
			<td width="13%"colspan="2"  class="ar p10"><? echo $TotalDiscount?></td>
		</tr>
		<tr>
			<td width="87%" class="ar p10"> Grand Total </td>
			<td width="13%"colspan="2"  class="ar p10"><? echo $NetPaybal?></td>
		</tr>
        <input name="NetPayment" id="NetPayment"  type="hidden" value="<? echo $NetPaybal?>" />
        <input name="paymentT" id="paymentT"  type="hidden" value="I|<? echo $NetPaybal?>" />
        <input name="discount" type="hidden" value="<? echo $TotalDiscount?>" />
        <input name="disc_code" id="disc_code" type="hidden" value="<? echo $coupon_code ?>" />
		</tbody>
	</table>
    <?
	}
	
?>
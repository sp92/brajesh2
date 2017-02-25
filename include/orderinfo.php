<?
$type = get("type");
$oid = get("oid");
$oem = get("oemail");

	   if ($oid =="") $oid  = str_replace("$OrderPrefix/","",get("id"));
		$u_id = $_SESSION["userid"];
		//$_SESSION["admin"]="";
		if ($_SESSION["admin"] == "yes")
			$sql = "select * from orders where  order_id = ". $oid;
		else if ($oid != "" && $email !="")
			$sql = "select * from orders o
					join address a on a.aid=o.user_aid
					where a.email='$oem' and o.order_id = ". $oid;
		else
			$sql = "select * from orders where user_id=". $u_id . " and order_id = ". $oid;
		//echo $sql;
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		$rowo=mysql_fetch_array($result);	
		$aid = $rowo["user_aid"];	
		$sid = $rowo["user_sid"];			
		$shipping = $rowo["freight"];
		$order_discount = $rowo["discount"];
		$order_discount_type = $rowo["discount_code"];
		$order_date = $rowo["order_date"];
		$order_status = $rowo["order_status"];
		$payment_mode = $rowo["pay_mode"];
		$OrderSite = $rowo["label"];
		if ($u_id=="") $u_id = $rowo["user_id"];		
		
		$SiteName = ($OrderSite=='UP')?'Upkar':'Pratiyogita';
		$shipping_instruction = $rowo["order_remark"];
		if ($shipping_instruction == "") $shipping_instruction = "No special instructions";

?>
<div id="product-tabs-slider" class="scroll-tabs wow fadeInUp aj animated animated" style="visibility: visible; -webkit-animation-name: fadeInUp; animation-name: fadeInUp;">
                <div class="w100">
                <?
				$colspan = 6;
				if ($type=="print")
				{
					echo "<h2><strong>$SiteName</strong></h2>";
					$colspan = 5;
				}
				else
					echo "<h2>Order Information</h2>";
				?>
                   
                   <div class="clearfix"></div>
                </div>
                
                <div class="wOA oD">
                <P>
                <?
		
	 	
		
			
		if ($aid != "") 
		{		
			echo "<strong>Order Id:</strong> $OrderSite/$oid &nbsp;&nbsp;<strong>Payment Mode:</strong> $payment_mode<br>
			      <strong>Order Date:</strong> $order_date<br />
				  <strong class=red>Order Status:</strong> $order_status";
				  
			if ($oid!="")
			{
				$sql="select * from order_tracking where order_id=$oid and action='Complete' order by created_date desc limit 0,1";
				$query=mysql_query($sql);
				while($row=mysql_fetch_array($query))
				{	
					$url = getCMValue("ShippingOpt",$row["del_mode"],"code_desc1");
					$ref = $row["referance"];
					echo "<br>=> Track your shipping referance @ <a href='$url' target=_new><strong>$url</strong></a>" ;
				}
			}
		}
		else
		{
			echo "Invaid order number. 
				</p>
				";
			return;
		}
		
		$sql = "select p.prod_store, p.prod_pic, p.writer_e,  p.prod_id, p.prod_code, p.prod_name, p.prod_name_e, c.prod_qty, c.prod_mrp,  c.prod_rate from orderdet c, products p where c.prod_id = p.prod_id and order_id = '$oid'";
		$rsCart = mysql_query($sql);
		$num_rows = mysql_num_rows($rsCart);
		  if ($num_rows>0)
		  { 		  
		  ?>
                
                <table class="shop_table m-t-20" border="1">
             		<thead>
               			<tr>
                			<th class="order-number"><span class="nobr"> #</span></th>
                       		<th class="order-date"><span class="nobr">Code</span></th>
                      		<th class="order-status"><span class="nobr">Book Name</span></th>
                         	<th class="order-total"><span class="nobr">Quantity</span></th>                   			
                            <th class="order-actions"><span class="nobr">Rate </span></th>
                            <? if ($type!="print")  { ?>
                            <th class="order-actions"><span class="nobr">Discount</span></th>
                            <? }?>
                      		<th class="order-actions"><span class="nobr"> Amount </span></th>
                  		</tr>
            		</thead>
          			<tbody>
                    <?
		
			$fc=0;
			$intQty = 0;
			$discount=0;
			while($row=mysql_fetch_array($rsCart))
			{
				$prod_store = $row["prod_store"];
				$n++;
				$tamount = $tamount + ($row["prod_qty"] * $row["prod_rate"]);
				$discount=  round((($row["prod_mrp"] - $row["prod_rate"]) * 100) / $row["prod_mrp"]);
				//$pic = getpic("prod_pic/small/". trim($row["prod_pic"]).".jpg");
			?>
               			<tr class="order">
                    		<td class="order-number"><? echo $n ?></td>
                      		<td class="order-date"><? echo $row["prod_code"]?></td>
                         	<td class="order-status"><? echo $row["prod_name_e"]?></td>
                     		<td class="order-total"><? echo $row["prod_qty"]?></td>
                      		<td class="order-actions">Rs.<? echo $row["prod_rate"]?>
                            <? if ($row["prod_mrp"]!=$row["prod_rate"]) {?>
			  					<br><span style="text-decoration:line-through; font-size:11px">Rs.<? echo $row["prod_mrp"]?>/-</span>
								<? } ?>
                            </td>
                            <? if ($type!="print")  { ?>
                        	<td class="order-actions"> <? echo  $discount ?>%&nbsp;</td>
                            <? } ?>
                            <td class="order-actions">Rs.<? echo $row["prod_qty"] * $row["prod_rate"]?>&nbsp;</td>
                  		</tr>
                        <? 
					$mrpTotal =$mrpTotal +  ($row["prod_qty"] * $row["prod_mrp"]);
					$intQty = $intQty + $row["prod_qty"];
							
			}
			$intMRPSaving = $mrpTotal - $tamount;
			$intMRPSaving = $intMRPSaving+$order_discount;		
			//$intMRPSaving =0;
			?>
                                                <tr class="order">
                                                <td colspan="<? echo $colspan ?>" class="order-number">Subtotal</td>
                                                <td class="order-actions">Rs.<? echo $tamount?></td>
                                                </tr>
                                                <tr class="order">
                                                <td colspan="<? echo $colspan ?>" class="order-number"> No. of Items Ordered</td>
                                                <td class="order-actions"><? echo $intQty?> </td>
                                                </tr>
                                                
                                                <tr class="order">
                                                <td colspan="<? echo $colspan ?>" class="order-number"> Shipping Charge </td>
                                                <td class="order-actions">Rs.<? echo $shipping?></td>
                                                </tr>
                                                
                                                <tr class="order">
                                                <td colspan="<? echo $colspan ?>" class="order-number"> <strong>Discount</strong><? echo ($order_discount_type!="")? "Code: $order_discount_type":"";  ?>  </td>
                                                <td class="order-actions">Rs.<? echo $order_discount?></td>
                                                </tr>
                                                
                                                <tr class="order">
                                                <td colspan="<? echo $colspan ?>" class="order-number"> Your Shopping Total </td>
                                                <td class="order-actions">Rs.<? echo ($tamount+$shipping-$order_discount)?></td>
                                                </tr>
                                                 <? if ($type!="print")  { ?>
                                                <tr class="order">
                                                <td colspan="<? echo $colspan ?>" class="order-number"> Total Saving on Order </td>
                                                <td class="order-actions">Rs.<? echo $intMRPSaving ?></td>
                                                </tr>
                                                <? } ?>
                                                
                                        </tbody>
                                       </table>
                                       <?
		} 
		else 
		{  ?>
          <div align="center"> <span class="pgh2"> No items in your order </span> </div>
          <? }?>
                                       
                                       <div class="w100 fl m-t-20">
                                       
                                       <p><h4 class="bb1">Shipping Instruction</h4></p>
                                       <p class="fs13 m-t-10 mb10"><? echo $shipping_instruction ?></p>
                                       
                                       <div class="col-xs-12 col-md-6">
                                       <div class="bor p10">
                                        <p class="ttu bb1">Billing Details</p>
                                        <?
			  //$orderfor = ($prod_store==1)?'UP':'PD';
			 // mysql_query("update orders set label=' $orderfor' where order_id=$oid");
			  
			  $sql = "select a.cname, a.name, a.address1, a.address2, a.city, a.state, a.country, a.pin, a.tel_res, a.tel_off, a.mobile, email
					from address a where aid = ". $aid;
					$result = mysql_query($sql);
					$num_rows = mysql_num_rows($result);
					if ($num_rows>0)
					{			
						$row=mysql_fetch_array($result);	
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
						$fax = $row["fax"];								
						$mobile = $row["mobile"];
						$email = $row["email"]; //mysql_query("select email from users where id=". u_id)(0)	
					}
			 	?>
                                        <p><strong><? echo $name?></strong></p>
                                        <? if ($cname!="") {?>
                                        <p><? echo $cname?></p>
                                        <? }?>
                                        <p><? echo $address1?></p>
                                        <p><? echo $city?> - <? echo $pin?></p>
                                        <p><? echo $state?> (<? echo $country?>)</p>
                                        <p>Phone: <? echo $mobile?>, <? echo $tel_res?></p>
                                        <p>Email: <? echo $email?></p>
                                        
                                        </div>
                                       </div>
                                       
                                       <div class="col-xs-12 col-md-6">
                                       <div class="bor p10">
                                       
                                        <p class="ttu bb1">Shipping Details</p>
                                        <?
			   $sql = "select a.cname, a.name, a.address1, a.address2, a.city, a.state, a.country, a.pin, a.tel_res, a.tel_off, a.mobile, email
					from address a where   aid = ". $sid;
					$result = mysql_query($sql);
					$num_rows = mysql_num_rows($result);
					if ($num_rows>0)
					{			
						$row=mysql_fetch_array($result);	
						$cname_s = $row["cname"];			
						$name_s = $row["name"];
						$address1_s = $row["address1"];
						$address2_s = $row["address2"];
						$city_s = $row["city"];
						$state_s = $row["state"];
						$pin_s = $row["pin"];
						$country_s = $row["country"];
						$tel_res_s = $row["tel_res"];
						$tel_off_s = $row["tel_off"];
						$fax_s = $row["fax"];								
						$mobile_s = $row["mobile"];
						$email_s = $row["email"]; //mysql_query("select email from users where id=". u_id)(0)	
					}
			  ?>
                                        <p><strong><? echo $name_s?></strong></p>
                                        <? if ($cname_s!="") {?>
                                        <p><strong><? echo $cname_s?></strong></p>
                                        <? }?>
                                        <p><? echo $address1_s?></p>
                                        <p><? echo $city_s?> - <? echo $pin_s?></p>
                                        <p><? echo $state_s?> (<? echo $country_s?>)</p>
                                        <p>Phone: <? echo $mobile_s?>, <? echo $tel_res_s?></p>
                                        <p>Email: <? echo $email_s?></p>
                                       </div>
                                       </div>
                                       
                                       <? if ($type=="print")  { ?>
                                       <div class="col-xs-12 col-md-6">
                                        
                                        <p><strong><? echo $name_s?></strong></p>
                                        <? if ($cname_s!="") {?>
                                        <p><strong><? echo $cname_s?></strong></p>
                                        <? }?>
                                        <p><? echo $address1_s?></p>
                                        <p><? echo $city_s?> - <? echo $pin_s?></p>
                                        <p><? echo $state_s?> (<? echo $country_s?>)</p>
                                        <p>Phone: <? echo $mobile_s?>, <? echo $tel_res_s?></p>
                                        <p>Email: <? echo $email_s?></p>
                                        
                                        <p><strong><? echo $name_s?></strong></p>
                                        <? if ($cname_s!="") {?>
                                        <p><strong><? echo $cname_s?></strong></p>
                                        <? }?>
                                        <p><? echo $address1_s?></p>
                                        <p><? echo $city_s?> - <? echo $pin_s?></p>
                                        <p><? echo $state_s?> (<? echo $country_s?>)</p>
                                        <p>Phone: <? echo $mobile_s?>, <? echo $tel_res_s?></p>
                                        <p>Email: <? echo $email_s?></p>
                                        
                                        
                                       </div>
                                      <? }?> 
                                       
                                       
                                      <? if ($type!="print")  { ?> 
                                       <p class="m-t-20"><h4 class="ttu bb1">Order Status Tracking</h4></p>
                                       <div id="orderStatus">
		   									<script>fn_getOrderTrail(<? echo $oid ?>)</script>
		   								</div>
                                       <? } ?>
               <div class="cb"></div>
                </div>
                                       
                    
               <div class="cb"></div>
               </div>
                                       
                                       
                
              
                </div>
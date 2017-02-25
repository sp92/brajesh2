<div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp aj animated animated p0 m0" style="visibility: visible; -webkit-animation-name: fadeInUp; animation-name: fadeInUp;">
	<div class="more-info-tab clearfix">
   		<h3 class="new-product-title pull-left"><b class="copN"> My </b> <b class="copR">Orders</b></h3>
 	</div>
 	<div class="wOA">
  		<table class="shop_table" border="1">
    		<thead>
         		<tr>
           			<th class="order-number"><span class="nobr">Order #</span></th>
                 	<th class="order-date"><span class="nobr">Date</span></th>
               		<th class="order-status"><span class="nobr">Ship To</span></th>
           			<th class="order-total"><span class="nobr">Order Total</span></th>             		<th class="order-actions"><span class="nobr">Status </span></th>
              		<th class="order-actions"><span class="nobr">  </span></th>
         		</tr>
      		</thead>
        	<tbody>
            <?
			 $sql = "select * from orders o, users u where user_id=id and user_id = '". $_SESSION["userid"] ."' order by order_id desc limit 0,50 ";
			 $prod_arr = mysql_query($sql);
			 $num_rows = mysql_num_rows($prod_arr);					 
			 while($row1=mysql_fetch_array($prod_arr))
			 {
			 
			?>
      			<tr class="order">
           			<td class="order-number"><? echo $OrderPrefix.'/'.$row1["order_id"]?></td>
            		<td class="order-date"><? echo date('d/m/Y', strtotime($row1["order_date"]))?></td>
               		<td class="order-status"><? echo $row1["name"]?></td>
            		<td class="order-total">&nbsp;Rs.<? echo $row1["total_amount"]?></td>
         			<td class="order-actions"><? echo $row1["order_status"]?></td>
            		<td class="order-actions"><a href="account.php?page=orderinfo&oid=<? echo $row1["order_id"]?>" class="btn btn-sm style1 view no-margin">View</a></td>
      			</tr>
                <? }
		  if ($num_rows==0)
		  {
		   ?>
           <tr class="order">
           			<td class="order-number" colspan="6">No order placed yet.</td>
      			</tr>
                <? } ?>
   			</tbody>
       	</table>
    	<div class="cb"></div>
 	</div>
 </div>
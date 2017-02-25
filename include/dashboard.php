<?
$sql = "select * from users where email = '". $_SESSION["email"] ."'";
$result = mysql_query($sql);
$row=mysql_fetch_array($result)
?>
<div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp aj animated animated" style="visibility: visible; -webkit-animation-name: fadeInUp; animation-name: fadeInUp;">
	<div class="more-info-tab clearfix ">
  		<h3 class="new-product-title pull-left">
     		<b class="copN">MY</b> 
       		<b class="copR">DASHBOARD</b>
     	</h3>
	</div>
    <h4>Hello <? echo $_SESSION["username"] ?>!</h4>
 	<p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.</p>
 	<hr>
  	<h4 class="new-product-title pull-left">
   	<b class="copN">MY</b> 
  	<b class="copR">DASHBOARD</b>
 	<span class="fr">
 		<a href="<? echo fn_link('account.php?page=orders')?>">View All</a>
   	</span>
 	</h4>                 	
	<div class="wOA">
 	<table class="shop_table" border="1">
 		<thead>
 			<tr>
   				<th class="order-number"><span class="nobr">Order #</span></th>
            	<th class="order-date"><span class="nobr">Date</span></th>
           		<th class="order-status"><span class="nobr">Ship To</span></th>
          		<th class="order-total"><span class="nobr">Order Total</span></th>          		<th class="order-actions"><span class="nobr">Status </span></th>
           		<th class="order-actions"><span class="nobr">  </span></th>
         	</tr>
    	</thead>
		<tbody>
        <?
					 $sql = "select * from orders o, users u where user_id=id and user_id = '". $_SESSION["userid"] ."' order by order_id desc limit 0,5 ";
					 $prod_arr = mysql_query($sql);
					 $num_rows = mysql_num_rows($prod_arr);					 
					 while($row1=mysql_fetch_array($prod_arr))
					 {
					 
					?>
  			<tr class="order">
         		<td class="order-number"><? echo $OrderPrefix.'/'.$row1["order_id"]?></td>
         		<td class="order-date"><? echo date('d/m/Y', strtotime($row1["order_date"]))?></td>
           		<td class="order-status"><? echo $row1["name"]?></td>
        		<td class="order-total">Rs.<? echo $row1["total_amount"]?></td>
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
                                       
                                       
               <table class="shop_table" border="1">
                <thead>
                    <tr>
                        <th class="review-date">Account Information</th>
                       <th class="product-name">&nbsp;  </th>
                        <th class="product-review">&nbsp;  </th>
                        <th class="product-comment">&nbsp;  </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="review-date"><h4>Profile Details</h4></td>
                        <td class="product-name">&nbsp;  </td>
                        <td class="product-review">&nbsp;  </td>
                        <td class="product-comment">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td class="review-date">
                        <p><? echo $row["name"]?><br />
   						<? echo $row["email"]?></p></td>
                        <td class="product-name">
                        	<a href="account.php?page=personal"> Edit </a>| <a href="account.php?page=changepwd">Change Password</a>
                  		</td>
                        <td class="review-date" style="display:none;">
                        <h3>Newsletters</h3>
                        <? if ($row["newsletter"] == 0) {?>
                          		<p> You are currently not subscribed to any newsletter. </p>
							<? } else {?>
								<p> You have subscribed the newsletter. </p>
							<? } ?></td>
                        <td class="product-name">
                        	&nbsp;
                  		</td>
                        <td class="product-review">&nbsp;</td>
                        <td class="product-comment">&nbsp;  </td>
                    </tr>
                    
                    
                    
                </tbody>                  
            		</table>
                	<?
					 $sql = "select * from address where defaultadd=1 and  uid = '". $_SESSION["userid"] ."'";
					 $prod_arr = mysql_query($sql);
					 $num_rows = mysql_num_rows($prod_arr);					 
					 while($row1=mysql_fetch_array($prod_arr))
					 {
					 }
					?>
                <div class="cb"></div>
                </div>
              
                </div>
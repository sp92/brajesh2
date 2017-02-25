<div class='col-md-12 bgwhite'>
				<div class="clearfix filters-container pt1">
            		<div class="row">
                		<div class="col col-sm-6 col-md-3 fl">
                    		<div class="filter-tabs">
                    <h3 class="mp0"><b class="copR">wishlist</b></h3>
                    </div>
                </div>
                
            </div>
        </div>
				<div class="search-result-container">
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active " id="grid-container">
							<div class="category-product  inner-top-vs">
                               <div class="row">									
                                    
                                
                                    <?
   if (get("delid") != "")
	 {
		$sql = "delete  from cart where cart_id=". get("delid");
		mysql_query($sql);
		echo "<script> alert('Item deleted from wishlist.')</script>";
	 }
 
 if ($uid!="")
 	$extra = " and c.user_id=$uid";
	
 $SalePrice=0;
 $sql = "select * from products p, cart c where c.prod_id=p.prod_id and prod_wish=1 and sessionid = '$sid' $extra ";
 $prod_arr = mysql_query($sql);
 while($row=mysql_fetch_array($prod_arr))
 {				
	$pic = getpic("prod_pic/small/". trim($row["prod_pic"]));		
				
	$MRP = round(GetCurrencyRate($row["prod_id"],"M") * $row["prod_rate"],0);					
	$PrintMRP = round(GetCurrencyRate($row["prod_id"],"S") * $row["prod_sprate"],0);								
	$SalePrice = GetFinalPrice($row["prod_id"], $MRP);
	$Discount=0;
	if ($PrintMRP > 0) 
		$Discount = round((($PrintMRP - $SalePrice) * 100) / $PrintMRP);
				 
	 $pid=$row["prod_id"];
	 // Get product Rating
	 $rating =  getProdRatings($pid);
	 $avg = $rating["Average"];
	 $rCount = $rating["ReviewsCnt"];
	 // End Ratings
			 include("include/prod_list_template.php");			
        } 
   if ($SalePrice == 0)
   {
   		echo "<li>- There is no item in your wishlist.</li>";
   }
 
 ?>
                                
                                    
                                
                                    
                    
         </div>
      </div>
     </div>

    
					</div>
					

				</div>

			</div>
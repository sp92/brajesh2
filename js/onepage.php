<?php include("top.php"); ?>
<?php include("header.php"); ?>


<div class="body-content">
<section class="breadcrumb-bg pb30">     
                <span class="gray-color-mask color-mask"></span>
                <div class="theme-container container">
                    <div class="site-breadcrumb relative-block space-75">
                        <h3 class="sub-title"> Checkout </h3>
                        <hr class="dash-divider">
                        <ol class="breadcrumb breadcrumb-menubar">
                            <li><a href="<? echo $SiteUrl; ?>">Home</a>  >  <span class="blue-color"> Checkout </span> </li>                             
                        </ol>
                    </div>  
                </div>
            </section>
  <div class="container pr1">
  <div class="col-xs-12 col-sm-12 col-md-3" >
  <div class="breadcrumb mb0">
  

    
  </div></div>
  
    <div class="checkout-box inner-bottom-sm">
         <form method="post" action="orderprocess.php">
          <div class="col-md-12 p0 bgwhite">
          <div class="panel-group checkout-steps pt20" id="accordion">
          <div class="w100">
                 <div class="title-2 sub-title-small bgwhite borb1"> Checkout Processes </div>
                 </div>
          
            <? if ($_SESSION["userid"]=="") {  ?>
            <div class="bgwhite col-md-12">Already registered? <a class="md-trigger" data-modal="modal-1"><strong style="cursor: pointer;">LOGIN HERE</strong></a></div>
            <div class="bgwhite col-md-12 p10 mb20"> Fill in the Fields below to complete your purchase! </div>
            <? } else {?>
            <!--<div class="bgwhite col-md-12 p10 mb20"></div>-->
            <div></div>
            <? } ?>
            <div class="col-md-4">
              <div class="checkout-progress-sidebar ">
                <div class="panel-group">
                  <div class="panel panel-default checkH">
                    <div class="panel-heading">
                      <h4 class="unicase-checkout-title title-2 sub-title-small bgwhite borb1"> Shipping & Billing Address </h4>
                    </div>
                    <div class="panel-body mp0">
                      <?
								  $DefCountry = 'India';
								  $disp = "none";
								  if ($_SESSION["userid"]!="")
								  {
								  ?>
                      <div id="existing-add">
                        <?
										$sql = "select * from address where uid=".$_SESSION["userid"]; 
										$result = mysql_query($sql);
										$num_rows = mysql_num_rows($result);
										if ($num_rows>0)
										{
											echo  '&nbsp;<strong>Select from existing address!</strong>
												   <div style="overflow:auto; max-height:400px" class="w100">';
										}
										
										while($row1=mysql_fetch_array($result))
										{
											$AddressInfo = "";
											$selaid = $row1["aid"];
											$AddressInfo = $AddressInfo .  $row1["name"];
											$AddressInfo = $AddressInfo . "<br>" . $row1["address1"];
											if ($row1["address2"]!="")		
												$AddressInfo = $AddressInfo . "<br> Landmark: " . $row1["address2"];							
											$AddressInfo = $AddressInfo . "<br> " . $row1["city"];
											$AddressInfo = $AddressInfo . "<br>" . $row1["state"];
											$AddressInfo = $AddressInfo . "-" . $row1["pin"];
											$AddressInfo = $AddressInfo . " (" . $row1["country"] . ")";
											$AddressInfo = $AddressInfo . "<br>Phone: " . $row1["tel_res"];
											$AddressInfo = $AddressInfo . "<br>Mobile: " . $row1["mobile"];
											$AddressInfo = $AddressInfo . "<br>Email: " . $row1["email"];
											
											$star ="";
											$chk = "";
											if ($row1["defaultadd"]==1) $star ="#FFD9D9";
											if ($selaid == $aid) $chk = "checked";
											$extarAttrib="";
											if ($row1["email"]=="") $extarAttrib = "disabled title='Address without email cann`t be choosen as billing address.' ";
											?>
											<div class="m5 p5 fs12" style="border:#CCCCCC solid 1px; padding:5px; margin:5px;  background-color:<? echo $star?>"> <? echo $AddressInfo ?><br />
											  <strong>Choose this address as: </strong>
											  <input type="radio"  <? echo $extarAttrib?> class="billing" required name="billing"  onclick="$('#bid').val('<? echo  $selaid ?>'); fn_setAttrib(false,'#')" />
											  Billing
											  <input type="radio" class="shipping"  required name="shipping"  onclick="$('#sid').val('<? echo  $selaid ?>');" />
											  Shipping </div>
											<?						
                                    }
                                    if ($num_rows > 0)
                                        echo '</div>
                                              <br />&nbsp;&nbsp;	<a href="#" onclick="fn_otherAdd()"><strong>Other Address</strong></a><br /><br />';						
                                    else
                                        $disp = "inline";
                                    ?>
							  </div>
							  <? 
                                }
                                else
                                {
                                    $disp = "inline";
                                }
                                ?>
                     
                      <div class="col-md-12 col-sm-6 guest-login p10" style="display:<? echo $disp ?>" id="add-form">
					   <? if ($num_rows > 0) { ?>
                     <? if ($_SESSION["userid"]!="") {  ?>
                      &nbsp;&nbsp;<a href="#" onclick="fn_existingAdd()"><strong>Choose address from existing address list</strong></a><br /><br />
					   <? } }?>
					  <div class="col-md-12 col-sm-6 guest-login p10"  >
                        <div class="col-md-6 ">
                          <div class="form-group">
                            <input name="name" id="name" type="text" required class="form-control unicase-form-control text-input" placeholder="Name">
                          </div>
                        </div>
                        <div class="col-md-6 ">
                          <div class="form-group">
                            <input name="company" id="company" type="text" class="form-control unicase-form-control text-input" placeholder="Company">
                          </div>
                        </div>
                        <div class="col-md-12 ">
                          <div class="form-group">
                            <textarea name="address" id="address"  cols="" rows="" required class="form-control unicase-form-control text-input" placeholder="Address..."></textarea>
                          </div>
                        </div>
                        <div class="col-md-12 ">
                          <div class="form-group">
                            <input name="landmark" id="landmark" type="text" class="form-control unicase-form-control text-input" placeholder="Landmark...">
                          </div>
                        </div>
                        <div class="col-md-6 ">
                          <div class="form-group">
                            <input name="city" id="city" type="text" required class="form-control unicase-form-control text-input" placeholder="City">
                          </div>
                        </div>
                        <div class="col-md-6 ">
                          <div class="form-group">
                            <select class="form-control unicase-form-control text-input" name="state" id="state" required>
                              <? echo fn_ddl("State", '')?>
                            </select>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 ">
                          <div class="form-group">
                            <input name="pin" id="pin" type="text" maxlength="6" required class="form-control unicase-form-control text-input" placeholder="Pincode">
                          </div>
                        </div>
                        <div class="col-md-6 ">
                          <div class="form-group">
                            <select name="country" id="country" defaultvalue="India" required class="form-control unicase-form-control text-input">
                              <? echo fn_ddl("Country", $DefCountry)?>
                            </select>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 ">
                          <div class="form-group">
                            <input name="phone" id="phone" type="text" class="form-control unicase-form-control text-input" placeholder="Phone no">
                          </div>
                        </div>
                        <div class="col-md-6 ">
                          <div class="form-group">
                            <input name="mobile" id="mobile" type="text" required class="form-control unicase-form-control text-input" placeholder="Mobile">
                          </div>
                        </div>
                        <div class="col-md-12 ">
                          <div class="form-group">
                            <input name="email" id="email" type="email" required class="form-control unicase-form-control text-input" placeholder="Email...">
                          </div>
                          <div class="form-group w100 fl">
                            <input name="shipadd" id="shipadd" type="checkbox" value="1" onclick="fn_CheckShipping()" class="mr15 fl">
                            <label class=" fl" for="guest"> Ship to other address</label>
                          </div>
                        </div>
                      </div>
                      <div class="panel-body mp0" id="shipping-address" style="display:none">
                          <div class="col-md-6 ">
                            <div class="form-group">
                              <input name="sname" id="sname" type="text" class="form-control unicase-form-control text-input" placeholder="Name">
                            </div>
                          </div>
                          <div class="col-md-6 ">
                            <div class="form-group">
                              <input name="scompany" id="scompany" type="text" class="form-control unicase-form-control text-input" placeholder="Company">
                            </div>
                          </div>
                          <div class="col-md-12 ">
                            <div class="form-group">
                              <textarea name="saddress" cols="" rows="" class="form-control unicase-form-control text-input" placeholder="Address..."></textarea>
                            </div>
                          </div>
                          <div class="col-md-12 ">
                            <div class="form-group">
                              <input name="slandmark" id="slandmark" type="text" class="form-control unicase-form-control text-input" placeholder="Landmark...">
                            </div>
                          </div>
                          <div class="col-md-6 ">
                            <div class="form-group">
                              <input name="scity" id="scity" type="text" class="form-control unicase-form-control text-input" placeholder="City">
                            </div>
                          </div>
                          <div class="col-md-6 ">
                            <div class="form-group">
                              <select class="form-control unicase-form-control text-input" name="sstate" id="sstate">
                                <? echo fn_ddl("State", '')?>
                              </select>
                            </div>
                          </div>
                          <div class="clearfix"></div>
                          <div class="col-md-6 ">
                            <div class="form-group">
                              <input name="spin" id="spin" type="text" maxlength="6" class="form-control unicase-form-control text-input" placeholder="Pincode">
                            </div>
                          </div>
                          <div class="col-md-6 ">
                            <div class="form-group">
                              <select name="scountry" id="scountry" defaultvalue="India" class="form-control unicase-form-control text-input">
                                <? echo fn_ddl("Country", $DefCountry)?>
                              </select>
                            </div>
                          </div>
                          <div class="clearfix"></div>
                          <div class="col-md-6 ">
                            <div class="form-group">
                              <input name="sphone" id="sphone" type="text" class="form-control unicase-form-control text-input" placeholder="Phone no">
                            </div>
                          </div>
                          <div class="col-md-6 ">
                            <div class="form-group">
                              <input name="smobile" id="smobile" type="text" class="form-control unicase-form-control text-input" placeholder="Mobile">
                            </div>
                          </div>    
						  </div>                   
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="checkout-progress-sidebar">
                <div class="panel-group">
                  <div class="panel panel-default checkH">
                    <div class="panel-heading">
                      <h4 class="unicase-checkout-title title-2 sub-title-small bgwhite borb1">Shipping Charges</h4>
                    </div>
                    <div class="panel-body">
                      <p>
                        <? if ($_SESSION["freight"] =="") {?>
                        Free Shipping
                        <? } else {?>
                        Rs. <? echo $_SESSION["freight"] ?>/- (Via Post)
                        <? } ?>
                      </p>
                      <div class="guest-login">
                        <h4 class="checkout-subtitle"> Payment Method </h4>
                        <div class="radio radio-checkout-unicase">
                          <input style="margin-left:0px" name="Payment" type="radio" value="CC" required />
                          <label class="radio-button guest-check" for="guest">Online Payment<br />
                          (Credit Card, Net Banking and any other Online Payment method)</label>
                          <br>
                          <input style="margin-left:0px" name="Payment" type="radio" value="DD/Cheque/MO" required />
                          <label class="radio-button" for="register">Demand Draft / Money Order</label>
                        </div>
                        <label class="radio-button" for="register">Remarks</label>
                        <textarea name="remarks" cols="" rows="" placeholder="Write some text here..." class="w100 mb10"></textarea>
                        <? 
                      $sql = "select count(*) from discountmaster where discount_type='Coupon' 
                              and store_id=$StoreId and '$today' between start_date and end_date and discount_coup_max>0 and active=1";
                      if (getValue($sql)>0 ) { ?>
                        <div class="col-md-12 ">
                          <h3>Discount Coupon</h3>
                          <div class="form-group">
                            <input name="coupon" id="coupon" type="text" class="form-control unicase-form-control text-input" placeholder="Enter your coupon code">
                            <div id="coup-msg" class="red"></div>
                          </div>
                        </div>
                        <button class="btn-upper btn btn-primary checkout-page-button checkout-continue m-t-15" type="button" onClick="fn_coupon()">
                        Apply
                        </button>
                        <? }?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="checkout-progress-sidebar ">
                <div class="panel-group">
                  <div class="panel panel-default checkH">
                    <div class="panel-heading">
                      <h4 class="unicase-checkout-title title-2 sub-title-small bgwhite borb1">Review Your Order</h4>
                    </div>
                    <div class="panel-body"> <span id="order_items"> </span>
                      <input name="bid" id="bid" type="hidden" value="" />
                      <input name="sid" id="sid" type="hidden" value="" />
                      <div id="check-out m-t-15"></div><br>

					
                      <button class="blue-btn btn" type="submit" value="Place Order" onclick = "//return fn_validateOrder($('#NetPayment').val())">Place Order</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="cb"></div>
          </div>
          <script>
	fn_orderitems(true);
	</script>
        </form>
     </div>
  </div>
</div>
</div>
<?php include("footer.php"); ?>
</body></html>
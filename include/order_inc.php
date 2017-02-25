<table>
<tr>
  <td valign="top">
 	<style>
	td
	{
		padding:5px;
	}
	</style>
	 <?
		if (get("order") == "can")
		{
			mysql_query("Delete from  cart where sessionid = '". session_id() ."'");
			echo "<script>location.href = 'index.php?mess=Order canceled'</script>";
		}
	 
		$active=1;
		$action="new";
		$u_id = $_SESSION["userid"];
		$aid = get("aid");
		if ($u_id != "") 
		{
			$action="edit";
			$sql = "select a.cname, a.name, a.address1, a.address2, a.city, a.state, a.country, a.pin, a.tel_res, a.tel_off, a.mobile, u.email
						 from address a, users u where u.id=a.uid and uid=". $u_id . " and aid = ". $aid;
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
		}
		?>

		  
		  <? //response.write get("add") 
			$sql = "select prod_pic, writer_e, c.cart_id, p.prod_id, prod_code, prod_name, prod_name_e, prod_qty, prod_rate,  prod_sprate from cart c, products p where c.prod_id = p.prod_id and sessionid = '$sid'";
			$rsCart = mysql_query($sql);
			$num_rows = mysql_num_rows($rsCart);
		  ?>
		  <? if ($num_rows>0)
		  { 		  
		  ?>
			  <table border="01" align="center" width="100%" cellpadding="3" cellspacing="1" bgcolor="#666666" style="width:690px" >
				<tr bgcolor="#F8F8F8" align="left" >
				  <td align="left" valign="bottom"  style="width:50px"  ><span><strong>Code</strong></span></td>
				  <td  align="left" valign="bottom"  ><span><strong>Book Name</strong></span></td>
				  <td align="left" valign="bottom" style="width:50px" ><span><strong>Quantity</strong></span></td>
				  <td align="left" valign="bottom"  style="width:70px" ><span><strong>Rate</strong></span></td>
				  <td align="left" valign="bottom"  style="width:70px" ><span><strong>Discount</strong> %</span></td>
				  <td align="right" valign="bottom"  style="width:70px"  ><span><strong>Amount</strong></span></td>
				  
				</tr>
				<?
				$fc=0;
				$intQty = 0;
				while($row=mysql_fetch_array($rsCart))
				{
					$n++;
					$tamount = $tamount + ($row["prod_qty"] * $row["prod_rate"]);
					$discount=  round((($row["prod_sprate"] - $row["prod_rate"]) * 100) / $row["prod_sprate"]);
					$pic = getpic("prod_pic/small/". trim($row["prod_pic"]).".jpg");
				?>
				 		<tr valign="top" class="sectiontableentry1 png" style="background-color:#FFFFFF">
						  <td align="left" class="second"><span><? echo $row["prod_code"]?></span></td>
                          <td align="left" class="first"><span><? echo $row["prod_name_e"]?> </span> </td>
                          <td align="middle" ><span><? echo $row["prod_qty"]?></span>
                          </td>
                          <td align="right" ><span>Rs.<? echo $row["prod_qty"] *$row["prod_rate"]?>&nbsp;</span></td>
                           <td align="right"><span>
                          <? echo  $discount ?>%&nbsp;</span></td>
                          <td align="right" ><span>Rs.<? echo $row["prod_qty"] * $row["prod_rate"]?>&nbsp;</span></td>                          
                        </tr>
					<? 
					$mrpTotal =$mrpTotal +  ($row["prod_qty"] * $row["prod_sprate"]);
					$intQty = $intQty + $row["prod_qty"];
					$intMRPSaving = $mrpTotal - $tamount;
					
					}
					$intMRPSaving =0;
					?>
					
				 <tr valign="top" style="background-color:#FFFFFF">
				  <td colspan="5" align="right" bgcolor="#FFFFFF" ><strong>Total Saving on Cover Price</strong></td>
				  <td align="right" bgcolor="#FFFFFF" >Rs.<? echo $intMRPSaving?> </td>
				  
				</tr>
				
				<tr valign="top" style="background-color:#FFFFFF">
				  <td colspan="5" align="right" bgcolor="#FFFFFF" ><strong>No. of Items Ordered</strong></td>
				  <td align="right" bgcolor="#FFFFFF" ><? echo $intQty?> </td>
				  
				</tr>
				<? if ($tamount < 500 )
				  {
						$shipping = 50;
						$_SESSION["freight"] = $shipping;										
				 ?>
			   <tr valign="top"  style="background-color:#FFFFFF">
				  <td colspan="5" align="right" bgcolor="#FFFFFF" ><strong>Shipping Charge</strong></td>
				  <td align="right" bgcolor="#FFFFFF" >Rs.<? echo $shipping?><input name="freight" type="hidden" id="freight" value="<? echo $shipping?>" /></td>
				
				</tr>
				<?
				}
				else
				{
					$_SESSION["freight"] = 0;							
				}?>
				<tr valign="top"  style="background-color:#FFFFFF">
				  <td colspan="5" align="right" bgcolor="#FFFFFF" ><strong>Your Shopping  Total </strong></td>
				  <td align="right" bgcolor="#FFFFFF">Rs.<? echo ($tamount+$shipping)?></td>
				  
				</tr>
			  </table>
		   		<?
				$_SESSION["tot_inr"] = $tamount+$shipping;
				?>
			<?
		} 
		else 
		{  ?>
			<div align="center"> <span class="pgh2"> No items in your shopping cart </span> </div>
		<? }?>
	<br />
	
	<form  method="post" name="form1" action="orderprocess.php" id="form1" onsubmit="//return valid(this)">
	<input type="hidden" name="discount" value="<? echo $discount ?>" />
	<input type="hidden" name="postOfficeFees" value="0" />
	<input type="hidden" name="aid" value="<? echo $aid ?>" />
   <div class="page-title">
	  <h1>Payment Details</h1>
	</div>
	  <div align="center"><span class="skycolorfont">Total Payment :</span>
			<select name="paymentT" id="paymentT">
				<!--
					  <option value="U|<? echo $_SESSION["tot_usd"]?>" selected="selected">$ <? echo  $_SESSION["tot_usd"]?></option>
					  <option value="P|<? echo  $_SESSION["tot_ukp"]?>">&pound; <? echo  $_SESSION["tot_ukp"]?></option>
					  -->
				<option value="I|<? echo  $_SESSION["tot_inr"]?>">INR <? echo  $_SESSION["tot_inr"]?></option>
				</select>
		</font>
	  </div>
	  <table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		  <td  width="34%" align="right" class="runninfont"><font face="Arial, Helvetica, sans-serif"><b>Payment by:</b></font></td>
		  <td valign="top" align="left">
		  
			<input name="Payment" type="radio" value="CC"  checked="checked" class="nowidth" /> 
			Credit Card<br />
			<input name="Payment" type="radio" value="DD/Cheque/MO" class="nowidth" />
			DD/Cheque/MO
			<!--<input type="radio" name="Payment" value="VPP" />
			VPP-->
			
			</td>
		</tr>
		<tr>
		  <td width="34%" align="right" valign="top" class="runninfont"><b><font face="Arial, Helvetica, sans-serif">Order Remarks<br />
			(If Any):</font></b></td>
		  <td width="66%" class="runninfont"><font face="Arial, Helvetica, sans-serif">
			<textarea name="remarks" cols="45" rows="4"></textarea>
			<br />
			(max 250 Characters)</font></td>
		</tr>
		<tr>
		  <td width="34%" align="right" valign="top" class="runninfont"><font face="Arial, Helvetica, sans-serif"><b>Payment Details <br />
			(</b>if payment type DD/Cheque/MO<b>): </b></font></td>
		  <td width="66%" class="runninfont"><font face="Arial, Helvetica, sans-serif">
			<textarea name="paymentDet" cols="45" rows="3"></textarea>
		  </font></td>
		</tr>
	  </table>
	 
	  </p>

	<div class="page-title">
	  <h1>Billing/Shipping Details</h1>
	</div>
	  <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">  
	  	<? if ($cname!="") {?>                 
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>Company Name:</b></div></td>
		  <td width="65%" class="runninfont"><? echo $cname?></td>
		</tr>
		<? }?>
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>Your Name:</b></div></td>
		  <td width="65%" class="runninfont"><? echo $name?><font color="#FF0000">
			<input type="hidden" name="aid" value="<? echo $aid?>" />
			</font></td>
		</tr>
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>Address:</b></div></td>
		  <td width="65%" class="runninfont"><? echo $address1?></td>
		</tr>
		<tr>
		  <td width="35%" class="runninfont"><div align="right">&nbsp;</div></td>
		  <td width="65%" class="runninfont"><? echo $address2?></td>
		</tr>
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>City:</b></div></td>
		  <td width="65%" class="runninfont"><? echo $city?></td>
		</tr>
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>State:</b></div></td>
		  <td width="65%" class="runninfont"><? echo $state?>
			<font color="#FF0000"><b><font color="#000000">Pin:</font></b></font>
			<? echo $pin?>
		  </td></tr>
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>Country:</b></div></td>
		  <td width="65%" class="runninfont"><? echo $country?>
		  </td></tr>
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>Telephone No. :</b></div></td>
		  <td width="65%" class="runninfont"><? echo $tel_res?>
			<font color="#FF0000"><font color="#000000">(Res)</font></font> </td>
		</tr>
	   <!-- <tr>
		  <td width="35%" class="runninfont"><div align="right"><b>Telephone No. :</b></div></td>
		  <td width="65%" class="runninfont"><? echo $tel_off?>
			<font color="#FF0000"><font color="#000000">(Office)</font></font> </td>
		</tr>
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>Fax No. :</b></div></td>
		  <td width="65%" class="runninfont"><? echo $fax?>
		  </td></tr>
		<tr>-->
		  <td width="35%" class="runninfont"><div align="right"><b>Mobile:</b></div></td>
		  <td width="65%" class="runninfont"><? echo $mobile?></td>
		</tr>
		<tr>
		  <td width="35%" class="runninfont"><div align="right"><b>Email:</b></div></td>
		  <td width="65%" class="runninfont"><? echo $email?></td>
		</tr>
		<tr align="center">
		  <td colspan="2">
		  <div align="center">>
			  <font size="2" face="Arial, Helvetica, sans-serif">
			  <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:100px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-70px;" value="Process Order" />
			  <input name="Cancel" type="button" style="background-color:#BF040D; color:#ffffff; width:100px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:10px;"  id="Cancel" value="Cancel Order" onclick="location.href='order.php?order=can'" />
			</font></div></td>
		</tr>
	  </table>
	</form> 
	 
  </td>
</tr>
</table>
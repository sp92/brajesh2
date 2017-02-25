<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");


//print_r($_POST); exit;
?>


<div class="my-account">
  <div class="dashboard">
    <div class="page-title">
      <h1>Manage Discount </h1>
    </div>
    <?
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");
  	
if (get("Submit3")!= "")
{
	$store_id=$_SESSION["StoreId"];
	$discountType = get("discountType");
	$startdate = get("startdate");
	$enddate = get("enddate");
	$discountcalculation = get("discountcalculation");
	$DiscountValue = get("DiscountValue");
	$active = get("active");
	$discount_coup_max = get("discount_coup_max");

	if ($discountType!="Coupon" && $discountType!="Book" )
	{
		$book_value=array();
		$book_value=$_POST['discount_items'];
		$discount_items= implode(',',$book_value); 
	}	
	else
		$discount_items = get("discount_coup");
		
	if ($row_id==0)
	{	
		$sql = "insert into discountmaster Set 
								store_id = $store_id,
								discount_type='$discountType',
								discount_items='$discount_items',
								discount_coup_max = '$discount_coup_max',
								start_date='$startdate', 
								end_date='$enddate',
								discount_calc='$discountcalculation',
								discount_value	='$DiscountValue',
								discount_user	='0',
								active='$active'";	 
	}
	else
	{
		 $sql = "update discountmaster Set 
								discount_type='$discountType',
								discount_items='$discount_items',
								discount_coup_max = '$discount_coup_max';
								start_date='$startdate', 
								end_date='$enddate',
								discount_calc='$discountcalculation',
								discount_value	='$DiscountValue',
								active='$active'
				where d_id=$row_id ";
		$event_id =  $row_id ;
	}
	//echo $sql;
	mysql_query($sql);
	
	// Upload Images
	
	
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');parent.location.href='managediscount.php' </script>";
}

/*
$sql = "select * from events where event_id=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$type = $row["type"];	
	$etitle = $row["title"];			
	$startdate = $row["fromdate"];
	$enddate = $row["enddate"];
	$details = $row["details"];
	$link = $row["link"];
	$active = $row["active"];
	if ($active == 1)
		$active = "checked";
	else
		$inactive = "checked";
		
	$english = $row["lang"];
	if ($english == 'E')
		$english = "checked";
	else
		$hindi = "checked";
}

*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/styles.css" rel="stylesheet" type="text/css" /> 

<script type="text/javascript" src="js/jquery.js"></script>

</head>


  <script>
	$(document).delegate( "#discountType", "change", function() { 
		 var disType=$("#discountType").val();
		  $("#discount_coup").hide();
		  $("#discount_coup_count").hide();
		  $("#discount_items").show();
		   $("#instructions").text('');
		 var tab;
		 var id;
		 var name;
		 //alert(disType);
		 if(disType=='Category'){
				 tab='category';
				 id='cat_id';
				 name='cat_title';
			}
		 else if(disType=='Sub Category'){
				 tab='subcategory';
				 id='subcat_id';
				 name='subcat_title';
			}
		  else if(disType=='Publisher')
			{
				 tab='publisher';
				 id='publisher_code';
				 name='publisher_name';
			}
			/*
		  else if(disType=='Book')
			{
				tab='products';
				id='prod_id';
				name='prod_name_e';
			}*/
		  else if(disType=='Traders')
		  {
			 tab='subcategory';
			 id='subcat_id';
			 name='subcat_title';
		  }
		  else if (disType=='Coupon')
		  { 		  
			 $("#discount_items").hide();
			 $("#discount_coup").show();
			 $("#discount_coup_count").show();
			 $("#instructions").text('like: 100NEWYEAR2015');
		  }
		  else if (disType=='Book')
		  { 		  
			 $("#discount_items").hide();
			 $("#discount_coup").show();
			 //$("#discount_coup_count").show();
			 $("#instructions").text('like: 1234, 1345, 6678');
		  }
		 $("#dis_item_name").removeAttr("style");
		 $("#disType_name b").text(disType); 
		 if (disType=='Book')
		 {
		 	 $("#disType_name b").text("Book Code"); 
			
		 }
		 
		$.ajax
		({ 
			type:"POST",
			url:"ajax_discountTypeDetails.php",
			data:{
					'id':id,
					'name':name,
					'tab':tab
			},
			success:function(html)
			{
			//alert(html);
				$("#discount_items").html(html);
			},
			error: function (e)
			{

			}
		})
	});
</script>
<script>
	$(document).delegate( "#discountType", "change", function() { 
		 var disType=$("#discountType").val();
		 if(disType=='Sub Category')
		 {
			$("#dis_item_cat").removeAttr("style");
			tab='category';
			id='cat_id';
			name='cat_title';
			 $.ajax
			({
				type:"POST",
				url:"ajax_discountTypeDetails.php",
				data:{
						'id':id,
						'name':name,
						'tab':tab
				},
				success:function(html)
				{
				//alert(html);
					$("#discount_cat").html(html);
				},
				error: function (e)
				{

				}
			})
		}
		else{
			$("#dis_item_cat").css("display","none");
		}
	});
</script>
<script>
	$(document).delegate( "#discount_cat", "change", function() {
		 var CatType=$("#discount_cat").val();
		 //alert(CatType);
			
			 $.ajax
			({
				type:"POST",
				url:"ajax_Bysubcat.php",
				data:{
						'id':CatType
				},
				success:function(html)
				{
				//alert(CatType);
					$("#discount_items").html(html);
				},
				error: function (e)
				{

				}
			})
		
	});
</script>

<body>
<style>
td
{
	padding:5px;
}
</style>
    <form  method="post" name="form2" action="" id="form2" onSubmit="//return valid(this)" enctype="multipart/form-data">
     
	
      <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
        <tr>
          <td width="30%" ><div align="right" ><b>Discount Type:</b></div></td>
          <td width="70%" ><select required name="discountType" id="discountType" style="width:190px;"> 
		   <? echo fn_ddl("DiscountType", '')?>
		  </select>         
		</td>
        </tr>
		<tr id='dis_item_cat' style="display:none;" >
          <td width="30%" ><div align="right" id="disType_cat"><b>Category:</b></div></td>
          <td width="70%" >
		  <select name="discount_cat"  id="discount_cat" style="width:390px;"> 
		  </select>         
		  </td>
        </tr>
		<tr id='dis_item_name' style="display:none;" >
          <td width="30%" ><div align="right" id="disType_name"><b>:</b></div></td>
          <td width="70%" >
		  <select name="discount_items[]" multiple="multiple" id="discount_items" style="width:390px; height:100px; " > 
		  </select>     
		  <input type="text" name="discount_coup" id="discount_coup"  style="display:none; width:250px; "/>
		  <div id="instructions"></div>
	   </td>
        </tr>
	   <tr id="discount_coup_count" style="display:none">
          <td ><div align="right" ><b>Max Count:</b></div></td>
          <td ><input  name="discount_coup_max" type="text" id="discount_coup_max" style="width:190px;" value="<? echo $discount_coup_max?>"  /></td>
        </tr>
        <tr>
          <td ><div align="right" ><b>Start Date:</b></div></td>
          <td ><input required name="startdate" type="date" id="datepicker" style="width:190px;" value="<? echo $startdate?>" size="30" maxlength="30" /></td>
        </tr>
		 
        <tr>
          <td ><div align="right" ><b>End Date:</b></div></td>
          <td ><input required name="enddate" type="date" id="datepicker1" style="width:190px;" value="<? echo $enddate?>" size="30" maxlength="30" /></td>
        </tr>
		
		<tr>
          <td ><div align="right" ><b>Discount Calculation:</b></div></td>
          <td ><select required name="discountcalculation" id="discountcalculation" style="width:190px;"> 
		   <? echo fn_ddl("DiscountCalc", '')?>
		  
		  </select>      </td>
        </tr>
		<tr>
          <td ><div align="right" ><b>Discount Value:</b></div></td>
          <td ><input required name="DiscountValue" type="text" id="DiscountValue" style="width:190px;" value="<? echo $link?>" size="70" /></td>
        </tr>
		
        <tr>
          <td width="30%" ><div align="right" ><b>Is Active:</b></div></td>
          <td width="70%" ><div>
		  <input name="active" type="radio" value="1" <? echo $active ?> />
            Active
              <input name="active" type="radio" value="0"  <? echo $inactive ?>  />
			Not Active
			</div>		</td>
        </tr>
		
	   
        <tr >
          <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
              <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" id="submitbutton" value="Save" />
            </div></td>
        </tr>
      </table>
</form>






</body>



</html>

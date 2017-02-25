<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");

$StoreId =   $_SESSION["StoreId"];
?>


<div class="my-account">
  <div class="dashboard">
    <div class="page-title">
      <h1>Manage Books</h1>
    </div>
  </div>
</div>
<?

if (get("del") == "yes")
{
	if (get("id") != "")
	{
		$id = get("id");
		$sql="delete from products where prod_id= $id";
		$query1=mysql_query($sql);						
		$msg =  " 1 Item Deleted...";
		echo "<script>alert('$msg ');parent.location.href='manageproducts.php' </script>";
	}
}

$prod_subcat = get('prod_subcat');
$prod_sub_subcat = get('prod_sub_subcat');
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");

$pageaction = get("pageaction");
//$prod_id= get("prod_id");
$prod_cat= get("prod_cat");
$prod_group_id= get("prod_group_id");
$prod_subcat= get("prod_subcat");
$prod_pic= get("prod_pic");
$prod_name= get("prod_name");
$prod_name_e= get("prod_name_e");
$prod_code= get("prod_code");
$prod_desc= get("prod_desc");
$prod_desc1= get("prod_desc1");
$edition= get("edition");
$prod_type= get("prod_type");
$prod_format= get("prod_format");
$pages= get("pages");
$prod_year= get("prod_year");
$prod_publisher= get("prod_publisher");
$writer= get("writer");
$writer_e= get("writer_e");
$writer_h= get("writer_h");
$writer_pic= get("writer_pic");
$prod_currency= get("prod_currency");

$prod_sprate= get("prod_sprate");
$prod_rate= $prod_sprate; //get("prod_rate");
$prod_isbn= get("prod_isbn");
$prod_new= get("prod_new");
$prod_hot= get("prod_hot");
$prod_special= get("prod_special");
$prod_forthc= get("prod_forthc");
$extra= get("extra");
$cat_seq= get("cat_seq");
$edited= get("edited");
$prod_imgsize= get("prod_imgsize");
$prod_active= get("prod_active");
$subscription = get("subscription");
$stock= get("stock");

if (get("Submit3")!= "")
{
	if ($writer > 0)
	{
		$sql  = "select * from writer_det where wid = $writer";
		$result = mysql_query($sql);
		$row1=mysql_fetch_array($result);
		$writer_e = $row1["writer_name"];
		$writer_h = $row1["writer_name_h"];		
	}

	$columns = 
				"
				prod_store = $StoreId,				
				prod_cat= '$prod_cat',				
				prod_subcat= '$prod_subcat',				
				prod_name= '$prod_name',
				prod_name_e= '$prod_name_e',
				prod_code= '$prod_code',
				prod_desc= '$prod_desc',
				prod_desc1= '$prod_desc1',
				edition= '$edition',
				prod_type= '$prod_type',
				prod_format= '$prod_format',
				pages= '$pages',
				prod_year= '$prod_year',
				prod_publisher= '$prod_publisher',
				writer= '$writer',
				writer_e= '$writer_e',
				writer_pic= '$writer_pic',
				prod_currency= '$prod_currency',
				prod_rate= '$prod_rate',
				prod_sprate= '$prod_sprate',
				prod_isbn= '$prod_isbn',
				subscription = '$subscription',
				prod_new= '$prod_new',
				prod_hot= '$prod_hot',
				prod_special= '$prod_special',
				prod_forthc= '$prod_forthc',
				extra= '$extra',
				prod_seq= '$cat_seq',
				edited= '$edited',
				prod_imgsize= '$prod_imgsize',
				prod_active= '$prod_active',
				modify_date = now(),
				stock= '$stock'
				";
	if ($row_id==0)
	{			
		$sql = "insert into products Set $columns, created_date = now(); ";	
		mysql_query($sql);
		$result = mysql_query("select @@identity prod_id;");
		$row1 = mysql_fetch_array($result);
		$prod_id = $row1["prod_id"];
	}
	else
	{
		$sql = "update products Set $columns where prod_id=$row_id ";
		mysql_query($sql);
		$prod_id = $row_id;
	}
	//echo $sql;
	
	// Upload Images
	$image=$_FILES['file']['name'];
	if ($image != "")
	{		
		$path="../upload/prod_pic/large/".$prod_id.".jpg";
		move_uploaded_file($_FILES['file']['tmp_name'],$path);		
		generate_image_thumbnail("../upload/prod_pic/large/".$prod_id.".jpg","../upload/prod_pic/small/".$prod_id.".jpg");
		generate_image_thumbnail("../upload/prod_pic/large/".$prod_id.".jpg","../upload/prod_pic/large/".$prod_id.".jpg", "large");
		
		$sql = "update products Set prod_pic = '$prod_id.jpg' where prod_id=$prod_id ";
		mysql_query($sql);
	}
	
	$pdf=$_FILES['file1']['name'];
	if ($pdf != "")
	{		
		$path="../upload/pdf/".$prod_id.".pdf";
		move_uploaded_file($_FILES['file1']['tmp_name'],$path);		
		
		$sql = "update products Set prod_pdf = '$prod_id.pdf' where prod_id=$prod_id ";
		mysql_query($sql);
	}
	
	echo $msg = "<center><h2>Information updated.</h2><br></center>";
	echo "<script>alert('Information saved.');parent.location.href='manageproducts.php' </script>";
	
}

$sql = "select * from products where prod_id=". $row_id;
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows>0)
{	
	$row=mysql_fetch_array($result);	
	$prod_id =  $row["prod_id"];
	if ($pageaction=="")
	{
		$prod_cat=  $row["prod_cat"];
		$prod_subcat=  $row["prod_subcat"];
	}
	$prod_pic=  $row["prod_pic"];
	$prod_sub_subcat=  $row["prod_sub_subcat"];
	$prod_name=  $row["prod_name"];
	$prod_name_e=  $row["prod_name_e"];
	$prod_code=  $row["prod_code"];
	$prod_desc=  $row["prod_desc"];
	$prod_desc1=  $row["prod_desc1"];
	$edition=  $row["edition"];
	$prod_type=  $row["prod_type"];
	$prod_format=  $row["prod_format"];
	$pages=  $row["pages"];
	$prod_year=  $row["prod_year"];
	$prod_publisher=  $row["prod_publisher"];
	$writer=  $row["writer"];
	$writer_e=  $row["writer_e"];
	$writer_h=  $row["writer_h"];
	$writer_pic=  $row["writer_pic"];
	$prod_currency=  $row["prod_currency"];
	$prod_rate=  $row["prod_rate"];
	$prod_sprate=  $row["prod_sprate"];
	$prod_isbn=  $row["prod_isbn"];
	$extra=  $row["extra"];
	$cat_seq=  $row["cat_seq"];
	$edited=  $row["edited"];
	$prod_imgsize=  $row["prod_imgsize"];
	$cr_date =  $row["created_date"];
	$last_date =  $row["modify_date"];

	$subscription = $row["subscription"];
	$prod_new=  $row["prod_new"];
	$prod_hot=  $row["prod_hot"];
	$prod_special=  $row["prod_special"];
	$prod_group_id=  $row["prod_group_id"];
	$prod_forthc=  $row["prod_forthc"];
	$prod_active=  $row["prod_active"];
	$stock=  $row["stock"];
	if ($stock=="In Stock") $stock0="checked";
	if ($stock=="Out of Stock") $stock1="checked";
	if ($stock=="Pre-Order") $stock2="checked";

	if ($subscription == 1)	
		$subscription1 = "checked";
	else
		$subscription0 = "checked";

	if ($prod_new == 1)	
		$prod_new1 = "checked";
	else
		$prod_new2 = "checked";
		
		
	if ($prod_hot == 1)	
		$prod_hot1 = "checked";
	else
		$prod_hot2 = "checked";
		
	if ($prod_special == 1)	
		$prod_special1 = "checked";
	else
		$prod_special2 = "checked";
		
	if ($prod_forthc == 1)	
		$prod_forthc1 = "checked";
	else
		$prod_forthc2 = "checked";
		
	if ($prod_active == 1)	
		$prod_active1 = "checked";
	else
		$prod_active2 = "checked";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/styles.css" rel="stylesheet" type="text/css" /> 
<script src="ckeditor/ckeditor.js"></script>


</head>
<body>
<style>
td
{
	padding:5px; font-size:11px
}
</style>
    <form action=""  method="post" enctype="multipart/form-data" name="form2" id="form2" onSubmit="return valid(this)">
		<input type="hidden" name="pageaction" value="" />
      <script = javascript>
	function valid(a)
	{ 
		if (a.cat_name.value=="")
			{
			alert ("Enter category name...")
			a.cat_name.focus();
			return false;
			}
		return true;
		}
		
	function fn_formAction(val)
	{
		document.forms[0].pageaction.value=val;
		document.forms[0].submit()
	}
	</script>
      <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
       
        <tr >
        
         
        
        
          <td width="61%" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
         
         
		 
            <tr>
              <td ><div align="right" ><b> Category Name:</b></div></td>
              <td >
			  <?
			  $sql = "select * from category where cat_active=1 and cat_store = $StoreId order by cat_title";
			  ?>
			  <select name="prod_cat" id="prod_cat" onChange="fn_formAction('subcat')"  style="width:300px">
                  <?					
					$result = mysql_query($sql);
					echo "<option value=''>---Select---</option>";
					while($row=mysql_fetch_array($result))
					{
						
						echo "<option value='".$row["cat_id"]."' ". (($row["cat_id"]==$prod_cat)?"selected":"") .">".$row["cat_title"]."</option>";
					}	
				  ?>
                </select>				</td>
            </tr>
            <tr>
              <td valign="top"><div align="right"><b>Sub Category :</b></div></td>
              <td><select name="prod_subcat" onchange='this.form.submit()'  id="prod_subcat"  >
                   <?
					$sqls = "select * from subcategory where cat_id = $prod_cat order by subcat_title";
					$results = mysql_query($sqls);
					echo "<option value='0'>---Select---</option>";
					while($rows=mysql_fetch_array($results))
					{
						echo "<option value='".$rows["subcat_id"]."' ". (($rows["subcat_id"]==$prod_subcat)?"selected":"") .">".$rows["subcat_title"]."</option>";
					}	
				  ?>
              </select></td>
            </tr>
	
            <tr>
              <td valign="top"><div align="right"><b>Code:</b></div></td>
              <td><input type="text" name="prod_code" value="<? echo $prod_code?>" size="20" maxlength="50" /></td>
            </tr>
            <tr>
              <td valign="top"><div align="right"><b> Name:</b></div></td>
              <td><input type="text" name="prod_name_e" value="<? echo $prod_name_e?>" size="40" maxlength="200" />
              <br />
              <input name="prod_name" type="text" id="prod_name" value="<? echo $prod_name?>" size="40" maxlength="200" />
              (for hindi books)</td>
            </tr>
			<!--<tr>
              <td valign="top"><div align="right"><b> Name (Hindi):</b></div></td>
              <td><input type="text" name="prod_name" value="<? echo $prod_name?>" size="50" />              </td>
            </tr>-->
            <tr>
              <td><div align="right"><b>ISBN:</b></div></td>
              <td><input type="text" name="prod_isbn" value="<? echo $prod_isbn?>" maxlength="50" /> 
              Linked  Book Code 
              <input name="extra" type="text" id="extra" value="<? echo $extra?>" size="20" maxlength="50" /></td>
            </tr>
            <tr>
              <td><div align="right"><b>Publisher:</b></div></td>
              <td><input name="prod_publisher" type="text" id="prod_publisher" value="<? echo $prod_publisher?>" size="40" maxlength="200" /></td>
            </tr>
            <tr>
              <td><div align="right"><b>Edition:</b></div></td>
              <td><input name="edition" type="text" id="edition" value="<? echo $edition?>" size="30" maxlength="200" /></td>
            </tr>
            <!--<tr>
              <td><div align="right"><b>Pages:</b></div></td>
              <td><input name="pages" type="text" id="pages" value="<? echo $pages?>" size="4" maxlength="4" /></td>
            </tr>
			-->
            <tr>
              <td><div align="right"><b>Publishing Year :</b></div></td>
              <td><input name="prod_year" type="text" id="prod_year" value="<? echo $prod_year?>" size="10" maxlength="10" /></td>
            </tr>
            <tr>
              <td><div align="right"><b>Book Language :</b></div></td>
              <td>
			   <select name="prod_type" id="prod_type" required>
				<? echo fn_ddl("Language", $prod_type); ?>
			  </select>
			 <!-- <input name="prod_type" type="text" id="prod_type" value="<? echo $prod_type?>" size="20" /> 
              (Hindi/English)--> </td>
            </tr>
            <tr>
              <td><div align="right"><b> Format:</b></div></td>
              <td><select name="prod_format" id="prod_format"  >
                  <?					
					echo "<option value=''>---Select---</option>";
					echo "<option value='Hard Bound' ". (($prod_format=='Hard Bound')?"selected":"") .">Hard Bound</option>";
					echo "<option value='Paper Back' ". (($prod_format=='Paper Back')?"selected":"") .">Paper Back</option>";
				  ?>
                  </select>              </td>
            </tr>
            <tr>
              <td width="23%"><div align="right"><b> Writer:</b></div></td>
              <td width="77%">
			  <select name="writer" id="writer"  onchange="updateWriter(this)"  style="width:300px; display:none">
                   <?
					$sql = "select * from writer_det order by writer_name";
					$result = mysql_query($sql);
					echo "<option value=''>---Select---</option>";
					while($row=mysql_fetch_array($result))
					{
						echo "<option value='".$row["wid"]."' ". (($row["wid"]==$writer)?"selected":"") .">".$row["writer_name"]."</option>";
					}	
				  ?>
              </select> 
			  <script>
			  function updateWriter(obj)
			  {
			  	document.getElementById("writer_e").value= obj.options[obj.selectedIndex].text;
			  }
			  </script>
			  
			  <input name="writer_e" type="input" id="writer_e" value="<? echo $writer_e?>"  />
			  <br />
			  <!--<a href="updatewriter.php?id=0">Add Writer</a> 		-->	  </td>
            </tr>
            <tr>
              <td><div align="right"><b>Sequence:</b></div></td>
              <td><input name="cat_seq" type="text" id="cat_seq" value="<? echo $cat_seq?>" size="4" maxlength="4" /></td>
            </tr>
            <!--<tr>
              <td valign="top" ><div align="right"><b> Details2:</b></div></td>
              <td ><textarea name="prod_desc1" cols="50"><? echo $prod_desc1?></textarea></td>
            </tr>-->
            <tr>
              <td height="5"><div align="right"><b>MRP:</b></div></td>
              <td height="5"><input type="text" name="prod_sprate" value="<? echo $prod_sprate?>" />              </td>
            </tr>
          <!--  <tr>
              <td height="5"><div align="right"><b>Sale Price:</b></div></td>
              <td height="5"><input type="text" name="prod_rate" value="<? echo $prod_rate?>" />              </td>
            </tr>-->
			
            <tr valign="top">
              <td height="5"><div align="right"><strong>Best Seller:</strong></div></td>
              <td height="5" valign="top"><input type="radio" name="prod_hot" value="1" <? echo $prod_hot1?> />
                Yes
                <input type="radio" name="prod_hot" value="0" <? echo $prod_hot2?> />
                No</td>
            </tr>
			<tr valign="top">
              <td height="5"><div align="right"><strong>Forthcoming Book:</strong></div></td>
              <td height="5" valign="top"><input type="radio" name="prod_forthc" value="1" <? echo $prod_forthc1?> />
                Yes
                <input type="radio" name="prod_forthc" value="0" <? echo $prod_forthc2?> />
                No</td>
            </tr>
			
            <tr valign="top">
              <td height="5"><div align="right"><strong>New Release:</strong></div></td>
              <td height="5" valign="top"><input type="radio" name="prod_new" value="1" <? echo $prod_new1?> />
                Yes
                <input type="radio" name="prod_new" value="0" <? echo $prod_new2?> />
                No</td>
            </tr>
            <tr>
              <td><div align="right"><b>Stock:</b></div></td>
              <td><input type="radio" name="stock" value="In Stock" <? echo $stock0?> />
                In Stock
                <input type="radio" name="stock" value="Out of Stock" <? echo $stock1?> />
                Out of Stock
                <input type="radio" name="stock" value="Pre-Order" <? echo $stock2?> />
                Pre-Order </td>
            </tr>
            <tr valign="top">
              <td height="5"><div align="right"><strong>Is Subscription:</strong></div></td>
              <td height="5" valign="top"><input name="subscription" type="radio" id="subscription" value="1" <? echo $subscription1?> />
                Yes
                <input name="subscription" type="radio" id="subscription" value="0" <? echo $subscription0?> />
                No</td>
            </tr>
            <tr valign="top">
              <td height="5"><div align="right"><strong>Active  :</strong></div></td>
              <td height="5" valign="top"><input type="radio" name="prod_active" value="1" <? echo $prod_active1?> />
                Yes
                <input type="radio" name="prod_active" value="0" <? echo $prod_active2?> />
                No</td>
            </tr>
           
          </table>
		    <br />
		  <strong>Cretaed Date: </strong><? echo $cr_date?> <strong>Last Updated: </strong><? echo $last_date ?>
		  </td>
		
          <td width="38%" align="left">
		  <b>Details:</b>
		  <textarea name="prod_desc" class="ckeditor" cols="50" rows="2" id="prod_desc"><? echo $prod_desc?></textarea>
		  <br />
		  <img src="../upload/prod_pic/small/<? echo trim($prod_pic); ?>" title="<? echo trim($prod_pic)?>"/> <br />
		  <table width="100%%" border="0">
            <tr>
              <td width="48%">Cover  Image </td>
              <td width="52%"><input type="file" name="file" /></td>
            </tr>
            <tr>
              <td>Pdf</td>
              <td><input name="file1" type="file" id="file1" /></td>
            </tr>
          </table>
		
        </tr>
        <tr >
          <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
              <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" value="Save" />
            </div></td>
        </tr>
        <tr >
          <td colspan="2" align="center">
		  <? if ($prod_id != 0) {?>
            <a href="updateproducts.php?id=<? echo $prod_id?>&amp;del=yes">Delete Current Item </a>
            <? }?></td>
        </tr>
      </table>
    </form>
 
<script>
	// Replace the <textarea id="editor"> with an CKEditor
	// instance, using default configurations.
	CKEDITOR.replace( 'prod_desc', {
		uiColor: '#14B8C4',
		toolbar: [
			[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
			[ 'FontSize', 'TextColor', 'BGColor' ]
		]
	});

</script>
</body>
</html>

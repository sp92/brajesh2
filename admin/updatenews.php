<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" /> ';  
include_once("../include/config.php");
include("../include/functions.php");

$type = $_REQUEST['type'];
$title =  $_REQUEST['t'];
//print_r($_POST); exit;
?>
<div class="my-account">
<div class="dashboard">
<div class="page-title">
  <h1>&nbsp;Manage <? echo $title?></h1>
</div>
<?
$row_id = 0;
if (get("id")!="")
	$row_id = get("id");
  	
if (get("Submit3")!= "")
{
	$type = get("type");
	$etitle = get("etitle");
	$startdate = get("startdate");
	$enddate = get("enddate");
	$details = get("details");
	$link = get("link");
	$lang = get("lang");
	$active = get("active");
	//$book_value=array();
	//$book_value=$_POST['ddlProduct1'];
	//$book_value1= implode(',',$book_value); 
	$book_value1= get("suggested_items");
	$image=$_FILES['file']['name'];
	if (get("type")=='EmpNews' && $image!="")
		$link = $SiteUrl."/upload/events/".$image;
		
	if ($row_id==0)
	{			
		$sql = "select max(event_id) from events";
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);			
		$event_id = $row[0]+1;			
		$sql = "insert into events Set type='$type',title='$etitle',store_id='1', fromdate='$startdate',enddate='$enddate',details='$details',lang='$lang',link='$link',active='$active',suggested_items='$book_value1',create_date=now()";	 
	}
	else
	{
		$sql = "update events Set type='$type',title='$etitle',suggested_items='$book_value1', fromdate='$startdate',lang='$lang',enddate='$enddate',details='$details',".
				(($link !='') ? ("link='$link',"):'').
				"active='$active'
				where event_id=$row_id ";
		$event_id =  $row_id ;
	}
	//echo $sql;
	mysql_query($sql);
	
	// Upload Images
	if ($image != "")
	{		
		$path="../upload/events/".$event_id.".jpg";
		if (get("type")=='EmpNews')
			$path="../upload/events/$image";
		move_uploaded_file($_FILES['file']['tmp_name'],$path);		
	}
	
	$msg = "Information updated.<br>";
	echo "<script>alert('Information saved.');parent.location.href='managenews.php?type=$type&t=$title' </script>";
}

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
	$suggested_items = $row["suggested_items"];
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



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script src="ckeditor/ckeditor.js"></script>
</head>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#datepicker1").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>
<script>
    $(document).delegate("#book_cat", "change", function() {
        var id = $("#book_cat").val();
        //alert(id);

        $.ajax({
            type: "POST",
            url: "ajax_Bycatbookname.php",
            data: {
                'id': id
            },
            success: function(html) {
                //alert(html);
                $("#ddlProduct").html(html);
            },
            error: function(e) {

            }
        })
    });
</script>
<script>
    $(document).delegate("#book_subcat", "change", function() {
        var id = $("#book_subcat").val();
        var catid = $("#book_cat").val();
        //alert(id);

        $.ajax({
            type: "POST",
            url: "ajax_Bysubcatbookname.php",
            data: {
                'id': id,
                'catid': catid
            },
            success: function(html) {
                //alert(html);
                $("#ddlProduct").html(html);
            },
            error: function(e) {

            }
        })
    });
</script>
<script>
    $(document).delegate("#book_cat", "change", function() {
        var id = $("#book_cat").val();
        //alert(id);

        $.ajax({
            type: "POST",
            url: "ajax_Bysubcat.php",
            data: {
                'id': id
            },
            success: function(html) {
                //alert(html);
                $("#book_subcat").html(html);
            },
            error: function(e) {

            }
        })
    });
</script>
<script>
    $(document).delegate("#submitbutton", "click", function() {

        $('#ddlProduct1 option').attr('selected', true);
        //alert("gfdg");
    })
</script>
<body>
<style>
td
{
	padding:5px;
}
</style>
<form  method="post" name="form2" action="" id="form2" onSubmit="return valid(this)" enctype="multipart/form-data">
  <script = javascript>
	function valid(a)
	{ 
		if (a.etitle.value=="")
			{
			alert ("Enter title ...")
			a.etitle.focus();
			return false;
			}
			
			
	
		return true;
		}
	</script>
  <?php
	if(get("type")=='News') $start="News ";
	if(get("type")=='EmpNews') $start="News ";
	if(get("type")=='ForthExam') $start="Exam ";
	if(get("type")=='Event') $start="Start ";
	if(get("type")=='Press') $start="Release ";
	?>
  <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
      <td ><div align="right" ><b>Language:</b></div></td>
      <td ><div>
          <input name="lang" type="radio" value="E" <? echo $english ?> />
        English
        <input name="lang" type="radio" value="H"  <? echo $hindi ?> />
        Hindi </div></td>
    </tr>
    <tr>
      <td width="16%" ><div align="right" ><b>Title:</b></div></td>
      <td width="84%" ><input name="etitle" type="text" id="etitle" style="width:190px;" value="<? echo $etitle?>" size="30" maxlength="500" />      </td>
    </tr>
    <tr>
      <td ><div align="right" ><b>
          <?=$start; ?>
          Date:</b></div></td>
      <td ><input name="startdate" type="text" id="datepicker" style="width:190px;" value="<? echo $startdate?>" size="30" maxlength="30" /></td>
    </tr>
    <?php
	if(get("type")=='Event' || get("type")=='EmpNews' )
	{
	?>
    <tr>
      <td ><div align="right" ><b>Last Date:</b></div></td>
      <td ><input name="enddate" type="text" id="datepicker1" style="width:190px;" value="<? echo $enddate?>" size="30" maxlength="30" /></td>
    </tr>
    <? }?>
    <tr>
      <td width="16%" valign="top" ><div align="right" ><b>Details:</b></div></td>
      <td width="84%" ><textarea name="details" class="ckeditor" cols="70" rows="8" id="editor1" style="width:390px; height:200px"><? echo $details?></textarea></td>
    </tr>
    <?php
	if(get("type")=='News' || get("type")=='Press' )
	{
	?>
    <tr>
      <td ><div align="right" ><b>Link:</b></div></td>
      <td ><input name="link" type="text" id="link" style="width:190px;" value="<? echo $link?>" size="70" /></td>
    </tr>
    <?php } 
	?>
    <tr>
      <td width="16%" ><div align="right" ><b><? echo (get("type")=='EmpNews')?"Pdf":"Picture" ?>:</b></div></td>
      <td width="84%" ><input type="file" name="file" />
	  <? echo ($link!="")?$link:""; ?>
	  </td>
    </tr>
    <?php

	if (get("type")=='ForthExam' || get("type")=='EmpNews')
	{
	?>
	<tr>
      <td ><div align="right" ><b>Suggested Book Codes:</b></div></td>
      <td ><input name="suggested_items" type="text" id="suggested_items" style="width:290px;" value="<? echo $suggested_items?>" />
	  Ex: 123,1245,PDE-1234 ..... etc.
	  </td>
    </tr>
	
	<? 
	}
	
	if ($abc =="1")
	{
	?>
    <tr>
      <td ><div align="right" ><b>Book Category:</b></div></td>
      <td ><select name="book_cat" id="book_cat">
          <option value="">Select Book Category</option>
          <?php $sql_cat = mysql_query("select * from Category where cat_active=1 and cat_store=$StoreId order by cat_seq, cat_title ");
			 while($data_cat=mysql_fetch_array($sql_cat))
			 {
				?>
          		<option value="<? echo $data_cat['cat_id'];?>"><? echo $data_cat['cat_title'];?></option>
          <?php } ?>
        </select>      </td>
    </tr>
    <tr>
      <td ><div align="right" ><b>Book Sub-Category:</b></div></td>
      <td ><select name="book_subcat" id="book_subcat">
          <option value="">Select Book Sub-Category</option>
        </select>      </td>
    </tr>
    <tr>
      <td></td>
      <td><div style="width:600px; margin:0 auto;">
          <div  style="width:200px; margin-right:10px; float:left;" >
            <select name="ddlProduct[]" id="ddlProduct" style="width:100%;" class="listbox" multiple="multiple" size="10">
              <option value=""> --Select -- </option>
            </select>
            <div style="clear:both;"></div>
          </div>
          <div  style="width:103px; padding-top:50px; float:left;">
            <input type="button" onClick="javascript:AddSelectedProduct();" value="Add" class="sitebutton btn-bg" id="btnAdd" name="btnAdd">
            <input type="button" onClick="javascript:DeleteSelectedProduct();"  value="Delete" class="sitebutton btn-bg" id="btnDelete" name="btnDelete">
          </div>
          <div  style="width:200px; float:left;">
            <select name="ddlProduct1[]" id="ddlProduct1" style="width:100%" class="listbox" multiple="multiple" size="10">
              <?php
			$pieces = explode(",", $row['suggested_items']);
			
			foreach ($pieces as $value) {
			 $sql_cat = mysql_query("select * from products where prod_id='".$value."'");
			 $data_cat=mysql_fetch_array($sql_cat)
				?>
              <option value="<? echo $data_cat['prod_id'];?>" select="selected"><? echo $data_cat['prod_name_e'];?></option>
              <?php } ?>
            </select>
          </div>
          <div style="clear:both"></div>
        </div></td>
    </tr>
	 <?php
	}
	?>
    <tr>
      <td ><div align="right" ><b>Is Active:</b></div></td>
      <td ><div>
          <input name="active" type="radio" value="1" <? echo $active ?> />
          Active
          <input name="active" type="radio" value="0"  <? echo $inactive ?> />
          Not Active </div></td>
    </tr>
   
    <tr >
      <td colspan="2" align="center"><div style="text-align:center;color:red"> <? echo $msg; ?>
          <input name="Submit3" type="submit" class="skycolorfont" style="background-color:#BF040D; color:#ffffff; width:150px; height:27px; border:none; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-left:-30px;" id="submitbutton" value="Save" />
        </div></td>
    </tr>
  </table>
</form>
</body>
<script type="text/javascript">        

function AddSelectedProduct() 
{
    var strMainProduct = document.getElementById("ddlProduct");
    var strSelectedProduct = document.getElementById("ddlProduct1");
    //             if(strMainProduct.selectedIndex == -1)
    //             {
    //                alert("Please select a book to add from list");               
    //             }
    //             else
    {
        var flag = 0;
        var intlength = strSelectedProduct.length;
        if (intlength == 0) {
            strSelectedProduct.options[intlength] = new Option(strMainProduct.options[strMainProduct.selectedIndex].text, strMainProduct.options[strMainProduct.selectedIndex].value);
        } else {
            for (i = 0; i < strSelectedProduct.length; i++) {
                if (strSelectedProduct.options[i].value == strMainProduct.options[strMainProduct.selectedIndex].value) {
                    flag = 1;
                    intlength = i + 1;
                    break;
                }
            }

            if (flag == 0) {
                strSelectedProduct.options[strSelectedProduct.length] = new Option(strMainProduct.options[strMainProduct.selectedIndex].text, strMainProduct.options[strMainProduct.selectedIndex].value);
                flag = 0;
            }
        }
    }
}

function DeleteSelectedProduct() 
{
    var strSelectedProduct = document.getElementById("ddlProduct1");
    //alert(strSelectedProduct.selectedIndex);
    if (strSelectedProduct.selectedIndex == -1) {
        alert("Please select a book to delete from list");
    } else {
        for (i = 0; i < strSelectedProduct.length; i++) {
            if (strSelectedProduct.selectedIndex >= 0) {
                if (strSelectedProduct.options[i].value == strSelectedProduct.options[strSelectedProduct.selectedIndex].value) {

                    strSelectedProduct.remove(i);
                    break;
                }
            }
        }
    }
}

</script>
<script>
	// Replace the <textarea id="editor"> with an CKEditor
	// instance, using default configurations.
	CKEDITOR.replace( 'editor1', {
		uiColor: '#14B8C4',
		toolbar: [
			[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
			[ 'FontSize', 'TextColor', 'BGColor' ]
		]
	});

</script>
</html>

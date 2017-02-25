<form name="form_side" method="post" action="">
<?
if ($_REQUEST['code'] != "")
{
	$_SESSION['section'] = $_REQUEST['code'];
	$_SESSION['sectiondesc'] = $_REQUEST['desc'];
	$_SESSION['cat'] =  "";
	$_SESSION['scat'] = "";
} 
		 if (isset($_POST['SubmitCat']))
		 {
		 	$category = $_REQUEST['category_id'];
		  	$subcategory = $_REQUEST['subcategory_id'];
		    $_SESSION['cat'] =  $category;
			$_SESSION['scat'] =  $subcategory;
		  }
?>
Select	Category/Sub Category
<table width="252" height="20"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
              <tr bgcolor="#FFFFFF">
                <td width="89">Category</td>
                <td width="148" align="left">
                  <select name="category_id" id="category_id" onChange=" if (document.getElementById('subcategory_id')){document.getElementById('subcategory_id').value=0;}//form.submit()" style="font-size:11px ">
                    <option value="0">Select Category</option>
					<?
					$cat_arr = mysql_query("Select cat_id, category_desc from category_mstr where active=1 and parent_id = ". $_SESSION['section']);		
					while($row=mysql_fetch_array($cat_arr))
					{
						if ($_SESSION['cat'] == $row['cat_id']) $sel = "selected";
						echo "<option value='".$row['cat_id']."' ".$sel.">". $row['category_desc'] ."</option>";
						$sel = "";
					}
					?>
                </select>                </td>
              </tr>
			 
			 
              <tr bgcolor="#FFFFFF">
                <td>Sub Category </td>
                <td align="left">
				<select name="subcategory_id" id="subcategory_id"  style="font-size:11px ">
                  <option value="0">Select Sub Category</option>
					<?
					$scat_arr = mysql_query("Select cat_id, category_desc from category_mstr where active=1  and parent_id = ".$_SESSION['cat']);
					while($row=mysql_fetch_array($scat_arr))
					{
						if ($_SESSION['scat'] == $row['cat_id']) $sel = "selected";
						echo "<option value='".$row['cat_id']."' ".$sel.">". $row['category_desc'] ."</option>";
						$sel = "";
					}
					?>
                </select>			    </td>
              </tr>
  </table><input type="submit" name="SubmitCat" value="Go">
			               </form> 
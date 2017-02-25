<?
//$code_fld = "MetaDataForecast"; //Set this value in the called page
$code_value = get("id");
$code_id = $_REQUEST["code_id"];

if (isset($_POST['Submit']))
{
	$code_desc = $_REQUEST['mtitle']; 
	$code_desc1 = $_REQUEST['mdescription']; 
	$code_desc2 = $_REQUEST['mkeyword']; 
	$active = 1; 

	if ($code_id == 0)
	{
		if ($code_desc != "")
		{
			$insert_query=mysql_query("Insert into codemstr (code_id, code_fld, code_value, code_desc, code_desc1, code_desc2, active) VALUES (NUll, '$code_fld', '$code_value', '$code_desc', '$code_desc1', '$code_desc2', $active)") or die (mysql_error());
		}
	}
	else
		$insert_query=mysql_query("UPDATE codemstr SET code_fld='$code_fld',`code_value`='$code_value',`code_desc`='$code_desc',`code_desc1`='$code_desc1', `code_desc2`='$code_desc2',active='$active' WHERE code_id=$code_id") or die (mysql_error());				
}
else
{
	$code_id = 0;
	$mtitle = "";
	$mdescription = "";
	$mkeyword = "";
	
	$sql = "Select * from codemstr where code_fld= '$code_fld' And code_value='$code_value'";
	$det_arr = mysql_query($sql);
	while($row=mysql_fetch_array($det_arr))
	{
		$code_id =  $row['code_id'];
		$mtitle = $row['code_desc'];
		$mdescription = $row['code_desc1'];
		$mkeyword = $row['code_desc2'];
	}
	?>
	  <tr bgcolor="#CCCCCC">
		<td colspan="2"><strong>Meta Information</strong></td>
	  </tr>	
	<input type="hidden" name="code_id" value="<? echo $code_id;?>">
	
	  <tr bgcolor="#FFFFFF">
		<td width="24%" align="right" >Meta Title&nbsp;</td>
		<td width="76%"><input name="mtitle" type="text"  id="mtitle" value="<? echo $mtitle; ?>" size="60" /></td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td align="right" >Meta Description&nbsp;</td>
		<td><input name="mdescription" type="text" id="mdescription" value="<? echo $mdescription; ?>" size="60" /></td>
	  </tr>	 
	  <tr bgcolor="#FFFFFF">
		<td align="right" >Meta Kewords &nbsp;</td>
		<td><input name="mkeyword" type="text"  id="mkeyword" value="<? echo $mkeyword; ?>" size="60" /></td>
	  </tr>
<? 
}
?>

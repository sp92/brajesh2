<?

$oid = get("id");
$email = get("oemail");
if ($oid != "" && $email !="")
{
	include("include/orderinfo.php");
	return;
}

?>
<form name="form1" method="post" action="">
  <table width="68%" border="0" align="center" class="tree">
    <tr>
      <td width="36%" align="right" valign="top"><strong>Order Number: </strong> </td>
      <td width="64%" valign="top"><? echo strtoupper($oid) ?></td>
    </tr>
    <tr>
      <td align="right" valign="top"><strong>Email:</strong> </td>
      <td valign="top"><input class="input-bdr w75" type="email" name="oemail" required title="Enter Email ID used to place the order">
      <br>
      Enter Email ID used to place the order</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="Submit" type="submit" value="View Order Status" class="fl ac btn-bg w94 mt10"></td>
    </tr>
  </table>
</form>

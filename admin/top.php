<? 
include_once("../include/config.php");
if ($_SESSION['username']=="")
	echo "<script>location.href='index.php';</script>";
	//header("location:index.php");
include("../include/functions.php");

if ($_SESSION["StoreId"]=="") $_SESSION["StoreId"] = $StoreId;
if (get("storeid")!="")  
	$_SESSION["StoreId"]=get("storeid");

$StoreId =   $_SESSION["StoreId"];

?>
<link href="css/winxp.blue.css" rel="stylesheet" type="text/css" />
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#dropmenudiv{
	position:absolute;
	border:1px solid black;
	border-bottom-width: 0;
	line-height:18px;
	z-index:100;
}

#dropmenudiv a{
	width: 100%;
	height:20px;
	display: block;
	text-indent: 3px;
	border-bottom: 1px solid black;
	padding: 1px 0;
	text-decoration: none;
	font-weight: bold;
}

#dropmenudiv a:hover{ /*hover background color*/
	background-color: #50638F;
	color: white;
}
</style>
<script type="text/javascript">
	var ddx = 10;   //menu position from left
	var ddy = 20;    //menu position from top
	var menuwidth='180px' //default menu width
	var menubgcolor='#91BEF0'  //menu bgcolor
	var disappeardelay=650  //menu disappear speed onMouseout (in miliseconds)
	var hidemenu_onclick="yes" //hide menu when user clicks within menu?
	
	var menu1=new Array()
	menu1[0]='<a href="managecategory.php">Category</a>';
	menu1[1]='<a href="managesubcategory.php">Sub Category</a>';
	//menu1[2]='<a href="managesubsubcategory.php">Sub Sub Category</a>';
	menu1[3]='<a href="manageproducts.php">Books</a>';
	//menu1[4]='<a href="managewriters.php">Writers</a>';

	var menu2=new Array()
	menu2[0]='<a href="managewriters.php">Writers</a>';

	var menu4=new Array()
	menu4[0]='<a href="orders.php">Orders</a>';
	menu4[1]='<a href="orders_shipping.php">Update Order Status</a>';

    
	var menu3=new Array()
	//menu3[0]='<a href="managenews.php?type=News&t=News">News</a>';
	//menu3[1]='<a href="managenews.php?type=EmpNews&t=Employment News">Employment News</a>';
	//menu3[2]='<a href="managenews.php?type=ForthExam&t=Forthcoming Exam">Forthcoming Exam</a>';
	//menu3[3]='<a href="managenews.php?type=Event&t=Events">Events</a>';
	//menu3[4]='<a href="managenews.php?type=Press&t=Press Release">Press Release</a>';
	//menu3[5]='<a href="managegallery.php?type=P&t=Picture Gallery">Picture Gallery</a>';
	//menu3[6]='<a href="managegallery.php?type=V&t=Video Gallery">Video Gallery</a>';
	//menu3[7]='<a href="managedealers.php">Bookstors</a>';
	menu3[8]='<a href="managediscount.php">Discount</a>';
	menu3[9]='<a href="managefile.php">Static Info</a>';
	menu3[10]='<a href="managebanner.php">Banners</a>';
	menu3[11]='<a href="managesystemsetting.php?groupName=StaticPages">Meta Info</a>';
	//menu3[12]='<a href="managesystemsetting.php?groupName=ProdEmailList">Book Update eMail</a>';
	
	var menu5=new Array()
	menu5[0]='<a href="users.php">Users</a>';
	menu5[1]='<a href="manageaddress.php">Order Address</a>';
	menu5[2]='<a href="managereview.php">Reviews</a>';
	//menu5[3]='<a href="managefeedback.php">Feedback</a>';
	//menu5[4]='<a href="manage-notifications.php">Notifications</a>';
	//menu5[5]='<a href="managesearch.php">Search</a>';

	var menu6=new Array()
	menu6[0]='<a href="emag-feeback.php">eMag - Feedback</a>';
	menu6[1]='<a href="emag-sms.php">emag -  Free SMS</a>';
	
</script>
<script language="JavaScript" src="js/mscript.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/thickbox.js"></script>
<script language="JavaScript" src="js/custom.js"></script>


<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css1/jsDatePick.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>

 <form name="stores" id="stores" method="post">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td height="42" bgcolor="#B7CAF7" background="image/head_bg.gif"><span class="style1">&nbsp;</span><span class="screenTitle">Admin Module</span>
      <div style="text-align:right; width:98%"> <a href="main.php" title="Home"><img src="image/home-on.gif" align="absmiddle" /></a> | <a href="cron_prod_update.php" target="iFrame">Update Notification</a> | <a href="managesystemsetting.php">System Settings</a> | <a href="changepwd.php?placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=500&modal=false" class='thickbox'>Change Password</a> | <a href="index.php">Logout</a> </div></td>
  </tr>
  <tr>
    <td height="27" bgcolor="#fff"><table width="100%"  border="0" cellspacing="0" cellpadding="3">
        <tr bgcolor="#DBE4FB">
          <td width="32%" bgcolor="#FFFFFF">&nbsp;&nbsp;
            <?php 
			echo "<strong>User:</strong> " . $_SESSION["username"] . " <strong>Login Date:</strong> ";
			$today = date("F j, Y");
			echo  $today; 
			
			?></td>
          <td width="68%" align="right" bgcolor="#FFFFFF">
		 
		  <? if ($_SESSION['username']=="admin") {?>
		  <strong>Select Front Store:</strong> 
		  <select name="storeid" id="storeid" onchange="$('#stores').submit()">
		  <?
		  	echo fn_ddl("StoreList", $_SESSION["StoreId"]);
		  ?>
		  </select>
		  <? }?>
		  </td>
        </tr>
        <tr align="left" >
          <td colspan="2" >
		  <ul class="menu">
              <li><a href="managecategory.php" onMouseover="dropdownmenu(this, event, menu1, menuwidth, true)" onMouseout="delayhidemenu()">Manage Books &#8250;</a> </li>
              <li><a href="orders.php" onMouseover="dropdownmenu(this, event, menu4, menuwidth, true)" onMouseout="delayhidemenu()">Manage Orders &#8250;</a></li>
              <!--<li><a href="users.php" onMouseover="//dropdownmenu(this, event, menu4, menuwidth, true)" onMouseout="delayhidemenu()">Manage Users</a></li>-->
              <li><a href="managenews.php?type=E&t=Events" onMouseover="dropdownmenu(this, event, menu3, menuwidth, true)" onMouseout="delayhidemenu()">Manage Content &#8250;</a></li>
			  <li><a href="#" onMouseover="dropdownmenu(this, event, menu5, menuwidth, true)" onMouseout="delayhidemenu()">Manage User Data &#8250;</a></li>
			  <!--<li><a href="#" onMouseover="dropdownmenu(this, event, menu6, menuwidth, true)" onMouseout="delayhidemenu()">eMagazine &#8250;</a></li>-->
              </ul>
            </ul>
        </tr>
      </table></td>
  </tr>
</table>
 </form>
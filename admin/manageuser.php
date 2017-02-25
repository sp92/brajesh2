<?php
session_start();
if($_SESSION['username']=="")
  header("location:index.php");
echo '<link href="winxp.blue.css" rel="stylesheet" type="text/css" /> ';  


include_once("../include/config.php");
include("../include/functions.php");
$uid = get("uid");

include("../include/personal.php");
?>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
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

<?php
session_start();
if($_SESSION['username']=="")
	header("location:index.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Main Screen</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #999999;
}
.style2 {color: #FFFFFF}
.style3 {font-weight: bold}
.style4 {color: #FFFFFF; font-weight: bold; }
ul li {padding:0 0 0 0;position:relative}
ul li img {float:none !important}
ol {margin-left:1.5em}
ol li {list-style-type:decimal;list-style-position:inside}
.ul {list-style-type:decimal;list-style-position:inside}
.hn{font-family:surya;font-size:18px;}

-->
</style>
<meta name="google-site-verification" content="mCOTc5k6Pfq1ufJd4sh_TVDZGGUk32CIq-ksMwkrhMw" />
<script src="ckeditor/ckeditor.js"></script>
</head>
<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><? include("top.php"); ?>
    </td>
  </tr>
  <tr>
    <td style="padding-left:10px" ><table width="99%"  border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td  align="center" valign="top"><? include("left.php"); ?>
          </td>
          <td >
            <div class="my-account" >
              <div class="dashboard" >
                <div class="page-title" >
                  <div style="float: left;">
                    <h1>File Setting List</h1>
                  </div>
                  
                </div>
              </div>
              <div style="clear:both;"></div>
            </div>
            <div id="msg" style="color:#FF0000;background-color:yellow; font-weight:bold; text-align:center"><? echo $_REQUEST["ms"]. $msg; ?></div>	
            <table width="100%"  border="0" bgcolor="#D3D3D3">
              <tr>
                <td bgcolor="#FFFFFF">
                  
                  <table width="100%%" border="0">
                    <tr>
                      <td width="34%" valign="top"><table width="100%"  border="0">
                        <tr bgcolor="#FFFFFF">
                          <td colspan="8"><div align="left"> Total  Current Listing: <? echo mysql_num_rows($query);?> </div></td>
                        </tr>
                        <tr class="table_header">
                          <td width="4%" height="21"><div align="center"><strong><span>#</span></strong></div></td>
                          <td width="6%"><div align="center"><strong><span>Option</span></strong></div></td>
                          <td width="90%" ><div align="left"><strong><span >File Name</span></strong></div></td>
                        </tr>
                        <?php
						$dir="../htmls";
						$files1 = scandir($dir);
						foreach($files1 as $key => $value)
						{
						 if (!in_array($value,array(".",".."))) 
						{ 
						 $sn++;
						 $aj = "&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=400&width=600&modal=false";
						 echo "<tr  class='$bgcolor'>
							<td ><div align='center'> $sn </div></td>
							<td><a href='managefile.php?fileName=$value' ><u>Edit</u></a> </font></td>
							<td>$value</td>
							
							
							</tr> 
							<tr><td colspan=6></td></tr>";
						}
					}
					//echo mysql_fetch_array($query);
				if ($sn == "")
					echo "<tr valign='top'><td colspan=9 align=center bgcolor=yellow> No data found </td></tr>";
				
				
				?>
                      </table></td>
                      <td width="66%" valign="top">
					  <?php
			    $fileName=get('fileName');
				if($fileName!='')
				{
					$flagto='1';
					//$filenameall=$_GET['fileName'];
					// configuration
					$url = 'http://localhost/upkarPrakashan/admin1/managefile.php';
					$file = '../htmls/'.$fileName;

					// check if form has been submitted
					$getfromtxt=get('text');
					if (isset($getfromtxt))
					{						
						// save the text contents
						$myfile = fopen($file, "w") or die("Unable to open file!");
						fwrite($myfile, $getfromtxt);
						fclose($myfile);
						file_put_contents($file, $getfromtxt);
						// redirect to form again
						header(sprintf('Location: %s', $url));
					   // printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
						//exit();
						$flagto='';
					}

					// read the textfile
					$text = file_get_contents($file);
					if($flagto=='1')
					{
					?>
						<!-- HTML form -->
						
						<form action="" method="post"  onsubmit='return savelconf()'; >
						<textarea name="text"  class="ckeditor"  id="editor1" cols="70" rows="8" ><?php echo htmlspecialchars($text) ?></textarea>
						<input type="submit" value="Save"/>
						<input type="reset"  />
						</form>
				<?
					}
				} 
				?>
			
					  
					  </td>
                    </tr>
                  </table>
                </td>
              </tr >
			  <tr style="width:100%;">
			  <td>
			  </td>
			</tr>
              <tr>
                <td bgcolor="#E5E5E5">&nbsp;</td>
              </tr>
              
            </table>
            </form>
			
          </td>
		  
        </tr>
		
      </table></td>
  </tr>
  <tr>
    <td><br>
      <? include("bottam.php"); ?></td>
  </tr>
  
  
  
 
</table>
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


<script>

function delconf()
{
	if (!confirm('Are you sure to delete'))
		return false;
	else
		return true;
}
function savelconf()
{
	if (!confirm('Are you sure to Save'))
		return false;
	else
		return true;
}

function fn_get(act)
{
	document.forms[0].target = (act=='users.php'?'':'new');
	document.forms[0].action = act;
	document.forms[0].action.submit();
}
function fn_fgroup()
	{		
		//alert("dfsdf");
		$("#fgrpname").submit();
		//location.href="exams.php?lang="+lang;
	}
</script>
</body>
</html>

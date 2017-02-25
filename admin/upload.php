<?
if (!session_id()) 
    session_start(); 
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload Images</title>
</head>

<?
$max_no_img=1; // Maximum number of images value to be set here

echo "<form method=post action=upload.php enctype='multipart/form-data'>";
echo "<table border='0' width='400' cellspacing='0' cellpadding='0' align=center>";
for($i=1; $i<=$max_no_img; $i++){
	echo "<tr><td>Images $i</td><td>
	<input type=file name='images[]' class='bginput'></td></tr>";
}

echo "<tr><td colspan=2 align=center><input name=submit type=submit value='Upload'></td></tr>";
echo "</form> </table>"; 

if (isset($_REQUEST["submit"]))
{
	while(list($key,$value) = each($_FILES[images][name]))
	{
		if(!empty($value)){   // this will check if any blank field is entered
			$filename = $value;    // filename stores the value		
			$filename=str_replace(" ","_",$filename);// Add _ inplace of blank space in file name, you can remove this line		
			$add = "../uploadimg/report/".$_SESSION["RepName"];   // upload directory path is set
			//echo $_FILES[images][type][$key];     // uncomment this line if you want to display the file type
			// echo "<br>";                             // Display a line break
			copy($_FILES[images][tmp_name][$key], $add);     //  upload the file to the server
			chmod("$add",0777);                 // set permission to the file. 
		}
	}
	echo "uploaded...";
}
?>

<body>
</body>
</html>

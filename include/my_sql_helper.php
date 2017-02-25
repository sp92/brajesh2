<?
/// My Sql Helper 

function executeSql($sql)
{
	$det_arr = mysql_query($sql);
	//return mysql_fetch_array($det_arr);
}

function getValue($sql)
{
	//echo $sql;
	$det_arr = mysql_query($sql);
	$row=mysql_fetch_array($det_arr);
	return $row[0]; 
}



?>
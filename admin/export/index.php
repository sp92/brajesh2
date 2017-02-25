<?php
	session_start();
	include_once("../../include/config.php");

	// load library
	require 'php-excel.class.php';
	$datavalgrp = array();
	
	$query =$_SESSION["filter"];
	$query = trim($query," and ");
	$for = get("for");
	$d = get("debug");
	if ($for=="") return;
	if ($query=="") $query= "1=1";
	
	$sql = "select code_desc from code_mstr where code_fld = 'ExportSql' and code_value='$for'";
	$sql = getValue($sql);
	//$sql = "select  * from notification";
	$sql = "$sql where $query";
	$_SESSION["filter"] ="";
	$result = mysql_query($sql);
	
	if ($d!="") echo $sql;
	
	$header = array();
	for($i = 0; $i < mysql_num_fields($result); $i++) {
   		 $field_info = mysql_fetch_field($result, $i);
    	 $header[] = $field_info->name;
	}
	
	$datavalgrp[] = array_merge($header);
	while($row=mysql_fetch_array($result))
	{
		$dataval = array();
		for($i = 0; $i < mysql_num_fields($result); $i++) {
			$dataval[] = $row[$i];
		}
		$datavalgrp[] = array_merge($dataval);
	}


	//$data = array_merge($header, $datavalgrp);		
	if ($d=="")
	{	
		//$data = array_merge($header, $datavalgrp);
		$data = $datavalgrp;
		// generate file (constructor parameters are optional)
		$xls = new Excel_XML('UTF-8', false, $for);
		$xls->addArray($data);
		$xls->generateXML($for.'-'.date('ymd'));
	}
	else
	{
		print_r ($datavalgrp);
		echo "<hr>";	
		print_r($data);	
	}
?>
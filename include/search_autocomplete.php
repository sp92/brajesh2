<?php
	include("config.php"); 
	$q=get('word');
	$my_data=mysql_real_escape_string($q);

	//if ($q != "")
	{
		$sql="select distinct trim(keyword) keyword from search where keyword LIKE '%$my_data%' ORDER BY keyword limit 0,3000";
		$result = mysql_query($sql);
		while($row=mysql_fetch_array($result))
		{
			echo trim($row['keyword'])."\n";
		}
	}
?>
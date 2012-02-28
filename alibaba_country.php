<?php
	$db = mysql_connect("192.168.5.31:3307", "test","test");
	mysql_select_db("world_address",$db);
	
	$file = file_get_contents("http://us.my.alibaba.com/user/join/join_step1.htm");
	//echo $file;
	$pattern="/<option value=\"(\w{2,3})\" countryNum=\"([0-9,-]*)\"\s+>([^<]+)<\/option>/";
	$matches=array();
	preg_match_all($pattern, $file, $matches);
	for ($i = 0; $i < count($matches[0]); $i++) {
		
		$count_abbr = $matches[1][$i];
		$count_num = $matches[2][$i];
		$count_name = $matches[3][$i];
		$query="INSERT INTO world_address.alibaba_country ( country_num, country_name, country_abbr) VALUES( '$count_num', '$count_name', '$count_abbr')";
		if(mysql_query($query,$db))
			echo mysql_error($db);
		else 
		   echo mysql_error($db);
	}
	//print_r($matches);
	mysql_close($db);
	print "end";
?>
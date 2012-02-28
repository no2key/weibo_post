<?php	
	$db = mysql_connect("192.168.5.31:3307", "test","test");
	mysql_select_db("world_address",$db);
	
	$country_name="United States";
	$country_abbr="US";
	$file = file_get_contents("http://us.my.alibaba.com/user/join/province.htm?country=$country_abbr");
	$matches = explode("@", $file);
	for ($i = 0; $i < count($matches); $i++) {
		$temp = explode("*",$matches[$i]);
		$state_name = $temp[0];
		print $state_name."\n";
		$query=" INSERT INTO world_address.alibaba_state ( state_name, country_name, country_abbr) VALUES( '$state_name', '$country_name', '$country_abbr')";
		if(mysql_query($query,$db))
			echo mysql_error($db);
		else 
		   echo mysql_error($db);
	}
	//print_r($matches);
	mysql_close($db);
	print "end";

?>
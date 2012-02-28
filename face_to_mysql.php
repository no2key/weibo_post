<?php
	$db = mysql_connect("192.168.5.31:3307", "test","test");
	mysql_select_db("world_address",$db);
	
	$file="facebook_address2_filter.txt";
	$file_handle=fopen($file, 'r');
	while (!feof($file_handle)) {
	   $line = fgets($file_handle);
	   echo $line;
	   $subject=array();
	   $subject=explode(",", $line);
	   for ($i = 0; $i <count($subject); $i++) {
			$str_temp=$subject[$i];
			if(preg_match("/\\\u[0-9a-f]{4}/", $str_temp)){
				unset($subject[$i]);
			}
	   }
	   $new_string = trim(join(",", $subject));
	   $query="INSERT INTO world_address.facebook_address(address) VALUES('$new_string')";
	   mysql_query($query,$db);
	}
	fclose($file_handle);
	mysql_close($db);
?>
<?php
$db = mysql_connect("192.168.5.31:3307", "test","test");
mysql_select_db("20111230_keyword",$db);
$id =7454163;
while (true) {
	$sql = "SELECT id,word FROM wrod_list WHERE id>$id LIMIT 1;";
	$result = mysql_query($sql,$db);
	$myrow = mysql_fetch_row($result);
	mysql_free_result($result);
	
	if (!$myrow) {
		exit();
	}
	$id = $myrow[0];
	$word = urldecode($myrow[1]);
	echo $id." ".$word."\n";

	$pattern = '/\w+/';
	preg_match_all($pattern, $word, $matches);
	$new_word=' ';
	$pr = 0;
	foreach ($matches[0] as $key){
		//echo $key;
		++$pr;
		$new_word = trim($new_word." ".$key);
		$new_word_md5 = md5($new_word);
		$insert_sql = "INSERT INTO 20111230_keyword.word_new_list
	(
	word, 
	pr, 
	MD5
	)
	VALUES
	(
	'$new_word', 
	'$pr', 
	'$new_word_md5'
	)";

		if (!mysql_query($insert_sql,$db)) {
			echo mysql_error($db)."\n";
		}

	}

}




?>
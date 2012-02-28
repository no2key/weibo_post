<?php

$db = mysql_connect("192.168.5.31:3307", "test","test");
mysql_select_db("20111230_keyword",$db);
$sleep_sec = 60;
while(true){
	$sql='SELECT id,word,MD5 FROM word_new_list WHERE has_suggest=0 ORDER BY pr,id LIMIT 1';
	mysql_query("LOCK TABLE word_new_list WRITE");
	$result = mysql_query($sql,$db);
	$myrow = mysql_fetch_row($result);
	mysql_free_result($result);
	$id = $myrow[0];
	$word = $myrow[1];
	$word_md5 = $myrow[2];
	$url_word = urldecode($word);
	echo $id." ".$word."\n";
	
	if (!$myrow) {
		exit();
	}else{
		$update_sql = "UPDATE word_new_list SET has_suggest=1 WHERE id=$id";
		if (!mysql_query($update_sql,$db)) {
			echo mysql_error($db);
		}
		mysql_query("UNLOCK TABLE");
	}
	
	$url = "http://connectkeyword.alibaba.com/lenoIframeJson.htm?keyword=".$url_word."&searchType=product_en&varname=intelSearchData&__number=1";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_ENCODING, "");
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
	$curlData = curl_exec($curl);
	
	
	if ($curlData==false) {
		echo "curl error!";
		sleep($sleep_sec);
		$sleep_sec +=60;
		echo curl_error($curl);
		$update_sql = "UPDATE word_new_list SET has_suggest=0 WHERE id=$id";
		if (!mysql_query($update_sql,$db)) {
			echo mysql_error($db);
		}
	}else{
		$sleep_sec = 60;
	}
	curl_close($curl);

	$pattern='/keywords:\'(.*?)\'/';
	preg_match_all($pattern, $curlData, $suggest_word);
	$pattern='/\{\'\d+\'\:\'(.*?)\'\}/';
	preg_match_all($pattern, $curlData, $cat);

	foreach ($suggest_word[1] as $suggest_wd){
		//var_dump($suggest_wd);
		$suggest_md5 = md5($suggest_wd);
		$insert_mysql_suggest="INSERT INTO 20111230_keyword.suggest_wordlist
	(
	word_id, 
	word, 
	suggest_word, 
	suggest_md5,
	word_md5
	)
	VALUES
	(
	'$id', 
	'$word', 
	'$suggest_wd', 
	'$suggest_md5',
	'$word_md5'
	)";
		//echo $insert_mysql_suggest;
		if(!mysql_query($insert_mysql_suggest,$db)){
			//echo mysql_error($db);
		}
	}

	if (sizeof($cat[1])>0) {
		$suggest_cat_word = $suggest_word[1][0];
		$suggest_cat_word_md5 = md5($suggest_cat_word);
		
		foreach ($cat[1] as $cat_wd){
			//var_dump($cat_wd);
			$cat_md5 = md5($cat_wd);
			$insert_mysql_word2cat="
			INSERT INTO 20111230_keyword.word_cat_list 
				(
				word, 
				category, 
				word_md5, 
				category_md5
				)
				VALUES
				(
				'$suggest_cat_word', 
				'$cat_wd', 
				'$suggest_cat_word_md5', 
				'$cat_md5'
				)";
			if (!mysql_query($insert_mysql_word2cat,$db)) {
				//echo mysql_error($db);
			}
				
		}
	}
	sleep(1);
	//break;
}

?>
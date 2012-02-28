
<?php		
function facebook_login() {
			// script name: login_to_facebook.php
  // coder: Sony AK Knowledge Center - www.sony-ak.com
 
  // your facebook credentials
  $username = "flychen50@qq.com";
  $password = "20053267";
 
  // access to facebook home page (to get the cookies)
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "http://www.facebook.com");
  curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_ENCODING, "");
  curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_facebook.cookie');
  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
  $curlData = curl_exec($curl);
  curl_close($curl);
 
  // do get some parameters for login to facebook
  $charsetTest = substr($curlData, strpos($curlData, "name=\"charset_test\""));
  $charsetTest = substr($charsetTest, strpos($charsetTest, "value=") + 7);
  $charsetTest = substr($charsetTest, 0, strpos($charsetTest, "\""));
 
  $locale = substr($curlData, strpos($curlData, "name=\"locale\""));
  $locale = substr($locale, strpos($locale, "value=") + 7);
  $locale = substr($locale, 0, strpos($locale, "\""));
 
  $lsd = substr($curlData, strpos($curlData, "name=\"locale\""));
  $lsd = substr($lsd, strpos($lsd, "value=") + 7);
  $lsd = substr($lsd, 0, strpos($lsd, "\""));
 
  // do login to facebook
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "https://login.facebook.com/login.php?login_attempt=1");
  curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_POSTFIELDS, "charset_test=" . $charsetTest . "&locale=" . $locale . "&non_com_login=&email=" . $username . "&pass=" . $password . "&charset_test=" . $charsetTest . "&lsd=" . $lsd);
  curl_setopt($curl, CURLOPT_ENCODING, "");
  curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd() . '/cookies_facebook.cookie');
  curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_facebook.cookie');
  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
  $curlData = curl_exec($curl);
  curl_close($curl);
  
   // do set_machine to facebook
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "https://www.facebook.com/loginnotify/setup_machine.php");
  curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_POSTFIELDS, "post_form_id=5635ec8245d583ac372de2ccc59a6c49&lsd=Lq68o&machinename=work&remembercomputer=1");
  curl_setopt($curl, CURLOPT_ENCODING, "");
  curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd() . '/cookies_facebook.cookie');
  curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_facebook.cookie');
  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
  $curlData = curl_exec($curl);
  curl_close($curl);
  print $curlData;
}
  	 facebook_login();
     // do login to facebook
 	$fp=fopen("facebook_address2.txt", 'a+');
	$file="facebook_address_seed.txt";
	$file_handle=fopen($file, 'r');
	while (!feof($file_handle)) {
	   $line = fgets($file_handle);
	   echo $line;
	   $subject=array();
	   $subject=explode(",", $line);
	   for ($i = 0; $i <count($subject); $i++) {
			$str_temp=trim($subject[$i]);
			if(preg_match("/\\\u[0-9a-f]{4}/", $str_temp)){
				unset($subject[$i]);
			}else{
				  print $str_temp."\n";
				  $str_temp=urlencode($str_temp);
				  //$url="http://www.facebook.com/ajax/typeahead/search.php?__a=1&value=$str_temp&category&filter[0]=page&viewer=1391745191&page_categories[0]=2404&context=hubs_location&services_mask=1";
				  $url="http://www.facebook.com/ajax/typeahead/search.php?__a=1&value=$str_temp&category&filter[0]=page&viewer=100002197982594&page_categories[0]=2404&context=hubs_location&services_mask=1";
				 // print $url."\n";
				  $curl = curl_init();
				  curl_setopt($curl, CURLOPT_URL, $url);
				  curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
				  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				  curl_setopt($curl, CURLOPT_ENCODING, "gzip");
				  curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd() . '/cookies_facebook.cookie');
				  curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_facebook.cookie');
				  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
				  $curlData = curl_exec($curl);
				  $addressnames = array();
				  $preg = "/\"text\"\:\"([^\"]+)(?=\")/";
				  preg_match_all($preg, $curlData, $addressnames);
				  foreach ($addressnames[1] as $address){
				  	//print "address:".$address."\n";
				  	fwrite($fp,$address."\n");
				  }
				  sleep(2);
			}
	   }
	   $new_string = trim(join(",", $subject));
	}
	fclose($file_handle);
	fclose($fp);
?>

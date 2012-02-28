
<?php

function create_post_string( $params )
{
	foreach ($params as $key => &$val)
	{
		if (is_array($val)) $val = implode(',', $val);
		$post_params[] = $key.'='.urlencode($val);
	}
	return implode('&', $post_params);
}

function weibo_login($username,$pass,$is_login) {
	//get server time and,pre_login
	if ($is_login) {

		//$username = 'chenxinfeng@ninetowns.com';
		//$pass = '********';
		$time = time();
		$url = 'http://login.sina.com.cn/sso/prelogin.php?entry=miniblog&callback=sinaSSOController.preloginCallBack&user='.$username.'&client=ssologin.js(v1.3.14)&_='.$time;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		//curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_ENCODING, "");
		curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_weibo.cookie');
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
		$curlData = curl_exec($curl);
		curl_close($curl);
		$pattern = '/"servertime":(\d{9,14}),"nonce":"(.*)"/';
		preg_match_all($pattern, $curlData, $serverdatas);

		$server_time = $serverdatas[1][0];
		$nonce = $serverdatas[2][0];

		//$a=array("a"=>"Dog","b"=>"Cat","c"=>"Horse");

		$formdata = array (
		"entry"=>'miniblog',
        "gateway" =>'1',
        "from" =>"",
        "savestate" => '7',
        "useticket" =>'1',
        "ssosimplelogin" => '1',
        "username" => $username,
        "service" => 'miniblog',
        "servertime" => $server_time,
        "nonce" => $nonce,
        "pwencode" =>'wsse',
        "password" =>$pass,
        "encoding" =>'utf-8',
        "url" => 'http://weibo.com/ajaxlogin.php?framelogin=1&callback=parent.sinaSSOController.feedBackUrlCallBack',
        "returntype" => 'META'
        );
        $poststring = create_post_string($formdata);
        //echo $poststring."\n";
        // do login to weibo
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://login.sina.com.cn/sso/login.php?client=ssologin.js(v1.3.14)");
        //curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$poststring);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd() . '/cookies_weibo.cookie');
        curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_weibo.cookie');
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
        $curlData = curl_exec($curl);
        curl_close($curl);
        //echo $curlData;
        $serverdatas = array();
        $pattern = '/location.replace\("(.*)"\);/';
        preg_match_all($pattern, $curlData, $serverdatas);
        //var_dump($serverdatas);
        $res_url = $serverdatas[1][0];


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $res_url);
        //curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_POSTFIELDS,$poststring);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd() . '/cookies_weibo.cookie');
        curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_weibo.cookie');
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
        $curlData = curl_exec($curl);
        curl_close($curl);

	}

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "http://weibo.com/b2bshangquan");
	//curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	//curl_setopt($curl, CURLOPT_POSTFIELDS,$poststring);
	curl_setopt($curl, CURLOPT_ENCODING, "");
	curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd() . '/cookies_weibo.cookie');
	curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_weibo.cookie');
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
	$curlData = curl_exec($curl);
	curl_close($curl);
	//var_dump($curlData);

	/*
	$text = 'hello world,from tootoo';
	$formdata = array("content"=>$text,"pic"=>'',"styleid"=>'1',"retcode"=>'');
	$poststring = create_post_string($formdata);
	//echo $poststring;
	$rnd = rand(0, 9999999999999999);
	$rnd2 = rand(0,1000000);
	$rnd =  '0.'.$rnd2.$rnd;
	$url = 'http://weibo.com/mblog/publish.php?rnd=0.8780930641842523';
	//echo $url;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	//curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS,$poststring);
	curl_setopt($curl, CURLOPT_ENCODING, "");
	curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd() . '/cookies_weibo.cookie');
	curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_weibo.cookie');
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
	curl_setopt($curl, CURLOPT_REFERER, "http://weibo.com/b2bshangquan");
	$curlData = curl_exec($curl);
	curl_close($curl);
	var_dump($curlData);
	*/
}
function post_essays($text) {

	$formdata = array("content"=>$text,"pic"=>'',"styleid"=>'1',"retcode"=>'');
	$poststring = create_post_string($formdata);
	echo $poststring;
	$rnd = rand(0, 9999999999999999);
	$rnd2 = rand(0,1000000);
	$rnd =  '0.'.$rnd2.$rnd;
	$url = 'http://weibo.com/mblog/publish.php?rnd=0.8780930641842923';
	echo $url;

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	//curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1:8580");
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS,$poststring);
	curl_setopt($curl, CURLOPT_ENCODING, "");
	curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd() . '/cookies_weibo.cookie');
	curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd() . '/cookies_weibo.cookie');
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
	curl_setopt($curl, CURLOPT_REFERER, "http://weibo.com/");
	$curlData = curl_exec($curl);
	curl_close($curl);
	var_dump($curlData);


}
weibo_login('chenxinfeng@ninetowns.com','*********',false);
post_essays("使用模拟登录发微博");

?>


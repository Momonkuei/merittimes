<?php

include '_i/config/environment.php';

/*
* 檢測連結是否是SSL連線
* @return bool
*/
session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota
if(!function_exists('is_SSL')){
	function is_SSL(){
		if(!isset($_SERVER['HTTPS']))
			return FALSE;
		if($_SERVER['HTTPS'] === 1){  //Apache
			return TRUE;
		}elseif($_SERVER['HTTPS'] === 'on'){ //IIS
			return TRUE;
		}elseif($_SERVER['SERVER_PORT'] == 443){ //其他
			return TRUE;
		}
			return FALSE;
	}
}

if(is_SSL()){

	//設定cookie傳輸模式 by lota
	// $maxlifetime = ini_get('session.gc_maxlifetime');
	$secure = true; // if you only want to receive the cookie over HTTPS
	$httponly = true; // prevent JavaScript access to session cookie
	$samesite = 'None';

    if(PHP_VERSION_ID < 70300) {
        session_set_cookie_params(0, '/; samesite='.$samesite, str_replace('www','',$_SERVER['HTTP_HOST']), $secure, $httponly);
    } else {
        session_set_cookie_params([
            // 'lifetime' => $maxlifetime,
            'path' => '/',
            'domain' => str_replace('www','',$_SERVER['HTTP_HOST']),
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
    }
}

session_start();

if(
	isset($_POST['client_id']) and $_POST['client_id'] != ''
	and isset($_POST['client_secret']) and $_POST['client_secret'] != ''
	and isset($_POST['url']) and $_POST['url'] != ''
){
	$_SESSION['client_id'] = $_POST['client_id'];
	$_SESSION['client_secret'] = $_POST['client_secret'];
	$_SESSION['session_id'] = session_id();
	$_SESSION['url'] = $_POST['url'];
	$run = 'Location: https://www.facebook.com/dialog/oauth?';
	$run .= 'client_id='.$_POST['client_id'].'&';
	$run .= 'client_secret='.$_POST['client_secret'].'&';
	//$run .= 'redirect_uri='.urlencode(FRONTEND_DOMAIN.'/facebook_s.php?id='.$_SESSION['session_id']).'&';
	//2021-01-04 FB已嚴格規定回傳網址不能帶參數 by lota
	$run .= 'redirect_uri='.urlencode(FRONTEND_DOMAIN.'/facebook_s.php').'&';
	$run .= 'id='.$_SESSION['session_id'].'&scope=email';
	header($run);
	die;
}

// if(isset($_GET['id']) and isset($_GET['code'])){
if(isset($_GET['code'])){ //2021-01-04 FB已嚴格規定回傳網址不能帶參數 by lota
	// 繼續下去
} else {
	header("HTTP/1.0 404 Not Found");
	die;
}

//2021-01-04 FB已嚴格規定回傳網址不能帶參數 by lota
// $session_id = $_GET['id'];
// session_id($session_id);

$url = $_SESSION['url'];
$code = $_GET['code'];
$client_id = $_SESSION['client_id'];
$client_secret = $_SESSION['client_secret'];

$code = str_replace('#_=_','',$code);

// Trigger URL
// https://www.facebook.com/dialog/oauth?client_id=228883727214773&client_secret=301cbc800fe41138add5623e2cd45c8b&redirect_uri=http://crm2.buyersline.com.tw/aaa.php&scope=email

// string(225) "access_token=CAAG0QuXBWrABAP4PKZAFsZBSJ3RndhnomzKb7gWqPHM8aZAtjdALT0rvUYmvUvAwc6VmjdFAUr8Y7VGeMyIt2LTfo4dMe5yoeEK27tTTyWF6tMSb4la5pEhleZCQoYh6LL44WHKbY0uQ8SQzMtZCBy2c7BWBYfMPxaHqaf058K73jGh5HlhJsQqqDuZAMVqDsZD&expires=5183191"
$run = 'https://graph.facebook.com/oauth/access_token?';
$run .= 'client_id='.$client_id.'&';
$run .= 'client_secret='.$client_secret.'&';
// $run .= 'redirect_uri='.urlencode(FRONTEND_DOMAIN.'/facebook_s.php?id='.$session_id).'&';
//2021-01-04 FB已嚴格規定回傳網址不能帶參數 by lota
$run .= 'redirect_uri='.urlencode(FRONTEND_DOMAIN.'/facebook_s.php').'&';
$run .= 'code='.$code;
// $tmp = file_get_contents($run);//2021-01-04 線上不能用 by lota
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $run);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tmp = curl_exec($ch); 
curl_close($ch);

$tmp2 = json_decode($tmp);

//$tmp = file_get_contents('https://graph.facebook.com/oauth/access_token?redirect_uri=http://demo.buyersline.com.tw/178/misc/aaa.php&code='.$_GET['code']);

// $tmp = str_replace('access_token=','', $tmp);
// $tmp = str_replace('expires=','', $tmp);
// $tmps = explode('&', $tmp);
// $access_token = $tmps[0];

//2021-01-04 線上不能用 by lota
// $json = file_get_contents('https://graph.facebook.com/me?fields=email,name&access_token='.$tmp2->access_token);
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/me?fields=email,name&access_token='.$tmp2->access_token);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($ch);

$post = json_decode($json,true);

$szHtml =  '<!DOCTYPE html>';
$szHtml .= '<html>';
$szHtml .=     '<head>';
$szHtml .=         '<meta charset="utf-8">';
$szHtml .=     '</head>';
$szHtml .=     '<body>';
$szHtml .=         '<form id="ECPayForm" method="POST" action="'.$url.'" target="_self">';

if($post and count($post) > 0){ 
    foreach($post as $k => $v){
$szHtml .= '            <input type="hidden" name="'.$k.'" value="'.$v.'" />';
    }
}

$szHtml .=         '</form>';
// 如果要debug的時候，請註解掉這行
$szHtml .=         '<script type="text/javascript">document.getElementById("ECPayForm").submit();</script>';
$szHtml .=     '</body>';
$szHtml .= '</html>';
echo $szHtml ;
exit;

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

require_once '_i/google-api-php-client/src/Google/autoload.php';
$client = new Google_Client();

if(
	isset($_POST['client_secret']) and $_POST['client_secret'] != ''
	and isset($_POST['url']) and $_POST['url'] != ''
){
	$_SESSION['client_secret'] = str_replace('87878787878787878787','"',$_POST['client_secret']);
	$_SESSION['session_id'] = session_id();
	$_SESSION['url'] = $_POST['url'];

	// init
	$client->setAuthConfig($_SESSION['client_secret']);
	$client->setRedirectUri(FRONTEND_DOMAIN.'/google_s.php');
	$client->addScope(Google_Service_Plus::USERINFO_EMAIL);
	$client->addScope(Google_Service_Plus::USERINFO_PROFILE);

    $auth_url = $client->createAuthUrl();
	$auth_url .= '&state='.strtr(base64_encode(json_encode(array('id'=>$_SESSION['session_id']))), '+/=', '-_,');
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
	die;
}

if(isset($_GET['state']) and isset($_GET['code'])){
	// 繼續下去
} else {
	header("HTTP/1.0 404 Not Found");
	die;
}

// http://stackoverflow.com/questions/7722062/google-oauth2-redirect-uri-with-several-parameters
$state = json_decode(base64_decode(strtr($_GET['state'], '-_,', '+/=')),true);

$session_id = $state['id'];
session_id($session_id);

$url = $_SESSION['url'];
$code = $_GET['code'];
$client_secret = $_SESSION['client_secret'];

// init
$client->setAuthConfig($client_secret);
$client->setRedirectUri(FRONTEND_DOMAIN.'/google_s.php');
$client->addScope(Google_Service_Plus::USERINFO_EMAIL);
$client->addScope(Google_Service_Plus::USERINFO_PROFILE);

// $client->authenticate($code);
$tmp = json_decode($client->getAccessToken(),true);
// $post = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$tmp['access_token']),true);
//線上不能用 file_get_contents 改用 CURL
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$tmp['access_token']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$post = json_decode(curl_exec($ch),true); 
curl_close($ch);

/*
 *  array(10) { 
 *      ["id"]=> string(21) "107807358519602249511" 
 *      ["email"]=> string(17) "gisanfu@gmail.com" 
 *      ["verified_email"]=> bool(true) 
 *      ["name"]=> string(10) "fu gisanfu" 
 *      ["given_name"]=> string(2) "fu" 
 *      ["family_name"]=> string(7) "gisanfu" 
 *      ["link"]=> string(45) "https://plus.google.com/107807358519602249511" 
 *      ["picture"]=> string(92) "https://lh5.googleusercontent.com/-3Trib9wXgbY/AAAAAAAAAAI/AAAAAAAAEGQ/faZp_sVsGRM/photo.jpg" 
 *      ["gender"]=> string(4) "male" 
 *      ["locale"]=> string(5) "zh-TW"
 *  } 
 */

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
$szHtml .=         '<script type="text/javascript">document.getElementById("ECPayForm").submit();</script>';
$szHtml .=     '</body>';
$szHtml .= '</html>';
echo $szHtml ;
exit;

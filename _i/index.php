<?php
/*
* 檢測連結是否是SSL連線
* @return bool
*/
// session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota //2021-03-29 後台改session_name會很麻煩...各種plugin都要改..先用原本的就好了 by lota
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


if(1){
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

// 保護機制，前後台都會指向到同一個地方
include_once('attack/spam.php');

date_default_timezone_set("Asia/Taipei");

// 2014-01-02 TED建議，我設一小時
ini_set("session.gc_maxlifetime","3600");

// debug
//ini_set('memory_limit', '512M');

// 2018-12-11
// 李哥試著上傳44.7M的檔案，就會出現以下的錯誤訊息
// PHP Fatal error:  Allowed memory size of 134217728 bytes exhausted (tried to allocate 44659600 bytes) in Unknown on line 0
// 這樣子改沒有作用，拜拜
// ini_set('memory_limit', '256M');

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

function ds($path)
{
	if(DIRECTORY_SEPARATOR == '/') return $path;
	return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

if (!defined('__DIR__')) {
	define('__DIR__', ds(dirname(__FILE__)));
}

// 因為不同資料夾的__DIR__是不一樣的，如果要做共用，要先做好這個變數
$DIR = __DIR__;

// 做不同環境的切換
$yiipath = '';
$yiipath_a = '';
$yiipath_b = '';
$yiipath_c = '';

if($yiipath != ''){
	$yiipath_a = '/'.$yiipath;
	$yiipath_b = $yiipath.'/';
	$yiipath_c = '/'.$yiipath.'/';
}

include_once($yiipath.'config/basic_yii_path.php'); //2016/6/19 改統一引入yii路徑


define('aaa_yii', $yii); // backend/config/main.php的themeManager會用到

$app_name = 'backend';
$app_path = $base_path.ds('/').$app_name;

$yii_init = str_replace('yii.php', '', $yii).$app_name.ds('/yii_init.php');
require_once($yii_init);

$app->run();

//https://devco.re/blog/2014/06/03/http-session-protection/ by lota 2018-05-08
if(isset(Yii::app()->session['LAST_REMOTE_ADDR']) && isset(Yii::app()->session['LAST_REMOTE_ADDR'])){
	if($_SERVER['REMOTE_ADDR'] !== Yii::app()->session['LAST_REMOTE_ADDR'] || $_SERVER['HTTP_USER_AGENT'] !== Yii::app()->session['LAST_USER_AGENT']) {
		session_destroy();
		//header('Location: index_login.php');
		//die;
	}
}else{
	//這邊如果消滅session的話 會造成需要兩次登入
	//session_destroy();
}



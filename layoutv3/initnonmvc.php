<?php

/*
 * 2017-08-03
 * 這個版本，目的是把LayoutV3當做是一個套件讓一般的非MVC架構直接include它
 *
 * 使用方式，把以下兩行，放在那個要使用的地方的最上面，就可以了
 * $layoutv3_parent_path = '';
 * include 'layoutv3/initnonmvc.php';
 */

// 這個是開發階段所使用的，如果開發完成，請註解
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

/*
 * 這支程式，對於LayoutV3來說，是要預留給需要用的程式或架構，例如：MVC架構
 */

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

// if(!defined('LAYOUTV3_PATH')){
if(!defined('LAYOUTV3_IS_RUN_FIRST')){
	@session_start();

	// 不同Application，如果這裡有指定的話(例如"admin/"或是en/")，可以使用自己的group、view等，但是layoutv3資料夾還是共用一個
	if(!isset($layoutv3_path)){
		$layoutv3_path = '';
	}

	define('LAYOUTV3_PATH', $layoutv3_path); // 為了要讓MVC架構也能使用，所以才用常數

	$bbb = str_replace('.php','',$_SERVER['SCRIPT_NAME']);
	if(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){
		$bbb = str_replace(LAYOUTV3_PATH,'',$bbb);
	}
	$bbb = str_replace('/','',$bbb);

	define('LAYOUTV3_IS_RUN_FIRST', $bbb); // 這個變數，在render階段會用到，等同於功能名稱
	define('_BASEPATH', __DIR__.'/../_i'); // /var/www/html/rwd_v3/_i

	//define('customer_public_path', '../'.$layoutv3_path.'assets/'); // 意思是jobs2裡面的assets，
	define('customer_public_path', 'assets/'); // 意思是jobs2裡面的assets，

	include 'cig/ci.php';	
	
	// 這個是s11的購物站母版在使用的
	$path = 'view/common';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);

}

$page = array();
$data = array();

// 動態載入區塊用
$third_party = array();

<?php
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

	// 每一種架構模式都會有這個屬於自己的常數 2018-01-15
	define('LAYOUTV3_STRUCT_MODE', 'cttdemo');

	// 不同Application，如果這裡有指定的話(例如"admin/"或是en/")，可以使用自己的group、view等，但是layoutv3資料夾還是共用一個
	if(!isset($layoutv3_path)){
		$layoutv3_path = '';
	}

	define('LAYOUTV3_PATH', $layoutv3_path); // 為了要讓MVC架構也能使用，所以才用常數

	$bbb = str_replace('.php','',str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']));//為了支援網站放在次目錄所處理的 by lota
	if(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){
		$bbb = str_replace(LAYOUTV3_PATH,'',$bbb);
	}
	$bbb = str_replace('/','',$bbb);

	define('LAYOUTV3_IS_RUN_FIRST', $bbb); // 這個變數，在render階段會用到，等同於功能名稱
	define('_BASEPATH', __DIR__.'/../../_i'); // /var/www/html/rwd_v3/_i

	//define('customer_public_path', '../'.$layoutv3_path.'assets/'); // 意思是jobs2裡面的assets，
	define('customer_public_path', 'assets/'); // 意思是jobs2裡面的assets，

	include 'ci.php';	
	
	// 這個不用，因為沒有這麼複雜
	// include 'core.php';

	// 這個是s11的購物站母版在使用的
	$path = 'view/common';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);

    //切換版型，個站不需要
    include('config.inc.php');
    //include 'common/template.config.php'; 
    
    /* 如 關閉 版型切版 會影響到：圖片、css、首頁區塊，打開以下設定*/
    // $templateNum='';      //影響首頁區塊 ex：06
    // $headerType=1;        //header編號 1~6
    // $imgPath= "images/";  //圖片路徑 ex：images/w06/
    // $themePath=""         //主樣式 ex：.w06
    // $stylePath=""         //自訂樣式路徑 ex：style.w11.css
    
    //include 'common/template.config.function.php'; 
    //include 'common/template.config.data.php'; 

}

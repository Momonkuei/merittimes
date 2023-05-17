<?php
/*
 * 目的：
 * 做一個東西，把設計師的靜態頁包起來
 * 然後執行DOM第二版，在靜態頁套用DOM第二版的規則
 * 最後在根目錄瀏覽靜態頁
 *
 * 在這裡，等於就是把V3當做資料流，提供資料給DOM第二版去使用，而Render的工作也是交給DOM第二版
 *
 * 2017-11-21 下班前，李哥有看過這個實驗性質的版本
 * 2017-11-22 午休後，李哥有看過這個併母版的版本
 *
 * 簡易說明：
 * LayoutV3先切換成cig_frontend的模式(也稱做獨立模式，因為脫去MVC的控制)
 * 在htaccess中，把獨立模式的註解打開
 * 把靜態頁放到html資料表裡面，就可以在根目錄連靜態頁
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

@session_start();
$static = '';
$simplehtml = ''; // 假裝init
if(isset($_GET['static']) and $_GET['static'] != ''){
	$static = $_GET['static'];
}
$_SERVER["SCRIPT_NAME"] = '/'.$static.'.php';

if(!defined('IS_STANDALONE')){
	define('IS_STANDALONE', true);
}

include 'standalone_simplehtmldom.php';
include 'layoutv3/init.php';

/*
 * 載入該相對功能的V3結構檔
 */
$parent_tmp = '';
if(file_exists('parent/'.$static.'.php')){
	$parent_tmp = file_get_contents('parent/'.$static.'.php');
} else {
	$parent_tmp = file_get_contents('parent/index.php');
}
if(preg_match('/^(.*)\$page\ \=\ /si', $parent_tmp, $matches)){
	$parent_tmp = str_replace($matches[1],'',$parent_tmp);
}
if($parent_tmp != ''){
	eval($parent_tmp);
}

/*
 * 執行，但是不輸出，因為只要留下它的資料而以
 */
ob_start();
	eval('?'.'>'.$run);
ob_get_contents();
ob_end_clean();

/*
 * 載入靜態頁
 */
$run = '';
if(file_exists('html/'.$static.'.html')){
	$run .= '<'.'?'.'php include "html/'.$static.'.html";';
} elseif(file_exists('html/'.$static.'.php')){
	$run .= '<'.'?'.'php include "html/'.$static.'.php";';
}

ob_start();
	eval('?'.'>'.$run);
$out = ob_get_contents();
ob_end_clean();

/*
 * 最後，啟用DOM第二版
 */
include 'layoutv3/dom4.php';

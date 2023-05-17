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

session_start();

$get = $_GET;

if(isset($get['lang']) and $get['lang'] != ''){
	// 不管是切換到什麼語系，都會把未登入的收藏清空
	unset($_SESSION['save']['shop_favorite']);
	if(isset($get['tw_cn']) and $get['tw_cn'] == '1'){
		if($get['lang'] == 'cn'){
			$_SESSION['web_ml_key'] = 'tw';
			header('Location: index_tw.php?_lang=cn');
			// header('Location: /tw/index.php?_lang=cn'); // SEO第二語系的範例
		} else {
			$_SESSION['web_ml_key'] = 'tw';
			header('Location: index_tw.php?_lang=tw');
			// header('Location: /tw/index.php?_lang=tw'); // SEO第二語系的範例
		}
	} else {
		$_SESSION['web_ml_key'] = $get['lang'];

		// 這個可以撰寫當下語系的協助判斷
	    unset($_COOKIE['targetEncoding']);
	    setcookie('targetEncoding', null, -1, '/');

		header('Location: index.php');
	}
}

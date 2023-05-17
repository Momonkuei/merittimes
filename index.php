<?php

/*
 * 連線根目錄的時候：
 *
 *	  正常人，會使用網站的預設語系，導向到該語系的首頁
 *	  正常人，如果SESSION己經存有語系，那就導向到該SESSION的語系的首頁
 *	  機器人，根目錄就是預設語系，就算是它當下是其它語系也是一樣
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

session_start();

// 切換成Yii架構(V3)(2/2)
// $aaa = file_get_contents('_i/web/config/main.php');
// $aaas = explode("\n",$aaa);
// $catch = true;
// $bbbs = array();
// foreach($aaas as $k => $v){
// 	if(preg_match('/RETURNXX/',$v)){
// 		$catch = false;
// 	}
// 	if($catch){
// 		$bbbs[] = $v;
// 	}
// }
// $ccc = implode("\n",$bbbs);
// eval('?'.'>'.$ccc);
// $default_language = $returnx['language'];

// 切換成CIg前台架構(3/3) - 向下相容Yii的非MVC架構
$aaa = file_get_contents('_i/config/environment.php');
$aaas = explode("\n",$aaa);
$default_language = 'tw'; // 網站一定會有預設的主語系，所以抓不到的話，預設的主語系就是繁體中文
foreach($aaas as $k => $v){
	if(preg_match('/FRONTEND_DEFAULT_LANG\'\,\ \'(.*)\'\)\;/', $v, $matches)){
		$default_language = $matches[1];
	}
}

$url = 'index_'.$default_language.'.php';

if(isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
	$url = 'index_'.$_SESSION['web_ml_key'].'.php';

	// SEO，請設定為預設語系的值，如果是多語系有其它語系的情況下
	// $url = 'index_en.php';
	// $_SESSION['web_ml_key'] = 'en';

	// 2017-06-13 李哥說要加的，底下是feature
	// 因應網站己經被收錄的情況
	// 然後還有人工把網址斜線後面刪掉的情況(目前不支援)
	if(
		$_SESSION['web_ml_key'] != $default_language
		and
		preg_match('/(Teoma|alexa|froogle|Gigabot|inktomi|looksmart|URL_Spider_SQL|Firefly|NationalDirectory|Ask\ Jeeves|TECNOSEEK|InfoSeek|WebFindBot|girafabot|crawler|www\.galaxy\.com|Googlebot|Scooter|Slurp|msnbot|appie|FAST|WebBug|Spade|ZyBorg|rabaz|Baiduspider|Feedfetcher-Google|TechnoratiSnoop|Rankivabot|Mediapartners-Google|Sogou\ web\ spider|WebAlta\ Crawler)/', $_SERVER['HTTP_USER_AGENT'])
		and 
		!isset($_GET['default'])
	){
		unset($_SESSION['web_ml_key']);
		$url = 'index.php';
	}

	if(isset($_GET['default'])){ // 2017-10-23 測試中
		// 動態網址 2017-09-20有跟李哥討論過
		// $_SESSION['contact_dynamic_ignore'] = true;

		// 動態網址(第2版)
		if(file_exists('_i/assets/_dynamic_url.php')){
			include '_i/assets/_dynamic_url.php';

			if(isset($_dynamic_url) and count($_dynamic_url) > 0){
				foreach($_dynamic_url as $k => $v){
					$_SESSION[$v.'_dynamic_ignore'] = true;
				}
			}
		}
	}
	// echo $url;
	// die;
}

header('Location: '.$url);

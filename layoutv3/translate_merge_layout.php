<?php

/*
 * 這個是根目錄的translate.php，在平面化的時候會使用的呈現方式
 * 順便提醒自己一下，所使用的程式位置，在layoutv3/libs.php裡面哦！
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

// layoutv3架構(為了讀語系的session而以)
// include 'layoutv3/init.php';

// demoshopX, s11架構(為了讀語系的session而以)
// include 'config.inc.php';

// require_once '_i/php-google-translate-free/vendor/autoload.php';
// use \Statickidz\GoogleTranslate;

// Debug
// $_POST = array();
// $_POST['source'] = 'tw';
// $_POST['target'] = 'en';
// $_POST['text'] = '商品說明';

if(
	!empty($_POST)
	and isset($_POST['source']) and isset($_POST['target']) and isset($_POST['text'])
	and $_POST['source'] != '' and $_POST['target'] != '' and $_POST['text'] != ''
){

	$text = $_POST['text'];
	$source = $_POST['source'];
	$target = $_POST['target'];

	// $source = 'zh-TW';
	// $target = 'en';
	// $text = '你真的知道，我在講什麼話嗎？';

	// 這個是JS模式在使用的，也就是把t的函式放到ajax處理
	if(isset($_POST['t'])){
		$map = array(
			'tw' => 'zh-TW',
			'cn' => 'zh-CN',
			'jp' => 'ja',
		);

		// 這個一定有值
		if(isset($map[$source])){
			$source = $map[$source];
		}

		$current_lang = '';
		if(isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
			$current_lang = $_SESSION['web_ml_key'];
		} else {
			$current_lang = $_SESSION["lang"];
		}

		// 我打算給它預設值為當前語系
		if($target == ''){
			if(!isset($map[$current_lang])){
				$target = $current_lang;
			} else {
				$target = $map[$current_lang];
			}
		}
		if($source == $target){
			echo $text;
			die;
		}
	} // post t

	$file = '_i/assets/translate.php';

	$translates = array();
	if(file_exists($file)){
		include $file;
	}

	$file2 = '_i/assets/labelgoogle.php';
	$labelgoogles = array();
	if(file_exists($file2)){
		include $file2;
	}

	if(isset($translates[$target][$text]) and $translates[$target][$text] != ''){
		if(isset($labelgoogles[$target][$text]) and $labelgoogles[$target][$text] != ''){
			echo $labelgoogles[$target][$text];
		} else {
			echo $translates[$target][$text];
		}
	} else {
		// if(1){ // 如果上線後，建議這裡改成零，也就是關閉自動翻譯的功能，為了安全性
		// 	$trans = new GoogleTranslate();
		// 	$result = $trans->translate($source, $target, $text);

		// 	$translates[$target][$text] = $result;

		// 	@file_put_contents($file, '<?php '."\n".'$translates = '.var_export($translates,true).';');
		// 	@chmod($file,0777);

		// 	echo $result;
		// } else {
		// 	echo $text;
		// }
	}
}

die;

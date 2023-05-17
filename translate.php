<?php

/*
 * 提醒自己一下，所使用的程式位置，在layoutv3/libs.php裡面哦！
 */

// layoutv3架構(為了讀語系的session而以)
include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
// 這裡建議不要打開，因為一定會減慢頁面載入的速度
include 'layoutv3/libs.php'; // pre_render
// include 'source/core_seo.php';

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

	if($source == 'undefined'){
		$source = $_POST['source'] = FRONTEND_DEFAULT_LANG;
	}
	// file_put_contents('123.txt', var_export($_POST,true), FILE_APPEND);
	// $source = 'zh-TW';
	// $target = 'en';
	// $text = '你真的知道，我在講什麼話嗎？';
	// 這個是JS模式在使用的，也就是把t的函式放到ajax處理
	if(isset($_POST['t'])){
		// 這個轉換，在PHP模式的時候，就會預先檢查了，所以這裡只有JS模式才有需要做
		// $map = array(
		// 	'tw' => 'zh-TW',
		// 	'cn' => 'zh-CN',
		// 	'jp' => 'ja',
		// );
		// 這個一定有值
		if(isset($map[$source])){
			$source = $map[$source];
		}
		$current_lang = '';
		if(isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
			$current_lang = $_SESSION['web_ml_key'];
		// } else {
		// 	$current_lang = $_SESSION["lang"]; // 這個變數不存在，我也不知道為什麼要這樣子寫
		}
		// 我打算給它預設值為當前語系
		if($target == ''){
			if(!isset($map[$current_lang])){
				$target = $current_lang;
			} else {
				$target = $map[$current_lang];
			}
		} else {
			if(isset($map[$target])){
				$target = $map[$target];
			}
		}

		if($source == $target){
			echo $text;
			die;
		}
	} // post t

	echo t($text,$source,$target);
	die;

	// // 資料庫內現有的翻譯項目
	// $file = '_i/assets/translate.php';
	// $translates = array();
	// if(file_exists($file)){
	// 	include $file;
	// }

	// // 後台的
	// $file2 = '_i/assets/labelgoogle.php';
	// $labelgoogles = array();
	// if(file_exists($file2)){
	// 	include $file2;
	// }

	// if(isset($translates[$target][$text]) and $translates[$target][$text] != ''){ // 都有的情況下
	// 	if(isset($labelgoogles[$target][$text]) and $labelgoogles[$target][$text] != ''){
	// 		echo $labelgoogles[$target][$text];
	// 	} else {
	// 		echo $translates[$target][$text];
	// 	}
	// } elseif(isset($labelgoogles[$target][$text])){ // 後台有的情況
	// 	if($labelgoogles[$target][$text] != ''){
	// 		echo $labelgoogles[$target][$text];
	// 	} else { // 如果是空白，代表是自動建議的新片語，還未有人去輸入
	// 		echo $text;
	// 	}
	// } else { // 這一定是新片語
	// 	$row = $this->cidb->where('is_enable',1)->where('type','labelgoogle')->where('ml_key',$_SESSION['web_ml_key'])->where('topic',$text)->get('html')->row_array();

	// 	if($row and isset($row['id'])){
	// 		// do nothing
	// 	} else {
	// 		$save = array(
	// 			'type' => 'labelgoogle',
	// 			// 'ml_key' => $this->data['ml_key'],
	// 			'ml_key' => $_SESSION['web_ml_key'],
	// 			'topic' => $text,
	// 			'is_enable' => 1,
	// 			'create_time' => date('Y-m-d H:i:s'),
	// 		);
	// 		$this->cidb->insert('html',$save);
	// 	}
	// 	echo $text;

	// 	// if(1){ // 如果上線後，建議這裡改成零，也就是關閉自動翻譯的功能，為了安全性
	// 	// 	$trans = new GoogleTranslate();
	// 	// 	$result = $trans->translate($source, $target, $text);

	// 	// 	//file_put_contents('123.txt', $text, FILE_APPEND);

	// 	// 	$translates[$target][$text] = $result;

	// 	// 	@file_put_contents($file, '<?php '."\n".'$translates = '.var_export($translates,true).';');
	// 	// 	@chmod($file,0777);

	// 	// 	echo $result;
	// 	// } else {
	// 	// 	echo $text;
	// 	// }
	// }
}

die;

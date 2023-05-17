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

if(is_SSL()){ //2020-08-31 加上去 前台layoutv3跟後台會有問題...再研究看看 2020-09-17 php7以上 把lifetime關閉即可

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
/*
 * 【Ming 2017-05-12】關於「SEO - 網址討論結論」
 */

// 為了支援200網站的使用習慣，上線後，可以把這裡mark掉
if($_SERVER['HTTP_HOST'] == '192.168.0.200'){
	$tmp = explode('/', $_SERVER["REQUEST_URI"]);
	header('Location: http://'.$tmp[1].'.web2.buyersline.com.tw');
	die;
}


// 簡易安全機制範例，有需要在打開，記得正式上線後要移除
if(0 and $_SERVER['HTTP_HOST'] != '889.devel.gisanfu.idv.tw'){
	@session_start();
	//if ($_SESSION['enter'] !== true){
	if((isset($_SESSION['enter']) and $_SESSION['enter'] == true) or preg_match('/(XXXXXXXXXX|capture)/',$_SERVER['REQUEST_URI'])){ // 2021-02-02
		// do nothing
	} else {
		header('Location: login_demo.php'); // 2021-02-02
		if(0){
		?>
		 <script language="javascript">
        location.href='login_demo.php';
        </script>           
        <?php
		}
		exit;
	}
}


//由使用者瀏覽器語系自動切換語系(第一次進入)
if(0 and isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
	@session_start();
    if(!isset($_SESSION['first_in'])){
		$supportedLangs = array('cn'=>'CN','tw'=>'zh-TW','en'=>'en','jp'=>'ja','sp'=>'sp');
		$_tmp = array();
		foreach ($supportedLangs as $key => $value) {
		$_tmp[$key] = $value;
		}    
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
		$languages = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		}else{
		$languages = array('en');
		}
		foreach($languages as $lang)
		{
		foreach ($_tmp as $key => $value) {
			if($lang == $value)
			{       
			// Set the page locale to the first supported language found 遇到第一個支援的語系
			header('Location: /index_'.$key.'.php');
			$_SESSION['first_in'] = 1; //停止無限迴圈
			die;
			}
		}      
		}
	}
}

/*
 * _CACHE3
 * 2017-12-18 下午2點40有跟李哥說，他說可以做cache機制
 *
 * 相關檔案如下：
 * parent/core.php 兩個地方
 * layoutv3/render.php
 * layoutv3/dom5.php
 */
if(isset($_GET['_cache3']) and $_GET['_cache3'] == 'clear' and file_exists('_cache3')){
	$files = glob('_cache3/*'); //get all file names
	foreach($files as $file){
		if(is_file($file))
			unlink($file); //delete file
	}
	header('Location: /');
	die;
}

//引入$web_folder
include_once dirname(dirname(__FILE__)).'/_i/config/web_folder.php';

// 2020-01-30
if(preg_match('/^(192|172|10)\./', $_SERVER['HTTP_HOST'])){
	$aaa = explode('/', $_SERVER['REQUEST_URI']);
	$ggg2 = '/'.$aaa[1];
	$_SERVER['REQUEST_URI'] = str_replace($ggg2,'',$_SERVER['REQUEST_URI']);
	$_SERVER['SCRIPT_NAME'] = str_replace($ggg2,'',$_SERVER['SCRIPT_NAME']);
	$_SERVER['REDIRECT_URL'] = str_replace($ggg2,'',$_SERVER['REDIRECT_URL']);
}

//$tmp = $_SERVER['SCRIPT_NAME'];
$tmp = str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']);//為了支援網站放在次目錄所處理的 by lota

$_SERVER['REQUEST_URI_OLD'] = $_SERVER['REQUEST_URI']; // 2019-11-25 用來給後面判斷，這個頁面是正常進來，還是靜態頁進來
if(preg_match('/\.html$/', $_SERVER['REQUEST_URI']) and isset($_SERVER['REDIRECT_URL']) and preg_match('/\.php$/', $_SERVER['REDIRECT_URL'])){
	$_SERVER['REQUEST_URI'] = $_SERVER['REDIRECT_URL'];
}

$url_prefix = '';
if(preg_match('/^\/(..)\/$/', $_SERVER['REQUEST_URI'], $matchesg) or preg_match('/^(\/..\/).*\.php/', $_SERVER['REQUEST_URI'], $matchesg)){ // seo次語系資料夾，在首頁的情況 /tw/、或是其它功能的情況
	$url_prefix = str_replace('/','',$matchesg[1]).'/'; // 例tw/
} elseif(preg_match('/(^\/..\/|).*\.html(\?page=.*|)$/', $_SERVER['REQUEST_URI'], $matchesg)){

	$_SERVER['REQUEST_URI'] = str_replace($matchesg[1],'',$_SERVER['REQUEST_URI']); // 2020-01-07
	$_SERVER['REQUEST_URI'] = str_replace($matchesg[2],'',$_SERVER['REQUEST_URI']);

	// 2020-01-08
	if($matchesg[1] != ''){
		$url_prefix = str_replace('/','',$matchesg[1]).'/'; // 例tw/
	}

	if(isset($_SERVER['REDIRECT_URL']) and preg_match('/\.php$/', $_SERVER['REDIRECT_URL'])){ // 2019-11-22 編排頁是靜態網址
		$_SERVER['REQUEST_URI'] = $_SERVER['REDIRECT_URL'];
	} elseif(isset($_SERVER['SCRIPT_NAME']) and preg_match('/parent_core/', $_SERVER['SCRIPT_NAME'])){ // 2019-11-25 通用靜態頁處理程式
		//echo $_SERVER['REQUEST_URI'];
		if($url_prefix == ''){
			$aaa = file_get_contents(dirname(dirname(__FILE__)).'/_i/config/environment.php');
			$aaas = explode("\n", $aaa);
			if($aaas and !empty($aaas)){
				foreach($aaas as $k => $v){
					// define('FRONTEND_DEFAULT_LANG', 'tw'); // 設定預設語系，當作createURL指標參考值 (*layoutv3的cig_frontend模式所使用)
					if(preg_match('/\'FRONTEND_DEFAULT_LANG\'\,\ \'(.*)\'/', $v, $matches)){
						$default_ml_key = $matches[1];
					}
				}
			}
		} else { // 2020-01-08
			$default_ml_key = str_replace('/','',$url_prefix);
		}

		//SEO靜態網址導向參考資料，這個檔案在後台SEO功能產出
		include dirname(dirname(__FILE__)).'/_i/assets/statichtml.php';

		$seo_script_name = $_SERVER['REQUEST_URI'];
		$seo_script_name = str_replace('.html','',$seo_script_name);
		$seo_script_name = str_replace('/','',$seo_script_name);
		$seo_script_name = urldecode($seo_script_name);

		if(isset($statichtml) and isset($default_ml_key)){
			$seo_type = '';
			$seo_item_id = 0;
			$current_ml_key = '';
			
			// 先找該語系底下的，然後在找其它語系順位第一的底下的
			if(isset($statichtml[$seo_script_name][$default_ml_key]) and !empty($statichtml[$seo_script_name][$default_ml_key])){
				$seo_type = $statichtml[$seo_script_name][$default_ml_key][0]['seo_type'];
				$seo_item_id = $statichtml[$seo_script_name][$default_ml_key][0]['seo_item_id'];
				$current_ml_key = $default_ml_key;

			// 2020-01-20 這裡是seo無資料夾混合模式的情況，沒用到別打開
			// } elseif(isset($statichtml[$seo_script_name]) and !empty($statichtml[$seo_script_name])){
			// 	foreach($statichtml[$seo_script_name] as $other_ml_key => $v){
			// 		break;
			// 	}
			// 	$seo_type = $statichtml[$seo_script_name][$other_ml_key][0]['seo_type'];
			// 	$seo_item_id = $statichtml[$seo_script_name][$other_ml_key][0]['seo_item_id'];
			// 	$current_ml_key = $other_ml_key;
			}

			if($seo_type != ''){
				if(preg_match('/^(.*)_(.*)$/', $seo_type, $matches)){ // 編排頁
					$new_uri = $matches[1].'_'.$current_ml_key.'_'.$matches[2].'.php';
				} else {
					if(preg_match('/^(.*)type$/', $seo_type, $matches)){
						$new_uri = $matches[1].'_'.$current_ml_key.'.php';
					} else {
						if($seo_item_id > 0){
							$new_uri = $seo_type.'detail_'.$current_ml_key.'.php';
						} else { // 2020-02-27 編號為零的時候，就一定不可能是內頁
							$new_uri = $seo_type.'_'.$current_ml_key.'.php';
						}
					}
				}

				if($seo_item_id > 0){
					$new_uri .= '?id='.$seo_item_id;
					$_GET['id'] = $seo_item_id;
				}

				// 重組request_uri
				$bbbs = explode('/', $_SERVER['REQUEST_URI']);
				$bbbs[count($bbbs)-1] = $new_uri;
				$_SERVER['REQUEST_URI'] = implode('/', $bbbs);

				// 2020-01-08
				if($url_prefix != ''){
					$_SERVER['REQUEST_URI'] = '/'.$url_prefix.str_replace('_'.$current_ml_key,'',$_SERVER['REQUEST_URI']);
				}

			}
		}
	}
}
//var_dump($_SERVER);

// 為了要支援，在htaccess裡面寫規則，取代parent/core.php的前導程式
// 理論上，平面化應該不會用到這裡
if($tmp == '/parent_core.php'){
	//$tmp = $_SERVER['REQUEST_URI'];
	$tmp = str_replace($web_folder,'',$_SERVER['REQUEST_URI']);//為了支援網站放在次目錄所處理的 by lota
}
if(preg_match('/^(.*)\?/', $tmp, $matches)){
	$tmp = $matches[1];
}

$tmps = explode('_',$tmp);

// 動態網址 2017-09-20有跟李哥討論過
// if($tmps[0] == '/contact'){
// 	header('Location: index_'.str_replace('.php','',$tmps[1]));
// }

// 2020-01-08
// seo次語系資料夾的情況下，替換與重組資料，為了讓後面的判斷正常運作
if($url_prefix != ''){
	$tmps[1] = str_replace('/', '', $url_prefix).'.php'; // 底線右邊
	$tmps[0] = str_replace('/'.$url_prefix, '', '/'.$_SERVER['REQUEST_URI']); // 底線左邊

	if(preg_match('/(.*)\./', $tmps[0], $matches)){
		$tmps[0] = $matches[1];
	}
}

// 動態網址(第2版)
if(file_exists('_i/assets/_dynamic_url.php')){
	include '_i/assets/_dynamic_url.php';

	if($_dynamic_url and !empty($_dynamic_url)){
		foreach($_dynamic_url as $k => $v){
			if($tmps[0] == '/'.$v){
				header('Location: index_'.str_replace('.php','',$tmps[1]).'.php');
			}
		}
	}
}

$file = ''; // 2020-01-02
$count = count($tmps);
if($tmps and $count == 2 and strlen(str_replace('.php','',$tmps[1])) == 2){

	/*
	 * _CACHE3
	 * 2017-12-18 下午2點40有跟李哥說，他說可以做cache機制
	 *
	 * 相關檔案如下：
	 * parent/core.php 兩個地方
	 * layoutv3/render.php
	 * layoutv3/dom5.php
	 */
	if(!preg_match('/(inquiry|contact)/', $tmps[0])){
		$get = '';
		if(!empty($_GET)){
			foreach($_GET as $k => $v){
				$get .= $k.':'.$v.',';
			}
		}
		$filename = '_cache3'.$tmps[0].'-'.str_replace('.php','',$tmps[1]).'-'.md5($get).'.html';
		// Debug
		// var_dump($get);echo $filename;
		// echo $filename;die;
		if(file_exists($filename)){
			echo file_get_contents($filename);
			die;
		}
	}

	@session_start();
	
	$_SESSION['web_ml_key'] = str_replace('.php','',$tmps[1]);
	$_SERVER['SCRIPT_NAME'] = $tmps[0].'.php';


	// 切換成Yii架構(cttdemo)
	// $run = file_get_contents('ctt'.$_SERVER['SCRIPT_NAME']);
	
	// 切換成Yii架構(V3)新
	$file = 'parent/_page.php';
	if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
		$file = 'parent'.$_SERVER['SCRIPT_NAME'];
	}

	// 2020-01-08
	if($url_prefix != ''){
		$_SESSION['web_ml_key'] = str_replace('/','',$url_prefix);
		$_SERVER['SCRIPT_NAME'] = $url_prefix.$_SERVER['SCRIPT_NAME'];
		$file = $url_prefix.'_subdir_page.php';
	}

	// 切換成Yii架構(V3)
	// if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
	// 	$run = file_get_contents('parent'.$_SERVER['SCRIPT_NAME']);
	// } else {
	// 	$run = file_get_contents('parent/_page.php');
	// }

	// 切換成V2架構(原生支援LayoutV2) beta
	// 還有 layoutv3/cig_frontend/init.php 那邊也要切換
	// $run = file_get_contents('v2'.$_SERVER['SCRIPT_NAME']);

	// 切換成Yii架構(V3) beta
	// if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
	// 	$run = file_get_contents('parent'.$_SERVER['SCRIPT_NAME']);
	// } else {
	// 	/*
	// 	 * 打算只支援單頁 2017-09-05
	// 	 */
	// 	$aaa = file_get_contents('_i/config/db.php');
	// 	$aaa = str_replace('aaa_','gggaaa0_',$aaa);
	// 	eval('?'.'>'.$aaa);
	// 	
	// 	$Db_Server = gggaaa0_dbhost;
	// 	$Db_User = gggaaa0_dbuser;
	// 	$Db_Pwd = gggaaa0_dbpass;
	// 	$Db_Name = gggaaa0_dbname; 
	// 	
	// 	$tmpg = array(
	// 		'dbdriver' => 'mysql',
	// 		'username' => $Db_User,
	// 		'password' => $Db_Pwd,
	// 		'hostname' => $Db_Server,
	// 		'port' => 3306,
	// 		'database' => $Db_Name,
	// 	);
	// 	
	// 	include_once 'layoutv3/cig/ci.php'; // 要記得，在init之上的東西，會載入兩次
	// 	$ggg = ggg_load_database($tmpg, true);

	// 	$ml_key = $_SESSION['web_ml_key'];
	// 	$router_method = str_replace('/', '', $tmps[0]);

	// 	// 不要只搜尋啟用的，因為它有可能是放在其它位置(例：top_link_menu)
	// 	// $row = $ggg->where('type', 'webmenu')->where('ml_key', $ml_key)->where('is_home',1)->where('is_top',1)->where('url1', $router_method.'_'.$ml_key.'.php')->get('html')->row_array();

	// 	$o = $ggg->where('type', 'webmenu')->where('ml_key', $ml_key);
	// 	$o = $o->where('url1', $router_method.'_'.$ml_key.'.php');
	// 	$o = $o->where('is_home',1)->where('is_top',1);
	// 	$row = $o->get('html')->row_array();

	// 	// var_dump($row);die;

	// 	if($row and isset($row['id']) and $row['id'] > 0){
	// 		define('IS_ARTICLESINGLE', true); // 給SiteController判斷用
	// 		$run = file_get_contents('parent/_articlesingle.php');
	// 	} else {
	// 		header("HTTP/1.0 404 Not Found");
	// 		die;
	// 	}
	// }

	// eval('?'.'>'.$run);
} elseif($tmps and $count == 3 and strlen(str_replace('.php','',$tmps[1])) == 2){ // 編排頁
	@session_start();

	$_SESSION['web_ml_key'] = str_replace('.php','',$tmps[1]);
	$_SERVER['SCRIPT_NAME'] = $tmps[0].'_'.$tmps[2].'.php';

	// 切換成Yii架構(cttdemo)
	// $run = file_get_contents('ctt'.$_SERVER['SCRIPT_NAME']);

	// 切換成Yii架構(V3)新
	$file = 'parent/_page.php';
	if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
		$file = 'parent'.$_SERVER['SCRIPT_NAME'];
	}
	
	// 切換成Yii架構(V3)
	// if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
	// 	$run = file_get_contents('parent'.$_SERVER['SCRIPT_NAME']);
	// } else {
	// 	$run = file_get_contents('parent/_page.php');
	// }

	// $_SERVER['SCRIPT_NAME'] = $tmps[0].'.php';

	// eval('?'.'>'.$run);
} elseif($tmps and $count == 1){ // 沒有指定語系的情況
	// 看看它的位置，是在根目錄的，還是在子資料夾

	@session_start();

	$tmps = explode('/', $_SERVER['REQUEST_URI']);
	$request_uri = $_SERVER['REQUEST_URI'];

	$path1 = 'parent';
	$count = count($tmps);
	if($count == 3){
		$request_uri = '/'.$tmps[2];
		$path1 = $tmps[1];

		if(strlen($path1) == 2){
			$_SESSION['web_ml_key'] = $path1;
		}
	}

	//假如 $_SESSION['web_ml_key'] 為空值 則直接寫入預設值 2018-11-29 by lota
	//if($_SESSION['web_ml_key']==''){
	//	$_SESSION['web_ml_key'] = 'tw';
	//}

	$tmp = str_replace('/', '', str_replace('.php','', $request_uri));
	$tmp2 = explode('?', $tmp);
	$path2 = $tmp2[0];

	// 2018-10-04
	if($path2 == ''){
		$path2 = 'index';
	}

	$file_tmp = $path1.'/'.$path2.'.php';

	// $_SERVER['SCRIPT_NAME'] = '/'.$file; // 2018-10-04 不要在用這行了
	$_SERVER['SCRIPT_NAME'] = '/'.$path2.'.php';

	$file = 'parent/_page.php';
	if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
		$file = $file_tmp;
	}

	// if(file_exists($file)){
	// 	$run = file_get_contents($file);
	// } else {
	// 	$run = file_get_contents('parent/_page.php');
	// }

	// eval('?'.'>'.$run);
} elseif($tmps and count($tmps) == 2 and $tmps[1] == 'core.php'){ // #35342
	header('Location: /');
	die;
}
if($file != ''){
	// $run = file_get_contents('parent/_page.php');

	// 2020-01-08
	$run = file_get_contents($file);

	eval('?'.'>'.$run);
}

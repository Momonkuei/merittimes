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
// 2019-05-29 因為帝寶而加的
date_default_timezone_set("Asia/Taipei");

/*
 * 這裡的東西，沒有經過parent/core.php的程式，所以$_SERVER SCRIPT_NAME要自行處理
 *
 * 如果要使用，請複製這支檔案，到該次資料夾裡面，還要搭配rewrite(.htaccess)
 *   RewriteEngine on
 *   RewriteCond %{REQUEST_FILENAME} !-f
 *   RewriteRule ^(.*)$ _subdir_page.php [L,QSA]
 *
 *   # 動態網址 (第2版)
 *   # RewriteRule ^(.*)\.html$ _subdir_page.php?dynamic=$1 [L,QSA]
 *
 *   # 非主語系的SEO
 *   # 檔案重導
 *   # RewriteRule ^(.*)$ _subdir_page.php [L,QSA]
 */

// 2018-10-02 如果下面的測試正常，那這裡的註解通通可以拿掉
// @session_start();
// 
// $tmps = explode('/', $_SERVER['REQUEST_URI']);
// 
// $request_uri = '/'.$tmps[2];
// 
// if(strlen($tmps[1]) == 2){
// 	$_SESSION['web_ml_key'] = $tmps[1];
// }
// $path1 = $tmps[1];
// 
// $tmp = str_replace('/', '', str_replace('.php','', $request_uri));
// $tmp2 = explode('?', $tmp);
// $path2 = $tmp2[0];
// $_SERVER['SCRIPT_NAME'] = '/'.$path1.'/'.$path2.'.php';
// 
// $layoutv3_parent_path = $tmps[1].'/'; // 例：tw, news, product, contact
// set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../'); // 產品內頁可能會需要

@session_start();

//判斷實體子資料夾
if(file_exists('../_i/config/web_folder.php')){
	include_once ('../_i/config/web_folder.php');
	if($web_folder!=''){
		$_SERVER['REQUEST_URI'] = str_replace($web_folder,'',$_SERVER['REQUEST_URI']);
	}
}

$tmpsg = explode('/', $_SERVER['REQUEST_URI']);

$request_uri = '/'.$tmpsg[2];

if(strlen($tmpsg[1]) == 2){
	$_SESSION['web_ml_key'] = $tmpsg[1];
}
$path1 = $tmpsg[1];

$tmp = str_replace('/', '', str_replace('.php','', $request_uri));
$tmp2 = explode('?', $tmp);

$tmps = explode('_',$tmp2[0]);
//檔案名稱有底線，不能用這個做explode，如果要做動態檔案讀取，就要把下面的註解打開 by lota
//$tmps = $tmp2[0];

if($tmps and count($tmps) == 1){
	$path2 = $tmp2[0];

	// #32266
	if($path2 == ''){
		$path2 = 'index';
	}

	$_SERVER['SCRIPT_NAME'] = '/'.$path1.'/'.$path2.'.php';
} elseif($tmps and count($tmps) == 2){ // 編排頁
	$_SERVER['SCRIPT_NAME'] = '/'.$path1.'/'.$tmps[0].'_'.$tmps[1].'.php';
} elseif($tmps and count($tmps) == 3){ // SEO編排頁
	$_SERVER['SCRIPT_NAME'] = '/'.$path1.'/'.$tmps[0].'_'.$tmps[2].'.php';
}

$layoutv3_parent_path = $tmpsg[1].'/'; // 例：tw, news, product, contact
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../'); // 產品內頁可能會需要

// 2018-12-06
// 把SEO做在資料夾功能裡面
// 例如：product/GGG.html
//
// RewriteEngine on
// RewriteCond %{REQUEST_FILENAME} !-f
// RewriteRule ^(.*)\.html\&page=(.*)$ _subdir_page.php?paramid=$1&page=$2 [L,QSA]
// RewriteRule ^(.*)\.html$ _subdir_page.php?paramid=$1 [L,QSA]
if(0){
	$_SERVER['SCRIPT_NAME'] = '/'.$path1.'/'.$path1.'.php';
	$_SERVER['REQUEST_URI'] = '/'.$path1.'/'.$path1.'.php';

	if($_GET['paramid'] == 'ALL'){
		$_GET['id'] = 1;
	} elseif($_GET['paramid'] == '客制購物網'){
		$_GET['id'] = 23;
	}
}

/*
 * 2018-11-09 李哥說要寫的，
 * 檔案下載直接開啟，rewrite查該檔案的標題
 * 目前範例預設是通用資料表
 * 動態檔案讀取
 */
if(0){
	$field = 'file1';
	$table = str_replace('/', '', $layoutv3_parent_path);

	$aaas = explode('.', urldecode($path2));
	if(count($aaas) > 1){
		unset($aaas[count($aaas)-1]);
	}
	$file2 = implode('.', $aaas);

	$aaa = file_get_contents('../_i/config/db.php');
	$aaa = str_replace('aaa_','gggaaa2_',$aaa);
	eval('?'.'>'.$aaa);

	$Db_Server = gggaaa2_dbhost;
	$Db_User = gggaaa2_dbuser;
	$Db_Pwd = gggaaa2_dbpass;
	$Db_Name = gggaaa2_dbname; 
	
	$tmps = array(
		'dbdriver' => 'mysql',
		'username' => $Db_User,
		'password' => $Db_Pwd,
		'hostname' => $Db_Server,
		'port' => 3306,
		'database' => $Db_Name,
		// 'db_debug' => true,
	);

	include_once '../layoutv3/cig/ci.php'; // 要記得，在init之上的東西，會載入兩次
	// $ggg = ggg_load_database("mysql://".gggaaa_dbuser.":".gggaaa_dbpass."@".gggaaa_dbhost."/".gggaaa_dbname, true);
	$cidb = ggg_load_database($tmps, true);

	$row = $cidb->where('type',$table)->where('is_enable',1)->where('topic !=','')->where('topic',$file2)->get('html')->row_array();
	// $row = $cidb->where('is_enable',1)->where('name !=','')->where('name',$file2)->get($table)->row_array();
	if($row and isset($row['id']) and $row['id'] > 0 and isset($row[$field]) and $row[$field] != ''){
		$bbbs = explode('.', $row[$field]);
		$ext = strtolower($bbbs[count($bbbs)-1]);
		$file = '../_i/assets/file/'.$table.'/'.$row[$field];

		header('Content-Type: application/'.$ext);
		readfile($file);
	} else {
		header("HTTP/1.0 404 Not Found");
	}
	die;
}

// 動態網址(第2版)
if(file_exists('../_i/assets/_dynamic_url.php')){
	include '../_i/assets/_dynamic_url.php';

	if(isset($_dynamic_url) and in_array($path1,$_dynamic_url) and isset($_GET['dynamic']) and !is_numeric($_GET['dynamic'])){
		$id_name = $_GET['dynamic'];
		$_SERVER['SCRIPT_NAME'] = '/'.$path1.'/'.$path1.'.php';

		// debug
		// if(0){
		// 	echo $_SESSION['save']['contact_dynamic_url'].' / ';
		// 	echo $id_name;
		// }

		// 動態網址
		// if(!isset($_SESSION['save']['contact_dynamic_url']) or $_SESSION['save']['contact_dynamic_url'] != $id_name){
		// 	// 李哥2017-10-26 早上說，不要404，轉到首頁去
		// 	//header("HTTP/1.0 404 Not Found");
		// 	// die;

		// 	header('Location: /');
		// }

		// 動態網址 (第2版)
		$tmps = explode('/', $_SERVER['REQUEST_URI']);
		if(0){
			echo $_SESSION['save'][$tmps[1].'_dynamic_url'].' / ';
			echo $id_name;
		}
		if(!isset($_SESSION['save'][$tmps[1].'_dynamic_url']) or $_SESSION['save'][$tmps[1].'_dynamic_url'] != $id_name){
			// 李哥2017-10-26 早上說，不要404，轉到首頁去
			//header("HTTP/1.0 404 Not Found");
			// die;

			header('Location: /');
		}
	}
}

include 'layoutv3/init.php';

// 挑選所需要的資料
//$page_source = array(
//	'share-core',
//	'share-page_title',
//	'share-breadcrumb',
//	'top_link_menu-v1',
//	'webmenu-v1',
//	'webmenu-bottom',
//	'home-banner',
//	'company-general',
//
//	// 結尾的程式碼，通常都放這裡
//	'share-end',
//);

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

// 不需要側選單，因為預設內頁結構是有側選單的
// $view_file = 'default/layout_sidemenu';
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$layoutv3_struct_map_keyname[$view_file][0]]['type'] = 3; // 無選單 | 沒滿版
// }

include 'layoutv3/render.php';

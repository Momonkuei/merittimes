<?php

/*
 * 這裡的東西，沒有經過parent/core.php的程式，所以$_SERVER SCRIPT_NAME要自行處理
 *
 * 如果要使用，請複製這支檔案，到該次資料夾裡面，還要搭配rewrite(.htaccess)
 *   RewriteEngine on
 *   RewriteCond %{REQUEST_FILENAME} !-f
 *   RewriteRule ^(.*)$ _subdir_page.php [L,QSA]
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
@session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota
@session_start();

//判斷實體子資料夾 2018-8-8 by lota
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

if($tmps and count($tmps) == 1){
	$path2 = $tmp2[0];
	$_SERVER['SCRIPT_NAME'] = '/'.$path1.'/'.$path2.'.php';
} elseif($tmps and count($tmps) == 2){ // 編排頁
	$_SERVER['SCRIPT_NAME'] = '/'.$path1.'/'.$tmps[0].'_'.$tmps[2].'.php';
}

$layoutv3_parent_path = $tmpsg[1].'/'; // 例：tw, news, product, contact
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../'); // 產品內頁可能會需要

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

include '../layoutv3/init.php';

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
include '../layoutv3/pre_render.php';
// include '../layoutv3/print_struct.php';

// 不需要側選單，因為預設內頁結構是有側選單的
// $view_file = 'default/layout_sidemenu';
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$layoutv3_struct_map_keyname[$view_file][0]]['type'] = 3; // 無選單 | 沒滿版
// }

include '../layoutv3/render.php';

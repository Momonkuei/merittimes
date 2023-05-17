<?php

// SEO
// @session_start();
// $_SESSION['web_ml_key'] = 'tw';
// $layoutv3_parent_path = 'tw/'; // 本程式在子資料夾內，相關檔案在根目錄 (通常是Yii和cig前台在用) ex: contact/
// $layoutv3_path = ''; // 本程式在子資料夾內，相關檔案也在該層目錄裡面 (通常是cig後台在用) ex: contact/
// include '../layoutv3/init.php';

/*
 * SEO專用
 */

// 這是正解(名子轉ID)
// if(!isset($_SESSION) and isset($_GET['id']) and !is_numeric($_GET['id'])){ // 這是舊版的(李哥發現的)
if(0 and !defined('LAYOUTV3_IS_RUN_FIRST') and isset($_GET['id']) and !is_numeric($_GET['id'])){
	@session_start();
	// $_SESSION['web_ml_key'] = 'tw'; // 非主語系的時候，而且要xx/abc.html的情況，這一行就必需要加
	$id_name = $_GET['id'];

	$aaa = file_get_contents('_i/config/db.php');
	$aaa = str_replace('aaa_','gggaaa_',$aaa);
	eval('?'.'>'.$aaa);

	$Db_Server = gggaaa_dbhost;
	$Db_User = gggaaa_dbuser;
	$Db_Pwd = gggaaa_dbpass;
	$Db_Name = gggaaa_dbname; 

	$tmps = array(
		'dbdriver' => 'mysql',
		'username' => $Db_User,
		'password' => $Db_Pwd,
		'hostname' => $Db_Server,
		'port' => 3306,
		'database' => $Db_Name,
		// 'db_debug' => true
	);

	include_once 'layoutv3/cig_frontend/ci.php'; // 要記得，在init之上的東西，會載入兩次
	// $ggg = ggg_load_database("mysql://".gggaaa_dbuser.":".gggaaa_dbpass."@".gggaaa_dbhost."/".gggaaa_dbname, true);
	$ggg = ggg_load_database($tmps, true);

	$is_type = false;

	//分類
	$query = $ggg->where('seo_type', 'producttype')->where('seo_script_name', $id_name)->where('seo_ml_key',$_SESSION['web_ml_key'])->get('seo');
	if($query){
		$producttype_row = $query->row_array();

		if($producttype_row and isset($producttype_row['seo_item_id']) and $producttype_row['seo_item_id'] > 0){
			$_GET['id'] = $producttype_row['seo_item_id'];
			//var_dump($_SERVER);die;
			//$_SERVER['REQUEST_URI'] = '/product.php'; // 主語系用 2019-07-22
			//$_SERVER['REQUEST_URI'] = '/tw/product.php'; // 資料夾用 2019-07-22
			//$_SERVER["SCRIPT_NAME"] = $id_name.'.html';
			$is_type = true;
		} else {
			// 2019-11-15 青輔遇到的問題
			//header("HTTP/1.0 404 Not Found");
			header("Location : http://".$_SERVER['SERVER_NAME']);//2019-11-19 ming 說不存在的頁面/資料全轉跳首頁
			die;
		}
	} else {
		//header("HTTP/1.0 404 Not Found");
		header("Location : http://".$_SERVER['SERVER_NAME']);//2019-11-19 ming 說不存在的頁面/資料全轉跳首頁
		die;
	}

	//產品 這邊如果要用的話 下面的結構要加判斷式 ，參考奇威爾 (lota版本)
	//if(!$is_type){
	//	$query = $ggg->where('script_name', $id_name)->get('product'.$_SESSION['web_ml_key']);
	//	$product_row = $query->row_array();

	//	if($product_row and isset($product_row['id']) and $product_row['id'] > 0){
	//		$_SERVER["SCRIPT_NAME"] = '/productdetail_'.$_SESSION['web_ml_key'].'.php';
	//		$_GET['id'] = $product_row['id'];
	//	} else {
	//		header("HTTP/1.0 404 Not Found");
	//		die;
	//	}
	//}

	// 產品
	// 當產品分類和項目的靜態頁，都是放在根目錄的情況下，才有需要打開這裡
	// 記得要使用的話，要使用判斷式，來區別產品的列表和內頁的page與source
	// 使用過這裡的網站：中立冷凍2017/12/19
	if(0 and !$is_type){
		// 奇威爾寫法
		$query = $ggg->where('seo_type', 'product')->where('seo_script_name', $id_name)->where('seo_ml_key',$_SESSION['web_ml_key'])->get('seo');
		$product_row = $query->row_array();

		if($product_row and isset($product_row['seo_item_id']) and $product_row['seo_item_id'] > 0){
			//$_SERVER['REQUEST_URI'] = '/product.php'; // 主語系用 2019-07-22
			//$_SERVER['REQUEST_URI'] = '/tw/product.php'; // 資料夾用 2019-07-22
			//$_SERVER["SCRIPT_NAME"] = '/productdetail.php'; // 這個不要在用了
			$_GET['id'] = $product_row['seo_item_id'];
		} else {
			//header("HTTP/1.0 404 Not Found");
			header("Location : http://".$_SERVER['SERVER_NAME']);//2019-11-19 ming 說不存在的頁面/資料全轉跳首頁
			die;
		}
	}

}

// lota 如果不是靜態連結進來的，那就搜尋資料後跳轉到靜態頁面
// 這是反解(ID轉名子)
// if(0 and !defined('LAYOUTV3_IS_RUN_FIRST') and !isset($_SESSION) and isset($_GET['id']) and is_numeric($_GET['id'])){ // 這是舊版的(李哥發現的)
// if(!isset($_GET['type'])){ // 這是新版的，但是怪怪的
if(0 and !isset($_GET['type']) and isset($_GET['id']) and is_numeric($_GET['id'])){
	//if(isset($_GET['id']) and is_numeric($_GET['id'])){

		//session_start();
		$id = $_GET['id'];

		$aaa = file_get_contents('_i/config/db.php');
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
			// 'db_debug' => true
		);

		include_once 'layoutv3/cig_frontend/ci.php'; // 要記得，在init之上的東西，會載入兩次
		// $ggg = ggg_load_database("mysql://".gggaaa_dbuser.":".gggaaa_dbpass."@".gggaaa_dbhost."/".gggaaa_dbname, true);
		$ggg = ggg_load_database($tmps, true);

		$is_type = false;

		// 因為第一次連入不會有SESSION by lota
		if(isset($_SESSION['web_ml_key'])){
			$web_ml_key = $_SESSION['web_ml_key'];
		} else {
			$web_ml_key = 'en';
			$_SESSION['web_ml_key'] = $web_ml_key;
		}

		// 2019-07-22
		// 加上新條件，讓反解更精準
		$tmps2 = explode('/', $_SERVER["SCRIPT_NAME"]); // /productdetail.php
		$condition2 = str_replace('.php','',$tmps2[count($tmps2)-1]); // productdetail
		if(preg_match('/detail/', $condition2)){
			$condition2 = str_replace('detail','',$condition2);
		} else {
			$condition2 .= 'type';
		}

		//分類
		$query = $ggg->where('seo_item_id', $id)->where('seo_ml_key',$web_ml_key)->where('seo_type',$condition2)->get('seo');
		if($query){
			$producttype_row = $query->row_array();
			if($producttype_row and isset($producttype_row['seo_script_name']) and $producttype_row['seo_item_id'] > 0){
				header('Location: http://'.$_SERVER['SERVER_NAME'].'/'.$producttype_row['seo_script_name'].'.html');
				die;
			}		
		} else {
			//header("HTTP/1.0 404 Not Found");
			header("Location : http://".$_SERVER['SERVER_NAME']);//2019-11-19 ming 說不存在的頁面/資料全轉跳首頁
			die;
		}
	// 2018-02-21 Ming早上說要加的，要用的時候在打開
	// } else { 
	// 	header('Location: http://'.$_SERVER['SERVER_NAME'].'/XXX.html');
	// 	die;

	// } // _GET['id']

}

include 'layoutv3/init.php';

/* 2017-12-17
if(preg_match('/productdetail/', $_SERVER["SCRIPT_NAME"])){
	// 內頁的page和source放這裡
} else {
	// 列表的page和source放這裡
}
 */

// $page = array(
// 	array(
// 		'file' => '$layout_main',
// 		'hole' => array(
// 			array(
// 				'file' => '$側邊結構',
// 				'hole' => array(
// 					array('file' => '$側邊選單'),
// 					array(
// 						'hole' => array(
// 							array(
// 								'file' => 'v3/product/layout_sub_3c',
// 								'hole' => array(
// 									array(
// 										'hole' => array(
// 											array('file' => 'v3/product/list1_1'),
// 											array('file' => 'system/search'),
// 										),
// 									),
// 								),
// 							),
// 							array('file' => 'v3/pagenav2'),
// 						),
// 					),
// 				),
// 			),
// 		),
// 	),
// );

// 挑選所需要的資料
// $page_source = array(
// 	'share-core',
// 	'share-page_title',
// 	'share-breadcrumb',
// 	'top_link_menu-v1',
// 	'webmenu-v1',
// 	'webmenu-bottom',
// 	'webmenu-sub',
// 	'home-banner',
// 	// 'product-submenu',
// 	// 'product-general',
// 	'share-general_item',
// 	'share-search', // 搜尋要在分項資料之下、分頁之上
// 	'share-pagenav',
// 
// 	// 結尾的程式碼，通常都放這裡
// 	'share-end',
// );

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

// 2018-05-30 次選單升級、加上有側邊選單、和有搜尋的情況下，就要隱藏側邊選單，以及更改功能名稱和麵包屑
if(!isset($_GET['id']) and isset($_GET['q']) and isset($this->data['webmenu_layer_up']) and isset($this->data['webmenu_layer_up'][$this->data['router_method']])){
	$view_file = 'v3/breadcrumb';
	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
		$data[$layoutv3_struct_map_keyname[$view_file][0]][1]['name'] = 'Search';
		$data[$layoutv3_struct_map_keyname[$view_file][0]][1]['url'] = '#';
	}

	$view_file = 'v3/sub_page_title';
	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
		$data[$layoutv3_struct_map_keyname[$view_file][0]]['name'] = 'Search';
		$data[$layoutv3_struct_map_keyname[$view_file][0]]['sub_name'] = '';
	}

}

// 2018-05-15 webmenuchild layer_up以後，左側選單不見的客制程式碼
// $row = $this->cidb->where('is_enable',1)->where('id',$_GET['id'])->get('producttype')->row_array();
// if($row and isset($row['id']) and $row['id'] > 0 and $row['pid'] != 0){
// 	$prefix_id = 888888;
// 	$this->data['func_name_id'] = $prefix_id.$row['pid'];
// 
// 	$view_file = 'header/nav_menu2';
// 	$tmps = $data[$layoutv3_struct_map_keyname[$view_file][0]];
// 	if($tmps and count($tmps) > 0){
// 		$row = array();
// 		foreach($tmps as $k => $v){
// 			if($v['id'] == $this->data['func_name_id'] and isset($v['child']) and count($v['child']) > 0){
// 				$row = $v['child'];
// 				break;
// 			}
// 		}
// 		//var_dump($row);
// 
// 		// 把$row的根，給弄出來
// 		if($row and count($row) > 0){
// 			foreach($row as $k => $v){
// 				$row[$k]['pid'] = 0;
// 			}
// 		}
// 
// 		//$data[$ID] = $row;
// 		$data[$layoutv3_struct_map_keyname['default/sidemenu'][0]] = $row;
// 	}
// }

// SEO
// if($_SERVER['SCRIPT_NAME'] == '/product.php' and !isset($_GET['id'])){
// 	$this->data['seo_description'] = 'Welcome to Yu Mao used offset printing machine website. Yu Mao has decades of professional experience on treading used printing machine. In Taiwan we not only have own printing shop also provide variety brand of used offset printing machine. Such as Heidelberg, Komori, Roland, Mitsubishi, Akiyama, Hamada, Sakurai, etc. ';
// 	$this->data['seo_keywords'] = 'Used Digital printing machine,Used Offset Printing Machine,Secondhand Printing machine Japan ';
// 	$data['head_title'] = 'Used Digital printing machine,Secondhand Printing machine Japan,Used Offset Printing Machine , YU MAO PRINTING MACHINE';
// }

include 'layoutv3/render.php';

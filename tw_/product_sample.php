<?php

/*
 * 這一個檔案是範本，不要把我刪掉哦
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

$layoutv3_parent_path = 'tw/';
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../'); // 產品內頁可能會需要

if(!isset($_SESSION) and isset($_GET['id']) and !is_numeric($_GET['id'])){
	session_start();
	$_SESSION['web_ml_key'] = 'tw'; // 非主語系的時候，而且要xx/abc.html的情況，這一行就必需要加
	$id_name = $_GET['id'];

	$aaa = file_get_contents('../_i/config/db.php');
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
		// 'db_debug' => true,
	);

	include_once '../layoutv3/cig/ci.php'; // 要記得，在init之上的東西，會載入兩次
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
			//$_SERVER['REQUEST_URI'] = '/product.php';
			//$_SERVER["SCRIPT_NAME"] = $id_name.'.html';
			$is_type = true;
		}
	}else{
		header("HTTP/1.0 404 Not Found");
		die;
	}
	
	/* //產品
	if(!$is_type){
		$query = $ggg->where('script_name', $id_name)->get('product'.$_SESSION['web_ml_key']);
		$product_row = $query->row_array();

		if($product_row and isset($product_row['id']) and $product_row['id'] > 0){
			$_SERVER["SCRIPT_NAME"] = '/productdetail.php';
			$_GET['id'] = $product_row['id'];
		} else {
			header("HTTP/1.0 404 Not Found");
			die;
		}
	}
	*/

}

//ming說 如果不是靜態連結進來的，那就搜尋資料後跳轉到靜態頁面
if(!isset($_SESSION) and isset($_GET['did']) and is_numeric($_GET['did'])){

	session_start();
	$id = $_GET['did'];

	$aaa = file_get_contents('../_i/config/db.php');
	$aaa = str_replace('aaa_','gggaaa_',$aaa);
	eval('?'.'>'.$aaa);

	include_once '../layoutv3/ci.php'; // 要記得，在init之上的東西，會載入兩次
	$ggg = ggg_load_database("mysql://".gggaaa_dbuser.":".gggaaa_dbpass."@".gggaaa_dbhost."/".gggaaa_dbname, true);

	$is_type = false;

	//分類
	$query = $ggg->where('seo_item_id', $id)->where('seo_ml_key',$_SESSION['web_ml_key'])->get('seo');
	if($query){
		$producttype_row = $query->row_array();
		if($producttype_row and isset($producttype_row['seo_script_name']) and $producttype_row['seo_item_id'] > 0){
			header('Location: http://www.wu-luen.com.tw/'.$producttype_row['seo_script_name'].'.html');
			die;
		}		
	}else{

		header("HTTP/1.0 404 Not Found");
		die;
	}

}


include '../layoutv3/init.php';

$page = array(
	array(
		'file' => '$layout_main',
		'hole' => array(
			array(
				'hole' => array(
					array(
						'file' => 'sub_page_title',
						'hole' => array(
							array('file' => 'breadcrumb'),
						),
					),
					array(
						//'file' => 'product/layout1', // 選單右
						'file' => 'product/layout2', // 選單左
						//'file' => 'product/layout3', // 無選單
						'hole' => array(
							array(
								'file' => 'shop/block',
								'hole' => array(
									array('file' => 'product/promenu'),
									// array('file' => 'product/promenu2'), // 左側選單，點下去不是展開，而是換頁，換頁完才展開，這個是SEO在使用的
								),
							),
							array('file' => 'category_title'),
							array(
								'file' => 'product/layout_sub_3c', // layout1,2在用的
								//'file' => 'product/layout_sub_4c', // layout3專用
								'hole' => array(
									array('file' => 'product/list1_1'),
								),
							),
							array('file' => 'system/empty'), // 因為shop的banner，佔住了第四個洞
						),
					),
					array('file' => 'pagenav'),
				),
			),
		),
	),
);

// 挑選所需要的資料
$page_source = array(
	'share-core',
	'share-page_title',
	'share-breadcrumb',
	'top_link_menu-v1',
	'webmenu-v1',
	'webmenu-bottom',
	'home-banner',
	'product-submenu',
	'product-general',
	'share-pagenav',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

include '../layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

//產品專用SEO
if($_SERVER['SCRIPT_NAME'] == '/product.php' and !isset($_GET['id'])){
	if($this->data['ml_key'] == 'en'){
		$this->data['seo_description'] = 'ggg';
		$this->data['seo_keywords'] = 'aaa';
		$data['head_title'] = 'aa, bb, cc';
	} else {
		$this->data['seo_description'] = 'ggg';
		$this->data['seo_keywords'] = 'aaa';
		$data['head_title'] = 'aa, bb, cc';
	}
}

include '../layoutv3/render.php';

<?php

// 為了支援/XXX/news.php
$tmps = explode('/', $_SERVER['REQUEST_URI']);

// 檢查次資料夾的那支檔案是否存在，不存在的話，就不用特別處理
$tmps2 = $tmps;
unset($tmps2[0]);
$check2 = implode('/', $tmps2);

$layoutv3_parent_path = ''; // 2018-11-13
if(count($tmps) == 3){
	$layoutv3_parent_path = $tmps[1].'/'; // 例：tw, news, product, contact
	set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../'); // 產品內頁可能會需要
}

/*
 * 2018-03-01
 * 後台 / LayoutV3 / 頁面區塊
 * 不存在的parent/XXX檔案，都會用這一支來取代
 */

if(!defined('LAYOUTV3_IS_RUN_FIRST')){
	if(isset($layoutv3_parent_path) and $layoutv3_parent_path != ''){
		include '../layoutv3/init.php';
	} else {
		include 'layoutv3/init.php';
	}
} else {
	if(LAYOUTV3_PARENT_PATH != ''){
		include '../layoutv3/init.php';
	} else {
		include 'layoutv3/init.php';
	}
}

$page = array(
	array(
		'file' => 'system/index_sitemapxml',
		'hole' => array(
			array('file' => 'system/sitemapxml'),
		),
	),
);

// 挑選所需要的資料
$page_source = array(
	'share-core',
	'webmenu-v1',
);

// include 'layoutv3/print_table.php';
if(LAYOUTV3_PARENT_PATH != ''){
	include '../layoutv3/pre_render.php';
	// include '../layoutv3/print_struct.php';
} else {
	include 'layoutv3/pre_render.php';
	// include 'layoutv3/print_struct.php';
}

// include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

// 2018-05-30 次選單升級、加上有側邊選單、和有搜尋的情況下，就要隱藏側邊選單，以及更改功能名稱和麵包屑
if(!isset($_GET['id']) and isset($_GET['q']) and isset($this->data['webmenu_layer_up']) and isset($this->data['webmenu_layer_up'][$this->data['router_method']])){
	$view_file = 'breadcrumb';
	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
		$data[$layoutv3_struct_map_keyname[$view_file][0]][1]['name'] = 'Search';
		$data[$layoutv3_struct_map_keyname[$view_file][0]][1]['url'] = '#';
	}

	$view_file = 'sub_page_title';
	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
		$data[$layoutv3_struct_map_keyname[$view_file][0]]['name'] = 'Search';
		$data[$layoutv3_struct_map_keyname[$view_file][0]]['sub_name'] = '';
	}

}

// 不需要側選單，因為預設內頁結構是有側選單的
// $view_file = 'default/layout_sidemenu';
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$layoutv3_struct_map_keyname[$view_file][0]]['type'] = 3; // 無選單 | 沒滿版
// }

if(LAYOUTV3_PARENT_PATH != ''){
	include '../layoutv3/render.php';
} else {
	include 'layoutv3/render.php';
}

// include 'layoutv3/render.php';

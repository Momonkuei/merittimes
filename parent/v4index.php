<?php

// 2019-05-29 因為帝寶而加的
date_default_timezone_set("Asia/Taipei");

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
	if(isset($layoutv3_parent_path) and $layoutv3_parent_path != '' and file_exists('../layoutv3/init.php')){ // 2019-03-25 加條件 file_exists('../layoutv3/init.php') by lota
		include '../layoutv3/init.php';
	} else {
		include 'layoutv3/init.php';
	}
} else {
	if(LAYOUTV3_PARENT_PATH != '' and file_exists('../layoutv3/init.php')){
		include '../layoutv3/init.php';
	} else {
		include 'layoutv3/init.php';
	}
}

$page = array(
	array(
		'file' => 'v4/index',
		'hole' => array(
			array(
				'hole' => array(
					array(
						'file' => 'system/head',
						'hole' => array(
							array('file' => 'v4/css'),
						),
					),
					array('file' => 'system/google_analytics'),
					array('file' => 'v4/common/word'),
				),
			),
			array('file' => 'system/empty'),
			array(
				'hole' => array(
					array('file' => 'v4/header/header02'), // 01 ~ 08
					array('file' => 'v4/banner/banner08'), // 01 ~ 11
					// array('file' => 'v3/widget/mb_panel2'), // 手機第2版 (header02、header03、header07不需要)
					array('file' => 'v4/home'),
					// array('file' => 'v4/_about'),
				),
			),
			array(
				'hole' => array(
					array('file' => 'v4/footer/footer02'), // 01 ~ 09
					array('file' => 'v4/common/end'),
					array('file' => 'system/end'),
				),
			),
		),
	),
);

// 挑選所需要的資料
$page_source = array(
	'share-core',
	// 'share-page_title',
	// 'share-breadcrumb',
	// 'top_link_menu-v1',
	// 'webmenu-v1',
	// 'webmenu-bottom',
	// 'home-banner',
	// 'company-general',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

// include 'layoutv3/print_table.php';
if(LAYOUTV3_PARENT_PATH != '' and file_exists('../layoutv3/pre_render.php')){
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

// 不需要側選單，因為預設內頁結構是有側選單的
// $view_file = 'default/layout_sidemenu';
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$layoutv3_struct_map_keyname[$view_file][0]]['type'] = 3; // 無選單 | 沒滿版
// }

// #32225
// 一般的頁面，會有功能名稱，和分項(分類)名稱，但是編排頁沒有
// 所以這裡就是挑編排頁的時候，把功能名稱，給分項(分類)名稱給取代掉
if(preg_match('/_/', $this->data['router_method']) and isset($data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]][2])){
	$webmenuchild_id = $data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]][2]['id'];
	$name = $data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]][2]['name'];
	$sub_name = '';

	$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$webmenuchild_id)->get('webmenuchild')->row_array();
	if($row and isset($row['id'])){
		if($row['func_name'] != ''){
			$name = $row['func_name'];
		}

		if($row['func_en_name'] != ''){
			$sub_name = $row['func_en_name'];
		}
	}

	$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]]['name'] = $name;
	$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]]['sub_name'] = $sub_name;
}

// SEO
// if($this->data['ml_key'] == 'tw'){
// 	if($this->data['router_method'] == 'company_1'){
// 		$this->data['seo_description'] = '台北婚宴會館-臻愛京華會館：「場地浪漫+豐盛菜餚+客製化專屬婚宴+新人網路口碑評價推薦」，台北最專業的 婚宴餐廳，給妳最難忘回憶，歡迎來電洽詢';
// 		$this->data['seo_keywords'] = '台北婚宴會館、台北婚宴餐廳';
// 		$data['head_title'] = '台北婚宴會館、台北婚宴餐廳 推薦--臻愛-京華婚宴會館';
// 	} elseif($this->data['router_method'] == 'download'){
// 	}
// }

if(LAYOUTV3_PARENT_PATH != '' and file_exists('../layoutv3/render.php')){
	include '../layoutv3/render.php';
} else {
	include 'layoutv3/render.php';
}

// include 'layoutv3/render.php';

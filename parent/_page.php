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
		if(FRONTEND_FOLDER==''){ //2019-08-08 加入實體子資料夾判斷 by lota
			include '../layoutv3/init.php';
		}else{
			include 'layoutv3/init.php';
		}
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

/* 
 * 2020-12-30 產品搜尋的情況
 */
// if(preg_match('/product/', $_SERVER["SCRIPT_NAME"])){
// 	if(!isset($_GET['id']) and isset($_GET['q'])){
// 		$page = array(
// 			array(
// 				'file' => '$layout_v4',
// 				'hole' => array(
// 					array(
// 						'file' => '$layout_v4_12',
// 						'hole' => array(
// 							array('file' => 'v4/widget/sidemenu/1'),
// 							array(
// 								'file' => 'v4/layout/row',
// 								'hole' => array(
// 									array(
// 										'hole' => array(
// 											array('file' => 'v4/product/list1'),
// 											array('file' => 'system/search'),
// 										),
// 									),
// 								),
// 							),
// 						),
// 					),
// 				),
// 			),
// 		);
// 	}
// }


/* 
 * 2021-01-05 購物搜尋的情況
 */
if(preg_match('/shop/', $_SERVER["SCRIPT_NAME"])  && LAYOUTV3_THEME_NAME=='v3'){
	if(!isset($_GET['id']) and isset($_GET['q'])){
		$page = array(
			array(
				'file' => '$layout_main',
				'hole' => array(
					array(
						'hole' => array(
							array(
								'file' => 'v3/sub_page_title',
								'hole' => array(
									array('file' => 'v3/breadcrumb'),
								),
							),
							array(
								//'file' => 'v3/product/layout2', // 選單左
								// 'file' => 'v3/product/layout1', // 選單右
								'file' => 'v3/product/layout3', // 無選單
								'hole' => array(
									array('file' => 'system/empty'),
									array('file' => 'v3/category_title'),
									array(
										'hole' => array(
											//array('file' => 'v3/shop/list1_1'),
											array('file' => 'v3/shop/list1_2'),
											array('file' => 'system/search'),
										),
									),
									array(
										'hole' => array(
											array(
												'file' => 'v3/default/layout_normal',
												'hole' => array(
													array('file' => 'system/empty'),
													array('file' => 'system/empty'),
													array('file' => 'v3/shop/banner'),
													array('file' => 'system/empty'),
												),
											),
											array('file' => 'v3/default/sidemenu_empty_datasource'),
										),
									),
								),
							),
							array(
								'file' => 'v3/widget/sticky_filter',
								'hole' => array(
									array(
										'hole' => array(
											//array('file' => 'v3/shop/filter1'),
											//array('file' => 'v3/shop/filter1'),
											array('file' => 'v3/shop/filter2'),
										),
									),
								),
							),
							array('file' => 'v3/pagenav2'),
						),
					),
				),
			),
		);
	}
}

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
if(LAYOUTV3_PARENT_PATH != '' and file_exists('../layoutv3/pre_render.php')){
	if(FRONTEND_FOLDER==''){ //2019-08-08 加入實體子資料夾判斷 by lota
		include '../layoutv3/pre_render.php';
		// include '../layoutv3/print_struct.php';
	}else{
		include 'layoutv3/pre_render.php';
		// include 'layoutv3/print_struct.php';
	}
} else {
	include 'layoutv3/pre_render.php';
	// include 'layoutv3/print_struct.php';
}


// include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

// 2018-05-30 次選單升級、加上有側邊選單、和有搜尋的情況下，就要隱藏側邊選單，以及更改功能名稱和麵包屑
//if(!isset($_GET['id']) and isset($_GET['q']) and isset($this->data['webmenu_layer_up']) and isset($this->data['webmenu_layer_up'][$this->data['router_method']])){
if(!isset($_GET['id']) and isset($_GET['q']) ){
	if(LAYOUTV3_THEME_NAME == 'v3'){
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
	} elseif(LAYOUTV3_THEME_NAME == 'v4'){
		$view_file = 'v4/widget/breadcrumb';
		if(isset($layoutv3_struct_map_keyname[$view_file][0])){
			$data[$layoutv3_struct_map_keyname[$view_file][0]][1]['name'] = 'Search';
			$data[$layoutv3_struct_map_keyname[$view_file][0]][1]['url'] = '#';
		}

		$view_file = 'v4/sub_page_title';
		if(isset($layoutv3_struct_map_keyname[$view_file][0])){
			$data[$layoutv3_struct_map_keyname[$view_file][0]]['name'] = 'Search';
			$data[$layoutv3_struct_map_keyname[$view_file][0]]['sub_name'] = '';
		}
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

// 2020-10-22
// 透過新的方式來取得麵包屑
$breadcrumb = array();
$page_source_data_param1 = 'share-breadcrumb';
include _BASEPATH.'/../source/system/page_source_data.php';
if(isset($page_source_data_return) and !empty($page_source_data_return)){
	$breadcrumb = $page_source_data_return;
}

if(preg_match('/_/', $this->data['router_method']) and !empty($breadcrumb) and isset($breadcrumb[2])){
	$webmenuchild_id = $breadcrumb[2]['id'];
	$name = $breadcrumb[2]['name'];
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

	//2021-02-21 lota fix 配合非中文語系可能不會有兩個標題而處理，有需要再打開
	// if($sub_name=='' or $sub_name == $name){
	// 	$sub_name = $name;
	// 	$name = '';
	// }

	$page_source_data_param1 = 'share-page_title';
	$page_source_data_param2 = array(
		'name' => $name,
		'sub_name' => $sub_name,
	);

	// $page_source_data_param2['name'] = ''; // 如果要靜態頁的 sub_page_title 不出現，就打開這個 by lota 2021/03/02
	// $page_source_data_param2['sub_name'] = ''; // 如果要靜態頁的 sub_page_title 不出現，就打開這個 by lota 2021/03/02

	$page_source_data_other = array('assign_force'=>true);
	include _BASEPATH.'/../source/system/page_source_data.php';
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

// 會員專用
// 2020-08-03
if(preg_match('/^member(center|bonuslist|orderlist|orderdetail|forget|forgetconfirm|changepassword|customeraddress|noticepayment)$/', $this->data['router_method'])){
	if(LAYOUTV3_PARENT_PATH != '' and file_exists('../layoutv3/render.php')){
		if(FRONTEND_FOLDER==''){ //2019-08-08 加入實體子資料夾判斷 by lota
			include '../source/core/member.php';
		}else{
			include 'source/core/member.php';
		}
	} else {
		include 'source/core/member.php';
	}
//} elseif($this->data['router_method'] == 'favorite'){
} elseif(preg_match('/^(favorite|guestlogin)$/',$this->data['router_method'])){
	$member_page_title = array();
	$member_breadcrumb = array();

	if($this->data['router_method'] == 'favorite'){
		$member_page_title = array("name"=>t('Favorite List'),"sub_name"=>'');
		$member_breadcrumb = array(array("name"=>"HOME","url"=>"/"),array("name"=>t('Favorite List'),"url"=>'favorite_'.$this->data['ml_key'].'.php'));
	} elseif($this->data['router_method'] == 'guestlogin'){
		$member_page_title = array("name"=>t('Login'),"sub_name"=>'');
		$member_breadcrumb = array(array("name"=>"HOME","url"=>"/"),array("name"=>('Login'),"url"=>'guestlogin_'.$this->data['ml_key'].'.php'));
	}

	if(!empty($member_page_title)){
		if(LAYOUTV3_THEME_NAME == 'v3'){
			if(isset($layoutv3_struct_map_keyname['v3/sub_page_title'][0])){
				$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]] = $member_page_title;
			}
		} elseif(LAYOUTV3_THEME_NAME == 'v4'){
			if(isset($layoutv3_struct_map_keyname['v4/sub_page_title'][0])){
				$data[$layoutv3_struct_map_keyname['v4/sub_page_title'][0]] = $member_page_title;
			}
		}
	}

	if(!empty($member_breadcrumb)){
		if(LAYOUTV3_THEME_NAME == 'v3'){
			if(isset($layoutv3_struct_map_keyname['v3/breadcrumb'][0])){
				$data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]] = $member_breadcrumb;
			}
		} elseif(LAYOUTV3_THEME_NAME == 'v4'){
			if(isset($layoutv3_struct_map_keyname['v4/widget/breadcrumb'][0])){
				$data[$layoutv3_struct_map_keyname['v4/widget/breadcrumb'][0]] = $member_breadcrumb;
			}
		}
	}
}

if(LAYOUTV3_PARENT_PATH != '' and file_exists('../layoutv3/render.php')){
	if(FRONTEND_FOLDER==''){ //2019-08-08 加入實體子資料夾判斷 by lota
		include '../layoutv3/render.php';
	}else{
		include 'layoutv3/render.php';
	}
} else {
	include 'layoutv3/render.php';
}

// include 'layoutv3/render.php';

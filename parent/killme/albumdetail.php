<?php

// SEO
// @session_start();
// $_SESSION['web_ml_key'] = 'tw';
// $layoutv3_parent_path = 'tw/'; // 本程式在子資料夾內，相關檔案在根目錄 (通常是Yii和cig前台在用) ex: contact/
// $layoutv3_path = ''; // 本程式在子資料夾內，相關檔案也在該層目錄裡面 (通常是cig後台在用) ex: contact/
// include '../layoutv3/init.php';

include 'layoutv3/init.php';

// 2019-01-22 這個是舊的，然後v3/album/layout3，是新弄的，不過它們是歸類舊的layout
if(0){
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
						// array('file' => 'v3/category_title'),
						array(
							'file' => 'v3/album/layout1', // 無選單，category_title在裡面
							//'file' => 'v3/album/layout2', // 選單左，category_title在外面，側邊選單的註解打開
							//'file' => 'v3/album/layout3', // 選單右，category_title在外面，側邊選單的註解打開
							'hole' => array(
								array(
									'hole' => array(
										array('file' => 'v3/category_title'),
										array('file' => 'v3/album/type2_2'),
										array('file' => 'v3/pagenav'),
									),
								),
								array('file' => '$側邊選單'),
							),
						),
					),
				),

			),
		),
	);
}

if(0){
	// 挑選所需要的資料
	$page_source = array(
		'share-core',
		'share-page_title',
		'share-breadcrumb',
		'top_link_menu-v1',
		'webmenu-v1',
		'webmenu-bottom',
		'webmenu-sub',
		'home-banner',

		//'album-submenu',
		'albumdetail-general',
		'share-pagenav',

		// 結尾的程式碼，通常都放這裡
		'share-end',
	);
}

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

// 不需要側選單，因為預設內頁結構是有側選單的
// $view_file = 'default/layout_sidemenu';
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$layoutv3_struct_map_keyname[$view_file][0]]['type'] = 3; // 無選單 | 沒滿版
// }

include 'layoutv3/render.php';

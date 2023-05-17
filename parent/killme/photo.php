<?php

// SEO
// @session_start();
// $_SESSION['web_ml_key'] = 'tw';
// $layoutv3_parent_path = 'tw/'; // 本程式在子資料夾內，相關檔案在根目錄 (通常是Yii和cig前台在用) ex: contact/
// $layoutv3_path = ''; // 本程式在子資料夾內，相關檔案也在該層目錄裡面 (通常是cig後台在用) ex: contact/
// include '../layoutv3/init.php';

include 'layoutv3/init.php';

$page = array(
	array(
		'file' => '$layout_main',
		'hole' => array(
			array(
				'file' => '$sub_page_no_menu',
				'hole' => array(
					array('file' => '$common_sidemenu'), // sidemenu
					array('file' => 'category_title'), // category_title
					array(
						'hole' => array(
							array(
								//'file' => 'product/layout_sub_3c', // layout1,2在用的
								'file' => 'product/layout_sub_4c', // layout3專用
								'hole' => array(
									array('file' => 'album/type1'),
								),
							),
							array('file' => 'pagenav'),
						),
					),
					// shop banner在用的，這個區塊雖然是排第四個洞，但優先權最高，請參照view/layout_sidemenu.php
					array(
						'hole' => array(
							array('file' => 'system/empty'), 
							array('file' => 'default/sidemenu_empty_datasource'),
						),
					),
				),
			),
			// array(
			// 	'hole' => array(
			// 		array(
			// 			'file' => 'sub_page_title',
			// 			'hole' => array(
			// 				array('file' => 'breadcrumb'),
			// 			),
			// 		),
			// 		array(
			// 			// 這是舊的，不要用唷
			// 			// 'file' => 'product/layout1', // 選單右
			// 			// 'file' => 'product/layout2', // 選單左
			// 			// 'file' => 'product/layout3', // 無選單
			// 			
			// 			// 滿版
			// 			// 'file' => 'default/layout_sidemenu_left_full',   // 選單左
			// 			// 'file' => 'default/layout_sidemenu_right_full',  // 選單右
			// 			// 'file' => 'default/layout_normal_full',          // 無選單

			// 			// 沒滿版
			// 			// 'file' => 'default/layout_sidemenu_left',   // 選單左
			// 			// 'file' => 'default/layout_sidemenu_right',  // 選單右
			// 			'file' => 'default/layout_normal',          // 無選單
			// 			'hole' => array(
			// 				array(
			// 					'file' => 'shop/block',
			// 					'hole' => array(
			// 						// array('file' => 'default/promenu'),
			// 						// array('file' => 'default/promenu2'), // 左側選單，點下去不是展開，而是換頁，換頁完才展開，這個是SEO在使用的
			// 						array('file' => 'default/sidemenu'), // 2018-01-17 winnie
			// 					),
			// 				),
			// 				array('file' => 'category_title'),
			// 				array(
			// 					//'file' => 'product/layout_sub_3c', // layout1,2在用的
			// 					'file' => 'product/layout_sub_4c', // layout3專用
			// 					'hole' => array(
			// 						array('file' => 'album/type1'),
			// 					),
			// 				),

			// 				// 因為shop的banner，佔住了第四個洞
			// 				array('file' => 'system/empty'), 
			// 				// array(
			// 				// 	'file' => 'default/layout_normal',
			// 				// 	'hole' => array(
			// 				// 		array('file' => 'system/empty'),									
			// 				// 		array('file' => 'system/empty'),
			// 				// 		array('file' => 'shop/banner'),
			// 				// 	),
			// 				// ),
			// 			),
			// 		),
			// 		array('file' => 'pagenav'),
			// 	),
			// ),
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
	'webmenu-sub',
	'home-banner',
	'photo-general',
	'share-pagenav',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
//include 'layoutv3/print_struct.php';

// 不需要側選單，因為預設內頁結構是有側選單的
// $view_file = 'default/layout_sidemenu';
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$layoutv3_struct_map_keyname[$view_file][0]]['type'] = 3; // 無選單 | 沒滿版
// }

include 'layoutv3/render.php';

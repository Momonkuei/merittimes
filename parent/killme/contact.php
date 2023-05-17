<?php

// SEO
// @session_start();
// $_SESSION['web_ml_key'] = 'tw';
// $layoutv3_parent_path = 'tw/'; // 本程式在子資料夾內，相關檔案在根目錄 (通常是Yii和cig前台在用) ex: contact/
// $layoutv3_path = ''; // 本程式在子資料夾內，相關檔案也在該層目錄裡面 (通常是cig後台在用) ex: contact/
// include '../layoutv3/init.php';

include 'layoutv3/init.php';

// $page = array(
// 	array(
// 		'file' => '$layout_main',
// 		'hole' => array(
// 			array(
// 				'hole' => array(
// 					array(
// 						'file' => '$sub_page',
// 						'hole' => array(
// 							array('file' => 'contact/info'), // sidemenu
// 							array('file' => 'system/empty'), // category_title
// 							array('file' => 'contact/type1'), // B2B (二選一)
// 							// array('file' => 'contact/type2'), // B2C (二選一)
// 							array('file' => 'system/empty'), // shop banner
// 						),
// 					),
// 					// array('file' => 'contact/googlemap1'), // iframe
// 					array('file' => 'contact/googlemap2'), // api
// 				)
// 			),
// 			// array(
// 			// 	'hole' => array(
// 			// 		array(
// 			// 			'file' => 'sub_page_title',
// 			// 			'hole' => array(
// 			// 				array('file' => 'breadcrumb'),
// 			// 			),
// 			// 		),
// 			// 		array(
// 			// 			'file' => 'contact/layout1', // 表單在右邊 (預設)
// 			// 			// 'file' => 'contact/layout2', // 表單在左
// 			// 			// 'file' => 'contact/layout3', // 無側欄 (winnie)，記得把info註解掉
// 			// 			'hole' => array(
// 			// 				array('file' => 'contact/info'), 
// 			// 				// array('file' => 'contact/type1'), // B2B
// 			// 				array('file' => 'contact/type2'), // B2C (預設)
// 			// 			),
// 			// 		),
// 			// 		// array('file' => 'contact/googlemap1'), // iframe
// 			// 		array('file' => 'contact/googlemap2'), // api
// 			// 	),
// 			// ),
// 		),
// 	),
// );

// 挑選所需要的資料
// $page_source = array(
// 	'contact-post',
// 	'share-core',
// 	'share-page_title',
// 	'share-breadcrumb',
// 	'top_link_menu-v1',
// 	'webmenu-v1',
// 	'webmenu-bottom',
// 	'webmenu-sub',
// 	'home-banner',
//
//	'contact-general',
// 
// 	// 結尾的程式碼，通常都放這裡
// 	'share-end',
// );

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
//include 'layoutv3/print_struct.php';

include 'layoutv3/render.php';

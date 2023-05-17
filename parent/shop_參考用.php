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
				'hole' => array(
					array(
						'file' => 'v3/sub_page_title',
						'hole' => array(
							array('file' => 'v3/breadcrumb'),
						),
					),
					array(
						// 這是舊的，不要用唷
						'file' => 'v3/product/layout2', // 選單左
						//'file' => 'v3/product/layout1', // 選單右
						// 'file' => 'v3/product/layout3', // 無選單
						
						// 滿版
						// 'file' => 'v3/default/layout_sidemenu_left_full',   // 選單左
						// 'file' => 'v3/default/layout_sidemenu_right_full',  // 選單右
						// 'file' => 'v3/default/layout_normal_full',          // 無選單

						// 沒滿版
						// 'file' => 'v3/default/layout_sidemenu_left',   // 選單左
						// 'file' => 'v3/default/layout_sidemenu_right',  // 選單右
						// 'file' => 'v3/default/layout_normal',          // 無選單
						'hole' => array(
							// array('file' => 'system/empty'), // 當選擇無側邊選單的時候，block那邊要註解，然後換這個註解拿掉
							array(
								'hole' => array(
									array(
										'file' => 'v3/shop/block',
										'hole' => array(
											array('file' => 'v3/default/promenu'),
										),
									),
									array(
										'file' => 'v3/shop/block',
										'hole' => array(
											array('file' => 'v3/default/promenu'),
										),
									),
									//array(
									//	'file' => 'v3/shop/block',
									//	'hole' => array(
									//		array('file' => 'v3/shop/filter1'),
									//	),
									//),
									//array(
									//	'file' => 'v3/shop/block',
									//	'hole' => array(
									//		array('file' => 'v3/shop/filter1'),
									//	),
									//),
									array(
										'file' => 'v3/shop/block',
										'hole' => array(
											array('file' => 'v3/shop/filter2'),
										),
									),
								),
							),
							array('file' => 'v3/category_title'),
							array('file' => 'v3/shop/list1_1'),
							array(
								'hole' => array(
									array(
										'file' => 'v3/default/layout_normal',
										'hole' => array(
											array('file' => 'system/empty'),									
											array('file' => 'system/empty'),
											array('file' => 'v3/shop/banner'),
										),
									),
									array('file' => 'v3/default/sidemenu_empty_datasource'),
								),
							),
						),
					),
					// 這裡面有許多寫死的，要注意
					array(
						'file' => 'v3/widget/sticky_filter',
						'hole' => array(
							array('file' => 'v3/shop/filter1'),
							array('file' => 'v3/shop/filter1'),
							array('file' => 'v3/shop/filter2'),
						),
					),
					array('file' => 'v3/pagenav'),
				),
			),
		),
	),
);

// 挑選所需要的資料
$page_source = array(
	'shop-post',
	'share-core',
	'share-page_title',
	'share-breadcrumb',
	'top_link_menu-v1',
	'webmenu-v1',
	'webmenu-bottom',
	//'webmenu-sub', // 2020-10-14 因為要執行shop-submenu，所以這個要關掉，要不然會衝到
	'home-banner',
	'shop-submenu',
	'shop-general',
	'share-pagenav',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

include 'layoutv3/render.php';

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
				'file' => '$sub_page',
				'hole' => array(
					array('file' => '$common_sidemenu'), // sidemenu
					array('file' => 'system/empty'), // category_title
					array(
						'file' => 'product/layout_sub_3c', // layout1,2在用的
						// 'file' => 'product/layout_sub_4c', // layout3專用
						'hole' => array(
							array(
								'file' => 'product/list2_1',
								'hole' => array(
									array(
										'hole' => array(
											array('file' => 'product/pictures_1'), // 左圖右文
											// array('file' => 'product/pictures_2'), // 圖上文下
											array('file' => 'product/tabs_1'),
											// array('file' => 'product/related_1'),
										),
									),
								),
							),
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

			// 		// 最單純的內頁
			// 		// array(
			// 		// 	'file' => 'product/list2_1',
			// 		// 	'hole' => array(
			// 		// 		array(
			// 		// 			'hole' => array(
			// 		// 				array('file' => 'product/pictures_1'), // 左圖右文
			// 		// 				// array('file' => 'product/pictures_2'), // 圖上文下
			// 		// 				array('file' => 'product/tabs_1'),
			// 		// 				// array('file' => 'product/related_1'),
			// 		// 			),
			// 		// 		),
			// 		// 	),
			// 		// ),

			// 		// 如果內頁要側選單的話，可以打開這裡，這裡是從產品列表頁複製過來的，只是差在修改product/list2_1
			// 		array(
			// 			//'file' => 'product/layout1', // 選單右
			// 			//'file' => 'product/layout2', // 選單左 2018-01-24 早上，李哥說經理說，預設是有側邊選單的
			// 			//'file' => 'product/layout3', // 無選單

			// 			'file' => 'default/layout_sidemenu_left',   // 選單左
			// 			// 'file' => 'default/layout_normal',          // 無選單
			// 			'hole' => array(
			// 				array(
			// 					'file' => 'shop/block',
			// 					'hole' => array(
			// 						array(
			// 							'hole' => array(
			// 								// array('file' => 'default/promenu'),
			// 								// array('file' => 'default/promenu2'), // 左側選單，點下去不是展開，而是換頁，換頁完才展開，這個是SEO在使用的
			// 								// array('file' => 'default/active'), // 展開
			// 								array('file' => 'default/sidemenu'), // 2018-01-17 winnie
			// 							),
			// 						),
			// 					),
			// 				),
			// 				array('file' => 'category_title'),
			// 				array(
			// 					'file' => 'product/layout_sub_3c', // layout1,2在用的
			// 					//'file' => 'product/layout_sub_4c', // layout3專用
			// 					'hole' => array(
			// 						array(
			// 							'file' => 'product/list2_1',
			// 							'hole' => array(
			// 								array(
			// 									'hole' => array(
			// 										array('file' => 'product/pictures_1'), // 左圖右文
			// 										// array('file' => 'product/pictures_2'), // 圖上文下
			// 										array('file' => 'product/tabs_1'),
			// 										// array('file' => 'product/related_1'),
			// 									),
			// 								),
			// 							),
			// 						),
			// 					),
			// 				),
			// 				array('file' => 'system/empty'), // 因為shop的banner，佔住了第四個洞
			// 			),
			// 		),
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
	//'product-submenu', // 用列表的，反正都一樣
	'productdetail-picture',
	'productdetail-related',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
//include 'layoutv3/print_struct.php';

include 'layoutv3/render.php';

<?php

$group_struct = array(
	array(
		'file' => 'v4/index',
		'hole' => array(
			array('file' => '$head2'),
			array(
				'hole' => array(
					array('file' => 'v4/common/word'),
					array('file' => 'v4/common/body_start'),
				),
			),
			array(
				'hole' => array(
					array('file' => 'system/empty_datasource/webmenu'),
					array(
						'hole' => array(
							// [header1]
							// array(
							// 	'file' => 'v4/header/layout1',
							// 	'hole' => array(
							// 		array('file' => 'v4/header/toplink/a'),
							// 		array('file' => 'v4/header/nav_menu'),
							// 	),
							// ),
							
							// [header2]
							// 主選單在漢堡裡面
							// array(
							// 	'file' => 'v4/header/layout2', 
							// 	'hole' => array(
							// 		array('file' => 'v4/header/toplink/a'),
							// 		array('file' => 'v4/header/nav_menu'),
							// 	),
							// ),

							// [header3]
							// 自帶手機版選單，只能一層
							// array(
							// 	'file' => 'v4/header/layout3', 
							// 	'hole' => array(
							//  		array('file' => 'v4/header/nav_menu3'),
							// 	),
							// ),

							// [header4]
							// array(
							// 	'file' => 'v4/header/layout4', 
							// 	'hole' => array(
							// 		// 左邊二個
							// 		array(
							// 			'file' => 'v4/header/toplink/b',
							// 			'params' => array(
							// 				'array_range_0' => '',
							// 				'array_range_1' => '0',
							// 				'array_range_2' => '1',
							// 				'array_range_3' => 'ID',
							// 			),
							// 		),
							// 		// 右邊二個
							// 		array(
							// 			'file' => 'v4/header/toplink/b',
							// 			'params' => array(
							// 				'array_range_0' => '',
							// 				'array_range_1' => '2',
							// 				'array_range_2' => '3',
							// 				'array_range_3' => 'ID',
							// 			),
							// 		),
							//  	array('file' => 'v4/header/nav_menu'),
							// 	),
							// ),

							// [header5]
							// array(
							// 	'file' => 'v4/header/layout5',
							// 	'hole' => array(
							// 		array(
							// 			'hole' => array(
							// 			 	array('file' => 'v4/header/toplink/a'),
							// 			 	array('file' => 'v4/header/toplink/a'),
							// 			),
							// 		),
							//  	// 左邊四個
							//  	array(
							//  		'file' => 'v4/header/nav_menu_less',
							//  		'params' => array(
							//  			'array_range_0' => '',
							//  			'array_range_1' => '0',
							//  			'array_range_2' => '3',
							//  			'array_range_3' => 'ID',
							//  		),
							//  	),
							//  	// 右邊四個
							//  	array(
							//  		'file' => 'v4/header/nav_menu_less',
							//  		'params' => array(
							//  			'array_range_0' => '',
							//  			'array_range_1' => '4',
							//  			'array_range_2' => '7',
							//  			'array_range_3' => 'ID',
							//  		),
							//  	),
							// 	),
							// ),

							// [header6]
							// array(
							// 	'file' => 'v4/header/layout6',
							// 	'hole' => array(
							// 	 	array('file' => 'v4/header/toplink/b'),
							// 		array('file' => 'v4/header/nav_menu'),
							// 	),
							// ),

							// [header7]
							// 自帶Banner，和scrollDown，記得banner尺寸是1920x1280
							// array(
							// 	'file' => 'v4/header/layout7',
							// 	'hole' => array(
							// 	 	array('file' => 'v4/header/toplink/b'),
							// 		array('file' => 'v4/banner/banner_for_header7'),
							// 		array('file' => 'v4/header/nav_menu4'),
							// 		array('file' => 'v4/header/nav_menu_for_layout7'),
							// 	),
							// ),

							// [header8]
							// array(
							// 	'file' => 'v4/header/layout8',
							// 	'hole' => array(
							// 	 	array('file' => 'v4/header/toplink/a'),
							// 		array('file' => 'v4/header/nav_menu2'),
							// 	),
							// ),

							// [header9] 由 header7 改的
							// 自帶Banner，和scrollDown，記得banner尺寸是1920x1280
							array(
								'file' => 'v4/header/layout9',
								'hole' => array(
								 	array('file' => 'v4/header/toplink/b'),
									array('file' => 'v4/banner/banner_for_header9'),
									array('file' => 'v4/header/nav_menu4'),
									array('file' => 'v4/header/nav_menu_for_layout9'),
								),
							),

						),
					),
					// header07 09 不需要Banner
					// 3,5,6,7,8,9,10沒有小圖

					array(
						'file' => 'system/holes',
						'params' => array(
							// (洞的數字，從一開始)_(功能名稱)
							// 例：1_constant => 後台/最大管理/常數設定 裡面的常數簡稱，假設backend_menu_merge
							// 例：1_exclude => 排除的view相對路徑，全型逗點分隔，假設v4/header/layout3,v4/header/layout7
							'1_exclude' => 'v4/header/layout7，v4/header/layout9',
						),
						'hole' => array(
							array(
								'hole' => array(
									// [banner1]
									// array(
									// 	'file' => 'v4/banner/banner01',
									// 	'hole' => array(
									// 		array('file' => 'v4/banner/scrolldown/1'),
									// 	),
									// ),

									// [banner2]
									// array(
									// 	'file' => 'v4/banner/banner02',
									// 	'hole' => array(
									// 		array('file' => 'v4/banner/scrolldown/2'),
									// 	),
									// ),

									// [banner3]
									// 圖片尺寸1200x805
									// 有標題，和內容
									// 內容的部份，記得要補detail textarea的後台欄位
									// array('file' => 'v4/banner/banner03'),

									// [banner4]
									// 上方大圖，下方有小圖，小圖也會跟著動
									// array('file' => 'v4/banner/banner04'),

									// [banner5]
									// 1920x600，只有一張圖，但是有多組標題和內容
									// 圖的部份，目前定義它為靜態圖
									// array('file' => 'v4/banner/banner05'),

									// [banner6]
									// 正方型旋轉
									// 有標題，和內容
									// 內容的部份，記得要補detail textarea的後台欄位
									array('file' => 'v4/banner/banner06'),

									// [banner7]
									// 換圖的時候，會有殘影和震動的效果
									// 有標題，和內容
									// 內容的部份，記得要補detail textarea的後台欄位
									// array(
									// 	'file' => 'v4/banner/banner07',
									// 	'hole' => array(
									//  		array('file' => 'v4/banner/scrolldown/3'),
									// 	),
									// ),

									// [banner8]
									// 只有標題
									// 標題的下面有倒數計時條
									// 變很大張，然後標題在中間
									// array('file' => 'v4/banner/banner08'),

									// [banner9]
									// 滑鼠移到右邊或左邊，會有東西浮出來
									// 有標題、連結和內容
									// 內容的部份，記得要補detail textarea的後台欄位
									// array(
									// 	'file' => 'v4/banner/banner09',
									// 	'hole' => array(
									//  		array('file' => 'v4/banner/scrolldown/4'),
									// 	),
									// ),

									// [banner10]
									// 中間有框框，框裡面有文字、內容和按鈕，按鈕有連結的時候才會出現
									// 內容的部份，記得要補detail textarea的後台欄位
									// array('file' => 'v4/banner/banner10'),

									// [banner11]
									// 圖會由小變大
									// array('file' => 'v4/banner/banner11'),

								),
							),
						),
					),
					// header07 09 不需要內頁Banner
					array(
						'file' => 'system/holes',
						'params' => array(
							// (洞的數字，從零開始)_(功能名稱)
							// 例：1_constant => 後台/最大管理/常數設定 裡面的常數簡稱，假設backend_menu_merge
							// 例：1_exclude => 排除的view相對路徑，全型逗點分隔，假設v4/header/layout3,v4/header/layout7
							'1_exclude' => 'v4/header/layout7，v4/header/layout9',
						),
						'hole' => array(
							array('file' => 'v4/banner/pageBanner'),
						),
					),
					array('file' => '// HOLE'),
					array(
						'hole' => array(
							// [footer1]
							// array(
							// 	'file' => 'v4/footer/layout1',
							// 	'hole' => array(
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2744'), // 頁尾 - 主選單
							//  				array('file' => 'v4/footer/sitemap/1'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2745'), // 頁尾 - 客製選單 
							//  				array('file' => 'v4/footer/sitemap/3'),
							//  			),
							//  		),
							// 		array('file' => 'v4/footer/copyright_txt'),
							// 	),
							// ),

							// [footer2]
							// array(
							// 	'file' => 'v4/footer/layout2',
							// 	'hole' => array(
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2746'), // 節點1
							//  				array('file' => 'datasource___2747'), // 節點1的資料
							//  				array('file' => 'v4/footer/sitemap/4'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2748'), // 節點2
							//  				array('file' => 'datasource___2749'), // 節點2的資料
							//  				array('file' => 'v4/footer/sitemap/4'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2750'), // 節點3
							//  				array('file' => 'datasource___2751'), // 節點3的資料
							//  				array('file' => 'v4/footer/sitemap/4'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2744'), // 頁尾 - 主選單
							//  				array('file' => 'v4/footer/sitemap/1'),
							//  			),
							//  		),
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'v4/footer/copyright_txt'),
							// 				array('file' => 'v4/footer/social_list'),
							// 			),
							// 		),
							// 	),
							// ),
							
							// [footer3]
							// 前兩個是沒標題的分項
							// array(
							// 	'file' => 'v4/footer/layout3',
							// 	'hole' => array(
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'datasource___2744'), // 頁尾 - 主選單
							// 				array('file' => 'v4/footer/sitemap/1'),
							// 			),
							// 		),
							// 		array('file' => 'system/empty'),
							// 		array('file' => 'v4/footer/social_list'),
							// 		array('file' => 'v4/footer/footer_info'),
							// 		array('file' => 'v4/footer/copyright_txt'),
							// 	),
							// ),

							// [footer4]
							// 前兩個沒標題的分項做群組，群組自帶一個標題供修改，其它三個是自帶標題
							// array(
							// 	'file' => 'v4/footer/layout4',
							// 	'hole' => array(
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'datasource___2744'), // 頁尾 - 主選單 
							// 				array('file' => 'v4/footer/sitemap/1'),
							// 			),
							// 		),
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'datasource___2745'), // 頁尾 - 客製選單 
							// 				array('file' => 'v4/footer/sitemap/1'),
							// 			),
							// 		),
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'datasource___2746'), // 節點1
							// 				array('file' => 'datasource___2747'), // 節點1的資料
							// 				array('file' => 'v4/footer/sitemap/4'),
							// 			),
							// 		),
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'datasource___2748'), // 節點2
							// 				array('file' => 'datasource___2749'), // 節點2的資料
							// 				array('file' => 'v4/footer/sitemap/4'),
							// 			),
							// 		),
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'datasource___2750'), // 節點3
							// 				array('file' => 'datasource___2751'), // 節點3的資料
							// 				array('file' => 'v4/footer/sitemap/4'),
							// 			),
							// 		),
							// 		array('file' => 'v4/footer/footer_info'),
							//  	array('file' => 'v4/footer/social_list'),
							//  	array('file' => 'v4/footer/copyright_txt'),
							// 	),
							// ),

							// [footer5]
							// array(
							// 	'file' => 'v4/footer/layout5',
							// 	'hole' => array(
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'datasource___2744'), // 頁尾 - 主選單
							// 				array('file' => 'v4/footer/sitemap/1'),
							// 			),
							// 		),
							// 		array('file' => 'v4/footer/social_list'),
							// 		array('file' => 'v4/footer/copyright_txt'),
							// 	),
							// ),

							// [footer6]
							// array(
							// 	'file' => 'v4/footer/layout6',
							// 	'hole' => array(
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'datasource___2744'), // 頁尾 - 主選單
							// 				array('file' => 'v4/footer/sitemap/1'),
							// 			),
							// 		),
							//  		array('file' => 'v4/footer/footer_info'),
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'v4/footer/social_list'),
							// 				array('file' => 'v4/footer/copyright_txt'),
							// 			),
							// 		),
							// 	),
							// ),

							// [footer7]
							// array(
							// 	'file' => 'v4/footer/layout7',
							// 	'hole' => array(
							// 		array(
							// 			'hole' => array(
							// 				array('file' => 'v4/footer/footer_info'),
							// 				array('file' => 'v4/footer/social_list'),
							// 				array('file' => 'v4/footer/copyright_txt'),
							// 			),
							// 		),
							// 	),
							// ),

							// [footer8]
							// array(
							// 	'file' => 'v4/footer/layout8',
							// 	'hole' => array(
							//			array(
							//				'hole' => array(
							//					array('file' => 'v4/footer/footer_info'),
							//					array('file' => 'v4/footer/social_list'),
							//					array('file' => 'v4/footer/copyright_txt'),
							//				),
							//			),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2746'), // 節點1
							//  				array('file' => 'datasource___2747'), // 節點1的資料
							//  				array('file' => 'v4/footer/sitemap/6'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2744'), // 頁尾 - 主選單
							//  				array('file' => 'v4/footer/sitemap/1'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2748'), // 節點2
							//  				array('file' => 'datasource___2749'), // 節點2的資料
							//  				array('file' => 'v4/footer/sitemap/4'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2745'), // 頁尾 - 客製選單 
							//  				array('file' => 'v4/footer/sitemap/1'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2750'), // 節點3
							//  				array('file' => 'datasource___2751'), // 節點3的資料
							//  				array('file' => 'v4/footer/sitemap/4'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2744'), // 頁尾 - 主選單
							//  				array('file' => 'v4/footer/sitemap/1'),
							//  			),
							//  		),
							// 	),
							// ),

							// [footer9]
							// array(
							// 	'file' => 'v4/footer/layout9',
							// 	'hole' => array(
							//  		array('file' => 'v4/footer/footer_info'),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2746'), // 節點1
							//  				array('file' => 'datasource___2747'), // 節點1的資料
							//  				array('file' => 'v4/footer/sitemap/4'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2748'), // 節點2
							//  				array('file' => 'datasource___2749'), // 節點2的資料
							//  				array('file' => 'v4/footer/sitemap/4'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'datasource___2750'), // 節點3
							//  				array('file' => 'datasource___2751'), // 節點3的資料
							//  				array('file' => 'v4/footer/sitemap/4'),
							//  			),
							//  		),
							// 		array('file' => 'v4/footer/social_list'),
							// 		array('file' => 'v4/footer/copyright_txt'),
							// 	),
							// ),

							// [footer10] {樣式1} {預設}
							array(
								'file' => 'v4/footer/layout10',
								'hole' => array(
							 		array(
							 			'hole' => array(
							 				array('file' => 'datasource___2744'), // 頁尾 - 主選單
							 				array('file' => 'v4/footer/sitemap/1'),
							 			),
							 		),							 		
								),
							),

							// [footer11]
							// array(
							// 	'file' => 'v4/footer/layout11',
							// 	'hole' => array(
							//  		array(
							//  			'hole' => array(
							//  				array('file' => 'v4/footer/social_list'),
							//  				// array('file' => 'datasource___2744'), // 頁尾 - 主選單
							//  				// array('file' => 'v4/footer/sitemap/1'),
							//  			),
							//  		),
							//  		array(
							//  			'hole' => array(							 				
							//  				array('file' => 'v4/footer/copyright_txt'),
							//  			),
							//  		),
							// 		array('file' => 'system/empty'),
							// 	),
							// ),

						),
					),
				),
			),
			array(
				'hole' => array(
					// 購物
					// 2020-08-05 會跟隨後台的常數設定/是否有開啟購物功能
					array(
						'file' => 'system/holes',
						'params' => array(
							// (洞的數字，從零開始)_(功能名稱)
							// 例：1_constant => 後台/最大管理/常數設定 裡面的常數簡稱，假設backend_menu_merge
							// 例：1_exclude => 排除的view相對路徑，半型逗點分隔，假設v4/header/layout3,v4/header/layout7
							'1_constant' => 'shop_open',
						),
						'hole' => array(
							array(
								'hole' => array(
									array('file' => 'v4/widget/login_panel'),
									array('file' => 'v4/widget/side_cart'),
									array('file' => 'v4/widget/show_cart'),

									array('file' => 'v4/widget/add_cart_panel'), // 其它的在共用的
									array('file' => 'v4/widget/add_cart_panel'), // checkout/step1在用的，如果你不用，那就不要丟資料給它就沒事了~呵

									array('file' => 'v4/end/shop'), // 跟上面一樣
									array('file' => 'v4/end/shop'), // checkout/step1在用的
								),
							),
						),
					),
					// 產品搜尋
					array('file' => 'v4/widget/search_form'),
					
					array('file' => 'v4/widget/pageLoading'),
					array('file' => 'v4/widget/gotop'),

					// V4特有的浮起選單，選擇語系
					array('file' => 'v4/widget/language'),

					// 會員需知
					array('file' => 'v4/widget/privacy'),
					// 隱私權
					array('file' => 'v4/widget/term'),

					array('file' => 'v4/common/end'),
					array('file' => 'system/end'),
					array('file' => '$end_other'),
					array(
						'file' => 'system/holes',
						'params' => array(
							// (洞的數字，從零開始)_(功能名稱)
							// 例：1_constant => 後台/最大管理/常數設定 裡面的常數簡稱，假設backend_menu_merge
							// 例：1_exclude => 排除的view相對路徑，半型逗點分隔，假設v4/header/layout3,v4/header/layout7
							'1_exclude' => 'v4/header/layout3，v4/header/layout7',
						),
						'hole' => array(
							array('file' => 'v4/mb_panel2'), // 手機第2版
						),
					),
				),
			),
		),
	),
);

<?php

// 請參考w/winnie/RWDProject/ProjectC/Web/common/pagewidget.php
$group_struct = array(
	array(
		'hole' => array(
			// 一般 
			array('file' => 'v3/widget/page_loading'),
			array('file' => 'v3/widget/gotop'),		

			// ■  密碼鎖：可針對個別相簿執行密碼上鎖
			array('file' => 'v3/widget/login_panel_pwd'), // 跳出的密碼輸入

			// 參考用
			//$widgetName='sideAD'; include 'common_widget.php'; 
			//$widgetName='sideCart'; include 'common_widget.php'; 
			//$widgetName='showCart'; include 'common_widget.php'; 
			//$widgetName='addCartPanel'; include 'common_widget.php'; 

			// 購物
			// 2020-06-23 非購物的，記得這裡要註解掉
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
							array('file' => 'v3/widget/login_panel'),
							array('file' => 'v3/widget/side_cart'),
							array('file' => 'v3/widget/show_cart'),

							array('file' => 'v3/widget/add_cart_panel'), // 其它的在共用的
							array('file' => 'v3/widget/add_cart_panel'), // checkout/step1在用的，如果你不用，那就不要丟資料給它就沒事了~呵

							array('file' => 'v3/end/shop'),
							array('file' => 'v3/end/shop'),
						),
					),
				),
			),

			//array('file' => 'v3/widget/add_cart_panel_change'), // checkout/step1在用的，如果你不用，那就不要丟資料給它就沒事了~呵

			// 會員
			// blha...

			// 手機版選單
			// array('file' => 'widget/mb_panel'), // 手機第1版
			array('file' => 'v3/widget/mb_panel2'), // 手機第2版

			// 產品搜尋 (*如果你覺得網站慢，極有可能是我)
			array('file' => 'v3/widget/search_form'),

			// Google站內搜尋 (*如果你覺得網站慢，極有可能是我。如果單純的產品搜尋，會出現js的img錯誤，那也是因為我)
			// array('file' => 'v3/widget/google_search_form'),

			// GDPR
			// array('file' => 'v3/widget/gdpr'),
		),
	),
);

// //常數判斷是否要開啟搜尋widget by lota
// //己修正關閉後搜尋後，出現的bug 2017-11-14
// unset($_constant_1);
// eval('$_constant_1 = '.strtoupper('product_search').';');
// if($_constant_1==true){
// 	$group_struct[0]['hole'][] = array('file' => 'v3/widget/search_form');
// }

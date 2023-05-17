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
						'file' => 'sub_page_title',
						'hole' => array(
							array('file' => 'breadcrumb'),
						),
					),
					array(
						//'file' => 'product/layout1', // 選單右
						'file' => 'product/layout2', // 選單左
						//'file' => 'product/layout3', // 無選單
						'hole' => array(
							array('file' => 'default/promenu'),
							array('file' => 'system/empty'),
							array(
								'file' => 'product/layout_sub_3c', // layout1,2在用的
								//'file' => 'product/layout_sub_4c', // layout3專用
								//'file' => 'product/layout_sub_pic_left_txt_right', // 列表圖左文右，以及簡述
								'hole' => array(
									// array('file' => 'category_title2'), // 分項標題
									array('file' => 'company/type1_11'), // 分項內容
								),
							),
							array('file' => 'system/empty'), // 因為shop的banner，佔住了第四個洞
						),
					),
					array('file' => 'pagenav'),
				),
			),
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
	'product-submenu',
	'articlemulti-general',
	// 'product-general',
	// 'product-search', // 搜尋要在分項資料之下、分頁之上
	'share-pagenav',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

// SEO
// if($_SERVER['SCRIPT_NAME'] == '/product.php' && count($_GET) < 2){
// 	$this->data['seo_description'] = 'Welcome to Yu Mao used offset printing machine website. Yu Mao has decades of professional experience on treading used printing machine. In Taiwan we not only have own printing shop also provide variety brand of used offset printing machine. Such as Heidelberg, Komori, Roland, Mitsubishi, Akiyama, Hamada, Sakurai, etc. ';
// 	$this->data['seo_keywords'] = 'Used Digital printing machine,Used Offset Printing Machine,Secondhand Printing machine Japan ';
// 	$data['head_title'] = 'Used Digital printing machine,Secondhand Printing machine Japan,Used Offset Printing Machine , YU MAO PRINTING MACHINE';
// }

include 'layoutv3/render.php';

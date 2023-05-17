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
					array('file' => 'category_title2'), // 分項標題
					array('file' => 'company/articlesingle'),
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
	'articlesingle-general',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
//include 'layoutv3/print_struct.php';

// 分項標題，以及附屬文字或連結
// 請看這個連結的說明和文字 http://192.168.0.200/winnie/RWDProject/ProjectC/Web/article.php
// $data[$layoutv3_struct_map_keyname['category_title2'][0]] = array('name'=>'GGG','sub_name'=>'AAA','url'=>'#','text'=>'test');

// 跟主選單沒有關連的時候，就會需要特別設定這裡，這裡是麵包屑
// 這裡通常是編排頁、或是獨立頁才會比較有可能會使用到這裡
// $data[$layoutv3_struct_map_keyname['sub_page_title'][0]] = array("name"=>'GGG',"sub_name"=>'aaa');
// $data[$layoutv3_struct_map_keyname['breadcrumb'][0]] = array(array("name"=>"HOME","url"=>"/"),array("name"=>'GGG',"url"=>'#'),array("name"=>'AAA',"url"=>'#'));

include 'layoutv3/render.php';

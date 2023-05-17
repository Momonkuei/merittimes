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
						'file' => 'v3/checkout/layout1',
						'hole' => array(
							array(
								'hole' => array(
									array('file' => 'v3/checkout/step'),
									array('file' => 'v3/checkout/step1'),
									array('file' => 'v3/checkout/step2'),
									array(
										'file' => 'v3/checkout/step3',
										'hole' => array(
											array('file' => 'v3/checkout/orderdetail'),
										),
									),
									//array('file' => 'checkout/stepx'),
								),
							),
						),
					),
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
	'checkout-general',

	// 結尾的程式碼，通常都放這裡
	'share-end',
);

// include 'layoutv3/print_table.php';
include 'layoutv3/pre_render.php';
//include 'layoutv3/print_struct.php';

include 'layoutv3/render.php';

<?php

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
					array('file' => 'news/type2_1'),
				),
			),
		),
	),
);

// 挑選所需要的資料
$page_source = array(
	'share-core',
	'top_link_menu-v1',
	'webmenu-v1',
	'newsdetail-page_title',
	'newsdetail-breadcrumb',
	'newsdetail-general',
);

include 'layoutv3/pre_render.php';
//include 'layoutv3/print_struct.php';

include 'layoutv3/render.php';

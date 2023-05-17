<?php
// var_dump($_SERVER['SCRIPT_NAME']);

$layoutv3_parent_path = 'news/';

include '../layoutv3/init.php';

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
						'file' => 'sub_page_list',
						'hole' => array(
							array('file' => 'news/type1_1'),
							//array('file' => 'news/type1_2'),
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
	'top_link_menu-v1',
	'webmenu-v1',
	'news-page_title',
	'news-breadcrumb',
	'news-general',
	'news-pagenav',
);

include '../layoutv3/pre_render.php';
//include '../layoutv3/print_struct.php';

include '../layoutv3/render.php';

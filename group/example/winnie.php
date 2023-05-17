<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include 'layoutv3/init.php';

$page = array(
	array(
		// 'type' => 'section', // default key-value
		'file' => 'index',
		'hole' => array(
			//array('file' => '$group1'),
			array('file' => 'head'),
			array(
				//'type' => 'group', // 如果沒有指定file元素, 那就自動把型態設成group
				'hole' => array(

					array('file' => '$header1'),
					array(
						'file' => '$content1',
						//'hole' => array(
						//	array('file' => 'test'),
						//),
					),
					array('file' => '$footer1'),
				),
			),
		),
	),
);


// 挑選所需要的資料
$page_source = array(
	'webmenu-v1',
	'company-page_title',
	'company-breadcrumb',
	'company-general',
);

// 共用的程式，記得這類的東西要放在pre_render的上面，由其是有指定page_source的情況
include 'source/start.php';

include 'layoutv3/pre_render.php';
// include 'layoutv3/print_struct.php';

include 'layoutv3/render.php';

<?php

// 2020-01-11  A方案範本 (南聯百威) abinbev
$group_struct = array(
	array(
		'file' => 'index',
		'hole' => array(
			array(
				'hole' => array(
					array(
						'file' => 'system/head',
						'hole' => array(
							array(
								'hole' => array(
									array('file' => 'jane/head'), // css
								),
							),
						),
					),
					array('file' => 'system/google_analytics'),
				),
			),
			array(
				'hole' => array(
					array('file' => 'jane/header'),
					// array('file' => 'jane/banner'), // 預留
					// array('file' => 'jane/breadcrumb'), // 預留
					array('file' => '// HOLE'),
					array('file' => 'jane/footer'),
					array('file' => 'jane/end'),
					array('file' => 'system/end'),
					// array('file' => 'v3/widget/mb_panel2'), // 2018-11-29 通用手機版選單
				),
			),
		),
	),
);


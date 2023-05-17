<?php

$group_struct = array(
	array(
		'file' => 'v2/index',
		'hole' => array(
			array('file' => 'v2/head'),
			array(
				'hole' => array(
					array(
						'file' => 'v2/child/view_header_navmenu',
						'hole' => array(
							array('file' => 'v2/nav_menu'),
						),
					),
					array(
						'file' => 'v2/layout/header',
						'hole' => array(
							array('file' => 'v2/child/view_toplink'),
							array('file' => 'v2/child/view_toplink01'),
							array(
								'file' => 'v2/child/view_navmenu01',
								'hole' => array(
									array('file' => 'v2/nav_menu'),
								),
							),
						),
					),
					array(
						'file' => 'v2/layout/banner',
						'hole' => array(
							array('file' => 'v2/child/view_banner_01'),
						),
					),
					// 內頁在用的
					array('file' => 'v2/breadcrumb'),

					array('file' => '// HOLE'),

					// array('file' => 'v2/child/view_newfooter'),
					array('file' => '$footer1'),

					array('file' => 'end'),
					array('file' => '$end_other'),
				),
			),
		),
	),
);

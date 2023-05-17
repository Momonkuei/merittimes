<?php

// 2018-01-31 Starr A方案範本 (逢甲大學國際科技與管理學院 istm)
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
									array('file' => 'common/meta.config'), // favicon (記得要把其它不相關的、或是重覆的刪掉
									array('file' => 'common/head'), // css
								),
							),
						),
					),
					array('file' => 'system/google_analytics'),
				),
			),
			array('file' => 'common/mobileMenu'),
			array(
				'hole' => array(
					array('file' => 'common/header'),
					// array('file' => 'common/banner'), // 預留
					array('file' => 'common/breadcrumbs'),
				),
			),
			array(
				'hole' => array(
					array('file' => '// HOLE'),
				),
			),
			array('file' => 'common/footer'),
			array(
				'hole' => array(
					array('file' => 'system/end'),
					array('file' => 'common/end'),
					// array('file' => 'v3/widget/mb_panel2'), // 2018-11-29 通用手機版選單
				),
			),
		),
	),
);


<?php

// 2019-12-20 政佳 A方案範本 (普信科技 orchard)
// 記得各頁面的上面，可以先掛system/hole1的view，然後在掛$layout_main在它底下
// 這樣system/hole1，可以在參數的地方，使用include_0的方式，把source/core.php給載進來
// 就完全不需要LayoutV3的規則了
//
// 另外要記得，使用政佳的範本，後台建立頁面的時候，記得Theme要選擇"政佳(view)"
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
									//array('file' => 'common/meta.config'), // favicon (記得要把其它不相關的、或是重覆的刪掉
									array('file' => 'view/css'), // css
								),
							),
						),
					),
					array('file' => 'system/google_analytics'),
				),
			),
			array(
				'hole' => array(
					array('file' => 'view/header/header'),
					array('file' => 'view/banner/banner'),
					array('file' => 'view/breadcrumb'),
					array('file' => 'view/pageTitle'),
					array('file' => '// HOLE'),
					array('file' => 'view/footer/footer'),
					array('file' => 'view/widget/pageLoading'),
					array('file' => 'view/widget/gotop'),
					// array('file' => 'view/widget/chat'),
					array('file' => 'view/end'),
					array('file' => 'system/end'),
				),
			),
		),
	),
);


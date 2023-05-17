<?php

/*
 * 這個是預設的版型，同時也是範例的版型，會把註解都寫到這裡來，供B方案或是A方案所參考使用
 */

$group_struct = array(
	array(
		'file' => 'v3/index',
		'hole' => array(
			array('file' => '$head1'),
			array(
				'hole' => array(
					array('file' => 'system/empty_datasource/webmenu'),
					array('file' => '$header3'),
					array('file' => '// HOLE'),

					//array('file' => '$footer0'),
					array('file' => '$footer1'),
					//array('file' => '$footer2'),
					//array('file' => '$footer3'),
					//array('file' => '$footer4'),
					//array('file' => '$footer5'),
					//array('file' => '$footer6'),
					//array('file' => '$footer7'),
					array(
						'file' => 'v3/widget/layout',
						'hole' => array(
							array('file' => '$widget1'),
							//array('file' => '$widget_shop'), // 購物，用不到請關掉
						),
					),
					array('file' => 'v3/end'),
					array('file' => 'system/end'),
					array('file' => '$end_other'),

					// 購物，用不到請關掉
					//array('file' => 'v3/end/shop'),
					//array('file' => 'v3/end/shop'), 
				),
			),
		),
	),
);

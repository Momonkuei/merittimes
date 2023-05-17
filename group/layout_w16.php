<?php

$group_struct = array(
	array(
		'file' => 'v3/index',
		'hole' => array(
			array('file' => '$head1'),
			array(
				'hole' => array(
					array('file' => '$header4'),
					array('file' => '// HOLE'),
					array('file' => '$footer1'),
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
					//array('file' => 'end/shop'),
					//array('file' => 'end/shop'), 
				),
			),
		),
	),
);

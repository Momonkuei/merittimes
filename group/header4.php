<?php

$group_struct = array(
	array(
		'file' => 'v3/header/header4',
		'hole' => array(
			// 縮小會在下面顯示4個，關掉mbpanel2才看得到效果
			array(
				'file' => 'v3/header/top_link_menu2',
				'params' => array(
					'array_range_0' => '',
					'array_range_1' => '0',
					'array_range_2' => '3',
					'array_range_3' => 'ID',
				),
			),
			// 電腦版左邊 (顯示2個)
			array(
				'file' => 'v3/header/top_link_menu2',
				'params' => array(
					'array_range_0' => '',
					'array_range_1' => '0',
					'array_range_2' => '1', // 這裡要寫字串，尤其是零的時候
					'array_range_3' => 'ID',
				),
			), 
			array('file' => 'v3/header/brand_logo'),
			// 電腦版右邊 (顯示另外2個)
			array(
				'file' => 'v3/header/top_link_menu2',
				'params' => array(
					'array_range_0' => '',
					'array_range_1' => '2',
					'array_range_2' => '3',
					'array_range_3' => 'ID',
				),
			), 
			array('file' => 'v3/header/hamburger'),
			array('file' => 'v3/header/nav_menu2'),
			array('file' => 'v3/home/banner1'),
			array('file' => 'v3/header/nav_menu2'),
		),
	),
);

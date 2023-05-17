<?php

$group_struct = array(
	array(
		'file' => 'v3/header/header5',
		'hole' => array(
			//array('file' => 'header/top_link_menu2'), // 縮小 (疑似有問題，因為會有兩個google翻譯的id會跑出來)
			array('file' => 'system/empty'), // 縮小
			// 左邊二個
			array(
				'file' => 'v3/header/top_link_menu2',
				'params' => array(
					'array_range_0' => '',
					'array_range_1' => '0',
					'array_range_2' => '1',
					'array_range_3' => 'ID',
				),
			),
			array('file' => 'v3/header/brand_logo'),
			// 右邊二個
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
		),
	),
);

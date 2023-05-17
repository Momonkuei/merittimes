<?php

$group_struct = array(
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
);

<?php

$group_struct = array(
	array(
		'file' => 'cttdemo/ctt',
		// 'file' => 'index',
		'hole' => array(
			array('file' => 'cttdemo/head'),
			array(
				'hole' => array(
					array('file' => '$empty'), // 要放這個，這樣子，洞裡面放群組才會正常
					array('file' => '// HOLE'),
				)
			),
			array('file' => 'cttdemo/footer'),
		),
	),
);

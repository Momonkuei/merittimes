<?php

$group_struct = array(
	array(
		'file' => 'cttdemo/sub',
		'hole'=> array(
			// array('file' => 'ctt/webcall'),
			array(
				'hole' => array(
					array('file' => '$header_ctt'),
					array('file' => 'cttdemo/banner'),
				),
			),

			// 左側
			array(
				'hole' => array(
					array('file' => 'cttdemo/left/promenu'),
					array('file' => 'cttdemo/left/ad'),
				),
			),

			// 右側
			array(
				'hole' => array(
					array(
						'file' => 'cttdemo/sub_page_title',
						'hole' => array(
							array('file' => 'cttdemo/breadcrumb'),
						),
					),
					// array('file' => 'ctt/company/type'),
					array('file' => '// HOLE'),
				),
			),
		),
	),
);

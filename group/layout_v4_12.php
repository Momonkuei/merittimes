<?php

$group_struct = array(
	array(
		'hole' => array(
			array(
				'file' => '$page_v4',
				'hole' => array(
					array(
						'file' => 'v4/layout/container',
						'hole' => array(
							array(
								'hole' => array(
									array('file' => 'system/empty_datasource/sidemenu'),
									array('file' => 'v4/sub_page_title'), // pageTitleStyle
									array('file' => 'v4/category_title'), // blockTitle
									array(
										'file' => 'system/if0',
										'hole' => array(
											array('file' => '// HOLE'), // menu
										),
									),
									array('file' => '// HOLE'), // content
								),
							),
						),
					),
				),
			),
		),
	),
);

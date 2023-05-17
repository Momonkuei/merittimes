<?php

$group_struct = array(
	array(
		'file' => 'footer',
		'hole' => array(
			array('file' => 'footer/logo_footer'),
			array(
				'hole' => array(
					array('file' => 'footer/footer_info'),
					//array('file' => 'footer/sitemap_type1'),
					array('file' => 'footer/sitemap_type2'),
				),
			),
			array('file' => 'footer/company_info'),
			array('file' => 'footer/copyright_txt'),
			array('file' => 'footer/social_list'),
		),
	),
	array('file' => 'end'),
);

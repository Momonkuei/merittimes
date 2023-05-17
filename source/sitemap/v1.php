<?php

if(0){
	// 2019-01-30 A方案專用
	// $data[$layoutv3_struct_map_keyname['v3/sitemap'][0]] = $this->data['_webmenu_top'];

	$page_source_data_param1 = 'sitemap-general';
	$page_source_data_param2 = $this->data['_webmenu_top'];
	include _BASEPATH.'/../source/system/page_source_data.php';
} else {
	// B, C方案專用
	//$data[$layoutv3_struct_map_keyname['v3/sitemap'][0]] = $data[$layoutv3_struct_map_keyname['v3/header/nav_menu2'][0]];

	$tmps = array();
	$page_source_data_param1 = 'webmenu-v1';
	include _BASEPATH.'/../source/system/page_source_data.php';
	if(isset($page_source_data_return) and !empty($page_source_data_return)){
		$tmps = $page_source_data_return;

		$page_source_data_param1 = 'sitemap-general';
		$page_source_data_param2 = $tmps;
		include _BASEPATH.'/../source/system/page_source_data.php';
	}
}

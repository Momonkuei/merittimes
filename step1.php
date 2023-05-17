<?php

include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

if(!empty($_POST)){
	$post = $_POST;
	if(!isset($post['func'])) die;

	if($post['func'] == 'change'){
		var_dump($post);die;
	} // change
}
die;

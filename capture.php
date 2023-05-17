<?php

// 2018-09-13 試試看，加上一個可以處理不完全是ul li的結構的情況

include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

$ml_key = '';
$target = '';

if(isset($_GET['ml_key'])){
	$ml_key = $_GET['ml_key'];
}

if(isset($_GET['target'])){
	$target = $_GET['target'];
}

$file = _BASEPATH.'/../view/'.$target;
if($ml_key != '' and $target != '' and file_exists($file)){
	include $file;
}


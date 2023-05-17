<?php

/*
 * 2019-12-19
 * 打算廢棄這支檔案
 */

// SEO
// 在core.php裡面也有同樣的東西
// 2017-12-20
$main_ml_key = ''; // 主語系，如果有開啟SEO功能，而且有第二語系，那這個變數是必填
$url_prefix = '';
$url_suffix = '_'.$this->data['ml_key'].'.php';
if($main_ml_key != '' and $this->data['ml_key'] != $main_ml_key){
	$url_prefix = $this->data['ml_key'].'/';
	$url_suffix = '.php';
}

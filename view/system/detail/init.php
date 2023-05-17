<?php

/*
 * 2019-11-28
 * 目前這個東西，最基礎的有分為
 * 分項單筆
 * 分類單筆(只有公司簡介、多層文章在用)
 *
 * 然後以分項單筆做為最小單位，在延申出累加圖、和相簿多圖
 */


$_general_detail = true; // 讓view可以知道，這個功能啟用了，可以抓這裡的資料
$router_method = str_replace('detail','',$this->data['router_method']);
$rowg = array(); // 後台的前台主選單，該功能的資料
$row = array(); // 單筆暫存
$rows = array(); // 多筆暫存
$result = array(); // 堆疊出來的最後的結果資料
$result_tag = array(); // 第幾筆是單筆還是多筆
$rowg = $this->cidb->where('is_home',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$router_method.$url_suffix)->get('html')->row_array();

if($rowg){
	$common_articlesingle = $rowg['is_top']; // 單頁專用

	// https://redmine.buyersline.com.tw/issues/18231#note-44
	// 除單頁以外，其它的頁面，都要判斷有沒有帶編號
	if($common_articlesingle != '1' and (!isset($_GET['id']) or $_GET['id'] == '' or $_GET['id'] <= 0)){
		// echo '404';
		// header('HTTP/1.1 404 Not Found');
		header('Location: /404.php');
		die;
	}
	
}

?>

<?php

// 預設通用
$row = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('type',$router_method.'type')->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get('html')->row_array(); 
if($rowg){
	$common_is_category = $rowg['pic2']; // 是或不是分類
	$common_category = $rowg['is_news'];   // 是或不是通用分類

	if($common_is_category == 1){
		if($common_category == 1){ // 是通用分類
			// do nothing
		} else {
			$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get($router_method.'type')->row_array();
		}
	}
}

// 單筆
if($row and isset($row['id']) and $row['id'] > 0){
	// do nothing
} else {
	// echo '404';
	// header('HTTP/1.1 404 Not Found');
	header('Location: /404.php');
	die;
}

// 接row_field的前導程式碼
$admin_field_router_class = $router_method.'type';

?>

<?php

// 預設通用
if(isset($_GET['id']) and $_GET['id'] > 0){
	$row = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('type',$router_method)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get('html')->row_array(); 
}

if($rowg){
	$common_item = $rowg['class_ids'];   // 是或不是通用分項
	$common_articlesingle = $rowg['is_top']; // 單頁專用

	if($common_articlesingle == '1'){ // 單頁
		$row = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('type',$router_method)->where('ml_key',$this->data['ml_key'])->order_by('id','asc')->limit(1)->get('html')->row_array(); 
	} elseif($common_item == '1'){ // 是通用分項
		// do nothing
	} else {
		$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get($router_method)->row_array();
	}
}

if(isset($common_articlesingle) and $common_articlesingle == '1'){ // 單頁
	// do nothing
} else {
	if($row and isset($row['id']) and $row['id'] > 0){
		// do nothing
	} else {
		// echo '404';
		// header('HTTP/1.1 404 Not Found');
		header('Location: /404.php');
		die;
	}
}

?>

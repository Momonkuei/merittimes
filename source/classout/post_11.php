<?php
//分頁設定
$limit_count = 12;//單頁數量
$pagew = 1; // 頁數
if (isset($_GET['page']) and $_GET['page'] > 0) {
	$pagew = $_GET['page'];
}

//全部
$billboard_list_all=$this->cidb->where('class_id',$_SESSION['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->get('class_billboard')->result_array();
$total_rows = count($billboard_list_all);
////單頁
$billboard_list=$this->cidb->where('class_id',$_SESSION['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->get('class_billboard', $limit_count, ($pagew - 1) * $limit_count)->result_array();

$url = 'classout_'.$this->data['ml_key'].'_2.php?page=';

include _BASEPATH . '/../source/core/pagination.php';
//圖片路徑
$data_path='/_i/assets/upload/class/'.$school.($_SESSION['class_id']!=0?'/'.$_SESSION['class_id']:'');
?>
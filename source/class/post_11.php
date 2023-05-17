<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']==1){
	echo "<script>alert('代表窗口請至總覽頁面操作');window.location.href='/apply_".$this->data['ml_key']."_4.php';</script>";
}
//班級資料
$class_data=$this->cidb->where('id',$_SESSION['member_data']['class_id'])->get('writeplan_class')->row_array();


//分頁設定
$limit_count = 12;//單頁數量
$pagew = 1; // 頁數
if (isset($_GET['page']) and $_GET['page'] > 0) {
	$pagew = $_GET['page'];
}

//全部
$billboard_list_all=$this->cidb->where('class_id',$_SESSION['member_data']['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->get('class_billboard')->result_array();
$total_rows = count($billboard_list_all);

////單頁
$billboard_list=$this->cidb->where('class_id',$_SESSION['member_data']['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->get('class_billboard', $limit_count, ($pagew - 1) * $limit_count)->result_array();

$url = 'class_'.$this->data['ml_key'].'_11.php?page=';

include _BASEPATH . '/../source/core/pagination.php';
//路徑
$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
$data_path='/_i/assets/upload/class/'.$school.($_SESSION['member_data']['class_id']!=0?'/'.$_SESSION['member_data']['class_id']:'');
?>
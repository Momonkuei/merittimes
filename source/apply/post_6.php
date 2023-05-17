<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']!=1){
	echo "<script>alert('師生成員請至班級頁面操作');window.location.href='/class_".$this->data['ml_key']."_1.php';</script>";
}

if(!empty($_GET['accid'])){

}else{
	
}
//計畫資料
$writeplan_array=$this->cidb->where('member_id',$_SESSION['member_data']['id'])->where('is_enable',1)->order_by('create_time desc')->get('writeplan')->result_array();
//學期資料
$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->order_by('sort_id')->get('html')->result_array();
if(!empty($semester_array)){
	foreach($semester_array as $k => $v){
		$semester[$v['id']]=$v['topic'];
	}
}
$class_data=$this->cidb->where('is_enable',1)->order_by('create_time desc')->get('writeplan_class')->result_array();
if(!empty($class_data)){
	foreach($class_data as $k => $v){
		$class_data[$v['id']]=$v['class_name'];
	}
}
//班級資料
$class_semester_array=array();

foreach($writeplan_array as $k => $v){
	if($v['a_results']=='核可'){
		$writeplan_class=$this->cidb->like('writeplan_id',','.$v['id'].',')->like('other7',','.$v['semester'].',')->where('is_enable',1)->order_by('id desc')->get('writeplan_class')->result_array();
		if(!empty($writeplan_class)){
			foreach($writeplan_class as $kk => $vv){
				$class_semester_array[$v['semester']]=$semester[$v['semester']];
			}
		}
	}
}

//分頁設定
$limit_count = 15;//單頁數量
$pagew = 1; // 頁數
if (isset($_GET['page']) and $_GET['page'] > 0) {
	$pagew = $_GET['page'];
}
//帳號資料
//全部
$account_data=$this->cidb->where('class_id',$_SESSION['member_data']['id'])->where('member_grade!=1');
if(isset($_GET['search']) and $_GET['search'] != ''){
	$account_data=$account_data->like('name',$_GET['search']);
}
$account_data=$account_data->order_by('id')->get('customer')->result_array();
$total_rows = count($account_data);

//單頁

$account_data=$this->cidb->where('class_id',$_SESSION['member_data']['id'])->where('member_grade!=1');
if(isset($_GET['search']) and $_GET['search'] != ''){
	$account_data=$account_data->like('name',$_GET['search']);
	$url = 'apply_'.$this->data['ml_key'].'_6.php?search=' . $_GET['search'] . '&page=';
}else{
	$url = 'apply_'.$this->data['ml_key'].'_6.php?page=';
}
$account_data=$account_data->order_by('id')->get('customer', $limit_count, ($pagew - 1) * $limit_count)->result_array();



include _BASEPATH . '/../source/core/pagination.php';
if(!empty($account_data)){
	foreach($account_data as $k => $v){
		$account_data[$k]['other7']=explode(',',$v['other7']);
	}
}
?>


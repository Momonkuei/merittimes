<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']!=1){
	echo "<script>alert('師生成員請至班級頁面操作');window.location.href='/class_".$this->data['ml_key']."_1.php';</script>";
}
if(empty($_GET['writeplan_id'])){
	echo "<script>alert('查無申請中計畫!');window.location.href='/apply_".$this->data['ml_key']."_1.php';</script>";
}


//計畫資料
$writeplan_array=$this->cidb->where('id',$_GET['writeplan_id'])->get('writeplan')->row_array();
//學期資料-單筆
$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->where('id',$writeplan_array['semester'])->get('html')->row_array();
//學期資料-全部
$semester_array_all=$this->cidb->where('is_enable',1)->where('type','semester')->order_by('sort_id')->get('html')->result_array();
foreach($semester_array_all as $k => $v){
	$have_sem=$this->cidb->where('is_enable',1)->where('semester',$v['id'])->where('member_id',$_SESSION['member_data']['id'])->get('writeplan')->row_array();
	//沒有資料的學期移除
	if(empty($have_sem)){
		unset($semester_array_all[$k]);
	}
	//自己不能複製自己
	if($have_sem['id']==$_GET['writeplan_id']){
		unset($semester_array_all[$k]);
	}
}

//班級資料
$writeplan_class=$this->cidb->like('writeplan_id',','.$_GET['writeplan_id'].',')->where('is_enable',1)->order_by('create_time')->get('writeplan_class')->result_array();
//檔案上傳-資料夾判斷
$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
//檔案上傳-路徑
$data_path='/_i/assets/file/writeplan/'.$school.'/'.$_GET['writeplan_id'];

if($writeplan_array['a_results']!='核可'){
	$is_revise=true;
}else{
	$is_revise=false;
}
?>


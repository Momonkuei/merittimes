<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']!=1){
	echo "<script>alert('師生成員請至班級頁面操作');window.location.href='/class_".$this->data['ml_key']."_1.php';</script>";
}
if(empty($_GET['writeplan_id'])){
	echo "<script>alert('查無計畫!');window.location.href='/apply_".$this->data['ml_key']."_1.php';</script>";
}


//計畫資料
$writeplan_array=$this->cidb->where('id',$_GET['writeplan_id'])->get('writeplan')->row_array();
//學期資料-單筆
$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->where('id',$writeplan_array['semester'])->get('html')->row_array();
//學期資料-全部
$semester_arrays=$this->cidb->where('is_enable',1)->where('type','semester')->order_by('sort_id')->get('html')->result_array();
if(!empty($semester_arrays)){
	foreach($semester_arrays as $k => $v){
		$semesters[$v['id']]=$v['topic'];
	}
}

//計畫資料-全部
$writeplan_arrays=$this->cidb->where('member_id',$_SESSION['member_data']['id'])->where('is_enable',1)->order_by('create_time asc')->get('writeplan')->result_array();

//班級資料
$writeplan_class_array=array();
$a=0;
foreach($writeplan_arrays as $k => $v){
	if($v['a_results']=='核可'){
		if(isset($semesters[$v['semester']])){
			$writeplan_class_array[$v['semester']]=$semesters[$v['semester']];
		}
	}
}
//班級資料
$writeplan_class=$this->cidb->like('writeplan_id',$_GET['writeplan_id'])->where('is_enable',1)->order_by('create_time')->get('writeplan_class')->result_array();

?>


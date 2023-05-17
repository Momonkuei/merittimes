<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']==1){
	echo "<script>alert('代表窗口請至總覽頁面操作');window.location.href='/apply_".$this->data['ml_key']."_4.php';</script>";
}
//班級資料
$class_data=$this->cidb->where('id',$_SESSION['member_data']['class_id'])->get('writeplan_class')->row_array();

if(empty($_GET['bid'])){
	echo "<script>alert('連結錯誤!');window.location.href='/class_".$this->data['ml_key']."_5.php';</script>";
}
$data=$this->cidb->where('id',$_GET['bid'])->where('is_enable',1)->get('class_billboard')->row_array();
if(empty($data)){
	echo "<script>alert('該筆資料已被關閉');window.location.href='/class_".$this->data['ml_key']."_5.php';</script>";
}

//路徑
$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
$data_path='/_i/assets/upload/class/'.$school.($_SESSION['member_data']['class_id']!=0?'/'.$_SESSION['member_data']['class_id']:'');
?>
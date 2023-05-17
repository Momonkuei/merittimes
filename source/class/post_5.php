<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']==1){
	echo "<script>alert('代表窗口請至總覽頁面操作');window.location.href='/apply_".$this->data['ml_key']."_4.php';</script>";
}
//班級資料
$class_data=$this->cidb->where('id',$_SESSION['member_data']['class_id'])->get('writeplan_class')->row_array();
if($class_data['is_enable']!=1){
	echo "<script>alert('該班級已被關閉');window.location.href='/index_".$this->data['ml_key'].".php';</script>";
}
//公佈欄
$billboard_list=$this->cidb->where('class_id',$_SESSION['member_data']['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->limit('4')->get('class_billboard')->result_array();
//相片
$pic_list=$this->cidb->where('class_id',$_SESSION['member_data']['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->limit('6')->get('class_pic')->result_array();
//影音
$vido_list=$this->cidb->where('class_id',$_SESSION['member_data']['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->limit('3')->get('class_vido')->result_array();

//圖片路徑
$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
$data_path='/_i/assets/upload/class/'.$school.($_SESSION['member_data']['class_id']!=0?'/'.$_SESSION['member_data']['class_id']:'');
?>


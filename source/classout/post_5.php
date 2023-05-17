<?php
//公佈欄
$billboard_list=$this->cidb->where('class_id',$_SESSION['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->limit('4')->get('class_billboard')->result_array();
//相片
$pic_list=$this->cidb->where('class_id',$_SESSION['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->limit('6')->get('class_pic')->result_array();
//影音
$vido_list=$this->cidb->where('class_id',$_SESSION['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->limit('3')->get('class_vido')->result_array();

//圖片路徑
$data_path='/_i/assets/upload/class/'.$school.($_SESSION['class_id']!=0?'/'.$_SESSION['class_id']:'');
?>


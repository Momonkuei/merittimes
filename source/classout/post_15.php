<?php
if(empty($_GET['bid'])){
	echo "<script>alert('連結錯誤!');window.location.href='/classout_".$this->data['ml_key']."_1.php';</script>";
}
$data=$this->cidb->where('id',$_GET['bid'])->where('is_enable',1)->get('class_billboard')->row_array();
if(empty($data)){
	echo "<script>alert('該筆資料已被關閉');window.location.href='/classout_".$this->data['ml_key']."_1.php';</script>";
}
//圖片路徑
$data_path='/_i/assets/upload/class/'.$school.($_SESSION['class_id']!=0?'/'.$_SESSION['class_id']:'');
$billboard_list=$this->cidb->where('class_id',$_SESSION['class_id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->limit('4')->get('class_billboard')->result_array();
foreach($billboard_list as $k => $v){
	if($data['id']==$v['id']){
		$num=$k;
	}
}
if(isset($billboard_list[$num-1])){
	$last_data=$billboard_list[$num-1];
}	
//下一筆
if(isset($billboard_list[$num+1])){
	$newt_data=$billboard_list[$num+1];
}	

?>
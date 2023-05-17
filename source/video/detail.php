<?php


// 單筆
$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']),':id'=>$_GET['id']))->queryRow();
$tmp['content'] = $tmp['detail'];
$tmp['name'] = $tmp['topic'];
$tmp['youtube_code'] = $tmp['other1'];

$tmp['start_date'] = date('Y-m-d', strtotime($tmp['create_time']));

if($tmp['class_id']!=0){
	$tmp['return_url'] = str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php?id='.$tmp['class_id'];
}else{
	$tmp['return_url'] = str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php';
}

$data[$ID] = $tmp;

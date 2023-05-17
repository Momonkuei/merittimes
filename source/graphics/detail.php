<?php


// 單筆
$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']),':id'=>$_GET['id']))->queryRow();
$tmp['content'] = $tmp['detail'];
$tmp['name'] = $tmp['topic'];
$tmp['pic'] = G::imgt('_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$tmp['pic1']);

// $tmp['year'] = date('Y', strtotime($tmp['start_date']));
// $tmp['month'] = date('F', strtotime($tmp['start_date']));
// $tmp['day'] = date('d', strtotime($tmp['start_date']));

// 回列表的連結和按鈕名稱
//$tmp['url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix;
//$tmp['url_name'] = t('回列表');

// 1 有分類
// 2 沒分類
// unset($_constant);
// eval('$_constant = '.strtoupper(str_replace('detail','',$this->data['router_method']).'_show_type').';');
// if($_constant == 1){

// $row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php', ':ml_key'=>$this->data['ml_key']))->queryRow();
// if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
// 	if(isset($row['is_news']) and $row['is_news'] == 1){ // 是通用分類
// 
// 		$tmp2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']).'type',':id'=>$tmp['class_id']))->queryRow();
// 
// 		$tmp['sub_name'] = $tmp2['topic'];
// 		$tmp['sub_url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id='.$tmp['class_id'];
// 
// 		// A方案，最新消息含左側選單專用
// 		if(0){
// ?g>
// <script type="text/javascript">
// 	$('#navlight_<?php echo $tmp2['id']?g>').addClass('active');
// <g/script>
// <?php
// 		}
// 		$tmps = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id=:id',array(':id'=>$tmp2['id'],':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('start_date desc')->queryAll();
// 	} else { // 獨立分類
// 		// 有遇到在說
// 	}
// } else { // 無分類
// 	$tmps = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('start_date desc')->queryAll();
// }

// if($_constant == 1){
// } else {
// }

// // 按鈕的預設值，預設是沒有作用
// $tmp['url_prev'] = 'javascript:;';
// $tmp['url_prev_disabled'] = 'disabled';
// $tmp['url_next'] = 'javascript:;';
// $tmp['url_next_disabled'] = 'disabled';
// 
// if($tmps and count($tmps) == 1){
// 	// all use default
// } elseif($tmps and count($tmps) > 0){
// 	$point = 0;
// 	foreach($tmps as $k => $v){
// 		if($tmp['id'] == $v['id']){
// 			$point = $k;
// 			break;
// 		}
// 	}
// 	if(isset($tmps[$point - 1])){
// 		$tmp['url_prev'] = $url_prefix.str_replace('detail','',$this->data['router_method']).'detail'.$url_suffix.'?id='.$tmps[$point - 1]['id'];
// 		$tmp['url_prev_disabled'] = '';
// 	} else {
// 		// prev use default
// 	}
// 
// 	if(isset($tmps[$point + 1])){
// 		$tmp['url_next'] = $url_prefix.str_replace('detail','',$this->data['router_method']).'detail'.$url_suffix.'?id='.$tmps[$point + 1]['id'];
// 		$tmp['url_next_disabled'] = '';
// 	} else {
// 		// next use default
// 	}
// } else {
// 	// all use default
// }

$data[$ID] = $tmp;

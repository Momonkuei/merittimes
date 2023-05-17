<?php

$row['content'] = $row['detail'];
$row['name'] = $row['topic'];
$row['pic'] = G::imgt('_i/assets/upload/'.$router_method.'/'.$row['pic1']);

// $row['year'] = date('Y', strtotime($row['start_date']));
// //$row['month'] = date('F', strtotime($row['start_date'])); // January through December
// $row['month'] = date('M', strtotime($row['start_date'])); // 縮寫 Jan through Dec 2019-03-07 查理說要依照縮寫為預設
// $row['day'] = date('d', strtotime($row['start_date']));

$row['year'] = date('Y', strtotime($row['date1']));
//$row['month'] = date('F', strtotime($row['start_date'])); // January through December
$row['month'] = date('M', strtotime($row['date1'])); // 縮寫 Jan through Dec 2019-03-07 查理說要依照縮寫為預設
$row['day'] = date('d', strtotime($row['date1']));

// 回列表的連結和按鈕名稱
$row['url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix;

//判斷有無開啟分類功能 by lota 2019/3/22
$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php', ':ml_key'=>$this->data['ml_key']))->queryRow();

if($rowg){ 
	if(isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
		if($row['class_id'] > 0){
			$row['url'] .= '?id='.$row['class_id'];
		}
	}
}

$row['url_name'] = t('回列表');

// 1 有分類
// 2 沒分類
// unset($_constant);
// eval('$_constant = '.strtoupper(str_replace('detail','',$this->data['router_method']).'_show_type').';');
// if($_constant == 1){

$rowx = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php', ':ml_key'=>$this->data['ml_key']))->queryRow();
if($rowx and isset($rowx['pic2']) and $rowx['pic2'] == 1){ // 有分類
	if(isset($rowx['is_news']) and $rowx['is_news'] == 1){ // 是通用分類

		$tmp2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']).'type',':id'=>$row['class_id']))->queryRow();

		$row['sub_name'] = $tmp2['topic'];
		$row['sub_url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id='.$row['class_id'];

		// A方案，最新消息含左側選單專用 for V3
		if(0){
?>
<script type="text/javascript">
	$('#navlight_<?php echo $tmp2['id']?>').addClass('active');
</script>
<?php
		}
		//$tmps = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id=:id',array(':id'=>$tmp2['id'],':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('start_date desc, id')->queryAll();
		$tmps = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id=:id',array(':id'=>$tmp2['id'],':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('sort_id')->queryAll();
	} else { // 獨立分類
		// 有遇到在說 2018/5/23 by lota 遇到了
		$tmp2 = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'type')->where('is_enable=1 and id=:id',array(':id'=>$row['class_id']))->queryRow();

		$row['sub_name'] = $tmp2['name'];
		$row['sub_url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id='.$row['class_id'];

		$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id=:id',array(':id'=>$row['class_id'],':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('sort_id')->queryAll();
	}

	//右側 熱門訊息 for V4 2021-04-27 by lota
	if(defined('LAYOUTV3_THEME_NAME') && LAYOUTV3_THEME_NAME == 'v4'){
		$this->cidb->where('is_enable',1)->where('type',str_replace('detail','',$this->data['router_method']));
		if(isset($tmps['class_id'])){
			$this->cidb->where('class_id',$tmps['class_id']);
		}
		$row['right_list'] = $this->cidb->where('ml_key',$this->data['ml_key'])->where('type',str_replace('detail','',$this->data['router_method']))->where('id !=',$tmps['id'])->order_by('sort_id')->limit(10)->get('html')->result_array();	
	}

} else { // 無分類
	//$tmps = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('start_date desc')->queryAll();
	$tmps = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('sort_id')->queryAll();

	//右側 熱門訊息 for V4 2021-04-27 by lota
	if(defined('LAYOUTV3_THEME_NAME') && LAYOUTV3_THEME_NAME == 'v4'){
		
		$row['right_list'] = $this->cidb->where('ml_key',$this->data['ml_key'])->where('type',str_replace('detail','',$this->data['router_method']))->where('id !=',$tmps['id'])->limit(10)->order_by('date1','desc')->get('html')->result_array();//2021-08-11 無分類時用時間排序 by ming	
	}
}





// if($_constant == 1){
// } else {
// }

// 按鈕的預設值，預設是沒有作用
$row['url_prev'] = 'javascript:;';
$row['url_prev_disabled'] = 'disabled';
$row['url_next'] = 'javascript:;';
$row['url_next_disabled'] = 'disabled';

if($tmps and count($tmps) == 1){
	// all use default
} elseif($tmps and count($tmps) > 0){
	$point = 0;
	foreach($tmps as $k => $v){
		if($row['id'] == $v['id']){
			$point = $k;
			break;
		}
	}
	if(isset($tmps[$point - 1])){
		$row['url_prev'] = $url_prefix.str_replace('detail','',$this->data['router_method']).'detail'.$url_suffix.'?id='.$tmps[$point - 1]['id'];
		$row['url_prev_disabled'] = '';
	} else {
		// prev use default
	}

	if(isset($tmps[$point + 1])){
		$row['url_next'] = $url_prefix.str_replace('detail','',$this->data['router_method']).'detail'.$url_suffix.'?id='.$tmps[$point + 1]['id'];
		$row['url_next_disabled'] = '';
	} else {
		// next use default
	}
} else {
	// all use default
}

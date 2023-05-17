<?php

// 2019-06-27
// https://redmine.buyersline.com.tw/issues/18231?issue_count=107&issue_position=106&next_issue_id=17463&prev_issue_id=18525#note-43
// 內頁資料不存在的時候，直接顯示空白404
$row = $this->cidb->where('is_enable',1)->where('type',str_replace('detail','',$this->data['router_method']))->where('id',$_GET['id'])->get('html')->row_array();
if($row and isset($row['id']) and $row['id'] > 0){
	// do nothing
} else {
	echo '404';
	header('HTTP/1.1 404 Not Found');
	die;
}

// 單筆
$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']),':id'=>$_GET['id']))->queryRow();
$tmp['content'] = $tmp['detail'];
$tmp['name'] = $tmp['topic'];
if($row['pic1']!=''){
	$tmp['pic'] = G::imgt('_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$tmp['pic1']);
}else{
	$tmp['pic'] = '';
}

// $tmp['year'] = date('Y', strtotime($tmp['start_date']));
// //$tmp['month'] = date('F', strtotime($tmp['start_date'])); // January through December
// $tmp['month'] = date('M', strtotime($tmp['start_date'])); // 縮寫 Jan through Dec 2019-03-07 查理說要依照縮寫為預設
// $tmp['day'] = date('d', strtotime($tmp['start_date']));

// #37471   #46853  增加若未設定日期 則以最新更新日期為主
$tmp['year'] = ($tmp['date1']!='0000-00-00'?date('Y', strtotime($tmp['date1'])):date('Y', strtotime($tmp['update_time'])));
//$tmp['month'] = date('F', strtotime($tmp['start_date'])); // January through December
$tmp['month'] = ($tmp['date1']!='0000-00-00'?date('m', strtotime($tmp['date1'])):date('m', strtotime($tmp['update_time']))); // 縮寫 Jan through Dec 2019-03-07 查理說要依照縮寫為預設
$tmp['day'] = ($tmp['date1']!='0000-00-00'?date('d', strtotime($tmp['date1'])):date('d', strtotime($tmp['update_time'])));

// 回列表的連結和按鈕名稱
$tmp['url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix;

//判斷有無開啟分類功能 by lota 2019/3/22
$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php', ':ml_key'=>$this->data['ml_key']))->queryRow();

if($rowg){ 
	if(isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
		if($tmp['class_id'] > 0){
			$tmp['url'] .= '?id='.$tmp['class_id'];
		}
	}
}

$tmp['url_name'] = t('回列表');


//SEO 2021-11-23 //這邊的SEO變化在 core.php已經處理
// unset($_constant);
// eval('$_constant = '.strtoupper('seo_open').';');
// if($_constant){
// 	$data['head_title'] = $tmp['name'] . ' | '.$this->data['sys_configs']['admin_title_'.$this->data['ml_key']]; //2021-12-01 ming說要加上網站名稱
// 	$this->data['seo_description'] = strip_tags($tmp['detail']);
// }

// 1 有分類
// 2 沒分類
// unset($_constant);
// eval('$_constant = '.strtoupper(str_replace('detail','',$this->data['router_method']).'_show_type').';');
// if($_constant == 1){

$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php', ':ml_key'=>$this->data['ml_key']))->queryRow();
if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
	if(isset($row['is_news']) and $row['is_news'] == 1){ // 是通用分類

		$tmp2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']).'type',':id'=>$tmp['class_id']))->queryRow();

		$tmp['sub_name'] = $tmp2['topic'];
		$tmp['sub_url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id='.$tmp['class_id'];

		// A方案，最新消息含左側選單專用
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
		$tmp2 = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'type')->where('is_enable=1 and id=:id',array(':id'=>$tmp['class_id']))->queryRow();

		$tmp['sub_name'] = $tmp2['name'];
		$tmp['sub_url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id='.$tmp['class_id'];

		$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id=:id',array(':id'=>$tmp['class_id'],':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('sort_id')->queryAll();
	}

	//右側 熱門訊息 for V4 2021-04-27 by lota
	if(defined('LAYOUTV3_THEME_NAME') && LAYOUTV3_THEME_NAME == 'v4'){
		$this->cidb->where('is_enable',1)->where('type',str_replace('detail','',$this->data['router_method']));
		if(isset($tmp['class_id'])){
			$this->cidb->where('class_id',$tmp['class_id']);
		}
		$tmp['right_list'] = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type',str_replace('detail','',$this->data['router_method']))->where('id !=',$tmp['id'])->order_by('sort_id')->limit(10)->get('html')->result_array();	
	}
} else { // 無分類
	//$tmps = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('start_date desc')->queryAll();
	$tmps = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->order('sort_id')->queryAll();

	//右側 熱門訊息 for V4 2021-04-27 by lota
	if(defined('LAYOUTV3_THEME_NAME') && LAYOUTV3_THEME_NAME == 'v4'){
		
		$tmp['right_list'] = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type',str_replace('detail','',$this->data['router_method']))->where('id !=',$tmp['id'])->order_by('sort_id')->limit(10)->get('html')->result_array();	
	}
	
}



// if($_constant == 1){
// } else {
// }

// 按鈕的預設值，預設是沒有作用
$tmp['url_prev'] = 'javascript:;';
$tmp['url_prev_disabled'] = 'disabled';
$tmp['url_next'] = 'javascript:;';
$tmp['url_next_disabled'] = 'disabled';

if($tmps and count($tmps) == 1){
	// all use default
} elseif($tmps and count($tmps) > 0){
	$point = 0;
	foreach($tmps as $k => $v){
		if($tmp['id'] == $v['id']){
			$point = $k;
			break;
		}
	}
	if(isset($tmps[$point - 1])){
		$tmp['url_prev'] = $url_prefix.str_replace('detail','',$this->data['router_method']).'detail'.$url_suffix.'?id='.$tmps[$point - 1]['id'];
		$tmp['url_prev_disabled'] = '';
	} else {
		// prev use default
	}

	if(isset($tmps[$point + 1])){
		$tmp['url_next'] = $url_prefix.str_replace('detail','',$this->data['router_method']).'detail'.$url_suffix.'?id='.$tmps[$point + 1]['id'];
		$tmp['url_next_disabled'] = '';
	} else {
		// next use default
	}
} else {
	// all use default
}

$num_type=substr($this->data['router_method'],4,1);
$left_pict=$this->cidb->where('type','news'.$num_type.'other1')->where('is_enable',1)->where('class_id',$_GET['id'])->order_by('sort_id')->get('html')->result_array();
$right_pict=$this->cidb->where('type','news'.$num_type.'other2')->where('is_enable',1)->where('class_id',$_GET['id'])->order_by('sort_id')->get('html')->result_array();
$multi_pic=$this->cidb->where('type','news'.$num_type.'other3')->where('is_enable',1)->where('class_id',$_GET['id'])->order_by('sort_id')->get('html')->result_array();
if(!empty($tmp['other9'])){$tmp['other9_pic']=explode('?',$tmp['other9']);$tmp['other9_pic']=str_replace('v=','',$tmp['other9_pic'][1]);}
if(!empty($tmp['other10'])){$tmp['other10_pic']=explode('?',$tmp['other10']);$tmp['other10_pic']=str_replace('v=','',$tmp['other10_pic'][1]);}

$data[$ID] = $tmp;

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

if($DATA_SINGLE == true and $DATA_MULTI == false){
	// 單筆
	if(!isset($_GET['id'])){
		$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>$this->data['router_method'],':ml_key'=>$this->data['ml_key']))->queryRow();
	} else {
		$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and id=:id',array(':type'=>$this->data['router_method'],':ml_key'=>$this->data['ml_key'],':id'=>intval($_GET['id'])))->queryRow();
	}
	if($tmp){
		$tmp['content'] = $tmp['detail'];
		$tmp['name'] = $tmp['topic'];
		$tmp['sub_name'] = '';
		$tmp['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$tmp['pic1'];
	} else {
		$tmp = array(
			'content' => '',
			'name' => '',
			'sub_name' => '',
			'pic' => '',
		);
	}
	$data[$ID] = $tmp;

} elseif($DATA_SINGLE == false and $DATA_MULTI == true){
	// 其它多筆
	$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>$this->data['router_method'],':ml_key'=>$this->data['ml_key']))->limit(3)->queryAll();

	// type2_1區塊專用的多筆
	//$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type',array(':type'=>$this->data['router_method']))->order('create_time desc')->queryAll();

	if($tmps and count($tmps) > 0){
		foreach($tmps as $k => $v){
			$tmps[$k]['name'] = $v['topic'];
			$tmps[$k]['sub_name'] = '';
			$tmps[$k]['content'] = $v['detail'];
			$tmps[$k]['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
			//$tmps[$k]['year'] = date('Y', strtotime($v['start_date']));
			//$tmps[$k]['month'] = date('m', strtotime($v['start_date']));
			$tmps[$k]['year'] = date('Y', strtotime($v['create_time']));
			$tmps[$k]['month'] = date('m', strtotime($v['create_time']));
		}
	}
	$data[$ID] = $tmps;
} elseif($DATA_SINGLE == true and $DATA_MULTI == true){

	// type1_7 區塊
	// if(count($DATA_SINGLE_MULTI) == 2 and $DATA_SINGLE_MULTI[0] == 'DATA_SINGLE' and $DATA_SINGLE_MULTI[1] == 'DATA_MULTI'){

	$layoutv3_condition = 'multi|single';
	include 'layoutv3/multi_source_check.php';
	if($layoutv3_condition === true){

		$data[$ID.'_0'] = array(
			'name' => '關於我們',
			'sub_name' => 'ABOUT',
		);
		// 多筆
		$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>$this->data['router_method'],':ml_key'=>$this->data['ml_key']))->limit(4)->queryAll();
		if($tmps and count($tmps) > 0){
			foreach($tmps as $k => $v){
				$tmps[$k]['name'] = $v['topic'];
				$tmps[$k]['sub_name'] = '';
				$tmps[$k]['content'] = $v['detail'];
				$tmps[$k]['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
			}
		}
		$data[$ID.'_1'] = $tmps;
	}

}

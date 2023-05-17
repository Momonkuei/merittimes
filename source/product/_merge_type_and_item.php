<?php

/*
 * 2017-12-08
 * 這個檔案其實是要給V1第二版所使用的
 *
 * 讓獨立分類、和獨立資料表能夠合併，然後建立成無限層級
 * 適合使用本功能的，是那種大分類一層、然後就接產品的那一類型
 */
$rows_type = $this->cidb->where(array('is_enable'=>1,'ml_key'=>$this->data['ml_key']))->order_by('sort_id')->get($this->data['router_method'].'type')->result_array();
if($rows_type){
	foreach($rows_type as $k => $v){
		$v['url_'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$v['id'];
		$rows_type[$k] = $v;
	}
}

$rows_item = $this->cidb->select('*, class_id as pid')->where(array('is_enable'=>1,'ml_key'=>$this->data['ml_key'],'class_id >'=>0))->order_by('sort_id')->get($this->data['router_method'])->result_array();
if($rows_item){
	foreach($rows_item as $k => $v){
		// 因為等一下要和分類合併，所以這裡修改一下它的編號
		$v['_id'] = $v['id'];
		$v['id'] = 94879487 + $v['id'];

		$v['url_'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['_id'];
		$rows_type[] = $v;
	}
}

$data[$ID] = $rows_type;

// var_dump($rows_type);die;

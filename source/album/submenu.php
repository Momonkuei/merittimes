<?php

// SEO
$rows = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>'albumtype'))->queryAll();
$rows_tmp = array();
if($rows){
	foreach($rows as $k => $v){
		$rows_tmp[$v['seo_item_id']] = $v;
	}
}

$tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'multitype')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if($tmps){
	foreach($tmps as $k => $v){
		if(isset($rows_tmp[$v['id']]) and $rows_tmp[$v['id']]['seo_script_name'] != ''){
			// SEO
			$v['url'] = $rows_tmp[$v['id']]['seo_script_name'].'.html';
		} else {
			$v['url'] = str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php?id='.$v['id'];
		}

		$v['parent_id'] = $v['pid'];
		$tmps[$k] = $v;
	}
}

$data[$ID] = $tmps;

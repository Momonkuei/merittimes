<?php

/*
 * 相關商品
 */

$tmps = array();
if(isset($_GET['id'])){
	// 先找該產品的資料
	$tmp = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and id=:id',array(':id'=>$_GET['id']))->queryRow();

	// 規則1：顯示所處分類底下的產品，排除自己
	$tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and id!='.$_GET['id'].' and class_id=:id',array(':id'=>$tmp['class_id']))->order('sort_id')->queryAll();
	// $tmps = $this->cidb->where('is_enable',1)->where('id!=',$_GET['id'])->where('class_id',$tmp['class_id'])->order_by('sort_id')->limit(8)->get('product')->result_array();
	if($tmps){
		foreach($tmps as $k => $v){
			// 為了要符合前台版型的規範
			$tmps[$k]['url1'] = $tmps[$k]['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$v['id'];
			$tmps[$k]['pic'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$v['pic1'];
		}
	}

	// 規則2：勾選 2017-12-26
	// $tmps2 = explode(',', $tmp['related_ids']);
	// if($tmps2 and count($tmps2) > 0){
	// 	foreach($tmps2 as $k => $v){
	// 		if($v == ''){
	// 			unset($tmps2[$k]);
	// 		}
	// 	}
	// }
	// if(count($tmps2) > 0){
	// 	$tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and id IN('.implode(',', $tmps2).') ')->queryAll();
	// 	if($tmps){
	// 		foreach($tmps as $k => $v){
	// 			// 為了要符合前台版型的規範
	// 			$tmps[$k]['url1'] = $tmps[$k]['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$v['id'];
	// 			$tmps[$k]['pic'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$v['pic1'];
	// 		}
	// 	}
	// }
}
$data[$ID] = $tmps;

// 相關商品(很舊的，不要打開)
// $tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and class_id=:id',array(':id'=>$tmp['class_id']))->order('sort_id')->limit(4)->queryAll();
// if($tmps){
// 	foreach($tmps as $k => $v){
// 		// 為了要符合前台版型的規範
// 		$tmps[$k]['url1'] = $tmps[$k]['url2'] = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$v['id'];
// 		$tmps[$k]['pic'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$v['pic1'];
// 	}
// }
// $data[$ID] = $tmps;

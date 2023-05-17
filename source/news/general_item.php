<?php

// $tmps = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>$this->data['router_method'].'type',':ml_key'=>$this->data['ml_key']))->queryAll();
$tmps_tmp = array();
if($tmps){
	foreach($tmps as $k => $v){
		// $tmps_tmp[$v['id']] = $v['name'];
		// $tmps_tmp[$v['id']] = $v['topic']; //2021-04-13 改用下面的 by lota
		$tmps_tmp[$v['id']]['name'] = $v['topic'];
		$tmps_tmp[$v['id']]['detail'] = $v['detail'];
	}
}

$admin_field_router_class = $this->data['router_method'];
$admin_field_section_id = 1;
include _BASEPATH.'/../source/system/admin_field_get.php';

// 簡述  by lota 2021-04-13
if(isset($_GET['id'])){
	if(isset($tmps_tmp[$_GET['id']]['detail']) && $tmps_tmp[$_GET['id']]['detail']!=''){
		$data[$this->data['router_method'].'_describe'] = nl2br($tmps_tmp[$_GET['id']]['detail']);
	}
}

if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		// 2019-12-04 移到上層
		// $v['__serial_number1'] = $k+1;
		// $v['__serial_number2'] = str_pad(($k+1),2,'0',STR_PAD_LEFT);
		// $v['name'] = $v['topic'];
		// $v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
		//
		// 為了A方案而修正的
		// $v['pic'] = '';
		// if($v['pic1'] != ''){
		// 	$v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
		// }

		$v['url1'] = $v['url2'] = $v['url'];

		// 分類名稱
		$v['name2'] = '';
		if(isset($tmps_tmp[$v['class_id']])){
			$v['name2'] = $tmps_tmp[$v['class_id']]['name'];
		}

		// $v['content'] = nl2br($v['field_tmp']); // ckeditor_js 預設編輯器輸出

		$v['content'] = $v['field_tmp'];
		if(isset($admin_field['field_tmp']) and isset($admin_field['field_tmp']['type'])){
			if($admin_field['field_tmp']['type'] == 'textarea'){
				$v['content'] = nl2br($v['field_tmp']); // ckeditor_js 預設編輯器輸出
			}
		}

		// 2019-12-23
		// $v['year'] = $v['start_date___year'];
		// $v['month'] = $v['start_date___month'];
		// $v['day'] = $v['start_date___day'];

		// 2020-10-08 Ming說經理說，最新消息回到托拉排序
		// #37471 #46853  增加若未設定日期 則以最新更新日期為主
		$v['year'] = (!empty($v['date1___year'])?$v['date1___year']:$v['update_time___year']);
		$v['month'] =(!empty($v['date1___month'])?$v['date1___month']:$v['update_time___month']); //月份為英文縮寫 2021-07-19 ming說改回月份縮寫
		// $v['month'] = $v['date1___MONTH'];   //2021-04-27 ming說改為預設月份為數字
		$v['day'] = (!empty($v['date1___day'])?$v['date1___day']:$v['update_time___day']);

		// 移到上層
		// $v['year'] = date('Y', strtotime($v['start_date']));
		// //$v['month'] = date('F', strtotime($v['start_date'])); // January through December
		// $v['month'] = date('M', strtotime($v['start_date'])); // 縮寫 Jan through Dec 2019-03-07 查理說要依照縮寫為預設
		// $v['day'] = date('d', strtotime($v['start_date']));
		// $v['MONTH'] = date('m', strtotime($v['start_date']));
		$v['MONTH'] = date('m', strtotime($v['date1']));

		$rows[$k] = $v;
	}
}

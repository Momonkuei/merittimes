<?php

$admin_field_router_class = $this->data['router_method'];
$admin_field_section_id = 1;
include _BASEPATH.'/../source/system/admin_field_get.php';

if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
		$v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
		$v['name'] = $v['topic'];

		// $v['content'] = nl2br($v['field_tmp']); // ckeditor_js 預設編輯器輸出

		$v['content'] = $v['field_tmp'];
		if(isset($admin_field['field_tmp']) and isset($admin_field['field_tmp']['type'])){
			if($admin_field['field_tmp']['type'] == 'textarea'){
				$v['content'] = nl2br($v['field_tmp']); // ckeditor_js 預設編輯器輸出
			}
		}

		$v['year'] = date('Y', strtotime($v['start_date']));
		$v['month'] = date('F', strtotime($v['start_date']));
		$v['day'] = date('d', strtotime($v['start_date']));
		$rows[$k] = $v;
	}
}

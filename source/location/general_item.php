<?php

$admin_field_router_class = $this->data['router_method'];
$admin_field_section_id = 1;
include 'source/system/admin_field_get.php';

if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		// 移到上層
		// $v['name'] = $v['topic'];

		$v['address_url'] = $v['detail'];
		$v['address'] = $v['url1'].'<i class="fa fa-map-marker"></i>';
		$v['phone'] = $v['other1'];
		$v['fax'] = $v['other2'];
		$v['email_url'] = 'mailto:'.$v['other3'];
		$v['email'] = $v['other3'];
		$v['website_url'] = '';
		$v['website'] = '';

		// $v['pic_big'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];

		if(isset($admin_field['pic1']['other']['width'])){
			if($admin_field['pic1']['other']['width'] == '40'){
				$v['pic_small'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
			} elseif($admin_field['pic1']['other']['width'] == '800'){
				$v['pic_big'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
			}
		}

		$rows[$k] = $v;
	}
}

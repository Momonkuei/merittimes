<?php

if(isset($layoutv3_struct_map_keyname['v3/sub_page_title'][0])){
	$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]] = array(
		'name' => t('會員登入'),
		'sub_name' => 'user login',
	);
}

if(isset($layoutv3_struct_map_keyname['v3/breadcrumb'][0])){
	$data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]] = array(
		array('name' => 'HOME', 'url' => '/'),
		array('name' => t('會員登入'), 'url' => 'guestlogin_'.$this->data['ml_key'].'.php'),
	);
}

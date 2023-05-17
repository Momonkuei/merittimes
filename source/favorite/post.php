<?php

$prefix = $this->data['router_method'];

//if(!empty($_REQUEST)){
	//$post = $_REQUEST;
if(!empty($_GET)){
	$post = $_GET;
	if(isset($post['id']) and $post['id'] != ''){
		if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
			//$ids2 = explode('_', $post['id']);
			$del = array(
				'type' => 'favorite',
				'is_enable' => '1',
				'ml_key' => $this->data['ml_key'],
				'member_id' => $this->data['admin_id'],
				//'other1' => $ids2[0],
				'other1' => $post['id'],
				//'other2' => '',
			);
			//if($ids2[1] == '0'){
			//	// do nothing
			//} else {
			//	$del['other2'] = $ids2[1]; // specid
			//}
			$this->cidb->delete('html', $del); 
		} else {
			unset($_SESSION['save']['shop_favorite'][$post['id']]);
		}
		$redirect_url = $url_prefix.$this->data['router_method'].$url_suffix;
		header('Location: '.$redirect_url);
		die;
	}
	die;
}

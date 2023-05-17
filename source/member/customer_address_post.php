<?php

//if(!isset($this->data['admin_id']) or count($this->data['admin_id']) <= 0){
if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
	// do nothing
} else {
	$redirect_url = 'index_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('請先登入！'), $redirect_url, $this->data);
	die;
}

if(!empty($_POST)){
	if(!isset($this->data['admin_id']) or $this->data['admin_id'] <= 0) die;

	$post = $_POST;

	if(isset($post['func'])){
		if($post['func'] == 'add'){
			$save = array(
				'name' => $post['name'],
				'gender' => $post['gender'],
				'phone' => $post['phone'],
				'mobile' => $post['mobile'],
				'addr_county' => $post['addr_county'],
				'addr_district' => $post['addr_district'],
				'addr_zipcode' => $post['addr_zipcode'],
				'addr' => $post['addr'],
				'customer_id' => $this->data['admin_id'],
				'is_enable' => 1,
				'create_time' => date('Y-m-d H:i:s'),
			);
			$this->cidb->insert('customer_address', $save); 
			// $id = $this->cidb->insert_id();

			$url = 'membercenter_'.$this->data['ml_key'].'.php';
			G::alert_and_redirect(t('新增地址簿成功'), $url, $this->data);
			die;
		} elseif($post['func'] == 'edit'){
			$update = $post;
			$id = $update['id'];

			$update['update_time'] = date('Y-m-d H:i:s');

			unset($update['id']);
			unset($update['func']);

			$this->cidb->where('id', $id);
			$this->cidb->update('customer_address', $update); 

			$url = 'membercenter_'.$this->data['ml_key'].'.php';
			G::alert_and_redirect(t('修改地址簿成功'), $url, $this->data);
			die;
		}
	}

	$url = 'membercenter_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('系統異常'), $url, $this->data);

	die;
}

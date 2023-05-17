<?php

if(!isset($this->data['admin_id']) or $this->data['admin_id'] <= 0){
	$redirect_url = 'index_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('請先登入！'), $redirect_url, $this->data);
	die;
}

if(!empty($_POST)){
	$post = $_POST;

	if(
		!isset($post['old_pass'])
		or $post['old_pass'] == ''
		or !isset($post['new_pass'])
		or $post['new_pass'] == ''
		or !isset($post['new_pass2'])
		or $post['new_pass2'] == ''
		or $post['new_pass'] != $post['new_pass2']
	){
		$url = 'memberchangepassword_'.$this->data['ml_key'].'.php';
		G::alert_and_redirect(t('修改失敗！'), $url, $this->data);
		die;
	}

	$old_pass = $post['old_pass'];

	unset($_constant);
	eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
	if($_constant == '0'){
		// do nothing
	} elseif($_constant == '1'){
		$old_pass = sha1($old_pass);
	} elseif($_constant == '2'){
		// 先找出salt
		$row2 = $this->db->createCommand()->select('salt')->from('customer')
		->where('id=:id AND is_enable=1', array(':id'=>$this->data['admin_id']))
		->queryRow();

		if(!$row2){
			$url = 'memberchangepassword_'.$this->data['ml_key'].'.php';
			G::alert_and_redirect(t('修改失敗！'), $url, $this->data);
			die;
		}

		$old_pass = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($old_pass.$row2['salt'])));
	}

	// 找一下有沒有存在的帳號在資料庫裡面
	$row = $this->db->createCommand()->from('customer')
	->where('id=:id AND login_password=:password AND is_enable=1', array(':id' => $this->data['admin_id'], ':password' => $old_pass))
	->queryRow();

	if($row and isset($row['id']) and $row['id'] > 0){
		$update = array();
		$update['login_password'] = $post['new_pass'];

		unset($_constant);
		eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
		if($_constant == '0'){
			$update['salt'] = '';
		} elseif($_constant == '1'){
			$update['salt'] = '';
			$update['login_password'] = sha1($update['login_password']);
		} elseif($_constant == '2'){
			$update['salt'] = G::GeraHash(10);
			$update['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($update['login_password'].$update['salt'])));
		}

		$this->cidb->where('id', $this->data['admin_id']);
		$this->cidb->update('customer', $update); 
	} else {
		$url = 'memberchangepassword_'.$this->data['ml_key'].'.php';
		G::alert_and_redirect(t('修改失敗！'), $url, $this->data);
		die;
	}

	$web_ml_key = $_SESSION['web_ml_key'];

	//http://stackoverflow.com/questions/20965023/sessions-in-yii
	Yii::app()->session->clear();
	Yii::app()->session->destroy();
	Yii::app()->session->open();

	$_SESSION['web_ml_key'] = $web_ml_key;
	
	$url = 'index_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('修改成功！請重新登入'), $url, $this->data);
	die;
}


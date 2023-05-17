<?php

class ProfileController extends Controller {

	protected $def = array(
		'table' => 'member',
		'title' => '修改密碼',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'member',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('login_account, email, login_password', 'required'),
				array('email', 'email'),
			),
		),
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate'
			),
			'smarty_javascript' => '',
			'smarty_javascript_text' => '',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
					'method' => 'post',
					'action' => '',
				),
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'old_login_password' => array(
							'label' => '舊密碼',
							'type' => 'pass',
							'attr' => array(
								'id' => 'old_login_password',
								'name' => 'old_login_password',
								'size' => '30',
							),
						),
						'login_password' => array(
							'label' => '新密碼',
							'type' => 'pass',
							'attr' => array(
								'id' => 'login_password',
								'name' => 'login_password',
								'size' => '30',
							),
						),
						'login_password_confirm' => array(
							'label' => '新密碼確認',
							'type' => 'pass',
							'attr' => array(
								'id' => 'login_password_confirm',
								'name' => 'login_password_confirm',
								'size' => '30',
							),
						),
					),
				),
			),
		),
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// (為了能夠擴展加密方式)
		// 沒有define：sha1
		// 1：從缺
		// 2：sha1 + salt
		// $this->data['gggaaa_crypt_type'] = 2;

		return true;
	}

	//public function actionIndex($status = '')
	public function actionIndex($param = '')
	{
		//$param = '';
		if(empty($_POST)){
			$parameter = new Parameter_handle;
			$params = $parameter->get($param);
			$param_define = $parameter->getDefine();

			$this->data['def'] = G::definit($this->def, $this->data);
			$this->data['params'] = $params;
			$this->data['parameter'] = $param_define;

			if(isset($params['value'][0]) and $params['value'][0] == 'a'){
				$this->data['def']['updatefield']['smarty_javascript_text'] = <<<XXX
alert('修改密碼失敗');
XXX;
			}

			if(isset($params['value'][0]) and $params['value'][0] == 'b'){
				$this->data['def']['updatefield']['smarty_javascript_text'] = <<<XXX
alert('修改 密碼失敗');
XXX;
			}

			//$User = new Admin_user_orm();
			//$User->where('id', $this->data['admin_id'])->get();

			$rows = $this->db->createCommand()->from($this->data['def']['table'])->where('is_enable=1 and id='.$this->data['admin_id'])->queryAll();

			$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

			if(count($lll) > 0){
				$query = $this->cidb->where('user_id', $this->data['admin_id'])->get('admin_user_perm');
				$perm_all = array();
				foreach($query->result() as $row){
					$perm_all[$row->resource] = $row->value;
				}
			}else{
				$perm_all = array();
			}

			$updatecontent = array();
			//if($User->result_count() > 0){
			if($rows and count($rows) > 0){
				$updatecontent = $rows[0];
				unset($updatecontent['login_password']);
			}

			$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules']);
			//var_dump($validation);
			//die;
			$validation['login_password_confirm'] = $validation['login_password'];
			$validation['login_password_confirm']['equalTo'] = '#login_password';
			//$validation['login_password_confirm']['required'] = true;
			$validation['old_login_password']['required'] = true;

			$this->data['updatecontent'] = $updatecontent;
			$this->data['jqueryvalidation'] = json_encode($validation);

			// 給rander前台的field，呈現必填的星號部份
            $this->data['updatecontent_jqueryvalidation'] = $validation;
			if($this->main_content_exists($this->data['main_content'], $this->data) === false){
				$this->data['main_content'] = 'default/update';
			}
			$this->data['main_content_title'] = $this->data['def']['title'];
			$this->display('index.htm', $this->data);
		} else {
			$this->data['def'] = G::definit($this->def, $this->data);
			$redirect_url = $this->data['class_url'];

			//$this->load->library('Parameter_handle', '', 'parameter');
			//$parameter = $this->parameter->getDefine();
			$parameter = new Parameter_handle;

			$url = base64url::encode($redirect_url);

			$update = $_POST;

			if(!isset($update['old_login_password']) or $update['old_login_password'] == ''){
				//$this->redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'lossfield');
				$this->redirect($this->createUrl('profile/index', array('param'=>'va')));
			}

			//$id = $this->input->post('hidden_id');
			//$User = new Admin_user_orm();
			//$User->where('id', $this->data['admin_id'])->where('login_password', sha1($update['old_login_password']))->get();

			//$row = $this->db->createCommand()->from($this->data['def']['table'])->where('is_enable=1 and login_password="'.sha1($update['old_login_password']).'"')->queryRow();

			if(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
				$row = $this->db->createCommand()->from($this->data['def']['table'])->where('is_enable=1 and id=:id',array(':id'=>$this->data['admin_id']))->queryRow();
				if(!isset($row['salt'])){
					echo '[error] loss salt field';
					die;
				}
				$row = $this->db->createCommand()->from($this->data['def']['table'])->where('is_enable=1 and id=:id and login_password=:pass',array(':id'=>$this->data['admin_id'],'pass'=>'{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.sha1($update['old_login_password'].$row['salt'])))->queryRow();
			} elseif(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 3){
				$row = $this->db->createCommand()->from($this->data['def']['table'])->where('is_enable=1 and id=:id',array(':id'=>$this->data['admin_id']))->queryRow();
				if(!isset($row['salt'])){
					echo '[error] loss salt field';
					die;
				}
				$row = $this->db->createCommand()->from($this->data['def']['table'])->where('is_enable=1 and id=:id and login_password=:pass',array(':id'=>$this->data['admin_id'],'pass'=>'{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($update['old_login_password'].$row['salt'])))))->queryRow();
			} else {
				$row = $this->db->createCommand()->from($this->data['def']['table'])->where('is_enable=1 and id=:id and login_password=:pass',array(':id'=>$this->data['admin_id'],'pass'=>sha1($update['old_login_password'])))->queryRow();
			}

			if(!$row or $row['id'] == ''){
				//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'lossfield');
				$this->redirect($this->createUrl('profile/index', array('param'=>'vb')));
			}

			$sys_log_msg = 'update user_id:'.$this->data['admin_id'].', name:'.$this->data['admin_name'];


			// 如果是空白，就代表使用者並沒有想要改密碼
			if($update['login_password'] == ''){
				unset($update['login_password']);
			} else {
				if(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
					$update['salt'] = G::GeraHash(20);
					$update['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.sha1($update['login_password'].$update['salt']);
				} elseif(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 3){
					$update['salt'] = G::GeraHash(10);
					$update['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($update['login_password'].$update['salt'])));
				} else {
					$update['login_password'] = sha1($update['login_password']);
				}
			}

			$c = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
			$u = $c::model()->findByPk($row['id']);
			$u->setAttributes($update);
			if(!$u->update()){
				G::dbm($u->getErrors());
			}

			sys_log::set($sys_log_msg);

			//$User->from_array($update);

			//// save自己會做validate
			//if(!$User->save()){
			//	show_error($User->error->string);
			//}

			//$this->load->library('sys_log');
			//$this->sys_log->set($sys_log_msg);

			//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'update');
			//redirect($this->data['base_url'].'/auth/logout');
			$this->redirect($this->createUrl('auth/logout'));
		}
	} // update

}

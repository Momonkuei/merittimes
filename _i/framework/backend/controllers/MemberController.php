<?php

class MemberController extends Controller
{

	protected $def = array(
		'enable_delete' => true,
		'table' => 'member',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'member',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('login_account,name', 'required'),
				array('login_account', 'unique'), // 唯一 2020-04-21
				array('login_type', 'system.backend.extensions.myvalidators.arraycomma'),
				//array('login_password', 'system.backend.extensions.myvalidators.sha1passchange'),
			),
		),
		'default_sort_field' => 'login_account', // 預設要排序的欄位
		'search_keyword_field' => array('login_account', 'name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'login_account', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'login_account', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'condition' => array(
			array(
				'where',
				'is_hidden=0',
			),
		),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			'login_account' => array(
				'label' => '帳號',
				'width' => '25%',
				'sort' => true,
			),
			'name' => array(
				'label' => '姓名',
				'width' => '25%',
				'sort' => true,
			),
			//'ml_key' => array(
			//	'label' => '語系',
			//	'width' => '12%',
			//	'sort' => true,
			//	'mls' => true,
			//	'align' => 'center',
			//),
			//'latest_login_time' => array(
			//	'label' => '最後登入時間',
			//	'width' => '12%',
			//	'sort' => true,
			//	'align' => 'center',
			//),
			'is_enable' => array(
				'label' => '是否啟用',
				'width' => '10%',
				'ez' => true,
				'align' => 'center',
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate'
			),
			'smarty_javascript' => '',
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
					'section_title' => '基本欄位',
					'field' => array(
						//'ml_key' => array(
						//	'label' => 'ml:Language',
						//	'type' => 'mls',
						//),
						'login_account' => array(
							'label' => '帳號',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'login_account',
								'name' => 'login_account',
								//'size' => '30',
							),
						),
						'name' => array(
							'label' => '姓名',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'name',
								'name' => 'name',
								'size' => '20',
							),
						),
						'login_password' => array(
							'label' => '密碼',
							'type' => 'pass',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'login_password',
								'name' => 'login_password',
								'size' => '30',
							),
						),
						//'login_password_confirm' => array(
						//	'label' => '密碼確認',
						//	'type' => 'pass',
						//	'attr' => array(
						//		'class' => 'form-control',
						//		'id' => 'login_password_confirm',
						//		'name' => 'login_password_confirm',
						//		'size' => '30',
						//	),
						//),
						'login_type' => array(
							'label' => '部門',
							//'type' => 'multiselect',
							'type' => 'multicheckbox',
							'attr' => array(
								'class' => 'form-control',
								'type' => 'checkbox',
								'id' => 'login_type',
								'name' => 'login_type[]',
							),
							'other' => array(
								'values' => array(),
								//'default' => 'center',
							),
						),
						'email' => array(
							'label' => '電子信箱',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'email',
								'name' => 'email',
								'size' => '30',
							),
						),
						'is_enable' => array(
							'label' => '是否啟用',
							'type' => 'status',
								'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'other1' => '是',
								'other2' => '否',
								'default' => '1',
								'html_start' => '<div class="radio-list">',
								'html_end' => '</div>',
							),
						),
						'latest_login_time' => array(
							'label' => '最後登入時間',
							'type' => 'time',
						),
						'create_time' => array(
							'label' => '建立時間',
							'type' => 'time',
						),
						'update_time' => array(
							'label' => '更新時間',
							'type' => 'time',
						),
					),
				),
			),
		),
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);
		// 如果是最大權限，那就不要客氣，把最大權限的使用者都列出來
		if(isset($this->data['admin_is_hidden']) and $this->data['admin_is_hidden'] == '1'){
			//unset($this->def['condition']['where']);
			unset($this->def['condition'][0]);
		}

		// (為了能夠擴展加密方式)
		// 沒有define：sha1
		// 1：從缺
		// 2：sha1 + salt
		//$this->data['gggaaa_crypt_type'] = 2;

		$sha1 = false;

		// if(!$sha1 and isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
		// 	$this->def['empty_orm_data']['rules'][] = array('login_password', 'system.backend.extensions.myvalidators.sha1passchange');
		// 	$sha1 = true;
		// }

		if(!$sha1 and !isset($this->data['gggaaa_crypt_type'])){
			$this->def['empty_orm_data']['rules'][] = array('login_password', 'system.backend.extensions.myvalidators.sha1passchange');
			$sha1 = true;
		}

		return true;
	}

	protected function getData()
	{
		/*
		 * 取得Resources
		 */

		$c = $this->db->createCommand();
		$c->from('admin_resource');
		$c->where('is_enable=1');
		if(isset($this->data['admin_is_hidden']) and $this->data['admin_is_hidden'] == '1'){
		} else {
			$c->where('is_hidden=0');
		}
		$rows = $c->queryAll();
		$this->data['resources'] = array();
		if($rows){
			foreach($rows as $k => $v){
				if(isset($v['actions'])){
					if($v['actions'] == ''){
						unset($rows[$k]);
					} else {
						$rows[$k]['actions'] = explode(',', $v['actions']);
					}
				}
			}
			$this->data['resources'] = $rows;
		}

		/*
		 * 取得Resources URL
		 */
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_url"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_url');
			$c->where('is_enable = 1 and param_condition != ""');
			if(isset($this->data['admin_is_hidden']) and $this->data['admin_is_hidden'] == '1'){
			} else {
				$c->where('is_hidden=0');
			}
			$rows = $c->queryAll();
			$this->data['urls'] = array();
			if($rows){
				foreach($rows as $k => $v){
					if(isset($v['actions'])){
						if($v['actions'] == ''){
							unset($rows[$k]);
						} else {
							$rows[$k]['actions'] = explode(',', $v['actions']);
						}
					}
				}
				$this->data['urls'] = $rows;
			}
		}else{
			$this->data['urls'] = array();
		}

	}

	//protected function update_show_validation($validation)
	//{

	//	$validation['login_password_confirm'] = $validation['login_password'];
	//	$validation['login_password_confirm']['equalTo'] = '#login_password';
	//	//$validation['login_password_confirm']['required'] = true;
	//	$validation['old_login_password']['required'] = true;

	//	return $validation;
	//}

	protected function update_show_last($updatecontent)
	{
		//var_dump($this->data['params']);die;
		$this->getData();

		//查詢上次登入時間 by lota 2017/9/22
		$user_id = $this->data['params']['value'][0];
		$rows_member = $this->db->createCommand()->from('member')->where('id='.$user_id)->queryRow();

		$rows = $this->db->createCommand()->from('sys_log')->where("log_msg like :log_msg and log_code=:log_code", array(':log_msg'=>'auth success: '.$rows_member['login_account'],':log_code'=>'auth/login'))->order('id DESC')->queryAll();
		
		if(count($rows)){
			if($this->data['admin_id']==$user_id){
				if(isset($rows[1]['create_time'])){
					$this->data['updatecontent']['latest_login_time'] = $rows[1]['create_time'];
				}
			}else{
				$this->data['updatecontent']['latest_login_time'] = $rows[0]['create_time'];
			}						
		}

		/*
		 * 取得使用者簡易授權表
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_user_perm');
			$c->where('user_id='.$this->data['updatecontent']['id']);
			$rows = $c->queryAll();

			$this->data['autzs'] = array();
			//var_dump($rows);
			if($rows){
				foreach($rows as $v){
					$this->data['autzs'][$v['resource']] = $v['value'];
				}
			}
		}else{
			$this->data['autzs'] = array();
		}

		/*
		 * 取得使用者反向簡易授權表
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_revert_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_user_revert_perm');
			$c->where('user_id='.$this->data['updatecontent']['id']);
			$rows = $c->queryAll();

			$this->data['autrzs'] = array();
			//var_dump($rows);
			if($rows){
				foreach($rows as $v){
					$this->data['autrzs'][$v['resource']] = $v['value'];
				}
			}
		}else{
			$this->data['autrzs'] = array();
		}

		/*
		 * 取得使用者簡易網址授權表
		 */
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_url_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_user_url_perm');
			$c->where('user_id='.$this->data['updatecontent']['id']);
			$rows = $c->queryAll();

			$this->data['autrs'] = array();
			//var_dump($rows);
			if($rows){
				foreach($rows as $v){
					$this->data['autrs'][$v['url_id']] = $v['value'];
				}
			}
		}else{
			$this->data['autrs'] = array();
		}

		/*
		 * 取得使用者進階授權表
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_user_action_perm');
			$c->where('user_id='.$this->data['updatecontent']['id']);
			$rows = $c->queryAll();

			$this->data['autzs2'] = array();
			//var_dump($rows);
			if($rows){
				foreach($rows as $v){
					$this->data['autzs2'][$v['resource']][$v['action']] = $v['value'];
				}
			}
		}else{
			$this->data['autzs2'] = array();
		}

		/*
		 * 取得使用者進階網址授權表
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_url_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$c = $this->db->createCommand();
			$c->from('admin_user_url_action_perm');
			$c->where('user_id='.$this->data['updatecontent']['id']);
			$rows = $c->queryAll();

			$this->data['autrs2'] = array();
			//var_dump($rows);
			if($rows){
				foreach($rows as $v){
					$this->data['autrs2'][$v['url_id']][$v['action']] = $v['value'];
				}
			}
		}else{
			$this->data['autrs2'] = array();
		}

		/*
		 * 取得群組列表
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$tmp = explode(',', $this->data['updatecontent']['login_type']);

			// 取得所有的群組
			$rows = $this->db->createCommand()
			->from('admin_group')
			->where('is_enable=1')
			->queryAll();

			$groups = array();
			if($rows){
				foreach($rows as $k => $v){
					$groups[$v['id']]['value'] = $v['name'];
					if(in_array($v['id'], $tmp)){
						//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
						$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
					}
				}
			}
			$this->data['updatecontent']['login_type'] = $groups;
		}else{
			$this->data['updatecontent']['login_type'] = array();
		}

		// 為了支援section_title
		$this->data['main_content'] = 'metronic_154/update';
		//$this->data['main_content'] = 'member/update';
	}

	protected function update_run_other_element($array)
	{
		// 如果是空白，就代表使用者並沒有想要改密碼
		if($array['login_password'] == ''){
			unset($array['login_password']);
		} else {
			if(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
				$update['salt'] = G::GeraHash(20);
				$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.sha1($array['login_password'].$array['salt']);
			} elseif(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 3){
				$update['salt'] = G::GeraHash(10);
				$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
			} else {
				// do nothing
				// $array['login_password'] = sha1($array['login_password'].$array['salt']);
			}
		}

		if(!isset($array['login_type'])){
			$array['login_type'] = '';
		}

		//if(isset($array['login_password'])){
		//	$array['login_password'] = sha1($array['login_password']);
		//}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		// 如果是空白，就代表使用者並沒有想要改密碼
		if($array['login_password'] == ''){
			unset($array['login_password']);
		} else {
			if(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
				if(!isset($array['salt'])){
					echo '[error] loss salt field';
					die;
				}
				$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.sha1($array['login_password'].$array['salt']);
			} elseif(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 3){
				$update['salt'] = G::GeraHash(10);
				$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
			} else {
				$array['login_password'] = sha1($array['login_password']);
			}
		}

		return $array;
	}

	protected function create_show_first($params)
	{
		//$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	protected function create_show_last()
	{
		$this->getData();

		/*
		 * 取得群組列表
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			// 取得所有的群組
			$rows = $this->db->createCommand()
			->from('admin_group')
			->where('is_enable=1')
			->queryAll();

			$groups = array();
			if($rows){
				foreach($rows as $k => $v){
					$groups[$v['id']]['value'] = $v['name'];
				}
			}
			$this->data['updatecontent']['login_type'] = $groups;
		}

		//$this->data['def']['updatefield']['sections'][$this->data['section_map']['company']]['field']['company_pic1']['other']['school_id'] = 'XXX';
		//$this->data['def']['updatefield']['sections'][$this->data['section_map']['personal_general']]['field']['personal_pic1']['other']['school_id'] = 'XXX';

		// 為了支援section_title
		$this->data['main_content'] = 'metronic_154/update';
	}

	protected function update_run_last()
	{
		//echo $this->data['id'];
		//die;

		$autz = array();
		$autrz = array();
		$autz2 = array();
		$autr = array(); // 使用者簡易網址
		$autr2 = array(); // 使用者進階網址

		if(isset($_POST['autz']) and count($_POST['autz']) > 0){
			$autz = $_POST['autz'];
		}

		if(isset($_POST['autrz']) and count($_POST['autrz']) > 0){
			$autrz = $_POST['autrz'];
		}

		if(isset($_POST['autz2']) and count($_POST['autz2']) > 0){
			$autz2 = $_POST['autz2'];
		}

		if(isset($_POST['autr']) and count($_POST['autr']) > 0){
			$autr = $_POST['autr'];
		}

		if(isset($_POST['autr2']) and count($_POST['autr2']) > 0){
			$autr2 = $_POST['autr2'];
		}

		/*
		 * 使用者簡易授權表操作
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){

			$u = new G_admin_user_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autz as $k => $v){
				// XXX
				$autzs_o = new G_admin_user_perm_orm();
				$autzs_o->user_id = $this->data['id'];
				$autzs_o->resource = $k;
				$autzs_o->value = 1;
				$autzs_o->save();
			}
		}

		/*
		 * 使用者反向簡易授權表操作
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_revert_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$u = new G_admin_user_revert_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autrz as $k => $v){
				$autrzs_o = new G_admin_user_revert_perm_orm();
				$autrzs_o->user_id = $this->data['id'];
				$autrzs_o->resource = $k;
				$autrzs_o->value = 1;
				$autrzs_o->save();
			}
		}

		/*
		 * 使用者進階授權表操作
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$u = new G_admin_user_action_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autz2 as $k => $v){
				// @kk method
				foreach($v as $kk => $vv){
					$autzs_o = new G_admin_user_action_perm_orm();
					$autzs_o->user_id = $this->data['id'];
					$autzs_o->resource = $k;
					$autzs_o->action = $kk;
					$autzs_o->value = 1;
					$autzs_o->save();
				}
			}
		}

		/*
		 * 使用者簡易網址授權表操作
		 */
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_url_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$u = new G_admin_user_url_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autr as $k => $v){
				$autrs_o = new G_admin_user_url_perm_orm();
				$autrs_o->user_id = $this->data['id'];
				$autrs_o->url_id = $k;
				$autrs_o->value = 1;
				$autrs_o->save();
			}
		}

		/*
		 * 使用者進階網址授權表操作
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_url_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$u = new G_admin_user_url_action_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autr2 as $k => $v){
				// @kk method
				foreach($v as $kk => $vv){
					$autrs_o = new G_admin_user_url_action_perm_orm();
					$autrs_o->user_id = $this->data['id'];
					$autrs_o->url_id = $k;
					$autrs_o->action = $kk;
					$autrs_o->value = 1;
					$autrs_o->save();
				}
			}
		}

		/* 參考用
			// 一般資料存儲完，換授權資料
			$autzs = $_POST['CommonMember']['autzs'];
			// array(1) { ["perm"]=> array(1) { ["all"]=> string(1) "1" } } 

			// 刪除目前修改的使用者，它的權限表，等一下要重建
			CommonMemberAutz::model()->deleteAll(array(
					'condition'=>'role=:role',
					'params'=>array(
						':role'=>'user_'.$id,
					),
				)
			);

			// @k controller name
			foreach($autzs as $k => $v){
				// @kk method
				foreach($v as $kk => $vv){
					$autzs_o = new CommonMemberAutz;
					$autzs_o->role = 'user_'.$id;
					$autzs_o->task = $k;
					$autzs_o->operation = $kk;
					$autzs_o->isactive = 1;
					$autzs_o->save();
				}
			}
		 */
	}

	protected function create_run_last()
	{
		$autz = array();
		$autrz = array();
		$autz2 = array();
		$autr = array(); // 簡易網址

		if(isset($_POST['autz']) and count($_POST['autz']) > 0){
			$autz = $_POST['autz'];
		}

		if(isset($_POST['autrz']) and count($_POST['autrz']) > 0){
			$autrz = $_POST['autrz'];
		}

		if(isset($_POST['autz2']) and count($_POST['autz2']) > 0){
			$autz2 = $_POST['autz2'];
		}

		if(isset($_POST['autr']) and count($_POST['autr']) > 0){
			$autr = $_POST['autr'];
		}

		/*
		 * 使用者簡易授權表操作
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){

			//$this->data['_last_insert_id']
			$u = new G_admin_user_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autz as $k => $v){
				$autzs_o = new G_admin_user_perm_orm();
				$autzs_o->user_id = $this->data['_last_insert_id'];
				$autzs_o->resource = $k;
				$autzs_o->value = 1;
				$autzs_o->save();
			}
		}

		/*
		 * 使用者反向簡易授權表操作
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_revert_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$u = new G_admin_user_revert_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autrz as $k => $v){
				$autrzs_o = new G_admin_user_revert_perm_orm();
				$autrzs_o->user_id = $this->data['_last_insert_id'];
				$autrzs_o->resource = $k;
				$autrzs_o->value = 1;
				$autrzs_o->save();
			}
		}

		/*
		 * 使用者進階授權表操作
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$u = new G_admin_user_action_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autz2 as $k => $v){
				// @kk method
				foreach($v as $kk => $vv){
					$autzs_o = new G_admin_user_action_perm_orm();
					$autzs_o->user_id = $this->data['_last_insert_id'];
					$autzs_o->resource = $k;
					$autzs_o->action = $kk;
					$autzs_o->value = 1;
					$autzs_o->save();
				}
			}
		}

		/*
		 * 使用者簡易網址授權表操作
		 */
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_url_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){
		
			//$this->data['_last_insert_id']
			$u = new G_admin_user_url_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autr as $k => $v){
				$autrs_o = new G_admin_user_url_perm_orm();
				$autrs_o->user_id = $this->data['_last_insert_id'];
				$autrs_o->url_id = $k;
				$autrs_o->value = 1;
				$autrs_o->save();
			}
		}

		/*
		 * 使用者進階網址授權表操作
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_url_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			$u = new G_admin_user_url_action_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'user_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'user_'.$id,
					//),
				)
			);

			// @k controller name
			if(isset($autr2) and count($autr2) > 0){
				foreach($autr2 as $k => $v){
					// @kk method
					foreach($v as $kk => $vv){
						$autrs_o = new G_admin_user_url_action_perm_orm();
						$autrs_o->user_id = $this->data['_last_insert_id'];
						$autrs_o->url_id = $k;
						$autrs_o->action = $kk;
						$autrs_o->value = 1;
						$autrs_o->save();
					}
				}
			}
		}
	}

}

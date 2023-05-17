<?php

class AdmingroupController extends Controller
{

	protected $def = array(
		'table' => 'admin_group',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'admin_group',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			// 名子範例 C"Required"Validator
			// 可以用的 boolean, captcha, compare, email, date,default, exist, file, filter, in, length, match, numerical, required, type, unique, url
			//'rules' => array(
			//	'name' => array(
			//		'rules' => array('required', 'max_length' => 250)
			//	),
			//	'key' => array(
			//		'rules' => array('required', 'max_length' => 50)
			//	),
			//	'type' => array(
			//		'rules' => array('required', 'max_length' => 50)
			//	),
			//	'style' => array(
			//		'rules' => array('required', 'max_length' => 50)
			//	),
			//),
			//'defaults' => array('type' => 'admin'),
			'primary' => 'id',
			'rules' => array(
				array('name', 'required'),
				//array('email', 'email'),
				//array('is_enable, is_hidden', 'length', 'max'=>1),
				//array('is_enable', 'default', 'value' => '1'),
				//array('create_time, update_time', 'default',
				//	'value'=>new CDbExpression('NOW()'),
				//	'setOnEmpty'=>false,
				//	'on'=>'insert',
				//),
				//array('update_time', 'default',
				//	'value'=>new CDbExpression('NOW()'),
				//	'setOnEmpty'=>false, 'on'=>'update'
				//),

				//array('phone', 'default',
				//	'value'=>'create',
				//	'setOnEmpty'=>false,
				//	'on'=>'insert',
				//),
				//array('phone', 'default',
				//	'value'=>'update',
				//	'setOnEmpty'=>false, 'on'=>'update'
				//),
			),
			/*
				'login_account' => array(
					'rules' => array('required', 'trim', 'unique', 'min_length' => 3, 'max_length' => 64)
				),
				'login_password' => array(
					'rules' => array('required', 'encrypt', 'min_length' => 3, 'max_length' => 64)
				),
				'name' => array(
					// 如果你有設定你自己想要使用的名稱，當然就是會拿來使用
					// 'label' => '其它的名稱',
					'rules' => array('required', 'trim', 'max_length' => 50)
				),
				'phone' => array(
					// 如果要套多國語系，這個欄位只要符合它的設定，其實是不需要設定的
					// 請看lib/datamapper.php裡面的localize_by_model函式
					//'label' => 'lang:${model}_${field}',
					'rules' => array('min_length' => 5, 'max_length' => 50)
				),
				'email' => array(
					'rules' => array('valid_email', 'min_length' => 6, 'max_length' => 255)
				),
				//'ml_key' => array(
				//	'rules' => array('required', 'max_length' => 2)
				//),
				'is_enable' => array(
					'rules' => array('max_length' => 1)
				),
				'is_hidden' => array(
					'rules' => array('max_length' => 1)
				)
			 */
		),
		'default_sort_field' => 'id', // 預設要排序的欄位
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'condition' => array(
		//	array(
		//		'where',
		//		'is_hidden=0',
		//	),
		//),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			'name' => array(
				//'label' => '群組名稱',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'群組名稱', // default
				),
				'width' => '80%',
				'sort' => true,
			),
			'is_enable' => array(
				//'label' => 'ml:Status',
				'mlabel' => array(
					null, // category
					'Status', // label
					array(), // sprintf
					'狀態', // default
				),
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
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
					'field' => array(
						'name' => array(
							//'label' => '群組名稱',
							'mlabel' => array(
								null, // category
								'Title', // label
								array(), // sprintf
								'群組名稱', // default
							),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '20',
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'mlabel' => array(
								null, // category
								'Status', // label
								array(), // sprintf
								'狀態', // default
							),
							'type' => 'status',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'default'=>'1',
							),
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

	protected function update_show_last($updatecontent)
	{
		$this->getData();

		/*
		 * 取得使用者簡易授權表
		 */
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_group_perm');
			$c->where('group_id='.$this->data['updatecontent']['id']);
			$rows = $c->queryAll();

			$this->data['autzs'] = array();
			//var_dump($rows);
			if($rows){
				foreach($rows as $v){
					$this->data['autzs'][$v['resource']] = $v['value'];
				}
			}
		}else{
			$this->data['autzs'][$v['resource']] =array();
		}

		/*
		 * 取得使用者簡易網址授權表
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_url_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_group_url_perm');
			$c->where('group_id='.$this->data['updatecontent']['id']);
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

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_group_action_perm');
			$c->where('group_id='.$this->data['updatecontent']['id']);
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

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_url_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$c = $this->db->createCommand();
			$c->from('admin_group_url_action_perm');
			$c->where('group_id='.$this->data['updatecontent']['id']);
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
	}

	protected function update_run_last()
	{
		//echo $this->data['id'];
		//die;

		$autz = array();
		$autz2 = array();
		$autr = array(); // 使用者簡易網址
		$autr2 = array(); // 使用者進階網址

		if(isset($_POST['autz']) and count($_POST['autz']) > 0){
			$autz = $_POST['autz'];
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

		$u = new G_admin_group_perm_orm();
		$u::model()->deleteAll(array(
				'condition'=>'group_id='.$this->data['id'],
				//'params'=>array(
				//	':role'=>'group_'.$id,
				//),
			)
		);

		// @k controller name
		foreach($autz as $k => $v){
			$autzs_o = new G_admin_group_perm_orm();
			$autzs_o->group_id = $this->data['id'];
			$autzs_o->resource = $k;
			$autzs_o->value = 1;
			$autzs_o->save();
		}

		$u = new G_admin_group_action_perm_orm();
		$u::model()->deleteAll(array(
				'condition'=>'group_id='.$this->data['id'],
				//'params'=>array(
				//	':role'=>'group_'.$id,
				//),
			)
		);

		// @k controller name
		foreach($autz2 as $k => $v){
			// @kk method
			foreach($v as $kk => $vv){
				$autzs_o = new G_admin_group_action_perm_orm();
				$autzs_o->group_id = $this->data['id'];
				$autzs_o->resource = $k;
				$autzs_o->action = $kk;
				$autzs_o->value = 1;
				$autzs_o->save();
			}
		}

		// 使用者簡易網址
		$u = new G_admin_group_url_perm_orm();
		$u::model()->deleteAll(array(
				'condition'=>'group_id='.$this->data['id'],
				//'params'=>array(
				//	':role'=>'group_'.$id,
				//),
			)
		);

		// @k controller name
		foreach($autr as $k => $v){
			$autrs_o = new G_admin_group_url_perm_orm();
			$autrs_o->group_id = $this->data['id'];
			$autrs_o->url_id = $k;
			$autrs_o->value = 1;
			$autrs_o->save();
		}

		$u = new G_admin_group_url_action_perm_orm();
		$u::model()->deleteAll(array(
				'condition'=>'group_id='.$this->data['id'],
				//'params'=>array(
				//	':role'=>'group_'.$id,
				//),
			)
		);

		// @k controller name
		foreach($autr2 as $k => $v){
			// @kk method
			foreach($v as $kk => $vv){
				$autrs_o = new G_admin_group_url_action_perm_orm();
				$autrs_o->group_id = $this->data['id'];
				$autrs_o->url_id = $k;
				$autrs_o->action = $kk;
				$autrs_o->value = 1;
				$autrs_o->save();
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

	protected function create_show_first($params)
	{
		$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	protected function create_show_last()
	{
		$this->getData();
	}

	protected function create_run_last()
	{
		$autz = array();
		$autz2 = array();
		$autr = array(); // 簡易網址
		$autr2 = array(); // 簡易網址

		if(isset($_POST['autz']) and count($_POST['autz']) > 0){
			$autz = $_POST['autz'];
		}

		if(isset($_POST['autz2']) and count($_POST['autz2']) > 0){
			$autz2 = $_POST['autz2'];
		}

		if(isset($_POST['autr']) and count($_POST['autr']) > 0){
			$autr = $_POST['autr'];
		}

		if(isset($_POST['autr2']) and count($_POST['autr2']) > 0){
			$autz2 = $_POST['autr2'];
		}

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){

			//$this->data['_last_insert_id']
			$u = new G_admin_group_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'group_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'group_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autz as $k => $v){
				$autzs_o = new G_admin_group_perm_orm();
				$autzs_o->group_id = $this->data['_last_insert_id'];
				$autzs_o->resource = $k;
				$autzs_o->value = 1;
				$autzs_o->save();
			}
		}

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){
			$u = new G_admin_group_action_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'group_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'group_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autz2 as $k => $v){
				// @kk method
				foreach($v as $kk => $vv){
					$autzs_o = new G_admin_group_action_perm_orm();
					$autzs_o->group_id = $this->data['_last_insert_id'];
					$autzs_o->resource = $k;
					$autzs_o->action = $kk;
					$autzs_o->value = 1;
					$autzs_o->save();
				}
			}
		}

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_url_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			// 使用者簡易網址
			//$this->data['_last_insert_id']
			$u = new G_admin_group_url_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'group_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'group_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autr as $k => $v){
				$autrs_o = new G_admin_group_url_perm_orm();
				$autrs_o->group_id = $this->data['_last_insert_id'];
				$autrs_o->url_id = $k;
				$autrs_o->value = 1;
				$autrs_o->save();
			}
		}


		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_url_action_perm_"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		
		if(count($lll) > 0){

			// 使用者進階網址
			$u = new G_admin_group_url_action_perm_orm();
			$u::model()->deleteAll(array(
					'condition'=>'group_id='.$this->data['_last_insert_id'],
					//'params'=>array(
					//	':role'=>'group_'.$id,
					//),
				)
			);

			// @k controller name
			foreach($autr2 as $k => $v){
				// @kk method
				foreach($v as $kk => $vv){
					$autrs_o = new G_admin_group_url_action_perm_orm();
					$autrs_o->group_id = $this->data['_last_insert_id'];
					$autrs_o->url_id = $k;
					$autrs_o->action = $kk;
					$autrs_o->value = 1;
					$autrs_o->save();
				}
			}
		}
	}

}

<?php

class SubadminuserController extends Controller
{

	protected $_group_condition = '';
	protected $_resource_condition = '';

	protected $def = array(
		'table' => 'member',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'member',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('login_account, email', 'required'),
				array('email', 'email'),
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
				'is_hidden=0 and from_user_id=',
			),
		),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'login_account' => array(
				'label' => '帳號',
				'width' => '15%',
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
			'latest_login_time' => array(
				'label' => '最後登入時間',
				'width' => '12%',
				'sort' => true,
				'align' => 'center',
			),
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
					'field' => array(
						//'ml_key' => array(
						//	'label' => 'ml:Language',
						//	'type' => 'mls',
						//),
						'login_account' => array(
							'label' => '帳號',
							'type' => 'input',
							'attr' => array(
								'id' => 'login_account',
								'name' => 'login_account',
								'size' => '30',
							),
						),
						'login_password' => array(
							'label' => '密碼',
							'type' => 'pass',
							'attr' => array(
								'id' => 'login_password',
								'name' => 'login_password',
								'size' => '30',
							),
						),
						'login_password_confirm' => array(
							'label' => '密碼確認',
							'type' => 'pass',
							'attr' => array(
								'id' => 'login_password_confirm',
								'name' => 'login_password_confirm',
								'size' => '30',
							),
						),
						'name' => array(
							'label' => '姓名',
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '20',
							),
						),
						'type' => array(
							'label' => '部門 / 職位',
							//'type' => 'select3',
							'type' => 'multiselect',
							'attr' => array(
								'id' => 'type',
								'name' => 'type[]',
							),
							'other' => array(
								'values' => array(),
								//'default' => 'center',
							),
						),
						'addr' => array(
							'label' => '地址',
							'type' => 'input',
							'attr' => array(
								'id' => 'addr',
								'name' => 'addr',
								'size' => '50',
							),
						),
						'phone' => array(
							'label' => '電話',
							'type' => 'input',
							'attr' => array(
								'id' => 'phone',
								'name' => 'phone',
								'size' => '30',
							),
						),
						'fax' => array(
							'label' => '傳真',
							'type' => 'input',
							'attr' => array(
								'id' => 'fax',
								'name' => 'fax',
								'size' => '30',
							),
						),
						'mobile' => array(
							'label' => '行動電話',
							'type' => 'input',
							'attr' => array(
								'id' => 'mobile',
								'name' => 'mobile',
								'size' => '30',
							),
						),
						'email' => array(
							'label' => '電子信箱',
							'type' => 'input',
							'attr' => array(
								'id' => 'email',
								'name' => 'email',
								'size' => '30',
							),
						),
						'comments' => array(
							'label' => '備註',
							'type' => 'textarea',
							'attr' => array(
								'id' => 'comments',
								'name' => 'comments',
								//'style' => 'resize: none;',
								'rows' => '4',
								'cols' => '40',
							),
						),
						//'is_area' => array(
						//	'label' => '是否為區經',
						//	'type' => 'status',
						//		'attr' => array(
						//		'id' => 'is_area',
						//		'name' => 'is_area',
						//	),
						//	'other' => array(
						//		'other1' => '是',
						//		'other2' => '否',
						//		'default' => '0',
						//	),
						//),
						//'area_id' => array(
						//	'label' => '屬於哪一個區經',
						//	'type' => 'select3',
						//	//'type' => 'multiselect',
						//	'attr' => array(
						//		'id' => 'area_id',
						//		'name' => 'area_id',
						//	),
						//	'other' => array(
						//		'values' => array('0'=>'無'),
						//		'default' => '0',
						//	),
						//),
						//'is_sales' => array(
						//	'label' => '是否為業務',
						//	'type' => 'status',
						//		'attr' => array(
						//		'id' => 'is_sales',
						//		'name' => 'is_sales',
						//	),
						//	'other' => array(
						//		'other1' => '是',
						//		'other2' => '否',
						//		'default' => '0',
						//	),
						//),
						//'is_tco' => array(
						//	'label' => '是否為TCO',
						//	'type' => 'status',
						//		'attr' => array(
						//		'id' => 'is_tco',
						//		'name' => 'is_tco',
						//	),
						//	'other' => array(
						//		'other1' => '是',
						//		'other2' => '否',
						//		'default' => '0',
						//	),
						//),
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
		} else {
			// 次管理者，只能管理自己的使用者
			$this->def['condition'][0][1] .= $this->data['admin_id'];

			// 次管理者，不能管理自己(這樣子比較合理)
			$this->def['condition'][0][1] .= ' and id != '.$this->data['admin_id'];
		}

		// 取得自己的群組，然後將產出的群組，濾掉不該出現的
		$admin_type = $this->data['admin_type'];
		$groups = explode(',', $admin_type);
		$tmp = array();
		foreach($groups as $k => $v){
			if($v != ''){
				$tmp[] = 'id='.$v;
				$tmp2[] = 'group_id='.$v;
			}
		}
		$this->_group_condition = implode(' OR ', $tmp);
		$tmp3 = implode(' OR ', $tmp2);

		// 取得自己群組的簡易授權開啟的resource，然後濾掉不該出現的
		$tmp4 = array();
		if($tmp3 != ''){
			$tmp2 = array();
			$c = $this->db->createCommand();
			$c->from('admin_group_perm');
			$c->where('value=1 and ('.$tmp3.')');
			$rows = $c->queryAll();
			if($rows){
				foreach($rows as $k => $v){
					$tmp4[] = 'name="'.$v['resource'].'"';
				}
			}
			$this->_resource_condition = implode(' OR ', $tmp4);
		}


		return true;
	}

	protected function getData()
	{

		// 取得區經的列表
		//$rows = $this->db->createCommand()->from('member')->where('is_enable=1 and is_area=1')->queryAll();
		//if($rows){
		//	foreach($rows as $k => $v){
		//		$this->data['def']['updatefield']['sections'][0]['field']['area_id']['other']['values'][$v['id']] = $v['name'];
		//	}
		//}

		/*
		 * 取得Resources
		 */

		$this->data['resources'] = array();
		if($this->_resource_condition != ''){
			$c = $this->db->createCommand();
			$c->from('admin_resource');
			$condition = 'is_enable=1 and ('.$this->_resource_condition.')';
			if(isset($this->data['admin_is_hidden']) and $this->data['admin_is_hidden'] == '1'){
			} else {
				//$c->addWhere('is_hidden=0');
				$condition .= ' and is_hidden=0';
			}
			//echo $condition;
			$c->where($condition);
			$rows = $c->queryAll();
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
			//var_dump($rows);
		}

		/*
		 * 取得Resources URL
		 */

		$this->data['urls'] = array();
		if($this->_resource_condition != ''){
			$c = $this->db->createCommand();
			$c->from('admin_url');
			$condition = 'is_enable=1 and param_condition != "" and ('.$this->_resource_condition.')';
			if(isset($this->data['admin_is_hidden']) and $this->data['admin_is_hidden'] == '1'){
			} else {
				//$c->where('is_hidden=0');
				$condition .= ' and is_hidden=0';
			}
			$c->where($condition);
			$rows = $c->queryAll();
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
		}

	}

	protected function update_show_last($updatecontent)
	{
		$this->getData();

		/*
		 * 取得使用者簡易授權表
		 */

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

		/*
		 * 取得使用者簡易網址授權表
		 */

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

		/*
		 * 取得使用者進階授權表
		 */

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

		/*
		 * 取得使用者進階網址授權表
		 */

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

		/*
		 * 取得群組列表
		 */
		$groups = array();
		if($this->_group_condition != ''){
			$tmp = explode(',', $this->data['updatecontent']['type']);

			// 取得所有的群組
			$rows = $this->db->createCommand()
			->select('*')
			->from('admin_group')
			->where('is_enable=1 and ('.$this->_group_condition.')')
			->queryAll();

			if($rows){
				foreach($rows as $k => $v){
					$groups[$v['id']]['value'] = $v['name'];
					if(in_array($v['id'], $tmp)){
						$groups[$v['id']]['is_selected'] = 'selected';
					}
				}
			}
		}
		$this->data['updatecontent']['type'] = $groups;

		//$this->data['def']['updatefield']['sections'][0]['field']['type']['other']['values'] = $groups;
	}

	protected function update_run_other_element($array)
	{
		// 如果是空白，就代表使用者並沒有想要改密碼
		if($array['login_password'] == ''){
			unset($array['login_password']);
		}

		if(isset($array['login_password'])){
			$array['login_password'] = sha1($array['login_password']);
		}

		if(isset($array['type']) and count($array['type']) > 0){
			$array['type'] = implode(',', $array['type']);
		} else {
			//$array['type'] = '';
			unset($array['type']);
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		if(isset($array['type']) and count($array['type']) > 0){
			$array['type'] = implode(',', $array['type']);
		} else {
			unset($array['type']);
		}

		if(isset($array['login_password'])){
			$array['login_password'] = sha1($array['login_password']);
		//} else {
		//	$array['login_password'] = '';
		}

		return $array;
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
			$autzs_o = new G_admin_user_perm_orm();
			$autzs_o->user_id = $this->data['id'];
			$autzs_o->resource = $k;
			$autzs_o->value = 1;
			$autzs_o->save();
		}

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

		// 使用者簡易網址
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

		$u = new G_admin_user_url_action_perm_orm();
		$u::model()->deleteAll(array(
				'condition'=>'user_id='.$this->data['id'],
				//'params'=>array(
				//	':role'=>'user_'.$id,
				//),
			)
		);

		// @k controller name
		if(isset($autr2) and count($autr2)){
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

	protected function create_show_first($params)
	{
		$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	protected function create_show_last()
	{
		$this->getData();

		/*
		 * 取得群組列表
		 */

		// 取得所有的群組
		$groups = array();
		if($this->_group_condition != ''){
			$rows = $this->db->createCommand()
			->select('*')
			->from('admin_group')
			->where('is_enable=1 and ('.$this->_group_condition.')')
			->queryAll();

			if($rows){
				foreach($rows as $k => $v){
					$groups[$v['id']]['value'] = $v['name'];
				}
			}
		}
		$this->data['updatecontent']['type'] = $groups;

	}

	protected function create_run_last()
	{
		$autz = array();
		$autz2 = array();
		$autr = array(); // 簡易網址

		if(isset($_POST['autz']) and count($_POST['autz']) > 0){
			$autz = $_POST['autz'];
		}

		if(isset($_POST['autz2']) and count($_POST['autz2']) > 0){
			$autz2 = $_POST['autz2'];
		}

		if(isset($_POST['autr']) and count($_POST['autr']) > 0){
			$autr = $_POST['autr'];
		}

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

		// 使用者簡易網址
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

		// 使用者進階網址
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

<?php

/*
 * 權限表，會去看from_user_id是誰，然後它有的權限，這裡才會出現，沒有就沒有
 */

class SubadminuserController extends Controller
{

	protected $_group_condition = '';
	protected $_resource_condition = '';

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
				//array('login_type', 'system.backend.extensions.myvalidators.arraycomma'),
				array('login_password', 'system.backend.extensions.myvalidators.sha1passchange'),
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
				//'is_hidden=0',
				'is_hidden=0 and from_user_id=',
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
					'section_title' => '基本欄位',
					'field' => array(
						'login_account' => array(
							'label' => '帳號',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'login_account',
								'name' => 'login_account',
								'size' => '30',
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
						'login_password_confirm' => array(
							'label' => '密碼確認',
							'type' => 'pass',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'login_password_confirm',
								'name' => 'login_password_confirm',
								'size' => '30',
							),
						),
						//'login_type' => array(
						//	'label' => '群組',
						//	//'type' => 'multiselect',
						//	'type' => 'multicheckbox',
						//	'attr' => array(
						//		'type' => 'checkbox',
						//		'id' => 'login_type',
						//		'name' => 'login_type[]',
						//	),
						//	'other' => array(
						//		'values' => array(),
						//		//'default' => 'center',
						//	),
						//),
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

	//protected function beforeAction($action)
	//{
	//	parent::beforeAction($action);

	//	// 如果是最大權限，那就不要客氣，把最大權限的使用者都列出來
	//	//if(isset($this->data['admin_is_hidden']) and $this->data['admin_is_hidden'] == '1'){
	//	//	//unset($this->def['condition']['where']);
	//	//	unset($this->def['condition'][0]);
	//	//}

	//	// 在使用本功能之前，先查當下操作者的公司是哪一間，並且在搜尋條件加上該條件
	//	// 只能看到本公司的帳號
	//	$row = $this->db->createCommand()->from('member')->where('id=:id and is_enable=1',array(':id'=>$this->data['admin_id']))->queryRow();
	//	if(!$row or !isset($row['id']) or $row['id'] <= 0){
	//		echo 'member is not exists';
	//		header("HTTP/1.0 404 Not Found");
	//		die;
	//	}

	//	//$this->def['condition'][0][1] .= ' and corporation_id > 0 and corporation_id='.$row['corporation_id'];

	//	// 檢查次管理者的公司，所限制的帳號數量(停用也算)
	//	$rows = $this->db->createCommand()->from('member')->where('corporation_id=:id',array(':id'=>$row['corporation_id']))->queryAll();
	//	$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id', array(':id'=>$row['corporation_id'],':type'=>'corporation',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryRow();
	//	if(!$row2 or !isset($row2['other1']) or (int)$row2['other1'] <= 0){
	//		echo 'corporation is not exist or limit is not set';
	//		header("HTTP/1.0 404 Not Found");
	//		die;
	//	}

	//	if($rows and count($rows) >= $row2['other1']){
	//		$this->def['disable_create'] = true;
	//	}

	//	return true;
	//}

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
		//var_dump($this->def['condition'][0][1]);
		//die;

		// 取得自己的群組，然後將產出的群組，濾掉不該出現的
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){

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
			if(isset($tmp2)){
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
			}
		}

		return true;
	}

	protected function getData()
	{
		$acl = new Admin_acl();
		$acl->start();

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
				// 把簡易授權裡面，把本 次管理者沒有權限的部分給拿掉
				if(!$acl->hasAcl($this->data['admin_id'], $v['name'])){
					unset($rows[$k]);
					continue;
				}
				if(isset($v['actions'])){
					if($v['actions'] == ''){
						unset($rows[$k]);
					} else {
						//$rows[$k]['actions'] = explode(',', $v['actions']);

						// 把進階授權裡面，把本 次管理者沒有權限的部分給拿掉
						$tmps = explode(',', $v['actions']);
						foreach($tmps as $kk => $vv){
							if(!$acl->hasAcl($this->data['admin_id'], $v['name'], $vv)){
								unset($tmps[$kk]);
							}
						}
						$rows[$k]['actions'] = $tmps;
					}
				}
			}
			$this->data['resources'] = $rows;
		}
		//var_dump($rows);
		//die;

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

		//$tmp = explode(',', $this->data['updatecontent']['login_type']);

		//// 取得所有的群組
		//$rows = $this->db->createCommand()
		//->select('*')
		//->from('admin_group')
		//->where('is_enable=1')
		//->queryAll();

		//$groups = array();
		//if($rows){
		//	foreach($rows as $k => $v){
		//		$groups[$v['id']]['value'] = $v['name'];
		//		if(in_array($v['id'], $tmp)){
		//			//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
		//			$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
		//		}
		//	}
		//}
		//$this->data['updatecontent']['login_type'] = $groups;

		// 為了支援section_title
		//$this->data['main_content'] = 'submember/update';
		$this->data['main_content'] = 'metronic_154/update';
	}

	protected function update_run_other_element($array)
	{
		// 如果是空白，就代表使用者並沒有想要改密碼
		if($array['login_password'] == ''){
			unset($array['login_password']);
		}

		//if(!isset($array['login_type'])){
		//	$array['login_type'] = '';
		//}

		//if(isset($array['login_password'])){
		//	$array['login_password'] = sha1($array['login_password']);
		//}

		return $array;
	}

	//protected function create_run_other_element($array)
	//{
	//	$array['corporation_id'] = $this->data['corporation_id'];

	//	return $array;
	//}

	protected function create_show_first($params)
	{
		// 在使用本功能之前，先查當下操作者的公司是哪一間，並且在搜尋條件加上該條件
		// 只能看到本公司的帳號
		//    $row = $this->db->createCommand()->from('member')->where('id=:id and is_enable=1',array(':id'=>$this->data['admin_id']))->queryRow();
		//    if(!$row or !isset($row['id']) or $row['id'] <= 0){
		//    	echo 'member is not exists';
		//    	header("HTTP/1.0 404 Not Found");
		//    	die;
		//    }

		if(preg_match('/^buyersline_(.*)$/', $this->data['admin_account']) and preg_match('/^99999/', $this->data['admin_id']) and $this->data['admin_name'] != '' and defined('EIP_APIV1_DOMAIN') and defined('EIP_APIV1_PUBLICKEY') and defined('EIP_APIV1_PRIVATEKEY')){
			$public_key = EIP_APIV1_PUBLICKEY;
			$private_key = EIP_APIV1_PRIVATEKEY;
			$server_ip = EIP_APIV1_DOMAIN;
			$url = 'index.php?r=api/adminidcheck';

			$params = array(
				'login_account' => $this->data['admin_account'],
				'admin_id' => $this->data['admin_id'],
				'admin_name' => $this->data['admin_name'],
			);

			// 這支是客戶端
			$postdata = http_build_query(
				array(
					'get_client_code' => '',
				)
			);
			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
				)
			);
			$context = stream_context_create($opts);
			$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

			//$code = stripslashes($code);
			eval('?'.'>'.$code);

			if(isset($return) and isset($return['check']) and $return['check'] == 'yes'){
				// $row = $return; (do nothing)
			} else {
				var_dump($return);
				echo 'member is not exists';
				header("HTTP/1.0 404 Not Found");
				die;
			}
		} else {
			$row = $this->db->createCommand()->from('member')->where('id=:id and is_enable=1',array(':id'=>$this->data['admin_id']))->queryRow();
			if(!$row or !isset($row['id']) or $row['id'] <= 0){
				echo 'member is not exists';
				header("HTTP/1.0 404 Not Found");
				die;
			}
		}


		//$this->def['condition'][0][1] .= ' and corporation_id > 0 and corporation_id='.$row['corporation_id'];

		// 檢查次管理者的公司，所限制的帳號數量(停用也算)
		//$rows = $this->db->createCommand()->from('member')->where('corporation_id=:id',array(':id'=>$row['corporation_id']))->queryAll();
		//$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id', array(':id'=>$row['corporation_id'],':type'=>'corporation',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryRow();
		//if(!$row2 or !isset($row2['other1']) or (int)$row2['other1'] <= 0){
		//	echo 'corporation is not exist or limit is not set';
		//	header("HTTP/1.0 404 Not Found");
		//	die;
		//}

		//if($rows and count($rows) >= $row2['other1']){
		//	echo 'member amount is out';
		//	header("HTTP/1.0 404 Not Found");
		//	die;
		//}

		//$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	protected function create_show_last()
	{
		$this->getData();

		///*
		// * 取得群組列表
		// */

		//// 取得所有的群組
		//$rows = $this->db->createCommand()
		//->select('*')
		//->from('admin_group')
		//->where('is_enable=1')
		//->queryAll();

		//$groups = array();
		//if($rows){
		//	foreach($rows as $k => $v){
		//		$groups[$v['id']]['value'] = $v['name'];
		//	}
		//}
		//$this->data['updatecontent']['login_type'] = $groups;

		//$this->data['def']['updatefield']['sections'][$this->data['section_map']['company']]['field']['company_pic1']['other']['school_id'] = 'XXX';
		//$this->data['def']['updatefield']['sections'][$this->data['section_map']['personal_general']]['field']['personal_pic1']['other']['school_id'] = 'XXX';

		// 為了支援section_title
		//$this->data['main_content'] = 'subadminuser/update';
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

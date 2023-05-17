<?php

/**
 * 預設是deny，如果你有建立resource，而沒有去設定permission的話
 */
class Admin_acl {

	protected $db;
	protected $acl;

	protected $_resources;
	protected $_users;
	protected $_users_tmp; // 以user_id為key的資料陣列

	protected $_urls;
	protected $_urls_tmp;

	protected $_groups;

	// 只有is_hidden的使用者們，可以看得到的東西
	protected $_hidden_permission;

	// 寫死的，不管資料表admin_resource怎麼寫，如果這裡有，那就還是會列為隱藏權限
	//protected $_hidden_permission2 = 'admin_resource|module|module_register|website_config|admin_menu|language|seo|test|route_list|short_url|list_css|demotemplate|demotemplatelist';
	protected $_hidden_permission2 = '';

	// 給zend acl用的前綴
	protected $_zend_acl_prefix = 'adminacl_';

	// 網址授權
	protected $_user_url_perms;
	protected $_group_url_perms;
	protected $_user_url_action_perms;
	protected $_group_url_action_perms;

	// 反向授權
	protected $_user_revert_perms;

	function __construct()
	{		
		// 這幾行是一定要做的
		//$CI = &get_instance ();
		//$CI->load->helper('zend_framework');
		//Zend_Loader::loadClass('Zend_Acl');
		$this->acl = new Zend_Acl();
		$this->db = Yii::app()->db;
		$this->session = Yii::app()->session;
	}

	public function start()
	{
		$this->_getData();
		$this->_setAcl();
	}

	// 取得Resource(從檔案)
	//public function getRealResources()
	//{
	//	$controller_path = app_path.ds('/controllers');
	//	$resources = $this->_getFilesFromDir($controller_path);
	//	if(count($resources) > 0){
	//		foreach($resources as $k => $v){
	//			$tmp = str_replace($controller_path.'/', '', $v);
	//			$tmp1 = explode('.', $tmp);
	//			if($tmp1[0] == 'auth'){
	//				unset($resources[$k]);
	//			   	continue;
	//			}
	//			$resources[$k] = $tmp1[0];
	//		}
	//	}
	//	// 把customer_開頭的resource，一個一個檢查，不要取得其它家的程式
	//	if(customer_code != ''){
	//		//var_dump($resources);
	//		if(count($resources) > 0){
	//			foreach($resources as $k => $v){
	//				if(preg_match('/^customer_/', $v)){
	//					if(!preg_match('/^customer_'.customer_code.'_/', $v)){
	//						unset($resources[$k]);
	//					}
	//				}
	//			}
	//		}
	//	}
	//	return $resources;
	//}

	public function getResources($admin_id)
	{
		$resources = array();

		// 取得Resource
		$auth_admin_is_hidden = $this->session['auth_admin_is_hidden'];
		$r = $this->db->createCommand();
		$condition = '';
		if($auth_admin_is_hidden != '1'){
			//$this->db->where('is_hidden', '0');
			//$r->where('is_hidden = 0');
			$condition = 'is_hidden = 0 and ';
		}
		//$this->db->where('is_enable', '1');
		//$query = $this->db->get('admin_resource');
		$r->where($condition.'is_enable = 1');
		$rows = $r->select('*')->from('admin_resource')->queryAll();
		$hidden_permission = array();
		foreach($rows as $row){
			$resources[] = $row['name'];
			if($row['is_hidden'] == '1'){
				$hidden_permission[] = $row['name'];
			}
		}
		$this->_hidden_permission = $hidden_permission;

		//$resources2 = $this->getModuleResources();

		// lota
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_url"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$urls = $this->db->createCommand()->from('admin_url')->where('is_enable = 1 and param_condition != ""')->queryAll();
		}else{
			$urls = array();
		}
		

		if(isset($this->_users_tmp[$admin_id]['is_hidden']) and $this->_users_tmp[$admin_id]['is_hidden'] == '0'){
			// 把不該出現給客戶用的給弄掉
			if(count($resources) > 0){
				foreach($resources as $k => $v){
					if(in_array($v, $this->_hidden_permission)){
						unset($resources[$k]);
					}
					if(preg_match('/^('.$this->_hidden_permission2.')$/', $v)){
						unset($resources[$k]);
					}
				}
			}

			if(count($urls) > 0){
				foreach($urls as $k => $v){
					if(in_array($v['name'], $this->_hidden_permission)){
						unset($urls[$k]);
					}
					if(preg_match('/^('.$this->_hidden_permission2.')$/', $v['name'])){
						unset($urls[$k]);
					}
				}
			}
		}

		$urls_tmp = array();
		if(count($urls) > 0){
			foreach($urls as $k => $v){
				$urls_tmp[$v['id']] = $v;
			}
		}

		$this->_urls = $urls;
		$this->_urls_tmp = $urls_tmp;
		//var_dump($urls_tmp);
		//die;

		return $resources;
	}

	//public function getModuleResources()
	//{
	//	$query = $this->db->get('module_register');
	//	$rows = array();
	//	foreach($query->result_array() as $row){
	//		$rows[] = $row;
	//	}
	//	return $rows;
	//}

	protected function _getData()
	{
		// 取得所有User
		//$query = $this->db->get_where('admin_user', array (
		//	'is_enable' => '1',
		//));
		$rows = $this->db->createCommand()
		->select('*')
		->from('member')
		->where('is_enable=1')
		->queryAll();
		$rows_tmp = array();
		foreach($rows as $row){
			$rows_tmp[$row['id']] = $row;
		}
		$this->_users = $rows;
		$this->_users_tmp = $rows_tmp;

		// 取得所有的群組
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$rows = $this->db->createCommand()
			->select('*')
			->from('admin_group')
			->where('is_enable=1')
			->queryAll();
			$this->_groups = $rows;
		}else{
			$this->_groups = array();
		}

		// 取得Resource
		//$auth_admin_is_hidden = $this->session->userdata('auth_admin_is_hidden');
		//if($auth_admin_is_hidden != '1'){
		//	$this->db->where('is_hidden', '0');
		//}
		//$query = $this->db->get('admin_resource');
		//$this->_resources = $query->result_array();

		$this->_resources = $resources = $this->getResources($this->session['auth_admin_id']);

		//var_dump($this->_resources);

	}

	protected function _setAcl()
	{
		$admin_id = $this->session['auth_admin_id'];
		$admin_type = $this->session['auth_admin_type'];

		// 不好意思，你一定要有使用者編號，不然不給你進來
		if($admin_id == ''){
			return;
		}

		// 設定resource
		//var_dump($this->_resources);
		if(count($this->_resources) > 0){
			foreach($this->_resources as $resource) {
				if($resource == '') continue;
				$zend_resource = new Zend_Acl_Resource($resource);

				try {
					$this->acl->add($zend_resource);
				} catch(Exception $e){
				}
			}
		}

		// debug
		//$zend_resource = new Zend_Acl_Resource('productclass');
		//$this->acl->add($zend_resource);

		// 取得所有網址的權限(簡易)，使用者的部份
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_url_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$user_url_perms = $this->db->createCommand()
			->from('admin_user_url_perm')
			->where('value=1 and user_id='.$admin_id)
			->queryAll();
		}else{
			$user_url_perms = 0;
		}

		if($user_url_perms){
			foreach($user_url_perms as $k => $v){
				if(isset($this->_urls_tmp[$v['url_id']])){
					$v['url'] = $this->_urls_tmp[$v['url_id']]['param_condition'];
					$user_url_perms[$k] = $v;
				}
			}
		} else {
			$user_url_perms = array();
		}
		//var_dump($user_url_perms);
		//die;
		$this->_user_url_perms = $user_url_perms;

		// 取得所有網址的權限(進階)，使用者的部份
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_url_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$user_url_action_perms = $this->db->createCommand()
			->from('admin_user_url_action_perm')
			->where('value = 1 and action != "" and user_id = '.$admin_id)
			->queryAll();
		}else{
			$user_url_action_perms = 0;
		}

		if($user_url_action_perms){
			foreach($user_url_action_perms as $k => $v){
				if(isset($this->_urls_tmp[$v['url_id']])){
					$v['url'] = $this->_urls_tmp[$v['url_id']]['param_condition'];
					$user_url_action_perms[$k] = $v;
				}
			}
		} else {
			$user_url_action_perms = array();
		}
		//var_dump($user_url_action_perms);
		//die;
		$this->_user_url_action_perms = $user_url_action_perms;

		/*
		 * 使用者簡易授權
		 */

		// 取得現在這個使用者的權限，然後整理起來
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$normals_tmp = $this->db->createCommand()
			->from('admin_user_perm')
			->where('user_id='.$admin_id)
			->queryAll();
		}else{
			$normals_tmp = array();
		}

		$normals = array();
		if(count($normals_tmp) > 0){
			foreach($normals_tmp as $k => $v){
				$normals[$v['resource']] = $v['value'];
			}
		}

		$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_u1_'.$admin_id);
		$this->acl->addRole($zend_role);

		if(count($normals) > 0){
			foreach($normals as $k => $v) {
				if($v == '1'){
					try {
						$this->acl->allow($this->_zend_acl_prefix.'_u1_'.$admin_id, $k);
					} catch(Exception $e){
					}
				} else {
					try {
						$this->acl->deny($this->_zend_acl_prefix.'_u1_'.$admin_id, $k);
					} catch(Exception $e){
					}
				}
			}
		}

		// 使用者反向授權(要有資料才會啟用這個功能) - 振聲
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_revert_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$user_revert_perm_rows = $this->db->createCommand()
			->from('admin_user_revert_perm')
			->where('value = 1 and user_id = '.$admin_id)
			->queryAll();
		}else{
			$user_revert_perm_rows = 0;
		}

		$user_revert_perms = array();
		if($user_revert_perm_rows){
			foreach($user_revert_perm_rows as $k => $v){
				$user_revert_perms[] = $v['resource'];
			}
		}
		$this->_user_revert_perms = $user_revert_perms;

		// debug
		//$this->acl->allow($this->_zend_acl_prefix.'_u1_'.'12', 'productclass');

		/*
		 * 使用者進階授權
		 */

		// 取得現在這個使用者的權限，然後整理起來
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_user_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$normals_tmp = $this->db->createCommand()
			->from('admin_user_action_perm')
			->where('user_id='.$admin_id)
			->queryAll();
		}else{
			$normals_tmp = array();
		}

		$normals = array();
		if(count($normals_tmp) > 0){
			foreach($normals_tmp as $k => $v){
				$normals[$v['resource']][$v['action']] = $v['value'];
			}
		}

		$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_u2_'.$admin_id);
		$this->acl->addRole($zend_role);

		if(count($normals) > 0){
			foreach($normals as $k => $v) {
				if(count($v) == 1 and isset($v['all'])){
					if($v['all'] == '1'){
						try {
							$this->acl->allow($this->_zend_acl_prefix.'_u2_'.$admin_id, $k);
						} catch(Exception $e){
						}
					} elseif($v['all'] == '0'){
						try {
							$this->acl->deny($this->_zend_acl_prefix.'_u2_'.$admin_id, $k);
						} catch(Exception $e){
						}
					}
					continue;
				}

				foreach($v as $kk => $vv) {
					if($vv == '1'){
						try {
							$this->acl->allow($this->_zend_acl_prefix.'_u2_'.$admin_id, $k, $kk);
						} catch(Exception $e){
						}
					} else {
						try {
							$this->acl->deny($this->_zend_acl_prefix.'_u2_'.$admin_id, $k, $kk);
						} catch(Exception $e){
						}
					}
				}
			}
		}

		/*
		 * 群組簡易授權
		 */

		// 準備並重組群組的搜尋條件

		// 如果沒有指定，那接下來的事情就不用做了
		if($admin_type == ''){
			return;
		}
		$groups = explode(',', $admin_type);

		$tmp = array();
		foreach($groups as $k => $v){
			$tmp[] = 'group_id='.$v;
		}

		$group_condition = implode(' OR ', $tmp);

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){			
			$normals_tmp = $this->db->createCommand()
			->from('admin_group_perm')
			->where($group_condition)
			->queryAll();
		}else{
			$normals_tmp = array();
		}

		$normals = array();
		if(count($normals_tmp) > 0){
			foreach($normals_tmp as $k => $v){
				// 試試能否解決generate/funcsample的授權失敗的問題
				$v['resource'] = str_replace('/', '', $v['resource']);

				$normals[$v['group_id']][$v['resource']] = $v['value'];
			}
		}


		if(count($normals) > 0){
			// 先讓群組的role先跑一次迴圈
			foreach($normals as $k => $v) {
				$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_g1_'.$k);
				$this->acl->addRole($zend_role);
			}

			foreach($normals as $k => $v) {
				foreach($v as $kk => $vv) {
					if($vv == '1'){
						//echo $k;
						//echo $kk;
						//die;
						try {
							$this->acl->allow($this->_zend_acl_prefix.'_g1_'.$k, $kk);
						} catch(Exception $e){
						}
					} else {
						try {
							$this->acl->deny($this->_zend_acl_prefix.'_g1_'.$k, $kk);
						} catch(Exception $e){
						}
					}
				}
			}
		}
		//die;

		/*
		 * 群組進階授權
		 */

		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_action_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$normals_tmp = $this->db->createCommand()
			->from('admin_group_action_perm')
			->where($group_condition)
			->queryAll();
		}else{
			$normals_tmp = array();
		}

		$normals = array();
		if(count($normals_tmp) > 0){
			foreach($normals_tmp as $k => $v){
				// 試試能否解決generate/funcsample的授權失敗的問題
				$v['resource'] = str_replace('/', '', $v['resource']);

				$normals[$v['group_id']][$v['resource']][$v['action']] = $v['value'];
			}
		}

		//$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_g2_'.$admin_id);
		//$this->acl->addRole($zend_role);

		if(count($normals) > 0){

			// 先讓群組的role先跑一次迴圈
			foreach($normals as $k => $v) {
				$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_g2_'.$k);
				$this->acl->addRole($zend_role);
			}

			// @k group_id
			foreach($normals as $k => $v) {
				// @kk resource
				foreach($v as $kk => $vv) {
					if(count($vv) == 1 and isset($vv['all'])){
						if($vv['all'] == '1'){
							try {
								$this->acl->allow($this->_zend_acl_prefix.'_g2_'.$k, $kk);
							} catch(Exception $e){
							}
						} elseif($vv['all'] == '0'){
							try {
								$this->acl->deny($this->_zend_acl_prefix.'_g2_'.$k, $kk);
							} catch(Exception $e){
							}
						}
						continue;
					}

					foreach($vv as $kkk => $vvv) {
						if($vvv == '1'){
							try {
								$this->acl->allow($this->_zend_acl_prefix.'_g2_'.$k, $kk, $kkk);
							} catch(Exception $e){
							}
						} else {
							try {
								$this->acl->deny($this->_zend_acl_prefix.'_g2_'.$k, $kk, $kkk);
							} catch(Exception $e){
							}
						}
					}
				}
			}
		}

		// 取得所有網址的權限(簡易)，群組的部份
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_url_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$group_url_perms = $this->db->createCommand()
			->from('admin_group_url_perm')
			->where('('.$group_condition.') and value=1')
			->queryAll();
		}else{
			$group_url_perms = 0;
		}

		if($group_url_perms){
			foreach($group_url_perms as $k => $v){
				if(isset($this->_urls_tmp[$v['id']])){
					$v['url'] = $this->_urls_tmp[$v['id']]['param_condition'];
					$group_url_perms[$k] = $v;
				}
			}
		} else {
			$group_url_perms = array();
		}
		$this->_group_url_perms = $group_url_perms;


	} // setAcl

	/*
	 * Methods to query the ACL.
	 * @param string vaaa-vbbb-vccc...
	 */
	public function hasAcl($user_id = null, $resource_key, $action_key = 'index', $param = '')
	{

		// 試試能否解決generate/funcsample的授權失敗的問題
		$resource_key = str_replace('/', '', $resource_key);

		if($user_id == null){
			$user_id = $this->session['auth_admin_id'];
		}

		$group_ids_tmp = $this->session['auth_admin_type'];
		// debug
		//$group_ids_tmp = '6,9,11';

		$group_ids = explode(',', $group_ids_tmp);
		//var_dump($group_ids);

		if($user_id == '1') return true;

		// debug 分別是手動開啟某一個測試tco和業務的編號
		//if(preg_match('/^(26)$/', $user_id)) return true;

		// 這是BUG，要注意
		//if($resource_key == 'home') return true;

		if($resource_key == 'site') return true;

		$other_param = array();
		// resource_key => generate/funcsample
		if(preg_match('/^r=/', $resource_key)){
			$tmp = explode('&', $resource_key);
			foreach($tmp as $k => $v){
				$tmp1 = explode('=', $v);
				$key1 = $tmp1[0];
				$value1 = str_replace($key1.'=', '', $v);
				$other_param[$key1] = $value1;
			}
			if(isset($other_param['param']) and $param == ''){
				$param = $other_param['param'];
			}
			if(isset($other_param['r'])){
				$tmp3 = explode('/', $other_param['r']);
				/*
				 * generate是我之前寫的功能，controller的網址多了generate的字眼，也就是多了一層
				 */
				if(count($tmp3) == 3){
					if($tmp3[0] == 'generate'){
						$resource_key = $tmp3[1];
						$action_key = $tmp3[2];
					}
				} elseif(count($tmp3) == 2){
					if($tmp3[0] == 'generate'){
						$resource_key = $tmp3[1];
					} else {
						// 只有兩個的時候要特別處理一下，例如payment/create，就要分配了
						$resource_key = $tmp3[0];
						$action_key = $tmp3[1];
					}
				} elseif(count($tmp3) == 1){
					if($tmp3[0] != 'generate'){
						$resource_key = $tmp3[0];
					}
				}
			}
		}
		//var_dump($other_param);

		// 有時候，會帶入引數進來，例如主選單的地方
		//if(preg_match('/(.*)\/(.*)\/(.*)\&param=(.*)/', $resource_key, $matches)){
		//	$resource_key = $matches[2];
		//	$action_key = $matches[3];
		//	$param = $matches[4];
		//} elseif(preg_match('/(.*)\/(.*)\&param=(.*)/', $resource_key, $matches)){
		//	$resource_key = $matches[1];
		//	$action_key = $matches[2];
		//	$param = $matches[3];
		//} elseif(preg_match('/(.*)\/(.*)\/(.*)/', $resource_key, $matches)){
		//	$resource_key = $matches[2];
		//	$action_key = $matches[3];
		//} elseif(preg_match('/(.*)\/(.*)/', $resource_key, $matches)){
		//	$resource_key = $matches[1];
		//	$action_key = $matches[2];
		//}

		// 有一些功能，不打算納入授權中

		// 預設第一個會看到的頁面
		//if($resource_key == 'currenttemplate'){
		//	return true;
		//}

		// 開關的授權，由我決定
		//if($resource_key == 'm_switch'){
		//	if($action_key == 'create' or $action_key == 'update' or $action_key == 'delete'){
		//		return false;
		//	}
		//}

		// 模組在使用的
		//if($module_serial_id != ''){
		//	$resource_key .= '_'.$module_serial_id;
		//}

		// 
		if(isset($this->_users_tmp[$user_id]['is_hidden']) and $this->_users_tmp[$user_id]['is_hidden'] == 0){
			if(in_array($resource_key, $this->_hidden_permission)){
				return false;
			}

			//if(preg_match('/^('.implode('|',$this->_hidden_permission).')$/', $resource_key)){
			//	return false;
			//}
		}

		// 目前操作模組功能的部份，只有我自己能用
		// 目前暫時不用
		//if($action_key == 'install'){
		//	return false;
		//}

		// 寫個案，會mark掉，是因為語系才是重點，片語給客戶使用沒有關係
		//if($resource_key == 'label' and $action_key == 'create'){
		//	return false;
		//}

		$return = false;

		// 從EIP過來的使用者
		if(preg_match('/^99999(.*)$/', $user_id) and preg_match('/^buyersline_(.*)$/', $this->session['auth_admin_account']) ){
			
			// 設計部、資訊部
			if(in_array(999994, $group_ids) or in_array(999995, $group_ids)){
				$this->_user_revert_perms = array(
					'none',
				);
			} elseif(in_array(999999, $group_ids)){ // SEO部
				$this->_user_revert_perms = array(
					// 這裡是layoutv2在使用的
					'funcv2','layoutv2configscss','layoutv2pagelist','layoutv2cssjs','homeother',

					// 系統最大管理
					'adminmenu','webmenu','webmenuchild','webmenusub','languagegoogle',
					'language','label','funclist','adminresource','functionconstant','emailformat',

					// LayoutV3(內勤用
					'scssconfig', 'layoutv3pagetype','layoutv3grouptype','layoutv3view','mbpanel','dom5','datasource',

					// 首頁管理(公司用
					'companyother','banner1','banner2','sidead','indexad',

					// W01
					'home01section1', 'home01section2', 'home01section3',
				);
			} elseif(in_array(999997, $group_ids) or in_array(999993, $group_ids)){ // 企劃部、業務部
				$this->_user_revert_perms = array(
					'seo',

					// 這裡是layoutv2在使用的
					'funcv2','layoutv2configscss','layoutv2pagelist','layoutv2cssjs','homeother',

					// 系統最大管理
					'adminmenu','webmenu','webmenuchild','webmenusub','languagegoogle',
					'language','label','funclist','adminresource','functionconstant','emailformat',

					// LayoutV3(內勤用
					'scssconfig', 'layoutv3pagetype','layoutv3grouptype','layoutv3view','mbpanel','dom5','datasource',

					// 首頁管理(公司用
					'banner','bannersub','companyother','banner1','banner2','sidead','indexad',

					// W01
					//'home01section1', 'home01section2', 'home01section3',
				);
			}

		}

		// 反向授權
		if(isset($this->_user_revert_perms) and count($this->_user_revert_perms) > 0){
			if(!in_array($resource_key, $this->_user_revert_perms)){
				$return = true;
			}
		}

		// 如果其中一個符合，就符合了
		if($return === true){
			return true;
		}

		// 使用者簡易授權
		try {
			$tmp = $this->acl->isAllowed($this->_zend_acl_prefix.'_u1_'.$user_id, $resource_key, $action_key)?TRUE:FALSE;
			if($tmp === true){
				$return = true;
			}
		} catch(Exception $e){
			//echo $e;
			//return false;
		}

		// 如果其中一個符合，就符合了
		if($return === true){
			return true;
		}

		// 使用者進階授權
		try {
			$tmp = $this->acl->isAllowed($this->_zend_acl_prefix.'_u2_'.$user_id, $resource_key, $action_key)?TRUE:FALSE;
			// debug
			//echo $user_id;
			//echo $resource_key;
			//echo $action_key;
			//var_dump($tmp);
			//die;
			if($tmp === true){
				$return = true;
			}
		} catch(Exception $e){
			//return false;
		}

		// 如果其中一個符合，就符合了
		if($return === true){
			return true;
		}

		// 群組統一授權
		if(count($group_ids) > 0){
			foreach($group_ids as $v){
				// 群組簡易授權
				try {
					//echo $v;
					//echo $resource_key;
					$tmp = $this->acl->isAllowed($this->_zend_acl_prefix.'_g1_'.$v, $resource_key)?TRUE:FALSE;
					if($tmp === true){
						$return = true;
					}
				} catch(Exception $e){
				}
				// 如果其中一個符合，就符合了
				if($return === true){
					return true;
				}

				// 群組進階授權
				try {
					$tmp = $this->acl->isAllowed($this->_zend_acl_prefix.'_g2_'.$v, $resource_key, $action_key)?TRUE:FALSE;
					if($tmp === true){
						$return = true;
					}
				} catch(Exception $e){
				}

				// 如果其中一個符合，就符合了
				if($return === true){
					return true;
				}
			}
		}


		// 網址授權
		if($this->_urls and count($this->_urls) > 0){
			$parameter = new Parameter_handle;
			$params = $parameter->get($param);

			// 使用者簡易網址檢查
			foreach($this->_user_url_perms as $kk => $vv){
				$run = 'if('.$vv['url'].'){'."\n";
				$run .= '  $return = true;';
				$run .= '}'."\n";
				eval($run);

				// 如果其中一個符合，就符合了
				if($return === true){
					return true;
				}
			}

			// 如果其中一個符合，就符合了
			if($return === true){
				return true;
			}

			// 使用者進階網址檢查
			foreach($this->_user_url_action_perms as $kk => $vv){
				if(!isset($vv['url']) or $vv['url'] == '') continue;
				$run = '';
				if($vv['action'] == 'all'){
					$run = 'if('.$vv['url'].'){'."\n";
				} else {
					$run = 'if(('.$vv['url'].') and "'.$action_key.'" == "'.$vv['action'].'"){'."\n";
				}
				$run .= '  $return = true;';
				$run .= '}'."\n";
				eval($run);

				// 如果其中一個符合，就符合了
				if($return === true){
					return true;
				}
			}

			// 如果其中一個符合，就符合了
			if($return === true){
				return true;
			}

			// 群組簡易網址檢查
			if(count($group_ids) > 0){
				foreach($group_ids as $v){
					foreach($this->_group_url_perms as $kk => $vv){
						if(!isset($vv['url']) or $vv['url'] == '') continue;
						$run = 'if('.$vv['url'].'){'."\n";
						$run .= '  $return = true;';
						$run .= '}'."\n";
						//var_dump($other_param);
						//if(isset($other_param['school_id'])){
						//echo $other_param['school_id'];
						//}
						//echo Yii::app()->session['auth_school_id'];
						//echo Yii::app()->getRequest()->getQuery('school_id');
						//echo Yii::app()->session['auth_school_id'];
						//echo $params['school_id'];
						//var_dump($run);
						//var_dump($params);
						eval($run);

						// 如果其中一個符合，就符合了
						if($return === true){
							return true;
						}
					}
				}
			}
		}

		return $return;
	}

	protected function _getFilesFromDir($dir) {

	  $files = array();
	  if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != '.svn') {
				if(is_dir($dir.'/'.$file)){
					$dir2 = $dir.'/'.$file;
					$files[] = $this->_getFilesFromDir($dir2);
				}
				else {
				  // 當controller是m_開頭的時候，代表它是模組，不會納入acl resource裡面
				  if(!preg_match('/^m_(.*)/', $file)){
					$files[] = $dir.'/'.$file;
				  }
				}
			}
		}   
		closedir($handle);
	  }

	  return $this->_array_flat($files);
	}

	protected function _array_flat($array) {

	  $tmp = array();
	  foreach($array as $a) {
		if(is_array($a)) {
		  $tmp = array_merge($tmp, $this->_array_flat($a));
		}   
		else {
		  $tmp[] = $a; 
		}   
	  }

	  return $tmp;
	}

}

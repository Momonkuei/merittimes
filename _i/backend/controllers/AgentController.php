<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,

		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				// array('name', 'required'),
				array('class_ids', 'system.backend.extensions.myvalidators.arraycomma2'),
			),
		),
		'default_sort_field' => 'update_time', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'listfield' => array(
			'name' => array(
				'label' => '姓名',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'公司名稱', // default
				//),
				'width' => '15%',
				'sort' => true,
			),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
			),
			// 'login_account' => array(
			// 	'label' => '帳號',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Title', // label
			// 	//	array(), // sprintf
			// 	//	'公司名稱', // default
			// 	//),
			// 	'width' => '15%',
			// 	'sort' => true,
			// ),
			//'email' => array(
			//	'label' => 'E-Mail',
			//	//'mlabel' => array(
			//	//	null, // category
			//	//	'Title', // label
			//	//	array(), // sprintf
			//	//	'公司名稱', // default
			//	//),
			//	'width' => '15%',
			//	'sort' => true,
			//),
			'is_enable' => array(
				//'label' => 'ml:Sort id',
				'mlabel' => array(
					null, // category
					'Status', // label
					array(), // sprintf
					'啟用狀態', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_enable',
				'ezother'=> '&nbsp;',
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 
			),
			//'smarty_javascript' => 'product/update_javascript.htm',
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
				'button_style' => '2',
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'section_title' => '',
					'field' => array(
						'name' => array(
							'label' => '姓名',
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '20',
							),
						),
						// 'login_account' => array(
						// 	'label' => '登入帳號',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'login_account',
						// 		'name' => 'login_account',
						// 		'size' => '30',
						// 	),
						// ),
						// 'login_password' => array(
						// 	'label' => '密碼',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'login_password',
						// 		'name' => 'login_password',
						// 		'size' => '30',
						// 	),
						// ),
						//'login_password_confirm' => array(
						//	'label' => '密碼確認',
						//	'type' => 'pass',
						//	'attr' => array(
						//		'id' => 'login_password_confirm',
						//		'name' => 'login_password_confirm',
						//		'size' => '30',
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
								// 'html_end' => '<br /><br /><h3>下載記錄：</h3>',
							),
						),
					),
				),
				// funcfieldv3的產出欄位，放在任何位置都可以，有需要就打開 2/7
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_result' => true, // 要記得這個要加
					'field' => array(
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'section_title' => '',
					'field' => array(
						'class_ids' => array(
							'label' => '檔案授權<br />',
							//'type' => 'multiselect',
							'type' => 'multicheckbox',
							'attr' => array(
								'type' => 'checkbox',
								'id' => 'class_ids',
								'name' => 'class_ids[]',
							),
							'other' => array(
								'values' => array(),
								//'default' => 'center',
							),
						),
						'gg01' => array(
							'label' => '下載記錄',
							'type' => 'inputn',
								'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'html' => '',
							),
						),
					),
				),
				// funcfieldv3的自定欄位，放在任何位置都可以，有需要就打開 3/7
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_custom' => true, // 要記得這個要加
					'field' => array(
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// funcfieldv3 有需要就打開 4/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// (為了能夠擴展加密方式)
		// 沒有define：sha1
		// 1：從缺
		// 2：sha1 + salt
		$this->data['gggaaa_crypt_type'] = 1; // 1就是明碼

		$sha1 = false;

		// if(!$sha1 and isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
		// 	$this->def['empty_orm_data']['rules'][] = array('login_password', 'system.backend.extensions.myvalidators.sha1passchange');
		// 	$sha1 = true;
		// }

		if(!$sha1 and !isset($this->data['gggaaa_crypt_type'])){
			$this->def['empty_orm_data']['rules'][] = array('login_password', 'system.backend.extensions.myvalidators.sha1passchange');
			$sha1 = true;
		}

		// 2018-03-29 調整內頁的說明欄位寬度
		unset($ggg);
		if(isset($this->def['updatefield']['sections'][0]['field']) and count($this->def['updatefield']['sections'][0]['field']) > 0){
			foreach($this->def['updatefield']['sections'][0]['field'] as $ggg => $aaa){
				break;
			}
			$this->def['updatefield']['sections'][0]['field'][$ggg]['attr_td1'] = array('width' => '160');
		}
		unset($ggg);
		if(isset($this->def['updatefield']['sections'][1]['field']) and count($this->def['updatefield']['sections'][1]['field']) > 0){
			foreach($this->def['updatefield']['sections'][1]['field'] as $ggg => $aaa){
				break;
			}
			$this->def['updatefield']['sections'][1]['field'][$ggg]['attr_td1'] = array('width' => '160');
		}
		unset($ggg);
		if(isset($this->def['updatefield']['sections'][2]['field']) and count($this->def['updatefield']['sections'][2]['field']) > 0){
			foreach($this->def['updatefield']['sections'][2]['field'] as $ggg => $aaa){
				break;
			}
			$this->def['updatefield']['sections'][2]['field'][$ggg]['attr_td1'] = array('width' => '160');
		}

		return true;
	}

	protected function create_show_last($param='')
	{
		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 取得所有的分類
		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>'download',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
		// $tmp2 = $this->_get_product_classes($this->data);
		// $rows = $tmp2['layer_one'];

		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['id']]['value'] = $v['topic'];
			}
		}
		$this->data['updatecontent']['class_ids'] = $groups;
	}

	protected function update_show_last($updatecontent)
	{
		$rows = $this->db->createCommand()->from($this->data['router_class'].'_log')->where('agent_id=:id', array('id'=>$updatecontent['id']))->order('create_time desc')->queryAll();

		$rows2 = $this->db->createCommand()->from('html')->where('type=:type and is_enable=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['ml_key'],':type'=>'download'))->order('sort_id')->queryAll();
		$rows_tmp = array();
		if($rows2 and count($rows2) > 0){
			foreach($rows2 as $k => $v){
				$rows_tmp[$v['id']] = $v['topic'];
			}
		}

		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->data['def']['updatefield']['sections'][0]['field']['gg01']['other']['html'] .= $rows_tmp[$v['item_id']].' '.$v['create_time'].'<br />';
			}
		}

		// 取得所有的分類
		$tmp = explode(',', $this->data['updatecontent']['class_ids']);
		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>'download',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
		// $tmp2 = $this->_get_product_classes($this->data);
		// $rows = $tmp2['layer_one'];
		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['id']]['value'] = $v['topic'];
				if(in_array($v['id'], $tmp)){
					//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
					$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['class_ids'] = $groups;

		// funcfieldv3 有需要就打開 6/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_run_other_element($array)
	{
		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		if(!isset($array['class_ids'])){
			$array['class_ids'] = '';
		}

		// 如果是空白，就代表使用者並沒有想要改密碼
		if(isset($array['login_password']) and $array['login_password'] == ''){
			unset($array['login_password']);
		} else {
			if(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
				$array['salt'] = G::GeraHash(20);
				$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.sha1($array['login_password'].$array['salt']);
			} elseif(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 3){
				$array['salt'] = G::GeraHash(10);
				$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
			} else {
				// do nothing
				// $array['login_password'] = sha1($array['login_password'].$array['salt']);
			}
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		if(!isset($array['class_ids'])){
			$array['class_ids'] = '';
		}

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
				$array['salt'] = G::GeraHash(10);
				$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
			} else {
				// do nothing
				// $array['login_password'] = sha1($array['login_password'].$array['salt']);
			}
		}

		return $array;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

<?php

/*
 * Controller各個狀態
 *
 * 顯示各個實體Controller的狀態：
 * 例如功能列表存不存在與修改
 * 和後台選單存不存在與修改
 * 還有群組授權的狀態與修改
 */
class FunclistController extends Controller {

	protected $def = array(
		'disable_create' => true,
		'disable_action' => true,
		'disable_index_normal_search' => true,
		//'table' => 'sys_model',
		'orm' => 'Empty_orm',
		//'empty_orm_data' => array(
		//	'table' => 'sys_model',
		//),
		'default_sort_field' => 'name', // 預設要排序的欄位
		'search_keyword_field' => array('name', 'func', 'common_orm', 'common_table'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'get_field_label' => array('name'), // 要變成多國語系的輸出欄位的欄位
		//'condition' => array(
		//	array(
		//		'where',
		//		'pid=0',
		//	),
		//),
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=func/sort', // ajax post都會有個目標
		//),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'func/main_content_top.htm',
		//),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'name' => array(
				'label' => 'Controller名稱',
				'width' => '15%',
				//'align' => 'left',
				//'sort' => true,
			),
			'check1' => array(
				'label' => '左側選單', // 有或沒有，有沒有設定
				'width' => '15%',
				//'align' => 'left',
				//'sort' => true,
			),
			'check2' => array(
				'label' => '功能列表', // 有或沒有，有沒有設定
				'width' => '15%',
				//'align' => 'left',
				//'sort' => true,
			),
			'check3' => array(
				'label' => '群組簡易授權檢查', // 有或沒有，有沒有授權任何一種，不管大或小的權限
				'width' => '15%',
				//'align' => 'left',
				//'sort' => true,
			),
		), // listfield
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				//'jquery-validate', 'fileuploader', 'jyoutube', 'jquery-ui', 'javascript-sortable',
			),
			//'smarty_javascript' => '',
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
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 先取得controller資料夾裡面的東西
		//$this->data['controllers_sys'] = array();
		//$path_tmp = _BASEPATH.ds('/').target_app_name.ds('/controllers');
		//$tmps = $this->_getFiles($path_tmp);

		$this->data['controllers_app'] = array();

		$path_tmp = Yii::getPathOfAlias('system').'/'.target_app_name.'/controllers';
		$tmps = CFileHelper::findFiles($path_tmp);
		if($tmps){
			foreach($tmps as $k => $v){
				$v = str_replace('\\','/',$v); // 因應windowc環境的處理 by lota
				$tmp = str_replace($path_tmp.'/', '', $v);
				if(!preg_match('/Controller\.php/', $tmp)){
					continue;
				}
				//echo $tmp."\n";
				$this->data['controllers_app'][$tmp] = '1';
			}
		}

		$path_tmp = Yii::getPathOfAlias('application').'/controllers';
		$tmps = CFileHelper::findFiles($path_tmp);
		if($tmps){
			foreach($tmps as $k => $v){
				$v = str_replace('\\','/',$v); // 因應windowc環境的處理 by lota
				$tmp = str_replace($path_tmp.'/', '', $v);
				if(!preg_match('/Controller\.php/', $tmp)){
					continue;
				}
				//echo $tmp."\n";
				$this->data['controllers_app'][$tmp] = '1';
			}
		}

		$this->data['controllers'] = array();

		if($this->data['controllers_app']){
			foreach($this->data['controllers_app'] as $k => $v){
				$this->data['controllers'][] = $k;
			}
		}

		// 用檔名當做排序的依據
		//sort($this->data['controllers']);

		// 檢查１：admin_menu
		$this->data['adminmenus'] = array();
		$this->data['adminmenus_tmp'] = array();
		$rows = $this->db->createCommand()->from('admin_menu')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->data['adminmenus'][] = $v;
				$this->data['adminmenus_tmp'][$v['id']] = $v;
			}
		}

		// 檢查２：admin_resource
		$this->data['adminresources'] = array();
		$rows = $this->db->createCommand()->from('admin_resource')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->data['adminresources'][] = $v;
			}
		}

		// 檢查３：admin_group
		$this->data['admingroupperms'] = array();
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group_perm"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$rows = $this->db->createCommand()->from('admin_group_perm')->queryAll();
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					$this->data['admingroupperms'][] = $v;
				}
			}
		}
		$this->data['admingroups_tmp'] = array();
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){
			$rows = $this->db->createCommand()->from('admin_group')->queryAll();
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					$this->data['admingroups_tmp'][$v['id']] = $v;
				}
			}
		}

		return true;
	}


	public function actionIndex($param = '')
	{
		$parameter = new Parameter_handle;
		$params = $parameter->get($param);
		$param_define = $parameter->getDefine();

		$this->data['def'] = G::definit($this->def, $this->data);
		$this->data['params'] = $params;
		$this->data['parameter'] = $param_define;

		$this->index_param_handle();

		//$this->index_get_total();

		$this->data['pagination'] = array(
			'url' => '',
			'control' => array(
				'total' => 0,
			),
		);

		//$this->index_get_data();

		// $controller_menu_exists = array();

		// // 先把沒有設定主選單的項目標記起來，打算放在後面(下面)
		// $this->data['listcontent'] = array();
		// if($this->data['controllers']){
		// 	foreach($this->data['controllers'] as $k => $v){
		// 		$name = strtolower(str_replace('Controller.php', '', $v));

		// 		/*
		// 		 * 檢查１
		// 		 */
		// 		if($this->data['adminmenus']){
		// 			foreach($this->data['adminmenus'] as $kk => $vv){
		// 				$link = $vv['link'];
		// 				if($link == '#') continue;
		// 				$link = str_replace('backend.php?r=', '', $vv['link']);
		// 				if($name == $link){
		// 					$name2 = ''; // 連結顯示後台選單的名稱
		// 					if(isset($this->data['adminmenus_tmp'][$vv['pid']])){
		// 						$name2 = $this->data['adminmenus_tmp'][$vv['pid']]['name'].' / ';
		// 					}
		// 					$name2 .= $vv['name'];
		// 					$check1 = '<a href="'.$this->createUrl('adminmenu/update', array('param'=>'v'.$vv['id'])).'" target="blank">'.$name2.'</a>';
		// 					break;
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		$result1 = array();
		$result2 = array();
		
		$this->data['listcontent'] = array();
		if($this->data['controllers']){
			foreach($this->data['controllers'] as $k => $v){
				$name = strtolower(str_replace('Controller.php', '', $v));

				if($name == 'site'){
					$this->data['listcontent'][$k] = array(
						'id' => $k,
						'name' => ucfirst($name),
						'check1' => '這是預設的Controller',
						'check2' => '',
						'check3' => '',
					);
					continue;
				} else {
					$tmp = array(
						'id' => $k,
						'name' => '<a target="_blank" href="'.$this->createUrl($name.'/index').'">'.ucfirst($name).'</a>',
						'check1' => '',
						'check2' => '',
						'check3' => '',
					);
				}

				$check1 = '';
				$check2 = '';
				$check3 = '';

				$is_check1 = false;
				// $is_check2 = false;
				// $is_check3 = false;

				$menu_name = '';

				/*
				 * 檢查１
				 */
				if($this->data['adminmenus']){
					foreach($this->data['adminmenus'] as $kk => $vv){
						$link = $vv['link'];
						if($link == '#') continue;
						$link = str_replace('backend.php?r=', '', $vv['link']);
						if($name == $link){
							$name2 = ''; // 連結顯示後台選單的名稱
							if(isset($this->data['adminmenus_tmp'][$vv['pid']])){
								$name2 = $this->data['adminmenus_tmp'][$vv['pid']]['name'].' / ';
							}
							$name2 .= $vv['name'];
							if($vv['is_enable'] == 0){
								$check1 = 'disable';
							} else {
								$check1 = '<a href="'.$this->createUrl('adminmenu/update', array('param'=>'v'.$vv['id'])).'" target="blank">'.$name2.'</a>';
							}
							$menu_name = $name2; // 要給後面那個檢查用的
							break;
						}
					}
				}
				if($check1 == ''){
					$check1 = '<span><i class="icon-plus"></i> <a href="'.$this->createUrl('adminmenu/index').'"><span class="text-danger">自行處理</span></a></span>';
				} elseif($check1 == 'disable'){
					$check1 = '<span><i class="icon-icon"></i> <a href="'.$this->createUrl('funclist/menuenable', array('id'=>$vv['id'])).'">'.$menu_name.' 　<i class="icon-ok"></i><span class="text-danger">啟用</span></a></span>';
				} else {
					$is_check1 = true;
				}
				$tmp['check1'] = $check1;

				/*
				 * 檢查２
				 */
				if($this->data['adminresources']){
					foreach($this->data['adminresources'] as $kk => $vv){
						if($name == $vv['name']){
							$name2 = '';
							$name2 .= $vv['description'];
							$name2 .= ' ('.$vv['actions'].')';
							$check2 = '<a href="'.$this->createUrl('adminresource/update', array('param'=>'v'.$vv['id'])).'" target="blank">'.$name2.'</a>';
							break;
						}
					}
				}
				if($check2 == ''){
					$check2 = '<span><i class="icon-plus"></i> <a target="_blank" href="'.$this->createUrl('adminresource/create', array('_searchkeyword' => $name)).'"><span class="text-danger">手動建立</span></a></span>';
					if($menu_name != ''){
						$check2 .= '　<span><i class="icon-ok"></i> <a href="'.$this->createUrl('funclist/resourcecreate', array('name' => $name, 'description' => $menu_name)).'"><span class="text-danger">直接建立</span></a></span>';
					}
				}
				$tmp['check2'] = $check2;

				/*
				 * 檢查３
				 */
				if($this->data['admingroupperms']){
					$name3 = '';
					foreach($this->data['admingroupperms'] as $kk => $vv){
						if($name == $vv['resource'] and $vv['value'] == '1'){
							if(isset($this->data['admingroups_tmp'][$vv['group_id']])){ // 2018-03-23 如果不是建立在次層，那這裡就會報錯
								$name3 .= $this->data['admingroups_tmp'][$vv['group_id']]['name'].', ';
							}
						}
					}
					$check3 = $name3;
				}
				// remove-sign
				$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "admin_group"',array(':aaa_dbname' => aaa_dbname))->queryAll();
				if(count($lll) > 0){
					if($check3 == ''){
						$check3 = '<span><i class="icon-plus"></i> <a target="_blank" href="'.$this->createUrl('admingroup/index').'"><span class="text-danger">請前往授權</span></a></span>';
					}
					$tmp['check3'] = $check3;
				}else{
					$tmp['check3'] ='';
				}

				// $this->data['listcontent'][$k] = $tmp;

				// 為了要分有設選單、和沒設選單
				if($is_check1){
					$result1[] = $tmp;
				} else {
					$result2[] = $tmp;
				}

			}
		}
		//var_dump($tmp);
		//die;

		$result_empty = array(
			array('id' => '99999', 'name' => '　', 'check1' => '', 'check2' => '', 'check3' => ''),
			array('id' => '99999', 'name' => '- - - - -', 'check1' => '( 底下是關閉、或是沒建立選單的資料 )', 'check2' => '- - - - -', 'check3' => ''),
			array('id' => '99999', 'name' => '　', 'check1' => '', 'check2' => '', 'check3' => ''),
		);

		$this->data['listcontent'] = array_merge($result1, $result_empty, $result2);

		$this->index_last_handle();

		if($this->main_content_exists($this->data['main_content'], $this->data) === false){
			$this->data['main_content'] = 'default/index';
		}

		//$this->index_last();

		$this->display('index.htm', $this->data);
		//$this->display('text:123{{**}}', $this->data);
	}

	public function actionResourcecreate()
	{
		// error_reporting(E_ALL);
		// ini_set("display_errors", 1);

		$name = $_GET['name'];
		$description = $_GET['description'];

		$savedata = array(
			'name' => $name,
			'description' => $description,
			'actions' => 'index,create,update,delete',
			'is_hidden' => 0,
			'is_enable' => 1,
		);

		$empty_orm_data = array(
			'table' => 'admin_resource',
		);

		eval($this->data['empty_orm_eval']);
		$c = new $name('insert', $empty_orm_data);
		$c->setAttributes($savedata);

		// 做了這個動作，才會處理預設值等validator(像是處理create_time和update_time的動作)
		if(!$c->validate()){
			G::dbm($c->getErrors());
		}

		// save自己會做validate
		if(!$c->save()){
			G::dbm($c->getErrors());
		}

		header('Location: '.$this->createUrl('funclist/index'));
		die;
	}

	public function actionMenuenable()
	{
		// error_reporting(E_ALL);
		// ini_set("display_errors", 1);

		$name = $_GET['name'];
		$description = $_GET['description'];

		$update = array(
			'is_enable' => 1,
		);

		$empty_orm_data = array(
			'table' => 'admin_menu',
		);

		eval($this->data['empty_orm_eval']);
		$u = new $name('insert', $empty_orm_data);
		$c = $u::model()->findByPk($_GET['id']);
		$c->setAttributes($update);

		// 做了這個動作，才會處理預設值等validator(像是處理create_time和update_time的動作)
		if(!$c->validate()){
			G::dbm($c->getErrors());
		}

		// save自己會做validate
		if(!$c->update()){
			G::dbm($c->getErrors());
		}

		header('Location: '.$this->createUrl('funclist/index'));
		die;
	}

}

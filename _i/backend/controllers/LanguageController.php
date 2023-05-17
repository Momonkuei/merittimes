<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,

		'title' => '語系',
		'table' => 'ml',
		//'orm' => 'language_orm',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'ml',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('key, name', 'required'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('key', 'name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'get_field_label' => array('name'), // 要變成多國語系的輸出欄位的欄位
		'sortable' => array(
			'enable' => 'true',
			//'condition' => 'type = "aboutus"', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=language/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		'listfield' => array(
			//'xxx' => array(
			//	'label' => '&nbsp;',
			//	'width' => '2%',
			//),
			'name' => array(
				'label' => '語系名稱',
				//'label' => 'ml:Name',
				'width' => '40%',
				'sort' => true,
			),
			'key' => array(
				'label' => '關鍵字索引',
				'width' => '15%',
				'align' => 'center',
				'sort' => true,
			),
			//'date_format' => array(
			//	'label' => '日期格式',
			//	'width' => '10%',
			//	'sort' => true,
			//),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
			),
			'sort_id' => array(
				//'label' => 'ml:Sort id',
				'label' => '排序',
				'translate_source' => 'tw',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
			'is_enable' => array(
				//'label' => 'ml:Status',
				'label' => '狀態',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Status', // label
				//	array(), // sprintf
				//	'狀態', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
			),
			// 'create_time' => array(
			// 	'label' => 'ml:Create time',
			// 	'width' => '10%',
			// 	'align' => 'center',
			// 	'sort' => true,
			// ),
			// 'update_time' => array(
			// 	'label' => 'ml:Update time',
			// 	'width' => '10%',
			// 	'align' => 'center',
			// 	'sort' => true,
			// ),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate',
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
							'label' => '語系名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
							),
						),
						'key' => array(
							'label' => '關鍵字索引',
							'type' => 'input',
							'attr' => array(
								'id' => 'key',
								'name' => 'key',
							),
						),
						// 'description' => array(
						// 	'label' => '描述',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'description',
						// 		'name' => 'description',
						// 	),
						// ),
						//'date_format' => array(
						//	'label' => '日期格式',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'date_format',
						//		'name' => 'date_format',
						//		'title' => '預設為%m / %d / %Y，也就是04 / 26 / 2012',
						//	),
						//),
						'interface' => array(
							'label' => '哪些介面啟用',
							'type' => 'multiselect',
							//'type' => 'multicheckbox',
							'attr' => array(
								//'class' => 'form-control',
								//'type' => 'checkbox',
								'id' => 'interface',
								'name' => 'interface[]',
								//'size' => '3',
							),
							'other2' => array(
								'1' => '後台',
								'2' => '前台',
							),
						),
						'domain_name' => array(
							'label' => '綁定前台網域',
							'type' => 'input',
							'attr' => array(
								'id' => 'domain_name',
								'name' => 'domain_name',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '例： demo.xxx.com.tw ',
							),
						),
						'change_url' => array(
							'label' => '更改特定網址',
							'type' => 'input',
							'attr' => array(
								'id' => 'change_url',
								'name' => 'change_url',
								'size' => '40',
							),
						),
						'target' => array(
							'label' => '開啟網址對象ID',
							'type' => 'input',							
							'attr' => array(
								'id' => 'target',
								'name' => 'target',
								'size' => '12',
							),
							'other' => array(
								'html_end' => '例：_blank ',
							),
						),
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'label' => '排序',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Sort', // label
							//	array(), // sprintf
							//	'排序', // default
							//),
							'type' => 'sort',
							'attr' => array(
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'label' => '狀態',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Status', // label
							//	array(), // sprintf
							//	'狀態', // default
							//),
							'type' => 'status',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'default'=>'1',
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

		// funcfieldv3 有需要就打開 4/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

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

		return true;
	}


	/*
	 * 修改與新增，render前，常做的事情，我統一寫在這裡，這樣子寫一次就好了
	 */
	protected function getdata()
	{
		$tmp = array();
		if(isset($this->data['updatecontent']['interface']) and $this->data['updatecontent']['interface'] != ''){
			$tmp = explode(',', $this->data['updatecontent']['interface']);
			if(count($tmp) >= 3){
				unset($tmp[count($tmp)-1]);
				unset($tmp[0]);
			}
		}

		$rows = $this->data['def']['updatefield']['sections'][0]['field']['interface']['other2'];
		$heads = array();
		foreach($rows as $k => $v){
			$heads[$k]['value'] = $v;
			if(in_array($k, $tmp)){
				$heads[$k]['is_selected'] = 'selected';
			}
		}
		$this->data['updatecontent']['interface'] = $heads;
	}

	protected function create_show_last()
	{
		$this->getdata();

		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_show_last($updatecontent)
	{
		$this->getdata();

		// funcfieldv3 有需要就打開 6/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 為了支援section_title
		//$this->data['main_content'] = 'metronic_154/update';
	}

	//public function actionTest()
	//{
	//	// 取得商品欄位群
	//	$rows_field = array();
	//	$t = Yii::app()->db->schema->getTable('product');
	//	if($t){
	//		$rows_field = $t->getColumnNames();
	//	}
	//	//var_dump($rows_field);
	//	$rows = $this->db->createCommand()->from('product')->where('is_enable = 1')->queryAll();
	//}

	protected function create_run_last()
	{
		// 當新增語系的時候，就會把英文的片語值，複製一份到新的語系
		$sql = "insert into ml_lang ( `ml_key`, `label_key`, `value`, `create_time`, `update_time` ) select '".$_POST['key']."', `label_key`, `value`, now(), now() from ml_lang where ml_key = 'en'";
		$this->cidb->query($sql);

		// 會報錯
		//$this->db->createCommand()->execute($sql);

		// 取得商品欄位群
		//$rows_field = array();
		//$t = Yii::app()->db->schema->getTable('product');
		//if($t){
		//	$rows_field = $t->getColumnNames();
		//}
	}

	protected function update_run_other_element($array)
	{
		if(isset($array['interface']) and count($array['interface']) > 0){
			$array['interface'] = ','.implode(',', $_POST['interface']).',';
		}

		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
	}

	protected function create_run_other_element($array)
	{
		if(isset($array['interface']) and count($array['interface']) > 0){
			$array['interface'] = ','.implode(',', $_POST['interface']).',';
		}

		return $array;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

<?php

class Funcv2Controller extends Controller {

	protected $def = array(
		//'table' => 'sys_model',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'sys_func_v2',
			//'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('name', 'required'),
				//array('login_type', 'ext.myvalidators.arraycomma'),
				//array('service_ids', 'ext.myvalidators.arraycomma'),
				//array('login_password', 'ext.myvalidators.sha1passchange'),
			),
		),
		'default_sort_field' => 'id', // 預設要排序的欄位
		'search_keyword_field' => array('name',), // 搜尋字串要搜尋的欄位
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
				'label' => '中文名稱',
				'width' => '10%',
				'sort' => true,
			),
			'func' => array(
				'label' => '英文名稱',
				'width' => '15%',
				//'align' => 'left',
				//'sort' => true,
			),
			'func_other' => array(
				'label' => '其它英文名稱',
				'width' => '20%',
				//'align' => 'left',
				//'sort' => true,
			),
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
			'is_enable' => array(
				'label' => 'ml:Status',
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
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
					'section_title' => '普 通 資 訊',
					'field' => array(
						'name' => array(
							'label' => '中文名稱',
							'type' => 'input',
							'attr_td1' => array(
								'width' => '160',
							),
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'title' => '例如id',
							),
						),
						'func' => array(
							'label' => '英文名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'func',
								'name' => 'func',
							),
						),
						'func_other' => array(
							'label' => '其它英文名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'func_other',
								'name' => 'func_other',
							),
							'other' => array(
								'html_end' => '逗號分隔',
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
							),
						),
						'export' => array(
							'label' => '匯出',
							'type' => 'inputn',
							'other' => array(
'html' => '<a href="/_i/backend.php?r=funcv2/exportgen&id=ID" onclick="return confirm(\'你確定？\')">假文</a>
&nbsp; <a href="/_i/backend.php?r=funcv2/exportcommon&id=ID" onclick="return confirm(\'你確定？\')">正常</a>
&nbsp; <a href="/_i/backend.php?r=XXXXX/funcv2exportdef" onclick="return confirm(\'你確定？\')">結構</a>',
							),
						),
					),
				),
				// 搜尋的欄位
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'section_title' => '搜 尋 欄 位',
					'field' => array(
						'search1' => array(
							'label' => '<a target="_blank" href="#">詳細...</a>',
							'type' => 'inputn',
							'attr' => array(
							),
							'attr_td1' => array(
								'width' => '160',
							),
							'other' => array(
								'html' => '',
							),
							// 欄位類型如下：
							// 有資料的欄位，有幾筆就幾個
							// 一次顯示兩組新增的欄位
							'def' => array(
								'updatefield' => array(
									// jquery-validate, jquery-datepicker
									'head' => array(
										'jquery-validate',
									),
									//'smarty_javascript' => '',
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
									'sections_sample' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'search1_name_' => array(
													'label' => '欄位中文*',
													'type' => 'input',
													'merge' => '1.5',
													'attr_tr' => array(
														'name' => 'search1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'search1_name_',
														'name' => 'search1_name_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'search1_keyname_' => array(
													'label' => '英',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'search1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'search1_keyname_',
														'name' => 'search1_keyname_',
														'size' => '20',
														'class' => 'small_input',
													),
												),
												'search1_type_' => array(
													'label' => '類型',
													'type' => 'select3',
													'merge' => '2', // 頭中尾的頭(1)
													'attr_tr' => array(
														'name' => 'search1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'search1_type_',
														'name' => 'search1_type_',
													),
													'other' => array(
														//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
														//'default' => 'center',
														'default' => '0',
														//'html_start' => '年度',
														'html_end' => '　',
													),
												),
												'search1_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'search1_delete_',
														'value' => '1',
													),
													'other' => array(
														'label' => '刪除',
														//'html_end' => '</span>', // 這裡很特別，別以為寫錯了，只有尾巴而以
													),
												),
											),
										),
										// section 1
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'search1_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'search1_more_',
														'onclick' => 'javascript:$(this).parent().parent().next().show();  $(this).parent().parent().next().next().show();  $(this).parent().parent().next().next().next().show();  $(this).parent().parent().hide(); $(\'tr:odd[name=search1]\').attr(\'class\', \'bgcolor2\');  $(\'tr:even[name=search1]\').attr(\'class\', \'bgcolor1\');',
														'href' => 'javascript:void(0);'
													),
												),
												'end_' => array(
													'label' => '&nbsp;',
													'type' => 'inputn',
													'merge' => '3',
													'attr' => array(
													),
													'other' => array(
														'html' => '',
													),
												),
											),
										),
									),
									'sections' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
											),
										),
									),
								),
							),
						),
					),
				),
				// 列表的欄位
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'section_title' => '列 表 欄 位',
					'field' => array(
						'list1' => array(
							'label' => '<a target="_blank" href="#">詳細...</a>',
							'type' => 'inputn',
							'attr' => array(
							),
							'attr_td1' => array(
								'width' => '160',
							),
							'other' => array(
								'html' => '',
							),
							// 欄位類型如下：
							// 有資料的欄位，有幾筆就幾個
							// 一次顯示兩組新增的欄位
							'def' => array(
								'updatefield' => array(
									// jquery-validate, jquery-datepicker
									'head' => array(
										'jquery-validate',
									),
									//'smarty_javascript' => '',
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
									'sections_sample' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'list1_name_' => array(
													'label' => '欄位中文*',
													'type' => 'input',
													'merge' => '1.5',
													'attr_tr' => array(
														'name' => 'list1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'list1_name_',
														'name' => 'list1_name_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'list1_keyname_' => array(
													'label' => '英',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'list1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'list1_keyname_',
														'name' => 'list1_keyname_',
														'size' => '20',
														'class' => 'small_input',
													),
												),
												//'list1_type_' => array(
												//	'label' => '類型',
												//	'type' => 'select3',
												//	'merge' => '2', // 頭中尾的頭(1)
												//	'attr_tr' => array(
												//		'name' => 'list1', // 為了要做odd, even
												//	),
												//	'attr' => array(
												//		'id' => 'list1_type_',
												//		'name' => 'list1_type_',
												//	),
												//	'other' => array(
												//		//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
												//		//'default' => 'center',
												//		'default' => '0',
												//		//'html_start' => '年度',
												//		'html_end' => '　',
												//	),
												//),
												'list1_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'list1_delete_',
														'value' => '1',
													),
													'other' => array(
														'label' => '刪除',
														//'html_end' => '</span>', // 這裡很特別，別以為寫錯了，只有尾巴而以
													),
												),
											),
										),
										// section 1
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'list1_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'list1_more_',
														'onclick' => 'javascript:$(this).parent().parent().next().show();  $(this).parent().parent().next().next().show();  $(this).parent().parent().next().next().next().show();  $(this).parent().parent().hide(); $(\'tr:odd[name=list1]\').attr(\'class\', \'bgcolor2\');  $(\'tr:even[name=list1]\').attr(\'class\', \'bgcolor1\');',
														'href' => 'javascript:void(0);'
													),
												),
												'end_' => array(
													'label' => '&nbsp;',
													'type' => 'inputn',
													'merge' => '3',
													'attr' => array(
													),
													'other' => array(
														'html' => '',
													),
												),
											),
										),
									),
									'sections' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
											),
										),
									),
								),
							),
						),
					),
				),
				// 修改的欄位
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'section_title' => '修 改 欄 位',
					'field' => array(
						'update1' => array(
							'label' => '<a target="_blank" href="#">第1區 詳細…</a>',
							'type' => 'inputn',
							'attr' => array(
							),
							'attr_td1' => array(
								'width' => '160',
							),
							'other' => array(
								'html' => '',
							),
							// 欄位類型如下：
							// 有資料的欄位，有幾筆就幾個
							// 一次顯示兩組新增的欄位
							'def' => array(
								'updatefield' => array(
									// jquery-validate, jquery-datepicker
									'head' => array(
										'jquery-validate',
									),
									//'smarty_javascript' => '',
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
									'sections_sample' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'update1_name_' => array(
													'label' => '欄位中文*',
													'type' => 'input',
													'merge' => '1.5',
													'attr_tr' => array(
														'name' => 'update1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'update1_name_',
														'name' => 'update1_name_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'update1_keyname_' => array(
													'label' => '英',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'update1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'update1_keyname_',
														'name' => 'update1_keyname_',
														'size' => '20',
														'class' => 'small_input',
													),
												),
												'update1_type_' => array(
													'label' => '類型',
													'type' => 'select3',
													'merge' => '2', // 頭中尾的頭(1)
													'attr_tr' => array(
														'name' => 'update1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'update1_type_',
														'name' => 'update1_type_',
													),
													'other' => array(
														//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
														//'default' => 'center',
														'default' => '0',
														//'html_start' => '年度',
														'html_end' => '　',
													),
												),
												'update1_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'update1_delete_',
														'value' => '1',
													),
													'other' => array(
														'label' => '刪除',
														//'html_end' => '</span>', // 這裡很特別，別以為寫錯了，只有尾巴而以
													),
												),
											),
										),
										// section 1
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'update1_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'update1_more_',
														'onclick' => 'javascript:$(this).parent().parent().next().show();  $(this).parent().parent().next().next().show();  $(this).parent().parent().next().next().next().show();  $(this).parent().parent().hide(); $(\'tr:odd[name=update1]\').attr(\'class\', \'bgcolor2\');  $(\'tr:even[name=update1]\').attr(\'class\', \'bgcolor1\');',
														'href' => 'javascript:void(0);'
													),
												),
												'end_' => array(
													'label' => '&nbsp;',
													'type' => 'inputn',
													'merge' => '3',
													'attr' => array(
													),
													'other' => array(
														'html' => '',
													),
												),
											),
										),
									),
									'sections' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
											),
										),
									),
								),
							),
						),
					),
				),
				// 資料表匯出
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'section_title' => '資 料 表 欄 位',
					'section_disable' => true,
					'field' => array(
						'sql' => array(
							'label' => '',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		$this->data['section_map'] = array(
			'general' => 0,
			'searchfield' => 1,
			'listfield' => 2,
			'updatefield' => 3,
			'sql' => 4,
		);
		return true;
	}

	protected function index_first()
	{
		// 取得資料表名稱
		$class_id = '';
		if(isset($this->data['params']['value'][0])){
			$class_id = $this->data['params']['value'][0];
		}
		$this->data['class_id'] = $class_id;

		if($class_id == ''){
			unset($this->data['def']['listfield']['sort_id']);
		}

		// 功能名稱要有指定，還有其它必要的條件，才能夠即時自動切換
		if($class_id != ''){
			$this->data['def']['sortable']['enable'] = true;
			$this->data['def']['sortable']['condition'] = 'func="'.$this->data['class_id'].'"';

		//'condition' => array(
		//	array(
		//		'where',
		//		'pid=0',
		//	),
			$this->data['def']['condition'][] = array(
				'where',
				'func=\''.$this->data['class_id'].'\'',
			);
		} else {
			$this->data['def']['sortable']['enable'] = false;
		}
		//var_dump($this->data['def']['sortable']);

		// 如果沒有選擇商品分類，而且又沒有指定排序的方式，這時預設排序欄位會改成商品名稱
		if($class_id == '' and $this->data['sort_field_nobase64'] == 'sort_id'){
			$sort_field = 'id';
			$this->data['sort_field'] = base64url::encode($sort_field);
			$this->data['sort_field_nobase64'] = $sort_field;
		}
	}

	protected function index_last()
	{   
		//var_dump($this->data['listcontent']);
		if(count($this->data['listcontent']) > 0){
			foreach($this->data['listcontent'] as $k => $v){
				if(isset($v['common_table']) and G::check_table_field_exists($v['common_table'], $v['name'])){
					$this->data['listcontent'][$k]['has_table_field'] = G::t(null, 'Exist', array(), '存在');
				}
			}
		}

		// 合併取得資料表名稱
		$rows = $this->db->createCommand()->from($this->data['def']['table'])->queryAll();
		$this->data['classes'] = array();
		if($rows){
			foreach($rows as $k => $v){
				if(!in_array($v['func'], $this->data['classes'])){
					$this->data['classes'][] = $v['func'];
				}
			}
		}
	}   

	protected function create_show_last()
	{
		$this->getdata();

		for($x=1;$x<=5;$x++){
			$this->data['def']['updatefield']['sections'][$this->data['section_map']['updatefield']]['field']['update'.$x]['label'] = str_replace('#', 'javascript:;', $this->data['def']['updatefield']['sections'][$this->data['section_map']['updatefield']]['field']['update'.$x]['label']);
		}

		unset($this->data['def']['updatefield']['sections'][$this->data['section_map']['general']]['field']['export']);
	}

	protected function update_show_last($updatecontent)
	{
		$this->getdata();

		for($x=1;$x<=5;$x++){
			$this->data['def']['updatefield']['sections'][$this->data['section_map']['updatefield']]['field']['update'.$x]['label'] = str_replace('#', $this->createUrl($this->data['router_class'].'/editfield',array('id'=>$updatecontent['id'],'section'=>$x)), $this->data['def']['updatefield']['sections'][$this->data['section_map']['updatefield']]['field']['update'.$x]['label']);
		}

		/*
		 * 把編號等資料帶入匯出的按鈕
		 */
		$aaa = $this->data['def']['updatefield']['sections'][$this->data['section_map']['general']]['field']['export']['other']['html'];
		$aaa = str_replace('ID', $updatecontent['id'], $aaa);
		$aaa = str_replace('XXXXX', $updatecontent['func'], $aaa);

		// 檢查檔案是否存在
		$file01 = _BASEPATH.ds('/').target_app_name.ds('/controllers/').ucfirst($updatecontent['func']).'Controller.php';
		if(file_exists($file01)){
			$aaa .= '&nbsp; <span class="label label-danger">檔案己存在</span>';
		}

		$this->data['def']['updatefield']['sections'][$this->data['section_map']['general']]['field']['export']['other']['html'] = $aaa;

		/*
		 * 增加資料表欄位的支援
		 */

		// 先處理搜尋欄位
		$table_fields = array();
		$rows_field = $this->db->createCommand()->from('sys_func_v2_search1')->where('data_id='.$this->data['updatecontent']['id'])->queryAll();
		$ids = array();
		$ids_tmp = array();
		foreach($rows_field as $k => $v){
			$ids[] = $v['id'];
			$ids_tmp[$v['id']] = $v;
		}
		$rows_other = $this->db->createCommand()->from('sys_func_v2_search1_other')->queryAll();
		foreach($rows_other as $k => $v){
			if(in_array($v['data_id'], $ids) and preg_match('/^table_(.*)$/', $v['keyname'], $matches)){
				$field_name = $ids_tmp[$v['data_id']]['keyname'];
				if(!isset($table_fields[$field_name])){
					$table_fields[$field_name] = array();
					$table_fields[$field_name]['comment'] = $ids_tmp[$v['data_id']]['name'];
				}
				$table_fields[$field_name][$matches[1]] = $v['keyvalue'];
			}
		}

		// 在處理修改欄位
		$rows_other = $this->db->createCommand()->from('sys_func_v2_update_other')->queryAll();
		for($x=1;$x<=5;$x++){
			$rows_field = $this->db->createCommand()->from('sys_func_v2_update')->where('update_section='.$x.' and data_id='.$this->data['updatecontent']['id'])->queryAll();
			$ids = array();
			$ids_tmp = array();
			foreach($rows_field as $k => $v){
				$ids[] = $v['id'];
				$ids_tmp[$v['id']] = $v;
			}
			//$rows_other = $this->db->createCommand()->from('sys_func_v2_update_other')->queryAll();
			foreach($rows_other as $k => $v){
				if(in_array($v['data_id'], $ids) and preg_match('/^table_(.*)$/', $v['keyname'], $matches)){
					$field_name = $ids_tmp[$v['data_id']]['keyname'];
					if(!isset($table_fields[$field_name])){
						$table_fields[$field_name] = array();
						$table_fields[$field_name]['comment'] = $ids_tmp[$v['data_id']]['name'];
					}
					$table_fields[$field_name][$matches[1]] = $v['keyvalue'];
				}
			}
		}
		//var_dump($table_fields);
		//die;

		$table_fields_content = 
'DROP TABLE IF EXISTS `'.$this->data['updatecontent']['func'].'`;'."\n"
.'CREATE TABLE IF NOT EXISTS `'.$this->data['updatecontent']['func'].'` ('."\n";

if(count($table_fields) > 0){
	foreach($table_fields as $k => $v){
		if(!isset($v['type']) or $v['type'] == '') continue;
		$tmp = '&nbsp;&nbsp;&nbsp;&nbsp; `'.$k.'` ';
		$tmp .= strtolower($v['type']);
		if(isset($v['length']) and $v['length'] != ''){
			$tmp .= '('.$v['length'].') ';
		} else {
			$tmp .= ' ';
		}
		if(in_array(strtolower($v['type']), array('int', 'varchar'))){
			$tmp .= 'COLLATE utf8_unicode_ci ';
		}
		$tmp .= 'NOT NULL ';
		if(isset($v['comment']) and $v['comment'] != ''){
			$tmp .= 'COMMENT \''.$v['comment'].'\', ';
		}
		$table_fields_content .= $tmp."\n";
	}
}

		$table_fields_content .= 
'  PRIMARY KEY (`id`)'."\n"
.') ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;';

		$this->data['def']['updatefield']['sections'][$this->data['section_map']['sql']]['field']['sql']['other']['html'] = nl2br($table_fields_content);

/* 參考
DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '公司名稱',
  `fax` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '傳真',
  `vat_number` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '統編',
  `industry_ids` varchar(120) COLLATE utf8_unicode_ci NOT NULL COMMENT '產業別',
  `product` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '產品別',
  `phone_id` int(11) NOT NULL COMMENT '電訪人員',
  `sales_run_id` int(11) NOT NULL COMMENT '經營業務',
  `sales_service_id` int(11) NOT NULL COMMENT '服務業務',
  `administrator` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sem_tw_expiry_date` date NOT NULL,
  `sem_en_expiry_date` date NOT NULL,
  `is_enable` tinyint(1) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
 */
	}

	public function actionEditfield($id,$section)
	{
		$_SESSION['funcv2_editfield_id_update'.$section] = $id;	
		$_SESSION['funcv2_editfield_id_updateX'] = $id;	// 後來寫的
		//$this->redirect($this->createUrl('funcfieldv2update'.$section.'/index'));
		$this->redirect($this->createUrl('funcfieldv2update/index'));
	}

	public function actionListfield($id,$section)
	{
		$_SESSION['funcv2_listfield_id_list'.$section] = $id;	
		$this->redirect($this->createUrl('funcfieldv2list'.$section.'/index'));
	}

	public function actionSearchfield($id,$section)
	{
		$_SESSION['funcv2_searchfield_id_search'.$section] = $id;	
		$this->redirect($this->createUrl('funcfieldv2search'.$section.'/index'));
	}

	protected function update_run_last()
	{
		$_POST['search1']['data_id'] = $this->data['id'];
		$_POST['search1']['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
		$this->multi_field_v1('search1', 'sys_func_v2_search1', 'name|keyname|type|sort_id', 'name', $this->data['section_map']['searchfield']);

		$_POST['list1']['data_id'] = $this->data['id'];
		$_POST['list1']['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
		$this->multi_field_v1('list1', 'sys_func_v2_list1', 'name|keyname|sort_id', 'name', $this->data['section_map']['listfield']);

		for($x=1;$x<=5;$x++){
			$_POST['update'.$x]['data_id'] = $this->data['id'];
			$_POST['update'.$x]['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
			//$this->multi_field_v1('update'.$x, 'sys_func_v2_update'.$x, 'name|keyname|type|sort_id', 'name', $this->data['section_map']['updatefield']);
			$this->multi_field_v1s('update'.$x, 'sys_func_v2_update', 'name|keyname|type|sort_id', 'name', $this->data['section_map']['updatefield'],$x);
		}
	}

	protected function create_run_last()
	{
		$_POST['search1']['data_id'] = $this->data['_last_insert_id'];
		$_POST['search1']['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
		$this->multi_field_v1('search1', 'sys_func_v2_search1', 'name|keyname|type|sort_id', 'name', $this->data['section_map']['searchfield']);

		$_POST['list1']['data_id'] = $this->data['_last_insert_id'];
		$_POST['list1']['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
		$this->multi_field_v1('list1', 'sys_func_v2_list1', 'name|keyname|sort_id', 'name', $this->data['section_map']['listfield']);

		for($x=1;$x<=5;$x++){
			$_POST['update'.$x]['data_id'] = $this->data['_last_insert_id'];
			$_POST['update'.$x]['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
			//$this->multi_field_v1('update'.$x, 'sys_func_v2_update'.$x, 'name|keyname|type|sort_id', 'name', $this->data['section_map']['updatefield']);
			$this->multi_field_v1s('update'.$x, 'sys_func_v2_update', 'name|keyname|type|sort_id', 'name', $this->data['section_map']['updatefield'],$x);
		}
	}

	/*
	 * 修改與新增，render前，常做的事情，我統一寫在這裡，這樣子寫一次就好了
	 */
	protected function getdata()
	{
		if(isset($this->data['updatecontent']['id'])){
			$this->data['def']['updatefield']['sections'][$this->data['section_map']['searchfield']]['field']['search1']['label'] = str_replace('#', $this->createUrl($this->data['router_class'].'/searchfield',array('id'=>$this->data['updatecontent']['id'],'section'=>1)), $this->data['def']['updatefield']['sections'][$this->data['section_map']['searchfield']]['field']['search1']['label']);
		}

		if(isset($this->data['updatecontent']['id'])){
			$this->data['def']['updatefield']['sections'][$this->data['section_map']['listfield']]['field']['list1']['label'] = str_replace('#', $this->createUrl($this->data['router_class'].'/listfield',array('id'=>$this->data['updatecontent']['id'],'section'=>1)), $this->data['def']['updatefield']['sections'][$this->data['section_map']['listfield']]['field']['list1']['label']);
		}

		$rows = $this->return_funcv2_field();

		$this->data['def']['updatefield']['sections'][$this->data['section_map']['searchfield']]['field']['search1']['def']['updatefield']['sections_sample'][0]['field']['search1_type_']['other']['values'] = $rows;

		$array_tmp = var_export($this->data['def']['updatefield']['sections'][$this->data['section_map']['updatefield']]['field']['update1'],true);

		for($x=1;$x<=5;$x++){
			// 複製
			if($x != 1){
				$array_tmp2 = $array_tmp;
				$array_tmp2 = str_replace('修改1', '修改'.$x, $array_tmp2);
				$array_tmp2 = str_replace('1區', $x.'區', $array_tmp2);
				$array_tmp2 = str_replace('update1', 'update'.$x, $array_tmp2);
				$run = '$xxx_xxx = '.$array_tmp2.';';
				eval($run);
				$this->data["def"]["updatefield"]["sections"][$this->data['section_map']['updatefield']]["field"]["update".$x] = $xxx_xxx;
			}

			$this->data['def']['updatefield']['sections'][$this->data['section_map']['updatefield']]['field']['update'.$x]['def']['updatefield']['sections_sample'][0]['field']['update'.$x.'_type_']['other']['values'] = $rows;

			// 如果有select或是radio等欄位，別忘了要先給它空值之類的
			for($y=0;$y<=11;$y++){
				$this->data['updatecontent']['update'.$x.'_type_c'.$y] = '0';
			}

			// 想要把修改的欄位屬性值給顯示出來
			if(isset($this->data['updatecontent']['id'])){
				$rowsx = $this->db->createCommand()->from('sys_func_v2_update')->where('data_id='.$this->data['updatecontent']['id'].' AND update_section='.$x)->queryAll();
				if($rowsx){
					foreach($rowsx as $k => $v){
						$rowsx1 = $this->db->createCommand()->from('sys_func_v2_update_attr')->where('is_enable=1 and data_id='.$v['id'])->queryAll();
						if($rowsx1){
							if(!isset($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'])){
								$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] = '';
							}
							if($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] == ''){
								$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] .= '<p>　└　HTML屬性：</p>';
							}
							foreach($rowsx1 as $kk => $vv){
								if($vv['keyvalue'] == ''){
									$vv['keyvalue'] = '``';
								}
								$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] .= '　`'.$vv['keyname'].'` => '.$vv['keyvalue']."\n";
							}
						}
						$rowsx1 = $this->db->createCommand()->from('sys_func_v2_update_other')->where('is_enable=1 and data_id='.$v['id'])->queryAll();
						if($rowsx1){
							if(!isset($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'])){
								$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] = '';
							}
							if(isset($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'])){
								if($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] != ''){
									$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] .= "\n";
								}
								$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] .= '<p>　└　其它屬性：</p>';
							}
							foreach($rowsx1 as $kk => $vv){
								//if(!isset($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'])){
								//	$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] = '';
								//}
								//if($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] == ''){
								//	$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] .= '<p>　└　其它屬性：</p>';
								//}
								if($vv['keyvalue'] == ''){
									$vv['keyvalue'] = '``';
								}
								$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] .= '　`'.$vv['keyname'].'` => '.$vv['keyvalue']."\n";
							}
						}
						$k1 = $v['id']; // 因為修改是多區域的，所以一定會重覆
						if(isset($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end']) and $this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] != ''){
							$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] = str_replace('<br />', '&lt;br /&gt;', $this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end']);
							$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] = '<br /><a class="share_toggle_list_a_'.$k1.'" href="javascript:;">[ 內容 ]</a><span class="share_toggle_list_'.$k1.'" style="display:none"><code>'.nl2br($this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end']).'</code></span>';

							$this->data['updatecontent']['update'.$x.'_delete_'.$v['id'].'_other_html_end'] .= <<<XXX
<script type="text/javascript">
$(document).ready(function(){
$('.share_toggle_list_a_$k1').click(function(){
	$('.share_toggle_list_$k1').toggle();
});
});
</script>
XXX;
						}
					}
				}
			}

			//$this->multi_field_v1('update'.$x, 'sys_func_v2_update'.$x, 'name|keyname|type|sort_id', 'name', $this->data['section_map']['updatefield']);
			$this->multi_field_v1s('update'.$x, 'sys_func_v2_update', 'name|keyname|type|sort_id', 'name', $this->data['section_map']['updatefield'],$x);
		} // for 

		// 想要把搜尋的欄位屬性值給顯示出來
		if(isset($this->data['updatecontent']['id'])){
			$rowsx = $this->db->createCommand()->from('sys_func_v2_search1')->where('data_id='.$this->data['updatecontent']['id'])->queryAll();
			if($rowsx){
				foreach($rowsx as $k => $v){
					$rowsx1 = $this->db->createCommand()->from('sys_func_v2_search1_attr')->where('is_enable=1 and data_id='.$v['id'])->queryAll();
					if($rowsx1){
						if(!isset($this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'])){
							$this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'] = '';
						}
						if($this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'] == ''){
							$this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'] .= '<p></p>';
						}
						foreach($rowsx1 as $kk => $vv){
							if($vv['keyvalue'] == ''){
								$vv['keyvalue'] = '``';
							}
							$this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'] .= '　`'.$vv['keyname'].'` => '.$vv['keyvalue']."\n";
						}
					}
					if(isset($this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end']) and $this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'] != ''){
						$this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'] = str_replace('<br />', '&lt;br /&gt;', $this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end']);
						$this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'] = '<br /><a class="share_toggle_list_a_'.$k.'" href="javascript:;">[ 內容 ]</a><span class="share_toggle_list_'.$k.'" style="display:none"><code>'.nl2br($this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end']).'</code></span>';

						$this->data['updatecontent']['search1_delete_'.$v['id'].'_other_html_end'] .= <<<XXX
<script type="text/javascript">
$(document).ready(function(){
$('.share_toggle_list_a_$k').click(function(){
	$('.share_toggle_list_$k').toggle();
});
});
</script>
XXX;
					}
				}
			} // 搜尋額外屬性
		}

		// 想要把列表的欄位屬性值給顯示出來
		if(isset($this->data['updatecontent']['id'])){
			$rowsx = $this->db->createCommand()->from('sys_func_v2_list1')->where('data_id='.$this->data['updatecontent']['id'])->queryAll();
			if($rowsx){
				foreach($rowsx as $k => $v){
					$rowsx1 = $this->db->createCommand()->from('sys_func_v2_list1_attr')->where('is_enable=1 and data_id='.$v['id'])->queryAll();
					if($rowsx1){
						if(!isset($this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'])){
							$this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'] = '';
						}
						if($this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'] == ''){
							$this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'] .= '<p></p>';
						}
						foreach($rowsx1 as $kk => $vv){
							if($vv['keyvalue'] == ''){
								$vv['keyvalue'] = '``';
							}
							$this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'] .= '　`'.$vv['keyname'].'` => '.$vv['keyvalue']."\n";
						}
					}
					if(isset($this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end']) and $this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'] != ''){
						$this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'] = str_replace('<br />', '&lt;br /&gt;', $this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end']);
						$this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'] = '<br /><a class="share_toggle_list_a_'.$k.'" href="javascript:;">[ 內容 ]</a><span class="share_toggle_list_'.$k.'" style="display:none"><code>'.nl2br($this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end']).'</code></span>';

						$this->data['updatecontent']['list1_delete_'.$v['id'].'_other_html_end'] .= <<<XXX
<script type="text/javascript">
$(document).ready(function(){
$('.share_toggle_list_a_$k').click(function(){
	$('.share_toggle_list_$k').toggle();
});
});
</script>
XXX;
					}
				}
			} // 列表額外屬性
		}

		for($y=0;$y<=11;$y++){
			$this->data['updatecontent']['list1_type_c'.$y] = '0';
			$this->data['updatecontent']['search1_type_c'.$y] = '0';
		}

		$this->multi_field_v1('search1', 'sys_func_v2_search1', 'name|keyname|type|sort_id', 'name', $this->data['section_map']['searchfield']);
		$this->multi_field_v1('list1', 'sys_func_v2_list1', 'name|keyname|sort_id', 'name', $this->data['section_map']['listfield']);

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	protected function update_run_other_element($array)
	{
		// 如果有選內頁欄位型態，而且額外屬性、額外其它、額外def，有一個是空白，這裡就會加預設值進去
		//if(isset($_POST['update_type']) and $_POST['update_type'] != ''){
		//	if(!isset($_POST['update_attr']) or $_POST['update_attr'] != '' or !isset($_POST['update_other']) or $_POST['update_other'] != '' or !isset($_POST['update_def']) or $_POST['update_def'] != ''){
		//	}
		//}

		if(isset($_POST['update_head']) and count($_POST['update_head']) > 0){
			$array['update_head'] = implode(',', $_POST['update_head']);
		}

		//var_dump($_POST);
		//die;

		return $array;
	}

	protected function create_run_other_element($array)
	{
		if(isset($_POST['update_head']) and count($_POST['update_head']) > 0){
			$array['update_head'] = implode(',', $_POST['update_head']);
		}

		return $array;
	}

	public function actionExportgen($id='')
	{
		if($id == '') die;

		$row = $this->db->createCommand()->from('sys_func_v2')->where('id='.$id)->queryRow();
		if($row and isset($row['id'])){
			$file01 = _BASEPATH.ds('/').target_app_name.ds('/controllers/').ucfirst($row['func']).'Controller.php';

			$tmp00 = $row['name'];
			$tmp01 = ucfirst($row['func']).'Controller';
			$program_content = <<<XXX
<?php

// $tmp00
class $tmp01 extends Controllergen
{

// DEF AUTO GENERATE START, DO NOT MODIFY!!
// DEF AUTO GENERATE END, DO NOT MODIFY!!

}

XXX;

			file_put_contents($file01, $program_content);
			chmod($file01,0777);
		}

		$end_string = '';
		// 這行沒有加，在IE就會看到亂碼
		$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
		$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
		$end_string .= '<script type="text/javascript">';
		$end_string .= 'alert("Export success");';
		$end_string .= 'window.location.href="'.$_SERVER['HTTP_REFERER'].'";';
		$end_string .= '</script>';
		echo $end_string;
		die;
	}

	public function actionExportcommon($id='')
	{
		if($id == '') die;

		$row = $this->db->createCommand()->from('sys_func_v2')->where('id='.$id)->queryRow();
		if($row and isset($row['id'])){
			$file01 = _BASEPATH.ds('/').target_app_name.ds('/controllers/').ucfirst($row['func']).'Controller.php';

			$tmp00 = $row['name'];
			$tmp01 = ucfirst($row['func']).'Controller';
			$program_content = <<<XXX
<?php

// $tmp00
class $tmp01 extends Controllercommon
{

// DEF AUTO GENERATE START, DO NOT MODIFY!!
// DEF AUTO GENERATE END, DO NOT MODIFY!!

}

XXX;

			file_put_contents($file01, $program_content);
			chmod($file01,0777);
		}

		$end_string = '';
		// 這行沒有加，在IE就會看到亂碼
		$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
		$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
		$end_string .= '<script type="text/javascript">';
		$end_string .= 'alert("Export success");';
		$end_string .= 'window.location.href="'.$_SERVER['HTTP_REFERER'].'";';
		$end_string .= '</script>';
		echo $end_string;
		die;
	}

	/*
	 * 只是想把不同的修改1~5，合併在一起，試著在同一個資料表上
	 *
	 * @update_section 這個是新加的欄位，跟原本v1不一樣的地方
	 */
	protected function multi_field_v1s($groupname, $tablename, $fields_pipe, $require_field, $section_number, $update_section)
	{
		/* 使用方式
		 * 1. 獨立使用section
		 * 2. membercontact是GROUPNAME
		 
				// section 2
				array(
					'form' => array('enable' => false),
					'type' => '1',
					//'section_title' => '聯絡人',
					'field' => array(
						'membercontact' => array(
							'label' => '評鑑',
							'type' => 'inputn',
							'attr' => array(
							),
							'attr_td1' => array(
								'width' => '160',
							),
							'other' => array(
								'html' => '',
							),
							// 欄位類型如下：
							// 有資料的欄位，有幾筆就幾個
							// 一次顯示兩組新增的欄位
							'def' => array(
								'updatefield' => array(
									// jquery-validate, jquery-datepicker
									'head' => array(
										'jquery-validate',
									),
									//'smarty_javascript' => '',
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
									'sections_sample' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												//'membercontact_name_' => array(
												//	'label' => '姓名*',
												//	'type' => 'input',
												//	'merge' => '1',
												//	'attr_tr' => array(
												//		'name' => 'membercontact', // 為了要做odd, even
												//	),
												//	'attr' => array(
												//		'id' => 'membercontact_name_',
												//		'name' => 'membercontact_name_',
												//		//'size' => '20',
												//		'class' => 'small_input',
												//	),
												//),
												'membercontact_year_' => array(
													'label' => '年度',
													'type' => 'select3',
													'merge' => '1.5', // 頭中尾的頭(1)
													'attr_tr' => array(
														'name' => 'membercontact', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'membercontact_year_',
														'name' => 'membercontact_year_',
													),
													'other' => array(
														//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
														//'default' => 'center',
														// Jonathan在1/28的早上11:38分所說的
														'values' => array(
															'90' => '90',
															'91' => '91',
															'92' => '92',
															'93' => '93',
															'94' => '94',
															'95' => '95',
															'96' => '96',
															'97' => '97',
															'98' => '98',
															'99' => '99',
															'100' => '100',
															'101' => '101',
															'102' => '102',
															'103' => '103',
															'104' => '104',
															'105' => '105',
															'106' => '106',
															'107' => '107',
															'108' => '108',
															'109' => '109',
															'110' => '110',
															'111' => '111',
															'112' => '112',
															'113' => '113',
															'114' => '114',
															'115' => '115',
															'116' => '116',
															'117' => '117',
															'118' => '118',
															'119' => '119',
															'120' => '120',
														),
														'default' => '90',
														//'html_start' => '年度',
														'html_end' => '　',
													),
												),
												'membercontact_performance_' => array(
													'label' => '*工程業績NT$',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'membercontact', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'membercontact_performance_',
														'name' => 'membercontact_performance_',
														//'size' => '20',
														'class' => 'small_input',
													),
												),
												'membercontact_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'membercontact_delete_',
														'value' => '1',
													),
													'other' => array(
														'label' => '刪除',
														//'html_end' => '</span>', // 這裡很特別，別以為寫錯了，只有尾巴而以
													),
												),
											),
										),
										// section 1
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'membercontact_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'membercontact_more_',
														'onclick' => 'javascript:$(this).parent().parent().next().show();  $(this).parent().parent().next().next().show();  $(this).parent().parent().next().next().next().show();  $(this).parent().parent().hide(); $(\'tr:odd[name=membercontact]\').attr(\'class\', \'bgcolor2\');  $(\'tr:even[name=membercontact]\').attr(\'class\', \'bgcolor1\');',
														'href' => 'javascript:void(0);'
													),
												),
												'end_' => array(
													'label' => '&nbsp;',
													'type' => 'inputn',
													'merge' => '3',
													'attr' => array(
													),
													'other' => array(
														'html' => '',
													),
												),
											),
										),
									),
									'sections' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
											),
										),
									),
								),
							),
						),
					),
				),
		 */

		$fields = explode('|', $fields_pipe);
		
		if(!empty($_POST)){
			$update = $_POST;
			$membercontacts = array();
			foreach($update as $k => $v){
				if(preg_match('/^'.$groupname.'_/', $k)){
					// search1_name_3
					$tmps = explode('_', $k);

					// 想要試著修正欄位有底線的情況
					$tmpsb = $tmps; // 備份
					// 尾頭切掉
					unset($tmps[count($tmps)-1]);
					unset($tmps[0]);
					$tmp1 = implode('_', $tmps);
					$tmps = array();
					$tmps[0] = $tmpsb[0];
					$tmps[1] = $tmp1;
					$tmps[2] = $tmpsb[count($tmpsb)-1];

					if($tmps[1] == 'delete' and $v == '1'){
						$membercontacts[$tmps[2]]['is_enable'] = 0;
					} else {
						$membercontacts[$tmps[2]][$tmps[1]] = $v;
					}

					unset($update[$k]);
				}
			}

			if(count($membercontacts) > 0){
				foreach($membercontacts as $k => $v){
					// 類似必填欄位
					if(isset($v[$require_field]) and $v[$require_field] == '') continue;

					// 新增
					if(substr($k, 0, 1) == 'c'){
						$v['data_id'] = $update[$groupname]['data_id'];
						$v['update_section'] = $update_section;
						//$v['is_enable'] = 1; // 預設值
						$v['create_time'] = date('Y-m-d H:i:s');
						$v['from_user_id'] = $update[$groupname]['from_user_id'];
						$this->cidb->insert($tablename, $v); 
					} else { // 修改
						//if(!isset($v['mainemail'])) $v['mainemail'] = 0;
						//if(!isset($v['maincontact'])) $v['maincontact'] = 0;
						$v['update_time'] = date('Y-m-d H:i:s');
						$this->cidb->where('id', $k);
						$this->cidb->update($tablename, $v); 
					}
				}
			}
			return true;
		}

		include_once 'simple_html_dom.php';


		/*
		 * 多筆
		 */

		// 測試一下
		//$updatecontent_tmp = array();

		$updatecontent_tmp = $this->data['updatecontent'];

		// 只留本群組該用到的updatecontent元素
		if($updatecontent_tmp){
			foreach($updatecontent_tmp as $k => $v){
				if(!preg_match('/^'.$groupname.'/', $k)){
					unset($updatecontent_tmp[$k]);
				}
			}
		}


		$data_tmp = $this->data;

		if($this->data['def']['updatefield']['method'] == 'update'){
			if(in_array('sort_id', $fields)){
				$rows = $this->db->createCommand()->from($tablename)->where('is_enable=1 and update_section=:section and data_id=:id', array('id'=>$this->data['updatecontent']['id'],'section'=>$update_section))->order('sort_id')->queryAll();
			} else {
				$rows = $this->db->createCommand()->from($tablename)->where('is_enable=1 and update_section=:section and data_id=:id', array('id'=>$this->data['updatecontent']['id'],'section'=>$update_section))->queryAll();
			}

			//var_dump($rows);
			//die;
			if($rows){
				foreach($rows as $k => $v){
					foreach($v as $kk => $vv){
						if(preg_match('/^('.$fields_pipe.'|id)$/', $kk)){
							$updatecontent_tmp[$groupname.'_'.$kk.'_'.$v['id']] = $vv;
						}
					}

					// 每一筆資料都會重建一次sections裡面的東西
					$create_id = $v['id']; // 複製程式碼，所以採用同樣的寫法
					$tmpx = ''; // 因為等一下要做一次的動作
					foreach($this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][0]['field'] as $kk => $vv){
						if($tmpx == ''){
							$vv['label'] = '&nbsp;'.$vv['label'];
						}

						$tmp = $vv;

						if(isset($tmp['attr']['id'])) $tmp['attr']['id'] .= $create_id;
						if(isset($tmp['attr']['name'])) $tmp['attr']['name'] .= $create_id;

						// 試著撰寫從外部資料覆寫或增加欄位客製屬性的功能
						// 參考的外部程式碼 $this->data['updatecontent']['rule1_param2_2_attr_placeholder'] = '123';
						foreach($updatecontent_tmp as $kkk => $vvv){
							if(preg_match('/^'.$kk.$create_id.'_(attr|other)_(.*)$/', $kkk, $matches)){
								$tmp[$matches[1]][$matches[2]] = $vvv;
							} elseif(preg_match('/^'.$kk.$create_id.'_(label|type)$/', $kkk, $matches)){
								$tmp[$matches[1]] = $vvv;
							}
						}

						$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$kk.$create_id] = $tmp;
					}
				}
			}
		} else { // 從contactus_join1線上申請那邊來的
			// do nothing
		}

		$data_tmp['updatecontent'] = $updatecontent_tmp;
		//var_dump($data_tmp['updatecontent']);

		$create_id = 'c'; // 複製程式碼，所以採用同樣的寫法
		// 總共有10個欄位，5個區塊，每個區塊2筆
		$create_id_number = 0;
		for($j=1;$j<=5;$j++){

			// 每兩個聯絡人配一個more
			$tmp = $this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][1]['field'][$groupname.'_more_'];
			//$tmp['attr']['class'] .= $create_id.$create_id_number;

			if($this->data['def']['updatefield']['method'] == 'update'){
				if($j != 1){
					$tmp['attr_tr']['style'] = 'display:none';
				}
			} else {
				if($j != 2){
					$tmp['attr_tr']['style'] = 'display:none';
				}
			}
			$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$groupname.'_more_'.$create_id.$create_id_number] = $tmp;

			for($i=0;$i<=1;$i++){
				$tmpx = ''; // 因為等一下要做一次的動作
				foreach($this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][0]['field'] as $kk => $vv){
					// 在新增裡面，是不會有刪除按鈕的
					if(preg_match('/delete/', $kk)){
					   	//continue;
						$vv['type'] = 'inputn';
						$vv['other']['html'] = '';
					}

					if($tmpx == ''){
						$vv['label'] = '<i class="icon-plus '.$groupname.'_new" style="cursor:pointer"></i>&nbsp;'.$vv['label'];
					}
					$tmpx = '1';
					$tmp = $vv;
					if(isset($tmp['attr']['id'])) $tmp['attr']['id'] .= $create_id.$create_id_number;
					if(isset($tmp['attr']['name'])) $tmp['attr']['name'] .= $create_id.$create_id_number;

					// 在新增裡面，要手動按more，才會讓內容顯示
					if(preg_match('/'.$groupname.'_'.$fields[0].'_/', $kk)){
						if($this->data['def']['updatefield']['method'] == 'update'){
							$tmp['attr_tr']['style'] = 'display:none';
						} else {
							if($j == 1 and ($i == 0 or $i == 1)){
								// nothing
							} else {
								$tmp['attr_tr']['style'] = 'display:none';
							}
						}
					}

					$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$kk.$create_id.$create_id_number] = $tmp;
				}
				$create_id_number++;
			}

		}

		$data_tmp['def'] = $this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def'];

		// 這是範本，如果有select或是radio等欄位，別忘了要先給它空值之類的
		//$data_tmp['updatecontent']['membercontact_performance_c0'] = '';
		//$data_tmp['updatecontent']['membercontact_year_c0'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c1'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c2'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c3'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c4'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c5'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c6'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c7'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c8'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c9'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c10'] = '90';


		// 先備份所有的data
		$backup_data = $this->data;

		//var_dump($data_tmp);
		//die;

		// 切換
		$this->data = $data_tmp;
		$this->layout = 'empty';
		$tmp = $this->renderPartial('//default/update', $this->data, true);
		$this->layout = 'main';

		// 回復
		$this->data = $backup_data;

		// 只取得我需要的
		$html = str_get_html($tmp, true, true, DEFAULT_TARGET_CHARSET, false);
		$tmp_html = '';
		// 沒有這樣子的寫的話，會報錯哦
		if(0 and count($html->find('table')) > 0){
			$html->find('table', 0)->class = 'table1_need_change_'.$groupname;
			$tmp_html = $html->find('table', 0)->outertext;
		}

		$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['other']['html'] = $tmp_html;
	}

	/*
	 * 只是想把不同的修改1~5，合併在一起，試著在同一個資料表上
	 *
	 * @update_section 這個是新加的欄位，跟原本v1不一樣的地方
	 */
	protected function multi_field_v1sx($groupname, $tablename, $fields_pipe, $require_field, $section_number, $update_section)
	{
		/* 使用方式
		 * 1. 獨立使用section
		 * 2. membercontact是GROUPNAME
		 
				// section 2
				array(
					'form' => array('enable' => false),
					'type' => '1',
					//'section_title' => '聯絡人',
					'field' => array(
						'membercontact' => array(
							'label' => '評鑑',
							'type' => 'inputn',
							'attr' => array(
							),
							'attr_td1' => array(
								'width' => '160',
							),
							'other' => array(
								'html' => '',
							),
							// 欄位類型如下：
							// 有資料的欄位，有幾筆就幾個
							// 一次顯示兩組新增的欄位
							'def' => array(
								'updatefield' => array(
									// jquery-validate, jquery-datepicker
									'head' => array(
										'jquery-validate',
									),
									//'smarty_javascript' => '',
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
									'sections_sample' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												//'membercontact_name_' => array(
												//	'label' => '姓名*',
												//	'type' => 'input',
												//	'merge' => '1',
												//	'attr_tr' => array(
												//		'name' => 'membercontact', // 為了要做odd, even
												//	),
												//	'attr' => array(
												//		'id' => 'membercontact_name_',
												//		'name' => 'membercontact_name_',
												//		//'size' => '20',
												//		'class' => 'small_input',
												//	),
												//),
												'membercontact_year_' => array(
													'label' => '年度',
													'type' => 'select3',
													'merge' => '1.5', // 頭中尾的頭(1)
													'attr_tr' => array(
														'name' => 'membercontact', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'membercontact_year_',
														'name' => 'membercontact_year_',
													),
													'other' => array(
														//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
														//'default' => 'center',
														// Jonathan在1/28的早上11:38分所說的
														'values' => array(
															'90' => '90',
															'91' => '91',
															'92' => '92',
															'93' => '93',
															'94' => '94',
															'95' => '95',
															'96' => '96',
															'97' => '97',
															'98' => '98',
															'99' => '99',
															'100' => '100',
															'101' => '101',
															'102' => '102',
															'103' => '103',
															'104' => '104',
															'105' => '105',
															'106' => '106',
															'107' => '107',
															'108' => '108',
															'109' => '109',
															'110' => '110',
															'111' => '111',
															'112' => '112',
															'113' => '113',
															'114' => '114',
															'115' => '115',
															'116' => '116',
															'117' => '117',
															'118' => '118',
															'119' => '119',
															'120' => '120',
														),
														'default' => '90',
														//'html_start' => '年度',
														'html_end' => '　',
													),
												),
												'membercontact_performance_' => array(
													'label' => '*工程業績NT$',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'membercontact', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'membercontact_performance_',
														'name' => 'membercontact_performance_',
														//'size' => '20',
														'class' => 'small_input',
													),
												),
												'membercontact_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'membercontact_delete_',
														'value' => '1',
													),
													'other' => array(
														'label' => '刪除',
														//'html_end' => '</span>', // 這裡很特別，別以為寫錯了，只有尾巴而以
													),
												),
											),
										),
										// section 1
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'membercontact_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'membercontact_more_',
														'onclick' => 'javascript:$(this).parent().parent().next().show();  $(this).parent().parent().next().next().show();  $(this).parent().parent().next().next().next().show();  $(this).parent().parent().hide(); $(\'tr:odd[name=membercontact]\').attr(\'class\', \'bgcolor2\');  $(\'tr:even[name=membercontact]\').attr(\'class\', \'bgcolor1\');',
														'href' => 'javascript:void(0);'
													),
												),
												'end_' => array(
													'label' => '&nbsp;',
													'type' => 'inputn',
													'merge' => '3',
													'attr' => array(
													),
													'other' => array(
														'html' => '',
													),
												),
											),
										),
									),
									'sections' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
											),
										),
									),
								),
							),
						),
					),
				),
		 */

		$fields = explode('|', $fields_pipe);
		
		if(!empty($_POST)){
			$update = $_POST;
			$membercontacts = array();
			foreach($update as $k => $v){
				if(preg_match('/^'.$groupname.'_/', $k)){
					$tmps = explode('_', $k);
					if($tmps[1] == 'delete' and $v == '1'){
						$membercontacts[$tmps[2]]['is_enable'] = 0;
					} else {
						$membercontacts[$tmps[2]][$tmps[1]] = $v;
					}

					unset($update[$k]);
				}
			}

			if(count($membercontacts) > 0){
				foreach($membercontacts as $k => $v){
					// 類似必填欄位
					if($v[$require_field] == '') continue;

					// 新增
					if(substr($k, 0, 1) == 'c'){
						$v['data_id'] = $update[$groupname]['data_id'];
						$v['update_section'] = $update_section;
						//$v['is_enable'] = 1; // 預設值
						$v['create_time'] = date('Y-m-d H:i:s');
						$v['from_user_id'] = $update[$groupname]['from_user_id'];
						$this->cidb->insert($tablename, $v); 
					} else { // 修改
						//if(!isset($v['mainemail'])) $v['mainemail'] = 0;
						//if(!isset($v['maincontact'])) $v['maincontact'] = 0;
						$v['update_time'] = date('Y-m-d H:i:s');
						$this->cidb->where('id', $k);
						$this->cidb->update($tablename, $v); 
					}
				}
			}
			return true;
		}

		include_once 'simple_html_dom.php';


		/*
		 * 多筆
		 */

		// 測試一下
		//$updatecontent_tmp = array();

		$updatecontent_tmp = $this->data['updatecontent'];

		// 只留本群組該用到的updatecontent元素
		if($updatecontent_tmp){
			foreach($updatecontent_tmp as $k => $v){
				if(!preg_match('/^'.$groupname.'/', $k)){
					unset($updatecontent_tmp[$k]);
				}
			}
		}


		$data_tmp = $this->data;

		if($this->data['def']['updatefield']['method'] == 'update'){
			if(in_array('sort_id', $fields)){
				$rows = $this->db->createCommand()->from($tablename)->where('is_enable=1 and update_section=:section and data_id=:id', array('id'=>$this->data['updatecontent']['id'],'section'=>$update_section))->order('sort_id')->queryAll();
			} else {
				$rows = $this->db->createCommand()->from($tablename)->where('is_enable=1 and update_section=:section and data_id=:id', array('id'=>$this->data['updatecontent']['id'],'section'=>$update_section))->queryAll();
			}

			//var_dump($rows);
			//die;
			if($rows){
				foreach($rows as $k => $v){
					foreach($v as $kk => $vv){
						if(preg_match('/^('.$fields_pipe.'|id)$/', $kk)){
							$updatecontent_tmp[$groupname.'_'.$kk.'_'.$v['id']] = $vv;
						}
					}

					// 每一筆資料都會重建一次sections裡面的東西
					$create_id = $v['id']; // 複製程式碼，所以採用同樣的寫法
					$tmpx = ''; // 因為等一下要做一次的動作
					foreach($this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][0]['field'] as $kk => $vv){
						if($tmpx == ''){
							$vv['label'] = '&nbsp;'.$vv['label'];
						}
						$tmp = $vv;
						if(isset($tmp['attr']['id'])) $tmp['attr']['id'] .= $create_id;
						if(isset($tmp['attr']['name'])) $tmp['attr']['name'] .= $create_id;
						$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$kk.$create_id] = $tmp;
					}
				}
			}
		} else { // 從contactus_join1線上申請那邊來的
			// do nothing
		}

		$data_tmp['updatecontent'] = $updatecontent_tmp;
		//var_dump($data_tmp['updatecontent']);

		$create_id = 'c'; // 複製程式碼，所以採用同樣的寫法
		// 總共有10個欄位，5個區塊，每個區塊2筆
		$create_id_number = 0;
		for($j=1;$j<=5;$j++){

			// 每兩個聯絡人配一個more
			$tmp = $this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][1]['field'][$groupname.'_more_'];
			//$tmp['attr']['class'] .= $create_id.$create_id_number;

			if($this->data['def']['updatefield']['method'] == 'update'){
				if($j != 1){
					$tmp['attr_tr']['style'] = 'display:none';
				}
			} else {
				if($j != 2){
					$tmp['attr_tr']['style'] = 'display:none';
				}
			}
			$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$groupname.'_more_'.$create_id.$create_id_number] = $tmp;

			for($i=0;$i<=1;$i++){
				$tmpx = ''; // 因為等一下要做一次的動作
				foreach($this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][0]['field'] as $kk => $vv){
					// 在新增裡面，是不會有刪除按鈕的
					if(preg_match('/delete/', $kk)){
					   	//continue;
						$vv['type'] = 'inputn';
						$vv['other']['html'] = '';
					}

					if($tmpx == ''){
						$vv['label'] = '<i class="icon-plus '.$groupname.'_new" style="cursor:pointer"></i>&nbsp;'.$vv['label'];
					}
					$tmpx = '1';
					$tmp = $vv;
					if(isset($tmp['attr']['id'])) $tmp['attr']['id'] .= $create_id.$create_id_number;
					if(isset($tmp['attr']['name'])) $tmp['attr']['name'] .= $create_id.$create_id_number;

					// 在新增裡面，要手動按more，才會讓內容顯示
					if(preg_match('/'.$groupname.'_'.$fields[0].'_/', $kk)){
						if($this->data['def']['updatefield']['method'] == 'update'){
							$tmp['attr_tr']['style'] = 'display:none';
						} else {
							if($j == 1 and ($i == 0 or $i == 1)){
								// nothing
							} else {
								$tmp['attr_tr']['style'] = 'display:none';
							}
						}
					}

					$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$kk.$create_id.$create_id_number] = $tmp;
				}
				$create_id_number++;
			}

		}

		$data_tmp['def'] = $this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def'];

		// 這是範本，如果有select或是radio等欄位，別忘了要先給它空值之類的
		//$data_tmp['updatecontent']['membercontact_performance_c0'] = '';
		//$data_tmp['updatecontent']['membercontact_year_c0'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c1'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c2'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c3'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c4'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c5'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c6'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c7'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c8'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c9'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c10'] = '90';


		// 先備份所有的data
		$backup_data = $this->data;

		//var_dump($data_tmp);
		//die;

		// 切換
		$this->data = $data_tmp;
		$this->layout = 'empty';
		$tmp = $this->renderPartial('//default/update', $this->data, true);
		$this->layout = 'main';

		// 回復
		$this->data = $backup_data;

		// 只取得我需要的
		$html = str_get_html($tmp, true, true, DEFAULT_TARGET_CHARSET, false);
		$tmp_html = '';
		// 沒有這樣子的寫的話，會報錯哦
		if(count($html->find('table')) > 0){
			$html->find('table', 0)->class = 'table1_need_change_'.$groupname;
			$tmp_html = $html->find('table', 0)->outertext;
		}

		$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['other']['html'] = $tmp_html;
	}

}

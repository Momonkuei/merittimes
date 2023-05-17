<?php

class Rulev1Controller extends Controller {

	protected $def = array(
		//'table' => 'sys_model',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'sys_rule_v1',
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
				'label' => '頁面中文名稱',
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
			//'sort_id' => array(
			//	'label' => 'ml:Sort id',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
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
					'section_title' => '普 通 資 訊',
					'field' => array(
						'name' => array(
							'label' => '頁面中文名稱',
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

						// 存放各section是否顯示的狀態
						'section_0' => array('type'=>'hidden','attr'=>array('id' => 'section_0','name' => 'section_0')),
						'section_1' => array('type'=>'hidden','attr'=>array('id' => 'section_1','name' => 'section_1')),
						'section_2' => array('type'=>'hidden','attr'=>array('id' => 'section_2','name' => 'section_2')),
						'section_3' => array('type'=>'hidden','attr'=>array('id' => 'section_3','name' => 'section_3')),
						'section_4' => array('type'=>'hidden','attr'=>array('id' => 'section_4','name' => 'section_4')),
						'section_5' => array('type'=>'hidden','attr'=>array('id' => 'section_5','name' => 'section_5')),
						
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
//						'export' => array(
//							'label' => '匯出',
//							'type' => 'inputn',
//							'other' => array(
//'html' => '<a href="/_i/backend.php?r=funcv2/exportmethod&id=ID" onclick="return confirm(\'你確定？\')">Method</a>
//&nbsp; <a href="/_i/backend.php?r=funcv2/exportlayoutv2&id=ID" onclick="return confirm(\'你確定？\')">LayoutV2</a>',
//							),
//						),
					),
				),
				// 資料庫的欄位
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'section_title' => '資 料 庫 欄 位',
					'field' => array(
						'db1' => array(
							//'label' => '<a target="_blank" href="#">詳細...</a>',
							'type' => 'inputn',
							'attr' => array(
							),
							'attr_td1' => array(
								'width' => '1',
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
												'db1_description_' => array(
													'label' => '描述*',
													'type' => 'input',
													'merge' => '1.5',
													'attr_tr' => array(
														'name' => 'db1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'db1_description_',
														'name' => 'db1_description_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'db1_sort_id_' => array(
													'label' => '排序',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'db1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'db1_sort_id_',
														'name' => 'db1_sort_id_',
														'size' => '3',
														'class' => 'small_input',
														'placeholder' => '排序',
													),
												),
												'db1_type_' => array(
													'label' => '類型',
													'type' => 'select3',
													'merge' => '2', // 頭中尾的頭(1)
													'attr_tr' => array(
														'name' => 'db1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'db1_type_',
														'name' => 'db1_type_',
													),
													'other' => array(
														//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
														//'default' => 'center',
														'values' => array(
															0 => '請選擇',
															//'yii_query_builder' => 'yii_query_builder',
															//'ci_active_record' => 'ci_active_record',
														),
														'default' => '0',
														//'html_start' => '年度',
														'html_end' => '　',
													),
												),
												'db1_param1_' => array(
													'label' => '1',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'db1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'db1_param1_',
														'name' => 'db1_param1_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'db1_param2_' => array(
													'label' => '2',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'db1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'db1_param2_',
														'name' => 'db1_param2_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'db1_param3_' => array(
													'label' => '3',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'db1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'db1_param3_',
														'name' => 'db1_param3_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'db1_param4_' => array(
													'label' => '4',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'db1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'db1_param4_',
														'name' => 'db1_param4_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'db1_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'db1_delete_',
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
												'db1_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'db1_more_',
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
				// 規則的欄位
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'section_title' => '規 則 欄 位',
					'field' => array(
						'rule1' => array(
							//'label' => '<a target="_blank" href="#">詳細...</a>',
							'type' => 'inputn',
							'attr' => array(
							),
							'attr_td1' => array(
								'width' => '1',
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
												'rule1_description_' => array(
													'label' => '描述*',
													'type' => 'input',
													'merge' => '1.5',
													'attr_tr' => array(
														'name' => 'rule1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'rule1_description_',
														'name' => 'rule1_description_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'rule1_sort_id_' => array(
													'label' => '排序',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'rule1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'rule1_sort_id_',
														'name' => 'rule1_sort_id_',
														'size' => '3',
														'class' => 'small_input',
														'placeholder' => '排序',
													),
												),
												'rule1_type_' => array(
													'label' => '類型',
													'type' => 'select3',
													'merge' => '2', // 頭中尾的頭(1)
													'attr_tr' => array(
														'name' => 'rule1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'rule1_type_',
														'name' => 'rule1_type_',
													),
													'other' => array(
														//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
														//'default' => 'center',
														'values' => array(
															0 => '請選擇',
															//'str_get_html' => 'str_get_html',
															//'assign' => 'assign',
															//'renderPartial' => 'renderPartial',
															//'multiple_assign_root' => 'multiple_assign_root',
															//'multiple_assign_child' => 'multiple_assign_child',
															//'echo' => 'echo',
														),
														'default' => '0',
														//'html_start' => '年度',
														'html_end' => '　',
													),
												),
												'rule1_param1_' => array(
													'label' => '1',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'rule1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'rule1_param1_',
														'name' => 'rule1_param1_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'rule1_param2_' => array(
													'label' => '2',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'rule1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'rule1_param2_',
														'name' => 'rule1_param2_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'rule1_param3_' => array(
													'label' => '3',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'rule1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'rule1_param3_',
														'name' => 'rule1_param3_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'rule1_param4_' => array(
													'label' => '4',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'rule1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'rule1_param4_',
														'name' => 'rule1_param4_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'rule1_param5_' => array(
													'label' => '5',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'rule1', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'rule1_param5_',
														'name' => 'rule1_param5_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'rule1_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'rule1_delete_',
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
												'rule1_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'rule1_more_',
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
				// preview
				array(
					'form' => array('enable' => false),
					'type' => '1',
					//'attr_td1' => array(
					//	'width' => '1',
					//),
					'section_title' => '預 覽',
					'field' => array(
						'iframe01' => array(
							'label' => '&nbsp;',
							'type' => 'iframe',
							'attr' => array(
								'id' => 'iframe01',
								'width' => '100%',
								'height' => '700px',
							),
							'other' => array(
								'html_start' => '規則測試：<input id="ruletest" type="text" style="width:390px;margin-bottom:3px">',
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

		// 規則的集合，隨著版型的切換
		//if(!isset($this->data['sys_configs']['template_rulev1_group'])){
		//	$this->data['sys_configs']['template_rulev1_group'] = 'sys_rule_v1';
		//}

		// 隨著檔案而切換
		if($this->data['router_class'] == 'rulev1'){
			$this->data['sys_configs']['template_rulev1_group'] = 'sys_rule_v1';
		} elseif(preg_match('/^theme(.*)$/', $this->data['router_class'], $matches)){
			$this->data['sys_configs']['template_rulev1_group'] = 'theme_'.$matches[1];
		}

		$this->def['empty_orm_data']['table'] = $this->data['sys_configs']['template_rulev1_group'];

		//echo $this->data['router_class'];

		$this->data['section_map'] = array(
			'general' => 0,
			'dbfield' => 1,
			'rulefield' => 2,
			'preview' => 3,
		);

		/*
		 * 不要在底下的中間寫註解，不然可能會造成frontend_generate載入失敗
		 */
		$this->data['db_modules'] = array(
			'yii_query_builder' => array(
				'name' => 'Yii Query Builder',
				'param1' => '<br /><br />　　變數',
				'param1.other.html_end' => '＝ $this->db->createCommand()->',
				'param2' => '<br /><br />　　區段1',
				'param2.attr.size' => '40',
				'param2.other.html_end' => '例如 from(\'html\')',
				'param3' => '<br /><br />　　區段2',
				'param3.attr.size' => '40',
				'param3.other.html_end' => '例如 where(\'is_enable=1\')',
				'param4' => '<br /><br />　　區段3',
				'param4.attr.size' => '20',
				'param4.other.html_end' => '例如queryAll() 或是 queryRow()<br /><br />',
			),
			'yii_query_builder_for_html_table_with_ml_key' => array(
				'name' => 'Yii Query Builder For HTML資料表(多語系)',
				'param1' => '<br /><br />　　變數',
				'param2' => '<br /><br />　　TYPE',
				'param2.attr.size' => '20',
				'param2.other.html_end' => '例如aboutus',
				'param3' => '<br /><br />　　其它條件1',
				'param3.attr.size' => '40',
				'param3.other.html_end' => '例如 where(\'is_enable=1\')->',
				'param4' => '<br /><br />　　其它條件2',
				'param4.attr.size' => '40',
				'param4.other.html_end' => 'order(\'create_time desc\')',
				'param5' => '<br /><br />　　其它條件3',
				'param5.attr.size' => '40',
				'param5.other.html_end' => '例如queryAll() 或是 queryRow()<br /><br />',
			),
			'ci_active_record' => array(
				'name' => 'Codeigniter Active Record',
				'param1' => '<br /><br />　變數',
				'param1.other.html_end' => '＝ $this->cidb->',
				'param2' => '<br /><br />　區段1',
				'param2.attr.size' => '40',
				'param2.other.html_end' => '例如 from(\'html\')',
				'param3' => '<br /><br />　區段2',
				'param3.attr.size' => '40',
				'param3.other.html_end' => '例如 where(\'is_enable\', 1)',
				'param4' => '<br /><br />　區段3',
				'param4.attr.size' => '20',
				'param4.other.html_end' => '例如get() 或是 result_array() 、 row_array()<br /><br />',
			),
			'common_func' => array(
				'name' => '共用 | 來自於英文名稱 ( common_func )',
				'description.label' => '共用的英文名稱*',
				'param1' => '集合',
				'param1.attr.title' => '可以指定另一個集合的東西，也可以不指定',
				'param1.attr.placeholder' => '非必填',
				'param2' => '',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
			'common_description' => array(
				'name' => '共用 | 來自於描述 ( common_description )',
				'description.label' => '共用的描述*',
				'description.attr.title' => '記得隨便加一個全型空白，才不會match到自己',
				'param1' => '集合',
				'param1.attr.title' => '可以指定另一個集合的東西，也可以不指定',
				'param1.attr.placeholder' => '非必填',
				'param2' => '',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
		);

		/*
		 * 不要在底下的中間寫註解，不然可能會造成frontend_generate載入失敗
		 */
		$this->data['rule_modules'] = array(
			'str_get_html' => array(
				'name' => '將HTML檔案=>物件 ( str_get_html )',
				'param1' => '變數',
				'param2' => '　靜態頁面',
				'param2.attr.size' => '35',
				'param3' => '　綁定',
				'param3.attr.placeholder' => '非必填',
				'param3.attr.title' => '這個是系統設定的變數，會在靜態頁面欄位的前面附加上去，包含斜線，預留擴充所使用',
				'param4' => '　規則',
				'param4.other.html_end' => '限縮範圍',
				'param5' => '',
			),
			'str_get_html_content' => array(
				'name' => '將HTML內容=>物件 ( str_get_html_content )',
				'param1' => '變數',
				'param2' => '　內容',
				'param2.other.html_end' => '通常是後台在用',
				'param2.attr.title' => '例PHP:$this->data[gggaaa2]',
				'param2.attr.size' => '35',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
			'assign' => array(
				'name' => '指定 ( assign )',
				'param1' => '變數',
				'param2' => '　規則',
				'param2.attr.size' => '15',
				'param3' => '　值',
				'param3.attr.size' => '25',
				'param4' => '',
				'param5' => '',
			),
			'append_left' => array(
				'name' => '附加在左邊 ( append_left )',
				'param1' => '變數',
				'param2' => '　規則',
				'param3' => '　值',
				'param4' => '　左/右',
				'param4.other.html_end' => '1/2(預設1)',
				'param5' => '',
			),
			'get' => array(
				'name' => '取得 ( get )',
				'param1' => '<br /><br />　　目標變數',
				'param1.other.html_end' => '　＝',
				'param2' => '　變數',
				'param2.attr.size' => '15',
				'param2.other.html_end' => '　->　',
				'param3' => '　規則',
				'param3.attr.size' => '25',
				'param4' => '',
				'param5' => '',
			),
			'search_replace' => array(
				'name' => '搜尋取代',
				'param1' => '變數',
				'param2' => '　搜尋',
				'param3' => '　取代',
				'param4' => '',
				'param5' => '',
			),
			'search_replace_html' => array(
				'name' => '搜尋取代成放置HTML的方式',
				'param1' => '變數',
				'param2' => '　有哪些要這樣子做',
				'param2.other.html_end' => '例如css,js,images',
				'param3' => 'HTMLdir',
				'param4' => '',
				'param5' => '',
			),
			'common_func' => array(
				'name' => '共用 | 來自於英文名稱 ( common_func )',
				'description.label' => '共用的英文名稱*',
				'param1' => '集合',
				'param1.attr.title' => '可以指定另一個集合的東西，也可以不指定',
				'param1.attr.placeholder' => '非必填',
				'param2' => '',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
			'common_description' => array(
				'name' => '共用 | 來自於描述 ( common_description )',
				'description.label' => '共用的描述*',
				'description.attr.title' => '記得隨便加一個全型空白，才不會match到自己',
				'param1' => '集合',
				'param1.attr.title' => '可以指定另一個集合的東西，也可以不指定',
				'param1.attr.placeholder' => '非必填',
				'param2' => '',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
			'renderPartial' => array(
				'name' => '載入View ( renderPartial )',
				'param1' => '變數',
				'param2' => '　Yii View路徑',
				'param2.attr.title' => '例//aaa/bbb',
				'param2.attr.size' => '25',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
			'autogenerate' => array(
				'name' => '自動產生規則 ( autogenerate )',
				'param1' => '變數',
				'param1.other.html_end' => '　單筆：rulev1="single"、多筆：rulev1="multi、1、n,n,n...',
				'param2' => '',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
			'multiple_assign_root' => array(
				'name' => '多筆 / 基礎 ( multiple_assign_root )',
				'param1' => '<br /><br />　　變數(目標,回存)',
				'param2' => '<br /><br />　　資料來源',
				'param2.attr.size' => '25',
				'param3' => '<br /><br />　　目標的規則',
				'param3.attr.size' => '30',
				'param4' => '<br /><br />　　單筆的規則',
				'param4.attr.size' => '30',
				'param5' => '<br /><br />　　回存的規則',
				'param5.attr.size' => '30',
				'param5.other.html_end' => '<br /><br />',
			),
			'multiple_assign_child' => array(
				'name' => '多筆 / 指定 ( multiple_assign_child )',
				'description.label' => '　　 └　　關聯哪一個多筆：',
				'description.attr.title' => '別忘了一個全型空白要加在最前面',
				'param1' => '　規則',
				'param1.attr.size' => '15',
				'param2' => '　值',
				'param2.attr.size' => '25',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
			'kcfinder_get_files' => array(
				'name' => '編輯器取檔案 ( kcfinder_get_files )',
				'param1' => '從編號',
				'param1.attr.size' => '30',
				'param1.attr.placeholder' => '例如item12或是30',
				'param1.other.html_end' => ' => ',
				'param2' => '變數',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
			'yii_query_builder' => array(
				'name' => 'Yii Query Builder',
				'param1' => '<br /><br />　　變數',
				'param1.other.html_end' => '＝ $this->db->createCommand()->',
				'param2' => '<br /><br />　　區段1',
				'param2.attr.size' => '40',
				'param2.other.html_end' => '例如 from(\'html\')',
				'param3' => '<br /><br />　　區段2',
				'param3.attr.size' => '40',
				'param3.other.html_end' => '例如 where(\'is_enable=1\')',
				'param4' => '<br /><br />　　區段3',
				'param4.attr.size' => '20',
				'param4.other.html_end' => '例如queryAll() 或是 queryRow()<br /><br />',
				'param5' => '',
			),
			'yii_query_builder_for_html_table_with_ml_key' => array(
				'name' => 'Yii Query Builder For HTML資料表(多語系)',
				'param1' => '<br /><br />　　變數',
				'param2' => '<br /><br />　　TYPE',
				'param2.attr.size' => '20',
				'param2.other.html_end' => '例如aboutus',
				'param3' => '<br /><br />　　其它條件1',
				'param3.attr.size' => '40',
				'param3.other.html_end' => '例如 where(\'is_enable=1\')->',
				'param4' => '<br /><br />　　其它條件2',
				'param4.attr.size' => '40',
				'param4.other.html_end' => 'order(\'create_time desc\')',
				'param5' => '<br /><br />　　其它條件3',
				'param5.attr.size' => '40',
				'param5.other.html_end' => '例如queryAll() 或是 queryRow()<br /><br />',
			),
			'ci_active_record' => array(
				'name' => 'Codeigniter Active Record',
				'param1' => '<br /><br />　變數',
				'param1.other.html_end' => '＝ $this->cidb->',
				'param2' => '<br /><br />　區段1',
				'param2.attr.size' => '40',
				'param2.other.html_end' => '例如 from(\'html\')',
				'param3' => '<br /><br />　區段2',
				'param3.attr.size' => '40',
				'param3.other.html_end' => '例如 where(\'is_enable\', 1)',
				'param4' => '<br /><br />　區段3',
				'param4.attr.size' => '20',
				'param4.other.html_end' => '例如get() 或是 result_array() 、 row_array()<br /><br />',
				'param5' => '',
			),
			'echo' => array(
				'name' => '簡易輸出 ( echo )',
				'param1' => '變數',
				'param2' => '',
				'param3' => '',
				'param4' => '',
				'param5' => '',
			),
		);

		foreach($this->data['db_modules'] as $k => $v){
			$this->def['updatefield']['sections'][$this->data['section_map']['dbfield']]['field']['db1']['def']['updatefield']['sections_sample'][0]['field']['db1_type_']['other']['values'][$k] = $v['name'];
		}

		foreach($this->data['rule_modules'] as $k => $v){
			$this->def['updatefield']['sections'][$this->data['section_map']['rulefield']]['field']['rule1']['def']['updatefield']['sections_sample'][0]['field']['rule1_type_']['other']['values'][$k] = $v['name'];
		}

		return true;
	}

	/*
	 * 修改與新增，render前，常做的事情，我統一寫在這裡，這樣子寫一次就好了
	 */
	protected function getdata()
	{

		for($y=0;$y<=11;$y++){
			$this->data['updatecontent']['db1_type_c'.$y] = '0';
			$this->data['updatecontent']['rule1_type_c'.$y] = '0';
		}

		$this->multi_field_v1('db1', $this->data['sys_configs']['template_rulev1_group'].'_db', 'description|param1|param2|param3|param4|type|sort_id', 'description', $this->data['section_map']['dbfield']);
		$this->multi_field_v1('rule1', $this->data['sys_configs']['template_rulev1_group'].'_list', 'description|param1|param2|param3|param4|param5|type|sort_id', 'description', $this->data['section_map']['rulefield']);

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	protected function create_show_last()
	{
		$this->getdata();

	}

	protected function update_show_last($updatecontent)
	{
		// 試著外加類型的說明和屬性加進去 rule1
		// 參考資料： $this->data['updatecontent']['rule1_param2_2_attr_placeholder'] = '123';
		$rows = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_list')->where('is_enable=1 and data_id=:id', array('id'=>$this->data['updatecontent']['id']))->queryAll();
		foreach($rows as $k => $v){
			if($v['type'] == '') continue;
			if(isset($this->data['rule_modules'][$v['type']])){
				$vv = $this->data['rule_modules'][$v['type']];

				// 錨點
				$this->data['updatecontent']['rule1_description_'.$v['id'].'_label'] = '描述*<a name="tooltip_'.$this->data['sys_configs']['template_rulev1_group'].$v['id'].'_target"></a>';

				// paramX = ???
				for($x=1;$x<=5;$x++){
					if($vv['param'.$x] != ''){
						$this->data['updatecontent']['rule1_param'.$x.'_'.$v['id'].'_label'] = $vv['param'.$x].':';
					} else {
						$this->data['updatecontent']['rule1_param'.$x.'_'.$v['id'].'_attr_style'] = 'display:none';
						$this->data['updatecontent']['rule1_param'.$x.'_'.$v['id'].'_label'] = '';
					}
				}

				// paramX.AAA.BBB = ???
				foreach($vv as $kkk => $vvv){
					if(preg_match('/^(param.*|type|description|sort_id)\./', $kkk)){
						$tmp01 = explode('.', $kkk);
						//$num = str_replace('param', '', $tmp01[0]);
						$num = $tmp01[0];
						unset($tmp01[0]);
						$this->data['updatecontent']['rule1_'.$num.'_'.$v['id'].'_'.implode('_', $tmp01)] = $vvv;
					}
				}
			}
			// 處理共用
			if($v['type'] == 'common_func'){
				$return = '<br /><br />';
				//$template_rulev1_group = 'sys_rule_v1';
				$template_rulev1_group = $this->data['sys_configs']['template_rulev1_group'];
				if($v['param1'] != ''){
					$template_rulev1_group = $v['param1'];
				}
				$row = $this->db->createCommand()->from($template_rulev1_group)->where('is_enable=1 and func=:func', array(':func'=>$v['description']))->queryRow();
				if($row and isset($row['id'])){
					$rowsx = $this->db->createCommand()->from($template_rulev1_group.'_list')->where('is_enable=1 AND data_id=:id', array(':id'=>$row['id']))->order('sort_id')->queryAll();
					if($rowsx and count($rowsx) > 0){
						foreach($rowsx as $kkk => $vvv){
							if(!isset($this->data['rule_modules'][$vvv['type']])) continue;
							$vv = $this->data['rule_modules'][$vvv['type']];
							$return .= '　　└　描述：'.$vvv['description'].'　排序：'.$vvv['sort_id'];
							$return .= '　'.$vv['name'].'<br />';
							for($x=1;$x<=5;$x++){
								if($vv['param'.$x] != ''){
									//$return .= '　　　　'.$x.'：'.$vvv['param'.$x].'<br />';
									$y = $this->data['rule_modules'][$vvv['type']]['param'.$x];
									$y = str_replace('　','',$y);
									$y = str_replace('<br />','',$y);
									$return .= '　　　　'.$y.'：'.$vvv['param'.$x].'<br />';
								}
							}
							$return .= '<br />';
						}
					}
				}

				if(!isset($rowsx)){
					$rowsx = array();
				}

				// 最後，html想要加上toggle，內容才不會一長串
				$return = '<br /><a class="share_toggle_list_a_'.$k.'" href="javascript:;">[ 內容 ('.count($rowsx).'筆) ]</a><span class="share_toggle_list_'.$k.'" style="display:none">'.$return.'</span>';
				$return .= <<<XXX
<script type="text/javascript">
$(document).ready(function(){
$('.share_toggle_list_a_$k').click(function(){
	$('.share_toggle_list_$k').toggle();
});
});
</script>
XXX;

				$this->data['updatecontent']['rule1_delete_'.$v['id'].'_other_html_end'] = $return;
			} elseif($v['type'] == 'common_description'){
				$return = '<br /><br />';
				//$template_rulev1_group = 'sys_rule_v1';
				$template_rulev1_group = $this->data['sys_configs']['template_rulev1_group'];
				if($v['param1'] != ''){
					$template_rulev1_group = $v['param1'];
				}
				$rowsx = $this->db->createCommand()->from($template_rulev1_group.'_list')->where('is_enable=1 AND description=:description', array(':description'=>str_replace('　','',$v['description'])))->order('sort_id')->queryAll();
				if($rowsx and count($rowsx) > 0){
					foreach($rowsx as $kkk => $vvv){
						if(!isset($this->data['rule_modules'][$vvv['type']])) continue;
						$vv = $this->data['rule_modules'][$vvv['type']];
						$return .= '　　└　描述：'.$vvv['description'].'　排序：'.$vvv['sort_id'];
						$return .= '　'.$vv['name'].'<br />';
						for($x=1;$x<=5;$x++){
							if($vv['param'.$x] != ''){
								$return .= '　　　　'.$x.'：'.$vvv['param'.$x].'<br />';
							}
						}
						$return .= '<br />';
					}
				}
				$this->data['updatecontent']['rule1_delete_'.$v['id'].'_other_html_end'] = $return;
			} elseif($v['type'] == 'autogenerate'){
				$return = '<br /><br />';
				$filename = $updatecontent['func'];
				if($filename != ''){
					$filename = $this->data['sys_configs']['template_rulev1_group'].'-'.str_replace('/', '-', $filename);
					$filename .= '.php';
					$filename_path = Yii::getPathOfAlias('application').'/../web/controllers/'.$filename;
					if(file_exists($filename_path)){
						$tmpx = file_get_contents($filename_path);
						eval('?>'.$tmpx);
						$countx = 0;
						if($rowsx and count($rowsx) > 0){
							foreach($rowsx as $kkk => $vvv){
								if($vvv['is_enable'] == 0) continue;
								$countx++;
								if(!isset($this->data['rule_modules'][$vvv['type']])) continue;
								$vv = $this->data['rule_modules'][$vvv['type']];
								$return .= '　　└　描述：'.$vvv['description'].'　排序：'.$vvv['sort_id'];
								$return .= '　'.$vv['name'].'<br />';
								for($x=1;$x<=5;$x++){
									if($vv['param'.$x] != ''){
										//$return .= '　　　　'.$x.'：'.$vvv['param'.$x].'<br />';
										$y = $this->data['rule_modules'][$vvv['type']]['param'.$x];
										$y = str_replace('　','',$y);
										$y = str_replace('<br />','',$y);
										$return .= '　　　　'.$y.'：'.$vvv['param'.$x].'<br />';
									}
								}
								$return .= '<br />';
							}
						}

						// 最後，html想要加上toggle，內容才不會一長串
						$return = '<br /><a class="share_toggle_list_a_'.$k.'" href="javascript:;">[ 內容 ('.$countx.'筆) ]</a><span class="share_toggle_list_'.$k.'" style="display:none">'.$return.'</span>';
						$return .= <<<XXX
<script type="text/javascript">
$(document).ready(function(){
$('.share_toggle_list_a_$k').click(function(){
	$('.share_toggle_list_$k').toggle();
});
});
</script>
XXX;

						$this->data['updatecontent']['rule1_delete_'.$v['id'].'_other_html_end'] = $return;
					}
				}
			}
		}

		// 複製貼上以上的程式碼，然後小改一下而以
		$rows = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'].'_db')->where('is_enable=1 and data_id=:id', array('id'=>$this->data['updatecontent']['id']))->queryAll();
		foreach($rows as $k => $v){
			if($v['type'] == '') continue;
			if(isset($this->data['db_modules'][$v['type']])){
				$vv = $this->data['db_modules'][$v['type']];

				// paramX = ???
				for($x=1;$x<=4;$x++){
					if($vv['param'.$x] != ''){
						$this->data['updatecontent']['db1_param'.$x.'_'.$v['id'].'_label'] = $vv['param'.$x].':';
					} else {
						$this->data['updatecontent']['db1_param'.$x.'_'.$v['id'].'_attr_style'] = 'display:none';
						$this->data['updatecontent']['db1_param'.$x.'_'.$v['id'].'_label'] = '';
					}
				}

				// paramX.AAA.BBB = ???
				foreach($vv as $kkk => $vvv){
					if(preg_match('/^(param.*|type|description|sort_id)\./', $kkk)){
						$tmp01 = explode('.', $kkk);
						//$num = str_replace('param', '', $tmp01[0]);
						$num = $tmp01[0];
						unset($tmp01[0]);
						$this->data['updatecontent']['db1_'.$num.'_'.$v['id'].'_'.implode('_', $tmp01)] = $vvv;
					}
				}
			}
			// 處理共用
			if($v['type'] == 'common_func'){
				$return = '<br /><br />';
				//$template_rulev1_group = 'sys_rule_v1';
				$template_rulev1_group = $this->data['sys_configs']['template_rulev1_group'];
				if($v['param1'] != ''){
					$template_rulev1_group = $v['param1'];
				}
				$row = $this->db->createCommand()->from($template_rulev1_group)->where('is_enable=1 and func=:func', array(':func'=>$v['description']))->queryRow();
				if($row and isset($row['id'])){
					$rowsx = $this->db->createCommand()->from($template_rulev1_group.'_db')->where('is_enable=1 AND data_id=:id', array(':id'=>$row['id']))->order('sort_id')->queryAll();
					if($rowsx and count($rowsx) > 0){
						foreach($rowsx as $kkk => $vvv){
							$vv = $this->data['db_modules'][$vvv['type']];
							$return .= '　　└　描述：'.$vvv['description'].'　排序：'.$vvv['sort_id'];
							$return .= '　'.$vv['name'].'<br />';
							for($x=1;$x<=4;$x++){
								if($vv['param'.$x] != ''){
									$return .= '　　　　'.$x.'：'.$vvv['param'.$x].'<br />';
								}
							}
							$return .= '<br />';
						}
					}
				}
				$this->data['updatecontent']['db1_delete_'.$v['id'].'_other_html_end'] = $return;
			} elseif($v['type'] == 'common_description'){
				$return = '<br /><br />';
				//$template_rulev1_group = 'sys_rule_v1';
				$template_rulev1_group = $this->data['sys_configs']['template_rulev1_group'];
				if($v['param1'] != ''){
					$template_rulev1_group = $v['param1'];
				}
				$rowsx = $this->db->createCommand()->from($template_rulev1_group.'_db')->where('is_enable=1 AND description=:description', array(':description'=>str_replace('　','',$v['description'])))->order('sort_id')->queryAll();
				if($rowsx and count($rowsx) > 0){
					foreach($rowsx as $kkk => $vvv){
						$vv = $this->data['db_modules'][$vvv['type']];
						$return .= '　　└　描述：'.$vvv['description'].'　排序：'.$vvv['sort_id'];
						$return .= '　'.$vv['name'].'<br />';
						for($x=1;$x<=4;$x++){
							if($vv['param'.$x] != ''){
								$return .= '　　　　'.$x.'：'.$vvv['param'.$x].'<br />';
							}
						}
						$return .= '<br />';
					}
				}
				$this->data['updatecontent']['db1_delete_'.$v['id'].'_other_html_end'] = $return;
			}
		}

		$this->getdata();

		$this->data['def']['updatefield']['sections'][$this->data['section_map']['preview']]['field']['iframe01']['attr']['src'] = FRONTEND_DOMAIN.'/index.php?r='.$this->data['updatecontent']['func'];

		$iframeid = $this->data['section_map']['preview'];

		$iframeurl = FRONTEND_DOMAIN.'/index.php?r='.$this->data['updatecontent']['func'].'&ruletest=';

		$this->data['def']['updatefield']['smarty_javascript_text'] .= <<<XXX

$('.tools a').click(function(){
	var item_id = $(this).attr('item_id');
	var status = $(this).attr('class');
	// collapse 要存關
	// expand 要存開
	var save = 0;
	if(status == 'collapse'){
		save = 1;
	} else {
		save = 0;
	}
	$('#section_'+item_id).attr('value', save);
});

// 省一些畫面的空間
$('.container-fluid').find('.row').eq(0).remove();

// 砍掉iframe左邊的空間
$('a[item_id=$iframeid]').parent().parent().parent().find('td').eq(0).remove();

// 規則測試
$('#ruletest').change(function(){
	$('#iframe01').attr('src', '$iframeurl'+$('#ruletest').attr('value'));
});

XXX;

		foreach($this->data['section_map'] as $k => $v){
			if($this->data['updatecontent']['section_'.$v] == 1){
				$this->data['def']['updatefield']['sections'][$v]['section_disable'] = true;
			}
		}


	}

	protected function update_run_last()
	{
		$_POST['db1']['data_id'] = $this->data['id'];
		$_POST['db1']['from_user_id'] = $_SESSION['authw_admin_id'];
		$this->multi_field_v1('db1', $this->data['sys_configs']['template_rulev1_group'].'_db', 'description|param1|param2|param3|param4|type|sort_id', 'description', $this->data['section_map']['dbfield']);

		$_POST['rule1']['data_id'] = $this->data['id'];
		$_POST['rule1']['from_user_id'] = $_SESSION['authw_admin_id'];
		$this->multi_field_v1('rule1', $this->data['sys_configs']['template_rulev1_group'].'_list', 'description|param1|param2|param3|param4|param5|type|sort_id', 'description', $this->data['section_map']['rulefield']);
	}

	protected function create_run_last()
	{
		$_POST['db1']['data_id'] = $this->data['_last_insert_id'];
		$_POST['db1']['from_user_id'] = $_SESSION['authw_admin_id'];
		$this->multi_field_v1('db1', $this->data['sys_configs']['template_rulev1_group'].'_db', 'description|param1|param2|param3|param4|type|sort_id', 'description', $this->data['section_map']['dbfield']);

		$_POST['rule1']['data_id'] = $this->data['_last_insert_id'];
		$_POST['rule1']['from_user_id'] = $_SESSION['authw_admin_id'];
		$this->multi_field_v1('rule1', $this->data['sys_configs']['template_rulev1_group'].'_list', 'description|param1|param2|param3|param4|type|sort_id', 'description', $this->data['section_map']['rulefield']);
	}

}

<?php

class Funcfieldv2update1Controller extends Controller {

	protected $def = array(
		'table' => 'sys_func_v2_update',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'sys_func_v2_update',
			//'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'condition' => array(
			array(
				'where',
				'',
			),
		),
		'sortable' => array(
			'enable' => 'true',
			'condition' => '', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=funcfieldv2update1/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			'xxx01' => array(
				'label' => '',
				'width' => '7%',
				'ezdelete' => true,
			),
			'name' => array(
				'label' => '欄位名稱',
				'width' => '25%',
				'sort' => true,
			),
			'keyname' => array(
				'label' => '英文',
				'width' => '15%',
				'sort' => true,
			),
			'type' => array(
				'label' => '類型',
				'width' => '15%',
				'sort' => true,
				'align' => 'center',
			),
			'db' => array(
				'label' => 'DB',
				'width' => '5%',
				'sort' => false,
				'align' => 'center',
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
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			//'smarty_javascript' => 'product/update_javascript.htm',
			'method' => 'update',
			'form' => array(
				'enable' => false,
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
					'form' => array(
						'enable' => true,
						'attr' => array(
							'id' => 'form_data1',
							'name' => 'form_data',
							'method' => 'post',
							'action' => '',
						),
					),
					'type' => '1',
					'section_title' => '一般設定：',
					'field' => array(
						'name' => array(
							'label' => '欄位名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '40',
							),
						),
						'keyname' => array(
							'label' => '英文',
							'type' => 'input',
							'attr' => array(
								'id' => 'keyname',
								'name' => 'keyname',
								'size' => '40',
							),
						),
						'type' => array(
							'label' => '類型',
							'type' => 'select3',
							'attr' => array(
								'id' => 'type',
								'name' => 'type',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'default' => '0',
								//'html_start' => '年度',
								'html_end' => '　',
							),
						),
						'update_section' => array(
							'label' => '第幾區',
							'type' => 'input',
							'attr' => array(
								'id' => 'update_section',
								'name' => 'update_section',
								'size' => '3',
							),
							'other' => array(
								'html_end' => '1 ~ 5',
							),
						),
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'mlabel' => array(
								null, // category
								'Sort', // label
								array(), // sprintf
								'排序', // default
							),
							'type' => 'sort',
							'attr' => array(
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
						'hidden_id' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'hidden_id',
							),
						),
						'prev_url' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'prev_url',
							),
						),
						'submit01' => array(
							'label' => '&nbsp;',
							'type' => 'button',
							'attr' => array(
								'type' => 'submit',
								'class' => 'btn green',
								'label' => '儲存',
								//'i' => 'icon-ok',
							),
						),
					),
				),
				// attr欄位
				array(
					'form' => array(
						'enable' => true,
						'attr' => array(
							'id' => 'form_data2',
							'name' => 'form_data',
							'method' => 'post',
							'action' => '',
						),
					),
					'type' => '1',
					'section_title' => 'HTML屬性的進階設定：',
					'section_disable' => true,
					'field' => array(
						'updatefield01' => array(
							'label' => 'HTML屬性',
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
												'updatefield01_keyname_' => array(
													'label' => '欄位屬性*',
													'type' => 'input',
													'merge' => '1.5',
													'attr_tr' => array(
														'name' => 'updatefield01', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'updatefield01_keyname_',
														'name' => 'updatefield01_keyname_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'updatefield01_keyvalue_' => array(
													'label' => '值',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'updatefield01', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'updatefield01_keyvalue_',
														'name' => 'updatefield01_keyvalue_',
														'size' => '30',
														'class' => 'small_input',
													),
												),
												'updatefield01_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'updatefield01_delete_',
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
												'updatefield01_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'updatefield01_more_',
														'onclick' => 'javascript:$(this).parent().parent().next().show();  $(this).parent().parent().next().next().show();  $(this).parent().parent().next().next().next().show();  $(this).parent().parent().hide(); $(\'tr:odd[name=updatefield01]\').attr(\'class\', \'bgcolor2\');  $(\'tr:even[name=updatefield01]\').attr(\'class\', \'bgcolor1\');',
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
						'hidden_id' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'hidden_id',
							),
						),
						'prev_url' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'prev_url',
							),
						),
						'submit01' => array(
							'label' => '&nbsp;',
							'type' => 'button',
							'attr' => array(
								'type' => 'submit',
								'class' => 'btn green',
								'label' => '儲存',
								//'i' => 'icon-ok',
							),
						),
					),
				),
				// other欄位
				array(
					'form' => array(
						'enable' => true,
						'attr' => array(
							'id' => 'form_data2',
							'name' => 'form_data',
							'method' => 'post',
							'action' => '',
						),
					),
					'type' => '1',
					'section_title' => '其它屬性的進階設定：',
					'section_disable' => true,
					'field' => array(
						'updateother01' => array(
							'label' => '其它屬性',
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
												'updateother01_keyname_' => array(
													'label' => '欄位屬性*',
													'type' => 'input',
													'merge' => '1.5',
													'attr_tr' => array(
														'name' => 'updateother01', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'updateother01_keyname_',
														'name' => 'updateother01_keyname_',
														'size' => '10',
														'class' => 'small_input',
													),
												),
												'updateother01_keyvalue_' => array(
													'label' => '值',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'updateother01', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'updateother01_keyvalue_',
														'name' => 'updateother01_keyvalue_',
														'size' => '30',
														'class' => 'small_input',
													),
												),
												'updateother01_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'updateother01_delete_',
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
												'updateother01_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'updateother01_more_',
														'onclick' => 'javascript:$(this).parent().parent().next().show();  $(this).parent().parent().next().next().show();  $(this).parent().parent().next().next().next().show();  $(this).parent().parent().hide(); $(\'tr:odd[name=updateother01]\').attr(\'class\', \'bgcolor2\');  $(\'tr:even[name=updateother01]\').attr(\'class\', \'bgcolor1\');',
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
						'hidden_id' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'hidden_id',
							),
						),
						'prev_url' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'prev_url',
							),
						),
						'submit01' => array(
							'label' => '&nbsp;',
							'type' => 'button',
							'attr' => array(
								'type' => 'submit',
								'class' => 'btn green',
								'label' => '儲存',
								//'i' => 'icon-ok',
							),
						),
					),
				),
				// section
				array(
					'form' => array(
						'enable' => true,
						'attr' => array(
							'id' => 'form_data2',
							'name' => 'form_data',
							'method' => 'post',
							'action' => '',
						),
					),
					'type' => '1',
					'section_title' => '欄位屬性：',
					'field' => array(
						'sample' => array(
							'label' => '欄位範本',
							'type' => 'input',
							'attr' => array(
								'id' => 'sample',
								'name' => 'sample',
								'size' => '40',
							),
						),
						'hidden_id' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'hidden_id',
							),
						),
						'prev_url' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'prev_url',
							),
						),
						'submit01' => array(
							'label' => '&nbsp;',
							'type' => 'button',
							'attr' => array(
								'type' => 'submit',
								'class' => 'btn blue',
								'label' => '儲存',
								//'i' => 'icon-ok',
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

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'is_enable=1 AND update_section='.str_replace('update', '', 'update1').' AND data_id=\''.$_SESSION['funcv2_editfield_id_update1'].'\' ';
		$this->def['sortable']['condition'] = ' is_enable=1 AND update_section='.str_replace('update', '', 'update1').' AND data_id="'.$_SESSION['funcv2_editfield_id_update1'].'"';

		return true;
	}

	protected function index_last()
	{   

		$row = $this->db->createCommand()->from('sys_func_v2')->where('id='.$_SESSION['funcv2_editfield_id_update1'])->queryRow();

		//var_dump($this->data['listcontent']);
		if(count($this->data['listcontent']) > 0){
			foreach($this->data['listcontent'] as $k => $v){
				if(G::check_table_field_exists($row['func'], $v['keyname'])){
					$this->data['listcontent'][$k]['db'] = 'V';
				}
			}
		}
	}   


	protected function getdata()
	{
		// 取得欄位型態(暫時關掉)
		//$rows_tmp = $this->db->createCommand()->from('sys_func_fields')->queryAll();
		//$rows = array();
		//if(count($rows_tmp) > 0){
		//	foreach($rows_tmp as $k => $v){
		//		$rows[$v['name']] = $v['description'].' ('.$v['name'].')';
		//	}
		//}

		$rows = $this->return_funcv2_field();
		$this->data['def']['updatefield']['sections'][0]['field']['type']['other']['values'] = $rows;

		$this->multi_field_v1('updatefield01', 'sys_func_v2_update_attr', 'keyname|keyvalue', 'keyname', 1);
		$this->multi_field_v1('updateother01', 'sys_func_v2_update_other', 'keyname|keyvalue', 'keyname', 2);

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	protected function update_show_last($updatecontent)
	{
		$this->getdata();

		$this->data['router_method_view'] = '1';
		$this->data['updatecontent']['hidden_id'] = $updatecontent['id'];
		$this->data['updatecontent']['prev_url'] = $this->data['current_url'].'&param=v'.$updatecontent['id'].'-a'.$this->data['params']['prev'];

		/*
		 * 產生欄位屬性，來自於各欄位的模組設定
		 */

		// 先清空
		$sample = $this->data['def']['updatefield']['sections'][3]['field']['sample'];
		$submit = $this->data['def']['updatefield']['sections'][3]['field']['submit01'];
		$this->data['def']['updatefield']['sections'][3]['field'] = array();

		// 取得己存在的值
		$rows = $this->db->createCommand()->from($this->data['def']['empty_orm_data']['table'].'_attr')->where('is_enable = 1 AND data_id = '.$updatecontent['id'])->queryAll();
		$attr_exists_tmp = array();
		if(isset($rows) and count($rows) > 0){
			foreach($rows as $k => $v){
				$attr_exists_tmp[$v['keyname']] = $v;
			}
		}
		$rows = $this->db->createCommand()->from($this->data['def']['empty_orm_data']['table'].'_other')->where('is_enable = 1 AND data_id = '.$updatecontent['id'])->queryAll();
		$other_exists_tmp = array();
		$emptyorm_rules_exists_tmp = array();
		if(isset($rows) and count($rows) > 0){
			foreach($rows as $k => $v){
				if($v['keyname'] == 'emptyorm_rules'){
					$emptyorm_rules_exists_tmp[$v['keyvalue']] = true;
				} else {
					$other_exists_tmp[$v['keyname']] = $v;
				}
			}
		}

		// 讀取此欄位的模組設定
		$tmp = Yii::getPathOfAlias('webroot.themes.admin_yiiv_3.views.default.updatefields').'/'.$updatecontent['type'].'.php';
		if(file_exists($tmp)){
			$this->data['vv_type_kk'] = '';
			$this->data['vv_type_vv'] = '';
			$tmp_module_config = array();
			include $tmp;
			if(isset($tmp_module_config['fields']) and count($tmp_module_config['fields']) > 0){
				foreach($tmp_module_config['fields'] as $k => $v){
					/*
					 * 'html__name' => 'NAME|comment1',
					 * 'other__merge' => '合併左右欄位|comment2',
					 */
					$tmp01 = explode('__', $k);
					$tmp02 = explode('|', $v);

					/*
						'sample' => array(
							'label' => '欄位範本',
							'type' => 'input',
							'attr' => array(
								'id' => 'sample',
								'name' => 'sample',
								'size' => '40',
							),
						),
					 */
					$sample01 = $sample;
					$sample01['label'] = $tmp02[0];
					//$sample01['label'] = strtoupper($tmp01[0]).'|'.$tmp02[0];

					// 在包一層
					$sample01['attr']['id'] = 'ui__'.$k; 
					$sample01['attr']['name'] = 'ui__'.$k; 
					$sample01['other']['html_end'] = $tmp02[1];

					// 取得己存在的值
					if(isset($attr_exists_tmp[$tmp01[1]])){
						$sample01['attr']['placeholder'] = $attr_exists_tmp[$tmp01[1]]['keyvalue']; 
					}
					if(isset($other_exists_tmp[$tmp01[1]])){
						$sample01['attr']['placeholder'] = $other_exists_tmp[$tmp01[1]]['keyvalue']; 
					}
					if($tmp01[0] == 'emptyorm_rules' and isset($emptyorm_rules_exists_tmp[$tmp01[1]])){
						$sample01['attr']['placeholder'] = $emptyorm_rules_exists_tmp[$tmp01[1]]; 
					}

					$this->data['def']['updatefield']['sections'][3]['field']['ui__'.$k] = $sample01;
				}
				$this->data['def']['updatefield']['sections'][3]['field']['hidden_id'] = array(
					'type' => 'hidden',
					'attr' => array(
						'name' => 'hidden_id',
					),
				);
				$this->data['def']['updatefield']['sections'][3]['field']['prev_url'] = array(
					'type' => 'hidden',
					'attr' => array(
						'name' => 'prev_url',
					),
				);
				$this->data['def']['updatefield']['sections'][3]['field']['submit01'] = $submit;
			}
		}

		if(count($this->data['def']['updatefield']['sections'][3]['field']) <= 0){
			$this->data['def']['updatefield']['sections'][1]['section_disable'] = false;
			$this->data['def']['updatefield']['sections'][2]['section_disable'] = false;
		}
	}

	protected function create_show_last()
	{
		$this->getdata();
	}

	protected function update_run_other_element($array)
	{
		$array['data_id'] = $_SESSION['funcv2_editfield_id_update1'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['data_id'] = $_SESSION['funcv2_editfield_id_update1'];
		return $array;
	}

	protected function update_run_last()
	{
		$_POST['updatefield01']['data_id'] = $this->data['id'];
		$_POST['updatefield01']['from_user_id'] = $_SESSION['authw_admin_id'];
		$this->multi_field_v1('updatefield01', 'sys_func_v2_update_attr', 'keyname|keyvalue', 'keyname', 1);

		$_POST['updateother01']['data_id'] = $this->data['id'];
		$_POST['updateother01']['from_user_id'] = $_SESSION['authw_admin_id'];
		$this->multi_field_v1('updateother01', 'sys_func_v2_update_other', 'keyname|keyvalue', 'keyname', 2);

		// 覆寫，如果欄位值有存在的話
		if(isset($_POST) and count($_POST) > 0){
			foreach($_POST as $k => $v){
				if(preg_match('/^ui__(.*)$/', $k, $matches)){
					if($v == '') continue;
					$tmp01 = explode('__', $matches[1]);
					if($tmp01[0] == 'html'){
						$sql = 'DELETE FROM `'.$this->data['def']['empty_orm_data']['table'].'_attr` WHERE data_id = '.$this->data['id'].' and keyname = :keyname';
						$db = Yii::app()->db;
						$command=$db->createCommand($sql);
						//$command->bindParam(":data_id",$k,PDO::PARAM_STR);
						$command->bindParam(":keyname",$tmp01[1],PDO::PARAM_STR);
						$command->execute();

						$save['keyname'] = $tmp01[1];
						$save['keyvalue'] = $v;
						$save['data_id'] = $this->data['id'];
						//$save['is_enable'] = 1; // 預設值
						$save['create_time'] = date('Y-m-d H:i:s');
						$save['from_user_id'] = Yii::app()->session['auth_admin_id'];
						$this->cidb->insert($this->data['def']['empty_orm_data']['table'].'_attr', $save); 
					} elseif($tmp01[0] == 'other'){
						$sql = 'DELETE FROM `'.$this->data['def']['empty_orm_data']['table'].'_other` WHERE data_id = '.$this->data['id'].' and keyname = :keyname';
						$db = Yii::app()->db;
						$command=$db->createCommand($sql);
						//$command->bindParam(":data_id",$k,PDO::PARAM_STR);
						$command->bindParam(":keyname",$tmp01[1],PDO::PARAM_STR);
						$command->execute();

						$save['keyname'] = $tmp01[1];
						$save['keyvalue'] = $v;
						$save['data_id'] = $this->data['id'];
						//$save['is_enable'] = 1; // 預設值
						$save['create_time'] = date('Y-m-d H:i:s');
						$save['from_user_id'] = Yii::app()->session['auth_admin_id'];
						$this->cidb->insert($this->data['def']['empty_orm_data']['table'].'_other', $save); 
					} elseif($tmp01[0] == 'emptyorm_rules'){
						$sql = 'DELETE FROM `'.$this->data['def']['empty_orm_data']['table'].'_other` WHERE data_id = '.$this->data['id'].' and keyname = :keyname and keyvalue = :keyvalue';
						$db = Yii::app()->db;
						$command=$db->createCommand($sql);
						//$command->bindParam(":data_id",$k,PDO::PARAM_STR);
						$command->bindParam(":keyname",$tmp01[0],PDO::PARAM_STR);
						$command->bindParam(":keyvalue",$tmp01[1],PDO::PARAM_STR);
						$command->execute();

						if($v){
							$save['keyname'] = $tmp01[0];
							$save['keyvalue'] = $tmp01[1];
							$save['data_id'] = $this->data['id'];
							//$save['is_enable'] = 1; // 預設值
							$save['create_time'] = date('Y-m-d H:i:s');
							$save['from_user_id'] = Yii::app()->session['auth_admin_id'];
							$this->cidb->insert($this->data['def']['empty_orm_data']['table'].'_other', $save); 
						}
					}
				}
			}
		}
	}

	protected function create_run_last()
	{
		$_POST['updatefield01']['data_id'] = $this->data['_last_insert_id'];
		$_POST['updatefield01']['from_user_id'] = $_SESSION['authw_admin_id'];
		$this->multi_field_v1('updatefield01', 'sys_func_v2_update_attr', 'keyname|keyvalue', 'keyname', 1);

		$_POST['updateother01']['data_id'] = $this->data['_last_insert_id'];
		$_POST['updateother01']['from_user_id'] = $_SESSION['authw_admin_id'];
		$this->multi_field_v1('updateother01', 'sys_func_v2_update_attr', 'keyname|keyvalue', 'keyname', 2);
	}

}

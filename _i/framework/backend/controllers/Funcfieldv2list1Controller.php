<?php

class Funcfieldv2list1Controller extends Controller {

	protected $def = array(
		'table' => 'sys_func_v2_list1',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'sys_func_v2_list1',
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
			'url' => 'backend.php?r=funcfieldv2list1/sort', // ajax post都會有個目標
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
				'width' => '38%',
				'sort' => true,
			),
			'keyname' => array(
				'label' => '英文',
				'width' => '15%',
				'sort' => true,
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
					),
				),
				// attr欄位
				array(
					'form' => array('enable' => false),
					'type' => '1',
					//'section_title' => '聯絡人',
					'field' => array(
						'updatefield01' => array(
							'label' => '屬性',
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
														'size' => '10',
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
		$this->def['condition'][0][1] = 'is_enable=1 AND data_id=\''.$_SESSION['funcv2_listfield_id_list1'].'\' ';
		$this->def['sortable']['condition'] = ' is_enable=1 AND data_id="'.$_SESSION['funcv2_listfield_id_list1'].'"';

		return true;
	}

	protected function index_last()
	{   

		$row = $this->db->createCommand()->from('sys_func_v2')->where('id='.$_SESSION['funcv2_listfield_id_list1'])->queryRow();

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
		$this->multi_field_v1('updatefield01', 'sys_func_v2_list1_attr', 'keyname|keyvalue', 'keyname', 1);
	}

	protected function update_show_last($updatecontent)
	{
		$this->getdata();
	}

	protected function create_show_last()
	{
		$this->getdata();
	}

	protected function update_run_other_element($array)
	{
		$array['data_id'] = $_SESSION['funcv2_listfield_id_list1'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['data_id'] = $_SESSION['funcv2_listfield_id_list1'];
		return $array;
	}

	protected function update_run_last()
	{
		$_POST['updatefield01']['data_id'] = $this->data['id'];
		$_POST['updatefield01']['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
		$this->multi_field_v1('updatefield01', 'sys_func_v2_list1_attr', 'keyname|keyvalue', 'keyname', 1);
	}

	protected function create_run_last()
	{
		$_POST['updatefield01']['data_id'] = $this->data['_last_insert_id'];
		$_POST['updatefield01']['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
		$this->multi_field_v1('updatefield01', 'sys_func_v2_list1_attr', 'keyname|keyvalue', 'keyname', 1);
	}

}

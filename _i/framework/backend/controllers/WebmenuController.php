<?php

class WebmenuController extends Controller {

	protected $def = array(
		//'title' => 'ml:Product',
		'table' => 'html',
		//'orm' => 'G_html_orm',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('topic'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'topic', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'topic', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'data_multilanguage_update' => 'model', // 在資料內頁中，切換多國語系，依照某一個欄位
		//'condition' => array(
		//	array(
		//		'where',
		//		'type="exhibition"',
		//	),
		//),
		'enable_delete' => true, // 多選刪除
		'sortable' => array(
			'enable' => 'true',
			//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=webmenu/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		//'multifile_upload' => array(
		//	'newspic' => array(
		//		'table' => 'news_image',
		//		'relation_field_name' => 'news_id',
		//		'pic_field_name' => 'pic',
		//		'store_dir_name' => 'news_image',
		//		'section_id' => 1,
		//	),
		//),
		'listfield' => array(
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			'topic' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '30%',
				'sort' => true,
			),
			'other1' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title2', // label
					array(), // sprintf
					'英文標題', // default
				),
				'width' => '30%',
				'sort' => true,
			),
			/*
			'other3' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title3', // label
					array(), // sprintf
					'標題3', // default
				),
				'width' => '20%',
				'sort' => true,
			),
			
			'other4' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title3', // label
					array(), // sprintf
					'日文', // default
				),
				'width' => '20%',
				'sort' => true,
			),
			*/
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
				'jquery-validate', 
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
						//'ml_key' => array(
						//	'label' => '語系',
						//	'type' => 'mls',
						//),
						'topic' => array(
							//'label' => '標題',
							'mlabel' => array(
								null, // category
								'Title', // label
								array(), // sprintf
								'標題', // default
							),
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'other1' => array(
							//'label' => '標題',
							'mlabel' => array(
								null, // category
								'Title2', // label
								array(), // sprintf
								'標題(英文語系用)', // default
							),
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '40',
							),
						),
						/*
						'other3' => array(
							'label' => '標題(簡體中文語系用)',
							'type' => 'input',
							'attr' => array(
								'id' => 'other3',
								'name' => 'other3',
								'size' => '40',
							),
						),
						'other4' => array(
							'label' => '標題(日文語系用)',
							'type' => 'input',
							'attr' => array(
								'id' => 'other4',
								'name' => 'other4',
								'size' => '40',
							),
						),
						*/
						'url1' => array(
							'label' => '網址',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'url1',
								'name' => 'url1',
								'size' => '50',
							),
						),						
						'pic1' => array(
							'label' => '圖片上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '120',
								'height' => '120',
								'comment_size' => '120x120',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'other2' => array(
							'label' => '開啟網址對象ID',
							'type' => 'input',
							'attr' => array(
								'id' => 'other2',
								'name' => 'other2',
								'size' => '40',
							),
						),
						'field_tmp' => array(
							'label' => '哪些區域顯示',
							//'type' => 'multiselect',
							'type' => 'multicheckbox',
							'attr' => array(
								'type'=>'checkbox',
								//'id' => 'field_tmp',
								'name' => 'field_tmp[]',
								//'size' => '3',
							),
							'other' => array(
								'split' => '',
								'split2' => '<br />',
								'count' => 5,
								'values' => array(),
								//'default' => 'center',
							),							
							/*
							'other2' => array(
								'1' => '頁首',
								'2' => '頁尾',
								'3' => '手機選單',
							),
							*/
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
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						//'newspic' => array(
						//	'label' => '圖片',
						//	'type' => 'fileuploader_multi',
						//	'other' => array(
						//		'type' => 'image',
						//		'number' => '1',
						//		'width' => '150',
						//		'height' => '150',
						//		'comment_size' => '400x400',
						//		'no_ext' => '',
						//	),
						//	'other2' => array(
						//		'topic' => array(
						//			'type' => 'text',
						//			'label' => '標題',
						//		),
						//		//'is_home' => array(
						//		//	'type' => 'radio',
						//		//	'label' => '首頁',
						//		//	'other' => array(
						//		//		array(
						//		//			'label' => '顯示',
						//		//			'value' => '1',
						//		//		),
						//		//		array(
						//		//			'label' => '不顯示',
						//		//			'value' => '0',
						//		//		),
						//		//	),
						//		//),
						//	),
						//),
						//'detail' => array(
						//	'label' => '描述',
						//	'type' => 'ckeditor_js',
						//	'attr' => array(
						//		'id' => 'detail',
						//		'name' => 'detail',
						//	),
						//),
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
		//$this->def['condition'][0][1] = 'type=\'webmenu\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$this->def['sortable']['condition'] = 'type="webmenu" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';
		$this->def['condition'][0][1] = 'type=\'webmenu\'  ';
		$this->def['sortable']['condition'] = 'type="webmenu" ';

		return true;
	}

	protected function getdata()
	{
		$tmp = array();
		/*
		if(isset($this->data['updatecontent']['field_tmp']) and $this->data['updatecontent']['field_tmp'] != ''){
			$tmp = explode(',', $this->data['updatecontent']['field_tmp']);
			if(count($tmp) >= 3){
				unset($tmp[count($tmp)-1]);
				unset($tmp[0]);
			}
		}

		$rows = $this->data['def']['updatefield']['sections'][0]['field']['field_tmp']['other2'];
		$heads = array();
		foreach($rows as $k => $v){
			$heads[$k]['value'] = $v;
			if(in_array($k, $tmp)){
				$heads[$k]['is_selected'] = 'selected';
			}
		}
		$this->data['updatecontent']['field_tmp'] = $heads;
		*/

	}

	protected function create_show_last()
	{
		//$this->getdata();
		$groups = array();		
		$groups[1]['value'] = '頁首';
		$groups[2]['value'] = '頁尾';
		$groups[3]['value'] = '手機選單';	
		$this->data['updatecontent']['field_tmp'] = $groups;
	}

	protected function update_show_last($updatecontent)
	{
		//$this->getdata();
		$groups = array();
		$tmp = explode(',', $this->data['updatecontent']['field_tmp']);
		$groups[1]['value'] = '頁首';
		$groups[2]['value'] = '頁尾';
		$groups[3]['value'] = '手機選單';
		if(in_array('1', $tmp)){
			//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
			$groups[1]['is_checked'] = 'checked'; // multicheckbox
		}
		if(in_array('2', $tmp)){
			//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
			$groups[2]['is_checked'] = 'checked'; // multicheckbox
		}
		if(in_array('3', $tmp)){
			//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
			$groups[3]['is_checked'] = 'checked'; // multicheckbox
		}
		$this->data['updatecontent']['field_tmp'] = $groups;
	}

	protected function update_run_other_element($array)
	{
		//$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['ml_key'] = 'tw';
		$array['type'] = 'webmenu';

		if(!isset($array['field_tmp'])){
            $array['field_tmp'] = array();
        }

		// if(isset($_POST['field_tmp']) and count($_POST['field_tmp']) > 0){
		// 	$array['field_tmp'] = implode(',', $_POST['field_tmp']);
		// }

		if(isset($array['field_tmp']) and count($array['field_tmp']) > 0){
			$array['field_tmp'] = ','.implode(',', $array['field_tmp']).',';
		} else {
			$array['field_tmp'] = '';
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		//$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['ml_key'] = 'tw';
		$array['type'] = 'webmenu';

		// if(isset($_POST['field_tmp']) and count($_POST['field_tmp']) > 0){
		// 	$array['field_tmp'] = implode(',', $_POST['field_tmp']);
		// }

		if(isset($array['field_tmp']) and count($array['field_tmp']) > 0){
			$array['field_tmp'] = ','.implode(',', $array['field_tmp']).',';
		} else {
			$array['field_tmp'] = '';
		}

		return $array;
	}


}

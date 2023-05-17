<?php

class Webmenu2Controller extends Controller {

	protected $def = array(
		//'title' => 'ml:Product',
		'table' => 'html',
		'orm' => 'G_html_orm',
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
		'sortable' => array(
			'enable' => 'true',
			//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=webmenu2/sort', // ajax post都會有個目標
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
			'topic' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '40%',
				'sort' => true,
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
						'other1' => array(
							'label' => '外掛程式名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								//'size' => '8',
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
						'detail' => array(
							'label' => '描述',
							'type' => 'ckeditor_js',
							'attr' => array(
								'id' => 'detail',
								'name' => 'detail',
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
		$this->def['condition'][0][1] = 'type=\'webmenu2\' ';
		$this->def['sortable']['condition'] = 'type="webmenu2" ';

		return true;
	}

	protected function update_run_other_element($array)
	{
		$array['ml_key'] = $this->data['ml_key'];
		$array['type'] = 'webmenu2';
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['ml_key'];
		$array['type'] = 'webmenu2';
		return $array;
	}

}

<?php

class SeoController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => false,
		//'disable_create' => true,
		'table' => 'seo',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'seo',
			'created_field' => 'seo_create_time', 
			//'updated_field' => 'seo_update_time',
			'primary' => 'seo_id',
			'rules' => array(
				array('seo_type, seo_ml_key', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'seo_create_time', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('seo_keyword'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'seo_keyword', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'seo_keyword', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'condition' => array(
		//	array(
		//		'where',
		//		'',
		//	),
		//),
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=articlenormal1/sort', // ajax post都會有個目標
		//),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			'seo_type' => array(
				'label' => '功能',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			'seo_keyword' => array(
				'label' => 'Keyword',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			//'seo_is_enable' => array(
			//	//'label' => 'ml:Status',
			//	'mlabel' => array(
			//		null, // category
			//		'Status', // label
			//		array(), // sprintf
			//		'狀態', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'ezshow' => true,
			//),
			'seo_create_time' => array(
				'label' => '建立時間',
				'width' => '20%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		'searchfield' => array(
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
					'id' => 'form_data_search',
					'name' => 'form_data_search',
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
						'seo_type' => array(
							'label' => '功能',
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_type',
								'name' => 'seo_type',
								'size' => '20',
							),
							'other' => array(
								'html_end' => '例如company, category, product',
							),
						),
						'seo_keyword' => array(
							'label' => 'Keyword',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_keyword',
								'name' => 'seo_keyword',
								'size' => '20',
							),
						),
					),
				),
			),
		),
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
						'seo_type' => array(
							'label' => '功能',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_type',
								'name' => 'seo_type',
								'size' => '30',
								'readonly' => 'readonly',
							),
						),
						//'seo_keyword' => array(
						//	'label' => 'Keyword',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_keyword',
						//		'name' => 'seo_keyword',
						//		'size' => '40',
						//	),
						//	'other'=> array(
						//		'html_end' => '這邊輸入文字送出後則底下欄位如果是空白則會複寫',
						//		),
						//),
						'seo_title' => array(
							'label' => '視窗抬頭Title',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_title',
								'name' => 'seo_title',
								'size' => '75',
							),
						),
						'seo_script_name' => array(
							'label' => '檔案名稱(靜態頁網址)',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_script_name',
								'name' => 'seo_script_name',
								'size' => '75',
							),
						),
						//'seo_link_alt' => array(
						//	'label' => '連結說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_link_alt',
						//		'name' => 'seo_link_alt',
						//		'size' => '40',
						//	),
						//),
						//'seo_photo_l_alt' => array(
						//	'label' => '大圖說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_photo_l_alt',
						//		'name' => 'seo_photo_l_alt',
						//		'size' => '40',
						//	),
						//),
						//'seo_photo_m_alt' => array(
						//	'label' => '中圖說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_photo_m_alt',
						//		'name' => 'seo_photo_m_alt',
						//		'size' => '40',
						//	),
						//),
						//'seo_photo_s_alt' => array(
						//	'label' => '小圖說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_photo_s_alt',
						//		'name' => 'seo_photo_s_alt',
						//		'size' => '40',
						//	),
						//),
						'seo_meta_keyword' => array(
							'label' => '網頁關鍵字keyword',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							//'type' => 'input',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'seo_meta_keyword',
								'name' => 'seo_meta_keyword',
								'size' => '30',
								'rows' => '6',
								'cols' => '80',
							),
						),
						'seo_meta_description' => array(
							'label' => '網頁說明description',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							//'type' => 'input',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'seo_meta_description',
								'name' => 'seo_meta_description',
								'size' => '30',
								'rows' => '6',
								'cols' => '80',
							),
						),
						//'seo_meta_copyright' => array(
						//	'label' => '網頁版權',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_meta_copyright',
						//		'name' => 'seo_meta_copyright',
						//		'size' => '40',
						//	),
						//),
						//'seo_is_enable' => array(
						//	'label' => '狀態',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Status', // label
						//	//	array(), // sprintf
						//	//	'狀態', // default
						//	//),
						//	'type' => 'status',
						//	'attr' => array(
						//		'id' => 'seo_is_enable',
						//		'name' => 'seo_is_enable',
						//	),
						//	'other' => array(
						//		'default'=>'1',
						//	),
						//),
					),
				),
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'detail' => array(
				//			'label' => '內容',
				//			//'type' => 'textarea',
				//			'type' => 'ckeditor_js',
				//			'attr' => array(
				//				//'class' => 'form-control', // 這…手動加上去好了
				//				'id' => 'detail',
				//				'name' => 'detail',
				//				//'rows' => '4',
				//				//'cols' => '40',
				//			),
				//		),
				//	),
				//),
			),
		), // updatefield
	);

	//protected function beforeAction($action)
	//{
	//	parent::beforeAction($action);

	//	// 無法帶入的變數中的變數，在這裡帶入
	//	$this->def['condition'][0][0] = 'where';
	//	$this->def['condition'][0][1] = 'type=\'articlenormal1\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
	//	$this->def['sortable']['condition'] = 'type="articlenormal1" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

	//	return true;
	//}

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		//$this->data['updatecontent']['class_id'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		$condition = ' 1 and seo_ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$condition_sortable = ' type="item1" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				//if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){
					$conditions[] = $k.'='.$v;
					//$conditions_sortable[] = $k.'='.$v;
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					//$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				//var_dump($conditions);
				//die;
			}
			if(count($conditions) > 0){
				if($condition != ''){
					$condition .= ' AND ';
				}
				$condition .= implode(' AND ', $conditions);
			}
			if($condition != ''){
				$this->def['condition'][0] = array(
					'where',
					$condition,
				);
			}
			//if(count($conditions_sortable) > 0){
			//	if($condition_sortable != ''){
			//		$condition_sortable .= ' AND ';
			//	}
			//	$condition .= implode(' AND ', $conditions_sortable);
			//}
			//if($condition_sortable != ''){
			//	$this->def['sortable']['condition'] = $condition_sortable;
			//}
			//var_dump($this->def['condition']);
			//die;
		} else {
			if(trim($condition) != ''){
				$this->def['condition'][] = array(
					'where',
					$condition,
				);
			}
			//if(trim($condition_sortable) != ''){
			//	$this->def['sortable']['condition'] = $condition_sortable;
			//}
		}

		return true;
	}

	//protected function index_last()
	//{
	//	//var_dump($this->data['listcontent']);
	//	if($this->data['listcontent']){
	//		foreach($this->data['listcontent'] as $k => $v){
	//			//if($v['pic1'] != ''){
	//			//	$v['pic1'] = $this->data['image_upload_path'].'/articlenormal1/'.$v['pic1'];
	//			//}
	//			$v['id'] = $v['seo_id'];
	//			$this->data['listcontent'][$k] = $v;
	//		}
	//	}
	//}

	protected function update_run_other_element($array)
	{
		$array['seo_ml_key'] = $this->data['admin_switch_data_ml_key'];
		//$array['type'] = 'articlenormal1';
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['seo_ml_key'] = $this->data['admin_switch_data_ml_key'];
		//$array['type'] = 'articlenormal1';
		return $array;
	}

}

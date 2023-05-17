<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,

		// 在各功能的上面的新增的右邊(匯出功能之一)
		// 'index_buttons' => array(
		// 	array(
		// 		'name' => '匯出<i class="icon-external-link"></i>',  // 按鈕的名稱和圖示
		// 		'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
		// 		'id' => '', // button
		// 		'class' => 'btn btn-info', // button
		// 		'onclick' => 'javascript:location.href=\'XXX\'',
		// 	),
		// ),

		'table' => 'country',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'country',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				// array('topic', 'required'),
				// array('detail', 'system.backend.extensions.myvalidators.numericcodeutf8'),
				// array('start_date', 'date', 'format'=>'yyyy-M-d'),
				// array('phone','numerical','integerOnly'=>true),
			),
		),
		//'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'name', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
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
		//	'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		//),
		//'func_field' => array(
		//	'id' => 'id',
		//	'sort_id' => 'sort_id',
		//),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			'pic1' => array(
				'label' => '圖片',
				'width' => '10%',
				'align' => 'center',
				'sort' => false,
				'kcfinder_small_img' => true,
			),
			'tw' => array(
				'label' => '國家名稱',
				'width' => '20%',
				'sort' => true,
			),
			'name' => array(
				'label' => '英文',
				'width' => '20%',
				'sort' => true,
			),
			'short' => array(
				'label' => '縮寫',
				'width' => '10%',
				'sort' => true,
			),
			'phone' => array(
				'label' => '電話國碼',
				'width' => '10%',
				'sort' => true,
			),
			'currency' => array(
				'label' => '貨幣',
				'width' => '10%',
				'sort' => true,
			),
			'is_enable' => array(
				//'label' => 'ml:Status',
				'label' => '狀態',
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
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader','jquery.datepicker',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			//'smarty_javascript' => 'product/update_javascript.htm',
			'smarty_javascript' => '',
			'smarty_javascript_text' => "",
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
							'label' => '國家名稱',
							'type' => 'input',
							'merge' => 1,
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '，繁體中文',
							),
						),
						'tw' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'merge' => 3,
							'attr' => array(
								'id' => 'tw',
								'name' => 'tw',
								'size' => '40',
							),
						),
						'short' => array(
							'label' => '縮寫',
							'type' => 'input',
							'attr' => array(
								'id' => 'short',
								'name' => 'short',
								'size' => '40',
							),
						),
						'phone' => array(
							'label' => '電話國碼',
							'type' => 'input',
							'attr' => array(
								'id' => 'phone',
								'name' => 'phone',
								'size' => '40',
							),
						),
						'currency' => array(
							'label' => '貨幣',
							'type' => 'input',
							'attr' => array(
								'id' => 'currency',
								'name' => 'currency',
								'size' => '40',
							),
						),
						'timezone' => array(
							'label' => 'Time Zone',
							'type' => 'input',
							'attr' => array(
								'id' => 'timezone',
								'name' => 'timezone',
								'size' => '40',
							),
						),
						'gmt' => array(
							'label' => 'GMT',
							'type' => 'input',
							'attr' => array(
								'id' => 'gmt',
								'name' => 'gmt',
								'size' => '40',
							),
						),
						'pic1' => array(
							'label' => '圖片上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '360x220',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'is_enable' => array(
							'label' => '狀態',
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
			),
		), // updatefield
	);

	protected function index_last($param='')
	{
		
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if(isset($v['pic1']) and $v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
				$this->data['listcontent'][$k] = $v;
			}
		}

		// $this->data['main_content'] = 'default/index';
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

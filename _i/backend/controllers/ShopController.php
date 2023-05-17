<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'empty_orm_data_related' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'func_field' => array(
			'id' => 'id',
			'sort_id' => 'sort_id',
		),
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
			'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		),

		'tools_name' => '美安更新產品',
		// 'tools' => array(
		// 	array(
		// 		'class' => '',
		// 		'target' => '',
		// 		'url' => '',
		// 		'name' => '',
		// 	),
		// ),

		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			'pic1' => array(
				//'label' => '圖片',
				'mlabel' => array(
					null, // category
					'Image', // label
					array(), // sprintf
					'代表圖', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => false,
				'kcfinder_small_img' => true,
			),
			'name' => array(
				'label' => '名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			// 'price' => array(
			// 	'label' => '市價(元)',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Title', // label
			// 	//	array(), // sprintf
			// 	//	'標題', // default
			// 	//),
			// 	'width' => '12%',
			// 	'sort' => true,
			// ),
			// 'price2' => array(
			// 	'label' => 'VIP價(元)',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Title', // label
			// 	//	array(), // sprintf
			// 	//	'標題', // default
			// 	//),
			// 	'width' => '12%',
			// 	'sort' => true,
			// ),
			'is_increase_purchase' => array(
				'label' => '加價購的產品',
				//'mlabel' => array(
				//	null, // category
				//	'Show Home', // label
				//	array(), // sprintf
				//	'顯示在首頁', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_increase_purchase',
				'ezother'=> '&nbsp;',
			),
			'is_promo' => array(
				'label' => '滿額加價購的產品',
				//'mlabel' => array(
				//	null, // category
				//	'Show Home', // label
				//	array(), // sprintf
				//	'顯示在首頁', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_promo',
				'ezother'=> '&nbsp;',
			),
			// 'is_home' => array(
			// 	//'label' => 'ml:Sort id',
			// 	'mlabel' => array(
			// 		null, // category
			// 		'Show Home', // label
			// 		array(), // sprintf
			// 		'顯示在首頁', // default
			// 	),
			// 	'width' => '10%',
			// 	'align' => 'center',
			// 	'sort' => true,
			// 	'ezfield' => 'is_home',
			// 	'ezother'=> '&nbsp;',
			// ),
			'is_enable' => array(
				'label' => '狀態',
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
			),
			'click' => array(
				'label' => '點閱數',
				'width' => '8%',
				'align' => 'center',
			),
			'xx3' => array(
				'label' => '多圖',				
				'width' => '5%',
				'url_id' => 'shopphoto',
				//'url_router_class' => 'fireproof',
			),
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '5%',
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
						'keyword' => array(
							'label' => '標題',
							'translate_source' => 'tw',
							'type' => 'input',
							'attr' => array(
								'id' => 'keyword',
								'name' => 'keyword',
								'size' => '40',
							),
						),
						'class_id' => array(
							'label' => '分類',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'class_id',
								'name' => 'class_id',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '',
							),
						),
						//'icon' => array(
						//	'label' => 'ICON',
						//	'type' => 'select3',
						//	//'type' => 'select5',
						//	//'merge' => '1', // 頭中尾的頭(1)
						//	'attr' => array(
						//		'id' => 'icon',
						//		'name' => 'icon',
						//	),
						//	'other' => array(
						//		'values' => array(
						//			''=>'請選擇',
						//			'shop-icon-new.svg'=>'NEW',
						//			'shop-icon-hot.svg'=>'HOT',
						//			'shop-icon-sale.svg'=>'SALE',
						//		),
						//		//'default' => 'center',
						//		//'values' => array(
						//		//	'0' => '請選擇',
						//		//),
						//		'default' => '',
						//	),
						//),
						//'checkbox_is_low_temperature' => array(
						//	'label' => '低溫運費',
						//	//'label' => '人氣',
						//	'type' => 'checkbox',
						//	'merge' => '1',
						//	'attr' => array(
						//		'name' => 'checkbox_is_low_temperature',
						//		'value' => '1',
						//	),
						//),
					),
				),
			),
		),
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader','jquery.datepicker',
				'jquery.multi-select',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			'smarty_javascript' => '', // product/update_javascript.htm
			'smarty_javascript_text' => "
				$.datepicker.regional['zh-TW'] = {
					closeText: '關閉',
					prevText: '&#x3c;上月',
					nextText: '下月&#x3e;',
					currentText: '今天',
					monthNames: ['一月','二月','三月','四月','五月','六月',
					'七月','八月','九月','十月','十一月','十二月'],
					monthNamesShort: ['一','二','三','四','五','六',
					'七','八','九','十','十一','十二'],
					dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
					dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
					dayNamesMin: ['日','一','二','三','四','五','六'],
					weekHeader: '周',
					dateFormat: 'yy/mm/dd',
					firstDay: 1,
					isRTL: false,
					showMonthAfterYear: true,
					yearSuffix: '年'};
				$.datepicker.setDefaults($.datepicker.regional['zh-TW']);
				$('#date1').datepicker({dateFormat: 'yy-mm-dd'});
				$('#date2').datepicker({dateFormat: 'yy-mm-dd'});
			",
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
							'label' => '名稱',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '40',
							),
						),
						'name2' => array(
							'label' => '品號',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								'id' => 'name2',
								'name' => 'name2',
								'size' => '15',
							),
						),
						//'icon' => array(
						//	'label' => 'ICON',
						//	'type' => 'select3',
						//	//'type' => 'select5',
						//	//'merge' => '1', // 頭中尾的頭(1)
						//	'attr' => array(
						//		'id' => 'icon',
						//		'name' => 'icon',
						//	),
						//	'other' => array(
						//		'values' => array(
						//			''=>'請選擇',
						//			'shop-icon-new.svg'=>'NEW',
						//			'shop-icon-hot.svg'=>'HOT',
						//			'shop-icon-sale.svg'=>'SALE',
						//		),
						//		'default' => '',
						//		'default' => '',
						//	),
						//),
						//'class_id' => array(
						//	'label' => '分類',
						//	//'type' => 'select3',
						//	'type' => 'select5',
						//	//'merge' => '1', // 頭中尾的頭(1)
						//	'attr' => array(
						//		'id' => 'class_id',
						//		'name' => 'class_id',
						//	),
						//	'other' => array(
						//		'html' => '',
						//	),
						//),
						'class_ids' => array(
							'label' => '複選分類',
							'type' => 'treeselect',
							'attr' => array(
								'id' => 'class_ids',
								'name' => 'class_ids',
							),
							'other' => array(
								//'pid' => 'class_id',
							),
						),
						'pic1' => array(
							'label' => '代表圖：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '300',
								'height' => '300',
								'comment_size' => '1000x650',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'itemspec' => array(
							'label' => '購買規格<br><font color="red">所有價格</font>欄位都須填寫',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						// 'related_ids' => array(
						// 	'label' => '選擇相關產品',
						// 	//'type' => 'select3',
						// 	//'type' => 'select5',
						// 	//'type' => 'multiselect',
						// 	//'type' => 'multi-select',
						// 	'type' => 'multi-select-category-select', // 2020-04-30
						// 	'attr' => array(
						// 		'id' => 'related_ids',
						// 		'name' => 'related_ids[]',

						// 		//'class' => 'form-control input-large select2me',
						// 		//'class' => 'multi-select',
						// 		//'data-placeholder' => "請選擇或搜尋",
						// 		//'multiple' => 'multiple',
						// 		//'size' => 10,
						// 	),
						// 	'other' => array(
						// 		'table_type' => 'shoptype',
						// 		//'values' => array(
						// 		//	'' => '請選擇',
						// 		//	'member' => '會員',
						// 		//	'search' => '搜尋',
						// 		//	'share' => '分享',
						// 		//	'shop' => '購物',
						// 		//	'language' => '語系',
						// 		//),
						// 		//'default' => '',
						// 	),
						// ),
						// 'price' => array(
						// 	'label' => '市價',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'標題', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'price',
						// 		'name' => 'price',
						// 		'size' => '10',
						// 	),
						// 	'other' => array(
						// 		'html_end' => '元',
						// 		'number_only' => true,
						// 	),
						// ),
						// 'price2' => array(
						// 	'label' => 'VIP價',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'標題', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'price2',
						// 		'name' => 'price2',
						// 		'size' => '10',
						// 	),
						// 	'other' => array(
						// 		'html_end' => '元',
						// 		'number_only' => true,
						// 	),
						// ),
						// 'bonus' => array(
						// 	'label' => '加贈額外紅利點數',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'標題', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'bonus',
						// 		'name' => 'bonus',
						// 		'size' => '10',
						// 	),
						// 	'other' => array(
						// 		'html_end' => '點',
						// 		'number_only' => true,
						// 	),
						// ),
						// 'price3' => array(
						// 	'label' => '加價購的購格',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'標題', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'price3',
						// 		'name' => 'price3',
						// 		'size' => '10',
						// 	),
						// 	'other' => array(
						// 		'html_end' => '元',
						// 		'number_only' => true,
						// 	),
						// ),
						'is_increase_purchase' => array(
							'label' => '加價購的產品',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'is_increase_purchase',
								'value' => '1',
							),
							//'other' => array(
							//	'label' => '免',
							//),
						),
						'is_promo' => array(
							'label' => '滿額加價購的產品',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'is_promo',
								'value' => '1',
							),
							//'other' => array(
							//	'label' => '免',
							//),
						),
						// 'increase_purchase_ids' => array(
						// 	'label' => '選擇加價購的產品',
						// 	//'type' => 'select3',
						// 	//'type' => 'select5',
						// 	//'type' => 'multiselect',
						// 	'type' => 'multi-select',
						// 	'attr' => array(
						// 		'id' => 'increase_purchase_ids',
						// 		'name' => 'increase_purchase_ids[]',

						// 		//'class' => 'form-control input-large select2me',
						// 		//'class' => 'multi-select',
						// 		//'data-placeholder' => "請選擇或搜尋",
						// 		//'multiple' => 'multiple',
						// 		//'size' => 10,
						// 	),
						// 	// 'other' => array(
						// 	// 	'values' => array(
						// 	// 		'' => '請選擇',
						// 	// 		'member' => '會員',
						// 	// 		'search' => '搜尋',
						// 	// 		'share' => '分享',
						// 	// 		'shop' => '購物',
						// 	// 		'language' => '語系',
						// 	// 	),
						// 	// 	'default' => '',
						// 	// ),
						// ),
						// 'is_additional_purchase' => array(
						// 	'label' => '加購產品',
						// 	'type' => 'checkbox',
						// 	'attr' => array(
						// 		'name' => 'is_additional_purchase',
						// 		'value' => '1',
						// 	),
						// 	//'other' => array(
						// 	//	'label' => '免',
						// 	//),
						// ),
						//需要低溫運費時再開啟
						// 'is_low_temperature' => array(
						// 	'label' => '是否為低溫產品',
						// 	'type' => 'checkbox',
						// 	'attr' => array(
						// 		'name' => 'is_low_temperature',
						// 		'value' => '1',
						// 	),
						// 	//'other' => array(
						// 	//	'label' => '免',
						// 	//),
						// ),
						// 這個不用建資料表的欄位
						// 'promotion_ids' => array(
						// 	'label' => '促銷方案',
						// 	'type' => 'multi-select',
						// 	'attr' => array(
						// 		'id' => 'promotion_ids',
						// 		'name' => 'promotion_ids[]',
						// 	),
						// ),
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
                        'date1' => array(
                            'label' => '上架日期',
                            'type' => 'input',
                            'merge' => '1',
                            'attr' => array(
                                'id' => 'date1',
                                'name' => 'date1',
                                'size' => '10',
                                'readonly' => 'readonly',
                            ),
                        ),
                        'date2' => array(
                            'label' => ' ∼ ',
                            'type' => 'input',
                            'merge' => '3',
                            'attr' => array(
                                'id' => 'date2',
                                'name' => 'date2',
                                'size' => '10',
                                // 'readonly' => 'readonly',
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
						// 2016-11-16 小李說要用textarea
						'detail' => array(
							'label' => '簡述',
							'type' => 'textarea',
							//'type' => 'ckeditor_js',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail',
								'name' => 'detail',
								'rows' => '4',
								'cols' => '40',
							),
						),
						'detail2' => array(
							'label' => '說明',
							'type' => 'ckeditor_js',
							'attr' => array(
								'id' => 'detail2',
								'name' => 'detail2',
							),
						),
						'detail3' => array(
							'label' => '規格',
							'type' => 'ckeditor_js',
							'attr' => array(
								'id' => 'detail3',
								'name' => 'detail3',
							),
						),
						'detail4' => array(
							'label' => '警告標語',
							'type' => 'textarea',
							//'type' => 'ckeditor_js',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail4',
								'name' => 'detail4',
								'rows' => '4',
								'cols' => '40',
							),
						),
						//改用拖拉多圖套件
						// 'kc01' => array(
						// 	'label' => '多張圖片<br />',
						// 	'type' => 'kcfinder_school',
						// 	'attr' => array(
						// 		'width' => '700',
						// 		'height' => '400',
						// 	),
						// 	'other' => array(
						// 		'uploadurl_id' => 'assetsdir',
						// 		'type' => 'member',
						// 		//'width' => '400',
						// 		'height' => '170',
						// 		'school_id' => '',
						// 		//'dir' => 'files/public',
						// 	),
						// ),
					),
				),
				// 商品複製
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'name' => array(
							'label' => '產品名稱',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'name',
							//	'name' => 'name',
							//	'size' => '40',
							//),
						),
						'is_copy' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'is_copy',
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

		$file = _BASEPATH.'/config/shop.php';
		if(file_exists($file)){
			include $file;
		}
		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}
		
		// 商品複製 copy
		if(isset($_GET['param'])){
			$parameter = new Parameter_handle;
			$params = $parameter->get($_GET['param']);
			if(isset($params['value'][1]) and $params['value'][1] and $params['value'][1] == 'copy'){
				$ggg = $this->def['updatefield']['sections'][2];
				$this->def['updatefield']['sections'] = array();
				$this->def['updatefield']['sections'][] = $ggg;
			} else {
				unset($this->def['updatefield']['sections'][2]);
			}
		}

		//相關產品是否顯示
		unset($_constant);
		eval('$_constant = '.strtoupper('shop_related_products').';'); 
		if(!$_constant){
			unset($this->def['updatefield']['sections'][0]['field']['related_ids']);
		}
		//加價購是否顯示
		unset($_constant);
		eval('$_constant = '.strtoupper('shop_show_purchase').';'); 
		if(!$_constant){
			unset($this->def['updatefield']['sections'][0]['field']['is_increase_purchase']);
			unset($this->def['listfield']['is_increase_purchase']);
		}
		//滿額加價購是否顯示
		unset($_constant);
		eval('$_constant = '.strtoupper('shop_promo').';'); 
		if(!$_constant){
			unset($this->def['updatefield']['sections'][0]['field']['is_promo']);
			unset($this->def['listfield']['is_promo']);
		}
		// 分類
		// $rows = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		// if($rows and count($rows) > 0){
		// 	foreach($rows as $k => $v){
		// 		$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
		// 		$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
		// 		$rows2 = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		// 		if($rows2 and count($rows2) > 0){
		// 			foreach($rows2 as $kk => $vv){
		// 				$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
		// 				$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
		// 			}
		// 		}
		// 	}
		// }

		// 分類
		// $rows = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		// if($rows and count($rows) > 0){
		// 	foreach($rows as $k => $v){
		// 		//大分類不可選 
		// 		/*
		// 		$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
		// 		$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
		// 		$rows2 = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		// 		*/
		// 		//大分類可選
		// 		$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
		// 		// $this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';

		// 		//無限層
		// 		$data_1 = $this->layout_show($v['id'],1,'　');//'　└'	
		// 		$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
		// 		//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;

		// 		/* //兩層
		// 		$rows2 = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		// 		if($rows2 and count($rows2) > 0){
		// 			foreach($rows2 as $kk => $vv){
		// 				$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
		// 				$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
		// 			}
		// 		}
		// 		*/
		// 	}
		// }

		// 分類
		$producttype_table = $this->data['router_class'];
		//$producttype_table = str_replace('homesort', '', $producttype_table); // 為了支援產品的首頁排序(這是homesort的另一支後台功能在用的，註解不要打開)
		$producttype_table .= 'type';

		$rows = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				//if(isset($rowg['other18']) and $rowg['other18'] == 1){
					// 大分類可選
					$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
					//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
				//} elseif(isset($rowg['other18']) and $rowg['other18'] == 2){
				//	// 大分類不可選
				//	$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
				//	//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
				//}

				// 剩餘子層的處理程序
				$data_1 = $this->layout_show($v['id'],1,'　',$producttype_table);//'　└'	
				//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
				$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1 ;
			}
		}

		// 規格
		if(isset($this->def['updatefield']['sections'][0]['field']['itemspec'])){
			$this->def['updatefield']['sections'][0]['field']['itemspec']['attr_td1'] = array('width' => '160');
			$this->def['updatefield']['sections'][0]['field']['itemspec']['def'] = array(
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
								'itemspec_name_' => array(
									'label' => '商品編號',
									'type' => 'input',
									'merge' => '1.5',
									'attr_tr' => array(
										'name' => 'itemspec', // 為了要做odd, even
									),
									'attr' => array(
										'id' => 'itemspec_name_',
										'name' => 'itemspec_name_',
									),
								),
								'itemspec_spec_' => array(
									'label' => '規格',
									'type' => 'input',
									'merge' => '2',
									'attr_tr' => array(
										'name' => 'itemspec', // 為了要做odd, even
									),
									'attr' => array(
										'id' => 'itemspec_spec_',
										'name' => 'itemspec_spec_',
									),
								),
								//更新Jquery1.11.3後，這邊用spinner會有錯誤...改用下面的 by lota
								// 'itemspec_inventory_' => array(
								// 	'label' => '庫存',
								// 	//'type' => 'input',
								// 	'type' => 'spinner',
								// 	'merge' => '2',
								// 	'attr_tr' => array(
								// 		'name' => 'itemspec', // 為了要做odd, even
								// 	),
								// 	'attr' => array(
								// 		'id' => 'itemspec_inventory_',
								// 		'name' => 'itemspec_inventory_',
								// 		'size' => '20',
								// 		'class' => 'small_input',
								// 		'style' => 'display:inline-block;vertical-align:middle;',
								// 	),
								// 	//'other' => array(
								// 	//	'html_end' => '</td></tr></table>',
								// 	//),
								// ),
								'itemspec_inventory_' => array(
									'label' => '庫存',
									'type' => 'input',
									
									'merge' => '2',
									'attr_tr' => array(
										'name' => 'itemspec', // 為了要做odd, even
									),
									'attr' => array(
										'type' => 'text',
										'onkeyup' => 'value=value.replace(/[^\d]+/g,\'\')',
										'id' => 'itemspec_inventory_',
										'name' => 'itemspec_inventory_',
										'size' => '10',						
									),
									//'other' => array(
									//	'html_end' => '</td></tr></table>',
									//),
								),
								'itemspec_price_' => array(
									'label' => '實際售價',
									'type' => 'input',
									'merge' => '2',
									'attr_tr' => array(
										'name' => 'itemspec', // 為了要做odd, even
									),
									'attr' => array(
										'id' => 'itemspec_price_',
										'name' => 'itemspec_price_',
									),
								),
								//2020-12-10 討論後決議要加入，只會在後台顯示 by lota
								'itemspec_price3_' => array(
									'label' => '成本價',
									'type' => 'input',
									'merge' => '2',
									'attr_tr' => array(
										'name' => 'itemspec', // 為了要做odd, even
									),
									'attr' => array(
										'id' => 'itemspec_price3_',
										'name' => 'itemspec_price3_',
									),
								),
								'itemspec_price2_' => array(
									'label' => '會員價',
									'type' => 'input',
									'merge' => '2',
									'attr_tr' => array(
										'name' => 'itemspec', // 為了要做odd, even
									),
									'attr' => array(
										'id' => 'itemspec_price2_',
										'name' => 'itemspec_price2_',
									),
								),
								'itemspec_delete_' => array(
									//'label' => '主要聯絡人',
									'label' => '&nbsp;',
									'type' => 'checkbox',
									'merge' => '3',
									'attr' => array(
										//'id' => 'membercontact_maincontact_',
										'name' => 'itemspec_delete_',
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
								'itemspec_more_' => array(
									'label' => '&nbsp;',
									'type' => 'anchor',
									'merge' => '1.5',
									'attr' => array(
										'text' => 'more ...',
										'class' => 'itemspec_more_',
										'onclick' => 'javascript:
													  $(this).parent().parent().next().show(); /*這是第一個*/
													  $(this).parent().parent().next().next().show();   /*這是第二個*/
													  $(this).parent().parent().next().next().next().show();  /*這是More按鈕*/
													  $(this).parent().parent().hide(); 
													  $(\'tr:odd[name=itemspec]\').attr(\'class\', \'bgcolor2\'); /*單數顏色*/ 
													  $(\'tr:even[name=itemspec]\').attr(\'class\', \'bgcolor1\'); /*雙數顏色*/',
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
			);
		}

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// 2018-10-18
		// 如果有下關鍵字，那就取消分類的搜尋，並且取消托拉排序
		// http://redmine.buyersline.com.tw:4000/issues/29538?issue_count=81&issue_position=2&next_issue_id=29493&prev_issue_id=29561#note-1
		if(isset($session['keyword']) and $session['keyword'] != ''){
			unset($session['class_id']);
			unset($this->def['listfield']['sort_id']);
			$this->def['default_sort_field'] = 'id';
		}

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['class_id'] = -1;
		$this->data['updatecontent']['icon'] = '';

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		$condition = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';


		// 2020-08-19
		// 供新增的時候使用，新增的資料要在第一筆
		$this->data['origin_condition'] = array();
		if(trim($condition) != ''){
			$this->data['origin_condition'][0] = array(
				'where',
				$condition,
			);
		}

		if(isset($session) and !empty($session)){
			$conditions = array();
			$conditions_sortable = array();

			// [多分類排序]
			//$is_multisort = '';

			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'class_id' and $v == -1) continue;
				if($k == 'class_id' and $v == 0) continue;
				if($k == 'icon' and $v == '') continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){

					// 單分類排序
					//$conditions[] = $k.'='.$v;
					//$conditions_sortable[] = $k.'='.$v;

					// [多分類排序]
					//$is_multisort = $v;
					$conditions[] = 'class_ids LIKE \'%,'.$v.',%\''; // 因為condition的部份要特別處理
					$conditions_sortable[] = 'class_ids LIKE "%,'.$v.',%"';
				} elseif($k == 'keyword'){
					//if($rowg){
					//	if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
					//		$k = 'topic';
					//	} else {
					//		$k = 'name';
					//	}
					//} else {
					//	$k = 'topic';
					//}
					$k = 'name';
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				} elseif($k == 'icon'){
					$conditions[] = $k.'=\''.$v.'\'';
					$conditions_sortable[] = $k.'="'.$v.'"';
				} elseif($k == 'checkbox_is_low_temperature'){
					$conditions[] = 'is_low_temperature='.$v;
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				//var_dump($conditions);
				//die;
			}
			if(!empty($conditions)){
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

				// [多分類排序]
				//if($is_multisort != ''){
				//	$this->def['condition'][] = array(
				//		'like',
				//		'class_ids',
				//		','.$is_multisort.',',
				//		'both',
				//	);
				//}
			}
			if(!empty($conditions_sortable)){
				if($condition_sortable != ''){
					$condition_sortable .= ' AND ';
				}
				// 疑似Bug 2017-03-24 己經修好了
				$condition_sortable .= implode(' AND ', $conditions_sortable);
			}
			if($condition_sortable != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
			//var_dump($this->def['sortable']);die;
			//var_dump($this->def['condition']);
			//die;
		} else {
			if(trim($condition) != ''){
				$this->def['condition'][] = array(
					'where',
					$condition,
				);
			}
			if(trim($condition_sortable) != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
		}

		$this->data['increase_purchase_ids'] = array();
		//	'demo' => '測試',
		//	'production' => '上線',
		//	'shop' => '購物',
		//	'sem' => 'SEM',
		//	'platform' => '平台',
		//	'buyersline' => '百邇來公司用',
		$rows = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and is_increase_purchase=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				$this->data['increase_purchase_ids'][$v['id']] = $v['name'];
			}
		}

		$this->data['related_ids'] = array();
		//	'demo' => '測試',
		//	'production' => '上線',
		//	'shop' => '購物',
		//	'sem' => 'SEM',
		//	'platform' => '平台',
		//	'buyersline' => '百邇來公司用',
		//
		// $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type', array(':type'=>'case',':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		$rows = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				// $this->data['related_ids'][$v['id']] = $v['topic'];
				$this->data['related_ids'][$v['id']] = $v['name'];
			}
		}

		//判斷圖片推薦大小 20220623 lin 增加
		$rows_size = $this->db->createCommand("SELECT * FROM `sys_config` where keyname='function_constant_image_ratio'")->queryAll();
		if($rows_size){
			foreach($rows_size as $kk => $vv){
				if($vv["keyval"]=="itemImg"){
					$this->def["updatefield"]["sections"]["0"]["field"]["pic1"]["other"]["comment_size"]="1000x650";
				}
				else if($vv["keyval"]=="itemImg square"){
					$this->def["updatefield"]["sections"]["0"]["field"]["pic1"]["other"]["comment_size"]="1000x1000";
				}
				else if($vv["keyval"]=="itemImg traight"){
					$this->def["updatefield"]["sections"]["0"]["field"]["pic1"]["other"]["comment_size"]="650x1000";
				}
				else if($vv["keyval"]=="itemImg a4"){
					$this->def["updatefield"]["sections"]["0"]["field"]["pic1"]["other"]["comment_size"]="650x1000";
				}
				else{
					$this->def["updatefield"]["sections"]["0"]["field"]["pic1"]["other"]["comment_size"]="1000x650";
				}
			}
		}
		//增加加購品判斷  #45445
		$rows_purchase = $this->db->createCommand("SELECT * FROM `sys_config` where keyname='function_constant_shop_show_purchase'")->queryRow();
		if($rows_purchase['keyval']=='false'){
			unset($this->def['listfield']['is_increase_purchase']);
			unset($this->def['updatefield']['sections']["0"]["field"]['is_increase_purchase']);
		}

		
		//print_r($this->def["updatefield"]["sections"]["0"]["field"]["pic1"]["other"]["comment_size"]);
		

		return true;
	}

	protected function index_first()
	{
		// 取得商品分類的編號
		$class_id = 0;
		//if(isset($this->data['params']['value'][0])){
		//	$class_id = $this->data['params']['value'][0];
		//}
		if(isset($_SESSION[$this->data['router_class'].'_search']['class_id']) and $_SESSION[$this->data['router_class'].'_search']['class_id'] > 0){
			$class_id = $_SESSION[$this->data['router_class'].'_search']['class_id'];
		}
		$this->data['class_id'] = $class_id;

		if($class_id <= 0){
			unset($this->data['def']['listfield']['sort_id']);
		}

		// 商品分類編號要有指定，還有其它必要的條件，才能夠即時自動切換
		if($class_id > 0){
			$this->data['def']['sortable']['enable'] = true;

			// 疑似Bug 2017-03-24
			//$this->data['def']['sortable']['condition'] = 'class_id = '.$this->data['class_id'].' ';
			//$this->data['def']['condition']['where']['class_id'] = $class_id;
		} else {
			$this->data['def']['sortable']['enable'] = false;
		}

		// [多分類排序]
		// 只有一個分類條件下，才能啟用多類別的排序
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		if(isset($session) and !empty($session)){
			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') unset($session[$k]);
				if($k == 'class_id' and $v == -1) unset($session[$k]);
				if($k == 'class_id' and $v == 0) unset($session[$k]);
				if($k == 'icon' and $v == '') unset($session[$k]);
			}
		}
		if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
			// do nothing
		} else {
			//沒搜尋時 就用id反序排序 2021-06-15
			unset($this->data['def']['listfield'][$this->def['default_sort_field']]);
			$this->data['def']['sortable']['enable'] = false;

			$this->data['params']['direction'] = 'desc';//2016/6/23 初始化為反序，方便客戶馬上看到新增的資料
			$this->data['sort_field'] = base64url::encode($this->data['def']['func_field']['id']);
			$this->data['sort_field_nobase64'] = $this->data['def']['func_field']['id'];
			// $this->data['def']['sortable']['enable'] = false;
			// $sort_field = 'name';
			// //$this->load->library('base64url');
			// //$this->data['sort_field'] = $this->base64url->encode($sort_field);
			// $this->data['sort_field'] = base64url::encode($sort_field);
			// $this->data['sort_field_nobase64'] = $sort_field;
			// unset($this->data['def']['listfield']['sort_id']);
		}

		// 如果沒有選擇商品分類，而且又沒有指定排序的方式，這時預設排序欄位會改成商品名稱
		if($class_id <= 0 and $this->data['sort_field_nobase64'] == 'sort_id'){
			$sort_field = 'name';
			//$this->load->library('base64url');
			//$this->data['sort_field'] = $this->base64url->encode($sort_field);
			$this->data['sort_field'] = base64url::encode($sort_field);
			$this->data['sort_field_nobase64'] = $sort_field;
		}
	}

	protected function getdata()
	{
		// 2017-03-24 有點忘記這一段是做什麼了，暫時先註解起來
		// if(isset($this->data['updatecontent']['id'])){
		// 	$this->data['def']['updatefield']['sections'][0]['field']['itemspec']['label'] = str_replace('#', $this->createUrl($this->data['router_class'].'/searchfield',array('id'=>$this->data['updatecontent']['id'],'section'=>1)), $this->data['def']['updatefield']['sections'][0]['field']['itemspec']['label']);
		// }

		if(isset($this->def['updatefield']['sections'][0]['field']['itemspec'])){
			//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>$this->data['router_class'].'spec',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
			//if($rows and count($rows) > 0){
			//	foreach($rows as $k => $v){
			//		$name = $v['topic'];
			//		$attrs = array();
			//		for($x=1;$x<=4;$x++){
			//			if(isset($v['other'.$x]) and $v['other'.$x] != ''){
			//				$attrs[] = $v['other'.$x];
			//			}
			//		}
			//		if(count($attrs)){
			//			$name .= ' ( '.implode(', ', $attrs).' )';
			//		}
			//		$this->data['def']['updatefield']['sections'][0]['field']['itemspec']['def']['updatefield']['sections_sample'][0]['field']['itemspec_specid_']['other']['values'][$v['id']] = $name;
			//	}
			//}

			//for($y=0;$y<=11;$y++){
			//	$this->data['updatecontent']['itemspec_specid_c'.$y] = '0';
			//}

			// protected function multi_field_v1($groupname, $tablename, $fields_pipe, $require_field, $section_number ,$sample_num = 5)
			$this->multi_field_v1('itemspec', 'shopspec', 'name|spec|inventory|price|price3|price2', 'spec', 0); //2021-10-07 改規格必填
		}
	}

	protected function create_show_last()
	{
		$this->getdata();

		unset($this->data['def']['updatefield']['sections'][1]['field']['kc01']);

		// 複選分類
		if(isset($this->data['def']['updatefield']['sections'][0]['field']['class_ids'])){
			// 取得所有分類
			$rows = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();

			$this->data['updatecontent']['class_ids'] = $rows;
		}

		// 相關產品
		$groups = array();
		foreach($this->data['related_ids'] as $k => $v){
			$groups[$k]['value'] = $v;
		}
		$this->data['updatecontent']['related_ids'] = $groups;

		// 選加價購的產品
		foreach($this->data['increase_purchase_ids'] as $k => $v){
			$groups[$k]['value'] = $v;
		}
		$this->data['updatecontent']['increase_purchase_ids'] = $groups;

		// 選擇促銷方案
		$rows = $this->db->createCommand()->from($this->data['router_class'].'promotion')->where('is_enable=1')->queryAll();
		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['id']]['value'] = $v['name'];
				// if(isset($tmps[$v['id']]) and in_array($this->data['updatecontent']['id'], $tmps[$v['id']])){
				// 	$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
				// 	//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				// }
			}
		}
		$this->data['updatecontent']['promotion_ids'] = $groups;
	}

	protected function update_show_last($updatecontent)
	{
		$this->getdata();

		if(isset($this->data['def']['updatefield']['sections'][1]['field']['kc01'])){
			$this->data['def']['updatefield']['sections'][1]['field']['kc01']['other']['school_id'] = $this->data['router_class'].$this->data['updatecontent']['id'];
		}

		// 複選分類
		if(isset($this->data['def']['updatefield']['sections'][0]['field']['class_ids'])){
			// 取得所有分類
			$rows = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();

			// ,1,2,3,
			$ggg = explode(',', $this->data['updatecontent']['class_ids']);
			unset($ggg[count($ggg) - 1]);
			unset($ggg[0]);

			if(!empty($rows)){
				foreach($rows as $k => $v){
					if(in_array($v['id'], $ggg)){
						$rows[$k]['is_selected'] = '1';
					}
				}
			}
			$this->data['updatecontent']['class_ids'] = $rows;
		}

		// 選擇相關產品
		$tmps = explode(',', $this->data['updatecontent']['related_ids']);
		$groups = array();
		if($this->data['related_ids']){
			foreach($this->data['related_ids'] as $k => $v){
				if($k == $this->data['updatecontent']['id']) continue; // 排除掉自己，不然選到自己跟本就是很奇怪
				$groups[$k]['value'] = $v;
				if(in_array($k, $tmps)){
					$groups[$k]['is_selected'] = 'selected'; // multiselect
					//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['related_ids'] = $groups;

		// 商品複製
		if(isset($this->data['params']['value'][1]) and $this->data['params']['value'][1] == 'copy'){
			$this->data['submit_buttons'] = array(
				array(
					'html' => '<i class="icon-copy"></i> Copy',
					'class' => 'btn blue',
				   	'type' => 'submit',
				),
			);
			$this->data['router_method_view'] = '1';
			$this->data['updatecontent']['is_copy'] = $this->data['updatecontent']['id'];
			$this->data['updatecontent']['id'] = 0; // 為了保護原本的資料不被動到
		}

		// 選擇加價購的產品
		$tmps = explode(',', $this->data['updatecontent']['increase_purchase_ids']);
		$groups = array();
		if($this->data['increase_purchase_ids']){
			foreach($this->data['increase_purchase_ids'] as $k => $v){
				if($k == $this->data['updatecontent']['id']) continue; // 排除掉自己，不然選到自己跟本就是很奇怪
				$groups[$k]['value'] = $v;
				if(in_array($k, $tmps)){
					$groups[$k]['is_selected'] = 'selected'; // multiselect
					//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['increase_purchase_ids'] = $groups;

		// 選擇促銷方案
		$rows = $this->db->createCommand()->from($this->data['router_class'].'promotion')->where('is_enable=1')->queryAll();
		$rows2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_class'].'promotionrelatedids',':ml_key'=>$this->data['ml_key']))->queryAll();
		$tmps = array();
		if($rows2){
			foreach($rows2 as $k => $v){
				$tmps[$v['class_id']][] = $v['other1'];
			}
		}
		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['id']]['value'] = $v['name'];
				if(isset($tmps[$v['id']]) and in_array($this->data['updatecontent']['id'], $tmps[$v['id']])){
					$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
					//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['promotion_ids'] = $groups;

	}

	protected function index_last()
	{
		//var_dump($this->data['listcontent']);
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}

				// $v['is_enable_name'] = '';
				// gif(isset($v['is_enable'])){
				// g	if($v['is_enable'] == 1){
				// g		$v['is_enable_name'] = '';
				// g	} else {
				// g	}
				// g}

				// 商品複製
				$v['_enable_custom_button_copy'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-vcopy')).'" class="btn default btn-xs blue"><i class="icon-copy"></i> Copy</a>';

				//$v['price'] = 'NT$ '.number_format($v['price']);
				//$v['price2'] = 'NT$ '.number_format($v['price2']);

				$this->data['listcontent'][$k] = $v;
			}
		}
		
		//是否顯示美安訂單更新產品按鈕
		if( isset($this->data['MarketAn']) && $this->data['MarketAn']['is_enable'] == 1 ){
			
			$tmp[] = array(					
					'class' => '_marketan',
					'target' => 'hidFrame1',
					'url' => $this->createUrl($this->data['router_class'].'/marketan'),
					'name' =>'產出XML檔案',					
			);
			$tmp[] = array(
					'class' => '',
					'target' => '_break',
					'url' => '/_i/assets/marketan.xml',
					'name' =>'XML檔案連結',					
			);
			
			$this->data['def']['tools'] = $tmp;

			$this->data['def']['searchfield']['smarty_javascript_text'] = '
				$("._marketan").on("click",function(){
					var _href = $(this).attr("href");
					$.get(_href,function(msg){
						alert(msg);
					});
					return false;
				});
			';
		}
	}

	//https://t.codebug.vip/questions-3066332.htm
	//排除XML不接受的特殊字元
	protected function stripInvalidXml($value)
	{
	    $ret = "";
	    $current;
	    if (empty($value)) 
	    {
	        return $ret;
	    }
	    $length = strlen($value);
	    for ($i=0; $i < $length; $i++)
	    {
	        $current = ord($value{$i});
	        if (($current == 0x9) ||
	            ($current == 0xA) ||
	            ($current == 0xD) ||
	            (($current >= 0x20) && ($current <= 0xD7FF)) ||
	            (($current >= 0xE000) && ($current <= 0xFFFD)) ||
	            (($current >= 0x10000) && ($current <= 0x10FFFF)))
	        {
	            $ret .= chr($current);
	        }
	        else
	        {
	            $ret .= " ";
	        }
	    }
	    return $ret;
	}

	//產出美安訂單所要的XMl檔案
	public function actionMarketan()
	{

		header("Content-Type:text/html; charset=utf-8");

		//讀取所有產品資料
		// $this->cidb->where('is_enable')->get($this->data['router_class']);

		$sql = "SELECT * FROM ".$this->data['router_class']." p WHERE (p.is_enable=1) AND (p.date1 <= now() Or p.date1 is null Or p.date1 = '0000-00-00') And (p.date2 >= '".date('Y-m-d')."' Or p.date2 is null Or p.date2 = '0000-00-00') AND p.is_increase_purchase !=1 Order by sort_id ASC";

		$tmp = $this->cidb->query($sql)->result_array();

		if(!empty($tmp)){
			foreach ($tmp as $key => $value) {
				if(!empty($value['pic1'])){ //只抓有照片的產品資料
					$t = explode('.', $value['pic1']);
					if(end($t) == 'jpg' || end($t) == 'JPG'){ //不知道為什麼只抓jpg的...先照寫在說 @@

						//讀取第一個類別的資料
						$c = array_filter(explode(',', $value['class_ids']));
						if(isset($c[0])){
							$cRow = $this->cidb->where('id',$c[0])->get($this->data['router_class'].'type')->row_array();
						}

						//撈取第一個規格的資料
						$spec_Row = $this->cidb->where('data_id',$value['id'])->where('price !=',0)->where('price2 !=',0)->where('inventory !=',0)->limit(1)->get($this->data['router_class'].'spec')->row_array();
						if(!$spec_Row){
							$spec_Row['price'] = 0;
							$spec_Row['price2'] = 0;
						}

						$value['detail'] = str_replace("&","&amp;",$value['detail']);
						$value['detail'] = str_replace("\n","",$value['detail']);
						$value['detail'] = str_replace("<br />","",$value['detail']);
						$value['detail'] = strip_tags($value['detail']);

						$tData=array();
						$tData["SKU"]=$value['id'];
						$tData["Name"]=str_replace("&","&amp;",$value['name']);
						$tData["Description"]=(empty($value['detail']))?$tData["Name"]:$value['detail'];//避免沒有填簡述的防呆 by lota
						$tData["URL"]= str_replace("&","&amp;",FRONTEND_DOMAIN."/shopdetail_tw.php?id=".$value['id']);
						$tData["LargeImage"]=FRONTEND_DOMAIN."/_i/assets/upload/shop/".$value['pic1']; 
					
						$tData["Price"]=$spec_Row['price'];				
						$tData["SalePrice"]=$spec_Row['price2'];   

						$tData["UPC"]=!empty($value['upc'])?$value['upc']:'';//非必填，最大20字元，UPC商品條碼
					    $tData["ISBN"]=!empty($value['isbn'])?$value['isbn']:''; //非必填，最大13個字元，ISBN書碼 
					    $tData["MPN"]=!empty($value['mpn'])?$value['mpn']:'';//非必填，最大13個字元，ISBN書碼  
					    $tData["Manufacturer"]=!empty($value['manufacturer'])?$value['manufacturer']:'';//非必填，最大255個字元，製造商名稱   
					    $tData["Brand"]=!empty($value['brand'])?$value['brand']:'';//非必填，最大255個字元，品牌名稱 
					    $tData["EAN"]=!empty($value['brand'])?$value['brand']:'';//非必填
					    $tData["Category"]=!empty($cRow['name'])?$cRow['name']:'商品總覽';
	   					$tData["Condition"]="New";

					    $data_array[]=$tData;

					}
				}
			}
		}

		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<Products>\n";
		 
		foreach ($data_array as $key => $data) {
		   	$xml .= "<Product>\n";
		    $xml .= "<SKU>" . $data["SKU"] . "</SKU>\n";
		    $xml .= "<Name>" . $data["Name"] . "</Name>\n";
		    $xml .= "<Description><![CDATA" . $this->stripInvalidXml($data["Description"]) . "]]></Description>\n";
		    $xml .= "<URL>" . $data["URL"] . "</URL>\n";
		    $xml .= "<Price>" . $data["Price"] . "</Price>\n";
		    $xml .= "<LargeImage>" . $data["LargeImage"] . "</LargeImage>\n";
		    $xml .= "<SalePrice>" . $data["SalePrice"] . "</SalePrice>\n";
		    $xml .= "<UPC>" . $data["UPC"] . "</UPC>\n";
		    $xml .= "<ISBN>" . $data["ISBN"] . "</ISBN>\n";
		    $xml .= "<MPN>" . $data["MPN"] . "</MPN>\n"; 
		    $xml .= "<Manufacturer>" . $data["Manufacturer"] . "</Manufacturer>\n";
		    $xml .= "<Brand>" . $data["Brand"] . "</Brand>\n";
		    $xml .= "<Category>" . $data["Category"] . "</Category>\n";
		    $xml .= "<EAN>" . $data["EAN"] . "</EAN>\n";
		    $xml .= "<Condition>" . $data["Condition"] . "</Condition>\n";
		    $xml .= "</Product>\n";
		}
	 
		$xml .= "</Products>\n";
		$filename = "marketan.xml";

		$Path_filename = dirname(dirname(dirname(__FILE__)))."/assets/".$filename;

		$fp=fopen($Path_filename, "w");
		fwrite($fp, $xml);
		fclose($fp);

		echo '執行成功，請點選 XML檔案連結 確認完後，請提交於美安工程師!"';

	}

	// 商品複製
	/*
	 * array(
	 *		class_id => 123,
	 *		is_copy => 1,
	 *		hidden_id => 0,
	 * ),
	 *
	 */
	protected function update_run_copy($update)
	{

		$row = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and id=:id and ml_key=:ml_key',array(':id' => $update['is_copy'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		$save = $row;
		unset($save['id']);
		unset($save['update_time']);

		// 單分類排序 
		// 請去參考一般產品

		// [多分類排序]
		$class_ids_tmp = $row['class_ids'];
		$class_ids = explode(',', $class_ids_tmp);
		// 先準備好
		if($class_ids and !empty($class_ids)){
			foreach($class_ids as $k => $v){
				if($v == '') unset($class_ids[$k]);
			}
		}
		// 跟單選一樣新增相同的資料，但是不用處理排序編號
		$save['name'] = $save['name'].' (複製)';
		$save['create_time'] = date('Y-m-d H:i:s');
		$this->cidb->insert($this->data['router_class'], $save);
		$new_product_id = $this->cidb->insert_id();
		// 在每一個多選分類，都建立sort_id，在另一個資料表上
		if($class_ids and !empty($class_ids)){
			foreach($class_ids as $k => $class_id){
				$row2 = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id=:class_id',array(':class_id' => $class_id))->queryAll();
				$save = array(
					'class_id' => $class_id,
					'product_id' => $new_product_id,
					'sort_id' => count($row2) + 1,
				);
				$this->cidb->insert($this->data['router_class'].'multisort', $save);
			}
		}

		// 規格 2020-05-26
		$rows = $this->db->createCommand()->from($this->data['router_class'].'spec')->where('is_enable=1 and data_id=:id',array(':id' => $update['is_copy']))->queryAll();
		if($rows and !empty($rows)){
			foreach($rows as $row){
				$save = $row;
				unset($save['id']);
				unset($save['update_time']);
				$save['create_time'] = date('Y-m-d H:i:s');
				$save['data_id'] = $new_product_id;
				$this->cidb->insert($this->data['router_class'].'spec', $save);
			}
		}

		// 複製成功後，只會轉到列表頁，不會做像單分類複製那樣的轉到該分類的動作

		$url = $this->createUrl($this->data['router_class'].'/index');

		G::alert_and_redirect('Copy Success !', $url, $this->data);

		die;
	}

	protected function update_run_other_element($array)
	{
		// 修改不需要這個
		//$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		// 複選分類
		// 除非有使用物件繼承，不然下面的程式碼是必需要寫的
		// 不然就是要另外載入底下母體的這支檔案
		// framework/backend/components/modules/Core2crud/AAAAAAAAAA.php
		if(isset($array['class_ids']) and !empty($array['class_ids'])){
			$array['class_ids'] = ','.implode(',', $array['class_ids']).',';
		} else {
			$array['class_ids'] = '';
		}

		// 相關產品
		if(isset($array['related_ids']) and !empty($array['related_ids'])){
			$array['related_ids'] = ','.implode(',', $array['related_ids']).',';
		} else {
			$array['related_ids'] = '';
		}

		if(!isset($array['is_increase_purchase'])){
			$array['is_increase_purchase'] = 0;
		}

		if(!isset($array['is_additional_purchase'])){
			$array['is_additional_purchase'] = 0;
		}

		if(!isset($array['is_low_temperature'])){
			$array['is_low_temperature'] = 0;
		}

		if(isset($array['increase_purchase_ids']) and !empty($array['increase_purchase_ids'])){
			$array['increase_purchase_ids'] = ','.implode(',', $array['increase_purchase_ids']).',';
		} else {
			$array['increase_purchase_ids'] = '';
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		// 複選分類
		// 除非有使用物件繼承，不然下面的程式碼是必需要寫的
		// 不然就是要另外載入底下母體的這支檔案
		// framework/backend/components/modules/Core2crud/AAAAAAAAAA.php
		if(isset($array['class_ids']) and !empty($array['class_ids'])){
			$array['class_ids'] = ','.implode(',', $array['class_ids']).',';
		} else {
			$array['class_ids'] = '';
		}

		// 相關產品
		if(isset($array['related_ids']) and !empty($array['related_ids'])){
			$array['related_ids'] = ','.implode(',', $array['related_ids']).',';
		} else {
			$array['related_ids'] = '';
		}

		if(!isset($array['is_additional_purchase'])){
			$array['is_additional_purchase'] = 0;
		}

		if(!isset($array['is_low_temperature'])){
			$array['is_low_temperature'] = 0;
		}

		if(isset($array['increase_purchase_ids']) and !empty($array['increase_purchase_ids'])){
			$array['increase_purchase_ids'] = ','.implode(',', $array['increase_purchase_ids']).',';
		} else {
			$array['increase_purchase_ids'] = '';
		}

		//Ming 2018-12-18 來信 指示 資料更新後，點擊送出後需返回列表頁 ( 所有單元都是 ),設定非資訊部人員才會動作 by lota
		if(!preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
			$array['update_base64_url'] = '';
		} 

		return $array;
	}

	//解無限層分類
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('is_enable=1 and pid='.$id.' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
		if($rows and !empty($rows)){
			foreach($rows as $v){						
				$data[$v['id']] = $tt.$v['name'];
				$data = $this->layout_show($v['id'],$k+1,$tt,$table,$data);
			}
			return $data;
		}else
			return $data;		
	}

	protected function update_run_last()
	{
		$_POST['itemspec']['data_id'] = $this->data['id'];
		$_POST['itemspec']['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
		$gg = $this->multi_field_v1('itemspec', 'shopspec', 'name|spec|inventory|price|price3|price2', 'spec', 0);//第四個參數是選擇哪個當必填 //2021-10-07 改為規格必填
		
		//2020-12-10
		if(!$gg){
			L::alert_and_back('購買規格的規格必填',$this->data);
			die;
		}

		// 把第一個規格的價格，更新到主資料表，為了簡化搜尋
		$row = $this->cidb->select('id,price2 as price_search')->where('is_enable',1)->where('data_id',$this->data['id'])->get('shopspec')->row_array();
		if($row and isset($row['id'])){
			unset($row['id']);
			$this->cidb->where('id', $this->data['id']);
			$this->cidb->update('shop',$row); 
			// echo $this->cidb->affected_rows();
		}

		eval($this->data['empty_orm_eval']);
		$c = new $name('insert', $this->data['def']['empty_orm_data_related']);
		$c::model()->deleteAll('type=:type and ml_key=:ml_key and other1=:id', array(':type'=>$this->data['router_class'].'promotionrelatedids',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['id']));

		if(isset($_POST['promotion_ids']) and !empty($_POST['promotion_ids'])){
			$save = array();
			foreach($_POST['promotion_ids'] as $k => $v){
				$tmp = array(
					'type' => $this->data['router_class'].'promotionrelatedids',
					'ml_key' => $this->data['admin_switch_data_ml_key'],
					'class_id' => $v,
					'other1' => $this->data['id'],
					'is_enable' => 1,
				);
				$save[] = $tmp;
			}
			$this->cidb->insert_batch('html', $save);
		}
	}

	protected function create_run_last()
	{
		$_POST['itemspec']['data_id'] = $this->data['_last_insert_id'];
		$_POST['itemspec']['from_user_id'] = (isset($_SESSION['authw_admin_id']))?$_SESSION['authw_admin_id']:'form1';
		$gg = $this->multi_field_v1('itemspec', 'shopspec', 'name|spec|inventory|price|price3|price2', 'spec', 0);//第四個參數是選擇哪個當必填 //2021-10-07 改為規格必填

		//2020-12-10 2021-10-07 新增不彈跳提醒，不然資料建立流程會有問題
		// if(!$gg){
		// 	L::alert_and_back('購買規格的商品編號必填',$this->data);
		// 	die;
		// }

		// 把第一個規格市價和會員價，更新到主資料表，為了簡化搜尋
		$row = $this->cidb->select('id,price2 as price_search')->where('is_enable',1)->where('data_id',$this->data['_last_insert_id'])->get('shopspec')->row_array();
		if($row and isset($row['id'])){
			unset($row['id']);
			$this->cidb->where('id', $this->data['_last_insert_id']);
			$this->cidb->update('shop',$row); 
			// echo $this->cidb->affected_rows();
		}

		eval($this->data['empty_orm_eval']);
		$c = new $name('insert', $this->data['def']['empty_orm_data_related']);
		$c::model()->deleteAll('type=:type and ml_key=:ml_key and other1=:id', array(':type'=>$this->data['router_class'].'promotionrelatedids',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['_last_insert_id']));

		if(isset($_POST['promotion_ids']) and !empty($_POST['promotion_ids'])){
			$save = array();
			foreach($_POST['promotion_ids'] as $k => $v){
				$tmp = array(
					'type' => $this->data['router_class'].'promotionrelatedids',
					'ml_key' => $this->data['admin_switch_data_ml_key'],
					'class_id' => $v,
					'other1' => $this->data['_last_insert_id'],
					'is_enable' => 1,
				);
				$save[] = $tmp;
			}
			$this->cidb->insert_batch('html', $save);
		}

		/*
		 * 2020-08-19
		 * 試著寫寫看，新增的時候，會是第一筆
		 */
		if(isset($this->data['origin_condition'])){
			$sort_field = 'sort_id';
			if(isset($this->data['datasave']['class_id']) and $this->data['datasave']['class_id'] > 0){ // 有單選的情況，先改零，在重排
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));
				
				// 單分類排序
				//$conditions[] = $k.'='.$v;

				$this->data['origin_condition'][0][1] .= ' AND class_id='.$this->data['datasave']['class_id'].' ';

				// 重新排序
				// 目前Fieldsorter不支援where以外的方法
				if(isset($this->data['def']['listfield'][$sort_field])){
					$fieldsorter = new Fieldsorter;
					$fieldsorter->setTableName($this->data['def']['table']);
					$fieldsorter->setIdName($this->data['def']['func_field']['id']);
					$fieldsorter->setCondition($this->data['origin_condition']);
					$fieldsorter->refresh('', array(),'', $sort_field);
				}
			} elseif (isset($this->data['datasave']['class_ids']) and $this->data['datasave']['class_ids'] !='') { //複選類別 預設使用 class_ids
				//將勾選的分類解析出來
				$_class_ids = array_filter(explode(',',$this->data['datasave']['class_ids']));
				if(count($_class_ids) > 0){
					//將勾選的分類分別的寫入專屬資料表
					foreach ($_class_ids as $key => $value) {
						$_data = array(
							'product_id' => $this->data['_last_insert_id'],
							'class_id' => $value,
							$sort_field => 0,
						);
						$this->cidb->insert($this->data['def']['table'].'multisort', $_data);					

						$this->data['origin_condition'][0][1] = ' class_id='.$value.' ';

						$fieldsorter = new Fieldsorter;
						$fieldsorter->setTableName($this->data['def']['table'].'multisort');
						$fieldsorter->setIdName($this->data['def']['func_field']['id']);
						$fieldsorter->setCondition($this->data['origin_condition']);
						$fieldsorter->refresh('', array(),'', $sort_field);	
					}	

					//如果已經按下search，那就先處理一下 , 從 actionSearch 拷貝過來的
					$ss = $this->data['router_class'].'_search';
					$session = Yii::app()->session[$ss];
					if($session === null){
						$session = array();
					}
					if(isset($session) and !empty($session)){
						$conditions = array();
						$conditions_sortable = array();
						foreach($session as $k => $v){
							if($v == '') unset($session[$k]);
							if($k == 'class_id' and $v == -1) unset($session[$k]);
							if($k == 'class_id' and $v == 0) unset($session[$k]);
							if($k == 'icon' and $v == '') unset($session[$k]);
						}
					}
					if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
						// 把該分類的sort_id洗掉，然後載入多分類排序資料表的資料，然後更新它
						$class_id = $session['class_id'];
						$rows = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id='.$class_id)->order('sort_id')->queryAll();
						if($rows){
							foreach($rows as $k => $v){
								$data = array(
									'sort_id' => $v['sort_id'],
								);
								//$this->cidb->where('id',$v['product_id'])->update($this->data['router_class'], $data);
								$this->cidb->query('update '.$this->data['router_class'].' set sort_id='.$v['sort_id'].' where id='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');
							}
						}
					}

				}
			} elseif(!isset($this->data['datasave']['class_id']) and !isset($this->data['datasave']['class_id'])){ // 分項的情況
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));

				$fieldsorter = new Fieldsorter;
				$fieldsorter->setTableName($this->data['def']['table']);
				$fieldsorter->setIdName($this->data['def']['func_field']['id']);
				$fieldsorter->setCondition($this->data['origin_condition']);
				$fieldsorter->refresh('', array(),'', $sort_field);
			}
		}
	}

	public function actionSearch()
	{
		if(!empty($_POST)){
			$ss = $this->data['router_class'].'_search';
			$session = Yii::app()->session[$ss];
			if($session === null){
				$session = array();
			}
			// 處理一下checkbox的欄位
			if($session){
				foreach($session as $k => $v){
					if(preg_match('/^checkbox_/', $k)){
						unset($session[$k]);
					}
				}
			}
			foreach($_POST as $k => $v){
				$session[$k] = $v;
			}
			Yii::app()->session[$ss] = $session;

			// [多分類排序]
			if(isset($session) and !empty($session)){
				$conditions = array();
				$conditions_sortable = array();
				foreach($session as $k => $v){
					if($v == '') unset($session[$k]);
					if($k == 'class_id' and $v == -1) unset($session[$k]);
					if($k == 'class_id' and $v == 0) unset($session[$k]);
					if($k == 'icon' and $v == '') unset($session[$k]);
				}
			}
			if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
				// 把該分類的sort_id洗掉，然後載入多分類排序資料表的資料，然後更新它
				$class_id = $session['class_id'];
				$rows = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id='.$class_id)->order('sort_id')->queryAll();
				if($rows){
					foreach($rows as $k => $v){
						$data = array(
							'sort_id' => $v['sort_id'],
						);
						//$this->cidb->where('id',$v['product_id'])->update($this->data['router_class'], $data);
						$this->cidb->query('update '.$this->data['router_class'].' set sort_id='.$v['sort_id'].' where id='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');
					}
				}
			}

			$this->redirect($this->createUrl($this->data['router_class'].'/index'));
		}
	}

	// [多分類排序]
	// 把一般排序後的結果，轉移到另一個資料表寫入
	protected function sort_last()
	{
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		$class_id = $session['class_id'];

		// 搜尋產品的多分類欄位，將它們的排序編號，寫入另一個資料表
		// 記得寫入之前要先把另一個資料表的該分類的資料刪掉
		$this->cidb->where('class_id', $class_id)->delete($this->data['router_class'].'multisort'); 
		// 這裡的Query語法，應該要跟search()裡面的一樣
		$rows = $this->db->createCommand()->from($this->data['router_class'])->where('ml_key=:ml_key and class_ids like "%,'.$class_id.',%"',array(':ml_key'=>$this->data['ml_key']))->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				$data = array(
					'class_id' => $class_id,
					'product_id' => $v['id'],
					'sort_id' => $v['sort_id'],
				);
				$this->cidb->insert($this->data['router_class'].'multisort', $data); 
			}
		}
	}
	
	// 刪除後要做的事情
	protected function delete_last()
	{
		// 前台主選單的資料表功能
		$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();

		if($rowg){
			if(isset($rowg['other26']) and $rowg['other26'] == '1'){ // 是否為“多分類排序”
				$this->cidb->where('product_id', $this->data['id'])->delete($this->data['router_class'].'multisort'); 
			}
		}

		// 跟著刪除規格
		$this->cidb->where('data_id', $this->data['id'])->delete($this->data['router_class'].'spec'); 
	}

	//多圖 - 子節點
	public function actionShopphoto($param)
     {
        $ss = 'shopphoto_node';
        $session = Yii::app()->session[$ss];
        $session['parent'] = 'shop';
        $session['value'] = $param;
        $session['field'] = 'class_id';
        Yii::app()->session[$ss] = $session;

        $this->redirect($this->createUrl('shopphoto/index'));
    }

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

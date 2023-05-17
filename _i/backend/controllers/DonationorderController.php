<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',__FILE__);
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'disable_create' => true,
		'disable_action' => true,
		'table' => 'orderform',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'orderform',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),

		// 在各功能的上面的新增的右邊
		'index_buttons' => array(
			array(
				'name' => '匯出<i class="icon-external-link"></i>',  // 按鈕的名稱和圖示
				'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
				'id' => '', // button
				'class' => 'btn btn-info', // button
				'onclick' => 'javascript:location.href=\'XXX\'',
			),
		),

		'default_sort_field' => 'create_time', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('id'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'id', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'id', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'condition' => array(
			array(
				'where',
				'is_enable=1',
			),
		),
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=orderstatus/sort', // ajax post都會有個目標
		//),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			//'pic1' => array(
			//	//'label' => '圖片',
			//	'mlabel' => array(
			//		null, // category
			//		'Image', // label
			//		array(), // sprintf
			//		'代表圖', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => false,
			//	'kcfinder_small_img' => true,
			//),


			// 'notepay' => array(
			// 	'label' => '付款通知',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Title', // label
			// 	//	array(), // sprintf
			// 	//	'標題', // default
			// 	//),
			// 	'width' => '12%',
			// 	'sort' => true,
			// ),



			'order_number' => array(
				'label' => '編號',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),


			'item_name' => array(
				'label' => '捐款項目',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),


			'create_time' => array(
				'label' => '捐款日期',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'buyer_name' => array(
				'label' => '會員姓名',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'total' => array(
				'label' => '捐款金額',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'payment_func_name' => array(
				'label' => '付款方式',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'order_status_name' => array(
				'label' => '處理狀態',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'xx01' => array(
				'label' => '捐款明細',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'url_id' => 'update',
				'width' => '12%',
				'sort' => true,
			),
			//'start_date' => array(
			//	//'label' => '日期',
			//	'mlabel' => array(
			//		null, // category
			//		'Date', // label
			//		array(), // sprintf
			//		'日期', // default
			//	),
			//	'width' => '15%',
			//	'sort' => true,
			//),
			//'is_news' => array(
			//	//'label' => 'ml:Sort id',
			//	'mlabel' => array(
			//		null, // category
			//		'Show News', // label
			//		array(), // sprintf
			//		'顯示在快訊', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//	'ezfield' => 'is_news',
			//	'ezother'=> '&nbsp;',
			//),
			//'is_home' => array(
			//	//'label' => 'ml:Sort id',
			//	'mlabel' => array(
			//		null, // category
			//		'Show Home', // label
			//		array(), // sprintf
			//		'顯示在首頁', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//	'ezfield' => 'is_home',
			//	'ezother'=> '&nbsp;',
			//),
			//'is_enable' => array(
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
			//'sort_id' => array(
			//	'label' => 'ml:Sort id',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
		), // listfield
		'searchfield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'jquery.datepicker',
			),
			//'smarty_javascript' => '',
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
$('#start_date').datepicker({dateFormat: 'yy-mm-dd'});
$('#end_date').datepicker({dateFormat: 'yy-mm-dd'});
			",
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
						// 'buyer_login_account' => array(
						// 	'label' => '帳號(Email)',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'公司名稱', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'buyer_login_account',
						// 		'name' => 'buyer_login_account',
						// 		'size' => '20',
						// 	),
						// ),
						'buyer_name' => array(
							'label' => '姓名',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'buyer_name',
								'name' => 'buyer_name',
								'size' => '20',
							),
						),
						'order_number' => array(
							'label' => '編號',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'order_number',
								'name' => 'order_number',
								'size' => '20',
							),
						),
						
						
						'start_date' => array(
							'label' => '捐贈日期',
							//'mlabel' => array(
							//	null, // category
							//	'Date', // label
							//	array(), // sprintf
							//	'日期', // default
							//),
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								'id' => 'start_date',
								'name' => 'start_date',
								'size' => '10',
								'readonly' => 'readonly',
							),
						),
						'end_date' => array(
							'label' => ' ∼ ',
							//'mlabel' => array(
							//	null, // category
							//	'Date', // label
							//	array(), // sprintf
							//	'日期', // default
							//),
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								'id' => 'end_date',
								'name' => 'end_date',
								'size' => '10',
								'readonly' => 'readonly',
							),
						),
						//'order_status' => array(
						//	'label' => '訂單狀態',
						//	'type' => 'select3',
						//	//'type' => 'select5',
						//	//'merge' => '1', // 頭中尾的頭(1)
						//	'attr' => array(
						//		'id' => 'order_status',
						//		'name' => 'order_status',
						//	),
						//	'other' => array(
						//		//'values' => array(
						//		//	'1' => '左上',
						//		//	'2' => '中上',
						//		//	'3' => '右上',
						//		//	'4' => '正左',
						//		//	'5' => '正中',
						//		//	'6' => '正右',
						//		//	'7' => '左下',
						//		//	'8' => '正下',
						//		//	'9' => '右下',
						//		//),
						//		//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						//		//'default' => 'center',
						//		'values' => array(
						//			'-1' => '請選擇',
						//		),
						//		'default' => '-1',
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
						'order_number' => array(
							'label' => '編號',
							'merge' => '1',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'create_time' => array(
							'label' => '捐款日期　',
							'merge' => '3',
							'type' => 'nothing',
						),


						'item_name' => array(
							'label' => '捐款項目',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),



						'total' => array(
							'label' => '捐款金額',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),




						'buyer_name' => array(
							'label' => '姓名',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),

						'buyer_phone' => array(
							'label' => '聯絡電話',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),


						'buyer_login_account' => array(
							'label' => '電子郵件',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),


						
					
						'payment_func_name' => array(
							'label' => '付款方式',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),

						'payRegular' => array(
							'label' => '定期定額總期數',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),

						'TotalSuccessTimes' => array(
							'label' => '定期定額已執行期數',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),

						//atm
						'vbank_code' => array(
							'label' => '銀行代碼',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),



						'vbank_account' => array(
							'label' => '捐贈帳號',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),



						'expiredate' => array(
							'label' => '付款期限',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),




						'getcvsmsg' => array(
							'label' => '取號狀況',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						), // atm


						//cvs

						'paymentno' => array(
							'label' => '超商付款代號',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						//cvs


						







						'rtnmsg' => array(
							'label' => '交易狀況',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),








						'title' => array(
							'label' => '收據抬頭',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),


						// 'isUploadIRS_YN' => array(
						// 	'label' => '是否上傳國稅局',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-3">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),


						// 'isCatholics' => array(
						// 	'label' => '捐款單位',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-3">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),





						'identity' => array(
							'label' => '身分別',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),


						'personId' => array(
							'label' => '身份證號/公司統編',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'receipt' => array(
							'label' => '紙本收據',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'address' => array(
							'label' => '收據地址',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'order_status' => array(
							'label' => '處理狀態',
							'type' => 'select3',
							'attr' => array(
								'id' => 'order_status',
								'name' => 'order_status',
							),
							'other' => array(
								'values' => array(
									'0'=>'未捐款',
									'1'=>'已捐贈',
									'2'=>'收據寄出',
									'3'=>'未完成捐款作業',

								),
								'default' => '0',
							),
						),
						'detail' => array(
							'label' => '備註事項',
							'type' => 'label',
						),
						// 'support' => array(
						// 	'label' => '護持項目',
						// 	'type' => 'label',							
						// ),
					),
				),
				// section
				// array(
				// 	'form' => array('enable' => false),
				// 	'type' => '1',
				// 	'field' => array(
				// 		'atm_name' => array(
				// 			'label' => 'ATM | 匯款人姓名',
				// 			'type' => 'nothing',
				// 		),

				// 		'atm_bank' => array(
				// 			'label' => 'ATM | 匯款銀行',
				// 			'type' => 'nothing',
				// 		),
				// 		'atm_number' => array(
				// 			'label' => 'ATM | 末五碼',
				// 			'type' => 'nothing',
				// 		),
				// 		'atm_price' => array(
				// 			'label' => 'ATM | 匯款金額',
				// 			'type' => 'nothing',
				// 		),
				// 		'atm_date' => array(
				// 			'label' => 'ATM | 匯款日期',
				// 			'type' => 'nothing',
				// 		),
				// 		'atm_memo' => array(
				// 			'label' => 'ATM | 匯款備註說明',
				// 			'type' => 'nothing',
				// 		),
				// 	),
				// ),
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						'detail_admin' => array(
							'label' => '捐款單備註(內部使用)',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail_admin',
								'name' => 'detail_admin',
								//'rows' => '4',
								//'cols' => '40',
							),
						),
					),
				),
				// array(
				// 	'form' => array('enable' => false),
				// 	'type' => '2',
				// 	'field' => array(
				// 		'detail_cancel' => array(
				// 			'label' => '備註',
				// 			//'type' => 'textarea',
				// 			'type' => 'textarea',
				// 			'attr' => array(
				// 				//'class' => 'form-control', // 這…手動加上去好了
				// 				'id' => 'detail_cancel',
				// 				'name' => 'detail_cancel',
				// 				'rows' => '10',
				// 				'cols' => '100',
				// 			),
				// 		),
				// 	),
				// ),





			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		//if(isset($this->def['sortable'])){
		//	$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		//}

		$this->def['index_buttons'][0]['onclick'] = 'javascript:location.href=\''.$this->createUrl($this->data['router_class'].'/excelexport').'\'';

		// 這裡只標示付款方式的區塊哦！
		$this->data['section_map'] = array(
			//'general' => 0,
			'atm' => 1,
			//'comment' => 2,
		);

		// 從前台複製過來的，等確認後，這個要存在資料庫哦！
		$this->data['payments_tmp'] = array(
			array(
				'name' => 'ATM轉帳',
				'func' => 'atm', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),


			array(
				'name' => '網路ATM',
				'func' => 'web_atm', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),


			array(
				'name' => '貨到付款',
				'func' => 'cash_on_delivery', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),


			array(
				'name' => '超商代碼付款',
				'func' => 'store_ibon', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),


			array(
				'name' => '線上刷卡',
				'func' => 'credit_car', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),

				
			array(
				'name' => 'PAYPAL',
				'func' => 'paypal', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),





		);

		$this->data['payments_tmp2'] = array();
		foreach($this->data['payments_tmp'] as $k => $v){
			$this->data['payments_tmp2'][$v['func']] = $v;
		}
		// 展開右上角工具列
		// $this->data['tools'] = array(
		// 	array(
		// 		'class' => '',
		// 		'target' => '',
		// 		'url' => $this->createUrl($this->data['router_class'].'/export'),
		// 		'name' => '匯出訂單',
		// 	),
		// );

		$this->def['searchfield']['sections'][0]['field']['checkbox_order_status']['attr_td1'] = array('width' => '160');

		// 訂單狀態
		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>str_replace('orderform','',$this->data['router_class']).'orderstatus'))->order('sort_id asc')->queryAll();
		$this->data['orderstatus_tmp'] = array();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->data['orderstatus_tmp'][$v['other1']] = $v['topic'];
				//$this->def['searchfield']['sections'][0]['field']['order_status']['other']['values'][$v['other1']] = $v['topic'];
				$this->def['updatefield']['sections'][0]['field']['order_status']['other']['values'][$v['other1']] = $v['topic'];
			}
		}

		/*
		 * 我打算規劃的訂單狀態
		 * 0 未付款
		 * 1 己付款
		 * 2 己出貨
		 *
		 * 所有錯誤類的都從11開始
		 * 11 己通知付款
		 * 12 付款失敗
		 * 
		 * 99 取消訂單
		 */
		$this->data['orderstatus_tmp'] = array(
			0 => '未捐贈',
			1 => '己捐贈',
			2 => '收據寄出',
			3 => '未完成捐款作業',
		);




		// $rows = $this->db->createCommand()->from(str_replace('orderform','',$this->data['router_class']).'paymenttype')->where('is_enable=1')->order('sort_id asc')->queryAll();
		// $this->data['paymenttype_tmp'] = array();
		// if($rows and count($rows) > 0){
		// 	foreach($rows as $k => $v){
		// 		$this->data['paymenttype_tmp'][$v['func']] = $v['name'];
		// 	}
		// }

				//if(isset($this->data['paymenttype_tmp'][$v['payment_type']])){
				//	$v['payment_type_name'] = $this->data['paymenttype_tmp'][$v['payment_type']];
				//}
		// 金流，這個寫法或許是暫時的，等欄位和功能都大致確認了以後在考慮寫到資料表裡面
		$payments_tmp = array(
			array(
				'name' => 'ATM轉帳',
				'func' => 'atm', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),


			array(
				'name' => 'ATM轉帳',
				'func' => 'web_atm', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),




			array(
				'name' => '貨到付款',
				'func' => 'cash_on_delivery', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),



			array(
				'name' => '超商代碼付款',
				'func' => 'store_ibon', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),



			array(
				'name' => '線上刷卡',
				'func' => 'credit_car', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),



			array(
				'name' => 'PAYPAL',
				'func' => 'paypal', // 程式名稱
				'description' => 'xxx', // 就…說明

				// 是否需要通知付款的按鈕
				'payment_notice' => true,

				// 先付還是後付，先付通常是要跑金流，也就是線上付款
				// 後付的話，通常是轉帳、劃撥
				'has_postpay' => true, // ATM是後付

				'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

				'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
			),




		);

		$this->data['paymenttype_tmp'] = array();
		foreach($payments_tmp as $k => $v){
			$this->data['paymenttype_tmp'][$v['func']] = $v;
		}

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		//$this->data['updatecontent']['order_status'] = -1;

		//$condition = 'is_checkout = 0 ';
		$condition = 'is_enable = 1 ';
		//$condition = ' type=\'layoutv2class2\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$condition_sortable = ' type="layoutv2class2" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			$conditions = array();
			//$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){
					$conditions[] = $k.'='.$v;
					//$conditions_sortable[] = $k.'='.$v;
				} elseif($k == 'checkbox_order_status'){ // 應該要這樣寫才對
					//$conditions[] = 'concat(\',\','.str_replace('checkbox_', '', $k).',\',\') LIKE \'%,'.implode(',', $v).',%\'';
					$tmp = array();
					foreach($v as $vv){
						$tmp[] = 'order_status=\''.$vv.'\' ';
					}
					$conditions[] = '('.implode(' OR ',$tmp).')';
				} elseif($k == 'start_date'){
					if($session['start_date'] != '' and $session['end_date'] != ''){
						//$conditions[] = ' ( create_time  >= '.$session['start_date'].' and create_time <= '.$session['end_date'].') ';
						$conditions[] = "( DATE_FORMAT(create_time, '%Y-%m-%d') <= '".($session['end_date'])."' && DATE_FORMAT(create_time, '%Y-%m-%d') >= '".($session['start_date'])."' )";
						// $conditions[] = ' ( UNIX_TIMESTAMP(create_time) >= '.strtotime($session['start_date']).' and UNIX_TIMESTAMP(create_time) <= '.strtotime($session['end_date']).') ';
					}
				} elseif($k == 'end_date'){
					// ignore
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
			// print_r($condition);die;
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

		// 無法帶入的變數中的變數，在這裡帶入
		foreach($this->def['updatefield']['sections'][0]['field'] as $k => $v){
			//$v['attr']['size'] = '50';
			$v['attr_td1']['width'] = '130';
			$this->def['updatefield']['sections'][0]['field'][$k] = $v;
		}
				

		foreach($this->def['updatefield']['sections'][1]['field'] as $k => $v){
			//$v['attr']['size'] = '50';
			$v['attr_td1']['width'] = '130';
			$this->def['updatefield']['sections'][1]['field'][$k] = $v;
		}

		return true;
	}

	protected function index_last()
	{


			//print_r($this->data['orderstatus_tmp']);

		//var_dump($this->data['listcontent']);
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				

				if($v['notepay'] == 1){
					$v['notepay'] = '<img src="../_i/backend/assetsg/images/donedone.jpg">';
				}else{
					$v['notepay'] = '';

				}
				

				$v['order_number'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>$v['id'])).'">'.$v['order_number'].'</a>';

				if(isset($this->data['paymenttype_tmp'][$v['payment_func']])){
					$v['payment_func_name'] = $this->data['paymenttype_tmp'][$v['payment_func']]['name'];
				}


				if(isset($this->data['orderstatus_tmp'][$v['order_status']])){
					$v['order_status_name'] = $this->data['orderstatus_tmp'][$v['order_status']];
				}
				$this->data['listcontent'][$k] = $v;
			}
		}

		
		



		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		$tmp = array();
		if(isset($session['checkbox_order_status']) and count($session['checkbox_order_status']) > 0){
			$tmp = $session['checkbox_order_status'];
		}
		//var_dump($tmp);
		//$tmp = explode(',', $this->data['updatecontent']['industry_ids']);
		// 取得所有的群組
		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type',array(':type'=>str_replace('orderform','',$this->data['router_class']).'orderstatus'))->order('sort_id')->queryAll();
		//var_dump($rows);
		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['other1']]['value'] = $v['topic'];
				if(in_array($v['other1'], $tmp)){
					//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
					$groups[$v['other1']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		//var_dump($groups);
		$this->data['updatecontent']['checkbox_order_status'] = $groups;
	}

	protected function update_show_last($updatecontent)
	{
		//print_r($this->def);


		// 付款方式
		// 為所有的付款方式，都留了一塊，如果是用那個付款方式，才會出現
		// if(isset($this->data['section_map']) and count($this->data['section_map']) > 0){
		// 	foreach($this->data['section_map'] as $k => $v){
		// 		if($updatecontent['payment_func'] != $k){
		// 			unset($this->data['def']['updatefield']['sections'][$v]);
		// 		}
		// 	}
		// }

		$updatecontent['payment_func_name'] = $this->data['payments_tmp2'][$updatecontent['payment_func']]['name'];
		// $updatecontent['buyer_phone'] = $this->CrptyPwd($updatecontent['buyer_phone']);


		if($updatecontent['payment_func'] == 'credit_car'){

			unset($this->data['def']['updatefield']['sections'][0]['field']['vbank_code']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['vbank_account']);

			unset($this->data['def']['updatefield']['sections'][0]['field']['expiredate']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['getcvsmsg']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['paymentno']);


		}elseif( $updatecontent['payment_func'] == 'store_ibon' ){
			unset($this->data['def']['updatefield']['sections'][0]['field']['vbank_code']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['vbank_account']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['payRegular']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['TotalSuccessTimes']);
		}


		// if($updatecontent['payment_func'] != 'web_atm'){

		// 	unset($this->data['def']['updatefield']['sections'][0]['field']['vbank_code']);
		// 	unset($this->data['def']['updatefield']['sections'][0]['field']['vbank_account']);


		// 	unset($this->data['def']['updatefield']['sections'][0]['field']['expiredate']);
		// 	unset($this->data['def']['updatefield']['sections'][0]['field']['getcvsmsg']);
		// }elseif($updatecontent['payment_func'] != 'store_ibon'){
		// 	unset($this->data['def']['updatefield']['sections'][0]['field']['paymentno']);
		// 	unset($this->data['def']['updatefield']['sections'][0]['field']['expiredate']);
		// }


		$updatecontent['personId'] = $updatecontent['personId'];

		$updatecontent['identity'] = $updatecontent['identity'] == 1?'個人':'公司';


		$this->data['updatecontent'] = $updatecontent;
		//var_dump($this->data['updatecontent']);die;
	}

	




	/*
	 * 這裡還沒有完成！！
	 * 先做其它地方
	 */
	public function actionExport()
	{
		

		$file_type = "vnd.ms-excel";
		$file_ending = "xls";
		$filename = "orders_".date("Y-m-d_His",time());

		

		$query = 'SELECT * FROM customer WHERE '.$this->def['condition'][0][1];
		$result_data = $this->db->createCommand($query)->queryAll();

		$this->render('//'.$this->data['router_class'].'/export', $this->data);
		die;
	}



		//解密
protected function CrptyPwd($paPwd = '') 
{
  $paPwd = substr($paPwd,-8,9999). substr($paPwd,0,-8);
  $paLogin_length = hexdec(substr($paPwd,0,2))-CODEOFFSET2; //帳號長度
  $paRtn_length = hexdec(substr($paPwd,2,2))-CODEOFFSET1;   //密碼長度
  $paRtn="";
  
  $tmp_str=substr($paPwd,4);
  $i = 0;
  if($paLogin_length >= $paRtn_length){
    
      while ($i < strlen($tmp_str))
      {
        $paRtn.= chr(hexdec(substr($tmp_str,$i,2))-CODEOFFSET1);
        $i+=4;
      }
  
  }else{
    $j = 0;
      while ($i < $paLogin_length*2)
      {
        $paRtn.= chr(hexdec(substr($tmp_str,$j,2))-CODEOFFSET1);
        $i+=2;
        $j+=4;
      }
      while ($j< strlen($tmp_str))
      {
        $paRtn.= chr(hexdec(substr($tmp_str,$j,2))-CODEOFFSET1);
        $j+=2;
      }  
  }
  return $paRtn;
}


	/*
	 * 通用匯出Excel的功能(PHP5)
	 */
	/*
	 * def可以加以下的東西
	 *
	 * 'index_buttons' => array(
	 * 	array(
	 * 		'name' => '匯出<i class="icon-external-link"></i>',
	 * 		'name2' => 'export',
	 * 		'id' => '', // button
	 * 		'class' => 'btn btn-info', // button
	 * 		'onclick' => 'javascript:location.href=\'XXX\'',
	 * 	),
	 * ),
	 *
	 * before可以加以下的東西
	 * $this->def['index_buttons'][0]['onclick'] = 'javascript:location.href=\''.$this->createUrl($this->data['router_class'].'/excelexport').'\'';
	 */
	public function actionExcelexport()
	{
		$admin_field = $this->def['updatefield']['sections'][0]['field'];
		include $_SERVER['DOCUMENT_ROOT'].'/include/export_sample.php';
	}


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

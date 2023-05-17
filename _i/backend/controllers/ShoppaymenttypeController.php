<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
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
			'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		),
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
			'name' => array(
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
							'label' => '標題',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '40',
							),
						),
						'func' => array(
							'label' => '功能',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'func',
								'name' => 'func',
							),
							'other' => array(
								'values' => array(
									'atm' => '銀行匯款/ATM轉帳',
									'cash_on_delivery' => '貨到付款',
									'allpay' => '歐付寶',
								),
								//'default' => 'center',
								//'values' => array(
								//	'0' => '請選擇',
								//),
								'default' => '',
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
						'has_invoice' => array(
							//'label' => '主要聯絡人',
							'label' => '電子發票欄位',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'has_invoice',
								'value' => '1',
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
						'detail' => array(
							'label' => '完成訂購的說明文字',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail',
								'name' => 'detail',
								'rows' => '17',
								'cols' => '40',
							),
							'other' => array(
								'html_end' => '<br /> {AA} 購買人, {BB} 訂單編號, {CC} 訂單金額',
							),
						),
						//'detail' => array(
						//	'label' => '內容',
						//	//'type' => 'textarea',
						//	'type' => 'ckeditor_js',
						//	'attr' => array(
						//		//'class' => 'form-control', // 這…手動加上去好了
						//		'id' => 'detail',
						//		'name' => 'detail',
						//		//'rows' => '4',
						//		//'cols' => '40',
						//	),
						//),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'other_allpay_choose_payment' => array(
							'label' => '指定付款方式',
							'type' => 'select5',
							'attr' => array(
								'id' => 'other_allpay_choose_payment',
								'name' => 'other_allpay_choose_payment',
							),
							'other' => array(
								'values' => array(
									'ALL' => '顯示全部付款方式',
									'Credit' => '信用卡',
									'WebATM' => '網路ATM',
									'ATM' => '自動櫃員機',
									'CVS' => '超商代碼',
									'BARCODE' => '超商代碼',
									'Alipay' => '支付寶',
									'Tenpay' => '財付通',
									'TopUpUsed' => '儲值消費',
								),
								//'default' => 'center',
								//'values' => array(
								//	'0' => '請選擇',
								//),
								'default' => '',
								'html_end' => '其它就不顯示，除非你選不指定',
							),
						),
						'other_allpay_service_url' => array(
							'label' => '介接網址',
							'type' => 'select5',
							'attr' => array(
								'id' => 'other_allpay_service_url',
								'name' => 'other_allpay_service_url',
								'size' => '40',
							),
							'other' => array(
								'values' => array(
									'http://payment-stage.allpay.com.tw/Cashier/AioCheckOut' => '測試',
									'https://payment.allpay.com.tw/Cashier/AioCheckOut' => '正式',
								),
								//'default' => 'center',
								//'values' => array(
								//	'0' => '請選擇',
								//),
								'default' => '',
							),
						),
						'other_allpay_return_url' => array(
							'label' => '回傳網址',
							'type' => 'input',
							'attr' => array(
								'id' => 'other_allpay_return_url',
								'name' => 'other_allpay_return_url',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '例：index.php?r=shoppingcar/returnurl&func=allpay',
							),
						),
						'other_allpay_merchant_id' => array(
							'label' => '商店代號',
							'type' => 'input',
							'attr' => array(
								'id' => 'other_allpay_merchant_id',
								'name' => 'other_allpay_merchant_id',
								'size' => '40',
							),
						),
						'other_allpay_hash_key' => array(
							'label' => 'Hash Key',
							'type' => 'input',
							'attr' => array(
								'id' => 'other_allpay_hash_key',
								'name' => 'other_allpay_hash_key',
								'size' => '40',
							),
						),
						'other_allpay_hash_iv' => array(
							'label' => 'Hash IV',
							'type' => 'input',
							'attr' => array(
								'id' => 'other_allpay_hash_iv',
								'name' => 'other_allpay_hash_iv',
								'size' => '40',
							),
						),
						'other_allpay_has_invoice' => array(
							//'label' => '主要聯絡人',
							'label' => '電子發票功能',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'other_allpay_has_invoice',
								'value' => '1',
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

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 無法帶入的變數中的變數，在這裡帶入
		//$this->def['condition'][0][0] = 'where';
		//$this->def['condition'][0][1] = 'type=\'paymenttype\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$this->def['sortable']['condition'] = 'type="paymenttype" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		return true;
	}

	//protected function index_last()
	//{
	//	//var_dump($this->data['listcontent']);
	//	if($this->data['listcontent']){
	//		foreach($this->data['listcontent'] as $k => $v){
	//			if($v['pic1'] != ''){
	//				$v['pic1'] = $this->data['image_upload_path'].'/paymenttype/'.$v['pic1'];
	//			}
	//			$this->data['listcontent'][$k] = $v;
	//		}
	//	}
	//}

	protected function update_run_other_element($array)
	{

		if(!isset($array['has_invoice'])){
			$array['has_invoice'] = 0;
		}

		if(!isset($array['other_allpay_has_invoice'])){
			$array['other_allpay_has_invoice'] = 0;
		}

		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	//protected function create_run_other_element($array)
	//{
	//	$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
	//	$array['type'] = $this->data['router_class'];
	//	return $array;
	//}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

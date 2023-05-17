<?php

class HomeController extends Controller
{
	protected $def = array(
		'table' => 'member',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'member',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('login_account, email', 'required'),
				array('email', 'email'),
			),
		),
		'default_sort_field' => 'login_account', // 預設要排序的欄位
		'search_keyword_field' => array('login_account', 'name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'login_account', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'login_account', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'condition' => array(
		//	array(
		//		'where',
		//		'is_hidden=0',
		//	),
		//),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'login_account' => array(
				'label' => '帳號',
				'width' => '15%',
				'sort' => true,
			),
			'name' => array(
				'label' => '姓名',
				'width' => '25%',
				'sort' => true,
			),
			//'ml_key' => array(
			//	'label' => '語系',
			//	'width' => '12%',
			//	'sort' => true,
			//	'mls' => true,
			//	'align' => 'center',
			//),
			'latest_login_time' => array(
				'label' => '最後登入時間',
				'width' => '12%',
				'sort' => true,
				'align' => 'center',
			),
			'is_enable' => array(
				'label' => '是否啟用',
				'width' => '10%',
				'ez' => true,
				'align' => 'center',
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate'
			),
			'smarty_javascript' => '',
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
					'field' => array(
						'title1' => array(
							'label' => '&nbsp;',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'company_name',
							//	'name' => 'company_name',
							//	'size' => '30',
							//),
						),
						'company_name' => array(
							//'label' => '公司名稱',
							'mlabel' => array(
								null, // category
								'Company Name', // label
								array(), // sprintf
								'公司名稱', // default
							),
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'company_name',
							//	'name' => 'company_name',
							//	'size' => '30',
							//),
						),
						//'name' => array(
						//	//'label' => '負責人',
						//	'mlabel' => array(
						//		null, // category
						//		'Person in charge', // label
						//		array(), // sprintf
						//		'負責人', // default
						//	),
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'name',
						//	//	'name' => 'name',
						//	//	'size' => '10',
						//	//),
						//),
						//'member_contact_name' => array(
						//	//'label' => '聯絡人1',
						//	'mlabel' => array(
						//		null, // category
						//		'Main Contact', // label
						//		array(), // sprintf
						//		'聯絡人', // default
						//	),
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'name1',
						//	//	'name' => 'name1',
						//	//	'size' => '10',
						//	//),
						//),
						//'member_contact_phone' => array(
						//	//'label' => '聯絡人1',
						//	'mlabel' => array(
						//		null, // category
						//		'Main Contact Phone', // label
						//		array(), // sprintf
						//		'聯絡人電話', // default
						//	),
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'name1',
						//	//	'name' => 'name1',
						//	//	'size' => '10',
						//	//),
						//),
						//'member_contact_email' => array(
						//	//'label' => '聯絡人1',
						//	'mlabel' => array(
						//		null, // category
						//		'Main Contact Email', // label
						//		array(), // sprintf
						//		'聯絡人Email', // default
						//	),
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'name1',
						//	//	'name' => 'name1',
						//	//	'size' => '10',
						//	//),
						//),
						//'member_contact_addr' => array(
						//	//'label' => '聯絡人1',
						//	'mlabel' => array(
						//		null, // category
						//		'Main Contact Address', // label
						//		array(), // sprintf
						//		'聯絡人地址', // default
						//	),
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'name1',
						//	//	'name' => 'name1',
						//	//	'size' => '10',
						//	//),
						//),
						'company_addr' => array(
							//'label' => '公司地址',
							'mlabel' => array(
								null, // category
								'Company Address', // label
								array(), // sprintf
								'公司地址', // default
							),
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'company_addr',
							//	'name' => 'company_addr',
							//	'size' => '50',
							//),
						),
						'company_phone' => array(
							'mlabel' => array(
								null, // category
								'Company Phone', // label
								array(), // sprintf
								'公司電話', // default
							),
							'type' => 'label',
						),
						'company_fax' => array(
							'mlabel' => array(
								null, // category
								'Company Fax', // label
								array(), // sprintf
								'公司傳真', // default
							),
							'type' => 'label',
						),
						'company_url' => array(
							'mlabel' => array(
								null, // category
								'Company Url', // label
								array(), // sprintf
								'公司網址', // default
							),
							'type' => 'label',
						),
						'company_email' => array(
							//'label' => '公司電子信箱',
							'mlabel' => array(
								null, // category
								'Company Email', // label
								array(), // sprintf
								'公司電子信箱', // default
							),
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'company_email',
							//	'name' => 'company_email',
							//	'size' => '30',
							//),
						),
						'sales_name' => array(
							//'label' => '業務',
							'mlabel' => array(
								null, // category
								'Sales', // label
								array(), // sprintf
								'業務', // default
							),
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'sales_name',
							//	'name' => 'sales_name',
							//	'size' => '10',
							//),
						),
						'tco_name' => array(
							'label' => 'TCO',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'title2' => array(
							'label' => '&nbsp;',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'company_name',
							//	'name' => 'company_name',
							//	'size' => '30',
							//),
						),
						'eob_last_balance' => array(
							//'label' => '交易幣餘額',
							'mlabel' => array(
								null, // category
								'Trading currency balances', // label
								array(), // sprintf
								'交易幣餘額', // default
							),
							//'type' => 'input',
							'type' => 'label',
							'other' => array(
								'number_format' => true,
							),
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'current_credit_line' => array(
							//'label' => 'EOB信用額度',
							'mlabel' => array(
								null, // category
								'EOB Credit', // label
								array(), // sprintf
								'EOB信用額度', // default
							),
							//'type' => 'input',
							'type' => 'label',
							'other' => array(
								'number_format' => true,
							),
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'eob_canuse_balance' => array(
							//'label' => '可用餘額',
							'mlabel' => array(
								null, // category
								'Available Balance', // label
								array(), // sprintf
								'可用餘額', // default
							),
							//'type' => 'input',
							'type' => 'label',
							'other' => array(
								'number_format' => true,
							),
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'cash_over' => array(
							//'label' => '帳戶現金餘額',
							'mlabel' => array(
								null, // category
								'Cash balance account', // label
								array(), // sprintf
								'帳戶現金餘額', // default
							),
							//'type' => 'input',
							'type' => 'label',
							//'other' => array(
							//	'number_format' => true,
							//),
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						//'tco_name' => array(
						//	'label' => '臨時餘額',
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'tco_name',
						//	//	'name' => 'tco_name',
						//	//	'size' => '10',
						//	//),
						//),
						//'tco_name' => array(
						//	'label' => '未繳限制天數',
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'tco_name',
						//	//	'name' => 'tco_name',
						//	//	'size' => '10',
						//	//),
						//),
						//'tco_name' => array(
						//	'label' => '付款類型',
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'tco_name',
						//	//	'name' => 'tco_name',
						//	//	'size' => '10',
						//	//),
						//),
						'vat_number' => array(
							//'label' => '公司編號',
							'mlabel' => array(
								null, // category
								'VAT Number', // label
								array(), // sprintf
								'公司統編', // default
							),
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'bill_type_name' => array(
							'label' => '帳單',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'card_name' => array(
							'label' => '費用種類',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'title3' => array(
							'label' => '&nbsp;',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'company_name',
							//	'name' => 'company_name',
							//	'size' => '30',
							//),
						),
						'card_number_format' => array(
							'label' => '會員卡號',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'card_data_name' => array(
							'label' => '卡片類別',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						//'tco_name' => array(
						//	'label' => '卡片數',
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'tco_name',
						//	//	'name' => 'tco_name',
						//	//	'size' => '10',
						//	//),
						//),
						'tco_name' => array(
							'label' => '狀態',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'card_password' => array(
							'label' => '密碼',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						//'tco_name' => array(
						//	'label' => '優先權',
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'tco_name',
						//	//	'name' => 'tco_name',
						//	//	'size' => '10',
						//	//),
						//),
						'create_time' => array(
							'label' => '入會日期',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						//'tco_name' => array(
						//	'label' => '合約生效日',
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'tco_name',
						//	//	'name' => 'tco_name',
						//	//	'size' => '10',
						//	//),
						//),
						//'x1' => array(
						//	'label' => '凍結日期',
						//	//'type' => 'input',
						//	'type' => 'label',
						//	//'attr' => array(
						//	//	'id' => 'tco_name',
						//	//	'name' => 'tco_name',
						//	//	'size' => '10',
						//	//),
						//),
						'prev_sell' => array(
							'label' => '上次銷售',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'prev_buy' => array(
							'label' => '上次採購',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'prev_payment' => array(
							'label' => '上次付款',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
						'prev_contactus' => array(
							'label' => '上次聯繫',
							//'type' => 'input',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'tco_name',
							//	'name' => 'tco_name',
							//	'size' => '10',
							//),
						),
					),
				),
			),
		),
	);

	/*
	 * 這裡應該會做成
	 * TCO  => 導到3個顏色的畫面
	 * 業務 => 業續報表
	 */
	public function actionIndex($param='')
	{
		// 判斷session，有的話，就導到修改頁面，沒有的話，就導到簡易介面
		
		//var_dump($_SESSION['card_number_current']);
		//die;
		//if(isset($_SESSION['card_number_current']) and $_SESSION['card_number_current'] != ''){
			$this->redirect($this->createUrl('home/update'));

			//} else {
			//	$row = $this->db->createCommand()->from('member')->where('id='.$this->data['admin_id'])->queryRow();
			//	$_SESSION['card_number_current'] = $row['card_number'];
			//	$this->redirect($this->createUrl('home/update'));

			//$this->redirect($this->createUrl('home/simple'));
		//}

	}

	public function actionUpdate($param = '')
    {
		$this->data['main_content'] = 'home/simple';
		$this->display('index.htm', $this->data);
	}

	// 當點右上角的首頁的時候，會做的動作
	public function actionPersonalhome()
	{
		//$_SESSION['card_number_current'] = '';
		$this->redirect($this->createUrl('home/simple'));
	}

	public function actionSimple()
	{
		//if(!isset($_SESSION['card_number_current']) or $_SESSION['card_number_current'] == ''){
		//	$row = $this->db->createCommand()->from('member')->where('id='.$this->data['admin_id'])->queryRow();
		//	$_SESSION['card_number_current'] = $row['card_number'];
		//}
		$this->redirect($this->createUrl('home/update'));

		//$this->display('index.htm', $this->data);
	}
}

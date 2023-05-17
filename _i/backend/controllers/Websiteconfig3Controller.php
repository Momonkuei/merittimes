<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,

		'table' => 'product',
		'orm' => 'G_product_orm',
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('name_en'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name_en', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name_en', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'data_multilanguage_update' => 'model', // 在資料內頁中，切換多國語系，依照某一個欄位
		// 建立前端要顯示的欄位
		'listfield_attr' => array(
			//'smarty_include_top' => 'product/main_content_top.htm',
		),
		'listfield' => array(
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader', 'jquery-ui', 
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
					'label' => '一般設定',
					'section_title' => '相關資訊',
					'field' => array(
						'sys_config_seo_description' => array(
							'label' => '全站 Description',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_seo_description',
								'name' => 'sys_config_seo_description',
								'title' => '建議在 125 個字元以內',
								'value' => '',
								'rows' => '6',
								'cols' => '80',
							),
						),
						'sys_config_seo_keyword' => array(
							'label' => '全站 Keyword',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_seo_keyword',
								'name' => 'sys_config_seo_keyword',
								'title' => '可設定多組關鍵字，請使用 , 鍵隔開',
								'value' => '',
								'rows' => '6',
								'cols' => '80',
							),
						),
						// 'sys_config_seo_index_footer_h1_content' => array(
						// 	'label' => '首頁的頁尾H1連結',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_seo_index_footer_h1_content',
						// 		'name' => 'sys_config_seo_index_footer_h1_content',
						// 		'title' => '',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),
						/*
						'sys_config_frontend_phone' => array(
							'label' => '公司電話',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_frontend_phone',
								'name' => 'sys_config_frontend_phone',
								//'value' => '',
								'size' => '30',
							),
						),
						'sys_config_frontend_address' => array(
							'label' => '公司地址',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_frontend_address',
								'name' => 'sys_config_frontend_address',
								//'value' => '',
								'size' => '30',
							),
						),
						'sys_config_frontend_email' => array(
							'label' => '公司信箱',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_frontend_email',
								'name' => 'sys_config_frontend_email',
								//'value' => '',
								'size' => '30',
							),
						),
						*/
						'sys_config_google_analytics_tracking_code' => array(
							'label' => 'Google Log分析',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_google_analytics_tracking_code',
								'name' => 'sys_config_google_analytics_tracking_code',
								//'value' => '',
								'size' => '20',
							),
							'other' => array(
								'html_end' => '例如:UA-XXXXXXXX-X',
							),
						),
						// 'sys_config_facebook_message' => array(
						// 	'label' => 'Facebook Message',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'sys_config_facebook_message',
						// 		'name' => 'sys_config_facebook_message',
						// 		//'value' => '',
						// 		'size' => '20',
						// 	),
						// 	'other' => array(
						// 		'html_end' => '例如:XXXXXXXXXXXXXXX',
						// 	),
						// ),
						/*
						'sys_config_google_map' => array(
							'label' => 'Google地圖(iframe)',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_google_map',
								'name' => 'sys_config_google_map',
								//'value' => '',
								//'size' => '20',
								'rows' => '4',
								'cols' => '40',
							),
						),
						'sys_config_google_map2' => array(
							'label' => 'Google地圖(URL)',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_google_map2',
								'name' => 'sys_config_google_map2',
								//'value' => '',
								//'size' => '20',
								'rows' => '4',
								'cols' => '40',
							),
						),
						'sys_config_footer_contact' => array(
							'label' => '頁尾連絡資訊',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_footer_contact',
								'name' => 'sys_config_footer_contact',
								//'value' => '',
								//'size' => '20',
								'rows' => '4',
								'cols' => '40',
							),
						),
						'sys_config_footer' => array(
							'label' => '頁尾copyright',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_footer',
								'name' => 'sys_config_footer',
								//'value' => '',
								//'size' => '20',
								'rows' => '4',
								'cols' => '40',
							),
						),
						*/
						'sys_config_has_seo' => array(
							'label' => 'SEO',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'sys_config_has_seo',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '<span style="color:red">*現在只剩產品分類內的輸入TDK舊介面在使用</span>',
							),
						),
						//'xxx01' => array(
						//	'label' => '其它商品圖',
						//	'type' => 'kcfinder',
						//	'attr' => array(
						//		'id' => 'xxx01',
						//		'name' => 'xxx01',
						//		'width' => '100%',
						//		'height' => '300px',
						//		//'title' => '',
						//	),
						//	'other' => array(
						//		'uploadurl_id' => 'assetsdir',
						//		'type' => 'product-images',
						//		//'dir' => 'files/public',
						//	),
						//),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'label' => '一般設定',
					'section_title' => '網站設定',
					'field' => array(
						'sys_config_admin_title' => array(
							'label' => '網站名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_admin_title',
								'name' => 'sys_config_admin_title',
								//'value' => '',
								'size' => '20',
							),
						),
						'sys_config_service_admin_mail' => array(
							'label' => '網站管理者E-Mail',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_service_admin_mail',
								'name' => 'sys_config_service_admin_mail',
								//'value' => '',
								'size' => '20',
							),
						),
						// 'sys_config_report' => array(
						// 	'label' => '預設報份',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'sys_config_report',
						// 		'name' => 'sys_config_report',
						// 		//'value' => '',
						// 		'size' => '20',
						// 	),
						// ),
						// 'sys_config_class_text' => array(
						// 	'label' => '班級成果側邊文字',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'sys_config_class_text',
						// 		'name' => 'sys_config_class_text',
						// 		//'value' => '',
						// 		'size' => '80',
						// 	),
						// ),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'label' => '',
					'section_title' => '購物',
					'field' => array(
						'sys_config_payment_atm' => array(
							'label' => 'ATM轉帳<br /><br />付款方式<br />說明文字',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_payment_atm',
								'name' => 'sys_config_payment_atm',
								//'title' => '建議在 125 個字元以內',
								'value' => '',
								'rows' => '6',
								'cols' => '80',
							),
						),
						'sys_config_payment_atm_bank_code' => array(
							'label' => 'ATM轉帳<br /><br />付款銀行代號',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_payment_atm_bank_code',
								'name' => 'sys_config_payment_atm_bank_code',
								//'title' => '建議在 125 個字元以內',
								//'value' => '',
								// 'rows' => '6',
								// 'cols' => '80',
							),
						),
						'sys_config_payment_atm_account' => array(
							'label' => 'ATM轉帳<br /><br />付款銀行帳號',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_payment_atm_account',
								'name' => 'sys_config_payment_atm_account',
								//'title' => '建議在 125 個字元以內',
								//'value' => '',
								// 'rows' => '6',
								// 'cols' => '80',
							),
						),
						'sys_config_payment_cash_on_delivery' => array(
							'label' => '貨到付款<br /><br />付款方式<br />說明文字',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_payment_cash_on_delivery',
								'name' => 'sys_config_payment_cash_on_delivery',
								//'title' => '建議在 125 個字元以內',
								'value' => '',
								'rows' => '6',
								'cols' => '80',
							),
						),
						// 'sys_config_payment_ecpay_credit_card' => array(
						// 	'label' => '線上刷卡<br /><br />付款方式<br />說明文字',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_payment_ecpay_credit_card',
						// 		'name' => 'sys_config_payment_ecpay_credit_card',
						// 		//'title' => '建議在 125 個字元以內',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),
						// 'sys_config_payment_ecpay_cvs' => array(
						// 	'label' => '超商代碼繳費<br /><br />付款方式<br />說明文字',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_payment_ecpay_cvs',
						// 		'name' => 'sys_config_payment_ecpay_cvs',
						// 		//'title' => '建議在 125 個字元以內',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),
						// 'sys_config_payment_ecpay_barcode' => array(
						// 	'label' => '超商條碼繳費<br /><br />付款方式<br />說明文字',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_payment_ecpay_barcode',
						// 		'name' => 'sys_config_payment_ecpay_barcode',
						// 		//'title' => '建議在 125 個字元以內',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),
						// 'sys_config_payment_ecpay_webatm' => array(
						// 	'label' => 'WEB ATM<br /><br />付款方式<br />說明文字',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_payment_ecpay_webatm',
						// 		'name' => 'sys_config_payment_ecpay_webatm',
						// 		//'title' => '建議在 125 個字元以內',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),
						// 'sys_config_payment_ecpay_vatm' => array(
						// 	'label' => '虛擬ATM<br /><br />付款方式<br />說明文字',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_payment_ecpay_vatm',
						// 		'name' => 'sys_config_payment_ecpay_vatm',
						// 		//'title' => '建議在 125 個字元以內',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),											
						// 'sys_config_payment_paypal' => array(
						// 	'label' => 'Paypal<br /><br />付款方式<br />說明文字',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_payment_paypal',
						// 		'name' => 'sys_config_payment_paypal',
						// 		//'title' => '建議在 125 個字元以內',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),
					),
				),
				//    array(
				//    	'form' => array('enable' => false),
				//    	'type' => '2',
				//    	'field' => array(						
				//    		'sys_config_pic1' => array(
				//    			'label' => '影片代表圖：(中文)',
				//    			'type' => 'fileuploader',
				//    			'other' => array(
				//    				'number' => '1',
				//    				'type' => 'photo',
				//    				'top_button' => '1',
				//    				'width' => '585',
				//    				'height' => '359',
				//    				'comment_size' => '585x359',
				//    				'no_ext' => '',
				//    				'no_need_delete_button' => '',
				//    			),
				//    		),
				//    		'sys_config_pic2' => array(
				//    			'label' => '影片代表圖：(英文)',
				//    			'type' => 'fileuploader',
				//    			'other' => array(
				//    				'number' => '2',
				//    				'type' => 'photo',
				//    				'top_button' => '1',
				//    				'width' => '585',
				//    				'height' => '359',
				//    				'comment_size' => '585x359',
				//    				'no_ext' => '',
				//    				'no_need_delete_button' => '',
				//    			),
				//    		),
				//    	),
				//    ),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		if(defined('SEO_OPEN') && SEO_OPEN == true){
		}else{
			unset($this->def['updatefield']['sections'][0]['field']['sys_config_has_seo']);
			unset($this->def['updatefield']['sections'][0]['field']['sys_config_seo_keyword']);
			unset($this->def['updatefield']['sections'][0]['field']['sys_config_seo_description']);		
		}

		//如果開啟購物功能，才會出現購物的區塊 by lota 2020-11-18
		unset($_constant_1);
		eval('$_constant_1 = '.strtoupper('shop_open').';');
		if(!$_constant_1){
			unset($this->def['updatefield']['sections'][2]);
		}
		

		// 2020-04-08 李哥說Ming說，只有公司員工才看得到
		// 2020-05-28 李哥說，相關資訊都拿掉，只有員工才看得到
		if(!preg_match('/^99999/', $this->data['admin_id'])){
			//unset($this->def['updatefield']['sections'][0]['field']['sys_config_seo_index_footer_h1_content']);
			unset($this->def['updatefield']['sections'][0]);
		}

		//if(isset($this->def['updatefield']['sections'][0])){
		//	foreach($this->def['updatefield']['sections'][0]['field'] as $k => $v){			
		//		if(preg_match('/^pic/', $k)) continue;

		//		if(isset($v['attr']['id'])){
		//			$v['attr']['id'] .= '_'.$this->data['admin_switch_data_ml_key'];
		//		}
		//		if(isset($v['attr']['name'])){
		//			$v['attr']['name'] .= '_'.$this->data['admin_switch_data_ml_key'];
		//		}
		//		$this->def['updatefield']['sections'][0]['field'][$k.'_'.$this->data['admin_switch_data_ml_key']] = $v;
		//		unset($this->def['updatefield']['sections'][0]['field'][$k]);

		//		// 這個欄位跳過
		//		if($k == 'sys_config_has_seo'){
		//		} else {
		//			continue;
		//		}
		//	}
		//}

		// 這個是新的區塊，雖然只有一個欄位
		for($x=0;$x<=9;$x++){
			if(isset($this->def['updatefield']['sections'][$x])){
				foreach($this->def['updatefield']['sections'][$x]['field'] as $k => $v){			
					if(preg_match('/^pic/', $k)) continue;

					// 這些開頭的，不會加上語系結尾(1/2)
					if(!preg_match('/^sys_config_(service|smtp|has_seo)/', $k)){
						if(isset($v['attr']['id'])){
							$v['attr']['id'] .= '_'.$this->data['admin_switch_data_ml_key'];
						}
						if(isset($v['attr']['name'])){
							$v['attr']['name'] .= '_'.$this->data['admin_switch_data_ml_key'];
						}
						$this->def['updatefield']['sections'][$x]['field'][$k.'_'.$this->data['admin_switch_data_ml_key']] = $v;
						unset($this->def['updatefield']['sections'][$x]['field'][$k]);
					}
				}
			}
		}

		/*
		 * 圖片專用的處理區段
		 */
		//    if($this->data['admin_switch_data_ml_key'] == 'tw'){
		//    	unset($this->def['updatefield']['sections'][1]['field']['sys_config_pic2']);
		//    }

		//    if($this->data['admin_switch_data_ml_key'] == 'en'){
		//    	unset($this->def['updatefield']['sections'][1]['field']['sys_config_pic1']);
		//    }

		if(defined('SEO_OPEN') && SEO_OPEN == true){
			$acl = new Admin_acl();
			$acl->start();
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.SeoController').'.php') and $acl->hasAcl($this->data['admin_id'], 'seo', 'update')){
				// 有權限的話
			} else {
				// 沒權限
				unset($this->def['updatefield']['sections'][0]['field']['sys_config_has_seo']);
			}
		}

		return true;
	}

	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;

			$list = array(
				// 前台
				'google_analytics_tracking_code',
				'facebook_message',
				'seo_keyword',
				'seo_description',
				'seo_index_footer_h1_content',
				//'frontend_phone',
				//'frontend_address',
				//'frontend_email',
				//'sys_config_google_map',
				//'sys_config_google_map2',
				//'footer_contact',
				//'footer',
				'has_seo',
				'report',
				'class_text',
				// 後台
				'admin_title',
				'service_admin_mail',
				//'service_send_mail',
				//'smtp_server',
				//'smtp_port',
				//'smtp_account',
				//'google_map',
				//'seo_keyword',
				//'seo_description',

				// 購物
				'payment_atm',
				'payment_atm_bank_code',
				'payment_atm_account',
				'payment_cash_on_delivery',
				'payment_ecpay_credit_card',
				'payment_ecpay_cvs',
				'payment_ecpay_barcode',
				'payment_ecpay_webatm',
				'payment_ecpay_vatm',
				'payment_paypal',
				// 其它
				//    'pic1',
				//    'pic2',
			);
			if(SEO_OPEN == false)
				unset($list['has_seo']);
			else{
				$acl = new Admin_acl();
				$acl->start();
				if(file_exists(Yii::getPathOfAlias('system.backend.controllers.SeoController').'.php') and $acl->hasAcl($this->data['admin_id'], 'seo', 'update')){
					// 有權限的話
				} else {
					// 沒權限
					unset($list['has_seo']);
				}
			}

			$load = array();
			$sys_configs = $this->data['sys_configs'];

			if(!empty($list)){
				foreach($list as $k => $v){
					if($v == 'has_seo'){
						$v .= '_'.$this->data['admin_switch_data_ml_key'];
					}
					// 這些開頭的，不會加上語系結尾(2/2)
					if(!preg_match('/^(service|smtp|has_seo)/', $v)){
						$v .= '_'.$this->data['admin_switch_data_ml_key'];
					}
					if(!isset($sys_configs[$v])){
						$sys_configs[$v] = '';
					}
					$load['sys_config_'.$v] = $sys_configs[$v];
				}
			}
			//var_dump($load);die;

			//unset($load['sys_config_smtp_password']);
			//var_dump($load);

			$this->data['updatecontent'] = $load;
			//var_dump($this->data['updatecontent']);
			//$this->data['main_content'] = 'default/update';
			$this->data['main_content'] = 'member/update';
			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
			$this->display('index.htm', $this->data);
		} else {
			$save = $_POST;
			//var_dump($save);die;
			//die;

			/*
array(9) {
  ["sys_config_service_admin_mail"]=>
  string(0) ""
  ["sys_config_smtp_server"]=>
  string(0) ""
  ["sys_config_smtp_port"]=>
  string(0) ""
  ["sys_config_smtp_account"]=>
  string(0) ""
  ["sys_config_smtp_password"]=>
  string(0) ""
  ["sys_config_google_analytics_tracking_code"]=>
  string(0) ""
  ["hidden_id"]=>
  string(0) ""
  ["update_base64_url"]=>
  string(0) ""
  ["prev_url"]=>
  string(0) ""
}

			 */

			 // checkbox 或是Radio請看這裡
			$acl = new Admin_acl();
			$acl->start();
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.SeoController').'.php') and $acl->hasAcl($this->data['admin_id'], 'seo', 'update')){
				if(!isset($save['sys_config_has_seo_'.$this->data['admin_switch_data_ml_key']])){
					$save['sys_config_has_seo_'.$this->data['admin_switch_data_ml_key']] = '0';
				}
			}
			//var_dump($this->data['sys_configs']);
			//die;

			// 看一下有沒有存在，有，而且數值不一樣，就update，沒有就insert
			if(!empty($save)){
				$db = Yii::app()->db;
				foreach($save as $k => $v){
					if(!preg_match('/^sys_config_(.*)$/', $k, $matches)){
						continue;
					}
					$k = $matches[1];

					if($k == 'smtp_password' and $v == ''){
						continue;
					}

					if(isset($this->data['sys_configs'][$k]) and $v != $this->data['sys_configs'][$k]){
						if(preg_match('/^pic/', $k)){
							// 要提供兩個欄位，是因為要比對的關系
							$update = $this->update_run_pic(array($k => $v), array($k => $this->data['sys_configs'][$k]));
							$v = $update[$k];
						}

						// update
						$sql="UPDATE sys_config SET keyval = :value WHERE keyname = :key";
						$command=$db->createCommand($sql);
						$command->bindParam(":key",$k,PDO::PARAM_STR);
						$command->bindParam(":value",$v,PDO::PARAM_STR);
						$command->execute();
					} elseif(!isset($this->data['sys_configs'][$k]) and $v != ''){
						if(preg_match('/^pic/', $k)){
							$savedata = $this->create_run_pic( array($k=>$v ));
							$v = $savedata[$k];
						}

						$sql="INSERT INTO sys_config (keyname, keyval) VALUES(:key,:value)";
						$command=$db->createCommand($sql);
						// PDO::PARAM_STR
						// PDO::PARAM_INT
						$command->bindParam(":key",$k,PDO::PARAM_STR);
						$command->bindParam(":value",$v,PDO::PARAM_STR);
						$command->execute();
					}
				}
			}
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method']));
		}
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

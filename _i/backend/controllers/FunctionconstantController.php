<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,

		'table' => 'XXX',
		'orm' => 'XXX_orm',
		'default_sort_field' => 'sort_id',
		'search_keyword_field' => array('name_en'),
		'search_keyword_assign_field' => 'name_en',
		'sys_log_name' => 'name_en',
		'data_multilanguage' => false,
		'data_multilanguage_update' => 'XXX',
		'listfield' => array(),
		'updatefield' => array(
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
					'label' => '一般',
					'section_title' => '一般',
					'field' => array(
						'sys_config_function_constant_lock_right_click' => array(
							'label' => '全站鎖右鍵',
							// 'type' => 'input',
						 	'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_lock_right_click',
								'name' => 'sys_config_function_constant_lock_right_click',
							),
							'other' => array(
						 		'values' => array(
						 			'false' => '關閉 (預設)',
						 			'true' => '開啟',
						 		),
						 		'default' => 'false',
								// 'html_end' => '是否開啟全站鎖右鍵功能',
							),
						),
						'sys_config_function_constant_google_translate' => array(
							'label' => 'Google 翻譯器',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_google_translate',
								'name' => 'sys_config_function_constant_google_translate',
							),
							'other' => array(
								'values' => array(
									'0' => '關閉 (預設)',
									'1' => '環境用',
									'2' => '客製用',
								),
								'default' => 'false',
								// 'html_end' => ' ( LayoutV2 ) 上方選單是否有Google翻譯器',
							),
						),
						'sys_config_function_constant_simple_translate' => array(
							'label' => '繁簡切換',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_simple_translate',
								'name' => 'sys_config_function_constant_simple_translate',
							),
							'other' => array(
								'values' => array(
									'false' => '關閉 (預設)',
									'true' => '開啟',
								),
								'default' => 'false',
								// 'html_end' => ' ( LayoutV2 ) 上方選單是否有繁簡切換',
							),
						),
						'sys_config_function_constant_seo_open' => array(
							'label' => '開啟SEO功能',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_seo_open',
								'name' => 'sys_config_function_constant_seo_open',
							),
							'other' => array(
								'values' => array(
									'false' => '關閉 (預設)',
									'true' => '開啟',
								),
								'default' => 'false',
								// 'html_end' => ' ( LayoutV2 ) 是否開啟SEO功能',
							),
						),
						'sys_config_function_constant_shop_open' => array(
							'label' => '開啟購物功能',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_open',
								'name' => 'sys_config_function_constant_shop_open',
							),
							'other' => array(
								'values' => array(
									'false' => '關閉 (預設)',
									'true' => '開啟',
								),
								'default' => 'false',
							),
						),
						'sys_config_function_constant_news_reserve' => array(
							'label' => '最新消息預約發布日期',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_news_reserve',
								'name' => 'sys_config_function_constant_news_reserve',
							),
							'other' => array(
								'values' => array(
									'false' => '關閉 (預設)',
									'true' => '開啟',
								),
								'default' => 'false',
							),
						),
						'sys_config_function_constant_donation' => array(
							'label' => '線上捐款',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_donation',
								'name' => 'sys_config_function_constant_donation',
							),
							'other' => array(
								'values' => array(
									'false' => '關閉 (預設)',
									'true' => '開啟',
								),
								'default' => 'false',
							),
						),
						'sys_config_function_constant_product_content' => array(
							'label' => '產品圖文',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_product_content',
								'name' => 'sys_config_function_constant_product_content',
							),
							'other' => array(
								'values' => array(
									'false' => '關閉 (預設)',
									'true' => '開啟',
								),
								'default' => 'false',
							),
						),
						'sys_config_function_constant_fb_board' => array(
							'label' => '臉書留言插件功能',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_fb_board',
								'name' => 'sys_config_function_constant_fb_board',
							),
							'other' => array(
								'values' => array(
									'false' => '關閉 (預設)',
									'true' => '開啟',
								),
								'default' => 'false',
								'html_end' => '目前在最新消息有放，網址有對外才有效',
							),
						),
						'sys_config_function_constant_backend_menu_merge' => array(
							'label' => '後台主選單分語系',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_backend_menu_merge',
								'name' => 'sys_config_function_constant_backend_menu_merge',
							),
							'other' => array(
								'values' => array(
									'true' => '不分語系 (預設)',
									'false' => '分語系',
								),
								'default' => 'true',
								// 'html_end' => ' 預設true (不分語系)',
							),
						),						
						'sys_config_function_constant_index_alest_ad' => array(
							'label' => '首頁彈跳廣告',
							// 'type' => 'input',
						 	'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_index_alest_ad',
								'name' => 'sys_config_function_constant_index_alest_ad',
							),
							'other' => array(
						 		'values' => array(
						 			'false' => '關閉 (預設)',
						 			'true' => '開啟',
						 		),
						 		'default' => 'false',
								// 'html_end' => ' ( LayoutV2 ) 是否有首頁彈跳廣告? 需至後台上傳圖片及選擇顯示才有作用',
							),
						),
						'sys_config_function_constant_cc_mail_open' => array(
							'label' => '首頁彈跳廣告',
							// 'type' => 'input',
						 	'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_cc_mail_open',
								'name' => 'sys_config_function_constant_cc_mail_open',
							),
							'other' => array(
						 		'values' => array(
						 			'false' => '關閉 (預設)',
						 			'true' => '開啟',
						 		),
						 		'default' => 'false',
								'html_end' => ' 寄信是否要CC給提問人',
							),
						),
						'sys_config_function_constant_image_ratio' => array(
							'label' => '全站預設圖片比例',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_image_ratio',
								'name' => 'sys_config_function_constant_image_ratio',
							),
							'other' => array(
								'html_end' => '這邊設定V4的全站預設圖片比例 <span style="color:red"><b>N e w !</b></span><br/>矩形(預設：橫式4:3) itemImg<br/>正方形 itemImg square <br/>矩形(直式3:4)  itemImg traight<br/>矩形(A4) itemImg a4<br/>',
							),
						),
						'sys_config_function_constant_small_menu_show_type' => array(
							'label' => '　',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_small_menu_show_type',
								'name' => 'sys_config_function_constant_small_menu_show_type',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) 縮小選單是否要有子選單 (固定)',
							),
						),
						'sys_config_function_constant_pc_menu_show_type' => array(
							'label' => '　',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_pc_menu_show_type',
								'name' => 'sys_config_function_constant_pc_menu_show_type',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) PC主選單是否要有下拉選單',
							),
						),
						'sys_config_function_constant_webmenuchild_detail_show_type' => array(
							'label' => '前台次選單(靜態)內頁其他內文顯示方式',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_webmenuchild_detail_show_type',
								'name' => 'sys_config_function_constant_webmenuchild_detail_show_type',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) 1.標準由上至下排版 2.使用頁籤顯示，由左至右',
							),
						),
						'sys_config_function_constant_webmenuchild_type_detail' => array(
							'label' => '有無前台次選單(靜態)分類描述',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_webmenuchild_type_detail',
								'name' => 'sys_config_function_constant_webmenuchild_type_detail',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 )',
							),
						),
						'sys_config_function_constant_show_black' => array(
							'label' => '黑幕遮屏',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_show_black',
								'name' => 'sys_config_function_constant_show_black',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) 這裡是對全站做黑幕遮屏，使用時機為需暫時關閉網站時開啟',
							),
						),
						'sys_config_function_constant_frontend_default_lang' => array(
							'label' => '預設語系',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_frontend_default_lang',
								'name' => 'sys_config_function_constant_frontend_default_lang',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) 設定預設語系，當作createURL指標參考值',
							),
						),
						'sys_config_function_constant_layout_small_menu' => array(
							'label' => '　',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_layout_small_menu',
								'name' => 'sys_config_function_constant_layout_small_menu',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) layout 內 中間大標題是否預設下拉選單',
							),
						),
						'sys_config_function_constant_first_site_banner' => array(
							'label' => '歡迎圖',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_first_site_banner',
								'name' => 'sys_config_function_constant_first_site_banner',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) 是否有網站進入歡迎圖 需至後台上傳圖片才有作用',
							),
						),
						'sys_config_function_constant_page_number' => array(
							'label' => '分頁功能樣式',
							// 'type' => 'input',
						 	'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_page_number',
								'name' => 'sys_config_function_constant_page_number',
							),
							'other' => array(
						 		'values' => array(
						 			'0' => '頁數不可選',
						 			'1' => '頁數可選',
						 		),
						 		'default' => '0',
								// 'html_end' => ' ( LayoutV2 ) 是否有首頁彈跳廣告? 需至後台上傳圖片及選擇顯示才有作用',
							),
						),
						// 'sys_config_function_constant_cc_mail_open' => array(
						// 	'label' => 'CC給提問人',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'sys_config_function_constant_cc_mail_open',
						// 		'name' => 'sys_config_function_constant_cc_mail_open',
						// 	),
						// 	'other' => array(
						// 		'html_end' => ' 寄信是否要CC給提問人',
						// 	),
						// ),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'label' => '購物產品功能',
					'section_title' => '購物產品功能',
					'field' => array(
						'sys_config_function_constant_shop_default_show_type' => array(
							'label' => '是否顯示全部產品',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_default_show_type',
								'name' => 'sys_config_function_constant_shop_default_show_type',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) 1 預設顯示全部產品 0 不顯示 (如果設1則優先執行該常數，設0則執行SHOP_SHOW_TYPE',
							),
						),
						'sys_config_function_constant_shop_show_type' => array(
							'label' => '產品是否有分類',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_show_type',
								'name' => 'sys_config_function_constant_shop_show_type',
							),
							'other' => array(
								'html_end' => ' ( LayoutV2 ) 0 不顯示產品，顯示分類 1 顯示該ID下的子分類產品,包含自己 2 只顯示該ID的產品',
							),
						),
						'sys_config_function_constant_shop_related_products' => array(
							'label' => '產品是否有相關產品',
							// 'type' => 'input',
						 	'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_related_products',
								'name' => 'sys_config_function_constant_shop_related_products',
							),
							'other' => array(
						 		'values' => array(
						 			'false' => '關閉 (預設)',
						 			'true' => '開啟',
						 		),
						 		'default' => 'false',
								// 'html_end' => '是否開啟產品相關產品',
							),
						),
						'sys_config_function_constant_shop_deduct_inventory' => array(
							'label' => '是否需要扣除庫存',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_deduct_inventory',
								'name' => 'sys_config_function_constant_shop_deduct_inventory',
							),
							'other' => array(
								'values' => array(
						 			'false' => '關閉 (預設)',
						 			'true' => '開啟',
						 		),
								'html_end' => ' 訂單完成後是否需要扣除該訂單物品的庫存',
							),
						),
						'sys_config_function_constant_shop_show_promotions' => array(
							'label' => '是否顯示促銷方案',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_show_promotions',
								'name' => 'sys_config_function_constant_shop_show_promotions',
							),
							'other' => array(
								'values' => array(
						 			'false' => '關閉 (預設)',
						 			'true' => '開啟',
						 		),
								'html_end' => ' 如要關閉促銷活動，要再關閉前將所有促銷方案的資料移除，並且要到頁面page功能關閉 v3/shop/block',
							),
						),
						'sys_config_function_constant_shop_show_coupon' => array(
							'label' => '是否顯示優惠券',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_show_coupon',
								'name' => 'sys_config_function_constant_shop_show_coupon',
							),
							'other' => array(
								'values' => array(
									'true' => '開啟 (預設)',
						 			'false' => '關閉',						 			
						 		),
								'html_end' => ' 優惠券在step1會出現',
							),
						),
						'sys_config_function_constant_shop_show_dividend' => array(
							'label' => '是否顯示紅利',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_show_dividend',
								'name' => 'sys_config_function_constant_shop_show_dividend',
							),
							'other' => array(
								'values' => array(
						 			'false' => '關閉 (預設)',
						 			'true' => '開啟',
						 		),
								'html_end' => ' 紅利在step1會出現',
							),
						),
						'sys_config_function_constant_shop_show_electronic_invoice' => array(
							'label' => '是否顯示電子發票',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_show_electronic_invoice',
								'name' => 'sys_config_function_constant_shop_show_electronic_invoice',
							),
							'other' => array(
								'values' => array(
									'true' => '開啟 (預設)',
						 			'false' => '關閉',						 			
						 		),
								'html_end' => ' 電子發票在step2會出現',
							),
						),
						'sys_config_function_constant_shop_category_show_open' => array(
							'label' => '購物分類主選單顯示',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_category_show_open',
								'name' => 'sys_config_function_constant_shop_category_show_open',
							),
							'other' => array(
								'values' => array(
						 			'false' => '關閉 (預設)',						 			
									'true' => '開啟',
						 		),
								'default' => 'false',
								'html_end' => '<span style="color:red"><b>N e w !</b></span>',
							),
						),
						'sys_config_function_constant_shop_show_purchase' => array(
							'label' => '是否顯示購物車加購商品',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_show_purchase',
								'name' => 'sys_config_function_constant_shop_show_purchase',
							),
							'other' => array(
								'values' => array(
						 			'false' => '關閉 (預設)',
						 			'true' => '開啟',
						 		),
								'html_end' => ' 加購商品在step1會出現',
							),
						),
						'sys_config_function_constant_shop_promo' => array(
							'label' => '是否顯示購物車滿額加購商品',
							// 'type' => 'input',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_promo',
								'name' => 'sys_config_function_constant_shop_promo',
							),
							'other' => array(
								'values' => array(
						 			'false' => '關閉 (預設)',						 			
									'true' => '開啟',
						 		),
								'default' => 'false',
								'html_end' => '滿額加購商品在step1會出現',
							),
						),
						'sys_config_function_constant_shop_promo_price' => array(
							'label' => '滿額加價購金額',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_shop_promo_price',
								'name' => 'sys_config_function_constant_shop_promo_price',
							),
							'other' => array(
								'html_end' => '上方選項需開啟、並輸入價格才有作用(純數字)',
							),
						),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'label' => '會員功能相關',
					'section_title' => '會員功能相關',
					'field' => array(
						'sys_config_function_constant_member_open' => array(
							'label' => '外部登入/註冊會員功能',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_function_constant_member_open',
								'name' => 'sys_config_function_constant_member_open',
							),
							'other' => array(
								'html_end' => ' 是否要有FB,G+,line的登入註冊會員功能',
							),
						),
						'sys_config_function_constant_customer_password_encrypt_type' => array(
							'label' => '會員密碼型態',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_customer_password_encrypt_type',
								'name' => 'sys_config_function_constant_customer_password_encrypt_type',
							),
							'other' => array(
								'values' => array(
									'0' => '明碼',
									'1' => 'SHA1',
									'2' => '加密方式1 (預設)',
								),
								'default' => '2',
								// 'html_end' => ' 預設true (不分語系)',
							),
						),
						'sys_config_function_constant_customer_login_type' => array(
							'label' => '會員系統登入使用類別',							
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_customer_login_type',
								'name' => 'sys_config_function_constant_customer_login_type',
							),
							'other' => array(
								'values' => array(
						 			'email' => 'E-mail (預設)',						 			
									'phone' => '手機',
									'account' => '自訂帳號',
						 		),
								'default' => 'email',
								'html_end' => '<span style="color:red"><b>N e w !</b></span>',
							),
						),
						'sys_config_function_constant_company_member' => array(
							'label' => '企業會員',
							// 'type' => 'input',
						 	'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_function_constant_company_member',
								'name' => 'sys_config_function_constant_company_member',
							),
							'other' => array(
						 		'values' => array(
						 			'false' => '不使用 (預設)',
						 			'true' => '使用',
						 		),
						 		'default' => 'false',
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

		$list_tmp = array();

		$section_id = -1;

		// 一般
		$section_id++;
		foreach($this->def['updatefield']['sections'][$section_id]['field'] as $k => $v){
			$list_tmp[str_replace('sys_config_','',$k)] = '1';
		}

		// 購物
		$section_id++;
		foreach($this->def['updatefield']['sections'][$section_id]['field'] as $k => $v){
			$list_tmp[str_replace('sys_config_','',$k)] = '1';
		}

		// 會員
		$section_id++;
		foreach($this->def['updatefield']['sections'][$section_id]['field'] as $k => $v){
			$list_tmp[str_replace('sys_config_','',$k)] = '1';
		}

		//      // 產品
		//      $section_id++;
		//      foreach($this->def['updatefield']['sections'][$section_id]['field'] as $k => $v){
		//      	$list_tmp[str_replace('sys_config_','',$k)] = '1';
		//      }

		//      // 購物產品
		//      $section_id++;
		//      foreach($this->def['updatefield']['sections'][$section_id]['field'] as $k => $v){
		//      	$list_tmp[str_replace('sys_config_','',$k)] = '1';
		//      }

		//      // 其它
		//      $section_id++;
		//      foreach($this->def['updatefield']['sections'][$section_id]['field'] as $k => $v){
		//      	$list_tmp[str_replace('sys_config_','',$k)] = '1';
		//      }

		$ggg = $this->data['sys_configs'];
		ksort($ggg);

		$section_id++;
		foreach($ggg as $k => $v){
			if(preg_match('/^function_constant_(.*)$/', $k, $matches) and !isset($list_tmp[$k])){
				$this->def['updatefield']['sections'][$section_id]['field']['sys_config_'.$k] = array(
					'label' => $matches[1],
					'type' => 'input',
					'attr' => array(
						'id' => 'sys_config_'.$k,
						'name' => 'sys_config_'.$k,
					),
					'other' => array(
						'html_end' => ' ( LayoutV3 ) ',
					),
				);
			}
		}

		//var_dump($this->def['updatefield']['sections'][3]['field']);die;

		return true;
	}

	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;

			// $list = array(
			// 	'google_analytics_tracking_code',
			// 	'seo_keyword',
			// 	'seo_description',
			// 	'has_seo',
			// );

			$list_tmp = array();

			$section_id = -1;

			// 一般
			$section_id++;
			foreach($this->data['def']['updatefield']['sections'][$section_id]['field'] as $k => $v){
				$list_tmp[str_replace('sys_config_','',$k)] = '1';
			}

			//      // 產品
			//      $section_id++;
			//      foreach($this->data['def']['updatefield']['sections'][$section_id]['field'] as $k => $v){
			//      	$list_tmp[str_replace('sys_config_','',$k)] = '1';
			//      }

			// 購物產品
			$section_id++;
			foreach($this->data['def']['updatefield']['sections'][$section_id]['field'] as $k => $v){
				$list_tmp[str_replace('sys_config_','',$k)] = '1';
			}

			// 會員
			$section_id++;
			foreach($this->data['def']['updatefield']['sections'][$section_id]['field'] as $k => $v){
				$list_tmp[str_replace('sys_config_','',$k)] = '1';
			}

			//      // 其它
			//      $section_id++;
			//      foreach($this->data['def']['updatefield']['sections'][$section_id]['field'] as $k => $v){
			//      	$list_tmp[str_replace('sys_config_','',$k)] = '1';
			//      }

			//      // 開環境所產生的
			//      $section_id++;
			//      if(isset($this->data['def']['updatefield']['sections'][$section_id]['field']) and count($this->data['def']['updatefield']['sections'][$section_id]['field']) > 0){
			//      	foreach($this->data['def']['updatefield']['sections'][$section_id]['field'] as $k => $v){
			//      		$list_tmp[str_replace('sys_config_','',$k)] = '1';
			//      	}
			//      }

			$list = array();
			foreach($list_tmp as $k => $v){
				$list[] = $k;
			}

			$load = array();
			$sys_configs = $this->data['sys_configs'];

			if(count($list) > 0){
				foreach($list as $k => $v){
					if(!isset($sys_configs[$v])){
						$sys_configs[$v] = '';
					}
					$load['sys_config_'.$v] = $sys_configs[$v];
				}
			}

			$this->data['updatecontent'] = $load;
			//$this->data['main_content'] = 'default/update';
			$this->data['main_content'] = 'member/update';
			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
			$this->display('index.htm', $this->data);
		} else {
			$save = $_POST;

			// 看一下有沒有存在，有，而且數值不一樣，就update，沒有就insert
			if(count($save) > 0){
				$db = Yii::app()->db;
				foreach($save as $k => $v){
					if(!preg_match('/^sys_config_(.*)$/', $k, $matches)){
						continue;
					}
					$k = $matches[1];

					if(isset($this->data['sys_configs'][$k]) and $v != $this->data['sys_configs'][$k]){
						// update
						$sql="UPDATE sys_config SET keyval = :value WHERE keyname = :key";
						$command=$db->createCommand($sql);
						$command->bindParam(":key",$k,PDO::PARAM_STR);
						$command->bindParam(":value",$v,PDO::PARAM_STR);
						$command->execute();
					} elseif(!isset($this->data['sys_configs'][$k]) and $v != ''){
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

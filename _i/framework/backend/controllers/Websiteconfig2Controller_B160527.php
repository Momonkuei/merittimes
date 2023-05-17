<?php

class Websiteconfig2Controller extends Controller
{
	protected $def = array(
		//'title' => 'ml:Product',
		'table' => 'product',
		'orm' => 'G_product_orm',
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('name_en'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name_en', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name_en', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'data_multilanguage_update' => 'model', // 在資料內頁中，切換多國語系，依照某一個欄位
		'sortable' => array(
			//'enable' => 'true',
			//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=product/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		'listfield_attr' => array(
			//'smarty_include_top' => 'product/main_content_top.htm',
		),
		'listfield' => array(
			'name_en' => array(
				'label' => '商品名稱',
				'width' => '30%',
				'sort' => true,
			),
			'class_name' => array(
				'label' => '商品分類',
				'width' => '20%',
			),
			//'article' => array(
			//	'label' => 'Article',
			//	//'label_comment' => '會將通知信寄給使用者',
			//	'width' => '7%',
			//	'url_id' => 'article',
			//),
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
					'section_title' => '前台設定',
					'field' => array(
						//'sys_config_seo_description' => array(
						//	'label' => 'SEO|網站簡介',
						//	'type' => 'textarea',
						//	'attr' => array(
						//		'id' => 'sys_config_seo_description',
						//		'name' => 'sys_config_seo_description',
						//		'title' => '建議在 125 個字元以內',
						//		//'value' => '',
						//		//'size' => '20',
						//	),
						//),
						//'sys_config_seo_keyword' => array(
						//	'label' => 'SEO|關鍵字',
						//	'type' => 'textarea',
						//	'attr' => array(
						//		'id' => 'sys_config_seo_keyword',
						//		'name' => 'sys_config_seo_keyword',
						//		'title' => '可設定多組關鍵字，請使用 , 鍵隔開',
						//		//'value' => '',
						//		//'size' => '20',
						//	),
						//),
						//'sys_config_link1' => array(
						//	'label' => '關係企業網址',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'sys_config_link1',
						//		'name' => 'sys_config_link1',
						//		//'value' => '',
						//		'size' => '30',
						//	),
						//),
						//'sys_config_link2' => array(
						//	'label' => '人才招募網址',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'sys_config_link2',
						//		'name' => 'sys_config_link2',
						//		//'value' => '',
						//		'size' => '30',
						//	),
						//),
						//'sys_config_link3' => array(
						//	'label' => '員工專區網址',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'sys_config_link3',
						//		'name' => 'sys_config_link3',
						//		//'value' => '',
						//		'size' => '30',
						//	),
						//),
						'sys_config_frontend_phone' => array(
							'label' => '公司電話',
							'type' => 'input',
							'attr_td1' => array('width' => '210'),
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
						'sys_config_google_analytics_tracking_code' => array(
							'label' => 'Google Log分析',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_google_analytics_tracking_code',
								'name' => 'sys_config_google_analytics_tracking_code',
								//'value' => '',
								'title' => '例如:UA-XXXXXXXX-X',
								'size' => '20',
							),
						),
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
						'sys_config_has_seo' => array(
							'label' => 'SEO',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'sys_config_has_seo',
								'type' => 'checkbox',
								'value' => '1',
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
					'section_title' => '後台設定',
					'field' => array(
						'sys_config_admin_title' => array(
							'label' => '後台網站名稱',
							'type' => 'input',
							'attr_td1' => array('width' => '210'),
							'attr' => array(
								'id' => 'sys_config_admin_title',
								'name' => 'sys_config_admin_title',
								//'value' => '',
								'size' => '20',
							),
						),
						'sys_config_service_admin_mail' => array(
							'label' => '網站管理者Mail',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_service_admin_mail',
								'name' => 'sys_config_service_admin_mail',
								//'value' => '',
								'size' => '20',
							),
						),
						'sys_config_service_send_mail' => array(
							'label' => '寄件人',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_service_send_mail',
								'name' => 'sys_config_service_send_mail',
								//'value' => '',
								'size' => '20',
							),
						),
						'sys_config_smtp_server' => array(
							'label' => 'SMTP主機設定',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_smtp_server',
								'name' => 'sys_config_smtp_server',
								//'value' => '',
								'size' => '20',
							),
						),
						'sys_config_smtp_port' => array(
							'label' => 'SMTP通訊埠號',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_smtp_port',
								'name' => 'sys_config_smtp_port',
								//'value' => '',
								'size' => '20',
								'title' => '',
							),
						),
						'sys_config_smtp_account' => array(
							'label' => 'SMTP連線帳號',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_smtp_account',
								'name' => 'sys_config_smtp_account',
								//'value' => '',
								'size' => '20',
							),
						),
						'sys_config_smtp_password' => array(
							'label' => 'SMTP連線密碼',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_smtp_password',
								'name' => 'sys_config_smtp_password',
								'value' => '',
								'size' => '20',
							),
						),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'label' => '購物設定',
					'section_title' => '購物設定',
					'field' => array(
						'sys_config_shop_default_shipment' => array(
							'label' => '基本運費',
							'type' => 'input',
							'attr_td1' => array('width' => '180'),
							'attr' => array(
								'id' => 'sys_config_shop_default_shipment',
								'name' => 'sys_config_shop_default_shipment',
								//'value' => '',
								'size' => '6',
							),
							'other' => array(
								'html_end' => '元，預設值是200元'
							),
						),
						'sys_config_shop_free_shipment' => array(
							'label' => '滿多少免運費',
							'type' => 'input',
							'attr_td1' => array('width' => '180'),
							'attr' => array(
								'id' => 'sys_config_shop_free_shipment',
								'name' => 'sys_config_shop_free_shipment',
								//'value' => '',
								'size' => '6',
							),
							'other' => array(
								'html_end' => '元，預設值是2000元'
							),
						),
						'sys_config_shop_bonus_with_money' => array(
							'label' => '每１點紅利折多少錢',
							'type' => 'input',
							'attr_td1' => array('width' => '180'),
							'attr' => array(
								'id' => 'sys_config_shop_bonus_with_money',
								'name' => 'sys_config_shop_bonus_with_money',
								//'value' => '',
								'size' => '6',
							),
							'other' => array(
								'html_end' => '元'
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

		foreach($this->def['updatefield']['sections'][0]['field'] as $k => $v){
			if(isset($v['attr']['id'])){
				$v['attr']['id'] .= '_'.$this->data['admin_switch_data_ml_key'];
			}
			if(isset($v['attr']['name'])){
				$v['attr']['name'] .= '_'.$this->data['admin_switch_data_ml_key'];
			}
			$this->def['updatefield']['sections'][0]['field'][$k.'_'.$this->data['admin_switch_data_ml_key']] = $v;
			unset($this->def['updatefield']['sections'][0]['field'][$k]);
		}

		$acl = new Admin_acl();
		$acl->start();
		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.SeoController').'.php') and $acl->hasAcl($this->data['admin_id'], 'seo', 'update')){
			// 有權限的話
		} else {
			// 沒權限
			unset($this->def['updatefield']['sections'][0]['field']['sys_config_has_seo']);
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
				'frontend_phone',
				'frontend_address',
				'frontend_email',
				'sys_config_google_map',
				'sys_config_google_map2',
				'footer_contact',
				'footer',
				'has_seo',

				// 後台
				'admin_title',
				'service_admin_mail',
				'service_send_mail',
				'smtp_server',
				'smtp_port',
				'smtp_account',
				//'google_map',
				//'seo_keyword',
				//'seo_description',
			);

			$acl = new Admin_acl();
			$acl->start();
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.SeoController').'.php') and $acl->hasAcl($this->data['admin_id'], 'seo', 'update')){
				// 有權限的話
			} else {
				// 沒權限
				unset($list['has_seo']);
			}

			$load = array();
			$sys_configs = $this->data['sys_configs'];

			if(count($list) > 0){
				foreach($list as $k => $v){
					if(!preg_match('/^(admin|service|smtp)/', $v)){
						$v .= '_'.$this->data['admin_switch_data_ml_key'];
					}
					if(!isset($sys_configs[$v])){
						$sys_configs[$v] = '';
					}
					$load['sys_config_'.$v] = $sys_configs[$v];
				}
			}

			//unset($load['sys_config_smtp_password']);

			$this->data['updatecontent'] = $load;
			//var_dump($this->data['updatecontent']);
			//$this->data['main_content'] = 'default/update';
			$this->data['main_content'] = 'member/update';
			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
			$this->display('index.htm', $this->data);
		} else {
			$save = $_POST;
			//var_dump($save);
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

			// 看一下有沒有存在，有，而且數值不一樣，就update，沒有就insert
			if(count($save) > 0){
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

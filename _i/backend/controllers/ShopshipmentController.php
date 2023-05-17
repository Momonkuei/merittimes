<?php

/*
 * 單頁文章(多國語系)
 */

/*
使用方式
//$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/').'Funcfieldv2update1Controller.php');
$contentx = file_get_contents(Yii::getPathOfAlias('system').ds('/').target_app_name.ds('/controllers/').'shoparticle1Controller.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
$contentx = str_replace('shoparticle1', 'Articlexxxsingle', $contentx); // class extents
$contentx = str_replace('shoparticle1', 'company', $contentx); // 欄位
eval($contentx);
class CompanyController extends ArticlexxxsingleController
{
}
 */

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

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
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'label' => '一般設定',
					'section_title' => '一般設定',
					'field' => array(
						'sys_config_shipment_normal' => array(
							'label' => '基本運費：',
							'type' => 'input',
							'attr_td1' => array('width' => '100'),
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_shipment_normal',
								'name' => 'sys_config_shipment_normal',								
								'size' => '20',
							),
							'other' => array(
								'html_end' => ' /元',
								),
						),						
						'sys_config_shipment_price1' => array(
							'label' => '一級運費：滿',
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_shipment_price1',
								'name' => 'sys_config_shipment_price1',
								'size' => '20',
							),
							'other' => array(
								'html_end' => ' /元，',
								),
						),
						'sys_config_shipment_price2' => array(
							'label' => '運費',
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_shipment_price2',
								'name' => 'sys_config_shipment_price2',
								'size' => '20',
							),
							'other' => array(
								'html_end' => ' /元 (一級運費的部份，有用到才寫，沒用到的話，這兩個欄位就保持空白)',
								),
						),
						'sys_config_shipment_free' => array(
							'label' => '二級運費：滿',
							'type' => 'input',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_shipment_free',
								'name' => 'sys_config_shipment_free',
								'size' => '20',
							),
							'other' => array(
								'html_end' => ' /元，免運費 (必填，空白的話就是全部免運)',
								),
						),
						// 2020-06-10 有需要在打開 #36082
						// 'sys_config_shipment_low_temperature' => array(
						// 	'label' => '低溫運費',
						// 	'type' => 'input',
						// 	'merge' => '1',
						// 	'attr' => array(
						// 		//'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_shipment_low_temperature',
						// 		'name' => 'sys_config_shipment_low_temperature',
						// 		'size' => '20',
						// 	),
						// 	'other' => array(
						// 		'html_end' => ' /元 ,',
						// 		),
						// ),
						// 'sys_config_shipment_low_temperature_free' => array(
						// 	'label' => ' 滿 ',
						// 	'type' => 'input',
						// 	'merge' => '3',
						// 	'attr' => array(
						// 		//'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_shipment_low_temperature_free',
						// 		'name' => 'sys_config_shipment_low_temperature_free',
						// 		'size' => '20',
						// 	),
						// 	'other' => array(
						// 		'html_end' => ' /元 免運費',
						// 		),
						// ),
						// 'sys_config_shipment_has_islands' => array(
						// 	'label' => '是否需要離島運費',
						// 	'type' => 'checkbox',
						// 	'merge' => '1',
						// 	'attr' => array(
						// 		'name' => 'sys_config_shipment_has_islands',
						// 		'type' => 'checkbox',
						// 		'value' => '1',
						// 	),
						// ),
						// 'sys_config_shipment_islands' => array(
						// 	'label' => '離島運費',
						// 	'type' => 'input',
						// 	'merge' => '3',
						// 	'attr' => array(
						// 		//'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_shipment_islands',
						// 		'name' => 'sys_config_shipment_islands',
						// 		'size' => '20',
						// 	),
						// ),
						//'sys_config_' => array(
						//	'label' => '&nbsp;',
						//	'type' => 'ckeditor_js',
						//	'attr' => array(
						//		'id' => 'sys_config_',
						//		'name' => 'sys_config_',
						//	),
						//),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'label' => '物流設定',
					'section_title' => '物流設定',
					'field' => array(
						'sys_config_shipment_home_delivery' => array(
							'label' => '一般宅配配送<br /><br />付款方式<br />說明文字',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_shipment_home_delivery',
								'name' => 'sys_config_shipment_home_delivery',
								//'title' => '建議在 125 個字元以內',
								'value' => '',
								'rows' => '6',
								'cols' => '80',
							),
						),
						// 'sys_config_shipment_ecpay_711_no_payment_for_pickup_normal' => array(
						// 	'label' => '統一超商取貨的運費',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'sys_config_shipment_ecpay_711_no_payment_for_pickup_normal',
						// 		'name' => 'sys_config_shipment_ecpay_711_no_payment_for_pickup_normal',
						// 	),
						// ),
						// 'sys_config_shipment_ecpay_711_no_payment_for_pickup' => array(
						// 	'label' => '統一超商取貨<br /><br />付款方式<br />說明文字',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_shipment_ecpay_711_no_payment_for_pickup',
						// 		'name' => 'sys_config_shipment_ecpay_711_no_payment_for_pickup',
						// 		//'title' => '建議在 125 個字元以內',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),
						// 'sys_config_shipment_ecpay_fami_no_payment_for_pickup_normal' => array(
						// 	'label' => '全家超商取貨的運費',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'sys_config_shipment_ecpay_fami_no_payment_for_pickup_normal',
						// 		'name' => 'sys_config_shipment_ecpay_fami_no_payment_for_pickup_normal',
						// 	),
						// ),
						// 'sys_config_shipment_ecpay_fami_no_payment_for_pickup' => array(
						// 	'label' => '全家超商取貨<br /><br />付款方式<br />說明文字',
						// 	'type' => 'textarea',
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'sys_config_shipment_ecpay_fami_no_payment_for_pickup',
						// 		'name' => 'sys_config_shipment_ecpay_fami_no_payment_for_pickup',
						// 		//'title' => '建議在 125 個字元以內',
						// 		'value' => '',
						// 		'rows' => '6',
						// 		'cols' => '80',
						// 	),
						// ),
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// foreach($this->def['updatefield']['sections'][0]['field'] as $k => $v){
		// 	if(isset($v['attr']['id'])){
		// 		$v['attr']['id'] .= '_'.$this->data['admin_switch_data_ml_key'];
		// 	}
		// 	if(isset($v['attr']['name'])){
		// 		$v['attr']['name'] .= '_'.$this->data['admin_switch_data_ml_key'];
		// 	}
		// 	$this->def['updatefield']['sections'][0]['field'][$k.'_'.$this->data['admin_switch_data_ml_key']] = $v;
		// 	unset($this->def['updatefield']['sections'][0]['field'][$k]);
		// }

		// 這個是新的區塊，雖然只有一個欄位
		for($x=0;$x<=9;$x++){
			if(isset($this->def['updatefield']['sections'][$x])){
				foreach($this->def['updatefield']['sections'][$x]['field'] as $k => $v){			
					if(preg_match('/^pic/', $k)) continue;

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

		return true;
	}

	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;

			$list = array(
				// 一般
				'shipment_normal_'.$this->data['admin_switch_data_ml_key'],
				'shipment_free_'.$this->data['admin_switch_data_ml_key'],
				'shipment_price1_'.$this->data['admin_switch_data_ml_key'],
				'shipment_price2_'.$this->data['admin_switch_data_ml_key'],
				'shipment_low_temperature_'.$this->data['admin_switch_data_ml_key'],
				'shipment_low_temperature_free_'.$this->data['admin_switch_data_ml_key'],
				'shipment_has_islands_'.$this->data['admin_switch_data_ml_key'],
				'shipment_islands_'.$this->data['admin_switch_data_ml_key'],

				// 物流
				'shipment_home_delivery_'.$this->data['admin_switch_data_ml_key'],
				'shipment_ecpay_711_no_payment_for_pickup_normal_'.$this->data['admin_switch_data_ml_key'],
				'shipment_ecpay_711_no_payment_for_pickup_'.$this->data['admin_switch_data_ml_key'],
				'shipment_ecpay_fami_no_payment_for_pickup_normal_'.$this->data['admin_switch_data_ml_key'],
				'shipment_ecpay_fami_no_payment_for_pickup_'.$this->data['admin_switch_data_ml_key'],
			);

			$load = array();
			$sys_configs = $this->data['sys_configs'];

			if(!empty($list)){
				foreach($list as $k => $v){
					if(!isset($sys_configs[$v])){
						$sys_configs[$v] = '';
					}
					$load['sys_config_'.$v] = $sys_configs[$v];
				}
			}

			$this->data['updatecontent'] = $load;
			//var_dump($this->data['updatecontent']);
			//$this->data['main_content'] = 'default/update';
			$this->data['main_content'] = 'member/update';
			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
			$this->display('index.htm', $this->data);
		} else {
			$save = $_POST;

			// checkbox 或是Radio請看這裡			
			if(!isset($save['sys_config_shipment_has_islands_'.$this->data['admin_switch_data_ml_key']])){
				$save['sys_config_shipment_has_islands_'.$this->data['admin_switch_data_ml_key']] = '0';
			}
			

			// 看一下有沒有存在，有，而且數值不一樣，就update，沒有就insert
			if(!empty($save)){
				$db = Yii::app()->db;
				foreach($save as $k => $v){
					if(!preg_match('/^sys_config_(.*)$/', $k, $matches)){
						continue;
					}
					$k = $matches[1];

					//if($k == 'smtp_password' and $v == ''){
					//	continue;
					//}

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

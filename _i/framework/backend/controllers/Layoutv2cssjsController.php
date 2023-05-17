<?php

class Layoutv2cssjsController extends Controller
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
					'type' => '2',
					'field' => array(
						'sys_config_layoutv2_css' => array(
							'label' => '載入CSS',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_layoutv2_css',
								'name' => 'sys_config_layoutv2_css',
								//'value' => '',
								//'size' => '20',
								'rows' => '4',
								'cols' => '40',
							),
						),
						'sys_config_layoutv2_js' => array(
							'label' => '載入Javascript',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'sys_config_layoutv2_js',
								'name' => 'sys_config_layoutv2_js',
								//'value' => '',
								//'size' => '20',
								'rows' => '4',
								'cols' => '40',
							),
						),
					),
				),
			),
		), // updatefield
	);

	//protected function beforeAction($action)
	//{
	//	parent::beforeAction($action);

	//	$tmp = $this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle'];
	//	$tmp['attr']['id'] .= '_'.$this->data['admin_switch_data_ml_key'];
	//	$tmp['attr']['name'] .= '_'.$this->data['admin_switch_data_ml_key'];
	//	$this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle_'.$this->data['admin_switch_data_ml_key']] = $tmp;

	//	unset($this->def['updatefield']['sections'][0]['field']['sys_config_articlesingle']);

	//	return true;
	//}

	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;

			$list = array(
				//'articlesingle_'.$this->data['admin_switch_data_ml_key'],
				'layoutv2_css',
				'layoutv2_js',
			);

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
			//var_dump($this->data['updatecontent']);
			$this->data['main_content'] = 'default/update';
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

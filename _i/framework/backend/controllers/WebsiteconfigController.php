<?php

class WebsiteconfigController extends Controller
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
					'section_title' => '系統設定',
					'field' => array(
						'sys_config_template_rulev1_group' => array(
							'label' => '版型',
							'type' => 'select3',
							'attr' => array(
								'id' => 'sys_config_template_rulev1_group',
								'name' => 'sys_config_template_rulev1_group',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
									//'theme_rwd03' => 'RWD03',
									//'theme_rwd05' => 'RWD05',
									//'theme_rwd15' => 'RWD15',
									//'theme_rwd152' => 'RWD152',
									//'ci_active_record' => 'ci_active_record',
								),
								'default' => '0',
								//'html_start' => '年度',
								'html_end' => '　',
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

		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>'templatetype'))->order('sort_id asc')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->def['updatefield']['sections'][0]['field']['sys_config_template_rulev1_group']['other']['values'][$v['other2']] = $v['topic'].' ('.$v['other1'].')';
			}
		}

		return true;
	}

	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;

			$list = array(
				'template_rulev1_group',
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

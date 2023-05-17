<?php

class SideadController extends Controller
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
					'field' => array(
						'sys_config_sidead_title' => array(
							//'label' => '標題',
							'mlabel' => array(
								null, // category
								'Title', // label
								array(), // sprintf
								'廣告標題', // default
							),
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_sidead_title',
								'name' => 'sys_config_sidead_title',
								'size' => '40',
							),
						),
						'sys_config_sidead_text' => array(
							'label' => '廣告連結',
							'type' => 'input',
							'attr' => array(
								'id' => 'sys_config_sidead_text',
								'name' => 'sys_config_sidead_text',
								'size' => '40',
							),
						),
						'pic3' => array(
							'label' => '廣告圖片上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '1024',
								'height' => '800',
								'comment_size' => '124x800',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'sys_config_sidead_enable' => array(
							//'label' => 'ml:Status',
							'mlabel' => array(
								null, // category
								'Status', // label
								array(), // sprintf
								'狀態', // default
							),
							'type' => 'status',
							'attr' => array(
								'id' => 'sys_config_sidead_enable',
								'name' => 'sys_config_sidead_enable',
							),
							'other' => array(
								'default'=>'1',
							),
						),
						//'sys_config_homeother_google_map' => array(
						//	'label' => '影片',
						//	'type' => 'textarea',
						//	'attr' => array(
						//		'class' => 'form-control', // 這…手動加上去好了
						//		'id' => 'sys_config_homeother_google_map',
						//		'name' => 'sys_config_homeother_google_map',
						//		//'value' => '',
						//		//'size' => '20',
						//		'rows' => '4',
						//		'cols' => '40',
						//	),
						//),
						//'sys_config_homeother_pic1' => array(
						//	'label' => '次頁大圖',
						//	'type' => 'kcfinder_input_school',
						//	'attr' => array(
						//		'id' => 'sys_config_homeother_pic1',
						//		'name' => 'sys_config_homeother_pic1',
						//		'size' => '40',
						//		//'title' => '',
						//	),
						//	'other' => array(
						//		'uploadurl_id' => 'assetsdir',
						//		'type' => 'member',
						//		'width' => '400',
						//		'school_id' => '',
						//		//'height' => '398',
						//		//'dir' => 'files/public',
						//	),
						//),
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
		

		return true;
	}

	public function actionIndex($param='')
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;

			$list = array(
				'sidead_title',
				'sidead_text',
				'sidead_enable',
				'pic3',
				//'homeother_google_map',
				//'homeother_pic1',
			);

			$load = array();
			$sys_configs = $this->data['sys_configs'];

			if(count($list) > 0){
				foreach($list as $k => $v){
					$v .= '_'.$this->data['admin_switch_data_ml_key'];
					if(!isset($sys_configs[$v])){
						$sys_configs[$v] = '';
					}
					$load['sys_config_'.$v] = $sys_configs[$v];
				}
			}

			//$this->data['def']['updatefield']['sections'][0]['field']['sys_config_homeother_pic1']['other']['school_id'] = 'other_page_banner';

			//unset($load['sys_config_smtp_password']);

			$this->data['updatecontent'] = $load;

			//處理單張圖片
			 $k = 'pic3_'.$this->data['admin_switch_data_ml_key'];
             if(isset($sys_configs[$k])){
				$this->data['updatecontent']['pic3_'.$this->data['admin_switch_data_ml_key']] = $sys_configs[$k];
				//echo $this->data['updatecontent']['pic1'];die;
             }


			//var_dump($this->data['updatecontent']);
			$this->data['main_content'] = 'default/update';
			//$this->data['main_content'] = 'member/update';
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

			 //處理單張圖片
			$k1 = 'pic3_'.$this->data['admin_switch_data_ml_key'];
			$k2 = 'pic3';
			$v1 = $save[$k1];
			if(isset($this->data['sys_configs'][$k1]) and $v1 != $this->data['sys_configs'][$k1] ){
				$update = $this->update_run_pic(array($k2=>$save[$k1]), array($k2=>$this->data['sys_configs'][$k1]));
				if(isset($update[$k2]))
					$save['sys_config_'.$k1] = $update[$k2];
			} else {
				$savedata = $this->create_run_pic(array($k2=>$save[$k1]));
				$save['sys_config_'.$k1] = $savedata[$k2];
			}

			// 看一下有沒有存在，有，而且數值不一樣，就update，沒有就insert
			if(count($save) > 0){
				$db = Yii::app()->db;
				foreach($save as $k => $v){


				/*
				//處理單張圖片 2016/6/6 不知道為什麼不能run ，先註記
				 $k1 = 'sys_config_pic1_'.$this->data['admin_switch_data_ml_key'];
                 $v1 = $save['pic1_'.$this->data['admin_switch_data_ml_key']];
                 if(isset($this->data['sys_configs'][$k1]) and $v1 != $this->data['sys_configs'][$k1] ){
					$update = $this->update_run_pic(array('pic1'=>$save['pic1_'.$this->data['admin_switch_data_ml_key']]), array('pic1'=>$this->data['sys_configs'][$k1]));
					$save[$k1] = $update['pic1_'.$this->data['admin_switch_data_ml_key']];
                 } else {
                    $savedata = $this->create_run_pic(array('pic1'=>$save['pic1_'.$this->data['admin_switch_data_ml_key']]));
                     $save[$k1] = $savedata['pic1'];
                 }
				 */



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

<?php

/*
 * 單層分類(通用資料表)
 */

// 懶得改Controller的名稱之一
//$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
//$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,
		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('topic'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'topic', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'topic', // 要給sys_log記錄名稱欄位值的設定
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
			'topic' => array(
				'label' => '分類名稱',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '15%',
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
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面
				'width' => '',
			),
			
			'is_enable' => array(
				//'label' => 'ml:Status',
				'label' => '狀態',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Status', // label
				//	array(), // sprintf
				//	'狀態', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
			),
			'sort_id' => array(
				//'label' => 'ml:Sort id',
				'label' => '排序',
				'translate_source' => 'tw',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			//'smarty_javascript' => 'product/update_javascript.htm',
			'smarty_javascript' => '',
			'smarty_javascript_text' => '',
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
						'topic' => array(
							'label' => '分類名稱',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'_contentbuilder' => array(
							'label' => '',
							'type' => 'inputn',
							'other' => array(
								'html'=>'<div class="control-box"><button type="button" id="htmlbtn" onclick="openif(\'detail\')">+ 加入範本</button><input type="hidden" id="ctidx" value=""><div id="ctarea" style="display: none;" ></div>',	
							),
						),
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'label' => '排序',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Sort', // label
							//	array(), // sprintf
							//	'排序', // default
							//),
							'type' => 'sort',
							'attr' => array(
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'label' => '狀態',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Status', // label
							//	array(), // sprintf
							//	'狀態', // default
							//),
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
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'detail' => array(
				//			'label' => '描述',
				//			'type' => 'ckeditor_js',
				//			'attr' => array(
				//				'id' => 'detail',
				//				'name' => 'detail',
				//			),
				//		),
				//	),
				//),
				// funcfieldv3的產出欄位，放在任何位置都可以
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_result' => true, // 要記得這個要加
					'field' => array(
					),
				),
				// 這是SEO欄位的範本，如果你需要，就打開它 1/4
				// *第二版的放在任何位置都可以，只要記得加上一個元素_has_seov2 => true就可以了
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_seov2' => true,
					'field' => array(
					),
				),
				// funcfieldv3的自定欄位，放在任何位置都可以
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_custom' => true, // 要記得這個要加
					'field' => array(
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);
		
		// 只有 設計/資訊 ，看得到拖拉範本
		if(!preg_match('/^(999994|999995)/', $this->data['admin_type'])){
			unset($this->def['updatefield']['sections'][0]['field']['_contentbuilder']);
		}else{
			//拖拉樣版的基本框架
			if(isset($this->data['BODY_END'])){
				$this->data['BODY_END'] .= '<iframe name="cbiframe" id="cbiframe" style="width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; border: 0px;display: none;"  src="" ></iframe><script type="text/javascript" src="/_i/assets/contenvuilder.js"></script>';
			}else{
				$this->data['BODY_END'] = '<iframe name="cbiframe" id="cbiframe" style="width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; border: 0px;display: none;"  src="" ></iframe><script type="text/javascript" src="/_i/assets/contenvuilder.js"></script>';
			}
		}

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = 'type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		$condition = $this->def['condition'][0][1]; 

		// 2020-08-19
		// 供新增的時候使用，新增的資料要在第一筆
		$this->data['origin_condition'] = array();
		if(trim($condition) != ''){
			$this->data['origin_condition'][0] = array(
				'where',
				$condition,
			);
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 這是SEO的欄位的範本，如果你需要，就打開它 2/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php') && $_constant ){
			$seo_func = 'a';
			include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
		}

		return true;
	}

	protected function index_last()
	{
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				//Ming 2018-12-18 來信 指示 列表的標題文字，點擊後可另開視窗顯示前台畫面  ( 所有單元都是 ) 
				//$_href = '/'.str_replace('type','',$this->data['router_class']).'_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$v['id'];	
				//$v['topic'] = '<a href="'.$_href.'" target="_BREAK">'.$v['topic'].'</a>';

				$this->data['listcontent'][$k] = $v;
			}
		}
		$this->data['main_content'] = 'default/index';
	}

	protected function create_show_last($param='')
	{
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_show_last($updatecontent)
	{
		parent::update_show_last($updatecontent);

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 這是SEO的範本，如果你需要，就打開它 3/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';'); 
		if($_constant){
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php')){
				$seo_func = 'b';
				include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
			}
			
			$row = $this->db->createCommand()->from('seo')->where('seo_item_id=:id and seo_ml_key=:ml_key and seo_type=:type',array(':id'=>$this->data['updatecontent']['id'],'ml_key'=>$this->data['admin_switch_data_ml_key'],':type'=>$this->data['router_class']))->queryRow();
			if($row){
				$this->data['updatecontent'] = $this->data['updatecontent'] + $row;
			}
		}		

		$this->data['main_content'] = 'default/update';
	}

	protected function update_run_last($param='')
	{
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_run_other_element($array)
	{
		// 這是SEO的範本，如果你需要，就打開它 4/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';'); 
		if($_constant){
			$array['seo_type'] = $this->data['router_class'];
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php')){
				$seo_func = 'c';
				include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
			}
		}

		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		//Ming 2018-12-18 來信 指示 資料更新後，點擊送出後需返回列表頁 ( 所有單元都是 ),設定非資訊部人員才會動作 by lota
		if(!preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
			$array['update_base64_url'] = '';
		}

		$array['ml_key'] = $this->data['ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['ml_key'];
		$array['type'] = $this->data['router_class'];

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
	}

	protected function create_run_last() 
	{
		// 為了要支援sort_id改欄位名稱
		$sort_field = 'sort_id';
		if(isset($this->data['def']['func_field']['sort_id']) and $this->data['def']['func_field']['sort_id'] != ''){
			$sort_field = $this->data['def']['func_field']['sort_id'];
		}

		/*
		 * 2019-02-14
		 * 每筆新資料新增時，請排列到第一筆(原會最後一筆)(這裡是舊的)
		 * http://redmine.buyersline.com.tw:4000/issues/31012
		 */
		
		// $this->cidb->where('id', $this->data['_last_insert_id']);
		// $this->cidb->update($this->data['def']['table'], array($sort_field => 0));

		// // 重新排序
		// // 目前Fieldsorter不支援where以外的方法
		// if(isset($this->data['def']['listfield'][$sort_field])){
		// 	$fieldsorter = new Fieldsorter;
		// 	$fieldsorter->setTableName($this->data['def']['table']);
		// 	$fieldsorter->setIdName($this->data['def']['func_field']['id']);
		// 	if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
		// 		$fieldsorter->setCondition($this->data['def']['condition']);
		// 	}
		// 	//$fieldsorter->refresh();
		// 	$fieldsorter->refresh('', array(),'', $sort_field);
		// }

		/*
		 * 2020-08-19
		 * 試著寫寫看，新增的時候，會是第一筆
		 */
		if(isset($this->data['origin_condition'])){
			if(isset($this->data['datasave']['class_id']) and $this->data['datasave']['class_id'] > 0){ // 有單選的情況，先改零，在重排
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));
				
				// 單分類排序
				//$conditions[] = $k.'='.$v;

				$this->data['origin_condition'][0][1] .= ' AND class_id='.$this->data['datasave']['class_id'].' ';

				// 重新排序
				// 目前Fieldsorter不支援where以外的方法
				if(isset($this->data['def']['listfield'][$sort_field])){
					$fieldsorter = new Fieldsorter;
					$fieldsorter->setTableName($this->data['def']['table']);
					$fieldsorter->setIdName($this->data['def']['func_field']['id']);
					$fieldsorter->setCondition($this->data['origin_condition']);
					$fieldsorter->refresh('', array(),'', $sort_field);
				}
			} elseif (isset($this->data['datasave']['class_ids']) and $this->data['datasave']['class_ids'] !='') { //複選類別 預設使用 class_ids
				//將勾選的分類解析出來
				$_class_ids = array_filter(explode(',',$this->data['datasave']['class_ids']));
				if(count($_class_ids) > 0){
					//將勾選的分類分別的寫入專屬資料表
					foreach ($_class_ids as $key => $value) {
						$_data = array(
							'product_id' => $this->data['_last_insert_id'],
							'class_id' => $value,
							$sort_field => 0,
						);
						$this->cidb->insert($this->data['def']['table'].'multisort', $_data);					

						$this->data['origin_condition'][0][1] = ' class_id='.$value.' ';

						$fieldsorter = new Fieldsorter;
						$fieldsorter->setTableName($this->data['def']['table'].'multisort');
						$fieldsorter->setIdName($this->data['def']['func_field']['id']);
						$fieldsorter->setCondition($this->data['origin_condition']);
						$fieldsorter->refresh('', array(),'', $sort_field);	
					}	

					//如果已經按下search，那就先處理一下 , 從 actionSearch 拷貝過來的
					$ss = $this->data['router_class'].'_search';
					$session = Yii::app()->session[$ss];
					if($session === null){
						$session = array();
					}
					if(isset($session) and !empty($session)){
						$conditions = array();
						$conditions_sortable = array();
						foreach($session as $k => $v){
							if($v == '') unset($session[$k]);
							if($k == 'class_id' and $v == -1) unset($session[$k]);
							if($k == 'class_id' and $v == 0) unset($session[$k]);
							if($k == 'icon' and $v == '') unset($session[$k]);
						}
					}
					if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
						// 把該分類的sort_id洗掉，然後載入多分類排序資料表的資料，然後更新它
						$class_id = $session['class_id'];
						$rows = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id='.$class_id)->order('sort_id')->queryAll();
						if($rows){
							foreach($rows as $k => $v){
								$data = array(
									'sort_id' => $v['sort_id'],
								);
								//$this->cidb->where('id',$v['product_id'])->update($this->data['router_class'], $data);
								$this->cidb->query('update '.$this->data['router_class'].' set sort_id='.$v['sort_id'].' where id='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');
							}
						}
					}

				}
			} elseif(!isset($this->data['datasave']['class_id']) and !isset($this->data['datasave']['class_id'])){ // 分項的情況
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));

				$fieldsorter = new Fieldsorter;
				$fieldsorter->setTableName($this->data['def']['table']);
				$fieldsorter->setIdName($this->data['def']['func_field']['id']);
				$fieldsorter->setCondition($this->data['origin_condition']);
				$fieldsorter->refresh('', array(),'', $sort_field);
			}
		}

	}

}

// 懶得改Controller的名稱之三
//eval('class '.$filename.' extends NonameController {}');

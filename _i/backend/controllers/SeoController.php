<?php

class SeoController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => false,
		//'disable_create' => true,
		'table' => 'seo',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'seo',
			'created_field' => 'seo_create_time', 
			//'updated_field' => 'seo_update_time',
			'primary' => 'id',
			'rules' => array(
				array('seo_type, seo_ml_key', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'seo_create_time', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('seo_keyword'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'seo_keyword', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'seo_keyword', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'condition' => array(
		//	array(
		//		'where',
		//		'',
		//	),
		//),
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=articlenormal1/sort', // ajax post都會有個目標
		//),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			'seo_type' => array(
				'label' => '功能',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			'seo_meta_keyword' => array(
				'label' => 'Keyword',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			//'seo_is_enable' => array(
			//	//'label' => 'ml:Status',
			//	'mlabel' => array(
			//		null, // category
			//		'Status', // label
			//		array(), // sprintf
			//		'狀態', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'ezshow' => true,
			//),
			'seo_create_time' => array(
				'label' => '建立時間',
				'width' => '20%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		'searchfield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate',
			),
			//'smarty_javascript' => '',
			'smarty_javascript_text' => '',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data_search',
					'name' => 'form_data_search',
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
						'seo_type' => array(
							'label' => '功能',
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_type',
								'name' => 'seo_type',
								'size' => '20',
							),
							'other' => array(
								'html_end' => '例如company, category, product',
							),
						),
						'seo_keyword' => array(
							'label' => 'Keyword',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_keyword',
								'name' => 'seo_keyword',
								'size' => '20',
							),
						),
					),
				),
			),
		),
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
						'seo_type' => array(
							'label' => '功能',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							//'merge' => 1,
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_type',
								'name' => 'seo_type',
								'size' => '30',
								//'readonly' => 'readonly',
							),
						),
						'seo_item_id' => array(
							'label' => '編號',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							//'merge' => 3,
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_item_id',
								'name' => 'seo_item_id',
								'size' => '10',
								//'readonly' => 'readonly',
							),
						),
						//'seo_keyword' => array(
						//	'label' => 'Keyword',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_keyword',
						//		'name' => 'seo_keyword',
						//		'size' => '40',
						//	),
						//	'other'=> array(
						//		'html_end' => '這邊輸入文字送出後則底下欄位如果是空白則會複寫',
						//		),
						//),
						'seo_title' => array(
							'label' => '視窗抬頭Title',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_title',
								'name' => 'seo_title',
								'size' => '75',
							),
						),
						'seo_script_name' => array(
							'label' => '檔案名稱(靜態頁網址)',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'seo_script_name',
								'name' => 'seo_script_name',
								'size' => '75',
							),
							'other' => array(
								'html_end' => '<p style="color:red">(只有百邇來的員工看得到這個欄位)</p>',
							),
						),
						//'seo_link_alt' => array(
						//	'label' => '連結說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_link_alt',
						//		'name' => 'seo_link_alt',
						//		'size' => '40',
						//	),
						//),
						//'seo_photo_l_alt' => array(
						//	'label' => '大圖說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_photo_l_alt',
						//		'name' => 'seo_photo_l_alt',
						//		'size' => '40',
						//	),
						//),
						//'seo_photo_m_alt' => array(
						//	'label' => '中圖說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_photo_m_alt',
						//		'name' => 'seo_photo_m_alt',
						//		'size' => '40',
						//	),
						//),
						//'seo_photo_s_alt' => array(
						//	'label' => '小圖說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_photo_s_alt',
						//		'name' => 'seo_photo_s_alt',
						//		'size' => '40',
						//	),
						//),
						'seo_meta_keyword' => array(
							'label' => '網頁關鍵字keyword',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							//'type' => 'input',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'seo_meta_keyword',
								'name' => 'seo_meta_keyword',
								'size' => '30',
								'rows' => '6',
								'cols' => '80',
							),
						),
						'seo_meta_description' => array(
							'label' => '網頁說明description',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							//'type' => 'input',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'seo_meta_description',
								'name' => 'seo_meta_description',
								'size' => '30',
								'rows' => '6',
								'cols' => '80',
							),
						),
						//'seo_meta_copyright' => array(
						//	'label' => '網頁版權',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'seo_meta_copyright',
						//		'name' => 'seo_meta_copyright',
						//		'size' => '40',
						//	),
						//),
						//'seo_is_enable' => array(
						//	'label' => '狀態',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Status', // label
						//	//	array(), // sprintf
						//	//	'狀態', // default
						//	//),
						//	'type' => 'status',
						//	'attr' => array(
						//		'id' => 'seo_is_enable',
						//		'name' => 'seo_is_enable',
						//	),
						//	'other' => array(
						//		'default'=>'1',
						//	),
						//),
					),
				),
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'detail' => array(
				//			'label' => '內容',
				//			//'type' => 'textarea',
				//			'type' => 'ckeditor_js',
				//			'attr' => array(
				//				//'class' => 'form-control', // 這…手動加上去好了
				//				'id' => 'detail',
				//				'name' => 'detail',
				//				//'rows' => '4',
				//				//'cols' => '40',
				//			),
				//		),
				//	),
				//),
			),
		), // updatefield
	);

	//protected function beforeAction($action)
	//{
	//	parent::beforeAction($action);

	//	// 無法帶入的變數中的變數，在這裡帶入
	//	$this->def['condition'][0][0] = 'where';
	//	$this->def['condition'][0][1] = 'type=\'articlenormal1\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
	//	$this->def['sortable']['condition'] = 'type="articlenormal1" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

	//	return true;
	//}

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		//$this->data['updatecontent']['class_id'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		$condition = ' 1 and seo_ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$condition_sortable = ' type="item1" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				//if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){
					$conditions[] = $k.'='.$v;
					//$conditions_sortable[] = $k.'='.$v;
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					//$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				//var_dump($conditions);
				//die;
			}
			if(count($conditions) > 0){
				if($condition != ''){
					$condition .= ' AND ';
				}
				$condition .= implode(' AND ', $conditions);
			}
			if($condition != ''){
				$this->def['condition'][0] = array(
					'where',
					$condition,
				);
			}
			//if(count($conditions_sortable) > 0){
			//	if($condition_sortable != ''){
			//		$condition_sortable .= ' AND ';
			//	}
			//	$condition .= implode(' AND ', $conditions_sortable);
			//}
			//if($condition_sortable != ''){
			//	$this->def['sortable']['condition'] = $condition_sortable;
			//}
			//var_dump($this->def['condition']);
			//die;
		} else {
			if(trim($condition) != ''){
				$this->def['condition'][] = array(
					'where',
					$condition,
				);
			}
			//if(trim($condition_sortable) != ''){
			//	$this->def['sortable']['condition'] = $condition_sortable;
			//}
		}

		// 只有公司員工，看得到靜態網址的欄位
		if(!preg_match('/^99999/', $this->data['admin_id'])){
			unset($this->def['updatefield']['sections'][0]['field']['seo_script_name']);
		}

		return true;
	}


	public function actionIndex($param = '')
	{
		$parameter = new Parameter_handle;
		$params = $parameter->get($param);
		$param_define = $parameter->getDefine();

		$this->data['def'] = G::definit($this->def, $this->data);
		$this->data['params'] = $params;
		$this->data['parameter'] = $param_define;

//		$this->index_param_handle();
//		$this->index_first();
//		$this->index_get_total();
//		$this->index_get_data();
//		$this->index_last_handle();

		if($this->main_content_exists($this->data['main_content'], $this->data) === false){
			$this->data['main_content'] = 'seo_tree/main';
		}

		$this->index_last();

		$this->data['_head_script'] = '
 <!-- fonts -->
  <link rel="stylesheet" href="backend/views/seo_tree/fonts/fontawesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="backend/views/seo_tree/fonts/fontawesome.line/css/font-awesome.css">

  <!-- suit -->
  <link rel="stylesheet" href="backend/views/seo_tree/js/fancybox/jquery.fancybox.css">

  <!-- basic -->
  <link rel="stylesheet" href="backend/views/seo_tree/css/style.css" />
';

		$this->display('index.htm', $this->data);		

	}

	protected function index_last()
	{		
		$url_prefix = '';
		$url_suffix = '_'.$this->data['ml_key'].'.php';
		$main_ml_key = '';
		define('LAYOUTV3_PATH', '');

		if(!function_exists('std_class_object_to_array')){
			function std_class_object_to_array($stdclassobject)
			{
				$_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

				foreach ($_array as $key => $value) {
					$value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
					$array[$key] = $value;
				}

				if(isset($array)){
					return $array;
				}
			}
		}

		$this->data['router_method'] = 'sitemapxml';

		include _BASEPATH.'/../source/menu/v2.php';//直接拉前台的資料流

		foreach ($tmp as $key => $value) {
			//解析 router_method 並塞入資料流
			$_router_method_revert = '';
            $_url = $value['url1'];
            if(preg_match('/^(.*)_(.*)_(.*)\.php/', $_url, $matches)){
            	$_router_method_revert = $matches[1].'_'.$matches[3];
            }elseif(preg_match('/^(.*)_(.*)\.php/', $_url, $matches)){
            	$_router_method_revert = $matches[1];
            }

            $tmp[$key]['_router_method_revert'] = $_router_method_revert;
            

            if($value['other3']!=0 && $value['other3']!=9){ //判斷主選單連結是否被複寫
            	$tmp[$key]['_router_method_revert'] = '';
            }  

            //查詢seo資料表有無資料
            $result = $this->cidb->where('seo_item_id',0)->where('seo_type',$_router_method_revert)->get('seo');

			$row = $result->row_array();
			if(isset($row['id'])){
				$tmp[$key]['_seo_data_true'] = true;
			}else{
				$tmp[$key]['_seo_data_true'] = false;
			}
			

            if(isset($value['child'])){
            	$tmp[$key]['child'] = $this->show_child($value['child'],$value['pic2']);//帶入是不是分類的參數
            }

		}

		$this->data['_menu_data'] = $tmp;

		if(0){
			?>
			<meta charset="utf-8">
			<?php
				new dBug($tmp,'',true);
				die;
			}

	}

	protected function show_child($data,$pic2 = 0) // pic2 (是否有分類)
	{
		foreach ($data as $key => $value) {
			//解析 router_method 並塞入資料流
			$_router_method_revert = '';
		    $seo_item_id = 0;

			$_url = '';
			if(isset($value['__link'])){
				$_url = $value['__link'];
			} elseif(isset($value['url'])){
				$_url = $value['url'];
			}

		    if(preg_match('/^(.*)_(.*)_(.*)\.php/', $_url, $matches)){
			    $_router_method_revert = $matches[1].'_'.$matches[3];
			    $seo_item_id = 0;
		    }elseif(preg_match('/^(.*)_(.*)\.php/', $_url, $matches)){
			    $_router_method_revert = $matches[1];
			    $seo_item_id = $value['id'];
		    }		    

		    if($_router_method_revert!=''){
		    	if($pic2=='1'){// 是或不是分類
			    	if(!isset($value['func_name'])){	 //判斷是不是靜態編輯頁	    		
			    	 	$_router_method_revert = $_router_method_revert.'type';
			    	}
			    }
		    }
		    		   
		    $_router_method_revert = str_replace('detailtype','',$_router_method_revert);

		    $data[$key]['_router_method_revert'] = $_router_method_revert;
		    

		    if($seo_item_id > 94879487){
		    	$seo_item_id = ($seo_item_id - 94879487);
		    }
		    
		    $data[$key]['seo_item_id'] = $seo_item_id;

		    //查詢seo資料表有無資料
            $result = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_item_id',$seo_item_id)->where('seo_type',$_router_method_revert)->get('seo');

			$row = $result->row_array();
			if(isset($row['id'])){
				$data[$key]['_seo_data_true'] = true;
			}else{
				$data[$key]['_seo_data_true'] = false;
			}			
			
			if(isset($value['child'])){
            	$data[$key]['child'] = $this->show_child($value['child'],$pic2);
            }

		}
			
		return $data;

	}

	public function actionDeldata($param = '')
	{
		
		$result = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_item_id',$_GET['seo_item_id'])->where('seo_type',$_GET['seo_type'])->delete('seo');		

		if($result){
			echo '1';
		}
		
	}

	public function actionGetdata($param = '')
	{
		//var_dump($_POST);

		$result = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_item_id',$_GET['seo_item_id'])->where('seo_type',$_GET['seo_type'])->get('seo');

		$row = $result->row_array();

		if(!isset($row['id'])){
			$row = array();
		}
		echo json_encode($row);	
	}

	public function actionRenew($param = '')
	{
		// var_dump($_POST);die;

		//2021/1/8 檢查有無重複的關鍵字資料，要把沒再用的刪除 #38560
		$result = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_script_name',$_POST['seo_script_name'])->where('seo_item_id !=',$_POST['seo_item_id'])->where('seo_type',$_POST['seo_type'])->delete('seo');
	

		$result = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_item_id',$_POST['seo_item_id'])->where('seo_type',$_POST['seo_type'])->get('seo');

		$row = $result->row_array();

		if(isset($row['id'])){
			$this->seo_update($row['id']);
		}else{
			$this->seo_create();
		}

		

		/* 這一段是從update_run_last那邊複製過來的
		 *
 		 * $statichtml = array(
 		 * 	'ggg' => array(
 		 * 		'tw' => array(
 		 * 			array(
 		 * 				'seo_type' => 'product',
 		 * 				'seo_item_id' => 33,
 		 * 			),
 		 * 		),
 		 * 	),
 		 * );
		 */

		$statichtml = array();

		$mls = $this->cidb->where('is_enable',1)->order_by('sort_id','asc')->get('ml')->result_array();
		if($mls){
			foreach($mls as $k => $v){
				$ml_key = $v['key'];
				$rows = $this->cidb->where('seo_ml_key',$ml_key)->get('seo')->result_array();
				if($rows){
					foreach($rows as $kk => $vv){
						if($vv['seo_script_name'] == ''){
							continue;
						}
						$tmp = array(
							'seo_type' => $vv['seo_type'],
							'seo_item_id' => $vv['seo_item_id'],
						);
						if(!isset($statichtml[$vv['seo_script_name']])){
							$statichtml[$vv['seo_script_name']] = array();
						}
						if(!isset($statichtml[$vv['seo_script_name']][$ml_key])){
							$statichtml[$vv['seo_script_name']][$ml_key] = array();
						}
						$statichtml[$vv['seo_script_name']][$ml_key][] = $tmp;
					}
				}
			}
		}

		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if($_constant){
			file_put_contents(_BASEPATH.'/assets/statichtml.php', '<'.'?'.'php $statichtml = '.var_export($statichtml,true).';');
		} else {
			@unlink(_BASEPATH.'/assets/statichtml.php');
		}
	}


	protected function seo_create($param = '')
    {
        if(empty($_POST)){			
        } else {
			//var_dump($this->def);
			$this->data['def'] = G::definit($this->def, $this->data);
			$savedata = $_POST;

			// 為了要支援sort_id改欄位名稱
			$sort_field = 'sort_id';
			if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
				$sort_field = $this->def['func_field']['sort_id'];
			}

			$savedata = $this->create_run_other_element($savedata);
			
			$savedata[$sort_field] = G::dbc($this->data['router_method'], $this->data['def']);

			$savedata = $this->create_run_pic($savedata);

			
			// 寫入比較特別，不需要在呼叫model()的method
			//$u = new Empty_orm('insert', $this->data['def']['empty_orm_data']);
			if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
				$u = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
			} else {
				$u = new $this->data['def']['orm'];
			}
			$this->data['datasave'] = $savedata;
			$u->setAttributes($savedata);

			// 做了這個動作，才會處理預設值等validator(像是處理create_time和update_time的動作)
			if(!$u->validate()){
				G::dbm($u->getErrors());
			}

			// save自己會做validate
			if(!$u->save()){
				G::dbm($u->getErrors());
			}

			$id = $this->db->getLastInsertID();

			if($id <= 0){
				G::m('insert id is empty');
			}

			// 重抓資料，等一下要記Log所使用的
			$s = $u::model()->findByPk($id);

			$this->data['_last_insert_id'] = $id;
			$sys_log_msg = 'create id:'.$id.', name:'.$s->{$this->data['def']['sys_log_name']};

			unset($u);
			unset($s);

			sys_log::set($sys_log_msg);

			$this->create_run_last();

			/*
			 * 2015-09-24
			 * 這裡會跟搜尋沖到
			 * 因為搜尋會更改condition
			 * 改了以後會導致搜尋source row失敗
			 * 由其是搜尋A類，而新增B分類的時候，保証出錯！
			 */

			// 先儲存，然後在檢查是否要更新排序的編號
			// 前面，是先寫接下來一筆的排序編號，最後，才會檢查排序的選項
			if(0 and isset($this->data['def']['listfield'][$sort_field])){
				// 取得數量，用在排序的編號產出
				//foreach($this->def['condition'] as $k => $v){
				//	$this->db->{$k}($v);
				//}
				//$query = $this->db->get($this->def['table']);
				//$sort_count = $query->num_rows();

				$sort_count = G::dbc($this->data['router_method'], $this->data['def']);

				$new_sort_id = '';
				if(isset($savedata['sort_id_point'])){
					if($savedata['sort_id_point'] == '1'){
						$new_sort_id = '1';
					} elseif($savedata['sort_id_point'] == '2'){
						$new_sort_id = $sort_count;
					} elseif($savedata['sort_id_point'] == '3'){
						$new_sort_id = $savedata['sort_id_select'];
						if($new_sort_id < 0) $new_sort_id = 1;
						if($new_sort_id > $sort_count) $new_sort_id = $sort_count;
					}
				}

				// 如果是相同的，當然就不需要在做排序的動作
				//if($new_sort_id == $old_sort_id){
				//	$new_sort_id = '';
				//}

				if($new_sort_id != ''){
					$fieldsorter = new Fieldsorter;
					$fieldsorter->setTableName($this->data['def']['table']);
					$fieldsorter->setIdName($this->data['def']['func_field']['id']);
					if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
						$fieldsorter->setCondition($this->data['def']['condition']);
					}
					// table_name, field_id, new_sort_id
					//$fieldsorter->go($this->data['def']['table'], $id, $new_sort_id);
					$fieldsorter->go($this->data['def']['table'], $id, $new_sort_id, array(), '', $sort_field); // 為了支援sort_id的脫勾
					if($fieldsorter->getStatus() === false){
						G::m($fieldsorter->getMessage());
					}
				}
			}			
			echo '1';
        }
    } // create

    /*
	 * 基本款
	 */
	public function seo_update($id)
    {
        if(empty($_POST)){			
        } else {
			$this->data['def'] = G::definit($this->def, $this->data);           

			// 讓下面的last函式所使用
			$this->data['id'] = $id;

            $update = $_POST;

			if($id == 0 and isset($_POST['is_copy']) and $_POST['is_copy'] > 0){
				$this->update_run_copy($update);
			}

			$update = $this->update_run_other_element($update);
			//var_dump($update);
			//die;

			//$update = $this->replace_quotes($update); //2017/10/13 加入特殊字元處理 by lota 

			// 為了要支援sort_id改欄位名稱
			$sort_field = 'sort_id';
			if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
				$sort_field = $this->def['func_field']['sort_id'];
			}

			$old_u = $this->db->createCommand()->from($this->data['def']['table'])->where($this->def['func_field']['id'].'=:id',array(':id'=>$id))->queryRow();
			if(isset($this->data['def']['listfield'][$sort_field])){
				$old_sort_id = $old_u[$sort_field];
			}

			$sys_log_msg = 'update id:'.$id.', name:'.$old_u[$this->data['def']['sys_log_name']];

			$update = $this->update_run_pic($update, $old_u);

			//$c = new Empty_orm('insert', $this->data['def']['empty_orm_data']);
			if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
				$c = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
			} else {
				$c = new $this->data['def']['orm'];
			}
			$u = $c::model()->findByPk($id);
			$this->data['dataupdate'] = $update;
			$u->setAttributes($update);

			//var_dump($this->data['def']['empty_orm_data']);
			//var_dump($_POST);
			//die;

			// 做了這個動作，才會處理預設值等validator(像是處理create_time和update_time的動作)
			if(!$u->validate()){
				G::dbm($u->getErrors());
			}

			// save自己會做validate
			if(!$u->update()){
				G::dbm($u->getErrors());
			}

			unset($u);
			unset($c);

			sys_log::set($sys_log_msg);

			$this->update_run_last();

			// 先儲存，然後在檢查是否要更新排序的編號
			//if(isset($this->def['listfield']['sort_id']) and isset($this->def['condition']) and count($this->def['condition']) > 0){
			if(isset($this->data['def']['listfield'][$sort_field])){				

				// 取得數量，用在排序的編號產出
				$sort_count = G::dbc($this->data['router_method'], $this->data['def']);

				$new_sort_id = '';
				if(isset($update['sort_id_point'])){
					if($update['sort_id_point'] == '1'){
						$new_sort_id = '1';
					} elseif($update['sort_id_point'] == '2'){
						$new_sort_id = $sort_count;
					} elseif($update['sort_id_point'] == '3'){
						$new_sort_id = $update['sort_id_select'];
					}
				}

				// 如果是相同的，當然就不需要在做排序的動作
				if($new_sort_id == $old_sort_id){
					$new_sort_id = '';
				}

				if($new_sort_id != ''){
					$fieldsorter = new Fieldsorter;
					$fieldsorter->setTableName($this->data['def']['table']);
					$fieldsorter->setIdName($this->data['def']['func_field']['id']);
					if(count($this->data['def']['condition']) > 0){
						$fieldsorter->setCondition($this->data['def']['condition']);
					}
					
					$fieldsorter->go($this->data['def']['table'], $id, $new_sort_id, array(), '', $sort_field); // 為了支援sort_id的脫勾
					if($fieldsorter->getStatus() === false){
						G::m($fieldsorter->getMessage());
					}
				} // new_sort_id
			}

			echo 'update ok';
			die;
        }
    } // update



	protected function update_run_other_element($array)
	{
		//$array['seo_ml_key'] = $this->data['admin_switch_data_ml_key'];
		//$array['type'] = 'articlenormal1';
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['seo_ml_key'] = $this->data['admin_switch_data_ml_key'];
		//$array['type'] = 'articlenormal1';
		return $array;
	}

	protected function update_run_last()
	{
		// $this->data['id']

		/*
 		 * $statichtml = array(
 		 * 	'ggg' => array(
 		 * 		'tw' => array(
 		 * 			array(
 		 * 				'seo_type' => 'product',
 		 * 				'seo_item_id' => 33,
 		 * 			),
 		 * 		),
 		 * 	),
 		 * );
		 */

		$statichtml = array();

		$mls = $this->cidb->where('is_enable',1)->order_by('sort_id','asc')->get('ml')->result_array();
		if($mls){
			foreach($mls as $k => $v){
				$ml_key = $v['key'];
				$rows = $this->cidb->where('seo_ml_key',$ml_key)->get('seo')->result_array();
				if($rows){
					foreach($rows as $kk => $vv){
						if($vv['seo_script_name'] == ''){
							continue;
						}
						$tmp = array(
							'seo_type' => $vv['seo_type'],
							'seo_item_id' => $vv['seo_item_id'],
						);
						if(!isset($statichtml[$vv['seo_script_name']])){
							$statichtml[$vv['seo_script_name']] = array();
						}
						if(!isset($statichtml[$vv['seo_script_name']][$ml_key])){
							$statichtml[$vv['seo_script_name']][$ml_key] = array();
						}
						$statichtml[$vv['seo_script_name']][$ml_key][] = $tmp;
					}
				}
			}
		}

		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if($_constant){
			file_put_contents(_BASEPATH.'/assets/statichtml.php', '<'.'?'.'php $statichtml = '.var_export($statichtml,true).';');
		} else {
			@unlink(_BASEPATH.'/assets/statichtml.php');
		}
	}

}

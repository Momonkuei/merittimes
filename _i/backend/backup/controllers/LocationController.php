<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_date_search' => false,
		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'enable_delete' => true, // 多選刪除
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
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			'pic1' => array(
				//'label' => '圖片',
				'mlabel' => array(
					null, // category
					'Image', // label
					array(), // sprintf
					'代表圖', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => false,
				'kcfinder_small_img' => true,
			),
			'xx2' => array(
				'label' => '區域',			
				'width' => '8%',
				'sort' => true,
			),
			'topic' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '20%',
				'sort' => true,
			),
			'url1' => array(
				'label' => '地址',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '20%',
				'sort' => true,
			),
			'other1' => array(
				'label' => '電話',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				'sort' => true,
			),
			'other2' => array(
				'label' => '傳真',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				'sort' => true,
			),
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
						'class_id' => array(
							'label' => '分類',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'class_id',
								'name' => 'class_id',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '',
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
						'topic' => array(
							//'label' => '標題',
							'mlabel' => array(
								null, // category
								'Title', // label
								array(), // sprintf
								'標題', // default
							),
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'class_id' => array(
							'label' => '分類',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'class_id',
								'name' => 'class_id',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '',
							),
						),

						'pic1' => array(
							'label' => '圖片上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',

								// 國旗
								// 'width' => '40',
								// 'height' => '30',
								// 'comment_size' => '40x30',

								// 廠房
								'width' => '800',
								'height' => '600',
								'comment_size' => '800x600',

								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),

						//'other1' => array(
						//	'label' => '說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'other1',
						//		'name' => 'other1',
						//		'size' => '40',
						//	),
						//),			
						
						'url1' => array(
							'label' => '地址',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'url1',
								'name' => 'url1',
								'size' => '50',
							),
						),
						'other1' => array(
							'label' => '電話',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '50',
							),
						),
						'other2' => array(
							'label' => '傳真',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other2',
								'name' => 'other2',
								'size' => '50',
							),
						),
						'other3' => array(
							'label' => 'E-mail',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other3',
								'name' => 'other3',
								'size' => '50',
							),
						),							
						'detail' => array(
							'label' => 'Google Map地址語法',
							'type' => 'textarea',							
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail',
								'name' => 'detail',
								'rows' => '4',
								'cols' => '100',
							),
						),
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'mlabel' => array(
								null, // category
								'Sort', // label
								array(), // sprintf
								'排序', // default
							),
							'type' => 'sort',
							'attr' => array(
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'mlabel' => array(
								null, // category
								'Status', // label
								array(), // sprintf
								'狀態', // default
							),
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

				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						/*'detail' => array(
							'label' => '內容',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail',
								'name' => 'detail',
								//'rows' => '4',
								//'cols' => '40',
							),
						),
						*/
						/*
						'field_tmp' => array(
							'label' => '首頁',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'field_tmp',
								'name' => 'field_tmp',
								//'rows' => '4',
								//'cols' => '40',
							),
						),
						*/
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		//if(isset($GLOBALS['lay_out_select']) && $GLOBALS['lay_out_select']!=1){
		//	unset($this->def['listfield']['is_home']);
		//	unset($this->def['updatefield']['sections'][0]['field']['pic2']);
		//	unset($this->def['updatefield']['sections'][1]['field']['field_tmp']);
		//}

		// unset($_constant);
		// eval('$_constant = '.strtoupper($this->data['router_class'].'_show_type').';'); // 分類
		// // if(LOCATION_SHOW_TYPE == 2){
		// if($_constant == 2){
		// } else {
		// }

		// 前台主選單的資料表功能
		$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
			$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
					$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
				}
			}
		} else {
			unset($this->def['searchfield']);
			unset($this->def['updatefield']['sections'][0]['field']['class_id']);
			unset($this->def['listfield']['xx2']);
		}

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['class_id'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){
					$conditions[] = $k.'='.$v;
					$conditions_sortable[] = $k.'='.$v;
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
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
			if(count($conditions_sortable) > 0){
				if($condition_sortable != ''){
					$condition_sortable .= ' AND ';
				}
				$condition .= implode(' AND ', $conditions_sortable);
			}
			if($condition_sortable != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
			//var_dump($this->def['condition']);
			//die;
		} else {
			if(trim($condition) != ''){
				$this->def['condition'][] = array(
					'where',
					$condition,
				);
			}
			if(trim($condition_sortable) != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
		}

		// 無法帶入的變數中的變數，在這裡帶入
		//$this->def['condition'][0][0] = 'where';
		//$this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$this->def['sortable']['condition'] = 'type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		return true;
	}

	protected function index_first($param='')
	{
		// 前台主選單的資料表功能
		$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
			// 取得商品分類的編號
			$class_id = 0;
			//if(isset($this->data['params']['value'][0])){
			//	$class_id = $this->data['params']['value'][0];
			//}
			if(isset($_SESSION[$this->data['router_class'].'_search']['class_id']) and $_SESSION[$this->data['router_class'].'_search']['class_id'] > 0){
				$class_id = $_SESSION[$this->data['router_class'].'_search']['class_id'];
			}
			$this->data['class_id'] = $class_id;


			//if(PRODUCT_ADD_LATER == true){ //2016/6/15 取消，改天再來想看看要放在哪邊
				//2016/5/16 讓尚未選擇分類搜尋也可以調整順序 (以後可能會有問題，到時再解決 2016/6/15 重新讓它作用
				if($class_id <= 0){
					unset($this->data['def']['listfield']['sort_id']);
				}
				

				// 商品分類編號要有指定，還有其它必要的條件，才能夠即時自動切換
				if($class_id > 0){
					$this->data['def']['sortable']['enable'] = true;
					$this->data['def']['sortable']['condition'] = 'class_id = '.$this->data['class_id'].' ';

					$this->data['def']['condition']['where']['class_id'] = $class_id;
				} else {
					$this->data['def']['sortable']['enable'] = false;
				}

				// 如果沒有選擇商品分類，而且又沒有指定排序的方式，這時預設排序欄位會改成商品名稱 2016/6/15 預設值改為id
				if($class_id <= 0 and $this->data['sort_field_nobase64'] == 'sort_id'){
					$sort_field = 'id';//$sort_field = 'topic';
					$this->data['params']['direction'] = 'desc';//2016/6/23 初始化為反序，方便客戶馬上看到新增的資料
					//$this->load->library('base64url');
					//$this->data['sort_field'] = $this->base64url->encode($sort_field);
					$this->data['sort_field'] = base64url::encode($sort_field);
					$this->data['sort_field_nobase64'] = $sort_field;
				}
			//}
		} else { // 無分類
			parent::index_first($param);
		}
	}

	protected function index_last($param='')
	{
		$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
			if(isset($row['is_news']) and $row['is_news'] == 1){ // 是通用分類
				$show_type_mode = 1; //通用資料表
			}else{
				$show_type_mode = 2; //獨立資料表
			}
		}else{
			$show_type_mode = 0; //沒有分類
		}

		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}				
				//這邊先做通用的，獨立的以後再說 by lota
				if($v['class_id']!=0 && $show_type_mode==1){
					$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id='.$v['class_id'], array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
					$v['xx2'] = $rows['topic'];
				}
				
				$this->data['listcontent'][$k] = $v;
			}
		}

	}

	protected function update_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

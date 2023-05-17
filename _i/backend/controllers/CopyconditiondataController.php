<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		//'header_closed' => true, // 側邊選單
		//'page_sidebar_closed' => true, // 側邊選單
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'disable_create' => true,

		// 在各功能的上面的新增的右邊(匯出功能之一)
		// 'index_buttons' => array(
		// 	array(
		// 		'name' => '匯出<i class="icon-external-link"></i>',  // 按鈕的名稱和圖示
		// 		'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
		// 		'id' => '', // button
		// 		'class' => 'btn btn-info', // button
		// 		'onclick' => 'javascript:location.href=\'XXX\'',
		// 	),
		// ),

		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				// array('topic', 'required'),
				// array('detail', 'system.backend.extensions.myvalidators.numericcodeutf8'),
				// array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'enable_delete' => false, // 多選刪除
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('XXX'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'XXX', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'XXX', // 要給sys_log記錄名稱欄位值的設定
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
		//'func_field' => array(
		//	'id' => 'id',
		//	'sort_id' => 'sort_id',
		//),
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
			'topic' => array(
				'label' => '英文別名',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '35%',
				'sort' => true,
			),
			'name' => array(
				// 'label' => '名稱',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '60%',
				'sort' => true,
			),
		), // listfield
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate',
			),
		),
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
					'method' => 'get',
					'action' => '',
				),
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'r' => array(
							'label' => '',
							'type' => 'hidden',
							'attr' => array(
								'id' => 'r',
								'name' => 'r',
							),
						),
						'table' => array(
							'label' => '資料表',
							'type' => 'input',
							'attr' => array(
								'id' => 'table',
								'name' => 'table',
								'size' => '10',
							),
						),
						'field' => array(
							'label' => '欄位',
							'type' => 'input',
							'attr' => array(
								'id' => 'field',
								'name' => 'field',
								'size' => '10',
							),
						),
						'source' => array(
							'label' => '來源數值',
							'type' => 'input',
							'attr' => array(
								'id' => 'source',
								'name' => 'source',
								'size' => '40',
							),
						),
						'dest' => array(
							'label' => '目的數值',
							'type' => 'input',
							'attr' => array(
								'id' => 'dest',
								'name' => 'dest',
								'size' => '40',
							),
						),
						'xx01' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
					),
				),
			),
		),
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		if(!empty($_GET)){
			$check = true;
			foreach(array('table','field','source','dest') as $v){
				if(isset($_GET[$v]) and $_GET[$v] != ''){
					eval('$'.$v.' = "'.$_GET[$v].'";');
					// do nothing
				} else {
					$check = false;
				}
			}
			//var_dump($_GET);die;

			$check2 = true;
			if($check){
				if(!$this->cidb->table_exists($table)){
					$check2 = false;
				}
			}

			$check3 = true;
			if($check and $check2){
				$rows = $this->cidb->where($field,$source)->get($table)->result_array();
				if($rows and !empty($rows)){
					foreach($rows as $k => $v){
						unset($rows[$k]['id']);

						if(isset($rows[$k][$field])){
							$rows[$k][$field] = $dest;
						} else {
							$check3 = false;
						}
					}
				} else {
					$check3 = false;
				}
			} else {
				$check3 = false;
			}

			if($check and $check2 and $check3){
				$this->cidb->insert_batch($table,$rows);

				$this->redirect($this->createUrl($this->data['router_class'].'/index'));
			}
		}

		$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		$this->def['condition'][0] = array(
			'where',
			$condition,
		);
		$this->def['sortable']['condition'] = $condition_sortable;

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();
		$this->data['updatecontent']['r'] = $this->data['router_class'];

		foreach(array('table','field','source','dest') as $v){
			if(isset($_GET[$v]) and $_GET[$v] != ''){
				$this->data['updatecontent'][$v] = $_GET[$v];
			}
		}

		$this->def['searchfield']['sections'][0]['field']['xx01']['other']['html'] = '* 備註：如果符合where(欄位,來源數值) => 原地複製 => 修改新資料，欄位=目的數值';

		return true;
	}

	public function actionCancel_search()
	{
		$this->redirect($this->createUrl($this->data['router_class'].'/index'));
	}

	//public function actionSearch()
	//{
	//}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'header_closed' => true, // 側邊選單
		'page_sidebar_closed' => true, // 側邊選單
		'disable_index_normal_search' => true,
		'disable_create' => true,
		'disable_edit' => true,
		'disable_delete' => true,
		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
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
				'label' => '名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			'other1' => array(
				'label' => '欄位',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		if(
			isset($_SESSION['funcfieldv3_router_class']) and $_SESSION['funcfieldv3_router_class'] != '' and
			isset($_SESSION['funcfieldv3_table']) and $_SESSION['funcfieldv3_table'] != ''
		){
			// do nothing
		} else {
			header("HTTP/1.0 404 Not Found");
			die;
		}

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $_SESSION['funcfieldv3_table'];
		//$this->def['empty_orm_data']['table'] = $_SESSION['funcfieldv3_table'];
		$this->def['table'] = 'html';
		$this->def['empty_orm_data']['table'] = 'html';
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		$type = 'funcfieldv3__'.$_SESSION['funcfieldv3_router_class'].'__'.$_SESSION['funcfieldv3_table'];

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'type=\''.$type.'\' ';
		$this->def['sortable']['condition'] = 'type="'.$type.'" ';

		return true;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

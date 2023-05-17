<?php

// 這裡不需要了，不過可以留下來，因為我動作都寫好了
// $admin_field_router_class = 'product';
// $admin_field_variable = 'ItemxController';
// include 'admin_field_get.php';

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		//'enable_index_advanced_search' => true,
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
				array('name', 'required'),
				array('name,class_id', 'required'),
				//array('class_id', 'required'),//或是用這種
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		//'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'sort_id_home', // 預設要排序的欄位 2016/04/29 改為預設為id 如有搜尋分類,則動態改為sort_id 2016/6/15 因點選分類後會無法排序，再度改回sort_id
		'func_field' => array(
			'id' => 'id',
			'sort_id' => 'sort_id_home',
		),
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
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
			//'xx_01' => array(
			//	'label' => '',
			//	'width' => '7%',
			//	'align' => 'center',
			//	'ezdelete' => true,
			//),
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
			'name' => array(
				'label' => '名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '50%',
				'sort' => true,
			),
			//'is_enable' => array(
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
			'sort_id_home' => array(
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

		$product_table = $this->data['router_class'];
		$product_table = str_replace('homesort', '', $product_table); // 為了支援產品的首頁排序

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $product_table;
		$this->def['empty_orm_data']['table'] = $product_table;
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'is_enable=1 and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' and is_home=1 ';
		$this->def['sortable']['condition'] = 'is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" and is_home=1 ';

		return true;
	}

	protected function index_last($param='')
	{
		//var_dump($this->data['listcontent']);
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.str_replace('homesort', '', $this->data['router_class']).'/'.$v['pic1'];
				}

				$this->data['listcontent'][$k] = $v;
			}
		}
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

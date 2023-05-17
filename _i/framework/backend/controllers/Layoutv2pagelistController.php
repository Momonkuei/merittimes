<?php

class Layoutv2pagelistController extends Controller {

	protected $def = array(
		'disable_create' => true,
		'disable_action' => true,
		'disable_index_normal_search' => true,
		//'table' => 'sys_model',
		'orm' => 'Empty_orm',
		//'empty_orm_data' => array(
		//	'table' => 'sys_model',
		//),
		'default_sort_field' => 'name', // 預設要排序的欄位
		'search_keyword_field' => array('name',), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'get_field_label' => array('name'), // 要變成多國語系的輸出欄位的欄位
		//'condition' => array(
		//	array(
		//		'where',
		//		'pid=0',
		//	),
		//),
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=func/sort', // ajax post都會有個目標
		//),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'func/main_content_top.htm',
		//),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'name' => array(
				'label' => '名稱',
				'width' => '10%',
				//'align' => 'left',
				//'sort' => true,
			),
			'need_edit' => array(
				'label' => '開啟修改',
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
				'ezother' => '&nbsp;',
			),
			'xx01' => array(
				'label' => '&nbsp;',
				'width' => '80%',
				'align' => 'center',
			),
		), // listfield
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				//'jquery-validate', 'fileuploader', 'jyoutube', 'jquery-ui', 'javascript-sortable',
			),
			//'smarty_javascript' => '',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
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
					),
				),
			),
		), // updatefield
	);

	public function actionCheckbox_listcontent_trigger()
	{
        if(!empty($_POST)){
			$value = $_POST['value'];
			$id = $_POST['id'];

			$this->data['session_name'] = $id.'_winnie_layout_v2';

			//$_SESSION[$id.'_winnie_layout_v2_edit'] = $value;
			//unset($_SESSION[$id.'_winnie_layout_v2_params']);

			if($value == '1'){
				$_SESSION[$this->data['session_name'].'_edit'] = true;
				unset($_SESSION[$this->data['session_name'].'_params']);
			} else {
				$_SESSION[$this->data['session_name'].'_edit'] = false;
			}

			echo '1';
		}
		echo '';
		die;
	}

	public function actionIndex($param = '')
	{
		$parameter = new Parameter_handle;
		$params = $parameter->get($param);
		$param_define = $parameter->getDefine();

		$this->data['def'] = G::definit($this->def, $this->data);
		$this->data['params'] = $params;
		$this->data['parameter'] = $param_define;

		$this->index_param_handle();

		//$this->index_get_total();

		$this->data['pagination'] = array(
			'url' => '',
			'control' => array(
				'total' => 0,
			),
		);

		//$this->index_get_data();

		$path_tmp = Yii::getPathOfAlias('application').'/../web/controllers/layoutv2';
		$tmps = CFileHelper::findFiles($path_tmp);
		if($tmps){
			foreach($tmps as $k => $v){
				$tmp = str_replace($path_tmp.'/', '', $v);
				if(!preg_match('/^layout_/', $tmp)) continue;
				$this->data['layouts'][$tmp] = '1';
			}
		}
		ksort($this->data['layouts']);
		
		$this->data['listcontent'] = array();
		if($this->data['layouts']){
			foreach($this->data['layouts'] as $k => $xxx){

				$need_edit = false;

				$name = $k;
				$name = str_replace('.php','',$name);
				$name = str_replace('layout_','',$name);

				$name_dash = $name;

				$session_name = $name.'_winnie_layout_v2';
				if(isset($_SESSION[$session_name.'_edit'])){
					$need_edit = $_SESSION[$session_name.'_edit'];
				}

				$name = str_replace('-','/',$name);

				$this->data['listcontent'][$k] = array(
					'id' => $name_dash,
					'name' => $name,
					'need_edit' => $need_edit,
				);

				//$this->data['listcontent'][$k] = $tmp;
			}
		}
		//var_dump($tmp);
		//die;

		$this->index_last_handle();

		if($this->main_content_exists($this->data['main_content'], $this->data) === false){
			$this->data['main_content'] = 'default/index';
		}

		//$this->index_last();

		$this->display('index.htm', $this->data);
		//$this->display('text:123{{**}}', $this->data);
	}


}

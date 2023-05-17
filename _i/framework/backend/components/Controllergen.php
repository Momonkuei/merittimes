<?php

/*
 * 這是使用v2產生器，然後搭配假資料的產生的狀況
 */
class Controllergen extends Controller
{
	// BJ4
	// 如果是空白，在某一個階段會補齊它
	// $this->default_def
	protected $def = array();

	protected function index_get_total()
	{
	}

	protected function index_get_data()
	{
	}

	protected function index_last_handle()
	{
		$this->data['pagination'] = array(
			'url' => '',
			'control' => array(
				'total' => 0,
			),
		);

		/*
		 * 沒有複製這些程式碼過來，欄位就沒辦法顯示出來
		 */
		if(isset($this->data['def']['listfield'])){
			// 建立前端要顯示的欄位
			$this->data['listfield'] = $this->data['def']['listfield'];

			// 自動補上判斷用的base64欄位英文名稱
			foreach($this->data['listfield'] as $k => $v){
				$this->data['listfield'][$k]['base64'] = base64url::encode($k);
				if(isset($v['label'])){
					$this->data['listfield'][$k]['label'] = $this->_getValueLabel($v['label'], $this->data['ml_key']);
				}
			}
		}

		if(isset($this->data['def']['listfield_foot'])){
			// 建立前端要顯示的欄位
			$this->data['listfield_foot'] = $this->data['def']['listfield_foot'];

			// 自動補上判斷用的base64欄位英文名稱
			foreach($this->data['listfield_foot'] as $k => $v){
				$this->data['listfield_foot'][$k]['base64'] = base64url::encode($k);
				if(isset($v['label'])){
					$this->data['listfield_foot'][$k]['label'] = $this->_getValueLabel($v['label'], $this->data['ml_key']);
				}
			}
		}


		// 當啟用搜尋，就停用即時排序和上下排序(2012-11-07的新功能)
		if($this->data['search_keyword'] != ''){
			unset($this->data['def']['sortable']);
			$this->data['sort_field_nobase64'] = '';
		}
	}

	protected function index_last()
	{
		$row = $this->db->createCommand()->from('sys_func_v2')->where('is_enable=1 and func=:func', array(':func'=>$this->data['router_class']))->queryRow();
		if($row and isset($row['id'])){
			// 輸出假資料
			$rows = $this->db->createCommand()->from('sys_func_v2_list1')->where('is_enable=1 and data_id=:id', array(':id'=>$row['id']))->order('sort_id')->queryAll();
			if($rows and count($rows) > 0){
				for($x=0;$x<=10;$x++){
					$tmp = array('id'=>$x);
					foreach($rows as $k => $v){
						$tmp[$v['keyname']] = 'xx';
					}
					$this->data['listcontent'][] = $tmp;
				}
			}
		}
	}

	public function actionCreate($param = '')
    {
        if(empty($_POST)){
			$parameter = new Parameter_handle;
			$params = $parameter->get($param);
			$param_define = $parameter->getDefine();

			$this->data['def'] = G::definit($this->def, $this->data);
			$this->data['params'] = $params;
			$this->data['parameter'] = $param_define;

			$this->data['updatecontent'] = array();

			$row = $this->db->createCommand()->from('sys_func_v2')->where('is_enable=1 and func=:func', array(':func'=>$this->data['router_class']))->queryRow();
			if($row and isset($row['id'])){
				// 輸出假資料
				$rows = $this->db->createCommand()->from('sys_func_v2_update')->where('is_enable=1 and data_id=:id', array(':id'=>$row['id']))->order('sort_id')->queryAll();
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						$this->data['updatecontent'][$v['keyname']] = 'xx';
					}
				}
			}

			// blha

			if($this->main_content_exists($this->data['main_content'], $this->data) === false){
				$this->data['main_content'] = 'default/update';
				$this->data['def']['updatefield']['method'] = 'create';
				$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
			}

			$this->display('index.htm', $this->data);
		}
	}

	public function actionUpdate($param = '')
    {
        if(empty($_POST)){
			$parameter = new Parameter_handle;
			$params = $parameter->get($param);
			$param_define = $parameter->getDefine();

			$this->data['def'] = G::definit($this->def, $this->data);
			$this->data['params'] = $params;
			$this->data['parameter'] = $param_define;

			if(!isset($params['value'][0])){
				$msg = $this->_getLabel('no id');
				G::m($msg);
			}
			$id = $params['value'][0];
			$this->data['id'] = $id;

			$this->update_show_first($params);

			if(count($params['value']) > 1){
				$update_success = $params['value'][count($params['value']) - 1];
				if($update_success == 'success') $this->data['update_success'] = '1';
			}

			$validation = array();

			$updatecontent = array();

			$row = $this->db->createCommand()->from('sys_func_v2')->where('is_enable=1 and func=:func', array(':func'=>$this->data['router_class']))->queryRow();
			if($row and isset($row['id'])){
				// 輸出假資料
				$rows = $this->db->createCommand()->from('sys_func_v2_update')->where('is_enable=1 and data_id=:id', array(':id'=>$row['id']))->order('sort_id')->queryAll();
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						$updatecontent[$v['keyname']] = 'xx';
					}
				}
			}

			// blha ...

            $this->data['updatecontent'] = $updatecontent;
			// 給前台jquery validate元件運作的json資料
            $this->data['jqueryvalidation'] = json_encode($validation);
			// 給rander前台的field，呈現必填的星號部份
            $this->data['updatecontent_jqueryvalidation'] = $validation;

			// 取得數量，用在排序的編號產出
			if(isset($this->data['def']['listfield']['sort_id'])){
				$this->data['class_sort_count'] = G::dbc($this->data['router_method'], $this->data['def']);
			}

			// 記錄上一頁
			$this->data['prev_url'] = base64url::decode($params['prev']);

			// 帶到前端，讓smarty知道，下一個頁面是自己
			$this->data['update_base64_url'] = $this->data['current_base64_url'];


			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];

			// 如果view不存在，就不用客氣，直接使用通用版
			if($this->main_content_exists($this->data['main_content'], $this->data) === false){
				$this->data['main_content'] = 'default/update';
				//$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'&param=v'.$this->data['updatecontent']['id'];
			}

			$this->update_show_last($updatecontent);

			$this->display('index.htm', $this->data);
		}
	}
}

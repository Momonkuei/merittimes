<?php

class XXXXXXXX_A extends XXXXXXXX_B
{

	//public function createUrl($route,$params=array(),$ampersand='&')
	//{
	//	echo '123';
	//	die;
	//}

	/*
	 * 第二版的controller產生器
	 * 如果有加什麼新的欄位，不要忘了這裡
	 *
	 * 這裡的作用，在於後台的功能controller沒有去define $def變數的時候，或是$def是空的時候，就會用這裡的東西去取代
	 */
	protected function default_def()
	{
		return array(

			'enable_index_advanced_search' => false,
			'disable_index_normal_search' => false,

			'disable_action' => false,
			'enable_index_create' => false,
			'disable_create' => false,
			//'disable_XXX' => false, // 你可以指定任意欄位取消
			'disable_edit' => false,
			'disable_delete' => false,
			'enable_view' => false, // 預設View按鈕是不出現的，剛好跟edit和delete是相反的，除非你打開它
			'enable_edit_button_changeto_view_button' => false, // 當需求是：想要有純觀看的功能，但是裡面又要有欄位可以做修改的動作，那就只是改一下edit的按鈕->View的按鈕

			/* 如果要啟用這個功能，別忘了後台listfield要有一個欄位必需設定ezdelete
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			 */
			'enable_delete' => false, // 多選刪除

			'tools_name' => '工具',
			'tools' => array(
				array(
					'class' => '',
					'target' => '',
					'url' => '',
					'name' => '',
				),
			),

			'title' => '', // 如果這裡有設定，將會覆寫後台主選單的文字
			'table' => $this->data['router_class'],
			'orm' => 'Empty_orm',
			'empty_orm_data' => array(
				'table' => $this->data['router_class'],
				//'created_field' => 'create_time', 
				//'updated_field' => 'update_time',
				'primary' => 'id',
				'rules' => array(
				),
			),
			'default_sort_field' => 'id', // 預設要排序的欄位
			'default_sort_direction' => 'asc',
			'search_keyword_field' => array('id'), // 搜尋字串要搜尋的欄位
			'search_keyword_assign_field' => 'id', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
			'sys_log_name' => 'id', // 要給sys_log記錄名稱欄位值的設定
			'data_multilanguage' => false, // 是否有多國語系的資料
			'data_multilanguage_update' => 'xxx01', // 在資料內頁中，切換多國語系，依照某一個欄位
			'condition' => array(
				//	array(
				//		'where',
				//		'type="exhibition"',
				//	),
			),
			'sortable' => array(
				'enable' => false,
				'condition' => '', // 有其它條件的時候，例如有商品分類
				'url' => '', // ajax post都會有個目標
			),
			// 功能性欄位，沒有定義的話，會自動補齊
			'func_field' => array(
				'id' => 'id',
				'sort_id' => 'sort_id',
			),
			// 建立前端要顯示的欄位
			'listfield_attr' => array(
				'smarty_include_top' => '',
			),
			'listfield' => array(
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
					// blha...
				),
			),
			// 定義修改要顯示的欄位
			'updatefield' => array(
				// jquery-validate, jquery-datepicker
				'head' => array(
					'jquery-validate',
				),
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
					'button_style' => '1',
				),
				'sections' => array(
					// blha...
				),
			), // updatefield
		);
	}

	public function actionCancel_search()
	{
		//if(method_exists($this, 'get_search_session_name')){
		//	$ss = $this->get_search_session_name();
		//} else {
		//	$ss = $this->data['router_class'].'_search';
		//}
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		$session = array();
		Yii::app()->session[$ss] = $session;

		$this->redirect($this->createUrl($this->data['router_class'].'/index'));
	}

	public function actionSearch()
	{
		if(!empty($_POST)){

			//if(method_exists($this, 'get_search_session_name')){
			//	$ss = $this->get_search_session_name();
			//} else {
			//	$ss = $this->data['router_class'].'_search';
			//}
			$ss = $this->data['router_class'].'_search';
			$session = Yii::app()->session[$ss];
			if($session === null){
				$session = array();
			}
			// 處理一下checkbox的欄位
			if($session){
				foreach($session as $k => $v){
					if(preg_match('/^checkbox_/', $k)){
						unset($session[$k]);
					}
				}
			}
			foreach($_POST as $k => $v){
				$session[$k] = $v;
			}
			Yii::app()->session[$ss] = $session;

			$this->redirect($this->createUrl($this->data['router_class'].'/index'));
		}
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
		$this->index_first();
		$this->index_get_total();
		$this->index_get_data();
		$this->index_last_handle();

		if($this->main_content_exists($this->data['main_content'], $this->data) === false){
			$this->data['main_content'] = 'default/index';
		}

		$this->index_last();

		$this->display('index.htm', $this->data);
		//$this->display('text:123{{**}}', $this->data);
	}

	// 把一些固定先前要處理的事情，例如引數處理，放在獨立的地方
	protected function index_param_handle()
	{
		// 排序的欄位
		if($this->data['params']['sort'] == ''){
			// 這裡指定預設要排序的欄位
			if(isset($this->data['def']['default_sort_field'])){
				$sort_field = $this->data['def']['default_sort_field'];
			} else {
				$sort_field = 'id';
			}
		} else {
			$sort_field = base64url::decode($this->data['params']['sort']);
		}
		$this->data['sort_field'] = base64url::encode($sort_field);
		$this->data['sort_field_nobase64'] = $sort_field;

		// 排序欄位的方向(asc, desc)
		if($this->data['params']['direction'] == ''){
			// 這裡允許被修改預設的排序狀態，而且是跟預設欄位相同的時候，才會有作用
			if(isset($this->data['def']['default_sort_direction']) and $this->data['def']['default_sort_direction'] != '' and isset($this->data['def']['default_sort_field']) and $sort_field == $this->data['def']['default_sort_field']){
				$sort_direction = $this->data['def']['default_sort_direction'];
			} else {
				$sort_direction = 'asc';
			}
		} else {
			$sort_direction = $this->data['params']['direction'];
		}
		if($sort_direction == 'asc'){
			$next_sort_direction = 'desc';
		} else {
			$next_sort_direction = 'asc';
		}
		$this->data['sort_direction'] = $sort_direction;
		$this->data['next_sort_direction'] = $next_sort_direction;
		
		// 因為後面的後面，存取資料庫的時候，是用這個變數
		$this->data['params']['direction'] = $sort_direction;

		// 將排序的引數結合起來，給欄位超連結，和分頁超連結
		$this->data['sort_url'] = $this->data['parameter']['sort'].$this->data['sort_field'].'-'.$this->data['parameter']['direction'].$sort_direction;

		// 如果有指定搜尋，那就搜尋，並且存到session
		// 如果沒有指定，但是session有，也還是會做搜尋的動作
		$search_keyword = '';
		if($this->data['params']['nosearch'] != ''){
			Yii::app()->session['search'] = array($this->data['router_class'], '');
			//$this->session->set_userdata('search', array($this->data['router_class'], ''));
			$this->data['search_keyword'] = '';
		}
		if($this->data['params']['search'] != ''){
			//echo $this->data['params']['search'];
			$search_keyword = base64url::decode($this->data['params']['search']);
			//echo $search_keyword;
			//die;
			Yii::app()->session['search'] = array(array($this->data['router_class'], $search_keyword));
			//$this->session->set_userdata('search', array($this->data['router_class'], $search_keyword));
		} else {
			$search_tmp = Yii::app()->session['search'];
			//$search_tmp = $this->session->userdata('search');
			if($search_tmp[0] == $this->data['router_class'] and $search_tmp[1] != ''){
				$search_keyword = $search_tmp[1];
			}
		}
		$this->data['search_keyword'] = $search_keyword;

		// 設定每頁顯示的筆數
		if($this->data['params']['record'] != ''){
			$record = $this->data['params']['record'];
			Yii::app()->session['record'] = (int)$record;
			//$this->session->set_userdata('record', (int)$record);
		} else {
			$record = Yii::app()->session['record'];
			//$record = $this->session->userdata('record');
			if($record === false or $record == ''){
				$record = '10';
				Yii::app()->session['record'] = (int)$record;
				//$this->session->set_userdata('record', (int)$record);
			}
		}
		$this->data['record'] = (int)$record;
	}


	protected function index_first(){}
	protected function index_last(){}

	// 商品列表中，取得數量，數量是用於分頁的，所以裡面還會包含分頁的init程式
	protected function index_get_total()
	{
		// 先重組搜尋資料的SQL語法
		$search_sql_append = '';

		// debug
		//$this->data['search_keyword'] = '123';

		$search_sql_appends_params = array();
		if($this->data['search_keyword'] != '' and isset($this->data['def']['search_keyword_field']) and count($this->data['def']['search_keyword_field']) > 0){
			// 範例SQL語法，因為要括號起來，比較特別，所以在這裡寫個範例
			// select * from html where type='faq' and ml_key='en' and (topic like '%b%' or detail like '%b%')
			$search_sql_append = '(';
			$search_sql_appends = array();
			foreach($this->data['def']['search_keyword_field'] as $k => $v){
				//$search_sql_appends[] = ' `'.$v.'` LIKE \'%'.$this->data['search_keyword'].'%\' ';
				$search_sql_appends[] = ' `'.$v.'` LIKE \'%:a'.$k.'%\' ';
				$search_sql_appends_params[':a'.$k] = $this->data['search_keyword'];
			}
			$search_sql_append .= implode(' OR ', $search_sql_appends);
			$search_sql_append .= ')';
		}

		// 取得資料筆數，依照def的規則
		$search_def = $this->data['def'];
		if($search_sql_append != ''){
			$tmp = array(
				'where', 
				$search_sql_append,
				$search_sql_appends_params
			);
			$search_def['condition'][] = $tmp;
		}
		$total_rows = G::dbc($this->data['router_method'], $search_def);

		// 分頁區塊
		$splitpage = new Splitpage;
		$splitpage->set($this->data['params']['page'], $total_rows, $this->data['record'], $this->data['params']['list']); //set($page, $total_records, $records_per_page, $listPage)
		$base_url = $this->data['base_url'].'/backend.php?r='.$this->data['router_class'];
		//if(isset($this->data['params']['module_serial_id']) and $this->data['params']['module_serial_id'] != ''){
		//	$base_url .= '_'.$this->data['params']['module_serial_id'];
		//}
		$base_url .= '/'.$this->data['router_method'].'&param=';
		$base_url2 = $base_url;
		$base_url .= $this->data['parameter']['page'];

		$this->data['pagination'] = $splitpage->setViewList_for_rewrite($base_url, $base_url2); // 取得分頁bar的變數
		//var_dump($this->data['pagination']);
		//die;
	}

	// 取得資料
	protected function index_get_data()
	{
		// 先重組搜尋資料的SQL語法
		$search_sql_append = '';

		$search_sql_appends_params = array();
		if($this->data['search_keyword'] != '' and isset($this->data['def']['search_keyword_field']) and count($this->data['def']['search_keyword_field']) > 0){
			// 範例SQL語法，因為要括號起來，比較特別，所以在這裡寫個範例
			// select * from html where type='faq' and ml_key='en' and (topic like '%b%' or detail like '%b%')
			$search_sql_append = '(';
			foreach($this->data['def']['search_keyword_field'] as $k => $v){
				$search_sql_appends[] = ' `'.$v.'` LIKE \'%'.$this->data['search_keyword'].'%\' ';
				$search_sql_appends_params[':a'.$k] = $this->data['search_keyword'];
			}
			$search_sql_append .= implode(' OR ', $search_sql_appends);
			$search_sql_append .= ')';
		}

		$listcontent = array();
		if(isset($this->data['def']['table'])){
			$c = $this->db->createCommand();
			$c->from($this->data['def']['table']);
			if($search_sql_append != ''){
				$c->where($search_sql_append, $search_sql_appends_params);
			}
			$c->limit($this->data['record'], ($this->data['params']['page']-1)*$this->data['record']);

			// 客製，特別狀況
			if(preg_match('/^(card_number_format)$/', $this->data['sort_field_nobase64'])){
				$c->order(str_replace('_format', '', $this->data['sort_field_nobase64']).' '.$this->data['params']['direction']);
			} else {
				$c->order($this->data['sort_field_nobase64'].' '.$this->data['params']['direction']);
			}

			if(isset($this->data['def']['condition'])){
				$r_condition = G::dbt($this->data['def']['condition'], '$c');
				if($r_condition != ''){
					eval($r_condition);
				}
			}
			//$c->where('is_hidden = 0');
			$listcontent = $c->queryAll();
		}

		$this->data['listcontent'] = $listcontent;
	}

	// 這個函式是列表中最後會做的事
	protected function index_last_handle()
	{
		$rows = $this->db->createCommand()->from('member')->queryAll();
		$aaa = new Eob;
		$user_tmp = $aaa->handle_data_tmp($rows);
		$system_user = array(
			'id' => 999999999,
			'name' => 'System',
		);
		$user_tmp[$system_user['id']] = $system_user;

		// 將一般的欄位，增加ml:前綴字串，轉換成多國語系片語
		if(isset($this->data['def']['get_field_label'])){
			foreach($this->data['def']['get_field_label'] as $v){
				foreach($this->data['listcontent'] as $kk => $vv){
					$this->data['listcontent'][$kk][$v] = $this->_getValueLabel($vv[$v], $this->data['ml_key']);
				}
			}
		}

		/*
		 * 這個是另外加的
		 */
		foreach($this->data['listcontent'] as $k => $v){
			foreach($v as $kk => $vv){

				// 自動增加建立人的文字欄位
				if($kk == 'from_user_id' and isset($user_tmp[$vv])){
					if(isset($user_tmp[$vv]['name'])){
						$v['from_user_name'] = $user_tmp[$vv]['name'];
					} elseif(isset($user_tmp[$vv]['personal_name'])){
						$v['from_user_name'] = $user_tmp[$vv]['personal_name'];
					}
				}

				// sql4array的bug修正
				if($kk == 'frxm_user_id' and isset($user_tmp[$vv])){
					$v['frxm_user_name'] = $user_tmp[$vv]['name'];
				}
			}
			$this->data['listcontent'][$k] = $v;
		}

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

		// 計算一些分頁不需要處理的變數
		if($this->data['params']['page'] == 1){
			$this->data['pagination']['current_start_record'] = 1;
			$this->data['pagination']['current_end_record'] = count($this->data['listcontent']);
		} else {
			$this->data['pagination']['current_start_record'] = $this->data['params']['page']*$this->data['record'];
			$this->data['pagination']['current_end_record'] = count($this->data['listcontent']) + ($this->data['params']['page']*$this->data['record']);
		}

		// 當啟用搜尋，就停用即時排序和上下排序(2012-11-07的新功能)
		if($this->data['search_keyword'] != ''){
			unset($this->data['def']['sortable']);
			$this->data['sort_field_nobase64'] = '';
		}
	}

	/*
	 */
	public function actionView($param = '')
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
			//if(isset($this->data['def']['empty_orm_data']['rules']) and !empty($this->data['def']['empty_orm_data']['rules'])){
			//	$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules']);
			//}

			if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
				$x = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
			} else {
				$x = new $this->data['def']['orm'];
			}

			if(count($x->getOrmRule()) > 0){
				$validation = G::getJqueryValidation($x->getOrmRule(), $this->data['def']);
			} elseif(isset($this->data['def']['empty_orm_data']['rules']) and count($this->data['def']['empty_orm_data']['rules']) > 0){
				$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules'], $this->data['def']);
			}

			$x = null;

			$updatecontent = $this->db->createCommand()->from($this->data['def']['table'])->where('id=:id', array(':id'=>$this->data['id']))->queryRow();

			/*
			 * 處理特別欄位的地方
			 */

			//$rows = $this->db->createCommand()->from('member')->queryAll();
			//$aaa = new Eob;
			//$user_tmp = $aaa->handle_data_tmp($rows);

			// 自動增加建立人的文字欄位
			//if(isset($updatecontent['from_user_id']) and $updatecontent['from_user_id'] > 0){
			//	if($updatecontent['from_user_id'] == 999999999){
			//		//$updatecontent['from_user_name'] = 'XXX';
			//	} else {
			//		$updatecontent['from_user_name'] = $user_tmp[$updatecontent['from_user_id']]['name'];
			//	}
			//}


            $this->data['updatecontent'] = $updatecontent;
			// 給前台jquery validate元件運作的json資料
            $this->data['jqueryvalidation'] = json_encode($validation);
			// 給rander前台的field，呈現必填的星號部份
            $this->data['updatecontent_jqueryvalidation'] = $validation;

			// 取得數量，用在排序的編號產出
			if(isset($this->data['def']['listfield']['sort_id'])){
				// $c = $this->db->createCommand();
				// $c->from($this->data['def']['table']);
				// // @k active record method
				// // @v array, string 屬性群
				// //foreach($this->data['def']['condition'] as $k => $v){
				// //	$c->{$k}($v[0], $v[1]);
				// //}
				// if(isset($this->data['def']['condition'])){
				// 	$r_condition = G::dbt($this->data['def']['condition'], '$c');
				// 	if($r_condition != ''){
				// 		eval($r_condition);
				// 	}
				// }
				// $query = $this->db->get($this->def['table']);
				// $this->data['class_sort_count'] = count($c->queryAll());

				$this->data['class_sort_count'] = G::dbc($this->data['router_method'], $this->data['def']);
			}

			// 記錄上一頁
			$this->data['prev_url'] = base64url::decode($params['prev']);

			// 帶到前端，讓smarty知道，下一個頁面是自己
			$this->data['update_base64_url'] = $this->data['current_base64_url'];

			// 暫時寫上去的，未完成
			//$this->data['main_content'] = 'default/'.$this->data['router_method'];

			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];

			// 如果view不存在，就不用客氣，直接使用通用版
			if($this->main_content_exists($this->data['main_content'], $this->data) === false){
				$this->data['main_content'] = 'default/update';
				//$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'&param=v'.$this->data['updatecontent']['id'];
			}
			//echo $this->data['main_content'];
			//$this->data['main_content'] = 'adminuser/update';

			$this->view_show_last($updatecontent);

			$this->display('index.htm', $this->data);
		} else {
		}
	}

	/*
	 * 基本款
	 */
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
			//if(isset($this->data['def']['empty_orm_data']['rules']) and !empty($this->data['def']['empty_orm_data']['rules'])){
			//	$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules']);
			//}

			if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
				$x = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
			} else {
				$x = new $this->data['def']['orm'];
			}

			if(count($x->getOrmRule()) > 0){
				$validation = G::getJqueryValidation($x->getOrmRule(), $this->data['def']);
			} elseif(isset($this->data['def']['empty_orm_data']['rules']) and count($this->data['def']['empty_orm_data']['rules']) > 0){
				$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules'], $this->data['def']);
			}

			$x = null;

			$updatecontent = $this->db->createCommand()->from($this->data['def']['table'])->where('id=:id', array(':id'=>$this->data['id']))->queryRow();

			/*
			 * 處理特別欄位的地方
			 */

			//$rows = $this->db->createCommand()->from('member')->queryAll();
			//$aaa = new Eob;
			//$user_tmp = $aaa->handle_data_tmp($rows);

			// 自動增加建立人的文字欄位
			//if(isset($updatecontent['from_user_id']) and $updatecontent['from_user_id'] > 0){
			//	if($updatecontent['from_user_id'] == 999999999){
			//		//$updatecontent['from_user_name'] = 'XXX';
			//	} else {
			//		$updatecontent['from_user_name'] = $user_tmp[$updatecontent['from_user_id']]['name'];
			//	}
			//}

			//$validation = $this->update_validation($validation);

            $this->data['updatecontent'] = $updatecontent;
			// 給前台jquery validate元件運作的json資料
            $this->data['jqueryvalidation'] = json_encode($validation);
			// 給rander前台的field，呈現必填的星號部份
            $this->data['updatecontent_jqueryvalidation'] = $validation;

			// 取得數量，用在排序的編號產出
			if(isset($this->data['def']['listfield']['sort_id'])){
				// $c = $this->db->createCommand();
				// $c->from($this->data['def']['table']);
				// // @k active record method
				// // @v array, string 屬性群
				// //foreach($this->data['def']['condition'] as $k => $v){
				// //	$c->{$k}($v[0], $v[1]);
				// //}
				// if(isset($this->data['def']['condition'])){
				// 	$r_condition = G::dbt($this->data['def']['condition'], '$c');
				// 	if($r_condition != ''){
				// 		eval($r_condition);
				// 	}
				// }
				// $query = $this->db->get($this->def['table']);
				// $this->data['class_sort_count'] = count($c->queryAll());

				$this->data['class_sort_count'] = G::dbc($this->data['router_method'], $this->data['def']);
			}

			// 記錄上一頁
			$this->data['prev_url'] = base64url::decode($params['prev']);

			// 帶到前端，讓smarty知道，下一個頁面是自己
			$this->data['update_base64_url'] = $this->data['current_base64_url'];

			// 暫時寫上去的，未完成
			//$this->data['main_content'] = 'default/'.$this->data['router_method'];

			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];

			// 如果view不存在，就不用客氣，直接使用通用版
			if($this->main_content_exists($this->data['main_content'], $this->data) === false){
				$this->data['main_content'] = 'default/update';
				//$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'&param=v'.$this->data['updatecontent']['id'];
			}
			//echo $this->data['main_content'];
			//$this->data['main_content'] = 'adminuser/update';

			$this->update_show_last($updatecontent);

			$this->display('index.htm', $this->data);
        } else {
			$this->data['def'] = G::definit($this->def, $this->data);

            $id = $_POST['hidden_id'];

			// 讓下面的last函式所使用
			$this->data['id'] = $id;

            $update = $_POST;

			$update = $this->update_run_other_element($update);
			//var_dump($update);
			//die;

			// 為了要支援sort_id改欄位名稱
			$sort_field = 'sort_id';
			if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
				$sort_field = $this->def['func_field']['sort_id'];
			}

			$old_u = $this->db->createCommand()->from($this->data['def']['table'])->where('id=:id',array(':id'=>$id))->queryRow();
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
				/*
				if(isset($this->def['orm']) and $this->def['orm'] != ''){
					// 取得數量，用在排序的編號產出
					foreach($this->def['condition'] as $k => $v){
						$this->db->{$k}($v);
					}
					$query = $this->db->get($this->def['table']);
					$sort_count = $query->num_rows();

				} elseif(isset($this->def['tableg_name']) and $this->def['tableg_name'] != ''){
					$this->load->library('M_tableglib');
					// params: table_name, conditions, where condition, other condition, search, get count,  need count
					$sort_count = $this->m_tableglib->query(
						$this->def['tableg_name'],
						$this->def['condition'],
						'',
						'',
						'',
						'',
						true
					);
				} else {
					echo '[ERROR] get data fail!!!';
					die;
				}
				*/

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
					if(count($this->data['def']['condition']) > 0){
						$fieldsorter->setCondition($this->data['def']['condition']);
					}
					//if(count($this->def['condition']) > 0){
					//	$fieldsorter->setCondition($this->def['condition']);
					//}
					// table_name, field_id, new_sort_id
					//$fieldsorter->go($this->data['def']['table'], $id, $new_sort_id);
					$fieldsorter->go($this->data['def']['table'], $id, $new_sort_id, array(), '', $sort_field); // 為了支援sort_id的脫勾
					if($fieldsorter->getStatus() === false){
						G::m($fieldsorter->getMessage());
					}
				} // new_sort_id
			}

			$redirect_url = $this->data['class_url'];
			if(isset($_POST['prev_url']) && $_POST['prev_url'] != ''){
				$redirect_url = $_POST['prev_url'];
			}

			//$this->load->library('Parameter_handle', '', 'parameter');
			//$parameter = $this->parameter->getDefine();

			$url = base64url::encode($redirect_url);
			//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'update');

			$end_string = '';
			// 這行沒有加，在IE就會看到亂碼
			$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
			$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
			$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
			$end_string .= '<script type="text/javascript">';
			if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0' or 1){ //2016/5/12 經理建議 要直接跳出修改提醒
				//$end_string .= 'alert(l.get("Update success"));';
				$end_string .= 'alert("Update success");';
			}

			//$this->load->library('base64url');
			if(isset($update['update_base64_url']) and $update['update_base64_url'] != ''){
				$url = base64url::decode($update['update_base64_url']);

				// 原有的方式，會導致一重整，就alert一次
				//$url = str_replace('-vsuccess', '', $url);
				//redirect($url.'-vsuccess');

				// 新的方式己修正掉這個問題
				$end_string .= 'window.location.href="'.$url.'";';

				// 為了大陸的pinky而做的暫時性改變 2016/5/12 經理建議 要跳出提醒 , 關閉直接跳頁
				//$this->redirect($url);
			} else {
				// 原有方式
				//$url = $this->base64url->encode($redirect_url);
				//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'update');

				$end_string .= 'window.location.href="'.$redirect_url.'";';

				// 為了大陸的pinky而做的暫時性改變 2016/5/12 經理建議 要跳出提醒 , 關閉直接跳頁
				//$this->redirect($redirect_url);
			}


			$end_string .= '</script>';
			echo $end_string;
			die;
        }
    } // update

	//protected function update_validation($validation){}

	// 基本款update方法的相關方法
	protected function update_show_first($params){}
	protected function update_show_last($updatecontent){}
	//protected function update_run_last(){}
	protected function update_run_last()
	{
		// 儲存後，轉到列表頁 #12645
		$_POST['prev_url'] = $this->createUrl($this->data['router_class'].'/index');
	}
	protected function update_run_other_element($array)
	{
		// 儲存後，轉到列表頁 #12645
		// 或是在update_show_last最末行，加上unset($this->data['update_base64_url'])
		$array['update_base64_url'] = '';

		return $array;
	}

	// 2015-12-09
	// 為了讓單頁也能支援圖片上傳，試著寫寫看
	//2016/5/26 lota fix 單張圖片上傳加入&& $update[$image_fieldname]!='' 使其刪除有作用
	protected function update_run_pic($update, $old_u , $lid = 0)
	{
		
		//2016/5/13 lota 加入單頁單張單獨copy for 進豐
		if($lid!=0){

			$image_fieldname = 'pic_'.$lid;

			//if(!isset($update[$image_fieldname]) or $update[$image_fieldname] == '') continue; //會報錯，改用935 加入判斷  $update[$image_fieldname]!=''

			if($update[$image_fieldname] != $old_u['pic1'] && $update[$image_fieldname]!=''){
				$copy_source = $this->data['image_upload_tmp_path'].'/'.$update[$image_fieldname];
				if(file_exists($copy_source)){
					// 自訂路徑修正
					if(isset($this->data['def']['pic_upload_path']) and $this->data['def']['pic_upload_path'] != ''){
						$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['def']['pic_upload_path'];
					} else {
						$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['router_class'];
					}
					if(!file_exists($copy_dest_dir)){
						// 自訂路徑修正2，複製
						//$pic_dir_need_copy_other = '1';
						if(!mkdir($copy_dest_dir, 0777, true)){
							G::m($this->_getLabel('mkdir dest dir fail'));
						}
					}
					$copy_dest = $copy_dest_dir.'/'.$update[$image_fieldname];
					if(!copy($copy_source, $copy_dest)){
						G::m($this->_getLabel('copy image to upload directory fail'));
					}
					if(!unlink($copy_source)){
						G::m($this->_getLabel('delete image tmp fail'));
					}
				}
			}
		}
		


		// 檢查是否圖片有異動，有的話就把tmp裡面的圖片拉到正式的圖片資料夾裡面
		//$pic_dir_need_copy_other = '';
		for($x=1;$x<=10;$x++){
			$image_fieldname = 'pic'.$x;
			if(!isset($update[$image_fieldname]) or $update[$image_fieldname] == '') continue;
			if($update[$image_fieldname] != $old_u[$image_fieldname]){
				$copy_source = $this->data['image_upload_tmp_path'].'/'.$update[$image_fieldname];
				if(file_exists($copy_source)){
					// 自訂路徑修正
					if(isset($this->data['def']['pic_upload_path']) and $this->data['def']['pic_upload_path'] != ''){
						$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['def']['pic_upload_path'];
					} else {
						$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['router_class'];
					}
					if(!file_exists($copy_dest_dir)){
						// 自訂路徑修正2，複製
						//$pic_dir_need_copy_other = '1';
						if(!mkdir($copy_dest_dir, 0777, true)){
							G::m($this->_getLabel('mkdir dest dir fail'));
						}
					}
					$copy_dest = $copy_dest_dir.'/'.$update[$image_fieldname];
					if(!copy($copy_source, $copy_dest)){
						G::m($this->_getLabel('copy image to upload directory fail'));
					}
					if(!unlink($copy_source)){
						G::m($this->_getLabel('delete image tmp fail'));
					}
				}
			}
		}
		// 自訂路徑修正3,final
		//if($pic_dir_need_copy_other == '1' and isset($this->def['pic_upload_path']) and $this->def['pic_upload_path'] != ''){
		//	if(file_exists(image_upload_path.ds('/').$this->data['router_class'])){
		//		$copy_source_tmp = image_upload_path.ds('/').$this->data['router_class'].'/*';
		//		$copy_dest_tmp =image_upload_path.ds('/').$this->def['pic_upload_path'].ds('/');
		//		if(!copy($copy_source_tmp, $copy_dest_tmp)){
		//			show_error($this->_getLabel('patch, copy image to upload directory fail'));
		//		}
		//	}
		//}

		// 檢查一般文件以及檔案的欄位是否有異動
		//$file_dir_need_copy_other = '';
		for($x=1;$x<=10;$x++){
			$image_fieldname = 'file'.$x;
			if(!isset($update[$image_fieldname]) or $update[$image_fieldname] == '') continue;
			if($update[$image_fieldname] != $old_u[$image_fieldname]){
				$copy_source = $this->data['file_upload_tmp_path'].'/'.$update[$image_fieldname];
				if(file_exists($copy_source)){
					// 自訂路徑修正
					if(isset($this->data['def']['file_upload_path']) and $this->data['def']['file_upload_path'] != ''){
						$copy_dest_dir = $this->data['file_upload_path'].'/'.$this->data['def']['file_upload_path'];
					} else {
						$copy_dest_dir = $this->data['file_upload_path'].'/'.$this->data['router_class'];
					}
					// 自訂路徑修正2，複製
					if(!file_exists($copy_dest_dir)){
						// 自訂路徑修正2，複製
						//$file_dir_need_copy_other = '1';
						if(!mkdir($copy_dest_dir, 0777, true)){
							G::m($this->_getLabel('mkdir dest dir fail'));
						}
					}
					$copy_dest = $copy_dest_dir.'/'.$update[$image_fieldname];
					if(!copy($copy_source, $copy_dest)){
						G::m($this->_getLabel('copy file to upload directory fail'));
					}
					if(!unlink($copy_source)){
						G::m($this->_getLabel('delete file tmp fail'));
					}
				}
			}
		}
		// 自訂路徑修正3,final
		//if($file_dir_need_copy_other == '1' and isset($this->def['file_upload_path']) and $this->def['file_upload_path'] != ''){
		//	if(file_exists(file_upload_path.ds('/').$this->data['router_class'])){
		//		$copy_source_tmp = file_upload_path.ds('/').$this->data['router_class'].'/*';
		//		$copy_dest_tmp = file_upload_path.ds('/').$this->def['file_upload_path'].ds('/');
		//		if(!copy($copy_source_tmp, $copy_dest_tmp)){
		//			show_error($this->_getLabel('patch, copy file to upload directory fail'));
		//		}
		//	}
		//}

		/*
		 * 多影片選擇
		 *  ["youtubes"]=>
		 *  array(1) {
		 *    ["productvideo"]=>
		 *    array(1) {
		 *      [0]=>
		 *      string(38) "hdv,6f8a1a70c8b9e036a1f3968bae4bb3a5,21"
		 *    }
		 *  }
		 *  ["youtubes_attr"]=>
		 *  array(1) {
		 *    ["productvideo"]=>
		 *    array(1) {
		 *      ["ishome"]=>
		 *      array(1) {
		 *        [0]=>
		 *        string(1) "1"
		 *      }
		 *    }
		 *  }
		 *
		 * 'multiyoutube_upload' => array(
		 * 	'exhibitionvideo' => array(
		 * 		'table' => 'exhibition_video',
		 * 		'relation_field_name' => 'exhibition_id',
		 * 		'pic_field_name' => 'pic',
		 * 		'store_dir_name' => 'exhibition_video',
		 * 	),
		 * ),
		 *
		 * array(2) {
		 *   ["file"]=>
		 *   array(5) {
		 *     ["name"]=>
		 *     string(0) ""
		 *     ["type"]=>
		 *     string(0) ""
		 *     ["tmp_name"]=>
		 *     string(0) ""
		 *     ["error"]=>
		 *     int(4)
		 *     ["size"]=>
		 *     int(0)
		 *   }
		 *   ["youtubes_fileattr_exhibitionvideo_thumb"]=>
		 *   array(5) {
		 *     ["name"]=>
		 *     string(7) "aaa.jpg"
		 *     ["type"]=>
		 *     string(10) "image/jpeg"
		 *     ["tmp_name"]=>
		 *     string(14) "/tmp/php2dTw6O"
		 *     ["error"]=>
		 *     int(0)
		 *     ["size"]=>
		 *     int(448643)
		 *   }
		 * }
		 */
		if(isset($this->data['def']['multiyoutube_upload']) and count($this->data['def']['multiyoutube_upload']) > 0){
			//var_dump($update['youtubes_attr']);
			$update_productpic = array();
			// @k 設定名稱
			// @v 屬性群
			foreach($this->data['def']['multiyoutube_upload'] as $k => $v){
				// 處理前，先把原有的東西洗掉，只有修改會做這個動作
				$this->cidb->where($this->data['def']['multiyoutube_upload'][$k]['relation_field_name'], $id)->delete($this->data['def']['multiyoutube_upload'][$k]['table']);

				// 排序的編號
				$sort_id_num = 1;

				// 如果有需要上傳檔案，那就上傳吧
				if(isset($_FILES) and count($_FILES) > 0){
					foreach($_FILES as $kk => $vv){
						if(preg_match('/^youtubes_fileattr_'.$k.'_(.*)/', $kk, $matches) and $_FILES[$kk]['size'] > 0){
							/*
							 * 將暫存檔複製到存放圖片的路徑
							 */
							$copy_source = $_FILES[$kk]['tmp_name'];
							// 有些檔案是本來就存在的，所以有可能暫存檔是不存在的，不存在就跳過這次複製動作
							if(file_exists($copy_source)){
								$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['def']['multiyoutube_upload'][$k]['store_dir_name'];
								if(!file_exists($copy_dest_dir)){
									if(!mkdir($copy_dest_dir, 0777, true)){
										G::m($this->_getLabel('mkdir dest dir fail'));
									}
								}
								$copy_dest = $copy_dest_dir.'/'.$_FILES[$kk]['name'];
								if(!copy($copy_source, $copy_dest)){
									G::m($this->_getLabel('copy image to upload directory fail'));
								}
								if(!unlink($copy_source)){
									G::m($this->_getLabel('delete image tmp fail'));
								}
								$update['youtubes_fileattr'][$k][$matches[1]] = $_FILES[$kk]['name'];
							}
						}
					}
				}
				
				// 如果有資料，那就準備要寫入了
				//var_dump($update);
				//die;
				/*
				 * update['youtubes']
				 * array(1) {
				 *   ["exhibitionvideo"]=>
				 *   array(2) {
				 *     ["u0"]=>
				 *     string(25) "ckeditor,exhibition_video"
				 *     ["u1"]=>
				 *     string(19) "youtube,3lKwkn6JT74"
				 *   }
				 * }
				 */
				if(isset($update['youtubes'][$k]) and count($update['youtubes'][$k]) > 0){
					foreach($update['youtubes'][$k] as $kk => $vv){
						$productpic = array(
							$this->data['def']['multiyoutube_upload'][$k]['relation_field_name'] => $id,
							$this->data['def']['multiyoutube_upload'][$k]['pic_field_name'] => $vv,
							'sort_id' => $sort_id_num,
							'create_time' => date('Y-m-d H:i:s'),
						);
						$sort_id_num++;

						// 讀取額外的屬性與值
						if(isset($update['youtubes_attr'][$k]) and count($update['youtubes_attr'][$k]) > 0){
							foreach($update['youtubes_attr'][$k] as $kkk => $vvv){
							   	//$productpic[$kkk] = $vvv[$kk];
								if(isset($vvv[$kk])){
								   	$productpic[$kkk] = $vvv[$kk];
								} else {
								   	$productpic[$kkk] = '';
								}
							}
						}
						// 讀取上傳後額外的屬性值
						if(isset($update['youtubes_fileattr'][$k]) and count($update['youtubes_fileattr'][$k]) > 0){
							foreach($update['youtubes_fileattr'][$k] as $kkk => $vvv){
								$productpic[$kkk] = $vvv;
							}
						}

						//$copy_source = image_upload_tmp_path.'/'.$vv;
						// 有些檔案是本來就存在的，所以有可能暫存檔是不存在的，不存在就跳過這次複製動作
						//if(file_exists($copy_source)){
						//	$copy_dest_dir = image_upload_path.'/'.$this->def['multiyoutube_upload'][$k]['store_dir_name'];
						//	if(!file_exists($copy_dest_dir)){
						//		if(!mkdir($copy_dest_dir, 0777, true)){
						//			show_error($this->_getLabel('mkdir dest dir fail'));
						//		}
						//	}
						//	$copy_dest = $copy_dest_dir.'/'.$vv;
						//	if(!copy($copy_source, $copy_dest)){
						//		show_error($this->_getLabel('copy image to upload directory fail'));
						//	}
						//	if(!unlink($copy_source)){
						//		show_error($this->_getLabel('delete image tmp fail'));
						//	}
						//}
						$update_productpic[] = $productpic;
					}
					$this->cidb->insert_batch($this->data['def']['multiyoutube_upload'][$k]['table'], $update_productpic);
				}
			}
		} // 檢查是否有啟用多個影片選擇的功能

		/*
		 * 多圖片檔上傳區塊
		 *  ["uploads"]=>
		 *  array(1) {
		 *    ["productpic"]=>
		 *    array(1) {
		 *      [0]=>
		 *      string(38) "e109dc9a3d6b69279a8812782d490f2133.jpg"
		 *    }
		 *  }
		 *  ["uploads_attr"]=>
		 *  array(1) {
		 *    ["productpic"]=>
		 *    array(1) {
		 *      ["ishome"]=>
		 *      array(1) {
		 *        [0]=>
		 *        string(1) "1"
		 *      }
		 *    }
		 *  }
		 */
		if(isset($this->data['def']['multifile_upload']) and count($this->data['def']['multifile_upload']) > 0){
			$update_productpic = array();
			// @k 設定名稱
			// @v 屬性群
			foreach($this->data['def']['multifile_upload'] as $k => $v){

				// 處理前，先把原有的東西洗掉，只有修改會做這個動作
				$this->cidb->where($this->data['def']['multifile_upload'][$k]['relation_field_name'], $id)->delete($this->data['def']['multifile_upload'][$k]['table']);

				// 排序的編號
				$sort_id_num = 1;
				
				// 如果有資料，那就準備要寫入了
				if(isset($update['uploads'][$k]) and count($update['uploads'][$k]) > 0){
					foreach($update['uploads'][$k] as $kk => $vv){
						$productpic = array(
							$this->data['def']['multifile_upload'][$k]['relation_field_name'] => $id,
							$this->data['def']['multifile_upload'][$k]['pic_field_name'] => $vv,
							'sort_id' => $sort_id_num,
							'create_time' => date('Y-m-d H:i:s'),
						);
						$sort_id_num++;

						// 讀取額外的屬性與值
						if(isset($update['uploads_attr'][$k]) and count($update['uploads_attr'][$k])){
							foreach($update['uploads_attr'][$k] as $kkk => $vvv){
								$productpic[$kkk] = $vvv[$kk];
							}
						}

						//var_dump($productpic);
						//die;

						$copy_source = $this->data['image_upload_tmp_path'].'/'.$vv;
						// 有些檔案是本來就存在的，所以有可能暫存檔是不存在的，不存在就跳過這次複製動作
						if(file_exists($copy_source)){
							$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['def']['multifile_upload'][$k]['store_dir_name'];
							if(!file_exists($copy_dest_dir)){
								if(!mkdir($copy_dest_dir, 0777, true)){
									G::m($this->_getLabel('mkdir dest dir fail'));
								}
							}
							$copy_dest = $copy_dest_dir.'/'.$vv;
							if(!copy($copy_source, $copy_dest)){
								G::m($this->_getLabel('copy image to upload directory fail'));
							}
							if(!unlink($copy_source)){
								G::m($this->_getLabel('delete image tmp fail'));
							}
						}
						$update_productpic[] = $productpic;
					}
					$this->cidb->insert_batch($this->data['def']['multifile_upload'][$k]['table'], $update_productpic);
					$update_productpic = array();
				}
			}
		} // 檢查是否有啟用多檔上傳的功能

		return $update;
	}

	protected function view_show_first($params){}
	protected function view_show_last($updatecontent)
	{
		$this->data['def']['updatefield']['method'] = 'update';
		$this->data['router_method_view'] = '1';

		// 把所有的input都改成label_id，也就是不能修改
		// 這一段，是最主要跟update不一樣的地方(多的)
		if(isset($this->data['def']['updatefield']['sections'])){
			// @k sections_id
			foreach($this->data['def']['updatefield']['sections'] as $k => $v){
				if(isset($v['field'])){
					// @kk 欄位key
					// @vv 欄位屬性群
					foreach($v['field'] as $kk => $vv){
						if(!isset($vv['type'])) continue;
						//if(!isset($this->data['updatecontent'][$kk])) continue;
						if(!isset($this->data['updatecontent'][$kk])){
							$this->data['updatecontent'][$kk] = '';
						}
						if($vv['type'] == 'select3'){
							//if(!isset($this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['values'])){
							//	continue;
							//}
							$tmpx = $this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['values'];
							$tmpy = '';
							if(isset($tmpx[$this->data['updatecontent'][$kk]])){
								$tmpy = $tmpx[$this->data['updatecontent'][$kk]];
							}
							if($tmpy == ''){
								$tmpy = $this->data['updatecontent'][$kk];
							}
							// 文字才會直接顯示
							if(is_numeric($tmpy)){
								$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'label';
								$this->data['updatecontent'][$kk] = '';
								continue;
							}
							if(preg_match('/^請/', $tmpy)){
								$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'label';
								$this->data['updatecontent'][$kk] = '';
								continue;
							}
							if($tmpy != ''){
								$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'label';
								$this->data['updatecontent'][$kk] = $tmpy;
							}
						} elseif($vv['type'] == 'fileuploader'){
							if($vv['other']['type'] == 'document'){
								$tmp01 = explode('.', $updatecontent[$kk]);
								$tmp02 = $tmp01[count($tmp01)-1]; // 副檔名

								// 這行是參考用的
								// $allowedExtensions = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'csv', 'wmv', 'mpg', 'mp4', 'avi', 'mov', 'zip', 'pptx', 'ppt', 'pdf', 'rar', 'ai', 'tif', 'tiff', 'igs', 'dxf', 'jpg', 'jpeg', 'png', 'gif', 'stp');

								if(preg_match('/^(wmv|mpg|mp4|avi|mov)$/', $tmp02)){
									$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'video_html5';
								} else {
									$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'inputn';
									if($this->data['updatecontent'][$kk] != ''){
										$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['html'] = '<a href="'.$this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$this->data['updatecontent'][$kk].'" target="_blank">檔案下載</a>';
									} else {
										$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['html'] = '';
									}
								}
							} elseif($vv['other']['type'] == 'photo'){
								$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'inputn';
								if($this->data['updatecontent'][$kk] != ''){
									$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['html'] = '<img width="300" src="'.$this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$this->data['updatecontent'][$kk].'" />';
								} else {
									$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['html'] = '';
								}
							} else {
							}
						} elseif($vv['type'] == 'sort'){
							unset($this->data['def']['updatefield']['sections'][$k]['field'][$kk]);
						} elseif($vv['type'] == 'kcfinder_school'){
							// 這行是參考
							// $this->data['def']['updatefield']['sections'][1]['field']['kc01']['other']['school_id'] = $this->data['updatecontent']['id'];

							// 讀取該客戶的所有檔案並輸出
							// _i/assets/members/1/member
							$tmp01 = $this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['school_id'];
							$path = 'webroot.assets.members.'.$tmp01.'.member';
							$files_content = '';
							if(file_exists(Yii::getPathOfAlias($path))){
								$tmp = $this->_getFiles(Yii::getPathOfAlias($path));
								if($tmp){
									foreach($tmp as $k => $v){
										$tmp2 = explode('/', $v);
										$tmp3 = $tmp2[count($tmp2)-1];
										$files_content .= '<a target="_blank" href="assets/members/'.$tmp01.'/member/'.$tmp3.'">'.$tmp3.'</a><br />';
									}
								}
							}
							$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'inputn';
							$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['html'] = $files_content;
						} elseif($vv['type'] == 'status'){
							/*
							'other' => array(
								'other1' => 'Email',
								'other2' => '郵寄',
								'default' => '1',
							),
							 */
							//if(!isset($this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other'])){
							//	continue;
							//}
							$tmpx = $this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other'];
							$tmpy = '';

							if(!isset($tmpx['other1'])){
								$tmpx['other1'] = '顯示';
							}

							if(!isset($tmpx['other2'])){
								$tmpx['other2'] = '隱藏';
							}

							if($this->data['updatecontent'][$kk] == 1){
								$tmpy = $tmpx['other1'];
							} elseif($this->data['updatecontent'][$kk] == 0){
								$tmpy = $tmpx['other2'];
							}

							if($tmpy == ''){
								$tmpy = $this->data['updatecontent'][$kk];
							}
							if($tmpy != ''){
								$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'label';
								$this->data['updatecontent'][$kk] = $tmpy;
							}
						} elseif($vv['type'] == 'hidden'){
						} elseif($vv['type'] == 'input_additional'){
							//continue;
							$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'label';

							// 
							$rowsx = $this->db->createCommand()->from('additional')->where('is_enable=1 and data_id=:id and type=:type', array('id'=>$updatecontent['id'], 'type'=>$vv['other']['type']))->queryAll();
							if($rowsx){
								$data_string = '';
								foreach($rowsx as $kkk => $vvv){
									if($vvv['keyval'] == ''){
										continue;
									}
									if($vvv['keyname'] != ''){
										$data_string .= '['.$vvv['keyname'].']: ';
									}
									$data_string .= $vvv['keyval'].', ';
								}
								if($this->data['updatecontent'][$kk] != ''){
									$data_string = ', '.$data_string;
								}
								$this->data['updatecontent'][$kk] .= $data_string;
							}
						} else {
							$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['type'] = 'label';
						}

						// 如果發現有陣列，就不要讓它出現(不然會出現Array的字眼)，順便把這個欄位拿掉
						if(is_array($this->data['updatecontent'][$kk])){
							$this->data['updatecontent'][$kk] = '';
							//unset($this->data['def']['updatefield']['sections'][$k]['field'][$kk]);
						}
					} // foreach kk
				} // isset
			}
		}
	}

	/*
	 * 基本款
	 */
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

			/*
			 * 處理預設值
			 */

			// 先搜尋，後新增的使用者行為
			if(isset($this->data['search_keyword']) and $this->data['search_keyword'] != ''){
				if(isset($this->data['def']['search_keyword_assign_field']) and !is_array($this->data['def']['search_keyword_assign_field']) and $this->data['def']['search_keyword_assign_field'] != ''){
					$this->data['updatecontent'][$this->data['def']['search_keyword_assign_field']] = $this->data['search_keyword'];
				}

				// 如果要帶入多個欄位的話
				if(isset($this->data['def']['search_keyword_assign_field']) and is_array($this->data['def']['search_keyword_assign_field']) and count($this->data['def']['search_keyword_assign_field']) > 0){
					//var_dump($this->def['search_keyword_assign_field']);
					foreach($this->data['def']['search_keyword_assign_field'] as $k => $v){
						$this->data['updatecontent'][$k] = $this->data['search_keyword'];
					}
				}
			}

			$this->create_show_first($params);

			//if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
			//	$u = new $this->data['def']['orm'](NULL, $this->data['def']['empty_orm_data']);
			//} else {
			//	$u = new $this->data['def']['orm']();
			//}
            //$validation = $u->getJqueryValidation();

			$validation = array();
			//if(isset($this->data['def']['empty_orm_data']['rules']) and !empty($this->data['def']['empty_orm_data']['rules'])){
			//	$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules']);
			//}
			if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
				$x = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
			} else {
				$x = new $this->data['def']['orm'];
			}

			if(count($x->getOrmRule()) > 0){
				$validation = G::getJqueryValidation($x->getOrmRule(), $this->data['def']);
			} elseif(isset($this->data['def']['empty_orm_data']['rules']) and count($this->data['def']['empty_orm_data']['rules']) > 0){
				$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules'], $this->data['def']);
			}

            $this->data['jqueryvalidation'] = json_encode($validation);

			// 給rander前台的field，呈現必填的星號部份
            $this->data['updatecontent_jqueryvalidation'] = $validation;

			// 記錄上一頁
			$this->data['prev_url'] = base64url::decode($params['prev']);

			// 帶到前端，讓smarty知道，下一個頁面是自己
			$this->data['update_base64_url'] = $this->data['current_base64_url'];

			// 取得數量，用在排序的編號產出
			//if(isset($this->def['listfield']['sort_id']) and isset($this->def['condition']) and count($this->def['condition']) > 0){
			//	foreach($this->def['condition'] as $k => $v){
			//		$this->db->{$k}($v);
			//	}
			//	$query = $this->db->get($this->def['table']);
			//	// 因為是新增，所以增加一筆
			//	$this->data['class_sort_count'] = $query->num_rows() + 1;
			//}

			// 取得數量，用在排序的編號產出
			//if(isset($this->data['def']['listfield']['sort_id']) and isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
			//	$c = $this->db->createCommand();
			//	$c->from($this->data['def']['table']);
			//	// @k active record method
			//	// @v array, string 屬性群
			//	foreach($this->data['def']['condition'] as $k => $v){
			//		$c->{$k}($v[0], $v[1]);
			//	}
			//	$query = $this->db->get($this->def['table']);
			//	// 因為是新增，所以增加一筆
			//	$this->data['class_sort_count'] = count($c->queryAll()) + 1;
			//}
			$this->data['class_sort_count'] = G::dbc($this->data['router_method'], $this->data['def']);

			//echo $this->data['main_content'];
			//die;
			// 如果view不存在，就不用客氣，直接使用通用版
			if($this->main_content_exists($this->data['main_content'], $this->data) === false){
				$this->data['main_content'] = 'default/update';
				$this->data['def']['updatefield']['method'] = 'create';
				$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
			}

			$this->create_show_last();

			$this->display('index.htm', $this->data);
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
			//var_dump($savedata);
			//die;

			//if(isset($this->def['empty_orm_data']) and count($this->def['empty_orm_data']) > 0){
			//	$u = new $this->def['orm'](NULL, $this->def['empty_orm_data']);
			//} else {
			//	$u = new $this->def['orm']();
			//}

			// 取得數量，用在排序的編號產出
			//if(isset($this->def['condition']) and count($this->def['condition']) > 0){
			//	foreach($this->def['condition'] as $k => $v){
			//		$this->db->{$k}($v);
			//	}
			//}
			//$query = $this->db->get($this->def['table']);
			//$sort_count = $query->num_rows();
			//$savedata['sort_id'] = $sort_count + 1;
			//var_dump($this->data['def']);
			//die;
			$savedata[$sort_field] = G::dbc($this->data['router_method'], $this->data['def']);

			$savedata = $this->create_run_pic($savedata);

			// 虛擬資料表處理
			//if(isset($this->def['tableg_name']) and $this->def['tableg_name'] != '' and isset($this->def['table']) and $this->db->field_exists('field_data', $this->def['table'])){
			//	$this->load->library('M_tableglib');
			//	$savedata = $this->m_tableglib->fifw($this->def['tableg_name'], $savedata);
			//}

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

            //$u->from_array($savedata);

            //// save自己會做validate
            //if(!$u->save()){
			//	G::m($u->error->string);
            //}

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

			$redirect_url = $this->data['class_url'];
			if($_POST['prev_url'] != ''){
				$redirect_url = $_POST['prev_url'];
			}

			$end_string = '';
			// 這行沒有加，在IE就會看到亂碼
			$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
			$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
			$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
			$end_string .= '<script type="text/javascript">';
			if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0'){
				$end_string .= 'alert(l.get("Create success"));';
			}
			if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0'){
				$end_string .= 'alert(l.get("Create success"));';
			}
			$end_string .= 'window.location.href="'.$redirect_url.'";';

			// 為了大陸的pinky而做的暫時性改變
			$this->redirect($redirect_url);

			$end_string .= '</script>';
			echo $end_string;

        }
    } // create

	// 
	protected function create_show_first($params){}
	protected function create_show_last(){}
	protected function create_run_last(){}
	protected function create_run_other_element($array)
	{
		return $array;
	}

	// 2015-12-09
	// 為了讓單頁也能支援圖片上傳，試著寫寫看
	protected function create_run_pic($savedata)
	{
		// 把tmp裡面的圖片拉到正式的圖片資料夾裡面
		for($x=1;$x<=10;$x++){
			$image_fieldname = 'pic'.$x;
			if(!isset($savedata[$image_fieldname]) or $savedata[$image_fieldname] == '') continue;
			if($savedata[$image_fieldname] != ''){
				$copy_source = $this->data['image_upload_tmp_path'].'/'.$savedata[$image_fieldname];
				if(file_exists($copy_source)){
					// 自訂路徑修正
					if(isset($this->data['def']['pic_upload_path']) and $this->data['def']['pic_upload_path'] != ''){
						$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['def']['pic_upload_path'];
					} else {
						$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['router_class'];
					}
					if(!file_exists($copy_dest_dir)){
						if(!mkdir($copy_dest_dir, 0777, true)){
							G::m($this->_getLabel('mkdir dest dir fail'));
						}
					}
					$copy_dest = $copy_dest_dir.'/'.$savedata[$image_fieldname];
					if(!copy($copy_source, $copy_dest)){
						G::m($this->_getLabel('copy image to upload directory fail'));
					}
					if(!unlink($copy_source)){
						G::m($this->_getLabel('delete image tmp fail'));
					}
				}
			}
		}

		for($x=1;$x<=10;$x++){
			$image_fieldname = 'file'.$x;
			if(!isset($savedata[$image_fieldname]) or $savedata[$image_fieldname] == '') continue;
			if($savedata[$image_fieldname] != ''){
				$copy_source = $this->data['file_upload_tmp_path'].'/'.$savedata[$image_fieldname];
				if(file_exists($copy_source)){
					//$copy_dest_dir = file_upload_path.'/'.$this->data['router_class'];
					// 自訂路徑修正
					if(isset($this->data['def']['file_upload_path']) and $this->data['def']['file_upload_path'] != ''){
						$copy_dest_dir = $this->data['file_upload_path'].'/'.$this->data['def']['file_upload_path'];
					} else {
						$copy_dest_dir = $this->data['file_upload_path'].'/'.$this->data['router_class'];
					}
					if(!file_exists($copy_dest_dir)){
						if(!mkdir($copy_dest_dir, 0777, true)){
							G::m($this->_getLabel('mkdir dest dir fail'));
						}
					}
					$copy_dest = $copy_dest_dir.'/'.$savedata[$image_fieldname];
					if(!copy($copy_source, $copy_dest)){
						G::m($this->_getLabel('copy file to upload directory fail'));
					}
					if(!unlink($copy_source)){
						G::m($this->_getLabel('delete file tmp fail'));
					}
				}
			}
		}

		/*
		 * 多影片建立區塊
		 *  ["uploads"]=>
		 *  array(1) {
		 *    ["productpic"]=>
		 *    array(1) {
		 *      [0]=>
		 *      string(38) "e109dc9a3d6b69279a8812782d490f2133.jpg"
		 *    }
		 *  }
		 *  ["uploads_attr"]=>
		 *  array(1) {
		 *    ["productpic"]=>
		 *    array(1) {
		 *      ["ishome"]=>
		 *      array(1) {
		 *        [0]=>
		 *        string(1) "1"
		 *      }
		 *    }
		 *  }
		 */
		if(isset($savedata['youtubes']) and count($savedata['youtubes']) > 0){
			$savedata_productpic = array();
			if(isset($this->data['def']['multiyoutube_upload']) and count($this->data['def']['multiyoutube_upload']) > 0){
				// @k 設定名稱
				// @v 屬性群
				foreach($this->data['def']['multiyoutube_upload'] as $k => $v){

					// 排序的編號
					$sort_id_num = 1;

					// 如果有需要上傳檔案，那就上傳吧
					if(isset($_FILES) and count($_FILES) > 0){
						foreach($_FILES as $kk => $vv){
							if(preg_match('/^youtubes_fileattr_'.$k.'_(.*)/', $kk, $matches) and $_FILES[$kk]['size'] > 0){
								/*
								 * 將暫存檔複製到存放圖片的路徑
								 */
								$copy_source = $_FILES[$kk]['tmp_name'];
								// 有些檔案是本來就存在的，所以有可能暫存檔是不存在的，不存在就跳過這次複製動作
								if(file_exists($copy_source)){
									$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['def']['multiyoutube_upload'][$k]['store_dir_name'];
									if(!file_exists($copy_dest_dir)){
										if(!mkdir($copy_dest_dir, 0777, true)){
											G::m($this->_getLabel('mkdir dest dir fail'));
										}
									}
									$copy_dest = $copy_dest_dir.'/'.$_FILES[$kk]['name'];
									if(!copy($copy_source, $copy_dest)){
										G::m($this->_getLabel('copy image to upload directory fail'));
									}
									if(!unlink($copy_source)){
										G::m($this->_getLabel('delete image tmp fail'));
									}
									$savedata['youtubes_fileattr'][$k][$matches[1]] = $_FILES[$kk]['name'];
								}
							}
						}
					}

					// 如果有資料，那就準備要寫入了
					if(isset($savedata['youtubes'][$k]) and count($savedata['youtubes'][$k]) > 0){
						foreach($savedata['youtubes'][$k] as $kk => $vv){
							$productpic = array(
								$this->data['def']['multiyoutube_upload'][$k]['relation_field_name'] => $id,
								$this->data['def']['multiyoutube_upload'][$k]['pic_field_name'] => $vv,
								'sort_id' => $sort_id_num,
								'create_time' => date('Y-m-d H:i:s'),
							);
							$sort_id_num++;
							// 讀取額外的屬性與值
							if(isset($savedata['youtubes_attr'][$k]) and count($savedata['youtubes_attr'][$k])){
								foreach($savedata['youtubes_attr'][$k] as $kkk => $vvv){
									$productpic[$kkk] = $vvv[$kk];
								}
							}

							$savedata_productpic[] = $productpic;
						}
						$this->cidb->insert_batch($this->data['def']['multiyoutube_upload'][$k]['table'], $savedata_productpic);
					}
				}
			} // 檢查是否有啟用多檔上傳的功能
		} // 檢查post資料是否有多檔上傳的資料

		/*
		 * 多檔上傳區塊
		 *  ["uploads"]=>
		 *  array(1) {
		 *    ["productpic"]=>
		 *    array(1) {
		 *      [0]=>
		 *      string(38) "e109dc9a3d6b69279a8812782d490f2133.jpg"
		 *    }
		 *  }
		 *  ["uploads_attr"]=>
		 *  array(1) {
		 *    ["productpic"]=>
		 *    array(1) {
		 *      ["ishome"]=>
		 *      array(1) {
		 *        [0]=>
		 *        string(1) "1"
		 *      }
		 *    }
		 *  }
		 */
		if(isset($savedata['uploads']) and count($savedata['uploads']) > 0){
			$savedata_productpic = array();
			if(isset($this->data['def']['multifile_upload']) and count($this->data['def']['multifile_upload']) > 0){
				// @k 設定名稱
				// @v 屬性群
				foreach($this->data['def']['multifile_upload'] as $k => $v){

					// 排序的編號
					$sort_id_num = 1;

					// 如果有資料，那就準備要寫入了
					if(isset($savedata['uploads'][$k]) and count($savedata['uploads'][$k]) > 0){
						foreach($savedata['uploads'][$k] as $kk => $vv){
							$productpic = array(
								$this->data['def']['multifile_upload'][$k]['relation_field_name'] => $id,
								$this->data['def']['multifile_upload'][$k]['pic_field_name'] => $vv,
								'sort_id' => $sort_id_num,
								'create_time' => date('Y-m-d H:i:s'),
							);
							$sort_id_num++;
							// 讀取額外的屬性與值
							if(isset($savedata['uploads_attr'][$k]) and count($savedata['uploads_attr'][$k])){
								foreach($savedata['uploads_attr'][$k] as $kkk => $vvv){
									$productpic[$kkk] = $vvv[$kk];
								}
							}

							//var_dump($productpic);
							//die;

							$copy_source = $this->data['image_upload_tmp_path'].'/'.$vv;
							$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['def']['multifile_upload'][$k]['store_dir_name'];
							if(!file_exists($copy_dest_dir)){
								if(!mkdir($copy_dest_dir, 0777, true)){
									G::m($this->_getLabel('mkdir dest dir fail'));
								}
							}
							$copy_dest = $copy_dest_dir.'/'.$vv;
							if(!copy($copy_source, $copy_dest)){
								G::m($this->_getLabel('copy image to upload directory fail'));
							}
							if(!unlink($copy_source)){
								G::m($this->_getLabel('delete image tmp fail'));
							}
							$savedata_productpic[] = $productpic;
						}
						$this->cidb->insert_batch($this->data['def']['multifile_upload'][$k]['table'], $savedata_productpic);
					}
				}
			} // 檢查是否有啟用多檔上傳的功能
		} // 檢查post資料是否有多檔上傳的資料

		return $savedata;
	}

	/*
	 * 基本款
	 */
	public function actionDelete($param = '')
    {
		$parameter = new Parameter_handle;
		$params = $parameter->get($param);

		$this->data['def'] = G::definit($this->def, $this->data);

		if(!isset($params['value'][0])){
			$msg = $this->_getLabel('no id');
			G::m($msg);
		}
		$id = $params['value'][0];

		// 為了要支援sort_id改欄位名稱
		$sort_field = 'sort_id';
		if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
			$sort_field = $this->def['func_field']['sort_id'];
		}

		//if(isset($this->def['empty_orm_data']) and count($this->def['empty_orm_data']) > 0){
		//	$u = new $this->def['orm'](NULL, $this->def['empty_orm_data']);
		//} else {
		//	$u = new $this->def['orm']();
		//}
        //$u->get_by_id($id);

		// $exists=Post::model()->exists($condition,$params);
		//$c = new Empty_orm('insert', $this->data['def']['empty_orm_data']);
		if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
			$c = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
		} else {
			$c = new $this->data['def']['orm'];
		}
		$s = $c::model()->findByPk($id);
		$u = $c::model()->exists('id=:id',array(':id'=>$id));
		//echo $id;
		//var_dump($c::model()->exists('id=:id',array(':id'=>$id)));
		//die;

        if($u){
			// 為了要回去上一頁
			$prev_url = base64url::decode($params['prev']);

			$sys_log_msg = 'delete id:'.$id.', name:'.$s->{$this->data['def']['sys_log_name']};

			$this->delete_before($s->Attributes);

            $s->delete();

			sys_log::set($sys_log_msg);

			$this->delete_last();

			// 重新排序
			// 目前Fieldsorter不支援where以外的方法
			if(isset($this->data['def']['listfield'][$sort_field])){
				$fieldsorter = new Fieldsorter;
				$fieldsorter->setTableName($this->data['def']['table']);
				if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
					$fieldsorter->setCondition($this->data['def']['condition']);
				}
				//$fieldsorter->refresh();
				$fieldsorter->refresh('', array(),'', $sort_field);
			}

			$redirect_url = $this->data['class_url'];
			if($prev_url != ''){
				$redirect_url = $prev_url;
			}

			$end_string = '';
			// 這行沒有加，在IE就會看到亂碼
			$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
			$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
			$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
			$end_string .= '<script type="text/javascript">';
			if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0'){
				$end_string .= 'alert(l.get("Delete success"));';
			}
			$end_string .= 'window.location.href="'.$redirect_url.'";';
			$end_string .= '</script>';

			// 為了大陸的pinky而做的暫時性改變
			$this->redirect($redirect_url);

			echo $end_string;

        } else {
			$msg = $this->_getLabel('delete error');
			G::m($msg);
        }
    } // delete

	protected function delete_before(){}
	protected function delete_last(){}

	public function actionCheckbox_listcontent_trigger()
	{
        if(!empty($_POST)){
			$this->data['def'] = G::definit($this->def, $this->data);

			$value = $_POST['value'];
			$id = $_POST['id'];

			if(isset($_POST['field']) and $_POST['field'] != ''){
				$field = $_POST['field'];
			} else {
				$field = 'is_enable';
			}

			//$this->db->where('id', $id);
			//$this->db->update($this->def['table'], array($field => $value));

			//$c = new Empty_orm('insert', $this->data['def']['empty_orm_data']);
			//var_dump($this->data['def']['orm']);
			if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
				$c = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
			} else {
				$c = new $this->data['def']['orm'];
			}
			$u = $c::model()->findByPk($id);
			$u->{$field} = $value;

			if($u->update()){
				echo '1';
				die;
			}
		}
		echo '';
		die;
	}

	public function actionEzdelete($param = '')
	{
		$parameter = new Parameter_handle;
		$params = $parameter->get($param);

		$this->data['def'] = G::definit($this->def, $this->data);

		// 為了要支援sort_id改欄位名稱
		$sort_field = 'sort_id';
		if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
			$sort_field = $this->def['func_field']['sort_id'];
		}

		// 參考用
		//if(!isset($params['value'][0])){
		//	$msg = $this->_getLabel('no id');
		//	G::m($msg);
		//}
		//$id = $params['value'][0];

		if(empty($_POST)){
			//$msg = $this->_getLabel('POST data empty');
			//G::m($msg);
			$prev_url = base64url::decode($params['prev']);
		} else {

			if(!isset($_POST['ezdeletes']) or count($_POST['ezdeletes']) <= 0){
				$msg = $this->_getLabel('Please Select');
				G::m($msg);
			}

			$ids = $_POST['ezdeletes'];

			foreach($ids as $k => $id){

				eval($this->data['empty_orm_eval']);

				if(isset($this->data['def']['empty_orm_data']) and count($this->data['def']['empty_orm_data']) > 0){
					//$c = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
					$c = new $name('insert', $this->data['def']['empty_orm_data']);
				} else {
					//$c = new $this->data['def']['orm'];
					$c = new $name;
				}

				$s = $c::model()->findByPk($id);
				$u = $c::model()->exists('id=:id',array(':id'=>$id));

				if($u){
					// 為了要回去上一頁
					$prev_url = base64url::decode($params['prev']);

					$sys_log_msg = 'delete id:'.$id.', name:'.$s->{$this->data['def']['sys_log_name']};

					$this->delete_before($s->Attributes);

					$s->delete();

					sys_log::set($sys_log_msg);

					$this->delete_last();

					// 重新排序
					// 目前Fieldsorter不支援where以外的方法
					if(isset($this->data['def']['listfield'][$sort_field])){
						$fieldsorter = new Fieldsorter;
						$fieldsorter->setTableName($this->data['def']['table']);
						if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
							$fieldsorter->setCondition($this->data['def']['condition']);
						}
						$fieldsorter->refresh('', array(),'', $sort_field);
					}
				}
			}
		} // empty

		$redirect_url = $this->data['class_url'];
		if($prev_url != ''){
			$redirect_url = $prev_url;
		}

		$end_string = '';
		// 這行沒有加，在IE就會看到亂碼
		$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
		$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
		$end_string .= '<script type="text/javascript">';
		if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0'){
			$end_string .= 'alert(l.get("Delete success"));';
		}
		$end_string .= 'window.location.href="'.$redirect_url.'";';
		$end_string .= '</script>';

		// 為了大陸的pinky而做的暫時性改變
		$this->redirect($redirect_url);

		echo $end_string;

	}

	/*
	 * 即時排序
	 * 兩者的距離在隔壁，就是交換排序
	 * 不在隔壁，往上拉，就是中間項目加1(下面少一項，中間項目往下掉)
	 * 往下拉，就是中間項目減1(上面少一項，中間項目往上動)
	 *
	 * 有兩個欄位是寫死的(id, sort_id)
	 *
	 * @tablename 資料表名稱
	 * @id
	 * @new_id
	 * @addition_conditions 條件群 => field01 != '3' and field02 = 1
	 */
	public function actionSort()
	{
		if(count($_POST) <= 0){
			echo '-1';
		}
		$table_name = $_POST['nnn'];
		$id = $_POST['id'];
		$addition_conditions = $_POST['mmm'];

		// 為了新舊支援
		$new_id = '';
		$new_sort_id = '';
		if(isset($_POST['new_id'])){
			$new_id = $_POST['new_id'];
		} else {
			if(isset($_POST['position'])){
				$new_sort_id = $_POST['position'];
			}
		}

		// 排序的欄位名稱，目前先拉出來，或許未來有改名稱或是其它用處
		$sort_field = 'sort_id';

		// 為了要支援sort_id改欄位名稱
		if(isset($this->def['func_field']['sort_id']) and $this->def['func_field']['sort_id'] != ''){
			$sort_field = $this->def['func_field']['sort_id'];
		}

		// 如果有指定的話
		if(isset($_POST['ppp']) and $_POST['ppp'] != ''){
			$sort_field = $_POST['ppp'];
		}

		if($table_name == '' or $id == '' or ($new_id == '' and $new_sort_id == '')){
			echo '-2';
			die;
		}

		if($new_sort_id == ''){
			// 找一下new_id的排序編號
			//$query = $this->db->select($sort_field)->where('id', $new_id)->get($table_name);
			//$row = $query->row_array();
			$c = $this->db->createCommand();
			$c->select($sort_field);
			$c->from($table_name);
			$c->where('id='.$new_id);
			$row = $c->queryRow();

			$new_sort_id = '';
			if(isset($row[$sort_field]) and $row[$sort_field] != ''){
				$new_sort_id = $row[$sort_field];
			} else {
				echo '-3';
				die;
			}
		}

		$fieldsorter = new Fieldsorter;
		$fieldsorter->setTableName($table_name);
		// table_name, field_id, new_sort_id
		$fieldsorter->go($table_name, $id, $new_sort_id, array(), $addition_conditions, $sort_field);
		if($fieldsorter->getStatus() === false){
			echo $fieldsorter->getMessage();
			echo '-4';
			die;
		}

		// 成功
		echo '1';
		die;
	} // sort

	/*
	 * 在同一欄位內，裡面又有多個欄位的功能
	 *
	 * @fields_pipe aaa|bbb|ccc，第一個欄位是代表必填的欄位
	 *
	 * 在POST的呼叫方式：
	 *
	 * $_POST[GROUPNAME]['data_id'] = $_SESSION['authw_admin_id'];
	 * $_POST[GROUPNAME]['from_user_id'] = $_SESSION['authw_admin_id'];
	 * $this->multi_field_v1(AAA,BBB,CCC,DDD);
	 */
	protected function multi_field_v1($groupname, $tablename, $fields_pipe, $require_field, $section_number,$sample_num = 5)
	{
		/* 使用方式
		 * 1. 獨立使用section
		 * 2. membercontact是GROUPNAME
		 
				// section 2
				array(
					'form' => array('enable' => false),
					'type' => '1',
					//'section_title' => '聯絡人',
					'field' => array(
						'membercontact' => array(
							'label' => '評鑑',
							'type' => 'inputn',
							'attr' => array(
							),
							'attr_td1' => array(
								'width' => '160',
							),
							'other' => array(
								'html' => '',
							),
							// 欄位類型如下：
							// 有資料的欄位，有幾筆就幾個
							// 一次顯示兩組新增的欄位
							'def' => array(
								'updatefield' => array(
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
											'id' => 'form_data',
											'name' => 'form_data',
											'method' => 'post',
											'action' => '',
										),
									),
									'sections_sample' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												//'membercontact_name_' => array(
												//	'label' => '姓名*',
												//	'type' => 'input',
												//	'merge' => '1',
												//	'attr_tr' => array(
												//		'name' => 'membercontact', // 為了要做odd, even
												//	),
												//	'attr' => array(
												//		'id' => 'membercontact_name_',
												//		'name' => 'membercontact_name_',
												//		//'size' => '20',
												//		'class' => 'small_input',
												//	),
												//),
												'membercontact_year_' => array(
													'label' => '年度',
													'type' => 'select3',
													'merge' => '1.5', // 頭中尾的頭(1)
													'attr_tr' => array(
														'name' => 'membercontact', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'membercontact_year_',
														'name' => 'membercontact_year_',
													),
													'other' => array(
														//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
														//'default' => 'center',
														// Jonathan在1/28的早上11:38分所說的
														'values' => array(
															'90' => '90',
															'91' => '91',
															'92' => '92',
															'93' => '93',
															'94' => '94',
															'95' => '95',
															'96' => '96',
															'97' => '97',
															'98' => '98',
															'99' => '99',
															'100' => '100',
															'101' => '101',
															'102' => '102',
															'103' => '103',
															'104' => '104',
															'105' => '105',
															'106' => '106',
															'107' => '107',
															'108' => '108',
															'109' => '109',
															'110' => '110',
															'111' => '111',
															'112' => '112',
															'113' => '113',
															'114' => '114',
															'115' => '115',
															'116' => '116',
															'117' => '117',
															'118' => '118',
															'119' => '119',
															'120' => '120',
														),
														'default' => '90',
														//'html_start' => '年度',
														'html_end' => '　',
													),
												),
												'membercontact_performance_' => array(
													'label' => '*工程業績NT$',
													'type' => 'input',
													'merge' => '2',
													'attr_tr' => array(
														'name' => 'membercontact', // 為了要做odd, even
													),
													'attr' => array(
														'id' => 'membercontact_performance_',
														'name' => 'membercontact_performance_',
														//'size' => '20',
														'class' => 'small_input',
													),
												),
												'membercontact_delete_' => array(
													//'label' => '主要聯絡人',
													'label' => '&nbsp;',
													'type' => 'checkbox',
													'merge' => '3',
													'attr' => array(
														//'id' => 'membercontact_maincontact_',
														'name' => 'membercontact_delete_',
														'value' => '1',
													),
													'other' => array(
														'label' => '刪除',
														//'html_end' => '</span>', // 這裡很特別，別以為寫錯了，只有尾巴而以
													),
												),
											),
										),
										// section 1
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
												'membercontact_more_' => array(
													'label' => '&nbsp;',
													'type' => 'anchor',
													'merge' => '1.5',
													'attr' => array(
														'text' => 'more ...',
														'class' => 'membercontact_more_',
														'onclick' => 'javascript:$(this).parent().parent().next().show();  $(this).parent().parent().next().next().show();  $(this).parent().parent().next().next().next().show();  $(this).parent().parent().hide(); $(\'tr:odd[name=membercontact]\').attr(\'class\', \'bgcolor2\');  $(\'tr:even[name=membercontact]\').attr(\'class\', \'bgcolor1\');',
														'href' => 'javascript:void(0);'
													),
												),
												'end_' => array(
													'label' => '&nbsp;',
													'type' => 'inputn',
													'merge' => '3',
													'attr' => array(
													),
													'other' => array(
														'html' => '',
													),
												),
											),
										),
									),
									'sections' => array(
										// section 0
										array(
											'form' => array('enable' => false),
											'type' => '1',
											'field' => array(
											),
										),
									),
								),
							),
						),
					),
				),
		 */

		$fields = explode('|', $fields_pipe);
		
		if(!empty($_POST)){
			$update = $_POST;
			$membercontacts = array();
			foreach($update as $k => $v){
				if(preg_match('/^'.$groupname.'_/', $k)){
					// search1_name_3
					$tmps = explode('_', $k);

					// 想要試著修正欄位有底線的情況
					$tmpsb = $tmps; // 備份
					// 尾頭切掉
					unset($tmps[count($tmps)-1]);
					unset($tmps[0]);
					$tmp1 = implode('_', $tmps);
					$tmps = array();
					$tmps[0] = $tmpsb[0];
					$tmps[1] = $tmp1;
					$tmps[2] = $tmpsb[count($tmpsb)-1];

					if($tmps[1] == 'delete' and $v == '1'){
						$membercontacts[$tmps[2]]['is_enable'] = 0;
					} else {
						$membercontacts[$tmps[2]][$tmps[1]] = $v;
					}

					unset($update[$k]);
				}
			}

			if(count($membercontacts) > 0){
				foreach($membercontacts as $k => $v){
					// 類似必填欄位
					if(isset($v[$require_field]) and $v[$require_field] == '') continue;

					// 這裡要小心注意一下
					if(isset($v[$require_field]) and $v[$require_field] == '0') continue;

					// 新增
					if(substr($k, 0, 1) == 'c'){
						$v['data_id'] = $update[$groupname]['data_id'];
						//$v['is_enable'] = 1; // 預設值
						$v['create_time'] = date('Y-m-d H:i:s');
						$v['from_user_id'] = $update[$groupname]['from_user_id'];
						$this->cidb->insert($tablename, $v); 
					} else { // 修改
						//if(!isset($v['mainemail'])) $v['mainemail'] = 0;
						//if(!isset($v['maincontact'])) $v['maincontact'] = 0;
						$v['update_time'] = date('Y-m-d H:i:s');
						$this->cidb->where('id', $k);
						$this->cidb->update($tablename, $v); 
					}
				}
			}
			return true;
		}

		include_once 'simple_html_dom.php';


		/*
		 * 多筆
		 */

		// 測試一下
		//$updatecontent_tmp = array();

		$updatecontent_tmp = $this->data['updatecontent'];

		// 只留本群組該用到的updatecontent元素
		if($updatecontent_tmp){
			foreach($updatecontent_tmp as $k => $v){
				if(!preg_match('/^'.$groupname.'/', $k)){
					unset($updatecontent_tmp[$k]);
				}
			}
		}

		$data_tmp = $this->data;

		if($this->data['def']['updatefield']['method'] == 'update'){
			if(in_array('sort_id', $fields)){
				$rows = $this->db->createCommand()->from($tablename)->where('is_enable=1 and data_id=:id', array('id'=>$this->data['updatecontent']['id']))->order('sort_id')->queryAll();
			} else {
				$rows = $this->db->createCommand()->from($tablename)->where('is_enable=1 and data_id=:id', array('id'=>$this->data['updatecontent']['id']))->queryAll();
			}

			//var_dump($rows);
			//die;
			if($rows){
				foreach($rows as $k => $v){
					foreach($v as $kk => $vv){
						if(preg_match('/^('.$fields_pipe.'|id)$/', $kk)){
							$updatecontent_tmp[$groupname.'_'.$kk.'_'.$v['id']] = $vv;
						}
					}

					// 每一筆資料都會重建一次sections裡面的東西
					$create_id = $v['id']; // 複製程式碼，所以採用同樣的寫法
					$tmpx = ''; // 因為等一下要做一次的動作
					foreach($this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][0]['field'] as $kk => $vv){
						if($tmpx == ''){
							$vv['label'] = '&nbsp;'.$vv['label'];
						}

						$tmp = $vv;

						if(isset($tmp['attr']['id'])) $tmp['attr']['id'] .= $create_id;
						if(isset($tmp['attr']['name'])) $tmp['attr']['name'] .= $create_id;

						// 試著撰寫從外部資料覆寫或增加欄位客製屬性的功能
						// 參考的外部程式碼 $this->data['updatecontent']['rule1_param2_2_attr_placeholder'] = '123';
						foreach($updatecontent_tmp as $kkk => $vvv){
							if(preg_match('/^'.$kk.$create_id.'_(attr|other)_(.*)$/', $kkk, $matches)){
								$tmp[$matches[1]][$matches[2]] = $vvv;
							} elseif(preg_match('/^'.$kk.$create_id.'_(label|type)$/', $kkk, $matches)){
								$tmp[$matches[1]] = $vvv;
							}
						}

						$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$kk.$create_id] = $tmp;
					}
				}
			}
		} else { // 從contactus_join1線上申請那邊來的
			// do nothing
		}

		$data_tmp['updatecontent'] = $updatecontent_tmp;
		//var_dump($data_tmp['updatecontent']);

		$create_id = 'c'; // 複製程式碼，所以採用同樣的寫法
		// 總共有10個欄位，5個區塊，每個區塊2筆
		$create_id_number = 0;
		for($j=1;$j<=$sample_num;$j++){

			// 每兩個聯絡人配一個more
			$tmp = $this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][1]['field'][$groupname.'_more_'];
			//$tmp['attr']['class'] .= $create_id.$create_id_number;

			if($this->data['def']['updatefield']['method'] == 'update'){
				if($j != 1){
					$tmp['attr_tr']['style'] = 'display:none';
				}
			} else {
				if($j != 2){
					$tmp['attr_tr']['style'] = 'display:none';
				}
			}
			$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$groupname.'_more_'.$create_id.$create_id_number] = $tmp;

			for($i=0;$i<=1;$i++){
				$tmpx = ''; // 因為等一下要做一次的動作
				foreach($this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections_sample'][0]['field'] as $kk => $vv){
					// 在新增裡面，是不會有刪除按鈕的
					if(preg_match('/delete/', $kk)){
					   	//continue;
						$vv['type'] = 'inputn';
						$vv['other']['html'] = '';
					}

					if($tmpx == ''){
						$vv['label'] = '<i class="icon-plus '.$groupname.'_new" style="cursor:pointer"></i>&nbsp;'.$vv['label'];
					}
					$tmpx = '1';
					$tmp = $vv;
					if(isset($tmp['attr']['id'])) $tmp['attr']['id'] .= $create_id.$create_id_number;
					if(isset($tmp['attr']['name'])) $tmp['attr']['name'] .= $create_id.$create_id_number;

					// 在新增裡面，要手動按more，才會讓內容顯示
					if(preg_match('/'.$groupname.'_'.$fields[0].'_/', $kk)){
						if($this->data['def']['updatefield']['method'] == 'update'){
							$tmp['attr_tr']['style'] = 'display:none';
						} else {
							if($j == 1 and ($i == 0 or $i == 1)){
								// nothing
							} else {
								$tmp['attr_tr']['style'] = 'display:none';
							}
						}
					}

					$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def']['updatefield']['sections'][0]['field'][$kk.$create_id.$create_id_number] = $tmp;
				}
				$create_id_number++;
			}

		}

		$data_tmp['def'] = $this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['def'];

		// 這是範本，如果有select或是radio等欄位，別忘了要先給它空值之類的
		//$data_tmp['updatecontent']['membercontact_performance_c0'] = '';
		//$data_tmp['updatecontent']['membercontact_year_c0'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c1'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c2'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c3'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c4'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c5'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c6'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c7'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c8'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c9'] = '90';
		//$data_tmp['updatecontent']['membercontact_year_c10'] = '90';


		// 先備份所有的data
		$backup_data = $this->data;

		//var_dump($data_tmp);
		//die;

		// 切換
		$this->data = $data_tmp;
		$this->layout = 'empty';
		$tmp = $this->renderPartial('//default/update', $this->data, true);
		$this->layout = 'main';

		// 回復
		$this->data = $backup_data;

		// 只取得我需要的
		$html = str_get_html($tmp, true, true, DEFAULT_TARGET_CHARSET, false);
		$tmp_html = '';
		// 沒有這樣子的寫的話，會報錯哦
		if(count($html->find('table')) > 0){
			$html->find('table', 0)->class = 'table1_need_change_'.$groupname;
			$tmp_html = $html->find('table', 0)->outertext;
		}

		$this->data['def']['updatefield']['sections'][$section_number]['field'][$groupname]['other']['html'] = $tmp_html;
	}

}

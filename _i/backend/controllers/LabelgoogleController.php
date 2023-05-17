<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

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
			'rules' => array(
				array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'other1', // 預設要排序的欄位
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
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		//),
		// 建立前端要顯示的欄位
		'listfield_attr' => array(
			'smarty_include_top' => 'product/main_content_top.htm',
		),
		'listfield' => array(
			'topic' => array(
				'label' => '片語',
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
				'label' => '內容',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
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
			/*
			'is_home' => array(
				//'label' => 'ml:Sort id',
				'mlabel' => array(
					null, // category
					'Show Home', // label
					array(), // sprintf
					'顯示在首頁', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_home',
				'ezother'=> '&nbsp;',
			),
			*/
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

				// 範例
				//'func_dropdown' => array(
				//	'enable' => true,
				//	'url_id' => 'id',
				//	'values' => array(
				//		array('id' => '1', 'name' => '顯示'),
				//		array('id' => '0', 'name' => '停用'),
				//	),
				//	'define' => array(
				//		'id' => 'id',
				//		'name' => 'name',
				//		'is_selected' => 'is_selected',
				//	),
				//),
			),
			//'sort_id' => array(
			//	'label' => 'ml:Sort id',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 
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
							'label' => '片語',
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
							'other' => array(
								'has_copy' => 1,
							),
						),
						'other1' => array(
							'label' => '內容',
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
								'size' => '40',
							),
							'other' => array(
								'has_copy' => 1,
							),
						),
						//'url1' => array(
						//	'label' => '網址',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'url1',
						//		'name' => 'url1',
						//		'size' => '40',
						//	),
						//),
						//'pic1' => array(
						//	'label' => '內頁圖片上傳：',
						//	'type' => 'fileuploader',
						//	'other' => array(
						//		'number' => '1',
						//		'type' => 'photo',
						//		'top_button' => '1',
						//		'width' => '360',
						//		'height' => '220',
						//		'comment_size' => '360x220',
						//		'no_ext' => '',
						//		'no_need_delete_button' => '',
						//	),
						//),
						/*
						'pic2' => array(
							'label' => '首頁圖片上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '2',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '360x220',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						*/
						//'sort_id' => array(
						//	//'label' => 'ml:Sort',
						//	'mlabel' => array(
						//		null, // category
						//		'Sort', // label
						//		array(), // sprintf
						//		'排序', // default
						//	),
						//	'type' => 'sort',
						//	'attr' => array(
						//	),
						//),
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
				//		/*
				//		'field_tmp' => array(
				//			'label' => '首頁',
				//			//'type' => 'textarea',
				//			'type' => 'ckeditor_js',
				//			'attr' => array(
				//				//'class' => 'form-control', // 這…手動加上去好了
				//				'id' => 'field_tmp',
				//				'name' => 'field_tmp',
				//				//'rows' => '4',
				//				//'cols' => '40',
				//			),
				//		),
				//		*/
				//	),
				//),
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
		//if(isset($this->def['sortable'])){
		//	$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		//}

		// if(isset($GLOBALS['lay_out_select']) && $GLOBALS['lay_out_select']!=1){
		// 	unset($this->def['listfield']['is_home']);
		// 	unset($this->def['updatefield']['sections'][0]['field']['pic2']);
		// 	unset($this->def['updatefield']['sections'][1]['field']['field_tmp']);
		// }

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = 'type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		$file = tmp_path.'/labelgoogle.php';
		// $map = array(
		// 	'tw' => 'zh-TW',
		// 	'cn' => 'zh-CN',
		// 	'jp' => 'ja',
		// );
		$tmps = $this->cidb->where('is_enable',1)->where('type','labelgoogle')->get('html')->result_array();
		$labelgoogles = array();
		if($tmps and count($tmps) > 0){
			foreach($tmps as $k => $v){
				$ml_key = $v['ml_key'];
				// if(isset($map[$v['ml_key']])){
				// 	$ml_key = $map[$v['ml_key']];
				// }
				$labelgoogles[$ml_key][$v['topic']] = $v['other1'];
			}
		}
		file_put_contents($file, '<?php '."\n".'$labelgoogles = '.var_export($labelgoogles,true).';');
		@chmod($file,0777);

		return true;
	}

	protected function index_last()
	{
		$file = tmp_path.'/translate.php';
		$aaa = '?'.'>'.file_get_contents($file);
		eval($aaa);

		// $map = array(
		// 	'tw' => 'zh-TW',
		// 	'cn' => 'zh-CN',
		// 	'jp' => 'ja',
		// );
		// $ml_key = $this->data['admin_switch_data_ml_key'];
		// if(isset($map[$ml_key])){
		// 	$ml_key = $map[$ml_key];
		// }

		// $result = '';
		// if(isset($translates) and isset($translates[$ml_key]) and count($translates[$ml_key]) > 0){
		// 	$result .= '<br /><b>Google翻譯的項目：</b><table class="table1 sortable table table-striped table-bordered table-hover dataTable">'."\n";
		// 	$result .= '<tr><th class="sorting" width="40%"><a href="javascript:;">片語</a></th><th class="sorting"><a href="javascript:;">內容</a></th></tr>';
		// 	foreach($translates[$ml_key] as $k => $v){
		// 		$result .= '<tr>'."\n";
		// 		$result .= '<td>'.$k.'</td><td>'.$v.'</td>'."\n";
		// 		$result .= '</tr>'."\n";
		// 	}
		// 	$result .= '</table>';
		// }

		$result = '<br /><p style="color:red">* 有翻譯，才會在這底下搜尋得到，如果是當下語系是中文，而且片語是中文，那就不會翻譯，而且在這底下搜尋不到</p>';
		$result .= '<br /><p style="color:red"><b>* 分頁在最最最下面 ↓ ↓ ↓ ⬇ ⬇ ⬇</b></p>';
		if(isset($translates) and count($translates) > 0){
			foreach($translates as $ml_key => $v){
				$result .= '<br /><b>資料庫內現有的翻譯項目： ( '.$ml_key.' )</b>'."\n";
				$result .= '<table class="table1 sortable table table-striped table-bordered table-hover dataTable">'."\n";
				$result .= '<tr><th class="sorting" width="6%"><a href="javascript:;">語系</a></th><th class="sorting" width="40%"><a href="javascript:;">片語</a></th><th class="sorting"><a href="javascript:;">內容</a></th></tr>'."\n";
				foreach($v as $kk => $vv){
					$result .= '<tr>'."\n";
					$result .= '<td>'.$ml_key.'</td>'."\n";
					$result .= '<td>'.$kk.'</td>'."\n";
					$result .= '<td>'.$vv.'</td>'."\n";
					$result .= '</tr>'."\n";
				}
				$result .= '</table>';
			}
		}

		$this->data['listfield_start_html'] = '<b>自行輸入的部份：</b> *會覆寫該語系現有的翻譯項目';
		$this->data['listfield_end_html'] = $result;
	}

	protected function update_run_other_element($array)
	{
		//$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		//$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function update_run_last()
	{
		$all_label = array();

		// $map = array(
		// 	'zh-TW' => 'tw',
		// 	'zh-CN' => 'cn',
		// 	'ja' => 'jp',
		// );

		// 這個一定有值
		// if(isset($map[$source])){
		// 	$source = $map[$source];
		// }

		$file = tmp_path.DIRECTORY_SEPARATOR.'translate.php';
		$translates = array();
		if(file_exists($file)){
			include $file;
		}

		$file2 = tmp_path.DIRECTORY_SEPARATOR.'labelgoogle.php';
		$labelgoogles = array();
		if(file_exists($file2)){
			include $file2;
		}

		if(count($translates) > 0){
			foreach($translates as $ml_key_tmp => $v){
				$ml_key = $ml_key_tmp;
				// if(isset($map[$ml_key])){
				// 	$ml_key = $map[$ml_key];
				// }
				if(count($v) > 0){
					foreach($v as $kk => $vv){
						$all_label[$ml_key][strtolower($kk)] = $vv;
					}
				}
			}
		}

		if(count($labelgoogles) > 0){
			foreach($labelgoogles as $ml_key_tmp => $v){
				$ml_key = $ml_key_tmp;
				// if(isset($map[$ml_key])){
				// 	$ml_key = $map[$ml_key];
				// }
				if(count($v) > 0){
					foreach($v as $kk => $vv){
						$all_label[$ml_key][strtolower($kk)] = $vv;
					}
				}
			}
		}

		if(count($all_label) > 0){
			$js_lang_path = tmp_path.DIRECTORY_SEPARATOR.'language2.js';
			//var_dump($all_label);die;

			// 輸出給javascript所使用的多國語系片語
			file_put_contents($js_lang_path, 'var labels2 = '.json_encode($all_label).';');
		}
	}

	/*
	 * 基本款
	 * 客製：只有修正送出後的跳出視窗
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

			if(isset($this->data['def']['empty_orm_data']) and !empty($this->data['def']['empty_orm_data'])){
				$x = new $this->data['def']['orm']('insert', $this->data['def']['empty_orm_data']);
			} else {
				$x = new $this->data['def']['orm'];
			}

			if(!empty($x->getOrmRule())){
				$validation = G::getJqueryValidation($x->getOrmRule(), $this->data['def']);
			} elseif(isset($this->data['def']['empty_orm_data']['rules']) and !empty($this->data['def']['empty_orm_data']['rules'])){
				$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules'], $this->data['def']);
			}

			$x = null;

			$updatecontent = $this->db->createCommand()->from($this->data['def']['table'])->where($this->data['def']['func_field']['id'].'=:id', array(':id'=>$this->data['id']))->queryRow();

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
			if(isset($this->data['def']['empty_orm_data']) and !empty($this->data['def']['empty_orm_data'])){
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
					$fieldsorter->setIdName($this->data['def']['func_field']['id']);
					if(!empty($this->data['def']['condition'])){
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
			//if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0' or 1){ //2016/5/12 經理建議 要直接跳出修改提醒
			//	//$end_string .= 'alert(l.get("Update success"));';
			//	$end_string .= 'alert("Update success");';
			//}

			//$this->load->library('base64url');
			if(isset($update['update_base64_url']) and $update['update_base64_url'] != ''){
				$url = base64url::decode($update['update_base64_url']);

				// 原有的方式，會導致一重整，就alert一次
				//$url = str_replace('-vsuccess', '', $url);
				//redirect($url.'-vsuccess');

				if($url==''){
					$url = BACKEND_DOMAIN.'/_i/';
				}

				// 新的方式己修正掉這個問題
				$end_string .= 'window.location.href="'.$url.'";';

				// 為了大陸的pinky而做的暫時性改變 2016/5/12 經理建議 要跳出提醒 , 關閉直接跳頁
				//$this->redirect($url);
			} else {
				// 原有方式
				//$url = $this->base64url->encode($redirect_url);
				//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'update');

				if($redirect_url==''){
					$redirect_url = BACKEND_DOMAIN.'/_i/';
				}

				$end_string .= 'window.location.href="'.$redirect_url.'";';

				// 為了大陸的pinky而做的暫時性改變 2016/5/12 經理建議 要跳出提醒 , 關閉直接跳頁
				//$this->redirect($redirect_url);
			}


			$end_string .= '</script>';
			echo $end_string;
			die;
        }
    } // update

	// 擴展的測試
	// protected function update_show_first($params)
	// {
	// 	parent::update_show_first($params);
	// }

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

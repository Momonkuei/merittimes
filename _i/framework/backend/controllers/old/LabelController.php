<?php

class LabelController extends Controller {

	protected $def = array(
		//'title' => 'ml:Label',
		'table' => 'ml_label',
		'orm' => 'empty_orm',
		'empty_orm_data' => array(
			'table' => 'ml_label',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('key', 'required'),
				array('key', 'length', 'max'=>255),
				//array('have_lang', 'length', 'max'=>1),
			),
		),
		'empty_orm_data_lang' => array(
			'table' => 'ml_lang',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('ml_key', 'length', 'max'=>2),
				array('label_key', 'required'),
				array('label_key', 'length', 'max'=>255),
			),
		),
		'default_sort_field' => 'key', // 預設要排序的欄位
		'search_keyword_field' => array('key'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'key', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'key', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		// 建立前端要顯示的欄位
		'listfield_attr' => array(
			'smarty_include_top' => 'label/main_content_top.htm',
		),
		// 建立前端要顯示的欄位
		'listfield' => array(
			//'xxx' => array(
			//	'label' => '&nbsp;',
			//	'width' => '2%',
			//),
			'value' => array(
				'label' => '中文',
				'width' => '20%',
				'sort' => false,
			),
			'key' => array(
				//'label' => 'ml:Label Index',
				//'label' => '片語索引',
				'mlabel' => array(
					null, // category
					'Label Index', // label
					array(), // sprintf
					'片語索引', // default
				),
				'width' => '30%',
				'sort' => true,
			),
			'create_time' => array(
				//'label' => 'ml:Create time',
				'mlabel' => array(
					null, // category
					'Create time', // label
					array(), // sprintf
					'建立時間', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
			'update_time' => array(
				//'label' => 'ml:Update time',
				'mlabel' => array(
					null, // category
					'Update time', // label
					array(), // sprintf
					'修改時間', // default
				),
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
			),
			//'smarty_javascript' => 'label/update_javascript.htm',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
					'method' => 'post',
					'action' => '',
					'enctype' => 'multipart/form-data',
				),
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'key' => array(
							//'label' => 'ml:Label',
							'label' => '片語索引',
							'type' => 'input',
							'attr' => array(
								'id' => 'key',
								'name' => 'key',
								'size' => '50',
							),
						),
					),
				),
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'xxx01' => array(
				//			//'label' => 'ml:Label',
				//			'label' => '有用到此片語的地方：',
				//			'type' => 'divid_2',
				//			'attr' => array(
				//				'id' => 'xxx01',
				//			),
				//		),
				//	),
				//),
				/*
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						'detail' => array(
							'label' => '廣告圖說',
							'type' => 'textarea',
							'attr' => array(
								'id' => 'detail',
								'name' => 'detail',
								'style' => 'resize: none;',
								'rows' => '6',
								'cols' => '100',
							),
						),
						'pic1' => array(
							'label' => '',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'top_button' => '1',
								'width' => '300',
								'height' => '300',
								'comment_size' => '220x220',
							),
						),
					),
				),
				 */
			),
		), // updatefield
	);

	public function actionTest()
	{
		//$d = new Empty_orm;
		// echo '123';
		// echo '<br />';

		// unset($a);
		// //die;

		// $e = new Empty_orm('insert', $this->def['empty_orm_data']);
		// $e->__destruct();

		// // 雖然沒辦法有第一次new的報錯，不過之後可以覆寫就好了
		// $c = new Empty_orm;
		//$a = new Empty_orm('insert', $this->def['empty_orm_data']);
		//unset($a);
		//$b = new Empty_orm('insert', $this->def['empty_orm_data_lang']);
		//var_dump($b::model()->findAll());
		//$c = $b::model()->findByPk(837);
		//echo $c->value;

		//$a = new Empty_orm('insert', $this->def['empty_orm_data']);
		//unset($a);

		//$z = new Empty_orm('xx');
		//unset($z);

		//$this->data['empty_orm_count']++;
		//$eval_content = $this->data['empty_orm'];
		//$eval_content[0] .= (string)$this->data['empty_orm_count'].$this->data['empty_orm_title'];
		//eval(implode("\n", $eval_content));
		//$name = 'Empty_orm'.$this->data['empty_orm_count'];
		//$b = new $name('insert', $this->def['empty_orm_data_lang']);
		//$b->ml_key = 'xx';
		//$b->label_key = 'ccc';
		//$b->value = 'aa';
		//$b->save();
		//die;


				//'mlabel' => array(
				//	null, // category
				//	'Label Index', // label
				//	array(), // sprintf
				//	'片語索引4', // default
				//),
		echo G::te(null, '[[admin_lang_1]] Label Index', array(), '片語索引4');
	}

	//public function actionTest2()
	//{
	//	//$d = new Empty_orm;
	//	$a = new Adminmenu_orm;
	//	$a::model()->count('');
	//	echo '456';
	//	die;
	//	//var_dump($b);
	//}

	public function actionAutocomplete()
	{
		//var_dump($_GET);
		//array(3) { ["q"]=> string(1) "a" ["limit"]=> string(1) "6" ["timestamp"]=> string(13) "1336453656605" } 

		$querystring = $_GET['q'];
		$limit = $_GET['limit'];
		$timestamp = $_GET['timestamp'];

		$query = $this->cidb->or_like('label_key', $querystring)->or_like('value', $querystring)->get('ml_lang');
		$result = $query->result_array();
		if(count($result) <= 0){
			echo '';
		}

		$query = $this->cidb->get('ml_lang');
		$result_tmp = $query->result_array();
		$results_tmp = array();
		foreach($result_tmp as $row){
			$results_tmp[$row['label_key']][$row['ml_key']] = $row['value'];
		}

		// 合併整理好的片語key
		$results = array();
		foreach($result as $row){
			//$results[$row['label_key']][$row['ml_key']] = $row['value'];
			$results[$row['label_key']] = $results_tmp[$row['label_key']];
		}
		//var_dump($results);

		$return = '';
		foreach($results as $k => $v){
			$tmp = $k.'----';
			$tmps = array();
			foreach($v as $kk => $vv){
				if(isset($this->data['mls'][$kk])){
					$tmps[] = $this->data['mls'][$kk].'==='.$vv;
				}
			}
			$tmp .= implode('*****', $tmps);
			$return .= $tmp."\n";
		}
		echo $return;

	}

	protected function index_get_total()
	{
		// Debug
		//throw new CHttpException(500,'The specified post cannot be found.');
		//die;

		// 取得總筆數
		$sql = 'SELECT COUNT(*) AS count 
			FROM ml_label
			LEFT JOIN ml_lang ON ml_lang.label_key=ml_label.`key`
			WHERE ml_lang.ml_key="'.$this->data['ml_key'].'" 
			AND ( ml_lang.label_key LIKE "%'.$this->data['search_keyword'].'%" OR ml_lang.`value` LIKE "%'.$this->data['search_keyword'].'%")';

		//if($this->data['search_keyword'] != ''){
		//} else {
		//	$sql = 'SELECT COUNT(*) AS count FROM ml_label';
		//}

		$c = $this->db->createCommand($sql);
		$total_rows = $c->queryScalar();

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
	}

	protected function index_get_data()
	{
		$this->data['def']['listfield']['value']['label'] = $this->data['mls'][$this->data['mls_tmp'][0]];
		//var_dump( $this->data['mls_tmp']);
		/*
		 * 搜尋兩次，為的是有些片語，只有定義，而沒有資料的狀況
		 * 所以我搜尋的第二次，就是要純搜尋片語定義，最後做結合
		 */

		// 取得資料
		$sql = 'SELECT ml_label.id, ml_label.key, ml_lang.`value`, ml_lang.create_time, ml_lang.update_time
			FROM ml_label 
			LEFT JOIN ml_lang ON ml_lang.label_key=ml_label.`key` ';
		// 搜尋現在語系的片語與值，或是搜尋現在語系，但是片語沒值的東西出來，有一種狀況，是現行語系沒有片語值，但是其它有，這時會找不到
		// 解決方式，為在寫入的時候，把空白的也寫一寫
		$sql .= 'WHERE (ml_lang.ml_key="'.$this->data['mls_tmp'][0].'" OR (ml_lang.value IS NULL AND ml_lang.ml_key IS NULL)) ';
			// WHERE (ml_lang.ml_key="tw" OR (ml_lang.value IS NULL AND ml_lang.ml_key IS NULL)) ';
			// 測試修bug中
			//WHERE ml_lang.ml_key="'.$this->data['ml_key'].'" ';
		if($this->data['search_keyword'] != ''){
			$sql .= 'AND (( ml_lang.label_key LIKE "%'.$this->data['search_keyword'].'%" OR ml_lang.`value` LIKE "%'.$this->data['search_keyword'].'%" OR ml_label.`key` LIKE "'.$this->data['search_keyword'].'" OR ml_label.`key` LIKE "%'.$this->data['search_keyword'].'%" ) OR (( `ml_label`.key LIKE "'.$this->data['search_keyword'].'" OR `ml_label`.`key` LIKE "%'.$this->data['search_keyword'].'%") AND (ml_lang.`value` IS NULL AND ml_lang.ml_key IS NULL)) ) ';
		}
		$sql .= 'ORDER BY ml_label.`'.$this->data['sort_field_nobase64'].'` '.$this->data['params']['direction'].' ';
		$sql .= 'LIMIT '.($this->data['params']['page']-1)*$this->data['record'].', '.$this->data['record'];
		$c = $this->db->createCommand($sql);
		$listcontent = $c->queryAll();

		$this->data['listcontent'] = $listcontent;
	}

	protected function update_show_last($updatecontent)
	{
		//$query = $this->db->where('label_key', $updatecontent['key'])->get('ml_lang');
		$langs = array();
		//foreach($query->result() as $row){
		//	$langs[$row->ml_key] = $row->value;
		//}

		$c = $this->db->createCommand();
		$c->from('ml_lang');
		$c->where('label_key=:key', array(':key'=>$updatecontent['key']));
		$langs_tmp = $c->queryAll();
		foreach($langs_tmp as $row){
			$langs[$row['ml_key']] = $row['value'];
		}
		$this->data['langs'] = $langs;

		// 比較特別的地方，自行創造修改的欄位
		// 'field' => array(
		// 	'key' => array(
		// 		'label' => 'ml:Label',
		// 		'type' => '',
		// 	),
		// ),
		if(isset($this->data['mls']) and count($this->data['mls']) > 0){
			foreach($this->data['mls'] as $k => $v){
				$array = array(
					'label' => $v,
					'type' => 'inputx',
					'attr' => array(
						'id' => 'langs_'.$k,
						'name' => 'langs_'.$k,
						'size' => '50',
						//'value' => $this->data['langs'][$k],
					),
				);
				if(isset($this->data['langs'][$k])){
					$array['attr']['value'] = $this->data['langs'][$k];
				}
				$this->data['def']['updatefield']['sections'][0]['field'][] = $array;
			}
		}

		// 管理者(最大的)，能夠擁有刪除網站專屬的片語，讓它使用共用的片語
		// 以及匯出共用的片語
		if($this->data['admin_is_hidden'] == '1' and 0){

			$array = array(
				'label' => '所有雲端相同片語一起改，沒有就建(資料庫)',
				'type' => 'status',
				'attr' => array(
					'id' => 'is_db_create_update',
					'name' => 'is_db_create_update',
				),
				'other' => array(
					'default' => '0',
					'other1' => '好',
					'other2' => '不做任何動作',
				),
			);
			$this->data['def']['updatefield']['sections'][0]['field'][] = $array;

			$array = array(
				'label' => '匯出共用片語(檔案)',
				'type' => 'status',
				'attr' => array(
					'id' => 'is_public',
					'name' => 'is_public',
				),
				'other' => array(
					'default' => '0',
					'other1' => '匯出',
					'other2' => '不做任何動作',
				),
			);
			$this->data['def']['updatefield']['sections'][0]['field'][] = $array;

			$array = array(
				'label' => '使用共用片語(檔案)',
				'type' => 'status',
				'attr' => array(
					'id' => 'is_delete',
					'name' => 'is_delete',
				),
				'other' => array(
					'default' => '0',
					'other1' => '使用',
					'other2' => '不做任何動作',
				),
			);
			$this->data['def']['updatefield']['sections'][0]['field'][] = $array;
		}

		// 在修改片語的時候，我讓使用者不能改名稱，這樣比較合理，如果要改，也是改不了
		$this->data['def']['updatefield']['sections'][0]['field']['key']['attr']['readonly'] = 'readonly';

		$this->data['updatecontent']['xxx01'] = '搜尋處理中...';

		// 選擇預設的修改樣版，並依照程式變數產生
		$this->data['main_content'] = '/default/update';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'/'.$this->data['updatecontent']['id'];
	}

	protected function update_run_last()
	{
		$update = $_POST;

		if(!isset($update['is_db_create_update'])){
			$update['is_db_create_update'] = '0';
		}

		if(!isset($update['is_public'])){
			$update['is_public'] = '0';
		}

		if(!isset($update['is_delete'])){
			$update['is_delete'] = '0';
		}

		$label_key = $_POST['key'];

		$langs = array();
		foreach($update as $k => $v){
			if(preg_match('/^langs_(.*)$/', $k, $matches)){
				// 本來是空白的不理它
				//if($v != ''){
				//	$langs[$matches[1]] = $v;
				//}
				$langs[$matches[1]] = $v;
			}
		}

		//if(count($langs) > 0){
		//	$g = new Lang_orm();
		//	foreach($langs as $k => $v){
		//		$g->where('label_key', $label_key)->where('ml_key', $k)->limit(1)->get();
		//		if($g->result_count() > 0){
		//			$g->value = $v;
		//			// save自己會做validate
		//			if(!$g->save())	show_error($g->error->string);
		//		} else {
		//			$g = new Lang_orm();
		//			$g->ml_key = $k;
		//			$g->label_key = $label_key;
		//			$g->value = $v;
		//			// save自己會做validate
		//			if(!$g->save())	show_error($g->error->string);
		//		}
		//	}
		//}

		if(count($langs) > 0){
			foreach($langs as $k => $v){
				$g = $this->db->createCommand()->from('ml_lang')->where('label_key=:key and ml_key=:ml_key', array(':key'=>$label_key, ':ml_key'=>$k))->queryRow();
				if($g){
					eval($this->data['empty_orm_eval']);
					$c = new $name('insert', $this->data['def']['empty_orm_data_lang']);
					//var_dump($c);
					//die;
					$u = $c::model()->findByPk($g['id']);
					//$u = $c::model()->findAll();
					//var_dump($u);
					//die;
					$u->value = $v;
					if(!$u->update()){
						G::dbm($u->getErrors());
					}
				} else {
					eval($this->data['empty_orm_eval']);
					$u = new $name('insert', $this->data['def']['empty_orm_data_lang']);
					$u->ml_key = $k;
					$u->label_key = $label_key;
					$u->value = $v;
					if(!$u->save()){
						G::dbm($u->getErrors());
					}
				}
			}
		}

		// 匯出實體檔案
		$ml = new Ml2;
		$ml->export();

		if($update['is_delete'] == '1'){
			$ml->delete();
		}

		$themea = G::get_theme_compiler($this->data['theme_name']);
		if($themea == 'smarty'){
			// 清除template compile後的資料，這樣子片語才會正確的在production模式下顯示
			//$this->smarty_parser->clear_compiled_tpl();
			Yii::app()->smarty->clear_compiled_tpl();
		}
	}

	protected function create_show_last()
	{
        $search = Yii::app()->session['search'];
		if(isset($search[0][0]) and $search[0][0] == $this->data['router_class']){
			if(isset($search[0][1]) and $search[0][1] == $this->data['updatecontent'][$this->data['def']['search_keyword_assign_field']]){
				$this->data['updatecontent'][$this->data['def']['search_keyword_assign_field']] = '[['.$this->data['theme_lang'].']] '.$this->data['updatecontent'][$this->data['def']['search_keyword_assign_field']];
			}
		}

		//var_dump($this->data['updatecontent']);
		//die;
		// 比較特別的地方
		// 'field' => array(
		// 	'key' => array(
		// 		'label' => 'ml:Label',
		// 		'type' => '',
		// 	),
		// ),
		if(isset($this->data['mls']) and count($this->data['mls']) > 0){
			foreach($this->data['mls'] as $k => $v){
				$array = array(
					'label' => $v,
					'type' => 'input',
					'attr' => array(
						'id' => 'langs_'.$k,
						'name' => 'langs_'.$k,
						'size' => '50',
						//'value' => $this->data['langs'][$k],
					),
				);
				$this->data['def']['updatefield']['sections'][0]['field'][] = $array;
			}
		}

		$this->data['def']['updatefield']['sections'][0]['field']['xxx01'] = array(
			'label' => '注意說明事項',
			'type' => 'divid_2',
		);

		$this->data['def']['updatefield']['sections'][0]['field']['xxx0x_br'] = array(
			'label' => '',
			'type' => '',
		);

		$this->data['updatecontent']['xxx01'] = '
			<div>
				1. 片語索引，建議輸入英文，可以有空白或任何符號，它是一個索引，不過在你沒有輸入當下語系資料時，它就會出現不會開天窗
			</div>
			<div>
				2. 片語索引，可以加上 [[xxx01]]_abcdef (其中xxx01是分區片語名稱，底線是空白，abcdef是片語索引)
			</div>
			<div>
				3. 分區片語，是不會輸出 [[xxx01]] 的字眼出來，在你沒有填當下語系輸出的時候
			</div>
			';

		// 管理者(最大的)，能夠擁有刪除網站專屬的片語，讓它使用共用的片語
		// 以及匯出共用的片語
		if($this->data['admin_is_hidden'] == '1' and 0){

			$array = array(
				'label' => '所有雲端相同片語一起改，沒有就建(資料庫)',
				'type' => 'status',
				'attr' => array(
					'id' => 'is_db_create_update',
					'name' => 'is_db_create_update',
				),
				'other' => array(
					'default' => '0',
					'other1' => '好',
					'other2' => '不做任何動作',
				),
			);
			$this->data['def']['updatefield']['sections'][0]['field'][] = $array;

			$array = array(
				'label' => '匯出共用片語(檔案)',
				'type' => 'status',
				'attr' => array(
					'id' => 'is_public',
					'name' => 'is_public',
				),
				'other' => array(
					'default' => '0',
					'other1' => '匯出',
					'other2' => '不做任何動作',
				),
			);
			$this->data['def']['updatefield']['sections'][0]['field'][] = $array;

			$array = array(
				'label' => '使用共用片語(檔案)',
				'type' => 'status',
				'attr' => array(
					'id' => 'is_delete',
					'name' => 'is_delete',
				),
				'other' => array(
					'default' => '0',
					'other1' => '使用',
					'other2' => '不做任何動作',
				),
			);
			$this->data['def']['updatefield']['sections'][0]['field'][] = $array;
		}

		//unset($this->data['def']['updatefield']['sections'][1]);
		unset($this->data['def']['updatefield']['sections'][1]['field']);

		$this->data['def']['updatefield']['sections'][1]['field']['xxx01'] = array(
			'label' => '注意說明事項',
			'type' => 'divid_2',
		);

		$this->data['def']['updatefield']['sections'][1]['field']['xxx0x_br'] = array(
			'label' => '',
			'type' => '',
		);

		$this->data['updatecontent']['xxx01'] = '
			<div>
				1. 片語索引，建議輸入英文，可以有空白或任何符號，它是一個索引，不過在你沒有輸入當下語系資料時，它就會出現不會開天窗
			</div>
			<div>
				2. 片語索引，可以加上 [[xxx01]]_abcdef (其中xxx01是分區片語名稱，底線是空白，abcdef是片語索引)
			</div>
			<div>
				3. 分區片語，是不會輸出 [[xxx01]] 的字眼出來，在你沒有填當下語系輸出的時候
			</div>
			';

		// 選擇預設的修改樣版，並依照程式變數產生
		$this->data['main_content'] = '/default/update';
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	protected function create_run_last()
	{
		$update = $_POST;

		if(!isset($update['is_db_create_update'])){
			$update['is_db_create_update'] = '0';
		}

		if(!isset($update['is_public'])){
			$update['is_public'] = '0';
		}

		if(!isset($update['is_delete'])){
			$update['is_delete'] = '0';
		}

		$label_key = $_POST['key'];

		$langs = array();
		foreach($_POST as $k => $v){
			if(preg_match('/^langs_(.*)$/', $k, $matches)){
				if($v != ''){
					$langs[$matches[1]] = $v;
				}
			}
		}

		/*
		if(count($langs) > 0){
			$g = new Lang_orm();
			foreach($langs as $k => $v){
				$g->where('label_key', $label_key)->where('ml_key', $k)->limit(1)->get();
				if($g->result_count() > 0){
					$g->value = $v;
					// save自己會做validate
					if(!$g->save())	show_error($g->error->string);
				} else {
					$g = new Lang_orm();
					$g->ml_key = $k;
					$g->label_key = $label_key;
					$g->value = $v;
					// save自己會做validate
					if(!$g->save())	show_error($g->error->string);
				}
			}
		}

		// 匯出實體檔案
		$this->load->library('Ml2', '', 'ml');
		if($update['is_public'] == '0'){
			$this->ml->export();
		} else {
			$this->ml->export('1');
		}

		if($update['is_delete'] == '1'){
			$this->ml->delete();
		}
*/

		if(count($langs) > 0){
			foreach($langs as $k => $v){
				$g = $this->db->createCommand()->from('ml_lang')->where('label_key=:key and ml_key=:ml_key', array(':key'=>$label_key, ':ml_key'=>$k))->queryRow();
				if($g){
					eval($this->data['empty_orm_eval']);
					$c = new $name('insert', $this->def['empty_orm_data_lang']);
					$u = $c::model()->findByPk($g['id']);
					$u->value = $v;
					if(!$u->update()){
						G::dbm($u->getErrors());
					}
				} else {
					eval($this->data['empty_orm_eval']);
					$u = new $name('insert', $this->def['empty_orm_data_lang']);
					$u->ml_key = $k;
					$u->label_key = $label_key;
					$u->value = $v;
					if(!$u->save()){
						G::dbm($u->getErrors());
					}
				}
			}
		}

		//if(count($langs) > 0){
		//	foreach($langs as $k => $v){
		//		$g = $this->db->createCommand()->from('ml_lang')->where('label_key=:key and ml_key=:ml_key', array(':key'=>$label_key, ':ml_key'=>$k))->queryRow();
		//		if($g){
		//			$c = new Empty_orm('insert', $this->data['def']['empty_orm_data_lang']);
		//			$u = $c::model()->findByPk($g['id']);
		//			$u->value = $v;
		//			if(!$u->update()){
		//				G::dbm($u->getErrors());
		//			}
		//		} else {
		//			//var_dump($this->data['def']['empty_orm_data_lang']);
		//			//die;
		//			$u = new Empty_orm('insert', $this->data['def']['empty_orm_data_lang']);
		//			//$u->setAttributes(array('ml_key'=>$k,'label_key'=>$label_key,'value'=>$v));
		//			$u->ml_key = $k;
		//			$u->label_key = $label_key;
		//			$u->value = $v;
		//			if(!$u->save()){
		//				G::dbm($u->getErrors());
		//			}
		//		}
		//	}
		//}

		// 匯出實體檔案
		$ml = new Ml2;
		$ml->export();

		if($update['is_delete'] == '1'){
			$ml->delete();
		}

		$themea = G::get_theme_compiler($this->data['theme_name']);
		if($themea == 'smarty'){
			// 清除template compile後的資料，這樣子片語才會正確的在production模式下顯示
			//$this->smarty_parser->clear_compiled_tpl();
			Yii::app()->smarty->clear_compiled_tpl();
		}

	}

	protected function delete_before($array)
	{
		$key = $array['key'];
		$this->cidb->where('label_key', $key);
		$this->cidb->delete('ml_lang');
	}

	protected function delete_last()
	{
		// 匯出實體檔案
		$ml = new Ml2;
		$ml->export();

		$themea = G::get_theme_compiler($this->data['theme_name']);
		if($themea == 'smarty'){
			// 清除template compile後的資料，這樣子片語才會正確的在production模式下顯示
			//$this->smarty_parser->clear_compiled_tpl();
			Yii::app()->smarty->clear_compiled_tpl();
		}
	}

	public function actionGet_use_where()
	{
		// 把這個功能停掉
		if(count($_POST) > 0 and 0){
			if(isset($_POST['label']) and $_POST['label'] == '') return '';
			$label = $_POST['label'];

			// 看一下群組表單有沒有"片語搜尋頁面檢查"這筆資料(而且它必需要停用)
			$query = $this->db->where('name', '片語搜尋頁面檢查')->get('m_formgcommon', '1');
			$compare_result = array();
			if($query->num_rows() <= 0){
				echo '你可以在<a target="_blank" href="/m_formgcommon">群組表單</a>中建一筆名為"片語搜尋頁面檢查"，<br />';
				echo '在"關連表單"中選擇你想要檢查的頁面，核心關連的部份，就建1筆排版是空白的表單。<br />';
				echo '如何提高片語檢查的辯識率：';
				echo '先到<a target="_blank" href="http://www.xml-sitemaps.com">這個網站</a>，輸入網址後按"Start"，';
				echo '然後下載"urllist.txt"的檔案下來，挑那個有編號引數的行(例如商品內頁，或是不要選檢查的頁面，全部貼進來)，';
				echo '貼入新建立的排版分身裡面，然後在表單重新選擇排版，改成你新建立的，並重新整理修改片語的頁面';
				die;
			} else {
				$common_data = $query->row_array();
				$ids = explode(',', $common_data['ids']);
				if(count($ids) > 0){
					foreach($ids as $k => $v){
						if($v == '') continue;
						$arr_tmp = file_get_contents('http://'.$this->data['host']['web_url'].'/formg/mls/'.$v);
						$arr_tmp_check = str_replace('$xxx__xxx', '$page_mls', trim($arr_tmp));
						if(!preg_match('/\$page_mls/', $arr_tmp_check)){
							continue;
						}
						$page_mls = array();
						/*
						 * $xxx__xxx = array (
						 * 0 => 
						 * array (
						 *   'label' => 'English',
						 *   'label_lang' => '英文',
						 *   'section' => '2',
						 *   'field_id' => '44',
						 *   'field_type' => 'searchbar',
						 * ),
						 * .......
						 */
						$eval_string = $arr_tmp_check.';';
						//echo $eval_string;
						//die;
						eval($eval_string);
						if(count($page_mls) > 0){
							foreach($page_mls as $kk => $vv){
								if($label == $vv['label']){
									$compare_result[$v][$vv['field_id']] = $vv;
								}
							}
						}
					}
				}
				// 看一下有沒有使用提高辯識率的清單功能
				$form_id = $common_data['form_id'];
				// 5代表noframe
				$form_html_source = file_get_contents('http://'.$this->data['host']['web_url'].'/formg/index/'.$form_id.'/5');
				if(strip_tags($form_html_source) == $form_html_source){
					$url_item = explode("\n", trim($form_html_source));
					if(count($url_item) > 0){
						foreach($url_item as $k => $v){
							/*
							 * HTTP/1.1 200 OK
							 * Date: Sat, 13 Oct 2012 13:54:16 GMT
							 * Server: Apache
							 * X-Powered-By: PHP/5.2.17
							 * Set-Cookie: PHPSESSID=3jh7252dib6i059fgb22u7v976; path=/
							 * Expires: Thu, 19 Nov 1981 08:52:00 GMT
							 * Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
							 * Pragma: no-cache
							 * formg_id: 23 (這才是我要的)
							 * formg_ml: tw (這才是我要的)
							 * formg_param: root_43 (這才是我要的)
							 * Connection: close
							 * Content-Type: text/html; charset=UTF-8
							 */
							$ch = curl_init($v);
							curl_setopt($ch, CURLOPT_HEADER, 1);
							curl_setopt($ch, CURLOPT_NOBODY, 1);
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
							ob_start();
							$c = curl_exec($ch);
							$headers_tmp = ob_get_contents();
							ob_end_clean();
							if($headers_tmp){
								$headers = explode("\n", $headers_tmp);
								$formgs = array();
								if(count($headers) > 0){
									foreach($headers as $kk => $vv){
										if(preg_match('/^formg_(.*): (.*)$/', $vv, $matches)){
											$formgs[$matches[1]] = trim($matches[2]);
										}
									}
								}
								// form_id是必要的條件
								if(!isset($formgs['id']) or $formgs['id'] == '') continue;
								if(!isset($formgs['ml'])){
									$formgs['ml'] = '';
								}
								if($formgs['ml'] != ''){
									$formgs['ml'] = '/'.$formgs['ml'];
								}
								// 重組URL
								$url = 'http://'.$this->data['host']['web_url'].$formgs['ml'].'/formg/mls/'.$formgs['id'].'/1';
								if(isset($formgs['param']) and $formgs['param'] != ''){
									$url .= '/_empty/0/0/'.$formgs['param'];
								}
								//echo $url;
								//die;
								$arr_tmp = file_get_contents($url);
								$arr_tmp_check = str_replace('$xxx__xxx', '$page_mls', trim($arr_tmp));
								if(!preg_match('/\$page_mls/', $arr_tmp_check)){
									continue;
								}
								$page_mls = array();
								/*
								 * $xxx__xxx = array (
								 * 0 => 
								 * array (
								 *   'label' => 'English',
								 *   'label_lang' => '英文',
								 *   'section' => '2',
								 *   'field_id' => '44',
								 *   'field_type' => 'searchbar',
								 * ),
								 * .......
								 */
								$eval_string = $arr_tmp_check.';';
								//echo $eval_string;
								//die;
								eval($eval_string);
								if(count($page_mls) > 0){
									foreach($page_mls as $kk => $vv){
										if($label == $vv['label']){
											$compare_result[$formgs['id']][$vv['field_id']] = $vv;
										}
									}
								}
							}
						}
					}
				}
			}

			// 重組html
			$return = '';
			if(count($compare_result) <= 0){
				echo '目前還沒有地方有用到這個片語(應該)';
			} else {
				// 取得所有的表單資料，等一下要做參考所使用
				$query = $this->db->select('id, name')->where('is_enable', '1')->get('m_formg');
				$formg_tmp = array();
				foreach($query->result_array() as $row){
					$formg_tmp[$row['id']] = $row['name'];
				}	

				// 取得欄位的key與名稱的對應
				$this->load->library('M_formglib', null, 'mformglib');
				$fields = $this->mformglib->_getFields('0');

				foreach($compare_result as $k => $v){
					$return .= '■ 表單 - <a target="_blank" href="/m_formg/create/'.$k.'">'.$formg_tmp[$k].'</a> ('.count($v).'筆)<br />'."\n";
					foreach($v as $kk => $vv){
						$return .= '&nbsp;&nbsp;';
						if(isset($vv['section'])){
							$return .= ' / 區塊'.($vv['section']+1);
						}
						if(isset($vv['field_id'])){
							$return .= ' / <a target="_blank" href="/m_formg/field/'.$vv['field_id'].'">欄位</a>';
							if(isset($fields[$vv['field_type']]['attr']['name'])){
								$return .= ' ('.$fields[$vv['field_type']]['attr']['name'].')';
							}
						}
						$return .= '<br />'."\n";
					}
					$return .= '<br />'."\n";
				}
			}

			echo $return;
			die;
		}

		$return = 'none';
		if(count($_POST) > 0){
			echo $return;
			die;
		}
	}

	public function actionExport()
	{
		$ml = new Ml2;
		//$this->load->library('Ml2', '', 'ml');
		$text = $ml->export_txt();

        //$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/file.txt";
		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		header("Cache-Control: public"); // needed for i.e.
		header("Content-Type: text/plain");
		//header("Content-Transfer-Encoding: Binary");
		header("Content-Length:".strlen($text));
		header("Content-Disposition: attachment; filename=file.txt");
		echo $text;
		//readfile($attachment_location);
		die();        

        //if (file_exists($attachment_location)) {
        //} else {
		//	show_404();
        //    //die("Error: File not found.");
        //} 
	}

	public function actionImport($param = '')
	{
		if(empty($_POST)){
			$parameter = new Parameter_handle;
			$params = $parameter->get($param);
			$param_define = $parameter->getDefine();

			$this->data['id'] = '';
			$this->data['updatecontent'] = array();
			$this->data['def'] = $this->def;

			$this->data['def']['updatefield']['sections'][0]['field'] = array();
			$this->data['def']['updatefield']['sections'][1]['field'] = array();
			$this->data['def']['updatefield']['sections'][1]['field']['upload_label'] = array(
				'label' => '上傳片語檔',
				'type' => 'file',
				'attr' => array(
					'id' => 'upload_label',
					'name' => 'upload_label',
				),
			);

			$this->data['def']['updatefield']['sections'][1]['field']['xxx01'] = array(
				'label' => '檔案文字範例',
				'type' => '',
			);

			$this->data['def']['updatefield']['sections'][1]['field']['xxx02'] = array(
				'label' => '注意說明事項',
				'type' => '',
			);

			$this->data['def']['updatefield']['sections'][1]['field']['xxx0x_br'] = array(
				'label' => '',
				'type' => '',
			);

			$this->data['updatecontent']['xxx01'] = '
				<div>
					, <span style="color:#0000FF">(第一行，分隔字元)</span>
				</div>
				<div>
					key,tw,ru <span style="color:#0000FF">(第二行是關鍵片語,語系A,語系N..，位置可以互換，但內容也要跟著換哦。從這行開始，底下就是內容了)</span>
				</div>
				<div>
					hello,你好,привет
				</div>
				<div>
					helloxx,你好?,привет?
				</div>
				';

			$this->data['updatecontent']['xxx02'] = '
				<div>
					1. 原本己存在的片語，不會被履蓋
				</div>
				<div>
					2. 片語索引，可以加上 [[xxx01]]_abcdef (其中xxx01是分區片語名稱，底線是空白，abcdef是片語索引)
				</div>
				<div>
					3. 分區片語，是不會輸出 [[xxx01]] 的字眼出來，在你沒有填當下語系輸出的時候
				</div>
				';

			$this->data['main_content'] = '/default/update';
			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
			$this->data['params'] = $params;
			//$this->smarty_parser->parse($this->smarty_htm_exists('index.htm'), $this->data);
			$this->display('index.htm', $this->data);
		} else {
			$update = $_POST;

			$return = '';
			//$url = $this->base64url->decode($update['update_base64_url']);
			$url = '/label/import';
			$return .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "tw";</script>';
			if( $this->data['is_public'] == '0'){
				$return .= '<script type="text/javascript" src="'.$this->data['base_url'].'/'.$this->data['tmp_path'].'/language.js"></script>';
			} else {
				$return .= '<script type="text/javascript" src="'.$this->data['base_url'].'/langc/language.js"></script>';
			}

			$texts = array();
			if(isset($_FILES) and count($_FILES) > 0){
				//var_dump($_FILES);
				foreach($_FILES as $kk => $vv){
					$copy_source = $_FILES[$kk]['tmp_name'];
					if(file_exists($copy_source)){
						$texts = file($copy_source);
						break;
					} // file exists
				}
			}
			if(count($texts) <= 2){
				$return .= '<script>alert("不好意思，我沒有看到你要匯入的內容");window.location.href="'.$url.'";</script>';
				echo $return;
				die;
			}

			$split = trim($texts[0]);
			$keys = explode($split, $texts[1]);
			unset($texts[0]);
			unset($texts[1]);

			$this->load->library('Ml2', '', 'ml');
			$this->ml->import($keys, $texts, $split);
			$this->ml->export();

			$themea = G::get_theme_compiler($this->data['theme_name']);
			if($themea == 'smarty'){
				// 清除template compile後的資料，這樣子片語才會正確的在production模式下顯示
				//$this->smarty_parser->clear_compiled_tpl();
				Yii::app()->smarty->clear_compiled_tpl();
			}

			$sys_log_msg = 'import ml, count:'.count($texts);

			//$this->load->library('sys_log');
			//$this->sys_log->set($sys_log_msg);
			sys_log::set($sys_log_msg);

			$return .= '<script>alert("匯入成功");window.location.href="'.$url.'";</script>';
			echo $return;
			die;
		}
	} // index

}

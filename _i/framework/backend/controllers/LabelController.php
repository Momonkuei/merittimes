<?php

class LabelController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		//'disable_action' => false,
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
			//'smarty_include_top' => 'label/main_content_top.htm',
			'smarty_include_top' => '',
		),
		// 建立前端要顯示的欄位
		'listfield' => array(
			// 'xxx01' => array(
			// 	'label' => '&nbsp;',
			// 	'width' => '7%',
			// 	'ezdelete' => true,
			// ),
			// 'value' => array(
			// 	'label' => '中文',
			// 	'width' => '20%',
			// 	'sort' => false,
			// ),
			'key' => array(
				//'label' => 'ml:Label Index',
				'label' => '片語索引',
				//'mlabel' => array(
				//	null, // category
				//	'Label Index', // label
				//	array(), // sprintf
				//	'片語索引', // default
				//),
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
		'searchfield' => array(
			'advanced_title' => '進階搜尋',
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
						'ggg' => array(
							'label' => '片語類別',
							'type' => 'select3',
							'attr' => array(
								'id' => 'ggg',
								'name' => 'ggg',
							),
							'other' => array(
								// 'values' => array(
								// 	'-1' => '請選擇',
								// 	'2016-08' => '2016年8月份',
								// 	'2016-09' => '2016年9月份',
								// 	'2016-10' => '2016年10月份',
								// 	'2016-11' => '2016年11月份',
								// 	'2016-12' => '2016年12月份',
								// ),
								'values' => array(
									'-1' => '請選擇',
								),
								'default' => '',
							),
						),
						'key' => array(
							'label' => '片語',
							'type' => 'input',
							'merge' => 1,
							'attr' => array(
								'id' => 'key',
								'name' => 'key',
								'size' => '10',
							),
							'other' => array(
								'html_start' => '索引',
								'html_end' => '，',
							),
						),
						'label_lang' => array(
							'label' => '值',
							'type' => 'input',
							'merge' => 3,
							'attr' => array(
								'id' => 'label_lang',
								'name' => 'label_lang',
								'size' => '10',
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
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 如果子站沒有search_data的欄位，那就取消片語值的搜尋功能，不然保證報報報錯
		if(!$this->cidb->field_exists('search_data', 'ml_label')){
			unset($this->def['searchfield']['sections'][0]['field']['label_lang']);

			unset($this->def['searchfield']['sections'][0]['field']['key']['merge']);
			$this->def['searchfield']['sections'][0]['field']['key']['other']['html_end'] = '';
		}

		//
		$rows = $this->db->createCommand()->from('ml_label')->queryAll();
		$rows_tmp = array();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				if(preg_match('/^\[\[(.*)\]\]\ /', $v['key'], $matches)){
					$rows_tmp[$matches[1]] = '1';
				}
			}
		}
		if(count($rows_tmp) > 0){
			ksort($rows_tmp);
			foreach($rows_tmp as $k => $v){
				$this->def['searchfield']['sections'][0]['field']['ggg']['other']['values'][$k] = $k;
			}
		}

		$this->def['searchfield']['smarty_javascript_text'] = <<<XXX0

$('.row_details_open').attr('style','display:none');
$('.row-details').click(function(){
	var click_id = $(this).attr('id');
	var tmps = click_id.split('_');
	if($(this).attr('class') == 'row-details row-details-open'){
		$(this).attr('class', 'row-details row-details-close');
	} else {
		$(this).attr('class', 'row-details row-details-open');
	}
	$('#row_details_open_'+tmps[2]).toggle();
});

XXX0;

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['ggg'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		//$condition = ' type=\'edm\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition = ' 1 ';
		//$condition_sortable = ' type="edm" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'ggg' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'label_lang'){

					$langs = $this->db->createCommand()->from('ml_lang')->queryAll();
					$langs_tmp = array();
					if($langs and count($langs) > 0){
						foreach($langs as $kk => $vv){
							$langs_tmp[$vv['label_key']][$vv['ml_key']] = $vv['value'];
						}
					}

					$labels = $this->db->createCommand()->from('ml_label')->queryAll();
					foreach($labels as $kk => $vv){

						$search_data = '';

						if(isset($langs_tmp[$vv['key']]) and is_array($langs_tmp[$vv['key']])){
							foreach($langs_tmp[$vv['key']] as $kkk => $vvv){
								$search_data .= strip_tags($vvv).',';
							}
						}

						$update = array(
							'search_data' => $search_data,
						);

						// 一筆一筆更新
						$this->cidb->where('id',$vv['id'])->update('ml_label', $update); 
					}

					$conditions[] = 'search_data LIKE \'%'.$v.'%\'';
				} elseif($k == 'month'){
					$conditions[] = 'start_date LIKE \''.$v.'%\'';
				} elseif($k == 'key'){
					$conditions[] = '`'.$k.'` LIKE \'%'.$v.'%\'';
				} elseif($k == 'ggg'){
					$conditions[] = '`key` LIKE \'[['.$v.']]%\'';
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

		return true;

	}

	protected function index_last()
	{   
		if(count($this->data['listcontent']) > 0){
			foreach($this->data['listcontent'] as $k => $v){
				$langs = $this->db->createCommand()->from('ml_lang')->where('`label_key`=:key',array(':key'=>$v['key']))->queryAll();
				$this->data['langs'] = $langs;
				if(count($this->data['langs']) > 0){
					$this->data['listcontent'][$k]['key'] .= ' <span id="row_details_'.$v['id'].'" class="row-details row-details-close"></span>';
				}
				$this->data['listcontent_row_details_open'][$v['id']] = $this->renderPartial('//label/sub', $this->data, true);
			}
		}
	}

	protected function update_show_last($updatecontent)
	{
		$langs = array();

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

		// 匯出實體檔案
		$ml = new Ml2;
		$ml->export();

		if($update['is_delete'] == '1'){
			$ml->delete();
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
	}

}

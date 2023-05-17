<?php

// 檢查是否有funcfieldv3標示的sections

$this->data['funcfieldv3_prefix'] = 'funcfieldv3__'.$this->data['router_class'].'__'.$this->def['table'];
$this->data['funcfieldv3_table_fields'] = $this->cidb->list_fields($this->def['table']);

// 2018-06-25 排序功能需要的兩個變數
$_SESSION['funcfieldv3_router_class'] = $this->data['router_class'];
$_SESSION['funcfieldv3_table'] = $this->def['table'];

$this->data['funcfieldv3_table_fields_data'] = array(); // 欄位的型態和長度
$tmps2 = $this->cidb->field_data($this->def['table']); 
if($tmps2 and !empty($tmps2)){
	foreach($tmps2 as $k => $v){
		$this->data['funcfieldv3_table_fields_data'][$v->name] = $v;
	}
}

// 雖然內頁應該不會去看列表的欄位，不過這邊還是讓它能執行，為了後續的擴充
// if($this->data['router_method'] == 'index'){
	$this->data['funcfieldv3_index_fields_tmp'] = array(); // 把列表所有的欄位抓進來，等一下會一一檢查，如果己有使用的，之後就不會納進來
	$tmp = $this->def['listfield'];
	foreach($tmp as $k => $v){
		$this->data['funcfieldv3_index_fields_tmp'][$k] = 1;
	}

	// funcfieldv3取得資料表欄位，並且將列表頁己使用的欄位給拿掉
	$this->data['funcfieldv3_index_canuse_fields'] = $this->data['funcfieldv3_table_fields'];
	foreach($this->data['funcfieldv3_index_canuse_fields'] as $k => $v){
		if(isset($this->data['funcfieldv3_index_fields_tmp'][$v])){
			unset($this->data['funcfieldv3_index_canuse_fields'][$k]);
		}
		// 排除start_date和sort_id，是因為那個我會自己附加上去，因為程式裡面會自行跟隨判斷要或不要那兩個欄位
		// 而排除is_enable，是因為它一定會有
		if(preg_match('/^(id|ml_key|pic1|is_enable|start_date|sort_id)$/', $v) or ($this->def['table'] == 'html' and $v == 'type') ){
			unset($this->data['funcfieldv3_index_canuse_fields'][$k]);
		}
	}
	// var_dump($this->data['funcfieldv3_index_canuse_fields']);

	// 目的是要把funcfieldv3產出的東西，放到listfield的中間
	$funcfieldv3_index_sections = array();
	$funcfieldv3_index_sections_counter = 0;
	foreach($this->def['listfield'] as $k => $v){
		if(preg_match('/^funcfieldv3_split_/', $k)){
			unset($this->def['listfield'][$k]);
			$funcfieldv3_index_sections_counter++;
		} else {
			if($funcfieldv3_index_sections_counter == 0){
				continue;
			}
			if(!isset($funcfieldv3_index_sections[$funcfieldv3_index_sections_counter])){
				$funcfieldv3_index_sections[$funcfieldv3_index_sections_counter] = array();
			}
			$funcfieldv3_index_sections[$funcfieldv3_index_sections_counter][$k] = $v;
			unset($this->def['listfield'][$k]);
		}
	}
	// var_dump($funcfieldv3_index_sections);die;

	if(!empty($this->data['funcfieldv3_index_canuse_fields'])){
		// 取得funcfieldv3欄位的資料，準備建立列表的實體欄位
		$rows = $this->cidb->where('is_enable',1)->where('type',$this->data['funcfieldv3_prefix'])->where('other1 !='/*欄位英文名稱*/,'')->where('other8'/*列表欄位開關*/,'1')->order_by('other11','asc')->get('html')->result_array();
		if($rows){
			foreach($rows as $k => $v){

				// 必需要是可用的欄位才會render
				if(!in_array($v['other1'], $this->data['funcfieldv3_index_canuse_fields'])){
					continue;
				}

				// trim，主要是針對json類型的欄位
				foreach(array('other10') as $vv){
					$v[$vv] = trim($v[$vv]);
				}

				$this->def['listfield'][$v['other1']] = array(
					'label' => $v['other9'],
					/* 範例
					//'label' => '標題',
					'mlabel' => array(
						null, // category
						'Title', // label
						array(), // sprintf
						'標題', // default
					),
					'width' => '60%',
					'sort' => true,
					 */
				);

				if($v['other10'] != ''){
					$array_other = $this->string_to_json_decode_to_array($v['other10']);
					if(!$array_other){
						// 因為這個是主要的屬性，所以不能有錯誤
						unset($this->def['listfield'][$v['other1']]);
						continue;
					}
					foreach($array_other as $kk => $vv){
						$this->def['listfield'][$v['other1']][$kk] = $vv;
					}
				}
			}
		}
	} // count funcfieldv3_index_canuse_fields

	if(!empty($funcfieldv3_index_sections)){
		foreach($funcfieldv3_index_sections as $k => $v){
			foreach($v as $kk => $vv){
				$this->def['listfield'][$kk] = $vv;
			}
		}
	}

	// 這三個欄位會自動附加上去，其中兩個欄位，會經由程式的判斷，來決定要顯示哪一個欄位
	// $this->def['listfield']['is_enable'] = array(
	// 	//'label' => 'ml:Status',
	// 	'mlabel' => array(
	// 		null, // category
	// 		'Status', // label
	// 		array(), // sprintf
	// 		'狀態', // default
	// 	),
	// 	'width' => '10%',
	// 	'align' => 'center',
	// 	'ezshow' => true,
	// );
	// $this->def['listfield']['start_date'] = array(
	// 	//'label' => '日期',
	// 	'mlabel' => array(
	// 		null, // category
	// 		'Date', // label
	// 		array(), // sprintf
	// 		'日期', // default
	// 	),
	// 	'width' => '15%',
	// 	'sort' => true,
	// );
	// $this->def['listfield']['sort_id'] = array(
	// 	'label' => 'ml:Sort id',
	// 	'width' => '10%',
	// 	'align' => 'center',
	// 	'sort' => true,
	// );
//}

// 內頁區塊處理程序，因為列表的某些欄位，會看內頁的動態欄位，所以這裡讓它可以在列表也會執行
//if($this->data['router_method'] == 'update' or $this->data['router_method'] == 'create'){
	$this->data['funcfieldv3_position_result'] = 0;
	$this->data['funcfieldv3_position_custom'] = 0;

	$this->data['funcfieldv3_fields_tmp'] = array(); // 把內頁所有的欄位抓進來，等一下會一一檢查，如果己有使用的，之後就不會納進來
	$tmp = $this->def['updatefield']['sections'];
	foreach($tmp as $k => $v){
		foreach($v as $kk => $vv){
			if($kk == '_has_funcfieldv3_result' and $vv === true and $this->data['funcfieldv3_position_result'] <= 0){
				$this->data['funcfieldv3_position_result'] = $k;
			}
			if($kk == '_has_funcfieldv3_custom' and $vv === true and $this->data['funcfieldv3_position_custom'] <= 0){
				$this->data['funcfieldv3_position_custom'] = $k;
			}
			if($kk == 'field'){
				foreach($vv as $kkk => $vvv){
					$this->data['funcfieldv3_fields_tmp'][$kkk] = 1;
				}
			}
		}
	}
	//var_dump($this->data['funcfieldv3_fields_tmp']);die;

	// funcfieldv3取得資料表欄位，並且將內頁己使用的欄位給拿掉
	$this->data['funcfieldv3_canuse_fields'] = $this->data['funcfieldv3_table_fields'];
	foreach($this->data['funcfieldv3_canuse_fields'] as $k => $v){
		if(isset($this->data['funcfieldv3_fields_tmp'][$v])){
			unset($this->data['funcfieldv3_canuse_fields'][$k]);
		}
		if(preg_match('/^(id|ml_key)$/', $v) or ($this->def['table'] == 'html' and $v == 'type') ){
			unset($this->data['funcfieldv3_canuse_fields'][$k]);
		}
	}
	// sort($funcfieldv3_canuse_fields);
	// var_dump($funcfieldv3_table_fields);die;
	// var_dump($funcfieldv3_canuse_fields);die;

	if(!empty($this->data['funcfieldv3_canuse_fields'])){

		// 建立資料欄位 (此時還沒有資料，而且是未啟用的非實體欄位)
		if(preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',') and $this->data['router_method'] == 'update'){
			$field = $this->data['funcfieldv3_prefix'].'__section_description__';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx90'] = array(
				'label' => '&nbsp;',
				'type' => 'button',
				'attr' => array(
					'type' => 'submit',
					'class' => 'btn green',
					'label' => '送出',
					//'i' => 'icon-ok',
				),
			);
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx91'] = array(
				'label' => '後台功能欄位：',
				'type' => 'inputn',
				'other' => array(
					'html' => '',
				),
			);

			foreach($this->data['funcfieldv3_canuse_fields'] as $k => $v){
				$field = $this->data['funcfieldv3_prefix'].'__'.$v.'__';
				$ggg = $this->data['funcfieldv3_table_fields_data'][$v];
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other7'] = array(
					'label' => '<b>'.$v.'</b> ('.$ggg->type.' '.$ggg->max_length.')',
					//'label' => '<b>'.$v.'</b>',
					'type' => 'checkbox',
					//'merge' => '1',
					'attr' => array(
						'name' => $field.'other7',
						//'type' => 'checkbox',
						'value' => '1',
					),
					'other' => array(
						'html_start' => '<a id="funcfieldv3_'.$v.'"></a>',
						'html_end' => '內頁啟用　',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'topic'] = array(
					'label' => '&nbsp;',
					'type' => 'input',
					'merge' => 1,
					'attr' => array(
						'id' => $field.'topic',
						'name' => $field.'topic',
						'size' => '8',
					),
					'other' => array(
						'html_start' => '　　名稱：',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other2'] = array(
					'label' => '&nbsp;',
					'type' => 'input',
					'merge' => 2,
					'attr' => array(
						'id' => $field.'other2',
						'name' => $field.'other2',
						'size' => '40',
					),
					'other' => array(
						'html_start' => '本身屬性：',
						//'html_end' => '( json )',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other6'] = array(
					'label' => '&nbsp;',
					'type' => 'select3',
					'merge' => 2,
					'attr' => array(
						'id' => $field.'other6',
						'name' => $field.'other6',
					),
					'other' => array(
						// 'html_start' => '排序編號：',
						//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						//'default' => 'center',
						'values' => array(
							'' => '請選擇',
							'label' => 'Label標籤 (label)',
							'input' => '文字欄位 (input)',
							'tag_input' => '標籤文字欄位 (input)',
							'select3' => '單選 (select3)',
							'multi-select' => '複選 (multi-select)',
							'datepicker' => '日期視窗 (datepicker)',
							'fileuploader' => '單檔上傳 (fileuploader)',
							'kcfinder_school' => '多檔上傳 (kcfinder_school)',
							'textarea' => '多行文字欄位 (textarea)',
							'ckeditor_js' => '編輯器 (ckeditor_js)',
							'ckeditor_child_js' => '編輯器(本地) (ckeditor_child_js)',
							// 'status' => '狀態radio (status)',
							'status2' => '通用radio (status2)',
							'checkbox' => '☑ checkbox (checkbox)',							
							'sort' => '排序 (sort)',
						),
						'default' => '',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'sort_id'] = array(
					'label' => '&nbsp;',
					'type' => 'select3',
					'merge' => 3,
					'attr' => array(
						'id' => $field.'sort_id',
						'name' => $field.'sort_id',
					),
					'other' => array(
						'html_start' => '順序：',
						//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						//'default' => 'center',
						'values' => array(
							'0' => '請選擇',
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
							'9' => '9',
							'10' => '10',
							'11' => '11',
							'12' => '12',
							'13' => '13',
							'14' => '14',
							'15' => '15',
							'16' => '16',
							'17' => '17',
							'18' => '18',
							'19' => '19',
							'20' => '20',
							'21' => '21',
							'22' => '22',
							'23' => '23',
							'24' => '24',
							'25' => '25',
							'26' => '26',
							'27' => '27',
							'28' => '28',
							'29' => '29',
							'30' => '30',
							'31' => '31',
							'32' => '32',
							'33' => '33',
							'34' => '34',
							'35' => '35',
						),
						'default' => '0',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other6readme'] = array(
					'label' => '&nbsp;',
					'type' => 'label',
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other3'] = array(
					'label' => '&nbsp;',
					'type' => 'input',
					'merge' => 1,
					'attr' => array(
						'id' => $field.'other3',
						'name' => $field.'other3',
						'size' => '40',
					),
					'other' => array(
						'html_start' => '　　html屬性：',
						// 'html_end' => '( json )',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other5'] = array(
					'label' => '&nbsp;',
					'type' => 'checkbox',
					'merge' => '2',
					'attr' => array(
						'name' => $field.'other5',
						//'type' => 'checkbox',
						'value' => '1',
					),
					'other' => array(
						//'no_value' => '0',
						'html_end' => '補上id和name　',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other13'] = array(
					'label' => '&nbsp;',
					'type' => 'checkbox',
					'merge' => '2',
					'attr' => array(
						'name' => $field.'other13',
						//'type' => 'checkbox',
						'value' => '1',
					),
					'other' => array(
						'html_end' => '必填　',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other14'] = array(
					'label' => '&nbsp;',
					'type' => 'checkbox',
					'merge' => '2',
					'attr' => array(
						'name' => $field.'other14',
						//'type' => 'checkbox',
						'value' => '1',
					),
					'other' => array(
						'html_end' => '只能整數　',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other15'] = array(
					'label' => '&nbsp;',
					'type' => 'checkbox',
					'merge' => '2',
					'attr' => array(
						'name' => $field.'other15',
						//'type' => 'checkbox',
						'value' => '1',
					),
					'other' => array(
						'html_end' => '符合Email格式　',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other17'] = array(
					'label' => '&nbsp;',
					'type' => 'checkbox',
					'merge' => '3',
					'attr' => array(
						'name' => $field.'other17',
						//'type' => 'checkbox',
						'value' => '1',
					),
					'other' => array(
						'html_end' => 'Datepicker　',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other4'] = array(
					'label' => '&nbsp;',
					'type' => 'input',
					'attr' => array(
						'id' => $field.'other4',
						'name' => $field.'other4',
						'size' => '100',
					),
					'other' => array(
						'html_start' => '　　其它屬性：',
						//'html_end' => '( json )',
					),
				); 
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other16'] = array(
					'label' => '&nbsp;',
					'type' => 'status2',
					'attr' => array(
						'id' => $field.'other16',
						'name' => $field.'other16',
					),
					'other' => array(
						'default'=>'',
						'values' => array(
							'' => '略過或預設',
							'input' => '文字欄位',
							'select' => '下拉單選',
							'radio' => '單選圓鈕',
							'textarea' => '多行文字框',
						),
						'html_start' => '　　前台欄位：',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other8'] = array(
					'label' => '&nbsp;',
					'type' => 'checkbox',
					'merge' => '1',
					'attr' => array(
						'name' => $field.'other8',
						//'type' => 'checkbox',
						'value' => '1',
					),
					'other' => array(
						'html_end' => '列表啟用　',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other9'] = array(
					'label' => '&nbsp;',
					'type' => 'input',
					'merge' => 2,
					'attr' => array(
						'id' => $field.'other9',
						'name' => $field.'other9',
						'size' => '8',
						'placeholder' => '名稱',
					),
					'other' => array(
						//'html_start' => '　　名稱：',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other10'] = array(
					'label' => '&nbsp;',
					'type' => 'input',
					'merge' => 2,
					'attr' => array(
						'id' => $field.'other10',
						'name' => $field.'other10',
						'size' => '40',
						'placeholder' => '屬性',
					),
					'other' => array(
						//'html_start' => '本身屬性：',
						//'html_end' => '( json )',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other12'] = array(
					'label' => '&nbsp;',
					'type' => 'select3',
					'merge' => 2,
					'attr' => array(
						'id' => $field.'other12',
						'name' => $field.'other12',
					),
					'other' => array(
						// 'html_start' => '排序編號：',
						//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						//'default' => 'center',
						'values' => array(
							'' => '請選擇',
							'normal' => '一般',
							'picture' => '小圖',
							'check_the_box' => '勾選 ☑', // ex: is_home
							'node' => '子節點└',
							'status' => '狀態 ☑', // ex: is_enable
							'sort' => '排序',
						),
						'default' => '',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other11'] = array(
					'label' => '&nbsp;',
					'type' => 'select3',
					'merge' => 3,
					'attr' => array(
						'id' => $field.'other11',
						'name' => $field.'other11',
					),
					'other' => array(
						'html_start' => '順序：',
						//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						//'default' => 'center',
						'values' => array(
							'0' => '請選擇',
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
							'9' => '9',
							'10' => '10',
							'11' => '11',
							'12' => '12',
							'13' => '13',
							'14' => '14',
							'15' => '15',
							'16' => '16',
							'17' => '17',
							'18' => '18',
							'19' => '19',
							'20' => '20',
							'21' => '21',
							'22' => '22',
							'23' => '23',
							'24' => '24',
							'25' => '25',
							'26' => '26',
							'27' => '27',
							'28' => '28',
							'29' => '29',
							'30' => '30',
							'31' => '31',
							'32' => '32',
							'33' => '33',
							'34' => '34',
							'35' => '35',
							'36' => '36',
							'37' => '37',
							'38' => '38',
							'39' => '39',
							'40' => '40',
						),
						'default' => '0',
					),
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other12readme'] = array(
					'label' => '&nbsp;',
					'type' => 'label',
				);
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx999'] = array(
					'label' => '&nbsp;',
					'type' => 'inputn',
					'other' => array(
						// sample
						// 'html' => '<button class="btn blue btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#\';return false;">Right</button>',
						'html' => '',
					),
				);

				// 2018-08-08 為了方便切換，以及了解現有的欄位的使用狀況
				foreach($this->data['funcfieldv3_canuse_fields'] as $kk => $vv){
					$fieldg = $this->data['funcfieldv3_prefix'].'__'.$vv;
					$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx999']['other']['html'] .= '<button class="btn btn-default '.$fieldg.'__xx999" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_'.$vv.'\';return false;">'.$vv.'</button>';
				}

				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx999']['other']['html'] .= '<br />';
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx999']['other']['html'] .= '<button class="btn btn-success" data-container="body" data-placement="right" onclick="window.location.href=\'#\';return false;">置頂</button>';
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx999']['other']['html'] .= '<button class="btn btn-primary" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_sort\';return false;">欄位排序</button>';
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx999']['other']['html'] .= '<button class="btn purple" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_copyconditiondata\';return false;">欄位複製</button>';
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx999']['other']['html'] .= '<button class="btn btn-info" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_form\';return false;">表單碼</button>';

			} // funcfieldv3_canuse_fields

			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx92'] = array(
				'label' => '&nbsp;',
				'type' => 'button',
				'attr' => array(
					'type' => 'submit',
					'class' => 'btn green',
					'label' => '送出',
					//'i' => 'icon-ok',
				),
			);

			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx93'] = array(
				'label' => '內頁欄位排序',
				'type' => 'iframe',
				'attr' => array(
					'id' => 'iframe09',
					'width' => '100%',
					'height' => '400px',
					'src' => 'backend.php?r=funcfieldv3sort',
					//'src' => 'index_tw.php?__print_table__=1',
				),
				'other' => array(
					'html_start' => '<a id="funcfieldv3_sort"></a>',
				),
			);

			// 2018-08-08 為了方便切換，以及了解現有的欄位的使用狀況
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx99a'] = array(
				'label' => '&nbsp;',
				'type' => 'inputn',
				'other' => array(
					// sample
					// 'html' => '<button class="btn blue btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#\';return false;">Right</button>',
					'html' => '',
				),
			);
			foreach($this->data['funcfieldv3_canuse_fields'] as $k => $v){
				$fieldg = $this->data['funcfieldv3_prefix'].'__'.$v;
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx99a']['other']['html'] .= '<button class="btn btn-default '.$fieldg.'__xx99a" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_'.$v.'\';return false;">'.$v.'</button>';
			}
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx99a']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#\';return false;">置頂</button>';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx99a']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_sort\';return false;">欄位排序</button>';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx99a']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_copyconditiondata\';return false;">欄位複製</button>';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx99a']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_form\';return false;">表單碼</button>';

			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx94'] = array(
				'label' => '欄位複製',
				'type' => 'iframe',
				'attr' => array(
					'id' => 'iframe10',
					'width' => '100%',
					'height' => '550px',
					'src' => 'backend.php?r=copyconditiondata&table='.$this->def['table'].'刪掉我&field=type&source='.$this->data['funcfieldv3_prefix'].'&dest=funcfieldv3__(功能英文名稱)__'.$this->def['table'],
					//'src' => 'index_tw.php?__print_table__=1',
				),
				'other' => array(
					'html_start' => '<a id="funcfieldv3_copyconditiondata"></a>',
				),
			);

			// 2018-08-08 為了方便切換，以及了解現有的欄位的使用狀況
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx998'] = array(
				'label' => '&nbsp;',
				'type' => 'inputn',
				'other' => array(
					// sample
					// 'html' => '<button class="btn blue btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#\';return false;">Right</button>',
					'html' => '',
				),
			);
			foreach($this->data['funcfieldv3_canuse_fields'] as $k => $v){
				$fieldg = $this->data['funcfieldv3_prefix'].'__'.$v;
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx998']['other']['html'] .= '<button class="btn btn-default '.$fieldg.'__xx998" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_'.$v.'\';return false;">'.$v.'</button>';
			}
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx998']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#\';return false;">置頂</button>';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx998']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_sort\';return false;">欄位排序</button>';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx998']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_copyconditiondata\';return false;">欄位複製</button>';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx998']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_form\';return false;">表單碼</button>';

			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$this->data['funcfieldv3_prefix'].'_form_data'] = array(
				'label' => '表單碼產生',
				'type' => 'label',
				'other' => array(
					'html_start' => '<a id="funcfieldv3_form"></a>',
				),
			);

			// 2018-08-08 為了方便切換，以及了解現有的欄位的使用狀況
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx997'] = array(
				'label' => '&nbsp;',
				'type' => 'inputn',
				'other' => array(
					// sample
					// 'html' => '<button class="btn blue btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#\';return false;">Right</button>',
					'html' => '',
				),
			);
			foreach($this->data['funcfieldv3_canuse_fields'] as $k => $v){
				$fieldg = $this->data['funcfieldv3_prefix'].'__'.$v;
				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx997']['other']['html'] .= '<button class="btn btn-default '.$fieldg.'__xx999" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_'.$v.'\';return false;">'.$v.'</button>';
			}
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx997']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#\';return false;">置頂</button>';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx997']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_sort\';return false;">欄位排序</button>';
			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx997']['other']['html'] .= '<button class="btn btn-default" data-container="body" data-placement="right" onclick="window.location.href=\'#funcfieldv3_form\';return false;">表單碼</button>';

			$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'xx95'] = array(
				'label' => '&nbsp;',
				'type' => 'button',
				'attr' => array(
					'type' => 'submit',
					'class' => 'btn green',
					'label' => '送出',
					//'i' => 'icon-ok',
				),
			);

		}

		// 取得funcfieldv3欄位的資料，準備建立內頁的實體欄位
		$rows = $this->cidb->where('is_enable',1)->where('type',$this->data['funcfieldv3_prefix'])->where('other1 !='/*欄位英文名稱*/,'')->where('other7'/*內頁欄位開關*/,'1')->order_by('sort_id','asc')->get('html')->result_array();
		if($rows){
			foreach($rows as $k => $v){
				// if($v['other1'] == '' or !in_array($v['other1'], $this->data['funcfieldv3_canuse_fields']))

				// 必需要是可用的欄位才會render
				if(!in_array($v['other1'], $this->data['funcfieldv3_canuse_fields'])){
					continue;
				}

				// trim，主要是針對json類型的欄位
				foreach(array('other2','other3','other4','other6') as $vv){
					$v[$vv] = trim($v[$vv]);
				}

				// 2018-06-01 欄位必填與只能數字，李哥早上有允許這個功能的開發 (beta)
				if($v['other13'] == '1'){ // 欄位必填
					$this->def['empty_orm_data']['rules'][] = array($v['other1'],'required');
				}

				if($v['other14'] == '1'){ // 只能數字
					$this->def['empty_orm_data']['rules'][] = array($v['other1'],'numerical','integerOnly'=>true);
				}

				if($v['other15'] == '1'){ // 要符合Email格式
					$this->def['empty_orm_data']['rules'][] = array($v['other1'],'email');
				}

				$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_result']]['field'][$v['other1']] = array(
					'label' => $v['topic'],
					/* 範例
					'type' => 'input',
					'attr' => array(
						'id' => $field.'topic',
						'name' => $field.'topic',
						'size' => '8',
					),
					'other' => array(
						'html_start' => '名稱：',
					),
					 */
				);
				// 2020-08-19
				if(preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
					$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_result']]['field'][$v['other1']]['label'] .= ' <br /><a href="#funcfieldv3_'.$v['other1'].'">(#)</a>';
				}

				if($v['other2'] == '' and $v['other6'] != ''){
					$v['other2'] = 'type:'.$v['other6'];
				}
				if($v['other2'] != ''){
					$array_other = $this->string_to_json_decode_to_array($v['other2']);
					if(!$array_other){
						// 因為這個是主要的屬性，所以不能有錯誤
						unset($this->def['updatefield']['sections'][$this->data['funcfieldv3_position_result']]['field'][$v['other1']]);
						continue;
					}
					foreach($array_other as $kk => $vv){
						$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_result']]['field'][$v['other1']][$kk] = $vv;
					}
				}
				// html屬性
				if($v['other3'] != ''){
					$array_other = $this->string_to_json_decode_to_array($v['other3']);
					if(!$array_other){
						continue;
					}
					$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_result']]['field'][$v['other1']]['attr'] = $array_other;
				}
				// 如果有打勾，那就會自動補id和name的html屬性
				if($v['other5'] > 0){
					$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_result']]['field'][$v['other1']]['attr']['id'] = $v['other1'];
					$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_result']]['field'][$v['other1']]['attr']['name'] = $v['other1'];
				}
				// other屬性
				if($v['other4'] != ''){
					$array_other = $this->string_to_json_decode_to_array($v['other4']);
					if(!$array_other){
						continue;
					}
					$array_other_group = array();
					$array_other_group_check = array();
					foreach($array_other as $kk => $vv){
						// select3、status2、multi-select會用到這個地方
						// 檢查第一個字母是否為大寫，是的話，那它就是該字母的集合，這個集合可以當做其它字項的陣列值，可用的集合為26個大寫字母
						$tmp01 = substr($kk, 0, 1);
						if(strtoupper($tmp01) == $tmp01){ // 如果是大寫
							if(!isset($array_other_group[$tmp01])){
								$array_other_group[$tmp01] = array();
							}

							if(preg_match('/^db__(.*)_(1|0)_(.*)_(.*)$/', $vv, $matches)){ // db__(獨立資料表名，或是通用的type)_(通用１|獨立０)_(key欄位名稱)_(name欄位名稱)
								if($matches[2] == 0 and !$this->cidb->table_exists($matches[1])){ // 檢查資料表是否存在
									continue;
								}
								$o = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key']);
								if($matches[2] == 1){
									$o = $o->where('type',$matches[1]);
								}
								$o = $o->order_by('sort_id','asc');
								if($matches[2] == 1){
									$rows2 = $o->get('html')->result_array();
								} else {
									// 上面一點，會檢查資料表是否存在
									$rows2 = $o->get($matches[1])->result_array();
								}
								if($rows2 and !empty($rows2)){
									foreach($rows2 as $kkk => $vvv){
										if(isset($vvv[$matches[3]]) and isset($vvv[$matches[4]])){
											$array_other_group[$tmp01][$vvv[$matches[3]]] = $vvv[$matches[4]];
										}
									}

									$array_other_group_check[] = $tmp01.$tmp01; // XX
									unset($array_other[$kk]);
								}
							} else {
								$tmp02 = substr($kk, 1); // 取剩下的值
								if($tmp02 == ''){
									$array_other_group[$tmp01][''] = $vv; // 要這樣子寫，才會正常，這算是一個HACK
								} else {
									$array_other_group[$tmp01][$tmp02] = $vv;
								}
								$array_other_group_check[] = $tmp01.$tmp01; // XX
								unset($array_other[$kk]);
							}
						}
					}

					// 判斷陣列值是否為該集合的兩個大寫字母
					foreach($array_other as $kk => $vv){
						$tmps2 = explode('，', $vv); // 全型的逗點，可以讓values，製做出複合式的結果出來，也就是多組的大寫字母
						foreach($tmps2 as $kkk => $vvv){
							if(in_array($vvv, $array_other_group_check)){ // 尋找兩個大寫字母的key值
								// 舊的寫法，是沒有累加的
								// $array_other[$kk] = $array_other_group[substr($vvv,0,1)];
								
								if(is_string($array_other[$kk])){
									$array_other[$kk] = array();
								}
								// 這樣子，是為了要累加
								foreach($array_other_group[substr($vvv,0,1)] as $kkkk => $vvvv){
									$array_other[$kk][$kkkk] = $vvvv;
								}
							}
						}

						if(preg_match('/^(values)$/', $kk) and !is_array($array_other[$kk])){ // 防呆
							$array_other[$kk] = array();
						}
					}

					// var_dump($array_other);

					$this->def['updatefield']['sections'][$this->data['funcfieldv3_position_result']]['field'][$v['other1']]['other'] = $array_other;
				} 
			}
		}

	}
//}

// 如果內頁沒有圖片欄位(1)，那列表也不會有圖片欄位
$tmp = $this->def['updatefield']['sections'];
//var_dump($tmp);die;
$funcfieldv3_has_pic1 = false;
foreach($tmp as $k => $v){
	foreach($v as $kk => $vv){
		if($kk == 'field'){
			foreach($vv as $kkk => $vvv){
				if($kkk == 'pic1'){
					$funcfieldv3_has_pic1 = true;
				}
			}
		}
	}
}
if($funcfieldv3_has_pic1 === false){
	unset($this->def['listfield']['pic1']);
}

// 自動調整一下列表的寬度
$funcfieldv3_index_width_total = 0;
if(isset($this->def['action_width'])){
	$funcfieldv3_index_width_total += str_replace('%','',$this->def['action_width']);
} else {
	$funcfieldv3_index_width_total += 10;
}
foreach($this->def['listfield'] as $k => $v){
	if(isset($v['width']) and $v['width'] != ''){
		$funcfieldv3_index_width_total += str_replace('%','',$v['width']);
	}
}
// echo $funcfieldv3_index_width_total;
if($funcfieldv3_index_width_total < 100){
	if(isset($this->def['listfield']['topic'])){
		$this->def['listfield']['topic']['width'] = (str_replace('%','',$this->def['listfield']['topic']['width']) + (100 - $funcfieldv3_index_width_total)).'%';
	} elseif(isset($this->def['listfield']['name'])){
		$this->def['listfield']['name']['width'] = (str_replace('%','',$this->def['listfield']['name']['width']) + (100 - $funcfieldv3_index_width_total)).'%';
	}
} elseif($funcfieldv3_index_width_total >= 100){
	if(isset($this->def['listfield']['topic'])){
		$this->def['listfield']['topic']['width'] = (str_replace('%','',$this->def['listfield']['topic']['width']) - ($funcfieldv3_index_width_total - 100)).'%';
	} elseif(isset($this->def['listfield']['name'])){
		$this->def['listfield']['name']['width'] = (str_replace('%','',$this->def['listfield']['name']['width']) + ($funcfieldv3_index_width_total - 100)).'%';
	}
}

// var_dump($this->def);die;
// var_dump($this->def['updatefield']);die;

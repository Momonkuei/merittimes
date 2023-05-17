<?php

// 2018-02-21 自動模組處理(auto_module_handle)
// 記得！create_show_last那邊也有
foreach($this->data['def']['updatefield']['sections'] as $k => $v){
	foreach($v['field'] as $kk => $vv){
		if(isset($vv['type'])){
		   	if($vv['type'] == 'kcfinder_school'){
				if(!isset($_auto_module_handle_kcfinder_school_counter)){
					$_auto_module_handle_kcfinder_school_counter = 0;
				}
				$_auto_module_handle_kcfinder_school_counter++;
				$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['school_id'] = $this->data['router_class'].'_'.$_auto_module_handle_kcfinder_school_counter.'_'.$this->data['updatecontent']['id'];
			} elseif($vv['type'] == 'fileuploader'){
				if(!isset($_auto_module_handle_fileuploader_counter)){
					$_auto_module_handle_fileuploader_counter = 0;
				}
				$_auto_module_handle_fileuploader_counter++;
				$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['number'] = $_auto_module_handle_fileuploader_counter;
			} elseif($vv['type'] == 'multi-select'){
				if(isset($this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['values']) and !empty($this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['values'])){
					$this->data['_auto_module_handle_'.$kk] = $this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['values'];

					$tmps33 = explode(',', $this->data['updatecontent'][$kk]);
					if(count($tmps33) == 1 and $tmps33[0] == ''){
						$tmps33 = array();
					}
					$groups = array();
					foreach($this->data['_auto_module_handle_'.$kk] as $kkk => $vvv){
						// if($kkk == $this->data['updatecontent']['id']) continue; // 排除掉自己，不然選到自己跟本就是很奇怪

						$groups[$kkk]['value'] = $vvv;

						if(in_array($kkk, $tmps33)){
							$groups[$kkk]['is_selected'] = 'selected'; // multiselect
							//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
						}
					}
					$this->data['updatecontent'][$kk] = $groups;
				}
			}
		}
		if(isset($vv['other']['funcfieldv3isdatepicker']) and $vv['other']['funcfieldv3isdatepicker'] == '1'){
			$this->data['def']['updatefield']['smarty_javascript_text'] .= '$("#'.$kk.'").datepicker({dateFormat: "yy-mm-dd"});'."\n";
		}
	}
}

// var_dump($this->data['def']['updatefield']['sections']);

// 取得funcfieldv3欄位的資料，有需要就打開 4/5
if(preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){

	// 表單碼產生
	$form_datas = array();
	if(isset($this->data['def']['updatefield']['sections'][0]['field']) and !empty($this->data['def']['updatefield']['sections'][0]['field'])){
		foreach($this->data['def']['updatefield']['sections'][0]['field'] as $k => $v){
			if(isset($v['label']) and !preg_match('/^(ml_key|sort_id|update_time|create_time)$/', $k)){
				$form_datas[] = array(
					$v['label'], $k, 'input',
				);
			}
		}
	}

	// 先把所有可用欄位，只要是select3的都要先有預設值，不然會報錯
	foreach($this->data['funcfieldv3_canuse_fields'] as $k => $v){
		$field = $this->data['funcfieldv3_prefix'].'__'.$v.'__';
		$this->data['updatecontent'][$field.'sort_id'] = 0; // 內頁欄位排序 select3
		$this->data['updatecontent'][$field.'other11'] = 0; // 列表欄位排序 select3
		$this->data['updatecontent'][$field.'other6'] = ''; // 模組下拉 select3
		$this->data['updatecontent'][$field.'other12'] = ''; // 模組下拉 select3
		$this->data['updatecontent'][$field.'other16'] = ''; // frontend field
	}

	// 己有的資料欄位
	$has_detail_ids = array();
	$has_list_ids = array();

	$rows = $this->cidb->where('is_enable',1)->where('type',$this->data['funcfieldv3_prefix'])->order_by('sort_id','asc')->get('html')->result_array();
	if($rows){
		foreach($rows as $k => $v){

			// 表單碼產生
			if($v['other7'] == '1'){
				$topic = $v['topic'];
				if($v['other13'] == '1'){
					$topic .= '*';
				}
				if(preg_match('/^(input|tag_input|select|radio|textarea)$/', $v['other16'])){
					$form_datas[] = array(
						$topic, $v['other1'], $v['other16'],
					);
				} else {
					$form_datas[] = array(
						$topic, $v['other1'], 'input',
					);
				}

				$has_detail_ids[] = $v['other1'];
			}

			if($v['other8'] == '1'){
				$has_list_ids[] = $v['other1'];
			}

			if($v['other7'] == '1' or $v['other8'] == '1'){
				// 2018-08-08 為了方便切換，以及了解現有的欄位的使用狀況
				$fieldg = $this->data['funcfieldv3_prefix'].'__'.$v['other1'];
				$this->data['def']['updatefield']['smarty_javascript_text'] .= '$(".'.$fieldg.'__xx999").addClass("blue");';
			}

			// trim
			foreach(array('other2','other3','other4','other6') as $vv){
				$v[$vv] = trim($v[$vv]);
			}

			$field = $this->data['funcfieldv3_prefix'].'__'.$v['other1'].'__';
			$this->data['updatecontent'][$field.'other7'] = $v['other7']; // 內頁的欄位啟用與否
			$this->data['updatecontent'][$field.'topic'] = $v['topic'];
			$this->data['updatecontent'][$field.'other2'] = $v['other2']; // current attr
			$this->data['updatecontent'][$field.'other3'] = $v['other3']; // html
			$this->data['updatecontent'][$field.'other4'] = $v['other4']; // other
			$this->data['updatecontent'][$field.'other5'] = $v['other5']; // id,name
			$this->data['updatecontent'][$field.'other13'] = $v['other13']; // required
			$this->data['updatecontent'][$field.'other14'] = $v['other14']; // integer only
			$this->data['updatecontent'][$field.'other15'] = $v['other15']; // email format
			$this->data['updatecontent'][$field.'other16'] = $v['other16']; // frontend field
			$this->data['updatecontent'][$field.'other17'] = $v['other17']; // datepicker
			$this->data['updatecontent'][$field.'other6'] = $v['other6']; // html.type
			$this->data['updatecontent'][$field.'sort_id'] = $v['sort_id']; // 內頁欄位排序 select3

			$this->data['updatecontent'][$field.'other8'] = $v['other8']; // 列表的欄位啟用與否
			$this->data['updatecontent'][$field.'other9'] = $v['other9']; // 列表的欄位名稱
			$this->data['updatecontent'][$field.'other10'] = $v['other10']; // 列表的欄位屬性
			$this->data['updatecontent'][$field.'other12'] = $v['other12']; // 列表所使用的模組
			$this->data['updatecontent'][$field.'other11'] = $v['other11']; // 列表欄位排序 select3

			if($v['other8'] == '1' and $v['other10'] == ''){
				// 這裡是要修改的地方 2018-05-22
				// $this->data['updatecontent'][$field.'other10'] = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
				// 	'width' => '10%',
				// 	'align' => 'center',
				// 	'sort' => true,
				// 	'kcfinder_small_img' => false,
				// )))));

				if($v['other12'] == '_ggg_xxx_'){ // 沒有作用
					// do nothing
				} elseif($v['other12'] == 'normal'){ // 一般
					$this->data['updatecontent'][$field.'other10'] = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
						'translate_source' => '', // 如果有填，該片語所屬的語系，那切換介面語系的時候，這個欄位名稱就會跟著切換 2018-05-28
						'width' => '10%',
						'align' => 'center',
						'sort' => true,
					)))));
				} elseif($v['other12'] == 'picture'){ // 小圖
					$this->data['updatecontent'][$field.'other10'] = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
						'translate_source' => '',
						'width' => '10%',
						'align' => 'center',
						//'sort' => false,
						'kcfinder_small_img' => true,
					)))));
				} elseif($v['other12'] == 'check_the_box'){ // 勾選 ☑
					$this->data['updatecontent'][$field.'other10'] = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
						'translate_source' => '',
						'width' => '10%',
						'align' => 'center',
						//'sort' => true,
						'ezfield' => $v['other1'],
						'ezother'=> '&nbsp;',
					)))));
				} elseif($v['other12'] == 'node'){ // 子節點 └
					$this->data['updatecontent'][$field.'other10'] = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
						'translate_source' => '',
						'width' => '10%',
						'align' => 'center',
						'url_id' => 'node',
						'url_id_field' => $v['other1'],
						'url_id_node_child'=> 'child router_class',
						'url_id_node_child_field'=> 'class_id',
					)))));

					// 列表模組說明欄位
					$this->data['updatecontent'][$field.'other12readme'] = <<<XXX
節點就是分項和分項的相依(關連)
也就是說，如果分項裡面如果有多筆，就可以用這個來解

url_id_node_child:{子節點的router_class名稱}
url_id_node_child_field:{子節點存放父節點編號的欄位，預設是class_id}
XXX;
				} elseif($v['other12'] == 'status'){ // 狀態 ☑
					$this->data['updatecontent'][$field.'other10'] = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
						'translate_source' => '',
						'width' => '10%',
						'align' => 'center',
						'ezshow' => true,
					)))));
				} elseif($v['other12'] == 'sort'){ // 排序
					$this->data['updatecontent'][$field.'other10'] = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
						'translate_source' => '',
						'width' => '10%',
						'align' => 'center',
						'sort' => true,
					)))));
				}
			}

			if($v['other2'] == '' and $v['other6'] != ''){
				$v['other2'] = 'type:'.$v['other6'];
			}

			$array_other = $this->string_to_json_decode_to_array($v['other2']);
			if(!$array_other){
				continue;
			}

			if($v['other6'] != ''){
				$array_other['type'] = $v['other6'];
			}

			if(isset($array_other['type'])){
				$html_tmp = '';
				$other_tmp = '';
				if($array_other['type'] == '_ggg_xxx_'){ // 沒有作用
					// do nothing
				} elseif($array_other['type'] == 'label'){
					if($v['other5'] == '0'){
						$this->data['updatecontent'][$field.'other5'] = '1';
					}
				} elseif($array_other['type'] == 'input' or $array_other['type'] == 'tag_input'){
					if($v['other5'] == '0'){
						$this->data['updatecontent'][$field.'other5'] = '1';
					}
					if($v['other3'] == ''){
						$html_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'size' => '40',
						)))));
						if($v['other17'] == '1'){
							$html_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
								'size' => '10',
								'readonly' => 'readonly',
							)))));
						}
					}
					if($v['other4'] == ''){
						if($v['other17'] == '1'){
							$other_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
								'funcfieldv3isdatepicker' => '1', // 要給auto_module_handle去判斷處理用
							),JSON_UNESCAPED_UNICODE)))); // 有中文的情況，json_encode必需要加上JSON_UNESCAPED_UNICODE的參數
						}
					}
				} elseif($array_other['type'] == 'status'){
					if($v['other4'] == ''){
						$other_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'default'=>'1',
						)))));
					}
				} elseif($array_other['type'] == 'status2'){
					if($v['other4'] == ''){
						$other_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'default' => '1',
							'A1' => '啟用',
							'A0' => '停用',
							'B' => 'db__companyx_1_id_topic',
							'C' => 'db__productx_0_id_name',
							'values' => 'AA，BB，CC',
						),JSON_UNESCAPED_UNICODE)))); // 有中文的情況，json_encode必需要加上JSON_UNESCAPED_UNICODE的參數
					}

					// 內頁模組說明欄位
					$this->data['updatecontent'][$field.'other6readme'] = <<<XXX
status2、select3的內頁模組，都是同樣的說明註解

default:{預設值}
{X}{N}:{V}
{X}是群組，可以是A~Z
{N}是數值
{V}是顯示名稱

而數值還有以下的擴充功能規則：
{db|}__{獨立資料表名稱，或是通用資料表的type}_{通用1|獨立0}_{欄位對應數值}_{欄位對應顯示名稱}

values:{如果是群組A，那這裡就是寫成AA，多個群組，請使用全形的逗點分隔}
XXX;
				} elseif($array_other['type'] == 'checkbox'){
					if($v['other3'] == ''){
						$html_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'name' => $v['other1'],
							'type' => 'checkbox',
							'value' => '1',
						)))));
					}
					if($v['other4'] == ''){
						$other_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'html_end' => '是',
							'no_value' => '0', // funcfieldv3專用，沒選的時候，是什麼值
						),JSON_UNESCAPED_UNICODE)))); // 有中文的情況，json_encode必需要加上JSON_UNESCAPED_UNICODE的參數
					}
				} elseif($array_other['type'] == 'fileuploader'){
					if($v['other4'] == ''){
						$other_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '360',
							'height' => '220',
							'comment_size' => '360x220',
							'no_ext' => '',
							'no_need_delete_button' => '',
						)))));
					}

					// 內頁模組說明欄位
					$this->data['updatecontent'][$field.'other6readme'] = <<<XXX
如果是圖片 comment_size:{新圖片尺寸}
如果是檔案 type:document, comment_size:{不要填內容}
其它沒講到的，都不要動
XXX;
				} elseif($array_other['type'] == 'textarea'){
					if($v['other5'] == '0'){
						$this->data['updatecontent'][$field.'other5'] = '1';
					}
					if($v['other3'] == ''){
						$html_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'class' => 'form-control',
							'rows' => '4',
							'cols' => '100',
						)))));
					}
				} elseif($array_other['type'] == 'kcfinder_school'){
					if($v['other3'] == ''){
						$html_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'width' => '700',
							'height' => '400',
						)))));
					}
					if($v['other4'] == ''){
						$other_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'uploadurl_id' => 'assetsdir',
							'type' => 'member',
							//'width' => '400',
							'height' => '170',
							'school_id' => '',
							//'dir' => 'files/public',
						)))));
					}
				} elseif($array_other['type'] == 'ckeditor_js'){
					if($v['other5'] == '0'){
						$this->data['updatecontent'][$field.'other5'] = '1';
					}
				} elseif($array_other['type'] == 'textarea'){
					if($v['other5'] == '0'){
						$this->data['updatecontent'][$field.'other5'] = '1';
					}
					if($v['other3'] == ''){
						$html_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'class' => 'form-control',
							'rows' => '4',
							'cols' => '40',
						)))));
					}
				} elseif($array_other['type'] == 'select3'){
					if($v['other5'] == '0'){
						$this->data['updatecontent'][$field.'other5'] = '1';
					}
					if($v['other4'] == ''){
						$other_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'default' => '0',
							'A0' => '請選擇',
							'B' => 'db__companyx_1_id_topic',
							'C' => 'db__productx_0_id_name',
							'values' => 'AA，BB，CC',
						),JSON_UNESCAPED_UNICODE)))); // 有中文的情況，json_encode必需要加上JSON_UNESCAPED_UNICODE的參數
					}

					// 內頁模組說明欄位
					$this->data['updatecontent'][$field.'other6readme'] = <<<XXX
status2、select3的內頁模組，都是同樣的說明註解

default:{預設值}
{X}{N}:{V}
{X}是群組，可以是A~Z
{N}是數值
{V}是顯示名稱

而數值還有以下的擴充功能規則：
{db|}__{獨立資料表名稱，或是通用資料表的type}_{通用1|獨立0}_{欄位對應數值}_{欄位對應顯示名稱}

values:{如果是群組A，那這裡就是寫成AA，多個群組，請使用全形的逗點分隔}
XXX;
				} elseif($array_other['type'] == 'multi-select'){
					if($v['other3'] == ''){
						$html_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							'id' => $v['other1'],
							'name' => $v['other1'].'[]',
						)))));
					}
					if($v['other4'] == ''){
						$other_tmp = str_replace('{','',str_replace('}','',str_replace('"','',json_encode(array(
							//'default' => '0',
							//'A0' => '請選擇',
							'A' => 'db__companyx_1_id_topic',
							'B' => 'db__productx_0_id_name',
							'values' => 'AA，BB',
						),JSON_UNESCAPED_UNICODE)))); // 有中文的情況，json_encode必需要加上JSON_UNESCAPED_UNICODE的參數
					}

					// 內頁模組說明欄位
					$this->data['updatecontent'][$field.'other6readme'] = <<<XXX
multi-select的註解，跟status2、select3模組有點不太一樣，少了default預設值

{X}{N}:{V}
{X}是群組，可以是A~Z
{N}是數值
{V}是顯示名稱

而數值還有以下的擴充功能規則：
{db|}__{獨立資料表名稱，或是通用資料表的type}_{通用1|獨立0}_{欄位對應數值}_{欄位對應顯示名稱}

values:{如果是群組A，那這裡就是寫成AA，多個群組，請使用全形的逗點分隔}
XXX;

				} elseif($array_other['type'] == 'datepicker'){
					if($v['other5'] == '0'){
						$this->data['updatecontent'][$field.'other5'] = '1';
					}
				} // 模組結束

				if($html_tmp != ''){
					$this->data['updatecontent'][$field.'other3'] = $html_tmp;
				}
				if($other_tmp != ''){
					$this->data['updatecontent'][$field.'other4'] = $other_tmp;
				}
			} // array_other type
		} // foreach
	}

	// 2018-10-26 沒有使用的欄位，不做render設定的欄位群
	foreach($this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'] as $k => $v){
		$tmps = explode('__', $k);

		/*
		 * array(5) {
		 *   [0]=>
		 *   string(11) "funcfieldv3" (prefix)
		 *   [1]=>
		 *   string(7) "company" (router_class)
		 *   [2]=>
		 *   string(4) "html" (table)
		 *   [3]=>
		 *   string(19) "section_description"
		 *   [4]=>
		 *   string(4) "xx90"
		 * }
		 */

		if(isset($tmps[3])){
			if(in_array($tmps[3], $has_detail_ids)){ // 如果有勾內頁啟用
				// do nothing
			} else {
				if(isset($tmps[4])){
					if(($tmps[4] == 'other7' or $tmps[4] == 'other8')){
						$this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$k]['other']['html_end'] = str_replace('　', ' <button class="btn blue" type="submit"></i>送出</button>', $this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$k]['other']['html_end']);
					} elseif($tmps[4] == 'xx999'){
						// do nothing
					} elseif($tmps[4] == 'xx93'){
						// 內頁欄位排序不要隱藏
					} elseif($tmps[4] == 'xx94'){
						// 欄位複製不要隱藏
					} else {
						if(!preg_match('/^(other9|other10|other11|other12)$/', $tmps[4])){
							unset($this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$k]);
						}
					}
				}
			}

			if(in_array($tmps[3], $has_list_ids)){ // 如果有勾列表啟用
				// do nothing
			} else {
				if(isset($tmps[4])){
					if($tmps[4] == 'other8'){
						$this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$k]['other']['html_end'] = str_replace('　', ' <button class="btn blue" type="submit"></i>送出</button>', $this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$k]['other']['html_end']);
					} elseif($tmps[4] == 'xx999'){
						// do nothing
					} elseif($tmps[4] == 'xx93'){
						// 內頁欄位排序不要隱藏
					} elseif($tmps[4] == 'xx94'){
						// 欄位複製不要隱藏
					} else {
						if(preg_match('/^(other9|other10|other11|other12)$/', $tmps[4])){
							unset($this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$k]);
						}
					}
				}
			}
		}
	}

	foreach($this->data['funcfieldv3_canuse_fields'] as $k => $v){
		$field = $this->data['funcfieldv3_prefix'].'__'.$v.'__';

		// 內頁沒有選模組的欄位，把它的說明欄位刪掉
		if(!isset($this->data['updatecontent'][$field.'other6readme']) or $this->data['updatecontent'][$field.'other6readme'] ==''){
			unset($this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other6readme']);
		} else {
			$this->data['updatecontent'][$field.'other6readme'] = '<code>'.nl2br($this->data['updatecontent'][$field.'other6readme']).'</code>';
		}

		// 列表沒有選模組的欄位，把它的說明欄位刪掉
		if(!isset($this->data['updatecontent'][$field.'other12readme']) or $this->data['updatecontent'][$field.'other12readme'] ==''){
			unset($this->data['def']['updatefield']['sections'][$this->data['funcfieldv3_position_custom']]['field'][$field.'other12readme']);
		} else {
			$this->data['updatecontent'][$field.'other12readme'] = '<code>'.nl2br($this->data['updatecontent'][$field.'other12readme']).'</code>';
		}
	}

	$form_data_html_tmp = '';
	if(isset($form_datas) and !empty($form_datas)){
		foreach($form_datas as $k => $v){
			if($this->data['admin_switch_data_ml_key'] == 'tw'){
				$form_data_html_tmp .= '	&lt;label t="* '.$this->data['admin_switch_data_ml_key'].' ucfirst"&gt;'.strip_tags($v[0]).'&lt;/label&gt;'."\n";
				$form_data_html_tmp .= '	&lt;span t="* '.$this->data['admin_switch_data_ml_key'].' ucfirst"&gt;'.strip_tags($v[0]).'&lt;/span&gt;'."\n";
			} else {
				$form_data_html_tmp .= '	&lt;label t="* '.$this->data['admin_switch_data_ml_key'].'"&gt;'.strip_tags($v[0]).'&lt;/label&gt;'."\n";
				$form_data_html_tmp .= '	&lt;span t="* '.$this->data['admin_switch_data_ml_key'].'"&gt;'.strip_tags($v[0]).'&lt;/span&gt;'."\n";
			}
			$form_data_html_tmp .= '	&lt;?php echo t(\''.strip_tags($v[0]).'\',\''.$this->data['admin_switch_data_ml_key'].'\')?&gt;'."\n";

			// 名子、英文、型態
			if($v[2] == 'input' or $v[2] == 'tag_input'){
				$form_data_html_tmp .= '	&lt;input type="text" id="'.$v[1].'" name="'.$v[1].'" value="&lt;?php echo $save[\''.$v[1].'\']?&gt;" /&gt;'."\n";
			} elseif($v[2] == 'select'){
				$form_data_html_tmp .= '	&lt;select id="'.$v[1].'" name="'.$v[1].'"&gt;'."\n";
				$form_data_html_tmp .= '	&lt;option value="test1" &lt;?php if($save[\''.$v[1].'\']==\'test1\'):?&gt; selected="selected" &lt;?php endif?&gt; &gt;test1&lt;/option&gt;'."\n";
				$form_data_html_tmp .= '	&lt;option value="test2" &lt;?php if($save[\''.$v[1].'\']==\'test2\'):?&gt; selected="selected" &lt;?php endif?&gt; &gt;test2&lt;/option&gt;'."\n";
				$form_data_html_tmp .= '	&lt;/select&gt;'."\n";
			} elseif($v[2] == 'radio'){
				$form_data_html_tmp .= '	&lt;input type="radio" name="'.$v[1].'" t="value tw ucfirst" value="test1" &lt;?php if($save[\''.$v[1].'\']==\'test1\'):?&gt; checked="checked" &lt;?php endif?&gt; /&gt; &lt;span t="* tw ucfirst"&gt;test1&lt;/span&gt;'."\n";
				$form_data_html_tmp .= '	&lt;input type="radio" name="'.$v[1].'" t="value tw ucfirst" value="test2" &lt;?php if($save[\''.$v[1].'\']==\'test2\'):?&gt; checked="checked" &lt;?php endif?&gt; /&gt; &lt;span t="* tw ucfirst"&gt;test2&lt;/span&gt;'."\n";
			} elseif($v[2] == 'textarea'){
				$form_data_html_tmp .= '	&lt;textarea id="'.$v[1].'" name="'.$v[1].'"&gt;&lt;?php echo $save[\''.$v[1].'\']?&gt;&lt;/textarea&gt;'."\n";
			}
		}
	}

	$form_data_html = <<<XXX
<pre>
&lt;form class="form_start"&gt;
$form_data_html_tmp

	&lt;label t="* tw ucfirst"&gt;認證碼&lt;/label&gt;
	&lt;?php echo t('認證碼','tw')?&gt;
	&lt;input type="text" id="captcha" name="captcha" /&gt;
	&lt;img id="valImageId" src="captcha.php" width="100" /&gt;
	&lt;a href="javascript:void(0)" onclick="RefreshImage('valImageId')"&gt;&lt;span t="* tw ucfirst"&gt;更新認證碼&lt;/span&gt;&lt;/a&gt;

	&lt;button&gt;&lt;?php echo t('SEND','en')?&gt;&lt;/button&gt;
&lt;/form&gt;

&lt;?php if(0):?&gt;&lt;!-- form_post --&gt;
&lt;?php
// http://網站的網址/_i/backend.php?r=datasource/update&amp;param=v1706
// 通用表單 - v3_source:system/form_post,
\$layoutv3_datasource_id = 1706;
include 'layoutv3/dom5/datasource.php';
?&gt;
&lt;?php endif?&gt;&lt;!-- form_post --&gt;
</pre>
XXX;

	// 表單碼產生
	$this->data['updatecontent'][$this->data['funcfieldv3_prefix'].'_form_data'] = $form_data_html;

} // if 999995

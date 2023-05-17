<?php

// 2018-02-21 自動模組處理(auto_module_handle)
// 記得！update_show_last那邊也有
foreach($this->data['def']['updatefield']['sections'] as $k => $v){
	foreach($v['field'] as $kk => $vv){
		if(isset($vv['type'])){
			// kcfinder_school
			if(isset($vv['type']) and $vv['type'] == 'kcfinder_school'){
				unset($this->data['def']['updatefield']['sections'][$k]['field'][$kk]);
			} elseif($vv['type'] == 'fileuploader'){
				if(!isset($_auto_module_handle_fileuploader_counter)){
					$_auto_module_handle_fileuploader_counter = 0;
				}
				$_auto_module_handle_fileuploader_counter++;
				$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['number'] = $_auto_module_handle_fileuploader_counter;
			} elseif($vv['type'] == 'multi-select'){
				if(isset($this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['values']) and count($this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['values']) > 0){
					$this->data['_auto_module_handle_'.$kk] = $this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['values'];

					$groups = array();
					foreach($this->data['_auto_module_handle_'.$kk] as $kkk => $vvv){
						$groups[$kkk]['value'] = $vvv;
					}
					$this->data['updatecontent'][$kk] = $groups;
				}
			}

			if(isset($vv['other']['_funcfieldv3_is_datepicker']) and $vv['other']['_funcfieldv3_is_datepicker'] == '1'){
				$this->data['def']['updatefield']['smarty_javascript_text'] .= '$("#'.$kk.'").datepicker({dateFormat: "yy-mm-dd"});';
			}
		}
	}
}

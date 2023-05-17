<?php

// 2020-08-20
// [sys_log2]將更新前後的資料備份，也寫入log (1/2)
$this->data['sys_log2_a'] = $this->cidb->where('id',$this->data['id'])->get($this->data['def']['table'])->row_array();

// 2018-02-21 自動模組處理(auto_module_handle)
// 記得！create_run_other_element那邊也有
foreach($this->data['def']['updatefield']['sections'] as $k => $v){
	foreach($v['field'] as $kk => $vv){
		if(isset($vv['type'])){
		   	if($vv['type'] == 'checkbox'){
				if(!isset($array[$kk])){
					if(isset($this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['no_value'])){
						$array[$kk] = $this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['no_value'];
					} else {
						$array[$kk] = 0;
					}
				}
			} elseif($vv['type'] == 'multi-select'){

				if(isset($array[$kk]) && is_array($array[$kk])){
					$_count = count($array[$kk]);
				}else{
					$_count = 0;
				}
				if(isset($array[$kk]) and $_count > 0){
					$array[$kk] = ','.implode(',', $array[$kk]).',';
				} else {
					$array[$kk] = '';
				}
				// if(isset($array[$kk]) and !empty($array[$kk])){
				// 	$array[$kk] = ','.implode(',', $array[$kk]).',';
				// } else {
				// 	$array[$kk] = '';
				// }
			}
		}
	}
}

// 寫入funcfieldv3欄位的資料，有需要就打開 5/5
if(preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
	$funcfieldv3_inserts_tmp = array();
	foreach($array as $k => $v){
		if(preg_match('/^'.$this->data['funcfieldv3_prefix'].'__(.*)__(.*)$/', $k, $matches)){
			$funcfieldv3_inserts_tmp[$matches[1]]['other1'] = $matches[1];
			$funcfieldv3_inserts_tmp[$matches[1]][$matches[2]] = $v;
			unset($array[$k]);
		}
	}

	$funcfieldv3_inserts = array();
	if(!empty($funcfieldv3_inserts_tmp)){
		foreach($funcfieldv3_inserts_tmp as $k => $v){
			// 如果內頁欄位、和列表欄位都沒有打勾，那就刪了它吧
			if((!isset($v['other7']) or $v['other7'] != '1') and (!isset($v['other8']) or $v['other8'] != '1')){
				$this->cidb->delete('html',array('type'=>$this->data['funcfieldv3_prefix'],'other1'=>$v['other1'])); 
				continue;
			}

			$this->cidb->delete('html',array('type'=>$this->data['funcfieldv3_prefix'],'other1'=>$v['other1'])); 

			$v['type'] = $this->data['funcfieldv3_prefix'];
			$v['is_enable'] = 1;
			$this->cidb->insert('html', $v); 
			// $id = $this->cidb->insert_id();
		}

		// 將def結構寫入暫存，讓source/include/admin_field_get的機制能夠跟進使用
		$save_file = _BASEPATH.ds('/assets/').'funcfieldv3_'.$this->data['router_class'].'.php';
		$defg = $this->data['def'];
		$defg['admin_title'] = $this->data['main_content_title'];
		file_put_contents($save_file, '<'.'?'.'php $admin_def = '.var_export($defg,true).';');
		@chmod($save_file,0777);
	}
}

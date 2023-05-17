<?php

// 2018-02-21 自動模組處理(auto_module_handle)
foreach($this->data['def']['updatefield']['sections'] as $k => $v){
	foreach($v['field'] as $kk => $vv){
		if(isset($vv['type'])){
			if($vv['type'] == 'kcfinder_school'){
				if(!isset($_auto_module_handle_kcfinder_school_counter2)){
					$_auto_module_handle_kcfinder_school_counter2 = 0;
				}
				$_auto_module_handle_kcfinder_school_counter2++;
				//$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['school_id'] = $this->data['router_class'].'_'.$_auto_module_handle_kcfinder_school_counter.'_'.$this->data['updatecontent']['id'];
				// 這是偷懶…的作法，只針對第一區塊來做，要記得…
				$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_class'].'_'.$_auto_module_handle_kcfinder_school_counter2.'_'.$this->data['id'].'/member');
				sort($tmps);//按照檔名排序後存到資料庫 by lota
				$this->cidb->where('type', $this->data['router_class'].'detailtmp'.$_auto_module_handle_kcfinder_school_counter2)->where('ml_key',$this->data['ml_key'])->where('class_id', $this->data['id'])->delete('html'); 
				foreach($tmps as $k => $v){
					$data = array(
						'ml_key' => $this->data['ml_key'],
						'type' => $this->data['router_class'].'detailtmp'.$_auto_module_handle_kcfinder_school_counter2,
						'class_id' => $this->data['id'],
						'pic1' => str_replace(_BASEPATH.'/', '', $v),
					);
					$this->cidb->insert('html', $data); 
				}
			}
		}
	}
}

// 2020-08-20
// [sys_log2]將更新前後的資料備份，也寫入log (2/2)
$sys_log2_msg = 'update id:'.$this->data['id'];
$sys_log2_a = $this->data['sys_log2_a'];
$sys_log2_b = $this->cidb->where('id',$this->data['id'])->get($this->data['def']['table'])->row_array();

// 為了避免訂單功能的這些欄位被存入
unset($sys_log2_a['log_1']);
unset($sys_log2_a['log_2']);
unset($sys_log2_a['log2_1']);
unset($sys_log2_a['log2_2']);

unset($sys_log2_b['log_1']);
unset($sys_log2_b['log_2']);
unset($sys_log2_b['log2_1']);
unset($sys_log2_b['log2_2']);

// 開發階段，其實也才用到5000而以(TEXT欄位是65535)，所以可以放心使用
$sys_log2_a_result = G::utf8_str_split('$log='.var_export($sys_log2_a,true).';', intval(65535*0.7));
$sys_log2_b_result = G::utf8_str_split('$log2='.var_export($sys_log2_b,true).';', intval(65535*0.7));

$save = array(
	'log_code' => Yii::app()->session['sys_log_code'],
	'log_msg' => $sys_log2_msg,
	'ip_addr' => $_SERVER['REMOTE_ADDR'],
	'create_time' => date("Y-m-d H:i:s"),
);
if(isset(Yii::app()->session['auth_admin_id']) and Yii::app()->session['auth_admin_id'] != null){
	$save['user_id'] = Yii::app()->session['auth_admin_id'];
} else {
	$save['user_id'] = 0;
}

foreach($sys_log2_a_result as $k => $v){
	$save['log_'.($k+1)] = $v;
	if($k == 1) break;
}

foreach($sys_log2_b_result as $k => $v){
	$save['log2_'.($k+1)] = $v;
	if($k == 1) break;
}

$this->cidb->insert('sys_log',$save);

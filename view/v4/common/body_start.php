<?php
// 2020-10-07
if(LAYOUTV3_THEME_NAME == 'v4'){
	$rows = $this->cidb->where('is_enable',1)->where('type','userblockv4'.$this->data['router_method'])->where('topic','v4/userblock/body_start')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('html')->result_array();
	if($rows){
		foreach($rows as $k => $v){
			echo $v['detail'];
		}
	}
}
?>

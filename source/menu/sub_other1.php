<?php

/*
 * 2019-08-05
 * 讓沒有主選單的功能，也能顯示次選單
 * 李哥說要做這個功能
 *
 * 2019-11-20 補充用法：
 * 1. 後台該功能的page，資料流勾選menu-sub_other1，取消menu-sub
 * 2. 勾選懷舊次選單(如果需要的話)
 * 3. 後台建立新的前台主選單，狀態啟用，區域選other1，還有資料流動態次選單那邊把它勾選好
 */

$tmps = array();

$_position = 'other1';
include 'source/menu/v2.php';

$tmps = $tmp;
unset($tmp);

if(count($tmps) > 0 and isset($this->data['func_name_id']) and $this->data['func_name_id'] > 0){
	$row = array();
	foreach($tmps as $k => $v){
		if($v['id'] == $this->data['func_name_id'] and isset($v['child']) and count($v['child']) > 0){
			//如果有小圖示就顯示
			foreach ($v['child'] as $k1 => $v1) {
				if(isset($v1['pic2']) && $v1['pic2']!=''){
					$v['child'][$k1]['pic2_src'] = '<span class="iconImg"><img src="_i/assets/upload/'.$this->data['router_method'].'type/'.$v1['pic2'].'" alt="WRENCHES"></span>';
				}
			}
			$row = $v['child'];
			break;
		}
	}

	$data[$ID] = $row;
}

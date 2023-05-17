<?php

/*
 * 單頁專用的
 * 這個是接在dump.php之後的
 * 為了要讓單頁輸出變數的時候，不用判斷陣列元素是否存在
 * 這個概念類似連絡我們那邊的save陣列
 */

// ！！不存在的時候哦！！
if(!isset($this->data['_general_detail']['id'])){
	$rowcc = $this->cidb->select('*,topic as name')->get('html')->row_array(); 
	if($rowcc and isset($rowcc['id'])){
		foreach($rowcc as $k => $v){
			$this->data['_general_detail'][$k] = '';
			$data[$next_id][$k] = ''; // $next_id來自於dump.php的最下面
		}
	}
}
?>

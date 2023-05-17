<?php

if(isset($_GET['id']) and $_GET['id'] > 0){
	$tmp = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>intval($_GET['id'])))->queryRow();
	if($tmp){
		$tmp['content'] = $tmp['detail'];
		// $tmp['name'] = $tmp['topic'];
		$tmp['sub_name'] = '';
		// $tmp['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$tmp['pic1'];

		//#38046 把文章的name 放到 sub_page_title 內 by lota
		$_tmp['name'] = $tmp['name'];
		$_tmp['sub_name'] = $this->data["func_en_name"];

		// $_tmp['sub_name'] = $tmp['name'];//#2021-02-21 統一只顯示文章標題，如果有需要再開啟,需要配合 sub_page_title的模式 by lota
		

		$page_source_data_param1 = 'share-page_title';
		$page_source_data_param2 = $_tmp;
		$page_source_data_other = array('assign_force'=>true);
		include _BASEPATH.'/../source/system/page_source_data.php';

	} else {
		$tmp = array(
			'content' => '',
			'name' => '',
			'subname' => '',
			'pic' => '',
		);
	}
	$data[$ID] = $tmp;
} else { // 2020-08-26 如果這個功能在主選單上是隱藏，而且開啟側邊選單的狀況下，沒有帶編號的時候，就會需要這裡程式的引導了
	$tmp = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get($this->data['router_method'].'type')->row_array();
	if($tmp and isset($tmp['id'])){
		header('Location: '.$this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$tmp['id']);
	}
}

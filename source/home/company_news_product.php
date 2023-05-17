<?php

if($DATA_SINGLE == true and $DATA_MULTI == false){
	
	// 目前沒有

} elseif($DATA_SINGLE == false and $DATA_MULTI == true){
	
	// 目前沒有

} elseif($DATA_SINGLE == true and $DATA_MULTI == true){

	// 單筆、多筆，我猜是W15在用的
	// if(count($DATA_SINGLE_MULTI) ==  2 and $DATA_SINGLE_MULTI[0] == 'DATA_SINGLE' and $DATA_SINGLE_MULTI[1] == 'DATA_MULTI'){

	$layoutv3_condition = 'single|multi';
	include _BASEPATH.'/../layoutv3/multi_source_check.php';
	if($layoutv3_condition === true){

		// 單筆
		$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and is_home=1',array(':type'=>'news',':ml_key'=>$this->data['ml_key']))->queryRow();
		if($tmp){
			$tmp['pic'] = '_i/assets/upload/news/'.$tmp['pic1'];
		} else {
			$tmp = array(
				'pic' => 'images/w15/index-sample-2.jpg',
			);
		}
		$tmp['url'] = 'news_'.$this->data['ml_key'].'.php';
		$data[$ID.'_0'] = $tmp;

		// 多筆
		$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and is_home=1',array(':type'=>'news',':ml_key'=>$this->data['ml_key']))->order('start_date desc')->limit(5)->queryAll();
		if($tmps and count($tmps) > 0){
			foreach($tmps as $k => $v){
				$tmps[$k]['name'] = $v['topic'];
				$tmps[$k]['url'] = 'news_'.$this->data['ml_key'].'.php?id='.$v['id'];
			}
		}
		for($x=0;$x<=4;$x++){
			if(!isset($tmps[$x])){
				$tmps[$x]['name'] = ' ';
				$tmps[$x]['url'] = 'javascript:;';
			}
		}
		$data[$ID.'_1'] = $tmps;

	}

	// 單筆、多筆、單筆、多筆、單筆，我猜是W02在用的
	// } elseif(count($DATA_SINGLE_MULTI) == 5 
	// 	and $DATA_SINGLE_MULTI[0] == 'DATA_SINGLE' 
	// 	and $DATA_SINGLE_MULTI[1] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[2] == 'DATA_SINGLE'
	// 	and $DATA_SINGLE_MULTI[3] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[4] == 'DATA_SINGLE'
	// ){

	$layoutv3_condition = 'single|multi|single|multi|single';
	include _BASEPATH.'/../layoutv3/multi_source_check.php';
	if($layoutv3_condition === true){

		// 單筆
		$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>'company',':ml_key'=>$this->data['ml_key']))->queryRow();
		if($tmp){
			$tmp['pic'] = '_i/assets/upload/company/'.$tmp['pic1'];
			$tmp['name'] = $tmp['topic'];
			$tmp['url'] = 'company'.$this->data['ml_key'].'.php';
		} else {
			$tmp = array(
				'pic' => '',
				'name' => '',
				'url' => 'company_'.$this->data['ml_key'].'.php',
			);
		}
		$data[$ID.'_0'] = $tmp;

		// 多筆
		$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and is_home=1 and type=:type',array(':type'=>'news',':ml_key'=>$this->data['ml_key']))->order('start_date desc')->queryAll();
		if($tmps and count($tmps) > 0){
			foreach($tmps as $k => $v){
				$tmps[$k]['name'] = $v['topic'];
				$tmps[$k]['url'] = 'news_'.$this->data['ml_key'].'.php?id='.$v['id'];
				$tmps[$k]['date'] = $v['start_date'];
			}
		}
		$data[$ID.'_1'] = $tmps;

		// 單筆
		$data[$ID.'_2'] = array(
			'url' => 'news_'.$this->data['ml_key'].'.php',
		);

		// 多筆
		$tmps = $this->db->createCommand()->from('product')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->limit(3)->queryAll();
		if($tmps and count($tmps) > 0){
			foreach($tmps as $k => $v){
				$tmps[$k]['url'] = 'productdetail_'.$this->data['ml_key'].'.php?id='.$v['id'];
				$tmps[$k]['pic'] = '_i/assets/upload/product/'.$v['pic1'];
				//$tmps[$k]['name'] = $v['topic'];
				$tmps[$k]['name2'] = $v['detail'];
			}
		}
		$data[$ID.'_3'] = $tmps;

		// 單筆
		$data[$ID.'_4'] = array(
			'url' => 'product_'.$this->data['ml_key'].'.php',
		);


	}

}

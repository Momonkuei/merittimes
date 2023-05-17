<?php

if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		$v['url2'] = $v['url1'];

		// cttdemo專用
		$v['url3'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];

		if($v['other1'] != ''){
			$v['pic'] = 'http://i.ytimg.com/vi/'.$v['other1'].'/0.jpg';
		} else {
			$v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
		}

		$v['name1'] = $v['name2'] = $v['name3'] = $v['topic'];
		// $v['content'] = $v['field_tmp'];
		if($v['start_date'] != ''){
			$v['year'] = date('Y', strtotime($v['start_date']));
			$v['month'] = date('F', strtotime($v['start_date']));
			$v['day'] = date('d', strtotime($v['start_date']));
		}
		$rows[$k] = $v;
	}
}

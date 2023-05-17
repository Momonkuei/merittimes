<?php

$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and is_home=1 and type=:type',array(':type'=>'product'))->limit(4)->queryAll();
if($tmps and count($tmps) > 0){
	foreach($tmps as $k => $v){
		$tmps[$k]['name'] = $v['topic'];
		$tmps[$k]['content'] = $v['detail'];
		$tmps[$k]['url'] = '';
		$tmps[$k]['pic'] = '_i/assets/upload/product/'.$v['pic1'];
	}
}
$data[$ID] = $tmps;

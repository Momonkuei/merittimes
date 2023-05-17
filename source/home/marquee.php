<?php

$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type',array(':type'=>'marquee'))->queryAll();
if($tmps and count($tmps) > 0){
	foreach($tmps as $k => $v){
		$tmps[$k]['name'] = $v['topic'];
		$tmps[$k]['url'] = $v['url1'];
	}
}
$data[$ID] = $tmps;

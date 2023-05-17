<?php

$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type',array(':type'=>'company'))->queryRow();
$tmp['name'] = $tmp['topic'];
$tmp['describe'] = $tmp['detail'];
$tmp['pic'] = '_i/assets/upload/company/'.$tmp['pic1'];
$data[$ID] = $tmp;

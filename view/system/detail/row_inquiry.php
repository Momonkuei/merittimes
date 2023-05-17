<?php

// inquiry
if(isset($row['id']) and $row['id'] > 0){
	$row['inquiry']['id'] = $router_method.'inquiry';
	$row['inquiry']['primary_key'] = $router_method.'___'.$row['id'].'___0'; // 預設型號為零，這是型號範本，請依需求去客制
	$row['inquiry']['ml_key'] = $this->data['ml_key']; // 2019-10-25
	$row['inquiry']['_append'] = ''; // 2019-10-25
	$row['inquiry']['amount'] = 1; // 2020-04-16

	// $row['inquiry']['url'] = 'save.php?id='.$row['inquiry']['id'].'&_append=&amount=1&primary_key='.$row['inquiry']['primary_key']; // 預留給A方案

	// 預留給A方案 2019-10-25
	$tmp2 = array();
	if(isset($row['inquiry']) and !empty($row['inquiry'])){
		foreach($row['inquiry'] as $k => $v){
			$tmp2[] = $k.'='.$v;
		}
	}
	$row['inquiry']['url'] = 'save.php?'.implode('&', $tmp2);
}

?>

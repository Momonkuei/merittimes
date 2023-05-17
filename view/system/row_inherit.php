<?php
// 這個是用在V4版型的row
// 請用incluce的方式，來載入這一支檔案

// 把上一個區塊所設定的row裡面的頭尾，給帶過來
$tmp2 = explode('-', $ID);
//var_dump($tmp2);
unset($tmp2[count($tmp2)-1]);
$parent_id = implode('-',$tmp2);

if(isset($data[$parent_id]['row_inherit_start']) and $data[$parent_id]['row_inherit_start'] != ''){
	$row_inherit_start = $data[$parent_id]['row_inherit_start'];

	if(isset($data[$parent_id]['row_inherit_end']) and $data[$parent_id]['row_inherit_end'] != ''){
		$row_inherit_end = $data[$parent_id]['row_inherit_end'];
	}
}
?>

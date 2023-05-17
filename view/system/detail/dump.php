<?php

/*
array(8) {
  [0]=>
  string(1) "0"
  [1]=>
  string(3) "0_0"
  [2]=>
  string(3) "0_0"
  [3]=>
  string(1) "1"
  [4]=>
  string(3) "1_0"
  [5]=>
  string(1) "2"
  [6]=>
  string(3) "0_0"
  [7]=>
  string(1) "5"
}
*/

/*
array(8) {
  [0]=>
  string(1) "0"
  [1]=>
  string(3) "0_0"
  [2]=>
  string(3) "0_0"
  [3]=>
  string(1) "1"
  [4]=>
  string(3) "1_0"
  [5]=>
  string(1) "2"
  [6]=>
  string(3) "1_0"
  [7]=>
  string(1) "5"
}
*/

// $data[$ID] = end($result);

$rows = array();
$row = array();

// 把後一個區塊的內容，取代成這裡的內容
$tmp2 = explode('-', $ID);

// 用群組包起來的解析方式
unset($tmp2[count($tmp2)-1]);
$tmp3 = explode('_', end($tmp2));
$tmp2[count($tmp2)-1] = $tmp3[0]+1;

// 直接使用的方式
// $tmp2[count($tmp2)-1] = $tmp2+1;

$next_id = implode('-',$tmp2);
// var_dump($data[$next_id]);

$tmp4 = end($result);

// 底下程式銜接的方式1 (預留)
if(isset($tmp4['id']) or isset($tmp4['name']) or isset($tmp4['topic']) or isset($tmp4['sort_id'])){
	$row = $tmp4;
} else {
	$rows = $tmp4;
}

// 底下程式銜接的方式2 (LayoutV3)
$data[$next_id] = $tmp4;

// 底下程式銜接的方式3 (V1第二版)
$this->data['_general_detail'] = $tmp4;
?>

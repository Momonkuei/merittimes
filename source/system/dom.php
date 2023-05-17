<?php

/*
 * 這個功能，是乖哥在2017-08-04下班前建議的
 */

/*
array(7) {
  ["0-0_0-0_0"]=>
  array(2) {
    ["alias"]=>
    string(24) "XXX"
    ["source"]=>
    string(4) "core"
  }
}
 */

$result = array();

//    $template_number = '01';
//    foreach($page_source_result as $k => $v){
//    	if(preg_match('/^index_content_(.*)$/', $layoutv3_struct_map[$k], $matches)){
//    		$template_number = $matches[1];
//    		break;
//    	}
//    }

// 共用規則
$rules_common = array(
	'parent' => 'find("*[dom*=multi]", "GGG")->innertext', // 多筆要assign到哪裡去
	'one' => 'find("*[dom*=1]", "GGG")->outertext', // 單筆在哪裡
	'start' => 'find("*[dom*=s]", "GGG")->outertext', // 第一筆在哪裡，因為有時候會需要，第一筆的時候，某個地方要加上class，例如active
	'odd' => 'find("*[dom*=o]", "GGG")->outertext', // 奇數 2017-10-19 李哥說好
	'even' => 'find("*[dom*=e]", "GGG")->outertext', // 偶數 2017-10-19 李哥說好
	'kill' => '', // 如果沒有資料的話要刪掉誰，如果是multi，最後不要刪掉它，或是assign一個空的multi，記到。對了，dom="1"也是一樣哦
	'kill_assign' => '', // 為了要避免刪到multi
);
$rules_common['kill'] = str_replace('innertext', 'outertext', $rules_common['parent']);

if(!function_exists('dom3')){
	function dom3($rules)
	{
		if(count($rules) <= 0){
			return array();
		}

		$root = $rules['parent'].'|'.$rules['one'].'|'.$rules['start'].'|'.$rules['odd'].'|'.$rules['even'];
		$kill = $rules['kill'];
		$kill_assign = $rules['kill_assign'];

		// if($single == true and $rows and isset($rows[0]) and isset($rows[0]['id']) and $rows[0]['id'] > 0){
		// 	$tmp = $rows[0];
		// 	$rows = array();
		// 	$rows[] = $tmp;
		// }

		$result = array();
		$result[$root] = $rules;

		// if($rows and count($rows) > 0){
		// 	$result[$root] = array();
		// } else {
		// 	$result[$kill] = $kill_assign;
		// }

		return $result;
	}
}

//    $file = _BASEPATH.'/../'.LAYOUTV3_PATH.'source/general_section/w'.$template_number.'.php';
//    if(file_exists($file)){
//    	include $file;
//    }

$multi_number = -1; // dom="multi"的順序是排在第幾個，從零開始

// 預設有5組多筆規則
for($x=1;$x<=5;$x++){
	/*
	 * 規則
	 */

	$multi_number++;
	$rules = $rules_common;
	$rules['parent'] = str_replace('GGG', $multi_number, $rules['parent']);
	$rules['one'] = str_replace('GGG', $multi_number, $rules['one']);
	$rules['start'] = str_replace('GGG', $multi_number, $rules['start']);
	$rules['odd'] = str_replace('GGG', $multi_number, $rules['odd']);
	$rules['even'] = str_replace('GGG', $multi_number, $rules['even']);
	$rules['kill'] = str_replace('innertext', 'outertext', $rules['parent']);
	// 可以把上層整個刪掉，但是要留個參照下來
	// $rules['kill'] = 'find("section[class=articleBlockStyle01]",0)->outertext';
	// $rules['kill_assign'] = '<ul dom="multi 1"></ul>';
	$result = array_merge($result, dom3($rules));
}

// 最後
$data[$ID] = $result;

// if(!function_exists('general_section_php2')){
// 	function general_section_php2($rows, $rules, $single = false)
// 	{
// 		if(count($rules) <= 0){
// 			return array();
// 		}
// 
// 		$root = $rules['parent'].'|'.$rules['one'];
// 		$kill = $rules['kill'];
// 		$kill_assign = $rules['kill_assign'];
// 
// 		if($single == true and $rows and isset($rows[0]) and isset($rows[0]['id']) and $rows[0]['id'] > 0){
// 			$tmp = $rows[0];
// 			$rows = array();
// 			$rows[] = $tmp;
// 		}
// 
// 		$result = array();
// 		if($rows and count($rows) > 0){
// 			$result[$root] = array();
// 			foreach($rows as $k => $v){
// 				$result[$root][] = $v;
// 			}
// 		} else {
// 			$result[$kill] = $kill_assign;
// 		}
// 
// 		return $result;
// 	}
// }

// if(!function_exists('general_section_php')){
// 	function general_section_php($rows, $rules, $field, $single = false)
// 	{
// 		if(count($rules) <= 0 or $field == ''){
// 			return array();
// 		}
// 
// 		$root = $rules['parent'].'|'.$rules['one'];
// 		$kill = $rules['kill'];
// 		$kill_assign = $rules['kill_assign'];
// 
// 		if($single == true and $rows and isset($rows[0]) and isset($rows[0]['id']) and $rows[0]['id'] > 0){
// 			$tmp = $rows[0];
// 			$rows = array();
// 			$rows[] = $tmp;
// 		}
// 
// 		$result = array();
// 		if($rows and count($rows) > 0){
// 			$result[$root] = array();
// 			foreach($rows as $k => $v){
// 				$tmp = array();
// 				eval($field);
// 				$result[$root][] = $tmp;
// 			}
// 		} else {
// 			$result[$kill] = $kill_assign;
// 		}
// 
// 		return $result;
// 	}
// }


//    // 原型的程式碼參考
//    $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'home'.$template_number.'section1',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
//    $result = array();
//    if($rows and count($rows) > 0){
//    	$result[$root] = array();
//    	foreach($rows as $k => $v){
//    		$title = 'find("a",0)->innertext';
//    		$url = 'find("a",0)->href';
//    		$tmp = array(
//    			$title => $v['topic'],
//    			$url => $v['url1'],
//    		);
//    		$result[$root][] = $tmp;
//    	}
//    } else {
//    	$result[$parent] = '';
//    }
//    

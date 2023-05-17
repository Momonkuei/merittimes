<?php
$multi_number = -1; // dom="multi"的順序是排在第幾個，從零開始

/*
 * 跑馬燈
 */

$multi_number++;
$router_method_type = 'home'.$template_number.'section1'; // 跟後台有相關
$rules = $rules_common;
$rules['parent'] = str_replace('GGG', $multi_number, $rules['parent']);
$rules['one'] = str_replace('GGG', $multi_number, $rules['one']);
$rules['kill'] = str_replace('innertext', 'outertext', $rules['parent']);
// 可以把上層整個刪掉，但是要留個參照下來
// $rules['kill'] = 'find("section[class=articleBlockStyle01]",0)->outertext';
// $rules['kill_assign'] = '<ul dom="multi 1"></ul>';
ob_start()?>
	// 可以試著把規則固定下來，所以要改的應該只剩資料表名稱，和欄位別名而以
	$tmp['find("a",0)->innertext'] = $v['name'];
	$tmp['find("a",0)->href'] = $v['url'];
<?php $field_eval = ob_get_contents();ob_end_clean();
$o = $this->db->createCommand()->select('*, topic as name, url1 as url')->from('html');
$o = $o->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$router_method_type,':ml_key'=>$this->data['ml_key']));
$rows = $o->order('sort_id')->queryAll();
$data['ggg'] = $rows;
// $result = array_merge($result, general_section_php($rows, $rules, $field_eval, false));
// $result = array_merge($result, general_section_php2($rows, $rules, false));
$result = array_merge($result, general_section_php3($rules, false));

/*
 * 區塊二
 */
$multi_number++;
$router_method_type = 'home'.$template_number.'section2';
$rules = $rules_common;
$rules['parent'] = str_replace('GGG', $multi_number, $rules['parent']);
$rules['one'] = str_replace('GGG', $multi_number, $rules['one']);
$rules['kill'] = str_replace('innertext', 'outertext', $rules['parent']);
// $rules['kill'] = 'find("section[class=articleBlockStyle03]",0)->outertext';
// $rules['kill_assign'] = '<span dom="multi 1"></span>';
ob_start()?>
 	$tmp['find("a",0)->href'] = $v['url'];
 	$tmp['find("img",0)->src'] = '_i/assets/upload/<?php echo $router_method_type?>/'.$v['pic'];
 	$tmp['find("h4",0)->innertext'] = $v['name'];
 	$tmp['find("p",0)->innertext'] = $v['describe'];
<?php $field_eval = ob_get_contents();ob_end_clean();
$o = $this->db->createCommand()->select('*, topic as name, url1 as url, pic1 as pic, other1 as describe')->from('html');
$o = $o->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$router_method_type,':ml_key'=>$this->data['ml_key']));
$rows = $o->order('sort_id')->queryAll();
if($rows){
	foreach($rows as $k => $v){
		$v['pic'] = '_i/assets/upload/'.$router_method_type.'/'.$v['pic'];
		$rows[$k] = $v;
	}
}
// $result = array_merge($result, general_section_php($rows, $rules, $field_eval, false));
$result = array_merge($result, general_section_php2($rows, $rules, false));

/*
 * 區塊三(單筆用多筆來解)
 */
$multi_number++;
$router_method_type = 'home'.$template_number.'section3';
$rules = $rules_common;
$rules['parent'] = str_replace('GGG', $multi_number, $rules['parent']);
$rules['one'] = str_replace('GGG', $multi_number, $rules['one']);
$rules['kill'] = str_replace('innertext', 'outertext', $rules['parent']);
// $rules['kill_assign'] = '<section class="articleBlockStyle01" dom="multi" dom="1"></section>';
ob_start()?>
	$tmp['find("span",0)->innertext'] = $v['topic'];
	$tmp['find("small",0)->innertext'] = $v['short'];
	$tmp['find("p",0)->innertext'] = $v['describe'];
	$tmp['find("img",0)->src'] = '_i/assets/upload/<?php echo $router_method_type?>/'.$v['pic1'];
<?php $field_eval = ob_get_contents();ob_end_clean();
$o = $this->db->createCommand()->select('*, topic as name, url1 as url, pic1 as pic, other1 as short, other2 as describe')->from('html');
$o = $o->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$router_method_type,':ml_key'=>$this->data['ml_key']));
$rows = $o->order('sort_id')->queryAll();
if($rows){
	foreach($rows as $k => $v){
		$v['pic'] = '_i/assets/upload/'.$router_method_type.'/'.$v['pic'];
		$rows[$k] = $v;
	}
}
// $result = array_merge($result, general_section_php($rows, $rules, $field_eval, true));
$result = array_merge($result, general_section_php2($rows, $rules, true));

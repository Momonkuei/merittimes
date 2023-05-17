<?php

// 2018-06-04 早上有跟李哥說明這個功能
if(isset($layoutv3_datasource_id) and $layoutv3_datasource_id > 0){

	$cidb = $this->cidb;
	$current_lang = $this->data['ml_key'];

	unset($layer_params);
	unset($single_content);
	unset($content);

	$o = $cidb;
	if(isset($layoutv3_enable_force) and $layoutv3_enable_force === true){ // 後台_i/backend/controllers/DatasourceController.php專用，用在預覽資料的功能上
		// do nothing
	} else {
		$o = $o->where('is_enable',1);
	}
	$rowggg = $o->where('video_1 !=','')->where('type','datasource')->where('id',$layoutv3_datasource_id)->get('html')->row_array();

	unset($layoutv3_enable_force);
	unset($layoutv3_datasource_id);

	if($rowggg and isset($rowggg['id']) and $rowggg['id'] > 0){
		$map = array(
			1  => array(1,2),
			2  => array(3,4),
			3  => array(5,6),
			4  => array(7,8),
			5  => array(9,10),
			6  => array(11,12),
			7  => array(13,14),
			8  => array(15,16),
			9  => array(17,18),
			10 => array(19,20),
		);
		$tmpsggg = array();
		for($x=1;$x<=10;$x++){
			$a = $map[$x][0];
			$b = $map[$x][1];
			if($rowggg['other'.$a] != '' and $rowggg['other'.$b] != ''){
				$valueggg = $rowggg['other'.$b];

				if(isset($layoutv3_rule_value[$x])){ // 2018-07-16 用在webmenuchild
					$valueggg = $layoutv3_rule_value[$x];
				}

				$tmpsggg[] = $rowggg['other'.$a].':'.$valueggg;
			}
		}

		// 2018-08-06 新增自定keyvalue參數，為了解決麵包屑的問題
		if(isset($rowggg['other21']) and $rowggg['other21'] != ''){
			$tmpsggg[] = $rowggg['other21'];
		}

		$layer_data_source = $rowggg['video_1'];
		$layer_params = implode(',', $tmpsggg);
		//var_dump($layer_params);

		$layer_debug_first = false;
		if($rowggg['is_top'] == 1){
			$layer_debug_first = true;
		}

		$layer_debug = false;
		if($rowggg['is_home'] == 1){
			$layer_debug = true;
		}

		unset($layoutv3_rule_value);

	} else {
		unset($layoutv3_rule_value);

		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			continue;
		} else {
			return;
		}
	}
}

// 2018-06-04 早上有跟李哥說明這個功能
if(isset($layer_data_source_id) and $layer_data_source_id > 0){
	$rowggg = $cidb->where('is_enable',1)->where('video_1 !=','')->where('type','datasource')->where('id',$layer_data_source_id)->get('html')->row_array();
	unset($layer_data_source_id);
	if($rowggg and isset($rowggg['id']) and $rowggg['id'] > 0){
		$map = array(
			1  => array(1,2),
			2  => array(3,4),
			3  => array(5,6),
			4  => array(7,8),
			5  => array(9,10),
			6  => array(11,12),
			7  => array(13,14),
			8  => array(15,16),
			9  => array(17,18),
			10 => array(19,20),
		);
		$tmpsggg = array();
		for($x=1;$x<=10;$x++){
			$a = $map[$x][0];
			$b = $map[$x][1];
			if($rowggg['other'.$a] != '' and $rowggg['other'.$b] != ''){
				$tmpsggg[] = $rowggg['other'.$a].':'.$rowggg['other'.$b];
			}
		}
		$layer_data_source = $rowggg['video_1'];
		$layer_params = implode(',', $tmpsggg);

		// 覆寫原有設定
		$layer_debug_first = false;
		if($rowggg['is_top'] == 1){
			$layer_debug_first = true;
		}

		// 覆寫原有設定
		$layer_debug = false;
		if($rowggg['is_home'] == 1){
			$layer_debug = true;
		}
	} else {
		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			continue;
		} else {
			return;
		}
	}
}

$m_params2 = array();
if($layer_params != ''){
	$m_params2 = explode(',', $layer_params);
}
if($m_params2){
	$m_params2_tmp = array(); // 檢查有沒有重覆的key值
	foreach($m_params2 as $kk => $vv){
		if(preg_match('/^(.*)\:(.*)$/', $vv, $matches)){
			if(!isset($m_params2_tmp[$matches[1]])){
				$m_params2_tmp[$matches[1]] = '';
				$m_params2[$kk] = '"'.$matches[1].'":"'.$matches[2].'"';
			} else {
				// 2018-01-30 下午發現的，因為andwhere條件只能下一次
				$m_params2[$kk] = '"'.$matches[1].$kk.'":"'.$matches[2].'"';
			}
		}
	}
}

$m_params = json_decode('{'.implode(',', $m_params2).'}', true);

//var_dump($m_params);die;

$has_rule = true;

$single_content = array(); // 單層資料流
$content = array(); // 己處理過後，或者是多層資料流

// 其它參數
if($m_params and count($m_params) > 0){
	foreach($m_params as $k => $v){
		if($k == 'get' and preg_match('/^(.*)---(.*)$/', $v, $matches)){
			if(isset($_GET[$matches[1]])){
				$old_get[$matches[1]] = $matches[2];
			}
			$_GET[$matches[1]] = $matches[2];
		}
	}
}

// 資料流
if(preg_match('/^(.*)\:(.*|)$/', $layer_data_source, $matches)){
	$table = $matches[1];
	$condition = $matches[2];

	if($table == 'webmenu'){
		$_position = $condition;

		if(isset($ID)){
			$OLDID = $ID;
		}
		unset($ID);

		if(isset($m_params['webmenu_navlight_name']) and $m_params['webmenu_navlight_name'] != ''){
			$this->data['_webmenu_navlight_name'] = $m_params['webmenu_navlight_name'];
		}

		if(isset($m_params['enableurl_by_subclass_haschild']) and $m_params['enableurl_by_subclass_haschild'] != ''){
			$this->data['_enableurl_by_subclass_haschild'] = $m_params['enableurl_by_subclass_haschild'];
		}

		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			include 'source/menu/v2.php';
		} else {
			include _BASEPATH.'/../source/menu/v2.php';
		}

		if(isset($m_params['webmenu_navlight_name']) and $m_params['webmenu_navlight_name'] != ''){
			unset($this->data['_webmenu_navlight_name']);
		}

		if(isset($m_params['enableurl_by_subclass_haschild']) and $m_params['enableurl_by_subclass_haschild'] != ''){
			unset($this->data['_enableurl_by_subclass_haschild']);
		}

		if($condition == 'mobile'){
			foreach($tmp as $k => $v){
				if(isset($v['has_child']) and $v['has_child'] === true and isset($v['child']) and count($v['child']) > 0){
					$v['attr2'] = ' href="javascript:;" ';
				}
				$tmp[$k] = $v;
			}
		}

		$single_content = $tmp;
		unset($tmp);
		unset($_position);

		if(isset($OLDID)){
			$ID = $OLDID;
			unset($OLDID);
		}
	} elseif($table == 'top_link_menu'){
		$_position = $condition;

		if(isset($ID)){
			$OLDID = $ID;
		}
		unset($ID);

		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			include 'source/top_link_menu/v1.php';
		} else {
			include _BASEPATH.'/../source/top_link_menu/v1.php';
		}
		$single_content = $result;
		unset($result);
		unset($_position);

		if(isset($OLDID)){
			$ID = $OLDID;
			unset($OLDID);
		}
	} elseif($table == 'breadcrumb'){
		if(isset($ID)){
			$OLDID = $ID;
		}
		unset($ID);

		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			include 'source/core/breadcrumb.php';
		} else {
			include _BASEPATH.'/../source/core/breadcrumb.php';
		}

		$single_content = $tmps;
		unset($tmps);

		if(isset($OLDID)){
			$ID = $OLDID;
			unset($OLDID);
		}
	} elseif($table == 'v3_source' and $condition != '' and preg_match('/^(.*)\,(.*|)$/', $condition, $matches) and isset($this) ){
		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			$path = 'source/'.$matches[1].'.php';
		} else {
			$path = _BASEPATH.'/../source/'.$matches[1].'.php';
		}
		if(file_exists($path)){
			unset($old_router_method); // 2018-09-10

			if(isset($ID)){
				$OLDID = $ID;
			}
			$ID = 'v3_source';

			if(isset($matches[2]) and $matches[2] != ''){
				$old_router_method = $this->data['router_method'];
				$this->data['router_method'] = $matches[2];
			}

			include $path;
			if(isset($data[$ID])){
				$single_content = $data[$ID];
			}

			if(isset($OLDID)){
				$ID = $OLDID;
				unset($OLDID);
			}

			if(isset($matches[2]) and $matches[2] != ''){
				$this->data['router_method'] = $old_router_method;
			}

			unset($old_router_method); // 2018-09-10
		}
	} elseif($table == 'id'){
		if(isset($data[$condition])){
			$single_content = $data[$condition];
		}
	} elseif($table == 'html'){ // 通用資料表
		$o = $cidb->select('*, topic as name');
		$o = $o->where(array('is_enable' => 1, 'ml_key' => $current_lang, 'type' => $condition));
		if($m_params and count($m_params) > 0){ // 2017-12-05 李哥下午說要加上去的
			foreach($m_params as $k => $v){
				if(preg_match('/^andwhere/', $k) and preg_match('/^(.*)---(.*)$/', $v, $matches)){
					$o = $o->where($matches[1], $matches[2]);
				}
			}
		}

		if(isset($m_params['andlike']) and preg_match('/^(.*)---(.*)---(.*)$/', $m_params['andlike'], $matches)){
			$andlike_position = 'both';
			if($matches[3] == '1'){
				$andlike_position = 'before';
			} elseif($matches[3] == '2'){
				$andlike_position = 'after';
			} elseif($matches[3] == '3'){
				$andlike_position = 'none';
			}
			$o = $o->like($matches[1], $matches[2], $matches[3]);
		}

		if(isset($m_params['orderby']) and $m_params['orderby'] != ''){
			$o = $o->order_by($m_params['orderby']);
		} else {
			$o = $o->order_by('sort_id');
		}
		$o = $o->get($table);
		$single_content = $o->result_array();
	} elseif($table == 'custom'){ // 自行指定條件
		$o = $cidb;
		if($m_params and count($m_params) > 0){ // 2017-12-05 李哥下午說要加上去的
			foreach($m_params as $k => $v){
				if(preg_match('/^andwhere/', $k) and preg_match('/^(.*)---(.*)$/', $v, $matches)){
					$o = $o->where($matches[1], $matches[2]);
				}
			}
		}

		if(isset($m_params['andlike']) and preg_match('/^(.*)---(.*)---(.*)$/', $m_params['andlike'], $matches)){
			$andlike_position = 'both';
			if($matches[3] == '1'){
				$andlike_position = 'before';
			} elseif($matches[3] == '2'){
				$andlike_position = 'after';
			} elseif($matches[3] == '3'){
				$andlike_position = 'none';
			}
			$o = $o->like($matches[1], $matches[2], $matches[3]);
		}

		if(isset($m_params['orderby']) and $m_params['orderby'] != ''){
			$o = $o->order_by($m_params['orderby']);
		}
		$o = $o->get($condition);
		$single_content = $o->result_array();
	} else { // 獨立分類資料表 2017-11-27 有跟lota說明這個新的資料流
		$table = str_replace('*', '', $table); // 為了要讓資料表名稱，可以使用保留字 2017-12-07
		if($this->cidb->table_exists($table)){
			$o = $cidb->select('*, name as topic');
			$o = $o->where(array('is_enable' => 1, 'ml_key' => $current_lang));
			if($m_params and count($m_params) > 0){ // 2017-12-05 李哥下午說要加上去的
				foreach($m_params as $k => $v){
					if(preg_match('/^andwhere/', $k) and preg_match('/^(.*)---(.*)$/', $v, $matches)){
						$o = $o->where($matches[1], $matches[2]);
					}
				}
			}

			if(isset($m_params['andlike']) and preg_match('/^(.*)---(.*)---(.*)$/', $m_params['andlike'], $matches)){
				$andlike_position = 'both';
				if($matches[3] == '1'){
					$andlike_position = 'before';
				} elseif($matches[3] == '2'){
					$andlike_position = 'after';
				} elseif($matches[3] == '3'){
					$andlike_position = 'none';
				}
				$o = $o->like($matches[1], $matches[2], $matches[3]);
			}

			if(isset($m_params['orderby']) and $m_params['orderby'] != ''){
				$o = $o->order_by($m_params['orderby']);
			} else {
				$o = $o->order_by('sort_id');
			}
			$o = $o->get($table);
			$single_content = $o->result_array();
		}
	}
} elseif(preg_match('/^(\d+)$/', $layer_data_source, $matches)){ // 2018-10-23
	$layoutv3_datasource_id = $matches[1];
	if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
		include 'layoutv3/dom5/datasource.php';
	} else {
		include _BASEPATH.'/../layoutv3/dom5/datasource.php';
	}
	return; // 這裡不支援平面化，記到…
} else {
	if(isset($data[$layer_data_source]) and count($data[$layer_data_source]) > 0){
		$single_content = $data[$layer_data_source];
	} elseif(!isset($data[$layer_data_source]) and isset($this) and isset($this->data[$layer_data_source])){ // lota建議
		$single_content = $this->data[$layer_data_source];
	}
}

if(isset($data_return) and preg_match('/layer/', $layer_parent)){ // 固定規則專用
	unset($layer_debug_first);
	$run = '$layer_debug_first = $html->'.$layer_parent.'->debug_first;';
	@eval($run); // gg
	if(isset($layer_debug_first) and $layer_debug_first != ''){
	?>
<meta charset="utf-8">
	<?php
		new dBug($single_content,'',true);
		die;
	}
} else {
	if(isset($layer_debug_first) and $layer_debug_first == true){
	?>
<meta charset="utf-8">
	<?php
		new dBug($single_content,'',true);
		die;
	}
}

// var_dump($single_content);

/*
 * 未結合的單層結構處理階段
 *
 * 分項階段
 */

// 這裡是下規則處理單層的地方，提供可擴充的環境區塊給它
if(count($single_content) > 0){
	if(isset($m_params['filter_key']) and $m_params['filter_key'] != ''){
		$tmpsggg = explode('.', $m_params['filter_key']);
		$run = '$single_content = $single_content';
		foreach($tmpsggg as $k => $v){
			$run .= '["'.$v.'"]';
		}
		$run .= ';';

		// 2018-03-05 加上小老鼠是因為，有可能那個元素是不存在的
		@eval($run);
	}

	if(isset($m_params['filter_key2']) and $m_params['filter_key2'] != ''){
		$tmpsggg = explode('.', $m_params['filter_key2']);
		$run = '$single_content = $single_content';
		foreach($tmpsggg as $k => $v){
			if($k != count($tmpsggg)-1){
				$run .= '["'.$v.'"]';
			}
		}
		$run .= ';';
		eval($run);

		foreach($single_content as $k => $v){
			if($k != $tmpsggg[count($tmpsggg)-1]){
				unset($single_content[$k]);
			}
		}
	}

	if(isset($m_params['callfunc']) and preg_match('/^(.*)---(.*)---(.*)$/', $m_params['callfunc'], $matches)){
		// ex: nl2br---field_tmp---field_tmp_ggg
		$condition2 = $matches[1];
		$condition = $matches[2];
		$new_var = $matches[3];
		foreach($single_content as $k => $v){
			$run = '$single_content['.$k.']["'.$new_var.'"] = '.$condition2.'($single_content['.$k.']["'.$condition.'"]);';
			@eval($run);
		}
		unset($new_var);
	}

	if(isset($m_params['search_table_by_field_get_one']) and preg_match('/^(.*)---(.*)---(.*)---(.*)---(.*)$/', $m_params['search_table_by_field_get_one'], $matches) and count($single_content) > 0 and isset($single_content[0][$condition])){
		$condition2 = $matches[1]; // table
		$condition = $matches[2]; // current field
		$new_var = $matches[3]; // search field
		$new_var2 = $matches[4]; // get field
		$new_var3 = $matches[5]; // new field

		foreach($single_content as $k => $v){
			$rowggg = $cidb->where($new_var,$v[$condition])->get($condition2)->row_array();
			$v[$new_var3] = '';
			if($rowggg and isset($rowggg[$new_var2])){
				$v[$new_var3] = $rowggg[$new_var2];
			}
			$single_content[$k] = $v;
		}
		unset($new_var);
		unset($new_var2);
		unset($new_var3);
	}


	$pidas = 'pid';
	if(isset($m_params['pidas']) and $m_params['pidas'] != ''){
		$pidas = $m_params['pidas'];
	}
	if(isset($m_params['filter']) and preg_match('/^(.*)---(.*)$/', $m_params['filter'], $matches)){
		// ex: name---shop_footer_link
		$condition2 = $matches[1];
		$condition = $matches[2];

		foreach($single_content as $k => $v){
			if($v[$pidas] == 0 and $v[$condition2] != $condition){
				unset($single_content[$k]);
			}
		}
	} elseif(isset($m_params['index']) and preg_match('/^(.*)---(.*)$/', $m_params['index'], $matches)){
		// ex: name---shop_footer_link
		$condition2 = $matches[1];
		$condition = $matches[2];

		// 將節點設定在指定的條件
		$tmp_id = 0;
		foreach($single_content as $k => $v){
			if($v[$pidas] == 0){
				if($v[$condition2] == $condition){
					$tmp_id = $v['id'];
				}
				unset($single_content[$k]);
			}
		}
		if($tmp_id > 0){
			foreach($single_content as $k => $v){
				if($v[$pidas] == $tmp_id){
					$single_content[$k][$pidas] = 0;
				}
			}
		}
	}
}

// var_dump($single_content);

// 李哥建議移植過來 2017-12-05
// 要記得，這裡只能跑多筆資料，單筆的那一種不行
if(count($single_content) > 0 and isset($table)){
	foreach($single_content as $kk => $vv){
		// 如果不是陣列，代表操作者去選擇到單筆的結構，所以這邊跳過去不處理
		if(!is_array($vv)){
			continue;
		}
		foreach($vv as $kkk => $vvv){
			if(preg_match('/^pic(.*)$/', $kkk, $matches) and $vvv != '' and !preg_match('/^(id)$/', $table)){
				if($table == 'html' and isset($vv['type'])){
					$vvv = '_i/assets/upload/'.$vv['type'].'/'.$vvv;
				} else {
					$vvv = '_i/assets/upload/'.$table.'/'.$vvv;
				}
				$vv['pic'.$matches[1].'_'] = $vvv;
			} elseif(preg_match('/^file(.*)$/', $kkk, $matches) and $vvv != '' and !preg_match('/^(id)$/', $table)){
				if($table == 'html'){
					$vvv = '_i/assets/file/'.$vv['type'].'/'.$vvv;
				} else {
					$vvv = '_i/assets/file/'.$table.'/'.$vvv;
				}
				$vv['file'.$matches[1].'_'] = $vvv;
			}
			// $vv[$kkk] = $vvv;
		}

		// 2018-12-06
		$vv['_serial_number'] = $kk+1;

		$single_content[$kk] = $vv;
	}
}

// var_dump($single_content);

// 分析結構，是否為多層，為了後續的處理
$has_single_content_rows = false; // 是否有多筆
$has_single_content_pid = false; // 是否有pid欄位
$has_single_content_multi_layer = false; // 是否有child
if(count($single_content) > 0){
	$pidas = 'pid';
	if(isset($m_params['pidas']) and $m_params['pidas'] != ''){
		$pidas = $m_params['pidas'];
	}
	foreach($single_content as $kk => $vv){
		if(is_numeric($kk)){
			$has_single_content_rows = true;
		}
		// if(is_array($vv) and count($vv) > 0){
		// 	foreach($vv as $kkk => $vvv){
		// 		break;
		// 	}
		// }
		// if($has_single_content_multi_layer === true){
		// 	break;
		// }
		// if($has_single_content_pid === true){
		// 	break;
		// }
		if(isset($vv['child'])){
			$has_single_content_multi_layer = true;
		}
		if(isset($vv[$pidas])){
			$has_single_content_pid = true;
		}
	}
}

// var_dump($single_content);

/*
 * 單層轉多層
 * 　└ 讓無限層處理的程式區塊，分享給其它使用
 *
 * 無限層階段
 */
if(
	(
		(
			(
				// 如果是無限層
				// ( isset($table) and !preg_match('/^(webmenu|top_link_menu|breadcrumb|v3_source|id|html|custom)$/', $table) )
				// or 
				// 如果是單層結構，且有pid欄位
				($has_single_content_multi_layer === false and $has_single_content_pid === true)
				// or
				// 如果有特別指定pid欄位，而且是單層結構
				// ( isset($m_params['pidas']) and $m_params['pidas'] != '' and $has_single_content_multi_layer === false )
			)
			and
			// 如果是，那它們必需要是多筆的
			$has_single_content_rows === true
		) 
		or
		isset($m_params['single_to_multi_check_ignore']) and $m_params['single_to_multi_check_ignore'] != ''
	)
	and
	(!isset($m_params['single_to_multi_flow_pass']) or $m_params['single_to_multi_flow_pass'] == '0')
){
	$pidas = 'pid';
	if(isset($m_params['pidas']) and $m_params['pidas'] != ''){
		$pidas = $m_params['pidas'];
	}

	// 為了要重建主選單能用的attr2屬性(webmenuchild)
	if($single_content and isset($single_content[0]) and isset($single_content[0]['url'])){
		foreach($content as $k => $v){
			$v['__link'] = $v['url'];
			$single_content[$k] = $v;
		}
	}

	// 檢查是否有必要的欄位pid，沒有的話補零，當做是根層
	// 會這樣子撰寫，是因為在上面，有可能第一筆(0)是不存在的
	foreach($single_content as $k => $v){
		// if(isset($v[$pidas])){
		// 	break;
		// }
		if(!isset($v[$pidas])){
			$v[$pidas] = 0;
		}
		$single_content[$k] = $v;
	}

	$indexedItems = array();

	// index elements by id
	foreach ($single_content as $item) {
		$item['child'] = array();
		$indexedItems[$item['id']] = (object) $item;
	}

	// assign to parent
	$topLevel = array();
	foreach ($indexedItems as $item) {
		if ($item->{$pidas} == 0) {
			$topLevel[] = $item;
		} else {
			$indexedItems[$item->{$pidas}]->child[] = $item;
		}
	}
	$tree = std_class_object_to_array($topLevel);

	// var_dump($tree);die;

	$tree_tmps = explode("\n", var_export($tree, true));
	if($tree_tmps){

		// 加上深度欄位
		foreach($tree_tmps as $kk => $vv){
			if(preg_match('/^(.*)\'name\'\ =>/', $vv, $matches)){
				// 4個字元為1層，以此類推
				// $depth = (strlen($matches[1]) / 4) + 1;
				$depth = (strlen($matches[1]) / 4);
				$tree_tmps[$kk] = $matches[1].'\'depth\' => \''.$depth.'\','.$vv;
			}
		}

		// 符合某個條件，就加上某個欄位
		// AAA---BBB---CCC---YYY---ZZZ
		// 條件  key   value
		if(isset($m_params['condition_append_element']) and preg_match('/^(.*)\|(.*)\|(.*)---(.*)---(.*)$/', $m_params['condition_append_element'], $matches)){

			// 先合併，在重新切割
			$run = '$tree = '.implode("\n", $tree_tmps).';';
			eval($run);
			$tree_tmps = explode("\n", var_export($tree, true));

			$depth_append_element_condition = array();
		   	$depth_append_element_condition[0] = $matches[1]; // 什麼欄位
		   	$depth_append_element_condition[1] = $matches[2]; // 例如：==、!=、%2 ==(偶數為0，奇數為1)
		   	$depth_append_element_condition[2] = $matches[3]; // 數值是多少

			$depth_append_element_key = $matches[4];
			$depth_append_element_value = $matches[5];

			// 純參考，沒有任何意義 
			// $kk % 2 == 0 偶數
			// $kk % 2 == 1 奇數
			foreach($tree_tmps as $kk => $vv){
				if(preg_match('/^(.*)\''.$depth_append_element_condition[0].'\'\ => \'(.*)\',/', $vv, $matches)){
					$depth_append_element_result = false;
					$run = <<<XXX

					if(\$matches[2] {$depth_append_element_condition[1]} '{$depth_append_element_condition[2]}' ){
						\$depth_append_element_result = true;
					}
XXX;
					eval($run);

					if($depth_append_element_result === true){
						$tree_tmps[$kk] = $matches[1].'\''.$depth_append_element_key.'\' => \''.$depth_append_element_value.'\','.$vv;
					}
				}
			}
		// 在某一層加上某個欄位
		// XXX---YYY---ZZZ
		// 層級  key   value
		} elseif(isset($m_params['depth_append_element']) and preg_match('/^(.*)---(.*)---(.*)$/', $m_params['depth_append_element'], $matches)){

			// 先合併，在重新切割
			$run = '$tree = '.implode("\n", $tree_tmps).';';
			eval($run);
			$tree_tmps = explode("\n", var_export($tree, true));

			$depth_append_element_target = $matches[1];
			$depth_append_element_key = $matches[2];
			$depth_append_element_value = $matches[3];

			foreach($tree_tmps as $kk => $vv){
				if(preg_match('/^(.*)\'depth\'\ => \'(.*)\',/', $vv, $matches)){
					if($depth_append_element_target == $matches[2]){
						$tree_tmps[$kk] = $matches[1].'\''.$depth_append_element_key.'\' => \''.$depth_append_element_value.'\','.$vv;
					}
				}
			}
		}
	}

	$run = '$tree = '.implode("\n", $tree_tmps).';';
	eval($run);

	$aaa = check_field_and_rebuild_array_by_multi_layer_menu($tree, array());

	// 2019-01-23 如果欄位值，裡面有單引號，就會報錯，有這種情況，就不要經過這裡
	// 2019-01-30 有修正source/menu/v2.php裡面的check_field_and_rebuild_array_by_multi_layer_menu()函式
	$aaa = '$tmpg = array('."\n".$aaa."\n".');';
	eval($aaa);

	$single_content = $tmpg;
}

// var_dump($single_content);

//var_dump($has_single_content_multi_layer);
/*
 * 己處理完後的結構，做條件處理
 *
 * 結尾階段
 */
if(count($single_content) > 0){
	if(isset($m_params['search_and_get_element']) and preg_match('/^(.*)---(.*)---(.*)$/', $m_params['search_and_get_element'], $matches)){
		foreach($single_content as $k => $v){
			if($v[$matches[1]] == $matches[2] and isset($v[$matches[3]])){
				$single_content = $v[$matches[3]];

				// 2018-07-16 修正pid的問題
				if(count($single_content) > 0){
					$pidas = 'pid';
					if(isset($m_params['pidas']) and $m_params['pidas'] != ''){
						$pidas = $m_params['pidas'];
					}
					foreach($single_content as $kk => $vv){
						if(isset($vv[$pidas])){
							$single_content[$kk][$pidas] = 0;
						}
					}
				}
				break;
			}
		}
	}

	// 分頁
	// 新變數名---一頁幾筆---網址
	if(isset($m_params['pagenav']) and preg_match('/^(.*)---(.*)---(.*)$/', $m_params['pagenav'], $matches) 
		and $has_single_content_rows === true and $has_single_content_multi_layer === false
		// and isset($_GET['page']) and $_GET['page'] > 0
	){
		$pagenav_assign = $matches[1];
		$limit_count = $matches[2];
		$url = $matches[3];

		// 濾掉分頁，然後放在另外一個變數
		$url = str_replace('?&page=', '', $url);
		$url = str_replace('&page=', '', $url);
		$url = str_replace('?page=', '', $url);

		$with = '?';
		if(preg_match('/\?/', $url)){
			$with = '&';
		}
		$with .= 'page=';

		$pagew = 1; // Splitpage
		if(isset($_GET['page']) and $_GET['page'] > 0){
			$pagew = $_GET['page'];
		}

		// 記得，切出來以後，是從零開始
		$rows = array();
		$rows_tmp = array_chunk($single_content, $limit_count);
		$total_record = count($single_content);
		$total_page = count($rows_tmp);

		// 先把陣列，改成從1開始
		if($rows_tmp and count($rows_tmp) > 0){
			foreach($rows_tmp as $k => $v){
				$rows[$k+1] = $v;
			}
		}

		// 如果有那一頁的話
		if(isset($rows[$pagew])){
			$single_content = $rows[$pagew];
		}

		$prev_url = $url;
		if(isset($rows[$pagew-1])){
			if( ($pagew-1) != 1 ){
				$prev_url .= $with.($pagew-1);
			}
		}

		$next_url = $url;
		if(isset($rows[$pagew+1])){
			if( ($pagew+1) != 1 ){
				$next_url .= $with.($pagew+1);
			}
		}

		$last_url = $url;
		if( count($rows) != 1 ){
			$last_url .= $with.count($rows);
		}

		// 重建
		$pagination = array(
			'control' => array(
				array(
					'name' => '當下頁數',
					'key' => 'now',
					'value' => $pagew, 
				),
				array(
					'name' => '第一頁',
					'key' => 'first',
					'value' => $url, 
				),
				array(
					'name' => '下一頁',
					'key' => 'next',
					'value' => $next_url, 
				),
				array(
					'name' => '最後一頁',
					'key' => 'last',
					'value' => $last_url,
				),
				array(
					'name' => '上一頁',
					'key' => 'prev',
					'value' => $prev_url, 
				),
				array(
					'name' => '總筆數',
					'key' => 'total_record',
					'value' => $total_record, 
				),
				array(
					'name' => '總頁數',
					'key' => 'total_page',
					'value' => $total_page, 
				),
				array(
					'name' => '每頁筆數',
					'key' => 'limit_count',
					'value' => $limit_count, 
				),
				array(
					'name' => '當下頁數 / 總頁數',
					'key' => 'now_and_total_page',
					'value' => $pagew.' / '.$total_page, 
				),
			),
			'number' => array(),
		);

		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$url2 = $url.$with.$k;
				if($k == 1){
					$url2 = $url;
				}

				$active = '';
				if($k == $pagew){
					$active = 'active';
				}

				$pagination['number'][] = array(
					'name' => $k,
					'active' => $active,
					'value' => $url2,
				);
			}
		}

		$data[$pagenav_assign] = $pagination;
		$this->data[$pagenav_assign] = $pagination;

		if(count($pagination['number']) <= 1){
			if(isset($html) and is_object($html)){
				$run = '$html->find("*[class=_dom5_layer_pagenav_]",0)->outertext = "";';
				@eval($run); // gg
				$run = '$html->find("*[id=_dom5_layer_pagenav_]",0)->outertext = "";';
				@eval($run); // gg
			}
		}

	} // pagenav

	// 這個規則，是放在這一區塊的最下面，記得
	if(isset($m_params['assign']) and $m_params['assign'] != ''){
		$data[$m_params['assign']] = $single_content;
	}
}

// 最後，放到$content，代表處理己告一段落
$content = $single_content;

if(isset($layer_parent) and preg_match('/layer/', $layer_parent)){ // 固定規則專用
	unset($layer_debug);
	$run = '$layer_debug = $html->'.$layer_parent.'->debug;';
	@eval($run); // gg
	if(isset($layer_debug) and $layer_debug != ''){
	?>
	<meta charset="utf-8">
	<?php
		new dBug($content,'',true);
		die;
	}
} else {
	if($layer_debug == true){
	?>
<meta charset="utf-8">
	<?php
		new dBug($content,'',true);
		die;
	}
}


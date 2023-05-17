<?php

//     // 範例
//     // 2017-09-12 試著用後台的分類來取代原有的作法
//     $o = $this->cidb->select('id');
//     $o = $o->where('is_enable',1)->where('type',$this->data['router_method'])->where('ml_key',$this->data['ml_key']);
//     // $o = $o->where('class_id', $class_id);
//     $rows = $o->get('html')->result_array();
//     $total_rows = count($rows);

//     include 'source/core/pagination.php';

/*
 * 分頁區塊
 * 為了縮減程式碼
 */
$splitpage = new Splitpage;
if(defined('LAYOUTV3_STRUCT_MODE')){
	if(LAYOUTV3_STRUCT_MODE == 'cig_frontend'){
		$splitpage->set($total_rows, $pagew, $limit_count, 10);
	} else {
		$splitpage->set($pagew, $total_rows, $limit_count, 10); //set($page, $total_records, $records_per_page, $listPage)
	}
}
// $base_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?page=';
$base_url = $url;
$base_url2 = $base_url;
//$base_url .= $param_define['page'];
//$base_url .= $pagew;

$pagination = $splitpage->setViewList_for_rewrite($base_url, $base_url2); // 取得分頁bar的變數
	
if($pagination and isset($pagination['number']) and !empty($pagination['number'])){
	
	if(!isset($pagination['control']['prev'])){
		$pagination['control']['prev'] = '';
	}
	if(!isset($pagination['control']['next'])){
		$pagination['control']['next'] = '';
	}

	if(!isset($pagination['control']['prevten'])){
		$pagination['control']['prevten'] = '';
	}
	if(!isset($pagination['control']['nextten'])){
		$pagination['control']['nextten'] = '';
	}

	// 2018-06-20 將一些原本寫在html上的判斷，寫過來這裡，簡化html上面的程式碼
	$prev_url = '';
	if($pagination['control']['prev'] != ''){
		// 2017-07-26 李哥說要改的，他說是Ming說的
		$prev_url = $pagination['control']['prev'];
		if(preg_match('/page\=1$/', $prev_url)){
			$prev_url = str_replace('?&page=1', '', $prev_url);
			$prev_url = str_replace('&page=1', '', $prev_url);
			$prev_url = str_replace('?page=1', '', $prev_url);
		}
	}
	$pageRecordInfo['prev_url'] = $prev_url;

	$next_url = '';
	if($pagination['control']['next'] != ''){
		$next_url = $pagination['control']['next'];
	}

	$rows = array();
	foreach($pagination['number'] as $k => $v){
		if($v['name'] == $pagination['control']['now']){
			$rows[] = array('name' => $v['name'], 'url' => '');
		} else {
			// 2017-07-26 李哥說要改的，他說是Ming說的
			$url2 = $v['link'];
			if(preg_match('/page\=1$/', $url2)){
				$url2 = str_replace('?&page=1', '', $url2);
				$url2 = str_replace('&page=1', '', $url2);
				$url2 = str_replace('?page=1', '', $url2);
			}
			$v['link'] = $url2;
			$pagination['number'][$k] = $v;
			$rows[] = array('name' => $v['name'], 'url' => $url2);
		}
	}
	
	$pageRecordInfo['pagination'] = $pagination;
	$pageRecordInfo['prev_url'] = $prev_url;
	$pageRecordInfo['next_url'] = $next_url;
	$pageRecordInfo['nopage_url'] = $url;
	$pageRecordInfo['pages'] = $rows;

	$pageRecordInfo['prevten_url'] = $pagination['control']['prevten'];
	$pageRecordInfo['nextten_url'] = $pagination['control']['nextten'];

	// var_dump($pageRecordInfo);

	// $view_file = 'v3/pagenav';
	// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	// 	$data[$layoutv3_struct_map_keyname[$view_file][0]] = $pageRecordInfo;
	// }
}

//     // 範例
//     $o = $this->cidb;
//     $o = $o->where('is_enable',1)->where('type',$this->data['router_method'])->where('ml_key',$this->data['ml_key']);
//     // $o = $o->where('class_id', $class_id);
//     $o = $o->order_by('start_date','desc');
//     $rows = $o->get('html', $limit_count, ($pagew-1) * $limit_count)->result_array();

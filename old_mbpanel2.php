<?php

include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

// 處理資料來源，在不預設欄位結構名稱的情況下，轉譯成mbpanel所需要的資料來源
if(!function_exists('check_field_and_rebuild_array')){
	function check_field_and_rebuild_array($items) {
		// $render = 'array('."\n";
		$render = '';

		foreach ($items as $k => $item) {
			$render .= $k.'=>array('."\n";

			if(!isset($item['link'])){
				if(isset($item['url1']) and $item['url1'] != ''){
					$item['link'] = $item['url1'];
				} elseif(isset($item['url']) and $item['url'] != ''){
					$item['link'] = $item['url'];
				} elseif(isset($item['__link']) and $item['__link'] != ''){ // 獨立資料表專用
					$item['link'] = $item['__link'];
				} else {
					$item['link'] = '';
				}
			}

			if (!empty($item['submenu'])) {
				// if(isset($item['link'])){
				// 	$item['link'] = '#_';
				// }
				$render .= '\'submenu\'=>array('."\n";
				$render .= check_field_and_rebuild_array($item['submenu']);
				$render .= '),'."\n"; // submenu
			}

			// 跟隨後台的前台主選單的"是否有次選單"的功能
			// http://redmine.buyersline.com.tw:4000/issues/26547
			if(isset($item['has_child'])){
				if($item['has_child'] === true){ 
					if(isset($item['link'])){
						$item['link'] = '#_';
					}
				} else {
					$item['submenu'] = '';
				}
			}

			if(!isset($item['content'])){
				if(isset($item['name']) and $item['name'] != ''){
					$item['content'] = $item['name'];
				} elseif(isset($item['topic']) and $item['topic'] != ''){
					$item['content'] = $item['topic'];
				} else {
					$item['content'] = '';
				}
			}

			if(!isset($item['class'])){
				$item['class'] = '';
			}
			if(!isset($item['target'])){ // 這個是data-target
				$item['target'] = '';
			}
			if(!isset($item['target2'])){ // 這個是target
				$item['target2'] = '';
			}
			if(!isset($item['submenu'])){
				$item['submenu'] = '';
			}

			foreach($item as $kk => $vv){
				// 2018-01-17 如果有發現target裡面，有加上blank以後發現問題，記得要把底下target那一項拿掉
				if(!is_array($vv) and preg_match('/^(content|class|target|target2|link|submenu)$/', $kk)){

					$render .= '\''.$kk.'\'=>\''.$vv.'\','."\n";

					// 2018-02-08 試著改寫成這樣，在看後續會不會有問題
					//if($kk == 'target'){
					//	$render .= '\'target2\'=>\''.$vv.'\','."\n"; // 如果沒有這樣子寫，這裡的target，最後會變成data-target
					//} else {
					//	$render .= '\''.$kk.'\'=>\''.$vv.'\','."\n";
					//}

					// debug
					// file_put_contents('123.txt',$render,FILE_APPEND);
				}
			}
			
			$render .= '),'."\n";
		}

		// $render .= '),'."\n"; // 為什麼註解不要問我

		return $render."\n";
	}
}

$panel = array(
	'mbPanelSet'=>array(),
	'mbPanelDataSet'=> array(),
);

// 先找有啟用的一筆範本
// $row = $this->cidb->where('pid',0)->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get('mbpanel')->row_array();

// 2017-11-23 下班前winnie說，形像網站會遇到各個語系的手機版選單不一樣的情況是沒有的，只有購物站才有遇過
$row = $this->cidb->where('pid',0)->where('is_enable',1)->where('ml_key','tw')->get('mbpanel')->row_array();

if(!$row or !isset($row['id'])){
	header("Content-type: text/javascript");
	echo json_encode(array('mbPanel'=>$panel));
	die;
}

// 範本編號
$sample_id = $row['sort_id'] - 1;

$panel['mbPanelSet']['effect'] = $row['set_effect'];
$panel['mbPanelSet']['panels'] = array();

// 取得panel
// $panels = $this->cidb->where('pid',$row['id'])->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get('mbpanel')->result_array();

// 2017-11-23 下班前winnie說，形像網站會遇到各個語系的手機版選單不一樣的情況是沒有的，只有購物站才有遇過
$panels = $this->cidb->where('pid',$row['id'])->where('is_enable',1)->where('ml_key','tw')->order_by('sort_id','asc')->get('mbpanel')->result_array();

if(!$panels or count($panels) <= 0){
	header("Content-type: text/javascript");
	echo json_encode(array('mbPanel'=>$panel));
	die;
}

// 將整個樹先建立起來
// $items = $this->cidb->select('id, pid, data_class as class, data_content as content, data_link as link, data_target as target')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get('mbpanel')->result_array();

// 2017-11-23 下班前winnie說，形像網站會遇到各個語系的手機版選單不一樣的情況是沒有的，只有購物站才有遇過
$items = $this->cidb->select('id, pid, data_class as class, data_content as content, data_link as link, data_target as target, data_target2 as target2')->where('is_enable',1)->where('ml_key','tw')->get('mbpanel')->result_array();

// 2017-11-27 winnie下午在logo那邊發現的問題
foreach ($items as $k => $v){
	$v['content'] = str_replace('ML_KEY', $this->data['ml_key'], $v['content']);

	// SEO
	// if($v['class'] == 'logo'){
	// 	if($this->data['ml_key'] == 'tw'){
	// 		$v['link'] = '/tw';
	// 	}
	// }

	$items[$k] = $v;
}

$indexedItems = array();

// index elements by id
foreach ($items as $item) {
	$item['submenu'] = array();
	$indexedItems[$item['id']] = (object) $item;
}


// assign to parent
$topLevel = array();
foreach ($indexedItems as $item) {
	if ($item->pid == 0) {
		$topLevel[] = $item;
	} else {
		$indexedItems[$item->pid]->submenu[] = $item;
	}
}

$treex = std_class_object_to_array($topLevel);

// var_dump($topLevel);die;
// var_dump($treex);die;

/*
 * 動態資料來源，預載的地方
 */

// MLS
$data['mls'] = array();

// 2020-01-22
$tmp = array();
include _BASEPATH.'/../source/core/mls.php';
if(!empty($tmp)){
	foreach($tmp as $k => $v){
		$target = '';
		if(isset($v['target'])){
			$target = $v['target'];
		}

		$xxx = array(
			'content' => $v['name'], 
			'link' => $v['url'], 
			'class' => '', 
			'target' => '',
			'target2' => $target,// 2019-10-23 加入後台設定另開視窗 by lota
			'submenu' => '',
		);
		$data['mls'][] = $xxx;
	}
}

// foreach($this->data['mls'] as $k => $v){
// 	//2018-07-05 加入後台更改特定網址 by lota
// 	if(isset($v['change_url']) && $v['change_url']!=''){
// 		$_link = $v['change_url'];
// 	}else{
// 		$_link = 'change_language.php?lang='.$k;
// 	}
// 
// 	// SEO
// 	// if($k == 'en'){
// 	// 	$_link = '/';
// 	// } else {
// 	// 	$_link = '/tw/';
// 	// }
// 
// 	$data['mls'][] = array(
// 		'content'=>$v['name'], 
// 		'link'=>$_link, 
// 		'class'=>'', 
// 		'target'=>'',
// 		'target2'=>$v['target'],// 2019-10-23 加入後台設定另開視窗 by lota
// 		'submenu'=>''
// 	);
// 
// 	unset($_constant);
// 	eval('$_constant = SIMPLE_TRANSLATE;');
// 	if($_constant == 1 and $k == 'tw'){ //繁簡切換
// 		if(isset($v['change_url']) && $v['change_url']==''){
// 			$data['mls'][count($data['mls'])-1]['link'] = $_link.'&tw_cn=1';
// 		}
// 		$data['mls'][] = array(
// 			'content'=>'简体中文', 
// 			'link'=>'change_language.php?tw_cn=1&lang=cn', 
// 			'class'=>'', 
// 			'target'=>'',
// 			'submenu'=>''
// 		);
// 	}
// }

// 動態網址 (第2版) 2018-03-26 李哥下午說OK，可以做
if(file_exists(_BASEPATH.'/assets/_dynamic_url.php')){
	include _BASEPATH.'/assets/_dynamic_url.php';
	if(isset($_dynamic_url) and count($_dynamic_url) > 0){
		foreach($_dynamic_url as $k => $v){
			if(isset($_SESSION[$v.'_dynamic_ignore']) and $_SESSION[$v.'_dynamic_ignore'] === true){ // 2017-10-23 測試中
				unset($_SESSION[$v.'_dynamic_ignore']);
			} else {
				// if($this->data['router_method'] != $v){ // 2018-04-30 這個在手機版選單會出問題
				if($this->data['router_method'] != $v and !isset($_SESSION['save'][$v.'_dynamic_url'])){
					$_SESSION['save'][$v.'_dynamic_url'] = substr(md5(microtime()),rand(0,26),15);
				}
			}
			if($this->data['router_method'] == $v){
				if(!isset($_SESSION['save'])){
					$_SESSION['save'] = array();
				}

				// 如果網頁停留太久，session timeout了以後，可能就會造成func_name_href那邊的出錯 2017-12-07
				if(!isset($_SESSION['save'][$v.'_dynamic_url']) ){
					header('Location: /');
					die;
				}

				$this->data['func_name_href'] = $v.'/'.$_SESSION['save'][$v.'_dynamic_url'].'.html';
			}
		}
	}
}

// TOP_LINK_MENU
$data['top_link_menu_top'] = array();
$data['top_link_menu_bottom'] = array();

if(!isset($_SESSION['save']['shop_car'])) $_SESSION['save']['shop_car'] = array();
$car_amount = count($_SESSION['save']['shop_car']);
if($car_amount < 0){
	$car_amount = 0;
}

foreach(array('top','bottom') as $kkkg => $kkka){
	unset($result);
	unset($_position);
	$_position = $kkka;
	include 'source/top_link_menu/v1.php';

	if($result and count($result) > 0){
		foreach($result as $k => $v){
			if($v['content2'] != ''){
				$v['content'] = $v['content2'];
			} else {
				$v['content'] = $v['icon'].'<span>'.$v['name'].' </span>'; // 2017-10-31 name後面那個空白，如果不加的話，有些情況會讓圖示出不來
			}
			$v['link'] = $v['url'];

			if(!isset($v['class'])){
				$v['class'] = '';
			}
			if(!isset($v['target'])){
				$v['target'] = '';
			}
			if(!isset($v['target2'])){
				$v['target2'] = '';
			}

			// 為了支援top選單裡面的浮起來的選單，以及class樣式
			if(isset($v['anchor_open']) and trim($v['anchor_open']) != ''){

				// 這裡會用到的是：產品搜尋、Google站內搜尋、購物車、漢堡
				if(preg_match('/class\=\'(.*)\'\ data\-target\=\'(.*)\' href=\'(.*)\'/', $v['anchor_open'], $matches)){ // 2020-02-26 漢堡專用
					$v['class'] = $matches[1];
					$v['target'] = $matches[2];
					$v['link'] = $matches[3];
				} elseif(preg_match('/class\=\'(.*)\'\ data\-target\=\'(.*)\'/', $v['anchor_open'], $matches)){
					$v['class'] = $matches[1];
					$v['target'] = $matches[2];
					$v['link'] = ''; // winnie 2017-11-14 下午說的
				} elseif(preg_match('/class\=\'(.*)\'\ /', $v['anchor_open'], $matches)){ // 善行數位
					$v['class'] = $matches[1];
					$v['link'] = ''; // winnie 2017-11-14 下午說的
				}

				// 舊的寫法，先切割，後處理
				// $tmp2 = explode(' ', trim($v['anchor_open']));
				// if($tmp2 and count($tmp2) > 0){
				// 	foreach($tmp2 as $kk => $vv){
				// 		if(preg_match('/^class\=\'(.*)\'$/', $vv, $matches)){
				// 			$v['class'] = $matches[1];
				// 		} elseif(preg_match('/^data\-target\=\'(.*)\'$/', $vv, $matches)){
				// 			$v['target'] = $matches[1];
				// 		}
				// 	}
				// }
			}

			// if($v['func'] == 'search'){
			// 	$v['class'] = 'openBtn';
			// 	$v['target'] = '#searchForm';
			// 	$v['link'] = '#link';
			// } elseif($v['func'] == 'googlesearch'){
			// 	$v['class'] = 'openBtn';
			// 	$v['target'] = '#cse_searchForm';
			// 	$v['link'] = '#link';

			// 唯獨語系才需要寫客製
			if($v['func'] == 'language'){
				$v['class'] = 'showPanel';
				$v['target'] = '#mbPanel_NavSubMenu';
				$v['link'] = '#_';
			}

			if($kkka == 'top'){

				// if($v['func'] == 'shop'){
				// 	$v['class'] = 'openBtn';
				// 	$v['target'] = '.sideCart';

				// 	// 要記得，上面己經有重改content的元素內容了，所以這裡不用在加上圖示icon
				// 	//$v['content'] = str_replace('購物車 ','',$v['content']);
				// 	//$v['content'] = str_replace('Shopping Car ','',$v['content']);
				// }

				// if(preg_match('/\<span\>(.*)\<\/span\>/', $v['content'],$matches)){
				// 		$v['content'] = str_replace($matches[1],'',$v['content']);
				// 	}
				// }
				if(preg_match('/^(shop)$/', $v['func'])){ // 有括號和數字的放這裡面，目前只有購物車
					// <i class="fa fa-shopping-cart"></i><span>購物車 (<span id="car_amount">0</span>)</span>
					if(preg_match('/\<span\>(.*)\ \(/', $v['content'], $matches)){ // shop在用的
						$v['content'] = str_replace($matches[1],'',$v['content']);
					}
				} else {
					if(preg_match('/\<span\>(.*)\<\/span\>/', $v['content'], $matches)){
						$v['content'] = str_replace($matches[1],'',$v['content']);
					}
				}

				// 2020-02-25
				//file_put_contents('123.txt',var_export($v,true),FILE_APPEND);

				$data['top_link_menu_top'][] = $v;
				// $panel['mbPanelDataSet']['navTop']['content'][0] = $v;
				//break; // 因為上方只會需要一筆，所以處理完直接跳出
			} else {
				$panel['mbPanelDataSet']['navBottom']['content'][] = $v;
				$data['top_link_menu_bottom'][] = $v;
			}
		}
	} else {
		// if($kkka == 'top'){
		// 	$panel['mbPanelDataSet']['navTop']['content'][0]['content'] = '';
		// }
	}
}

// MENU
$_position = 'mobile';
include 'source/menu/v2.php';

// 2017-12-13 如果要啟動menu/v2.php裡面的範本，那就有可能會用到這裡的debug方式
// file_put_contents('123.txt',var_export($tmp,true));

// 在處理資料來源的步驟之前，先做第一次的整理
$menu_tmp = '$tmp='.var_export($tmp,true).';';
$menu_tmp = str_replace('\'other2\'','\'target2\'',$menu_tmp); // 2019-07-24 政佳需要的
$menu_tmp = str_replace('\'anchor_class\'','\'class\'',$menu_tmp);
$menu_tmp = str_replace('\'anchor_data_target\'','\'target\'',$menu_tmp);
$menu_tmp = str_replace('\'child\'','\'submenu\'',$menu_tmp);
$menu_tmp = str_replace('\'url\'','\'link\'',$menu_tmp);
eval($menu_tmp);

// debug
//file_put_contents('123.php',var_export($tmp,true));

$aaa = check_field_and_rebuild_array($tmp);
// $aaas = explode("\n",$aaa);
$aaa = '$tmp = array('."\n".$aaa."\n".');';
eval($aaa);
//file_put_contents('123.php',var_export($tmp,true));
$data['menu'] = $tmp;

/*
{
	type:"side",
	pos:"mbPanel_left",
	id:"mbPanel_navMenu",
	content:{
		id:"panelMenu01",
		type:"panelMenu",
		style:[],
		data:"navMenuData",
	}
},
 */
foreach($panels as $k => $v){
	$content_styles = array();
	if($v['set_content_style'] != ''){
		$content_styles = explode(',', $v['set_content_style']);
	}

	$tmp = array(
		'type' => $v['set_panel_type'],
		'pos' => $v['set_panel_position'],
		'id' => $v['set_panel_id'],
		'content' => array(
			'id' => $v['set_content_id'],
			'type' => $v['set_content_type'],
			'style' => $content_styles,
			'data' => 'ggg'.$k,
		),
	);
	$panel['mbPanelSet']['panels'][] = $tmp;

	$panel['mbPanelDataSet']['ggg'.$k]['type'] = $v['set_data_type'];
	$panel['mbPanelDataSet']['ggg'.$k]['content'] = array();

	$data_static = array();

	// 靜態資料
	if(isset($treex[$sample_id]['submenu'][$k]['submenu']) and count($treex[$sample_id]['submenu'][$k]['submenu']) > 0){
		$data_static = $treex[$sample_id]['submenu'][$k]['submenu'];
	}

	// if(count($data_static) > 0){
	// 	$panel['mbPanelDataSet']['ggg'.$k]['content'] = $data_static;
	// }

	// 動態資料
	$data_dynamic = array();
	if($v['set_data_source'] != ''){ 
		if(preg_match('/^html:(.*)$/', $v['set_data_source'], $matches)){ // 通用資料表
			$rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type',$matches[1])->order_by('sort_id','asc')->get('html')->result_array();
			$aaa = check_field_and_rebuild_array($rows);
			// $aaas = explode("\n",$aaa);
			$aaa = '$tmp = array('."\n".$aaa."\n".');';
			eval($aaa);
			$data_dynamic = $tmp;
		} elseif(preg_match('/^(.*):$/', $v['set_data_source'], $matches)){ // 獨立資料表
			$table = $matches[1];
			$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get($table)->row_array();
			$has_layer = false;

			if($row and isset($row['id']) and $row['id'] > 0 and isset($row['pid'])){ // 獨立分類資料表，才會特別用多層來處理
				$has_layer = true;
			}

			if($has_layer === true){
				$items = $this->cidb->select('*, concat( \''.str_replace('type','',$table).'_'.$this->data['ml_key'].'.php?id=\',id ) as __link')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get($table)->result_array();
				$indexedItems = array();

				// index elements by id
				foreach ($items as $item) {
					$item['submenu'] = array();
					$indexedItems[$item['id']] = (object) $item;
				}


				// assign to parent
				$topLevel = array();
				foreach ($indexedItems as $item) {
					if ($item->pid == 0) {
						$topLevel[] = $item;
					} else {
						$indexedItems[$item->pid]->submenu[] = $item;
					}
				}

				$tree2 = std_class_object_to_array($topLevel);
				$aaa = check_field_and_rebuild_array($tree2);
				// $aaas = explode("\n",$aaa);
				$aaa = '$tmp = array('."\n".$aaa."\n".');';
				eval($aaa);
				$data_dynamic = $tmp;
			} else {
				// 用主觀的方式來判斷
				$has_detail = '_'.$this->data['ml_key'].'.php?id=';
				if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method_revert.'detail.php')){
					$has_detail = 'detail'.$has_detail;
				}

				$rows = $this->cidb->select('*, concat( \''.$table.$has_detail.'\',id ) as __link')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get($table)->result_array();
				$aaa = check_field_and_rebuild_array($rows);
				// $aaas = explode("\n",$aaa);
				$aaa = '$tmp = array('."\n".$aaa."\n".');';
				eval($aaa);
				$data_dynamic = $tmp;
			}

		} else {
			if($v['set_data_source'] != '' and isset($data[$v['set_data_source']]) and count($data[$v['set_data_source']]) > 0){
				$data_dynamic = $data[$v['set_data_source']];
			}
		}
	}

	if(count($data_dynamic) <= 0){
		$panel['mbPanelDataSet']['ggg'.$k]['content'] = $data_static;
	} elseif($v['set_data_source_position'] == 0){
	 	$panel['mbPanelDataSet']['ggg'.$k]['content'] = $data_dynamic;
	} elseif($v['set_data_source_position'] == 1){
	 	$panel['mbPanelDataSet']['ggg'.$k]['content'] = $data_dynamic;
		foreach($data_static as $kk => $vv){
			$panel['mbPanelDataSet']['ggg'.$k]['content'][] = $vv;
		}
	} elseif($v['set_data_source_position'] == 2){
		$panel['mbPanelDataSet']['ggg'.$k]['content'] = $data_static;
		foreach($data_dynamic as $kk => $vv){
			$panel['mbPanelDataSet']['ggg'.$k]['content'][] = $vv;
		}
	}

} // panels foreach

// 因為如果陣列裡面submenu為null的時候，傳給js，那邊會處理錯誤
array_walk_recursive($panel, function(&$item, $key) {
	if ($item === null) $item = array();
});

// var_dump($panel);die;

// 2018-02-26 平面化
// http://redmine.buyersline.com.tw:4000/issues/18231?issue_count=44&issue_position=43&next_issue_id=17463&prev_issue_id=18525#note-41
if(isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
	$run_tmp = '';
	$run_tmp .= '<'.'?'.'php'."\n";
	$run_tmp .= '$panel = '.var_export($panel,true).';'."\n";
	$run_tmp .= 'header("Content-type: text/javascript");'."\n";
	$run_tmp .= 'echo json_encode(array("mbPanel"=>$panel));'."\n";
	$run_tmp .= 'die;'."\n";

	@mkdir(_BASEPATH.'/../'.LAYOUTV3_PATH.'_compile',0777,true);
	$file = _BASEPATH.'/../'.LAYOUTV3_PATH.'_compile/mbpanel2.php';
	file_put_contents($file ,$run_tmp);
}

header("Content-type: text/javascript");
// file_put_contents('aaa.php','<'.'?'.'php '."\n".var_export($panel,true).';');
echo json_encode(array('mbPanel'=>$panel));
die;

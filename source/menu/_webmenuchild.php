<?php

// 無限層 2017-11-03
// $rows = $this->db->createCommand()->select('*, concat( \''.$_router_method_revert.'_'.$this->data['ml_key'].'.php?id=\',id ) as __link')->from($_router_method_revert.'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
$rows = $this->db->createCommand()->select('*, url as __link')->from('webmenuchild')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
$has_custom_name = ''; // 在靜態次選單裡面， // #25768有動態的功能 2017-12-18
$params = array(); // 隨興使用的欄位，012分別是other7, other8, other9

// 多筆程式的IDEA 2017-12-21
// custom:language,pX,r1,r2,r3|custom:webmenu_style2,pX,r1,r2,r3|custom:layer_up,pX,r1,r2,r3
// pX是位置，也就是沒有、上、下、末
// rX是引數，總共有三個可以用

if($rows){
	foreach($rows as $kk => $vv){

		// 有些擴充功能，會需要有引數
		if($vv['id'] == $v['video_2']){
			for($x=7;$x<=9;$x++){
				$params[] = $v['other'.$x];
			}
		}

		if($vv['id'] == $v['video_2'] and preg_match('/^custom\:(.*)$/', $vv['name'], $matches)){
			$has_custom_name = $matches[1];
		}

		// 2018-06-12 讓編排頁也能有自己的大標小標
		if('/'.$vv['__link'] == $_SERVER['REQUEST_URI']){
			if(isset($vv['func_en_name']) and $vv['func_en_name'] != ''){
				$this->data['func_en_name'] = $vv['func_en_name'];
			}

			if(isset($vv['func_name']) and $vv['func_name'] != ''){
				$this->data['func_name'] = $vv['func_name'];
			}
		}

		if($vv['pid'] == 0){
			unset($rows[$kk]);
		}
	}

	foreach($rows as $kk => $vv){
		if($vv['pid'] == $v['video_2']){
			$vv['pid'] = 0;
		}
		// 動態網址 2017-09-20有跟李哥討論過
		if($vv['url'] == 'contact_'.$this->data['ml_key'].'.php' and isset($_SESSION['save']['contact_dynamic_url'])){
			$vv['url'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
			$vv['__link'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
		}

		//靜態次選單所用的擴充欄位 2022-03-14 by lota
		if($vv['other1']!=''){
			$vv['url'] = $vv['other1'];
			$vv['__link'] = $vv['other1'];
		}

		// 2019-02-04 試著修修看，欄位裡面單引號所造成的問題
		foreach($vv as $kkk => $vvv){
			if(!is_array($vvv) and !empty($vvv)){
				$vv[$kkk] = addslashes($vvv);
			}
		}

		$rows[$kk] = $vv;
	}
}

if(!isset($v['child'])){
	$v['child'] = array();
}

// debug
if(0){
	echo $v['url'];
	echo $has_custom_name."\n";
}

if($has_custom_name != ''){
	if($has_custom_name == 'language'){ // #25768
		foreach($this->data['mls'] as $kk => $vv){
			$tmp2 = array(
				'name' => $vv['name'],
				'url' => 'change_language.php?lang='.$kk,
				'attr1' => '',
				'attr2' => '',
			);
			$tmp2['attr2'] = ' href="'.$tmp2['url'].'" ';
			$tmpg[] = $tmp2;
			// $v['child'][] = $tmp2;
		}
		$v['url'] = 'change_language.php?lang='.$this->data['ml_key'];
		$v['name'] = $this->data['mls'][$this->data['ml_key']]['name'];
		// $v['name'] = t('LANGUAGE','en');
	} elseif($has_custom_name == 'layer_up' and isset($params[0]) and $params[0] != '' and isset($params[1]) and $params[1] != ''and $v['video_4'] == 3){ // 把次選單上提一層，到主選單層級
		// * 如果沒有用”末“，會發生缺少video_2的問題，所以還是要放在最下面

		// 可以用逗點來區別分層，例child.2，最後一層不能為child
		$source_menu_id = $params[0]; 

		// 要重寫編號，不然極有可能會跟前台主選單的編號衝到
		$prefix_id = $params[1]; 

		$tmps2 = explode('.', $source_menu_id);
		$run = '$v = $v';
		foreach($tmps2 as $kk => $vv){
			$run .= '[\''.$vv.'\']';
		}
		eval($run.';');

		// 2018-05-15
		// 重寫頂層的編號，因為頂層是前台主選單(webmenu)的編號
		// 如果是次選單提升層次，次選單裡面的編號，是該資料流的編號
		$v['id'] = $prefix_id.$v['id'];
		if(preg_match('/navlight_noname_(.*)\"/',$v['attr1'],$matches)){
			$v['attr1'] = str_replace('navlight_noname_'.$matches[1].'"','navlight_noname_'.$v['id'].'"',$v['attr1']);
		}
	} elseif($has_custom_name == 'move' and isset($params[0]) and $params[0] != ''){ // 把別人的根，和次選單，移來我這裡
		$tmps2 = explode(',', $params[0]);
		foreach($tmps2 as $kk => $vv){
			$v['child'][] = $tmp[$vv];
			unset($tmp[$vv]);
		}
	} elseif($has_custom_name == 'webmenu_style2' and $v['video_4'] == 3){ // 改變主選單顯示的樣式
		// * 如果沒有用“末”，會發現找不到$v['attr1']的問題，所以還是要放在最下面
		if(isset($v['child']) and count($v['child'] ) > 0){
			$v['attr1'] = str_replace('moreMenu', 'moreMenu multiMenu', $v['attr1']);
			$v['anchor_class'] = 'inner wide'; // V4 2021-03-12 lota add
			foreach($v['child'] as $kk => $vv){				
				// if(isset($vv['child']) and count($vv['child']) > 0){
				if($common_enableurl_by_subclass_haschild){ //2021-05-05 讓後台去控制第一層能不能點選 by lota
					$v['child'][$kk]['attr1'] = str_replace('moreMenu','',$vv['attr1']);
					$v['child'][$kk]['attr1'] = str_replace('multiMenu','',$vv['attr1']); // V4 2021-03-12 lota add
					$v['child'][$kk]['attr2'] = 'class="menuTitle" ' . $vv['attr2']; // V4 2021-03-12 lota add
				}else{
					$v['child'][$kk]['attr2'] = 'class="menuTitle" '; // V4 2021-03-12 lota add
				}
			}
			
		}
	}
} else {
	$indexedItems = array();

	// index elements by id
	foreach ($rows as $item) {
		$item['child'] = array();
		$indexedItems[$item['id']] = (object) $item;
	}

	// assign to parent
	$topLevel = array();
	foreach ($indexedItems as $item) {
		if ($item->pid == 0) {
			$topLevel[] = $item;
		} else {
			if(isset($indexedItems[$item->pid])){ // 2019-12-19 by lota
				$indexedItems[$item->pid]->child[] = $item;
			}
		}
	}
	$tree = std_class_object_to_array($topLevel);

	// 加上深度欄位
	$tree_tmps = explode("\n", var_export($tree, true));
	if($tree_tmps){
		foreach($tree_tmps as $kk => $vv){
			if(preg_match('/^(.*)\'name\'\ =>/', $vv, $matches)){
				// 4個字元為1層，以此類推
				$depth = (strlen($matches[1]) / 4) + 1;
				$tree_tmps[$kk] = '\'depth\' => '.$depth.','.$vv;
			}
		}
	}
	$run = '$tree = '.implode("\n", $tree_tmps).';';
	eval($run);

	$params = array();
	if(isset($url_prefix)){
		$params['url_prefix'] = $url_prefix;
	}
	if(isset($url_suffix)){
		$params['url_suffix'] = $url_suffix;
	}
	

	$aaa = check_field_and_rebuild_array_by_multi_layer_menu($tree, array(), $params);
	$aaa = '$tmpg = array('."\n".$aaa."\n".');';
	eval($aaa);

} // has_custom_name

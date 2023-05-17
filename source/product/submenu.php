<?php

// 最初的版本，在mbpanel2.php裡面
// 280行
if(!function_exists('check_field_and_rebuild_array_by_multi_layer_submenu')){
	function check_field_and_rebuild_array_by_multi_layer_submenu($items,$seo) {

		$render = '';
		if(!empty($items)){ //如果不是空值，才處理 by lota
			foreach ($items as $k => $item) {
				$render .= $k.'=>array('."\n";

				if(!isset($item['url'])){
					if(isset($item['url1']) and $item['url1'] != ''){
						$item['url'] = $item['url1'];
					} elseif(isset($item['__link']) and $item['__link'] != ''){ // 獨立資料表專用
						$item['url'] = $item['__link'];
					} else {
						$item['url'] = '';
					}
				}

				//如果網址是有效連結，則判斷是否需要做SEO化 by lota
				if($item['url'] != 'javascript:;' and isset($seo[$item['id']]) and $seo[$item['id']]['seo_script_name'] != ''){
					$item['url'] = $seo[$item['id']]['url_prefix'].$seo[$item['id']]['seo_script_name'].'.html';
				}

				if (!empty($item['child'])) {

					// 如果view是用product/promenu2，那這裡就要註解起來 2017-11-16
					$item['url'] = 'javascript:;';

					$render .= '\'child\'=>array('."\n";
					$render .= check_field_and_rebuild_array_by_multi_layer_submenu($item['child'],$seo);
					$render .= '),'."\n"; // child
				}

				if(!isset($item['child'])){
					$item['child'] = array();
				}

				// 把屬性都處理好了，在顯示在頁面上
				// LI的屬性，輸出前準備
				$attr1 = '';
				$classes = array();
				// if(isset($item['child']) and count($item['child']) > 0 and isset($item['depth'])){
				// 	// 這裡要判斷層次
				// 	if($item['depth'] == 1 and isset($item['has_child']) and $item['has_child'] === true){ 
				// 		$classes[] = 'moreMenu';
				// 	} elseif($item['depth'] == 2){ 
				// 		$classes[] = 'moreMenu';
				// 	}
				// }
				if(isset($item['class']) and $item['class'] != ''){
					$classes[] = $item['class'];
				}
				if(count($classes) > 0){
					$attr1 .= ' class="'.implode(' ', $classes).'" ';
				}
				if(isset($item['id'])){
					$attr1 .= ' id="navlight_'.$item['id'].'" ';
				}
				$item['attr1'] = $attr1;

				// 把屬性都處理好了，在顯示在頁面上
				// Anchor的屬性，輸出前準備
				$attr2 = '';
				// if(isset($item['target']) and $item['target'] != ''){
				// 	$attr2 .= ' target="'.$item['target'].'" ';
				// }
				// if(isset($item['anchor_class']) and $item['anchor_class'] != ''){
				// 	$attr2 .= ' class="'.$item['anchor_class'].'" ';
				// }
				// if(isset($item['anchor_data_target']) and $item['anchor_data_target'] != ''){
				// 	$attr2 .= ' data-target="'.$item['anchor_data_target'].'" ';
				// }
				if(isset($item['url'])){
					$attr2 .= ' href="'.$item['url'].'" ';
				}
				$item['attr2'] = $attr2;

				foreach($item as $kk => $vv){
					if(!is_array($vv)){
						$render .= '\''.$kk.'\'=>\''.$vv.'\','."\n";
					}
				}
				
				$render .= '),'."\n";
			}
		}

		return $render."\n";
	}
}

// SEO
$rows = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>'producttype'))->queryAll();
$rows_tmp = array();
if($rows){
	foreach($rows as $k => $v){
		$v['url_prefix'] = $url_prefix;
		$v['url_suffix'] = $url_suffix;
		$rows_tmp[$v['seo_item_id']] = $v;
	}
}

// 單層，且放在html資料表
// $tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'performancetype',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// if($tmps){
// 	foreach($tmps as $k => $v){
// 		$v['url'] = str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php?id='.$v['id'];
// 		$v['parent_id'] = $v['pid'];
// 		$v['name'] = $v['topic'];
// 		$tmps[$k] = $v;
// 	}
// }

// 沒有分類的情況 2017-10-13
// $tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// if($tmps){
// 	foreach($tmps as $k => $v){
// 		if(isset($rows_tmp[$v['id']]) and $rows_tmp[$v['id']]['seo_script_name'] != ''){
// 			// SEO
// 			$v['url'] = $rows_tmp[$v['id']]['seo_script_name'].'.html';
// 		} else {
// 			$v['url'] = str_replace('detail','',$this->data['router_method']).'detail_'.$this->data['ml_key'].'.php?id='.$v['id'];
// 		}
// 
// 		$v['parent_id'] = 0;
// 		$tmps[$k] = $v;
// 	}
// }

// 無限層，且放在獨立資料表
// 但是如果有次類，大類還是會有連結 2017-12-04發現的
// $tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// if($tmps){
// 	foreach($tmps as $k => $v){
// 
// 		//舊站SEO轉新站的方式
// 		//$v['url'] = '';
// 		//if($this->data['ml_key'] == 'tw'){
// 		//	$v['url'] = 'tw/';
// 		//}
// 		//$v['url'] .= $v['script_name'].'.html';	
// 
// 		if(isset($rows_tmp[$v['id']]) and $rows_tmp[$v['id']]['seo_script_name'] != ''){
// 			// SEO
// 			$v['url'] = $rows_tmp[$v['id']]['seo_script_name'].'.html';
// 		} else {
// 			$v['url'] = str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php?id='.$v['id'];
// 		}
// 
// 		$v['parent_id'] = $v['pid'];
// 		$tmps[$k] = $v;
// 	}
// }

// 2017-12-04
// 二層，這是for舊版的
// 讓舊版的二層，可以像主選單那樣，如果有次層，那大類就不顯示連結
// $tmps = array();
// $rows = $this->db->createCommand()->from('producttype')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// if($rows){
// 	foreach($rows as $kk => $vv){
// 	$rows2 = $this->db->createCommand()->from('producttype')->where('is_enable=1 and pid=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
// 		//$rows2 = $this->db->createCommand()->from('product')->where('is_enable=1 and class_id=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
// 		if($rows2 and count($rows2) > 0){
// 			// 這個當multiMenu關閉的時候，這個就可以打開
// 			$rows[$kk]['class'] = 'moreMenu';
// 			foreach($rows2 as $kkk => $vvv){
// 				$rows2[$kkk]['parent_id'] = $vvv['pid'];
// 				$rows2[$kkk]['url'] = $url_prefix.'product_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
// 				//$rows2[$kkk]['url'] = $_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
// 				$tmps[$vvv['id']] = $rows2[$kkk];
// 			}
// 			$rows[$kk]['child'] = $rows2;
// 
// 			//2017/6/8 預設上層不給點 by lota
// 			$rows[$kk]['url'] = 'javascript:;';
// 
// 		}else{
// 			//如果沒子類別，則顯示連結 by lota
// 			$rows[$kk]['url'] = $url_prefix.'product_'.$this->data['ml_key'].'.php?id='.$vv['id'];
// 		}
// 		
// 		//如果網址是有效連結，則判斷是否需要做SEO化 by lota
// 		if($rows[$kk]['url']!='javascript:;'){
// 			if(isset($rows_tmp[$vv['id']]) and $rows_tmp[$vv['id']]['seo_script_name'] != ''){
// 				// SEO
// 				$rows[$kk]['url'] = $rows_tmp[$vv['id']]['seo_script_name'].'.html';
// 			} else {
// 				$rows[$kk]['url'] = $url_prefix.'product_'.$this->data['ml_key'].'.php?id='.$vv['id'];
// 			}
// 		}
// 
// 		// 有子分類的話，就不給點 2017-04-17 李哥和查理
// 		// 如果是選擇promenu2的話，這裡要註解掉哦
// 		// 2017/6/8 這邊如果分類一些有子分類，一些沒子分類的話會錯誤，所以改用279行的自動判別方式 by lota
// 		//if($rows2 and count($rows2) > 0){
// 		//	$rows[$kk]['url'] = 'javascript:;';
// 		//}
// 
// 		$rows[$kk]['parent_id'] = $rows[$kk]['pid'];
// 
// 		$tmps[$vv['id']] = $rows[$kk];
// 	}
// 	// $v['child'] = $rows;
// 
// }

// 無限層，且放在獨立資料表
$rows = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if($rows){
	foreach($rows as $k => $v){
		//$v['__link'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$v['id']; // 2018-02-22 下午李哥看到這個問題
		$v['__link'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id='.$v['id'];
		$rows[$k] = $v;
	}
}

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
		$indexedItems[$item->pid]->child[] = $item;
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

$aaa = check_field_and_rebuild_array_by_multi_layer_submenu($tree, $rows_tmp);
$aaa = '$tmpg = array('."\n".$aaa."\n".');';
eval($aaa);

$data[$ID] = $tmpg;

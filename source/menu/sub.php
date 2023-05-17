<?php

/*
 * 2018-07-13
 * 這裡的寫法，不適用於 "dom5/datasource/v3_source載入" 的方式
 */

$tmps = array();

// C方案 (source/page_source)
// $view_file = 'v3/header/nav_menu2';
// $view_file = 'system/empty_datasource/webmenu';
// if(isset($layoutv3_struct_map_keyname[$view_file][0]) and isset($data[$layoutv3_struct_map_keyname[$view_file][0]])){
// 	$tmps = $data[$layoutv3_struct_map_keyname[$view_file][0]];
// 
// 	// 把主選單的"navlight_webmenu_"名稱，替換成"navlight_"
// 	$handle = '$tmps='.var_export($tmps,true).';';
// 	$handle = preg_replace('/navlight_webmenu_/', 'navlight_', $handle);
// 	eval($handle);
// }

$tmps = array();
$page_source_data_param1 = 'webmenu-v1';
include _BASEPATH.'/../source/system/page_source_data.php';
if(isset($page_source_data_return) and !empty($page_source_data_return)){
	$tmps = $page_source_data_return;

	// 把主選單的"navlight_webmenu_"名稱，替換成"navlight_"
	$handle = '$tmps='.var_export($tmps,true).';';
	$handle = preg_replace('/navlight_webmenu_/', 'navlight_', $handle);
	eval($handle);
}

// A方案
if(isset($this->data['_webmenu_top_for_sub']) and !empty($this->data['_webmenu_top_for_sub'])){
	$tmps = $this->data['_webmenu_top_for_sub'];
}

// 五綸 || 捷弘 || 兩個分類，一個分項 (1)
// 為了第二個分類，能夠讓第一個分類的主選單項目亮燈
// 現在可以用分類提升的方式，來解決兩個分類的情況，所以這邊應該是用不到
//
// 相關檔案：
// source/system/general_item.php
// source/menu/sub.php
// source/product/general_item.php
//
// 2019-04-01
// 原本的分類，改名成應用，在上面
// 新的分類(product2)，名子是一般分類，位置在下面
//
// 為了讓product2的分類，也能讓主選單product亮燈
// if($this->data['ml_key'] == 'en'){
// 	if($this->data['func_name_id'] == 2111){ // 次要分類
// 		$this->data['func_name_id'] = 289; // 主要分類
// 	}
// } elseif($this->data['ml_key'] == 'tw'){
// 	if($this->data['func_name_id'] == 2113){
// 		$this->data['func_name_id'] = 16;
// 	}
// }

// 懷舊次選單 view/default/page_submenu.php
//
// 側邊選單 source/system/general_item.php
// 　└ view/default/sidemenu_empty_datasource.php 可透過後台的前台主選單，去更換資料流區塊的目標
//
if(!empty($tmps) and isset($this->data['func_name_id']) and $this->data['func_name_id'] > 0){
	$row = array();
	foreach($tmps as $k => $v){
		if($v['id'] == $this->data['func_name_id'] and isset($v['child']) and count($v['child']) > 0){

			//2021-12-15 政佳的側選單資料補正 by lota
			foreach ($v['child'] as $k1 => $v1) {
				// $v['child'][$k1]['attr1'] = ' class="moreMenu"  id="navlight_'.$v1['id'].'" ';
				
				if(!empty($v1['child'])){
					foreach ($v1['child'] as $k2 => $v2) {
						if(isset($_GET['id']) && ($v2['id'] == $_GET['id'])){
							$v['child'][$k1]['attr2'] = ' class="open active" '; //第一層
							$v['child'][$k1]['child'][$k2]['attr2'] .= ' class="open active" '; //第二層
						}
					}
				}
				//第一層
				if(isset($_GET['id']) && ($_GET['id'] == $v1['id'])){				
					$v['child'][$k1]['attr2'] = str_replace('class="menuTitle"','class="menuTitle open active"',$v['child'][$k1]['attr2']);
				}				
			}

			// 如果有小圖示就顯示 (舊寫法)
			// foreach ($v['child'] as $k1 => $v1) {
			// 	if(isset($v1['pic2']) && $v1['pic2']!=''){
			// 		$v['child'][$k1]['pic2_src'] = '<span class="iconImg"><img src="_i/assets/upload/'.$this->data['router_method'].'type/'.$v1['pic2'].'" alt="WRENCHES"></span>';
			// 	}
			// }

			// 2020-03-27 如果有小圖示就顯示
			if(!empty($v1['child'])){
				foreach ($v1['child'] as $k2 => $v2) {
					if(isset($v2['pic2']) && $v2['pic2']!=''){
						$v['child'][$k1]['child'][$k2]['pic2_src'] = '<span class="iconImg"><img src="_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'type/'.$v2['pic2'].'" alt="WRENCHES"></span>';
					}
				}
			}
			$row = $v['child'];
			break;
		}
	}

	//客製如果 router_method 是 product2，另外的選單資料流 by lota
	// if(preg_match('/^(product2)$/', $this->data['router_method'])){
	// 	$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('pid',0)->order_by('sort_id','asc')->get('producttype')->result_array();
	// 	if($row){
	// 		foreach($row as $k => $v){
	// 			$v['url'] = 'product_'.$this->data['ml_key'].'.php?id='.$v['id'];
	//			//如果有兩層就把下面的註解打開 by lota
	// 			$v['url'] = 'javascript:;';
	// 			$v['attr1'] = ' class="moreMenu"  id="navlight_'.$v['id'].'" ';
	// 			$v['attr2'] = ' href="'.$v['url'].'" ';
	// 			$row1 = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('pid',$v['id'])->order_by('sort_id','asc')->get('producttype')->result_array();
	// 			if($row1){
	// 		        foreach($row1 as $k1=> $v1){
	// 		            $v1['url'] = 'product_'.$this->data['ml_key'].'.php?id='.$v1['id'];
	// 		            $v1['attr1'] = ' id="navlight_'.$v1['id'].'" ';
	// 			        $v1['attr2'] = ' href="'.$v1['url'].'" ';
	// 		            $row1[$k1] = $v1;
	// 		        }
	// 		        $v['child'] = $row1;
	// 			}
	// 			$row[$k] = $v;
	// 		}
	// 	}
	// }

	// 五綸 || 捷弘 || 兩個分類，一個分項 (2)
	// source/system/general_item.php
	// source/menu/sub.php
	// source/product/general_item.php
	//
	// if(preg_match('/^(product|productdetail|product2)$/', $this->data['router_method'])){

	// 	unset($_constant);
 //        eval('$_constant = '.strtoupper('seo_open').';');
 //        $seos_type_tmp = array();
 //        if($_constant){
 //    	    // SEO 資料
 //            $seos = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>'product2type'))->queryAll();
 //            if($seos){
 //            	foreach($seos as $k => $v){
 //            		$seos_type_tmp[$v['seo_item_id']] = $v;
 //            	}
 //            }
 //        }

	// 	$rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get('product2type')->result_array();
	// 	if($rows){
	// 		foreach($rows as $k => $v){
	// 			$v['url'] = 'product2_'.$this->data['ml_key'].'.php?id='.$v['id'];
	// 			if(isset($seos_type_tmp[$v['id']])){
	// 	        	$v['url'] = $url_prefix.$seos_type_tmp[$v['id']]['seo_script_name'].'.html';
	// 	    	}

	// 			// 如果有兩層就把下面的註解打開 by lota
	// 			// $v['url'] = 'javascript:;';
	// 			// $v['attr1'] = ' class="moreMenu"  id="navlight_'.$v['id'].'" ';
	// 			// $v['attr2'] = ' href="'.$v['url'].'" ';
	// 			// $row1 = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('pid',$v['id'])->order_by('sort_id','asc')->get('product2type')->result_array();
	// 			// if($row1){
	// 		 //        foreach($row1 as $k1=> $v1){
	// 		 //            $v1['url'] = 'product2_'.$this->data['ml_key'].'.php?id='.$v1['id'];

	// 		 //            if(isset($seos_type_tmp[$v['id']])){
	// 			//         	$v1['url'] = $url_prefix.$seos_type_tmp[$v['id']]['seo_script_name'].'.html';
	// 			//     	}
				    	
	// 		 //            $v1['attr1'] = ' id="navlight_'.$v1['id'].'" ';
	// 			//         $v1['attr2'] = ' href="'.$v1['url'].'" ';
	// 		 //            $row1[$k1] = $v1;
	// 		 //        }
	// 		 //        $v['child'] = $row1;
	// 			// }
	// 			$rows[$k] = $v;
	// 		}
	// 	}

	// 	$data[$ID] = array();


	// 	// if($this->data['ml_key'] == 'en'){
	// 	// 	$view_file = 'v3/shop/block';
	// 	// 	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	// 	// 		$data[$layoutv3_struct_map_keyname[$view_file][0]] = array('name' => 'Application Categories');
	// 	// 	}

	// 	// 	$view_file = 'v3/shop/block';
	// 	// 	if(isset($layoutv3_struct_map_keyname[$view_file][1])){
	// 	// 		$data[$layoutv3_struct_map_keyname[$view_file][1]] = array('name' => 'Product Categories');
	// 	// 	}
	// 	// } else {
	// 	// 	$view_file = 'v3/shop/block';
	// 	// 	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	// 	// 		$data[$layoutv3_struct_map_keyname[$view_file][0]] = array('name' => '應用分類');
	// 	// 	}

	// 	// 	$view_file = 'v3/shop/block';
	// 	// 	if(isset($layoutv3_struct_map_keyname[$view_file][1])){
	// 	// 		$data[$layoutv3_struct_map_keyname[$view_file][1]] = array('name' => '產品分類');
	// 	// 	}
	// 	// }

	// 	//====
	// 	$view_file = 'v3/shop/block';
	// 	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	// 		$data[$layoutv3_struct_map_keyname[$view_file][0]] = array('name' => t('應用分類','tw'));
	// 	}

	// 	$view_file = 'v3/shop/block';
	// 	if(isset($layoutv3_struct_map_keyname[$view_file][1])){
	// 		$data[$layoutv3_struct_map_keyname[$view_file][1]] = array('name' => t('產品分類','tw'));
	// 	}

	// 	//====

	// 	$view_file = 'v3/default/sidemenu';
	// 	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	// 		$data[$layoutv3_struct_map_keyname[$view_file][0]] = $row;
	// 	}

	// 	$view_file = 'v3/default/sidemenu';
	// 	if(isset($layoutv3_struct_map_keyname[$view_file][1])){
	// 		$data[$layoutv3_struct_map_keyname[$view_file][1]] = $rows;
	// 	}

	// } else {
	// 	$data[$ID] = $row;
	// }

	// 五綸 || 捷弘 || 兩個分類，一個分項 (3)
	// 上面的註解打開，那這一行就要註解
	$data[$ID] = $row;
	// var_dump($data[$ID]);die;
}

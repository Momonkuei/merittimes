<?php

// 最初的版本，在mbpanel2.php裡面
// 280行
if(!function_exists('check_field_and_rebuild_array_by_multi_layer_menu')){
	function check_field_and_rebuild_array_by_multi_layer_menu($items,$seo,$params=array()) {

		$render = '';

		// 2018-10-02
		$url_prefix = '';
		if(isset($params['url_prefix'])){
			$url_prefix = $params['url_prefix'];
		}

		$url_suffix = '';
		if(isset($params['url_suffix'])){
			$url_suffix = $params['url_suffix'];
		}

		if($items and !empty($items)){
			foreach ($items as $k => $item){
				$render .= $k.'=>array('."\n";

				if(!isset($item['url'])){
					if(isset($item['__link']) and $item['__link'] != ''){ // 獨立資料表專用
						$item['url'] = $item['__link'];
					} elseif(isset($item['url1']) and $item['url1'] != ''){
						$item['url'] = $item['url1'];
					} else {
						$item['url'] = '';
					}
				}

				// 2019-01-30 試著修修看，欄位裡面單引號所造成的問題
				if($item and !empty($item)){
					foreach($item as $kk => $vv){
						if(!is_array($vv) and !empty($vv)){
							$item[$kk] = addslashes($vv);
						}
					}
				}

				// 2019-01-16 醫揚-法語的dirty hack #30204
				// if(isset($item['topic'])){
				// 	$item['topic'] = str_replace("'",'’',$item['topic']);
				// }
				// if(isset($item['name'])){
				// 	$item['name'] = str_replace("'",'’',$item['name']);
				// }

				// 如果網址是有效連結，則判斷是否需要做SEO化 by lota
				// 這裡的SEO，都只是針對分類而以
				if($item['url'] != 'javascript:;' and isset($seo[$item['id']]) and $seo[$item['id']]['seo_script_name'] != ''){
					$item['url'] = $seo[$item['id']]['seo_script_name'].'.html';
				}

				// 2018-10-02
				if($item['url'] != '' and isset($params['url_prefix'])){
					$item['url'] = $params['url_prefix'].$item['url'];

					// 2020-01-09 在seo非主語系的資料夾模式下，把網址(ggg_tw.php、aaa_tw_1.php)，都只剩tw/ggg.php，也就是用底線語系拿掉
					if($params['url_prefix'] != ''){
						$item['url'] = str_replace('_'.str_replace('/', '', $params['url_prefix']), '', $item['url']);
					}
				}

				if (!empty($item['child'])) {

					// 2021-01-29 手機版不跟進"有次分類的分類，連結是否有效"的選項
					if(isset($params['enableurl_by_subclass_haschild']) and ($params['enableurl_by_subclass_haschild'] == '' or $params['enableurl_by_subclass_haschild'] == '0') ){
						if(isset($item['child'][0]['__link']) and preg_match('/detail/', $item['child'][0]['__link'])){
						} elseif(isset($item['child'][0]['url1']) and preg_match('/detail/', $item['child'][0]['url1'])){
						} elseif(isset($item['child'][0]['url']) and preg_match('/detail/', $item['child'][0]['url'])){
							// 2017-12-13 後台 / 前台主選單 / 資料表功能 / 動態次選單 / 分類下有分項
						// } elseif(!isset($item['child'][0]['child']) or empty($item['child'][0]['child'])){ // 2021-01-29
							// 2021-01-29 如果沒有第二層，或者是第二層沒有東西，那就會讓連結保留，為了要讓"割蘭尾"的程序，在手機版能夠運作正常 2021-05-05 因為"割蘭尾"這個情境不常使用，先註解起來，如果有緣人遇到了就解除封印吧! by lota
						} else {
							$item['url'] = 'javascript:;';
						}
					}

					$render .= '\'child\'=>array('."\n";
					$render .= check_field_and_rebuild_array_by_multi_layer_menu($item['child'],$seo,$params);
					$render .= '),'."\n"; // child
				}

				if(!isset($item['child'])){
					$item['child'] = array();
				}

				// 把屬性都處理好了，在顯示在頁面上
				// LI的屬性，輸出前準備
				$attr1 = '';
				$classes = array();
				if(isset($item['child']) and !empty($item['child']) and isset($item['depth'])){

					// 這裡要判斷層次 因為UX設計不當，所以主選單下拉選單這邊要限制兩層，如果要改無限層則要把原程式註解換成下行
					//$classes[] = 'moreMenu';

					//限制顯示層數
					if($item['depth'] == 1 and isset($item['has_child']) and $item['has_child'] === true){ 
						$classes[] = 'moreMenu';
					} elseif($item['depth'] == 2){ 
						$classes[] = 'moreMenu';
					}
				}
				if(isset($item['class']) and $item['class'] != ''){
					$classes[] = $item['class'];
				}
				if(!empty($classes)){
					$attr1 .= ' class="'.implode(' ', $classes).'" ';
				}
				if(isset($item['id'])){
					$attr1 .= ' id="navlight_noname_'.$item['id'].'" ';
				}
				$item['attr1'] = $attr1;

				// 把屬性都處理好了，在顯示在頁面上
				// Anchor的屬性，輸出前準備
				$attr2 = '';
				if(isset($item['target']) and $item['target'] != ''){
					$attr2 .= ' target="'.$item['target'].'" ';
				}
				if(isset($item['anchor_class']) and $item['anchor_class'] != ''){
					$attr2 .= ' class="'.$item['anchor_class'].'" ';
				}
				if(isset($item['anchor_data_target']) and $item['anchor_data_target'] != ''){
					$attr2 .= ' data-target="'.$item['anchor_data_target'].'" ';
				}
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
		} // count

		return $render."\n";
	}
}

/*
 * 為了支援開環境的程式
 */

// 2019-12-10 寫一個客製的，可以讓v1第二版的datasource帶參數進來的東西
$position_params = array();
if(isset($_position) and preg_match('/^(.*)___(.*)___(.*)$/', $_position, $matches)){
	$_position = $matches[1];
	$position_params[$matches[2]] = $matches[3];
}

$position = '1';
if(isset($_position) and $_position != ''){
	if($_position == 'bottom'){
		$position = '2';
	} elseif($_position == 'mobile'){
		$position = '3';
	} elseif($_position == 'other1'){
		$position = '4';
	} elseif($_position == 'other2'){
		$position = '5';
	}
}

$this->data['func_name_href'] = '';

// 2020-02-27
$seos = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->get('seo')->result_array();

if(isset($this->data['_webmenu_navlight_name']) and $this->data['_webmenu_navlight_name'] == 'navlight_'){ // A方案的時候，透過layoutv3/datasource/_webmenu_top_for_sub載入給側邊選單用的情況，但是主選單不出現，那就會需要這邊的幫忙
	$tmp = $this->db->createCommand()->from('html')->where('type =:type and ml_key=:ml_key and field_tmp like "%,'.$position.',%"',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
} else {
	$tmp = $this->db->createCommand()->from('html')->where('is_enable =1 and type=:type and ml_key=:ml_key and field_tmp like "%,'.$position.',%"',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
}
if($tmp){
	foreach($tmp as $k => $v){

		$v['name'] = $v['topic'];
		$v['url'] = $v['url1'];
		$v['target'] = $v['other2'];

		// 2018-05-04 通常是相簿需要密碼的時候
		// (2018-05-15 手機版選單會異常)
		$v['anchor_class'] = $v['other19'];
		$v['anchor_data_target'] = $v['other20'];

		// 深度
		$v['depth'] = 1;

		// 2019-08-28 電腦版的主選單，只有排第二位置以外，都沒有次選單
		// if($position == 1 and $k != 1){
		// 	$v['video_1'] = 2;
		// }

		// 2017-10-25
		// 沒有次選單的話
		// 在後台的 / 前台選單 / 該功能 / 是否有次選單 / 有或沒有
		$v['has_child'] = true; // 只有頂層的次選單才有支援
		if($v['video_1'] == '2'){ // 2：就是沒有次選單，其它的值都是有，空白也算有
			$v['has_child'] = false;
		}

		// 把屬性都處理好了，在顯示在頁面上
		// LI的屬性，輸出前準備
		// 這裡會等到child處理好才做，通常在最下面，或者是提早要輸出的時候
		$attr1 = '';

		// 把屬性都處理好了，在顯示在頁面上
		// Anchor的屬性，輸出前準備
		$attr2 = '';
		if(isset($v['target']) and $v['target'] != ''){
			$attr2 .= ' target="'.$v['target'].'" ';
		}
		if(isset($v['anchor_class']) and $v['anchor_class'] != ''){
			$attr2 .= ' class="'.$v['anchor_class'].'" ';
		}
		if(isset($v['anchor_data_target']) and $v['anchor_data_target'] != ''){
			$attr2 .= ' data-target="'.$v['anchor_data_target'].'" ';
		}
		// $v['attr2'] = $attr2;

		// 資料表功能
		$common_is_enable = $v['is_home'];
		$common_is_category = $v['pic2']; // 是或不是分類
		$common_category = $v['is_news']; // 是或不是通用分類
		$common_category_type_name = $v['other22']; // 用別人的
		$common_item = $v['class_ids'];   // 是或不是通用分項
		$common_has_category_item = $v['other10'];   // 分類下有分項
		$common_articlesingle = $v['is_top']; // 單頁專用
		$common_date_sort = $v['pic3'];

		// 其它
		$common_layer_up = $v['other21']; // 頂層分類升級
		$common_enableurl_by_subclass_haschild = $v['other12']; // 有次分類的分類，連結是否有效(1:有效)

		// 2018-09-14 有次分類的分類，連結是否有效，這個是全域的哦，不是針對某個功能
		if(isset($this->data['_enableurl_by_subclass_haschild']) and $this->data['_enableurl_by_subclass_haschild'] != ''){
			$common_enableurl_by_subclass_haschild = $this->data['_enableurl_by_subclass_haschild'];
		}

		if($position == 3){ // 手機版不跟進這個選項
			$common_enableurl_by_subclass_haschild = 0;
		} 

		// 進階功能
		$static_child = $v['video_2'];
		$static_child_position = $v['video_4'];

		// 如果有供值，那就是要在那個指定的網域字串下，才會出現
		// 2017-05-02 李哥說要加的
		if($v['video_3'] != ''){
			if($v['video_3'] == $_SERVER['HTTP_HOST']){
				// do nothing
			} else {
				unset($tmp[$k]);

				// $v['attr1'] = $attr1;
				// $v['attr2'] = $attr2;
				// $tmp[$k] = $v; // 2017-12-11 李哥發現的問題

				continue;
			}
		} else {
			// do nothing
		}

		/*
		 * 底下是，沒有次選單，卻有程式碼要處理的狀況
		 */

		$_router_method_revert = $v['url'];
		$_router_method_revert = str_replace('_'.$this->data['ml_key'].'.php','',$_router_method_revert);
		$_router_method_revert = str_replace('detail','',$_router_method_revert);

		// 2019-12-10
		if(!empty($position_params)){
			foreach($position_params as $kk => $vv){
				eval('$'.$kk.'='.$vv.';');
			}
		}

		// 2019-12-04 有無內頁
		$common_has_page_detail = false;
		if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method_revert.'detail.php')){
			$common_has_page_detail = true;
		} else {
			$tmp2 = $this->cidb->query('select * from layoutv3pagetype where is_enable=1 and pid=0 and theme_name="'.LAYOUTV3_THEME_NAME.'" and ( name="'.$_router_method_revert.'detail" or concat(",",other_func,",") LIKE "%,'.$_router_method_revert.'detail,%" )')->row_array();
			if($tmp2 and isset($tmp2['id'])){
				$common_has_page_detail = true;
			}
		}

		// 2019-02-01 程式化sitemap 善行數位
		if($this->data['router_method'] == 'sitemapxml'){
			if($common_is_category == 1){
				$common_has_category_item = 1;
			}
		}

		// 解決衝突的部份
		if($common_is_enable == 1){
			if($common_is_category == 1 and $common_has_page_detail === false){
				$common_has_category_item = 0;
			} elseif($common_is_category == 0 and $common_has_page_detail === false){
				// 2020-01-02 不要急著刪，下面純分項，已經有做處理了，所以這裡不要處理，因為還是有可能會有靜態次選單的下拉
				//$v['has_child'] = false;
			}
		}

		// 子選單 / 靜態次選單
		// 這裡是動態分項的上方，另外，還有下方的，內容幾乎是一樣的，剛好要放在資料庫動態分項／分類的上下方包起來
		// if($v['video_2'] > 0 and $v['video_4'] == 1){
		if($static_child > 0 and $static_child_position == 1){
			// 當這個打開的時候，下面那個moreMenu就可以關閉
			//$v['class'] = 'multiMenu';

			$tmpg = array();

			include _BASEPATH.'/../source/menu/_webmenuchild.php';

			// 最後才寫進去
			$v['child'] = $tmpg;
		}

		/*
		 * 資料表功能開始
		 */

		// 先檢查動態次選單
		if($common_is_enable == 1){
			$common_sort_condition = 'sort_id asc';
			if($common_date_sort == 1){
				$common_sort_condition = 'start_date desc';
			}

			if($common_is_category == 1){ // 有分類

				// SEO Product
				$rows_seo = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method_revert.'type'))->queryAll();
				$rows_tmp = array();
				if($rows_seo){
					foreach($rows_seo as $k_seo => $v_seo){
						$rows_tmp[$v_seo['seo_item_id']] = $v_seo;
					}
				}

				$type_name = $_router_method_revert.'type';
				if($common_category_type_name != ''){
					$type_name = $common_category_type_name;
				}

				if($common_category == 1){ // 單層分類
			    	// $rows = $this->db->createCommand()->select('*, topic as name, class_id as pid, concat( \''.$url_prefix.$_router_method_revert.$url_suffix.'?id=\',id ) as __link')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$type_name,':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll();
			    	$rows = $this->db->createCommand()->select('*, topic as name, class_id as pid, concat( \''.$_router_method_revert.$url_suffix.'?id=\',id ) as __link')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$type_name,':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll();

					// 2018-10-30 分類選單加密碼功能
					if(0 and $rows and preg_match('/^(download)$/', $_router_method_revert)){
						foreach($rows as $kk => $vv){
							if($vv['other1']!=''){ //改為如果後台有輸入密碼才做判斷 by lota 2018-12-14
								if(isset($_SESSION['media_password']) and $_SESSION['media_password'] != '' and $vv['other1'] == $_SESSION['media_password']){
									// do nothing
								} else {
									$vv['url'] = 'javascript:;';
									$vv['anchor_class'] = 'openBtn';
									$vv['anchor_data_target'] = '#loginPanel_pwd';
									$rows[$kk] = $vv;
								}
							}
						}
					}
				} else { // 多層分類
					// $rows = $this->db->createCommand()->select('*, concat( \''.$url_prefix.$_router_method_revert.$url_suffix.'?id=\',id ) as __link')->from($type_name)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
					$rows = $this->db->createCommand()->select('*, concat( \''.$_router_method_revert.$url_suffix.'?id=\',id ) as __link')->from($type_name)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

					// 2018-05-30 李哥允許這個新功能的開發，也就是上提一層的功能
					if($common_layer_up != '0'){
						foreach($rows as $kk => $vv){
							if($vv['pid'] == 0){
								$vv['pid'] = -1;
							}
							if($vv['pid'] == $common_layer_up){
								$vv['pid'] = 0;
							}
							$rows[$kk] = $vv;
						}
					}
					
					//2020-10-27 購物主題活動
					if($rows and preg_match('/^(shoppromotion)$/', $_router_method_revert)){
						// $v['url'] = str_replace('promotion','',$v['url1']);
						foreach($rows as $kk => $vv){
							//限定時間顯示處理 2020-11-16 by lota
							$_now_time = time();						
							if($vv['start_time']!='0000-00-00 00:00:00'){
								$_start_time = strtotime($vv['start_time']);
							}else{
								$_start_time = 0;
							}							
							if($vv['end_time']!='0000-00-00 00:00:00'){							
								$_end_time = strtotime($vv['end_time']);
							}else{
								$_end_time = 99999999999;
							}
							if($_now_time >= $_start_time && $_now_time <= $_end_time){
								$vv['__link'] = str_replace('promotion','',$vv['__link']);
								$vv['__link'] = str_replace('id=','id=s',$vv['__link']);
								$rows[$kk] = $vv;
							}else{
								unset($rows[$kk]);
							}						
						}

						//如果都沒有主題活動就不顯示主選單 by lota
						if(count($rows) < 1){
							unset($tmp[$k]);
							continue;
						}
					}
				}

				// 2017-12-14
				if($common_has_category_item == 1){
					if($common_item == 0){
						// $rows2 = $this->db->createCommand()->select('*, class_id as pid, concat( \''.$url_prefix.$_router_method_revert.'detail'.$url_suffix.'?id=\',id ) as __link')->from($_router_method_revert)->where('is_enable=1 and ml_key=:ml_key and class_id > 0',array(':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
						$rows2 = $this->db->createCommand()->select('*, class_id as pid, concat( \''.$_router_method_revert.'detail'.$url_suffix.'?id=\',id ) as __link')->from($_router_method_revert)->where('is_enable=1 and ml_key=:ml_key and class_id > 0',array(':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
					} else {
						// $rows2 = $this->db->createCommand()->select('*, topic as name, class_id as pid, concat( \''.$url_prefix.$_router_method_revert.'detail'.$url_suffix.'?id=\',id ) as __link')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id > 0',array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method_revert))->order($common_sort_condition)->queryAll();
						$rows2 = $this->db->createCommand()->select('*, topic as name, class_id as pid, concat( \''.$_router_method_revert.'detail'.$url_suffix.'?id=\',id ) as __link')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id > 0',array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method_revert))->order($common_sort_condition)->queryAll();
					}
					foreach($rows2 as $kk => $vv){
						$vv['_id'] = $vv['id'];
						$vv['id'] = 94879487+$vv['id'];
						$rows[] = $vv;
					}
				}
				
				// 2018-05-08 如果欄位裡面有存放HTML，可能導致接下來的程序異常
				//     └ check_field_and_rebuild_array_by_multi_layer_menu
				if($rows and !empty($rows)){
					foreach($rows as $kk => $vv){
						// unset($vv['detail']);
						foreach($vv as $kkk => $vvv){
							// 2018-07-03 其實是單引號的關係，而不是HTML欄位的關係
							$vv[$kkk] = str_replace("'",'’',$vvv);
						}
						$rows[$kk] = $vv;
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

				// 2018-10-30 該功能大類底下，在子分類上面插入該大類的總覽頁連結，變成第一個，底下是範例 (這個範例來自於幸康)
				// if($_router_method_revert == 'product'){
				// 	$rowsgg = $tree;
				// 	$rowsaa = array();
				// 	foreach($rowsgg as $kk => $vv){
				// 		$rowsaa[$kk] = $vv;
				// 		$rowsaa[$kk]['child'] = array();
				// 		$rowsaa[$kk]['child'][] = array(
				// 			'id' => 999,
				// 			'name' => 'Product Overview',
				// 			'pid' => $vv['id'],
				// 			'depth' => 3,
				// 			'__link' => 'product_'.$this->data['ml_key'].'.php?id='.$vv['id'],
				// 		);
				// 		foreach($vv['child'] as $kkk => $vvv){
				// 			$rowsaa[$kk]['child'][] = $vvv;
				// 		}
				// 	}
				// 	$tree = $rowsaa;
				// }

				$params = array();
				// 2018-10-02
				$params['url_prefix'] = $url_prefix;
				$params['url_suffix'] = $url_suffix;
				$params['enableurl_by_subclass_haschild'] = $common_enableurl_by_subclass_haschild;

				$aaa = check_field_and_rebuild_array_by_multi_layer_menu($tree, $rows_tmp, $params);
				$aaa = '$tmpg = array('."\n".$aaa."\n".');';
				eval($aaa);

				// 最後才寫進去
				// $v['child'] = $tmpg;
				if(!isset($v['child']) or !$v['child']){
					$v['child'] = array();
				}
				$v['child'] = array_merge($v['child'],$tmpg); // 試著修修看沒有出現的情況 2018-03-08

			} elseif($common_articlesingle == 1){
			 	// do nothing
			} else {
				if($common_item == 1){ // 分項使用通用的html資料表
			    	$rows = $this->db->createCommand()->select('*, topic as name')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$_router_method_revert,':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
				} else { // 分項使用獨立的資料表
			    	$rows = $this->db->createCommand()->from($_router_method_revert)->where('is_enable=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
				}
				if($rows and !empty($rows)){
					foreach($rows as $kkk => $vvv){
						$tmp2 = array(
							'id' => $vvv['id'], // 給menu-sub的資料流所使用
							'depth' => 2,
							'name' => $vvv['name'],
							// 'url' => $url_prefix.$_router_method_revert.$url_suffix.'?id='.$vvv['id'],
							'url' => $_router_method_revert.$url_suffix.'?id='.$vvv['id'],
							'attr1' => '',
							'attr2' => '',
						);

						// if($common_is_category != 1 and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method_revert.'detail.php')){
						if($common_is_category != 1 and $common_has_page_detail === true){
							// $tmp2['url'] = $url_prefix.$_router_method_revert.'detail'.$url_suffix.'?id='.$vvv['id'];
							$tmp2['url'] = $_router_method_revert.'detail'.$url_suffix.'?id='.$vvv['id'];
						}

						$tmp2['attr2'] = ' href="'.$tmp2['url'].'" ';
						// $v['child'][] = $tmp2;

						// 解決衝突的部份 2020-01-02
						if($common_is_enable == 1){
							if($common_is_category == 0 and $common_has_page_detail === false){
								// do nothing
								// 例如：舊的公司簡介、沒分類的Video、沒分類的Faq、沒下類的檔案下載
								// 它們的分項，不會被列進次選單裡面
							} else {
								$v['child'][] = $tmp2;
							}
						} else {
							$v['child'][] = $tmp2;
						}
					}
				}
			}

		} // common_is_enable

		/*
		 * 通用資料表結束
		 */

		// 子選單 / 靜態次選單
		// 這裡是動態分項的下方，還有一個上方的哦，內容幾乎是一樣的
		// if($v['video_2'] > 0 and $v['video_4'] == 2){
		if($static_child > 0 and $static_child_position == 2){
			// 當這個打開的時候，下面那個moreMenu就可以關閉
			//$v['class'] = 'multiMenu';

			$tmpg = array();

			include _BASEPATH.'/../source/menu/_webmenuchild.php';

			if(!empty($tmpg)){
				$v['child'] = array_merge($v['child'],$tmpg);
			}

		}

		// 動態網址 2017-09-20有跟李哥討論過
		// if($v['url'] == 'contact_'.$this->data['ml_key'].'.php' and isset($_SESSION['save']['contact_dynamic_url'])){
		// 	$v['url'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
		// }

		// 動態網址 (第2版) 2018-03-26 李哥下午說OK，可以做
		if(isset($_dynamic_url)){
			foreach($_dynamic_url as $kk => $vv){
				if($v['url'] == $vv.'_'.$this->data['ml_key'].'.php' and isset($_SESSION['save'][$vv.'_dynamic_url'])){
					$v['url'] = $vv.'/'.$_SESSION['save'][$vv.'_dynamic_url'].'.html';
				}
			}
		}

		// SEO主選單靜態頁範例 2017-10-27
		// if($v['url'] == 'photo_tw.php'){
		// 	$v['url'] = $url_prefix.'網頁設計.html';
		// }

		// 子選單 / 純手工範本
		// 盡量不要用這裡，請用後台的前台次選單(靜態)的功能
		// if($v['url'] == 'contact_tw.php'){
		// 	$v['child'] = array(
		// 		array(
		// 			'name' => '服務據點',
		// 			'url' => $url_prefix.'location_tw.php',
		// 		),
		// 		array(
		// 			'name' => '客制頁面',
		// 			'url' => 'javascript:;',
		// 		),
		// 	);
		// }

		// 子選單是語系的範本
		// #25768
		// if($v['url'] == 'ml_key'){
		// 	foreach($this->data['mls'] as $kk => $vv){
		// 		$tmp2 = array(
		// 			'name' => $vv,
		// 			'url' => 'change_language.php?lang='.$kk,
		// 			'attr1' => '',
		// 			'attr2' => '',
		// 		);
		// 		$tmp2['attr2'] = ' href="'.$tmp2['url'].'" ';
		// 		$v['child'][] = $tmp2;
		// 	}
		// 	$v['url'] = 'change_language.php?lang='.$this->data['ml_key'];
		// 	$v['name'] = $this->data['mls'][$this->data['ml_key']];
		// }

		// 第一個次選單去覆寫網址的欄位，這個是後台的功能
		if(isset($v['other3'])){
			if($v['other3'] == 1 and isset($v['child'][0]['url'])){ // 第一個網址
				$v['url'] = $v['child'][0]['url'];
			} elseif($v['other3'] == 4 and isset($v['child']) and !empty($v['child'])){ // 2018-07-24 第一個有效網址
				$aaas = explode("\n", var_export($v['child'], true));
				if($aaas and !empty($aaas)){
					foreach($aaas as $kk => $vv){
						if(preg_match('/\'url\'\ \=\>\ \'(.*)\'\,/', $vv, $matches)){
							if($matches[1] != '' and $matches[1] != '#' and $matches[1] != 'javascript:;'){
								$v['url'] = $matches[1];
								break;
							}
						}
					}
				}
			} elseif($v['other3'] == 2){
				$v['url'] = 'javascript:;';
			} elseif($v['other3'] == 3){
				$v['url'] = '#';
			// 4~8是預留
			} elseif($v['other3'] == 9 and $v['other16'] != ''){
				$v['url'] = $v['other16'];
			}
		}

		// 2020-02-27 seo
		// 照邏輯判斷，不是這樣寫，但這樣比較好寫
		if($seos and !empty($seos)){
			foreach($seos as $kk => $vv){
				if($vv['seo_script_name'] != ''){
					$ggg = '';
					if(preg_match('/^(.*)_(.*)$/', $vv['seo_type'], $matches)){
						$ggg = $matches[1].'_'.$this->data['ml_key'].'_'.$matches[2].'.php';
					} else {
						if(preg_match('/(.*)type$/', $vv['seo_type'], $matches)){
							$ggg = $matches[1].'_'.$this->data['ml_key'].'.php';
						} else {
							if($vv['seo_item_id'] > 0){
								$ggg = $vv['seo_type'].'detail_'.$this->data['ml_key'].'.php';
							} else {
								$ggg = $vv['seo_type'].'_'.$this->data['ml_key'].'.php';
							}
						}
					}

					if($vv['seo_item_id'] > 0){
						$ggg .= '?id='.$vv['seo_item_id'];
					}

					if($v['url'] == $ggg){
						$v['url'] = $vv['seo_script_name'].'.html';
						break;
					}
				}	
			}
		}	

		$classes = array();
		if(isset($v['class']) and $v['class'] != ''){
			$classes[] = $v['class'];
		}

		// 只有頂層在使用的，如果要下拉選單的，請看76行
		if(isset($v['child']) and !empty($v['child']) and isset($v['has_child']) and $v['has_child'] === true){
			$classes[] = 'moreMenu';
		}
		if(!empty($classes)){
			$attr1 .= ' class="'.implode(' ', $classes).'" ';
		}
		if(isset($v['id'])){
			$attr1 .= ' id="navlight_noname_'.$v['id'].'" ';
		}

		// 2020-10-14
		// 這個是A方案在使用的，可以讓主選單亮燈
		// 之前V3版型的做法，是帶參數給JS亮燈
		// V4版型目前是不會亮燈的
		// if(isset($this->data['func_name_id']) and $v['id'] == $this->data['func_name_id']){
		// 	$attr1 .= ' class="focus" '; // 政佳主選單習慣的寫法
		// 	// $attr1 .= ' class="active" ';
		// }

		$v['attr1'] = $attr1;

		//2020-10-27 購物主題活動
		if(preg_match('/^(shoppromotion)$/', $_router_method_revert)){
			$v['url'] = str_replace('promotion','',$v['url']);
		}

		// seo
		if($main_ml_key != '' and $this->data['ml_key'] != $main_ml_key and !preg_match('/'.$this->data['ml_key'].'\//',$v['url'])){
			$v['url'] = $url_prefix.$v['url'];
			$v['url'] = str_replace('_'.$this->data['ml_key'].'.php',$url_suffix,$v['url']);
		}

		if(isset($v['url'])){
			$attr2 .= ' href="'.$v['url'].'" ';
		}
		$v['attr2'] = $attr2;

		// 子選單 / 靜態次選單
		// 這裡是程式在使用的，要記得！要放在迴圈的最下面哦！
		// if($v['video_2'] > 0 and $v['video_4'] == 3){
		if($static_child > 0 and $static_child_position == 3){
			// 當這個打開的時候，下面那個moreMenu就可以關閉
			//$v['class'] = 'multiMenu';

			// $tmpg = array();

			include _BASEPATH.'/../source/menu/_webmenuchild.php';

			// if(!empty($tmpg)){
			// 	$v['child'] = array_merge($v['child'],$tmpg);
			// }


			//這邊是for 靜態次選單功能layer_up 所處理的 by lota(有問題 jerry會處理)
			//PS:seo的url還沒複製過來，遇到的話再從543行複製
			foreach ($v['child'] as $key => $value) {
				$classes = array();$attr1 = '';
				if(isset($v['class']) and $v['class'] != ''){
					$classes[] = $v['class'];
				}
				if(isset($value['child']) and !empty($value['child'])){
					if(isset($value['anchor_class']) && $value['anchor_class'] = 'inner wide'){ // 2021-03-12 lota fix 寬版選單的第二層修正，暫時用 anchor_class 當判斷
						$classes[] = 'moreMenu';
					}					
				}
				if(!empty($classes)){
					$attr1 .= ' class="'.implode(' ', $classes).'" ';
				}
				if(isset($value['id'])){
					$attr1 .= ' id="navlight_noname_'.$value['id'].'" ';
				}
				$v['child'][$key]['attr1'] = $attr1;
			}

		}

		// 解決衝突的部份
		// if($common_is_enable == 1){
		// 	if($common_is_category == 0 and $common_has_page_detail === false){
		// 		unset($v['child']);
		// 	}
		// }

		// 2018-07-18 ruby在uniplast發現的錯誤
		if(isset($this->data['func_name_id']) and $v['id'] == $this->data['func_name_id']){
			$this->data['func_name_href'] = $v['url'];
		}

		$tmp[$k] = $v;
	}
}

if(0){
?>
<meta charset="utf-8">
<?php
	new dBug($tmp,'',true);
	die;
}

// var_dump($tmp);die;

// 2019-07-01
// 範本：需要登入，才能使用的功能(depo)
// 在source/core.php的下面還有
// if($position == 1 or $position == 3){
// 	if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] > 0){
// 		// do nothing
// 	} else {
// 		$tmp[1]['attr2'] = ' class="openBtn"  data-target="#loginForm"  href="product_'.$this->data['ml_key'].'.php" ';
// 		$tmp[2]['attr2'] = ' class="openBtn"  data-target="#loginForm"  href="newproduct_'.$this->data['ml_key'].'.php" ';
// 	}
// }

// 2019-03-12
// 範本：刪掉次選單第一個項目，不管是電腦版還是手機版
// $menu_id = 3;
// unset($tmp[$menu_id]['child'][0]);
// $tmpgg = array();
// foreach($tmp[$menu_id]['child'] as $k1 => $v1){
// 	$tmpgg[] = $v1;
// };
// $tmp[$menu_id]['child'] = $tmpgg;

// 範本：讓某一主選單的項目，變成另外一種樣式
// 這裡己經有併入靜態次選單的功能裡面
// if($position == 1){
// 	$menu_id = 1;
// 	$tmp[$menu_id]['attr1'] = str_replace('moreMenu', 'moreMenu multiMenu', $tmp[$menu_id]['attr1']);
// 	foreach($tmp[$menu_id]['child'] as $k => $v){
// 		if(isset($v['child']) and !empty($v['child'])){
// 			$tmp[$menu_id]['child'][$k]['attr1'] = str_replace('moreMenu','',$v['attr1']);
// 		}
// 	}
// }

// 範本：把某一節點，提升到最頂層的某一節點
// 這裡的數字，都是key的號碼
// if($position == 1){
// 	$source_menu_id = '2.child.2'; // 可以用逗點來區別分層
// 	$dest_menu_id = 13;
// 	$kill_menu_id = 0; // 設為零的時候，就不做這個動作
// 	$tmps2 = explode('.', $source_menu_id);
// 	$run = '$tmp2 = $tmp';
// 	foreach($tmps2 as $k => $v){
// 		$run .= '[\''.$v.'\']';
// 	}
// 	eval($run.';');
// 	$tmp[$dest_menu_id] = $tmp2;
// 	if($kill_menu_id > 0){
// 		unset($tmp[$kill_menu_id]);
// 	}
// }

// 2018-09-13 試試看，加上一個可以處理不完全是ul li的結構的情況，幸康、常廣的案子有用到
// 2021-05-18 這個程式區塊，愈多主選單使用這個功能，會讓網站速度愈來愈慢，要注意，但是它的優點是可以加速開發
// if($position == 1){
// 	$menu_id = 2; // 從零開始的流水號

// 	//$view = 'v3/capture/webmenu_product.php'; // V3形象站
// 	$view = 'v3/capture/webmenu_shop.php'; // V3購物站，將產品分類，顯示在主選單，如同分類提升的效果 2020-12-24
// 	//$view = 'v4/capture/webmenu_product.php';
// 	// $url = FRONTEND_DOMAIN.'/capture.php?ml_key='.$this->data['ml_key'].'&target='.$view;
// 	$url = FRONTEND_DOMAIN.'/capture_'.$this->data['ml_key'].'.php?ml_key='.$this->data['ml_key'].'&target='.$view;
// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL, $url);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //這個是重點,規避ssl的證書檢查。
// 	curl_setopt($ch, CURLOPT_TIMEOUT, 1); // CURLOPT_TIMEOUT_MS

// 	// debug
// 	//curl_setopt($ch, CURLOPT_VERBOSE, 1);
// 	//curl_setopt($ch, CURLOPT_HEADER, 1);

// 	$output = curl_exec($ch);

// 	// debug
// 	//$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
// 	//$header = substr($output, 0, $header_size);

// 	curl_close($ch);

// 	//file_put_contents('123.txt',var_export($header,true)."\n",FILE_APPEND);
// 	//file_put_contents('123.txt',$url."\n",FILE_APPEND);
// 	//file_put_contents('123.txt',$output."\n",FILE_APPEND);

// 	// echo $output;die;
//  	$tmp[$menu_id]['_replace_struct_0'] = $output;
// }

// 2019-12-25 割蘭尾(固定割掉二層的第二層) (李哥說要做在相片花絮)
// 手機和電腦版都要這樣子做
// $menu_id = 10; // 從零開始的流水號
// if(isset($tmp[$menu_id]['child'])){
// 	foreach($tmp[$menu_id]['child'] as $k => $v){
// 		if(isset($v['child']) and !empty($v['child'])){
// 			$tmp[$menu_id]['child'][$k]['attr1'] = str_replace('class="moreMenu"','',$tmp[$menu_id]['child'][$k]['attr1']);
// 			unset($tmp[$menu_id]['child'][$k]['child']);
// 		}
// 	}
// }

// 2020-05-26 購物分類在主選單(這個寫法有問題)
// 相關檔案：view/v3/end.php
// if($position == 1){
//  	$menu_id = 1; // 插入點、與參考點
// 
// 	// 基礎資料
// 	$tmpg = $tmp[$menu_id];
// 	$tmpg['has_child'] = false;
// 	//unset($tmpg['child']);
// 
// 	$rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get('shoptype')->result_array();
// 	$tmpa = array(); // 小計
// 	if($rows and !empty($rows)){
// 		foreach($rows as $k => $v){
// 			$tmpg['name'] = $v['name'];
// 			 
// 			$tmpg['attr1'] = ' class="moreMenu" id="navlight_noname_shop'.$v['id'].'" ';
// 			$tmpg['attr2'] = ' href="shop_'.$this->data['ml_key'].'.php?id='.$v['id'].'" ';
// 
// 			$tmpa[] = $tmpg;
// 		}
// 	}
// 
// 	$tmp_result = array();
// 
// 	foreach($tmp as $k => $v){
// 		if($k == $menu_id){
// 			if($tmpa and !empty($tmpa)){
// 				foreach($tmpa as $kk => $vv){
// 					$tmp_result[] = $vv;
// 				}
// 			}
// 		} else {
// 			$tmp_result[] = $v;
// 		}
// 	}
// 
// 	$tmp = $tmp_result;
// }


// 2020-12-28 購物分類主選單顯示(多層) ，手機板尚未完善，需等待有緣人來處理 by lota
unset($_constant);
eval('$_constant = '.strtoupper('shop_category_show_open').';');
if($_constant){

 	$menu_id = 1; // 預設插入點、與參考點

	// if($position == 1){ // 電腦版
	// 	$menu_id = 1;
	// } elseif($position == 2){ // 頁尾
	// 	$menu_id = 1;
	// } elseif($position == 3){ // 手機版
	// 	$menu_id = 1;
	// }

	$pidas = 'pid';

	// 基礎資料
	$tmpg = $tmp[$menu_id];
	$tmpg['has_child'] = false; //如果需要下拉選單(第二層)，就要改為true
	//unset($tmpg['child']);

	$rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get('shoptype')->result_array();

	$indexedItems = array();

	// index elements by id
	foreach ($rows as $item) {
		$item['child'] = array();
		$indexedItems[$item['id']] = (object) $item;
	}

	// assign to parent
	$topLevel = array();
	foreach ($indexedItems as $item) {
		if ($item->{$pidas} == 0) {
			$topLevel[] = $item;
		} else {
			if(isset($indexedItems[$item->{$pidas}])){ // 2019-12-19 by lota
				$indexedItems[$item->{$pidas}]->child[] = $item;
			}
		}
	}
	$tree = std_class_object_to_array($topLevel);

	if($tree){
		foreach($tree as $k => $v){
			$attr1 = '';
			$classes = array();
			if(isset($v['child']) and !empty($v['child'])){
				$classes[] = 'moreMenu';
			}
			if(!empty($classes)){
				$attr1 .= ' class="'.implode(' ', $classes).'" ';
			}
			if(isset($v['id'])){
				$attr1 .= ' id="navlight_noname_'.$v['id'].'" ';
			}
			$v['attr1'] = $attr1;
 			$v['attr2'] = ' href="shop_'.$this->data['ml_key'].'.php?id='.$v['id'].'" ';

			if(isset($v['child']) and !empty($v['child'])){
				$v['has_child'] = $tmpg['has_child'];
				foreach($v['child'] as $kk => $vv){
					$attr1 = '';
					$classes = array();
					if(isset($vv['child']) and !empty($vv['child'])){
						$classes[] = 'moreMenu';
					}
					if(!empty($classes)){
						$attr1 .= ' class="'.implode(' ', $classes).'" ';
					}
					if(isset($vv['id'])){
						$attr1 .= ' id="navlight_noname_'.$vv['id'].'" ';
					}
					$vv['attr1'] = $attr1;
					$vv['attr2'] = ' href="shop_'.$this->data['ml_key'].'.php?id='.$vv['id'].'" ';

					if(isset($vv['child']) and !empty($vv['child'])){
						foreach($vv['child'] as $kkk => $vvv){
							$attr1 = '';
							$classes = array();
							if(isset($vvv['child']) and !empty($vvv['child'])){
								$classes[] = 'moreMenu';
							}
							if(!empty($classes)){
								$attr1 .= ' class="'.implode(' ', $classes).'" ';
							}
							if(isset($vvv['id'])){
								$attr1 .= ' id="navlight_noname_'.$vvv['id'].'" ';
							}
							$vv['attr1'] = $attr1;
							$vv['attr2'] = ' href="shop_'.$this->data['ml_key'].'.php?id='.$vvv['id'].'" ';
							

							$v['child'][$kk] = $vvv;
						}
					}

					$v['child'][$kk] = $vv;
				}
			}

			$tree[$k] = $v;
		}
	}

	$tmp_result = array();

	foreach($tmp as $k => $v){
		if($k == $menu_id){
			if($tree and !empty($tree)){
				foreach($tree as $kk => $vv){
					$tmp_result[] = $vv;
				}
			}
		} else {
			$tmp_result[] = $v;
		}
	}

	$tmp = $tmp_result;
}

// 2020-07-06 一個功能，只有一組密碼
// #36317
// 相關檔案
// source/menu/v2.php
// source/system/general_item.php
// $rowg = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','videologin')->get('html')->row_array();
// if($rowg and isset($rowg['id']) and isset($_SESSION['media_password']) and $_SESSION['media_password'] != '' and $_SESSION['media_password'] == $rowg['other1']){
// 	// do nothing
// } else {
// 	$menu_id = 3; // 從零開始的流水號
// 	$tmp[$menu_id]['attr2'] = ' class="openBtn"  data-target="#loginPanel_pwd"  href="product_'.$this->data['ml_key'].'.php" ';
// 	$tmp[$menu_id]['has_child'] = false;
// 
// 	// 手機
// 	$tmp[$menu_id]['anchor_class'] = 'openBtn';
// 	$tmp[$menu_id]['anchor_data_target'] = '#loginPanel_pwd';
// }

// 2020-10-14
// 單選側邊選單展開和亮燈
// A方案專用
// 分類3層
// 三阪實業
// if($position == 1 and preg_match('/product/',$this->data['router_method']) and isset($_GET['id']) and $_GET['id'] > 0){
// 	$menu_id = 3;
// 	$class_id = $_GET['id'];
// 
// 	if(preg_match('/detail/',$this->data['router_method'])){
// 		$rowga = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get('product')->row_array();
// 		if($rowga){
// 			$class_id = $rowga['class_id'];
// 		}
// 	}
// 
// 	$actives = array();
// 	$actives[] = $class_id;
// 
// 	$rowgb = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$class_id)->get('producttype')->row_array();
// 	if($rowgb){
// 		$rowgc = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$rowgb['pid'])->get('producttype')->row_array();
// 		if($rowgc){
// 			$actives[] = $rowgc['id'];
// 			$rowgd = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$rowgc['pid'])->get('producttype')->row_array();
// 			if($rowgd){
// 				$actives[] = $rowgd['id'];
// 			}
// 		}
// 	}
// 
// 	if(isset($tmp[$menu_id]['child'])){
// 		foreach($tmp[$menu_id]['child'] as $k => $v){
// 			if(in_array($v['id'],$actives)){
// 				$tmp[$menu_id]['child'][$k]['attr1'] = str_replace('"moreMenu"','"moreMenu active"',$v['attr1']);
// 			}
// 			if($class_id == $v['id']){
// 				$tmp[$menu_id]['child'][$k]['attr2'] .= ' class="focus" ';
// 			}
// 			if(isset($v['child'])){
// 				foreach($v['child'] as $kk => $vv){
// 					if(in_array($vv['id'],$actives)){
// 						$tmp[$menu_id]['child'][$k]['child'][$kk]['attr1'] = str_replace('"moreMenu"','"moreMenu active"',$vv['attr1']);
// 					}
// 					if($class_id == $vv['id']){
// 						$tmp[$menu_id]['child'][$k]['child'][$kk]['attr2'] .= ' class="focus" ';
// 					}
// 					if(isset($vv['child'])){
// 						foreach($vv['child'] as $kkk => $vvv){
// 							if($class_id == $vvv['id']){
// 								$tmp[$menu_id]['child'][$k]['child'][$kk]['child'][$kkk]['attr2'] .= ' class="focus" ';
// 							}
// 						}
// 					}
// 				}
// 			}
// 		}
// 	}
// }

//20221020 lin 增加start
if(isset($_position) and $_position != ''){
    // http://redmine.buyersline.com.tw:4000/issues/18231#note-35
    // 看看有沒有啟用手機版選單功能，並且選擇位置
    $tops2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and ( field_tmp like "%,4,%" and field_tmp like "%,'.$position.',%" )',array(':type'=>'webmenusub',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
    // 沒有的話，就使用預設C方案規則，也就是第一筆是左上角，其它在下面
    // if(!$tops2 or count($tops2) <= 0){
    //  $tops2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and field_tmp like "%,4,%"',array(':type'=>'webmenusub',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
    // }
} else {
    $tops2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and field_tmp like "%,3,%"',array(':type'=>'webmenusub',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
}
if($tops2 and !empty($tops2)){
    foreach($tops2 as $k => $v){
        $v['func'] = $v['other1'];
        $v['name'] = $v['topic'];
        if(preg_match('/^(http|\#|javascript\:\;)/', $v['url1'])){
            $v['url'] = $v['url1'];
        } else {
            $v['url'] = $url_prefix.$v['url1'];
            if($main_ml_key != '' and $this->data['ml_key'] != $main_ml_key){
                $v['url'] = str_replace('_'.$this->data['ml_key'].'.php',$url_suffix,$v['url']);
            }
        }
        // 2020-12-03 這個元素，到手機版那邊也會使用和判斷
        $v['anchor_open'] = $v['other2'];
        // 2020-12-03
        // v4手機版在使用的
        if(isset($v['anchor_open']) and $v['anchor_open'] != '' and LAYOUTV3_THEME_NAME == 'v4' and preg_match('/class=\'openBtn\'\ data-target=\'(.*)\'/', $v['anchor_open'], $matches)){
            $v['anchor_open'] = 'data-fancybox data-src=\''.$matches[1].'\'';
            // 手機版使用
            $v['other'] = $v['anchor_open'];
        }
        $v['icon'] = ''; // 2017-08-18 winnie發現的
        if($v['other3'] != ''){
            $v['icon'] = '<i class="'.$v['other3'].'"></i>';
        }
        // 2020-02-25
        $v['content2'] = $v['other4'];
        $tops2[$k] = $v;
    }
}
// 有資料的話，才會指定
if($tops2 and !empty($tops2)){
    $tops = $tops2;
}
if($tops and !empty($tops)){
    foreach($tops as $k => $v){
        
        if($v['func'] == 'search'){
            
            $page_source_data_param1 = 'widget-search_form';
            $page_source_data_param2 = $v;
            include _BASEPATH.'/../source/system/page_source_data.php';
        }
        // 動態網址 (第2版) 2018-03-26 李哥下午說OK，可以做
        if(isset($_dynamic_url)){
            foreach($_dynamic_url as $kk => $vv){
                if($v['func'] == $vv){
                    // if($this->data['router_method'] != 'contact' and isset($ID)){
                    //  $_SESSION['save']['contact_dynamic_url'] = substr(md5(microtime()),rand(0,26),15);
                    //  $_SESSION['save']['contact_dynamic_url_handled'] = true;
                    // } 
                    if(isset($_SESSION['save'][$vv.'_dynamic_url'])){
                        $v['url'] = $vv.'/'.$_SESSION['save'][$vv.'_dynamic_url'].'.html';
                    }
                }
            }
        }
        $tops[$k] = $v;
    }
}
//20221020 lin 增加end

//-2020/11/01 #46127  增加線上捐款功能開關----------------------------------------------------------------------------------------start
$donation_data = $this->cidb->where('keyname','function_constant_donation')->get('sys_config')->row_array();
if(!empty($donation_data) && $donation_data['keyval']=='false'){
	foreach($tmp as $k => $v){
		if(stristr($v['url1'],'donation')){
			unset($tmp[$k]);
		}
	}
}
//--------------------------------------------------------------------------------------------------------------------------------end
// 2018-10-22
if(isset($this->data['_webmenu_navlight_name']) and $this->data['_webmenu_navlight_name'] != ''){
	$tmp2 = var_export($tmp, true);
	$tmp2 = str_replace('navlight_noname_', $this->data['_webmenu_navlight_name'], $tmp2);
	$run = '$tmp = '.$tmp2.';';
	eval($run);
}
if(isset($ID)){
	$data[$ID] = $tmp;
}

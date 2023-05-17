<?php

// 最初的版本，在mbpanel2.php裡面
// 280行
if(!function_exists('check_field_and_rebuild_array_by_multi_layer_menu')){
	function check_field_and_rebuild_array_by_multi_layer_menu($items,$seo) {
		// $render = 'array('."\n";
		$render = '';

		foreach ($items as $k => $item) {
			$render .= $k.'=>array('."\n";

			if(!isset($item['link'])){
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
				$item['url'] = $seo[$item['id']]['seo_script_name'].'.html';
			}

			if (!empty($item['child'])) {
				$item['url'] = 'javascript:;';
				// if(isset($item['url'])){
				// }
				$render .= '\'child\'=>array('."\n";
				$render .= check_field_and_rebuild_array_by_multi_layer_menu($item['child'],$seo);
				$render .= '),'."\n"; // child
			}

			// if(!isset($item['content'])){
			// 	if(isset($item['name']) and $item['name'] != ''){
			// 		$item['content'] = $item['name'];
			// 	} elseif(isset($item['topic']) and $item['topic'] != ''){
			// 		$item['content'] = $item['topic'];
			// 	} else {
			// 		$item['content'] = '';
			// 	}
			// }

			// if(!isset($item['class'])){
			// 	$item['class'] = '';
			// }
			// if(!isset($item['target'])){
			// 	$item['target'] = '';
			// }
			if(!isset($item['child'])){
				$item['child'] = array();
			}

			foreach($item as $kk => $vv){
				if(!is_array($vv)){
					$render .= '\''.$kk.'\'=>\''.$vv.'\','."\n";
				}
			}
			
			$render .= '),'."\n";
		}

		// $render .= '),'."\n"; // 為什麼註解不要問我

		return $render."\n";
	}
}

// echo $_SERVER['HTTP_HOST'];die;

/*
 * 為了支援開環境的程式
 */

// 預設文章功能
if(!isset($functions)){
	$functions = array(); // 'company', 'news', 'location', 'faq', 'video', 'download'
}

// 活動花絮要做的事 
if(!isset($functions_album)){
	$functions_album = array(); // 'album'
}

// 相簿花絮要做的事，因為常數和活動花絮、還有架構是不太一樣的，所以分開
if(!isset($functions_photo)){
	$functions_photo = array('photo'); // 'photo'
}

$position = '1';
if(isset($_position) and $_position != ''){
	if($_position == 'bottom'){
		$position = '2';
	} elseif($_position == 'mobile'){
		$position = '3';
	}
}

$url_prefix = '';

// SEO
//unset($_constant);
//eval('$_constant = '.strtoupper('seo_open').';');
//if($_constant == 1){
//	if($this->data['ml_key'] == 'tw'){
//		$url_prefix = 'tw/';
//	}
//}

$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and field_tmp like "%,'.$position.',%"',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if($tmp){
	foreach($tmp as $k => $v){

		$v['name'] = $v['topic'];
		$v['url'] = $v['url1'];
		$v['target'] = $v['other2'];

		// 2017-10-25
		// 沒有次選單的話
		// 在後台的 / 前台選單 / 該功能 / 是否有次選單 / 有或沒有
		$v['has_child'] = true; // 只有頂層的次選單才有支援
		if($v['video_1'] == '2'){ // 2：就是沒有次選單，其它的值都是有，空白也算有
			$v['has_child'] = false;
		}

		// 資料表功能
		$common_is_enable = $v['is_home'];
		$common_is_category = $v['pic2']; // 是或不是分類
		$common_category = $v['is_news']; // 是或不是通用分類
		$common_item = $v['class_ids'];   // 是或不是通用分項
		$common_date_sort = $v['pic3'];
		$common_articlesingle = $v['is_top']; // 單頁專用

		// 如果有供值，那就是要在那個指定的網域字串下，才會出現
		// 2017-05-02 李哥說要加的
		if($v['video_3'] != ''){
			if($v['video_3'] == $_SERVER['HTTP_HOST']){
				// do nothing
			} else {
				$tmp[$k] = $v;
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

		if(in_array($_router_method_revert,$functions_photo)){
			eval('$_constant = '.strtoupper($_router_method_revert.'_type_later').';');
			if($_constant == 2){ // 只有相片
				$v['url'] = $url_prefix.$_router_method_revert.'detail_'.$this->data['ml_key'].'.php';
			}
		}

		// 沒有次選單的話，
		// 在後台的 / 前台選單 / 該功能 / 是否有次選單 / 有或沒有
		// if($v['video_1'] == '2'){ // 2：就是沒有次選單，其它的值都是有，空白也算有
		// 	unset($_constant);
		// 	eval('$_constant = '.strtoupper('seo_open').';');
		// 	if($_constant == 1){
		// 		if(!preg_match('/tw\//', $v['url']) and !preg_match('/^http/', $v['url'])){
		// 			$v['url'] = $url_prefix.$v['url'];
		// 		}
		// 	}
		// 	$tmp[$k] = $v;
		// 	continue;
		// }

		// 子選單 / 靜態次選單
		// 這裡是動態分項的上方，另外，還有下方的，內容幾乎是一樣的，剛好要放在資料庫動態分項／分類的上下方包起來
		if($v['video_2'] > 0 and $v['video_4'] == 1){
			// 當這個打開的時候，下面那個moreMenu就可以關閉
			//$v['class'] = 'multiMenu';
			$rows = $this->db->createCommand()->from('webmenuchild')->where('is_enable=1 and pid='.$v['video_2'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
			if($rows){
				foreach($rows as $kk => $vv){
					$rows2 = $this->db->createCommand()->from('webmenuchild')->where('is_enable=1 and pid=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
					//$rows2 = $this->db->createCommand()->from('product')->where('is_enable=1 and class_id=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
					if($rows2 and count($rows2) > 0){
						// 這個當multiMenu關閉的時候，這個就可以打開
						$rows[$kk]['class'] = 'moreMenu';
						//foreach($rows2 as $kkk => $vvv){
						//	$rows2[$kkk]['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
						//	//$rows2[$kkk]['url'] = $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
						//}
						$rows[$kk]['child'] = $rows2;
					}
					//$rows[$kk]['url'] = $_router_method.'_'.$this->data['ml_key'].'.php?id='.$vv['id'];
				}
				$v['child'] = $rows;

				// 這個不用，因為下面會Append 
				// if(count($rows) > 0){
				// 	$v['child'] = array_merge($rows,$v['child']);
				// }
			}
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
				if($common_category == 1){ // 單分類
			    	$rows = $this->db->createCommand()->select('*, topic as name')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$_router_method_revert.'type',':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
			    	if($rows and count($rows) > 0){
			    		foreach($rows as $kkk => $vvv){
			    			$tmp2 = array(
								'id' => $vvv['id'], // 給menu-sub的資料流所使用
			    				'name' => $vvv['topic'],
			    				'url' => $url_prefix.$_router_method_revert.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
			    			);
			    			$v['child'][] = $tmp2;
			    		}
			    	}
				} else { // 多層分類(二層)
					// SEO Product
					$rows_seo = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method_revert.'type'))->queryAll();
					$rows_tmp = array();
					if($rows_seo){
						foreach($rows_seo as $k_seo => $v_seo){
							$rows_tmp[$v_seo['seo_item_id']] = $v_seo;
						}
					}

					// 產品無分類，記得把分類的部份註解掉 2017-06-19
					// $rows = $this->db->createCommand()->from($_router_method)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
					// if($rows){
					// 	foreach($rows as $kk => $vv){
					// 		if($kk == 0){
					// 			$v['url'] = $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vv['id'];
					// 		}
					// 		$rows[$kk]['url'] = $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vv['id'];
					// 	}
					// 	$v['child'] = $rows;
					// }

					// 產品多層分類中，只顯示單層 2017-09-07
					// $rows = $this->db->createCommand()->from($_router_method_revert.'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
					// if($rows){
					// 	foreach($rows as $kk => $vv){
					// 		$rows[$kk]['url'] = $url_prefix.$_router_method_revert.'_'.$this->data['ml_key'].'.php?id='.$vv['id'];
					// 	}
					// 	$v['child'] = $rows;
					// }

					// 無限層 2017-11-03
					$rows = $this->db->createCommand()->select('*, concat( \''.$_router_method_revert.'_'.$this->data['ml_key'].'.php?id=\',id ) as __link')->from($_router_method_revert.'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
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

					$aaa = check_field_and_rebuild_array_by_multi_layer_menu($tree, $rows_tmp);
					$aaa = '$tmpg = array('."\n".$aaa."\n".');';
					eval($aaa);

					// 補上多層的樣式變化
					// 當這個打開的時候，下面那個moreMenu就可以關閉
					// $v['class'] = 'multiMenu';
					if($tmpg and count($tmpg) > 0){
						foreach($tmpg as $kk => $vv){
							if(isset($vv['child']) and count($vv['child']) > 0){
								$tmpg[$kk]['class'] = 'moreMenu';
							}
						}
					}

					// 最後才寫進去
					$v['child'] = $tmpg;

					// 兩層 (舊的，以經由上面的無限層所取代，但是要記得前台主選單的樣式只有做兩層而以)
					// 當這個打開的時候，下面那個moreMenu就可以關閉
					//$v['class'] = 'multiMenu';
					// $rows = $this->db->createCommand()->from($_router_method_revert.'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
					if(0 and $rows){ 
						foreach($rows as $kk => $vv){
						$rows2 = $this->db->createCommand()->from($_router_method_revert.'type')->where('is_enable=1 and pid=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
							//$rows2 = $this->db->createCommand()->from('product')->where('is_enable=1 and class_id=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
							if($rows2 and count($rows2) > 0){
								// 這個當multiMenu關閉的時候，這個就可以打開
								$rows[$kk]['class'] = 'moreMenu';
								foreach($rows2 as $kkk => $vvv){
									$rows2[$kkk]['url'] = $url_prefix.$_router_method_revert.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
									//$rows2[$kkk]['url'] = $_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
								}
								$rows[$kk]['child'] = $rows2;

								//2017/6/8 預設上層不給點 by lota
								$rows[$kk]['url'] = 'javascript:;';
							}else{
								//如果沒子類別，則顯示連結 by lota
								$rows[$kk]['url'] = $url_prefix.$_router_method_revert.'_'.$this->data['ml_key'].'.php?id='.$vv['id'];
							}
							
							//如果網址是有效連結，則判斷是否需要做SEO化 by lota
							if($rows[$kk]['url']!='javascript:;'){
								if(isset($rows_tmp[$vv['id']]) and $rows_tmp[$vv['id']]['seo_script_name'] != ''){
									// SEO
									$rows[$kk]['url'] = $rows_tmp[$vv['id']]['seo_script_name'].'.html';
								} else {
									$rows[$kk]['url'] = $url_prefix.$_router_method_revert.'_'.$this->data['ml_key'].'.php?id='.$vv['id'];
								}
							}

							// 有子分類的話，就不給點 2017-04-17 李哥和查理
							// 如果是選擇promenu2的話，這裡要註解掉哦
							// 2017/6/8 這邊如果分類一些有子分類，一些沒子分類的話會錯誤，所以改用279行的自動判別方式 by lota
							//if($rows2 and count($rows2) > 0){
							//	$rows[$kk]['url'] = 'javascript:;';
							//}

						}
						$v['child'] = $rows;
					}
				}
			} elseif($common_articlesingle == 1){
				// do nothing
			} else {
				if($common_item == 1){ // 分項使用通用的html資料表
			    	$rows = $this->db->createCommand()->select('*, topic as name')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$_router_method_revert,':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
				} else { // 分項使用獨立的資料表
			    	$rows = $this->db->createCommand()->from($_router_method_revert)->where('is_enable=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
				}
				if($rows and count($rows) > 0){
					foreach($rows as $kkk => $vvv){
						$tmp2 = array(
							'id' => $vvv['id'], // 給menu-sub的資料流所使用
							'name' => $vvv['name'],
							'url' => $url_prefix.$_router_method_revert.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
						);
						if($common_is_category != 1 and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method_revert.'detail.php')){
							$tmp2['url'] = $url_prefix.$_router_method_revert.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
						}
						$v['child'][] = $tmp2;
					}
				}
			}

		} // common_is_enable

		foreach($functions_photo as $kk => $vv){
			$_router_method = $vv;
			unset($_constant);
			eval('$_constant = '.strtoupper($_router_method.'_type_later').';');
			if($v['url'] == $_router_method.'_'.$this->data['ml_key'].'.php'){

				// 為了和靜態分項的搭配，所以才註解起來
				// $v['child'] = array();

				// 請自行決定是否要使用
				// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標1', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_1.php');
				// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標2', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_2.php');

				// 請自行決定是否要使用，讓主選單連結更改為編排頁的網址，記得下面的"才不會出現沒有編號"的那個，要加上該功能的名稱，例如preg_match('/(xxx|company)...
				// if($_router_method == 'company') $v['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_1.php';

				if($_constant == 1){ // 頂層是分類，第二層是相簿
					$rows = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
					if($rows and count($rows) > 0){
						foreach($rows as $kkk => $vvv){
							// 這樣子才不會出現沒有編號的時候
							if($kkk == 0){
								$v['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
							}
							$tmp2 = array(
								'id' => $vvv['id'], // 給menu-sub的資料流所使用
								'name' => $vvv['name'],
								'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
							);
							$v['child'][] = $tmp2;
						}
					}
				} elseif($_constant == 0){ // 分類是相簿
					$rows = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
					if($rows and count($rows) > 0){
						foreach($rows as $kkk => $vvv){
							$tmp2 = array(
								'id' => $vvv['id'], // 給menu-sub的資料流所使用
								'name' => $vvv['name'],
								'url' => $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
							);
							$v['child'][] = $tmp2;
						}
					}
				} elseif($_constant == 2){ // 只有相片
					// 沒有次選單的話，請在最上面處理
					// $v['url'] = $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php';
				}

				// 請自行決定是否要使用
				// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標3', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_3.php');
				// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標4', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_4.php');
			}
		} // foreach functions

		//    舊的通用資料表撰寫方式
		//
		//    $common_detail_page = $v['is_news'];
		//
		//    if(0){
		//		  $common_method = $common_method_condition = str_replace('_'.$this->data['ml_key'].'.php', '', $v['url']);
		//		  if($common_is_category == 1){ // 有分類
		//			$common_method_condition .= 'type';
		//		  } else { // 沒分類
		//			// if($common_detail_page == 1){ // 有內頁
		//			// 	$common_method .= 'detail';
		//			// }
		//			if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$common_method.'detail.php')){
		//				$common_method .= 'detail';
		//			}
		//		  }

		//		  if($common_is_html_table == 1){
		//			// 通用資料表
		//			$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$common_method_condition,':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
		//			if($rows and count($rows) > 0){
		//				foreach($rows as $kkk => $vvv){
		//					$tmp2 = array(
		//						'name' => $vvv['topic'],
		//						'url' => $url_prefix.$common_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
		//					);
		//					$v['child'][] = $tmp2;
		//				}
		//			}
		//		  } else {
		//			// 先檢查是不是有多層的功能
		//			$pid_condition = '';
		//			if($common_is_category == 1){ // 有分類
		//				$row = $this->db->createCommand()->from($common_method_condition)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryRow();
		//				if($row and isset($row['id']) and $row['id'] > 0 and isset($row['pid'])){
		//					$pid_condition = ' and pid=0 ';
		//				}
		//			}

		//			// 獨立資料表
		//			$rows = $this->db->createCommand()->from($common_method_condition)->where('is_enable=1 and ml_key=:ml_key '.$pid_condition, array(':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
		//			if($rows and count($rows) > 0){
		//				foreach($rows as $kkk => $vvv){
		//					$tmp2 = array(
		//						'name' => $vvv['topic'],
		//						'url' => $url_prefix.$common_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
		//					);
		//					$v['child'][] = $tmp2;
		//				}
		//			}
		//		  }
		//    }

		// foreach($functions as $kk => $vv){
		// 	$_router_method = $vv;
		// 	unset($_constant);
		// 	eval('$_constant = '.strtoupper($_router_method.'_show_type').';');
		// 	if($v['url'] == $_router_method.'_'.$this->data['ml_key'].'.php'){

		// 		// 為了和靜態分項的搭配，所以才註解起來
		// 		// $v['child'] = array();

		// 		// 請自行決定是否要使用
		// 		// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標1', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_1.php');
		// 		// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標2', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_2.php');

		// 		// 請自行決定是否要使用，讓主選單連結更改為編排頁的網址，記得下面的"才不會出現沒有編號"的那個要註解掉
		// 		// if($_router_method == 'company') $v['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_1.php';

		// 		if($_constant == 1){ // 有分類
		// 			$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$_router_method.'type',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
		// 			if($rows and count($rows) > 0){
		// 				foreach($rows as $kkk => $vvv){
		// 					// 這樣子才不會出現沒有編號的時候
		// 					if($kkk == 0){
		// 						$v['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
		// 					}
		// 					$tmp2 = array(
		// 						'name' => $vvv['topic'],
		// 						'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
		// 					);
		// 					$v['child'][] = $tmp2;
		// 				}
		// 			}
		// 		} elseif($_constant == 2){ // 無分類
		// 			$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$_router_method,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
		// 			if($rows and count($rows) > 0){
		// 				foreach($rows as $kkk => $vvv){
		// 					// 這樣子才不會出現沒有編號的時候
		// 					if($kkk == 0 and !preg_match('/(xxx|company)/', $_router_method)){
		// 						$v['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
		// 					}
		// 					$tmp2 = array(
		// 						'name' => $vvv['topic'],
		// 						// 這個是沒列表頁在用的，有列表頁的，需要取消下拉
		// 						// 在後台的 / 前台選單 / 該功能 / 是否有次選單 / 有或沒有
		// 						'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
		// 					);
		// 					$v['child'][] = $tmp2;
		// 				}
		// 			}
		// 		}

		// 		// 請自行決定是否要使用
		// 		// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標3', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_3.php');
		// 		// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標4', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_4.php');
		// 	}
		// } // foreach functions

		// foreach($functions_album as $kk => $vv){
		// 	$_router_method = $vv;
		// 	unset($_constant);
		// 	eval('$_constant = '.strtoupper($_router_method.'_type_later').';');
		// 	if($v['url'] == $_router_method.'_'.$this->data['ml_key'].'.php'){

		// 		// 為了和靜態分項的搭配，所以才註解起來
		// 		// $v['child'] = array();

		// 		// 請自行決定是否要使用
		// 		// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標1', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_1.php');
		// 		// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標2', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_2.php');

		// 		// 請自行決定是否要使用，讓主選單連結更改為編排頁的網址，記得下面的"才不會出現沒有編號"的那個，要加上該功能的名稱，例如preg_match('/(xxx|company)...
		// 		// if($_router_method == 'company') $v['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_1.php';

		// 		// define('ALBUMTYPE_LATER',1);//活動花絮分類層次數量 0 無分類 1 單一層 2 多層 (要記得去切換檔案
		// 		if($_constant == 1){ // 有分類(一層)
		// 			$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$_router_method.'type',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
		// 			if($rows and count($rows) > 0){
		// 				foreach($rows as $kkk => $vvv){
		// 					// 這樣子才不會出現沒有編號的時候
		// 					if($kkk == 0){
		// 						$v['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
		// 					}
		// 					$tmp2 = array(
		// 						'name' => $vvv['topic'],
		// 						'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
		// 					);

		// 					// ■  密碼鎖：可針對個別相簿執行密碼上鎖
		// 					// $tmp2['url'] = 'javascript:;';
		// 					// $tmp2['anchor_class'] = 'openBtn';
		// 					// $tmp2['anchor_data_target'] = '#loginPanel_pwd';

		// 					$v['child'][] = $tmp2;
		// 				}
		// 			}
		// 		} elseif($_constant == 0){ // 無分類
		// 			$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$_router_method,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
		// 			if($rows and count($rows) > 0){
		// 				foreach($rows as $kkk => $vvv){
		// 					// 這樣子才不會出現沒有編號的時候
		// 					// if($kkk == 0 and !preg_match('/(xxx|company)/', $_router_method)){
		// 					// 	$v['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
		// 					// }
		// 					$tmp2 = array(
		// 						'name' => $vvv['topic'],
		// 						'url' => $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'],
		// 					);

		// 					// ■  密碼鎖：可針對個別相簿執行密碼上鎖
		// 					// $tmp2['url'] = 'javascript:;';
		// 					// $tmp2['anchor_class'] = 'openBtn';
		// 					// $tmp2['anchor_data_target'] = '#loginPanel_pwd';
		// 					// $v['child'][] = $tmp2;

		// 					$v['child'][] = $tmp2;
		// 				}
		// 			}
		// 		} elseif($_constant == 2){ // 無限層
		// 			// 有遇到在寫
		// 		}

		// 		// 請自行決定是否要使用
		// 		// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標3', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_3.php');
		// 		// if($_router_method == 'company') $v['child'][] = array('name' => '***請說明次標4', 'url' => $url_prefix.$_router_method.'_'.$this->data['ml_key'].'_4.php');
		// 	}
		// } // foreach functions


		// $_router_method = 'product';
		// if($v['url'] == $_router_method.'_'.$this->data['ml_key'].'.php'){

		// 	// SEO Product
		// 	$rows_seo = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>'producttype'))->queryAll();
		// 	$rows_tmp = array();
		// 	if($rows_seo){
		// 		foreach($rows_seo as $k_seo => $v_seo){
		// 			$rows_tmp[$v_seo['seo_item_id']] = $v_seo;
		// 		}
		// 	}

		// 	// 產品無分類，記得把分類的部份註解掉 2017-06-19
		// 	// $rows = $this->db->createCommand()->from($_router_method)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
		// 	// if($rows){
		// 	// 	foreach($rows as $kk => $vv){
		// 	// 		if($kk == 0){
		// 	// 			$v['url'] = $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vv['id'];
		// 	// 		}
		// 	// 		$rows[$kk]['url'] = $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vv['id'];
		// 	// 	}
		// 	// 	$v['child'] = $rows;
		// 	// }

		// 	// 當這個打開的時候，下面那個moreMenu就可以關閉
		// 	//$v['class'] = 'multiMenu';
		// 	$rows = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
		// 	if($rows){
		// 		foreach($rows as $kk => $vv){
		// 		$rows2 = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and pid=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
		// 			//$rows2 = $this->db->createCommand()->from('product')->where('is_enable=1 and class_id=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
		// 			if($rows2 and count($rows2) > 0){
		// 				// 這個當multiMenu關閉的時候，這個就可以打開
		// 				$rows[$kk]['class'] = 'moreMenu';
		// 				foreach($rows2 as $kkk => $vvv){
		// 					$rows2[$kkk]['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
		// 					//$rows2[$kkk]['url'] = $_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
		// 				}
		// 				$rows[$kk]['child'] = $rows2;

		// 				//2017/6/8 預設上層不給點 by lota
		// 				$rows[$kk]['url'] = 'javascript:;';
		// 			}else{
		// 				//如果沒子類別，則顯示連結 by lota
		// 				$rows[$kk]['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vv['id'];
		// 			}
		// 			
		// 			//如果網址是有效連結，則判斷是否需要做SEO化 by lota
		// 			if($rows[$kk]['url']!='javascript:;'){
		// 				if(isset($rows_tmp[$vv['id']]) and $rows_tmp[$vv['id']]['seo_script_name'] != ''){
		// 					// SEO
		// 					$rows[$kk]['url'] = $rows_tmp[$vv['id']]['seo_script_name'].'.html';
		// 				} else {
		// 					$rows[$kk]['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vv['id'];
		// 				}
		// 			}
		// 				

		// 			// 有子分類的話，就不給點 2017-04-17 李哥和查理
		// 			// 如果是選擇promenu2的話，這裡要註解掉哦
		// 			// 2017/6/8 這邊如果分類一些有子分類，一些沒子分類的話會錯誤，所以改用279行的自動判別方式 by lota
		// 			//if($rows2 and count($rows2) > 0){
		// 			//	$rows[$kk]['url'] = 'javascript:;';
		// 			//}
		// 		}
		// 		$v['child'] = $rows;
		// 	}
		// }

		// $_router_method = 'shop';
		// if($v['url'] == $_router_method.'_'.$this->data['ml_key'].'.php'){
		// 	// 當這個打開的時候，下面那個moreMenu就可以關閉
		// 	//$v['class'] = 'multiMenu';
		// 	$rows = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
		// 	if($rows){
		// 		foreach($rows as $kk => $vv){
		// 			$rows2 = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and pid=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
		// 			//$rows2 = $this->db->createCommand()->from('product')->where('is_enable=1 and class_id=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
		// 			if($rows2 and count($rows2) > 0){
		// 				// 這個當multiMenu關閉的時候，這個就可以打開
		// 				$rows[$kk]['class'] = 'moreMenu';
		// 				foreach($rows2 as $kkk => $vvv){
		// 					$rows2[$kkk]['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
		// 					//$rows2[$kkk]['url'] = $_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
		// 				}
		// 				$rows[$kk]['child'] = $rows2;
		// 			}
		// 			$rows[$kk]['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vv['id'];
		// 		}
		// 		$v['child'] = $rows;
		// 	}
		// }

		/*
		 * 通用資料表結束
		 */

		// 子選單 / 靜態次選單
		// 這裡是動態分項的下方，還有一個上方的哦，內容幾乎是一樣的
		if($v['video_2'] > 0 and $v['video_4'] == 2){
			// 當這個打開的時候，下面那個moreMenu就可以關閉
			//$v['class'] = 'multiMenu';
			$rows = $this->db->createCommand()->from('webmenuchild')->where('is_enable=1 and pid='.$v['video_2'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
			if($rows){
				foreach($rows as $kk => $vv){
					$rows2 = $this->db->createCommand()->from('webmenuchild')->where('is_enable=1 and pid=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
					//$rows2 = $this->db->createCommand()->from('product')->where('is_enable=1 and class_id=:pid and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key'],':pid'=>$vv['id']))->order('sort_id')->queryAll();
					if($rows2 and count($rows2) > 0){
						// 這個當multiMenu關閉的時候，這個就可以打開
						$rows[$kk]['class'] = 'moreMenu';
						//foreach($rows2 as $kkk => $vvv){
						//	$rows2[$kkk]['url'] = $url_prefix.$_router_method.'_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
						//	//$rows2[$kkk]['url'] = $url_prefix.$_router_method.'detail_'.$this->data['ml_key'].'.php?id='.$vvv['id'];
						//}
						$rows[$kk]['child'] = $rows2;
					}
					//$rows[$kk]['url'] = $_router_method.'_'.$this->data['ml_key'].'.php?id='.$vv['id'];
				}
				if(count($rows) > 0){
					$v['child'] = array_merge($v['child'],$rows);
				}
			}
		}

		// 動態網址 2017-09-20有跟李哥討論過
		// 2017-09-21 李哥說，預設功能是開著的，底下是舊站要跟進的話，需要更新的檔案：
		// 2017-09-25 Ming說，對SEO沒有影響
		// source/core.php
		// source/menu/v1.php
		// ajax2.php
		// source/contact/post.php
		// source/top_link_menu/v1.php
		// contact/
		// if($v['url'] == 'contact_'.$this->data['ml_key'].'.php' and $this->data['router_method'] != 'contact'){
		// 	if($position == 1){
		// 		if(isset($_SESSION['save']['contact_dynamic_url_handled']) and $_SESSION['save']['contact_dynamic_url_handled'] == true){
		// 			unset($_SESSION['save']['contact_dynamic_url_handled']);
		// 		} else {
		// 			$_SESSION['save']['contact_dynamic_url'] = substr(md5(microtime()),rand(0,26),15);
		// 		}

		// 	}
		// 	$v['url'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
		// 	$this->data['func_name_href'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
		// }

		if($v['url'] == 'contact_'.$this->data['ml_key'].'.php' and isset($_SESSION['save']['contact_dynamic_url'])){
			$v['url'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
		}

		// SEO主選單靜態頁範例 2017-10-27
		// if($v['url'] == 'photo_tw.php'){
		// 	$v['url'] = '網頁設計.html';
		// }

		// 子選單 / 純手工範本
		// if($v['url'] == 'contact_tw.php'){
		// 	$v['child'] = array(
		// 		array(
		// 			'name' => '服務據點',
		// 			'url' => 'location_tw.php',
		// 		),
		// 		array(
		// 			'name' => '客制頁面',
		// 			'url' => 'javascript:;',
		// 		),
		// 	);
		// }

		// SEO 這個沒有作用了
		// unset($_constant);
		// eval('$_constant = '.strtoupper('seo_open').';');
		// if($_constant == 1){ // 有分類
		// 	if(!preg_match('/tw\//', $v['url']) and !preg_match('/^http/', $v['url'])){
		// 		$v['url'] = $url_prefix.$v['url'];
		// 	}
		// }

		// 第一個次選單去覆寫網址的欄位，這個是後台的功能
		if(isset($v['other3'])){
			if($v['other3'] >= 1 and isset($v['child']) and count($v['child']) > 0 and $v['child'] != '#' and $v['child'] != 'javascript'){
				$v['url'] = $v['child'][0]['url'];
			}
		}

		$tmp[$k] = $v;
	}
}

if(isset($ID)){
	$data[$ID] = $tmp;
}

// 沒有加，會影響到breadcrumb
unset($functions);
unset($functions_album);
unset($functions_photo);

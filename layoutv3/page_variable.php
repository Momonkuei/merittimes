<?php

/*
 * 2018-03-01
 * 後台 / LayoutV3 / 頁面區塊
 */

// http://stackoverflow.com/questions/8587341/recursive-function-to-generate-multidimensional-array-from-database-result
function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['hole'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}

if(!isset($page) or count($page) <= 0){
	$rows = $this->db->createCommand()->select('id, table_content, name as file, pid as parent_id, params, other_func,theme_name')->from('layoutv3pagetype')->where('is_enable=1')->order('sort_id')->queryAll();
	if($rows and !empty($rows)){

		// 2020-01-08
		// seo非主語系的資料夾，首頁的情況，需要做這個修正
		if(preg_match('/^\/..\/$/', $_SERVER['REQUEST_URI'], $matchesg)){
			$_SERVER['REQUEST_URI'] .= 'index.php';
		}

		// 2018-03-26 打算支援的網址 $_SERVER['REQUEST_URI']
		// /faq_tw.php
		// /company_tw_1.php 
		// /news/news.php
		// /news_tw.php?id=17
		// /XXX.php
		$tmps = explode('/', $_SERVER['REQUEST_URI']);
		$request_uri = $_SERVER['REQUEST_URI'];

		// 動態網址(第2版)
		if(file_exists('_i/assets/_dynamic_url.php')){
			include '_i/assets/_dynamic_url.php';
		}

		if(count($tmps) == 3){
			if(isset($_dynamic_url) and in_array($tmps[1], $_dynamic_url)){
				$request_uri = '/'.$tmps[1].'.php';
			} else {
				$request_uri = '/'.$tmps[2];
			}
		}

		$tmp = str_replace('/', '', str_replace('.php','', $request_uri));
		$tmp2 = explode('?', $tmp);
		$tmp = $tmp2[0];

		// 為了要支援沒有語系(_tw)的網址
		if(!preg_match('/_'.$this->data['ml_key'].'$/', $tmp)){
			$tmp .= '_'.$this->data['ml_key'];
		}

		foreach($rows as $k => $v){
			$other_func = explode(',',$v['other_func']);
			// if($v['parent_id'] == 0 and $v['file'].'_'.$this->data['ml_key'] != $tmp and !in_array(str_replace('_'.$this->data['ml_key'],'',$tmp),$other_func)){
			if($v['parent_id'] == 0 and ($v['theme_name'] != LAYOUTV3_THEME_NAME or ($v['file'].'_'.$this->data['ml_key'] != $tmp and !in_array(str_replace('_'.$this->data['ml_key'],'',$tmp),$other_func)))){
				unset($rows[$k]);
			} else {
				// 2018-03-12 下午，有跟李哥報告過這個東西(layoutv3 + params)
				$layer_params = $v['params'];

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
				$rows[$k]['params'] = $m_params;

				// 2019-12-12
				if($v['file'] == 'system/other_page'){
					$file_alias = 'other_page';
					$node = array(
						'params' => $m_params,
					);
					/*
					 * 參數1：table
					 * 參數2：type
					 * 參數3：file對應哪一個欄位
					 * 參數4：parent_id對應哪一個欄位
					 * 參數5：params對應哪一個欄位
					 */
					$field_check = true;
					for($x=1;$x<=5;$x++){
						if(!isset($node['params'][$file_alias.'_'.$x]) or $node['params'][$file_alias.'_'.$x] == ''){
							$field_check = false;
						}
					}

					// 2020-09-30 這個是做給第二版的模組編排頁所使用
					// table		| other_page_1:XXX,
					// type			| other_page_2:XXX,
					// file			| other_page_3:topic,
					// parent_id	| other_page_4:class_id,
					// params		| other_page_5:detail_top
					if($node['params'][$file_alias.'_1'] == 'XXX' and $node['params'][$file_alias.'_2'] == 'XXX'){
						$node['params'][$file_alias.'_1'] = 'html';
						$node['params'][$file_alias.'_2'] = 'userblockv4'.str_replace('_'.$this->data['ml_key'],'',$tmp);
					}

					if($field_check === true){
						$o = $db->select('id, '.$node['params'][$file_alias.'_3'].' as file, '.$node['params'][$file_alias.'_4'].' as parent_id, '.$node['params'][$file_alias.'_5'].' as params')->where('is_enable',1)->where('ml_key',$this->data['ml_key']);
						if($node['params'][$file_alias.'_1'] == 'html'){
							$o = $o->where('type',$node['params'][$file_alias.'_2']);
						}
						$o = $o->order_by('sort_id','asc');
						$rowsg = $o->get($node['params'][$file_alias.'_1'])->result_array();
						//var_dump($rowsg);

						if($rowsg and !empty($rowsg)){
							$newid = 999999+$v['id']; // 因為other_page和底下的東西，中間打算放一個容器，而這個編號就是容器的編號
							foreach($rowsg as $kk => $vv){
								// 2018-03-12 下午，有跟李哥報告過這個東西(layoutv3 + params)
								// 2020-10-07 這裡的參數，可以參考_i/backend/include/sample_userblock.php +699
								$layer_params = $vv['params'];

								// 區塊那邊，才可以找回得到原本的地方，只打算支援通用資料表
								if($node['params'][$file_alias.'_1'] == 'html'){
									if($layer_params != ''){
										$layer_params .= ',';
									}
									$layer_params .= 'id:'.$vv['id'].',router_method:'.$node['params'][$file_alias.'_2'];
								}

								// 2020-09-01
								// dirty hack
								// 如果上一筆有參數，而下一筆完全沒有，這時下一筆會有上一筆的參數
								// 因為還沒有找到問題，所以如果沒有參數的話，就隨便給它亂加一個
								if($layer_params == ''){
									$layer_params = 'aa123456:';
								}

								$m_params2 = array();
								if($layer_params != ''){
									$m_params2 = explode(',', $layer_params);
								}
								if($m_params2){
									$m_params2_tmp = array(); // 檢查有沒有重覆的key值
									foreach($m_params2 as $kkk => $vvv){
										if(preg_match('/^(.*)\:(.*)$/', $vvv, $matches)){
											if(!isset($m_params2_tmp[$matches[1]])){
												$m_params2_tmp[$matches[1]] = '';
												$m_params2[$kkk] = '"'.$matches[1].'":"'.$matches[2].'"';
											} else {
												// 2018-01-30 下午發現的，因為andwhere條件只能下一次
												$m_params2[$kkk] = '"'.$matches[1].$kkk.'":"'.$matches[2].'"';
											}
										}
									}
								}

								$m_params = json_decode('{'.implode(',', $m_params2).'}', true);

								$rowsg[$kk]['id'] = 999999+$rowsg[$kk]['id'];
								if($rowsg[$kk]['parent_id'] == 0){
									$rowsg[$kk]['parent_id'] = $newid;
								} else {
									$rowsg[$kk]['parent_id'] = 999999+$rowsg[$kk]['parent_id'];
								}
								$rowsg[$kk]['params'] = $m_params;
							}
							$rowsg[] = array(
								'id' => $newid,
								'table_content' => '',
								'file' => '-group',
								'parent_id' => $v['id'],
								'params' => array(),
								'other_func' => '',
							);
							foreach($rowsg as $kk => $vv){
								$rows[] = $vv;
							}
						}
					} // field_check
				}
			}
		}
	}
	// var_dump($rows);die;
	$result = buildTree($rows);
	if(!isset($result[0])){
		echo '404';
		header("HTTP/1.0 404 Not Found");
		die;
	}
	$page = $result[0]['hole'];


	// debug
	// echo var_export($page,true);

	// if(isset($_SESSION['auth_admin_id']) and preg_match('/\,(999995)\,/', ','.$_SESSION['auth_admin_type'].',')){
	// 	// var_dump($page_layoutit);
	// }

}

$_layoutv3pagetype_id = 0; // 2018-08-23 打算用在前台頁面的頁尾，連結後台的頁面的方式，李哥早上有看過
if(!isset($page_source) or count($page_source) <= 0){

	// 2018-03-26 打算支援的網址 $_SERVER['REQUEST_URI']
	// /faq_tw.php
	// /company_tw_1.php 
	// /news/news.php
	// /news_tw.php?id=17
	// /XXX.php
	$tmps = explode('/', $_SERVER['REQUEST_URI']);
	$request_uri = $_SERVER['REQUEST_URI'];

	// 動態網址(第2版)
	if(file_exists('_i/assets/_dynamic_url.php')){
		include '_i/assets/_dynamic_url.php';
	}

	if(count($tmps) == 3){
		if(isset($_dynamic_url) and in_array($tmps[1], $_dynamic_url)){
			$request_uri = '/'.$tmps[1].'.php';
		} else {
			$request_uri = '/'.$tmps[2];
		}
	}

	// /news_tw.php?id=123
	$name = str_replace('/', '', str_replace('.php','',$request_uri));
	$name2 = explode('?', $name);

	$names = explode('_',$name2[0]);
	$name = $names[0];

	// company_tw_1.php
	if(count($names) == 3 and strlen($names[1]) == 2){
		$name .= '_'.$names[2];
	}

	$row = $this->cidb->query('select * from layoutv3pagetype where is_enable=1 and pid=0 and theme_name="'.LAYOUTV3_THEME_NAME.'" and ( name="'.$name.'" or concat(",",other_func,",") LIKE "%,'.$name.',%" )')->row_array();
	if($row and isset($row['id'])){
		if($row['page_source_tmp'] != ''){
			$page_source = explode(',', $row['page_source_tmp']);
		}

		if(isset($row['debug']) and $row['debug'] > 0){
			$_layoutv3pagetype_id = $row['id']; 
		}
	}
}

// 2018-03-14 DB區塊，規則設定的跟實體區塊不一樣，只會單純的找該語系的DB區塊，而不是像實體一樣
$rows = $this->cidb->where('is_enable',1)->where('type','layoutv3view')->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get('html')->result_array();
if($rows){
	foreach($rows as $k => $v){
		$this->data['%view'][$v['topic'].'_'.$v['ml_key']] = $v['field_tmp'];
	}
}

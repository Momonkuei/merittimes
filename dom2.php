<?php

// @session_start();

// 如果是非法呼叫，這邊會先做第一次的阻擋，接下來裡面的資料流也要禁止某些資料表使用
if(0 and isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
	header("HTTP/1.0 404 Not Found");
	die;
}

/*
 * 2017-10-23 10:49 有跟李哥報告要做這個東西
 * 這個東西是給前端在本地開發時間用的假資料功能的前身
 */

include 'layoutv3/init.php';

// 單筆
if(
	!empty($_POST) and isset($_POST['html2']) and isset($_POST['ms']) and isset($_POST['index'])
	and $_POST['html2'] != '' and $_POST['ms'] != '' and $_POST['index'] >= 0
){
	if(!isset($simplehtml)){
		$simplehtml = new SimpleHtmlDom;
	}

	$out = $_POST['html2'];
	$html = str_get_html($out, true, true, DEFAULT_TARGET_CHARSET, false);

	$parent = 'find("*[d*=]", "0")';

	$data_source = $_POST['ms'];

	$content = array();

	// 資料流
	if($data_source != ''){

		$tmps = explode('.', $data_source);
		$type = $tmps[0];

		// $table = $matches[1];
		// $condition = $matches[2];

		if($type == 'table'){
			$table = $tmps[1];
			$data_id = $tmps[2];
			$content = $this->db->createCommand()->from($table)->where('id=:id',array(':id'=>$data_id))->queryRow();
			$file_dir = '';

			if($table == 'html' and $content and isset($content['type'])){
				$file_dir = $content['type'];
			} else {
				$file_dir = $table;
			}
		}

		if(count($content) > 0){ // 這裡是欄位的迴圈哦
			foreach($content as $kkk => $vvv){
				if(preg_match('/^pic/', $kkk) and $vvv != ''){
					$vvv = '_i/assets/upload/'.$file_dir.'/'.$vvv;
				} elseif(preg_match('/^file/', $kkk) and $vvv != ''){
					$vvv = '_i/assets/file/'.$file_dir.'/'.$vvv;
				}
				$content[$kkk] = $vvv;
			}
		}
	}

	$gggg = $content;

	$tags_repeated = array();
	$run = '$vvv = $html->'.$parent.';';
	eval($run);

	// 假設是anchor，當然，不可能只有一個
	// 如果上面有anchor，但是不用套，但下面那個有套，所以，上面那個，也要加上dom="f"，很重要，一定會遇到
	if(isset($tags_repeated[$vvv->tag])){
		$tags_repeated[$vvv->tag]++;
	} else {
		$tags_repeated[$vvv->tag] = 0;
	}
	$repeated = $tags_repeated[$vvv->tag];

	// 因為有時會得到多筆的屬性
	$tmpg = array();

	if(count($vvv->attr) >= 2){ // Tag的屬性
		$tmp2 = $vvv->attr;
		unset($tmp2['d']);
		foreach($tmp2 as $attr => $value){
			$tmpg[] = array(
				'attr' => $attr,
				'value' => $value,
				'is_attr' => true,
			);
		}

		// 偵測是否有tag存在，如果不存在且不是空白，那就也納進去規則
		$value = $vvv->innertext;
		// $value = $vvv->plaintext;
		if($value != '' and $value == strip_tags($value)){
			$attr = 'innertext';
			$tmpg[] = array(
				'attr' => $attr,
				'value' => $value,
			);
		}

	} elseif(count($vvv->attr) == 1){ // 例如P, H*, SPAN等
		$attr = 'innertext';
		// $value = $vvv->plaintext;
		$value = $vvv->innertext;

		$tmpg[] = array(
			'attr' => $attr,
			'value' => $value,
		);
	}

	foreach($tmpg as $kkkk => $vvvv){

		$attr = $vvvv['attr'];
		$value = $vvvv['value'];
		$is_attr = false;
		if(isset($vvvv['is_attr'])){
			$is_attr = $vvvv['is_attr'];
		}

		if(preg_match('/\{\*(.*)\*\}/i', $value, $matches)){
			if(isset($gggg[$matches[1]])){
				$value = $gggg[$matches[1]];
			}
		// 例如：<div style="background:url(XXXXXX) no-repeat center center/cover;"></div>
		} elseif(preg_match('/\{\/.*\/\}/i', $value)){

			// http://php.net/manual/en/function.preg-match-all.php#101259
			preg_match_all('/{\/[^}]*\/}/i', $value, $matches);

			if(isset($matches[0]) and count($matches[0]) > 0){
				// @vvvvv string {/otherx/}
				foreach($matches[0] as $vvvvv){
					$element = str_replace('{/', '', str_replace('/}', '', $vvvvv));
					if(isset($gggg[$element])){
						$value = str_replace($vvvvv, $gggg[$element], $value);
					}
				}
			}
		} else {
			if($is_attr === false){
				$value = '';
			}
		}

		// 參考：$tmp['find("a",0)->href'] = $v['url']
		// 其中href的屬性名稱的部份，不能有"-"，例如data-txtlen
		// 所以要改寫成->{'data-txtlen'}
		$vv['find("'.$vvv->tag.'",'.$repeated.')->{\''.$attr.'\'}'] = $value;
	} // vvvv

	// @kkk 規則
	$run = '';
	foreach($vv as $kkk => $vvv){
		// if(preg_match('/doms/', $kkk)){
		// 	continue;
		// }
		$tmps = explode('->', $kkk); // find("span",0)->{'innertext'} 只留後面的那個，這樣下條件也比較單純

		if(preg_match('/innertext/', $tmps[1])){
			// $run .= '$("*[dom=single]").eq('.$_POST['index'].').html(\''.$vvv.'\');';
			$run .= 'thisobj.html(\''.$vvv.'\');';
		} else {
			// $run .= '$("*[dom=single]").eq('.$_POST['index'].').attr(\''.str_replace('{\'','',str_replace('\'}','',$tmps[1])).'\', \''.$vvv.'\');';
			$run .= 'thisobj.attr(\''.str_replace('{\'','',str_replace('\'}','',$tmps[1])).'\', \''.$vvv.'\');';
		}
		// eval($run); // cc
	}

	// $run .= '$("*[dom=single]").eq('.$_POST['index'].').removeAttr(\'doms\');';
	// $run .= '$("*[dom=single]").eq('.$_POST['index'].').removeAttr(\'dom\');';

	// $run .= 'thisobj.removeAttr(\'doms\');';
	$run .= 'thisobj.removeAttr(\'d\');';

	echo $run;
	die;

} // 單筆

// 多筆
if(
	!empty($_POST) and isset($_POST['html']) and isset($_POST['ms'])
	and $_POST['html'] != '' and $_POST['ms'] != ''
){
	if(!isset($simplehtml)){
		$simplehtml = new SimpleHtmlDom;
	}

	$out = $_POST['html'];
	$html = str_get_html($out, true, true, DEFAULT_TARGET_CHARSET, false);

	$parent = 'find("*[m*=multi]", "0")->innertext'; // 多筆要assign到哪裡去
	$one = 'find("*[m*=1]", "0")->outertext'; // 單筆在哪裡
	$start = 'find("*[m*=s]", "0")->outertext'; // 第一筆在哪裡，因為有時候會需要，第一筆的時候，某個地方要加上class，例如active
	$odd = 'find("*[m*=o]", "0")->outertext'; // 奇數 2017-10-19 李哥說好
	$even = 'find("*[m*=e]", "0")->outertext'; // 偶數 2017-10-19 李哥說好
	$kill = ''; // 如果沒有資料的話要刪掉誰，如果是multi，最後不要刪掉它，或是assign一個空的multi，記到。對了，dom="1"也是一樣哦
	$kill_assign = ''; // 為了要避免刪到multi

	$data_source = $_POST['ms'];

	$content = array();

	// 資料流
	if(preg_match('/^(.*)\:(.*|)$/', $data_source, $matches)){
		$table = $matches[1];
		$condition = $matches[2];

		// 獨立資料表安全性
		//$deny_standalones = array(

		if($table == 'html'){
			$o = $this->db->createCommand()->from('html');
			$o = $o->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$condition,':ml_key'=>$this->data['ml_key']));
			$content = $o->order('sort_id')->queryAll();
		} else {
			if(preg_match('/(admin_|agent|contact|customer|keep|member|record|scss|seo|shop|sys_)/', $table)){
				// 安全性
			} else {
				$o = $this->db->createCommand()->from($table);
				$o = $o->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']));
				$content = $o->order('sort_id')->queryAll();
			}
		}

		if(count($content) > 0){
			foreach($content as $kk => $vv){
				foreach($vv as $kkk => $vvv){
					if(preg_match('/^pic/', $kkk) and $vvv != ''){
						if($table == 'html'){
							$vvv = '_i/assets/upload/'.$condition.'/'.$vvv;
						} else {
							$vvv = '_i/assets/upload/'.$table.'/'.$vvv;
						}
					} elseif(preg_match('/^file/', $kkk) and $vvv != ''){
						if($table == 'html'){
							$vvv = '_i/assets/file/'.$condition.'/'.$vvv;
						} else {
							$vvv = '_i/assets/file/'.$table.'/'.$vvv;
						}
					}
					$vv[$kkk] = $vvv;
				}
				$content[$kk] = $vv;
			}
		}
	} elseif($data_source == ''){ // doms是空白的情況，那就是串接V3的資料格式，記得要自行指定和處理資料流或是下規則
		// 不支援
	} else {
		// 不支援
	}

	$data_return = '';

	if(count($content) > 0){
		// @gggg 單筆的資料
		foreach($content as $kk => $gggg){
			$vv = array();

			if($kk % 2 == 0){
				// 因為零，也是偶數，所以規則在預設規則之上，所以這裡有三條規則檢查
				$run = '$html2_section = $html->'.$even.';';
				@eval($run);
				if($html2_section == ''){
					$run = '$html2_section = $html->'.$start.';';
					@eval($run);
					if($html2_section == ''){
						$run = '$html2_section = $html->'.$one.';';
						eval($run);
					}
				}
			} elseif($kk % 2 == 1){
				// 如果不是奇數，那就是預設規則了
				$run = '$html2_section = $html->'.$odd.';';
				@eval($run);
				if($html2_section == ''){
					$run = '$html2_section = $html->'.$one.';';
					eval($run);
				}
			}

			// } else { // 預設規則 one，但是上面加太多判斷式，所以理論上不會走到這裡來
			// 	$run = '$html2_section = $html->'.$one.';';
			// 	eval($run);

			$html2 = str_get_html($html2_section, true, true, DEFAULT_TARGET_CHARSET, false);

			// 測試動態產生欄位規則
			$tags_repeated = array();
			foreach($html2->find('*[m*=f]') as $vvv){

				// 假設是anchor，當然，不可能只有一個
				// 如果上面有anchor，但是不用套，但下面那個有套，所以，上面那個，也要加上dom="f"，很重要，一定會遇到
				if(isset($tags_repeated[$vvv->tag])){
					$tags_repeated[$vvv->tag]++;
				} else {
					$tags_repeated[$vvv->tag] = 0;
				}
				$repeated = $tags_repeated[$vvv->tag];

				// 因為有時會得到多筆的屬性
				$tmpg = array();

				if(count($vvv->attr) >= 2){ // Tag的屬性
					$tmp2 = $vvv->attr;
					unset($tmp2['m']);
					foreach($tmp2 as $attr => $value){
						$tmpg[] = array(
							'attr' => $attr,
							'value' => $value,
							'is_attr' => true,
						);
					}

					// 偵測是否有tag存在，如果不存在且不是空白，那就也納進去規則
					$value = $vvv->innertext;
					// $value = $vvv->plaintext;
					if($value != '' and $value == strip_tags($value)){
						$attr = 'innertext';
						$tmpg[] = array(
							'attr' => $attr,
							'value' => $value,
						);
					}

				} elseif(count($vvv->attr) == 1){ // 例如P, H*, SPAN等
					$attr = 'innertext';
					// $value = $vvv->plaintext;
					$value = $vvv->innertext;

					$tmpg[] = array(
						'attr' => $attr,
						'value' => $value,
					);
				}

				foreach($tmpg as $kkkk => $vvvv){

					$attr = $vvvv['attr'];
					$value = $vvvv['value'];
					$is_attr = false;
					if(isset($vvvv['is_attr'])){
						$is_attr = $vvvv['is_attr'];
					}

					if(preg_match('/\{\*(.*)\*\}/i', $value, $matches)){
						if(isset($gggg[$matches[1]])){
							$value = $gggg[$matches[1]];
						}
					// 例如：<div style="background:url(XXXXXX) no-repeat center center/cover;"></div>
					} elseif(preg_match('/\{\/.*\/\}/i', $value)){

						// http://php.net/manual/en/function.preg-match-all.php#101259
						preg_match_all('/{\/[^}]*\/}/i', $value, $matches);

						if(isset($matches[0]) and count($matches[0]) > 0){
							// @vvvvv string {/otherx/}
							foreach($matches[0] as $vvvvv){
								$element = str_replace('{/', '', str_replace('/}', '', $vvvvv));
								if(isset($gggg[$element])){
									$value = str_replace($vvvvv, $gggg[$element], $value);
								}
							}
						}
					} else {
						if($is_attr === false){
							$value = '';
						}
					}

					// 參考：$tmp['find("a",0)->href'] = $v['url']
					// 其中href的屬性名稱的部份，不能有"-"，例如data-txtlen
					// 所以要改寫成->{'data-txtlen'}
					$vv['find("'.$vvv->tag.'",'.$repeated.')->{\''.$attr.'\'}'] = $value;
				} // vvvv
			}

			// @kkk 規則
			foreach($vv as $kkk => $vvv){
				$run = '$html2->'.$kkk.' = \''.$vvv.'\';';
				eval($run); // bb
			}

			$data_return .= $html2;
		}

		// $run = '$html->'.$parent.' = \''.$data_return.'\';';
		// eval($run); // ss
	} else { // 其它指令 kill
	 	// $run = '$html->'.$kill.' = \''.$kill_assign.'\';';
	 	// eval($run); // ww
	}

	$aaa = $data_return;
	// $aaa = $html->save();

	// 輸出前，先把不該輸出的東西處理掉
	$aaa = str_replace('m="multi"', '', $aaa);
	$aaa = str_replace('m="e"', '', $aaa); // even
	$aaa = str_replace('m="o"', '', $aaa); // odd
	$aaa = str_replace('m="s"', '', $aaa); // start
	$aaa = str_replace('m="1"', '', $aaa); // default
	$aaa = str_replace('m="f"', '', $aaa); // field
	$aaa = str_replace('m="multi 1"', '', $aaa);
	$aaa = str_replace('m="multi s"', '', $aaa); // 這個應該不可能吧，不過還是寫下來
	$aaa = str_replace('m="e f"', '', $aaa);
	$aaa = str_replace('m="o f"', '', $aaa);
	$aaa = str_replace('m="s f"', '', $aaa);
	$aaa = str_replace('m="1 f"', '', $aaa);

	echo $aaa;
}

die;

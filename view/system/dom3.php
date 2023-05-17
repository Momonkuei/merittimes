<?php
/*
 * 2017-09-14
 * 這是LayoutV1的分身，改名叫DOM(simple html dom)
 * 是用插件的方式，存活在LayoutV3的環境裡面
 *
 * 使用方式：
 * 把一個靜態的頁面，放在這個的底下
 * 然後把page_source設定好
 * 最後就可以在source裡面寫程式了
 */

/*
 * 這個功能，是乖哥在2017-08-04下班前建議的
 */
?>

<?php ob_start()?>
<?php echo $AA?>
<?php 
$out = ob_get_contents();
ob_end_clean();

if(!isset($simplehtml)){
	$simplehtml = new SimpleHtmlDom;
}

$html = str_get_html($out, true, true, DEFAULT_TARGET_CHARSET, false);

if(isset($data[$ID])){
	// @k 主規則 root / kill
	// @v content
	foreach($data[$ID] as $k => $v){
		// if(preg_match('/\|/', $k)){ // 多筆 root

		$tmps = explode('|',$k);
		$parent = $tmps[0];
		$one = $tmps[1];
		$start = $tmps[2];
		$odd = $tmps[3];
		$even = $tmps[4];
		$kill = $v['kill'];
		$kill_assign = $v['kill_assign'];

		unset($data_source);
		$run = '$data_source = $html->'.str_replace('innertext', 'doms', $parent).';';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($data_source)){
			continue;
		}

		$content = array();

		// 資料流
		if(preg_match('/^(.*)\:(.*|)$/', $data_source, $matches)){
			$table = $matches[1];
			$condition = $matches[2];

			if(preg_match('/^(SINGLE|MULTI)$/', $table, $matches)){ // DATA2
				$content = $data2[$ID.'-0'][strtolower($matches[1])][$condition];
			} elseif($table == 'html'){
				$o = $this->db->createCommand()->from('html');
				$o = $o->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$condition,':ml_key'=>$this->data['ml_key']));
				$content = $o->order('sort_id')->queryAll();
			} else {
				$o = $this->db->createCommand()->from($table);
				$o = $o->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']));
				$content = $o->order('sort_id')->queryAll();
			}

			if(count($content) > 0 and !preg_match('/^(SINGLE|MULTI)$/', $table)){
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
			if(isset($data[$ID.'-0']) and count($data[$ID.'-0']) > 0){
				$content = $data[$ID.'-0'];
			}
		} else {
			if(isset($data[$data_source]) and count($data[$data_source]) > 0){
				$content = $data[$data_source];
			}
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
				foreach($html2->find('*[dom*=f]') as $vvv){

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
						unset($tmp2['dom']);
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

			$run = '$html->'.$parent.' = \''.$data_return.'\';';
			eval($run); // ss
		} else { // 其它指令 kill
		 	$run = '$html->'.$kill.' = \''.$kill_assign.'\';';
		 	eval($run); // ww
		}
		
	}
}

// 單筆預設有10筆規則，李哥在2017-10-23下午3點說好
for($x=0;$x<=9;$x++){
	$vv = array();

	$parent = 'find("*[dom*=single]", "'.$x.'")';

	unset($data_source);
	$run = '$data_source = $html->'.$parent.'->doms;';

	// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
	@eval($run); // gg
	if(!isset($data_source)){
		continue;
	}

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
		unset($tmp2['dom']);
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
	foreach($vv as $kkk => $vvv){
		$tmps = explode('->', $kkk); // find("span",0)->{'innertext'} 只留後面的那個，這樣下條件也比較單純
		$run = '$html->'.$parent.'->'.$tmps[1].' = \''.$vvv.'\';';
		eval($run); // cc
	}

}

$aaa = $html->save();

// 輸出前，先把不該輸出的東西處理掉
$aaa = str_replace('dom="multi"', '', $aaa);
$aaa = str_replace('dom="single"', '', $aaa);
$aaa = str_replace('dom="e"', '', $aaa); // even
$aaa = str_replace('dom="o"', '', $aaa); // odd
$aaa = str_replace('dom="s"', '', $aaa); // start
$aaa = str_replace('dom="1"', '', $aaa); // default
$aaa = str_replace('dom="f"', '', $aaa); // field
$aaa = str_replace('dom="multi 1"', '', $aaa);
$aaa = str_replace('dom="multi s"', '', $aaa); // 這個應該不可能吧，不過還是寫下來
$aaa = str_replace('dom="e f"', '', $aaa);
$aaa = str_replace('dom="o f"', '', $aaa);
$aaa = str_replace('dom="s f"', '', $aaa);
$aaa = str_replace('dom="1 f"', '', $aaa);

// 因為預設有5個規則
for($x=1;$x<=5;$x++){
	if(preg_match('/doms=\"(.*)\"/', $aaa, $matches)){
		// 假設性的錯誤處理
		if(preg_match('/\"/', $matches[1])){
			$tmps = explode('"', $matches[1]);
			$matches[1] = $tmps[0];
		}
		$aaa = str_replace('doms="'.$matches[1].'"', '', $aaa);
	}
}
echo $aaa;

if(isset($html)) unset($html);
if(isset($html2)) unset($html2);
if(isset($aaa)) unset($aaa);
?>

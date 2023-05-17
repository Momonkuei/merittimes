<?php
/*
 * 2017-09-13
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

// 因為要抓的是裡面那層(AA)的資料編號
$new_id = $ID.'-0';

if(isset($data[$new_id])){
	// var_dump($data[$new_id]);
	
	// @k 主規則
	// @v content
	foreach($data[$new_id] as $k => $v){
		if(count($v) > 0){

			// killme
			// $htmlg = str_get_html($html->save(), true, true, DEFAULT_TARGET_CHARSET, false);
			// $html = $html;

			if(is_string($k)){
				if(preg_match('/\|/', $k)){ // 多筆
					$tmps = explode('|',$k);
					$parent = $tmps[0];
					$one = $tmps[1];
					
					$data_return = '';

					// @gggg 單筆的資料
					foreach($v as $kk => $gggg){
						$vv = array();
						$run = '$html2_section = $html->'.$one.';';
						eval($run);
						$html2 = str_get_html($html2_section, true, true, DEFAULT_TARGET_CHARSET, false);

						// 測試動態產生欄位規則
						$tags_repeated = array();
						foreach($html2->find('*[dom=f]') as $vvv){

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
							eval($run);
						}

						$data_return .= $html2;
					}
					

					$run = '$html->'.$parent.' = \''.$data_return.'\';';
					eval($run);
				} else { // 其它指令
					$run = '$html->'.$k.' = \''.$v.'\';';
					eval($run);
				}
			// } else { // 單筆
			// 	foreach($v as $kk => $vv){
			// 		$run = '$html->'.$kk.' = \''.$vv.'\';';
			// 		eval($run);
			// 	}
			}
		}
	}
}

$aaa = $html->save();

// 輸出前，先把不該輸出的東西處理掉
$aaa = str_replace('dom="multi"', '', $aaa);
$aaa = str_replace('dom="1"', '', $aaa);
$aaa = str_replace('dom="f"', '', $aaa);
$aaa = str_replace('dom="multi 1"', '', $aaa);
echo $aaa;

if(isset($html)) unset($html);
if(isset($html2)) unset($html2);
if(isset($aaa)) unset($aaa);
?>

<?php
/*
 * 2017-08-08
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

	// @k 主規則
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

					foreach($v as $kk => $vv){

						$run = '$html2_section = $html->'.$one.';';
						eval($run);
						$html2 = str_get_html($html2_section, true, true, DEFAULT_TARGET_CHARSET, false);

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
			} else { // 單筆
				foreach($v as $kk => $vv){
					$run = '$html->'.$kk.' = \''.$vv.'\';';
					eval($run);
				}
			}
		}
	}
}

$aaa = $html->save();

// 輸出前，先把不該輸出的東西處理掉
// $aaa = str_replace('dom="multi"', '', $aaa);
// $aaa = str_replace('dom="1"', '', $aaa);
// $aaa = str_replace('dom="f"', '', $aaa);
// $aaa = str_replace('dom="multi 1"', '', $aaa);
echo $aaa;

if(isset($html)) unset($html);
if(isset($html2)) unset($html2);
if(isset($aaa)) unset($aaa);
?>

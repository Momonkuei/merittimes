<?php

// 2019-12-02 動靜態
unset($html_origin_innertext);

// 先看一下是不是單層單行模式
unset($html_list);
if(preg_match('/layer/', $layer_parent)){ // 固定規則專用
	$layer_single = false;
	unset($l_value);
	$run = '$l_value = $html->'.$layer_parent.'->l;';
	@eval($run); // gg
	if(!isset($l_value)){
		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			//continue;
		} else {
			return;
		}
	}
	if(preg_match('/list/', $l_value)){
		unset($html_list);
		$run = '$html_list = $html->'.$layer_parent.'->outertext;';
		@eval($run); // gg
		if(isset($html_list)){
			$layer_single = true;
		}
	}

	unset($layer_data_source);
	$run = '$layer_data_source = $html->'.$layer_parent.'->ls;';
	@eval($run); // gg
	if(!isset($layer_data_source)){
		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			//continue;
		} else {
			return;
		}
	}

	// 2018-03-13 ls屬性用不到了，順手刪掉
	$run = '$html->'.$layer_parent.'->removeAttribute("ls");';
	@eval($run);
}

$struct = array();

// list
if(preg_match('/layer/', $layer_parent)){ // 固定規則專用
	if($layer_single === false){
		// 李哥找到的問題，因為不是所有的地方都會需要有排除的規則 2017-12-04
		$run = '$html2_section = $html->'.$layer_parent.'->innertext;';
		eval($run);
		$html2 = str_get_html($html2_section, true, true, DEFAULT_TARGET_CHARSET, false);

		$run = '$html2_section = $html2->'.$layer_list.';';
		@eval($run);
		if(!$html2_section){
			if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
				//continue;
			} else {
				return;
			}
		}
		$html_list = str_get_html($html2_section, true, true, DEFAULT_TARGET_CHARSET, false);
		$struct[0] = $html_list->save();

		// 2019-12-02 動靜態
		$html_origin_innertext = str_replace($struct[0], '', $html2->save());
	} else {
		// 李哥找到的問題，因為不是所有的地方都會需要有排除的規則 2017-12-04
		$run = '$html2_section = $html->'.$layer_parent.'->outertext;';
		eval($run);
		$html2 = str_get_html($html2_section, true, true, DEFAULT_TARGET_CHARSET, false);

		$struct[0] = $html_list;
	}
} else {
	$struct[0] = $layer_struct_0;

	// 2018-05-24 list2的規則，李哥2018-05-24下午4點有看過這個東西
	if(trim($layer_struct_a) != '' and $struct[0] == ''){
		$run = '$html->'.$layer_parent;

		// 2018-04-30 試著檢查規則的正確性，以及存在性
		$can_run = true;
		$tmps = explode('->', $run);

		$checkx = 'if($can_run === true and is_object('.$tmps[0].')){} else {$can_run = false;}';
		eval($checkx);

		$test_rule = $tmps[0].'->'.$tmps[1];

		$checkx = 'if($can_run === true and is_object('.$test_rule.')){} else {$can_run = false;}';
		eval($checkx);

		for($x=2;$x<=6;$x++){ // 預設檢查6個箭頭
			if($can_run === true and isset($tmps[$x])){
				$test_rule .= '->'.$tmps[$x];
				$checkx = 'if($can_run === true and is_object('.$test_rule.')){} else {$can_run = false;}';
				eval($checkx);
			}
		}

		$layer_struct_a_tmps = explode("\n", $layer_struct_a);
		if($can_run === true){
			if($layer_single === false){
				$run = '$html_struct_a_object = $html->'.$layer_parent.'->'.$layer_struct_a_tmps[0].'->outertext;';
			} else {
				$run = '$html_struct_a_object = $html->'.$layer_parent.'->outertext;';
			}
			eval($run); // ss
			$html3 = str_get_html($html_struct_a_object, true, true, DEFAULT_TARGET_CHARSET, false);
			$html_struct_a = $html3->save();
		}

		// <li class="moreMenu"><a href="about.php?type=1"><span>關於我們</span></a>
		if($can_run === true and isset($html_struct_a) and $html_struct_a != ''){
			$html_tmps = $html_tmps_old = explode("\n", $html_struct_a);
			foreach($html_tmps as $k => $v){
				$tmp = $v;

				$tmp = str_replace('">','"_gg_xx_>',$tmp);
				$tmp = str_replace('><','>_gg_xx_<',$tmp);

				preg_match_all('/\ (\w+)="([a-zA-Z0-9 \?=\.\(\)]+)"/', $tmp, $matches);
				//var_dump($matches);
				foreach($matches[1] as $kk => $vv){
					if($vv != ''){
						$tmp2 = $vv.'="'.$matches[2][$kk].'"';
						$tmp = str_replace($tmp2,'_gg_xx_'.$tmp2,$tmp);
					}
				}

				preg_match_all('/<(\w+)>([^<^>]+)<\/\w+>/', $tmp, $matches);
				//var_dump($matches);
				foreach($matches[1] as $kk => $vv){
					if($vv != ''){
						$tmp2 = '<'.$vv.'>'.$matches[2][$kk].'</'.$vv.'>';
						$tmp3 = '<'.$vv.'>_gg_xx_'.$matches[2][$kk].'_gg_xx_</'.$vv.'>';
						$tmp = str_replace($tmp2,$tmp3,$tmp);
					}
				}

				$html_tmps[$k] = explode('_gg_xx_',trim($tmp));
			}
			//var_dump($html_tmps);

			foreach($layer_struct_a_tmps as $k => $v){
				if($k == 0){
					continue;
				}
				// 1-3|style|{/describe/}|replace
				$tmps2 = explode('|',$v);
				if(count($tmps2) < 3){
					continue;
				}
				$list2_line_position = $tmps2[0];
				$list2_value = $tmps2[1];
				$list2_fill = $tmps2[2]; // 填入方式

				if(preg_match('/^(\d+)~(\d+)$/', $list2_line_position, $matches)){ // 範圍，通常用在{/child/}
					if($matches[2] > $matches[1]){ // 簡單的防呆
						for($x=$matches[1];$x<=$matches[2];$x++){
							if($x == $matches[1]){
								$html_tmps_old[$x-1] = $list2_value;
								$html_tmps[$x-1] = array();
								$html_tmps[$x-1][] = $list2_value;
							} else {
								$html_tmps_old[$x-1] = '';
								$html_tmps[$x-1] = array();
							}
						}
					}
				} elseif(preg_match('/^(\d+)\-(\d+)$/', $list2_line_position, $matches)){ // 某一行的某個位置
					if(!isset($html_tmps[$matches[1]-1][$matches[2]-1])){
						continue;
					}
					// 1:左, 2:右，3:取代，4:插入在屬性值左，5:插入在屬性值右
					if($list2_fill == 1){ // 左
						$html_tmps[$matches[1]-1][$matches[2]-1] = $list2_value.$html_tmps[$matches[1]-1][$matches[2]-1];
					} elseif($list2_fill == 2){ // 右
						$html_tmps[$matches[1]-1][$matches[2]-1] = $html_tmps[$matches[1]-1][$matches[2]-1].$list2_value;
					} elseif($list2_fill == 3){ // 取代
						$html_tmps[$matches[1]-1][$matches[2]-1] = $list2_value;
					} elseif($list2_fill == 4){ // 插入在屬性值左
						// 有用到在寫
					} elseif($list2_fill == 5){ // 插入在屬性值右
						// 有用到在寫
					}
				}
			}

			foreach($html_tmps as $k => $v){
				if(count($v) == 0){
					unset($html_tmps[$k]);
					continue;
				}
				$html_tmps[$k] = implode(' ',$v);
			}

			$struct[0] = implode("\n",$html_tmps);
			//echo $struct[0];die;
		} // if
	}

}

// 預設沒有無限層
$struct[1] = '';
$struct[2] = '';

$ignore_top = '';
if(preg_match('/layer/', $layer_parent)){ // 固定規則專用
	if($layer_single === false){
		// Ignore Top
		// 這是用在HTML Table的th
		unset($ignore_top);
		$run = '$ignore_top = $html2->'.$layer_it.';';
		@eval($run); // gg
		if(!isset($ignore_top)){
			$ignore_top = '';
		}
		

		// box
		// <ul l="box">{split}</ul>
		$run = '$html2_section = $html2->'.$layer_box.';';
		@eval($run);
		if($html2_section){
			$html_box = str_get_html($html2_section, true, true, DEFAULT_TARGET_CHARSET, false);

			// 2019-12-02 動靜態
			if(isset($html_origin_innertext)){
				$html_origin_innertext = str_replace($html_box->save(), '', $html_origin_innertext);
			}

			$tmps = explode('{split}', $html_box->save());
			$struct[1] = $tmps[0];
			$struct[2] = $tmps[1];
		}
	}
} else {
	$struct[1] = $layer_struct_1;
	$struct[2] = $layer_struct_2;
}

// var_dump($struct);die;

// Params
// 例 AAA:1,BBB:3,CCC:5---a
$m_params = array();
if(preg_match('/layer/', $layer_parent)){ // 固定規則專用
	unset($layer_params);
	$run = '$layer_params = $html->'.$layer_parent.'->lp;';
	@eval($run); // gg
	if(!isset($layer_params)){
		$layer_params = '';
	}
}

include 'datasource.php';

$result = renderMenu_dom4_layer($content, $struct, $m_params);

$tmps = explode("\n", $result);

// 把最外層的box頭尾刪掉
unset($tmps[count($tmps)-1]);
unset($tmps[count($tmps)-1]);

unset($tmps[0]);
unset($tmps[1]);
$data_return = implode("\n", $tmps);

// 2019-12-02 動靜態
if(isset($single_content_is_null) and $single_content_is_null === true and isset($html_origin_innertext) and $html_origin_innertext != ''){
	$data_return = $html_origin_innertext;
}

// 2017-12-13 為starr所加的測試功能，後續在看看會不會有什麼問題
$data_return = str_replace('\'','"',$data_return);

// 2018-02-13 為starr所加的測試功能，後續在看看會不會有什麼問題
$data_return = str_replace('\"',"\'",$data_return);

// echo $data_return;die;

if($layer_single === false){
	$run = '$html->'.$layer_parent.'->innertext = \''.$ignore_top.$data_return.'\';';
} else {
	$run = '$html->'.$layer_parent.'->outertext = \''.$data_return.'\';';
}

// 2018-04-30 試著檢查規則的正確性，以及存在性
$can_run = true;
$tmps = explode('->', $run);
unset($tmps[count($tmps)-1]);

$checkx = 'if($can_run === true and is_object('.$tmps[0].')){} else {$can_run = false;}';
eval($checkx);

$test_rule = $tmps[0].'->'.$tmps[1];

$checkx = 'if($can_run === true and is_object('.$test_rule.')){} else {$can_run = false;}';
eval($checkx);

for($x=2;$x<=6;$x++){ // 預設檢查6個箭頭
	if($can_run === true and isset($tmps[$x])){
		$test_rule .= '->'.$tmps[$x];
		$checkx = 'if($can_run === true and is_object('.$test_rule.')){} else {$can_run = false;}';
		echo $checkx;
		eval($checkx);
	}
}

if($can_run === true){
	$dom5_runs[] = $run;
	eval($run); // ss
}

if($layer_single === true){ // 2018-03-07 凡使用outertext，而且裡面的值是有包含功能屬性(ex: l, ls, lp...)，都要重新使用str_get_html，不然後續刪除屬性會失敗
	// 2018-08-15 在oia的網站，如果上面有用單層單行，就會因為這行而有問題，在觀察看看
	// 如果後續還有用這行的需求，到時在用params的方式，來觸發這個動作
	//$html = str_get_html($html->save(), true, true, DEFAULT_TARGET_CHARSET, false);
}

// 其它參數
if($m_params and count($m_params) > 0){
	foreach($m_params as $k => $v){
		if($k == 'get' and preg_match('/^(.*)---(.*)$/', $v, $matches)){
			// 回到原本的GET參數
			if(isset($old_get[$matches[1]])){
				$_GET[$matches[1]] = $matches[2];
			} else {
				unset($_GET[$matches[1]]);
			}
		}
	}
}

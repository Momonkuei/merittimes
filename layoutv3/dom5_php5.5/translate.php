<?php

if(preg_match('/\*\[t\*\=/', $translate_parent)){
	unset($function_list_tmp);
	$run = '$function_list_tmp = $html->'.$translate_parent.'->t;';

	// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
	@eval($run); // gg
	if(!isset($function_list_tmp)){
		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			continue;
		} else {
			return;
		}
	}

	if(trim($function_list_tmp) == ''){
		$function_list = array();
	} else {
		$function_list = explode(' ', $function_list_tmp);
	}

	if(count($function_list) > 0){
		foreach($function_list as $k => $v){
			$v = trim($v);
			$v = strtolower($v);

			if($k == 0 and $v == '*'){
				$v = 'innertext';
			} elseif($k == 1 and $v == '*'){
				$v = 'tw';
			}

			if($k > 1 and !preg_match('/^(strtolower|strtoupper|ucfirst|trim)$/', $v)){
				unset($function_list[$k]);
				continue;
			}

			$function_list[$k] = $v;
		}
		if(!isset($function_list[1])){
			$function_list[] = 'tw';
		}
	} else {
		$function_list[] = 'innertext';
		$function_list[] = 'tw';
	}

	// 2017-11-08 winnie建議的功能
	if(preg_match('/|/', $function_list[0])){
		$tmps = explode('|', $function_list[0]);
		$function_list[0] = $tmps;
	} else {
		$function_list[0][] = $function_list[0];
	}
}

$tags_repeated = array();
$run = '$vvv = $html->'.$translate_parent.';';
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
		$tmpg[$attr] = array(
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
		$tmpg[$attr] = array(
			'attr' => $attr,
			'value' => $value,
		);
	}

} elseif(count($vvv->attr) == 1){ // 例如P, H*, SPAN等
	$attr = 'innertext';
	// $value = $vvv->plaintext;
	$value = $vvv->innertext;

	$tmpg[$attr] = array(
		'attr' => $attr,
		'value' => $value,
	);
} else { // 當使用靜態規則模式的時候，這裡的情況才會發生
	$attr = 'innertext';
	// $value = $vvv->plaintext;
	$value = $vvv->innertext;

	$tmpg[$attr] = array(
		'attr' => $attr,
		'value' => $value,
	);
}

foreach($function_list[0] as $k => $v){
	$value = $tmpg[$v]['value'];
	$value = t($value, $function_list[1]);

	// 擴增函式功能
	foreach($function_list as $kk => $vv){
		if($kk <= 1){
			continue;
		}
		$run = '$value = '.$vv.'($value);';
		eval($run);
	}

	// 2018-12-07
	// 因為不同的語言，可能會翻譯出來單引號，所以把它跳脫掉
	$value = str_replace("'","\'",$value);

	$run = '$html->'.$translate_parent.'->'.$v.' = \''.$value.'\';';
	$dom5_runs[] = $run;
	eval($run);
}

// $run = '$html->'.$translate_parent.'->removeAttribute("t");';
// eval($run);

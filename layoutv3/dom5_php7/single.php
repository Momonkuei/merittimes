<?php

if(preg_match('/\*\[d\*\=/', $single_parent)){
	unset($single_data_source);
	$run = '$single_data_source = $html->'.$single_parent.'->d;';

	// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
	@eval($run); // gg
	if(!isset($single_data_source)){
		if(isset($this) and isset($this->data['current_flattened']) and $this->data['current_flattened'] === true){
			//continue;
		} else {
			return;
		}
	}
}

$content = array();
$file_dir = ''; // 圖片的資料夾功能名稱

// 別名群組
$data['dom4_d_alias'] = array();
$data['dom4_d_alias']['pagetitle'] = array(
	"name" => $this->data["func_name"], "sub_name" => $this->data["func_en_name"]
);

if(preg_match('/^id\:(.*)$/', $single_data_source, $matches)){
	if(isset($data[$matches[1]])){
		$content = $data[$matches[1]];
	}
} elseif(preg_match('/^alias\./', $single_data_source, $matches)){
	$tmps = explode('.', $single_data_source);
	unset($tmps[0]);
	$tmp = '$content = $data["dom4_d_alias"]';
	if(count($tmps) > 0){
		foreach($tmps as $v){
			if($v != ''){
				$tmp .= '["'.$v.'"]';
			}
		}
		$tmp .= ';';
	}
	eval($tmp);
} elseif(preg_match('/^memory\./', $single_data_source, $matches)){
	$tmps = explode('.', $single_data_source);
	unset($tmps[0]);
	$tmp = '$content = $_SESSION';
	if(count($tmps) > 0){
		foreach($tmps as $v){
			if($v != ''){
				$tmp .= '["'.$v.'"]';
			}
		}
		$tmp .= ';';
	}
	eval($tmp);
} elseif(preg_match('/^table\.(.*)\.(.*)$/', $single_data_source, $matches)){
	$table = $matches[1];
	$data_id = $matches[2];
	// $content = $this->db->createCommand()->from($table)->where('id=:id',array(':id'=>$data_id))->queryRow();
	$content = $cidb->where('id', $data_id)->get($table)->row_array();

	if($table == 'html' and $content and isset($content['type'])){
		$file_dir = $content['type'];
	} else {
		$file_dir = $table;
	}
} else {
	if(isset($data[$single_data_source]) and count($data[$single_data_source]) > 0){
		$content = $data[$single_data_source];
	} elseif(!isset($data[$single_data_source]) and isset($this) and isset($this->data[$single_data_source])){ // lota建議
		$content = $this->data[$single_data_source];
	}
}

// 伏筆
if(isset($content['_file_dir']) and $content['_file_dir'] != ''){
	$file_dir = $content['_file_dir'];
}

// 真的沒有的情況下
if($file_dir == '' and isset($this) and isset($this->data['router_method'])){
	$file_dir = $this->data['router_method'];
	$file_dir = str_replace('detail', '', $file_dir);
	$file_dir = str_replace('show', '', $file_dir);
}

if(count($content) > 0){ // 這裡是欄位的迴圈哦
	foreach($content as $kkk => $vvv){
		if(preg_match('/^pic./', $kkk) and $vvv != ''){
			$vvv = '_i/assets/upload/'.$file_dir.'/'.$vvv;
		} elseif(preg_match('/^file/', $kkk) and $vvv != ''){
			$vvv = '_i/assets/file/'.$file_dir.'/'.$vvv;
		}
		$content[$kkk] = $vvv;
	}
}
// var_dump($content);die;
$gggg = $content;

if(preg_match('/\*\[d\*\=/', $single_parent)){
	unset($single_debug);
	$run = '$single_debug = $html->'.$single_parent.'->debug;';
	@eval($run); // gg
	if(isset($single_debug) and $single_debug != ''){
	?>
<meta charset="utf-8">
	<?php
		new dBug($content,'',true);
		die;
	}
} else {
	if($single_debug == true){
	?>
<meta charset="utf-8">
	<?php
		new dBug($content,'',true);
		die;
	}
}

$tags_repeated = array();

if(preg_match('/\*\[d\*\=/', $single_parent)){
	$run = '$vvv = $html->'.$single_parent.';';
	eval($run);
} else {
	$htmlg = str_get_html($single_struct, true, true, DEFAULT_TARGET_CHARSET, false);
	$run = '$vvv = $htmlg->find("'.$single_struct_tag.'",0);';
	eval($run);
}

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
} else { // 當使用靜態規則模式的時候，這裡的情況才會發生
	$attr = 'innertext';
	// $value = $vvv->plaintext;
	$value = $vvv->innertext;

	$tmpg[] = array(
		'attr' => $attr,
		'value' => $value,
	);
}

// var_dump($tmpg);die;

$vv = array(); // 規則集合，裡面會用到
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
		} else {
			$value = ''; // 試試看 2017-11-14
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

// var_dump($vv);die;

// @kkk 規則
foreach($vv as $kkk => $vvv){
	$tmps = explode('->', $kkk); // find("span",0)->{'innertext'} 只留後面的那個，這樣下條件也比較單純
	if(count($tmps) != 2){
		continue;
	}

	$has_rule = true;

	$run = '$html->'.$single_parent.'->'.$tmps[1].' = \''.$vvv.'\';';
	// echo $run;
	eval($run); // cc
}

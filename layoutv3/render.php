<?php

/*
<?php if(0):?><!-- head_start -->
<script type="text/javascript">
// head start
</script>
<?php endif?><!-- head_start -->

<?php if(0):?><!-- head_end -->
<script type="text/javascript">
// head end 
</script>
<?php endif?><!-- head_end -->

<?php if(0):?><!-- body_start -->
<script type="text/javascript">
// body start
</script>
<?php endif?><!-- body_start -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
// body end 
</script>
<?php endif?><!-- body_end -->
 */

$append = array();
$append['form_post'] = '';
$append['head_start'] = '';
$append['head_end'] = '';
$append['body_start'] = '';
$append['body_end'] = '';

$append_object['form_post'] = array();
$append_object['head_start'] = array();
$append_object['head_end'] = array();
$append_object['body_start'] = array();
$append_object['body_end'] = array();

$point = '';
foreach($layoutv3_pre_render_content as $k => $v){
	if(preg_match('/^\<\?php\ if\(0\)\:\?\>\<\!\-\-\ (form_post|head_start|head_end|body_start|body_end)\ \-\-\>$/', trim($v), $matches)){
		$point = $matches[1];
		unset($layoutv3_pre_render_content[$k]);
		continue;
	} elseif(preg_match('/^\<\?php\ endif\?\>\<\!\-\-\ (form_post|head_start|head_end|body_start|body_end)\ \-\-\>$/', trim($v), $matches)){
		$point = '';
		unset($layoutv3_pre_render_content[$k]);
		continue;
	}

	if($point != ''){
		$append[$point] .= $v."\n";
		unset($layoutv3_pre_render_content[$k]);
	}
}

// 因為模組的寫法，和Append的寫法不一樣，所以這裡切分開來寫 2017-06-27
$tag = '';
$module = '';
$tmp = '';
foreach($layoutv3_pre_render_content as $k => $v){
	if(preg_match('/^\<\?php\ if\(0\)\:\?\>\<\!\-\-\ (form_post|head_start|head_end|body_start|body_end)\:(.*)\ \-\-\>$/', trim($v), $matches)){
		$tag = $matches[1];
		$module = $matches[2];
		unset($layoutv3_pre_render_content[$k]);
		continue;
	} elseif(preg_match('/^\<\?php\ endif\?\>\<\!\-\-\ (form_post|head_start|head_end|body_start|body_end)\:(.*)\ \-\-\>$/', trim($v), $matches)){
		if(!isset($append_object[$matches[1]][$matches[2]])){
			$append_object[$matches[1]][$matches[2]] = $tmp;
		}
		$tag = '';
		$module = '';
		$tmp = '';
		unset($layoutv3_pre_render_content[$k]);
		continue;
	}
	if($tag != ''){
		$tmp .= $v."\n";
		unset($layoutv3_pre_render_content[$k]);
	}
}

// 為了解決footer的sitemap_type2(橫)換新行的問題而寫的新功能 2017-02-14
$other_function = array();
$point = '';
$check_tmp = array();
foreach($layoutv3_pre_render_content as $k => $v){
	if(preg_match('/^\<\!\-\-\ func\|start\|(.*)\ \-\-\>$/', trim($v), $matches)){
		$point = $matches[1];
		if(isset($check_tmp[$point])){
			$check_tmp[$point]++;
		} else {
			$check_tmp[$point] = 0;
		}
		//unset($layoutv3_pre_render_content[$k]);
		$layoutv3_pre_render_content[$k] = '<!-- func|result|'.$matches[1].'|'.$check_tmp[$point].' -->';
		continue;
	} elseif(preg_match('/^\<\!\-\-\ func\|end\|(.*)\ \-\-\>$/', trim($v), $matches)){
		$point = '';
		unset($layoutv3_pre_render_content[$k]);
		continue;
	}
	if($point != ''){
		if(!isset($other_function[$point])){
			$other_function[$point] = array();
		}
		if(!isset($other_function[$point][$check_tmp[$point]])){
			$other_function[$point][$check_tmp[$point]] = '';
		}
		$other_function[$point][$check_tmp[$point]] .= trim($v);
		unset($layoutv3_pre_render_content[$k]);
	}
}
//var_dump($other_function);die;

// DATA2資料流
// (V1不打算支援，除非靜態區塊加上<!-- // DATA_[MULTI或SINGLE] -->)第一個版本的混合資料流，可以針對不同的HTML情況，切換成不同資料流，請參考公司簡介和產品列表的部份
// (V1支援)第二版的混合資料流，程式端只能產出特定結構，但HTML可以自由切換第幾組單筆、或是第幾組的多筆，請參考購物或是結帳
foreach($layoutv3_pre_render_content as $k => $v){
	preg_match('/\<\!\-\-\ \/\/\ DATA2\:(SINGLE|MULTI)(\:\d+|)\ \-\-\>/', $v, $matches);
	if(isset($matches[0]) and $matches[0] != ''){
		$type = strtolower($matches[1]);
		$element = str_replace(':','',$matches[2]);
		if($element == ''){
			$layoutv3_pre_render_content[$k] = <<<XXX

<?php
if(!isset(\$data2_control)) \$data2_control = array();
if(!isset(\$data2_control[\$ID]['$type'])) \$data2_control[\$ID]['$type'] = -1;
if(isset(\$data2[\$ID]['$type'])){
	\$data2_control[\$ID]['$type']++;
	if(isset(\$data2[\$ID]['$type'][\$data2_control[\$ID]['$type']])){
		\$data[\$ID] = \$data2[\$ID]['$type'][\$data2_control[\$ID]['$type']];
	} else {
		\$data[\$ID] = array();
	}
}
?>

XXX;
		} else {
			$layoutv3_pre_render_content[$k] = <<<XXX

<?php
if(!isset(\$data2_control)) \$data2_control = array();
if(!isset(\$data2_control[\$ID]['$type'])) \$data2_control[\$ID]['$type'] = -1;
if(isset(\$data2[\$ID]['$type'][$element - 1])){
	\$data[\$ID] = \$data2[\$ID]['$type'][$element - 1];
} else {
	\$data[\$ID] = array();
}
?>

XXX;
		}
	}
}

foreach($layoutv3_pre_render_content as $k => $v){

	// 只要有這個字眼，就刪掉那一行，目前是一層tags，沒有內容，且在view寫入// XX的情況在使用的
	if(preg_match('/\/\/ killme/', $v, $matches)){
		unset($layoutv3_pre_render_content[$k]);
	}
}

$run = implode("\n", $layoutv3_pre_render_content);
// echo $run;die;
// var_dump($append_object);die;

if(!empty($append_object['form_post'])){
	$tmp2 = '';
	foreach($append_object['form_post'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['form_post'] = $tmp2;
} else {
	$append_object['form_post'] = '';
}

if(!empty($append_object['head_start'])){
	$tmp2 = '';
	foreach($append_object['head_start'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['head_start'] = $tmp2;
} else {
	$append_object['head_start'] = '';
}

if(!empty($append_object['head_end'])){
	$tmp2 = '';
	foreach($append_object['head_end'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['head_end'] = $tmp2;
} else {
	$append_object['head_end'] = '';
}

if(!empty($append_object['body_start'])){
	$tmp2 = '';
	foreach($append_object['body_start'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['body_start'] = $tmp2;
} else {
	$append_object['body_start'] = '';
}

if(!empty($append_object['body_end'])){
	$tmp2 = '';
	foreach($append_object['body_end'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['body_end'] = $tmp2;
} else {
	$append_object['body_end'] = '';
}

$run = str_replace('##form_post##', $append_object['form_post']."\n".$append['form_post'], $run);
$run = str_replace('##head_start##', $append_object['head_start']."\n".$append['head_start'], $run);
$run = str_replace('##head_end##', $append_object['head_end']."\n".$append['head_end'], $run);
$run = str_replace('##body_start##', $append_object['body_start']."\n".$append['body_start'], $run);
$run = str_replace('##body_end##', $append_object['body_end']."\n".$append['body_end'], $run);

// 2020-02-03
$run = str_replace('<form class="form_start">', '<'.'?'.'php include "view/system/form_start.php"'.'?'.'>', $run); // 2018-06-20 取代form開頭的標籤

if(isset($other_function) and !empty($other_function)){
	foreach($other_function as $k => $v){
		if($k == 'remove_new_line'){
			foreach($v as $kk => $vv){
				$other_function[$k][$kk] = trim(preg_replace('/\s\s+/', ' ', $vv));
			}
		}
	}
}

if(isset($other_function) and !empty($other_function)){
	foreach($other_function as $k => $v){
		foreach($v as $kk => $vv){
			$run = str_replace('<!-- func|result|'.$k.'|'.$kk.' -->', $vv, $run);
		}
	}
}

// 2019-02-01 程式化sitemap 善行數位
// 因為<xml之前，不能有任何空白或跳行
// if(preg_match('/^(sitemapxml|sitemap\.xml)$/', $this->data['router_method'])){
// }

// 2019-12-20 應該不限制sitemapxml，所有頁面都這樣子做
$tmps = explode("\n",$run);
if($tmps){
	foreach($tmps as $k => $v){
		if(trim($v) == ''){
			unset($tmps[$k]);
		}
	}
}
$run = implode("\n", $tmps);

// View Debug用的，記得是看原始碼
// 當發生eval某一行的問題，就可以打開這裡，把行號填進去
//$tmps = explode("\n",$run);
//echo $tmps[1073-1];die;
//var_dump($tmps);die;

// View Debug用的，不過以被下面的平面化程式碼所取代
// @mkdir(_BASEPATH.'/../'.LAYOUTV3_PATH.'_compile',0777,true);
// file_put_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'_compile/'.LAYOUTV3_IS_RUN_FIRST.'.php',$run);

/*
 * 平面化，有一些重點要注意
 * 1. source裡面程式碼，建議不要在include其它程式碼，不然平面化沒有意義
 * 2. 請搭配去註解和加密程式，這樣子做平面化的東西出來才會有意義，而且能夠提高深度
 * 3. 平面化會把LayoutV3核心函式和所有關連與結構拔掉
 * 4. 如果搭配Yii，檔案會被init兩次，所以函式要記得加上function_exists
 * 5. need_flattened的設定，放在config/environment.php和config/shop.php
 * 6. 根目錄的a.php要留著
 */
if(isset($this) and isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){

	// 為了支援parent結構程式裡面的客製程式碼
	$file = _BASEPATH.'/../parent/'.$this->data['router_method'].'.php';
	if(!file_exists($file)){
		$file = str_replace('/parent','', $file);
	}
	$tmp = file_get_contents($file);

	$tmps = explode("\n", $tmp);

	$tmps2 = array();
	$start = false;
	foreach($tmps as $k => $v){
		if(preg_match('/print_struct/', $v)){
			$start = true;
			$v = '';
		}
		if($start === true and !preg_match('/layoutv3\/render/', $v)){
			$tmps2[] = $v;
		}
	}

	$tmp = implode("\n", $tmps2);
	$CCCCCCCCCCCCCCCCCCCC .= '?'.'>'.'<'.'?'.'php '.$tmp;

	@mkdir(_BASEPATH.'/../'.LAYOUTV3_PATH.'_compile',0777,true);
	$run_tmp = file_get_contents(_BASEPATH.'/../layoutv3/'.LAYOUTV3_STRUCT_MODE.'_merge_layout.php');
	$run_tmp = str_replace('$AAAAAAAAAAAAAAAAAAAA=0;', $AAAAAAAAAAAAAAAAAAAA, $run_tmp);
	$run_tmp = str_replace('$BBBBBBBBBBBBBBBBBBBB=0;', $BBBBBBBBBBBBBBBBBBBB, $run_tmp);
	$run_tmp = str_replace('$CCCCCCCCCCCCCCCCCCCC=0;', $CCCCCCCCCCCCCCCCCCCC, $run_tmp);

	// 試著撰寫php include的偵測與改寫的程序
	// 這是第一層的檢查
	$run_tmps = explode("\n", $run_tmp);
	//file_put_contents('123.php',var_export($run_tmps,true));

	if($run_tmps and !empty($run_tmps)){
		foreach($run_tmps as $k => $v){
			$tmp = trim($v);
			if(preg_match('/^include\ (.*)\;$/', $tmp, $matches)){

				// 如果前面要忽略，那後面都要跟著忽略
				if(preg_match('/(ci\.php|\/config\/)/', $matches[1])){
					continue;
				}
				if(preg_match('/(pre_render_other|dom4)/', $matches[1])){
					$matches[1] = '"layoutv3/'.str_replace('"','',$matches[1]).'"';
				}
				eval('$run_tmps[$k] = \'?\'.\'>\'.file_get_contents('.$matches[1].');');
				continue;
			} elseif($tmp == 'require \'../a.php\';'){
				$run_tmps[$k] = '?'.'>'.file_get_contents('a.php');
				continue;
			} elseif($tmp == 'require \'a.php\';'){
				$run_tmps[$k] = '?'.'>'.file_get_contents('a.php');
				continue;
			}
		}
	}

	// 每檢查一次，就要重新合併和切割
	$run_tmp = implode("\n", $run_tmps);
	$run_tmps = explode("\n", $run_tmp);

	// 這是第二次的檢查
	if($run_tmps and !empty($run_tmps)){
		foreach($run_tmps as $k => $v){
			$tmp = trim($v);
			if(preg_match('/^include\ (.*)\;$/', $tmp, $matches)){
				$path_result = $matches[1];

				// 如果前面要忽略，那後面都要跟著忽略
				if(preg_match('/(ci\.php|\/config\/)/', $path_result)){
					continue;
				}
				//if(preg_match('/_BASEPATH\.\'\/\.\.\//', $path_result)){
				//	$path_result = str_replace('_BASEPATH.\'/../','',$path_result);
				//}
				if(preg_match('/standalone_simplehtmldom\./', $path_result)){
					// 因為Foo眼裡，放不了任何的class object
					continue;
				}
				if(preg_match('/dom5\//', $path_result)){
					// $path_result = str_replace('dom5/', 'layoutv3/dom5_merge_layout/', $path_result); //'"layoutv3/dom5/'.$matches[1].'"';
					$path_result = str_replace('dom5/', 'layoutv3/dom5/', $path_result); //'"layoutv3/dom5/'.$matches[1].'"';
				}
				eval('$run_tmps[$k] = \'?\'.\'>\'.file_get_contents('.$path_result.');');
				continue;
			} elseif(preg_match('/^include_once\((.*)\)\;$/', $tmp, $matches)){
				// 就是在處理這一行啦，它在a.php裡面 => include_once($yiipath.'/attack/spam.php');

				// vendors
				if(preg_match('/phpmailer/', $matches[1])){
					continue;
				}

				$tmp = $matches[1];
				$tmp = str_replace('$yiipath','yiipath',$tmp);
				eval('$run_tmps[$k] = \'?\'.\'>\'.file_get_contents('.$tmp.');');
			}
		}
	}

	// 每檢查一層，就要重新合併和切割
	$run_tmp = implode("\n", $run_tmps);
	$run_tmps = explode("\n", $run_tmp);

	// 這是第三次的檢查
	if($run_tmps and !empty($run_tmps)){
		foreach($run_tmps as $k => $v){
			$tmp = trim($v);
			if(preg_match('/^include\ (.*)\;$/', $tmp, $matches)){
				$path_result = $matches[1];

				// 如果前面要忽略，那後面都要跟著忽略
				if(preg_match('/(\$path|ci\.php|\/config\/)/', $path_result)){
					continue;
				}
				if(preg_match('/standalone_simplehtmldom\./', $path_result)){
					// 因為Foo眼裡，放不了任何的class object
					continue;
				}
				if(preg_match('/dom5\//', $path_result)){
					// $path_result = str_replace('dom5/', 'layoutv3/dom5_merge_layout/', $path_result); //'"layoutv3/dom5/'.$matches[1].'"';
					$path_result = str_replace('dom5/', 'layoutv3/dom5/', $path_result); //'"layoutv3/dom5/'.$matches[1].'"';
				}

				// if(preg_match('/_BASEPATH\.\'\/\.\.\//', $path_result)){
				// 	$path_result = str_replace('_BASEPATH.\'/../','',$path_result);
				// }
				eval('$run_tmps[$k] = \'?\'.\'>\'.file_get_contents('.$path_result.');');
				continue;
			}
		}
	}

	// 每檢查一層，就要重新合併和切割
	$run_tmp = implode("\n", $run_tmps);
	$run_tmps = explode("\n", $run_tmp);

	// 這是第三次的檢查
	if($run_tmps and !empty($run_tmps)){
		foreach($run_tmps as $k => $v){
			$tmp = trim($v);
			if(preg_match('/^include\ (.*)\;$/', $tmp, $matches)){
				$path_result = $matches[1];

				// 如果前面要忽略，那後面都要跟著忽略
				if(preg_match('/(\$path|ci\.php|\/config\/)/', $path_result)){
					continue;
				}
				if(preg_match('/standalone_simplehtmldom\./', $path_result)){
					// 因為Foo眼裡，放不了任何的class object
					continue;
				}
				if(preg_match('/dom5\//', $path_result)){
					// $path_result = str_replace('dom5/', 'layoutv3/dom5_merge_layout/', $path_result); //'"layoutv3/dom5/'.$matches[1].'"';
					$path_result = str_replace('dom5/', 'layoutv3/dom5/', $path_result); //'"layoutv3/dom5/'.$matches[1].'"';
				}

				// if(preg_match('/_BASEPATH\.\'\/\.\.\//', $path_result)){
				// 	$path_result = str_replace('_BASEPATH.\'/../','',$path_result);
				// }
				eval('$run_tmps[$k] = \'?\'.\'>\'.file_get_contents('.$path_result.');');
				continue;
			}
		}
	}

	$run_tmp = implode("\n", $run_tmps);
	//echo $run_tmp;die;

	// SEO版的平面化專用
	if(isset($this->data['mls']) and !empty($this->data['mls'])){
		foreach($this->data['mls'] as $k => $v){
			$file = _BASEPATH.'/../'.LAYOUTV3_PATH.'_compile/'.LAYOUTV3_IS_RUN_FIRST.'_'.$k.'.php';
			file_put_contents($file ,$run_tmp);
		}
	}

	// 非SEO版的平面化專用
	// $file = _BASEPATH.'/../'.LAYOUTV3_PATH.'_compile/'.LAYOUTV3_IS_RUN_FIRST.'.php';
	// file_put_contents($file ,$run_tmp);

}

/*
 * _CACHE3
 * 2017-12-18 下午2點40有跟李哥說，他說可以做cache機制
 *
 * 相關檔案如下：
 * parent/core.php
 * layoutv3/render.php
 * layoutv3/dom5.php
 */
if(0 and !preg_match('/(inquiry|contact)/', LAYOUTV3_IS_RUN_FIRST)){
	@mkdir(_BASEPATH.'/../'.LAYOUTV3_PATH.'_cache3',0777,true);
	$get = '';
	if(!empty($_GET)){
		foreach($_GET as $k => $v){
			if(!preg_match('/current_page/', $k)){
				$get .= $k.':'.$v.',';
			}
		}
	}
	$filename = LAYOUTV3_IS_RUN_FIRST.'-'.$this->data['ml_key'].'-'.md5(var_export($_GET, true)).'.html';

	// Debug
	// var_dump($get);echo $filename;

	ob_start();
		eval('?'.'>'.$run);
	$out = ob_get_contents();
	ob_end_clean();

	file_put_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'_cache3/'.$filename, $out);
	chmod(_BASEPATH.'/../'.LAYOUTV3_PATH.'_cache3/'.$filename, 0777);
}


/*
 * 只有使用LayoutV3輸出的情況下
 */
// eval('?'.'>'.$run);

/*
 * 2019-12-31
 * 李哥有看過這個cache4的東西
 */
if(0){
	@mkdir(_BASEPATH.'/../'.LAYOUTV3_PATH.'_cache4',0777,true);
	$filename = LAYOUTV3_IS_RUN_FIRST.'-'.$this->data['ml_key'].'.php';

	$cache4_content .= $run."\n";

	$cache4s = explode("\n", $cache4_content);
	foreach($cache4s as $k => $v){
		if(preg_match('/form_start/', $v)){
			$cache4s[$k] = file_get_contents(_BASEPATH.'/../view/system/form_start.php');
		}
	}
	$cache4_content = implode("\n", $cache4s);

	$cache4s = explode("\n", $cache4_content);
	foreach($cache4s as $k => $v){
		if(preg_match('/default_validate/', $v)){
			$cache4s[$k] = file_get_contents(_BASEPATH.'/../view/system/default_validate.php');
		}
	}
	$cache4_content = implode("\n", $cache4s);

	$run_tmp = file_get_contents(_BASEPATH.'/../layoutv3/cig_frontend_cache4_layout.php');
	$cache4_content = str_replace('$XXXXXXXXXXXXXXXXXXXX=0;', $cache4_content, $run_tmp);

	file_put_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'_cache4/'.$filename, $cache4_content);
	@chmod(_BASEPATH.'/../'.LAYOUTV3_PATH.'_cache4/'.$filename, 0777);
}

// 2020-02-03
$map = array(
	'<'.'?'.'php echo $AA?'.'>',
	'<'.'?'.'php echo $BB?'.'>',
	'<'.'?'.'php echo $CC?'.'>',
	'<'.'?'.'php echo $DD?'.'>',
	'<'.'?'.'php echo $EE?'.'>',
	'<'.'?'.'php echo $FF?'.'>',
	'<'.'?'.'php echo $GG?'.'>',
	'<'.'?'.'php echo $HH?'.'>',
	'<'.'?'.'php echo $II?'.'>',
	'<'.'?'.'php echo $JJ?'.'>',
	'<'.'?'.'php echo $KK?'.'>',
	'<'.'?'.'php echo $LL?'.'>',
	'<'.'?'.'php echo $MM?'.'>',
	'<'.'?'.'php echo $NN?'.'>',
	'<'.'?'.'php echo $OO?'.'>',
	'<'.'?'.'php echo $PP?'.'>',
	'<'.'?'.'php echo $QQ?'.'>',
	'<'.'?'.'php echo $RR?'.'>',
	'<'.'?'.'php echo $SS?'.'>',
	'<'.'?'.'php echo $TT?'.'>',
	'<'.'?'.'php echo $UU?'.'>',
	'<'.'?'.'php echo $VV?'.'>',
	'<'.'?'.'php echo $WW?'.'>',
	'<'.'?'.'php echo $XX?'.'>',
	'<'.'?'.'php echo $YY?'.'>',
	'<'.'?'.'php echo $ZZ?'.'>',
);
foreach($map as $k => $v){
	//$run = str_replace($v, '', $run);
}

// var_dump($_SESSION['layoutv3_struct_files']);

/*
 * V1第二版，或是獨立模式
 */
if(defined('IS_STANDALONE') and IS_STANDALONE === true){
} else {
	// include "dom4.php";
	include "dom5.php";

	// if(isset($_SESSION['auth_admin_id']) and preg_match('/\,(999995)\,/', ','.$_SESSION['auth_admin_type'].',') and isset($_layoutv3pagetype_id) and $_layoutv3pagetype_id > 0){
	// 	eval('?'.'>'.$run);
	// } else {
	// 	include "dom5.php";
	// }
}

/*
 * html開頭，在layoutv3/print_table.php的檔案上面，這裡是結尾
 */
if(isset($this->data['print_table']) and $this->data['print_table'] === true){
?>

</body>
</html>
<?php
}

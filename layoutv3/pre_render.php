<?php

// 2019-12-31
// $cache4_includes = array();
// $cache4_includes[] = _BASEPATH.'/../source/core.php';
// $cache4_includes[] = _BASEPATH.'/../layoutv3/libs.php';
$cache4_content = '';
$cache4_content .= '<'.'?'.'php include _BASEPATH.\'/../source/core.php\'?'.'>'."\n";
$cache4_content .= '<'.'?'.'php include _BASEPATH.\'/../layoutv3/libs.php\'?'.'>'."\n";

// 2018-05-11 IDEA
if(isset($_GET['__print_table__']) and $_GET['__print_table__'] == '1' and isset($_SESSION['auth_admin_id']) and $_SESSION['auth_admin_id'] != '' and preg_match('/^99999/', $_SESSION['auth_admin_id'])){
	//error_reporting(0);
	$this->data['print_table'] = true;
}

if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'source/page_sources.php')){
	include _BASEPATH.'/../'.LAYOUTV3_PATH.'source/page_sources.php';
}

if(isset($this) and isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
	$AAAAAAAAAAAAAAAAAAAA = '';
}

// 2020-08-17
unset($_SESSION['layoutv3_struct_files']);

include 'libs.php';

// 如果$page沒有設定，那就會去看資料庫裡面有沒有相對應的資料
// 2018-03-01 後台 / LayoutV3 / 頁面區塊
if(defined('LAYOUTV3_IS_RUN_FIRST')){
	include 'page_variable.php';
}

// 先找有沒有post的程式區段在裡面，有的話優先處理
if(isset($page_source) and !empty($page_source)){
	// 2017-12-20 檢查有沒有post的規則，有的話，就先載入共用程式碼
	$has_post = false;
	foreach($page_source as $k_gggggg => $v_gggggg){
		$tmp2_gggggg = explode('-', $v_gggggg);
		if(preg_match('/post/', $tmp2_gggggg[1])){
			$has_post = true;
			 break;
		}
	}
	
	// contact-post
	if($has_post === true){
		// include _BASEPATH.'/../'.LAYOUTV3_PATH.'source/core_post.php';
		include _BASEPATH.'/../'.LAYOUTV3_PATH.'source/core_seo.php';
		// $cache4_includes[] = _BASEPATH.'/../'.LAYOUTV3_PATH.'source/core_seo.php';
		$cache4_content .= '<'.'?'.'php include _BASEPATH.\'/../source/core_seo.php\'?'.'>'."\n";

if(isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
	// $AAAAAAAAAAAAAAAAAAAA .= '?'.'>'.file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'source/core_post.php')."\n";
	$AAAAAAAAAAAAAAAAAAAA .= '?'.'>'.file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'source/core_seo.php')."\n";
}
		foreach($page_source as $k_gggggg => $v_gggggg){
			$tmp2_gggggg = explode('-', $v_gggggg);
			if(preg_match('/post/', $tmp2_gggggg[1])){
				// 這裡是複製下面的，但是不太一樣哦
				$run = '$tmp_gggggg = '.var_export($page_sources[$tmp2_gggggg[0]][$tmp2_gggggg[1]], true).';';
				eval($run);
				// 這裡也有一個規則哦，就是必需"沒有"下規則的post程式，才會列在這裡執行哦
				// 而且這裡不去執行eval的元素哦，因為不合理，所以這裡不寫
				if(!isset($tmp_gggggg['file']) and isset($tmp_gggggg['source']) and $tmp_gggggg['source'] != ''){

					include _BASEPATH.'/../'.LAYOUTV3_PATH.'source/'.$tmp_gggggg['source'].'.php';
					// $cache4_includes[] = _BASEPATH.'/../'.LAYOUTV3_PATH.'source/'.$tmp_gggggg['source'].'.php';
					$cache4_content .= '<'.'?'.'php include _BASEPATH.\'/../source/'.$tmp_gggggg['source'].'.php\'?'.'>'."\n";

if(isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
	$AAAAAAAAAAAAAAAAAAAA .= '?'.'>'.file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'source/'.$tmp_gggggg['source'].'.php')."\n";
}

				}
			}
		}
	} // has_post
}

// hack 如果第一層是$群組，那就要外包一層view，不然會出現ksort(null)的問題
// 如果第一層是view，那就不用包
if(isset($page[0]['file']) and preg_match('/^\$/', $page[0]['file'])){
	$tmp = array(
		array(
			'file' => 'system/hole1',
			'hole' => $page,
		),
	);
	$page = $tmp;
}

// $tmps = explode("\n", var_export($page,true));

$page = layoutv3_group_recursive($page, $this->cidb);

// if(isset($_SESSION['auth_admin_id']) and preg_match('/\,(999995)\,/', ','.$_SESSION['auth_admin_type'].',') and isset($_layoutv3pagetype_id) and $_layoutv3pagetype_id > 0){
// 	$page[0]['hole']['0_0']['hole']['0_0']['file'] = 'system/layoutit';
// }

if(isset($this) and isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
	$AAAAAAAAAAAAAAAAAAAA .= '$page = '.var_export($page,true).";\n";
}
$cache4_content .= '<'.'?'.'php $page = '.var_export($page,true).'?'.'>'."\n";

/*
 * 整理陣列
 * 把那些群組和Layout都給刪掉
 */
$tmps = explode("\n", var_export($page,true));
$groups = array();
if($tmps and !empty($tmps)){
	foreach($tmps as $k => $v){
		if(preg_match('/\'\$(.*)\'/', $v, $matches)){
			$groups[] = $matches[1];
		}
	}
}
$group_tmp = array();
$group_result = array();
if($groups and !empty($groups)){
	foreach($groups as $k => $v){
		$tmp = layoutv3_struct_search($page, 'file', '$'.$v);
		$group_tmp[] = $tmp;
	}
}

/*
array(6) {
  [0]=>
  array(1) {
    [0]=>
    array(2) {
      ["file"]=>
      string(6) "$head1"
      ["position"]=>
      string(27) "-0-hole-0_0-hole-0_0-hole-0"
    }
  }
  [1]=>
  array(1) {
    [0]=>
    array(2) {
      ["file"]=>
      string(8) "$header2"
      ["position"]=>
      string(34) "-0-hole-0_0-hole-0_0-hole-1-hole-0"
    }
  }
 */
if($group_tmp and !empty($group_tmp)){
	foreach($group_tmp as $k => $v){
		foreach($v as $kk => $vv){
			$tmp = explode('-',$vv['position']);
			unset($tmp[0]);
			$node_string = '[\''.implode("']['",$tmp).'\']';
			$run = 'unset($page'.$node_string.');';
			eval($run);
		}
	}
}

// var_dump($page);die;

/*
 * 將結構轉成PHP和HTML混合的程式碼
 * 在這個階段後，就沒有群組和區塊了
 * 己經將分散的檔案(View)給組起來了
 */

//$run = layoutv3_section_recursive(0, $page, $group_result);
if(isset($this)){
	$run = layoutv3_section_recursive(0, $page, $this->data, $this->cidb);
} else {
	if(!isset($data_params)) $data_params = array();
	$run = layoutv3_section_recursive(0, $page, $data_params, $this->cidb);
}

if(isset($this) and isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
	$BBBBBBBBBBBBBBBBBBBB=$run;
}
//$cache4_content .= $run;

$layoutv3_pre_render_content = explode("\n",$run);

// 先把變數取出來，建立一個區塊編號順序的結構
// 資料可以依照這個結構來排列對應
// 這樣子就不用寫區塊編號了
$layoutv3_struct = array();

// 這個是要留給後面的程式碼所使用
// 可以用$ID來查檔名
$layoutv3_struct_map = array();

// 用檔名來查編號
$layoutv3_struct_map_keyname = array();

$layoutv3_struct_tmp = array(); // page_source功能在使用的
$layoutv3_data_single_multi = array();
$layoutv3_data_single_multi_detail = array();
foreach($layoutv3_pre_render_content as $k => $v){
	// < ? php $ID = '0' // header? >
	if(preg_match('/^\<\?php\ \$ID\ =\ \'(.*)\' \/\/\ (.*)\?/', $v, $matches)){

		$layoutv3_struct[] = $matches[1].'|'.$matches[2];

		// 這個是要給後面程式碼所使用，用編號查詢檔案名稱
		$layoutv3_struct_map[$matches[1]] = $matches[2];

		// 這個要給後面的程式所使用，用檔名來查編號
		if(!isset($layoutv3_struct_map_keyname[$matches[2]])){
		   	$layoutv3_struct_map[$matches[2]] = array();
		}
		$layoutv3_struct_map_keyname[$matches[2]][] = $matches[1];

		// 因為一個頁面載入不止一個的同區塊機率是有的，這樣子才合理
		if(!isset($layoutv3_struct_tmp[$matches[2]])){
			$layoutv3_struct_tmp[$matches[2]] = array();
		}
		$layoutv3_struct_tmp[$matches[2]][] = $matches[1];
	}
	if(preg_match('/^\<\?php\ \/\/\ (.*)\|(DATA_SINGLE|DATA_MULTI)\|(.*)\?/', $v, $matches)){
		if($matches[3] == 'true'){
			$layoutv3_data_single_multi[$matches[1]][$matches[2]] = true;
		}
	}
	if(preg_match('/^\<\?php\ \/\/\ (.*)\|DATA_SINGLE_MULTI\|(.*)\?/', $v, $matches)){
		$layoutv3_data_single_multi_detail[$matches[1]] = explode('|',$matches[2]);

		// 應該是bug所以才補上去 2016-12-27 jerry
		foreach(explode('|',$matches[2]) as $kk => $vv){
			$layoutv3_data_single_multi[$matches[1]][$vv] = true;
		}
	}
}

// 載入暫存程式碼，必需要寫入_compile，這個功能是Beta，而且產品列表有bug
// if(file_exists(_BASEPATH.'/../_compile/'.LAYOUTV3_IS_RUN_FIRST.'.php')){
// 	$ID = 0;
// 	include _BASEPATH.'/../_compile/'.LAYOUTV3_IS_RUN_FIRST.'.php';
// 	die;
// }

/* 挑選所需要的資料，有內容才會跑這個半自動批配
 * $page_source = array(
 *		'webmenu-v1',
 *		'company-page_title',
 *		'company-breadcrumb',
 *		'company-general',
 * );
 */
$page_source_result = array();
if(isset($page_source) and !empty($page_source) and isset($page_sources) and !empty($page_sources)){
	// 先轉成這個比較好寫
	// $page_source[] = $page_sources['webmenu']['v1'];
	$tmp = array();
	foreach($page_source as $k => $v){
		$tmp2 = explode('-', $v);
		$run = '$tmp[\''.$tmp2[0].'\'][\''.$tmp2[1].'\'] = '.var_export($page_sources[$tmp2[0]][$tmp2[1]], true).';';

		// debug
		// file_put_contents('ggg.txt',$run);

		eval($run);
	}
	$page_source = $tmp;

	// 這裡只做一件事，就是處理規則，也就是file的部份
	// @k 功能集合
	foreach($page_source as $k => $v){
		// @kk 功能名稱
		// @vv 功能規則和屬性群
		foreach($v as $kk => $vv){
			//var_dump($vv);
			// @vvv file(rule)
			$files = array();
			// 因為post的關係，所以才有可能不會有file的規則
			if(isset($vv['file']) and !empty($vv['file'])){
				foreach($vv['file'] as $kkk => $vvv){
					$tmp3 = $vvv;
					if(preg_match('/(\*|\/)/', $vvv)){
						// 一個以上的星號或是斜線都會被取代
						$tmp3 = str_replace('/', '\/', $tmp3);
						$tmp3 = str_replace('*', '(.*)', $tmp3);
					}
					$files[] = $tmp3;
				}
				// @kkk footer/logo_footer
				// @vvv array('0-1-4-1-0', ... )
				foreach($layoutv3_struct_tmp as $kkk => $vvv){
					// @vvvv file(rule)
					foreach($files as $kkkk => $vvvv){
						if(preg_match('/'.$vvvv.'/', $kkk, $matches)){
							$tmp3 = $vv;
							unset($tmp3['file']); // 這樣我以後才不會搞混
							foreach($vvv as $kkkkk => $vvvvv){
								$page_source_result[$vvvvv] = $tmp3;
							}
						}
					}
				}
			}
		}
	}
	// var_dump($page_source_result);

	// 這個是next_id在使用的
	// 因為會先跑一次，等一下還會在跑一次
	$ID = 0;
	$DATA_SINGLE = false;
	$DATA_MULTI = false;

	if(isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
		$CCCCCCCCCCCCCCCCCCCC='';
		$CCCCCCCCCCCCCCCCCCCC.='$layoutv3_struct = '.var_export($layoutv3_struct,true).";\n";
		$CCCCCCCCCCCCCCCCCCCC.='$layoutv3_struct_map = '.var_export($layoutv3_struct_map,true).";\n";
		$CCCCCCCCCCCCCCCCCCCC.='$layoutv3_struct_map_keyname = '.var_export($layoutv3_struct_map_keyname,true).";\n";
		$CCCCCCCCCCCCCCCCCCCC.='$layoutv3_struct_tmp = '.var_export($layoutv3_struct_tmp,true).";\n";
		$CCCCCCCCCCCCCCCCCCCC.='$layoutv3_data_single_multi = '.var_export($layoutv3_data_single_multi,true).";\n";
		$CCCCCCCCCCCCCCCCCCCC.='$layoutv3_data_single_multi_detail = '.var_export($layoutv3_data_single_multi_detail,true).";\n";
		$CCCCCCCCCCCCCCCCCCCC.='$ID=0;$data_single=false;$data_multi=false;'."\n";
	}

	$cache4_content .= '<'.'?'.'php'."\n";
	$cache4_content .= '$layoutv3_struct = '.var_export($layoutv3_struct,true).";\n";
	$cache4_content .= '$layoutv3_struct_map = '.var_export($layoutv3_struct_map,true).";\n";
	$cache4_content .= '$layoutv3_struct_map_keyname = '.var_export($layoutv3_struct_map_keyname,true).";\n";
	$cache4_content .= '$layoutv3_struct_tmp = '.var_export($layoutv3_struct_tmp,true).";\n";
	$cache4_content .= '$layoutv3_data_single_multi = '.var_export($layoutv3_data_single_multi,true).";\n";
	$cache4_content .= '$layoutv3_data_single_multi_detail = '.var_export($layoutv3_data_single_multi_detail,true).";\n";
	$cache4_content .= '$ID=0;$data_single=false;$data_multi=false;'."\n";
	$cache4_content .= '?'.'>'."\n";

	/*
	 * array(17) {
	 *   [0]=>
	 *   string(7) "0|index"
	 *   [1]=>
	 *   string(8) "0-0|head"
	 *   [2]=>
	 *   string(10) "0-1|-group"
	 * }
	 */
	/*
	 * 在$k和$v後面，要加上_gggggg的關系，就是因為，如果程式碼裡面，也有用到$k之類的，就會遇到下面那一行程式碼的問題
	 * "if(count($layoutv3_struct) == ($k+1)){"
	 * 所以要跳脫掉 2017-05-02
	 */
	foreach($layoutv3_struct as $k_gggggg => $v_gggggg){
		$tmp_gggggg = explode('|', $v_gggggg);
		if(isset($page_source_result[$tmp_gggggg[0]])){
			$tmp2_gggggg = $page_source_result[$tmp_gggggg[0]];
			if(isset($tmp2_gggggg['condition']) and !empty($tmp2_gggggg['condition'])){
				foreach($tmp2_gggggg['condition'] as $kk_gggggg => $vv_gggggg){
					if($vv_gggggg == 'single'){
						if($DATA_SINGLE == true and $DATA_MULTI == false){
							include 'pre_render_other.php';
						}

					} elseif($vv_gggggg == 'multi'){
						if($DATA_SINGLE == false and $DATA_MULTI == true){
							include 'pre_render_other.php';
						}

					// 這裡不是你說要就要哦，必需區塊裡面要有定義結構，就是註解的那個啦
					} elseif(preg_match('/\|/', $vv_gggggg) and isset($DATA_SINGLE_MULTI) and !empty($DATA_SINGLE_MULTI)){ // single|multi|single
						$tmp3_gggggg = explode('|', $vv_gggggg);
						// 參考用 if(count($DATA_SINGLE_MULTI) == 2 and $DATA_SINGLE_MULTI[0] == 'DATA_SINGLE' and $DATA_SINGLE_MULTI[1] == 'DATA_MULTI'){
						$run = 'if(count($DATA_SINGLE_MULTI) == '.count($tmp3_gggggg).' and ';
						// @vvv single或是multi
						$runs = array();
						foreach($tmp3_gggggg as $kkk_gggggg => $vvv_gggggg){
							$runs[] = ' $DATA_SINGLE_MULTI['.$kkk_gggggg.'] == \'DATA_'.strtoupper($vvv_gggggg).'\' ';
						}
						$run .= implode(' and ', $runs);
						$run .= '){'."\n";
						$run .= 'include "pre_render_other.php";'."\n";
						$run .= '}'."\n";
						eval($run);

						if(isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
							$CCCCCCCCCCCCCCCCCCCC.=$run."\n";
						}
					}
				}

			// 沒有下條件的情況
			} else {
				include 'pre_render_other.php';
				//$cache4_includes[] = 'pre_render_other.php';
				//$cache4_content .= '<'.'?'.'php include _BASEPATH.\'/../layoutv3/pre_render_other.php\'?'.'>'."\n";
			}
		}

		if(count($layoutv3_struct) == ($k_gggggg+1)){
			// 最後一筆不輸出囉，因為也沒什麼意義
		} else {

			include _BASEPATH.'/../layoutv3/next_data_id.php';
			// $cache4_includes[] = _BASEPATH.'/../layoutv3/next_data_id.php';
			$cache4_content .= '<'.'?'.'php include _BASEPATH.\'/../layoutv3/next_data_id.php\'?'.'>'."\n";

			if(isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
				$CCCCCCCCCCCCCCCCCCCC.='?'.'>'.file_get_contents(_BASEPATH.'/../layoutv3/next_data_id.php')."\n";
			}

		}
	} // foreach

} // page_source

// 這個是next_id在使用的，重新刷新，因為pre_render之後，可能程式設計師會用它來放資料流
$ID = 0;
$DATA_SINGLE = false;
$DATA_MULTI = false;
// $DATA_SINGLE_MULTI_{ID} = array();

$cache4_content .= '<'.'?'.'php $ID=0;$data_single=false;$data_multi=false?'.'>'."\n";

if(isset($this) and isset($this->data['need_flattened']) and $this->data['need_flattened'] === true){
	$CCCCCCCCCCCCCCCCCCCC.='$ID=0;$data_single=false;$data_multi=false;'."\n";
}

// 接下來可能會放page_source的運作程式

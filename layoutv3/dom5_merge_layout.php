<?php

/*
 * 2017-11-23 以下四種模式，李哥都有看過
 *
 * V3模式的使用方式：
 *
 *	  V3啟動後，就有預載DOM第二版了，所以不用另外做任何事情
 *
 * V2架構的使用方式：
 *
 *    複製dom4.php、standalone_simplehtmldom.php、translate.php到v2架構的根目錄
 *
 *    修改translate.php，把最上面的layoutv3那邊註解，換成@session_start();
 *
 *    複製_i/php-google-translate-free/
 *
 *    _i/web/views/layoutv2/main.php的檔案上下，要掛上以下的內容，就可以使用了
 *
 *    <?php ob_start()?>
 *    XXX
 *    <?php
 *    $out = ob_get_contents();
 *    ob_end_clean();
 *    unset($run);
 *    include 'dom4.php';
 *    ?>
 *
 * 獨立模式的使用方式：(啟動後，請用網頁連faq.html)
 *
 *	  layoutv3/init.php切換成獨立模式
 *	  .htaccess把獨立模式的註解打開
 *	  
 *	  就可以脫離MVC架構，並且抓取html資料表裡面靜態頁呈現
 *	  但還是在LayoutV3的架構底下，而且裡面可以下DOM第二版的規則
 *	  
 *	  通常會用在全客製網站切版環境、或是單純的靜態頁套DOM第二版的規則
 *	  也可以看根目錄的standalone.php裡面的註解
 *	  
 * 舊架構的使用方式：(但是因為資料表的欄位命名問題，所以請使用$data[XXX]變數)
 *
 *	  ob_start();
 *	  XXX
 *	  $out = ob_get_contents();
 *	  ob_end_clean();
 *	  unset($run);
 *	  include 'dom5.php';
 *
 * 單獨程式的使用的方式(使用新架構資料表)：(請用網頁連layoutv3/dom4_test.php)
 *
 *	  ob_start();
 *	  XXX
 *	  $run = ob_get_contents();
 *	  ob_end_clean();
 *	  
 *	  // 初始化
 *	  @session_start();
 *	  $simplehtml = ''; // 假裝init
 *	  $old_struct = true;
 *	  $_SESSION['web_ml_key'] = 'tw';
 *    define('FRONTEND_DOMAIN','');
 *    $goback_root_path = ''; // 如果不是放根目錄，那就要提供，哪一個地方底下，的上幾層是根目錄
 *	  
 *    // 純參考而以，有需要用才打開
 *	  // $Db_Server = 'localhost';
 *	  // $Db_User = 'ordertrading_use';
 *	  // $Db_Pwd = '';
 *	  // $Db_Name = 'rwd_v3'; 
 *	  
 *	  include '../standalone_simplehtmldom.php';
 *	  include 'dom5.php';
 *
 */

// false: 新架構
// true: 舊架構
if(!isset($old_struct)){
	$old_struct = false;
}

// 如果是用在其它的架構，應該不需要做這個動作
if(isset($run)){
	ob_start();
		eval('?'.'>'.$run);
	$out = ob_get_contents();
	ob_end_clean();
} else {
	$simplehtml = ''; // 假裝init
	
	if(file_exists('standalone_simplehtmldom.php')){
		include 'standalone_simplehtmldom.php';
	} elseif(file_exists('../standalone_simplehtmldom.php')){
		include '../standalone_simplehtmldom.php';
	} elseif(file_exists('../../standalone_simplehtmldom.php')){
		include '../../standalone_simplehtmldom.php';
	}
	$old_struct = true;
}

// 為了避免其它架構，使用錯誤而導致的問題產生
if(!isset($out)){
	$out = '';
}

// if(!isset($this) and !isset($this->cidb)){
if(isset($this) and isset($this->cidb)){
} else {
	// 因為平面化的關係，所以這裡的ci.php程式碼刪掉
} // !isset($this) and  !isset($this->cidb)

// 因為平面化的關係，所以這裡的dBug class程式碼刪掉

// 這個函式，是從source/menu/v2.php複製過來的，最初的版本，在mbpanel2.php裡面
// 跟LayoutV3放在一起的時候，不是跑這一支，而是跑source/menu/v2.php裡面的那支，要記得…
// 缺這個函式，是李哥發現的 2017-12-04
if(!function_exists('check_field_and_rebuild_array_by_multi_layer_menu')){
	function check_field_and_rebuild_array_by_multi_layer_menu($items,$seo) {

		$render = '';

		if($items and count($items) > 0){
		foreach ($items as $k => $item) {
			$render .= $k.'=>array('."\n";

			if(!isset($item['url'])){
				if(isset($item['__link']) and $item['__link'] != ''){ // 獨立資料表專用
					$item['url'] = $item['__link'];
				} elseif(isset($item['url1']) and $item['url1'] != ''){
					$item['url'] = $item['url1'];
				} else {
					$item['url'] = '';
				}
			}

			//如果網址是有效連結，則判斷是否需要做SEO化 by lota
			if($item['url'] != 'javascript:;' and isset($seo[$item['id']]) and $seo[$item['id']]['seo_script_name'] != ''){
				$item['url'] = $seo[$item['id']]['seo_script_name'].'.html';
			}

			if (!empty($item['child'])) {
				if(isset($item['child'][0]['__link']) and preg_match('/detail/', $item['child'][0]['__link'])){
				} elseif(isset($item['child'][0]['url1']) and preg_match('/detail/', $item['child'][0]['url1'])){
				} elseif(isset($item['child'][0]['url']) and preg_match('/detail/', $item['child'][0]['url'])){
					// 2017-12-13 為了在分類底下，加上分項
				} else {
					$item['url'] = 'javascript:;';
				}
				$render .= '\'child\'=>array('."\n";
				$render .= check_field_and_rebuild_array_by_multi_layer_menu($item['child'],$seo);
				$render .= '),'."\n"; // child
			}

			if(!isset($item['child'])){
				$item['child'] = array();
			}

			// 把屬性都處理好了，在顯示在頁面上
			// LI的屬性，輸出前準備
			$attr1 = '';
			$classes = array();
			if(isset($item['child']) and count($item['child']) > 0 and isset($item['depth'])){
				// 這裡要判斷層次
				if($item['depth'] == 1 and isset($item['has_child']) and $item['has_child'] === true){ 
					$classes[] = 'moreMenu';
				} elseif($item['depth'] == 2){ 
					$classes[] = 'moreMenu';
				}
			}
			if(isset($item['class']) and $item['class'] != ''){
				$classes[] = $item['class'];
			}
			if(count($classes) > 0){
				$attr1 .= ' class="'.implode(' ', $classes).'" ';
			}
			if(isset($item['id'])){
				$attr1 .= ' id="navlight_webmenu_'.$item['id'].'" ';
			}
			$item['attr1'] = $attr1;

			// 把屬性都處理好了，在顯示在頁面上
			// Anchor的屬性，輸出前準備
			$attr2 = '';
			if(isset($item['target']) and $item['target'] != ''){
				$attr2 .= ' target="'.$item['target'].'" ';
			}
			if(isset($item['anchor_class']) and $item['anchor_class'] != ''){
				$attr2 .= ' class="'.$item['anchor_class'].'" ';
			}
			if(isset($item['anchor_data_target']) and $item['anchor_data_target'] != ''){
				$attr2 .= ' data-target="'.$item['anchor_data_target'].'" ';
			}
			if(isset($item['url'])){
				$attr2 .= ' href="'.$item['url'].'" ';
			}
			$item['attr2'] = $attr2;

			foreach($item as $kk => $vv){
				if(!is_array($vv)){
					$render .= '\''.$kk.'\'=>\''.$vv.'\','."\n";
				}
			}
			
			$render .= '),'."\n";
		}
		} // count

		return $render."\n";
	}
}

/*
 * 放在其它架構的初始化
 */
$cidb = null;

if(!isset($goback_root_path)){
	$goback_root_path = '';
}

// demoshopX, s11
if(isset($DB) and file_exists($goback_root_path.'include/MysqlConn.php')){
	$config_tmps = explode("\n", file_get_contents($goback_root_path.'include/MysqlConn.php'));

	// 把< ? php 和結尾 ? > 都拿掉
	unset($config_tmps[count($config_tmps)-1]);
	unset($config_tmps[0]);

	// 把MeekroDB相關的都拿掉
	foreach($config_tmps as $k => $v){
		if(preg_match('/^\$DB/', $v)){
			unset($config_tmps[$k]);
		}
	}

	eval(implode("\n", $config_tmps));

	$tmps = array(
		'dbdriver' => 'mysql',
		'username' => $Db_User,
		'password' => $Db_Pwd,
		'hostname' => $Db_Server,
		'port' => 3306,
		'database' => $Db_Name,
		'db_debug' => true,
	);
	$cidb = ggg_load_database($tmps, true);
}

if(isset($this) and isset($this->cidb) and !isset($cidb)){
	$cidb = $this->cidb;
}

if($cidb === null and isset($Db_Server) and isset($Db_User)){
	$tmps = array(
		'dbdriver' => 'mysql',
		'username' => $Db_User,
		'password' => $Db_Pwd,
		'hostname' => $Db_Server,
		'port' => 3306,
		'database' => $Db_Name,
		'db_debug' => true,
	);

	$cidb = ggg_load_database($tmps, true);
}

if($cidb === null and file_exists($goback_root_path.'_i/config/db.php')){
	$aaa = file_get_contents($goback_root_path.'_i/config/db.php');
	$aaa = str_replace('aaa_','gggaaa_',$aaa);
	eval('?'.'>'.$aaa);

	$Db_Server = gggaaa_dbhost;
	$Db_User = gggaaa_dbuser;
	$Db_Pwd = gggaaa_dbpass;
	$Db_Name = gggaaa_dbname; 
	
	$tmps = array(
		'dbdriver' => 'mysql',
		'username' => $Db_User,
		'password' => $Db_Pwd,
		'hostname' => $Db_Server,
		'port' => 3306,
		'database' => $Db_Name,
		'db_debug' => true,
	);

	$cidb = ggg_load_database($tmps, true);
}

// 不是舊架構，也不是新架構，是單獨的程式，使用新架構的資料表的情況
if($cidb === null and isset($Db_Server)){
	$tmps = array(
		'dbdriver' => 'mysql',
		'username' => $Db_User,
		'password' => $Db_Pwd,
		'hostname' => $Db_Server,
		'port' => 3306,
		'database' => $Db_Name,
		'db_debug' => true,
	);

	$cidb = ggg_load_database($tmps, true);
}

$current_lang = '';
if(isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
	$current_lang = $_SESSION['web_ml_key'];
} else {
	$current_lang = $_SESSION["lang"];
}

// top_link_menu 
unset($ID);

if(!function_exists('renderMenu_dom4_layer')){
	function renderMenu_dom4_layer($items, $struct, $params = array()) {
		// $render = '<ul>'."\n";
		$render = "\n".$struct[1]."\n";

		$count = 0;
		foreach ($items as $item) {
			$count ++;

			// $render .= '<li '.$item['attr1'].' ><a '.$item['attr2'].' ><span>' . $item['name'].'</span></a>'."\n";
			// if (!empty($item['child'])) {
			// 	if(isset($item['has_child']) and $item['has_child'] == false){
			// 		continue;
			// 	}
			// 	$render .= renderMenu_dom4_layer($item['child'], $struct);
			// }
			// $render .= '</li>'."\n";

			if(isset($params['depth']) and isset($item['depth']) and $params['depth'] < $item['depth']){
				continue;
			}

			if(isset($params['limit']) and $params['limit'] != '' and isset($item['depth']) ){
				$tmps = explode('---', $params['limit']);
				$depth = $tmps[0];
				$limit = $tmps[1];

				if($item['depth'] == $depth and $count > $limit){
					continue;
				}
			}

			$child = '';
			if (!empty($item['child'])) {
				if(isset($item['has_child']) and $item['has_child'] == false){
					// do nothing
				} else {
					// 興承建議 2017-12-28
					if(isset($params['child_class']) and preg_match('/^(.*)---(.*)$/', $params['child_class'], $matches)){
						if(isset($params['depth']) and isset($item['depth']) and ($params['depth']-1) < $item['depth']){ // 2018-01-31 增加相依性 Starr
							// do nothing
						} else {
							$item[$matches[1]] = $matches[2];
						}
					}
					$child = renderMenu_dom4_layer($item['child'], $struct, $params);
				}
			}

			$tmp = $struct[0]."\n";

			// 找看看有沒有只顯示在某一層的規則在裡面 2017-12-28
			for($x=1;$x<=3;$x++){
				$html = str_get_html($tmp, true, true, DEFAULT_TARGET_CHARSET, false);
				unset($show);
				$run = '$show = $html->find("*[l*=show-]",0)->l;';
				@eval($run); // gg
				$show_on_layers = array();
				if(isset($show) and preg_match('/^show-(.*)$/', $show, $matches)){
					$show_on_layers = explode(',', $matches[1]);
					if(!in_array($item['depth'], $show_on_layers)){
						$run = '$html->find("*[l*=show-]",0)->outertext="";';
						@eval($run); // gg
						$run = '$tmp = $html->save();';
						@eval($run); // gg
					}
				}
			}

			if(isset($item['attr1'])){
				$tmp = str_replace('attr1=""', $item['attr1'], $tmp);
			}
			if(isset($item['attr2'])){
				$tmp = str_replace('attr2=""', $item['attr2'], $tmp);
			}

			if(preg_match('/\{\/.*\/\}/i', $tmp)){

				// http://php.net/manual/en/function.preg-match-all.php#101259
				preg_match_all('/{\/[^}]*\/}/i', $tmp, $matches);

				if(isset($matches[0]) and count($matches[0]) > 0){
					// @vvvvv string {/otherx/}
					foreach($matches[0] as $vvvvv){
						$element = str_replace('{/', '', str_replace('/}', '', $vvvvv));
						$value = '';
						if($element == 'child'){
							$value = $child;
						} else {
							if(isset($item[$element])){
								$value = $item[$element];
							}
						}
						$tmp = str_replace($vvvvv, $value, $tmp);

					}
				}
			}

			$render .= $tmp."\n";
		}

		// return $render . '</ul>'."\n";
		return $render . $struct[2]."\n";
	}
}

/*
 * 通用版 新版多國語系
 */
if(!function_exists('t')){
	function t($text = '', $source = 'zh-TW', $target = '')
	{
		$map = array(
			'tw' => 'zh-TW',
			'cn' => 'zh-CN',
			'jp' => 'ja',
		);

		// 這個一定有值
		if(isset($map[$source])){
			$source = $map[$source];
		}

		$current_lang = '';
		if(isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
			$current_lang = $_SESSION['web_ml_key'];
		} else {
			$current_lang = $_SESSION["lang"];
		}

		// 我打算給它預設值為當前語系
		if($target == ''){
			if(!isset($map[$current_lang])){
				$target = $current_lang;
			} else {
				$target = $map[$current_lang];
			}
		}

		if($source == $target){
			return $text;
		} else {
			$url = FRONTEND_DOMAIN;
			if(defined('FRONTEND_FOLDER')){
				$url .= FRONTEND_FOLDER;
			}
			$url .= '/translate.php';
			$post = array(
				'text' => $text,
				'source' => $source,
				'target' => $target,
			);

			$postdata = http_build_query($post);
			$ch = curl_init();
			$options = array(
				CURLOPT_URL => $url,
				CURLOPT_HEADER => 0,
				CURLOPT_VERBOSE => 0,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postdata,
			);
			curl_setopt_array($ch, $options);
			$code = curl_exec($ch); 
			curl_close($ch);

			return $code;
		}
	}
}

// 試著撰寫自動翻譯的tag功能
// 這個很類似V1(Dom)
// 2017-11-07 李哥下班前說，允許這個功能開發
// 2017-11-14 V1的第二個版本，早上有跟李哥說明這件事，他允許這個功能開發，就是讓V1跟V3結合
//
// 目的：
// 加速多國語系的套用，尤其是在全客製的A方案
//
if(!isset($simplehtml)){
	if(defined('LAYOUTV3_STRUCT_MODE') and LAYOUTV3_STRUCT_MODE == 'yii'){
		$simplehtml = new SimpleHtmlDom;
	}
}

// CIg前台架構(cig_frontend)，會需要這個判斷式，這樣子DOM第二版才能正常init
if(!function_exists('str_get_html')){
	if(file_exists('standalone_simplehtmldom.php')){
		include 'standalone_simplehtmldom.php';
	} elseif(file_exists('../standalone_simplehtmldom.php')){
		include '../standalone_simplehtmldom.php';
	} elseif(file_exists('../../standalone_simplehtmldom.php')){
		include '../../standalone_simplehtmldom.php';
	}
}

$html = str_get_html($out, true, true, DEFAULT_TARGET_CHARSET, false);
$has_rule = false;

if(isset($v1) and count($v1) > 0){
	foreach($v1 as $kgg => $vgg){
		if(isset($vgg['type'])){
			if($vgg['type'] == 'l'){
				// 唯一條件
				$layer_parent = $vgg['parent']; // 'find("*[l*=layer]", "'.$x.'")';

				$layer_single = $vgg['single']; // 是否為單層單行模式，false或是true
				$layer_data_source = $vgg['data_source']; // 例product:
				$layer_params = $vgg['params']; // 例filter_key:1.2.3.4
				$layer_ignore_top = $vgg['ignore_top']; // 上方忽略區塊

				$layer_struct_0 = $vgg['struct_0']; // <li><a href="{/url/}"><span>{/name/}</span></a>{/child/}</li>
				$layer_struct_1 = $vgg['struct_1']; // <ul>
				$layer_struct_2 = $vgg['struct_2']; // </ul>

				$layer_debug_first = $vgg['debug_first']; // 
				$layer_debug = $vgg['debug']; // 

				include 'dom5/layer.php';
			} elseif($vgg['type'] == 'n'){
				$nothing_parent = $vgg['parent']; // 'find("*[n*=]", "'.$x.'")';

				include 'dom5/nothing.php';
			} elseif($vgg['type'] == 'd'){
				$single_parent = $vgg['parent']; //'find("*[d*=]", "'.$x.'")';
				$single_data_source = $vgg['data_source']; // 
				$single_struct_tag = $vgg['struct_tag'];
				$single_struct = $vgg['struct'];

				$single_debug = $vgg['debug'];

				include 'dom5/single.php';
			} elseif($vgg['type'] == 't'){
				$translate_parent = $vgg['parent']; //'find("*[t*=]", "'.$x.'")';
				$function_list = $vgg['function_list'];

				include 'dom5/translate.php';
			}
		} // isset type
	}
}

// 移動(處理程序一)
for($xgg=0;$xgg<=5;$xgg++){

	$move_parent = 'find("*[m*=]", "'.$xgg.'")';
	unset($target);
	$run = '$target = $html->'.$move_parent.'->m;';
	@eval($run); // gg
	if(!isset($target)){
		continue;
	}

	$move_content = 'find("*[m*='.$target.']", "'.$xgg.'")';
	unset($move_data_content);
	$run = '$move_data_content = $html->'.$move_content.'->outertext;';
	@eval($run); // gg
	if(!isset($move_data_content)){
		continue;
	}

	$move_go = 'find("*[mg*='.$target.']", "0")';
	unset($move_go_content);
	$run = '$html->'.$move_go.'->innertext .= "\n".$move_data_content;';
	@eval($run); // gg

	$has_rule = true;
}

// 移動(處理程序二)
for($xgg=0;$xgg<=5;$xgg++){

	$move_parent = 'find("*[mg*=]", "'.$xgg.'")';
	unset($target);
	$run = '$html->'.$move_parent.'->outertext = $html->'.$move_parent.'->innertext;';
	@eval($run); // gg
	if(!isset($target)){
		continue;
	}

	$has_rule = true;
}


// 什麼都沒有
for($x=0;$x<=5;$x++){
	$nothing_parent = 'find("*[n*=]", "0")';

	include 'dom5/nothing.php';
}

// 無限層
for($xgg=0;$xgg<=8;$xgg++){ // 因為裡面所引用的程式碼很深，所以這裡最頂層的變數撰寫要小心

	// 唯一條件
	$layer_parent = 'find("*[l*=layer]", "'.$xgg.'")';

	$layer_data_source = ''; // 例product:
	$layer_params = ''; // 例filter_key:1.2.3.4

	// 局部條件
	$layer_list = 'find("*[l*=list]", "0")->outertext'; // list
	$layer_it = 'find("*[l*=it]", "0")->outertext'; // ignore top 
	$layer_box = 'find("*[l*=box]", "0")->outertext'; // box

	include 'dom5/layer.php';

	$has_rule = true;
}

/*
 * 使用方式：
 * <span d="ddd">我會被覆蓋掉</span>
 * 假設資料來源：
 * array('content' => '123')
 * 輸出：
 * <span>123</span>
 *
 * 位置1：資料來源，如果是ddd，就會被取代成V3的ID、如果是table.AAA.BBB，就是table前綴.資料表.資料編號、其它是$data['XXX']
 */
for($xgg=0;$xgg<=14;$xgg++){

	$single_parent = 'find("*[d*=]", "'.$xgg.'")';
	$single_data_source = ''; // 

	// $single_struct_tag = '';
	// $single_struct = '';

	include 'dom5/single.php';

	$has_rule = true;
}

/*
 * 使用方式：
 * <span t="* tw strtolower">我是中文</span>
 * 第一個位置：指定屬性，innertext是預設，如果後面還要加其它功能，那這個位置就是*(星號)，如果有多個屬性要做，那就用pipe(|)分隔，但是共用第二位置的語系
 * 第二個位置：該片語是什麼語系，預設是tw(*)，如果想要自動偵測，請使用auto(2017-11-10 winnie發現的)
 * 第三個位置：可以指定首字大寫、全部大寫等，可以使用的包含strtolower、strtoupper、ucfirst、trim
 */
for($x=0;$x<=14;$x++){
	$translate_parent = 'find("*[t*=]", "'.$x.'")';

	include 'dom5/translate.php';

	$has_rule = true;
}


// 如果上面的功能規則有運作，只要有一個動作，就會進來這裡，把剩餘的屬性移除掉
if($has_rule === true){

	for($x=0;$x<=8;$x++){
		// $parent = 'find("*[t*=]", "'.$x.'")'; // 因為下面移除掉了，所以如果要移除的話，就是移除第一個
		$parent = 'find("*[l*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->l;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$run = '$html->'.$parent.'->removeAttribute("l");';
		eval($run);
	}

	for($x=0;$x<=8;$x++){
		// $parent = 'find("*[t*=]", "'.$x.'")'; // 因為下面移除掉了，所以如果要移除的話，就是移除第一個
		$parent = 'find("*[ls*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->ls;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$run = '$html->'.$parent.'->removeAttribute("ls");';
		eval($run);
	}

	for($x=0;$x<=8;$x++){
		// $parent = 'find("*[t*=]", "'.$x.'")'; // 因為下面移除掉了，所以如果要移除的話，就是移除第一個
		$parent = 'find("*[lp*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->lp;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$run = '$html->'.$parent.'->removeAttribute("lp");';
		eval($run);
	}

	for($x=0;$x<=14;$x++){
		$parent = 'find("*[d*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->d;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$run = '$html->'.$parent.'->removeAttribute("d");';
		eval($run);
	}

	for($x=0;$x<=14;$x++){
		// $parent = 'find("*[t*=]", "'.$x.'")'; // 因為下面移除掉了，所以如果要移除的話，就是移除第一個
		$parent = 'find("*[t*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->t;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$run = '$html->'.$parent.'->removeAttribute("t");';
		eval($run);
	}

	// 壓縮
	// 這裡的壓縮，是比較安全的，所以各行之間會多一個空白
	// 但是某些狀況不適用，不適用的話，請使用V3的那一種方式
	for($x=0;$x<=5;$x++){
		$parent = 'find("*[x*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->innertext;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$aaa = explode("\n", $function_list_tmp);
		foreach($aaa as $k => $v){
			$aaa[$k] = trim($v).' ';
		}
		$bbb = implode('', $aaa);

		$run = '$html->'.$parent.'->innertext = \''.str_replace("'","\'",$bbb).'\';';
		// echo $run;die;
		eval($run);

		$run = '$html->'.$parent.'->removeAttribute("x");';
		eval($run);
	}

	// 壓縮
	// 這裡的壓縮，是比較乾靜的
	for($x=0;$x<=5;$x++){
		$parent = 'find("*[z*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->innertext;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$aaa = explode("\n", $function_list_tmp);
		foreach($aaa as $k => $v){
			$aaa[$k] = trim($v);
		}
		$bbb = implode('', $aaa);

		$run = '$html->'.$parent.'->innertext = \''.str_replace("'","\'",$bbb).'\';';
		eval($run);

		$run = '$html->'.$parent.'->removeAttribute("z");';
		eval($run);
	}

	for($x=0;$x<=5;$x++){
		// $parent = 'find("*[t*=]", "'.$x.'")'; // 因為下面移除掉了，所以如果要移除的話，就是移除第一個
		$parent = 'find("*[m*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->m;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$run = '$html->'.$parent.'->removeAttribute("m");';
		eval($run);

		// $parent = 'find("*[t*=]", "'.$x.'")'; // 因為下面移除掉了，所以如果要移除的話，就是移除第一個
		$parent = 'find("*[mg*=]", "0")';

		unset($function_list_tmp);
		$run = '$function_list_tmp = $html->'.$parent.'->mg;';

		// 會這樣子寫，是因為我假設5個區塊要用規則，多餘的會透過這裡排除掉
		@eval($run); // gg
		if(!isset($function_list_tmp)){
			continue;
		}

		$run = '$html->'.$parent.'->removeAttribute("mg");';
		eval($run);
	}

	$aaa = $html->save();

	// 輸出前，先把不該輸出的東西處理掉
	$aaa = str_replace('l="layer"', '', $aaa);
	$aaa = str_replace('l="list"', '', $aaa);
	$aaa = str_replace('l="layer list"', '', $aaa);
	$aaa = str_replace('l="box"', '', $aaa);
	$aaa = str_replace('l="it"', '', $aaa); // ignore top
	$aaa = str_replace('m="body_end"', '', $aaa);
	// $aaa = str_replace('m="multi"', '', $aaa);
	// $aaa = str_replace('m="it"', '', $aaa); // ignore top
	// $aaa = str_replace('m="e"', '', $aaa); // even
	// $aaa = str_replace('m="o"', '', $aaa); // odd
	// $aaa = str_replace('m="s"', '', $aaa); // start
	// $aaa = str_replace('m="1"', '', $aaa); // default
	// $aaa = str_replace('m="f"', '', $aaa); // field
	// $aaa = str_replace('m="multi 1"', '', $aaa);
	// $aaa = str_replace('m="multi s"', '', $aaa); // 這個應該不可能吧，不過還是寫下來
	// $aaa = str_replace('m="e f"', '', $aaa);
	// $aaa = str_replace('m="o f"', '', $aaa);
	// $aaa = str_replace('m="s f"', '', $aaa);
	// $aaa = str_replace('m="1 f"', '', $aaa);
	$aaa = str_replace('debug_first="123"', '', $aaa);
	$aaa = str_replace('debug="123"', '', $aaa);

	// for($x=1;$x<=8;$x++){
	// 	if(preg_match('/ms=\"(.*)\"/', $aaa, $matches)){
	// 		// 假設性的錯誤處理
	// 		if(preg_match('/\"/', $matches[1])){
	// 			$tmps = explode('"', $matches[1]);
	// 			$matches[1] = $tmps[0];
	// 		}
	// 		$aaa = str_replace('ms="'.$matches[1].'"', '', $aaa);
	// 	}
	// }

	// for($x=1;$x<=8;$x++){
	// 	if(preg_match('/mp=\"(.*)\"/', $aaa, $matches)){
	// 		// 假設性的錯誤處理
	// 		if(preg_match('/\"/', $matches[1])){
	// 			$tmps = explode('"', $matches[1]);
	// 			$matches[1] = $tmps[0];
	// 		}
	// 		$aaa = str_replace('mp="'.$matches[1].'"', '', $aaa);
	// 	}
	// }

	//echo $aaa;

	// 統一在_cache3後輸出
	$out = $aaa;
} else {
	// 改成在_cache3後輸出
	// echo $out;
}

/*
 * _CACHE3
 * 2017-12-18 下午2點40有跟李哥說，他說可以做cache機制
 *
 * 相關檔案如下：
 * parent/core.php 兩個地方
 * layoutv3/render.php
 * layoutv3/dom5.php
 */
if(0 and !preg_match('/(inquiry|contact)/', $_SERVER['SCRIPT_NAME'])){
	@mkdir('_cache3',0777,true);
	chmod('_cache3', 0777);
	$get = '';
	if(!empty($_GET)){
		foreach($_GET as $k => $v){
			if(!preg_match('/current_page/', $k)){
				$get .= $k.':'.$v.',';
			}
		}
	}
	$filename = '_cache3/'.str_replace('.php','',str_replace('/','',$_SERVER['SCRIPT_NAME'])).'-'.$this->data['ml_key'].'-'.md5($get).'.html';
	// Debug
	// var_dump($get);echo $filename;
	file_put_contents($filename, $out);
	chmod($filename, 0777);
}

echo $out;

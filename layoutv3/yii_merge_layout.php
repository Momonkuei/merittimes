<?php
// 這裡上面不要空行，不然captcha的圖片會出不來

/*
 * 這個是Yii平面化在使用的LayoutV3程式樣版
 */


/*
* 檢測連結是否是SSL連線
* @return bool
*/
session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota
if(!function_exists('is_SSL')){
	function is_SSL(){
		if(!isset($_SERVER['HTTPS']))
			return FALSE;
		if($_SERVER['HTTPS'] === 1){  //Apache
			return TRUE;
		}elseif($_SERVER['HTTPS'] === 'on'){ //IIS
			return TRUE;
		}elseif($_SERVER['SERVER_PORT'] == 443){ //其他
			return TRUE;
		}
			return FALSE;
	}
}

if(is_SSL()){

	//設定cookie傳輸模式 by lota
	// $maxlifetime = ini_get('session.gc_maxlifetime');
	$secure = true; // if you only want to receive the cookie over HTTPS
	$httponly = true; // prevent JavaScript access to session cookie
	$samesite = 'None';

    if(PHP_VERSION_ID < 70300) {
        session_set_cookie_params(0, '/; samesite='.$samesite, str_replace('www','',$_SERVER['HTTP_HOST']), $secure, $httponly);
    } else {
        session_set_cookie_params([
            // 'lifetime' => $maxlifetime,
            'path' => '/',
            'domain' => str_replace('www','',$_SERVER['HTTP_HOST']),
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
    }
}



// 這個是開發階段所使用的，如果開發完成，請註解
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*
 * 【Ming 2017-05-12】關於「SEO - 網址討論結論」
 * parent/core.php
 */

// 為了支援200網站的使用習慣，上線後，可以把這裡mark掉
if($_SERVER['HTTP_HOST'] == '192.168.0.200'){
	$tmp = explode('/', $_SERVER["REQUEST_URI"]);
	header('Location: http://'.$tmp[1].'.web.buyersline.com.tw');
	die;
}


// 簡易安全機制範例，有需要在打開，記得正式上線後要移除
if(0 and $_SERVER['HTTP_HOST'] != '889.devel.gisanfu.idv.tw'){
	@session_start();
	if ($_SESSION['enter'] !== true){
		?>
		 <script language="javascript">
        location.href='login_demo.php';
        </script>           
        <?php
		exit;
	}
}


$tmp = $_SERVER['SCRIPT_NAME'];

// 為了要支援，在htaccess裡面寫規則，取代parent/core.php的前導程式
// 理論上平面化應該不會用到這裡，不過還是寫過來好了
if($tmp == '/parent_core.php'){
	$tmp = $_SERVER['REQUEST_URI'];
}
if(preg_match('/^(.*)\?/', $tmp, $matches)){
	$tmp = $matches[1];
}

$tmps = explode('_',$tmp);

if($tmps and count($tmps) == 2 and strlen(str_replace('.php','',$tmps[1])) == 2){
	@session_start();
	$_SESSION['web_ml_key'] = str_replace('.php','',$tmps[1]);
	$_SERVER['SCRIPT_NAME'] = $tmps[0].'.php';
}

/*
 * 這支程式，對於LayoutV3來說，是要預留給需要用的程式或架構，例如：MVC架構
 * layoutv3/yii/init.php
 */

// 不同Application，如果這裡有指定的話(例如"admin/"或是en/")，可以使用自己的group、view等，但是layoutv3資料夾還是共用一個
if(!isset($layoutv3_path)){
	$layoutv3_path = '';
}

// 下面的a.php，不需要用parent_path來判斷，因為不太一樣
if(!isset($layoutv3_parent_path)){
	$layoutv3_parent_path = '';
}

if(!defined('LAYOUTV3_IS_RUN_FIRST')){

	define('LAYOUTV3_PARENT_PATH', $layoutv3_parent_path);
	define('LAYOUTV3_PATH', $layoutv3_path); // 為了要讓MVC架構也能使用，所以才用常數

	/*
	 * 這是一個示範，簡化MVC的網址
	 */

	if(file_exists('a.php')){
		// define('LAYOUTV3_IS_RUN_FIRST', str_replace(__DIR__.'/', '', str_replace('.php','',__FILE__)));
		// 用script_name才不會抓到GET引數
		define('LAYOUTV3_IS_RUN_FIRST', str_replace('/', '', str_replace('.php', '', $_SERVER["SCRIPT_NAME"])));
		
		$tmp = LAYOUTV3_IS_RUN_FIRST;

		// 修改預設的router和method，為了要減化網址
		define('RETURNXX', <<<XXX
		\$returnxx = array(
			'defaultController' => 'site',
			'defaultAction' => '$tmp',
		);
XXX
		);
		require 'a.php';
	} else {
		// define('LAYOUTV3_IS_RUN_FIRST', str_replace(__DIR__.'/', '', str_replace('.php','',__FILE__)));
		// 用script_name才不會抓到GET引數

		$gggs = explode('/', $_SERVER["SCRIPT_NAME"]);

		define('LAYOUTV3_IS_RUN_FIRST', str_replace('.php', '', $gggs[count($gggs)-1]));
		
		$tmp = LAYOUTV3_IS_RUN_FIRST;

		// 修改預設的router和method，為了要減化網址
		define('RETURNXX', <<<XXX
		\$returnxx = array(
			'defaultController' => 'sem',
			'defaultAction' => '$tmp',
		);
XXX
		);
		require '../a.php';
	}

	// 前半段這裡結束
}

// 前半段到這裡就結束了哦
// 接下來YII的預設Controllers會重新載入程式，例如載入company.php
// 但是程式都會載入這支core.php，所以這支程式會被載入第二次
//

$page = array();
$data = array();

/*
 * $ID = layoutv3_next_data_id($layoutv3_struct, $ID);
 */
if(!function_exists('layoutv3_next_data_id')){
	function layoutv3_next_data_id($struct, $current){
		$point = false;
		foreach($struct as $k => $v){
			if($point){
				$tmp = explode('|', $v);
				return trim($tmp[0]);
			}
			if(preg_match('/^'.$current.'\|/', $v)){
				$point = true;
			}
		}
	}
}

if(!function_exists('layoutv3_struct_search')){
	function layoutv3_struct_search($array, $key, $value, $k = '')
	{
		$results = array();

		if (is_array($array)) {
			if (isset($array[$key]) && $array[$key] == $value) {
				$array['position'] = $k; // 這個是我後來加的
				$results[] = $array;
			}

			foreach ($array as $ggg => $subarray) {
				$results = array_merge($results, layoutv3_struct_search($subarray, $key, $value, $k.'-'.$ggg));
			}
		}

		return $results;
	}
}

// http://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
/*
 * 用法
 * echo str_replace_first('abc', '123', 'abcdef abcdef abcdef'); 
 * outputs '123def abcdef abcdef'
 */
// function layoutv3_str_replace_first($from, $to, $subject){
// 	$from = '/'.preg_quote($from, '/').'/';
// 	return preg_replace($from, $to, $subject, 1);
// }

// http://php.net/manual/en/function.rand.php
// @qtd 要產出的長度
if(!function_exists('layoutv3_hash')){
	function layoutv3_hash($qtd){
		//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
		$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
		$QuantidadeCaracteres = strlen($Caracteres);
		$QuantidadeCaracteres--;

		$Hash=NULL;
			for($x=1;$x<=$qtd;$x++){
				$Posicao = rand(0,$QuantidadeCaracteres);
				$Hash .= substr($Caracteres,$Posicao,1);
			}

		return $Hash; 
	}
}

// https://blog.longwin.com.tw/2009/03/php-object-to-array-json-reader-cli-2009/
//
// 使用方式
// $rows = $this->db->createCommand()->from('producttype')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// $indexedItems = array();
// 
// foreach ($rows as $item) {
// 	$item['child'] = array();
// 	$indexedItems[$item['id']] = (object) $item;
// }
// 
// $topLevel = array();
// foreach ($indexedItems as $item) {
// 	if ($item->pid == 0) {
// 		$topLevel[] = $item;
// 	} else {
// 		$indexedItems[$item->pid]->child[] = $item;
// 	}
// }
// $tree = std_class_object_to_array($topLevel);
// var_dump($tree);
if(!function_exists('std_class_object_to_array')){
function std_class_object_to_array($stdclassobject)
{
	$_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

	foreach ($_array as $key => $value) {
		$value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
		$array[$key] = $value;
	}

	if(isset($array)){
		return $array;
	}
}
}

/*
 * 
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

	// 我打算給它預設值為當前語系
	if($target == ''){
		if(!isset($map[$_SESSION['web_ml_key']])){
			$target = $_SESSION['web_ml_key'];
		} else {
			$target = $map[$_SESSION['web_ml_key']];
		}
	}

	if($source == $target){
		return $text;
	} else {
		$url = FRONTEND_DOMAIN.'/translate.php';
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

/*
 * 還有優先權最高的post的程式
 * 還有合併好的$page
 */
$AAAAAAAAAAAAAAAAAAAA=0;

/*
 * 這裡的處理好、合併好的$page變數，放在上面，就是A的那個位置
 */

/*
 * 整理陣列
 * 把那些群組和Layout都給刪掉
 */
$tmps = explode("\n", var_export($page,true));
$groups = array();
if($tmps and count($tmps) > 0){
	foreach($tmps as $k => $v){
		if(preg_match('/\'\$(.*)\'/', $v, $matches)){
			$groups[] = $matches[1];
		}
	}
}
$group_tmp = array();
$group_result = array();
if($groups and count($groups) > 0){
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
if($group_tmp and count($group_tmp) > 0){
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

/*
 * 將結構轉成PHP和HTML混合的程式碼
 * 在這個階段後，就沒有群組和區塊了
 * 己經將分散的檔案給組起來了
 */

//$run = layoutv3_section_recursive(0, $page, $this->data);

/*
 * 這裡要放View合併好的東西
 */
$run = <<<'XXX'
$BBBBBBBBBBBBBBBBBBBB=0;
XXX;

$layoutv3_pre_render_content = explode("\n",$run);

/*
 * 這裡要放Source合併好的東西
 */
$CCCCCCCCCCCCCCCCCCCC=0;

/*
 * pre_render.php結束
 */


/*
 * 這裡是自定程式碼，但這裡並不會去parser抓過來
 */

//include 'layoutv3/render.php';

/*
 * <?php if(0):?><!-- head_start -->
 * <script type="text/javascript">
 * // head start
 * </script>
 * <?php endif?><!-- head_start -->
 * 
 * <?php if(0):?><!-- head_end -->
 * <script type="text/javascript">
 * // head end 
 * </script>
 * <?php endif?><!-- head_end -->
 * 
 * <?php if(0):?><!-- body_start -->
 * <script type="text/javascript">
 * // body start
 * </script>
 * <?php endif?><!-- body_start -->
 * 
 * <?php if(0):?><!-- body_end -->
 * <script type="text/javascript">
 * // body end 
 * </script>
 * <?php endif?><!-- body_end -->
 */

$append = array();
$append['head_start'] = '';
$append['head_end'] = '';
$append['body_start'] = '';
$append['body_end'] = '';

$append_object['head_start'] = array();
$append_object['head_end'] = array();
$append_object['body_start'] = array();
$append_object['body_end'] = array();

$point = '';
foreach($layoutv3_pre_render_content as $k => $v){
	if(preg_match('/^\<\?php\ if\(0\)\:\?\>\<\!\-\-\ (head_start|head_end|body_start|body_end)\ \-\-\>$/', trim($v), $matches)){
		$point = $matches[1];
		unset($layoutv3_pre_render_content[$k]);
		continue;
	} elseif(preg_match('/^\<\?php\ endif\?\>\<\!\-\-\ (head_start|head_end|body_start|body_end)\ \-\-\>$/', trim($v), $matches)){
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
	if(preg_match('/^\<\?php\ if\(0\)\:\?\>\<\!\-\-\ (head_start|head_end|body_start|body_end)\:(.*)\ \-\-\>$/', trim($v), $matches)){
		$tag = $matches[1];
		$module = $matches[2];
		unset($layoutv3_pre_render_content[$k]);
		continue;
	} elseif(preg_match('/^\<\?php\ endif\?\>\<\!\-\-\ (head_start|head_end|body_start|body_end)\:(.*)\ \-\-\>$/', trim($v), $matches)){
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
	if(preg_match('/\/\/ killme/', $v, $matches)){
		unset($layoutv3_pre_render_content[$k]);
	}
}

$run = implode("\n", $layoutv3_pre_render_content);
//echo $run;die;
//var_dump($append_object);die;

if(count($append_object['head_start']) > 0){
	$tmp2 = '';
	foreach($append_object['head_start'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['head_start'] = $tmp2;
} else {
	$append_object['head_start'] = '';
}

if(count($append_object['head_end']) > 0){
	$tmp2 = '';
	foreach($append_object['head_end'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['head_end'] = $tmp2;
} else {
	$append_object['head_end'] = '';
}

if(count($append_object['body_start']) > 0){
	$tmp2 = '';
	foreach($append_object['body_start'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['body_start'] = $tmp2;
} else {
	$append_object['body_start'] = '';
}

if(count($append_object['body_end']) > 0){
	$tmp2 = '';
	foreach($append_object['body_end'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['body_end'] = $tmp2;
} else {
	$append_object['body_end'] = '';
}

$run = str_replace('##head_start##', $append_object['head_start']."\n".$append['head_start'], $run);
$run = str_replace('##head_end##', $append_object['head_end']."\n".$append['head_end'], $run);
$run = str_replace('##body_start##', $append_object['body_start']."\n".$append['body_start'], $run);
$run = str_replace('##body_end##', $append_object['body_end']."\n".$append['body_end'], $run);

if(isset($other_function) and count($other_function) > 0){
	foreach($other_function as $k => $v){
		if($k == 'remove_new_line'){
			foreach($v as $kk => $vv){
				$other_function[$k][$kk] = trim(preg_replace('/\s\s+/', ' ', $vv));
			}
		}
	}
}

if(isset($other_function) and count($other_function) > 0){
	foreach($other_function as $k => $v){
		foreach($v as $kk => $vv){
			$run = str_replace('<!-- func|result|'.$k.'|'.$kk.' -->', $vv, $run);
		}
	}
}

// debug用的，記得是看原始碼
// 當發生eval某一行的問題，就可以打開這裡，把行號填進去
// $tmps = explode("\n",$run);
// echo $tmps[1627-1];die;

// debug用的
// @mkdir(_BASEPATH.'/../'.LAYOUTV3_PATH.'_compile',0777,true);
// file_put_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'_compile/'.LAYOUTV3_IS_RUN_FIRST.'.php',$run);

// 編譯後的版型，也就是view，最後才會執行哦哦哦
// eval('?'.'>'.$run);

include "dom4.php";

<?php
// 這裡上面不要空行，不然captcha的圖片會出不來

/*
 * 2020-01-02
 * 這個是cig frontend cache4在使用的LayoutV3程式樣版
 */

/*
 * parent/core.php
 */


/*
 * 【Ming 2017-05-12】關於「SEO - 網址討論結論」
 */

// 為了支援200網站的使用習慣，上線後，可以把這裡mark掉
if($_SERVER['HTTP_HOST'] == '192.168.0.200'){
	$tmp = explode('/', $_SERVER["REQUEST_URI"]);
	header('Location: http://'.$tmp[1].'.web2.buyersline.com.tw');
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

/*
 * _CACHE3
 * 2017-12-18 下午2點40有跟李哥說，他說可以做cache機制
 *
 * 相關檔案如下：
 * parent/core.php 兩個地方
 * layoutv3/render.php
 * layoutv3/dom5.php
 */
if(isset($_GET['_cache3']) and $_GET['_cache3'] == 'clear' and file_exists('_cache3')){
	$files = glob('_cache3/*'); //get all file names
	foreach($files as $file){
		if(is_file($file))
			unlink($file); //delete file
	}
	header('Location: /');
	die;
}

//引入$web_folder
include_once dirname(dirname(__FILE__)).'/_i/config/web_folder.php';

//$tmp = $_SERVER['SCRIPT_NAME'];
$tmp = str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']);//為了支援網站放在次目錄所處理的 by lota

$_SERVER['REQUEST_URI_OLD'] = $_SERVER['REQUEST_URI']; // 2019-11-25 用來給後面判斷，這個頁面是正常進來，還是靜態頁進來
if(preg_match('/\.html$/', $_SERVER['REQUEST_URI']) and isset($_SERVER['REDIRECT_URL']) and preg_match('/\.php$/', $_SERVER['REDIRECT_URL'])){
	$_SERVER['REQUEST_URI'] = $_SERVER['REDIRECT_URL'];
}

if(preg_match('/\.html$/', $_SERVER['REQUEST_URI'])){
	if(isset($_SERVER['REDIRECT_URL']) and preg_match('/\.php$/', $_SERVER['REDIRECT_URL'])){ // 2019-11-22 編排頁是靜態網址
		$_SERVER['REQUEST_URI'] = $_SERVER['REDIRECT_URL'];
	} elseif(isset($_SERVER['SCRIPT_NAME']) and preg_match('/parent_core/', $_SERVER['SCRIPT_NAME'])){ // 2019-11-25 通用靜態頁處理程式
		$aaa = file_get_contents(dirname(dirname(__FILE__)).'/_i/config/environment.php');
		$aaas = explode("\n", $aaa);
		if($aaas and !empty($aaas)){
			foreach($aaas as $k => $v){
				// define('FRONTEND_DEFAULT_LANG', 'tw'); // 設定預設語系，當作createURL指標參考值 (*layoutv3的cig_frontend模式所使用)
				if(preg_match('/\'FRONTEND_DEFAULT_LANG\'\,\ \'(.*)\'/', $v, $matches)){
					$default_ml_key = $matches[1];
				}
			}
		}

		include dirname(dirname(__FILE__)).'/_i/assets/statichtml.php';

		$seo_script_name = $_SERVER['REQUEST_URI'];
		$seo_script_name = str_replace('.html','',$seo_script_name);
		$seo_script_name = str_replace('/','',$seo_script_name);

		if(isset($statichtml) and isset($default_ml_key)){
			$seo_type = '';
			$seo_item_id = 0;
			$current_ml_key = '';
			
			// 先找該語系底下的，然後在找其它語系順位第一的底下的
			if(isset($statichtml[$seo_script_name][$default_ml_key]) and !empty($statichtml[$seo_script_name][$default_ml_key])){
				$seo_type = $statichtml[$seo_script_name][$default_ml_key][0]['seo_type'];
				$seo_item_id = $statichtml[$seo_script_name][$default_ml_key][0]['seo_item_id'];
				$current_ml_key = $default_ml_key;
			} elseif(isset($statichtml[$seo_script_name]) and !empty($statichtml[$seo_script_name])){
				foreach($statichtml[$seo_script_name] as $other_ml_key => $v){
					break;
				}
				$seo_type = $statichtml[$seo_script_name][$other_ml_key][0]['seo_type'];
				$seo_item_id = $statichtml[$seo_script_name][$other_ml_key][0]['seo_item_id'];
				$current_ml_key = $other_ml_key;
			}

			if($seo_type != ''){
				if(preg_match('/^(.*)_(.*)$/', $seo_type, $matches)){ // 編排頁
					$new_uri = $matches[1].'_'.$current_ml_key.'_'.$matches[2].'.php';
				} else {
					if($seo_type == 'about' or preg_match('/type/', $seo_type)){
						$new_uri = $seo_type.'_'.$current_ml_key.'.php';
					} else {
						$new_uri = $seo_type.'detail_'.$current_ml_key.'.php';
					}
				}

				if($seo_item_id > 0){
					$new_uri .= '?id='.$seo_item_id;
					$_GET['id'] = $seo_item_id;
				}

				// 重組request_uri
				$bbbs = explode('/', $_SERVER['REQUEST_URI']);
				$bbbs[count($bbbs)-1] = $new_uri;
				$_SERVER['REQUEST_URI'] = implode('/', $bbbs);
			}
		}
	}
}
//var_dump($_SERVER);

// 為了要支援，在htaccess裡面寫規則，取代parent/core.php的前導程式
// 理論上，平面化應該不會用到這裡
if($tmp == '/parent_core.php'){
	//$tmp = $_SERVER['REQUEST_URI'];
	$tmp = str_replace($web_folder,'',$_SERVER['REQUEST_URI']);//為了支援網站放在次目錄所處理的 by lota
}
if(preg_match('/^(.*)\?/', $tmp, $matches)){
	$tmp = $matches[1];
}

$tmps = explode('_',$tmp);

// 動態網址 2017-09-20有跟李哥討論過
// if($tmps[0] == '/contact'){
// 	header('Location: index_'.str_replace('.php','',$tmps[1]));
// }

// 動態網址(第2版)
if(file_exists('_i/assets/_dynamic_url.php')){
	include '_i/assets/_dynamic_url.php';

	if($_dynamic_url and !empty($_dynamic_url)){
		foreach($_dynamic_url as $k => $v){
			if($tmps[0] == '/'.$v){
				header('Location: index_'.str_replace('.php','',$tmps[1]).'.php');
			}
		}
	}
}

$file = ''; // 2020-01-02
$count = count($tmps);
if($tmps and $count == 2 and strlen(str_replace('.php','',$tmps[1])) == 2){

	/*
	 * _CACHE3
	 * 2017-12-18 下午2點40有跟李哥說，他說可以做cache機制
	 *
	 * 相關檔案如下：
	 * parent/core.php 兩個地方
	 * layoutv3/render.php
	 * layoutv3/dom5.php
	 */
	if(!preg_match('/(inquiry|contact)/', $tmps[0])){
		$get = '';
		if(!empty($_GET)){
			foreach($_GET as $k => $v){
				$get .= $k.':'.$v.',';
			}
		}
		$filename = '_cache3'.$tmps[0].'-'.str_replace('.php','',$tmps[1]).'-'.md5($get).'.html';
		// Debug
		// var_dump($get);echo $filename;
		if(file_exists($filename)){
			echo file_get_contents($filename);
			die;
		}
	}

	@session_start();

	$_SESSION['web_ml_key'] = str_replace('.php','',$tmps[1]);
	$_SERVER['SCRIPT_NAME'] = $tmps[0].'.php';


	// 切換成Yii架構(cttdemo)
	// $run = file_get_contents('ctt'.$_SERVER['SCRIPT_NAME']);
	
	// 切換成Yii架構(V3)新
	$file = 'parent/_page.php';
	if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
		$file = 'parent'.$_SERVER['SCRIPT_NAME'];
	}

	// 切換成Yii架構(V3)
	// if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
	// 	$run = file_get_contents('parent'.$_SERVER['SCRIPT_NAME']);
	// } else {
	// 	$run = file_get_contents('parent/_page.php');
	// }

	// 切換成V2架構(原生支援LayoutV2) beta
	// 還有 layoutv3/cig_frontend/init.php 那邊也要切換
	// $run = file_get_contents('v2'.$_SERVER['SCRIPT_NAME']);

	// 切換成Yii架構(V3) beta
	// if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
	// 	$run = file_get_contents('parent'.$_SERVER['SCRIPT_NAME']);
	// } else {
	// 	/*
	// 	 * 打算只支援單頁 2017-09-05
	// 	 */
	// 	$aaa = file_get_contents('_i/config/db.php');
	// 	$aaa = str_replace('aaa_','gggaaa0_',$aaa);
	// 	eval('?'.'>'.$aaa);
	// 	
	// 	$Db_Server = gggaaa0_dbhost;
	// 	$Db_User = gggaaa0_dbuser;
	// 	$Db_Pwd = gggaaa0_dbpass;
	// 	$Db_Name = gggaaa0_dbname; 
	// 	
	// 	$tmpg = array(
	// 		'dbdriver' => 'mysql',
	// 		'username' => $Db_User,
	// 		'password' => $Db_Pwd,
	// 		'hostname' => $Db_Server,
	// 		'port' => 3306,
	// 		'database' => $Db_Name,
	// 	);
	// 	
	// 	include_once 'layoutv3/cig/ci.php'; // 要記得，在init之上的東西，會載入兩次
	// 	$ggg = ggg_load_database($tmpg, true);

	// 	$ml_key = $_SESSION['web_ml_key'];
	// 	$router_method = str_replace('/', '', $tmps[0]);

	// 	// 不要只搜尋啟用的，因為它有可能是放在其它位置(例：top_link_menu)
	// 	// $row = $ggg->where('type', 'webmenu')->where('ml_key', $ml_key)->where('is_home',1)->where('is_top',1)->where('url1', $router_method.'_'.$ml_key.'.php')->get('html')->row_array();

	// 	$o = $ggg->where('type', 'webmenu')->where('ml_key', $ml_key);
	// 	$o = $o->where('url1', $router_method.'_'.$ml_key.'.php');
	// 	$o = $o->where('is_home',1)->where('is_top',1);
	// 	$row = $o->get('html')->row_array();

	// 	// var_dump($row);die;

	// 	if($row and isset($row['id']) and $row['id'] > 0){
	// 		define('IS_ARTICLESINGLE', true); // 給SiteController判斷用
	// 		$run = file_get_contents('parent/_articlesingle.php');
	// 	} else {
	// 		header("HTTP/1.0 404 Not Found");
	// 		die;
	// 	}
	// }

	// eval('?'.'>'.$run);
} elseif($tmps and $count == 3 and strlen(str_replace('.php','',$tmps[1])) == 2){ // 編排頁
	@session_start();

	$_SESSION['web_ml_key'] = str_replace('.php','',$tmps[1]);
	$_SERVER['SCRIPT_NAME'] = $tmps[0].'_'.$tmps[2].'.php';

	// 切換成Yii架構(cttdemo)
	// $run = file_get_contents('ctt'.$_SERVER['SCRIPT_NAME']);

	// 切換成Yii架構(V3)新
	$file = 'parent/_page.php';
	if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
		$file = 'parent'.$_SERVER['SCRIPT_NAME'];
	}
	
	// 切換成Yii架構(V3)
	// if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
	// 	$run = file_get_contents('parent'.$_SERVER['SCRIPT_NAME']);
	// } else {
	// 	$run = file_get_contents('parent/_page.php');
	// }

	// $_SERVER['SCRIPT_NAME'] = $tmps[0].'.php';

	// eval('?'.'>'.$run);
} elseif($tmps and $count == 1){ // 沒有指定語系的情況
	// 看看它的位置，是在根目錄的，還是在子資料夾

	@session_start();

	$tmps = explode('/', $_SERVER['REQUEST_URI']);
	$request_uri = $_SERVER['REQUEST_URI'];

	$path1 = 'parent';
	$count = count($tmps);
	if($count == 3){
		$request_uri = '/'.$tmps[2];
		$path1 = $tmps[1];

		if(strlen($path1) == 2){
			$_SESSION['web_ml_key'] = $path1;
		}
	}

	//假如 $_SESSION['web_ml_key'] 為空值 則直接寫入預設值 2018-11-29 by lota
	//if($_SESSION['web_ml_key']==''){
	//	$_SESSION['web_ml_key'] = 'tw';
	//}

	$tmp = str_replace('/', '', str_replace('.php','', $request_uri));
	$tmp2 = explode('?', $tmp);
	$path2 = $tmp2[0];

	// 2018-10-04
	if($path2 == ''){
		$path2 = 'index';
	}

	$file_tmp = $path1.'/'.$path2.'.php';

	// $_SERVER['SCRIPT_NAME'] = '/'.$file; // 2018-10-04 不要在用這行了
	$_SERVER['SCRIPT_NAME'] = '/'.$path2.'.php';

	$file = 'parent/_page.php';
	if(file_exists('parent'.$_SERVER['SCRIPT_NAME'])){
		$file = $file_tmp;
	}

	// if(file_exists($file)){
	// 	$run = file_get_contents($file);
	// } else {
	// 	$run = file_get_contents('parent/_page.php');
	// }

	// eval('?'.'>'.$run);
}

/*
 * parent/_page.php
 */

// 2019-05-29 因為帝寶而加的
date_default_timezone_set("Asia/Taipei");

// 為了支援/XXX/news.php
$tmps = explode('/', $_SERVER['REQUEST_URI']);

// 檢查次資料夾的那支檔案是否存在，不存在的話，就不用特別處理
$tmps2 = $tmps;
unset($tmps2[0]);
$check2 = implode('/', $tmps2);

$layoutv3_parent_path = ''; // 2018-11-13
if(count($tmps) == 3){
	$layoutv3_parent_path = $tmps[1].'/'; // 例：tw, news, product, contact
	set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../'); // 產品內頁可能會需要
}

/*
 * layoutv3/init.php
 */

//引入$web_folder
include_once dirname(dirname(__FILE__)).'/_i/config/web_folder.php';

/*
 * 這支程式，對於LayoutV3來說，是要預留給需要用的程式或架構，例如：MVC架構
 * 除了這裡以外，根目錄的index.php可能也會有，那邊也要看一下
 * 還有，如果是特殊架構，parent/core.php的這支檔案也要看一下
 */

// 切換成CIg前台架構(1/3) - 向下相容Yii的非MVC架構
// include 'cig_frontend/init.php';

/*
 * layoutv3/cig_frontend/init.php
 */

use nguyenanhung\CodeIgniterDB as CI;

// if(!defined('LAYOUTV3_PATH')){
if(!defined('LAYOUTV3_IS_RUN_FIRST')){

	// 2018-04-10 各式攻擊與檢查機制
	$file = dirname(__FILE__).'/attack_check.php';
	if(file_exists($file)){

		require $file;

		$HH = new Attack_check;

		$_POST = $HH->check_value($_POST);
		$_GET = $HH->check_value($_GET);
		$_REQUEST = $HH->check_value($_REQUEST);
	}

	@session_start();

	// 每一種架構模式都會有這個屬於自己的常數 2018-01-15
	define('LAYOUTV3_STRUCT_MODE', 'cig_frontend');

	if(!isset($layoutv3_parent_path)){
		$layoutv3_parent_path = '';
	}

	// 不同Application，如果這裡有指定的話(例如"admin/"或是en/")，可以使用自己的group、view等，但是layoutv3資料夾還是共用一個
	if(!isset($layoutv3_path)){
		$layoutv3_path = '';
	}

	define('LAYOUTV3_PARENT_PATH', $layoutv3_parent_path); // 為了要讓連絡我們的動態網址能夠用
	define('LAYOUTV3_PATH', $layoutv3_path); // 為了要讓MVC架構也能使用，所以才用常數

	//$bbb = str_replace('.php','',$_SERVER['SCRIPT_NAME']);
	$bbb = str_replace('.php','',str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']));//為了支援網站放在次目錄所處理的 by lota
	if(defined('LAYOUTV3_PARENT_PATH') and LAYOUTV3_PARENT_PATH != ''){
		$bbb = str_replace(LAYOUTV3_PARENT_PATH,'',$bbb);
	} elseif(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){
		$bbb = str_replace(LAYOUTV3_PATH,'',$bbb);
	}
	$bbb = str_replace('/','',$bbb);

	define('LAYOUTV3_IS_RUN_FIRST', $bbb); // 這個變數，在render階段會用到，等同於功能名稱

	// cache4
	define('_BASEPATH', __DIR__.'/_i'); // /var/www/html/rwd_v3/_i

	//define('customer_public_path', '../'.$layoutv3_path.'assets/'); // 意思是jobs2裡面的assets，
	define('customer_public_path', 'assets/'); // 意思是jobs2裡面的assets，

	$vendors_dir = _BASEPATH.'/vendors';
	ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

	// CI2
	// include_once 'ci.php';	

	// CI3
	// 2018-12-18 從ci.php裡面移出來的
	if(!defined('GGG_BASEPATH')){
		// cache4
		define('GGG_BASEPATH', realpath(dirname(__FILE__)).'/layoutv3/cig_frontend/');

	}
	if(!defined('GGG_APPPATH')){
		define('GGG_APPPATH', realpath(dirname(__FILE__)).'');
	}

	// composer autoload 2018-12-18
	include_once GGG_BASEPATH.'../vendor/autoload.php';

	class Foo {

		public $data; // $this->data

		// 這是後台在用的
		// public $ignore_class_acl = array(
		// 	'login',
		// 	'captcha',
		// );

		// 只取得檔案列表
		protected function _getFiles($dir)
		{
		  $files = array();
		  if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
					if(is_dir($dir.'/'.$file)){
						//$dir2 = $dir.'/'.$file;
						//$files[] = _getFilesFromDir($dir2);
						//$files[] = $dir2;
					}
					else {
						$files[] = $dir.'/'.$file;
					}
				}
			}   
			closedir($handle);
		  }

		  return $this->_array_flat($files);
		}

		// 只取得資料夾列表
		protected function _getDirs($dir)
		{
			$files = array();
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
						if(is_dir($dir.'/'.$file)){
							$dir2 = $dir.'/'.$file;
							//$files[] = _getFilesFromDir($dir2);
							$files[] = $dir2;
						}
						else {
							//$files[] = $dir.'/'.$file;
						}
					}
				}   
				closedir($handle);
			}

			return $this->_array_flat($files);
		}

		// 取得資料夾和檔案列表，包含子目錄
		protected function _getFilesFromDir($dir)
		{
			$files = array();
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
						if(is_dir($dir.'/'.$file)){
							$dir2 = $dir.'/'.$file;
							$files[] = $this->_getFilesFromDir($dir2);
						}
						else {
							$files[] = $dir.'/'.$file;
						}
					}
				}   
				closedir($handle);
			}

			return $this->_array_flat($files);
		}

		protected function _array_flat($array) {

			$tmp = array();
			foreach($array as $a) {
				if(is_array($a)) {
					$tmp = array_merge($tmp, $this->_array_flat($a));
				}   
				else {
					$tmp[] = $a; 
				}   
			}

			return $tmp;
		}

		protected function email_send_to($to, $subject, $body, $body_html,$cc_mail = NULL)
		{
			/*
			 * 寄信開始
			 */
			//$zend_dir =  dirname(__FILE__).'/../../framework/vendors';
			//ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$zend_dir);
			require_once('Zend/Loader/Autoloader.php');
			$autoloader = Zend_Loader_Autoloader::getInstance();

			$Transport = new Zend_Mail_Transport_Smtp($this->data['email_config']['_server'], $this->data['email_config']);
			Zend_Mail::setDefaultTransport($Transport);

			//$mail->setFrom(aaa_smtp_from, '');

			$mail = new Zend_Mail('utf-8');
			$mail->setFrom($this->data['sys_configs']['smtp_from'], $this->data['sys_configs']['smtp_from_name']);
			$mail->addTo($to);
			if($cc_mail)
				$mail->addCc($cc_mail);
			
			$mail->setSubject($subject);
			$mail->setBodyText($body);
			$mail->setBodyHtml($body_html);

			$mail->send();
		}

		protected function email_send_to_api($to, $subject, $body, $body_html,$cc_mail = NULL)
		{
			$public_key = EIP_APIV1_PUBLICKEY;
			$private_key = EIP_APIV1_PRIVATEKEY;

			$server_ip = EIP_APIV1_DOMAIN;
			$url = 'index.php?r=api/emailsendto';

			/*
			 * $tmps = array(
			 * 	'ssl',
			 * 	'server',
			 * 	'port',
			 * 	'account',
			 * 	'login_password',
			 * 	'from',
			 * 	'from_name',
			 * 	'to',
			 * 	'cc',
			 * 	'subject',
			 * 	'body',
			 * 	'body_html',
			 * );
			 */
			$params = array(
				'ssl' => $this->data['sys_configs']['smtp_ssl'],
				'server' => $this->data['sys_configs']['smtp_server'],
				'port' => $this->data['sys_configs']['smtp_port'],
				'account' => $this->data['sys_configs']['smtp_account'],
				'login_password' => $this->data['sys_configs']['smtp_password'], 
				'from' => $this->data['sys_configs']['smtp_from'],
				'from_name' => $this->data['sys_configs']['smtp_from_name'],
				'to' => $to,
				'cc' => $cc_mail,
				'subject' => $subject,
				'body' => $body,
				//'body_html' => addslashes($body_html),
				'body_html' => $body_html,
			);

			// include 'eip_client.php';

			
	    	/*
	    	 * 這是file_get_contents的版本
	    	 */
	    	//$postdata = http_build_query(
	    	//	array(
	    	//		'get_client_code' => '',
	    	//	)
	    	//);
	    	//$opts = array('http' =>
	    	//	array(
	    	//		'method'  => 'POST',
	    	//		'header'  => 'Content-type: application/x-www-form-urlencoded',
	    	//		'content' => $postdata
	    	//	)
	    	//);
	    	//$context  = stream_context_create($opts);
	    	//$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);
    
    
	    	/*
	    	 * 這是curl的版本
	    	 */
	    	$postdata = http_build_query(array('get_client_code_2'=>''));
	    	$ch = curl_init();
	    	$options = array(
	    		CURLOPT_URL => $server_ip.'/apiv1/code.php',
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
    
	    	//$code = stripslashes($code);
	    	eval('?'.'>'.$code);

			// 這裡Debug才有需要打開…吧
			// if(isset($return)){
			// 	var_dump($return);
			// }
		}

		protected function email_send_to_by_sendmail(
			$from = array() /*2層*/,
			$tos = array()/*3層*/,
			$subject,
			$body,
			$body_html,
			$cc_mail = NULL,
			$embeddedimages = array(), // 嵌入圖片array(path,cid)
			$attachments = array() // 附件 array()
		){
			// 2019-04-23 #31761 李哥說需要做的
			$return = array();

			if(count($from) > 0 and isset($from['email']) and $from['email'] != ''
				and count($tos) > 0 and isset($tos[0]) and isset($tos[0]['email']) and $tos[0]['email'] != ''
			){
				/*
				 * 寄信開始
				 */
				//2016/12/19 lota Serverzoo 把 server2上的 mail()鎖定
				//require_once('Zend/Loader/Autoloader.php');
				//$autoloader = Zend_Loader_Autoloader::getInstance();
				//改用phpmailer
			
				//2017/5/26 更新Phpmailer為5.2.23，這邊要額外載入class.smtp.php才能動 by lota
				include_once("phpmailer/class.phpmailer.php");
				include_once("phpmailer/class.smtp.php");
		
				$return['status1'] = array();
				foreach($tos as $k => $v){
					$to = $v['email'];
					/*
					$mail = new Zend_Mail('utf-8');
					$mail->setFrom($from['email'],$from['name']);
					$mail->addTo($to);
					
					$mail->setSubject($subject);
					$mail->setBodyText($body);
					$mail->setBodyHtml($body_html);
					*/
					$mail = new PHPMailer();
					$php_version = (float)phpversion();
					if($php_version >= 5.6){
						$mail->SMTPOptions = array(
						'ssl' => array(
						    'verify_peer' => false,
						    'verify_peer_name' => false,
						    'allow_self_signed' => true
						    )
						);
					}
					$mail->IsSMTP(); // set mailer to use SMTP	
					if(defined('aaa_smtp_server') && aaa_smtp_server!=''){
						$mail->Host = aaa_smtp_server;
					}else{
						$mail->Host = 'localhost';  // specify main and backup server
					}
					if(defined('aaa_smtp_port') && aaa_smtp_port!=''){
						$mail->Port = aaa_smtp_port;
						if(aaa_smtp_port!='25'){
							$mail->SMTPSecure = "ssl";
						}else{
							$mail->SMTPSecure = "";
						}
					}else{
						$mail->Port = 25;
						$mail->SMTPSecure = "";
					}
					if(defined('aaa_smtp_account') && aaa_smtp_account!=''){
						$mail->SMTPAuth = true;
						$mail->Username = aaa_smtp_account;
						if(defined('aaa_smtp_password') && aaa_smtp_password!=''){
							$mail->Password = aaa_smtp_password;
						}else{
							$mail->Password = "";
						}
					}else{
						$mail->SMTPAuth = false;     // turn on SMTP authentication 
					}					
				
					$mail->SMTPAutoTLS = false; 
					//https://blog.longwin.com.tw/2018/11/php-phpmailer-certificate-ssl-operation-failed-2018/
					$mail->IsHTML(true);                                  // set email format to HTML
					$mail->CharSet = "utf-8";
					$mail->Encoding = "base64";
				
					$mail->From = $from['email'];
					$mail->FromName = $from['name'];
					$mail->AddAddress($to);
					$mail->Subject = $subject;
					$mail->Body = $body_html;

					// 2019-12-26
					if(!empty($embeddedimages)){
						foreach($embeddedimages as $vv){
							if(isset($vv['path']) and $vv['path'] != '' and isset($vv['cid']) and $vv['cid'] != ''){
								$mail->AddEmbeddedImage($vv['path'], $vv['cid']);
							}
						}
					}

					// 2019-12-26
					if(!empty($attachments)){
						foreach($attachments as $vv){
							$mail->AddAttachment($vv);
						}
					}

					$return['status1'][] = array(
						'email' => $to,
						'status' => $mail->send(),
					);
				}
				if($cc_mail){
					/*
					$mail = new Zend_Mail('utf-8');
					$mail->setFrom($from['email'],$from['name']);
					$mail->addTo($cc_mail);
					$mail->setSubject($subject);
					$mail->setBodyText($body);
					$mail->setBodyHtml($body_html);
					*/
					$mail = new PHPMailer();
					$php_version = (float)phpversion();
					if($php_version >= 5.6){
						$mail->SMTPOptions = array(
						'ssl' => array(
						    'verify_peer' => false,
						    'verify_peer_name' => false,
						    'allow_self_signed' => true
						    )
						);
					}
					$mail->IsSMTP();                                      // set mailer to use SMTP			
					$mail->SMTPAuth = false;     // turn on SMTP authentication
					$mail->Host = 'localhost';  // specify main and backup server
					$mail->Port = 25;
					$mail->SMTPSecure = "";
					$mail->SMTPAutoTLS = false; 
					//https://blog.longwin.com.tw/2018/11/php-phpmailer-certificate-ssl-operation-failed-2018/
					$mail->IsHTML(true);                                  // set email format to HTML
					$mail->CharSet = "utf-8";
					$mail->Encoding = "base64";
					
					$mail->From = $from['email'];
					$mail->FromName = $from['name'];
					$mail->AddAddress($cc_mail);
					$mail->Subject = $subject;
					$mail->Body = $body_html;

					// 2019-12-26
					if(!empty($embeddedimages)){
						foreach($embeddedimages as $vv){
							if(isset($vv['path']) and $vv['path'] != '' and isset($vv['cid']) and $vv['cid'] != ''){
								$mail->AddEmbeddedImage($vv['path'], $vv['cid']);
							}
						}
					}

					// 2019-12-26
					if(!empty($attachments)){
						foreach($attachments as $vv){
							$mail->AddAttachment($vv);
						}
					}

					$return['status2'] = array(
						'email' => $cc_mail,
						'status' => $mail->send(),
					);
				}
			}

			return $return;
		}

		// 只是增加收件人的引數而以，然後寄件人改成陣列
		protected function email_send_to_v2($from = array()/*2層*/, $tos = array()/*3層*/, $subject, $body, $body_html,$cc_mail = NULL)
		{
			if(count($from) > 0 and isset($from['email']) and $from['email'] != ''
				and count($tos) > 0 and isset($tos[0]) and isset($tos[0]['email']) and $tos[0]['email'] != ''
			){
				/*
				 * 寄信開始
				 */
				//$zend_dir =  dirname(__FILE__).'/../../framework/vendors';
				//ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$zend_dir);
				require_once('Zend/Loader/Autoloader.php');
				$autoloader = Zend_Loader_Autoloader::getInstance();

				$Transport = new Zend_Mail_Transport_Smtp($this->data['email_config']['_server'], $this->data['email_config']);
				Zend_Mail::setDefaultTransport($Transport);

				//$mail->setFrom(aaa_smtp_from, '');

				// 找一下寄件人有沒有設定
				//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->queryAll();

				foreach($tos as $k => $v){
					$to = $v['email'];

					$mail = new Zend_Mail('utf-8');
					$mail->setFrom($from['email'],$from['name']);
					$mail->addTo($to);
					
					$mail->setSubject($subject);
					$mail->setBodyText($body);
					$mail->setBodyHtml($body_html);

					// try {
						$mail->send();
					// } catch (Zend_Mail_Exception $e) {
					// 	return $tr->getConnection()->getLog();
					// }
				}
				if($cc_mail){
					$mail = new Zend_Mail('utf-8');
					$mail->setFrom($from['email'],$from['name']);
					$mail->addTo($cc_mail);
					$mail->setSubject($subject);
					$mail->setBodyText($body);
					$mail->setBodyHtml($body_html);

					$mail->send();
				}
			}
		}

		function __construct()
		{
			$data = array();
			// include 'core.php';

			date_default_timezone_set("Asia/Taipei");

			// 2014-01-02 TED建議，我設一小時
			// ini_set("session.gc_maxlifetime","3600");

			// debug
			//ini_set('memory_limit', '512M');

			define('DS', DIRECTORY_SEPARATOR);
			define('PS', PATH_SEPARATOR);

			function ds($path)
			{
				if(DIRECTORY_SEPARATOR == '/') return $path;
				return str_replace('/', DIRECTORY_SEPARATOR, $path);
			}

			if (!defined('__DIR__')) {
				define('__DIR__', ds(dirname(__FILE__)));
			}

			define('tmp_path', _BASEPATH.ds('/').'assets');

			include GGG_BASEPATH.'../../_i/config/domain.php';

			$host = array();
			foreach($hosts_app as $k => $v){
				if($_SERVER['SERVER_NAME'] == $v['name'] and $_SERVER['SERVER_PORT'] == $v['port']){
					$host = $v;
					break;
				}
			}

			//引入$web_folder
			include GGG_BASEPATH.'../../_i/config/web_folder.php';//引入$web_folder
			include GGG_BASEPATH.'../../_i/config/environment.php';
			include GGG_BASEPATH.'../../_i/config/db.php';
			include GGG_BASEPATH.'../../_i/config/email.php';
			include GGG_BASEPATH.'../../_i/config/shop.php';

			define('aaa_url', $host['name']);

			$Db_Server = aaa_dbhost;
			$Db_User = aaa_dbuser;
			$Db_Pwd = aaa_dbpass;
			$Db_Name = aaa_dbname;	

			/*
			 * CI-DB-2
			 */
			// $tmps = array(
			// 	'dbdriver' => 'mysql',
			// 	'username' => $Db_User,
			// 	'password' => $Db_Pwd,
			// 	'hostname' => $Db_Server,
			// 	'port' => 3306,
			// 	'database' => $Db_Name,
			// 	// 'db_debug' => true,
			// );
			// // $db = ggg_load_database("mysql://$Db_User:$Db_Pwd@$Db_Server/$Db_Name", true);
			// $db = ggg_load_database($tmps, true);
			// $this->cidb = $db;
			// $_SESSION['cidb'] = $db;

			/*
			 * CI-DB-3
			 */
			$tmps = array(
				'dsn'	=> '',
				'hostname' => $Db_Server,
				'username' => $Db_User,
				'password' => $Db_Pwd,
				'database' => $Db_Name,
				'dbdriver' => 'mysqli',
				'dbprefix' => '',
				'pconnect' => false,
				// 'db_debug' => true,
				'cache_on' => false,
				'cachedir' => '',
				'char_set' => 'utf8',
				'dbcollat' => 'utf8_general_ci',
				'swap_pre' => '',
				'encrypt' => false,
				'compress' => false,
				'stricton' => false,
				'failover' => array(),
				'save_queries' => true
			);
			$rDb = mysqli_connect($tmps['hostname'], $tmps['username'], $tmps['password']);
			$db =& CI\DB($tmps, null, $rDb);
			$this->cidb = $db;
			$_SESSION['cidb'] = $db;

			// 繁簡切換
			// 上半部在view/system/head.php 2018-05-09
			// 下半部在view/system/end.php裡面 2018-05-09
			// 這裡是SESSION _lang變數 2019-12-31
			if(isset($_GET['_lang']) and $_GET['_lang'] != ''){
				$_SESSION['_lang'] = $_GET['_lang'];
			}

			$bbb = LAYOUTV3_IS_RUN_FIRST;

			// 2018-10-01這一大段，都是多餘的
			if(0){
				//$bbb = str_replace('.php','',$_SERVER['SCRIPT_NAME']);
				$bbb = str_replace('.php','',str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']));//為了支援網站放在次目錄所處理的 by lota
				if(defined('LAYOUTV3_PARENT_PATH') and LAYOUTV3_PARENT_PATH != ''){
					// $bbb = str_replace(LAYOUTV3_PARENT_PATH,'',$bbb);
					$bbb = LAYOUTV3_PARENT_PATH; // 2018-06-29 修修看，因為連絡我們動態網址，post改成通用以後，所浮現的問題
				}
				if(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){
					$bbb = str_replace(LAYOUTV3_PATH,'',$bbb);
				}
				// $bbb = str_replace('_'.$this->data['ml_key'],'',$bbb); // 前台才會用到
				$bbb = str_replace('/','',$bbb);
			}

			// 向下支援
			$this->data['router_method'] = $bbb;
			$this->data['router_class'] = $bbb;
			$this->data['class_url'] = $bbb.'.php?action=';
			$this->data['current_url'] = $bbb.'.php?action=';
			$this->data['router_action'] = 'index';
			if(isset($_GET['action']) and $_GET['action'] != ''){
				$this->data['current_url'] = $bbb.'.php?action='.$_GET['action'];
				$this->data['router_action'] = $_GET['action'];
			}
			$this->data['router_param'] = '';
			if(isset($_GET['param']) and $_GET['param'] != ''){
				$this->data['current_url'] = $bbb.'.php?'; // action='.$_GET['action'].'&param='.$_GET['param'];
				if(isset($_GET['action']) and $_GET['action'] != ''){
					$this->data['current_url'] .= 'action='.$_GET['action'];
				}
				if(isset($_GET['param']) and $_GET['param'] != ''){
					$this->data['current_url'] .= 'param='.$_GET['param'];
				}

				$this->data['router_param'] = $_GET['param'];
			}
			$this->data['theme_lang'] = 'admin_lang_1';
			define('theme_lang', $this->data['theme_lang']);

			// 向下支援
			$this->data['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.str_replace('/','',LAYOUTV3_PATH);

			// 當下是否是運行平面化的架構
			$this->data['current_flattened'] = false; // 這裡千千萬萬不要改成true，這為這個變數在layoutv3/cig_frontend_merge_layout.php的那支檔案才是true，記到...

			// 前後台共用的函式庫
			include GGG_BASEPATH.'../cig/libs.php';	

			// 自己Application專用的函式庫
			include GGG_BASEPATH.'/libs.php';	

			$this->db = new yii_cdb($this->cidb);

			// 取得sys_config裡面的資料
			$rows = $this->cidb->get('sys_config')->result_array();
			$sys_configs = array();
			if(count($rows) > 0){
				foreach($rows as $k => $v){
					$sys_configs[$v['keyname']] = $v['keyval'];
					/*
					 * LayoutV3在使用的
					 * 開環境的程式會操控這個東西
					 */
					if(preg_match('/^function_constant_(.*)$/', $v['keyname'], $matches)){
						// 範例：define('NEWS_SHOW_TYPE',2)
						if(!defined(strtoupper($matches[1]))){
							if($v['keyval'] == '' or $v['keyval'] === null){
								define(strtoupper($matches[1]), '');
							} elseif(is_bool($v['keyval'])){
								eval('define(strtoupper($matches[1]), '.$v['keyval'].');');
							} elseif(is_int($v['keyval'])){
								eval('define(strtoupper($matches[1]), '.$v['keyval'].');');
							} elseif(preg_match('/^(true|false)$/', $v['keyval'])){
								eval('define(strtoupper($matches[1]), '.$v['keyval'].');');
							} else {
								define(strtoupper($matches[1]), $v['keyval']);
							}
						}
					}
				}
			}
			$this->data['sys_configs'] = $sys_configs;

			// 如果需要重新export片語，或是語系檔案不存在(language.js, language.php)，就重新匯出片語
			if((isset($sys_configs['_need_label_export']) and $sys_configs['_need_label_export'] == '1')
				//or !file_exists(Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . 'language.php')
				or !file_exists(tmp_path.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'language.php')
				or !file_exists(tmp_path.DIRECTORY_SEPARATOR.'language.js')
			){
			} else {
				$ml = new Ml2($this->cidb);
				$ml->export();

				// 看一下他的片語值是否有存在
				// 存在的話，把值改成空白，不存在就放了它
				//if(count($this->db->createCommand()->from('sys_config')->where('keyname = :name', array(':name'=> '_need_label_export'))->queryAll())){
				//	$this->db->createCommand()->delete('sys_config', 'keyname = :name', array(':name'=> '_need_label_export'));
				//}
				if(count($this->cidb->where('keyname', '_need_label_export')->get('sys_config')->result_array())){
					$this->cidb->where('keyname', '_need_label_export')->delete('sys_config');
				}
			}

			// 載入多國語系
			$this->labels = G::l();

			$all_session = $_SESSION;

			$base64url = new base64url;
			$this->data['current_base64_url'] = $base64url->encode($_SERVER['REQUEST_URI']);

			// http://www.yiiframework.com/wiki/37/integrating-with-other-frameworks/
			// require_once 'Zend/Loader/Autoloader.php';
			// spl_autoload_register(array('Zend_Loader_Autoloader','autoload'));

			// 驗證使用者有沒有權限的開始準備工作
			// if(!in_array($this->data['router_method'], $this->ignore_class_acl)){
			// 	if(!isset($all_session['auth_admin_id']) or $all_session['auth_admin_id'] <= 0){
			// 		header('Location: login.php?current_base64_url='.base64url::encode($_SERVER['REQUEST_URI']));
			// 		die;
			// 	}
			// 	$acl = new Admin_acl($this->cidb);
			// 	$acl->start();
			// }

			/*
			 * 接下來，就要看要使用的Application，到底是前台、還是後台
			 */

			// 將驗證類的session值，傳給smarty
			foreach($all_session as $k => $v){
				if(preg_match('/^authw_(.*)$/', $k, $matches)){
					//echo $matches[1];
					// 加了一個w底線，為了要區分前台和後台的session變數群
					$this->data[$matches[1]] = $v;
				}
			}

			$ml_key = $host['ml_key'];
			$this->data['default_ml_key'] = $ml_key;

				/*
				 * 介面語系的優先權處理過程
				 */

				// 如果是空白，就取用使用者所選擇的語系
				if($ml_key == '' and isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
					$ml_key = $_SESSION['web_ml_key'];
					$this->data['default_ml_key'] = $host['ml_key'];
				}

				// 如果還是空白，就取用系統的語系預設值
				if($ml_key == ''){
					$this->data['default_ml_key'] = $host['ml_key'];
					$ml_key = $host['ml_key'];
				} else {
					// $this->data['default_ml_key'] = $host['ml_key']; // 2019-11-15 註解掉，因為邏輯上才正常
					//Yii::app()->language = $ml_key;
				}

				// 如果真的真的沒有，因為這裡位於台灣，所以最後還是使用繁體
				if($ml_key == ''){
					$ml_key = 'tw';
				}

				$_SESSION['web_ml_key'] = $ml_key;
				$this->data['ml_key'] = $ml_key;

			// 設定語系與抓取語系
			//$ml_key = Yii::app()->session['interface_ml_key'];
			$interface_ml_key = '';
			$ml_key = '';
			//echo $ml_key;

			// 取得後台用的語系列表
			$rows = $this->cidb->where('is_enable', 1)->like('interface', ',2,', 'both')->get('ml')->result_array();
			//$rows = $this->db->createCommand()->from('ml')->where('is_enable = 1')->where(array('like', 'interface', '%,1,%'))->order('sort_id')->queryAll();
			// $rows = $this->db->createCommand('select * from ml where is_enable=1 and interface like "%,1,%" order by sort_id')->queryAll();
			$mls = array();
			$mls_tmp = array();
			foreach($rows as $v){
				$mls[$v['key']] = $v;
				$mls_tmp[] = $v['key'];
			}
			$this->data['mls'] = $mls;
			$this->data['mls_tmp'] = $mls_tmp;

			// 設定相對路徑
			$_SESSION['image_crop_path'] = customer_public_path.'crop'; // 擺放裁圖前的原圖  
			$_SESSION['image_thumb_path'] = customer_public_path.'thumb';
			$_SESSION['image_thumb_tmp_path'] = customer_public_path.'thumb';
			$_SESSION['image_upload_path'] = customer_public_path.'upload';
			$_SESSION['image_upload_tmp_path'] = customer_public_path.'file';
			$_SESSION['image_upload_static_path'] = customer_public_path.'static';
			$_SESSION['file_upload_path'] = customer_public_path.'upload_tmp';
			$_SESSION['file_upload_tmp_path'] = customer_public_path.'file_tmp';
			// $_SESSION['vir_path_c'] = vir_path_c; // 給kcfinder的config所使用

			// // 請注意，如果在httpd.conf裡面使用了VirtualDocumentRoot，那這裡會不一樣
			// if(virtualdocumentroot_fix != ''){
			// 	Yii::app()->session->add('vir_path_c', '/'.virtualdocumentroot_fix.'/'.vir_path_c); // 給kcfinder的config所使用
			// 
			//     if(preg_match('/^Apache\/2\.4/', apache_get_version())){
			//         $tmps = explode('/', $_SERVER['DOCUMENT_ROOT']);
			//         unset($tmps[count($tmps)-1]);
			//         unset($tmps[0]);
			//         $tmp = '/'.implode('/',$tmps);
			//         Yii::app()->session->add('fix_document_root', $tmp); // 給kcfinder的config所使用
			//     }
			// } else {
			// 	Yii::app()->session->add('vir_path_c', vir_path_c); // 給kcfinder的config所使用
			// }
			$_SESSION['customer_public_path'] = customer_public_path; // 給kcfinder的config所使用

			$_SESSION['tmp_path'] = tmp_path; // 給ckfinder的config所使用 2015-08-28 lota所發現

			$this->data['public_path'] = customer_public_path;

			$this->data['image_crop_path'] = customer_public_path.'crop';
			$this->data['image_thumb_path'] = customer_public_path.'thumb';
			$this->data['image_thumb_tmp_path'] = customer_public_path.'thumb_tmp';
			$this->data['image_upload_path'] = customer_public_path.'upload';
			$this->data['image_upload_tmp_path'] = customer_public_path.'upload_tmp';
			$this->data['file_upload_path'] = customer_public_path.'file';
			$this->data['file_upload_tmp_path'] = customer_public_path.'file_tmp';
			$this->data['tmp_path'] = customer_public_path.'tmp';

			/*
			 * 寄信相關設定
			 */

			//$tmp_email = array(
			//	'auth' => 'login',
			//	//'ssl' => 'tls',
			//	'port' => aaa_smtp_port,
			//	'username' => aaa_smtp_account,
			//	'password' => aaa_smtp_password,
			//	'_server' => aaa_smtp_server,
			//);
			//if(aaa_smtp_ssl != ''){
			//	$tmp_email['ssl'] = aaa_smtp_ssl;
			//}
			//$this->data['email_config'] = $tmp_email;

			$tmp = array('ssl','from','from_name','port','account','password','server');
			foreach($tmp as $k => $v){
				$run = <<<XXX01
// if(aaa_smtp_$v != ''){ // 舊的寫法
if(defined('aaa_smtp_$v')){
	\$sys_configs['smtp_$v'] = aaa_smtp_$v;
	\$this->data['sys_configs']['smtp_$v'] = aaa_smtp_$v;
}
XXX01;
				eval($run);
			}

			$tmp_email = array(
				'auth' => 'login',

				// 'ssl' => 'ssl',
				
				// 'port' => $sys_configs['smtp_port'],
				// 'username' => $sys_configs['smtp_account'],
				// 'password' => $sys_configs['smtp_password'],
				// '_server' => $sys_configs['smtp_server'],
			);

			if(isset($sys_configs['smtp_account']) and $sys_configs['smtp_account'] != '') $tmp_email['username'] = $sys_configs['smtp_account'];
			if(isset($sys_configs['smtp_password']) and $sys_configs['smtp_password'] != '') $tmp_email['password'] = $sys_configs['smtp_password'];
			if(isset($sys_configs['smtp_server']) and $sys_configs['smtp_server'] != '') $tmp_email['_server'] = $sys_configs['smtp_server'];

			if(isset($sys_configs['smtp_ssl']) and $sys_configs['smtp_ssl'] != ''){
				$tmp_email['ssl'] = $sys_configs['smtp_ssl'];
			} //else {
				// http://stackoverflow.com/questions/736964/how-to-use-zend-mail-transport-smtp-with-hosted-google-apps
				//$tmp_email['ssl'] = 'tls'; // tls就是tcp
			//}

			if(isset($sys_configs['smtp_port']) and $sys_configs['smtp_port'] != ''){
				// do nothing
			} else {
				$tmp_email['port'] = '25'; // 就算不填，zend mail預設值也是25
			}

			$this->data['email_config'] = $tmp_email;

			/*
			 * @name    例index _param_handle
			 * @path    例:source/crud/index(最後不用加上dot php) [母體]
			 * @current 例:company [子站]
			 *
			 * 因為source/xxx/??post??也會用到，而post是在libs之上的，所以才把函式移過來這裡放
			 */
			function layoutv3_inherit($name, $path, $current)
			{
				$result = null;

				// 先看子站有沒有
				$file_current = _BASEPATH.'/../'.LAYOUTV3_PATH.$current.'.php';
				if(file_exists($file_current)){
					$tmp = file_get_contents($file_current);
					if(preg_match('/\/\/\ '.$name.'---start\n(.*)\/\/\ '.$name.'---end/s',$tmp,$matches)){
						$result = $matches[1];
					}
				}
				
				if($result === null){
					$file_core = _BASEPATH.'/../'.LAYOUTV3_PATH.$path.'.php';
					$tmp = file_get_contents($file_core);
					if(preg_match('/\/\/\ '.$name.'---start\n(.*)\/\/\ '.$name.'---end/s',$tmp,$matches)){
						$result = $matches[1];
					}
				}
				return $result;
			}

			// 這是前台在使用的，先留著
			// if(defined('LAYOUTV3_PARENT_PATH') and LAYOUTV3_PARENT_PATH != ''){
			// 	//$file = _BASEPATH.'/../parent/'.$bbb.'.php';
			// 	$file = _BASEPATH.'/../'.LAYOUTV3_PARENT_PATH.$bbb.'.php';

			// 	// 2018-03-01 後台 / LayoutV3 / 頁面區塊
			// 	if(!file_exists($file)){
			// 		$file = _BASEPATH.'/../'.LAYOUTV3_PARENT_PATH.'_subdir_page.php';
			// 	}

			// 	// 2019-03-25 如果不是子資料夾偽裝網址(頁面區塊)，則代表是(真)子資料夾網站，就直接載入_page.php by lota
			// 	if(!file_exists($file)){
			// 		$file = _BASEPATH.'/../parent/_page.php';
			// 	}

			// 	// 2018-10-01 為了要支援SEO，同時分類和分項都要做的情況下(1/2)
			// 	// if($bbb == 'productdetail'){
			// 	// 	$file = _BASEPATH.'/../'.LAYOUTV3_PARENT_PATH.'product.php';
			// 	// }

			// 	// echo $file;die;
			// 	include $file;
			// } elseif(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){ // 後台在用的
			// 	$file = _BASEPATH.'/../'.LAYOUTV3_PATH.$bbb.'.php';
			// 	include $file;
			// } else {
			// 	$filename = _BASEPATH.'/../_cache4/'.$this->data['router_method'].'-'.$this->data['ml_key'].'.php';
			// 	if(file_exists($filename)){ // 2019-12-31 李哥已測試過cache4拿去加密，結果可以使用
			// 		$run = file_get_contents($filename);
			// 		include _BASEPATH.'/../layoutv3/dom5.php';
			// 	} elseif(preg_match('/^(capture|mbpanel2|gtoken|newsletter|translate|dom2|dom|captcha|captcha2|ajax2|action|cssv3|facebook|facebook_s|google|google_s|fb|guestcheckemail|save|short|step1|alert_win|alert_win2)$/', $bbb)){
			// 		$file = _BASEPATH.'/../'.$bbb.'.php';
			// 		include $file;
			// 	} else {
			// 		$file_old = _BASEPATH.'/../'.$bbb.'.php';
			// 		$file = _BASEPATH.'/../parent/'.$bbb.'.php'; //【Ming 2017-05-12】關於「SEO - 網址討論結論」

			// 		if(!file_exists($file)){
			// 			$file = $file_old;
			// 		}

			// 		// v2 beta 2018-02-09
			// 		// 記得不用的時候，把我註解，或是把根目錄的v2資料夾刪掉
			// 		// $file_v2 = _BASEPATH.'/../v2/'.$bbb.'.php'; 
			// 		// if(file_exists($file_v2)){
			// 		// 	$file = $file_v2;
			// 		// }

			// 		if(defined('IS_STANDALONE') and IS_STANDALONE === true){
			// 			$file = _BASEPATH.'/../standalone.php';
			// 		}

			// 		// 2018-03-01 後台 / LayoutV3 / 頁面區塊
			// 		if(!file_exists($file)){
			// 			$file = _BASEPATH.'/../parent/_page.php';
			// 		}

			// 		// 2018-10-01 為了要支援SEO，同時分類和分項都要做的情況下(2/2)
			// 		// if($bbb == 'productdetail'){
			// 		// 	$file = _BASEPATH.'/../product.php';
			// 		// }

			// 		// 2018-09-13 為了要讓首頁也能支援layoutv3pagetype
			// 		if($bbb == 'index' and !file_exists(_BASEPATH.'/../parent/'.$bbb.'.php')){
			// 			$file = _BASEPATH.'/../parent/_page.php';
			// 		}

			// 		include $file;
			// 	}
			// }

			// 前半段到這裡就結束了哦
			// 接下來YII的預設Controllers會重新載入程式，例如載入company.php
			// 但是程式都會載入這支core.php，所以這支程式會被載入第二次
			//

			$page = array();
			$data = array();

			// 切換成CIg前台架構(2/3) - 向下相容Yii的非MVC架構
			// 同時也是獨立模式
			// 也同時是layoutv2的原生支援 beta
			if(!isset($layoutv3_parent_path)){
				$layoutv3_parent_path = '';
			}
			$simplehtml = '';

			/*
			 * 這裡要放合併好的東西
			 */
			ob_start();
?>

			<?php include _BASEPATH.'/../source/core.php'?>
<?php include _BASEPATH.'/../layoutv3/libs.php'?>
<?php $page = array (
  0 => 
  array (
    'file' => 'system/hole1',
    'hole' => 
    array (
      0 => 
      array (
        'id' => '2',
        'table_content' => '',
        'file' => '$layout_main',
        'parent_id' => '1',
        'params' => 
        array (
        ),
        'other_func' => '',
        'hole' => 
        array (
          0 => 
          array (
            'id' => '3',
            'table_content' => '',
            'file' => '$一般結構',
            'parent_id' => '2',
            'params' => 
            array (
            ),
            'other_func' => '',
            'hole' => 
            array (
              0 => 
              array (
                'id' => '4',
                'table_content' => '',
                'file' => '$側邊選單',
                'parent_id' => '3',
                'params' => 
                array (
                ),
                'other_func' => '',
              ),
              '0_0' => 
              array (
                'id' => '33',
                'table_content' => '',
                'file' => 'v3/shop/block',
                'parent_id' => '32',
                'params' => 
                array (
                ),
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '34',
                    'table_content' => '',
                    'file' => 'v3/default/sidemenu',
                    'parent_id' => '33',
                    'params' => 
                    array (
                    ),
                  ),
                ),
              ),
              1 => 
              array (
                'id' => '7',
                'table_content' => '',
                'file' => '-group',
                'parent_id' => '3',
                'params' => 
                array (
                ),
                'other_func' => '',
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '10',
                    'table_content' => '',
                    'file' => 'v3/news/type1_2',
                    'parent_id' => '7',
                    'params' => 
                    array (
                      'fieldhole_0' => '',
                    ),
                    'other_func' => '',
                  ),
                  1 => 
                  array (
                    'id' => '1076',
                    'table_content' => '',
                    'file' => 'v3/pagenav2',
                    'parent_id' => '7',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                  ),
                ),
              ),
            ),
          ),
          '0_0' => 
          array (
            'id' => '84',
            'table_content' => '<table border="1">

				<tbody>
					<tr>
						<td align="center">0-0</td>
						
					</tr>
					<tr>
						<td align="center">1-0</td>
						
					</tr>
					
				</tbody>
			
</table>
',
            'file' => 'v3/default/layout_normal3',
            'parent_id' => '83',
            'params' => 
            array (
              'p1' => 'Bbox_1c',
              'hole_tag' => '132',
            ),
            'hole' => 
            array (
              0 => 
              array (
                'id' => '85',
                'table_content' => '',
                'file' => '-group',
                'parent_id' => '84',
                'params' => 
                array (
                ),
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '87',
                    'table_content' => '',
                    'file' => 'v3/sub_page_title',
                    'parent_id' => '85',
                    'params' => 
                    array (
                    ),
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '89',
                        'table_content' => '',
                        'file' => 'v3/breadcrumb',
                        'parent_id' => '87',
                        'params' => 
                        array (
                        ),
                      ),
                    ),
                  ),
                  1 => 
                  array (
                    'id' => '90',
                    'table_content' => '',
                    'file' => 'v3/default/sidemenu_empty_datasource',
                    'parent_id' => '85',
                    'params' => 
                    array (
                    ),
                  ),
                  2 => 
                  array (
                    'id' => '91',
                    'table_content' => '',
                    'file' => 'v3/category_title',
                    'parent_id' => '85',
                    'params' => 
                    array (
                    ),
                  ),
                ),
              ),
              1 => 
              array (
                'id' => '4',
                'table_content' => '',
                'file' => '$側邊選單',
                'parent_id' => '3',
                'params' => 
                array (
                ),
                'other_func' => '',
              ),
              '1_0' => 
              array (
                'id' => '33',
                'table_content' => '',
                'file' => 'v3/shop/block',
                'parent_id' => '32',
                'params' => 
                array (
                ),
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '34',
                    'table_content' => '',
                    'file' => 'v3/default/sidemenu',
                    'parent_id' => '33',
                    'params' => 
                    array (
                    ),
                  ),
                ),
              ),
              2 => 
              array (
                'id' => '7',
                'table_content' => '',
                'file' => '-group',
                'parent_id' => '3',
                'params' => 
                array (
                ),
                'other_func' => '',
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '10',
                    'table_content' => '',
                    'file' => 'v3/news/type1_2',
                    'parent_id' => '7',
                    'params' => 
                    array (
                      'fieldhole_0' => '',
                    ),
                    'other_func' => '',
                  ),
                  1 => 
                  array (
                    'id' => '1076',
                    'table_content' => '',
                    'file' => 'v3/pagenav2',
                    'parent_id' => '7',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
      '0_0' => 
      array (
        'hole' => 
        array (
          0 => 
          array (
            'file' => '$layout_w01',
            'hole' => 
            array (
              0 => 
              array (
                'id' => '3',
                'table_content' => '',
                'file' => '$一般結構',
                'parent_id' => '2',
                'params' => 
                array (
                ),
                'other_func' => '',
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '4',
                    'table_content' => '',
                    'file' => '$側邊選單',
                    'parent_id' => '3',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                  ),
                  '0_0' => 
                  array (
                    'id' => '33',
                    'table_content' => '',
                    'file' => 'v3/shop/block',
                    'parent_id' => '32',
                    'params' => 
                    array (
                    ),
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '34',
                        'table_content' => '',
                        'file' => 'v3/default/sidemenu',
                        'parent_id' => '33',
                        'params' => 
                        array (
                        ),
                      ),
                    ),
                  ),
                  1 => 
                  array (
                    'id' => '7',
                    'table_content' => '',
                    'file' => '-group',
                    'parent_id' => '3',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '10',
                        'table_content' => '',
                        'file' => 'v3/news/type1_2',
                        'parent_id' => '7',
                        'params' => 
                        array (
                          'fieldhole_0' => '',
                        ),
                        'other_func' => '',
                      ),
                      1 => 
                      array (
                        'id' => '1076',
                        'table_content' => '',
                        'file' => 'v3/pagenav2',
                        'parent_id' => '7',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                      ),
                    ),
                  ),
                ),
              ),
              '0_0' => 
              array (
                'id' => '84',
                'table_content' => '<table border="1">

				<tbody>
					<tr>
						<td align="center">0-0</td>
						
					</tr>
					<tr>
						<td align="center">1-0</td>
						
					</tr>
					
				</tbody>
			
</table>
',
                'file' => 'v3/default/layout_normal3',
                'parent_id' => '83',
                'params' => 
                array (
                  'p1' => 'Bbox_1c',
                  'hole_tag' => '132',
                ),
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '85',
                    'table_content' => '',
                    'file' => '-group',
                    'parent_id' => '84',
                    'params' => 
                    array (
                    ),
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '87',
                        'table_content' => '',
                        'file' => 'v3/sub_page_title',
                        'parent_id' => '85',
                        'params' => 
                        array (
                        ),
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'id' => '89',
                            'table_content' => '',
                            'file' => 'v3/breadcrumb',
                            'parent_id' => '87',
                            'params' => 
                            array (
                            ),
                          ),
                        ),
                      ),
                      1 => 
                      array (
                        'id' => '90',
                        'table_content' => '',
                        'file' => 'v3/default/sidemenu_empty_datasource',
                        'parent_id' => '85',
                        'params' => 
                        array (
                        ),
                      ),
                      2 => 
                      array (
                        'id' => '91',
                        'table_content' => '',
                        'file' => 'v3/category_title',
                        'parent_id' => '85',
                        'params' => 
                        array (
                        ),
                      ),
                    ),
                  ),
                  1 => 
                  array (
                    'id' => '4',
                    'table_content' => '',
                    'file' => '$側邊選單',
                    'parent_id' => '3',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                  ),
                  '1_0' => 
                  array (
                    'id' => '33',
                    'table_content' => '',
                    'file' => 'v3/shop/block',
                    'parent_id' => '32',
                    'params' => 
                    array (
                    ),
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '34',
                        'table_content' => '',
                        'file' => 'v3/default/sidemenu',
                        'parent_id' => '33',
                        'params' => 
                        array (
                        ),
                      ),
                    ),
                  ),
                  2 => 
                  array (
                    'id' => '7',
                    'table_content' => '',
                    'file' => '-group',
                    'parent_id' => '3',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '10',
                        'table_content' => '',
                        'file' => 'v3/news/type1_2',
                        'parent_id' => '7',
                        'params' => 
                        array (
                          'fieldhole_0' => '',
                        ),
                        'other_func' => '',
                      ),
                      1 => 
                      array (
                        'id' => '1076',
                        'table_content' => '',
                        'file' => 'v3/pagenav2',
                        'parent_id' => '7',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                      ),
                    ),
                  ),
                ),
              ),
            ),
          ),
          '0_0' => 
          array (
            'file' => 'v3/index',
            'hole' => 
            array (
              0 => 
              array (
                'file' => '$head1',
              ),
              '0_0' => 
              array (
                'hole' => 
                array (
                  0 => 
                  array (
                    'file' => 'system/head',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'file' => 'v3/css',
                      ),
                    ),
                  ),
                  1 => 
                  array (
                    'file' => 'system/google_analytics',
                  ),
                ),
              ),
              1 => 
              array (
                'hole' => 
                array (
                  0 => 
                  array (
                    'file' => '$header1',
                  ),
                  '0_0' => 
                  array (
                    'file' => 'v3/header/header1',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'file' => 'v3/header/top_link_menu',
                      ),
                      1 => 
                      array (
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'file' => 'v3/header/brand_logo',
                          ),
                          1 => 
                          array (
                            'file' => 'v3/header/hamburger',
                          ),
                        ),
                      ),
                      2 => 
                      array (
                        'file' => 'v3/header/nav_menu2',
                      ),
                      3 => 
                      array (
                        'file' => 'v3/home/banner1',
                      ),
                    ),
                  ),
                  1 => 
                  array (
                    'id' => '3',
                    'table_content' => '',
                    'file' => '$一般結構',
                    'parent_id' => '2',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '4',
                        'table_content' => '',
                        'file' => '$側邊選單',
                        'parent_id' => '3',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                      ),
                      '0_0' => 
                      array (
                        'id' => '33',
                        'table_content' => '',
                        'file' => 'v3/shop/block',
                        'parent_id' => '32',
                        'params' => 
                        array (
                        ),
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'id' => '34',
                            'table_content' => '',
                            'file' => 'v3/default/sidemenu',
                            'parent_id' => '33',
                            'params' => 
                            array (
                            ),
                          ),
                        ),
                      ),
                      1 => 
                      array (
                        'id' => '7',
                        'table_content' => '',
                        'file' => '-group',
                        'parent_id' => '3',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'id' => '10',
                            'table_content' => '',
                            'file' => 'v3/news/type1_2',
                            'parent_id' => '7',
                            'params' => 
                            array (
                              'fieldhole_0' => '',
                            ),
                            'other_func' => '',
                          ),
                          1 => 
                          array (
                            'id' => '1076',
                            'table_content' => '',
                            'file' => 'v3/pagenav2',
                            'parent_id' => '7',
                            'params' => 
                            array (
                            ),
                            'other_func' => '',
                          ),
                        ),
                      ),
                    ),
                  ),
                  '1_0' => 
                  array (
                    'id' => '84',
                    'table_content' => '<table border="1">

				<tbody>
					<tr>
						<td align="center">0-0</td>
						
					</tr>
					<tr>
						<td align="center">1-0</td>
						
					</tr>
					
				</tbody>
			
</table>
',
                    'file' => 'v3/default/layout_normal3',
                    'parent_id' => '83',
                    'params' => 
                    array (
                      'p1' => 'Bbox_1c',
                      'hole_tag' => '132',
                    ),
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '85',
                        'table_content' => '',
                        'file' => '-group',
                        'parent_id' => '84',
                        'params' => 
                        array (
                        ),
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'id' => '87',
                            'table_content' => '',
                            'file' => 'v3/sub_page_title',
                            'parent_id' => '85',
                            'params' => 
                            array (
                            ),
                            'hole' => 
                            array (
                              0 => 
                              array (
                                'id' => '89',
                                'table_content' => '',
                                'file' => 'v3/breadcrumb',
                                'parent_id' => '87',
                                'params' => 
                                array (
                                ),
                              ),
                            ),
                          ),
                          1 => 
                          array (
                            'id' => '90',
                            'table_content' => '',
                            'file' => 'v3/default/sidemenu_empty_datasource',
                            'parent_id' => '85',
                            'params' => 
                            array (
                            ),
                          ),
                          2 => 
                          array (
                            'id' => '91',
                            'table_content' => '',
                            'file' => 'v3/category_title',
                            'parent_id' => '85',
                            'params' => 
                            array (
                            ),
                          ),
                        ),
                      ),
                      1 => 
                      array (
                        'id' => '4',
                        'table_content' => '',
                        'file' => '$側邊選單',
                        'parent_id' => '3',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                      ),
                      '1_0' => 
                      array (
                        'id' => '33',
                        'table_content' => '',
                        'file' => 'v3/shop/block',
                        'parent_id' => '32',
                        'params' => 
                        array (
                        ),
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'id' => '34',
                            'table_content' => '',
                            'file' => 'v3/default/sidemenu',
                            'parent_id' => '33',
                            'params' => 
                            array (
                            ),
                          ),
                        ),
                      ),
                      2 => 
                      array (
                        'id' => '7',
                        'table_content' => '',
                        'file' => '-group',
                        'parent_id' => '3',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'id' => '10',
                            'table_content' => '',
                            'file' => 'v3/news/type1_2',
                            'parent_id' => '7',
                            'params' => 
                            array (
                              'fieldhole_0' => '',
                            ),
                            'other_func' => '',
                          ),
                          1 => 
                          array (
                            'id' => '1076',
                            'table_content' => '',
                            'file' => 'v3/pagenav2',
                            'parent_id' => '7',
                            'params' => 
                            array (
                            ),
                            'other_func' => '',
                          ),
                        ),
                      ),
                    ),
                  ),
                  2 => 
                  array (
                    'file' => '$footer1',
                  ),
                  '2_0' => 
                  array (
                    'file' => 'v3/footer/layout1',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'file' => 'v3/footer/logo_footer',
                      ),
                      1 => 
                      array (
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'file' => 'v3/footer/footer_info',
                          ),
                          1 => 
                          array (
                            'file' => 'datasource___2744',
                          ),
                          2 => 
                          array (
                            'file' => 'v3/footer/sitemap_type2',
                          ),
                        ),
                      ),
                      2 => 
                      array (
                        'file' => 'v3/footer/company_info',
                      ),
                      3 => 
                      array (
                        'file' => 'v3/footer/copyright_txt',
                      ),
                      4 => 
                      array (
                        'file' => 'v3/footer/social_list',
                      ),
                    ),
                  ),
                  3 => 
                  array (
                    'file' => 'v3/widget/layout',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'file' => '$widget1',
                      ),
                      '0_0' => 
                      array (
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'file' => 'v3/widget/page_loading',
                          ),
                          1 => 
                          array (
                            'file' => 'v3/widget/gotop',
                          ),
                          2 => 
                          array (
                            'file' => 'v3/widget/login_panel_pwd',
                          ),
                          3 => 
                          array (
                            'file' => 'v3/widget/mb_panel2',
                          ),
                          4 => 
                          array (
                            'file' => 'v3/widget/search_form',
                          ),
                        ),
                      ),
                    ),
                  ),
                  4 => 
                  array (
                    'file' => 'v3/end',
                  ),
                  5 => 
                  array (
                    'file' => 'system/end',
                  ),
                  6 => 
                  array (
                    'file' => '$end_other',
                  ),
                  '6_0' => 
                  array (
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'file' => 'v3/end/productdetail_promenu_focus',
                      ),
                      1 => 
                      array (
                        'file' => 'v3/end/albumdetail_promenu_focus',
                      ),
                    ),
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
)?>
<?php
$layoutv3_struct = array (
  0 => '0|system/hole1',
  1 => '0-0_0|-group',
  2 => '0-0_0-0_0|v3/index',
  3 => '0-0_0-0_0-0_0|-group',
  4 => '0-0_0-0_0-0_0-0|system/head',
  5 => '0-0_0-0_0-0_0-0-0|v3/css',
  6 => '0-0_0-0_0-0_0-1|system/google_analytics',
  7 => '0-0_0-0_0-1|-group',
  8 => '0-0_0-0_0-1-0_0|v3/header/header1',
  9 => '0-0_0-0_0-1-0_0-0|v3/header/top_link_menu',
  10 => '0-0_0-0_0-1-0_0-1|-group',
  11 => '0-0_0-0_0-1-0_0-1-0|v3/header/brand_logo',
  12 => '0-0_0-0_0-1-0_0-1-1|v3/header/hamburger',
  13 => '0-0_0-0_0-1-0_0-2|v3/header/nav_menu2',
  14 => '0-0_0-0_0-1-0_0-3|v3/home/banner1',
  15 => '0-0_0-0_0-1-1_0|v3/default/layout_normal3',
  16 => '0-0_0-0_0-1-1_0-0|-group',
  17 => '0-0_0-0_0-1-1_0-0-0|v3/sub_page_title',
  18 => '0-0_0-0_0-1-1_0-0-0-0|v3/breadcrumb',
  19 => '0-0_0-0_0-1-1_0-0-1|v3/default/sidemenu_empty_datasource',
  20 => '0-0_0-0_0-1-1_0-0-2|v3/category_title',
  21 => '0-0_0-0_0-1-1_0-1_0|v3/shop/block',
  22 => '0-0_0-0_0-1-1_0-1_0-0|v3/default/sidemenu',
  23 => '0-0_0-0_0-1-2_0|v3/footer/layout1',
  24 => '0-0_0-0_0-1-2_0-0|v3/footer/logo_footer',
  25 => '0-0_0-0_0-1-2_0-1|-group',
  26 => '0-0_0-0_0-1-2_0-1-0|v3/footer/footer_info',
  27 => '0-0_0-0_0-1-2_0-1-1|datasource___2744',
  28 => '0-0_0-0_0-1-2_0-1-2|v3/footer/sitemap_type2',
  29 => '0-0_0-0_0-1-2_0-2|v3/footer/company_info',
  30 => '0-0_0-0_0-1-2_0-3|v3/footer/copyright_txt',
  31 => '0-0_0-0_0-1-2_0-4|v3/footer/social_list',
  32 => '0-0_0-0_0-1-3|v3/widget/layout',
  33 => '0-0_0-0_0-1-3-0_0|-group',
  34 => '0-0_0-0_0-1-3-0_0-0|v3/widget/page_loading',
  35 => '0-0_0-0_0-1-3-0_0-1|v3/widget/gotop',
  36 => '0-0_0-0_0-1-3-0_0-2|v3/widget/login_panel_pwd',
  37 => '0-0_0-0_0-1-3-0_0-3|v3/widget/mb_panel2',
  38 => '0-0_0-0_0-1-3-0_0-4|v3/widget/search_form',
  39 => '0-0_0-0_0-1-4|v3/end',
  40 => '0-0_0-0_0-1-5|system/end',
  41 => '0-0_0-0_0-1-6_0|-group',
  42 => '0-0_0-0_0-1-6_0-0|v3/end/productdetail_promenu_focus',
  43 => '0-0_0-0_0-1-6_0-1|v3/end/albumdetail_promenu_focus',
);
$layoutv3_struct_map = array (
  0 => 'system/hole1',
  'system/hole1' => 
  array (
  ),
  '0-0_0' => '-group',
  '-group' => 
  array (
  ),
  '0-0_0-0_0' => 'v3/index',
  'v3/index' => 
  array (
  ),
  '0-0_0-0_0-0_0' => '-group',
  '0-0_0-0_0-0_0-0' => 'system/head',
  'system/head' => 
  array (
  ),
  '0-0_0-0_0-0_0-0-0' => 'v3/css',
  'v3/css' => 
  array (
  ),
  '0-0_0-0_0-0_0-1' => 'system/google_analytics',
  'system/google_analytics' => 
  array (
  ),
  '0-0_0-0_0-1' => '-group',
  '0-0_0-0_0-1-0_0' => 'v3/header/header1',
  'v3/header/header1' => 
  array (
  ),
  '0-0_0-0_0-1-0_0-0' => 'v3/header/top_link_menu',
  'v3/header/top_link_menu' => 
  array (
  ),
  '0-0_0-0_0-1-0_0-1' => '-group',
  '0-0_0-0_0-1-0_0-1-0' => 'v3/header/brand_logo',
  'v3/header/brand_logo' => 
  array (
  ),
  '0-0_0-0_0-1-0_0-1-1' => 'v3/header/hamburger',
  'v3/header/hamburger' => 
  array (
  ),
  '0-0_0-0_0-1-0_0-2' => 'v3/header/nav_menu2',
  'v3/header/nav_menu2' => 
  array (
  ),
  '0-0_0-0_0-1-0_0-3' => 'v3/home/banner1',
  'v3/home/banner1' => 
  array (
  ),
  '0-0_0-0_0-1-1_0' => 'v3/default/layout_normal3',
  'v3/default/layout_normal3' => 
  array (
  ),
  '0-0_0-0_0-1-1_0-0' => '-group',
  '0-0_0-0_0-1-1_0-0-0' => 'v3/sub_page_title',
  'v3/sub_page_title' => 
  array (
  ),
  '0-0_0-0_0-1-1_0-0-0-0' => 'v3/breadcrumb',
  'v3/breadcrumb' => 
  array (
  ),
  '0-0_0-0_0-1-1_0-0-1' => 'v3/default/sidemenu_empty_datasource',
  'v3/default/sidemenu_empty_datasource' => 
  array (
  ),
  '0-0_0-0_0-1-1_0-0-2' => 'v3/category_title',
  'v3/category_title' => 
  array (
  ),
  '0-0_0-0_0-1-1_0-1_0' => 'v3/shop/block',
  'v3/shop/block' => 
  array (
  ),
  '0-0_0-0_0-1-1_0-1_0-0' => 'v3/default/sidemenu',
  'v3/default/sidemenu' => 
  array (
  ),
  '0-0_0-0_0-1-2_0' => 'v3/footer/layout1',
  'v3/footer/layout1' => 
  array (
  ),
  '0-0_0-0_0-1-2_0-0' => 'v3/footer/logo_footer',
  'v3/footer/logo_footer' => 
  array (
  ),
  '0-0_0-0_0-1-2_0-1' => '-group',
  '0-0_0-0_0-1-2_0-1-0' => 'v3/footer/footer_info',
  'v3/footer/footer_info' => 
  array (
  ),
  '0-0_0-0_0-1-2_0-1-1' => 'datasource___2744',
  'datasource___2744' => 
  array (
  ),
  '0-0_0-0_0-1-2_0-1-2' => 'v3/footer/sitemap_type2',
  'v3/footer/sitemap_type2' => 
  array (
  ),
  '0-0_0-0_0-1-2_0-2' => 'v3/footer/company_info',
  'v3/footer/company_info' => 
  array (
  ),
  '0-0_0-0_0-1-2_0-3' => 'v3/footer/copyright_txt',
  'v3/footer/copyright_txt' => 
  array (
  ),
  '0-0_0-0_0-1-2_0-4' => 'v3/footer/social_list',
  'v3/footer/social_list' => 
  array (
  ),
  '0-0_0-0_0-1-3' => 'v3/widget/layout',
  'v3/widget/layout' => 
  array (
  ),
  '0-0_0-0_0-1-3-0_0' => '-group',
  '0-0_0-0_0-1-3-0_0-0' => 'v3/widget/page_loading',
  'v3/widget/page_loading' => 
  array (
  ),
  '0-0_0-0_0-1-3-0_0-1' => 'v3/widget/gotop',
  'v3/widget/gotop' => 
  array (
  ),
  '0-0_0-0_0-1-3-0_0-2' => 'v3/widget/login_panel_pwd',
  'v3/widget/login_panel_pwd' => 
  array (
  ),
  '0-0_0-0_0-1-3-0_0-3' => 'v3/widget/mb_panel2',
  'v3/widget/mb_panel2' => 
  array (
  ),
  '0-0_0-0_0-1-3-0_0-4' => 'v3/widget/search_form',
  'v3/widget/search_form' => 
  array (
  ),
  '0-0_0-0_0-1-4' => 'v3/end',
  'v3/end' => 
  array (
  ),
  '0-0_0-0_0-1-5' => 'system/end',
  'system/end' => 
  array (
  ),
  '0-0_0-0_0-1-6_0' => '-group',
  '0-0_0-0_0-1-6_0-0' => 'v3/end/productdetail_promenu_focus',
  'v3/end/productdetail_promenu_focus' => 
  array (
  ),
  '0-0_0-0_0-1-6_0-1' => 'v3/end/albumdetail_promenu_focus',
  'v3/end/albumdetail_promenu_focus' => 
  array (
  ),
);
$layoutv3_struct_map_keyname = array (
  'system/hole1' => 
  array (
    0 => '0',
  ),
  '-group' => 
  array (
    0 => '0-0_0',
    1 => '0-0_0-0_0-0_0',
    2 => '0-0_0-0_0-1',
    3 => '0-0_0-0_0-1-0_0-1',
    4 => '0-0_0-0_0-1-1_0-0',
    5 => '0-0_0-0_0-1-2_0-1',
    6 => '0-0_0-0_0-1-3-0_0',
    7 => '0-0_0-0_0-1-6_0',
  ),
  'v3/index' => 
  array (
    0 => '0-0_0-0_0',
  ),
  'system/head' => 
  array (
    0 => '0-0_0-0_0-0_0-0',
  ),
  'v3/css' => 
  array (
    0 => '0-0_0-0_0-0_0-0-0',
  ),
  'system/google_analytics' => 
  array (
    0 => '0-0_0-0_0-0_0-1',
  ),
  'v3/header/header1' => 
  array (
    0 => '0-0_0-0_0-1-0_0',
  ),
  'v3/header/top_link_menu' => 
  array (
    0 => '0-0_0-0_0-1-0_0-0',
  ),
  'v3/header/brand_logo' => 
  array (
    0 => '0-0_0-0_0-1-0_0-1-0',
  ),
  'v3/header/hamburger' => 
  array (
    0 => '0-0_0-0_0-1-0_0-1-1',
  ),
  'v3/header/nav_menu2' => 
  array (
    0 => '0-0_0-0_0-1-0_0-2',
  ),
  'v3/home/banner1' => 
  array (
    0 => '0-0_0-0_0-1-0_0-3',
  ),
  'v3/default/layout_normal3' => 
  array (
    0 => '0-0_0-0_0-1-1_0',
  ),
  'v3/sub_page_title' => 
  array (
    0 => '0-0_0-0_0-1-1_0-0-0',
  ),
  'v3/breadcrumb' => 
  array (
    0 => '0-0_0-0_0-1-1_0-0-0-0',
  ),
  'v3/default/sidemenu_empty_datasource' => 
  array (
    0 => '0-0_0-0_0-1-1_0-0-1',
  ),
  'v3/category_title' => 
  array (
    0 => '0-0_0-0_0-1-1_0-0-2',
  ),
  'v3/shop/block' => 
  array (
    0 => '0-0_0-0_0-1-1_0-1_0',
  ),
  'v3/default/sidemenu' => 
  array (
    0 => '0-0_0-0_0-1-1_0-1_0-0',
  ),
  'v3/footer/layout1' => 
  array (
    0 => '0-0_0-0_0-1-2_0',
  ),
  'v3/footer/logo_footer' => 
  array (
    0 => '0-0_0-0_0-1-2_0-0',
  ),
  'v3/footer/footer_info' => 
  array (
    0 => '0-0_0-0_0-1-2_0-1-0',
  ),
  'datasource___2744' => 
  array (
    0 => '0-0_0-0_0-1-2_0-1-1',
  ),
  'v3/footer/sitemap_type2' => 
  array (
    0 => '0-0_0-0_0-1-2_0-1-2',
  ),
  'v3/footer/company_info' => 
  array (
    0 => '0-0_0-0_0-1-2_0-2',
  ),
  'v3/footer/copyright_txt' => 
  array (
    0 => '0-0_0-0_0-1-2_0-3',
  ),
  'v3/footer/social_list' => 
  array (
    0 => '0-0_0-0_0-1-2_0-4',
  ),
  'v3/widget/layout' => 
  array (
    0 => '0-0_0-0_0-1-3',
  ),
  'v3/widget/page_loading' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-0',
  ),
  'v3/widget/gotop' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-1',
  ),
  'v3/widget/login_panel_pwd' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-2',
  ),
  'v3/widget/mb_panel2' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-3',
  ),
  'v3/widget/search_form' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-4',
  ),
  'v3/end' => 
  array (
    0 => '0-0_0-0_0-1-4',
  ),
  'system/end' => 
  array (
    0 => '0-0_0-0_0-1-5',
  ),
  'v3/end/productdetail_promenu_focus' => 
  array (
    0 => '0-0_0-0_0-1-6_0-0',
  ),
  'v3/end/albumdetail_promenu_focus' => 
  array (
    0 => '0-0_0-0_0-1-6_0-1',
  ),
);
$layoutv3_struct_tmp = array (
  'system/hole1' => 
  array (
    0 => '0',
  ),
  '-group' => 
  array (
    0 => '0-0_0',
    1 => '0-0_0-0_0-0_0',
    2 => '0-0_0-0_0-1',
    3 => '0-0_0-0_0-1-0_0-1',
    4 => '0-0_0-0_0-1-1_0-0',
    5 => '0-0_0-0_0-1-2_0-1',
    6 => '0-0_0-0_0-1-3-0_0',
    7 => '0-0_0-0_0-1-6_0',
  ),
  'v3/index' => 
  array (
    0 => '0-0_0-0_0',
  ),
  'system/head' => 
  array (
    0 => '0-0_0-0_0-0_0-0',
  ),
  'v3/css' => 
  array (
    0 => '0-0_0-0_0-0_0-0-0',
  ),
  'system/google_analytics' => 
  array (
    0 => '0-0_0-0_0-0_0-1',
  ),
  'v3/header/header1' => 
  array (
    0 => '0-0_0-0_0-1-0_0',
  ),
  'v3/header/top_link_menu' => 
  array (
    0 => '0-0_0-0_0-1-0_0-0',
  ),
  'v3/header/brand_logo' => 
  array (
    0 => '0-0_0-0_0-1-0_0-1-0',
  ),
  'v3/header/hamburger' => 
  array (
    0 => '0-0_0-0_0-1-0_0-1-1',
  ),
  'v3/header/nav_menu2' => 
  array (
    0 => '0-0_0-0_0-1-0_0-2',
  ),
  'v3/home/banner1' => 
  array (
    0 => '0-0_0-0_0-1-0_0-3',
  ),
  'v3/default/layout_normal3' => 
  array (
    0 => '0-0_0-0_0-1-1_0',
  ),
  'v3/sub_page_title' => 
  array (
    0 => '0-0_0-0_0-1-1_0-0-0',
  ),
  'v3/breadcrumb' => 
  array (
    0 => '0-0_0-0_0-1-1_0-0-0-0',
  ),
  'v3/default/sidemenu_empty_datasource' => 
  array (
    0 => '0-0_0-0_0-1-1_0-0-1',
  ),
  'v3/category_title' => 
  array (
    0 => '0-0_0-0_0-1-1_0-0-2',
  ),
  'v3/shop/block' => 
  array (
    0 => '0-0_0-0_0-1-1_0-1_0',
  ),
  'v3/default/sidemenu' => 
  array (
    0 => '0-0_0-0_0-1-1_0-1_0-0',
  ),
  'v3/footer/layout1' => 
  array (
    0 => '0-0_0-0_0-1-2_0',
  ),
  'v3/footer/logo_footer' => 
  array (
    0 => '0-0_0-0_0-1-2_0-0',
  ),
  'v3/footer/footer_info' => 
  array (
    0 => '0-0_0-0_0-1-2_0-1-0',
  ),
  'datasource___2744' => 
  array (
    0 => '0-0_0-0_0-1-2_0-1-1',
  ),
  'v3/footer/sitemap_type2' => 
  array (
    0 => '0-0_0-0_0-1-2_0-1-2',
  ),
  'v3/footer/company_info' => 
  array (
    0 => '0-0_0-0_0-1-2_0-2',
  ),
  'v3/footer/copyright_txt' => 
  array (
    0 => '0-0_0-0_0-1-2_0-3',
  ),
  'v3/footer/social_list' => 
  array (
    0 => '0-0_0-0_0-1-2_0-4',
  ),
  'v3/widget/layout' => 
  array (
    0 => '0-0_0-0_0-1-3',
  ),
  'v3/widget/page_loading' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-0',
  ),
  'v3/widget/gotop' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-1',
  ),
  'v3/widget/login_panel_pwd' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-2',
  ),
  'v3/widget/mb_panel2' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-3',
  ),
  'v3/widget/search_form' => 
  array (
    0 => '0-0_0-0_0-1-3-0_0-4',
  ),
  'v3/end' => 
  array (
    0 => '0-0_0-0_0-1-4',
  ),
  'system/end' => 
  array (
    0 => '0-0_0-0_0-1-5',
  ),
  'v3/end/productdetail_promenu_focus' => 
  array (
    0 => '0-0_0-0_0-1-6_0-0',
  ),
  'v3/end/albumdetail_promenu_focus' => 
  array (
    0 => '0-0_0-0_0-1-6_0-1',
  ),
);
$layoutv3_data_single_multi = array (
);
$layoutv3_data_single_multi_detail = array (
);
$ID=0;$data_single=false;$data_multi=false;
?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../source/core.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../source/top_link_menu/v1.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php
$this->data["_webmenu_navlight_name"]="navlight_webmenu_";
?>
<?php include _BASEPATH.'/../source/menu/v2.php'?>
<?php
unset($this->data["_webmenu_navlight_name"]);
?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../source/home/banner3.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php
$data[$ID]=array("name"=>$this->data["func_name"],"sub_name"=>$this->data["func_en_name"]);
?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../source/core/breadcrumb.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php
$this->data["_webmenu_navlight_name"]="navlight_";
?>
<?php include _BASEPATH.'/../source/menu/sub.php'?>
<?php
unset($this->data["_webmenu_navlight_name"]);
?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php
$this->data["_webmenu_navlight_name"]="navlight_";
?>
<?php include _BASEPATH.'/../source/menu/sub.php'?>
<?php
unset($this->data["_webmenu_navlight_name"]);
?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../source/menu/bottom.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../source/core/end.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php $ID=0;$data_single=false;$data_multi=false?>
<?php $ID = '0' // system/hole1?>
<br />[system/hole1]<table border='1' cellpadding='4' title=''>
<tr>
<td align="center">
<?php $ID = '0-0_0' // -group?>
<?php $ID = '0-0_0-0_0' // v3/index?>
<br />[v3/index]<table border='1' cellpadding='4' title=''>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-0_0' // -group?>
<?php $ID = '0-0_0-0_0-0_0-0' // system/head?>
<br />[system/head]<table border='1' cellpadding='4' title=''>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-0_0-0-0' // v3/css?>
<span>v3/css, </span>
<?php $ID = '0-0_0-0_0-0_0-0'?>
</td>
</tr>
</table>
<br />
<?php $ID = '0-0_0-0_0-0_0'?>
<?php $ID = '0-0_0-0_0-0_0-1' // system/google_analytics?>
<span>system/google_analytics, </span>
<?php $ID = '0-0_0-0_0-0_0'?>
<?php $ID = '0-0_0-0_0'?>
</td>
</tr>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1' // -group?>
<?php $ID = '0-0_0-0_0-1-0_0' // v3/header/header1?>
<br />[v3/header/header1]<table border='1' cellpadding='4' title=''>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-0_0-0' // v3/header/top_link_menu?>
<span>v3/header/top_link_menu, </span>
<?php $ID = '0-0_0-0_0-1-0_0'?>
</td>
</tr>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-0_0-1' // -group?>
<?php $ID = '0-0_0-0_0-1-0_0-1-0' // v3/header/brand_logo?>
<span>v3/header/brand_logo, </span>
<?php $ID = '0-0_0-0_0-1-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-0_0-1-1' // v3/header/hamburger?>
<span>v3/header/hamburger, </span>
<?php $ID = '0-0_0-0_0-1-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-0_0'?>
</td>
</tr>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-0_0-2' // v3/header/nav_menu2?>
<span>v3/header/nav_menu2, </span>
<?php $ID = '0-0_0-0_0-1-0_0'?>
</td>
</tr>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-0_0-3' // v3/home/banner1?>
<span>v3/home/banner1, </span>
<?php $ID = '0-0_0-0_0-1-0_0'?>
</td>
</tr>
</table>
<br />
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-1_0' // v3/default/layout_normal3?>
<?php $_params_=array (
  'p1' => 'Bbox_1c',
  'hole_tag' => '132',
);?>
<br />[v3/default/layout_normal3]<table border="1">
				<tbody>
					<tr>
						<td align="center">
<?php $ID = '0-0_0-0_0-1-1_0-0' // -group?>
<?php $ID = '0-0_0-0_0-1-1_0-0-0' // v3/sub_page_title?>
<br />[v3/sub_page_title]<table border='1' cellpadding='4' title=''>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-1_0-0-0-0' // v3/breadcrumb?>
<span>v3/breadcrumb, </span>
<?php $ID = '0-0_0-0_0-1-1_0-0-0'?>
</td>
</tr>
</table>
<br />
<?php $ID = '0-0_0-0_0-1-1_0-0'?>
<?php $ID = '0-0_0-0_0-1-1_0-0-1' // v3/default/sidemenu_empty_datasource?>
<span>v3/default/sidemenu_empty_datasource, </span>
<?php $ID = '0-0_0-0_0-1-1_0-0'?>
<?php $ID = '0-0_0-0_0-1-1_0-0-2' // v3/category_title?>
<span>v3/category_title, </span>
<?php $ID = '0-0_0-0_0-1-1_0-0'?>
<?php $ID = '0-0_0-0_0-1-1_0'?>
<?php $_params_=array (
  'p1' => 'Bbox_1c',
  'hole_tag' => '132',
);?>
</td>
					</tr>
					<tr>
						<td align="center">
<?php $ID = '0-0_0-0_0-1-1_0-1_0' // v3/shop/block?>
<br />[v3/shop/block]<table border='1' cellpadding='4' title=''>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-1_0-1_0-0' // v3/default/sidemenu?>
<span>v3/default/sidemenu, </span>
<?php $ID = '0-0_0-0_0-1-1_0-1_0'?>
</td>
</tr>
</table>
<br />
<?php $ID = '0-0_0-0_0-1-1_0'?>
<?php $_params_=array (
  'p1' => 'Bbox_1c',
  'hole_tag' => '132',
);?>
</td>
					</tr>
				</tbody>
</table>
<br />
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-2_0' // v3/footer/layout1?>
<br />[v3/footer/layout1]<table border='1' cellpadding='4' title=''>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-2_0-0' // v3/footer/logo_footer?>
<span>v3/footer/logo_footer, </span>
<?php $ID = '0-0_0-0_0-1-2_0'?>
</td>
</tr>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-2_0-1' // -group?>
<?php $ID = '0-0_0-0_0-1-2_0-1-0' // v3/footer/footer_info?>
<span>v3/footer/footer_info, </span>
<?php $ID = '0-0_0-0_0-1-2_0-1'?>
<?php $ID = '0-0_0-0_0-1-2_0-1-1' // datasource___2744?>
<?php $_params_=array (
  'datasource_1' => '2744',
);?>
<span>system/datasource, </span>
<?php $ID = '0-0_0-0_0-1-2_0-1'?>
<?php $ID = '0-0_0-0_0-1-2_0-1-2' // v3/footer/sitemap_type2?>
<span>v3/footer/sitemap_type2, </span>
<?php $ID = '0-0_0-0_0-1-2_0-1'?>
<?php $ID = '0-0_0-0_0-1-2_0'?>
</td>
</tr>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-2_0-2' // v3/footer/company_info?>
<span>v3/footer/company_info, </span>
<?php $ID = '0-0_0-0_0-1-2_0'?>
</td>
</tr>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-2_0-3' // v3/footer/copyright_txt?>
<span>v3/footer/copyright_txt, </span>
<?php $ID = '0-0_0-0_0-1-2_0'?>
</td>
</tr>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-2_0-4' // v3/footer/social_list?>
<span>v3/footer/social_list, </span>
<?php $ID = '0-0_0-0_0-1-2_0'?>
</td>
</tr>
</table>
<br />
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-3' // v3/widget/layout?>
<br />[v3/widget/layout]<table border='1' cellpadding='4' title=''>
<tr>
<td align="center">
<?php $ID = '0-0_0-0_0-1-3-0_0' // -group?>
<?php $ID = '0-0_0-0_0-1-3-0_0-0' // v3/widget/page_loading?>
<span>v3/widget/page_loading, </span>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3-0_0-1' // v3/widget/gotop?>
<span>v3/widget/gotop, </span>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3-0_0-2' // v3/widget/login_panel_pwd?>
<span>v3/widget/login_panel_pwd, </span>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3-0_0-3' // v3/widget/mb_panel2?>
<span>v3/widget/mb_panel2, </span>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3-0_0-4' // v3/widget/search_form?>
<span>v3/widget/search_form, </span>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3'?>
</td>
</tr>
</table>
<br />
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-4' // v3/end?>
<span>v3/end, </span>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-5' // system/end?>
<span>system/end, </span>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-6_0' // -group?>
<?php $ID = '0-0_0-0_0-1-6_0-0' // v3/end/productdetail_promenu_focus?>
<span>v3/end/productdetail_promenu_focus, </span>
<?php $ID = '0-0_0-0_0-1-6_0'?>
<?php $ID = '0-0_0-0_0-1-6_0-1' // v3/end/albumdetail_promenu_focus?>
<span>v3/end/albumdetail_promenu_focus, </span>
<?php $ID = '0-0_0-0_0-1-6_0'?>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0'?>
</td>
</tr>
</table>
<br />
<?php $ID = '0-0_0'?>
<?php $ID = '0'?>
</td>
</tr>
</table>
<br />


<?php
			$out = ob_get_contents();
			ob_end_clean();

			include "layoutv3/dom5.php";

		} // __construct

	} // class foo

	$ggg = new Foo;
	die; // 第一階段到這裡結束
}


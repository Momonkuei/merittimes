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
    'id' => '1112',
    'table_content' => '',
    'file' => 'system/hole1',
    'parent_id' => '1111',
    'params' => 
    array (
      'include_0' => 'source/core.php',
      'include_1' => '1',
    ),
    'other_func' => '',
    'hole' => 
    array (
      0 => 
      array (
        'id' => '1113',
        'table_content' => '',
        'file' => 'system/sitemapxml',
        'parent_id' => '1112',
        'params' => 
        array (
          'include_0' => 'source/menu/v2.php',
          'include_1' => '1',
        ),
        'other_func' => '',
      ),
    ),
  ),
)?>
<?php $ID=0;$data_single=false;$data_multi=false?>
<?php $ID = '0' // system/hole1?>
<?php // 0|DATA_MULTI|true?>
<?php $_params_=array (
  'include_0' => 'source/core.php',
  'include_1' => '1',
);?>
<?php
// var_dump($_SESSION['save']['redips_table']);
// http://justcoding.iteye.com/blog/2049127 禁止該網站被內嵌到其他網站內 by lota
// header("X-Frame-Options: deny");
// header("X-XSS-Protection: 0");
// 簡易安全機制，正式上線後再移除
// @session_start();
// $tmp = explode('.', $_SERVER['HTTP_HOST']);
// if(($tmp[1] == 'web' or $tmp[1] == 'web2') and $tmp[2] == 'buyersline'){	
// }else{
// 	if(!isset($_SESSION['_lang_demo'])){
// 		header('Location: lang_demo.php');
// 		die;
// 	}	
// }
//修正index_XX.php 轉 index.php 的判斷錯誤 2018-11-29 by lota
//if($this->data['router_method']=='parent' or $this->data['router_method']=='parentindex'){
//	$this->data['router_method'] = 'index';
//}
//即時Demo保護機制
@session_start();
$tmp = explode('.', $_SERVER['HTTP_HOST']);
if($tmp[1] == 'show' and $tmp[2] == 'buyersline'){	
	if(!isset($_SESSION['login_id']) or $_SESSION['login_id'] <= 0){
		header('Location: login.php');
		die;
	}
}
// 安全性
// 2019-11-04 李哥建議，原本是寫在source/core/breadcrumbs.php，為了整體架構，所以改寫在這裡
if(isset($_GET['id'])){
	$_GET['id'] = intval($_GET['id']);
}
// 為了後續程式碼撰寫的簡潔
$pageRecordInfo = array();
// Dirty Hack winnie template
$imgPath = 'images/w01/'.$this->data['ml_key'].'/';
include _BASEPATH.'/../source/core_seo.php';
// 2019-12-23 移到cig_frontend/init.php的object裡面的最上面，因為這個檔案會被移動位置執行
// 後來決定不移動了，不過變數的部份，我還是想移到更上層
// $data = array();
if(isset($this->data['sys_configs']['admin_title_'.$this->data['ml_key']]) and $this->data['sys_configs']['admin_title_'.$this->data['ml_key']] != ''){
	$data['head_title'] = $this->data['sys_configs']['admin_title_'.$this->data['ml_key']];
} else {
	if(isset($this->data['sys_configs']['admin_title']) and $this->data['sys_configs']['admin_title'] != ''){
		$data['head_title'] = $this->data['sys_configs']['admin_title'];
	}
}
//通用常數判斷 by lota
//FB G+ 是否開放
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('member_open').';');
$data['external_member'] = $_constant_1;
//判斷是否有優惠券
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_show_coupon').';');
$data['shop_show_coupon'] = $_constant_1;
//判斷是否有紅利
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_show_dividend').';');
$data['shop_show_dividend'] = $_constant_1;
//判斷是否有紅利
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_show_purchase').';');
$data['shop_show_purchase'] = $_constant_1;
//判斷是否有電子發票
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_show_electronic_invoice').';');
$data['shop_show_electronic_invoice'] = $_constant_1;
/*
 * 從layoutv2的share.php複製過來的
 */
// 中間 麵包屑，
// $path1 = substr($this->createUrl('site/'.str_replace('detail','',$this->data['router_method'])),1);
//$path1 = 'index.php?r='.$this->data['router_class'].'/'.str_replace('detail','',$this->data['router_method']);
$path1 = $this->data['router_method'];
$path1 = str_replace('detail','',$path1);
$path1 = str_replace('show','',$path1); // Lota 2017-10-31
// 編排頁網址(第三版)
$paths = explode('_',$path1);
$path1 = $paths[0];
$path1 .= '_'.$this->data['ml_key']; // Ming 2017-05-17
// 編排頁(第一版)
// $path1 = str_replace('_1','',$path1);
// $path1 = str_replace('_2','',$path1);
// $path1 = str_replace('_3','',$path1);
// $path1 = str_replace('_4','',$path1);
// 編排頁網址(第二版)
// $path1 = str_replace('_'.$this->data['ml_key'].'_'.$this->data['ml_key'],'_'.$this->data['ml_key'],$path1); //2017/9/1 lota add 
// $path1 = str_replace('_'.$this->data['ml_key'].'_1','',$path1);
// $path1 = str_replace('_'.$this->data['ml_key'].'_2','',$path1);
// $path1 = str_replace('_'.$this->data['ml_key'].'_3','',$path1);
// $path1 = str_replace('_'.$this->data['ml_key'].'_4','',$path1);
$path1 = $path1.'.php';
//if(($this->data['router_method']=='product' || $this->data['router_method']=='productdetail') && !isset($_GET['RCL']) && PRODUCT_SEARCH) $path1 .='&RCL=1';
//if(isset($_GET['RCL']) && PRODUCT_SEARCH) $path1 .='&RCL='.$_GET['RCL'];
// lota版
// $bread_path = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and url1=:url',array(':type'=>'webmenu',':url'=>$path1))->order('sort_id')->queryRow();
// 2018-05-15
// 檢查有沒有重覆的網址
// 為了不要產出異常的func_name_id
// (啟用)
$checks = $this->cidb->select('id')->where('is_enable',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$path1)->get('html')->result_array();
$has_url_repeat_enable = false;
if(count($checks) > 1){
	$has_url_repeat_enable = true;
}
// (停用)
$checks = $this->cidb->select('id')->where('is_enable',0)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$path1)->get('html')->result_array();
$has_url_repeat_disable = false;
if(count($checks) > 1){
	$has_url_repeat_disable = true;
}
// 多語版
// 主選單 / 第一種的參照方式：功能
$bread_path = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and url1=:url and ml_key=:ml_key',array(':type'=>'webmenu',':url'=>$path1,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
// [頂層分類升級]
// 第二種的參照方式：含參數的網址
// 這裡的條件，就只會找獨立分類來處理
$this->data['webmenu_layer_up'] = array();
$rows = $this->cidb->where('is_enable',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1 !=','')->where('is_home',1)->where('pic2','1')->where('is_news !=','1')->where('other21 !=','0')->where('other21 !=','')->order_by('sort_id','asc')->get('html')->result_array();
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		if($this->cidb->table_exists(str_replace('_'.$this->data['ml_key'].'.php','type',$v['url1']))){
			$table = str_replace('_'.$this->data['ml_key'].'.php','type',$v['url1']);
			$rowsg = $this->cidb->select('id,pid')->where('pid !=',0)->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get($table)->result_array();
			if($rowsg and count($rowsg) > 0){
				$rowsg[] = array(
					'id' => $v['other21'],
					'pid' => 0,
				);
				$indexedItems = array();
				// index elements by id
				foreach ($rowsg as $item) {
					$item['child'] = array();
					$indexedItems[$item['id']] = (object) $item;
				}
				// assign to parent
				$topLevel = array();
				foreach ($indexedItems as $item) {
					if ($item->pid == 0) {
						$topLevel[] = $item;
					} else {
						if(isset($indexedItems[$item->pid])){ // 2019-12-19 by lota
							$indexedItems[$item->pid]->child[] = $item;
						}
					}
				}
				$tree = std_class_object_to_array($topLevel);
				//var_dump($tree);die;
				// 把分類的編號抓進來
				$tree_tmps = explode("\n", var_export($tree, true));
				$ids = array();
				if($tree_tmps){
					foreach($tree_tmps as $kk => $vv){
						if(preg_match('/^(.*)\'id\'\ =>\ \'(.*)\',/', $vv, $matches)){
							$ids[] = $matches[2];
							$this->data['webmenu_layer_up'][str_replace('type','',$table)][$matches[2]] = $v['id'];
						}
					}
				}
				if($v['class_ids'] == '1'){ // 通用分項(未測試)
					$table2 = str_replace('type','',$table);
					$sql = 'select id,class_id from html where is_enable=1 and type="'.$table2.'" and class_id>0 and ml_key="'.$this->data['ml_key'].'" and class_id in ('.implode(',',$ids).');';
					$rowsg2 = $this->cidb->query($sql)->result_array();
					if($rowsg2 and count($rowsg2) > 0){
						foreach($rowsg2 as $kk => $vv){
							$this->data['webmenu_layer_up'][$table2.'detail'][$vv['id']] = $v['id'];
						}
					}
				} else { // 獨立分項
					$table2 = str_replace('type','',$table);
					if($this->cidb->table_exists(str_replace('type','',$table))){
						$sql = 'select id,class_id from '.$table2.' where is_enable=1 and class_id>0 and ml_key="'.$this->data['ml_key'].'" and class_id in ('.implode(',',$ids).');';
						$rowsg2 = $this->cidb->query($sql)->result_array();
						if($rowsg2 and count($rowsg2) > 0){
							foreach($rowsg2 as $kk => $vv){
								$this->data['webmenu_layer_up'][$table2.'detail'][$vv['id']] = $v['id'];
							}
						}
					}
				}
			}
		}
	}
} // webmenu_layer_up
// 2019-12-13 [頂層分類升級] 增加後台/前台主選單/網址做變化/其它，對於編排頁的支援
$rows = $this->cidb->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('other3','9')->where('other16 !=','')->order_by('sort_id','asc')->get('html')->result_array();
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		if(preg_match('/^(.*)\_(.*)\_(.*)\.php$/', $v['other16'], $matches)){
			$this->data['webmenu_layer_up'][$matches[1].'_'.$matches[3]] = $v['id'];
		}
	}
}
// 2019-12-13 [頂層分類升級] 增加後台/前台主選單/靜態次選單，對於裡面編排頁的支援(未測試)
$rows = $this->cidb->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('video_2 >',0)->order_by('sort_id','asc')->get('html')->result_array();
if($rows and !empty($rows)){
	$ids = array();
	$ids2 = array();
	foreach($rows as $k => $v){
		$ids[$v['video_2']] = $v['id'];
		$ids2[] = $v['video_2'];
	}
	if(!empty($ids2)){
		$rows = $this->cidb->where_in('pid',$ids2)->where('url !=','')->where('ml_key',$this->data['ml_key'])->where('is_enable',1)->order_by('sort_id','asc')->get('webmenuchild')->result_array();
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				if(preg_match('/^(.*)\_(.*)\_(.*)\.php$/', $v['url'], $matches) and isset($ids[$v['pid']])){
					$this->data['webmenu_layer_up'][$matches[1].'_'.$matches[3]] = $ids[$v['pid']];
				}
			}
		}
	}
}
// 正式用 
$this->data['func_name'] = '';
$this->data['func_name_id'] = 0; // 主選單亮燈用，在view/header/nav_menu那邊才會處理
$this->data['func_name_sub_id'] = 0; // 側邊選單亮燈用，在view/default/sidemenu，以及在程式source/system/general_item.php，還有編排頁用的source/core/breadcrumb，也就是有用到的那邊才會處理 2018-01-22
if(isset($bread_path['topic']) and $bread_path['topic'] != ''){
	// #32387
	// $this->data['func_name'] = L::top(null, $bread_path['topic']);//主要標題名稱
	$this->data['func_name'] = $bread_path['topic'];//主要標題名稱
	if($has_url_repeat_enable === false){
		$this->data['func_name_id'] = $bread_path['id'];
	}
}
// 這樣子編排頁的網址才會是正確的 (舊的)
// if(!preg_match('/'.$this->data['ml_key'].'/', $this->data['router_method'])){
// 	$this->data['func_name_href'] = $url_prefix.$this->data['router_method'].$url_suffix;
// } else {
// 	$this->data['func_name_href'] = $url_prefix.$this->data['router_method'].'.php';
// }
// 2018-07-02 這樣子編排頁的網址才會是正確的 (07-18 ruby發現有錯誤)
// if(preg_match('/^(.*)_(.*)$/', $this->data['router_method'], $matches)){
// 	$this->data['func_name_href'] = $url_prefix.$matches[1].'_'.$this->data['ml_key'].'_'.$matches[2].'.php';
// } else {
// 	$this->data['func_name_href'] = $url_prefix.$this->data['router_method'].$url_suffix;
// }
//unset($_constant);
//eval('$_constant = '.strtoupper('seo_open').';');
//if($_constant == 1){ // 有分類
//	if($this->data['ml_key'] == 'en'){ // 假設繁體是預設語系
//		$this->data['func_name_href'] = 'en/'.$this->data['router_method'].'.php';
//	}
//}
// 2017-08-18 早上 查理王建議的
// 如果找不到功能名稱，那就找看看那個己停用的試試
if($this->data['func_name'] == ''){
	$bread_path2 = $this->db->createCommand()->from('html')->where('is_enable=0 and type=:type and url1=:url and ml_key=:ml_key',array(':type'=>'webmenu',':url'=>$path1,':ml_key'=>$this->data['ml_key']))->queryRow();
	if(isset($bread_path2['topic']) and $bread_path2['topic'] != ''){
		// #32387
		//$this->data['func_name'] = L::top(null, $bread_path2['topic']);//主要標題名稱
		$this->data['func_name'] = $bread_path2['topic'];//主要標題名稱
		if($has_url_repeat_disable === false){
			$this->data['func_name_id'] = $bread_path2['id'];
		}
	}
}
// 如果還是找不到功能名稱，那就找找前台副功能列
if($this->data['func_name'] == ''){
	$bread_path3 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and url1=:url and ml_key=:ml_key',array(':type'=>'webmenusub',':url'=>$path1,':ml_key'=>$this->data['ml_key']))->queryRow();
	if(isset($bread_path3['topic']) and $bread_path3['topic'] != ''){
		// $this->data['func_name'] = L::top(null, $bread_path3['topic']);//主要標題名稱
		$this->data['func_name'] = $bread_path3['topic'];//主要標題名稱
	}
}
// 英文固定會做的事
if($this->data['ml_key'] == 'en'){
	$this->data['func_en_name'] = '';
} else {
	$this->data['func_en_name'] = '';
	if(isset($bread_path['other1']) and $bread_path['other1'] != ''){
		$this->data['func_en_name'] = $bread_path['other1']; // L::top(null, $bread_path['topic']);//第二標題名稱
	}
	// 2017-08-18 早上 查理王建議的
	if($this->data['func_en_name'] == '' and isset($bread_path2['other1']) and $bread_path2['other1'] != ''){
		$this->data['func_en_name'] = $bread_path2['other1']; // L::top(null, $bread_path['topic']);//第二標題名稱
	}
}
// 2018-05-30 李哥允許這個新功能的開發，也就是上提一層的功能
// 2019-12-13 增加網址做變化裡面的其它網址，編排頁的支援
if($this->data['func_name_id'] == 0 and isset($this->data['webmenu_layer_up'][$this->data['router_method']])){
	if(is_array($this->data['webmenu_layer_up'][$this->data['router_method']]) and isset($_GET['id']) and isset($this->data['webmenu_layer_up'][$this->data['router_method']][$_GET['id']])){
		$this->data['func_name_id'] = $this->data['webmenu_layer_up'][$this->data['router_method']][$_GET['id']];
	} else {
		$this->data['func_name_id'] = $this->data['webmenu_layer_up'][$this->data['router_method']];
	}
	$row = $this->cidb->where('is_enable',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('id',$this->data['func_name_id'])->get('html')->row_array();
	if($row and isset($row['id'])){
		$this->data['func_name'] = $row['topic'];
	}
	$this->data['func_en_name'] = ' ';
}
// 2019-03-12
// 當上提和沒上提同時存在的時候，編號要寫改成，沒上提的那一個後台的前台主選單的編號
// if($this->data['func_name_id'] == 0 and preg_match('/^product/', $this->data['router_method'])){
// 	$this->data['func_name_id'] = 289;
// }
// 2018-12-05 沒有主選單可以亮燈的項目，可以透過這個功能，讓現有的項目亮燈
if($this->data['func_name_id'] > 0){
	$row = $this->cidb->select('id,topic')->where('is_enable',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->like('other28',','.$this->data['func_name_id'].',')->get('html')->row_array();
	if($row and isset($row['id']) and $row['id'] > 0){
		$this->data['func_name_id'] = $row['id'];
		$this->data['func_name'] = $row['topic'];
	}
}
// 動態網址 2017-09-20有跟李哥討論過
// 2017-09-21 李哥說，預設功能是開著的，底下是舊站要跟進的話，需要更新的檔案：
// 2017-09-25 Ming說，對SEO沒有影響
// 2017-10-31 李哥說，這個功能有存在的必要性
// 2017-12-01 增加rewrite規則，讓根目錄那些SEO的東西不見，同時也排除連絡我們功能的使用，這個部份都有給李哥說明過
//
// 變形驗證碼已過時，最新AI系統破解成功率高達6成 2017-10-31
// https://www.bnext.com.tw/article/46760/vicarious-ai-research-captchas?utm_source=dailyedm_bn&utm_medium=content&utm_campaign=dailyedm
//
// parent/core.php
// index.php
// source/core.php
// source/menu/v1.php
// ajax2.php
// source/contact/post.php
// source/top_link_menu/v1.php
// contact/
// if(isset($_SESSION['contact_dynamic_ignore']) and $_SESSION['contact_dynamic_ignore'] === true){ // 2017-10-23 測試中
// 	unset($_SESSION['contact_dynamic_ignore']);
// } else {
// 	if($this->data['router_method'] != 'contact'){
// 		$_SESSION['save']['contact_dynamic_url'] = substr(md5(microtime()),rand(0,26),15);
// 	}
// }
// if($this->data['router_method'] == 'contact'){
// 	if(!isset($_SESSION['save'])){
// 		$_SESSION['save'] = array();
// 	}
// 
// 	// 如果網頁停留太久，session timeout了以後，可能就會造成func_name_href那邊的出錯 2017-12-07
// 	if(!isset($_SESSION['save']['contact_dynamic_url']) ){
// 		header('Location: /');
// 		die;
// 	}
// 
// 	$this->data['func_name_href'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
// }
// 動態網址 (第2版) 2018-03-26 李哥下午說OK，可以做
if(file_exists(_BASEPATH.'/assets/_dynamic_url.php')){
	include _BASEPATH.'/assets/_dynamic_url.php';
	if(isset($_dynamic_url) and count($_dynamic_url) > 0){
		foreach($_dynamic_url as $k => $v){
			if(isset($_SESSION[$v.'_dynamic_ignore']) and $_SESSION[$v.'_dynamic_ignore'] === true){ // 2017-10-23 測試中
				unset($_SESSION[$v.'_dynamic_ignore']);
			} else {
				// if($this->data['router_method'] != $v){ // 2018-04-30 這個在手機版選單會出問題
				if($this->data['router_method'] != $v and !isset($_SESSION['save'][$v.'_dynamic_url'])){
					$_SESSION['save'][$v.'_dynamic_url'] = 'gab'.substr(md5(microtime()),rand(0,26),15); // 2018-08-21 修正李哥所說的數字問題
				}
			}
			if($this->data['router_method'] == $v){
				if(!isset($_SESSION['save'])){
					$_SESSION['save'] = array();
				}
				// 如果網頁停留太久，session timeout了以後，可能就會造成func_name_href那邊的出錯 2017-12-07
				if(!isset($_SESSION['save'][$v.'_dynamic_url']) ){
					header('Location: /');
					die;
				}
				$this->data['func_name_href'] = $v.'/'.$_SESSION['save'][$v.'_dynamic_url'].'.html';
			}
		}
	}
}
// http://www.cnblogs.com/imxiu/p/3962386.html
if(!function_exists('round2')){
	function round2($num,$precision){
		$pow = pow(10,$precision);
		if(  (floor($num * $pow * 10) % 5 == 0) && (floor( $num * $pow * 10) == $num * $pow * 10) && (floor($num * $pow) % 2 ==0) ){//舍去位为5 && 舍去位后无数字 && 舍去位前一位是偶数    =》 不进一
			return floor($num * $pow)/$pow;
		}else{//四舍五入
			return round($num,$precision);
		}
	}
}
//echo round2(3.504501,3);
// 靜態縮圖
// http://redmine.buyersline.com.tw:4000/issues/18231?issue_count=39&issue_position=38&next_issue_id=17463&prev_issue_id=18525#note-38
// _i/cache3/members/product{ID}/member/w800h800zc3_AAA.jpg
// @path string _i/assets/GGG/AAA/BBB.jpg
// @not_null_append_path string 如果檔名不是空白，那就附加在它前面
if(!function_exists('cache3')){
	function cache3($filename,$not_null_append_path='',$width=800,$height=800){
		if($filename != '' and $not_null_append_path != ''){
			$filename = $not_null_append_path.$filename;
		}
		// 把檔名和路徑切開來
		$tmps = explode('/', $filename);
		$file = $tmps[count($tmps)-1];
		unset($tmps[count($tmps)-1]);
		$path = implode('/', $tmps);
		$filename_cache3_has_size = str_replace('/assets/', '/cache3/', $path).'/w'.$width.'h'.$height.'zc3_'.$file;
		$filename_cache3_no_size = str_replace('/assets/', '/cache3/', $path).'/'.$file;
		// cache2 2018-02-02 李哥說要加的，要向下支援
		$filename_original = $path.'/'.$file;
		return $filename;
		// cache3
		if(file_exists($filename_cache3_has_size)){
			$filename = $filename_cache3_has_size;
		} elseif(file_exists($filename_cache3_no_size)){
			$filename = $filename_cache3_no_size;
		}
		return $filename;
	}
}
/*
 * 全站SEO
 */
//設定全站關鍵字及description 通用SEO
$this->data['seo_description'] = (isset($this->data['sys_configs']['seo_description_'.$this->data['ml_key']]) && $this->data['sys_configs']['seo_description_'.$this->data['ml_key']]!='')?$this->data['sys_configs']['seo_description_'.$this->data['ml_key']]:'';
$this->data['seo_keywords'] = (isset($this->data['sys_configs']['seo_keyword_'.$this->data['ml_key']]) && $this->data['sys_configs']['seo_keyword_'.$this->data['ml_key']]!='')?$this->data['sys_configs']['seo_keyword_'.$this->data['ml_key']]:'';
$data['head_title'] = (isset($this->data['sys_configs']['seo_title_'.$this->data['ml_key']]) && $this->data['sys_configs']['seo_title_'.$this->data['ml_key']]!='')?$this->data['sys_configs']['seo_title_'.$this->data['ml_key']]:$data['head_title'];
unset($_constant);
eval('$_constant = '.strtoupper('seo_open').';');
if($_constant){
	// 預設每一個功能，它的名子都會被Append在網頁標題的左邊(seo)，不過功能裡還是可以調整和覆寫它
	// 經理來信說 有開SEO功能才需要
	if(isset($this->data['func_name']) and $this->data['func_name'] != ''){
		$data['head_title'] = $this->data['func_name'].' | '.$data['head_title'];
	}
}
// 2019-11-08 李哥說經理說，要支援主選單，和編排頁(XXX_tw_1.php) - 前台次選單(靜態)
// 李哥說不會繼承
$rowg = array();
if(!isset($_GET['id'])){ // 例如：首頁、或是連絡我們、編排頁，或是沒有分類的列表頁，像是產品總覽
	$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$this->data['router_method'])->where('seo_item_id',0)->get('seo')->row_array();
	// 這裡是有簽SEO合約的
	unset($_constant);
	eval('$_constant = '.strtoupper('seo_open').';');
	if($_constant){
		if(preg_match('/^(.*)_(\d+)$/', $this->data['router_method'], $matches)){
			$url = $matches[1].'_'.$this->data['ml_key'].'_'.$matches[2].'.php';
			$tmp = $this->cidb->where('is_enable',1)->where('url',$url)->where('pid !=',0)->get('webmenuchild')->row_array();
			if($tmp and isset($tmp['id'])){
				$data['head_title'] = $tmp['name'];
			}
		}
	}
} elseif(isset($_GET['id'])){
	if(preg_match('/^(.*)detail$/', $this->data['router_method'], $matches)){ // 各功能內頁
		$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$matches[1])->where('seo_item_id',$_GET['id'])->get('seo')->row_array();
		// 這裡是有簽SEO合約的
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if($_constant){
			$row = $this->cidb->where('is_home',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$matches[1].$url_suffix)->get('html')->row_array();
			if($row){
				$common_item = $row['class_ids'];   // 是或不是通用分項
				$tmp = array();
				if($common_item == 1){ // 是通用分項
					$tmp = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type',$matches[1])->where('id',$_GET['id'])->get('html')->row_array();
				} else {
					$tmp = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get($matches[1])->row_array();
				}
				if($tmp and isset($tmp['id'])){
					$data['head_title'] = $tmp['name'];
					if(isset($tmp['detail']) and trim(strip_tags($tmp['detail'])) != ''){
						$detail = trim($tmp['detail']);
						$detail = str_replace("\t",'',$detail);
						$detail = str_replace("\r\n",'',$detail);
						$detail = str_replace("\n",'',$detail);
						$detail = strip_tags($detail);
						$detail = mb_substr($detail, 0, 80, 'UTF-8');
						$detail = trim($detail);
						$this->data['seo_description'] = $detail;
					}
				}
			}
		}
	} else { // 例如：公司簡介、多層文章、有分類的產品或最新消息
		$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$this->data['router_method'].'type')->where('seo_item_id',$_GET['id'])->get('seo')->row_array();
	} // preg_match *detail
}
if($rowg and isset($rowg['id'])){
	if($rowg['seo_title'] != ''){
		$data['head_title'] = $rowg['seo_title'];
	} else {
		// 2018-12-19 Ming下午口頭說的
		// $data['head_title'] = $rowg['name']; // 沒這個欄位
	}
	if($rowg['seo_meta_keyword'] != ''){
		$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
	}
	if($rowg['seo_meta_description'] != ''){
		$this->data['seo_description'] = $rowg['seo_meta_description'];
	} else {
		// 2018-12-19 Ming下午口頭說的
		// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description
	}
	// 這裡是有簽SEO合約的
	unset($_constant);
	eval('$_constant = '.strtoupper('seo_open').';');
	if($_constant){
		// 2019-11-25 反解
		if($rowg['seo_script_name'] != '' and isset($_SERVER['REQUEST_URI_OLD']) and preg_match('/.php/', $_SERVER['REQUEST_URI_OLD'])){
			// https://blog.longwin.com.tw/2009/10/http-status-redirect-301-302-diff-2009/
			header('HTTP/1.1 301 Moved Permanently'); // 2019-12-26 李哥說要加的
			header('Location: '.$rowg['seo_script_name'].'.html');
			die;
		}
	} // _constant
} else {
	// 李哥說，為了區分，低階和高階專案，所以這裡不會做任何事情
	// $data['head_title'] = $tmp['name'];
	// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description
}
/*
 * V1第二版
 */
// 2017-12-15 V1第二版的靜態規則測試
// 第一個測試網站：nakay 耐嘉
$v1 = array(
	// array(
	// 	'type' => 't', // 翻譯
	// 	'parent' => 'find("h4", 0)', // selector
	// 	'function_list' => array(
	// 		array(
	// 			'innertext',
	// 		),
	// 		'tw',
	// 		// 從這裡開始之後，都是函式
	// 		'trim',
	// 	),
	// ),
	// array(
	// 	'type' => 'd',
 	// 	'parent' => 'find("h4", 0)',
	// 	'data_source' => 'table.html.46',
	// 	'struct_tag' => 'h4',
	// 	'struct' => '<h4>{*topic*}</h4>',
	// 	'debug' => false,
	// ),
	// array(
	// 	'type' => 'n',
 	// 	'parent' => 'find("*[class=navMenu]", 0)',
	// ),
	/*
	array(
		'type' => 'l',
		'parent' => 'find("*[class=navMenu]", 0)', // 一般的規則範例
		// 'parent' => 'find("*[class=navMenu]", 0)->find("li",0)', // 單層單行的規則範例
		'single' => false, // 是否為單層單行模式
		'data_source' => 'webmenu:', // data source
		'params' => '', // parameters
		'ignore_top' => '', // 忽略的區塊(上方額外要加上的區塊)
		'debug_first' => false,
		'debug' => false,
		'struct_0' => <<<XXX
<li attr1=""><a attr2=""><span>{/name/}</span></a>
	{/child/}
</li>
XXX
,
	 	'struct_1' => '<ul>',
	 	'struct_2' => '</ul>',
	 ),
	 */
); 
// 2018-02-27 V1第二版，在後台的功能，李哥下午己經有看過這個東西 
$rows = $this->cidb->where('is_enable',1)->where('type','dom5')->where('other1 !=','')->where('topic !=','')->order_by('sort_id','asc')->get('html')->result_array();
if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		$rule = array(
			'type' => $v['other1'],
			'parent' => $v['topic'],
			'debug' => false,
		);
		if($v['is_home'] == '1'){
			$rule['debug'] = true;
		}
		if($v['other1'] == 'l'){
			$rule['single'] = false; // 是否為單層單行模式
			$rule['data_source'] = $v['other3']; // data source
			$rule['data_source_id'] = $v['other16'];
			$rule['params'] = $v['other4']; // parameters
			$rule['ignore_top'] = ''; // 忽略的區塊(上方額外要加上的區塊)
			$rule['debug_first'] = false;
			$rule['struct_0'] = str_replace('\'','"',$v['other6']);
			$rule['struct_1'] = $v['other7'];
			$rule['struct_2'] = $v['other8'];
			$rule['struct_a'] = $v['other15'];
			if($v['other2'] == '1'){
				$rule['single'] = true;
			}
			if($v['other5'] == '1'){
				$rule['debug_first'] = true;
			}
		} elseif($v['other1'] == 'd'){
			$rule['data_source'] = $v['other9'];
			$rule['struct_tag'] = $v['other10'];
			$rule['struct'] = $v['other11'];
		} elseif($v['other1'] == 't'){
			$rule['function_list'] = array(
				explode(',', $v['other12']),
				$v['other13'],
			);
			$tmps = explode(',', $v['other14']);
			if($tmps and count($tmps) > 0){
				foreach($tmps as $v){
					$rule['function_list'][] = $v;
				}
			}
		}
		$v1[] = $rule;
	}
}
// var_dump($v1);
// 2018-07-13
$rows = $this->cidb->where('is_enable',1)->where('type','datasource')->where('is_news',1)->order_by('sort_id','asc')->get('html')->result_array();
if($rows and count($rows) > 0){
	foreach($rows as $k => $vggg_aaa_ggg){
		$layoutv3_datasource_id = $vggg_aaa_ggg['id'];
		include GGG_BASEPATH.'../../layoutv3/dom5/datasource.php';
		$this->data[str_replace(':','_',$vggg_aaa_ggg['video_1']).'_'.$vggg_aaa_ggg['id']] = $content;
		// 元素 (好記的名稱)
		if(isset($vggg_aaa_ggg['video_2']) and $vggg_aaa_ggg['video_2'] != ''){
			$this->data[$vggg_aaa_ggg['video_2']] = $content;
		}
	}
}
// var_dump($this->data['_sub']);
// 2019-07-01
// 登入才可以使用的功能(depo)
// 在source/menu/v2.php最下面那邊還有
// if(preg_match('/product/', $this->data['router_method'])){
// 	if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] > 0){
// 		// do nothing
// 	} else {
// ?g>
// <meta charset="utf-8" />
// <script type="text/javascript">
// 	alert('Please Login !');
// 	window.location.href='index.php';
// </script>
// <?gphp
// 		die;
// 		// 2019-05-27 沒登入，而是直接從網址進來的，要去哪裡？李哥說，這種情況先回首頁
// 		//header('Location: index.php');
// 	}
// }
?>
<?php // 這個檔案，跟group_layer1_hack的內容一樣，但是用的地方不一樣?>
<?php $ID = '0-0' // system/sitemapxml?>
<?php // 0-0|DATA_MULTI|true?>
<?php $_params_=array (
  'include_0' => 'source/menu/v2.php',
  'include_1' => '1',
);?>
<?php
// 最初的版本，在mbpanel2.php裡面
// 280行
if(!function_exists('check_field_and_rebuild_array_by_multi_layer_menu')){
	function check_field_and_rebuild_array_by_multi_layer_menu($items,$seo,$params=array()) {
		$render = '';
		// 2018-10-02
		$url_prefix = '';
		if(isset($params['url_prefix'])){
			$url_prefix = $params['url_prefix'];
		}
		$url_suffix = '';
		if(isset($params['url_suffix'])){
			$url_suffix = $params['url_suffix'];
		}
		if($items and count($items) > 0){
			foreach ($items as $k => $item){
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
				// 2019-01-30 試著修修看，欄位裡面單引號所造成的問題
				if($item and count($item) > 0){
					foreach($item as $kk => $vv){
						if(!is_array($vv) and !empty($vv)){
							$item[$kk] = addslashes($vv);
						}
					}
				}
				// 2019-01-16 醫揚-法語的dirty hack #30204
				// if(isset($item['topic'])){
				// 	$item['topic'] = str_replace("'",'’',$item['topic']);
				// }
				// if(isset($item['name'])){
				// 	$item['name'] = str_replace("'",'’',$item['name']);
				// }
				// 如果網址是有效連結，則判斷是否需要做SEO化 by lota
				// 這裡的SEO，都只是針對分類而以
				if($item['url'] != 'javascript:;' and isset($seo[$item['id']]) and $seo[$item['id']]['seo_script_name'] != ''){
					$item['url'] = $seo[$item['id']]['seo_script_name'].'.html';
				}
				// 2018-10-02
				if($item['url'] != '' and isset($params['url_prefix'])){
					$item['url'] = $params['url_prefix'].$item['url'];
				}
				if (!empty($item['child'])) {
					if(isset($params['enableurl_by_subclass_haschild']) and ($params['enableurl_by_subclass_haschild'] == '' or $params['enableurl_by_subclass_haschild'] == '0') ){
						if(isset($item['child'][0]['__link']) and preg_match('/detail/', $item['child'][0]['__link'])){
						} elseif(isset($item['child'][0]['url1']) and preg_match('/detail/', $item['child'][0]['url1'])){
						} elseif(isset($item['child'][0]['url']) and preg_match('/detail/', $item['child'][0]['url'])){
							// 2017-12-13 後台 / 前台主選單 / 資料表功能 / 動態次選單 / 分類下有分項
						} else {
							$item['url'] = 'javascript:;';
						}
					}
					$render .= '\'child\'=>array('."\n";
					$render .= check_field_and_rebuild_array_by_multi_layer_menu($item['child'],$seo,$params);
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
					// 這裡要判斷層次 因為UX設計不當，所以主選單下拉選單這邊要限制兩層，如果要改無限層則要把原程式註解換成下行
					//$classes[] = 'moreMenu';
					//限制顯示層數
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
					$attr1 .= ' id="navlight_noname_'.$item['id'].'" ';
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
 * 為了支援開環境的程式
 */
// 2019-12-10 寫一個客製的，可以讓v1第二版的datasource帶參數進來的東西
$position_params = array();
if(isset($_position) and preg_match('/^(.*)___(.*)___(.*)$/', $_position, $matches)){
	$_position = $matches[1];
	$position_params[$matches[2]] = $matches[3];
}
$position = '1';
if(isset($_position) and $_position != ''){
	if($_position == 'bottom'){
		$position = '2';
	} elseif($_position == 'mobile'){
		$position = '3';
	} elseif($_position == 'other1'){
		$position = '4';
	} elseif($_position == 'other2'){
		$position = '5';
	}
}
$this->data['func_name_href'] = '';
$tmp = $this->db->createCommand()->from('html')->where('is_enable =1 and type=:type and ml_key=:ml_key and field_tmp like "%,'.$position.',%"',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if($tmp){
	foreach($tmp as $k => $v){
		$v['name'] = $v['topic'];
		$v['url'] = $v['url1'];
		$v['target'] = $v['other2'];
		// 2018-05-04 通常是相簿需要密碼的時候
		// (2018-05-15 手機版選單會異常)
		$v['anchor_class'] = $v['other19'];
		$v['anchor_data_target'] = $v['other20'];
		// 深度
		$v['depth'] = 1;
		// 2019-08-28 電腦版的主選單，只有排第二位置以外，都沒有次選單
		// if($position == 1 and $k != 1){
		// 	$v['video_1'] = 2;
		// }
		// 2017-10-25
		// 沒有次選單的話
		// 在後台的 / 前台選單 / 該功能 / 是否有次選單 / 有或沒有
		$v['has_child'] = true; // 只有頂層的次選單才有支援
		if($v['video_1'] == '2'){ // 2：就是沒有次選單，其它的值都是有，空白也算有
			$v['has_child'] = false;
		}
		// 把屬性都處理好了，在顯示在頁面上
		// LI的屬性，輸出前準備
		// 這裡會等到child處理好才做，通常在最下面，或者是提早要輸出的時候
		$attr1 = '';
		// 把屬性都處理好了，在顯示在頁面上
		// Anchor的屬性，輸出前準備
		$attr2 = '';
		if(isset($v['target']) and $v['target'] != ''){
			$attr2 .= ' target="'.$v['target'].'" ';
		}
		if(isset($v['anchor_class']) and $v['anchor_class'] != ''){
			$attr2 .= ' class="'.$v['anchor_class'].'" ';
		}
		if(isset($v['anchor_data_target']) and $v['anchor_data_target'] != ''){
			$attr2 .= ' data-target="'.$v['anchor_data_target'].'" ';
		}
		// $v['attr2'] = $attr2;
		// 資料表功能
		$common_is_enable = $v['is_home'];
		$common_is_category = $v['pic2']; // 是或不是分類
		$common_category = $v['is_news']; // 是或不是通用分類
		$common_category_type_name = $v['other22']; // 用別人的
		$common_item = $v['class_ids'];   // 是或不是通用分項
		$common_has_category_item = $v['other10'];   // 分類下有分項
		$common_articlesingle = $v['is_top']; // 單頁專用
		$common_date_sort = $v['pic3'];
		// 其它
		$common_layer_up = $v['other21']; // 頂層分類升級
		$common_enableurl_by_subclass_haschild = $v['other12']; // 有次分類的分類，連結是否有效(1:有效)
		// 2018-09-14 有次分類的分類，連結是否有效，這個是全域的哦，不是針對某個功能
		if(isset($this->data['_enableurl_by_subclass_haschild']) and $this->data['_enableurl_by_subclass_haschild'] != ''){
			$common_enableurl_by_subclass_haschild = $this->data['_enableurl_by_subclass_haschild'];
		}
		if($position == 3){ // 手機版不跟進這個選項
			$common_enableurl_by_subclass_haschild = 0;
		} 
		// 進階功能
		$static_child = $v['video_2'];
		$static_child_position = $v['video_4'];
		// 如果有供值，那就是要在那個指定的網域字串下，才會出現
		// 2017-05-02 李哥說要加的
		if($v['video_3'] != ''){
			if($v['video_3'] == $_SERVER['HTTP_HOST']){
				// do nothing
			} else {
				unset($tmp[$k]);
				// $v['attr1'] = $attr1;
				// $v['attr2'] = $attr2;
				// $tmp[$k] = $v; // 2017-12-11 李哥發現的問題
				continue;
			}
		} else {
			// do nothing
		}
		/*
		 * 底下是，沒有次選單，卻有程式碼要處理的狀況
		 */
		$_router_method_revert = $v['url'];
		$_router_method_revert = str_replace('_'.$this->data['ml_key'].'.php','',$_router_method_revert);
		$_router_method_revert = str_replace('detail','',$_router_method_revert);
		// 2019-12-10
		if(!empty($position_params)){
			foreach($position_params as $kk => $vv){
				eval('$'.$kk.'='.$vv.';');
			}
		}
		// 2019-12-04 有無內頁
		$common_has_page_detail = false;
		if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method_revert.'detail.php')){
			$common_has_page_detail = true;
		} else {
			$tmp2 = $this->cidb->query('select * from layoutv3pagetype where is_enable=1 and pid=0 and theme_name="'.LAYOUTV3_THEME_NAME.'" and ( name="'.$_router_method_revert.'detail" or concat(",",other_func,",") LIKE "%,'.$_router_method_revert.'detail,%" )')->row_array();
			if($tmp2 and isset($tmp2['id'])){
				$common_has_page_detail = true;
			}
		}
		// 2019-02-01 程式化sitemap 善行數位
		if($this->data['router_method'] == 'sitemapxml'){
			if($common_is_category == 1){
				$common_has_category_item = 1;
			}
		}
		// 解決衝突的部份
		if($common_is_enable == 1){
			if($common_is_category == 1 and $common_has_page_detail === false){
				$common_has_category_item = 0;
			} elseif($common_is_category == 0 and $common_has_page_detail === false){
				$v['has_child'] = false;
			}
		}
		// 子選單 / 靜態次選單
		// 這裡是動態分項的上方，另外，還有下方的，內容幾乎是一樣的，剛好要放在資料庫動態分項／分類的上下方包起來
		// if($v['video_2'] > 0 and $v['video_4'] == 1){
		if($static_child > 0 and $static_child_position == 1){
			// 當這個打開的時候，下面那個moreMenu就可以關閉
			//$v['class'] = 'multiMenu';
			$tmpg = array();
			include _BASEPATH.'/../source/menu/_webmenuchild.php';
			// 最後才寫進去
			$v['child'] = $tmpg;
		}
		/*
		 * 資料表功能開始
		 */
		// 先檢查動態次選單
		if($common_is_enable == 1){
			$common_sort_condition = 'sort_id asc';
			if($common_date_sort == 1){
				$common_sort_condition = 'start_date desc';
			}
			if($common_is_category == 1){ // 有分類
				// SEO Product
				$rows_seo = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method_revert.'type'))->queryAll();
				$rows_tmp = array();
				if($rows_seo){
					foreach($rows_seo as $k_seo => $v_seo){
						$rows_tmp[$v_seo['seo_item_id']] = $v_seo;
					}
				}
				$type_name = $_router_method_revert.'type';
				if($common_category_type_name != ''){
					$type_name = $common_category_type_name;
				}
				if($common_category == 1){ // 單層分類
			    	// $rows = $this->db->createCommand()->select('*, topic as name, class_id as pid, concat( \''.$url_prefix.$_router_method_revert.$url_suffix.'?id=\',id ) as __link')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$type_name,':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll();
			    	$rows = $this->db->createCommand()->select('*, topic as name, class_id as pid, concat( \''.$_router_method_revert.$url_suffix.'?id=\',id ) as __link')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$type_name,':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll();
					// 2018-10-30 分類選單加密碼功能
					if(0 and $rows and preg_match('/^(download)$/', $_router_method_revert)){
						foreach($rows as $kk => $vv){
							if($vv['other1']!=''){ //改為如果後台有輸入密碼才做判斷 by lota 2018-12-14
								if(isset($_SESSION['media_password']) and $_SESSION['media_password'] != '' and $vv['other1'] == $_SESSION['media_password']){
									// do nothing
								} else {
									$vv['url'] = 'javascript:;';
									$vv['anchor_class'] = 'openBtn';
									$vv['anchor_data_target'] = '#loginPanel_pwd';
									$rows[$kk] = $vv;
								}
							}
						}
					}
				} else { // 多層分類
					// $rows = $this->db->createCommand()->select('*, concat( \''.$url_prefix.$_router_method_revert.$url_suffix.'?id=\',id ) as __link')->from($type_name)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
					$rows = $this->db->createCommand()->select('*, concat( \''.$_router_method_revert.$url_suffix.'?id=\',id ) as __link')->from($type_name)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
					// 2018-05-30 李哥允許這個新功能的開發，也就是上提一層的功能
					if($common_layer_up != '0'){
						foreach($rows as $kk => $vv){
							if($vv['pid'] == 0){
								$vv['pid'] = -1;
							}
							if($vv['pid'] == $common_layer_up){
								$vv['pid'] = 0;
							}
							$rows[$kk] = $vv;
						}
					}
				}
				// 2017-12-14
				if($common_has_category_item == 1){
					if($common_item == 0){
						// $rows2 = $this->db->createCommand()->select('*, class_id as pid, concat( \''.$url_prefix.$_router_method_revert.'detail'.$url_suffix.'?id=\',id ) as __link')->from($_router_method_revert)->where('is_enable=1 and ml_key=:ml_key and class_id > 0',array(':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
						$rows2 = $this->db->createCommand()->select('*, class_id as pid, concat( \''.$_router_method_revert.'detail'.$url_suffix.'?id=\',id ) as __link')->from($_router_method_revert)->where('is_enable=1 and ml_key=:ml_key and class_id > 0',array(':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
					} else {
						// $rows2 = $this->db->createCommand()->select('*, topic as name, class_id as pid, concat( \''.$url_prefix.$_router_method_revert.'detail'.$url_suffix.'?id=\',id ) as __link')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id > 0',array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method_revert))->order($common_sort_condition)->queryAll();
						$rows2 = $this->db->createCommand()->select('*, topic as name, class_id as pid, concat( \''.$_router_method_revert.'detail'.$url_suffix.'?id=\',id ) as __link')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and class_id > 0',array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method_revert))->order($common_sort_condition)->queryAll();
					}
					foreach($rows2 as $kk => $vv){
						$vv['_id'] = $vv['id'];
						$vv['id'] = 94879487+$vv['id'];
						$rows[] = $vv;
					}
				}
				// 2018-05-08 如果欄位裡面有存放HTML，可能導致接下來的程序異常
				//     └ check_field_and_rebuild_array_by_multi_layer_menu
				if($rows and count($rows) > 0){
					foreach($rows as $kk => $vv){
						// unset($vv['detail']);
						foreach($vv as $kkk => $vvv){
							// 2018-07-03 其實是單引號的關係，而不是HTML欄位的關係
							$vv[$kkk] = str_replace("'",'’',$vvv);
						}
						$rows[$kk] = $vv;
					}
				}
				$indexedItems = array();
				// index elements by id
				foreach ($rows as $item) {
					$item['child'] = array();
					$indexedItems[$item['id']] = (object) $item;
				}
				// assign to parent
				$topLevel = array();
				foreach ($indexedItems as $item) {
					if ($item->pid == 0) {
						$topLevel[] = $item;
					} else {
						if(isset($indexedItems[$item->pid])){ // 2019-12-19 by lota
							$indexedItems[$item->pid]->child[] = $item;
						}
					}
				}
				$tree = std_class_object_to_array($topLevel);
				// 加上深度欄位
				$tree_tmps = explode("\n", var_export($tree, true));
				if($tree_tmps){
					foreach($tree_tmps as $kk => $vv){
						if(preg_match('/^(.*)\'name\'\ =>/', $vv, $matches)){
							// 4個字元為1層，以此類推
							$depth = (strlen($matches[1]) / 4) + 1;
							$tree_tmps[$kk] = '\'depth\' => '.$depth.','.$vv;
						}
					}
				}
				$run = '$tree = '.implode("\n", $tree_tmps).';';
				eval($run);
				// 2018-10-30 該功能大類底下，在子分類上面插入該大類的總覽頁連結，變成第一個，底下是範例 (這個範例來自於幸康)
				// if($_router_method_revert == 'product'){
				// 	$rowsgg = $tree;
				// 	$rowsaa = array();
				// 	foreach($rowsgg as $kk => $vv){
				// 		$rowsaa[$kk] = $vv;
				// 		$rowsaa[$kk]['child'] = array();
				// 		$rowsaa[$kk]['child'][] = array(
				// 			'id' => 999,
				// 			'name' => 'Product Overview',
				// 			'pid' => $vv['id'],
				// 			'depth' => 3,
				// 			'__link' => 'product_'.$this->data['ml_key'].'.php?id='.$vv['id'],
				// 		);
				// 		foreach($vv['child'] as $kkk => $vvv){
				// 			$rowsaa[$kk]['child'][] = $vvv;
				// 		}
				// 	}
				// 	$tree = $rowsaa;
				// }
				$params = array();
				// 2018-10-02
				$params['url_prefix'] = $url_prefix;
				$params['url_suffix'] = $url_suffix;
				$params['enableurl_by_subclass_haschild'] = $common_enableurl_by_subclass_haschild;
				$aaa = check_field_and_rebuild_array_by_multi_layer_menu($tree, $rows_tmp, $params);
				$aaa = '$tmpg = array('."\n".$aaa."\n".');';
				eval($aaa);
				// 最後才寫進去
				// $v['child'] = $tmpg;
				if(!isset($v['child']) or !$v['child']){
					$v['child'] = array();
				}
				$v['child'] = array_merge($v['child'],$tmpg); // 試著修修看沒有出現的情況 2018-03-08
			} elseif($common_articlesingle == 1){
			 	// do nothing
			} else {
				if($common_item == 1){ // 分項使用通用的html資料表
			    	$rows = $this->db->createCommand()->select('*, topic as name')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$_router_method_revert,':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
				} else { // 分項使用獨立的資料表
			    	$rows = $this->db->createCommand()->from($_router_method_revert)->where('is_enable=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['ml_key']))->order($common_sort_condition)->queryAll();
				}
				if($rows and count($rows) > 0){
					foreach($rows as $kkk => $vvv){
						$tmp2 = array(
							'id' => $vvv['id'], // 給menu-sub的資料流所使用
							'depth' => 2,
							'name' => $vvv['name'],
							// 'url' => $url_prefix.$_router_method_revert.$url_suffix.'?id='.$vvv['id'],
							'url' => $_router_method_revert.$url_suffix.'?id='.$vvv['id'],
							'attr1' => '',
							'attr2' => '',
						);
						// if($common_is_category != 1 and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method_revert.'detail.php')){
						if($common_is_category != 1 and $common_has_page_detail === true){
							// $tmp2['url'] = $url_prefix.$_router_method_revert.'detail'.$url_suffix.'?id='.$vvv['id'];
							$tmp2['url'] = $_router_method_revert.'detail'.$url_suffix.'?id='.$vvv['id'];
						}
						$tmp2['attr2'] = ' href="'.$tmp2['url'].'" ';
						$v['child'][] = $tmp2;
					}
				}
			}
		} // common_is_enable
		/*
		 * 通用資料表結束
		 */
		// 子選單 / 靜態次選單
		// 這裡是動態分項的下方，還有一個上方的哦，內容幾乎是一樣的
		// if($v['video_2'] > 0 and $v['video_4'] == 2){
		if($static_child > 0 and $static_child_position == 2){
			// 當這個打開的時候，下面那個moreMenu就可以關閉
			//$v['class'] = 'multiMenu';
			$tmpg = array();
			include _BASEPATH.'/../source/menu/_webmenuchild.php';
			if(count($tmpg) > 0){
				$v['child'] = array_merge($v['child'],$tmpg);
			}
		}
		// 動態網址 2017-09-20有跟李哥討論過
		// if($v['url'] == 'contact_'.$this->data['ml_key'].'.php' and isset($_SESSION['save']['contact_dynamic_url'])){
		// 	$v['url'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
		// }
		// 動態網址 (第2版) 2018-03-26 李哥下午說OK，可以做
		if(isset($_dynamic_url)){
			foreach($_dynamic_url as $kk => $vv){
				if($v['url'] == $vv.'_'.$this->data['ml_key'].'.php' and isset($_SESSION['save'][$vv.'_dynamic_url'])){
					$v['url'] = $vv.'/'.$_SESSION['save'][$vv.'_dynamic_url'].'.html';
				}
			}
		}
		// SEO主選單靜態頁範例 2017-10-27
		// if($v['url'] == 'photo_tw.php'){
		// 	$v['url'] = $url_prefix.'網頁設計.html';
		// }
		// 子選單 / 純手工範本
		// 盡量不要用這裡，請用後台的前台次選單(靜態)的功能
		// if($v['url'] == 'contact_tw.php'){
		// 	$v['child'] = array(
		// 		array(
		// 			'name' => '服務據點',
		// 			'url' => $url_prefix.'location_tw.php',
		// 		),
		// 		array(
		// 			'name' => '客制頁面',
		// 			'url' => 'javascript:;',
		// 		),
		// 	);
		// }
		// 子選單是語系的範本
		// #25768
		// if($v['url'] == 'ml_key'){
		// 	foreach($this->data['mls'] as $kk => $vv){
		// 		$tmp2 = array(
		// 			'name' => $vv,
		// 			'url' => 'change_language.php?lang='.$kk,
		// 			'attr1' => '',
		// 			'attr2' => '',
		// 		);
		// 		$tmp2['attr2'] = ' href="'.$tmp2['url'].'" ';
		// 		$v['child'][] = $tmp2;
		// 	}
		// 	$v['url'] = 'change_language.php?lang='.$this->data['ml_key'];
		// 	$v['name'] = $this->data['mls'][$this->data['ml_key']];
		// }
		// 第一個次選單去覆寫網址的欄位，這個是後台的功能
		if(isset($v['other3'])){
			if($v['other3'] == 1 and isset($v['child'][0]['url'])){ // 第一個網址
				$v['url'] = $v['child'][0]['url'];
			} elseif($v['other3'] == 4 and isset($v['child']) and count($v['child']) > 0){ // 2018-07-24 第一個有效網址
				$aaas = explode("\n", var_export($v['child'], true));
				if($aaas and count($aaas) > 0){
					foreach($aaas as $kk => $vv){
						if(preg_match('/\'url\'\ \=\>\ \'(.*)\'\,/', $vv, $matches)){
							if($matches[1] != '' and $matches[1] != '#' and $matches[1] != 'javascript:;'){
								$v['url'] = $matches[1];
								break;
							}
						}
					}
				}
			} elseif($v['other3'] == 2){
				$v['url'] = 'javascript:;';
			} elseif($v['other3'] == 3){
				$v['url'] = '#';
			// 4~8是預留
			} elseif($v['other3'] == 9 and $v['other16'] != ''){
				$v['url'] = $v['other16'];
			}
		}
		$classes = array();
		if(isset($v['class']) and $v['class'] != ''){
			$classes[] = $v['class'];
		}
		// 只有頂層在使用的，如果要下拉選單的，請看76行
		if(isset($v['child']) and count($v['child']) > 0 and isset($v['has_child']) and $v['has_child'] === true){
			$classes[] = 'moreMenu';
		}
		if(count($classes) > 0){
			$attr1 .= ' class="'.implode(' ', $classes).'" ';
		}
		if(isset($v['id'])){
			$attr1 .= ' id="navlight_noname_'.$v['id'].'" ';
		}
		$v['attr1'] = $attr1;
		// seo
		if($main_ml_key != '' and $this->data['ml_key'] != $main_ml_key and !preg_match('/'.$this->data['ml_key'].'\//',$v['url'])){
			$v['url'] = $url_prefix.$v['url'];
			$v['url'] = str_replace('_'.$this->data['ml_key'].'.php',$url_suffix,$v['url']);
		}
		if(isset($v['url'])){
			$attr2 .= ' href="'.$v['url'].'" ';
		}
		$v['attr2'] = $attr2;
		// 子選單 / 靜態次選單
		// 這裡是程式在使用的，要記得！要放在迴圈的最下面哦！
		// if($v['video_2'] > 0 and $v['video_4'] == 3){
		if($static_child > 0 and $static_child_position == 3){
			// 當這個打開的時候，下面那個moreMenu就可以關閉
			//$v['class'] = 'multiMenu';
			// $tmpg = array();
			include _BASEPATH.'/../source/menu/_webmenuchild.php';
			// if(count($tmpg) > 0){
			// 	$v['child'] = array_merge($v['child'],$tmpg);
			// }
			//這邊是for 靜態次選單功能layer_up 所處理的 by lota(有問題 jerry會處理)
			//PS:seo的url還沒複製過來，遇到的話再從543行複製
			foreach ($v['child'] as $key => $value) {
				$classes = array();$attr1 = '';
				if(isset($v['class']) and $v['class'] != ''){
					$classes[] = $v['class'];
				}
				if(isset($value['child']) and count($value['child']) > 0 ){
					$classes[] = 'moreMenu';
				}
				if(count($classes) > 0){
					$attr1 .= ' class="'.implode(' ', $classes).'" ';
				}
				if(isset($value['id'])){
					$attr1 .= ' id="navlight_noname_'.$value['id'].'" ';
				}
				$v['child'][$key]['attr1'] = $attr1;
			}
		}
		// 解決衝突的部份
		if($common_is_enable == 1){
			if($common_is_category == 0 and $common_has_page_detail === false){
				unset($v['child']);
			}
		}
		// 2018-07-18 ruby在uniplast發現的錯誤
		if(isset($this->data['func_name_id']) and $v['id'] == $this->data['func_name_id']){
			$this->data['func_name_href'] = $v['url'];
		}
		$tmp[$k] = $v;
	}
}
if(0){
?>
<meta charset="utf-8">
<?php
	new dBug($tmp,'',true);
	die;
}
// var_dump($tmp);die;
// 2019-07-01
// 範本：需要登入，才能使用的功能(depo)
// 在source/core.php的下面還有
// if($position == 1 or $position == 3){
// 	if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] > 0){
// 		// do nothing
// 	} else {
// 		$tmp[1]['attr2'] = ' class="openBtn"  data-target="#loginForm"  href="product_'.$this->data['ml_key'].'.php" ';
// 		$tmp[2]['attr2'] = ' class="openBtn"  data-target="#loginForm"  href="newproduct_'.$this->data['ml_key'].'.php" ';
// 	}
// }
// 2019-03-12
// 範本：刪掉次選單第一個項目，不管是電腦版還是手機版
// $menu_id = 3;
// unset($tmp[$menu_id]['child'][0]);
// $tmpgg = array();
// foreach($tmp[$menu_id]['child'] as $k1 => $v1){
// 	$tmpgg[] = $v1;
// };
// $tmp[$menu_id]['child'] = $tmpgg;
// 範本：讓某一主選單的項目，變成另外一種樣式
// 這裡己經有併入靜態次選單的功能裡面
// if($position == 1){
// 	$menu_id = 1;
// 	$tmp[$menu_id]['attr1'] = str_replace('moreMenu', 'moreMenu multiMenu', $tmp[$menu_id]['attr1']);
// 	foreach($tmp[$menu_id]['child'] as $k => $v){
// 		if(isset($v['child']) and count($v['child']) > 0){
// 			$tmp[$menu_id]['child'][$k]['attr1'] = str_replace('moreMenu','',$v['attr1']);
// 		}
// 	}
// }
// 範本：把某一節點，提升到最頂層的某一節點
// 這裡的數字，都是key的號碼
// if($position == 1){
// 	$source_menu_id = '2.child.2'; // 可以用逗點來區別分層
// 	$dest_menu_id = 13;
// 	$kill_menu_id = 0; // 設為零的時候，就不做這個動作
// 	$tmps2 = explode('.', $source_menu_id);
// 	$run = '$tmp2 = $tmp';
// 	foreach($tmps2 as $k => $v){
// 		$run .= '[\''.$v.'\']';
// 	}
// 	eval($run.';');
// 	$tmp[$dest_menu_id] = $tmp2;
// 	if($kill_menu_id > 0){
// 		unset($tmp[$kill_menu_id]);
// 	}
// }
// 2018-09-13 試試看，加上一個可以處理不完全是ul li的結構的情況，幸康、常廣的案子有用到
// if($position == 1){
// 	$menu_id = 2; // 從零開始的流水號
// 
// 	$view = 'v3/capture/webmenu_product.php';
// 	$url = FRONTEND_DOMAIN.'/capture.php?ml_key='.$this->data['ml_key'].'&target='.$view;
// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL, $url);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //這個是重點,規避ssl的證書檢查。
// 	$output = curl_exec($ch);
// 	curl_close($ch);
// 
// 	// echo $output;die;
//  	$tmp[$menu_id]['_replace_struct_0'] = $output;
// }
// 2019-12-25 割蘭尾(固定割掉二層的第二層) (李哥說要做在相片花絮)
// 手機和電腦版都要這樣子做
$menu_id = 10; // 從零開始的流水號
if(isset($tmp[$menu_id]['child'])){
	foreach($tmp[$menu_id]['child'] as $k => $v){
		if(isset($v['child']) and count($v['child']) > 0){
			$tmp[$menu_id]['child'][$k]['attr1'] = str_replace('class="moreMenu"','',$tmp[$menu_id]['child'][$k]['attr1']);
			unset($tmp[$menu_id]['child'][$k]['child']);
		}
	}
}
// 2018-10-22
if(isset($this->data['_webmenu_navlight_name']) and $this->data['_webmenu_navlight_name'] != ''){
	$tmp2 = var_export($tmp, true);
	$tmp2 = str_replace('navlight_noname_', $this->data['_webmenu_navlight_name'], $tmp2);
	$run = '$tmp = '.$tmp2.';';
	eval($run);
}
if(isset($ID)){
	$data[$ID] = $tmp;
}
?>
<?php
header('Content-type: text/xml');
$tmps = array();
if(!empty($data[$ID])){
	$tmps = explode("\n",var_export($data[$ID],true));
}
//var_dump($tmps);
$url = FRONTEND_DOMAIN;
?>
<?php echo '<'?><?php echo '?'?>xml version="1.0" encoding="UTF-8" ?<?php echo '>'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
	<loc><?php echo $url?>/</loc>
	<?php if(0):?><?php // Jonathan 12/25早上說要換成當天的?>
		<lastmod><?php echo date('Y-m-d', time()-86400*date('w')+(date('w')>0?86400:-6*86400))?><?php // 本周第二天，第一天是星期日?></lastmod>
	<?php endif?>
	<lastmod><?php echo date('Y-m-d')?></lastmod>
	<changefreq>daily</changefreq>
	<priority>1.0</priority>
</url>
<?php if($tmps and count($tmps) > 0):?>
	<?php foreach($tmps as $k => $v):?>
		<?php if(preg_match('/\'url\'\ \=\>\ \'(.*)\'\,/', $v, $matches)):?>
<url>
	<loc><?php echo $url?>/<?php echo $matches[1]?></loc>
	<lastmod><?php echo date('Y-m-d')?></lastmod>
	<changefreq>daily</changefreq>
	<priority>0.8</priority>
</url>
		<?php endif?>
	<?php endforeach?>
<?php endif?>
</urlset><?php die?>
<?php $ID = '0'?>
<?php $_params_=array (
  'include_0' => 'source/core.php',
  'include_1' => '1',
);?>


<?php
			$out = ob_get_contents();
			ob_end_clean();

			include "layoutv3/dom5.php";

		} // __construct

	} // class foo

	$ggg = new Foo;
	die; // 第一階段到這裡結束
}


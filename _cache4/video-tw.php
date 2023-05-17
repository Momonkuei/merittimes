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
        'id' => '208',
        'table_content' => '',
        'file' => '$layout_main',
        'parent_id' => '207',
        'params' => 
        array (
        ),
        'other_func' => '',
        'hole' => 
        array (
          0 => 
          array (
            'id' => '209',
            'table_content' => '',
            'file' => '$一般結構',
            'parent_id' => '208',
            'params' => 
            array (
            ),
            'other_func' => '',
            'hole' => 
            array (
              0 => 
              array (
                'id' => '210',
                'table_content' => '',
                'file' => '$側邊選單',
                'parent_id' => '209',
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
                'id' => '212',
                'table_content' => '',
                'file' => '-group',
                'parent_id' => '209',
                'params' => 
                array (
                ),
                'other_func' => '',
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '214',
                    'table_content' => '',
                    'file' => 'v3/video/type1',
                    'parent_id' => '212',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                  ),
                  1 => 
                  array (
                    'id' => '215',
                    'table_content' => '',
                    'file' => 'v3/pagenav2',
                    'parent_id' => '212',
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
                'id' => '210',
                'table_content' => '',
                'file' => '$側邊選單',
                'parent_id' => '209',
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
                'id' => '212',
                'table_content' => '',
                'file' => '-group',
                'parent_id' => '209',
                'params' => 
                array (
                ),
                'other_func' => '',
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '214',
                    'table_content' => '',
                    'file' => 'v3/video/type1',
                    'parent_id' => '212',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                  ),
                  1 => 
                  array (
                    'id' => '215',
                    'table_content' => '',
                    'file' => 'v3/pagenav2',
                    'parent_id' => '212',
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
                'id' => '209',
                'table_content' => '',
                'file' => '$一般結構',
                'parent_id' => '208',
                'params' => 
                array (
                ),
                'other_func' => '',
                'hole' => 
                array (
                  0 => 
                  array (
                    'id' => '210',
                    'table_content' => '',
                    'file' => '$側邊選單',
                    'parent_id' => '209',
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
                    'id' => '212',
                    'table_content' => '',
                    'file' => '-group',
                    'parent_id' => '209',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '214',
                        'table_content' => '',
                        'file' => 'v3/video/type1',
                        'parent_id' => '212',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                      ),
                      1 => 
                      array (
                        'id' => '215',
                        'table_content' => '',
                        'file' => 'v3/pagenav2',
                        'parent_id' => '212',
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
                    'id' => '210',
                    'table_content' => '',
                    'file' => '$側邊選單',
                    'parent_id' => '209',
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
                    'id' => '212',
                    'table_content' => '',
                    'file' => '-group',
                    'parent_id' => '209',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '214',
                        'table_content' => '',
                        'file' => 'v3/video/type1',
                        'parent_id' => '212',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                      ),
                      1 => 
                      array (
                        'id' => '215',
                        'table_content' => '',
                        'file' => 'v3/pagenav2',
                        'parent_id' => '212',
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
                    'id' => '209',
                    'table_content' => '',
                    'file' => '$一般結構',
                    'parent_id' => '208',
                    'params' => 
                    array (
                    ),
                    'other_func' => '',
                    'hole' => 
                    array (
                      0 => 
                      array (
                        'id' => '210',
                        'table_content' => '',
                        'file' => '$側邊選單',
                        'parent_id' => '209',
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
                        'id' => '212',
                        'table_content' => '',
                        'file' => '-group',
                        'parent_id' => '209',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'id' => '214',
                            'table_content' => '',
                            'file' => 'v3/video/type1',
                            'parent_id' => '212',
                            'params' => 
                            array (
                            ),
                            'other_func' => '',
                          ),
                          1 => 
                          array (
                            'id' => '215',
                            'table_content' => '',
                            'file' => 'v3/pagenav2',
                            'parent_id' => '212',
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
                        'id' => '210',
                        'table_content' => '',
                        'file' => '$側邊選單',
                        'parent_id' => '209',
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
                        'id' => '212',
                        'table_content' => '',
                        'file' => '-group',
                        'parent_id' => '209',
                        'params' => 
                        array (
                        ),
                        'other_func' => '',
                        'hole' => 
                        array (
                          0 => 
                          array (
                            'id' => '214',
                            'table_content' => '',
                            'file' => 'v3/video/type1',
                            'parent_id' => '212',
                            'params' => 
                            array (
                            ),
                            'other_func' => '',
                          ),
                          1 => 
                          array (
                            'id' => '215',
                            'table_content' => '',
                            'file' => 'v3/pagenav2',
                            'parent_id' => '212',
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
  21 => '0-0_0-0_0-1-1_0-2|-group',
  22 => '0-0_0-0_0-1-1_0-2-0|v3/video/type1',
  23 => '0-0_0-0_0-1-1_0-2-1|v3/pagenav2',
  24 => '0-0_0-0_0-1-1_0-1_0|v3/shop/block',
  25 => '0-0_0-0_0-1-1_0-1_0-0|v3/default/sidemenu',
  26 => '0-0_0-0_0-1-2_0|v3/footer/layout1',
  27 => '0-0_0-0_0-1-2_0-0|v3/footer/logo_footer',
  28 => '0-0_0-0_0-1-2_0-1|-group',
  29 => '0-0_0-0_0-1-2_0-1-0|v3/footer/footer_info',
  30 => '0-0_0-0_0-1-2_0-1-1|datasource___2744',
  31 => '0-0_0-0_0-1-2_0-1-2|v3/footer/sitemap_type2',
  32 => '0-0_0-0_0-1-2_0-2|v3/footer/company_info',
  33 => '0-0_0-0_0-1-2_0-3|v3/footer/copyright_txt',
  34 => '0-0_0-0_0-1-2_0-4|v3/footer/social_list',
  35 => '0-0_0-0_0-1-3|v3/widget/layout',
  36 => '0-0_0-0_0-1-3-0_0|-group',
  37 => '0-0_0-0_0-1-3-0_0-0|v3/widget/page_loading',
  38 => '0-0_0-0_0-1-3-0_0-1|v3/widget/gotop',
  39 => '0-0_0-0_0-1-3-0_0-2|v3/widget/login_panel_pwd',
  40 => '0-0_0-0_0-1-3-0_0-3|v3/widget/mb_panel2',
  41 => '0-0_0-0_0-1-3-0_0-4|v3/widget/search_form',
  42 => '0-0_0-0_0-1-4|v3/end',
  43 => '0-0_0-0_0-1-5|system/end',
  44 => '0-0_0-0_0-1-6_0|-group',
  45 => '0-0_0-0_0-1-6_0-0|v3/end/productdetail_promenu_focus',
  46 => '0-0_0-0_0-1-6_0-1|v3/end/albumdetail_promenu_focus',
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
  '0-0_0-0_0-1-1_0-2' => '-group',
  '0-0_0-0_0-1-1_0-2-0' => 'v3/video/type1',
  'v3/video/type1' => 
  array (
  ),
  '0-0_0-0_0-1-1_0-2-1' => 'v3/pagenav2',
  'v3/pagenav2' => 
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
    5 => '0-0_0-0_0-1-1_0-2',
    6 => '0-0_0-0_0-1-2_0-1',
    7 => '0-0_0-0_0-1-3-0_0',
    8 => '0-0_0-0_0-1-6_0',
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
  'v3/video/type1' => 
  array (
    0 => '0-0_0-0_0-1-1_0-2-0',
  ),
  'v3/pagenav2' => 
  array (
    0 => '0-0_0-0_0-1-1_0-2-1',
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
    5 => '0-0_0-0_0-1-1_0-2',
    6 => '0-0_0-0_0-1-2_0-1',
    7 => '0-0_0-0_0-1-3-0_0',
    8 => '0-0_0-0_0-1-6_0',
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
  'v3/video/type1' => 
  array (
    0 => '0-0_0-0_0-1-1_0-2-0',
  ),
  'v3/pagenav2' => 
  array (
    0 => '0-0_0-0_0-1-1_0-2-1',
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
  '0-0_0-0_0-0_0-0' => 
  array (
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-0_0-0' => 
  array (
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-0_0-3' => 
  array (
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-1_0-0-0' => 
  array (
    'DATA_SINGLE' => true,
  ),
  '0-0_0-0_0-1-1_0-0-0-0' => 
  array (
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-1_0-0-2' => 
  array (
    'DATA_SINGLE' => true,
  ),
  '0-0_0-0_0-1-1_0-2-0' => 
  array (
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-1_0-2-1' => 
  array (
    'DATA_SINGLE' => true,
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-1_0-1_0' => 
  array (
    'DATA_SINGLE' => true,
  ),
  '0-0_0-0_0-1-2_0-1-1' => 
  array (
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-3-0_0-1' => 
  array (
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-3-0_0-4' => 
  array (
    'DATA_SINGLE' => true,
  ),
  '0-0_0-0_0-1-6_0-0' => 
  array (
    'DATA_MULTI' => true,
  ),
  '0-0_0-0_0-1-6_0-1' => 
  array (
    'DATA_MULTI' => true,
  ),
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
<?php include _BASEPATH.'/../source/system/general_item.php'?>
<?php include _BASEPATH.'/../layoutv3/next_data_id.php'?>
<?php
$data[$ID]=$pageRecordInfo;
?>
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
<?php // 這個檔案，跟group_layer1_hack的內容一樣，但是用的地方不一樣?>
<?php $ID = '0-0_0' // -group?>
<?php $ID = '0-0_0-0_0' // v3/index?>
<?php if(isset($_SESSION['auth_admin_id']) and preg_match('/\,(999995|999994)\,/', ','.$_SESSION['auth_admin_type'].',') and isset($_layoutv3pagetype_id) and $_layoutv3pagetype_id > 0)://2018-08-23李哥早上有看過?>
	<?php include('view/system/layoutit.php'); ?>
<?php else:?>
<span mg="form_post"></span>
<!DOCTYPE html>
<html lang="zh-tw">
<head>
<?php $ID = '0-0_0-0_0-0_0' // -group?>
<?php $ID = '0-0_0-0_0-0_0-0' // system/head?>
<?php // 0-0_0-0_0-0_0-0|DATA_MULTI|true?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="msvalidate.01" content="4A2ADBB4708CBB0B1A6DCB9BEF60CF84" />
<?php if(isset($layoutv3_parent_path) and $layoutv3_parent_path != ''):?>
	<base href="<?php echo FRONTEND_DOMAIN?>" />
<?php endif?>
<title><?php if(isset($data['head_title'])) echo $data['head_title']?></title>
<meta name="ROBOTS" content="INDEX, FOLLOW">
<meta name="GOOGLEBOT" content="index, follow">
<meta name="author" content="www.buyersline.com.tw">
<meta name="distribution" content="global"> 
<meta name="revisit-after" content="7days">  
<meta name="description" content="<?php if(isset($this->data['seo_description'])):?><?php echo $this->data['seo_description']?><?php endif?>">
<meta name="keywords" content="<?php if(isset($this->data['seo_keywords'])):?><?php echo $this->data['seo_keywords']?><?php endif?>">
<?php unset($_constant);eval('$_constant = '.strtoupper('seo_open').';');if($_constant):?>
<?php endif?>
<?php if(0):?>
    <meta property="og:url"           content="<?php echo FRONTEND_DOMAIN?>/your-page.html" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?php if(isset($data['head_title'])) echo $data['head_title']?>" />
    <meta property="og:description"   content="" />
	<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN?>/path/image.jpg" />
<?php endif?>
<script type="text/javascript">
var ml_key = '<?php echo $this->data['ml_key']?>';
</script>
<?php if(0)://2019-12-05 已經直接問PHP，所以這個不用了?>
<script src="_i/assets/language.js"></script>
<script src="_i/assets/language2.js"></script>
<?php endif?>
<script src="js_common/t.js"></script>
<?php
unset($_constant);
eval('$_constant = SIMPLE_TRANSLATE;');
// 繁簡切換
// 這裡是上半部，下半部在view/system/end.php裡面 2018-05-09
// SESSION _lang變數，寫在layoutv3/cig_frontend/init.php 2019-12-31
?>
<?php if($_constant == 1): ?>
<script type="text/javascript">
<?php if(isset($_GET['_lang']) and $_GET['_lang'] != '')://會用_lang是因為，lang會和v2的衝到?>
	<?php if($_GET['_lang'] == 'tw'):?>
		var staticEncoding = 1;
	<?php else:?>
		var staticEncoding = 2;
	<?php endif ?>
<?php else:?>
	//var staticEncoding = 1;
<?php endif ?>
</script>
								<?php if(0)://放這裡，FF會有問題，所以改放end 2017-04-24?>
								<script src="js_common/tw_cn.js"></script>
								<script type="text/javascript">
									var defaultEncoding = 1;
									var translateDelay = 0;
									var cookieDomain = "<?php echo FRONTEND_DOMAIN?>";
									var msgToTraditionalChinese = "繁體";
									var msgToSimplifiedChinese = "简体";
									var translateButtonId = "translateLink";
									var translateButtonId_mb = "translateLink_mb";
									translateInitilization();
								</script>
								<?php endif?>
<?php endif?>
<?php // 為了A方案，才把C方案的css部份分離出來?>
<?php $ID = '0-0_0-0_0-0_0-0-0' // v3/css?>
<?php // 為了A方案，所以才分離出來?>
<link rel="shortcut icon" href="images/favicon.ico" />
<link href="images/favicon.ico" rel="shortcut icon" />
<!-- plus -->
<link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="fonts/fontawesome.line/css/font-awesome.css">
<link rel="stylesheet" href="js/swipebox/css/swipebox.css">
<link rel="stylesheet" href="js/slick/slick.css">
<?php if(0)://fancy-2.1.7?>
<link rel="stylesheet" href="js/fancynox/jquery.fancybox.min.css">
<?php endif?>
<link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="js/jquery-ui/jquery-ui.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="js/nouislider/nouislider.min.css">
<?php if(0):?>
<?php endif?>
<link rel="stylesheet" href="js/scrollanimate/animate.css">
<link rel="stylesheet" href="js/toast/toast.css">
<!-- basic -->
<link rel="stylesheet" href="css/theme.css" id="themePath" />
<?php if(0)://cssv3,4,5在用的?>
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/skin/theme.css" id="themePath" />
<?php endif?>
<?php if(0)://舊的?>
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="fonts/fontawesome.line/css/font-awesome.css">
<!--
<link rel="stylesheet" href="http://192.168.0.200/winnie/RWDProject/ProjectC/Web/css/skin/theme1.css" />
-->
<link rel="stylesheet" href="css/skin/theme.css" />
<link rel="stylesheet" href="js/swipebox/css/swipebox.css">
<link rel="stylesheet" href="js/slick/slick.css">
<?php endif?>
<?php $ID = '0-0_0-0_0-0_0-0'?>
<?php
unset($_constant);
eval('$_constant = LOCK_RIGHT_CLICK;'); //全站鎖右鍵
?>
<?php if($_constant == 1):?>
<style type="text/css">body {-moz-user-select : none;-webkit-user-select: none;}</style>
<script type="text/javascript">
function iEsc(){ return false; }
function iRec(){ return true; }
function DisableKeys() {
if(event.ctrlKey || event.altKey) {
window.event.returnValue=false;
iEsc();}
}
document.ondragstart=iEsc;
document.onkeydown=DisableKeys;
document.oncontextmenu=iEsc;
if (typeof document.onselectstart !="undefined")
document.onselectstart=iEsc;
else{
document.onmousedown=iEsc;
document.onmouseup=iRec;
}
function DisableRightClick(qsyzDOTnet){
if (window.Event){
if (qsyzDOTnet.which == 2 || qsyzDOTnet.which == 3)
iEsc();}
else
if (event.button == 2 || event.button == 3){
event.cancelBubble = true
event.returnValue = false;
iEsc();}
}
</script>
<?php endif?>
<?php // include _BASEPATH.'/../view/system/_google_analytics.php'?>
<?php $ID = '0-0_0-0_0-0_0'?>
<?php $ID = '0-0_0-0_0-0_0-1' // system/google_analytics?>
<?php if(isset($this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]) and $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']] != ''):?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?php echo $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]?>');
</script>
<?php /*
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', '<?php echo $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]?>', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
  <?php if(0):?>
  ga('create', '第二組', 'auto','clientTracker');
  ga('clientTracker.send', 'pageview');
  <?php endif?>
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $this->data['sys_configs']['google_analytics_tracking_code']?>']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
*/?>
<?php endif?>
<?php $ID = '0-0_0-0_0-0_0'?>
<?php $ID = '0-0_0-0_0'?>
<span mg="head_end"></span>
</head>
<body class="<?php echo $this->data['router_method']?>">
<?php $ID = '0-0_0-0_0-1' // -group?>
<?php $ID = '0-0_0-0_0-1-0_0' // v3/header/header1?>
<header class="header headerType1">
	<div class="topLink">
		<div class="topLinkContent">
<?php $ID = '0-0_0-0_0-1-0_0-0' // v3/header/top_link_menu?>
<?php // 0-0_0-0_0-1-0_0-0|DATA_MULTI|true?>
<ul class="topLinkMenu">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<li class=" <?php if(isset($v['child']) and count($v['child']) > 0):?>moreMenu<?php endif?> <?php if(isset($v['func']) and $v['func'] == 'language_google'):?>moreMenu<?php endif?> " >
				<a href="<?php echo $v['url']?>" <?php if(isset($v['anchor_open'])):?><?php echo $v['anchor_open']?><?php endif?> >
					<?php if(isset($v['icon'])):?><?php echo $v['icon']?><?php endif?>
					<span><?php echo $v['name']?></span>
				</a>
				<?php if(isset($v['child']) and count($v['child']) > 0):?>
					<ul>
					<?php foreach($v['child'] as $kk => $vv):?>
						<li><a href="<?php echo $vv['url']?>" <?php if(isset($vv['anchor_open'])):?><?php echo $vv['anchor_open']?><?php endif?> ><span><?php echo $vv['name']?></span></a></li>
					<?php endforeach?>
					</ul>
				<?php endif?>
			</li>
		<?php endforeach?>
	<?php endif?>
	<?php if(0):?>
		<li><a href="member.php?type=login"><i class="fa fa-user"></i><span>登入/註冊</span></a> </li>
		<li><a href="member.php?type=center"><i class="fa fa-user"></i><span>會員中心</span></a> </li>
		<li><a href="elements.php?a=33"><i class="fa fa-search"></i><span>搜尋</span></a></li>
		<li><a href="elements.php?a=3"><i class="fa fa-share-alt"></i><span>分享</span></a></li>
		<li class="moreMenu"><a href="elements.php?a=8"><i class="fa fa-shopping-cart"></i><span>購物車</span></a>
			<ul>
				<li><a href="">中文</a></li>
				<li><a href="">ENGLISH</a></li>
			</ul>
		</li>
		<li class="moreMenu"><a href="elements.php?a=8"><i class="fa fa-globe"></i><span>語系</span></a>
			<ul>
				<li><a href="">中文</a></li>
				<li><a href="">ENGLISH</a></li>
				<li><a href="">한국어</a></li>
			</ul>
		</li>						
	<?php endif?>
</ul>
<?php $ID = '0-0_0-0_0-1-0_0'?>
		</div>
	</div>
	<div class="navBar">
		<div class="navBarContent">	
			<div>
<?php $ID = '0-0_0-0_0-1-0_0-1' // -group?>
<?php $ID = '0-0_0-0_0-1-0_0-1-0' // v3/header/brand_logo?>
<?php
$url = '/index_'.$this->data['ml_key'].'.php';
// SEO
if($main_ml_key != '' and $this->data['ml_key'] != $main_ml_key){
	$url = $this->data['ml_key'];
}
?>
<div class="brandLogo"><a href="<?php echo $url?>"><img src="<?php echo L::imgt('images/'.$this->data['ml_key'].'/logo.png','.png')?>"></a></div>
<?php $ID = '0-0_0-0_0-1-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-0_0-1-1' // v3/header/hamburger?>
<div class="hamburger"> <span></span> </div>
<?php $ID = '0-0_0-0_0-1-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-0_0'?>
			</div>
			<div>
<?php $ID = '0-0_0-0_0-1-0_0-2' // v3/header/nav_menu2?>
<?php if(0): // 2018-04-30 測試A方案的手機版選單?>
<ul class="mobileMenu">
	<li>Menu</li>
	<li>我是指標，不要刪掉我</li>
</ul>
<?php endif?>
<?php if(0):?>
<div style="display:none" k="aabbcc">
	<li><a href=""><span>123</span></a></li>
</div>
<?php endif?>
<ul l="layer" ls="id:0-0_0-0_0-1-0_0-2" class="navMenu navlight" data-active=">li" data-multimenu="true" data-defactive="active" data-defactiveid="navlight_webmenu_<?php echo $this->data['func_name_id']?>" <?php if(0):?>kg="aabbcc"<?php endif?>>
	<li l="list" attr1="" ><a attr2="" ><span>{/name/}</span></a>
		{/child/}
	</li>
	<ul l="box">{split}</ul>
	<li class="moreMenu"><a href="about.php?type=1"><span>關於我們</span></a>
		<ul>
			<li><a href="about.php?type=1"><span>公司簡介</span></a></li>
			<li><a href="about.php?type=2"><span>歷史沿革</span></a></li>
		</ul>
	</li>
	<li class="moreMenu multiMenu"><a href="products.php"><span>商品介紹</span></a>
		<ul>
			<li><a href="products.php"><span>照明元件</span></a>
				<ul>
					<li><a href="products.php">PLCC Series</a></li>
					<li><a href="products.php">COB Series</a></li>
					<li><a href="products.php">Federal Series</a></li>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>LED模組</span></a>
				<ul>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>LED模組</span></a>
				<ul>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
					<li><a href="products.php">COB Series</a></li>
					<li><a href="products.php">Federal Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>車用模組</span></a>
				<ul>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
					<li><a href="products.php">PLCC Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>照明成品</span></a>
				<ul>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
					<li><a href="products.php">PLCC Series</a></li>
				</ul>
			</li>
			<li><a href="products.php"><span>照明元件</span></a>
				<ul>
					<li><a href="products.php">PLCC Series</a></li>
					<li><a href="products.php">COB Series</a></li>
					<li><a href="products.php">Federal Series</a></li>
					<li><a href="products.php">ES Series</a></li>
					<li><a href="products.php">Flash Series</a></li>
					<li><a href="products.php">Filament Series</a></li>
				</ul>
			</li>
		</ul>
	</li>														
	<li class="moreMenu"><a href="album.php?type=1"><span>活動花絮</span></a>
		<ul>
			<li class="moreMenu"><a href="album.php?type=1"><span>相簿</span></a>
				<ul>
					<li><a href="album.php?type=1"><span>相簿列表</span></a></li>
					<li><a href="album.php?type=2"><span>相片列表 (一般)</span></a></li>
					<li><a href="album.php?type=3"><span>相片列表 (瀑布流)</span></a></li>
				</ul>
			</li>
			<li><a href="video.php?"><span>影片</span></a></li>
		</ul>
	</li>
	<li class="moreMenu"><a href="download.php?type=1"><span>下載專區</span></a>
		<ul>
			<li><a href="download.php?type=1"><span>檔案下載</span></a></li>
			<li><a href="download.php?type=2"><span>型錄下載</span></a></li>
		</ul>
	</li>
	<li class="moreMenu"><a href="news.php?type=1"><span>最新消息</span></a>
		<ul>
			<li><a href="news.php?type=1"><span>文字列表</span></a></li>
			<li><a href="news.php?type=2"><span>圖文列表</span></a></li>
		</ul>
	</li>
	<li class="moreMenu"><a href=""><span>其他頁面</span></a>
		<ul>
			<li><a href="faq.php"><span>問與答</span></a></li>
			<li class="moreMenu"><a href="contact.php?type=1"><span>聯絡我們</span></a>
				<ul>
					<li><a href="contact.php?type=1"><span>B to B</span></a></li>
					<li><a href="contact.php?type=2"><span>B to C</span></a></li>
				</ul>
			</li>
		</ul>
	</li>
</ul>
<?php $ID = '0-0_0-0_0-1-0_0'?>
			</div>
		</div>
	</div>
</header>
<?php $ID = '0-0_0-0_0-1-0_0-3' // v3/home/banner1?>
<?php // 0-0_0-0_0-1-0_0-3|DATA_MULTI|true?>
<?php // if(preg_match('/^index/', basename($_SERVER['REQUEST_URI'],'.php')) or basename($_SERVER['REQUEST_URI'],'.php') == ''):?>
<?php if($this->data['router_method'] == 'index'):?>
<?php 
	/* 設定 scrolldown 的形式	 
	 * 0 無
	 * 1 一般圖檔 (scrolldown.svg)
	 * 2 影格動畫 (scrolldown_frame.svg)
	 */
	$scrollDownType = 2;
	/* 影格動畫的設定 (選2才要設定)
	 * 說明：
	 * frames:影格數
	 * playtime:動畫時間
	 * w:一格影格 寬 (px)
	 * h:一格影格 高 (px)
	 * animateName:動畫名稱
	 *
	 * $scrollDownFrameData='{"frames":6,"playtime":"1s","w":50,"h":50,"animateName":"scrollDown"}';
	 */
	$scrollDownFrameData = '{"frames":6,"playtime":"1s","w":50,"h":50,"animateName":"scrollDown"}';
?>
<?php 
/*
 * 這個是首頁的Banner
 */
?>
<section class="bannerBlock">
	<section class="banner slideBanner">		
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<?php if(0)://SEO?>
					<?php $alt = ''?>
					<?php if($k == 0):?>
						<?php $alt = '台北防水工程'?>
					<?php elseif($k == 1):?>
						<?php $alt = '台北防水抓漏'?>
					<?php endif?>
					<?php $v['topic'] = $alt?>
				<?php endif?>
				<div class="slideItem"><?php if($v['url']!=''):?><a href="<?php echo $v['url']?>"><?php endif?><img src="<?php echo $v['pic1g']?>" class="pc" alt="<?php echo $v['topic']?>"><img src="<?php echo $v['pic2g']?>" class="mb" alt="<?php echo $v['topic']?>"></a></div>
			<?php endforeach?>
		<?php endif?>
		<?php if(0):?>
			<div class="slideItem"><a href=""><img src="images/indexBanner.jpg" class="pc"><img src="images/indexBanner_mb.jpg" class="mb"></a></div>
			<div class="slideItem"><a href=""><img src="images/indexBanner.jpg" class="pc"><img src="images/indexBanner_mb.jpg" class="mb"></a></div>
		<?php endif?>
	</section>
	<?php /*img的scrolldown */ ?>
	<?php if($scrollDownType==1):?>	
		<section class="scrollDown" data-scrollTo="[class^='indexContent']">	
			<div> 
				<img src="images/<?php echo $this->data['ml_key']?>/scrolldown.svg"> 
			</div>
		</section>
	<?php endif // end img ?>			
	<?php /* 影格動畫(需製作連續圖) */ ?>
	<?php if($scrollDownType==2):?>	
		<section class="scrollDown" data-scrollTo="[class^='indexContent']">	
			<div class="playFrame" data-playFrame="js" data-playFrameData='<?php echo $scrollDownFrameData?>'>		
				<img src="images/<?php echo $this->data['ml_key']?>/scrolldown_frame.svg"> 
			</div>
		</section>
	<?php endif //end frame ?>
</section>
<?php else:?>
<?php 
/*
 * 這個是內頁的Banner
 */
?>
	<section class="banner bgFix">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<img src="<?php echo $v['pic1g']?>" class="pc">
				<img src="<?php echo $v['pic2g']?>" class="mb">
			<?php endforeach?>
		<?php endif?>
		<?php if(0):?>
			<!--視差 banner-->
			<img src="images/tw/pageBanner.jpg" class="pc">
			<img src="images/tw/pageBanner_mb.jpg" class="mb">
		<?php endif?>
	</section>
<?php endif?>
<?php $ID = '0-0_0-0_0-1-0_0'?>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-1_0' // v3/default/layout_normal3?>
<?php $_params_=array (
  'p1' => 'Bbox_1c',
  'hole_tag' => '132',
);?>
<?php
/*
 * 2018-07-18
 */
// 預設四個參數都是空白，使用前，請確定其它洞裡面，沒有$p1的變數，不然會被覆寫
$p1 = ''; // Bbox_1c, Bbox_view_full (滿版)
if(isset($_params_) and isset($_params_['p1']) and $_params_['p1'] != ''){
	$p1 = $_params_['p1'];
}
?>
<?php $ID = '0-0_0-0_0-1-1_0-0' // -group?>
<?php $ID = '0-0_0-0_0-1-1_0-0-0' // v3/sub_page_title?>
<?php // 0-0_0-0_0-1-1_0-0-0|DATA_SINGLE|true?>
<section class="Bbox_1c">
	<div>
		<div class="text-right">
<?php $ID = '0-0_0-0_0-1-1_0-0-0-0' // v3/breadcrumb?>
<?php // 0-0_0-0_0-1-1_0-0-0-0|DATA_MULTI|true?>
<div>
	<ul class="breadcrumb">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<li><a <?php if(isset($v['url']) and $v['url'] != ''):?> href="<?php echo $v['url']?>" <?php endif?> ><?php echo $v['name']?></a></li>
			<?php endforeach?>
		<?php endif?>
<?php if(0):?>
		<li dom="1"><a dom="f" href="{*url*}index.html">{*name*}HOME</a></li>
		<li><a href="">產品介紹</a></li>
		<li><a href="">產品介紹</a></li>
		<li><a>產品介紹</a></li>
<?php endif?>
	</ul>
</div>
<?php // 2018-08-06 A方案的麵包屑範例?>
<?php if(0 and $this->data['router_method'] != 'index'):?>
	<ul class="breadcrumbs" l="layer" ls="_breadcrumb">
		<li l="list"><a href="{/url/}">{/name/}</a></li>
	</ul>
<?php endif?>
<?php $ID = '0-0_0-0_0-1-1_0-0-0'?>
		</div>
	</div>
</section>
<section class="Bbox_1c block">
	<div>
		<div>
			<div class="pageTitle">
				<span><?php if(isset($data[$ID]['name'])):?><?php echo $data[$ID]['name']?><?php endif?></span>
				<small><?php if(isset($data[$ID]['sub_name'])):?><?php echo $data[$ID]['sub_name']?><?php endif?></small>
			</div>   
		</div>
	</div>
</section>
<?php $ID = '0-0_0-0_0-1-1_0-0'?>
<?php $ID = '0-0_0-0_0-1-1_0-0-1' // v3/default/sidemenu_empty_datasource?>
<?php
// http://網站的網址/_i/backend.php?r=datasource/update&param=v1693
// 懷舊次選單 - v3_source:menu/sub,
// 
if(0){ // A方案
	$layoutv3_datasource_id = 1693;
	include 'layoutv3/dom5/datasource.php';
}
?>
<?php $ID = '0-0_0-0_0-1-1_0-0'?>
<?php $ID = '0-0_0-0_0-1-1_0-0-2' // v3/category_title?>
<?php // 0-0_0-0_0-1-1_0-0-2|DATA_SINGLE|true?>
<?php // 2018-08-09 A方案專用?>
<?php // 根據後台／LayoutV3／資料 的元素(好記的名子)格式命名?>
<?php if(0):?>
	<?php $data[$ID] = $this->data['_category_title']?>
<?php endif?>
<?php if(isset($data[$ID]) and isset($data[$ID]['name']) and $data[$ID]['name'] != ''):?>
<div class="Bbox_view">
	<div>	
		<div>
			<?php if(isset($data[$ID]['day']) or isset($data[$ID]['count'])): // GGG?>
			<div class="Bbox_flexBetween">
			<?php endif?>
				<?php if(isset($data[$ID]['name']) and $data[$ID]['name'] != ''):?>
					<?php 
					// 經理來信說 有開SEO功能才需要
					unset($_constant);
					eval('$_constant = '.strtoupper('seo_open').';');
					if($_constant){
						$_sptxt = 'h1';
					}else{
						$_sptxt = 'div';
					}
					?>
					<<?php echo $_sptxt?> class="blockTitle"><span><?php echo $data[$ID]['name']?></span></<?php echo $_sptxt?>>
				<?php endif?>
				<div class="Bbox_flexBetween">
					<?php if(isset($data[$ID]['day'])):?>
						<div class="dateStyle">
							<i class="fa fa-calendar-o"></i>
							<span class="dateD"><?php echo $data[$ID]['day']?></span>
							<span class="dateM"><?php echo $data[$ID]['month']?></span>
							<span class="dateY"><?php echo $data[$ID]['year']?></span>
						</div>
					<?php endif?>
					<?php if(isset($data[$ID]['count'])):?>
						<div class="itemTotal">
							<i class="fa fa-camera"></i>
							<span><?php echo $data[$ID]['count']?></span>
						</div>
					<?php endif?>
				</div>
			<?php if(isset($data[$ID]['day']) or isset($data[$ID]['count'])): // GGG?>
			</div>
			<?php endif?>
			<div class="blockInfoTxt">
				<?php if(isset($data[$ID]['sub_name']) and $data[$ID]['sub_name'] != ''):?>
					<?php echo $data[$ID]['sub_name']?>
				<?php endif?>				
			</div>
		</div>
	</div>
</div>
<?php endif?>
<?php $ID = '0-0_0-0_0-1-1_0-0'?>
<?php $ID = '0-0_0-0_0-1-1_0'?>
<?php $_params_=array (
  'p1' => 'Bbox_1c',
  'hole_tag' => '132',
);?>
<div class="<?php echo $p1?>">
	<div>
		<div>
<?php $ID = '0-0_0-0_0-1-1_0-2' // -group?>
<?php $ID = '0-0_0-0_0-1-1_0-2-0' // v3/video/type1?>
<?php // 0-0_0-0_0-1-1_0-2-0|DATA_MULTI|true?>
<div class="videoList">
	<div class="itemList Bbox_in_3c">
		<div>
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="item">
						<a class="swipebox-video" href="<?php echo $v['url1']?>" rel="album<?php echo $ID?>" title="<?php echo $v['name1']?>">
							<div class="itemImg">
								<img src="<?php echo $v['pic']?>">
							</div>
						</a>
						<a class="swipebox-video" href="<?php echo $v['url2']?>" rel="album<?php echo $ID?>" title="<?php echo $v['name2']?>">									
							<div class="itemTitle"> <span><?php echo $v['name3']?></span></div>
							<div class="dateStyle">
								<i class="fa fa-calendar-o"></i>
								<span class="dateD"><?php echo $v['day']?></span>
								<span class="dateM"><?php echo $v['month']?></span>
								<span class="dateY"><?php echo $v['year']?></span>
							</div>
						</a>
					</div>
				<?php endforeach?>
			<?php endif?>
		</div>
	</div>
</div>
<?php $ID = '0-0_0-0_0-1-1_0-2'?>
<?php $ID = '0-0_0-0_0-1-1_0-2-1' // v3/pagenav2?>
<?php // 0-0_0-0_0-1-1_0-2-1|DATA_SINGLE|true?>
<?php // 0-0_0-0_0-1-1_0-2-1|DATA_MULTI|true?>
<?php // 2018-06-19 A方案專用?>
<?php // $data[$ID]=$pageRecordInfo?>
<?php //var_dump($data[$ID])?>
<?php if(isset($data[$ID]) and count($data[$ID]) > 0):?>
	<section>
		<div class="Bbox_1c">
			<div>
				<div>
					<nav class="pageNav">
						<ul>
							<?php if(isset($data[$ID]['prev_url'])):?>
								<?php if($data[$ID]['prev_url'] != ''):?>
									<li class="prev"><a href="<?php echo $data[$ID]['prev_url']?>"><i class="fa fa-angle-left"></i></a></li>
								<?php else:?>
									<li class="prev disabled"><a href="javascript:;"><i class="fa fa-angle-left"></i></a></li>
								<?php endif?>
							<?php endif?>
							<li class="total"><a href="javascript:;" class="toggleBtn" data-target=".pageNav"><?php echo $data[$ID]['pagination']['control']['now']?> / <?php echo $data[$ID]['pagination']['control']['total']?></a></li>
							<?php if(isset($data[$ID]['pages']) and count($data[$ID]['pages']) > 0):?>
								<?php foreach($data[$ID]['pages'] as $k => $v):?>
									<li <?php if($v['url'] == ''):?> class="active" <?php endif?> ><a <?php if($v['url'] == ''):?> href="javascript:;" <?php else:?> href="<?php echo $v['url']?>" <?php endif?> ><?php echo $v['name']?></a></li>
								<?php endforeach?>
							<?php endif?>
							<?php if(isset($data[$ID]['next_url'])):?>
								<?php if($data[$ID]['next_url'] != ''):?>
									<li class="next"><a href="<?php echo $data[$ID]['next_url']?>"><i class="fa fa-angle-right"></i></a></li>
								<?php else:?>
									<li class="next disabled"><a href="javascript:;"><i class="fa fa-angle-right"></i></a></li>
								<?php endif?>
							<?php endif?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
<?php endif?>
<?php if(0)://V1第二版的範例 2017-12-12?>
<!--
					<div class="flex4c" l="layer" ls="html:download" lp="pagenav:ggg---1---index_<\?php echo $this->data['ml_key']\?>.php?page=">
						<div l="list">
							<a href=""><div class="itemImg"><img src="<\?=$imgPath;\?>index-img-2.jpg"></div></a>
							<h4>設計</h4>		
							<p>歐洲最大光電產業先驅，擁有全世界超過18 個據點</p>					
						</div>
					</div>
	<section>
		<div class="Bbox_1c">
			<div>
				<div>
					<nav class="pageNav">
						<ul>
							<li class="prev" l="layer list" ls="ggg" lp="filter_key2:control.4"><a href="{/value/}"><i class="fa fa-angle-left"></i></a></li>						
							<li class="total" l="layer list" ls="ggg" lp="filter_key2:control.8"><a href="#_" class="toggleBtn" data-target=".pageNav">{/value/}</a></li>
							<li l="layer list" ls="ggg" lp="filter_key:number" class="{/active/}"><a href="{/value/}">{/name/}</a></li>
							<li class="next" l="layer list" ls="ggg" lp="filter_key2:control.2"><a href="{/value/}"><i class="fa fa-angle-right"></i></a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
-->
<?php endif?>
<?php if(0)://純靜態?>
<section>
	<div class="Bbox_1c">
		<div>
			<div>
				<nav class="pageNav">
					<ul>
						<li class="prev disabled" ><a href=""><i class="fa fa-angle-left"></i></a></li>						
						<li class="total"><a href="#_" class="toggleBtn" data-target=".pageNav">3 / 11</a></li>
						<li><a href="">1</a></li>
						<li><a href="">2</a></li>
						<li class="active"><a href="">3</a></li>
						<li><a href="">4</a></li>
						<li><a href="">5</a></li>
						<li><a href="">6</a></li>
						<li><a href="">7</a></li>
						<li><a href="">8</a></li>
						<li><a href="">9</a></li>
						<li><a href="">10</a></li>
						<li class="next"><a href=""><i class="fa fa-angle-right"></i></a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</section>
<?php endif?>
<?php $ID = '0-0_0-0_0-1-1_0-2'?>
<?php $ID = '0-0_0-0_0-1-1_0'?>
<?php $_params_=array (
  'p1' => 'Bbox_1c',
  'hole_tag' => '132',
);?>
		</div>
	</div>
</div>			
<?php if(0):// 這個洞，是拿來放$側邊選單的，並且把它隱藏?>
<?php $ID = '0-0_0-0_0-1-1_0-1_0' // v3/shop/block?>
<?php // 0-0_0-0_0-1-1_0-1_0|DATA_SINGLE|true?>
<section class="<?php if(isset($data[$ID]['class_name'])):?><?php echo $data[$ID]['class_name']?><?php endif?> block"><?php // eventMenu, proCatalog, sideFilter ?>
	<div class="boxTitle"> <?php if(isset($data[$ID]['name'])):?><?php echo $data[$ID]['name']?><?php endif?> </div>							
<?php $ID = '0-0_0-0_0-1-1_0-1_0-0' // v3/default/sidemenu?>
<?php 
	// $def_activeid = 'navlight_5'; //亮燈的id
	$link_act = 'false'; //true: 點了換頁(就像是以前的promenu2), false: 點了展開(就像是以前的promenu)
?>
<!-- sidemenu start-->
<section class="navlight" 
		data-active="li" 
		data-multimenu="true" 
		data-defactive="active" 
		<?php if(isset($this->data['func_name_sub_id'])):?>
			data-defactiveid="<?php echo $this->data['func_name_sub_id']?>"
		<?php endif?>
	>
	<ul l="layer" 
		ls="id:0-0_0-0_0-1-1_0-1_0-0" 
		class="menuBlock togglearea" 
		data-item="li" 
		data-title="li>a" 
		data-content="li>ul" 
		data-nodefault="true" 
		data-prevent="<?php echo $link_act?>">
		<li l="list" attr1="" <?php if(0):?> idx="navlight_{/id/}" <?php endif?> ><a attr2="" >{/pic2_src/}{/name/}</a>
			{/child/}
		</li>
		<ul l="box">{split}</ul>
		<li><a href="elements.php">照明元件(子)</a>
			<ul>
				<li><a href="elements.php">PLCC Series</a></li>
				<li><a href="elements.php">COB Series</a></li>
				<li><a href="elements.php">Federal Series</a></li>
				<li><a href="elements.php">ES Series</a></li>
				<li><a href="elements.php">Flash Series</a></li>
				<li><a href="elements.php">Filament Series</a></li>
			</ul>
		</li>
		<li><a href="elements.php">LED模組</a></li>
		<li><a href="elements.php">車用模組(子)</a>
			<ul>
				<li><a href="elements.php">PLCC Series(子)</a>
					<ul>
						<li><a href="elements.php">PLCC Series</a></li>
						<li><a href="elements.php">COB Series</a></li>
						<li><a href="elements.php">Flash Series</a></li>
						<li><a href="elements.php">Filament Series</a></li>
					</ul>
				</li>
				<li><a href="elements.php">Flash Series(子)</a>
					<ul>
						<li><a href="elements.php">PLCC Series</a></li>
						<li><a href="elements.php">COB Series</a></li>
						<li><a href="elements.php">Federal Series</a></li>
					</ul>
				</li>
				<li><a href="elements.php">Flash Series</a></li>
				<li><a href="elements.php">COB Series</a></li>
			</ul>
		</li>
		<li><a href="elements.php">照明成品</a></li>
		<li><a href="elements.php">LED燈條</a></li>
	</ul>
</section>
<!-- sidemenu end-->
<?php $ID = '0-0_0-0_0-1-1_0-1_0'?>
</section>
<?php $ID = '0-0_0-0_0-1-1_0'?>
<?php $_params_=array (
  'p1' => 'Bbox_1c',
  'hole_tag' => '132',
);?>
<?php endif?>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-2_0' // v3/footer/layout1?>
<footer>
	<div class="footerContent">
		<section class="footerType2">
			<div>
<?php $ID = '0-0_0-0_0-1-2_0-0' // v3/footer/logo_footer?>
<section>
<div class="footerLogo"><img src="images/<?php echo $this->data['ml_key']?>/logo_footer.png"></div>
</section>
<?php $ID = '0-0_0-0_0-1-2_0'?>
			</div>
		</section>
		<section class="footerType1">
			<div>			
<?php $ID = '0-0_0-0_0-1-2_0-1' // -group?>
<?php $ID = '0-0_0-0_0-1-2_0-1-0' // v3/footer/footer_info?>
<section>
	<div class="footerInfo">
		一般文字請更新 Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis earum nam fugiat consectetur perferendis maiores doloremque dignissimos iure dicta, fugit autem! Aspernatur deserunt nihil ipsam quaerat cupiditate, quae doloribus fugiat!
	</div>
</section>
<?php $ID = '0-0_0-0_0-1-2_0-1'?>
<?php $ID = '0-0_0-0_0-1-2_0-1-1' // datasource___2744?>
<?php // 0-0_0-0_0-1-2_0-1-1|DATA_MULTI|true?>
<?php $_params_=array (
  'datasource_1' => '2744',
);?>
<?php
/*
 * 2019-12-02
 */
// var_dump($_params_);
if(
	isset($_params_) and !empty($_params_)
	and isset($_params_['datasource_1']) and $_params_['datasource_1'] != '' // 例8787
){
	$layoutv3_datasource_id = $_params_['datasource_1'];
	include 'layoutv3/dom5/datasource.php';
	if(!isset($content)){
		$content = array();
	}
	// dirty hack
	// 如果有必要，條件還是要下pidas:XXX的條件
	if($content and !empty($content) and !isset($content['id'])){
		foreach($content as $k => $v){
			if(isset($v['pid'])){
				$content[$k]['pid'] = 0;
			}
		}
	}
	// 底下程式銜接的方式3 (V1第二版)
	if($content){
		if(isset($content['id'])){ // 單筆
			$this->data['_general_detail'] = $content;
		} elseif(!empty($content)){ // 多筆
			$this->data['_general_rows'] = $content;
		}
	}
	if(isset($_params_['datasource_0'])){
		$data[$ID] = $content;
	} else {
		// 把後一個區塊的內容，取代成這裡的內容
		$tmp2 = explode('-', $ID);
		// 用群組包起來的解析方式
		// unset($tmp2[count($tmp2)-1]);
		// $tmp3 = explode('_', end($tmp2));
		// $tmp2[count($tmp2)-1] = $tmp3[0]+1;
		// 直接使用的方式
		$tmp2[count($tmp2)-1] = end($tmp2)+1;
		$next_id = implode('-',$tmp2);
		// var_dump($data[$next_id]);
		// 底下程式銜接的方式2 (LayoutV3)
		$data[$next_id] = $content;
		// if($_params_['datasource_1'] == 2751){
		// 	var_dump($content);
		// }
	}
}
?>
<?php $ID = '0-0_0-0_0-1-2_0-1'?>
<?php $ID = '0-0_0-0_0-1-2_0-1-2' // v3/footer/sitemap_type2?>
<?php
/*
 * 這個是橫的
 */
?>
<section z="">
	<ul class="siteMap type2" l="layer" ls="id:0-0_0-0_0-1-2_0-1-2">
		<li l="list"><a attr2="">{/name/}</a></li>
		<li><a href="about.php">關於我們</a></li>
		<li><a href="products.php">商品介紹</a></li>
		<li><a href="album.php?type=1">活動花絮</a></li>
		<li><a href="download.php?type=1">下載專區</a></li>
		<li><a href="news.php?type=1">最新消息</a></li>
		<li><a href="faq.php">問與答</a></li>
		<li><a href="contact.php">聯絡我們</a></li>
	</ul>
</section>
<?php $ID = '0-0_0-0_0-1-2_0-1'?>
<?php $ID = '0-0_0-0_0-1-2_0'?>
			</div>
			<div>
<?php $ID = '0-0_0-0_0-1-2_0-2' // v3/footer/company_info?>
<section>
	<ul class="companyInfo">
		<li><i class="fa fa-map-marker"></i><a href="" target="_blank">公司地址，請記得更新</a></li>
		<li><i class="fa fa-phone"></i><a href="tel:00-0000-0000">00-0000-0000</a></li>
		<li><i class="fa fa-envelope"></i><a href="mailto:xxx@xxx.xxx.xx">xxx@xxx.xxx.xx</a></li>
	</ul>
</section>
<?php $ID = '0-0_0-0_0-1-2_0'?>
			</div>
		</section>
	</div>
	<div class="footerContent copyright">
		<section class="footerType1">
			<div>
<?php $ID = '0-0_0-0_0-1-2_0-3' // v3/footer/copyright_txt?>
<section class="copyRightTxt">Copyright © 2020 xxxxxx All Rights Reserved.
	<span>
		<a href="http://www.buyersline.com.tw" class="copyrightTxt Designed" title="網頁設計" target="_blank">
			<img alt="網頁設計" title="網頁設計" src="images/<?php echo $this->data['ml_key']?>/txt-copyright.svg">網頁設計
		</a>
		<?php if(0):?>
			<span class="copyrightTxt byBLC">
				<img alt="BuyersLine Company" title="BuyersLine Company" src="images/<?php echo $this->data['ml_key']?>/txt-byBLC.svg">
				by BLC
			</span>
		<?php endif?>
		<img src="images/<?php echo $this->data['ml_key']?>/txt-byBLC.svg">
	</span>
</section>
<?php if($this->data['router_method']=='index' && 0)://SEO?>
	<?php if($this->data['ml_key'] == 'en'):?>
		<h1 class="copyRightTxt" style="margin:0;padding-top:0"><a href="#">AAA</a>、<a href="#">BBB</a>、<a href="#">CCC</a>、<a href="sitemap_<?php echo $this->data['ml_key']?>.php">Sitemap</a></h1>
	<?php else:?>
		<h1 class="copyRightTxt" style="margin:0;padding-top:0"><a href="#">AAA</a>、<a href="#">BBB</a>、<a href="#">CCC</a>、<a href="sitemap_<?php echo $this->data['ml_key']?>.php">Sitemap</a></h1>
	<?php endif?>
<?php endif?>
<?php $ID = '0-0_0-0_0-1-2_0'?>
			</div>
			<div>
<?php $ID = '0-0_0-0_0-1-2_0-4' // v3/footer/social_list?>
<section>
	<ul class="socialList">
		<li><a href=""><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
		<li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
		<li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
		<li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
	</ul>
</section>
<?php $ID = '0-0_0-0_0-1-2_0'?>
			</div>
		</section>
	</div>
</footer>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-3' // v3/widget/layout?>
<section class="pageWidget">
<?php $ID = '0-0_0-0_0-1-3-0_0' // -group?>
<?php $ID = '0-0_0-0_0-1-3-0_0-0' // v3/widget/page_loading?>
<?php 
	/*
	 * 設定 scrolldown 的形式 
	 * 0 無
	 * 1 一般圖檔 (loading.gif)
	 * 2 影格動畫 (loading_frame.svg)
	*/
	$pageLoadingType = 2; 
	/* 影格動畫的設定 (選2才要設定)
	 * 說明：
	 * frames:影格數
	 * playtime:動畫時間 (ex: 1s、500ms )
	 * w:一格影格 寬 (px)
	 * h:一格影格 高 (px)
	 * animateName:動畫名稱
	 *
	 * $pageLoadingFrameData='{"frames":30,"playtime":"1s","w":100,"h":100,"animateName":"pageLoading"}';
	 */
	$pageLoadingFrameData = '{"frames":8,"playtime":"800ms","w":100,"h":100,"animateName":"pageLoading"}';
?>
<?php 
/*
 * 這個是img的loading 
 */
?>
<?php if($pageLoadingType==1):?>	
	<section class="pageLoading">
		<div class="">
			<img src="images/<?php echo $this->data['ml_key']?>/loading.gif">
		</div>
	</section>
<?php endif;?>
<?php 
/* 
 * 影格動畫(需製作連續圖)
 */
?>
<?php if($pageLoadingType==2):?>	
	<section class="pageLoading">
		<div class="playFrame" 
			 data-playFrame="js" 
			 data-playFrameData='<?php echo $pageLoadingFrameData?>'>			 
			 <img src="images/<?php echo $this->data['ml_key']?>/loading_frame.svg">			
		</div>	
	</section>
<?php endif?>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3-0_0-1' // v3/widget/gotop?>
<?php // 0-0_0-0_0-1-3-0_0-1|DATA_MULTI|true?>
<a id="gotop" class="gotop">
	<i class="fa fa-chevron-up"></i>
	<img src="images/<?php echo $this->data['ml_key']?>/gotop.svg">
</a>
<?php
//判斷SESSION是否有詢問資料，如有則顯示提示連結 by lota
$_row = $_SESSION['save'];
//var_dump($_row);
$_inquiry = array();
if(isset($_row)){
	foreach ($_row as $key => $value) {
		if(preg_match('/^(.*)inquiry$/', $key, $matches)){
			$_count_key = count($value);
			if($_count_key > 0){
				$_check_ml_key = false;
				foreach ($value as $key1 => $value1) {
					if($value1['ml_key'] == $this->data['ml_key']){
						$_check_ml_key = true;
					}
				}
				if($_check_ml_key){
					$_inquiry[] = $matches[1];
				}					
			}					
		}
	}
}
$_count_inquiry = count($_inquiry);
?>
<?php if($_count_inquiry > 0):?>
	<?php foreach ($_inquiry as $key => $value):?>
		<a class="inquiry_info" href="<?php echo $value?>inquiry_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-info-circle" aria-hidden="true"></i><?php echo t('詢問車','tw')?></a>
	<?php endforeach?>
<?php else:?>
	<a class="inquiry_info" href="" style="display:none"><i class="fa fa-info-circle" aria-hidden="true"></i><?php echo t('詢問車','tw')?></a>
<?php endif?>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3-0_0-2' // v3/widget/login_panel_pwd?>
<div id="loginPanel_pwd" class="loginPanel_pwd popBox">
	<div class="closeSpace closeBtn" data-target="#loginPanel_pwd"></div>
	<div class="boxContent">
		<a href="#_" class="closeBtn" data-target="#loginPanel_pwd"><i class="fa fa-times"></i></a>
		<div class="mainContent">
			<div class="">
				<div class="userLogin">
					<div class="boxTitle"><?php echo t('登入')?></div>
					<section class="">
						<form action="media.php" method="post" name="memberForm" id="memberForm" >
							<div class="formItem">
								<label class="must"><?php echo t('密碼')?></label>
								<input type="password" name="login_password" id="<?php echo t('密碼')?>" placeholder="Password" />
							</div>	
							<div class="formItem oneLine">
								<button><i class="fa fa-user"></i><?php echo t('登入')?></button> 
								<?php if(0):?>
								<a class="icon-link" href="member.php?type=forgot"><i class="fa fa-lock"></i><?php echo t('忘記密碼')?></a>
								<?php endif?>
							</div>
						</form>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3-0_0-3' // v3/widget/mb_panel2?>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3-0_0-4' // v3/widget/search_form?>
<?php // 0-0_0-0_0-1-3-0_0-4|DATA_SINGLE|true?>
<div id="searchForm" class="searchForm popBox">
  <div class="closeSpace closeBtn" data-target="#searchForm"></div>
  <div class="boxContent">
    <a href="" class="closeBtn" data-target="#searchForm"><i class="fa fa-check" aria-hidden="true"></i> <?php echo t('CLOSE','en')?></a>
    <div class="mainContent">
	  <form method="get" action="<?php echo $data[$ID]['url']?>">
		  <input type="text" placeholder_xxxxx="xxxxx" name="q" /><button><?php echo t('SEARCH','en')?></button>
      </form>
    </div>
  </div>
</div>
<?php $ID = '0-0_0-0_0-1-3-0_0'?>
<?php $ID = '0-0_0-0_0-1-3'?>
</section>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-4' // v3/end?>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/slick/slick.min.js"></script>
<script src="js/swipebox/js/jquery.swipebox.js"></script>
<script src="js/masonry/masonry.pkgd.min.js"></script>
<script src="js/masonry/imagesloaded.pkgd.js"></script>
<script src="js/fancybox/jquery.fancybox.pack.js"></script>
<?php if(0):?>
<script src="js/twzipcode/jquery.twzipcode-1.7.8.min.js"></script>
<script src="js/nouislider/nouislider.min.js"></script>
<?php endif?>
<script src="js/twzipcode/jquery.twzipcode.min.js"></script>
<script src="js/jquery-ui/jquery-ui.min.js"></script>
<script src="js/jquery-ui/datepicker-zh-TW.js"></script>
<script src="js/scrollanimate/animate.js"></script>
<script src="js/clipboard/clipboard.min.js"></script>
<script src="js/toast/toast.min.js"></script>
<script>
  //share_social
  $(document).ready(function(){
    var url = document.location.href;
    new Clipboard('.btn_clipboard', {
      text: function() {
        return url;
      }
    });
    $('.btn_clipboard').click(function(){
      alert("Copied");
    });
  });
</script>
<?php if(0):?><!-- 這裡己經移到view/system/end.php，因為A方案也可能會用到 -->
<?php
unset($_constant);
eval('$_constant = SIMPLE_TRANSLATE;');
?>
<?php if($_constant == 1)://繁簡切換，放在head，在FF會有問題，所以改放這裡 2017-04-24?>
<script src="js_common/tw_cn.js"></script>
<script type="text/javascript">
	var defaultEncoding = 1;
	var translateDelay = 0;
	var cookieDomain = "<?php echo FRONTEND_DOMAIN?>";
	var msgToTraditionalChinese = "繁體";
	var msgToSimplifiedChinese = "简体";
	var translateButtonId = "translateLink";
	var translateButtonId_mb = "translateLink_mb";
	translateInitilization();
</script>
<?php endif?>
<?php endif?>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-5' // system/end?>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0-1-6_0' // -group?>
<?php $ID = '0-0_0-0_0-1-6_0-0' // v3/end/productdetail_promenu_focus?>
<?php // 0-0_0-0_0-1-6_0-0|DATA_MULTI|true?>
<?php if(0 and $this->data['router_method'] == 'productdetail')://2018-01-09己有新作法，不要在用這裡的東西?>
<?php
$tmps = array();
$class_id = $_GET['id'];
$product_row = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
$class_id = $product_row['class_id'];
$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where(array('ml_key'=>$this->data['ml_key'],'is_enable'=>'1'))->get(str_replace('detail','',$this->data['router_method']).'type');
$rows = array();
foreach($query->result_array() as $v){
    $rows[] = $v; 
}
$tmp2 = _get_product_classes($rows);
// 因為相簿沒有無限層的時候，這裡就會報錯，所以才要寫這個判斷式
if(isset($tmp2['sample'][$class_id])){
$tmp3 = _search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$class_id]['class_name']);
	if($tmp3 and isset($tmp3['keyvalue']) and count($tmp3) > 0){ 
		foreach($tmp3['keyvalue'] as $k => $v){
			$tmps[] = array(
				'name' => $v, 
				'url' => str_replace('detail','',$this->data['router_method']).'.php?id='.$k,
			);  
		}   
	}
?>
	<?php if(isset($tmps)):?>
	<script type="text/javascript">
		<?php foreach($tmps as $k => $v):?>
			<?php if(isset($v['url']) and preg_match('/^'.str_replace('detail','',$this->data['router_method']).'\.php\?id\=(.*)$/', $v['url'], $matches)):?>
				$('#navlight_<?php echo $matches[1]?>').addClass('active');
			<?php endif?>
		<?php endforeach?>
	</script>
	<?php endif?>
<?php } //這裡是判斷tmp2['sample']有沒有class_id的結尾?>
<?php
/*
 * 順便做主選單的focus
 */
$row = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and url1=:url1',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key'],':url1'=>str_replace('detail','',$this->data['router_method']).'.php'))->queryRow();
if($row and isset($row['id'])){?>
	<script type="text/javascript">
		$('#navlight_webmenu_<?php echo $row['id']?>').addClass('active');
	</script>
<?php } //這裡是判斷有沒有主選單的結尾?>
<?php endif//productdetail?>
<?php $ID = '0-0_0-0_0-1-6_0'?>
<?php $ID = '0-0_0-0_0-1-6_0-1' // v3/end/albumdetail_promenu_focus?>
<?php // 0-0_0-0_0-1-6_0-1|DATA_MULTI|true?>
<?php if(0 and $this->data['router_method'] == 'albumdetail'):// 這裡己經有新的作法取代，請不要在用這裡?>
<?php
$tmps = array();
$class_id = $_GET['id'];
$product_row = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']),':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
$class_id = $product_row['class_id'];
$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where(array('ml_key'=>$this->data['ml_key'],'is_enable'=>'1'))->get(str_replace('detail','',$this->data['router_method']).'multitype');
$rows = array();
foreach($query->result_array() as $v){
    $rows[] = $v; 
}
$tmp2 = _get_product_classes($rows);
// 因為相簿沒有無限層的時候，這裡就會報錯，所以才要寫這個判斷式
if(isset($tmp2['sample'][$class_id])){
	$tmp3 = _search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$class_id]['class_name']); // gg
	if($tmp3 and isset($tmp3['keyvalue']) and count($tmp3) > 0){ 
		foreach($tmp3['keyvalue'] as $k => $v){
			$tmps[] = array(
				'name' => $v, 
				'url' => str_replace('detail','',$this->data['router_method']).'.php?id='.$k,
			);  
		}   
	}
?>
	<?php if(isset($tmps)):?>
	<script type="text/javascript">
		<?php foreach($tmps as $k => $v):?>
			<?php if(isset($v['url']) and preg_match('/^'.str_replace('detail','',$this->data['router_method']).'\.php\?id\=(.*)$/', $v['url'], $matches)):?>
				$('#navlight_<?php echo $matches[1]?>').addClass('active');
			<?php endif?>
		<?php endforeach?>
	</script>
	<?php endif?>
<?php } //這裡是判斷tmp2['sample']有沒有class_id的結尾?>
<?php endif//albumdetail?>
<?php $ID = '0-0_0-0_0-1-6_0'?>
<?php $ID = '0-0_0-0_0-1'?>
<?php $ID = '0-0_0-0_0'?>
	<?php
	unset($_constant);
	eval('$_constant = INDEX_ALEST_AD;');
	?>
	<?php if($_constant == 1 and $this->data['router_method'] == 'index'):?>
		<?php if(1):?>
			<?php 
				/*
				 * 首頁彈跳廣告 第一版
				 * iframe
				 */
			?>
			<a class="fancybox fancybox.iframe" href="alert_win2.php"></a>
			<script language="JavaScript" type="text/javascript" src="js/jquery.flexslider.js"></script>
			<?php if(0):?>
				<!-- Add mousewheel plugin (this is optional) -->
				<script type="text/javascript" src="js/fancybox_old/lib/jquery.mousewheel-3.0.6.pack.js"></script>
			<?php endif?>
			<!-- Add fancyBox -->
			<link rel="stylesheet" href="js/fancybox_old/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
			<?php if(0)://因為在view/end.php裡面己經有載入了?>
			<script type="text/javascript" src="js/fancybox_old/jquery.fancybox.pack.js?v=2.1.5"></script>
			<?php endif?>
			<script type="text/javascript" charset="utf-8">
				// http://stackoverflow.com/questions/37738732/jquery-3-0-url-indexof-error
				// $(window).on('load', function() { // jquery > 3.0 這個很重要
				$(window).load(function() {
					$('.flexslider').flexslider();
					$('.fancybox').fancybox({
						maxWidth : 800,
						maxHeight : 600,
						fitToView : false,
						width  : '70%',
						height  : '70%',
						autoSize : false,
						closeClick : false,
						openEffect : 'none',
						closeEffect : 'none'
						// 'frameWidth': 300,
						// 'frameHeight': 100,
						// 'autoScale'		: false,
						// 'scrolling':'auto',
						// 'hideOnContentClick': false,
						// 'overlayOpacity': 0.65
					});
					<?php if(isset($this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]) and $this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']] == 1):?>
					$('.fancybox').click();
					<?php endif?>
				});
			</script>
		<?php endif?>
		<?php 
		/*
		 * 首頁彈跳廣告 第二版
		 * 必需要fancybox 2.1.7版以上才可以使用
		 * iframe
		 */
		if(0 and isset($this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]) and $this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']] != ''):?>
			<?php if(0)://fancy-2.1.7?>
				<script src="js/fancynox/jquery.fancybox.js"></script>
			<?php endif?>
			<script type="text/javascript">
				$(document).ready(function(){
					$.fancybox.open([
						{
							src  : '_i/assets/upload/indexad/<?php echo $this->data['sys_configs']['pic2_'.$this->data['ml_key']]?>',		
						},
					], {
						loop : false
					});
				});
			</script>
		<?php endif?>
	<?php endif?>
<?php
unset($_constant);
eval('$_constant = GOOGLE_TRANSLATE;');
?>
<?php if($_constant == 1):?>
<?php
$rows_tmp = $this->cidb->where('is_enable',1)->get('ml_google')->result_array();
$rows = array();
foreach($rows_tmp as $k => $v){
	$rows[] = $v['key'];
}
$google_language = implode(',', $rows);
?>
<script type="text/javascript">
<?php // 這幾行是winnie寫的 2017/6/13 移除 pageLanguage: 'en', 讓翻譯器自動判別來源字元?>
if($("#google_translate_element_g").length){
	function googleTranslateElementInit_g() {new google.translate.TranslateElement({includedLanguages: '<?php echo $google_language?>'}, 'google_translate_element_g');}
	$('body').append('<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit_g"></'+'script>');
}
</script>
<?php endif?>
<script type="text/javascript">
$(document).ready(function(){
	$.ajax({
		type: "POST",
		data: {
			'id': 'get_token',
		},
		url: 'gtoken.php',
		success: function(response){
			//alert(response);
			eval(response);
		}
	}); // ajax
});
</script>
<script type="text/javascript">
if($(window).width() < 1025){
	//ajax to get data
	var mbPanelDatas = "";
	$.ajax({
		url: "mbpanel2.php",
		type: "POST",
		async: false,
		dataType: "json",
		success: function(data) {
			mbPanelDatas=data['mbPanel'];
		},
		error: function() {
			console.log("mbPanel get Data ERROR!!!");
		}
	});
	var mbPanelSet=mbPanelDatas['mbPanelSet'];
	var mbPanelDataSet=mbPanelDatas['mbPanelDataSet'];
}
</script>
<script type="text/javascript">
	//define #mbPanel wrap
	var mbPanelWrap="body>*:not(script):not(.pageWidget)";
	//define mb hide block (selector)
	var hideBlock=".header";
</script>
<script src="js_common/mbPanel.js"></script>
<script src="js/custome.js"></script>
<script src="js/page.js"></script>
<?php
unset($_constant);
eval('$_constant = SIMPLE_TRANSLATE;');
// 繁簡切換
// 這裡的東西放在head，在FF會有問題，所以改放這裡 2017-04-24
// 這裡是下半部，上半部在view/system/head.php 2018-05-09
// SESSION _lang變數，寫在layoutv3/cig_frontend/init.php 2019-12-31
?>
<?php if($_constant == 1):?>
<script src="js_common/tw_cn.js"></script>
<script type="text/javascript">
	var defaultEncoding = 1;
	var translateDelay = 0;
	var cookieDomain = "<?php echo FRONTEND_DOMAIN?>";
	var msgToTraditionalChinese = "繁體";
	var msgToSimplifiedChinese = "简体";
	var translateButtonId = "translateLink";
	var translateButtonId_mb = "translateLink_mb";
	translateInitilization();
	//$(window).load(translateBody());
</script>
<?php endif?>
<?php if(0 and isset($_SESSION['auth_admin_id']) and preg_match('/\,(999995)\,/', ','.$_SESSION['auth_admin_type'].',') and isset($_layoutv3pagetype_id) and $_layoutv3pagetype_id > 0)://2018-08-23李哥早上有看過?>
	<iframe src="_i/backend.php?r=layoutv3pagetype/update&param=v<?php echo $_layoutv3pagetype_id?>" width="100%" height="500" frameborder="0" scrolling="auto"></iframe>
<?php endif?>
<span mg="body_end"></span>
</body>
</html>
<?php endif//layoutit?>
<?php $ID = '0-0_0'?>
<?php $ID = '0'?>


<?php
			$out = ob_get_contents();
			ob_end_clean();

			include "layoutv3/dom5.php";

		} // __construct

	} // class foo

	$ggg = new Foo;
	die; // 第一階段到這裡結束
}


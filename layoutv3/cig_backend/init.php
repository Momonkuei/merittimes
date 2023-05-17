<?php

use nguyenanhung\CodeIgniterDB as CI;

// if(!defined('LAYOUTV3_PATH')){
if(!defined('LAYOUTV3_IS_RUN_FIRST')){
	@session_start();

	// 每一種架構模式都會有這個屬於自己的常數 2018-01-15
	define('LAYOUTV3_STRUCT_MODE', 'cig_backend');

	// 不同Application，如果這裡有指定的話(例如"admin/"或是en/")，可以使用自己的group、view等，但是layoutv3資料夾還是共用一個
	if(!isset($layoutv3_path)){
		$layoutv3_path = '';
	}

	define('LAYOUTV3_PATH', $layoutv3_path); // 為了要讓MVC架構也能使用，所以才用常數

	$bbb = str_replace('.php','',$_SERVER['SCRIPT_NAME']);
	if(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){
		$bbb = str_replace(LAYOUTV3_PATH,'',$bbb);
	}
	$bbb = str_replace('/','',$bbb);

	define('LAYOUTV3_IS_RUN_FIRST', $bbb); // 這個變數，在render階段會用到，等同於功能名稱
	define('_BASEPATH', __DIR__.'/../../_i'); // /var/www/html/rwd_v3/_i

	//define('customer_public_path', '../'.$layoutv3_path.'assets/'); // 意思是jobs2裡面的assets，
	define('customer_public_path', 'assets/'); // 意思是jobs2裡面的assets，

	$vendors_dir = _BASEPATH.'/vendors';
	ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

	// CI2
	// include_once 'ci.php';	

	// CI3
	// 2018-12-18 從ci.php裡面移出來的
	if(!defined('GGG_BASEPATH')){
		define('GGG_BASEPATH', realpath(dirname(__FILE__)).'/');
	}
	if(!defined('GGG_APPPATH')){
		define('GGG_APPPATH', realpath(dirname(__FILE__)).'');
	}

	// composer autoload 2018-12-18
	include_once GGG_BASEPATH.'../vendor/autoload.php';

	class Foo {

		public $data;

		public $ignore_class_acl = array(
			'login',
			'captcha',
		);

		function __construct()
		{
			date_default_timezone_set("Asia/Taipei");

			// 2014-01-02 TED建議，我設一小時
			//ini_set("session.gc_maxlifetime","3600");

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

			include GGG_BASEPATH.'../../_i/config/environment.php';
			include GGG_BASEPATH.'../../_i/config/db.php';
			include GGG_BASEPATH.'../../_i/config/email.php';
			include GGG_BASEPATH.'../../_i/config/shop.php';

			$Db_Server = aaa_dbhost;
			$Db_User = aaa_dbuser;
			$Db_Pwd = aaa_dbpass;
			$Db_Name = aaa_dbname;	

			// $tmps = array(
			// 	'dbdriver' => 'mysql',
			// 	'username' => $Db_User,
			// 	'password' => $Db_Pwd,
			// 	'hostname' => $Db_Server,
			// 	'port' => 3306,
			// 	'database' => $Db_Name,
			// );

			// $db = ggg_load_database($tmps, true);
			// $this->cidb = $db;
			// $_SESSION['cidb'] = $db;

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

			$bbb = str_replace('.php','',$_SERVER['SCRIPT_NAME']);

			// 2019-12-27
			if($bbb == '/'.LAYOUTV3_PATH.'_page'){
				$bbb = str_replace('.php','',$_SERVER['REQUEST_URI']);//為了支援網站放在次目錄所處理的 by lota
			}
			if(preg_match('/^(.*)\?/', $bbb, $matches)){
				$bbb = $matches[1];
			}

			if(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){
				$bbb = str_replace(LAYOUTV3_PATH,'',$bbb);
			}
			// $bbb = str_replace('_'.$this->data['ml_key'],'',$bbb); // 前台才會用到
			$bbb = str_replace('/','',$bbb);


			//echo $_SERVER['REQUEST_URI'].'ggg';die;
			//if($bbb == '_page.php'){
			//	//$tmp = $_SERVER['REQUEST_URI'];
			//	$tmp = str_replace($web_folder,'',$_SERVER['REQUEST_URI']);//為了支援網站放在次目錄所處理的 by lota
			//}

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
					$this->data['current_url'] .= '&param='.$_GET['param'];
				}

				$this->data['router_param'] = $_GET['param'];
			}
			$this->data['theme_lang'] = 'admin_lang_1';
			define('theme_lang', $this->data['theme_lang']);

			// 向下支援
			$this->data['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.str_replace('/','',LAYOUTV3_PATH);

			// 前後台共用的函式庫
			include GGG_BASEPATH.'../cig/libs.php';	

			// 自己Application專用的函式庫
			include 'libs.php';	

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
			require_once 'Zend/Loader/Autoloader.php';
			spl_autoload_register(array('Zend_Loader_Autoloader','autoload'));

			// 驗證使用者有沒有權限的開始準備工作
			if(!in_array($this->data['router_method'], $this->ignore_class_acl)){
				if(!isset($all_session['auth_admin_id']) or $all_session['auth_admin_id'] <= 0){
					header('Location: login.php?current_base64_url='.base64url::encode($_SERVER['REQUEST_URI']));
					die;
				}
				$acl = new Admin_acl($this->cidb);
				$acl->start();
			}

			/*
			 * 接下來，就要看要使用的Application，到底是前台、還是後台
			 */

			// 將驗證類的session值，傳給smarty
			foreach($all_session as $k => $v){
				if(preg_match('/^auth_(.*)$/', $k, $matches)){
					//echo $matches[1];
					// 加了一個w底線，為了要區分前台和後台的session變數群
					$this->data[$matches[1]] = $v;
				}
			}

			if(!in_array($this->data['router_method'], $this->ignore_class_acl)){
				if(!$acl->hasAcl($this->data['admin_id'], $this->data['router_class'], $this->data['router_action'], $this->data['router_param'])){
					//$error = array(
					//	'code' => 'You do not have permissions',
					//	'message' => 'You do not have permissions',
					//);
					//$msg = $this->_getLabel('You do not have permissions');
					//show_error($msg);
					//$this->render('//error', $error);
					//throw new CHttpException(403, $msg);

					$msg = G::t(null, 'You do not have permissions', array(), '你沒有權限使用這個功能, <a href="logout.php">登出</a>');
					sys_log::set($msg.': '.$class.'/'.$method);
					header('HTTP/1.0 403 '.$msg);
					// $this->widget('system.widgets.Gw_error', array('message'=>$msg, 'heading'=>'Error', 'errorcode'=>403));
					die;
				}
			}

			// $ml_key = $host['ml_key'];
			// $this->data['default_ml_key'] = $ml_key;

			//    /*
			//     * 介面語系的優先權處理過程
			//     */
			//    
			//    // 如果是空白，就取用使用者所選擇的語系
			//    if($ml_key == '' and isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
			//    	$ml_key = $_SESSION['web_ml_key'];
			//    	$this->data['default_ml_key'] = $host['ml_key'];
			//    }
			//    
			//    // 如果還是空白，就取用系統的語系預設值
			//    if($ml_key == ''){
			//    	$this->data['default_ml_key'] = $host['ml_key'];
			//    	$ml_key = $host['ml_key'];
			//    } else {
			//    	$this->data['default_ml_key'] = $host['ml_key'];
			//    	//Yii::app()->language = $ml_key;
			//    }
			//    
			//    // 我就跟你說吧，最終預設語系是繁體(kid)
			//    if($ml_key == ''){
			//    	$ml_key = 'tw';
			//    }
			//    
			//    $_SESSION['web_ml_key'] = $ml_key;
			//    $this->data['ml_key'] = $ml_key;

			// 設定語系與抓取語系
			//$ml_key = Yii::app()->session['interface_ml_key'];
			$interface_ml_key = '';
			$ml_key = '';
			//echo $ml_key;

			/*
			 * 介面語系的優先權處理過程
			 */

			// 介面即時切換語系，比使用者預設語系的優先權還要高
			if($interface_ml_key == '' and isset($this->data['admin_switch_interface_ml_key']) and $this->data['admin_switch_interface_ml_key'] != ''){
				$interface_ml_key = $this->data['admin_switch_interface_ml_key'];
				$this->data['admin_switch_interface_ml_key'] = $interface_ml_key;
			}

			// 介面選擇語系，比使用者預設語系的優先權還要高
			if($interface_ml_key == '' and isset($this->data['admin_interface_ml_key']) and $this->data['admin_interface_ml_key'] != ''){
				$interface_ml_key = $this->data['admin_interface_ml_key'];
			}

			// 如果是空白，就取用使用者所選擇的語系
			if($interface_ml_key == '' and isset($this->data['admin_ml_key']) and $this->data['admin_ml_key'] != ''){
				$interface_ml_key = $this->data['admin_ml_key'];
			}

			// 如果還是空白，就取用系統的語系預設值
			// if($interface_ml_key == ''){
			// 	$interface_ml_key = Yii::app()->language;
			// } else {
			// 	Yii::app()->language = $interface_ml_key;
			// }

			// 我就跟你說吧，最終預設語系是繁體(kid)
			if($interface_ml_key == ''){
				$interface_ml_key = 'tw';
			}

			// debug
			//$interface_ml_key = 'en';
			//echo $interface_ml_key;
			//die;

			/*
			 * 資料語系的優先權處理過程
			 */

			// 資料即時切換語系，比資料預設語系的優先權還要高
			if($ml_key == '' and isset($this->data['admin_switch_data_ml_key']) and $this->data['admin_switch_data_ml_key'] != ''){
				$ml_key = $this->data['admin_switch_data_ml_key'];
				$this->data['admin_switch_data_ml_key'] = $ml_key;
			}

			// 以Session裡面的為主
			if($ml_key == '' and isset($this->data['admin_data_ml_key']) and $this->data['admin_data_ml_key'] != ''){
				$ml_key = $this->data['admin_data_ml_key'];
			}


			// 如果是空白，就取用前台的預設語系
			// if($ml_key == ''){
			// 	if(file_exists('web/config/main.php')){	
			// 		$web_configs = include('web/config/main.php');
			// 		if(isset($web_configs['language']) and $web_configs['language'] != ''){
			// 			$ml_key = $web_configs['language'];
			// 		}
			// 		//var_dump($web_configs['language']);
			// 	}
			// }

			// 如果真的還是空白，就取用介面語系的為主(真的沒辦法了)
			if($ml_key == ''){
				$ml_key = $interface_ml_key;
			}

			// 先死的，優先權最高，取代一切
			// 如果你要用網域來決定介面語系
			//  1. 請移除登入介面的語系切換
			//  2. 請保留這一行
			// 反之
			// 如果你想用Google隱藏式自動翻譯，請打開layout/main.php裡面的google翻譯的程式區段
			if(isset($host['ml_key']) and $host['ml_key'] != ''){
				$interface_ml_key = $host['ml_key'];
			}

			/*
			 * 語系己經決定好了，所以分配給介面語系和資料語系
			 */

			// 因為介面語系是後來寫的，怕把資料語系需要改的地方很多，所以介面語系改名子比較快
			$_SESSION['auth_admin_interface_ml_key'] = $interface_ml_key;
			// 這行可能是bug
			//Yii::app()->session['interface_ml_key'] = $interface_ml_key;
			$this->data['interface_ml_key'] = $interface_ml_key;

			// 切換要維護的語系資料，是不會影響到介面語系的(那當然)
			//Yii::app()->session['ml_key'] = $ml_key;
			$_SESSION['web_ml_key'] = $_SESSION['auth_admin_data_ml_key'] = $ml_key;
			$this->data['ml_key'] = $ml_key;
			//var_dump($this->data['ml_key']);

			/*
			 * 這兩個變數，辛苦你們了，讓你們跑前鋒
			 */

			if(!isset($this->data['admin_switch_data_ml_key'])){
				$this->data['admin_switch_data_ml_key'] = $ml_key;
			}
			if(!isset($this->data['admin_switch_interface_ml_key'])){
				$this->data['admin_switch_interface_ml_key'] = $ml_key;
			}

			// 取得後台用的語系列表
			$rows = $this->cidb->where('is_enable', 1)->like('interface', ',1,', 'both')->get('ml')->result_array();
			//$rows = $this->db->createCommand()->from('ml')->where('is_enable = 1')->where(array('like', 'interface', '%,1,%'))->order('sort_id')->queryAll();
			// $rows = $this->db->createCommand('select * from ml where is_enable=1 and interface like "%,1,%" order by sort_id')->queryAll();
			$mls = array();
			$mls_tmp = array();
			foreach($rows as $row){
				$tmp = $row['name'];
				$mls[$row['key']] = $tmp;
				$mls_tmp[] = $row['key'];
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

				// 2019-12-27
				if(!file_exists($file_current)){
					$file_current = _BASEPATH.'/../'.LAYOUTV3_PATH.'_page.php';
				}

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
			// if(preg_match('/^(captcha|captcha2|ajax2|action|cssv3|facebook|google|fb|guestcheckemail|page|save|short|step1)$/', $bbb)){
			// 	$file = _BASEPATH.'/../'.$bbb.'.php';
			// 	include $file;
			// } else {
			// 	$file_old = _BASEPATH.'/../'.$bbb.'.php';
			// 	$file = _BASEPATH.'/../parent/'.$bbb.'.php'; //【Ming 2017-05-12】關於「SEO - 網址討論結論」
			// 	if(!file_exists($file)){
			//		$file = $file_old;
			// 	}
			// 	include $file;
			// }

			// 這是後台在用的
			$file = _BASEPATH.'/../'.LAYOUTV3_PATH.$bbb.'.php';
			if(!file_exists($file)){
				$file = _BASEPATH.'/../'.LAYOUTV3_PATH.'_page.php';
			}
			include $file;

		}
	}
	$ggg = new Foo;
	die; // 第一階段到這裡結束
}


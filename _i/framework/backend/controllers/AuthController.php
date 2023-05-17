<?php

class AuthController extends Controller
{
	// 測試一下寫入的動作
	//public function actionTest()
	//{
	//	$id = 8;
	//	$update = array(
	//		'common_table' => '123',
	//	);

	//	$c = new G_sys_func_orm;
	//	$u = $c::model()->findByPk($id);
	//	$u->setAttributes($update);
	//	$u->validate();

	//	// save自己會做validate
	//	if(!$u->update()){
	//		G::dbm($u->getErrors());
	//	}
	//}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			//'captcha'=>array(
			//	'class'=>'CCaptchaAction',
			//	'backColor'=>0xFFFFFF,
			//	'fontFile'=>'ext.sbcaptcha.Duality.ttf'
			//),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			//'page'=>array(
			//	'class'=>'CViewAction',
			//),
		);
	}

	//public function actionTest()
	//{
	//	$acl = new Admin_acl();
	//	$acl->start();
	//	//var_dump($acl->hasAcl(27, 'payment', 'create'));
	//	
	//	//$group_ids_tmp = $this->session['auth_admin_type'];
	//	//var_dump($acl->hasAcl(1, 'payment'));
	//}


	// /customer/a1-demo-sj-gisanfu-idv-tw/thumb/product_image/320x320_ec6ef230f1828039ee794566b9c58adc98.jpg
	// http://svn.test.oz.gisanfu.idv.tw/12Y0313/trunk/backend.php?r=imagethumb/index&class=adv&filename=20130118142003_3_5y..jpg&width=300&height=100
	// 範例：http://svn.test.oz.gisanfu.idv.tw/emtechnik_12Y0441/trunk/_ozman/index.php?r=auth/imagethumb&class=_system&width=200&height=200&tag=5&filename=image.png
	public function actionImagethumb($class = '', $filename = '', $width = '', $height = '', $tag = '', $thumb = '', $x = '', $y = '', $replace = '', $crop = '')
	{
		if($class == '' or $filename == '' or $width == '' or $height == ''){
			die;
		}

		//if($tag == ''){
		//	// 回傳檔案內容
		//	$tag = '5';
		//}

		// a,b,c
		// id
		// tag
		$params = array(
			'a' => (int)$width,
			'b' => (int)$height,
			'c' => $class,
			//'id' => '123',
			//'tag' => $tag,
			//'tag' => '5',
			//'replace' => '1',
			'content' => $filename,
		);
		if($thumb != ''){
			$params['thumb'] = $thumb;
		}
		if($x != ''){
			$params['x'] = (int)$x;
		}
		if($y != ''){
			$params['y'] = (int)$y;
		}
		if($replace != ''){
			$params['replace'] = $replace;
		}
		if($crop != ''){
			$params['crop'] = $crop;
		}
		if($tag != ''){
			$params['tag'] = $tag;
		}
		//var_dump($params);
		//die;

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
        header("Cache-Control: no-store, no-cache, must-revalidate"); 
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
		header('Content-type: image/png');

		echo G::img($params);
		die;
	} 

	public function actionSwitchLoginMl($ml_key = '')
	{
		// 這裡的session變數，到了Controller，會被更名成admin_switch_interface_ml_key
		// 也就是auth_會被拿掉
		if($ml_key != ''){
			Yii::app()->session['auth_admin_switch_interface_ml_key'] = $ml_key;
		} else {
			Yii::app()->session['auth_admin_switch_interface_ml_key'] = '';
		}
		//echo Yii::app()->session['admin_switch_interface_ml_key'];
		//die;
		$this->redirect($this->createUrl($this->data['router_class'].'/login'));
	}

	public function actionSwitchDataMl($ml_key = '', $current_base64_url = '')
	{ 
		if($ml_key != '' and $current_base64_url != ''){

			$current_url = base64url::decode($current_base64_url);
			// 2017-07-26 李哥說，在功能內頁的時候，要轉到列表頁
			// /_i/backend.php?r=company/create¶m=aL19pL2JhY2tlbmQucGhwP3I9Y29tcGFueQ,,
			if(preg_match('/\?r=(.*)\/(.*)$/', $current_url, $matches)){
				$current_url = str_replace('/'.$matches[2], '', $current_url);
			}
			
			//2019-9-26 增加管理者限定操作語系判斷 by lota
			if(isset(Yii::app()->session['check_data_ml_key']) && count(Yii::app()->session['check_data_ml_key']) > 0 ){		
				$check_data_ml_key = Yii::app()->session['check_data_ml_key'];
				if(!in_array($ml_key,$check_data_ml_key)){
					G::alert_and_redirect('違法操作', $current_url, $this->data);
				}
			}

			Yii::app()->session['auth_admin_switch_data_ml_key'] = $ml_key;			

			// 2018-07-06 切換語系的時候，要清一下，不然搜尋結果會變成空白
			//$ss = $this->data['router_class'].'_search';
			//$session = Yii::app()->session[$ss];
			//$session = array();
			//Yii::app()->session[$ss] = $session;
			foreach(Yii::app()->session as $ss => $session){
				if(preg_match('/_search$/', $ss)){
					$session = array();
					Yii::app()->session[$ss] = $session;
				}
			}

			//2016/2/22 lota Bryan建議，切換語系跳出提醒
			//2018/5/23 修改為讀取資料庫的name by lota
			$query = $this->cidb->where('key',$ml_key)->get('ml');
			$ml_data = $query->row_array();
			$show_tt = $ml_data['name'];
			
			//switch($ml_key){
			//	case 'tw':
			//		$show_tt = '繁體中文';
			//	break;
			//	case 'en':
			//		$show_tt = 'English';
			//	break;
			//	case 'cn': 
			//		$show_tt = '簡體';
			//	break;
			//	case 'jp':
			//		$show_tt = '日文';
			//	break;
			//	case 'sp':
			//		$show_tt = '西班牙';
			//	break;
			//}

			G::alert_and_redirect('目前為'.$show_tt.'環境', $current_url, $this->data);
			//$this->redirect($current_url);
		}
	}

	// 其實它沒有什麼用處，只是在登入後，純導向到某個地方，為了換首頁不要改太多地方才寫成這樣子的
	public function actionMain()
	{
		$this->redirect($this->createUrl('home/simple'));
	}

	public function actionLogin($status = '', $current_base64_url = '')
	{
		$this->layout = 'empty';
		if(empty($_POST)){

			// 用Facebook快速登入，2017-03-17有跟小李報告過
			// 這裡是上半部
			if(isset($_GET['a']) and $_GET['a'] != ''){
				//$_COOKIE['_buyersline_crm2_user_publickey'] = $_GET['a'];
				setcookie('_buyersline_crm2_user_facebook_id', $_GET['a'], time()+86400);
				header('Location: '.FRONTEND_DOMAIN.'/admin');die;
			}

			$this->data['status'] = $status;

			$this->data['current_base64_url'] = $current_base64_url;

			// 如果己經登入的，就不用在登入一次
			if(isset(Yii::app()->session['auth_admin_id']) and Yii::app()->session['auth_admin_id'] != ''){
				if($current_base64_url != ''){
					$url = base64url::decode($current_base64_url);
					$this->redirect($url);
				}
				$this->redirect($this->createUrl('auth/main'));
			}

			// 如果有勾保持登入狀態的話，就不需要在登入一次，重新寫入session
			$db = Yii::app()->db;
			if(isset($_COOKIE['keep_login']) and $_COOKIE['keep_login'] != ''){

				// 找一下有沒有cookie登入的東西
				$row = $db->createCommand()
				->select('*')
				->from('keep_login')
				->where('hash=:hash', array(':hash' => $_COOKIE['keep_login']))
				->queryRow();
				if($row !== false){
					// 如果有的話，利用帳號帶出其它的欄位
					$user_row = $db->createCommand()
					->select('*')
					->from('member')
					->where('login_account=:account', array(':account' => $row['login_account']))
					->queryRow();
					if($user_row !== false){
						// 因為有公司的連絡人名稱、公司名稱、個人名稱，所以這裡做一個判斷
						$name = '';
						$name = $user_row['name'];
						Yii::app()->session->add('auth_admin_id', $user_row['id']);  
						Yii::app()->session->add('auth_admin_type', $user_row['login_type']);  
						Yii::app()->session->add('auth_admin_account', $row['login_account']);  
						Yii::app()->session->add('auth_admin_name', $name);  
						Yii::app()->session->add('auth_admin_ml_key', $user_row['ml_key']);  
						Yii::app()->session->add('auth_admin_is_hidden', $user_row['is_hidden']);  

						// 順便登入使用者的前台
						//Yii::app()->session->add('authw_admin_id', $user_row['id']);  
						//Yii::app()->session->add('authw_admin_account', $row['login_account']);  
						//Yii::app()->session->add('authw_admin_name', $name);  

						// auth_admin_interface_ml_key 不需要，就用預設的
						$this->redirect($this->createUrl('auth/main'));
					}
				}
			}

			$string = 'ip';
			$is_return = '1';
			$lf = new Load_other_file;
			$ip = $lf->load($string, '', $is_return);

			//if(file_exists(_BASEPATH.'/backend/controllers/AuthlocalController.php')){
			if(file_exists(target_app_name.'/controllers/AuthlocalController.php')){
				$this->data['have_auto_login'] = @file_get_contents('http://'.$_SERVER['HTTP_HOST'].$this->createUrl('authlocal/check', array('return'=>'aa', 'ip_tmp'=>$ip)));
				// 空白，或是長度大於１，都算檢查失敗
				if(strlen($this->data['have_auto_login']) > 1){
					$this->data['have_auto_login'] = '';
				}
			}

			//lota fix no captcha 2016.10.03
			if(isset(Yii::app()->session['error_num'])){
				if(Yii::app()->session['error_num'] < 2){
					$this->data['have_auto_login'] = '1';
				}else
					$this->data['have_auto_login'] = '';
			}else{
				$this->data['have_auto_login'] = '1';
				Yii::app()->session['error_num'] = 0;
			}


			if(isset(Yii::app()->session['error_num']) && Yii::app()->session['error_num'] < 2)
				$this->data['have_auto_login'] = '1';


			// 用Facebook快速登入，2017-03-17有跟小李報告過
			// 這裡是下半部
			if(isset($_COOKIE['_buyersline_crm2_user_facebook_id']) and $_COOKIE['_buyersline_crm2_user_facebook_id'] != ''){
				$login_status = false;
				// 這裡有兩種情況，一個是fb送出前，一個是fb送出後
				if(isset($_SESSION['_buyersline_fb_user_facebook_id']) and $_SESSION['_buyersline_fb_user_facebook_id'] != ''){
					if($_COOKIE['_buyersline_crm2_user_facebook_id'] == $_SESSION['_buyersline_fb_user_facebook_id']){

						// 去EIP抓使用者資料
						$public_key = EIP_APIV1_PUBLICKEY;
						$private_key = EIP_APIV1_PRIVATEKEY;
						$server_ip = EIP_APIV1_DOMAIN;
						$url = 'index.php?r=api/websitefbauth';

						$params = array(
							'facebook_id' => $_SESSION['_buyersline_fb_user_facebook_id'],
						);

						// 這支是客戶端
						$postdata = http_build_query(
							array(
								'get_client_code' => '',
							)
						);
						$opts = array('http' =>
							array(
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => $postdata
							)
						);
						$context = stream_context_create($opts);
						$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

						//$code = stripslashes($code);
						eval('?'.'>'.$code);

						unset($row);
						if(isset($return) and count($return) > 0){
							$row = $return;
						}
						if(isset($row) and $row !== false){
							$login_status = true;
						} else {
							$login_status = false;
						}
					} else {
						$login_status = false;
					}

					// 清掉，不然下次不用正常流程就可以fb登入
					unset($_SESSION['_buyersline_fb_user_facebook_id']);

					if($login_status === false){
						unset($_COOKIE['_buyersline_crm2_user_facebook_id']);
						setcookie('_buyersline_crm2_user_facebook_id', null, -1);
						header('Location: '.FRONTEND_DOMAIN);die;
					}

					Yii::app()->session->add('auth_admin_id', $row['id']);  
					Yii::app()->session->add('auth_admin_type', $row['login_type']);  
					Yii::app()->session->add('auth_admin_account', $row['login_account']);  
					Yii::app()->session->add('auth_admin_name', $row['name']);  
					Yii::app()->session->add('auth_admin_ml_key', $row['ml_key']);  
					Yii::app()->session->add('auth_admin_is_hidden', $row['is_hidden']);  

					Yii::app()->session['auth_admin_interface_ml_key'] = '';

					// 登入成功也要記錄
					sys_log::set('auth success: '.$row['login_account']);

					$this->redirect($this->createUrl('auth/main'));
				} else {
					// 如果cookie有建立的話，預設會全自動後台登入
					// 所以登出的時候，要順便刪掉cookie，避免全自動
					header('Location: '.FRONTEND_DOMAIN.'/fb.php');die;
				}
			}

				//var_dump(apache_request_headers());die;

			//$this->render('login', array('status' => $status));

			// 不要太care login"7" 這個數字
			$this->display('login7.htm', $this->data);
		} else {
			if(!isset($_POST['login_account']) or $_POST['login_account'] == '' or !isset($_POST['login_password']) or $_POST['login_password'] == ''){
				$this->redirect($this->createUrl('auth/login', array('status' => '1', 'current_base64_url' => $_POST['current_base64_url'])));
			}

			$login_account = $_POST['login_account'];
			$login_password = $_POST['login_password'];

			$current_base64_url = '';
			if(isset($_POST['current_base64_url'])){
				$current_base64_url = $_POST['current_base64_url'];
			}

			$db = Yii::app()->db;

			$string = 'ip';
			$is_return = '1';
			$lf = new Load_other_file;
			$ip = $lf->load($string, '', $is_return);

			//https://devco.re/blog/2014/06/03/http-session-protection/ by lota
			session_regenerate_id();
			Yii::app()->session['LAST_REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
			Yii::app()->session['LAST_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];

			// 如果有自動登入的功能，就不用檢查驗證碼
			$have_auto_login = '';
			if(file_exists(_BASEPATH.'/backend/controllers/AuthlocalController.php')){
				$have_auto_login = @file_get_contents('http://'.$_SERVER['HTTP_HOST'].$this->createUrl('authlocal/check', array('return'=>'aa', 'ip_tmp'=>$ip)));
				// 空白，或是長度大於１，都算檢查失敗
				if(strlen($have_auto_login) > 1){
					$have_auto_login = '';
				}
			}

			//lota fix no captcha 2016.10.03
			if(isset(Yii::app()->session['error_num']) && Yii::app()->session['error_num'] < 2)
				$have_auto_login = '1';

			// 檢查驗證正不正確
			if($have_auto_login == ''){
				if(!isset($_POST['captcha']) or Yii::app()->session['captcha'] != $_POST['captcha']){
					Yii::app()->session['error_num'] = Yii::app()->session['error_num']  +1;//lota fix no captcha 2016.10.03
					$this->redirect($this->createUrl('auth/login', array('status' => '2')));
				}
			}

			if(preg_match('/^buyersline_(.*)$/', $login_account) and defined('EIP_APIV1_DOMAIN') and defined('EIP_APIV1_PUBLICKEY') and defined('EIP_APIV1_PRIVATEKEY')){
				$public_key = EIP_APIV1_PUBLICKEY;
				$private_key = EIP_APIV1_PRIVATEKEY;
				$server_ip = EIP_APIV1_DOMAIN;
				$url = 'index.php?r=api/websiteauth';

				$params = array(
					'login_account' => $login_account,
					'login_password' => $login_password,
				);


				// 這支是客戶端

				/*
				 * 這是file_get_contents的版本
				 */
				// $postdata = http_build_query(array('get_client_code'=>''));
				// $opts = array('http' =>
				// 	array(
				// 		'method'  => 'POST',
				// 		'header'  => 'Content-type: application/x-www-form-urlencoded',
				// 		'content' => $postdata
				// 	)
				// );
				// $context = stream_context_create($opts);
				// $code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

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

				//var_dump($return);die;

				if(isset($return) and count($return) > 0){
					$row = $return;
				}
			} else {
				// 先檢查所使用的加密方式
				$row = $db->createCommand()
				->from('member')
				->where('login_account=:account AND is_enable=1', array(':account' => $login_account))
				->queryRow();

				// (為了能夠擴展加密方式)
				// 找一下有沒有存在的帳號在資料庫裡面
				// 這樣子寫，是為了讓新舊加密方式都可以同時存在，以及使用
				if(isset($row['login_password']) and preg_match('/^\{GGG(.*)AAA\}/', $row['login_password'], $matches)){
					if($matches[1] == '2'){
						if(!isset($row['salt'])){
							echo '[error] loss salt field';
							die;
						}
						$row = $db->createCommand()
						->from('member')
						->where('login_account=:account AND login_password=:password AND is_enable=1', array(':account' => $login_account, ':password' => '{GGG3AAA}'.sha1($login_password.$row['salt'])))
						->queryRow();
					} elseif($matches[1] == '3'){
						if(!isset($row['salt'])){
							echo '[error] loss salt field';
							die;
						}
						$row = $db->createCommand()
						->from('member')
						->where('login_account=:account AND login_password=:password AND is_enable=1', array(':account' => $login_account, ':password' => '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($login_password.$row['salt'])))))
						->queryRow();
					} else {
						$row = false;
					}
				} else {
					$row = $db->createCommand()
					->from('member')
					->where('login_account=:account AND login_password=:password AND is_enable=1', array(':account' => $login_account, ':password' => sha1($login_password)))
					->queryRow();
				}

			}

			$login_status = false;

			if(isset($row) and $row !== false){
				$login_status = true;
			}

			//if(!isset($current_base64_url)){
			//	$_POST['current_base64_url'] = '';
			//}

			if($login_status === false){
				Yii::app()->session['captcha'];
				Yii::app()->session['error_num'] = Yii::app()->session['error_num'] +1;//lota fix no captcha 2016.10.03
				// 登入失敗要記錄
				sys_log::set('auth fail: '.$login_account.', '.$login_password);
				$this->redirect($this->createUrl('auth/login', array('status' => '3', 'current_base64_url' => $current_base64_url)));
			}

			// 找一下資料表裡面有沒有這筆資料，有的話改一下更新時間，沒有的話就建立
			$keep_row = $db->createCommand()
			->select('*')
			->from('keep_login')
			->where('login_account=:account AND ip=:ip AND browser=:browser', array(':account' => $row['login_account'], ':ip' => $_SERVER['REMOTE_ADDR'], ':browser' => $_SERVER['HTTP_USER_AGENT']))
			->queryRow();
			$keep_login_exists = false;
			if($keep_row !== false){
				$keep_login_exists = true;
			}

			// 是否要保持登入
			$keep_login = '';
			if(isset($_POST['keep_login']) and $_POST['keep_login'] == '1'){
				$keep_login = md5('cloud1'.$row['name'].$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].'cloud2');
				//$_COOKIE['keep_login'] = $keep_login;
				Yii::app()->request->cookies['keep_login'] = new CHttpCookie('keep_login', $keep_login);

				if($keep_login_exists){
					$sql="UPDATE keep_login SET create_time = NOW() WHERE login_account = :account AND ip = :ip AND browser = :browser";
					$command=$db->createCommand($sql);
					$command->bindParam(":account",$row['login_account'],PDO::PARAM_STR);
					$command->bindParam(":ip",$_SERVER['REMOTE_ADDR'],PDO::PARAM_STR);
					$command->bindParam(":browser",$_SERVER['HTTP_USER_AGENT'],PDO::PARAM_STR);
					$command->execute();
				} else {
					$sql="INSERT INTO keep_login (login_account, ip, browser, hash, create_time) VALUES(:account, :ip, :browser, :hash, NOW())";
					$command=$db->createCommand($sql);
					// PDO::PARAM_STR
					// PDO::PARAM_INT
					$command->bindParam(":account", $row['login_account'],PDO::PARAM_STR);
					$command->bindParam(":ip", $_SERVER['REMOTE_ADDR'],PDO::PARAM_STR);
					$command->bindParam(":browser", $_SERVER['HTTP_USER_AGENT'],PDO::PARAM_STR);
					$command->bindParam(":hash", $keep_login,PDO::PARAM_STR);
					$command->execute();
				}
			} else {
				// 如果使用者沒有勾，但是資料庫裡面有他的資料，那就砍了它
				if($keep_login_exists){
				}
			}

			$name = '';
			$name = $row['name'];

			Yii::app()->session->add('auth_admin_id', $row['id']);  
			Yii::app()->session->add('auth_admin_type', $row['login_type']);  
			Yii::app()->session->add('auth_admin_account', $row['login_account']);  
			Yii::app()->session->add('auth_admin_name', $name);  
			Yii::app()->session->add('auth_admin_ml_key', $row['ml_key']);  
			Yii::app()->session->add('auth_admin_is_hidden', $row['is_hidden']); 

			//2019-9-26 增加管理者限定操作語系 by lota
			if(isset($row['ml_key_access']) && $row['ml_key_access']!='' ){
				Yii::app()->session['check_data_ml_key'] = array_filter(explode(',',$row['ml_key_access'])); 
			}
			

			// 順便登入使用者的前台
			//Yii::app()->session->add('authw_admin_id', $row['id']);  
			//Yii::app()->session->add('authw_admin_account', $row['login_account']);  
			//Yii::app()->session->add('authw_admin_name', $name);  

			if(isset($_POST['select_language']) and $_POST['select_language'] != ''){
				Yii::app()->session->add('auth_admin_interface_ml_key', $_POST['select_language']);  
			} else {
				Yii::app()->session['auth_admin_interface_ml_key'] = '';
			}

			// 登入成功也要記錄
			sys_log::set('auth success: '.$login_account);

			if(isset($current_base64_url) and $current_base64_url != ''){
				$this->redirect(base64url::decode($current_base64_url));
			} else {
				$this->redirect($this->createUrl('auth/main'));
			}
		}
	}

	public function actionCaptcha2()
	{
		// 這裡是原有的captcha產生碼的方式，部份拿到這裡使用
		$CheckStr = '0123456789';
		$angel_set = array(0,2,4,6,8,10,12,14,16,18,20,-2,-4,-6,-8,-10,-12,-14,-16,-18,-20);
		$code = '';
		for($i=0; $i<4; $i++) {
			srand((double)microtime()*1000000); 
			$rndFont = rand();
			srand((double)microtime()*1000000); 
			$dd = (rand() % strlen($CheckStr));
			srand((double)microtime()*1000000); 
			$aa = (rand() % count($angel_set));
			$ckChar = substr($CheckStr, $dd, 1);
			$code .= $ckChar;
			//$N_color = (rand() % count($num_color));
			// 字型
			//ImageTTFText ($im, 18, $angel_set[$aa], 2+($i*rand(16, 18)), 20, $num_color[$N_color], $font_file[$rndFont], $ckChar); 
			//ImageTTFText ($im, 20, $angel_set[$aa], 8+($i*rand(20, 23)), 22, $num_color[$N_color], $font_file[$rndFont], $ckChar);
		}

		// 這裡是phpbb所使用的captcha程式
		// https://www.phpbb.com/community/viewtopic.php?t=473222
		/**
		  * The next part is orginnaly written by ted from mastercode.nl and modified for using in this mod.
		  **/
		header("content-type:image/png");
		header('Cache-control: no-cache, no-store');
		//$code = 'abc';
		$width = 96;
		$height = 45;
		$img = imagecreatetruecolor($width,$height);
		$background = imagecolorallocate($img, $this->captcha2_color("bg"), $this->captcha2_color("bg"), $this->captcha2_color("bg"));

		srand($this->captcha2_make_seed());

		imagefilledrectangle($img, 0, 0, 249, 59, $background);
		for($g = 0;$g < 30; $g++)
		{
			//$t = dss_rand();
			//$t = $t[0];
			$t='abc';

			$ypos = rand(0,$height);
			$xpos = rand(0,$width);

			$kleur = imagecolorallocate($img, $this->captcha2_color("bgtekst"), $this->captcha2_color("bgtekst"), $this->captcha2_color("bgtekst"));

			imagettftext($img, $this->captcha2_size(), $this->captcha2_move(), $xpos, $ypos, $kleur, $this->captcha2_font(), $t);
		}
		$stukje = $width / (strlen($code) + 3);

		for($j = 0;$j < strlen($code); $j++)
		{


			$tek = $code[$j];
			$ypos = rand(35,41);
			$xpos = $stukje * ($j+1);

			$color2 = imagecolorallocate($img, $this->captcha2_color("tekst"), $this->captcha2_color("tekst"), $this->captcha2_color("tekst"));

			imagettftext($img, $this->captcha2_size(), $this->captcha2_move(), $xpos, $ypos, $color2, $this->captcha2_font() , $tek);
		}

		Yii::app()->session['captcha'] = $code;

		imagepng($img);
		imagedestroy($img);
		die;
	}
	/**
	  * Some functions :)
	  * Also orginally written by mastercode.nl
	  **/
	/**
	  * Function to create a random color
	  * @auteur mastercode.nl
	  * @param $type string Mode for the color
	  * @return int
	  **/
	private function captcha2_color($type)
	{
		switch($type)
		{
			case "bg":
				$color = rand(224,255);
			break;
			case "tekst":
				$color = rand(0,127);
			break;
			case "bgtekst":
				$color = rand(200,224);
			break;
			default:
				$color = rand(0,255);
			break;
		}
		return $color;
	}
	/**
	  * Function to ranom the size
	  * @auteur mastercode.nl
	  * @return int
	  **/
	private function captcha2_size()
	{
		return rand(18,30);
	}
	/**
	  * Function to random the posistion
	  * @auteur mastercode.nl
	  * @return int
	  **/
	private function captcha2_move()
	{
		return rand(-22,22);
	}
	/**
	  * Function to return a ttf file from fonts map
	  * @auteur mastercode.nl
	  * @return string
	  **/
	private function captcha2_font()
	{
		return _BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'haldanor.ttf';

		global $phpbb_root_path,$phpEx;
		static $ar;
		$f = opendir($phpbb_root_path . 'includes/fonts');
		if(!is_array($ar))
		{
			$ar = array();
			while(($file = @readdir($f)) !== false)
			{
				if(!in_array($file,array('.','..')) && eregi('.ttf',$file))
				{
					$ar[] = $file;
				}
			}
		}
		if(count($ar))
		{
		//	shuffle($ar);
			$i = rand(0,(count($ar) - 1));
			return $phpbb_root_path . 'includes/fonts/' . $ar[$i];
		}
		else
		{
			//There where NO font files. Included old confirm code.
			require($phpbb_root_path . 'includes/usercp_confirm.' . $phpEx);
			die;
		}
	}
	private function captcha2_make_seed()
	{
	   list($usec, $sec) = explode(' ', microtime());
	   return (float) $sec + ((float) $usec * 100000);
	}

	public function actionCaptcha()
	{
		$im = @ImageCreate (96, 25) or die ('Cannot Initialize new GD image stream'); 
		//$bgCol = array(
		//	array('R'=>250, 'G'=>250, 'B'=>250),
		//	array('R'=>251, 'G'=>251, 'B'=>251),
		//	array('R'=>252, 'G'=>252, 'B'=>252),
		//	array('R'=>253, 'G'=>253, 'B'=>253),
		//	array('R'=>254, 'G'=>254, 'B'=>254)
		//);
		//$n = round(rand(0, (count($bgCol)-1)));
		//$background_color = ImageColorAllocate ($im, $bgCol[$n]['R'], $bgCol[$n]['G'], $bgCol[$n]['B']);
		$background_color = ImageColorAllocate ($im, 221, 221, 221);
		$text_color = ImageColorAllocate ($im, 0, 0, 0);
		$num_color = array(
			ImageColorAllocate ($im, 128, 0, 0),
			ImageColorAllocate ($im, 0, 128, 0),
			ImageColorAllocate ($im, 0, 0, 128),
			ImageColorAllocate ($im, 255, 80, 0),
			ImageColorAllocate ($im, 0, 128, 80),
			ImageColorAllocate ($im, 0, 80, 255),
			ImageColorAllocate ($im, 255, 0, 80),
			ImageColorAllocate ($im, 80, 0, 255),
			ImageColorAllocate ($im, 128, 128, 0),
			ImageColorAllocate ($im, 0, 128, 128));

		// 將背景色(白色)
		// 改成透明(拿掉就變灰色了)
		$white = imagecolorallocate($im, 255, 255, 255);
		imagefill($im, 0, 0, $white);
		imagecolortransparent($im, $white);

		$line_color = ImageColorAllocate ($im, 128, 128, 128);
		$CheckStr = '0123456789';
		$font_file = array (
			//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'oneway.ttf',
			//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'arcade_r.ttf',
			//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'colourmepurple.ttf',
			_BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'haldanor.ttf',
		);
		// 旋轉角度
		$angel_set = array(0,2,4,6,8,10,12,14,16,18,20,-2,-4,-6,-8,-10,-12,-14,-16,-18,-20);
		$SCode = '';
		for($i=0; $i<4; $i++) {
			srand((double)microtime()*1000000); 
			$rndFont = (rand() % count($font_file));
			srand((double)microtime()*1000000); 
			$dd = (rand() % strlen($CheckStr));
			srand((double)microtime()*1000000); 
			$aa = (rand() % count($angel_set));
			$ckChar = substr($CheckStr, $dd, 1);
			$SCode .= $ckChar;
			$N_color = (rand() % count($num_color));
			// 字型
			//ImageTTFText ($im, 18, $angel_set[$aa], 2+($i*rand(16, 18)), 20, $num_color[$N_color], $font_file[$rndFont], $ckChar); 
			ImageTTFText ($im, 20, $angel_set[$aa], 8+($i*rand(20, 23)), 22, $num_color[$N_color], $font_file[$rndFont], $ckChar);
		}

		Yii::app()->session['captcha'] = $SCode;

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
        header("Cache-Control: no-store, no-cache, must-revalidate"); 
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
		header('Content-type: image/png');
		imagepng ($im);
		imagedestroy ($im);
		exit();
	}

	// 試著純登出，來測試Cookie持續登入是否能夠正常使用
	//public function actionTestlogout()
	//{
	//	Yii::app()->session->destroy();
	//	die;
	//}

	public function actionLogout($current_base64_url = '')
	{
		Yii::app()->session->destroy();

		// 如果有勾保持登入狀態的話，就不需要在登入一次，重新寫入session
		$db = Yii::app()->db;
		if(isset($_COOKIE['keep_login']) and $_COOKIE['keep_login'] != ''){
			// 找一下有沒有cookie登入的東西
			$row = $db->createCommand()
			->select('*')
			->from('keep_login')
			->where('hash=:hash', array(':hash' => $_COOKIE['keep_login']))
			->queryRow();
			if($row !== false){
				// 如果真的有的話，就砍了它
				$user_row = $db->createCommand()
				->select('*')
				->from('member')
				->where('login_account=:account', array(':account' => $row['login_account']))
				->queryRow();
				if($user_row !== false){
					//$row['id']  
					$c = $db->createCommand();
					$c->delete('keep_login', 'id=:id', array(':id'=>$row['id']));
				}
			}

			// 砍Cookie
			unset(Yii::app()->request->cookies['keep_login']);
		}

		// 避免全自動Facebook登入後台
		unset($_COOKIE['_buyersline_crm2_user_facebook_id']);
		setcookie('_buyersline_crm2_user_facebook_id', null, -1);

		//if($current_base64_url != ''){
		//	$url = base64url::decode($current_base64_url);
		//	$this->redirect($url);
		//}
		$this->redirect('..');
	}

}

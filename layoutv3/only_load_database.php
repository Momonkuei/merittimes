<?php
use nguyenanhung\CodeIgniterDB as CI;

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


@session_start();


 $vendors_dir = 'layoutv3/vendors';
    ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

    include_once 'layoutv3/vendor/autoload.php';

    include '_i/config/db.php';

    $Db_Server = aaa_dbhost;
    $Db_User = aaa_dbuser;
    $Db_Pwd = aaa_dbpass;
    $Db_Name = aaa_dbname; 

    $tmps = array(
        'dsn'   => '',
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
    $cidb =& CI\DB($tmps, null, $rDb);




function email_send_to_by_sendmail(
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

			if(!empty($from) and isset($from['email']) and $from['email'] != ''
				and !empty($tos) and isset($tos[0]) and isset($tos[0]['email']) and $tos[0]['email'] != ''
			){
				/*
				 * 寄信開始
				 */
				//2016/12/19 lota Serverzoo 把 server2上的 mail()鎖定
				//require_once('Zend/Loader/Autoloader.php');
				//$autoloader = Zend_Loader_Autoloader::getInstance();
				//改用phpmailer

				// 2020/06/29 因Server1的IP黑了... 可改用中華電信 msa.hinet.net 寄信 (限定公司自架伺服器專用)
				$_hinet_send_mail = false;
			
				//2017/5/26 更新Phpmailer為5.2.23，這邊要額外載入class.smtp.php才能動 by lota
				include_once(dirname(dirname(__FILE__))."/_i/vendors/phpmailer/class.phpmailer.php");
				include_once(dirname(dirname(__FILE__))."/_i/vendors/phpmailer/class.smtp.php");
		
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

					if($_hinet_send_mail){
						$mail->Host = 'msa.hinet.net';
						$mail->Port = 465;
						$mail->SMTPSecure = "ssl";
						$mail->SMTPOptions = array(
						'ssl' => array(
						    'verify_peer' => false,
						    'verify_peer_name' => false,
						    'allow_self_signed' => true
						    )
						);
					}else{

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
					}

					
					$mail->IsSMTP(); // set mailer to use SMTP	

					
				
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

					if($_hinet_send_mail){
						$mail->Host = 'msa.hinet.net';
						$mail->Port = 465;
						$mail->SMTPSecure = "ssl";
						$mail->SMTPOptions = array(
						'ssl' => array(
						    'verify_peer' => false,
						    'verify_peer_name' => false,
						    'allow_self_signed' => true
						    )
						);
					}else{
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

					}


					$mail->IsSMTP(); // set mailer to use SMTP							
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
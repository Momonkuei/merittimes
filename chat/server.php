<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

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

$run = ' '."\n";
/*
 * DOM第二版初始化
 */
@session_start();
$simplehtml = ''; // 假裝init
$old_struct = true;
$_SESSION['web_ml_key'] = 'tw'; // 注意！！！預設語系不是繁體中文的網站，要記得改這裡
define('FRONTEND_DOMAIN','');
$goback_root_path = '../'; // 如果不是放根目錄，那就要提供，哪一個地方底下，的上幾層是根目錄

// 純參考而以，千千萬萬不要打開
// $Db_Server = 'localhost';
// $Db_User = 'ordertrading_use';
// $Db_Pwd = '';
// $Db_Name = 'rwd_v3'; 

include '../standalone_simplehtmldom.php';
include '../layoutv3/dom5.php';

// 先確認沒有抓錯網站
// $row = $cidb->get('sys_config')->row_array();
// var_dump($row);

define('_BASEPATH', __DIR__.'/../_i');

function get_client_ip_gggaaa() {
    $ip = 'UNKNOWN';
    $list = array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR', // 2017-07-31 李哥 HAPROXY
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP', // http://devco.re/blog/2014/06/19/client-ip-detection/
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
        'HTTP_VIA', // http://devco.re/blog/2014/06/19/client-ip-detection/
    );  

    foreach($list as $v){
        if(isset($_SERVER[$v])){
            $ip = $_SERVER[$v];
            break;
        }
    }   

    return $ip;
}

if(!empty($_POST) 
	and isset($_POST['website_id']) and $_POST['website_id'] != ''
	and isset($_POST['room_id']) and $_POST['room_id'] != ''
	and isset($_POST['func']) and $_POST['func'] != ''
){
	$website_id = $_POST['website_id'];
	$room_id = $_POST['room_id'];
	$func = $_POST['func'];

	$detail = ''; // 留言訊息
	if(isset($_POST['detail']) and $_POST['detail'] != ''){
		$detail = $_POST['detail'];
	}

	$member_id = 0; // 客服編號
	if(isset($_POST['member_id']) and $_POST['member_id'] != ''){
		$member_id = $_POST['member_id'];
	}

	// Debug
	// file_put_contents('123.txt',get_client_ip_gggaaa());
	// file_put_contents('123.txt',$room_id);
	
	if($func == 'save_member'){ // 2018-07-10 客服人員留言，必需經過主機授權
		$rowg = $cidb->where('id',$website_id)->where('ip',get_client_ip_gggaaa())->where('http',$_SERVER['HTTP_HOST'])->get('chat_website')->row_array();
	} else {
		$rowg = $cidb->where('id',$website_id)->get('chat_website')->row_array();
	}

	if($rowg and isset($rowg['id']) and $rowg['id'] > 0){
		if(preg_match('/^(save|save_member)$/', $func) and $detail != ''){
			// init
			$rowgg = $cidb->where('website_id',$website_id)->where('room_id',$room_id)->get('chat_message')->row_array();
			if($rowgg and isset($rowgg['id']) and $rowgg['id'] > 0){
				// do nothing
			} else {
				$save = array(
					'website_id' => $website_id,
					'room_id' => $room_id,
					'detail' => '__init__',
					'create_time' => date('Y-m-d H:i:s'),
				);
				$cidb->insert('chat_message', $save); 
			}

			$save = array(
				'website_id' => $website_id,
				'room_id' => $room_id,
				'detail' => $detail,
				'create_time' => date('Y-m-d H:i:s'),
			);
			if($func == 'save_member' and $member_id > 0){
				$save['member_id'] = $member_id;
			}
			$cidb->insert('chat_message', $save); 

			// 為了在後台，能夠看到該聊天室的排序，能夠依據最新的時間排序
			$cidb->where('website_id', $website_id);
			$cidb->where('room_id', $room_id);
			$cidb->where('detail', '__init__');
			$cidb->update('chat_message', array('create_time'=>date('Y-m-d H:i:s'),'last_message'=>$detail)); 

		} elseif(preg_match('/^(read|read_member)$/', $func)){
			$rowgg = $cidb->where('website_id',$website_id)->where('room_id',$room_id)->where('detail !=','__init__')->order_by('create_time','desc')->get('chat_message')->result_array();
			$result = '';

			if($rowgg and count($rowgg) > 0){
				foreach($rowgg as $k => $v){
					if($v['member_id'] <= 0){
						if($func == 'read_member'){
							$result .= '瀏覽者: '.$v['detail']."\n";
						} else {
							$result .= '你: '.$v['detail']."\n";
						}
					} else {
						if($func == 'read_member'){
							$result .= '你: '.$v['detail']."\n";
						} else {
							$result .= '客服: '.$v['detail']."\n";
						}
					}
				}
			}
			echo $result;
		}
	}
}

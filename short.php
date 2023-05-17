<?php

use nguyenanhung\CodeIgniterDB as CI;

/*
 * 短網址 Short
 */

/*
 * 2021-01-27
 * 這個東西最開始，只是為了做一個短網址的功能而以
 * 後來被購物站拿來使用，演化成一個新的角色
 * 有點類似Proxy
 * 也有點類似Port Address Translation (PAT)的動作
 * 
 * 當網站還沒有上線，還在內部的時候
 * short的角色，是由外部的EIP來擔當
 * 等到網站上線以後，short的角色，是放在網站本身
 *
 * 所以這個角色，就是做轉發的角色，
 */

/*
 * 資料表欄位
 * id			int(11) 主索引
 * id_number	varchar(100) 讓外面找到該筆資料的方式，不是依照id欄位哦
 * session_id	varchar(100)
 * func			varchar(100)
 * is_enable	tinyint(1)	 上線後，用完記得要用程式把它改成零，因為程式有權限操作資料庫；在內部未上線的時候，EIP的Short角色，看的是當天的那個小時內，以外的過期就自動失效
 *
 * url1			varchar(100) 幕前的html form post轉頁，目前是超商取貨不付款(action.php)裡面在使用的。早期的facebook and google login也會經過這裡，後來沒有用
 * 　└ back		varchar(100) 這個是url1相對應以及專用的欄位，url1那邊處理好之後，就會用php header location url1的方式，把頁面轉出去
 * 　└ log2_1	text		 綠界超商取貨C2C在使用的，買家用這個項目結帳後，後台shoporderform訂單管理裡面，會有將"物流訂單傳至綠界"的按鈕，按下去會有托運單的欄位出現
 * 　└ log2_2	text
 *
 * url2			varchar(100) 幕後傳東西，通常是由金流公司，回傳訂單狀態所使用的
 * 　└ log_1	text
 * 　└ log_2	text
 *
 */


function utf8_str_split($str, $split_len = 1){
	if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
		return false;
 
	$len = mb_strlen($str, 'UTF-8');
	if ($len <= $split_len)
		return array($str);
 
	preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
 
	return $ar[0];
}

//if(isset($_POST['MerchantTradeNo']) and $_POST['MerchantTradeNo'] == '200611000016'){
//	echo '1|OK';die;
//}

// $_GET['id'] = '52f616caa86c0f0';
// $_POST = array (
//   'CheckMacValue' => '885D62B24703AC6C47EF3BD15B86AD25',
//   'MerchantID' => '3198358',
//   'MerchantTradeNo' => '200611000016',
//   'PaymentDate' => '2020/06/11 15:09:03',
//   'PaymentType' => 'Credit_CreditCard',
//   'PaymentTypeChargeFee' => '5',
//   'RtnCode' => '1',
//   'RtnMsg' => 'paid',
//   'SimulatePaid' => '0',
//   'TradeAmt' => '39',
//   'TradeDate' => '2020/06/11 15:08:15',
//   'TradeNo' => '2006111508153604',
// );


// debug
// file_put_contents('123.txt',var_export($_POST,true),FILE_APPEND);
// file_put_contents('123.txt',var_export($_GET,true),FILE_APPEND);
//file_put_contents('123.txt','id_number='.$id_number."\n",FILE_APPEND);

//include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
//include 'layoutv3/libs.php'; // pre_render
//include 'source/core_seo.php';

$id_number = '';
if(isset($_GET['id'])){
	$id_number = $_GET['id'];
//} elseif(isset($_GET['CustomField1'])){
//	$id_number = $_GET['CustomField1'];
}

// $id = substr($id2, 0, 1);
// $id_number = substr($id2, 1);

$get = array();
$_count = count($_GET);
if($_count > 1){
	unset($_GET['id']);
	$get = $_GET;
}

$post = $_POST;
//unset($post['id']);


//$vendors_dir = _BASEPATH.'/vendors';
$vendors_dir = 'layoutv3/vendors';
ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

// composer autoload 2018-12-18
//include_once GGG_BASEPATH.'../vendor/autoload.php';
include_once 'layoutv3/vendor/autoload.php';

include '_i/config/db.php';

$Db_Server = aaa_dbhost;
$Db_User = aaa_dbuser;
$Db_Pwd = aaa_dbpass;
$Db_Name = aaa_dbname; 

// CI2
// $tmps = array(
// 	'dbdriver' => 'mysql',
// 	'username' => $Db_User,
// 	'password' => $Db_Pwd,
// 	'hostname' => $Db_Server,
// 	'port' => 3306,
// 	'database' => $Db_Name,
// 	// 'db_debug' => true
// );

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

// EIP Short專用(1/2)
//$row = $this->db->createCommand()->from('short')->where('is_enable=1 and id_number=:id_number and create_time like "'.date('Y-m-d H:').'%"',array(':id_number'=>$id_number))->queryRow();

// 子站專用
//$row = $this->db->createCommand()->from('short')->where('is_enable=1 and id_number=:id_number',array(':id_number'=>$id_number))->queryRow();
$row = $db->where('is_enable',1)->where('id_number',$id_number)->get('short')->row_array();
//file_put_contents('123.txt',var_export($row,true),FILE_APPEND);
if($row and isset($row['id'])){
	//    // 將log解開，這一樣程式碼是從購物站 / shoporderform裡面複製過來的
	//    $log_txt = '';
	//    for($x=1;$x<=20;$x++){
	//    	if(isset($row['log_'.$x])){
	//    		$log_txt .= $row['log_'.$x];
	//    	}
	//    }
	//    eval($log_txt);
	//    $row['details'] = $log;

	// 留存
	$update = array();
	$post_result = utf8_str_split('$log='.var_export($post,true).';', intval(65535*0.7));
	foreach($post_result as $k => $v){
		$update['log_'.($k+1)] = $v;
	}

	if(!empty($get)){
		$get_result = utf8_str_split('$log2='.var_export($get,true).';', intval(65535*0.7));
		foreach($get_result as $k => $v){
			$update['log2_'.($k+1)] = $v;
		}
	}

	// EIP Short專用(2/2)
	// $update['is_enable'] = 0; 
	
	$db->where('id', $row['id']);
	$db->update('short', $update); 

    if(isset($row['url2']) and $row['url2'] != ''){ // 傳東西
        $post['_from_short'] = '1';
        $post['_session_id'] = $row['session_id'];
        $post['_func'] = $row['func'];
        $post['_id_number'] = $row['id_number']; // 為了能回來刪資料

        if(isset($get) and !empty($get)){
            foreach($get as $k => $v){
                $post['_get_'.$k] = $v;
            }
        }

        $postdata = http_build_query(
            $post
        );

        // $opts = array('http' =>
        //     array(
        //         'method'  => 'POST',
        //         'header'  => 'Content-type: application/x-www-form-urlencoded',
        //         'content' => $postdata
        //     )
        // );
        // $context = stream_context_create($opts);
        // $code = file_get_contents($row['url2'], false, $context);

		// $options = array(
		// 	CURLOPT_URL => $row['url2'],
		// 	CURLOPT_HEADER => 0,
		// 	CURLOPT_VERBOSE => 0,
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
		// 	CURLOPT_POST => true,
		// 	CURLOPT_POSTFIELDS => $postdata,
		// );  
		// curl_setopt_array($ch, $options);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $row['url2']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //這個是重點,規避ssl的證書檢查。
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 1); // CURLOPT_TIMEOUT_MS

		// debug
		//curl_setopt($ch, CURLOPT_VERBOSE, 1);
		//curl_setopt($ch, CURLOPT_HEADER, 1);

		$code = curl_exec($ch); 

		// debug
		//$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		//$header = substr($output, 0, $header_size);

		curl_close($ch);

    } elseif(isset($row['url1']) and $row['url1'] != ''){ // 轉頁

		$szHtml =  '<!DOCTYPE html>';
		$szHtml .= '<html>';
		$szHtml .=     '<head>';
		$szHtml .=         '<meta charset="utf-8">';
		$szHtml .=     '</head>';
		$szHtml .=     '<body>';
		$szHtml .=         '<form id="ECPayForm" method="POST" action="'.$row['url1'].'" target="_self">';

		if($post and !empty($post)){
			foreach($post as $k => $v){
		$szHtml .= '            <input type="hidden" name="'.$k.'" value="'.$v.'" />';
			}
		}

        if(isset($get) and !empty($get)){
            foreach($get as $k => $v){
        $szHtml .= '            <input type="hidden" name="_get_'.$k.'" value="'.$v.'" />';
            }
        }

		$szHtml .= '            <input type="hidden" name="_from_short" value="1" />';
		$szHtml .= '            <input type="hidden" name="_session_id" value="'.$row['session_id'].'" />';
		$szHtml .= '            <input type="hidden" name="_func" value="'.$row['func'].'" />';
		$szHtml .= '            <input type="hidden" name="_id_number" value="'.$row['id_number'].'" />'; // 為了能回來刪資料
		$szHtml .= '            <input type="hidden" name="_back" value="'.$row['back'].'" />'; // 為了能回來刪資料
		$szHtml .=         '</form>';
		$szHtml .=         '<script type="text/javascript">document.getElementById("ECPayForm").submit();</script>';
		$szHtml .=     '</body>';
		$szHtml .= '</html>';
		echo $szHtml ;
		exit;
	}
}

die;

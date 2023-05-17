<?php
/*
 * L，代表L(Lota)的首字
 * 2016/3/7 開始嘗試寫自己的function
 */

class L 
{
	//2017/5/10 手機電話顯示格式化
	public static function format_cellphone($phone = '')
	{
	if($phone!=''){
		$phone = preg_replace("/[^0-9]/", "", $phone);
	}	 
	 if(strlen($phone) == 10){ // 手機
	  return preg_replace("/([0-9]{4})([0-9]{6})/", "$1-$2", $phone);
	 }else{
	  return $phone;
	 }
	 //elseif(strlen($phone) == 10)
	 // return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/","($1) $2-$3",$phone);	 
	}


	//2016/7/22 圖片語系判斷
	public static function imgt($label = '',$img_type)
	{
		//目前使用的語系
		$lang = Yii::app()->session['web_ml_key'];
		if($label != ''){
			$file_name = str_replace('./','',str_replace('../','',str_replace($img_type,'',$label)));
			$tmp = $file_name.'_'.$lang.$img_type;
				if(!is_file($tmp)) $tmp = $file_name.$img_type;
			return $tmp;
		}else{
			return 'images/';
		}
	}


	public static function top($category = '', $label = '')
	{
		//讀取片語索引 web
		if($category == ''){
			$category = theme_lang;
		}	
		//目前使用的語系
		$lang = Yii::app()->session['web_ml_key'];

		if($label != ''){
			$db = Yii::app()->db;
			$row = $db->createCommand()->from('html')->where('type=:type and topic=:topic',array(':type'=>'webmenu','topic'=>$label))->queryRow();
			$str = '';
			if($row and count($row)){
				if($row['ml_key']!=$lang){
					switch($lang){
						case 'en':
							$str = $row['other1'];
							break;
						case 'tw':
							$str = $row['topic'];
							break;
						case 'cn':
							$str = $row['other3'];
							break;
						case 'jp':
							$str = $row['other4'];
							break;
						case 'sp':
							$str = $row['video_1'];
							break;
					}					
					if($str=='')
						$str = $label;
				}else{
					$str = $row['topic'];
				}
			}else
				$str = $label;
		}else
			$str = $label;

		return $str;
	}
	//移植cttdemo的utf8字串截字
	public static function utf8_substr($string, $start, $sublen, $code = 'UTF-8') {
		if(strtoupper($code) == 'UTF-8') {
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);

			if(count($t_string[0]) - $start > $sublen) 
				return join('', array_slice($t_string[0], $start, $sublen));
			else 
				return $string;
		} else {
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';
			for($i=0; $i<$strlen; $i++) {
				if($i>=$start && $i<($start+$sublen)) {
					if(ord(substr($string, $i, 1))>129) 
					$tmpstr.= substr($string, $i, 2);
					else 
					$tmpstr.= substr($string, $i, 1);
				}
				if(ord(substr($string, $i, 1))>129) $i++;
			}
			if(strlen($tmpstr)<$strlen ) $tmpstr.= "..";
			return $tmpstr;
		}
	}
	//前台 解無限層產品分類 
	public static function producttype_layer($id,$lay_num = 0,$tt = '', $data = array())
	{
		if($id){
			$db = Yii::app()->db;
			$tmp = $db->createCommand()->from('producttype')->where('is_enable=1 and ml_key=:ml_key and pid='.$id,array(':ml_key'=>Yii::app()->session['web_ml_key']))->order('sort_id')->queryAll();
			$ggg = array();$k = 0;
			$tt .= '&id'.($lay_num+1).'='.$id;
			foreach($tmp as $k => $v){
				$v['topic'] = $v['name'];				
				$v['url'] = '/index.php?r=site/product&id='.$v['id'].$tt;//id : 本身ID 
				$v['childs_'.($lay_num+1)] = L::producttype_layer($v['id'],$lay_num +1,$tt);
				if(count($v['childs_'.($lay_num+1)]) < 1) unset($v['childs_'.($lay_num+1)]);
				$data[$k] = $v;
			}
			return $data;
		}else
			return $data;
	}

	//前台 解無限層分類 for kingfoam
	public static function unlimited_layer($id,$table = 'product',$label_name = 'id',$ml_key = '',$lay_num = 0,$tt = '', $data = array())
	{
		if($id){
			$db = Yii::app()->db;
			$tmp = $db->createCommand()->from($table.'type'.$ml_key)->where('is_enable=1 and ml_key=:ml_key and pid='.$id,array(':ml_key'=>Yii::app()->session['web_ml_key']))->order('sort_id')->queryAll();
			$ggg = array();$k = 0;
			$tt .= '&'.$label_name.($lay_num+1).'='.$id;
			foreach($tmp as $k => $v){
				$v['topic'] = $v['name'];				
				$v['url'] = 'index.php?r=site/'.$table.'&'.$label_name.'='.$v['id'].$tt;//id : 本身ID 
				$v['childs_'.($lay_num+1)] = L::unlimited_layer($v['id'],$table,$label_name,$ml_key,$lay_num +1,$tt,array());
				if(count($v['childs_'.($lay_num+1)]) < 1) unset($v['childs_'.($lay_num+1)]);
				$data[$k] = $v;
			}
			return $data;
		}else
			return $data;
	}
	
	//前台 解無限層分類 (資料表無後綴) for tcim
	public static function unlimited_layer_nosuffix($id,$table = 'product',$label_name = 'id',$ml_key = '',$lay_num = 0,$tt = '', $data = array())
	{
		if($id){
			$db = Yii::app()->db;
			$ml_key = ($ml_key)?$ml_key:Yii::app()->session['web_ml_key'];
			$tmp = $db->createCommand()->from($table.'type')->where('is_enable=1 and ml_key=:ml_key and pid='.$id,array(':ml_key'=>$ml_key))->order('sort_id')->queryAll();
			$ggg = array();$k = 0;
			$tt .= '&'.$label_name.($lay_num+1).'='.$id;
			foreach($tmp as $k => $v){
				$v['topic'] = $v['name'];				
				$v['url'] = 'index.php?r=site/'.$table.'&'.$label_name.'='.$v['id'].$tt;//id : 本身ID 
				$v['childs_'.($lay_num+1)] = L::unlimited_layer_nosuffix($v['id'],$table,$label_name,$ml_key,$lay_num +1,$tt,array());
				if(count($v['childs_'.($lay_num+1)]) < 1) unset($v['childs_'.($lay_num+1)]);
				$data[$k] = $v;
			}
			return $data;
		}else
			return $data;
	}

	//2016/11/09 lota fix ml_key
	public static function top_class_excavation($id,$table = 'product' , $out_type = 'id',$ml_key = '',$data = '')
	{		
		if($id){
			$db = Yii::app()->db;
			$ml_key = ($ml_key)?$ml_key:Yii::app()->session['web_ml_key'];
			$tmp = $db->createCommand()->from($table.'type')->where('is_enable=1 and ml_key=:ml_key and id='.$id,array(':ml_key'=>$ml_key))->order('sort_id')->queryRow();
			if($tmp['pid']!=0){
				$ggg = L::top_class_excavation($tmp['pid'],$table,$out_type,$ml_key);
				if($ggg=='')
					$data = $tmp[$out_type];
				else
					$data = $ggg;
				return $data;
			}else{
				$data = $tmp[$out_type];
				return $data;
			}
		}
	}
/* // 2016/5/17 
	public static function unlimited_crumbs($id,$table = 'product',$label_name = 'id',$get = array(),$source = array(),$data = array(),$lay_num = 0)
	{
		if(isset($source['childs']) ){
			if((isset($_GET[$label_name]) && $_GET[$label_name] == $id) or (isset($_GET[$label_name.($lay_num+1)]) && $_GET[$label_name.($lay_num+1)] == $id)){
				$tt = array();
				$tt['name'] = $v['name'];
				$tt['url'] = $v['url'];
				$data[$lay_num] = $tt;
			}
		}

	}
*/

	//顯示訊息後直接返回上一頁
	public static function alert_and_back($msg, $data = array())
	{
		$end_string = '';
		// 這行沒有加，在IE就會看到亂碼
		$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$end_string .= '<script type="text/javascript">var base_url = "'.$data['base_url'].'";var ml_key = "tw";</script>';
		//if( $this->data['is_public'] == '0'){
		//	$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/'.$this->data['tmp_path'].'/language.js"></script>';
		//} else {
			//$end_string .= '<script type="text/javascript" src="'.$data['base_url'].'/langc/language.js"></script>';
			$end_string .= '<script type="text/javascript" src="/_i/assets/language.js"></script>';
		//}
		$end_string .= '<script type="text/javascript">';
		//if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0'){
		if(preg_match('/^l\.get\(/', $msg)){
			$end_string .= 'alert('.$msg.');';
		} else {
			$end_string .= 'alert("'.$msg.'");';
		}
		//}
		
		$end_string .= 'window.history.go(-1);;';
		
		$end_string .= '</script>';
		echo $end_string;
		die;
	}

	public static function a($source = array(), $dot_elements = '', $return = '1')
	{
		if(count($source) <= 0 or $dot_elements == '' or preg_match('/\./', $dot_elements) === false){
			return;
		}
		var_dump($source);die;
		$xxx = '';

		// 取第1個出來，其它繼續合併
		$tmps = explode('.', $dot_elements);
		//var_dump($tmps);die;
		$name = $tmps[0];
		unset($tmps[0]);

		// php在陣列的取中，會自行轉換型態，所以不要特別處理，通通給它字串就好了
		$new_string = '$'.$name.'[\'';
		$new_string .= implode('\'][\'', $tmps);
		$new_string .= '\']';

		$run1 = '$'.$name.'=$source;';
		$run2 = 'if(isset('.$new_string.')){ $xxx = '.$new_string.';}';
		eval($run1);
		eval($run2);

		return G::e($xxx, $return);
	}

	public static function alert_captcha($msg, $url = '', $data = array(),$parent = null)
	{
		$end_string = '';
		// 這行沒有加，在IE就會看到亂碼
		$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$end_string .= '<script type="text/javascript">var base_url = "'.$data['base_url'].'";var ml_key = "tw";</script>';		
		$end_string .= '<script type="text/javascript" src="/_i/assets/language.js"></script>';
		
		$end_string .= '<script type="text/javascript">';
		$end_string .= "function RefreshImage(valImageId) {
    var objImage = parent.document.images[valImageId];
    if (objImage == undefined) {
        return;
    }
    var now = new Date();
    objImage.src = objImage.src.split('?')[0] + '/index.php?r=contact/captcha&s=' + new Date().getTime();
}";
		$end_string .="RefreshImage('valImageId');";
		
		if(preg_match('/^l\.get\(/', $msg)){
			$end_string .= 'alert('.$msg.');';
		} else {
			$end_string .= 'alert("'.$msg.'");';
		}
		
		
		$end_string .= '</script>';
		echo $end_string;
		die;
	}
	//E-mail格式檢查
	public static function checkemail($bail) 
	{ 
		if(eregi("^[a-za-z0-9_]+@[a-za-z0-9\-]+\.[a-za-z0-9\-\.]+$]", $bail))
		{
			return false;
		}

		list($username, $domain) = split("@",$bail);

		if(getmxrr($domain, $mxhost)) 
		{
			return true;
		}
		else 
		{
			if(fsockopen($domain, 25, $errno, $errstr, 30)) 
			{
				return true; 
			}
			else 
			{
				return false; 
			}
		}
	}

	//直接設定從EIP登入帳號的名稱(寫死的)
	function eip_id_name($id,$name=''){
		switch ($id) {
			case '999991':
				$name = 'Buyersline_Jerry';
				break;
			case '999993':
				$name = 'Buyersline_Lota';
				break;
			case '9999912':
				$name = 'Buyersline_Jonathan';
				break;
			case '9999922':
				$name = 'Buyersline_Winnie(設計部)';
				break;			
			default:
				$name = 'EIP 後勤帳號';
				break;
		}
		return $name;
	}

	//亂數產生器
	function randtext($length,$type = 'both') {
	    $password_len = $length;    //字串長度
	    $password = '';
	    if($type=='both'){
	    	$word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';   //亂數內容
	    }
	    if($type=='number'){
	    	$word = '0123456789';   //亂數內容
	    }
	    if($type=='string'){
	    	$word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';   //亂數內容
	    }
	    
	    $len = strlen($word);
	    for ($i = 0; $i < $password_len; $i++) {
	        $password .= $word[rand() % $len];
	    }
	    return $password;
	}
}

?>

<?php

/*
 * 雜項，難分類的東西，都放這裡
 * G，代表G(gisanfu)的首字
 */
class G 
{

	//public static function b($text = '', $source = 'zh-TW', $target = 'en')
	//{
	//	require_once Yii::getPathOfAlias('system.vendors.php-google-translate-free.vendor').'/autoload.php';
	//	use \Statickidz\GoogleTranslate;

	//	$source = 'zh-TW';
	//	$target = 'en';
	//	// $text = '你真的知道，我在講什麼話嗎？';

	//	$trans = new GoogleTranslate();
	//	$result = $trans->translate($source, $target, $text);

	//	return $result;
	//}

	// 這個是從L(Lota)那邊複製過來的
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
    objImage.src = objImage.src.split('?')[0] + '/captcha.php&s=' + new Date().getTime();
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

	public static function GeraHash($qtd = 8){
		//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
		$Caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';

		$QuantidadeCaracteres = strlen($Caracteres);
		$QuantidadeCaracteres--;

		$Hash=NULL;
		for($x=1;$x<=$qtd;$x++){
			$Posicao = rand(0,$QuantidadeCaracteres);
			$Hash .= substr($Caracteres,$Posicao,1);
		}

		return $Hash;
	}

	/**
	 * 反轉utf8的字符串，使用正則和陣列實現
	 * @param string $str
	 * @return string
	 */
	public static function utf8_strrev($str){
		preg_match_all('/./us', $str, $ar);
		return implode('', array_reverse($ar[0]));                                                   
	}

	/**
	* https://blog.longwin.com.tw/2010/01/php-utf8-str-split-word-2010/
	*
	* 購物站的結帳頁在使用的
	*
	* @version $Id: str_split.php 10381 2008-06-01 03:35:53Z pasamio $
	* @package utf8
	* @subpackage strings
	*/
	public static function utf8_str_split($str, $split_len = 1){
		if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
			return false;
	 
		$len = mb_strlen($str, 'UTF-8');
		if ($len <= $split_len)
			return array($str);
	 
		preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
	 
		return $ar[0];
	}

	// 這個是主要是用在資料的圖片輸出
	// @label		string	圖片的路徑
	// @use			integer	用途，數值1是<img>在用的(預設)，數值2是javascript或是css在用的
	public static function imgt($label = '', $use = 1)
	{
		//目前使用的語系
		$lang = Yii::app()->session['web_ml_key'];

		$tmps = explode('.', $label);

		if(count($tmps) <= 1){
			$label = '';
		}

		$img_type = '.'.$tmps[count($tmps)-1];

		// 這段是複製來的，原創是lota
		if($label != ''){
			$file_name = str_replace('./','',str_replace('../','',str_replace($img_type,'',$label)));
			$tmp = $file_name.'_'.$lang.$img_type;
				if(!is_file($tmp)) $tmp = $file_name.$img_type;
			return $tmp;
		} else {
			if($use == 1){
				// https://css-tricks.com/snippets/html/base64-encode-of-1x1px-transparent-gif/
				//return 'data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=';

				// http://png-pixel.com/
				return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII';
			}
		}
			
		return 'images/system/empty.png';
	}

	public static function number_format2($str)
	{
		// 檢查字串裡面是否有中文
		// http://www.wilf.cn/post/php-match-chinese-str.html
		if (preg_match("/[\x7f-\xff]/", $str)) {
			return $str;
		} else {
			return number_format($str);
		}
	}

	// 2015-12-14
	// 這個函式己經不用了
	public static function url($url)
	{

		/*
		 * url功能1：SEM
		 *
		 * 當啟動SEM功能的時候，網址就會全面變成靜態頁
		 */

		$db = Yii::app()->db;
		$row = $db->createCommand()->from('sys_config')->where('keyname=:name',array(':name'=>'has_seo_'.Yii::app()->session['web_ml_key']))->queryRow();
		if($row and isset($row['keyname']) and $row['keyval'] == '1'){

			/*
			 * 以下的程式，很類似components/SemUrlRule.php的內容，記得要雙邊更新
			 */

			$route = '';
			$params = array();

			if(preg_match('/^index\.php\?/', $url)){
				$tmp = str_replace('index.php?', '', $url);
				$tmps = explode('&', $tmp);
				foreach($tmps as $k => $v){
					// r=aaa&id=bbb&id2=ccc
					if(preg_match('/\=/', $v)){
						$tmp2s = explode('=', $v);
						$params[$tmp2s[0]] = $tmp2s[1];
					// r=aaa&del
					} else {
						// r=aaa&del=
						$params[$v] = '';
					}
				}
			}

			if(isset($params['r'])){
				$route = $params['r'];
				unset($params['r']);
			}

			if($route == ''){
				$route = 'site/index';
			}

			if(file_exists(Yii::getPathOfAlias('application.components.seo').'.php')){
				$file = Yii::getPathOfAlias('application.components.seo').'.php';
			} else {
				$file = Yii::getPathOfAlias('system.frontend.components.seo').'.php';
			}

			include $file;

		}

		return $url;
	}

	public static function alert_and_redirect($msg, $url = '', $data = array(),$parent = null)
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
		if($url != ''){
			if(!$parent)
				$end_string .= 'window.location.href="'.$url.'";';
			else
				$end_string .= 'parent.location.href="'.$url.'";';
		}
		$end_string .= '</script>';
		echo $end_string;
		die;
	}

	/*
	 * 這是大衛特別的地方，有圖片加工區的概念，這個函式是前台專用
	 *
	 * params:
	 * @width int 
	 * @height int
	 * @pic varchar 例如 _ozman/assets/6/gallery/60.jpg
	 */
	public static function gallery($params = array(), $data = array())
	{
		if(isset($data['school_id']) and isset($params['pic']) and isset($params['width']) and isset($params['height'])){

			// 先檢查一下檔名和格式
			$tmp = explode('/', $params['pic']);
			if(count($tmp) != 5) return;
			if((int)$tmp[2] <= 0) return; // 檢查學校編號
			if($tmp[2] != $data['school_id']) return;
			if($tmp[3] != 'gallery') return;

			$gallery_path = _BASEPATH.'/assets/success/'.$data['school_id'];
			$gallery_path2 = vir_path_c.'_butterfly/assets/success/'.$data['school_id'];

			if(!file_exists($gallery_path)){
				@mkdir($gallery_path, 0777, true);
			}

			$img_path = $gallery_path.'/'.$params['width'].'x'.$params['height'].'_'.$tmp[4];
			//echo $img_path;
			//die;
			$img_path2 = $gallery_path2.'/'.$params['width'].'x'.$params['height'].'_'.$tmp[4];

			// 寫入加工區，如果有需要，以及還沒有寫過的話
			if(!file_exists($img_path)){
				$db = Yii::app()->db;
				$rows = $db->createCommand()->from('machining')->where('school_id='.$data['school_id'].' and width=:width and height=:height and pic=:pic',array('width'=>$params['width'],'height'=>$params['height'],'pic'=>$params['pic']))->queryAll();
				if(!$rows){
					$empty_orm_data = array(
						'table' => 'machining',
						'created_field' => 'create_time', 
						//'updated_field' => 'update_time',
						'primary' => 'id',
						'rules' => array(
							//array('topic, other1, school_id, type', 'required'),
							//array('type', 'default', 'value'=>'secretary'),
						),
					);
					$u = new Empty_orm('insert', $empty_orm_data);
					$u->school_id = $data['school_id'];
					$u->router_class = $data['router_class'];
					$u->router_method = $data['router_method'];
					$u->width = $params['width'];
					$u->height = $params['height'];
					$u->pic = $params['pic'];
					$u->save();
				}

				// 我本來的想法是先顯示原圖，等工讀生上傳後，在顯示工讀生的圖
				//return vir_path_c.$params['pic'];

				// 先顯示完全白色的圖，直到工讀生上傳
				return 'http://placehold.it/'.$params['width'].'x'.$params['height'].'/ffffff/ffffff';
			} else {
				return $img_path2;
			}

			//$t = new Thumb_image;
			//return $t->core($params);
		}
	}

	public static function check_table_field_exists($table, $field = '')
	{
		$return = false;

		$t = Yii::app()->db->schema->getTable($table);

		$fields = array();
		if($t !== null){
			$return = true;
			$fields = $t->getColumnNames();
			if($field != ''){
				if(in_array($field, $fields)){
					$return = true;
				} else {
					$return = false;
				}
			}
		} else {
			$return = false;
		}
		return $return;
	}
	/*
	 * 範例：
	 * admin_smarty_1
	 * admin_yiiv_2
	 * --------------
	 * 0     1    2
	 *
	 * admin是application name
	 * (smarty|yiiv) 是template運作者
	 * 1, 2是樣版編號
	 */
	public static function get_theme_compiler($theme_name = '', $getid = false){
		if($theme_name == ''){
			return;
		}
		$tmp = explode('_', $theme_name);
		if($getid){
			if(isset($tmp[2])){
				return $tmp[2];
			} else {
				return '1'; // 預設
			}
		} else {
			if(isset($tmp[1])){
				return $tmp[1];
			} else {
				return 'smarty'; // 預設
			}
		}
		return;
	}

	public static function definit($def = array(), $data = array())
	{
		if(count($def) <= 0){
			return array();
		}

		/*
		 * 補一些欄位，以下是會處理的狀況
		 *
		 * 第一節：Table和ORM
		 * 1. 只有table的時候 => 補empty_orm和empty_orm_data的table
		 * 2. 有orm，沒有table，但orm有table的狀況
		 * 3. 有orm，沒有table，但empty_orm_data有table的狀況
		 * 4. 什麼都沒有的狀況，從controller名稱取得
		 */

		// 雖然這種狀況比較少，不過還是給它加上去了
		if(!isset($def['orm']) and !isset($def['table']) and !isset($def['empty_orm_data'])){
			$def['table'] = Yii::app()->controller->id;
		}

		$orm_data = array();
		// 如果有指定orm，就問問它資料表是什麼，但是如果是Empty_orm，就不用問了，因為它預設是沒有指定資料表的
		if(isset($def['orm']) and $def['orm'] != '' and $def['orm'] != 'Empty_orm'){
			$def['orm'] = ucfirst($def['orm']);
			//$x = new $def['orm'];
			if(isset($def['empty_orm_data']) and count($def['empty_orm_data']) > 0){
				$x = new $def['orm']('insert', $def['empty_orm_data']);
			} else {
				$x = new $def['orm'];
			}
			$orm_data = $x->getOrmData();
		} else {
			// 預設ORM，就是給它一個沒有限制、規則的ORM
			$def['orm'] = 'Empty_orm';

			// 反正結論都是要給它能動就對了
			if((isset($def['table']) and $def['table'] != '') and (!isset($def['empty_orm_data']) or count($def['empty_orm_data']) <= 0)){
				$def['empty_orm_data']['table'] = $def['table'];
			}
		}

		// 補資料表欄位，如果沒有的話
		if(!isset($def['table'])){
			if(isset($def['orm']) and $def['orm'] != '' and isset($orm_data['table']) and $orm_data['table'] != ''){
				$def['table'] = $orm_data['table'];
			} elseif(isset($def['empty_orm_data']['table'])){
				$def['table'] = $def['empty_orm_data']['table'];
			}
		}

		// Yiiv版型需要做這樣子的處理
		$themea = G::get_theme_compiler($data['theme_name']);
		if($themea == 'yiiv' and isset($def['listfield_attr']['smarty_include_top']) and $def['listfield_attr']['smarty_include_top'] != ''){
			$def['listfield_attr']['smarty_include_top'] = str_replace('.htm', '', $def['listfield_attr']['smarty_include_top']);
		}
		if($themea == 'yiiv' and isset($def['updatefield']['smarty_javascript']) and $def['updatefield']['smarty_javascript'] != ''){
			$def['updatefield']['smarty_javascript'] = str_replace('.htm', '', $def['updatefield']['smarty_javascript']);
		}

		return $def;
	}

	public static function img($params = array())
	{
		$t = new Thumb_image;
		
		return $t->core($params);
	}

	public static function getUploadFileName($content = '')
	{
		if($content == ''){
			return;
		}
		if(preg_match('/^\.\//', $content)){
			$tmp = explode('/', $content);
			//$path = $tmp[3];
			//$content = $tmp[4];
			return $tmp[4];
			//unset($tmp[3]);
			//unset($tmp[4]);
		}
		return;
	}

	/*
	 * 負責處理return, echo, bool的動作
	 *
	 * axxx string
	 * return
	 * params array len元素如果有指定，就會truncate
	 */
	
	public static function e($xxx = null, $return = null, $params = array())
	{
		// 預設是會echo，這樣才看得到東西
		if($return == null){
			$return = '2';
		}

		// http://stackoverflow.com/questions/1967540/truncate-a-utf-8-string-to-fit-a-given-byte-count-in-php
		if(isset($params['len']) and (int)$params['len'] > 0 and $xxx !== null){
			$len_fill = '…';
			if(isset($params['len_fill']) and $params['len_fill']){
				$len_fill = $params['len_fill'];
			}
			mb_internal_encoding('UTF-8');
			$truncate_result = mb_strcut($xxx, 0, (int)$params['len']);
			if($truncate_result != $xxx){
				$truncate_result .= $len_fill;
			}
			$xxx = $truncate_result;
		}

		if($return == '1'){
			return $xxx;
		} elseif($return == '2'){
			echo $xxx;
		} elseif($return == '3'){
			if($xxx == null or $xxx == ''){
				return false;
			} else {
				return true;
			}
		} else {
			echo $xxx;
		}
	}

	//public static function tae(

	/*
	 * 什麼是ae(echo)
	 *
	 * @return string 1:return, 2:echo, 3:true false
	 */
	public static function ae($source = array(), $dot_elements = '', $return = '2')
	{
		$xxx = self::a($source, $dot_elements, '1');
		return self::e($xxx, $return);
	}

	public static function a($source = array(), $dot_elements = '', $return = '1')
	{
		if(count($source) <= 0 or $dot_elements == '' or preg_match('/\./', $dot_elements) === false){
			return;
		}

		$xxx = '';

		// 取第1個出來，其它繼續合併
		$tmps = explode('.', $dot_elements);
		//var_dump($tmps);
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

		return self::e($xxx, $return);
	}

	// 這裡會處理sprintf的動作
	public static function tsprintf($str = '', $values = array())
	{
		if(preg_match('/%/', $str) and count($values) > 0){
			$aaa_s = '';
			$run = '$aaa_s = sprintf("'.$str.'", '.implode(',', $values).');';
			eval($run);
			return $aaa_s;
		}
		return $str;
	}

	// 跟t()一樣，只是差在它return的預設值是false而以(echo)
	public static function te($category = '', $label = '', $sprintf_values = array(), $default = '', $return = '2')
	{
		$xxx = self::t($category, $label, $sprintf_values, $default, '1');
		return self::e($xxx, $return);
	}

	// 差不多跟te一樣，差在它是跟隨資料語系切換
	// 只有tf，我才有啟用e()的額外參數帶數，不然改動的範圍很大
	public static function tf($category = '', $label = '', $sprintf_values = array(), $default = '', $return = '2', $echo_params = array())
	{
		$xxx = self::t($category, $label, $sprintf_values, $default, '1', false);
		return self::e($xxx, $return, $echo_params);
	}

	// 2019-12-26 從w/rwd_v3/layoutv3/libs.php那裡複製過來的
	public static function _($text = '', $source = 'tw', $target = '')
	{
		// $db = $_SESSION['cidb'];
		$db = Yii::app()->params['cidb'];

		// 我打算給它預設值為當前語系
		if($target == ''){
			// $target = $_SESSION['web_ml_key'];
			$target = $_SESSION['auth_admin_interface_ml_key'];
		//} else {
			//$target = $target;
		}

		// file_put_contents('123.txt', 'source='.$source, FILE_APPEND);
		// file_put_contents('123.txt', 'tar='.$target, FILE_APPEND);
		// file_put_contents('123.txt', .'/../', FILE_APPEND);

		$file = _BASEPATH.'/assets/translate.php';
		$translates = array();
		if(file_exists($file)){
			include $file;
		}

		$file2 = _BASEPATH.'/assets/labelgoogle.php';
		$labelgoogles = array();
		if(file_exists($file2)){
			include $file2;
		}

		if($source == $target){ // 同語系的情況，就直接顯示
			return $text;
		} elseif(isset($translates[$target][$text]) and $translates[$target][$text] != ''){ // 都有的情況下
			if(isset($labelgoogles[$target][$text]) and $labelgoogles[$target][$text] != ''){
				return $labelgoogles[$target][$text];
			} else {
				return $translates[$target][$text];
			}
		} elseif(isset($labelgoogles[$target][$text])){ // 後台有的情況
			if($labelgoogles[$target][$text] != ''){
				return $labelgoogles[$target][$text];
			} else { // 如果是空白，代表是自動建議的新片語，還未有人去輸入
				return $text;
			}
		} else { // 這一定是新片語

			$row = $db->where('is_enable',1)->where('type','labelgoogle')->where('ml_key',$_SESSION['auth_admin_interface_ml_key'])->where('topic',$text)->get('html')->row_array();

			// var_dump($row);

			if($row and isset($row['id'])){
				// do nothing
			} else {
				$save = array(
					'type' => 'labelgoogle',
					// 'ml_key' => $this->data['ml_key'],
					'ml_key' => $_SESSION['auth_admin_interface_ml_key'],
					'topic' => $text,
					'is_enable' => 1,
					'create_time' => date('Y-m-d H:i:s'),
				);
				$db->insert('html',$save);
			}

			return $text;
		}
	}

	// 2018-05-28 從前台的layoutv3/libs.php的function t那邊所複製過來的，但是因為架構的關係而改名稱
	// 當天下午有跟李哥說明過要做這件事情
	// public static function _($text = '', $source = 'zh-TW', $target = '')
	// {
	// 	$map = array( 
	// 		'tw' => 'zh-TW',
	// 		'cn' => 'zh-CN',
	// 		'jp' => 'ja',
	// 	);

	// 	// 這個一定有值
	// 	if(isset($map[$source])){
	// 		$source = $map[$source];
	// 	}

	// 	// 我打算給它預設值為當前語系
	// 	if($target == ''){
	// 		if(!isset($map[$_SESSION['auth_admin_interface_ml_key']])){
	// 			$target = $_SESSION['auth_admin_interface_ml_key'];
	// 		} else {
	// 			$target = $map[$_SESSION['auth_admin_interface_ml_key']];
	// 		}
	// 	} else {
	// 		if(isset($map[$target])){
	// 			$target = $map[$target];
	// 		}
	// 	}

	// 	if($source == $target){
	// 		return $text;
	// 	} else {
	// 		$url = FRONTEND_DOMAIN;
	// 		if(defined('FRONTEND_FOLDER')){
	// 			$url .= FRONTEND_FOLDER;
	// 		}
	// 		$url .= '/translate.php';
	// 		$post = array(
	// 			'text' => $text,
	// 			'source' => $source,
	// 			'target' => $target,
	// 		);
	// 		//var_dump($post);die;

	// 		$postdata = http_build_query($post);
	// 		$ch = curl_init();
	// 		$options = array(
	// 			CURLOPT_URL => $url,
	// 			CURLOPT_HEADER => 0,
	// 			CURLOPT_VERBOSE => 0,
	// 			CURLOPT_RETURNTRANSFER => true,
	// 			CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
	// 			CURLOPT_POST => true,
	// 			CURLOPT_POSTFIELDS => $postdata,
	// 		);
	// 		curl_setopt_array($ch, $options);
	// 		$code = curl_exec($ch); 
	// 		curl_close($ch);

	// 		//var_dump($post);
	// 		//var_dump($code);
	// 		return $code;
	// 	}
	// }

	/*
	 * 顯示介面多國語系
	 * 類似Yii::t()
	 * 不一樣的地方在第3個引數
	 * $sprintf_value = array(引數1, 引數2, 引數3)
	 *
	 * @interface bool 是介面語系嗎？不是的話，那就是資料語系了
	 */
	public static function t($category = '', $label = '', $sprintf_values = array(), $default = '', $return = '1', $interface = true)
	{
		if($category == ''){
			$category = theme_lang;
		}

		// 後台專用
		$ml_key = '';
		if(defined('target_app_name')){
			if(target_app_name == 'backend'){
				if($interface){
					$ml_key = Yii::app()->session['auth_admin_interface_ml_key'];
				} else {
					$ml_key = Yii::app()->session['auth_admin_data_ml_key'];
				}
			} elseif(target_app_name == 'web'){
				// 前台的多國語系方式應該是很單純，就介面多國語系而以
				$ml_key = Yii::app()->session['web_ml_key'];
			}
		}

		//if(strlen($label) <= 3){
		//	return $label;
		//}

		if($label == ''){
			return;
		}

		// 先把ml拿掉，資料語系會有，純介面片語不會有
		$append_ml = '';
		if(preg_match('/^(ml:)(.*)$/', $label, $matches)){
			$append_ml = $matches[1];
			$label = $matches[2];
		} elseif(preg_match('/^(ml..:)(.*)$/', $label, $matches)){
			$append_ml = $matches[1];
			$label = $matches[2];
		}

		if($category != ''){
			$label = '[['.$category.']] '.$label;
		}

		// 為了資料語系而做的，step2
		if($append_ml != ''){
			$label = $append_ml.$label;
		}

		// 為了讓資料語系切換能夠單純一點
		if(!preg_match('/^ml..:/', $label) and !preg_match('/^ml:/', $label)){
			$label = 'ml:'.$label;
		}

		$isml = strtolower(substr($label, 0, 3));
		$isml2 = strtolower(substr($label, 0, 5));

		// 鎖定顯示某個語系內的該片語
		if(preg_match('/^ml(..):/', $isml2, $matches)){
			$ml_key = $matches[1];
			$label_key = substr($label, 5);

			$labels = self::l();

			$aaa = $labels[$ml_key][strtolower($label_key)];
			if($aaa == ''){
				if($default != ''){
					$xxx = self::tsprintf($default, $sprintf_values);
					return self::e($xxx, $return);
				}
				if(preg_match('/^\[\[.*\]\] (.*)$/', $label_key, $matches)){
					$xxx = self::tsprintf($matches[1], $sprintf_values);
					return self::e($xxx, $return);
				}
				$xxx = self::tsprintf($label_key, $sprintf_values);
				return self::e($xxx, $return);
			}

			$xxx = self::tsprintf($aaa, $sprintf_values);
			return self::e($xxx, $return);
		// 沒有鎖定，顯示當下語系的片語值
		} elseif($isml == 'ml:'){
			$label_key = substr($label, 3);

			$labels = self::l();

			$aaa = '';
			if(isset($labels[$ml_key][strtolower($label_key)])){
				$aaa = $labels[$ml_key][strtolower($label_key)];
			}

			if($aaa == ''){
				if($default != ''){
					$xxx = self::tsprintf($default, $sprintf_values);
					return self::e($xxx, $return);
				}
				if(preg_match('/^\[\[.*\]\] (.*)$/', $label_key, $matches)){
					$xxx = self::tsprintf($matches[1], $sprintf_values);
					return self::e($xxx, $return);
				}
				$xxx = self::tsprintf($label_key, $sprintf_values);
				return self::e($xxx, $return);
			}
			$xxx = self::tsprintf($aaa, $sprintf_values);
			return self::e($xxx, $return);
		} else {
			if(preg_match('/^\[\[.*\]\] (.*)$/', $label, $matches)){
				$xxx = self::tsprintf($matches[1], $sprintf_values);
				return self::e($xxx, $return);
			} else {
				$xxx = self::tsprintf($label, $sprintf_values);
				return self::e($xxx, $return);
			}
		}
	}

	public static function l($source = array(), $dot_elements = '')
	{
		$labels = array();
		// 載入多國語系
		//if(file_exists(Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'language.php')){
		if(file_exists(tmp_path.DIRECTORY_SEPARATOR.'language.php')){
			// 這裡先這樣子寫，到時有效能上的疑問，在回來tune這裡
			//require Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'language.php';
			require tmp_path.DIRECTORY_SEPARATOR.'language.php';
		}
		return $labels;
	}

	// 等同於CI的show_error
	public static function m($message = '', $heading = 'Error', $data = array(), $errorcode = 500)
	{
		$data['message'] = $message;
		$data['heading'] = $heading;

		throw new CHttpException($errorcode, $heading.strip_tags($message));

		//$themea = G::get_theme_compiler($data['theme_name']);
		//if($themea == 'smarty'){
		//	if(count($data) > 0){
		//		foreach($data as $k => $v){
		//			Yii::app()->smarty->assign($k, $v);
		//		}
		//	}
		//	//Yii::app()->smarty->display(template_path.'/error/error_general.htm', $data);
		//	Yii::app()->smarty->display('template/admin_smarty_1/error/error_general.htm', $data);
		//} elseif($themea == 'yiiv'){
		//	$->render('error/error_general', $data);
		//}
	}

	// 跟m一樣，只是這個是負責處理AR的getErrors陣列
	public static function dbm($message_tmp = array(), $heading = 'Error')
	{
		$message = '';
		if(count($message_tmp) > 0){
			foreach($message_tmp as $k => $v){
				$message .= $k.':<br />';
				foreach($v as $vv){
					$message .= '&nbsp;&nbsp'.$vv.'<br />';
				}
			}
		}

		$data = array();
		$data['heading'] = $heading;
		$data['message'] = $message;

		throw new CHttpException(500, '['.$heading.'] '.strip_tags($message));

		//if(count($data) > 0){
		//	foreach($data as $k => $v){
		//		Yii::app()->smarty->assign($k, $v);
		//	}
		//}
		//Yii::app()->smarty->display(template_path.'/error/error_general.htm', $data);
		//die;
	}

	// 在新增或修改的時候，都會有需要取得資料庫的筆數，如果是新增，筆數還要加1，這裡就專做這件事
	//
	// 2019-02-14 這裡的規則，是將資料的插入點，放在後面
	public static function dbc($class_method = '', $def = array())
	{
		$count = 0;
		if($class_method == ''){
			return $count;
		}

		$db = Yii::app()->db;
		$c = $db->createCommand();
		$c->select('count(*)');
		$c->from($def['table']);
		// @k active record method
		// @v array, string 屬性群
		//foreach($def['condition'] as $k => $v){
		//	$c->{$k}($v[0], $v[1]);
		//}
		if(isset($def['condition'])){
			$r_condition = self::dbt($def['condition'], '$c');
			if($r_condition != ''){
				eval($r_condition);
			}
		}
		// 因為是新增，所以增加一筆
		//$class_sort_count = count($c->queryAll());
		$count = $c->queryScalar();
		if($class_method == 'create'){
			$count++;
		}

		//if(isset($def['listfield']['sort_id'])){
		//}
		return $count;
	}

	/*
	 * CDBCommand專用
	 * 常常在程式裡面需要讀取def的condition，但是Yii的跟CI不太一樣，所以特別寫這個方式來處理
	 * @condition array 條件
	 * @obj_string string 例如$c等等
	 * @need_end bool 預設是會主動加上結尾，可以改成false，讓它不加，如果後面要在加其它東西的話
	 *
	 * 引數數量，不含where(method)最多4個(其實是無限層)
	 *
	 *	array(
	 *		array(
	 *			'where', 
	 *			'is_enable=:is_enable',
	 *			array(
	 *				':is_enable'=>'1'
	 *			)
	 *		)
	 *	)
	 *
		'condition' => array(
			array(
				'where',
				'is_hidden=0',
			),
		),
	 */
	public static function dbt($conditions = array(), $obj_string = '', $need_end = true)
	{
		/*
		if(count($v) == 2){
			$c->{$v[0]}($v[1]);
		} elseif(count($v) == 3){
			$c->{$v[0]}($v[1], $v[2]);
		} elseif(count($v) == 4){
			$c->{$v[0]}($v[1], $v[2], $v[3]);
		} elseif(count($v) == 5){
			$c->{$v[0]}($v[1], $v[2], $v[3], $v[4]);
		}
		 */
		$return = '';

		// 2019-10-05 PHP7
		if($conditions === null){
			$conditions = array();
		}

		if(count($conditions) <= 0 or $obj_string == '' ){
			return $return;
		}

		$tmp1 = array();
		foreach($conditions as $k => $v){
			if(count($v) <= 1){
				continue;
			}
			$method = $v[0];
			if($method == 'where'){
				$method = 'andWhere';
			}
			unset($v[0]);
			$tmp2 = array();
			foreach($v as $kk => $vv){
				if(is_array($vv)){
					$tmp2[] = var_export($vv, true);
				} else {
					$tmp2[] = '"'.$vv.'"';
				}
			}
			$tmp1[] = $method.'('.implode(',', $tmp2).')';
		}
		//if($obj_string == '$bbb'){
		//var_dump($tmp1);
		//}

		if(count($tmp1) > 0){
			$return = $obj_string.'->'.implode('->', $tmp1);

			//if($obj_string == '$bbb'){
			//	echo $return;
			//}

			if($need_end){
				$return .= ';';
			}
		}

		return $return;
	}

	// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
	public static function getJqueryValidation($rules = array(), $def = array())
	{
		$validation = array();

		// 2015-11-20 註解，請先看底下的註解
		$def_update_field_merge = array();
		if($def and isset($def['updatefield']) and count($def['updatefield']['sections'])){
			foreach($def['updatefield']['sections'] as $k => $v){
				foreach($v['field'] as $kk => $vv){
					$def_update_field_merge[$kk] = $vv;
				}
			}
		}

		foreach($rules as $k => $v){
			$fields_tmp = $v[0];
			$validator = $v[1];
			unset($v[0]);
			unset($v[1]);
			$fields = array();
			if(preg_match('/\,/', $fields_tmp)){
				$tmps = explode(',', $fields_tmp);
				foreach($tmps as $kk => $vv){
					$fields[] = trim($vv);
				}
			} else {
				$fields[] = trim($fields_tmp);
			}
			foreach($fields as $vv){
				if($validator == 'required'){
					// 2015-11-20 
					// 這裡在admin_menu、或是product_type的第二層，保證出問題
					// 在update裡，getJqueryValidation會先執行
					// 而last是在最後在執行，所以如果功能是需要在last才unset該元素
					// 那這裡保證出錯
					if(isset($def_update_field_merge[$vv]) and preg_match('/^(select3|select5)$/', $def_update_field_merge[$vv]['type'])){
						$validation[$vv]['selectcheck'] = true;
					} else {
						$validation[$vv]['required'] = true;
					}

					//$validation[$vv]['required'] = true;
				} elseif($validator == 'email'){
					$validation[$vv]['email'] = true;
				} elseif($validator == 'length'){
					if(isset($v['min'])){
						$validation[$vv]['minlength'] = (int)$v['min'];
					} elseif(isset($v['max'])){
						$validation[$vv]['maxlength'] = (int)$v['max'];
					}
				} elseif($validator == 'numerical'){ // 2018-05-02
					if(isset($v['integerOnly']) and $v['integerOnly'] === true){
						$validation[$vv]['digits'] = true;
					} else {
						$validation[$vv]['number'] = true;
					}
				}
			}
		}

		return $validation;
	}
	/*
		'rules' => array(
			array('login_account, email', 'required'),
			array('email', 'email'),
			array('is_enable, is_hidden', 'length', 'max'=>1),
			array('is_enable', 'default', 'value'=>1),
		),
	 */

	/*
	public function getJqueryValidation()
	{
		$validation = array();

		foreach($this->validation as $k => $v){
			foreach($v['rules'] as $kk => $vv){
				$key = $kk;
				$value = $vv;

				if($this->isInt($kk) === true){
					$key = $vv;
					$value = '';
				}

				if($key == 'required'){
					$validation[$k]['required'] = true;
				} elseif($key == 'valid_email'){
					$validation[$k]['email'] = true;
				} elseif($key == 'min_length'){
					$validation[$k]['minlength'] = $value;
				} elseif($key == 'max_length'){
					$validation[$k]['maxlength'] = $value;
				}
			} // rules
		} // this

		return $validation;
	}
	 */
}

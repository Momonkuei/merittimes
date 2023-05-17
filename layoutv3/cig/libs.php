<?php

// 2019-12-31 為了弄cache4而移過來的
// https://blog.longwin.com.tw/2009/03/php-object-to-array-json-reader-cli-2009/
//
// 使用方式
// $rows = $this->db->createCommand()->from('producttype')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// $indexedItems = array();
// 
// foreach ($rows as $item) {
// 	$item['child'] = array();
// 	$indexedItems[$item['id']] = (object) $item;
// }
// 
// $topLevel = array();
// foreach ($indexedItems as $item) {
// 	if ($item->pid == 0) {
// 		$topLevel[] = $item;
// 	} else {
// 		$indexedItems[$item->pid]->child[] = $item;
// 	}
// }
// $tree = std_class_object_to_array($topLevel);
// var_dump($tree);
function std_class_object_to_array($stdclassobject)
{
	$_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

	foreach ($_array as $key => $value) {
		$value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
		$array[$key] = $value;
	}

	if(isset($array)){
		return $array;
	}
}


/*
 * 2019-12-05
 * 李哥說，這個呼叫自己的，不會吃主機的流量
 * delete from html where type='labelgoogle'
 */
function t($text = '', $source = 'tw', $target = '')
{
	$db = $_SESSION['cidb'];

	// 我打算給它預設值為當前語系
	if($target == ''){
		$target = $_SESSION['web_ml_key'];
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

		$row = $db->where('is_enable',1)->where('type','labelgoogle')->where('ml_key',$_SESSION['web_ml_key'])->where('topic',$text)->get('html')->row_array();

		// var_dump($row);

		if($row and isset($row['id'])){
			// do nothing
		} else {
			$save = array(
				'type' => 'labelgoogle',
				// 'ml_key' => $this->data['ml_key'],
				'ml_key' => $_SESSION['web_ml_key'],
				'topic' => $text,
				'is_enable' => 1,
				'create_time' => date('Y-m-d H:i:s'),
			);
			$db->insert('html',$save);
		}

		return $text;
	}
}

 
class Ml2
{
	function __construct($db)
	{
		//$CI =& get_instance();
		//$this->db = $CI->db;
		//$this->ci = $CI;
		//$this->session = Yii::app()->session;
		$this->cidb = $db;
	}

	/*
	 * ,
	 * tw,key,en,cn,ru
	 * 阿富汗,[[sehoepaper]] AFG-AFGHANISTAN,,,
	 * 阿爾巴尼亞,[[sehoepaper]] ALB-ALBANIA,,,
	 */
	public function export_txt()
	{
		$splitchar = '|||';
		$return = $splitchar."\n";

		$query = $this->cidb->where('is_enable', '1')->get('ml');
		$mls = array();
		foreach($query->result_array() as $row){
			$mls[] = $row['key'];
		}
		//$mls_tmp = $this->db->createCommand()->from('ml')->where('is_enable=1')->queryAll();
		//foreach($mls_tmp as $row){
		//	$mls[] = $row['key'];
		//}

		$return .= 'key'.$splitchar.implode($splitchar, $mls)."\n";

		// 取得所有片語
		$query = $this->cidb->get('ml_label');
		$labels = $query->result_array();
		//$labels = $this->db->createCommand()->from('ml_label')->queryAll();

		// 參考用的片語
		$labels_tmp = array();
		$labels_tmp2 = array();
		if(count($labels) > 0){
			foreach($labels as $k => $v){
				$labels_tmp[] = $v['key'];
				$labels_tmp2[$v['key']] = '1';
			}
		}

		// 取得所有片語值
		$query = $this->cidb->get('ml_lang');
		$labelvalues = $query->result_array();
		//$labelvalues = $this->db->createCommand()->from('ml_lang')->queryAll();

		$values = array();
		if(count($labelvalues) > 0){
			foreach($labelvalues as $k => $v){
				if(!isset($labels_tmp2[$v['label_key']])){
					continue;
				}
				$values[$v['label_key']][$v['ml_key']] = $v['value'];
			}
		}

		if(count($values) > 0){
			foreach($values as $k => $v){
				//$tmp = $v;
				//var_dump($tmp);
				//die;
				$tmp1 = array();
				if(count($mls) > 0){
					foreach($mls as $kk => $vv){
						$tmp1[$vv] = $v[$vv];
					}
				}
				$values[$k] = $tmp1;
			}
		}

		//var_dump($values);
		//die;

		if(count($values) > 0){
			foreach($values as $k => $v){
				$return .= $k.$splitchar;
				$tmp = array();
				foreach($v as $kk => $vv){
					$tmp[] = $vv;
				}
				$return .= implode($splitchar, $tmp)."\n";
			}
		}
		//echo nl2br($return);
		//die;

		return $return;
	}

	/*
	 * @keys array 裡面放的是array(key,en,cn,tw, ...)
	 * @keys array 裡面放的是array(hello,Hello,你好,你好, ...)
	 */
	public function import($keys, $values, $split = ',')
	{
		if(count($keys) <= 0 or count($values) <= 0 and !in_array('key', $keys)){
			return false;
		}

		// 如果裡面一個以上的key
		$key_count = 0;
		foreach($keys as $k => $v){
			$keys[$k] = strtolower($v);
			if($v == 'key'){
				$key_count++;
			}
		}
		if($key_count > 1){
			return false;
		}

		// @v 語系別名（key,en,tw...)

		// 對一下位置
		$key_position = 0;
		$ml_positions = array();
		foreach($keys as $k => $v){
			$v = trim($v);
			if($v == 'key'){
				$key_position = $k;
			} else {
				$ml_positions[$k] = $v;
			}
		}
		//var_dump($ml_positions);

		// 取得所有片語，等一下要做比對，不存在的才建
		$query = $this->db->get('ml_label');
		$labels_tmp = array();
		foreach($query->result_array() as $row){
			$labels_tmp[strtolower($row['key'])] = '1';
		}

		// 取得所有語系，等一下要做比對，不存在的才建
		$query = $this->db->where('is_enable', '1')->get('ml');
		$mls_tmp = array();
		foreach($query->result_array() as $row){
			$mls_tmp[$row['key']] = '1';
		}

		/*
		 * 第一次處理，整理一下
		 */

		// 存放處理後的結果
		$result = array();

		// 要寫入label資料表的東西
		$labels = array();
		$label_values = array();

		foreach($values as $k => $v){
			/*
			 * array(5) {
			 *   [0]=>
			 *   string(9) "阿富汗"
			 *   [1]=>
			 *   string(30) "[[sehoepaper]] AFG-AFGHANISTAN"
			 *   [2]=>
			 *   string(0) ""
			 *   [3]=>
			 *   string(0) ""
			 *   [4]=>
			 *   string(1) "
			 * "
			 * }
			 */
			$tmps = explode($split, $v);
			// 存放片語和片語內容，每一個語系的資料
			$tmp = array();
			$is_break = 0;
			$label_name = '';
			foreach($tmps as $kk => $vv){
				if($key_position == $kk){
					// // 不存在的片語才建立
					// if(!isset($labels_tmp[strtolower($vv)])){
					// 	$label_name = $vv;
					// 	$labels[] = $vv;
					// } else {
					// 	// 己存在的不會去做
					// 	unset($values[$k]);
					// 	$is_break = 1;
					// 	break;
					// }
					$label_name = $vv;
					$labels[] = $vv;
				} else {
					//echo $ml_positions[$kk];
					if(isset($ml_positions[$kk])){
						$tmp[$ml_positions[$kk]] = $vv;
					}
				}
			}
			if($is_break == 0 and $label_name != '' and count($tmp) > 0){
				$label_values[$label_name] = $tmp;
			}
		}

		if(count($labels) > 0){
			foreach($labels as $k => $v){
				$u = new Label_orm();
				$u->get_by_key($v);
				if($u->key == ''){
					$u = new Label_orm();
					$u->key = $v;
					if(!$u->save()){
						show_error($u->error->string);
					}
				}
			}
		}

		//$save_values = array();
		if(count($label_values) > 0){
			// @k string 片語名稱
			foreach($label_values as $k => $v){
				//var_dump($v);
				// @kk string 語系
				// @vv string 片語值
				foreach($v as $kk => $vv){
					// 不存在的語系不會處理
					if(!isset($mls_tmp[$kk])){
						continue;
					}
					$query = $this->db->where('ml_key', $kk)->where('label_key', $k)->get('ml_lang', 1);
					if($query->num_rows() > 0){
						// 如果有的話，就修改
						$row = $query->row_array();
						$u = new Lang_orm();
						$u->get_by_id($row['id']);
						//$u->ml_key = $kk;
						//$u->label_key = $k;
						$u->value = $vv;
						if(!$u->save()){
							show_error($u->error->string);
						}
					} else {
						// 沒有的話就新增
						if($v != ''){
							$row = $query->row_array();
							$u = new Lang_orm();
							$u->ml_key = $kk;
							$u->label_key = $k;
							$u->value = $vv;
							if(!$u->save()){
								show_error($u->error->string);
							}
						} // v要有值才會新增
					}
				}
			}
		}

		return true;
	}

	public function export()
	{
		// 重新輸出靜態片語陣列檔案
		//$u = new Lang_orm();
		//$u->get();

		//$listcontent = array();
		//if($u->result_count() > 0){
		//	$listcontent = $u->all_to_array();
		//}

		$listcontent = $this->cidb->get('ml_lang')->result_array();
		//$listcontent = $this->db->createCommand()->from('ml_lang')->queryAll();

		$all_label = array();
		if(count($listcontent) > 0){
			foreach($listcontent as $k => $v){
				$all_label[$v['ml_key']][trim(strtolower($v['label_key']))] = $v['value'];
			}
		}

		// 輸出片語與編號的對應檔
		$query = $this->cidb->select('id, key')->get('ml_label');
		$all_label_tmp = array();
		foreach($query->result_array() as $row){
			$all_label_tmp[trim(strtolower($row['key']))] = $row['id'];
		}

		//$rows = $this->db->createCommand()->from('ml_label')->queryAll();
		//$all_label_tmp = array();
		//foreach($rows as $row){
		//	$all_label_tmp[trim(strtolower($row['key']))] = $row['id'];
		//}

$js_script = 'function Language(multilanguage){
	this.ml_key = multilanguage;
	this.get = geta;
}
function geta(label){
	var aa = labels[this.ml_key][label.toLowerCase()];

	var regex = /^\[\[(.*)\]\] (.*)$/g;
	var match = regex.exec(label.toLowerCase());

	if(aa == undefined){
		if(match && match[1] != null){
			return match[2];
		} else {
			return label;
		}
	} else {
		return aa;
	}
}
// 載入多國語系，給js所使用
var l = new Language(ml_key);
';

		$ggg = '?';
		//if(count($all_label) > 0){
		//	// @k en, tw...
		//	foreach($all_label as $k => $v){
		//		file_put_contents(lang_path.'/'.$k.'.php', '<'.$ggg.'php $labels = '.var_export($v, true).';');
		//	}
		//}
		if(count($all_label) > 0){
			$php_lang_path = '';
			$js_lang_path = '';

			//if(!file_exists(tmp_path)){
			//	mkdir(tmp_path, 0777, true);
			//}
			//$php_lang_path = Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . 'language.php';
			$php_lang_path = tmp_path.DIRECTORY_SEPARATOR.'language.php';
			$js_lang_path = tmp_path.DIRECTORY_SEPARATOR.'language.js';

			file_put_contents($php_lang_path, '<'.$ggg.'php $labels = '.var_export($all_label, true).';');
			//file_put_contents($php_lang_tmp_path, '<'.$ggg.'php $labels_tmp = '.var_export($all_label_tmp, true).';');
			// 輸出給javascript所使用的多國語系片語
			file_put_contents($js_lang_path, $js_script.'var labels = '.json_encode($all_label).';');
		}
	}

	// 刪除自己的片語檔案(不是共用的哦)
	public function delete()
	{
		unlink(tmp_path.ds('/language.php'));
		unlink(tmp_path.ds('/language.js'));
	}
}

/*
 * 雜項，難分類的東西，都放這裡
 * G，代表G(gisanfu)的首字
 */
class G 
{

	// 這個是從L(Lota)那邊複製過來的
	public static function alert_captcha($msg, $url = '', $data = array(),$parent = null)
	{
		$end_string = '';
		// 這行沒有加，在IE就會看到亂碼
		$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$end_string .= '<script type="text/javascript">var base_url = "'.$data['base_url'].'";var ml_key = "tw";</script>'."\n";
		$end_string .= '<script type="text/javascript" src="/_i/assets/language.js"></script>'."\n";
		
		$end_string .= '<script type="text/javascript">'."\n";
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

	public static function alert_and_redirect($msg = '', $url = '', $data = array(),$parent = null)
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

		if($msg != ''){ // 2020-01-10
			if(preg_match('/^l\.get\(/', $msg)){
				$end_string .= 'alert('.$msg.');';
			} else {
				$end_string .= 'alert("'.$msg.'");';
			}
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

	public static function img($params = array())
	{
		$t = new Thumb_image;
		return $t->core($params);
	}

	// 這個是主要是用在資料的圖片輸出
	// @label		string	圖片的路徑
	// @use			integer	用途，數值1是<img>在用的(預設)，數值2是javascript或是css在用的
	public static function imgt($label = '', $use = 1)
	{
		//目前使用的語系
		$lang = $_SESSION['web_ml_key'];

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


} // G

class yii_session implements ArrayAccess
{

	public function offsetExists($key)
	{
		return isset($_SESSION[$key]);
	}

	public function offsetSet($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function offsetGet($key)
	{
		return $_SESSION[$key];
	}

	public function offsetUnset($key)
	{
		unset($_SESSION[$key]);
	}

	// 為了往下支援
	public function clear(){}
	public function destroy()
	{
		session_destroy();
	}
	public function open(){}

	public function add($key, $value)
	{
		$_SESSION[$key] = $value;
	}
}

// $ggg2 = $this->_getFiles(Yii::getPathOfAlias($path));
// Yii::app()->session['captcha'] = $SCode;
// member/change_password_post.php:	Yii::app()->session->clear();
// member/change_password_post.php:	Yii::app()->session->destroy();
// member/change_password_post.php:	Yii::app()->session->open();
class Yii
{
	// @path webroot._i.assets.thumb ...
	public static function getPathOfAlias($path)
	{
		$path = str_replace('webroot.', _BASEPATH.'/../'.LAYOUTV3_PATH, $path);
		$path = str_replace('..', 'ggxxgg', $path);
		$path = str_replace('.', '/', $path);
		$path = str_replace('ggxxgg', '..', $path);
		return $path;
	}

	// http://www.cnblogs.com/zyf-zhaoyafei/p/5228652.html
	public $session;

	public $db; 

	function __construct()
	{
		// $this->session = $_SESSION;
		$this->session = new yii_session();

		// var_dump($this->session);
		$this->db = new yii_cdb($_SESSION['cidb']);
	}

	public static function app()
	{
		$ggg = new Yii();
		return $ggg;
	}
}

// $this->db->createCommand()->from('html')
// ->where('is_enable=1 and type=:type and url1=:url and ml_key=:ml_key',array(':type'=>'webmenu',':url'=>$path1,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
class yii_cdb
{
	public $cidb;
	public $table;
	public $select;
	public $order;
	public $where;
	public $limit;
	public $where_params;

	public $create_command_sql;

	function __construct($db)
	{
		$this->cidb = $db;
	}

	public function createCommand($sql = '')
	{
		// 為了不要繼承到上一個連線的內容
		// 一定會發生
		$this->table = '';
		$this->select = '';
		$this->order = '';
		$this->limit = ''; // 2018-10-09
		$this->where = '';
		$this->where_params = '';
		$this->create_command_sql = '';

		if($sql != ''){
			$this->create_command_sql = $sql;
		}

		return $this;
	}

	public function select($select)
	{
		$this->select = $select;
		return $this;
	}

	public function from($table)
	{
		$this->table = $table;
		return $this;
	}

	public function where($where,$params=array())
	{
		$this->where = $where;
		$this->where_params = $params;
		return $this;
	}

	public function order($order)
	{
		$this->order = $order;
		return $this;
	}

	public function limit($aa)
	{
		$this->limit = $aa;
		return $this;
	}

	public function queryRow()
	{
		$aaa = $this->cidb;

		if($this->create_command_sql != ''){
			// $rows = $this->db->createCommand('select * from product where id=3')->queryAll();
			//echo $this->create_command_sql;die;
			$row = $aaa->query($this->create_command_sql)->row_array();
			// var_dump($rows);die;
		} else {
			$select = $this->select;
			$where = $this->where_params();
			$order = $this->order;

			if($select != ''){
				$aaa->select($select);
			}
			if($where != ''){
				$aaa->where($where);
			}
			if($order != ''){
				$aaa->order_by($order);
			}
			$row = $aaa->get($this->table)->row_array();
		}

		return $row;
	}

	public function queryAll()
	{
		$aaa = $this->cidb;

		if($this->create_command_sql != ''){
			// $rows = $this->db->createCommand('select * from product where id=3')->queryAll();
			//echo $this->create_command_sql;die;
			$rows = $aaa->query($this->create_command_sql)->result_array();
			// var_dump($rows);die;
		} else {
			$select = $this->select;
			$where = $this->where_params();
			$limit = $this->limit;
			$order = $this->order;

			if($select != ''){
				$aaa = $aaa->select($select);
			}
			if($where != ''){
				//$aaa = $aaa->where('');
				$aaa = $aaa->where($where);
				//var_dump($aaa);die;
			}
			if($limit != ''){
				$aaa = $aaa->limit($limit);
			}
			if($order != ''){
				$aaa = $aaa->order_by($order);
			}
			$rows = $aaa->get($this->table)->result_array();
		}

		return $rows;
	}

	protected function where_params()
	{
		$where = $this->where;
		$params = $this->where_params;
		if($params and count($params) > 0){
			foreach($params as $k => $v){
				if(preg_match('/^\:(id)$/', $k)){
					// 變數v，不用加上雙引號
					// 但是測試的時候發現，Mysql就算是INT的欄位加上雙引號也不會壞掉
				} else {
					$v = '"'.$v.'"';
				}

				// 2019-09-09
				if(!preg_match('/^\:/', $k)){
					$k = ':'.$k;
				}

				$where = str_replace($k,$v,$where);
			}
		}
		// 2018-11-19 應該是cig的問題，第一個參數，如果是等於條件，例如is_enable=1，它會判定是`is_enable=1`是一個欄位
		// $where = str_replace('is_enable=','is_enable =',$where); 

		// 2018-11-19 試著修修看
		if(trim($where) != ''){
			$where = 'id != "" and '.$where;
		}

		return $where;
	}

} // yii_cdb


// 使用方式，只有insert和update的功能，如果可以，還要寫validate的功能
/* 
新增
$orm = new gorm($db, $rules);
$orm->data($data);
$orm->name = 'abc';
$status = $orm->validate(); // 回傳true或false
$logs = $orm->message();
$status = $orm->insert(); // 回傳寫入狀態
$id = $db->insert_id();

修改
$orm->data($data);
$orm->find_by_XX($VALUE);
$status = $orm->validate(); // 回傳true或false
$logs = $orm->message();
$status = $orm->update(); // 回傳更新狀態
$count = $db->affected_rows();

$rules = array(
	'table' => 'html',
	'created_field' => 'create_time', 
	'updated_field' => 'update_time',
	'rules' => array(
		array('topic', 'required'),
		//array('start_date', 'date', 'format'=>'yyyy-M-d'),
	),
);
 */
class gorm {

	public $cidb;
	public $table;
	public $rules;
	public $created_field;
	public $updated_field;

	public $data;

	public $message;

	public $update_key;
	public $update_value;

	function __construct($db, $rules)
	{
		$this->cidb = $db;
		$this->rules = $rules['rules'];

		if(isset($rules['created_field']) and $rules['created_field'] != ''){
			$this->created_field = $rules['created_field'];
		}

		if(isset($rules['updated_field']) and $rules['updated_field'] != ''){
			$this->updated_field = $rules['updated_field'];
		}

		$this->table = $rules['table'];

		$this->message = array();
	}

	public function data($data)
	{
		$this->data = $data;

		return $this;
	}

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
		return null;
	}

	public function __isset($name)
	{
		return isset($this->data[$name]);
	}

	public function __unset($name)
	{
		unset($this->data[$name]);
	}

	public function __call($name, $arguments)
	{
		if(preg_match('/^find_by_(.*)$/', $name, $matches) and count($arguments) == 1){
			$this->update_key = $matches[1];
			$this->update_value = $arguments[0];
			return $this;
		}

		return false;
	}

	public function message()
	{
		return $this->message;
	}

	public function validate()
	{
		$status = true;

		if($this->rules and count($this->rules) > 0){
			foreach($this->rules as $k => $v){ // 每一個欄位，可以有一個以上的規則
				if(isset($v[0]) and $v[1]){
					$name_tmp = trim($v[0]);
					$type = $v[1];

					// 額外參數，目前還沒有用到
					$param = array(); 
					if(isset($v[2])){
						$param = $v[2];
					}

					// 可能是逗點分隔，例如name, phone, addr
					$names = array();
					if(preg_match('/\,/', $name_tmp)){
						$names = explode(',', $name_tmp);
						if(count($names) > 0){
							foreach($names as $kk => $vv){
								$names[$kk] = trim($vv);
							}
						}
					} else {
						$names[] = $name_tmp;
					}

					if(count($names) > 0){
						foreach($names as $name){
							if(!isset($this->data[$name])){
								$this->message[] = 'validate|'.$name.'|not exists';
								$status = false; break;
							}

							$value = $this->data[$name];
							if($type == 'required'){
								if($value == null){
									$this->message[] = 'validate|'.$name.'|'.$type.'|check fail';
									$status = false; break;
								} elseif($value == ''){
									$this->message[] = 'validate|'.$name.'|'.$type.'|check fail';
									$status = false; break;
								}
							}
						}
					} // count $names > 0

				}
			}
		}

		return $status;
	}

	public function insert()
	{
		$status = false;

		// 檢查欄位是否存在
		$fields = $this->cidb->list_fields($this->table);
		$save = $this->data;
		if($save and count($save) > 0){
			foreach($save as $k => $v){
				if(!in_array($k, $fields)){
					unset($save[$k]);
				}
			}
		}

		if($this->created_field != '' and in_array($this->created_field, $fields) and !isset($save[$this->created_field])){
			$save[$this->created_field] = date('Y-m-d H:i:s');
		}

		$this->cidb->insert($this->table, $save); 
		$id = $this->cidb->insert_id();

		if($id > 0){
			$status = true;
		}
		return $status;
	}

	public function update()
	{
		$status = false;

		// 檢查欄位是否存在
		$fields = $this->cidb->list_fields($this->table);
		$update = $this->data;
		if($update and count($update) > 0){
			foreach($update as $k => $v){
				if(!in_array($k, $fields)){
					unset($update[$k]);
				}
			}
		}

		if($this->updated_field != '' and in_array($this->updated_field, $fields) and !isset($update[$this->updated_field])){
			$update[$this->updated_field] = date('Y-m-d H:i:s');
		}

		$this->cidb->where($this->update_key,$this->update_value)->update($this->table, $update); 
		$count = $this->cidb->affected_rows();

		if($count > 0){
			$status = true;
		}
		return $status;
	}
}

				// 這個版本留著參考
				class gorm_encrypt {

					public $cidb;
					public $table;
					public $rules;
					public $created_field;
					public $updated_field;

					public $data;

					public $message;

					public $update_key;
					public $update_value;

					// 加密資料表名稱和欄位
					public $table_0;
					public $table_1;
					public $encode_0;
					public $encode_1;

					function __construct($db, $rules)
					{
						$this->cidb = $db;
						$this->rules = $rules['rules'];

						// 加密資料表名稱和欄位
						/*
						 * 就是真 => 假
						 * array(
						 *	  'member' => '0987654321gfedcba',
						 *	  'admin_menu' => 'abcdefg1234567890',
						 * )
						 */
						$this->table_0 = array();
						if(isset($rules['table_0']) and count($rules['table_0']) > 0){
							$this->table_0 = $rules['table_0'];
						}

						/*
						 * 就是假 => 真
						 * array(
						 *	  '0987654321gfedcba' => 'member',
						 *	  'abcdefg1234567890' => 'admin_menu',
						 * )
						 */
						$this->table_1 = array();
						if(isset($rules['table_1']) and count($rules['table_1']) > 0){
							$this->table_1 = $rules['table_1'];
						}

						/*
						 * 就是真 => 假
						 * '一律假資料表名稱' => array(
						 *	  'name' => '0987654321gfedcba',
						 *	  'phone' => 'abcdefg1234567890',
						 * )
						 */
						$this->encode_0 = array();
						if(isset($rules['encode_0']) and count($rules['encode_0']) > 0){
							$this->encode_0 = $rules['encode_0'];
						}

						/*
						 * 就是假 => 真
						 * '一律假資料表名稱' => array(
						 *	  '0987654321gfedcba' => 'name',
						 *	  'abcdefg1234567890' => 'phone',
						 * )
						 */
						$this->encode_1 = array();
						if(isset($rules['encode_1']) and count($rules['encode_1']) > 0){
							$this->encode_1 = $rules['encode_1'];
						}

						if(isset($rules['created_field']) and $rules['created_field'] != ''){
							$this->created_field = $rules['created_field'];
						}

						if(isset($rules['updated_field']) and $rules['updated_field'] != ''){
							$this->updated_field = $rules['updated_field'];
						}

						if(isset($this->table_0[$rules['table']]) and $this->table_0[$rules['table']] != ''){
							$rules['table'] = $this->table_0[$rules['table']];
						}

						$this->table = $rules['table'];

						$this->message = array();
					}

					public function data($data)
					{
						// 加密資料表名稱和欄位
						if(isset($this->encode_0[$this->table]) and count($this->encode_0[$this->table]) > 0){
							$encodes = array();
							foreach($this->encode_0[$this->table] as $k => $v){
								if(isset($data[$k])){
									$encodes[$v] = $data[$k];
								}
							}
							$data = $encodes;
						}

						$this->data = $data;

						return $this;
					}

					public function __set($name, $value)
					{
						// 加密資料表名稱和欄位
						if(isset($this->encode_0[$this->table][$name]) and $this->encode_0[$this->table][$name] != ''){
							$name = $this->encode_0[$this->table][$name];
						}
						
						$this->data[$name] = $value;
					}

					public function __get($name)
					{
						// 加密資料表名稱和欄位
						if(isset($this->encode_0[$this->table][$name]) and $this->encode_0[$this->table][$name] != ''){
							$name = $this->encode_0[$this->table][$name];
						}

						if (array_key_exists($name, $this->data)) {
							return $this->data[$name];
						}
						return null;
					}

					public function __isset($name)
					{
						// 加密資料表名稱和欄位
						if(isset($this->encode_0[$this->table][$name]) and $this->encode_0[$this->table][$name] != ''){
							$name = $this->encode_0[$this->table][$name];
						}

						return isset($this->data[$name]);
					}

					public function __unset($name)
					{
						// 加密資料表名稱和欄位
						if(isset($this->encode_0[$this->table][$name]) and $this->encode_0[$this->table][$name] != ''){
							$name = $this->encode_0[$this->table][$name];
						}

						unset($this->data[$name]);
					}

					public function __call($name, $arguments)
					{
						// 加密資料表名稱和欄位
						if(isset($this->encode_0[$this->table][$name]) and $this->encode_0[$this->table][$name] != ''){
							$name = $this->encode_0[$this->table][$name];
						}

						if(preg_match('/^find_by_(.*)$/', $name, $matches) and count($arguments) == 1){
							$this->update_key = $matches[1];
							$this->update_value = $arguments[0];
							return $this;
						}

						return false;
					}

					public function message()
					{
						return $this->message;
					}

					public function validate()
					{
						$status = true;

						if($this->rules and count($this->rules) > 0){
							foreach($this->rules as $k => $v){ // 每一個欄位，可以有一個以上的規則
								if(isset($v[0]) and $v[1]){
									$name = $v[0];

									// 加密資料表名稱和欄位
									if(isset($this->encode_0[$this->table][$name]) and $this->encode_0[$this->table][$name] != ''){
										$name = $this->encode_0[$this->table][$name];
									}

									$type = $v[1];
									$param = array(); // 額外參數
									if(isset($v[2])){
										$param = $v[2];
									}

									if(!isset($this->data[$name])){
										$this->message[] = 'validate|'.$name.'|not exists';
										$status = false; break;
									}

									$value = $this->data[$name];
									if($type == 'required'){
										if($value == null){
											$this->message[] = 'validate|'.$name.'|'.$type.'|check fail';
											$status = false; break;
										} elseif($value == ''){
											$this->message[] = 'validate|'.$name.'|'.$type.'|check fail';
											$status = false; break;
										}
									}
								}
							}
						}

						return $status;
					}

					public function insert()
					{
						$status = false;

						// 檢查欄位是否存在
						$fields = $this->cidb->list_fields($this->table);
						$save = $this->data;
						if($save and count($save) > 0){
							foreach($save as $k => $v){
								if(!in_array($k, $fields)){
									unset($save[$k]);
								}
							}
						}

						$this->cidb->insert($this->table, $save); 
						$id = $this->cidb->insert_id();

						if($id > 0){
							$status = true;
						}
						return $status;
					}

					public function update()
					{
						$status = false;

						// 檢查欄位是否存在
						$fields = $this->cidb->list_fields($this->table);
						$update = $this->data;
						if($update and count($update) > 0){
							foreach($update as $k => $v){
								if(!in_array($k, $fields)){
									unset($update[$k]);
								}
							}
						}

						$this->cidb->where($this->update_key,$this->update_value)->update($this->table, $update); 
						$count = $this->cidb->affected_rows();

						if($count > 0){
							$status = true;
						}
						return $status;
					}
				}

class Splitpage {
	private $records_per_page;  // 顯示筆數
	private $page;              // 目前所在頁數 
	private $total_records;     // 每幾筆分一頁
	private $total_pages;       // 總分頁數
	private $started_record;

	// 每次顯示的分頁數量
	// 如果是10的話，範例就是1~10或10~20
	private $listPage;  

	private $startPage;
	private $endPage;
	public $viewlist;

	// 自己加上的功能
	public $basic_element = array(); // [array] 基本元素(first,prev,next,last,now(現在頁面的編號))
	public $page_element = array();  // [array] 頁面編號及連結對應表

	function __construct() {
	}

	// 這裡的參數，跟yii架構(_i/framework/backend/components/Splitpage.php)的參數不一樣，是為了預設值的定義而調整
	public function set($total_records, $page = 1, $records_per_page = 10, $listPage = 10) {
		$this->records_per_page = (int)$records_per_page;
		$this->page          = (int)$page;
		$this->total_records = (int)$total_records;
		$this->listPage      = (int)$listPage;
		$this->setALL();
	}

	public function set_for_group_array($page, $total_records, $records_per_page, $listPage, $group_array) {
		if($page == '') $page = 1;
		if($listPage == '') $listPage = 10;
		if($records_per_page == '') $records_per_page = 10; 

		//$this->records_per_page = (int)$records_per_page;
		$this->page          = (int)$page;
		$this->total_records = (int)$total_records;
		$this->listPage      = (int)$listPage;


		$this->setALL_for_group_array($group_array);
	}

	public function setALL() {  //設定類別參數
		$this->total_pages = ceil($this->total_records / $this->records_per_page);
		$this->started_record = $this->records_per_page * ($this->page-1);
		if($this->listPage < $this->total_pages) {
			if($this->page % $this->listPage == 0)
				$this->startPage = $this->page - $this->listPage + 1;
			else
				$this->startPage = $this->page - $this->page % $this->listPage + 1;

			if(($this->startPage + $this->listPage) > $this->total_pages)
				$this->endPage = $this->total_pages;
			else
				$this->endPage = ($this->startPage + $this->listPage - 1);
		}
		else {
			$this->startPage = 1;/*預設頁面編號是1*/
			$this->endPage = $this->total_pages;
		}
	}

	public function setALL_for_group_array($group_array) {
		//$this->total_pages = ceil($this->total_records / $this->records_per_page);
		$this->total_pages = count($group_array);
		//$this->started_record = $this->records_per_page * ($this->page-1);
		if($this->listPage < $this->total_pages) {
			if($this->page % $this->listPage == 0)
				$this->startPage = $this->page - $this->listPage + 1;
			else
				$this->startPage = $this->page - $this->page % $this->listPage + 1;

			if(($this->startPage + $this->listPage) > $this->total_pages)
				$this->endPage = $this->total_pages;
			else
				$this->endPage = ($this->startPage + $this->listPage - 1);
		}
		else {
			$this->startPage = 1;/*預設頁面編號是1*/
			$this->endPage = $this->total_pages;
		}
	}

	/*
	 * 產生2種導覽列，一種是基本版型的導覽列，另一種是可套其他版型的導覽列
	 *
	 * 引數說明
	 *   url 網址(aaa.php)
	 *   url_arg GET引數(abc=123)
	 *   records_enable 是否要加上顯示每頁筆數的功能
	 */
	//function setViewList($url, $url_arg, $records_enable = false) {
	public function setViewList($url, $url_arg = 'page') {

		$url = $url.'/'.$url_arg.'/';

		// 初始化
		$this->viewlist = '';
		$this->basic_element = array();
		$this->page_element = array();

		// 預設值
		$this->basic_element['now'] = $this->page; /*指定現在的頁面編號*/
		$this->basic_element['total'] = $this->total_pages;
		$this->basic_element['first'] = $url.'1';

		// 如果總分頁數的設定超過1，才會跑這裡，大部份的情況都會超過0
		if($this->total_pages > 1) {
			if(($this->page - 1) != 0) {
				$this->basic_element['prev'] = $url.($this->page - 1);

				// 處理上十頁區段的地方
				if($this->total_pages > $this->listPage){
					if( (($this->startPage - $this->listPage) >= 1) and ($this->page > $this->listPage)) {
						//$this->basic_element['prevten'] = ($this->startPage - $this->listPage);
						$this->basic_element['prevten'] = $url.($this->startPage - 1);
					}
				}
			} /* if page-1 */

			for($pagenumber = $this->startPage; $pagenumber <= $this->endPage; $pagenumber++){
				if($pagenumber != $this->page){
					$this->page_element[] = array('name' => $pagenumber,
						'link' => $url.$pagenumber
					);
					// 現行的page編號要如何處理，就是這裡
				} else {
					$this->page_element[] = array('name' => $pagenumber,
						'link' => $url.$pagenumber
					);
				}
			} /* for */


			if(($this->page + 1) <= $this->total_pages) {
				// 處理下十頁區段的地方
				if(($this->total_pages > $this->listPage) and ($this->endPage != $this->total_pages)){
					$this->basic_element['nextten'] = $url.($this->endPage + 1);
				}
				$this->basic_element['next'] = $url.($this->page + 1);
			}
		}

		$this->basic_element['last'] = $url.$this->total_pages;

	} /* end function setViewList */

	/*
	 * 產生導覽的基本元素與連結的對應陣列
	 *
	 * 陣列元素:
	 *  first 第1頁
	 *  prevten 上十頁(暫不寫)
	 *  prev 上一頁(暫不寫)
	 *
	 *  nextten 下十頁(暫不寫)
	 *  next 下一頁(暫不寫)
	 *  last 最後一頁
	 *
	 * 陣列值:
	 *  都是連結
	 */
	public function setBasicElement($url) {

		$this->basic_element['first'] = $url.'page=1';

		// 如果目前所在的頁面和最後一頁是同一頁的情況
		if( $this->page == $this->endPage ){
			$this->basic_element['last'] = '';
		} else {
			$this->basic_element['last'] = $url.'page='.$this->endPage;
		}

	} /* end function setBasicElement */

	/*
	 * 產生導覽的頁面編號及連結的對應陣列
	 *
	 * 陣列元素:
	 *  name  頁面的編號
	 *  link  頁面的連結
	 */
	//function setPageElement($url, $target = false) {
	public function setViewList_for_group_array($url = '', $url2 = '', $group_array, $records_enable = false) {

		// 定義副檔名名稱
		//$extensionname = '.html';
		$extensionname = '';

		// 分隔的字元
		$intervalchar = '';

		// 初始化
		$url = $url.$intervalchar;
		$this->basic_element = array();
		$this->page_element = array();

		if($records_enable){
			// 本來是 => .html
			// 如果有啟用顯示每頁筆數的功能
			// 就會變成這樣子 => _20.html
			$extensionname = $intervalchar.$this->records_per_page.$extensionname;
		}

		// 預設值
		$this->basic_element['now'] = $this->page; /*指定現在的頁面編號*/
		$this->basic_element['total'] = $this->total_pages;
		$this->basic_element['first'] = $url.'1'.$extensionname;

		if($this->total_pages > 1) {
			if(($this->page - 1) > 0) {
				$this->basic_element['prev'] = $url.($this->page - 1).$extensionname;

				// 處理上十頁區段的地方
				if($this->total_pages > $this->listPage){
					if(($this->startPage - $this->listPage) >= 1 and $this->page > $this->listPage) {
						$this->basic_element['prevten'] = $url.($this->startPage - $this->listPage).$extensionname;
					}
				}
			}

			for($pagenumber = $this->startPage; $pagenumber <= $this->endPage; $pagenumber++){
				if($pagenumber != $this->page){
					$this->page_element[] = array('name' => $pagenumber,
						'link' => $url.$pagenumber.$extensionname
					);
				} else {
					$this->page_element[] = array('name' => $pagenumber,
						'link' => $url.$pagenumber.$extensionname
					);
				}
			} /*for*/

			if(($this->page + 1) <= $this->total_pages) {
				// 處理下十頁區段的地方
				if(($this->total_pages > $this->listPage) and ($this->endPage != $this->total_pages)){
					$this->basic_element['nextten'] = $url.($this->endPage + 1);
				}
				$this->basic_element['next'] = $url.($this->page + 1).$extensionname;
			}
		}
		$this->basic_element['last'] = $url.$this->endPage.$extensionname;

		$return = array(
			'total' => $this->total_records,
			'control' => $this->basic_element,
			'number' => $this->page_element,
			//'number_range' => array(
			//	$tmp1['name'],
			//	$tmp2['name'],
			//),
			'records_per_page' => $this->records_per_page,
			'url' => $url2,
		);
		return $return;

	} /* setViewList_for_rewrite */


	/*
	 * 給Rewrite專用的導覽列
	 *
	 * 分頁從1開始
	 * 
	 * 引數說明:
	 *   url 網址
	 *   records_enable 是否要加上顯示每頁筆數的功能
	 */
	public function setViewList_for_rewrite($url = '', $url2 = '', $records_enable = false) {

		// 定義副檔名名稱
		//$extensionname = '.html';
		$extensionname = '';

		// 分隔的字元
		$intervalchar = '';

		// 初始化
		$url = $url.$intervalchar;
		$this->basic_element = array();
		$this->page_element = array();

		if($records_enable){
			// 本來是 => .html
			// 如果有啟用顯示每頁筆數的功能
			// 就會變成這樣子 => _20.html
			$extensionname = $intervalchar.$this->records_per_page.$extensionname;
		}

		// 預設值
		$this->basic_element['now'] = $this->page; /*指定現在的頁面編號*/
		$this->basic_element['total'] = $this->total_pages;
		$this->basic_element['first'] = $url.'1'.$extensionname;

		if($this->total_pages > 1) {
			if(($this->page - 1) > 0) {
				$this->basic_element['prev'] = $url.($this->page - 1).$extensionname;

				// 處理上十頁區段的地方
				if($this->total_pages > $this->listPage){
					if(($this->startPage - $this->listPage) >= 1 and $this->page > $this->listPage) {
						$this->basic_element['prevten'] = $url.($this->startPage - $this->listPage).$extensionname;
					}
				}
			}

			for($pagenumber = $this->startPage; $pagenumber <= $this->endPage; $pagenumber++){
				if($pagenumber != $this->page){
					$this->page_element[] = array('name' => $pagenumber,
						'link' => $url.$pagenumber.$extensionname
					);
				} else {
					$this->page_element[] = array('name' => $pagenumber,
						'link' => $url.$pagenumber.$extensionname
					);
				}
			} /*for*/

			if(($this->page + 1) <= $this->total_pages) {
				// 處理下十頁區段的地方
				if(($this->total_pages > $this->listPage) and ($this->endPage != $this->total_pages)){
					$this->basic_element['nextten'] = $url.($this->endPage + 1);
				}
				$this->basic_element['next'] = $url.($this->page + 1).$extensionname;
			}
		}
		$this->basic_element['last'] = $url.$this->endPage.$extensionname;

		$return = array(
			'total' => $this->total_records,
			'control' => $this->basic_element,
			'number' => $this->page_element,
			//'number_range' => array(
			//	$tmp1['name'],
			//	$tmp2['name'],
			//),
			'records_per_page' => $this->records_per_page,
			'url' => $url2,
		);
		return $return;

	} /* setViewList_for_rewrite */

} /* end class SplitPage */

class base64url
{
	/*
	 * http://stackoverflow.com/questions/1374753/passing-base64-encoded-strings-in-url
	 */
	// 加號，yii會濾掉
	public static function encode($data)
	{
		//return strtr(base64_encode($data), '+/=', '-_,');
		return strtr(base64_encode($data), '+/=', '*_,');
		//return substr_replace(strtr(base64_encode($data), '+/=', '*_,'),2);
	}

	public static function decode($base64)
	{
		//return base64_decode(strtr($base64, '*_', '+/'));
		//return base64_decode(strtr($base64, '-_,', '+/='));
		return base64_decode(strtr($base64, '*_,', '+/='));
	}

	//// 目前只有/auth/font會用得到。但目前沒有用
	//public static function decode_other($base64)
	//{
	//	return base64_decode(strtr($base64, '-_', '+/'));
	//}

	// http://php.net/manual/en/function.base64-encode.php#82947
	// unchanged, thanx Tom, Andy, fsx.nr01
	//function encode($input) {
	//	return strtr(base64_encode($input), '+/=', '-_,');
	//}

	//function decode($input) {
	//	return base64_decode(strtr($input, '-_,', '+/='));
	//}

	//// some variables are used for clarity, they can be avoided and lines can be shortened:

	//function encryptId($int, $TableSalt='') {
	//	global $GlobalSalt;    // global secret for salt.
	//   
	//	$HashedChecksum = substr(sha1($TableSalt.$int.$GlobalSalt), 0, 6);
	//	// The length of the "HashedChecksum" is another little secret,
	//	// but when the integers are small, it reveals...
	//   
	//	$hex = dechex($int);
	//	// The integer is better obfuscated by being HEX like the hash.
	//   
	//	return base64url_encode($HashedChecksum.$hex);
	//	// reordered, alternatively use substr() with negative lengths...
	//}

	//function decryptId($string, $TableSalt='') {
	//	// checks if the second part of the base64 encoded string is correct.
	//	global $GlobalSalt;    // global secret for salt.
	//	$parts = base64url_decode($string);
	//	$hex = substr($parts, 6);
	//	$int = hexdec($hex);
	//	$part1 = substr($parts, 0, 6);    // The "checksum/salt" is always the same length
	//   
	//	return substr(sha1($TableSalt.$int.$GlobalSalt), 0, 6) === $part1
	//		? $int
	//		: false;    // distinguish "0" and "false"
	//}

}


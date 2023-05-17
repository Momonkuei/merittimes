<?php
/**
 * 扩展增加smarty模板 
 *
 * @author Hema
 * @link http://www.ttall.net/
 * @copyright Copyright © 2012-2015  ttall.net
 * @license http://www.ttall.net/license/
 */
require_once (Yii::getPathOfAlias('application.extensions.smarty') . DIRECTORY_SEPARATOR . 'Smarty.class.php');
define('SMARTY_VIEW_DIR', Yii::getPathOfAlias('application.views'));
class CSmarty extends Smarty {
	const DIR_SEP = DIRECTORY_SEPARATOR;
	function __construct() {
		parent::__construct();
		$this -> template_dir = SMARTY_VIEW_DIR;
		$this -> compile_dir = Yii::app()->getRuntimePath() . DIR_SEP . 'compile';
		$this -> caching = false;
		$this -> cache_dir = Yii::app()->getRuntimePath() . DIR_SEP . 'cache';
		$this -> left_delimiter = '{{';
		$this -> right_delimiter = '}}';
		$this -> cache_lifetime = 0;
		$this -> plugins_dir = array(
			Yii::getPathOfAlias('application.extensions.smarty') . DIR_SEP . 'plugins',
			_BASEPATH . DIR_SEP . 'smarty',
		);
		$this->register_function[] = 'multi_language_output';

		// 要注意，它是吃效能的東西，雖然只有在第一次的compiler
		//$this->register_prefilter('smarty_prefilter_i18n');

		$this->register_resource("text", array($this, "text_get_template",
		"text_get_timestamp",
		"text_get_secure",
		"text_get_trusted"));

		if(!file_exists($this->compile_dir)){
			@mkdir($this->compile_dir, 0777, true);
		}
		if(!file_exists($this->cache_dir)){
			@mkdir($this->cache_dir, 0777, true);
		}

		// 先移掉注解
		$this->load_filter('output', 'remove_html_comment');

		// 在把空白等東西拿掉
		//$this->load_filter('output', 'trimwhitespace_custom');

		// 在調整效能的時使，要注意這裡，建議不要啟用這個功能，就也是不要用prefilter，至少會多100ms以上的執行時間
		//if(defined('ENVIRONMENT') and ENVIRONMENT == 'development'){
		//	$this->force_compile = true;
		//}

		// -- 初始全局数据
		//$this -> assign('base_url', 'http://www.ttall.net');
		//$this -> assign('index_url', 'http://www.ttall.net/index.php');
	}
	function init() {
	}

	/**
	 * 可以載入變數的template
	 * http://www.webdnes.cz/blog/blog2.php/2009/12/23/smarty-resources-template-from-string
	 */
	public static function text_get_template($tpl_name, &$tpl_source, &$smarty)
	{
		$tpl_source = $tpl_name;
		return true;
	}
	public static function text_get_timestamp($tpl_name, &$tpl_timestamp, &$smarty)
	{
		/**
		* uses the static variable assigned in the DisplayCategory function
		*/
		//if(!empty(self::$mktime)) {
		//$tpl_timestamp=self::$mktime;
		return true;
		//}

		//return false;
	}
	public static function text_get_secure($tpl_name, &$smarty)
	{
		// assume all templates are secure
		return true;
	}
	public static function text_get_trusted($tpl_name, &$smarty)
	{
		// not used for templates
	} 

}

/**
 * 負責處理ml:開頭的函式
 * 目前只有這個地方可以使用
 * 如果要修改開頭字串，只要改這裡就可以了
 * void register_function(string name, mixed impl, bool cacheable, mixed cache_attrs);
 */
function multi_language_output($label, $ml_key, $class)
{
	// 只有後台才會維持顯示繁體中文tw
	//$ml_key = 'tw';

	if(strlen($label) <= 3){
		return $label;
	}

	$isml = strtolower(substr($label, 0, 3));
	$isml2 = strtolower(substr($label, 0, 5));

	if(preg_match('/^ml(..):/', $isml2, $matches)){
		$ml_key = $matches[1];
		$label_key = substr($label, 5);

		// 載入多國語系，如果自己有，就用自己的，沒有的話，就用共用的
		//if(file_exists(tmp_path.ds('/language.php'))){
		//	require tmp_path.ds('/language.php');
		//} else {
		//	require lang_path.ds('/language.php');
		//}
		//$CI =& get_instance();
		//$labels = $CI->labels;
		$labels = G::l();

		$aaa = $labels[$ml_key][strtolower($label_key)];
		if($aaa == ''){
			if(preg_match('/^\[\[.*\]\] (.*)$/', $label_key, $matches)){
				return $matches[1];
			}
			return $label_key;
		}
		return $aaa;
	} elseif($isml == 'ml:'){
		$label_key = substr($label, 3);

		// 載入多國語系，如果自己有，就用自己的，沒有的話，就用共用的
		//if(file_exists(tmp_path.ds('/language.php'))){
		//	require tmp_path.ds('/language.php');
		//} else {
		//	require lang_path.ds('/language.php');
		//}
		//$CI =& get_instance();
		//$labels = $CI->labels;
		$labels = G::l();
		//var_dump($labels);

		$aaa = $labels[$ml_key][strtolower($label_key)];
		if($aaa == ''){
			if(preg_match('/^\[\[.*\]\] (.*)$/', $label_key, $matches)){
				return $matches[1];
			}
			return $label_key;
		}
		return $aaa;
	} else {
		if(preg_match('/^\[\[.*\]\] (.*)$/', $label, $matches)){
			return $matches[1];
		} else {
			return $label;
		}
	}
}

/**
 * smarty_prefilter_i18n()
 * This function takes the language file, and rips it into the template
 * $GLOBALS['_NG_LANGUAGE_'] is not unset anymore
 *
 * @param $tpl_source
 * @return
 **/
function smarty_prefilter_i18n($tpl_source, &$smarty) {
	return preg_replace_callback('/##(.+?)##/', '_compile_lang', $tpl_source);
}

/**
 * _compile_lang
 * Called by smarty_prefilter_i18n function it processes every language
 * identifier, and inserts the language string in its place.
 *
 */
function _compile_lang($key) {
	//$CI =& get_instance();
	$ml_key = Yii::app()->session['interface_ml_key'];
	//$ml_key = $CI->session->userdata('ml_key');
	// 介面的部份，因為是後台的關係，所以都是繁體的
	//$aaa = $GLOBALS['_NG_LANGUAGE_']['tw'][strtolower($key[1])];

	// 只有後台才會維持顯示繁體中文tw
	//$ml_key = 'tw';

	$labels = G::l();

	// 載入多國語系，如果自己有，就用自己的，沒有的話，就用共用的
	//if(file_exists(tmp_path.ds('/language.php'))){
	//	require tmp_path.ds('/language.php');
	//} else {
	//	require lang_path.ds('/language.php');
	//}

	$aaa = $labels[$ml_key][strtolower($key[1])];

	if($aaa == ''){
		if(preg_match('/^\[\[.*\]\] (.*)$/', $key[1], $matches)){
			return $matches[1];
		}
		return $key[1];
	} else {
		return $aaa;
	}
	//return $GLOBALS['_NG_LANGUAGE_'][$ml_key][$key[1]];
}

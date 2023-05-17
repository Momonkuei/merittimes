<?php

/*
 * 試著分離method
 */
//include Yii::getPathOfAlias('system.frontend.components.Layoutv2').'.php';
include Yii::getPathOfAlias('system.frontend.components.Controllerfront').'.php';

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
//class Controller extends Layoutv2 
class Controller extends Coremodulelast 
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	//public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	//public $breadcrumbs=array();

	// 上面Controllerfront裡面會有東西會判斷以及修改哦，為了減化網址，以及在不使用Rewrite的方式來做到減化網址的目的
	//public $defaultAction = 'ggg';

	public $_action;

	public $db = NULL;
	public $cidb = NULL;
	public $assetsUrl = NULL;

	public $data = array();
	public $labels = array();

	function init()
	{
		parent::init();

		// 參考阿財
	    $this->getAssetsUrl();

		// 樣版的多國語系種類(Yiiv在使用的，smarty沒有用到)
		// 我把切換樣版，和它的多國語系分開，因為切換樣版加多國語系的機率，比切換樣版的機率還要低
		$this->data['theme_lang'] = 'web';

		if (!defined('theme_lang')) {
			// G::a在使用的
			define('theme_lang', $this->data['theme_lang']);
		}

		// 範例 http://www.yiiframework.com/forum/index.php/topic/25123-position-of-css-links-registered-in-a-package/
        //$this->data['clientscript_packages'] = array(
		//	//'mytheme' => array(
		//	//	'basePath'=>'application.themes.mytheme',
		//	//	'baseUrl'=>'/themes/mytheme/',
		//	//	'js'=>array('js/layout.js', 'js/ga.js'),
		//	//	'css'=>array('css/form.css', 'css/main.css'),
		//	//	'depends'=>array('jquery'),
		//	//),
		//	'jquery.ui'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		//'js'=>array('jui/js/jquery-ui.min.js'),
		//		'js'=>array('js/jquery-ui-1.8.8.custom.min.js'),
		//		'css'=>array('css/smoothness/jquery-ui-1.8.8.custom.css'),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.validate'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jquery.validate.min.js'),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.uniform'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jquery.uniform.min.js'),
		//		'css'=>array('css/uniform.default.css'),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.wysiwyg'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jquery.wysiwyg.js'),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.superfish'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/superfish.js'),
		//		'css'=>array('css/superfish.css'),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.flot'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jquery.flot.min.js'),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.facebox'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/facebox.js'),
		//		'css'=>array('css/facebox.css'),
		//		'depends'=>array('jquery'),
		//	),
		//	'facebox.start'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/facebox_start.js'),
		//		'depends'=>array('jquery.facebox'),
		//	),
		//	// 通常是image token在使用的
		//	'jquery.random'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jquery.random.js'),
		//		'depends'=>array('jquery'),
		//	),
		//	// 裁圖
		//	'jcorp'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array(YII_DEBUG ? 'js/jcorp/jquery.Jcrop.js' : 'js/jcorp/jquery.Jcrop.min.js'),
		//		'css'=>array(YII_DEBUG ? 'css/jcorp/jquery.Jcrop.css' : 'js/jcorp/jquery.Jcrop.min.css'),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.widget'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jquery.ui.widget.js'),
		//		'depends'=>array('jquery','jquery.ui'),
		//	),
		//	'jquery.datepicker'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jquery.ui.datepicker.js'),
		//		'depends'=>array('jquery.widget'),
		//	),
		//	'jquery.colorpicker'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jquery.colorPicker.js'),
		//		'css'=>array('css/colorPicker.css'),
		//		'depends'=>array('jquery'),
		//	),
		//	'fileuploader'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/fileuploader.js', 'js/jquery.random.js'),
		//		'css'=>array('css/fileuploader.css'),
		//		'depends'=>array('jquery'),
		//	),
		//	'fileuploader.single'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/fileuploader.custom.singleupload.js',),
		//		'depends'=>array('jquery', 'fileuploader'),
		//	),
		//	'fileuploader.multi'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/fileuploader.custom.multiupload.js',),
		//		'depends'=>array('jquery', 'fileuploader', 'sortable'),
		//	),
		//	'swfuploader'=>array(
		//		//'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('swfupload/swfupload.js', 'swfupload/plugins/swfupload.queue.js'),
		//		'css'=>array('swfupload/swfupload.css'),
		//	),
		//	'sortable'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array(
		//			'js/tool-man/core.js',
		//			'js/tool-man/events.js',
		//			'js/tool-man/css.js',
		//			'js/tool-man/coordinates.js',
		//			'js/tool-man/drag.js',
		//			'js/tool-man/dragsort.js',
		//			'js/tool-man/cookies.js',
		//		),
		//	),
		//	'jquery.syntaxhighlighter'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/jQuery-SyntaxHighlighter/scripts/jquery.syntaxhighlighter.min.js'),
		//		'css'=>array(
		//			array('js/jQuery-SyntaxHighlighter/styles/style.css',array('media' => 'screen')),
		//		),
		//	),
		//	'ckeditor'=>array(
		//		'baseUrl' => Yii::app()->baseUrl,
		//		'js'=>array('ckeditor/ckeditor.js', 'ckfinder/ckfinder.js'),
		//	),
		//	'codemiror2'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array('js/codemirror2/lib/codemirror.js', 'js/codemirror2/mode/css/css.js'),
		//		'css'=>array('js/codemirror2/lib/codemirror.css', ),
		//	),
		//	'jquery.autocomplete'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array(
		//			'js/autocomplete/jquery.bgiframe.min.js',
		//			'js/autocomplete/jquery.ajaxQueue.js',
		//			'js/autocomplete/thickbox-compressed.js',
		//			'js/autocomplete/jquery.autocomplete.js',
		//		),
		//		'css'=>array('css/jquery.autocomplete.css', 'css/thickbox.css'),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.autoautosize'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array(
		//			'js/jquery.autosize.js',
		//		),
		//		'depends'=>array('jquery'),
		//	),
		//	'jquery.digits'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array(
		//			'js/jquery.digits.js',
		//		),
		//		'depends'=>array('jquery'),
		//	),
		//	// http://digitalbush.com/projects/masked-input-plugin/
		//	'jquery.maskedinput'=>array(
		//		'baseUrl'=>$this->assetsUrl,
		//		'js'=>array(
		//			'js/jquery.maskedinput.js',
		//		),
		//		'depends'=>array('jquery'),
		//	),
        //);
        //Yii::app()->clientScript->packages = $this->data['clientscript_packages'];
	}

	public function getAssetsUrl()
    {
		if ($this->assetsUrl === null){
			// http://www.yiiframework.com/wiki/311/assetmanager-clearing-browser-s-cache-on-site-update/    Step2
			//$this->assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.assetsg'), false, -1, defined('YII_DEBUG') && YII_DEBUG);
			$this->assetsUrl = '/'.str_replace(str_replace('_i/web/assetsg','',Yii::getPathOfAlias('application.assetsg')), '', Yii::getPathOfAlias('application.assetsg'));
			//$this->assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.assetsg'),false,-1,defined('YII_DEBUG') && YII_DEBUG);
		}
		$this->data['asseturl'] = $this->assetsUrl;
		return $this->assetsUrl;
	}
    
	public function setAssetsUrl($value) 
    {
		$this->assetsUrl = $value;
		$this->data['asseturl'] = $value;
	}

	protected function beforeAction($action)
	{
		// 1.1.13 
		//echo Yii::getVersion();

		$class = Yii::app()->controller->id;
		$method = Yii::app()->controller->action->id;

		// 這個是要給sys_log的物件所使用
		Yii::app()->session['sys_log_code'] = $class.'/'.$method;

		// http://b1.cloud.oz.gisanfu.idv.tw 在一般的VH上看到的狀況
		// http://qa.test.oz.gisanfu.idv.tw/cloud 在QA站上看到的狀況
		$this->data['base_url'] = Yii::app()->getBaseUrl(true);

		$this->data['class_url'] = $this->data['base_url'].'/index.php?r='.$class;
		$this->data['current_url'] = $this->data['class_url'].'/'.$method;

		// get db object
		$this->db = Yii::app()->db;
		$this->cidb = Yii::app()->params['cidb'];

		// 取得sys_config裡面的資料
		$rows = $this->db->createCommand()->from('sys_config')->queryAll();
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
			//$this->load->library('Ml2', '', 'ml');
			$ml = new Ml2;
			$ml->export();

			// 看一下他的片語值是否有存在
			// 存在的話，把值改成空白，不存在就放了它
			if(count($this->db->createCommand()->from('sys_config')->where('keyname = :name', array(':name'=> '_need_label_export'))->queryAll())){
				$this->db->createCommand()->delete('sys_config', 'keyname = :name', array(':name'=> '_need_label_export'));
			}
		}

		// 載入多國語系
		$this->labels = G::l();

		$all_session = Yii::app()->session;

		// 將驗證類的session值，傳給smarty
		foreach($all_session as $k => $v){
			if(preg_match('/^authw_(.*)$/', $k, $matches)){
				//echo $matches[1];
				// 加了一個w底線，為了要區分前台和後台的session變數群
				$this->data[$matches[1]] = $v;
			}
		}

		$this->data['router_class'] = $class;
		$this->data['router_method'] = $method;

		// 設定語系與抓取語系
		//$ml_key = Yii::app()->session['interface_ml_key'];
		//$ml_key = '';
		$ml_key = domain_ml_key;
		$this->data['default_ml_key'] = $ml_key;

		/*
		 * 介面語系的優先權處理過程
		 */

		// 如果是空白，就取用使用者所選擇的語系
		if($ml_key == '' and isset(Yii::app()->session['web_ml_key']) and Yii::app()->session['web_ml_key'] != ''){
			$ml_key = Yii::app()->session['web_ml_key'];
			//$this->data['default_ml_key'] = Yii::app()->language; // 2017-06-13 所發現的可能性的問題
			$this->data['default_ml_key'] = Yii::app()->session['web_ml_key'];
		}

		// 如果還是空白，就取用系統的語系預設值
		if($ml_key == ''){
			$this->data['default_ml_key'] = Yii::app()->language;
			$ml_key = Yii::app()->language;
		} else {
			//$this->data['default_ml_key'] = Yii::app()->language; // 2017-06-13 所發現的可能性的問題
			Yii::app()->language = $ml_key;
		}

		// 我就跟你說吧，最終預設語系是繁體(kid)
		if($ml_key == ''){
			$ml_key = 'tw';
		}

		Yii::app()->session['web_ml_key'] = $ml_key;
		$this->data['ml_key'] = $ml_key;

		// 取得語系列表
		//$rows = $this->db->createCommand()->from('ml')->where('is_enable = 1')->where(array('like', 'interface', '%,2,%'))->order('sort_id')->queryAll();
		$rows = $this->db->createCommand('select * from ml where is_enable=1 and interface like "%,2,%" order by sort_id')->queryAll();
		foreach($rows as $row){

			// 2017-05-02 李哥說要加的
			if(isset($row['domain_name']) and $row['domain_name'] != ''){
				if($row['domain_name'] == $_SERVER['HTTP_HOST']){
					// do nothing
				} else {
					continue;
				}
			}
			$tmp = $this->_getValueLabel($row['name'], $this->data['ml_key']);
			$mls[$row['key']] = $tmp;
			$mls_tmp[] = $row['key'];
		}
		$this->data['mls'] = $mls;
		$this->data['mls_tmp'] = $mls_tmp;

		// 設定相對路徑
		Yii::app()->session->add('image_crop_path', customer_public_path.'crop'); // 擺放裁圖前的原圖  
		Yii::app()->session->add('image_thumb_path', customer_public_path.'thumb');
		Yii::app()->session->add('image_thumb_tmp_path', customer_public_path.'thumb');
		Yii::app()->session->add('image_upload_path', customer_public_path.'upload');
		Yii::app()->session->add('image_upload_tmp_path', customer_public_path.'file');
		Yii::app()->session->add('image_upload_static_path', customer_public_path.'static');
		Yii::app()->session->add('file_upload_path', customer_public_path.'upload_tmp');
		Yii::app()->session->add('file_upload_tmp_path', customer_public_path.'file_tmp');
		Yii::app()->session->add('vir_path_c', vir_path_c.'_i/'); // 給kcfinder的config所使用

		$this->data['image_crop_path'] = customer_public_path.'crop';
		$this->data['image_thumb_path'] = customer_public_path.'thumb';
		$this->data['image_thumb_tmp_path'] = customer_public_path.'thumb_tmp';
		$this->data['image_upload_path'] = customer_public_path.'upload';
		$this->data['image_upload_tmp_path'] = customer_public_path.'upload_tmp';
		$this->data['file_upload_path'] = customer_public_path.'file';
		$this->data['file_upload_tmp_path'] = customer_public_path.'file_tmp';
		$this->data['tmp_path'] = customer_public_path.'tmp';

		//$this->data['current_user'] = array();
		//if(isset($this->data['admin_id']) and $this->data['admin_id'] != ''){
		//	$row = $this->db->createCommand()->from('member')->where('id='.$this->data['admin_id'])->queryRow();
		//	if(isset($row['id'])){
		//		$this->data['current_user'] = $row;
		//	}
		//}

		/*
		 * 想要在這裡寫一個處理Empty_orm的hack
		 */
		//$tmp = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/share/').'Empty_source_orm.php');
		$tmp = file_get_contents(Yii::getPathOfAlias('system').ds('/frontend/controllers/share/').'Empty_source_orm.php');
		$this->data['empty_orm'] = explode("\n", $tmp);
		$this->data['empty_orm_title'] = ' extends CActiveRecord';
		$this->data['empty_orm_count'] = 0;
		$this->data['empty_orm'][2] = 'class Empty_orm';
		unset($this->data['empty_orm'][0]);
		unset($this->data['empty_orm'][1]);

		// reindex array
		// http://stackoverflow.com/questions/5217721/how-to-remove-array-element-and-then-re-index-array
		$this->data['empty_orm'] = array_values($this->data['empty_orm']);

		// 使用新款Empty的原始方式
		// $this->data['empty_orm_count']++;
		// $eval_content = $this->data['empty_orm'];
		// $eval_content[0] .= (string)$this->data['empty_orm_count'].$this->data['empty_orm_title'];
		// eval(implode("\n", $eval_content));
		// $name = 'Empty_orm'.$this->data['empty_orm_count'];
		// $u = new $name('insert', $this->def['empty_orm_data']);

		$this->data['empty_orm_eval']  = ''; 
		$this->data['empty_orm_eval'] .= '$this->data[\'empty_orm_count\']++;'."\n";
		$this->data['empty_orm_eval'] .= '$eval_content = $this->data[\'empty_orm\'];'."\n";
		$this->data['empty_orm_eval'] .= '$eval_content[0] .= (string)$this->data[\'empty_orm_count\'].$this->data[\'empty_orm_title\'];'."\n";
		$this->data['empty_orm_eval'] .= 'eval(implode("\n", $eval_content));'."\n";
		$this->data['empty_orm_eval'] .= '$name = \'Empty_orm\'.$this->data[\'empty_orm_count\'];'."\n";

		// 使用新款Empty的另一種方式
		//eval($this->data['empty_orm_eval']);
		//$c = new $name('insert', $this->data['def']['empty_orm_data']);

		// 雖然大部份的東西共用，不過當然一定會有不共用的東西
		if(file_exists(Yii::getPathOfAlias('application.controllers').'/core.php')){
			include(Yii::getPathOfAlias('application.controllers').'/core.php');
		}


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

		// 為了方便前台撰寫程式
		$this->data['auth_admin_types'] = array();
		if(isset($_SESSION['auth_admin_type']) and $_SESSION['auth_admin_type'] != ''){
			$this->data['auth_admin_types'] = explode(',', $_SESSION['auth_admin_type']);
		}

		// 就是會在body結尾的上面輸出
		$this->data['html_end'] = '';

		/*
		 * 前台產生器V2 (就叫Layout V2好了)
		 */
		include Yii::getPathOfAlias('system.frontend.components').'/layout_v2.php';

		/*
		 * 前台產生器V1
		 */
		// include Yii::getPathOfAlias('system.components').'/frontend_generate.php';
		
		return parent::beforeAction($action);
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

	protected function email_send_to_by_sendmail($from = array()/*2層*/, $tos = array()/*3層*/, $subject, $body, $body_html,$cc_mail = NULL , $cc_body_html = NULL)
	{
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
				$mail->IsSMTP();                                      // set mailer to use SMTP			
				$mail->SMTPAuth = false;     // turn on SMTP authentication
				$mail->Host = 'localhost';  // specify main and backup server
				$mail->Port = 25;
				$mail->SMTPSecure = "";
				$mail->IsHTML(true);                                  // set email format to HTML
				$mail->CharSet = "utf-8";
				$mail->Encoding = "base64";
			
				$mail->From = $from['email'];
				$mail->FromName = $from['name'];
				$mail->AddAddress($to);
				$mail->Subject = $subject;
				$mail->Body = $body_html;

				$return['status1'][] = array(
					'email' => $to,
					'status' => $mail->send(),
				);
			}
			if($cc_mail){
				// print_r($cc_mail);
				/*
				$mail = new Zend_Mail('utf-8');
				$mail->setFrom($from['email'],$from['name']);
				$mail->addTo($cc_mail);
				$mail->setSubject($subject);
				$mail->setBodyText($body);
				$mail->setBodyHtml($body_html);
				*/
				$mail = new PHPMailer();
				$mail->IsSMTP();                                      // set mailer to use SMTP			
				$mail->SMTPAuth = false;     // turn on SMTP authentication
				$mail->Host = 'localhost';  // specify main and backup server
				$mail->Port = 25;
				$mail->SMTPSecure = "";
				$mail->IsHTML(true);                                  // set email format to HTML
				$mail->CharSet = "utf-8";
				$mail->Encoding = "base64";
			
				$mail->From = $from['email'];
				$mail->FromName = $from['name'];
				$mail->AddAddress($to);
				$mail->Subject = $subject;
				$mail->Body = $cc_body_html;


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

	/**
     * @return array action filters
	 * http://www.yiiframework.com/extension/yii-html-compactor/
     */
    public function filters()
    {
		if(defined('YII_DEBUG') && YII_DEBUG){
			// 開發時期是不壓縮的
			// 測試
			//return array(
			//	array(
			//		'application.filters.ECompressHtmlFilter',
			//		//'gzip'    => false,
			//		//'actions' => 'ALL'
			//	),
			//);
		} else {
			if(isset($_GET['seo'])){
			} else {
				//return array(
				//	array(
				//		'application.filters.ECompressHtmlFilter',
				//		//'gzip'    => false,
				//		//'actions' => 'ALL'
				//	),
				//);
			}
		}
    }

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	// http://www.weixuhong.com/%E6%8A%80%E6%9C%AF%E6%84%9F%E6%83%B3/php/2009/05/08/%E5%85%B3%E4%BA%8Eyii%E7%9A%84beforeaction%EF%BC%8Cafteraction%E7%9A%84%E7%94%A8%E6%B3%95/
	//public function runAction($action)
	//{
	//	$priorAction=$this->_action;
	//	$this->_action=$action;
	//	if($this->beforeAction($action)){
	//		$action->run();
	//		$this->afterAction($action);
	//	}
	//	$this->_action=$priorAction;
	//}

	//protected function afterAction($action)
	//{
	//	/*
	//	 * 上面搜尋資料
	//	 */

	//	$rows = $this->db->createCommand()->from('product_class')->where('is_enable=1 and pid=0')->queryAll();
	//	$this->data['product_classes_option2'] = '';
	//	if($rows){
	//		foreach($rows as $k => $v){
	//			$this->data['product_classes_tmp'][$v['id']] = $v;
	//			$selected = '';
	//			if(isset($this->data['type']) and $v['id'] == $this->data['type']){
	//				$selected = 'selected="selected"';
	//			}
	//			$this->data['product_classes_option2'] .= '<option '.$selected.' value="'.$v['id'].'">'.$v['class_name'].'</option>';
	//		}
	//	}
	//	echo '123';
	//	die;

	//	return parent::afterAction($action);
	//}

	/*
	 * 檢查值裡面，是否含有ml:前綴的字眼，有的話，就代表它是多國語片語
	 */
	protected function _getValueLabel($label_name, $ml_key = '')
	{
		//if($ml_key == '' and isset($this->data['ml_key']) and $this->data['ml_key'] != ''){
		//	$ml_key = $this->data['ml_key'];
		//}
		return G::t(null, $label_name);

		//$isml = strtolower(substr($label_name, 0, 3));
		//if($isml == 'ml:'){
		//	$label_key = substr($label_name, 3);
		//	if(isset($this->labels[$ml_key][strtolower($label_key)])){
		//		return $this->labels[$ml_key][strtolower($label_key)];
		//	} else {
		//		return $label_key;
		//	}
		//} else {
		//	return $label_name;
		//}
	}

	/*
	 * 在後端裡面，純多國語系片語
	 */
	protected function _getLabel($label_name, $ml_key = '')
	{
		return G::t(null, $label_name);
		//if($ml_key == '' and isset($this->data['ml_key']) and $this->data['ml_key'] != ''){
		//	$ml_key = $this->data['ml_key'];
		//}

		//if(isset($this->labels[$ml_key][strtolower($label_name)])){
		//	return $this->labels[$ml_key][strtolower($label_name)];
		//} else {
		//	return $label_name;
		//}
	}

	//    // 只取得檔案列表
	//    protected function _getFiles($dir)
	//    {
	//      $files = array();
	//      if ($handle = opendir($dir)) {
	//    	while (false !== ($file = readdir($handle))) {
	//    		if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
	//    			if(is_dir($dir.'/'.$file)){
	//    				//$dir2 = $dir.'/'.$file;
	//    				//$files[] = _getFilesFromDir($dir2);
	//    				//$files[] = $dir2;
	//    			}
	//    			else {
	//    				$files[] = $dir.'/'.$file;
	//    			}
	//    		}
	//    	}   
	//    	closedir($handle);
	//      }

	//      return $this->_array_flat($files);
	//    }

	//    // 只取得資料夾列表
	//    protected function _getDirs($dir)
	//    {
	//    	$files = array();
	//    	if ($handle = opendir($dir)) {
	//    		while (false !== ($file = readdir($handle))) {
	//    			if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
	//    				if(is_dir($dir.'/'.$file)){
	//    					$dir2 = $dir.'/'.$file;
	//    					//$files[] = _getFilesFromDir($dir2);
	//    					$files[] = $dir2;
	//    				}
	//    				else {
	//    					//$files[] = $dir.'/'.$file;
	//    				}
	//    			}
	//    		}   
	//    		closedir($handle);
	//    	}

	//    	return $this->_array_flat($files);
	//    }

	//    // 取得資料夾和檔案列表，包含子目錄
	//    protected function _getFilesFromDir($dir)
	//    {
	//    	$files = array();
	//    	if ($handle = opendir($dir)) {
	//    		while (false !== ($file = readdir($handle))) {
	//    			if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
	//    				if(is_dir($dir.'/'.$file)){
	//    					$dir2 = $dir.'/'.$file;
	//    					$files[] = $this->_getFilesFromDir($dir2);
	//    				}
	//    				else {
	//    					$files[] = $dir.'/'.$file;
	//    				}
	//    			}
	//    		}   
	//    		closedir($handle);
	//    	}

	//    	return $this->_array_flat($files);
	//    }

	//    protected function _array_flat($array) {

	//    	$tmp = array();
	//    	foreach($array as $a) {
	//    		if(is_array($a)) {
	//    			$tmp = array_merge($tmp, $this->_array_flat($a));
	//    		}   
	//    		else {
	//    			$tmp[] = $a; 
	//    		}   
	//    	}

	//    	return $tmp;
	//    }

}

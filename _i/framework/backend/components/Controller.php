<?php

/*
 * 試著分離method
 */
include Yii::getPathOfAlias('system.backend.components.Controllerfront').'.php';



/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
//class Controller extends CController
class Controller extends Coremodulelast 
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	public $assetsUrl = NULL;
	//private $_assetsUrl = NULL;
	public $data = array();
	public $db = NULL;
	public $cidb = NULL;
	public $cidbeip = NULL;
	public $pdo = NULL;
	public $labels = array();

	public $ignore_class_acl = array(
		'auth',
		'authlocal',
		'site',

		// 測試帳單匯出用，但這個一打開，會產生main_content_title沒有定義的錯誤
		//'billreport',
	);

	// 如果有用str_replace的eval會失敗，要注意哦，不要打開
	//protected $def = array();

	public function actionInput_additional()
	{
		if(!empty($_POST)){
			//echo '$(\'#'.$_POST['field_id'].'_anchor\').attr(\'data-original-title\', \'請點選，並輸入額外的內容\');';
			//'$(\'.tooltips\').tooltip();';
			//echo '$(\'#'.$_POST['field_id'].'_anchor\').hover(';
			//echo 'function(){';
			//echo '},function(){';
			//echo '});';
			//echo '$(\'#'.$_POST['field_id'].'_anchor\').hover();';
		}
		die;
	}

	/**
	 * Creates a relative URL based on the given controller and action information.
	 * @param string $route the URL route. This should be in the format of 'ControllerID/ActionID'.
	 * @param array $params additional GET parameters (name=>value). Both the name and value will be URL-encoded.
	 * @param string $ampersand the token separating name-value pairs in the URL.
	 * @return string the constructed URL
	 */
	//public function createUrl($route,$params=array(),$ampersand='&')
	//{
	//	return Yii::app()->getUrlManager()->createUrl($route,$params,$ampersand);
	//}

	// 這裡主要是用在view裡面，例如include search之類的在用的
	// 因為原先的//aaa/bbb寫得太多，懶的改了，所以用繼承的方式來改
	public function renderPartial($view,$data=null,$return=false,$processOutput=false)
	{
		// 先檢查一次，如果確定，就改寫
		//if(($this->getViewFile($view)) === false and preg_match('/^\/\/(.*)$/', $view, $matches)){
			//$tmp = $matches[1];

		// 2017-06-14
		// 如果在變數$view裡面，開頭是"//"斜線斜線，那個是不會經過底下我所撰寫的處理區塊！ 
		// 所以如果要子站部份繼承區塊的話，那母體就必需要把"//"拿掉
		if($this->getViewFile($view) === false){

			// 預設值是Application(後台子站)
			$tmp = $view;
			if(preg_match('/^\/\/(.*)$/', $view, $matches)){
				$tmp = $matches[1];
			}
			$view = 'application.views.'.str_replace('/', '.', $tmp);

			/*
			 * 檢查母體
			 */
			if($data['theme_name'] != 'admin_yiiv_3'){
				$view_tmp2 = Yii::getPathOfAlias('system.themes.admin_yiiv_3.views').'/'.$tmp.'.php';
				if(file_exists($view_tmp2)){
					$view = 'system.themes.admin_yiiv_3.views.'.str_replace('/', '.', $tmp);
				}
			}

			$view_tmp2 = Yii::getPathOfAlias('system.themes.'.$data['theme_name'].'.views').'/'.$tmp.'.php';
			if(file_exists($view_tmp2)){
				$view = 'system.themes.'.$data['theme_name'].'.views.'.str_replace('/', '.', $tmp);
			}

			/*
			 * 檢查子站
			 */
			$view_tmp2 = Yii::getPathOfAlias('application.views').'/'.$tmp.'.php';
			if(file_exists($view_tmp2)){
				$view = 'application.views.'.str_replace('/', '.', $tmp);
			}

			//$view_tmp2 = yii::getpathofalias('webroot.backend.views').'/'.$data['main_content'].'.php';
			//if(file_exists($view_tmp2)){
			//	$main_content = 'webroot.backend.views.'.str_replace('/', '.', $data['main_content']);
			//}

		} else {
			//echo $view."gggg\n";
		}

		//parent::renderPartial($view,$data,$return,$processOutput);

		if(($viewFile=$this->getViewFile($view))!==false)
		{
			$output=$this->renderFile($viewFile,$data,true);
			if($processOutput)
				$output=$this->processOutput($output);
			if($return)
				return $output;
			else
				echo $output;
		}
		else
			throw new CException(Yii::t('yii','{controller} cannot find the requested view "{view}".',
				array('{controller}'=>get_class($this), '{view}'=>$view)));

	}

	// 當method不存在的時候，打算符合某些名稱的時候，就自動去找Eob Class的麻煩
	// http://stackoverflow.com/questions/6350769/yiis-magic-method-for-controlling-all-actions-under-a-controller
	public function missingAction($actionID)
	{
		// ajax首先使用的
		if(preg_match('/^eob__(.*)$/', $actionID, $matches)){
			$aaa = new Eob;
			$aaa->{$matches[1]}();
			die;
		}

		// debug
		//echo '123';
		//die;

		// 底下是預設值，如果不符合條件的時候，就使用它
	    throw new CHttpException(404,Yii::t('yii','The system is unable to find the requested action "{action}".',
	        array('{action}'=>$actionID==''?$this->defaultAction:$actionID)));
	}

	// http://codepad.org/UL8k4aYK
	public function actionRegen($len = 6, $ajax = true) {
		//$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$alphabet = "0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $len; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		if($ajax){
			echo implode($pass);
		} else {
			return implode($pass); //turn the array into a string
		}
	}

	// 指定的卡片，導向到tco的該客戶的首頁
	public function actionCurrent($card_number_format)
	{
		$card_number = str_replace('-', '', $card_number_format);
		$_SESSION['card_number_current'] = $card_number;
		if(!isset($_SESSION['card_number_currents'])){
			$_SESSION['card_number_currents'] = array();
		}
		if(!in_array($card_number, $_SESSION['card_number_currents'])){
			$_SESSION['card_number_currents'][] = $card_number;
		} else {
			// 如果有存在，就把順序拉到前面
			$tmp01 = array();
			$tmp01[] = $card_number;
			foreach($_SESSION['card_number_currents'] as $kkk => $vvv){
				if($vvv == $card_number) continue;
				$tmp01[] = $vvv;
			}
			$_SESSION['card_number_currents'] = $tmp01;
		}
		$this->redirect($this->createUrl('home/update'));
	}

	// TCO各功能專用的匯出pdf的功能
	/*
	$(".t_add").after("<div class=\"t_export fle\">PDF</div>");
	$(".t_add").remove();

	$(".t_export").click(function(){
		var htmldata = $("#tablelist").parent().html();

		alert("請等待PDF的產生與轉址");

		$.ajax({
			type: "POST",
			data: {
				"ggg": htmldata
			},
			url: "'.$this->createUrl($this->data['router_class'].'/genpdf').'",
			success: function(response){
				//alert(response);
				if(response != ""){
					eval(response);
				}
				//var obj = jQuery.parseJSON(response);
				//alert(obj);
				//alert(obj.name);
			}
		}); // ajax

		return false;
	});
	 */
	public function actionGenpdf($ggg='')
	{
		if(!empty($_POST) and isset($_POST['ggg'])){
			$ggg = $_POST['ggg'];

			$gggs = explode("\n", $ggg);
			if(count($gggs) > 0){
				foreach($gggs as $k => $v){
					if(preg_match('/tablelist/', $v)){
						//if(isset($_POST['is_report']) and $_POST['is_report'] == '1'){
						//	$gggs[$k] = '<table id="tablelist" class="table1 sortable table dataTable table-advance" aria-describedby="sample_1_info">';
						//	break;
						//}
						$gggs[$k] = str_replace('tablelist', 'one-column-emphasis', $v);
						break;
					}
				}
				foreach($gggs as $k => $v){
					if(preg_match('/^(.*)<a href="(.*)">(.*)$/', $v, $matches)){
						$gggs[$k] = $matches[1].'<a hrefg="javascript:;">'.$matches[3];
					}
				}
			}
			$ggg = implode("\n", $gggs);

			$themea = G::get_theme_compiler($this->data['theme_name']);
			$themeb = G::get_theme_compiler($this->data['theme_name'], true);

			if(isset($_POST['is_report']) and $_POST['is_report'] == '1'){
				$main_content = '//pdf/sample01_report';
			} else {
				$main_content = '//pdf/sample01';
			}

			//$this->main_content_path($main_content, $this->data);
			$this->data['ggg'] = $ggg;
			$this->layout = 'pdf';
			$path = _BASEPATH.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.$this->data['admin_id'].DIRECTORY_SEPARATOR;
			if(!file_exists($path)){
				mkdir($path, 0777, true);
			}

			/*
			 * 先匯出html，然後在叫pdf匯出程式去讀那支html
			 */

			file_put_contents($path.$this->data['router_class'].'.html', $this->render($main_content, $this->data, true));

			//$pdfrun = '#!/bin/bash'."\n";
			//$pdfrun .= '/home/gisanfu/下載/wkhtmltopdf-i386 http://hg.test.eob.gisanfu.idv.tw/eob/_butterfly/pdf/'.$this->data['admin_id'].'/'.$this->data['router_class'].'.html ';
			//$pdfrun .= $path.$this->data['router_class'].'.pdf';
			//`$pdfrun`;
			//echo 'window.location.href="'.'http://hg.test.eob.gisanfu.idv.tw/eob/_butterfly/pdf/'.$this->data['admin_id'].'/'.$this->data['router_class'].'.pdf'.'";';
			//die;

			echo 'window.location.href="'.PDF_DOMAIN.'/pdf.php?return=1&pdf='.base64url::encode(BACKEND_DOMAIN.vir_path_c.'pdf/'.$this->data['admin_id'].'/'.$this->data['router_class'].'.html').'";';
			die;
		}
		die;
	}
	public function actionGenhtml($ggg='')
	{
		if(!empty($_POST) and isset($_POST['ggg'])){
			$ggg = $_POST['ggg'];

			$gggs = explode("\n", $ggg);
			if(count($gggs) > 0){
				foreach($gggs as $k => $v){
					if(preg_match('/tablelist/', $v)){
						$gggs[$k] = str_replace('tablelist', 'newspaper-a', $v);
						break;
					}
				}
			}
			$ggg = implode("\n", $gggs);

			$themea = G::get_theme_compiler($this->data['theme_name']);
			$themeb = G::get_theme_compiler($this->data['theme_name'], true);
			$main_content = '//pdf/sample01';
			//$main_content = $this->main_content_path($main_content, $this->data);
			$this->data['ggg'] = $ggg;
			$this->layout = 'pdf';
			$path = _BASEPATH.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.$this->data['admin_id'].DIRECTORY_SEPARATOR;
			if(!file_exists($path)){
				mkdir($path, 0777, true);
			}
			file_put_contents($path.$this->data['router_class'].'.html', $this->render($main_content, $this->data, true));

			echo 'window.location.href="'.'http://hg.test.eob.gisanfu.idv.tw/eob/_butterfly/pdf/'.$this->data['admin_id'].'/'.$this->data['router_class'].'.html'.'";';
			die;
		}
		die;
	}

	//    /*
	//     * 每一個公司會員和個人會員都會先經過這裡，檢查編號，以及檢查是否有購買
	//     * @check_payment 代表只是做會員簡單的檢查，不會看有沒有付錢之類的
	//     */
	//    public function member_check($check_payment = true)
	//    {
	//    	if(!isset($_SESSION['authw_admin_id'])){
	//    		throw new CHttpException(404,'Member not set.');
	//    	}

	//    	// 管理者不需要經過這個檢查
	//    	if($check_payment and !preg_match('/1/', $_SESSION['auth_admin_type']) and 0){
	//    		$row = $this->db->createCommand()->from('member')->where('id='.$_SESSION['authw_admin_id'])->queryRow();
	//    		if($row and isset($row['id'])){
	//    			$check_status = true;
	//    			if(preg_match('/^company(sell|buy|career|advert)/', $this->data['router_class'], $matches)){
	//    				$service = 'company_'.$matches[1].'_plan_';

	//    				// 先檢查日期欄位是否正常
	//    				if($row[$service.'start_date'] == '0000-00-00'){
	//    					$check_status = false;
	//    				}
	//    				if($row[$service.'end_date'] == '0000-00-00'){
	//    					$check_status = false;
	//    				}
	//    				// 是否在時間範圍內
	//    				if(strtotime($row[$service.'end_date']) >= strtotime(date('Y-m-d'))){
	//    					// do nothing
	//    				} else {
	//    					$check_status = false;
	//    				}
	//    				// 帳號是否正確的啟用，而不是在等待Email確認之類的
	//    				if($row['is_enable'] == '1'){
	//    					// do nothing
	//    				} else {
	//    					$check_status = false;
	//    				}
	//    			} else {
	//    				throw new CHttpException(404,'URL is not support check!');
	//    			}
	//    			if(!$check_status){
	//    				$this->redirect($this->createUrl('memberpayment/index'));
	//    				die;
	//    			}
	//    		} else {
	//    			throw new CHttpException(404,'Member id is not exists!');
	//    		}
	//    	}
	//    }

	function init()
	{
		parent::init();

		// 參考阿財
	    //$this->getAssetsUrl();

		// new theme debug
		// $lf = new Load_other_file;
		// if(isset(Yii::app()->SESSION['auth_admin_id']) and Yii::app()->SESSION['auth_admin_id'] == '1' and $lf->load('ip', '', '1') == '127.0.0.1'){
		// 	Yii::app()->theme = 'admin_yiiv_4';
		// }

		// 
		$this->data['theme_name'] = Yii::app()->theme->name;
		//define('theme_name', $this->data['theme_name']);

		// 樣版的多國語系種類(Yiiv在使用的，smarty沒有用到)
		// 我把切換樣版，和它的多國語系分開，因為切換樣版加多國語系的機率，比切換樣版的機率還要低
		$this->data['theme_lang'] = 'admin_lang_1';

		// G::a在使用的
		//if(!defined('theme_lang')){
			define('theme_lang', $this->data['theme_lang']);
		//}

		// http://www.yiiframework.com/doc/guide/1.1/en/topics.theming
		$this->layout = 'system.themes.'.$this->data['theme_name'].'.views.layouts.main';

		// 為了要放多個後台版型
		$template_path = 'template/'.$this->data['theme_name'];
		$this->data['template_path'] = '/'.$template_path;
		if(!defined('template_path')){
			define('template_path', $template_path);
		}

		$assetsUrl = BACKEND_ASSETSURL_DOMAIN.'/'.str_replace(str_replace('_i/framework/backend/assetsg','',Yii::getPathOfAlias('system.backend.assetsg')), '', Yii::getPathOfAlias('system.backend.assetsg'));
		//echo $_SERVER['SERVERNAME'];
		//$assetsUrl = BACKEND_ASSETSURL_DOMAIN.'/'.str_replace(str_replace('_i/framework_v1116/backend/assetsg','',Yii::getPathOfAlias('system.backend.assetsg')), '', Yii::getPathOfAlias('system.backend.assetsg'));
		$this->assetsUrl = $assetsUrl;
		//echo $this->assetsUrl;
		//die;

		// yii 1.1.16
		// 接下來換這個問題
		// There is no CClientScript package: jquery-validate 
		// _i/framework_1116/web/CClientScript.php(598)
		//$assetsUrl = BACKEND_ASSETSURL_DOMAIN.'/'.str_replace(str_replace('_i/framework_1116/backend/assetsg','',Yii::getPathOfAlias('system.backend.assetsg')), '', Yii::getPathOfAlias('system.backend.assetsg'));

		// 範例 http://www.yiiframework.com/forum/index.php/topic/25123-position-of-css-links-registered-in-a-package/
		// http://danaluther.blogspot.tw/2012/03/using-packages-with-clientscript.html
        $this->data['clientscript_packages'] = array(
			//'mytheme' => array(
			//	'basePath'=>'application.themes.mytheme',
			//	'baseUrl'=>'/themes/mytheme/',
			//	'js'=>array('js/layout.js', 'js/ga.js'),
			//	'css'=>array('css/form.css', 'css/main.css'),
			//	'depends'=>array('jquery'),
			//),
			'jquery-ui'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				//'js'=>array('jui/js/jquery-ui.min.js'),
				// 'js'=>array('js/jquery-ui-1.8.8.custom.min.js'),
				'js'=>array('js/jquery-ui-1.11.4.min.js'),//2021-09-07 1.8.8升級1.11.4 by lota
				// 'css'=>array('css/smoothness/jquery-ui-1.8.8.custom.css'),
				'css'=>array('css/smoothness/jquery-ui-1.11.3.css'),//2021-09-07 1.8.8升級1.11.3 by lota
				'depends'=>array('jquery'),
			),
			'jquery.ui'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				//'js'=>array('jui/js/jquery-ui.min.js'),
				// 'js'=>array('js/jquery-ui-1.8.8.custom.min.js'),
				'js'=>array('js/jquery-ui-1.11.4.min.js'),//2021-09-07 1.8.8升級1.11.4 by lota
				// 'css'=>array('css/smoothness/jquery-ui-1.8.8.custom.css'),
				'css'=>array('css/smoothness/jquery-ui-1.11.3.css'),//2021-09-07 1.8.8升級1.11.3 by lota
				'depends'=>array('jquery'),
			),
			'jquery-validate'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/jquery.validate.min.js'),
				'depends'=>array('jquery'),
			),
			'jquery.validate'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/jquery.validate.min.js'),
				'depends'=>array('jquery'),
			),
			'jquery.uniform'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				//'js'=>array('js/jquery.uniform.min.js'),

				// http://snippi.com/s/j22gg3a
				'js'=>array('js/jquery.uniform.js'),
				'css'=>array('css/uniform.default.css'),
				'depends'=>array('jquery'),
			),
			'jquery.wysiwyg'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/jquery.wysiwyg.js'),
				'depends'=>array('jquery'),
			),
			'jquery.superfish'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/superfish.js'),
				'css'=>array('css/superfish.css'),
				'depends'=>array('jquery'),
			),
			//'jquery.flot'=>array(
			//	//'baseUrl'=>$this->assetsUrl,
			//	'baseUrl' => $assetsUrl,
			//	'js'=>array('js/jquery.flot.min.js'),
			//	'depends'=>array('jquery'),
			//),
			'jquery.facebox'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/facebox.js'),
				'css'=>array('css/facebox.css'),
				'depends'=>array('jquery'),
			),
			'facebox.start'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/facebox_start.js'),
				'depends'=>array('jquery.facebox'),
			),
			// 通常是image token在使用的
			'jquery.random'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/jquery.random.js'),
				'depends'=>array('jquery'),
			),
			// 裁圖
			'jcorp'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(YII_DEBUG ? 'js/jcorp/jquery.Jcrop.js' : 'js/jcorp/jquery.Jcrop.min.js'),
				'css'=>array(YII_DEBUG ? 'css/jcorp/jquery.Jcrop.css' : 'js/jcorp/jquery.Jcrop.min.css'),
				'depends'=>array('jquery'),
			),
			'jquery.widget'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/jquery.ui.widget.js'),
				'depends'=>array('jquery','jquery.ui'),
			),
			'jquery.datepicker'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/jquery.ui.datepicker.js'),
				'depends'=>array('jquery.widget'),
			),
			'jquery.colorpicker'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'template/admin_yiiv_5/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
				),
				'css'=>array(
					'template/admin_yiiv_5/plugins/bootstrap-colorpicker/css/colorpicker.css',
				),
				'depends'=>array('jquery'),
			),
			'jquery.colorpicker.bootstrap'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/jquery.colorPicker.js',
				),
				'css'=>array('css/colorPicker.css'),
				'depends'=>array('jquery'),
			),
			'fileuploader'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/fileuploader.js', 'js/jquery.random.js'),
				'css'=>array('css/fileuploader.css'),
				'depends'=>array('jquery'),
			),
			'fileuploader.single'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/fileuploader.custom.singleupload.js',),
				'depends'=>array('jquery', 'fileuploader'),
			),
			'fileuploader.multi'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/fileuploader.custom.multiupload.js',),
				'depends'=>array('jquery', 'fileuploader', 'sortable'),
			),
			'swfuploader'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'js'=>array('swfupload/swfupload.js', 'swfupload/plugins/swfupload.queue.js'),
				'css'=>array('swfupload/swfupload.css'),
			),
			'sortable'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/tool-man/core.js',
					'js/tool-man/events.js',
					'js/tool-man/css.js',
					'js/tool-man/coordinates.js',
					'js/tool-man/drag.js',
					'js/tool-man/dragsort.js',
					'js/tool-man/cookies.js',
				),
			),
			'jquery.syntaxhighlighter'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/jQuery-SyntaxHighlighter/scripts/jquery.syntaxhighlighter.min.js'),
				'css'=>array(
					array('js/jQuery-SyntaxHighlighter/styles/style.css',array('media' => 'screen')),
				),
			),
			'ckeditor'=>array(
				'baseUrl' => Yii::app()->baseUrl,
				'js'=>array('ckeditor/ckeditor.js', 'ckfinder/ckfinder.js'),
			),
			// 2015/03/11 小李說要的，我測式寫寫看
			'ckeditorchild'=>array(
				//'baseUrl' => test_phy_file,
				//'baseUrl' => Yii::app()->baseUrl,
				'baseUrl' => '/',
				'js'=>array('../ckeditor/ckeditor.js', '../ckfinder/ckfinder.js'),
				//'js'=>array('/ckeditor/ckeditor.js', '/ckfinder/ckfinder.js'),
			),
			'codemiror2'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array('js/codemirror2/lib/codemirror.js', 'js/codemirror2/mode/css/css.js'),
				'css'=>array('js/codemirror2/lib/codemirror.css', ),
			),
			'jquery.autocomplete'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/autocomplete/jquery.bgiframe.min.js',
					'js/autocomplete/jquery.ajaxQueue.js',
					'js/autocomplete/thickbox-compressed.js',
					'js/autocomplete/jquery.autocomplete.js',
				),
				'css'=>array('css/jquery.autocomplete.css', 'css/thickbox.css'),
				'depends'=>array('jquery'),
			),
			'jquery.devbridge.autocomplete'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/jquery.devbridge.autocomplete.js',
				),
				'css'=>array('css/jquery.devbridge.autocomplete.css'),
				'depends'=>array('jquery'),
			),
			'jquery.autoautosize'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/jquery.autosize.js',
				),
				'depends'=>array('jquery'),
			),
			'jquery.digits'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/jquery.digits.js',
				),
				'depends'=>array('jquery'),
			),
			// http://digitalbush.com/projects/masked-input-plugin/
			'jquery.maskedinput'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/jquery.maskedinput.js',
				),
				'depends'=>array('jquery'),
			),
			'jquery.twzipcode'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					//'js/jquery.twzipcode-1.5.2.min.js',
					'js/jquery.twzipcode.min.js', // 版本為1.7.11 因為購物站是用這個，要記到
				),
				'depends'=>array('jquery'),
			),
			'jquery.cityselect'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/jquery.cityselect.js',
				),
				'depends'=>array('jquery'),
			),
			'jquery.multi-select'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'template/admin_yiiv_5/plugins/jquery-multi-select/js/jquery.multi-select.js',
					'template/admin_yiiv_5/plugins/jquery-multi-select/js/jquery.quicksearch.js',
				),
				'css'=>array(
					'template/admin_yiiv_5/plugins/jquery-multi-select/css/multi-select.css',
				),
				'depends'=>array('jquery'),
			),
			//	這個目前還沒有用到
			'jquery.imageresizecropcanvas'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/image_resize_crop_canvas/js/component.js',
				),
				'depends'=>array('jquery'),
			),
			'jquery.clockface'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'template/admin_yiiv_5/plugins/clockface/js/clockface.js',
				),
				'css'=>array(
					'template/admin_yiiv_5/plugins/clockface/css/clockface.css',
				),
				'depends'=>array('jquery'),
			),
			'jquery.fullcalendar'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'js/fullcalendar-2.4.0/lib/moment.min.js',
					'js/fullcalendar-2.4.0/fullcalendar.min.js',
				),
				'css'=>array(
					'js/fullcalendar-2.4.0/fullcalendar.css',
					//'js/fullcalendar-2.4.0/fullcalendar.print.css',
					'js/fullcalendar-2.4.0/bootstrap-fullcalendar.css',
				),
				'depends'=>array('jquery'),
			),
			'jquery.treeselect'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'treeview-style-multi-select-plugin-for-bootstrap-treeselect/js/jquery.bootstrap.treeselect.js',
				),
				'css'=>array(
					'treeview-style-multi-select-plugin-for-bootstrap-treeselect/css/jquery.bootstrap.treeselect.css',
				),
				'depends'=>array('jquery'),
			),
			'jquery.spinner'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'template/admin_yiiv_5/plugins/fuelux/js/spinner.js',
				),
				'depends'=>array('jquery'),
			),
			'jquery.flot'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'template/admin_yiiv_5/plugins/flot/jquery.flot.js',
					'template/admin_yiiv_5/plugins/flot/jquery.flot.time.js',
					'template/admin_yiiv_5/plugins/flot/jquery.flot.resize.js',
					'template/admin_yiiv_5/plugins/flot/jquery.flot.pie.js',
					'template/admin_yiiv_5/plugins/flot/jquery.flot.stack.js',
					'template/admin_yiiv_5/plugins/flot/jquery.flot.crosshair.js',
				),
				'depends'=>array('jquery'),
			),
			'jquery.switch'=>array(
				//'baseUrl'=>$this->assetsUrl,
				'baseUrl' => $assetsUrl,
				'js'=>array(
					'template/admin_yiiv_5/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js',
				),
				'css'=>array(
					'template/admin_yiiv_5/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css',
				),
				'depends'=>array('jquery'),
			),
//<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
//<script src="assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
//< ? php include _BASEPATH.'/../'.LAYOUTV3_PATH.'view/third_party/_js.php'? >
        );
        Yii::app()->clientScript->packages = $this->data['clientscript_packages'];

	}

	protected function beforeAction($action)
	{

		$class = Yii::app()->controller->id;
		$method = Yii::app()->controller->action->id;
		$param = Yii::app()->getRequest()->getQuery('param');

		$this->data['router_class'] = $class;
		$this->data['router_method'] = $method;
		$this->data['router_param'] = $param;

		// 這個是要給sys_log的物件所使用
		Yii::app()->session['sys_log_code'] = $class.'/'.$method;

		// http://b1.cloud.oz.gisanfu.idv.tw 在一般的VH上看到的狀況
		// http://qa.test.oz.gisanfu.idv.tw/cloud 在QA站上看到的狀況
		$this->data['base_url'] = Yii::app()->getBaseUrl(true); // http://rwd_v3.web.buyersline.com.tw/_i

		$this->data['class_url'] = $this->data['base_url'].'/backend.php?r='.$class;
		$this->data['current_url'] = $this->data['class_url'].'/'.$method;

		// Controller的模組化
		//$tmp01 = Yii::getPathOfAlias('application.controllers').'/'.ucfirst($this->data['router_class']).'Controller.php';
		//if(!file_exists($tmp01)){
		//	echo '123';
		//	die;
		//}

		$default_def = $this->default_def();

		// 第二版的Controller產生器功能
		if(isset($this->def) and count($this->def) <= 0){
			$this->def = $default_def;
		}

		// 功能性欄位，沒有定義的話，會自動補齊
		if(isset($this->def) and !isset($this->def['func_field'])){
			$this->def['func_field'] = array(
				'id' => 'id',
				'sort_id' => 'sort_id',
			);
		}

		// 如果沒驗證，就去登入頁，auth controller是例外，是外對窗囗(我指的是登入的部份)
		//if($class != 'auth' or $class != 'authlocal'){
		if(!in_array($class, $this->ignore_class_acl)){
			//echo Yii::app()->session['auth_admin_id'];die;
			if(!isset(Yii::app()->session['auth_admin_id']) or Yii::app()->session['auth_admin_id'] == ''){
				$this->redirect($this->createUrl('auth/login', array('current_base64_url'=>base64url::encode($_SERVER['REQUEST_URI']))));
			}
		}

		// get db object
		$this->db = Yii::app()->db;
		$this->cidb = Yii::app()->params['cidb'];
		$this->cidbeip = Yii::app()->params['cidbeip'];
		$this->pdo = Yii::app()->params['pdo'];

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
			or !file_exists(tmp_path.DIRECTORY_SEPARATOR.'language.php')
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

		// 測試多國語系的功能(測試繼承、功能正常性等)
		//echo G::te(null, '[[admin_lang_2]] Label Index', array(), '片語索引4');
		//echo G::te(null, 'Label Index', array(), '片語索引4');
		//die;

		$all_session = Yii::app()->session;

		$base64url = new base64url;
		$this->data['current_base64_url'] = $base64url->encode($_SERVER['REQUEST_URI']);

		// 為了Debug Request-URI Too Large 的問題，最後是增加ignore_acl_class = site
		//$aaa = '';
		//if(!file_exists('/home/gisanfu/aaa.txt')){
		//	file_put_contents('/home/gisanfu/aaa.txt','');
		//} else {
		//	$aaa = file_get_contents('/home/gisanfu/aaa.txt');
		//}
		//file_put_contents('/home/gisanfu/aaa.txt',$aaa."\n".$class."\n");

		// 驗證使用者有沒有權限的開始準備工作
		$acl = new Admin_acl();
		$acl->start();

		if($method == 'index'){
			// 本來我是寫read，後來改掉，先這樣子看看
			$permission = 'index';
		} else {
			$permission = $method;
		}
		//$this->data['permission'] = $permission; // 這個是要給後續的程式使用acl用的

		// 將驗證類的session值，傳給smarty
		foreach($all_session as $k => $v){
			if(preg_match('/^auth_(.*)$/', $k, $matches)){
				$this->data[$matches[1]] = $v;
			}
		}

		// 主選單的項目，目前是寫死的，想轉成資料庫存放
		//$this->data['menus'] = array(
		//	array('label' => '網站設定', 'url' => $this->createUrl('site/index'), 'items' => array(
		//	)),
		//	array('label' => '管理者權限設定', 'url' => $this->createUrl('adminuser/index'), 'items' => array(
		//	)),
		//	//array('label' => '廣告管理', 'url' => $this->createUrl('basicAdv/index')),
		//	//array('label' => '最新消息', 'url' => $this->createUrl('basicNews/index')),
		//	//array('label' => '型錄分類', 'url' => $this->createUrl('catalogCategory/index')),
		//	//array('label' => '型錄商品', 'url' => $this->createUrl('catalogProduct/index')),
		//	//array('label' => 'BLOG分類', 'url' => $this->createUrl('blogCategory/index')),
		//	//array('label' => 'BLOG', 'url' => $this->createUrl('blogPost/index')),
		//	//array('label' => '聯絡我們', 'url' => $this->createUrl('basicContact/index')),
		//	//array('label' => '電子報', 'url' => $this->createUrl('basicNewsletter/index')),
		//	//array('label' => '其他設定', 'url' => $this->createUrl('default/other')),

		//	// 兩層式下拉的參考設定
		//	//array('label' => '佈局寬度', 'url' => '#', 'items' => array(
		//	//    array('label' => '固定', 'url' => '#', 'linkOptions' => array('rel'=>'fixed')),
		//	//    array('label' => '流動', 'url' => '#', 'linkOptions' => array('rel'=>'fluid')),
		//	//)),
		//);

		//if($class != 'auth' or $class != 'authlocal'){
		if(!in_array($class, $this->ignore_class_acl)){
			if(!$acl->hasAcl($this->data['admin_id'], $class, $permission, $param)){
				//$error = array(
				//	'code' => 'You do not have permissions',
				//	'message' => 'You do not have permissions',
				//);
				//$msg = $this->_getLabel('You do not have permissions');
				//show_error($msg);
				//$this->render('//error', $error);
				//throw new CHttpException(403, $msg);

				$msg = G::t(null, 'You do not have permissions', array(), '你沒有權限使用這個功能, <a href="'.$this->createUrl('auth/logout').'">登出</a>');
				sys_log::set($msg.': '.$class.'/'.$method);
				//G::m($msg, 'Error', $this->data, 403);
				$this->widget('system.widgets.Gw_error', array('message'=>$msg, 'heading'=>'Error', 'errorcode'=>403));
				die;
			}
		}

		//$this->data['router_class'] = $class;
		//$this->data['router_method'] = $method;
		//$this->data['router_param'] = $param;

		// 預設載入的tpl main content目標
		$this->data['main_content'] = $class.'/'.$method;
		//echo $this->data['main_content'];

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
		if($interface_ml_key == ''){
			$interface_ml_key = Yii::app()->language;
		} else {
			Yii::app()->language = $interface_ml_key;
		}

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

		//2019-9-26 增加管理者限定操作語系 by lota
		if(isset(Yii::app()->session['check_data_ml_key']) && count(Yii::app()->session['check_data_ml_key']) > 0 ){		
			$check_data_ml_key = Yii::app()->session['check_data_ml_key'];
			if(!in_array($ml_key,$check_data_ml_key)){
				$ml_key = current($check_data_ml_key);
			}
		}


		// 如果是空白，就取用前台的預設語系
		if($ml_key == ''){
			if(file_exists('web/config/main.php')){	
				$web_configs = include('web/config/main.php');
				if(isset($web_configs['language']) and $web_configs['language'] != ''){
					$ml_key = $web_configs['language'];
				}
				//var_dump($web_configs['language']);
			}
		}

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
		if(domain_ml_key != ''){
			$interface_ml_key = domain_ml_key;
		}

		/*
		 * 語系己經決定好了，所以分配給介面語系和資料語系
		 */
		
		// 因為介面語系是後來寫的，怕把資料語系需要改的地方很多，所以介面語系改名子比較快
		Yii::app()->session['auth_admin_interface_ml_key'] = $interface_ml_key;
		// 這行可能是bug
		//Yii::app()->session['interface_ml_key'] = $interface_ml_key;
		$this->data['interface_ml_key'] = $interface_ml_key;

		// 切換要維護的語系資料，是不會影響到介面語系的(那當然)
		//Yii::app()->session['ml_key'] = $ml_key;
		Yii::app()->session['auth_admin_data_ml_key'] = $ml_key;
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
		//$rows = $this->cidb->where('is_enable', 1)->like('interface', ',1,', 'both')->get('ml')->result_array();
		//$rows = $this->db->createCommand()->from('ml')->where('is_enable = 1')->where(array('like', 'interface', '%,1,%'))->order('sort_id')->queryAll();
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "ml"',array(':aaa_dbname' => aaa_dbname))->queryAll();
		if(count($lll) > 0){
			$rows = $this->db->createCommand('select * from ml where is_enable=1 and interface like "%,1,%" order by sort_id')->queryAll();
			$mls = array();
			$mls_tmp = array();
			foreach($rows as $row){
				//2019-9-26 增加管理者限定操作語系 by lota
				if(isset(Yii::app()->session['check_data_ml_key']) && count(Yii::app()->session['check_data_ml_key']) > 0 ){	
					$check_data_ml_key = Yii::app()->session['check_data_ml_key'];
					if(!in_array($row['key'],$check_data_ml_key)){
						continue;
					}
				}
				$tmp = $this->_getValueLabel($row['name'], $this->data['ml_key']);
				$mls[$row['key']] = $tmp;
				$mls_tmp[] = $row['key'];
			}
		}else{
			$mls = array();
			$mls_tmp = array();
		}
		$this->data['mls'] = $mls;
		$this->data['mls_tmp'] = $mls_tmp;

		// 取得前台用的語系列表
		//$rows = $this->cidb->where('is_enable', 1)->like('interface', ',2,', 'both')->get('ml')->result_array();
		$lll = $this->db->createCommand()->select('TABLE_NAME')->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA = :aaa_dbname and TABLE_NAME = "ml"',array(':aaa_dbname' => aaa_dbname))->queryAll();

		if(count($lll) > 0){	
			$rows = $this->db->createCommand('select * from ml where is_enable=1 and interface like "%,2,%" order by sort_id')->queryAll();

			// yii不能這樣用，如果換成where加上where(param like)也不行
			//$rows = $this->db->createCommand()->from('ml')->where('is_enable = 1 and LIKE interface "%,2,%"')->order('sort_id')->queryAll();
			$mls_frontend = array();
			$mls_frontend_tmp = array();
			foreach($rows as $row){
				$mls_frontend[$row['key']] = $row['name'];
				$mls_frontend_tmp[] = $row['key'];
			}
		}else{
			$mls_frontend = array();
			$mls_frontend_tmp = array();
		}
		$this->data['mls_frontend'] = $mls_frontend;
		$this->data['mls_frontend_tmp'] = $mls_frontend_tmp;
		//var_dump($mls_frontend);

		// 新的搜尋方式
        $search = Yii::app()->session['search'];
		if(isset($search[0][0]) and $search[0][0] == $class){
			if(isset($search[0][1]) and $search[0][1] != ''){
				$this->data['search_keyword'] = $search[0][1];
			}
		}

		// 也是新的搜尋方式，用get的方式帶入，而且優先權更高
		if(isset($_GET['_searchkeyword']) and $_GET['_searchkeyword'] != ''){
			$this->data['search_keyword'] = $_GET['_searchkeyword'];
		}

		// 設定相對路徑
		Yii::app()->session->add('image_crop_path', customer_public_path.'crop'); // 擺放裁圖前的原圖  
		Yii::app()->session->add('image_thumb_path', customer_public_path.'thumb');
		Yii::app()->session->add('image_thumb_tmp_path', customer_public_path.'thumb_tmp');
		Yii::app()->session->add('image_upload_path', customer_public_path.'upload');
		Yii::app()->session->add('image_upload_tmp_path', customer_public_path.'file');
		Yii::app()->session->add('image_upload_static_path', customer_public_path.'static');
		Yii::app()->session->add('file_upload_path', customer_public_path.'upload_tmp');
		Yii::app()->session->add('file_upload_tmp_path', customer_public_path.'file_tmp');
		//Yii::app()->session->add('vir_path_c', vir_path_c); // 給kcfinder的config所使用

		// 請注意，如果在httpd.conf裡面使用了VirtualDocumentRoot，那這裡會不一樣
		if(virtualdocumentroot_fix != ''){
			Yii::app()->session->add('vir_path_c', '/'.virtualdocumentroot_fix.'/'.vir_path_c); // 給kcfinder的config所使用

            if(preg_match('/^Apache\/2\.4/', apache_get_version())){
                $tmps = explode('/', $_SERVER['DOCUMENT_ROOT']);
                unset($tmps[count($tmps)-1]);
                unset($tmps[0]);
                $tmp = '/'.implode('/',$tmps);
                Yii::app()->session->add('fix_document_root', $tmp); // 給kcfinder的config所使用
            }
		} else {
			Yii::app()->session->add('vir_path_c', vir_path_c); // 給kcfinder的config所使用
		}
		Yii::app()->session->add('customer_public_path', customer_public_path); // 給kcfinder的config所使用

		Yii::app()->session->add('tmp_path', tmp_path); // 給ckfinder的config所使用 2015-08-28 lota所發現

		$this->data['public_path'] = customer_public_path;

		$this->data['image_crop_path'] = customer_public_path.'crop';
		$this->data['image_thumb_path'] = customer_public_path.'thumb';
		$this->data['image_thumb_tmp_path'] = customer_public_path.'thumb_tmp';
		$this->data['image_upload_path'] = customer_public_path.'upload';
		$this->data['image_upload_tmp_path'] = customer_public_path.'upload_tmp';
		$this->data['file_upload_path'] = customer_public_path.'file';
		$this->data['file_upload_tmp_path'] = customer_public_path.'file_tmp';
		$this->data['tmp_path'] = customer_public_path.'tmp';

		if(!in_array($class, $this->ignore_class_acl)){
			// 取得選單列表(root)
			$rows = $this->db->createCommand()->from('admin_menu')->where('is_enable = 1 AND pid = 0')->order('sort_id')->queryAll();
			$menus = array();
			foreach($rows as $row){
				$row['name'] = $this->_getValueLabel($row['name'], $this->data['interface_ml_key']);

				if($row['link'] != '#' and $row['link'] != ''){
					if(!$acl->hasAcl($this->data['admin_id'], str_replace('backend.php?', '', $row['link']))){
						continue;
					}
				}

				$menus[] = $row;
			}
			$this->data['menus'] = $menus;
		}

		//if($class != 'auth' or $class != 'authlocal'){
		if(!in_array($class, $this->ignore_class_acl)){
			// 取得次選單
			$submenus = array();
			if(count($menus) > 0){
				foreach($menus as $k => $v){
					//$query = $this->db->where('is_enable', '1')->where('pid', $v['id'])->order_by('sort_id')->get('admin_menu');
					$rows = $this->db->createCommand()->from('admin_menu')->where('is_enable = 1 AND pid = :pid', array(':pid' => $v['id']))->order('sort_id')->queryAll();
					foreach($rows as $row){
						// 先mark起來，我重寫一次
						//$check_status = 0;
						//if($acl->hasAcl($this->data['admin_id'], substr($row['link'], 1), $permission)){
						//	$check_status = 1;
						//}
						//if(preg_match('/-edesc/', $row['link']) and $check_status == 0){
						//	$links = explode('/', $row['link']);
						//	if($acl->hasAcl($this->data['admin_id'], $links[1], $permission)){
						//		$check_status = 1;
						//	}
						//}
						//if($check_status == 0){
						//	continue;
						//}

						if(!$acl->hasAcl($this->data['admin_id'], str_replace('backend.php?', '', $row['link']))){
							continue;
						}

						// 將中文字當做key，做多國語系
						if(!preg_match('/^ml:/', $row['name'])){
							$row['name'] = 'ml:'.$row['name'];
						}

						$row['name'] = $this->_getValueLabel($row['name'], $this->data['interface_ml_key']);
						$submenus[$v['id']][] = $row;
					}
				}

			}
			$this->data['submenus'] = $submenus;
		}

		// 取得目前的選單位置
		$default_menu = ''; // 裡面是存放編號
		$default_sub_menu = '';
		$default_menu_title = '';
		$default_sub_menu_title = '';

		// 新版麵包選單
		if(!in_array($class, $this->ignore_class_acl)){
			$tmp = $this->_get_admin_menu_classes();
			$menu_items = $tmp['data'];
			/*
			 *  ["REQUEST_URI"]=>
			 *    string(24) "/_i/backend.php?r=banner"
			 */
			if(preg_match('/index\.php/', $_SERVER['REQUEST_URI'])){
				$url = str_replace('/_i/index.php?r=', '', $_SERVER['REQUEST_URI']);
			} else {
				$url = str_replace('/_i/backend.php?r=', '', $_SERVER['REQUEST_URI']);
			}
			$tmps = explode('/', $url);
			$tmps = explode('&', $tmps[0]);
			$url = $tmps[0];
			//var_dump($tmps);
			//die;
			$url = 'backend.php?r='.$tmps[0];
			$row = $this->cidb->where('is_enable',1)->where('link',trim($url))->get('admin_menu')->row_array();
			//var_dump($row);
			//die;

			if(isset($row['name'])){
				$focus = $this->_search_admin_menu_tree($tmp['tree'], $tmp['sample'], $row['name'], 'xxxxxxx');

				if(count($focus) > 0){
					// 2018-03-01 後台頂層停用，但是子項啟用，而且在其它地方有建了新的功能，這時就要做這個判斷，讓麵包屑和功能名稱空白，不然會報錯
					if(!isset($focus['ids'][count($focus['ids'])-1])){
						$default_sub_menu_title = '';
					} else {
						$default_sub_menu_title = $tmp['sample'][$focus['ids'][count($focus['ids'])-1]]['class_name'];
					}

					/*
						<a href="#"><?php echo $default_menu_title?></a> 
						<span class="icon-angle-right"></span>
					 */

					$tmp2 = array();
					foreach($focus['ids'] as $k => $v){
						$tmp2[] = '<a href="#">'.$tmp['sample'][$v]['class_name'].'</a>';
					}

					$this->data['admin_menu_breadcrumbs'] = implode('<span class="icon-angle-right"></span>', $tmp2);;

				}
			}
		}

		/*
		 * 舊版選單
		 */

		//if($class != 'auth' or $class != 'authlocal'){
		if(!in_array($class, $this->ignore_class_acl) and !isset($this->data['admin_menu_breadcrumbs'])){
			if($this->data['router_class'] != 'index'){
				//$this->db->select('b.*, a.name as pid_name');
				//if($this->data['module_serial_id'] != ''){
				//	$this->db->where('b.link', '/'.$this->data['router_class'].'_'.$this->data['module_serial_id']);
				//} else {
				//	$this->db->where('b.link', '/'.$this->data['router_class']);
				//}
				//$query = $this->db->join('admin_menu as a', 'b.pid = a.id')->get('admin_menu as b');
				//$row = $query->result_array();

				$c = $this->db->createCommand();
				$c->from('admin_menu b');
				$c->select('b.*, a.name as pid_name');
				$c->where('b.link = :link', array(':link' => 'backend.php?r='.$this->data['router_class'].'/'.$this->data['router_method']));
				$c->leftjoin('admin_menu a', 'b.pid = a.id');
				$row = $c->queryRow();

				if(!empty($row)){
					$default_menu = $row['pid'];
					$default_sub_menu = $row['id'];
					$default_menu_title = $this->_getValueLabel($row['pid_name'], $this->data['interface_ml_key']);
					$default_sub_menu_title = $this->_getValueLabel($row['name'], $this->data['interface_ml_key']);
				} else {
					//$this->db->where('link', '/'.$this->data['router_class']);
					//$query = $this->db->get('admin_menu');
					//$row = $query->result_array();
					$row = $this->db->createCommand()->from('admin_menu')->where('link = :link', array(':link'=>'backend.php?r='.$this->data['router_class'].'/'.$this->data['router_method']))->queryRow();
					//$default_menu = $row[0]['pid'];
					if(isset($row['id'])){
						$default_sub_menu = $row['id'];
					}
					//$default_menu_title = $this->_getValueLabel($row[0]['pid_name'], 'tw');
					if(isset($row['name'])){
						$default_sub_menu_title = $this->_getValueLabel($row['name'], $this->data['interface_ml_key']);
					}
				} // empty row
			}
		}

		//if($class != 'auth' or $class != 'authlocal'){
		if(!in_array($class, $this->ignore_class_acl)  and !isset($this->data['admin_menu_breadcrumbs'])){
			// 為了要解決選單網址含有反向排序或者是其它字眼的時候，default_menu找不到的問題
			if($default_menu == ''){
				$c = $this->db->createCommand();
				$c->from('admin_menu b');
				$c->select('b.*, a.name pid_name');
				$c->where(array('like', 'b.link', 'backend.php?r='.$this->data['router_class'].'&%'));
				$c->leftjoin('admin_menu a', 'b.pid = a.id');
				$row = $c->queryRow();

				if(!empty($row)){
					$default_menu = $row['pid'];
					$default_sub_menu = $row['id'];
					$default_menu_title = $this->_getValueLabel($row['pid_name'], $this->data['interface_ml_key']);
					$default_sub_menu_title = $this->_getValueLabel($row['name'], $this->data['interface_ml_key']);
				}
			}

			// 為了要解決網址只有router_class，而沒有method的狀況
			if($default_menu == ''){
				$c = $this->db->createCommand();
				$c->from('admin_menu b');
				$c->select('b.*, a.name pid_name');
				$c->where(array('like', 'b.link', 'backend.php?r='.$this->data['router_class']));
				$c->leftjoin('admin_menu a', 'b.pid = a.id');
				$row = $c->queryRow();

				if(!empty($row)){
					$default_menu = $row['pid'];
					$default_sub_menu = $row['id'];
					$default_menu_title = $this->_getValueLabel($row['pid_name'], $this->data['interface_ml_key']);
					$default_sub_menu_title = $this->_getValueLabel($row['name'], $this->data['interface_ml_key']);
				}
			}
		}

		// 取得root選單的名稱
		$this->data['default_menu_title'] = $default_menu_title;
		// 取得目前的選單名稱
		$this->data['default_sub_menu_title'] = $default_sub_menu_title;

		// 取得root選單的id，帶到前端
		$this->data['default_menu'] = $default_menu;
		// 取得目前的選單id
		$this->data['default_sub_menu'] = $default_sub_menu;

		// 如果controller有定義名稱，那麵包就顯示它
		// 如果沒有，就顯示所屬的子選單項目的選單名稱
		//if($class != 'auth' or $class != 'authlocal'){
		if(!in_array($class, $this->ignore_class_acl)){
			if(!isset($this->def['title']) or $this->def['title'] == ''){
				$this->data['main_content_title'] = $this->data['default_sub_menu_title'];
			} else {
				$this->data['main_content_title'] = $this->_getValueLabel($this->def['title'], $this->data['interface_ml_key']);
			}
		}

		//$aaa = new Eob;
		//var_dump($aaa->abcde('6220430900000041'));

		// 右側的TCO快速選單
		$this->data['tcofastmenus'] = array();
		if(!in_array($class, $this->ignore_class_acl) and 0){
			$this->data['tcofastmenus'] = array();
			$rows = $this->db->createCommand()->from('html')->where('type="tcofastmenu" and is_enable=1')->order('sort_id')->queryAll();
			if($rows){
				foreach($rows as $k => $v){
					if(!$acl->hasAcl($this->data['admin_id'], str_replace('backend.php?', '', $v['url1']))){
						continue;
					}

					// 將中文字當做key，做多國語系
					if(!preg_match('/^ml:/', $v['topic'])){
						$v['topic'] = 'ml:'.$v['topic'];
					}
					$v['topic'] = $this->_getValueLabel($v['topic'], $this->data['interface_ml_key']);

					$this->data['tcofastmenus'][] = $v;
				}
			}
		}

		// 上方的TCO快速選單
		$this->data['tcotopmenus'] = array();
		if(!in_array($class, $this->ignore_class_acl)){
			$this->data['tcotopmenus'] = array();
			$rows = $this->db->createCommand()->from('html')->where('type="tcotopmenu" and is_enable=1')->order('sort_id')->queryAll();
			if($rows){
				foreach($rows as $k => $v){
					// r=redirectto/index&url=index
					//$tmp = str_replace('backend.php?', '', $v['url1']);
					// 有點問題，但是算了，先註解掉好了
					//if(!$acl->hasAcl($this->data['admin_id'], $tmp)){
					//	//die;
					//	continue;
					//}

					// 將中文字當做key，做多國語系
					if(!preg_match('/^ml:/', $v['topic'])){
						$v['topic'] = 'ml:'.$v['topic'];
					}
					$v['topic'] = $this->_getValueLabel($v['topic'], $this->data['interface_ml_key']);

					$this->data['tcotopmenus'][] = $v;
				}
			}
		}

		// tco搜尋history，從資料庫取出
		// if(!in_array($class, $this->ignore_class_acl)){
		// 	if(isset($this->data['sys_configs']['memberhistory_'.$this->data['admin_id']])){
		// 		$tmp = '$xxx__xxx = '.$this->data['sys_configs']['memberhistory_'.$this->data['admin_id']].';';
		// 		//echo $tmp;
		// 		//die;
		// 		eval($tmp);
		// 		$_SESSION['card_number_currents'] = $xxx__xxx;
		// 	}
		// }

		if(0){
			/*
			 * 想要在這裡寫一個處理Empty_orm的hack
			 */
			//$tmp = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/share/').'Empty_source_orm.php');
			$tmp = file_get_contents(Yii::getPathOfAlias('system').ds('/').target_app_name.ds('/controllers/share/').'Empty_source_orm.php');
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
		}

		// 使用新款Empty的另一種方式
		//eval($this->data['empty_orm_eval']);
		//$c = new $name('insert', $this->data['def']['empty_orm_data']);

		/*
		 * 支援加密的Empty_orm的Hack
		 *
		 * 使用方式：
		 * eval($this->data['empty_orm_v2_eval']);
		 * $c = new $name('insert', $this->data['def']['empty_orm_data']);
		 */
		$this->data['empty_orm'] = '?'.'>'.file_get_contents(Yii::getPathOfAlias('system').ds('/').target_app_name.ds('/models/').'Empty_orm.php');
		$this->data['empty_orm_count'] = 0;
		$this->data['empty_orm_eval']  = ''; 
		$this->data['empty_orm_eval'] .= '$this->data[\'empty_orm_count\']++;'."\n";
		$this->data['empty_orm_eval'] .= '$eval_content = $this->data[\'empty_orm\'];'."\n";
		$this->data['empty_orm_eval'] .= 'eval(str_replace(\'class Empty_orm extends CActiveRecord\',\'class Empty_orm\'.$this->data[\'empty_orm_count\'].\' extends CActiveRecord\',$eval_content));'."\n";
		$this->data['empty_orm_eval'] .= '$name = \'Empty_orm\'.$this->data[\'empty_orm_count\'];'."\n";

		// 第二版的Controller產生功能
		//if(!isset($this->def) or count($this->def) <= 0){
		//	$this->def = $this->default_def();
		//}

		/*
		 * 後台產生器
		 */
		include Yii::getPathOfAlias('system.backend.components').'/sys_func_v2.php';

		// 雖然大部份的東西共用，不過當然一定會有不共用的東西
		if(file_exists(Yii::getPathOfAlias('application.controllers').'/core.php')){
			include(Yii::getPathOfAlias('application.controllers').'/core.php');
		}

		// 營建網會員的section各個的作用
		//$this->data['member_section_map'] = array(
		//	'login' => 0,
		//	'company' => 1,
		//	'personal_general' => 2,
		//	'personal_educational' => 3,
		//	'personal_job' => 4,
		//	'personal_experience' => 5,
		//	'personal_other' => 6,
		//);

		/*
		 * 寄信相關設定
		 */

		//$tmp_email = array(
		//	'auth' => 'login',
		//	'ssl' => 'ssl',
		//	'port' => aaa_smtp_port,
		//	'username' => aaa_smtp_account,
		//	'password' => aaa_smtp_password,
		//	'_server' => aaa_smtp_server,
		//);

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
		}

		if(isset($sys_configs['smtp_port']) and $sys_configs['smtp_port'] != ''){
			// do nothing
		} else {
			$tmp_email['port'] = '25'; // 就算不填，zend mail預設值也是25
		}

		$this->data['email_config'] = $tmp_email;

		return parent::beforeAction($action);
		//return true;
	} // beforeAction 結束

	protected function email_send_to($to, $subject, $body, $body_html)
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
		//$mail->addTo('gisanfu@yahoo.com.tw');
		$mail->setSubject($subject);
		$mail->setBodyText($body);
		$mail->setBodyHtml($body_html);

		$mail->send();
	}

	protected function email_send_to_by_sendmail($from = array()/*2層*/, $tos = array()/*3層*/, $subject, $body, $body_html,$cc_mail = NULL)
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
				/*
				$mail = new Zend_Mail('utf-8');
				$mail->setFrom($from['email'],$from['name']);
				$mail->addTo($cc_mail);
				$mail->setSubject($subject);
				$mail->setBodyText($body);
				$mail->setBodyHtml($body_html);
				*/
				$mail = new PHPMailer();
				//$mail->SMTPDebug = 2;
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
				$mail->AddAddress($cc_mail);

				// 2018-11-05
				// if(preg_match('/\,/', $cc_mail)){
				// 	$ccs = explode(',', $cc_mail);
				// 	foreach($ccs as $k => $v){
				// 		// $mail->AddCC($v);
				// 		if($k == 0){
				// 			$mail->AddAddress($v);
				// 		} else {
				// 			$mail->AddCC($v);
				// 		}
				// 	}
				// } else {
				// 	$mail->AddAddress($cc_mail);
				// }

				$mail->Subject = $subject;
				$mail->Body = $body_html;

				$return['status2'] = array(
					'email' => $cc_mail,
					'status' => $mail->send(),
				);
			}
		}

		return $return;
	}

	//protected function email_send_to_by_sendmail($from = array()/*2層*/, $tos = array()/*3層*/, $subject, $body, $body_html,$cc_mail = NULL)
	//{
	//	if(count($from) > 0 and isset($from['email']) and $from['email'] != ''
	//		and count($tos) > 0 and isset($tos[0]) and isset($tos[0]['email']) and $tos[0]['email'] != ''
	//	){
	//		/*
	//		 * 寄信開始
	//		 */
	//		require_once('Zend/Loader/Autoloader.php');
	//		$autoloader = Zend_Loader_Autoloader::getInstance();
//
	//		foreach($tos as $k => $v){
	//			$to = $v['email'];
//
	//			$mail = new Zend_Mail('utf-8');
	//			$mail->setFrom($from['email'],$from['name']);
	//			$mail->addTo($to);
	//			//$mail->addTo('gisanfu@yahoo.com.tw');
	//			$mail->setSubject($subject);
	//			$mail->setBodyText($body);
	//			$mail->setBodyHtml($body_html);
//
	//			$mail->send();
	//		}
//
	//		if($cc_mail){//vencen 2017.05.23 多了一個CC-MAIL
	//			
	//			$mail = new Zend_Mail('utf-8');
	//			$mail->setFrom($from['email'],$from['name']);
	//			$mail->addTo($cc_mail);
	//			$mail->setSubject($subject);
	//			$mail->setBodyText($body);
	//			$mail->setBodyHtml($body_html);
	//			$mail->send();
	//		}
	//	}
	//}

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
				//$mail->addTo('gisanfu@yahoo.com.tw');
				$mail->setSubject($subject);
				$mail->setBodyText($body);
				$mail->setBodyHtml($body_html);

				$mail->send();
			}

			if($cc_mail){ // vencen 2017.05.23 多了一個CC-MAIL
				
				$mail = new Zend_Mail('utf-8');
				$mail->setFrom($from['email'],$from['name']);
				$mail->addTo($cc_mail);

				// 2018-11-05
				// if(preg_match('/\,/', $cc_mail)){
				// 	$ccs = explode(',', $cc_mail);
				// 	foreach($ccs as $k => $v){
				// 		$mail->addTo($v);
				// 	}
				// } else {
				// 	$mail->addTo($cc_mail);
				// }
				$mail->setSubject($subject);
				$mail->setBodyText($body);
				$mail->setBodyHtml($body_html);
				$mail->send();
			}


		}
	}

	public function actionFuncv2exportdef()
	{
		
		$file01 = _BASEPATH.ds('/').target_app_name.ds('/controllers/').ucfirst($this->data['router_class']).'Controller.php';

		if(!file_exists($file01)){
			$end_string = '';
			// 這行沒有加，在IE就會看到亂碼
			$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
			$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
			$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
			$end_string .= '<script type="text/javascript">';
			$end_string .= 'alert("File is NOT EXISTS!!");';
			$end_string .= 'window.location.href="'.$_SERVER['HTTP_REFERER'].'";';
			$end_string .= '</script>';
			echo $end_string;
			die;
		}

		$aaa = file_get_contents($file01);
		$tmps = explode("\n", $aaa);
		// 先檢查有沒有開頭和結尾
		$check1 = false;
		$check2 = false;
		if($tmps){
			foreach($tmps as $k => $v){
				if($v == '// DEF AUTO GENERATE START, DO NOT MODIFY!!'){
					$check1 = true;
				} elseif($v == '// DEF AUTO GENERATE END, DO NOT MODIFY!!'){
					$check2 = true;
				}
			}
		}

		if($check1 and $check2){
		} else {
			$end_string = '';
			// 這行沒有加，在IE就會看到亂碼
			$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
			$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
			$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
			$end_string .= '<script type="text/javascript">';
			$end_string .= 'alert("Ignore DEF export!");';
			$end_string .= 'window.location.href="'.$_SERVER['HTTP_REFERER'].'";';
			$end_string .= '</script>';
			echo $end_string;
			die;
		}

		// 現在才要開始匯出
		if(preg_match('/\/\/\ DEF\ AUTO\ GENERATE\ START,\ DO\ NOT\ MODIFY!!\s(.*)\/\/\ DEF\ AUTO\ GENERATE\ END,\ DO\ NOT\ MODIFY\!\!/', $aaa, $matches)){
			$aaa = str_replace($matches[1], '', $aaa);
			$aaa = str_replace(
				'// DEF AUTO GENERATE START, DO NOT MODIFY!!'."\n".'// DEF AUTO GENERATE END, DO NOT MODIFY!!', 
				'// DEF AUTO GENERATE START, DO NOT MODIFY!!'."\n".'/*'."\n".'protected $def = '.$this->my_var_export($this->def, true).";\n".'*/'."\n".'// DEF AUTO GENERATE END, DO NOT MODIFY!!', 
				$aaa
			);
			//var_dump($aaa);
			//die;
			file_put_contents($file01, $aaa);
		}

		$end_string = '';
		// 這行沒有加，在IE就會看到亂碼
		$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
		$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
		$end_string .= '<script type="text/javascript">';
		$end_string .= 'alert("Export DEF success");';
		$end_string .= 'window.location.href="'.$_SERVER['HTTP_REFERER'].'";';
		$end_string .= '</script>';
		echo $end_string;
		die;
	}

	/**
	 * http://wbkuo.pixnet.net/blog/post/177609294-%5Bphp%5D-%E4%BF%AE%E6%AD%A3-print_r-%E7%84%A1%E6%B3%95%E6%AD%A3%E5%B8%B8%E9%A1%AF%E7%A4%BA%E5%B8%83%E6%9E%97%E5%80%BC%E7%9A%84%E5%95%8F%E9%A1%8C
	 *
	 * 修正 print_r 無法正常顯示布林值的問題
	 * 直接把布林值取代成字串
	 * @author Leo.Kuo
	 */
	protected function print_r_fix($value)
	{
		function print_r_boolean_fix($value)
		{
			if (is_array($value))
			{
				foreach ($value as $key => $v)
				{
					$value[$key] = print_r_boolean_fix($v);
				}
			}
			else if (gettype($value) == "boolean")
			{
				$boolean_str = ($value) ? "True" : "False";
				$value = "{$boolean_str} (Boolean)";
			}

			return $value;
		}
		return print_r(print_r_boolean_fix($value),true);
	}

	// http://php.net/manual/en/function.var-export.php#110067
	protected function my_var_export($var, $is_str=false)
	{
		$rtn = preg_replace(array('/Array\s+\(/', '/\[(\d+)\] => (.*)\n/', '/\[([^\d].*)\] => (.*)\n/'), array('array (', '\1 => \'\2\''."\n", '\'\1\' => \'\2\''."\n"), substr($this->print_r_fix($var, true), 0, -1));
		$rtn = strtr($rtn, array("=> 'array ('"=>'=> array ('));
		$rtn = strtr($rtn, array(")\n\n"=>")\n"));
		$rtn = strtr($rtn, array("'\n"=>"',\n", ")\n"=>"),\n"));
		$rtn = preg_replace(array('/\n +/e'), array('strtr(\'\0\', array(\'    \'=>\'  \'))'), $rtn);
		$rtn = strtr($rtn, array(" Object',"=>" Object'<-"));
		if ($is_str){
			return $rtn;
		} else {
			echo $rtn;
		}
	}


	/**
	 * Smarty assign()方法
	 *
	 */
	public function assign($key, $value)
	{
		Yii::app()->smarty->assign($key, $value);
	}

	// 這裡只是純檢查，如果要照這個規則，在display或是render的裡面，要跟隨這裡的流程和優先權來跑
	// 這裡的view，是aaa/bbb，不是純layout哦
	public function main_content_exists($view, $data = array())
	{
		// 你沒有啟用theme，我當做沒看到，都通過
		if(!isset($data['theme_name']) or $data['theme_name'] == ''){
			return true;
		}

		// 取得現行樣版的執行者以及編號
		$themea = G::get_theme_compiler($data['theme_name']);
		//$themeb = G::get_theme_compiler($data['theme_name'], true);

		if($themea == 'smarty'){
			if(!preg_match('/^text:/', $view)){
				$view_tmp = Yii::getPathOfAlias('application.views').'/'.template_path.'/'.$view.'.htm';
				if(!file_exists($view_tmp)){
					return false;
				}
			}
			return true;
		} elseif($themea == 'yiiv') {
			$return = false;

			$view_tmp1 = Yii::getPathOfAlias('application.views').'/'.$view.'.php';
			if(file_exists($view_tmp1)){
				$return = true;
			}

			//if($data['theme_name'] != 'admin_yiiv_3'){
			//	$view_tmp2 = Yii::getPathOfAlias('webroot.themes.admin_yiiv_3.views').'/'.$view.'.php';
			//	if(file_exists($view_tmp2)){
			//		$return = true;
			//	}
			//}

			//$view_tmp2 = Yii::getPathOfAlias('webroot.themes.'.$data['theme_name'].'.views').'/'.$view.'.php';
			//if(file_exists($view_tmp2)){
			//	$return = true;
			//}

			// 試著把theme放到framework裡面

			if($data['theme_name'] != 'admin_yiiv_3'){
				$view_tmp2 = Yii::getPathOfAlias('system.themes.admin_yiiv_3.views').'/'.$view.'.php';
				if(file_exists($view_tmp2)){
					$return = true;
				}
			}

			$view_tmp2 = Yii::getPathOfAlias('system.themes.'.$data['theme_name'].'.views').'/'.$view.'.php';
			if(file_exists($view_tmp2)){
				$return = true;
			}

			return $return;
		}
		return false;
	}

	// 跟上面的一樣，差別在於回傳路徑
	//public function main_content_path($view, $data = array())
	//{
	//	// 你沒有啟用theme，我當做沒看到，都通過
	//	if(!isset($data['theme_name']) or $data['theme_name'] == ''){
	//		return $view;
	//	}

	//	// 取得現行樣版的執行者以及編號
	//	$themea = G::get_theme_compiler($data['theme_name']);
	//	//$themeb = G::get_theme_compiler($data['theme_name'], true);

	//	if($themea == 'smarty'){
	//		if(!preg_match('/^text:/', $view)){
	//			$view_tmp = Yii::getPathOfAlias('application.views').'/'.template_path.'/'.$view.'.htm';
	//			if(!file_exists($view_tmp)){
	//				return $view_tmp;
	//			}
	//		}
	//		return true;
	//	} elseif($themea == 'yiiv') {
	//		$return = false;

	//		$view_tmp1 = Yii::getPathOfAlias('application.views').'/'.$view.'.php';
	//		if(file_exists($view_tmp1)){
	//			$return = $view_tmp1;
	//		}

	//		if($data['theme_name'] != 'admin_yiiv_3'){
	//			$view_tmp2 = Yii::getPathOfAlias('webroot.themes.admin_yiiv_3.views').'/'.$view.'.php';
	//			if(file_exists($view_tmp2)){
	//				$return = $view_tmp2;
	//			}
	//		}

	//		$view_tmp2 = Yii::getPathOfAlias('webroot.themes.'.$data['theme_name'].'.views').'/'.$view.'.php';
	//		if(file_exists($view_tmp2)){
	//			$return = $view_tmp2;
	//		}

	//		return $return;
	//	}
	//	return false;
	//}
	
	/**
	 * Smarty display()方法
	 * 這裡的view，是layout，沒有斜線哦
	 */
	public function display($view, $data = array()) 
	{
		// 取得現行樣版的執行者以及編號
		$themea = G::get_theme_compiler($data['theme_name']); // 例如：yiiv
		$themeb = G::get_theme_compiler($data['theme_name'], true); // 例如：4

		if($themea == 'smarty'){
			if(count($data) > 0){
				foreach($data as $k => $v){
					$this->assign($k, $v);
				}
			}
			//$tempdata = $this->render('template/default/'.$view, NULL, true);
			//$tempdata = $this->render($view, NULL, true); // 別亂想了
			if(!preg_match('/^text:/', $view)){
				$view = template_path.'/'.$view;
			}
			Yii::app()->smarty->display($view);
		} elseif($themea == 'yiiv') {
			// $view = 'index'

			/*
			 * 這裡不會去處理$view，也不會用
			 */

			/*
			 * http://www.yiiframework.com/forum/index.php/topic/20354-partial-render-problem/
			 */
			// $main_content = 'application.views.'.str_replace('/', '.', $data['main_content']);

			$main_content = false;
			
			// 試看看，改成framework/themes路徑
			if($data['theme_name'] != 'admin_yiiv_3'){
				$view_tmp2 = Yii::getPathOfAlias('system.themes.admin_yiiv_3.views').'/'.$data['main_content'].'.php';
				if(file_exists($view_tmp2)){
					$main_content = 'system.themes.admin_yiiv_3.views.'.str_replace('/', '.', $data['main_content']);
				}
			}

			$view_tmp2 = Yii::getPathOfAlias('system.themes.'.$data['theme_name'].'.views').'/'.$data['main_content'].'.php';
			if(file_exists($view_tmp2)){
				$main_content = 'system.themes.'.$data['theme_name'].'.views.'.str_replace('/', '.', $data['main_content']);
			}

			$view_tmp2 = yii::getpathofalias('webroot.backend.views').'/'.$data['main_content'].'.php';
			if(file_exists($view_tmp2)){
				$main_content = 'webroot.backend.views.'.str_replace('/', '.', $data['main_content']);
			}

			//$main_content = '//'.$data['main_content'];

			//$main_content = $data['main_content'];
			//$main_content = '//'.$main_content;

			// 這要帶給renderPartial所使用的，通常是放在render之前(就最後啦)
			//$data['_data'] = $data;

			// 何必呢...
			//if(preg_match('/^default\//', $main_content)){
			//	$main_content = '_'.$main_content;
			//}

			//var_dump($data);
			//die;

			// $this->data['sys_configs']['template_rulev1_group'] = 'theme_admin';
			// if(0 and empty($_POST) and Yii::app()->db->schema->getTable($this->data['sys_configs']['template_rulev1_group'])){

			// 	$class_method = $this->data['router_class'].'/'.$this->data['router_method'];

			// 	$row01 = $this->db->createCommand()->from($this->data['sys_configs']['template_rulev1_group'])->where('is_enable=1 and (func=:func OR concat(\',\',func_other,\',\') LIKE \'%,'.$class_method.',%\')', array(':func'=>$this->data['router_class'].'/'.$this->data['router_method']))->queryRow();
			// 	if($row01 and isset($row01['id'])){
			// 		$this->data['gggaaa2'] =  $this->render($main_content, $data, true); 
			// 		include Yii::getPathOfAlias('system.components').'/frontend_generate.php';
			// 		die;
			// 	}
			// } else {
			// 	echo $this->render($main_content, $data, true); 
			// 	die;
			// }

			$this->render($main_content, $data); 

			//echo $this->renderPartial($main_content, $data, true);
		}
	}

	public function getAssetsUrl()
    {
		if ($this->assetsUrl === null){
			// http://www.yiiframework.com/wiki/311/assetmanager-clearing-browser-s-cache-on-site-update/    Step2
			// 開發專用的
			//$this->assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.assetsg'), false, -1, defined('YII_DEBUG') && YII_DEBUG);

			// 試著把assetsUrl這個東西弄掉
			//$this->assetsUrl = str_replace($_SERVER['DOCUMENT_ROOT'], '', Yii::getPathOfAlias('application.assetsg'));

			// 試著共用這個東西
			//$this->assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('system.backend.assetsg'), false, -1, defined('YII_DEBUG') && YII_DEBUG);

			// 又想把assetsUrl這個東西弄掉 2015/05/25
			//echo _BASEPATH;
			//echo $_SERVER['DOCUMENT_ROOT'];
			//echo Yii::getPathOfAlias('system.backend.assetsg');
			//die;
			//$system_path =  str_replace('_i/framework/backend/assetsg','',Yii::getPathOfAlias('system.backend.assetsg'));
			//die;
			//$this->assetsUrl = str_replace($_SERVER['DOCUMENT_ROOT'], '', Yii::getPathOfAlias('system.backend.assetsg'));
			$this->assetsUrl = BACKEND_ASSETSURL_DOMAIN.'/'.str_replace(str_replace('_i/framework/backend/assetsg','',Yii::getPathOfAlias('system.backend.assetsg')), '', Yii::getPathOfAlias('system.backend.assetsg'));
			//echo $this->assetsUrl;

			// Debug
			//$this->assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.assetsg'), false, -1, true);
		}
		$this->data['asseturl'] = $this->assetsUrl;
		//echo $this->data['asseturl'].'<br />'; // 這個是後台版型
		//echo Yii::app()->clientScript->getCoreScriptUrl().'<br />'; // 這個是fr/web/js/source裡面的東西
		//die;
		return $this->assetsUrl;
	}
    
	public function setAssetsUrl($value) 
    {
		$this->assetsUrl = $value;
		$this->data['asseturl'] = $value;
	}

	public function actionCrop()
	{
		$width = $_GET['width'];
		$height = $_GET['height'];
		$pic = $_GET['pic'];
		//$imageData = $_POST['data'];
		$img = $_POST['data'];

		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		file_put_contents(tmp_path.'/thumb/'.$this->data['router_class'].'/'.$width.'x'.$height.'_'.$pic, $data);

		echo $this->data['image_thumb_path'].'/'.$this->data['router_class'].'/'.$width.'x'.$height.'_'.$pic;
		die;

		//preg_match('#^data:[\w/]+(;[\w=]+)*,[\w+/=%]+$#', $imageData)
		//copy($data, tmp_path.'/thumb/'.$this->data['router_class'].'/'.$width.'x'.$height.'_'.$pic);

		//    /*
		//     * http://permadi.com/2010/10/html5-saving-canvas-image-data-using-php-and-ajax/
		//     */

		//    // Remove the headers (data:,) part.
		//    // A real application should use them according to needs such as to check image type
		//    $filteredData = substr($imageData, strpos($imageData, ",")+1);

		//    // Need to decode before saving since the data we received is already base64 encoded
		//    $unencodedData = base64_decode($filteredData);

		//    //echo "unencodedData".$unencodedData;

		//    // Save file. This example uses a hard coded filename for testing,
		//    // but a real application can specify filename in POST variable
		//    $fp = fopen(tmp_path.'/thumb/'.$this->data['router_class'].'/'.$width.'x'.$height.'_'.$pic, 'wb');
		//    fwrite($fp, $unencodedData);
		//    fclose($fp);

		echo 'success';
		die;
	}

	// 試著寫一個回傳所有欄位型態的函式，其它程式也會使用
	public function return_funcv2_field()
	{
		// 從實體檔案和模組兩個方向去取得欄位型態
		$tmp = file_get_contents(Yii::getPathOfAlias('system.themes.admin_yiiv_3.views.default').'/update_fields_section.php');
		$tmps = explode("\n", $tmp);
		$rows = array();
		//var_dump($tmps);
		foreach($tmps as $k => $v){
			if(preg_match('/if\(\$vv\[\'type\'\]\ \=\=\ \'(.*)\'\)/', $v, $matches)){
				//if(preg_match('/if\(\$vv\[\'type\'\]\ \=\=\ \'(.*)\'\)/', $v, $matches)){
				$rows[$matches[1]] = $matches[1];
			}
		}
		// 從檔案
		$tmp = $this->_getFiles(Yii::getPathOfAlias('system.themes.admin_yiiv_3.views.default.updatefields'));
		$files = array();
		if($tmp and count($tmp) > 0){
			foreach($tmp as $k => $v){
				$tmp02 = str_replace(Yii::getPathOfAlias('system.themes.admin_yiiv_3.views.default.updatefields').'/','', $v);
				$tmp02 = str_replace('.php', '', $tmp02);
				$rows[$tmp02] = $tmp02;
				$files[$tmp02] = Yii::getPathOfAlias('system.themes.admin_yiiv_3.views.default.updatefields').'/'.$tmp02.'.php';
			}
		}
		// 整理一下
		if($rows){
			foreach($rows as $k => $v){
				if(preg_match('/vv\[\'type/', $v)){
					unset($rows[$k]);
					$tmp = explode('\' or $vv[\'type\'] == \'', $v);
					if($tmp){
						foreach($tmp as $kk => $vv){
							$rows[$vv] = $vv;
						}
					}
				}
			}
		}

		ksort($rows);

		// 做一下名稱的轉換
		$rows_tmp = array();
		if(count($files) > 0){
			$this->data['vv_type_kk'] = '';
			$this->data['vv_type_vv'] = '';
			foreach($files as $k => $v){
				$tmp_module_config = array();
				include $v;
				if(count($tmp_module_config) > 0){
					if(isset($tmp_module_config['name']) and $tmp_module_config['name'] != ''){
						$rows_tmp[$k] = $tmp_module_config['name'];
					}
				}
			}
		}

		foreach($rows as $k => $v){
			if(isset($rows_tmp[$v]) and $rows_tmp[$v] != ''){
				$rows[$k] = $rows_tmp[$v].' ('.$v.')';
			}
		}

		return $rows;
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

	/*
	 * 上傳到暫存
	 */
	public function actionUpload($type, $width, $height, $qqfile, $path)
	{
		// get params
		//$type = $_GET['type'];
		//$width = $_POST['width'];
		//$height = $_POST['height'];
		//$ext = $this->input->get('ext');

		/*
		 * 建立上傳物件所需要的上傳路徑
		 */
		$return = array('success' => false);

		// 將圖片上傳到存放原始圖片的資料夾，這個資料夾是沒有做功能上的分類
		if($type == 'image'){
			$upload_path = $this->data['image_upload_tmp_path'].'/';
			$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'svg', 'webp','dng');
		} elseif($type == 'document'){
			$upload_path = $this->data['file_upload_tmp_path'].'/';
			$allowedExtensions = array('cad','doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'csv', 'wmv', 'mpg', 'mp3', 'mp4', 'avi', 'mov', 'zip', 'pptx', 'ppt', 'pdf', 'rar', 'ai', 'tif', 'tiff', 'igs', 'dxf', 'jpg', 'jpeg', 'png', 'gif', 'stp','exe');
		} else {
			echo json_encode($return);
			die();
		}


		if(!file_exists($upload_path)){
			if(!mkdir($upload_path, 0777, true)){
				$return['msg'] = 'error create directory';
				echo json_encode($return);
				die();
			}
		}
		$upload_config['upload_path'] = $upload_path;

		// list of valid extensions, ex. array("jpeg", "xml", "bmp")

		// max file size in bytes
		$sizeLimit = 300 * 1024 * 1024;

		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$return = $uploader->handleUpload($upload_path);

		// 接下來的動作，只會有圖片才會需要
		if($type == 'document'){
			echo json_encode($return);
			die();
		}

		// array(
		//	'success' => ??,
		//	'filename' => ??,
		//	'origin' => ??,
		// )
		
		$this->thumb_from_tmp($return['filename'], $width, $height);

		echo json_encode($return);
		die();
	}

	/**
	 * 純做縮圖的動作
	 * http://patw.idv.tw/blog/archives/144
	 * http://codeigniter.com/user_guide/libraries/file_uploading.html
	 */
	public function thumb_from_tmp($tmp_file, $width = '', $height = '')
	{
		//if(count($_FILES) <= 0){
		//	echo '-1';
		//}

		// 這個變數暫時沒有用到，因為上傳到暫存資料夾，不打算做分類8/2
		//if($this->input->post('path') == ''){
		//	echo '-1';
		//}

		//$is_thumb = $this->input->post('thumb');
		//$width = $this->input->post('width');
		//$height = $this->input->post('height');

		//if($is_thumb == ''){
		//	$is_thumb = '1';
		//}

		if($width == ''){
			$width = '200';
		}

		if($height == ''){
			$height = '200';
		}

		//  // 縮圖開始
		//  $thumb_config['image_library'] = 'gd2';
		//  $thumb_config['source_image'] = image_upload_tmp_path.ds('/').$tmp_file;
		//  //echo $thumb_config['source_image'];
		//  $thumb_config['create_thumb'] = TRUE;
		//  $thumb_config['maintain_ratio'] = TRUE;
		//  $thumb_config['width'] = $width;
		//  $thumb_config['height'] = $height;
		//  // 如果本來的檔名是aaa.jpg，這個參數不設的話，會輸出縮圖aaa_thumb.jpg
		//  $thumb_config['thumb_marker'] = '';
		//  $thumb_config['new_image'] = image_thumb_tmp_path.'/'.$width.'x'.$height.'_'.$tmp_file;
		//  $this->load->library('image_lib', $thumb_config);
		//  if(!file_exists(image_thumb_tmp_path)){
		//  	if(!mkdir(image_thumb_tmp_path, 0777, true)){
		//  		show_error($this->_getLabel('mkdir image thumb tmp dir fail'));
		//  	}
		//  }
		//  if (!$this->image_lib->resize()){
		//  	$return['msg'] = strip_tags($this->image_lib->display_errors());
		//  	echo json_encode($return);
		//  	die();
		//  }

		// 取得副檔名
		$tmp1 = explode('.', $tmp_file);
		$imagetype = strtolower($tmp1[count($tmp1)-1]);

		$path = $this->data['image_upload_tmp_path'].'/'.$tmp_file;
		$new_image = $this->data['image_thumb_tmp_path'].'/'.$width.'x'.$height.'_'.str_replace('.'.$imagetype, '', $tmp_file);
		@mkdir($this->data['image_thumb_tmp_path'], 0777, true);

		$im = null;

		if($imagetype == 'gif')
			$im = imagecreatefromgif($path);
		else if ($imagetype == 'jpg')
			$im = imagecreatefromjpeg($path);
		else if ($imagetype == 'png')
			$im = imagecreatefrompng($path);

		//if($imagetype == 'svg'){
		if(preg_match('/^(svg|webp|dng)$/', $imagetype)){ // 2020-04-29
		} else {
			CThumb::resizeImage($im, $width, $height, $new_image, '.'.$imagetype);
		}

		// 完成之前
		$return['status'] = '1';

		// 這裡沒有return
	}


}

// ====================================================================================================
include 'Qqupload.php';

<?php

class SeoUrlRule extends CBaseUrlRule
{
	public $connectionID = 'db';
	public $db = NULL;
	public $cidb = NULL;

	public function createUrl($manager,$route,$params,$ampersand)
	{
		// get db object
		//$this->db = Yii::app()->db;
		//$this->cidb = Yii::app()->params['cidb'];

		//$db = Yii::app()->db;
		$db = Yii::app()->params['cidb'];

		//file_put_contents('/home/gisanfu/aaa.txt', _BASEPATH);

		$url = false;

		/*
		 * 這是SEO的網址
		 */

		// _BASEPATH => /home/gisanfu/hg/buyerline_rwd_cttdemo/_i

		if(file_exists(Yii::getPathOfAlias('application.components.seo').'.php')){
			$file = Yii::getPathOfAlias('application.components.seo').'.php';
		} else {
			$file = Yii::getPathOfAlias('system.frontend.components.seo').'.php';
		}

		include $file;

		// 第一層的檢查 
		// index.php?r=site/aaa	
		//if(preg_match('/^site\/(.*)$/', $route, $matches) and (!$params or count($params) <= 0)){
		//	if(file_exists(_BASEPATH.'/../'.$matches[1].'.php')){
		//		$url = $matches[1].'.html';
		//	}
		//}


		/*
		 * 這是正常的mvc網址
		 */

		// 2019-01-31 試著修正層級的問題，因為這邊只能處理到相對路徑而以
		$ggg3 = '';
		$ggg = explode('/', $_SERVER['REQUEST_URI']);
		if(count($ggg) > 2){
			$ggg2 = count($ggg) - 2;
			for($x=0;$x<=$ggg2;$x++){
				$ggg3 .= '../';
			}
		}

		if(!$url){
			$url = $ggg3.'index.php?r='.$route;
			//$url = '../../index.php?r='.$route; // 2019-01-31 bv
			if(count($params) > 0){
				$url = $url.'&';
				$tmps = array();
				foreach($params as $k => $v){
					$tmps[] = $k.'='.$v;
				}
				$url .= implode('&', $tmps);
			}
		} else {
			$url = $ggg3.$url;
		}

		//2016/6/20 lota 加入自動跟隨其他語系參數
		if(defined('FRONTEND_DEFAULT_LANG') && FRONTEND_DEFAULT_LANG != Yii::app()->language)
			$url .= '&lang='.Yii::app()->language;

		return $url;

		//return false;  // this rule does not apply
	}

	public function parseUrl($manager,$request,$pathInfo,$rawPathInfo){}

}

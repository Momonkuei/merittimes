<?php
/**
 * Built-in client script packages.
 *
 * Please see {@link CClientScript::packages} for explanation of the structure
 * of the returned array.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

$assetsUrl = BACKEND_ASSETSURL_DOMAIN.'/'.str_replace(str_replace('_i/framework/web/js/source','',Yii::getPathOfAlias('system.web.js.source')), '', Yii::getPathOfAlias('system.web.js.source'));

//$assetsUrl = BACKEND_ASSETSURL_DOMAIN.'/'.str_replace(str_replace('_i/framework/backend/assetsg','',Yii::getPathOfAlias('system.backend.assetsg')), '', Yii::getPathOfAlias('system.backend.assetsg'));

return array(
	'jquery'=>array(
		//'baseUrl' => str_replace($_SERVER['DOCUMENT_ROOT'], '', Yii::getPathOfAlias('system.web.js.source')),
		'baseUrl' => $assetsUrl,
		//'js'=>array(YII_DEBUG ? 'jquery.js' : 'jquery.min.js'),
		// 'js'=>array(YII_DEBUG ? 'jquery-1.7.2.min.js' : 'jquery-1.7.2.min.js'),
		'js'=>array(YII_DEBUG ? 'jquery-1.11.3.min.js' : 'jquery-1.11.3.min.js'),//2021-09-07 1.7.2升級1.11.3 by lota
	),
	'yii'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.yii.js'),
		'depends'=>array('jquery'),
	),
	'yiitab'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.yiitab.js'),
		'depends'=>array('jquery'),
	),
	'yiiactiveform'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.yiiactiveform.js'),
		'depends'=>array('jquery'),
	),
	'jquery.ui'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jui/js/jquery-ui.min.js'),
		'depends'=>array('jquery'),
	),
	'bgiframe'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.bgiframe.js'),
		'depends'=>array('jquery'),
	),
	'ajaxqueue'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.ajaxqueue.js'),
		'depends'=>array('jquery'),
	),
	'autocomplete'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.autocomplete.js'),
		'depends'=>array('jquery', 'bgiframe', 'ajaxqueue'),
	),
	'maskedinput'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array(YII_DEBUG ? 'jquery.maskedinput.js' : 'jquery.maskedinput.min.js'),
		'depends'=>array('jquery'),
	),
	'cookie'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.cookie.js'),
		'depends'=>array('jquery'),
	),
	'treeview'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.treeview.js', 'jquery.treeview.edit.js', 'jquery.treeview.async.js'),
		'depends'=>array('jquery', 'cookie'),
	),
	'multifile'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.multifile.js'),
		'depends'=>array('jquery'),
	),
	'rating'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.rating.js'),
		'depends'=>array('jquery', 'metadata'),
	),
	'metadata'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.metadata.js'),
		'depends'=>array('jquery'),
	),
	'bbq'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array(YII_DEBUG ? 'jquery.ba-bbq.js' : 'jquery.ba-bbq.min.js'),
		'depends'=>array('jquery'),
	),
	'history'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array('jquery.history.js'),
		'depends'=>array('jquery'),
	),
	'punycode'=>array(
		'baseUrl' => $assetsUrl,
		'js'=>array(YII_DEBUG ? 'punycode.js' : 'punycode.min.js'),
	),
);

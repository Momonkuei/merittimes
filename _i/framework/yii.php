<?php

// 200的外部IP
	if(!defined('EIP_APIV1_PUBLICKEY')) define('EIP_APIV1_PUBLICKEY', '224990017745');
	if(!defined('EIP_APIV1_PRIVATEKEY')) define('EIP_APIV1_PRIVATEKEY', '021317730886');
	if(!defined('EIP_APIV1_DOMAIN')) define('EIP_APIV1_DOMAIN', 'http://crm2.buyersline.com.tw');

// 防止sql_injection (SQLMAP)
if(is_file(dirname(__FILE__).'/sql_injection_check.php')){

	require(dirname(__FILE__).'/sql_injection_check.php');

	class HHH extends Sql_injection_check
	{
	}
	//這邊如果要放到線上環境，要改成這個判斷式
	if($app_name!='backend' and !preg_match('/(api\/scssphpv3)/', $test_phy_file)){
	// if($app_name!='backend'){
		$_POST = HHH::check_value($_POST);
		$_GET = HHH::check_value($_GET);
		$_REQUEST = HHH::check_value($_REQUEST);//server zoo 的 server3 可能會有問題
	}
}

/**
 * Yii bootstrap file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @package system
 * @since 1.0
 */

if(!class_exists('YiiBase', false))
	require(dirname(__FILE__).'/YiiBase.php');

/**
 * Yii is a helper class serving common framework functionalities.
 *
 * It encapsulates {@link YiiBase} which provides the actual implementation.
 * By writing your own Yii class, you can customize some functionalities of YiiBase.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system
 * @since 1.0
 */
class Yii extends YiiBase
{
}

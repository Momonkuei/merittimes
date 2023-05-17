<?php

// 不同Application，如果這裡有指定的話(例如"admin/"或是en/")，可以使用自己的group、view等，但是layoutv3資料夾還是共用一個
if(!isset($layoutv3_path)){
	$layoutv3_path = '';
}

// 下面的a.php，不需要用parent_path來判斷，因為不太一樣
// 這個是Yii專用
if(!isset($layoutv3_parent_path)){
	$layoutv3_parent_path = '';
}

if(!defined('LAYOUTV3_IS_RUN_FIRST')){

	// 每一種架構模式都會有這個屬於自己的常數 2018-01-15
	define('LAYOUTV3_STRUCT_MODE', 'yii_ctt');

	define('LAYOUTV3_PARENT_PATH', $layoutv3_parent_path);
	define('LAYOUTV3_PATH', $layoutv3_path); // 為了要讓MVC架構也能使用，所以才用常數

	/*
	 * 這是一個示範，簡化MVC的網址
	 */

	if(file_exists('a.php')){
		// define('LAYOUTV3_IS_RUN_FIRST', str_replace(__DIR__.'/', '', str_replace('.php','',__FILE__)));
		// 用script_name才不會抓到GET引數
		//為了支援網站放在次目錄所處理的 by lota
		define('LAYOUTV3_IS_RUN_FIRST', str_replace('/', '', str_replace('.php', '', str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']))));
		
		$tmp = LAYOUTV3_IS_RUN_FIRST;

		// 修改預設的router和method，為了要減化網址
		define('RETURNXX', <<<XXX
		\$returnxx = array(
			'defaultController' => 'ctt',
			'defaultAction' => '$tmp',
		);
XXX
		);
		require 'a.php';
	} else {
		// define('LAYOUTV3_IS_RUN_FIRST', str_replace(__DIR__.'/', '', str_replace('.php','',__FILE__)));
		// 用script_name才不會抓到GET引數

		$gggs = explode('/', str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']));//為了支援網站放在次目錄所處理的 by lota

		define('LAYOUTV3_IS_RUN_FIRST', str_replace('.php', '', $gggs[count($gggs)-1]));
		
		$tmp = LAYOUTV3_IS_RUN_FIRST;

		// 修改預設的router和method，為了要減化網址
		define('RETURNXX', <<<XXX
		\$returnxx = array(
			'defaultController' => 'sem',
			'defaultAction' => '$tmp',
		);
XXX
		);
		require '../a.php';
	}

	// 前半段這裡結束
}

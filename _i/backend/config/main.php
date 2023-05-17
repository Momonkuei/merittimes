<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(

	// 如果你不喜歡預設site default controller的話，來這裡改一下
	//'defaultController' => 'aaa',

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// http://www.yiiframework.com/forum/index.php/topic/13006-shared-themes-base-path/
	//'theme'=>'admin_smarty_1',
	//'theme'=>'admin_yiiv_2',
	//'theme'=>'classic',
	//'theme'=>'admin_yiiv_3',
	//'theme'=>'admin_yiiv_4',
	'theme' => 'admin_yiiv_5',

	// preloading 'log' component
	//'preload'=>array('log'),

	// zend loader v3
	'preload'=>array('log', 'zendAutoloader','input'),

	// autoloading model and component classes
	'import'=>array(
		'system.components.*',

		// 後台共用程式
		'system.backend.components.*',
		'system.backend.extensions.*',
		'system.backend.models.*',
		'system.backend.models.generate.*',

		//'system.models.*', // 另外加的，打算把Empty_orm放framework那邊，讓前後台共用

		'application.models.*',
		'application.components.*',
		'application.extensions.*',
		//'application.extensions.smarty.sysplugins.*',
		'application.models.generate.*',
		'application.controllers.generate.*',

		// Zend loader v3
		'system.vendors.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		//'gii'=>array(
		//	'class'=>'system.gii.GiiModule',
		//	'password'=>'qwe123',
		//	// If removed, Gii defaults to localhost only. Edit carefully to taste.
		//	'ipFilters'=>array('127.0.0.1','::1'),
		//),
		/*
		*/
	),

	// 預設多國語系
	'language' => 'tw',

	// application components
	'components'=>array(

		// 2019-04-19 不支援php 7.3
		// http://www.yiiframework.com/extension/input/
		'input'=>array(   
			'class'         => 'CmsInput',  
			'cleanPost'     => false,  
			'cleanGet'      => true, // 2018-02-12 李哥早上說，只要過濾掉GET就好了
		),

		'themeManager' => array(
			//'basePath' => 'system.themes',

			// 因為這裡一定要寫實際的部徑，不能用Alias的
			'basePath' => str_replace('yii.php', 'themes', aaa_yii),
		),

		// https://github.com/damncabbage/yii-zend-autoloader/blob/master/examples/main.php
		// Set up the autoloader component <------ (This entire block.)
		'zendAutoloader'=>array(
			// Change this if you've put the class elsewhere.
			'class'=>'system.components.DCZendAutoloader',

			// Optional: provide an absolute path to the non-Yii directory containing the
			// Zend libraries.
			//'basePath'=>realpath(dirname(__FILE__).'/../../../../private/libraries/zf-1.10.2'),
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			// 以下是自行撰寫驗證授權所新增的設定(不寫了)
            //'loginUrl' => array('auth/login'),
			//'class' => 'AdminWebUser',
		),
		//'smarty'=>array(
		//	'class'=>'application.extensions.CSmarty',
		//),
		// 為了支援level
		'clientScript' => array(
			'class' => 'ClientScript',
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
			'connectionString' => 'mysql:host='.aaa_dbhost.';dbname='.aaa_dbname,
			'emulatePrepare' => true,
			'username' => aaa_dbuser,
			'password' => aaa_dbpass,
			'charset' => 'utf8mb4',//2021-03-12 資料庫也要使用utf8mb4 才能存emoji符號 by lota
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			// 'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'gisanfu@gmail.com',
	),
);

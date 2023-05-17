<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
//return array(
//	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
//	'name'=>'My Console Application',
//
//	// preloading 'log' component
//	'preload'=>array('log'),
//
//	// application components
//	'components'=>array(
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
//		// uncomment the following to use a MySQL database
//		/*
//		'db'=>array(
//			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
//			'emulatePrepare' => true,
//			'username' => 'root',
//			'password' => '',
//			'charset' => 'utf8',
//		),
//		*/
//		'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//				array(
//					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning',
//				),
//			),
//		),
//	),
//);

return array(
	// zend loader v3
	'preload'=>array('log', 'zendAutoloader'),

	// autoloading model and component classes
	'import'=>array(
		'system.components.*',
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
		'application.extensions.smarty.sysplugins.*',
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
		'smarty'=>array(
			'class'=>'application.extensions.CSmarty',
		),
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
			'charset' => 'utf8',
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
			'errorAction'=>'site/error',
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

<?php

// 這個是開發階段所使用的，如果開發完成，請註解
error_reporting(E_ALL);
ini_set("display_errors", 1);

//引入$web_folder
include_once dirname(dirname(__FILE__)).'/_i/config/web_folder.php';
// include_once '_i/config/web_folder.php';

/*
 * 這支程式，對於LayoutV3來說，是要預留給需要用的程式或架構，例如：MVC架構
 * 除了這裡以外，根目錄的index.php可能也會有，那邊也要看一下
 * 還有，如果是特殊架構，parent/core.php的這支檔案也要看一下
 */

// 切換成Yii架構(1/2)(V3)
// include 'yii/init.php';

// 切換成Yii架構(cttdemo)
// 記得這些檔案也要跟著修改： 1. parent/core.php 2. group/layout_main.php 3. cp contact/(v3|ctt)_contact.php contact/contact.php
// include 'yii_ctt/init.php';

// 切換成CIg前台架構(1/3) - 向下相容Yii的非MVC架構
// 同時也是獨立模式
// 也同時是layoutv2的原生支援 beta
// 測試後不支援 php 7.0以後的版本 ( mysql_connect() 問題)
// 如果要支援php7，請看misc/php7.txt的文件
include 'cig_frontend/init.php';

// 切換成CI3前台架構
// include 'ci3_frontend/init.php';

// 切換成cttdemo前台架構
// include 'cttdemo/init.php';

// 前半段到這裡就結束了哦
// 接下來YII的預設Controllers會重新載入程式，例如載入company.php
// 但是程式都會載入這支core.php，所以這支程式會被載入第二次
//

$page = array();
$data = array();

// 切換成CIg前台架構(2/3) - 向下相容Yii的非MVC架構
// 同時也是獨立模式
// 也同時是layoutv2的原生支援 beta
if(!isset($layoutv3_parent_path)){
	$layoutv3_parent_path = '';
}
$simplehtml = '';

// 動態載入區塊用
// $third_party = array();

<?php

// 這個是開發階段所使用的，如果開發完成，請註解
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

/*
 * 這支程式，對於LayoutV3來說，是要預留給需要用的程式或架構，例如：MVC架構
 */

include 'cttdemo/init.php';

// 前半段到這裡就結束了哦
// 接下來YII的預設Controllers會重新載入程式，例如載入company.php
// 但是程式都會載入這支core.php，所以這支程式會被載入第二次
//

$page = array();
$data = array();

// 動態載入區塊用
$third_party = array();

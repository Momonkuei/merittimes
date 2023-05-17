<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

// $contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/').'HtmlController.php');
$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_home_section.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
eval($contentx);

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');

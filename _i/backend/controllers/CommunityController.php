<?php
$pathx = 'sample_rows';
$tmps = explode('/',str_replace('\\','/',__FILE__));
$filename = str_replace('.php','',$tmps[count($tmps)-1]);
$contentx2 = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_main.php');
$contentx2 = str_replace('<'.'?'.'php', '', $contentx2);
eval($contentx2);
eval('class '.$filename.' extends NonameController {}');
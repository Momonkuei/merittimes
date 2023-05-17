<?php

// 底下的規格，將只採用分散的寫法(自動組合)
if(!isset($admin_field)){
	$contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst('shop').'specController.php');
	$contentx = str_replace('<'.'?'.'php', '', $contentx);
	$contentx = str_replace('extends Controller', '', $contentx);
	$contentx = str_replace('protected $def', 'static public $def', $contentx);
	$contentx = str_replace('$tmps = explode(\'/\',__FILE__);', '', $contentx);
	$contentx = str_replace('$filename = str_replace(\'.php\',\'\',$tmps[count($tmps)-1]);', '', $contentx);
	$contentx = str_replace('eval(\'class \'.$filename.\' extends NonameController {}\');', '', $contentx);
	eval($contentx);
	eval('$admin_def = NonameController::$def;');
	$admin_field = $admin_def['updatefield']['sections'][0]['field'];
}

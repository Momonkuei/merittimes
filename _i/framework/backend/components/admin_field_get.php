<?php

/*
 * $admin_field_router_class 要抓取的
 * $admin_field_variable 要改名的，被繼承的
 */

if(!isset($admin_field_router_class)){
	$admin_field_router_class = str_replace('homesort','',$this->data['router_class']);
}

// if(!function_exists('gerahash_admin_field_get')){
// 	function gerahash_admin_field_get($qtd){
// 		$Caracteres = 'abcdefghijklmopqrstuvxwyz';
// 		$QuantidadeCaracteres = strlen($Caracteres);
// 		$QuantidadeCaracteres--;
// 
// 		$Hash=NULL;
// 		for($x=1;$x<=$qtd;$x++){
// 			$Posicao = rand(0,$QuantidadeCaracteres);
// 			$Hash .= substr($Caracteres,$Posicao,1);
// 		}
// 
// 		return $Hash;
// 	} 
// }

unset($admin_field);

if(isset($admin_field_router_class)){
	$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/').ucfirst($admin_field_router_class).'Controller.php');
	$contentx = str_replace('<'.'?'.'php', '', $contentx);
	//$contentx = str_replace('extends Controller', '', $contentx);
	//$contentx = str_replace('protected $def', 'static public $def', $contentx);

	// 把懶人機制拿掉
	$contentx = str_replace('$tmps = explode(\'/\',__FILE__);', '', $contentx);
	$contentx = str_replace('$filename = str_replace(\'.php\',\'\',$tmps[count($tmps)-1]);', '', $contentx);
	$contentx = str_replace('eval(\'class \'.$filename.\' extends NonameController {}\');', '', $contentx);
	//$admin_field_variable = 'Noname'.gerahash_admin_field_get(10).'Controller';
	$contentx = str_replace('NonameController', $admin_field_variable, $contentx);

	eval($contentx);

	//$admin_def = ContactuswebController::$def;
	//eval('$admin_def = '.ucfirst($this->data['router_method']).'Controller::$def;');

	//eval('$admin_def = '.$admin_field_variable.'::$def;');
	//$admin_field = $admin_def['updatefield']['sections'][$admin_field_section_id]['field'];
}

unset($admin_field_router_class);

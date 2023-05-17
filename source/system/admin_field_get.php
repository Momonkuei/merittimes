<?php

if(!function_exists('gerahash_admin_field_get')){
	function gerahash_admin_field_get($qtd){
		$Caracteres = 'abcdefghijklmopqrstuvxwyz';
		$QuantidadeCaracteres = strlen($Caracteres);
		$QuantidadeCaracteres--;

		$Hash=NULL;
		for($x=1;$x<=$qtd;$x++){
			$Posicao = rand(0,$QuantidadeCaracteres);
			$Hash .= substr($Caracteres,$Posicao,1);
		}

		return $Hash;
	} 
}

// https://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
/*
 * 用法
 * echo str_replace_first('abc', '123', 'abcdef abcdef abcdef'); 
 * outputs '123def abcdef abcdef'
 */
if(!function_exists('str_replace_first')){
	function str_replace_first($from, $to, $content)
	{
		$from = '/'.preg_quote($from, '/').'/';
		return preg_replace($from, $to, $content, 1);
	}
}

unset($admin_def); // 存放$this->def
unset($admin_field); // 存放某內頁欄位群
unset($admin_fields); // 假設性的，猜測有哪些欄位 (view/system/form_start.php、和view/system/detail/row_field.php在使用)

if(isset($admin_field_section_id) and isset($admin_field_router_class)){

	$funcfieldv3_file = _BASEPATH.ds('/assets/').'funcfieldv3_'.$admin_field_router_class.'.php';
	$funcfieldv3_file2 = _BASEPATH.ds('/assets/').'funcfieldv3_'.$admin_field_router_class.'type.php'; // 多層文章的部份會遇到

	if(file_exists($funcfieldv3_file)){
		include $funcfieldv3_file;
	} elseif(file_exists($funcfieldv3_file2)){
		include $funcfieldv3_file2;
	} else {
		// $contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst($this->data['router_method']).'Controller.php');
		// $contentx = file_get_contents(Yii::getPathOfAlias('system').ds('/backend').ds('/controllers/').ucfirst($this->data['router_method']).'Controller.php');

		//if($admin_field_router_class == 'contact'){
		if(file_exists(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst($admin_field_router_class).'Controller.php')){
			$contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst($admin_field_router_class).'Controller.php');
		} elseif(file_exists(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst($admin_field_router_class).'typeController.php')){ // 多層文章的部份會遇到
			$contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst($admin_field_router_class).'typeController.php');
		}

		// 2020-09-30 要記得，這個特例，是不支援funcfieldv3的
		if(preg_match('/sample_(contact_b2c|contact_b2b)/',$contentx,$matches)){
			$contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/include/').'sample_'.$matches[1].'.php');
		}

		// 檢查是不是使用了_i/backend/include/sample機制，如果是，那就會略過它，直到它產出funcfieldv3_XXX.php的暫存檔
		if(preg_match('/\$get_r\ /', $contentx)){
			// ignore
		} else {
			$contentx = str_replace_first('<'.'?'.'php', '', $contentx); // 2020-05-26
			$contentx = str_replace('extends Controller', '', $contentx);
			$contentx = str_replace('protected $def', 'static public $def', $contentx);

			// 把懶人機制拿掉
			$contentx = str_replace('$tmps = explode(\'/\',__FILE__);', '', $contentx);
			$contentx = str_replace('$filename = str_replace(\'.php\',\'\',$tmps[count($tmps)-1]);', '', $contentx);
			$contentx = str_replace('eval(\'class \'.$filename.\' extends NonameController {}\');', '', $contentx);
			$admin_field_variable = 'Noname'.gerahash_admin_field_get(10).'Controller';
			$contentx = str_replace('NonameController', $admin_field_variable, $contentx);

			$contentxs = explode("\n", $contentx);
			if(isset($contentxs) and !empty($contentxs)){
				foreach($contentxs as $k => $v){
					if(preg_match('/^use\ /', $v)){
						unset($contentxs[$k]);
					} elseif(preg_match('/phpSpreadsheet\/autoload/', $v)){
						unset($contentxs[$k]);
					}
				}
				$contentx = implode("\n",$contentxs);
			}

			// 2020-01-09
			// 在php7.4的時候，變數裡面的parent::beforeAction($action)那行會報parent錯誤，因為我只是要抓def變數而以，所以就用小老鼠來忽略它
			@eval($contentx);

			// $admin_def = ContactuswebController::$def;
			// eval('$admin_def = '.ucfirst($this->data['router_method']).'Controller::$def;');

			eval('$admin_def = '.$admin_field_variable.'::$def;');

			// 2018-06-14 如果沒有使用sample的機制下，然後資料表名稱，是在before階段替換變數的情況下，而且預設值是XXX，那在這個情況下，就會抓到XXX
			if($admin_def['table'] == 'XXX'){
				$admin_def['table'] = $admin_field_router_class;
			}
			if($admin_def['empty_orm_data']['table'] == 'XXX'){
				$admin_def['empty_orm_data']['table'] = $admin_field_router_class;
			}
		}
	}

	if(isset($admin_def['updatefield']['sections'][$admin_field_section_id])){
		$admin_field = $admin_def['updatefield']['sections'][$admin_field_section_id]['field'];
	}

	/*
	 *  
	 */
	$tmps = array();
	if(isset($admin_def['listfield']) and count($admin_def['listfield']) > 0){
		foreach($admin_def['listfield'] as $k => $v){
			$tmps[$k] = '';
		}
	}
	if(isset($admin_def['searchfield']['sections'][0]['field']) and count($admin_def['searchfield']['sections'][0]['field']) > 0){
		foreach($admin_def['searchfield']['sections'][0]['field'] as $k => $v){
			$tmps[$k] = '';
		}
	}
	for($x=0;$x<=4;$x++){
		if(isset($admin_def['updatefield']['sections'][$x]['field']) and count($admin_def['updatefield']['sections'][$x]['field']) > 0){
			foreach($admin_def['updatefield']['sections'][$x]['field'] as $k => $v){
				$tmps[$k] = '';
			}
		}
	}

	if(!empty($tmps)){
		foreach($tmps as $k => $v){
			$admin_fields[] = $k;
		}
	}

}

unset($admin_field_section_id);
unset($admin_field_router_class);

<?php

class Foo {

	public $data;

	// 這是後台在用的
	// public $ignore_class_acl = array(
	// 	'login',
	// 	'captcha',
	// );

	function __construct()
	{


		// 這個是開發階段所使用的，如果開發完成，請註解
		error_reporting(E_ALL);
		ini_set("display_errors", 1);

		$run = '<'.'?'.'php // 123?'.'>
<html>
<head>
</head>
</head>
<body>'.$_POST['html'].'
</body>
</html>';

		// 初始化
		@session_start();
		$simplehtml = ''; // 假裝init
		$old_struct = true;
		$_SESSION['web_ml_key'] = 'tw';
		$this->data['ml_key'] = $_SESSION['web_ml_key'];
		define('FRONTEND_DOMAIN','');
		$goback_root_path = ''; // 如果不是放根目錄，那就要提供，哪一個地方底下，的上幾層是根目錄

		// 純參考而以，有需要用才打開
		// $Db_Server = 'localhost';
		// $Db_User = 'ordertrading_use';
		// $Db_Pwd = '';
		// $Db_Name = 'rwd_v3'; 

		include 'standalone_simplehtmldom.php';

		include 'layoutv3/cig/ci.php';

		define('_BASEPATH', realpath(dirname(__FILE__)).'/_i');
		define('LAYOUTV3_PATH', '');

		include 'layoutv3/cig/libs.php'; // pre_render
		include 'layoutv3/cig_frontend/libs.php'; // pre_render
		include 'layoutv3/libs.php'; // pre_render
		include 'source/core_seo.php';

		$aaa = file_get_contents($goback_root_path.'_i/config/db.php');
		$aaa = str_replace('aaa_','gggaaa_',$aaa);
		eval('?'.'>'.$aaa);

		$Db_Server = gggaaa_dbhost;
		$Db_User = gggaaa_dbuser;
		$Db_Pwd = gggaaa_dbpass;
		$Db_Name = gggaaa_dbname; 

		$tmps = array(
			'dbdriver' => 'mysql',
			'username' => $Db_User,
			'password' => $Db_Pwd,
			'hostname' => $Db_Server,
			'port' => 3306,
			'database' => $Db_Name,
			'db_debug' => true,
		);

		$this->cidb = ggg_load_database($tmps, true);
		$this->db = new yii_cdb($this->cidb);

		// 這一段程式碼，是從母版的source/core.php裡面複製過來的
		// 2018-02-27 V1第二版，在後台的功能，李哥下午己經有看過這個東西 
		$rows = $this->cidb->where('is_enable',1)->where('type','dom5')->where('other1 !=','')->where('topic !=','')->order_by('sort_id','asc')->get('html')->result_array();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$rule = array(
					'type' => $v['other1'],
					'parent' => $v['topic'],
					'debug' => false,
				);

				if($v['is_home'] == '1'){
					$rule['debug'] = true;
				}

				if($v['other1'] == 'l'){
					$rule['single'] = false; // 是否為單層單行模式
					$rule['data_source'] = $v['other3']; // data source
					$rule['params'] = $v['other4']; // parameters
					$rule['ignore_top'] = ''; // 忽略的區塊(上方額外要加上的區塊)
					$rule['debug_first'] = false;
					$rule['struct_0'] = str_replace('\'','"',$v['other6']);
					$rule['struct_1'] = $v['other7'];
					$rule['struct_2'] = $v['other8'];

					if($v['other2'] == '1'){
						$rule['single'] = true;
					}

					if($v['other5'] == '1'){
						$rule['debug_first'] = true;
					}
				} elseif($v['other1'] == 'd'){
					$rule['data_source'] = $v['other9'];
					$rule['struct_tag'] = $v['other10'];
					$rule['struct'] = $v['other11'];
				} elseif($v['other1'] == 't'){
					$rule['function_list'] = array(
						explode(',', $v['other12']),
						$v['other13'],
					);

					$tmps = explode(',', $v['other14']);
					if($tmps and count($tmps) > 0){
						foreach($tmps as $v){
							$rule['function_list'][] = $v;
						}
					}
				}

				$v1[] = $rule;
			}
		}

		ob_start();
		include 'layoutv3/dom5.php';
		$out = ob_get_contents();
		ob_end_clean();

		//var_dump($dom5_runs);

		// ex: $html->find('*[class=mobileMenu]', 0)->find('li',1)->outertext = '';
		$result = array();
		if(isset($dom5_runs) and count($dom5_runs) > 0){
			foreach($dom5_runs as $k => $v){
				$tmp = str_replace('$html->','$("body").',$v);
				if(preg_match('/->outertext\ \=\ \'(.*)\';/s', $tmp, $matches)){
					$content = $matches[1];
					$content = trim(preg_replace('/\s+/', ' ', $content)); // 併成一行，不然js會有問題
					$tmps = explode('->outertext', $tmp);
					$tmp = $tmps[0];
					$tmp = str_replace(')->',').',$tmp);
					$tmp .= '.outerHTML(\''.$content.'\');';
				} elseif(preg_match('/->innertext\ \=\ \'(.*)\';/s', $tmp, $matches)){
					$content = $matches[1];
					$content = trim(preg_replace('/\s+/', ' ', $content)); // 併成一行，不然js會有問題
					$tmps = explode('->innertext', $tmp);
					$tmp = $tmps[0];
					$tmp = str_replace(')->',').',$tmp);
					$tmp .= '.html(\''.$content.'\');';
				} else {
				}

				$result[] = $tmp;
			}
		}

		if(count($result) > 0){
			foreach($result as $k => $v){
				echo $v."\n";
			}
		}

	} // __construct

} // class foo

$ggg = new Foo;
die; // 第一階段到這裡結束

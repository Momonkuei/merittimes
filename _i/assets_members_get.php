<?php

// 只取得檔案列表
function _getFiles($dir)
{
  $files = array();
  if ($handle = opendir($dir)) {
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
			if(is_dir($dir.'/'.$file)){
				//$dir2 = $dir.'/'.$file;
				//$files[] = _getFilesFromDir($dir2);
				//$files[] = $dir2;
			}
			else {
				$files[] = $dir.'/'.$file;
			}
		}
	}   
	closedir($handle);
  }

  return _array_flat($files);
}

// 只取得資料夾列表
function _getDirs($dir)
{
	$files = array();
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
				if(is_dir($dir.'/'.$file)){
					$dir2 = $dir.'/'.$file;
					//$files[] = _getFilesFromDir($dir2);
					$files[] = $dir2;
				}
				else {
					//$files[] = $dir.'/'.$file;
				}
			}
		}   
		closedir($handle);
	}

	return _array_flat($files);
}

// 取得資料夾和檔案列表，包含子目錄
function _getFilesFromDir($dir)
{
	$files = array();
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
				if(is_dir($dir.'/'.$file)){
					$dir2 = $dir.'/'.$file;
					$files[] = _getFilesFromDir($dir2);
				}
				else {
					$files[] = $dir.'/'.$file;
				}
			}
		}   
		closedir($handle);
	}

	return _array_flat($files);
}

function _array_flat($array) {

	$tmp = array();
	foreach($array as $a) {
		if(is_array($a)) {
			$tmp = array_merge($tmp, _array_flat($a));
		}   
		else {
			$tmp[] = $a; 
		}   
	}

	return $tmp;
}

/*
 * #35225
 */

// include_once '../layoutv3/cig_frontend/ci.php';	
// 
// define('aaa_dbhost', '192.168.0.62');
// define('aaa_dbname', 'rwd_v3');
// define('aaa_dbuser', 'environment_user');
// define('aaa_dbpass', 'Ps6RRJmYDXXQYmuE');
// 
// 
// $Db_Server = aaa_dbhost;
// $Db_User = aaa_dbuser;
// $Db_Pwd = aaa_dbpass;
// $Db_Name = aaa_dbname;	
// 
// /*
//  * CI-DB-2
//  */
// $tmps = array(
// 	'dbdriver' => 'mysql',
// 	'username' => $Db_User,
// 	'password' => $Db_Pwd,
// 	'hostname' => $Db_Server,
// 	'port' => 3306,
// 	'database' => $Db_Name,
// 	// 'db_debug' => true,
// );
// // $db = ggg_load_database("mysql://$Db_User:$Db_Pwd@$Db_Server/$Db_Name", true);
// $db = ggg_load_database($tmps, true);

var_dump(_getFilesFromDir('assets/members'));

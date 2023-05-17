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

$classes = _getFiles(Yii::getPathOfAlias('system.frontend.components.modules'));
if($classes and count($classes) > 0){
	$XXXXXXXX_B = 'CController'; // 上一個class的名稱
	asort($classes);
	foreach($classes as $k => $v){
		$tmp0 = file_get_contents($v);
		$tmp1 = 'Coremodule'.($k+1);
		$tmp0 = str_replace('XXXXXXXX_A', $tmp1, $tmp0);
		$tmp0 = str_replace('XXXXXXXX_B', $XXXXXXXX_B, $tmp0);
		$XXXXXXXX_B = $tmp1;
		//include Yii::getPathOfAlias('system.frontend.components.modules.Core1file').'.php';
		eval('?'.'>'.$tmp0);
	}
	eval('class Coremodulelast extends '.$XXXXXXXX_B.' {}');
}

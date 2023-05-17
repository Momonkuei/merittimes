<?php

class XXXXXXXX_A extends XXXXXXXX_B
{
	// 只取得檔案列表
	protected function _getFiles($dir)
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

	  return $this->_array_flat($files);
	}

	// 只取得資料夾列表
	protected function _getDirs($dir)
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

		return $this->_array_flat($files);
	}

	// 取得資料夾和檔案列表，包含子目錄
	protected function _getFilesFromDir($dir)
	{
		$files = array();
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
					if(is_dir($dir.'/'.$file)){
						$dir2 = $dir.'/'.$file;
						$files[] = $this->_getFilesFromDir($dir2);
					}
					else {
						$files[] = $dir.'/'.$file;
					}
				}
			}   
			closedir($handle);
		}

		return $this->_array_flat($files);
	}

	protected function _array_flat($array) {

		$tmp = array();
		foreach($array as $a) {
			if(is_array($a)) {
				$tmp = array_merge($tmp, $this->_array_flat($a));
			}   
			else {
				$tmp[] = $a; 
			}   
		}

		return $tmp;
	}
}

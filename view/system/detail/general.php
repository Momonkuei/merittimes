<?php

/*
 * 這支檔案，建議要放在push的上面，然後單筆和多筆的程式程序之下
 *
 * 寫法參考，兩個同時存在，這樣就可以同時處理兩種情況
 * if($row and isset($row) and isset($row['id'])){
 *	// blha
 * }
 *
 * if($rows and !empty($rows)){
 *	// blha
 * }
 */

$file = _BASEPATH.'/../source/'.$router_method.'/general_detail.php';
if(file_exists($file)){
	include($file);
}
?>

<?php

/*
 * 這個是JS的版本，會有這個版本，是因為上一個版本己經陸續出現問題了
 *
 * https://github.com/medialize/sass.js/blob/master/docs/api.md
 * https://github.com/medialize/sass.js/blob/master/docs/getting-started.md
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);


// include 'layoutv3/init.php';

$run = ' '."\n";
/*
 * DOM第二版初始化
 */
@session_start();
$simplehtml = ''; // 假裝init
$old_struct = true;
$_SESSION['web_ml_key'] = 'tw'; // 注意！！！預設語系不是繁體中文的網站，要記得改這裡
define('FRONTEND_DOMAIN','');

// 純參考而以，千千萬萬不要打開
// $Db_Server = 'localhost';
// $Db_User = 'ordertrading_use';
// $Db_Pwd = '';
// $Db_Name = 'rwd_v3'; 

include 'standalone_simplehtmldom.php';
include 'layoutv3/dom5.php';

@session_start();

if(
	isset($_POST['captcha']) and $_POST['captcha'] != '' and $_POST['captcha'] == $_SESSION['cssv5_captcha'] 
	and isset($_POST['file_type']) and $_POST['file_type'] != ''
	and isset($_POST['result']) and $_POST['result'] != ''
){
	$filename = '';
	if($_POST['file_type'] == '1'){
		$filename = 'css/style.css';
	} elseif($_POST['file_type'] == '2'){
		$filename = 'css/skin/theme.css';
	}

	if($filename != ''){
		@unlink($filename);
		file_put_contents($filename, $_POST['result']);
		@chmod($filename, 0777);
	}

	die;
}

$_SESSION['cssv5_captcha'] = substr(md5(microtime()),rand(0,26),15);

// 切換版型
if(isset($_GET['t']) and $_GET['t'] != ''){
	$file = 'css/skin/theme.w'.$_GET['t'].'.scss';
	if(file_exists($file)){
		copy($file, 'css/skin/theme.scss');
	}
}

$imports['config'] = file_get_contents('css/config.scss');
$tmps = explode("\n", $imports['config']);
foreach($tmps as $k => $v){
	// @charset "utf-8";
	if(preg_match('/^\@charset\ \"utf\-8\"\;$/', trim($v), $matches)){
		unset($tmps[$k]);
		break;
	}
}

$row = $cidb->where('is_enable',1)->get('scss_config')->row_array();
if($row and count($row) > 0){

	// 2016-10-07 下午，winnie所要增加的
	if(isset($row['googlefont_import']) and $row['googlefont_import'] != ''){
		foreach($tmps as $k => $v){
			// @import url(https://fonts.googleapis.com/css?family=Lato:400,300,100italic,300italic,100,400italic,700,700italic,900,900italic);
			if(preg_match('/^\@import(.*)fonts(.*)googleapis/', trim($v), $matches)){
				$tmps[$k] = $row['googlefont_import'];
				break;
			}
		}
	}

	unset($row['id']);
	unset($row['topic']);
	unset($row['googlefont_import']);
	unset($row['is_enable']);
	unset($row['create_time']);
	unset($row['update_time']);
	foreach($row as $k => $v){
		//if($k == 'grid-gutter-width') continue;
		if($k == 'googlefont'){
			// $googlefont:"Lato";  //非必填
			$tmps[] = '$'.$k.':"'.str_replace('"','',$v).'";'."\n";
		//} else {
		//} elseif($k == 'pageTitleDecoContent'){
		} elseif(preg_match('/^(pageTitleDecoContent|pageTitleDecoPath)$/', $k)){ // 加上雙引號
			$tmps[] = '$'.$k.':"'.$v.'";'."\n";
		} elseif($v != ''){
			$tmps[] = '$'.$k.':'.$v.';'."\n";
		}
	}
}

$imports['config'] = implode("\n", $tmps);
//var_dump($imports['config']);die;

$imports['style'] = file_get_contents('css/style.scss');
$tmps = explode("\n", $imports['style']);
foreach($tmps as $k => $v){
	// 參考@import "bootstrap";
	if(preg_match('/^\@import\ \"(.*)\"\;/', trim($v), $matches) and isset($imports[$matches[1]])){
		$tmps[$k] = $imports[$matches[1]];
	}

	// dry hack
	// content: "/\\00a0";  要改成=> content: "/ ";
	// content: "/\\\\00a0";
	if(preg_match('/content:\ "\/\\\\\\\\00a0/', $v)){
		$tmps[$k] = 'content: "/ ";';
	}
}

$imports['style'] = implode("\r\n", $tmps);
file_put_contents('css/styleg.scss', $imports['style']);
@chmod('css/styleg.scss', 0777);

/*
 * 繼續theme的編譯
 */

$imports['theme'] = file_get_contents('css/skin/theme.scss');
$tmps = explode("\r\n", $imports['theme']);
foreach($tmps as $k => $v){
	// 參考@import "bootstrap";
	if(preg_match('/^\@import\ \"\.\.\/config/', trim($v))){
		$tmps[$k] = $imports['config'];
	}
}
$imports['theme'] = implode("\r\n", $tmps);
file_put_contents('css/skin/themeg.scss', $imports['theme']);
@chmod('css/skin/themeg.scss', 0777);

/**
 * http://php.net/manual/en/function.scandir.php#109140
 *
 * Get an array that represents directory tree
 * @param string $directory     Directory path
 * @param bool $recursive         Include sub directories
 * @param bool $listDirs         Include directories on listing
 * @param bool $listFiles         Include files on listing
 * @param regex $exclude         Exclude paths that matches this regex
 */
function directoryToArray($directory, $recursive = true, $listDirs = false, $listFiles = true, $exclude = '') {
	$arrayItems = array();
	$skipByExclude = false;
	$handle = opendir($directory);
	if ($handle) {
		while (false !== ($file = readdir($handle))) {
			preg_match("/(^(([\.]){1,2})$|(\.(svn|git|hg|md))|(Thumbs\.db|\.DS_STORE))$/iu", $file, $skip);
			if($exclude){
				preg_match($exclude, $file, $skipByExclude);
			}
			if (!$skip && !$skipByExclude) {
				if (is_dir($directory. DIRECTORY_SEPARATOR . $file)) {
					if($recursive) {
						$arrayItems = array_merge($arrayItems, directoryToArray($directory. DIRECTORY_SEPARATOR . $file, $recursive, $listDirs, $listFiles, $exclude));
					}
					if($listDirs){
						$file = $directory . DIRECTORY_SEPARATOR . $file;
						$arrayItems[] = $file;
					}
				} else {
					if($listFiles){
						$file = $directory . DIRECTORY_SEPARATOR . $file;
						$arrayItems[] = $file;
					}
				}
			}
		}
		closedir($handle);
	}
	return $arrayItems;
}

$filelists = directoryToArray('css',true,false,true,'/websites/');
if($filelists and count($filelists) > 0){
	foreach($filelists as $k => $v){
		if(preg_match('/^css\/(.*)$/', $v, $matches)){
			$filelists[$k] = $matches[1];
		}
	}
}
$filelist = implode(',', $filelists);

?>
<html>
<head>
<title>CSS Compiler version5</title>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="sass.js-0.10.7/dist/sass.js"></script>
<script>
	var sass = new Sass();
	sass.options({
		style: Sass.style.compressed,
		comments: false,
	});

	var files = '<?php echo $filelist?>';
	sass.preloadFiles('../../../css/', '', files.split(","), function() {
		sass.compileFile('styleg.scss', function(result) {                  
			console.log(result);
			$.ajax({
				type: "POST",
				data: {
					'captcha': '<?php echo $_SESSION['cssv5_captcha']?>',
					'file_type': '1',
					'result': result.text
				},
				url: 'cssv5.php',
				success: function(response){
					$('#style').html('success');
				}
			}); // ajax
		});

		sass.compileFile('skin/themeg.scss', function(result) {                  
			console.log(result);
			$.ajax({
				type: "POST",
				data: {
					'captcha': '<?php echo $_SESSION['cssv5_captcha']?>',
					'file_type': '2',
					'result': result.text
				},
				url: 'cssv5.php',
				success: function(response){
					$('#theme').html('success');
				}
			}); // ajax
		});
	});
</script>
</head>
<body>
	<a href="index.php">Go Home</a> <b>style:</b><span id="style">process...</span>, <b>theme</b>: <span id="theme">process...</span>
</body>
</html>

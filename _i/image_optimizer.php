<?php

/*
 * 2017-12-21 無損壓縮
 * https://github.com/psliwa/image-optimizer
 * https://mozjpeg.codelove.de/binaries.html
 *
 * 伺服器請安裝以下的套件：
 * APT
 *	   libjpeg-progs
 *	   jpegoptim
 *	   pngquant
 *	   optipng
 *	   pngcrush
 *	   gifsicle
 *
 * 這個要另外處理
 *	   pngout
 *	   advpng
 */

if(isset($_GET['src']) and $_GET['src'] != ''){
	require_once ('image-optimizer/vendor/autoload.php');
	$factory = new \ImageOptimizer\OptimizerFactory();

	// $options = array(
	// 	'ignore_errors' => false,
	// 	'jpegoptim_options' => array(
	// 		'--strip-all', 
	// 		'--all-progressive'
	// 	),
	// 	'jpegtran_options' => array(
	// 		'-optimize', 
	// 		'-progressive'
	// 	),
	// );
	// $factory = new \ImageOptimizer\OptimizerFactory($options, $logger);

	$optimizer = $factory->get();
	// $optimizer = $factory->get('jpegoptim');

	$filepath = $_GET['src'];

	$optimizer->optimize($filepath);
	chmod($filepath,0777);
	//optimized file overwrites original one

}
die;

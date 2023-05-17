<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$_GET['code'] = 'code39';
$_GET['t'] = '40';
$_GET['r'] = '1';
$_GET['o'] = '1';
$_GET['f1'] = 'Arial.ttf';
$_GET['f2'] = '8';
$_GET['a1'] = '';
$_GET['a2'] = '';

if(isset($_GET['code']) && isset($_GET['t']) && isset($_GET['r']) && isset($_GET['text']) && isset($_GET['f1']) && isset($_GET['f2']) && isset($_GET['o']) && isset($_GET['a1']) && isset($_GET['a2'])) {
	require('barcode/BCGColor.php');
	require('barcode/BCGBarcode.php');
	require('barcode/BCGDrawing.php');
	require('barcode/BCGFont.php');

	if(include('barcode/BCGcode39.barcode.php')) {
		//if(include('class/BCG' . $_GET['code'] . '.barcode.php')) {
		if($_GET['f1'] !== '0' && $_GET['f1'] !== '-1' && intval($_GET['f2']) >= 1){
			$font = new BCGFont('barcode/font/'.$_GET['f1'], intval($_GET['f2']));
		} else {
			$font = 0;
		}
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255);
		$codebar = 'BCG'.$_GET['code'];
		$code_generated = new $codebar();
		if(isset($_GET['a1']) && intval($_GET['a1']) === 1) {
			$code_generated->setChecksum(true);
		}
		if(isset($_GET['a2']) && !empty($_GET['a2'])) {
			$code_generated->setStart($_GET['a2']);
		}
		if(isset($_GET['a3']) && !empty($_GET['a3'])) {
			$code_generated->setLabel($_GET['a3']);
		}
		$code_generated->setThickness($_GET['t']);
		$code_generated->setScale($_GET['r']);
		$code_generated->setBackgroundColor($color_white);
		$code_generated->setForegroundColor($color_black);
		$code_generated->setFont($font);
		$code_generated->parse($_GET['text']);
		$drawing = new BCGDrawing('', $color_white);
		$drawing->setBarcode($code_generated);
		$drawing->draw();
		if(intval($_GET['o']) === 1) {
			header('Content-Type: image/png');
		} elseif(intval($_GET['o']) === 2) {
			header('Content-Type: image/jpeg');
		} elseif(intval($_GET['o']) === 3) {
			header('Content-Type: image/gif');
		}

		$drawing->finish(intval($_GET['o']));
	}else{
		header('Content-Type: image/png');
		readfile('barcode/error.png');
	}
}else{
	header('Content-Type: image/png');
	readfile('barcode/error.png');
}



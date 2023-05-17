<?php

header("Content-type: text/javascript");

$seconds_to_cache = 3600;
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
header("Expires: $ts");
header("Pragma: cache");
header("Cache-Control: max-age=$seconds_to_cache");

// var_dump($_SERVER);

$aaa = $_SERVER['REQUEST_URI'];
$aaas = explode('/', $aaa);
$bbb = $aaas[count($aaas)-1];

// style.css
// echo $bbb;

$source = file_get_contents($bbb);

$url = "http://crm2.buyersline.com.tw/javascript-g-obfuscator.php";
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array("codeg"=>$source))); 
$dest = curl_exec($ch); 
curl_close($ch);

echo $dest;

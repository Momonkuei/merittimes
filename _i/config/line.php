<?php

$client_id = '';

$client_secret = '';

$return_url = urlencode(FRONTEND_DOMAIN.'/linelogin.php');

function mb_unserialize($str) {
    return preg_replace_callback('#s:(\d+):"(.*?)";#s',function($match){return 's:'.strlen($match[2]).':"'.$match[2].'";';},$str);
}  
<?php
if(!empty($_POST)){
  /*
  * 檢測連結是否是SSL連線
  * @return bool
  */
  session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota
  if(!function_exists('is_SSL')){
    function is_SSL(){
      if(!isset($_SERVER['HTTPS']))
        return FALSE;
      if($_SERVER['HTTPS'] === 1){  //Apache
        return TRUE;
      }elseif($_SERVER['HTTPS'] === 'on'){ //IIS
        return TRUE;
      }elseif($_SERVER['SERVER_PORT'] == 443){ //其他
        return TRUE;
      }
        return FALSE;
    }
  }
  if(is_SSL()){
    //設定cookie傳輸模式 by lota
    // $maxlifetime = ini_get('session.gc_maxlifetime');
    $secure = true; // if you only want to receive the cookie over HTTPS
    $httponly = true; // prevent JavaScript access to session cookie
    $samesite = 'None';
  
      if(PHP_VERSION_ID < 70300) {
          session_set_cookie_params(0, '/; samesite='.$samesite, str_replace('www','',$_SERVER['HTTP_HOST']), $secure, $httponly);
      } else {
          session_set_cookie_params([
              // 'lifetime' => $maxlifetime,
              'path' => '/',
              'domain' => str_replace('www','',$_SERVER['HTTP_HOST']),
              'secure' => $secure,
              'httponly' => $httponly,
              'samesite' => $samesite
          ]);
      }
  }
  session_start();
  //密鑰
  define('RECAPTCHA_V3_SECRET_KEY','6Le8Ag4iAAAAANgjtc6KX41x0Jo6JIkQOcxfLYPW');

  $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';

  $recaptcha_secret = RECAPTCHA_V3_SECRET_KEY; 

  unset($_SESSION['save']['google_token']);
  $recaptcha_response = $token;
  //Make and decode POST request:
  $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
  $recaptcha = json_decode($recaptcha);
  if($recaptcha->success==true){
    if($recaptcha->score >= 0.5){
      $_SESSION['save']['google_token']=true;
      echo '1';
    }
  }
}

?>
<?php
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
@session_start();
//$op=$_REQUEST["test"];
//$_SESSION["enter"]=false;
if (($_REQUEST["op"] == 'XXXXXX') || ($_SESSION['enter'] == true)){
  $_SESSION['enter'] = true;  
  ?>
    <script language="javascript">
  alert('Login Sucess');
  location.href='index.php';
  </script>
    <?
  header('Location: index.php');
    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <script>
      location.href='index.php';
    </script>";
  exit;
}else{
  if(!empty($_POST)){
    echo "Wrong Password！"; 
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>demo階段登入界面</title>
  <style>
    *,
    *:before,
    *:after {
      -webkit-box-sizing: border-box;
         -moz-box-sizing: border-box;
              box-sizing: border-box;
    }
    body{
      padding: 0;
      margin: 0;
      height:100vh;
      font-size: 16px;
      font-family:"Microsoft JhengHei";
      background: #4a7ab4;
      background: -moz-linear-gradient(45deg, #4a7ab4 0%, #64a59f 100%);
      background: -webkit-linear-gradient(45deg, #4a7ab4 0%,#64a59f 100%);
      background: linear-gradient(45deg, #4a7ab4 0%,#64a59f 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4a7ab4', endColorstr='#64a59f',GradientType=1 );
    }
    .main{
      position: absolute;
      left: 15px;
      right: 15px;
      top: 50%;
      -webkit-transform: translate(0, -50%);
      -ms-transform: translate(0, -50%);
      transform: translate(0, -50%);
      margin: auto;
    }
    form{
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      padding: 80px 50px;
      border-radius: 5px;
      background-color: rgba(255,255,255,0.6);

    }
    .title{
      color: #222222;
      font-size: 32px;
      font-weight: bold;
      text-align: center;
      margin-top: 0;
    }
    .input_txt{
      border: 0;
      width: 100%;
      padding: 15px;
      font-size: 16px;
      margin-bottom: 30px;
      background-color: #eeeeee;
    }
    .btn_send{
      color: #ffffff;
      font-size: 20px;
      padding: 10px;
      border: 0;
      width: 100%;
      border-radius: 30px;
      cursor: pointer;
      font-weight: bold;
      text-align: center;
      background-color: #4e5055;
      font-family:"Microsoft JhengHei";
    }
  </style>
</head>
<body>

  <div class="main">
    <form action="" method="post" name="main" id="main" >
      <p class="title">密碼</p>
      <input class="input_txt" type="text" name="op" value="" placeholder="請輸入密碼">
      <input class="btn_send" type="submit" name="" value="送出">
    </form>
  </div>



</body>
</html>

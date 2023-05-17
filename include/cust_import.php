<?php
die;

define("CODEOFFSET1",16);
define("CODEOFFSET2",24);
$key = 'Qa!aG@sfJg#hLj$k;q%w^e&*(';
define("KEY", $key);
//加密
function EncrptyPwd($paLogin,$paPwd)  
{
  if($paLogin=="") $paLogin="Buyersline";
  $piCode =dechex(strlen($paLogin)+CODEOFFSET2);
  $paRtn = $piCode;
  $piCode =dechex(strlen($paPwd)+CODEOFFSET1);
  $paRtn .= $piCode;
  $j=0;
  for($i=0;$i<strlen($paPwd);$i++)
  {
      $piCode=dechex(ord(substr($paPwd,$i,1))+CODEOFFSET1);	
      $piCode=(strlen($piCode) < 2)?"0".$piCode:$piCode;
      $paRtn .= $piCode;
      if($j < strlen($paLogin))
     {
         $piCode=dechex(ord(substr($paLogin,$j,1))+CODEOFFSET2);
         $piCode=(strlen($piCode) < 2)?"0".$piCode:$piCode;
         $paRtn .= $piCode;
         $j++;
     }	  	
  }
  $paRtn = substr($paRtn,8,9999). substr($paRtn,0,8);
   return $paRtn;
}
//解密
function CrptyPwd($paPwd) 
{
  $paPwd = substr($paPwd,-8,9999). substr($paPwd,0,-8);
  $paLogin_length = hexdec(substr($paPwd,0,2))-CODEOFFSET2; //帳號長度
  $paRtn_length = hexdec(substr($paPwd,2,2))-CODEOFFSET1;   //密碼長度
  $paRtn="";
  
  $tmp_str=substr($paPwd,4);
  $i = 0;
  if($paLogin_length >= $paRtn_length){
    
      while ($i < strlen($tmp_str))
      {
        $paRtn.= chr(hexdec(substr($tmp_str,$i,2))-CODEOFFSET1);
        $i+=4;
      }
  
  }else{
    $j = 0;
      while ($i < $paLogin_length*2)
      {
        $paRtn.= chr(hexdec(substr($tmp_str,$j,2))-CODEOFFSET1);
        $i+=2;
        $j+=4;
      }
      while ($j< strlen($tmp_str))
      {
        $paRtn.= chr(hexdec(substr($tmp_str,$j,2))-CODEOFFSET1);
        $j+=2;
      }  
  }
  return $paRtn;
}

	//資料連結 V3架構
	$aaa = file_get_contents('../_i/config/db.php');
	$aaa = str_replace('aaa_','gggaaa_',$aaa);
	eval('?'.'>'.$aaa);
	$Db_Server = gggaaa_dbhost;
	$Db_User = gggaaa_dbuser;
	$Db_Pwd = gggaaa_dbpass;
	$Db_Name = gggaaa_dbname; 
	
	$tmps = array(
		'dbdriver' => 'mysql',
		'username' => $Db_User,
		'password' => $Db_Pwd,
		'hostname' => $Db_Server,
		'port' => 3306,
		'database' => $Db_Name,
		//'db_debug' => TRUE,
	);
	include_once 'ci.php';
	$ggg = ggg_load_database($tmps, true);


// 測試資料庫連線是否正常
	$rows = $ggg->get('customer_old')->result_array();
// 	var_dump($rows);die;

    foreach($rows as $k => $v){
        
        $save = array(
            'id' => $v['CustNo'],
            'login_account' => $v['LoginID'],
            'login_password' => CrptyPwd($v['password']),
            'name' => $v['name'],
            'email' => $v['email'],
            'gender' => ($v['sex']=='M')?'1':'2',
            'birthday' => $v['birthday'],
            'phone' => CrptyPwd($v['mobile']),
            'addr_county' => $v['county'],
            'addr_district' => $v['district'],
            'addr_zipcode' => $v['zip'],
            'addr' => $v['address'],
            'create_time' =>$v['create_date'],
            'is_enable' => 1,
            'need_dm' => 1,
        );
        
        $ggg->insert('customer',$save);
    }
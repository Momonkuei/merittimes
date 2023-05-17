<?php
  
  class classAllPay{
  protected $ShoppingCar;
  protected $CustNo;
  protected $OrderNo;
  protected $type;
  protected $Config;
  protected $DB;
  protected $WebSet;
  protected $oPayment;
  protected $CreditNum;
  protected $CashflowType;
  //private $DB1;

    function __construct($Config,$WebSet,$Total=0,$cashflowtype=null,$lang=""){
      global $Db_Server,$Db_User,$Db_Pwd,$Db_Name;
      $this ->DB = new proc_DB($Db_Server,$Db_User,$Db_Pwd,$Db_Name); 
      $this ->CashflowType = $cashflowtype;
     
      $this ->ShoppingCar = $_SESSION['{$lang}ShoppingCar'];
      $this ->Total =$Total;
      $this ->OrderNo=$_SESSION['OrderNo'];
      $this ->Config=$Config;
      $this ->WebSet = $WebSet;
      if($_SESSION['CreditNum']){
        $this -> CreditNum =$_SESSION['CreditNum'];
      }

      if($_SESSION['Payment']=="3"){
        $this ->type="CVS";
      }
      else if($_SESSION['Payment']=="1"){
        $this ->type="Credit";
      }
      else if($_SESSION['Payment']=="10"){
        $this ->type="ATM";
      }
      else if($_SESSION['Payment']=="5"){
         $this ->type="UnionPay";
      }
      //showlog($this->DB);
      //設定website_setting
    
        
      
    }

    function checkout($lang=""){
      switch ($this ->CashflowType) {
        case '1':
          $this ->allpaycheckout();
          break;
        case '2':
          $this ->catcheckout();
          break;
        case '3':
          $this ->esuncheckout();
          break;
        case '4':
          $this ->esafecheckout();
          break;
        case '5':
          $this ->paypalcheckout();
          break;
        case '6':
          $this ->firstbankcheckout();
          break;
        default:
         
          break;
      }
    

      
    }


    function GetMsg($Data,$t,$c,$lang=""){

     
    
      if($t=="Credit" && $c=="cat"){
        $tradecode=$Data['ret'];
        if($tradecode == "OK"){
          $RtnMsg="交易成功";
          $status=1;
        }
        else{
          $RtnMsg="交易失敗";
          $status=0;
        }
        $tmpAry=explode("A", $Data['cust_order_no']);
        $OrderNo=$tmpAry[1];
        $TradeAmt=$Data['order_amount'];
        $PaymentDate=$Data['acquire_time'];
        $TradeNo=$Data['auth_code'];
        $last5=$Data['card_no'];
        $payamt= $TradeAmt;
        $sql="UPDATE `order` SET notepay=1,payamt='$payamt',status='$status',paymentdate='$PaymentDate',rtnmsg='$RtnMsg',rtncode='$tradecode',tradeamt='$TradeAmt',tradeno='$TradeNo' where orderno='$OrderNo'";
        $res=$this ->DB->query($sql);
      }
      else if(($t=="CVS" || $t=="ATM")  && $c=="cat"){
        $tradecode=$Data['status'];
        if($tradecode == "OK"){
          $RtnMsg="交易成功";
          $status=1;
        }
        else{
          $RtnMsg="交易失敗";
          $status=0;
        }
        $tmpAry=explode("A", $Data['order']['cust_order_number']);
        $OrderNo=$tmpAry[1];
        $TradeAmt=$Data['order']['order_amount'];
        $expiredate=str_replace("+08:00", "", str_replace("T", " ", $Data['order']['expire_date']));
        $paymenttypechargefee  =$Data['order']['cs_fee'];
        if($t=="CVS"){
          $paymentno=$Data['order']['ibon_shopid'].$Data['order']['ibon_code'];
        }
        else{
          $paymentno=$Data['order']['virtual_account'];
        }

       
        $sql="UPDATE `order` set notepay=1,status='$status',tradeamt='$TradeAmt',expiredate='$expiredate',paymenttypechargefee='$paymenttypechargefee',paymentno='$paymentno' WHERE orderno='$OrderNo'";

        $res=$this ->DB->query($sql);
      }
      else if($t=="Credit" && $c=="esun"){
        if($Data['RC'] !="00"){
          echo '<script>alert("刷卡失敗，系統將自動重新交易")</script>';
          $this ->checkout($lang);
        }
        else{
          foreach ($Data as $key => $value) {
            $str.=$key."=>".$value."|";
          }
          $sql="INSERT inTO log (log) values ('$str')";
          $this ->DB ->query($sql);
          $tO=explode("A", $Data['ONO']);
          $OrderNo=$tO[1];
          $PaymentDate=substr($Data['LTD'], 0,4)."-".substr($Data['LTD'], 4,2)."-".substr($Data["LTD"],6,2)." ".substr($Data['LTT'],0,2).":".substr($Data['LTT'], 2,2).":".substr($Data['LTT'], 4,2);
          $RtnCode=$Data['RC'];
          $RtnMsg=$Data['RC']=="00"?"交易成功":"交易失敗";
          $TradeAmt=$this ->Total;
          $merchantID=$Data['MID'];
          $TradeNo=$Data['RRN'];
          $CreditNo=$Data['AN'];
          $sql="UPDATE `{$lang}order` SET notepay=1,payamt='$TradeAmt',paymentdate='$PaymentDate',rtncode='$RtnCode',rtnmsg='$RtnMsg',tradeamt='$TradeAmt',merchantID='$merchantID',tradeno='$TradeNo',creditno='$CreditNo' WHERE orderno='$OrderNo'";
          
          $res=$this ->DB->query($sql);
        }
      }
      else if($t=="Credit" && $c=="esafe"){
        $tO=explode("A", $Data['Td']);
        $status=$Data['errmsg']=='00'?"1":"0";
        $OrderNo=$tO[1];
        $PaymentDate=date('Y-m-d H:i:s');
        $RtnCode=$Data['errcode'];
        $RtnMsg=$Data['errmsg'];
        $merchantID=$Data['web'];
        $TradeNo=$Data['buysafeno'];
        $TradeAmt=$Data['MN'];
        $CreditNo=$Data['Card_NO'];
        $sql="UPDATE `{$lang}order` SET notepay=1,status='$status',payamt='$TradeAmt',paymentdate='$PaymentDate',rtncode='$RtnCode',rtnmsg='$RtnMsg',tradeamt='$TradeAmt',merchantID='$merchantID',tradeno='$TradeNo',creditno='$CreditNo' WHERE orderno='$OrderNo'";
         $res=$this ->DB->query($sql);
      }
      else if($t=="Credit" && $c="First"){
        $status = $Data['status']=="0"?"1":"0";
        $OrderNo = $Data['lidm'];
        $PaymentDate = $Data['authRespTime'];
        $RtnCode = $Data['status'];
        $RtnMsg = $Data['status']=="0"?"交易成功":"交易失敗";
        $merchantID = $Data['merID'];
        $TradeNo = $Data['authCode'];
        $TradeAmt = $Data['authAmt'];
        $CreditNo = $Data['pan'];
         $sql="UPDATE `{$lang}order` SET notepay=1,status='$status',payamt='$TradeAmt',paymentdate='$PaymentDate',rtncode='$RtnCode',rtnmsg='$RtnMsg',tradeamt='$TradeAmt',merchantID='$merchantID',tradeno='$TradeNo',creditno='$CreditNo' WHERE orderno='$OrderNo'";
         $res=$this ->DB->query($sql);


      }
      return $res;
    }
    function CatrtnObj($obj){
      $tOrderNo=explode("A", $obj ->order_no);
      $OrderNo=$tOrderNo[1];
      $TradeAmt=$obj ->amount;
      $tStatus=$obj ->status;
      if($tStatus=="B"){
        $status=1;
        $rtnmsg="交易成功";
      }
      else if($tStatus=="C" || $tStatus=="D"){
        $rtnmsg="交易失敗";
        $status=4;
      }
      else{
        $rtnmsg="未付款";
        $status=0;
      }
      $PaymentDate=str_replace("T", " ", str_replace(" 08:00", "", $obj->modify_time));
      $sql="UPDATE `order` SET notepay=1,paymentdate='$PaymentDate',rtnmsg='$rtnmsg',payamt='$TradeAmt',tradecode='$tStatus',rtnmsg='$rtnmsg',status='$status' where orderno='$OrderNo'";
      $this ->DB ->query($sql);
    }
    function paypalcheckout(){
      if($this ->type == "Credit"){
        ?>
         

          <form action="<?=$this ->Config['Paypal']['URL']?>" method="post" id="PayPalForm" target="_top">
          <input type="hidden" name="business" value="<?=$this ->WebSet['PayPal']['Name']?>">
          <input type="hidden" name="cmd" value="_xclick">
          <input type="hidden" name="rm" value="2">
          <input type="hidden" name="return" value="<?=$this ->Config['Paypal']['RETURN']."?ONo=".$_SESSION['OrderNo']."&payment=".$_SESSION['Payment']?>">
          <input type="hidden" name="cancel_return" value="<?=$this ->Config['Paypal']['CANCEL']?>">
          <input type="hidden" name="custom" value="<?=$_SESSION['OrderNo']?>">
          <input type="hidden" name="item_name" value="訂單編號:<?=$_SESSION['OrderNo']?>款項">
          <input type="hidden" name="amount" value="<?=$this ->Total?>">
          <input type="hidden" name="currency_code" value="USD">
          <input type="hidden" name="undefined_quantity" value="1">

          </form>
          <script>
          document.getElementById("PayPalForm").submit();
          </script>
        <?php  
      }

    }
    function firstbankcheckout(){
      if($this ->type=="Credit"){
        ?>
          <form name="ecpay" method="post" action="<?=$this ->Config['facas']['URL']?>">
            <input type="hidden" name="MerchantID" value="<?=$this ->Config['facas']['MerchantID']?>">
            <input type="hidden" name="TerminalID" value="<?=$this ->Config['facas']['TerminalID']?>">
            <input type="hidden" name="merID" value="<?=$this ->Config['facas']['merID']?>">
            <input type="hidden" name="MerchantName" value="<?=$this ->Config['facas']['MerchantName']?>">
            <input type="hidden" name="purchAmt" value="<?=$row->Total?>">
            <input type="hidden" name="lidm" value="<?=$_SESSION['OrderNo']?>">
            <input type="hidden" name="AutoCap" value="0">
            <input type="hidden" name="AuthResURL" value="<?=$this ->Config['facas']['RETURN']?>">
          </form>

          <script>
            document.forms.ecpay.submit();
          </script>
        <?

      }

    }
    function esafecheckout($lang){
      if($this ->type =='Credit'){
      
        $ChkValue=sha1($this->WebSet['ESafeCredit']['Name'].$this->WebSet['ESafeCredit']['Content'].$this ->Total); 
        $ChkValue=strtoupper($ChkValue); //轉換為全部大寫 
          $NewNo=time()."A".$_SESSION['OrderNo'];
          ?>
            <form action="<?=$this ->Config['ESafe']['URL']?>" method="post" id="ESafe_Form" target="_top" >
              <input type="hidden" name="web" value="<?=urlencode($this->WebSet['ESafeCredit']['Name'])?>" />
              <input type="hidden" name="MN" value="<?=$this ->Total?>" /> <!--2.*交易金額--> 
              <input type="hidden" name="OrderInfo" value="<?=urlencode("您今日於本公司的消費總金額")?>" /> <!--3.交易內容--> 
              <input type="hidden" name="Td" value="<?=$NewNo?>" /> <!--4.商家訂單編號--> 
              <input type="hidden" name="sna" value="<?=urlencode($_SESSION['Name'])?>" /> <!--5.消費者姓名--> 
              <input type="hidden" name="sdt" value="<?=urlencode($_SESSION["R_TEL"])?>" /> <!--6.消費者電話--> 
              <input type="hidden" name="email" value="<?=urlencode($_SESSION['EMail'])?>"/> <!--7.消費者Email--> 
              <input type="hidden" name="note1" value="" /> <!--8.備註--> 
              <input type="hidden" name="note2" value="" /> <!--9.備註--> 
              <input type="hidden" name="Card_Type" value="" /> <!--10.交易類別--> 
              <input type="hidden" name="ChkValue" value="<?=$ChkValue?>" />    <!--11.交易檢查碼--> 
             
            </form>
            <script>
            document.getElementById("ESafe_Form").submit();
            </script>
          <?
      }
    }
    function esuncheckout($lang){

       if($this ->type=='Credit'){
        $NewNo=time()."A".$_SESSION['OrderNo'];
        $Rtnurl=$this ->Config['ESun']['ESUN_BACKURL'];
       // $Rtnurl=$lang=="tw_"?$this ->Config['ESun']['ESUN_BACKURL_tw']:$this ->Config['ESun']['ESUN_BACKURL_cn'];
        $MD5M=md5($this->WebSet['EsunCredit']['Name']."&&EC000001&".$NewNo."&".$this ->Total."&".$Rtnurl."&".$this->WebSet['EsunCredit']['Content']);
        //$MD5M=md5($this->WebSet['EsunCredit']['Name']."&&EC000001&".$NewNo."&".$this ->Total."&".$this ->Config['ESun']['ESUN_BACKURL']."&".$this->WebSet['EsunCredit']['Content']);
       
        ?>
          <form action="<?=$this ->Config['ESun']['ESUN_URL']?>" method="post" id="ESUN_Form" target="_top" >
            <input type="hidden" name="MID" value="<?=$this->WebSet['EsunCredit']['Name']?>">
            <input type="hidden" name="CID" value="">
            <input type="hidden" name="TID" value="EC000001">
            <input type="hidden" name="ONO" value="<?=$NewNo?>">
            <input type="hidden" name="TA" value="<?=$this ->Total?>">
            <input type="hidden" name="U" value="<?=$Rtnurl?>">
        
            <input type="hidden" name="M" value="<?=$MD5M?>">

          </form>
          <script>
            document.getElementById("ESUN_Form").submit();
          </script>
        <?
      }
      else if($this ->type=="ATM"){

        $tString=str_split($this->WebSet['EsunCredit']['Name'].sprintf("%08d",$_SESSION['OrderNo']));
        $tTotal=str_split(sprintf("%08d",$this ->Total));
        $check1=$tString[0]*6+$tString[1]*5+$tString[2]*4+$tString[3]*3+$tString[4]*2+$tString[5]*8+$tString[6]*7+$tString[7]*6+$tString[8]*5+$tString[9]*4+$tString[10]*3+$tString[11]*2+$tString[12]*1;
        $check2=$tTotal[0]*8+$tTotal[1]*7+$tTotal[2]*6+$tTotal[3]*5+$tTotal[4]*4+$tTotal[5]*3+$tTotal[6]*2+$tTotal[7]*1;
        $tcheckAry=str_split($check1+$check2);
        $checkcode=end($tcheckAry);
        $cString=implode("", $tString).$checkcode;
        $sql="UPDATE `order` set atmno='$cString' WHERE OrderNo='".$_SESSION['OrderNo']."'";
        $DB->query($sql);
        $_SESSION['ATMNo']=$cString;
      }
       else if($this ->type == "AliPay"){
        $pno=$_SESSION['OrderNo'];
        $ntd=$this->Total;
        $validate_method="sign";
        $ttime=date("Ymdhis");
        $seller_id=$this ->Config['AliPay']['SellerID'];
        $return_url = $this ->Config['AliPay']['ReturnURL'];
        $HASHKey = $this ->Config['AliPay']['HashKey'];
       
        //計算物品總數
        $count=0;
    
        if($_SESSION['ShoppingCar_cn']){
          foreach ($_SESSION['ShoppingCar_cn'] as $key => $value){
            if(is_array($value) && $value['ProductNo'] !=""){
              $count++;
              $Ppid[]=$value['ProductNo'];
              $Pqty[]=$value['Quantity'];
            } 
          } 
        } 
       
        $sha=$count.$ntd.implode("", $Ppid).$pno.implode("", $Pqty).$return_url.$seller_id.$ttime.$validate_method.$HASHKey;

        $pcode=SHA1($sha); 
        //$pcode= SHA1( $count. $ntd.$pid0.$pname.$pno. $qty0.$receiver .$return_url. $seller_id. $ttime. $validate_method. $HASHKey);
        ?>

          <form action="<?=$this ->Config['AliPay']['URL']?>" method="POST" target="_top"  id="AliPayForm"> 
            商家代號<input type="text" name="seller_id" value="<?php echo $this ->Config['AliPay']['SellerID']?>"> <br/>
            交易編號<input type="text" name="pno" value="<?php echo $pno;?>"><br/>
            交易金額<input type="text" name="ntd" value="<?php echo $ntd;?>"><br/>
            交易時間<input type="text" name="ttime" value="<?php echo $ttime; ?>"><br/>
            驗證參數<input type="text" name="validate_method" value="<?php echo $validate_method; ?>"><br/>
            項目總數<input type="text" name="count" value="<?=$count?>"><br/>
             
  
            <?
            
              foreach ($Ppid as $key => $value) {

                ?>
                  商品編號<input type="text" name="pid<?=$key?>" value="<?=$value?>"><br/>
                  商品數量<input type="text" name="qty<?=$key?>" value="<?=$Pqty[$key]?>"><br/>
                <?
              }
            ?>
           
            導回網頁<input type="text" name="return_url" value="<?php echo  $return_url;?>"><br/>
            Hash驗證碼1<input type="text" name="pcode" value="<?php echo $pcode;?>"><br/>
            <p></p>
          </form>
          <script>
            document.getElementById("AliPayForm").submit();
          </script>
        ?><?

      }
    }
    function catcheckout(){
      $Nowdate=date('Y-m-d H:i:s');
       $chk=md5($this ->WebSet['CatCredit']['Content']."$".$this->Total."$".$Nowdate);
      if($this ->type =="Credit"){
        

                 //$chk=md5($this ->WebSet['CatCredit']['Content']."$1$".$Nowdate);
        ?>
            <form action='<?=$this ->Config['Cat']['CreditURL']?>' id="mainForm" method="POST" target="_top">
              <input type='hidden' name='link_id' value='<?=$this ->WebSet['CatCredit']['Name']?>'> 
              <input type='hidden' name='cust_order_no' value='<?=$_SESSION['No']?>'> 
            
              <input type='hidden' name='order_amount' value='<?=$this ->Total?>'> 
              <input type='hidden' name='order_detail' value='您於本站本次消費金額'> 
              <input type='hidden' name='limit_product_id' value=''>
              <input type='hidden' name='send_time' value='<?=$Nowdate?>'> 
              <input type='hidden' name='chk' value='<?=$chk?>'> 
              <input type='hidden' name='return_type' value='redirect'> 
             
            </form>
            <script>
              document.getElementById("mainForm").submit();
            </script>
        <?
      }
      else if($this ->type=="CVS" || $this ->type=="ATM"){
         $ExpireDate=date('Y-m-d',strtotime("+8 day"));
         if($this ->type=="CVS"){
          $acc=$this ->WebSet['CatIbon']['Name'];
           $pass=$this ->WebSet['CatIbon']['Content'];
         } else if($this ->type=="ATM"){
         
          $acc=$this ->WebSet['CatATM']['Name'];
           $pass=$this ->WebSet['CatATM']['Content'];
         }
        
    //    $GETStr="?cmd=cvs_order_regiater&cust_id=CV2355386001&cust_password=CV2355386001SHN&cust_order_number=".$_SESSION['No']."&order_amount=".$this ->Total."&expire_date=".$ExpireDate."T00:00:00+08:00&payer_name=&payer_postcode=&payer_address=&payer_mobile=".$_SESSION["TEL"]."&payer_email=".$_SESSION["EMail"];
        ?>
          <form action="<?=$this ->Config['Cat']['CVSURL']?>" id="mainForm" method="POST" target="_top">
            <input type='hidden' name='cmd' value='cvs_order_regiater'> 
            <input type='hidden' name='cust_id' value='<?=$acc?>'> 
            <input type='hidden' name='cust_password' value='<?=$pass?>'>
            <input type='hidden' name='cust_order_number' value='<?=$_SESSION['No']?>'>
            <input type='hidden' name='order_amount' value='<?=$this ->Total?>'>
            <input type='hidden' name='expire_date' value='<?=$ExpireDate."T00:00:00+08:00"?>'>
             <input type='hidden' name='payer_name' value='<?=$_SESSION["Name"] ?>'>
             <input type='hidden' name='payer_postcode' value='<?=$_SESSION["R_ZIP"] ?>'>
            <input type='hidden' name='payer_address' value='<?=$_SESSION["R_Address"] ?>'>
            <input type='hidden' name='payer_mobile' value='<?=$_SESSION["R_TEL"] ?>'>
            <input type='hidden' name='payer_email' value='<?=$_SESSION["EMail"]?>'>

          </form>
             <script>
             document.getElementById("mainForm").submit();
            </script>
        <?
      }
      else if($this ->type=="UnionPay"){
        ?>
          <form action='<?=$this ->Config['Cat']['UnionPayURL']?>'  id="mainForm" method="POST" target="_top"> 
            <input type='hidden' name='link_id' value='<?=$this ->WebSet['CatCredit']['Name']?>'> 
            <input type='hidden' name='cust_order_no' value='<?=$_SESSION['No']?>'> 
            <input type='hidden' name='order_amount' value='<?=$this ->Total?>'> 
            <input type='hidden' name='order_detail' value='AAAAAf'> 
            <input type='hidden' name='limit_product_id' value=''> 
            <input type='hidden' name='send_time' value='<?=$Nowdate?>'> 
            <input type='hidden' name='chk' value='<?=$chk?>'> 
            <input type='hidden' name='return_type' value='redirect'> 
           
          </form>
           <script>
             document.getElementById("mainForm").submit();
            </script>
        <?
      }

    }
    function allpaycheckout($lang=""){
      $this ->oPayment = new AllInOne();
      $this ->oPayment->ServiceURL = $this ->Config['Allpay']['URL'];
      $this ->oPayment->HashKey =  $this ->Config['AllPay']['HashKey'];
      $this ->oPayment->HashIV = $this ->Config['AllPay']['HashIV'];
      $this ->oPayment->MerchantID =$this ->Config['AllPay']['MerchantID'];
      
      //基本參數
      $this ->oPayment->Send['ClientBackURL'] = $this->Config['Allpay']['client_back_url']."&g=allpay&t=".$this ->type;
      $this ->oPayment->Send['MerchantTradeNo'] =time()."A".$_SESSION['OrderNo'];
      $this ->oPayment->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
      $this ->oPayment->Send['TotalAmount'] = (int) $this ->Total;
      $this ->oPayment->Send['TradeDesc'] =  "您於本站本次的交易名細";
      if($this ->type =="CVS"){
          $this ->oPayment->Send['ReturnURL'] = $this->Config['Allpay']['CVS_back_url'];
          $this ->oPayment->Send['ChoosePayment'] = PaymentMethod::CVS;
          $this ->oPayment->SendExtend['PaymentInfoURL'] = $this ->Config['Allpay']['CVS_back_url'];
          
      if($_SESSION['ShoppingCar_Success']){
       // foreach ($_SESSION['ShoppingCar_Success'] as $key => $value) {
          //if(!empty($value['ProductNo'])){
            array_push($this ->oPayment->Send['Items'], array('Name' =>"網路購物商品", 'Price' => (int)$this->Total,'Currency' => "元", 'Quantity' =>"1", 'URL' => ""));
          //}
        //}
        
      } 
/*
            print("<pre>");
            print_r($this ->oPayment->SendExtend);
            print("</pre>");
            */
  
      }
      else if($this -> type =="Credit"){
        $this ->oPayment->Send['ChoosePayment'] = PaymentMethod::Credit;
        $this ->oPayment ->Send['ReturnURL'] = $this->Config['Allpay']['return_url'];
       if($this ->CreditNum >0 && $this ->CreditNum !=""){
          $this ->oPayment ->Send['ReturnURL'] = $this->Config['Allpay']['return_url'];
          $this ->oPayment ->SendExtend['CreditInstallment']=(int)$this->CreditNum;
          $this ->oPayment ->SendExtend['InstallmentAmount']=(int) $this ->Total;
        }
      }
      else if($this ->type=="ATM"){


        $this ->oPayment->Send['ReturnURL'] = $this->Config['Allpay']['atm_return_url'];
        $this ->oPayment->Send['ChoosePayment'] = PaymentMethod::ATM;
        $this ->oPayment->SendExtend['PaymentInfoURL'] = $this->Config['Allpay']['atm_return_url'];
      }
      $this ->oPayment->Send['Remark'] = "";

      $this ->oPayment->Send['ChooseSubPayment'] = PaymentMethodItem::None;
      $this ->oPayment->Send['NeedExtraPaidInfo'] = ExtraPaymentInfo::No;
    //  print_r($_SESSION['ShoppingCar']);
      if($_SESSION['ShoppingCar']){
        //foreach ($_SESSION['ShoppingCar'] as $key => $value) {
          //if(!empty($value['ProductNo'])){
            array_push($this ->oPayment->Send['Items'], array('Name' =>"網路購物商品", 'Price' => (int)$this->Total,'Currency' => "元", 'Quantity' =>"1", 'URL' => ""));
            
          //}
          
       // }
            


      } 

     // print_r($this ->oPayment);
     $_SESSION['ShoppingCar'] = null;
     $_SESSION['ShoppingCar_gift'] = null;
    /*
            print("<pre>");
            print_r($this ->oPayment->Send);
            print("</pre>");
    die;  */      
      $this ->oPayment->CheckOut();
    }
  
  }

//開發者愛用的資料庫方式，無義意
class proc_DB
 {
  var $dbhost = DB_HOST;
  var $dbuser = DB_USER;
  var $dbpwd = DB_PWD;
  var $dbname = DB_NAME;
  var $lid = 0;                // Link ID for database connection
  var $qid = 0;                // Query ID for current query
  var $row;                    // Current row in query result set
  var $record = array();       // Current row record data
  var $err_msg = "";       // deafult err msg
  var $error = "";             // Error Message
  var $errno = "";             // Error Number
  var $pflag=0;                //預設為 pconnect
  var $lastamount=0;           //最後query取得的資料筆數
  var $sqlstr = "";            //最後query的sql語法,偵錯用

  function proc_DB($host='',$user='',$pwd='',$dbname='')
  {
   if(!empty($host))
   {
    $this->dbname = $dbname;
    $this->dbhost = $host;
    $this->dbuser = $user;
    $this->dbpwd = $pwd;
   }
  }
  
  function connect($test = 0, $connect_flag=1)
  {
  global $debug;
  $err = 'Could not connect DB!!';
  if($debug)
  {
    $err .= $this->dbhost .", ".$this->dbuser." - ".$this->sqlstr." - ".$_SERVER['PHP_SELF'];
  }
   if($this->lid == 0)
   {
   //if ($connect_flag)
   //{
    $this->lid = @mysql_connect($this->dbhost,$this->dbuser,$this->dbpwd,$connect_flag);
    if(!$this->lid)
     {
      if($test)
      {
        return false;
      }else{
        if($debug)
        {
          die($err);
        }else{
          $this->wFile($msg);
        }
      }
     }
    $pflag=0;
    mysql_query("set Names 'utf8'");
  /*}else{
    $this->lid = @mysql_pconnect($this->dbhost,$this->dbuser,$this->dbpwd);
    if(!$this->lid)
    {
      if($test)
      {
        return false;
      }else{
        die($err);
      }
    }
    $pflag=1;
    mysql_query("set Names 'utf8'");
   }*/

    if(!$this->lid)
     $this->halt($err);
    if (!@mysql_select_db($this->dbname,$this->lid))
    {
     $this->halt($err);
     return 0;
    }
   }
   return $this->lid;
  }

  function query($qstr,$action=0)
  {
   global $DB_SHOW_SQL,$DB_PCONNECT;
   if(empty($qstr))  return 0;
   if($DB_PCONNECT)
   {
     if(!$this->connect(0,0))    return 0;
   }else{
     if(!$this->connect())    return 0;
   }
   
   if($this->qid)
   {
    @mysql_free_result($this->qid);
    $this->qid = 0;
   }
   $this->sqlstr = $qstr;
   if($DB_SHOW_SQL) echo $qstr;
   $qstr = str_replace('--','',$qstr);
   //$qstr = str_replace('\\', '\\\\', $qstr);
   $this->qid = @mysql_db_query($this->dbname,$qstr, $this->lid);
   $this->row   = 0;
   $this->errno = mysql_errno();
   $this->error = mysql_error();
   if (!$this->qid) {
     if($DB_SHOW_SQL) {
       echo "Invalid SQL: ".$qstr;
     } else {
       $this->halt("Invalid SQL: ".$qstr);
     }
   }
   $this->lastamount = @mysql_num_rows($this->qid);
   if($action)
    $this->next_record();
   return $this->qid;
  }

  function show_sql() {
    return $this->sqlstr;
  }

  function muti_query($qstr_arr)
  {
   if(empty($qstr_arr))  return 0;
   if(!$this->connect())    return 0;
   if($this->qid)
   {
    @mysql_free_result($this->qid);
    $this->qid = 0;
   }
   for($i=0; $i<count($qstr_arr); $i++)
   {
  $aqstr = $qstr_arr[$i];
    $this->qid = @mysql_db_query($this->dbname,$aqstr, $this->lid);
    $this->row   = 0;
    $this->errno = mysql_errno();
    $this->error = mysql_error();
    if (!$this->qid)
     $this->halt("Invalid SQL: ".$aqstr);
   }
   $this->next_record();
   $lastamount = @mysql_num_rows($this->qid);
   return $this->qid;
  }

function un_query($aqstr)
{
  if(empty($aqstr))  return 0;
  if(!$this->connect())    return 0;
  if($this->qid)
  {
    @mysql_free_result($this->qid);
    $this->qid = 0;
  }
  $qstr = implode(" union ",$aqstr);
  $this->qid = @mysql_db_query($this->dbname,$qstr, $this->lid);
  $this->row   = 0;
  $this->errno = mysql_errno();
  $this->error = mysql_error();
  if (!$this->qid) {
    if($DB_SHOW_SQL) {
      echo "Invalid SQL: ".$qstr;
    } else {
      $this->halt("Invalid SQL: ".$qstr);
    }
  }
  $this->lastamount = @mysql_num_rows($this->qid);
  if($action)
    $this->next_record();
  return $this->qid;
  }

  function get_total_data($qfield='')
  {
   $count = 0;
   while($this->next_record())
   {
    if(empty($qfield))
     $all_data[$count] = $this->record;
    else
     $all_data[$this->record[$qfield]] = $this->record;
    $count++;
   }
   return $all_data;
  }

  function next_record()
  {
   if(!$this->qid)
   {
//    $this->halt("next_record called with no query pending.");
    return false;
   }
   $this->record = @mysql_fetch_array($this->qid, MYSQL_ASSOC);
   $this->row   += 1;
   $this->errno  = mysql_errno();
   $this->error  = mysql_error();
   if(is_array($this->record))
    return true;
   else
   {
    @mysql_free_result($this->qid);
    $this->qid = 0;
    return false;
   }
  }

  function f($field_name)
  {
  return stripslashes($this->record[$field_name]);
  }
  function f2($field_name)
  {
   //return stripslashes(ereg_replace('&nbsp;', '', $this->record[$field_name]));
  return ereg_replace('&nbsp;', '', $this->record[$field_name]);
  }
  function sf($field_name)
  {
   global $vars, $default;

   if($vars["error"] and $vars["$field_name"])
  return $vars["$field_name"];
   else if($default["$field_name"])
    return $default["$field_name"];
   else
    return $this->record[$field_name];
  }

  function print_value($field_name)
  {
  print stripslashes($this->record[$field_name]);
  print $this->record[$field_name];
  }

  function sp($field_name)
  {
    global $vars, $default;

   if($vars["error"] and $vars["$field_name"])
    //print stripslashes($vars["$field_name"]);
    print $vars["$field_name"];
   else if($default["$field_name"])
    //print stripslashes($default["$field_name"]);
    print $default["$field_name"];
   else
    //print stripslashes($this->record[$field_name]);
    print $this->record[$field_name];
}

  function num_rows()
  {
   if($this->lid)
    return $this->lastamount;
   else
    return 0;
  }

  function halt($msg)
  {
  global $debug;
  $this->error = @mysql_error($this->lid);
  $this->errno = @mysql_errno($this->lid);
  if($this->error == "MySQL server has gone away")
  {
    $this->connect();
  }
  if ($this->err_msg) {
    return $this->err_msg;
  }else{
    if($debug)
    {
      printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
      printf("<b>MySQL Error</b>: %s (%s)<br>\n",$this->errno,$this->error);
      exit;
    }else{
      $msg = $msg."<br>\n".$this->error."<br>\n";
      $this->wFile($msg);
    }
  }
  }

  function record_count()
  {
  if($this->qid)
  {
    $this->record = @mysql_fetch_row($this->qid);
    return @count($this->record);
  }else{
    return 0;
  }
  }

  function record_list($num)
  {
  if ($this->record)
    return @mysql_field_name($this->qid,$num);
  else
    return 0;
  }

  function insert_id($qstr) {
  array_push($qstr,"SELECT last_insert_id() as id");
  $this->muti_query($qstr);
  return $this->f('id');
  }

  function query_up($qstr) {
  array_push($qstr,"SELECT ROW_COUNT() as num");
  $this->muti_query($qstr);
  return $this->f('num');
  }

  function close()
  {
   if($this->qid)
   {
    @mysql_free_result($this->qid);
    $this->qid = 0;
   }
   if ($pflag) return;
   if($this->lid)
   {
    @mysql_close($this->lid);
    $this->lid = 0;
   }
  }

  function dbVector($sql)
  {
  $this ->query($sql,1);
  return $this->record;
  }

  function wFile($msg, $file = "")
  {
    if(function_exists("writeLog"))
    {
      writeLog($msg,$file);
    }else{
      printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
      printf("<b>MySQL Error123</b>: %s (%s)<br>\n",$this->errno,$this->error);
      exit;
    }
  }
 }

 

/**
 * 付款方式。
 */
abstract class PaymentMethod {

    /**
     * 不指定付款方式。
     */
    const ALL = 'ALL';

    /**
     * 信用卡付費。
     */
    const Credit = 'Credit';

    /**
     * 網路 ATM。
     */
    const WebATM = 'WebATM';

    /**
     * 自動櫃員機。
     */
    const ATM = 'ATM';

    /**
     * 超商代碼。
     */
    const CVS = 'CVS';

    /**
     * 超商條碼。
     */
    const BARCODE = 'BARCODE';

    /**
     * 支付寶。
     */
    const Alipay = 'Alipay';

    /**
     * 財付通。
     */
    const Tenpay = 'Tenpay';

    /**
     * 儲值消費。
     */
    const TopUpUsed = 'TopUpUsed';

}

/**
 * 付款方式子項目。
 */
abstract class PaymentMethodItem {

    /**
     * 不指定。
     */
    const None = '';
    // WebATM 類(001~100)
    /**
     * 台新銀行。
     */
    const WebATM_TAISHIN = 'TAISHIN';

    /**
     * 玉山銀行。
     */
    const WebATM_ESUN = 'ESUN';

    /**
     * 華南銀行。
     */
    const WebATM_HUANAN = 'HUANAN';

    /**
     * 台灣銀行。
     */
    const WebATM_BOT = 'BOT';

    /**
     * 台北富邦。
     */
    const WebATM_FUBON = 'FUBON';

    /**
     * 中國信託。
     */
    const WebATM_CHINATRUST = 'CHINATRUST';

    /**
     * 第一銀行。
     */
    const WebATM_FIRST = 'FIRST';

    /**
     * 國泰世華。
     */
    const WebATM_CATHAY = 'CATHAY';

    /**
     * 兆豐銀行。
     */
    const WebATM_MEGA = 'MEGA';

    /**
     * 元大銀行。
     */
    const WebATM_YUANTA = 'YUANTA';

    /**
     * 土地銀行。
     */
    const WebATM_LAND = 'LAND';
    // ATM 類(101~200)
    /**
     * 台新銀行。
     */
    const ATM_TAISHIN = 'TAISHIN';

    /**
     * 玉山銀行。
     */
    const ATM_ESUN = 'ESUN';

    /**
     * 華南銀行。
     */
    const ATM_HUANAN = 'HUANAN';

    /**
     * 台灣銀行。
     */
    const ATM_BOT = 'BOT';

    /**
     * 台北富邦。
     */
    const ATM_FUBON = 'FUBON';

    /**
     * 中國信託。
     */
    const ATM_CHINATRUST = 'CHINATRUST';

    /**
     * 第一銀行。
     */
    const ATM_FIRST = 'FIRST';
    // 超商類(201~300)
    /**
     * 超商代碼繳款。
     */
    const CVS = 'CVS';

    /**
     * OK超商代碼繳款。
     */
    const CVS_OK = 'OK';

    /**
     * 全家超商代碼繳款。
     */
    const CVS_FAMILY = 'FAMILY';

    /**
     * 萊爾富超商代碼繳款。
     */
    const CVS_HILIFE = 'HILIFE';

    /**
     * 7-11 ibon代碼繳款。
     */
    const CVS_IBON = 'IBON';
    // 其他第三方支付類(301~400)
    /**
     * 支付寶。
     */
    const Alipay = 'Alipay';

    /**
     * 財付通。
     */
    const Tenpay = 'Tenpay';
    // 儲值/餘額消費類(401~500)
    /**
     * 儲值/餘額消費(歐付寶)
     */
    const TopUpUsed_AllPay = 'AllPay';

    /**
     * 儲值/餘額消費(玉山)
     */
    const TopUpUsed_ESUN = 'ESUN';
    // 其他類(901~999)
    /**
     * 超商條碼繳款。
     */
    const BARCODE = 'BARCODE';

    /**
     * 信用卡(MasterCard/JCB/VISA)。
     */
    const Credit = 'Credit';

    /**
     * 貨到付款。
     */
    const COD = 'COD';

}

/**
 * 額外付款資訊。
 */
abstract class ExtraPaymentInfo {

    /**
     * 需要額外付款資訊。
     */
    const Yes = 'Y';

    /**
     * 不需要額外付款資訊。
     */
    const No = 'N';

}

/**
 * 額外付款資訊。
 */
abstract class DeviceType {

    /**
     * 桌機版付費頁面。
     */
    const PC = 'P';

    /**
     * 行動裝置版付費頁面。
     */
    const Mobile = 'M';

}

/**
 * 信用卡訂單處理動作資訊。
 */
abstract class ActionType {

    /**
     * 關帳
     */
    const C = 'C';

    /**
     * 退刷
     */
    const R = 'R';

    /**
     * 取消
     */
    const E = 'E';

    /**
     * 放棄
     */
    const N = 'N';

}

/**
 * 定期定額的週期種類。
 */
abstract class PeriodType {

    /**
     * 無
     */
    const None = '';

    /**
     * 年
     */
    const Year = 'Y';

    /**
     * 月
     */
    const Month = 'M';

    /**
     * 日
     */
    const Day = 'D';

}

/**
 * 電子發票開立註記。
 */
abstract class InvoiceState {
    /**
     * 需要開立電子發票。
     */
  const Yes = 'Y';

    /**
     * 不需要開立電子發票。
     */
  const No = '';
}

/**
 * 電子發票載具類別
 */
abstract class CarruerType {
  // 無載具
  const None = '';
  
  // 會員載具
  const Member = '1';
  
  // 買受人自然人憑證
  const Citizen = '2';
  
  // 買受人手機條碼
  const Cellphone = '3';
}

/**
 * 電子發票列印註記
 */
abstract class PrintMark {
  // 不列印
  const No = '0';
  
  // 列印
  const Yes = '1';
}

/**
 * 電子發票捐贈註記
 */
abstract class Donation {
  // 捐贈
  const Yes = '1';
  
  // 不捐贈
  const No = '2';
}

/**
 * 通關方式
 */
abstract class ClearanceMark {
  // 經海關出口
  const Yes = '1';
  
  // 非經海關出口
  const No = '2';
}

/**
 * 課稅類別
 */
abstract class TaxType {
  // 應稅
  const Dutiable = '1';
  
  // 零稅率
  const Zero = '2';
  
  // 免稅
  const Free = '3';
  
  // 應稅與免稅混合(限收銀機發票無法分辦時使用，且需通過申請核可)
  const Mix = '9';
}

/**
 * 字軌類別
 */
abstract class InvType {
  // 一般稅額
  const General = '07';
  
  // 特種稅額
  const Special = '08';
}

abstract class EncryptType {
    // MD5(預設)
    const ENC_MD5 = 0;
    
    // SHA256
    const ENC_SHA256 = 1;
}

/**
 * AllInOne short summary.
 *
 * AllInOne description.
 *
 * @version 1.0
 * @author andy.chao
 */
class AllInOne {

    public $ServiceURL = 'ServiceURL';
    public $ServiceMethod = 'ServiceMethod';
    public $HashKey = 'HashKey';
    public $HashIV = 'HashIV';
    public $MerchantID = 'MerchantID';
    public $PaymentType = 'PaymentType';
    public $Send = 'Send';
    public $SendExtend = 'SendExtend';
    public $Query = 'Query';
    public $Action = 'Action';
    public $ChargeBack = 'ChargeBack';
    public $EncryptType = EncryptType::ENC_MD5;

    function __construct() {
        $this->AllInOne();
        $this->PaymentType = 'aio';
        $this->Send = array(
            "ReturnURL" => '',
            "ClientBackURL" => '',
            "OrderResultURL" => '',
            "MerchantTradeNo" => '',
            "MerchantTradeDate" => '',
            "PaymentType" => 'aio',
            "TotalAmount" => '',
            "TradeDesc" => '',
            "ChoosePayment" => PaymentMethod::ALL,
            "Remark" => '',
            "ChooseSubPayment" => PaymentMethodItem::None,
            "NeedExtraPaidInfo" => ExtraPaymentInfo::No,
            "DeviceSource" => DeviceType::PC,
            "IgnorePayment" => '',
            "PlatformID" => '',
            "InvoiceMark" => InvoiceState::No,
            "Items" => array(),
            "EncryptType" => EncryptType::ENC_MD5
        );
        $this->SendExtend = array(
            // ATM 延伸參數。
            "ExpireDate" => 3,
            // CVS, BARCODE 延伸參數。
            "Desc_1" => '', "Desc_2" => '', "Desc_3" => '', "Desc_4" => '',
            // ATM, CVS, BARCODE 延伸參數。
            "ClientRedirectURL" => '',
            // Alipay 延伸參數。
            "Email" => '', "PhoneNo" => '', "UserName" => '',
            // Tenpay 延伸參數。
            "ExpireTime" => '',
            // Credit 分期延伸參數。
            "CreditInstallment" => 0, "InstallmentAmount" => 0, "Redeem" => FALSE, "UnionPay" => FALSE,
            // Credit 定期定額延伸參數。
            "PeriodAmount" => '', "PeriodType" => '', "Frequency" => '', "ExecTimes" => '',
            // 回傳網址的延伸參數。
            "PaymentInfoURL" => '', "PeriodReturnURL" => '',
            // 電子發票延伸參數。
            "CustomerIdentifier" => '',
            "CarruerType" => CarruerType::None,
            "CustomerID" => '',
            "Donation" => Donation::No,
            "Print" => PrintMark::No,
            "CustomerName" => '',
            "CustomerAddr" => '',
            "CustomerPhone" => '',
            "CustomerEmail" => '',
            "ClearanceMark" => '',
            "CarruerNum" => '',
            "LoveCode" => '',
            "InvoiceRemark" => '',
            "DelayDay" => 0,
        );
        $this->Query = array(
            'MerchantTradeNo' => '', 'TimeStamp' => ''
        );
        $this->Action = Array(
            'MerchantTradeNo' => '', 'TradeNo' => '', 'Action' => ActionType::C, 'TotalAmount' => 0
        );
        $this->ChargeBack = Array(
            'MerchantTradeNo' => '', 'TradeNo' => '', 'ChargeBackTotalAmount' => 0, 'Remark' => ''
        );
    }

    function AllInOne() {
        
    }

    function CheckOut($target = "_top") {
        $szHtml = $this->CheckOutString(null, $target);

        print $szHtml;

        exit();
        die();
        flush();

        return;
    }

    function CheckOutString($paymentButton, $target = "_top") {
        // 變數宣告。
        $arErrors = array();
        $szHtml = '';
        $arParameters = null;

        $szItemName = '';
        $szAlipayItemName = '';
        $szAlipayItemCounts = '';
        $szAlipayItemPrice = '';
        $szInvoiceItemName = '';
        $szInvoiceItemCount = '';
        $szInvoiceItemWord = '';
        $szInvoiceItemPrice = '';
        $szInvoiceItemTaxType = '';
        $InvSptr = '|';
        // 檢查資料。
        if (strlen($this->ServiceURL) == 0) {
            array_push($arErrors, 'ServiceURL is required.');
        }
        if (strlen($this->ServiceURL) > 200) {
            array_push($arErrors, 'ServiceURL max langth as 200.');
        }
        if (strlen($this->HashKey) == 0) {
            array_push($arErrors, 'HashKey is required.');
        }
        if (strlen($this->HashIV) == 0) {
            array_push($arErrors, 'HashIV is required.');
        }
        if (strlen($this->MerchantID) == 0) {
            array_push($arErrors, 'MerchantID is required.');
        }
        if (strlen($this->MerchantID) > 10) {
            array_push($arErrors, 'MerchantID max langth as 10.');
        }

        if (strlen($this->Send['ReturnURL']) == 0) {
            array_push($arErrors, 'ReturnURL is required.');
        }
        if (strlen($this->Send['ClientBackURL']) > 200) {
            array_push($arErrors, 'ClientBackURL max langth as 10.');
        }
        if (strlen($this->Send['OrderResultURL']) > 200) {
            array_push($arErrors, 'OrderResultURL max langth as 10.');
        }

        if (strlen($this->Send['MerchantTradeNo']) == 0) {
            array_push($arErrors, 'MerchantTradeNo is required.');
        }
        if (strlen($this->Send['MerchantTradeNo']) > 20) {
            array_push($arErrors, 'MerchantTradeNo max langth as 20.');
        }
        if (strlen($this->Send['MerchantTradeDate']) == 0) {
            array_push($arErrors, 'MerchantTradeDate is required.');
        }
        if (strlen($this->Send['TotalAmount']) == 0) {
            array_push($arErrors, 'TotalAmount is required.');
        }
        if (strlen($this->Send['TradeDesc']) == 0) {
            array_push($arErrors, 'TradeDesc is required.');
        }
        if (strlen($this->Send['TradeDesc']) > 200) {
            array_push($arErrors, 'TradeDesc max langth as 200.');
        }
        if (strlen($this->Send['ChoosePayment']) == 0) {
            array_push($arErrors, 'ChoosePayment is required.');
        }
        if (strlen($this->Send['NeedExtraPaidInfo']) == 0) {
            array_push($arErrors, 'NeedExtraPaidInfo is required.');
        }
        if (strlen($this->Send['DeviceSource']) == 0) {
            array_push($arErrors, 'DeviceSource is required.');
        }
        if (sizeof($this->Send['Items']) == 0) {
            array_push($arErrors, 'Items is required.');
        }
        // 檢查 Alipay 條件。
        if ($this->Send['ChoosePayment'] == PaymentMethod::Alipay) {
            if (strlen($this->SendExtend['Email']) == 0) {
                array_push($arErrors, "Email is required.");
            }
            if (strlen($this->SendExtend['Email']) > 200) {
                array_push($arErrors, "Email max langth as 200.");
            }
            if (strlen($this->SendExtend['PhoneNo']) == 0) {
                array_push($arErrors, "PhoneNo is required.");
            }
            if (strlen($this->SendExtend['PhoneNo']) > 20) {
                array_push($arErrors, "PhoneNo max langth as 20.");
            }
            if (strlen($this->SendExtend['UserName']) == 0) {
                array_push($arErrors, "UserName is required.");
            }
            if (strlen($this->SendExtend['UserName']) > 20) {
                array_push($arErrors, "UserName max langth as 20.");
            }
        }
        // 檢查產品名稱。
        if (sizeof($this->Send['Items']) > 0) {
            foreach ($this->Send['Items'] as $keys => $value) {
                $szItemName .= vsprintf('#%s %d %s x %u', $this->Send['Items'][$keys]);
                $szAlipayItemName .= sprintf('#%s', $this->Send['Items'][$keys]['Name']);
                $szAlipayItemCounts .= sprintf('#%u', $this->Send['Items'][$keys]['Quantity']);
                $szAlipayItemPrice .= sprintf('#%d', $this->Send['Items'][$keys]['Price']);

                if (!array_key_exists('ItemURL', $this->Send)) {
                    $this->Send['ItemURL'] = $this->Send['Items'][$keys]['URL'];
                }
            }

            if (strlen($szItemName) > 0) {
                $szItemName = mb_substr($szItemName, 1, 200);
            }
            if (strlen($szAlipayItemName) > 0) {
                $szAlipayItemName = mb_substr($szAlipayItemName, 1, 200);
            }
            if (strlen($szAlipayItemCounts) > 0) {
                $szAlipayItemCounts = mb_substr($szAlipayItemCounts, 1, 100);
            }
            if (strlen($szAlipayItemPrice) > 0) {
                $szAlipayItemPrice = mb_substr($szAlipayItemPrice, 1, 20);
            }
        } else {
            array_push($arErrors, "Goods information not found.");
        }
        
        // 檢查電子發票參數
        if (strlen($this->Send['InvoiceMark']) > 1) {
            array_push($arErrors, "InvoiceMark max length as 1.");
        } else {
          if ($this->Send['InvoiceMark'] == InvoiceState::Yes) {
              // RelateNumber(不可為空)
              if (strlen($this->SendExtend['RelateNumber']) == 0) {
                  array_push($arErrors, "RelateNumber is required.");
              } else {
                  if (strlen($this->SendExtend['RelateNumber']) > 30) {
                      array_push($arErrors, "RelateNumber max length as 30.");
                  }
              }
              
              // CustomerIdentifier(預設為空字串)
              if (strlen($this->SendExtend['CustomerIdentifier']) > 0) {
                  if (strlen($this->SendExtend['CustomerIdentifier']) != 8) {
                      array_push($arErrors, "CustomerIdentifier length should be 8.");
                  }
              }
              
              // CarruerType(預設為None)
              if (strlen($this->SendExtend['CarruerType']) > 1) {
                  array_push($arErrors, "CarruerType max length as 1.");
              } else {
                  // 統一編號不為空字串時，載具類別請設定空字串
                  if (strlen($this->SendExtend['CustomerIdentifier']) > 0) {
                      if ($this->SendExtend['CarruerType'] != CarruerType::None) {
                          array_push($arErrors, "CarruerType should be None.");
                      }
                  }
              }
              
              // CustomerID(預設為空字串)
              if (strlen($this->SendExtend['CustomerID']) > 20) {
                  array_push($arErrors, "CustomerID max length as 20.");
              } else {
                  // 當載具類別為會員載具(Member)時，此參數不可為空字串
                  if ($this->SendExtend['CarruerType'] == CarruerType::Member) {
                      if (strlen($this->SendExtend['CustomerID']) == 0) {
                          array_push($arErrors, "CustomerID is required.");
                      }
                  }
              }
              
              // Donation(預設為No)
              if (strlen($this->SendExtend['Donation']) > 1) {
                  array_push($arErrors, "Donation max length as 1.");
              } else {
                  // 統一編號不為空字串時，請設定不捐贈(No)
                  if (strlen($this->SendExtend['CustomerIdentifier']) > 0) {
                      if ($this->SendExtend['Donation'] != Donation::No) {
                          array_push($arErrors, "Donation should be No.");
                      }
                  } else {
                      if (strlen($this->SendExtend['Donation']) == 0) {
                          $this->SendExtend['Donation'] = Donation::No;
                      }
                  }
              }

              // Print(預設為No)
              if (strlen($this->SendExtend['Print']) > 1) {
                  array_push($arErrors, "Print max length as 1.");
              } else {
                  // 捐贈註記為捐贈(Yes)時，請設定不列印(No)
                  if ($this->SendExtend['Donation'] == Donation::Yes) {
                      if ($this->SendExtend['Print'] != PrintMark::No) {
                          array_push($arErrors, "Print should be No.");
                      }
                  } else {
                      // 統一編號不為空字串時，請設定列印(Yes)
                      if (strlen($this->SendExtend['CustomerIdentifier']) > 0) {
                          if ($this->SendExtend['Print'] != PrintMark::Yes) {
                              array_push($arErrors, "Print should be Yes.");
                          }
                      } else {
                          if (strlen($this->SendExtend['Print']) == 0) {
                              $this->SendExtend['Print'] = PrintMark::No;
                          }
                          
                          // 載具類別為會員載具(Member)、買受人自然人憑證(Citizen)、買受人手機條碼(Cellphone)時，請設定不列印(No)
                          $notPrint = array(CarruerType::Member, CarruerType::Citizen, CarruerType::Cellphone);
                          if (in_array($this->SendExtend['CarruerType'], $notPrint) and $this->SendExtend['Print'] == PrintMark::Yes) {
                              array_push($arErrors, "Print should be No.");
                          }
                      }
                  }
                  
              }
              
              // CustomerName(UrlEncode, 預設為空字串)
              if (mb_strlen($this->SendExtend['CustomerName'], 'UTF-8') > 20) {
                  array_push($arErrors, "CustomerName max length as 20.");
              } else {
                  // 列印註記為列印(Yes)時，此參數不可為空字串
                  if ($this->SendExtend['Print'] == PrintMark::Yes) {
                      if (mb_strlen($this->SendExtend['CustomerName'], 'UTF-8') == 0) {
                          array_push($arErrors, "CustomerName is required.");
                      }
                  }
              }
              
              // CustomerAddr(UrlEncode, 預設為空字串)
              if (mb_strlen($this->SendExtend['CustomerAddr'], 'UTF-8') > 200) {
                  array_push($arErrors, "CustomerAddr max length as 200.");
              } else {
                  // 列印註記為列印(Yes)時，此參數不可為空字串
                  if ($this->SendExtend['Print'] == PrintMark::Yes) {
                      if (mb_strlen($this->SendExtend['CustomerAddr'], 'UTF-8') == 0) {
                          array_push($arErrors, "CustomerAddr is required.");
                      }
                  }
              }
              
              // CustomerPhone(與CustomerEmail擇一不可為空)
              if (strlen($this->SendExtend['CustomerPhone']) > 20) {
                  array_push($arErrors, "CustomerPhone max length as 20.");
              }
              
              // CustomerEmail(UrlEncode, 預設為空字串, 與CustomerPhone擇一不可為空)
              if (strlen($this->SendExtend['CustomerEmail']) > 200) {
                  array_push($arErrors, "CustomerEmail max length as 200.");
              }
              
              if (strlen($this->SendExtend['CustomerPhone']) == 0 and strlen($this->SendExtend['CustomerEmail']) == 0) {
                  array_push($arErrors, "CustomerPhone or CustomerEmail is required.");
              }
              
              // TaxType(不可為空)
              if (strlen($this->SendExtend['TaxType']) > 1) {
                  array_push($arErrors, "TaxType max length as 1.");
              } else {
                  if (strlen($this->SendExtend['TaxType']) == 0) {
                      array_push($arErrors, "TaxType is required.");
                  }
              }
              
              // ClearanceMark(預設為空字串)
              if (strlen($this->SendExtend['ClearanceMark']) > 1) {
                  array_push($arErrors, "ClearanceMark max length as 1.");
              } else {
                  // 請設定空字串，僅課稅類別為零稅率(Zero)時，此參數不可為空字串
                  if ($this->SendExtend['TaxType'] == TaxType::Zero) {
                      if ($this->SendExtend['ClearanceMark'] != ClearanceMark::Yes and $this->SendExtend['ClearanceMark'] != ClearanceMark::No) {
                          array_push($arErrors, "ClearanceMark is required.");
                      }
                  } else {
                      if (strlen($this->SendExtend['ClearanceMark']) > 0) {
                          array_push($arErrors, "Please remove ClearanceMark.");
                      }
                  }
              }
              
              // CarruerNum(預設為空字串)
              if (strlen($this->SendExtend['CarruerNum']) > 64) {
                  array_push($arErrors, "CarruerNum max length as 64.");
              } else {
                  switch ($this->SendExtend['CarruerType']) {
                      // 載具類別為無載具(None)或會員載具(Member)時，請設定空字串
                      case CarruerType::None:
                      case CarruerType::Member:
                          if (strlen($this->SendExtend['CarruerNum']) > 0) {
                              array_push($arErrors, "Please remove CarruerNum.");
                          }
                          break;
                      // 載具類別為買受人自然人憑證(Citizen)時，請設定自然人憑證號碼，前2碼為大小寫英文，後14碼為數字
                      case CarruerType::Citizen:
                          if (!preg_match('/^[a-zA-Z]{2}\d{14}$/', $this->SendExtend['CarruerNum']))
                          {
                              array_push($arErrors, "Invalid CarruerNum.");
                          }
                          break;
                      // 載具類別為買受人手機條碼(Cellphone)時，請設定手機條碼，第1碼為「/」，後7碼為大小寫英文、數字、「+」、「-」或「.」
                      case CarruerType::Cellphone:
                          if (!preg_match('/^\/{1}[0-9a-zA-Z+-.]{7}$/', $this->SendExtend['CarruerNum'])) {
                              array_push($arErrors, "Invalid CarruerNum.");
                          }
                          break;
                      default:
                          array_push($arErrors, "Please remove CarruerNum.");
                  }
              }
              
              // LoveCode(預設為空字串)
              // 捐贈註記為捐贈(Yes)時，參數長度固定3~7碼，請設定全數字或第1碼大小寫「X」，後2~6碼全數字
              if ($this->SendExtend['Donation'] == Donation::Yes) {
                  if (!preg_match('/^([xX]{1}[0-9]{2,6}|[0-9]{3,7})$/', $this->SendExtend['LoveCode'])) {
                      array_push($arErrors, "Invalid LoveCode.");
                  }
              } else {
                  if (strlen($this->SendExtend['LoveCode']) > 0) {
                      array_push($arErrors, "Please remove LoveCode.");
                  }
              }
              
              // InvoiceItemName(UrlEncode, 不可為空)
              // InvoiceItemCount(不可為空)
              // InvoiceItemWord(UrlEncode, 不可為空)
              // InvoiceItemPrice(不可為空)
              // InvoiceItemTaxType(不可為空)
              if (sizeof($this->SendExtend['InvoiceItems']) > 0) {
                  $tmpItemName = array();
                  $tmpItemCount = array();
                  $tmpItemWord = array();
                  $tmpItemPrice = array();
                  $tmpItemTaxType = array();
                  foreach ($this->SendExtend['InvoiceItems'] as $tmpItemInfo) {
                      if (mb_strlen($tmpItemInfo['Name'], 'UTF-8') > 0) {
                          array_push($tmpItemName, $tmpItemInfo['Name']);
                      }
                      if (strlen($tmpItemInfo['Count']) > 0) {
                          array_push($tmpItemCount, $tmpItemInfo['Count']);
                      }
                      if (mb_strlen($tmpItemInfo['Word'], 'UTF-8') > 0) {
                          array_push($tmpItemWord, $tmpItemInfo['Word']);
                      }
                      if (strlen($tmpItemInfo['Price']) > 0) {
                          array_push($tmpItemPrice, $tmpItemInfo['Price']);
                      }
                      if (strlen($tmpItemInfo['TaxType']) > 0) {
                          array_push($tmpItemTaxType, $tmpItemInfo['TaxType']);
                      }
                  }
                  
                  if ($this->SendExtend['TaxType'] == TaxType::Mix) {
                      if (in_array(TaxType::Dutiable, $tmpItemTaxType) and in_array(TaxType::Free, $tmpItemTaxType)) {
                          // Do nothing
                      }  else {
                          $tmpItemTaxType = array();
                      }
                  }
                  if ((count($tmpItemName) + count($tmpItemCount) + count($tmpItemWord) + count($tmpItemPrice) + count($tmpItemTaxType)) == (count($tmpItemName) * 5)) {
                      $szInvoiceItemName = implode($InvSptr, $tmpItemName);
                      $szInvoiceItemCount = implode($InvSptr, $tmpItemCount);
                      $szInvoiceItemWord = implode($InvSptr, $tmpItemWord);
                      $szInvoiceItemPrice = implode($InvSptr, $tmpItemPrice);
                      $szInvoiceItemTaxType = implode($InvSptr, $tmpItemTaxType);
                  } else {
                      array_push($arErrors, "Invalid Invoice Goods information.");
                  }
              } else {
                  array_push($arErrors, "Invoice Goods information not found.");
              }

              // InvoiceRemark(UrlEncode, 預設為空字串)
              
              // DelayDay(不可為空, 預設為0)
              // 延遲天數，範圍0~15，設定為0時，付款完成後立即開立發票
              $this->SendExtend['DelayDay'] = (int)$this->SendExtend['DelayDay'];
              if ($this->SendExtend['DelayDay'] < 0 or $this->SendExtend['DelayDay'] > 15) {
                  array_push($arErrors, "DelayDay should be 0 ~ 15.");
              } else {
                  if (strlen($this->SendExtend['DelayDay']) == 0) {
                      $this->SendExtend['DelayDay'] = 0;
                  }
              }
              
              // InvType(不可為空)
              if (strlen($this->SendExtend['InvType']) == 0) {
                  array_push($arErrors, "InvType is required.");
              }
          }
        }
        
        // 檢查CheckMacValue加密方式
        if (strlen($this->Send['EncryptType']) > 1) {
            array_push($arErrors, 'EncryptType max langth as 1.');
        }
        
        // 輸出表單字串。
        if (sizeof($arErrors) == 0) {
            // 信用卡特殊邏輯判斷(行動裝置畫面的信用卡分期處理，不支援定期定額)
            if ($this->Send['ChoosePayment'] == PaymentMethod::Credit && $this->Send['DeviceSource'] == DeviceType::Mobile && !$this->SendExtend['PeriodAmount']) {
                $this->Send['ChoosePayment'] = PaymentMethod::ALL;
                $this->Send['IgnorePayment'] = 'WebATM#ATM#CVS#BARCODE#Alipay#Tenpay#TopUpUsed#APPBARCODE#AccountLink';
            }
            // 產生畫面控制項與傳遞參數。
            $arParameters = array(
              'MerchantID' => $this->MerchantID,
              'PaymentType' => $this->PaymentType,
              'ItemName' => $szItemName,
              'ItemURL' => $this->Send['ItemURL'],
              'InvoiceItemName' => $szInvoiceItemName,
              'InvoiceItemCount' => $szInvoiceItemCount,
              'InvoiceItemWord' => $szInvoiceItemWord,
              'InvoiceItemPrice' => $szInvoiceItemPrice,
              'InvoiceItemTaxType' => $szInvoiceItemTaxType,
            );
            $arParameters = array_merge($arParameters, $this->Send);
            $arParameters = array_merge($arParameters, $this->SendExtend);
            // 處理延伸參數
            if (!$this->Send['PlatformID']) { unset($arParameters['PlatformID']); }
            // 整理全功能參數。
            if ($this->Send['ChoosePayment'] == PaymentMethod::ALL) {
                unset($arParameters['ExecTimes']);
                unset($arParameters['Frequency']);
                unset($arParameters['PeriodAmount']);
                unset($arParameters['PeriodReturnURL']);
                unset($arParameters['PeriodType']);

                $arParameters = array_merge($arParameters, array(
                    'AlipayItemName' => $szAlipayItemName,
                    'AlipayItemCounts' => $szAlipayItemCounts,
                    'AlipayItemPrice' => $szAlipayItemPrice
                ));

                if (!$arParameters['CreditInstallment']) { unset($arParameters['CreditInstallment']); }
                if (!$arParameters['InstallmentAmount']) { unset($arParameters['InstallmentAmount']); }
                if (!$arParameters['Redeem']) { unset($arParameters['Redeem']); }
                if (!$arParameters['UnionPay']) { unset($arParameters['UnionPay']); }

                if (!$this->Send['IgnorePayment']) { unset($arParameters['IgnorePayment']); }
                if (!$this->SendExtend['ClientRedirectURL']) { unset($arParameters['ClientRedirectURL']); }
            }
            // 整理 Alipay 參數。
            if ($this->Send['ChoosePayment'] == PaymentMethod::Alipay) {
                $arParameters = array_merge($arParameters, array(
                    'AlipayItemName' => $szAlipayItemName,
                    'AlipayItemCounts' => $szAlipayItemCounts,
                    'AlipayItemPrice' => $szAlipayItemPrice
                ));

                unset($arParameters['CreditInstallment']);
                unset($arParameters['Desc_1']);
                unset($arParameters['Desc_2']);
                unset($arParameters['Desc_3']);
                unset($arParameters['Desc_4']);
                unset($arParameters['ExecTimes']);
                unset($arParameters['ExpireDate']);
                unset($arParameters['ExpireTime']);
                unset($arParameters['Frequency']);
                unset($arParameters['InstallmentAmount']);
                unset($arParameters['PaymentInfoURL']);
                unset($arParameters['PeriodAmount']);
                unset($arParameters['PeriodReturnURL']);
                unset($arParameters['PeriodType']);
                unset($arParameters['Redeem']);
                unset($arParameters['UnionPay']);

                unset($arParameters['IgnorePayment']);
                unset($arParameters['ClientRedirectURL']);
            }
            // 整理 Tenpay 參數。
            if ($this->Send['ChoosePayment'] == PaymentMethod::Tenpay) {
                unset($arParameters['CreditInstallment']);
                unset($arParameters['Desc_1']);
                unset($arParameters['Desc_2']);
                unset($arParameters['Desc_3']);
                unset($arParameters['Desc_4']);
                unset($arParameters['Email']);
                unset($arParameters['ExecTimes']);
                unset($arParameters['ExpireDate']);
                unset($arParameters['Frequency']);
                unset($arParameters['InstallmentAmount']);
                unset($arParameters['PaymentInfoURL']);
                unset($arParameters['PeriodAmount']);
                unset($arParameters['PeriodReturnURL']);
                unset($arParameters['PeriodType']);
                unset($arParameters['PhoneNo']);
                unset($arParameters['Redeem']);
                unset($arParameters['UnionPay']);
                unset($arParameters['UserName']);

                unset($arParameters['IgnorePayment']);
                unset($arParameters['ClientRedirectURL']);
            }
            // 整理 ATM 參數。
            if ($this->Send['ChoosePayment'] == PaymentMethod::ATM) {
                unset($arParameters['CreditInstallment']);
                unset($arParameters['Desc_1']);
                unset($arParameters['Desc_2']);
                unset($arParameters['Desc_3']);
                unset($arParameters['Desc_4']);
                unset($arParameters['Email']);
                unset($arParameters['ExecTimes']);
                unset($arParameters['ExpireTime']);
                unset($arParameters['Frequency']);
                unset($arParameters['InstallmentAmount']);
                unset($arParameters['PeriodAmount']);
                unset($arParameters['PeriodReturnURL']);
                unset($arParameters['PeriodType']);
                unset($arParameters['PhoneNo']);
                unset($arParameters['Redeem']);
                unset($arParameters['UnionPay']);
                unset($arParameters['UserName']);

                unset($arParameters['IgnorePayment']);
                if (!$this->SendExtend['ClientRedirectURL']) { unset($arParameters['ClientRedirectURL']); }
            }
            // 整理 BARCODE OR CVS 參數。
            if ($this->Send['ChoosePayment'] == PaymentMethod::BARCODE || $this->Send['ChoosePayment'] == PaymentMethod::CVS) {
                unset($arParameters['CreditInstallment']);
                unset($arParameters['Email']);
                unset($arParameters['ExecTimes']);
                unset($arParameters['ExpireDate']);
                unset($arParameters['ExpireTime']);
                unset($arParameters['Frequency']);
                unset($arParameters['InstallmentAmount']);
                unset($arParameters['PeriodAmount']);
                unset($arParameters['PeriodReturnURL']);
                unset($arParameters['PeriodType']);
                unset($arParameters['PhoneNo']);
                unset($arParameters['Redeem']);
                unset($arParameters['UnionPay']);
                unset($arParameters['UserName']);

                unset($arParameters['IgnorePayment']);
                if (!$this->SendExtend['ClientRedirectURL']) { unset($arParameters['ClientRedirectURL']); }
            }
            // 整理全功能、WebATM OR TopUpUsed 參數。
            if ($this->Send['ChoosePayment'] == PaymentMethod::WebATM || $this->Send['ChoosePayment'] == PaymentMethod::TopUpUsed) {
                unset($arParameters['CreditInstallment']);
                unset($arParameters['Desc_1']);
                unset($arParameters['Desc_2']);
                unset($arParameters['Desc_3']);
                unset($arParameters['Desc_4']);
                unset($arParameters['Email']);
                unset($arParameters['ExecTimes']);
                unset($arParameters['ExpireDate']);
                unset($arParameters['ExpireTime']);
                unset($arParameters['Frequency']);
                unset($arParameters['InstallmentAmount']);
                unset($arParameters['PaymentInfoURL']);
                unset($arParameters['PeriodAmount']);
                unset($arParameters['PeriodReturnURL']);
                unset($arParameters['PeriodType']);
                unset($arParameters['PhoneNo']);
                unset($arParameters['Redeem']);
                unset($arParameters['UnionPay']);
                unset($arParameters['UserName']);

                unset($arParameters['IgnorePayment']);
                unset($arParameters['ClientRedirectURL']);
            }
            // 整理 Credit 參數。
            if ($this->Send['ChoosePayment'] == PaymentMethod::Credit) {
                // Credit 分期。
                $arParameters['Redeem'] = ($arParameters['Redeem'] ? 'Y' : '');
                $arParameters['UnionPay'] = ($arParameters['UnionPay'] ? 1 : 0);

                unset($arParameters['Desc_1']);
                unset($arParameters['Desc_2']);
                unset($arParameters['Desc_3']);
                unset($arParameters['Desc_4']);
                unset($arParameters['Email']);
                unset($arParameters['ExpireDate']);
                unset($arParameters['ExpireTime']);
                unset($arParameters['PaymentInfoURL']);
                unset($arParameters['PhoneNo']);
                unset($arParameters['UserName']);

                unset($arParameters['IgnorePayment']);
                unset($arParameters['ClientRedirectURL']);
            }

            unset($arParameters['Items']);
           
            // 處理電子發票參數
            unset($arParameters['InvoiceItems']);
            if ($this->Send['InvoiceMark'] == InvoiceState::Yes) {
                $encode_fields = array(
                    'CustomerName',
                    'CustomerAddr',
                    'CustomerEmail',
                    'InvoiceItemName',
                    'InvoiceItemWord',
                    'InvoiceRemark'
                );
                foreach ($encode_fields as $tmp_field) {
                    $arParameters[$tmp_field] = urlencode($arParameters[$tmp_field]);
                }
            } else {
                unset($arParameters['InvoiceMark']);
                unset($arParameters['RelateNumber']);
                unset($arParameters['CustomerIdentifier']);
                unset($arParameters['CarruerType']);
                unset($arParameters['CustomerID']);
                unset($arParameters['Donation']);
                unset($arParameters['Print']);
                unset($arParameters['CustomerName']);
                unset($arParameters['CustomerAddr']);
                unset($arParameters['CustomerPhone']);
                unset($arParameters['CustomerEmail']);
                unset($arParameters['TaxType']);
                unset($arParameters['ClearanceMark']);
                unset($arParameters['CarruerNum']);
                unset($arParameters['LoveCode']);
                unset($arParameters['InvoiceItemName']);
                unset($arParameters['InvoiceItemCount']);
                unset($arParameters['InvoiceItemWord']);
                unset($arParameters['InvoiceItemPrice']);
                unset($arParameters['InvoiceItemTaxType']);
                unset($arParameters['InvoiceRemark']);
                unset($arParameters['DelayDay']);
                unset($arParameters['InvType']);
            }
            
            // 資料排序
      // php 5.3以下不支援
      // ksort($arParameters, SORT_NATURAL | SORT_FLAG_CASE);
      uksort($arParameters, array('AllInOne','merchantSort'));

            $szCheckMacValue = "HashKey=$this->HashKey";
            foreach ($arParameters as $key => $value) {
                $szCheckMacValue .= "&$key=$value";
            }
            $szCheckMacValue .= "&HashIV=$this->HashIV";
            $szCheckMacValue = strtolower(urlencode($szCheckMacValue));
            // 取代為與 dotNet 相符的字元
            $szCheckMacValue = str_replace('%2d', '-', $szCheckMacValue);
            $szCheckMacValue = str_replace('%5f', '_', $szCheckMacValue);
            $szCheckMacValue = str_replace('%2e', '.', $szCheckMacValue);
            $szCheckMacValue = str_replace('%21', '!', $szCheckMacValue);
            $szCheckMacValue = str_replace('%2a', '*', $szCheckMacValue);
            $szCheckMacValue = str_replace('%28', '(', $szCheckMacValue);
            $szCheckMacValue = str_replace('%29', ')', $szCheckMacValue);
            // Customize for Magento
            $szCheckMacValue = str_replace('%3f___sid%3d' . session_id(), '', $szCheckMacValue);
            $szCheckMacValue = str_replace('%3f___sid%3du', '', $szCheckMacValue);
            $szCheckMacValue = str_replace('%3f___sid%3ds', '', $szCheckMacValue);
            
            // CheckMacValue 壓碼
            $szCheckMacValue = $this->EncCheckMacValue($szCheckMacValue, $this->Send['EncryptType']);

            $szHtml = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            $szHtml .= '<div style="text-align:center;" ><form id="__allpayForm" method="post" target="' . $target . '" action="' . $this->ServiceURL . '">';
            foreach ($arParameters as $keys => $value) {
                $szHtml .="<input type='hidden' name='$keys' value='$value' />";
            }
            $szHtml .= '<input type="hidden" name="CheckMacValue" value="' . $szCheckMacValue . '" />';
            // 手動或自動送出表單。
            if (!isset($paymentButton)) {
                $szHtml .= '<script type="text/javascript">document.getElementById("__allpayForm").submit();</script>';
            } else {
                $szHtml .= '<input type="submit" id="__paymentButton" value="' . $paymentButton . '" />';
            }
            $szHtml .= '</form></div>';
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $szHtml;
    }

    function CheckOutFeedback() {
        // 變數宣告。
        $arErrors = array();
        $arParameters = array();
        $arFeedback = array();
        $szCheckMacValue = '';
        // 重新整理回傳參數。
        foreach ($_POST as $keys => $value) {
            if ($keys != 'CheckMacValue') {
                if ($keys == 'PaymentType') {
                    $value = str_replace('_CVS', '', $value);
                    $value = str_replace('_BARCODE', '', $value);
                    $value = str_replace('_Alipay', '', $value);
                    $value = str_replace('_Tenpay', '', $value);
                    $value = str_replace('_CreditCard', '', $value);
                }
                if ($keys == 'PeriodType') {
                    $value = str_replace('Y', 'Year', $value);
                    $value = str_replace('M', 'Month', $value);
                    $value = str_replace('D', 'Day', $value);
                }
                $arFeedback[$keys] = $value;
            } else {
                $szCheckMacValue = $value;
            }
        }
        // 回傳參數鍵值轉小寫。
        foreach ($_POST as $keys => $value) {
      if ($keys == 'view' || $keys == 'hikashop_front_end_main') {
        // Customize to Skip Parameters for HikaShop
      } else if ($keys == 'mijoshop_store_id' || $keys == 'language') {
        // Customize to Skip Parameters for MijoShop
      } else {
        $arParameters[strtolower($keys)] = $value;
      }
        }
        unset($arParameters['checkmacvalue']);
        ksort($arParameters);
        // 驗證檢查碼。
        if (sizeof($arFeedback) > 0) {
            $szConfirmMacValue = "HashKey=$this->HashKey";
            foreach ($arParameters as $key => $value) {
                $szConfirmMacValue .= "&$key=$value";
            }
            $szConfirmMacValue .= "&HashIV=$this->HashIV";
            $szConfirmMacValue = strtolower(urlencode($szConfirmMacValue));
            // 取代為與 dotNet 相符的字元
            $szConfirmMacValue = str_replace('%2d', '-', $szConfirmMacValue);
            $szConfirmMacValue = str_replace('%5f', '_', $szConfirmMacValue);
            $szConfirmMacValue = str_replace('%2e', '.', $szConfirmMacValue);
            $szConfirmMacValue = str_replace('%21', '!', $szConfirmMacValue);
            $szConfirmMacValue = str_replace('%2a', '*', $szConfirmMacValue);
            $szConfirmMacValue = str_replace('%28', '(', $szConfirmMacValue);
            $szConfirmMacValue = str_replace('%29', ')', $szConfirmMacValue);
            
            // 檢查CheckMacValue加密方式
            if (strlen($this->EncryptType) > 1) {
                array_push($arErrors, 'EncryptType max langth as 1.');
            }
            
            // CheckMacValue 壓碼
            $szConfirmMacValue = $this->EncCheckMacValue($szConfirmMacValue, $this->EncryptType);

            if ($szCheckMacValue != strtoupper($szConfirmMacValue)) {
                array_push($arErrors, 'CheckMacValue verify fail.');
            }
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback;
    }

    function QueryTradeInfo() {
        // 變數宣告。
        $arErrors = array();
        $this->Query['TimeStamp'] = time();
        $arFeedback = array();
        $arConfirmArgs = array();
        // 檢查資料。
        if (strlen($this->ServiceURL) == 0) {
            array_push($arErrors, 'ServiceURL is required.');
        }
        if (strlen($this->ServiceURL) > 200) {
            array_push($arErrors, 'ServiceURL max langth as 200.');
        }
        if (strlen($this->HashKey) == 0) {
            array_push($arErrors, 'HashKey is required.');
        }
        if (strlen($this->HashIV) == 0) {
            array_push($arErrors, 'HashIV is required.');
        }
        if (strlen($this->MerchantID) == 0) {
            array_push($arErrors, 'MerchantID is required.');
        }
        if (strlen($this->MerchantID) > 10) {
            array_push($arErrors, 'MerchantID max langth as 10.');
        }

        if (strlen($this->Query['MerchantTradeNo']) == 0) {
            array_push($arErrors, 'MerchantTradeNo is required.');
        }
        if (strlen($this->Query['MerchantTradeNo']) > 20) {
            array_push($arErrors, 'MerchantTradeNo max langth as 20.');
        }
        if (strlen($this->Query['TimeStamp']) == 0) {
            array_push($arErrors, 'TimeStamp is required.');
        }
        // 呼叫查詢。
        if (sizeof($arErrors) == 0) {
            $arParameters = array("MerchantID" => $this->MerchantID);
            $arParameters = array_merge($arParameters, $this->Query);
            // 資料排序。
            ksort($arParameters);
            // 產生檢查碼。
            $szCheckMacValue = "HashKey=$this->HashKey";
            foreach ($arParameters as $key => $value) {
                $szCheckMacValue .= "&$key=$value";
            }
            $szCheckMacValue .= "&HashIV=$this->HashIV";
            $szCheckMacValue = strtolower(urlencode($szCheckMacValue));
            // 取代為與 dotNet 相符的字元
            $szCheckMacValue = str_replace('%2d', '-', $szCheckMacValue);
            $szCheckMacValue = str_replace('%5f', '_', $szCheckMacValue);
            $szCheckMacValue = str_replace('%2e', '.', $szCheckMacValue);
            $szCheckMacValue = str_replace('%21', '!', $szCheckMacValue);
            $szCheckMacValue = str_replace('%2a', '*', $szCheckMacValue);
            $szCheckMacValue = str_replace('%28', '(', $szCheckMacValue);
            $szCheckMacValue = str_replace('%29', ')', $szCheckMacValue);
            // Customize for Magento
            $szCheckMacValue = str_replace('%3f___sid%3d' . session_id(), '', $szCheckMacValue);
            $szCheckMacValue = str_replace('%3f___sid%3du', '', $szCheckMacValue);
            $szCheckMacValue = str_replace('%3f___sid%3ds', '', $szCheckMacValue);
            // MD5 編碼
            $szCheckMacValue = md5($szCheckMacValue);

            $arParameters["CheckMacValue"] = $szCheckMacValue;
            // 送出查詢並取回結果。
            $szResult = $this->ServerPost($arParameters);
            $szResult = str_replace(' ', '%20', $szResult);
            $szResult = str_replace('+', '%2B', $szResult);
            //$szResult = str_replace('/', '%2F', $szResult);
            //$szResult = str_replace('?', '%3F', $szResult);
            //$szResult = str_replace('%', '%25', $szResult);
            //$szResult = str_replace('#', '%23', $szResult);
            //$szResult = str_replace('&', '%26', $szResult);
            //$szResult = str_replace('=', '%3D', $szResult);
            // 轉結果為陣列。
            parse_str($szResult, $arParameters);
            // 重新整理回傳參數。
            foreach ($arParameters as $keys => $value) {
                if ($keys == 'CheckMacValue') {
                    $szCheckMacValue = $value;
                } else {
                    $arFeedback[$keys] = $value;
                    $arConfirmArgs[strtolower($keys)] = $value;
                }
            }

            ksort($arConfirmArgs);
            // 驗證檢查碼。
            if (sizeof($arFeedback) > 0) {
                $szConfirmMacValue = "HashKey=$this->HashKey";
                foreach ($arConfirmArgs as $key => $value) {
                    $szConfirmMacValue .= "&$key=$value";
                }
                $szConfirmMacValue .= "&HashIV=$this->HashIV";
                $szConfirmMacValue = strtolower(urlencode($szConfirmMacValue));
                // 取代為與 dotNet 相符的字元
                $szConfirmMacValue = str_replace('%2d', '-', $szConfirmMacValue);
                $szConfirmMacValue = str_replace('%5f', '_', $szConfirmMacValue);
                $szConfirmMacValue = str_replace('%2e', '.', $szConfirmMacValue);
                $szConfirmMacValue = str_replace('%21', '!', $szConfirmMacValue);
                $szConfirmMacValue = str_replace('%2a', '*', $szConfirmMacValue);
                $szConfirmMacValue = str_replace('%28', '(', $szConfirmMacValue);
                $szConfirmMacValue = str_replace('%29', ')', $szConfirmMacValue);
                // MD5 編碼
                $szConfirmMacValue = md5($szConfirmMacValue);

                if ($szCheckMacValue != strtoupper($szConfirmMacValue)) {
                    array_push($arErrors, 'CheckMacValue verify fail.');
                }
            }
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback;
    }
  
    function QueryPeriodCreditCardTradeInfo() {
        // 變數宣告。
        $arErrors = array();
        $this->Query['TimeStamp'] = time();
        $arFeedback = array();
        // 檢查資料。
        if (strlen($this->ServiceURL) == 0) {
            array_push($arErrors, 'ServiceURL is required.');
        }
        if (strlen($this->ServiceURL) > 200) {
            array_push($arErrors, 'ServiceURL max langth as 200.');
        }
        if (strlen($this->HashKey) == 0) {
            array_push($arErrors, 'HashKey is required.');
        }
        if (strlen($this->HashIV) == 0) {
            array_push($arErrors, 'HashIV is required.');
        }
        if (strlen($this->MerchantID) == 0) {
            array_push($arErrors, 'MerchantID is required.');
        }
        if (strlen($this->MerchantID) > 10) {
            array_push($arErrors, 'MerchantID max langth as 10.');
        }

        if (strlen($this->Query['MerchantTradeNo']) == 0) {
            array_push($arErrors, 'MerchantTradeNo is required.');
        }
        if (strlen($this->Query['MerchantTradeNo']) > 20) {
            array_push($arErrors, 'MerchantTradeNo max langth as 20.');
        }
        if (strlen($this->Query['TimeStamp']) == 0) {
            array_push($arErrors, 'TimeStamp is required.');
        }
        // 呼叫查詢。
        if (sizeof($arErrors) == 0) {
            $arParameters = array("MerchantID" => $this->MerchantID);
            $arParameters = array_merge($arParameters, $this->Query);
            // 資料排序。
            ksort($arParameters);
            // 產生檢查碼。
            $szCheckMacValue = "HashKey=$this->HashKey";
            foreach ($arParameters as $key => $value) {
                $szCheckMacValue .= "&$key=$value";
            }
            $szCheckMacValue .= "&HashIV=$this->HashIV";
            $szCheckMacValue = strtolower(urlencode($szCheckMacValue));
            // 取代為與 dotNet 相符的字元
            $szCheckMacValue = str_replace('%2d', '-', $szCheckMacValue);
            $szCheckMacValue = str_replace('%5f', '_', $szCheckMacValue);
            $szCheckMacValue = str_replace('%2e', '.', $szCheckMacValue);
            $szCheckMacValue = str_replace('%21', '!', $szCheckMacValue);
            $szCheckMacValue = str_replace('%2a', '*', $szCheckMacValue);
            $szCheckMacValue = str_replace('%28', '(', $szCheckMacValue);
            $szCheckMacValue = str_replace('%29', ')', $szCheckMacValue);
            // Customize for Magento
            $szCheckMacValue = str_replace('%3f___sid%3d' . session_id(), '', $szCheckMacValue);
            $szCheckMacValue = str_replace('%3f___sid%3du', '', $szCheckMacValue);
            $szCheckMacValue = str_replace('%3f___sid%3ds', '', $szCheckMacValue);
            // MD5 編碼
            $szCheckMacValue = md5($szCheckMacValue);

            $arParameters["CheckMacValue"] = $szCheckMacValue;
            // 送出查詢並取回結果。
            $szResult = $this->ServerPost($arParameters);
            $szResult = str_replace(' ', '%20', $szResult);
            $szResult = str_replace('+', '%2B', $szResult);
            //$szResult = str_replace('/', '%2F', $szResult);
            //$szResult = str_replace('?', '%3F', $szResult);
            //$szResult = str_replace('%', '%25', $szResult);
            //$szResult = str_replace('#', '%23', $szResult);
            //$szResult = str_replace('&', '%26', $szResult);
            //$szResult = str_replace('=', '%3D', $szResult);
            // 轉結果為陣列。
            parse_str($szResult, $arFeedback);
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback;
    }

    function DoAction() {
        // 變數宣告。
        $arErrors = array();
        $arFeedback = array();
        // 檢查資料。
        if (strlen($this->ServiceURL) == 0) {
            array_push($arErrors, 'ServiceURL is required.');
        }
        if (strlen($this->ServiceURL) > 200) {
            array_push($arErrors, 'ServiceURL max langth as 200.');
        }
        if (strlen($this->HashKey) == 0) {
            array_push($arErrors, 'HashKey is required.');
        }
        if (strlen($this->HashIV) == 0) {
            array_push($arErrors, 'HashIV is required.');
        }
        if (strlen($this->MerchantID) == 0) {
            array_push($arErrors, 'MerchantID is required.');
        }
        if (strlen($this->MerchantID) > 10) {
            array_push($arErrors, 'MerchantID max langth as 10.');
        }

        if (strlen($this->Action['MerchantTradeNo']) == 0) {
            array_push($arErrors, 'MerchantTradeNo is required.');
        }
        if (strlen($this->Action['MerchantTradeNo']) > 20) {
            array_push($arErrors, 'MerchantTradeNo max langth as 20.');
        }
        if (strlen($this->Action['TradeNo']) == 0) {
            array_push($arErrors, 'TradeNo is required.');
        }
        if (strlen($this->Action['TradeNo']) > 20) {
            array_push($arErrors, 'TradeNo max langth as 20.');
        }
        if (strlen($this->Action['Action']) == 0) {
            array_push($arErrors, 'Action is required.');
        }
        if (strlen($this->Action['Action']) > 1) {
            array_push($arErrors, 'Action max length as 1.');
        }
        if (strlen($this->Action['TotalAmount']) == 0) {
            array_push($arErrors, 'TotalAmount is required.');
        }
        // 呼叫信用卡訂單處理。
        if (sizeof($arErrors) == 0) {
            $arParameters = array("MerchantID" => $this->MerchantID);
            $arParameters = array_merge($arParameters, $this->Action);
            // 資料排序。
            ksort($arParameters);
            // 產生檢查碼。
            $szCheckMacValue = "HashKey=$this->HashKey";
            foreach ($arParameters as $key => $value) {
                $szCheckMacValue .= "&$key=$value";
            }
            $szCheckMacValue .= "&HashIV=$this->HashIV";
            $szCheckMacValue = strtolower(urlencode($szCheckMacValue));
            // 取代為與 dotNet 相符的字元
            $szCheckMacValue = str_replace('%2d', '-', $szCheckMacValue);
            $szCheckMacValue = str_replace('%5f', '_', $szCheckMacValue);
            $szCheckMacValue = str_replace('%2e', '.', $szCheckMacValue);
            $szCheckMacValue = str_replace('%21', '!', $szCheckMacValue);
            $szCheckMacValue = str_replace('%2a', '*', $szCheckMacValue);
            $szCheckMacValue = str_replace('%28', '(', $szCheckMacValue);
            $szCheckMacValue = str_replace('%29', ')', $szCheckMacValue);
            // Customize for Magento
            $szCheckMacValue = str_replace('%3f___sid%3d' . session_id(), '', $szCheckMacValue);
            $szCheckMacValue = str_replace('%3f___sid%3du', '', $szCheckMacValue);
            $szCheckMacValue = str_replace('%3f___sid%3ds', '', $szCheckMacValue);
            // MD5 編碼
            $szCheckMacValue = md5($szCheckMacValue);

            $arParameters["CheckMacValue"] = $szCheckMacValue;
            // 送出查詢並取回結果。
            $szResult = $this->ServerPost($arParameters);
            // 轉結果為陣列。
            parse_str($szResult, $arParameters);
            // 重新整理回傳參數。
            foreach ($arParameters as $keys => $value) {
                if ($keys == 'CheckMacValue') {
                    $szCheckMacValue = $value;
                } else {
                    $arFeedback[$keys] = $value;
                }
            }

            if (array_key_exists('RtnCode', $arFeedback) && $arFeedback['RtnCode'] != '1') {
                array_push($arErrors, vsprintf('#%s: %s', array($arFeedback['RtnCode'], $arFeedback['RtnMsg'])));
            }
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback;
    }

    function AioChargeback() {
        // 變數宣告。
        $arErrors = array();
        $arParameters = array("MerchantID" => $this->MerchantID);
        $arParameters = array_merge($arParameters, $this->ChargeBack);
        $arFeedback = array();
        // 檢查資料。
        if (strlen($this->ServiceURL) == 0) {
            array_push($arErrors, 'ServiceURL is required.');
        }
        if (strlen($this->ServiceURL) > 200) {
            array_push($arErrors, 'ServiceURL max langth as 200.');
        }
        if (strlen($this->HashKey) == 0) {
            array_push($arErrors, 'HashKey is required.');
        }
        if (strlen($this->HashIV) == 0) {
            array_push($arErrors, 'HashIV is required.');
        }
        if (strlen($this->MerchantID) == 0) {
            array_push($arErrors, 'MerchantID is required.');
        }
        if (strlen($this->MerchantID) > 10) {
            array_push($arErrors, 'MerchantID max langth as 10.');
        }

        if (strlen($this->ChargeBack['MerchantTradeNo']) == 0) {
            array_push($arErrors, 'MerchantTradeNo is required.');
        }
        if (strlen($this->ChargeBack['MerchantTradeNo']) > 20) {
            array_push($arErrors, 'MerchantTradeNo max langth as 20.');
        }
        if (strlen($this->ChargeBack['TradeNo']) == 0) {
            array_push($arErrors, 'TradeNo is required.');
        }
        if (strlen($this->ChargeBack['TradeNo']) > 20) {
            array_push($arErrors, 'TradeNo max langth as 20.');
        }
        if (strlen($this->ChargeBack['ChargeBackTotalAmount']) == 0) {
            array_push($arErrors, 'ChargeBackTotalAmount is required.');
        }
        if (strlen($this->ChargeBack['Remark']) > 200) {
            array_push($arErrors, 'Remark max length as 200.');
        }
        // 資料排序。
        ksort($arParameters);
        // 產生檢查碼。
        $szCheckMacValue = "HashKey=$this->HashKey";
        foreach ($arParameters as $key => $value) {
            $szCheckMacValue .= "&$key=$value";
        }
        $szCheckMacValue .= "&HashIV=$this->HashIV";
        $szCheckMacValue = strtolower(urlencode($szCheckMacValue));
        // 取代為與 dotNet 相符的字元
        $szCheckMacValue = str_replace('%2d', '-', $szCheckMacValue);
        $szCheckMacValue = str_replace('%5f', '_', $szCheckMacValue);
        $szCheckMacValue = str_replace('%2e', '.', $szCheckMacValue);
        $szCheckMacValue = str_replace('%21', '!', $szCheckMacValue);
        $szCheckMacValue = str_replace('%2a', '*', $szCheckMacValue);
        $szCheckMacValue = str_replace('%28', '(', $szCheckMacValue);
        $szCheckMacValue = str_replace('%29', ')', $szCheckMacValue);
        // Customize for Magento
        $szCheckMacValue = str_replace('%3f___sid%3d' . session_id(), '', $szCheckMacValue);
        $szCheckMacValue = str_replace('%3f___sid%3du', '', $szCheckMacValue);
        $szCheckMacValue = str_replace('%3f___sid%3ds', '', $szCheckMacValue);
        // MD5 編碼
        $szCheckMacValue = md5($szCheckMacValue);

        $arParameters["CheckMacValue"] = $szCheckMacValue;
        // 送出查詢並取回結果。
        $szResult = $this->ServerPost($arParameters);
        // 檢查結果資料。
        if ($szResult == '1|OK') {
            $arFeedback['RtnCode'] = '1';
            $arFeedback['RtnMsg'] = 'OK';
        } else {
            array_push($arErrors, str_replace('-', ': ', $szResult));
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback;
    }

    private function ServerPost($parameters) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->ServiceURL);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        $rs = curl_exec($ch);

        curl_close($ch);

        return $rs;
    }

    /**
  * 自訂排序使用
  */
  private static function merchantSort($a,$b)
  {
    return strcasecmp($a, $b);
  }
    
    private function EncCheckMacValue($checkMacValue, $encType = EncryptType::ENC_MD5) {
        $szCheckMacValue = $checkMacValue;
        switch ($encType) {
            case EncryptType::ENC_SHA256:
                // SHA256 編碼
                $szCheckMacValue = hash('sha256', $szCheckMacValue);
                break;
            case EncryptType::ENC_MD5:
            default:
                // MD5 編碼
                $szCheckMacValue = md5($szCheckMacValue);
        }
        return $szCheckMacValue;
    }
    
}
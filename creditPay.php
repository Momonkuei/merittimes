<?php
header("Content-Type:text/html; charset=utf-8");
include 'layoutv3/init.php';
include 'include/ECPay.Payment.Integration.php';


$donation_data =$this->cidb->where('keyname','function_constant_donation')->get('sys_config')->row_array();
if(!empty($donation_data) && $donation_data['keyval']=='true'){
    $query = $this->cidb->select('*')->where('order_number',$_SESSION['OrderNumber'])->get('donationorder');
    $result = $query->row_array();


    if(empty($result)){
        echo "
        <script>
            alert('未查訊到項目 / 待滯過久 請重新選擇捐款項目!');
            parent.location.href='/donation_tw_1.php';	
        </script>";
        exit;
    }

    /**
    * 重要資料...
    */
    //****************************************母版才需要這段******************************************************************
    $url=str_replace('web2','show',$_SERVER['SERVER_NAME']);
    //***********************************************************************************************************************
    if($_SERVER['REQUEST_SCHEME']=='https'){
        $url='https://'.$url;
    }else{
        $url='http://'.$url;
    }
    try {
            
        $obj = new ECPay_AllInOne();

        //服務參數
        $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置
        $obj->HashKey     = 'spPjZn66i0OhqJsQ' ;                                           //測試用Hashkey，請自行帶入ECPay提供的HashKey
        $obj->HashIV      = 'hT5OJckN45isQTTs' ;                                           //測試用HashIV，請自行帶入ECPay提供的HashIV
        $obj->MerchantID  = '3002599';                                                          //測試用MerchantID，請自行帶入ECPay提供的MerchantID

        //正式區
        // $obj->ServiceURL  = "https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置
        // $obj->HashKey     = '' ;
        // $obj->HashIV      = '' ;
        // $obj->MerchantID  = '';       

        // $aaa = FRONTEND_DOMAIN;
        // FRONTEND_DOMAIN

        $obj->EncryptType = '1';                                                           //CheckMacValue加密類型，請固定填入1，使用SHA256加密
        //基本參數(請依系統規劃自行調整)
        $MerchantTradeNo = $_SESSION['OrderNumber'];
        $obj->Send['ReturnURL']         = $url."/creditPay_back.php" ;    //付款完成通知回傳的網址
        $obj->Send['ClientBackURL']     = $url."/donation_tw_3.php" ;    //付款完轉跳網址

        $obj->Send['MerchantTradeNo']   = $MerchantTradeNo;                          //訂單編號
        $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                       //交易時間
        $obj->Send['TotalAmount']       = $result['total'];                          //交易金額
        $obj->Send['TradeDesc']         = "您於本站本次的交易名細";                          			//交易描述
        $obj->Send['NeedExtraPaidInfo']         = "Yes"; 			//交易回傳所有	
        $obj->Send['ChoosePayment']     = ECPay_PaymentMethod::Credit ;              //付款方式:Credit

        //訂單的商品資料
        array_push($obj->Send['Items'], array('Name' => "此次捐款項目", 'Price' => (int)$result['total'],'Currency' => "元", 'Quantity' => (int) "1", 'URL' => "dedwed"));


        $obj->SendExtend['Redeem']   = false ;           //是否使用紅利折抵，預設false
        $obj->SendExtend['UnionPay'] = false;          //是否為聯營卡，預設false;
        //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
        //以下參數不可以跟信用卡定期定額參數一起設定
        if(isset($result['creditnum']) && $result['creditnum']!=''){
            $obj->SendExtend['CreditInstallment'] = $result['creditnum'] ;
        }else{
            $obj->SendExtend['CreditInstallment'] = '' ;    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24 
        }
        //2020-12-01 經理來信 加入分期 3 6 12 ; 淨土寺不能分期...

        //Credit信用卡定期定額付款延伸參數(可依系統需求選擇是否代入)
        //以下參數不可以跟信用卡分期付款參數一起設定
        if(isset($result['payRegular']) && $result['payRegular']!=''){
            $obj->SendExtend['PeriodAmount'] = $result['total'] ;    //每次授權金額，預設空字串
            $obj->SendExtend['PeriodType']   = 'M' ;    //週期種類，預設空字串
            $obj->SendExtend['Frequency']    = '1' ;    //執行頻率，預設空字串
            $obj->SendExtend['ExecTimes']    = $result['payRegular'] ;    //執行次數，預設空字串
            $obj->SendExtend['PeriodReturnURL'] = $url."/creditPay_back.php" ;
        }

    
        // print_r($obj);die;
        //產生訂單(auto submit至ECPay)
        $obj->CheckOut();

    // print_r($obj->Send);

    } catch (Exception $e) {
        echo $e->getMessage();
    } 
}

?>

<?php 


header("Content-Type:text/html; charset=utf-8");
include 'layoutv3/only_load_database.php';

if(!empty($_POST)){
    foreach ($_POST as $key => $value) $str.= $key."=>".$value."||";
    $tAry=array("log"=>$str);
    $cidb->insert('log',$tAry);

    $OrderID= $_POST['MerchantTradeNo'];
    $query = $cidb->select('*')->where('order_number',$OrderID)->get('donationorder');
    $result = $query->row_array();

    $SqlArry = array();
    //確認$$...
    if($result['total'] == $_POST['TradeAmt']){

        $SqlArry = array(
            "PaymentDate"=>!empty($_POST['PaymentDate'])?$_POST['PaymentDate']:'',
            "RtnMsg"=>!empty($_POST['RtnMsg'])?$_POST['RtnMsg']:'',
            "RtnCode"=>!empty($_POST['RtnCode'])?$_POST['RtnCode']:'',
            "TradeAmt"=>!empty($_POST['TradeAmt'])?$_POST['TradeAmt']:'',
            "PaymentTypeChargeFee"=>!empty($_POST['PaymentTypeChargeFee'])?$_POST['PaymentTypeChargeFee']:'',
            "TradeNo"=>!empty($_POST['TradeNo'])?$_POST['TradeNo']:'',
            "order_status"=>($_POST['RtnCode']==1)?1:3,
            "memo"=>$str,
        );
        // print_r($SqlArry);die;
        if($SqlArry){
            $cidb->where('order_number', $OrderID);
            $res = $cidb->update("donationorder",$SqlArry);
            if($res == 1) {
                echo '1|OK';
            }

            /**
            * 寄信區塊
            */

            // 找一下寄件人有沒有設定
            $query = $cidb->select('*,topic as name,other1 as email')->where('type','email')->where('is_enable',1)->where('is_home',1)->order_by('sort_id')->get('html');
            $from = $query->row_array();
            
            // 找一下收件人有沒有設定
            $query = $cidb->select('*,topic as name,other1 as email')->where('type','email')->where('is_enable',1)->where('is_news',1)->order_by('sort_id')->get('html');
            $tos = $query->result_array();

            //網站名稱
            $query = $cidb->select('*')->where('keyname','admin_title')->get('sys_config');
            $web_data = $query->row_array();
        
            $body_html = "  ＊此郵件是系統自動發送，請勿直接回覆此郵件！<br>
                        親愛的 ".$result['buyer_name']." 您好，<br>
                        感謝您的捐款！<br> 
                        以下是您的填寫的捐款資訊，我們將遵守個人資料隱私權之重要性。<br>
                        捐款編號： ".$OrderID." <br>
                        日期： ".$_POST["TradeDate"]." <br>
                        會員姓名︰ ".$result['buyer_name']." <br>
                        E-Mail︰".$result['buyer_login_account']."<br>
                        項目︰".$result['item_name']."<br>
                        金額︰".$result['total']."<br>
                        若您有任何疑問，您可透過以下資訊與我們連絡<br>

                        ".$web_data['keyval']."敬上<br>";

            //設定cc收件者
            // if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true){
            //     if(!empty($result['buyer_login_account'])) {$cc_mail = $result['buyer_login_account'];}
            // }else{
            //     $cc_mail = NULL;
            // }
            if(!empty($result['buyer_login_account'])){
                $cc_mail = $result['buyer_login_account'];
            }else{
                $cc_mail = NULL;
            }

            if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
                and $tos and count($tos) > 0 and isset($tos[0]['id'])){
              
                $email_return = email_send_to_by_sendmail($from,$tos, '捐款信件', '', $body_html,$cc_mail);               
                
            }
            //寄信區塊END 
        }

    }

    $SqlArry = array();
    //定期定額 回傳確認 RtnCode=1才會寄信
    if($result['payRegular'] == $_POST['ExecTimes'] && $result['total'] == $_POST['FirstAuthAmount'] && $_POST['RtnCode'] == 1){

        $SqlArry = array(            
            "TotalSuccessTimes"=>!empty($_POST['TotalSuccessTimes'])?$_POST['TotalSuccessTimes']:'',            
        );

        $cidb->where('order_number', $OrderID);
        $res = $cidb->update("donationorder",$SqlArry);
        if($res == 1) {

            /**
            * 寄信區塊
            */

            // 找一下寄件人有沒有設定
            $query = $cidb->select('*,topic as name,other1 as email')->where('type','email')->where('is_enable',1)->where('is_home',1)->order_by('sort_id')->get('html');
            $from = $query->row_array();
            
            // 找一下收件人有沒有設定
            $query = $cidb->select('*,topic as name,other1 as email')->where('type','email')->where('is_enable',1)->where('is_news',1)->order_by('sort_id')->get('html');
            $tos = $query->result_array();

        
            $body_html = "  ＊此郵件是系統自動發送，請勿直接回覆此郵件！<br>
                        親愛的 ".$result['buyer_name']." 您好，<br>
                        感謝您的捐款！<br> 
                        以下是您的填寫的捐款資訊，我們將遵守個人資料隱私權之重要性。<br>
                        捐款編號： ".$OrderID." <br>
                        日期： ".$_POST['ProcessDate']." <br>
                        會員姓名︰ ".$result['buyer_name']." <br>
                        E-Mail︰".$result['buyer_login_account']."<br>
                        項目︰".$result['item_name']."<br>
                        定期定額成功次數︰".$_POST['TotalSuccessTimes']."<br> 
                        本次金額︰".$_POST['Amount']."<br>
                        若您有任何疑問，您可透過以下資訊與我們連絡<br>

                        蓮心自強服務協會<br>
                        地址: 臺中市大甲區奉化里和平路２６８號<br>
                        電話: 04-2680-584";

            //設定cc收件者
            if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true){
                if(!empty($result['buyer_login_account'])) {$cc_mail = $result['buyer_login_account'];}
            }else{
                $cc_mail = NULL;
            }

            if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
                and $tos and count($tos) > 0 and isset($tos[0]['id'])){

                 $email_return = email_send_to_by_sendmail($from,$tos, '捐款信件', '', $body_html,$cc_mail);               
                
            }
            //寄信區塊END 

        }
    }
}else{
    echo 'error';
}


?>
<?php
class Sms_lib
{
    static public function sendsms($subject, $content, $mobile, $sendtime, $test = 0)
    {
        global $DBlink;
        $sql = $DBlink->query("select * from setting_website where `key`='sms_key'");
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $sms_key = $row['value'];

        $cust_domain = 'botanicgarden.com.tw';
        $url = '192.168.0.62/sms_system/send.php';

        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        $postdata = http_build_query(
            array(
                'url' => $cust_domain,
                'sms_key' => $sms_key,
                'subject' => $subject,
                'content' => $content,
                'mobile' => $mobile,
                'send_time' => $sendtime,
                'ip' => $ip,
                'test' => $test
            )
        );
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postdata,
        );
        curl_setopt_array($ch, $options);
        $code = str_replace(array("\r\n", "\r", "\n"), "", curl_exec($ch));
        curl_close($ch);
        if ($code == "00000") {
            $status = 1;
            $error_msg = '';
        } else {
            $status = 0;
            $error_msg = $code;
        }

        $sql = $DBlink->query("insert into log_customerService (id) values('')");
        $insertID = $DBlink->lastInsertId();
        $sql = $DBlink->prepare("update log_customerService set 
        type=:type,
        subject=:subject,
        content=:content,
        status=:status,
        error_msg=:error_msg,
        lang=:lang,
        priority='0',
        update_time=:time,
        update_user='system',
        create_time=:time,
        ip=:ip
        where id=:id
        ");
        $sql->execute(array(
            ":type" => 1,
            ":subject" => $subject,
            ":content" => $content,
            ":status" => $status,
            ":error_msg" => $error_msg,
            ":lang" => 1,
            ":time" => date("Y-m-d H:i:s"),
            ":ip" => $ip,
            ":id" => $insertID
        ));
    }
}

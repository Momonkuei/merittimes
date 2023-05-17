<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Member success</title>
</head>

<body style="padding: 0; margin: 0;">

  <div style="width:640px;margin:0 auto 30px auto;"><img src="cid:logo" alt=""></div>

  <div style="width:640px;margin:0 auto;font-family:'PingFang TC','\005fae\008edf\006b63\009ed1\009ad4','Microsoft JhengHei','Helvetica Neue',Helvetica,Arial,sans-serif;">

    <table style="margin-bottom:12px;width:100%;border-collapse:collapse;border-spacing:0;border:1px solid #eaeaea">
      <thead>
        <tr>
          <th style="padding:4px;background-color:#f5a623;color:#ffffff;border-bottom:1px solid #eaeaea;letter-spacing:3px">加入會員成功通知函</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding:16px">
			<p style="margin:0 0 16px 0">親愛的&nbsp;<?php echo $savedata['name']?>&nbsp;您好：</p>
            <p style="margin:0">歡迎您加入<?php echo $this->data['sys_configs']['admin_title']?>，我們誠摯的歡迎您！<br>以下是您的填寫的註冊的會員資訊，我們將遵守每個會員個人資料隱私權之重要性。</p>
          </td>
        </tr>
      </tbody>
    </table>
    
	<?php if(isset($form_fields) and !empty($form_fields)):?>
    <table style="margin-bottom:12px;width:100%;border-collapse:collapse;border-spacing:0;border:1px solid #eaeaea;background:#fff9e0">
      <tbody>
        <tr>
          <td style="padding:0">
            <table style="width:100%;border-collapse:collapse;border-spacing:0;border:1px solid #eaeaea;background-color:#fff">
              <tbody>
                <tr>
                  <th style="padding:4px;background:#fff;color:#222;letter-spacing:3px">註冊會員資訊</th>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td style="padding:0">
            <table style="width:100%;border-collapse:collapse;border-spacing:0;border:1px solid #eaeaea;background-color:#fff9e0">
              <tbody>
				<?php foreach($form_fields as $k => $v):?>
					<tr>
					  <th style="padding:10px;color:#655;border:1px dotted #ccc;vertical-align:top;letter-spacing:3px;<?php echo $v['style']?>"><?php echo $v['name']?></th>
						<?php if($k == (count($form_fields)-1)):?>
							<td style="padding:10px 20px;border:1px dotted #ccc"><a href="mailto:<?php echo $v['value']?>" style="color:#06c" target="_blank"><?php echo $v['value']?></a></td>
						<?php else:?>
							<td style="padding:10px 20px;border:1px dotted #ccc;<?php echo $v['style']?>"><?php echo $v['value']?></td>
						<?php endif?>
					</tr>
				<?php endforeach?>
<?php if(0):?>
                <tr>
                  <th style="padding:10px;color:#655;border:1px dotted #ccc;vertical-align:top;letter-spacing:3px">註冊日期</th>
                  <td style="padding:10px 20px;border:1px dotted #ccc">2019-08-22</td>
                </tr>
                <tr>
                  <th style="padding:10px;color:#655;border:1px dotted #ccc;vertical-align:top;letter-spacing:3px">使用者名稱</th>
                  <td style="padding:10px 20px;border:1px dotted #ccc"><a href="mailto:vencen@buyersline.com.tw" style="color:#06c" target="_blank">vencen@buyersline.com.tw</a></td>
                </tr>
                <tr>
                  <th style="padding:10px;color:#655;border:1px dotted #ccc;vertical-align:top;letter-spacing:3px">會員姓名</th>
                  <td style="padding:10px 20px;border:1px dotted #ccc">VVV</td>
                </tr>
                <tr>
                  <th style="padding:10px;color:#655;border:1px dotted #ccc;vertical-align:top;letter-spacing:3px">E-Mail</th>
                  <td style="padding:10px 20px;border:1px dotted #ccc"><a href="mailto:vencen@buyersline.com.tw" style="color:#06c" target="_blank">vencen@buyersline.com.tw</a></td>
                </tr>
<?php endif?>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
	<?php endif?>

    <table style="margin-bottom:12px;width:100%;border:1px solid #d9d9d9;background-color:#f4f4f4">
      <tbody>
        <tr>
          <td style="padding:6px 12px;color:#e00">
            ＊此郵件是系統自動發送，請勿直接回覆此郵件！
          </td>
        </tr>
        <tr>
          <td style="padding:0 12px 12px 12px">
			若您對我們的服務有任何疑問，您可利用線上客服 <a style="color:#06c" href="<?php echo FRONTEND_DOMAIN?>/contact_<?php echo $this->data['ml_key']?>.php" target="_blank"><?php echo FRONTEND_DOMAIN?>/contact_<?php echo $this->data['ml_key']?>.php</a> 與我們連絡，<br>
			或直接E-Mail至客服信箱 <a style="color:#06c" href="mailto:<?php echo $this->data['sys_configs']['service_admin_mail']?>" target="_blank"><?php echo $this->data['sys_configs']['service_admin_mail']?></a> 告訴我們您的需求。
          </td>
        </tr>
      </tbody>
    </table>

  </div>

  <p style="color:#666; font-size:12px; text-align:center; margin-top:30px;">Copyright © <?php echo date('Y')?> <?php echo $this->data['sys_configs']['admin_title_'.$this->data['ml_key']]?> All Rights Reserved.</p>

</body>

</html>

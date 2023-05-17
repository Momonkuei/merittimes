<?php if(isset($body_type) or isset($mail_type)):?>
	<?php if($body_type == '1'):?>
＊此郵件是系統自動發送，請勿直接回覆此郵件！ 

為了保護個人資料安全，本通知信將不顯示訂單明細。

<?php if($mail_type == '2'):?>
<?php echo $member['name']?> 您好！ 
<?php endif?>
<?php if($mail_type == '1'):?>
我們已經收到 <?php echo $member['name']?> 的訂購資訊，請至 
<?php elseif($mail_type == '2'):?>
我們已經收到您的訂購資訊，請至 
<?php endif?>
<?php if($mail_type == '1'):?>
<?php echo FRONTEND_DOMAIN?>/_i/backend.php?r=shoporderform
<?php elseif($mail_type == '2'):?>
<?php echo FRONTEND_DOMAIN?>/memberorderlist_tw.php
<?php endif?>
查看

<?php echo $this->data['sys_configs']['admin_title']?>  <?php echo FRONTEND_DOMAIN?>

	<?php elseif($body_type == '2'):?>
		<!DOCTYPE html>
		<html lang="en">

		<head>
		  <meta charset="UTF-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1.0">
		  <meta http-equiv="X-UA-Compatible" content="ie=edge">
		  <title>Order Finish</title>
		</head>

		<body style="padding: 0; margin: 0;">

		  <div style="width:640px;margin:0 auto 30px auto;"><img src="cid:logo" alt=""></div>

		  <div style="width:640px;margin:0 auto;font-family:'PingFang TC','\005fae\008edf\006b63\009ed1\009ad4','Microsoft JhengHei','Helvetica Neue',Helvetica,Arial,sans-serif;">

			<table style="margin-bottom:12px;width:100%;border-collapse:collapse;border-spacing:0;border:1px solid #eaeaea">
			  <thead>
				<tr>
				  <th style="padding:4px;background-color:#f5a623;color:#ffffff;border-bottom:1px solid #eaeaea;letter-spacing:3px">訂單完成通知函</th>
				</tr>
			  </thead>
			  <tbody>
				<tr>
				  <td style="padding:16px">
					<?php if($mail_type == '2'):?>
					<p style="margin:0 0 16px 0">親愛的&nbsp;<?php echo $member['name']?>&nbsp;您好：</p>
					<?php endif?>
					<p style="margin:16px 0 0 0">為了保護您的個人資料安全，本通知信將不顯示訂單明細。<br>
					<?php if($mail_type == '1'):?>
					  我們已經收到 <?php echo $member['name']?> 的訂購資訊，請至<br>
					  <a style="color:#06c" href="<?php echo FRONTEND_DOMAIN?>/_i/backend.php?r=shoporderform" target="_blank"><?php echo FRONTEND_DOMAIN?>/_i/backend.php?r=shoporderform</a><br>
					<?php elseif($mail_type == '2'):?>
					  我們已經收到您的訂購資訊，請至<br>
					  <a style="color:#06c" href="<?php echo FRONTEND_DOMAIN?>/memberorderlist_tw.php" target="_blank"><?php echo FRONTEND_DOMAIN?>/memberorderlist_tw.php</a><br>
					<?php endif?>
					<?php if($mail_type == '2'):?>
					  感謝您對<?php echo $this->data['sys_configs']['admin_title']?>的支持與信賴，如有任何需要服務的地方，<br>歡迎使用 E-mail與我們聯繫，再次感謝您的訂購。</p>
					<?php endif?>
				  </td>
				</tr>
			  </tbody>
			</table>

			<table style="margin-bottom:12px;width:100%;border:1px solid #d9d9d9;background-color:#f4f4f4">
			  <tbody>
				<tr>
				  <td style="padding:6px 12px;color:#e00;">
					＊此郵件是系統自動發送，請勿直接回覆此郵件！
				  </td>
				</tr>

			  </tbody>
			</table>

		  </div>

		  <p style="color:#666; font-size:12px; text-align:center; margin-top:30px;">Copyright © <?php echo date('Y')?> <?php echo $this->data['sys_configs']['admin_title']?> All Rights Reserved.</p>

		</body>

		</html>
	<?php endif?>
<?php endif?>

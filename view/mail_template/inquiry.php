<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Inquiry</title>
</head>
<body style="padding:0; margin:0;">

  <p style="color:#ff0000; font-size:16px; text-align:center; margin:30px 0;"><?php echo $no_reply?></p>
  <div style="width:640px;margin:0 auto;background-color:#0050A3;text-align:center;"><img src="cid:logo" alt=""></div>

	<?php if(isset($form_items) and !empty($form_items)):?>
  <table style="width: 100%; max-width: 640px; margin: 30px auto 0 auto; border-collapse: collapse; font-family:'PingFang TC','\005fae\008edf\006b63\009ed1\009ad4','Microsoft JhengHei','Helvetica Neue',Helvetica,Arial,sans-serif;">
    <thead>
      <tr>
        <th style="text-align: left; padding: 5px 15px;">產品名稱</th>
        <th style="text-align: left; padding: 5px 15px; width: 35px;">數量</th>
      </tr>
    </thead>
    <tbody>
		<?php foreach($form_items as $k => $v):?>
		  <tr>
			<td style="padding: 5px 15px; border-top: 1px solid #ccc;">
			  <p><a style="color:#000;text-decoration: none;" href="<?php echo $v['url']?>" target="_blank"><?php echo $v['name']?></a></p>
			  <p><?php // 李哥說先隱藏?></p>
			</td>
			<td style="padding: 5px 15px; border-top: 1px solid #ccc; text-align: center;"><?php echo $v['amount']?></td>
		  </tr>
		<?php endforeach?>
<?php if(0):?>
      <tr>
        <td style="padding: 5px 15px; border-top: 1px solid #ccc;">
          <p><a style="color:#000;text-decoration: none;" href="#" target="_blank">PLCC 2835 0.5W IP LC</a></p>
          <p>TD00002PG 非反相電路的晶體管陣列。輸出箝位二極管箝位的電感性負載驅動中產生的反電動勢，輸入電阻，以限制基極電流是建立。</p>
        </td>
        <td style="padding: 5px 15px; border-top: 1px solid #ccc; text-align: center;">1</td>
      </tr>
      <tr>
        <td style="padding: 5px 15px; border-top: 1px solid #ccc;">
          <p><a style="color:#000;text-decoration: none;" href="#" target="_blank">PLCC 2835 0.5W IP LC</a></p>
          <p>TD00002PG 非反相電路的晶體管陣列。輸出箝位二極管箝位的電感性負載驅動中產生的反電動勢，輸入電阻，以限制基極電流是建立。</p>
        </td>
        <td style="padding: 5px 15px; border-top: 1px solid #ccc; text-align: center;">1</td>
      </tr>
<?php endif?>
    </tbody>
  </table>
	<?php endif?>

	<?php if(isset($form_fields) and !empty($form_fields)):?>
  <table style="width: 100%; max-width: 640px; margin: 30px auto 0 auto; border-collapse: collapse; font-family:'PingFang TC','\005fae\008edf\006b63\009ed1\009ad4','Microsoft JhengHei','Helvetica Neue',Helvetica,Arial,sans-serif;">
    <tbody>
		<?php foreach($form_fields as $k => $v):?>
		  <tr>
			<td style="padding: 0 20px; border-top: 1px solid #ccc; <?php echo $v['style']?>">
				<p style="font-weight:bold;"><?php echo $v['name']?></p>
			</td>
			<td style="padding: 0 20px; border-top: 1px solid #ccc; <?php echo $v['style']?>">
			<p><?php echo $v['value']?></p>
			</td>
		  </tr>
		<?php endforeach?>

	<?php if(0):?>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; background-color:#fff9e0;">
          <p style="font-weight:bold;">姓名</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; background-color:#fff9e0;">
        <p>XXX</p>
        </td>
      </tr>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc;">
          <p style="font-weight:bold;">性別</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc;">
          <p>女</p>
        </td>
      </tr>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; background-color:#fff9e0;">
          <p style="font-weight:bold;">公司名稱</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; background-color:#fff9e0;">
          <p>ABC</p>
        </td>
      </tr>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc;">
          <p style="font-weight:bold;">傳真</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc;">
          <p>00-000-00000</p>
        </td>
      </tr>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; background-color:#fff9e0;">
          <p style="font-weight:bold;">電話</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; background-color:#fff9e0;">
        <p>00-00000000</p>
        </td>
      </tr>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc;">
          <p style="font-weight:bold;">分機</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc;">
          <p>15</p>
        </td>
      </tr>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; background-color:#fff9e0;">
          <p style="font-weight:bold;">E-Mail</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; background-color:#fff9e0;">
          <p>abc@buyersline.com.tw</p>
        </td>
      </tr>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc;">
          <p style="font-weight:bold;">地址</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc;">
          <p>台中市文心路三段155-1號</p>
        </td>
      </tr>
      <tr>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; background-color:#fff9e0;">
          <p style="font-weight:bold;">意見</p>
        </td>
        <td style="padding: 0 20px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; background-color:#fff9e0;">
          <p>我沒有意見</p>
        </td>
      </tr>
	<?php endif?>

    </tbody>
  </table>
	<?php endif?>
  <p style="color:#666; font-size:12px; text-align:center; margin-top:30px;">Copyright © <?php echo date('Y')?> <?php echo $aaa_name?> All Rights Reserved.</p>

</body>
</html>

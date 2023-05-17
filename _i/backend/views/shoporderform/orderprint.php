<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="" lang="" xml:lang="">
<header>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<title>出貨單/揀貨單</title>

<style>
*{
  font-size:16px;
}

h1{
  font-size:24px;
  text-align:center;}

.customer{
  width:100%;
  border-spacing:0px;
  border-top:1px solid #000;
  border-left:1px solid #000;
}

.customer th{
  border-bottom:1px solid #000;
  border-right:1px solid #000;
  vertical-align:top;
}

.customer td{
  border-bottom:1px solid #000;
  border-right:1px solid #000;
  vertical-align:top;
}

.order{
  width:100%;
  border-spacing:0px;
  margin-bottom:30px;
}

.order caption{
  font-weight:bold;
  font-size:20px;
}

.order th{
  border-top:1px solid #000;
  border-bottom:3px double #000;
  vertical-align:top;
}

.order td{
  border-bottom:1px solid #000;
  vertical-align:top;
  text-align:center;
}

.comment{
  margin:20px 0px;
  border-bottom:1px dotted #999;
}

.comment p{padding:0px 20px;}
</style>
</header>
<body>
    <div>
        <div>
			<p style="text-align: center;"><img src="/images/<?php echo $this->data['ml_key']?>/logo.png" alt="">&nbsp;</p>
        
        
        </div>
    <h1><?php echo $this->data['sys_configs']['admin_title']?>&nbsp;&nbsp;出貨單</h1>
    <table class="customer">
      <tr>
		<th>訂單日期：<?php echo str_replace('-',' / ', substr($updatecontent['create_time'],0,10))?></th>
	  <th>訂單編號：<?php echo $updatecontent['order_number']?>
	</th></tr>
      <tr>
        <td width="50%">
		  訂購人：<?php echo $updatecontent['buyer_name']?><br />
          地址：<?php echo $updatecontent['buyer_addr']?><br/><br/>
          電話：<?php echo $updatecontent['buyer_phone']?><br/>
          手機：<?php echo $updatecontent['buyer_phone']?><br/>          
         
        </td>
        <td width="50%">
          收貨人：<?php echo $updatecontent['recipient_name']?><br />
          地址：<?php echo $updatecontent['recipient_addr']?><br/><br/>
          電話：<?php echo $updatecontent['recipient_phone']?><br/>
          備用電話：<?php echo $updatecontent['recipient_mobile']?><br/>
         </td>
      </tr>
    </table>
    <div class="comment">備註：<br/> <?php echo $updatecontent['detail']?><p></p></div>
    <table class="order">
      <caption>訂購明細</caption>
      <tr><th>序號</th><th>貨號</th><th>商品名稱</th><th>規格</th><th>數量</th></tr>
		<?php if(isset($this->data['updatecontent']['details']['car']) and count($this->data['updatecontent']['details']['car']) > 0):?>
			<?php $x=1?>
			<?php foreach($this->data['updatecontent']['details']['car'] as $k => $v):?>
				<tr>
					<td><?php echo $x?></td>
					<td><?php if(isset($v['item']['name2'])){echo $v['item']['name2'];}?></td>
					<td><?php echo $v['item']['name']?></td>
					<?php if(0):?>
						<td><?php foreach($v['specs'] as $kk => $vv):?><?php echo $vv['name'].':'.$vv['value']?>, <?php endforeach?></td>
					<?php endif?>
					<td><?php echo $v['spec']?></td>
					<td><?php echo $v['amount']?></td>
				</tr>
				<?php $x++?>
			<?php endforeach?>
		<?php endif?>
    </table>
  <p style='page-break-after:always'></p>  
 
  
  
  
  <div>
    <div><p style="text-align: center;"><img src="/images/<?php echo $this->data['ml_key']?>/logo.png" alt="">&nbsp;</p></div>
    <h1><?php echo $this->data['sys_configs']['admin_title']?>&nbsp;&nbsp;揀貨單</h1>
    <table class="customer">
      <tr>
		<th>訂單日期：<?php echo str_replace('-',' / ', substr($updatecontent['create_time'],0,10))?></th>
		<th>訂單編號：<?php echo $updatecontent['order_number']?></tr>
      <tr>
        <td width="50%">
          <p>單號:</p>
            <p>&#160;</p>
            <p>貨運單號:</p>
        </td>
        <td width="50%">收貨人：
          <?php echo $updatecontent['recipient_name']?>
          <br />
地址：
<?php echo $updatecontent['recipient_addr']?>
<br>
電話：
<?php echo $updatecontent['recipient_phone']?>
<br/>
備用電話：
<?php echo $updatecontent['recipient_mobile']?>
<br/>
     </td>
      </tr>
    </table>
    <div class="comment">備註：<br/><p></p></div>
    <table class="order">
      <caption>訂購明細<br />
      </caption>
      <tr><th>序號</th><th>貨號</th><th>商品名稱</th><th>規格</th><th>數量</th></tr>
			<?php if(isset($this->data['updatecontent']['details']['car']) and count($this->data['updatecontent']['details']['car']) > 0):?>
				<?php $x=1?>
				<?php foreach($this->data['updatecontent']['details']['car'] as $k => $v):?>
					<tr>
						<td><?php echo $x?></td>
						<td><?php if(isset($v['item']['name2'])){echo $v['item']['name2'];}?></td>
						<td><?php echo $v['item']['name']?></td>
						<?php if(0):?>
							<td><?php foreach($v['specs'] as $kk => $vv):?><?php echo $vv['name'].':'.$vv['value']?>, <?php endforeach?></td>
						<?php endif?>
						<td><?php echo $v['spec']?></td>
						<td><?php echo $v['amount']?></td>
					</tr>
					<?php $x++?>
				<?php endforeach?>
			<?php endif?>
          </table>
    <div><table align="center" border="0" cellpadding="1" cellspacing="1" style="width: 90%">
	<tbody>
		<tr>
			<td>
				<table align="center" border="0" cellpadding="1" cellspacing="1" style="width: 90%">
            <tbody>
                <tr>
                    <td>訂單處理:</td>
                    <td>揀貨:</td>
                    <td>核對:</td>
                    <td>包裝:</td>
                   
                </tr>
            </tbody>
        </table>
        <p>&#160;</p>
			</td>
		</tr>
	</tbody>
</table>
<p>&nbsp;
	</p>
</div>
  </div>

</body>
</html>
<?php die?>

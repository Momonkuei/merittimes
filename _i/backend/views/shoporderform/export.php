<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40"><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 11">
<link rel=File-List href="order%201%20.files/filelist.xml">
<link rel=Edit-Time-Data href="order%201%20.files/editdata.mso">
<link rel=OLE-Object-Data href="order%201%20.files/oledata.mso">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:LastAuthor>TIGER-XP</o:LastAuthor>
  <o:Created>2008-03-20T03:43:19Z</o:Created>
  <o:LastSaved>2008-03-20T03:53:20Z</o:LastSaved>
  <o:Version>11.5606</o:Version>
 </o:DocumentProperties>
</xml><![endif]-->
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>order 1 </x:Name>
    <x:WorksheetOptions>
     <x:DefaultRowHeight>330</x:DefaultRowHeight>
     <x:Selected/>
     <x:DoNotDisplayGridlines/>
     <x:Panes>
      <x:Pane>
       <x:Number>3</x:Number>
       <x:ActiveRow>10</x:ActiveRow>
       <x:ActiveCol>7</x:ActiveCol>
      </x:Pane>
     </x:Panes>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->

<style>
.style0
	{mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:新細明體, serif;
	mso-font-charset:136;
	border:none;
	mso-protection:locked visible;
	mso-style-name:一般;
	mso-style-id:0;}
td
	{mso-style-parent:style0;
	font-size:10.0pt;
	mso-number-format:"\@";
	white-space:normal;
	vertical-align:top;
	text-align:left
	}
body,td,th {
	font-size: 10pt;
}
</style>
</head>
<body>

<?php //if($result_data and count($row_total->total >0) > 0):?>
<?php if($result_data and count($row_total >0) > 0):?>
<table bordercolor="#dddddd" cellspacing="0" border="1" align="center" style="font-size:13px;letter-spacing:2px; text-align:center">
 <tr>
 <td colspan="19" ><?php echo $this->data['admin_title']?> - 訂單匯出 </td>
  </tr>
  <tr>
      <td>匯出日期</td>
      <td colspan="18" ><?=date("Y-m-d H:i:s")?></td>
  </tr>
    <tr>
      <td bgcolor="#FF99CC">訂單編號</td>
      <td bgcolor="#FF99CC">訂單狀態</td>      
      <td bgcolor="#FF99CC">訂購商品</td>
      <td bgcolor="#FF99CC">訂購金額</td>
      <td bgcolor="#FF99CC">運費</td>  
      <td bgcolor="#FF99CC">應付金額</td>
      <td bgcolor="#FF99CC">付款方式</td>
      <td bgcolor="#FF99CC">訂單備註</td>
      <td bgcolor="#FF99CC">收件者</td>
      <td bgcolor="#FF99CC">收件地址</td>
      <td bgcolor="#FF99CC">收件者電話</td>
      <td bgcolor="#FF99CC">收件者手機</td>
      <td bgcolor="#FF99CC">收件者E-mail</td>      
	  <td bgcolor="#FF99CC">訂購者</td>
	  <td bgcolor="#FF99CC">訂購者聯絡電話</td>
      <td bgcolor="#FF99CC">訂購者手機</td>
      <td bgcolor="#FF99CC">訂購者Email</td>
      <td bgcolor="#FF99CC">訂購者地址</td>
      <td bgcolor="#FF99CC">訂單時間</td>
    </tr>
<?php
//while ($orders = mysql_fetch_object_s($result_data)) { 
//$status=$orders->status;
?>
<?php foreach($result_data as $orders):?>
	<tr>
      <td align="center">
      #<? if (function_exists('setOrdeNumber')) echo setOrdeNumber($orders->OrderNo);
          else echo $orders->OrderNo
       ?></td>
      <td align="center"><?=$gOrderStatus[$status]?></td>
      <td>
	  
	  <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="font-size:13px;letter-spacing:2px; text-align:center;">
        <tr bgcolor="#FFFFCC">
          <td align="center">商品編號</td>
          <td align="center">訂購商品</td>
          <td align="center">單價</td>
          <td align="center">訂購數量</td>
		  <td align="center">金額</td>
        </tr>
		<?php
		//訂單明細
		$nTotBonus = 0;
		$nCnt = 0;
		$query = "SELECT o.*, p.product_name, p.ProductID FROM ".$LANG_DB."order_detail o, ".$LANG_DB."product p WHERE o.ProductNo=p.ProductNo AND o.OrderNo='".$orders->OrderNo."'";
		$recOrd = mysql_query($query, $link);
		while ($rowOrd = mysql_fetch_object_s($recOrd)) {
			$nTotBonus += $rowOrd->bonus;
			$nCnt++;
		?>
        <tr>
          <td align="center"><?=$nCnt?></td>
          <td align="left">
		  <?=$rowOrd->product_name?> 
		  <? if(!empty($rowOrd->spec) && $gHasProductSpec==1){echo " - ".$rowOrd->spec;}?> </td>          
          <td x:num="<?=$rowOrd->price?>" style="text-align:right">&nbsp;</td>
          <td x:num="<?=$rowOrd->quantity?>" style="text-align:right">&nbsp;</td>
          <td x:num="<?=$rowOrd->amount?>" style="text-align:right">&nbsp;</td>          
        </tr>
		<? }?>
      </table>      </td>
      <td x:num="<?=$orders->amount?>" style="text-align:right"></td>
      <td x:num="<?=$orders->shipfee?>" style="text-align:right"></td>
      <td  x:num="<?=$orders->total - $orders->bonus_rebate - $orders->feedback_rebate  ?>" style="text-align:right"></td>
      <td>
	  
	  
      <? if($orders->payment==1){?>
       <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="font-size:13px;letter-spacing:2px; text-align:center;">
        <tr bgcolor="#FFFFCC">
          <td colspan="2" align="center"><?=$gPaymentMethod[$orders->payment]?></td>
         </tr>
		<?php
		
		$query = "SELECT * FROM ".$LANG_DB."order_credit WHERE OrderNo ='".$orders->OrderNo."' and  CardNO ='".$orders->card_appno."'";
		$recCard = mysql_query($query, $link);
		$rowCard = mysql_fetch_object_s($recCard);
		?>
        <tr>
          <td width="35%" align="center">付款日期 :</td>
          <td width="65%" align="center"><?=$rowCard->date?></td>
        </tr>
		 <tr>
          <td width="35%" align="center">卡號末四碼 :</td>
          <td width="65%" align="center"><?=$rowCard->card4no?></td>
        </tr>
         <tr>
          <td width="35%" align="center">授權碼 :</td>
          <td width="65%" align="center"><?=$rowCard->auth_code?></td>
        </tr>
         <tr>
          <td width="35%" align="center">付款金額 :</td>
          <td width="65%" align="center"><?=$rowCard->amount ?></td>
        </tr>
      </table>  
	  <?
      }else{
	  echo $gPaymentMethod[$orders->payment];
	  }
	  ?>      </td>
      <td><?=$orders->memo ?></td>
      <td><?=$orders->receiver ?></td>
      <td><?=$orders->r_ZIP ?> <?=$orders->r_address ?></td>
      <td><?=$orders->r_TEL ?></td>
      <td><?=$orders->r_mobile ?></td>
      <td><?=$orders->r_email ?></td>
      <td><?=$orders->name?></td>
      <td><?=$orders->tel ?></td>
      <td><?=$orders->mobile?></td>
      <td><?=$orders->email?></td>
      <td><?=$orders->zip . $orders->address ?></td>
      <td><?=$orders->order_date?></td>
  </tr>
<?php endforeach?>
</table>
<?php else:?>
查無資料
<?php endif?>
</body>
</html>

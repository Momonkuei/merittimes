<?php if($_SESSION[$this->data['router_method']]['step'] == '2'):?>

<!-- // DATA2:SINGLE -->
<?php $member = $data[$ID];//訂購人資料?>
<!-- // DATA2:SINGLE -->
<?php $shipment = $data[$ID];//運費與物流?>
<!-- // DATA2:SINGLE -->
<?php $recipient = $data[$ID];//收件人資料?>
<!-- // DATA2:SINGLE -->
<?php $invoice_config = $data[$ID];//發票設定?>
<!-- // DATA2:SINGLE -->
<?php $invoice = $data[$ID];//發票資訊和備註?>

<!-- // DATA2:MULTI -->
<?php $error_logs = $data[$ID];//錯誤訊息?>
<!-- // DATA2:MULTI -->
<?php $payments = $data[$ID];//金流?>
<!-- // DATA2:MULTI -->
<?php $physicals = $data[$ID];//物流?>
<!-- // DATA2:MULTI -->
<?php $member_address = $data[$ID];//地址簿?>

<script type="text/javascript">
	<?php if(0 and isset($error_logs) and !empty($error_logs)):?>
		alert('<?php echo $error_logs[0][1]?>');
		<?php if($data[$ID][0][2] != 2)://沒有加這個判斷式，會無限迴圈哦?>
			window.location.href='checkout_<?php echo $this->data['ml_key']?>.php?step=<?php echo $data[$ID][0][2]?>';
		<?php endif?>
	<?php endif?>
</script>


<div class="innerBlock">
  <div class="blockTitle">
    <span><?php echo t('選擇付款方式')?></span>
  </div>
  <div class="rwdTable">
    <table class="tableList payments">
      <thead>
        <tr>
          <th><?php echo t('付款方式')?></th>
          <th><?php echo t('說明')?></th>
        </tr>
      </thead>
      <tbody>
		<?php foreach($payments as $k => $v):?>
			<tr>
				<td>
				  <div class="radioBox_group">
				    <input type="radio" name="func" id="ggg_<?php echo $k?>" value="<?php echo $v['func']?>" <?php if(isset($_SESSION['save']['selecxt_payment']['func']) and $_SESSION['save']['selecxt_payment']['func'] == $v['func']):?> checked="checked" <?php endif?> >
				    <label for="ggg_<?php echo $k?>"><span class="signIcon"></span><?php echo $v['name']?></label>
				  </div>
				</td>
				<td> <?php echo $v['description']?></td>
			</tr>
		<?php endforeach?>
      </tbody>
    </table>
  </div><!-- .rwdTable -->

</div><!-- .innerBlock -->

<?php if(isset($physicals) and !empty($physicals)):?>
	<div class="innerBlock">
	  <div class="blockTitle">
		<span><?php echo t('選擇運送方式')?></span>
	  </div>
	  <div class="rwdTable">
		<table class="tableList physicals">
		  <thead>
			<tr>
				<th width="200"><?php echo t('配送方式')?></th>
				<th width="300"><?php echo t('基本運費')?></th>
				<th><?php echo t('說明')?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php foreach($physicals as $k => $v):?>

				<?// shipType item start ------?>
				<tr>
					<td>
						<div class="radioBox_group">
						  <input type="radio" id="aaa_<?php echo $k?>"  value="<?php echo $v['func']?>" <?php if(isset($_SESSION['save']['selecxt_physical']['func']) and $_SESSION['save']['selecxt_physical']['func'] == $v['func']):?> checked="checked" <?php else:?> name="func" <?php endif?> data-price="<?php //echo $item['pay']?>" >
						  <label for="aaa_<?php echo $k?>"><span class="signIcon"></span><?php echo $v['name']?></label>
						</div>
					</td>

					<td>
						<div class="formItem ">
							<label>
								<span><?php echo t('運費')?>：<?php echo $v['normal']?> </span>
								<?php if(isset($v['low_temperature']) && $v['low_temperature'] > 0):?>									
									<span>+<?php echo t('低溫')?> </span>
									<span class="coldship"><?php echo $v['low_temperature']?></span>									
								<?php endif?>
							</label>

							<?php if(isset($v['has_islands']) && $v['has_islands'] === true and isset($_SESSION['save']['selecxt_physical']['func']) and $_SESSION['save']['selecxt_physical']['func'] == $v['func']):?>
								<div class="plusPayOption tips">
									<div class="checkbox"><label><input type="checkbox" name="is_islands" value="<?php echo $v['func']?>" <?php if(isset($_SESSION['save']['selecxt_physical']['is_islands']) and $_SESSION['save']['selecxt_physical']['is_islands'] == $v['func']):?> checked="checked" <?php endif?> ><span><?php echo t('離島')?>+<?php echo $v['islands']?></span></label></div>
								</div>
							<?php endif?>


							<?php if(isset($v['no_islands']) && $v['no_islands'] === true):?>
								<div class="limitPay tips">
									<?php echo t('離島不適用')?>
								</div>
							<?php endif?>

						</div>
					</td>

					<td>
						<?php echo $v['description']?>
					</td>
				</tr>
				<?php // shipType item  end ------?>

			<?php endforeach?>
		  </tbody>
		</table>
	  </div><!-- .rwdTable -->

	</div><!-- .innerBlock -->
<?php endif?>

<form class="cont_form"><?php // 因為是用php來驗證表單欄位，所以這裡不需要多寫任何東西?>

  <div class="innerBlock">
    <div class="blockTitle">
      <span><?php echo t('訂購人資料')?></span>
    </div>

	<?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
		<div class="row">
		  <div class="form_group col-lg-4">
			<label class="must"><?php echo t('E-mail','en')?></label>
			<input type="text" value="<?php echo $member['login_account']?>" disabled="disabled" />
		  </div>
		  <div class="form_group col-lg-4">
			<label class="must"><?php echo t('訂購人')?></label>
			<input type="text" value="<?php echo $member['name']?>" disabled="">
		  </div>
		</div>
	<?php else:?>
		<div class="common_bk_txt">
			<?php echo t('為了簡化流程，第一次購物您不需要加入會員就可以直接進行購物。')?><br>
			<?php echo t('完成訂購後，系統將自動將您升級為會員。')?><br>
			<?php echo t('如已有帳號請先')?><a href="guestlogin_<?php echo $this->data['ml_key']?>.php?next=checkout_<?php echo $this->data['ml_key']?>.php"><?php echo t('登入會員')?></a>。
			<label class="must" style="display:block;"><?php echo t('為必填')?></label>
		</div>
		<div class="row member_form_1">
		  <div class="form_group col-lg-4">
			<label class="must"><?php echo t('E-mail')?></label>
			<input type="text" name="login_account" value="<?php echo $member['login_account']?>" autocomplete="off" />
		  </div>
		  <div class="form_group col-lg-4">
			<label class="must"><?php echo t('姓名')?></label>
			<input type="text" name="name" value="<?php echo $member['name']?>" placeholder="" autocomplete="off" />
		  </div>
		  <div class="form_group col-lg-4">
			<label><?php echo t('性別')?></label>
			<select name="gender">
			  <option value="">選擇性別</option>
			  <option value="男" <?php if(isset($member['gender']) and $member['gender'] == '1'):?> selected="selected" <?php endif?> ><?php echo t('男')?></option>
			  <option value="女" <?php if(isset($member['gender']) and $member['gender'] == '2'):?> selected="selected" <?php endif?> ><?php echo t('女')?></option>
			</select>
		  </div>
		  <div class="form_group col-lg-4">
			<label class="must"><?php echo t('密碼')?></label>
			<input type="password" name="login_password" placeholder="" value="<?php if(isset($member['login_password']) and $member['login_password'] != ''):?>*********<?php endif?>" />
		  </div>
		  <div class="form_group col-lg-4">
			<label class="must"><?php echo t('再次輸入密碼')?></label>
			<input type="password" name="login_password_confirm" placeholder="" value="<?php if(isset($member['login_password_confirm']) and $member['login_password_confirm'] != ''):?>*********<?php endif?>" />
		  </div>
		  <div class="form_group col-lg-4">
			<label class="must"><?php echo t('聯絡電話')?></label>
			<input type="tel" name="phone" value="<?php echo $member['phone']?>">
		  </div>
		  <div class="form_group col-lg-12">
			<label><?php echo t('生日')?></label>
			<div class="form_date">
			  <div class="row">
				<div class="col-lg-4">
					<select name="birthday_year">
						<option value="">年份</option>
						<?php for($i=1940;$i<=2023;$i++):?>
							<option value="<?php echo $i?>" <?php if(isset($_SESSION['save']['member_form_1']['birthday_year']) and $_SESSION['save']['member_form_1']['birthday_year'] == $i):?> selected="selected" <?php endif?> ><?php echo $i?></option>
						<?php endfor?>
					</select>
				</div>
				<div class="col-lg-4">
					<select name="birthday_month">
						<option value="">月份</option>
						<?php for($i=1;$i<=12;$i++):?>
							<option value="<?php echo $i?>" <?php if(isset($_SESSION['save']['member_form_1']['birthday_month']) and $_SESSION['save']['member_form_1']['birthday_month'] == $i):?> selected="selected" <?php endif?> ><?php echo $i?></option>
						<?php endfor?>
					</select>
				</div>
				<div class="col-lg-4">
					<select name="birthday_day">
						<option value="">日期</option>
						<?php for($i=1;$i<=31;$i++):?>
							<option value="<?php echo $i?>" <?php if(isset($_SESSION['save']['member_form_1']['birthday_day']) and $_SESSION['save']['member_form_1']['birthday_day'] == $i):?> selected="selected" <?php endif?> ><?php echo $i?></option>
						<?php endfor?>
					</select>
				</div>
			  </div>
			</div><!-- .form_date -->
		  </div>
		  <div class="form_group col-lg-12">
			<label><?php echo t('地址')?></label>
			<span class="twzipcode_form_1"></span>
			<input type="text" name="addr" value="<?php echo $member['addr']?>" placeholder="<?php echo t('地址')?>" autocomplete="off" />
		  </div>
		  <div class="form_group col-lg-12">
			<div class="checkBox_group">
			  <input type="checkbox" name="need_dm" id="need_dm" value="1" <?php if(isset($_SESSION['save']['member_form_1']['need_dm']) and $_SESSION['save']['member_form_1']['need_dm'] == '1'):?> checked="checked" <?php endif?> />
			  <label for="need_dm"><span class="signIcon"></span><?php echo t('願意收到產品相關訊息或活動資訊')?></label>
			</div>
			<div class="checkBox_group">
			  <input type="checkbox" name="accept_privacy" id="accept_privacy" value="1" <?php if(isset($_SESSION['save']['member_form_1']['accept_privacy']) and $_SESSION['save']['member_form_1']['accept_privacy'] == '1'):?> checked="checked" <?php endif?> <?php if(0):?> checked="checked" disabled="disabled" <?php endif?> />
			  <label for="accept_privacy"><span class="signIcon"></span>同意<a data-fancybox data-options='{"touch" : false}' data-src="#memberPrivacy_modal" href="javascript:;"><?php echo t('隱私權政策')?></a></label>
			</div>
			<div class="common_gy_txt">如有任何問題歡迎來電聯絡。若想知道會員詳請，請參考 <a data-fancybox data-options='{"touch" : false}' data-src="#memberTerm_modal" href="javascript:;">會員需知</a></div>
		  </div>
		</div>
	<?php endif//是否為會員的判斷?>
  </div><!-- .innerBlock -->

  <div class="innerBlock">
    <div class="blockTitle">
      <span><?php echo t('收件人資料')?></span>
    </div>
    <div class="row member_form_2">
      <div class="form_group col-lg-12">
        <label class=""><?php echo t('收件人')?></label>
        <div class="even_controlBox">
			<?php // 2020-05-28 Ming下午說，要從下拉改成Radio?>
			<div class="radio">
				<span class="radioBox_group">
				  <input type="radio" id="select_recipient_buyer" name="select_recipient" value="buyer" <?php if(isset($_SESSION['save']['member_form_2']['select_recipient']) and $_SESSION['save']['member_form_2']['select_recipient'] == 'buyer'):?> checked="checked" <?php endif?> >
				  <label for="select_recipient_buyer"><span class="signIcon"></span><?php echo t('同訂購人')?></label>
				</span>

				<span class="radioBox_group">
				  <input type="radio" id="select_recipient_custom" name="select_recipient" value="custom" <?php if(isset($_SESSION['save']['member_form_2']['select_recipient']) and $_SESSION['save']['member_form_2']['select_recipient'] == 'custom'):?> checked="checked" <?php endif?> >
				  <label for="select_recipient_custom"><span class="signIcon"></span><?php echo t('自訂')?></label>
				</span>

				<?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0 and isset($member_address) and !empty($member_address)):?>
					<?php foreach($member_address as $k => $v):?>
						<span class="radioBox_group">
						  <input type="radio" id="select_recipient_<?php echo $k?>" name="select_recipient" value="<?php echo 'addr_'.$v['id']?>" <?php if(isset($_SESSION['save']['member_form_2']['select_recipient']) and $_SESSION['save']['member_form_2']['select_recipient'] == 'addr_'.$v['id']):?> checked="checked" <?php endif?> >
						  <label for="select_recipient_<?php echo $k?>"><span class="signIcon"></span><?php echo $v['name']?></label>
						</span>
					<?php endforeach?>
				<?php endif?>
			</div>

        </div>
      </div>
      <div class="form_group col-lg-6">
		<label class="must"><?php echo t('收件人姓名')?></label>
		<input type="text" name="recipient_name" placeholder="" value="<?php echo $recipient['recipient_name']?>" autocomplete="off" />
      </div>
	  <div class="form_group col-lg-6">
	    <label><?php echo t('性別')?></label>
	    <select name="recipient_gender">
	      <option value="">選擇性別</option>
	      <option value="男" <?php if(isset($recipient['recipient_gender']) and $recipient['recipient_gender'] == '1'):?> selected="selected" <?php endif?> ><?php echo t('男')?></option>
	      <option value="女" <?php if(isset($recipient['recipient_gender']) and $recipient['recipient_gender'] == '2'):?> selected="selected" <?php endif?> ><?php echo t('女')?></option>
	    </select>
	  </div>
      <div class="form_group col-lg-6">
		<label class="must"><?php echo t('電話')?></label>
		<input type="tel" name="recipient_phone" value="<?php echo $recipient['recipient_phone']?>">
      </div>
      <div class="form_group col-lg-6">
		<label class=""><?php echo t('備用電話')?></label>
		<input type="tel" name="recipient_mobile" value="<?php echo $recipient['recipient_mobile']?>">
      </div>

		<?php if(isset($shipment['addr']) and $shipment['addr'] == 'addr'):?>
			<div class="form_group col-lg-12">
				<label class="must"><?php echo t('地址')?></label>

				<?/*有外島
				<span class="twzipcode"></span>
				*/?>

				<?/*無外島*/?>
				<span class="twzipcode_form_2 <?php if($shipment['has_islands'] === false):?> onlyLocal <?php endif?>"></span>

				<?/* <span class="tips">提示文字</span> */?>

				<input type="text" name="recipient_addr" placeholder="地址" value="<?php echo $recipient['recipient_addr']?>" autocomplete="off" />
			</div>
		<?php elseif(isset($shipment['addr']) and preg_match('/^ecpay_(711|fami)$/', $shipment['addr'])):?>
			<div class="formItem marketInfo">
				<label class="must"><?php echo t('超商取貨門市')?></label>
				<a href="action.php?func=<?php echo $shipment['func']?>" class="btn-cis1"><?php echo t('選擇取貨門市')?></a>

				<?php if(isset($_SESSION['save']['selecxt_physical']['params']) and !empty($_SESSION['save']['selecxt_physical']['params'])):?>
					<?php $params = $_SESSION['save']['selecxt_physical']['params']?>
					<table cellpadding="0" cellspacing="0" class="rwdTable" width="100%">
						<tr>
							<th><?php echo t('門市代號')?></th>
							<th><?php echo t('門市名稱')?></th>
							<th><?php echo t('門市地址')?></th>
						</tr>
						<tr>
							<td><label class="th"><?php echo t('門市代號')?></label><div><span class="marketID"></span><?php echo $params['CVSStoreID']?></div></td>
							<td><label class="th"><?php echo t('門市名稱')?></label><div><span class="marketName"><?php echo $params['CVSStoreName']?></span></div></td>
							<td><label class="th"><?php echo t('門市地址')?></label><div><span class="marketAddr"><?php echo $params['CVSAddress']?></span><div></td>
						</tr>
					</table>
				<?php endif?>
			</div>
		<?php endif?>


    </div>
  </div><!-- .innerBlock -->

  <div class="innerBlock">

    <!-- 樣式一 -->
    <div class="blockTitle">
      <span><?php if(isset($data['shop_show_electronic_invoice']) && $data['shop_show_electronic_invoice']==true):?><?php echo t('發票資訊')?>&amp;<?php endif?><?php echo t('備註')?></span>
    </div>
    <div class="row invoice_1">
		<?php if(isset($data['shop_show_electronic_invoice']) && $data['shop_show_electronic_invoice']==true):?>
		  <div class="form_group col-lg-12">
			<label class=""><?php echo t('發票資訊')?></label>
			<div class="even_controlBox">
				<?php if(0):?>
				  <span class="radioBox_group">
					<input type="radio" id="invoice1" name="invoice_type" value="1" <?php if(isset($invoice['invoice_type']) and $invoice['invoice_type'] == '1'):?> checked="checked" <?php endif?> >
					<label for="invoice1" class="invoiceType" data-target="#invoice1"><span class="signIcon"></span><?php echo t('二聯式電子發票')?></label>
				  </span>
				<?php endif?>
			  <span class="radioBox_group">
				<input type="radio" id="invoice2" name="invoice_type" value="2" <?php if(isset($invoice['invoice_type']) and $invoice['invoice_type'] == '2'):?> checked="checked" <?php endif?> >
				<label for="invoice2" class="invoiceType" data-target="#invoice2"><span class="signIcon"></span><?php echo t('捐贈發票')?></label>
			  </span>
			  <span class="radioBox_group">
				<input type="radio" id="invoice4" name="invoice_type" value="4" <?php if(isset($invoice['invoice_type']) and $invoice['invoice_type'] == '4'):?> checked="checked" <?php endif?> >
				<label for="invoice4" class="invoiceType" data-target="#invoice4"><span class="signIcon"></span><?php echo t('二聯式紙本發票隨商品寄出')?></label>
			  </span>
			  <span class="radioBox_group">
				<input type="radio" id="invoice3" name="invoice_type" value="3" <?php if(isset($invoice['invoice_type']) and $invoice['invoice_type'] == '3'):?> checked="checked" <?php endif?> >
				<label for="invoice3" class="invoiceType" data-target="#invoice4"><span class="signIcon"></span><?php echo t('三聯式紙本發票(公司行號報帳用)')?></label>
			  </span>
			</div>
		  </div>

			<div id="invoice1" class="invoiceInfo <?php if(isset($invoice['invoice_type']) and $invoice['invoice_type'] == '1'):?> active <?php endif?> ">
				<?php // 這裡要補二聯電子發票的內容?>
			</div>

			<div id="invoice2" class="invoiceInfo <?php if(isset($invoice['invoice_type']) and $invoice['invoice_type'] == '2'):?> active <?php endif?> ">
				<?php // 這裡要補捐贈的內容?>
			</div>

			<div id="invoice4" class="invoiceInfo <?php if(isset($invoice['invoice_type']) and $invoice['invoice_type'] == '4'):?> active <?php endif?> ">
				<?php // 這裡本來就沒內容?>
			</div>

			<div id="invoice3" class="invoiceInfo <?php if(isset($invoice['invoice_type']) and $invoice['invoice_type'] == '3'):?> active <?php endif?> ">
			  <div class="form_group col-lg-6">
				<label><?php echo t('統一編號')?></label>
				<input type="text" name="invoice_tax_id" placeholder="" value="<?php echo $invoice['invoice_tax_id']?>" autocomplete="off" />
			  </div>
			  <div class="form_group col-lg-6">
				<label><?php echo t('公司抬頭')?></label>
				<input type="text" name="invoice_name" placeholder="" value="<?php echo $invoice['invoice_name']?>" autocomplete="off" />
			  </div>
			</div>

		  <div class="form_group col-lg-12">
			<div class="common_bk_txt">※ 依統一發票使用辦法規定：個人戶（二聯式）發票一經開立，不得任意更改為公司戶（三聯式）發票。</div>
		  </div>
		<?php endif?>

      <div class="form_group col-lg-12">
		<label><?php echo t('備註事項')?></label>
		<textarea rows="5" cols="80" name="detail"><?php echo $invoice['detail']?></textarea>
      </div>
    

	<?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
	<?php else:?>
		<?//第一次購物顯示驗證碼?>
		<div class="form_group col-lg-12">
			<label class="must" t="* tw ucfirst">認證碼</label>
			<div class="authenticateCode">
				<input type="text" id="captcha" name="captcha" />
				<img id="valImageId" src="captcha.php" width="100" gheight="40" />
				<a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
			</div><!-- .authenticateCode -->
		</div>
	<?php endif?>

	</div>

    <div class="even_btn">
		<a class="btn-white2" href="checkout_<?php echo $this->data['ml_key']?>.php?step=1"><i class="fa fa-reply"></i><?php echo t('上一步')?></a>
		<?php if(isset($shipment['func']) and preg_match('/(cash_on_delivery)$/', $shipment['func'])):?>
				<a class="btn-cis1 step2" href="javascript:;"><i class="fa fa-check"></i><?php echo t('完成訂購')?></a>
		<?php elseif(isset($payment['func']) and $payment['func'] == 'atm'):?>
				<a class="btn-cis1 step2" href="javascript:;"><i class="fa fa-check"></i><?php echo t('完成訂購')?></a>
		<?php elseif(isset($payment['func']) and $payment['func'] != ''):?>
				<a class="btn-cis1 step2" href="javascript:;"><i class="fa fa-check"></i><?php echo t('下一步')?></a>
		<?php endif?>
    </div><!-- .even_btn -->

  </div><!-- .innerBlock -->

</form>

<?php if(0):?><!-- body_end -->
<script src="js_common/reload.js"></script>
<script type="text/javascript">
$('body').on('click','.payments input[name=func]',function(){
	$.ajax({
		type: "POST",
		data: {
			'id': 'selecxt_payment',
			'func': $('.payments input[name=func]:checked').val()
		},
		url: 'save.php',
		success: function(response){
			location.reload();
		}
	}); // ajax
});
$('body').on('click','.physicals input[name=func]',function(){
	$.ajax({
		type: "POST",
		data: {
			'id': 'selecxt_physical',
			'func': $('.physicals input[name=func]:checked').val()
		},
		url: 'save.php',
		success: function(response){
			location.reload();
		}
	}); // ajax
});
$('body').on('click','.physicals input[name=is_islands]',function(){
	var is_islands = '';
	if($('.physicals input[name=is_islands]').is(':checked')){
		is_islands = $('.physicals input[name=is_islands]:checked').val();
	}
	$.ajax({
		type: "POST",
		data: {
			'id': 'selecxt_physical',
			'is_islands': is_islands
		},
		url: 'save.php',
		success: function(response){
			location.reload();
		}
	}); // ajax
});
$('body').on('change','.member_form_1 select[name=birthday_year], .member_form_1 select[name=birthday_month], .member_form_1 select[name=birthday_day]',function(){
	var thisobj = $(this);
	var field1 = thisobj.attr('name');
	var field2 = thisobj.val();
	var json = {};
	json['id'] = 'member_form_1';
	//json['primary_key'] = thisobj.val();
	json[field1] = field2;
	$.ajax({
		type: "POST",
		data: json,
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
$('body').on('change','.member_form_1 input[type=text],.member_form_1 select[name=gender], .member_form_1 input[type=password], .member_form_1 input[type=radio], .member_form_1 input[type=date], .member_form_1 input[type=tel]',function(){//20220818 lin add .member_form_1 select[name=gender],
	var thisobj = $(this);
	var field1 = thisobj.attr('name');
	var field2 = thisobj.val();
	var json = {};
	json['id'] = 'member_form_1';
	//json['primary_key'] = thisobj.val();
	json[field1] = field2;
	$.ajax({
		type: "POST",
		data: json,
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
$('body').on('click','.member_form_1 input[name=need_dm]',function(){
	var need_dm = '';
	if($('.member_form_1 input[name=need_dm]').is(':checked')){
		need_dm = $('.member_form_1 input[name=need_dm]:checked').val();
	}
	$.ajax({
		type: "POST",
		data: {
			'id': 'member_form_1',
			'need_dm': need_dm
		},
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
$('body').on('click','.member_form_1 input[name=accept_privacy]',function(){
	var accept_privacy = '';
	if($('.member_form_1 input[name=accept_privacy]').is(':checked')){
		accept_privacy = $('.member_form_1 input[name=accept_privacy]:checked').val();
	}
	$.ajax({
		type: "POST",
		data: {
			'id': 'member_form_1',
			'accept_privacy': accept_privacy
		},
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
$('body').on('keydown','.member_form_1 input[name=phone]',function(e){

    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
$(function(){
	if($('.twzipcode_form_1').length){
		if(typeof ml_key == 'undefined' || ml_key == 'tw'){
			//$('.twzipcode_form_1').twzipcode();
			$('.twzipcode_form_1').twzipcode({
				countyName: 'addr_county',
				districtName: 'addr_district',
				zipcodeName: 'addr_zipcode',
				onCountySelect: function(){
					var thisobj = $(this);
					var field1 = 'addr_county';
					var field2 = $(this).val();
					var json = {};
					json['id'] = 'member_form_1';
					//json['primary_key'] = thisobj.val();
					json[field1] = field2;
					$.ajax({
						type: "POST",
						data: json,
						url: 'save.php',
						success: function(response){
							var field4 = $(".twzipcode_form_1 input[name='addr_zipcode']").val();
							var json1 = {};
							json1['id'] = 'member_form_1';
							//json['primary_key'] = thisobj.val();
							json1['addr_zipcode'] = field4;
							$.ajax({
								type: "POST",
								data: json1,
								url: 'save.php',
								success: function(response){
									//location.reload();
								}
							});
							//location.reload();
						}
					}); // ajax
				},
				onDistrictSelect: function(){
					var thisobj = $(this);
					var field1 = 'addr_district';
					var field2 = $(this).val();
					var json = {};
					json['id'] = 'member_form_1';
					//json['primary_key'] = thisobj.val();
					json[field1] = field2;
					$.ajax({
						type: "POST",
						data: json,
						url: 'save.php',
						success: function(response){
							var field4 = $(".twzipcode_form_1 input[name='addr_zipcode']").val();
							var json1 = {};
							json1['id'] = 'member_form_1';
							//json['primary_key'] = thisobj.val();
							json1['addr_zipcode'] = field4;
							$.ajax({
								type: "POST",
								data: json1,
								url: 'save.php',
								success: function(response){
									//location.reload();
								}
							});
							//location.reload();
						}
					}); // ajax
				},
				onZipcodeKeyUp: function(){
					var thisobj = $(this);
					var field1 = 'addr_zipcode';
					var field2 = $(this).val();
					var json = {};
					json['id'] = 'member_form_1';
					//json['primary_key'] = thisobj.val();
					json[field1] = field2;
					$.ajax({
						type: "POST",
						data: json,
						url: 'save.php',
						success: function(response){
							//location.reload();
						}
					}); // ajax
				}

	<?php
		if(isset($_SESSION['save']['member_form_1']['addr_county']) and $_SESSION['save']['member_form_1']['addr_county'] != ''){
			echo ',countySel: \''.$_SESSION['save']['member_form_1']['addr_county'].'\',districtSel: \''.$_SESSION['save']['member_form_1']['addr_district'].'\'';
		}
	?>

			});
		}
	} // twzipcode_form_1 length
});
//$('body').on('change','.member_form_2 select[name=select_recipient]',function(){
$('body').on('change','.member_form_2 input[name=select_recipient]',function(){
	var thisobj = $(this);
	var field1 = thisobj.attr('name');
	var field2 = thisobj.val();
	var json = {};
	if(field2 == 'custom'){
		json['id'] = 'member_form_2_clear'; //2017/07/03 這邊加入自訂選項的動作 by lota
	}else{
		json['id'] = 'member_form_2';
	}	
	//json['primary_key'] = thisobj.val();
	json[field1] = field2;
	$.ajax({
		type: "POST",
		data: json,
		url: 'save.php',
		success: function(response){
			// 這個才需要重整
			location.reload();
		}
	}); // ajax
});
$('body').on('change','.member_form_2 input[type=text], .member_form_2 select[name=recipient_gender], .member_form_2 input[type=tel]',function(){
	var thisobj = $(this);
	var field1 = thisobj.attr('name');
	var field2 = thisobj.val();
	var json = {};
	json['id'] = 'member_form_2';
	//json['primary_key'] = thisobj.val();
	json[field1] = field2;
	$.ajax({
		type: "POST",
		data: json,
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
$('body').on('click','.member_form_2 input[name=recipient_address_add]',function(){
	var recipient_address_add = '';
	if($('.member_form_2 input[name=recipient_address_add]').is(':checked')){
		recipient_address_add = $('.member_form_2 input[name=recipient_address_add]:checked').val();
	}
	$.ajax({
		type: "POST",
		data: {
			'id': 'member_form_2',
			'recipient_address_add': recipient_address_add
		},
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
$('body').on('keydown','.member_form_2 input[name=recipient_phone], .member_form_2 input[name=recipient_mobile]',function(e){
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
$(function(){
if($('.twzipcode_form_2').length){
	if(typeof ml_key == 'undefined' || ml_key == 'tw'){
		//$('.twzipcode_form_1').twzipcode();
		$('.twzipcode_form_2').twzipcode({
			countyName: 'recipient_addr_county',
			districtName: 'recipient_addr_district',
			zipcodeName: 'recipient_addr_zipcode',
			onCountySelect: function(){
				var thisobj = $(this);
				var field1 = 'recipient_addr_county';
				var field2 = $(this).val();
				var json = {};
				json['id'] = 'member_form_2';
				//json['primary_key'] = thisobj.val();
				json[field1] = field2;
				$.ajax({
					type: "POST",
					data: json,
					url: 'save.php',
					success: function(response){
						//location.reload();
					}
				}); // ajax
			},
			onDistrictSelect: function(){
				var thisobj = $(this);
				var field1 = 'recipient_addr_district';
				var field2 = $(this).val();
				var json = {};
				json['id'] = 'member_form_2';
				//json['primary_key'] = thisobj.val();
				json[field1] = field2;
				$.ajax({
					type: "POST",
					data: json,
					url: 'save.php',
					success: function(response){
						//location.reload();
					}
				}); // ajax
			}

<?php
	if(isset($_SESSION['save']['member_form_2']['recipient_addr_county']) and $_SESSION['save']['member_form_2']['recipient_addr_county'] != ''){
		echo ',countySel: \''.$_SESSION['save']['member_form_2']['recipient_addr_county'].'\',districtSel: \''.$_SESSION['save']['member_form_2']['recipient_addr_district'].'\'';
	}
?>

		});
	}
} // twzipcode_form_2 length
});
$('body').on('click','.invoiceType',function(){
	var activeTarget=$(this).data('target');
    $(".invoiceInfo.active").removeClass("active");
    $(activeTarget).addClass("active");
    jQuery("html,body").animate({
        scrollTop: $(this).offset().top-$(this).height()*2
    }, 300);
});
$(".mobileInvoice input[type='radio']").on('load change click',function(){
	var placeholderTxt=$(this).next().text();
	$(".mobileInvoice .invoiceCode").attr("placeholder","<?php echo t('請輸入')?>"+placeholderTxt);
});
$('body').on('click','.step2',function(){
	$.ajax({
		type: "GET",
		data: {
			'ajax': 2
		},
		url: 'checkout_<?php echo $this->data['ml_key']?>.php',
		success: function(response){
			eval(response);
			//location.reload();
		}
	}); // ajax
});
$('body').on('click','.step3',function(){
	$.ajax({
		type: "POST",
		data: {
			'id': 'step3',
			'go_to_finish!!': 1
		},
		url: 'save.php',
		success: function(response){
			//location.href='checkout.php?ajax=2';
			location.href='checkout_<?php echo $this->data['ml_key']?>.php?step=3';
		}
	}); // ajax
});
$('body').on('change','.invoice_1 input[type=radio], .invoice_1 input[name=invoice_type_2_barcode], .invoice_1 input[name=invoice_tax_id], .invoice_1 input[name=invoice_name], .invoice_1 input[name=captcha], .invoice_1 textarea',function(){
	var thisobj = $(this);
	var field1 = thisobj.attr('name');
	var field2 = thisobj.val();
	var json = {};
	json['id'] = 'invoice_1';
	//json['primary_key'] = thisobj.val();
	json[field1] = field2;
	$.ajax({
		type: "POST",
		data: json,
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->

<?php endif?><?php // step2?>

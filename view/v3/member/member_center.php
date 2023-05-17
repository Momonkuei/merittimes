<!-- // DATA2:SINGLE -->
<?php $member = $data[$ID];?>
<!-- // DATA2:SINGLE -->
<?php $bonus_info = $data[$ID];?>

<!-- // DATA2:MULTI -->
<?php $order = $data[$ID];//訂單記錄(最近三筆)?>
<!-- // DATA2:MULTI -->
<?php $bonus = $data[$ID];//紅利(最近三筆)?>
<!-- // DATA2:MULTI -->
<?php $gift = $data[$ID];//優惠卷(不限制)?>
<!-- // DATA2:MULTI -->
<?php $member_address = $data[$ID];//地址簿(三筆)?>

<?php
//會員登入型態
unset($_constant);
eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');
?>

<div class="memberBlockCenter">

	<div class="blockTitle"><?php echo t('MEMBER CENTER','en')?></div>
	<p class="blockInfoTxt"><?php // XXX?></p>
	<a href="memberlogout_<?php echo $this->data['ml_key']?>.php" class="btn-cis1"><i class="fa fa-sign-out"></i><?php echo t('會員登出')?></a>

	<div class="">

	<div class="hrTitle"><span><?php echo t('基本資料')?></span></div>
		<section class="memberData">			
			<form target="hideframe" action="" method="post" name="memberForm" id="form_data" class="formStyle" <?php // enctype="multipart/form-data" ?> > <input type="hidden" name="gtoken" class="gtoken" />

				<?php // https://stackoverflow.com/questions/7083325/firefox-form-targeting-an-iframe-is-opening-new-tab?noredirect=1&lq=1?>
				<iframe id="hideframe" name="hideframe" style="display:none" src=""></iframe>
				<input id="force_save" type="hidden" name="123" />
				<input type="hidden" name="func" value="profile" />

				<input type="hidden" name="func" value="profile" />

				<div class="Bbox_in_2c">						
					<div>
						<div class="formItem">
							<label><?php echo t('帳號')?></label>
							<span><input type="email" disabled value="<?php echo $member['login_account']?>"></span>
						</div>					
						<div class="formItem">
							<label><?php echo t('密碼')?></label>
							<span>****** <a href="memberchangepassword_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-pencil"></i><?php echo t('修改密碼')?></a></span>
						</div>						
						<div class="formItem edit">
							<label><?php echo t('姓名')?></label>
							<span><input type="text" id="ggg" disabled="disabled" name="name" value="<?php echo $member['name']?>"></span>
						</div>				
						<?php if($_constant=='email'):?>		
						<div class="formItem edit">
							<label><?php echo t('聯絡電話')?></label>
							<span><input type="tel" disabled="disabled" name="phone" value="<?php echo $member['phone']?>" inputmode="tel"></span>
						</div>			
						<?php elseif($_constant=='phone'):?>
						<div class="formItem edit">
							<label><?php echo t('E-mail')?></label>
							<span><input type="email" disabled="disabled" name="email" value="<?php echo $member['email']?>" inputmode="email"></span>
						</div>
						<?php elseif($_constant=='account'):?>
						<div class="formItem edit">
							<label><?php echo t('聯絡電話')?></label>
							<span><input type="tel" disabled="disabled" name="phone" value="<?php echo $member['phone']?>" inputmode="tel"></span>
						</div>
						<?php endif?>
						<div class="formItem edit">
							<label><?php echo t('性別')?></label>
							<div class="radio">
								<label> <input type="radio" disabled="disabled" name="gender" id="" value="1" <?php if(isset($member['gender']) and $member['gender'] == '1'):?> checked="checked" <?php endif?> > <span><?php echo t('男')?></span> </label>
								<label> <input type="radio" disabled="disabled" name="gender" id="" value="2"  <?php if(isset($member['gender']) and $member['gender'] == '2'):?> checked="checked" <?php endif?> > <span><?php echo t('女')?></span> </label>
							</div>
						</div>
						<div class="formItem edit">
							<label><?php echo t('生日')?></label>
							<span><input type="date" disabled="disabled" name="birthday" value="<?php echo $member['birthday']?>"></span>
						</div>

						<?php // 2020-12-31?>
						<?php if(0):?>
							<div class="formItem edit">
								<label><?php echo t('會員預留欄位1(會連動訂購人)')?></label>
								<span><input type="text" disabled="disabled" name="other1" value="<?php echo $member['other1']?>"></span>
							</div>						
							<div class="formItem edit">
								<label><?php echo t('會員預留欄位2(會連動訂購人)')?></label>
								<span><input type="text" disabled="disabled" name="other2" value="<?php echo $member['other2']?>"></span>
							</div>						
							<div class="formItem edit">
								<label><?php echo t('會員預留欄位3(會連動訂購人)')?></label>
								<span><input type="text" disabled="disabled" name="other3" value="<?php echo $member['other3']?>"></span>
							</div>						
						<?php endif?>
					</div>
				</div>	

				<div class="formItem agreementBlock edit">					
					<div class="checkbox">						
						<label><input type="checkbox" disabled="disabled" <?php if(isset($member['need_dm']) and $member['need_dm'] == '1'):?> checked <?php endif?> name="need_dm" value="1" />  <span><?php echo t('願意收到產品相關訊息或活動資訊')?></span> </label>
					</div>					
				</div>	
				<div class="">
					<a href="#_" class="btn-cis1" id="memberDataEdit" data-status='edit'><i class="fa fa-pencil"></i><?php echo t('修改資料')?></a>	
					<?php if($_constant=='phone' && isset($member['is_sms']) && $member['is_sms']==0):?>
					<a href="memberverification_<?php echo $this->data['ml_key']?>.php?resend=1" class="btn-cis1" id="memberverification" data-status='edit'><i class="fa fa-pencil"></i><?php echo t('重新驗證手機')?></a>	
				<?php endif?>					
				</div>					
			</form>

		</section>

		<?php if(isset($order) and !empty($order)):?>
			<div class="hrTitle"><span><?php echo t('訂單記錄')?> (<?php echo t('最近三筆')?>)</span></div>
			<section class="memberOrderList block">
				<table class="rwdTable" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<th><?php echo t('訂單編號')?></th>
						<th><?php echo t('消費時間')?></th>
						<th><?php echo t('訂單金額')?></th>
						<th><?php echo t('付款方式')?></th>
						<th><?php echo t('訂單狀態')?></th>
						<th><?php echo t('查看明細')?></th>
					</tr>
					<?php foreach($order as $k => $v):?>
						<tr>
							<td><label class="th"><?php echo t('訂單編號')?></label><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><?php echo $v['order_number']?></a></td>
							<td><label class="th"><?php echo t('消費時間')?></label><small><?php echo $v['create_time']?></small></td>
							<td><label class="th"><?php echo t('訂單金額')?></label><span><?php echo $v['total']?></span></td>
							<td><label class="th"><?php echo t('付款方式')?></label><span><?php if(isset($v['payment_func_name'])){ echo $v['payment_func_name'];}?></span></td>
<!-- func|start|remove_new_line -->
							<td><label class="th"><?php echo t('訂單狀態')?></label>
								<?php $no_action = false//只是為了減少程式碼的層次?>
								<?php if($v['order_status'] == 99)://己取消?>
									<span class="orderStatus del"><?php echo $v['order_status_handle']?></span>
								<?php elseif($v['order_status'] == 0)://未付款?>
									<?php foreach ($payments_tmp as $k1 => $v1):?>
										<?php if($v1['func'] == $v['payment_func']):?>
											<?php if($v1['payment_notice']):?>
												<a href="membernoticepayment_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>" class=""><span class="orderStatus noticPay"><?php echo t('通知付款')?></span></a>
											<?php else:?>
												<?php $no_action = true?>
											<?php endif?>
										<?php endif?>
									<?php endforeach?>
								<?php elseif($v['order_status_handle'] == '己出貨')://這個是隱藏的?>
									<span class="orderStatus ship"><?php echo $v['order_status_handle']?></span>
								<?php else:?>
									<?php $no_action = true?>
								<?php endif?>
								<?php if($no_action === true):?>
									<?php echo $v['order_status_handle']?>
								<?php endif?>
							</td>
<!-- func|end|remove_new_line -->
							<td><label class="th"></label><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><i class="fa fa-th-list" aria-hidden="true"></i><?php echo t('查看明細')?></a></td>
						</tr>
					<?php endforeach?>

					<?php if(0):?>
						<tr>
							<td><label class="th">訂單編號</label><a href="member.php?type=orderdetail">151021010062</a></td>
							<td><label class="th">消費時間</label><small>2015-10-21 16:31:58</small></td>
							<td><label class="th">訂單金額</label><span>$300</span></td>
							<td><label class="th">付款方式</label><span>銀行匯款/ATM轉帳</span></td>
							<td><label class="th">訂單狀態</label><span class="orderStatus del">已取消</span></td>
							<td><label class="th"></label><a href="member.php?type=orderdetail"><i class="fa fa-th-list" aria-hidden="true"></i>查看明細</a></td>
						</tr>
						<tr>
							<td><label class="th">訂單編號</label><a href="member.php?type=orderdetail">151021010062</a></td>
							<td><label class="th">消費時間</label><small>2015-10-21 16:31:58</small></td>
							<td><label class="th">訂單金額</label><span>$300</span></td>
							<td><label class="th">付款方式</label><span>銀行匯款/ATM轉帳</span></td>
							<td><label class="th">訂單狀態</label><a href="member.php?type=noticepay" class=""><span class="orderStatus noticPay">通知付款</span></a></td>
							<td><label class="th"></label><a href="member.php?type=orderdetail"><i class="fa fa-th-list" aria-hidden="true"></i>查看明細</a></td>
						</tr>
						<tr>
							<td><label class="th">訂單編號</label><a href="member.php?type=orderdetail">151021010062</a></td>
							<td><label class="th">消費時間</label><small>2015-10-21 16:31:58</small></td>
							<td><label class="th">訂單金額</label><span>$300</span></td>
							<td><label class="th">付款方式</label><span>銀行匯款/ATM轉帳</span></td>
							<td><label class="th">訂單狀態</label><span class="orderStatus ship">出貨中</span></td>
							<td><label class="th"></label><a href="member.php?type=orderdetail"><i class="fa fa-th-list" aria-hidden="true"></i>查看明細</a></td>
						</tr>
					<?php endif?>
				</table>
				<a href="memberorderlist_<?php echo $this->data['ml_key']?>.php" class="btn-cis1"><i class="fa fa-history" aria-hidden="true"></i><?php echo t('看更多')?></a>
			</section>
		<?php endif?>

		<?php if(isset($bonus) and !empty($bonus)):?>
			<div class="hrTitle"><span><?php echo t('可使用的紅利')?>/<?php echo t('優惠券')?></span></div>
			<section class="bonusBlock block">
				<div class="blockInfo">
					<label class="bonusTotal"><?php echo t('總共累積紅利')?>：<span><?php echo $bonus_info['total']?></span></label>
					<label class="bonusUsed"><?php echo t('已使用紅利')?>：<span><?php echo $bonus_info['use']?></span></label>
				</div>
				<table class="rwdTable" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<th><?php echo t('紅利點數')?></th>
						<th><?php echo t('紅利說明')?></th>
						<th><?php echo t('開始日期')?></th>
						<th><?php echo t('到期日')?></th>
					</tr>
					<?php foreach($bonus as $k => $v):?>
						<tr>
							<?php if($v['order_number'] != ''):?>
								<td><label class="th"><?php echo t('紅利點數')?></label><span>-<?php echo $v['point']?></span></td>
								<td><label class="th"><?php echo t('紅利說明')?></label><span><?php echo t('消費折抵')?><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><?php echo $v['order_number']?></a></span></td>
								<td><label class="th"><?php echo t('開始日期')?></label><small>&nbsp;</small></td>
								<td><label class="th"><?php echo t('到期日')?></label><small>&nbsp;</small></td>
							<?php else:?>
								<td><label class="th"><?php echo t('紅利點數')?></label><span>+<?php echo $v['point']?></span></td>
								<td><label class="th"><?php echo t('紅利說明')?></label><span><?php echo $v['name']?></span></td>
								<td><label class="th"><?php echo t('開始日期')?></label><small><?php echo $v['start_date_name']?></small></td>
								<td><label class="th"><?php echo t('到期日')?></label><small><?php echo $v['start_date_name']?></small></td>
							<?php endif?>
						</tr>
					<?php endforeach?>

					<?php if(0):?> 
						<tr>
							<td><label class="th">紅利點數</label><span>+500</span></td>
							<td><label class="th">紅利說明</label><span>註冊會員</span></td>
							<td><label class="th">開始日期</label><small>2015-10-21</small></td>
							<td><label class="th">到期日</label><small>2015-10-21</small></td>
						</tr>
						<tr>
							<td><label class="th">紅利點數</label><span>-100</span></td>
							<td><label class="th">紅利說明</label><span>消費折抵<a href="member.php?type=orderdetail">123456789</a></span></td>
							<td><label class="th">開始日期</label><small>2015-10-21</small></td>
							<td><label class="th">到期日</label><small>2015-10-21</small></td>
						</tr>
						<tr>
							<td><label class="th">紅利點數</label><span>+500</span></td>
							<td><label class="th">紅利說明</label><span>登入紅利</span></td>
							<td><label class="th">開始日期</label><small>2015-10-21</small></td>
							<td><label class="th">到期日</label><small>2015-10-21</small></td>
						</tr>
					<?php endif?>
				</table>
				<a href="memberbonuslist_<?php echo $this->data['ml_key']?>.php" class="btn-cis1"><i class="fa fa-history" aria-hidden="true"></i><?php echo t('看更多')?></a>
			</section>
		<?php endif?>

		<?php if(isset($gift) and !empty($gift)):?>
			<section class="couponBlock block">
				<table class="rwdTable" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<th><?php echo t('優惠券名稱')?></th>
						<th><?php echo t('說明')?></th>
						<th><?php echo t('優惠券序號')?></th>
						<th><?php echo t('開始日期')?></th>
						<th><?php echo t('截止日期')?></th>
					</tr>
					<?php foreach($gift as $k => $v):?>
						<tr>
							<td><label class="th"><?php echo t('優惠券名稱')?></label><span><?php echo $v['name']?></span></td>
							<td>
								<label class="th"><?php echo t('說明')?></label>
								<span>
									<?php if($v['gift_condition1'] == '1'):?>
										滿<?php echo $v['gift_condition2']?>
									<?php endif?>

									<?php if($v['gift_do_type'] == '1'):?>
										折扣<?php eval('$aaa=0.'.$v['gift_do_value'].';$aaa=100-($aaa*100);echo $aaa;');?>%
									<?php elseif($v['gift_do_type'] == '2'):?>
										折抵<?php echo $v['gift_do_value']?>元
									<?php endif?>
								</span>
							</td>
							<td><label class="th"><?php echo t('優惠券序號')?></label><small><?php echo $v['gift_serial_number']?></small></td>
							<td><label class="th"><?php echo t('開始日期')?></label><small><?php echo $v['start_date']?></small></td>
							<td><label class="th"><?php echo t('截止日期')?></label><small><?php echo $v['end_date']?></small></td>
						</tr>
					<?php endforeach?>
				</table>
			</section>
		<?php endif?>
		
		<?php if(isset($member_address) and !empty($member_address)):?>
			<div class="hrTitle"><span><?php echo t('收件地址簿')?></span></div>

			<section class="memberAddressBook block">			
				<table class="rwdTable" width="100%" cellspacing="0" cellpadding="0">				
					<tr>
						<th><?php echo t('收件人')?></th>
						<th><?php echo t('性別')?></th>
						<th><?php echo t('郵遞區號')?></th>
						<th><?php echo t('縣市')?></th>
						<th><?php echo t('地區')?></th>
						<th><?php echo t('地址')?></th>
						<th><?php echo t('修改')?></th>
						<th><?php echo t('刪除')?></th>
					</tr>				
					<?php foreach($member_address as $k => $v):?>
						<tr id="addrBook_<?php echo $k?>">
							<td><label class="th"><?php echo t('收件人')?></label><div><?php echo $v['name']?></div></td>
							<td><label class="th"><?php echo t('性別')?></label><div><?php if($v['gender'] == '1'):?><?php echo t('先生')?><?php else:?><?php echo t('小姐')?><?php endif?></div></td>
							<td><label class="th"><?php echo t('郵遞區號')?></label><div><?php echo $v['addr_zipcode']?></div></td>
							<td><label class="th"><?php echo t('縣市')?></label><div><?php echo $v['addr_county']?></div></td>
							<td><label class="th"><?php echo t('地區')?></label><div><?php echo $v['addr_district']?></div></td>
							<td><label class="th"><?php echo t('地址')?></label><div><?php echo $v['addr']?></div></td>
							<td><label class="th"><?php echo t('修改')?></label><div><a href="membercustomeraddress_<?php echo $this->data['ml_key']?>.php?id=<?php echo $v['id']?>"><i class="fa fa-pencil"></i><?php echo t('修改')?></a></div></td>
							<td><label class="th"><?php echo t('刪除')?></label><div><a href="membercustomeraddress_<?php echo $this->data['ml_key']?>.php?del=<?php echo $v['id']?>" onclick="return confirm('<?php echo t('你確定要刪掉這筆資料？')?>')" class="delAddr" data-target="<?php echo $k?>"><i class="fa fa-trash"></i><?php echo t('刪除')?></a></div></td>
						</tr>				
					<?php endforeach?>
				</table>

				<a href="membercustomeraddress_<?php echo $this->data['ml_key']?>.php?id=0" class="btn-cis1 addAddr"><i class="fa fa-plus" aria-hidden="true"></i><?php echo t('新增')?></a>

			</section>
		<?php endif?>
		
	</div>
</div>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
	$('body').on('click','#memberDataEdit',function(){	
		if($(this).attr('data-status') == 'edit'){
			$('.memberData .edit input[disabled="disabled"]').removeAttr('disabled'); 
			$(this).html('<i class="fa fa-check"></i><?php echo t('完成修改')?>').attr('data-status','submit');
			return false;
		}else if($(this).attr('data-status') == 'submit'){
			// do something...?
			// after save, disabled input							
			$('.memberData .edit input').attr("disabled","disabled"); 
			$(this).html('<i class="fa fa-pencil"></i><?php echo t('修改資料')?>').attr('data-status','edit');

			var need_dm = 0;
			if($('.memberData input[name=need_dm]').is(":checked")){
				need_dm = 1;
			}

			$.ajax({
				type: "POST",
				data: {
					'name': $('.memberData input[name=name]').val(),
					'gender': $('.memberData input[name=gender]:checked').val(),
					'need_dm': need_dm,
					'birthday': $('.memberData input[name=birthday]').val(),
					'phone': $('.memberData input[name=phone]').val(),
					'other1': $('.memberData input[name=other1]').val(),
					'other2': $('.memberData input[name=other2]').val(),
					'other3': $('.memberData input[name=other3]').val(),
					'func': 'profile'
				},
				dataType: 'script',
				url: 'membercenter_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					//alert(response);
					eval(response);
				}
			}); // ajax

			return false;
		}
	});
</script>

<script type="text/javascript">
	//set if >=3 add hide		
	setAddrBtn();
	function setAddrBtn(){
		var nowCount=($(".memberAddressBook tr").length-1);
		if(nowCount>=3){$(".addAddr").hide();}
		else{$(".addAddr").show();}
	}

	// delete addr
	// $(".delAddr").click(function(){
	// 	var target=$(this).attr('data-target');					
	// 	$('#addrBook_'+target).remove();
	// 	setAddrBtn();
	// 	return false;
	// });				
</script>
<?php endif?><!-- body_end -->

<?php echo $AA?>

<?php if(0):?><!-- body_end -->
<script src="js_common/reload.js"></script>
<?php endif?><!-- body_end -->

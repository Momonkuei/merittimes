<?php if(isset($this->data['layoutv2_sections_select'])):?>
	<?php if($this->data['layoutv2_sections_select'] == '1'):?>

		<?php if($this->data['router_class'] == 'shoppingcar' and isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''):?>
			<?php $row = $this->db->createCommand()->from('customer')->where('is_enable=1 and id=:id',array(':id'=>$_SESSION['authw_admin_id']))->queryRow()?>
			<div class="form-group">
				<label class="col-xs-3 control-label">登入帳號 (E-Mail)：</label>
				<div class="col-xs-9">
					<p class="form-control-static"><?php echo $row['login_account']?></p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-3 control-label">姓名</label>
				<div class="col-xs-9">
					<p class="form-control-static">
						<?php echo $row['name']?> <?php if($row['sex'] == '1'):?>先生<?php else:?>小姐<?php endif?>
					</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-3 control-label">聯絡電話</label>
				<div class="col-xs-9">
					<p class="form-control-static">
						<?php echo $row['phone']?>
					</p>
				</div>
			</div>
			<div class="form-group ">
				<label class="col-xs-3 control-label">地址</label>

				<div class="col-xs-9">
					<p class="form-control-static">
						<?php echo $row['addr_zipcode']?>
						<?php echo $row['addr_county']?>
						<?php echo $row['addr_district']?>
						<?php echo $row['addr']?>
					</p>
				</div>

			</div>
		<?php else:?><?php // shoppingcar authw?>

		<?php $key = $this->data['section']['key'] // 為了整齊?>

		<?php if($this->data['router_class'] == 'shoppingcar'):?>
			<?php $key = 'buyer'?>
		<?php endif?>

		<?php if(0):?><?php // 不用載入，因為上方的登入Bar己經有載入?>
		<?php if(!isset($this->data['BODY_START'])):?><?php $this->data['BODY_START']=''?><?php endif?>
		<?php $this->data['BODY_START'] .= <<<XXX
<script type="text/javascript">
var msgErrorTip2 = '請輸入「%s」';
var msgErrorTip1 = '請輸入要搜尋的關鍵字。';
var msgProcess = '處理中...';
</script><script src="Scripts/confirm_form.js"></script>
XXX;
?>
		<?php endif?>

		<?php if(!isset($this->data['HEAD_START'])):?><?php $this->data['HEAD_START']=''?><?php endif?>
		<?php $this->data['HEAD_START'] .= <<<XXX
 <link rel="stylesheet" href="common/jquery-ui/jquery-ui.min.css" />
XXX;
?>

		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script src="common/twzipcode/jquery.twzipcode.min.js"></script>
<script src="common/jquery-ui/jquery-ui.min.js"></script>
<script src="common/jquery-ui/datepicker-zh-TW.js"></script>
<script src="js/reload.js"></script>
<script>
$( document ).ready(function() {
	$("#birthday").datepicker( $.datepicker.regional["zh-TW"] );  
	$('#twzipcode').twzipcode({
		countyName: 'addr_county',
		districtName: 'addr_district',
		zipcodeName: 'addr_zipcode',
XXX;

			if(isset($this->data['layoutv2'][$key]['addr_county']) and $this->data['layoutv2'][$key]['addr_county'] != ''){
				$this->data['BODY_END'] .= 'countySel: \''.$this->data['layoutv2'][$key]['addr_county'].'\',districtSel: \''.$this->data['layoutv2'][$key]['addr_district'].'\',';
			}

			// 要注意，這裡是寫死的，而非寫在Shoppingcar的class裡面
			if($this->data['router_class'] == 'shoppingcar'){
				if(
					isset($_SESSION['productshop_attr'][$key]['addr_county']) and $_SESSION['productshop_attr'][$key]['addr_county'] != ''
					and isset($_SESSION['productshop_attr'][$key]['addr_district']) and $_SESSION['productshop_attr'][$key]['addr_district'] != ''
				){
					$this->data['BODY_END'] .= 'countySel: \''.$_SESSION['productshop_attr'][$key]['addr_county'].'\',districtSel: \''.$_SESSION['productshop_attr'][$key]['addr_district'].'\',';
				}
				$url = $this->createUrl('shoppingcar/formbuyerinputsave');
				$this->data['BODY_END'] .= <<<XXX
onCountySelect: function(){
	$.ajax({
		type: "POST",
		data: {
			'name': $(this).attr('name'),
			'value': $(this).val()
		},
		url: '$url',
		success: function(response){
			//eval(response);
		}
	}); // ajax
},
onDistrictSelect: function(){
	$.ajax({
		type: "POST",
		data: {
			'name': $(this).attr('name'),
			'value': $(this).val()
		},
		url: '$url',
		success: function(response){
			//eval(response);
		}
	}); // ajax
},
XXX;
			}

			$this->data['BODY_END'] .= <<<XXX
		// 依序套用至縣市、鄉鎮市區及郵遞區號框
		'css': ['form-control', 'form-control', 'form-control']
	});
});
</script>
XXX;
?>

		<?php if($this->data['router_class'] == 'shoppingcar'):?>
			<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
			<?php $url = $this->createUrl('shoppingcar/formbuyerinputsave')?>
			<?php $this->data['BODY_END'] .= <<<XXX
<script type="text/javascript">
$( document ).ready(function() {
	$('#form_data input').change(function(){
		$.ajax({
			type: "POST",
			data: {
				'name': $(this).attr('name'),
				'value': $(this).val()
			},
			url: '$url',
			success: function(response){
				//eval(response);
			}
		}); // ajax
	});
});
</script>
XXX;
?>
		<?php endif?>

		<?php // 加入會員?>

		<?php if($this->data['router_class'] == 'member'):?>
			<div class="col-md-6">
		<?php else:?>
			<div  class="col-md-10 col-md-offset-1">
		<?php endif?>
			<?php echo $this->renderPartial('//include/default_validate', $this->data)?>
			<form class="form-horizontal" action="" method="post" name="form_data" id="form_data">
				<?php if($this->data['router_class'] == 'member'):?>
					<div class="form-group">
						<label class="col-xs-3 control-label"><small class="cis2">※</small>登入帳號 (E-Mail)</label>
						<div class="col-xs-9">
							 <input type="text" class="form-control" id="login_account" name="login_account" value="<?php echo $this->d('login_account',$key)?>" />
						</div>
					</div>
				<?php elseif($this->data['router_class'] == 'guest'):?>
					<div class="form-group">
						<label class="col-xs-3 control-label"><small class="cis2">※</small>登入帳號 (E-Mail)</label>
						<div class="col-xs-9">
							 <input type="text" class="form-control" id="login_account" name="login_account" />
						</div>
					</div>
				<?php else:?>
					<div class="form-group">
						<label class="col-xs-3 control-label">登入帳號 (E-Mail)：</label>
						<div class="col-xs-9">
						<p class="form-control-static"><?php echo $this->d('login_account',$key)?></p>
						</div>
					</div>
				<?php endif?>


				<?php if($this->data['router_class'] == 'member' ):?>
					<div class="form-group">
						<label class="col-xs-3 control-label"><small class="cis2">※</small>密碼</label>
						<div class="col-xs-9">
							<input type="password" class="form-control" id="login_password" name="login_password" value="<?php echo $this->d('login_password',$key)?>" placeholder="密碼由英文、數字組成。">
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label"><small class="cis2">※</small>密碼確認</label>
						<div class="col-xs-9">
							<input type="password" class="form-control" id="login_password_confirm" name="login_password_confirm" value="<?php echo $this->d('login_password_confirm',$key)?>" placeholder="請再輸入一次密碼">
						</div>                                
					</div>
				<?php elseif($this->data['router_class'] == 'guest'):?>
					<div class="form-group">
						<label class="col-xs-3 control-label"><small class="cis2">※</small>密碼</label>
						<div class="col-xs-9">
							<input type="password" class="form-control" id="login_password" name="login_password" placeholder="密碼由英文、數字組成。">
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label"><small class="cis2">※</small>密碼確認</label>
						<div class="col-xs-9">
							<input type="password" class="form-control" id="login_password_confirm" name="login_password_confirm" placeholder="請再輸入一次密碼">
						</div>                                
					</div>
				<?php endif?>

				<div class="form-group">
					<label class="col-xs-3 control-label"><small class="cis2">※</small>姓名</label>
					<div class="col-xs-6">
						<input type="text" class="form-control" id="name" name="name" value="<?php echo $this->d('name',$key)?>" />
					</div>
					<label class="radio-inline">
					  <input type="radio" name="sex" value="1" <?php echo $this->dradio('sex','1',$key,true)?> /> 先生
					</label>
					<label class="radio-inline">
					  <input type="radio" name="sex" value="2" <?php echo $this->dradio('sex','2',$key)?> /> 小姐
					</label>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label"><small class="cis2">※</small>生日</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" id="birthday" name="birthday" value="<?php echo $this->d('birthday',$key)?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-3 control-label"><small class="cis2">※</small>聯絡電話</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" id="phone" name="phone" placeholder="請填寫聯絡電話，格式如 : 0425674185 或 0912345678" value="<?php echo $this->d('phone',$key)?>" />
					</div>
				</div>
				<div class="form-group ">
					<label class="col-xs-3 control-label"><small class="cis2">※</small>地址</label>

					<div class="col-xs-9 margin_base_b">
						<div id="twzipcode"></div>
					</div>
					<div class="col-xs-9 col-xs-offset-3">
						<input type="text" class="form-control" id="addr" name="addr" placeholder="請填寫完整地址"  value="<?php echo $this->d('addr',$key)?>" />
					</div>

				</div>

				
					<div class="form-group">
						<label class="col-xs-3 control-label"><small class="cis2">※</small>驗證碼</label>
						<div class="col-xs-5">
							<input class="form-control" id="captcha" name="captcha">
						</div>
						<div class="col-xs-4">
							<img border="0" align="absbottom" id="valImageId" src="<?php echo $this->createUrl('guest/captcha')?>"> <a href="javascript:void(0)" onclick="RefreshImage('valImageId')"><?php echo G::t(null,'更新驗證碼')?></a>
						</div>

					</div>
				


				<!-- show ligin/check -->
				<div class="modal fade membernotice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<p class="text-right">
								<button class="btn-cus btn-lg" data-dismiss="modal">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</p>
							<div class="col-sm-10 col-sm-offset-1">
								<div class="row">
									<div class="col-sm-12">
										<p class="title-sm title-c text-center margin_base_t">Member Notice<span class="title-c">會員需知</span></p>
									</div>
									<div class="col-sm-12">
										<?php if(isset($this->data['sys_configs']['shoparticle2_tw'])):?>
											<?php echo $this->data['sys_configs']['shoparticle2_tw']?>
										<?php endif?>
										<?php if(0 and isset($this->data['layoutv2'][$this->data['section']['key']]['member_policy'])):?>
											<?php echo $this->data['layoutv2'][$this->data['section']['key']]['member_policy']?>
										<?php endif?>
									</div>
								</div>
							</div>
							<div class="modal-footer">
							</div>
						</div>
					</div>
				</div>
				<!-- show ligin/check END-->

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<?php if($this->data['router_class'] == 'guest'):?>
						<div class="col-md-12">
							<p>感謝您，填妥本表單相關資料，我們立刻為您註冊會員資格。 </p>
							<p>若有任何問題歡迎來電聯絡。</p>
							<p>若想知道會員詳請，請參考 <a class="btn btn-link" data-toggle="modal" data-target=".membernotice">會員需知</a></p>
							<input id="terms" type="checkbox" checked="checked" /> 接受會員條款
						</div>
						<?php endif?>

						
						<button type="submit" class="btn-primary">Submit</button>
						
					</div>
				</div>
				<input id="force_save" type="hidden" name="123" />
			</form>
		</div>

		<?php endif?><?php // shoppingcar authw?>

	<?php elseif($this->data['layoutv2_sections_select'] == '2'):?><?php // 忘記密碼?>
		<div  class="col-md-10 col-md-offset-1">
			<?php echo $this->renderPartial('//include/default_validate', $this->data)?>
			<form class="form-horizontal" action="" method="post" name="form_data" id="form_data">
				<div class="form-group">
					<label class="col-xs-3 control-label"><small class="cis2">※</small>請輸入您的帳號</label>
					<div class="col-xs-9">
						 <input type="text" class="form-control" id="login_account" name="login_account" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label"><small class="cis2">※</small>驗證碼</label>
					<div class="col-xs-5">
						<input class="form-control" id="captcha" name="captcha">
					</div>
					<div class="col-xs-4">
						<img border="0" align="absbottom" id="valImageId" src="<?php echo $this->createUrl('guest/captcha')?>"> <a href="javascript:void(0)" onclick="RefreshImage('valImageId')"><?php echo G::t(null,'更新驗證碼')?></a>
					</div>

				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button type="submit" class="btn-primary">Submit</button>
					</div>
				</div>
				<input id="force_save" type="hidden" name="123" />
			</form>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '3'):?><?php // 重設密碼?>
		<div  class="col-md-10 col-md-offset-1">
			<?php echo $this->renderPartial('//include/default_validate', $this->data)?>
			<form class="form-horizontal" action="" method="post" name="form_data" id="form_data">
				<div class="form-group">
					<label class="col-xs-3 control-label"><small class="cis2">※</small>密碼</label>
					<div class="col-xs-9">
						<input type="password" class="form-control" id="login_password" name="login_password" placeholder="密碼由英文、數字組成。">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-3 control-label"><small class="cis2">※</small>密碼確認</label>
					<div class="col-xs-9">
						<input type="password" class="form-control" id="login_password_confirm" name="login_password_confirm" placeholder="請再輸入一次密碼">
					</div>                                
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button type="submit" class="btn-primary">Submit</button>
					</div>
				</div>
				<input id="force_save" type="hidden" name="123" />
			</form>
		</div>
	<?php endif?>
<?php endif?>

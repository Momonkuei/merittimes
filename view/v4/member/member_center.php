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

<div class="member_center">

  <section class="sectionBlock">
    <div class="container">

      <?php //include('memberCenter_title.php'); ?>
<?php echo $__?>

	  <div><a class="btn-gray2" href="memberlogout_<?php echo $this->data['ml_key']?>.php">會員登出<i class="fa fa-sign-out" aria-hidden="true"></i></a></div>
      <div class="formLine"></div>

      <div class="innerBlock_small memberData">
        <div class="blockTitle">
          <span>基本資料</span>
        </div>
		<form target="hideframe" action="" method="post" name="memberForm" id="form_data" class="row cont_form" <?php // enctype="multipart/form-data" ?> > <input type="hidden" name="gtoken" class="gtoken" />

			<?php // https://stackoverflow.com/questions/7083325/firefox-form-targeting-an-iframe-is-opening-new-tab?noredirect=1&lq=1?>
			<iframe id="hideframe" name="hideframe" style="display:none" src=""></iframe>
			<input id="force_save" type="hidden" name="123" />
			<input type="hidden" name="func" value="profile" />

			<input type="hidden" name="func" value="profile" />

          <div class="form_group col-lg-6">
			<label><?php echo t('帳號')?></label>
			<span><input class="formData" type="email" disabled="disabled" value="<?php echo $member['login_account']?>"></span>
          </div>
          <div class="form_group col-lg-6">
			<label><?php echo t('密碼')?></label>
			<span>****** <a class="icon-link" href="memberchangepassword_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-pencil-square-o"></i><?php echo t('修改密碼')?></a></span>
          </div>
          <div class="form_group col-lg-6 edit">
			<label><?php echo t('姓名')?></label>
			<span><input class="formData" type="text" id="ggg" disabled="disabled" name="name" value="<?php echo $member['name']?>"></span>
          </div>
          <div class="form_group col-lg-6 edit">
			<label><?php echo t('聯絡電話')?></label>
			<span><input class="formData" type="tel" disabled="disabled" name="phone" value="<?php echo $member['phone']?>"></span>
          </div>
          <div class="form_group col-lg-6 edit">
			<label><?php echo t('性別')?></label>
			<select class="formData" name="gender" disabled="disabled">
	     	  <option value="0" <?php if(isset($member['gender']) and $member['gender'] == '0'):?> selected="selected" <?php endif?> ><?php echo t('未填寫')?></option>
			  <option value="1" <?php if(isset($member['gender']) and $member['gender'] == '1'):?> selected="selected" <?php endif?> ><?php echo t('男')?></option>
			  <option value="2" <?php if(isset($member['gender']) and $member['gender'] == '2'):?> selected="selected" <?php endif?> ><?php echo t('女')?></option>
			</select>
          </div>
          <div class="form_group col-lg-6 edit">
			<label><?php echo t('生日')?></label>
			<span><input class="formData" type="date" disabled="disabled" name="birthday" value="<?php echo $member['birthday']?>"></span>
          </div>
		  <div class="form_group col-lg-12 edit">
				<div class="formItem oneLine edit">
					<label t="* tw ucfirst">地址</label>
					<span class="twzipcode_form_1"></span>
				</div>	

				<div class="formItem edit">
					<input type="hidden" id="zipcode_1" name="zipcode_1" value="<?php echo $member['addr_zipcode']?>">
					<input type="hidden" id="county_1" name="county_1" value="<?php echo $member['addr_county']?>">
					<input type="hidden" id="district_1" name="district_1" value="<?php echo $member['addr_district']?>">
					<input type="text" disabled="disabled" id="addr" name="addr" value="<?php echo $member['addr']?>">
				</div>
		  </div>
          <div class="form_group col-lg-12 edit">
            <div class="checkBox_group">
              <input type="checkbox" id="check_news" disabled="disabled" <?php if(isset($member['need_dm']) and $member['need_dm'] == '1'):?> checked <?php endif?> name="need_dm" value="1" />
              <label for="check_news"><span class="signIcon"></span>願意收到產品相關訊息或活動資訊</label>
            </div>
          </div>
          <div class="form_group col-lg-12">
            <button class="btn-cis1" id="memberDataEdit" data-status='edit'><i class="fa fa-pencil-square-o" aria-hidden="true"></i><?php echo t('修改資料')?></button>
          </div>
        </form><!-- .cont_form -->
      </div><!-- .innerBlock_small -->

	  <?php if(isset($order) and !empty($order)):?>
		  <div class="innerBlock_mt">
			<div class="blockTitle">
				<span><?php echo t('訂單記錄')?><span><?php echo t('最近三筆')?></span></span>
			</div>
			<div class="responsive_tbl">
			  <table class="tableList">
				<thead>
				  <tr>
					<th><?php echo t('訂單編號')?></th>
					<th><?php echo t('消費時間')?></th>
					<th><?php echo t('訂單金額')?></th>
					<th><?php echo t('付款方式')?></th>
					<th><?php echo t('訂單狀態')?></th>
					<th><?php echo t('查看明細')?></th>
				  </tr>
				</thead>
				<tbody>
					<?php foreach($order as $k => $v):?>
						<tr>
							<td><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><?php echo $v['order_number']?></a></td>
							<td><?php echo $v['create_time']?></td>
							<td><?php echo $v['total']?></td>
							<td><?php if(isset($v['payment_func_name'])){ echo $v['payment_func_name'];}?></td>
<!-- func|start|remove_new_line -->
							<td>
								<?php $no_action = false//只是為了減少程式碼的層次?>
								<?php if($v['order_status'] == 99)://己取消?>
									<span class="orderStatus del"><?php echo $v['order_status_handle']?></span>
								<?php elseif($v['order_status'] == 0)://未付款?>
									<?php foreach ($payments_tmp as $k1 => $v1):?>
										<?php if($v1['func'] == $v['payment_func']):?>
											<?php if($v1['payment_notice']):?>
												<a href="membernoticepayment_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>" class=""><span class="orderStatus noticPay">通知付款</span></a>
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
							<td><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><i class="fa fa-file-text-o" aria-hidden="true"></i>查看明細</a></td>
						</tr>
					<?php endforeach?>
				</tbody>
			  </table>
			</div><!-- .responsive_tbl -->
			<div><a class="btn-cis1" href="memberorderlist_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo t('看更多')?></a></div>
		  </div><!-- .innerBlock_mt -->
	  <?php endif?>

		<?php if(isset($bonus) and !empty($bonus)):?>
      <div class="innerBlock_mt">
        <div class="blockTitle">
			<span><?php echo t('可使用的紅利')?>/<?php echo t('優惠券')?></span>
        </div>
        <div class="responsive_tbl">
          <table class="tableList">
            <thead>
              <tr>
				<th><?php echo t('紅利點數')?></th>
				<th><?php echo t('紅利說明')?></th>
				<th><?php echo t('開始日期')?></th>
				<th><?php echo t('到期日')?></th>
              </tr>
            </thead>
            <tbody>
				<?php foreach($bonus as $k => $v):?>
					<tr>
						<?php if($v['order_number'] != ''):?>
							<td><?php echo t('紅利點數')?>-<?php echo $v['point']?></td>
							<td><?php echo t('紅利說明')?><?php echo t('消費折抵')?><a href="memberorderdetail_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $v['order_number']?>"><?php echo $v['order_number']?></a></td>
							<td><?php echo t('開始日期')?>&nbsp;</td>
							<td><?php echo t('到期日')?>&nbsp;</td>
						<?php else:?>
							<td><?php echo t('紅利點數')?>+<?php echo $v['point']?></td>
							<td><?php echo t('紅利說明')?><?php echo $v['name']?></td>
							<td><?php echo t('開始日期')?><?php echo $v['start_date_name']?></td>
							<td><?php echo t('到期日')?><?php echo $v['start_date_name']?></td>
						<?php endif?>
					</tr>
				<?php endforeach?>
            </tbody>
          </table>
        </div><!-- .responsive_tbl -->
        <div><a class="btn-cis1" href="memberbonuslist_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo t('看更多')?></a></div>
      </div><!-- .innerBlock_mt -->
		<?php endif?>

		<?php if(isset($gift) and !empty($gift)):?>
      <div class="innerBlock_small">
        <div class="responsive_tbl">
          <table class="tableList">
            <thead>
              <tr>
				<th><?php echo t('優惠券名稱')?></th>
				<th><?php echo t('說明')?></th>
				<th><?php echo t('優惠券序號')?></th>
				<th><?php echo t('開始日期')?></th>
				<th><?php echo t('截止日期')?></th>
              </tr>
            </thead>
            <tbody>
				<?php foreach($gift as $k => $v):?>
					<tr>
						<td><?php echo $v['name']?></td>
						<td>
							<?php if($v['gift_condition1'] == '1'):?>
								滿<?php echo $v['gift_condition2']?>
							<?php endif?>

							<?php if($v['gift_do_type'] == '1'):?>
								折扣<?php eval('$aaa=0.'.$v['gift_do_value'].';$aaa=100-($aaa*100);echo $aaa;');?>%
							<?php elseif($v['gift_do_type'] == '2'):?>
								折抵<?php echo $v['gift_do_value']?>元
							<?php endif?>
						</td>
						<td><span id="couponNumber1"><?php echo $v['gift_serial_number']?></span> <a data-clipboard-target="#couponNumber1" class="tips_shipping copyCoupon" href="javascript:void(0);"><i class="fa fa-files-o" aria-hidden="true"></i>複製</a></td>
						<td><?php echo t('開始日期')?></label><small><?php echo $v['start_date']?></td>
						<td><?php echo t('截止日期')?></label><small><?php echo $v['end_date']?></td>
					</tr>
				<?php endforeach?>
            </tbody>
          </table>
        </div><!-- .responsive_tbl -->
      </div><!-- .innerBlock_small -->
		<?php endif?>

		<?php if(isset($member_address) and !empty($member_address)):?>
      <div class="innerBlock_mt">
        <div class="blockTitle">
          <span><?php echo t('收件地址簿')?></span>
        </div>
        <div class="responsive_tbl memberAddressBook">
          <table class="tableList">
            <thead>
              <tr>
				<th><?php echo t('收件人')?></th>
				<th><?php echo t('性別')?></th>
				<?php if(0):?><th><?php echo t('郵遞區號')?></th><?php endif?><?php //跑訂單流程的時候，不會把zipcode放到session，所以這個一定是空白 by lota?>
				<th><?php echo t('縣市')?></th>
				<th><?php echo t('地區')?></th>
				<th><?php echo t('地址')?></th>
				<th><?php echo t('修改')?></th>
				<th><?php echo t('刪除')?></th>
              </tr>
            </thead>
            <tbody>
				<?php foreach($member_address as $k => $v):?>
					<tr id="addrBook_<?php echo $k?>">
						<td><?php echo $v['name']?></td>
                        <td><?php if($v['gender'] == '1'):?><?php echo t('先生')?><?php elseif($v['gender'] == '2'):?><?php echo t('小姐')?><?php else :?><?php echo t('未填寫')?><?php endif?></td>
						<?php if(0):?><td><?php echo $v['addr_zipcode']?></td><?php endif?>
						<td><?php echo $v['addr_county']?></td>
						<td><?php echo $v['addr_district']?></td>
						<td><?php echo $v['addr']?></td>
						<td><a class="tips_details" href="membercustomeraddress_<?php echo $this->data['ml_key']?>.php?id=<?php echo $v['id']?>"><i class="fa fa-pencil-square-o"></i><?php echo t('修改')?></a></td>
						<td><a class="tips_details" href="membercustomeraddress_<?php echo $this->data['ml_key']?>.php?del=<?php echo $v['id']?>" onclick="return confirm('<?php echo t('你確定要刪掉這筆資料？')?>')" class="delAddr" data-target="<?php echo $k?>"><i class="fa fa-trash-o"></i><?php echo t('刪除')?></a></td>
					</tr>				
				<?php endforeach?>

            </tbody>
          </table>
        </div><!-- .responsive_tbl -->
        <div><a class="btn-cis1 addAddr" href="membercustomeraddress_<?php echo $this->data['ml_key']?>.php?id=0"><i class="fa fa-plus" aria-hidden="true"></i>新增一筆</a></div>
      </div><!-- .innerBlock_mt -->
		<?php endif?>

    </div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_center -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
	$('body').on('click','#memberDataEdit',function(){	
		if($(this).attr('data-status')=='edit'){
			$('.twzipcode_form_1').twzipcode('set', {'county':$("#county_1").val(),'district':$("#district_1").val(),'zipcode':$("#zipcode_1").val()}); //#39227
			$('.memberData .edit input[disabled="disabled"]').removeAttr('disabled'); 
			$('.memberData .edit select[disabled="disabled"]').removeAttr('disabled'); 
			$(this).html('<i class="fa fa-check"></i><?php echo t('完成修改')?>').attr('data-status','submit');
			return false;
		}else if($(this).attr('data-status')=='submit'){
			// do something...?
			// after save, disabled input							
			$('.memberData .edit input').attr("disabled","disabled"); 
			$('.memberData .edit select').attr("disabled","disabled"); 
			$(this).html('<i class="fa fa-pencil"></i><?php echo t('修改資料')?>').attr('data-status','edit');

			var need_dm = 0;
			if($('.memberData input[name=need_dm]').is(":checked")){
				need_dm = 1;
			}

			$('.twzipcode_form_1').twzipcode('get', function (county, district, zipcode) {
            $("#zipcode_1").val(zipcode); //#39227
            $("#county_1").val(county); //#39227
            $("#district_1").val(district); //#39227
            }); 

			$.ajax({
				type: "POST",
				data: {
					'name': $('.memberData input[name=name]').val(),
					'gender': $('.memberData select[name=gender]').val(),
					'need_dm': need_dm,
					'birthday': $('.memberData input[name=birthday]').val(),
					'phone': $('.memberData input[name=phone]').val(),
					'addr_county': $("#county_1").val(),
                    'addr_district': $("#district_1").val(),
                    'addr_zipcode': $('.memberData input[name=addr_zipcode]').val(),
                    'addr': $('.memberData input[name=addr]').val(),
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
		return false;
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

<?php if(0):?><!-- body_end -->
<script src="js_common/reload.js"></script>
<?php endif?><!-- body_end -->
<?php if(0):?><!-- body_end -->
<script type="text/javascript">
    var setPoint=1024;
    var mbViewPoint=mbViewPointSet(setPoint);
    function mbViewPointSet(viewPoint){
        viewPoint=(viewPoint>0)?viewPoint:768;
        viewPoint='(max-width: '+viewPoint+'px)';
        viewPoint=window.matchMedia(viewPoint).matches;
        return viewPoint;
    }
    if(!mbViewPoint){
        if($('.twzipcode_form_1').length){
            if(typeof ml_key == 'undefined' || ml_key == 'tw'){
                //$('.twzipcode_form_1').twzipcode();
                $('.twzipcode_form_1').twzipcode({
                    countyName: 'addr_county',
                    districtName: 'addr_district',
                    zipcodeName: 'addr_zipcode',
                });
            }
        }
    }
    $('.twzipcode_form_1').twzipcode('set', {'county':$("#county_1").val(),'district':$("#district_1").val(),'zipcode':$("#zipcode_1").val()}); //#39227  
    $("select[name='addr_county']").attr("disabled","disabled");  //#39227
    $("select[name='addr_district']").attr("disabled","disabled");  //#39227
    $("input[name='addr_zipcode']").attr("disabled","disabled");  //#39227
</script>
<?php endif?><!-- body_end -->
<script type="text/javascript">
if($('.twzipcode_form_1').length){
    if(typeof ml_key == 'undefined' || ml_key == 'tw'){
        //$('.twzipcode_form_1').twzipcode();
        $('.twzipcode_form_1').twzipcode({
            countyName: 'addr_county',
            districtName: 'addr_district',
            zipcodeName: 'addr_zipcode',
        });
    }
}
$('.twzipcode_form_1').twzipcode('set', {'county':$("#county_1").val(),'district':$("#district_1").val(),'zipcode':$("#zipcode_1").val()}); //#39227
$("select[name='addr_county']").attr("disabled","disabled");  //#39227
$("select[name='addr_district']").attr("disabled","disabled");  //#39227
$("select[name='addr_zipcode']").attr("disabled","disabled");  //#39227
</script>
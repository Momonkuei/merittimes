<?php if(isset($this->data['layoutv2_sections_select'])):?>
	<?php if($this->data['layoutv2_sections_select'] == '1'):?><?php // 麵包屑?>
		[POS1]
		<?php if(!isset($this->data['layoutv2'][$this->data['section']['key']]['func_name'])):?>
			<?php $this->data['layoutv2'][$this->data['section']['key']]['func_name'] = '未設定名稱'?>
		<?php endif?>
		<?php if(!isset($this->data['layoutv2'][$this->data['section']['key']]['func_en_name'])):?>
			<?php $this->data['layoutv2'][$this->data['section']['key']]['func_en_name'] = 'unknow'?>
		<?php endif?>
		<div>
			<ol class="breadcrumb floatright marginb0">
				<li><a href="index.html">HOME</a></li>
				<li class="active"><a href="#"><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name']?></a></li>
			</ol>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '2'):?><?php // 購物車上的3個大按鈕?>
		<div class="btn <?php if($this->data['router_method'] == 'index'):?>btn-default<?php else:?>btn-cus<?php endif?>">
			<h4 class="">Step1</h4>
			<p class="">確認訂單＆選擇付款方式</p>
		</div>
		<div class="btn <?php if($this->data['router_method'] == 'form'):?>btn-default<?php else:?>btn-cus<?php endif?>">
			<h4 class="">Step2</h4>
			<p class="">填寫訂購資料</p>
		</div>
		<div class="btn <?php if($this->data['router_method'] == 'success'):?>btn-default<?php else:?>btn-cus<?php endif?>">
			<h4 class="">Step3</h4>
			<p class="">完成訂購</p>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '3'):?>

		<?php $car = new Shoppingcar?>

		<?php $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'productshopspec',':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll()?>
		<?php
		$specs_tmp = array();
		if($rows){
			foreach($rows as $k => $v){
				$specs_tmp[$v['id']] = $v;
			}
		}
		?>

		<?php if($car->hasdata()):?>
			<!--商品資料標題-->
			<div class="checkitem col-sm-12 hidden-xs hidden-sm">
				<div>
					<div class="Bbox_in_2c_L3 col-sm-10 col-md-11 col-md-offset-1">
						<div>
							<div>
								<div>
									<table class="checklist th pro_title_name">
										<tbody>
											<tr>
												<td>名稱</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div>
								<div>
									<table class="checklist th">
										<tbody>
											<tr>
												<td>價格</td>
												<td>規格</td>
												<td>數量</td>
												<td>小計</td>
												<td>刪除</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--商品資料標題 END-->
			<?php $productshop = $car->get()?>
			<?php foreach($productshop as $k => $v):?>
				<!--商品資料 1筆-->
				<div class="Bbox_sin_12_12">
					<div>
						<div class="checkitem col-sm-12">
							<div>
								<div class="checkimg">
									<a href="<?php echo $this->createUrl('site/productshopdetail',array('id2'=>$k,'id'=>$v['class_id']))?>"><img src="<?php echo '_i/assets/upload/productshop/'.$v['pic1']?>"></a>
								</div>
								<div class="col-sm-9 col-md-11">
									<div class="row">
										<div class="col-md-3 col-xs-12">
											<div class="row">
												<table class="checklist  pro_title_name">
													<tbody>
														<tr>
															<td><a href="<?php echo $this->createUrl('site/productshopdetail',array('id2'=>$k,'id'=>$v['class_id']))?>"><?php echo $v['name']?></a></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-9">
											<div class="row">
												<table class="checklist">
													<tbody>
														<tr class="hidden-md hidden-lg th">
															<td>價格</td>
															<td>規格</td>
															<td>數量</td>
															<td>小計</td>
															<td>刪除</td>
														</tr>
														<tr>
															<td valign="center">$<?php echo $v['price']?></td>
															<td>
																<?php if(isset($specs_tmp[$v['spec_id']])):?><?php echo $specs_tmp[$v['spec_id']]['topic']?><?php endif?>
															</td>
															<td>
																<select item_id="<?php echo $k?>" class="form-control input-sm col-xs-offset-4 inventorylist">
																	<?php if($v['inventory'] > 0):?>
																		<?php $y = $v['inventory']?>
																		<?php if($v['inventory'] > 10):?>
																			<?php $y = 10?>
																		<?php endif?>

																		<?php for($x=1;$x<=$y;$x++):?>
																			<option <?php if($v['amount'] == $x):?> selected="selected" <?php endif?> ><?php echo $x?></option>
																		<?php endfor?>
																	<?php endif?>
																</select>
															</td>
															<td valign="center"><?php echo $v['price']*$v['amount']?></td>
															<td><a href="<?php echo $this->createUrl('shoppingcar/del',array('id'=>$k))?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--商品資料 1筆 END-->
			<?php endforeach?>
		<?php else:?>
			<div class="text-center"> 您尚未選購任何商品 </div>
		<?php endif?>

		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $href = $this->createUrl('shoppingcar/change',array('id'=>''))?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script type="text/javascript">
	$( document ).ready(function() {
		$('.inventorylist').change(function(){
			var id = $(this).attr('item_id');
			window.location.href='$href'+id+'&amount='+$(this).val();
		});
	});
</script>
XXX;
?>

	<?php elseif($this->data['layoutv2_sections_select'] == '4'):?>

		<?php $car = new Shoppingcar?>
		<?php if($car->hasdata()):?>
			<?php $total = $car->total()?>

			<p class="title-sm"></p>
			<p>合計：$<?php echo $total['sum']?></p>
			<p>運費：$<?php echo $total['shipment']?></p>

			<?php if(0):?>
				<p>折扣：-$80</p>
			<?php endif?>

			<p>總計：<span class="cis2"><b>NTD.<?php echo $total['total']?></b></span></p>
		<?php endif?>

	<?php elseif($this->data['layoutv2_sections_select'] == '5'):?>

		<?php $car = new Shoppingcar?>
		<?php //$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'paymenttype','ml_key'=>$this->data['ml_key']))->queryAll()?>
		<?php $rows = $this->db->createCommand()->from('payment_type')->where('is_enable=1')->queryAll()?>
		<em class="cis2">※</em>付款方式：
		<?php if(isset($rows) and count($rows) > 0):?>
			<?php foreach($rows as $k => $v):?>
				<label>
					<input 
						type="radio"
						<?php //name="paymenttype" ?>
						value="<?php echo $v['func']?>" 
						<?php echo $car->dradio('type',$v['func'],'paymenttype')?>
						onclick="window.location.href='<?php echo $this->createUrl('shoppingcar/paymenttype',array('paymenttype'=>$v['func']))?>';"
					>
					<?php echo $v['name']?>
				</label>
			<?php endforeach?>
		<?php endif?>

	<?php elseif($this->data['layoutv2_sections_select'] == '6'):?>

		<button onclick="window.location.href='<?php echo $this->createUrl('site/productshop')?>'">返回購物</button>

		<?php $car = new Shoppingcar?>
		<?php if($car->hasdata()):?>
			<a href="<?php echo $this->createUrl('shoppingcar/form')?>" class="btn btn-warning">下一步</a>
		<?php endif?>

	<?php elseif($this->data['layoutv2_sections_select'] == '7'):?>

		<form class="form-horizontal col-md-6">
			<div class="form-group">
				<label class="col-xs-3 control-label"><small class="cis2">※</small>E-Mail</label>
				<div class="col-xs-9">
					<input type="text" class="form-control" placeholder="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label"><small class="cis2">※</small>密碼</label>
				<div class="col-xs-9">
					<input type="password" class="form-control" placeholder="密碼由英文、數字組成。">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label"><small class="cis2">※</small>密碼確認</label>
				<div class="col-xs-9">
					<input type="password" class="form-control" placeholder="請再輸入一次密碼">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label"><small class="cis2">※</small>姓名</label>
				<div class="col-xs-6">
					<input type="text" class="form-control" placeholder="">
				</div>
				<label class="radio-inline">
					<input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="先生"> 先生
				</label>
				<label class="radio-inline">
					<input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="小姐"> 小姐
				</label>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label"><small class="cis2">※</small>生日</label>
				<div class="col-xs-9">
					<input type="text" class="form-control" placeholder=" " id="inputdate">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label"><small class="cis2">※</small>聯絡電話</label>
				<div class="col-xs-9">
					<input type="text" class="form-control" placeholder="請填寫聯絡電話，格式如 : 0425674185 或 0912345678">
				</div>
			</div>
			<div class="form-group ">
				<label class="col-xs-3 control-label"><small class="cis2">※</small>地址</label>
				<div class="col-xs-9 margin_base_b">
					<div class="twzipcode"></div>
				</div>
				<div class="col-xs-9 col-xs-offset-3">
					<input type="text" class="form-control" placeholder="請填寫完整地址">
				</div>
			</div>
		</form>

	<?php elseif($this->data['layoutv2_sections_select'] == '8'):?>

		<?php $key = 'recipient'?>

		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script src="common/twzipcode/jquery.twzipcode.min.js"></script>
<script>
$(function() {
	$('#twzipcode2').twzipcode({
		countyName: 'addr_county',
		districtName: 'addr_district',
		zipcodeName: 'addr_zipcode',

XXX;

		if(
			isset($_SESSION['productshop_attr'][$key]['addr_county']) and $_SESSION['productshop_attr'][$key]['addr_county'] != ''
			and isset($_SESSION['productshop_attr'][$key]['addr_district']) and $_SESSION['productshop_attr'][$key]['addr_district'] != ''
		){
			$this->data['BODY_END'] .= 'countySel: \''.$_SESSION['productshop_attr'][$key]['addr_county'].'\',districtSel: \''.$_SESSION['productshop_attr'][$key]['addr_district'].'\',';
		}

		$url = $this->createUrl('shoppingcar/formrecipientinputsave');
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

		$this->data['BODY_END'] .= <<<XXX

		// 依序套用至縣市、鄉鎮市區及郵遞區號框
		'css': ['form-control', 'form-control', 'form-control']
	});
});
</script>
XXX;
?>

		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $url = $this->createUrl('shoppingcar/formrecipientinputsave')?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script type="text/javascript">
$( document ).ready(function() {
	$('#form_data_recipient_same_buyer input').change(function(){
		if(this.checked){
			var val = '1';
		} else {
			var val = '0';
		}
		$.ajax({
			type: "POST",
			data: {
				'name': $(this).attr('name'),
				'value': val
			},
			url: '$url',
			success: function(response){
				//eval(response);
			}
		}); // ajax
	});

	$('#form_data_recipient input').change(function(){
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

		<form action="" method="post" id="form_data_recipient_same_buyer">
			<div class="checkbox ">
				<label>
					<input type="checkbox" class="samedata" name="same" value="1" <?php echo $this->dradio('same','1',$key)?>  > 收件人同訂購人
				</label>
			</div>
			<div class="title-sm"></div>
		</form>

		<form action="" method="post" class="form-horizontal col-md-6 receiverform" id="form_data_recipient">

			<div class="form-group">
				<label class="col-xs-3 control-label"><small class="cis2">※</small>收件人</label>
				<div class="col-xs-5">
					<input type="text" class="form-control" id="name" name="name" value="<?php echo $this->d('name',$key)?>" />
				</div>
				<div class="col-xs-4">
				<label class="radio-inline">
					<input type="radio" name="sex" value="1" <?php echo $this->dradio('sex','1',$key,true)?> > 先生
				</label>
				<label class="radio-inline">
					<input type="radio" name="sex" value="2" <?php echo $this->dradio('sex','2',$key)?> > 小姐
				</label>
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
					<div id="twzipcode2"></div>
				</div>
				<div class="col-xs-9 col-xs-offset-3">
					<input type="text" class="form-control" id="addr" name="addr" placeholder="請填寫完整地址"  value="<?php echo $this->d('addr',$key)?>" />
				</div>
			</div>
		</form>

	<?php elseif($this->data['layoutv2_sections_select'] == '9'):?>

		<?php $car = new Shoppingcar?>

		<?php $key = 'invoice'?>

		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $url = $this->createUrl('shoppingcar/forminvoiceinputsave')?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script type="text/javascript">
$( document ).ready(function() {
	$('#form_data_invoice input').change(function(){
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
	$('#form_data_invoice select').change(function(){
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

		<form action="" method="post" id="form_data_invoice">
			<div class="radio">
				<em class="cis2">※</em>是否捐贈發票：
				<label>
					<input type="radio" name="donation" value="1" <?php echo $this->dradio('donation','1',$key)?> > 是
				<label>
					<input type="radio" name="donation" value="2" <?php echo $this->dradio('donation','2',$key,true)?> > 否
			</div>

			<?php if($car->has_invoice_fields()):?>
				<div class="col-md-12">
					<p class="margin_sm_tb title"></p>
					<p>如需捐贈發票請填寫以下資訊：<a href="https://www.einvoice.nat.gov.tw/APMEMBERVAN/XcaOrgPreserveCodeQuery/XcaOrgPreserveCodeQuery" target="_blank">查詢愛心碼</a></p>
					<div class="col-md-4 margin_base_b">
						<input type="text" class="form-control" id="love_code" name="love_code" value="<?php echo $this->d('love_code',$key)?>" placeholder="愛心碼" />
					</div>
				</div>
				<div class="col-md-12">
					<div class="radio">
						<em class="cis2">※</em>發票類型：
						<label>
							<input type="radio" name="type" value="2" <?php echo $this->dradio('type',2,$key,true)?> > 二聯
						<label>
							<input type="radio" name="type" value="3" <?php echo $this->dradio('type',3,$key)?> > 三聯 
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-4 margin_base_b">
						<select id="carruer_type" name="carruer_type" class="form-control">
							<option value="0">請選擇</option>
							<option value="1" <?php echo $this->dselect('carruer_type',1,$key,true)?> >會員載具</option>
							<option value="2" <?php echo $this->dselect('carruer_type',2,$key)?> >自然人憑證</option>
							<option value="3" <?php echo $this->dselect('carruer_type',3,$key)?> >手機條碼</option>
						</select>
					</div>
					<div class="col-md-8 margin_base_b">
						<input type="text" class="form-control" id="carruer_number" name="carruer_number" value="<?php echo $this->d('carruer_number',$key)?>" placeholder="編號" />
					</div>
				</div>
			<?php endif?>

			<div class="col-md-12">
				<p class="margin_sm_tb title"></p>
				<p>如需發票請填寫以下資訊：</p>
				<div class="col-md-4 margin_base_b">
					<input type="text" class="form-control" id="tax_id" name="tax_id" value="<?php echo $this->d('tax_id',$key)?>" placeholder="統一編號" />
				</div>
				<div class="col-md-8 margin_base_b">
					<input type="text" class="form-control" id="name" name="name" value="<?php echo $this->d('name',$key)?>" placeholder="公司抬頭" />
				</div>
				<div class="col-md-12 margin_base_b">
					<input type="text" class="form-control" id="addr" name="addr" value="<?php echo $this->d('addr',$key)?>" placeholder="發票寄送地址" />
				</div>
			</div>
		</form>

	<?php elseif($this->data['layoutv2_sections_select'] == '10'):?>

		<a class="btn btn-default" href="<?php echo $this->createUrl('shoppingcar/index')?>">返回更改付款方式</a>
		<a class="btn btn-warning" href="<?php echo $this->createUrl('shoppingcar/success')?>">下一步</a>

	<?php elseif($this->data['layoutv2_sections_select'] == '11'):?>

		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
		<?php $row = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:alias', array(':type'=>'paymenttype',':ml_key'=>$this->data['ml_key'],':alias'=>$tmp['attr']['paymenttype']['type']))->queryRow()?>

		<?php $tmp1 = $row['detail']?>
		<?php $tmp1 = str_replace('{AA}', $tmp['orderform']['buyer_name'], $tmp1)?>
		<?php $tmp1 = str_replace('{BB}', $tmp['orderform']['order_number'], $tmp1)?>
		<?php $tmp1 = str_replace('{CC}', $tmp['orderform']['total'], $tmp1)//好像不含運費，要修一下?>

		<?php echo $tmp1?>

		<?php if(0):?>
			<p>
				○○○ 先生/小姐您好：
				<br> 感謝您的訂購！
				<br> 以下是您的付款資訊，請您於7天內至各銀行ATM轉帳付款：
			</p>
			<p>訂單編號：#123456789</p>
			<p>訂單金額：2200 </p>
			<p>付款方式：銀行匯款/ATM轉帳 </p>
			<p>銀行代碼：111</p>
			<p>銀行帳號：1234567891</p>
			<p>銀行戶名：百爾來網路有限公司</p>
			<p>銀行名稱： 大眾銀行 testa</p>
		<?php endif?>

	<?php elseif($this->data['layoutv2_sections_select'] == '12'):?>

		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>

		<?php $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'productshopspec',':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll()?>
		<?php
		$specs_tmp = array();
		if($rows){
			foreach($rows as $k => $v){
				$specs_tmp[$v['id']] = $v;
			}
		}
		?>

		<table class="table text-center margin_base_tb">
			<tbody>
				<tr>
					<td class="col-xs-2"></td>
					<td class="col-xs-6 text-left">名稱</td>
					<td class="col-xs-1">價格</td>
					<td class="col-xs-1">規格</td>
					<td class="col-xs-1">數量</td>
					<td class="col-xs-1">小計</td>
				</tr>
				<?php $productshop = $tmp['car']?>
				<?php foreach($productshop as $k => $v):?>
					<tr>
						<td>
							<a href="<?php echo $this->createUrl('site/productshopdetail',array('id2'=>$k,'id'=>$v['class_id']))?>"><img src="<?php echo '_i/assets/upload/productshop/'.$v['pic1']?>" class="img-responsive"></a>
						</td>
						<td class="text-left"><a href="<?php echo $this->createUrl('site/productshopdetail',array('id2'=>$k,'id'=>$v['class_id']))?>"><?php echo $v['name']?></a></td>
						<td valign="center">$<?php echo $v['price']?></td>
						<td><?php if(isset($specs_tmp[$v['spec_id']])):?><?php echo $specs_tmp[$v['spec_id']]['topic']?><?php endif?></td>
						<td><?php echo $v['amount']?></td>
						<td valign="center">$<?php echo $v['price']*$v['amount']?></td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>

	<?php elseif($this->data['layoutv2_sections_select'] == '13'):?>

		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
		<?php echo $tmp['attr']['buyer']['raw']?>

		<?php if(0):?>
			<div>姓名：<span>xxxx</span></div>
			<div>電話：<span>0912-345678</span></div>
			<div>Email：<span>abc@buyersline.com.tw</span></div>
			<div>付款方式：<span>匯款.轉帳</span></div>
			<div>是否捐贈發票：<span>否</span></div>
			<div>統一編號：<span>否</span></div>
			<div>公司抬頭：<span>否</span></div>
			<div>發票寄送地址：<span>否</span></div>
		<?php endif?>

	<?php elseif($this->data['layoutv2_sections_select'] == '14'):?>

		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
		<?php echo $tmp['attr']['recipient']['raw']?>

		<?php if(0):?>
			<div>姓名：<span>xxxx</span></div>
			<div>電話：<span>0912-345678</span></div>
			<div>Email：<span>abc@buyersline.com.tw</span></div>
			<div>地址：<span>xxx</span><span>台中市大雅路123號</span></div>
			<div>備註：<span>蚵仔麵線不加蚵仔</span></div>
		<?php endif?>

	<?php elseif($this->data['layoutv2_sections_select'] == '15'):?>

		<p class="title-sm title-c cis3-darker">出貨時間</p>
		<p>
			您所訂購的商品在確認收款無誤後，我們將立即進行出貨程序，你最晚可在7個工作天 內收到訂購的商品。
			<br> 若您超過7個工作天仍未收到訂購商品，請您立即與客服中心連絡，以保障您的權益。
			<br> 消費記錄您可至訂單查詢(須先登入會員)中查詢訂單紀錄。
			<br> 若對訂單有疑問也可在此提出詢問， 我們將在1-2日內儘速以e-mail或電話回覆您！ </p>
		<p class="title-sm title-c cis3-darker">客服中心</p>
		<p>
			若您有任何問題，可與本公司客服中心聯絡：
			<br> E-Mail： mis2@buyersline.com.tw
		</p>

	<?php elseif($this->data['layoutv2_sections_select'] == '16'):?>

		<a class="btn btn-warning" href=" ">列印訂單</a>

	<?php elseif($this->data['layoutv2_sections_select'] == '17'):?>
		<?php // 這裡跟layoutv2_sections_select == 4很類似?>

		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>

		<?php $total = $tmp['orderform']['total']?>

		<p class="title-sm"></p>
		<p>合計：$<?php echo $tmp['orderform']['sum']?></p>
		<p>運費：$<?php echo $tmp['orderform']['shipment']?></p>

		<?php if(0):?>
			<p>折扣：-$80</p>
		<?php endif?>

		<p>總計：<span class="cis2"><b>NTD.<?php echo $tmp['orderform']['total']?></b></span></p>
    
	<?php endif?>
<?php endif?>

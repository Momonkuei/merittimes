<section class="Bbox_1c">
	<div>
		<div class="proInquiry">

			<?php //if(isset($data[$ID]) and count($data[$ID]) > 0):?>
				<section class="itemList">
					<div class="hrTitle"><span>PRODUCT LIST</span></div>
					<div l="layer" ls="lll">
						<?php // newslist item start ------ ?>
						<div class="item" l="list">
							<div>
								<a href="{/url1/}">
									<div class="itemImg"> <img src="{/pic/}"> </div>
								</a>
							</div>
							<div class="itemContent">	
								<div class="itemTitle"> 
									<span>{/name/}</span>
								</div>
								<div class="itemInfo" data-txtlen="80"> 
									{/name2/}
								</div>
								<div class="Bbox_flexBetween">
									<form>
										<?php if(1):// 要／不要數量?>
										<div class="numSet">
											<span><?php echo t('數量：','tw')?></span>
											<button class="minus">-</button><input type="text" id="amount--{/amount_inquiry_id/}" class="amount" value="{/amount/}"><button class="add">+</button>
										</div>
										<?php endif?>
									</form>
									<a href="{/url2/}" class="icon-link"><i class="fa fa-trash-o" aria-hidden="true"></i><span><?php echo t('刪除','tw')?></span></a>
								</div>
							</div>
						</div>
						<?php // newslist item end ------ ?>
					</div>
					<div>
						<a class="btn-prev" href="javascript:history.back();"><i class="fa fa-reply"></i><?php echo t('BACK','en')?></a>
					</div>
				</section>
			<?php //endif?>

			<?php //if(isset($data[$ID]) and count($data[$ID]) > 0):?>
				<section>
					<div class="hrTitle"><span>INQUIRY FORM</span></div>

					<?php //include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
					<form class="form_start">

						<p class="blockInfoTxt">
							<?php echo t('如果您對我們的產品有任何問題，歡迎透過諮詢表單與我們聯絡。')?><label class="must"><?php echo t('為必填')?></label>
						</p>
						<div class="Bbox_in_2c">
							<div>
								<div class="formItem">
									<label class="must" t="* tw ucfirst">姓名</label>
									<input type="text" id="name" name="name" placeholder="<?php echo t('請輸入姓名')?>" value="<?php echo $save['name']?>" />
								</div>
								<div class="formItem">
									<label t="* tw ucfirst">性別</label>
									<div class="radio">
										<label><input type="radio" name="gender" t="value tw ucfirst" value="男" />  <span t="* tw ucfirst">男</span> </label>
										<label><input type="radio" name="gender" t="value tw ucfirst" value="女" />  <span t="* tw ucfirst">女</span> </label>
									</div>
								</div>
								<div class="formItem">
									<label class="must" t="* tw ucfirst">公司名稱</label>
									<input type="text" id="company_name" name="company_name" placeholder="" value="<?php echo $save['company_name']?>" />
								</div>
								<div class="formItem">
									<label t="* tw ucfirst">傳真</label>
									<input type="text" id="fax" name="fax" placeholder="" value="<?php echo $save['fax']?>" />
								</div>
								<div class="formItem">
									<label class="must" t="* tw ucfirst">電話</label>
									<input type="text" id="phone" name="phone" placeholder="" value="<?php echo $save['phone']?>" />
								</div>
								<div class="formItem">
									<label t="* tw ucfirst">分機</label>
									<input type="text" id="exten" name="exten" placeholder="" value="<?php echo $save['exten']?>" />
								</div>
							</div>
						</div>
						<div class="Bbox_in_1c">
							<div>
								
								<div class="formItem">
									<label class="must">E-Mail</label>
									<input type="email" id="email" name="email" placeholder="" value="<?php echo $save['email']?>" />
								</div>
								<div class="formItem oneLine">
									<label t="* tw ucfirst">地址</label>
									<span id="twzipcode"></span>
								</div>
								<div class="formItem">
									<input type="text" name="addr" placeholder="<?php echo t('地址')?>" value="<?php // echo $save['addr'] // 2020-02-10 因為後台沒有addr欄位，所以這裡要註解?>" />
								</div>

								<div class="formItem">
									<label class="must" t="* tw ucfirst">意見</label>
									<textarea id="detail" name="detail" ><?php echo $save['detail']?></textarea>
								</div>

								<div class="formItem oneLine">
									<label class="must" t="* tw ucfirst">認證碼</label>
									<input type="text" id="captcha" name="captcha" /><img id="valImageId" src="captcha.php" width="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新驗證碼</span></a>
								</div>
							
							</div>
						</div>

						<div>							
							<button><i class="fa fa-paper-plane"></i><?php echo t('SEND','en')?></button>	
						</div>							
					</form>
				</section>
			<?php //endif?>
			

		</div>
	</div>
</section>	

<script type="text/javascript" m="body_end">

	<?php if($this->data['ml_key'] == 'tw'):?>
		$('#twzipcode').twzipcode();
	<?php endif?>

	$(document).ready(function() {
		function numCal(calType,nowVal){          

			if(calType=="-"){
				var newVal=parseInt(nowVal)-1;
				newVal=(newVal<=0)?1:newVal;
			}
			if(calType=="+"){
				var newVal=parseInt(nowVal)+1;
			}

			return newVal;
		}

		$('.amount').change(function(){
			var ids_tmp = $(this).attr('id');
			var ids = ids_tmp.split('--');
			$.ajax({
				type: "POST",
				data: {
					'id': 'productinquiry',
					'primary_key': ids[1],
					'amount': $(this).val()
				},
				url: 'save.php',
				success: function(response){
					//alert(response);
					eval(response);
				}
			}); // ajax
		});

		$(".numSet .minus").click(function(){
			var nowVal=$(this).siblings("input").val();
			$(this).siblings("input").val(numCal("-",nowVal));
			$(this).parent().find('input').change();
			//$('.amount').change();
			return false;
		});
		$(".numSet .add").click(function(){
			var nowVal=$(this).siblings("input").val();
			$(this).siblings("input").val(numCal("+",nowVal));
			$(this).parent().find('input').change();
			//$('.amount').change();
			return false;
		});

	});
</script>	

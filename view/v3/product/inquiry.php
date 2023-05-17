<!-- // DATA_MULTI -->
	<?php // $${CONNECT_A} = $ID // 因為下一個區塊會用到?>
	<?php $rows_id = $ID?>
	<?php $rows = $data[$ID]?>

<!-- // DATA_SINGLE -->
	<?php // $${CONNECT_B} = $ID // 因為下一個區塊會用到?>
	<?php $row_id = $ID?>
	<?php $row = $data[$ID]?>


<section class="Bbox_1c">
	<div>
		<div class="proInquiry">

			<?php //$/${CONNECT_A} = $ID // 因為下一個區塊會用到?>

			<?php if(isset($rows)):?>
				<section class="itemList">
					<div class="hrTitle"><span>PRODUCT LIST</span></div>
					<div>
						<?php foreach($rows as $k => $v):?>
							<?php // newslist item start ------ ?>
							<div class="item">
								<div>
									<a href="<?php echo $v['url1']?>">
										<div class="itemImg"> <img src="<?php echo $v['pic']?>"> </div>
									</a>
								</div>
								<div class="itemContent">	
									<div class="itemTitle"> 
										<span><?php echo $v['name']?></span>
									</div>
									<div class="itemInfo" data-txtlen="80"> 
										<?php echo $v['name2']?>
									</div>
									<div class="Bbox_flexBetween">
<?php if(0):?>
										<div><span>數量：</span><input type="number" id="<?php echo $this->data['router_method'].'_'.$rows_id?>_amount--<?php echo $v['id']?>" class="itemNum <?php echo $this->data['router_method'].'_'.$rows_id?>_amount" value="<?php echo $v['amount']?>" /></div>
<?php endif?>
										<form>
											<?php if(1):// 要／不要數量?>
											<div class="numSet">
												<span><?php echo t('數量')?>：</span>
												<button class="minus">-</button><input type="text" id="<?php echo $this->data['router_method'].'_'.$rows_id?>_amount--<?php echo str_replace('inquiry','',$this->data['router_method']).'___'.$v['id']?>" class="<?php echo $this->data['router_method'].'_'.$rows_id?>_amount" value="<?php echo $v['amount']?>"><button class="add">+</button>
											</div>
											<?php endif?>
										</form>
										<a href="<?php echo $v['url2']?>" class="icon-link"><i class="fa fa-trash-o" aria-hidden="true"></i><span t="* * ucfirst">刪除</span></a>
									</div>
								</div>
							</div>
							<?php // newslist item end ------ ?>
						<?php endforeach?>
					</div>
					<div>
						<a class="btn-prev" href="javascript:history.back();"><i class="fa fa-reply"></i><?php echo t('BACK','en')?></a>
					</div>
				</section>
			<?php endif?>

			<?php if(isset($rows) and count($rows) > 0):?>
				<section>
					<div class="hrTitle"><span>INQUIRY FORM</span></div>

					<?php // $/${CONNECT_B} = $ID // 因為下一個區塊會用到?>

					<form action="" method="post" name="memberForm" id="form_data_<?php echo $this->data['router_method'].'_'.$row_id?>" onsubmit="MM_validateForm('<?php echo t('姓名')?>','','R','<?php echo t('E-Mail','en')?>','','RisEmail','<?php echo t('電話')?>','', 'R', '<?php echo t('公司名稱')?>', '', 'R', '<?php echo t('意見')?>', '', 'R', '<?php echo t('認證碼')?>', '', 'R', this); return document.MM_returnValue;" target="hidFrame" >

						<iframe name="hidFrame" style="display:none"></iframe>

						<p class="blockInfoTxt">
							<?php echo t('如果您對我們的產品有任何問題，歡迎透過諮詢表單與我們聯絡。')?><label class="must"><?php echo t('為必填')?></label>
						</p>
						<div class="Bbox_in_2c">
							<div>
								<div class="formItem">
									<label class="must" t="* * ucfirst">姓名</label>
									<input type="text" id="<?php echo t('姓名')?>" name="name" placeholder="<?php echo t('請輸入姓名')?>" value="<?php if(isset($row['name'])):?><?php echo $row['name']?><?php endif?>" />
								</div>
								<div class="formItem">
									<label t="* * ucfirst">性別</label>
									<div class="radio">
										<label><input type="radio" name="gender" value="1" <?php if(isset($row['gender']) and $row['gender'] == '1'):?> checked="checked" <?php endif?> />  <span t="* * ucfirst">男</span> </label>
										<label><input type="radio" name="gender" value="2" <?php if(isset($row['gender']) and $row['gender'] == '2'):?> checked="checked" <?php endif?> />  <span t="* * ucfirst">女</span> </label>
									</div>
								</div>
								<div class="formItem">
									<label class="must" t="* * ucfirst">公司名稱</label>
									<input type="text" id="<?php echo t('公司名稱')?>" name="company_name" placeholder="" value="<?php if(isset($row['company_name'])):?><?php echo $row['company_name']?><?php endif?>" />
								</div>
								<div class="formItem">
									<label t="* * ucfirst">傳真</label>
									<input type="text" name="fax" placeholder="" value="<?php if(isset($row['fax'])):?><?php echo $row['fax']?><?php endif?>" />
								</div>
								<div class="formItem">
									<label class="must" t="* * ucfirst">電話</label>
									<input type="text" id="<?php echo t('電話')?>" name="phone" placeholder="" value="<?php if(isset($row['phone'])):?><?php echo $row['phone']?><?php endif?>" />
								</div>
								<div class="formItem">
									<label t="* * ucfirst">分機</label>
									<input type="text" name="exten" placeholder="" value="<?php if(isset($row['exten'])):?><?php echo $row['exten']?><?php endif?>" />
								</div>
							</div>
						</div>
						<div class="Bbox_in_1c">
							<div>
								
								<div class="formItem">
									<label class="must"><?php echo t('E-Mail')?></label>
									<input type="email" id="<?php echo t('E-Mail')?>" name="email" placeholder="" value="<?php if(isset($row['email'])):?><?php echo $row['email']?><?php endif?>" />
								</div>
								<div class="formItem oneLine">
									<label t="* * ucfirst">地址</label>
									<span id="twzipcode"></span>
								</div>
								<div class="formItem">
									<input type="text" name="addr" placeholder="<?php echo t('地址')?>" value="<?php if(isset($row['addr'])):?><?php echo $row['addr']?><?php endif?>" />
								</div>

								<div class="formItem">
									<label class="must" t="* * ucfirst">意見</label>
									<textarea id="<?php echo t('意見')?>" name="detail" ><?php if(isset($row['detail'])):?><?php echo $row['detail']?><?php endif?></textarea>
								</div>

								<div class="formItem oneLine">
									<label class="must" t="* * ucfirst">認證碼</label>
									<input type="text" id="<?php echo t('認證碼')?>" name="captcha" /><img id="valImageId" src="captcha.php" width="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* * ucfirst">更新驗證碼</span></a>
								</div>
							
							</div>
						</div>

						<div>							
							<button><i class="fa fa-paper-plane"></i><?php echo t('SEND','en')?></button>	
						</div>							
					</form>
				</section>
			<?php endif?>
			

		</div>
	</div>
</section>	

<?php if(0):?><!-- head_end -->
<script type="text/javascript">
var msgErrorTip1 = '<?php echo t('請輸入要搜尋的關鍵字。')?>';
var msgErrorTip2 = '<?php echo t('請輸入')?>「%s」';
var msgErrorTip3 = '<?php echo t('E-Mail','en')?>，<?php echo t('請輸入正確的Email格式')?>';
var msgProcess = '<?php echo t('處理中')?>...';
</script>
<script src="js_common/confirm_form.js"></script>
<?php endif?><!-- head_end -->

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

		var cid = '<?php echo $rows_id?>';
		$('.<?php echo $this->data['router_method'].'_'?>' + cid + '_amount').change(function(){
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
			//$('#amount').change();
			return false;
		});
		$(".numSet .add").click(function(){
			var nowVal=$(this).siblings("input").val();
			$(this).siblings("input").val(numCal("+",nowVal));
			$(this).parent().find('input').change();
			//$('#amount').change();
			return false;
		});

		<?php if(isset($row_id)):?>
			var cid = '<?php echo $row_id?>';
			$('#form_data_<?php echo $this->data['router_method'].'_'?>' + cid + ' input').change(function(){
				<?php // http://stackoverflow.com/questions/13833204/how-to-set-a-js-object-property-name-from-a-variable?>
				var jsonvariable = {};
				jsonvariable['id'] = cid;
				jsonvariable[$(this).attr('name')] = $(this).val();

				$.ajax({
					type: "POST",
					data: jsonvariable,
					url: 'save.php',
					success: function(response){
						//eval(response);
					}
				}); // ajax
			});
			$('#form_data_<?php echo $this->data['router_method'].'_'?>' + cid + ' textarea').change(function(){
				<?php // http://stackoverflow.com/questions/13833204/how-to-set-a-js-object-property-name-from-a-variable?>
				var jsonvariable = {};
				jsonvariable['id'] = cid;
				<?php // http://stackoverflow.com/questions/19241272/save-textarea-value-to-json?>
				var newtext = $(this).val();
				newText = newtext.replace(/\r?\n/g, '<br />');
				jsonvariable[$(this).attr('name')] = newText;

				$.ajax({
					type: "POST",
					data: jsonvariable,
					url: 'save.php',
					success: function(response){
						//eval(response);
					}
				}); // ajax
			});
		<?php endif?>
	});
</script>	

<?php if(0):?><!-- body_end -->
<script src="js_common/reload.js"></script>

<script type="text/javascript">
$("input[name=phone],input[name=fax],input[name=exten]").keydown(function (e) {
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
</script>
<?php endif?><!-- body_end -->

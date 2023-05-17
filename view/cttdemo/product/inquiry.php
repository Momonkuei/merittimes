<!-- // DATA_MULTI -->
<?php $rows = $data[$ID]?>
<?php $rows_id = $ID?>
<?php $${CONNECT_A} = $ID // 因為下一個區塊會用到?>

<!-- // DATA_SINGLE -->
<?php $row = $data[$ID]?>
<?php $row_id = $ID?>
<?php $${CONNECT_B} = $ID // 因為下一個區塊會用到?>

<?php if(isset($rows) and count($rows) > 0):?>
<table border="0" cellpadding="0" cellspacing="0" id="down">
	<tr>
		<th width="120">產品名稱</th>
        <th></th>
		<th width="100">數量</th>
		<th width="150">刪除</th>
	</tr>
	<?php foreach($rows as $k => $v):?>
	<tr>
		<td>
        <div class="news_listpic"><a href="<?php echo $v['url1']?>"><img src="<?php echo $v['pic']?>" width="100" border="0"/></a></div></td>
        <td><div class="Prd_Name"><?php echo $v['name']?></div><div class="Prd_Photo"><div><a href="<?php echo $v['url1']?>"><img src="<?php echo $v['pic']?>" border="0"></a></div></div></td>
		<td align="center">
			<input type="text" class="qtyFld <?php echo $this->data['router_method'].'_'.$rows_id?>_amount" id="<?php echo $this->data['router_method'].'_'.$rows_id?>_amount--<?php echo $v['id']?>" size='10' maxlength='' value="<?php echo $v['amount']?>" />
		<td align="center">
        <a href="<?php echo $v['url2']?>">
        <img src="ctt/images/temp_a/ico_del.png" / border="0"></a></td>
	</tr>
	<?php endforeach?>
</table>
<br />
<?php endif?>

<?php if(0):?>
<div id="inq_bt">
	<a href="product.php" onclick="return checkChange(this);"><img src="ctt/images/temp_a/bt_back_list.png" hspace="5"  border="0"/></a>
	<input type="image" src="ctt/images/temp_a/bt_refresh.png" hspace="5" border="0" />
	<a href="inquiry02.php" onclick="return checkChange(this);"><img src="ctt/images/temp_a/bt_inquiry.png" hspace="5" border="0" /></a>
</div>
<?php endif?>

<?php if(isset($rows) and count($rows) > 0):?>
<form action="" method="post" name="memberForm" id="form_data_<?php echo $this->data['router_method'].'_'.$row_id?>" onsubmit="MM_validateForm(l.get('姓名'),'','R',l.get('E-Mail'),'','RisEmail',l.get('電話'),'', 'R', l.get('公司名稱'), '', 'R', l.get('意見'), '', 'R', l.get('驗證碼'), '', 'R', this); return document.MM_returnValue;" target="hidFrame" >
	<iframe name="hidFrame" style="display:none"></iframe>
	<table border="0" cellpadding="0" cellspacing="0" id="ctt_form">
		<tr>
			<th><span>*</span><?php echo G::t(null,'姓名')?>:</th>
			<td><label><input name="name" type="text" id="<?php echo G::t(null,'姓名')?>" /></label></td>
		</tr>
		<tr>
			<th><span>*</span><?php echo G::t(null,'公司名稱')?>:</th>
			<td><label><input name="company_name" type="text" id="<?php echo G::t(null,'公司名稱')?>" /></label></td>
		</tr>
		<tr>
			<th><?php echo G::t(null,'傳真')?>:</th>
			<td><label><input name="fax" type="text" id="<?php echo G::t(null,'傳真')?>" /></label></td>
		</tr>
		<tr>
			<th><span>*</span><?php echo G::t(null,'電話')?>:</th>
			<td><label><input name="phone" type="text" id="<?php echo G::t(null,'電話')?>" /></label></td>
		</tr>
		<tr>
			<th><?php echo G::t(null,'分機')?>:</th>
			<td><label><input name="exten" type="text" id="<?php echo G::t(null,'分機')?>" /></label></td>
		</tr>
		<tr>
			<th><span>*</span><?php echo G::t(null,'E-Mail')?>:</th>
			<td><label><input name="email" type="text" id="<?php echo G::t(null,'E-Mail')?>" /></label></td>
		</tr>
		<tr>
			<th><?php echo G::t(null,'地址')?>:</th>
			<td><label><input name="addr" type="text" id="<?php echo G::t(null,'地址')?>" /></label></td>
		</tr>
		<tr>
			<th><span>*</span><?php echo G::t(null,'意見')?>:</th>
			<td><textarea name="detail" cols="50" rows="8" id="<?php echo G::t(null,'意見')?>"></textarea></td>
		</tr>
		<tr>
			<th><div align="right"><span class="c_orang">*</span> <?php echo G::t(null,'認證碼')?>：</div></th>
			<td><input type="text" id="<?php echo G::t(null,'驗證碼')?>" name="captcha" /><img id="valImageId" src="captcha.php" width="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo G::t(null,'更新驗證碼')?></a></td>
		</tr>
	</table>
	<div class="back">
	<input onmouseover="MM_swapImage('Image21','','ctt/images/temp_a/bt_send.png',1)" onmouseout="MM_swapImgRestore()" border="0"  src="ctt/images/temp_a/bt_send.png" type="image" name="Image21" />
	</div>
</form>
<?php endif?>

<?php if(0):?><!-- head_end -->
<script type="text/javascript">
var msgErrorTip1 = '請輸入要搜尋的關鍵字。';
var msgErrorTip2 = '<?php echo G::t(null,'請輸入')?>「%s」';
var msgErrorTip3 = '<?php echo G::t(null,'E-Mail')?>，請輸入正確的Email格式';
var msgProcess = '處理中...';
</script>
<script src="js/confirm_form.js"></script>
<?php endif?><!-- head_end -->


<?php if(0):?><!-- body_end -->
<?php if(0 and $this->data['ml_key'] == 'tw'):?>
<script src="js/twzipcode/jquery.twzipcode-1.7.8.min.js"></script>
<?php endif?>
<script type="text/javascript">
	<?php if(0 and $this->data['ml_key'] == 'tw'):?>
		$('#twzipcode').twzipcode();
	<?php endif?>
	$(document).ready(function() {
		// function numCal(calType,nowVal){          

		// 	if(calType=="-"){
		// 		var newVal=parseInt(nowVal)-1;
		// 		newVal=(newVal<=0)?1:newVal;
		// 	}
		// 	if(calType=="+"){
		// 		var newVal=parseInt(nowVal)+1;
		// 	}

		// 	return newVal;
		// }

		var cid = '<?php echo $${CONNECT_A}?>';
		$('.<?php echo $this->data['router_method'].'_'?>' + cid + '_amount').change(function(){
			var ids_tmp = $(this).attr('id');
			var ids = ids_tmp.split('--');
			//alert(ids);
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

		<?php if(isset($${CONNECT_B})):?>
			var cid = '<?php echo $${CONNECT_B}?>';
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
<script src="js/reload.js"></script>
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

<script type="text/javascript">
</script>
<?php endif?><!-- body_end -->

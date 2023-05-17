<section class="block">
	<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('姓名')?>','','R','<?php echo t('電話')?>','', 'R', '<?php echo t('公司名稱')?>', '', 'R', '<?php echo t('意見')?>', '', 'R', this); return document.MM_returnValue;">
		<div class="blockTitle"><span><?php echo t('新增地址')?></span></div>
		<p class="blockInfoTxt">					
			xxxxxxxxxxx至多三筆，<label class="must"><?php echo t('為必填')?></label>
		</p>	

<!-- // DATA2:SINGLE -->
		<input type="hidden" name="id" value="<?php echo $data[$ID]['id']?>" />
		<input type="hidden" name="func" value="<?php echo $data[$ID]['func']?>" />

		<div class="Bbox_in_2c">
			<div>
				<div class="formItem">
					<label class="must"><?php echo t('姓名')?></label>
					<input type="text" id="<?php echo t('姓名')?>" name="name" value="<?php echo $data[$ID]['name']?>" placeholder="">
				</div>
				<div class="formItem">
					<label><?php echo t('性別')?></label>
					<div class="radio">
						<label> <input type="radio" name="gender" id="" value="1" <?php if(isset($data[$ID]['gender']) and $data[$ID]['gender'] == '1'):?> checked="checked" <?php endif?> > <span><?php echo t('男')?></span> </label>
						<label> <input type="radio" name="gender" id="" value="2" <?php if(isset($data[$ID]['gender']) and $data[$ID]['gender'] == '2'):?> checked="checked" <?php endif?> > <span><?php echo t('女')?></span> </label>
					</div>
				</div>

				<div class="formItem">
					<label class="must"><?php echo t('電話')?></label>
					<input type="tel" id="<?php echo t('電話')?>" name="phone" value="<?php echo $data[$ID]['phone']?>">
				</div>


				<div class="formItem">
					<label><?php echo t('備用電話')?></label>
					<input type="tel" id="<?php echo t('備用電話')?>" name="mobile" value="<?php echo $data[$ID]['mobile']?>">
				</div>

			</div>
		</div>
		<div class="formItem oneLine">
			<label class="must"><?php echo t('地址')?></label>
			<span class="twzipcode"></span>
			<input type="text" class="autoFull" id="<?php echo t('地址')?>" name="addr" value="<?php echo $data[$ID]['addr']?>" />
		</div>
		<div class="">
			<button><?php echo t('送出')?></button>
		</div>

	</form>
</section>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$(function(){
	if(typeof ml_key == 'undefined' || ml_key == 'tw'){
		$('.twzipcode').twzipcode({
			countyName: 'addr_county',
			districtName: 'addr_district',
			zipcodeName: 'addr_zipcode'


<?php
	$tmp = array();
	if(isset($layoutv3_struct_map_keyname['v3/member/customer_address'][0]) and isset($data2[$layoutv3_struct_map_keyname['v3/member/customer_address'][0]]['single'][0])){
		$tmp = $data2[$layoutv3_struct_map_keyname['v3/member/customer_address'][0]]['single'][0];
	}
	if(isset($tmp['addr_county']) and $tmp['addr_county'] != ''){
		echo ',countySel: \''.$tmp['addr_county'].'\',districtSel: \''.$tmp['addr_district'].'\'';
	}
?>

		});
	}
});
</script>
<?php endif?><!-- body_end -->

<!-- // DATA2:MULTI -->
<?php if(isset($data[$ID]) and !empty($data[$ID])):?>
	<div class="hrTitle"><span><?php echo t('地址簿')?></span></div>
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
			<?php // for ($i=1; $i <= 3; $i++) {?>
			<?php foreach($data[$ID] as $k => $v):?>
			<tr>
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
	</section>
<?php endif?>

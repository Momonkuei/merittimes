<div class="member_center">

  <section class="sectionBlock">
	<div class="container">

	  <?php //include('memberCenter_title.php'); ?>
<?php echo $__?>
	  <div class="formLine"></div>

	  <div class="innerBlock_small">
		<div class="blockTitle">
		  <span>新增地址</span>
		</div>
		<p>最多三筆</p>
		<form class="row cont_form" action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('姓名')?>','','R','<?php echo t('電話')?>','', 'R', '<?php echo t('公司名稱')?>', '', 'R', '<?php echo t('意見')?>', '', 'R', this); return document.MM_returnValue;">

<!-- // DATA2:SINGLE -->
		  <input type="hidden" name="id" value="<?php echo $data[$ID]['id']?>" />
		  <input type="hidden" name="func" value="<?php echo $data[$ID]['func']?>" />

		  <div class="form_group col-lg-6">
			<label class="must"><?php echo t('姓名')?></label>
			<input type="text" id="<?php echo t('姓名')?>" name="name" value="<?php echo $data[$ID]['name']?>" placeholder="">
		  </div>
          <div class="form_group col-lg-6">
		    <label><?php echo t('性別')?></label>
		    <select name="gender">
		     <option value="0" <?php if(isset($data[$ID]['gender']) && $data[$ID]['gender']==0){ echo 'selected';}?> ><?php echo t('請選擇')?></option>
			 <option value="1" <?php if(isset($data[$ID]['gender']) && $data[$ID]['gender']==1){ echo 'selected';}?> ><?php echo t('男')?></option>
			 <option value="2" <?php if(isset($data[$ID]['gender']) && $data[$ID]['gender']==2){ echo 'selected';}?> ><?php echo t('女')?></option>
		    </select>
          </div>
		  <div class="form_group col-lg-6">
			<label class="must"><?php echo t('電話')?></label>
			<input type="tel" id="<?php echo t('電話')?>" name="phone" value="<?php echo $data[$ID]['phone']?>">
		  </div>
		  <div class="form_group col-lg-6">
			<label><?php echo t('備用電話')?></label>
			<input type="tel" id="<?php echo t('備用電話')?>" name="mobile" value="<?php echo $data[$ID]['mobile']?>">
		  </div>
		  <div class="form_group col-lg-12">
			<label class="must"><?php echo t('地址')?></label>
			<span class="twzipcode"></span>
			<input type="text" class="autoFull" id="<?php echo t('地址')?>" name="addr" value="<?php echo $data[$ID]['addr']?>" />
		  </div>
		  <div class="form_group col-lg-12">
			<button class="btn-cis1"><i class="fa fa-paper-plane" aria-hidden="true"></i>送出</button>
		  </div>
		</form><!-- .cont_form -->
	  </div><!-- .innerBlock_small -->

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
	  <div class="innerBlock_small">
		<div class="blockTitle">
		  <span>收件地址簿</span>
		</div>
		<div class="responsive_tbl">
		  <table class="tableList">
			<thead>
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
			</thead>
			<tbody>
				<?php foreach($data[$ID] as $k => $v):?>
					<tr>
						<td><?php echo $v['name']?></td>
						<td><?php if($v['gender'] == '1'):?><?php echo t('先生')?><?php else:?><?php echo t('小姐')?><?php endif?></td>
						<td><?php echo $v['addr_zipcode']?></td>
						<td><?php echo $v['addr_county']?></td>
						<td><?php echo $v['addr_district']?></td>
						<td><?php echo $v['addr']?></td>
						<td><a href="membercustomeraddress_<?php echo $this->data['ml_key']?>.php?id=<?php echo $v['id']?>"><i class="fa fa-pencil"></i><?php echo t('修改')?></a></td>
						<td><a href="membercustomeraddress_<?php echo $this->data['ml_key']?>.php?del=<?php echo $v['id']?>" onclick="return confirm('<?php echo t('你確定要刪掉這筆資料？')?>')" class="delAddr" data-target="<?php echo $k?>"><i class="fa fa-trash"></i><?php echo t('刪除')?></a></td>
					</tr>				
				<?php endforeach?>
			</tbody>
		  </table>
		</div><!-- .responsive_tbl -->
	  </div><!-- .innerBlock_small -->

	</div><!-- .container -->
  </section><!-- .sectionBlock -->
  <?php endif?>

</div><!-- .member_center -->

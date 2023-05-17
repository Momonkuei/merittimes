	<div class="innerBlock_small">
	  <div class="blockTitle">
		<span>Product List</span>
	  </div>
	  <div class="proInquiry" l="layer" ls="lll">
		<?php //for ($i=0; $i < 3; $i++) {?>
		<div class="proInquiry_item" l="list">
		  <div>
			<a href="{/url1/}">
			  <div class="<?php echo $data['image_ratio'];//變數在source/core.php?>  img-rectangle square itemImgHover hoverEffect1">
				<img src="{/pic/}" alt="">
			  </div>
			</a>
		  </div>
		  <div>
			<div class="subBlock_item">
			  <div class="subBlockTitle">{/name/}</div>
				<?php if(0):?>
			  <p class="subBlockTxt">商品分類1</p>
				<?php endif?>
			</div>
			<?php if(1):// 要／不要數量?>
				<div class="prod_num">
				  <p><?php echo t('數量：','tw')?></p>
					<form>
					  <div class="number-spinner">
						<span class="ns-btn">
							  <a class="minus" data-dir="dwn"><span class="icon-minus"></span></a>
						</span>
						<input type="text" id="amount--{/amount_inquiry_id/}" class="pl-ns-value amount" value="{/amount/}" maxlength="2">
						<span class="ns-btn">
							  <a class="add" data-dir="up"><span class="icon-plus"></span></a>
						</span>
					  </div>
					</form>
				</div>
			<?php endif?>
		  </div>
		  <div>
			<a href="{/url2/}" class="icon-link"><i class="fa fa-trash-o" aria-hidden="true"></i><?php echo t('刪除','tw')?></a>
		  </div>
		</div>
		<?php //}?>
	  </div><!-- .proInquiry -->
	  <div><a class="btn-cis1" href="javascript:history.back();"><i class="fa fa-reply" aria-hidden="true"></i><?php echo t('BACK','en')?></a></div>
	</div><!-- .innerBlock_small -->

	<div class="innerBlock_small">
	  <div class="blockTitle">
		<span>Inquiry Form</span>
	  </div>
		<p><?php echo t('如果您對我們的產品有任何問題，歡迎透過諮詢表單與我們聯絡。')?><label class="must"><?php echo t('為必填')?></label></p>
	  <?php //include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
	  <form class="form_start">
		<div class="form_group col-lg-6">
		  <label class="must" t="* tw ucfirst">姓名</label>
		  <input type="text" id="name" name="name" placeholder="<?php echo t('請輸入姓名')?>" value="<?php echo $save['name']?>" />
		</div>
		<div class="form_group col-lg-6">
		  <label t="* tw ucfirst">性別</label>
		  <select name="gender">
			<option value=""><?php echo t('選擇性別','tw')?></option>
		    <option t="value tw ucfirst" value="男" ><?php echo t('男','tw')?></option>
		    <option t="value tw ucfirst" value="女" ><?php echo t('女','tw')?></option>
		  </select>
		</div>	    
	    <div class="form_group col-lg-6">
	      <label class="must" t="* tw ucfirst">電話</label>
	      <input type="text" id="phone" name="phone" placeholder="" value="<?php echo $save['phone']?>">
	    </div>	    
	    <div class="form_group col-lg-6">
	      <label class="must">E-Mail</label>
	      <input type="email" id="email" name="email" placeholder="" value="<?php echo $save['email']?>">
	    </div>
	    <div class="form_group col-lg-12">
	      <label t="* tw ucfirst">地址</label>
	      <span class="twzipcode"></span>
	      <input type="text" id="addr" name="addr" placeholder="<?php echo t('地址')?>" value="<?php // echo $save['addr'] // 2020-02-10 因為後台沒有addr欄位，所以這裡要註解?>">
	    </div>
	    <div class="form_group col-lg-12">
	      <label class="must" t="* tw ucfirst">備註</label><?php ////2021-11-29 ming說要改的?>
	      <textarea rows="5" cols="80" id="detail" name="detail"><?php echo $save['detail']?></textarea>
	    </div>
	    <div class="form_group col-lg-12">
	      <label class="must" t="* tw ucfirst">認證碼</label>
	      <div class="authenticateCode">
	      	<input type="text" id="captcha" name="captcha" />
	      	<img id="valImageId" src="captcha.php" width="100" gheight="40" />
	      	<a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
	      </div><!-- .authenticateCode -->
	      <div><button class="btn-cis1"><?php echo t('SEND','en')?></button></div>
	    </div>
	  </form>
	</div><!-- .innerBlock_small -->

<script type="text/javascript" m="body_end">

<?php if($this->data['ml_key'] == 'tw'):?>
$('#twzipcode').twzipcode();
<?php endif?>

$(document).ready(function() {
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
	$(".number-spinner .minus").click(function(){
		var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
		if(nowVal <= 1){
			nowVal = 1;
		}
		$(this).parent().parent().find(".pl-ns-value").val(nowVal);
		$(this).parent().parent().find(".pl-ns-value").change();
		return false;
	});
	$(".number-spinner .add").click(function(){
		var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
		$(this).parent().parent().find(".pl-ns-value").val(nowVal);
		$(this).parent().parent().find(".pl-ns-value").change();
		return false;
	});

});
</script>	

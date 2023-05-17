<div id="sideCart_modal" class="modal">
  <div class="sideCart_content">
    <div class="cartInfo">

<!-- // DATA2:SINGLE -->

      <div class="cartTitle">
		<h3>購物車 (<span><?php echo $data[$ID]['count']?></span>)</h3>
		<h5>TOTAL:<span class="cis1" style="color:yellow"><?php echo $data[$ID]['total']?></span></h5>
      </div>
		<?php if(isset($this->data['admin_id'])):?>
			<div><a class="btn-gray" id="_check_now" href="checkout_<?php echo $this->data['ml_key']?>.php?step=1"><i class="fa fa-shopping-cart" aria-hidden="true"></i>立即結帳</a></div>
		<?php else:?>
			<div><a class="btn-gray" id="_check_now" data-fancybox data-src="#fastLogin_modal" data-options='{"touch" : false}' href="javascript:;"><i class="fa fa-shopping-cart" aria-hidden="true"></i>立即結帳</a></div>
		<?php endif?>
    </div>
    <div class="proInquiry">

<!-- // DATA2:MULTI -->

		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
			  <div class="proInquiry_item">
				<div>
				  <a href="<?php echo $v['item']['url1']?>">
					<div class="itemImg img-rectangle square itemImgHover hoverEffect1">
					  <img src="<?php echo $v['item']['pic']?>" alt="">
					</div>
				  </a>
				</div>
				<div>
				  <div class="subBlock_item">
					<div class="subBlockTitle"><?php echo $v['item']['name']?></div>
					<?php if(isset($v['item']['promotion'])):?>
						<p class="subBlockTxt"><?php echo $v['item']['promotion_name']?></p>
					<?php else:?>
						<div><a href="javascript:;" class="itemSP"></a></div>
					<?php endif?>
					<div>特價：<?php echo $v['item']['price']?></div>
					<div>數量：<?php echo $v['amount']?></div>
				  </div>
				</div>
				<div>
				  <a item_id="<?php echo $k?>" href="javascript:;" class="icon-link delcar"><i class="fa fa-trash-o" aria-hidden="true"></i>刪除</a>
				</div>
			  </div>
			<?php endforeach?>
		<?php endif?>
    </div><!-- .proInquiry -->
  </div><!-- .sideCart_content -->
</div><!-- #memberPrivacy_modal-->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.delcar',function(){
	var thisobj = $(this);
	var item_id = thisobj.attr('item_id');
	$.ajax({
		type: "POST",
		data: {
			'func': 'delcar',
			'id': item_id
		},
		url: 'shop_<?php echo $this->data['ml_key']?>.php',
		success: function(response){
			eval(response);	
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->

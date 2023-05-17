[POS1]
<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
<div class=""><!-- container -->
	<div class="row" style="padding: 20px;">
	  <!-- col-md-12 --><div class="" style="font-size: 14px; font-family: 微軟正黑體; color: #666; line-height: 200%; letter-spacing: 3px;"></div>
      <!-- col-md-12 --><div class="" ><?php echo $this->data['layoutv2'][$this->data['section']['key']]?> </div>
	  </div>

</div>
<?php endif?>


<?php /* //舊的
<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
<div class="container">
	<div class="row" style="padding: 20px;">
	  <div class="col-md-12" style="font-size: 14px; font-family: 微軟正黑體; color: #666; line-height: 200%; letter-spacing: 3px;">
	      <div class="col-md-12" ><?php echo $this->data['layoutv2'][$this->data['section']['key']]?> </div>
	  </div>
	</div>
</div
<?php endif?>
*/?>
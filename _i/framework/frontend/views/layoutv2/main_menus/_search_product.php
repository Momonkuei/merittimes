<li>
<form method="post" action="<?php echo $this->createUrl('site/productsearch')?>" class="form-inline search">
		<div class="input-group input-group-sm">
			<span class="glyphicon glyphicon-search"></span>
			<input type="text" name="keyword" value="<?php if(isset($_SESSION['productsearch_'.$this->data['ml_key']])):?><?php echo $_SESSION['productsearch_'.$this->data['ml_key']]?><?php endif?>" class="form-control  margin_sm_lr">
		</div>
	</form>
</li>
				

<?php if(isset($data[$ID])):?>
	<div class="adBanner">
		<div class="slideBanner">
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="slideItem"><a href="<?php echo $v['url']?>"> <img class="pc" src="<?php echo $v['pic1']?>" width="100%"> <img class="mb" src="<?php echo $v['pic2']?>" width="100%"> </a></div>
			<?php endforeach?>
		</div>
	</div>
<?php endif?>


<?php if(0):?>
<div class="adBanner">
	<div class="slideBanner">	
		<div class="slideItem">
			<a href="#abc">
				<img src="http://fakeimg.pl/800x300/?text=mb&font=lobster" class="mb" width="100%">
				<img src="http://fakeimg.pl/800x300/?text=pc&font=lobster" class="pc" width="100%">
			</a>
		</div>	
		<div class="slideItem">
			<a href="#abc">
				<img src="http://fakeimg.pl/800x300/?text=mb&font=lobster" class="mb" width="100%">
				<img src="http://fakeimg.pl/800x300/?text=pc&font=lobster" class="pc" width="100%">
			</a>
		</div>	
	</div>
</div>
<?php endif?>

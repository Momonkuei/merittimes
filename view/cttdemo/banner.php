<?php if(preg_match('/^index/', basename($_SERVER['REQUEST_URI'],'.php')) or basename($_SERVER['REQUEST_URI'],'.php') == ''):?>
	<div id="banner_area" class="flexslider">
		<ul class="slides">
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="slideItem"></div>
					<li><a href="<?php echo $v['url']?>"><img src="<?php echo $v['pic']?>" alt="<?php echo $v['topic']?>"></a></li>
				<?php endforeach?>
			<?php endif?>
		</ul>
	</div>
<?php else:?>
	<div id="banner">
		<div id="banner"><img src="ctt/images/banner_1.jpg" /></div>
		<?php if(0 and isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<img src="<?php echo $v['pic']?>">
				<?php break // 只有一張圖的位置，所以只取一張?>
			<?php endforeach?>
		<?php endif?>
	</div>
<?php endif?>

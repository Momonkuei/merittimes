<div id="language_modal" class="modal modal_half">
  <div class="pageTitleStyle-1">
    <span>語系</span>
  </div>
	<?php
	include _BASEPATH.'/../source/core/mls.php';
	//$result[$k]['child'] = $tmp;
	?>
	<ul class="listStyle text-center">
		<?php if(!empty($tmp)):?>
			<?php foreach($tmp as $k => $v):?>
				<li>
					<a href="<?php echo $v['url']?>"><?php echo $v['name']?></a>
				</li>
			<?php endforeach?>
		<?php endif?>

		<?php if(0):?>
		<li>
			<a href="index_en.php">English</a>
		</li>
		<li>
			<a href="index_tw.php">繁體中文</a>
		</li>
		<li>
			<a href="index_fr.php">French</a>
		</li>
		<li>
			<a href="index_de.php">German</a>
		</li>
		<?php endif?>

	</ul>
</div><!-- #language_modal-->

<?php // 多國語系?>
<?php if(isset($mls) and count($mls) > 1):?>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span><span class="caret"></span></a>
		<ul class="dropdown-menu">
			<?php foreach($mls as $k => $v):?>
				<?php if($k == $this->data['ml_key']):?>
					<li><a href="change_language.php?lang=<?php echo $k?>">[ <?php echo $v?> ]</a></li>
				<?php else:?>
					<li><a href="change_language.php?lang=<?php echo $k?>"><?php echo $v?></a></li>
				<?php endif?>
			<?php endforeach?>
		</ul>
	</li>
<?php endif?>

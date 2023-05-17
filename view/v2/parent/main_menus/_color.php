<?php if(isset($this->data['colors']) and count($this->data['colors']) > 1):?>
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span><span class="caret"></span></a>
	<ul class="dropdown-menu">
		<?php foreach($this->data['colors'] as $k => $v):?>
			<?php if($v['is_enable'] == 1):?>
				<li><a href="change_color_v2.php?id=<?php echo $v['id']?>">[ <?php echo $v['name']?> ]</a></li>
			<?php else:?>
				<li><a href="change_color_v2.php?id=<?php echo $v['id']?>"><?php echo $v['name']?></a></li>
			<?php endif?>
		<?php endforeach?>

		<?php if(0):?>
		<li><a href="change_color.php?color=brown_coffee">BROWN COFFEE</a></li>
		<li><a href="change_color.php?color=blue_water">BLUE WATER</a></li>
		<li><a href="change_color.php?color=pink_lady">PINK LADY</a></li>
		<?php endif?>
	</ul>
</li>
<?php endif?>

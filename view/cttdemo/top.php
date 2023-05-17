<div id="webcall"><a href="#uptop"><img src="ctt/images/ico_top.png"  border="0" /></a></div>
<div id="top">
<div class="logo"><a href="./"><img src="ctt/images/logo.png" border="0" /></a></div>
<div class="language">
<a href="index.php">HOME</a> / 

<?php if(isset($data[$ID]) and count($data[$ID]) > 0):?>
	<?php $tmps = array()?>
	<?php foreach($data[$ID] as $k => $v):?>
		<?php if($v['func'] == 'language' and isset($v['child']) and count($v['child']) > 0):?>
			<?php foreach($v['child'] as $kk => $vv):?>
				<?php $tmps[] = '<a href="'.$vv['url'].'">'.$vv['name'].'</a>'?>
			<?php endforeach?>
		<?php endif?>
	<?php endforeach?>
	<?php echo implode(' / ', $tmps)?>
<?php endif?>
</div>

<div class="menu_top">
<?php echo $AA?>
<?php // include("top_menu.php"); ?>
</div></div><!-- top -->


<?php if(isset($data[$ID]) and count($data[$ID]) > 0):?>
<div id="move_page"> 
	<?php if($data[$ID]['pagination']['control']['prev'] != ''):?>
		<?php // 2017-07-26 李哥說要改的，他說是Ming說的?>
		<?php $url = $data[$ID]['pagination']['control']['prev']?>
		<?php if(preg_match('/page\=0$/', $url)):?>
			<?php $url = str_replace('?&page=0', '', $url)?>
			<?php $url = str_replace('&page=0', '', $url)?>
			<?php $url = str_replace('?page=0', '', $url)?>
		<?php endif?>
		<a href="<?php echo $url?>"> ◄</a>
	<?php endif?>

	<?php foreach($data[$ID]['pagination']['number'] as $k => $v):?>
		<?php if($v['name'] == $data[$ID]['pagination']['control']['now']):?>
			<span class="onthis"><?php echo $v['name']?></span>
		<?php else:?>
			<?php // 2017-07-26 李哥說要改的，他說是Ming說的?>
			<?php $url = $v['link']?>
			<?php if(preg_match('/page\=0$/', $url)):?>
				<?php $url = str_replace('?&page=0', '', $url)?>
				<?php $url = str_replace('&page=0', '', $url)?>
				<?php $url = str_replace('?page=0', '', $url)?>
			<?php endif?>
			<a href="<?php echo $url?>"><?php echo $v['name']?></a>
			<?php unset($url)?>
		<?php endif?>
	<?php endforeach?>

	<?php if($data[$ID]['pagination']['control']['next'] != ''):?>
		<a href="<?php echo $data[$ID]['pagination']['control']['next']?>"> ►</a>
	<?php endif?>

</div>
<?php endif?>

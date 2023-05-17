<?php $row_inherit_start = $row_inherit_end = '';
include 'view/system/row_inherit.php' ?>

<?php if (isset($data[$ID])) : ?>
	<?php foreach ($data[$ID] as $k => $v) : ?>
		<?php echo $row_inherit_start ?>
		<?php
		//2021-06-24 經理來電說要兩種分享模式通用 by lota
		if (stristr($v['url1'], 'https://youtu.be/')) {
			$v['url1'] = 'https://www.youtube.com/watch?v=' . str_replace('https://youtu.be/', '', $v['url1']);
		}

		//2023/2/2 新增live模式 Gary
		if (stristr($v['url1'], 'https://www.youtube.com/live/')) {
			$tmp = explode('?', $v['url1']);
			// print_r($tmp);
			$v['url1'] = 'https://www.youtube.com/watch?v=' . str_replace('https://www.youtube.com/live/', '', $tmp[0]);
		}
		?>
		<a href="javascript:;" data-url="<?php echo $v['url1'] ?>" title="<?php echo $v['name1'] ?>">
			<div class="<?php echo $data['image_ratio']; //變數在source/core.php
						?>  itemImgHover hoverEffect1 video-revise">
				<img src="<?php echo $v['pic'] ?>">
			</div>
		</a>
		<div class="subBlockTitle"><?php echo $v['name3'] ?></div>
		<?php if (isset($v['day'])) : ?>
			<div class="subBlockTxt">
				<?php if (0) : //20201112開會決定不要日期
				?>
					<div class="dateStyle">
						<i class="fa fa-calendar-o" aria-hidden="true"></i>
						<span class="dateD"><?php echo $v['day'] ?></span>
						<span class="dateM"><?php echo $v['month'] ?></span>
						<span class="dateY"><?php echo $v['year'] ?></span>
					</div>
				<?php endif ?>
			</div>
		<?php endif ?>
		<?php echo $row_inherit_end ?>
	<?php endforeach ?>
<?php endif ?>
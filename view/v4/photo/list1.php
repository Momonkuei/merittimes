<?php $row_inherit_start = $row_inherit_end = '';include 'view/system/row_inherit.php';?>

<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
		<?php echo $row_inherit_start?>
		<a href="<?php echo $v['url1']?>" <?php if(isset($v['anchor_attr1']) and $v['anchor_attr1'] != ''):?><?php echo $v['anchor_attr1']?><?php endif?> >
			<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> img-rectangle itemImgHover hoverEffect1">
				<img src="<?php echo $v['pic']?>">
			</div>
		</a>
		
		<div class="subBlockTitle"><?php echo $v['name']?></div>
			
			<div class="Bbox_flexBetween">
				<?php if(isset($v['day'])):?>	
				<div class="subBlockTxt">
					<div class="dateStyle">
						<i class="fa fa-calendar-o" aria-hidden="true"></i>
						<span class="dateD"><?php echo $v['day']?></span>
						<span class="dateM"><?php echo $v['month']?></span>
						<span class="dateY"><?php echo $v['year']?></span>
					</div>
				</div>
				<?php endif?>
				<?php if(isset($v['count']) && $v['count']!=0):?>
				<div class="subBlockTxt">
					<i class="fa fa-camera" aria-hidden="true"></i><span><?php echo $v['count']?></span>
				</div>
				<?php endif?>
			</div>
		
		<?php echo $row_inherit_end?>
	<?php endforeach?>
<?php endif?>

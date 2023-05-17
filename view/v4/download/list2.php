<div class="row">
<?php $row_inherit_start = $row_inherit_end = '';include 'view/system/row_inherit.php'?>

<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
		<?php //echo $row_inherit_start?>
		<div class="col-md-3 col-sm-6">
		<a 
			<?php if(isset($v['href1']) and $v['href1'] != ''):?> href="<?php echo $v['href1']?>" target="_blank" <?php endif?>
			<?php if(isset($v['anchor1_class']) and $v['anchor1_class'] != ''):?> class="<?php echo $v['anchor1_class']?>" <?php endif?> 
			<?php if(isset($v['anchor1_data_target']) and $v['anchor1_data_target'] != ''):?> data-target="<?php echo $v['anchor1_data_target']?>" <?php endif?> 
		>
			<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> img-rectangle itemImgHover hoverEffect1">
				<img src="<?php echo $v['pic1_']?>"  onerror="javascript:this.src='images_v4/default.png';img.onerror=null;">
			</div>
		</a>
		<div class="subBlockTitle"><?php echo $v['name']?></div>
		<?php if($v['file_size'] != ''):?>
			<p class="subBlockTxt"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>檔案大小  <?php echo $v['file_size']?></p>
			<p class="subBlockTxt"><i class="fa fa-clock-o" aria-hidden="true"></i>最後更新時間  <?php echo $v['update_time']?></p>
			<div>
				<a class="btn-cis1" 
					<?php if(isset($v['href2']) and $v['href2']!=''):?> href="<?php echo $v['href2']?>" target="_blank" <?php endif?>
					<?php if(isset($v['anchor2_class']) and $v['anchor2_class'] != ''):?> class="<?php echo $v['anchor2_class']?>" <?php endif?> 
					<?php if(isset($v['anchor2_data_target']) and $v['anchor2_data_target'] != ''):?> data-target="<?php echo $v['anchor2_data_target']?>" <?php endif?> 
				>
					<i class="fa fa-download" aria-hidden="true"></i><?php echo t('DOWNLOAD','en')?>
				</a>
			</div>
		<?php endif?>
		<?php //echo $row_inherit_end?>
		</div>
	<?php endforeach?>
<?php endif?>
</div>
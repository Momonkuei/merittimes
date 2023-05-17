<?php // 2018-08-09 A方案專用?>
<?php // 根據後台／LayoutV3／資料 的元素(好記的名子)格式命名?>
<?php if(0):?>
	<?php $data[$ID] = $this->data['_category_title']?>
<?php endif?>

<?php if(isset($data[$ID]) and isset($data[$ID]['name']) and $data[$ID]['name'] != ''):?>
<div class="Bbox_view">
	<div>	
		<div>

			<?php if(isset($data[$ID]['day']) or isset($data[$ID]['count'])): // GGG?>
			<div class="Bbox_flexBetween">
			<?php endif?>

				<?php if(isset($data[$ID]['name']) and $data[$ID]['name'] != ''):?>
					<?php 
					// 經理來信說 有開SEO功能才需要
					unset($_constant);
					eval('$_constant = '.strtoupper('seo_open').';');
					if($_constant){
						$_sptxt = 'h1';
					}else{
						$_sptxt = 'div';
					}
					?>
					<<?php echo $_sptxt?> class="blockTitle"><span><?php echo $data[$ID]['name']?></span></<?php echo $_sptxt?>>
				<?php endif?>

				<div class="Bbox_flexBetween">
					<?php if(isset($data[$ID]['day'])):?>
						<div class="dateStyle">
							<i class="fa fa-calendar-o"></i>
							<span class="dateD"><?php echo $data[$ID]['day']?></span>
							<span class="dateM"><?php echo $data[$ID]['month']?></span>
							<span class="dateY"><?php echo $data[$ID]['year']?></span>
						</div>
					<?php endif?>
					<?php if(isset($data[$ID]['count'])):?>
						<div class="itemTotal">
							<i class="fa fa-camera"></i>
							<span><?php echo $data[$ID]['count']?></span>
						</div>
					<?php endif?>
				</div>

			<?php if(isset($data[$ID]['day']) or isset($data[$ID]['count'])): // GGG?>
			</div>
			<?php endif?>

			<?php if(0):// #34327?>
				<div class="blockInfoTxt">
					<?php if(isset($data[$ID]['sub_name']) and $data[$ID]['sub_name'] != ''):?>
						<?php echo $data[$ID]['sub_name']?>
					<?php endif?>				
				</div>
			<?php endif?>

		</div>
	</div>
</div>
<?php endif?>

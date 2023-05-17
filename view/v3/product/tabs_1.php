<?php if( (isset($data[$ID]['content1']) and $data[$ID]['content1']) != '' or (isset($data[$ID]['content2']) and $data[$ID]['content2'] != '') )://#31796?>
<div class="itemContent">
	<div class="tabList tabList_center">
	<!-- 若不要置中，拿掉tabList_center即可 -->								
		<?php if(isset($data[$ID]['content1']) and $data[$ID]['content1']!='')://#31796?>
		<a href="#_" class="tabLabel active"><?php echo t('商品說明')?></a>
		<div class="tabContent">
			<div class="editorBlock">
				<?php echo $data[$ID]['content1']?>
			</div>
		</div>
		<?php endif?>
		<?php if(isset($data[$ID]['content2']) and $data[$ID]['content2']!='')://#31796?>
		<a href="#_" class="tabLabel <?php if(!isset($data[$ID]['content1']) or $data[$ID]['content1']==''):?>active<?php endif?>"><?php echo t('商品規格')?></a>
		<div class="tabContent">
			<div class="editorBlock">
				<?php echo $data[$ID]['content2']?>
			</div>
		</div>
		<?php endif?>

	</div>
</div>
<?php endif?>

				<?php // 顯示欄位名稱，包含排序 ?>
				<?php if(!empty($listfield)): ?>
					<?php foreach($listfield as $k => $v): ?>
					<th width="<?php echo $v['width']?>" <?php if(isset($v['label_comment']) and $v['label_comment'] != ""):?>title="<?php echo $v['label_comment']?>"<?php endif;?> >
<?php if($v['base64'] == $sort_field):?>
	<?php if($sort_direction == 'desc'):?>
		<i class="icon-sort-down"></i>
	<?php else:?>
		<i class="icon-sort-up"></i>
	<?php endif?>
<?php endif?>
<?php if(0):?>
					<label style="width:100%;display:block; <?php if(isset($v['align']) and $v['align'] != ''):?>text-align:<?php echo $v['align']?>;<?php endif?>">
<?php endif?>
					<?php if(isset($v['sort']) and $v['sort'] == true):?><a href="<?php echo $class_url?>&param=<?php echo $parameter['sort'].$v['base64']?><?php if($v['base64'] == $sort_field):?>-<?php echo $parameter['direction'].$next_sort_direction;endif?>"><?php endif?>
<?php G::ae($v, 'v.label')?>
<?php if(isset($v['mlabel'])):?><?php G::te(G::a($v, 'v.mlabel.0'), G::a($v, 'v.mlabel.1'), G::a($v, 'v.mlabel.2'), G::a($v, 'v.mlabel.3'))?><?php endif?>
<?php //{{*如果我點了一個欄位要做排序的動作，這個欄位就會出現上或下的圖示*}}?>
<?php if(isset($v['sort']) and $v['sort'] == true):?>

<?php if(0):?>
	<?php if($v['base64'] == $sort_field):?><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icons/<?php echo $sort_direction?>.png" border="0" alt="" /><?php endif?>
<?php endif?>

<?php if($v['base64'] == $sort_field and 0):?>
	<?php if($sort_direction == 'desc'):?>
		<div class="icondown fle"></div>
	<?php else:?>
		<div class="icontop fle"></div>
	<?php endif?>
<?php endif?>
</a>
<?php endif?>

<?php if(0):?>
					</label>
<?php endif?>
</th>
					<?php endforeach?>
				<?php endif?>

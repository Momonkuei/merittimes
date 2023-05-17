				<?php // 顯示欄位名稱，包含排序 ?>
				<?php if(!empty($listfield)): ?>
					<?php foreach($listfield as $k => $v): ?>
					<th <?php if(isset($v['ezdelete']) and $v['ezdelete'] == true):?>class="table-checkbox"<?php endif?> width="<?php if(isset($v['width'])) {echo $v['width'];}?>" <?php if(isset($v['label_comment']) and $v['label_comment'] != ""):?>title="<?php echo $v['label_comment']?>"<?php endif;?> style=" <?php if(isset($v['align']) and $v['align'] != ''):?>text-align:<?php echo $v['align']?>;<?php endif?>" class=" <?php if($v['base64'] == $sort_field):?><?php if($sort_direction == 'desc'):?>sorting_desc<?php else:?>sorting_asc<?php endif?><?php endif?> <?php if(isset($v['sort']) and $v['sort'] == true and $v['base64'] != $sort_field):?>sorting<?php endif?> " >

						<?php if(isset($v['ezdelete']) and $v['ezdelete'] == true):?>
							<input class="group-checkable" type="checkbox" data-set="#tablelist .checkboxes">
							<?php continue?>
						<?php endif?>
					
					<?php if(isset($v['sort']) and $v['sort'] == true):?><a href="<?php echo $class_url?>&param=<?php echo $parameter['sort'].$v['base64']?><?php if($v['base64'] == $sort_field):?>-<?php echo $parameter['direction'].$next_sort_direction;endif?>"><?php endif?>
<?php //G::ae($v, 'v.label')?>
<?php if(isset($v['label']) and $v['label'] != ''):?>
	<?php if(isset($v['translate_source']) and $v['translate_source'] != ''):?>
		<?php echo G::_($v['label'], $v['translate_source'])?>
	<?php else:?>
		<?php echo $v['label']?>
	<?php endif?>
<?php endif?>
<?php if(isset($v['mlabel'])):?><?php G::te(G::a($v, 'v.mlabel.0'), G::a($v, 'v.mlabel.1'), G::a($v, 'v.mlabel.2'), G::a($v, 'v.mlabel.3'))?><?php endif?>
<?php //{{*如果我點了一個欄位要做排序的動作，這個欄位就會出現上或下的圖示*}}?>
<?php if(isset($v['sort']) and $v['sort'] == true):?>

<?php if($v['base64'] == $sort_field and 0):?>
	<?php if($sort_direction == 'desc'):?>
		<div class="icondown fle"></div>
	<?php else:?>
		<div class="icontop fle"></div>
	<?php endif?>
<?php endif?>
</a>
<?php endif?>

</th>
					<?php endforeach?>
				<?php endif?>

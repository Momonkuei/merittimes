<style type="text/css">
.photos li .dragBar{ cursor:move; }
</style>

<?php
// 上傳多檔圖片區塊(可同時多個使用)

Yii::app()->clientScript->registerCoreScript('fileuploader.multi');
Yii::app()->clientScript->registerCoreScript('sortable');
Yii::app()->clientScript->registerCoreScript('facebox.start');

if($width != ''){
	$a = $width;
} else {
	$a = '200';
}

if($height != ''){
	$b = $height;
} else {
	$b = '200';
}

$image_ext = "['jpg', 'jpeg', 'png', 'gif']";
$document_ext = "['doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'csv', 'wmv', 'mpg', 'mp4', 'avi', 'mov', 'zip', 'pptx', 'ppt', 'pdf', 'rar', 'ai', 'tif', 'tiff', 'igs', 'dxf', 'jpg', 'jpeg', 'png', 'gif', 'stp']";

if($type == 'image'){
	$ext = $image_ext;
} elseif($type == 'document'){
	$ext = $document_ext;
} else {
	// 預設是上傳圖片
	$type = 'image';
	$ext = $image_ext;
}

// 利用存放的資料夾名稱，當做updatecontent的變數名稱，同時也是img smarty的class名稱
$store_dir_name = $def['multifile_upload'][$field]['store_dir_name'];

/* 範例
createuploader_single('{{$router_class}}', 'pic6', '6', 'image');
createuploader_single('{{$router_class}}', 'file1', '7', 'document', '1');
// function createuploader_single(path, field, num, type, image_ext, document_ext, o_image_thumb_tmp_path, o_file_upload_tmp_path, ,o_image_upload_path, a, b, class_url){
 */
//$subfield = $def['updatefield']['sections'][$def['multifile_upload'][$field]['section_id']]['field'][$field]['other'];
$j_subfield = json_encode($subfield);
$upload_pos_load = <<<XXX1
	createuploader_multi('{$class}', '{$field}', '{$number}', '{$type}', {$image_ext}, {$document_ext},'{$image_thumb_tmp_path}', '{$file_upload_tmp_path}', '{$image_upload_path}', '{$a}', '{$b}', '{$class_url}', {$j_subfield});
XXX1;

Yii::app()->clientScript->registerScript('upload_pos_load_fileuploader_multi_'.$field.'_'.$number, $upload_pos_load, CClientScript::POS_LOAD);

?>

<div>
	<?php if($no_ext != '1'):?>
	<p>*指定上傳格式: <?php echo str_replace("'", '', str_replace('[', '', str_replace(']', '', $ext)))?></p>
	<?php endif?>

	<?php if($comment_size != ''):?>
	<p>*建議上傳圖片尺寸(像素): <?php echo $comment_size?></p>
	<?php endif?>

	<div id="file-uploader<?php echo $field?>">
		<noscript>			
			<p>##Please enable JavaScript to use file uploader.##</p>
			<!-- or put a simple form for upload here -->
		</noscript>         
	</div>

	<br />
	
	<ul class="itemList photos" id="fileuploader_collection_<?php echo $field?>">
	<?php if($action == 'update'):?>
		<?php if(!empty($updatecontent[$store_dir_name])):?>
			<?php foreach($updatecontent[$store_dir_name] as $k => $v):?>
				<li id="fileuploader_li_<?php echo $field?>_<?php echo $k?>" class="item fileuploader_li_<?php echo $field?>">
					<input type='hidden' name='uploads[<?php echo $field?>][u<?php echo $k?>]' value='<?php echo $v['pic']?>' />
					<div class="dragBar" id="fileuploader_li_<?php echo $field?>_<?php echo $k?>_dragarea"><span>排序移動</span></div>
					<div><?php echo G::img(array('a'=>$width,'b'=>$height,'c'=>$def['multifile_upload'][$field]['store_dir_name'],'content'=>$v['pic'],'tag'=>'1','thumb'=>'2'))?></div>
					<div class="links"><!-- style2 -->
						<a rel="facebox" href="<?php echo G::img(array('a'=>1000,'b'=>1000,'c'=>$def['multifile_upload'][$field]['store_dir_name'],'content'=>$v['pic'],'tag'=>'3'))?>">[觀看]</a>
						<a class="delete" href="javascript:;" onclick="$(this).parent().parent().remove()">[刪除]</a><br />
						<?php if(!empty($subfield)):?>
							<?php foreach($subfield as $kk => $vv):?>
								<div><!-- style3 -->
									<span><?php echo $vv['label']?></span>
								<span>
								<?php if($vv['type'] == 'text'):?>
									<input type="text" size="10" class="fileuploader_multi_text_<?php echo $field?>_<?php echo $kk?>" name="uploads_attr[<?php echo $field?>][<?php echo $kk?>][u<?php echo $k?>]" value="<?php echo $v[$kk]?>" />
								<?php elseif($vv['type'] == 'radio'):?>
									<?php if(!empty($vv['other'])):?>
										<?php foreach($vv['other'] as $kkk => $vvv):?>
											<?php $x1 = ''?>
											<?php $x2 = ''?>
											<?php if($vvv['value'] == "0"):?>
												<?php $x1 = 'checked'?>
											<?php elseif($vvv['value'] == "1"):?>
												<?php $x2 = 'checked'?>
											<?php endif?>
											<label><input type="radio" name="uploads_attr[<?php echo $field?>][<?php echo $kk?>][u<?php echo $k?>]" value="<?php echo $vvv['value']?>" <?php $this->widget('system.widgets.Gw_abcn', array('list'=>array($x1, $x2), 'v'=>G::a($v, 'v.'.$kk)))?> /><?php echo $vvv['label']?></label>
										<?php endforeach?>
									<?php endif?>
								<?php endif?>
								</span>
								</div>
							<?php endforeach?>
						<?php endif?>
					</div>
				</li>
			<?php endforeach?>
		<?php endif?>
	<?php elseif($action == 'create'):?>
	<?php endif?>
	</ul>
</div>

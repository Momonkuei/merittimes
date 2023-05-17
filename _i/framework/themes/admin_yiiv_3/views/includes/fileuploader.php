<?php
//Yii::app()->clientScript->registerCoreScript('jquery.random');
//Yii::app()->clientScript->registerCoreScript('fileuploader');
Yii::app()->clientScript->registerCoreScript('fileuploader.single');

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

$image_ext = "['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp','dng']";//2020-11-17 經理說要加DNG
$document_ext = "['cad', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'csv', 'wmv', 'mpg', 'mp3','mp4', 'avi', 'mov', 'zip', 'pptx', 'ppt', 'pdf', 'rar', 'ai', 'tif', 'tiff', 'igs', 'dxf', 'jpg', 'jpeg', 'png', 'gif', 'stp','exe','step','iges','webp','dng']";//2020-11-17 經理說要加DNG

if($type == 'image'){
	$ext = $image_ext;
} elseif($type == 'document'){
	$ext = $document_ext;
} else {
	// 預設是上傳圖片
	$type = 'image';
	$ext = $image_ext;
}

if($top_button == ''){
	$top_button = '0';
} else {
	$top_button = '1';
}

/* 範例
createuploader_single('{{$router_class}}', 'pic6', '6', 'image');
createuploader_single('{{$router_class}}', 'file1', '7', 'document', '1');
// function createuploader_single(path, field, num, type, image_ext, document_ext, o_image_thumb_tmp_path, o_file_upload_tmp_path, ,o_image_upload_path, a, b, class_url, top_button, no_need_delete_button){
 */
$upload_pos_load = <<<XXX1
	createuploader_single('{$class}', '{$field}', '{$number}', '{$type}', {$image_ext}, {$document_ext},'{$image_thumb_tmp_path}', '{$file_upload_tmp_path}', '{$image_upload_path}', '{$a}', '{$b}', '{$class_url}', '{$top_button}', '{$no_need_delete_button}');
XXX1;

Yii::app()->clientScript->registerScript('upload_pos_load_fileuploader_single_'.$field.'_'.$number, $upload_pos_load, CClientScript::POS_LOAD);

//班級列表 單純顯示圖片
if($this->data['router_class']=='writeplan_class'){
	$customer_code=$this->cidb->select('code')->where('other6',$updatecontent['id'])->get('customer')->row_array();
	if(!empty($customer_code['code'])){
		$def['pic_upload_path'] = 'class/'.$customer_code['code'];
	}
}
//計畫內頁 顯示檔案
if($this->data['router_class']=='writeplan'){
	$sql="select a.code from customer as a left join writeplan as b on b.id='".$updatecontent['id']."' where a.id=b.member_id";
	$rs=$this->cidb->query($sql);
	$data=$rs->row_array();
	if(!empty($data)){
		$def['file_upload_path'] = 'writeplan/'.$data['code'].'/'.$updatecontent['id'];
	}
	
}
?>

<input type="hidden" id="<?php echo $field?>" name="<?php echo $field?>" value="<?php echo $value?>" />
<input type="hidden" id="<?php echo $field?>___origin" name="<?php echo $field?>___origin" value="" />
<table>
	<tr>
		<td>
			<?php if($top_button == '1'):?>
				<?/*班級列表圖片先不給後台修改*/?>
				<?if($this->data['router_class']!='writeplan_class' && $this->data['router_class']!='writeplan'){?>
					<span class="google-submit" id="fileuploader_top_button_<?php echo $number?>" style="position: relative;"><?php G::te($this->data['theme_lang'], 'Upload', null, '上傳')?></span>
				<?}?>
			<span class="google-submit" id="fileuploader_top_button_delete_<?php echo $number?>" style="position: relative;"><?php G::te($this->data['theme_lang'], 'Delete', null, '刪除')?></span>
			<br />
			<br />
			<?php endif?>
			<?php if($action == 'update'):?>
				<?php if($type == 'image'):?>
					<div style="border:1px outset;padding:2px;">
					<?php if($value == ''):?>
						<?php echo G::img(array('a'=>$a, 'b'=>$b, 'c'=>'_system', 'id'=>'image_'.$field, 'static'=>'1', 'content'=>'image.png'))?>	
					<?php else:?>
						<?php if(isset($def['pic_upload_path']) and $def['pic_upload_path'] != ''):?>
							<?php echo G::img(array('a'=>$a, 'b'=>$b, 'c'=>$def['pic_upload_path'], 'id'=>'image_'.$field, 'content'=>$value))?>	
						<?php else:?>
							<?php echo G::img(array('a'=>$a, 'b'=>$b, 'c'=>$class, 'id'=>'image_'.$field, 'content'=>$value))?>	
						<?php endif?>
					<?php endif?>
					</div>
				<?php elseif($type == 'document'):?>
					<?php echo G::img(array('a'=>$a, 'b'=>$b, 'c'=>'_system', 'id'=>'image_'.$field, 'static'=>'1', 'content'=>'document.png'))?>	
					<?php if(isset($comment_file_size) && $comment_file_size!=''):?>
						<div>*不建議放超過<?php echo $comment_file_size?>以上的檔案</div>
					<?php endif?>
					<?php if($value != ''):?>
						<br />
						<?php if(isset($def['file_upload_path']) and $def['file_upload_path'] != ''):?>
						<a id="fileuploader_document_download__<?php echo $field?>" target="_blank" href="<?php echo $file_upload_path?>/<?php echo $def['file_upload_path']?>/<?php echo $value?>">已上傳檔案預覽</a>
						<?php else:?>
						<a style="color:red;font-size:22pt" <?php // 2020-09-26 Ming下午建議的 ?> id="fileuploader_document_download__<?php echo $field?>" target="_blank" href="<?php echo $file_upload_path?>/<?php echo $class?>/<?php echo $value?>">已上傳檔案預覽</a>
						<?php endif?>
					<?php endif?>
				<?php endif?>
			<?php elseif($action == 'create'):?>
				<?php if($type == 'image'):?>
					<div style="border:1px outset;padding:2px;">
						<?php echo G::img(array('a'=>$a, 'b'=>$b, 'c'=>'_system', 'id'=>'image_'.$field, 'static'=>'0', 'content'=>'image.png'))?>	
					</div>
				<?php elseif($type == 'document'):?>
					<?php echo G::img(array('a'=>$a, 'b'=>$b, 'c'=>'_system', 'id'=>'image_'.$field, 'static'=>'1', 'content'=>'document.png'))?>	
				<?php endif?>
			<?php endif?>

			<?php if($top_button == '1' && $this->data['router_class']!='writeplan_class'):?>
				<?php if($comment != ''):?>
					<?php echo $comment?>
				<?php else:?>
					<?php if($no_ext != '1'):?>
					<p>*指定上傳格式: <?php echo str_replace("'", '', str_replace('[', '', str_replace(']', '', $ext)))?></p>
					<?php endif?>

					<?php if($comment_size != ''):?>
					<p>*建議上傳圖片尺寸(像素): <?php echo $comment_size?> <!-- 約小於10MB --> </p>
					<?php endif?>
				<?php endif?>

				<div id="file-uploader<?php echo $number?>">
					<noscript>			
						<p><?php G::te($this->data['theme_lang'], 'Please enable JavaScript to use file uploader.', null, '請啟用JavaScript來使用這個功能')?></p>
						<!-- or put a simple form for upload here -->
					</noscript>         
				</div>
			<?php endif?>

		</td>
		<td style="width:1px;">&nbsp;</td>
		<td valign="bottom">
			<?php if($top_button == '0'):?>
				<?php if($no_ext != '1'):?>
				<p>*指定上傳格式: <?php echo str_replace("'", '', str_replace('[', '', str_replace(']', '', $ext)))?></p>
				<?php endif?>

				<?php if($comment_size != ''):?>
				<p>*建議上傳圖片尺寸(像素): <?php echo $comment_size?></p>
				<?php endif?>

				<div id="file-uploader<?php echo $number?>">
					<noscript>			
						<p><?php G::te($this->data['theme_lang'], 'Please enable JavaScript to use file uploader.', null, '請啟用JavaScript來使用這個功能')?></p>
						<!-- or put a simple form for upload here -->
					</noscript>         
				</div>
			<?php endif?>
		</td>
	</tr>
</table>

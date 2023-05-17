<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>


	<?php /* 後台的使用方式
	'xx01' => array(
		'label' => '裁圖：',
		'type' => 'image_resize_crop_canvas',
		'other' => array(
			// 工作區
			'work_width' => '901',
			'work_height' => '500',
			// 目標
			'target_width' => '180',
			'target_height' => '190',
			'target_left_percent' => '50',
			'target_top_percent' => '50',
			//'posturl' => 'backend.php?r=company/crop&pic=',
			// 欄位資料來源，pic1欄位裡面存放的例如是e770f8ac8aacd147ee11c37c1b0d0c9a.jpg
			'src_field' => 'pic1',
		),
	),
	 */
	?>
	<?php if(isset($this->data['updatecontent'][$vv['other']['src_field']]) and $this->data['updatecontent'][$vv['other']['src_field']] != ''):?>

		<?php $src_field = $vv['other']['src_field']?>
		<?php $work_width = '901'?>
		<?php $work_height = '500'?>
		<?php $target_width = '200'?>
		<?php $target_height = '200'?>
		<?php $target_left_percent = '50'?>
		<?php $target_top_percent = '50'?>

		<?php if(isset($vv['other']['work_width']) and $vv['other']['work_width'] != ''):?><?php $work_width = $vv['other']['work_width']?><?php endif?>
		<?php if(isset($vv['other']['work_height']) and $vv['other']['work_height'] != ''):?><?php $work_height = $vv['other']['work_height']?><?php endif?>
		<?php if(isset($vv['other']['target_width']) and $vv['other']['target_width'] != ''):?><?php $target_width = $vv['other']['target_width']?><?php endif?>
		<?php if(isset($vv['other']['target_height']) and $vv['other']['target_height'] != ''):?><?php $target_height = $vv['other']['target_height']?><?php endif?>
		<?php if(isset($vv['other']['target_left_percent']) and $vv['other']['target_left_percent'] != ''):?><?php $target_left_percent = $vv['other']['target_left_percent']?><?php endif?>
		<?php if(isset($vv['other']['target_top_percent']) and $vv['other']['target_top_percent'] != ''):?><?php $target_top_percent = $vv['other']['target_top_percent']?><?php endif?>

		<?php $posturl = $this->createUrl($this->data['router_class'].'/crop',array('width'=>$target_width,'height'=>$target_height,'pic'=>'')).$this->data['updatecontent'][$vv['other']['src_field']]?>
		<?php if(isset($vv['other']['posturl']) and $vv['other']['posturl'] != ''):?><?php $posturl = $vv['other']['posturl']?><?php endif?>
	
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl?>/js/image_resize_crop_canvas/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl?>/js/image_resize_crop_canvas/css/component.css" />
		<div class="component" style="max-width: <?php echo $work_width?>px !important; height: <?php echo $work_height?>px !important;">
			<div class="overlay" src_field="<?php echo $src_field?>" posturl="<?php echo $posturl?>" style="width: <?php echo $target_width?>px !important; height: <?php echo $target_height?>px !important; left: <?php echo $target_left_percent?>% !important; top: <?php echo $target_top_percent?>% !important; ">
				<div class="overlay-inner">
				</div>
			</div>
			<!-- This image must be on the same domain as the demo or it will not work on a local file system -->
			<!-- http://en.wikipedia.org/wiki/Cross-origin_resource_sharing -->
			<img class="resize-image" src="/_i/assets/upload/<?php echo $this->data['router_class']?>/<?php echo $this->data['updatecontent'][$vv['other']['src_field']]?>" alt="image for resizing">
			<button class="btn-crop js-crop">Crop<img class="icon-crop" src="<?php echo $this->assetsUrl?>/js/image_resize_crop_canvas/img/crop.svg"></button>
		</div>
		<script src="<?php echo $this->assetsUrl?>/js/image_resize_crop_canvas/js/component.js"></script>
		即時預覽<br />
		<img id="crop_<?php echo $src_field?>" src="http://placehold.it/200?text=Preview" />
		<br />
		己存檔的實際大小圖片<br />
		<img src="/_i/assets/thumb/<?php echo $this->data['router_class']?>/<?php echo $target_width.'x'.$target_height.'_'?><?php echo $this->data['updatecontent'][$vv['other']['src_field']]?>" alt="image for resizing">
	<?php else:?>
		請先上傳圖片
	<?php endif?>
<?php endif?>

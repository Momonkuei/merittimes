<?php if(isset($this->data['autzs']) and isset($this->data['autzs2']) and isset($this->data['resources'])):?>

<?php 


	$map = array(
		'index' => '列表',
		'create' => '新增',
		'update' => '修改',
		'delete' => '刪除',
		'all' => '全部',
		'export' => '匯出',
		'search' => '搜尋',
		'cancel_search' => '取消搜尋',
	);

	$tmp = $this->_get_admin_menu_classes();
	$menu_items = $tmp['data'];

	// http://stackoverflow.com/questions/8587341/recursive-function-to-generate-multidimensional-array-from-database-result
	function buildTree(array $elements, $parentId = 0) {
		$branch = array();

		foreach ($elements as $element) {
			if ($element['class_id'] == $parentId) {
				$children = buildTree($elements, $element['id']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}

		return $branch;
	}
	$tmps = buildTree($menu_items);
	$resources_tmp = array();
	foreach($resources as $k => $v){
		$resources_tmp[$v['name']] = $v;
	}
	if($tmps and count($tmps) > 0){
		foreach($tmps as $k => $v){
			if(isset($v['children']) and count($v['children']) > 0){
				foreach($v['children'] as $kk => $vv){
					$router_class = str_replace('backend.php?r=','',$vv['link']);
					$tmps[$k]['children'][$kk]['router_class'] = $router_class;
					if(isset($resources_tmp[$router_class])){
						$resource = $resources_tmp[$router_class];
						$tmps[$k]['children'][$kk]['resource'] = $resource;
						$tmps[$k]['children'][$kk]['actions'] = $resource['actions'];
						foreach($resources_tmp[$router_class]['actions'] as $action){
							if(isset($autzs2[$resource['name']][$action]) and $autzs2[$resource['name']][$action] > 0){
								$tmps[$k]['children'][$kk]['actions_checked'][$action] = '1';
							}
						}
					}
				}
			} else {
				$router_class = str_replace('backend.php?r=','',$v['link']);
				$tmps[$k]['router_class'] = $router_class;
				if(isset($resources_tmp[$router_class])){
					$resource = $resources_tmp[$router_class];
					$tmps[$k]['resource'] = $resource;
					$tmps[$k]['actions'] = $resource['actions'];
					foreach($resources_tmp[$router_class]['actions'] as $action){
						if(isset($autzs2[$resource['name']][$action]) and $autzs2[$resource['name']][$action] > 0){
							$tmps[$k]['actions_checked'][$action] = '1';
						}
					}
				}
			}
		}
	}
	?>
	<!-- BEGIN SAMPLE FORM PORTLET-->   
	<div class="portlet box blue">
	  <div class="portlet-title">
		 <div class="caption">
			<i class="icon-reorder"></i> <?php G::te(null, 'Premission Config', array(), '授權表') ?>
		 </div>
	<?php if(0):?>
		 <div class="tools">
			<a href="" class="collapse"></a>
			<a href="#portlet-config" data-toggle="modal" class="config"></a>
			<a href="" class="reload"></a>
			<a href="" class="remove"></a>
		 </div>
	<?php endif?>
	   </div>
	   <div class="portlet-body">

			<?php if($tmps and count($tmps) > 0):?>
				<?php foreach($tmps as $k => $v):?>
					<?php if(isset($v['children']) and count($v['children']) > 0):?>
						<h4><?php echo $v['class_name']?></h4>
						<?php foreach($v['children'] as $kk => $vv):?>
							<div class="form-group">
								<label class="col-md-3 control-label"><?php echo $vv['class_name']?></label>
								<div class="col-md-9">
									<div class="checkbox-list">
										<?php if(isset($vv['resource'])):?>
											<label class="checkbox-inline">
												<input type="checkbox" class="clickbutton" id="clickbutton_<?php echo $k.$kk?>" value="1" name="autz[<?php echo $vv['resource']['name']?>]" <?php if(isset($autzs[$vv['resource']['name']]) and $autzs[$vv['resource']['name']] > 0):?>checked="checked"<?php endif?> />
												全部
											</label>
											<?php if(isset($vv['actions'])):?>
												<?php foreach($vv['actions'] as $kkk => $vvv):?>
													<label class="checkbox-inline clickitem_<?php echo $k.$kk?>">
													<input type="checkbox" <?php if(isset($vv['actions_checked'][$vvv])): ?>checked="checked"<?php endif; ?> value="1" name="autz2[<?php echo $vv['resource']['name']?>][<?php echo $vvv ?>]" stylex="opacity: 1;" <?php if(isset($autzs[$vv['resource']['name']]) and $autzs[$vv['resource']['name']] > 0):?> disabled="disabled"<?php endif?> >
														<?php if(isset($map[$vvv])):?><?php G::te(null, $action, array(), $map[$vvv])?><?php else:?><?php G::te(null, $vvv)?><?php endif?>
													</label>
												<?php endforeach?>
											<?php endif?>
										<?php else:?>
											<p class="form-control-static">
												未設定
											</p>
										<?php endif?>
									</div>
								</div>
							</div>
						<?php endforeach?>
					<?php else:?>
						<?php if(isset($v['resource'])):?>

							<div class="form-group">
								<label class="col-md-3 gcontrol-label"><?php echo $v['class_name']?></label>
								<div class="col-md-9">
									<div class="checkbox-list">

										<label class="checkbox-inline">
											<input type="checkbox" class="clickbutton" id="clickbutton_<?php echo $k?>" value="1" name="autz[<?php echo $v['resource']['name']?>]" <?php if(isset($autzs[$v['resource']['name']]) and $autzs[$v['resource']['name']] > 0): ?>checked="checked"<?php endif?> />
											全部
										</label>
										<?php if(isset($v['actions'])):?>
											<?php foreach($v['actions'] as $kk => $vv):?>
												<label class="checkbox-inline clickitem_<?php echo $k?>">
													<input type="checkbox" <?php if(isset($v['actions_checked'][$vv])): ?>checked="checked"<?php endif; ?> value="1" name="autz2[<?php echo $v['resource']['name']?>][<?php echo $vv ?>]" stylex="opacity: 1;" <?php if(isset($autzs[$v['resource']['name']]) and $autzs[$v['resource']['name']] > 0):?> disabled="disabled"<?php endif?> >
													<?php if(isset($map[$vv])):?><?php G::te(null, $action, array(), $map[$vv])?><?php else:?><?php G::te(null, $vv)?><?php endif?>
												</label>
											<?php endforeach?>
										<?php endif?>

									</div>
								</div>
							</div>

						<?php else:?>
							<?php if(0):?>
								<p class="form-control-static">
									未設定
								</p>
							<?php endif?>
						<?php endif?>
					<?php endif?>
				<?php endforeach?>
			<?php endif?>

	   </div>
	</div>
	<!-- END SAMPLE FORM PORTLET-->

   <script type="text/javascript">
      $(document).ready(function() {   
		  $('.clickbutton').change(function(){
			  var thisobj = $(this);
			  var data = thisobj.attr('id');
			  var arr = data.split('_');
			  // arr[1]

			  if($(this).prop("checked") == true){
				  $('.clickitem_'+arr[1]).each(function(index,value){
					  $(this).find('input').attr('disabled','disabled');
					  $(this).find('.checker').addClass('disabled');
				  });
			  } else {
				  $('.clickitem_'+arr[1]).each(function(index,value){
					  $(this).find('input').removeAttr('disabled');
					  $(this).find('.checker').removeClass('disabled');
				  });
			  }
		  });
      });
   </script>

<?php endif?>

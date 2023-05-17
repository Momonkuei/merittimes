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
		'upload' => '更新',
		'node' => '節點資料',
		'ajaxdata' => '資料(必勾)',//#43216
		'ajaxcolumndefs' => '資料(必勾)',//#43216
		'ajaxinsertdata' => '新增',//#43216
		'ajaxdeletedata' => '刪除',//#43216
		'ajaxupdatedata' => '修改',//#43216
		'ajaxsortdata' => '排序',//#43216
	);

	$tmp = $this->_get_admin_menu_classes();
	$menu_items = $tmp['data'];

	$resources_tmp = array();
	foreach($resources as $k => $v){
		$resources_tmp[$v['name']] = $v;
	}

	if($menu_items and count($menu_items) > 0){
		foreach($menu_items as $k => $v){
			$router_class = str_replace('backend.php?r=','',$v['link']);
			$menu_items[$k]['router_class'] = $router_class;
			if(isset($resources_tmp[$router_class])){
				$resource = $resources_tmp[$router_class];
				$menu_items[$k]['resource'] = $resource;
				$menu_items[$k]['actions'] = $resource['actions'];
				foreach($resources_tmp[$router_class]['actions'] as $action){
					if(isset($autzs2[$resource['name']][$action]) and $autzs2[$resource['name']][$action] > 0){
						$menu_items[$k]['actions_checked'][$action] = '1';
					}
				}
			}
			
		}
	}

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

	// http://www.developerq.com/article/1502680799
	function array_set_depth($array, $depth = -1){
		$subdepth = $depth + 1;
		if ($depth < 0) {
			foreach ($array as $key => $subarray) {
				$temp[$key] = array_set_depth(($subarray), $subdepth);
			}
			return $temp;
		}
		$array['depth'] = $depth;
		//if ($array['hasChildren'] && isset($array['children'])) {
		if (isset($array['children'])) {
			foreach ($array['children'] as $key => $subarray) {
				$temp[$key] = array_set_depth($subarray, $subdepth);
			}
			unset($array['children']);
			$array['children'] = $temp;
		}
		return $array;
	}
	$tmps = array_set_depth($tmps);

	function renderMenu($items,$autzs,$map = array()) {		

		$render = '';

		foreach ($items as $k => $item) {
			if($item['depth'] > 0){
				$item['class_name'] = str_repeat('　',$item['depth']).'└　'.$item['class_name'];
			} else {
				$item['class_name'] = '<b>'.$item['class_name'].'</b>';
			}

			$item['resource_name_checked'] = '';
			if(isset($item['resource']['name']) and isset($autzs[$item['resource']['name']]) and $autzs[$item['resource']['name']] > 0){
				$item['resource_name_checked'] = 'checked="checked"';
			}

			$item['resource_name'] = '';
			if(isset($item['resource']['name']) and $item['resource']['name'] != ''){
				$item['resource_name'] = $item['resource']['name'];
			}

			$o = json_decode(json_encode($item), false); // https://stackoverflow.com/questions/1869091/how-to-convert-an-array-to-object-in-php

			$render .= <<<XXX
<div class="form-group">
	<label class="col-md-3 gcontrol-label">$o->class_name</label>
	<div class="col-md-9">
		<div class="checkbox-list">

XXX;

			if(isset($item['resource'])){
				$render .= <<<XXX
			<label class="checkbox-inline">
				<input type="checkbox" class="clickbutton" id="clickbutton_{$o->resource_name}$k" value="1" name="autz[$o->resource_name]" $o->resource_name_checked />
				全部
			</label>
XXX;
				if(isset($item['actions'])){
					foreach($item['actions'] as $kk => $vv){
						$actions_checked = '';
						if(isset($item['actions_checked'][$vv])){
							$actions_checked = 'checked="checked"';
						}

						$disabled = '';
						if(isset($item['resource']['name']) and isset($autzs[$item['resource']['name']]) and $autzs[$item['resource']['name']] > 0){
							$disabled = 'disabled="disabled"';
						}

						$render .= <<<XXX
					<label class="checkbox-inline clickitem_{$o->resource_name}$k">
						<input type="checkbox" $actions_checked value="1" name="autz2[$o->resource_name][$vv]" stylex="opacity: 1;" $disabled >
XXX;

						if(isset($map[$vv])){
							// $render .= G::t(null, $action, array(), $map[$vv]);
							$render .= G::t(null, $map[$vv]);
						} else {						
							$render .= G::t(null, $vv);
						}
						$render .= <<<XXX
					</label>
XXX;
					}
				}
			} else {
				$render .= <<<XXX
				<p class="form-control-static">
					未設定
				</p>
XXX;
			}

			$render .= <<<XXX
		</div>
	</div>
</div>
XXX;

			if (!empty($item['children'])) {
				$render .= renderMenu($item['children'], $autzs,$map);
			}
		}

		return $render."\n";
	}
	$new = renderMenu($tmps,$autzs,$map);

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

			<?php echo $new?>

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

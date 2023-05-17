<?php if(!empty($menus) and $router_class != 'auth'):?>
<div class="page-sidebar nav-collapse collapse">
	<ul id="mainmenu">
		<li>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			<div class="sidebar-toggler hidden-phone"></div>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		</li>
		<?php if(0):?>
		<li>
			<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
			<form class="sidebar-search">
				<div class="input-box">
					<a href="javascript:;" class="remove"></a>
					<input type="text" placeholder="Search..." />				
					<input type="button" class="submit" value=" " />
				</div>
			</form>
			<!-- END RESPONSIVE QUICK SEARCH FORM -->
		</li>
		<?php endif?>
<?php

	// 先處理一下，沒有子項的大項，刪掉(main跳過)
	foreach($menus as $k => $v){
		if($v['class'] != 'main'){
			$link_tmp = '';
			if($v['link'] != '' and $v['link'] != '#'){
				$link_tmp = $v['link'];
			}
			if($link_tmp == ''){
				$link_tmp = '#';
			}
			if(empty($submenus[$v['id']]) and $link_tmp == '#'){
				unset($menus[$k]);
			}
		}
	}

	// 重新編流水號
	$x = 0;
	$menus_tmp = array();
	foreach($menus as $k => $v){
		$menus_tmp[$x] = $v;
		$x++;
	}
	$menus = $menus_tmp;
	//var_dump($menus_tmp);

	foreach($menus as $k => $v){
		if($v['class'] == 'main'){
			if(isset($menus[$k+1]) and $menus[$k+1]['class'] == 'main'){
				unset($menus[$k]);
			}
		}
	}

	foreach($menus as $k => $v){
		$link_tmp = '';
		if($v['link'] != '' and $v['link'] != '#'){
			$link_tmp = $v['link'];
		}
		// 避免只有root層，而沒有子項，而root層又沒有連結的狀況下出現
		//if(empty($submenus[$v['id']]) and $link_tmp == ''){
		//	continue;
		//}

		// 分隔項的顯示方式要有所不同
		$current_big_menu = '';
		if(empty($submenus[$v['id']]) and $link_tmp == '' and $v['class'] = 'main'){
			$current_big_menu = 'big';
		}
		$current_root_menu = '';
		if($v['id'] == $default_menu){
			$current_root_menu = 'active';
		} elseif($default_menu == '0' and $v['id'] == $default_sub_menu){
			$current_root_menu = 'active';
		}

?>
	<li class="<?php echo $current_root_menu?> <?php if(!empty($submenus[$v['id']])):?> has-sub <?php endif?>">
		<a href="<?php echo $link_tmp?>" class="<?php if($current_big_menu == 'big'):?>bigme<?php endif?>">
			<?php if($current_big_menu != 'big'):?>
			<?php endif?>

			<?php if($current_big_menu != 'big'):?>
				<i class="icon-map-marker"></i>
			<?php else:?>
				<i class="icon-th-list"></i>
			<?php endif?>

			<?php if($current_big_menu != 'big'):?>
				<span class="title"><?php echo $v['name']?></span>
			<?php else:?>
				<span class="title" style2="border-top: 1px solid #595959 !important;color: #FFFFFF !important;"><?php echo $v['name']?></span>
			<?php endif?>

			<?php if($current_root_menu == 'active'):?>
				<span class="selected"></span>
			<?php endif?>

			<?php if($current_big_menu != 'big'):?>
			<span class="arrow <?php if($current_root_menu != ''):?> open <?php endif?>"></span>
			<?php endif?>
		</a>
		
<?php

		if(!empty($submenus[$v['id']])){
			// 子選單會跑兩次迴圈
			$current_sub_menu_showhide = 'none';
			foreach($submenus[$v['id']] as $kk => $vv){
				if($vv['id'] == $default_sub_menu){
					$current_sub_menu_showhide = 'block';
					continue;
				}
			}
?>
			<ul class="sub">
<?php
			foreach($submenus[$v['id']] as $kk => $vv){
				if($vv['id'] == $default_sub_menu){
					$current_sub_menu = 'active';	
				} else {
					$current_sub_menu = '';	
				}
?>
				<li class="<?php echo $current_sub_menu?>"><a href="<?php echo $vv['link']?>"><?php echo $vv['name']?></a></li>
<?php
			}
?>
			</ul>
<?php
		} // if
?>
		</li>
<?php
	} // foreach
?>

		<?php // 在考慮看看要不要加，因為在FF會碰到底，怪怪的?>
		<?php if(0):?>
			<li>&nbsp;</li>
			<li>&nbsp;</li>
		<?php endif?>

	</ul>
</div>

<?php
$tmpx = <<<XXX
$('#mainmenu').children('li').children('a').click(function(){
	if($(this).attr('class') == 'bigme'){
		return false;
	}

	if($(this).parent().hasClass('active')){
		$(this).parent().attr('class', '');
		$(this).find('.arrow').attr('class', 'arrow');
	} else {
		$(this).parent().attr('class', 'active');
		$(this).find('.arrow').attr('class', 'arrow open');
	}

	//if($(this).parent().attr('class') != ''){
	//	$(this).parent().attr('class', '');
	//	$(this).find('.arrow').attr('class', 'arrow');
	//} else {
	//	$(this).parent().attr('class', 'active');
	//	$(this).find('.arrow').attr('class', 'arrow open');
	//}
	//alert($(this).attr('href'));
	if($(this).attr('href') == '' || $(this).attr('href') == '#'){
		return false;
	}

	//return false;
});
XXX;
	Yii::app()->clientScript->registerScript('menu_footer', $tmpx, CClientScript::POS_READY);
?>

<?php endif;?>



<?php if(0):?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar nav-collapse collapse">
	<!-- BEGIN SIDEBAR MENU -->        	
	<ul>
		<li>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			<div class="sidebar-toggler hidden-phone"></div>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		</li>
		<li>
			<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
			<form class="sidebar-search">
				<div class="input-box">
					<a href="javascript:;" class="remove"></a>
					<input type="text" placeholder="Search..." />				
					<input type="button" class="submit" value=" " />
				</div>
			</form>
			<!-- END RESPONSIVE QUICK SEARCH FORM -->
		</li>
		<li class="start active ">
			<a href="index.html">
			<i class="icon-home"></i> 
			<span class="title">Dashboard</span>
			<span class="selected"></span>
			</a>
		</li>
		<li class="has-sub ">
			<a href="javascript:;">
			<i class="icon-bookmark-empty"></i> 
			<span class="title">UI Features</span>
			<span class="arrow "></span>
			</a>
			<ul class="sub">
				<li ><a href="ui_general.html">General</a></li>
				<li ><a href="ui_buttons.html">Buttons</a></li>
				<li ><a href="ui_tabs_accordions.html">Tabs & Accordions</a></li>
				<li ><a href="ui_sliders.html">Sliders</a></li>
				<li ><a href="ui_tiles.html">Tiles</a></li>
				<li ><a href="ui_typography.html">Typography</a></li>
				<li ><a href="ui_tree.html">Tree View</a></li>
				<li ><a href="ui_nestable.html">Nestable List</a></li>
			</ul>
		</li>
		<li class="has-sub ">
			<a href="javascript:;">
			<i class="icon-table"></i> 
			<span class="title">Form Stuff</span>
			<span class="arrow "></span>
			</a>
			<ul class="sub">
				<li ><a href="form_layout.html">Form Layouts</a></li>
				<li ><a href="form_samples.html">Advance Form Samples</a></li>
				<li ><a href="form_component.html">Form Components</a></li>
				<li ><a href="form_wizard.html">Form Wizard</a></li>
				<li ><a href="form_validation.html">Form Validation</a></li>
				<li ><a href="form_fileupload.html">Multiple File Upload</a></li>
				<li ><a href="form_dropzone.html">Dropzone File Upload</a></li>
			</ul>
		</li>
		<li class="has-sub ">
			<a href="javascript:;">
			<i class="icon-th-list"></i> 
			<span class="title">Data Tables</span>
			<span class="arrow "></span>
			</a>
			<ul class="sub">
				<li ><a href="table_basic.html">Basic Tables</a></li>
				<li ><a href="table_managed.html">Managed Tables</a></li>
				<li ><a href="table_editable.html">Editable Tables</a></li>
			</ul>
		</li>
		<li class="has-sub ">
			<a href="javascript:;">
			<i class="icon-th-list"></i> 
			<span class="title">Portlets</span>
			<span class="arrow "></span>
			</a>
			<ul class="sub">
				<li ><a href="portlet_general.html">General Portlets</a></li>
				<li ><a href="portlet_draggable.html">Draggable Portlets</a></li>
			</ul>
		</li>
		<li class="has-sub ">
			<a href="javascript:;">
			<i class="icon-map-marker"></i> 
			<span class="title">Maps</span>
			<span class="arrow "></span>
			</a>
			<ul class="sub">
				<li ><a href="maps_google.html">Google Maps</a></li>
				<li ><a href="maps_vector.html">Vector Maps</a></li>
			</ul>
		</li>
		<li class="">
			<a href="charts.html">
			<i class="icon-bar-chart"></i> 
			<span class="title">Visual Charts</span>
			</a>
		</li>
		<li class="">
			<a href="calendar.html">
			<i class="icon-calendar"></i> 
			<span class="title">Calendar</span>
			</a>
		</li>
		<li class="">
			<a href="gallery.html">
			<i class="icon-camera"></i> 
			<span class="title">Gallery</span>
			</a>
		</li>
		<li class="has-sub ">
			<a href="javascript:;">
			<i class="icon-briefcase"></i> 
			<span class="title">Extra</span>
			<span class="arrow "></span>
			</a>
			<ul class="sub">
				<li ><a href="extra_profile.html">User Profile</a></li>
				<li ><a href="extra_faq.html">FAQ</a></li>
				<li ><a href="extra_search.html">Search Results</a></li>
				<li ><a href="extra_invoice.html">Invoice</a></li>
				<li ><a href="extra_pricing_table.html">Pricing Tables</a></li>
				<li ><a href="extra_404.html">404 Page</a></li>
				<li ><a href="extra_500.html">500 Page</a></li>
				<li ><a href="extra_blank.html">Blank Page</a></li>
				<li ><a href="extra_full_width.html">Full Width Page</a></li>
			</ul>
		</li>
		<li class="">
			<a href="login.html">
			<i class="icon-user"></i> 
			<span class="title">Login Page</span>
			</a>
		</li>
	</ul>
	<!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->
<?php endif;?>

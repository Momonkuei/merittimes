<?php $addandmodifydata = ''?>
<?php //if(!isset($addandmodifydata) or $addandmodifydata == ''):?>
<?php //$addandmodifydata = ' :: '.G::t($this->data['theme_lang'], 'Add and Modify Data', null, '新增修改資料')?>
<?php //endif?>

<?php $main_content_title_action = ''?>
<?php if(isset($action)):?>
	<?php if($action == ''):?>
		<?php $main_content_title_action = ''?>
	<?php elseif($action == 'update'):?>
		<?php $main_content_title_action = $addandmodifydata?>
	<?php elseif($action == 'create'):?>
		<?php $main_content_title_action = G::t($this->data['theme_lang'], 'Establish an Data', null, '新增資料')?>
	<?php else:?>
		<?php $main_content_title_action = ''?>
	<?php endif?>
<?php endif?>

<?php //寫給商品分類所使用?>
<?php if(isset($other_content_title) and $other_content_title != ''):?>
	<?php $main_content_title_action = ' / '.$other_content_title?>
<?php endif?>

<?php //最後在做一次覆蓋確認?>
<?php if(isset($main_content_title_action_tmp) and $main_content_title_action_tmp != ''):?>
	<?php $main_content_title_action = $main_content_title_action_tmp?>
<?php endif?>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN STYLE CUSTOMIZER -->
		<div class="color-panel hidden-phone">

<?php if(0):?>
			<div class="color-mode-icons icon-color"></div>
			<div class="color-mode-icons icon-color-close"></div>
			<div class="color-mode">
				<p>THEME COLOR</p>
				<ul class="inline">
					<li data-style="default" class="color-black current color-default"></li>
					<li data-style="blue" class="color-blue"></li>
					<li data-style="brown" class="color-brown"></li>
					<li data-style="purple" class="color-purple"></li>
					<li data-style="light" class="color-white color-light"></li>
				</ul>
				<label class="hidden-phone">
					<div class="checker" id="uniform-undefined"><span class="checked"><input type="checkbox" value="" checked="" class="header" style="opacity: 0;"></span></div>
					<span class="color-mode-label">Fixed Header</span>
				</label>                    
			</div>
<?php endif?>

<?php if(!isset($def['disable_index_normal_search']) or (isset($def['disable_index_normal_search']) and $def['disable_index_normal_search'] == false)):?>
			<form style="position: absolute;right:0px;top:4px;" method="GET" action="<?php echo $current_url?>" id="searchFrm" name="searchFrm" onsubmit="searchkeyword(this);return false;">


				<div class="searchCopy"> <span class="fle"><?php G::te($this->data['theme_lang'], 'Search', null, '搜尋')?></span>
					<input type="text" name="search_keyword" id="search_keyword" placeholder="<?php G::te($this->data['theme_lang'], 'Search Data', null, '搜尋資料內容')?>" />
					<input type="image" class="search_icon" title="搜尋" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icon007.gif" align="top" />
					<?php if(isset($search_keyword) and $search_keyword != '' and 0):?>
					<span class="search_re"><a class="cancel_search2" href="#">清除設定</a></span>
					<?php endif?>
				</div>

			</form>
<?php endif?>

		</div>
		<!-- END BEGIN STYLE CUSTOMIZER -->   
		<h3 class="page-title">
			<?php echo $main_content_title?>

			<?php if(0):?>
				<small>form components and widgets</small>
			<?php endif?>
		</h3>

		<ul class="page-breadcrumb breadcrumb">
			<li>

				<?php // 新版麵包?>
				<?php if(isset($admin_menu_breadcrumbs) and $admin_menu_breadcrumbs != ''):?>
					<?php echo $admin_menu_breadcrumbs?>
				<?php else:?>
					<i class="icon-home"></i>
					<a href="backend.php"><?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></a> 
					<span class="icon-angle-right"></span>

					<?php if($default_menu_title != ''):?>
						<a href="#"><?php echo $default_menu_title?></a> 
						<span class="icon-angle-right"></span>
					<?php endif?>

					<a href="#"><?php echo strip_tags($main_content_title)?></a> 
					<?php if($main_content_title_action != ''):?>
						<span class="icon-angle-right"></span>
					<?php endif?>

					<?php if($main_content_title_action != ''):?>
						<a href="#"><?php echo $main_content_title_action?></a> 
					<?php endif?>
				<?php endif?>
			</li>

			<?php if(isset($this->data['tools']) and count($this->data['tools']) > 0):?> 
			<li class="btn-group">
				<button class="btn blue dropdown-toggle" data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" type="button">工具 <i class="icon-angle-down"></i></button>
				<ul class="dropdown-menu pull-right" role="menu">
					<?php foreach($this->data['tools'] as $k => $v):?>
					<li><a <?php if(isset($v['class']) and $v['class'] != ''):?>class="<?php echo $v['class']?>"<?php endif?> <?php if(isset($v['target']) and $v['target'] != ''):?>target="<?php echo $v['target']?>"<?php endif?> href="<?php echo $v['url']?>"><?php echo $v['name']?></a></li>
					<?php endforeach?>
				</ul>
			</li>
			<?php endif?>
		</ul>

		<div class="clearfix">
			<?php if(isset($this->data['tools']) and count($this->data['tools']) > 0 and 0):?>
			<div class="btn-group pull-right">
				<button data-toggle="dropdown" class="btn dropdown-toggle"><?php G::te($this->data['theme_lang'], 'Home', null, '工具')?> <i class="icon-angle-down"></i>
				</button>
				<ul class="dropdown-menu">
					<?php foreach($this->data['tools'] as $k => $v):?>
					<li><a <?php if(isset($v['class']) and $v['class'] != ''):?>class="<?php echo $v['class']?>"<?php endif?> <?php if(isset($v['target']) and $v['target'] != ''):?>target="<?php echo $v['target']?>"<?php endif?> href="<?php echo $v['url']?>"><?php echo $v['name']?></a></li>
					<?php endforeach?>
				</ul>
			</div>
			<?php endif?>
		</div>

<?php // 在IE8會有顯示上的問題?>
<?php if(0):?>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="backend.php"><?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></a> 
				<span class="icon-angle-right"></span>
			</li>
			<?php if($default_menu_title != ''):?>
			<li>
				<a href="#"><?php echo $default_menu_title?></a> 
				<span class="icon-angle-right"></span>
			</li>
			<?php endif?>
			<li>
				<a href="#"><?php echo $main_content_title?></a> 
				<?php if($main_content_title_action != ''):?>
				<span class="icon-angle-right"></span>
				<?php endif?>
			</li>
			<?php if($main_content_title_action != ''):?>
			<li>
				<a href="#"><?php echo $main_content_title_action?></a> 
			</li>
			<?php endif?>

<?php if(0):?>
			<li>
				<a href="#">Form Stuff</a>
				<span class="icon-angle-right"></span>
			</li>
			<li><a href="#">Form Components</a></li>
<?php endif?>

		</ul>
<?php endif?>

	</div>
</div>

<?php if(0):?>
<h1>
	<?php if(!isset($this->data['disable_title']) or $this->data['disable_title'] != true):?>
	<?php echo $main_content_title?>
	<?php endif?>

	&nbsp;&nbsp;<a href="backend.php"><span class="h1blue"><?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></span></a>
	&gt;
	<?php if($default_menu_title != ''):?>
		&nbsp;&nbsp;<a href="#"><span class="h1blue"><?php echo $default_menu_title?></span></a>
		&gt;
	<?php endif?>
	&nbsp;&nbsp;<span class="h1blue"><?php echo $main_content_title.$main_content_title_action?></span>
</h1>
<?php endif?>

<?php if(isset($prev_url) and $prev_url != '' and 0):?>
	<div class="formtop clearfix">
		<a href="<?php echo $prev_url?>"><div class="t_back fle"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></div></a>
	</div>
<?php endif?>

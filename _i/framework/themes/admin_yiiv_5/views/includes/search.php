<script type="text/javascript">
	<!--
$(document).ready(function() {
	$('.cancel_search').click(function(){
		$('#search_keyword').attr('value', '');
		$('#searchFrm').submit();
	});
});

function searchkeyword(form)
{
	var aaa = base64_encode(form.search_keyword.value);
	if(aaa == ''){
		document.location.href='<?php echo $current_url?>&param=<?php echo $parameter['nosearch']?>1';
	} else {
		document.location.href='<?php echo $current_url?>&param=<?php echo $parameter['search']?>' + aaa;
	}
	return false;
}
//-->
</script>

<div class="row">
<?php $main_content_title_action = ''?>
<?php if(isset($action)):?>
	<?php if($action == ''):?>
		<?php $main_content_title_action = ''?>
	<?php elseif($action == 'update'):?>
		<?php $main_content_title_action = G::t($this->data['theme_lang'], 'Modify an Data', null, '修改資料')?>
	<?php elseif($action == 'create'):?>
		<?php $main_content_title_action = G::t($this->data['theme_lang'], 'Establish an Data', null, '新增資料')?>
	<?php else:?>
		<?php $main_content_title_action = ''?>
	<?php endif?>
<?php endif?>

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


				<div class="searchCopy dataTables_filter">
					<label class="fle">
						<?php echo G::_('Search', 'en')?>
						<input type="text" name="search_keyword" class="m-wrap medium" id="search_keyword" placeholder="<?php echo G::_('Search Data', 'en')?>" />
					</label>
					<input type="image" class="search_icon hide" title="搜尋" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icon007.gif" align="top" />
					<?php if(isset($search_keyword) and $search_keyword != '' and 0):?>
					<span class="search_re"><a class="cancel_search2" href="#">清除設定</a></span>
					<?php endif?>
				</div>

			</form>
<?php endif?>

		</div>
		<!-- END BEGIN STYLE CUSTOMIZER -->   
		<h3 class="page-title 123">
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
					<a href="backend.php"><?php echo G::_('Home', 'en')?></a> 
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

			<?php // 這是原本的，但是我的認知它很容易忘記，想要併在def裡面?>
			<?php if(isset($this->data['tools']) and count($this->data['tools']) > 0):?> 
			<li class="btn-group">
				<button class="btn blue dropdown-toggle" data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" type="button">工具 <i class="icon-angle-down"></i></button>
				<ul class="dropdown-menu pull-right" role="menu">
					<?php foreach($this->data['tools'] as $k => $v):?>
					<li>
						<a 
							<?php if(isset($v['onclick']) and $v['onclick'] != ''):?>onclick="<?php echo $v['onclick']?>"<?php endif?> 
							<?php if(isset($v['class']) and $v['class'] != ''):?>class="<?php echo $v['class']?>"<?php endif?> 
							<?php if(isset($v['target']) and $v['target'] != ''):?>target="<?php echo $v['target']?>"<?php endif?> 
							href="<?php echo $v['url']?>"
						>
						<?php echo $v['name']?>
						</a>
					</li>
					<?php endforeach?>
				</ul>
			</li>
			<?php endif?>

			<?php if(isset($def['tools']) and count($def['tools']) > 0):?> 
			<li class="btn-group">
				<button class="btn blue dropdown-toggle" data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" type="button"><?php if(isset($def['tools_name']) and $def['tools_name']!=''):?><?php echo $def['tools_name']?><?php else:?>工具<?php endif?> <i class="icon-angle-down"></i></button>
				<ul class="dropdown-menu pull-right" role="menu">
					<?php foreach($def['tools'] as $k => $v):?>
					<li>
						<a 
							<?php if(isset($v['onclick']) and $v['onclick'] != ''):?>onclick="<?php echo $v['onclick']?>"<?php endif?> 
							<?php if(isset($v['class']) and $v['class'] != ''):?>class="<?php echo $v['class']?>"<?php endif?> 
							<?php if(isset($v['target']) and $v['target'] != ''):?>target="<?php echo $v['target']?>"<?php endif?> 
							href="<?php echo $v['url']?>"
						>
						<?php echo $v['name']?>
						</a>
					</li>
					<?php endforeach?>
				</ul>
			</li>
			<?php endif?>

		</ul>

		<div class="clearfix">
			<?php if(!isset($def['disable_create']) or $def['disable_create'] != true):?>
				<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'create'))?>
				<div class="btn-group">
					<button id="sample_editable_1_new" class="btn green" onclick="javascript:location.href='<?php echo $class_url?>/create&param=<?php echo $parameter['prev'].$current_base64_url?>';">
					<?php echo G::_('Create', 'en')?> <i class="icon-plus"></i>
					</button>
				</div>
				<?php $this->EndWidget('system.widgets.Gw_acl')?>
			<?php endif?>

			<?php if(isset($def['index_buttons']) and count($def['index_buttons']) > 0):?>
				<?php foreach($def['index_buttons'] as $k => $v):?>
					<?php if(!isset($v['name2']) or $v['name2'] == ''):?><?php continue?><?php endif?>
					<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>$v['name2']))?>
					<div class="btn-group">
						<button id="<?php echo $v['id']?>" class="<?php echo $v['class']?>" onclick="<?php echo $v['onclick']?>">
						<?php echo $v['name']?>
						</button>
					</div>
					<?php $this->EndWidget('system.widgets.Gw_acl')?>
				<?php endforeach?>
			<?php endif?>

			<?php if(isset($def['enable_delete']) and $def['enable_delete'] == true):?>
				<div class="btn-group">
					<button class="btn red" onclick="javascript:DoBatch();">
					<?php echo G::_('Delete', 'en')?>
					</button>
				</div>
				<script type="text/javascript">
					function DoBatch()
					{
						$('#ezdelete').attr('action', '<?php echo $class_url?>/ezdelete&param=<?php echo $parameter['prev'].$current_base64_url?>');
						if (confirm('是否確定刪除?')){
							$('#ezdelete').submit();
						}
					}
					$(document).ready(function() {
						<?php // 複製來自於原版型的template_content/assets/scripts/table-managed.js?>
						jQuery('#tablelist .group-checkable').change(function () {
							var set = jQuery(this).attr("data-set");
							var checked = jQuery(this).is(":checked");
							jQuery(set).each(function () {
								if (checked) {
									$(this).attr("checked", true);
								} else {
									$(this).attr("checked", false);
								}
								$(this).parents('tr').toggleClass("active");
							});
							jQuery.uniform.update(set);

						});

						jQuery('#tablelist tbody tr .checkboxes').change(function(){
							$(this).parents('tr').toggleClass("active");
						});
					});
				</script>
			<?php endif?>
			<?php if(0 and isset($this->data['tools']) and count($this->data['tools']) > 0):?>
			<div class="btn-group pull-right">
				<button data-toggle="dropdown" class="btn dropdown-toggle">工具 <i class="icon-angle-down"></i>
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

<!--建立按鈕-->
<div class="formtop clearfix">
	<?php if(0):?>
		<?php if(!isset($def['disable_create']) or $def['disable_create'] != true):?>
			<?php $this->BeginWidget('system.widgets.Gw_acl', array('method'=>'create'))?>
				<a class="btn btn-large" href="<?php echo $class_url?>/create&param=<?php echo $parameter['prev'].$current_base64_url?>"><div class="t_add fle"><?php G::te($this->data['theme_lang'], 'Create', null, '新增')?></div></a>
			<?php $this->EndWidget('system.widgets.Gw_acl')?>
		<?php endif?>
	<?php endif?>


	<?php if(isset($search_keyword) and $search_keyword != ''):?>
	<br />
	<div class="tableData">
		<table style="background-color:#eff;width:100%;font-size:12px;margin-bottom:2px;margin-top:2px;">
			<tr>
				<td><?php echo G::_('Search', 'en')?>：<?php echo $search_keyword?></td>
				<td align="right"><span class="search_re"><a class="cancel_search" href="#"><?php echo G::_('Cancel Search', 'en')?></a></span></td>
			</tr>
		</table>
	</div>
	<?php endif?>
</div>

	<?php //{{* 自定的smarty top 區塊，來自於資料庫 *}} ?>
	<?php if(isset($def['listfield_attr']['smarty_include_top_text']) and $def['listfield_attr']['smarty_include_top_text'] != ''):?>
		<?php eval($def['listfield_attr']['smarty_include_top_text'])?>
	<?php endif?>

</div><!-- row-fluid -->


</div>

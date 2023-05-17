<?php $addandmodifydata = ''?>
<?php //if(!isset($addandmodifydata) or $addandmodifydata == ''):?>
<?php //$addandmodifydata = ' :: '.G::t($this->data['theme_lang'], 'Add and Modify Data', null, '新增修改資料')?>
<?php //endif?>

<?php $main_content_title_action = ''?>
<?php if(isset($action)):?>
	<?php if($action == ''):?>
		<?php $main_content_title_action = ''?>
	<?php elseif($action == 'update'):?>
		<?php $main_content_title_action = '&nbsp;&nbsp;'.$addandmodifydata?>
	<?php elseif($action == 'create'):?>
		<?php $main_content_title_action = '&nbsp;&nbsp;'.G::t($this->data['theme_lang'], 'Establish an Data', null, '新增資料')?>
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

<div class="title">
	<?php if(!isset($this->data['disable_title']) or $this->data['disable_title'] != true):?>
	<h1><?php echo $main_content_title?></h1>
	<?php endif?>
	<ul id="breadcrumbs">
		<li><a href="backend.php"><?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></a></li>
		<li>&gt;</li>
		<?php if($default_menu_title != ''):?>
			<li><a href="#"><?php echo $default_menu_title?></a></li>
			<li>&gt;</li>
		<?php endif?>
		<li class="selected"><a href="#"><?php echo $main_content_title.$main_content_title_action?></a></li>
	</ul>
	<div class="clear"></div>
</div>	

<?php if(0):?>
{{if 0}}
<form method="GET" action="{{$current_url}}" id="searchFrm" name="searchFrm" onsubmit="searchkeyword(this);return false;">
	<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix">
		{{* 自定的smarty top 區塊 *}}
		{{if $def.listfield_attr.smarty_include_top != ''}}
			{{include file=$def.listfield_attr.smarty_include_top}}
		{{/if}}

		{{* 自定的smarty top 區塊，來自於資料庫 *}}
		{{if $def.listfield_attr.smarty_include_top_text != ''}}
			{{assign var="smarty_include_top_text" value=$def.listfield_attr.smarty_include_top_text}}
			{{include file="text:`$smarty_include_top_text`"}}
		{{/if}}

		<div class="dataTables_filter" id="datatable_filter">
			{{if $def.data_multilanguage == true and $router_method == 'index'}}
				<select name="edit_lang" onchange="document.location.href='{{$base_url}}/backend.php?r=auth/switchdataml&ml_key='+this.value+'&current_base64_url={{$current_base64_url}}';">
				{{foreach from=$mls key=k item=v}}
					<option value="{{$k}}" {{if $k == $ml_key}}selected="selected"{{/if}}>{{$v}}</option>
				{{/foreach}}
				</select>
			{{/if}}
		</div>
	</div>
</form>
{{/if}}
<?php endif?>

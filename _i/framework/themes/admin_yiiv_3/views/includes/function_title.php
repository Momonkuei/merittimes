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

<?php if(0):?>
<h1>使用者管理系統&nbsp;&nbsp;<span class="h1blue">使用者管理</span></h1>
<?php endif?>

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

<?php if(isset($prev_url) and $prev_url != '' and 0):?>
	<div class="formtop clearfix">
		<a href="<?php echo $prev_url?>"><div class="t_back fle"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></div></a>
	</div>
<?php endif?>

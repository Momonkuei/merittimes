<div class="row-fluid">
	<div class="span12">
		<h2><?php G::te($this->data['theme_lang'], 'Welcome Login', null, '歡迎登入EOB管理系統')?></h2>
	</div>
</div>
<script type="text/javascript">
function searchkeyword(form)
{
	var aaa = base64_encode(form.search_keyword.value);
	if(aaa != ''){
<?php 
$acl = new Admin_acl();
$acl->start();
?>
<?php if($acl->hasAcl($this->data['admin_id'], 'member', 'index')):?>
		document.location.href='<?php echo $this->createUrl('member/index')?>&param=s' + aaa;
<?php else:?>
		document.location.href='<?php echo $this->createUrl('memberdemand/index')?>&param=s' + aaa;
<?php endif?>
	}
	return false;
}
</script>

<?php //*麵包或是功能標題*}} ?>
<div class="row-fluid">

	<?php if(count($this->data['tcofastmenus']) > 0):?>
	<div class="span10">
	<?php else:?>
	<div class="span12">
	<?php endif?>

		<div class="portlet box light-grey" style="border-style:none">
			<div class="portlet-body">
				<form id="searchFrm" onsubmit="searchkeyword(this);return false;" name="searchFrm" action="<?php echo $this->createUrl('memberdemand/index')?>" method="GET">
					<?php G::te($this->data['theme_lang'], 'Search', null, '搜尋')?>：<input size="100" id="search_keyword" name="search_keyword" value="" placeholder="<?php G::te($this->data['theme_lang'], 'Search', null, '請輸入')?>" />
					<br />
					<br />
					<img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/globe_06.jpg" />
				</form>
			</div><!-- body -->
		</div> <!-- portlet box -->

	</div> <!-- span12 -->

	<?php echo $this->renderPartial('//includes/tcofastmenu', $this->data)?>

</div> <!-- row-fluid -->

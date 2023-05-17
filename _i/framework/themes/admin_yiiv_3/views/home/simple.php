<div class="main_content">
<h2>歡迎登入EOB管理系統</h2>
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
<form id="searchFrm" onsubmit="searchkeyword(this);return false;" name="searchFrm" action="<?php echo $this->createUrl('memberdemand/index')?>" method="GET">
搜尋：<input size="100" id="search_keyword" name="search_keyword" value="" placeholder="請輸入" />
<br />
<br />
<img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/globe_06.jpg" />
</form>

<?php 
	$logo_img = 'images/logo_'.$this->data['ml_key'].'.png';
	if(!is_file($logo_img)) $logo_img = 'images/logo.png';
?>
<div class="logo"><a href="./"><img src="<?php echo $logo_img?>"></a></div>

<?php if((isset($mls) and count($mls) > 1 || SIMPLE_TRANSLATE) && $GLOBALS['lay_out_select']!='12' && $GLOBALS['lay_out_select']!='13' && $GLOBALS['lay_out_select']!='15'):?>
<ul class="links">
	<?php foreach($mls as $k => $v):?>
		<?php if($k == $this->data['ml_key']):?>
			<?php if($k=='tw' && SIMPLE_TRANSLATE):?>
				<li ><a id="translateLink" href="javascript:translatePage();">简体</a></li>
			<?php else:?>
				<li ><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
			<?php endif?>
		<?php else:?>
			<li ><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
		<?php endif?>
	<?php endforeach?>                
</ul>
<?php endif?>

<?php if(GOOGLE_TRANSLATE==true): //Google 翻譯器?>
<ul class="links">
	<div class="googleTranslate pc"></div>                              
</ul>
<?php endif?>

<?php if(MEMBER_OPEN==true)://會員功能?>
<ul class="links">
<?php if((isset($_SESSION['authw_admin_account']) && $_SESSION['authw_admin_account']!='')):?>
	<li><a href="index.php?r=member" ><?php echo G::t(null,'會員中心')?></a></li>
	<li><a href="index.php?r=member/logout" ><?php echo G::t(null,'會員登出')?></a></li>	
<?php else:?>
	<li><a href="" data-toggle="modal" data-target=".login"><?php echo G::t(null,'會員登錄')?></a></li>
	<li><a href="index.php?r=guest/register" ><?php echo G::t(null,'會員註冊')?></a></li>
	<li><a href="index.php?r=guest/forget" ><?php echo G::t(null,'忘記密碼')?></a></li>
<?php endif?>
</ul>
<?php endif?>
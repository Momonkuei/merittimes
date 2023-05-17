<?php if(0):?><!-- xxx_head_end -->
		<link rel="stylesheet" href="layoutv2/css/section/header_navmenu.css">
<?php endif?><!-- xxx_head_end -->

<?php if(0):?><!-- body_end -->
<script>

	$(".hamburger").click(function(){
		$(".navmenu_collapse.content").toggleClass("open");
		$("body").toggleClass("false");
		return false;
	});


	$(".navmenu_collapse.content .menu_main li>a").each(function(){
		if($(this).next("ul").length>0){
			$(this).addClass("more");
		}	
	});
	

	$(".menu_login").click(function(){
		$(".hamburger").trigger("click");
	});

</script>
<?php endif?><!-- body_end -->

<?/* //這邊是已經套程式的部分*/?>

<header class="navmenu_collapse top">
		<?php 
			$logo_img = 'images/logo_'.$this->data['ml_key'].'.png';
			if(!is_file($logo_img)) $logo_img = 'images/logo.png';
		?>
		<ul>
			<li class="logo"><a href="index.html"><img src="<?php echo $logo_img?>"></a></li>
			<li class="hamburger" data-target=".navmenu_collapse.content"><a><i></i><i></i><i></i></a></li>
		</ul>

</header>
<section class="navmenu_collapse content">

<ul class="menu_main cis3-bk-90 togglearea" data-item="li" data-title="li>a" data-content="ul" data-nodefault="true">
<?php echo $AA?>
</ul>

<?php if(isset($this->data['mls']) and count($this->data['mls']) > 1 || SIMPLE_TRANSLATE):?>
	<ul class="menu_lang">
	<?php foreach($this->data['mls'] as $k => $v):?>	
		<?php if($k == $this->data['ml_key']):?>
			<?php if($k=='tw' && SIMPLE_TRANSLATE):?>
				<li><a id="translateLink_mb" href="javascript:translatePage();">简体</a></li>
			<?php else:?>										
				<li><a href="change_language.php?lang=<?php echo $k?>">[ <?php echo $v?> ]</a></li>		
			<?php endif?>
		<?php else:?>
			<li><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
		<?php endif?>
	<?php endforeach?>
	</ul>
<?php endif?>

<?php if(0 and isset($this->data['layoutv2'][$this->data['section']['key']])):?>	

	<ul class="menu_main cis3-bk-90 togglearea" data-item="li" data-title="li>a" data-content="ul" data-nodefault="true">

		<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>	
		
				<li <?php if($v['url1'] == 'index.php?r='.$this->data['router_class'].'/'.$this->data['router_method']):?>class="active"<?php endif?>"><a href="<?php echo $v['url1']?>" <?php if(isset($v['other2']) && $v['other2']) echo 'target="'.$v['other2'].'"'?>><?php echo L::top(null,$v['topic'])?></a>
				<?php if(isset($this->data['small_menu_tmp'][$v['id']]) && count($this->data['small_menu_tmp'][$v['id']]) > 0):?>
					<ul>					
						<?php foreach($this->data['small_menu_tmp'][$v['id']] as $k1 => $v1):?>	
							<li><a href="<?php echo $v1['url']?>"><?php echo L::top(null,$v1['topic'])?></a>
							<?php if(isset($v1['sub_menu'])):?>
								<ul>
									<?php foreach($v1['sub_menu'] as $k2 => $v2):?>	
									<li>
										<a href="<?php echo $v2['url']?>"><?php echo L::top(null,$v2['topic'])?></a>
									</li>
									<?php endforeach?>								
								</ul>
							<?php endif?>
							</li>
						<?php endforeach?>
					</ul>
				<?php endif?>
				</li>
			
		<?php endforeach?>
		</ul>

	<?php if(MEMBER_OPEN==true)://會員功能?>
		<ul class="menu_main cis3-bk">					
		<?php if((isset($_SESSION['authw_admin_account']) && $_SESSION['authw_admin_account']!='')):?>
			<li><a href="index.php?r=member" ><?php echo G::t(null,'會員中心')?></a></li>
			<li><a href="index.php?r=member/logout" ><?php echo G::t(null,'會員登出')?></a></li>	
		<?php else:?>
			<li><a href="" class="menu_login" data-toggle="modal" data-target=".login"><?php echo G::t(null,'會員登錄')?></a></li>
			<li><a href="index.php?r=guest/register" ><?php echo G::t(null,'會員註冊')?></a></li>
			<li><a href="index.php?r=guest/forget" ><?php echo G::t(null,'忘記密碼')?></a></li>
		<?php endif?>
		</ul>
	<?php endif?>
	
		<ul class="menu_others cis3-bk">
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>	
				<?php if($v['pic1']):?>
				<li><a href=""><img src="/_i/assets/upload/webmenu/<?php echo $v['pic1']?>" style="float:center; width:25px; margin:0 1px 0; border:0" <?php if(isset($v['other2']) && $v['other2']) echo 'target="'.$v['other2'].'"';else echo 'target="_BREAK"'?>></a></li>
				<?php endif?>
			<?php endforeach?>
		
			<?php if(GOOGLE_TRANSLATE == true):?>
			<li>
				<div class="googleTranslate mb"></div>
			</li>			
			<?php endif?>
		</ul>
	

	<?php if(isset($mls) and count($mls) > 1 || SIMPLE_TRANSLATE):?>
		<ul class="menu_lang">
		<?php foreach($mls as $k => $v):?>	
			<?php if($k == $this->data['ml_key']):?>
				<?php if($k=='tw' && SIMPLE_TRANSLATE):?>
					<li><a id="translateLink_mb" href="javascript:translatePage();">简体</a></li>
				<?php else:?>										
					<li><a href="change_language.php?lang=<?php echo $k?>">[ <?php echo $v?> ]</a></li>		
				<?php endif?>
			<?php else:?>
				<li><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
			<?php endif?>
		<?php endforeach?>
		</ul>
	<?php endif?>
<?php endif?>

</section>


<?php  /*備份用 
<header class="navmenu_collapse top">


		<ul>
			<li class="logo"><a href=""><img src="images/logo.png"></a></li>
			<li class="hamburger" data-target=".navmenu_collapse.content"><a><i></i><i></i><i></i></a></li>
		</ul>


</header>
<section class="navmenu_collapse content">

		<ul class="menu_main cis3-bk-90 togglearea" data-item="li" data-title="li>a" data-content="ul" data-nodefault="true">
			<li><a href="">公司簡介</a>
				<ul>
					<li class="active"><a href="">子選單</a></li>
					<li><a href="">子選單</a></li>
					<li><a href="">子選單*</a>
						<ul>
							<li><a href="">子子選單</a></li>
							<li><a href="">子子選單*</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li><a href="">公司簡介</a></li>
			<li><a href="">公司簡介</a></li>
		</ul>

		<ul class="menu_main cis3-bk">					
			<li><a href="">會員登入</a></li>
			<li><a href="">會員註冊</a></li>
			<li><a href="">忘記密碼</a></li>
		</ul>

		<ul class="menu_others cis3-bk">
			<li><a href=""><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a></li>
			<li><a href=""><img src="images/social_ico_facebook.png"></a></li>
			<li><a href=""><img src="images/social_ico_line.png"></a></li>
			<li><a href=""><img src="images/social_ico_googleplus.png"></a></li>
			<li>
				<div id="google_translate_element"></div>
				<script type="text/javascript">function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage: 'tw',  layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element'); }</script>
				<script type="text/javascript" src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
			</li>
		</ul>

		<ul class="menu_lang">
			<li><a href="">EN</a></li>
			<li><a href="">中文</a></li>	
		</ul>


</section>
*/?>

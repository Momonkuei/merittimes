<?php
/*
 * https://redmine.buyersline.com.tw/issues/42811
 * 政佳新增的 樣式 cowboySidemenu_2
 */
$_sidemenu_title = '我是側選單標題';
if($this->data['router_method']=='product'){
  $_sidemenu_title = t('Product Categories');
}
if($this->data['router_method']=='shop'){
  $_sidemenu_title = t('Shop Categories');
}
?>

<div class="boxTitle">
	<span><?php echo $_sidemenu_title?></span>
</div>

<ul class="cowboySidemenu_2" l="layer" ls="lll" debug="">
	<li l="list" attr1="">
		<a attr2="">{/pic2_src/}{/name/}</a>
		{/child/}		
	</li>
	<ul class="submenu" l="box">{split}</ul>
	<li class="moremenu">
		<a class="active" href="javascript:;">十上力牠目木幾</a>
		<ul class="submenu">
			<li>
				<a class="active" href="javascript:;">現語那到水晚穿今</a>
			</li>
			<li>
				<a href="javascript:;">助今占但他邊斗</a>
			</li>
			<li>
				<a href="javascript:;">造拉結朋雨秋重春升</a>
			</li>
		</ul>
	</li>
	<li>
		<a href="javascript:;">你完未片月</a>
	</li>
	<li class="moremenu">
		<a href="javascript:;">Lorem ipsum dolor sit amet</a>
		<ul class="submenu">
			<li class="moremenu">
				<a href="javascript:;">Vivamus sit amet</a>
				<ul class="submenu">
					<li>
						<a href="javascript:;">Nulla eu leo</a>
					</li>
					<li>
						<a href="javascript:;">Donec porta ullamcorper</a>
					</li>
					<li>
						<a href="javascript:;">Vestibulum eleifend</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:;">Duis vel dapibus neque</a>
			</li>
			<li>
				<a href="javascript:;">Ut facilisis</a>
			</li>
		</ul>
	</li>
</ul>



<?php if(0):?><!-- body_end -->
<script>
	if($('.cowboySidemenu_2').length){
		$(window).on('load',function(){
			$('.cowboySidemenu_2 .submenu').parent('li').addClass('moremenu');
			$('.cowboySidemenu_2 .submenu').siblings('a').removeAttr('href').attr('href', 'javascript:;');

			$('.cowboySidemenu_2 .submenu').hide();
			$('.cowboySidemenu_2 a.active').addClass('open');
			$('.cowboySidemenu_2 a.active').parents('.submenu').siblings('a').addClass('active open');
			$('.cowboySidemenu_2 a.active').parents('.submenu').addClass('open').show();
			$('.cowboySidemenu_2 a.active').siblings('.submenu').addClass('open').show();
		});

		$('.cowboySidemenu_2 a').click(function(){
			if($(this).hasClass('open')){
				$(this).removeClass('open');
				$(this).siblings('.submenu').removeClass('open').slideUp(200);
				$(this).siblings('.submenu').find('.open').removeClass('open');
				$(this).siblings('.submenu').find('.submenu').slideUp(200);
			} else {
				$(this).addClass('open');
				$(this).siblings('.submenu').addClass('open').slideDown(200);
			}
		});
	}
</script>
<?php endif?><!-- body_end -->
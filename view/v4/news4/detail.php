<?php if(0)://lota?>
<?php if(!isset($client_id)):?>
	<?php include '_i/config/facebook.php'?>
<?php endif?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.10&appId=<?php echo $client_id?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php endif?>

<meta property="og:url"           content="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" m="head_end" />
<meta property="og:type"          content="website"  m="head_end" />
<meta property="og:title"         content="<?php echo $data[$ID]['name']?>"  m="head_end" />
<meta property="og:description"   content="<?php echo strip_tags($data[$ID]['content'])?>"  m="head_end"  />
<?php if(isset($data[$ID]) and isset($data[$ID]['pic']) and $data[$ID]['pic'] != ''):?>
	<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN.'/'.$data[$ID]['pic']?>"  m="head_end"  />
<?php else:?>
	<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN?>/images/fb_share.jpg" m="head_end"/>
<?php endif?>

<div class="Bbox_flexBetween">
  <div class="dateStyle_2">
	<?php if(0)://#42738?>
		<span class="dateD"><?php echo $data[$ID]['day']?></span>
		<span class="dateM"><?php echo $data[$ID]['month']?></span>
		<span class="dateY"><?php echo $data[$ID]['year']?></span>
	<?php endif?>
  </div>
	<?php if(isset($data[$ID]['sub_name']) and $data[$ID]['sub_name'] != ''):?>
		<a href="<?php if(isset($data[$ID]['sub_url']) and $data[$ID]['sub_url'] != ''):?><?php echo $data[$ID]['sub_url']?><?php else:?>javascript:;<?php endif?>" class="iconTxt"><i class="fa fa-folder" aria-hidden="true"></i><span><?php echo $data[$ID]['sub_name']?></span></a>
	<?php endif?>
</div><!-- .Bbox_flexBetween -->

<?php if(0)://#42738?>
<div class="share_social">
  <ul>
    <li><span class="social_txt"><?php echo t('分享')?></span></li>
	<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>&appId="><img src="images/default/icon_fb.svg" alt=""></a></li>
	<li><a target="_blank" href="https://social-plugins.line.me/lineit/share?url=<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>"><img src="images/default/icon_line.svg" alt=""></a></li>
	<li><a target="_blank" href="https://twitter.com/share"><img src="images/default/icon_twitter.svg" alt=""></a></li>
	<li><div class="btn_clipboard"><img src="images/default/icon_clipboard.svg" alt=""></div></li>
  </ul>
</div><!-- .share_social -->
<?php endif?>

<div class="newsD_main">
	<?php if($data[$ID]['pic2']!=''):?>
		<div class="newD_img"><img class="rwd_img" src="_i/assets/upload/<?php echo str_replace('detail','',$this->data['router_method'])?>/<?php echo $data[$ID]['pic2']?>" alt=""></div>
	<?php endif?>

	<div class="blockTitle"><span><?php echo $data[$ID]['name']?></span></div>

	<div class="editor">
		<?php echo $data[$ID]['content']?>
	</div>

	<?php if($data[$ID]['pic3']!=''):?>
		<?php $class = 'rwd_img'?>
		<?php if($data[$ID]['other10'] == '2'):?>
			<?php $class = 'img-responsive'?>
		<?php endif?>
		<div class="newD_img"><img class="<?php echo $class?>" src="_i/assets/upload/<?php echo str_replace('detail','',$this->data['router_method'])?>/<?php echo $data[$ID]['pic3']?>" alt=""></div>
	<?php endif?>

	<?php
	$rows = $this->cidb->where('is_enable',1)->where('type',str_replace('detail','content',$this->data['router_method']))->where('class_id',$data[$ID]['id'])->order_by('sort_id')->get('html')->result_array();
	?>
	<?php if($rows and !empty($rows)):?>
		<?php foreach($rows as $k => $v):?>
			<div class="editor">
				<?php echo $v['detail']?>
			</div>

			<?php if($v['pic1']!=''):?>
				<?php $class = 'rwd_img'?>
				<?php if($v['other10'] == '2'):?>
					<?php $class = 'img-responsive'?>
				<?php endif?>
				<div class="newD_img"><img class="<?php echo $class?>" src="_i/assets/upload/<?php echo str_replace('detail','content',$this->data['router_method'])?>/<?php echo $v['pic1']?>" alt=""></div>
			<?php endif?>
		<?php endforeach?>
	<?php endif?>

</div><!-- .newsD_main -->

<?php 
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('fb_board').';');
if($_constant_1):?>
<div class="fb-comments" data-href="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" data-numposts="10"></div>
<?php endif?>

<?php //#42738?>
<div class="dateStyle_2">
	<span class="dateD"><?php echo $data[$ID]['day']?></span>
	<span class="dateM"><?php echo $data[$ID]['month']?></span>
	<span class="dateY"><?php echo $data[$ID]['year']?></span>
</div>

<div class="text-center">
	<a href="<?php echo $data[$ID]['url']?>" class="btn-cis1"><i class="fa fa-reply" aria-hidden="true"></i><?php echo $data[$ID]['url_name']?></a>
</div>

<div class="pageControl">
	<a href="<?php echo $data[$ID]['url_prev']?>" class="btn-gray btn-prev <?php echo $data[$ID]['url_prev_disabled']?>"><i class="fa fa-chevron-left"></i><?php echo t('上一則')?></a>
	<a href="<?php echo $data[$ID]['url_next']?>" class="btn-gray btn-next <?php echo $data[$ID]['url_next_disabled']?>"><?php echo t('下一則')?><i class="fa fa-chevron-right"></i></a>
</div>

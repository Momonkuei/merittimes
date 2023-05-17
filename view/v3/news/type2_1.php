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
<?php endif?>

<section class="pageDetail ">
	<div>
		<div>
			<div class="item">
				<div class="Bbox_flexBetween">
					<div class="dateStyle">
						<span class="dateD"><?php echo $data[$ID]['day']?></span>
						<span class="dateM"><?php echo $data[$ID]['month']?></span>
						<span class="dateY"><?php echo $data[$ID]['year']?></span>
					</div>
					<?php if(isset($data[$ID]['sub_name']) and $data[$ID]['sub_name'] != ''):?>
						<a href="<?php if(isset($data[$ID]['sub_url']) and $data[$ID]['sub_url'] != ''):?><?php echo $data[$ID]['sub_url']?><?php else:?>javascript:;<?php endif?>" class="iconTxt"><i class="fa fa-folder"></i><span><?php echo $data[$ID]['sub_name']?></span></a>
					<?php endif?>
				</div>
				<div class="share_social">
			    <ul>
					<li><span class="social_txt">分享</span></li>
			      <li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>&appId="><img src="images/default/icon_fb.svg" alt=""></a></li>
				  <li><a target="_blank" href="https://social-plugins.line.me/lineit/share?url=<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>"><img src="images/default/icon_line.svg" alt=""></a></li>
			      <li><a target="_blank" href="https://twitter.com/share"><img src="images/default/icon_twitter.svg" alt=""></a></li>
			      <li><div class="btn_clipboard"><img src="images/default/icon_clipboard.svg" alt=""></div></li>
			    </ul>
			  </div><!-- .share_social -->
			  	<?php if($data[$ID]['pic']!=''):?>
				<div class="itemImg">
				    <img src="<?php echo $data[$ID]['pic']?>">
				</div>
				<?php endif?>

				<?php 
				// #34410
				unset($_constant);
				eval('$_constant = '.strtoupper('seo_open').';');
				if($_constant){
					$_sptxt = 'h1';
				}else{
					$_sptxt = 'div';
				}
				?>

				<div>
					<<?php echo $_sptxt?> class="itemTitle"> <span><?php echo $data[$ID]['name']?></span> </<?php echo $_sptxt?>>
					<div class="itemContent">
						<div class="editorBlock">
							<?php echo $data[$ID]['content']?>
						</div>
					</div>
				</div>

				<?php 
				unset($_constant);
				eval('$_constant = '.strtoupper('fb_board').';');
				if($_constant):
				?>
				<div class="fb-comments" data-href="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" data-numposts="10"></div>
				<?php endif?>

				<div class="text-center">
					<a href="<?php echo $data[$ID]['url']?>" class="btn-cis1"><i class="fa fa-reply"></i><?php echo $data[$ID]['url_name']?></a>
				</div>
			</div>
			<div class="pageControl">
				<a href="<?php echo $data[$ID]['url_prev']?>" class="btn-prev <?php echo $data[$ID]['url_prev_disabled']?>"><i class="fa fa-chevron-left"></i><?php echo t('上一則')?></a>
				<a href="<?php echo $data[$ID]['url_next']?>" class="btn-next <?php echo $data[$ID]['url_next_disabled']?>"><?php echo t('下一則')?><i class="fa fa-chevron-right"></i></a>
			</div>
		</div>
	</div>
</section>


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

<section class="pageDetail ">
	<div>
		<div>
			<div class="item">				
				<?php if(0):?>
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
				<?php endif?>
				
				<div class="itemImg">
				    <img src="<?php echo $data[$ID]['pic']?>">
				</div>

				<div>
					<div class="itemTitle"> <span><?php echo $data[$ID]['name']?></span> </div>
					<div class="itemContent">
						<div class="editorBlock">
							<?php echo $data[$ID]['content']?>
						</div>						
					</div>						
				</div>	

				<?php if(0):?>
					<div class="fb-comments" data-href="<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>" data-numposts="10"></div>

					<div>
						<a href="<?php echo $data[$ID]['url']?>" class="btn-cis1"><i class="fa fa-reply"></i><?php echo $data[$ID]['url_name']?></a>
					</div>
				<?php endif?>
			</div>

			<?php if(0):?>
				<div class="pageControl">
					<a href="<?php echo $data[$ID]['url_prev']?>" class="btn-prev <?php echo $data[$ID]['url_prev_disabled']?>"><i class="fa fa-chevron-left"></i><?php echo t('上一則')?></a>
					<a href="<?php echo $data[$ID]['url_next']?>" class="btn-next <?php echo $data[$ID]['url_next_disabled']?>"><?php echo t('下一則')?><i class="fa fa-chevron-right"></i></a>
				</div>
			<?php endif?>
		</div>
	</div>
</section>			

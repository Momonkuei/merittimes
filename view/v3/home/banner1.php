<?php // if(preg_match('/^index/', basename($_SERVER['REQUEST_URI'],'.php')) or basename($_SERVER['REQUEST_URI'],'.php') == ''):?>

<?php if($this->data['router_method'] == 'index'):?>

<?php 
	/* 設定 scrolldown 的形式	 
	 * 0 無
	 * 1 一般圖檔 (scrolldown.svg)
	 * 2 影格動畫 (scrolldown_frame.svg)
	 */
	$scrollDownType = 2;
	
	/* 影格動畫的設定 (選2才要設定)
	 * 說明：
	 * frames:影格數
	 * playtime:動畫時間
	 * w:一格影格 寬 (px)
	 * h:一格影格 高 (px)
	 * animateName:動畫名稱
	 *
	 * $scrollDownFrameData='{"frames":6,"playtime":"1s","w":50,"h":50,"animateName":"scrollDown"}';
	 */
	$scrollDownFrameData = '{"frames":6,"playtime":"1s","w":50,"h":50,"animateName":"scrollDown"}';
?>


<?php 
/*
 * 這個是首頁的Banner
 */
?>
<section class="bannerBlock">
	<section class="banner slideBanner">		
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<?php if(0)://SEO?>
					<?php $alt = ''?>
					<?php if($k == 0):?>
						<?php $alt = '台北防水工程'?>
					<?php elseif($k == 1):?>
						<?php $alt = '台北防水抓漏'?>
					<?php endif?>
					<?php $v['topic'] = $alt?>
				<?php endif?>
				<div class="slideItem"><?php if($v['url']!=''):?><a href="<?php echo $v['url']?>"><?php endif?><img src="<?php echo $v['pic1g']?>" class="pc" alt="<?php echo $v['topic']?>"><img src="<?php echo $v['pic2g']?>" class="mb" alt="<?php echo $v['topic']?>"></a></div>
			<?php endforeach?>
		<?php endif?>

		<?php if(0):?>
			<div class="slideItem"><a href=""><img src="images/indexBanner.jpg" class="pc"><img src="images/indexBanner_mb.jpg" class="mb"></a></div>
			<div class="slideItem"><a href=""><img src="images/indexBanner.jpg" class="pc"><img src="images/indexBanner_mb.jpg" class="mb"></a></div>
		<?php endif?>
	</section>

	<?php /*img的scrolldown */ ?>
	<?php if($scrollDownType==1):?>	
		<section class="scrollDown" data-scrollTo="[class^='indexContent']">	
			<div> 
				<img src="images/<?php echo $this->data['ml_key']?>/scrolldown.svg"> 
			</div>
		</section>
	<?php endif // end img ?>			
		
	<?php /* 影格動畫(需製作連續圖) */ ?>
	<?php if($scrollDownType==2):?>	
		<section class="scrollDown" data-scrollTo="[class^='indexContent']">	
			<div class="playFrame" data-playFrame="js" data-playFrameData='<?php echo $scrollDownFrameData?>'>		
				<img src="images/<?php echo $this->data['ml_key']?>/scrolldown_frame.svg"> 
			</div>
		</section>
	<?php endif //end frame ?>

</section>

<?php else:?>
<?php 
/*
 * 這個是內頁的Banner
 */
?>
	<section class="banner bgFix">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<img src="<?php echo $v['pic1g']?>" class="pc">
				<img src="<?php echo $v['pic2g']?>" class="mb">
			<?php endforeach?>
		<?php endif?>

		<?php if(0):?>
			<!--視差 banner-->
			<img src="images/tw/pageBanner.jpg" class="pc">
			<img src="images/tw/pageBanner_mb.jpg" class="mb">
		<?php endif?>
	</section>
<?php endif?>

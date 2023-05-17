<?php 
	/*
	 * 設定 scrolldown 的形式 
	 * 0 無
	 * 1 一般圖檔 (loading.gif)
	 * 2 影格動畫 (loading_frame.svg)
	*/
	$pageLoadingType = 1; 

	/* 影格動畫的設定 (選2才要設定)
	 * 說明：
	 * frames:影格數
	 * playtime:動畫時間 (ex: 1s、500ms )
	 * w:一格影格 寬 (px)
	 * h:一格影格 高 (px)
	 * animateName:動畫名稱
	 *
	 * $pageLoadingFrameData='{"frames":30,"playtime":"1s","w":100,"h":100,"animateName":"pageLoading"}';
	 */
	$pageLoadingFrameData = '{"frames":8,"playtime":"800ms","w":100,"h":100,"animateName":"pageLoading"}';
?>


<?php 
/*
 * 這個是img的loading 
 */
?>
<?php if($pageLoadingType==1):?>	
	<section class="pageLoading">
		<div class="">
			<img src="images/<?php echo $this->data['ml_key']?>/loading.gif">
		</div>
	</section>
<?php endif;?>




<?php 
/* 
 * 影格動畫(需製作連續圖)
 */
?>

<?php if($pageLoadingType==2):?>	
	<section class="pageLoading">
		<div class="playFrame" 
			 data-playFrame="js" 
			 data-playFrameData='<?php echo $pageLoadingFrameData?>'>			 
			 <img src="images/<?php echo $this->data['ml_key']?>/loading_frame.svg">			
		</div>	
	</section>
<?php endif?>

<div class="videoList">
	<div class="itemList Bbox_in_3c">
		<div>
			<?php if(0):?>
				<?php if(isset($data[$ID])):?>
					<?php foreach($data[$ID] as $k => $v):?>
					<?php 
					//2021-06-24 經理來電說要兩種分享模式通用 by lota
					if(stristr($v['url1'],'https://youtu.be/')){
						$v['url1'] = 'https://www.youtube.com/watch?v='.str_replace('https://youtu.be/','',$v['url1']);
					}
					if(stristr($v['url2'],'https://youtu.be/')){
						$v['url2'] = 'https://www.youtube.com/watch?v='.str_replace('https://youtu.be/','',$v['url2']);
					}
					?>
						<div class="item">
							<a class="swipebox-video" href="<?php echo $v['url1']?>" rel="album<?php echo $ID?>" title="<?php echo $v['name1']?>">
								<div class="itemImg">
									<img src="<?php echo $v['pic']?>">
								</div>
							</a>
							<a class="swipebox-video" href="<?php echo $v['url2']?>" rel="album<?php echo $ID?>" title="<?php echo $v['name2']?>">									
								<div class="itemTitle"> <span><?php echo $v['name3']?></span></div>
								<div class="dateStyle">
									<i class="fa fa-calendar-o"></i>
									<span class="dateD"><?php echo $v['day']?></span>
									<span class="dateM"><?php echo $v['month']?></span>
									<span class="dateY"><?php echo $v['year']?></span>
								</div>
								
							</a>
						</div>
					<?php endforeach?>
				<?php endif?>
			<?php endif?>

			<?php // 2020-08-05 政佳?>
			<?php // 這個是為了支援MP4，才做替換?>
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<?php // 只差在前二行不一樣?>
					<?php if(preg_match('/\.(mp4|MP4)$/',$v['url1'])):?>
						<div id="html5-videos<?php echo $k?>" class="html5-videos item">
							<a data-sub-html="video caption1" data-html="#video<?php echo $v['id']?>" herf="javascript:;">
					<?php else:?>
						<div id="video-gallery<?php echo $k?>" class="video-gallery item">
							<a href="<?php echo $v['url1']?>" >
					<?php endif?>

							<div class="videoImg"><img src="<?php echo $v['pic']?>" /></div>
							<p><?php echo $v['name1']?></p>
							<?php if($v['start_date'] != ''):?>
								<div class="dateStyle">
									<i class="fa fa-calendar-o"></i>
									<span class="dateD"><?php echo $v['day']?></span>
									<span class="dateM"><?php echo $v['month']?></span>
									<span class="dateY"><?php echo $v['year']?></span>
								</div>
							<?php endif?>
						</a>
					</div>
				<?php endforeach?>
			<?php endif?>

		</div>
	</div>
</div>

<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
		<?php if(preg_match('/\.(mp4|MP4)$/',$v['url1'])):?>
			<div style="display:none;" id="video<?php echo $v['id']?>">
				<video class="lg-video-object lg-html5" controls preload="none">
					<source src="<?php echo $v['url1']?>" type="video/mp4">
					 Your browser does not support HTML5 video.
				</video>
			</div>
		<?php endif?>
	<?php endforeach?>
<?php endif?>

<div class="newsList newsListType19">
	<div class="row">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
		<div class="newsContent col-md-6 col-lg-4">
			<div class="item">
					<div class="date"><?php echo $v['year']?>.<?php echo $v['month']?>.<?php echo $v['day']?></div>
					<span class="classified"><?php echo $v['name2']?></span>						
					<div class="textBox">
					<a href="<?php echo $v['url1']?>"><div class="itemTitle"><?php echo $v['name']?></div></a>
						<?php if(1): //預留簡述文字?>
						<div class="itemContent"><?php echo $v['content']?></div>
						<?php endif?>
					</div>
					
				</div>
				<div class="linkBox btnLink">
				<a href="<?php echo $v['url1']?>"><span class="more">了解更多</span></a>
				</div>															
		</div>
		<?php endforeach?>
	<?php endif?>
	<?php if(0):?>
		<div class="col-md-6 col-lg-4">
			<div class="item">
				<a href="">
					<div class="imgBox">
						<div class="itemImg">
							<img src="_i/assets/upload/news/c2ceab7455426b6bb27c4dece35b3d94.jpg">
						</div>
						<span class="classified">新聞分類</span>						
					</div>
					<div class="textBox">
						<div class="itemTitle">測試最新消息測試最新消息測試最新消息測試最新消息測試最新消息</div>
						<?php if(0):?>
						<div class="itemContent">最新消息簡述文字最新消息簡述文字最新消息簡述文字最新消息簡述文字最新消息簡述文字最新消息簡述文字最新消息簡述文字最新消息簡述文字最新消息簡述文字最新消息簡述文字</div>
						<?php endif?>
					</div>
					<div class="linkBox">
						<span class="date">2021.12.25</span>
						<span class="more">了解更多</span>
					</div>															
				</a>
			</div>
		</div>

				<div class="col-md-6 col-lg-4">
			<div class="item">
				<a href="">
					<div class="imgBox">
						<div class="itemImg">
							<img src="_i/assets/upload/news/c2ceab7455426b6bb27c4dece35b3d94.jpg">
						</div>
						<span class="classified">新聞分類</span>						
					</div>
					<div class="textBox">
						<div class="itemTitle">測試最新消息2</div>
						<?php if(0):?>
						<div class="itemContent">最新消息簡述文字</div>
						<?php endif?>
					</div>
					<div class="linkBox">
						<span class="date">2021.12.25</span>
						<span class="more">了解更多</span>
					</div>															
				</a>
			</div>
		</div>
	<?php endif?>


	</div>
</div>

[POS1]

<section class="Bbox_1c">
	<div>
		<div class="indexAbout_w13">
			<div>
				 <div class="itemImg">
					<?php if(isset($this->data['sys_configs']['pic1_'.$this->data['ml_key']])):?>
						<?php echo '<img src="_i/assets/upload/companyother/'.$this->data['sys_configs']['pic1_'.$this->data['ml_key']].'">'?>
					<?php endif?>
				 				 	
				 	<img src="images/w13/indexAbout_w13_bg.svg" class="itemDeco">				 	
				 </div>
			</div>
			<div class="itemContent">
				<div class="blockTitle"><?php if(isset($this->data['sys_configs']['companyother_title_'.$this->data['ml_key']])) echo $this->data['sys_configs']['companyother_title_'.$this->data['ml_key']]?></div>
				<p>
					<?php if(isset($this->data['sys_configs']['companyother_text_'.$this->data['ml_key']])) echo $this->data['sys_configs']['companyother_text_'.$this->data['ml_key']]?>
				</p>
			</div>
		</div>
	</div>
</section> 


<section class="Bbox_1c">
	<div>
		<div class="indexNews_w13">
			<div>
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['banner2'])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']]['banner2'] as $k => $v):?>
				 		<div class="itemImg"><a href="<?php echo $v['url']?>"><img src="<?php echo $v['pic']?>"></a></div>
					<?php endforeach?>
				<?php endif?>
			</div>
			<div class="itemContent">
				<div class="blockTitle"><?php echo G::t(null,'NEWS')?></div>
				<ul>
					<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['news'])):?>
						<?php foreach($this->data['layoutv2'][$this->data['section']['key']]['news'] as $k => $v):?>
							<li><a href="<?php echo $v['url']?>"><label class="itemDate"><?php echo $v['title2']?></label><p><?php echo $v['title']?></p></a></li>
						<?php endforeach?>
					<?php endif?>
					
				</ul>
				<div class="text-right"><a href="<?php echo $this->createUrl('site/news')?>" class="itemMore"><?php echo G::t(null,'more')?>...</a></div>
			</div>
		</div>
	</div>
</section>


<?php /* //備份用
<section class="Bbox_1c">
	<div>
		<div class="indexAbout_w13">
			<div>
				 <div class="itemImg">
				 	<img src="images/banner.jpg">				 	
				 	<img src="images/w13/indexAbout_w13_bg.svg" class="itemDeco">				 	
				 </div>
			</div>
			<div class="itemContent">
				<div class="blockTitle">LET OUR SAUNA'S WARMTH WORK FOR YOU!</div>
				<p>
					成立1960年，歐洲最大光電產業先驅，1979年開始拓展世界市場專住於相關電子零件產品，總員工超過1000人，1985年於台灣設立分公司，採用專業設備生產一流的電子產品，並通過ISO9001等相關認證，提供3C工業等相關產業品需求，強化企業品牌給予消費者使用有專業的等級。
				</p>
			</div>
		</div>
	</div>
</section> 


<section class="Bbox_1c">
	<div>
		<div class="indexNews_w13">
			<div>
				 <div class="itemImg"><a href=""><img src="images/banner.jpg"></a></div>
				 <div class="itemImg"><a href=""><img src="images/banner.jpg"></a></div>
				 <div class="itemImg"><a href=""><img src="images/banner.jpg"></a></div>				
				 <div class="itemImg"><a href=""><img src="images/banner.jpg"></a></div>
				 <div class="itemImg"><a href=""><img src="images/banner.jpg"></a></div>
				 <div class="itemImg"><a href=""><img src="images/banner.jpg"></a></div>
			</div>
			<div class="itemContent">
				<div class="blockTitle">NEWS</div>
				<ul>
					<li><a href=""><label class="itemDate">2015.12.31</label><p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></a></li>
					<li><a href=""><label class="itemDate">2015.12.31</label><p>xxxxx</p></a></li>
					<li><a href=""><label class="itemDate">2015.12.31</label><p>xxxxx</p></a></li>
					<li><a href=""><label class="itemDate">2015.12.31</label><p>xxxxx</p></a></li>
					<li><a href=""><label class="itemDate">2015.12.31</label><p>xxxxx</p></a></li>
				</ul>
				<div class="text-right"><a href="" class="itemMore">more...</a></div>
			</div>
		</div>
	</div>
</section> 
*/?>
	[POS1]
		<?/*
		<ul class="list-inline">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<?php if(preg_match('/2/i',$v['field_tmp'])):?>
					<li><a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a></li>
					<?php endif?>
				<?php endforeach?>
			<?php endif?>
		 </ul>
		 */?>
		 		<div class="Bbox_in_2c_L8">
		 			<div>
		 				<div>
						<!-- // -->
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<div class="footer__Menu">	
			<?php if(count($this->data['layoutv2'][$this->data['section']['key']]) < 7):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<?php if(preg_match('/2/i',$v['field_tmp'])):?>						
						<div class="UlItem">
							<div class="UlItem__Title">
								<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
							</div>							
						</div>						
					<?php endif?>
				<?php endforeach?>
			<?php else:?>
				<div class="UlItem">
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					
						<?php if($k%4==0):?>
							<?php if(preg_match('/2/i',$v['field_tmp'])):?>	
								<div class="UlItem__Title">
									<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
								</div>	
							<?php endif?>
						<?php endif?>
					
					<?php endforeach?>
				</div>

				<div class="UlItem">
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					
						<?php if($k%4==1):?>
							<?php if(preg_match('/2/i',$v['field_tmp'])):?>	
								<div class="UlItem__Title">
									<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
								</div>	
							<?php endif?>
						<?php endif?>
					
					<?php endforeach?>
				</div>

				<div class="UlItem">
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					
						<?php if($k%4==2):?>
							<?php if(preg_match('/2/i',$v['field_tmp'])):?>	
								<div class="UlItem__Title">
									<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
								</div>	
							<?php endif?>
						<?php endif?>
					
					<?php endforeach?>
				</div>

				<div class="UlItem">
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					
						<?php if($k%4==3):?>
							<?php if(preg_match('/2/i',$v['field_tmp'])):?>	
								<div class="UlItem__Title">
									<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
								</div>	
							<?php endif?>
						<?php endif?>
					
					<?php endforeach?>
				</div>
			<?php endif?>
			</div>
		<?php endif?>
			<!-- // -->
<?php /* //備份用
公司簡介
Q&A
最新消息
聯絡我們
產品介紹
電子型錄
*/?>
</div>
		 				<div class="footer__SocialArea">
				<div class="footer__map">
				<img src="images/demo_map.png" alt=""></div>
				<!--<div class="footer__social">
					<a href="javascript:void(0);"><img src="images/demo_social_icon_twitter.png" alt=""></a>
					<a href="javascript:void(0);"><img src="images/demo_social_icon_facebook.png" alt=""></a>
					<a href="javascript:void(0);"><img src="images/demo_social_icon_youtube.png" alt=""></a>
					<a href="javascript:void(0);"><img src="images/demo_social_icon_ig.png" alt=""></a>
				</div>
				<div class="footer__contact">
					<a href="javascript:void(0);">Contact US</a>
				</div>
			</div> -->

		 			</div>
		 			




		 		</div>


<?php /*
		<div class="footerArea">
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<div class="footer__Menu">	
			<?php if(count($this->data['layoutv2'][$this->data['section']['key']]) < 7):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<?php if(preg_match('/2/i',$v['field_tmp'])):?>						
						<div class="UlItem">
							<div class="UlItem__Title">
								<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
							</div>							
						</div>						
					<?php endif?>
				<?php endforeach?>
			<?php else:?>
				<div class="UlItem">
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					
						<?php if($k%4==0):?>
							<?php if(preg_match('/2/i',$v['field_tmp'])):?>	
								<div class="UlItem__Title">
									<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
								</div>	
							<?php endif?>
						<?php endif?>
					
					<?php endforeach?>
				</div>

				<div class="UlItem">
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					
						<?php if($k%4==1):?>
							<?php if(preg_match('/2/i',$v['field_tmp'])):?>	
								<div class="UlItem__Title">
									<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
								</div>	
							<?php endif?>
						<?php endif?>
					
					<?php endforeach?>
				</div>

				<div class="UlItem">
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					
						<?php if($k%4==2):?>
							<?php if(preg_match('/2/i',$v['field_tmp'])):?>	
								<div class="UlItem__Title">
									<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
								</div>	
							<?php endif?>
						<?php endif?>
					
					<?php endforeach?>
				</div>

				<div class="UlItem">
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					
						<?php if($k%4==3):?>
							<?php if(preg_match('/2/i',$v['field_tmp'])):?>	
								<div class="UlItem__Title">
									<a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a>
								</div>	
							<?php endif?>
						<?php endif?>
					
					<?php endforeach?>
				</div>
			<?php endif?>
			</div>
		<?php endif?>
*/?>
			<?php /* //備份用
			<div class="footer__Menu">
				<div class="UlItem">
					<div class="UlItem__Title">
						<a href="javascript:void(0);">關於DEMO</a>
					</div>
					<ul>
						<li><a href="javascript:(0);">關於DEMO</a></li>
						<li><a href="javascript:(0);">系統服務</a></li>
					</ul>
					<div class="UlItem__Title">
						<a href="javascript:void(0);">最新消息</a>
					</div>
					<ul>
						<li><a href="javascript:(0);">最新消息</a></li>
						<li><a href="javascript:(0);">新品上市</a></li>
					</ul>
				</div>
				<div class="UlItem">
					<div class="UlItem__Title">
						<a href="javascript:void(0);">代理品牌</a>
					</div>
					<ul>
						<li><a href="javascript:(0);">NIKE</a></li>
						<li><a href="javascript:(0);">PUMA</a></li>
						<li><a href="javascript:(0);">ADDIDAS</a></li>
						<li><a href="javascript:(0);">REEBOK</a></li>
					</ul>
				</div>
				<div class="UlItem">
					<div class="UlItem__Title">
						<a href="javascript:void(0);">線上循價</a>
					</div>
				</div>
				<div class="UlItem">
					<div class="UlItem__Title">
						<a href="javascript:void(0);">常見問題</a>
					</div>
					<div class="UlItem__Title">
						<a href="javascript:void(0);">連結DEMO</a>
					</div>
					<div class="UlItem__Title">
						<a href="javascript:void(0);">員工專區</a>
					</div>
				</div>
			</div>
			*/?>
			<?php /*
			<div class="footer__SocialArea">
				<div class="footer__map">
				<img src="images/demo_map.png" alt=""></div>
				<div class="footer__social">
					<a href="javascript:void(0);"><img src="images/demo_social_icon_twitter.png" alt=""></a>
					<a href="javascript:void(0);"><img src="images/demo_social_icon_facebook.png" alt=""></a>
					<a href="javascript:void(0);"><img src="images/demo_social_icon_youtube.png" alt=""></a>
					<a href="javascript:void(0);"><img src="images/demo_social_icon_ig.png" alt=""></a>
				</div>
				<div class="footer__contact">
					<a href="javascript:void(0);">Contact US</a>
				</div>
			</div>
		</div>
		*/?>
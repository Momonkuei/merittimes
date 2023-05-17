[POS1]

<?/*
	最新消息固定五則
*/?>

<section class="Bbox_1c">
	<div>
		<div class="indexNews_w15">
			<div>
		 		<div class="itemImg"><a href=""><img src="images/w15/index-sample-2.jpg"></a></div>
			</div>
			<div class="itemContent">
				<div class="itemTitleBlock"><div class="blockTitle"><?php echo G::t(null,'NEWS')?></div></div>
				<ul>
					<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['news'])):?>
						<?php foreach($this->data['layoutv2'][$this->data['section']['key']]['news'] as $k => $v):?>
							<li><a href="<?php echo $v['url']?>"><p><?php echo $v['title']?></p></a></li>
						<?php endforeach?>
					<?php endif?>
							
					
				</ul>
				
			</div>
		</div>
	</div>
</section>



<section class="Bbox_1c">
	<div>
		<div class="indexAbout_w15">
			<div>
				 <div class="itemImg">
					<?php if(isset($this->data['sys_configs']['pic1_'.$this->data['ml_key']])):?>
						<?php echo '<img src="_i/assets/upload/companyother/'.$this->data['sys_configs']['pic1_'.$this->data['ml_key']].'">'?>
					<?php endif?>
				 </div>
			</div>
			<div class="itemContent">
				<div class="blockTitle"><?php if(isset($this->data['sys_configs']['companyother_title_'.$this->data['ml_key']])) echo $this->data['sys_configs']['companyother_title_'.$this->data['ml_key']]?></div>
				<p>
					<?php if(isset($this->data['sys_configs']['companyother_text_'.$this->data['ml_key']])) echo $this->data['sys_configs']['companyother_text_'.$this->data['ml_key']]?>
				</p>
				<a href="" class="btn-more">read more</a>
			</div>
		</div>
	</div>
</section> 



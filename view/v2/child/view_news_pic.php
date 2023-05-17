[POS1]
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>	
				<article class="Bbox_sin_1c_2cL4">
				<div style="border-bottom:1px solid #eee">
					<div>
						<a href="<?php echo $this->createUrl('site/'.$this->data['router_method'].'detail',array('id'=>$v['class_id'],'id2'=>$v['id']))?>">
						<?php if($v['pic1']):?>
						<p><img src="<?php echo '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1']?>" class="img-responsive"></p>
						<?php else:?>
						<p><img src="/images/demo.jpg" class="img-responsive"></p>
						<?php endif?>
						</a>
					</div>
					<div class="ArticleMain">	
						<?php if($v['start_date']!='0000-00-00'):?>
						<p><span class="badge cis2-bk"><?php echo date('Y.m.d', strtotime($v['start_date']))?></span></p>
						<?php endif?>
						<p class="title-c border_bottom_1"><a href="<?php echo $this->createUrl('site/'.$this->data['router_method'].'detail',array('id'=>$v['class_id'],'id2'=>$v['id']))?>"><?php echo $v['topic']?></a></p>
						<?php echo $v['field_tmp']?>
					</div>
				</div>
				</article>
			<?php endforeach?>
		<?php endif?>

		<?php echo $this->renderPartial('//include/_pagi_has_id', $this->data)?>

<?php if($this->data['editmode']):?>    

<?php endif?>




<div class="[OTHER]" [STYLEPOS1]>
    [POS1]
    <div>
        
        <ul class="inline">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
				<li><a href="<?php echo $v['url']?>" class="cis3-dark"><small><?php echo $v['title2']?></small><span><?php echo $v['title']?></span></a></li>
				<?php endforeach?>
			<?php endif?>

			<?php if(0):?>
            <li><a href="" class="cis3-dark"><small>[2015.02.01]</small><span>新聞標題新聞標題</span></a></li>
            <li><a href="" class="cis3-dark"><small>[2015.02.01]</small><span>新聞標題新聞標題</span></a></li>
            <li><a href="" class="cis3-dark"><small>[2015.02.01]</small><span>新聞標題新聞標題</span></a></li>
			<?php endif?>
        </ul>
        
    </div>

    <div>
        <p class="text-center">
            <a href="<?php echo $this->createUrl('site/news')?>" class="btn btn-default btn-sm" role="button">READ MORE</a>
        </p>
    </div>
</div>

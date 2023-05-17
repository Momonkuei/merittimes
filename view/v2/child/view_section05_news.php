<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
<h3 class="title-sm noline text-vcenter">NEWS<button class="btn-link cis3-border margin_sm_lr visible-lg-inline" onclick="location.href='index.php?r=site/news';">VIEW ALL</button></h3>
    <ul class="listitem list-unstyled">
		<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
        <li class="oneline text-vcenter"><span class="cis3-bk color-fff"><?php echo date('Y.m.d', strtotime($v['start_date']))?></span><a href="<?php echo $v['url']?>" ><?php echo $v['topic']?></a></li>
       <?php endforeach?>
    </ul>
<h4 class="text-center margin_base_lr"><button class="btn-link btn-lg cis2-border  hidden-lg" onclick="location.href='index.php?r=site/news';">VIEW ALL</button></h4>
<?php endif?>



<?php /* //備份用
<h3 class="title-sm noline text-vcenter">NEWS<button class="btn-link cis3-border margin_sm_lr visible-lg-inline">VIEW ALL</button></h3>
    <ul class="listitem list-unstyled">
        <li class="oneline text-vcenter"><span class="cis3-bk color-fff">2015.01.02</span><a href="" >新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題</a></li>
        <li class="oneline text-vcenter"><span class="cis3-bk color-fff">2015.01.02</span><a href="" >新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題</a></li>
        <li class="oneline text-vcenter"><span class="cis3-bk color-fff">2015.01.02</span><a href="" >新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題</a></li>
        <li class="oneline text-vcenter"><span class="cis3-bk color-fff">2015.01.02</span><a href="" >新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題新聞標題</a></li>                                
    </ul>
<h4 class="text-center margin_base_lr"><button class="btn-link btn-lg cis2-border  hidden-lg">VIEW ALL</button></h4>
*/ ?>
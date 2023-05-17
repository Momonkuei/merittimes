	[POS1]
		<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>
		<?php $this->data['HEAD'] .= <<<XXX
<link rel="stylesheet" href="common/fancybox/jquery.fancybox.css">
<style>
.fancybox-overlay *{
      -webkit-transition: none !important;
      -moz-transition: none !important;
      -o-transition: none !important;
      -ms-transition: none !important;
      transition: none !important;
}
</style>
XXX;
?>
		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
   <script src="common/fancybox/jquery.fancybox.pack.js"></script>
<!--<script src="js/jquery.md5.js"></script>-->
<script>
  $(".albumlist a").fancybox({
      helpers : {
        title : {
          type : 'over'
        }
      }
    }); 
</script>
XXX;
?>
		<div id="album1" class="tab-pane fade in hoverEffect_01 active ">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<?
		$tmp_name = explode("/",$v['pic1']);	
		$tmp_name = explode(".",$tmp_name[count($tmp_name)-1]);
		$tmp_name = $tmp_name[0];
		$tmp_name = $v['name'];
					?>
					<!---1 張照片 Start-->                
					<div class="albumlist _xs1c">
						<div>
							<a href="<?php echo $v['pic1']?>" data-lightbox="album1" data-title="<?php echo $tmp_name?>" rel="group1">
								<div class="thumbnail"><img src="<?php echo $v['pic1']?>" alt="<?php echo $tmp_name?>"></div>
								<h5 class="text-center"><?php echo $tmp_name?></h5>
							</a>
						</div>
					</div>
					<!---1張照片 END-->
				<?php endforeach?>
			<?php endif?>
		</div>
<?php if(0):?>     

[POS1]                

                   

			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>

				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>

				<?php if($v['pic'] == ''):?><?php continue?><?php endif?>

                        <div>

							<a class="thumbnail idex_5" href="<?php echo $v['url']?>">

								<img src="<?php echo $v['pic']?>" class="img-responsive wCenter_hCenter ">

                            </a>

                        </div>  

				<?php endforeach?>

			<?php endif?>

                       
<?php endif?>



 <?php /*
            

         <ul class="bxslider">
            <li><a class=" " href="#_"><img src="/images/ad_logo_1.jpg" class=""></a></li>
            <li><a class=" " href="#_"><img src="/images/ad_logo_2.png" class=""></a></li>
            <li><a class=" " href="#_"><img src="/images/ad_logo_3.jpg" class=""></a></li>
            <li><a class=" " href="#_"><img src="/images/ad_logo_4.jpg" class=""></a></li>
            
          </ul>
*/?>

			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>			
			 <ul class="bxslider no_css_transition ">
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
				<?php if($v['pic'] == ''):?><?php continue?><?php endif?>
				 <li><a class=" " href="#_"><img src="<?php echo $v['pic']?>" class=""></a></li>
				<?php endforeach?>
       </ul>
			<?php endif?>
	
<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>
    <?php $this->data['HEAD'] .= <<<XXX
<link rel="stylesheet" href="common/bxslider/css/jquery.bxslider.css">
<style>
.bxslider li {min-width:210px;}
@media (max-width:992px) {.bxslider li {min-width:190px;}}
@media (max-width:768px) {.bxslider li {min-width:190px;}}
</style>
XXX;
?>



<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
    <?php $this->data['BODY_END'] .= <<<XXX

<script type="text/javascript" src="common/bxslider/js/jquery.bxslider.min.js"></script>
<script type="text/javascript">
    \$(function(){
           \$(".bxslider").bxSlider({
          mode:'horizontal', //'horizontal', 'vertical', 'fade',
          captions: false, 
          slideWidth:210, 
          slideMargin:20,
          auto: true, 
          autoHover: true, 
          pager: false,
          //moveSlides:5,
          minSlides:2,
          maxSlides:5,
          controls:false, 
          pause:5000, 
          speed:2000 
        });
    });
</script>



XXX;
?>




<?php /*
<!-- 

                       <div>

                            <a class="thumbnail " href="#_">

                                

                                <img src="/images/ad_logo_1.jpg" class="img-responsive wCenter_hCenter">

                                

                            </a>

                        </div> 





                        <div>

                            <a class="thumbnail " href="#_">

                                

                               <img src="/images/ad_logo_2.png" class="img-responsive wCenter_hCenter">

                                

                            </a>

                        </div> 





                        <div>

                            <a class="thumbnail " href="#_">

                                

                               <img src="/images/ad_logo_3.jpg" class="img-responsive wCenter_hCenter">

                                

                            </a>

                        </div> 





                        <div>

                            <a class="thumbnail " href="#_">

                                

                                <img src="/images/ad_logo_4.jpg" class="img-responsive wCenter_hCenter">

                                

                            </a>

                        </div> 





         

                         -->
*/?>





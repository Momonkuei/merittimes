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
  $(".waterfall_photos a").fancybox({
      helpers : {
        title : {
          type : 'over'
        }
      }
    }); 
</script>
XXX;
?>


<style> 
  .waterfall_photos *                    {-webkit-transition:none;-moz-transition:none;-o-transition:none;transition:none;}
  .waterfall_photos                      {margin-bottom:100px}
  .grid-sizer, .grid-item                {width:25%;}
  .grid-item                             {padding:10px;}
  .grid-item img                         {width: 100%;}
  
  @media (min-width:1200px) {.grid-sizer, .grid-item { width: 20%}}
  @media (max-width:990px)  {.grid-sizer, .grid-item { width: 33.33334%}}
  @media (max-width:768px)  {.grid-sizer, .grid-item { width: 50%}}

</style>    




<div class="waterfall_photos">
  <div class="grid-sizer"></div>

 <?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
    <?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>

  <div class="grid-item">
    <div class="shadow">
        <div class="hoverEffect_02">
           <a href="<?php echo $v?>" data-lightbox="waterfall_photos" data-title="HOLIDAY" rel="group1">
              <img src="<?php echo $v?>" alt="" rel="group1">              
           </a>
        </div>         
    </div>
  </div>
  <?php endforeach?>
<?php endif?>

</div>
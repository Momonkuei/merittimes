[POS1]

<section class="Bbox_1c">
	<div class="indexCircle">
		  <div class="blockTitle"><?php echo G::t(null,'NEWS')?> </div> 

<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
      <?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>

	      <div class="item">
	      	  <a  <?php if(isset($v['url']) && $v['url']):?> href="<?php echo $v['url']?>" <?php endif?> class="">
	      	  	<div class="itemImg"> <img src="<?php echo $v['pic']?>" class=""> </div>
		      	<h5><?php echo $v['name']?></h5>
	      	  </a>	      
	      </div>

       <?php endforeach?>
<?php endif?>



		<div class="text-center"><a href="index.php?r=site/news" class="btn"><?php echo G::t(null,'VIEW MORE')?></a></div>
	</div>
</section> 

<section class="indexFeaturedProducts">
	<div class="blockTitle"><?php echo G::t(null,'FEATURED PRODUCTS')?> </div> 
	<div class="item">



<?php if(isset($this->data['layoutv2'][13])):?>
						<?php foreach($this->data['layoutv2'][13] as $k => $v):?>
		<a  <?php if(isset($v['url']) && $v['url']):?> href="<?php echo $v['url']?>"<?php endif?>   ><img src="<?php echo $v['pic']?>" class="itemImg"></a>
 <?php endforeach?>
<?php endif?>

	
	</div>
</section>


<?php /* //備份用
<section class="Bbox_1c">
	<div class="indexCircle">
		  <div class="blockTitle"> NEWS </div> 
	      <div class="item">
	      	  <a href="" class="">
	      	  	<div class="itemImg"> <img src="images/sample-index-img-1.jpg" class=""> </div>
		      	<h5>2016室內裝潢新家具</h5>
	      	  </a>	      
	      </div>
	      <div class="item">
	      	  <a href="" class="">
	      	  	<div class="itemImg"> <img src="images/sample-index-img-2.jpg" class=""> </div>
		      	<h5>歐美精簡重新打造家居新風格</h5>
	      	  </a>	      
	      </div>
	      <div class="item">
	      	  <a href="" class="">
	      	  	<div class="itemImg"> <img src="images/sample-index-img-3.jpg" class=""> </div>
		      	<h5>日式空間設計久大要點推薦</h5>
	      	  </a>	      
	      </div>
		<div class="text-center"><a href="" class="btn">VIEW MORE</a></div>
	</div>
</section> 

<section class="indexFeaturedProducts">
	<div class="blockTitle"> FEATURED PRODUCTS </div> 
	<div class="item">
		<a href=""><img src="images/sample-index-img-4.png" class="itemImg"></a>
		<a href=""><img src="images/sample-index-img-5.png" class="itemImg"></a>
	</div>
</section>
*/?>
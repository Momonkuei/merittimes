<div class="indexContent_07">

	<section class="w600px block">

		<div class="blockTitle txtCenter">
			<span>最新消息</span>
			<small>LATEST NEWS</small>
		</div>
		
		<?php // 文字跑馬燈，至多五則?>
		<?php //$widgetName='marquee';include 'common/common_widget.php';?>

<?php if(0):?>
		<section class="marquee">
			<ul class="" l="layer" ls="html:news" lp="andwhere:is_home---1,orderby:start_date desc" >
				<li l="list"><a href="newsdetail_<?php echo $this->data['ml_key']?>.php?id={/id/}" data-txtlen="35">{/topic/}</a>	</li>
				<li><a href="" data-txtlen="35">舉辦「產學合作商機發表會」</a>	</li>
				<li><a href="" data-txtlen="35">舉辦「產學合作商機發表會」</a>	</li>
			</ul>
		</section>
<?php endif?>

	</section>




	<section class="w1200px block">
		

			<div class="adBlock gridBox closest" data-grid="2"  l="layer" ls="html:news" lp="andwhere:is_home---1,orderby:start_date desc" >					
				<div l="list">
					<a href="newsdetail_<?php echo $this->data['ml_key']?>.php?id={/id/}"><div class="itemImg"><img src="{/pic1_/}"></div></a>
				</div>
				<div>
					<a href=""><div class="itemImg"><img src="images/index_ad_2.jpg"></div></a>					
				</div>
			</div>

	</section>	

<?php
$rowstype = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get('shoptype')->result_array();
$rowstype_tmp = array();
if($rowstype and !empty($rowstype)){
	foreach($rowstype as $k => $v){
		$rowstype_tmp[$v['id']] = $v['name'];
	}
}

$rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('is_home',1)->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")')->get('shop')->result_array();
?>

	<div class="Bbox_1c">
		<div>
			<div>
				<h2 class="blockTitle txtCenter">
					<span>LOOK BOOK</span> 
					<small>New & Hot</small>
				</h2>
				<!-- <div class="slidBlock"  data-slick='{"slidesToShow": 4, "slidesToScroll": 1}' > -->
				<div class="indexProListSlidBlock gridBox" data-grid="12">
					<?php if(!empty($rows)):?>
						<?php foreach($rows as $k => $v):?>
						<a class="slidItem col_3" data-rwd="l4x6" href="shopdetail_<?php echo $this->data['ml_key']?>.php?id=<?php echo $v['id']?>">
								<div class="itemImg share"><img src="_i/assets/upload/shop/<?php echo $v['pic1']?>"></div>
								<h4 class="slidItemTitle"><?php if(isset($rowstype_tmp[$v['class_id']])):?><?php echo $rowstype_tmp[$v['class_id']]?><?php endif?></h4>
								<p class="slidItemDesc"><?php echo $v['name']?></p>
							</a>
						<?php endforeach?>
					<?php endif?>
<?php if(0):?>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_5.jpg"></div>
						<h4 class="slidItemTitle">Summer</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_2.jpg"></div>
						<h4 class="slidItemTitle">Winter</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_3.jpg"></div>
						<h4 class="slidItemTitle">Snow</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_4.jpg"></div>
						<h4 class="slidItemTitle">Fall</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_1.jpg"></div>
						<h4 class="slidItemTitle">Spring</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_5.jpg"></div>
						<h4 class="slidItemTitle">Summer</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_2.jpg"></div>
						<h4 class="slidItemTitle">Winter</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_3.jpg"></div>
						<h4 class="slidItemTitle">Snow</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_4.jpg"></div>
						<h4 class="slidItemTitle">Fall</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_1.jpg"></div>
						<h4 class="slidItemTitle">Spring</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_5.jpg"></div>
						<h4 class="slidItemTitle">Summer</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
					<a class="slidItem col_3" data-rwd="l4x6">
						<div class="itemImg share"><img src="images/tw/demo/pro_2.jpg"></div>
						<h4 class="slidItemTitle">Winter</h4>
						<p class="slidItemDesc">Lorem ipsum dolor</p>
					</a>
<?php endif?>
				</div>
			</div>
		</div>
	</div>






</div>	
		

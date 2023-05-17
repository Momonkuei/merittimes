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

<?php 
$tmps = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','bannernews')->get('html')->row_array(); //#38303
?>

	<section class="w1200px block">
		

			<div class="adBlock gridBox closest" data-grid="2" >
				<?php if($tmps):?>					
				<div >
					<a <?php if($tmps['other1']!=''):?>href="<?php echo $tmps['other1']?>"<?php endif?>><div class="itemImg">
						<?php if($tmps['pic1']!=''):?>
						<img src="_i/assets/upload/bannernews/<?php echo $tmps['pic1']?>">
						<?php endif?>
					</div></a>
				</div>
				<div>
					<a <?php if($tmps['other2']!=''):?>href="<?php echo $tmps['other2']?>"<?php endif?>><div class="itemImg">
						<?php if($tmps['pic2']!=''):?>
						<img src="_i/assets/upload/bannernews/<?php echo $tmps['pic2']?>">
						<?php endif?>
					</div></a>					
				</div>
				<?php endif?>
			</div>

	</section>



<?php if(0):?>
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
<?php endif?>

<?php
$rowstype = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get('shoptype')->result_array();
$rowstype_tmp = array();
if($rowstype and !empty($rowstype)){
	foreach($rowstype as $k => $v){
		$rowstype_tmp[$v['id']] = $v['name'];
	}
}

$tmps = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")')->where('is_home',1)->get('shop')->result_array();

if($tmps and !empty($tmps)){
	foreach($tmps as $kk => $vv){
		$vv['img_alt'] = $vv['name'];
		$vv['url1'] = $vv['url2'] = $url_prefix.'shopdetail'.$url_suffix.'?id='.$vv['id'];
		$vv['pic'] = '_i/assets/upload/shop/'.$vv['pic1'];

		$vv['price'] = 0; 
		$vv['price2'] = 0;
		$vv['inventory'] = 0;
		$rowg = $this->cidb->where('is_enable',1)->where('data_id',$vv['id'])->get('shopspec')->row_array();
		if($rowg and isset($rowg['id'])){
			$vv['inventory'] = $rowg['inventory'];
			$vv['price'] = $rowg['price'];
			$vv['price2'] = $rowg['price2'];
		}

		foreach(array('price','price2') as $_price){
			$vv[$_price.'_format'] = number_format($vv[$_price]);
			$vv[$_price.'_format_ds'] = '$'.$vv[$_price.'_format'];
			$vv[$_price.'_format_ds_nt'] = 'NT'.$vv[$_price.'_format_ds'];
		}

		$tmps[$kk] = $vv;
	}
}
//$data[$ID] = $tmps;

// 這裡是從source/favorite/list.php複製過來的
$items2 = $tmps;

// 目前有跟source/favorite/list.php和首頁的共用
include 'source/shop/spec_float_include.php';

$rows = $items2;
//var_dump($tmps);
?>

	<div class="Bbox_1c">
		<div>
			<div>
				<h2 class="blockTitle txtCenter">
					<span>熱銷商品</span> 
					<small>Hot Sale</small>
				</h2>
				<!-- <div class="slidBlock"  data-slick='{"slidesToShow": 4, "slidesToScroll": 1}' > -->
				<div class="indexProListSlidBlock gridBox" data-grid="12">
					<?php if(!empty($rows)):?>
						<?php foreach($rows as $k => $v):?>
						<div class="slidItem col_3" data-rwd="l4x6">
							<a href="shopdetail_<?php echo $this->data['ml_key']?>.php?id=<?php echo $v['id']?>">
								<div class="itemImg share"><img src="<?php echo $v['pic']?>"></div>
								<h4 class="slidItemTitle"><?php if(isset($rowstype_tmp[$v['class_id']])):?><?php echo $rowstype_tmp[$v['class_id']]?><?php endif?></h4>
								<p class="slidItemDesc"><?php echo $v['name']?></p>
							</a>
							<div class="price">$<?php echo $v['price2']?></div>
							<div class="carBar">
								<a  href="javascript:;" class="itemAddCart openBtn" item_id="<?php echo $v['id']?>" <?php if(isset($v['specs']) and !empty($v['specs'])):?> item_specid="<?php echo $v['specid']?>" <?php else:?> data-target=".addCartPanel_<?php echo $v['id']?>" <?php endif?> ><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="tips">加入購物車</span></a>
								<a href="javascript:;" class="itemAddFavor  <?php if(isset($v['has_favorite']) and $v['has_favorite'] == '1'):?> active <?php endif?>  " item_id="<?php echo $v['id']?>"><i class="fa fa-heart"></i><span class="tips">加入收藏</span></a>
							</div>
							</div>
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
		

<?php if(0):?><!-- body_end -->
<?php // 這個是從view/favorite/type1.php那邊複製來的?>
<script type="text/javascript">
$('body').on('click','.itemAddCart',function(){
	var thisobj = $(this);
	var item_id = thisobj.attr('item_id');
	var specid = thisobj.attr('item_specid');
	if(parseInt(specid) > 0){
		$.ajax({
			type: "POST",
			data: {
				'func': 'addcar',
				'id': item_id,
				'specid': specid
			},
			url: 'shop_<?php echo $this->data['ml_key']?>.php',
			success: function(response){
				eval(response);	
			}
		}); // ajax
		//return false;
	}
});
</script>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.itemAddFavor',function(){
	var thisobj = $(this);
	var d = new Date();

	var item_id = thisobj.attr('item_id');

	var month = d.getMonth()+1;
	var day = d.getDate();

	var output = d.getFullYear() + '-' +
		((''+month).length<2 ? '0' : '') + month + '-' +
		((''+day).length<2 ? '0' : '') + day;

	if(thisobj.hasClass('active')){
		// do nothing
	} else {
		<?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
			$.ajax({
				type: "POST",
				data: {
					'func': 'addfavorite',
					'id': item_id,
					'add_date': output
				},
				url: 'shop_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);	
					window.location.reload();
				}
			}); // ajax
		<?php else:?>
			$.ajax({
				type: "POST",
				data: {
					'id': 'shop_favorite',
					'primary_key': item_id + '_0',
					'add_date': output
					// specid 這個是加入購物車的時候會有的元素
				},
				url: 'save.php',
				success: function(response){
					thisobj.addClass('active');
					alert('<?php echo t('己加入我的收藏')?>');
					window.location.reload();
					//location.reload();
				}
			}); // ajax
		<?php endif?>
	}
});
</script>
<?php endif?><!-- body_end -->
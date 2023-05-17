
<?php if(isset($this->data['layoutv2_sections_select'])):?>
	<?php if($this->data['layoutv2_sections_select'] == '3'):?><?php // 右邊產品列表 ?>
		[POS1]

		<?php if(0):?><?php // 購物站在使用的?>
		<?php endif?>

		<div>
			<ul class="list-inline floatright">
				<li>
					<?php if(!isset($_SESSION['productsortcount_'.$this->data['ml_key']]) or $_SESSION['productsortcount_'.$this->data['ml_key']] == '0'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort cis3"></span>
					<?php elseif(isset($_SESSION['productsortcount_'.$this->data['ml_key']]) and $_SESSION['productsortcount_'.$this->data['ml_key']] == '1'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-attributes cis3"></span>
					<?php elseif(isset($_SESSION['productsortcount_'.$this->data['ml_key']]) and $_SESSION['productsortcount_'.$this->data['ml_key']] == '2'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-attributes-alt cis3"></span>
					<?php endif?>
					<a href="<?php echo $this->createUrl('site/productsortcount')?>">依瀏覽次數</a>
				</li>
				<li>
					<?php if(!isset($_SESSION['productsortprice_'.$this->data['ml_key']]) or $_SESSION['productsortprice_'.$this->data['ml_key']] == '0'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort cis3"></span>
					<?php elseif(isset($_SESSION['productsortprice_'.$this->data['ml_key']]) and $_SESSION['productsortprice_'.$this->data['ml_key']] == '1'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-attributes cis3"></span>
					<?php elseif(isset($_SESSION['productsortprice_'.$this->data['ml_key']]) and $_SESSION['productsortprice_'.$this->data['ml_key']] == '2'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-attributes-alt cis3"></span>
					<?php endif?>
					<a href="<?php echo $this->createUrl('site/productsortprice')?>">依價格</a>
				</li>
				<li>
					<?php if(!isset($_SESSION['productsortcreatetime_'.$this->data['ml_key']]) or $_SESSION['productsortcreatetime_'.$this->data['ml_key']] == '0'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort cis3"></span>
					<?php elseif(isset($_SESSION['productsortcreatetime_'.$this->data['ml_key']]) and $_SESSION['productsortcreatetime_'.$this->data['ml_key']] == '1'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-attributes cis3"></span>
					<?php elseif(isset($_SESSION['productsortcreatetime_'.$this->data['ml_key']]) and $_SESSION['productsortcreatetime_'.$this->data['ml_key']] == '2'):?>
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-attributes-alt cis3"></span>
					<?php endif?>
					<a href="<?php echo $this->createUrl('site/productsortcreatetime')?>">依上架時間</a>
				</li>
			</ul>
		</div>
		<div class="title"></div>

		<div>
			<div class="Bbox_in_3c">
				<div>
					<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
						<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
							<!---1個商品 Start-->
							<div class="Bbox_in_1c prolist margin_base_tb">
								<div>
									<div>
										<div class="thumbnail">
											<a href="<?php echo $v['url']?>">
												<img src="<?php echo $v['pic']?>" alt="<?php echo $v['name']?>" class="img-responsive">
											</a>
										</div>
									</div>
									<div>
										<div class="box_pro_list_txt">
											<a href="<?php echo $v['url']?>"><h5><?php echo $v['name']?></h5></a>
											<label>NT.<?php echo $v['price']?></label>
										</div>
									</div>
								</div>
							</div>
							<!---1個商品 END-->
						<?php endforeach?>
					<?php endif?>

				</div>
			</div>
		</div>
		<?php echo $this->renderPartial('//include/_pagi_has_id', $this->data)?>

	<?php elseif($this->data['layoutv2_sections_select'] == '4'):?><?php // 商品內頁大圖特效 ?>
		[POS1]
		<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>
		<?php $this->data['HEAD'] .= <<<XXX
<link rel="stylesheet" href="common/lightbox/lightbox.css">
XXX;
?>
		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script src="common/lightbox/lightbox.js"></script>
<script src="js/jquery.md5.js"></script>
XXX;
?>
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']][0]) and count($this->data['layoutv2'][$this->data['section']['key']][0]) > 0):?>
			<!--大圖-->
			<div class="pro_showimg cis3-border-lighter">
				<div class="thumbnail"><a href="javascript:;" onclick="javascript:$('#productdetail_'+$.md5($(this).find('img').attr('src'))).click();"><img src="<?php echo $this->data['layoutv2'][$this->data['section']['key']][0]?>" class="img-responsive vcenter" /></a></div>
			</div>

			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<div style="display:none">
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<a id="productdetail_<?php echo md5($v)?>" href="<?php echo $v?>" data-lightbox="productdetail" data-title="">&nbsp;</a>
				<?php endforeach?>
				</div>
			<?php endif?>

			<!--小圖-->
			<div class="pro_showimg_tumblist">
				<nav class="tumblist-6c margin_base_tb">
					<ul>

						<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
							<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
								<li>
									<a href="#_" class="cis3-border-lighter"><img src="<?php echo $v?>" class="img-responsive"></a>
								</li>
							<?php endforeach?>
						<?php endif?>

					</ul>
				</nav>
			</div>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '5'):?><?php // 商品內頁產品名稱和按鈕 ?>
		[POS1]
		<?php $car = new Shoppingcar?>
		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
		<div class="col-md-12">
			<h3 class="cis3-darker margin_"><?php echo $tmp['name']?></h3>
			<h4>
				<small>NT.<?php echo $tmp['price']?></small>
				<?php if(0):?>
				<span class="label label-danger">VIP.$99</span>   
				<?php endif?>
			</h4>
			<p class="title-sm"></p>
		</div>
		<!--START:Editor-->
		<div class="col-md-12">
			<?php echo $tmp['describe1']?>
		</div>
		<!--END:Editor-->

		<?php if(0):?><?php // 這是詢問車的?>
		<div class="col-md-12 margin_base_tb">
			<a href="<?php echo $this->createUrl('site/inquiry',array('id'=>$tmp['id']))?>" class="btn btn-warning col-xs-12 btn-md col-md-4"><?php echo G::t(null,'加入詢問車')?></a>
			<a href="<?php echo $this->createUrl('site/productinquiry')?>" class="btn btn-link "><?php echo G::t(null,'檢視詢問車')?></a>
		</div>
		<?php endif?>

		<div class="col-md-12 margin_sm_tb">

			<form method="get" id="form_data">

				<div class="col-md-3">

					<label class="control-label">規格</label>

						<select name="spec_id" class="form-control">
							<?php 
								$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'productshopspec',':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll();
								if($rows and count($rows) > 0){
									foreach($rows as $k => $v){
										echo '<option value="'.$v['id'].'">'.$v['topic'].'</option>';
									}
								}
							?>
						</select>

				</div>

				<div class="col-md-3">
					<label class="control-label">數量</label>

						<select name="amount" class="form-control">
							<?php if($tmp['inventory'] > 0):?>
								<?php $y = $tmp['inventory']?>
								<?php if($tmp['inventory'] > 10):?>
									<?php $y = 10?>
								<?php endif?>

								<?php for($x=1;$x<=$y;$x++):?>
									<option><?php echo $x?></option>
								<?php endfor?>
							<?php endif?>
						</select>

				</div>

				<input type="hidden" id="form_data_r" name="r" value="" />
				<input type="hidden" name="id" value="<?php echo $tmp['id']?>" />

				<div class="col-md-12 margin_base_tb">
					<div class="row">
						<a 
							<?php if(!$car->hasid($tmp['id'])):?>
								 onclick="javascript:$('#form_data_r').attr('value','shoppingcar/add');$('#form_data').submit();return false;" 
							<?php endif?> 
							href="javascript:;" 
							class="btn btn-warning col-xs-12 btn-md col-md-3 margin_sm addcar" 
							<?php if($car->hasid($tmp['id'])):?>
								data-toggle="popover" title="已加入購物車" data-content="請點選上方購物車進行結帳" data-placement="top" data-trigger="focus" <?php endif?>
							 >
								<?php echo G::t(null,'加入購物車')?>
						</a>
						<?php if($car->hasid($tmp['id'])):?>
						<?php ob_start()?>
							<script type="text/javascript">
								$( document ).ready(function() {
									$('.addcar').popover('show');
								});
							</script>
							<?php $content = ob_get_contents()?>
							<?php ob_end_clean()?>
							<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
							<?php $this->data['BODY_END'] .= $content?>
						<?php endif?>

						<a 
							<?php if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''):?>
								<?php if(!$car->hasid($tmp['id'])):?>
									 onclick="javascript:$('#form_data_r').attr('value','shoppingcar/directadd');$('#form_data').submit();return false;" 
								<?php endif?> 
							<?php else:?>
								data-toggle="modal" data-target=".goshop"
							<?php endif?> 
							href="javascript:;" 
							class="btn btn-warning col-xs-12 btn-md col-md-3 col-md-offset-1 margin_sm" 
							 >
								<?php echo G::t(null,'立即購買')?>
						</a>
					</div>
				</div>

			</form>

		</div><?php // col-md-12 margin_sm_tb 共兩層，有相同的class名稱?>

	<?php elseif($this->data['layoutv2_sections_select'] == '6'):?><?php // 商品內頁編輯器內容 ?>
		[POS1]
		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
		<!-- Description -->
		<div class="box_ad_1c">
			<div>
				<div class="title-sm">Product Features</div>
				<div id="pro_features">
					<?php echo $tmp['describe2']?>
				</div>
				<div class="title-sm">Notice</div>
				<div id="pro_notice">
					<p align="left">
						<?php echo $tmp['describe3']?>
					</p>
				</div>
			</div>
		</div>
		<!---商品詳細 END-->
		<div class="text-center">
			<p class="title"></p>
			<a href="javascript:history.back();" class="btn btn-default">BACK</a>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '7'):?><?php // 立即結帳 ?>
		<?php $car = new Shoppingcar?>
		<?php if($car->hasdata()):?>
			<?php ob_start()?>
				<div class="sideblock hidden-sm hidden-xs margin_base_lr" data-spy="affix">
					<div class="text-center margin_sm_tb">
						<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
						<br>
						<span class="badge"><?php echo $car->counts()?></span></a>
						<br>
					</div>
					<div class="text-center margin_base_b">
						<?php if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''):?>
							<a href="<?php echo $this->createUrl('shoppingcar/index')?>">
						<?php else:?>
							<a data-target=".goshop" data-toggle="modal" href="#_">
						<?php endif?>
							<span class="btn btn-default ">立<br>即<br>結<br>帳</span>
						</a>
					</div>
					<div class="cis3-border text-center newestadd">
						<div class="cis3-bk-darker">
							<span class="cis3-lighter">最新加入商品</span>
						</div>
							<?php $productshop = $car->get_last_add_three()?>
							<?php if($productshop and count($productshop) > 0):?>
								<?php foreach($productshop as $k => $v):?>
									<!---1個商品 Start-->
									<div class="Bbox_in_1c ">
										<div>
											<div>
												<div class="thumbnail">
													<a href="<?php echo $this->createUrl('site/productshopdetail',array('id2'=>$k,'id'=>$v['class_id']))?>">
														<img src="<?php echo '_i/assets/upload/productshop/'.$v['pic1']?>" alt="商品名稱" class="img-responsive">
													</a>
												</div>
											</div>
											<div>
												<div class="box_pro_list_txt">
													<a href="<?php echo $this->createUrl('site/productshopdetail',array('id2'=>$k,'id'=>$v['class_id']))?>">
														<p><?php echo $v['name']?></p>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!---1個商品 END-->
								<?php endforeach?>
							<?php endif?>
					</div>
				</div>
				<script type="text/javascript">
					$(function () {
					  $('[data-toggle="popover"]').popover();
					});
				</script>
			<?php $content = ob_get_contents()?>
			<?php ob_end_clean()?>
			<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
			<?php $this->data['BODY_END'] .= $content?>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '8'):?><?php // 浮動的登入視窗 ?>
		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script type="text/javascript">
$(document).ready(function() {
	$("#帳號　,#密碼　").keypress(function(e){
		code = (e.keyCode ? e.keyCode : e.which);
		if (code == 13)
		{
			//targetForm是表單的ID
			$("#memberForm2").submit();
		}
	});
	$('.goshoplogin').click(function(){
		$("#memberForm2").submit();
		return false;
	});
});
</script>
XXX;
?>
		<!-- show ligin/check -->
		<div class="modal fade goshop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<p class="text-right">
							<button class="btn-cus btn-lg" data-dismiss="modal">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</p>
						<div class="col-sm-10 col-sm-offset-1">
							<div class="row">
								<div class="col-sm-6">
									<h4 class="title-sm noline">Login</h4>
									<form class="form-horizontal" role="form" id="memberForm2" action="<?php echo $this->createUrl('guest/login',array('next'=>'shoppingcar/index'))?>" method="post" name="main_form" onsubmit="MM_validateForm('帳號　', '', 'R', '密碼　', '', 'R', this); return document.MM_returnValue;">
										<div class="form-group">
											<label for="inputID" class="control-label col-sm-2">帳號</label>
											<div class="col-sm-10">
												<input type="email" class="form-control" id="帳號　" name="login_account" placeholder="請輸入帳號">
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword" class="col-sm-2 control-label">密碼</label>
											<div class="col-sm-10">
												<input type="password" class="form-control" id="密碼　" name="login_password" placeholder="密碼">
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<a href="#" class="btn btn-default goshoplogin">登入</a>
												<a href="<?php echo $this->createUrl('guest/forget')?>" class="btn btn-default">忘記密碼</a>
											</div>
										</div>
									</form>
								</div>
								<div class="col-sm-6">
									<h4 class="title-sm noline">Check Out</h4>
									<p class="clearfix">
										<a href="<?php echo $this->createUrl('shoppingcar/index')?>" class="btn btn-default col-sm-10 col-sm-offset-1">第一次購物</a>
									</p>
									<h5 class="text-center">不需加入會員即可完成結帳。<small>如已有購買請從左側登入</small></h5>
								</div>
							</div>
						</div>
						<div class="modal-footer">
						</div>
					</div>
				</div>
		</div>
		<!-- show ligin/check END-->

	<?php endif?>
<?php endif?>

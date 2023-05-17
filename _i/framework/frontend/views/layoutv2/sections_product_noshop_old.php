<?php
/*
 * 從晴空小鋪Copy來的
 */
?>
<?php if(isset($this->data['layoutv2_sections_select'])):?>
	<?php if($this->data['layoutv2_sections_select'] == '1'):?><?php // 左側選單?>
		[POS1]
		<div class="menu_lg_view">
			<div>
				<p class="title-c text-center margin_sm_tb">ProductsMenu 商品分類</p>
			</div>
			<ul class="list-unstyled">
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
						<li><a href="#_" data-toggle="collapse" data-target=".submenu_<?php echo $k?>"><?php echo $v['name']?></a>
							<?php if(isset($v['childs']) and count($v['childs']) > 0):?>
								<ul class="submenu_<?php echo $k?> nav nav-pills nav-stacked <?php if(isset($_GET['id']) and isset($producttype_tmp[$_GET['id']]) and $producttype_tmp[$_GET['id']]['pid'] == $v['id']):?><?php else:?> collapse <?php endif?> ">
								<?php foreach($v['childs'] as $kk => $vv):?>
									<li><a href="<?php echo $vv['url']?>"><?php echo $vv['name']?></a></li>
								<?php endforeach?>
								</ul>
							<?php endif?>
						</li>
					<?php endforeach?>
				<?php endif?>

<?php if(0):?>
				<li><a href="#_" data-toggle="collapse" data-target=".submenu_01">分類1</a>
					<ul class="submenu_01 nav nav-pills nav-stacked">
						<li><a href="">次分類1</a></li>
						<li><a href="">次分類2</a></li>
						<li><a href="">次分類3</a></li>
					</ul>
				</li>
				<li><a href="#_" data-toggle="collapse" data-target=".submenu_02" aria-expanded="true" aria-controls="submenu">分類2</a>
					<ul class="submenu_02 nav nav-pills nav-stacked collapse">
						<li><a href="">次分類1</a></li>
						<li><a href="">次分類2</a></li>
					</ul>
				</li>
				<li><a href="#_" data-toggle="collapse" data-target=".submenu_03" aria-expanded="true" aria-controls="submenu">分類3</a> </li>
<?php endif?>

			</ul>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '2'):?><?php // 縮小後才會出現的左側選單，記得外層是Bbox_1c hidden-md hidden-lg?>
		[POS1]
		<div data-toggle="collapse" data-target=".menu_s_view" aria-expanded="fale">
			<p class="title-sm text-center margin_sm_tb" style="cursor:pointer">Products <span class="caret hidden-md hidden-lg"></span></p>
		</div>
		<div class="menu_s_view collapse hidden-md hidden-lg">
			<ul class="list-unstyled">
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
						<li><a href="#_" data-toggle="collapse" data-target=".submenu_<?php echo $k?>"><?php echo $v['name']?></a>
							<?php if(isset($v['childs']) and count($v['childs']) > 0):?>
								<ul class="submenu_<?php echo $k?> nav nav-pills nav-stacked <?php if(isset($_GET['id']) and isset($producttype_tmp[$_GET['id']]) and $producttype_tmp[$_GET['id']]['pid'] == $v['id']):?><?php else:?> collapse <?php endif?> ">
								<?php foreach($v['childs'] as $kk => $vv):?>
									<li><a href="<?php echo $vv['url']?>"><?php echo $vv['name']?></a></li>
								<?php endforeach?>
								</ul>
							<?php endif?>
						</li>
					<?php endforeach?>
				<?php endif?>

			</ul>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '3'):?><?php // 右邊產品列表 ?>
		[POS1]

		<?php if(0):?><?php // 購物站在使用的?>
		<div>
			<ul class="list-inline floatright">
				<li><span aria-hidden="true" class="glyphicon glyphicon-sort cis3"></span></li>
				<li><a href="">依瀏覽次數</a></li>
				<li><a href="">依價格</a></li>
				<li><a href="">依上架時間</a></li>
			</ul>
		</div>
		<div class="title"></div>
		<?php endif?>

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
											<?php if(0):?><label>NT.100</label><?php endif?>
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
		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
		<div class="col-md-12">
			<h3 class="cis3-darker margin_"><?php echo $tmp['name']?></h3>
			<p class="title-sm"></p>
		</div>
		<!--START:Editor-->
		<div class="col-md-12">
			<?php echo $tmp['describe1']?>
		</div>
		<!--END:Editor-->
		<div class="col-md-12 margin_base_tb">
			<a href="<?php echo $this->createUrl('site/inquiry',array('id'=>$tmp['id']))?>" class="btn btn-warning col-xs-12 btn-md col-md-4"><?php echo G::t(null,'加入詢問車')?></a>
			<a href="<?php echo $this->createUrl('site/productinquiry')?>" class="btn btn-link "><?php echo G::t(null,'檢視詢問車')?></a>
		</div>
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
	<?php elseif($this->data['layoutv2_sections_select'] == '7'):?><?php // 商品洽詢上半部 ?>

		[POS1]

		<?php if(0):?><?php // 這裡暫不用?>
		<div class="shadow">
			<h4 class="cis3-darker">
		<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>詢問車</h4>
		</div>
		<?php endif?>

		<div>
			<!--商品資料標題-->
			<div class="checkitem col-sm-12 hidden-xs hidden-sm">
				<div>
					<div class="Bbox_in_2c_L3 col-sm-10 col-md-11 col-md-offset-1">
						<div>
							<div>
								<div>
									<table class="checklist th pro_title_name">
										<tbody>
											<tr>
												<td><?php echo G::t(null,'名稱')?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div>
								<div>
									<table class="checklist th">
										<tbody>
											<tr>
												<?php if(0):?>
												<td>顏色</td>
												<td>規格</td>
												<td>數量</td>                                                            
												<?php endif?>
												<td><?php echo G::t(null,'刪除')?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--商品資料標題 END-->
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<!--商品資料 1筆-->
					<div class="Bbox_sin_12_12">
						<div>
							<div class="checkitem col-sm-12">
								<div>
									<div class="checkimg">
										<a href="<?php echo $v['url']?>"><img src="<?php echo $v['pic']?>">
										</a>
									</div>
									<div class="col-sm-9 col-md-11">
										<div class="row">
											<div class="col-md-3 col-xs-12">
												<div class="row">
													<table class="checklist  pro_title_name">
														<tbody>
															<tr>
																<td><a href="<?php echo $v['url']?>"><?php echo $v['name']?></a></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="col-md-9">
												<div class="row">
													<table class="checklist">
														<tbody>
															<tr class="hidden-md hidden-lg th">
																<?php if(0):?>
																<td>顏色</td>
																<td>規格</td>
																<td>數量</td>                                                            
																<?php endif?>
																<td><?php echo G::t(null,'刪除')?></td>
															</tr>
															<tr>
																<?php if(0):?>
																<td valign="center">粉色</td>
																<td valign="center">M</td>
																<td>
																	<select class="form-control input-sm col-xs-offset-4">
																		<option>1</option>
																		<option>2</option>
																		<option>3</option>
																		<option>4</option>
																		<option>5</option>
																	</select>
																</td>
																<?php endif?>
																<td><a href="<?php echo $v['_delete']?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--商品資料 1筆 END-->
				<?php endforeach?>
			<?php endif?>
		</div>

		<?php if(0):?><?php // 這裡暫不用?>
		<div>
			<div class="col-md-3 col-md-offset-8 text-right">
				<p class="title-sm"></p>
				<p>總計：<span class="cis2"><b>NTD.2000</b></span></p>
			</div>
		</div>
		<?php endif?>

	<?php elseif($this->data['layoutv2_sections_select'] == '8'):?><?php // 商品洽詢下半部 ?>

		[POS1]

		<?php if(0):?><?php // 這裡暫不用?>
		<div class="margin_base_tb shadow">
			<h4 class="cis3-darker"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>收件人資料</h4>
		</div>
		<?php endif?>


		<div>

			<script type="text/javascript">
			var msgErrorTip2 = '<?php echo G::t(null,'請輸入')?>「%s」';
			var msgErrorTip1 = '請輸入要搜尋的關鍵字。';
			var msgProcess = '處理中...';
			</script>
			<script src="Scripts/confirm_form.js"></script>

			<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm(l.get('[[web]] 聯繫時間'), '', 'R',l.get('[[web]] 姓名'),'','R',l.get('[[web]] 聯絡信箱'),'','R',l.get('[[web]] 聯絡電話'),'', 'R', l.get('[[web]] 詢問服務'), '', 'R', l.get('[[web]] 驗證碼'), '', 'R', this); return document.MM_returnValue;">
				<div class="col-md-6 col-md-offset-3">
					<div class="col-md-6 margin_base_b">
						<input class="form-control"  id="<?php echo G::t(null,'姓名')?>" name="name" placeholder="<?php echo G::t(null,'姓名')?>">
					</div>
					<div class="col-md-6 margin_base_b">
						<input class="form-control" id="<?php echo G::t(null,'聯繫時間')?>" name="know" placeholder="<?php echo G::t(null,'聯繫時間')?>">
					</div>
					<?php if(0):?>
						<div class="col-md-4 margin_base_b">
							<select class="form-control">
								<option>郵遞區號</option>
								<option>406 台中市北屯區</option>
								<option>407 台中市西屯區</option>
								<option>xxx 台北市 x x 區</option>
							</select>
						</div>
						<div class="col-md-8 margin_base_b">
							<input type="email" class="form-control" id="inputEmail3" placeholder="地址">
						</div>
					<?php endif?>
					<div class="col-md-12 margin_base_b">
						<input type="text" class="form-control" id="<?php echo G::t(null,'聯絡電話')?>" name="phone" placeholder="<?php echo G::t(null,'聯絡電話')?>">
					</div>
					<div class="col-md-12 margin_base_b">
						<input type="text" class="form-control" id="<?php echo G::t(null,'聯絡信箱')?>" name="email" placeholder="<?php echo G::t(null,'聯絡信箱')?>">
					</div>
					<div class="col-md-12 margin_base_b">
						<textarea class="form-control" id="<?php echo G::t(null,'詢問服務')?>" name="detail" placeholder="<?php echo G::t(null,'詢問服務')?>" rows="5"></textarea>
					</div>

					<div class="col-md-12 margin_base_b">
						<div class="col-md-6 margin_base_b">
							<input class="form-control" id="<?php echo G::t(null,'驗證碼')?>" name="captcha" placeholder="<?php echo G::t(null,'驗證碼')?>">
						</div>
						<div class="col-md-6 margin_base_b">
							<img border="0" align="absbottom" id="valImageId" src="<?php echo $this->createUrl('contact/captcha')?>"> <a href="javascript:void(0)" onclick="RefreshImage('valImageId')"><?php echo G::t(null,'更新驗證碼')?></a>
						</div>
					</div>

					<div class="col-md-12">
					   <button class="btn-warning"><?php echo G::t(null,'Submit')?></button>
					</div>

				</div>
			</form>
		</div>
		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script src="js/reload.js"></script>
XXX;
?>
	<?php endif?>
<?php endif?>

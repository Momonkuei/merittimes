<?php if(isset($this->data['layoutv2_sections_select'])):?>
	<?php if($this->data['layoutv2_sections_select'] == 'menuAAA' or $this->data['layoutv2_sections_select'] == 'menuBBB' or $this->data['layoutv2_sections_select'] == 'menuCCC' ):?>

		<?php
		 /*
		  * 這裡是共用的主選單處理程式
		  */
		?>

		<?php $section_key = $this->data['section']['key']?>
		<?php if($this->data['layoutv2_sections_select'] == 'menuBBB'):?>
			<?php $section_key = $this->data['section']['key'].'_no_hide'?>
		<?php endif?>

		<?php if(isset($this->data['layoutv2'][$section_key])):?>
			<?php foreach($this->data['layoutv2'][$section_key] as $k => $v):?>

				<?php $submenu_li_attr = ' class="dropdown" '?>
				<?php $submenu_anchor_attr = ' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" '?>
				<?php $submenu_anchor_content = '<span class="caret"></span>'//箭頭?>
				<?php $submenu_li_sub_content = ''?>
				<?php $section_key_sub = ''?>

				<?php if(!isset($v['url'])):?>
					<?php $v['url'] = ''?>
				<?php endif?>

				<?php if(isset($v['url']) and $v['url'] != ''):?>
				<?php $section_key_sub = $this->data['section']['key'].'_sub_'.$v['url']?>
				<?php endif?>

				<?php if(isset($this->data['layoutv2'][$section_key_sub])):?>
					<?php $v['url'] = '#'?>
					<?php ob_start()?>
					<ul class="dropdown-menu">
						<?php foreach($this->data['layoutv2'][$section_key_sub] as $kk => $vv):?>
							<li><a href="<?php echo $this->url($vv['url'])?>"><?php echo $vv['name']?></a></li>
						<?php endforeach?>
					</ul>
					<?php $submenu_li_sub_content = ob_get_contents()?>
					<?php ob_end_clean()?>
				<?php else:?>
					<?php $submenu_li_attr = ''?>
					<?php $submenu_anchor_attr = ''?>
					<?php $submenu_anchor_content = ''?>
				<?php endif?>

				<?php if(isset($v['url']) and preg_match('/^_/', $v['url'])):?>
					<?php
						if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/main_menus/'.$v['url1'].'.php')){
							$file = Yii::getPathOfAlias('application.views.layoutv2').'/main_menus/'.$v['url1'].'.php';
						} else {
							$file = Yii::getPathOfAlias('system.frontend.views.layoutv2').'/main_menus/'.$v['url1'].'.php';
						}
						// 因為footer的選單也用同樣的地方
						if($tmpa == '2' or $tmpa == '1'){ // dirty hack
							include $file;
						}
					?>
				<?php elseif(isset($v['icon']) and $v['icon'] != ''):?>
					<li <?php echo $submenu_li_attr?> >
						<a href="<?php echo $this->url($v['url'])?>" <?php echo $submenu_anchor_attr?> ><span class="glyphicon <?php echo $v['icon']?>" aria-hidden="true"></span><?php echo $submenu_anchor_content?></a>
						<?php echo $submenu_li_sub_content?>
					</li>
				<?php else:?>
					<li <?php echo $submenu_li_attr?> <?php if($v['url1'] == 'index.php?r='.$this->data['router_class'].'/'.str_replace('detail','',$this->data['router_method'])):?>class="active"<?php endif?>>
					<a href="<?php echo $this->url($v['url'])?>" <?php echo $submenu_anchor_attr?> ><?php echo G::t(null,$v['name'])?><?php echo $submenu_anchor_content?></a>
						<?php echo $submenu_li_sub_content?>
					</li>
				<?php endif?>


			<?php endforeach?>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '1'):?>
		[POS1]
		<div class="navbar-brand">
			<a href="index.html"><img src="images/logo.png" class="img-responsive"></a>
		</div>
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar_menu" aria-expanded="false">
			<span class="sr-only"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
		<ul class="nav navbar-nav text-right toplink hidden-sm hidden-md hidden-lg ">
			<?php $tmpa = $this->data['layoutv2_sections_select']?>
			<?php $this->data['layoutv2_sections_select'] = 'menuCCC'?>
			<?php include 'sections.php'?>
			<?php $this->data['layoutv2_sections_select'] = $tmpa?>
		</ul>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '2'):?>
		[POS1]
		<div class="collapse navbar-collapse navbar_menu">
			<ul class="nav navbar-nav">
				<?php $tmpa = $this->data['layoutv2_sections_select']?>
				<?php $this->data['layoutv2_sections_select'] = 'menuAAA'?>
				<?php include 'sections.php'?>
				<?php $this->data['layoutv2_sections_select'] = $tmpa?>

				<?php if(0 and isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
						<?php if(preg_match('/^_/', $v['url1'])):?>
							<?php
								if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/main_menus/'.$v['url1'].'.php')){
									$file = Yii::getPathOfAlias('application.views.layoutv2').'/main_menus/'.$v['url1'].'.php';
								} else {
									$file = Yii::getPathOfAlias('system.frontend.views.layoutv2').'/main_menus/'.$v['url1'].'.php';
								}
								include $file;
							?>
						<?php elseif($v['other1'] != ''):?>
							<li><a href="<?php echo $this->url($v['url1'])?>"><span class="glyphicon <?php echo $v['other1']?>" aria-hidden="true"></span></a></li>
						<?php else:?>
							<li <?php if($v['url1'] == 'index.php?r='.$this->data['router_class'].'/'.str_replace('detail','',$this->data['router_method'])):?>class="active"<?php endif?>><a href="<?php echo $v['url1']?>"><?php echo G::t(null,$v['topic'])?></a></li>
						<?php endif?>
					<?php endforeach?>
				<?php endif?>

			</ul>

			<?php // 如果你有縮小，但不想被隱藏在選單裡面的，就放在這裡?>

			<?php if(isset($this->data['layoutv2'][$this->data['section']['key'].'_no_hide'])):?>
			<ul class="nav navbar-nav text-right toplink hidden-xs">

				<?php $tmpa = $this->data['layoutv2_sections_select']?>
				<?php $this->data['layoutv2_sections_select'] = 'menuBBB'?>
				<?php include 'sections.php'?>
				<?php $this->data['layoutv2_sections_select'] = $tmpa?>

				<?php if(0):?>
				<li class="dropdown">
					<a href="shop_cart.html">
						<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
						<span class="badge">2</span>
					</a>
				</li>
				<li><a href="member_data.html"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
				<?php endif?>
			</ul>
			<?php endif?>

		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '3'):?>
		[POS1]
		<div class="marquee-scroll">
			<ul>
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
						<li><a href="<?php echo $this->url($v['url1'])?>"><?php echo $v['topic']?></a></li>
					<?php endforeach?>
				<?php endif?>
			</ul>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '4'):?>
		[POS1]
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
				<div class="IndexNewsArea_Item Bbox_sin_3_12 ">
					<div>
						<div>
							<a class="thumbnail " href="<?php echo $v['url1']?>">
								<img src="<?php echo $v['pic1']?>" class="img-responsive">
							</a>
						</div>
						<div>
							<div>
								<a href=" ">
									<h4><?php echo $v['topic']?></h4>
									<p><?php echo $v['other1']?></p>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach?>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '5'):?>
		[POS1]
		<div class="title text-center cis2">Feature</div>
		<div><?php echo $this->data['sys_configs']['homeother_text']?></div>
	<?php elseif($this->data['layoutv2_sections_select'] == '6'):?>
		[POS1]
		<iframe src="<?php echo $this->data['sys_configs']['homeother_google_map']?>" width="100%" height="340" frameborder="0" style="border:0"></iframe>
	<?php elseif($this->data['layoutv2_sections_select'] == '7'):?>
		[POS1]
		<?php if(isset($this->data['sys_configs']['footer_contact_'.$this->data['ml_key']])):?>
		<div>
			<h4><?php echo $this->data['sys_configs']['footer_contact_'.$this->data['ml_key']]?></h4>
		</div>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '8'):?>
		[POS1]
		<ul class="list-inline floatright">
			<?php $tmpa = $this->data['layoutv2_sections_select']?>
			<?php $this->data['layoutv2_sections_select'] = 'menuAAA'?>
			<?php include 'sections.php'?>
			<?php $this->data['layoutv2_sections_select'] = $tmpa?>

			<?php if(0 and isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<li><a href="<?php echo $v['url1']?>"><?php echo G::t(null,$v['topic'])?></a></li>
				<?php endforeach?>
			<?php endif?>
		 </ul>
	<?php elseif($this->data['layoutv2_sections_select'] == '9'):?>
		[POS1]
		<?php if(isset($this->data['sys_configs']['footer_'.$this->data['ml_key']]) and trim($this->data['sys_configs']['footer_'.$this->data['ml_key']]) != ''):?>
			<?php echo $this->data['sys_configs']['footer_'.$this->data['ml_key']]?>
		<?php else:?>
			<h6>Copyright © <?php echo $this->data['sys_configs']['admin_title']?> All Rights Reserved / <span>Designed by <a href="http://www.buyersline.com.tw">BLC</a></span></h6>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '10'):?>
		[POS1]
		<?php if(!isset($this->data['layoutv2'][$this->data['section']['key']]['func_name'])):?>
			<?php $this->data['layoutv2'][$this->data['section']['key']]['func_name'] = '未設定名稱'?>
		<?php endif?>
		<?php if(!isset($this->data['layoutv2'][$this->data['section']['key']]['func_en_name'])):?>
			<?php $this->data['layoutv2'][$this->data['section']['key']]['func_en_name'] = 'unknow'?>
		<?php endif?>
		<div>
			<ol class="breadcrumb floatright marginb0">
				<li><a href="index.html">HOME</a></li>
				<li class="active"><a href="#"><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name']?></a></li>
			</ol>
		</div>
		<div class="title text-center margin_base_t cis2"><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_en_name']?><span class="title-c"><?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['func_name_2'])):?><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_2']?><?php else:?><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name']?><?php endif?></span></div>
	<?php elseif($this->data['layoutv2_sections_select'] == '11'):?>
		[POS1]
		<div class="SubMenu text-center">
			<ul class="nav nav-pills text-center">
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<li <?php if((!isset($_GET['id']) and $k == 0) or (isset($_GET['id']) and $v['id'] == $_GET['id'])):?> class="active"<?php endif?> ><a href="<?php echo $this->createUrl('site/'.str_replace('detail','',$this->data['router_method']),array('id'=>$v['id']))?>"><?php echo $v['topic']?></a></li>
					<?php endforeach?>
				<?php endif?>
			</ul>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '12'):?>
		[POS1]
		<div class="title-sm"><?php echo $this->data['layoutv2'][$this->data['section']['key']]['topic']?></div>
		<div>
			<?php echo $this->data['layoutv2'][$this->data['section']['key']]['detail']?>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '13'):?>
		[POS1]
		<div class="cis3">
			<?php if(isset($this->data['sys_configs']['subother_text_'.$this->data['ml_key']])):?>
				<?php echo $this->data['sys_configs']['subother_text_'.$this->data['ml_key']]?>
			<?php endif?>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '14'):?>
		[POS1]
		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
			<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
				<div class="margin_base_tb">
					<div>
					<span class="badge cis2-bk"><?php echo date('Y.m.d', strtotime($v['start_date']))?></span>
						<p class="title-sm title-c"><a href="<?php echo $this->createUrl('site/newsdetail',array('id'=>$v['other1'],'id2'=>$v['id']))?>"><?php echo $v['topic']?></a></p>
					</div>
					<div class="ArticleMain">
						<?php echo $v['detail']?>
					</div>
				</div>
			<?php endforeach?>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '15'):?>
		[POS1]
		<?php $v = $this->data['layoutv2'][$this->data['section']['key']]?>
		<div>
			<span class="badge cis2-bk"><?php echo date('Y.m.d', strtotime($v['start_date']))?></span>
			<p class="title-sm title-c"><?php echo $v['topic']?></p>
		 </div>
		 <div class="ArticleMain">
			<?php echo $v['detail']?>
		 </div>
		 <div class="text-center margin_base_tb"><button class="btn-primary" onclick="javascript:history.back()">BACK</button></div>
	<?php elseif($this->data['layoutv2_sections_select'] == '16'):?>
		[POS1]
		<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>
		<?php $this->data['HEAD'] .= <<<XXX
<link rel="stylesheet" href="common/lightbox/lightbox.css">
XXX;
?>
		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php // 這是錯的 <script src="common/lightbox/lightbox-plus-jquery.min.js"></script>?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script src="common/lightbox/lightbox.js"></script>
XXX;
?>
		<div id="album1" class="tab-pane fade in hoverEffect_01 active ">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<!---1 張照片 Start-->                
					<div class="albumlist">
						<div>
							<a href="<?php echo $v['pic1']?>" data-lightbox="album1" data-title="<?php echo $v['name']?>">
								<div class="thumbnail"><img src="<?php echo $v['pic1']?>" alt="<?php echo $v['name']?>"></div>
								<h5><?php echo $v['name']?></h5>
							</a>
						</div>
					</div>
					<!---1張照片 END-->
				<?php endforeach?>
			<?php endif?>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '17'):?>
		[POS1]
		<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>
		<?php $this->data['HEAD'] .= <<<XXX
<link rel="stylesheet" href="common/lightbox/lightbox.css">
<link rel="stylesheet" href="common/swipebox/css/swipebox.css">
XXX;
?>
		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script src="common/swipebox/js/jquery.swipebox.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {
		$('.swipebox-video').swipebox();
	});
</script>
XXX;
?>
		<div id="album1" class="tab-pane fade in hoverEffect_01 active ">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<!---1 張照片 Start-->                
					<div class="albumlist">
						<div>
							<a class="swipebox-video" href="<?php echo $v['url1']?>" rel="album1" title="<?php echo $v['name']?>">
								<div class="thumbnail"><img src="<?php echo $v['pic1']?>" alt="<?php echo $v['name']?>"></div>
								<h5><?php echo $v['name']?></h5>
							</a>
						</div>
					</div>
					<!---1張照片 END-->
				<?php endforeach?>
			<?php endif?>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '18'):?>
		[POS1]
		<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>
		<?php $this->data['HEAD'] .= <<<XXX
<script type="text/javascript">
var msgErrorTip2 = '請輸入「%s」';
var msgErrorTip1 = '請輸入要搜尋的關鍵字。';
var msgProcess = '處理中...';
</script>
<script src="Scripts/confirm_form.js"></script>
XXX;
?>
		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script src="js/reload.js"></script>
XXX;
?>
		<form class="ContactForm form-inline" action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm(l.get('[[web]] 聯繫時間'), '', 'R',l.get('[[web]] 姓名'),'','R',l.get('[[web]] 聯絡信箱'),'','R',l.get('[[web]] 聯絡電話'),'', 'R', l.get('[[web]] 詢問服務'), '', 'R', l.get('[[web]] 驗證碼'), '', 'R', this); return document.MM_returnValue;">
			<div class="col-md-12 margin_base_b">
			  <h5><?php echo G::t(null,'問題分類')?><em>※</em></h5>
				  <select class="form-control" name="question">
					<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
						<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
							<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
						<?php endforeach?>
					<?php endif?>
				  </select>
			</div>
			<div class="col-md-6 margin_base_b">
				<h5><?php echo G::t(null,'姓名')?><em>※</em></h5>
				<input class="form-control" id="<?php echo G::t(null,'姓名')?>" name="name">
			</div>
			<div class="col-md-6 margin_base_b">
				<h5><?php echo G::t(null,'聯絡電話')?><em>※</em></h5>
				<input class="form-control" id="<?php echo G::t(null,'聯絡電話')?>" name="phone">
			</div>
			<div class="col-md-6 margin_base_b">
				<h5><?php echo G::t(null,'聯絡信箱')?><em>※</em></h5>
				<input class="form-control" id="<?php echo G::t(null,'聯絡信箱')?>" name="email">
			</div>
			<div class="col-md-6 margin_base_b">
				<h5><?php echo G::t(null,'聯繫時間')?><em>※</em></h5>
				<input class="form-control" id="<?php echo G::t(null,'聯繫時間')?>" name="know">
			</div>
			<div class="col-md-12 margin_base_b">
				<h5><?php echo G::t(null,'詢問服務')?><em>※</em></h5>
				<textarea class="form-control" id="<?php echo G::t(null,'詢問服務')?>" name="detail"></textarea>
			</div>
			<div class="col-md-8">
				<h5><?php echo G::t(null,'驗證碼')?><em>※</em></h5>
				<div class="col-md-6 margin_base_b padding_0">
					<input class="form-control" id="<?php echo G::t(null,'驗證碼')?>" name="captcha">
				</div>
				<div class="col-md-6 margin_base_b">
					<img border="0" align="absbottom" id="valImageId" src="<?php echo $this->createUrl('contact/captcha')?>"> <a href="javascript:void(0)" onclick="RefreshImage('valImageId')"><?php echo G::t(null,'更新驗證碼')?></a>
				</div>
			</div>
			<div class="col-md-12">
			<button type="submit" class="btn-primary"><?php //G::te(null,'456') // 這是範例?><?php echo G::t(null,'Submit')?></button>
			</div>
		</form>
	<?php elseif($this->data['layoutv2_sections_select'] == '19'):?>
		<div id="accordion" class="panel-group" aria-multiselectable="true" role="tablist">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne<?php echo ($k+1)?>">
						  <h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo ($k+1)?>" aria-expanded="true" aria-controls="collapseOne<?php echo ($k+1)?>">
							  Q<?php echo ($k+1)?>. <?php echo $v['topic']?>
							</a>
						  </h4>
						</div>
						<div id="collapseOne<?php echo ($k+1)?>" class="panel-collapse collapse <?php if($k == 0):?> in <?php endif?> " role="tabpanel" aria-labelledby="headingOne<?php echo ($k+1)?>">
						  <div class="panel-body">
							為簡化及加速取得適合商品的流程，lativ沒有提供換貨服務，只有「退貨處理」哦。
							取貨後如有不適合的商品，請於7日鑑賞期內於線上辦理退貨申請，您可利用超商退貨通服務寄回退貨（如您購買5件，1件不合適／不喜歡，僅需要把不適合的1件退回即可）。
						  </div>
						</div>
					  </div>
					</div>
				<?php endforeach?>
			<?php endif?>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '20'):?>
		<ul class="col-md-12 list-unstyled onelinenews">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<li>
						<span class="label label-default"><?php echo date('Y.m.d', strtotime($v['create_time']))?></span>
						<a href="<?php echo $this->createUrl('site/downloaddetail',array('id' =>$v['id']))?>"><?php echo $v['topic']?></a>
					</li>
				<?php endforeach?>
			<?php endif?>
		</ul>
	<?php elseif($this->data['layoutv2_sections_select'] == '21'):?>
		<div>
			<ol class="breadcrumb floatright marginb0">
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
						<li><a href="<?php echo $v['url']?>"><?php echo $v['name']?></a></li>
					<?php endforeach?>
				<?php endif?>
			</ol>
		</div>
		<div class="title text-center margin_base_t cis2"><?php echo $this->data['layoutv2'][$this->data['section']['key'].'_other']['func_en_name']?><span class="title-c"><?php if(isset($this->data['layoutv2'][$this->data['section']['key'].'_other']['func_name_2'])):?><?php echo $this->data['layoutv2'][$this->data['section']['key'].'_other']['func_name_2']?><?php else:?><?php echo $this->data['layoutv2'][$this->data['section']['key'].'_other']['func_name']?><?php endif?></span></div>
	<?php endif?>
<?php endif?>

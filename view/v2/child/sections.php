<?php if(isset($this->data['layoutv2_sections_select'])):?>
	<?php if($this->data['layoutv2_sections_select'] == '1'):?>
		[POS1]
		<div class="navbar-brand">
			<a href="index.html"><img src="<?php echo L::imgt('images/logo.png','.png')?>" class="img-responsive" alt="<?php echo  G::t(null,$this->data['sys_configs']['admin_title'])?>"></a>
		</div>
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar_menu" aria-expanded="false">
			<span class="sr-only"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	<?php elseif($this->data['layoutv2_sections_select'] == '2'):?>
		[POS1]
		<?php /*
		<style>
.social_ico {  margin: 10px 0px 0px 0px;}
.social_ico ul {list-style:none;margin:0px;}
.social_ico img { float:right; width:18px; margin:0 1px 0; border:0}
</style>
		<div class="social_ico">
					<ul>
						<li><a href="#"><img src="images/social_ico_facebook.png"  /></a></li>
						<li><a href="#"><img src="images/social_ico_youtube.png"  /></a></li>
						<li><a href="#"><img src="images/social_ico_line.png"  /></a></li>
						<li><a href="#"><img src="images/social_ico_twitter.png"  /></a></li>
						<li><a href="#"><img src="images/social_ico_youtube.png"  /></a></li>
				  </ul>
			 </div>
*/?>
		<div class="collapse navbar-collapse navbar_menu">
			<ul class="nav navbar-nav">
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>

						<?php if(stristr($v['url1'],'contact') and 0) continue;//這是一個範例?>
					
					<?php if(isset($v['field_tmp']) && preg_match('/1/i',$v['field_tmp'])): //這邊判斷後台的前台選單顯示區域是否開啟?>

						<?php if(defined('PC_MENU_SHOW_TYPE') && PC_MENU_SHOW_TYPE):?>

							<?php if(isset($this->data['pc_menu_tmp'][$v['id']]) && count($this->data['pc_menu_tmp'][$v['id']]) > 0) $show_sub_menu = true; else $show_sub_menu = false?>

							<li class="<?php if($show_sub_menu):?>dropdown<?php endif?> <?php if(($v['url1']== str_replace('detail','','index.php?r=site/'.$this->data['router_method'])) &&  $this->data['router_method']!='index' && $v['url1']!='index.php?r=site/productinquiry'):?>active<?php endif?>" >
								<a href="<?php echo $v['url1']?>" <?php if($show_sub_menu):?>class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"<?php endif?>><?php echo L::top(null,$v['topic'])?><?php if($show_sub_menu):?><span class="caret"></span><?php endif?></a>
								
								<?php if($show_sub_menu):?>
									<ul class="dropdown-menu">					
										<?php foreach($this->data['pc_menu_tmp'][$v['id']] as $k1 => $v1):?>	
											<li><a href="<?php echo $v1['url']?>"><?php echo $v1['topic']?></a></li>
										<?php endforeach?>
									</ul>
								<?php endif?>
								
							</li>
						<?php else:?>
							<li class="<?php if($v['pic1']):?>otherlink<? endif ?> <?php if(($v['url1']== str_replace('detail','','index.php?r=site/'.$this->data['router_method'])) &&  $this->data['router_method']!='index' && $v['url1']!='index.php?r=site/productinquiry'):?>active<?php endif?>">
								<a  href="<?php echo $v['url1']?>" <?php if($v['pic1']) echo 'target="_BREAK"'; else if($v['other2']) echo 'target="'.$v['other2'].'"'?> >

								<?php if($v['pic1']):?>
									<img src="_i/assets/upload/webmenu/<?php echo $v['pic1']?>" style="float:center; width:25px; margin:0 1px 0; border:0">
								<?php else: ?>
									<?php echo L::top(null,$v['topic'])?>
								<?php endif ?>

								</a>
							</li>
						<?php endif?>
					<?php endif?>
					<?php endforeach?>

					<?php if(defined('GOOGLE_TRANSLATE') && GOOGLE_TRANSLATE && $GLOBALS['lay_out_select']!=8):?>
					<li id="googleTransLate">
			            <a>
			                <div class="googleTranslate pc"></div>
			            </a>        
					</li>
					<?php endif?>

					<?php if(defined('MEMBER_OPEN') && MEMBER_OPEN==true)://會員功能?>
						<?php if((isset($_SESSION['authw_admin_account']) && $_SESSION['authw_admin_account']!='')):?>
							<li><a href="index.php?r=member" >會員中心</a></li>
							<li><a href="index.php?r=member/logout" >會員登出</a></li>	
						<?php else:?>
							<li><a href="" data-toggle="modal" data-target=".login">會員登錄</a></li>
							<li><a href="index.php?r=guest/register" >會員註冊</a></li>
							<li><a href="index.php?r=guest/forget" >忘記密碼</a></li>
						<?php endif?>
						<?php /*
						<a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target=".login">會員登錄</a>
						<a class="btn btn-default btn-sm" href="/index.php?r=guest/register">註冊</a>
						<a class="btn btn-default btn-sm" href="/index.php?r=guest/register">忘記密碼</a>
						*/?>
					<?php endif?>
				<?php endif?>
				
				<?php // 動態改整站顏色?>
				<?php if(0):?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="change_color.php?color=brown_coffee">BROWN COFFEE</a></li>
						<li><a href="change_color.php?color=blue_water">BLUE WATER</a></li>
						<li><a href="change_color.php?color=pink_lady">PINK LADY</a></li>
					</ul>
				</li>
				<?php endif?>

				<?php // 多國語系?>
				<?php if((isset($mls) and count($mls) > 1 || SIMPLE_TRANSLATE) && $GLOBALS['lay_out_select']!=8 ):?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php foreach($mls as $k => $v):?>	
								<?php if($k == $this->data['ml_key']):?>
									<?php if($k=='tw' && SIMPLE_TRANSLATE):?>
										<li><a id="translateLink" href="javascript:translatePage();">简体</a></li>
									<?php else:?>										
										<li><a href="change_language.php?lang=<?php echo $k?>">[ <?php echo $v?> ]</a></li>		
									<?php endif?>
								<?php else:?>
									<li><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
								<?php endif?>

								<?php /*
								<?php if($k == $this->data['ml_key'] && 0):?>
										 <?php if($k=='tw') $k.='&tran=1'; ?>
										 <?php if($k=='cn') $k='tw&tran=0'; ?>
									<li><a href="change_language.php?lang=<?php echo $k?>">[ <?php echo $v?> ]</a></li>
								<?php else:?>
										<?php if($k=='tw') $k.='&tran=1'; ?>
										<?php if($k=='cn') $k='tw&tran=0'; ?>
									<li><a href="change_language.php?lang=<?php echo $k?>&r=<?php if(isset($_GET['r'])) echo $_GET['r']?>"><?php echo $v?></a></li>
								<?php endif?>	
								*/?>
							<?php endforeach?>
						</ul>
					</li>
				<?php endif?>
				<?php if(0) { ?>
				<li><a href="contact.html"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></a></li>
				<?php } ?>

			</ul>
		</div>
	<?php elseif($this->data['layoutv2_sections_select'] == '3'):?>
		[POS1]
		<div class="marquee-scroll">
			<ul>
				<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
					<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
						<li><a href="<?php echo $v['url1']?>"><?php echo $v['topic']?></a></li>
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
		<div class="title text-center cis2">
			<?php if(isset($this->data['sys_configs']['companyother_title_'.$this->data['ml_key']])):?>
				<?php echo $this->data['sys_configs']['companyother_title_'.$this->data['ml_key']]?>
			<?php else:?>
				Feature
			<?php endif?>		
		</div>
		<div>
		<?php if(isset($this->data['sys_configs']['companyother_text_'.$this->data['ml_key']])):?>
		<?php echo $this->data['sys_configs']['companyother_text_'.$this->data['ml_key']]?>
		<?php endif?>
		</div>

		<?php /* //舊的
		<div class="title text-center cis2">Feature</div>
		<div>
		<?php if(isset($this->data['sys_configs']['homeother_text_'.$this->data['ml_key']])):?>
		<?php echo $this->data['sys_configs']['homeother_text_'.$this->data['ml_key']]?>
		<?php endif?>
		</div>
		*/?>
	<?php elseif($this->data['layoutv2_sections_select'] == '6'):?>
		[POS1]
		<?php if(isset($this->data['sys_configs']['pic1_'.$this->data['ml_key']])):?>
		<?php echo '<img style="margin: 80px 0px 0px;" src="_i/assets/upload/companyother/'.$this->data['sys_configs']['pic1_'.$this->data['ml_key']].'">'?>
		<?php endif?>
		<?php /* //舊的
		<?php if(isset($this->data['sys_configs']['homeother_google_map_'.$this->data['ml_key']])):?>
		<?php echo $this->data['sys_configs']['homeother_google_map_'.$this->data['ml_key']]?>
		<?php endif?>
		*/?>
		<?php /*
		<iframe src="<?php echo $this->data['sys_configs']['homeother_google_map_'.$this->data['ml_key']]?>" width="100%" height="340" frameborder="0" style="border:0"></iframe>
		*/?>
	<?php elseif($this->data['layoutv2_sections_select'] == '7'):?>
		[POS1]
		<?php if(isset($this->data['sys_configs']['footer_contact_'.$this->data['ml_key']])):?>
		<div>
			<h4><?php echo $this->data['sys_configs']['footer_contact_'.$this->data['ml_key']]?></h4>
		</div>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '8'):?>
		[POS1]		
		<ul class="list-inline">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<?php if(isset($v['field_tmp']) && preg_match('/2/i',$v['field_tmp'])):?>
					<li><a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a></li>
					<?php endif?>
				<?php endforeach?>
			<?php endif?>
		 </ul>
	<?php elseif($this->data['layoutv2_sections_select'] == '9'):?>
		[POS1]
		<?php if(isset($this->data['sys_configs']['footer_'.$this->data['ml_key']]) and trim($this->data['sys_configs']['footer_'.$this->data['ml_key']]) != ''):?>
			<?php echo $this->data['sys_configs']['footer_'.$this->data['ml_key']]?>
		<?php else:?>
			<h6>Copyright © <?php echo  G::t(null,$this->data['sys_configs']['admin_title'])?> All Rights Reserved / <span>Designed by <a href="http://www.buyersline.com.tw">BLC</a></span></h6>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '9-8'):?>
		[POS1]
		
		<div class="logo">
			<img src="<?php echo L::imgt('images/logo.png','.png')?>">
		</div>
		<div class="tel">
			<div><img src="images/icon-phone.svg"> <span>(04) 2317-7467</span></div>
			<h4>歡迎預約拍攝 </h4>
		</div>
		

		
		<?php if(isset($this->data['sys_configs']['footer_'.$this->data['ml_key']]) and trim($this->data['sys_configs']['footer_'.$this->data['ml_key']]) != ''):?>
			<?php echo $this->data['sys_configs']['footer_'.$this->data['ml_key']]?>
		<?php else:?>
			<h6 class="copybar">Copyright © <?php echo $this->data['sys_configs']['footer']?> All Rights Reserved / <a href="http://www.buyersline.com.tw">Designed</a> by BLC</h6>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '10'):?>
		[POS1]
	<?php if($this->data['router_method']!='index'):?>
		<?php if(!isset($this->data['layoutv2'][$this->data['section']['key']]['func_name'])):?>
			<?php $this->data['layoutv2'][$this->data['section']['key']]['func_name'] = '未設定名稱'?>
		<?php endif?>
		<?php if(!isset($this->data['layoutv2'][$this->data['section']['key']]['func_en_name'])):?>
			<?php $this->data['layoutv2'][$this->data['section']['key']]['func_en_name'] = 'unknow'?>
		<?php endif?>
		<div>
			<ol class="breadcrumb floatright marginb0">
			
				<li><a href="index.html"><?php echo G::t(null,'HOME')?></a></li>
				<li class="active"><a href="<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['func_name_href'])) echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_href'];else echo '#'?>" ><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name']?></a></li>
				<?php if(0 and !empty($this->data['layoutv2'][$this->data['section']['key']]['func_name_2'])):?>
				<li class="active"><a href="<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['func_name_2_href'])) echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_2_href'];else echo '#'?>" ><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_2']?></a></li>
				<?php endif?>
				<?php if(0 and !empty($this->data['layoutv2'][$this->data['section']['key']]['func_name_3']) && $this->data['layoutv2'][$this->data['section']['key']]['func_name_3']!=''):?>
				<li class="active"><a href="<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['func_name_3_href'])) echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_3_href'];else echo '#'?>" ><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_3']?></a></li>
				<?php endif?>
				<?php if(0 and !empty($this->data['layoutv2'][$this->data['section']['key']]['func_name_4']) && $this->data['layoutv2'][$this->data['section']['key']]['func_name_4']!=''):?>
				<li class="active"><a href="#" onclick="return false;"><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_4']?></a></li>
				<?php endif?>

                <?php for($x=2;$x<=10;$x++):?>
                    <?php if(!empty($this->data['layoutv2'][$this->data['section']['key']]['func_name_'.$x])):?>
                    <li class="active"><a href="<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['func_name_'.$x.'_href'])) echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_'.$x.'_href'];else echo '#'?>" ><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_'.$x]?></a></li>
                    <?php endif?>
                <?php endfor?>
			
			</ol>
		</div>
		
	<?php if($GLOBALS['lay_out_select']==1 || $GLOBALS['lay_out_select']==2):?>
		<?php //標題 ?>
		<?php if(LAYOUT_SMALL_MENU):?>
		<div data-toggle="collapse" <?php if(isset($this->data['lettle_menu'])):?>data-target=".menu_s_view" aria-expanded="false"<?php endif?> rulev1="1">        
            <p class="title text-center margin_sm_tb" <?php if(isset($this->data['lettle_menu'])):?>style="cursor:pointer"<?php endif?> rulev1="n">
			
			<?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_en_name']?>
			<span class="title-c">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['func_name_2'])):?>
				<?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_2']?>
			<?php else:?>
				<?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name']?>
			<?php endif?>
			</span>
			
			<?php if(isset($this->data['lettle_menu'])):?><span class="caret hidden-md hidden-lg"></span></p><?php endif?>
        </div>                   

        <div class="menu_s_view collapse hidden-md hidden-lg">
            <div>
                <div>
                    <ul class="nav nav-pills nav-stacked" rulv1="1">
					<?php if(isset($this->data['lettle_menu'])):?>
						<?php foreach($this->data['lettle_menu'] as $k => $v):?>
                            <li class="active"><a href="<?php echo $this->createUrl('site/'.str_replace('detail','',$this->data['router_method']),array('id'=>$v['id']))?>" rulv1="n"><?php echo $v['topic']?></a></li>
						<?php endforeach?>
					<?php endif?>
                     </ul>
                </div>
            </div>
        </div>
		<?php else:?>
		
		<div class="title text-center margin_base_t deco_2" ><b><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_en_name']?></b><span class="title-c"><?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['func_name_2'])):?><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name_2']?><?php else:?><?php echo $this->data['layoutv2'][$this->data['section']['key']]['func_name']?><?php endif?></span></div>
		<?php endif?>
	<?php endif?>
<?php endif?>

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
		<div class="">
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
					<?php /*<div class="ArticleMain">
						<?php echo $v['detail']?>
					</div> */?>
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
	
	<?php elseif($this->data['layoutv2_sections_select'] == '15-1'):?>

		[POS1]

		<?php $v = $this->data['layoutv2'][$this->data['section']['key']]?>

		<div>

			<p class="title-sm title-c"><?php echo $v['topic']?></p>

		 </div>

		 <div class="ArticleMain" style="text-align:center;">

			<img src="_i/assets/upload/album/<?php echo $v['pic1']?>">

		 </div>

		 <div class="text-center margin_base_tb"><button class="btn-primary" onclick="javascript:history.back()">BACK</button></div>

	<?php elseif($this->data['layoutv2_sections_select'] == '16'):?>
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
	  	  autoDimensions : true,
	      helpers : {
	        title : {
	          type : 'over'
	        }
	      }
	    });		
	
$(".albumlist a").click(function(){
	if (window.matchMedia('(max-width: 768px)').matches) {
		return false;		
	}
});

	
</script>
XXX;
?>
		<div id="album1" class="tab-pane fade in hoverEffect_01 active ">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<!---1 張照片 Start-->                
					<div class="albumlist _xs1c">
						<div>
							<?php if(ALBUM_SHOW_TYPE==1):?>		
							<a href="<?php echo $v['pic1']?>" rel="group1" data-lightbox="album1" data-title="<?php echo $v['name']?>">
								<div class="thumbnail"><img src="<?php echo $v['pic1_small']?>" alt="<?php echo $v['name']?>"></div>
								<a href="<?php echo $v['url']?>" rel="group1"><h5><?php echo $v['name']?></h5></a>
							</a>
							<?php endif?>
							<?php if(ALBUM_SHOW_TYPE==2):?>
							<a href="<?php echo $v['pic1']?>" data-lightbox="album1" data-title="<?php echo $v['name']?>" rel="group1">
								<div class="thumbnail"><img src="<?php echo $v['pic1_small']?>" alt="<?php echo $v['name']?>"></div>
								<h5><?php echo $v['name']?></h5>
							</a>
							<?php endif?>
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
$this->data['HEAD'] = str_replace('請輸入',G::t(null,'請輸入'),$this->data['HEAD']);//2015/8/26 Lota
?>
		<form class="ContactForm form-inline" action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm(l.get('[[web]] 公司名稱'), '', 'R',l.get('[[web]] 姓名'),'','R',l.get('[[web]] 聯絡信箱'),'','R',l.get('[[web]] 聯絡電話'),'', 'R', l.get('[[web]] 詢問服務'), '', 'R', l.get('[[web]] 驗證碼'), '', 'R', this); return document.MM_returnValue;" target="hidFrame">
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
				<h5><?php echo G::t(null,'公司名稱')?><em>※</em></h5>
				<input class="form-control" id="<?php echo G::t(null,'公司名稱')?>" name="company_name">
			</div>
			<div class="col-md-12 margin_base_b">
				<h5><?php echo G::t(null,'詢問服務')?><em>※</em></h5>
				<textarea class="form-control" id="<?php echo G::t(null,'詢問服務')?>" name="detail"></textarea>
			</div>
			<div class="col-md-8">
				<h5><?php echo G::t(null,'驗證碼')?><em>※</em></h5>
				<div class="row">
					<div class="col-md-6 margin_base_b">
						<input class="form-control" id="<?php echo G::t(null,'驗證碼')?>" name="captcha">
					</div>
					<div class="col-md-6 margin_base_b">
						<img border="0" align="absbottom" id="valImageId" src="<?php echo $this->createUrl('contact/captcha')?>"> <a href="javascript:void(0)" onclick="RefreshImage('valImageId')"><?php echo G::t(null,'更新驗證碼')?></a>
					</div>
				</div>
			</div>
			<div class="col-md-12">
			<button type="submit" class="btn-primary"><?php //G::te(null,'456') // 這是範例?><?php echo G::t(null,'Submit')?></button>
			</div>
		</form>
		<iframe name="hidFrame" style="display:none"></iframe>

		<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
		<?php $this->data['BODY_END'] .= <<<XXX
<script src="js/reload.js"></script>
XXX;
?>
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
						  <div class="panel-body"><?php echo $v['detail']?></div>
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
						<?php $create_time = (isset($v['create_time']))?$v['create_time']:date('Y.m.d');?>
						<span class="label label-default"><?php echo date('Y.m.d', strtotime($create_time))?></span>						
						<a href="<?php echo $this->createUrl('site/downloaddetail',array('id' =>$v['id']))?>"><?php echo $v['topic']?></a>
					</li>
				<?php endforeach?>
			<?php endif?>
		</ul>
	<?php endif?>
<?php endif?>

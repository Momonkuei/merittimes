<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/eob.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/custom.css"  />
    
	<link rel="shortcut icon" href="<?php echo vir_path_c?>favicon.ico" />

    <script type="text/javascript">var IMAGE_URL = '<?php echo $this->assetsUrl?>/images/';</script>
	<script type="text/javascript">
		var vir_path_c = '<?php echo vir_path_c?>';
		var base_url = '<?php echo $this->data['base_url']?>';
		var ml_key = '<?php echo $this->data['ml_key']?>';
		var assets_url = '<?php echo $this->assetsUrl?>';
		var template_path = '<?php echo $this->data['template_path']?>';
	</script>

	<script src="<?php echo $this->data['base_url']?>/assets/language.js"></script>
	<?php
		//Yii::app()->clientScript->registerCoreScript('jquery');
		//Yii::app()->clientScript->registerCoreScript('jquery.ui');
		Yii::app()->clientScript->registerCoreScript('jquery.validate');
		//Yii::app()->clientScript->registerCoreScript('jquery.uniform');
		//Yii::app()->clientScript->registerCoreScript('jquery.wysiwyg');
		//Yii::app()->clientScript->registerCoreScript('jquery.superfish');
		//Yii::app()->clientScript->registerCoreScript('jquery.flot');
		Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/custom.js');
		//Yii::app()->clientScript->registerCoreScript('jquery.facebox');
		//Yii::app()->clientScript->registerCoreScript('cookie');
		//Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/switcher.js' );
		//Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/switcher.js' );

		// 這個要放在最下面的
//		$tmpx = <<<XXX
//$('.tabs > li a').eq(0).click();
//XXX;
		//Yii::app()->clientScript->registerScript('custom_last_head', $tmpx, CClientScript::POS_END, 9);
		//Yii::app()->clientScript->registerScript('custom_last_head', $tmpx, CClientScript::POS_READY, 9);
	?>
	<title><?php G::tf($this->data['theme_lang'], $this->data['sys_configs']['admin_title'], null, '後台管理')?></title>
</head>
	<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="146" align="left" valign="top" class="indexgo20"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="1">&nbsp;</td>
							<td width="635" height="1" align="center">
								<div class="indexgo4">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="left" valign="top">
												<a href="#" class="indexmenu04">三寶生化科技股份有限公司 (6220-4909-0000-1096)</a>&nbsp;&nbsp;&nbsp;&nbsp;<br />
												408台中市南屯區大墩十街300號7樓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel：04-22551743&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax：04-22551743<br />
												www.tripletreasures.co.nz&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail：  ted@bbx.tw<br />            在紐西蘭基督城已有二十年歷史的「Triple Treasures 三寶集團」橫跨乳品、保健品、保養品、不動產等多項領域，公司行銷規模橫跨全世界，是當地一間相當有實力的公司！
											</td>
											<td width="20">&nbsp;</td>
											<td width="100" align="left" valign="top" class="indexgo401">桌椅 清潔用品 裝飾品 住宿</td>
										</tr>
									</table>
								</div>
							</td>
							<td height="1">&nbsp;</td>
						</tr>
					</table>
					<br />
					<div class="topmenu2">
						<img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/icon_022.gif" alt="回首頁" width="28" height="21" align="absbottom" />
						&nbsp;&nbsp;<span class="splr"><a href="<?php echo $this->createUrl('site/index')?>">回首頁</a></span>
						&nbsp;&nbsp;<span class="splr"><a href="<?php echo str_replace('_butterfly/', '', vir_path_c)?>">到前台</a></span>
						<div class="login">
<?php if(0):?>
							許信實 您好<span class="splr">&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;</span><a href="#" class="indexmenu03">登出</a>
<?php endif?>
							<?php G::te($this->data['theme_lang'], 'Welcome', null, '歡迎')?>, <a href="<?php echo $this->createUrl('profile/index')?>"><?php if(isset($this->data['admin_name'])):?><?php echo $this->data['admin_name'] ?><?php endif?></a>
<a href="<?php echo $this->createUrl('auth/logout', array('current_base64_url'=> $this->data['current_base64_url']))?>"><?php G::te($this->data['theme_lang'], 'Logout', null, '登出')?></a>
						</div>
					</div>
					<a href="<?php echo $this->createUrl('home/index')?>"><img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/logo.gif" width="206" height="60" border="0"/></a>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top"><img height="34" width="1025" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/header_line.png"></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="230" align="left" valign="top">
								<?php echo $this->renderPartial('//includes/menu', $this->data)?>
							</td>
							<td valign="top">
								<?php echo $content; ?>
							</td>
							<?php if(count($this->data['tcofastmenus']) > 0):?>
								<td width="140" align="center" valign="top">
									<?php foreach($this->data['tcofastmenus'] as $k => $v):?>
										<div class="tcofastmenu_item" style="background-color:#<?php echo $v['other1']?>"><a style="color:#fff;" href="<?php echo vir_path_c.$v['url1']?>"><?php echo $v['topic']?></a></div>
									<?php endforeach?>
								</td>
							<?php endif?>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<div class="footer clearfix">
						<div class="footer_content ">
							<div class="flr">
								<a href="http://tw.eobbarter.com/" target="_blank" class="indexmenu03">EOB 官網</a>
								<br />
								<a href="#" target="_blank" class="indexmenu03">EOB Sales</a>
							</div>
<?php if(0):?>
							<div class="fle help">
								<a href="#" class="indexmenu03">功能管理</a><br />
								<a href="#" target="_blank" class="indexmenu03">EOB後台操作說明</a><br />
								<br /><span class="fle">您需要什麼協助？</span><br /><input type="text" name="textfield" id="textfield" class="style1" size="30"/><input name="button" type="submit" class="btn_help" id="button" value="搜尋說明">
							</div>
<?php endif?>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<div class="gotop"><a href="#">TOP</a></div>
	</body>
</html>

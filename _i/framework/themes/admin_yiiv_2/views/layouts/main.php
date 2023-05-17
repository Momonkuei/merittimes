<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/skins/gray.css" title="gray" />
    
	<link rel="alternate stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/skins/orange.css" title="orange" />
    <link rel="alternate stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/skins/red.css" title="red" />
    <link rel="alternate stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/skins/green.css" title="green" />
    <link rel="alternate stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/skins/purple.css" title="purple" />
    <link rel="alternate stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/skins/yellow.css" title="yellow" />
    <link rel="alternate stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/skins/black.css" title="black" />
    <link rel="alternate stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/skins/blue.css" title="blue" />

    <link type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/custom.css"  />
    
	<link rel="shortcut icon" href="<?php echo vir_path_c?>favicon.ico" />

    <!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/html5.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/selectivizr.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/excanvas.min.js"></script>
    <![endif]-->

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
		Yii::app()->clientScript->registerCoreScript('jquery.ui');
		Yii::app()->clientScript->registerCoreScript('jquery.validate');
		Yii::app()->clientScript->registerCoreScript('jquery.uniform');
		Yii::app()->clientScript->registerCoreScript('jquery.wysiwyg');
		Yii::app()->clientScript->registerCoreScript('jquery.superfish');
		Yii::app()->clientScript->registerCoreScript('jquery.flot');
		Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/custom.js');
		//Yii::app()->clientScript->registerCoreScript('jquery.facebox');
		Yii::app()->clientScript->registerCoreScript('cookie');
		Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/switcher.js' );
		Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/switcher.js' );
		//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/ckeditor/ckeditor.js', CClientScript::POS_END);

		// 這個要放在最下面的
		$tmpx = <<<XXX
$('.tabs > li a').eq(0).click();
XXX;
		//Yii::app()->clientScript->registerScript('custom_last_head', $tmpx, CClientScript::POS_END, 9);
		Yii::app()->clientScript->registerScript('custom_last_head', $tmpx, CClientScript::POS_READY, 9);
	?>
	<title><?php G::tf($this->data['theme_lang'], $this->data['sys_configs']['admin_title'], null, '後台管理')?></title>
</head>
<body>
<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_5">
			<!-- replace with your website title or logo -->
			<a id="site-title" href="<?php echo $this->createUrl('site/index')?>"><img src="<?php echo $this->assetsUrl?>/images/logo.gif" <?php //width="100"?> height="40" /></a>
			<a id="view-site" href="<?php echo vir_path_c?>../" target="_blank"><?php G::te($this->data['theme_lang'], 'Frontend Web Preview', null, '前台網站')?></a>
		</div>
		<?php if(isset($this->data['admin_name']) and $this->data['admin_name'] != ''): ?>
			<div class="grid_4" id="colorstyle">
				<div><?php G::te($this->data['theme_lang'], 'Change Color', null, '改變顏色')?></div>
				<a href="#" rel="blue"></a>
				<a href="#" rel="green"></a>
				<a href="#" rel="red"></a>
				<a href="#" rel="purple"></a>
				<a href="#" rel="orange"></a>
				<a href="#" rel="yellow"></a>
				<a href="#" rel="black"></a>
				<a href="#" rel="gray"></a>
			</div>
			<div id="userinfo" class="grid_3">
				<?php G::te($this->data['theme_lang'], 'Welcome', null, '歡迎')?>, <a href="<?php echo $this->createUrl('profile/index')?>"><?php echo $this->data['admin_name'] ?></a>
			</div>
		<?php endif; ?>
	</div>
</header>
<nav id="topmenu">
	<div class="container_12 clearfix">
		<div class="grid_12">
			<?php echo $this->renderPartial('//includes/menu', $this->data)?>
		</div>
	</div>
</nav>

<section id="content">
    <section class="container_12 clearfix">
        <?php echo $content; ?>
    </section>
</section>

<?php if(0): ?>
<section id="content">
    <section class="container_12 clearfix">
    	<?php if(isset($this->breadcrumbs)):?>
    		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'htmlOptions' => array('class' => 'road'),
                //'homeLink' => CHtml::link('首頁',array('/')), 
    			'links'=>$this->breadcrumbs,
    		)); ?>
    	<?php endif?>
        <?php echo $content; ?>
    </section>
</section>
<?php endif; ?>

<footer id="bottom">
	<section class="container_12 clearfix">
		<div class="grid_6">
			<a href="#"></a>
		</div>
		<div class="grid_6 alignright">
			Copyright &copy; 2012 <a href="http://www.ozchamp.com/">ozchamp.com</a>
		</div>
	</section>
</footer>

<?php if(0): ?>
	<!--<script type="text/javascript" src="view/javascript/jquery/ui/ui.datepicker.js"></script>-->
	<script>
	<!--列表修改排序和狀態，日期控件-->
	$(document).ready(function(){
		edit_init();
	});
	function edit_init()
	{
		$('input[postId]').blur(function (){
			edit($(this));
		});
		$('select[postId]').change(function (){
			edit($(this));
		});
		//$('.date').datepicker({dateFormat: 'yy-mm-dd'}).change(function() {
		//   edit($(this));
		//});
	}
	function edit(obj){
		var param={};
		param[obj.attr('name')]=obj.val();
		var type=obj.attr('postType');
		var id=obj.attr('postId');
		if(type!='' && id!=''){
			$.post('<?php echo $this->createUrl('ajax/update')?>&type='+type+'&action=edit&id='+id,param);
		}
	}
	</script>
<?php endif; ?>

</body>
</html>

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
    
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/superfish.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/jquery.wysiwyg.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/facebox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path'];?>/css/smoothness/jquery-ui-1.8.8.custom.css" />
    <link rel="shortcut icon" href="/favicon.ico" />

    <!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/html5.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/selectivizr.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/excanvas.min.js"></script>
    <![endif]-->

	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/jquery-ui-1.8.8.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/cufon-yui.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/Delicious_500.font.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/custom.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/facebox.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/switcher.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->assetsUrl;?>/js/jquery.form.js"></script>
	<title>後台管理</title>
</head>
<body>
<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_5">
			<!-- replace with your website title or logo -->
			<a id="site-title" href="<?php echo $this->createUrl('site/index')?>"><img src="<?php echo Yii::app()->baseUrl?>/images/logo.png" width="100" height="40" /></a>
			<a id="view-site" href="/" target="_blank">前台網站</a>
		</div>
		<div class="grid_4" id="colorstyle">
			<div>Change Color</div>
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
			Welcome, <a href="<?php echo $this->createUrl('site/profile')?>"><?php echo $this->data['admin_name'] ?></a>
		</div>
	</div>
</header>
<nav id="topmenu">
	<div class="container_12 clearfix">
		<div class="grid_12">
		<?php $this->widget('zii.widgets.CMenu',array(
            'id' => 'mainmenu',
            'activeCssClass' => 'current',
            'htmlOptions' => array('class' => 'sf-menu'),
			'items'=> $this->data['menus'],
		)); ?>
		<?php $this->widget('zii.widgets.CMenu',array(
            'id' => 'usermenu',
            'activeCssClass' => 'current',
            'htmlOptions' => array('class' => 'sf-menu'),
			'items'=> array(array('label'=>'Logout','url'=>$this->createUrl('auth/logout'))),
		)); ?>
		</div>
	</div>
</nav>
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
</body>
</html>

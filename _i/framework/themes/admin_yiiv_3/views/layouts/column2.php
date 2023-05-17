<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/eob.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/custom.css"  />
    
    <link rel="shortcut icon" href="/favicon.ico" />

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
		//Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/custom.js');
		//Yii::app()->clientScript->registerCoreScript('jquery.facebox');
		//Yii::app()->clientScript->registerCoreScript('cookie');
		//Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/switcher.js' );
		//Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/switcher.js' );
		//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/ckeditor/ckeditor.js', CClientScript::POS_END);

		// 這個要放在最下面的
		//$tmpx = <<<XXX
//$('.tabs > li a').eq(0).click();
//XXX;
		//Yii::app()->clientScript->registerScript('custom_last_head', $tmpx, CClientScript::POS_END, 9);
		//Yii::app()->clientScript->registerScript('custom_last_head', $tmpx, CClientScript::POS_READY, 9);

	?>
	<title><?php G::tf($this->data['theme_lang'], $this->data['sys_configs']['admin_title'], null, '後台管理')?></title>
</head>
<body>
<?php echo $content; ?>

</body>
</html>

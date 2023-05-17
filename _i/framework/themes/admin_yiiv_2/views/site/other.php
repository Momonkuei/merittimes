<?php
$this->breadcrumbs = array(
	'其他設定'
);
 ?>
<section id="main" class="grid_12">
    <article id="settings">
        <h1>Other</h1>
        <?php $form=$this->beginWidget('CActiveForm', array(
        	'id'=>'member-form',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        	'enableAjaxValidation'=>false,
        )); ?>
    		<ul class="tabs">
    			<li><a href="#general">其他設定</a></li>
    		</ul>
            <div class="tabcontent">
                <div id="general">
                    <dl class="inline">
                        <dt>商品目錄:</dt>
                        <dd>
                            <?php echo $form->fileField($model, 'svalue'); ?>
                        <?php if ($model->svalue != ''): ?>
                            <br /><a href="<?=$this->createUrl('default/filepath',array('url'=>Helper::encode_url($model->svalue)))?>">檔案下載</a>
                        <?php endif; ?>
							<small><?php echo $form->error($model,'svalue'); ?></small>
						</dd>
                    </dl>
                </div>
            </div>
			<div class="buttons">
				<button type="submit" name="send" class="button">儲存設定</button>
				<button type="reset" class="button white">取消</button>
			</div>
        <?php $this->endWidget(); ?>
    </article>
</section>
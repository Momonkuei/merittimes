<?php
$this->breadcrumbs = array(
	'帳戶設定'
);
 ?>
<div class="main_content">
        <h1>Profile</h1>
        <?php $form=$this->beginWidget('CActiveForm', array(
        	'id'=>'member-form',
        	'enableAjaxValidation'=>false,
        )); ?>
    		<ul class="tabs">
    			<li><a href="#general">帳戶設定</a></li>
    		</ul>
            <div class="tabcontent">
                <div id="general">
                    <dl class="inline">
                        <dt>帳號:</dt>
                        <dd>
                            <?php echo $form->textField($model,'username'); ?>
							<small><?php echo $form->error($model,'username'); ?></small>
						</dd>
                        <dt>密碼:</dt>
                        <dd>
							<?php echo $form->passwordField($model,'passcode'); ?>
							<small><?php echo $form->error($model,'passcode'); ?></small>
						</dd>
                    </dl>
                </div>
            </div>
			<div class="buttons">
				<button type="submit" name="send" class="button">儲存設定</button>
				<button type="reset" class="button white">取消</button>
			</div>
        <?php $this->endWidget(); ?>
</div>

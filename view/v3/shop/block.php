<section class="<?php if(isset($data[$ID]['class_name'])):?><?php echo $data[$ID]['class_name']?><?php endif?> block" <?php if(isset($data[$ID]['name']) and $data[$ID]['name'] == ''):?> style="display:none" <?php endif?>><?php // eventMenu, proCatalog, sideFilter ?>
	<div class="boxTitle"> <?php if(isset($data[$ID]['name'])):?><?php echo $data[$ID]['name']?><?php endif?> </div>							
<?php echo $AA?>
</section>

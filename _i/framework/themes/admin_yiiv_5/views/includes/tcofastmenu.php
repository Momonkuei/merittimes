<?php if(count($this->data['tcofastmenus']) > 0):?>
<div class="col-md-2" style="margin-top:5px;widthg:7.9%">

	<?php foreach($this->data['tcofastmenus'] as $k => $v):?>
		<a href="<?php echo vir_path_c.$v['url1']?>">
		<?php if($v['other1'] == 'CC0000'):?>
			<div class="alert alert-block alert-danger fade in" style="margin-bottom:3px;padding:8px 8px 8px 14px"><?php if(isset($v['other2']) and $v['other2'] != ''):?><i class="<?php echo $v['other2']?>"></i><?php endif?><?php echo $v['topic']?></div>
		<?php elseif($v['other1'] == '000080'):?>
			<div class="alert alert-info" style="margin-bottom:3px;padding:8px 8px 8px 14px"><?php if(isset($v['other2']) and $v['other2'] != ''):?><i class="<?php echo $v['other2']?>"></i><?php endif?><?php echo $v['topic']?></div>
		<?php elseif($v['other1'] == '003300'):?>
			<div class="alert alert-success" style="margin-bottom:3px;padding:8px 8px 8px 14px"><?php if(isset($v['other2']) and $v['other2'] != ''):?><i class="<?php echo $v['other2']?>"></i><?php endif?><?php echo $v['topic']?></div>
		<?php elseif($v['other1'] == '3E003E'):?>
			<div class="alert" style="margin-bottom:3px;padding:8px 8px 8px 14px"><?php if(isset($v['other2']) and $v['other2'] != ''):?><i class="<?php echo $v['other2']?>"></i><?php endif?><?php echo $v['topic']?></div>
		<?php endif?>
		</a>
	<?php endforeach?>

</div>
<?php endif?>

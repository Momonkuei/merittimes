<?php if(count($this->data['tcofastmenus']) > 0):?>
<div class="span2" style="margin-top:5px;widthg:7.9%">

	<?php foreach($this->data['tcofastmenus'] as $k => $v):?>
		<?php if($v['other1'] == 'CC0000'):?>
			<div class="alert alert-error" style="margin-bottom:3px;padding:8px 8px 8px 14px"><a  href="<?php echo vir_path_c.$v['url1']?>"><?php echo $v['topic']?></a></div>
		<?php elseif($v['other1'] == '000080'):?>
			<div class="alert alert-info" style="margin-bottom:3px;padding:8px 8px 8px 14px"><a  href="<?php echo vir_path_c.$v['url1']?>"><?php echo $v['topic']?></a></div>
		<?php elseif($v['other1'] == '003300'):?>
			<div class="alert alert-success" style="margin-bottom:3px;padding:8px 8px 8px 14px"><a  href="<?php echo vir_path_c.$v['url1']?>"><?php echo $v['topic']?></a></div>
		<?php elseif($v['other1'] == '3E003E'):?>
			<div class="alert" style="margin-bottom:3px;padding:8px 8px 8px 14px"><a  href="<?php echo vir_path_c.$v['url1']?>"><?php echo $v['topic']?></a></div>
		<?php endif?>
	<?php endforeach?>

</div>
<?php endif?>

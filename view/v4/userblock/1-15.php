<?php
//var_dump($_params_);
$other1 = '';
$other2 = '';
if(isset($_params_['id']) and $_params_['id'] > 0){
	$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type',$_params_['router_method'])->where('id',$_params_['id'])->get('html')->row_array();
	if($row and isset($row['id'])){
		$other1 = $row['other1'];
		$other2 = $row['other2'];
	}
}
?>

<section class="sectionBlock" id="userblock_<?php echo $_params_['id']?>">
  <div class="container">

    <div class="innerBlock">
      <div class="blockTitle text-center">
        <span><?php echo $other1?></span>
        <small><?php echo $other2?></small>
      </div>

      <div class="row">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="col-lg-6">
				  <div class="innerBlock_small">
					<div class="row colVCenter">
					  <div class="col-md-4">
						<div class="img-circle">
							<img src="_i/assets/upload/<?php echo $v['type']?>/<?php echo $v['pic1']//210x210?>" alt="">
						</div>
					  </div>
					  <div class="col-md-8">
						<div class="subBlockTitle text-lcenter"><?php echo $v['topic']?></div>
						<p class="text-lcenter"><?php echo $v['detail']?></p>
					  </div>
					</div>
				  </div><!-- .innerBlock_small -->
				</div>
			<?php endforeach?>
		<?php endif?>
      </div>

    </div><!-- .innerBlock -->
  </div><!-- .container -->
</section><!-- .sectionBlock -->

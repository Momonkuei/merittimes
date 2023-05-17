<?php
// 2019-11-12
//if(isset($_general_detail) and $_general_detail === true and isset($result) and !empty($result)){
//	//var_dump($result);
//	//
//	$data[$ID] = array();
//	//if(isset($result[0])){
//	//	$data[$ID]['big'] = $data[$ID]['small'] = $result[0];
//	//}
//	$data[$ID] = end($result);
//}
?>

<div class="editorBlock">
	<?php if(isset($data[$ID]['detail'])):?>
		<?php echo $data[$ID]['detail']?>
	<?php endif?>
</div>


<?php

$del = false;
$id = false;

if(isset($_GET['del'])){
	$del = intval($_GET['del']);
}

if(isset($_GET['id'])){
	$id = intval($_GET['id']);
}

if($del > 0){
	$row = $this->db->createCommand()->select('id')->from('customer_address')->where('is_enable=1 and customer_id=:customer_id and id=:id',array(':customer_id'=>$this->data['admin_id'],':id'=>$del))->queryRow();

	if($row and isset($row['id'])){
		$this->cidb->delete('customer_address', array('id' => $del)); 
	}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('己刪除')?>');
	window.location.href='membercenter_<?php echo $this->data['ml_key']?>.php';
</script>
<?php

	die;
}

if($id <= 0){
	$func = 'add';
} elseif($id > 0){
	$func = 'edit';
}

if($func == 'add'){
	$single = array(
		'id' => '',
		'name' => '',
		'phone' => '',
		'mobile' => '',
		'addr' => '',
	);
} elseif($func == 'edit'){
	$single = $this->db->createCommand()->from('customer_address')->where('is_enable=1 and customer_id=:customer_id and id=:id',array(':customer_id'=>$this->data['admin_id'],':id'=>$id))->queryRow();
}

$single['func'] = $func;

$data2[$ID]['single'][] = $single;
$data2[$ID]['multi'][] = $this->db->createCommand()->from('customer_address')->where('is_enable=1 and customer_id=:customer_id',array(':customer_id'=>$this->data['admin_id']))->queryAll();

<?php if(0 and $this->data['router_method'] == 'albumdetail'):// 這裡己經有新的作法取代，請不要在用這裡?>
<?php
$tmps = array();

$class_id = $_GET['id'];

$product_row = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']),':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
$class_id = $product_row['class_id'];

$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where(array('ml_key'=>$this->data['ml_key'],'is_enable'=>'1'))->get(str_replace('detail','',$this->data['router_method']).'multitype');
$rows = array();
foreach($query->result_array() as $v){
    $rows[] = $v; 
}
$tmp2 = _get_product_classes($rows);

// 因為相簿沒有無限層的時候，這裡就會報錯，所以才要寫這個判斷式
if(isset($tmp2['sample'][$class_id])){
	$tmp3 = _search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$class_id]['class_name']); // gg

	if($tmp3 and isset($tmp3['keyvalue']) and count($tmp3) > 0){ 
		foreach($tmp3['keyvalue'] as $k => $v){
			$tmps[] = array(
				'name' => $v, 
				'url' => str_replace('detail','',$this->data['router_method']).'.php?id='.$k,
			);  
		}   
	}
?>

	<?php if(isset($tmps)):?>
	<script type="text/javascript">
		<?php foreach($tmps as $k => $v):?>
			<?php if(isset($v['url']) and preg_match('/^'.str_replace('detail','',$this->data['router_method']).'\.php\?id\=(.*)$/', $v['url'], $matches)):?>
				$('#navlight_<?php echo $matches[1]?>').addClass('active');
			<?php endif?>
		<?php endforeach?>
	</script>
	<?php endif?>

<?php } //這裡是判斷tmp2['sample']有沒有class_id的結尾?>

<?php endif//albumdetail?>

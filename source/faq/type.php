<?php

//設定分頁基本參數 要記得在view那邊加入分頁的view
$page = 0;
if(isset($_GET['page']) and $_GET['page'] > 0){
	$page = $_GET['page'];
}
$limit_count = 10;//一頁顯示幾筆
$_GET['current_page'] = $page;
$DataList = array();
$pageRecordInfo = array();
$db = new Mysqleric(array('table'=>'html'));

// 1 有分類
// 2 沒分類
// unset($_constant);
// eval('$_constant = '.strtoupper($this->data['router_method'].'_show_type').';');
// if($_constant == 1){

$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_method'].'_'.$this->data['ml_key'].'.php', ':ml_key'=>$this->data['ml_key']))->queryRow();
if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
	if(isset($row['is_news']) and $row['is_news'] == 1){ // 是通用分類

		// 如果是分類，但沒有帶分類編號，那自動會轉去第一個
		if(!isset($_GET['id'])){
			$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_method'].'type',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
			$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$tmp['id'];

			if(1){
				header('Location: '.$url);
			} else {
				// A方案，含左側選單專用
?>
<script type="text/javascript">
	window.location.href='<?php echo $url?>';
</script>
<?php
			}
		}

		if(isset($_GET['id'])){

			$class_id = intval($_GET['id']);
			//使用分頁列表
			//$url = $this->createUrl($this->data['router_method'].'.php', array('id'=>$class_id,'page'=>''));
			$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$class_id.'&page=';
			$qryField = '*';
			$qryWhere = ' WHERE is_enable=1 and type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';

			//搜尋哪個分類
			$qryWhere .=' and class_id='.$class_id;

			$qryWhere .=' order by sort_id';

			$db->getData($qryField, $qryWhere, (int)$limit_count);
			if($db->total_row > 0) {
				$DataCount = $db->total_row;
				do{
					if($db->row['update_time'] == '0000-00-00 00:00:00'){
						$db->row['update_time'] = '';
					} else {
						$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
					}
					$db->row['name'] = $db->row['topic'];
					$db->row['content'] = $db->row['detail'];
				$DataList[] = $db->row;
				}while($db->row = $db->result->fetch_assoc());
				$pageRecordInfo = $db->get_page_bar($url);
				$pageBar = $db->record_info();
			}
			$data[$ID] = $DataList;

			// 分類名稱
			if(isset($layoutv3_struct_map_keyname['v3/category_title'][0])){
				$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>$this->data['router_method'].'type',':id'=>$class_id))->queryRow();
				$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = array(
					'name' => $tmp['topic'],
					'sub_name' => $tmp['detail'],
				);
			}
		}

	} else { // 是獨立分類
		// 有用到，在去產品那邊複製就好了
	}

} else {
	//使用分頁列表
	$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
	$qryField = '*';
	$qryWhere = ' WHERE is_enable=1 and  type=\''.$this->data['router_method'].'\' and ml_key=\''.$this->data['ml_key'].'\'';	

	$qryWhere .=' order by sort_id';

	$db->getData($qryField, $qryWhere, (int)$limit_count);
	if($db->total_row > 0) {
		$DataCount = $db->total_row;
		do{
			if($db->row['update_time'] == '0000-00-00 00:00:00'){
				$db->row['update_time'] = '';
			} else {
				$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
			}
			$db->row['name'] = $db->row['topic'];
			$db->row['content'] = $db->row['detail'];
			$DataList[] = $db->row;
		}while($db->row = $db->result->fetch_assoc());
		$pageRecordInfo = $db->get_page_bar($url);
		$pageBar = $db->record_info();
	}
	$data[$ID] = $DataList;
}

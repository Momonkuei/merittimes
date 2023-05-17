<?php
//var_dump($data[$ID]);

$pagew = 0;
if(isset($_GET['page']) and $_GET['page'] > 0){
	$pagew = $_GET['page'];
}

$prefix = 'shop';

// 先把所有規格的session給清掉
unset($_SESSION['save'][$prefix.'_spec']);

// 底下的規格，將只採用分散的寫法(自動組合)
// $contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst($prefix).'specController.php');
// $contentx = str_replace('<'.'?'.'php', '', $contentx);
// $contentx = str_replace('extends Controller', '', $contentx);
// $contentx = str_replace('protected $def', 'static public $def', $contentx);
// $contentx = str_replace('$tmps = explode(\'/\',__FILE__);', '', $contentx);
// $contentx = str_replace('$filename = str_replace(\'.php\',\'\',$tmps[count($tmps)-1]);', '', $contentx);
// $contentx = str_replace('eval(\'class \'.$filename.\' extends NonameController {}\');', '', $contentx);
// eval($contentx);
// eval('$admin_def = NonameController::$def;');
// $admin_field = $admin_def['updatefield']['sections'][0]['field'];

$admin_field_router_class = $prefix.'spec'; // str_replace是為了支援編排頁
$admin_field_section_id = 0;

include _BASEPATH.'/../source/system/admin_field_get.php';

$ids = array();
if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
	$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id',array(':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->order('start_date')->queryAll();
	if($rows and !empty($rows)){
		foreach($rows as $k => $v){
			$ids[] = $v['other1'];
		}
	}

	$DataList = array();

	if(!empty($ids)){

		$limit_count = 8;//一頁顯示幾筆
		$_GET['current_page'] = $pagew;
		$pageRecordInfo = array();
		$db = new Mysqleric(array('table'=>$prefix));

		//使用分頁列表
		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 and ml_key=\''.$this->data['ml_key'].'\'';	
		$qryWhere .= ' and id IN ('.implode(',', $ids).') ';
		$qryWhere .= ' and (date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")';

		$qryWhere .=' order by create_time desc';

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				if($db->row['update_time'] == '0000-00-00 00:00:00'){
					$db->row['update_time'] = '';
				} else {
					$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
				}

				$db->row['url1'] = $url_prefix.$prefix.'detail'.$url_suffix.'?id='.$db->row['id'];
				$db->row['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$db->row['id'];

				// 看商品詳細(widget/add_cart_panel.php)
				$db->row['url'] = $url_prefix.$prefix.'detail'.$url_suffix.'?id='.$db->row['id'];

				$db->row['price'] = 0;
				$db->row['price2'] = 0;
				$rowg = $this->cidb->where('is_enable',1)->where('data_id',$db->row['id'])->get('shopspec')->row_array();
				if($rowg and isset($rowg['id'])){
					$db->row['price'] = $rowg['price'];
					$db->row['price2'] = $rowg['price2'];
				}

				$db->row['pic'] = '_i/assets/upload/'.$prefix.'/'.$db->row['pic1'];

				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}
	}
	$data[$ID] = $DataList;
} else {
	// var_dump($_SESSION['save'][$prefix.'_favorite']);
	if(isset($_SESSION['save'][$prefix.'_favorite']) and !empty($_SESSION['save'][$prefix.'_favorite'])){
		$ids_tmp = array();
		foreach($_SESSION['save'][$prefix.'_favorite'] as $k => $v){
			$ids2 = explode('_', $k);
			//var_dump($ids2);die;

			$id = $ids2[0];
			$specid = $ids2[1];

			//$ids_tmp[] = $ids2[1];

			// 因為會有重覆的資料，所以這裡採用效率最低的方式來取資料，而且不做分頁
			// $item = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':id'=>$id,':ml_key'=>$this->data['ml_key']))->queryRow();
			$item = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$id)->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")')->get($prefix)->row_array();

			if(isset($item)){
				//$item['price'] = '$'.number_format($item['price']);
				//$item['price2'] = '$'.number_format($item['price2']);

				$item['price'] = 0;
				$item['price2'] = 0;
				$rowg = $this->cidb->where('is_enable',1)->where('data_id',$item['id'])->get('shopspec')->row_array();
				if($rowg and isset($rowg['id'])){
					$item['price'] = $rowg['price'];
					$item['price2'] = $rowg['price2'];
				}

				$item['pic'] = '_i/assets/upload/'.$prefix.'/'.$item['pic1'];
				$item['url1'] = $url_prefix.$prefix.'detail'.$url_suffix.'?id='.$item['id'];
				$item['url2'] = $url_prefix.'favorite'.$url_suffix.'?id='.$id.'_'.$specid;

				// 這個是浮起來的選單，裡面的產品詳細的連結
				$item['url'] = $item['url1'];


				if($specid > 0){
					$item['specid'] = $specid;
					//echo $specid;die;
				}

				// 這裡要處理規格，請複製產品內頁的程式碼
				$item['specs'] = array();
				if($specid > 0){

					// 檢查庫存
					//$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and specid=:specid', array(':id'=>$item['id'],':specid'=>$specid))->queryRow();
					$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and id=:specid', array(':id'=>$item['id'],':specid'=>$specid))->queryRow();
					$item['inventory'] = $row['inventory'];
					if($row['inventory'] <= 0){
						$item['inventory'] = 0;
					} 

					$search_data = array(
						':type' => $prefix.'spec',
						':ml_key' => $this->data['ml_key'],
						':id' => $specid,
					);
					$row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',$search_data)->queryRow();
					// $attrs_tmp = array();
					//var_dump($row_tmp);die;
					if($row_tmp and isset($row_tmp['id'])){
						$tmps = array();
						$v = $row_tmp;
						for($x=0;$x<=3;$x++){
							if($v['other'.($x+1)] != ''){
								$tmp = array(
									'name' => $admin_field['other'.($x+1)]['other']['html_end'],
									'value' => $v['other'.($x+1)],
									//'pic' => '_i/assets/upload/'.$prefix.'spec/'.$v['pic1'],
								);

								// 這邊就看需求，這裡預設第一個規格屬性才有圖片
								// 也可以改成只有圖片沒有規格屬性
								if($x == 0){
									$tmp['pic'] = '_i/assets/upload/'.$prefix.'spec/'.$v['pic1'];
								}
								$tmps[] = $tmp;
							}
						}


						// 請手動透過更換spec檔案名稱來達成
						if($tmps and !empty($tmps)){
							foreach($tmps as $k => $v){
								$item['specs'][$k] = $v;
								//$data[$layoutv3_struct_map_keyname['v3/shop/spec'.($k+1)][0]] = $v;
							}
						}
					} // atrs_tmp
				}
				//var_dump($item['specs']);

				$data[$ID][] = $item;
				//var_dump($data[$layoutv3_struct_map_keyname['v3/widget/add_cart_panel'][0]]);
				//die;


			} // item isset
		}

	}


}

// 這個是因為加進來的收藏，可能是沒有規格編號的
// 那種沒有規格編號的，才需要浮現出規格的區塊讓人選擇
if(isset($data[$ID]) and !empty($data[$ID])){
	$items2 = $data[$ID];

	// 目前有跟source/shop/list.php和首頁的共用
	include _BASEPATH.'/../source/shop/spec_float_include.php';
}

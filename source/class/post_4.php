<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']==1){
	echo "<script>alert('代表窗口請至總覽頁面操作');window.location.href='/apply_".$this->data['ml_key']."_4.php';</script>";
}
//班級資料
//填寫計畫頁面
$class_data=$this->cidb->where('id',$_SESSION['member_data']['class_id'])->get('writeplan_class')->row_array();

//檔案上傳-資料夾判斷
$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
//檔案上傳-路徑
$data_path='/_i/assets/upload/class/'.$school.'/'.$_SESSION['member_data']['class_id'];

//分頁設定
$limit_count = 12;//單頁數量
$pagew = 1; // 頁數
if (isset($_GET['page']) and $_GET['page'] > 0) {
	$pagew = $_GET['page'];
}
//全部
$vido_data_all=$this->cidb->where('class_id',$_SESSION['member_data']['class_id'])->where('ml_key',$this->data['ml_key']);
if(!empty($_GET)){
	if(!empty($_GET['start_date'])){
		$vido_data_all=$vido_data_all->where("DATE_FORMAT(create_time,'%Y-%m-%d') >=",$_GET['start_date']);
	}
	if(!empty($_GET['end_date'])){
		$vido_data_all=$vido_data_all->where("DATE_FORMAT(create_time,'%Y-%m-%d') <=",$_GET['end_date']);
	}
	if(!empty($_GET['keyword'])){
		$vido_data_all=$vido_data_all->where("(name like '%".$_GET['keyword']."%' or detail like '%".$_GET['keyword']."%' or field_data like '%".$_GET['keyword']."%' or field_tmp like '%".$_GET['keyword']."%') ");
	}
}
$vido_data_all=$vido_data_all->order_by('create_time desc')->get('class_vido')->result_array();
$total_rows = count($vido_data_all);
//單頁
$vido_data=$this->cidb->where('class_id',$_SESSION['member_data']['class_id'])->where('ml_key',$this->data['ml_key']);
if(!empty($_GET)){
	if(!empty($_GET['start_date'])){
		$vido_data=$vido_data->where("DATE_FORMAT(create_time,'%Y-%m-%d') >=",$_GET['start_date']);
	}
	if(!empty($_GET['end_date'])){
		$vido_data=$vido_data->where("DATE_FORMAT(create_time,'%Y-%m-%d') <=",$_GET['end_date']);
	}
	if(!empty($_GET['keyword'])){
		$vido_data=$vido_data->where("(name like '%".$_GET['keyword']."%' or detail like '%".$_GET['keyword']."%' or field_data like '%".$_GET['keyword']."%' or field_tmp like '%".$_GET['keyword']."%') ");
	}
}
$vido_data=$vido_data->order_by('create_time desc')->get('class_vido', $limit_count, ($pagew - 1) * $limit_count)->result_array();;
if(isset($_GET) and !empty($_GET)){
	$search='';
	if(!empty($_GET['start_date'])){
		$search.='?start_date='.$_GET['start_date'];
	}
	if(!empty($_GET['end_date'])){
		if(!empty($search)){
			$search.='&end_date='.$_GET['end_date'];
		}else{
			$search.='?end_date='.$_GET['end_date'];
		}
	}
	if(!empty($_GET['keyword'])){
		if(!empty($search)){
			$search.='&keyword='.$_GET['keyword'];
		}else{
			$search.='?keyword='.$_GET['keyword'];
		}
	}
	$url = 'class_'.$this->data['ml_key'].'_4.php'.(!empty($search)?$search.'&':'?').'page=';
}else{
	$url = 'class_'.$this->data['ml_key'].'_4.php?page=';
}
include _BASEPATH . '/../source/core/pagination.php';
if(!empty($account_data)){
	foreach($account_data as $k => $v){
		$account_data[$k]['other7']=explode(',',$v['other7']);
	}
}
?>


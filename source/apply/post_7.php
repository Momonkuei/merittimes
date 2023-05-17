<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']!=1){
	echo "<script>alert('師生成員請至班級頁面操作');window.location.href='/class_".$this->data['ml_key']."_1.php';</script>";
}

//計畫資料
$writeplan_array=$this->cidb->where('member_id',$_SESSION['member_data']['id'])->where('is_enable',1)->order_by('create_time desc')->get('writeplan')->result_array();
//學期資料
$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->order_by('sort_id')->get('html')->result_array();
if(!empty($semester_array)){
	foreach($semester_array as $k => $v){
		$semester[$v['id']]=$v['topic'];
	}
}
$class_data=$this->cidb->where('is_enable',1)->order_by('create_time desc')->get('writeplan_class')->result_array();
if(!empty($class_data)){
	foreach($class_data as $k => $v){
		$class_data[$v['id']]=$v['class_name'];
	}
}
//班級資料
$writeplan_class_array=array();
$a=0;
foreach($writeplan_array as $k => $v){
	if($v['a_results']=='核可'){
		$writeplan_class=$this->cidb->like('writeplan_id',','.$v['id'].',')->like('other7',','.$v['semester'].',')->where('is_enable',1)->order_by('sort_id')->get('writeplan_class')->result_array();
		if(!empty($writeplan_class)){
			foreach($writeplan_class as $kk => $vv){
				$writeplan_class_array[$a]=$vv;
				$writeplan_class_array[$a]['semester_name']=$semester[$v['semester']];
				$a++;
			}
		}
	}
}

//分頁設定
$limit_count = 15;//單頁數量
$pagew = 1; // 頁數
$serach='';
if (isset($_GET['page']) and $_GET['page'] > 0) {
	$pagew = $_GET['page'];
}
if(!empty($_GET['cars'])){
	$serach=" and a.other7 like '%,".$_GET['cars'].",%' ";
}
$sql_all="select DISTINCT a.* from writeplan_class as a 
		LEFT JOIN writeplan as c 
			on c.a_results='核可' 
		where LOCATE(c.id, a.writeplan_id) and a.represent_id='".$_SESSION['member_data']['id']."' and a.is_enable=1 $serach
		order by create_time desc,id desc";
$rs_all=$this->cidb->query($sql_all);		
// LOCATE(c.id, a.writeplan_id) 
//帳號資料
//全部
$total_rows = $rs_all->num_rows();

//單頁
$sql="select DISTINCT a.* from writeplan_class as a 
		where  a.represent_id='".$_SESSION['member_data']['id']."' and a.is_enable=1 $serach
		order by create_time desc,id desc limit ".($pagew - 1) * $limit_count.",".$limit_count;
$rs = $this->cidb->query($sql);
$account_data=$rs->result_array();
if(isset($_GET['search']) and $_GET['search'] != ''){
	$url = 'apply_'.$this->data['ml_key'].'_7.php?search=' . $_GET['search'] . '&page=';
}else{
	$url = 'apply_'.$this->data['ml_key'].'_7.php?page=';
}

include _BASEPATH . '/../source/core/pagination.php';
if(!empty($account_data)){
	foreach($account_data as $k => $v){
		$writeplan_id=explode(',',trim(rtrim($v['writeplan_id'], ","),",")); 
		$a=0;
		
		$is_a_results=array();
		foreach($writeplan_id as $kk => $vv){
			
			$writeplan_data=$this->cidb->where('id',$vv);
			if(!empty($_GET['cars'])){
				$writeplan_data=$writeplan_data->where('semester',$_GET['cars']);
			}
			$writeplan_data=$writeplan_data->get('writeplan')->row_array();
			if($writeplan_data['a_results']=='核可'){
				$is_a_results[$a]=$writeplan_data['semester'];
				$a++;
			}
			
		}
		
		$other3=$this->cidb->where('other6',$v['id'])->limit('1')->get('customer')->row_array();
		if(!empty($other3)){
			$account_data[$k]['other3']=$other3['other3'];
		}
		
		if(empty($v['pic1']) && empty($v['pic_name']) && empty($v['pic_description']) && empty($v['description'])){
			$account_data[$k]['no_data']=1;
		}
		
		$account_data[$k]['other7']=$is_a_results;
		
		if(empty($is_a_results)){
			unset($account_data[$k]);
		}
	}
	
	$account_data =array_values($account_data);
	
}
?>


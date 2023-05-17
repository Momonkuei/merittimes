<?php

//分頁設定
$limit_count = 15;//單頁數量
$pagew = 1; // 頁數
$serach='';
if (isset($_GET['page']) and $_GET['page'] > 0) {
	$pagew = $_GET['page'];
}
//全部
$class_list_o=$this->cidb->select('a.*,b.code')->from('writeplan_class as a')->where('a.is_enable',1);

$class_list_o->group_start();
$class_list_o->where('a.pic_description!=""');
$class_list_o->or_where('a.pic_name!=""');
$class_list_o->or_where('a.pic1!=""');
$class_list_o->or_where('a.description!=""');
$class_list_o->group_end();
if(!empty($_GET)){
	if(!empty($_GET['school'])){
		$class_list_o=$class_list_o->where('a.represent_id',$_GET['school']);
	}
	if(!empty($_GET['cars'])){
		$class_list_o=$class_list_o->like('a.other7',$_GET['cars']);
	}
	if(!empty($_GET['class_name'])){
		$class_list_o=$class_list_o->like('a.class_name',$_GET['class_name']);
	}
	if(!empty($_GET['teacher_name'])){
		$class_list_o=$class_list_o->like('a.teacher_name',$_GET['teacher_name']);
	}
}
$class_list_o->join('customer as b', 'a.represent_id = b.id', 'left');
$class_list_o=$class_list_o->order_by('a.create_time desc')->get();
$total_rows = $class_list_o->num_rows();

//單頁
$class_list_o=$this->cidb->select('a.*,b.code')->from('writeplan_class as a')->where('a.is_enable',1);

$class_list_o->group_start();
$class_list_o->where('a.pic_description!=""');
$class_list_o->or_where('a.pic_name!=""');
$class_list_o->or_where('a.pic1!=""');
$class_list_o->or_where('a.description!=""');
$class_list_o->group_end();
if(!empty($_GET)){
	if(!empty($_GET['school'])){
		$class_list_o=$class_list_o->where('a.represent_id',$_GET['school']);
	}
	if(!empty($_GET['cars'])){
		$class_list_o=$class_list_o->like('a.other7',$_GET['cars']);
	}
	if(!empty($_GET['class_name'])){
		$class_list_o=$class_list_o->like('a.class_name',$_GET['class_name']);
	}
	if(!empty($_GET['teacher_name'])){
		$class_list_o=$class_list_o->like('a.teacher_name',$_GET['teacher_name']);
	}
}
$class_list_o->join('customer as b', 'a.represent_id = b.id', 'left');
$class_list_o=$class_list_o->order_by('a.create_time desc')->get('', $limit_count, ($pagew - 1) * $limit_count)->result_array();
//分頁用
if(isset($_GET) and !empty($_GET)){
	$search='';
	if(!empty($_GET['school'])){
		$search.='?school='.$_GET['school'];
	}
	if(!empty($_GET['cars'])){
		if(!empty($search)){
			$search.='&cars='.$_GET['cars'];
		}else{
			$search.='?cars='.$_GET['cars'];
		}
	}
	if(!empty($_GET['class_name'])){
		if(!empty($search)){
			$search.='&class_name='.$_GET['class_name'];
		}else{
			$search.='?class_name='.$_GET['class_name'];
		}
	}
	if(!empty($_GET['teacher_name'])){
		if(!empty($search)){
			$search.='&teacher_name='.$_GET['teacher_name'];
		}else{
			$search.='?teacher_name='.$_GET['teacher_name'];
		}
	}
	$url = 'classachievement_'.$this->data['ml_key'].'.php'.(!empty($search)?$search.'&':'?').'page=';
}else{
	$url = 'classachievement_'.$this->data['ml_key'].'.php?page=';
}
include _BASEPATH . '/../source/core/pagination.php';

$class_list=array();
$a=0;
//
foreach($class_list_o as $k => $v){
	if(!empty($v['description']) || !empty($v['pic1']) || !empty($v['pic_name']) || !empty($v['pic_description'])){
		$v['writeplan_id']=ltrim(rtrim($v['writeplan_id'], ","),","); 
		$writeplan_id=explode(',',$v['writeplan_id']);
		$have_approved=false;
		foreach($writeplan_id as $kk => $vv){
			$writeplan_data=$this->cidb->where('id',$vv)->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get('writeplan')->row_array();
			if(!empty($writeplan_data) && $writeplan_data['a_results']=='核可'){
				$have_approved=true;
			}
		}
		if($have_approved==true){
			$class_list[$a]=$v;
			$a++;
		}
	}

}

//圖片路徑
$data_path='_i/assets/upload/class/';

//學校名稱列表
$customer_data=$this->cidb->where('is_enable',1)->where('member_grade',1)->order_by('create_time desc')->get('customer')->result_array();
if(!empty($customer_data)){
	foreach($customer_data as $k => $v){
		$have_class=$this->cidb->where('represent_id',$v['id'])->get('writeplan_class')->result_array();
		$have_other_account=$this->cidb->where('class_id',$v['id'])->get('customer')->row_array();
		if(!empty($have_other_account)){
			foreach($have_class as $kk => $vv){
				if((!empty($vv['description']) || !empty($vv['pic1']) || !empty($vv['pic_name']) || !empty($vv['pic_description']))){
					$school_list[$v['id']]=$v['school_name'];
				}
			}
		}
	}
}
//學期資料
$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->order_by('sort_id')->get('html')->result_array();
if(!empty($semester_array)){
	foreach($semester_array as $k => $v){
		$semester_list[$v['id']]=$v['topic'];
	}
}

?>

